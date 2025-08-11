<?php

require_once "../../plugins/PHPExcel/IOFactory.php";
require_once "../../plugins/PHPExcel.php";

class ControladorEncuestasProfesional{

    static public function ctrEliminarCalificacionesSegmentosRespuestas($idEncuesta, $idEncuProceso){
        
        // $eliminarCaliProceso = ModelEncuestas::mdlEliminarCalificacionProceso($idEncuesta, $idEncuProceso);
        $eliminarCaliProcesoSegmento = ModelEncuestasProfesional::mdlEliminarCalificacionProcesoSegmento($idEncuesta, $idEncuProceso);
        $eliminarRespuestas = ModelEncuestasProfesional::mdlEliminarRespuestas($idEncuesta, $idEncuProceso);

        if($eliminarCaliProcesoSegmento == 'ok' && $eliminarRespuestas == 'ok'){

            return 'ok';

        }else{

            return 'error';

        }

    }

    static public function ctrListaPreguntasSegmentosEncuestaRespuesta($idEncuesta, $idEncuSegmento){

        $respuesta = ModelEncuestasProfesional::mdlListaPreguntasSegmentosEncuestaRespuesta($idEncuesta, $idEncuSegmento);

        if(empty($respuesta)){

            $respuesta = ModelEncuestasProfesional::mdlListaPreguntasSegmentosEncuesta($idEncuSegmento);

        }

        return $respuesta;

    }

    static public function ctrListaEncuestasBolsaTerminadasProfesional($especialidad, $user){

        $respuesta = ModelEncuestasProfesional::mdlListaEncuestasBolsaTerminadasProfesional($especialidad, $user);

        return $respuesta;

    }

    static public function ctrListaBolsasTerminadasEncuestasProfesional($user){

        $respuesta = ModelEncuestasProfesional::mdlListaBolsasTerminadasEncuestasProfesional($user);

        return $respuesta;

    }

    static public function ctrListaEncuestasBolsaPendientesProfesional($especialidad, $user){

        $respuesta = ModelEncuestasProfesional::mdlListaEncuestasBolsaPendientesProfesional($especialidad, $user);

        return $respuesta;

    }

    static public function ctrListaBolsasPendientesEncuestasProfesional($user){

        $respuesta = ModelEncuestasProfesional::mdlListaBolsasPendientesEncuestasProfesional($user);

        return $respuesta;

    }

    static public function ctrTerminarEncuesta($idEncuesta){

        $tabla = "encuestas_encuestas_procesos_profesional";

        $datos = array(

            "id_encuesta" => $idEncuesta,
            "fecha_fin" => date("Y-m-d H:i:s"),
            "estado" => "FINALIZADA"

        );

        $respuesta = ModelEncuestasProfesional::mdlTerminarEncuesta($tabla, $datos);

        return $respuesta;

    }

    static public function ctrObtenerCalificacionesEncuesta($idEncuesta){

        $tabla = "encuestas_encuestas_procesos_gestion_profesional";

        $respuesta = ModelEncuestasProfesional::mdlObtenerCalificacionesEncuesta($tabla, $idEncuesta);

        return $respuesta;

    }

    static public function ctrValidacionTerminarEncuesta($idEncuesta){

        $tabla = "encuestas_encuestas_procesos_gestion_profesional";

        $respuesta = ModelEncuestasProfesional::mdlValidacionTerminarEncuesta($tabla, $idEncuesta);

        if(!empty($respuesta)){

            return 'encuestas-pendientes';

        }else{

            return 'ok-terminar';
            
        }

    }

    static public function ctrGuardarRespuestasEncuesta($arrayRespuestas, $idEncuProceso, $idEncuesta, $calificacionProceso){

        $tabla = "encuestas_encuestas_respuestas_profesional";

        foreach ($arrayRespuestas as $key => $valueRes) {
        
            $respuesta = ModelEncuestasProfesional::mdlGuardarRespuestasEncuesta($tabla, $valueRes);

            if($respuesta != 'ok'){

                return 'error-save-respuestas';

            }
        
        }

        // $actualizarPaso = ControladorEncuestas::ctrActualizarPaso($idEncuProceso, $idEncuesta);
        $updCalifacionProcesoGestion = ControladorEncuestasProfesional::ctrActualizarCalifacionEncuProcesoGestion($idEncuProceso, $idEncuesta, $calificacionProceso);

        if($updCalifacionProcesoGestion == 'ok'){

            return 'ok';

        }else{

            return 'error-actualizacion';

        }


    }

    static public function ctrActualizarCalifacionEncuProcesoGestion($idEncuProceso, $idEncuesta, $calificacionProceso){

        $tabla = "encuestas_encuestas_procesos_gestion_profesional";

        $respuesta = ModelEncuestasProfesional::mdlActualizarCalifacionEncuProcesoGestion($tabla, $idEncuProceso, $idEncuesta, $calificacionProceso);

        return $respuesta;


    }

    static public function ctrListaPreguntasEncuestaProceso($idEncuProceso){

        $respuesta = ModelEncuestasProfesional::mdlListaPreguntasEncuestaProceso($idEncuProceso);

        return $respuesta;

    }

    static public function ctrGuardarCalificacionSegmento($datos){

        $tabla = "encuestas_encuestas_procesos_gestion_detalle_profesional";

        foreach ($datos as $key => $valueDato){

            $respuesta = ModelEncuestasProfesional::mdlGuardarCalificacionSegmento($tabla, $valueDato);

            if($respuesta != 'ok'){

                return $respuesta;

            }

        }

        return 'ok';

    }

    static public function ctrListaSegmentosProcesoEncuestaPorcentaje($idEncuProceso){

        $respuesta = ModelEncuestasProfesional::mdlListaSegmentosProcesoEncuestaPorcentaje($idEncuProceso);

        return $respuesta;        


    }

    static public function ctrListaSegmentosParaclinicos($especialidad){

        $arraySegmentos = array(
            "MEDICO ESPECIALISTA FAMILIAR" => "3,4",
            "MEDICO GENERAL DOLOR" => "10,11",
            "MEDICO INTERNISTA" => "17,18",
            "MEDICO REUMATOLOGO" => "24,25",
            "MEDICO GENERAL VIH" => "67,68",
            "INFECTOLOGIA" => "75,76",
            "INFECTOPEDIATRIA" => "83,84",
        );

        $respuesta = ModelEncuestasProfesional::mdlListaSegmentosParaclinicos($especialidad, $arraySegmentos[$especialidad]);

        return $respuesta;

    }

    static public function ctrListaPreguntasSegmentosEncuesta($idEncuSegmento){

        $respuesta = ModelEncuestasProfesional::mdlListaPreguntasSegmentosEncuesta($idEncuSegmento);

        return $respuesta;

    }

    static public function ctrListaSegmentosProcesoEncuesta($idEncuProceso){

        $respuesta = ModelEncuestasProfesional::mdlListaSegmentosProcesoEncuesta($idEncuProceso);

        return $respuesta;

    }

    static public function ctrDescartarEncuesta($idEncuesta){

        $tabla = "encuestas_encuestas_procesos_profesional";

        $hoy = date("Y-m-d H:i:s");

        $respuesta = ModelEncuestasProfesional::mdlDescartarEncuesta($tabla, $idEncuesta, $hoy);

        return $respuesta;

    }

    static public function ctrObtenerProcesosGestionEncuesta($idEncuesta){

        $respuesta = ModelEncuestasProfesional::mdlObtenerProcesosGestionEncuesta($idEncuesta);

        return $respuesta;

    }

    static public function ctrGuardarInfoAuditoriaEncuesta($datos){

        $datos["fecha_edita"] = date("Y-m-d H:i:s");

        $respuesta = ModelEncuestasProfesional::mdlGuardarInfoAuditoriaEncuesta($datos);

        return $respuesta;

    }

    static public function ctrMostrarInformacionEncuesta($idEncuesta){

        $respuesta = ModelEncuestasProfesional::mdlMostrarInformacionEncuesta($idEncuesta);

        return $respuesta;

    }

    static public function ctrTomarEncuestaProfesional($datos){

        $infoBase = ControladorEncuestasProfesional::ctrValidacionBolsaEncuesta($datos["id_base_encu"]);
        
        if($infoBase["cantidad"] < $infoBase["muestra"]){

            $encuestasUser = ControladorEncuestasProfesional::ctrListaEncuestasPendienteUser($datos["auditor"]);

            $tablaCantidad = "par_variables_globales";
            $itemCantidad = "variable";
            $valorCantidad = "CANTIDAD_PENDIENTES_ENCUESTAS_PROFESIONAL";

            $datosCantidades = ControladorEncuestasProfesional::ctrObtenerDato($tablaCantidad, $itemCantidad, $valorCantidad);

            if(count($encuestasUser) < $datosCantidades["valor"]){

                $data = ControladorEncuestasProfesional::ctrObtenerEncuesta($datos["id_encuesta"]);

                if(empty($data["auditor"]) && $data["estado"] == 'CREADA'){

                    $hoy = date("Y-m-d H:i:s");

                    $asignarEncuesta = ModelEncuestasProfesional::mdlAsignarEncuesta($datos["id_encuesta"], $datos["auditor"], $hoy);
                    
                    if($asignarEncuesta == 'ok'){

                        $crearEncuProcesosGestion = ControladorEncuestasProfesional::ctrCrearProcesosInicialesGestion($datos["id_encuesta"], $datos["auditor"], $datos["especialidad"], $datos["nombre_auditor"]);

                        if($crearEncuProcesosGestion == 'ok'){

                            return array (
                                
                                "estado" => "ok-asignado"
                            
                            );

                        }else{

                            return array (
                                
                                "estado" => "error-creando-procesos"
                            
                            );

                        }


                    }else{

                        return array (
                                
                            "estado" => "error-asignando"
                        
                        );

                    }

                }else if(!empty($data["auditor"]) && $data["estado"] != 'CREADA'){

                    return array (
                                
                        "estado" => "ok-ya-asignado"
                    
                    );

                }

            }else{

                return array (
                                
                    "estado" => "error-capacidad-superada"
                
                );

            }

        }else{

            $muestraCumplida = ControladorEncuestasProfesional::ctrObtenerEncuestasTerminadasBase($datos["id_base_encu"]);

            if($muestraCumplida["cantidad_finalizadas"] >= $infoBase["muestra"]){

                //CERRAMOS TODOS LOS CASOS EN OTROS ESTADOS DIFERENTES A FINALIZADA
                $cerrarEncuestas = ControladorEncuestasProfesional::ctrActualizarEncuestasNoAplicadaBase($datos["id_base_encu"]);

                if($cerrarEncuestas == "ok"){

                    $estadoBase = ControladorEncuestasProfesional::ctrActualizarEstadoBase($datos["id_base_encu"]);

                }

                return array (
                            
                    "estado" => "muestra-cumplida"
                
                );

            }else{

                return array (
                                
                    "estado" => "pendiente-cierre-muestra"
                
                );


            }

        }

    }

    static public function ctrActualizarEstadoBase($idBaseEncuesta){

        $respuesta = ModelEncuestasProfesional::mdlActualizarEstadoBase($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrActualizarEncuestasNoAplicadaBase($idBaseEncuesta){

        $respuesta = ModelEncuestasProfesional::mdlActualizarEncuestasNoAplicadaBase($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrObtenerEncuestasTerminadasBase($idBaseEncuesta){

        $respuesta = ModelEncuestasProfesional::mdlObtenerEncuestasTerminadasBase($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrCrearProcesosInicialesGestion($idEncuesta, $auditor, $especialidad, $nombreUser){

        $tabla = "encuestas_encuestas_procesos_gestion_profesional";

        $procesos = ControladorEncuestasProfesional::ctrObtenerProcesosInicialesEncuesta($especialidad);

        foreach ($procesos as $key => $valueProceso) {

            $datos = array(
                "id_encuesta" => $idEncuesta,
                "id_encu_proceso" => $valueProceso["id_encu_proceso"],
                "proceso" => $valueProceso["proceso"],
                "nombre_usuario" => strtoupper($nombreUser),
                "usuario_crea" => $auditor
            );

            $crear = ModelEncuestasProfesional::mdlCrearProcesosInicialesGestion($tabla, $datos);

            if($crear != 'ok'){

                return 'error';

            }

        }

        return 'ok';

    }

    static public function ctrObtenerProcesosInicialesEncuesta($especialidad){

        $respuesta = ModelEncuestasProfesional::mdlObtenerProcesosInicialesEncuesta($especialidad);

        return $respuesta;

    }


    static public function ctrObtenerEncuesta($idEncuesta){

        $respuesta = ModelEncuestasProfesional::mdlObtenerEncuesta($idEncuesta);

        return $respuesta;

    }

    static public function ctrListaEncuestasPendienteUser($user){

        $respuesta = ModelEncuestasProfesional::mdlListaEncuestasPendienteUser($user);

        return $respuesta;

    }

    static public function ctrValidacionBolsaEncuesta($idBaseEncuesta){

        $respuesta = ModelEncuestasProfesional::mdlValidacionBolsaEncuesta($idBaseEncuesta);

        return $respuesta;

    }


    static public function ctrListaEncuestasBolsaProfesional($user, $especialidad){

        $tabla = "encuestas_encuestas_procesos_profesional";

        $idEncuesta = ControladorEncuestasProfesional::ctrObtenerIdEncuestaAleatoriaAuditorProfesional($especialidad, $user);

        if(!empty($idEncuesta)){

            $respuesta = ModelEncuestasProfesional::mdlObtenerInfoEncuesta($especialidad, $user, $idEncuesta["id_encuesta"]);

        }else{

            $respuesta = [];

        }

        return $respuesta;

    }

    static public function ctrObtenerIdEncuestaAleatoriaAuditorProfesional($especialidad, $user){

        $arrayEncuestas = ModelEncuestasProfesional::mdlObtenerIdEncuestasAuditorProfesional($especialidad, $user);

        $idsEncuestas = [];

        foreach ($arrayEncuestas as $key => $value) {

            $idsEncuestas[] = $value["id_encuesta"];

        }

        if(!empty($arrayEncuestas)){

            $indiceEncuesta = array_rand($idsEncuestas);
            
            return $arrayEncuestas[$indiceEncuesta];
        }
        
        return [];

        
    }

    static public function ctrListaBolsasEncuestasProfesional($user){

        $respuesta = ModelEncuestasProfesional::mdlListaBolsasEncuestasProfesional($user);

        return $respuesta;

    }

    static public function ctrListaEspecialidades($especialidad){

        $tabla = "encuestas_par_especialidades_profesional";

        $respuesta = ModelEncuestasProfesional::mdlListaEspecialidades($tabla, $especialidad);

        return $respuesta;

    }

    static public function ctrObtenerArchivoCargar(){

        $tabla = "encuestas_bases_encuestas_profesional";

        $respuesta = ModelEncuestasProfesional::mdlObtenerArchivoCargar($tabla);

        return $respuesta;

    }

    static public function ctrListaBasesEncuestas(){

        $tabla = "encuestas_bases_encuestas_profesional";

        $respuesta = ModelEncuestasProfesional::mdlListaBasesEncuestas($tabla);

        return $respuesta;

    }

    static public function ctrCargarArchivoEncuestas($datos){

        if(!empty($datos)){

            $Now = date('YmdHis');
			$ruta = "../../../archivos_nexuslink/encuestas/archivos_bases_encuestas_profesional/";
			$rutaErrores = "../../../archivos_nexuslink/encuestas/archivos_bases_encuestas_profesional/errores/";
			$nombreOriginal = $datos["archivo"]["name"];
			$nombreArchivo = $Now.$nombreOriginal;
			$rutaFin = $ruta.$nombreArchivo;
			$rutaFinErros = $rutaErrores.$nombreArchivo.".txt";

            move_uploaded_file ($datos["archivo"]["tmp_name"], $rutaFin);

            $objPHPExcel = PHPEXCEL_IOFactory::load($rutaFin);
            $objPHPExcel->setActiveSheetIndex(0);
            $NumColum = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
            $NumFilas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

            if($NumColum == 'J'){

                $tabla = "encuestas_bases_encuestas_profesional";

                /*==================================
                CALCULANDO VALOR DE LA MUESTRA
                ===================================*/
                // $nivelConfianza = $datos["nivel_confianza"] / 100;
                $margenError = $datos["margen_error"] / 100;

                $nivelConfianza = array(
                    "80" => 1.2816,
                    "85" => 1.4408,
                    "90" => 1.6449,
                    "95" => 1.9599,
                    "99" => 2.5758
                );

                
                
                $N = $NumFilas - 1;
                $Z = $nivelConfianza[$datos["nivel_confianza"]];      // Nivel de confianza
                $p = 0.5;       // Proporción esperada
                $E = $margenError;      // Margen de error

                // $muestra = round(($N * pow($Z, 2) * $p * (1- $p)) / (($N - 1) * pow($E, 2) + pow($Z, 2) * $p * (1 - $p)));

                $muestra = round($N/(1+(($E * $E) * ($N - 1))/($Z * $Z * $p * $p)));

                if($N < 50){

                    $muestra = $N;

                }else{

                    $muestra = $muestra;

                }


                $datosEncuestas = array(
                    "nombre" => mb_strtoupper($datos["nombre_archivo"]),
                    "nombre_archivo_original" => $nombreOriginal,
                    "especialidad" => mb_strtoupper($datos["especialidad"]),
                    "nombre_archivo" => $nombreArchivo,
                    "ruta_archivo" => $rutaFin,
                    "cantidad" => $N,
                    "nivel_confianza" => $Z,
                    "margen_error" => $margenError,
                    "muestra" => $muestra,
                    "auditor" => $datos["auditor"],
                    "estado" => "SUBIDA",
                    "usuario" => $datos["usuario"]
                );

                $guardarArchivo = ModelEncuestasProfesional::mdlGuardarArchivoEncuestas($tabla, $datosEncuestas);

                if($guardarArchivo == 'ok'){

                    return 'ok';

                }else{

                    return $guardarArchivo;

                }

            }else{

                $archivoError = fopen("../../../archivos_nexuslink/encuestas/archivos_bases_encuestas_profesional/errores/" . $nombreArchivo . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

                fwrite($archivoError, $nombreArchivo . "\n");
                fwrite($archivoError, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
                fwrite($archivoError, "Validacion Cargue Base Encuestas\n");
                fwrite($archivoError, "El archivo no posee la estructura adecuada de 10 columnas (J)\n");
                fwrite($archivoError, "------------------------ Fin Validacion-------------------------------------\n");

                return 'error-estructura';

            }


        }

    }

    static public function ctrObtenerDato($tabla, $item, $valor){

        $respuesta = ModelEncuestasProfesional::mdlObtenerDato($tabla, $item, $valor);

        return $respuesta;

    }


}
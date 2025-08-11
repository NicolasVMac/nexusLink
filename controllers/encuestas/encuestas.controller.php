<?php

require_once "../../plugins/PHPExcel/IOFactory.php";
require_once "../../plugins/PHPExcel.php";

class ControladorEncuestas{

    static public function ctrListaSegmentosProcesoEncuestaPorcentaje($idEncuProceso){

        $respuesta = ModelEncuestas::mdlListaSegmentosProcesoEncuestaPorcentaje($idEncuProceso);

        return $respuesta;        


    }

    static public function ctrEliminarCalificacionesSegmentosRespuestas($idEncuesta, $idEncuProceso){
        
        // $eliminarCaliProceso = ModelEncuestas::mdlEliminarCalificacionProceso($idEncuesta, $idEncuProceso);
        $eliminarCaliProcesoSegmento = ModelEncuestas::mdlEliminarCalificacionProcesoSegmento($idEncuesta, $idEncuProceso);
        $eliminarRespuestas = ModelEncuestas::mdlEliminarRespuestas($idEncuesta, $idEncuProceso);

        if($eliminarCaliProcesoSegmento == 'ok' && $eliminarRespuestas == 'ok'){

            return 'ok';

        }else{

            return 'error';

        }

    }

    static public function ctrListaEncuestasBolsaTerminadas($tipoEncuesta, $user){

        $respuesta = ModelEncuestas::mdlListaEncuestasBolsaTerminadas($tipoEncuesta, $user);

        return $respuesta;

    }

    static public function ctrGuardarInfoAuditoriaEncuesta($datos){

        $datos["fecha_edita"] = date("Y-m-d H:i:s");

        $respuesta = ModelEncuestas::mdlGuardarInfoAuditoriaEncuesta($datos);

        return $respuesta;

    }

    static public function ctrListaAuditoresEncuesta($tipoEncuesta){

        $respuesta = ModelEncuestas::mdlListaAuditoresEncuesta($tipoEncuesta);

        return $respuesta;

    }

    static public function ctrSelectAuditoresProceso($procesoProfesional, $tipoEncuesta){

        $respuesta = ModelEncuestas::mdlSelectAuditoresProceso($procesoProfesional, $tipoEncuesta);

        return $respuesta;

    }

    static public function ctrEliminarUsuarioProfesional($idProUsu, $userDelete){

        $tabla = "encuestas_profesionales_usuarios";

        $datos = array(
            "id_pro_usu" => $idProUsu,
            "usuario_elimina" => $userDelete,
            "fecha_elimina" => date("Y-m-d H:i:s")
        );

        $respuesta = ModelEncuestas::mdlEliminarUsuarioProfesional($tabla, $datos);

        return $respuesta;

    }

    static public function ctrListaUsuariosProfesionales(){
        
        $respuesta = ModelEncuestas::mdlListaUsuariosProfesionales();

        return $respuesta;

    }

    static public function ctrAgregarUsuarioProfesional($datos){

        $isExist = ModelEncuestas::mdlValidarExisteUsuarioProfesional($datos);

        $infoProceso = ModelEncuestas::mdlObtenerDato("encuestas_procesos", "id_encu_proceso", $datos["id_encu_proceso"]);

        if(empty($isExist)){

            $respuesta = ModelEncuestas::mdlAgregarUsuarioProfesional($datos, $infoProceso["proceso"]);
            
            return $respuesta;
        
        }else{

            return 'usu-pro-existe';

        }


    }

    static public function ctrListaSegmentosParaclinicos($tipoEncuesta){

        if($tipoEncuesta == 'AUTOINMUNES'){

            $segmentos = '4,123';

        }else{

            $segmentos = '59,124';

        }

        $respuesta = ModelEncuestas::mdlListaSegmentosParaclinicos($tipoEncuesta, $segmentos);

        return $respuesta;

    }

    static public function ctrGuardarCalificacionSegmento($datos){

        $tabla = "encuestas_encuestas_procesos_gestion_detalle";

        foreach ($datos as $key => $valueDato){

            $respuesta = ModelEncuestas::mdlGuardarCalificacionSegmento($tabla, $valueDato);

            if($respuesta != 'ok'){

                return $respuesta;

            }

        }

        return 'ok';

    }

    static public function ctrObtenerCalificacionesEncuesta($idEncuesta){

        $tabla = "encuestas_encuestas_procesos_gestion";

        $respuesta = ModelEncuestas::mdlObtenerCalificacionesEncuesta($tabla, $idEncuesta);

        return $respuesta;

    }
    
    static public function ctrValidacionTerminarEncuesta($idEncuesta){

        $tabla = "encuestas_encuestas_procesos_gestion";

        $respuesta = ModelEncuestas::mdlValidacionTerminarEncuesta($tabla, $idEncuesta);

        if(!empty($respuesta)){

            return 'encuestas-pendientes';

        }else{

            return 'ok-terminar';
            
        }

    }

    static public function ctrEliminarProfesionalModificacion($idEncuProcesoGestion, $idEncuProceso, $idEncuesta){

        $eliminar = ModelEncuestas::mdlEliminarProfesional($idEncuProcesoGestion);

        if($eliminar == 'ok'){

            $eliminarCaliProcesoSegmento = ModelEncuestas::mdlEliminarCalificacionProcesoSegmento($idEncuesta, $idEncuProceso);
            $eliminarRespuestas = ModelEncuestas::mdlEliminarRespuestas($idEncuesta, $idEncuProceso);

            if($eliminarCaliProcesoSegmento == 'ok' && $eliminarRespuestas == 'ok'){

                return 'ok';

            }else{

                return 'error-eliminando-det-res';

            }

        }else{

            return 'error';

        }


    }

    static public function ctrEliminarProfesional($idEncuProcesoGestion, $idEncuProceso, $idEncuesta){

        //VALIDAR SI EL PROCESO ENCUESTA TIENE RESPUESTAS EN EL PROCESO
    
        $validacion = ModelEncuestas::mdlValidarExisteEncuestaProceso($idEncuProceso, $idEncuesta);

        if(empty($validacion)){

            $eliminar = ModelEncuestas::mdlEliminarProfesional($idEncuProcesoGestion);
            
            if($eliminar == 'ok'){

                return 'ok';

            }else{

                return 'error-eliminando-proceso';

            }

        }else{

            return 'error-no-permitido';

        }

    }

    static public function ctrListaProcesosGestionEncuesta($idEncuesta){

        $respuesta = ModelEncuestas::mdlListaProcesosGestionEncuesta($idEncuesta);

        return $respuesta;

    }

    static public function ctrAgregarProfesional($datos){

        $tabla = "encuestas_encuestas_procesos_gestion";

        $respuesta = ModelEncuestas::mdlAgregarProfesional($tabla, $datos);

        return $respuesta;

    }

    static public function ctrObtenerProcesosEncuestaNoIniciales($tipoEncuesta){

        $respuesta= ModelEncuestas::mdlObtenerProcesosEncuestaNoIniciales($tipoEncuesta);

        return $respuesta;

    }

    static public function ctrObterProcesosEncuestaArray($idEncuesta){

        $procesos = ControladorEncuestas::ctrObtenerProcesosGestionEncuesta($idEncuesta);

        $arrayProcesos = [];

        foreach ($procesos as $key => $value) {

            $arrayProcesos[] = $value["id_encu_proceso"];

        }


        return $arrayProcesos;


    }

    static public function ctrObtenerProcesosGestionEncuesta($idEncuesta){

        $respuesta = ModelEncuestas::mdlObtenerProcesosGestionEncuesta($idEncuesta);

        return $respuesta;

    }

    static public function ctrDescartarEncuesta($idEncuesta){

        $tabla = "encuestas_encuestas_procesos";

        $hoy = date("Y-m-d H:i:s");

        $respuesta = ModelEncuestas::mdlDescartarEncuesta($tabla, $idEncuesta, $hoy);

        return $respuesta;

    }

    static public function ctrValidacionBolsaEncuesta($idBaseEncuesta){

        $respuesta = ModelEncuestas::mdlValidacionBolsaEncuesta($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrMostrarInformacionEncuesta($idEncuesta){

        $respuesta = ModelEncuestas::mdlMostrarInformacionEncuesta($idEncuesta);

        return $respuesta;

    }

    static public function ctrTerminarEncuesta($idEncuesta){

        $tabla = "encuestas_encuestas_procesos";

        $datos = array(

            "id_encuesta" => $idEncuesta,
            "fecha_fin" => $hoy = date("Y-m-d H:i:s"),
            "estado" => "FINALIZADA"

        );

        $respuesta = ModelEncuestas::mdlTerminarEncuesta($tabla, $datos);

        return $respuesta;

    }

    static public function ctrGuardarRespuestasEncuesta($arrayRespuestas, $idEncuProceso, $idEncuesta, $calificacionProceso){

        $tabla = "encuestas_encuestas_respuestas";

        foreach ($arrayRespuestas as $key => $valueRes) {
        
            $respuesta = ModelEncuestas::mdlGuardarRespuestasEncuesta($tabla, $valueRes);

            if($respuesta != 'ok'){

                return 'error-save-respuestas';

            }
        
        }

        // $actualizarPaso = ControladorEncuestas::ctrActualizarPaso($idEncuProceso, $idEncuesta);
        $updCalifacionProcesoGestion = ControladorEncuestas::ctrActualizarCalifacionEncuProcesoGestion($idEncuProceso, $idEncuesta, $calificacionProceso);

        if($updCalifacionProcesoGestion == 'ok'){

            return 'ok';

        }else{

            return 'error-actualizacion';

        }


    }

    static public function ctrActualizarCalifacionEncuProcesoGestion($idEncuProceso, $idEncuesta, $calificacionProceso){

        $tabla = "encuestas_encuestas_procesos_gestion";

        $respuesta = ModelEncuestas::mdlActualizarCalifacionEncuProcesoGestion($tabla, $idEncuProceso, $idEncuesta, $calificacionProceso);

        return $respuesta;


    }

    static public function ctrListaPreguntasEncuestaProceso($idEncuProceso){

        $respuesta = ModelEncuestas::mdlListaPreguntasEncuestaProceso($idEncuProceso);

        return $respuesta;

    }

    static public function ctrListaPreguntasSegmentosEncuesta($idEncuSegmento){

        $respuesta = ModelEncuestas::mdlListaPreguntasSegmentosEncuesta($idEncuSegmento);

        return $respuesta;

    }

    static public function ctrListaPreguntasSegmentosEncuestaRespuesta($idEncuesta, $idEncuSegmento){

        $respuesta = ModelEncuestas::mdlListaPreguntasSegmentosEncuestaRespuesta($idEncuesta, $idEncuSegmento);

        if(empty($respuesta)){

            $respuesta = ModelEncuestas::mdlListaPreguntasSegmentosEncuesta($idEncuSegmento);

        }

        return $respuesta;

    }

    static public function ctrListaSegmentosProcesoEncuesta($idEncuProceso){

        $respuesta = ModelEncuestas::mdlListaSegmentosProcesoEncuesta($idEncuProceso);

        return $respuesta;

    }

    static public function ctrObtenerProcesosEncuesta($tipoEncuesta){

        $respuesta = ModelEncuestas::mdlObtenerProcesosEncuesta($tipoEncuesta);

        return $respuesta;

    }

    static public function ctrObtenerProcesosInicialesEncuesta($tipoEncuesta){

        $respuesta = ModelEncuestas::mdlObtenerProcesosInicialesEncuesta($tipoEncuesta);

        return $respuesta;

    }

    static public function ctrListaEncuestasPendientesUser($tipoEncuesta, $auditor){

        $respuesta = ModelEncuestas::mdlListaEncuestasPendientesUser($tipoEncuesta, $auditor);

        return $respuesta;

    }

    static public function ctrTomarEncuesta($idEncuesta, $auditor, $idBaseEncuesta, $tipoEncuesta, $nombreUser){

        $infoBase = ControladorEncuestas::ctrValidacionBolsaEncuesta($idBaseEncuesta);

        if($infoBase["cantidad"] < $infoBase["muestra"]){

            $encuestasUser = ControladorEncuestas::ctrListaEncuestasPendienteUser($auditor);

            $tablaCantidad = "par_variables_globales";
            $itemCantidad = "variable";
            $valorCantidad = "CANTIDAD_PENDIENTES_ENCUESTAS";

            $datosCantidades = ControladorEncuestas::ctrObtenerDato($tablaCantidad, $itemCantidad, $valorCantidad);

            if(count($encuestasUser) < $datosCantidades["valor"]){

                $data = ControladorEncuestas::ctrObtenerEncuesta($idEncuesta);

                if(empty($data["auditor"]) && $data["estado"] == 'CREADA'){

                    $hoy = date("Y-m-d H:i:s");

                    $asignarEncuesta = ModelEncuestas::mdlAsignarEncuesta($idEncuesta, $auditor, $hoy);

                    if($asignarEncuesta == 'ok'){

                        $crearEncuProcesosGestion = ControladorEncuestas::ctrCrearProcesosInicialesGestion($idEncuesta, $auditor, $tipoEncuesta, $nombreUser);

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

            $muestraCumplida = ControladorEncuestas::ctrObtenerEncuestasTerminadasBase($idBaseEncuesta);

            if($muestraCumplida["cantidad_finalizadas"] >= $infoBase["muestra"]){

                //CERRAMOS TODOS LOS CASOS EN OTROS ESTADOS DIFERENTES A FINALIZADA
                $cerrarEncuestas = ControladorEncuestas::ctrActualizarEncuestasNoAplicadaBase($idBaseEncuesta);

                if($cerrarEncuestas == "ok"){

                    $estadoBase = ControladorEncuestas::ctrActualizarEstadoBase($idBaseEncuesta);

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

        $respuesta = ModelEncuestas::mdlActualizarEstadoBase($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrActualizarEncuestasNoAplicadaBase($idBaseEncuesta){

        $respuesta = ModelEncuestas::mdlActualizarEncuestasNoAplicadaBase($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrObtenerEncuestasTerminadasBase($idBaseEncuesta){

        $respuesta = ModelEncuestas::mdlObtenerEncuestasTerminadasBase($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrCrearProcesosInicialesGestion($idEncuesta, $auditor, $tipoEncuesta, $nombreUser){

        $tabla = "encuestas_encuestas_procesos_gestion";

        $procesos = ControladorEncuestas::ctrObtenerProcesosInicialesEncuesta($tipoEncuesta);

        foreach ($procesos as $key => $valueProceso) {

            $datos = array(
                "id_encuesta" => $idEncuesta,
                "id_encu_proceso" => $valueProceso["id_encu_proceso"],
                "proceso" => $valueProceso["proceso"],
                "nombre_usuario" => strtoupper($nombreUser),
                "usuario_crea" => $auditor
            );

            $crear = ModelEncuestas::mdlCrearProcesosInicialesGestion($tabla, $datos);

            if($crear != 'ok'){

                return 'error';

            }

        }

        return 'ok';

    }

    static public function ctrObtenerEncuesta($idEncuesta){

        $respuesta = ModelEncuestas::mdlObtenerEncuesta($idEncuesta);

        return $respuesta;

    }

    static public function ctrListaEncuestasPendienteUser($user){

        $respuesta = ModelEncuestas::mdlListaEncuestasPendienteUser($user);

        return $respuesta;

    }

    static public function ctrListaEncuestasBolsa($tipoEncuesta, $user){

        $tabla = "encuestas_encuestas_procesos";

        $idEncuesta = ControladorEncuestas::ctrObtenerIdEncuestaAleatoriaAuditor($tipoEncuesta, $user);

        // $respuesta = ModelEncuestas::mdlListaEncuestasBolsa($tabla, $tipoEncuesta, $user);

        if(!empty($idEncuesta)){

            $respuesta = ModelEncuestas::mdlObtenerInfoEncuesta($tipoEncuesta, $user, $idEncuesta["id_encuesta"]);

        }else{

            $respuesta = [];

        }

        return $respuesta;

    }

    static public function ctrObtenerIdEncuestaAleatoriaAuditor($tipoEncuesta, $user){

        $arrayEncuestas = ModelEncuestas::mdlObtenerIdEncuestasAuditor($tipoEncuesta, $user);

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

    static public function ctrObtenerArchivoCargar(){

        $tabla = "encuestas_bases_encuestas";

        $respuesta = ModelEncuestas::mdlObtenerArchivoCargar($tabla);

        return $respuesta;

    }

    static public function ctrListaBasesEncuestas(){

        $tabla = "encuestas_bases_encuestas";

        $respuesta = ModelEncuestas::mdlListaBasesEncuestas($tabla);

        return $respuesta;

    }

    static public function ctrCargarArchivoEncuestas($datos){

        if(!empty($datos)){

            $Now = date('YmdHis');
			$ruta = "../../../archivos_nexuslink/encuestas/archivos_bases_encuestas/";
			$rutaErrores = "../../../archivos_nexuslink/encuestas/archivos_bases_encuestas/errores/";
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

                $tabla = "encuestas_bases_encuestas";

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
                    "nombre" => strtoupper($datos["nombre_archivo"]),
                    "nombre_archivo_original" => $nombreOriginal,
                    "tipo_encuestas" => $datos["tipo_encuestas"],
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

                $guardarArchivo = ModelEncuestas::mdlGuardarArchivoEncuestas($tabla, $datosEncuestas);

                if($guardarArchivo == 'ok'){

                    return 'ok';

                }else{

                    return $guardarArchivo;

                }

            }else{

                $archivoError = fopen("../../../archivos_nexuslink/encuestas/archivos_bases_encuestas/errores/" . $nombreArchivo . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

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

        $respuesta = ModelEncuestas::mdlObtenerDato($tabla, $item, $valor);

        return $respuesta;

    }


}
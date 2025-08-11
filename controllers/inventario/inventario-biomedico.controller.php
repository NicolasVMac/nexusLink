<?php

class ControladorInventarioBiomedico{

    static public function ctrListaEquiposBiomedicosReserva(){

        $tabla = "inventario_equipos_biomedicos";
        
        $respuesta = ModelInventarioBiomedico::mdlListaEquiposBiomedicosReserva($tabla);

        return $respuesta;

    }

    static public function ctrValidacionTipoMantenimiento($idEquipoBiomedico, $tipoMantenimiento){

        $hoy = date("Y-m-d");

        $respuesta = ModelInventarioBiomedico::mdlValidacionTipoMantenimiento($idEquipoBiomedico, $tipoMantenimiento, $hoy);

        return $respuesta;

    }

    static public function ctrListaEstadosMantenimientosBiomedicosCl(){

        $hoy = date("Y-m-d");

        $respuesta = ModelInventarioBiomedico::mdlListaEstadosMantenimientosBiomedicosCl($hoy);

        return $respuesta;

    }

    static public function ctrListaEstadosMantenimientosBiomedicosVld(){

        $hoy = date("Y-m-d");

        $respuesta = ModelInventarioBiomedico::mdlListaEstadosMantenimientosBiomedicosVld($hoy);

        return $respuesta;

    }

    static public function ctrListaEstadosMantenimientosBiomedicosClbr(){

        $hoy = date("Y-m-d");

        $respuesta = ModelInventarioBiomedico::mdlListaEstadosMantenimientosBiomedicosClbr($hoy);

        return $respuesta;

    }

    static public function ctrObtenerHistorialMantenimientos($idEquipoBiomedico){

        $respuesta = ModelInventarioBiomedico::mdlObtenerHistorialMantenimientos($idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrObtenerOtrosMto($idEquipoBiomedico){

        $respuesta = ModelInventarioBiomedico::mdlObtenerOtrosMto($idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrObtenerMtoBiomedico($idEquipoBiomedico){

        $respuesta = ModelInventarioBiomedico::mdlObtenerMtoBiomedico($idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrObtenerTiposMantenimientosEquipoBiomedico($idEquipoBiomedico){

        $respuesta = ModelInventarioBiomedico::mdlObtenerTiposMantenimientosEquipoBiomedico($idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrEliminarTipoMantenimientoBiomedico($datos){
        
        $datos["fecha_elimina"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioBiomedico::mdlEliminarTipoMantenimientoBiomedico($datos);

        return $respuesta;

    }

    static public function ctrAgregarTipoMantenimientoBiomedico($datos){

        //VALIDACION TIPO MANTENIMIENTO
        $vali = ControladorInventarioBiomedico::ctrValiTipoMantenimiento($datos["id_equipo_biomedico"], $datos["tipo_mantenimiento"]);

        if($vali == 'crear'){

            $respuesta = ModelInventarioBiomedico::mdlAgregarTipoMantenimientoBiomedico($datos);
    
            return $respuesta;

        }else{

            return $vali;

        }


    }

    static public function ctrValiTipoMantenimiento($idEquipoBiomedico, $tipoMantenimiento){

        $info = ModelInventarioBiomedico::mdlValidarTipoMantenimientro($idEquipoBiomedico, $tipoMantenimiento);

        if(!empty($info)){

            return 'error-existe';

        }else{

            return 'crear';

        }


    }

    static public function ctrListaEquipoBiomedicoTiposMantenimientos($idEquipoBiomedico){

        $respuesta = ModelInventarioBiomedico::mdlListaEquipoBiomedicoTiposMantenimientos($idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrListaEstadosMantenimientosBiomedicosMto(){

        $hoy = date("Y-m-d");

        $respuesta = ModelInventarioBiomedico::mdlListaEstadosMantenimientosBiomedicosMto($hoy);

        return $respuesta;

    }

    static public function ctrEliminarMantenimientoBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos_mantenimientos";
        $datos["fecha_elimina"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioBiomedico::mdlEliminarMantenimientoBiomedico($tabla, $datos);

        return $respuesta;

    }

    static public function ctrObtenerMantenimientosEquipoBiomedico($idEquipoBiomedico){

        $respuesta = ModelInventarioBiomedico::mdlObtenerMantenimientosEquipoBiomedico($idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrListaSolicitudesActaBajaEquipoBio($idEquipoBiomedico){

        $tabla = "inventario_equipos_biomedicos_solicitudes_bajas_equipos";

        $respuesta = ModelInventarioBiomedico::mdlListaSolicitudesActaBajaEquipoBio($tabla, $idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrAgregarSolicitudBajaEquipoBio($datos){

        $tabla = "inventario_equipos_biomedicos_solicitudes_bajas_equipos";

        $respuesta = ModelInventarioBiomedico::mdlAgregarSolicitudBajaEquipoBio($tabla, $datos);

        return $respuesta;

    }

    static public function ctrListaSolicitudesMantenimientosEquipoBio($idEquipoBiomedico){

        $tabla = "inventario_equipos_biomedicos_solicitudes_mantenimientos";

        $respuesta = ModelInventarioBiomedico::mdlListaSolicitudesMantenimientosEquipoBio($tabla, $idEquipoBiomedico);

        return $respuesta;

    }


    static public function ctrAgregarSolicitudMantenimientoCorrectivoEquipoBio($datos){

        $tabla = "inventario_equipos_biomedicos_solicitudes_mantenimientos";

        $respuesta = ModelInventarioBiomedico::mdlAgregarSolicitudMantenimientoCorrectivoEquipoBio($tabla, $datos);

        return $respuesta;

    }

    static public function ctrListaSolicitudesTrasladoEquipoBio($idEquipoBiomedico){

        $tabla = "inventario_equipos_biomedicos_solicitudes_traslados";

        $respuesta = ModelInventarioBiomedico::mdlListaSolicitudesTrasladoEquipoBio($tabla, $idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrAgregarSolicitudTrasladoEquipoBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos_solicitudes_traslados";

        $datosEquipoBio = ControladorInventarioBiomedico::ctrInfoDatosEquipoBiomedico($datos["id_equipo_biomedico"]);

        if(!empty($datosEquipoBio)){

            $datos["sede_old"] = $datosEquipoBio["sede"];
            $datos["activo_fijo_old"] = $datosEquipoBio["activo_fijo"];
            $datos["ubicacion_old"] = $datosEquipoBio["ubicacion"];

            $respuesta = ModelInventarioBiomedico::mdlAgregarSolicitudTrasladoEquipoBiomedico($tabla, $datos);

            if($respuesta == 'ok'){

                //ACTUALIZAR SEDE, UBICACION, ACTIVO FIJO
                $updSede = ModelInventarioBiomedico::mdlActualizarSedeBiomedico($datos);

                return $updSede;

            }else{

                return 'error';

            }
    

        }else{

            return 'error';

        }


    }

    static public function ctrValidacionMantenimientoEquipoBiomedico($idEquipoBiomedico){

        $hoy = date("Y-m-d");

        $respuesta = ModelInventarioBiomedico::mdlValidacionMantenimientoEquipoBiomedico($hoy, $idEquipoBiomedico);

        return $respuesta;

    }

    
    static public function ctrListaMantenimientosEquiposBiomedicos($idEquipoBiomedico){

        $respuesta = ModelInventarioBiomedico::mdlListaMantenimientosEquiposBiomedicos($idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrAgregarMantenimientoBiomedico($datos){

        if(!empty($datos["archivoMantenimiento"]["name"])){

            $Now = date('YmdHis');
			$ruta = "../../../archivos_nexuslink/inventario/biomedicos/mantenimientos/".$datos["id_equipo_biomedico"]."/";
            if(!file_exists($ruta)){
                mkdir($ruta, 0777, true) or die ("No se puede crear el directorio");
            }
			$nombreOriginal = $datos["archivoMantenimiento"]["name"];
			$nombreArchivo = $Now.$nombreOriginal;
			$rutaFin = $ruta.$nombreArchivo;

            move_uploaded_file ($datos["archivoMantenimiento"]["tmp_name"], $rutaFin);
            $datos["ruta_archivo"] = $rutaFin;

        }else{

            $datos["ruta_archivo"] = "";

        }

        $tabla = "inventario_equipos_biomedicos_mantenimientos";

        $respuesta = ModelInventarioBiomedico::mdlAgregarMantenimientoBiomedico($tabla, $datos);

        return $respuesta;

    }

    static public function ctrObtenerDatosActivos($tabla, $item, $valor){

        $respuesta = ModelInventarioBiomedico::mdlObtenerDatosActivos($tabla, $item, $valor);

        return $respuesta;

    }

    static public function ctrListaEstadosGarantiaBiomedicos(){

        $hoy = date("Y-m-d");

        $respuesta = ModelInventarioBiomedico::mdlListaEstadosGarantiaBiomedicos($hoy);

        return $respuesta;

    }

    static public function ctrObtenerDato($tabla, $item, $valor){

        $respuesta = ModelInventarioBiomedico::mdlObtenerDato($tabla, $item, $valor);
        
        return $respuesta;

    }

    static public function ctrListaEquiposBiomedicos(){

        $tabla = "inventario_equipos_biomedicos";
        
        $respuesta = ModelInventarioBiomedico::mdlListaEquiposBiomedicos($tabla);

        return $respuesta;

    }

    static public function ctrEliminarComponenteAccesorioBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos_componentes_caracteristicas";
        $datos["fecha_elimina"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioBiomedico::mdlEliminarComponenteAccesorioBiomedico($tabla, $datos);

        return $respuesta;

    }

    static public function ctrEliminarRecomendacionBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos_recomendaciones";
        $datos["fecha_elimina"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioBiomedico::mdlEliminarRecomendacionBiomedico($tabla, $datos);

        return $respuesta;

    }

    static public function ctrEliminarPlanoBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos_planos";
        $datos["fecha_elimina"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioBiomedico::mdlEliminarPlanoBiomedico($tabla, $datos);

        return $respuesta;

    }

    static public function ctrEliminarManualBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos_manuales";
        $datos["fecha_elimina"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioBiomedico::mdlEliminarManualBiomedico($tabla, $datos);

        return $respuesta;

    }

    static public function ctrInfoDatosEquipoBiomedicoHistorico($idEquipoBiomedico){

        $tabla = "inventario_equipos_biomedicos_historicos";

        $respuesta = ModelInventarioBiomedico::mdlInfoDatosEquipoBiomedicoHistorico($tabla, $idEquipoBiomedico);

        return $respuesta;

    }


    static public function ctrGuardarHistoricoEquipoBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos_historicos";

        $datos["fecha_crea"] = date("Y-m-d H:i:s");

        $fecha1 = new DateTime($datos["fecha_inicio_garantia"]);
        $fecha2 = new DateTime($datos["fecha_fin_garantia"]);

        $intervalo = $fecha1->diff($fecha2);
        $datos["garantia_anios"] = $intervalo->days;
        $datos["valor_depreciacion"] = $datos["valor_iva"] / $datos["vida_util"];

        $dataLogOld = ControladorInventarioBiomedico::ctrInfoDatosEquipoBiomedico($datos["id_equipo_biomedico"]);

        $respuesta = ModelInventarioBiomedico::mdlGuardarHistoricoEquipoBiomedico($tabla, $datos);

        if($respuesta == 'ok'){

            $tablaLog = "inventario_log_equipos_biomedicos";

            $datosLog = array(
                "id_equipo_biomedico" => $datos["id_equipo_biomedico"],
                "accion" => "EDICION DATOS EQUIPOS BIOMEDICOS HISTORICO",
                "data_old" => json_encode($dataLogOld),
                "data_new" => json_encode($datos),
                "usuario_crea" => $datos["usuario_crea"],
                "fecha_crea" => date("Y-m-d H:i:s")
            );

            //LOG CAMBIO
            $log = ModelInventarioBiomedico::mdlRegistrarLog($tablaLog, $datosLog);

            if($log == 'ok'){
                
                return 'ok';
                
            }else{

                return 'error';
            }

        }else{

            return $respuesta;

        }


    }

    static public function ctrListaEquipoBiomedicoComponentesCaracteristicas($idEquipoBiomedico){

        $tabla = "inventario_equipos_biomedicos_componentes_caracteristicas";

        $respuesta = ModelInventarioBiomedico::mdlListaEquipoBiomedicoComponentesCaracteristicas($tabla, $idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrCrearComponenteCaracteristica($datos){

        $tabla = "inventario_equipos_biomedicos_componentes_caracteristicas";

        $datos["fecha_crea"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioBiomedico::mdlCrearComponenteCaracteristica($tabla, $datos);

        return $respuesta;


    }

    static public function ctrListaEquipoBiomedicoRecomendaciones($idEquipoBiomedico){
        
        $tabla = "inventario_equipos_biomedicos_recomendaciones";

        $respuesta = ModelInventarioBiomedico::mdlListaEquipoBiomedicoRecomendaciones($tabla, $idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrCrearRecomendacionBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos_recomendaciones";
        $datos["fecha_crea"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioBiomedico::mdlCrearRecomendacionBiomedico($tabla, $datos);

        return $respuesta;

    }

    static public function ctrListaEquipoBiomedicoPlanos($idEquipoBiomedico){

        $tabla = "inventario_equipos_biomedicos_planos";

        $respuesta = ModelInventarioBiomedico::mdlListaEquipoBiomedicoPlanos($tabla, $idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrCrearPlanoBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos_planos";

        if(!empty($datos["archivoPlano"]) && !empty($datos["archivoPlano"]["name"][0])){

            $rutaArchivo = "../../../archivos_nexuslink/inventario/biomedicos/planos/".$datos["id_equipo_biomedico"];

            if(!file_exists($rutaArchivo)){

                mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");

            }


            if($datos["archivoPlano"]["name"]){

                $aletorioArchivo = rand(0000001, 9999999);

                $filenameArchivo = $aletorioArchivo.$datos["archivoPlano"]["name"];
                $sourceArchivo = $datos["archivoPlano"]["tmp_name"];

                $dirArchivo = opendir($rutaArchivo);
                $rutaArchivoFin = $rutaArchivo."/".$filenameArchivo;

                if(move_uploaded_file($sourceArchivo, $rutaArchivoFin)){

                    $resultado = "ok";

                }else{

                    $resultado = "error";

                }

                closedir($dirArchivo);
    
            }

    
        }else{

            $rutaArchivoFin = '';

        }

        $datos["ruta_archivo"] = $rutaArchivoFin;
        $datos["fecha_crea"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioBiomedico::mdlCrearPlanoBiomedico($tabla, $datos);

        if($respuesta == 'ok'){

            return 'ok';
        
        }else{

            return 'error';
            
        }

    }

    static public function ctrListaEquipoBiomedicoManuales($idEquipoBiomedico){

        $tabla = "inventario_equipos_biomedicos_manuales";

        $respuesta = ModelInventarioBiomedico::mdlListaEquipoBiomedicoManuales($tabla, $idEquipoBiomedico);

        return $respuesta;

    }

    static public function ctrCrearManualBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos_manuales";

        if(!empty($datos["archivoManual"]) && !empty($datos["archivoManual"]["name"][0])){

            $rutaArchivo = "../../../archivos_nexuslink/inventario/biomedicos/manuales/".$datos["id_equipo_biomedico"];

            if(!file_exists($rutaArchivo)){

                mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");

            }


            if($datos["archivoManual"]["name"]){

                $aletorioArchivo = rand(0000001, 9999999);

                $filenameArchivo = $aletorioArchivo.$datos["archivoManual"]["name"];
                $sourceArchivo = $datos["archivoManual"]["tmp_name"];

                $dirArchivo = opendir($rutaArchivo);
                $rutaArchivoFin = $rutaArchivo."/".$filenameArchivo;

                if(move_uploaded_file($sourceArchivo, $rutaArchivoFin)){

                    $resultado = "ok";

                }else{

                    $resultado = "error";

                }

                closedir($dirArchivo);
    
            }

    
        }else{

            $rutaArchivoFin = '';

        }

        $datos["ruta_archivo"] = $rutaArchivoFin;
        $datos["fecha_crea"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioBiomedico::mdlCrearManualBiomedico($tabla, $datos);

        if($respuesta == 'ok'){

            return 'ok';
        
        }else{

            return 'error';
            
        }
        
    }

    static public function ctrEditarDatosEquipoBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos";

        $dataLogOld = ControladorInventarioBiomedico::ctrInfoDatosEquipoBiomedico($datos["id"]);

        $respuesta = ModelInventarioBiomedico::mdlEditarDatosEquipoBiomedico($tabla, $datos);

        if($respuesta == 'ok'){

            $tablaLog = "inventario_log_equipos_biomedicos";

            $datosLog = array(
                "id_equipo_biomedico" => $datos["id"],
                "accion" => "EDICION DATOS EQUIPOS BIOMEDICOS",
                "data_old" => json_encode($dataLogOld),
                "data_new" => json_encode($datos),
                "usuario_crea" => $datos["usuario_edita"],
                "fecha_crea" => date("Y-m-d H:i:s")
            );

            //LOG CAMBIO
            $log = ModelInventarioBiomedico::mdlRegistrarLog($tablaLog, $datosLog);

            if($log == 'ok'){
                
                return 'ok';
                
            }else{

                return 'error';
            }

        }else{

            return 'error';
        }

    }

    static public function ctrInfoDatosEquipoBiomedico($idEquipoBiomedico){

        $tabla = "inventario_equipos_biomedicos";

        $respuesta = ModelInventarioBiomedico::mdlInfoDatosEquipoBiomedico($tabla, $idEquipoBiomedico);

        return $respuesta;

    }


    static public function ctrGuardarDatosEquipoBiomedico($datos){

        $tabla = "inventario_equipos_biomedicos";

        $datos["fecha_crea"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioBiomedico::mdlGuardarDatosEquipoBiomedico($tabla, $datos);

        if($respuesta == 'ok'){

            //OBTENER DATOS EQUIPO BIOMEDICO CREADO
            $dataEquipo = ControladorInventarioBiomedico::ctrObtenerEquipoBiomedico($datos["marca"], $datos["modelo"], $datos["activo_fijo"], $datos["usuario_crea"]);

            $datosHistorico = array(
                "id_equipo_biomedico" => $dataEquipo["id"],
                "usuario_crea" =>  $datos["usuario_crea"],
                "fecha_crea" => date("Y-m-d H:i:s")
            );

            //CREAR REGISTRO HISTORICO
            $equipoHistorico = ModelInventarioBiomedico::mdlCrearEquipoBiomedicoHistorico($datosHistorico);

            return array(
                "response" => "ok",
                "data" => $dataEquipo
            );


        }else{

            return array(
                "response" => "error",
                "data" => []
            );

        }

    }

    static public function ctrObtenerEquipoBiomedico($marca, $modelo, $activoFijo, $usuarioCrea){

        $respuesta = ModelInventarioBiomedico::mdlObtenerEquipoBiomedico($marca, $modelo, $activoFijo, $usuarioCrea);

        return $respuesta;

    }

}
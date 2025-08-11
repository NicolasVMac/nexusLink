<?php

date_default_timezone_set('America/Bogota');

class ControladorCorrespondenciaRecibida{

    static public function ctrListaCorrespondenciaRecibidaAll(){

        $respuesta = ModelCorrespondenciaRecibida::mdlListaCorrespondenciaRecibidaAll();

        return $respuesta;

    }


    static public function ctrListaCorresponFactuRec(){

        $respuesta = ModelCorrespondenciaRecibida::mdlListaCorresponFactuRec();

        return $respuesta;

    }


    static public function ctrAprobarCorresponFacRec($datos){

        $datos["fecha_cartera"] = date("Y-m-d H:i:s");
        $respuesta = ModelCorrespondenciaRecibida::mdlAprobarCorresponFacRec($datos);

        return $respuesta;

    }

    static public function ctrListaBolsaCorresponFactuRec(){

        $respuesta = ModelCorrespondenciaRecibida::mdlListaBolsaCorresponFactuRec();

        return $respuesta;

    }


    static public function ctrGestionarCorrespondenciaRecibida($datos){

        if(!empty($datos)){

            $tabla = "correspondencia_correspondencia_recibida";

            if(!empty($datos["archivosGestionCorresponRec"]) && !empty($datos["archivosGestionCorresponRec"]["name"][0])){

                $rutaArchivo = "../../../archivos_nexuslink/correspondencia/correspondencia_recibida/archivos_gestion/".$datos["id_corr_rec"]."/";
    
                if(!file_exists($rutaArchivo)){
    
                    mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");
    
                }
    
                foreach ($datos["archivosGestionCorresponRec"]["tmp_name"] as $key => $tmp_name) {
    
                    if($datos["archivosGestionCorresponRec"]["name"][$key]){
    
                        $aletorioArchivo = rand(0000001, 9999999);
    
                        $filenameArchivo = $aletorioArchivo.'-'.$datos["archivosGestionCorresponRec"]["name"][$key];
                        $sourceArchivo = $datos["archivosGestionCorresponRec"]["tmp_name"][$key];
    
                        $dirArchivo = opendir($rutaArchivo);
                        $target_path_archivo = $rutaArchivo."/".$filenameArchivo;
    
                        if(move_uploaded_file($sourceArchivo, $target_path_archivo)){
    
                            $resultado = "ok";
    
                        }else{
    
                            $resultado = "error";
    
                        }
    
                        closedir($dirArchivo);
            
                    }
    
                }
            
            }

            $datos["ruta_archivo_ges"] = $rutaArchivo;
            $datos["fecha_gestion"] = date("Y-m-d H:i:s");

            $save = ModelCorrespondenciaRecibida::mdlGestionarCorrespondenciaRecibida($tabla, $datos);

            if($save == 'ok'){

                $datosLog = array(
                    "id_corr" => $datos["id_corr_rec"],
                    "categoria_correspon" => "RECIBIDA",
                    "mensaje" => "GESTION CORRESPONDENCIA RECIBIDA",
                    "usuario_crea" => $datos["usuario_gestion"],
                    "fecha_crea" => date("Y-m-d H:i:s")
                );

                $log = ControladorCorrespondenciaRecibida::ctrRegistrarLogCorrespondencia($datosLog);

                if($log == 'ok'){

                    return 'ok';

                }else{

                    return 'error-log';

                }

            }else{

                return 'error-save';

            }


        }else{

            return 'error-datos';

        }

    }

    static public function ctrAsignarUsuarioCorrespondenciaRec($datos){

        if(!empty($datos)){

            $tabla = "correspondencia_correspondencia_recibida";

            $save = ModelCorrespondenciaRecibida::mdlAsignarUsuarioCorrespondenciaRec($tabla, $datos);

            if($save == 'ok'){

                $datosLog = array(
                    "id_corr" => $datos["id_corr_rec"],
                    "categoria_correspon" => "RECIBIDA",
                    "mensaje" => "RE-ASIGNAR CORRESPONDENCIA RECIBIDA",
                    "usuario_crea" => $datos["usuario_sesion"],
                    "fecha_crea" => date("Y-m-d H:i:s")
                );

                $log = ControladorCorrespondenciaRecibida::ctrRegistrarLogCorrespondencia($datosLog);

                if($log == 'ok'){

                    return 'ok';

                }else{

                    return 'error-log';

                }

            }else{

                return 'error-save';

            }


        }else{

            return 'error-datos';

        }

    }

    static public function ctrListaUsuariosCorresponRecibida($idUserSesion){

        $respuesta = ModelCorrespondenciaRecibida::mdlListaUsuariosCorresponRecibida($idUserSesion);

        return $respuesta;

    }

    static public function ctrRechazarCorresponRec($datos){

        if(!empty($datos)){

            $tabla = "correspondencia_correspondencia_recibida";

            $infoCorrRec = ControladorCorrespondenciaRecibida::ctrInfoCorrespondenciaRecibida($datos["id_corr_rec"]);

            if(!empty($infoCorrRec["id_usuario_re_asignacion"])){

                $datos["estado_asignacion"] = "RE-ASIGNADA-RECHAZADA";
                
            }else{
                
                $datos["estado_asignacion"] = "RECHAZADA";

            }

            $save = ModelCorrespondenciaRecibida::mdlRechazarCorrespondenciaRecibida($tabla, $datos);

            if($save == 'ok'){

                $datosLog = array(
                    "id_corr" => $datos["id_corr_rec"],
                    "categoria_correspon" => "RECIBIDA",
                    "mensaje" => "RECHAZA CORRESPONDENCIA RECIBIDA",
                    "usuario_crea" => $datos["usuario_sesion"],
                    "fecha_crea" => date("Y-m-d H:i:s")
                );

                $log = ControladorCorrespondenciaRecibida::ctrRegistrarLogCorrespondencia($datosLog);

                if($log == 'ok'){

                    return 'ok';

                }else{

                    return 'error';

                }

            }else{

                return 'error';

            }

        }

    }

    static public function ctrInfoCorrespondenciaRecibida($idCorresRec){

        $respuesta = ModelCorrespondenciaRecibida::mdlInfoCorrespondenciaRecibida($idCorresRec);

        return $respuesta;

    }

    static public function ctrListaMiCorresponRec($idUserSesion){

        $respuesta = ModelCorrespondenciaRecibida::mdlListaMiCorresponRec($idUserSesion);

        return $respuesta;

    }

    static public function ctrAceptarCorrespondenciaRecibida($datos){

        if(!empty($datos)){

            $tabla = "correspondencia_correspondencia_recibida";

            $save = ModelCorrespondenciaRecibida::mdlAceptarCorrespondenciaRecibida($tabla, $datos);

            if($save == 'ok'){

                $datosLog = array(
                    "id_corr" => $datos["id_corr_rec"],
                    "categoria_correspon" => "RECIBIDA",
                    "mensaje" => "ACEPTA CORRESPONDENCIA RECIBIDA",
                    "usuario_crea" => $datos["usuario_sesion"],
                    "fecha_crea" => date("Y-m-d H:i:s")
                );

                $log = ControladorCorrespondenciaRecibida::ctrRegistrarLogCorrespondencia($datosLog);

                if($log == 'ok'){

                    return 'ok';

                }else{

                    return 'error';

                }

            }else{

                return 'error';

            }

        }else{

            return 'error-datos';

        }

    }

    static public function ctrListaMiBandejaCorresponRec($idUserSesion){

        $respuesta = ModelCorrespondenciaRecibida::mdlListaMiBandejaCorresponRec($idUserSesion);

        return $respuesta;

    }

    static public function ctrReAsignarCorresRec($datos){

        if(!empty($datos)){

            $tabla = "correspondencia_correspondencia_recibida";

            $save = ModelCorrespondenciaRecibida::mdlReAsignarCorresRec($tabla, $datos);

            if($save == 'ok'){

                $datosLog = array(
                    "id_corr" => $datos["id_corr_rec"],
                    "categoria_correspon" => "RECIBIDA",
                    "mensaje" => "RE-ASIGNA CORRESPONDENCIA RECIBIDA - RESPONSABLE OLD: " . $datos["id_responsable_proyecto_old"] . " - RESPONSABLE NEW: " . $datos["id_responsable_proyecto"],
                    "usuario_crea" => $datos["usuario_sesion"],
                    "fecha_crea" => date("Y-m-d H:i:s")
                );

                $log = ControladorCorrespondenciaRecibida::ctrRegistrarLogCorrespondencia($datosLog);

                if($log == 'ok'){

                    return 'ok';

                }else{

                    return 'error';

                }

            }else{

                return 'error';

            }

        }else{

            return 'error-datos';

        }

    }

    static public function ctrEliminarCorresponRec($idCorresRec, $user){

        $tabla = "correspondencia_correspondencia_recibida";

        $datosCorresRec = array(
            "id_corr" => $idCorresRec,
            "categoria_correspon" => "RECIBIDA",
            "mensaje" => "ELIMINA CORRESPONDENCIA RECIBIDA",
            "usuario_crea" => $user,
            "fecha_crea" => date("Y-m-d H:i:s")
        );

        $updCorresRec = ModelCorrespondenciaRecibida::mdlEliminarCorresponRec($tabla, $datosCorresRec);

        if($updCorresRec == 'ok'){

            $log = ControladorCorrespondenciaRecibida::ctrRegistrarLogCorrespondencia($datosCorresRec);

            if($log == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }else{

            return 'error';

        }

    }


    static public function ctrRegistrarLogCorrespondencia($datos){

        $tabla = "correspondencia_log_correspondencia";

        $respuesta = ModelCorrespondenciaRecibida::mdlRegistrarLogCorrespondencia($tabla, $datos);

        return $respuesta;

    }

    static public function ctrInfoCorrespondenciaRec($idCorresRec){

        $respuesta = ModelCorrespondenciaRecibida::mdlInfoCorrespondenciaRec($idCorresRec);

        $files = [];
        $filesGestion = [];

        if(!empty($respuesta["ruta_archivo_rec"])){

            if(is_dir($respuesta["ruta_archivo_rec"])){
                
                $scanned_files = scandir($respuesta["ruta_archivo_rec"]);
                $files = [];
                
                // Filtrar archivos y omitir '.' y '..'
                foreach ($scanned_files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $files[] = $file;
                    }
                }

                $respuesta["archivosCorresRec"] = $files;
                
            }
            
        }else{

            $respuesta["archivosCorresRec"] = 'SIN ARCHIVOS';

        }

        if(!empty($respuesta["ruta_archivo_ges"])){

            if(is_dir($respuesta["ruta_archivo_ges"])){
                
                $scanned_files = scandir($respuesta["ruta_archivo_ges"]);
                $filesGestion = [];
                
                // Filtrar archivos y omitir '.' y '..'
                foreach ($scanned_files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $filesGestion[] = $file;
                    }
                }

                $respuesta["archivosCorresRecGes"] = $filesGestion;
                
            }
            
        }else{

            $respuesta["archivosCorresRecGes"] = 'SIN ARCHIVOS';

        }

        return $respuesta;

    }

    static public function ctrListaCorrespondenciaRecibida($user){

        $respuesta = ModelCorrespondenciaRecibida::mdlListaCorrespondenciaRecibida($user);

        return $respuesta;

    }

    static public function ctrCargarCorrespondenciaRecibida($datos){

        $tabla = "correspondencia_correspondencia_recibida";
        $dateId = date("YmdHis");

        if(!empty($datos)){

            if(!empty($datos["archivosCorresRec"]) && !empty($datos["archivosCorresRec"]["name"][0])){

                $rutaArchivo = "../../../archivos_nexuslink/correspondencia/correspondencia_recibida/archivos_recibidos/".$dateId."/";
    
                if(!file_exists($rutaArchivo)){
    
                    mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");
    
                }
    
                foreach ($datos["archivosCorresRec"]["tmp_name"] as $key => $tmp_name) {
    
                    if($datos["archivosCorresRec"]["name"][$key]){
    
                        $aletorioArchivo = rand(0000001, 9999999);
    
                        $filenameArchivo = $aletorioArchivo.'-'.$datos["archivosCorresRec"]["name"][$key];
                        $sourceArchivo = $datos["archivosCorresRec"]["tmp_name"][$key];
    
                        $dirArchivo = opendir($rutaArchivo);
                        $target_path_archivo = $rutaArchivo."/".$filenameArchivo;
    
                        if(move_uploaded_file($sourceArchivo, $target_path_archivo)){
    
                            $resultado = "ok";
    
                        }else{
    
                            $resultado = "error";
    
                        }
    
                        closedir($dirArchivo);
            
                    }
    
                }
            
            }

            $datos["ruta_archivo_rec"] = $rutaArchivo;

            $save = ModelCorrespondenciaRecibida::mdlCargarCorrespondenciaRecibida($tabla, $datos);

            if($save == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }else{

            return 'error-datos';

        }


    }

    static public function ctrListaCorrespondenciaEnviadaProyecto($idProyecto){

        $respuesta = ModelCorrespondenciaRecibida::mdlListaCorrespondenciaEnviadaProyecto($idProyecto);

        return $respuesta;

    }

}
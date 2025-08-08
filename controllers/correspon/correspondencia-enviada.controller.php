<?php

date_default_timezone_set('America/Bogota');

class ControladorCorrespondenciaEnviada{

    static public function ctrListaCorrespondenciaEnviada(){

        $respuesta = ModelCorrespondenciaEnviada::mdlListaCorrespondenciaEnviada();

        return $respuesta;

    }

    static public function ctrRespuestaCorrespondenciaEnv($datos){

        $tabla = "correspondencia_correspondencia_enviada";

        if(!empty($datos)){

            if(!empty($datos["archivosRespCorres"]) && !empty($datos["archivosRespCorres"]["name"][0])){

                $rutaArchivo = "../../../archivos_vidamedical/correspondencia/correspondencia_enviada/archivos_recibidos/".$datos["id_corr_env"]."/";
    
                if(!file_exists($rutaArchivo)){
    
                    mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");
    
                }
    
                foreach ($datos["archivosRespCorres"]["tmp_name"] as $key => $tmp_name) {
    
                    if($datos["archivosRespCorres"]["name"][$key]){
    
                        $aletorioArchivo = rand(0000001, 9999999);
    
                        $filenameArchivo = $aletorioArchivo.'-'.$datos["archivosRespCorres"]["name"][$key];
                        $sourceArchivo = $datos["archivosRespCorres"]["tmp_name"][$key];
    
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
            $datos["estado"] = "RADICADO";
            $datos["fecha_radicado"] = date('Y-m-d H:i:s');

            $updRespuesta = ModelCorrespondenciaEnviada::mdlRespuestaCorrespondenciaEnv($tabla, $datos);

            if($updRespuesta == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }else{

            return 'error-datos';

        }

    }

    static public function ctrRadicarCorrespondenciaEnv($datos){

        $tabla = "correspondencia_correspondencia_enviada";

        if(!empty($datos)){

            if(!empty($datos["archivosRadCorres"]) && !empty($datos["archivosRadCorres"]["name"][0])){

                $rutaArchivo = "../../../archivos_vidamedical/correspondencia/correspondencia_enviada/archivos_enviados/".$datos["id_corr_env"]."/";
    
                if(!file_exists($rutaArchivo)){
    
                    mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");
    
                }
    
                foreach ($datos["archivosRadCorres"]["tmp_name"] as $key => $tmp_name) {
    
                    if($datos["archivosRadCorres"]["name"][$key]){
    
                        $aletorioArchivo = rand(0000001, 9999999);
    
                        $filenameArchivo = $aletorioArchivo.'-'.$datos["archivosRadCorres"]["name"][$key];
                        $sourceArchivo = $datos["archivosRadCorres"]["tmp_name"][$key];
    
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


            $datos["ruta_archivo_env"] = $rutaArchivo;
            $datos["estado"] = "RADICANDO";
            $datos["fecha_radicacion"] = date('Y-m-d H:i:s');

            $updRespuesta = ModelCorrespondenciaEnviada::mdlRadicarCorrespondenciaEnv($tabla, $datos);

            if($updRespuesta == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }else{

            return 'error-datos';

        }

    }

    static public function ctrAnularCorrespondenciaEnv($datos){

        $tabla = "correspondencia_correspondencia_enviada";

        $respuesta = ModelCorrespondenciaEnviada::mdlAnularCorrespondenciaEnv($tabla, $datos);

        return $respuesta;

    }


    static public function ctrInfoCorrespondenciaEnv($idCorresEnv){

        $respuesta = ModelCorrespondenciaEnviada::mdlInfoCorrespondenciaEnv($idCorresEnv);

        if(!empty($respuesta["ruta_archivo_env"])){

            if(is_dir($respuesta["ruta_archivo_env"])){
                
                $scanned_files = scandir($respuesta["ruta_archivo_env"]);
                $files = [];
                
                // Filtrar archivos y omitir '.' y '..'
                foreach ($scanned_files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $files[] = $file;
                    }
                }

                $respuesta["archivosCorresEnv"] = $files;
                
            }
            
        }else{

            $respuesta["archivosCorresEnv"] = 'SIN ARCHIVOS';

        }

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

        return $respuesta;

    }

    static public function ctrListaMiCorrespondenciaEnviada($user){

        $respuesta = ModelCorrespondenciaEnviada::mdlListaMiCorrespondenciaEnviada($user);

        return $respuesta;

    }


    static public function ctrCrearNuevoConsecutivo($datos){

        $tabla = "correspondencia_correspondencia_enviada";

        $tablaProyecto = "correspondencia_proyectos";
        $infoProyecto = ControladorCorrespondenciaEnviada::ctrObtenerCodigoConcecutivo($tablaProyecto, $datos["id_proyecto"]);

        if($infoProyecto["numero_consecutivo"] != ""){

            $lastConsecutivo = ModelCorrespondenciaEnviada::mdlObtenerUltimoCodigoCorEnviada($datos["id_proyecto"]);

            if(empty($lastConsecutivo)){
                $lastConsecutivo["codigo"] = "0000";
            }

            $newConsecutivo = substr(str_repeat(0, 6).($infoProyecto["numero_consecutivo"] + 1), - 6);

            $newCodigoCompleto = $infoProyecto["prefijo_proyecto"] . "-" . $newConsecutivo;

            if($newCodigoCompleto > $lastConsecutivo["codigo"]){

                $datosConsecutivo = array(
                    "id_proyecto" => $infoProyecto["id_proyecto"],
                    "numero_consecutivo" => $newConsecutivo
                );

                $updCodigoConsecutivo = ControladorCorrespondenciaEnviada::ctrActualizarCodigoConsecutivo($datosConsecutivo);

                if($updCodigoConsecutivo == 'ok'){

                    $datosCorrespondencia = array(
                        "codigo" => $newCodigoCompleto,
                        "id_proyecto" =>  $infoProyecto["id_proyecto"],
                        "tipo_comunicacion" => $datos["tipo_comunicacion"],
                        "usuario_crea" => $datos["usuario_crea"]
                    );

                    $crearCorrespondencia = ControladorCorrespondenciaEnviada::ctrCrearCorrespondencia($datosCorrespondencia);

                    if($crearCorrespondencia == 'ok'){

                        return array(
                            "resp" => "ok",
                            "codigoConsecutivo" => $newCodigoCompleto
                        );

                    }else{

                        return array(
                            "resp" => "error-save-codigo",
                        );

                    }
                    

                }else{

                    return array(
                        "resp" => "error-logica",
                    );

                }

            }else{

                return array(
                    "resp" => "error-logica",
                );

            }

        }else{

            return array(
                "resp" => "error-logica",
            );

        }


    }

    static public function ctrCrearCorrespondencia($datos){

        $respuesta = ModelCorrespondenciaEnviada::mdlCrearCorrespondencia($datos);

        return $respuesta;

    }

    static public function ctrActualizarCodigoConsecutivo($datos){

        $respuesta = ModelCorrespondenciaEnviada::mdlActualizarCodigoConsecutivo($datos);

        return $respuesta;

    }


    static public function ctrObtenerCodigoConcecutivo($tabla, $idProyecto){

        $respuesta = ModelCorrespondenciaEnviada::mdlObtenerCodigoConcecutivo($tabla, $idProyecto);

        return $respuesta;

    }

}
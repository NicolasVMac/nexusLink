<?php

date_default_timezone_set('America/Bogota');

class ControladorHv{

    static public function ctrListaHv(){

        $tabla = "hv_datos_personales";

        $respuesta = ModelHv::mdlListaHV($tabla);

        return $respuesta;

    }

    static public function ctrCalculoExperienciaLaboral($idHV){

        $respuesta = ModelHv::mdlCalculoExperienciaLaboral($idHV);

        return $respuesta;

    }

    static public function ctrConsultarHv($datos){

        $respuesta = ModelHv::mdlConsultarHv($datos);

        return $respuesta;

    }


    static public function ctrVerExperienciaLaboral($idExpLaboral){

        $tabla = "hv_experiencias_laborales";

        $respuesta = ModelHv::mdlVerExperienciaLaboral($tabla, $idExpLaboral);

        return $respuesta;

    }


    static public function ctrVerEstudio($idEstudio){

        $tabla = "hv_estudios";

        $respuesta = ModelHv::mdlVerEstudio($tabla, $idEstudio);
        
        return $respuesta;

    }

    static public function ctrEliminarEstudio($datos){

        $tabla = "hv_estudios";
        $datos["fecha_elimina"] = date('Y-m-d H:i:s');

        $respuesta = ModelHv::mdlEliminarEstudio($tabla, $datos);

        return $respuesta;

    }

    static public function ctrEliminarExperienciaLaboral($datos){

        $tabla = "hv_experiencias_laborales";
        $datos["fecha_elimina"] = date('Y-m-d H:i:s');

        $respuesta = ModelHv::mdlEliminarExperienciaLaboral($tabla, $datos);

        return $respuesta;

    }

    static public function ctrEditarDatosPersonales($datos){

        if(!empty($datos)){

            $tabla = "hv_datos_personales";

            $infoHv = ControladorHv::ctrInfoDatosPersonales($datos["id_hv"]);

            if(!empty($datos["archivosDatosPersonales"]) && !empty($datos["archivosDatosPersonales"]["name"][0])){

                $rutaArchivo = "../../../archivos_vidamedical/hv/archivos_datos_personales/".$infoHv["tipo_doc"].$infoHv["numero_doc"]."/";
    
                if(!file_exists($rutaArchivo)){
    
                    mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");
    
                }
    
                foreach ($datos["archivosDatosPersonales"]["tmp_name"] as $key => $tmp_name) {
    
                    if($datos["archivosDatosPersonales"]["name"][$key]){
    
                        $aletorioArchivo = rand(0000001, 9999999);
    
                        $filenameArchivo = $aletorioArchivo.'-'.$datos["archivosDatosPersonales"]["name"][$key];
                        $sourceArchivo = $datos["archivosDatosPersonales"]["tmp_name"][$key];
    
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
            
            }else{

                $rutaArchivo = $infoHv["ruta_archivos_datos"];

            }

            $datos["ruta_archivos_datos"] = $rutaArchivo;


            $save = ModelHv::mdlEditarDatosPersonales($tabla, $datos);

            if($save == 'ok'){

                return array(
                    "response" => "ok",
                    "dataHv" => $infoHv
                );

            }else{

                return array(
                    "response" => "error-save",
                );

            }


        }else{

            return array(
                "response" => "error-datos",
            );

        }

    }

    static public function ctrInfoDatosPersonales($idHV){

        $tabla = "hv_datos_personales";

        $respuesta = ModelHv::mdlInfoDatosPersonales($tabla, $idHV);

        $files = [];

        if(!empty($respuesta["ruta_archivos_datos"])){

            if(is_dir($respuesta["ruta_archivos_datos"])){
                
                $scanned_files = scandir($respuesta["ruta_archivos_datos"]);
                $files = [];
                
                // Filtrar archivos y omitir '.' y '..'
                foreach ($scanned_files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $files[] = $file;
                    }
                }

                $respuesta["archivosDatosPersonales"] = $files;
                
            }
            
        }else{

            $respuesta["archivosDatosPersonales"] = 'SIN ARCHIVOS';

        }

        return $respuesta;

    }

    static public function ctrListaEstudios($idHV){

        $tabla = "hv_estudios";

        $respuesta = ModelHv::mdlListaEstudios($tabla, $idHV);

        return $respuesta;

    }

    static public function ctrListaExperienciasLaborales($idHV){

        $tabla = "hv_experiencias_laborales";

        $respuesta = ModelHv::mdlListaExperienciasLaborales($tabla, $idHV);

        return $respuesta;

    }

    static public function ctrCrearExperienciaLaboral($datos){

        if(!empty($datos)){

            $tabla = "hv_experiencias_laborales";

            if(!empty($datos["archivoExpLaboral"]) && !empty($datos["archivoExpLaboral"]["name"][0])){

                $rutaArchivo = "../../../archivos_vidamedical/hv/archivos_experiencias_laborales/".$datos["id_hv"];

                if(!file_exists($rutaArchivo)){

                    mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");

                }


                if($datos["archivoExpLaboral"]["name"]){

                    $aletorioArchivo = rand(0000001, 9999999);

                    $filenameArchivo = $aletorioArchivo.$datos["archivoExpLaboral"]["name"];
                    $sourceArchivo = $datos["archivoExpLaboral"]["tmp_name"];

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

            $tiempoLabor = ControladorHv::ctrTiempoLaborado($datos["fecha_inicio_labor"], $datos["fecha_fin_labor"]);
            
            $datos["ruta_archivo"] = $rutaArchivoFin;
            $datos["tiempo_dias"] = $tiempoLabor["dias"];
            $datos["tiempo_meses"] = $tiempoLabor["meses"];
            $datos["tiempo_anios"] = $tiempoLabor["anios"];


            $save = ModelHv::mdlCrearExperienciaLaboral($tabla, $datos);

            if($save == 'ok'){

                return 'ok';

            }else{

                return 'error-save';

            }

        }else{

            return 'error-datos';

        }

    }

    static public function ctrTiempoLaborado($fechaInicio, $fechaFin){

        $fechaUno = new DateTime($fechaInicio);
        $fechaDos = new DateTime($fechaFin);
        
        $intervalo = $fechaUno->diff($fechaDos);

        $anios = $intervalo->y + ($intervalo->m / 12) + ($intervalo->d / 365);
        $meses = ($intervalo->y * 12) + $intervalo->m + ($intervalo->d / 30);
        $dias = $intervalo->days;

        return [
            'anios' => number_format($anios, 2),
            'meses' => number_format($meses, 2),
            'dias' => $dias
        ];

    }

    static public function ctrCrearEstudio($datos){

        if(!empty($datos)){

            $tabla = "hv_estudios";

            if(!empty($datos["archivoEstudio"]) && !empty($datos["archivoEstudio"]["name"][0])){

                $rutaArchivo = "../../../archivos_vidamedical/hv/archivos_estudios/".$datos["id_hv"];

                if(!file_exists($rutaArchivo)){

                    mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");

                }


                if($datos["archivoEstudio"]["name"]){

                    $aletorioArchivo = rand(0000001, 9999999);

                    $filenameArchivo = $aletorioArchivo.$datos["archivoEstudio"]["name"];
                    $sourceArchivo = $datos["archivoEstudio"]["tmp_name"];

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


            if($datos["archivoTarjPro"] !== "VACIO"){

                if(!empty($datos["archivoTarjPro"]) && !empty($datos["archivoTarjPro"]["name"][0])){

                    $rutaArchivo = "../../../archivos_vidamedical/hv/archivos_estudios/".$datos["id_hv"];
    
                    if(!file_exists($rutaArchivo)){
    
                        mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");
    
                    }
    
    
                    if($datos["archivoTarjPro"]["name"]){
    
                        $aletorioArchivo = rand(0000001, 9999999);
    
                        $filenameArchivo = $aletorioArchivo.$datos["archivoTarjPro"]["name"];
                        $sourceArchivo = $datos["archivoTarjPro"]["tmp_name"];
    
                        $dirArchivo = opendir($rutaArchivo);
                        $rutaArchivoTarProFin = $rutaArchivo."/".$filenameArchivo;
    
                        if(move_uploaded_file($sourceArchivo, $rutaArchivoTarProFin)){
    
                            $resultado = "ok";
    
                        }else{
    
                            $resultado = "error";
    
                        }
    
                        closedir($dirArchivo);
            
                    }
    
            
                }else{
    
                    $rutaArchivoTarProFin = '';
    
                }


            }else{

                $rutaArchivoTarProFin = '';

            }


            $datos["ruta_archivo"] = $rutaArchivoFin;
            $datos["ruta_archivo_tarjeta_pro"] = $rutaArchivoTarProFin;

            $save = ModelHv::mdlCrearEstudio($tabla, $datos);

            if($save == 'ok'){

                return 'ok';

            }else{

                return 'error-save';

            }


        }else{

            return 'error-datos';

        }

    }

    static public function ctrCrearDatosPersonales($datos){

        if(!empty($datos)){


            $existePersona = ControladorHv::ctrBuscarHvDocumento($datos["tipo_doc"], $datos["numero_doc"]);

            if(empty($existePersona)){

                $tabla = "hv_datos_personales";

                if(!empty($datos["archivosDatosPersonales"]) && !empty($datos["archivosDatosPersonales"]["name"][0])){

                    $rutaArchivo = "../../../archivos_vidamedical/hv/archivos_datos_personales/".$datos["tipo_doc"].$datos["numero_doc"]."/";
        
                    if(!file_exists($rutaArchivo)){
        
                        mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");
        
                    }
        
                    foreach ($datos["archivosDatosPersonales"]["tmp_name"] as $key => $tmp_name) {
        
                        if($datos["archivosDatosPersonales"]["name"][$key]){
        
                            $aletorioArchivo = rand(0000001, 9999999);
        
                            $filenameArchivo = $aletorioArchivo.'-'.$datos["archivosDatosPersonales"]["name"][$key];
                            $sourceArchivo = $datos["archivosDatosPersonales"]["tmp_name"][$key];
        
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
                
                }else{

                    $rutaArchivo = '';

                }

                $datos["ruta_archivos_datos"] = $rutaArchivo;


                $save = ModelHv::mdlCrearDatosPersonales($tabla, $datos);

                if($save == 'ok'){

                    $infoHv = ControladorHv::ctrBuscarHvDocumento($datos["tipo_doc"], $datos["numero_doc"]);

                    return array(
                        "response" => "ok",
                        "dataHv" => $infoHv
                    );

                }else{

                    return array(
                        "response" => "error-save",
                    );

                }

            }else{

                return array(
                    "response" => "error-existe-persona",
                    "dataHv" => $existePersona
                );

            }


        }else{

            return array(
                "response" => "error-datos",
            );

        }

    }


    static public function ctrBuscarHvDocumento($tipoDoc, $numDoc){

        $tabla = "hv_datos_personales";

        $respuesta = ModelHv::mdlBuscarHvDocumento($tabla, $tipoDoc, $numDoc);

        return $respuesta;

    }

}
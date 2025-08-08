<?php

date_default_timezone_set('America/Bogota');

class ControladorPqr{

    static public function ctrEliminarArchivoPQRSF($datos){

        $tabla = "pqr_log_archivos_eliminados";

        $log = ModelPqr::mdlEliminarArchivoPQRSF($tabla, $datos);

        if($log == 'ok'){

            if(unlink($datos["ruta_archivo"])){

                return 'ok';

            }else{

                return 'error';

            }

        }else{

            return 'error';

        }

    }

    static public function ctrListaPQRSGestionadosGestor($user){

        $respuesta = ModelPqr::mdlListaPQRSGestionadosGestor($user);

        return $respuesta;

    }


    static public function ctrCalcularMaxFechaRespuestaPQRSF($datos){

        $fecha = new DateTime($datos["fecha_pqr"]);
        // echo "Fecha PQR: " . $fecha->format('Y-m-d') . "<br>";

        if ($datos["tiempo"] === 'HORAS') {
            // echo "INGRESO HORAS" . "<br>";
            $diasAgregados = 0;
            $cantidad = $datos["cantidad"] / 24;

            while ($diasAgregados < $cantidad) {
                $fecha->modify('+1 day');
                // $diasAgregados++;
                // echo "Fecha: " . $fecha->format('Y-m-d H:i:s') . " - Dias Agregado: " . $diasAgregados . "<br>";
                if (ControladorPqr::esDiaHabil($fecha)) {
                    $diasAgregados++;
                }
            }

        } elseif ($datos["tiempo"] === 'DIAS') {
            // echo "INGRESO DIAS" . "<br>";
            
            $diasAgregados = 0;

            while ($diasAgregados < $datos["cantidad"]) {
                $fecha->modify('+1 day');
                // $diasAgregados++;
                // echo "Fecha: " . $fecha->format('Y-m-d H:i:s') . " - Dias Agregado: " . $diasAgregados . "<br>";
                if (ControladorPqr::esDiaHabil($fecha)) {
                    $diasAgregados++;
                }
            }
        }

        // echo $fecha->format('Y-m-d H:i:s');

        return  $fecha->format('Y-m-d H:i:s');

    }

    static public function esDiaHabil($fecha){

        $diaSemana = $fecha->format('N'); // 6 para sábado, 7 para domingo

        $anio = date('Y');

        $arrayFestivos = ControladorPqr::ctrObtenerDiasHabiles($anio);

        $esFestivo = in_array($fecha->format('Y-m-d'), $arrayFestivos);
        // echo $fecha->format('Y-m-d H:i:s') . "DIA NUMERO: " . $diaSemana . "<br>";

        return $diaSemana < 6 && !$esFestivo;
    }

    static public function ctrObtenerDiasHabiles($anio){

        $respuesta = ModelPqr::mdlObtenerDiasHabiles($anio);

        $datos = [];

        foreach($respuesta as $key => $value){

            $datos[] = $value["fecha"];
        }

        return $datos;

    }

    static public function ctrEliminarTrabajadorPQRSF($idTrabajador, $user){

        $datos = array(
            "id_par_trabajador" => $idTrabajador,
            "usuario_elimina" => $user,
            "fecha_elimina" => date('Y-m-d H:i:s')
        );

        $respuesta = ModelPqr::mdlEliminarTrabajadorPQRSF($datos);

        return $respuesta;

    }

    static public function ctrAgregarTrabajadorPQRSF($datos){

        //VALIDAR EXISTE TRABAJADOR
        $valiTrabajador = ControladorPqr::ctrValiTrabajador($datos);

        if(empty($valiTrabajador)){

            $respuesta = ModelPqr::mdlAgregarTrabajadorPQRSF($datos);

            return $respuesta;
        
        }else{

            return 'trabajador-existe';

        }


    }

    static public function ctrValiTrabajador($datos){

        $respuesta = ModelPqr::mdlValiTrabajador($datos);

        return $respuesta;

    }

    static public function ctrListaTrabajadoresPQRSF(){

        $respuesta = ModelPqr::mdlListaTrabajadoresPQRSF();

        return $respuesta;

    }

    static public function ctrGuardarResPQRSF($datos){

        if(!empty($datos)){

            if(!empty($datos["archivosResPqr"]) && !empty($datos["archivosResPqr"]["name"][0])){

                $rutaArchivo = "../../../archivos_vidamedical/pqrsf/archivos_res_pqrsf/".$datos["id_pqr"]."/";
    
                if(!file_exists($rutaArchivo)){
    
                    mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");
    
                }
    
                foreach ($datos["archivosResPqr"]["tmp_name"] as $key => $tmp_name) {
    
                    if($datos["archivosResPqr"]["name"][$key]){
    
                        $aletorioArchivo = rand(0000001, 9999999);
    
                        $filenameArchivo = $aletorioArchivo.$datos["archivosResPqr"]["name"][$key];
                        $sourceArchivo = $datos["archivosResPqr"]["tmp_name"][$key];
    
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


            $datos["ruta_archivo_res"] = $rutaArchivo;
            $datos["estado_pqr"] = "FINALIZADO";
            $datos["fecha_archivo_res"] = date('Y-m-d H:i:s');

            $updRespuesta = ModelPqr::mdlGuardarResPQRSF($datos);

            if($updRespuesta == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }else{

            return 'error-datos';

        }

    }

    static public function ctrListaCargarResPQRSF(){

        $respuesta = ModelPqr::mdlListaCargarResPQRSF();

        return $respuesta;

    }

    static public function ctrActualizarPQRSF($datos){

        if(!empty($datos)){

            $tabla = "pqr_pqrs";

            $tiempoNormativo = ControladorPqr::ctrObtenerDato("pqr_par_tipos_pqr", "tipo_pqr", $datos["tipo_pqr"]);

            $datos["tiempo_res_normativo"] = $tiempoNormativo["cantidad"] . " " . $tiempoNormativo["tiempo"];
            // $datos["fecha_radicacion_pqr"] = date('Y-m-d H:i:s');
            $datos["pla_ac_pqr_recurrente"] = "";
            $datos["pla_ac_accion_efectiva"] = "";

            if(empty($datos["fecha_nacimiento_pac"])){

                $datos["fecha_nacimiento_pac"] = null;

            }

            //VALIDACION RECUERRENTE
            $respPQRSFRecurrente = ControladorPqr::ctrValidarPQRSFRecurrente($datos["trabajador_relacionado_pqr"]);
            $datos["pla_ac_pqr_recurrente"] = $respPQRSFRecurrente["pla_ac_pqr_recurrente"];
            $datos["pla_ac_accion_efectiva"] = $respPQRSFRecurrente["pla_ac_accion_efectiva"];

            //CALCULAR DIA MAX RESP PQRSF
            $datosCalculo = array(
                "fecha_pqr" => $datos["fecha_pqr"],
                "tipo_pqr" => $datos["tipo_pqr"],
                "cantidad" => $tiempoNormativo["cantidad"],
                "tiempo" => $tiempoNormativo["tiempo"]
            );

            $fechaMaxRespPQRSF = ControladorPqr::ctrCalcularMaxFechaRespuestaPQRSF($datosCalculo);

            $datos["fecha_max_resp_pqr"] = $fechaMaxRespPQRSF;

            $respuesta = ModelPqr::mdlActualizarPQRSF($tabla, $datos);

            if($respuesta == 'ok'){

                $datosLog = array(
                    "id_pqr" => $datos["id_pqr"],
                    "usuario" => $datos["usuario_mofica"],
                    "accion" => "EDICION INFORMACION PQRSF (DIGITADOR)"
                );

                //ACTUALIZAR LOG CALIDAD
                $log = ControladorPqr::ctrGuardarLog($datosLog);

                return 'ok';


            }else{

                return 'error';

            }


        }else{

            return 'error-datos';

        }

    }

    static public function ctrGuardarLog($datos){

        $tabla = "pqr_log_pqr";

        $respuesta = ModelPqr::mdlGuardarLog($tabla, $datos);

        return $respuesta;

    }

    static public function ctrCantidadPQRSFUser($user){

        $respuesta = ModelPqr::mdlCantidadPQRSFUser($user);
        
        return $respuesta;

    }

    static public function ctrValidarPQRSFRecurrente($trabajadorRelacionado){

        $datos["pla_ac_pqr_recurrente"] = "";
        $datos["pla_ac_accion_efectiva"] = "";

        if($trabajadorRelacionado != "NO APLICA"){

            $numPQRSFTrabajador = ModelPqr::mdlCantidadPQRSTrabajador($trabajadorRelacionado, date('Y-m-d'));

            if(intval($numPQRSFTrabajador) >= 5){

                $datos["pla_ac_pqr_recurrente"] = "RECURRENTE";
                $datos["pla_ac_accion_efectiva"] = "NO EFECTIVA";


            }else{

                $datos["pla_ac_pqr_recurrente"] = "NO RECURRENTE";
                $datos["pla_ac_accion_efectiva"] = "EFECTIVA";

            }

        }else{

            $datos["pla_ac_pqr_recurrente"] = "NO RECURRENTE";
            $datos["pla_ac_accion_efectiva"] = "EFECTIVA";

        }

        return array(
            "pla_ac_pqr_recurrente" => $datos["pla_ac_pqr_recurrente"],
            "pla_ac_accion_efectiva" => $datos["pla_ac_accion_efectiva"],
        );


    }

    static public function ctrCrearBuzonPQRS($datos){

        if(!empty($datos)){

            $tabla = "pqr_pqrs";

            $tiempoNormativo = ControladorPqr::ctrObtenerDato("pqr_par_tipos_pqr", "tipo_pqr", $datos["tipo_pqr"]);

            $datos["tiempo_res_normativo"] = $tiempoNormativo["cantidad"] . " " . $tiempoNormativo["tiempo"];
            $datos["fecha_radicacion_pqr"] = date('Y-m-d H:i:s');
            $datos["estado_pqr"] = "CREADA";
            $datos["fecha_fin_buzon"] = date('Y-m-d H:i:s');
            $datos["pla_ac_pqr_recurrente"] = "";
            $datos["pla_ac_accion_efectiva"] = "";

            if(empty($datos["fecha_nacimiento_pac"])){

                $datos["fecha_nacimiento_pac"] = null;

            }

            $respPQRSFRecurrente = ControladorPqr::ctrValidarPQRSFRecurrente($datos["trabajador_relacionado_pqr"]);
            $datos["pla_ac_pqr_recurrente"] = $respPQRSFRecurrente["pla_ac_pqr_recurrente"];
            $datos["pla_ac_accion_efectiva"] = $respPQRSFRecurrente["pla_ac_accion_efectiva"];

            //CALCULAR DIA MAX RESP PQRSF
            $datosCalculo = array(
                "fecha_pqr" => $datos["fecha_pqr"],
                "tipo_pqr" => $datos["tipo_pqr"],
                "cantidad" => $tiempoNormativo["cantidad"],
                "tiempo" => $tiempoNormativo["tiempo"]
            );

            $fechaMaxRespPQRSF = ControladorPqr::ctrCalcularMaxFechaRespuestaPQRSF($datosCalculo);

            $datos["fecha_max_resp_pqr"] = $fechaMaxRespPQRSF;

            $respuesta = ModelPqr::mdlCrearBuzonPQRS($tabla, $datos);

            if($respuesta == 'ok'){

                // $infoPQR = ModelPqr::mdlObtenerPQRSF($datos);

                if(!empty($datos["archivosPqr"]) && !empty($datos["archivosPqr"]["name"][0])){

                    $rutaArchivo = "../../../archivos_vidamedical/pqrsf/archivos_pqrsf/".$datos["id_pqr"]."/";
        
                    if(!file_exists($rutaArchivo)){
        
                        mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");
        
                    }
        
                    foreach ($datos["archivosPqr"]["tmp_name"] as $key => $tmp_name) {
        
                        if($datos["archivosPqr"]["name"][$key]){
        
                            $aletorioArchivo = rand(0000001, 9999999);
        
                            $filenameArchivo = $aletorioArchivo.$datos["archivosPqr"]["name"][$key];
                            $sourceArchivo = $datos["archivosPqr"]["tmp_name"][$key];
        
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

                $updPQRSF = ModelPqr::mdlActualizarPQRSFArchivos($datos["id_pqr"], $rutaArchivo);

                return $respuesta;

            }else{
                return 'error';
            }


        }else{

            return 'error-datos';

        }

    }

    static public function ctrListaBuzonPendientesPQRSF($user){{

        $respuesta = ModelPqr::mdlListaBuzonPendientesPQRSF($user);

        return $respuesta;

    }}

    static public function ctrInfoBuzonPQRSF($idPQR){

        $respuesta = ModelPqr::mdlInfoBuzonPQRSF($idPQR);

        if(!empty($respuesta["ruta_archivos_actas"])){

            if(is_dir($respuesta["ruta_archivos_actas"])){
                
                $scanned_files = scandir($respuesta["ruta_archivos_actas"]);
                
                // Filtrar archivos y omitir '.' y '..'
                foreach ($scanned_files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $files[] = $file;
                    }
                }

                $respuesta["archivosActaPQRSF"] = $files;
                
            }
            
        }else{

            $respuesta["archivosActaPQRSF"] = 'SIN ARCHIVOS';

        }

        return $respuesta;

    }

    static public function ctrTomarBuzonPQRSF($idPQR, $user){

        $datos = array(
            "id_pqr" => $idPQR,
            "usuario_buzon" => $user,
            "fecha_ini_buzon" => date('Y-m-d H:i:s')
        );

        $respuesta = ModelPqr::mdlTomarBuzonPQRSF($datos);

        return $respuesta;

    }

    static public function ctrListaBuzonPQRSF(){

        $respuesta = ModelPqr::mdlListaBuzonPQRSF();

        return $respuesta;

    }

    static public function ctrCrearActa($datos){

        $infoActa = ControladorPqr::ctrObtenerDato("pqr_actas", "radicado_acta", $datos["radicado_acta"]);

        if(empty($infoActa)){

            if(!empty($datos["archivosActas"]) && !empty($datos["archivosActas"]["name"][0])){

                $rutaArchivo = "../../../archivos_vidamedical/pqrsf/archivos_actas/".$datos["radicado_acta"]."/";

                if(!file_exists($rutaArchivo)){

                    mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");

                }

                foreach ($datos["archivosActas"]["tmp_name"] as $key => $tmp_name) {

                    if($datos["archivosActas"]["name"][$key]){

                        $aletorioArchivo = rand(0000001, 9999999);

                        $filenameArchivo = $aletorioArchivo.$datos["archivosActas"]["name"][$key];
                        $sourceArchivo = $datos["archivosActas"]["tmp_name"][$key];

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

            $datos["ruta_archivos"] = $rutaArchivo;

            $respuesta = ModelPqr::mdlCrearActa($datos);

            if($respuesta == 'ok'){

                //CREAR CANTIDAD PQRSF

                $infoActa = ControladorPqr::ctrObtenerDato("pqr_actas", "radicado_acta", $datos["radicado_acta"]);

                $datosPQR = array(
                    "id_acta" => $infoActa["id_acta"],
                    "estado_pqr" => 'PRECREADA'
                );

                for ($i=0; $i < $datos["cantidad_pqr"]; $i++) { 

                    $pqrPreCreate = ModelPqr::mdlPreCrearPQR($datosPQR);
                
                }

                return $respuesta;


            }else{

                return $respuesta;

            }

        }else{

            return 'error-existe';

        }

    }

    static public function ctrAsignarPQRS($idPQR, $gestor){

        $datos = array(
            "id_pqr" => $idPQR,
            "gestor" => $gestor,
            "fecha_ini_gestor" => date('Y-m-d H:i:s')
        );

        $respuesta = ModelPqr::mdlAsignarPQRS($datos);

        return $respuesta;

    }

    static public function ctrRechazarPQRS($idPQR){

        $respuesta = ModelPqr::mdlRechazarPQRS($idPQR);

        return $respuesta;
        
    }

    static public function ctrListaUsuariosPQRS(){

        $respuesta = ModelPqr::mdlListaUsuariosPQRS();

        return $respuesta;

    }

    static public function ctrListaPQRS(){

        $respuesta = ModelPqr::mdlListaPQRS();

        return $respuesta;

    }

    static public function ctrTerminarRevisionPQRS($datos){

        $tabla = "pqr_pqrs";

        $datos["fecha_fin_revision"] = date('Y-m-d H:i:s');
        $datos["estado_pqr"] = "COMPLETADO";

        $respuesta = ModelPqr::mdlTerminarRevisionPQRS($tabla, $datos);

        if($respuesta == 'ok'){

            $infoPQR = ControladorPqr::ctrObtenerDato("pqr_pqrs", "id_pqr", $datos["id_pqr"]);

            if(!empty($datos["archivosPqr"]) && !empty($datos["archivosPqr"]["name"][0])){

                $rutaArchivo = "../../../archivos_vidamedical/pqrsf/archivos_pqrsf/".$infoPQR["id_pqr"]."/";

                if(!file_exists($rutaArchivo)){

                    mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");

                }

                foreach ($datos["archivosPqr"]["tmp_name"] as $key => $tmp_name) {

                    if($datos["archivosPqr"]["name"][$key]){

                        $aletorioArchivo = rand(0000001, 9999999);

                        $filenameArchivo = $aletorioArchivo.$datos["archivosPqr"]["name"][$key];
                        $sourceArchivo = $datos["archivosPqr"]["tmp_name"][$key];

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

                $rutaArchivo = $datos["rutaArchivosPqr"];

            }

            $updPQRSF = ModelPqr::mdlActualizarPQRSFArchivos($infoPQR["id_pqr"], $rutaArchivo);

            return $respuesta;

        }else{

            return 'error';

        }

        return $respuesta;

    }

    static public function ctrListaPendientesRevisionPQRS($usuario){

        $respuesta = ModelPqr::mdlListaPendientesRevisionPQRS($usuario);

        return $respuesta;
        
    }

    static public function ctrRevisarPQRS($idPQR, $usuario){

        $tabla = "pqr_pqrs";

        $valiRevisarPQRSF = ControladorPqr::ctrValidarRevisarPQRSF($idPQR);

        if(empty($valiRevisarPQRSF)){

            $datos = array(
                "id_pqr" => $idPQR,
                "usuario_revision" => $usuario,
                "fecha_ini_revision" => date('Y-m-d H:i:s'),
                "estado_pqr" => "REVISANDO"
            );

            $respuesta = ModelPqr::mdlRevisarPQRS($tabla, $datos);
            
            return $respuesta;
        
        }else{

            return 'asignada';

        }

    }

    static public function ctrValidarRevisarPQRSF($idPQR){

        $respuesta = ModelPqr::mdlValidarRevisarPQRSF($idPQR);

        return $respuesta;

    }

    static public function ctrListaRevisionesPQRS(){

        $respuesta = ModelPqr::mdlListaRevisionesPQRS();

        return $respuesta;

    }

    static public function ctrCrearPlanAccionPQRS($datos){

        $tabla = "pqr_pqrs";

        $datos["fecha_crea_pla_ac"] = date('Y-m-d H:i:s');
        $datos["estado_pqr"] = "REVISION";

        $respuesta = ModelPqr::mdlCrearPlanAccionPQRS($tabla, $datos);

        if($respuesta == 'ok'){

            $infoPQR = ControladorPqr::ctrObtenerDato("pqr_pqrs", "id_pqr", $datos["id_pqr"]);

            if(!empty($datos["archivosPqr"]) && !empty($datos["archivosPqr"]["name"][0])){

                $rutaArchivo = "../../../archivos_vidamedical/pqrsf/archivos_pqrsf/".$infoPQR["id_pqr"]."/";

                if(!file_exists($rutaArchivo)){

                    mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");

                }

                foreach ($datos["archivosPqr"]["tmp_name"] as $key => $tmp_name) {

                    if($datos["archivosPqr"]["name"][$key]){

                        $aletorioArchivo = rand(0000001, 9999999);

                        $filenameArchivo = $aletorioArchivo.$datos["archivosPqr"]["name"][$key];
                        $sourceArchivo = $datos["archivosPqr"]["tmp_name"][$key];

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


                $rutaArchivo = $datos["rutaArchivosPqr"];

            }

            $updPQRSF = ModelPqr::mdlActualizarPQRSFArchivos($infoPQR["id_pqr"], $rutaArchivo);

            return $respuesta;

        }else{

            return 'error';

        }

        return $respuesta;

    }

    static public function ctrListaPendientesPQRS($usuario){

        $tabla = "pqr_pqrs";

        $respuesta = ModelPqr::mdlListaPendientesPQRS($tabla, $usuario);

        return $respuesta;

    }

    static public function ctrGestionarPQRS($idPQR){

        $tabla = "pqr_pqrs";

        $datos = array(
            "id_pqr" => $idPQR,
            "estado_pqr" => "GESTION",
            "fecha_ini_gestor" => date('Y-m-d H:i:s')
        );

        $respuesta = ModelPqr::mdlGestionarPQRS($tabla, $datos);

        return $respuesta;

    }

    static public function ctrInfoPQR($idPQR){

        $tabla = "pqr_pqrs";

        $respuesta = ModelPqr::mdlInfoPQR($tabla, $idPQR);

        if(!empty($respuesta["ruta_archivos"])){

            if(is_dir($respuesta["ruta_archivos"])){
                
                $scanned_files = scandir($respuesta["ruta_archivos"]);
                $files = [];
                
                // Filtrar archivos y omitir '.' y '..'
                foreach ($scanned_files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $files[] = $file;
                    }
                }

                $respuesta["archivosPQRSF"] = $files;
                
            }
            
        }else{

            $respuesta["archivosPQRSF"] = 'SIN ARCHIVOS';

        }

        if(!empty($respuesta["ruta_archivo_res"])){

            if(is_dir($respuesta["ruta_archivo_res"])){


                $scanned_files_res = scandir($respuesta["ruta_archivo_res"]);
                $filesRes = [];

                foreach ($scanned_files_res as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $filesRes[] = $file;
                    }
                }
                
                $respuesta["archivosRespPQRSF"] = $filesRes;

            }


        }else{

            $respuesta["archivosRespPQRSF"] = 'SIN ARCHIVOS';

        }

        return $respuesta;

    }

    static public function ctrListaAsignacionesPQRS($usuario){

        $tabla = "pqr_pqrs";

        $respuesta = ModelPqr::mdlListaAsignacionesPQRS($tabla, $usuario);

        return $respuesta;

    }

    static public function ctrCrearPQRS($datos){

        if(!empty($datos)){

            $tabla = "pqr_pqrs";

            $tiempoNormativo = ControladorPqr::ctrObtenerDato("pqr_par_tipos_pqr", "tipo_pqr", $datos["tipo_pqr"]);

            $datos["tiempo_res_normativo"] = $tiempoNormativo["cantidad"] . " " . $tiempoNormativo["tiempo"];
            $datos["fecha_radicacion_pqr"] = date('Y-m-d H:i:s');
            $datos["pla_ac_pqr_recurrente"] = "";
            $datos["pla_ac_accion_efectiva"] = "";

            if(empty($datos["fecha_nacimiento_pac"])){

                $datos["fecha_nacimiento_pac"] = null;

            }

            //VALIDACION RECUERRENTE
            $respPQRSFRecurrente = ControladorPqr::ctrValidarPQRSFRecurrente($datos["trabajador_relacionado_pqr"]);
            $datos["pla_ac_pqr_recurrente"] = $respPQRSFRecurrente["pla_ac_pqr_recurrente"];
            $datos["pla_ac_accion_efectiva"] = $respPQRSFRecurrente["pla_ac_accion_efectiva"];

            //CALCULAR DIA MAX RESP PQRSF
            $datosCalculo = array(
                "fecha_pqr" => $datos["fecha_pqr"],
                "tipo_pqr" => $datos["tipo_pqr"],
                "cantidad" => $tiempoNormativo["cantidad"],
                "tiempo" => $tiempoNormativo["tiempo"]
            );

            $fechaMaxRespPQRSF = ControladorPqr::ctrCalcularMaxFechaRespuestaPQRSF($datosCalculo);

            $datos["fecha_max_resp_pqr"] = $fechaMaxRespPQRSF;

            $respuesta = ModelPqr::mdlCrearPQRS($tabla, $datos);

            if($respuesta == 'ok'){

                $infoPQR = ModelPqr::mdlObtenerPQRSF($datos);

                if(!empty($datos["archivosPqr"]) && !empty($datos["archivosPqr"]["name"][0])){

                    $rutaArchivo = "../../../archivos_vidamedical/pqrsf/archivos_pqrsf/".$infoPQR["id_pqr"]."/";
        
                    if(!file_exists($rutaArchivo)){
        
                        mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");
        
                    }
        
                    foreach ($datos["archivosPqr"]["tmp_name"] as $key => $tmp_name) {
        
                        if($datos["archivosPqr"]["name"][$key]){
        
                            $aletorioArchivo = rand(0000001, 9999999);
        
                            $filenameArchivo = $aletorioArchivo.$datos["archivosPqr"]["name"][$key];
                            $sourceArchivo = $datos["archivosPqr"]["tmp_name"][$key];
        
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

                $updPQRSF = ModelPqr::mdlActualizarPQRSFArchivos($infoPQR["id_pqr"], $rutaArchivo);

                return $respuesta;

            }else{
                return 'error';
            }


        }else{

            return 'error-datos';

        }

    }

    static public function ctrUsuariosPqrs($tipo){

        $tabla = "pqr_usuarios";

        $respuesta = ModelPqr::mdlUsuariosPqrs($tabla, $tipo);
        
        return $respuesta;

    }

    static public function ctrObtenerDato($tabla, $item, $valor){

        $respuesta = ModelPqr::mdlObtenerDato($tabla, $item, $valor);

        return $respuesta;

    }

    static public function ctrObtenerDatosActivos($tabla, $item, $valor){

        $respuesta = ModelPqr::mdlObtenerDatosActivos($tabla, $item, $valor);

        return $respuesta;

    }

}
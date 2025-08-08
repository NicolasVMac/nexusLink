<?php

class ControladorAutoevaluacion
{
    static public function ctrGuardarInfoGeneral($datos)
    {
        $tabla = "pamec_autoevaluacion";
        $respuesta = ModelAutoevaluacion::mdlGuardarInfoGeneral($tabla, $datos);

        if ($respuesta != "error") {

            $resp = array(
                "idAutoevaluacion" => $respuesta,
                "status" => "ok"
            );
        } else {

            $resp = array(
                "status" => "error"
            );
        }

        return $resp;
    }
    static public function ctrObtenerInfoAutoevaluacion($idAutoEva)
    {
        $tabla = "pamec_autoevaluacion";
        $respuesta = ModelAutoevaluacion::mdlObtenerInfoAutoevaluacion($idAutoEva, $tabla);

        return $respuesta;
    }
    static public function ctrListaPreguntasCualitativasAutoevaluacion()
    {

        $respuesta = ModelAutoevaluacion::mdlListaPreguntasCualitativasAutoevaluacion();

        return $respuesta;
    }
    static public function ctrGuardarInfoCualitativa($datos)
    {
        $tabla = "pamec_autoevaluacion_respuesta_cualitativa";
        $respuesta = ModelAutoevaluacion::mdlGuardarInfoCualitativa($tabla, $datos);

        return $respuesta;
    }
    static public function ctrActualizarInfoGeneralAutoevaluacion($datos)
    {
        $tabla = "pamec_autoevaluacion";
        $respuesta = ModelAutoevaluacion::mdlActualizarInfoGeneralAutoevaluacion($tabla, $datos);

        return $respuesta;
    }
    static public function ctrObtenerInfoCualitativaAutoevaluacion($idAutoEva)
    {
        $tabla = "pamec_autoevaluacion_respuesta_cualitativa";
        $respuesta = ModelAutoevaluacion::mdlObtenerInfoCualitativaAutoevaluacion($idAutoEva, $tabla);

        return $respuesta;
    }
    static public function ctrActualizarInfoCualitativa($datos)
    {
        $tabla = "pamec_autoevaluacion_respuesta_cualitativa";
        $respuesta = ModelAutoevaluacion::mdlActualizarInfoCualitativa($tabla, $datos);

        return $respuesta;
    }
    static public function ctrListaDimensionesCuantitativaAutoevaluacion()
    {
        $tabla = "pamec_par_escalas_calificacion_cuantitativa";
        $respuesta = ModelAutoevaluacion::mdlListaDimensionesCuantitativaAutoevaluacion($tabla);

        return $respuesta;
    }
    static public function ctrListaVariablesDimension($dimension)
    {
        $tabla = "pamec_par_escalas_calificacion_cuantitativa";
        $respuesta = ModelAutoevaluacion::mdlListaVariablesDimension($tabla, $dimension);

        return $respuesta;
    }
    static public function ctrListaRespuestasVariables($dimension, $variable)
    {
        $tabla = "pamec_par_escalas_calificacion_cuantitativa";
        $respuesta = ModelAutoevaluacion::mdlListaRespuestasVariables($tabla, $dimension, $variable);

        return $respuesta;
    }
    static public function ctrGuardarInfoCuantitativa($datos)
    {
        $tabla = "pamec_autoevaluacion_respuesta_cuantitativa";
        $respuesta = ModelAutoevaluacion::mdlGuardarInfoCuantitativa($tabla, $datos);

        return $respuesta;
    }
    static public function ctrObtenerInfoCuantitativaAutoevaluacion($idAutoEva)
    {
        $respuesta = ModelAutoevaluacion::mdlObtenerInfoCuantitativaAutoevaluacion($idAutoEva);

        return $respuesta;
    }
    static public function ctrActualizarInfoCuantitativa($datos)
    {
        $tabla = "pamec_autoevaluacion_respuesta_cuantitativa";
        $respuesta = ModelAutoevaluacion::mdlActualizarInfoCuantitativa($tabla, $datos);

        return $respuesta;
    }
    static public function ctrGuardarInfoPriorizacion($datos)
    {
        $tabla = "pamec_autoevaluacion_priorizacion_respuesta";
        $respuesta = ModelAutoevaluacion::mdlGuardarInfoPriorizacion($tabla, $datos);

        return $respuesta;
    }
    static public function ctrListaPriorizacionesAutoevaluacion($idAutoEva)
    {
        $tabla = "pamec_autoevaluacion_priorizacion_respuesta";
        $respuesta = ModelAutoevaluacion::mdlListaPriorizacionesAutoevaluacion($idAutoEva, $tabla);

        return $respuesta;
    }
    static public function ctrEliminarPriorizacionAutoEvaluacion($id_respuesta_priorizacion, $user)
    {
        $tabla = "pamec_autoevaluacion_priorizacion_respuesta";
        $respuesta = ModelAutoevaluacion::mdlEliminarPriorizacionAutoEvaluacion($tabla, $id_respuesta_priorizacion, $user);

        return $respuesta;
    }
    static public function ctrListarOpcionesRespPriorizacion()
    {
        $idVariables = ModelAutoevaluacion::mdlObtenerVariablesPriorizacion();
        $data = array();

        foreach ($idVariables as $id_variable_priorizacion) {
            $key =  $id_variable_priorizacion;
            $data[$key] = ModelAutoevaluacion::mdlListarOpcionesRespPriorizacion($id_variable_priorizacion);
        }
        return $data;
    }
    static public function ctrTerminarGestionAutoevaluacion($datos)
    {
        $respuesta = ModelAutoevaluacion::mdlTerminarGestionAutoevaluacion($datos);

        return $respuesta;
    }
    static public function ctrListaMisAutoevaluaciones($user)
    {
        $respuesta = ModelAutoevaluacion::mdlListaMisAutoevaluaciones($user);

        return $respuesta;
    }
    static public function ctrListaAutoevaluacionesVerEvaluador()
    {
        $respuesta = ModelAutoevaluacion::mdlListaAutoevaluacionesVerEvaluador();

        return $respuesta;
    }


    static public function ctrCargarArchivosEvidenciaAutoevaluacion($datos)
    {

        $tabla = "pamec_autoevaluacion_archivos_evidencia";
        $dateId = $datos['idAutoEva'];

        if (!empty($datos)) {

            if (!empty($datos["archivoEvidencia"]) && !empty($datos["archivoEvidencia"]["name"][0])) {

                $rutaArchivo = "../../../archivos_vidamedical/pamec/autoevaluacion_archivos/" . $dateId . "/";

                if (!file_exists($rutaArchivo)) {

                    mkdir($rutaArchivo, 0777, true) or die("No se puede crear el directorio");
                }

                foreach ($datos["archivoEvidencia"]["tmp_name"] as $key => $tmp_name) {

                    if ($datos["archivoEvidencia"]["name"][$key]) {

                        $aletorioArchivo = rand(0000001, 9999999);

                        $filenameArchivo = $aletorioArchivo . '-' . $datos["archivoEvidencia"]["name"][$key];
                        $sourceArchivo = $datos["archivoEvidencia"]["tmp_name"][$key];

                        $dirArchivo = opendir($rutaArchivo);
                        $target_path_archivo = $rutaArchivo . "/" . $filenameArchivo;

                        if (move_uploaded_file($sourceArchivo, $target_path_archivo)) {
                            // $save = ModelAutoevaluacion::mdlCargarArchivosEvidenciaAutoevaluacion($tabla, $datos, $target_path_archivo);
                            // if ($save == 'ok') {
                            $resultado = "ok";
                            // }
                        } else {

                            $resultado = "error";
                        }

                        closedir($dirArchivo);
                    }
                }
            }

            $datos["ruta_archivo_evidencia"] = $rutaArchivo;

            $saveCarpeta = ModelAutoevaluacion::mdlCargarCarpetaArchivosAutoevaluacion($datos);

            if ($saveCarpeta == 'ok') {

                return 'ok';
            } else {

                return 'error';
            }
        } else {

            return 'error-datos';
        }
    }

    static public function ctrInfoAutoevaluacionArchivos($idAutoEva)
    {
        $tabla = "pamec_autoevaluacion";
        $respuesta = ModelAutoevaluacion::mdlInfoAutoevaluacionArchivos($tabla, $idAutoEva);

        if (!empty($respuesta["ruta_archivo_evidencia"])) {

            $ruta = $respuesta["ruta_archivo_evidencia"];
            $archivos = [];

            if (is_dir($ruta)) {
                foreach (scandir($ruta) as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $archivos[] = $file;
                    }
                }
            }

            $respuesta["archivos"] = $archivos;
            $respuesta["ruta_archivos"] = $ruta;
        } else {
            $respuesta["archivos"] = 'SIN ARCHIVOS';
        }

        return $respuesta;
    }

    static public function ctrEliminarArchivoEvidencia($datos)
    {
        $tabla = "pamec_log_archivos_eliminados";
        $log = ModelAutoevaluacion::mdlEliminarArchivoEvidencia($tabla, $datos);

        if ($log == 'ok') {
            $rutaCompleta = $datos["ruta_archivo"] . "/" . $datos["archivo"];
            if (file_exists($rutaCompleta) && unlink($rutaCompleta)) {
                return 'ok';
            } else {
                return 'error';
            }
        } else {
            return 'error';
        }
    }

    static public function ctrVerificarPeriodosCreacion() {

        $tabla="pamec_par_periodos_autoevaluacion";

        $respuesta= ModelAutoevaluacion::mdlVerificarPeriodosCreacion($tabla);

        return $respuesta;
    }

    static public function ctrGuardarPeriodoAutoevaluacion($datos) {

        $tabla="pamec_par_periodos_autoevaluacion";

        $respuesta= ModelAutoevaluacion::mdlGuardarPeriodoAutoevaluacion($datos,$tabla);

        return $respuesta;
    }

    static public function ctrListaPeriodosAutoevaluacionPamec()
    {
        $tabla = "pamec_par_periodos_autoevaluacion";
        $respuesta = ModelAutoevaluacion::mdlListaPeriodosAutoevaluacionPamec($tabla);

        return $respuesta;
    }
    
    static public function ctrPeriodoAutoevaluacionActivo(){
        $tabla = "pamec_par_periodos_autoevaluacion";
        $respuesta = ModelAutoevaluacion::mdlPeriodoAutoevaluacionActivo($tabla);
        return $respuesta;
    }

    static public function ctrSedesNoEvaluadasPorEstandar($codigo, $periodo) {
        $sedesEvaluadasRaw = ModelAutoevaluacion::mdlSedesEvaluadasPorEstandar($codigo, $periodo);
        $todasSedes = ModelAutoevaluacion::mdlTodasSedes();
    
        $sedesEvaluadas = [];
        foreach ($sedesEvaluadasRaw as $cadena) {
            $partes = explode('-', $cadena);
            foreach ($partes as $sede) {
                $sede = trim($sede);
                if (!in_array($sede, $sedesEvaluadas)) {
                    $sedesEvaluadas[] = $sede;
                }
            }
        }
    
        $noEvaluadas = array_values(array_diff($todasSedes, $sedesEvaluadas));

        // var_dump($todasSedes); 
        return $noEvaluadas;
    }
    
    static public function ctrProgramasNoEvaluadosPorEstandar($codigo, $periodo) {
        $programasEvaluadosRaw = ModelAutoevaluacion::mdlProgramasEvaluadosPorEstandar($codigo, $periodo);
        $todosProgramas = ModelAutoevaluacion::mdlTodosProgramas();
    
        $programasEvaluados = [];
        foreach ($programasEvaluadosRaw as $cadena) {
            $partes = explode('-', $cadena);
            foreach ($partes as $programa) {
                $programa = trim($programa);
                if (!in_array($programa, $programasEvaluados)) {
                    $programasEvaluados[] = $programa;
                }
            }
        }
        $noEvaluados = array_values(array_diff($todosProgramas, $programasEvaluados));

        // var_dump($todosProgramas);
        return $todosProgramas;
    }

    static public function ctrConsultarAutoevaluaciones($datos){

        $respuesta = ModelAutoevaluacion::mdlConsultarAutoevaluaciones($datos);

        return $respuesta;

    }
    
    static public function ctrGuardarNoAplicaAutoevaluacion($idAutoeva,$user)
    {
        $respuesta = ModelAutoevaluacion::mdlGuardarNoAplicaAutoevaluacion($idAutoeva,$user);

        return $respuesta;
    }
    static public function ctrListaPriorizacionesGeneral()
    {
        $tabla = "pamec_autoevaluacion_priorizacion_respuesta";
        $respuesta = ModelAutoevaluacion::mdlListaPriorizacionesGeneral($tabla);

        return $respuesta;
    }

    
}

<?php

require_once "../../plugins/Spout/src/Spout/Autoloader/autoload.php";

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Type;


class ControladorEncuestasReportes{

    static public function ctrListaSolicitudesReportesConsolidados($tipoEncuesta){

        $respuesta = ModelEncuestasReportes::mdlListaSolicitudesReportesConsolidados($tipoEncuesta);

        return $respuesta;

    }


    static public function ctrInfoConsolidadoCalificacionSegmento($tipoEncuesta, $idBaseEncuesta){

        $respuesta = ModelEncuestasReportes::mdlInfoConsolidadoCalificacionSegmento($tipoEncuesta, $idBaseEncuesta);

        return $respuesta;

    }

    public static function ctrReporteGeneralAutoinmunes($idBaseEncuesta, $idEncuProceso){

        $writer = WriterEntityFactory::createXLSXWriter();

        $rutaReportes = "../../../archivos_nexuslink/encuestas/archivos_reportes_autoinmunes/";
        $nameFile = date('YmdHis')."-Reporte General Autoinmunes.xlsx";
        $rutaFinal = $rutaReportes.$nameFile;

        $writer->openToFile($rutaFinal);

        $infoBase = ModelEncuestasReportes::mdlInfoBaseEncuesta($idBaseEncuesta);

        $title = ['NOMBRE BASE', $infoBase["nombre"], 'TIPO ENCUESTA', $infoBase["tipo_encuestas"], 'NIVEL CONFIANZA', $infoBase["nivel_confianza"], 'MARGEN ERROR', $infoBase["margen_error"],
            "CANTIDAD ENCUESTAS CARGADAS", $infoBase["cantidad"], "MUESTRA", $infoBase["muestra"], "ESTADO BASE", $infoBase["estado"]
        ];

        $writer->addRow(WriterEntityFactory::createRowFromArray($title));
        
        $space1 = [];
        $space2 = [];
        
        $writer->addRow(WriterEntityFactory::createRowFromArray($space1));
        $writer->addRow(WriterEntityFactory::createRowFromArray($space2));

        $header = [
            '# ENCUESTA', 'FECHA AUDITORIA', 'PROFESIONAL AUDITO', 'NO. HISTORIA', 'NOMBRES Y APELLIDOS DEL PACIENTE',
            'EDAD', 'SEXO', 'ESPECIALIDAD', 'PROFESIONAL AUDITADO', 'SEDE', 'EPS', 'FECHA ATENCION', 'MODALIDAD CONSULTA'
        ];

        $segmentosEncuesta = ModelEncuestasReportes::mdlSegmentosEncuestaAutoinmunes($idEncuProceso);

        foreach ($segmentosEncuesta as $key => $valueSegmento) {

            $preguntasEncuesta = ModelEncuestasReportes::mdlObtenerPreguntasEncuestasSegmentoAutoinmunes($valueSegmento["id_encu_segmento"]);
    
            foreach ($preguntasEncuesta as $key => $value) {
    
                array_push($header, $value["titulo_descripcion"]);
    
            }

            if($valueSegmento["segmento"] != "CALIFICACION"){

                if($valueSegmento["id_encu_segmento"] == 4){
    
                    $titleOrdenado = "CALIFICACION REGISTRO, REVISION Y ANALISIS DE LOS PARACLINICOS DE RUTINA - ORDENADO";
                    $titleAnalizado = "CALIFICACION REGISTRO, REVISION Y ANALISIS DE LOS PARACLINICOS DE RUTINA - ANALIZADO";
    
                    array_push($header, $titleOrdenado);
                    array_push($header, $titleAnalizado);
    
                }else{
    
                    $title = "CALIFICACION {$valueSegmento["segmento"]}";
    
                    array_push($header, $title);
    
                }

            }


        }

        
        // array_push($header, 'TEST 1');

        $writer->addRow(WriterEntityFactory::createRowFromArray($header));

        $tipoEncuesta = "AUTOINMUNES";

        $encuestas = ControladorEncuestasReportes::ctrObtenerEncuestasFinalizadas($idBaseEncuesta, $tipoEncuesta, $idEncuProceso);

        foreach ($encuestas as $key => $valueEncuesta) {

            $especialidad = "";

            if($valueEncuesta["proceso"] == "MEDICO O ESPECIALISTA"){

                $especialidad = $valueEncuesta["especialidad"];
                $profesionalAuditado = $valueEncuesta["profesional_auditado"];

            }else{

                $especialidad = $valueEncuesta["proceso"];
                $profesionalAuditado = $valueEncuesta["nombre_usuario"];

            }

            $data = array(
                $valueEncuesta["id_encuesta"], $valueEncuesta["fecha_fin"], $valueEncuesta["nombre"], $valueEncuesta["no_historia_clinica"], $valueEncuesta["nombre_paciente"], $valueEncuesta["edad"],
                $valueEncuesta["sexo"], $especialidad, $profesionalAuditado, $valueEncuesta["sede"], $valueEncuesta["eps"], $valueEncuesta["fecha_atencion"], $valueEncuesta["modalidad_consulta"]
            );

            // $segmentosEncuesta = ModelEncuestasReportes::mdlSegmentosEncuestaAutoinmunes($idEncuProceso);

            foreach ($segmentosEncuesta as $key => $valueSegmentoRes) {

                $respuestasEncuesta = ModelEncuestasReportes::mdlObtenerRespuestasEncuesta($valueEncuesta["id_encuesta"], $valueSegmentoRes["id_encu_segmento"]);

                foreach ($respuestasEncuesta as $key => $valueRespuesta) {
                
                    array_push($data, $valueRespuesta["respuesta_pre"]);
                
                }

                if($valueSegmentoRes["id_encu_segmento"] == 4){
    
                    $calificacionOrdenado = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], 4, $idEncuProceso);
                    $calificacionAnalizado = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], 123, $idEncuProceso);

                    $data[] = $calificacionOrdenado;
                    $data[] = $calificacionAnalizado;

                }else{

                    $calificacion = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], $valueSegmentoRes["id_encu_segmento"], $idEncuProceso);

                    $data[] = $calificacion;
    
                }

            }



            $writer->addRow(WriterEntityFactory::createRowFromArray($data));

        }

        $writer->close();
        
        echo json_encode([
            'success' => true
        ]);
        
        exit();


    }

    static public function ctrGenerarReporteGeneralConsolidado($idBaseEncuesta, $idEncuProceso, $tipoEncuesta, $usuario){

        $infoProceso = ModelEncuestasReportes::mdlObtenerInfoEncuProceso($idEncuProceso, $tipoEncuesta);

        $nombreArchivo = date('YmdHis').'-CONSOLIDADO '.$infoProceso["proceso"].'.xlsx';

        $datos = array(
            "id_base_encu" => $idBaseEncuesta,
            "id_encu_proceso" => $idEncuProceso,
            "proceso_encuesta" => $infoProceso["proceso"],
            "nombre_archivo" => $nombreArchivo,
            "tipo_encuesta" => $tipoEncuesta,
            "usuario_crea" => $usuario
        );

        $respuesta = ModelEncuestasReportes::mdlGenerarReporteGeneralVih($datos);

        return $respuesta;

    }

    public static function ctrReporteGeneralVih($idBaseEncuesta, $idEncuProceso){

        $writer = WriterEntityFactory::createXLSXWriter();

        $rutaReportes = "../../../archivos_nexuslink/encuestas/archivos_reportes_vih/";
        $nameFile = date('YmdHis')."-Reporte General VIH.xlsx";
        $rutaFinal = $rutaReportes.$nameFile;

        $writer->openToFile($rutaFinal);

        $infoBase = ModelEncuestasReportes::mdlInfoBaseEncuesta($idBaseEncuesta);

        $title = ['NOMBRE BASE', $infoBase["nombre"], 'TIPO ENCUESTA', $infoBase["tipo_encuestas"], 'NIVEL CONFIANZA', $infoBase["nivel_confianza"], 'MARGEN ERROR', $infoBase["margen_error"],
            "CANTIDAD ENCUESTAS CARGADAS", $infoBase["cantidad"], "MUESTRA", $infoBase["muestra"], "ESTADO BASE", $infoBase["estado"]
        ];

        $writer->addRow(WriterEntityFactory::createRowFromArray($title));
        
        $space1 = [];
        $space2 = [];
        
        $writer->addRow(WriterEntityFactory::createRowFromArray($space1));
        $writer->addRow(WriterEntityFactory::createRowFromArray($space2));

        $header = [
            '# ENCUESTA', 'FECHA AUDITORIA', 'PROFESIONAL AUDITO', 'NO. HISTORIA', 'NOMBRES Y APELLIDOS DEL PACIENTE',
            'EDAD', 'SEXO', 'ESPECIALIDAD', 'PROFESIONAL AUDITADO', 'SEDE', 'EPS', 'FECHA ATENCION', 'MODALIDAD CONSULTA'
        ];

        $segmentosEncuesta = ModelEncuestasReportes::mdlSegmentosEncuesta($idEncuProceso);

        foreach ($segmentosEncuesta as $key => $valueSegmento) {

            $preguntasEncuesta = ModelEncuestasReportes::mdlObtenerPreguntasEncuestasSegmentoVih($valueSegmento["id_encu_segmento"]);
    
            foreach ($preguntasEncuesta as $key => $value) {
    
                array_push($header, $value["titulo_descripcion"]);
    
            }

            if($valueSegmento["segmento"] != "CALIFICACION"){

                if($valueSegmento["id_encu_segmento"] == 59){
    
                    $titleOrdenado = "CALIFICACION REGISTRO, REVISION Y ANALISIS DE LOS PARACLINICOS DE RUTINA - ORDENADO";
                    $titleAnalizado = "CALIFICACION REGISTRO, REVISION Y ANALISIS DE LOS PARACLINICOS DE RUTINA - ANALIZADO";
    
                    array_push($header, $titleOrdenado);
                    array_push($header, $titleAnalizado);
    
                }else{
    
                    $title = "CALIFICACION {$valueSegmento["segmento"]}";
    
                    array_push($header, $title);
    
                }

            }


        }

        
        // array_push($header, 'TEST 1');

        $writer->addRow(WriterEntityFactory::createRowFromArray($header));

        $tipoEncuesta = "VIH";

        $encuestas = ControladorEncuestasReportes::ctrObtenerEncuestasFinalizadas($idBaseEncuesta, $tipoEncuesta, $idEncuProceso);

        foreach ($encuestas as $key => $valueEncuesta) {

            $especialidad = "";

            if($valueEncuesta["proceso"] == "MEDICINA"){

                $especialidad = $valueEncuesta["especialidad"];
                $profesionalAuditado = $valueEncuesta["profesional_auditado"];

            }else{

                $especialidad = $valueEncuesta["proceso"];
                $profesionalAuditado = $valueEncuesta["nombre_usuario"];

            }

            $data = array(
                $valueEncuesta["id_encuesta"], $valueEncuesta["fecha_fin"], $valueEncuesta["nombre"], $valueEncuesta["no_historia_clinica"], $valueEncuesta["nombre_paciente"], $valueEncuesta["edad"],
                $valueEncuesta["sexo"], $especialidad, $profesionalAuditado, $valueEncuesta["sede"], $valueEncuesta["eps"], $valueEncuesta["fecha_atencion"], $valueEncuesta["modalidad_consulta"]
            );

            // $segmentosEncuesta = ModelEncuestasReportes::mdlSegmentosEncuesta($idEncuProceso);

            foreach ($segmentosEncuesta as $key => $valueSegmentoRes) {

                $respuestasEncuesta = ModelEncuestasReportes::mdlObtenerRespuestasEncuesta($valueEncuesta["id_encuesta"], $valueSegmentoRes["id_encu_segmento"]);

                foreach ($respuestasEncuesta as $key => $valueRespuesta) {
                
                    array_push($data, $valueRespuesta["respuesta_pre"]);
                
                }

                if($valueSegmentoRes["id_encu_segmento"] == 59){
    
                    $calificacionOrdenado = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], 59, $idEncuProceso);
                    $calificacionAnalizado = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], 124, $idEncuProceso);

                    $data[] = $calificacionOrdenado;
                    $data[] = $calificacionAnalizado;

                }else{

                    $calificacion = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], $valueSegmentoRes["id_encu_segmento"], $idEncuProceso);

                    $data[] = $calificacion;
    
                }

            }



            $writer->addRow(WriterEntityFactory::createRowFromArray($data));

        }

        $writer->close();
        
        echo json_encode([
            'success' => true
        ]);
        
        exit();

    }

    public static function ctrReporteGeneralVihTest($idBaseEncuesta, $idEncuProceso){

        $writer = WriterEntityFactory::createXLSXWriter();

        // Establecer las cabeceras para la descarga del archivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Reporte General VIH.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->openToBrowser('Reporte General VIH.xlsx');

        $header = [
            '# ENCUESTA', 'FECHA AUDITORIA', 'PROFESIONAL AUDITO', 'NO. HISTORIA', 'NOMBRES Y APELLIDOS DEL PACIENTE',
            'EDAD', 'SEXO', 'ESPECIALIDAD', 'PROFESIONAL AUDITADO', 'SEDE', 'EPS', 'FECHA ATENCION', 'MODALIDAD CONSULTA'
        ];

        $segmentosEncuesta = ModelEncuestasReportes::mdlSegmentosEncuesta($idEncuProceso);

        foreach ($segmentosEncuesta as $key => $valueSegmento) {

            $preguntasEncuesta = ModelEncuestasReportes::mdlObtenerPreguntasEncuestasSegmentoVih($valueSegmento["id_encu_segmento"]);
    
            foreach ($preguntasEncuesta as $key => $value) {
    
                array_push($header, $value["titulo_descripcion"]);
    
            }

            if($valueSegmento["segmento"] != "CALIFICACION"){

                if($valueSegmento["id_encu_segmento"] == 59){
    
                    $titleOrdenado = "CALIFICACION REGISTRO, REVISION Y ANALISIS DE LOS PARACLINICOS DE RUTINA - ORDENADO";
                    $titleAnalizado = "CALIFICACION REGISTRO, REVISION Y ANALISIS DE LOS PARACLINICOS DE RUTINA - ANALIZADO";
    
                    array_push($header, $titleOrdenado);
                    array_push($header, $titleAnalizado);
    
                }else{
    
                    $title = "CALIFICACION {$valueSegmento["segmento"]}";
    
                    array_push($header, $title);
    
                }

            }


        }

        
        // array_push($header, 'TEST 1');

        $writer->addRow(WriterEntityFactory::createRowFromArray($header));

        $tipoEncuesta = "VIH";

        $encuestas = ControladorEncuestasReportes::ctrObtenerEncuestasFinalizadas($idBaseEncuesta, $tipoEncuesta, $idEncuProceso);

        foreach ($encuestas as $key => $valueEncuesta) {

            $data = array(
                $valueEncuesta["id_encuesta"], $valueEncuesta["fecha_fin"], $valueEncuesta["nombre"], $valueEncuesta["no_historia_clinica"], $valueEncuesta["nombre_paciente"], $valueEncuesta["edad"],
                $valueEncuesta["sexo"], $valueEncuesta["especialidad"], $valueEncuesta["profesional_auditado"], $valueEncuesta["sede"], $valueEncuesta["eps"], $valueEncuesta["fecha_atencion"], $valueEncuesta["modalidad_consulta"]
            );

            $segmentosEncuesta = ModelEncuestasReportes::mdlSegmentosEncuesta($idEncuProceso);

            foreach ($segmentosEncuesta as $key => $valueSegmentoRes) {

                $respuestasEncuesta = ModelEncuestasReportes::mdlObtenerRespuestasEncuesta($valueEncuesta["id_encuesta"], $valueSegmentoRes["id_encu_segmento"]);

                foreach ($respuestasEncuesta as $key => $valueRespuesta) {
                
                    array_push($data, $valueRespuesta["respuesta_pre"]);
                
                }

                if($valueSegmentoRes["id_encu_segmento"] == 59){

                    // $detalleOrdenado = ModelEncuestasReportes::mdlEncuestaGestionDetalle($valueEncuesta["id_encuesta"], 59);
                    // $detalleAnalizado = ModelEncuestasReportes::mdlEncuestaGestionDetalle($valueEncuesta["id_encuesta"], 124);

                    // if(empty($detalleOrdenado)){

                    //     $calificacionSegmengoEncuestaOrdenado = ModelEncuestasReportes::mdlCalificacionSegmentoEncuesta($valueEncuesta["id_encuesta"], 59);
                        
                    //     $saveCalificacionParaclinicosOrdenado = ControladorEncuestasReportes::ctrSaveCalificacionParaclinicos($valueEncuesta["id_encuesta"], $idEncuProceso, 59, $calificacionSegmengoEncuestaOrdenado["calificacion_segmento"]);
                        
                    //     $calificacionOrdenado = $calificacionSegmengoEncuestaOrdenado["calificacion_segmento"];
    
                    //     array_push($data, $calificacionOrdenado);

                        
                    // }else{

                    //     $calificacionTotalOrdenado = $detalleOrdenado["calificacion"];
                    //     // $calificacionTotalAnalizado = $detalleAnalizado["calificacion"];

                    //     $data[] = $calificacionTotalOrdenado;
                    //     // array_push($data, $calificacionTotalAnalizado);

                    // }

                    // if(empty($detalleAnalizado)){

                    //     $calificacionSegmengoEncuestaAnalizado = ModelEncuestasReportes::mdlCalificacionSegmentoEncuesta($valueEncuesta["id_encuesta"], 124);

                    //     $saveCalificacionParaclinicosAnalizado = ControladorEncuestasReportes::ctrSaveCalificacionParaclinicos($valueEncuesta["id_encuesta"], $idEncuProceso, 124, $calificacionSegmengoEncuestaAnalizado["calificacion_segmento"]);
    
                    //     $calificacionAnalizado = $calificacionSegmengoEncuestaOrdenado["calificacion_segmento"];

                    //     array_push($data, $calificacionAnalizado);

                        
                    // }else{

                    //     // $calificacionTotalOrdenado = $detalleOrdenado["calificacion"];
                    //     $calificacionTotalAnalizado = $detalleAnalizado["calificacion"];

                    //     // array_push($data, $calificacionTotalOrdenado);
                    //     array_push($data, $calificacionTotalAnalizado);

                    // }


    
                }

                $detalle = ModelEncuestasReportes::mdlEncuestaGestionDetalle($valueEncuesta["id_encuesta"], $valueSegmentoRes["id_encu_segmento"]);
                
                if(empty($detalle)){

                    // $calificacionSegmengoEncuesta = ModelEncuestasReportes::mdlCalificacionSegmentoEncuesta($valueEncuesta["id_encuesta"], $valueSegmentoRes["id_encu_segmento"]);
                    
                    // if(!empty($calificacionSegmengoEncuesta)){

                    //     $datosDetalle = array(
                    //         "id_encuesta" => $valueEncuesta["id_encuesta"],
                    //         "id_encu_proceso" => $idEncuProceso,
                    //         "id_encu_segmento" => $valueSegmentoRes["id_encu_segmento"],
                    //         "segmento" => $valueSegmentoRes["segmento"],
                    //         "calificacion" => $calificacionSegmengoEncuesta["calificacion_segmento"],
                    //         "usuario_crea" => "ADMIN"
                    //     );

                    //     $saveDetalle = ModelEncuestasReportes::mdlGuardarDetalleEncuesta($datosDetalle);

                    // }


                    // array_push($data, $calificacionSegmengoEncuesta["calificacion_segmento"]);
                    
                    
                }else{
                    
                    $calificacionTotal = $detalle["calificacion"];
                    array_push($data, $calificacionTotal);
                    // array_push($data, "CALI TOTAL");

                }
    
    

            }



            // $writer->addRow(WriterEntityFactory::createRowFromArray(array_slice($data, 0, -1)));
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));

        }

        // $data = ['1', '2'];
        // $writer->addRow(WriterEntityFactory::createRowFromArray($data));

        
        $writer->close();
        exit();
        
        echo json_encode([
            'success' => true
        ]);
        


    }

    static public function obtenerNotaSegmentoEncuesta($idEncuesta, $idEncuSegmento, $idEncuProceso){

        $infoSegmento = ModelEncuestasReportes::mdlInfoSegmento($idEncuSegmento);

        if($infoSegmento["porcentaje_general"] != "0"){
            
            $detalleEncuesta = ModelEncuestasReportes::mdlEncuestaGestionDetalle($idEncuesta, $idEncuSegmento);
            
            if(!empty($detalleEncuesta) && !is_null($detalleEncuesta["calificacion"])){
                
                // $save = ControladorEncuestasReportes::ctrSaveCalificacionParaclinicos($idEncuesta, $idEncuProceso, $idEncuSegmento, $detalleEncuesta["calificacion"]);
            
                return $detalleEncuesta["calificacion"];
            
            }else{

                //ELIMINAR VACIO
                $deleteVacio = ModelEncuestasReportes::mdlEliminarRespuestaSinCalificacion($idEncuesta, $idEncuSegmento);
                
                $calificacionEncuestaSegmento = ModelEncuestasReportes::mdlCalificacionSegmentoEncuesta($idEncuesta, $idEncuSegmento);
                
                if(!empty($calificacionEncuestaSegmento) && !is_null($calificacionEncuestaSegmento["calificacion_segmento"])) {
                    
                    $save = ControladorEncuestasReportes::ctrSaveCalificacionParaclinicos($idEncuesta, $idEncuProceso, $idEncuSegmento, $calificacionEncuestaSegmento["calificacion_segmento"]);
                    return $calificacionEncuestaSegmento["calificacion_segmento"];
                    
                }else{
                    
                    $save = ControladorEncuestasReportes::ctrSaveCalificacionParaclinicos($idEncuesta, $idEncuProceso, $idEncuSegmento, 0);
                    return "0.00";
                    
                }
                
            }
        
        }
    }

    static public function ctrSaveCalificacionParaclinicos($idEncuesta, $idEncuProceso, $idEncuSegmento, $calificacionSegmento){

        $infoSegmento = ModelEncuestasReportes::mdlInfoSegmento($idEncuSegmento);

        $datosDetalle = array(
            "id_encuesta" => $idEncuesta,
            "id_encu_proceso" => $idEncuProceso,
            "id_encu_segmento" => $idEncuSegmento,
            "segmento" => $infoSegmento["segmento"],
            "calificacion" => $calificacionSegmento,
            "usuario_crea" => "ADMIN"
        );

        $saveDetalle = ModelEncuestasReportes::mdlGuardarDetalleEncuesta($datosDetalle);


    }

    static public function ctrObtenerEncuestasFinalizadas($idBaseEncuesta, $tipoEncuesta, $idEncuProceso){

        $respuesta = ModelEncuestasReportes::mdlObtenerEncuestasFinalizadas($idBaseEncuesta, $tipoEncuesta, $idEncuProceso);

        return $respuesta;

    }

    static public function ctrObtenerProcesosEncuestaGeneral($tipoEncuesta){

        $respuesta = ModelEncuestasReportes::mdlObtenerProcesosEncuestaGeneral($tipoEncuesta);

        return $respuesta;
        
    }


    static public function ctrPreguntasSegmentoIntrumentoProfesional($idBaseEncuesta, $idEncuSegmento, $idInstrumento, $auditor){

        $respuesta = ModelEncuestasReportes::mdlPreguntasSegmentoIntrumentoProfesional($idBaseEncuesta, $idEncuSegmento, $idInstrumento, $auditor);

        return $respuesta;

    }

    static public function ctrSegmentosInstrumentoProfesional($idBaseEncuesta, $idInstrumento, $auditor){

        $respuesta = ModelEncuestasReportes::mdlSegmentosInstrumentoProfesional($idBaseEncuesta, $idInstrumento, $auditor);

        return $respuesta;

    }

    static public function ctrListaAuditoresInstrumento($idBaseEncuesta, $idInstrumento){

        $respuesta = ModelEncuestasReportes::mdlListaAuditoresInstrumento($idBaseEncuesta, $idInstrumento);

        return $respuesta;

    }

    static public function ctrListaAuditoresEspecialidad($idBaseEncuesta, $tipoEncuesta, $especialidad){

        if($tipoEncuesta == 'VIH'){

            $idEncuProceso = 13;

        }else{

            $idEncuProceso = 3;

        }

        $respuesta = ModelEncuestasReportes::mdlListaAuditoresEspecialidad($idBaseEncuesta, $idEncuProceso, $especialidad);

        return $respuesta;

    }

    static public function ctrListaEspecialidadBase($idBaseEncuesta){

        $respuesta = ModelEncuestasReportes::mdlListaEspecialidadBase($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrInfoReportConsoMedicoEspecialista($idBaseEncuesta, $tipoEncuesta, $tipoProfesional){

        $respuesta = ModelEncuestasReportes::mdlInfoReportConsoMedicoEspecialista($idBaseEncuesta, $tipoEncuesta, $tipoProfesional);

        return $respuesta;
        
    }

    static public function ctrInfoReportTratamientoFormulado($idBaseEncuesta){
        
        $respuesta = ModelEncuestasReportes::mdlInfoReportTratamientoFormulado($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrInfoDatosIndicador2($idBaseEncuesta, $procesoEncu, $tipoEncuesta){

        $respuesta = ModelEncuestasReportes::mdlInfoDatosIndicador2($idBaseEncuesta, $procesoEncu, $tipoEncuesta);

        return $respuesta;

    }

    static public function ctrInfoDatosIndicador1($idBaseEncuesta, $procesoEncu, $tipoEncuesta){

        $respuesta = ModelEncuestasReportes::mdlInfoDatosIndicador1($idBaseEncuesta, $procesoEncu, $tipoEncuesta);

        return $respuesta;

    }

    static public function ctrPreguntasSegmentoIntrumento($idBaseEncuesta, $idEncuSegmento){

        $respuesta = ModelEncuestasReportes::mdlPreguntasSegmentoIntrumento($idBaseEncuesta, $idEncuSegmento);

        return $respuesta;

    }

    static public function ctrSegmentosInstrumento($idBaseEncuesta, $idInstrumento){

        $respuesta = ModelEncuestasReportes::mdlSegmentosInstrumento($idBaseEncuesta, $idInstrumento);

        return $respuesta;

    }

    static public function ctrListaInstrumentos($tipoEncuesta){

        $tabla = "encuestas_procesos";

        $respuesta = ModelEncuestasReportes::mdlListaInstrumentos($tabla, $tipoEncuesta);

        return $respuesta;

    }

    static public function ctrInfoReporteEspecidalidadxProfesional($idBaseEncuesta, $tipoEncuesta, $especialidad, $tipo, $auditor){

        $respuesta = ModelEncuestasReportes::mdlInfoReporteEspecidalidadxProfesional($idBaseEncuesta, $tipoEncuesta, $especialidad, $tipo, $auditor);

        return $respuesta;

    }

    static public function ctrInfoReporteEspecidalidad($idBaseEncuesta, $tipoEncuesta, $especialidad, $tipo){

        $respuesta = ModelEncuestasReportes::mdlInfoReporteEspecidalidad($idBaseEncuesta, $tipoEncuesta, $especialidad, $tipo);

        return $respuesta;

    }

    static public function ctrInfoReportConsolidadoDatosIdentificacion($idBaseEncuesta, $tipoEncuesta){

        if($tipoEncuesta == 'VIH'){

            $idEncuProceso = 12;

        }else if($tipoEncuesta == 'AUTOINMUNES'){

            $idEncuProceso = 1;

        }

        $respuesta = ModelEncuestasReportes::mdlInfoReportConsolidadoDatosIdentificacion($idBaseEncuesta, $idEncuProceso);

        return $respuesta;


    }

    static public function ctrInfoReportCumplimientoAtencionInicial($idBaseEncuesta, $tipoEncuesta){

        $dataEspecialidad = ControladorEncuestasReportes::ctrObtenerCumplimientoAtencionInicialEspecialidad($idBaseEncuesta, $tipoEncuesta);
        $dataInstrumentos = ControladorEncuestasReportes::ctrObtenerCumplimientoAtencionInicialInstrumentos($idBaseEncuesta, $tipoEncuesta);

        $arrayData = array();
        $cantidadTotal = 0;

        foreach($dataEspecialidad as $key => $especialidad){

            $cantidadTotal += $especialidad["cantidad"];

            $arrayData[] = array(
                'equipo' => $especialidad["especialidad"],
                'cantidad' => $especialidad["cantidad"]
            );

        }

        foreach($dataInstrumentos as $key => $instrumento){

            $arrayData[] = array(
                'equipo' => $instrumento["proceso"],
                'cantidad' => $instrumento["cantidad"]
            );

        }

        return array(
            "data" => $arrayData,
            "cantidadTotal" => $cantidadTotal 
        );

    }

    static public function ctrInfoReporteConsolidadoFrencuenciaGrupo($idBaseEncuesta){

        $respuesta = ModelEncuestasReportes::mdlInfoReporteConsolidadoFrencuenciaGrupo($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrInfoReporteFrencuencia($idBaseEncuesta, $tipoEncuesta, $frecuencia){

        $respuesta = ModelEncuestasReportes::mdlInfoReporteFrencuencia($idBaseEncuesta, $tipoEncuesta, $frecuencia);

        return $respuesta;

    }

    static public function ctrInfoReportConsolidadoGrupoInter($idBaseEncuesta, $procesoEncu){

        $dataEspecialidad = ControladorEncuestasReportes::ctrObtenerConsolidadoEspecialidad($idBaseEncuesta, $procesoEncu);
        $dataInstrumentos = ControladorEncuestasReportes::ctrObtenerConsolidadoInstrumentos($idBaseEncuesta);

        $arrayData = array();

        foreach($dataEspecialidad as $key => $especialidad){

            $arrayData[] = array(
                'grupo' => $especialidad["especialidad"],
                'cantidad' => $especialidad["cantidad"],
                'puntaje' => $especialidad["puntaje"]
            );

        }


        foreach($dataInstrumentos as $key => $instrumento){

            $arrayData[] = array(
                'grupo' => $instrumento["proceso"],
                'cantidad' => $instrumento["cantidad"],
                'puntaje' => $instrumento["puntaje"]
            );

        }

        return $arrayData;



    }

    static public function ctrInfoReportConsolidadoEps($idBaseEncuesta){

        $tabla = "encuestas_encuestas_procesos";

        $respuesta = ModelEncuestasReportes::mdlInfoReportConsolidadoEps($tabla, $idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrListaBasesEncuestas($tipoEncuesta){

        $tabla = "encuestas_bases_encuestas";

        $respuesta = ModelEncuestasReportes::mdlListaBasesEncuestas($tabla, $tipoEncuesta);

        return $respuesta;

    }

    static public function ctrListaReportesEncuestas($tipoEncuesta){

        $tabla = "encuestas_reportes";

        $respuesta = ModelEncuestasReportes::mdlListaReportesEncuestas($tabla, $tipoEncuesta);

        return $respuesta;

    }

    static public function ctrObtenerConsolidadoEspecialidad($idBaseEncuesta, $procesoEncu){

        $respuesta = ModelEncuestasReportes::mdlObtenerConsolidadoEspecialidad($idBaseEncuesta, $procesoEncu);

        return $respuesta;

    }

    static public function ctrObtenerConsolidadoInstrumentos($idBaseEncuesta){

        $respuesta = ModelEncuestasReportes::mdlObtenerConsolidadoInstrumentos($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrObtenerCumplimientoAtencionInicialEspecialidad($idBaseEncuesta, $tipoEncuesta){

        $respuesta = ModelEncuestasReportes::mdlObtenerCumplimientoAtencionInicialEspecialidad($idBaseEncuesta, $tipoEncuesta);

        return $respuesta;

    }

    static public function ctrObtenerCumplimientoAtencionInicialInstrumentos($idBaseEncuesta, $tipoEncuesta){

        $respuesta = ModelEncuestasReportes::mdlObtenerCumplimientoAtencionInicialInstrumentos($idBaseEncuesta, $tipoEncuesta);

        return $respuesta;

    }


}
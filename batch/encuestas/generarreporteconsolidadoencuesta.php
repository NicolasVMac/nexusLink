<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
date_default_timezone_set('America/Bogota');
$hoy = date('Y-m-d H:i:s');

require_once "../../plugins/Spout/src/Spout/Autoloader/autoload.php";
require "../../models/connection.php";
require "../../controllers/encuestas/reportes.controller.php";
require "../../models/encuestas/reportes.model.php";

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Type;


$valiProceso = Connection::connectBatch()->prepare("SELECT * FROM encuestas_encuestas_reportes_consolidados WHERE estado = 'PROCESO'");
$valiProceso->execute();
$valiProceso = $valiProceso->fetch();


if(!empty($valiProceso)){

    echo 'PROCESO CORRIENDO <br><br>';
    
}else{

    $solicitud = Connection::connectBatch()->prepare("SELECT * FROM encuestas_encuestas_reportes_consolidados WHERE estado = 'CREADO' LIMIT 1");
    $solicitud->execute();
    $solicitud = $solicitud->fetch();

    if(!empty($solicitud)){

        $idReporte = $solicitud["id_reporte"];

        $updProceso = Connection::connectBatch()->prepare("UPDATE encuestas_encuestas_reportes_consolidados SET estado = 'PROCESO' WHERE id_reporte = $idReporte");
        $updProceso->execute();


        if($solicitud["tipo_encuesta"] == "VIH"){

            //CREAR ARCHIVO REPORTE VIH
            $writer = WriterEntityFactory::createXLSXWriter();

            $rutaReportes = "../../../archivos_vidamedical/encuestas/archivos_reportes_vih/";
            
            $rutaFinal = $rutaReportes.$solicitud["nombre_archivo"];

            $writer->openToFile($rutaFinal);

            $infoBase = ModelEncuestasReportes::mdlInfoBaseEncuesta($solicitud["id_base_encu"]);

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

            $segmentosEncuesta = ModelEncuestasReportes::mdlSegmentosEncuesta($solicitud["id_encu_proceso"]);

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

            $encuestas = ControladorEncuestasReportes::ctrObtenerEncuestasFinalizadas($solicitud["id_base_encu"], $solicitud["tipo_encuesta"], $solicitud["id_encu_proceso"]);

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
        
                        $calificacionOrdenado = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], 59, $solicitud["id_encu_proceso"]);
                        $calificacionAnalizado = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], 124, $solicitud["id_encu_proceso"]);

                        $data[] = $calificacionOrdenado;
                        $data[] = $calificacionAnalizado;

                    }else{

                        $calificacion = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], $valueSegmentoRes["id_encu_segmento"], $solicitud["id_encu_proceso"]);

                        $data[] = $calificacion;
        
                    }

                }



                $writer->addRow(WriterEntityFactory::createRowFromArray($data));

            }

            $writer->close();

            $updEnd = Connection::connectBatch()->prepare("UPDATE encuestas_encuestas_reportes_consolidados SET estado = 'FINALIZADO' WHERE id_reporte = $idReporte");
            $updEnd->execute();
            
            echo 'Reporte: ' . $solicitud["nombre_archivo"] . " GENERADO<br><br>";

            exit();



        }else if($solicitud["tipo_encuesta"] == "AUTOINMUNES"){

            //CREAR ARCHIVO REPORTE AUTOINMUNES
            $writer = WriterEntityFactory::createXLSXWriter();

            $rutaReportes = "../../../archivos_vidamedical/encuestas/archivos_reportes_autoinmunes/";

            $rutaFinal = $rutaReportes.$solicitud["nombre_archivo"];

            $writer->openToFile($rutaFinal);

            $infoBase = ModelEncuestasReportes::mdlInfoBaseEncuesta($solicitud["id_base_encu"]);

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

            $segmentosEncuesta = ModelEncuestasReportes::mdlSegmentosEncuestaAutoinmunes($solicitud["id_encu_proceso"]);

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

            $encuestas = ControladorEncuestasReportes::ctrObtenerEncuestasFinalizadas($solicitud["id_base_encu"], $solicitud["tipo_encuesta"], $solicitud["id_encu_proceso"]);

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
        
                        $calificacionOrdenado = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], 4, $solicitud["id_encu_proceso"]);
                        $calificacionAnalizado = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], 123, $solicitud["id_encu_proceso"]);

                        $data[] = $calificacionOrdenado;
                        $data[] = $calificacionAnalizado;

                    }else{

                        $calificacion = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta($valueEncuesta["id_encuesta"], $valueSegmentoRes["id_encu_segmento"], $solicitud["id_encu_proceso"]);

                        $data[] = $calificacion;
        
                    }

                }



                $writer->addRow(WriterEntityFactory::createRowFromArray($data));

            }

            $writer->close();
            
            $updEnd = Connection::connectBatch()->prepare("UPDATE encuestas_encuestas_reportes_consolidados SET estado = 'FINALIZADO' WHERE id_reporte = $idReporte");
            $updEnd->execute();
            
            echo 'Reporte: ' . $solicitud["nombre_archivo"] . " GENERADO<br><br>";
            
            exit();

        }

        
    }else{

        echo 'SIN SOLICITUD PARA GENERAR REPORTE <br><br>';

    }


}
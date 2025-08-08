<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');
ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
set_time_limit(0);

class ModelEncuestasReportesProfesional{

    static public function mdlPreguntasSegmentoIntrumentoProfesional($idBaseEncuesta, $idEncuSegmento, $profesional){

        $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
            WHERE encuestas_segmentos_profesional.id_encu_segmento = $idEncuSegmento AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }


    static public function mdlSegmentosOtraEspecialidadProfesional($idBaseEncuesta, $idProceso, $profesional){

        $stmt = Connection::connectBatch()->prepare("SELECT encuestas_segmentos_profesional.id_encu_segmento, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
            WHERE encuestas_procesos_profesional.id_encu_proceso = $idProceso AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_segmentos_profesional.porcentaje_general != 0 AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_segmentos_profesional.id_encu_segmento");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function ctrInfoReporteEspecidalidadProfesionalPro($idBaseEncuesta, $programa, $especialidad, $tipo, $profesional){

        $segmentos = ModelEncuestasReportesProfesional::mdlObtenerSegmentosProfesionalProgramaEspecialidad($especialidad, $tipo);

        if($programa == 'VIH'){

            switch ($tipo) {

                case 'DILIGENCIAMIENTO':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado
                        FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_segmentos_profesional.id_encu_segmento IN ($segmentos) AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_segmentos_profesional.id_encu_segmento");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'REGISTRO-ANTECEDENTES':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado
                        FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_segmentos_profesional.id_encu_segmento = $segmentos AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'EVALUACION-CLINICA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado
                        FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_segmentos_profesional.id_encu_segmento = $segmentos AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'SEGUIMIENTO-VACUNAS':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado
                        FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_segmentos_profesional.id_encu_segmento = $segmentos AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-1':

                    $idsPreguntasOrde = $segmentos['ORDENADO'];
                    $idsPreguntasAna = $segmentos['ANALIZADO'];

                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasOrde) AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasAna) AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-2':

                    $idsPreguntasOrde = $segmentos['ORDENADO'];
                    $idsPreguntasAna = $segmentos['ANALIZADO'];

                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasOrde) AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasAna) AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-3':

                    $idsPreguntasOrde = $segmentos['ORDENADO'];
                    $idsPreguntasAna = $segmentos['ANALIZADO'];

                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasOrde) AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasAna) AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                // case 'PARACLINICOS-GENERAL':
                //     $stmt = Connection::connectBatch()->prepare("SELECT TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 59 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 59 THEN 0 END), 0) AS resultado_ordenado, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 124 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 124 THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta 
                //     WHERE encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_preguntas.id_encu_segmento IN (59,124)");

                //     $stmt->execute();
                //     return $stmt->fetch();
                //     break;

                case 'CITOLOGIA-ANAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '1' THEN 'PACIENTES CON CITOLOGÍAS ANALES' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '0' THEN 'SIN CITOLOGIA ANAL' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas_profesional AS encu_preg JOIN encuestas_encuestas_respuestas_profesional AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN ($segmentos) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.profesional_auditado = '$profesional' AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'CITOLOGIA-VAGINAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '1' THEN 'TOTAL CON CITOLOGÍA VAGINAL' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '0' THEN 'SIN CITOLOGIA VAGINAL' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas_profesional AS encu_preg JOIN encuestas_encuestas_respuestas_profesional AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN ($segmentos) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.profesional_auditado = '$profesional' AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encu_pro.sexo = 'F' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ANTIGENO-PROSTATICO':
                    // $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA POR EDAD' WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = '1' THEN 'CON PSA' WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = '0' THEN 'SIN PSA' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                    //     WHERE encu_preg.id_encu_pregunta IN (317) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encu_pro.sexo = 'MASCULINO' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '1' THEN 'CON PSA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '0' THEN 'SIN PSA' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas_profesional AS encu_preg JOIN encuestas_encuestas_respuestas_profesional AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN ($segmentos) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.profesional_auditado = '$profesional' AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encu_pro.sexo = 'M' AND encu_pro.edad >= 40 GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'MAMOGRAFIA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '1' THEN 'TOTAL CON MAMOGRAFÍA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '0' THEN 'TOTAL SIN MAMOGRAFÍA' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas_profesional AS encu_preg JOIN encuestas_encuestas_respuestas_profesional AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN ($segmentos) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.profesional_auditado = '$profesional' AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encu_pro.sexo = 'F' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'RECOMENDACIONES-COHERENCIA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_segmentos_profesional.id_encu_segmento = $segmentos AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ATRIBUTOS-CALIDAD':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta 
                        WHERE encuestas_segmentos_profesional.id_encu_segmento = $segmentos  AND encuestas_encuestas_procesos_profesional.profesional_auditado = '$profesional' AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                

            }

        }else if($programa == "DOLOR"){

        }

    }

    static public function mdlListaProfesionalesIdBaseEncuesta($idBaseEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT profesional_auditado FROM encuestas_encuestas_procesos_profesional WHERE id_base_encu = :id_base_encu GROUP BY profesional_auditado");

        $stmt->bindParam(":id_base_encu", $idBaseEncuesta, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoResultadoAuditoriaProfesional($idBaseEncuesta, $idProceso){

        $stmt = Connection::connectOnly()->prepare("SELECT encu_pro.profesional_auditado, encu_pro_ges.nombre_usuario, COUNT(*) AS cantidad, TRUNCATE(AVG(encu_pro_ges.calificacion), 0) AS calificacion FROM encuestas_encuestas_procesos_gestion_profesional AS encu_pro_ges JOIN encuestas_encuestas_procesos_profesional AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta
            WHERE encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro_ges.id_encu_proceso = $idProceso AND encu_pro.estado = 'FINALIZADA' AND encu_pro_ges.nombre_usuario != '' GROUP BY encu_pro.profesional_auditado ORDER BY calificacion DESC");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerInfoProceso($especialidad){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_procesos_profesional WHERE especialidad = :especialidad ORDER BY id_encu_proceso DESC LIMIT 1");

        $stmt->bindParam(":especialidad", $especialidad, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdllistaBasesProfesionales(){

        $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_bases_encuestas_profesional WHERE estado IN ('CARGADO','AUDITADA')");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlPreguntasSegmentoIntrumento($idBaseEncuesta, $idEncuSegmento){

        $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
            WHERE encuestas_segmentos_profesional.id_encu_segmento = $idEncuSegmento AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlSegmentosOtraEspecialidad($idBaseEncuesta, $idProceso){

        $stmt = Connection::connectBatch()->prepare("SELECT encuestas_segmentos_profesional.id_encu_segmento, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
            WHERE encuestas_procesos_profesional.id_encu_proceso = $idProceso AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_segmentos_profesional.porcentaje_general != 0 AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_segmentos_profesional.id_encu_segmento");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdllistaOtrasEspecialistas(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_procesos_profesional WHERE especialidad NOT IN ('MEDICO GENERAL DOLOR', 'MEDICO ESPECIALISTA FAMILIAR', 'MEDICO GENERAL VIH', 'MEDICO INTERNISTA', 'MEDICO REUMATOLOGO', 'INFECTOLOGIA', 'INFECTOPEDIATRIA') GROUP BY especialidad");

        if($stmt->execute()){
            return $stmt->fetchAll();
        }else{
            return $stmt->errorInfo();
        }

        $stmt = null;

    }

    static public function ctrInfoReporteEspecidalidadProfesional($idBaseEncuesta, $programa, $especialidad, $tipo){

        $segmentos = ModelEncuestasReportesProfesional::mdlObtenerSegmentosProfesionalProgramaEspecialidad($especialidad, $tipo);

        if($programa == 'VIH'){

            switch ($tipo) {

                case 'DILIGENCIAMIENTO':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado
                        FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_segmentos_profesional.id_encu_segmento IN ($segmentos) AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_segmentos_profesional.id_encu_segmento");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'REGISTRO-ANTECEDENTES':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado
                        FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_segmentos_profesional.id_encu_segmento = $segmentos AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'EVALUACION-CLINICA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado
                        FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_segmentos_profesional.id_encu_segmento = $segmentos AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'SEGUIMIENTO-VACUNAS':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado
                        FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_segmentos_profesional.id_encu_segmento = $segmentos AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-1':

                    $idsPreguntasOrde = $segmentos['ORDENADO'];
                    $idsPreguntasAna = $segmentos['ANALIZADO'];

                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasOrde) AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasAna) AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-2':

                    $idsPreguntasOrde = $segmentos['ORDENADO'];
                    $idsPreguntasAna = $segmentos['ANALIZADO'];

                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasOrde) AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasAna) AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-3':

                    $idsPreguntasOrde = $segmentos['ORDENADO'];
                    $idsPreguntasAna = $segmentos['ANALIZADO'];

                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasOrde) AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas_profesional.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_preguntas_profesional.id_encu_pregunta IN ($idsPreguntasAna) AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta, encuestas_preguntas_profesional.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                // case 'PARACLINICOS-GENERAL':
                //     $stmt = Connection::connectBatch()->prepare("SELECT TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 59 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 59 THEN 0 END), 0) AS resultado_ordenado, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 124 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 124 THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta 
                //     WHERE encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_preguntas.id_encu_segmento IN (59,124)");

                //     $stmt->execute();
                //     return $stmt->fetch();
                //     break;

                case 'CITOLOGIA-ANAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '1' THEN 'PACIENTES CON CITOLOGÍAS ANALES' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '0' THEN 'SIN CITOLOGIA ANAL' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas_profesional AS encu_preg JOIN encuestas_encuestas_respuestas_profesional AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN ($segmentos) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'CITOLOGIA-VAGINAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '1' THEN 'TOTAL CON CITOLOGÍA VAGINAL' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '0' THEN 'SIN CITOLOGIA VAGINAL' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas_profesional AS encu_preg JOIN encuestas_encuestas_respuestas_profesional AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN ($segmentos) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encu_pro.sexo = 'F' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ANTIGENO-PROSTATICO':
                    // $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA POR EDAD' WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = '1' THEN 'CON PSA' WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = '0' THEN 'SIN PSA' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                    //     WHERE encu_preg.id_encu_pregunta IN (317) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encu_pro.sexo = 'MASCULINO' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '1' THEN 'CON PSA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '0' THEN 'SIN PSA' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas_profesional AS encu_preg JOIN encuestas_encuestas_respuestas_profesional AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN ($segmentos) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encu_pro.sexo = 'M' AND encu_pro.edad >= 40 GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'MAMOGRAFIA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '1' THEN 'TOTAL CON MAMOGRAFÍA' WHEN encu_preg.id_encu_pregunta = $segmentos AND encu_resp.respuesta = '0' THEN 'TOTAL SIN MAMOGRAFÍA' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas_profesional AS encu_preg JOIN encuestas_encuestas_respuestas_profesional AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN ($segmentos) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encu_pro.sexo = 'F' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'RECOMENDACIONES-COHERENCIA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta
                        WHERE encuestas_segmentos_profesional.id_encu_segmento = $segmentos AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ATRIBUTOS-CALIDAD':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas_profesional.id_encu_pregunta, encuestas_procesos_profesional.proceso, encuestas_segmentos_profesional.segmento, encuestas_preguntas_profesional.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas_profesional.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas_profesional.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_procesos_profesional.id_encu_proceso = encuestas_segmentos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta JOIN encuestas_encuestas_procesos_profesional ON encuestas_encuestas_respuestas_profesional.id_encuesta = encuestas_encuestas_procesos_profesional.id_encuesta 
                        WHERE encuestas_segmentos_profesional.id_encu_segmento = $segmentos AND encuestas_encuestas_procesos_profesional.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_profesional.especialidad = '$especialidad' AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' GROUP BY encuestas_preguntas_profesional.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                

            }

        }else if($programa == "DOLOR"){

        }

    }

    static public function mdlObtenerSegmentosProfesionalProgramaEspecialidad($especialidad, $tipo){

        $datosSegmentos = array(
            "MEDICO GENERAL VIH" => array(
                "DILIGENCIAMIENTO" => "64,65,66,67,68,69,70",
                "REGISTRO-ANTECEDENTES" => "64",
                "EVALUACION-CLINICA" => "65",
                "SEGUIMIENTO-VACUNAS" => "66",
                "PARACLINICOS-1" => array(
                    "ORDENADO" => "484,485,488,489,490,491,492,493",
                    "ANALIZADO" => "509,510,513,514,515,516,517,518"
                ),
                "PARACLINICOS-2" => array(
                    "ORDENADO" => "486,487,494,495,496,497",
                    "ANALIZADO" => "511,512,519,520,521,522"
                ),
                "PARACLINICOS-3" => array(
                    "ORDENADO" => "498,499,500,501,502,503,504,505",
                    "ANALIZADO" => "523,524,525,526,527,528,529,530"
                ),
                "CITOLOGIA-ANAL" => "532",
                "CITOLOGIA-VAGINAL" => "531",
                "ANTIGENO-PROSTATICO" => "533",
                "MAMOGRAFIA" => "533",
                "RECOMENDACIONES-COHERENCIA" => "69",
                "ATRIBUTOS-CALIDAD" => "70"
            ),
            "INFECTOLOGIA" => array(
                "DILIGENCIAMIENTO" => "72,73,74,75,76,77,78",
                "REGISTRO-ANTECEDENTES" => "72",
                "EVALUACION-CLINICA" => "73",
                "SEGUIMIENTO-VACUNAS" => "74",
                "PARACLINICOS-1" => array(
                    "ORDENADO" => "566,567,570,571,572,573,574,575",
                    "ANALIZADO" => "591,592,595,596,597,598,599,600"
                ),
                "PARACLINICOS-2" => array(
                    "ORDENADO" => "568,569,576,577,578,579",
                    "ANALIZADO" => "593,594,601,602,603,604"
                ),
                "PARACLINICOS-3" => array(
                    "ORDENADO" => "580,581,582,583,584,585,586,587",
                    "ANALIZADO" => "605,606,607,608,609,610,611,612"
                ),
                "CITOLOGIA-ANAL" => "614",
                "CITOLOGIA-VAGINAL" => "613",
                "ANTIGENO-PROSTATICO" => "615",
                "MAMOGRAFIA" => "615",
                "RECOMENDACIONES-COHERENCIA" => "77",
                "ATRIBUTOS-CALIDAD" => "78"
            ),
            "INFECTOPEDIATRIA" => array(
                "DILIGENCIAMIENTO" => "80,81,82,83,84,85,86",
                "REGISTRO-ANTECEDENTES" => "80",
                "EVALUACION-CLINICA" => "81",
                "SEGUIMIENTO-VACUNAS" => "82",
                "PARACLINICOS-1" => array(
                    "ORDENADO" => "648,649,652,653,654,655,656,657",
                    "ANALIZADO" => "673,674,677,678,679,680,681,682"
                ),
                "PARACLINICOS-2" => array(
                    "ORDENADO" => "650,651,658,659,660,661",
                    "ANALIZADO" => "675,676,683,684,685,686"
                ),
                "PARACLINICOS-3" => array(
                    "ORDENADO" => "662,663,664,665,666,667,668,669",
                    "ANALIZADO" => "687,688,689,690,691,692,693,694"
                ),
                "CITOLOGIA-ANAL" => "696",
                "CITOLOGIA-VAGINAL" => "695",
                "ANTIGENO-PROSTATICO" => "697",
                "MAMOGRAFIA" => "697",
                "RECOMENDACIONES-COHERENCIA" => "85",
                "ATRIBUTOS-CALIDAD" => "86"
            ),
        );

        return $datosSegmentos[$especialidad][$tipo];

    }

    static public function mdlListaBasesEncuestasEspecialidad($tabla, $especialidad){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE especialidad = :especialidad");

        $stmt->bindParam(":especialidad", $especialidad, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();
            
        }

        $stmt = null;

    }


    static public function mdlListaEspecialidadProfesional($tabla, $programa){

        if($programa == 'VIH'){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_encu_proceso IN (16,17,18)");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
                
            }

        }else if($programa == 'DOLOR'){


        }


        $stmt = null;

    }

    static public function mdlListaReportesEncuestasProfesional($tabla){

        $stmt = Connection::connectBatch()->prepare("SELECT * FROM $tabla WHERE estado = 1");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();
            
        }

        $stmt = null;

    }

    static public function mdlObtenerDatos($tabla, $item, $valor){

        if ($item == null) {

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();
        } else {

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        }

        $stmt = null;
    }

}
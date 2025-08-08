<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');
ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
set_time_limit(0);

class ModelEncuestasReportes{

    static public function mdlListaSolicitudesReportesConsolidados($tipoEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_encuestas_reportes_consolidados WHERE tipo_encuesta = :tipo_encuesta");

        $stmt->bindParam(":tipo_encuesta", $tipoEncuesta, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlGenerarReporteGeneralVih($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO encuestas_encuestas_reportes_consolidados (id_base_encu, id_encu_proceso, proceso_encuesta, nombre_archivo, tipo_encuesta, usuario_crea) VALUES (:id_base_encu, :id_encu_proceso, :proceso_encuesta, :nombre_archivo, :tipo_encuesta, :usuario_crea)");

        $stmt->bindParam(":id_base_encu", $datos["id_base_encu"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_proceso", $datos["id_encu_proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":proceso_encuesta", $datos["proceso_encuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_archivo", $datos["nombre_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_encuesta", $datos["tipo_encuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarRespuestaSinCalificacion($idEncuesta, $idEncuSegmento){

        $stmt = Connection::connectBatch()->prepare("DELETE FROM encuestas_encuestas_procesos_gestion_detalle WHERE id_encu_segmento = $idEncuSegmento AND id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoConsolidadoCalificacionSegmento($tipoEncuesta, $idBaseEncuesta){

        if($tipoEncuesta == 'VIH'){

            $stmt = Connection::connectBatch()->prepare("SELECT resultado, COUNT(*) AS cantidad_encuestas, TRUNCATE(AVG(calificacion), 0) AS calificacion_promedio FROM ( SELECT encu_pro.id_encuesta, AVG(calificacion) AS calificacion, CASE WHEN TRUNCATE(AVG(calificacion), 0) < 70 THEN 'DEFICIENTE' WHEN TRUNCATE(AVG(calificacion), 0) >= 70 AND TRUNCATE(AVG(calificacion), 0) < 90 THEN 'ACEPTABLE' WHEN TRUNCATE(AVG(calificacion), 0) >= 90 THEN 'SATISFACTORIO' ELSE 'OTRO DATO' END AS resultado FROM encuestas_encuestas_procesos AS encu_pro JOIN encuestas_encuestas_procesos_gestion AS encu_pro_ges ON encu_pro.id_encuesta = encu_pro_ges.id_encuesta
                WHERE encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.estado = 'FINALIZADA' AND encu_pro_ges.id_encu_proceso NOT IN (12, 21) GROUP BY encu_pro.id_encuesta) AS subquery GROUP BY resultado");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll();
    
            }else{
    
                return $stmt->errorInfo();
    
            }

        }else{

            $stmt = Connection::connectBatch()->prepare("SELECT resultado, COUNT(*) AS cantidad_encuestas, TRUNCATE(AVG(calificacion), 0) AS calificacion_promedio FROM ( SELECT encu_pro.id_encuesta, AVG(calificacion) AS calificacion, CASE WHEN TRUNCATE(AVG(calificacion), 0) < 70 THEN 'DEFICIENTE' WHEN TRUNCATE(AVG(calificacion), 0) >= 70 AND TRUNCATE(AVG(calificacion), 0) < 90 THEN 'ACEPTABLE' WHEN TRUNCATE(AVG(calificacion), 0) >= 90 THEN 'SATISFACTORIO' ELSE 'OTRO DATO' END AS resultado FROM encuestas_encuestas_procesos AS encu_pro JOIN encuestas_encuestas_procesos_gestion AS encu_pro_ges ON encu_pro.id_encuesta = encu_pro_ges.id_encuesta
                WHERE encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.estado = 'FINALIZADA' AND encu_pro_ges.id_encu_proceso NOT IN (1,2,20) GROUP BY encu_pro.id_encuesta) AS subquery GROUP BY resultado ORDER BY cantidad_encuestas DESC");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll();
    
            }else{
    
                return $stmt->errorInfo();
    
            }

        }


    }

    static public function mdlInfoBaseEncuesta($idBaseEncuesta){

        $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_bases_encuestas WHERE id_base_encuesta = $idBaseEncuesta");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoSegmento($idEncuSegmento){

        $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_segmentos WHERE id_encu_segmento = $idEncuSegmento");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlGuardarDetalleEncuesta($datos){

        $stmt = Connection::connectBatch()->prepare("INSERT INTO encuestas_encuestas_procesos_gestion_detalle (id_encuesta, id_encu_proceso, id_encu_segmento, segmento, calificacion, usuario_crea) VALUES (:id_encuesta, :id_encu_proceso, :id_encu_segmento, :segmento, :calificacion, :usuario_crea)");

        $stmt->bindParam(":id_encuesta", $datos["id_encuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_proceso", $datos["id_encu_proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_segmento", $datos["id_encu_segmento"], PDO::PARAM_STR);
        $stmt->bindParam(":segmento", $datos["segmento"], PDO::PARAM_STR);
        $stmt->bindParam(":calificacion", $datos["calificacion"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCalificacionSegmentoEncuesta($idEncuesta, $idEncuSegmento){

        $stmt = Connection::connectBatch()->prepare("SELECT TRUNCATE( ROUND(AVG( CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END )), 0 ) AS calificacion_segmento FROM encuestas_encuestas_respuestas JOIN encuestas_preguntas ON encuestas_encuestas_respuestas.id_encu_pregunta = encuestas_preguntas.id_encu_pregunta JOIN encuestas_segmentos ON encuestas_preguntas.id_encu_segmento = encuestas_segmentos.id_encu_segmento 
            WHERE encuestas_encuestas_respuestas.id_encuesta = $idEncuesta AND encuestas_segmentos.id_encu_segmento = $idEncuSegmento");

        if($stmt->execute()){

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;

        }else{

            return null;

        }

        $stmt = null;

    }

    static public function mdlObtenerRespuestasEncuesta($idEncuesta, $idEncuSegmento){

        if($idEncuSegmento == 59){

            $stmt = Connection::connectBatch()->prepare("SELECT *, encu_res.respuesta AS respuesta_pre FROM encuestas_segmentos AS encu_seg JOIN encuestas_preguntas AS encu_pre ON encu_seg.id_encu_segmento = encu_pre.id_encu_segmento JOIN encuestas_encuestas_respuestas AS encu_res ON encu_pre.id_encu_pregunta = encu_res.id_encu_pregunta 
                WHERE id_encuesta = $idEncuesta AND encu_seg.id_encu_segmento IN (59, 124) AND encu_seg.is_view = 1 ORDER BY encu_pre.id_encu_pregunta");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

        }else if($idEncuSegmento == 4){

            $stmt = Connection::connectBatch()->prepare("SELECT *, encu_res.respuesta AS respuesta_pre FROM encuestas_segmentos AS encu_seg JOIN encuestas_preguntas AS encu_pre ON encu_seg.id_encu_segmento = encu_pre.id_encu_segmento JOIN encuestas_encuestas_respuestas AS encu_res ON encu_pre.id_encu_pregunta = encu_res.id_encu_pregunta 
                WHERE id_encuesta = $idEncuesta AND encu_seg.id_encu_segmento IN (4, 123) AND encu_seg.is_view = 1 ORDER BY encu_pre.id_encu_pregunta");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

        }else{

            $stmt = Connection::connectBatch()->prepare("SELECT *, encu_res.respuesta AS respuesta_pre FROM encuestas_segmentos AS encu_seg JOIN encuestas_preguntas AS encu_pre ON encu_seg.id_encu_segmento = encu_pre.id_encu_segmento JOIN encuestas_encuestas_respuestas AS encu_res ON encu_pre.id_encu_pregunta = encu_res.id_encu_pregunta 
                WHERE id_encuesta = $idEncuesta AND encu_seg.id_encu_segmento = $idEncuSegmento AND encu_seg.is_view = 1 ORDER BY encu_pre.id_encu_pregunta");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }


        }

        $stmt = null;
        
    }

    static public function mdlObtenerPreguntasEncuestasSegmentoAutoinmunes($idEncuSegmento){

        if($idEncuSegmento == 4){

            $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_preguntas WHERE encuestas_preguntas.id_encu_segmento IN (4,123) ORDER BY id_encu_pregunta");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

        }else{

            $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_preguntas WHERE encuestas_preguntas.id_encu_segmento = $idEncuSegmento ORDER BY id_encu_pregunta");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }


        }

        $stmt = null;

    }

    static public function mdlObtenerPreguntasEncuestasSegmentoVih($idEncuSegmento){

        if($idEncuSegmento == 59){

            $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_preguntas WHERE encuestas_preguntas.id_encu_segmento IN (59,124) ORDER BY id_encu_pregunta");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

        }else{

            $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_preguntas WHERE encuestas_preguntas.id_encu_segmento = $idEncuSegmento ORDER BY id_encu_pregunta");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }


        }

        $stmt = null;

    }

    static public function mdlObtenerPreguntasEncuestasVih($idBaseEncuesta, $idEncuProceso){

        if($idEncuProceso == 13){

            $stmt = Connection::connectBatch()->prepare("SELECT *, encu_res.respuesta AS respuesta_pre FROM encuestas_segmentos AS encu_seg JOIN encuestas_preguntas AS encu_pre ON encu_seg.id_encu_segmento = encu_pre.id_encu_segmento JOIN encuestas_encuestas_respuestas AS encu_res ON encu_pre.id_encu_pregunta = encu_res.id_encu_pregunta 
                WHERE encu_seg.id_encu_proceso IN (12,13) AND encu_seg.is_view = 1");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

        }else{

            $stmt = Connection::connectBatch()->prepare("SELECT *, encu_res.respuesta AS respuesta_pre FROM encuestas_segmentos AS encu_seg JOIN encuestas_preguntas AS encu_pre ON encu_seg.id_encu_segmento = encu_pre.id_encu_segmento JOIN encuestas_encuestas_respuestas AS encu_res ON encu_pre.id_encu_pregunta = encu_res.id_encu_pregunta 
                WHERE encu_seg.id_encu_proceso = $idEncuProceso AND encu_seg.is_view = 1");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }


        }

        $stmt = null;

    }

    static public function mdlEncuestaRespuestas($idEncuesta, $idEncuSegmento){

        $stmt = Connection::connectBatch()->prepare("SELECT encu_pre.titulo_descripcion, encu_res.respuesta FROM encuestas_preguntas AS encu_pre JOIN encuestas_encuestas_respuestas AS encu_res ON encu_pre.id_encu_pregunta = encu_res.id_encu_pregunta  WHERE id_encu_segmento = $idEncuSegmento AND id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEncuestaGestionDetalle($idEncuesta, $idEncuSegmento){

        $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_encuestas_procesos_gestion_detalle WHERE id_encu_segmento = $idEncuSegmento AND id_encuesta = $idEncuesta");

        if($stmt->execute()){

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;

        }else{

            return null;

        }

    }

    static public function mdlSegmentosEncuestaAutoinmunes($idEncuProceso){

        //PROCESO MEDICO O ESPECIALISTA
        if($idEncuProceso == 3){

            $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_segmentos WHERE id_encu_proceso IN (1,2,3) AND is_view = 1 LIMIT 7;");

            if($stmt->execute()){

                return $stmt->fetchAll();


            }else{

                return $stmt->errorInfo();

            }

        }else{

            $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_segmentos WHERE id_encu_proceso = $idEncuProceso AND is_view = 1;");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }


        }

        $stmt = null;
    }

    static public function mdlSegmentosEncuesta($idEncuProceso){

        //PROCESO MEDICINA
        if($idEncuProceso == 13){

            $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_segmentos WHERE id_encu_proceso IN (12,13) AND is_view = 1 LIMIT 8");

            if($stmt->execute()){

                return $stmt->fetchAll();


            }else{

                return $stmt->errorInfo();

            }

        }else{

            $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_segmentos WHERE id_encu_proceso = $idEncuProceso AND is_view = 1;");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }


        }

        $stmt = null;
    }

    static public function mdlEncuestaGestion($idEncuesta, $idEncuProceso){

        $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges WHERE encu_pro_ges.id_encuesta = $idEncuesta AND encu_pro_ges.id_encu_proceso IN ( $idEncuProceso )");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerEncuestasFinalizadas($idBaseEncuesta, $tipoEncuesta, $idEncuProceso){

        $stmt = Connection::connectBatch()->prepare("SELECT encuestas_encuestas_procesos.*, usuarios.nombre, encuestas_encuestas_procesos_gestion.nombre_usuario, encuestas_encuestas_procesos_gestion.proceso FROM encuestas_encuestas_procesos_gestion JOIN encuestas_encuestas_procesos ON encuestas_encuestas_procesos_gestion.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN usuarios ON encuestas_encuestas_procesos.auditor = usuarios.usuario 
            WHERE encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND tipo_encuesta = '$tipoEncuesta' AND id_encu_proceso = $idEncuProceso ORDER BY encuestas_encuestas_procesos.id_encuesta ASC");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerProcesosEncuestaGeneral($tipoEncuesta){

        if($tipoEncuesta == 'VIH'){

            $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_procesos WHERE id_encu_proceso IN (13,14,15,16,17,18,19)");

            if($stmt->execute()){

                return $stmt->fetchAll();
    
            }else{
    
                return $stmt->errorInfo();
    
            }

        }else{

            $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_procesos WHERE id_encu_proceso IN (3,4,5,6,7,8,9,10,11)");

            if($stmt->execute()){

                return $stmt->fetchAll();
    
            }else{
    
                return $stmt->errorInfo();
    
            }

        }

    }

    static public function mdlPreguntasSegmentoIntrumentoProfesional($idBaseEncuesta, $idEncuSegmento, $idInstrumento, $auditor){

        $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
            WHERE encuestas_segmentos.id_encu_segmento = $idEncuSegmento AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = $idInstrumento AND encuestas_encuestas_procesos_gestion.nombre_usuario = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlSegmentosInstrumentoProfesional($idBaseEncuesta, $idInstrumento, $auditor){

        $stmt = Connection::connectBatch()->prepare("SELECT encuestas_segmentos.id_encu_segmento, encuestas_procesos.proceso, encuestas_segmentos.segmento AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
            WHERE encuestas_procesos.id_encu_proceso = $idInstrumento AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_segmentos.porcentaje_general != 0 AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = $idInstrumento AND encuestas_encuestas_procesos_gestion.nombre_usuario = '$auditor' GROUP BY encuestas_segmentos.id_encu_segmento");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaAuditoresInstrumento($idBaseEncuesta, $idInstrumento){

        $stmt = Connection::connectBatch()->prepare("SELECT nombre_usuario FROM encuestas_encuestas_procesos_gestion JOIN encuestas_encuestas_procesos ON encuestas_encuestas_procesos_gestion.id_encuesta = encuestas_encuestas_procesos.id_encuesta
            WHERE encuestas_encuestas_procesos_gestion.id_encu_proceso = $idInstrumento AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta GROUP BY nombre_usuario");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlListaAuditoresEspecialidad($idBaseEncuesta, $idEncuProceso, $especialidad){

        $stmt = Connection::connectBatch()->prepare("SELECT encu_pro_ges.nombre_usuario, encu_pro.profesional_auditado FROM encuestas_encuestas_procesos AS encu_pro JOIN encuestas_encuestas_procesos_gestion AS encu_pro_ges ON encu_pro.id_encuesta = encu_pro_ges.id_encuesta WHERE encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro_ges.id_encu_proceso = $idEncuProceso AND encu_pro.especialidad = '$especialidad' GROUP BY encu_pro.profesional_auditado");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaEspecialidadBase($idBaseEncuesta){

        $stmt = Connection::connectBatch()->prepare("SELECT * FROM encuestas_encuestas_procesos WHERE id_base_encu = $idBaseEncuesta GROUP BY especialidad");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoReportConsoMedicoEspecialista($idBaseEncuesta, $tipoEncuesta, $tipoProfesional){

        if($tipoEncuesta == 'VIH'){

            switch($tipoProfesional){

                case 'MEDICO':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_pro.profesional_auditado, encu_pro_ges.nombre_usuario, COUNT(*) AS cantidad, TRUNCATE(AVG(encu_pro_ges.calificacion),0) AS calificacion FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges JOIN encuestas_encuestas_procesos AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_pro.tipo_encuesta = 'VIH' AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.estado = 'FINALIZADA' AND encu_pro_ges.id_encu_proceso = 13 AND encu_pro_ges.nombre_usuario != '' GROUP BY encu_pro.profesional_auditado ORDER BY calificacion DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ESPECIALISTA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_pro_ges.nombre_usuario, COUNT(*) AS cantidad, TRUNCATE(AVG(encu_pro_ges.calificacion),0) AS calificacion FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges JOIN encuestas_encuestas_procesos AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_pro.tipo_encuesta = 'VIH' AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.estado = 'FINALIZADA' AND encu_pro_ges.id_encu_proceso IN (14,15,16,17,18,19) AND encu_pro_ges.nombre_usuario != '' GROUP BY encu_pro_ges.nombre_usuario ORDER BY calificacion DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

            }

        }else if($tipoEncuesta == 'AUTOINMUNES'){

            switch($tipoProfesional){

                case 'MEDICO':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_pro.profesional_auditado, encu_pro_ges.nombre_usuario, COUNT(*) AS cantidad, TRUNCATE(AVG(encu_pro_ges.calificacion),0) AS calificacion FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges JOIN encuestas_encuestas_procesos AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_pro.tipo_encuesta = 'AUTOINMUNES' AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.estado = 'FINALIZADA' AND encu_pro_ges.id_encu_proceso = 3 AND encu_pro_ges.nombre_usuario != '' GROUP BY encu_pro.profesional_auditado ORDER BY calificacion DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ESPECIALISTA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_pro_ges.nombre_usuario, COUNT(*) AS cantidad, TRUNCATE(AVG(encu_pro_ges.calificacion),0) AS calificacion FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges JOIN encuestas_encuestas_procesos AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_pro.tipo_encuesta = 'AUTOINMUNES' AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.estado = 'FINALIZADA' AND encu_pro_ges.id_encu_proceso IN (4,5,6,7,8,9,10,11) AND encu_pro_ges.nombre_usuario != '' GROUP BY encu_pro_ges.nombre_usuario ORDER BY calificacion DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

            }
        }

    }

    static public function mdlInfoReportTratamientoFormulado($idBaseEncuesta){

        $stmt = Connection::connectBatch()->prepare("SELECT respuesta, COUNT(*) AS cantidad FROM encuestas_encuestas_procesos AS encu_pro JOIN encuestas_encuestas_respuestas AS encu_res ON encu_pro.id_encuesta = encu_res.id_encuesta
            WHERE encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.estado = 'FINALIZADA' AND encu_res.id_encu_pregunta = 478 GROUP BY respuesta ORDER BY cantidad DESC");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoDatosIndicador2($idBaseEncuesta, $procesoEncu, $tipoEncuesta){

        if($tipoEncuesta == "VIH"){

            if($procesoEncu == "MEDICINA GENERAL" || $procesoEncu == "INFECTOLOGIA"){

                $stmt = Connection::connectBatch()->prepare("SELECT encu_bases.nombre, SUM(CASE WHEN encu_pro_ges.proceso = 'MEDICINA' AND encu_pro_ges.calificacion >= 90 THEN 1 ELSE 0 END) AS cantidad_satisfactorio, SUM(CASE WHEN encu_pro_ges.proceso = 'MEDICINA' THEN 1 ELSE 0 END) AS cantidad_total FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges JOIN encuestas_encuestas_procesos AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta JOIN encuestas_bases_encuestas AS encu_bases ON encu_pro.id_base_encu = encu_bases.id_base_encuesta
                    WHERE encu_pro.especialidad = '$procesoEncu' AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.estado = 'FINALIZADA'");
    
                if($stmt->execute()){
    
                    return $stmt->fetch();
    
                }else{
    
                    return $stmt->errorInfo();
    
                }
    
            }else{
    
                $stmt = Connection::connectBatch()->prepare("SELECT encu_bases.nombre, SUM(CASE WHEN encu_pro_ges.proceso = '$procesoEncu' AND encu_pro_ges.calificacion >= 90 THEN 1 ELSE 0 END) AS cantidad_satisfactorio, SUM(CASE WHEN encu_pro_ges.proceso = '$procesoEncu' THEN 1 ELSE 0 END) AS cantidad_total FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges JOIN encuestas_encuestas_procesos AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta JOIN encuestas_bases_encuestas AS encu_bases ON encu_pro.id_base_encu = encu_bases.id_base_encuesta
                    WHERE encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.estado = 'FINALIZADA'");
    
                if($stmt->execute()){
    
                    return $stmt->fetch();
    
                }else{
    
                    return $stmt->errorInfo();
    
                }
    
            }

        }else if($tipoEncuesta == "AUTOINMUNES"){

            if($procesoEncu == "MEDICINA FAMILIAR" || $procesoEncu == "REUMATOLOGIA" || $procesoEncu == "MEDICINA GENERAL" || $procesoEncu == "MEDICINA INTERNA"){

                $stmt = Connection::connectBatch()->prepare("SELECT encu_bases.nombre, SUM(CASE WHEN encu_pro_ges.proceso = 'MEDICO O ESPECIALISTA' AND encu_pro_ges.calificacion >= 90 THEN 1 ELSE 0 END) AS cantidad_satisfactorio, SUM(CASE WHEN encu_pro_ges.proceso = 'MEDICO O ESPECIALISTA' THEN 1 ELSE 0 END) AS cantidad_total FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges JOIN encuestas_encuestas_procesos AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta JOIN encuestas_bases_encuestas AS encu_bases ON encu_pro.id_base_encu = encu_bases.id_base_encuesta
                    WHERE encu_pro.especialidad = '$procesoEncu' AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.estado = 'FINALIZADA'");
    
                if($stmt->execute()){
    
                    return $stmt->fetch();
    
                }else{
    
                    return $stmt->errorInfo();
    
                }
    
            }else if($procesoEncu == "SEDE"){

                $stmt = Connection::connectBatch()->prepare("SELECT encu_bases.nombre, SUM(CASE WHEN encu_pro_ges.proceso = 'MEDICO O ESPECIALISTA' AND encu_pro_ges.calificacion >= 90 THEN 1 ELSE 0 END) AS cantidad_satisfactorio, SUM(CASE WHEN encu_pro_ges.proceso = 'MEDICO O ESPECIALISTA' THEN 1 ELSE 0 END) AS cantidad_total FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges JOIN encuestas_encuestas_procesos AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta JOIN encuestas_bases_encuestas AS encu_bases ON encu_pro.id_base_encu = encu_bases.id_base_encuesta
                    WHERE encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.estado = 'FINALIZADA'");
    
                if($stmt->execute()){
    
                    return $stmt->fetch();
    
                }else{
    
                    return $stmt->errorInfo();
    
                }
                
            }else{
    
                $stmt = Connection::connectBatch()->prepare("SELECT encu_bases.nombre, SUM(CASE WHEN encu_pro_ges.proceso = '$procesoEncu' AND encu_pro_ges.calificacion >= 90 THEN 1 ELSE 0 END) AS cantidad_satisfactorio, SUM(CASE WHEN encu_pro_ges.proceso = '$procesoEncu' THEN 1 ELSE 0 END) AS cantidad_total FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges JOIN encuestas_encuestas_procesos AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta JOIN encuestas_bases_encuestas AS encu_bases ON encu_pro.id_base_encu = encu_bases.id_base_encuesta
                    WHERE encu_pro.id_base_encu = $idBaseEncuesta");
    
                if($stmt->execute()){
    
                    return $stmt->fetch();
    
                }else{
    
                    return $stmt->errorInfo();
    
                }
    
            }

        }

    }

    static public function mdlInfoDatosIndicador1($idBaseEncuesta, $procesoEncu, $tipoEncuesta){

        if($tipoEncuesta == "VIH"){

            if($procesoEncu == "MEDICINA GENERAL" || $procesoEncu == "INFECTOLOGIA"){

                $stmt = Connection::connectBatch()->prepare("SELECT encu_bases.nombre, SUM(CASE WHEN encu_pro_ges.proceso = 'MEDICINA' AND encu_pro_ges.calificacion >= 90 THEN 1 ELSE 0 END) AS cantidad_satisfactorio, SUM(CASE WHEN encu_pro_ges.proceso = 'MEDICINA' AND encu_pro.estado = 'FINALIZADA' THEN 1 ELSE 0 END) AS cantidad_total FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges JOIN encuestas_encuestas_procesos AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta JOIN encuestas_bases_encuestas AS encu_bases ON encu_pro.id_base_encu = encu_bases.id_base_encuesta
                    WHERE encu_pro.especialidad = '$procesoEncu' AND encu_pro.id_base_encu = $idBaseEncuesta");
    
                if($stmt->execute()){
    
                    return $stmt->fetch();
    
                }else{
    
                    return $stmt->errorInfo();
    
                }
    
            }else{
    
                $stmt = Connection::connectBatch()->prepare("SELECT encu_bases.nombre, SUM(CASE WHEN encu_pro_ges.proceso = '$procesoEncu' AND encu_pro_ges.calificacion >= 90 THEN 1 ELSE 0 END) AS cantidad_satisfactorio, SUM(CASE WHEN encu_pro_ges.proceso = '$procesoEncu' THEN 1 ELSE 0 END) AS cantidad_total FROM encuestas_encuestas_procesos_gestion AS encu_pro_ges JOIN encuestas_encuestas_procesos AS encu_pro ON encu_pro_ges.id_encuesta = encu_pro.id_encuesta JOIN encuestas_bases_encuestas AS encu_bases ON encu_pro.id_base_encu = encu_bases.id_base_encuesta
                    WHERE encu_pro.id_base_encu = $idBaseEncuesta");
    
                if($stmt->execute()){
    
                    return $stmt->fetch();
    
                }else{
    
                    return $stmt->errorInfo();
    
                }
    
            }

        }else if($tipoEncuesta == "AUTOINMUNES"){


        }

    }


    static public function mdlPreguntasSegmentoIntrumento($idBaseEncuesta, $idEncuSegmento){

        $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
            WHERE encuestas_segmentos.id_encu_segmento = $idEncuSegmento AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlSegmentosInstrumento($idBaseEncuesta, $idInstrumento){

        $stmt = Connection::connectBatch()->prepare("SELECT encuestas_segmentos.id_encu_segmento, encuestas_procesos.proceso, encuestas_segmentos.segmento AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
            WHERE encuestas_procesos.id_encu_proceso = $idInstrumento AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_segmentos.porcentaje_general != 0 AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_segmentos.id_encu_segmento");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaInstrumentos($tabla, $tipoEncuesta){

        $stmt = Connection::connectBatch()->prepare("SELECT * FROM $tabla WHERE generacion = 'NORMAL' AND encuesta = '$tipoEncuesta'");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoReporteEspecidalidad($idBaseEncuesta, $tipoEncuesta, $especialidad, $tipo){

        if($tipoEncuesta == 'VIH'){

            switch ($tipo) {

                case 'DILIGENCIAMIENTO':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_procesos.proceso, encuestas_segmentos.segmento AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento IN (56,57,58,59,60,61,124) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_segmentos.id_encu_segmento");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'REGISTRO-ANTECEDENTES':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 56 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'EVALUACION-CLINICA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 57 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'SEGUIMIENTO-VACUNAS':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 58 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-1':
                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (266,268,274,276,278,280,282,284) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (267,269,275,277,279,281,283,285) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-2':
                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                    FROM (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                    WHERE encuestas_preguntas.id_encu_pregunta IN (270,272,286,288,290,292) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS ord
                    LEFT JOIN (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                    WHERE encuestas_preguntas.id_encu_pregunta IN (271,273,287,289,291,293) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-3':
                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                    FROM (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                    WHERE encuestas_preguntas.id_encu_pregunta IN (294,296,298,300,302,304,306,308) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS ord
                    LEFT JOIN (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                    WHERE encuestas_preguntas.id_encu_pregunta IN (295,297,299,301,303,305,307,309) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-GENERAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 59 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 59 THEN 0 END), 0) AS resultado_ordenado, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 124 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 124 THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta 
                    WHERE encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_preguntas.id_encu_segmento IN (59,124)");

                    $stmt->execute();
                    return $stmt->fetch();
                    break;

                case 'CITOLOGIA-ANAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 313 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = 313 AND encu_resp.respuesta = '1' THEN 'PACIENTES CON CITOLOGÍAS ANALES' WHEN encu_preg.id_encu_pregunta = 313 AND encu_resp.respuesta = '0' THEN 'SIN CITOLOGIA ANAL' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN (313) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'CITOLOGIA-VAGINAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 311 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = 311 AND encu_resp.respuesta = '1' THEN 'TOTAL CON CITOLOGÍA VAGINAL' WHEN encu_preg.id_encu_pregunta = 311 AND encu_resp.respuesta = '0' THEN 'SIN CITOLOGIA VAGINAL' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN (311) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encu_pro.sexo = 'FEMENINO' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ANTIGENO-PROSTATICO':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA POR EDAD' WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = '1' THEN 'CON PSA' WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = '0' THEN 'SIN PSA' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN (317) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encu_pro.sexo = 'MASCULINO' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'MAMOGRAFIA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 315 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = 315 AND encu_resp.respuesta = '1' THEN 'TOTAL CON MAMOGRAFÍA' WHEN encu_preg.id_encu_pregunta = 315 AND encu_resp.respuesta = '0' THEN 'TOTAL SIN MAMOGRAFÍA' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN (315) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encu_pro.sexo = 'FEMENINO' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'RECOMENDACIONES-COHERENCIA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 60 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ATRIBUTOS-CALIDAD':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 61 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                

            }

        }else if($tipoEncuesta == "AUTOINMUNES"){

            switch ($tipo) {

                case 'DILIGENCIAMIENTO':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_procesos.proceso, encuestas_segmentos.segmento AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento IN (3,4,5,6,123) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_segmentos.id_encu_segmento");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'EVALUACION-CLINICA-1':

                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (21,22,23,24,25,26,28) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'EVALUACION-CLINICA-2':

                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (29,27,30,31,32,33,34) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                    break;


                case 'PARACLINICOS-1':

                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (35,37,39,41,43,45,47,49,51,53) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (36,38,40,42,44,46,48,50,52,54) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();

                    break;


                case 'PARACLINICOS-2':

                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (55,57,59,61,63) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (56,58,60,62,64) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();

                    break;

                case 'PARACLINICOS-GENERAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 4 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 4 THEN 0 END), 0) AS resultado_ordenado, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 123 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 123 THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta 
                    WHERE encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_preguntas.id_encu_segmento IN (4,123)");

                    $stmt->execute();
                    return $stmt->fetch();
                    break;

                case 'RECOMENDACIONES-COHERENCIA':

                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 5 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ATRIBUTOS-CALIDAD':

                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 6 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();

                    break;

            }


        }

    }

    static public function mdlInfoReporteEspecidalidadxProfesional($idBaseEncuesta, $tipoEncuesta, $especialidad, $tipo, $auditor){

        if($tipoEncuesta == 'VIH'){

            switch ($tipo) {

                case 'DILIGENCIAMIENTO':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_procesos.proceso, encuestas_segmentos.segmento AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento IN (56,57,58,59,60,61,124) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_segmentos.id_encu_segmento");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'REGISTRO-ANTECEDENTES':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 56 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'EVALUACION-CLINICA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 57 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'SEGUIMIENTO-VACUNAS':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 58 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-1':
                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (266,268,274,276,278,280,282,284) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (267,269,275,277,279,281,283,285) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-2':
                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                    FROM (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                    WHERE encuestas_preguntas.id_encu_pregunta IN (270,272,286,288,290,292) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS ord
                    LEFT JOIN (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                    WHERE encuestas_preguntas.id_encu_pregunta IN (271,273,287,289,291,293) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-3':
                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                    FROM (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                    WHERE encuestas_preguntas.id_encu_pregunta IN (294,296,298,300,302,304,306,308) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS ord
                    LEFT JOIN (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                    WHERE encuestas_preguntas.id_encu_pregunta IN (295,297,299,301,303,305,307,309) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'PARACLINICOS-GENERAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 59 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 59 THEN 0 END), 0) AS resultado_ordenado, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 124 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 124 THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta 
                    WHERE encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_preguntas.id_encu_segmento IN (59,124) AND encuestas_encuestas_procesos.profesional_auditado = '$auditor'");

                    $stmt->execute();
                    return $stmt->fetch();
                    break;

                case 'CITOLOGIA-ANAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 313 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = 313 AND encu_resp.respuesta = '1' THEN 'PACIENTES CON CITOLOGÍAS ANALES' WHEN encu_preg.id_encu_pregunta = 313 AND encu_resp.respuesta = '0' THEN 'SIN CITOLOGIA ANAL' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encu_pro.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN (313) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encu_pro.profesional_auditado = '$auditor' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'CITOLOGIA-VAGINAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 311 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = 311 AND encu_resp.respuesta = '1' THEN 'TOTAL CON CITOLOGÍA VAGINAL' WHEN encu_preg.id_encu_pregunta = 311 AND encu_resp.respuesta = '0' THEN 'SIN CITOLOGIA VAGINAL' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encu_pro.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN (311) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encu_pro.profesional_auditado = '$auditor' AND encu_pro.sexo = 'FEMENINO' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ANTIGENO-PROSTATICO':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA POR EDAD' WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = '1' THEN 'CON PSA' WHEN encu_preg.id_encu_pregunta = 317 AND encu_resp.respuesta = '0' THEN 'SIN PSA' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encu_pro.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN (317) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encu_pro.profesional_auditado = '$auditor' AND encu_pro.sexo = 'MASCULINO' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'MAMOGRAFIA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 315 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = 315 AND encu_resp.respuesta = '1' THEN 'TOTAL CON MAMOGRAFÍA' WHEN encu_preg.id_encu_pregunta = 315 AND encu_resp.respuesta = '0' THEN 'TOTAL SIN MAMOGRAFÍA' ELSE 'NO MOSTRAR' END AS item, encu_resp.respuesta, COUNT(*) AS resultado FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encu_pro.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN (315) AND encu_pro.id_base_encu = $idBaseEncuesta AND encu_pro.especialidad = '$especialidad' AND encu_pro.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encu_pro.profesional_auditado = '$auditor' AND encu_pro.sexo = 'FEMENINO' GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING item != 'NO MOSTRAR' ORDER BY resultado DESC");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'RECOMENDACIONES-COHERENCIA':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 60 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ATRIBUTOS-CALIDAD':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 61 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 13 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                

            }

        }else if($tipoEncuesta == "AUTOINMUNES"){

            switch ($tipo) {

                case 'DILIGENCIAMIENTO':
                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_procesos.proceso, encuestas_segmentos.segmento AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento IN (3,4,5,6,123) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 3 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_segmentos.id_encu_segmento");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'EVALUACION-CLINICA-1':

                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (21,22,23,24,25,26,28) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 3 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'EVALUACION-CLINICA-2':

                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (29,27,30,31,32,33,34) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 3 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                    break;


                case 'PARACLINICOS-1':

                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (35,37,39,41,43,45,47,49,51,53) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 3 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (36,38,40,42,44,46,48,50,52,54) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 3 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();

                    break;


                case 'PARACLINICOS-2':

                    $stmt = Connection::connectBatch()->prepare("SELECT COALESCE(ord.id_encu_pregunta, anal.id_encu_pregunta) AS id_encu_pregunta, COALESCE(ord.segmento, anal.segmento) AS segmento, COALESCE(ord.item, anal.item) AS item, COALESCE(ord.titulo_descripcion, anal.titulo_descripcion) AS titulo_descripcion, COALESCE(ord.resultado_ordenado, 0) AS resultado_ordenado, COALESCE(anal.resultado_analizado, 0) AS resultado_analizado 
                        FROM (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_ordenado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (55,57,59,61,63) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 3 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS ord
                        LEFT JOIN (SELECT encuestas_preguntas.id_encu_pregunta, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, REPLACE(REPLACE(encuestas_preguntas.titulo_descripcion, ' - ORDENADO', ''), ' - ANALIZADO', '') AS titulo_descripcion, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_preguntas.id_encu_pregunta IN (56,58,60,62,64) AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 3 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion) AS anal ON ord.titulo_descripcion = anal.titulo_descripcion");

                    $stmt->execute();
                    return $stmt->fetchAll();

                    break;

                case 'PARACLINICOS-GENERAL':
                    $stmt = Connection::connectBatch()->prepare("SELECT TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 4 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 4 THEN 0 END), 0) AS resultado_ordenado, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' AND encuestas_preguntas.id_encu_segmento = 123 THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' AND encuestas_preguntas.id_encu_segmento = 123 THEN 0 END), 0) AS resultado_analizado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta 
                    WHERE encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_preguntas.id_encu_segmento IN (4,123) AND encuestas_encuestas_procesos.profesional_auditado = '$auditor'");

                    $stmt->execute();
                    return $stmt->fetch();
                    break;

                case 'RECOMENDACIONES-COHERENCIA':

                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 5 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 3 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();
                    break;

                case 'ATRIBUTOS-CALIDAD':

                    $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_procesos.proceso, encuestas_segmentos.segmento, encuestas_preguntas.titulo_descripcion AS item, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS resultado FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta JOIN encuestas_encuestas_procesos_gestion ON encuestas_encuestas_procesos.id_encuesta = encuestas_encuestas_procesos_gestion.id_encuesta
                        WHERE encuestas_segmentos.id_encu_segmento = 6 AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.especialidad = '$especialidad' AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_encuestas_procesos_gestion.id_encu_proceso = 3 AND encuestas_encuestas_procesos.profesional_auditado = '$auditor' GROUP BY encuestas_preguntas.id_encu_pregunta");

                    $stmt->execute();
                    return $stmt->fetchAll();

                    break;

            }


        }

    }

    static public function mdlInfoReportConsolidadoDatosIdentificacion($idBaseEncuesta, $idEncuProceso){

        $stmt = Connection::connectBatch()->prepare("SELECT encuestas_preguntas.id_encu_pregunta, encuestas_preguntas.titulo_descripcion, encuestas_procesos.proceso, encuestas_segmentos.segmento, TRUNCATE(AVG(CASE WHEN encuestas_encuestas_respuestas.respuesta = '1' THEN 100 WHEN encuestas_encuestas_respuestas.respuesta = '0' THEN 0 END), 0) AS calificacion, COUNT(*) AS cantidad FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_procesos.id_encu_proceso = encuestas_segmentos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta JOIN encuestas_encuestas_procesos ON encuestas_encuestas_respuestas.id_encuesta = encuestas_encuestas_procesos.id_encuesta
            WHERE encuestas_procesos.id_encu_proceso = $idEncuProceso AND encuestas_encuestas_procesos.id_base_encu = $idBaseEncuesta AND encuestas_encuestas_procesos.estado = 'FINALIZADA' GROUP BY encuestas_preguntas.id_encu_pregunta");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerCumplimientoAtencionInicialInstrumentos($idBaseEncuesta, $tipoEncuesta){
        
        switch ($tipoEncuesta) {
            case 'VIH':

                $stmt = Connection::connectBatch()->prepare("SELECT encu_pro_ges.proceso, COUNT(*) AS cantidad FROM encuestas_bases_encuestas AS encu_base JOIN encuestas_encuestas_procesos AS encu_pro ON encu_base.id_base_encuesta = encu_pro.id_base_encu JOIN encuestas_encuestas_respuestas AS encu_res ON encu_pro.id_encuesta = encu_res.id_encuesta JOIN encuestas_encuestas_procesos_gestion AS encu_pro_ges ON encu_res.id_encuesta = encu_pro_ges.id_encuesta
                    WHERE encu_res.id_encu_pregunta = 490 AND encu_res.respuesta = 'SI' AND encu_base.id_base_encuesta = $idBaseEncuesta AND encu_pro_ges.id_encu_proceso NOT IN (12, 13, 21, 16, 18, 19) AND encu_pro.estado = 'FINALIZADA' GROUP BY proceso ORDER BY cantidad DESC");

                $stmt->execute();

                return $stmt->fetchAll();

                break;

            case 'AUTOINMUNES':
                break;
        }

    }

    static public function mdlObtenerCumplimientoAtencionInicialEspecialidad($idBaseEncuesta, $tipoEncuesta){

        switch ($tipoEncuesta) {
            case 'VIH':

                $stmt = Connection::connectBatch()->prepare("SELECT encu_pro_ges.proceso, encu_pro.especialidad, COUNT(*) AS cantidad FROM encuestas_bases_encuestas AS encu_base JOIN encuestas_encuestas_procesos AS encu_pro ON encu_base.id_base_encuesta = encu_pro.id_base_encu JOIN encuestas_encuestas_respuestas AS encu_res ON encu_pro.id_encuesta = encu_res.id_encuesta JOIN encuestas_encuestas_procesos_gestion AS encu_pro_ges ON encu_res.id_encuesta = encu_pro_ges.id_encuesta
                    WHERE encu_res.id_encu_pregunta = 490 AND encu_res.respuesta = 'SI' AND encu_base.id_base_encuesta = $idBaseEncuesta AND encu_pro_ges.id_encu_proceso = 13 AND especialidad = 'MEDICINA GENERAL' AND encu_pro.estado = 'FINALIZADA' GROUP BY especialidad ORDER BY cantidad DESC");

                $stmt->execute();

                return $stmt->fetchAll();

                break;

            case 'AUTOINMUNES':
                break;
                
        }

    }

    static public function mdlInfoReporteConsolidadoFrencuenciaGrupo($idBaseEncuesta){

        $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 457 THEN 'MEDICO EXPERTO' WHEN encu_preg.id_encu_pregunta = 459 THEN 'INFECTOLOGIA' WHEN encu_preg.id_encu_pregunta = 462 THEN 'PSIQUIATRIA' WHEN encu_preg.id_encu_pregunta = 465 THEN 'ENFERMERIA' WHEN encu_preg.id_encu_pregunta = 467 THEN 'PSICOLOGIA' WHEN encu_preg.id_encu_pregunta = 469 THEN 'NUTRICION' WHEN encu_preg.id_encu_pregunta = 471 THEN 'TRABAJO SOCIAL' WHEN encu_preg.id_encu_pregunta = 473 THEN 'ODONTOLOGIA' WHEN encu_preg.id_encu_pregunta = 475 THEN 'QUIMICO FARMACEUTICO' ELSE 'ERROR' END AS titulo, encu_resp.respuesta, TRUNCATE(AVG(CASE WHEN encu_resp.respuesta = '1' THEN 100 WHEN encu_resp.respuesta = '0' THEN 0 END), 0) AS calificacion FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
            WHERE encu_preg.id_encu_pregunta IN (457, 459, 462, 465, 467, 469, 471, 473, 475) AND encu_pro.id_base_encu = $idBaseEncuesta GROUP BY encu_preg.id_encu_pregunta ORDER BY calificacion DESC");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoReporteFrencuencia($idBaseEncuesta, $tipoEncuesta, $frecuencia){

        if($tipoEncuesta == 'VIH'){

            switch ($frecuencia) {

                case 'MEDICO-EXPERTO':

                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.titulo_descripcion, CASE WHEN encu_resp.respuesta = 0 THEN 'NÚMERO DE PACIENTES ATENDIDOS POR FUERA DE LA FRECUENCIA ESTABLECIDA' ELSE 'NÚMERO DE PACIENTES ATENDIDOS UNA VEZ AL MES' END AS titulo, encu_resp.respuesta, COUNT(*) AS cantidad FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta = 457 AND encu_resp.respuesta != 'NA' AND encu_pro.id_base_encu = $idBaseEncuesta GROUP BY respuesta, encu_preg.id_encu_pregunta ORDER BY cantidad DESC;");

                    $stmt->execute();

                    return $stmt->fetchAll();
                    break;

                case 'INFECTOLOGIA':

                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 460 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = 459 AND encu_resp.respuesta = '1' THEN 'No. DE PACIENTES ATENDIDOS DENTRO DEL 1 TRIMESTRE' WHEN encu_preg.id_encu_pregunta = 460 AND encu_resp.respuesta = '1' THEN 'No. PACIENTES ATENDIDOS DENTRO DE LOS 6 MESES' WHEN encu_preg.id_encu_pregunta = 460 AND encu_resp.respuesta = '0' THEN 'No. PACIENTES ATENDIDOS POR FUERA DE LOS 6 MESES' ELSE 'NO MOSTRAR' END AS titulo, encu_resp.respuesta, COUNT(*) AS cantidad FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN (459, 460) AND encu_pro.id_base_encu = $idBaseEncuesta GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING titulo != 'NO MOSTRAR' ORDER BY cantidad DESC");
                    
                    $stmt->execute();

                    return $stmt->fetchAll();
                    break;

                case 'PSICOLOGIA':

                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.titulo_descripcion, CASE WHEN encu_resp.respuesta = 'NA' THEN 'NA ATENCIÓN' WHEN encu_resp.respuesta = 'DISENTIMIENTO' THEN 'DISENTIMIENTO' WHEN encu_resp.respuesta = 'NO REGISTRA ATENCIONES' THEN 'NÚMERO DE PACIENTES QUE NO TIENEN ATENCIONES POR PSICOLOGÍA' WHEN encu_resp.respuesta = '1' THEN 'NÚMERO DE PACIENTES ATENDIDOS DENTRO DE LOS 6 MESES' ELSE 'NÚMERO DE PACIENTES ATENDIDOS POR FUERA DE LOS 6 MESES' END AS titulo, encu_resp.respuesta, COUNT(*) AS cantidad FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta = 467 AND encu_pro.id_base_encu = $idBaseEncuesta GROUP BY respuesta, encu_preg.id_encu_pregunta ORDER BY cantidad DESC");
                    
                    $stmt->execute();

                    return $stmt->fetchAll();
                    break;

                case 'NUTRICION':

                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.titulo_descripcion, CASE WHEN encu_resp.respuesta = 'NA' THEN 'NA ATENCIÓN' WHEN encu_resp.respuesta = 'DISENTIMIENTO' THEN 'DISENTIMIENTO' WHEN encu_resp.respuesta = 'NO REGISTRA ATENCIONES' THEN 'NÚMERO DE PACIENTES QUE NO TIENEN ATENCIONES POR NUTRICIÓN' WHEN encu_resp.respuesta = '1' THEN 'NÚMERO DE PACIENTES ATENDIDOS DENTRO DE LOS 6 MESES' ELSE 'NÚMERO DE PACIENTES ATENDIDOS POR FUERA DE LOS 6 MESES' END AS titulo, encu_resp.respuesta, COUNT(*) AS cantidad FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta = 469 AND encu_pro.id_base_encu = $idBaseEncuesta GROUP BY respuesta, encu_preg.id_encu_pregunta ORDER BY cantidad DESC");
                    
                    $stmt->execute();

                    return $stmt->fetchAll();
                    break;

                case 'TRABAJO-SOCIAL':

                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.titulo_descripcion, CASE WHEN encu_resp.respuesta = 'NA' THEN 'NA ATENCIÓN' WHEN encu_resp.respuesta = 'DISENTIMIENTO' THEN 'DISENTIMIENTO' WHEN encu_resp.respuesta = 'NO REGISTRA ATENCIONES' THEN 'NÚMERO DE PACIENTES QUE NO TIENEN ATENCIONES POR T. SOCIAL' WHEN encu_resp.respuesta = '1' THEN 'NÚMERO DE PACIENTES ATENDIDOS DENTRO DE LOS 6 MESES' ELSE 'NÚMERO DE PACIENTES ATENDIDOS POR FUERA DE LOS 6 MESES' END AS titulo, encu_resp.respuesta, COUNT(*) AS cantidad FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta = 471 AND encu_pro.id_base_encu = $idBaseEncuesta GROUP BY respuesta, encu_preg.id_encu_pregunta ORDER BY cantidad DESC");
                    
                    $stmt->execute();

                    return $stmt->fetchAll();
                    break;

                case 'ODONTOLOGIA':

                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.titulo_descripcion, CASE WHEN encu_resp.respuesta = 'NA' THEN 'NA ATENCIÓN' WHEN encu_resp.respuesta = 'DISENTIMIENTO' THEN 'DISENTIMIENTO' WHEN encu_resp.respuesta = 'NO REGISTRA ATENCIONES' THEN 'NÚMERO DE PACIENTES QUE NO TIENEN ATENCIONES POR ODONTOLOGÍA' WHEN encu_resp.respuesta = '1' THEN 'NÚMERO DE PACIENTES ATENDIDOS DENTRO DE LOS 6 MESES' ELSE 'NÚMERO DE PACIENTES ATENDIDOS POR FUERA DE LOS 6 MESES' END AS titulo, encu_resp.respuesta, COUNT(*) AS cantidad FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta = 473 AND encu_pro.id_base_encu = $idBaseEncuesta GROUP BY respuesta, encu_preg.id_encu_pregunta ORDER BY cantidad DESC");
                    
                    $stmt->execute();

                    return $stmt->fetchAll();
                    break;

                case 'QUIMICO-FARMACEUTICO':

                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.titulo_descripcion, CASE WHEN encu_resp.respuesta = 'NA' THEN 'NA ATENCIÓN' WHEN encu_resp.respuesta = 'DISENTIMIENTO' THEN 'DISENTIMIENTO' WHEN encu_resp.respuesta = 'NO REGISTRA ATENCIONES' THEN 'NÚMERO DE PACIENTES QUE NO TIENEN ATENCIONES POR Q. F' WHEN encu_resp.respuesta = '1' THEN 'NÚMERO DE PACIENTES ATENDIDOS DENTRO DE LOS 6 MESES' ELSE 'NÚMERO DE PACIENTES ATENDIDOS POR FUERA DE LOS 6 MESES' END AS titulo, encu_resp.respuesta, COUNT(*) AS cantidad FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta = 475 AND encu_pro.id_base_encu = $idBaseEncuesta GROUP BY respuesta, encu_preg.id_encu_pregunta ORDER BY cantidad DESC");
                    
                    $stmt->execute();

                    return $stmt->fetchAll();
                    break;

                case 'ENFERMERIA':

                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.titulo_descripcion, CASE WHEN encu_resp.respuesta = 'NA' THEN 'NA ATENCIÓN' WHEN encu_resp.respuesta = 'DISENTIMIENTO' THEN 'DISENTIMIENTO' WHEN encu_resp.respuesta = 'NO REGISTRA ATENCIONES' THEN 'NÚMERO DE PACIENTES QUE NO TIENEN ATENCIONES POR ENFERMERÍA' WHEN encu_resp.respuesta = '1' THEN 'NÚMERO DE PACIENTES ATENDIDOS DENTRO DE LOS 6 MESES' ELSE 'NÚMERO DE PACIENTES ATENDIDOS POR FUERA DE LOS 6 MESES' END AS titulo, encu_resp.respuesta, COUNT(*) AS cantidad FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta = 465 AND encu_pro.id_base_encu = $idBaseEncuesta GROUP BY respuesta, encu_preg.id_encu_pregunta ORDER BY cantidad DESC;");
                    
                    $stmt->execute();

                    return $stmt->fetchAll();
                    break;

                case 'SIAU':

                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.titulo_descripcion, CASE WHEN encu_resp.respuesta = '1' THEN 'TOTAL DE PACIENTES CON SEGUIMIENTO EN LA HISTORIA CLÍNICA' WHEN encu_resp.respuesta = '0' THEN 'TOTAL DE PACIENTES SIN SEGUIMIENTO' WHEN encu_resp.respuesta = 'NA' THEN 'NO APLICA' ELSE 'NO VALIDO' END AS titulo, encu_resp.respuesta, COUNT(*) AS cantidad FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta = 477 AND encu_pro.id_base_encu = $idBaseEncuesta GROUP BY respuesta, encu_preg.id_encu_pregunta ORDER BY cantidad DESC");
                    
                    $stmt->execute();

                    return $stmt->fetchAll();
                    break;

                case 'PSIQUIATRIA':

                    $stmt = Connection::connectBatch()->prepare("SELECT encu_preg.id_encu_pregunta, encu_preg.titulo_descripcion, CASE WHEN encu_preg.id_encu_pregunta = 462 AND encu_resp.respuesta = '1' THEN 'ATENCION DENTRO DEL PRIMER TRIMESTRE DE INGRESO AL PROGRAMA' WHEN encu_preg.id_encu_pregunta = 463 AND encu_resp.respuesta = 'NO REGISTRA ATENCIONES' THEN 'SIN ATENCIONES' WHEN encu_preg.id_encu_pregunta = 463 AND encu_resp.respuesta = 'DISENTIMIENTO' THEN 'DISENTIMIENTO' WHEN encu_preg.id_encu_pregunta = 463 AND encu_resp.respuesta = 'NA' THEN 'NO APLICA' WHEN encu_preg.id_encu_pregunta = 463 AND encu_resp.respuesta = '1' THEN 'TIENE ATENCIÓN ANUAL' WHEN encu_preg.id_encu_pregunta = 463 AND encu_resp.respuesta = '0' THEN 'TIENE ATENCION FUERA DEL AÑO' ELSE 'NO MOSTRAR' END AS titulo, encu_resp.respuesta, COUNT(*) AS cantidad FROM encuestas_preguntas AS encu_preg JOIN encuestas_encuestas_respuestas AS encu_resp ON encu_preg.id_encu_pregunta = encu_resp.id_encu_pregunta JOIN encuestas_encuestas_procesos AS encu_pro ON encu_resp.id_encuesta = encu_pro.id_encuesta
                        WHERE encu_preg.id_encu_pregunta IN (462,463) AND encu_pro.id_base_encu = 8 GROUP BY respuesta, encu_preg.id_encu_pregunta HAVING titulo != 'NO MOSTRAR' ORDER BY cantidad DESC");
                    
                    $stmt->execute();

                    return $stmt->fetchAll();
                    break;
            }

        }else if($tipoEncuesta == 'AUTOINMUNES'){


        }

    }

    static public function mdlObtenerConsolidadoInstrumentos($idBaseEncuesta){

        $stmt = Connection::connectBatch()->prepare("SELECT encu_pg.id_encuesta, encu_pg.proceso, encu_pp.especialidad, COUNT(*) AS cantidad, TRUNCATE ( AVG( encu_pg.calificacion ), 0 ) AS puntaje FROM encuestas_procesos AS encu_p JOIN encuestas_encuestas_procesos_gestion AS encu_pg ON encu_p.id_encu_proceso = encu_pg.id_encu_proceso JOIN encuestas_encuestas_procesos AS encu_pp ON encu_pg.id_encuesta = encu_pp.id_encuesta
            WHERE encu_p.generacion = 'NORMAL' AND encu_pp.id_base_encu = $idBaseEncuesta AND encu_pp.estado = 'FINALIZADA' GROUP BY proceso");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerConsolidadoEspecialidad($idBaseEncuesta, $procesoEncu){

        $stmt = Connection::connectBatch()->prepare("SELECT encu_pg.id_encuesta, encu_pg.proceso, encu_p.especialidad, COUNT(*) AS cantidad, TRUNCATE ( AVG( encu_pg.calificacion ), 0 ) AS puntaje FROM encuestas_encuestas_procesos AS encu_p JOIN encuestas_encuestas_procesos_gestion AS encu_pg ON encu_p.id_encuesta = encu_pg.id_encuesta
            WHERE encu_pg.proceso = '$procesoEncu' AND encu_p.id_base_encu = $idBaseEncuesta AND encu_p.estado = 'FINALIZADA' GROUP BY encu_p.especialidad");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        
    }

    static public function mdlInfoReportConsolidadoEps($tabla, $idBaseEncuesta){

        $stmt = Connection::connectBatch()->prepare("SELECT eps, COUNT(*) AS cantidad FROM $tabla WHERE id_base_encu = $idBaseEncuesta AND estado = 'FINALIZADA' GROUP BY eps ORDER BY cantidad DESC");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();
            
        }

    }

    static public function mdlListaBasesEncuestas($tabla, $tipoEncuesta){

        $stmt = Connection::connectBatch()->prepare("SELECT * FROM $tabla WHERE tipo_encuestas = :tipo_encuestas AND estado IN ('CARGADO','AUDITADA')");

        $stmt->bindParam(":tipo_encuestas", $tipoEncuesta, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();
            
        }


    }

    static public function mdlListaReportesEncuestas($tabla, $tipoEncuesta){

        $stmt = Connection::connectBatch()->prepare("SELECT * FROM $tabla WHERE tipo_encuesta = :tipo_encuesta AND estado = 1");

        $stmt->bindParam(":tipo_encuesta", $tipoEncuesta, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();
            
        }

    }

    static public function mdlObtenerInfoEncuProceso($idEncuProceso, $tipoEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_procesos WHERE id_encu_proceso = $idEncuProceso AND encuesta = '$tipoEncuesta'");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerDato($tabla, $item, $valor){

        if($item == null){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            if($stmt->execute()){

                return $stmt->fetch();

            }else{

                return $stmt->errorInfo();

            }

        }

        $stmt = null;

    }


}
<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelEncuestasProfesional{

    static public function mdlEliminarRespuestas($idEncuesta, $idEncuProceso){

        $stmt = Connection::connectOnly()->prepare("DELETE FROM encuestas_encuestas_respuestas_profesional WHERE id_encuesta = :id_encuesta AND id_encu_proceso = :id_encu_proceso");

        $stmt->bindParam(":id_encuesta", $idEncuesta, PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_proceso", $idEncuProceso, PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarCalificacionProcesoSegmento($idEncuesta, $idEncuProceso){

        $stmt = Connection::connectOnly()->prepare("DELETE FROM encuestas_encuestas_procesos_gestion_detalle_profesional WHERE id_encuesta = :id_encuesta AND id_encu_proceso = :id_encu_proceso");

        $stmt->bindParam(":id_encuesta", $idEncuesta, PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_proceso", $idEncuProceso, PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPreguntasSegmentosEncuestaRespuesta($idEncuesta, $idEncuSegmento){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_segmentos_profesional.id_encu_proceso, encuestas_preguntas_profesional.*, encuestas_encuestas_respuestas_profesional.respuesta AS respu_encu FROM encuestas_segmentos_profesional JOIN encuestas_preguntas_profesional ON encuestas_segmentos_profesional.id_encu_segmento = encuestas_preguntas_profesional.id_encu_segmento JOIN encuestas_encuestas_respuestas_profesional ON encuestas_preguntas_profesional.id_encu_pregunta = encuestas_encuestas_respuestas_profesional.id_encu_pregunta 
            WHERE encuestas_preguntas_profesional.id_encu_segmento =  $idEncuSegmento AND encuestas_encuestas_respuestas_profesional.id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaEncuestasBolsaTerminadasProfesional($especialidad, $user){
        
        $day = date("Y-m-d");

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_encuestas_procesos_profesional.*, encuestas_bases_encuestas_profesional.auditor AS auditor_base, DATEDIFF('$day', encuestas_encuestas_procesos_profesional.fecha_fin) AS diff_fecha FROM encuestas_encuestas_procesos_profesional JOIN encuestas_bases_encuestas_profesional ON encuestas_encuestas_procesos_profesional.id_base_encu = encuestas_bases_encuestas_profesional.id_base_encuesta 
            WHERE encuestas_encuestas_procesos_profesional.especialidad = :especialidad AND encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' AND encuestas_bases_encuestas_profesional.auditor = :user HAVING diff_fecha >= 0 AND diff_fecha <= 3");

        $stmt->bindParam(":user", $user, PDO::PARAM_STR);
        $stmt->bindParam(":especialidad", $especialidad, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaBolsasTerminadasEncuestasProfesional($user){

        $day = date("Y-m-d");

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_encuestas_procesos_profesional.*, encuestas_bases_encuestas_profesional.auditor AS auditor_base, DATEDIFF( '$day', encuestas_encuestas_procesos_profesional.fecha_fin ) AS diff_fecha FROM encuestas_encuestas_procesos_profesional JOIN encuestas_bases_encuestas_profesional ON encuestas_encuestas_procesos_profesional.id_base_encu = encuestas_bases_encuestas_profesional.id_base_encuesta 
            WHERE encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' AND encuestas_bases_encuestas_profesional.auditor = :user AND DATEDIFF( '$day', encuestas_encuestas_procesos_profesional.fecha_fin ) >= 0 AND DATEDIFF( '$day', encuestas_encuestas_procesos_profesional.fecha_fin ) <= 3 GROUP BY encuestas_encuestas_procesos_profesional.especialidad ");

        $stmt->bindParam(":user", $user, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


    static public function mdlListaEncuestasBolsaPendientesProfesional($especialidad, $user){

        $stmt = Connection::connectOnly()->prepare("SELECT eepp.* FROM encuestas_bases_encuestas_profesional ebep JOIN encuestas_encuestas_procesos_profesional eepp ON ebep.id_base_encuesta = eepp.id_base_encu 
            WHERE eepp.estado = 'PROCESO' AND eepp.auditor = :user AND eepp.especialidad = :especialidad");

        $stmt->bindParam(":especialidad", $especialidad, PDO::PARAM_STR);
        $stmt->bindParam(":user", $user, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaBolsasPendientesEncuestasProfesional($user){

        $stmt = Connection::connectOnly()->prepare("SELECT eepp.* FROM encuestas_bases_encuestas_profesional ebep JOIN encuestas_encuestas_procesos_profesional eepp ON ebep.id_base_encuesta = eepp.id_base_encu 
            WHERE eepp.estado = 'PROCESO' AND eepp.auditor = :user GROUP BY eepp.especialidad");

        $stmt->bindParam(":user", $user, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlTerminarEncuesta($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET fecha_fin = :fecha_fin, estado = :estado WHERE id_encuesta = :id_encuesta");

        $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encuesta", $datos["id_encuesta"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerCalificacionesEncuesta($tabla, $idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidacionTerminarEncuesta($tabla, $idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_encuesta = $idEncuesta AND calificacion IS NULL");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarCalifacionEncuProcesoGestion($tabla, $idEncuProceso, $idEncuesta, $calificacionProceso){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET calificacion = $calificacionProceso WHERE id_encuesta = $idEncuesta AND id_encu_proceso = $idEncuProceso");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlGuardarRespuestasEncuesta($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_encu_proceso, id_encuesta, id_encu_pregunta, respuesta, especialidad, usuario_crea) VALUES (:id_encu_proceso, :id_encuesta, :id_encu_pregunta, :respuesta, :especialidad, :usuario_crea)");

        $stmt->bindParam(":id_encu_proceso", $datos["id_encu_proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encuesta", $datos["id_encuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_pregunta", $datos["id_encu_pregunta"], PDO::PARAM_STR);
        $stmt->bindParam(":respuesta", $datos["respuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":especialidad", $datos["especialidad"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPreguntasEncuestaProceso($idEncuProceso){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_preguntas_profesional.* FROM encuestas_procesos_profesional JOIN encuestas_segmentos_profesional ON encuestas_segmentos_profesional.id_encu_proceso = encuestas_procesos_profesional.id_encu_proceso JOIN encuestas_preguntas_profesional ON encuestas_preguntas_profesional.id_encu_segmento = encuestas_segmentos_profesional.id_encu_segmento WHERE encuestas_procesos_profesional.id_encu_proceso = $idEncuProceso;");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlGuardarCalificacionSegmento($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_encuesta, id_encu_proceso, id_encu_segmento, segmento, calificacion, usuario_crea) VALUES (:id_encuesta, :id_encu_proceso, :id_encu_segmento, :segmento, :calificacion, :usuario_crea)");

        $stmt->bindParam(":id_encuesta", $datos["idEncuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_proceso", $datos["idEncuProceso"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_segmento", $datos["idEncuSegmento"], PDO::PARAM_STR);
        $stmt->bindParam(":segmento", $datos["segmento"], PDO::PARAM_STR);
        $stmt->bindParam(":calificacion", $datos["notaSegmento"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuarioCrea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlListaSegmentosProcesoEncuestaPorcentaje($idEncuProceso){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_segmentos_profesional WHERE id_encu_proceso = $idEncuProceso AND porcentaje_segmento > 0");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaSegmentosParaclinicos($especialidad, $segmentos){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_segmentos_profesional WHERE id_encu_segmento IN ($segmentos)");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPreguntasSegmentosEncuesta($idEncuSegmento){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_segmentos_profesional.id_encu_proceso, encuestas_preguntas_profesional.* FROM encuestas_preguntas_profesional JOIN encuestas_segmentos_profesional ON encuestas_preguntas_profesional.id_encu_segmento = encuestas_segmentos_profesional.id_encu_segmento WHERE encuestas_preguntas_profesional.id_encu_segmento = $idEncuSegmento");
        
        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaSegmentosProcesoEncuesta($idEncuProceso){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_segmentos_profesional WHERE id_encu_proceso = $idEncuProceso");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlDescartarEncuesta($tabla, $idEncuesta, $hoy){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = 'DESCARTADA', fecha_fin = '$hoy' WHERE id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerProcesosGestionEncuesta($idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_encuestas_procesos_gestion_profesional WHERE id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlGuardarInfoAuditoriaEncuesta($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_encuestas_procesos_profesional SET nombre_paciente = :nombre_paciente, edad = :edad, sexo = :sexo, modalidad_consulta_tipo_atencion = :modalidad_consulta_tipo_atencion, usuario_edita = :usuario_edita, fecha_edita = :fecha_edita WHERE id_encuesta = :id_encuesta");

        $stmt->bindParam(":nombre_paciente", $datos["nombre_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":edad", $datos["edad"], PDO::PARAM_STR);
        $stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
        $stmt->bindParam(":modalidad_consulta_tipo_atencion", $datos["modalidad_consulta_tipo_atencion"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_edita", $datos["usuario_edita"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_edita", $datos["fecha_edita"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encuesta", $datos["id_encuesta"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlMostrarInformacionEncuesta($idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_encuestas_procesos_profesional WHERE encuestas_encuestas_procesos_profesional.id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarEstadoBase($idBaseEncuesta){

        $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_bases_encuestas_profesional SET estado = 'AUDITADA' WHERE id_base_encuesta = $idBaseEncuesta");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarEncuestasNoAplicadaBase($idBaseEncuesta){

        $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_encuestas_procesos_profesional SET estado = 'NO_APLICADA' WHERE id_base_encu = $idBaseEncuesta AND estado IN ('CREADA','PROCESO')");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlObtenerEncuestasTerminadasBase($idBaseEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT COUNT(*) AS cantidad_finalizadas FROM encuestas_encuestas_procesos_profesional WHERE id_base_encu = $idBaseEncuesta AND estado = 'FINALIZADA'");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearProcesosInicialesGestion($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_encuesta, id_encu_proceso, proceso, usuario_crea, nombre_usuario) VALUES (:id_encuesta, :id_encu_proceso, :proceso, :usuario_crea, :nombre_usuario)");

        $stmt->bindParam(":id_encuesta", $datos["id_encuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_proceso", $datos["id_encu_proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":proceso", $datos["proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_usuario", $datos["nombre_usuario"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerProcesosInicialesEncuesta($especialidad){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_procesos_profesional WHERE especialidad = :especialidad");

        $stmt->bindParam(":especialidad", $especialidad, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAsignarEncuesta($idEncuesta, $auditor, $fechaIni){

        $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_encuestas_procesos_profesional SET auditor = :auditor, estado = 'PROCESO', fecha_ini = :fecha_ini WHERE id_encuesta = :id_encuesta");

        $stmt->bindParam(":id_encuesta", $idEncuesta, PDO::PARAM_STR);
        $stmt->bindParam(":auditor", $auditor, PDO::PARAM_STR);
        $stmt->bindParam(":fecha_ini", $fechaIni, PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerEncuesta($idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_encuestas_procesos_profesional WHERE id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }

    static public function mdlListaEncuestasPendienteUser($user){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_encuestas_procesos_profesional WHERE auditor = :auditor AND estado = 'PROCESO'");

        $stmt->bindParam(":auditor", $user, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidacionBolsaEncuesta($idBaseEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT muestra, SUM( CASE WHEN encuestas_encuestas_procesos_profesional.estado = 'PROCESO' OR encuestas_encuestas_procesos_profesional.estado = 'FINALIZADA' THEN 1 ELSE 0 END ) AS cantidad FROM encuestas_bases_encuestas_profesional JOIN encuestas_encuestas_procesos_profesional ON encuestas_bases_encuestas_profesional.id_base_encuesta = encuestas_encuestas_procesos_profesional.id_base_encu 
            WHERE id_base_encuesta = :id_base_encuesta");

        $stmt->bindParam(":id_base_encuesta", $idBaseEncuesta, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerInfoEncuesta($especialidad, $user, $idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_encuestas_procesos_profesional.*, encuestas_bases_encuestas_profesional.auditor AS auditor_base FROM encuestas_encuestas_procesos_profesional JOIN encuestas_bases_encuestas_profesional ON encuestas_encuestas_procesos_profesional.id_base_encu = encuestas_bases_encuestas_profesional.id_base_encuesta 
            WHERE encuestas_encuestas_procesos_profesional.especialidad = :especialidad AND encuestas_encuestas_procesos_profesional.estado = 'CREADA' 
                AND encuestas_bases_encuestas_profesional.auditor = :auditor AND encuestas_encuestas_procesos_profesional.id_encuesta = :id_encuesta");

        $stmt->bindParam(":especialidad", $especialidad, PDO::PARAM_STR);
        $stmt->bindParam(":auditor", $user, PDO::PARAM_STR);
        $stmt->bindParam(":id_encuesta", $idEncuesta, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlObtenerIdEncuestasAuditorProfesional($especialidad, $auditor){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_encuestas_procesos_profesional.*, encuestas_bases_encuestas_profesional.auditor AS auditor_base FROM encuestas_encuestas_procesos_profesional JOIN encuestas_bases_encuestas_profesional ON encuestas_encuestas_procesos_profesional.id_base_encu = encuestas_bases_encuestas_profesional.id_base_encuesta 
            WHERE encuestas_encuestas_procesos_profesional.especialidad = :especialidad AND encuestas_encuestas_procesos_profesional.estado = 'CREADA' AND encuestas_bases_encuestas_profesional.auditor = :auditor");

        $stmt->bindParam(":especialidad", $especialidad, PDO::PARAM_STR);
        $stmt->bindParam(":auditor", $auditor, PDO::PARAM_STR);


        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaBolsasEncuestasProfesional($user){

        $stmt = Connection::connectOnly()->prepare("SELECT eepp.especialidad FROM encuestas_bases_encuestas_profesional ebep JOIN encuestas_encuestas_procesos_profesional eepp ON ebep.id_base_encuesta = eepp.id_base_encu
            WHERE ebep.estado = 'CARGADO' AND ebep.auditor = :user GROUP BY eepp.especialidad");

        $stmt->bindParam(":user", $user, PDO::PARAM_STR);
            
        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlListaEspecialidades($tabla, $especialidad){

        if($especialidad != "VACIO"){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE especialidad = :especialidad");

            $stmt->bindParam(":especialidad", $especialidad, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetch();
    
            }else{
    
                return $stmt->errorInfo();
    
            }

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll();
    
            }else{
    
                return $stmt->errorInfo();
    
            }

        }


        $stmt = null;

    }

    static public function mdlCrearEncuesta($tabla, $datos){

        $stmt = Connection::connectBatch()->prepare("INSERT INTO $tabla (id_base_encu, no_historia_clinica, nombre_paciente, edad, sexo, especialidad, profesional_auditado, sede, eps, fecha_atencion, modalidad_consulta_tipo_atencion) VALUES (:id_base_encu, :no_historia_clinica, :nombre_paciente, :edad, :sexo, :especialidad, :profesional_auditado, :sede, :eps, :fecha_atencion, :modalidad_consulta_tipo_atencion)");

        $stmt->bindParam(":id_base_encu", $datos["id_base_encu"], PDO::PARAM_STR);
        $stmt->bindParam(":no_historia_clinica", $datos["no_historia_clinica"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_paciente", $datos["nombre_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":edad", $datos["edad"], PDO::PARAM_STR);
        $stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
        $stmt->bindParam(":especialidad", $datos["especialidad"], PDO::PARAM_STR);
        $stmt->bindParam(":profesional_auditado", $datos["profesional_auditado"], PDO::PARAM_STR);
        $stmt->bindParam(":sede", $datos["sede"], PDO::PARAM_STR);
        $stmt->bindParam(":eps", $datos["eps"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_atencion", $datos["fecha_atencion"], PDO::PARAM_STR);
        $stmt->bindParam(":modalidad_consulta_tipo_atencion", $datos["modalidad_consulta_tipo_atencion"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarBaseEncuestas($proceso, $datos){

        if($proceso == "ERROR"){

            $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_bases_encuestas_profesional SET ruta_archivo_errors = :ruta_archivo_errors, estado = :estado, fecha_fin_valida = :fecha_fin_valida WHERE id_base_encuesta = :id_base_encuesta");

            $stmt->bindParam(":ruta_archivo_errors", $datos["ruta_archivo_errors"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_fin_valida", $datos["fecha_fin_valida"], PDO::PARAM_STR);
            $stmt->bindParam(":id_base_encuesta", $datos["id_base_encuesta"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else if($proceso == "ERROR_CARGA"){
        
            $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_bases_encuestas_profesional SET fecha_fin_carga = :fecha_fin_carga, estado = :estado, ruta_archivo_errors = :ruta_archivo_errors WHERE id_base_encuesta = :id_base_encuesta");

            $stmt->bindParam(":fecha_fin_carga", $datos["fecha_fin_carga"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
            $stmt->bindParam(":ruta_archivo_errors", $datos["ruta_archivo_errors"], PDO::PARAM_STR);
            $stmt->bindParam(":id_base_encuesta", $datos["id_base_encuesta"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;
        
        }else if($proceso == "CARGAR"){

            $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_bases_encuestas_profesional SET fecha_fin_valida = :fecha_fin_valida, estado = :estado WHERE id_base_encuesta = :id_base_encuesta");

            $stmt->bindParam(":fecha_fin_valida", $datos["fecha_fin_valida"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
            $stmt->bindParam(":id_base_encuesta", $datos["id_base_encuesta"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else if($proceso == "CARGADO"){

            $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_bases_encuestas_profesional SET fecha_fin_carga = :fecha_fin_carga, estado = :estado WHERE id_base_encuesta = :id_base_encuesta");

            $stmt->bindParam(":fecha_fin_carga", $datos["fecha_fin_carga"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
            $stmt->bindParam(":id_base_encuesta", $datos["id_base_encuesta"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }

    }

    static public function mdlObtenerArchivoCargar($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE estado = 'SUBIDA' ORDER BY fecha_crea ASC LIMIT 1");

        $stmt->execute();

        return $stmt->fetch();

        $stmt = null;

    }

    static public function mdlListaBasesEncuestas($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla ORDER BY id_base_encuesta DESC");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;

    }

    static public function mdlGuardarArchivoEncuestas($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla(nombre, nombre_archivo_original, nombre_archivo, especialidad, nivel_confianza, margen_error, muestra, ruta_archivo, cantidad, estado, usuario, auditor) VALUES (:nombre, :nombre_archivo_original, :nombre_archivo, :especialidad, :nivel_confianza, :margen_error, :muestra, :ruta_archivo, :cantidad, :estado, :usuario, :auditor)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_archivo_original", $datos["nombre_archivo_original"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_archivo", $datos["nombre_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":especialidad", $datos["especialidad"], PDO::PARAM_STR);
        $stmt->bindParam(":nivel_confianza", $datos["nivel_confianza"], PDO::PARAM_STR);
        $stmt->bindParam(":margen_error", $datos["margen_error"], PDO::PARAM_STR);
        $stmt->bindParam(":muestra", $datos["muestra"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":auditor", $datos["auditor"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerDato($tabla, $item, $valor){

        if($item != null){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();


        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();

        }

        $stmt = null;

    }

}
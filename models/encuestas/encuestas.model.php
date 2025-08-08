<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelEncuestas{

    static public function mdlListaSegmentosProcesoEncuestaPorcentaje($idEncuProceso){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_segmentos WHERE id_encu_proceso = $idEncuProceso AND porcentaje_segmento > 0");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarRespuestas($idEncuesta, $idEncuProceso){

        $stmt = Connection::connectOnly()->prepare("DELETE FROM encuestas_encuestas_respuestas WHERE id_encuesta = :id_encuesta AND id_encu_proceso = :id_encu_proceso");

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

        $stmt = Connection::connectOnly()->prepare("DELETE FROM encuestas_encuestas_procesos_gestion_detalle WHERE id_encuesta = :id_encuesta AND id_encu_proceso = :id_encu_proceso");

        $stmt->bindParam(":id_encuesta", $idEncuesta, PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_proceso", $idEncuProceso, PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarCalificacionProceso($idEncuesta, $idEncuProceso){

        $stmt = Connection::connectOnly()->prepare("DELETE FROM encuestas_encuestas_procesos_gestion WHERE id_encuesta = :id_encuesta AND id_encu_proceso = :id_encu_proceso");

        $stmt->bindParam(":id_encuesta", $idEncuesta, PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_proceso", $idEncuProceso, PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaEncuestasBolsaTerminadas($tipoEncuesta, $user){

        $day = date("Y-m-d");

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_encuestas_procesos.*, encuestas_bases_encuestas.auditor AS auditor_base, DATEDIFF('$day', encuestas_encuestas_procesos.fecha_fin) AS diff_fecha FROM encuestas_encuestas_procesos JOIN encuestas_bases_encuestas ON encuestas_encuestas_procesos.id_base_encu = encuestas_bases_encuestas.id_base_encuesta 
            WHERE tipo_encuesta = :tipo_encuesta AND encuestas_encuestas_procesos.estado = 'FINALIZADA' AND encuestas_bases_encuestas.auditor = :user AND encuestas_encuestas_procesos.usuario_edita IS NULL HAVING diff_fecha >= 0 AND diff_fecha <= 1;");

        $stmt->bindParam(":tipo_encuesta", $tipoEncuesta, PDO::PARAM_STR);    
        $stmt->bindParam(":user", $user, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;



    }

    static public function mdlGuardarInfoAuditoriaEncuesta($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_encuestas_procesos SET nombre_paciente = :nombre_paciente, edad = :edad, sexo = :sexo, modalidad_consulta = :modalidad_consulta, usuario_edita = :usuario_edita, fecha_edita = :fecha_edita WHERE id_encuesta = :id_encuesta");

        $stmt->bindParam(":nombre_paciente", $datos["nombre_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":edad", $datos["edad"], PDO::PARAM_STR);
        $stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
        $stmt->bindParam(":modalidad_consulta", $datos["modalidad_consulta"], PDO::PARAM_STR);
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

    static public function mdlListaAuditoresEncuesta($tipoEncuesta){

        if($tipoEncuesta == 'VIH'){

            $stmt = Connection::connectOnly()->prepare("SELECT usuarios.nombre, usuarios.usuario FROM usuarios_permisos JOIN usuarios ON usuarios_permisos.usuario = usuarios.usuario WHERE id_menu = 15 AND usuarios.usuario != 'administrador'");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll();
    
            }else{
    
                return $stmt->errorInfo();
    
            }
            
        }else{
            
            $stmt = Connection::connectOnly()->prepare("SELECT usuarios.nombre, usuarios.usuario FROM usuarios_permisos JOIN usuarios ON usuarios_permisos.usuario = usuarios.usuario WHERE id_menu = 14 AND usuarios.usuario != 'administrador'");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll();
    
            }else{
    
                return $stmt->errorInfo();
    
            }

        }


        $stmt = null;

    }

    static public function mdlActualizarEstadoBase($idBaseEncuesta){

        $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_bases_encuestas SET estado = 'AUDITADA' WHERE id_base_encuesta = $idBaseEncuesta");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlSelectAuditoresProceso($procesoProfesional, $tipoEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_profesionales_usuarios WHERE tipo_encuesta = '$tipoEncuesta' AND proceso = '$procesoProfesional' AND estado = 1");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarUsuarioProfesional($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = 0, usuario_elimina = :usuario_elimina, fecha_elimina = :fecha_elimina WHERE id_pro_usu = :id_pro_usu");

        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_elimina", $datos["fecha_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":id_pro_usu", $datos["id_pro_usu"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaUsuariosProfesionales(){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_profesionales_usuarios.*, encuestas_procesos.proceso FROM encuestas_profesionales_usuarios JOIN encuestas_procesos ON encuestas_profesionales_usuarios.id_encu_proceso = encuestas_procesos.id_encu_proceso WHERE encuestas_profesionales_usuarios.estado = 1");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAgregarUsuarioProfesional($datos, $proceso){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO encuestas_profesionales_usuarios (tipo_encuesta, id_encu_proceso, proceso, nombre_profesional, tipo_doc_profesional, documento_profesional, usuario_crea) VALUES (:tipo_encuesta, :id_encu_proceso, :proceso, :nombre_profesional, :tipo_doc_profesional, :documento_profesional, :usuario_crea)");

        $stmt->bindParam(":tipo_encuesta", $datos["tipo_encuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_proceso", $datos["id_encu_proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":proceso", $proceso, PDO::PARAM_STR);
        $stmt->bindParam(":nombre_profesional", $datos["nombre_profesional"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_doc_profesional", $datos["tipo_doc_profesional"], PDO::PARAM_STR);
        $stmt->bindParam(":documento_profesional", $datos["documento_profesional"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlValidarExisteUsuarioProfesional($datos){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_profesionales_usuarios WHERE id_encu_proceso = :id_encu_proceso AND tipo_doc_profesional = :tipo_doc_profesional AND documento_profesional = :documento_profesional");

        $stmt->bindParam(":id_encu_proceso", $datos["id_encu_proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_doc_profesional", $datos["tipo_doc_profesional"], PDO::PARAM_STR);
        $stmt->bindParam(":documento_profesional", $datos["documento_profesional"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaSegmentosParaclinicos($tipoEncuesta, $segmentos){

        if($tipoEncuesta == 'AUTOINMUNES'){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_segmentos WHERE id_encu_segmento IN ($segmentos)");

            if($stmt->execute()){

                return $stmt->fetchAll();
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;
            
        }else{
            
            $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_segmentos WHERE id_encu_segmento IN ($segmentos)");

            if($stmt->execute()){

                return $stmt->fetchAll();
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;


        }


    }

    static public function mdlEliminarCalificacionSegmento($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("DELETE FROM $tabla WHERE id_encuesta = :id_encuesta, id_encu_proceso = :id_encu_proceso, id_encu_segmento = :id_encu_segmento");

        $stmt->bindParam(":id_encuesta", $datos["id_encuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_proceso", $datos["id_encu_proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_segmento", $datos["id_encu_segmento"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

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

    static public function mdlActualizarEncuestasNoAplicadaBase($idBaseEncuesta){

        $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_encuestas_procesos SET estado = 'NO_APLICADA' WHERE id_base_encu = $idBaseEncuesta AND estado IN ('CREADA','PROCESO')");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlObtenerEncuestasTerminadasBase($idBaseEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT COUNT(*) AS cantidad_finalizadas FROM encuestas_encuestas_procesos WHERE id_base_encu = $idBaseEncuesta AND estado = 'FINALIZADA'");

        if($stmt->execute()){

            return $stmt->fetch();

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

    static public function mdlEliminarProfesional($idEncuProcesoGestion){

        $stmt = Connection::connectOnly()->prepare("DELETE FROM encuestas_encuestas_procesos_gestion WHERE id_encu_proce_gestion = $idEncuProcesoGestion");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaProcesosGestionEncuesta($idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_procesos.*, encuestas_encuestas_procesos_gestion.id_encuesta, encuestas_encuestas_procesos_gestion.id_encu_proce_gestion FROM encuestas_encuestas_procesos_gestion JOIN encuestas_procesos ON encuestas_encuestas_procesos_gestion.id_encu_proceso = encuestas_procesos.id_encu_proceso WHERE encuestas_encuestas_procesos_gestion.id_encuesta = $idEncuesta AND generacion = 'NORMAL'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidarExisteEncuestaProceso($idEncuProceso, $idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_encuestas_respuestas WHERE id_encu_proceso = $idEncuProceso AND id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlEliminarProcesosGestionNoIniciales($idEncuesta){

        $stmt = Connection::connectOnly()->prepare("DELETE FROM encuestas_encuestas_procesos_gestion WHERE id_encu_proceso IN ( SELECT encuestas_procesos.id_encu_proceso FROM encuestas_procesos WHERE encuestas_encuestas_procesos_gestion.id_encu_proceso = encuestas_procesos.id_encu_proceso AND encuestas_procesos.generacion = 'NORMAL' AND encuestas_encuestas_procesos_gestion.id_encuesta = $idEncuesta)");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAgregarProfesional($tabla, $datos){

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

    static public function mdlObtenerProcesosEncuestaNoIniciales($tipoEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_procesos WHERE encuesta = '$tipoEncuesta' AND generacion = 'NORMAL'");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerProcesosGestionEncuesta($idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_encuestas_procesos_gestion WHERE id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetchAll();

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

    static public function mdlDescartarEncuesta($tabla, $idEncuesta, $hoy){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = 'DESCARTADA', fecha_fin = '$hoy' WHERE id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidacionBolsaEncuesta($idBaseEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT muestra, SUM( CASE WHEN encuestas_encuestas_procesos.estado = 'PROCESO' OR encuestas_encuestas_procesos.estado = 'FINALIZADA' THEN 1 ELSE 0 END ) AS cantidad FROM encuestas_bases_encuestas JOIN encuestas_encuestas_procesos ON encuestas_bases_encuestas.id_base_encuesta = encuestas_encuestas_procesos.id_base_encu WHERE id_base_encuesta = $idBaseEncuesta");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlMostrarInformacionEncuesta($idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_encuestas_procesos WHERE encuestas_encuestas_procesos.id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetch();

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

    static public function mdlGuardarRespuestasEncuesta($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_encu_proceso, id_encuesta, id_encu_pregunta, respuesta, tipo_encuesta, usuario_crea) VALUES (:id_encu_proceso, :id_encuesta, :id_encu_pregunta, :respuesta, :tipo_encuesta, :usuario_crea)");

        $stmt->bindParam(":id_encu_proceso", $datos["id_encu_proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encuesta", $datos["id_encuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":id_encu_pregunta", $datos["id_encu_pregunta"], PDO::PARAM_STR);
        $stmt->bindParam(":respuesta", $datos["respuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_encuesta", $datos["tipo_encuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPreguntasEncuestaProceso($idEncuProceso){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_preguntas.* FROM encuestas_procesos JOIN encuestas_segmentos ON encuestas_segmentos.id_encu_proceso = encuestas_procesos.id_encu_proceso JOIN encuestas_preguntas ON encuestas_preguntas.id_encu_segmento = encuestas_segmentos.id_encu_segmento WHERE encuestas_procesos.id_encu_proceso = $idEncuProceso;");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlListaPreguntasSegmentosEncuesta($idEncuSegmento){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_segmentos.id_encu_proceso, encuestas_preguntas.* FROM encuestas_preguntas JOIN encuestas_segmentos ON encuestas_preguntas.id_encu_segmento = encuestas_segmentos.id_encu_segmento WHERE encuestas_preguntas.id_encu_segmento = $idEncuSegmento");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPreguntasSegmentosEncuestaRespuesta($idEncuesta, $idEncuSegmento){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_segmentos.id_encu_proceso, encuestas_preguntas.*, encuestas_encuestas_respuestas.respuesta AS respu_encu FROM encuestas_segmentos JOIN encuestas_preguntas ON encuestas_segmentos.id_encu_segmento = encuestas_preguntas.id_encu_segmento JOIN encuestas_encuestas_respuestas ON encuestas_preguntas.id_encu_pregunta = encuestas_encuestas_respuestas.id_encu_pregunta
            WHERE encuestas_preguntas.id_encu_segmento = $idEncuSegmento AND encuestas_encuestas_respuestas.id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaSegmentosProcesoEncuesta($idEncuProceso){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_segmentos WHERE id_encu_proceso = $idEncuProceso");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerProcesosInicialesEncuesta($tipoEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_procesos WHERE encuesta = '$tipoEncuesta' AND generacion = 'INICIAL'");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerProcesosEncuesta($tipoEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_procesos WHERE encuesta = '$tipoEncuesta'");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


    static public function mdlListaEncuestasPendientesUser($tipoEncuesta, $auditor){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_encuestas_procesos WHERE encuestas_encuestas_procesos.estado = 'PROCESO' AND encuestas_encuestas_procesos.tipo_encuesta = '$tipoEncuesta' AND encuestas_encuestas_procesos.auditor = '$auditor'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAsignarEncuesta($idEncuesta, $auditor, $fechaIni){

        $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_encuestas_procesos SET auditor = '$auditor', estado = 'PROCESO', fecha_ini = '$fechaIni' WHERE id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerEncuesta($idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_encuestas_procesos WHERE id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }

    static public function mdlListaEncuestasPendienteUser($user){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM encuestas_encuestas_procesos WHERE auditor = '$user' AND estado = 'PROCESO'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaEncuestasBolsa($tabla, $tipoEncuesta, $user){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_encuestas_procesos.*, encuestas_bases_encuestas.auditor AS auditor_base FROM encuestas_encuestas_procesos JOIN encuestas_bases_encuestas ON encuestas_encuestas_procesos.id_base_encu = encuestas_bases_encuestas.id_base_encuesta 
            WHERE tipo_encuesta = '$tipoEncuesta' AND encuestas_encuestas_procesos.estado = 'CREADA' AND encuestas_bases_encuestas.auditor = '$user' ORDER BY no_historia_clinica, nombre_paciente DESC LIMIT 1;");
        // $stmt = Connection::connectOnly()->prepare("SELECT encuestas_encuestas_procesos.*, encuestas_bases_encuestas.auditor AS auditor_base FROM encuestas_encuestas_procesos JOIN encuestas_bases_encuestas ON encuestas_encuestas_procesos.id_base_encu = encuestas_bases_encuestas.id_base_encuesta WHERE tipo_encuesta = '$tipoEncuesta' AND encuestas_encuestas_procesos.estado = 'CREADA' AND encuestas_bases_encuestas.auditor = '$user' AND encuestas_encuestas_procesos.id_encuesta >= (SELECT FLOOR(RAND() * (SELECT MAX(id_encuesta) FROM encuestas_encuestas_procesos))) ORDER BY encuestas_encuestas_procesos.id_encuesta ASC LIMIT 1");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerInfoEncuesta($tipoEncuesta, $user, $idEncuesta){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_encuestas_procesos.*, encuestas_bases_encuestas.auditor AS auditor_base FROM encuestas_encuestas_procesos JOIN encuestas_bases_encuestas ON encuestas_encuestas_procesos.id_base_encu = encuestas_bases_encuestas.id_base_encuesta 
            WHERE tipo_encuesta = '$tipoEncuesta' AND encuestas_encuestas_procesos.estado = 'CREADA' AND encuestas_bases_encuestas.auditor = '$user' AND encuestas_encuestas_procesos.id_encuesta = $idEncuesta");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlObtenerIdEncuestasAuditor($tipoEncuesta, $auditor){

        $stmt = Connection::connectOnly()->prepare("SELECT encuestas_encuestas_procesos.*, encuestas_bases_encuestas.auditor AS auditor_base FROM encuestas_encuestas_procesos JOIN encuestas_bases_encuestas ON encuestas_encuestas_procesos.id_base_encu = encuestas_bases_encuestas.id_base_encuesta 
            WHERE tipo_encuesta = '$tipoEncuesta' AND encuestas_encuestas_procesos.estado = 'CREADA' AND encuestas_bases_encuestas.auditor = '$auditor'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearEncuesta($tabla, $datos){

        $stmt = Connection::connectBatch()->prepare("INSERT INTO $tabla (id_base_encu, no_historia_clinica, nombre_paciente, edad, sexo, especialidad, profesional_auditado, sede, eps, fecha_atencion, modalidad_consulta, tipo_encuesta) VALUES (:id_base_encu, :no_historia_clinica, :nombre_paciente, :edad, :sexo, :especialidad, :profesional_auditado, :sede, :eps, :fecha_atencion, :modalidad_consulta, :tipo_encuesta)");

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
        $stmt->bindParam(":modalidad_consulta", $datos["modalidad_consulta"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_encuesta", $datos["tipo_encuesta"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarBaseEncuestas($proceso, $datos){

        if($proceso == "ERROR"){

            $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_bases_encuestas SET ruta_archivo_errors = :ruta_archivo_errors, estado = :estado, fecha_fin_valida = :fecha_fin_valida WHERE id_base_encuesta = :id_base_encuesta");

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
        
            $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_bases_encuestas SET fecha_fin_carga = :fecha_fin_carga, estado = :estado, ruta_archivo_errors = :ruta_archivo_errors WHERE id_base_encuesta = :id_base_encuesta");

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

            $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_bases_encuestas SET fecha_fin_valida = :fecha_fin_valida, estado = :estado WHERE id_base_encuesta = :id_base_encuesta");

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

            $stmt = Connection::connectOnly()->prepare("UPDATE encuestas_bases_encuestas SET fecha_fin_carga = :fecha_fin_carga, estado = :estado WHERE id_base_encuesta = :id_base_encuesta");

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

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla(nombre, nombre_archivo_original, nombre_archivo, tipo_encuestas, nivel_confianza, margen_error, muestra, ruta_archivo, cantidad, estado, usuario, auditor) VALUES (:nombre, :nombre_archivo_original, :nombre_archivo, :tipo_encuestas, :nivel_confianza, :margen_error, :muestra, :ruta_archivo, :cantidad, :estado, :usuario, :auditor)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_archivo_original", $datos["nombre_archivo_original"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_archivo", $datos["nombre_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_encuestas", $datos["tipo_encuestas"], PDO::PARAM_STR);
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
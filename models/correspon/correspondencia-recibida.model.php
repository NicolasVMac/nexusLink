<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelCorrespondenciaRecibida{

    static public function mdlListaCorrespondenciaRecibidaAll(){

        $stmt = Connection::connectOnly()->prepare("SELECT cr.*, cp.nombre_proyecto FROM correspondencia_correspondencia_recibida cr JOIN correspondencia_proyectos cp ON cr.id_proyecto = cp.id_proyecto WHERE is_active = 1");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaCorresponFactuRec(){

        $stmt = Connection::connectOnly()->prepare("SELECT cr.*, cp.nombre_proyecto FROM correspondencia_correspondencia_recibida cr JOIN correspondencia_proyectos cp ON cr.id_proyecto = cp.id_proyecto
            WHERE cr.estado = 'GESTIONADA' AND cr.aprobado_cartera != 'SIN_REVISION'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAprobarCorresponFacRec($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE correspondencia_correspondencia_recibida SET aprobado_cartera = :aprobado_cartera, observaciones_cartera = :observaciones_cartera, usuario_cartera = :usuario_cartera, fecha_cartera = :fecha_cartera WHERE id_corr_rec = :id_corr_rec");

        $stmt->bindParam(":aprobado_cartera", $datos["aprobado_cartera"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_cartera", $datos["observaciones_cartera"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_cartera", $datos["usuario_cartera"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cartera", $datos["fecha_cartera"], PDO::PARAM_STR);
        $stmt->bindParam(":id_corr_rec", $datos["id_corr_rec"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


    static public function mdlListaBolsaCorresponFactuRec(){

        $stmt = Connection::connectOnly()->prepare("SELECT cr.*, cp.nombre_proyecto FROM correspondencia_correspondencia_recibida cr JOIN correspondencia_proyectos cp ON cr.id_proyecto = cp.id_proyecto
            WHERE cr.estado = 'GESTIONADA' AND cr.aprobado_cartera = 'SIN_REVISION'");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlGestionarCorrespondenciaRecibida($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET observaciones_ges = :observaciones_ges, ruta_archivo_ges = :ruta_archivo_ges, usuario_gestion = :usuario_gestion, fecha_gestion = :fecha_gestion, estado = 'GESTIONADA', estado_asignacion = 'ACEPTADA', id_usuario_re_asignacion = null WHERE id_corr_rec = :id_corr_rec");

        $stmt->bindParam(":observaciones_ges", $datos["observaciones_ges"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo_ges", $datos["ruta_archivo_ges"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_gestion", $datos["usuario_gestion"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_gestion", $datos["fecha_gestion"], PDO::PARAM_STR);
        $stmt->bindParam(":id_corr_rec", $datos["id_corr_rec"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoCorrespondenciaRecibida($idCorresRec){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM correspondencia_correspondencia_recibida WHERE id_corr_rec = :id_corr_rec");

        $stmt->bindParam(":id_corr_rec", $idCorresRec, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAsignarUsuarioCorrespondenciaRec($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET id_usuario_re_asignacion = :id_usuario_re_asignacion, estado_asignacion = 'RE-ASIGNADA' WHERE id_corr_rec = :id_corr_rec");

        $stmt->bindParam(":id_usuario_re_asignacion", $datos["id_usuario_re_asignacion"], PDO::PARAM_STR);
        $stmt->bindParam(":id_corr_rec", $datos["id_corr_rec"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaUsuariosCorresponRecibida($idUserSesion){

        $stmt = Connection::connectOnly()->prepare("SELECT usuarios.id, usuarios.nombre, usuarios.usuario FROM usuarios JOIN usuarios_permisos ON usuarios.usuario = usuarios_permisos.usuario WHERE usuarios_permisos.id_menu = 22 AND usuarios.id != :id_user");

        $stmt->bindParam(":id_user", $idUserSesion, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlRechazarCorrespondenciaRecibida($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado_asignacion = :estado_asignacion WHERE id_corr_rec = :id_corr_rec");

        $stmt->bindParam(":id_corr_rec", $datos["id_corr_rec"], PDO::PARAM_STR);
        $stmt->bindParam(":estado_asignacion", $datos["estado_asignacion"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaMiCorresponRec($idUserSesion){

        $stmt = Connection::connectOnly()->prepare("SELECT cr.*, cp.nombre_proyecto FROM correspondencia_correspondencia_recibida cr JOIN correspondencia_proyectos cp ON cr.id_proyecto = cp.id_proyecto WHERE cr.id_responsable_proyecto = :id_responsable_proyecto AND is_active = 1 AND estado_asignacion NOT IN ('ASIGNADA', 'RECHAZADA')");

        $stmt->bindParam(":id_responsable_proyecto", $idUserSesion, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAceptarCorrespondenciaRecibida($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado_asignacion = 'ACEPTADA', id_responsable_proyecto = :id_responsable_proyecto, id_usuario_re_asignacion = NULL WHERE id_corr_rec = :id_corr_rec");

        $stmt->bindParam(":id_responsable_proyecto", $datos["id_user"], PDO::PARAM_STR);
        $stmt->bindParam(":id_corr_rec", $datos["id_corr_rec"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaMiBandejaCorresponRec($idUserSesion){

        // $stmt = Connection::connectOnly()->prepare("SELECT cr.*, cp.nombre_proyecto FROM correspondencia_correspondencia_recibida cr JOIN correspondencia_proyectos cp ON cr.id_proyecto = cp.id_proyecto WHERE cr.id_responsable_proyecto = :id_responsable_proyecto AND cr.estado_asignacion = 'ASIGNADA' AND is_active = 1");
        // $stmt = Connection::connectOnly()->prepare("SELECT cr.*, cp.nombre_proyecto FROM correspondencia_correspondencia_recibida cr JOIN correspondencia_proyectos cp ON cr.id_proyecto = cp.id_proyecto 
            // WHERE (cr.id_responsable_proyecto = :id_responsable_proyecto OR cr.id_usuario_re_asignacion = :id_responsable_proyecto) AND cr.estado_asignacion IN ('ASIGNADA', 'RE-ASIGNADA') AND is_active = 1");

        $stmt = Connection::connectOnly()->prepare("SELECT
            cr.*,
            cp.nombre_proyecto 
        FROM
            correspondencia_correspondencia_recibida cr
            JOIN correspondencia_proyectos cp ON cr.id_proyecto = cp.id_proyecto 
        WHERE
            (cr.id_responsable_proyecto = :id_responsable_proyecto AND cr.estado_asignacion = 'ASIGNADA')
            OR (cr.id_usuario_re_asignacion = :id_responsable_proyecto AND cr.estado_asignacion = 'RE-ASIGNADA')
            AND is_active = 1");

        $stmt->bindParam(":id_responsable_proyecto", $idUserSesion, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlReAsignarCorresRec($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET asunto = :asunto, observaciones = :observaciones, id_proyecto = :id_proyecto, id_responsable_proyecto = :id_responsable_proyecto, estado_asignacion = 'ASIGNADA' WHERE id_corr_rec = :id_corr_rec");

        $stmt->bindParam(":asunto", $datos["asunto"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
        $stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);
        $stmt->bindParam(":id_responsable_proyecto", $datos["id_responsable_proyecto"], PDO::PARAM_STR);
        $stmt->bindParam(":id_corr_rec", $datos["id_corr_rec"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarCorresponRec($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET is_active = 0 WHERE id_corr_rec = :id_corr_rec");

        $stmt->bindParam(":id_corr_rec", $datos["id_corr"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlRegistrarLogCorrespondencia($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_corr, categoria_correspon, mensaje, usuario_crea, fecha_crea) VALUES (:id_corr, :categoria_correspon, :mensaje, :usuario_crea, :fecha_crea)");

        $stmt->bindParam(":id_corr", $datos["id_corr"], PDO::PARAM_STR);
        $stmt->bindParam(":categoria_correspon", $datos["categoria_correspon"], PDO::PARAM_STR);
        $stmt->bindParam(":mensaje", $datos["mensaje"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoCorrespondenciaRec($idCorresRec){

        $stmt = Connection::connectOnly()->prepare("SELECT correspondencia_correspondencia_recibida.*, correspondencia_proyectos.nombre_proyecto, usuarios.nombre FROM correspondencia_correspondencia_recibida JOIN correspondencia_proyectos ON correspondencia_correspondencia_recibida.id_proyecto = correspondencia_proyectos.id_proyecto JOIN usuarios ON usuarios.id = correspondencia_correspondencia_recibida.id_responsable_proyecto 
            WHERE correspondencia_correspondencia_recibida.id_corr_rec = :id_corr_rec");

        $stmt->bindParam(":id_corr_rec", $idCorresRec, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlListaCorrespondenciaRecibida($user){

        $stmt = Connection::connectOnly()->prepare("SELECT correspondencia_correspondencia_recibida.*, correspondencia_proyectos.nombre_proyecto, usuarios.nombre FROM correspondencia_correspondencia_recibida JOIN correspondencia_proyectos ON correspondencia_correspondencia_recibida.id_proyecto = correspondencia_proyectos.id_proyecto JOIN usuarios ON usuarios.id = correspondencia_correspondencia_recibida.id_responsable_proyecto
            WHERE correspondencia_correspondencia_recibida.usuario_crea = :user AND estado_asignacion IN ('ASIGNADA', 'RECHAZADA') AND correspondencia_correspondencia_recibida.is_active = 1");

        $stmt->bindParam(":user", $user);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCargarCorrespondenciaRecibida($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_corr_env, asunto, observaciones, ruta_archivo_rec, id_proyecto, id_responsable_proyecto, tipo_correspondencia, usuario_crea) VALUES (:id_corr_env, :asunto, :observaciones, :ruta_archivo_rec, :id_proyecto, :id_responsable_proyecto, :tipo_correspondencia, :usuario_crea)");

        $stmt->bindParam(":id_corr_env", $datos["id_corr_env"], PDO::PARAM_STR);
        $stmt->bindParam(":asunto", $datos["asunto"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo_rec", $datos["ruta_archivo_rec"], PDO::PARAM_STR);
        $stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);
        $stmt->bindParam(":id_responsable_proyecto", $datos["id_responsable_proyecto"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_correspondencia", $datos["tipo_correspondencia"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaCorrespondenciaEnviadaProyecto($idProyecto){

        $stmt = Connection::connectOnly()->prepare("SELECT c_env.*, c_pro.nombre_proyecto, c_pro.numero_consecutivo, c_pro.prefijo_proyecto FROM correspondencia_correspondencia_enviada c_env JOIN correspondencia_proyectos c_pro ON c_env.id_proyecto = c_pro.id_proyecto 
            WHERE c_env.id_proyecto = :id_proyecto AND c_env.estado = 'RADICADO' ORDER BY c_pro.numero_consecutivo ASC");

        $stmt->bindParam(":id_proyecto", $idProyecto, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


}
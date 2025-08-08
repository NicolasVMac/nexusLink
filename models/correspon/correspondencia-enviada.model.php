<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelCorrespondenciaEnviada{

    static public function mdlListaCorrespondenciaEnviada(){

        $stmt = Connection::connectOnly()->prepare("SELECT correspondencia_correspondencia_enviada.*, correspondencia_proyectos.nombre_proyecto FROM correspondencia_correspondencia_enviada JOIN correspondencia_proyectos ON correspondencia_correspondencia_enviada.id_proyecto = correspondencia_proyectos.id_proyecto");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlRespuestaCorrespondenciaEnv($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET ruta_archivo_rec = :ruta_archivo_rec, estado = :estado, fecha_radicado = :fecha_radicado, radicado = :radicado, usuario_radicado = :usuario_radicado WHERE id_corr_env = :id_corr_env");

        $stmt->bindParam(":ruta_archivo_rec", $datos["ruta_archivo_rec"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_radicado", $datos["fecha_radicado"], PDO::PARAM_STR);
        $stmt->bindParam(":radicado", $datos["radicado"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_radicado", $datos["usuario_radicado"], PDO::PARAM_STR);
        $stmt->bindParam(":id_corr_env", $datos["id_corr_env"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlRadicarCorrespondenciaEnv($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET ruta_archivo_env = :ruta_archivo_env, asunto = :asunto, usuario_radicacion = :usuario_radicacion, estado = :estado, fecha_radicacion = :fecha_radicacion, destinatario = :destinatario, descripcion = :descripcion WHERE id_corr_env = :id_corr_env");

        $stmt->bindParam(":ruta_archivo_env", $datos["ruta_archivo_env"], PDO::PARAM_STR);
        $stmt->bindParam(":asunto", $datos["asunto"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_radicacion", $datos["usuario_radicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_radicacion", $datos["fecha_radicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":id_corr_env", $datos["id_corr_env"], PDO::PARAM_STR);
        $stmt->bindParam(":destinatario", $datos["destinatario"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAnularCorrespondenciaEnv($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = :estado, motivo_anula = :motivo_anula, usuario_anula = :usuario_anula, fecha_anula = CURRENT_TIMESTAMP WHERE id_corr_env = :id_corr_env");

        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":motivo_anula", $datos["motivo_anula"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_anula", $datos["usuario_anula"], PDO::PARAM_STR);
        $stmt->bindParam(":id_corr_env", $datos["id_corr_env"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }
    
    static public function mdlInfoCorrespondenciaEnv($idCorresEnv){

        $stmt = Connection::connectOnly()->prepare("SELECT cp.nombre_proyecto, ce.*, u.nombre FROM correspondencia_proyectos cp JOIN correspondencia_correspondencia_enviada ce ON cp.id_proyecto = ce.id_proyecto JOIN usuarios u ON ce.usuario_crea = u.usuario WHERE ce.id_corr_env = :id_corr_env");

        $stmt->bindParam(":id_corr_env", $idCorresEnv, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaMiCorrespondenciaEnviada($user){

        $stmt = Connection::connectOnly()->prepare("SELECT correspondencia_correspondencia_enviada.*, correspondencia_proyectos.nombre_proyecto FROM correspondencia_correspondencia_enviada JOIN correspondencia_proyectos ON correspondencia_correspondencia_enviada.id_proyecto = correspondencia_proyectos.id_proyecto
            WHERE correspondencia_correspondencia_enviada.usuario_crea = :user");

        $stmt->bindParam(":user", $user, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlCrearCorrespondencia($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO correspondencia_correspondencia_enviada (codigo, id_proyecto, tipo_comunicacion, usuario_crea) VALUES (:codigo, :id_proyecto, :tipo_comunicacion, :usuario_crea)");

        $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_comunicacion", $datos["tipo_comunicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarCodigoConsecutivo($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE correspondencia_proyectos SET numero_consecutivo = :numero_consecutivo WHERE id_proyecto = :id_proyecto");

        $stmt->bindParam(":numero_consecutivo", $datos["numero_consecutivo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerUltimoCodigoCorEnviada($idProyecto){

		$stmt = Connection::connectOnly()->prepare("SELECT codigo FROM correspondencia_correspondencia_enviada WHERE id_proyecto = :id_proyecto ORDER BY codigo DESC LIMIT 1");

        $stmt->bindParam(":id_proyecto", $idProyecto, PDO::PARAM_STR);

		if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

		$stmt = null;

	}

    static public function mdlObtenerCodigoConcecutivo($tabla, $idProyecto){

		$stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_proyecto = :id_proyecto");

        $stmt->bindParam(":id_proyecto", $idProyecto, PDO::PARAM_STR);

		if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

	}

}
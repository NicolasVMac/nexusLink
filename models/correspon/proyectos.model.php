<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelProyectosCorrespondencia{
    
    static public function mdlObtenerDatosActivos($tabla, $item, $valor){

        if($item == null){
            
            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE estado = 1");

            $stmt->execute();

            return $stmt->fetchAll();

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :valor AND estado = 1");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();	

        }

        $stmt = null;


    }

    static public function mdlEditarProyecto($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET nombre_proyecto = :nombre_proyecto, id_usuario_responsable = :id_usuario_responsable WHERE id_proyecto = :id_proyecto");

        $stmt->bindParam(":nombre_proyecto", $datos["nombre_proyecto"], PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario_responsable", $datos["id_usuario_responsable"], PDO::PARAM_STR);
        $stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerInfoProyecto($idProyecto){

        $stmt = Connection::connectOnly()->prepare("SELECT correspondencia_proyectos.*, usuarios.nombre, usuarios.usuario FROM correspondencia_proyectos JOIN usuarios ON correspondencia_proyectos.id_usuario_responsable = usuarios.id WHERE correspondencia_proyectos.id_proyecto = :id_proyecto");

        $stmt->bindParam(":id_proyecto", $idProyecto, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaProyectosCorrespondencia(){

        $stmt = Connection::connectOnly()->prepare("SELECT correspondencia_proyectos.*, usuarios.nombre, usuarios.usuario FROM correspondencia_proyectos JOIN usuarios ON correspondencia_proyectos.id_usuario_responsable = usuarios.id");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearProyecto($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (nombre_proyecto, prefijo_proyecto, id_usuario_responsable, usuario_crea) VALUES (:nombre_proyecto, :prefijo_proyecto, :id_usuario_responsable, :usuario_crea)");

        $stmt->bindParam(":nombre_proyecto", $datos["nombre_proyecto"], PDO::PARAM_STR);
        $stmt->bindParam(":prefijo_proyecto", $datos["prefijo_proyecto"], PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario_responsable", $datos["id_usuario_responsable"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }
    
    static public function mdlValidarExistePrefijoProyecto($prefijoProyecto){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM correspondencia_proyectos WHERE prefijo_proyecto = :prefijo_proyecto");

        $stmt->bindParam(":prefijo_proyecto", $prefijoProyecto, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


}
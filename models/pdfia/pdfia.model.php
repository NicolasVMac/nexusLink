<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelPdfia{
    static public function mdlGuardarArchivoPdf($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla(nombre , nombre_pdf , nombre_pdf_original , ruta_pdf , usuario_crea , fecha_crea ) VALUES (:nombre , :new_nombre_archivo , :nombre_original , :ruta_archivo , :usuario , :fecha_crea)");
        $stmt->bindParam(":nombre",$datos["nombre_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":new_nombre_archivo",$datos["new_nombre_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_original", $datos["nombre_original"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);
        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPdfCargados($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla ORDER BY id_pdf DESC");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;

    }

    static public function mdlActualizarSourceID($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET id_sourceid = :sourceId WHERE id_pdf = :id_pdf");
        $stmt->bindParam(":sourceId",$datos["sourceId"], PDO::PARAM_STR);
        $stmt->bindParam(":id_pdf",$datos["id_pdf"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return $stmt->errorInfo();
        }

        $stmt = null;

    }

    static public function mdlGuardarMensajePDF($tabla, $datos, $fechaHora){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_pdf , rol , descripcion , usuario_crea , fecha_crea) VALUES (:id_pdf,:rol,:contenido,:usuario,:fecha)");
        $stmt->bindParam(":id_pdf",$datos["id_pdf"], PDO::PARAM_STR);
        $stmt->bindParam(":rol",$datos["rol"], PDO::PARAM_STR);
        $stmt->bindParam(":contenido",$datos["contenido"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario",$datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha",$fechaHora, PDO::PARAM_STR);


        if($stmt->execute()){
            return "ok";
        }else{
            return $stmt->errorInfo();
        }

        $stmt = null;

    }

    static public function mdlListarMensajesPDF($tabla,$id_pdf){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_pdf = :id_pdf ");
        $stmt->bindParam(":id_pdf",$id_pdf, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;

    }

}
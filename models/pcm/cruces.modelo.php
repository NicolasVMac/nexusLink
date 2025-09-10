<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModeloCruces
{
    public static function mdlCruceRenc($tabla, $datos)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * from $tabla where reclamacionID=:idReclamacion;");

        $stmt->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }

    public static function mdlCruceRepsHabili($tabla, $datos)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * from $tabla where reclamacionID=:idReclamacion;");

        $stmt->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }

    public static function mdlCruceRepsProced($tabla, $datos)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * from $tabla where reclamacionID=:idReclamacion;");

        $stmt->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }

    public static function mdlCruceRepsTrans($tabla, $datos)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * from $tabla where reclamacionID=:idReclamacion;");

        $stmt->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }

    public static function mdlCrucePoliza($tabla, $datos)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * from $tabla where reclamacionID=:idReclamacion;");

        $stmt->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }

    public static function mdlCruceSiniestro($tabla, $datos)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * from $tabla where reclamacionID=:idReclamacion;");

        $stmt->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }
}

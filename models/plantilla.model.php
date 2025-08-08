<?php
require_once "connection.php";

class ModelPlantilla
{
    static public function mdlRutas($tabla, $carpeta, $ruta)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT*FROM (
            SELECT*,ruta AS ruta_fin FROM $tabla WHERE carpeta='' UNION ALL 
            SELECT*,CONCAT(carpeta,'/',ruta) AS ruta_fin FROM $tabla WHERE carpeta !='') AS rutas WHERE carpeta=:carpeta AND ruta=:ruta AND estado='1' LIMIT 1;");

        $stmt->bindParam(":carpeta", $carpeta, PDO::PARAM_STR);
        $stmt->bindParam(":ruta", $ruta, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return sizeof($resultado) > 0 ? $resultado[0] : "error";

        $stmt = null;
    }
}

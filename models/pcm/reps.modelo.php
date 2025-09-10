<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModeloReps
{
    

    public static function mdlRepsInfo($datos)
    {
       
        $stmt = Connection::connectOnly()->prepare("SELECT * from servicios_reps where codigo_habilitacion=:codigoHabilitacion;");
        
        $stmt->bindParam(":codigoHabilitacion", $datos["codigoHabilitacion"],PDO::PARAM_STR);

        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $stmt->errorInfo();
        }
        $stmt = null;



    }

}

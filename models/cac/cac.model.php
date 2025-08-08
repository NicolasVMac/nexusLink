<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";

require_once $rutaConnection;

date_default_timezone_set('America/Bogota');

class ModelCac{

    static public function mdlGuardarRutaErroresVali($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE cac_cac_bases SET ruta_archivo_errores = :ruta_archivo_errores WHERE id_base = :id_base");

        $stmt->bindParam(":ruta_archivo_errores", $datos["ruta_archivo_errores"], PDO::PARAM_STR);
        $stmt->bindParam(":id_base", $datos["id_base"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlMarcarErrorIdCac($tabla, $datos){

        $columnId = $datos["column_id"];

        $stmt = Connection::connectBatch()->prepare("UPDATE $tabla SET estado = :estado WHERE $columnId = :id_cac");

        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":id_cac", $datos["id_cac"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlRegistrarLogErrorValidacion($datos){

        $stmt = Connection::connectBatch()->prepare("INSERT INTO cac_cac_log_validaciones (id_base, mensaje) VALUES (:id_base, :mensaje)");

        $stmt->bindParam(":id_base", $datos["id_base"], PDO::PARAM_STR);
        $stmt->bindParam(":mensaje", $datos["mensaje"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


    static public function mdlActualizarEstadoBaseCac($datos){

        $stmt = Connection::connectBatch()->prepare("UPDATE cac_cac_bases SET estado = :estado ");

    }

    static public function mdlRegistrarLogErrorCarga($datos){

        $stmt = Connection::connectBatch()->prepare("INSERT INTO cac_cac_log_carga (id_base, mensaje) VALUES (:id_base, :mensaje)");

        $stmt->bindParam(":id_base", $datos["id_base"], PDO::PARAM_STR);
        $stmt->bindParam(":mensaje", $datos["mensaje"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static function mdlBasesCargadasCac(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM cac_cac_bases ORDER BY id_base DESC");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;

        
    }

    static public function mdlGuardarArchivoCac($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla(nombre, nombre_archivo_original, nombre_archivo, ruta_archivo, cantidad, estado, usuario_crea) VALUES (:nombre, :nombre_archivo_original, :nombre_archivo, :ruta_archivo, :cantidad, :estado, :usuario_crea)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_archivo_original", $datos["nombre_archivo_original"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_archivo", $datos["nombre_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


}
<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelContratistas
{

    static public function mdlListaTipoContratista($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * , CONCAT(tipo,' - ',tipo_contratistas) as tipo_contra FROM $tabla;");

        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }


    static public function mdlValidarExisteContratista($numeroDoc, $tipoDoc)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratistas WHERE tipo_identi_contratistas = :tipoDoc AND numero_identi_contratistas = :numeroDoc AND active='1'");

        $stmt->bindParam(":tipoDoc", $tipoDoc, PDO::PARAM_STR);
        $stmt->bindParam(":numeroDoc", $numeroDoc, PDO::PARAM_STR);
        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }


    static public function mdlCrearContratista($tabla, $datos)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("INSERT INTO $tabla (tipo_contratistas,nombre_contratistas,naturaleza,tipo_identi_contratistas,numero_identi_contratistas,direccion_contratistas,telefono_contratistas,departamento,ciudad,correo,usuario_crea,fecha_crea) VALUES (:tipoContratista,:nombreContratistaContratista,:naturalezaContratista,:tipoDocumentoContratista, :numeroDocumentoContratista,:direccionContratista,:telefonoContratista, :departamentoContratista,:ciudadContratista,:correoContratista,:usuario,CURRENT_TIMESTAMP)");

        $stmt->bindParam(":tipoContratista", $datos["tipoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":nombreContratistaContratista", $datos["nombreContratistaContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":naturalezaContratista", $datos["naturalezaContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":tipoDocumentoContratista", $datos["tipoDocumentoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":numeroDocumentoContratista", $datos["numeroDocumentoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":direccionContratista", $datos["direccionContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":telefonoContratista", $datos["telefonoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":departamentoContratista", $datos["departamentoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":ciudadContratista", $datos["ciudadContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":correoContratista", $datos["correoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);


        if ($stmt->execute()) {
            return 'ok';
        } else {
            return "error";
        }

        $stmt = null;
    }

    static public function mdlListaContratistas($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT cc.* , ptd.tipo as tipoDoc, ptd.descripcion as descripcionDoc, cptc.tipo_contratistas as descripcionTipoContratista,cc.active as estado  FROM contratistas_contratistas cc JOIN par_tipo_documentos ptd  on ptd.tipo=cc.tipo_identi_contratistas JOIN contratistas_par_tipos_contratistas cptc ON cptc.tipo=cc.tipo_contratistas");

        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlEliminarContratista($tabla, $idContratista)
    {

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET active='0' WHERE id_contratistas = $idContratista;");

        if ($stmt->execute()) {

            return 'ok';
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }


    static public function mdlListaContratosContratista($idContratista)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratistas_contratos WHERE id_contratista = :id_contratista");

        $stmt->bindParam(":id_contratista", $idContratista, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlCrearContrato($tabla, $datos)
    {

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_contratista, tipo_contrato, nombre_contrato, fecha_inicio, fecha_fin, fecha_fin_real, valor_contrato, cuantia_indeterminada, ruta_archivo_contrato, objeto_contractual, usuario_crea) VALUES (:id_contratista, :tipo_contrato, :nombre_contrato, :fecha_inicio, :fecha_fin, :fecha_fin_real, :valor_contrato, :cuantia_indeterminada, :ruta_archivo_contrato, :objeto_contractual, :usuario_crea)");

        $stmt->bindParam(":id_contratista", $datos["id_Contratista"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_contrato", $datos["tipo_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_contrato", $datos["nombre_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin_real", $datos["fecha_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":valor_contrato", $datos["valor_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":cuantia_indeterminada", $datos["cuantia_indeterminada"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo_contrato", $datos["ruta_archivo_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":objeto_contractual", $datos["objeto_contractual"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return 'ok';
        } else {
            return $stmt->errorInfo();
            
        }

        $stmt = null;
    }

    static public function mdlInfocontratista($idContratista)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT   contratistas_contratistas.*,   par_tipos_documentos.descripcion AS tipo_documento_contratista,   contratistas_par_tipos_contratistas.tipo_contratistas AS tipo_contratistas_full FROM   par_tipos_documentos   JOIN contratistas_contratistas ON contratistas_contratistas.tipo_identi_contratistas = par_tipos_documentos.codigo   JOIN contratistas_par_tipos_contratistas ON contratistas_contratistas.tipo_contratistas = contratistas_par_tipos_contratistas.tipo  WHERE contratistas_contratistas.id_contratistas = :id_contratista");

        $stmt->bindParam(":id_contratista", $idContratista, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }
}

<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelPagadores{

    static public function mdlListaContratosPagador($idPagador){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagadores_contratos WHERE id_pagador = :id_pagador");

        $stmt->bindParam(":id_pagador", $idPagador, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearContrato($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_pagador, tipo_contrato, nombre_contrato, fecha_inicio, fecha_fin, fecha_fin_real, valor_contrato, cuantia_indeterminada, ruta_archivo_contrato, objeto_contractual, usuario_crea) VALUES (:id_pagador, :tipo_contrato, :nombre_contrato, :fecha_inicio, :fecha_fin, :fecha_fin_real, :valor_contrato, :cuantia_indeterminada, :ruta_archivo_contrato, :objeto_contractual, :usuario_crea)");

        $stmt->bindParam(":id_pagador", $datos["id_pagador"], PDO::PARAM_STR);
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

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function ctrInfoPagador($idPagador){

        $stmt = Connection::connectOnly()->prepare("SELECT pagadores_pagadores.*, par_tipos_documentos.descripcion AS tipo_documento_pagador, pagadores_par_tipos_pagadores.tipo_pagador AS tipo_pagador_full FROM par_tipos_documentos JOIN pagadores_pagadores ON pagadores_pagadores.tipo_identi_pagador = par_tipos_documentos.codigo JOIN pagadores_par_tipos_pagadores ON pagadores_pagadores.tipo_pagador = pagadores_par_tipos_pagadores.tipo
            WHERE pagadores_pagadores.id_pagador = :id_pagador");

        $stmt->bindParam(":id_pagador", $idPagador, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPagadores(){

        $stmt = Connection::connectOnly()->prepare("SELECT pagadores_pagadores.*, par_tipos_documentos.descripcion AS tipo_documento_pagador, pagadores_par_tipos_pagadores.tipo_pagador AS tipo_pagador_full FROM par_tipos_documentos JOIN pagadores_pagadores ON pagadores_pagadores.tipo_identi_pagador = par_tipos_documentos.codigo JOIN pagadores_par_tipos_pagadores ON pagadores_pagadores.tipo_pagador = pagadores_par_tipos_pagadores.tipo");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
    
    }

    static public function mdlAgregarPagador($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (tipo_pagador, nombre_pagador, tipo_identi_pagador, numero_identi_pagador, direccion_pagador, telefono_pagador, departamento, ciudad, correo, usuario_crea) 
            VALUES (:tipo_pagador, :nombre_pagador, :tipo_identi_pagador, :numero_identi_pagador, :direccion_pagador, :telefono_pagador, :departamento, :ciudad, :correo, :usuario_crea)");

        $stmt->bindParam(":tipo_pagador", $datos["tipo_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_pagador", $datos["nombre_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_identi_pagador", $datos["tipo_identi_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_identi_pagador", $datos["numero_identi_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_pagador", $datos["direccion_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono_pagador", $datos["telefono_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento", $datos["departamento"], PDO::PARAM_STR);
        $stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


}


<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelReportesContratistas{

    static public function mdlListaEstadoPolizas($tipo){

        if($tipo == 'vencido'){

            $stmt = Connection::connectOnly()->prepare("SELECT
                tablaPolizas.id_poliza,
                tablaPolizas.id_contrato,
                tablaContrato.id_contratista,
                tablaContrato.tipo_contrato,
                tablaContrato.nombre_contrato,
                tablaPolizas.aseguradora,
                tablaPolizas.tipo_poliza,
                tablaPolizas.numero_poliza,
                tablaPolizas.amparo,
                tablaPolizas.fecha_inicio,
                tablaPolizas.fecha_fin,
                tablaPolizas.usuario_crea
                FROM (SELECT * FROM contratistas_contratistas_contratos WHERE fecha_fin_real > NOW() OR fecha_fin_real > NOW()) AS tablaContrato LEFT JOIN (SELECT * FROM contratistas_contratista_contratos_polizas WHERE is_active = 1) AS tablaPolizas ON tablaContrato.id_contrato = tablaPolizas.id_contrato
                WHERE id_poliza IS NOT NULL AND DATEDIFF(tablaPolizas.fecha_fin, NOW()) <= 1");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

            $stmt = null;

        }else if($tipo == '2-7'){

            $stmt = Connection::connectOnly()->prepare("SELECT
                tablaPolizas.id_poliza,
                tablaPolizas.id_contrato,
                tablaContrato.id_contratista,
                tablaContrato.tipo_contrato,
                tablaContrato.nombre_contrato,
                tablaPolizas.aseguradora,
                tablaPolizas.tipo_poliza,
                tablaPolizas.numero_poliza,
                tablaPolizas.amparo,
                tablaPolizas.fecha_inicio,
                tablaPolizas.fecha_fin,
                tablaPolizas.usuario_crea
                FROM (SELECT * FROM contratistas_contratistas_contratos WHERE fecha_fin_real > NOW() OR fecha_fin_real > NOW()) AS tablaContrato LEFT JOIN (SELECT * FROM contratistas_contratista_contratos_polizas WHERE is_active = 1) AS tablaPolizas ON tablaContrato.id_contrato = tablaPolizas.id_contrato
                WHERE id_poliza IS NOT NULL AND DATEDIFF( tablaPolizas.fecha_fin, NOW()) >= 2 AND DATEDIFF(tablaPolizas.fecha_fin,NOW()) < 8");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

            $stmt = null;


        }else if($tipo == '8-14'){

            $stmt = Connection::connectOnly()->prepare("SELECT
                tablaPolizas.id_poliza,
                tablaPolizas.id_contrato,
                tablaContrato.id_contratista,
                tablaContrato.tipo_contrato,
                tablaContrato.nombre_contrato,
                tablaPolizas.aseguradora,
                tablaPolizas.tipo_poliza,
                tablaPolizas.numero_poliza,
                tablaPolizas.amparo,
                tablaPolizas.fecha_inicio,
                tablaPolizas.fecha_fin,
                tablaPolizas.usuario_crea
                FROM (SELECT * FROM contratistas_contratistas_contratos WHERE fecha_fin_real > NOW() OR fecha_fin_real > NOW()) AS tablaContrato LEFT JOIN (SELECT * FROM contratistas_contratista_contratos_polizas WHERE is_active = 1) AS tablaPolizas ON tablaContrato.id_contrato = tablaPolizas.id_contrato
                WHERE id_poliza IS NOT NULL AND DATEDIFF( tablaPolizas.fecha_fin, NOW()) >= 8 AND DATEDIFF(tablaPolizas.fecha_fin,NOW()) < 15");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT
                tablaPolizas.id_poliza,
                tablaPolizas.id_contrato,
                tablaContrato.id_contratista,
                tablaContrato.tipo_contrato,
                tablaContrato.nombre_contrato,
                tablaPolizas.aseguradora,
                tablaPolizas.tipo_poliza,
                tablaPolizas.numero_poliza,
                tablaPolizas.amparo,
                tablaPolizas.fecha_inicio,
                tablaPolizas.fecha_fin,
                tablaPolizas.usuario_crea
                FROM (SELECT * FROM contratistas_contratistas_contratos WHERE fecha_fin_real > NOW() OR fecha_fin_real > NOW()) AS tablaContrato LEFT JOIN (SELECT * FROM contratistas_contratista_contratos_polizas WHERE is_active = 1) AS tablaPolizas ON tablaContrato.id_contrato = tablaPolizas.id_contrato
                WHERE id_poliza IS NOT NULL AND DATEDIFF(tablaPolizas.fecha_fin,NOW()) >= 15");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

        }

    }

    static public function mdlListaEstadoContratos($tipo){

        if($tipo == 'vencido'){

            $stmt = Connection::connectOnly()->prepare("SELECT ccc.*, cc.tipo_contratistas, cc.nombre_contratistas, CONCAT(cc.tipo_identi_contratistas, ' - ', cc.numero_identi_contratistas) AS contratista_identificacion FROM contratistas_contratistas cc INNER JOIN contratistas_contratistas_contratos ccc ON cc.id_contratistas = ccc.id_contratista
                WHERE DATEDIFF(ccc.fecha_fin_real, NOW()) <= 0 ORDER BY fecha_fin_real ASC");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

            $stmt = null;

        }else if($tipo == '1-30'){

            $stmt = Connection::connectOnly()->prepare("SELECT ccc.*, cc.tipo_contratistas, cc.nombre_contratistas, CONCAT(cc.tipo_identi_contratistas, ' - ', cc.numero_identi_contratistas) AS contratista_identificacion FROM contratistas_contratistas cc INNER JOIN contratistas_contratistas_contratos ccc ON cc.id_contratistas = ccc.id_contratista
                WHERE DATEDIFF( ccc.fecha_fin_real, NOW()) >= 1 AND DATEDIFF(ccc.fecha_fin_real,NOW()) <= 30 ORDER BY fecha_fin_real ASC");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

            $stmt = null;


        }else if($tipo == '31-59'){

            $stmt = Connection::connectOnly()->prepare("SELECT ccc.*, cc.tipo_contratistas, cc.nombre_contratistas, CONCAT(cc.tipo_identi_contratistas, ' - ', cc.numero_identi_contratistas) AS contratista_identificacion FROM contratistas_contratistas cc INNER JOIN contratistas_contratistas_contratos ccc ON cc.id_contratistas = ccc.id_contratista
                WHERE DATEDIFF( ccc.fecha_fin_real, NOW()) >= 31 AND DATEDIFF(ccc.fecha_fin_real, NOW()) <= 59 ORDER BY fecha_fin_real ASC");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT ccc.*, cc.tipo_contratistas, cc.nombre_contratistas, CONCAT(cc.tipo_identi_contratistas, ' - ', cc.numero_identi_contratistas) AS contratista_identificacion FROM contratistas_contratistas cc INNER JOIN contratistas_contratistas_contratos ccc ON cc.id_contratistas = ccc.id_contratista
                WHERE DATEDIFF( ccc.fecha_fin_real, NOW()) >= 60 ORDER BY fecha_fin_real ASC");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

        }

    }

    static public function mdlEstadoProcesoPolizas(){

        $stmt = Connection::connectOnly()->prepare("SELECT 
            SUM( CASE WHEN DATEDIFF( tablaPolizas.fecha_fin, NOW()) >= 15 THEN 1 ELSE 0 END ) AS CANTIDAD_FUTURO_VENCE,
            SUM( CASE WHEN DATEDIFF( tablaPolizas.fecha_fin, NOW()) >= 8 AND DATEDIFF( tablaPolizas.fecha_fin, NOW()) < 15 THEN 1 ELSE 0 END ) AS CANTIDAD_MESES_VENCIMIENTO,
            SUM( CASE WHEN DATEDIFF( tablaPolizas.fecha_fin, NOW()) >= 2 AND DATEDIFF(tablaPolizas.fecha_fin,NOW()) < 8 THEN 1 ELSE 0 END ) AS CANTIDAD_MES_VENCIMIENTO,
            SUM( CASE WHEN DATEDIFF( tablaPolizas.fecha_fin, NOW()) <= 1 THEN 1 ELSE 0 END ) AS CANTIDAD_VENCIDO 
            FROM ( SELECT * FROM contratistas_contratistas_contratos WHERE fecha_fin > NOW() OR fecha_fin_real > NOW()) AS tablaContrato
            LEFT JOIN( SELECT * FROM contratistas_contratista_contratos_polizas WHERE is_active = 1 ) AS tablaPolizas ON tablaContrato.id_contrato= tablaPolizas.id_contrato WHERE id_poliza IS NOT NULL");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEstadoProcesoContratos(){

        $stmt = Connection::connectOnly()->prepare("SELECT
            SUM( CASE WHEN DATEDIFF( cc.fecha_fin_real, NOW()) >= 60 THEN 1 ELSE 0 END ) AS CANTIDAD_FUTURO_VENCEN,
            SUM( CASE WHEN DATEDIFF( cc.fecha_fin_real, NOW()) >= 31 AND DATEDIFF(cc.fecha_fin_real, NOW()) <= 59 THEN 1 ELSE 0 END ) AS CANTIDAD_MESES_VENCIMIENTO,
            SUM( CASE WHEN DATEDIFF( cc.fecha_fin_real, NOW()) >= 1 AND DATEDIFF(cc.fecha_fin_real,NOW()) <= 30 THEN 1 ELSE 0 END ) AS CANTIDAD_MES_VENCIMIENTO,
            SUM( CASE WHEN DATEDIFF( cc.fecha_fin_real, NOW()) <= 0 THEN 1 ELSE 0 END ) AS CANTIDAD_VENCIDO
            FROM contratistas_contratistas_contratos cc");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaReportesContratistas($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE estado = 1");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


}
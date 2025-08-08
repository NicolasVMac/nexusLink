<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelPqrsfReportes{

    static public function mdlReportTipoPqrsfOportunidadSedeDias($fechaAnio, $sede, $eps){

        $txtEps = "";

        if($eps != "TODAS"){

            $txtEps = "AND eps = '$eps'";

        }

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM (
            (SELECT
            pqr_pqrs.tipo_pqr,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 1 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 1 THEN 1 ELSE 0 END), 0), 0), 2) AS ENERO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 2 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 2 THEN 1 ELSE 0 END), 0), 0), 2) AS FEBRERO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 3 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 3 THEN 1 ELSE 0 END), 0), 0), 2) AS MARZO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 4 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 4 THEN 1 ELSE 0 END), 0), 0), 2) AS ABRIL,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 5 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 5 THEN 1 ELSE 0 END), 0), 0), 2) AS MAYO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 6 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 6 THEN 1 ELSE 0 END), 0), 0), 2) AS JUNIO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 7 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 7 THEN 1 ELSE 0 END), 0), 0), 2) AS JULIO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 8 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 8 THEN 1 ELSE 0 END), 0), 0), 2) AS AGOSTO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 9 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 9 THEN 1 ELSE 0 END), 0), 0), 2) AS SEPTIEMBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 10 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 10 THEN 1 ELSE 0 END), 0), 0), 2) AS OCTUBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 11 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 11 THEN 1 ELSE 0 END), 0), 0), 2) AS NOVIEMBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 12 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 12 THEN 1 ELSE 0 END), 0), 0 ), 2) AS DICIEMBRE,
            CONCAT(pqr_par_tipos_pqr.cantidad, ' ', pqr_par_tipos_pqr.tiempo, ' HABILES') AS tiempo_normativo,
            TRUNCATE(IF(pqr_par_tipos_pqr.tiempo = 'HORAS', pqr_par_tipos_pqr.cantidad / 24, pqr_par_tipos_pqr.cantidad), 0) AS dias_normativos
            FROM
            pqr_pqrs
            JOIN pqr_par_tipos_pqr ON pqr_pqrs.tipo_pqr = pqr_par_tipos_pqr.tipo_pqr
            WHERE
            estado_pqr = 'FINALIZADO'
            AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59'
            AND sede = :sede $txtEps
            GROUP BY
            tipo_pqr
            ORDER BY
            tipo_pqr ASC)
            UNION
            (SELECT
            'TOTAL' as tipo_pqr,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 1 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 1 THEN 1 ELSE 0 END), 0), 0), 2) AS ENERO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 2 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 2 THEN 1 ELSE 0 END), 0), 0), 2) AS FEBRERO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 3 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 3 THEN 1 ELSE 0 END), 0), 0), 2) AS MARZO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 4 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 4 THEN 1 ELSE 0 END), 0), 0), 2) AS ABRIL,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 5 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 5 THEN 1 ELSE 0 END), 0), 0), 2) AS MAYO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 6 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 6 THEN 1 ELSE 0 END), 0), 0), 2) AS JUNIO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 7 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 7 THEN 1 ELSE 0 END), 0), 0), 2) AS JULIO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 8 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 8 THEN 1 ELSE 0 END), 0), 0), 2) AS AGOSTO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 9 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 9 THEN 1 ELSE 0 END), 0), 0), 2) AS SEPTIEMBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 10 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 10 THEN 1 ELSE 0 END), 0), 0), 2) AS OCTUBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 11 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 11 THEN 1 ELSE 0 END), 0), 0), 2) AS NOVIEMBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 12 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 12 THEN 1 ELSE 0 END), 0), 0 ), 2) AS DICIEMBRE,
            '' AS tiempo_normativo,
            '' AS horas_normativas
            FROM
            pqr_pqrs
            JOIN pqr_par_tipos_pqr ON pqr_pqrs.tipo_pqr = pqr_par_tipos_pqr.tipo_pqr
            WHERE
            estado_pqr = 'FINALIZADO'
            AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59'
            AND sede = :sede $txtEps)
            ) AS tabla");

        $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

        if($stmt->execute()){
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlReportTipoPqrsfOportunidadSedeHoras($fechaAnio, $sede, $eps){

        $txtEps = "";

        if($eps != "TODAS"){

            $txtEps = "AND eps = '$eps'";

        }

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM (
            (SELECT
            pqr_pqrs.tipo_pqr,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 1 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 1 THEN 1 ELSE 0 END), 0), 0), 2) AS ENERO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 2 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 2 THEN 1 ELSE 0 END), 0), 0), 2) AS FEBRERO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 3 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 3 THEN 1 ELSE 0 END), 0), 0), 2) AS MARZO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 4 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 4 THEN 1 ELSE 0 END), 0), 0), 2) AS ABRIL,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 5 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 5 THEN 1 ELSE 0 END), 0), 0), 2) AS MAYO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 6 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 6 THEN 1 ELSE 0 END), 0), 0), 2) AS JUNIO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 7 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 7 THEN 1 ELSE 0 END), 0), 0), 2) AS JULIO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 8 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 8 THEN 1 ELSE 0 END), 0), 0), 2) AS AGOSTO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 9 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 9 THEN 1 ELSE 0 END), 0), 0), 2) AS SEPTIEMBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 10 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 10 THEN 1 ELSE 0 END), 0), 0), 2) AS OCTUBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 11 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 11 THEN 1 ELSE 0 END), 0), 0), 2) AS NOVIEMBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 12 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 12 THEN 1 ELSE 0 END), 0), 0 ), 2) AS DICIEMBRE,
            CONCAT(pqr_par_tipos_pqr.cantidad, ' ', pqr_par_tipos_pqr.tiempo, ' HABILES') AS tiempo_normativo,
            IF(pqr_par_tipos_pqr.tiempo = 'DIAS', pqr_par_tipos_pqr.cantidad * 24, pqr_par_tipos_pqr.cantidad) AS horas_normativas
            FROM
            pqr_pqrs
            JOIN pqr_par_tipos_pqr ON pqr_pqrs.tipo_pqr = pqr_par_tipos_pqr.tipo_pqr
            WHERE
            estado_pqr = 'FINALIZADO'
            AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59'
            AND sede = :sede $txtEps
            GROUP BY
            tipo_pqr
            ORDER BY
            tipo_pqr ASC)
            UNION
            (SELECT
            'TOTAL' as tipo_pqr,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 1 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 1 THEN 1 ELSE 0 END), 0), 0), 2) AS ENERO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 2 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 2 THEN 1 ELSE 0 END), 0), 0), 2) AS FEBRERO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 3 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 3 THEN 1 ELSE 0 END), 0), 0), 2) AS MARZO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 4 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 4 THEN 1 ELSE 0 END), 0), 0), 2) AS ABRIL,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 5 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 5 THEN 1 ELSE 0 END), 0), 0), 2) AS MAYO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 6 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 6 THEN 1 ELSE 0 END), 0), 0), 2) AS JUNIO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 7 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 7 THEN 1 ELSE 0 END), 0), 0), 2) AS JULIO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 8 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 8 THEN 1 ELSE 0 END), 0), 0), 2) AS AGOSTO,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 9 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 9 THEN 1 ELSE 0 END), 0), 0), 2) AS SEPTIEMBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 10 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 10 THEN 1 ELSE 0 END), 0), 0), 2) AS OCTUBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 11 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 11 THEN 1 ELSE 0 END), 0), 0), 2) AS NOVIEMBRE,
            TRUNCATE(COALESCE(SUM(CASE WHEN MONTH(fecha_pqr) = 12 THEN calcular_horas_habiles(fecha_pqr, fecha_respuesta_pqr) ELSE 0 END) / NULLIF(SUM(CASE WHEN MONTH(fecha_pqr) = 12 THEN 1 ELSE 0 END), 0), 0 ), 2) AS DICIEMBRE,
            '' AS tiempo_normativo,
            '' AS horas_normativas
            FROM
            pqr_pqrs
            JOIN pqr_par_tipos_pqr ON pqr_pqrs.tipo_pqr = pqr_par_tipos_pqr.tipo_pqr
            WHERE
            estado_pqr = 'FINALIZADO'
            AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59'
            AND sede = :sede $txtEps)
            ) AS tabla");

        $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

        if($stmt->execute()){
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPQRSEstadoProceso($tipo, $sede){

        switch ($tipo){

            case 'VENCIDAS':

                if($sede == 'TODAS'){

                    $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.* FROM pqr_pqrs WHERE DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) < 0 AND estado_pqr NOT IN ('PRECREADA', 'FINALIZADO')");

                    if($stmt->execute()){

                        return $stmt->fetchAll(PDO::FETCH_ASSOC);

                    }else{

                        return $stmt->errorInfo();

                    }

                    $stmt = null;

                }else{

                    $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.* FROM pqr_pqrs WHERE DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) < 0 AND estado_pqr NOT IN ('PRECREADA', 'FINALIZADO') AND sede = :sede");

                    $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

                    if($stmt->execute()){

                        return $stmt->fetchAll(PDO::FETCH_ASSOC);

                    }else{

                        return $stmt->errorInfo();

                    }

                    $stmt = null;


                }

                break;

            case 'A-VENCER':

                if($sede == 'TODAS'){

                    $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.* FROM pqr_pqrs WHERE DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) >= 1 AND DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) <= 3 AND estado_pqr NOT IN ('PRECREADA', 'FINALIZADO')");
    
                    if($stmt->execute()){
    
                        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                    }else{
    
                        return $stmt->errorInfo();
    
                    }
    
                    $stmt = null;

                }else{
                    
                    $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.* FROM pqr_pqrs WHERE DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) >= 1 AND DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) <= 3 AND estado_pqr NOT IN ('PRECREADA', 'FINALIZADO') AND sede = :sede");
    
                    $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

                    if($stmt->execute()){
    
                        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                    }else{
    
                        return $stmt->errorInfo();
    
                    }
    
                    $stmt = null;

                }

                break;

            case 'A-TIEMPO':

                if($sede == 'TODAS'){

                    $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.* FROM pqr_pqrs WHERE DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) > 3 AND estado_pqr NOT IN ('PRECREADA', 'FINALIZADO')");

                    if($stmt->execute()){

                        return $stmt->fetchAll(PDO::FETCH_ASSOC);

                    }else{

                        return $stmt->errorInfo();

                    }

                    $stmt = null;
                    
                }else{
                    
                    $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.* FROM pqr_pqrs WHERE DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) > 3 AND estado_pqr NOT IN ('PRECREADA', 'FINALIZADO') AND sede = :sede");

                    $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

                    if($stmt->execute()){

                        return $stmt->fetchAll(PDO::FETCH_ASSOC);

                    }else{

                        return $stmt->errorInfo();

                    }

                    $stmt = null;

                }

                break;
            
        }


    }

    static public function mdlListaReporteEstadoProcesoPQRSF($sede){

        if($sede == 'TODAS'){

            $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.tipo_pqr, SUM( CASE WHEN DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) < 0 THEN 1 ELSE 0 END ) AS CANT_VENCIDA, SUM( CASE WHEN DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) >= 1 AND DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) <= 3 THEN 1 ELSE 0 END ) AS CANT_A_VENCER, SUM( CASE WHEN DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) > 3 THEN 1 ELSE 0 END ) AS CANT_A_TIEMPO FROM pqr_pqrs WHERE estado_pqr NOT IN ('PRECREADA', 'FINALIZADO') GROUP BY tipo_pqr");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.tipo_pqr, SUM( CASE WHEN DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) < 0 THEN 1 ELSE 0 END ) AS CANT_VENCIDA, SUM( CASE WHEN DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) >= 1 AND DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) <= 3 THEN 1 ELSE 0 END ) AS CANT_A_VENCER, SUM( CASE WHEN DATEDIFF( pqr_pqrs.fecha_max_resp_pqr, NOW()) > 3 THEN 1 ELSE 0 END ) AS CANT_A_TIEMPO FROM pqr_pqrs WHERE estado_pqr NOT IN ('PRECREADA', 'FINALIZADO') AND sede = :sede GROUP BY tipo_pqr");
    
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }


    }

    static public function mdlReportTipoPqrsfOportunidadEps($fechaAnio, $eps, $sede, $columnAnio){

        if($eps == 'TODAS'){

            $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.tipo_pqr, $columnAnio, CONCAT(pqr_par_tipos_pqr.cantidad, ' ', pqr_par_tipos_pqr.tiempo, ' HABILES') AS tiempo_normativo FROM pqr_pqrs JOIN pqr_par_tipos_pqr ON pqr_pqrs.tipo_pqr = pqr_par_tipos_pqr.tipo_pqr 
                WHERE estado_pqr = 'FINALIZADO' 
                AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND pqr_pqrs.sede = :sede
                GROUP BY tipo_pqr ORDER BY tipo_pqr ASC");
    
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.tipo_pqr, $columnAnio, CONCAT(pqr_par_tipos_pqr.cantidad, ' ', pqr_par_tipos_pqr.tiempo, ' HABILES') AS tiempo_normativo FROM pqr_pqrs JOIN pqr_par_tipos_pqr ON pqr_pqrs.tipo_pqr = pqr_par_tipos_pqr.tipo_pqr 
                WHERE estado_pqr = 'FINALIZADO' 
                AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede AND pqr_pqrs.eps = :eps 
                GROUP BY tipo_pqr ORDER BY tipo_pqr ASC");
    
            $stmt->bindParam(":eps", $eps, PDO::PARAM_STR);
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;
            
        }



    }

    static public function mdlReportEstadistica3Usuarios($fechaAnio, $rol, $columnAnio){

        if($rol == 'DIGITADOR'){

            $stmt = Connection::connectOnly()->prepare("SELECT CONCAT(usuarios.nombre,' - ',usuarios.usuario) AS usuario, $columnAnio FROM pqr_pqrs JOIN usuarios ON pqr_pqrs.usuario_crea = usuarios.usuario OR pqr_pqrs.usuario_buzon = usuarios.usuario WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' GROUP BY usuarios.nombre ORDER BY usuarios.nombre ASC");

            if($stmt->execute()){

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else if($rol == 'GESTOR'){

            $stmt = Connection::connectOnly()->prepare("SELECT CONCAT(usuarios.nombre,' - ',usuarios.usuario) AS usuario, $columnAnio FROM pqr_pqrs JOIN usuarios ON pqr_pqrs.gestor = usuarios.usuario WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' GROUP BY usuarios.nombre ORDER BY usuarios.nombre ASC");

            if($stmt->execute()){

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
            }

        }else if($rol == 'SUPERVISOR'){

            $stmt = Connection::connectOnly()->prepare("SELECT CONCAT(usuarios.nombre,' - ',usuarios.usuario) AS usuario, $columnAnio FROM pqr_pqrs JOIN usuarios ON pqr_pqrs.usuario_revision = usuarios.usuario WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' GROUP BY usuarios.nombre ORDER BY usuarios.nombre ASC");

            if($stmt->execute()){

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
            }

        }

        $stmt = null;

    }
    
    static public function mdlReportTipoPqrsfEnteControl($fechaAnio, $enteControl, $sede, $eps, $columnAnio){

        $txtEps = "";

        if($eps != "TODAS"){

            $txtEps = "AND eps = '$eps'";

        }

        if($enteControl == 'TODAS'){
            
            $stmt = Connection::connectOnly()->prepare("SELECT tipo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede $txtEps GROUP BY tipo_pqr ORDER BY tipo_pqr ASC");
    
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT tipo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND ente_reporta_pqr = :ente_reporta_pqr AND sede = :sede $txtEps GROUP BY tipo_pqr ORDER BY tipo_pqr ASC");
    
            $stmt->bindParam(":ente_reporta_pqr", $enteControl, PDO::PARAM_STR);
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }


    }

    static public function mdlReportTipoPqrsfClasiAtribu($fechaAnio, $clasifiAtributo, $sede, $eps, $columnAnio){

        $txtEps = "";

        if($eps != "TODAS"){

            $txtEps = "AND eps = '$eps'";

        }

        if($clasifiAtributo == 'TODAS'){

            $stmt = Connection::connectOnly()->prepare("SELECT tipo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede $txtEps GROUP BY tipo_pqr ORDER BY tipo_pqr ASC");
    
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT tipo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND clasificacion_atributo = :clasificacion_atributo AND sede = :sede $txtEps GROUP BY tipo_pqr ORDER BY tipo_pqr ASC");
    
            $stmt->bindParam(":clasificacion_atributo", $clasifiAtributo, PDO::PARAM_STR);
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }


    }

    static public function mdlReportTipoPqrsfEpsMotivo($fechaAnio, $eps, $sede, $columnAnio){

        if($eps == 'TODAS'){

            $stmt = Connection::connectOnly()->prepare("SELECT motivo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede GROUP BY motivo_pqr ORDER BY motivo_pqr ASC");
    
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT motivo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND eps = :eps AND sede = :sede GROUP BY motivo_pqr ORDER BY motivo_pqr ASC");
    
            $stmt->bindParam(":eps", $eps, PDO::PARAM_STR);
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }


    }

    static public function mdlReportTipoPqrsfEps($fechaAnio, $eps, $sede, $columnAnio){

        if($eps == 'TODAS'){

            $stmt = Connection::connectOnly()->prepare("SELECT tipo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede GROUP BY tipo_pqr ORDER BY tipo_pqr ASC");
    
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT tipo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND eps = :eps AND sede = :sede GROUP BY tipo_pqr ORDER BY tipo_pqr ASC");
    
            $stmt->bindParam(":eps", $eps, PDO::PARAM_STR);
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }


    }

    static public function mdlReportEnteControlPqrsf($fechaAnio, $sede, $columnAnio){

        if($sede == 'TODAS'){
            
            $stmt = Connection::connectOnly()->prepare("SELECT ente_reporta_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' GROUP BY ente_reporta_pqr ORDER BY ente_reporta_pqr ASC");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;


        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT ente_reporta_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede GROUP BY ente_reporta_pqr ORDER BY ente_reporta_pqr ASC");
    
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }


    }

    static public function mdlReportServicioPqrsf($fechaAnio, $sede, $columnAnio){

        if($sede == 'TODAS'){

            $stmt = Connection::connectOnly()->prepare("SELECT servicio_area, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' GROUP BY servicio_area ORDER BY servicio_area ASC");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT servicio_area, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede GROUP BY servicio_area ORDER BY servicio_area ASC");
    
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }


    }

    static public function mdlReportMedRecepPqrsf($fechaAnio, $sede, $columnAnio){

        if($sede == 'TODAS'){

            $stmt = Connection::connectOnly()->prepare("SELECT medio_recep_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' GROUP BY medio_recep_pqr ORDER BY medio_recep_pqr ASC");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT medio_recep_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede GROUP BY medio_recep_pqr ORDER BY medio_recep_pqr ASC");
    
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }


    }

    static public function ctrReportEpsPqrsf($fechaAnio, $sede, $columnAnio){

        if($sede == 'TODAS'){

            $stmt = Connection::connectOnly()->prepare("SELECT eps, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' GROUP BY eps ORDER BY eps ASC");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT eps, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede GROUP BY eps ORDER BY eps ASC");
    
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }


    }

    static public function mdlReportClaAtriPqrsf($fechaAnio, $sede, $columnAnio){

        if($sede == 'TODAS'){

            $stmt = Connection::connectOnly()->prepare("SELECT clasificacion_atributo, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' GROUP BY clasificacion_atributo ORDER BY clasificacion_atributo ASC");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT clasificacion_atributo, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede GROUP BY clasificacion_atributo ORDER BY clasificacion_atributo ASC");
    
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }


    }

    static public function mdlReportMotivoPqrsf($fechaAnio, $sede, $columnAnio){

        if($sede == 'TODAS'){

            $stmt = Connection::connectOnly()->prepare("SELECT motivo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' GROUP BY motivo_pqr ORDER BY motivo_pqr ASC");
            
            if($stmt->execute()){
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
                
                return $stmt->errorInfo();
                
            }
            
            $stmt = null;
            
        }else{
            
            $stmt = Connection::connectOnly()->prepare("SELECT motivo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede GROUP BY motivo_pqr ORDER BY motivo_pqr ASC");
            
            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
            
            if($stmt->execute()){
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
                
                return $stmt->errorInfo();
                
            }
            
            $stmt = null;
        
        }

    }

    static public function mdlReportTipoPqrsf($fechaAnio, $sede, $columnAnio){

        if($sede == 'TODAS'){

            $stmt = Connection::connectOnly()->prepare("SELECT tipo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' GROUP BY tipo_pqr ORDER BY tipo_pqr ASC");
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT tipo_pqr, $columnAnio FROM pqr_pqrs WHERE estado_pqr IN ('COMPLETADO','FINALIZADO') AND fecha_pqr BETWEEN '$fechaAnio-01-01 00:00:00' AND '$fechaAnio-12-31 23:59:59' AND sede = :sede GROUP BY tipo_pqr ORDER BY tipo_pqr ASC");

            $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);
    
            if($stmt->execute()){
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }



    }

    static public function mdlListaReportesPqrsf($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE estado = 1");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    

}
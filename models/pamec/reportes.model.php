<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelReportesAutoevaluacion
{
    public static function mdlObtenerSedes()
    {
        $sql = "SELECT id_sede, sede FROM pamec_par_sedes ORDER BY sede ASC";
        $stmt = Connection::connectOnly()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
    }

    public static function mdlObtenerAutoevaluacionesSeleccionadas()
    {
        $sql = "SELECT pa.* FROM pamec_autoevaluacion pa JOIN pamec_par_periodos_autoevaluacion ppp ON pa.periodo_autoevaluacion = ppp.periodo AND ppp.seleccionado = '1' where pa.is_active=1 ";
        $stmt = Connection::connectOnly()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
    }

    public static function mdlObtenerAutoevaluacionesPorSede($sede, $periodo)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT pa.*  FROM pamec_autoevaluacion pa  WHERE pa.is_active = 1 AND pa.periodo_autoevaluacion= :periodo AND pa.sede LIKE :sede");
        $parametro = '%' . $sede . '%';
        $stmt->bindParam(':sede', $parametro, PDO::PARAM_STR);
        $stmt->bindParam(':periodo', $periodo, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
    }

    static public function mdlObtenerEstandares()
    {

        $stmt = Connection::connectOnly()->prepare(" SELECT  *  FROM pamec_par_estandares  WHERE is_active = '1'  ORDER BY id_estandar asc ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);


        $stmt = null;
    }

    public static function mdlConteoEstadosAutoevaluacion()
    {
        $stmt = Connection::connectOnly()->prepare("SELECT SUM(CASE WHEN pa.estado = 'NO APLICA' THEN 1 ELSE 0 END)  AS no_aplica, SUM(CASE WHEN pa.estado = 'PENDIENTE'    THEN 1 ELSE 0 END)  AS pendiente, SUM(CASE WHEN pa.estado = 'PROCESO'    THEN 1 ELSE 0 END)  AS proceso, SUM(CASE WHEN pa.estado = 'TERMINADO'   THEN 1 ELSE 0 END)  AS terminado FROM pamec_autoevaluacion pa JOIN pamec_par_periodos_autoevaluacion ppp ON pa.periodo_autoevaluacion = ppp.periodo AND ppp.seleccionado = '1' where pa.is_active=1 ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

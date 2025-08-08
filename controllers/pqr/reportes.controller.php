<?php

date_default_timezone_set('America/Bogota');

class ControladorPqrsfReportes{

    public static $columnAnio = 'SUM(CASE WHEN MONTH(fecha_pqr) = 1 THEN 1 ELSE 0 END) AS ENERO,
    SUM(CASE WHEN MONTH(fecha_pqr) = 2 THEN 1 ELSE 0 END) AS FEBRERO,
    SUM(CASE WHEN MONTH(fecha_pqr) = 3 THEN 1 ELSE 0 END) AS MARZO,
    SUM(CASE WHEN MONTH(fecha_pqr) = 4 THEN 1 ELSE 0 END) AS ABRIL,
    SUM(CASE WHEN MONTH(fecha_pqr) = 5 THEN 1 ELSE 0 END) AS MAYO,
    SUM(CASE WHEN MONTH(fecha_pqr) = 6 THEN 1 ELSE 0 END) AS JUNIO,
    SUM(CASE WHEN MONTH(fecha_pqr) = 7 THEN 1 ELSE 0 END) AS JULIO,
    SUM(CASE WHEN MONTH(fecha_pqr) = 8 THEN 1 ELSE 0 END) AS AGOSTO,
    SUM(CASE WHEN MONTH(fecha_pqr) = 9 THEN 1 ELSE 0 END) AS SEPTIEMBRE,
    SUM(CASE WHEN MONTH(fecha_pqr) = 10 THEN 1 ELSE 0 END) AS OCTUBRE,
    SUM(CASE WHEN MONTH(fecha_pqr) = 11 THEN 1 ELSE 0 END) AS NOVIEMBRE,
    SUM(CASE WHEN MONTH(fecha_pqr) = 12 THEN 1 ELSE 0 END) AS DICIEMBRE';


    static public function ctrReportTipoPqrsfOportunidadSedeDias($fechaAnio, $sede, $eps){

        $respuesta = ModelPqrsfReportes::mdlReportTipoPqrsfOportunidadSedeDias($fechaAnio, $sede, $eps);

        return $respuesta;

    }

    static public function ctrReportTipoPqrsfOportunidadSedeHoras($fechaAnio, $sede, $eps){

        $respuesta = ModelPqrsfReportes::mdlReportTipoPqrsfOportunidadSedeHoras($fechaAnio, $sede, $eps);

        return $respuesta;

    }

    static public function ctrListaPQRSEstadoProceso($tipo, $sede){

        $respuesta = ModelPqrsfReportes::mdlListaPQRSEstadoProceso($tipo, $sede);

        return $respuesta;

    }

    static public function ctrListaReporteEstadoProcesoPQRSF($sede){

        $respuesta = ModelPqrsfReportes::mdlListaReporteEstadoProcesoPQRSF($sede);

        return $respuesta;

    }

    static public function ctrReportTipoPqrsfOportunidadEps($fechaAnio, $eps, $sede){

        $respuesta = ModelPqrsfReportes::mdlReportTipoPqrsfOportunidadEps($fechaAnio, $eps, $sede, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrReportEstadistica3Usuarios($fechaAnio, $rol){

        $respuesta = ModelPqrsfReportes::mdlReportEstadistica3Usuarios($fechaAnio, $rol, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrReportTipoPqrsfEnteControl($fechaAnio, $enteControl, $sede, $eps){

        $respuesta = ModelPqrsfReportes::mdlReportTipoPqrsfEnteControl($fechaAnio, $enteControl, $sede, $eps, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrReportTipoPqrsfClasiAtribu($fechaAnio, $clasifiAtributo, $sede, $eps){

        $respuesta = ModelPqrsfReportes::mdlReportTipoPqrsfClasiAtribu($fechaAnio, $clasifiAtributo, $sede, $eps, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrReportTipoPqrsfEpsMotivo($fechaAnio, $eps, $sede){

        $respuesta = ModelPqrsfReportes::mdlReportTipoPqrsfEpsMotivo($fechaAnio, $eps, $sede, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrReportTipoPqrsfEps($fechaAnio, $eps, $sede){

        $respuesta = ModelPqrsfReportes::mdlReportTipoPqrsfEps($fechaAnio, $eps, $sede, self::$columnAnio);

        return $respuesta;

    }


    static public function ctrReportEnteControlPqrsf($fechaAnio, $sede){

        $respuesta = ModelPqrsfReportes::mdlReportEnteControlPqrsf($fechaAnio, $sede, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrReportServicioPqrsf($fechaAnio, $sede){

        $respuesta = ModelPqrsfReportes::mdlReportServicioPqrsf($fechaAnio, $sede, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrReportMedRecepPqrsf($fechaAnio, $sede){

        $respuesta = ModelPqrsfReportes::mdlReportMedRecepPqrsf($fechaAnio, $sede, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrReportEpsPqrsf($fechaAnio, $sede){

        $respuesta = ModelPqrsfReportes::ctrReportEpsPqrsf($fechaAnio, $sede, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrReportClaAtriPqrsf($fechaAnio, $sede){

        $respuesta = ModelPqrsfReportes::mdlReportClaAtriPqrsf($fechaAnio, $sede, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrReportMotivoPqrsf($fechaAnio, $sede){

        $respuesta = ModelPqrsfReportes::mdlReportMotivoPqrsf($fechaAnio, $sede, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrReportTipoPqrsf($fechaAnio, $sede){

        $respuesta = ModelPqrsfReportes::mdlReportTipoPqrsf($fechaAnio, $sede, self::$columnAnio);

        return $respuesta;

    }

    static public function ctrListaReportesPqrsf(){

        $tabla = "pqr_reportes";

        $respuesta = ModelPqrsfReportes::mdlListaReportesPqrsf($tabla);

        return $respuesta;

    }

}
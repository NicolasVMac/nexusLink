<?php


class ControladorReportesAgendamiento{

    static public function ctrListaDetalleDi($cohorte, $fechaInicio, $fechaFin){

        $respuesta = ModelReportesAgendamiento::mdlListaDetalleDi($cohorte, $fechaInicio, $fechaFin);

        return $respuesta;

    }

    static public function ctrListaAtencionCohorteGraficaTable($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ModelReportesAgendamiento::mdlListaAtencionCohorteGraficaTable($idProfesional, $fechaInicio, $fechaFin);

        return $respuesta;

    }
    
    static public function ctrListaAtencionCohorteGrafica($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ModelReportesAgendamiento::mdlListaAtencionCohorteGrafica($idProfesional, $fechaInicio, $fechaFin);

        return $respuesta;

    }


    static public function ctrListaEfectiFalliReproGraficaTable($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ModelReportesAgendamiento::mdlListaEfectiFalliReproGraficaTable($idProfesional, $fechaInicio, $fechaFin);

        return $respuesta;

    }

    static public function ctrListaEfectiFalliReproGrafica($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ModelReportesAgendamiento::mdlListaEfectiFalliReproGrafica($idProfesional, $fechaInicio, $fechaFin);

        return $respuesta;

    }

    static public function ctrListaProductividadProfesionalGrafica($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ModelReportesAgendamiento::mdlListaProductividadProfesionalGrafica($idProfesional, $fechaInicio, $fechaFin);

        return $respuesta;

    }

    static public function ctrListaProductividadProfesional($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ModelReportesAgendamiento::mdlListaProductividadProfesional($idProfesional, $fechaInicio, $fechaFin);

        return $respuesta;

    }

    static public function ctrListaTablaRegimenBaseDetalle($idBase, $regimen){

        $respuesta = ModelReportesAgendamiento::mdlListaTablaRegimenBaseDetalle($idBase, $regimen);

        return $respuesta;

    }

    static public function ctrListaTablaRegimenBase($idBase){

        $respuesta = ModelReportesAgendamiento::mdlListaTablaRegimenBase($idBase);

        return $respuesta;

    }

    static public function ctrListaTablaReporteBaseDetallado($idBase){

        $respuesta = ModelReportesAgendamiento::mdlListaTablaReporteBaseDetallado($idBase);

        return $respuesta;

    }

    static public function ctrListaTablaReporteBaseGeneral($idBase){

        $respuesta = ModelReportesAgendamiento::mdlListaTablaReporteBaseGeneral($idBase);

        return $respuesta;

    }

    static public function ctrListaTablaLlamadas($procesoLlamada, $cohortePrograma,  $fechaInicio, $fechaFin){

        $respuesta = ModelReportesAgendamiento::mdlListaTablaLlamadas($procesoLlamada, $cohortePrograma,  $fechaInicio, $fechaFin);

        return $respuesta;

    }

    static public function ctrReporteLlamadasRealizadas($fechaInicio, $fechaFin){

        $respuesta = ModelReportesAgendamiento::mdlReporteLlamadasRealizadas($fechaInicio, $fechaFin);

        $seriesFinalizadas = array();
        $seriesNoFinalizadas = array();

        foreach ($respuesta as $key => $value) {

            $seriesFinalizadas[] = intval($value["FINALIZADAS"]);
            $seriesNoFinalizadas[] = intval($value["NO_FINALIZADAS"]);
        }

        return $datos = array(
            "seriesFinalizadas" => $seriesFinalizadas,
            "seriesNoFinalizadas" => $seriesNoFinalizadas
        );

    }

    static public function ctrReporteLlamadasProgramadas($cohortePrograma, $fechaInicio, $fechaFin){

        $respuesta = ModelReportesAgendamiento::mdlReporteLlamadasProgramadas($cohortePrograma, $fechaInicio, $fechaFin);

        $categories = array();
        $seriesCreadas = array();
        $seriesProcesos = array();

        foreach ($respuesta as $key => $value) {
            $categories[] = $value["cohorte_programa"];
            $seriesCreadas[] = intval($value["CREADAS"]);
            $seriesProcesos[] = intval($value["PROCESOS"]);
        }

        return $datos = array(
            "categories" => $categories,
            "seriesCreadas" => $seriesCreadas,
            "seriesProcesos" => $seriesProcesos
        );

    }

    static public function ctrReporteLlamadasEfectivasFallidas($cohortePrograma, $fechaInicio, $fechaFin){

        $respuesta = ModelReportesAgendamiento::mdlReporteLlamadasEfectivasFallidas($cohortePrograma, $fechaInicio, $fechaFin);

        $categories = array();
        $seriesFinalizada = array();
        $seriesFallida = array();

        foreach ($respuesta as $key => $value) {
            $categories[] = $value["cohorte_programa"];
            $seriesFinalizada[] = intval($value["FINALIZADAS"]);
            $seriesFallida[] = intval($value["FALLIDAS"]);
        }

        return $datos = array(
            "categories" => $categories,
            "seriesFinalizada" => $seriesFinalizada,
            "seriesFallida" => $seriesFallida
        );


    }

    static public function ctrListaReportesAgendamiento(){

        $tabla = "di_reportes";

        $respuesta = ModelReportesAgendamiento::mdlListaReportesAgendamiento($tabla);

        return $respuesta;

    }

    static public function ctrListaCohorteProgramas(){

        $respuesta = ModelReportesAgendamiento::mdlListaCohorteProgramas();

        return $respuesta;

    }

    static public function ctrListaBasesCargadas(){

        $respuesta = ModelReportesAgendamiento::mdlListaBasesCargadas();

        return $respuesta;

    }

}
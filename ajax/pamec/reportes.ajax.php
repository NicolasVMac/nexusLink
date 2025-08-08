<?php

require_once "../../controllers/pamec/reportes.controller.php";
require_once "../../models/pamec/reportes.model.php";

class reportesAutoevaluacionAjax
{
    public $datos;


    public function listaEstandarEvaluadoSedes()
    {

        $respuesta = ControladorReportesAutoevaluacion::ctrListaEstandarEvaluadoSedes();
        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($respuesta),
            "recordsFiltered" => count($respuesta),
            "data" => $respuesta
        );

        echo json_encode($resultado);
    }

    public function listarSubgruposEstandares($sede, $periodo)
    {
        $respuesta = ControladorReportesAutoevaluacion::ctrListarSubgruposEstandares($sede, $periodo);

        $resultado = array(
            "draw" => 1,
            "recordsTotal"    => count($respuesta),
            "recordsFiltered" => count($respuesta),
            "data"            => $respuesta
        );
        echo json_encode($resultado);
    }
    public function listargruposEstandares($sede, $periodo)
    {
        $respuesta = ControladorReportesAutoevaluacion::ctrListarGruposEstandares($sede, $periodo);

        $resultado = array(
            "draw" => 1,
            "recordsTotal"    => count($respuesta),
            "recordsFiltered" => count($respuesta),
            "data"            => $respuesta
        );
        echo json_encode($resultado);
    }
    public function conteoEstadosAutoevaluacion()
    {
        $respuesta = ControladorReportesAutoevaluacion::ctrConteoEstadosAutoevaluacion();
        echo json_encode($respuesta);
    }
    public function conteoEstandaresPorSede()
    {
        $respuesta = ControladorReportesAutoevaluacion::ctrConteoEstandaresPorSede();
        echo json_encode($respuesta);
    }
    static public function conteoEstadosPorSede()
    {
        $respuesta = ControladorReportesAutoevaluacion::ctrConteoEstadosPorSede();
        echo json_encode($respuesta);
    }
    public function matrizEstandaresPorSede()
    {
        $respuesta = ControladorReportesAutoevaluacion::ctrMatrizEstandaresPorSede();
        echo json_encode($respuesta);
    }
}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch ($proceso) {
        case 'listaEstandarEvaluadoSedes':
            $listaEstandarEvaluadoSedes = new reportesAutoevaluacionAjax();
            $listaEstandarEvaluadoSedes->listaEstandarEvaluadoSedes();
            break;
        case 'listarSubgruposEstandares':
            $listarSubgruposEstandares = new reportesAutoevaluacionAjax();
            $listarSubgruposEstandares->listarSubgruposEstandares($_POST["selectSedes"], $_POST["selectPeriodo"]);
            break;
        case 'listargruposEstandares':
            $listargruposEstandares = new reportesAutoevaluacionAjax();
            $listargruposEstandares->listargruposEstandares($_POST["selectSedes"], $_POST["selectPeriodo"]);
            break;
        case 'conteoEstadosAutoevaluacion':
            $conteoEstados = new reportesAutoevaluacionAjax();
            $conteoEstados->conteoEstadosAutoevaluacion();
            break;
        case 'conteoEstandaresPorSede':
            $conteoEstandaresPorSede = new reportesAutoevaluacionAjax();
            $conteoEstandaresPorSede->conteoEstandaresPorSede();
            break;
        case 'conteoEstadosPorSede':
            $conteoEstadosPorSede = new reportesAutoevaluacionAjax();
            $conteoEstadosPorSede->conteoEstadosPorSede();
            break;
        case 'matrizEstandaresPorSede':
            $matrizEstandaresPorSede = new reportesAutoevaluacionAjax();
            $matrizEstandaresPorSede->matrizEstandaresPorSede();
            break;
    }
}

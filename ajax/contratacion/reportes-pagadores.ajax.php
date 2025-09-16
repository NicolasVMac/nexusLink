<?php

require_once "../../controllers/contratacion/reportes-pagadores.controller.php";
require_once "../../models/contratacion/reportes-pagadores.model.php";

class ReportesPagadoresAjax{

    public $datos;

    public function listaReportesPagadores(){

        $respuesta = ControladorReportesPagadores::ctrListaReportesPagadores();

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }

    public function estadoProcesoContratos(){

        $respuesta = ControladorReportesPagadores::ctrEstadoProcesoContratos();

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }

    public function estadoProcesoPolizas(){

        $respuesta = ControladorReportesPagadores::ctrEstadoProcesoPolizas();

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }

    public function listaEstadoContratos($tipo){

        $respuesta = ControladorReportesPagadores::ctrListaEstadoContratos($tipo);

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }


    public function listaEstadoPolizas($tipo){

        $respuesta = ControladorReportesPagadores::ctrListaEstadoPolizas($tipo);

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'listaEstadoPolizas':
            $listaEstadoPolizas = new ReportesPagadoresAjax();
            $listaEstadoPolizas->listaEstadoPolizas($_POST["tipo"]);
            break;

        case 'listaEstadoContratos':
            $listaEstadoContratos = new ReportesPagadoresAjax();
            $listaEstadoContratos->listaEstadoContratos($_POST["tipo"]);
            break;

        case 'estadoProcesoPolizas':
            $estadoProcesoPolizas = new ReportesPagadoresAjax();
            $estadoProcesoPolizas->estadoProcesoPolizas();
            break;

        case 'estadoProcesoContratos':
            $estadoProcesoContratos = new ReportesPagadoresAjax();
            $estadoProcesoContratos->estadoProcesoContratos();
            break;

        case 'listaReportesPagadores':
            $listaReportesPagadores = new ReportesPagadoresAjax();
            $listaReportesPagadores->listaReportesPagadores();
            break;



    }

}
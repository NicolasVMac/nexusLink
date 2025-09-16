<?php

require_once "../../controllers/contratacion/reportes-contratistas.controller.php";
require_once "../../models/contratacion/reportes-contratistas.model.php";

class ReportesContratistasAjax{

    public $datos;

    public function listaReportesContratistas(){

        $respuesta = ControladorReportesContratistas::ctrListaReportesContratistas();

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

        $respuesta = ControladorReportesContratistas::ctrEstadoProcesoContratos();

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

        $respuesta = ControladorReportesContratistas::ctrEstadoProcesoPolizas();

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

        $respuesta = ControladorReportesContratistas::ctrListaEstadoContratos($tipo);

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

        $respuesta = ControladorReportesContratistas::ctrListaEstadoPolizas($tipo);

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
            $listaEstadoPolizas = new ReportesContratistasAjax();
            $listaEstadoPolizas->listaEstadoPolizas($_POST["tipo"]);
            break;

        case 'listaEstadoContratos':
            $listaEstadoContratos = new ReportesContratistasAjax();
            $listaEstadoContratos->listaEstadoContratos($_POST["tipo"]);
            break;

        case 'estadoProcesoPolizas':
            $estadoProcesoPolizas = new ReportesContratistasAjax();
            $estadoProcesoPolizas->estadoProcesoPolizas();
            break;

        case 'estadoProcesoContratos':
            $estadoProcesoContratos = new ReportesContratistasAjax();
            $estadoProcesoContratos->estadoProcesoContratos();
            break;

        case 'listaReportesContratistas':
            $listaReportesContratistas = new ReportesContratistasAjax();
            $listaReportesContratistas->listaReportesContratistas();
            break;



    }

}
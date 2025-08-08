<?php

require_once "../../controllers/inventario/reportes-biomedico.controller.php";
require_once "../../models/inventario/reportes-biomedico.model.php";

class ReportesInventarioBiomedicoAjax{

    public $datos;

    public function listaReportesBiomedicos(){

        $respuesta = ControladorReportesInventarioBiomedico::ctrListaReportesBiomedicos();

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

    public function listaEquiposBiomedicosTipoMantenimiento($tipoMantenimiento){

        $respuesta = ControladorReportesInventarioBiomedico::ctrListaEquiposBiomedicosTipoMantenimiento($tipoMantenimiento);

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

        case 'listaEquiposBiomedicosTipoMantenimiento':
            $listaEquiposBiomedicosTipoMantenimiento = new ReportesInventarioBiomedicoAjax();
            $listaEquiposBiomedicosTipoMantenimiento->listaEquiposBiomedicosTipoMantenimiento($_POST["tipoMantenimiento"]);
            break;

        case 'listaReportesBiomedicos':
            $listaReportesBiomedicos = new ReportesInventarioBiomedicoAjax();
            $listaReportesBiomedicos->listaReportesBiomedicos();
            break;


    }

}
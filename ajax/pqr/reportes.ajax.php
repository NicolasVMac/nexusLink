<?php

require_once "../../controllers/pqr/reportes.controller.php";
require_once "../../models/pqr/reportes.model.php";

class PqrsfReportesAjax{


    public function listaReportesPqrsf(){

        $respuesta = ControladorPqrsfReportes::ctrListaReportesPqrsf();

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

    public function reportTipoPqrsf($fechaAnio, $sede){

        $respuesta = ControladorPqrsfReportes::ctrReportTipoPqrsf($fechaAnio, $sede);

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

    public function reportMotivoPqrsf($fechaAnio, $sede){

        $respuesta = ControladorPqrsfReportes::ctrReportMotivoPqrsf($fechaAnio, $sede);

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

    public function reportClaAtriPqrsf($fechaAnio, $sede){

        $respuesta = ControladorPqrsfReportes::ctrReportClaAtriPqrsf($fechaAnio, $sede);

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

    public function reportEpsPqrsf($fechaAnio, $sede){

        $respuesta = ControladorPqrsfReportes::ctrReportEpsPqrsf($fechaAnio, $sede);

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

    public function reportMedRecepPqrsf($fechaAnio, $sede){

        $respuesta = ControladorPqrsfReportes::ctrReportMedRecepPqrsf($fechaAnio, $sede);

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

    public function reportServicioPqrsf($fechaAnio, $sede){

        $respuesta = ControladorPqrsfReportes::ctrReportServicioPqrsf($fechaAnio, $sede);

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


    public function reportEnteControlPqrsf($fechaAnio, $sede){

        $respuesta = ControladorPqrsfReportes::ctrReportEnteControlPqrsf($fechaAnio, $sede);

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


    public function reportTipoPqrsfEps($fechaAnio, $eps, $sede){

        $respuesta = ControladorPqrsfReportes::ctrReportTipoPqrsfEps($fechaAnio, $eps, $sede);

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

    public function reportTipoPqrsfEpsMotivo($fechaAnio, $eps, $sede){

        $respuesta = ControladorPqrsfReportes::ctrReportTipoPqrsfEpsMotivo($fechaAnio, $eps, $sede);

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

    public function reportTipoPqrsfClasiAtribu($fechaAnio, $clasifiAtributo, $sede, $eps){

        $respuesta = ControladorPqrsfReportes::ctrReportTipoPqrsfClasiAtribu($fechaAnio, $clasifiAtributo, $sede, $eps);

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

    public function reportTipoPqrsfEnteControl($fechaAnio, $enteControl, $sede, $eps){

        $respuesta = ControladorPqrsfReportes::ctrReportTipoPqrsfEnteControl($fechaAnio, $enteControl, $sede, $eps);

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

    public function reportEstadistica3Usuarios($fechaAnio, $rol){

        $respuesta = ControladorPqrsfReportes::ctrReportEstadistica3Usuarios($fechaAnio, $rol);

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


    public function reportTipoPqrsfOportunidadEps($fechaAnio, $eps, $sede){

        $respuesta = ControladorPqrsfReportes::ctrReportTipoPqrsfOportunidadEps($fechaAnio, $eps, $sede);

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

    public function listaReporteEstadoProcesoPQRSF($sede){

        $respuesta = ControladorPqrsfReportes::ctrListaReporteEstadoProcesoPQRSF($sede);

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

    public function listaPQRSEstadoProceso($tipo, $sede){

        $respuesta = ControladorPqrsfReportes::ctrListaPQRSEstadoProceso($tipo, $sede);

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

    public function reportTipoPqrsfOportunidadSedeHoras($fechaAnio, $sede, $eps){

        $respuesta = ControladorPqrsfReportes::ctrReportTipoPqrsfOportunidadSedeHoras($fechaAnio, $sede, $eps);

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


    public function reportTipoPqrsfOportunidadSedeDias($fechaAnio, $sede, $eps){

        $respuesta = ControladorPqrsfReportes::ctrReportTipoPqrsfOportunidadSedeDias($fechaAnio, $sede, $eps);

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

        case 'reportTipoPqrsfOportunidadSedeDias':
            $reportTipoPqrsfOportunidadSedeDias = new PqrsfReportesAjax();
            $reportTipoPqrsfOportunidadSedeDias->reportTipoPqrsfOportunidadSedeDias($_POST["fechaAnio"], $_POST["sede"], $_POST["eps"]);
            break;

        case 'reportTipoPqrsfOportunidadSedeHoras':
            $reportTipoPqrsfOportunidadSedeHoras = new PqrsfReportesAjax();
            $reportTipoPqrsfOportunidadSedeHoras->reportTipoPqrsfOportunidadSedeHoras($_POST["fechaAnio"], $_POST["sede"], $_POST["eps"]);
            break;

        case 'listaPQRSEstadoProceso':
            $listaPQRSEstadoProceso = new PqrsfReportesAjax();
            $listaPQRSEstadoProceso->listaPQRSEstadoProceso($_POST["tipo"], $_POST["sede"]);
            break;

        case 'listaReporteEstadoProcesoPQRSF':
            $listaReporteEstadoProcesoPQRSF = new PqrsfReportesAjax();
            $listaReporteEstadoProcesoPQRSF->listaReporteEstadoProcesoPQRSF($_POST["sede"]);
            break;

        case 'reportTipoPqrsfOportunidadEps':
            $reportTipoPqrsfOportunidadEps = new PqrsfReportesAjax();
            $reportTipoPqrsfOportunidadEps->reportTipoPqrsfOportunidadEps($_POST["fechaAnio"], $_POST["eps"], $_POST["sede"]);
            break;

        case 'reportEstadistica3Usuarios':
            $reportEstadistica3Usuarios = new PqrsfReportesAjax();
            $reportEstadistica3Usuarios->reportEstadistica3Usuarios($_POST["fechaAnio"], $_POST["rol"]);
            break;

        case 'reportTipoPqrsfEnteControl':
            $reportTipoPqrsfEnteControl = new PqrsfReportesAjax();
            $reportTipoPqrsfEnteControl->reportTipoPqrsfEnteControl($_POST["fechaAnio"], $_POST["enteControl"], $_POST["sede"], $_POST["eps"]);
            break;

        case 'reportTipoPqrsfClasiAtribu':
            $reportTipoPqrsfClasiAtribu = new PqrsfReportesAjax();
            $reportTipoPqrsfClasiAtribu->reportTipoPqrsfClasiAtribu($_POST["fechaAnio"], $_POST["clasifiAtributo"], $_POST["sede"], $_POST["eps"]);
            break;

        case 'reportTipoPqrsfEpsMotivo':
            $reportTipoPqrsfEpsMotivo = new PqrsfReportesAjax();
            $reportTipoPqrsfEpsMotivo->reportTipoPqrsfEpsMotivo($_POST["fechaAnio"], $_POST["eps"], $_POST["sede"]);
            break;

        case 'reportTipoPqrsfEps':
            $reportTipoPqrsfEps = new PqrsfReportesAjax();
            $reportTipoPqrsfEps->reportTipoPqrsfEps($_POST["fechaAnio"], $_POST["eps"], $_POST["sede"]);
            break;

        case 'reportEnteControlPqrsf':
            $reportEnteControlPqrsf = new PqrsfReportesAjax();
            $reportEnteControlPqrsf->reportEnteControlPqrsf($_POST["fechaAnio"], $_POST["sede"]);
            break;

        case 'reportServicioPqrsf':
            $reportServicioPqrsf = new PqrsfReportesAjax();
            $reportServicioPqrsf->reportServicioPqrsf($_POST["fechaAnio"], $_POST["sede"]);
            break;

        case 'reportMedRecepPqrsf':
            $reportMedRecepPqrsf = new PqrsfReportesAjax();
            $reportMedRecepPqrsf->reportMedRecepPqrsf($_POST["fechaAnio"], $_POST["sede"]);
            break;

        case 'reportEpsPqrsf':
            $reportEpsPqrsf = new PqrsfReportesAjax();
            $reportEpsPqrsf->reportEpsPqrsf($_POST["fechaAnio"], $_POST["sede"]);
            break;

        case 'reportClaAtriPqrsf':
            $reportClaAtriPqrsf = new PqrsfReportesAjax();
            $reportClaAtriPqrsf->reportClaAtriPqrsf($_POST["fechaAnio"], $_POST["sede"]);
            break;

        case 'reportMotivoPqrsf':
            $reportMotivoPqrsf = new PqrsfReportesAjax();
            $reportMotivoPqrsf->reportMotivoPqrsf($_POST["fechaAnio"], $_POST["sede"]);
            break;

        case 'reportTipoPqrsf':
            $reportTipoPqrsf = new PqrsfReportesAjax();
            $reportTipoPqrsf->reportTipoPqrsf($_POST["fechaAnio"], $_POST["sede"]);
            break;

        case 'listaReportesPqrsf':
            $listaReportesPqrsf = new PqrsfReportesAjax();
            $listaReportesPqrsf->listaReportesPqrsf();
            break;

    }

}
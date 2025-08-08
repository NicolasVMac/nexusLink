<?php

require_once "../../controllers/di/reportes.controller.php";
require_once "../../models/di/reportes.model.php";

class ReportesAgendamientoAjax{

    public $datos;

    public function listaBasesCargadas(){

        $respuesta = ControladorReportesAgendamiento::ctrListaBasesCargadas();

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione una Base</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["id_base"].'">'.$value["nombre"].'</option>';

        }

        echo $cadena;

    }

    public function listaCohorteProgramas(){

        $respuesta = ControladorReportesAgendamiento::ctrListaCohorteProgramas();

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Cohorte o Programa</option><option value="TODOS">TODOS</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["cohorte_programa"].'">'.$value["cohorte_programa"].'</option>';

        }

        echo $cadena;

    }

    public function listaReportesAgendamiento(){

        $respuesta = ControladorReportesAgendamiento::ctrListaReportesAgendamiento();

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

    public function reporteLlamadasEfectivasFallidas($cohortePrograma, $fechaInicio, $fechaFin){

        $respuesta = ControladorReportesAgendamiento::ctrReporteLlamadasEfectivasFallidas($cohortePrograma, $fechaInicio, $fechaFin);

        echo json_encode($respuesta);

    }

    public function reporteLlamadasProgramadas($cohortePrograma, $fechaInicio, $fechaFin){

        $respuesta = ControladorReportesAgendamiento::ctrReporteLlamadasProgramadas($cohortePrograma, $fechaInicio, $fechaFin);

        echo json_encode($respuesta);

    }

    public function reporteLlamadasRealizadas($fechaInicio, $fechaFin){

        $respuesta = ControladorReportesAgendamiento::ctrReporteLlamadasRealizadas($fechaInicio, $fechaFin);

        echo json_encode($respuesta);

    }

    public function listaTablaLlamadas($procesoLlamada, $cohortePrograma,  $fechaInicio, $fechaFin){

        $respuesta = ControladorReportesAgendamiento::ctrListaTablaLlamadas($procesoLlamada, $cohortePrograma,  $fechaInicio, $fechaFin);

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

    public function listaTablaReporteBaseGeneral($idBase){

        $respuesta = ControladorReportesAgendamiento::ctrListaTablaReporteBaseGeneral($idBase);

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

    public function listaTablaReporteBaseDetallado($idBase){

        $respuesta = ControladorReportesAgendamiento::ctrListaTablaReporteBaseDetallado($idBase);

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

    public function listaTablaRegimenBase($idBase){

        $respuesta = ControladorReportesAgendamiento::ctrListaTablaRegimenBase($idBase);
        
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

    public function listaTablaRegimenBaseDetalle($idBase, $regimen){

        $respuesta = ControladorReportesAgendamiento::ctrListaTablaRegimenBaseDetalle($idBase, $regimen);

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

    public function listaProductividadProfesional($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ControladorReportesAgendamiento::ctrListaProductividadProfesional($idProfesional, $fechaInicio, $fechaFin);

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

    public function listaProductividadProfesionalGrafica($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ControladorReportesAgendamiento::ctrListaProductividadProfesionalGrafica($idProfesional, $fechaInicio, $fechaFin);

        echo json_encode($respuesta);

    }


    public function listaEfectiFalliReproGrafica($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ControladorReportesAgendamiento::ctrListaEfectiFalliReproGrafica($idProfesional, $fechaInicio, $fechaFin);

        echo json_encode($respuesta);

    }


    public function listaEfectiFalliReproGraficaTable($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ControladorReportesAgendamiento::ctrListaEfectiFalliReproGraficaTable($idProfesional, $fechaInicio, $fechaFin);

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

    public function listaAtencionCohorteGrafica($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ControladorReportesAgendamiento::ctrListaAtencionCohorteGrafica($idProfesional, $fechaInicio, $fechaFin);

        echo json_encode($respuesta);

    }

    public function listaAtencionCohorteGraficaTable($idProfesional, $fechaInicio, $fechaFin){

        $respuesta = ControladorReportesAgendamiento::ctrListaAtencionCohorteGraficaTable($idProfesional, $fechaInicio, $fechaFin);

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

    public function listaDetalleDi($cohorte, $fechaInicio, $fechaFin){

        $respuesta = ControladorReportesAgendamiento::ctrListaDetalleDi($cohorte, $fechaInicio, $fechaFin);

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

    public function listaCohorteProgramasNotTodos(){

        $respuesta = ControladorReportesAgendamiento::ctrListaCohorteProgramas();

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Cohorte o Programa</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["cohorte_programa"].'">'.$value["cohorte_programa"].'</option>';

        }

        echo $cadena;

    }

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'listaCohorteProgramasNotTodos':
            $listaCohorteProgramasNotTodos = new ReportesAgendamientoAjax();
            $listaCohorteProgramasNotTodos->listaCohorteProgramasNotTodos();
            break;

        case 'listaDetalleDi':
            $listaDetalleDi = new ReportesAgendamientoAjax();
            $listaDetalleDi->listaDetalleDi($_POST["cohorte"], $_POST["fechaInicio"], $_POST["fechaFin"]);
            break;

        case 'listaAtencionCohorteGraficaTable':
            $listaAtencionCohorteGraficaTable = new ReportesAgendamientoAjax();
            $listaAtencionCohorteGraficaTable->listaAtencionCohorteGraficaTable($_POST["idProfesional"], $_POST["fechaInicio"], $_POST["fechaFin"]);
            break;

        case 'listaAtencionCohorteGrafica':
            $listaAtencionCohorteGrafica = new ReportesAgendamientoAjax();
            $listaAtencionCohorteGrafica->listaAtencionCohorteGrafica($_POST["idProfesional"], $_POST["fechaInicio"], $_POST["fechaFin"]);
            break;

        case 'listaEfectiFalliReproGraficaTable':
            $listaEfectiFalliReproGraficaTable = new ReportesAgendamientoAjax();
            $listaEfectiFalliReproGraficaTable->listaEfectiFalliReproGraficaTable($_POST["idProfesional"], $_POST["fechaInicio"], $_POST["fechaFin"]);
            break;

        case 'listaEfectiFalliReproGrafica':
            $listaEfectiFalliReproGrafica = new ReportesAgendamientoAjax();
            $listaEfectiFalliReproGrafica->listaEfectiFalliReproGrafica($_POST["idProfesional"], $_POST["fechaInicio"], $_POST["fechaFin"]);
            break;

        case 'listaProductividadProfesionalGrafica':
            $listaProductividadProfesionalGrafica = new ReportesAgendamientoAjax();
            $listaProductividadProfesionalGrafica->listaProductividadProfesionalGrafica($_POST["idProfesional"], $_POST["fechaInicio"], $_POST["fechaFin"]);
            break;

        case 'listaProductividadProfesional':
            $listaProductividadProfesional = new ReportesAgendamientoAjax();
            $listaProductividadProfesional->listaProductividadProfesional($_POST["idProfesional"], $_POST["fechaInicio"], $_POST["fechaFin"]);
            break;

        case 'listaTablaRegimenBaseDetalle':
            $listaTablaRegimenBaseDetalle = new ReportesAgendamientoAjax();
            $listaTablaRegimenBaseDetalle->listaTablaRegimenBaseDetalle($_POST["idBase"], $_POST["regimen"]);
            break;

        case 'listaTablaRegimenBase':
            $listaTablaRegimenBase = new ReportesAgendamientoAjax();
            $listaTablaRegimenBase->listaTablaRegimenBase($_POST["idBase"]);
            break;

        case 'listaTablaReporteBaseDetallado':
            $listaTablaReporteBaseDetallado = new ReportesAgendamientoAjax();
            $listaTablaReporteBaseDetallado->listaTablaReporteBaseDetallado($_POST["idBase"]);
            break;

        case 'listaTablaReporteBaseGeneral':
            $listaTablaReporteBaseGeneral = new ReportesAgendamientoAjax();
            $listaTablaReporteBaseGeneral->listaTablaReporteBaseGeneral($_POST["idBase"]);
            break;

        case 'listaTablaLlamadas':
            $listaTablaLlamadas = new ReportesAgendamientoAjax();
            $listaTablaLlamadas->listaTablaLlamadas($_POST["procesoLlamada"], $_POST["cohortePrograma"],  $_POST["fechaInicio"], $_POST["fechaFin"]);
            break;

        case 'reporteLlamadasRealizadas':
            $reporteLlamadasRealizadas = new ReportesAgendamientoAjax();
            $reporteLlamadasRealizadas->reporteLlamadasRealizadas($_POST["fechaInicio"], $_POST["fechaFin"]);
            break;

        case 'reporteLlamadasProgramadas':
            $reporteLlamadasProgramadas = new ReportesAgendamientoAjax();
            $reporteLlamadasProgramadas->reporteLlamadasProgramadas($_POST["cohortePrograma"], $_POST["fechaInicio"], $_POST["fechaFin"]);
            break;

        case 'reporteLlamadasEfectivasFallidas':
            $reporteLlamadasEfectivasFallidas = new ReportesAgendamientoAjax();
            $reporteLlamadasEfectivasFallidas->reporteLlamadasEfectivasFallidas($_POST["cohortePrograma"], $_POST["fechaInicio"], $_POST["fechaFin"]);
            break;

        case 'listaReportesAgendamiento':
            $listaReportesAgendamiento = new ReportesAgendamientoAjax();
            $listaReportesAgendamiento->listaReportesAgendamiento();
            break;

        case 'listaCohorteProgramas':
            $listaCohorteProgramas = new ReportesAgendamientoAjax();
            $listaCohorteProgramas->listaCohorteProgramas();
            break;

        case 'listaBasesCargadas':
            $listaBasesCargadas = new ReportesAgendamientoAjax();
            $listaBasesCargadas->listaBasesCargadas();
            break;

    }

}

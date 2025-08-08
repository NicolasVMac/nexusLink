<?php

require_once "../../controllers/encuestas/reportes-profesional.controller.php";
require_once "../../models/encuestas/reportes-profesional.model.php";

class EncuestasReportesProfesionalAjax{


    public function listaReportesEncuestasProfesional(){

        $respuesta = ControladorEncuestasReportesProfesional::ctrListaReportesEncuestasProfesional();

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


    public function listaEspecialistasProfesional($programa){

        $respuesta = ControladorEncuestasReportesProfesional::ctrListaEspecialidadProfesional($programa);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Especialista</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["especialidad"].'">'.$value["especialidad"].'</option>';

        }

        echo $cadena;
        

    }

    public function listaBasesEncuestasEspecialidad($especialidad){

        $respuesta = ControladorEncuestasReportesProfesional::ctrListaBasesEncuestasEspecialidad($especialidad);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione una Base</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["id_base_encuesta"].'">'.$value["nombre"].'</option>';

        }

        echo $cadena;

    }

    public function infoReporteEspecidalidadProfesional($idBaseEncuesta, $programa, $especialidad, $tipo){

        $respuesta = ControladorEncuestasReportesProfesional::ctrInfoReporteEspecidalidadProfesional($idBaseEncuesta, $programa, $especialidad, $tipo);

        echo json_encode($respuesta);

    }

    public function listaOtrasEspecialistas(){

        $respuesta = ControladorEncuestasReportesProfesional::ctrlistaOtrasEspecialistas();

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione una Especiliadad</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["id_encu_proceso"].'">'.$value["especialidad"].'</option>';

        }

        echo $cadena;

    }

    public function segmentosOtraEspecialidad($idBaseEncuesta, $idProceso){

        $respuesta = ControladorEncuestasReportesProfesional::ctrSegmentosOtraEspecialidad($idBaseEncuesta, $idProceso);

        echo json_encode($respuesta);

    }

    public function listaBasesEncuestasEspecialidadIdProceso($idProceso){

        $respuesta = ControladorEncuestasReportesProfesional::ctrListaBasesEncuestasEspecialidadIdProceso($idProceso);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione una Base</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["id_base_encuesta"].'">'.$value["nombre"].'</option>';

        }

        echo $cadena;

    }

    public function preguntasSegmentoIntrumento($idBaseEncuesta, $idEncuSegmento){

        $respuesta = ControladorEncuestasReportesProfesional::ctrPreguntasSegmentoIntrumento($idBaseEncuesta, $idEncuSegmento);

        echo json_encode($respuesta);

    }

    public function listaBasesProfesionales(){

        $respuesta = ControladorEncuestasReportesProfesional::ctrlistaBasesProfesionales();

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione una Base</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["id_base_encuesta"].'">'.$value["nombre"].'</option>';

        }

        echo $cadena;

    }

    public function infoResultadoAuditoriaProfesional($idBaseEncuesta){

        $respuesta = ControladorEncuestasReportesProfesional::ctrInfoResultadoAuditoriaProfesional($idBaseEncuesta);

        echo json_encode($respuesta);

    }

    public function listaProfesionalesIdBaseEncuesta($idBaseEncuesta){

        $respuesta = ControladorEncuestasReportesProfesional::ctrListaProfesionalesIdBaseEncuesta($idBaseEncuesta);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Profesional</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["profesional_auditado"].'">'.$value["profesional_auditado"].'</option>';

        }

        echo $cadena;

    }

    public function infoReporteEspecidalidadProfesionalPro($idBaseEncuesta, $programa, $especialidad, $tipo, $profesional){

        $respuesta = ControladorEncuestasReportesProfesional::ctrInfoReporteEspecidalidadProfesionalPro($idBaseEncuesta, $programa, $especialidad, $tipo, $profesional);

        echo json_encode($respuesta);

    }

    public function segmentosOtraEspecialidadProfesional($idBaseEncuesta, $idProceso, $profesional){

        $respuesta = ControladorEncuestasReportesProfesional::ctrSegmentosOtraEspecialidadProfesional($idBaseEncuesta, $idProceso, $profesional);

        echo json_encode($respuesta);

    }

    public function preguntasSegmentoIntrumentoProfesional($idBaseEncuesta, $idEncuSegmento, $profesional){

        $respuesta = ControladorEncuestasReportesProfesional::ctrPreguntasSegmentoIntrumentoProfesional($idBaseEncuesta, $idEncuSegmento, $profesional);

        echo json_encode($respuesta);

    }

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'preguntasSegmentoIntrumentoProfesional':
            $preguntasSegmentoIntrumentoProfesional = new EncuestasReportesProfesionalAjax();
            $preguntasSegmentoIntrumentoProfesional->preguntasSegmentoIntrumentoProfesional($_POST["idBaseEncuesta"], $_POST["idEncuSegmento"], $_POST["profesional"]);
            break;

        case 'segmentosOtraEspecialidadProfesional':
            $segmentosOtraEspecialidadProfesional = new EncuestasReportesProfesionalAjax();
            $segmentosOtraEspecialidadProfesional->segmentosOtraEspecialidadProfesional($_POST["idBaseEncuesta"], $_POST["idProceso"], $_POST["profesional"]);
            break;

        case 'infoReporteEspecidalidadProfesionalPro':
            $infoReporteEspecidalidadProfesionalPro = new EncuestasReportesProfesionalAjax();
            $infoReporteEspecidalidadProfesionalPro->infoReporteEspecidalidadProfesionalPro($_POST["idBaseEncuesta"],$_POST["programa"],$_POST["especialidad"],$_POST["tipo"], $_POST["profesional"]);
            break;

        case 'listaProfesionalesIdBaseEncuesta':
            $listaProfesionalesIdBaseEncuesta = new EncuestasReportesProfesionalAjax();
            $listaProfesionalesIdBaseEncuesta->listaProfesionalesIdBaseEncuesta($_POST["idBaseEncuesta"]);
            break;

        case 'infoResultadoAuditoriaProfesional':
            $infoResultadoAuditoriaProfesional = new EncuestasReportesProfesionalAjax();
            $infoResultadoAuditoriaProfesional->infoResultadoAuditoriaProfesional($_POST["idBaseEncuesta"]);
            break;

        case 'listaBasesProfesionales':
            $listaBasesProfesionales = new EncuestasReportesProfesionalAjax();
            $listaBasesProfesionales->listaBasesProfesionales();
            break;

        case 'preguntasSegmentoIntrumento':
            $preguntasSegmentoIntrumento = new EncuestasReportesProfesionalAjax();
            $preguntasSegmentoIntrumento->preguntasSegmentoIntrumento($_POST["idBaseEncuesta"], $_POST["idEncuSegmento"]);
            break;

        case 'listaBasesEncuestasEspecialidadIdProceso':
            $listaBasesEncuestasEspecialidadIdProceso = new EncuestasReportesProfesionalAjax();
            $listaBasesEncuestasEspecialidadIdProceso->listaBasesEncuestasEspecialidadIdProceso($_POST["idProceso"]);
            break;

        case 'segmentosOtraEspecialidad':
            $segmentosOtraEspecialidad = new EncuestasReportesProfesionalAjax();
            $segmentosOtraEspecialidad->segmentosOtraEspecialidad($_POST["idBaseEncuesta"], $_POST["idProceso"]);
            break;

        case 'listaOtrasEspecialistas':
            $listaOtrasEspecialistas = new EncuestasReportesProfesionalAjax();
            $listaOtrasEspecialistas->listaOtrasEspecialistas();
            break;

        case 'infoReporteEspecidalidadProfesional':
            $infoReporteEspecidalidadProfesional = new EncuestasReportesProfesionalAjax();
            $infoReporteEspecidalidadProfesional->infoReporteEspecidalidadProfesional($_POST["idBaseEncuesta"],$_POST["programa"],$_POST["especialidad"],$_POST["tipo"]);
            break;

        case 'listaBasesEncuestasEspecialidad':
            $listaBasesEncuestasEspecialidad = new EncuestasReportesProfesionalAjax();
            $listaBasesEncuestasEspecialidad->listaBasesEncuestasEspecialidad($_POST["especialidad"]);
            break;

        case 'listaEspecialistasProfesional':
            $listaEspecialistasProfesional = new EncuestasReportesProfesionalAjax();
            $listaEspecialistasProfesional->listaEspecialistasProfesional($_POST["programa"]);
            break;


        case 'listaReportesEncuestasProfesional':
            $listaReportesEncuestasProfesional = new EncuestasReportesProfesionalAjax();
            $listaReportesEncuestasProfesional->listaReportesEncuestasProfesional();
            break;

    }

}
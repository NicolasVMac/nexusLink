<?php

require_once "../../controllers/encuestas/reportes.controller.php";
require_once "../../models/encuestas/reportes.model.php";

class EncuestasReportesAjax{


    public function listaReportesEncuestas($tipoEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrListaReportesEncuestas($tipoEncuesta);

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

    public function listaBasesEncuestas($tipoEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrListaBasesEncuestas($tipoEncuesta);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Base</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["id_base_encuesta"].'">'.$value["nombre"].'</option>';

        }

        echo $cadena;

    }

    public function infoReportConsolidadoEps($idBaseEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrInfoReportConsolidadoEps($idBaseEncuesta);

        // $data = array();

        // foreach ($respuesta as $key => $value) {
        //     $data[] = $value;
        // }

        // $resultado = array(
        //     "draw" => 1,
        //     "recordsTotal" => count($data),
        //     "recordsFiltered" => count($data),
        //     "data" => $data
        // );

        echo json_encode($respuesta);

    }

    public function infoReportConsolidadoGrupoInter($idBaseEncuesta, $procesoEncu){

        $respuesta = ControladorEncuestasReportes::ctrInfoReportConsolidadoGrupoInter($idBaseEncuesta, $procesoEncu);

        echo json_encode($respuesta);

    }

    public function infoReporteFrencuencia($idBaseEncuesta, $tipoEncuesta, $frecuencia){

        $respuesta = ControladorEncuestasReportes::ctrInfoReporteFrencuencia($idBaseEncuesta, $tipoEncuesta, $frecuencia);

        echo json_encode($respuesta);

    }

    public function infoReporteConsolidadoFrencuenciaGrupo($idBaseEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrInfoReporteConsolidadoFrencuenciaGrupo($idBaseEncuesta);

        echo json_encode($respuesta);

    }

    public function infoReportCumplimientoAtencionInicial($idBaseEncuesta, $tipoEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrInfoReportCumplimientoAtencionInicial($idBaseEncuesta, $tipoEncuesta);

        echo json_encode($respuesta);

    }

    public function infoReportConsolidadoDatosIdentificacion($idBaseEncuesta, $tipoEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrInfoReportConsolidadoDatosIdentificacion($idBaseEncuesta, $tipoEncuesta);

        echo json_encode($respuesta);

    }

    public function infoReporteEspecidalidadxProfesional($idBaseEncuesta, $tipoEncuesta, $especialidad, $tipo, $auditor){

        $respuesta = ControladorEncuestasReportes::ctrInfoReporteEspecidalidadxProfesional($idBaseEncuesta, $tipoEncuesta, $especialidad, $tipo, $auditor);

        echo json_encode($respuesta);

    }

    public function infoReporteEspecidalidad($idBaseEncuesta, $tipoEncuesta, $especialidad, $tipo){

        $respuesta = ControladorEncuestasReportes::ctrInfoReporteEspecidalidad($idBaseEncuesta, $tipoEncuesta, $especialidad, $tipo);

        echo json_encode($respuesta);

    }

    public function listaInstrumentos($tipoEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrListaInstrumentos($tipoEncuesta);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Instrumento</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["id_encu_proceso"].'">'.$value["proceso"].'</option>';

        }

        echo $cadena;

    }

    public function segmentosInstrumento($idBaseEncuesta, $idInstrumento){

        $respuesta = ControladorEncuestasReportes::ctrSegmentosInstrumento($idBaseEncuesta, $idInstrumento);

        echo json_encode($respuesta);

    }

    public function preguntasSegmentoIntrumento($idBaseEncuesta, $idEncuSegmento){

        $respuesta = ControladorEncuestasReportes::ctrPreguntasSegmentoIntrumento($idBaseEncuesta, $idEncuSegmento);

        echo json_encode($respuesta);

    }

    public function infoDatosIndicador1($idBaseEncuesta, $procesoEncu, $tipoEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrInfoDatosIndicador1($idBaseEncuesta, $procesoEncu, $tipoEncuesta);

        echo json_encode($respuesta);

    }

    public function infoDatosIndicador2($idBaseEncuesta, $procesoEncu, $tipoEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrInfoDatosIndicador2($idBaseEncuesta, $procesoEncu, $tipoEncuesta);

        echo json_encode($respuesta);

    }

    public function infoReportTratamientoFormulado($idBaseEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrInfoReportTratamientoFormulado($idBaseEncuesta);

        echo json_encode($respuesta);

    }

    public function infoReportConsoMedicoEspecialista($idBaseEncuesta, $tipoEncuesta, $tipoProfesional){

        $respuesta = ControladorEncuestasReportes::ctrInfoReportConsoMedicoEspecialista($idBaseEncuesta, $tipoEncuesta, $tipoProfesional);

        echo json_encode($respuesta);

    }

    public function listaEspecialidadBase($idBaseEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrListaEspecialidadBase($idBaseEncuesta);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione una Especialidad</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["especialidad"].'">'.$value["especialidad"].'</option>';

        }

        echo $cadena;

    }

    public function listaAuditoresEspecialidad($idBaseEncuesta, $tipoEncuesta, $especialidad){

        if(!empty($especialidad)){

            $respuesta = ControladorEncuestasReportes::ctrListaAuditoresEspecialidad($idBaseEncuesta, $tipoEncuesta, $especialidad);

            $cadena = '';
            
            $cadena .= '<option value="">Seleccione un Profesional</option>';

            foreach ($respuesta as $key => $value) {

                $cadena .= '<option value="'.$value["profesional_auditado"].'">'.$value["profesional_auditado"].'</option>';

            }

            echo $cadena;

        }


    }

    public function listaAuditoresInstrumento($idBaseEncuesta, $idInstrumento){

        if(!empty($idInstrumento)){

            $respuesta = ControladorEncuestasReportes::ctrListaAuditoresInstrumento($idBaseEncuesta, $idInstrumento);

            $cadena = '';
            
            $cadena .= '<option value="">Seleccione un Profesional</option>';

            foreach ($respuesta as $key => $value) {

                $cadena .= '<option value="'.$value["nombre_usuario"].'">'.$value["nombre_usuario"].'</option>';

            }

            echo $cadena;

        }

    }

    public function segmentosInstrumentoProfesional($idBaseEncuesta, $idInstrumento, $auditor){

        $respuesta = ControladorEncuestasReportes::ctrSegmentosInstrumentoProfesional($idBaseEncuesta, $idInstrumento, $auditor);

        echo json_encode($respuesta);

    }


    public function preguntasSegmentoIntrumentoProfesional($idBaseEncuesta, $idEncuSegmento, $idInstrumento, $auditor){

        $respuesta = ControladorEncuestasReportes::ctrPreguntasSegmentoIntrumentoProfesional($idBaseEncuesta, $idEncuSegmento, $idInstrumento, $auditor);

        echo json_encode($respuesta);

    }

    public function listaInstrumentosGeneral($tipoEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrObtenerProcesosEncuestaGeneral($tipoEncuesta);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Instrumento</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["id_encu_proceso"].'">'.$value["proceso"].'</option>';

        }

        echo $cadena;

    }

    public function generarReporteGeneralVih($idBaseEncuesta, $idEncuProceso, $tipoEncuesta, $usuario){

        $respuesta = ControladorEncuestasReportes::ctrGenerarReporteGeneralConsolidado($idBaseEncuesta, $idEncuProceso, $tipoEncuesta, $usuario);

        echo json_encode($respuesta);

    }

    // public function obtenerPrueba(){

    //     $respuesta = ControladorEncuestasReportes::obtenerNotaSegmentoEncuesta(196, 59, 15);

    //     echo json_encode($respuesta);

    // }

    public function generarReporteGeneralAutoinmunes($idBaseEncuesta, $idEncuProceso, $tipoEncuesta, $usuario){

        $respuesta = ControladorEncuestasReportes::ctrGenerarReporteGeneralConsolidado($idBaseEncuesta, $idEncuProceso, $tipoEncuesta, $usuario);

        echo json_encode($respuesta);

    }

    public function infoReportConsolidadoCalificacionesSegmento($tipoEncuesta, $idBaseEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrInfoConsolidadoCalificacionSegmento($tipoEncuesta, $idBaseEncuesta);

        echo json_encode($respuesta);

    }

    public function listaSolicitudesReportesConsolidados($tipoEncuesta){

        $respuesta = ControladorEncuestasReportes::ctrListaSolicitudesReportesConsolidados($tipoEncuesta);

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

        case 'listaSolicitudesReportesConsolidados':
            $listaSolicitudesReportesConsolidados = new EncuestasReportesAjax();
            $listaSolicitudesReportesConsolidados->listaSolicitudesReportesConsolidados($_POST["tipoEncuesta"]);
            break;

        case 'infoReportConsolidadoCalificacionesSegmento':
            $infoReportConsolidadoCalificacionesSegmento = new EncuestasReportesAjax();
            $infoReportConsolidadoCalificacionesSegmento->infoReportConsolidadoCalificacionesSegmento($_POST["tipoEncuesta"], $_POST["idBaseEncuesta"]);
            break;

        case 'generarReporteGeneralAutoinmunes':
            $generarReporteGeneralAutoinmunes = new EncuestasReportesAjax();
            $generarReporteGeneralAutoinmunes->generarReporteGeneralAutoinmunes($_POST["idBaseEncuesta"], $_POST["idEncuProceso"], $_POST["tipoEncuesta"], $_POST["user"]);
            break;

        // case 'obtenerPrueba':
        //     $obtenerPrueba = new EncuestasReportesAjax();
        //     $obtenerPrueba->obtenerPrueba();
        //     break;

        case 'listaInstrumentosGeneral':
            $listaInstrumentosGeneral = new EncuestasReportesAjax();
            $listaInstrumentosGeneral->listaInstrumentosGeneral($_POST["tipoEncuesta"]);
            break;

        case 'generarReporteGeneralVih':
            $generarReporteGeneralVih = new EncuestasReportesAjax();
            $generarReporteGeneralVih->generarReporteGeneralVih($_POST["idBaseEncuesta"], $_POST["idEncuProceso"], $_POST["tipoEncuesta"], $_POST["user"]);
            break;

        case 'preguntasSegmentoIntrumentoProfesional':
            $preguntasSegmentoIntrumentoProfesional = new EncuestasReportesAjax();
            $preguntasSegmentoIntrumentoProfesional->preguntasSegmentoIntrumentoProfesional($_POST["idBaseEncuesta"], $_POST["idEncuSegmento"], $_POST["idInstrumento"], $_POST["auditor"]);
            break;

        case 'segmentosInstrumentoProfesional':
            $segmentosInstrumentoProfesional = new EncuestasReportesAjax();
            $segmentosInstrumentoProfesional->segmentosInstrumentoProfesional($_POST["idBaseEncuesta"], $_POST["idInstrumento"], $_POST["auditor"]);
            break;

        case 'listaAuditoresInstrumento':
            $listaAuditoresInstrumento = new EncuestasReportesAjax();
            $listaAuditoresInstrumento->listaAuditoresInstrumento($_POST["idBaseEncu"], $_POST["idInstrumento"]);
            break;

        case 'infoReporteEspecidalidadxProfesional':
            $infoReporteEspecidalidadxProfesional = new EncuestasReportesAjax();
            $infoReporteEspecidalidadxProfesional->infoReporteEspecidalidadxProfesional($_POST["idBaseEncuesta"], $_POST["tipoEncuesta"], $_POST["especialidad"], $_POST["tipo"], $_POST["auditor"]);
            break;

        case 'listaAuditoresEspecialidad':
            $listaAuditoresEspecialidad = new EncuestasReportesAjax();
            $listaAuditoresEspecialidad->listaAuditoresEspecialidad($_POST["idBaseEncu"], $_POST["tipoEncuesta"], $_POST["especialidad"]);
            break;

        case 'listaEspecialidadBase':
            $listaEspecialidadBase = new EncuestasReportesAjax();
            $listaEspecialidadBase->listaEspecialidadBase($_POST["idBaseEncu"]);
            break;

        case 'infoReportConsoMedicoEspecialista':
            $infoReportConsoMedicoEspecialista = new EncuestasReportesAjax();
            $infoReportConsoMedicoEspecialista->infoReportConsoMedicoEspecialista($_POST["idBaseEncuesta"], $_POST["tipoEncuesta"], $_POST["tipoProfesional"]);
            break;

        case 'infoReportTratamientoFormulado':
            $infoReportTratamientoFormulado = new EncuestasReportesAjax();
            $infoReportTratamientoFormulado->infoReportTratamientoFormulado($_POST["idBaseEncuesta"]);
            break;

        case 'infoDatosIndicador2':
            $infoDatosIndicador2 = new EncuestasReportesAjax();
            $infoDatosIndicador2->infoDatosIndicador2($_POST["idBaseEncuesta"], $_POST["procesoEncu"], $_POST["tipoEncuesta"]);
            break;

        case 'infoDatosIndicador1':
            $infoDatosIndicador1 = new EncuestasReportesAjax();
            $infoDatosIndicador1->infoDatosIndicador1($_POST["idBaseEncuesta"], $_POST["procesoEncu"], $_POST["tipoEncuesta"]);
            break;

        case 'preguntasSegmentoIntrumento':
            $preguntasSegmentoIntrumento = new EncuestasReportesAjax();
            $preguntasSegmentoIntrumento->preguntasSegmentoIntrumento($_POST["idBaseEncuesta"], $_POST["idEncuSegmento"]);
            break;

        case 'segmentosInstrumento':
            $segmentosInstrumento = new EncuestasReportesAjax();
            $segmentosInstrumento->segmentosInstrumento($_POST["idBaseEncuesta"], $_POST["idInstrumento"]);
            break;

        case 'listaInstrumentos':
            $listaInstrumentos = new EncuestasReportesAjax();
            $listaInstrumentos->listaInstrumentos($_POST["tipoEncuesta"]);
            break;

        case 'infoReporteEspecidalidad':
            $infoReporteEspecidalidad = new EncuestasReportesAjax();
            $infoReporteEspecidalidad->infoReporteEspecidalidad($_POST["idBaseEncuesta"],$_POST["tipoEncuesta"],$_POST["especialidad"],$_POST["tipo"]);
            break;

        case 'infoReportConsolidadoDatosIdentificacion':
            $infoReportConsolidadoDatosIdentificacion = new EncuestasReportesAjax();
            $infoReportConsolidadoDatosIdentificacion->infoReportConsolidadoDatosIdentificacion($_POST["idBaseEncuesta"], $_POST["tipoEncuesta"]);
            break;

        case 'infoReportCumplimientoAtencionInicial':
            $infoReportCumplimientoAtencionInicial = new EncuestasReportesAjax();
            $infoReportCumplimientoAtencionInicial->infoReportCumplimientoAtencionInicial($_POST["idBaseEncuesta"], $_POST["tipoEncuesta"]);
            break;

        case 'infoReporteConsolidadoFrencuenciaGrupo':
            $infoReporteConsolidadoFrencuenciaGrupo = new EncuestasReportesAjax();
            $infoReporteConsolidadoFrencuenciaGrupo->infoReporteConsolidadoFrencuenciaGrupo($_POST["idBaseEncuesta"]);
            break;

        case 'infoReporteFrencuencia':
            $infoReporteFrencuencia = new EncuestasReportesAjax();
            $infoReporteFrencuencia->infoReporteFrencuencia($_POST["idBaseEncuesta"],$_POST["tipoEncuesta"],$_POST["frecuencia"]);
            break;

        case 'infoReportConsolidadoGrupoInter':
            $infoReportConsolidadoGrupoInter = new EncuestasReportesAjax();
            $infoReportConsolidadoGrupoInter->infoReportConsolidadoGrupoInter($_POST["idBaseEncuesta"], $_POST["procesoEncuesta"]);
            break;

        case 'infoReportConsolidadoEps':
            $infoReportConsolidadoEps = new EncuestasReportesAjax();
            $infoReportConsolidadoEps->infoReportConsolidadoEps($_POST["idBaseEncuesta"]);
            break;

        case 'listaBasesEncuestas':
            $listaBasesEncuestas = new EncuestasReportesAjax();
            $listaBasesEncuestas->listaBasesEncuestas($_POST["tipoEncuesta"]);
            break;

        case 'listaReportesEncuestas':
            $listaReportesEncuestas = new EncuestasReportesAjax();
            $listaReportesEncuestas->listaReportesEncuestas($_POST["tipoEncuesta"]);
            break;

    }

}
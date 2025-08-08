<?php

require_once "../../controllers/encuestas/encuestas-profesional.controller.php";
require_once "../../models/encuestas/encuestas-profesional.model.php";

class EncuestasProfesionalAjax{

    public $datos;

    public function cargarArchivoEncuestas(){

        $datos = $this->datos;

        $respuesta = ControladorEncuestasProfesional::ctrCargarArchivoEncuestas($datos);

        echo $respuesta;
        
    }

    public function basesCargadasEncuestasProfesional(){

        $respuesta = ControladorEncuestasProfesional::ctrListaBasesEncuestas();

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

    public function listaEspecialidades($especialidad){

        $respuesta = ControladorEncuestasProfesional::ctrListaEspecialidades($especialidad);

        echo json_encode($respuesta);

    }

    public function listaBolsasEncuestasProfesional($user){

        $respuesta = ControladorEncuestasProfesional::ctrListaBolsasEncuestasProfesional($user);

        echo json_encode($respuesta);

    }


    public function listaEncuestasBolsaProfesional($user, $especialidad){

        $respuesta = ControladorEncuestasProfesional::ctrListaEncuestasBolsaProfesional($user, $especialidad);

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


    public function tomarEncuestaProfesional(){

        $datos = $this->datos;

        $respuesta = ControladorEncuestasProfesional::ctrTomarEncuestaProfesional($datos);

        echo json_encode($respuesta);

    }

    public function mostrarInfoEncuesta($idEncuesta){

        $respuesta = ControladorEncuestasProfesional::ctrMostrarInformacionEncuesta($idEncuesta);

        echo json_encode($respuesta);

    }

    public function infoAuditoriaEncuesta($idEncuesta){

        $respuesta = ControladorEncuestasProfesional::ctrMostrarInformacionEncuesta($idEncuesta);

        echo json_encode($respuesta);        

    }


    public function guardarInfoAuditoriaEncuesta(){

        $datos = $this->datos;

        $respuesta = ControladorEncuestasProfesional::ctrGuardarInfoAuditoriaEncuesta($datos);

        echo $respuesta;

    }

    public function obtenerProcesosGestionEncuesta($idEncuesta){

        $respuesta = ControladorEncuestasProfesional::ctrObtenerProcesosGestionEncuesta($idEncuesta);

        echo json_encode($respuesta);

    }

    public function descartarEncuesta($idEncuesta){

        $respuesta = ControladorEncuestasProfesional::ctrDescartarEncuesta($idEncuesta);

        echo json_encode($respuesta);

    }

    public function listaSegmentosProcesoEncuesta($idEncuProceso){

        $respuesta = ControladorEncuestasProfesional::ctrListaSegmentosProcesoEncuesta($idEncuProceso);

        echo json_encode($respuesta);

    }

    public function listaPreguntasSegmentosEncuesta($idEncuSegmento){

        $respuesta = ControladorEncuestasProfesional::ctrListaPreguntasSegmentosEncuesta($idEncuSegmento);

        echo json_encode($respuesta);

    }

    public function listaSegmentosParaclinicos($especialidad){

        $respuesta = ControladorEncuestasProfesional::ctrListaSegmentosParaclinicos($especialidad);

        echo json_encode($respuesta);

    }

    public function listaSegmentosProcesoEncuestaPorcentaje($idEncuProceso){

        $respuesta = ControladorEncuestasProfesional::ctrListaSegmentosProcesoEncuestaPorcentaje($idEncuProceso);

        echo json_encode($respuesta);

    }


    public function guardarCalificacionSegmento($datos){

        $respuesta = ControladorEncuestasProfesional::ctrGuardarCalificacionSegmento($datos);

        echo $respuesta;

        // var_dump($respuesta);

    }

    public function listaPreguntasEncuestaProceso($idEncuProceso){

        $respuesta = ControladorEncuestasProfesional::ctrListaPreguntasEncuestaProceso($idEncuProceso);

        echo json_encode($respuesta);

    }

    public function guardarRespuestasEncuesta($arrayRespuestas, $idEncuProceso, $idEncuesta, $calificacionProceso){

        $respuesta = ControladorEncuestasProfesional::ctrGuardarRespuestasEncuesta($arrayRespuestas, $idEncuProceso, $idEncuesta, $calificacionProceso);

        echo $respuesta;

    }

    public function validacionTerminarEncuesta($idEncuesta){

        $respuesta = ControladorEncuestasProfesional::ctrValidacionTerminarEncuesta($idEncuesta);

        echo $respuesta;

    }

    public function obtenerCalificacionesEncuesta($idEncuesta){

        $respuesta = ControladorEncuestasProfesional::ctrObtenerCalificacionesEncuesta($idEncuesta);

        echo json_encode($respuesta);

    }


    public function terminarEncuesta($idEncuesta){

        $respuesta = ControladorEncuestasProfesional::ctrTerminarEncuesta($idEncuesta);

        echo $respuesta;

    }

    public function listaBolsasPendientesEncuestasProfesional($user){

        $respuesta = ControladorEncuestasProfesional::ctrListaBolsasPendientesEncuestasProfesional($user);

        echo json_encode($respuesta);

    }

    public function listaEncuestasBolsaPendientesProfesional($especialidad, $user){

        $respuesta = ControladorEncuestasProfesional::ctrListaEncuestasBolsaPendientesProfesional($especialidad, $user);

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

    public function listaBolsasTerminadasEncuestasProfesional($user){

        $respuesta = ControladorEncuestasProfesional::ctrListaBolsasTerminadasEncuestasProfesional($user);

        echo json_encode($respuesta);

    }


    public function listaEncuestasBolsaTerminadasProfesional($especialidad, $user){

        $respuesta = ControladorEncuestasProfesional::ctrListaEncuestasBolsaTerminadasProfesional($especialidad, $user);

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

    public function listaPreguntasSegmentosEncuestaRespuesta($idEncuesta, $idEncuSegmento){

        $respuesta = ControladorEncuestasProfesional::ctrListaPreguntasSegmentosEncuestaRespuesta($idEncuesta, $idEncuSegmento);

        echo json_encode($respuesta);

    }

    public function eliminarCalificacionesSegmentosRespuestas($idEncuesta, $idEncuProceso){

        $respuesta = ControladorEncuestasProfesional::ctrEliminarCalificacionesSegmentosRespuestas($idEncuesta, $idEncuProceso);

        echo json_encode($respuesta);

    }


}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'eliminarCalificacionesSegmentosRespuestas':
            $eliminarCalificacionesSegmentosRespuestas = new EncuestasProfesionalAjax();
            $eliminarCalificacionesSegmentosRespuestas->eliminarCalificacionesSegmentosRespuestas($_POST["idEncuesta"], $_POST["idEncuProceso"]);
            break;

        case 'listaPreguntasSegmentosEncuestaRespuesta':
            $listaPreguntasSegmentosEncuestaRespuesta = new EncuestasProfesionalAjax();
            $listaPreguntasSegmentosEncuestaRespuesta->listaPreguntasSegmentosEncuestaRespuesta($_POST["idEncuesta"], $_POST["idEncuSegmento"]);
            break;

        case 'listaEncuestasBolsaTerminadasProfesional':
            $listaEncuestasBolsaTerminadasProfesional = new EncuestasProfesionalAjax();
            $listaEncuestasBolsaTerminadasProfesional->listaEncuestasBolsaTerminadasProfesional($_POST["especialidad"], $_POST["user"]);
            break;

        case 'listaBolsasTerminadasEncuestasProfesional':
            $listaBolsasTerminadasEncuestasProfesional = new EncuestasProfesionalAjax();
            $listaBolsasTerminadasEncuestasProfesional->listaBolsasTerminadasEncuestasProfesional($_POST["user"]);
            break;

        case 'listaEncuestasBolsaPendientesProfesional':
            $listaEncuestasBolsaPendientesProfesional = new EncuestasProfesionalAjax();
            $listaEncuestasBolsaPendientesProfesional->listaEncuestasBolsaPendientesProfesional($_POST["especialidad"], $_POST["user"]);
            break;

        case 'listaBolsasPendientesEncuestasProfesional':
            $listaBolsasPendientesEncuestasProfesional = new EncuestasProfesionalAjax();
            $listaBolsasPendientesEncuestasProfesional->listaBolsasPendientesEncuestasProfesional($_POST["user"]);
            break;

        case 'terminarEncuesta':
            $terminarEncuesta = new EncuestasProfesionalAjax();
            $terminarEncuesta->terminarEncuesta($_POST["idEncuesta"]);
            break;

        case 'obtenerCalificacionesEncuesta':
            $obtenerCalificacionesEncuesta = new EncuestasProfesionalAjax();
            $obtenerCalificacionesEncuesta->obtenerCalificacionesEncuesta($_POST["idEncuesta"]);
            break;

        case 'validacionTerminarEncuesta':
            $validacionTerminarEncuesta = new EncuestasProfesionalAjax();
            $validacionTerminarEncuesta->validacionTerminarEncuesta($_POST["idEncuesta"]);
            break;

        case 'guardarRespuestasEncuesta':
            $guardarRespuestasEncuesta = new EncuestasProfesionalAjax();
            $guardarRespuestasEncuesta->guardarRespuestasEncuesta($_POST["arrayRespuestas"], $_POST["idEncuProceso"], $_POST["idEncuesta"], $_POST["calificacionProceso"]);
            break;

        case 'listaPreguntasEncuestaProceso':
            $listaPreguntasEncuestaProceso = new EncuestasProfesionalAjax();
            $listaPreguntasEncuestaProceso->listaPreguntasEncuestaProceso($_POST["idEncuProceso"]);
            break;

        case 'guardarCalificacionSegmento':
            $guardarCalificacionSegmento = new EncuestasProfesionalAjax();
            $guardarCalificacionSegmento->guardarCalificacionSegmento($_POST["datos"]);
            break;

        case 'listaSegmentosProcesoEncuestaPorcentaje':
            $listaSegmentosProcesoEncuestaPorcentaje = new EncuestasProfesionalAjax();
            $listaSegmentosProcesoEncuestaPorcentaje->listaSegmentosProcesoEncuestaPorcentaje($_POST["idEncuProceso"]);
            break;
        
        case 'listaSegmentosParaclinicos':
            $listaSegmentosParaclinicos = new EncuestasProfesionalAjax();
            $listaSegmentosParaclinicos->listaSegmentosParaclinicos($_POST["especialidad"]);
            break;

        case 'listaPreguntasSegmentosEncuesta':
            $listaPreguntasSegmentosEncuesta = new EncuestasProfesionalAjax();
            $listaPreguntasSegmentosEncuesta->listaPreguntasSegmentosEncuesta($_POST["idEncuSegmento"]);
            break;

        case 'listaSegmentosProcesoEncuesta':
            $listaSegmentosProcesoEncuesta = new EncuestasProfesionalAjax();
            $listaSegmentosProcesoEncuesta->listaSegmentosProcesoEncuesta($_POST["idEncuProceso"]);
            break;

        case 'descartarEncuesta':
            $descartarEncuesta = new EncuestasProfesionalAjax();
            $descartarEncuesta->descartarEncuesta($_POST["idEncuesta"]);
            break;

        case 'obtenerProcesosGestionEncuesta':
            $obtenerProcesosGestionEncuesta = new EncuestasProfesionalAjax();
            $obtenerProcesosGestionEncuesta->obtenerProcesosGestionEncuesta($_POST["idEncuesta"]);
            break;

        case 'guardarInfoAuditoriaEncuesta':
            $guardarInfoAuditoriaEncuesta = new EncuestasProfesionalAjax();
            $guardarInfoAuditoriaEncuesta->datos = array(
                "id_encuesta" => $_POST["idEncuesta"],
                "nombre_paciente" => strtoupper($_POST["nombrePaciente"]),
                "edad" => $_POST["edadPaciente"],
                "sexo" => strtoupper($_POST["sexoPaciente"]),
                "modalidad_consulta_tipo_atencion" => strtoupper($_POST["modalidadConsultaPaciente"]),
                "usuario_edita" => $_POST["usuarioEdit"]
            );
            $guardarInfoAuditoriaEncuesta->guardarInfoAuditoriaEncuesta();
            break;

        case 'obtenerInfoAuditoriaEncuesta':
            $infoAuditoriaEncu = new EncuestasProfesionalAjax();
            $infoAuditoriaEncu->infoAuditoriaEncuesta($_POST["idEncuesta"]);
            break;

        case 'mostrarInfoEncuesta':
            $mostrarInfoEncuesta = new EncuestasProfesionalAjax();
            $mostrarInfoEncuesta->mostrarInfoEncuesta($_POST["idEncuesta"]);
            break;

        case 'tomarEncuestaProfesional':
            $tomarEncuestaProfesional = new EncuestasProfesionalAjax();
            $tomarEncuestaProfesional->datos = array(
                "id_encuesta" => $_POST["idEncuesta"],
                "auditor" => $_POST["auditor"],
                "nombre_auditor" => $_POST["nombreUser"],
                "id_base_encu" => $_POST["idBaseEncuesta"],
                "especialidad" => $_POST["especialidad"],
            );
            $tomarEncuestaProfesional->tomarEncuestaProfesional();
            break;

        case 'listaEncuestasBolsaProfesional':
            $listaEncuestasBolsaProfesional = new EncuestasProfesionalAjax();
            $listaEncuestasBolsaProfesional->listaEncuestasBolsaProfesional($_POST["user"], $_POST["especialidad"]);
            break;

        case 'listaBolsasEncuestasProfesional':
            $listaBolsasEncuestasProfesional = new EncuestasProfesionalAjax();
            $listaBolsasEncuestasProfesional->listaBolsasEncuestasProfesional($_POST["user"]);
            break;

        case 'listaEspecialidades':
            $listaEspecialidades = new EncuestasProfesionalAjax();
            $listaEspecialidades->listaEspecialidades($_POST["especialidad"]);
            break;

        case 'basesCargadasEncuestas':
            $basesCargadasEncuestas = new EncuestasProfesionalAjax();
            $basesCargadasEncuestas->basesCargadasEncuestasProfesional();
            break;

        case 'cargarArchivoEncuestas':
            $cargarArchivoEncuestas = new EncuestasProfesionalAjax();
            $cargarArchivoEncuestas->datos = array(
                "nombre_archivo" => $_POST["nombreArchivo"],
                "especialidad" => $_POST["especialidad"],
                "nivel_confianza" => $_POST["nivelConfianza"],
                "margen_error" => $_POST["margenError"],
                "archivo" => $_FILES["archivoEncuesta"],
                "auditor" => $_POST["auditorEncuesta"],
                "usuario" => $_POST["user"]
            );
            $cargarArchivoEncuestas->cargarArchivoEncuestas();
            break;

    }

}
<?php

$rutaControlador =  __DIR__. "\..\..\controllers\callcenter\callcenter.controller.php";
$rutaModelo = __DIR__ . "\..\..\models\callcenter\callcenter.model.php";
//echo $rutaControlador;

require_once $rutaControlador;
require_once $rutaModelo;
//require_once "../../models/callcenter/callcenter.model.php";

class CallCenterAjax{

    public $datos;

    public function buscarPaciente($filtro, $valor){

        $respuesta = ControladorCallCenter::ctrBuscarPaciente($filtro, $valor);

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

    public function crearGestionCall($procesoCall, $idPaciente, $asesor){

        $respuesta = ControladorCallCenter::ctrCrearGestionCall($procesoCall, $idPaciente, $asesor);

        echo json_encode($respuesta);

    }

    public function infoCall($idCall, $procesoCall){

        $respuesta = ControladorCallCenter::ctrInfoCall($idCall, $procesoCall);

        echo json_encode($respuesta);

    }

    public function mostrarPreguntasProcesoCall($procesoCall){

        $respuesta = ControladorCallCenter::ctrMostrarPreguntasProcesoCall($procesoCall);

        echo json_encode($respuesta);

    }

    public function crearComunicacionFallida(){

        $datos = $this->datos;

        $respuesta = ControladorCallCenter::ctrCrearComunicacionFallida($datos);

        echo $respuesta;
    }

    public function terminarGestionCall($idCall, $estado){

        $respuesta = ControladorCallCenter::ctrTerminarGestionCall($idCall, $estado);

        echo $respuesta;

    }

    public function guardarRespuestaPreguntaCall(){

        $datos = $this->datos;

        $respuesta = ControladorCallCenter::ctrGuardarRespuestaPreguntaCall($datos);

        echo $respuesta;

    }

    public function listaPendientesCall($usuario){

        $respuesta = ControladorCallCenter::ctrListaPendientesCall($usuario);

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

    public function listaComunicacionFallidasCall($idCall){

        $respuesta = ControladorCallCenter::ctrListaDato("call_center_comunicaciones_fallidas", "id_call", $idCall);

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

    public function mostrarEspaciosAgendaProfesional($idProfesional, $fechaCita){

        $respuesta = ControladorCallCenter::ctrMostrarEspaciosAgendaProfesional($idProfesional, $fechaCita);

        echo json_encode($respuesta);

    }


    public function crearCitaAgenda(){

        $datos = $this->datos;

        $respuesta = ControladorCallCenter::ctrCrearCitaAgenda($datos);

        echo $respuesta;

    }

    public function mostrarDiasAgendaProfesional($idProfesional){

        $respuesta = ControladorCallCenter::ctrMostrarDiasAgendaProfesional($idProfesional);

        echo json_encode($respuesta);

    }

    public function mostrarHorasAgendaProfesional($idProfesional, $fechaCita){

        $respuesta = ControladorCallCenter::ctrMostrarHorasAgendaProfesional($idProfesional, $fechaCita);

        echo json_encode($respuesta);

    }

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'mostrarHorasAgendaProfesional':
            $mostrarHorasAgendaProfesional = new CallCenterAjax();
            $mostrarHorasAgendaProfesional->mostrarHorasAgendaProfesional($_POST["idProfesional"], $_POST["fechaCita"]);
            break;

        case 'mostrarDiasAgendaProfesional':
            $mostrarDiasAgendaProfesional = new CallCenterAjax();
            $mostrarDiasAgendaProfesional->mostrarDiasAgendaProfesional($_POST["idProfesional"]);
            break;

        case 'crearCitaAgenda':
            $crearCitaAgenda = new CallCenterAjax();
            $crearCitaAgenda->datos = array(
                "motivo_cita" => strtoupper($_POST["motivoCita"]),
                "id_profesional" => $_POST["idProfesional"],
                "id_paciente" => $_POST["idPaciente"],
                "fecha_cita" => $_POST["fechaCita"],
                "hora_cita" => $_POST["horaCita"],
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $crearCitaAgenda->crearCitaAgenda();
            break;

        case 'mostrarEspaciosAgendaProfesional':
            $mostrarEspacioAgendaPro = new CallCenterAjax();
            $mostrarEspacioAgendaPro->mostrarEspaciosAgendaProfesional($_POST["idProfesional"], $_POST["fechaCita"]);
            break;

        case 'buscarPacienteCall':
            $buscarPaciente = new CallCenterAjax();
            $buscarPaciente->buscarPaciente($_POST["filtroBusqueda"], $_POST["valorBusqueda"]);
            break;

        case 'crearGestionCall':
            $crearGestionCall = new CallCenterAjax();
            $crearGestionCall->crearGestionCall($_POST["procesoCall"], $_POST["idPaciente"], $_POST["asesor"]);
            break;

        case 'infoCall':
            $infoCall = new CallCenterAjax();
            $infoCall->infoCall($_POST["idCall"], $_POST["procesoCall"]);
            break;

        case 'mostrarPreguntasProcesoCall':
            $preguntasCall = new CallCenterAjax();
            $preguntasCall->mostrarPreguntasProcesoCall($_POST["procesoCall"]);
            break;

        case 'crearRegistroComunicacionFallida':
            $registroComFallida = new CallCenterAjax();
            $registroComFallida->datos = array(
                "id_call" => $_POST["idCall"],
                "causal_fallida" => $_POST["causalFallida"],
                "observaciones" => $_POST["observacionFallida"],
                "cantidad_gestiones" => $_POST["cantidadGestiones"],
                "proceso_call" => $_POST["procesoCall"],
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $registroComFallida->crearComunicacionFallida();
            break;

        case 'guardarRespuestaPreguntaCall':
            $guardarRespuestaPreguntaCall = new CallCenterAjax();
            $guardarRespuestaPreguntaCall->datos = array(
                "id_call" => $_POST["id_call"],
                "id_pregunta" => $_POST["id_pregunta"],
                "respuesta" => strtoupper($_POST["respuesta"]),
                "origen_encuesta" => $_POST["origen_encuesta"],
                "usuario_crea" => $_POST["usuario_crea"]
            );
            $guardarRespuestaPreguntaCall->guardarRespuestaPreguntaCall();
            break;

        case 'terminarGestionCall':
            $terminarGestionCall = new CallCenterAjax();
            $terminarGestionCall->terminarGestionCall($_POST["id_call"], $_POST["estado"]);
            break;

        case 'listaPendientesCall':
            $listaPendientesCall = new CallCenterAjax();
            $listaPendientesCall->listaPendientesCall($_POST["usuario"]);
            break;

        case 'listaComunicacionFallidasCall':
            $listaComunicacionFallidasCall = new CallCenterAjax();
            $listaComunicacionFallidasCall->listaComunicacionFallidasCall($_POST["idCall"]);
            break;
    }

}
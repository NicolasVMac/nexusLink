<?php

$rutaControlador =  __DIR__. "\..\..\controllers\di\agendamiento.controller.php";
$rutaModelo = __DIR__ . "\..\..\models\di\agendamiento.model.php";
//echo $rutaControlador;

require_once $rutaControlador;
require_once $rutaModelo;
//require_once "../../models/callcenter/callcenter.model.php";

class AgendamientoAjax{

    public $datos;

    public function cargarArchivoAgendamiento($nombreArchivo, $archivo, $user){

        $datos = array(
            "nombre_archivo" => $nombreArchivo,
            "archivo" => $archivo,
            "usuario" => $user
        );

        $respuesta = ControladorAgendamiento::ctrCargarArchivoAgendamiento($datos);

        echo $respuesta;
        
    }

    public function basesCargadasAgendamientoPacientes(){

        $respuesta = ControladorAgendamiento::ctrListaBasesAgendamiento();

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

    public function listaAgendamientoBolsa($cohortePrograma){

        $respuesta = ControladorAgendamiento::ctrListaAgendamientoBolsa($cohortePrograma);

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

    public function tomarAgendamiento($idBolsaPaciente, $asesor){

        $respuesta = ControladorAgendamiento::ctrTomarAgendamiento($idBolsaPaciente, $asesor);

        echo json_encode($respuesta);

    }

    public function validarExistePaciente($idBolsaPaciente){

        $respuesta = ControladorAgendamiento::ctrValidarExistePaciente($idBolsaPaciente);

        echo $respuesta;

    }

    public function listaAgendamientosPendienteUser($user){

        $respuesta = ControladorAgendamiento::ctrListaAgendamientoPendienteUser($user);

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

    public function verInfoAgendamiento($idAgendamiento){

        $respuesta = ControladorAgendamiento::ctrObtenerAgendamiento($idAgendamiento);

        echo json_encode($respuesta);

    }

    public function crearComunicacionFallida(){

        $datos = $this->datos;

        $respuesta = ControladorAgendamiento::ctrCrearComunicacionFallida($datos);

        echo $respuesta;

    }

    public function listaComunicacionFallidasAgendamiento($idAgendamiento){

        $respuesta = ControladorAgendamiento::ctrListaComunicacionFallidasAgendamiento($idAgendamiento);

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

    public function verCitasPendientesPaciente($idPaciente){

        $respuesta = ControladorAgendamiento::ctrVerCitasPendientesPaciente($idPaciente);

        echo json_encode($respuesta);

    }

    public function validarDisponibilidadMedicoCita($idProfesional, $fechaCita, $franjaCita){

        $respuesta = ControladorAgendamiento::ctrValidarDisponibilidadMedicoCita($idProfesional, $fechaCita, $franjaCita);

        echo json_encode($respuesta);

    }

    public function crearCita(){

        $datos = $this->datos;

        $respuesta = ControladorAgendamiento::ctrCrearCita($datos);

        echo $respuesta;

    }

    public function crearCitaBusqueda(){

        $datos = $this->datos;

        $respuesta = ControladorAgendamiento::ctrCrearCitaBusqueda($datos);

        echo $respuesta;

    }

    public function terminarGestionAgendamiento(){

        $datos = $this->datos;

        $respuesta = ControladorAgendamiento::ctrTerminarGestionAgendamiento($datos);

        echo $respuesta;

    }

    public function listaCitasCalendar(){

        $respuesta = ControladorAgendamiento::ctrListaCitasCalendar();

        echo json_encode($respuesta);

    }

    public function listaCitasCalendarProfesional($idProfesional){

        $respuesta = ControladorAgendamiento::ctrListaCitasCalendarProfesional($idProfesional);

        echo json_encode($respuesta);
        
    }

    public function validaDatosPaciente($idBolsaAgendamiento, $tipoDocumento, $numeroDocumento){

        $respuesta = ControladorAgendamiento::ctrValidaDatosPaciente($idBolsaAgendamiento, $tipoDocumento, $numeroDocumento);

        echo json_encode($respuesta);

    }

    public function listaCohorteProgramas(){

        $respuesta = ControladorAgendamiento::ctrListaCohorteProgramas();

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Cohorte o Programa</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["cohorte_programa"].'">'.$value["cohorte_programa"].'</option>';

        }

        echo $cadena;

    }

    public function crearPrioridad($cohortePrograma, $prioridad, $usuarioCrea){

        $respuesta = ControladorAgendamiento::ctrCrearPrioridad($cohortePrograma, $prioridad, $usuarioCrea);

        echo $respuesta;

    }

    public function listaPrioridadesAgendamiento(){

        $respuesta = ControladorAgendamiento::ctrListaPrioridadesAgendamiento();

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

    public function eliminarPrioridad($idPrioridad){

        $respuesta = ControladorAgendamiento::ctrEliminarPrioridad($idPrioridad);

        echo $respuesta;

    }

    public function eliminarCita($idCita, $user){

        $respuesta = ControladorAgendamiento::ctrEliminarCita($idCita, $user);

        echo $respuesta;

    }

    public function reAgendarCita(){

        $datos = $this->datos;

        $respuesta = ControladorAgendamiento::ctrReAgendarCita($datos);

        echo $respuesta;

    }

    public function validarNoDisponibilidad($idProfesional, $fechaCita){

        $respuesta = ControladorAgendamiento::ctrValidarNoDisponibilidad($idProfesional, $fechaCita);

        echo $respuesta;

    }

    public function crearNoDisponibilidad(){

        $datos = $this->datos;

        $respuesta = ControladorAgendamiento::ctrCrearNoDisponibilidad($datos);

        echo $respuesta;

    }

    public function guardarInformacionNexusVidamedical($idBolsaAgendamiento){

        $respuesta = ControladorAgendamiento::ctrGuardarInformacionNexusVidamedical($idBolsaAgendamiento);

        echo json_encode($respuesta);

    }

    public function listaProfesionalesAgendamiento(){

        $respuesta = ControladorAgendamiento::ctrListaProfesionalesAgendamiento();

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

    public function listaUsuariosAgendamiento(){

        $respuesta = ControladorAgendamiento::ctrListaUsuariosAgendamiento();

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Usuario</option>';

        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["usuario"].'">'.$value["nombre"] . ' - ' . $value["usuario"].'</option>';

        }

        echo $cadena;

    }

    public function crearAsignacionBolsa(){

        $datos = $this->datos;

        $respuesta = ControladorAgendamiento::ctrCrearAsignacionBolsa($datos);

        echo $respuesta;

    }

    public function listaAsignacionesBolsasAgendamiento(){

        $respuesta = ControladorAgendamiento::ctrListaAsignacionesBolsasAgendamiento();

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

    public function eliminarAsignacionBolsaAgendamiento($idUsuBolsaAgend){

        $respuesta = ControladorAgendamiento::ctrEliminarAsignacionBolsaAgendamiento($idUsuBolsaAgend);

        echo $respuesta;

    }

    public function listaBolsasAgendamientoUser($user){

        $respuesta = ControladorAgendamiento::ctrListaBolsasAgendamientoUser($user);

        echo json_encode($respuesta);

    }

    public function listaAgendamientosPendienteUserCohorte($cohortePrograma, $user){

        $respuesta = ControladorAgendamiento::ctrListaAgendamientosPendienteUserCohorte($cohortePrograma, $user);

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

    public function listaAgendamientosBusqueda($tipoDocumento, $numeroDocumento){

        $respuesta = ControladorAgendamiento::ctrListaAgendamientosBusqueda($tipoDocumento, $numeroDocumento);

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

    public function asignarAgendamiento(){

        $datos = $this->datos;

        $respuesta = ControladorAgendamiento::ctrAsignarAgendamiento($datos);

        echo $respuesta;

    }

    public function listaPacienteAgenda(){

        $datos = $this->datos;

        $respuesta = ControladorAgendamiento::ctrListaPacienteAgenda($datos);

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

    public function infoPacienteBolsaAgendamiento($idBolsaAgendamiento){

        $respuesta = ControladorAgendamiento::ctrInfoPacienteBolsaPaciente($idBolsaAgendamiento);

        echo json_encode($respuesta);

    }

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){
        
        case 'infoPacienteBolsaAgendamiento':
            $infoPacienteBolsaAgendamiento = new AgendamientoAjax();
            $infoPacienteBolsaAgendamiento->infoPacienteBolsaAgendamiento($_POST["idBolsaPacienteAgendamiento"]);
            break;

        case 'listaPacienteAgenda':
            $listaPacienteAgenda = new AgendamientoAjax();
            $listaPacienteAgenda->datos = array(
                "tipoDoc" => $_POST["tipoDoc"],
                "tipoBusqueda" => $_POST["tipoBusqueda"],
                "numeroDocumento" => $_POST["numeroDocumento"],
            );
            $listaPacienteAgenda->listaPacienteAgenda();
            break;

        case 'asignarAgendamiento':
            $asignarAgendamiento = new AgendamientoAjax();
            $asignarAgendamiento->datos = array(
                "id_bolsa_paciente" => base64_decode($_POST["idBolsaPaciente"]),
                "asesor" => $_POST["usuarioAgendador"]
            );
            $asignarAgendamiento->asignarAgendamiento();
            break;

        case 'listaAgendamientosBusqueda':
            $listaAgendamientosBusqueda = new AgendamientoAjax();
            $listaAgendamientosBusqueda->listaAgendamientosBusqueda($_POST["tipoDocumento"], $_POST["numeroDocumento"]);
            break;

        case 'listaAgendamientosPendienteUserCohorte':
            $listaAgendamientosPendienteUserCohorte = new AgendamientoAjax();
            $listaAgendamientosPendienteUserCohorte->listaAgendamientosPendienteUserCohorte($_POST["cohorte"], $_POST["user"]);
            break;

        case 'listaBolsasAgendamientoUser':
            $listaBolsasAgendamientoUser = new AgendamientoAjax();
            $listaBolsasAgendamientoUser->listaBolsasAgendamientoUser($_POST["userBolsa"]);
            break;

        case 'eliminarAsignacionBolsaAgendamiento':
            $eliminarAsignacionBolsaAgendamiento = new AgendamientoAjax();
            $eliminarAsignacionBolsaAgendamiento->eliminarAsignacionBolsaAgendamiento($_POST["idUsuBolsaAgend"]);
            break;

        case 'listaAsignacionesBolsasAgendamiento':
            $listaAsignacionesBolsasAgendamiento = new AgendamientoAjax();
            $listaAsignacionesBolsasAgendamiento->listaAsignacionesBolsasAgendamiento();
            break;

        case 'crearAsignacionBolsa':
            $crearAsignacionBolsa = new AgendamientoAjax();
            $crearAsignacionBolsa->datos = array(
                "usuario" => $_POST["usuario"],
                "cohorte" => $_POST["cohortePrograma"],
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $crearAsignacionBolsa->crearAsignacionBolsa();
            break;

        case 'listaUsuariosAgendamiento':
            $listaUsuariosAgendamiento = new AgendamientoAjax();
            $listaUsuariosAgendamiento->listaUsuariosAgendamiento();
            break;

        case 'listaProfesionalesAgendamiento':
            $listaProfesionalesAgendamiento = new AgendamientoAjax();
            $listaProfesionalesAgendamiento->listaProfesionalesAgendamiento();
            break;

        case 'guardarInformacionNexusVidamedical':
            $guardarInformacionNexusVidamedical = new AgendamientoAjax();
            $guardarInformacionNexusVidamedical->guardarInformacionNexusVidamedical($_POST["idBolsaAgendamiento"]);
            break; 

        case 'crearNoDisponibilidad':
            $crearNoDisponibilidad = new AgendamientoAjax();
            $crearNoDisponibilidad->datos = array(
                "id_profesional" => $_POST["idProfesional"],
                "motivo_cita" => $_POST["motivoCita"],
                "fecha_cita" => $_POST["fechaCita"],
                "franja_cita" => $_POST["franjaCita"],
                "localidad_cita" => $_POST["localidadCita"],
                "observaciones_cita" => strtoupper($_POST["observacionCita"]),
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $crearNoDisponibilidad->crearNoDisponibilidad();
            break;

        case 'validarNoDisponibilidad':
            $validarNoDisponibilidad = new AgendamientoAjax();
            $validarNoDisponibilidad->validarNoDisponibilidad($_POST["idProfesional"], $_POST["fechaCita"]);
            break;

        case 'reAgendarCita':
            $reAgendarCita = new AgendamientoAjax();
            $reAgendarCita->datos = array(
                "idCita" => $_POST["idCita"],
                "idProfesional" => $_POST["idProfesional"],
                "fechaCita" => $_POST["fechaCita"],
                "franjaCita" => $_POST["franjaCita"],
                "servicioCita" => $_POST["servicioCita"],
                "usuario" => $_POST["user"]
            );
            $reAgendarCita->reAgendarCita();
            break;

        case 'eliminarCita':
            $eliminarCita = new AgendamientoAjax();
            $eliminarCita->eliminarCita($_POST["idCita"], $_POST["user"]);
            break;

        case 'eliminarPrioridad':
            $eliminarPrioridad = new AgendamientoAjax();
            $eliminarPrioridad->eliminarPrioridad($_POST["idPrioridad"]);
            break;

        case 'listaPrioridadesAgendamiento':
            $listaPrioridadesAgendamiento = new AgendamientoAjax();
            $listaPrioridadesAgendamiento->listaPrioridadesAgendamiento();
            break;

        case 'crearPrioridad':
            $crearPrioridad = new AgendamientoAjax();
            $crearPrioridad->crearPrioridad($_POST["cohortePrograma"], $_POST["prioridad"], $_POST["usuarioCrea"]);
            break;

        case 'listaCohorteProgramas':
            $listaCohorteProgramas = new AgendamientoAjax();
            $listaCohorteProgramas->listaCohorteProgramas();
            break;

        case 'validaDatosPaciente':
            $validaDatosPaciente = new AgendamientoAjax();
            $validaDatosPaciente->validaDatosPaciente($_POST["idBolsaAgendamiento"], $_POST["tipoDocumento"], $_POST["numeroDocumento"]);
            break;

        case 'listaCitasCalendarProfesional':
            $listaCitasCalendarProfesional = new AgendamientoAjax();
            $listaCitasCalendarProfesional->listaCitasCalendarProfesional($_POST["idProfesional"]);
            break;

        case 'listaCitasCalendar':
            $listaCitasCalendar = new AgendamientoAjax();
            $listaCitasCalendar->listaCitasCalendar();
            break;

        case 'terminarGestionAgendamiento':
            $terminarGestionAgendamiento = new AgendamientoAjax();
            $terminarGestionAgendamiento->datos = array(
                "id_bolsa_paciente" => $_POST["idBolsaAgendamiento"],
                "estado" => $_POST["estado"]
            );
            $terminarGestionAgendamiento->terminarGestionAgendamiento();
            break;

        case 'crearCitaBusqueda':
            $crearCitaBusqueda = new AgendamientoAjax();
            $crearCitaBusqueda->datos = array(
                "id_profesional" => $_POST["idProfesional"],
                "id_paciente" => $_POST["idPaciente"],
                "id_bolsa_agendamiento" => $_POST["idBolsaAgendamiento"],
                "motivo_cita" => mb_strtoupper($_POST["motivoCita"]),
                "fecha_cita" => $_POST["fechaCita"],
                "franja_cita" => $_POST["franjaCita"],
                "observaciones_cita" => mb_strtoupper($_POST["observacionCita"]),
                "cohorte_programa" => $_POST["cohortePrograma"],
                "localidad_cita" => $_POST["localidadCita"],
                "servicio_cita" => $_POST["servicioCita"],
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $crearCitaBusqueda->crearCitaBusqueda();
            break;

        case 'crearCita':
            $crearCita = new AgendamientoAjax();
            $crearCita->datos = array(
                "id_profesional" => $_POST["idProfesional"],
                "id_paciente" => $_POST["idPaciente"],
                "id_bolsa_agendamiento" => $_POST["idBolsaAgendamiento"],
                "motivo_cita" => mb_strtoupper($_POST["motivoCita"]),
                "fecha_cita" => $_POST["fechaCita"],
                "franja_cita" => $_POST["franjaCita"],
                "observaciones_cita" => mb_strtoupper($_POST["observacionCita"]),
                "cohorte_programa" => $_POST["cohortePrograma"],
                "localidad_cita" => $_POST["localidadCita"],
                "servicio_cita" => $_POST["servicioCita"],
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $crearCita->crearCita();
            break;
        
        case 'validarDisponibilidadMedicoCita':
            $validarDisponibilidadMedicoCita = new AgendamientoAjax();
            $validarDisponibilidadMedicoCita->validarDisponibilidadMedicoCita($_POST["idProfesional"], $_POST["fechaCita"], $_POST["franjaCita"]);
            break;

        case 'verCitasPendientesPaciente':
            $verCitasPendientesPaciente = new AgendamientoAjax();
            $verCitasPendientesPaciente->verCitasPendientesPaciente($_POST["idPaciente"]);
            break;

        case 'listaComunicacionFallidasAgendamiento':
            $listaComunicacionFallidasAgendamiento = new AgendamientoAjax();
            $listaComunicacionFallidasAgendamiento->listaComunicacionFallidasAgendamiento($_POST["idAgendamiento"]);
            break;

        case 'crearComunicacionFallida':
            $crearComunicacionFallida = new AgendamientoAjax();
            $crearComunicacionFallida->datos = array(
                "id_bolsa_paciente" => $_POST["idBolsaPaciente"],
                "causal_fallida" => $_POST["causalFallida"],
                "observaciones" => $_POST["observacionFallida"],
                "cantidad_gestiones" => $_POST["cantidadGestiones"],
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $crearComunicacionFallida->crearComunicacionFallida();
            break;

        case 'verInfoAgendamiento':
            $verInfoAgendamiento = new AgendamientoAjax();
            $verInfoAgendamiento->verInfoAgendamiento($_POST["idAgendamiento"]);
            break;

        case 'listaAgendamientosPendienteUser':
            $listaAgendamientosPendienteUser = new AgendamientoAjax();
            $listaAgendamientosPendienteUser->listaAgendamientosPendienteUser($_POST["user"]);
            break;

        case 'validarExistePaciente':
            $validarExistePaciente = new AgendamientoAjax();
            $validarExistePaciente->validarExistePaciente($_POST["idBolsaPaciente"]);
            break;

        case 'tomarAgendamiento':
            $tomarAgendamiento = new AgendamientoAjax();
            $tomarAgendamiento->tomarAgendamiento($_POST["idBolsaPaciente"], $_POST["asesor"]);
            break;

        case 'listaAgendamientoBolsa':
            $listaAgendamientoBolsa = new AgendamientoAjax();
            $listaAgendamientoBolsa->listaAgendamientoBolsa($_POST["cohortePrograma"]);
            break;

        case 'basesCargadasAgendamientoPacientes':
            $basesCargadasAgendamientoPacientes = new AgendamientoAjax();
            $basesCargadasAgendamientoPacientes->basesCargadasAgendamientoPacientes();
            break;

        case 'cargarArchivoAgendamiento':
            $cargarArchivoAgendamiento = new AgendamientoAjax();
            $cargarArchivoAgendamiento->cargarArchivoAgendamiento($_POST["nombreArchivo"], $_FILES["archivoAgendamiento"], $_POST["user"]);
            break;

    }

}
<?php

require_once "../../controllers/encuestas/encuestas.controller.php";
require_once "../../models/encuestas/encuestas.model.php";

class EncuestasAjax{

    public $datos;

    public function cargarArchivoEncuestas(){

        $datos = $this->datos;

        $respuesta = ControladorEncuestas::ctrCargarArchivoEncuestas($datos);

        echo $respuesta;
        
    }

    public function basesCargadasEncuestas(){

        $respuesta = ControladorEncuestas::ctrListaBasesEncuestas();

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

    public function listaEncuestasBolsa($tipoEncuesta, $user){

        $respuesta = ControladorEncuestas::ctrListaEncuestasBolsa($tipoEncuesta, $user);

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        // var_dump($data);

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }

    public function tomarEncuesta($idEncuesta, $auditor, $idBaseEncuesta, $tipoEncuesta, $nombreUser){

        $respuesta = ControladorEncuestas::ctrTomarEncuesta($idEncuesta, $auditor, $idBaseEncuesta, $tipoEncuesta, $nombreUser);

        echo json_encode($respuesta);

    }

    public function listaEncuestasPendientesUser($tipoEncuesta, $auditor){

        $respuesta = ControladorEncuestas::ctrListaEncuestasPendientesUser($tipoEncuesta, $auditor);

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

    public function obtenerProcesosInicialesEncuesta($tipoEncuesta){

        $respuesta = ControladorEncuestas::ctrObtenerProcesosInicialesEncuesta($tipoEncuesta);

        echo json_encode($respuesta);

    }

    public function listaSegmentosProcesoEncuesta($idEncuProceso){

        $respuesta = ControladorEncuestas::ctrListaSegmentosProcesoEncuesta($idEncuProceso);

        echo json_encode($respuesta);

    }

    public function listaSegmentosProcesoEncuestaPorcentaje($idEncuProceso){

        $respuesta = ControladorEncuestas::ctrListaSegmentosProcesoEncuestaPorcentaje($idEncuProceso);

        echo json_encode($respuesta);

    }

    public function listaPreguntasSegmentosEncuesta($idEncuSegmento){

        $respuesta = ControladorEncuestas::ctrListaPreguntasSegmentosEncuesta($idEncuSegmento);

        echo json_encode($respuesta);

    }

    public function listaProcesosEncuesta($tipoEncuesta){

        $resultado = ControladorEncuestas::ctrObtenerProcesosEncuesta($tipoEncuesta);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Proceso Encuesta</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["id_encu_proceso"].'">'.$value["proceso"].'</option>';

        }

        echo $cadena;


    }

    public function listaPreguntasEncuestaProceso($idEncuProceso){

        $respuesta = ControladorEncuestas::ctrListaPreguntasEncuestaProceso($idEncuProceso);

        echo json_encode($respuesta);

    }

    public function guardarRespuestasEncuesta($arrayRespuestas, $idEncuProceso, $idEncuesta, $calificacionProceso){

        $respuesta = ControladorEncuestas::ctrGuardarRespuestasEncuesta($arrayRespuestas, $idEncuProceso, $idEncuesta, $calificacionProceso);

        echo $respuesta;

    }

    public function terminarEncuesta($idEncuesta){

        $respuesta = ControladorEncuestas::ctrTerminarEncuesta($idEncuesta);

        echo $respuesta;

    }

    public function mostrarInfoEncuesta($idEncuesta){

        $respuesta = ControladorEncuestas::ctrMostrarInformacionEncuesta($idEncuesta);

        echo json_encode($respuesta);

    }

    public function descartarEncuesta($idEncuesta){

        $respuesta = ControladorEncuestas::ctrDescartarEncuesta($idEncuesta);

        echo json_encode($respuesta);

    }

    public function obtenerProcesosGestionEncuesta($idEncuesta){

        $respuesta = ControladorEncuestas::ctrObtenerProcesosGestionEncuesta($idEncuesta);

        echo json_encode($respuesta);

    }

    public function selectProcesos($idEncuesta, $tipoEncuesta){
    
        $procesos = ControladorEncuestas::ctrObtenerProcesosEncuestaNoIniciales($tipoEncuesta);

        $procesosEncuesta = ControladorEncuestas::ctrObterProcesosEncuestaArray($idEncuesta);

        $cadena = '';

        $cadena = '<option value="">Seleccione el Profesional a Aplicar</option>';

        foreach ($procesos as $key => $valueProceso) {

            if(!in_array($valueProceso["id_encu_proceso"], $procesosEncuesta)){

                $cadena .= '<option value="'.$valueProceso["proceso"].'" idEncuProceso="'.$valueProceso["id_encu_proceso"].'">'.$valueProceso["proceso"].'</option>';

            }

        }

        echo $cadena;

    }

    public function agregarProfesional(){

        $datos = $this->datos;

        $respuesta = ControladorEncuestas::ctrAgregarProfesional($datos);

        echo json_encode($respuesta);

    }

    public function listaProcesosGestionEncuesta($idEncuesta){

        $respuesta = ControladorEncuestas::ctrListaProcesosGestionEncuesta($idEncuesta);

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

    public function eliminarProfesional($idEncuProcesoGestion, $idEncuProceso, $idEncuesta){

        $respuesta = ControladorEncuestas::ctrEliminarProfesional($idEncuProcesoGestion, $idEncuProceso, $idEncuesta);

        echo $respuesta;

    }

    public function eliminarProfesionalModificacion($idEncuProcesoGestion, $idEncuProceso, $idEncuesta){

        $respuesta = ControladorEncuestas::ctrEliminarProfesionalModificacion($idEncuProcesoGestion, $idEncuProceso, $idEncuesta);

        echo $respuesta;

    }

    public function validacionTerminarEncuesta($idEncuesta){

        $respuesta = ControladorEncuestas::ctrValidacionTerminarEncuesta($idEncuesta);

        echo $respuesta;

    }

    public function obtenerCalificacionesEncuesta($idEncuesta){

        $respuesta = ControladorEncuestas::ctrObtenerCalificacionesEncuesta($idEncuesta);

        echo json_encode($respuesta);

    }

    public function guardarCalificacionSegmento($datos){

        $respuesta = ControladorEncuestas::ctrGuardarCalificacionSegmento($datos);

        echo $respuesta;

        // var_dump($respuesta);

    }

    public function listaSegmentosParaclinicos($tipoEncuesta){

        $respuesta = ControladorEncuestas::ctrListaSegmentosParaclinicos($tipoEncuesta);

        echo json_encode($respuesta);

    }

    public function listaProcesosEncuestaNoIniciales($tipoEncuesta){

        $resultado = ControladorEncuestas::ctrObtenerProcesosEncuestaNoIniciales($tipoEncuesta);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione Proceso Encuesta</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["id_encu_proceso"].'">'.$value["proceso"].'</option>';

        }

        echo $cadena;

    }

    public function agregarUsuarioProfesional(){

        $datos = $this->datos;

        $respuesta = ControladorEncuestas::ctrAgregarUsuarioProfesional($datos);

        echo $respuesta;

    }

    public function listaUsuariosProfesionales(){

        $respuesta = ControladorEncuestas::ctrListaUsuariosProfesionales();

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

    public function eliminarUsuarioProfesional($idProUsu, $userDelete){

        $respuesta = ControladorEncuestas::ctrEliminarUsuarioProfesional($idProUsu, $userDelete);

        echo $respuesta;

    }

    public function selectAuditoresProceso($procesoProfesional, $tipoEncuesta){

        $resultado = ControladorEncuestas::ctrSelectAuditoresProceso($procesoProfesional, $tipoEncuesta);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Auditor Proceso</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["nombre_profesional"].'">'.$value["nombre_profesional"].'</option>';

        }

        echo $cadena;


    }


    public function listaAuditoresEncuesta($tipoEncuesta, $user){

        $resultado = ControladorEncuestas::ctrListaAuditoresEncuesta($tipoEncuesta);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione un Profesional</option>';

        foreach ($resultado as $key => $value) {

            if($value["usuario"] == $user){

                $cadena .= '<option value="'.$value["usuario"].'" selected>'.$value["nombre"].'</option>';
                
            }else{
                
                $cadena .= '<option value="'.$value["usuario"].'">'.$value["nombre"].'</option>';

            }

        }

        echo $cadena;

    }

    public function infoAuditoriaEncuesta($idEncuesta){

        $respuesta = ControladorEncuestas::ctrMostrarInformacionEncuesta($idEncuesta);

        echo json_encode($respuesta);        

    }
    
    public function guardarInfoAuditoriaEncuesta(){

        $datos = $this->datos;

        $respuesta = ControladorEncuestas::ctrGuardarInfoAuditoriaEncuesta($datos);

        echo $respuesta;

    }

    public function listaEncuestasBolsaTerminadas($tipoEncuesta, $user){

        $respuesta = ControladorEncuestas::ctrListaEncuestasBolsaTerminadas($tipoEncuesta, $user);

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        // var_dump($data);

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }

    public static function listaPreguntasSegmentosEncuestaRespuesta($idEncuesta, $idEncuSegmento){

        $respuesta = ControladorEncuestas::ctrListaPreguntasSegmentosEncuestaRespuesta($idEncuesta, $idEncuSegmento);

        echo json_encode($respuesta);

    }

    public function eliminarCalificacionesSegmentosRespuestas($idEncuesta, $idEncuProceso){

        $respuesta = ControladorEncuestas::ctrEliminarCalificacionesSegmentosRespuestas($idEncuesta, $idEncuProceso);

        echo json_encode($respuesta);

    }

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'eliminarCalificacionesSegmentosRespuestas':
            $eliminarCalificacionesSegmentosRespuestas = new EncuestasAjax();
            $eliminarCalificacionesSegmentosRespuestas->eliminarCalificacionesSegmentosRespuestas($_POST["idEncuesta"], $_POST["idEncuProceso"]);
            break;

        case 'listaPreguntasSegmentosEncuestaRespuesta':
            $listaPreguntasSegmentosEncuestaRespuesta = new EncuestasAjax();
            $listaPreguntasSegmentosEncuestaRespuesta->listaPreguntasSegmentosEncuestaRespuesta($_POST["idEncuesta"], $_POST["idEncuSegmento"]);
            break;

        case 'listaEncuestasBolsaTerminadas':
            $listaEncuestasBolsaTerminadas = new EncuestasAjax();
            $listaEncuestasBolsaTerminadas->listaEncuestasBolsaTerminadas($_POST["tipoEncuesta"], $_POST["user"]);
            break;

        case 'guardarInfoAuditoriaEncuesta':
            $guardarInfoAuditoriaEncuesta = new EncuestasAjax();
            $guardarInfoAuditoriaEncuesta->datos = array(
                "id_encuesta" => $_POST["idEncuesta"],
                "nombre_paciente" => strtoupper($_POST["nombrePaciente"]),
                "edad" => $_POST["edadPaciente"],
                "sexo" => strtoupper($_POST["sexoPaciente"]),
                "modalidad_consulta" => strtoupper($_POST["modalidadConsultaPaciente"]),
                "usuario_edita" => $_POST["usuarioEdit"]
            );
            $guardarInfoAuditoriaEncuesta->guardarInfoAuditoriaEncuesta();
            break;

        case 'obtenerInfoAuditoriaEncuesta':
            $infoAuditoriaEncu = new EncuestasAjax();
            $infoAuditoriaEncu->infoAuditoriaEncuesta($_POST["idEncuesta"]);
            break;

        case 'listaAuditoresEncuesta':
            $listaAuditoresEncuesta = new EncuestasAjax();
            $listaAuditoresEncuesta->listaAuditoresEncuesta($_POST["tipoEncuesta"], $_POST["userSession"]);
            break;

        case 'selectAuditoresProceso':
            $selectAuditoresProceso = new EncuestasAjax();
            $selectAuditoresProceso->selectAuditoresProceso($_POST["procesoProfesional"], $_POST["tipoEncuesta"]);
            break;

        case 'eliminarUsuarioProfesional':
            $eliminarUsuarioProfesional = new EncuestasAjax();
            $eliminarUsuarioProfesional->eliminarUsuarioProfesional($_POST["idProUsu"], $_POST["userDelete"]);
            break;

        case 'listaUsuariosProfesionales':
            $listaUsuariosProfesionales = new EncuestasAjax();
            $listaUsuariosProfesionales->listaUsuariosProfesionales();
            break;

        case 'agregarUsuarioProfesional':
            $agregarUsuarioProfesional = new EncuestasAjax();
            $agregarUsuarioProfesional->datos = array(
                "tipo_encuesta" => $_POST["tipoEncuesta"],
                "id_encu_proceso" => $_POST["procesoEncuesta"],
                "nombre_profesional" => strtoupper($_POST["nombreProfesional"]),
                "tipo_doc_profesional" => $_POST["tipoDocumento"],
                "documento_profesional" => $_POST["numeroDocumento"],
                "usuario_crea" => $_POST["userCreate"],
            );
            $agregarUsuarioProfesional->agregarUsuarioProfesional();
            break;

        case 'listaProcesosEncuestaNoIniciales':
            $listaProcesosEncuestaNoIniciales = new EncuestasAjax();
            $listaProcesosEncuestaNoIniciales->listaProcesosEncuestaNoIniciales($_POST["tipoEncuesta"]);
            break;

        case 'listaSegmentosParaclinicos':
            $listaSegmentosParaclinicos = new EncuestasAjax();
            $listaSegmentosParaclinicos->listaSegmentosParaclinicos($_POST["tipoEncuesta"]);
            break;

        case 'guardarCalificacionSegmento':
            $guardarCalificacionSegmento = new EncuestasAjax();
            $guardarCalificacionSegmento->guardarCalificacionSegmento($_POST["datos"]);
            break;

        case 'obtenerCalificacionesEncuesta':
            $obtenerCalificacionesEncuesta = new EncuestasAjax();
            $obtenerCalificacionesEncuesta->obtenerCalificacionesEncuesta($_POST["idEncuesta"]);
            break;

        case 'validacionTerminarEncuesta':
            $validacionTerminarEncuesta = new EncuestasAjax();
            $validacionTerminarEncuesta->validacionTerminarEncuesta($_POST["idEncuesta"]);
            break;

        case 'eliminarProfesionalModificacion':
            $eliminarProfesionalModificacion = new EncuestasAjax();
            $eliminarProfesionalModificacion->eliminarProfesionalModificacion($_POST["idEncuProcesoGestion"], $_POST["idEncuProceso"], $_POST["idEncuesta"]);
            break;

        case 'eliminarProfesional':
            $eliminarProfesional = new EncuestasAjax();
            $eliminarProfesional->eliminarProfesional($_POST["idEncuProcesoGestion"], $_POST["idEncuProceso"], $_POST["idEncuesta"]);
            break;

        case 'listaProcesosGestionEncuesta':
            $listaProcesosGestionEncuesta = new EncuestasAjax();
            $listaProcesosGestionEncuesta->listaProcesosGestionEncuesta($_POST["idEncuesta"]);
            break;

        case 'agregarProfesional':
            $agregarProfesional = new EncuestasAjax();
            $agregarProfesional->datos = array(
                "proceso" => $_POST["procesoEncuesta"],
                "id_encu_proceso" => $_POST["idEncuProceso"],
                "id_encuesta" => $_POST["idEncuesta"],
                "usuario_crea" => $_POST["userSession"],
                "nombre_usuario" => $_POST["auditorProceso"]
            );
            $agregarProfesional->agregarProfesional();
            break;

        case 'selectProcesos':
            $selectProcesos = new EncuestasAjax();
            $selectProcesos->selectProcesos($_POST["idEncuesta"], $_POST["tipoEncuesta"]);
            break;

        case 'obtenerProcesosGestionEncuesta':
            $obtenerProcesosGestionEncuesta = new EncuestasAjax();
            $obtenerProcesosGestionEncuesta->obtenerProcesosGestionEncuesta($_POST["idEncuesta"]);
            break;

        case 'descartarEncuesta':
            $descartarEncuesta = new EncuestasAjax();
            $descartarEncuesta->descartarEncuesta($_POST["idEncuesta"]);
            break;

        case 'mostrarInfoEncuesta':
            $mostrarInfoEncuesta = new EncuestasAjax();
            $mostrarInfoEncuesta->mostrarInfoEncuesta($_POST["idEncuesta"]);
            break;

        case 'terminarEncuesta':
            $terminarEncuesta = new EncuestasAjax();
            $terminarEncuesta->terminarEncuesta($_POST["idEncuesta"]);
            break;

        case 'guardarRespuestasEncuesta':
            $guardarRespuestasEncuesta = new EncuestasAjax();
            $guardarRespuestasEncuesta->guardarRespuestasEncuesta($_POST["arrayRespuestas"], $_POST["idEncuProceso"], $_POST["idEncuesta"], $_POST["calificacionProceso"]);
            break;

        case 'listaPreguntasEncuestaProceso':
            $listaPreguntasEncuestaProceso = new EncuestasAjax();
            $listaPreguntasEncuestaProceso->listaPreguntasEncuestaProceso($_POST["idEncuProceso"]);
            break;

        case 'listaProcesosEncuesta':
            $listaProcesosEncuesta = new EncuestasAjax();
            $listaProcesosEncuesta->listaProcesosEncuesta($_POST["tipoEncuesta"]);
            break;

        case 'listaPreguntasSegmentosEncuesta':
            $listaPreguntasSegmentosEncuesta = new EncuestasAjax();
            $listaPreguntasSegmentosEncuesta->listaPreguntasSegmentosEncuesta($_POST["idEncuSegmento"]);
            break;

        case 'listaSegmentosProcesoEncuesta':
            $listaSegmentosProcesoEncuesta = new EncuestasAjax();
            $listaSegmentosProcesoEncuesta->listaSegmentosProcesoEncuesta($_POST["idEncuProceso"]);
            break;

        case 'listaSegmentosProcesoEncuestaPorcentaje':
            $listaSegmentosProcesoEncuestaPorcentaje = new EncuestasAjax();
            $listaSegmentosProcesoEncuestaPorcentaje->listaSegmentosProcesoEncuestaPorcentaje($_POST["idEncuProceso"]);
            break;

        case 'obtenerProcesosInicialesEncuesta':
            $obtenerProcesosInicialesEncuesta = new EncuestasAjax();
            $obtenerProcesosInicialesEncuesta->obtenerProcesosInicialesEncuesta($_POST["tipoEncuesta"]);
            break;

        case 'listaEncuestasPendientesUser':
            $listaEncuestasPendientesUser = new EncuestasAjax();
            $listaEncuestasPendientesUser->listaEncuestasPendientesUser($_POST["tipoEncuesta"], $_POST["user"]);
            break;

        case 'tomarEncuesta':
            $tomarEncuesta = new EncuestasAjax();
            $tomarEncuesta->tomarEncuesta($_POST["idEncuesta"], $_POST["auditor"], $_POST["idBaseEncuesta"], $_POST["tipoEncuesta"], $_POST["nombreUser"]);
            break;

        case 'listaEncuestasBolsa':
            $listaEncuestasBolsa = new EncuestasAjax();
            $listaEncuestasBolsa->listaEncuestasBolsa($_POST["tipoEncuesta"], $_POST["user"]);
            break;

        case 'basesCargadasEncuestas':
            $basesCargadasEncuestas = new EncuestasAjax();
            $basesCargadasEncuestas->basesCargadasEncuestas();
            break;

        case 'cargarArchivoEncuestas':
            $cargarArchivoEncuestas = new EncuestasAjax();
            $cargarArchivoEncuestas->datos = array(
                "nombre_archivo" => $_POST["nombreArchivo"],
                "tipo_encuestas" => $_POST["tipoEncuestas"],
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
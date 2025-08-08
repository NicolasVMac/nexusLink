<?php

require_once "../../controllers/pqr/pqr.controller.php";
require_once "../../models/pqr/pqr.model.php";

class PqrAjax{

    public $datos;

    public function listaGestoresPqr($tipo){

        $resultado = ControladorPqr::ctrUsuariosPqrs($tipo);

        $cadena = '';
        
        $cadena .= '<option value="">Seleccione el Gestor</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["usuario"].'">'.$value["nombre"] . " - " .$value["usuario"].'</option>';

        }

        echo $cadena;

    }

    public function crearPQRS(){

        $datos = $this->datos;

        $respuesta = ControladorPqr::ctrCrearPQRS($datos);

        echo $respuesta;

    }

    public function listaAsignacionesPQRS($usuario){

        $respuesta = ControladorPqr::ctrListaAsignacionesPQRS($usuario);

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

    public function infoPQR($idPQR){

        $respuesta = ControladorPqr::ctrInfoPQR($idPQR);

        echo json_encode($respuesta);

    }

    public function gestionarPQRS($idPQR){

        $respuesta = ControladorPqr::ctrGestionarPQRS($idPQR);

        echo $respuesta;

    }

    public function listaPendientesPQRS($usuario){

        $respuesta = ControladorPqr::ctrListaPendientesPQRS($usuario);

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

    public function crearPlanAccionPQRS(){

        $datos = $this->datos;

        $respuesta = ControladorPqr::ctrCrearPlanAccionPQRS($datos);

        echo $respuesta;

    }

    public function listaRevisionesPQRS(){

        $respuesta = ControladorPqr::ctrListaRevisionesPQRS();

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

    public function revisarPQRS($idPQR, $usuario){

        $respuesta = ControladorPqr::ctrRevisarPQRS($idPQR, $usuario);

        echo $respuesta;

    }

    public function listaPendientesRevisionPQRS($usuario){

        $respuesta = ControladorPqr::ctrListaPendientesRevisionPQRS($usuario);

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

    public function terminarRevisionPQRS(){

        $datos = $this->datos;

        $respuesta = ControladorPqr::ctrTerminarRevisionPQRS($datos);

        echo $respuesta;

    }

    public function listaPQRS(){

        $respuesta = ControladorPqr::ctrListaPQRS();

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

    public function listaUsuariosPQRS(){

        $respuesta = ControladorPqr::ctrListaUsuariosPQRS();

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

    public function rechazarPQRS($idPQR){

        $respuesta = ControladorPqr::ctrRechazarPQRS($idPQR);

        echo $respuesta;

    }

    public function asignarPQRS($idPQR, $gestor){

        $respuesta = ControladorPqr::ctrAsignarPQRS($idPQR, $gestor);

        echo $respuesta;

    }

    public function listaRecursosRevisionPqr($opciones){

        $tabla = "pqr_par_recursos";
        $item = null;
        $valor = null;

        $resultado = ControladorPqr::ctrObtenerDatosActivos($tabla, $item, $valor);

        $arrayOpciones = explode('-', $opciones);

        $cadena = '';
        
        foreach ($resultado as $key => $value) {

            if(in_array($value["recurso"], $arrayOpciones)){

                $cadena .= '<option value="'.$value["recurso"].'" selected>'.$value["recurso"].'</option>';
                
            }else{
                
                $cadena .= '<option value="'.$value["recurso"].'">'.$value["recurso"].'</option>';

            }


        }

        echo $cadena;
        
    }

    public function listaQuienRevisionPqr($opciones){

        $tabla = "pqr_par_quien";
        $item = null;
        $valor = null;

        $resultado = ControladorPqr::ctrObtenerDatosActivos($tabla, $item, $valor);

        $arrayOpciones = explode('-', $opciones);

        $cadena = '';
        
        foreach ($resultado as $key => $value) {

            if(in_array($value["quien"], $arrayOpciones)){

                $cadena .= '<option value="'.$value["quien"].'" selected>'.$value["quien"].'</option>';
                
            }else{
                
                $cadena .= '<option value="'.$value["quien"].'">'.$value["quien"].'</option>';

            }


        }

        echo $cadena;

    }

    public function crearActa(){

        $datos = $this->datos;

        $respuesta = ControladorPqr::ctrCrearActa($datos);

        echo $respuesta;

    }

    public function listaBuzonPQRSF(){

        $respuesta = ControladorPqr::ctrListaBuzonPQRSF();

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

    public function tomarBuzonPQRSF($idPQR, $user){

        $respuesta = ControladorPqr::ctrTomarBuzonPQRSF($idPQR, $user);

        echo $respuesta;

    }

    public function infoBuzonPQR($idPQR){

        $respuesta = ControladorPqr::ctrInfoBuzonPQRSF($idPQR);

        echo json_encode($respuesta);

    }

    public function listaBuzonPendientesPQRSF($user){

        $respuesta = ControladorPqr::ctrListaBuzonPendientesPQRSF($user);

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

    public function crearBuzonPQRS(){

        $datos = $this->datos;

        $respuesta = ControladorPqr::ctrCrearBuzonPQRS($datos);

        echo $respuesta;

    }

    public function actualizarPQRS(){

        $datos = $this->datos;

        $respuesta = ControladorPqr::ctrActualizarPQRSF($datos);

        echo $respuesta;

    }

    public function listaCargarResPQRSF(){

        $respuesta = ControladorPqr::ctrListaCargarResPQRSF();

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
    

    public function guardarResPQRSF(){

        $datos = $this->datos;
        
        $respuesta = ControladorPqr::ctrGuardarResPQRSF($datos);

        echo $respuesta;

    }

    public function listaTrabajadoresPQRSF(){

        $respuesta = ControladorPqr::ctrListaTrabajadoresPQRSF();

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

    public function agregarTrabajadorPQRSF(){

        $datos = $this->datos;

        $respuesta = ControladorPqr::ctrAgregarTrabajadorPQRSF($datos);

        echo $respuesta;

    }


    public function eliminarTrabajadorPQRSF($idTrabajador, $user){

        $respuesta = ControladorPqr::ctrEliminarTrabajadorPQRSF($idTrabajador, $user);

        echo $respuesta;

    }

    public function listaPQRSGestionadosGestor($user){

        $respuesta = ControladorPqr::ctrListaPQRSGestionadosGestor($user);

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

    public function eliminararchivoPQRSF(){

        $datos = $this->datos;

        $respuesta = ControladorPqr::ctrEliminarArchivoPQRSF($datos);

        echo $respuesta;

    }

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'eliminararchivoPQRSF':
            $eliminararchivoPQRSF = new PqrAjax();
            $eliminararchivoPQRSF->datos = array(
                "ruta_archivo" => $_POST["rutaArchivo"],
                "id_pqr" => $_POST["idPQRSF"],
                "usuario_elimina" => $_POST["user"]
            );
            $eliminararchivoPQRSF->eliminararchivoPQRSF();
            break;

        case 'listaPQRSGestionadosGestor':
            $listaPQRSGestionadosGestor = new PqrAjax();
            $listaPQRSGestionadosGestor->listaPQRSGestionadosGestor($_POST["user"]);
            break;

        case 'eliminarTrabajadorPQRSF':
            $eliminarTrabajadorPQRSF = new PqrAjax();
            $eliminarTrabajadorPQRSF->eliminarTrabajadorPQRSF($_POST["idTrabajadorPQRSF"], $_POST["user"]);
            break;

        case 'agregarTrabajadorPQRSF':
            $agregarTrabajadorPQRSF = new PqrAjax();
            $agregarTrabajadorPQRSF->datos = array(
                "tipo_doc_trabajador" => $_POST["tipoDocumentoTrabajador"],
                "numero_doc_trabajador" => $_POST["documentoTrabajador"],
                "nombre_trabajador" => mb_strtoupper($_POST["nombreTrabajador"]),
                "usuario_crea" => $_POST["user"]
            );
            $agregarTrabajadorPQRSF->agregarTrabajadorPQRSF();
            break;

        case 'listaTrabajadoresPQRSF':
            $listaTrabajadoresPQRSF = new PqrAjax();
            $listaTrabajadoresPQRSF->listaTrabajadoresPQRSF();
            break;

        case 'guardarResPQRSF':
            $guardarResPQRSF = new PqrAjax();
            if(isset($_FILES["archivoResPQRSF"])){$archivoResPQRSF = $_FILES["archivoResPQRSF"];}else{$archivoResPQRSF = 'VACIO';}
            $guardarResPQRSF->datos = array(
                "id_pqr" => $_POST["idPQRSF"],
                "archivosResPqr" => $archivoResPQRSF,
                "fecha_respuesta_pqr" => $_POST["fechaRespPQRSF"],
                "usuario_archivo_res" => $_POST["user"],
            );
            $guardarResPQRSF->guardarResPQRSF();
            break;

        case 'listaCargarResPQRSF':
            $listaCargarResPQRSF = new PqrAjax();
            $listaCargarResPQRSF->listaCargarResPQRSF();
            break;

        case 'actualizarPQRS':
            $actualizarPQRS = new PqrAjax();
            $actualizarPQRS->datos = array(
                "id_pqr" => $_POST["idPQRS"],
                "nombre_pac" => mb_strtoupper($_POST["nombrePaciente"]),
                "tipo_identificacion_pac" => $_POST["tipoDocPaciente"],
                "numero_identificacion_pac" => $_POST["numIdentificacionPaciente"],
                "fecha_nacimiento_pac" => $_POST["fechaNacimientoPaciente"],
                "eps" => $_POST["epsPqr"],
                "regimen" => $_POST["regimenEps"],
                "programa" => $_POST["programaPqr"],
                "sede" => $_POST["sedePqr"],
                "nombre_pet" => mb_strtoupper($_POST["nombrePeticionario"]),
                "tipo_identificacion_pet" => $_POST["tipoDocPeticionario"],
                "numero_identificacion_pet" => $_POST["numIdentificacionPeticionario"],
                "contacto_pet" => $_POST["telefonoPeticionario"],
                "correo_pet" => $_POST["correoPeticionario"],
                "fecha_pqr" => $_POST["fechaPQRSF"],
                "departamento" => $_POST["departamentoPeticionario"],
                "municipio" => $_POST["municipioPeticionario"],
                "descripcion_pqr" => $_POST["descripcionPqr"],
                "medio_recep_pqr" => $_POST["medioRecepcionPqr"],
                "fecha_apertura_buzon_suge" => $_POST["fechaAperturaBuzonSugerencias"],
                "tipo_pqr" => $_POST["tipoPqr"],
                "ente_reporta_pqr" => $_POST["enteReportePqr"],
                "motivo_pqr" => $_POST["motivoPqr"],
                "trabajador_relacionado_pqr" => $_POST["trabajadorRelaPqr"],
                "servicio_area" => $_POST["servcioAreaPqr"],
                "clasificacion_atributo" => $_POST["clasificacionAtributoPqr"],
                "usuario_mofica" => $_POST["userModifica"]
            );
            $actualizarPQRS->actualizarPQRS();
            break;

        case 'crearBuzonPQRS':
            $crearBuzonPQRS = new PqrAjax();
            if(isset($_FILES["archivosPqr"])){$archivosPqr = $_FILES["archivosPqr"];}else{$archivosPqr = 'VACIO';}
            $crearBuzonPQRS->datos = array(
                "id_pqr" => $_POST["idPQRSF"],
                "nombre_pac" => mb_strtoupper($_POST["nombrePaciente"]),
                "tipo_identificacion_pac" => $_POST["tipoDocPaciente"],
                "numero_identificacion_pac" => $_POST["numIdentificacionPaciente"],
                "fecha_nacimiento_pac" => $_POST["fechaNacimientoPaciente"],
                "eps" => $_POST["epsPqr"],
                "regimen" => $_POST["regimenEps"],
                "programa" => $_POST["programaPqr"],
                "sede" => $_POST["sedePqr"],
                "nombre_pet" => mb_strtoupper($_POST["nombrePeticionario"]),
                "tipo_identificacion_pet" => $_POST["tipoDocPeticionario"],
                "numero_identificacion_pet" => $_POST["numIdentificacionPeticionario"],
                "contacto_pet" => $_POST["telefonoPeticionario"],
                "correo_pet" => $_POST["correoPeticionario"],
                "fecha_pqr" => $_POST["fechaPQRSF"],
                "departamento" => $_POST["departamentoPeticionario"],
                "municipio" => $_POST["municipioPeticionario"],
                "descripcion_pqr" => $_POST["descripcionPqr"],
                "medio_recep_pqr" => $_POST["medioRecepcionPqr"],
                "fecha_apertura_buzon_suge" => $_POST["fechaAperturaBuzonSugerencias"],
                // "fecha_radicacion_pqr" => $_POST["fechaHoraRadicacionPqr"],
                "tipo_pqr" => $_POST["tipoPqr"],
                "ente_reporta_pqr" => mb_strtoupper($_POST["enteReportePqr"]),
                "motivo_pqr" => $_POST["motivoPqr"],
                "trabajador_relacionado_pqr" => mb_strtoupper($_POST["trabajadorRelaPqr"]),
                "servicio_area" => $_POST["servcioAreaPqr"],
                "clasificacion_atributo" => $_POST["clasificacionAtributoPqr"],
                "gestor" => $_POST["gestoresPqr"],
                "usuario_crea" => $_POST["userCreate"],
                "archivosPqr" => $archivosPqr
            );
            $crearBuzonPQRS->crearBuzonPQRS();
            break;

        case 'listaBuzonPendientesPQRSF':
            $listaBuzonPendientesPQRSF = new PqrAjax();
            $listaBuzonPendientesPQRSF->listaBuzonPendientesPQRSF($_POST["user"]);
            break;

        case 'infoBuzonPQR':
            $infoBuzonPQR = new PqrAjax();
            $infoBuzonPQR->infoBuzonPQR($_POST["idPQR"]);
            break;

        case 'tomarBuzonPQRSF':
            $tomarBuzonPQRSF = new PqrAjax();
            $tomarBuzonPQRSF->tomarBuzonPQRSF($_POST["idPQR"], $_POST["userSession"]);
            break;

        case 'listaBuzonPQRSF':
            $listaBuzonPQRSF = new PqrAjax();
            $listaBuzonPQRSF->listaBuzonPQRSF();
            break;

        case 'crearActa':
            $crearActa = new PqrAjax();
            if(isset($_FILES["archivosActa"])){$archivosActa = $_FILES["archivosActa"];}else{$archivosActa = 'VACIO';}
            $crearActa->datos = array(
                "radicado_acta" => mb_strtoupper($_POST["radicadoActa"]),
                "cantidad_pqr" => $_POST["cantidadPQR"],
                "fecha_acta" => $_POST["fechaActaPQR"],
                "fecha_apertura_buzon" => $_POST["fechaAperturaBuzonPQR"],
                "usuario_crea" => $_POST["userCreate"],
                "archivosActas" => $archivosActa,
            );
            $crearActa->crearActa();
            break;

        case 'listaQuienRevisionPqr':
            $listaQuienRevisionPqr = new PqrAjax();
            $listaQuienRevisionPqr->listaQuienRevisionPqr($_POST["opciones"]);
            break;

        case 'listaRecursosRevisionPqr':
            $listaRecursosRevisionPqr = new PqrAjax();
            $listaRecursosRevisionPqr->listaRecursosRevisionPqr($_POST["opciones"]);
            break;

        case 'asignarPQRS':
            $asignarPQRS = new PqrAjax();
            $asignarPQRS->asignarPQRS($_POST["idPQRSAsignar"], $_POST["gestoresPqrAsignar"]);
            break;

        case 'rechazarPQRS':
            $rechazarPQRS = new PqrAjax();
            $rechazarPQRS->rechazarPQRS($_POST["idPQR"]);
            break;

        case 'listaUsuariosPQRS':
            $listaUsuariosPQRS = new PqrAjax();
            $listaUsuariosPQRS->listaUsuariosPQRS();
            break;

        case 'listaPQRS':
            $listaPQRS = new PqrAjax();
            $listaPQRS->listaPQRS();
            break;

        case 'terminarRevisionPQRS':
            $terminarRevisionPQRS = new PqrAjax();
            if(isset($_FILES["archivosPqr"])){$archivosPqr = $_FILES["archivosPqr"];}else{$archivosPqr = 'VACIO';}
            $terminarRevisionPQRS->datos = array(
                "id_pqr" => $_POST["idPQRS"],
                "pla_ac_que" => mb_strtoupper($_POST["planAccionQue"]),
                "pla_ac_por_que" => mb_strtoupper($_POST["planAccionPorQue"]),
                "pla_ac_cuando" => $_POST["planAccionCuando"],
                "pla_ac_donde" => mb_strtoupper($_POST["planAccionDonde"]),
                "pla_ac_como" => mb_strtoupper($_POST["planAccionComo"]),
                "pla_ac_quien" => $_POST["respQuien"],
                "pla_ac_recurso" => $_POST["respRecursos"],
                "pla_ac_negacion_pqr" => $_POST["planAccionNegacion"],
                "pla_ac_motivo_negacion" => mb_strtoupper($_POST["planAccionMotivoResponsableNega"]),
                // "pla_ac_pqr_recurrente" => $_POST["planAccionPqrRecurrente"],
                // "pla_ac_accion_efectiva" => $_POST["planAccionEfectiva"],
                "pla_ac_respuesta" => $_POST["respuestaPQRSF"],
                "observaciones_gestor" => mb_strtoupper($_POST["gestorObservaciones"]),
                "observaciones_revision" => mb_strtoupper($_POST["revisionObservaciones"]),
                "archivosPqr" => $archivosPqr,
                "rutaArchivosPqr" => $_POST["txtRutaArchivosPQRSF"]
            );
            $terminarRevisionPQRS->terminarRevisionPQRS();
            break;

        case 'listaPendientesRevisionPQRS':
            $listaPendientesRevisionPQRS = new PqrAjax();
            $listaPendientesRevisionPQRS->listaPendientesRevisionPQRS($_POST["user"]);
            break;

        case 'revisarPQRS':
            $revisarPQRS = new PqrAjax();
            $revisarPQRS->revisarPQRS($_POST["idPQR"], $_POST["user"]);
            break;

        case 'listaRevisionesPQRS':
            $listaRevisionesPQRS = new PqrAjax();
            $listaRevisionesPQRS->listaRevisionesPQRS();
            break;

        case 'crearPlanAccionPQRS':
            $crearPlanAccionPQRS = new PqrAjax();
            if(isset($_FILES["archivosPqr"])){$archivosPqr = $_FILES["archivosPqr"];}else{$archivosPqr = 'VACIO';}
            $crearPlanAccionPQRS->datos = array(
                "id_pqr" => $_POST["idPQRS"],
                "pla_ac_que" => mb_strtoupper($_POST["planAccionQue"]),
                "pla_ac_por_que" => mb_strtoupper($_POST["planAccionPorQue"]),
                "pla_ac_cuando" => $_POST["planAccionCuando"],
                "pla_ac_donde" => mb_strtoupper($_POST["planAccionDonde"]),
                "pla_ac_como" => mb_strtoupper($_POST["planAccionComo"]),
                "pla_ac_quien" => $_POST["respQuien"],
                "pla_ac_recurso" => $_POST["respRecursos"],
                "pla_ac_negacion_pqr" => $_POST["planAccionNegacion"],
                "pla_ac_motivo_negacion" => mb_strtoupper($_POST["planAccionMotivoResponsableNega"]),
                // "pla_ac_pqr_recurrente" => $_POST["planAccionPqrRecurrente"],
                // "pla_ac_accion_efectiva" => $_POST["planAccionEfectiva"],
                "pla_ac_respuesta" => $_POST["respuestaPQRSF"],
                "observaciones_gestor" => mb_strtoupper($_POST["gestorObservaciones"]),
                "usuario_crea_pla_ac" => $_POST["userCreate"],
                "archivosPqr" => $archivosPqr,
                "rutaArchivosPqr" => $_POST["txtRutaArchivosPQRSF"]
            );
            $crearPlanAccionPQRS->crearPlanAccionPQRS();
            break;

        case 'listaPendientesPQRS':
            $listaPendientesPQRS = new PqrAjax();
            $listaPendientesPQRS->listaPendientesPQRS($_POST["user"]);
            break;

        case 'gestionarPQRS':
            $gestionarPQRS = new PqrAjax();
            $gestionarPQRS->gestionarPQRS($_POST["idPQR"]);
            break;

        case 'infoPQR':
            $infoPQR = new PqrAjax();
            $infoPQR->infoPQR($_POST["idPQR"]);
            break;

        case 'listaAsignacionesPQRS':
            $listaAsignacionesPQRS = new PqrAjax();
            $listaAsignacionesPQRS->listaAsignacionesPQRS($_POST["user"]);
            break;

        case 'crearPQRS':
            $crearPQRS = new PqrAjax();
            if(isset($_FILES["archivosPqr"])){$archivosPqr = $_FILES["archivosPqr"];}else{$archivosPqr = 'VACIO';}
            $crearPQRS->datos = array(
                "nombre_pac" => mb_strtoupper($_POST["nombrePaciente"]),
                "tipo_identificacion_pac" => $_POST["tipoDocPaciente"],
                "numero_identificacion_pac" => $_POST["numIdentificacionPaciente"],
                "fecha_nacimiento_pac" => $_POST["fechaNacimientoPaciente"],
                "eps" => $_POST["epsPqr"],
                "regimen" => $_POST["regimenEps"],
                "programa" => $_POST["programaPqr"],
                "sede" => $_POST["sedePqr"],
                "nombre_pet" => mb_strtoupper($_POST["nombrePeticionario"]),
                "tipo_identificacion_pet" => $_POST["tipoDocPeticionario"],
                "numero_identificacion_pet" => $_POST["numIdentificacionPeticionario"],
                "contacto_pet" => $_POST["telefonoPeticionario"],
                "correo_pet" => $_POST["correoPeticionario"],
                "fecha_pqr" => $_POST["fechaPQRSF"],
                "departamento" => $_POST["departamentoPeticionario"],
                "municipio" => $_POST["municipioPeticionario"],
                "descripcion_pqr" => $_POST["descripcionPqr"],
                "medio_recep_pqr" => $_POST["medioRecepcionPqr"],
                "fecha_apertura_buzon_suge" => $_POST["fechaAperturaBuzonSugerencias"],
                // "fecha_radicacion_pqr" => $_POST["fechaHoraRadicacionPqr"],
                "tipo_pqr" => $_POST["tipoPqr"],
                "ente_reporta_pqr" => mb_strtoupper($_POST["enteReportePqr"]),
                "motivo_pqr" => $_POST["motivoPqr"],
                "trabajador_relacionado_pqr" => mb_strtoupper($_POST["trabajadorRelaPqr"]),
                "servicio_area" => $_POST["servcioAreaPqr"],
                "clasificacion_atributo" => $_POST["clasificacionAtributoPqr"],
                "gestor" => $_POST["gestoresPqr"],
                "usuario_crea" => $_POST["userCreate"],
                "archivosPqr" => $archivosPqr
            );
            $crearPQRS->crearPQRS();
            break;

        case 'listaGestoresPqr':
            $listaGestoresPqr = new PqrAjax();
            $listaGestoresPqr->listaGestoresPqr($_POST["tipo"]);
            break;

    }

}
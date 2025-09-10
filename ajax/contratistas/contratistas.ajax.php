<?php

require_once "../../controllers/contratistas/contratistas.controller.php";
require_once "../../models/contratistas/contratistas.model.php";

class contratistasAjax
{
    public $datos;

    public function listaTipoContratista()
    {

        $tabla = "contratistas_par_tipos_contratistas";
        $resultado = ControladorContratistas::ctrListaTipoContratista($tabla);
        $cadena = '';

        $cadena .= '<option value="">Seleccione el Tipo Contratista</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["tipo"] . '">' . $value["tipo_contra"] . '</option>';
        }

        echo $cadena;
    }

    public function validarExisteContratista($numeroDoc, $tipoDoc)
    {

        $resultado = ControladorContratistas::ctrValidarExisteContratista($numeroDoc, $tipoDoc);

        echo json_encode($resultado);
    }

    public function crearContratista()
    {

        $datos = $this->datos;
        $resultado = ControladorContratistas::ctrCrearContratista($datos);

        echo json_encode($resultado);
    }

    public function listaContratistas()
    {
        $respuesta = ControladorContratistas::ctrListaContratistas();
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

    public function eliminarContratista($idContratista)
    {

        $resultado = ControladorContratistas::ctrEliminarContratista($idContratista);

        echo json_encode($resultado);
    }

    
    public function infoContratista($idContratista){

        $respuesta = ControladorContratistas::ctrInfoContratista($idContratista);

        echo json_encode($respuesta);

    }

    public function crearContrato(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrCrearContrato($datos);

        echo $respuesta;

    }

    public function listaContratosContratista($idContratista){

        $respuesta = ControladorContratistas::ctrListaContratosContratista($idContratista);

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

    public function crearTarifasDefault(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrCrearTarifasDefault($datos);

        echo json_encode($respuesta);

    }

    public function infoContratoContratista($idContratista, $idContrato){

        $respuesta = ControladorContratistas::ctrInfoContratoContratista($idContratista, $idContrato);

        echo json_encode($respuesta);

    }

    public function listaParTarifasPrestador(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrListaParTarifasPrestador($datos);

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

    public function listaProrrogasContrato($idContrato){

        $respuesta = ControladorContratistas::ctrListaProrrogasContrato($idContrato);

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

    public function crearProrroga(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrCrearProrroga($datos);

        echo $respuesta;

    }

    public function aplicarProrrogaContrato(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrAplicarProrrogaContrato($datos);

        echo $respuesta;

    }

    public function eliminarProrroga(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrEliminarProrroga($datos);

        echo $respuesta;

    }

    public function crearTarifa(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrCrearTarifa($datos);

        echo $respuesta;

    }

    public function infoTarifario($idTarifario){

        $respuesta = ControladorContratistas::ctrInfoTarifario($idTarifario);

        echo json_encode($respuesta);

    }

    public function crearTarifaUnitaria(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrCrearTarifaUnitaria($datos);

        echo $respuesta;

    }

    public function listaTarifasTarifario($idTarifario){

        $respuesta = ControladorContratistas::ctrListaTarifasTarifario($idTarifario);

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

    public function eliminarTarifaUnitaria(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrEliminarTarifaUnitaria($datos);

        echo $respuesta;

    }

    public function cargarArchivoTarifasMasivo(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrCargarArchivoTarifasMasivo($datos);

        echo $respuesta;

    }

    public function listaArchivosMasivosTarifas($idTarifario){

        $respuesta = ControladorContratistas::ctrListaArchivosMasivosTarifas($idTarifario);

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

    public function agregarOtroDocumento(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrAgregarOtroDocumento($datos);

        echo $respuesta;

    }

    public function listaOtrosDocumentosContrato($idContrato){

        $respuesta = ControladorContratistas::ctrListaOtrosDocumentosContrato($idContrato);

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

    public function eliminarOtroDocumento(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrEliminarOtroDocumento($datos);

        echo $respuesta;

    }

    public function crearPoliza(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrCrearPolizas($datos);

        echo $respuesta;

    }

    public function listaPolizasContrato($idContrato){

        $respuesta = ControladorContratistas::ctrListaPolizasContrato($idContrato);

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

    public function eliminarPoliza(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrEliminarPoliza($datos);

        echo $respuesta;

    }

    public function crearOtroSi(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::ctrCrearOtroSi($datos);

        echo $respuesta;

    }

    public function listaContratosOtroSiContrato($idContrato){

        $respuesta = ControladorContratistas::ctrListaContratosOtroSiContrato($idContrato);

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

    public function eliminarContratoOtroSi(){

        $datos = $this->datos;

        $respuesta = ControladorContratistas::eliminarContratoOtroSi($datos);

        echo $respuesta;

    }

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch ($proceso) {

        case 'eliminarContratoOtroSi':
            $eliminarContratoOtroSi = new contratistasAjax();
            $eliminarContratoOtroSi->datos = array(
                "id_contrato_si" => $_POST["idContratoOtraSi"],
                "usuario_sesion" => $_POST["userCreate"],
            );
            $eliminarContratoOtroSi->eliminarContratoOtroSi();
            break;

        case 'listaContratosOtroSiContrato':
            $listaContratosOtroSiContrato = new contratistasAjax();
            $listaContratosOtroSiContrato->listaContratosOtroSiContrato($_POST["idContrato"]);
            break;

        case 'crearOtroSi':
            $crearOtroSi = new contratistasAjax();
            $crearOtroSi->datos = $_POST;
            $crearOtroSi->crearOtroSi();
            break;

        case 'eliminarPoliza':
            $eliminarPoliza = new contratistasAjax();
            $eliminarPoliza->datos = array(
                "id_poliza" => $_POST["idPoliza"],
                "usuario_sesion" => $_POST["userCreate"],
            );
            $eliminarPoliza->eliminarPoliza();
            break;

        case 'listaPolizasContrato':
            $listaPolizasContrato = new contratistasAjax();
            $listaPolizasContrato->listaPolizasContrato($_POST["idContrato"]);
            break;

        case 'crearPoliza':
            $crearPoliza = new contratistasAjax();
            $crearPoliza->datos = $_POST;
            $crearPoliza->crearPoliza();
            break;

        case 'eliminarOtroDocumento':
            $eliminarOtroDocumento = new contratistasAjax();
            $eliminarOtroDocumento->datos = array(
                "id_otro_documento" => $_POST["idOtroDocumento"],
                "usuario_elimina" => $_POST["userCreate"]
            );
            $eliminarOtroDocumento->eliminarOtroDocumento();
            break;

        case 'listaOtrosDocumentosContrato':
            $listaOtrosDocumentosContrato = new contratistasAjax();
            $listaOtrosDocumentosContrato->listaOtrosDocumentosContrato($_POST["idContrato"]);
            break;

        case 'agregarOtroDocumento':
            $agregarOtroDocumento = new contratistasAjax();
            if(isset($_FILES["oDarchivoDocumento"])){$archivoDocumento = $_FILES["oDarchivoDocumento"];}else{$archivoDocumento = 'VACIO';}
            $agregarOtroDocumento->datos = array(
                "id_contratista" => $_POST["idContratista"],
                "id_contrato" => $_POST["idContrato"],
                "tipo_documento" => $_POST["oDTipoDocumento"],
                "observaciones" => mb_strtoupper($_POST["oDObservaciones"]),
                "usuario_crea" => $_POST["userCreate"],
                "archivoDocumento" => $archivoDocumento,
            );
            $agregarOtroDocumento->agregarOtroDocumento();
            break;

        case 'listaArchivosMasivosTarifas':
            $listaArchivosMasivosTarifas = new contratistasAjax();
            $listaArchivosMasivosTarifas->listaArchivosMasivosTarifas($_POST["idTarifario"]);
            break;

        case 'cargarArchivoTarifasMasivo':
            $cargarArchivoTarifasMasivo = new contratistasAjax();
            if(isset($_FILES["tMArchivoTarifas"])){$archivoDocumento = $_FILES["tMArchivoTarifas"];}else{$archivoDocumento = 'VACIO';}
            $cargarArchivoTarifasMasivo->datos = array(
                "id_tarifario" => $_POST["idTarifario"],
                "nombre_archivo" => mb_strtoupper($_POST["tMNombreArchivo"]),
                "archivoDocumento" => $archivoDocumento,
                "usuario_crea" => $_POST["userCreate"]
            );
            $cargarArchivoTarifasMasivo->cargarArchivoTarifasMasivo();
            break;

        case 'eliminarTarifaUnitaria':
            $eliminarTarifaUnitaria = new contratistasAjax();
            $eliminarTarifaUnitaria->datos = array(
                "id_tarifa" => $_POST["idTarifa"],
                "usuario_elimina" => $_POST["userCreate"],
            );
            $eliminarTarifaUnitaria->eliminarTarifaUnitaria();
            break;

        case 'listaTarifasTarifario':
            $listaTarifasTarifario = new contratistasAjax();
            $listaTarifasTarifario->listaTarifasTarifario($_POST["idTarifario"]);
            break;

        case 'crearTarifaUnitaria':
            $crearTarifaUnitaria = new contratistasAjax();
            $crearTarifaUnitaria->datos = array(
                "id_par_tarifario" => $_POST["idTarifario"],
                "tipo_tarifa" => $_POST["tTipoTarifa"],
                "codigo" => $_POST["tCodigo"],
                "codigo_normalizado" => $_POST["tCodigoNormalizado"],
                "registro_sanitario" => mb_strtoupper($_POST["tRegistroSanitario"]),
                "tarifa_pactada" => $_POST["tTarifaPactada"],
                "tarifa_regulacion" => $_POST["tTarifaRegulacion"],
                "fecha_inicio_vigencia" => $_POST["tFechaInicio"],
                "fecha_fin_vigencia" => $_POST["tFechaFin"],
                "descripcion_tarifa" => mb_strtoupper($_POST["tDescripcionTarifa"]),
                "producto" => mb_strtoupper($_POST["tProductos"]),
                "usuario_crea" => $_POST["userCreate"],
            );
            $crearTarifaUnitaria->crearTarifaUnitaria();
            break;

        case 'infoTarifario':
            $infoTarifario = new contratistasAjax();
            $infoTarifario->infoTarifario($_POST["idTarifario"]);
            break;

        case 'crearTarifa':
            $crearTarifa = new contratistasAjax();
            $crearTarifa->datos = array(
                "nombre_tarifa" => mb_strtoupper($_POST["nombreTarifa"]),
                "id_contratista" => $_POST["idContratista"],
                "id_contrato" => $_POST["idContrato"],
                "usuario_crea" => $_POST["userCreate"],
            );
            $crearTarifa->crearTarifa();
            break;

        case 'eliminarProrroga':
            $eliminarProrroga = new contratistasAjax();
            $eliminarProrroga->datos = array(
                "id_prorroga" => $_POST["idProrroga"],
                "usuario_elimina" => $_POST["userCreate"],
            );
            $eliminarProrroga->eliminarProrroga();
            break;

        case 'aplicarProrrogaContrato':
            $aplicarProrrogaContrato = new contratistasAjax();
            $aplicarProrrogaContrato->datos = array(
                "id_prorroga" => $_POST["idProrroga"],
                "id_contrato" => $_POST["idContrato"],
                "prorroga_meses" => $_POST["prorrogaMeses"],
                "usuario_crea" => $_POST["userCreate"],
            );
            $aplicarProrrogaContrato->aplicarProrrogaContrato();
            break;

        case 'crearProrroga':
            $crearProrroga = new contratistasAjax();
            $crearProrroga->datos = array(
                "id_contrato" => $_POST["idContrato"],
                "prorroga_meses" => $_POST["pMesesProrroga"],
                "observaciones" => mb_strtoupper($_POST["pObservacionesProrroga"]),
                "usuario_crea" => $_POST["userCreate"],
            );
            $crearProrroga->crearProrroga();
            break;

        case 'listaProrrogasContrato':
            $listaProrrogasContrato = new contratistasAjax();
            $listaProrrogasContrato->listaProrrogasContrato($_POST["idContrato"]);
            break;

        case 'listaParTarifasPrestador':
            $listaParTarifasPrestador = new contratistasAjax();
            $listaParTarifasPrestador->datos = array(
                "id_contratista" => $_POST["idContratista"],
                "id_contrato" => $_POST["idContrato"]
            );
            $listaParTarifasPrestador->listaParTarifasPrestador();
            break;

        case 'infoContratoContratista':
            $infoContratoContratista = new contratistasAjax();
            $infoContratoContratista->infoContratoContratista($_POST["idContratista"], $_POST["idContrato"]);
            break;

        case 'crearTarifasDefault':
            $crearTarifasDefault = new contratistasAjax();
            $crearTarifasDefault->datos = array(
                "id_contratista" => $_POST["idContratista"],
                "id_contrato" => $_POST["idContrato"],
                "usuario_crea" => $_POST["userSession"]
            );
            $crearTarifasDefault->crearTarifasDefault();
            break;

        case 'listaTipoContratista':
            $listaTipoContratista = new contratistasAjax();
            $listaTipoContratista->listaTipoContratista();
            break;
        case 'validarExisteContratista':
            $validarExisteContratista = new contratistasAjax();
            $validarExisteContratista->validarExisteContratista($_POST["numeroDoc"], $_POST["tipoDoc"]);
            break;
        case 'crearContratista':
            $crearContratista = new contratistasAjax();
            $crearContratista->datos = array(
                "tipoContratista" => $_POST["tipoContratista"],
                "nombreContratistaContratista" => mb_strtoupper($_POST["nombreContratistaContratista"]),
                "tipoDocumentoContratista" => $_POST["tipoDocumentoContratista"],
                "numeroDocumentoContratista" => $_POST["numeroDocumentoContratista"],
                "naturalezaContratista" => $_POST["naturalezaContratista"],
                "direccionContratista" => mb_strtoupper($_POST["direccionContratista"]),
                "telefonoContratista" => $_POST["telefonoContratista"],
                "departamentoContratista" => $_POST["departamentoContratista"],
                "ciudadContratista" => $_POST["ciudadContratista"],
                "correoContratista" => $_POST["correoContratista"],
                "usuario" => $_POST["userCreate"],
            );

            $crearContratista->crearContratista();
            break;
        case 'listaContratistas':
            $listaContratistas = new contratistasAjax();
            $listaContratistas->listaContratistas();
            break;
        case 'eliminarContratista':
            $eliminarContratista = new contratistasAjax();
            $eliminarContratista->eliminarContratista($_POST["idContratista"]);
            break;

             case 'listaContratosContratista':
            $listaContratosContratista = new contratistasAjax();
            $listaContratosContratista->listaContratosContratista($_POST["idContratista"]);
            break;

        case 'crearContrato':
            $crearContrato = new contratistasAjax();
            if(isset($_FILES["archivoContrato"])){$archivoContrato = $_FILES["archivoContrato"];}else{$archivoContrato = 'VACIO';}
            $crearContrato->datos = array(
                "id_Contratista" => $_POST["idContratista"],
                "tipo_contrato" => $_POST["tipoContrato"],
                "nombre_contrato" => $_POST["nombreContrato"],
                "fecha_inicio" => $_POST["fechaInicio"],
                "fecha_fin" => $_POST["fechaFin"],
                "valor_contrato" => $_POST["valorContrato"],
                "cuantia_indeterminada" => $_POST["cuantiaInderContrato"],
                "archivoContrato" => $archivoContrato,
                "objeto_contractual" => mb_strtoupper($_POST["objetoContrato"]),
                "usuario_crea" => $_POST["userCreate"],
            );
            $crearContrato->crearContrato();
            break;

        case 'infoContratista':
            $infoContratista = new contratistasAjax();
            $infoContratista->infoContratista($_POST["idContratista"]);
            break; 
    }
}

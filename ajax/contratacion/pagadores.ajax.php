<?php

require_once "../../controllers/contratacion/pagadores.controller.php";
require_once "../../models/contratacion/pagadores.model.php";

class PagadoresAjax{

    public $datos;

    public function agregarPagador(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrAgregarPagador($datos);

        echo $respuesta;

    }

    public function listaPagadores(){

        $respuesta = ControladorPagadores::ctrListaPagadores();

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

    public function infoPagador($idPagador){

        $respuesta = ControladorPagadores::ctrInfoPagador($idPagador);

        echo json_encode($respuesta);

    }

    public function crearContrato(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrCrearContrato($datos);

        echo $respuesta;

    }

    public function listaContratosPagador($idPagador){

        $respuesta = ControladorPagadores::ctrListaContratosPagador($idPagador);

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

    public function infoContratoPagador($idPagador, $idContrato){

        $respuesta = ControladorPagadores::ctrInfoContratoPagador($idPagador, $idContrato);

        echo json_encode($respuesta);

    }

    public function crearTarifasDefault(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrCrearTarifasDefault($datos);

        echo json_encode($respuesta);

    }

    public function listaParTarifasPrestador(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrListaParTarifasPrestador($datos);

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

    public function crearTarifa(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrCrearTarifa($datos);

        echo $respuesta;

    }

    public function crearProrroga(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrCrearProrroga($datos);

        echo $respuesta;

    }

    public function listaProrrogasContrato($idContrato){

        $respuesta = ControladorPagadores::ctrListaProrrogasContrato($idContrato);

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

    public function eliminarProrroga(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrEliminarProrroga($datos);

        echo $respuesta;

    }

    public function aplicarProrrogaContrato(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrAplicarProrrogaContrato($datos);

        echo $respuesta;

    }

    public function agregarOtroDocumento(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrAgregarOtroDocumento($datos);

        echo $respuesta;

    }


    public function listaOtrosDocumentosContrato($idContrato){

        $respuesta = ControladorPagadores::ctrListaOtrosDocumentosContrato($idContrato);

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

        $respuesta = ControladorPagadores::ctrEliminarOtroDocumento($datos);

        echo $respuesta;

    }

    public function crearPoliza(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrCrearPolizas($datos);

        echo $respuesta;

    }

    public function listaPolizasContrato($idContrato){

        $respuesta = ControladorPagadores::ctrListaPolizasContrato($idContrato);

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

        $respuesta = ControladorPagadores::ctrEliminarPoliza($datos);

        echo $respuesta;

    }

    public function crearOtroSi(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrCrearOtroSi($datos);

        echo $respuesta;

    }

    public function listaContratosOtroSiContrato($idContrato){

        $respuesta = ControladorPagadores::ctrListaContratosOtroSiContrato($idContrato);

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

        $respuesta = ControladorPagadores::eliminarContratoOtroSi($datos);

        echo $respuesta;

    }

    public function infoTarifario($idTarifario){

        $respuesta = ControladorPagadores::ctrInfoTarifario($idTarifario);

        echo json_encode($respuesta);

    }

    public function crearTarifaUnitaria(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrCrearTarifaUnitaria($datos);

        echo $respuesta;

    }

    public function listaTarifasTarifario($idTarifario){

        $respuesta = ControladorPagadores::ctrListaTarifasTarifario($idTarifario);

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

        $respuesta = ControladorPagadores::ctrEliminarTarifaUnitaria($datos);

        echo $respuesta;

    }

    public function cargarArchivoTarifasMasivo(){

        $datos = $this->datos;

        $respuesta = ControladorPagadores::ctrCargarArchivoTarifasMasivo($datos);

        echo $respuesta;

    }

    public function listaArchivosMasivosTarifas($idTarifario){

        $respuesta = ControladorPagadores::ctrListaArchivosMasivosTarifas($idTarifario);

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
        
        case 'listaArchivosMasivosTarifas':
            $listaArchivosMasivosTarifas = new PagadoresAjax();
            $listaArchivosMasivosTarifas->listaArchivosMasivosTarifas($_POST["idTarifario"]);
            break;

        case 'cargarArchivoTarifasMasivo':
            $cargarArchivoTarifasMasivo = new PagadoresAjax();
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
            $eliminarTarifaUnitaria = new PagadoresAjax();
            $eliminarTarifaUnitaria->datos = array(
                "id_tarifa" => $_POST["idTarifa"],
                "usuario_elimina" => $_POST["userCreate"],
            );
            $eliminarTarifaUnitaria->eliminarTarifaUnitaria();
            break;

        case 'listaTarifasTarifario':
            $listaTarifasTarifario = new PagadoresAjax();
            $listaTarifasTarifario->listaTarifasTarifario($_POST["idTarifario"]);
            break;

        case 'crearTarifaUnitaria':
            $crearTarifaUnitaria = new PagadoresAjax();
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
            $infoTarifario = new PagadoresAjax();
            $infoTarifario->infoTarifario($_POST["idTarifario"]);
            break;

        case 'eliminarContratoOtroSi':
            $eliminarContratoOtroSi = new PagadoresAjax();
            $eliminarContratoOtroSi->datos = array(
                "id_contrato_si" => $_POST["idContratoOtraSi"],
                "usuario_sesion" => $_POST["userCreate"],
            );
            $eliminarContratoOtroSi->eliminarContratoOtroSi();
            break;

        case 'listaContratosOtroSiContrato':
            $listaContratosOtroSiContrato = new PagadoresAjax();
            $listaContratosOtroSiContrato->listaContratosOtroSiContrato($_POST["idContrato"]);
            break;

        case 'crearOtroSi':
            $crearOtroSi = new PagadoresAjax();
            $crearOtroSi->datos = $_POST;
            $crearOtroSi->crearOtroSi();
            break;

        case 'eliminarPoliza':
            $eliminarPoliza = new PagadoresAjax();
            $eliminarPoliza->datos = array(
                "id_poliza" => $_POST["idPoliza"],
                "usuario_sesion" => $_POST["userCreate"],
            );
            $eliminarPoliza->eliminarPoliza();
            break;

        case 'listaPolizasContrato':
            $listaPolizasContrato = new PagadoresAjax();
            $listaPolizasContrato->listaPolizasContrato($_POST["idContrato"]);
            break;

        case 'crearPoliza':
            $crearPoliza = new PagadoresAjax();
            $crearPoliza->datos = $_POST;
            $crearPoliza->crearPoliza();
            break;

        case 'eliminarOtroDocumento':
            $eliminarOtroDocumento = new PagadoresAjax();
            $eliminarOtroDocumento->datos = array(
                "id_otro_documento" => $_POST["idOtroDocumento"],
                "usuario_elimina" => $_POST["userCreate"]
            );
            $eliminarOtroDocumento->eliminarOtroDocumento();
            break;

        case 'listaOtrosDocumentosContrato':
            $listaOtrosDocumentosContrato = new PagadoresAjax();
            $listaOtrosDocumentosContrato->listaOtrosDocumentosContrato($_POST["idContrato"]);
            break;

        case 'agregarOtroDocumento':
            $agregarOtroDocumento = new PagadoresAjax();
            if(isset($_FILES["oDarchivoDocumento"])){$archivoDocumento = $_FILES["oDarchivoDocumento"];}else{$archivoDocumento = 'VACIO';}
            $agregarOtroDocumento->datos = array(
                "id_pagador" => $_POST["idPagador"],
                "id_contrato" => $_POST["idContrato"],
                "tipo_documento" => $_POST["oDTipoDocumento"],
                "observaciones" => mb_strtoupper($_POST["oDObservaciones"]),
                "usuario_crea" => $_POST["userCreate"],
                "archivoDocumento" => $archivoDocumento,
            );
            $agregarOtroDocumento->agregarOtroDocumento();
            break;

        case 'aplicarProrrogaContrato':
            $aplicarProrrogaContrato = new PagadoresAjax();
            $aplicarProrrogaContrato->datos = array(
                "id_prorroga" => $_POST["idProrroga"],
                "id_contrato" => $_POST["idContrato"],
                "prorroga_meses" => $_POST["prorrogaMeses"],
                "usuario_crea" => $_POST["userCreate"],
            );
            $aplicarProrrogaContrato->aplicarProrrogaContrato();
            break;

        case 'eliminarProrroga':
            $eliminarProrroga = new PagadoresAjax();
            $eliminarProrroga->datos = array(
                "id_prorroga" => $_POST["idProrroga"],
                "usuario_elimina" => $_POST["userCreate"],
            );
            $eliminarProrroga->eliminarProrroga();
            break;

        case 'listaProrrogasContrato':
            $listaProrrogasContrato = new PagadoresAjax();
            $listaProrrogasContrato->listaProrrogasContrato($_POST["idContrato"]);
            break;

        case 'crearProrroga':
            $crearProrroga = new PagadoresAjax();
            $crearProrroga->datos = array(
                "id_contrato" => $_POST["idContrato"],
                "prorroga_meses" => $_POST["pMesesProrroga"],
                "observaciones" => mb_strtoupper($_POST["pObservacionesProrroga"]),
                "usuario_crea" => $_POST["userCreate"],
            );
            $crearProrroga->crearProrroga();
            break;

        case 'crearTarifa':
            $crearTarifa = new PagadoresAjax();
            $crearTarifa->datos = array(
                "nombre_tarifa" => mb_strtoupper($_POST["nombreTarifa"]),
                "id_pagador" => $_POST["idPagador"],
                "id_contrato" => $_POST["idContrato"],
                "usuario_crea" => $_POST["userCreate"],
            );
            $crearTarifa->crearTarifa();
            break;

        case 'listaParTarifasPrestador':
            $listaParTarifasPrestador = new PagadoresAjax();
            $listaParTarifasPrestador->datos = array(
                "id_pagador" => $_POST["idPagador"],
                "id_contrato" => $_POST["idContrato"]
            );
            $listaParTarifasPrestador->listaParTarifasPrestador();
            break;

        case 'crearTarifasDefault':
            $crearTarifasDefault = new PagadoresAjax();
            $crearTarifasDefault->datos = array(
                "id_pagador" => $_POST["idPagador"],
                "id_contrato" => $_POST["idContrato"],
                "usuario_crea" => $_POST["userSession"]
            );
            $crearTarifasDefault->crearTarifasDefault();
            break;

        case 'infoContratoPagador':
            $infoContratoPagador = new PagadoresAjax();
            $infoContratoPagador->infoContratoPagador($_POST["idPagador"], $_POST["idContrato"]);
            break;

        case 'listaContratosPagador':
            $listaContratosPagador = new PagadoresAjax();
            $listaContratosPagador->listaContratosPagador($_POST["idPagador"]);
            break;

        case 'crearContrato':
            $crearContrato = new PagadoresAjax();
            if(isset($_FILES["archivoContrato"])){$archivoContrato = $_FILES["archivoContrato"];}else{$archivoContrato = 'VACIO';}
            $crearContrato->datos = array(
                "id_pagador" => $_POST["idPagador"],
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

        case 'infoPagador':
            $infoPagador = new PagadoresAjax();
            $infoPagador->infoPagador($_POST["idPagador"]);
            break; 

        case 'listaPagadores':
            $listaPagadores = new PagadoresAjax();
            $listaPagadores->listaPagadores();
            break;

        case 'agregarPagador':
            $agregarPagador = new PagadoresAjax();
            $agregarPagador->datos = array(
                "tipo_pagador" => $_POST["tipoPagador"],
                "nombre_pagador" => mb_strtoupper($_POST["nombrePagador"]),
                "tipo_identi_pagador" => $_POST["tipoIdentiPagador"],
                "numero_identi_pagador" => $_POST["numeroIdentiPagador"],
                "direccion_pagador" => mb_strtoupper($_POST["direccionPagador"]),
                "telefono_pagador" => $_POST["telefonoPagador"],
                "departamento" => $_POST["departamentoPagador"],
                "ciudad" => $_POST["ciudadPagador"],
                "correo" => $_POST["correoPagador"],
                "usuario_crea" => $_POST["userCreate"],
            );
            $agregarPagador->agregarPagador();
            break;

    }

}
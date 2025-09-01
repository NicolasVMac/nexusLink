<?php

require_once "../../controllers/pagadores/pagadores.controller.php";
require_once "../../models/pagadores/pagadores.model.php";

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

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

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
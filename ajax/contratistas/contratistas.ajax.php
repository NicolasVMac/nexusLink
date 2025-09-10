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

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch ($proceso) {

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

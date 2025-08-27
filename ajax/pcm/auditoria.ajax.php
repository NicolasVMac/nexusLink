<?php

require_once "../../controllers/pcm/auditoria.controlador.php";
require_once "../../models/pcm/auditoria.modelo.php";

class auditoriaAjax
{
    public $datos;

    public function auditoriaValidaCuenta()
    {
        $datos = $this->datos;
        $tabla = 'reclamaciones_log';

        $resultado = ControladorAuditoria::ctrAuditoriaValidaCuenta($tabla, $datos);

        print_r($resultado);
    }

    public function auditoriasearch($perfil, $usuario, $montos, $items)
    {
        $respuesta = ControladorAuditoria::ctrBolsaSearch($perfil, $usuario, $montos, $items);
        //var_dump($respuesta);
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

    public function auditoriaPausa($perfil, $usuario)
    {
        $respuesta = ControladorAuditoria::ctrPausaSearch($perfil, $usuario);
        //var_dump($respuesta);
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

    public function reclamacionInfo($idReclamacion)
    {
        $respuesta = ControladorAuditoria::ctrReclamacionInfo($idReclamacion);
        echo json_encode($respuesta);
    }

    public function reclamacionDetail($idReclamacion)
    {
        $respuesta = ControladorAuditoria::ctrReclamacionDetail($idReclamacion);
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

    public function reclamacionGlosas($idReclamacion)
    {
        $respuesta = ControladorAuditoria::ctrReclamacionGlosas($idReclamacion);
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

    public function crearGlosaItem()
    {
        $datos = $this->datos;
        $tabla = 'reclamaciones_glosas';

        $resultado = ControladorAuditoria::ctrCrearGlosaItem($tabla, $datos);

        print_r($resultado);
    }

    public function crearGlosaMasivoItem()
    {
        $datos = $this->datos;
        $tabla = 'reclamaciones_glosas';

        $resultado = ControladorAuditoria::ctrCrearGlosaMasivoItem($tabla, $datos);

        print_r($resultado);
    }

    public function crearGlosaRecla()
    {
        $datos = $this->datos;
        $tabla = 'reclamaciones_glosas';

        $resultado = ControladorAuditoria::ctrCrearGlosaRecla($tabla, $datos);

        print_r($resultado);
    }

    public function calcularGlosa()
    {
        $datos = $this->datos;

        $resultado = ControladorAuditoria::ctrCalcularGlosa($datos);

        print_r($resultado);
    }

    public function reclamacionClose()
    {

        $datos = $this->datos;

        $resultado = ControladorAuditoria::ctrReclamacionClose($datos);

        print_r($resultado);
    }

    public function glosaUniDelete()
    {

        $datos = $this->datos;
        $tablaDelete = 'reclamaciones_glosas_delete';
        $tablaOrigin = 'reclamaciones_glosas';

        $resultado = ControladorAuditoria::ctrGlosaUniDelete($tablaOrigin, $tablaDelete, $datos);

        print_r($resultado);
    }

    public function glosaMasivoDelete()
    {

        $datos = $this->datos;
        $tablaDelete = 'reclamaciones_glosas_delete';
        $tablaOrigin = 'reclamaciones_glosas';

        $resultado = ControladorAuditoria::ctrGlosaMasivoDelete($tablaOrigin, $tablaDelete, $datos);

        print_r($resultado);
    }

    public function searchClaim()
    {
        $datos = $this->datos;

        $resultado = ControladorAuditoria::ctrSearchBill($datos);

        $data = array();

        foreach ($resultado as $key => $value) {
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
    public function TablaAnotacion($idReclamacion){

        $respuesta = ControladorAuditoria::ctrTablaAnotacion($idReclamacion);

        $data = array();

        foreach($respuesta as $key => $value){
            $data[] = $value;
        }

        $respuesta = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($respuesta);

    }

    public function añadirAnotacion(){
        
        $datos = $this->datos;
        $tabla = 'reclamaciones_anotaciones';

        $respuesta = ControladorAuditoria::ctrañadirAnotacion($tabla, $datos);

        print_r($respuesta);
        
    }

    public function eliminarAnotacion(){

        $datos = $this->datos;

        $respuesta = ControladorAuditoria::ctreliminarAnotacion($datos);

        print_r($respuesta);
    }

    public function reclamacionInfoXml($idReclamacion){

        $respuesta = ControladorAuditoria::ctrReclamacionInfoXml($idReclamacion);
        echo json_encode($respuesta);

    }

    
}

/*-----------------------------------------------------------------------------------------------------------------------*/

if (isset($_POST['option'])) {
    $option = $_POST['option'];

    switch ($option) {
        case 'validaCuenta':
            $auditoria = new auditoriaAjax();
            $auditoria->datos = array(
                "idReclamacion" => $_POST["idReclamacion"],
                "idPerfil" => $_POST["idPerfil"],
                "usuario" => $_POST["usuario"]
            );
            $auditoria->auditoriaValidaCuenta();
            break;
        case 'auditoriaSearch':
            $auditoria = new auditoriaAjax();
            $auditoria->auditoriasearch($_POST["perfil"], $_POST["usuario"], $_POST["montos"], $_POST["items"]);
            break;
        case 'auditoriaPausa':
            $auditoria = new auditoriaAjax();
            $auditoria->auditoriaPausa($_POST["perfil"], $_POST["usuario"]);
            break;
        case 'reclamacionInfo':
            $auditoria = new auditoriaAjax();
            $auditoria->reclamacionInfo($_POST["idReclamacion"]);
            break;
        case 'reclamacionDetail':
            $auditoria = new auditoriaAjax();
            $auditoria->reclamacionDetail($_POST["idReclamacion"]);
            break;
        case 'reclamacionGlosas':
            $auditoria = new auditoriaAjax();
            $auditoria->reclamacionGlosas($_POST["idReclamacion"]);
            break;
        case 'crearGlosaItem':
            $auditoria = new auditoriaAjax();
            $auditoria->datos = array(
                "idItem" => $_POST["idItem"],
                "idReclamacion" => $_POST["idReclamacion"],
                "clasificacion" => $_POST["clasificacion"],
                "codGlosa" => $_POST["codGlosa"],
                "glosaDescription" => $_POST["glosaDescription"],
                "justificacion" => strtoupper($_POST["justificacion"]),
                "usuario" => $_POST["usuario"],
                "tipoGlosa" => $_POST["tipoGlosa"],
                "cantidadItem" => $_POST["cantidadItem"],
                "valorUniItem" => $_POST["valorUniItem"],
                "valorItem" => $_POST["valorItem"],
                "cantidadGlosa" => $_POST["cantidadGlosa"],
                "valorGlosa" => $_POST["valorGlosa"],
                "totalGlosa" => $_POST["totalGlosa"]
            );
            $auditoria->crearGlosaItem();
            break;
        case 'crearGlosaMasivoItem':
            $auditoria = new auditoriaAjax();
            $auditoria->datos = array(
                "idItems" => $_POST["idItemMasivoModal"],
                "idReclamacion" => $_POST["idReclamacion"],
                "clasificacion" => $_POST["clasificacion"],
                "codGlosa" => $_POST["codMasivoGlosa"],
                "glosaDescription" => $_POST["glosaMasivaDescription"],
                "justificacion" => strtoupper($_POST["obsMasivoGlosa"]),
                "usuario" => $_POST["usuario"],
                "tipoGlosa" => $_POST["tipoMasivoGlosa"],
                "valorMasivaGlosa" => $_POST["valorMasivaGlosa"],
                "porcentajeMasivaGlosa" => $_POST["porcentajeMasivaGlosa"]
            );
            $auditoria->crearGlosaMasivoItem();
            break;
        case 'crearGlosaRecla':
            $auditoria = new auditoriaAjax();
            $auditoria->datos = array(
                "idReclamacion" => $_POST["idReclamacion"],
                "clasificacion" => $_POST["clasificacion"],
                "codGlosa" => $_POST["codGlosa"],
                "glosaDescription" => $_POST["glosaDescription"],
                "justificacion" => strtoupper($_POST["justificacion"]),
                "usuario" => $_POST["usuario"],
                "tipoGlosa" => $_POST["tipoGlosa"],
                "valorReclamado" => $_POST["valorReclamado"]
            );
            $auditoria->crearGlosaRecla();
            break;
        case 'calcularGlosa':
            $auditoria = new auditoriaAjax();
            $auditoria->datos = array(
                "idReclamacion" => $_POST["idReclamacion"]
            );
            $auditoria->calcularGlosa();
            break;
        case 'reclamacionClose':
            $auditoria = new auditoriaAjax();
            $auditoria->datos = array(
                "idReclamacion" => $_POST["idReclamacion"],
                "idPerfil" => $_POST["idPerfil"],
                "usuario" => $_POST["usuario"]
            );
            $auditoria->reclamacionClose();
            break;
        case 'glosaUniDelete':
            $auditoria = new auditoriaAjax();
            $auditoria->datos = array(
                "idGlosa" => $_POST["idGlosa"],
                "usuario" => $_POST["usuario"]
            );
            $auditoria->glosaUniDelete();
            break;
        case 'glosaMasivoDelete':
            $auditoria = new auditoriaAjax();
            $auditoria->datos = array(
                "idGlosas" => $_POST["idGlosas"],
                "usuario" => $_POST["usuario"]
            );
            $auditoria->glosaMasivoDelete();
            break;
        case 'searchClaim':
            $auditoria = new auditoriaAjax();
            $auditoria->datos = array(
                "filtro" => $_POST["filtro"],
                "valores" => $_POST["valores"]
            );
            $auditoria->searchClaim();
            break;

        case 'TablaAnotacion':
            $TablaAnotacion = new auditoriaAjax();
            $TablaAnotacion->TablaAnotacion($_POST["idReclamacion"]);
            break;

        case 'añadirAnotacion':
            $añadirAnotacion = new auditoriaAjax();
            $añadirAnotacion->datos = array(
                "idReclamacion" => $_POST["idReclamacion"],
                "Anotacion_Observacion" => mb_strtoupper($_POST["Anotacion_Observacion"]),
                "Usuario_Creacion" => $_POST["Usuario_Creacion"],
                "Numero_Radicacion"=> $_POST["Numero_Radicacion"]
            );
            $añadirAnotacion->añadirAnotacion();
            break;

        case 'eliminarAnotacion':
            $eliminarAnotacion = new auditoriaAjax();
            $eliminarAnotacion->datos = array(
                "Anotacion_Id" => $_POST["Anotacion_Id"],
                "Usuario_Eliminacion" => $_POST["Usuario_Eliminacion"]
            );
            $eliminarAnotacion->eliminarAnotacion();

            break;

        case 'reclamacionInfoXml':
            $reclamacionInfoXml = new auditoriaAjax();
            $reclamacionInfoXml->reclamacionInfoXml($_POST["idReclamacion"]);
            break;
    }
}

<?php

require_once "../../controllers/pdfia/pdfia.controller.php";
require_once "../../models/pdfia/pdfia.model.php";

class PdfAjax
{

    public $datos;

    public function cargarArchivoPDF()
    {

        $datos = $this->datos;

        $respuesta = ControladorPdfia::ctrCargarArchivoPdf($datos);

        echo $respuesta;
    }

    public function listaPdfCargados()
    {

        $respuesta = ControladorPdfia::ctrListaPdfCargados();

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

    public function actualizarSourceID()
    {

        $datos = $this->datos;

        $respuesta = ControladorPdfia::ctrActualizarSourceID($datos);

        echo $respuesta;
    }

    public function guardarMensajePDF()
    {

        $datos = $this->datos;

        $respuesta = ControladorPdfia::ctrGuardarMensajePDF($datos);

        echo $respuesta;
    }

    public function listarMensajesPDF($id_pdf)
    {

        $respuesta = ControladorPdfia::ctrListarMensajesPDF($id_pdf);

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
        case 'listaPdfCargados':
            $listaPdfCargados = new PdfAjax();
            $listaPdfCargados->listaPdfCargados();
            break;
        case 'cargarArchivoPDF':
            $cargarArchivoPDF = new PdfAjax();
            $cargarArchivoPDF->datos = array(
                "nombre_archivo" => $_POST["nombreArchivoPDF"],
                "archivo" => $_FILES["archivoPDF"],
                "usuario" => $_POST["user"]
            );
            $cargarArchivoPDF->cargarArchivoPDF();
            break;
        case 'actualizarSourceID':
            $actualizarSourceID = new PdfAjax();
            $actualizarSourceID->datos = array(
                "sourceId" => $_POST["sourceId"],
                "id_pdf" => $_POST["id_pdf"]
            );
            $actualizarSourceID->actualizarSourceID();
            break;
        case 'guardarMensajePDF':
            $guardarMensajePDF = new PdfAjax();
            $guardarMensajePDF->datos = array(
                "rol" => $_POST["rol"],
                "contenido" => $_POST["contenido"],
                "id_pdf" => $_POST["id_pdf"],
                "usuario" => $_POST["usuario"]
            );
            $guardarMensajePDF->guardarMensajePDF();
            break;
        case 'listarMensajesPDF':
            $listarMensajesPDF = new PdfAjax();
            $listarMensajesPDF->listarMensajesPDF($_POST["id_pdf"]);
            break;
    }
}

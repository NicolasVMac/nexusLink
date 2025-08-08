<?php

require_once "../../controllers/cac/cac.controller.php";
require_once "../../models/cac/cac.model.php";

class CacAjax{

    public $datos;

    public function cargarArchivoCac($nombreArchivo, $archivo, $user){

        $datos = array(
            "nombre_archivo" => $nombreArchivo,
            "archivo" => $archivo,
            "usuario" => $user
        );

        $respuesta = ControladorCac::ctrCargarArchivoCac($datos);

        echo $respuesta;

    }

    public function basesCargadasCac(){

        $respuesta = ControladorCac::ctrBasesCargadasCac();

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

        case 'basesCargadasCac':
            $basesCargadasCac = new CacAjax();
            $basesCargadasCac->basesCargadasCac();
            break;

        case 'cargarArchivoCac':
            $cargarArchivoCac = new CacAjax();
            $cargarArchivoCac->cargarArchivoCac($_POST["nombreArchivo"], $_FILES["archivoCac"], $_POST["user"]);
            break;

    }

}
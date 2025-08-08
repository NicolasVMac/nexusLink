<?php

require_once "../../controllers/correspon/proyectos.controller.php";
require_once "../../models/correspon/proyectos.model.php";

class ProyectosCorrespondenciaAjax{

    public $datos;

    public function validarExistePrefijoProyecto($prefijoProyecto){

        $resultado = ControladorProyectosCorrespondencia::ctrValidarExistePrefijoProyecto($prefijoProyecto);

        echo json_encode($resultado);

    }

    public function crearProyecto(){

        $datos = $this->datos;

        $respuesta = ControladorProyectosCorrespondencia::ctrCrearProyecto($datos);

        echo $respuesta;

    }

    public function listaProyectosCorrespondencia(){

        $respuesta = ControladorProyectosCorrespondencia::ctrListaProyectosCorrespondencia();

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


    public function obtenerInfoProyecto($idProyecto){

        $respuesta = ControladorProyectosCorrespondencia::ctrObtenerInfoProyecto($idProyecto);

        echo json_encode($respuesta);

    }

    public function editarProyecto(){

        $datos = $this->datos;

        $respuesta = ControladorProyectosCorrespondencia::ctrEditarProyecto($datos);

        echo $respuesta;

    }

    public function listaSelectProyectosCorrespondencia(){

        $tabla = "correspondencia_proyectos";
        $item = null;
        $valor = null;

        $resultado = ControladorProyectosCorrespondencia::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Proyecto</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["id_proyecto"].'">'.$value["nombre_proyecto"].' - '.$value["prefijo_proyecto"].'</option>';

        }

        echo $cadena;

    }

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'listaSelectProyectosCorrespondencia':
            $listaSelectProyectosCorrespondencia = new ProyectosCorrespondenciaAjax();
            $listaSelectProyectosCorrespondencia->listaSelectProyectosCorrespondencia();
            break;

        case 'editarProyecto':
            $editarProyecto = new ProyectosCorrespondenciaAjax();
            $editarProyecto->datos = array(
                "id_proyecto" => $_POST["editIdProyecto"],
                "nombre_proyecto" => mb_strtoupper($_POST["editarNombreProyecto"]),
                "id_usuario_responsable" => $_POST["editarResponsablesProyectos"],
                "usuario" => $_POST["userSession"]
            );
            $editarProyecto->editarProyecto();
            break;

        case 'obtenerInfoProyecto':
            $obtenerInfoProyecto = new ProyectosCorrespondenciaAjax();
            $obtenerInfoProyecto->obtenerInfoProyecto($_POST["idProyecto"]);
            break;

        case 'listaProyectosCorrespondencia':
            $listaProyectosCorrespondencia = new ProyectosCorrespondenciaAjax();
            $listaProyectosCorrespondencia->listaProyectosCorrespondencia();
            break;

        case 'crearProyecto':
            $crearProyecto = new ProyectosCorrespondenciaAjax();
            $crearProyecto->datos = array(
                "nombre_proyecto" => mb_strtoupper($_POST["nombreProyecto"]),
                "prefijo_proyecto" => mb_strtoupper($_POST["prefijoProyecto"]),
                "id_usuario_responsable" => $_POST["responsablesProyectos"],
                "usuario_crea" => $_POST["userCreate"]
            );
            $crearProyecto->crearProyecto();
            break;

        case 'validarExistePrefijoProyecto':
            $validarExistePrefijoProyecto = new ProyectosCorrespondenciaAjax();
            $validarExistePrefijoProyecto->validarExistePrefijoProyecto($_POST["prefijoProyecto"]);
            break;

    }

}
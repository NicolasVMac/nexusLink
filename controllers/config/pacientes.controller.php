<?php

class ControladorPacientes{

    static public function ctrMostrarInfoPacienteId($idPaciente){

        $tabla = "pacientes";

        $respuesta = ModelPacientes::mdlMostrarInfoPacienteId($tabla, $idPaciente);

        return $respuesta;

    }

    static public function ctrValidarExisteDocumento($tipoDocumento, $numDocumento){

        $tabla = "pacientes";

        $respuesta = ModelPacientes::mdlValidarExisteDocumento($tabla, $tipoDocumento, $numDocumento);

        return $respuesta;

    }

    static public function ctrCrearPaciente($datos){

        $tabla = "pacientes";

        $respuesta = ModelPacientes::mdlCrearPaciente($tabla, $datos);

        return $respuesta;

    }

    static public function ctrMostrarPacientes($item, $valor){

        $tabla = "pacientes";

        $respuesta = ModelPacientes::mdlMostrarPacientes($tabla, $item, $valor);

        return $respuesta;

    }

    static public function ctrEditarPaciente($datos){

        $tabla = "pacientes";

        $respuesta = ModelPacientes::mdlEditarPaciente($tabla, $datos);

        return $respuesta;

    }
    
}
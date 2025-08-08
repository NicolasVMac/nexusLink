<?php

class ControladorProyectosCorrespondencia{

    static public function ctrObtenerDatosActivos($tabla, $item, $valor){

        $respuesta = ModelProyectosCorrespondencia::mdlObtenerDatosActivos($tabla, $item, $valor);

        return $respuesta;

    }

    static public function ctrEditarProyecto($datos){

        $tabla = "correspondencia_proyectos";

        $respuesta = ModelProyectosCorrespondencia::mdlEditarProyecto($tabla, $datos);

        return $respuesta;

    }

    static public function ctrObtenerInfoProyecto($idProyecto){

        $respuesta = ModelProyectosCorrespondencia::mdlObtenerInfoProyecto($idProyecto);

        return $respuesta;

    }

    static public function ctrListaProyectosCorrespondencia(){

        $respuesta = ModelProyectosCorrespondencia::mdlListaProyectosCorrespondencia();

        return $respuesta;

    }

    static public function ctrCrearProyecto($datos){

        $tabla = "correspondencia_proyectos";

        $respuesta = ModelProyectosCorrespondencia::mdlCrearProyecto($tabla, $datos);

        return $respuesta;

    }

    static public function ctrValidarExistePrefijoProyecto($prefijoProyecto){

        $respuesta = ModelProyectosCorrespondencia::mdlValidarExistePrefijoProyecto($prefijoProyecto);

        if(empty($respuesta)){

            return 'no-existe';

        }else{

            return 'existe';

        }

    }

}
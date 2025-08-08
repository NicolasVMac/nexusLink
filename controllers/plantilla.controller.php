<?php

class ControllerPlantilla{

    static public function ctrPlantilla(){

        include "views/plantilla.php";

    }

    static public function ctrRutas($carpeta,$ruta){
        $tabla='par_rutas';
        $respuesta = ModelPlantilla::mdlRutas($tabla, $carpeta, $ruta);
        return $respuesta;

    }

}
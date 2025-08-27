<?php

class ControladorHistoricos
{
	static public function ctrHistoricosEvento($datos){

		$respuesta = ModeloHistoricos::mdlHistoricosEvento($datos);

		return $respuesta;

	}
	static public function ctrReclamacionInfo($idReclamacion){

		$respuesta = ModeloHistoricos::mdlReclamacionInfo($idReclamacion);

		return $respuesta;

	}

	static public function ctrReclamacionDetail($idReclamacion){

		$respuesta = ModeloHistoricos::mdlReclamacionDetail($idReclamacion);

		return $respuesta;

	}

	static public function ctrReclamacionGlosas($idReclamacion){

		$respuesta = ModeloHistoricos::mdlReclamacionGlosas($idReclamacion);

		return $respuesta;

	}
	static public function ctrTablaAnotacion($idReclamacion){

        $respuesta = ModeloHistoricos::mdlTablaAnotacion($idReclamacion);
            
        return $respuesta;  
        
    }

   
}
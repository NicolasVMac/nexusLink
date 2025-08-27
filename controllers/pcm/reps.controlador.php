<?php

class ControladorReps
{
	static public function ctrRepsInfo($datos){

		$respuesta = ModeloReps::mdlRepsInfo($datos);

		return $respuesta;

	}

   
}
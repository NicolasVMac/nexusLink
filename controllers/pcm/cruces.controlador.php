<?php

class ControladorCruces
{
	static public function ctrCruceRenc($tabla,$datos){

		$respuesta = ModeloCruces::mdlCruceRenc($tabla,$datos);

		return $respuesta;

	}

    static public function ctrCruceRepsHabili($tabla,$datos){

		$respuesta = ModeloCruces::mdlCruceRepsHabili($tabla,$datos);

		return $respuesta;

	}

    static public function ctrCruceRepsProced($tabla,$datos){

		$respuesta = ModeloCruces::mdlCruceRepsProced($tabla,$datos);

		return $respuesta;

	}

    static public function ctrCruceRepsTrans($tabla,$datos){

		$respuesta = ModeloCruces::mdlCruceRepsTrans($tabla,$datos);

		return $respuesta;

	}

    static public function ctrCrucePoliza($tabla,$datos){

		$respuesta = ModeloCruces::mdlCrucePoliza($tabla,$datos);

		return $respuesta;

	}

    static public function ctrCruceSiniestro($tabla,$datos){

		$respuesta = ModeloCruces::mdlCruceSiniestro($tabla,$datos);

		return $respuesta;

	}
}
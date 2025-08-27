<?php

class ControladorAuditoria
{
	static public function ctrAuditoriaValidaCuenta($tabla,$datos){

		$respuesta = ModeloAuditoria::mdlAuditoriaValidaCuenta($tabla,$datos);

		return $respuesta;

	}

    static public function ctrBolsaSearch($perfil,$usuario,$montos,$items){

		$respuesta = ModeloAuditoria::mdlBolsaSearch($perfil,$usuario,$montos,$items);

		return $respuesta;

	}

	static public function ctrPausaSearch($perfil,$usuario){

		$respuesta = ModeloAuditoria::mdlPausaSearch($perfil,$usuario);

		return $respuesta;

	}

	static public function ctrReclamacionInfo($idReclamacion){

		$respuesta = ModeloAuditoria::mdlReclamacionInfo($idReclamacion);

		return $respuesta;

	}

	static public function ctrReclamacionDetail($idReclamacion){

		$respuesta = ModeloAuditoria::mdlReclamacionDetail($idReclamacion);

		return $respuesta;

	}

	static public function ctrReclamacionGlosas($idReclamacion){

		$respuesta = ModeloAuditoria::mdlReclamacionGlosas($idReclamacion);

		return $respuesta;

	}

	static public function ctrCrearGlosaItem($tabla, $datos){

		$respuesta = ModeloAuditoria::mdlCrearGlosaItem($tabla, $datos);

		return $respuesta;

	}

	static public function ctrCrearGlosaMasivoItem($tabla, $datos){

		$respuesta = ModeloAuditoria::mdlCrearGlosaMasivoItem($tabla, $datos);

		return $respuesta;

	}

	static public function ctrCrearGlosaRecla($tabla, $datos){

		$respuesta = ModeloAuditoria::mdlCrearGlosaRecla($tabla, $datos);

		return $respuesta;

	}

	static public function ctrCalcularGlosa($datos){

		$respuesta = ModeloAuditoria::mdlCalcularGlosa($datos);

		return $respuesta;

	}

	static public function ctrReclamacionClose($datos){

		$respuesta = ModeloAuditoria::mdlReclamacionClose($datos);

		return $respuesta;

	}

	static public function ctrGlosaUniDelete($tablaOrigin, $tablaDelete, $datos){

		$respuesta = ModeloAuditoria::mdlGlosaUniDelete($tablaOrigin, $tablaDelete, $datos);

		return $respuesta;

	}

	static public function ctrGlosaMasivoDelete($tablaOrigin, $tablaDelete, $datos){

		$respuesta = ModeloAuditoria::mdlGlosaMasivoDelete($tablaOrigin, $tablaDelete, $datos);

		return $respuesta;

	}

	static public function ctrObtenerDatos($tabla, $item, $valor){

        $respuesta = ModeloAuditoria::mdlObtenerDatos($tabla, $item, $valor);

        return $respuesta;

    }

	static public function ctrSearchBill($datos){

		$respuesta = ModeloAuditoria::mdlSearchBill($datos);

		return $respuesta;

	}
	static public function ctrTablaAnotacion($idReclamacion){

        $respuesta = ModeloAuditoria::mdlTablaAnotacion($idReclamacion);
            
        return $respuesta;  
        
    }
	static public function ctrañadirAnotacion($tabla, $datos){

		$respuesta = ModeloAuditoria::mdlañadirAnotacion($tabla, $datos);

		return $respuesta;
	}
	static public function ctreliminarAnotacion($datos){
		
		$respuesta = ModeloAuditoria::mdleliminarAnotacion($datos);

		return $respuesta;
	}

	static public function ctrReclamacionInfoXml($idReclamacion){

		$respuesta = ModeloAuditoria::mdlReclamacionInfoXml($idReclamacion);

		return $respuesta;

	}

}
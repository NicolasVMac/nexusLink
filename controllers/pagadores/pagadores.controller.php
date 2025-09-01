<?php

class ControladorPagadores{

    static public function ctrListaContratosPagador($idPagador){

        $respuesta = ModelPagadores::mdlListaContratosPagador($idPagador);
        
        return $respuesta;

    }

    static public function ctrCrearContrato($datos){

        if(!empty($datos["archivoContrato"]["name"])){

            $Now = date('YmdHis');
			$ruta = "../../../archivos_nexuslink/pagadores/pagadores_contratos/{$datos["id_pagador"]}/";
            if(!file_exists($ruta)){
                mkdir($ruta, 0777, true) or die ("No se puede crear el directorio");
            }
			$nombreOriginal = $datos["archivoContrato"]["name"];
			$nombreArchivo = $Now.$nombreOriginal;
			$rutaFin = $ruta.$nombreArchivo;

            move_uploaded_file ($datos["archivoContrato"]["tmp_name"], $rutaFin);
            $datos["ruta_archivo_contrato"] = $rutaFin;

        }else{

            $datos["ruta_archivo_contrato"] = "";

        }

        $tabla = "pagadores_pagadores_contratos";

        $respuesta = ModelPagadores::mdlCrearContrato($tabla, $datos);

        return $respuesta;

    }

    static public function ctrInfoPagador($idPagador){

        $tabla = "pagadores_pagadores";

        $respuesta = ModelPagadores::ctrInfoPagador($idPagador);

        return $respuesta;

    }

    static public function ctrListaPagadores(){

        $tabla = "pagadores_pagadores";

        $respuesta = ModelPagadores::mdlListaPagadores($tabla);

        return $respuesta;

    }
    
    static public function ctrAgregarPagador($datos){

        $tabla = "pagadores_pagadores";

        $respuesta = ModelPagadores::mdlAgregarPagador($tabla, $datos);

        return $respuesta;

    }


}
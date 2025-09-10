<?php

class ControladorContratistas
{

    static public function ctrListaTipoContratista($tabla)
    {
        $respuesta = ModelContratistas::mdlListaTipoContratista($tabla);

        return $respuesta;
    }

    static public function ctrValidarExisteContratista($numeroDoc, $tipoDoc)
    {

        $respuesta = ModelContratistas::mdlValidarExisteContratista($numeroDoc, $tipoDoc);

        if (empty($respuesta)) {

            return 'no-existe';
        } else {

            return 'existe';
        }
    }
    static public function ctrCrearContratista($datos)
    {

        $tabla = 'contratistas_contratistas';
        $respuesta = ModelContratistas::mdlCrearContratista($tabla, $datos);

        return $respuesta;
    }

    static public function ctrListaContratistas()
    {

        $tabla = 'contratistas_contratistas';
        $respuesta = ModelContratistas::mdlListaContratistas($tabla);

        return $respuesta;
    }

    static public function ctrEliminarContratista($idContratista)
    {

        $tabla = 'contratistas_contratistas';
        $respuesta = ModelContratistas::mdlEliminarContratista($tabla, $idContratista);

        return $respuesta;
    }
    static public function ctrListaContratosContratista($idContratista)
    {

        $respuesta = ModelContratistas::mdlListaContratosContratista($idContratista);

        return $respuesta;
    }

    static public function ctrCrearContrato($datos)
    {

        if (!empty($datos["archivoContrato"]["name"])) {

            $Now = date('YmdHis');
            $ruta = "../../../archivos_nexuslink/contratistas/contratistas_contratos/{$datos["id_Contratista"]}/";
            if (!file_exists($ruta)) {
                mkdir($ruta, 0777, true) or die("No se puede crear el directorio");
            }
            $nombreOriginal = $datos["archivoContrato"]["name"];
            $nombreArchivo = $Now . $nombreOriginal;
            $rutaFin = $ruta . $nombreArchivo;

            move_uploaded_file($datos["archivoContrato"]["tmp_name"], $rutaFin);
            $datos["ruta_archivo_contrato"] = $rutaFin;
        } else {

            $datos["ruta_archivo_contrato"] = "";
        }

        $tabla = "contratistas_contratistas_contratos";

        $respuesta = ModelContratistas::mdlCrearContrato($tabla, $datos);

        return $respuesta;
    }

    static public function ctrInfoContratista($idContratista)
    {

        $tabla = "contratistas_contratistas";

        $respuesta = ModelContratistas::mdlInfoContratista($idContratista);

        return $respuesta;
    }
}

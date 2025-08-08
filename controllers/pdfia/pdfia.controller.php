<?php

require_once "../../plugins/PHPExcel/IOFactory.php";
require_once "../../plugins/PHPExcel.php";

class ControladorPdfia
{
    static public function ctrCargarArchivoPdf($datos)
    {
        $tabla = "pdfia_pdf_hc";

        // Definir la ruta donde se guardará el PDF
        $rutaArchivo = "../../../archivos_vidamedical/pdfia/pdf";

        // Verificar si se subió un archivo
        if (!empty($datos["archivo"]) && !empty($datos["archivo"]["name"])) {
            // Crear el directorio si no existe
            if (!file_exists($rutaArchivo)) {
                mkdir($rutaArchivo, 0777, true) or die("No se puede crear el directorio");
            }

            // Obtener la información del archivo
            $nombreOriginal = $datos["archivo"]["name"];
            $sourceArchivo = $datos["archivo"]["tmp_name"];

            // Generar un nombre único basado en fecha y hora (YYYYMMDDHHMMSS)
            $filenameArchivo = date("YmdHis") . ".pdf";

            // Definir la ruta completa donde se guardará el archivo
            $rutaArchivoFin = $rutaArchivo . "/" . $filenameArchivo;

            // Mover el archivo a la carpeta de destino
            if (move_uploaded_file($sourceArchivo, $rutaArchivoFin)) {
                $resultado = "ok";
            } else {
                $resultado = "error";
            }
        } else {
            // Si no se subió un archivo, dejar la ruta vacía
            $rutaArchivoFin = '';
            $filenameArchivo = '';
        }
        $datos["nombre_original"] = $nombreOriginal;
        $datos["new_nombre_archivo"] = $filenameArchivo;
        $datos["ruta_archivo"] = $rutaArchivoFin;
        $datos["fecha_crea"] = date("Y-m-d H:i:s");

        // Llamar al modelo para guardar los datos en la base de datos
        $respuesta = ModelPdfia::mdlGuardarArchivoPdf($tabla, $datos);

        return ($respuesta == 'ok') ? 'ok' : 'error';
    }

    static public function ctrListaPdfCargados()
    {

        $tabla = "pdfia_pdf_hc";

        $respuesta = ModelPdfia::mdlListaPdfCargados($tabla);

        return $respuesta;
    }

    static public function ctrActualizarSourceID($datos)
    {
        $tabla = "pdfia_pdf_hc";
        $respuesta = ModelPdfia::mdlActualizarSourceID($tabla, $datos);

        return $respuesta;
    }

    static public function ctrGuardarMensajePDF($datos)
    {
        $tabla = "pdfia_pdf_chat";
        $fechaHora = date("Y-m-d H:i:s");
        $respuesta = ModelPdfia::mdlGuardarMensajePDF($tabla, $datos,$fechaHora);

        return $respuesta;
    }

    static public function ctrListarMensajesPDF($id_pdf)
    {

        $tabla = "pdfia_pdf_chat";

        $respuesta = ModelPdfia::mdlListarMensajesPDF($tabla,$id_pdf);

        return $respuesta;
    }

}

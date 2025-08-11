<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

require_once "../../plugins/PHPExcel/IOFactory.php";
require_once "../../plugins/PHPExcel.php";

class ControladorCac{

    static public function ctrGuardarRutaErroresVali($datos){

        $respuesta = ModelCac::mdlGuardarRutaErroresVali($datos);

        return $respuesta;

    }

    static public function ctrMarcarErrorIdCac($tabla, $datos){

        $respuesta = ModelCac::mdlMarcarErrorIdCac($tabla, $datos);

        return $respuesta;

    } 

    static public function ctrRegistrarLogErrorValidacion($datos){

        $respuesta = ModelCac::mdlRegistrarLogErrorValidacion($datos);

        return $respuesta;

    }

    static public function ctrRegistrarLogErrorCarga($datos){

        $respuesta = ModelCac::mdlRegistrarLogErrorCarga($datos);

        return $respuesta;

    }

    static public function ctrBasesCargadasCac(){

        $respuesta = ModelCac::mdlBasesCargadasCac();

        return $respuesta;

    }

    static public function ctrCargarArchivoCac($datos){

        if(!empty($datos)){

            $Now = date('YmdHis');
			$ruta = "../../../archivos_nexuslink/cac/archivos_bases_cac/";
			$rutaErrores = "../../../archivos_nexuslink/cac/archivos_bases_cac/errores/";
			$nombreOriginal = $datos["archivo"]["name"];
			$nombreArchivo = $Now.$nombreOriginal;
			$rutaFin = $ruta.$nombreArchivo;
			$rutaFinErros = $rutaErrores.$nombreArchivo.".txt";

            move_uploaded_file($datos["archivo"]["tmp_name"], $rutaFin);

            $objPHPExcel = PHPEXCEL_IOFactory::load($rutaFin);
            $objPHPExcel->setActiveSheetIndex(0);
            $NumColum = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
            $NumFilas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

            if($NumColum == 'HD'){

                $tabla = "cac_cac_bases";

                $datosCac = array(
                    "nombre" => strtoupper($datos["nombre_archivo"]),
                    "nombre_archivo_original" => $nombreOriginal,
                    "nombre_archivo" => $nombreArchivo,
                    "ruta_archivo" => $rutaFin,
                    "cantidad" => $NumFilas-1,
                    "estado" => "SUBIDA",
                    "usuario_crea" => $datos["usuario"]
                );

                $guardarArchivo = ModelCac::mdlGuardarArchivoCac($tabla, $datosCac);

                if($guardarArchivo == 'ok'){

                    return 'ok';

                }else{

                    return $guardarArchivo;

                }

            }else{

                $archivoError = fopen("../../../archivos_nexuslink/cac/archivos_bases_cac/errores/" . $nombreArchivo . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

                fwrite($archivoError, $nombreArchivo . "\n");
                fwrite($archivoError, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
                fwrite($archivoError, "Validacion Cargue Base CAC\n");
                fwrite($archivoError, "El archivo no posee la estructura adecuada de 212 columnas (HD)\n");
                fwrite($archivoError, "------------------------ Fin Validacion-------------------------------------\n");

                return 'error-estructura';

            }


        }

    }
    

}
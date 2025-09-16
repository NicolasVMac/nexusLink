<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
date_default_timezone_set('America/Bogota');
$hoy = date('Y-m-d H:i:s');

//$spout = "../../plugins/spout/src/Spout/Autoloader/autoload.php";
//require_once $spout;
require_once "../../plugins/PHPExcel/IOFactory.php";
require_once "../../plugins/PHPExcel.php";

require "../../models/connection.php";
require "../../controllers/contratistas/contratistas.controller.php";
require "../../models/contratistas/contratistas.model.php";

//use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

$tiempo_inicio = microtime(true);

$archivoTarifario = Connection::connectBatch()->prepare("SELECT * FROM contratistas_contratista_tarifas_archivos_masivo WHERE estado = 'CARGAR' ORDER BY fecha_crea ASC LIMIT 1");
$archivoTarifario->execute();
$archivoTarifario = $archivoTarifario->fetch();


if(empty($archivoTarifario)){

    echo 'No hay Tarifarios para cargar <br>';

}else{

    $idBase = $archivoTarifario["id_archivo_tarifas"];
    $nombreArchivo = $archivoTarifario["nombre_archivo"];
    $rutaArchivo = $archivoTarifario["ruta_archivo"];


    //CAMBIAR ESTADO A CARGANDO
    $cargando= Connection::connectOnly()->prepare("UPDATE contratistas_contratista_tarifas_archivos_masivo set estado = 'CARGANDO', fecha_ini_carga = CURRENT_TIMESTAMP WHERE id_archivo_tarifas = $idBase"); 
    $cargando->execute();

    echo "Id Archivo Tarifas: {$idBase} - Nombre Archivo: {$nombreArchivo} - Ruta Archivo: {$rutaArchivo} <br><br>";

    $objPHPExcel = PHPEXCEL_IOFactory::load($rutaArchivo);
    $objPHPExcel->setActiveSheetIndex(0);
    $NumColum = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
    $NumFilas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
    $cantidadRegistros = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow() - 1;

    echo "Letra Columna: {$NumColum} - Numero Filas: {$cantidadRegistros} <br>";

    //$fechaBase = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();

    //$fechaBase  = PHPExcel_Style_NumberFormat::toFormattedString($fechaBase,PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIMENICOLAS2);
    $erroresCarga = [];

    for($i = 2; $i <= $NumFilas; $i++){

        $tipoTarifa = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
        $codigo = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
        $codigoNormalizado = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
        $registroSanitario = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
        $tarifaPactada = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
        $tarifaRegulacion = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
        $fechaInicioVigencia = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
        $fechaFinVigencia = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
        $descripcionTarifa = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
        $producto = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();

        $date = $fechaInicioVigencia;
        $date1 = DateTime::createFromFormat('Y-m-d', $date);
        
        if ($date1 !== false) {
            // El formato de la fecha y hora es 'd/m/Y h:i:s a'
            $fechaInicioVigencia = $date1->format('Y-m-d H:i:s');
        } else {
            // El formato de la fecha y hora no es 'd/m/Y h:i:s a', vamos a intentar con 'd/m/Y'
            $date2 = DateTime::createFromFormat('d/m/Y', $date);
            if ($date2 !== false) {
                // El formato de la fecha y hora es 'd/m/Y'
                $fechaInicioVigencia = $date2->format('Y-m-d');
            } else {
                // El formato de la fecha y hora no es ni 'd/m/Y h:i:s a' ni 'd/m/Y', intentamos con 'd-m-Y'
                $date3 = DateTime::createFromFormat('d-m-Y', $date);
                if ($date3 !== false) {
                    $fechaInicioVigencia = $date3->format('Y-m-d');
                } else {
                    // Intentamos con 'd-m-Y h:i:s'
                    $date4 = DateTime::createFromFormat('d-m-Y h:i:s', $date);
                    if ($date4 !== false) {
                        $fechaInicioVigencia = $date4->format('Y-m-d H:i:s');
                    } else {
                        $filaLfechaInicioVigenciaimpia = '00-00-00 00:00:00';
                        //throw new Exception("Formato de fecha y hora no válido");
                    }
                }
            }
        }

        $fechaInicioVigencia = PHPExcel_Style_NumberFormat::toFormattedString($fechaInicioVigencia,PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIMENICOLAS);

        $date = $fechaFinVigencia;
        $date1 = DateTime::createFromFormat('Y-m-d', $date);

        if ($date1 !== false) {
            // El formato de la fecha y hora es 'd/m/Y h:i:s a'
            $fechaFinVigencia = $date1->format('Y-m-d H:i:s');
        } else {
            // El formato de la fecha y hora no es 'd/m/Y h:i:s a', vamos a intentar con 'd/m/Y'
            $date2 = DateTime::createFromFormat('d/m/Y', $date);
            if ($date2 !== false) {
                // El formato de la fecha y hora es 'd/m/Y'
                $fechaFinVigencia = $date2->format('Y-m-d');
            } else {
                // El formato de la fecha y hora no es ni 'd/m/Y h:i:s a' ni 'd/m/Y', intentamos con 'd-m-Y'
                $date3 = DateTime::createFromFormat('d-m-Y', $date);
                if ($date3 !== false) {
                    $fechaFinVigencia = $date3->format('Y-m-d');
                } else {
                    // Intentamos con 'd-m-Y h:i:s'
                    $date4 = DateTime::createFromFormat('d-m-Y h:i:s', $date);
                    if ($date4 !== false) {
                        $fechaFinVigencia = $date4->format('Y-m-d H:i:s');
                    } else {
                        $filaLfechaFinVigenciaimpia = '00-00-00 00:00:00';
                        //throw new Exception("Formato de fecha y hora no válido");
                    }
                }
            }
        }

        $fechaFinVigencia = PHPExcel_Style_NumberFormat::toFormattedString($fechaFinVigencia,PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIMENICOLAS);

        $datos = array(

            "id_par_tarifario" => $archivoTarifario["id_tarifario"],
            "tipo_tarifa" => $tipoTarifa,
            "codigo" => mb_strtoupper($codigo),
            "codigo_normalizado" => mb_strtoupper($codigoNormalizado),
            "registro_sanitario" => mb_strtoupper($registroSanitario),
            "tarifa_pactada" => $tarifaPactada,
            "tarifa_regulacion" => $tarifaRegulacion,
            "fecha_inicio_vigencia" => $fechaInicioVigencia,
            "fecha_fin_vigencia" => $fechaFinVigencia,
            "descripcion_tarifa" => mb_strtoupper($descripcionTarifa),
            "producto" => mb_strtoupper($producto),
            "usuario_crea" => "ADMIN"
            
        );

        $tabla = "contratistas_contratista_tarifas";

        $crearTarifa = ModelContratistas::mdlCrearTarifaUnitaria($datos);

        if($crearTarifa == 'ok'){

            echo "Tarifa Guardada: {$i}.<br>";

        }else{

            echo "Error Carga Tarifa: {$i} <br>";
            // var_dump($crearEncuesta);
            $erroresCarga[] = 'No se cargo Tarifa en Fila: ' . $i . "<br>";

        }

    }

    if(sizeof($erroresCarga)>0){

        $rutaErrores = "../../../archivos_nexuslink/contratistas/contratistas_archivos_tarifarios/errores_carga/";
        $rutaFinErros = $rutaErrores.$nombreArchivo.".txt";

        $resl_vali = fopen("../../../archivos_nexuslink/contratistas/contratistas_archivos_tarifarios/errores_carga/" . $nombreArchivo . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

        fwrite($resl_vali, $nombreArchivo . "\n");
        fwrite($resl_vali, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
        fwrite($resl_vali, "Validacion Carga Tarifas\n");
        fwrite($resl_vali, "El archivo posee errores en las siguientes filas\n");
        fwrite($resl_vali, "-----------------------------------Errores----------------------------------------\n");

        for($i=0;$i<sizeof($erroresCarga);$i++){
            fwrite($resl_vali, $erroresCarga[$i]."\n");
        }

        fwrite($resl_vali, "------------------------ Fin Validacion-------------------------------------\n");

        fwrite($resl_vali, "\n");
        fwrite($resl_vali, "\n");
        fwrite($resl_vali, "------------------------ Cantidad de lineas Validadas " . ($NumFilas - 1) . " ----------------------\n");

        $respuesta = Connection::connectOnly()->prepare("UPDATE contratistas_contratista_tarifas_archivos_masivo SET fecha_fin_carga = CURRENT_TIMESTAMP, estado = 'ERROR_CARGA', ruta_archivo_errors = '$rutaFinErros' WHERE id_archivo_tarifas = $idBase");

        if($respuesta->execute()){

            echo "Ok, se guardo el archivo de errores de carga.<br>";

        }else{

            echo "Error no se guardo archivo de errores de carga.<br>";

        }

    }else{

        $respuesta = Connection::connectOnly()->prepare("UPDATE contratistas_contratista_tarifas_archivos_masivo SET fecha_fin_carga = CURRENT_TIMESTAMP, estado = 'CARGADO' WHERE id_archivo_tarifas = $idBase");

        if($respuesta->execute()){

            echo "Ok, Se cargaron las Tarifas<br>";

        }else{

            echo "Error no se actualizo el estado CARGADO.<br>";

        }


    }


}
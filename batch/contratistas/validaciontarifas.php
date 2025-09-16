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

$archivoTarifario = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratista_tarifas_archivos_masivo WHERE estado = 'SUBIDA' ORDER BY fecha_crea ASC LIMIT 1");
$archivoTarifario->execute();
$archivoTarifario = $archivoTarifario->fetch();


if(empty($archivoTarifario)){

    echo 'No hay Tarifarios para cargar <br>';

}else{

    $idBase = $archivoTarifario["id_archivo_tarifas"];
    $nombreArchivo = $archivoTarifario["nombre_archivo"];
    $rutaArchivo = $archivoTarifario["ruta_archivo"];

    // //ACTUALIZAR A ESTADO VALIDACIONES
    $enValidacion = Connection::connectBatch()->prepare("UPDATE contratistas_contratista_tarifas_archivos_masivo SET estado = 'VALIDANDO', fecha_ini_valida = CURRENT_TIMESTAMP WHERE id_archivo_tarifas = $idBase");
    $enValidacion->execute();

    echo "Id Archivo Tarifas: {$idBase} - Nombre Archivo: {$nombreArchivo} - Ruta Archivo: {$rutaArchivo} <br><br>";

    $objPHPExcel = PHPEXCEL_IOFactory::load($rutaArchivo);
    $objPHPExcel->setActiveSheetIndex(0);
    $NumColum = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
    $NumFilas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow() - 1;

    echo "Letra Columna: {$NumColum} - Numero Filas: {$NumFilas} <br>";

    $errores = [];

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

        if($tipoTarifa != "INSUMOS" && $tipoTarifa != "MEDICAMENTOS"){
            $errores[] = 'Error en Tipo Tarifa diferente a (INSUMOS - MEDICAMENTOS) En Fila: '.$i;
        }

        if(empty($codigo)){
            $errores[] = 'Error en Codigo En Fila: '.$i;	
        }

        if(empty($codigoNormalizado)){
            $errores[] = 'Error en Codigo Normalizado En Fila: '.$i;	
        }

        if(empty($registroSanitario)){
            $errores[] = 'Error en Registro Sanitario En Fila: '.$i;	
        }

        if(!is_numeric($tarifaPactada) || empty($tarifaPactada)){
            $errores[] = 'Error en Tarifa Pactada En Fila: '.$i;	
        }

        if(!is_numeric($tarifaRegulacion) || empty($tarifaRegulacion)){
            $errores[] = 'Error en Tarifa Regulacion En Fila: '.$i;	
        }

        if($fechaInicioVigencia==''){
            $errores[]='Error en Fecha Inicio Vigencia En Fila '.$i;
        }else{

            // $fechaInicioVigencia = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaPubli));
            $fechaInicioVigencia = date("Y-m-d", strtotime($fechaInicioVigencia."+ 1 days"));
            $fecha=explode("-", $fechaInicioVigencia);
            $fechaAno=$fecha[0];
            $fechaMes=$fecha[1];
            $fechaDia=$fecha[2];

            if(!checkdate($fechaMes, $fechaDia, $fechaAno)){
                $errores[]='Error en Fecha Inicio Vigencia En Fila '.$i;
            }
        }

        if($fechaFinVigencia==''){
            $errores[]='Error en Fecha Fin Vigencia En Fila '.$i;
        }else{

            // $fechaFinVigencia = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaPubli));
            $fechaFinVigencia = date("Y-m-d", strtotime($fechaFinVigencia."+ 1 days"));
            $fecha=explode("-", $fechaFinVigencia);
            $fechaAno=$fecha[0];
            $fechaMes=$fecha[1];
            $fechaDia=$fecha[2];

            if(!checkdate($fechaMes, $fechaDia, $fechaAno)){
                $errores[]='Error en Fecha Fin Vigencia En Fila '.$i;
            }
        }

        if(empty($descripcionTarifa)){
            $errores[] = 'Error en Descripcion Tarifa En Fila: '.$i;	
        }

        if(empty($producto)){
            $errores[] = 'Error en Producto En Fila: '.$i;	
        }

    }

    //var_dump($errores);

    $nombreFin = $nombreArchivo;
    $rutaErrores = "../../../archivos_nexuslink/contratistas/contratistas_archivos_tarifarios/errores/";
    $rutaFinErros = $rutaErrores.$nombreFin.".txt";

    /*=======================
    VALIDACION DE ERRORES
    ========================*/
    if(sizeof($errores)>0){

        $resl_vali = fopen("../../../archivos_nexuslink/contratistas/contratistas_archivos_tarifarios/errores/" . $nombreFin . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

        fwrite($resl_vali, $nombreFin . "\n");
        fwrite($resl_vali, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
        fwrite($resl_vali, "Validacion Cargue Archivo Tarifas\n");
        fwrite($resl_vali, "El archivo posee errores en las siguientes filas\n");
        fwrite($resl_vali, "-----------------------------------Errores----------------------------------------\n");

        for($i=0;$i<sizeof($errores);$i++){
            fwrite($resl_vali, $errores[$i]."\n");
        }

        fwrite($resl_vali, "------------------------ Fin Validacion-------------------------------------\n");

        fwrite($resl_vali, "\n");
        fwrite($resl_vali, "\n");
        fwrite($resl_vali, "------------------------ Cantidad de lineas Validadas " . ($NumFilas - 1) . " ----------------------\n");

        $respuesta = Connection::connectBatch()->prepare("UPDATE contratistas_contratista_tarifas_archivos_masivo SET ruta_archivo_errors = '$rutaFinErros', estado = 'ERROR', fecha_fin_valida = CURRENT_TIMESTAMP WHERE id_archivo_tarifas = $idBase");

        if($respuesta->execute()){

            echo "Ok, se guardo el archivo de errores.<br>";

        }else{

            echo "Error no se guardo archivo de errores.<br>";

        }
        
    }else{

        /*===================
        CAMBIAR ESTADO A SUBIR REGISTROS
        ===================*/
        $respuesta = Connection::connectOnly()->prepare("UPDATE contratistas_contratista_tarifas_archivos_masivo SET fecha_fin_valida = CURRENT_TIMESTAMP, estado = 'CARGAR' WHERE id_archivo_tarifas = $idBase");

        if($respuesta->execute()){

            echo "Se valido el archivo y no hubo errores.<br>";

        }else{

            echo "Error en la actualizacion del estado.<br>";

        }

    }


}
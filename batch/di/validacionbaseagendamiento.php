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
require "../../controllers/di/agendamiento.controller.php";
require "../../models/di/agendamiento.model.php";

//use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

$tiempo_inicio = microtime(true);

$archivoBase = ControladorAgendamiento::ctrObtenerArchivoCargar();
$idBase = $archivoBase["id_base"];
$nombreArchivo = $archivoBase["nombre_archivo"];
$rutaArchivo = $archivoBase["ruta_archivo"];

//ACTUALIZAR A ESTADO VALIDACIONES
$enValidacion = Connection::connectBatch()->prepare("UPDATE di_bases_pacientes SET estado = 'VALIDANDO', fecha_ini_valida = '$hoy' WHERE id_base = $idBase");
$enValidacion->execute();

if(empty($archivoBase)){

    echo 'No hay bases para cargar <br>';

}else{

    echo "Id Radicacion: {$idBase} - Nombre Archivo: {$nombreArchivo} - Ruta Archivo: {$rutaArchivo} <br><br>";

    $objPHPExcel = PHPEXCEL_IOFactory::load($rutaArchivo);
    $objPHPExcel->setActiveSheetIndex(0);
    $NumColum = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
    $NumFilas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow() - 1;

    echo "Letra Columna: {$NumColum} - Numero Filas: {$NumFilas} <br>";

    $errores = [];

    for($i = 2; $i <= $NumFilas; $i++){

        $fechaBase = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
        $agrupadorIps = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
        $ipsPrimario = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
        $nombreCompleto = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
        $edadAnios = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
        $sexo = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
        $tipoDoc = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
        $numeroDocumento = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
        $numeroCelular = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
        $numeroTelefono = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();
        $direccion = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getCalculatedValue();
        $cohortePrograma = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getCalculatedValue();
        $grupoRiesgo = $objPHPExcel->getActiveSheet()->getCell('M' . $i)->getCalculatedValue();
        $equipoProfesional = $objPHPExcel->getActiveSheet()->getCell('N' . $i)->getCalculatedValue();
        $regimen = $objPHPExcel->getActiveSheet()->getCell('O' . $i)->getCalculatedValue();


        if(!is_numeric($fechaBase) || empty($fechaBase)){
            $errores[] = 'Error en Fecha Base En Fila: '.$i;	
        }else{
            $fechaBase = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaBase));
            $fechaBase = date("Y-m-d", strtotime($fechaBase));
            $fecha=explode("-", $fechaBase);
            $fechaAno=$fecha[0];
            $fechaMes=$fecha[1];
            $fechaDia=$fecha[2];
            if(!checkdate($fechaMes, $fechaDia, $fechaAno)){
                $errores[]='Error en Fecha Base En Fila: '.$i;
            }
        }

        if(empty($agrupadorIps)){
            $errores[] = 'Error en Agrupador IPS En Fila: '.$i;	
        }

        if(empty($ipsPrimario)){
            $errores[] = 'Error en IPS Primario En Fila: '.$i;	
        }

        if(empty($nombreCompleto)){
            $errores[] = 'Error en Nombre Completo En Fila: '.$i;	
        }

        //if(empty($sexo)){
        //    $errores[] = 'Error en Sexo En Fila: '.$i;	
        //}

        if(empty($tipoDoc)){
           $errores[] = 'Error en Tipo Documento En Fila: '.$i;	
        }

        if(!is_numeric($numeroDocumento) || empty($numeroDocumento)){
            $errores[] = 'Error en Numero Documento En Fila: '.$i;	
        }

        if(!is_numeric($numeroDocumento) || empty($numeroDocumento)){
            $errores[] = 'Error en Numero Documento En Fila: '.$i;	
        }

        if(empty($cohortePrograma)){
            $errores[] = 'Error en Cohorte o Programa En Fila: '.$i;	
        }

        $arrayCohorte = ['MATERNO PERINATAL Y SSR', 'SALUD INFANTIL', 'VACUNACION', 'CRONICOS', 'PHD', 'ANTICOAGULADOS', 'NUTRICION', 'TRABAJO SOCIAL', 'PSICOLOGIA', 'RIESGO CARDIO VASCULAR'];

        if(!in_array(mb_strtoupper($cohortePrograma), $arrayCohorte)){
            $errores[] = 'Error en Cohorte diferente a las permitidas En Fila: '.$i;	
        }

        if(empty($grupoRiesgo)){
            $errores[] = 'Error en Grupo Riesgo En Fila: '.$i;	
        }

        if(empty($equipoProfesional)){
            $errores[] = 'Error en Equipo Profesional En Fila: '.$i;	
        }

        if(empty($regimen)){
            $errores[] = 'Error en Regimen En Fila: '.$i;	
        }


    }

    //var_dump($errores);

    $nombreFin = $nombreArchivo;
    $rutaErrores = "../../../archivos_vidamedical/di/agendamiento/archivos_bases_agendamiento/errores/";
    $rutaFinErros = $rutaErrores.$nombreFin.".txt";

    /*=======================
    VALIDACION DE ERRORES
    ========================*/
    if(sizeof($errores)>0){

        $resl_vali = fopen("../../../archivos_vidamedical/di/agendamiento/archivos_bases_agendamiento/errores/" . $nombreFin . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

        fwrite($resl_vali, $nombreFin . "\n");
        fwrite($resl_vali, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
        fwrite($resl_vali, "Validacion Cargue Base Agendamiento\n");
        fwrite($resl_vali, "El archivo posee errores en las siguientes filas\n");
        fwrite($resl_vali, "-----------------------------------Errores----------------------------------------\n");

        for($i=0;$i<sizeof($errores);$i++){
            fwrite($resl_vali, $errores[$i]."\n");
        }

        fwrite($resl_vali, "------------------------ Fin Validacion-------------------------------------\n");

        fwrite($resl_vali, "\n");
        fwrite($resl_vali, "\n");
        fwrite($resl_vali, "------------------------ Cantidad de lineas Validadas " . ($NumFilas - 1) . " ----------------------\n");

        $datos = array(

            "id_base" => $idBase,
            "ruta_archivo_errors" => $rutaFinErros,
            "fecha_fin_valida" => $hoy,
            "estado" => "ERROR"
        
        );

        $respuesta = ModelAgendamiento::mdlActualizarBaseAgendamiento("ERROR", $datos);

        if($respuesta == "ok"){

            echo "Ok, se guardo el archivo de errores.<br>";

        }else{

            echo "Error no se guardo archivo de errores.<br>";

        }
        
    }else{

        /*===================
        CAMBIAR ESTADO A SUBIR REGISTROS
        ===================*/
        $datos = array(

            "id_base" => $idBase,
            "fecha_fin_valida" => $hoy,
            "estado" => "CARGAR"

        );

        $respuesta = ModelAgendamiento::mdlActualizarBaseAgendamiento("CARGAR", $datos);

        if($respuesta == "ok"){

            echo "Se valido el archivo y no hubo errores.<br>";

        }else{

            echo "Error en la actualizacion del estado.<br>";

        }

    }


}
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
require "../../controllers/encuestas/encuestas.controller.php";
require "../../models/encuestas/encuestas.model.php";

//use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

$tiempo_inicio = microtime(true);

$archivoBase = ControladorEncuestas::ctrObtenerArchivoCargar();
$idBase = $archivoBase["id_base_encuesta"];
$nombreArchivo = $archivoBase["nombre_archivo"];
$rutaArchivo = $archivoBase["ruta_archivo"];
$tipoEncuestas = $archivoBase["tipo_encuestas"];

//ACTUALIZAR A ESTADO VALIDACIONES
$enValidacion = Connection::connectBatch()->prepare("UPDATE encuestas_bases_encuestas SET estado = 'VALIDANDO', fecha_ini_valida = CURRENT_TIMESTAMP WHERE id_base_encuesta = $idBase");
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

        $noHistoriaClinica = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
        $nombrePaciente = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
        $edad = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
        $sexo = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
        $especialidad = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
        $profesionalAuditado = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
        $sede = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
        $eps = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
        $fechaAtencion = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
        $modalidadConsulta = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();


        if(!is_numeric($noHistoriaClinica) || empty($noHistoriaClinica)){
            $errores[] = 'Error en Numero Historia Clinica En Fila: '.$i;	
        }

        if(empty($nombrePaciente)){
            $errores[] = 'Error en Nombre Paciente En Fila: '.$i;	
        }

        if(empty($edad)){
            $errores[] = 'Error en Edad En Fila: '.$i;	
        }

        if(empty($sexo)){
            $errores[] = 'Error en Sexo En Fila: '.$i;	
        }

        if(empty($especialidad)){
            $errores[] = 'Error en Especialidad En Fila: '.$i;	
        }

        if(empty($profesionalAuditado)){
            $errores[] = 'Error en Profesional Auditado En Fila: '.$i;	
        }

        if(empty($sede)){
            $errores[] = 'Error en Sede En Fila: '.$i;	
        }

        if(empty($eps)){
            $errores[] = 'Error en Eps En Fila: '.$i;	
        }

        if($fechaAtencion==''){
            $errores[]='Error en Fecha Publicacion En Fila '.$i;
        }else{

            // $fechaAtencion = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaPubli));
            $fechaAtencion = date("Y-m-d", strtotime($fechaAtencion."+ 1 days"));
            $fecha=explode("-", $fechaAtencion);
            $fechaAno=$fecha[0];
            $fechaMes=$fecha[1];
            $fechaDia=$fecha[2];

            if(!checkdate($fechaMes, $fechaDia, $fechaAno)){
                $errores[]='Error en Fecha Publicacion En Fila '.$i;
            }
        }

        if($tipoEncuestas == "VIH"){

            $arrayVih = array(
                "MEDICINA GENERAL",
                "INFECTOLOGIA"
            );
            
            if(!in_array($especialidad, $arrayVih)){
                $errores[]='Error en Especialidad no corresponde En Fila '.$i;
            }

        }else if($tipoEncuestas == "AUTOINMUNES"){

            $arrayAuto = array(
                "MEDICINA FAMILIAR",
                "REUMATOLOGIA",
                "MEDICINA GENERAL",
                "MEDICINA INTERNA"
            );

            if(!in_array($especialidad, $arrayAuto)){
                $errores[]='Error en Especialidad no corresponde En Fila '.$i;
            }

        }

        if(empty($modalidadConsulta)){
            $errores[] = 'Error en Modalidad Consulta En Fila: '.$i;	
        }

        $arraySexo = ['FEMENINO', 'MASCULINO'];
        if(!in_array(mb_strtoupper($sexo), $arraySexo)){
            $errores[] = 'Error en Sexo debe ser FEMININO o MASCULINO En Fila: '.$i;
        }


    }

    //var_dump($errores);

    $nombreFin = $nombreArchivo;
    $rutaErrores = "../../../archivos_nexuslink/encuestas/archivos_bases_encuestas/errores/";
    $rutaFinErros = $rutaErrores.$nombreFin.".txt";

    /*=======================
    VALIDACION DE ERRORES
    ========================*/
    if(sizeof($errores)>0){

        $resl_vali = fopen("../../../archivos_nexuslink/encuestas/archivos_bases_encuestas/errores/" . $nombreFin . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

        fwrite($resl_vali, $nombreFin . "\n");
        fwrite($resl_vali, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
        fwrite($resl_vali, "Validacion Cargue Base Encuestas\n");
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

            "id_base_encuesta" => $idBase,
            "ruta_archivo_errors" => $rutaFinErros,
            "fecha_fin_valida" => $hoy,
            "estado" => "ERROR"
        
        );

        $respuesta = ModelEncuestas::mdlActualizarBaseEncuestas("ERROR", $datos);

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

            "id_base_encuesta" => $idBase,
            "fecha_fin_valida" => $hoy,
            "estado" => "CARGAR"

        );

        $respuesta = ModelEncuestas::mdlActualizarBaseEncuestas("CARGAR", $datos);

        if($respuesta == "ok"){

            echo "Se valido el archivo y no hubo errores.<br>";

        }else{

            echo "Error en la actualizacion del estado.<br>";

        }

    }


}
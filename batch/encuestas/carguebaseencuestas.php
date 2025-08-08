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

$archivoBase = Connection::connectBatch()->prepare("SELECT * FROM encuestas_bases_encuestas WHERE estado = 'CARGAR' ORDER BY fecha_crea ASC LIMIT 1");
$archivoBase->execute();
$archivoBase = $archivoBase->fetch();
$idBase = $archivoBase["id_base_encuesta"];
$nombreArchivo = $archivoBase["nombre_archivo"];
$rutaArchivo = $archivoBase["ruta_archivo"];
$tipoEncuestas = $archivoBase["tipo_encuestas"];


//CAMBIAR ESTADO A CARGANDO
$cargando= Connection::connectOnly()->prepare("UPDATE encuestas_bases_encuestas set estado = 'CARGANDO', fecha_ini_carga = CURRENT_TIMESTAMP WHERE id_base_encuesta = $idBase"); 
$cargando->execute();

if(empty($archivoBase)){

    echo 'No hay bases para cargar <br>';

}else{

    echo "Id Radicacion: {$idBase} - Nombre Archivo: {$nombreArchivo} - Ruta Archivo: {$rutaArchivo} <br><br>";

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

        $date = $fechaAtencion;
        $date1 = DateTime::createFromFormat('Y-m-d', $date);
        
        if ($date1 !== false) {
            // El formato de la fecha y hora es 'd/m/Y h:i:s a'
            $fechaAtencion = $date1->format('Y-m-d H:i:s');
        } else {
            // El formato de la fecha y hora no es 'd/m/Y h:i:s a', vamos a intentar con 'd/m/Y'
            $date2 = DateTime::createFromFormat('d/m/Y', $date);
            if ($date2 !== false) {
                // El formato de la fecha y hora es 'd/m/Y'
                $fechaAtencion = $date2->format('Y-m-d');
            } else {
                // El formato de la fecha y hora no es ni 'd/m/Y h:i:s a' ni 'd/m/Y', intentamos con 'd-m-Y'
                $date3 = DateTime::createFromFormat('d-m-Y', $date);
                if ($date3 !== false) {
                    $fechaAtencion = $date3->format('Y-m-d');
                } else {
                    // Intentamos con 'd-m-Y h:i:s'
                    $date4 = DateTime::createFromFormat('d-m-Y h:i:s', $date);
                    if ($date4 !== false) {
                        $fechaAtencion = $date4->format('Y-m-d H:i:s');
                    } else {
                        $filaLfechaAtencionimpia = '00-00-00 00:00:00';
                        //throw new Exception("Formato de fecha y hora no válido");
                    }
                }
            }
        }

        $fechaAtencion = PHPExcel_Style_NumberFormat::toFormattedString($fechaAtencion,PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIMENICOLAS);

        $datosEncuestas = array(

            "id_base_encu" => $idBase,
            "no_historia_clinica" => $noHistoriaClinica,
            "nombre_paciente" => mb_strtoupper($nombrePaciente),
            "edad" => $edad,
            "sexo" => mb_strtoupper($sexo),
            "especialidad" => mb_strtoupper($especialidad),
            "profesional_auditado" => mb_strtoupper($profesionalAuditado),
            "sede" => mb_strtoupper($sede),
            "eps" => mb_strtoupper($eps),
            "fecha_atencion" => $fechaAtencion,
            "modalidad_consulta" => mb_strtoupper($modalidadConsulta),
            "tipo_encuesta" => $tipoEncuestas
            
        );

        $tabla = "encuestas_encuestas_procesos";

        $crearEncuesta = ModelEncuestas::mdlCrearEncuesta($tabla, $datosEncuestas);

        if($crearEncuesta == 'ok'){

            echo "Encuesta Guardada: {$i}.<br>";

        }else{

            echo "Error Carga Encuesta: {$i} <br>";
            // var_dump($crearEncuesta);
            $erroresCarga[] = 'No se cargo Encuesta en Fila: ' . $i . "<br>";

        }

    }

    if(sizeof($erroresCarga)>0){

        $rutaErrores = "../../../archivos_vidamedical/encuestas/archivos_bases_encuestas/errores_carga/";
        $rutaFinErros = $rutaErrores.$nombreArchivo.".txt";

        $resl_vali = fopen("../../../archivos_vidamedical/encuestas/archivos_bases_encuestas/errores_carga/" . $nombreArchivo . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

        fwrite($resl_vali, $nombreArchivo . "\n");
        fwrite($resl_vali, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
        fwrite($resl_vali, "Validacion Carga Pacientes Base Encuestas\n");
        fwrite($resl_vali, "El archivo posee errores en las siguientes filas\n");
        fwrite($resl_vali, "-----------------------------------Errores----------------------------------------\n");

        for($i=0;$i<sizeof($erroresCarga);$i++){
            fwrite($resl_vali, $erroresCarga[$i]."\n");
        }

        fwrite($resl_vali, "------------------------ Fin Validacion-------------------------------------\n");

        fwrite($resl_vali, "\n");
        fwrite($resl_vali, "\n");
        fwrite($resl_vali, "------------------------ Cantidad de lineas Validadas " . ($NumFilas - 1) . " ----------------------\n");

        $datos = array(

            "id_base_encuesta" => $idBase,
            "fecha_fin_carga" => $hoy,
            "ruta_archivo_errors" => $rutaFinErros,
            "estado" => "ERROR_CARGA"
        
        );

        $respuesta = ModelEncuestas::mdlActualizarBaseEncuestas("ERROR_CARGA", $datos);

        if($respuesta == "ok"){

            echo "Ok, se guardo el archivo de errores de carga.<br>";

        }else{

            echo "Error no se guardo archivo de errores de carga.<br>";

        }

    }else{

        $datos = array(

            "id_base_encuesta" => $idBase,
            "fecha_fin_carga" => $hoy,
            "estado" => "CARGADO"
        
        );

        $respuesta = ModelEncuestas::mdlActualizarBaseEncuestas("CARGADO", $datos);

        if($respuesta == "ok"){

            echo "Ok, Se cargaron las Encuestas<br>";

        }else{

            echo "Error no se actualizo el estado CARGADO.<br>";

        }


    }


}
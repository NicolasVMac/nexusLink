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

$archivoBase = Connection::connectBatch()->prepare("SELECT * FROM di_bases_pacientes WHERE estado = 'CARGAR' ORDER BY fecha_crea ASC LIMIT 1");
$archivoBase->execute();
$archivoBase = $archivoBase->fetch();
$idBase = $archivoBase["id_base"];
$nombreArchivo = $archivoBase["nombre_archivo"];
$rutaArchivo = $archivoBase["ruta_archivo"];


//CAMBIAR ESTADO A CARGANDO
$cargando= Connection::connectOnly()->prepare("UPDATE di_bases_pacientes set estado = 'CARGANDO', fecha_ini_carga = '$hoy' WHERE id_base = $idBase"); 
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

        $fechaBase  = PHPExcel_Style_NumberFormat::toFormattedString($fechaBase,PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIMENICOLAS2);
        if(empty($fechaNacimiento)){

            $fechaNacimiento = '0000-00-00';

        }

        /*=============================
        VALIDACION REGIMEN API
        =============================*/

        // if(!empty($tipoDoc) && !empty($numeroDocumento)){

            // $urlApi = 'http://127.0.0.1:8000/info/'.strtoupper($tipoDoc).'-'.$numeroDocumento.'';
            // $respuestaApi = file_get_contents($urlApi);
            // $datos = json_decode($respuestaApi, true);
            
            // if(!empty($datos["datos"]["paciente"])){
            //     $regimen = $datos["datos"]["paciente"]["regimen"];
            //     //echo $tipoDoc . " - ". $numeroDocumento . " - Regimen Paciente: " .  $datos["datos"]["paciente"]["regimen"] . "<br>";
            // }else{
            //     $regimen = "NO REGISTRA";
            // }
            
        $datosPacienteTemp = array(
            
            "id_base" => $idBase,
            "fecha_base" => $fechaBase,
            "agrupador_ips" => $agrupadorIps,
            "ips" => $ipsPrimario,
            "nombre_completo" => $nombreCompleto,
            "edad_anios" => $edadAnios,
            "sexo" => $sexo,
            "tipo_doc" => $tipoDoc,
            "numero_documento" => $numeroDocumento,
            "numero_celular" => $numeroCelular,
            "numero_fijo" => $numeroTelefono,
            "direccion" => $direccion,
            "regimen" => mb_strtoupper($regimen),
            "cohorte_programa" => mb_strtoupper($cohortePrograma),
            "grupo_riesgo" => mb_strtoupper($grupoRiesgo),
            "equipo_profesional" => mb_strtoupper($equipoProfesional)
        
        );
        
        $crearPacienteTemp = ModelAgendamiento::mdlCrearPacienteTemp($datosPacienteTemp);
        
        if($crearPacienteTemp == 'ok'){
            
            echo "Paciente Guardado: {$i}.<br>";
            
        }else{
            
            echo "Error Carga Paciente: {$i}"."<br>";
            //var_dump($crearPacienteTemp);
            $erroresCarga[] = 'No se cargo Paciente en Fila: ' . $i . "<br>";
            
        }

    }

    if(sizeof($erroresCarga)>0){

        //ELIMINAR REGISTROS DE BOLSA SI EXISTEN ERRORES
        $stmtDelete = Connection::connectBatch()->prepare("DELETE FROM di_bolsa_pacientes WHERE id_base = $idBase");
        $stmtDelete->execute();

        $rutaErrores = "../../../archivos_vidamedical/di/agendamiento/archivos_bases_agendamiento/errores_carga/";
        $rutaFinErros = $rutaErrores.$nombreArchivo.".txt";

        $resl_vali = fopen("../../../archivos_vidamedical/di/agendamiento/archivos_bases_agendamiento/errores_carga/" . $nombreArchivo . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

        fwrite($resl_vali, $nombreArchivo . "\n");
        fwrite($resl_vali, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
        fwrite($resl_vali, "Validacion Carga Pacientes Base Agendamiento\n");
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

            "id_base" => $idBase,
            "fecha_fin_carga" => $hoy,
            "ruta_archivo_errors" => $rutaFinErros,
            "estado" => "ERROR_CARGA"
        
        );

        $respuesta = ModelAgendamiento::mdlActualizarBaseAgendamiento("ERROR_CARGA", $datos);

        if($respuesta == "ok"){

            echo "Ok, se guardo el archivo de errores de carga.<br>";

        }else{

            echo "Error no se guardo archivo de errores de carga.<br>";

        }

    }else{

        $datos = array(

            "id_base" => $idBase,
            "fecha_fin_carga" => $hoy,
            "estado" => "CARGADO"
        
        );

        $respuesta = ModelAgendamiento::mdlActualizarBaseAgendamiento("CARGADO", $datos);

        if($respuesta == "ok"){

            echo "Ok, Se cargaron los pacientes<br>";

        }else{

            echo "Error no se actualizo el estado CARGADO.<br>";

        }


    }


}
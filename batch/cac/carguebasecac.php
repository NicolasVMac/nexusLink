<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
date_default_timezone_set('America/Bogota');
$hoy = date('Y-m-d H:i:s');

//$spout = "../../plugins/spout/src/Spout/Autoloader/autoload.php";
//require_once $spout;

// require_once "../../plugins/spout/src/Spout/Autoloader/autoload.php";
require_once "../../plugins/PHPExcel/IOFactory.php";
require_once "../../plugins/PHPExcel.php";

require "../../models/connection.php";
require "../../controllers/cac/cac.controller.php";
require "../../models/cac/cac.model.php";


$tiempo_inicio = microtime(true);

function convertirFecha($fecha){

    // echo "Vali Fecha: " . $fecha . "<br>";

    if(strlen($fecha) > 5){

        $newFecha = new DateTime($fecha);
        $newFecha = $newFecha->format("Y-m-d");

    }else{

        $newFechaUnix = ($fecha - 25569 + 1) * 86400;
        $newFecha = date("Y-m-d", $newFechaUnix);
    }

    return $newFecha;

}

function calcularEdad($fechaNacimiento){

    $fechaNacimiento = new DateTime($fechaNacimiento);

    $fechaActual = new DateTime();

    $edad = $fechaNacimiento->diff($fechaActual)->y;

    return $edad;


}

$archivoBase = Connection::connectBatch()->prepare("SELECT * FROM cac_cac_bases WHERE estado = 'SUBIDA' ORDER BY fecha_crea ASC LIMIT 1");
$archivoBase->execute();
$archivoBase = $archivoBase->fetch();


if(!$archivoBase){
    
    echo 'Nada Para Cargar <br/>';
    
}else{
    
    //ACTUALIZAR ESTADO PROCESANDO
    $stmtProcesando = Connection::connectBatch()->prepare("UPDATE cac_cac_bases SET estado = 'PROCESANDO', fecha_ini_cargado = '$hoy' WHERE id_base = :id_base");
    $stmtProcesando->bindParam(":id_base", $archivoBase["id_base"], PDO::PARAM_STR);
    $stmtProcesando->execute();
    
    echo '# Base CAC: ' . $archivoBase["id_base"] . ' - ' . $archivoBase["nombre_archivo"] . " - Cantidad: " . $archivoBase["cantidad"] . '<br><br>';

    $idBase = $archivoBase["id_base"];
    $nombreArchivo = $archivoBase["nombre_archivo"];
    $rutaArchivo = $archivoBase["ruta_archivo"];

    $objPHPExcel = PHPEXCEL_IOFactory::load($rutaArchivo);
    $objPHPExcel->setActiveSheetIndex(0);
    $NumColum = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
    $NumFilas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
    $cantidadRegistros = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow() - 1;
    $lastColumnIndex = PHPExcel_Cell::columnIndexFromString($NumColum);

    echo "Letra Columna: {$NumColum} - Numero Filas: {$cantidadRegistros} <br><br>";

    $cantidad = 100;
    $data = [];

    for($i = 2; $i <= $NumFilas; $i++){

        $rowData = [];
        // $rowData[] = $idBase;

        //ARRAY DE FECHAS PARA CONVERTIR EN FECHA REAL Y NO SE GUARDEN NUMEROS
        $arrayFechas = [9, 14, 19, 20, 21, 22, 23, 30, 41, 43, 45, 49, 50, 51, 53, 56, 63, 80, 88, 112, 120, 122, 123, 124, 127, 130, 132, 134, 136, 
                        148, 158, 166, 168, 171, 189, 193, 205, 207, 209, 211];

        for ($col = 0; $col < $lastColumnIndex; $col++) {
            // echo $cellValue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $i)->getCalculatedValue() . ' - ' . intval($col+1) . ' <br>';

            if(in_array($col, $arrayFechas)){

                // $cellValue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $i)->getCalculatedValue();
                
                $fecha = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $i)->getCalculatedValue();
                $cellValue = convertirFecha($fecha);

                //CALCULO FECHA NACIMIENTO
                if($col == 9){
                    $fechaNacimiento = calcularEdad($cellValue);
                }


            }else{

                $cellValue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $i)->getCalculatedValue();

            }


            // echo $cellValue . '-' . $col . "<br>";

            $rowData[] = $cellValue;

            //SE AGREGA FECHA NACIMIENTO DESPUESTE DE COL FECHA NACIMIENTO
            if ($col == 9 && isset($fechaNacimiento)) {
                $rowData[] = $fechaNacimiento;
            }
        }

        // print_r($rowData);

        $data[] = $rowData;
        

    }

    // print_r($data);

    $insertQueryCac1 = "INSERT INTO cac_cac_informacion_1 (id_base, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `32`, `33`, `34`, `35`, `36`, `37`, `38`, `39`, `40`, `41`, `42`, `43`, `44`, `45`, `46`, `47`, `48`, `49`, `50`, `51`, `52`, `53`, `54`, `55`, `56`, `57`, `58`, `59`, `60`, `61`, `62`, `63`, `64`, `65`, `66`, `67`, `68`, `69`, `70`) VALUES ";
    $insertQueryCac2 = "INSERT INTO cac_cac_informacion_2 (id_base, `71`, `72`, `73`, `74`, `75`, `76`, `77`, `78`, `79`, `80`, `81`, `82`, `83`, `84`, `85`, `86`, `87`, `88`, `89`, `90`, `91`, `92`, `93`, `94`, `95`, `96`, `97`, `98`, `99`, `100`, `101`, `102`, `103`, `104`, `105`, `106`, `107`, `108`, `109`, `110`, `111`, `112`, `113`, `114`, `115`, `116`, `117`, `118`, `119`, `120`, `121`, `122`, `123`, `124`, `125`, `126`, `127`, `128`, `129`, `130`, `131`, `132`, `133`, `134`, `135`, `136`, `137`, `138`, `139`, `140`) VALUES ";
    $insertQueryCac3 = "INSERT INTO cac_cac_informacion_3 (id_base, `141`, `142`, `143`, `144`, `145`, `146`, `147`, `148`, `149`, `150`, `151`, `152`, `153`, `154`, `155`, `156`, `157`, `158`, `159`, `160`, `161`, `162`, `163`, `164`, `165`, `166`, `167`, `168`, `169`, `170`, `171`, `172`, `173`, `174`, `175`, `176`, `177`, `178`, `179`, `180`, `181`, `182`, `183`, `184`, `185`, `186`, `187`, `188`, `189`, `190`, `191`, `192`, `193`, `194`, `195`, `196`, `197`, `198`, `199`, `200`, `201`, `202`, `203`, `204`, `205`, `206`, `207`, `208`, `209`, `210`, `211`, `212`, `213`) VALUES ";

    $batchData = [];
    $errorCarga = false;

    foreach ($data as $key => $rowValue) {


        /*===========================================
        CARGUE INFORMACION CAC 1
        ===========================================*/

        $rowLimitedCac1 = array_slice($rowValue, 0, 70);

        array_unshift($rowLimitedCac1, $idBase);

        $batchDataCac1[] = "(" . implode(", ", array_map(function($value){
            return Connection::connectBatch()->quote(addslashes($value));
        }, $rowLimitedCac1)) . ")";

        if(count($batchDataCac1) >= $cantidad || ($key + 1) == count($data)){

            $finalQuery1 = $insertQueryCac1 . implode(", ", $batchDataCac1);

            // echo "CAC QUERY 1: " . $finalQuery1 . "<br><br>";

            $stmt = Connection::connectBatch()->prepare("$finalQuery1");

            if($stmt->execute()){

                echo  'OK -> CAC_CAC_INFORMACION 1' . '<br><br>';

            }else{

                $datos = array(
                    "id_base" => $idBase,
                    "mensaje" => "ERROR CARGANDO INFORMACION CAC_CAC_INFORMACION_1"
                );

                ControladorCac::ctrRegistrarLogErrorCarga($datos);

                $errorCarga = true;

                echo  'ERROR -> CAC_CAC_INFORMACION 1' . '<br><br>';
                // var_dump($stmt->errorInfo());

            }


        }

        /*===========================================
        CARGUE INFORMACION CAC 2
        ===========================================*/

        $rowLimitedCac2 = array_slice($rowValue, 70, 70);

        array_unshift($rowLimitedCac2, $idBase);

        $batchDataCac2[] = "(" . implode(", ", array_map(function($value){
            return Connection::connectBatch()->quote(addslashes($value));
        }, $rowLimitedCac2)) . ")";

        if(count($batchDataCac2) >= $cantidad || ($key + 1) == count($data)){

            $finalQuery2 = $insertQueryCac2 . implode(", ", $batchDataCac2);

            // echo "CAC QUERY 2: " . $finalQuery2 . "<br><br>";

            $stmt = Connection::connectBatch()->prepare("$finalQuery2");

            if($stmt->execute()){

                echo  'OK -> CAC_CAC_INFORMACION 2' . '<br><br>';

            }else{

                $datos = array(
                    "id_base" => $idBase,
                    "mensaje" => "ERROR CARGANDO INFORMACION CAC_CAC_INFORMACION_2"
                );

                ControladorCac::ctrRegistrarLogErrorCarga($datos);

                $errorCarga = true;

                echo  'ERROR -> CAC_CAC_INFORMACION 2' . '<br><br>';
                // var_dump($stmt->errorInfo());

            }


        }


        /*===========================================
        CARGUE INFORMACION CAC 3
        ===========================================*/

        $rowLimitedCac3 = array_slice($rowValue, 140, 73);

        array_unshift($rowLimitedCac3, $idBase);

        $batchDataCac3[] = "(" . implode(", ", array_map(function($value){
            return Connection::connectBatch()->quote(addslashes($value));
        }, $rowLimitedCac3)) . ")";

        if(count($batchDataCac3) >= $cantidad || ($key + 1) == count($data)){

            $finalQuery3 = $insertQueryCac3 . implode(", ", $batchDataCac3);

            // echo "CAC QUERY 3: " . $finalQuery3 . "<br><br>";

            $stmt = Connection::connectBatch()->prepare("$finalQuery3");

            if($stmt->execute()){

                echo  'OK -> CAC_CAC_INFORMACION 3' . '<br><br>';

            }else{

                $datos = array(
                    "id_base" => $idBase,
                    "mensaje" => "ERROR CARGANDO INFORMACION CAC_CAC_INFORMACION_3"
                );

                ControladorCac::ctrRegistrarLogErrorCarga($datos);

                $errorCarga = true;

                echo  'ERROR -> CAC_CAC_INFORMACION 3' . '<br><br>';
                // var_dump($stmt->errorInfo());

            }


        }

        

    }
    
    //CARBIAR ESTADO BASE
    if($errorCarga){

        $stmtErrorCarga = Connection::connectBatch()->prepare("UPDATE cac_cac_bases SET estado = 'ERROR_CARGA', fecha_fin_cargado = '$hoy' WHERE id_base = :id_base");
        $stmtErrorCarga->bindParam(":id_base", $archivoBase["id_base"], PDO::PARAM_STR);
        $stmtErrorCarga->execute();

    }else{

        $stmtCargada = Connection::connectBatch()->prepare("UPDATE cac_cac_bases SET estado = 'CARGADA', fecha_fin_cargado = '$hoy' WHERE id_base = :id_base");
        $stmtCargada->bindParam(":id_base", $archivoBase["id_base"], PDO::PARAM_STR);
        $stmtCargada->execute();

    }


}
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

$archivoBase = Connection::connectBatch()->prepare("SELECT * FROM cac_cac_bases WHERE estado = 'CARGADA' ORDER BY fecha_crea ASC LIMIT 1");
$archivoBase->execute();
$archivoBase = $archivoBase->fetch();

if(!$archivoBase){
    
    echo 'Nada Para Validar <br/>';
    
}else{

    //ACTUALIZAR ESTADO PROCESANDO
    $stmtProcesando = Connection::connectBatch()->prepare("UPDATE cac_cac_bases SET estado = 'VALIDANDO', fecha_ini_validando = '$hoy' WHERE id_base = :id_base");
    $stmtProcesando->bindParam(":id_base", $archivoBase["id_base"], PDO::PARAM_STR);
    $stmtProcesando->execute();

    $array12 = ['H', 'M', 'I'];
    $array14 = ['1','2','3','4','5','6','7','8','9'];
    $array17 = ['1', '2', '3', '9'];
    $array28 = ['1', '2', '3', '4', '9'];
    $array31 = ['1', '2', '3', '4', '9'];
    $array41 = ['0','1','2','3','4','5','6','7','8','9'];
    $array61 = ['1','2','3','4','9'];
    $array117 = ['1','2','3','4','5','9'];
    $array118 = ['1','2'];
    $array119 = ['1','2'];
    $array120 = ['1','2'];
    $array121 = ['1','2'];
    $array143 = ['0','1', '9'];
    $array144 = ['1','2', '3', '5', '6'];
    $array145 = ['0','1', '9'];
    $array146 = ['1','2', '3', '5', '6'];
    $array147 = ['0','1', '9'];
    $array148 = ['1','2','3','4','5', '6', '7', '9'];
    $array149 = ['1','2','3','4','5', '6', '7', '8', '9'];
    $array172 = ['1','2','3','4','5', '6', '7', '9'];
    $array185 = ['1','2','3','4','5', '6', '7', '9', '98'];
    $array186 = ['1', '2', '3', '4', '9', '98'];
    $array187 = ['1', '2', '3', '4'];
    $array188 = ['1', '2', '3', '4', '9'];
    $array190 = ['1', '2', '3', '4', '5', '6', '9'];
    $array192 = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
    $array193 = ['1', '2', '3', '4', '9'];
    $array196 = ['1', '2', '3', '4', '5', '9', '10'];
    $array198 = ['1', '2', '3', '4', '5', '9'];
    $array199 = ['1', '2', '3', '4', '9'];
    // $array200 = ['96', '97', '98', '99', '101', '102'];
    $array203 = ['1', '2', '3', '4', '5', '6', '7', '9'];
    $array208 = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '20', '21', '22', '23'];
    $array212 = ['1', '2', '3', '4'];

    echo '# Base CAC: ' . $archivoBase["id_base"] . ' - ' . $archivoBase["nombre_archivo"] . " - Cantidad: " . $archivoBase["cantidad"] . '<br><br>';

    $infoCac = Connection::connectBatch()->prepare("SELECT * FROM cac_cac_informacion_1 JOIN cac_cac_informacion_2 ON cac_cac_informacion_1.id_cac_1 = cac_cac_informacion_2.id_cac_2 JOIN cac_cac_informacion_3 ON cac_cac_informacion_2.id_cac_2 = cac_cac_informacion_3.id_cac_3 WHERE
	    cac_cac_informacion_1.id_base = :id_base AND cac_cac_informacion_2.id_base = :id_base AND cac_cac_informacion_3.id_base = :id_base");

    $infoCac->bindParam(":id_base", $archivoBase["id_base"], PDO::PARAM_STR);
    $infoCac->execute();
    $infoCac = $infoCac->fetchAll();

    $errores = [];

    foreach ($infoCac as $keyCac => $valueCac){

        //VALIDACION SEDE
        if(strlen($valueCac["1"]) <= 0 || strlen($valueCac["1"]) > 10){

            $error = 'ERROR CAMPO SEDE LONGITUD ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION EPS
        if(strlen($valueCac["2"]) > 6){

            $errores[] = 'ERROR CAMPO EPS LONGITUD ID O FILA - ' . $valueCac["id_cac_1"];
        
        }

        //VALIDACION SEXO
        if(!in_array($valueCac["12"], $array12)){

            $errores[] = 'ERROR CAMPO EPS LONGITUD ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION POBLACION CLAVE
        if(!empty($valueCac["14"])){
            
            if(strlen($valueCac["14"]) > 1){
                
                $poblacionArray = str_split($valueCac["14"]);
                
                $isAscendente = true;
                
                for ($i=0; $i < count($poblacionArray) - 1; $i++) { 
                    
                    if ($poblacionArray[$i] > $poblacionArray[$i + 1]) {
                        $esAscendente = false;
                        $errores[] = 'ERROR CAMPO POBLACION CLAVE NO ES ASCENDENTE ID O FILA - ' . $valueCac["id_cac_1"];
                        break;
                        
                    }else{
                        
                        if(!in_array($poblacionArray[$i], $array14)){
                            $errores[] = 'ERROR CAMPO POBLACION CLAVE NO EXISTE POBLACION ID O FILA - ' . $valueCac["id_cac_1"];
                            break;
                        }
                        
                    }
                    
                }
            
            }else{

                if(!in_array($valueCac["14"], $array14)){
                    $errores[] = 'ERROR CAMPO POBLACION CLAVE NO EXISTE POBLACION ID O FILA - ' . $valueCac["id_cac_1"];
                    break;
                }
                
            }

        }else{

            $errores[] = 'ERROR CAMPO POBLACION CLAVE VACIO ID O FILA - ' . $valueCac["id_cac_1"];
            
        }

        //VALIDACION MUJER GESTANTE
        if(!empty($valueCac["17"])){
            
            if($valueCac["17"] == 9 && $valueCac["12"] != "H"){
                
                $errores[] = 'ERROR CAMPO MUJER GESTANTE SEXO DIFERENTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

            if(!in_array($valueCac["17"], $array17)){

                $errores[] = 'ERROR CAMPO MUJER GESTANTE NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO POBLACION CLAVE VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION RECIBIO TRATAMIENTO PARA VIH DURANTE GESTION REPORTADA
        if(!empty($valueCac["28"])){

            if(!in_array($valueCac["28"], $array28)){

                $errores[] = 'ERROR CAMPO RECIBIO TRATAMIENTO PARA VIH DURANTE GESTION REPORTADA NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO RECIBIO TRATAMIENTO PARA VIH DURANTE GESTION REPORTADA VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION RESULTADO DE LA GESTION REPORTADA EN GESTANTES CON VIH
        if(!empty($valueCac["31"])){

            if(!in_array($valueCac["31"], $array31)){

                $errores[] = 'ERROR CAMPO RESULTADO DE LA GESTION REPORTADA EN GESTANTES CON VIH NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO RESULTADO DE LA GESTION REPORTADA EN GESTANTES CON VIH VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION FECHA CULMINACION DE LA GESTION REPORTADA EN GESTANTES CON VIH
        if(empty($valueCac["32"])){

            $errores[] = 'ERROR CAMPO FECHA CULMINACION DE LA GESTION REPORTADA VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION PROFILAXIS ANTIRRETROVIRALES RECIEN NACIDO VIVO EXPUESTO VIH
        if(!empty($valueCac["41"]) || $valueCac["41"] != ''){

            if(!in_array($valueCac["41"], $array41)){

                $errores[] = 'ERROR CAMPO PROFILAXIS ANTIRRETROVIRALES RECIEN NACIDO VIVO EXPUESTO VIH NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO PROFILAXIS ANTIRRETROVIRALES RECIEN NACIDO VIVO EXPUESTO VIH VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION FECHA PRIMERA CARGA VIRAL VIH MENOR DE 12 MESES EXPUESTO VIH
        if(empty($valueCac["43"])){

            $errores[] = 'ERROR CAMPO FECHA PRIMERA CARGA VIRAL VIH MENOR DE 12 MESES EXPUESTO VIH VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION FECHA SEGUNDA CARGA VIRAL VIH MEJOR DE 12 MESES EXPUESTO VIH
        if(empty($valueCac["45"])){

            $errores[] = 'ERROR CAMPO FECHA SEGUNDA CARGA VIRAL VIH MEJOR DE 12 MESES EXPUESTO VIH VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION FECHA DIAGNOSTICO DE TUBERCULOSIS ACTIVA REPORTADA
        if(empty($valueCac["51"])){

            $errores[] = 'ERROR CAMPO FECHA DIAGNOSTICO DE TUBERCULOSIS ACTIVA REPORTADA VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION FECHA PRUEBA PRESUNTIVA INFECCION VIH
        if(empty($valueCac["53"])){

            $errores[] = 'ERROR CAMPO FECHA PRUEBA PRESUNTIVA INFECCION VIH VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION FECHA CONFIRMACION DIAGNOSTICO DE INFECCION VIH
        if(empty($valueCac["55"])){

            $errores[] = 'ERROR CAMPO FECHA CONFIRMACION DIAGNOSTICO DE INFECCION VIH VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION CONTEO LINFOCITOS T CD4 MOMENTO DIAGNOSTICO
        if(!empty($valueCac["61"])){

            if(!in_array($valueCac["61"], $array31)){

                $errores[] = 'ERROR CAMPO CONTEO LINFOCITOS T CD4 MOMENTO DIAGNOSTICO NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO CONTEO LINFOCITOS T CD4 MOMENTO DIAGNOSTICO VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION CONTEO LINFOCITOS T CD4 MOMENTO DIAGNOSTICO
        if(empty($valueCac["62"])){

            $errores[] = 'ERROR CAMPO CONTEO LINFOCITOS T CD4 MOMENTO DIAGNOSTICO VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION FECHA INICIO TERAPIA ANTIRRETROVIRAL (TAR)
        if(empty($valueCac["65"])){

            $errores[] = 'ERROR CAMPO FECHA INICIO TERAPIA ANTIRRETROVIRAL (TAR) VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION FECHA PRIMER CAMBIO MEDICAMENTO ESQUEMA TAR
        if(empty($valueCac["82"])){

            $errores[] = 'ERROR CAMPO FECHA PRIMER CAMBIO MEDICAMENTO ESQUEMA TAR VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        //VALIDACION VALORACION INFECTOLOGO ULTIMOS 12 MESES
        if(!empty($valueCac["117"])){

            if(!in_array($valueCac["117"], $array117)){

                $errores[] = 'ERROR CAMPO VALORACION INFECTOLOGO ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO VALORACION INFECTOLOGO ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION VALORACION MEDICO EXPERTO ULTIMOS 12 MESES
        if(!empty($valueCac["118"])){

            if(!in_array($valueCac["118"], $array118)){

                $errores[] = 'ERROR CAMPO VALORACION MEDICO EXPERTO ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO VALORACION MEDICO EXPERTO ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION VALORACION QUIMICO FARMACEUTICO ULTIMOS 12 MESES
        if(!empty($valueCac["119"])){

            if(!in_array($valueCac["119"], $array119)){

                $errores[] = 'ERROR CAMPO VALORACION QUIMICO FARMACEUTICO ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO VALORACION QUIMICO FARMACEUTICO ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION VALORACION ODONTOLOGIA ULTIMOS 12 MESES
        if(!empty($valueCac["120"])){

            if(!in_array($valueCac["120"], $array120)){

                $errores[] = 'ERROR CAMPO VALORACION ODONTOLOGIA ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO VALORACION ODONTOLOGIA ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION VALORACION PSICOLOGIA O TRABAJO SOCIAL O ENFERMERIA ULTIMOS 12 MESES
        if(!empty($valueCac["121"])){

            if(!in_array($valueCac["121"], $array121)){

                $errores[] = 'ERROR CAMPO VALORACION PSICOLOGIA O TRABAJO SOCIAL O ENFERMERIA ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO VALORACION PSICOLOGIA O TRABAJO SOCIAL O ENFERMERIA ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION FECHA ULTIMA GENOTIPIFICACION REALIZADA
        if(empty($valueCac["122"])){

            $errores[] = 'ERROR CAMPO VALORACION PSICOLOGIA O TRABAJO SOCIAL O ENFERMERIA ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }

        
        //VALIDACION FECHA ULTIMO COLESTEROL LDL
        if(empty($valueCac["124"])){

            $errores[] = 'ERROR CAMPO FECHA ULTIMO COLESTEROL LDL VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION FECHA ULTIMA ENZIMA ALANINA AMINOTRANSFERASA
        if(empty($valueCac["132"])){

            $errores[] = 'ERROR CAMPO FECHA ULTIMA ENZIMA ALANINA AMINOTRANSFERASA VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION FECHA ULTIMA CREATINA SERICA
        if(empty($valueCac["134"])){

            $errores[] = 'ERROR CAMPO FECHA ULTIMA CREATINA SERICA VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION FECHA ULTIMA GLUCEMIA SERICA AYUNO
        if(empty($valueCac["136"])){

            $errores[] = 'ERROR CAMPO FECHA ULTIMA GLUCEMIA SERICA AYUNO VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION TIENE COINFECCION HEPATITIS B CRONICA
        if(!empty($valueCac["143"]) || $valueCac["143"] != ''){

            if(!in_array($valueCac["143"], $array143)){

                $errores[] = 'ERROR CAMPO TIENE COINFECCION HEPATITIS B CRONICA NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO TIENE COINFECCION HEPATITIS B CRONICA VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION RECIBIO TRATAMIENTO PARA VHB
        if(!empty($valueCac["144"])){

            if(!in_array($valueCac["144"], $array144)){

                $errores[] = 'ERROR CAMPO RECIBIO TRATAMIENTO PARA VHB NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO RECIBIO TRATAMIENTO PARA VHB VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION TIENE COINFECCION HEPATITIS C CRONICA
        if(!empty($valueCac["145"]) || $valueCac["145"] != ''){

            if(!in_array($valueCac["145"], $array145)){

                $errores[] = 'ERROR CAMPO TIENE COINFECCION HEPATITIS C CRONICA NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO TIENE COINFECCION HEPATITIS C CRONICA VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION RECIBIO TRATAMIENTO VHC
        if(!empty($valueCac["146"])){

            if(!in_array($valueCac["146"], $array146)){

                $errores[] = 'ERROR CAMPO RECIBIO TRATAMIENTO VHC NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO RECIBIO TRATAMIENTO VHC VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION TIENE O TUVO COINFECCION TUBERCULOSIS ACTIVA ULTIMOS 12 MESES
        if(!empty($valueCac["147"]) || $valueCac["147"] != ''){

            if(!in_array($valueCac["147"], $array147)){

                $errores[] = 'ERROR CAMPO TIENE O TUVO COINFECCION TUBERCULOSIS ACTIVA ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO TIENE O TUVO COINFECCION TUBERCULOSIS ACTIVA ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION TIPO TUBERCULOSIS ACTIVA PRESENTA O PRESENTO PERSONA CON COINFECCION TB-VIH ULTIMOS 12 MESES
        if(!empty($valueCac["148"])){

            if(!in_array($valueCac["148"], $array148)){

                $errores[] = 'ERROR CAMPO TIPO TUBERCULOSIS ACTIVA PRESENTA O PRESENTO PERSONA CON COINFECCION TB VIH ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO TIPO TUBERCULOSIS ACTIVA PRESENTA O PRESENTO PERSONA CON COINFECCION TB VIH ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION PERSONA COINFECCION TB-VIH RECIBE O RECIBIO TRATAMIENTO TUBERCULOSIS ACTIVA ULTIMOS 12 MESES
        if(!empty($valueCac["149"])){

            if(!in_array($valueCac["149"], $array149)){

                $errores[] = 'ERROR CAMPO PERSONA COINFECCION TB VIH RECIBE O RECIBIO TRATAMIENTO TUBERCULOSIS ACTIVA ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO PERSONA COINFECCION TB VIH RECIBE O RECIBIO TRATAMIENTO TUBERCULOSIS ACTIVA ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION FECHA ULTIMO CONTEO LINFOCITOS T CD4 REALIZADO PERIODO OBSERVACION
        if(!isset($valueCac["168"]) || $valueCac["168"] == ''){

            $errores[] = 'ERROR CAMPO FECHA ULTIMO CONTEO LINFOCITOS T CD4 REALIZADO PERIODO OBSERVACION VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        // //VALIDACION VALOR ULTIMO CONTEO LINFOCITOS T CD4 REALIZADO PERIODO OBSERVACION
        if(!isset($valueCac["169"]) || $valueCac["169"] == ''){

            $errores[] = 'ERROR CAMPO VALOR ULTIMO CONTEO LINFOCITOS T CD4 REALIZADO PERIODO OBSERVACION VACIO ID O FILA - ' . $valueCac["id_cac_1"];            

        }


        //VALIDACION FECHA ULTIMA CARGA VIRAL VIH REALIZADA PERIODO OBSERVACION
        if(!isset($valueCac["170"]) || $valueCac["170"] == ''){

            $errores[] = 'ERROR CAMPO FECHA ULTIMA CARGA VIRAL VIH REALIZADA PERIODO OBSERVACION VACIO ID O FILA - ' . $valueCac["id_cac_1"];            

        }


        //VALIDACION VALOR ULTIMA CARGA VIRAL VIH REALIZADA PERIODO OBSERVACION
        if(!isset($valueCac["171"]) || $valueCac["171"] === ''){
            
            $errores[] = 'ERROR CAMPO VALOR ULTIMA CARGA VIRAL VIH REALIZADA PERIODO OBSERVACION VACIO ID O FILA - ' . $valueCac["id_cac_1"];            

        }


        //VALIDACION RECIBE TAR
        if(!empty($valueCac["172"])){

            if(!in_array($valueCac["172"], $array172)){

                $errores[] = 'ERROR CAMPO RECIBE TAR NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO RECIBE TAR VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION NUMERO MESES DISPENSO FORMULA COMPLETA TAR DURANTE 12 ULTIMOS MESES
        if(empty($valueCac["180"]) || $valueCac["180"] == ''){

            $errores[] = 'ERROR CAMPO NUMERO MESES DISPENSO FORMULA COMPLETA TAR DURANTE 12 ULTIMOS MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];            

        }


        //VALIDACION VACUNACION CONTRA HEPATITIS B
        if(!empty($valueCac["185"])){

            if(!in_array($valueCac["185"], $array185)){

                $errores[] = 'ERROR CAMPO VACUNACION CONTRA HEPATITIS B NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO VACUNACION CONTRA HEPATITIS B VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION VACUNACION CONTRA NEUMOCOCO
        if(!empty($valueCac["186"])){

            if(!in_array($valueCac["186"], $array186)){

                $errores[] = 'ERROR CAMPO VACUNACION CONTRA NEUMOCOCO NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO VACUNACION CONTRA NEUMOCOCO VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION VACUNACION CONTRA INFLUENZA
        if(!empty($valueCac["187"])){

            if(!in_array($valueCac["187"], $array187)){

                $errores[] = 'ERROR CAMPO VACUNACION CONTRA INFLUENZA NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO VACUNACION CONTRA INFLUENZA VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION VACUNACION CONTRA VPH
        if(!empty($valueCac["188"])){

            if(!in_array($valueCac["188"], $array188)){

                $errores[] = 'ERROR CAMPO VACUNACION CONTRA VPH NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO VACUNACION CONTRA VPH VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION HIZO PDD PRUEBAS EQUIVALENTES IDENTIFICACION TUBERCULOSIS LATENTE ULTIMOS 12 MESES
        if(!empty($valueCac["190"])){

            if(!in_array($valueCac["190"], $array190)){

                $errores[] = 'ERROR CAMPO HIZO PDD PRUEBAS EQUIVALENTES IDENTIFICACION TUBERCULOSIS LATENTE ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO HIZO PDD PRUEBAS EQUIVALENTES IDENTIFICACION TUBERCULOSIS LATENTE ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION RECIBIO TRATAMIENTO TUBERCULOSIS LATENTE ULTIMOS 12 MESES
        if(!empty($valueCac["192"])){

            if(!in_array($valueCac["192"], $array192)){

                $errores[] = 'ERROR CAMPO RECIBIO TRATAMIENTO TUBERCULOSIS LATENTE ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO RECIBIO TRATAMIENTO TUBERCULOSIS LATENTE ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION REALIZO TAMIZAJE SIFILIS PERSONA VIVE VIH ULTIMOS 12 MESES
        if(!empty($valueCac["193"])){

            if(!in_array($valueCac["193"], $array193)){

                $errores[] = 'ERROR CAMPO REALIZO TAMIZAJE SIFILIS PERSONA VIVE VIH ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO REALIZO TAMIZAJE SIFILIS PERSONA VIVE VIH ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION REALIZO TAMIZAJE VPH ANOGENITAL PERSONA VIVE VIH ULTIMOS 12 MESES
        if(!empty($valueCac["196"])){

            if(!in_array($valueCac["196"], $array196)){

                $errores[] = 'ERROR CAMPO REALIZO TAMIZAJE VPH ANOGENITAL PERSONA VIVE VIH ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO REALIZO TAMIZAJE VPH ANOGENITAL PERSONA VIVE VIH ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION REALIZO TAMIZAJE HEPATITIS B PERSONA VIVE VIH ULTIMOS 12 MESES
        if(!empty($valueCac["198"])){

            if(!in_array($valueCac["198"], $array198)){

                $errores[] = 'ERROR CAMPO REALIZO TAMIZAJE HEPATITIS B PERSONA VIVE VIH ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO REALIZO TAMIZAJE HEPATITIS B PERSONA VIVE VIH ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION TAMIZAJE HEPATITIS C PERSONA VIVE VIH ULTIMOS 12 MESES
        if(!empty($valueCac["199"])){

            if(!in_array($valueCac["199"], $array199)){

                $errores[] = 'ERROR CAMPO TAMIZAJE HEPATITIS C PERSONA VIVE VIH ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO TAMIZAJE HEPATITIS C PERSONA VIVE VIH ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION RESULTADO EVALUACION RIESGO CARDIOVASCULAR PERSONA VIVA VIH ULTIMOS 12 MESES
        if(!empty($valueCac["200"])){

            if(!intval($valueCac["200"]) > 0 && intval($valueCac["200"]) <= 100){

                $errores[] = 'ERROR CAMPO RESULTADO EVALUACION RIESGO CARDIOVASCULAR PERSONA VIVA VIH ULTIMOS 12 MESES NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO RESULTADO EVALUACION RIESGO CARDIOVASCULAR PERSONA VIVA VIH ULTIMOS 12 MESES VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION PROFILAXIS PNEUMOCRYSTIS JIROVECII
        if(!empty($valueCac["203"])){

            if(!in_array($valueCac["203"], $array203)){

                $errores[] = 'ERROR CAMPO PROFILAXIS PNEUMOCRYSTIS JIROVECII NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO PROFILAXIS PNEUMOCRYSTIS JIROVECII VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION NUMERO HOSPITALIZACIONES PERIODO RELACIONADAS VIH
        if (isset($valueCac["206"]) && $valueCac["206"] !== '') {

            $valor = intval($valueCac["206"]);

            if ($valor < 0 || $valor > 100) {

                $errores[] = 'ERROR CAMPO NUMERO HOSPITALIZACIONES PERIODO RELACIONADAS VIH FUERA DE RANGO (0-100) ID O FILA - ' . $valueCac["id_cac_1"];
            
            }
            
        }else{

            $errores[] = 'ERROR CAMPO NUMERO HOSPITALIZACIONES PERIODO RELACIONADAS VIH VACIO ID O FILA - ' . $valueCac["id_cac_1"];
        
        }


        //VALIDACION NOVEDAD USUARIO RESPECTO REPORTE ANTERIOR
        if(!empty($valueCac["208"])){

            if(!in_array($valueCac["208"], $array208)){

                $errores[] = 'ERROR CAMPO NOVEDAD USUARIO RESPECTO REPORTE ANTERIOR NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO NOVEDAD USUARIO RESPECTO REPORTE ANTERIOR VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


        //VALIDACION CAUSA MUERTE
        if(!empty($valueCac["212"])){

            if(!in_array($valueCac["212"], $array212)){

                $errores[] = 'ERROR CAMPO CAUSA MUERTE NO EXISTE ID O FILA - ' . $valueCac["id_cac_1"];

            }

        }else{

            $errores[] = 'ERROR CAMPO CAUSA MUERTE VACIO ID O FILA - ' . $valueCac["id_cac_1"];

        }


    }

    $erroresValidando = false;
    $nombreFin = $archivoBase["nombre_archivo"];
    $rutaErrores = "../../../archivos_vidamedical/cac/archivos_bases_cac/errores/";
    $rutaFinErros = $rutaErrores.$nombreFin.".txt";

    if(sizeof($errores) > 0){

        $resl_vali = fopen("../../../archivos_vidamedical/cac/archivos_bases_cac/errores/" . $nombreFin . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

        fwrite($resl_vali, $nombreFin . "\n");
        fwrite($resl_vali, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
        fwrite($resl_vali, "Validacion Cargue Informacion CAC\n");
        fwrite($resl_vali, "El archivo posee errores en las siguientes filas\n");
        fwrite($resl_vali, "-----------------------------------Errores----------------------------------------\n");

        for($i=0;$i<sizeof($errores);$i++){
            fwrite($resl_vali, $errores[$i]."\n");
        }

        fwrite($resl_vali, "------------------------ Fin Validacion-------------------------------------\n");

        fwrite($resl_vali, "\n");
        fwrite($resl_vali, "\n");
        fwrite($resl_vali, "------------------------ Cantidad de lineas Validadas " . (count($infoCac)) . " ----------------------\n");

        $datosBase = array(

            "id_base" => $archivoBase["id_base"],
            "ruta_archivo_errores" => $rutaFinErros,
        
        );

        $respuesta = ControladorCac::ctrGuardarRutaErroresVali($datosBase);

        echo "SE ENCONTRARON: " . sizeof($errores) . " ERRORES";

        $erroresValidando = true;

        $datosLog = array();
        $arrayIdCac = [];

        foreach ($errores as $key => $valueError) {

            $arrayIdCac[] = explode("-", $valueError)[1];

            $datosLog = array(
                "id_base" => $archivoBase["id_base"],
                "mensaje" => mb_strtoupper($valueError)
            );

            ControladorCac::ctrRegistrarLogErrorValidacion($datosLog);

        }

        $arrayIdCacUnique = array_unique($arrayIdCac);

        //MARCAR iD CAC CON ERRORES
        foreach ($arrayIdCacUnique as $key => $valueCac) {

            $datosCac1 = array(
                "estado" => "ERROR",
                "column_id" => "id_cac_1",
                "id_cac" => $valueCac
            );
            ControladorCac::ctrMarcarErrorIdCac("cac_cac_informacion_1", $datosCac1);

            $datosCac2 = array(
                "estado" => "ERROR",
                "column_id" => "id_cac_2",
                "id_cac" => $valueCac
            );
            ControladorCac::ctrMarcarErrorIdCac("cac_cac_informacion_2", $datosCac2);

            $datosCac3 = array(
                "estado" => "ERROR",
                "column_id" => "id_cac_3",
                "id_cac" => $valueCac
            );
            ControladorCac::ctrMarcarErrorIdCac("cac_cac_informacion_3", $datosCac3);


        }


    }


    if($erroresValidando){

        $stmtErrores = Connection::connectBatch()->prepare("UPDATE cac_cac_bases SET estado = 'VALIDADO_ERRORES', fecha_fin_validando = '$hoy' WHERE id_base = :id_base");
        $stmtErrores->bindParam(":id_base", $archivoBase["id_base"], PDO::PARAM_STR);
        $stmtErrores->execute();

    }else{

        $stmtOK = Connection::connectBatch()->prepare("UPDATE cac_cac_bases SET estado = 'VALIDADO_OK', fecha_fin_validando = '$hoy' WHERE id_base = :id_base");
        $stmtOK->bindParam(":id_base", $archivoBase["id_base"], PDO::PARAM_STR);
        $stmtOK->execute();

    }


}
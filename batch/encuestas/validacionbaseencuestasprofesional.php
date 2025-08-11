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
require "../../controllers/encuestas/encuestas-profesional.controller.php";
require "../../models/encuestas/encuestas-profesional.model.php";

//use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

$tiempo_inicio = microtime(true);

$archivoBase = ControladorEncuestasProfesional::ctrObtenerArchivoCargar();
$idBase = $archivoBase["id_base_encuesta"];
$nombreArchivo = $archivoBase["nombre_archivo"];
$rutaArchivo = $archivoBase["ruta_archivo"];
$especialidadArchivo = $archivoBase["especialidad"];

//ACTUALIZAR A ESTADO VALIDACIONES
$enValidacion = Connection::connectBatch()->prepare("UPDATE encuestas_bases_encuestas_profesional SET estado = 'VALIDANDO', fecha_ini_valida = CURRENT_TIMESTAMP WHERE id_base_encuesta = $idBase");
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
        $modalidadConsultaoTipoAtencion = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();


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

        if(!is_numeric($fechaAtencion)||$fechaAtencion==''){
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

        if($especialidadArchivo == $especialidad){

            $arrayEspecialidad = array(
                "ANESTESIOLOGIA",
                "DERMATOLOGIA",
                "FISIATRA",
                "PALIATIVISTA",
                "T. ALTERNATIVAS",
                "PSIQUIATRIA DOLOR",
                "MEDICO ESPECIALISTA FAMILIAR",
                "MEDICO GENERAL DOLOR",
                "MEDICO INTERNISTA",
                "MEDICO REUMATOLOGO",
                "PSIQUIATRIA VIH",
                "MEDICO GENERAL VIH",
                "INFECTOLOGIA",
                "INFECTOPEDIATRIA",
            );
            
            if(!in_array($especialidad, $arrayEspecialidad)){
                $errores[]='Error en Especialidad no corresponde En Fila '.$i;
            }

        }else{

            $errores[]='Error en Especialidad diferente a Especialidad Base En Fila '.$i;

        }


        if(empty($modalidadConsultaoTipoAtencion)){
            $errores[] = 'Error en Modalidad Consulta o Tipo Servicio En Fila: '.$i;	
        }

        $arraySexo = ['F', 'M'];
        if(!in_array(mb_strtoupper($sexo), $arraySexo)){
            $errores[] = 'Error en Sexo debe ser F o M En Fila: '.$i;
        }


    }

    //var_dump($errores);

    $nombreFin = $nombreArchivo;
    $rutaErrores = "../../../archivos_nexuslink/encuestas/archivos_bases_encuestas_profesional/errores/";
    $rutaFinErros = $rutaErrores.$nombreFin.".txt";

    /*=======================
    VALIDACION DE ERRORES
    ========================*/
    if(sizeof($errores)>0){

        $resl_vali = fopen("../../../archivos_nexuslink/encuestas/archivos_bases_encuestas_profesional/errores/" . $nombreFin . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

        fwrite($resl_vali, $nombreFin . "\n");
        fwrite($resl_vali, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
        fwrite($resl_vali, "Validacion Cargue Base Encuestas Profesional\n");
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

        $respuesta = ModelEncuestasProfesional::mdlActualizarBaseEncuestas("ERROR", $datos);

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

        $respuesta = ModelEncuestasProfesional::mdlActualizarBaseEncuestas("CARGAR", $datos);

        if($respuesta == "ok"){

            echo "Se valido el archivo y no hubo errores.<br>";

        }else{

            echo "Error en la actualizacion del estado.<br>";

        }

    }


}
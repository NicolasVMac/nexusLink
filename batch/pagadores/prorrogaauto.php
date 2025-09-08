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
require "../../controllers/pagadores/pagadores.controller.php";
require "../../models/pagadores/pagadores.model.php";

$contratosVencidos = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagadores_contratos WHERE fecha_fin_real < NOW() AND active = 1");
$contratosVencidos->execute();
$contratosVencidos = $contratosVencidos->fetchAll();


if(empty($contratosVencidos)){

    echo 'NO SE ENCUENTRAN CONTRATOS VENCIDOS<br>';

}else{

    foreach ($contratosVencidos as $key => $valueCon) {


        //OBTENER PRORROGA DISPONIBLE CONTRATO
        $getProrrogaContrato = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagadores_contratos_prorrogas WHERE id_contrato = {$valueCon['id_contrato']} AND is_active = 1 AND estado = 'DISPONIBLE' ORDER BY id_prorroga ASC LIMIT 1");
        $getProrrogaContrato->execute();
        $getProrrogaContrato = $getProrrogaContrato->fetch();

        if(!empty($getProrrogaContrato)){

            //APLICAR PRORROGA
            $datosProrroga = array(
                "id_contrato" => $valueCon["id_contrato"],
                "id_prorroga" => $getProrrogaContrato["id_prorroga"],
                "prorroga_meses" => $getProrrogaContrato["prorroga_meses"], 
                "usuario_crea" => $getProrrogaContrato["usuario_crea"],
            );
    
            $resultado = ControladorPagadores::ctrAplicarProrrogaContrato($datosProrroga);
    
            if($resultado == 'ok'){
    
                echo "Prorroga Automatica Aplicada a Id Contrato: {$valueCon['id_contrato']} - Nombre Contrato: {$valueCon['nombre_contrato']} - Tiempo Prorroga: {$getProrrogaContrato['prorroga_meses']} <br>";
                
            }else{
                
                echo "Error Cargando la Prorroga Automatica Aplicada a Id Contrato: {$valueCon['id_contrato']} - Nombre Contrato: {$valueCon['nombre_contrato']} - Tiempo Prorroga: {$getProrrogaContrato['prorroga_meses']} <br>";
    
            }

        }else{

            echo "El Id Contrato: {$valueCon['id_contrato']} no tiene prorrogas creadas. <br>";

        }



    }



}
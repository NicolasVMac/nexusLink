<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
date_default_timezone_set('America/Bogota');
$hoy = date('Y-m-d H:i:s');


require "../../models/connection.php";

//use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

//INFO DI VALIDACIONES
$infoValidar = Connection::connectBatch()->prepare("SELECT * FROM di_validacion_famisanar WHERE estado = 'CREADO'");
$infoValidar->execute();
$datos = $infoValidar->fetchAll();

if(empty($datos)){

    echo 'No hay datos para validar <br>';

}else{


    foreach ($datos as $key => $valueDato) {


        $urlApi = 'http://127.0.0.1:8000/info/'.strtoupper($valueDato["tipo_documento"]).'-'.$valueDato["numero_documento"];
        $respuestaApi = file_get_contents($urlApi);
        $datos = json_decode($respuestaApi, true);

        if(!empty($datos["datos"]["paciente"])){

            $datosPaciente = array(
                "id" => $valueDato["id"],
                "nombre_1" => $datos["datos"]["paciente"]["nombre1"],
                "nombre_2" => $datos["datos"]["paciente"]["nombre2"],
                "apellido_1" => $datos["datos"]["paciente"]["apellido1"],
                "apellido_2" => $datos["datos"]["paciente"]["apellido2"],
                "estado_afiliacion" => $datos["datos"]["paciente"]["desc_Estado"],
                "observacion" => "EXISTE",
                "estado" => "VALIDADO"
            );

            $stmtUpdateVali = Connection::connectBatch()->prepare("UPDATE di_validacion_famisanar SET nombre_1 = :nombre_1, nombre_2 = :nombre_2, apellido_1 = :apellido_1, apellido_2 = :apellido_2,
                estado_afiliacion = :estado_afiliacion, observacion = :observacion, estado = :estado WHERE id = :id");

            $stmtUpdateVali->bindParam(":id", $datosPaciente["id"], PDO::PARAM_STR);
            $stmtUpdateVali->bindParam(":nombre_1", $datosPaciente["nombre_1"], PDO::PARAM_STR);
            $stmtUpdateVali->bindParam(":nombre_2", $datosPaciente["nombre_2"], PDO::PARAM_STR);
            $stmtUpdateVali->bindParam(":apellido_1", $datosPaciente["apellido_1"], PDO::PARAM_STR);
            $stmtUpdateVali->bindParam(":apellido_2", $datosPaciente["apellido_2"], PDO::PARAM_STR);
            $stmtUpdateVali->bindParam(":estado_afiliacion", $datosPaciente["estado_afiliacion"], PDO::PARAM_STR);
            $stmtUpdateVali->bindParam(":observacion", $datosPaciente["observacion"], PDO::PARAM_STR);
            $stmtUpdateVali->bindParam(":estado", $datosPaciente["estado"], PDO::PARAM_STR);

            if($stmtUpdateVali->execute()){

                echo 'Paciente: ' . $valueDato["id"] . ' - validado y actualizado <br>';
                
            }else{
                
                echo 'Paciente: ' . $valueDato["id"] . ' - ERROR ACTUALIZANDO <br>';

            }

        }else{
            
            $datosPaciente = array(
                "id" => $valueDato["id"],
                "observacion" => "NO-EXISTE",
                "estado" => "VALIDADO"
            );

            $stmtUpdateVali = Connection::connectBatch()->prepare("UPDATE di_validacion_famisanar SET observacion = :observacion, estado = :estado WHERE id = :id");

            $stmtUpdateVali->bindParam(":id", $datosPaciente["id"], PDO::PARAM_STR);
            $stmtUpdateVali->bindParam(":observacion", $datosPaciente["observacion"], PDO::PARAM_STR);
            $stmtUpdateVali->bindParam(":estado", $datosPaciente["estado"], PDO::PARAM_STR);

            if($stmtUpdateVali->execute()){

                echo 'Paciente: ' . $valueDato["id"] . ' - NO EXISTE, validado y actualizado <br>';
                
            }else{
                
                echo 'Paciente: ' . $valueDato["id"] . ' - PACIENTE NO EXISTE - ERROR ACTUALIZANDO <br>';

            }

        }
        
    
    }



}
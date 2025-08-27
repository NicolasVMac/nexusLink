<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModeloAuditoria
{

    public static function mdlAuditoriaValidaCuenta($tabla, $datos)
    {
        $idPerfil = $datos["idPerfil"];
        $idReclamacion = $datos["idReclamacion"];
        $usuario = $datos["usuario"];

        //echo 'Id perfil-> ' . $idPerfil . ' Id Cuenta-> ' . $idCuenta . '  usuario-> ' . $usuario . '<br/>';

        switch ($idPerfil) {
            case 'Auditor':
                // Validacion de cuenta para asignar o propia
                $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE reclamacion_id='$idReclamacion' AND auditor='SI' AND usuario_auditor IS NULL;");
                $stmt->execute();
                $cuentaAsignada = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (sizeof($cuentaAsignada) > 0) {  // Cuenta sin asignacion
                    //echo 'cuenta para tomar';
                    $asignarCuenta = Connection::connectOnly()->prepare("UPDATE $tabla SET usuario_auditor='$usuario', fecha_auditor_ini=CURRENT_TIME WHERE reclamacion_id='$idReclamacion'");
                    if ($asignarCuenta->execute()) { // Asignacion de la cuenta
                        return "Asignada";
                    } else {
                        return "Error Asignado";
                    }
                    $asignarCuenta = null;
                } else { // Cuenta con Asignacion
                    $propiaCuenta = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE reclamacion_id='$idReclamacion' AND auditor='SI' AND usuario_auditor ='$usuario';");
                    $propiaCuenta->execute();
                    $cuentaPropia = $propiaCuenta->fetchAll(PDO::FETCH_ASSOC);
                    if (sizeof($cuentaPropia) > 0) {  // Cuenta Propia
                        //echo 'cuenta propia';
                        return "Propia";
                    } else { // Cuenta Otro Auditor
                        return "Ya Asignada";
                    }
                    $propiaCuenta = null;
                }
                $stmt = null;

                break;
            case 'Medico':
                // Validacion de cuenta para asignar o propia
                $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE reclamacion_id='$idReclamacion' AND medico='SI' AND usuario_medico IS NULL;");
                $stmt->execute();
                $cuentaAsignada = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (sizeof($cuentaAsignada) > 0) {  // Cuenta sin asignacion
                    //echo 'cuenta para tomar';
                    $asignarCuenta = Connection::connectOnly()->prepare("UPDATE $tabla SET usuario_medico='$usuario', fecha_medico_ini=CURRENT_TIME WHERE reclamacion_id='$idReclamacion'");
                    if ($asignarCuenta->execute()) { // Asignacion de la cuenta
                        return "Asignada";
                    } else {
                        return "Error Asignado";
                    }
                    $asignarCuenta = null;
                } else { // Cuenta con Asignacion
                    $propiaCuenta = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE reclamacion_id='$idReclamacion' AND medico='SI' AND usuario_medico ='$usuario';");
                    $propiaCuenta->execute();
                    $cuentaPropia = $propiaCuenta->fetchAll(PDO::FETCH_ASSOC);
                    if (sizeof($cuentaPropia) > 0) {  // Cuenta Propia
                        //echo 'cuenta propia';
                        return "Propia";
                    } else { // Cuenta Otro Medico
                        return "Ya Asignada";
                    }
                    $propiaCuenta = null;
                }
                $stmt = null;

                break;
            case 'Financiero':
                // Validacion de cuenta para asignar o propia
                $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE reclamacion_id='$idReclamacion' AND financiero='SI' AND usuario_financiero IS NULL;");
                $stmt->execute();
                $cuentaAsignada = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (sizeof($cuentaAsignada) > 0) {  // Cuenta sin asignacion
                    //echo 'cuenta para tomar';
                    $asignarCuenta = Connection::connectOnly()->prepare("UPDATE $tabla SET usuario_financiero='$usuario', fecha_financiero_ini=CURRENT_TIME WHERE reclamacion_id='$idReclamacion'");
                    if ($asignarCuenta->execute()) { // Asignacion de la cuenta
                        return "Asignada";
                    } else {
                        return "Error Asignado";
                    }
                    $asignarCuenta = null;
                } else { // Cuenta con Asignacion
                    $propiaCuenta = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE reclamacion_id='$idReclamacion' AND financiero='SI' AND usuario_financiero ='$usuario';");
                    $propiaCuenta->execute();
                    $cuentaPropia = $propiaCuenta->fetchAll(PDO::FETCH_ASSOC);
                    if (sizeof($cuentaPropia) > 0) {  // Cuenta Propia
                        //echo 'cuenta propia';
                        return "Propia";
                    } else { // Cuenta Otro Financiero
                        return "Ya Asignada";
                    }
                    $propiaCuenta = null;
                }
                $stmt = null;

                break;
            case 'Validaciones':
                // Validacion de cuenta para asignar o propia
                $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE reclamacion_id='$idReclamacion' AND validaciones='SI' AND usuario_validaciones IS NULL;");
                $stmt->execute();
                $cuentaAsignada = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (sizeof($cuentaAsignada) > 0) {  // Cuenta sin asignacion
                    //echo 'cuenta para tomar';
                    $asignarCuenta = Connection::connectOnly()->prepare("UPDATE $tabla SET usuario_validaciones='$usuario', fecha_validaciones_ini=CURRENT_TIME WHERE reclamacion_id='$idReclamacion'");
                    if ($asignarCuenta->execute()) { // Asignacion de la cuenta
                        return "Asignada";
                    } else {
                        return "Error Asignado";
                    }
                    $asignarCuenta = null;
                } else { // Cuenta con Asignacion
                    $propiaCuenta = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE reclamacion_id='$idReclamacion' AND validaciones='SI' AND usuario_validaciones ='$usuario';");
                    $propiaCuenta->execute();
                    $cuentaPropia = $propiaCuenta->fetchAll(PDO::FETCH_ASSOC);
                    if (sizeof($cuentaPropia) > 0) {  // Cuenta Propia
                        //echo 'cuenta propia';
                        return "Propia";
                    } else { // Cuenta Otro Financiero
                        return "Ya Asignada";
                    }
                    $propiaCuenta = null;
                }
                $stmt = null;

                break;
        }
    }

    public static function mdlBolsaSearch($perfil, $usuario, $montos, $items)
    {

        switch ($perfil) {
            case 'Auditor':

                $stmt = Connection::connectOnly()->prepare("SELECT reclamaciones_encabezado.Reclamacion_Id,reclamaciones_encabezado.Numero_Radicacion,CASE WHEN reclamaciones_encabezado.Tipo_Ingreso IN ('0','1') THEN 'Respuesta Glosa' WHEN reclamaciones_encabezado.Tipo_Ingreso='2' THEN 'Reclamacion Nueva' ELSE 'NaN' END AS Tipo_Ingreso,reclamaciones_encabezado.Numero_Factura,reclamaciones_encabezado.Razon_Social_Reclamante,reclamaciones_encabezado.Numero_Paquete,reclamaciones_encabezado.Estado,reclamaciones_encabezado.Total_Reclamado,reclamaciones_encabezado.Tipo_Formulario,reclamaciones_encabezado.Codigo_Entrada,Tipo_Monto,Tipo_Items,reclamaciones_log.auditor,reclamaciones_log.fecha_auditor_ini,reclamaciones_log.fecha_auditor_fin,reclamaciones_log.usuario_auditor,reclamaciones_log.medico,reclamaciones_log.fecha_medico_ini,reclamaciones_log.fecha_medico_fin,reclamaciones_log.usuario_medico,reclamaciones_log.financiero,reclamaciones_log.fecha_financiero_ini,reclamaciones_log.fecha_financiero_fin,reclamaciones_log.usuario_financiero FROM reclamaciones_encabezado INNER JOIN reclamaciones_log ON reclamaciones_encabezado.Reclamacion_Id=reclamaciones_log.reclamacion_id WHERE reclamaciones_encabezado.Estado='auditoria' AND reclamaciones_encabezado.Imagen='SI' AND reclamaciones_log.auditor='SI' AND reclamaciones_log.usuario_auditor IS NULL AND Tipo_Monto IN ($montos) AND Tipo_Items IN ($items) ORDER BY CASE WHEN Razon_Social_Reclamante='HOSPITAL REGIONAL JOSE DAVID PADILLA VILLAFAÑE E.S.E' THEN 1 WHEN Razon_Social_Reclamante='HOSPITAL ROSARIO PUMAREJO DE LOPEZ' THEN 2 WHEN Razon_Social_Reclamante='SOCIEDAD MEDICA  CLINICA MAICAO S.A.' THEN 3 WHEN Razon_Social_Reclamante='HOSPITAL REGIONAL SAN ANDRES ESE' THEN 4 ELSE 5 END,Razon_Social_Reclamante LIMIT 1;");

                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                //return $perfil;
                $stmt = null;

                break;

            case 'Medico':

                $stmt = Connection::connectOnly()->prepare("SELECT reclamaciones_encabezado.Reclamacion_Id,reclamaciones_encabezado.Numero_Radicacion,CASE WHEN reclamaciones_encabezado.Tipo_Ingreso IN ('0','1') THEN 'Respuesta Glosa' WHEN reclamaciones_encabezado.Tipo_Ingreso='2' THEN 'Reclamacion Nueva' ELSE 'NaN' END AS Tipo_Ingreso,reclamaciones_encabezado.Numero_Factura,reclamaciones_encabezado.Razon_Social_Reclamante,reclamaciones_encabezado.Numero_Paquete,reclamaciones_encabezado.Estado,reclamaciones_encabezado.Total_Reclamado,reclamaciones_encabezado.Tipo_Formulario,reclamaciones_encabezado.Codigo_Entrada,Tipo_Monto,Tipo_Items,reclamaciones_log.auditor,reclamaciones_log.fecha_auditor_ini,reclamaciones_log.fecha_auditor_fin,reclamaciones_log.usuario_auditor,reclamaciones_log.medico,reclamaciones_log.fecha_medico_ini,reclamaciones_log.fecha_medico_fin,reclamaciones_log.usuario_medico,reclamaciones_log.financiero,reclamaciones_log.fecha_financiero_ini,reclamaciones_log.fecha_financiero_fin,reclamaciones_log.usuario_financiero FROM reclamaciones_encabezado INNER JOIN reclamaciones_log ON reclamaciones_encabezado.Reclamacion_Id=reclamaciones_log.reclamacion_id WHERE reclamaciones_encabezado.Estado='auditoria' AND reclamaciones_encabezado.Imagen='SI' AND reclamaciones_log.medico='SI' AND reclamaciones_log.usuario_medico IS NULL AND Tipo_Items IN ($items) AND Tipo_Monto IN ($montos) ORDER BY CASE WHEN Razon_Social_Reclamante='HOSPITAL REGIONAL JOSE DAVID PADILLA VILLAFAÑE E.S.E' THEN 1 WHEN Razon_Social_Reclamante='HOSPITAL ROSARIO PUMAREJO DE LOPEZ' THEN 2 WHEN Razon_Social_Reclamante='SOCIEDAD MEDICA  CLINICA MAICAO S.A.' THEN 3 WHEN Razon_Social_Reclamante='HOSPITAL REGIONAL SAN ANDRES ESE' THEN 4 ELSE 5 END,Razon_Social_Reclamante LIMIT 1;");

                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                //return $perfil;
                $stmt = null;

                break;

            case 'Financiero':

                $stmt = Connection::connectOnly()->prepare("SELECT reclamaciones_encabezado.Reclamacion_Id,reclamaciones_encabezado.Numero_Radicacion,CASE WHEN reclamaciones_encabezado.Tipo_Ingreso IN ('0','1') THEN 'Respuesta Glosa' WHEN reclamaciones_encabezado.Tipo_Ingreso='2' THEN 'Reclamacion Nueva' ELSE 'NaN' END AS Tipo_Ingreso,reclamaciones_encabezado.Numero_Factura,reclamaciones_encabezado.Razon_Social_Reclamante,reclamaciones_encabezado.Numero_Paquete,reclamaciones_encabezado.Estado,reclamaciones_encabezado.Total_Reclamado,reclamaciones_encabezado.Tipo_Formulario,reclamaciones_encabezado.Codigo_Entrada,Tipo_Monto,Tipo_Items,reclamaciones_log.auditor,reclamaciones_log.fecha_auditor_ini,reclamaciones_log.fecha_auditor_fin,reclamaciones_log.usuario_auditor,reclamaciones_log.medico,reclamaciones_log.fecha_medico_ini,reclamaciones_log.fecha_medico_fin,reclamaciones_log.usuario_medico,reclamaciones_log.financiero,reclamaciones_log.fecha_financiero_ini,reclamaciones_log.fecha_financiero_fin,reclamaciones_log.usuario_financiero FROM reclamaciones_encabezado INNER JOIN reclamaciones_log ON reclamaciones_encabezado.Reclamacion_Id=reclamaciones_log.reclamacion_id WHERE reclamaciones_encabezado.Estado='auditoria' AND reclamaciones_encabezado.Imagen='SI' AND reclamaciones_log.financiero='SI' AND reclamaciones_log.usuario_financiero IS NULL AND Tipo_Items IN ($items) AND Tipo_Monto IN ($montos) ORDER BY CASE WHEN Razon_Social_Reclamante='HOSPITAL REGIONAL JOSE DAVID PADILLA VILLAFAÑE E.S.E' THEN 1 WHEN Razon_Social_Reclamante='HOSPITAL ROSARIO PUMAREJO DE LOPEZ' THEN 2 WHEN Razon_Social_Reclamante='SOCIEDAD MEDICA  CLINICA MAICAO S.A.' THEN 3 WHEN Razon_Social_Reclamante='HOSPITAL REGIONAL SAN ANDRES ESE' THEN 4 ELSE 5 END,Razon_Social_Reclamante LIMIT 1;");
                
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                //return $perfil;
                $stmt = null;

                break;
            default:
                return "perfil no asignado";
        }
    }

    public static function mdlPausaSearch($perfil, $usuario)
    {

        switch ($perfil) {
            case 'Auditor':

                $stmt = Connection::connectOnly()->prepare("SELECT reclamaciones_encabezado.Reclamacion_Id,reclamaciones_encabezado.Numero_Radicacion,CASE WHEN reclamaciones_encabezado.Tipo_Ingreso IN ('0','1') THEN 'Respuesta Glosa' WHEN reclamaciones_encabezado.Tipo_Ingreso='2' THEN 'Reclamacion Nueva' ELSE 'NaN' END AS Tipo_Ingreso,reclamaciones_encabezado.Numero_Factura,reclamaciones_encabezado.Razon_Social_Reclamante,reclamaciones_encabezado.Numero_Paquete,reclamaciones_encabezado.Estado,reclamaciones_encabezado.Total_Reclamado,reclamaciones_encabezado.Tipo_Formulario,reclamaciones_encabezado.Codigo_Entrada,reclamaciones_log.auditor,reclamaciones_log.fecha_auditor_ini,reclamaciones_log.fecha_auditor_fin,reclamaciones_log.usuario_auditor FROM reclamaciones_encabezado INNER JOIN reclamaciones_log ON reclamaciones_encabezado.Reclamacion_Id=reclamaciones_log.reclamacion_id WHERE reclamaciones_encabezado.Estado='auditoria' AND reclamaciones_encabezado.Imagen='SI' AND reclamaciones_log.auditor='SI' AND reclamaciones_log.usuario_auditor='$usuario' AND fecha_auditor_fin IS NULL;");
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                //return $perfil;
                $stmt = null;

                break;

            case 'Medico':

                $stmt = Connection::connectOnly()->prepare("SELECT reclamaciones_encabezado.Reclamacion_Id,reclamaciones_encabezado.Numero_Radicacion,CASE WHEN reclamaciones_encabezado.Tipo_Ingreso IN ('0','1') THEN 'Respuesta Glosa' WHEN reclamaciones_encabezado.Tipo_Ingreso='2' THEN 'Reclamacion Nueva' ELSE 'NaN' END AS Tipo_Ingreso,reclamaciones_encabezado.Numero_Factura,reclamaciones_encabezado.Razon_Social_Reclamante,reclamaciones_encabezado.Numero_Paquete,reclamaciones_encabezado.Estado,reclamaciones_encabezado.Total_Reclamado,reclamaciones_encabezado.Tipo_Formulario,reclamaciones_encabezado.Codigo_Entrada,reclamaciones_log.auditor,reclamaciones_log.fecha_auditor_ini,reclamaciones_log.fecha_auditor_fin,reclamaciones_log.usuario_auditor FROM reclamaciones_encabezado INNER JOIN reclamaciones_log ON reclamaciones_encabezado.Reclamacion_Id=reclamaciones_log.reclamacion_id WHERE reclamaciones_encabezado.Estado='auditoria' AND reclamaciones_encabezado.Imagen='SI' AND reclamaciones_log.medico='SI' AND reclamaciones_log.usuario_medico='$usuario' AND fecha_medico_fin IS NULL;");
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                //return $perfil;
                $stmt = null;

                break;

            case 'Financiero':

                $stmt = Connection::connectOnly()->prepare("SELECT reclamaciones_encabezado.Reclamacion_Id,reclamaciones_encabezado.Numero_Radicacion,CASE WHEN reclamaciones_encabezado.Tipo_Ingreso IN ('0','1') THEN 'Respuesta Glosa' WHEN reclamaciones_encabezado.Tipo_Ingreso='2' THEN 'Reclamacion Nueva' ELSE 'NaN' END AS Tipo_Ingreso,reclamaciones_encabezado.Numero_Factura,reclamaciones_encabezado.Razon_Social_Reclamante,reclamaciones_encabezado.Numero_Paquete,reclamaciones_encabezado.Estado,reclamaciones_encabezado.Total_Reclamado,reclamaciones_encabezado.Tipo_Formulario,reclamaciones_encabezado.Codigo_Entrada,reclamaciones_log.auditor,reclamaciones_log.fecha_auditor_ini,reclamaciones_log.fecha_auditor_fin,reclamaciones_log.usuario_auditor FROM reclamaciones_encabezado INNER JOIN reclamaciones_log ON reclamaciones_encabezado.Reclamacion_Id=reclamaciones_log.reclamacion_id WHERE reclamaciones_encabezado.Estado='auditoria' AND reclamaciones_encabezado.Imagen='SI' AND reclamaciones_log.financiero='SI' AND reclamaciones_log.usuario_financiero='$usuario' AND fecha_financiero_fin IS NULL;");
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                //return $perfil;
                $stmt = null;

                break;

            case 'Validaciones':

                $stmt = Connection::connectOnly()->prepare("SELECT reclamaciones_encabezado.Reclamacion_Id,reclamaciones_encabezado.Numero_Radicacion,CASE WHEN reclamaciones_encabezado.Tipo_Ingreso IN ('0','1') THEN 'Respuesta Glosa' WHEN reclamaciones_encabezado.Tipo_Ingreso='2' THEN 'Reclamacion Nueva' ELSE 'NaN' END AS Tipo_Ingreso,reclamaciones_encabezado.Numero_Factura,reclamaciones_encabezado.Razon_Social_Reclamante,reclamaciones_encabezado.Numero_Paquete,reclamaciones_encabezado.Estado,reclamaciones_encabezado.Total_Reclamado,reclamaciones_encabezado.Tipo_Formulario,reclamaciones_encabezado.Codigo_Entrada,reclamaciones_log.auditor,reclamaciones_log.fecha_auditor_ini,reclamaciones_log.fecha_auditor_fin,reclamaciones_log.usuario_auditor FROM reclamaciones_encabezado INNER JOIN reclamaciones_log ON reclamaciones_encabezado.Reclamacion_Id=reclamaciones_log.reclamacion_id WHERE reclamaciones_encabezado.Estado='auditada' AND reclamaciones_encabezado.Imagen='SI' AND reclamaciones_log.validaciones='SI' AND reclamaciones_log.usuario_validaciones='$usuario' AND fecha_validaciones_fin IS NULL;");
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                //return $perfil;
                $stmt = null;

                break;
            default:
                return "perfil no asignado";
        }
    }
    public static function mdlReclamacionInfo($idReclamacion)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT *, CASE WHEN Tipo_Aprobacion=1 THEN 'Aprobado' WHEN Tipo_Aprobacion=2 THEN 'Aprobado Parcial' WHEN Tipo_Aprobacion=3 THEN 'No Aprobado' END AS Tipo_Aprobacion_New FROM reclamaciones_encabezado WHERE Reclamacion_Id = $idReclamacion;");

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
        //return $perfil;
        $stmt = null;
    }

    public static function mdlReclamacionDetail($idReclamacion)
    {
        //$stmt = Connection::connectOnly()->prepare("SELECT * FROM reclamaciones_detalle WHERE Reclamacion_Id = $idReclamacion;");

        $stmt = Connection::connectOnly()->prepare("SELECT reclamaciones_detalle.*,count(reclamaciones_glosas.id_glosa) AS 'sum_glosas',GROUP_CONCAT(reclamaciones_glosas.Cod_Glosa SEPARATOR ' | ') AS Glosa FROM reclamaciones_detalle LEFT JOIN reclamaciones_glosas ON reclamaciones_detalle.Reclamacion_Id=reclamaciones_glosas.Reclamacion_Id AND reclamaciones_detalle.Item_id=reclamaciones_glosas.Item_id WHERE reclamaciones_detalle.Reclamacion_Id=$idReclamacion GROUP BY reclamaciones_detalle.Item_id;");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //return $perfil;
        $stmt = null;
    }

    public static function mdlReclamacionGlosas($idReclamacion)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT * FROM reclamaciones_glosas WHERE Reclamacion_Id = $idReclamacion;");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //return $perfil;
        $stmt = null;
    }

    public static function mdlCrearGlosaItem($tabla, $datos)
    {
        $valorPagar = $datos["valorItem"] - $datos["totalGlosa"];

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla(Item_id,Reclamacion_Id,Clasificacion_Glosa,Cod_Glosa,Descripcion_Glosa,Justificacion_Glosa,Usuario,Fecha_Glosa,Tipo_Glosa,Num_Item_Reclamado,Valor_Item_Reclamado,Valor_Total_Reclamado,Num_Item_Glosa,Valor_Item_Glosa,Valor_Total_Glosa,Valor_Total_Pagar) 
        VALUES (:idItem,:idReclamacion,:clasificacion, :codGlosa, :glosaDescription, :justificacion, :usuario, CURRENT_TIME, :tipoGlosa, :cantidadItem, :valorUniItem, :valorItem, :cantidadGlosa, :valorGlosa, :totalGlosa, :totalPagar)");

        $stmt->bindParam(":idItem", $datos["idItem"], PDO::PARAM_STR);
        $stmt->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);
        $stmt->bindParam(":clasificacion", $datos["clasificacion"], PDO::PARAM_STR);
        $stmt->bindParam(":codGlosa", $datos["codGlosa"], PDO::PARAM_STR);
        $stmt->bindParam(":glosaDescription", $datos["glosaDescription"], PDO::PARAM_STR);
        $stmt->bindParam(":justificacion", $datos["justificacion"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":tipoGlosa", $datos["tipoGlosa"], PDO::PARAM_STR);
        $stmt->bindParam(":cantidadItem", $datos["cantidadItem"], PDO::PARAM_STR);
        $stmt->bindParam(":valorUniItem", $datos["valorUniItem"], PDO::PARAM_STR);
        $stmt->bindParam(":valorItem", $datos["valorItem"], PDO::PARAM_STR);
        $stmt->bindParam(":cantidadGlosa", $datos["cantidadGlosa"], PDO::PARAM_STR);
        $stmt->bindParam(":valorGlosa", $datos["valorGlosa"], PDO::PARAM_STR);
        $stmt->bindParam(":totalGlosa", $datos["totalGlosa"], PDO::PARAM_STR);
        $stmt->bindParam(":totalPagar", $valorPagar, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt = null;
    }

    public static function mdlCrearGlosaMasivoItem($tabla, $datos)
    {
        $idItems = explode(",", $datos["idItems"]);
        $error = 0;

        if ($datos["tipoGlosa"] == 'valorM') {
            foreach ($idItems as $item) {
                $items = Connection::connectOnly()->prepare("SELECT Item_id,Reclamacion_Id,Cantidad,Valor_Unitario,Valor_Total_Reclamado_item FROM reclamaciones_detalle WHERE Item_id ='$item'");
                $items->execute();
                $row = $items->fetch();

                $aprobadoValor = ($row["Valor_Total_Reclamado_item"] - $datos["valorMasivaGlosa"]);
                $glosaTipo = $datos["tipoGlosa"];

                if ($aprobadoValor < 0) {
                    $aprobadoValor = 0;
                    $glosaValor = $row["Valor_Total_Reclamado_item"];
                } else {
                    $glosaValor = $datos["valorMasivaGlosa"];
                }

                $glosaFin = Connection::connectOnly()->prepare("INSERT INTO $tabla(Item_id,Reclamacion_Id,Clasificacion_Glosa,Cod_Glosa,Descripcion_Glosa,Justificacion_Glosa,Usuario,Fecha_Glosa,Tipo_Glosa,Num_Item_Reclamado,Valor_Item_Reclamado,Valor_Total_Reclamado,Num_Item_Glosa,Valor_Item_Glosa,Valor_Total_Glosa,Valor_Total_Pagar) 
                VALUES (:idItem,:idReclamacion,:clasificacion, :codGlosa, :glosaDescription, :justificacion, :usuario, CURRENT_TIME, :tipoGlosa, :cantidadItem, :valorUniItem, :valorItem, :cantidadGlosa, :valorGlosa, :totalGlosa, :totalPagar)");

                $glosaFin->bindParam(":idItem", $item, PDO::PARAM_STR);
                $glosaFin->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);
                $glosaFin->bindParam(":clasificacion", $datos["clasificacion"], PDO::PARAM_STR);
                $glosaFin->bindParam(":codGlosa", $datos["codGlosa"], PDO::PARAM_STR);
                $glosaFin->bindParam(":glosaDescription", $datos["glosaDescription"], PDO::PARAM_STR);
                $glosaFin->bindParam(":justificacion", $datos["justificacion"], PDO::PARAM_STR);
                $glosaFin->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
                $glosaFin->bindParam(":tipoGlosa", $glosaTipo, PDO::PARAM_STR);
                $glosaFin->bindParam(":cantidadItem", $row["Cantidad"], PDO::PARAM_STR);
                $glosaFin->bindParam(":valorUniItem", $row["Valor_Unitario"], PDO::PARAM_STR);
                $glosaFin->bindParam(":valorItem", $row["Valor_Total_Reclamado_item"], PDO::PARAM_STR);
                $glosaFin->bindValue(":cantidadGlosa", "1", PDO::PARAM_STR);
                $glosaFin->bindParam(":valorGlosa", $glosaValor, PDO::PARAM_STR);
                $glosaFin->bindParam(":totalGlosa", $glosaValor, PDO::PARAM_STR);
                $glosaFin->bindParam(":totalPagar", $aprobadoValor, PDO::PARAM_STR);

                if ($glosaFin->execute()) {
                    $error = $error + 0;
                } else {
                    $error = $error + 1;
                }
            }
            if ($error == 0) {
                return "ok";
            } else {
                return "Errores" . $error;
            }
        } elseif ($datos["tipoGlosa"] == 'PorcentajeM') {
            foreach ($idItems as $item) {
                $items = Connection::connectOnly()->prepare("SELECT Item_id,Reclamacion_Id,Cantidad,Valor_Unitario,Valor_Total_Reclamado_item FROM reclamaciones_detalle WHERE Item_id ='$item'");
                $items->execute();
                $row = $items->fetch();

                $glosaValor = ($row["Valor_Total_Reclamado_item"] * $datos["porcentajeMasivaGlosa"]) / 100;
                $aprobadoValor = $row["Valor_Total_Reclamado_item"] - $glosaValor;

                $glosaTipo = $datos["tipoGlosa"] . ' ' . $datos["porcentajeMasivaGlosa"];

                $glosaFin = Connection::connectOnly()->prepare("INSERT INTO $tabla(Item_id,Reclamacion_Id,Clasificacion_Glosa,Cod_Glosa,Descripcion_Glosa,Justificacion_Glosa,Usuario,Fecha_Glosa,Tipo_Glosa,Num_Item_Reclamado,Valor_Item_Reclamado,Valor_Total_Reclamado,Num_Item_Glosa,Valor_Item_Glosa,Valor_Total_Glosa,Valor_Total_Pagar) 
                VALUES (:idItem,:idReclamacion,:clasificacion, :codGlosa, :glosaDescription, :justificacion, :usuario, CURRENT_TIME, :tipoGlosa, :cantidadItem, :valorUniItem, :valorItem, :cantidadGlosa, :valorGlosa, :totalGlosa, :totalPagar)");

                $glosaFin->bindParam(":idItem", $item, PDO::PARAM_STR);
                $glosaFin->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);
                $glosaFin->bindParam(":clasificacion", $datos["clasificacion"], PDO::PARAM_STR);
                $glosaFin->bindParam(":codGlosa", $datos["codGlosa"], PDO::PARAM_STR);
                $glosaFin->bindParam(":glosaDescription", $datos["glosaDescription"], PDO::PARAM_STR);
                $glosaFin->bindParam(":justificacion", $datos["justificacion"], PDO::PARAM_STR);
                $glosaFin->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
                $glosaFin->bindParam(":tipoGlosa", $glosaTipo, PDO::PARAM_STR);
                $glosaFin->bindParam(":cantidadItem", $row["Cantidad"], PDO::PARAM_STR);
                $glosaFin->bindParam(":valorUniItem", $row["Valor_Unitario"], PDO::PARAM_STR);
                $glosaFin->bindParam(":valorItem", $row["Valor_Total_Reclamado_item"], PDO::PARAM_STR);
                $glosaFin->bindValue(":cantidadGlosa", "1", PDO::PARAM_STR);
                $glosaFin->bindParam(":valorGlosa", $glosaValor, PDO::PARAM_STR);
                $glosaFin->bindParam(":totalGlosa", $glosaValor, PDO::PARAM_STR);
                $glosaFin->bindParam(":totalPagar", $aprobadoValor, PDO::PARAM_STR);

                if ($glosaFin->execute()) {
                    $error = $error + 0;
                } else {
                    $error = $error + 1;
                }
            }

            if ($error == 0) {
                return "ok";
            } else {
                return "Errores" . $error;
            }
        } else {
            return "error";
        }
    }

    public static function mdlCrearGlosaRecla($tabla, $datos)
    {

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla(Item_id,Reclamacion_Id,Clasificacion_Glosa,Cod_Glosa,Descripcion_Glosa,Justificacion_Glosa,Usuario,Fecha_Glosa,Tipo_Glosa,Num_Item_Reclamado,Valor_Item_Reclamado,Valor_Total_Reclamado,Num_Item_Glosa,Valor_Item_Glosa,Valor_Total_Glosa,Valor_Total_Pagar) 
        VALUES (:idItem,:idReclamacion,:clasificacion, :codGlosa, :glosaDescription, :justificacion, :usuario, CURRENT_TIME, :tipoGlosa, :cantidadItem, :valorUniItem, :valorItem, :cantidadGlosa, :valorGlosa, :totalGlosa, :totalPagar)");

        $stmt->bindValue(":idItem", "0", PDO::PARAM_STR);
        $stmt->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);
        $stmt->bindParam(":clasificacion", $datos["clasificacion"], PDO::PARAM_STR);
        $stmt->bindParam(":codGlosa", $datos["codGlosa"], PDO::PARAM_STR);
        $stmt->bindParam(":glosaDescription", $datos["glosaDescription"], PDO::PARAM_STR);
        $stmt->bindParam(":justificacion", $datos["justificacion"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":tipoGlosa", $datos["tipoGlosa"], PDO::PARAM_STR);
        $stmt->bindValue(":cantidadItem", "1", PDO::PARAM_STR);
        $stmt->bindParam(":valorUniItem", $datos["valorReclamado"], PDO::PARAM_STR);
        $stmt->bindParam(":valorItem", $datos["valorReclamado"], PDO::PARAM_STR);
        $stmt->bindValue(":cantidadGlosa", "1", PDO::PARAM_STR);
        $stmt->bindParam(":valorGlosa", $datos["valorReclamado"], PDO::PARAM_STR);
        $stmt->bindParam(":totalGlosa", $datos["valorReclamado"], PDO::PARAM_STR);
        $stmt->bindValue(":totalPagar", "0", PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt = null;
    }

    public static function mdlCalcularGlosa($datos)
    {

        $idReclamacion = $datos["idReclamacion"];

        $glosaEncabezado = Connection::connectOnly()->prepare("SELECT * FROM reclamaciones_glosas WHERE Item_id='0' AND Reclamacion_Id ='$idReclamacion';");
        $glosaEncabezado->execute();
        $encabezado = $glosaEncabezado->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($encabezado) > 0) {

            $stmt = Connection::connectOnly()->prepare("UPDATE reclamaciones_detalle SET Valor_Aprobado_Item ='0', Valor_Glosado_Item=Valor_Total_Reclamado_item, Tipo_Aprobacion_Item='3', Cantidad_Aprobado='0', Valor_Unitario_Aprobado='0'  WHERE Reclamacion_Id='$idReclamacion';");
            $end = Connection::connectOnly()->prepare("UPDATE reclamaciones_encabezado SET Total_Aprobado='0', Total_Glosado=Total_Reclamado, Tipo_Aprobacion='3' WHERE Reclamacion_Id=$idReclamacion;");

            if ($stmt->execute() && $end->execute()) {
                $stmt = null;
                $end = null;
                return 'ok';
            } else {
                $error = $end->errorInfo() . '-' . $stmt->errorInfo();
                return $error;
                //return "Error Asociando";
            }
        } else {
            /* Inicio Calculo Por Item */
            $stmt = Connection::connectOnly()->prepare("SELECT reclamaciones_detalle.Item_id,reclamaciones_detalle.Reclamacion_Id,reclamaciones_detalle.Cantidad,reclamaciones_detalle.Valor_Unitario,reclamaciones_detalle.Valor_Total_Reclamado_item,sum(reclamaciones_glosas.Valor_Total_Glosa) AS sum_glosa,reclamaciones_detalle.Valor_Aprobado_Item,reclamaciones_detalle.Valor_Glosado_Item,reclamaciones_detalle.Tipo_Aprobacion_Item FROM reclamaciones_detalle LEFT JOIN reclamaciones_glosas ON reclamaciones_detalle.Item_id=reclamaciones_glosas.Item_id WHERE reclamaciones_detalle.Reclamacion_Id='$idReclamacion' GROUP BY Item_id;");

            $stmt->execute();

            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($items as $key => $value) {
                $valorGlosadoItem = 0;
                $valorAprobadoItem = 0;
                $cantidadApro = 0;
                $valorUniAproItem = 0;
                $tipoAprobaItem = "1";

                if($value['Valor_Total_Reclamado_item']==0){
                    $valorAprobadoItem=0;
                    $valorGlosadoItem=0;
                    $tipoAprobaItem=1;
                    $cantidadApro=0;
                    $valorUniAproItem=0;

                }else{
                        if ($value['sum_glosa'] == null) {
                        $value['sum_glosa'] = 0;
                    }
                    if ($value['Valor_Total_Reclamado_item'] <= $value['sum_glosa']) {
                        $valorGlosadoItem = $value['Valor_Total_Reclamado_item'];
                    } else {
                        $valorGlosadoItem = $value['sum_glosa'];
                    }
                    $valorAprobadoItem = $value['Valor_Total_Reclamado_item'] - $valorGlosadoItem;
                    $cantidadApro = $value['Cantidad'];
                    $valorUniAproItem = $valorAprobadoItem / $cantidadApro;
                    if ($valorUniAproItem == 0) {
                        $cantidadApro = 0;
                    }

                    // Si Cantidad_Aprobado * Valor_Unitario_Aprobado es decimal y diferente de Valor_Aprobado_Item (Item 11)

                    if(($cantidadApro*round($valorUniAproItem, 2))!=$valorAprobadoItem){
                        //echo 'Entro calculo '.$cantidadApro*$valorUniAproItem.'<br/>';
                        //echo $valorAprobadoItem;
                        $cantidadApro=$valorAprobadoItem/$value['Valor_Unitario'];
                        $valorUniAproItem=$value['Valor_Unitario'];
                    }

                    // Si cantidad es decimal -> pasar a 1 

                    if(is_float($cantidadApro)){
                        $cantidadApro=1;
                        $valorUniAproItem=$valorAprobadoItem;
                    }
                    
                    if ($valorAprobadoItem == $value['Valor_Total_Reclamado_item']) {
                        $tipoAprobaItem = "1";
                    } elseif ($valorAprobadoItem == 0) {
                        $tipoAprobaItem = "3";
                    } else {
                        $tipoAprobaItem = "2";
                    }
                }


                $stmt = Connection::connectOnly()->prepare("UPDATE reclamaciones_detalle SET Valor_Aprobado_Item ='$valorAprobadoItem', Valor_Glosado_Item='$valorGlosadoItem', Tipo_Aprobacion_Item='$tipoAprobaItem', Cantidad_Aprobado=$cantidadApro, Valor_Unitario_Aprobado=$valorUniAproItem WHERE Reclamacion_Id='$idReclamacion' AND Item_id='{$value["Item_id"]}';");
                $stmt->execute();
                $stmt = null;
            }

            $stmt = null;

            /* Inicio Calculo Factura */

            $cuentaAprobado = 0;
            $cuentaGlosa = 0;
            $cuentaTipo = "1";

            $Reclamacion = Connection::connectOnly()->prepare("SELECT Total_Reclamado FROM reclamaciones_encabezado WHERE Reclamacion_Id = $idReclamacion;");
            $Reclamacion->execute();
            $valorCuenta = $Reclamacion->fetch();

            $GlosasValor = Connection::connectOnly()->prepare("SELECT sum(Valor_Glosado_Item) as ValorGlosaIni FROM reclamaciones_detalle WHERE Reclamacion_Id=$idReclamacion ;");
            $GlosasValor->execute();
            $valorGlosaIni = $GlosasValor->fetch();

            if ($valorGlosaIni['ValorGlosaIni'] == null) {
                $valorGlosaIni['ValorGlosaIni'] = 0;
            }

            if ($valorCuenta['Total_Reclamado'] <= $valorGlosaIni['ValorGlosaIni']) {
                $cuentaGlosa = $valorCuenta['Total_Reclamado'];
            } else {
                $cuentaGlosa = $valorGlosaIni['ValorGlosaIni'];
            }

            $cuentaAprobado = $valorCuenta['Total_Reclamado'] - $cuentaGlosa;

            if ($cuentaAprobado == $valorCuenta['Total_Reclamado']) {
                $cuentaTipo = "1";
            } elseif ($cuentaAprobado == 0) {
                $cuentaTipo = "3";
            } else {
                $cuentaTipo = "2";
            }

            $end = Connection::connectOnly()->prepare("UPDATE reclamaciones_encabezado SET Total_Aprobado=$cuentaAprobado, Total_Glosado=$cuentaGlosa, Tipo_Aprobacion='$cuentaTipo' WHERE Reclamacion_Id=$idReclamacion ;");

            if ($end->execute()) {
                return 'ok';
            } else {
                $error = $end->errorInfo();
                return $error;
                //return "Error Asociando";
            }
            $end = null;
        }
    }
    public static function mdlReclamacionClose($datos)
    {
        $idPerfil = $datos["idPerfil"];
        $idReclamacion = $datos["idReclamacion"];
        $usuario = $datos["usuario"];
        // 1. Cerrar en tabla de log
        switch ($idPerfil) {
            case 'Auditor':
                $stmtLog = Connection::connectOnly()->prepare("UPDATE reclamaciones_log SET fecha_auditor_fin = CURRENT_TIME WHERE reclamacion_id = '$idReclamacion' AND usuario_auditor='$usuario';");
                if ($stmtLog->execute()) {

                    // 2. Validar Cierre general factura

                    $stmtValidaCierre = Connection::connectOnly()->prepare("SELECT*FROM (SELECT reclamacion_id,CASE WHEN auditor='SI' AND fecha_auditor_fin IS NOT NULL THEN 'Cumple' WHEN auditor='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_aud,CASE WHEN medico='SI' AND fecha_medico_fin IS NOT NULL THEN 'Cumple' WHEN medico='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_med,CASE WHEN financiero='SI' AND fecha_financiero_fin IS NOT NULL THEN 'Cumple' WHEN financiero='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_finan FROM reclamaciones_log WHERE reclamacion_id='$idReclamacion') AS tabla WHERE 'No Cumple' IN (estado_aud,estado_med,estado_finan);");
                    $stmtValidaCierre->execute();
                    $validaCierre = $stmtValidaCierre->fetchAll(PDO::FETCH_ASSOC);

                    if (sizeof($validaCierre) <= 0) { // Cuenta a cerrar.
                        $stmt = Connection::connectOnly()->prepare("UPDATE reclamaciones_encabezado SET estado = 'AUDITADA', Fecha_Cierre = CURRENT_TIME, Usuario_Cierre = '$usuario' WHERE Reclamacion_Id = '$idReclamacion';");
                        if ($stmt->execute()) {
                            return "ok";
                        } else {
                            return "Error Cierre Reclamcion";
                            //$error = $stmt->errorInfo();
                            //return $error;
                        }
                    } else { // No cerrar cuenta
                        return "ok";
                    }
                } else {
                    return "Error Cierre Log";
                }
                break;
            case 'Medico':
                $stmtLog = Connection::connectOnly()->prepare("UPDATE reclamaciones_log SET fecha_medico_fin = CURRENT_TIME WHERE reclamacion_id = '$idReclamacion' AND usuario_medico='$usuario';");
                if ($stmtLog->execute()) {

                    // 2. Validar Cierre general factura

                    $stmtValidaCierre = Connection::connectOnly()->prepare("SELECT*FROM (SELECT reclamacion_id,CASE WHEN auditor='SI' AND fecha_auditor_fin IS NOT NULL THEN 'Cumple' WHEN auditor='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_aud,CASE WHEN medico='SI' AND fecha_medico_fin IS NOT NULL THEN 'Cumple' WHEN medico='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_med,CASE WHEN financiero='SI' AND fecha_financiero_fin IS NOT NULL THEN 'Cumple' WHEN financiero='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_finan FROM reclamaciones_log WHERE reclamacion_id='$idReclamacion') AS tabla WHERE 'No Cumple' IN (estado_aud,estado_med,estado_finan);");
                    $stmtValidaCierre->execute();
                    $validaCierre = $stmtValidaCierre->fetchAll(PDO::FETCH_ASSOC);

                    if (sizeof($validaCierre) <= 0) { // Cuenta a cerrar.
                        $stmt = Connection::connectOnly()->prepare("UPDATE reclamaciones_encabezado SET estado = 'AUDITADA', Fecha_Cierre = CURRENT_TIME, Usuario_Cierre = '$usuario' WHERE Reclamacion_Id = '$idReclamacion';");
                        if ($stmt->execute()) {
                            return "ok";
                        } else {
                            return "Error Cierre Reclamcion";
                            //$error = $stmt->errorInfo();
                            //return $error;
                        }
                    } else { // No cerrar cuenta
                        return "ok";
                    }
                } else {
                    return "Error Cierre Log";
                }
                break;
            case 'Financiero':
                $stmtLog = Connection::connectOnly()->prepare("UPDATE reclamaciones_log SET fecha_financiero_fin = CURRENT_TIME WHERE reclamacion_id = '$idReclamacion' AND usuario_financiero='$usuario';");
                if ($stmtLog->execute()) {

                    // 2. Validar Cierre general factura

                    $stmtValidaCierre = Connection::connectOnly()->prepare("SELECT*FROM (SELECT reclamacion_id,CASE WHEN auditor='SI' AND fecha_auditor_fin IS NOT NULL THEN 'Cumple' WHEN auditor='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_aud,CASE WHEN medico='SI' AND fecha_medico_fin IS NOT NULL THEN 'Cumple' WHEN medico='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_med,CASE WHEN financiero='SI' AND fecha_financiero_fin IS NOT NULL THEN 'Cumple' WHEN financiero='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_finan FROM reclamaciones_log WHERE reclamacion_id='$idReclamacion') AS tabla WHERE 'No Cumple' IN (estado_aud,estado_med,estado_finan);");
                    $stmtValidaCierre->execute();
                    $validaCierre = $stmtValidaCierre->fetchAll(PDO::FETCH_ASSOC);

                    if (sizeof($validaCierre) <= 0) { // Cuenta a cerrar.
                        $stmt = Connection::connectOnly()->prepare("UPDATE reclamaciones_encabezado SET estado = 'AUDITADA', Fecha_Cierre = CURRENT_TIME, Usuario_Cierre = '$usuario' WHERE Reclamacion_Id = '$idReclamacion';");
                        if ($stmt->execute()) {
                            return "ok";
                        } else {
                            return "Error Cierre Reclamcion";
                            //$error = $stmt->errorInfo();
                            //return $error;
                        }
                    } else { // No cerrar cuenta
                        return "ok";
                    }
                } else {
                    return "Error Cierre Log";
                }
                break;
            case 'Validaciones':
                $stmtLog = Connection::connectOnly()->prepare("UPDATE reclamaciones_log SET fecha_validaciones_fin = CURRENT_TIME WHERE reclamacion_id = '$idReclamacion' AND usuario_validaciones='$usuario';");
                if ($stmtLog->execute()) {

                    // 2. Validar Cierre general factura

                    $stmtValidaCierre = Connection::connectOnly()->prepare("SELECT*FROM (SELECT reclamacion_id,CASE WHEN auditor='SI' AND fecha_auditor_fin IS NOT NULL THEN 'Cumple' WHEN auditor='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_aud,CASE WHEN medico='SI' AND fecha_medico_fin IS NOT NULL THEN 'Cumple' WHEN medico='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_med,CASE WHEN financiero='SI' AND fecha_financiero_fin IS NOT NULL THEN 'Cumple' WHEN financiero='NO' THEN 'No Aplica' ELSE 'No Cumple' END AS estado_finan FROM reclamaciones_log WHERE reclamacion_id='$idReclamacion') AS tabla WHERE 'No Cumple' IN (estado_aud,estado_med,estado_finan);");
                    $stmtValidaCierre->execute();
                    $validaCierre = $stmtValidaCierre->fetchAll(PDO::FETCH_ASSOC);

                    if (sizeof($validaCierre) <= 0) { // Cuenta a cerrar.
                        $stmt = Connection::connectOnly()->prepare("UPDATE reclamaciones_encabezado SET estado = 'AUDITADA' WHERE Reclamacion_Id = '$idReclamacion';");
                        if ($stmt->execute()) {
                            return "ok";
                        } else {
                            return "Error Cierre Reclamcion";
                            //$error = $stmt->errorInfo();
                            //return $error;
                        }
                    } else { // No cerrar cuenta
                        return "ok";
                    }
                } else {
                    return "Error Cierre Log";
                }
                break;
            default:
                return "Error Perfil";
                break;
        }



        $stmt = null;
    }

    public static function mdlGlosaUniDelete($tablaOrigin, $tablaDelete, $datos)
    {
        // Insertar glosa a borrar en la tabla de borrado

        $stmtInsert = Connection::connectOnly()->prepare("INSERT INTO $tablaDelete (SELECT Id_Glosa,Reclamacion_Id,Item_id,Clasificacion_Glosa,Cod_Glosa,Descripcion_Glosa,Justificacion_Glosa,Usuario,Fecha_Glosa,Tipo_Glosa,Num_Item_Reclamado,Valor_Item_Reclamado, Valor_Total_Reclamado,Num_Item_Glosa,Valor_Item_Glosa,Valor_Total_Glosa,Valor_Total_Pagar,Estado, :usuario, CURRENT_TIME FROM $tablaOrigin WHERE id_glosa=:idGlosa);");
        $stmtInsert->bindParam(":idGlosa", $datos["idGlosa"], PDO::PARAM_STR);
        $stmtInsert->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);


        if ($stmtInsert->execute()) {

            // Borrar Glosa
            $stmtDelete = Connection::connectOnly()->prepare("DELETE from $tablaOrigin WHERE id_glosa=:idGlosa;");
            $stmtDelete->bindParam(":idGlosa", $datos["idGlosa"], PDO::PARAM_STR);
            if ($stmtDelete->execute()) {
                return "ok";
            } else {
                //return "errorDelete";
                $error = $stmtDelete->errorInfo();
                return $error;
            }
        } else {
            //return "errorInsert";
            $error = $stmtInsert->errorInfo();
            return $error;
        }

        $stmtInsert = null;
        $stmtDelete = null;
    }

    public static function mdlGlosaMasivoDelete($tablaOrigin, $tablaDelete, $datos)
    {

        $idGlosas = $datos['idGlosas'];
        // Insertar glosa a borrar en la tabla de borrado
        $stmtInsert = Connection::connectOnly()->prepare("INSERT INTO $tablaDelete (SELECT Id_Glosa,Reclamacion_Id,Item_id,Clasificacion_Glosa,Cod_Glosa,Descripcion_Glosa,Justificacion_Glosa,Usuario,Fecha_Glosa,Tipo_Glosa,Num_Item_Reclamado,Valor_Item_Reclamado, Valor_Total_Reclamado,Num_Item_Glosa,Valor_Item_Glosa,Valor_Total_Glosa,Valor_Total_Pagar,Estado, :usuario, CURRENT_TIME FROM $tablaOrigin WHERE id_glosa in ('" . implode("', '", $idGlosas) . "'));");
        $stmtInsert->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

        if ($stmtInsert->execute()) {

            // Borrar Glosa
            $stmtDelete = Connection::connectOnly()->prepare("DELETE from $tablaOrigin WHERE id_glosa in ('" . implode("', '", $idGlosas) . "');");

            if ($stmtDelete->execute()) {
                return "ok";
            } else {
                //return "errorDelete";
                $error = $stmtDelete->errorInfo();
                return $error;
            }
        } else {
            //return "errorInsert";
            $error = $stmtInsert->errorInfo();
            return $error;
        }

        $stmtInsert = null;
        $stmtDelete = null;
    }

    static public function mdlObtenerDatos($tabla, $item, $valor)
    {

        if ($item == null) {

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();
        } else {

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        }

        $stmt = null;
    }

    public static function mdlSearchBill($datos)
    {


        $stmt = Connection::connectOnly()->prepare("SELECT * FROM reclamaciones_encabezado WHERE {$datos["filtro"]} IN ({$datos["valores"]});");
        //$stmt->bindParam(":filtro", $datos["filtro"], PDO::PARAM_STR);
        //$stmt->bindParam(":valor", $datos["valores"], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //return $perfil;
        $stmt = null;
    }

    static public function mdlTablaAnotacion($idReclamacion){

        $stmt = Connection::connectOnly()->prepare("SELECT  Anotacion_Id,Reclamacion_Id,Numero_Radicacion,Anotacion_Observacion,Usuario_Creacion,Fecha_Creacion FROM reclamaciones_anotaciones WHERE (Reclamacion_Id = :idReclamacion AND Estado = 1 );");

        $stmt->bindParam(":idReclamacion",$idReclamacion,PDO::PARAM_STR);
        if($stmt->execute()){

            return $stmt->fetchAll();
        }else{
            return $stmt->errorInfo();
        }

        $stmt = null;


    }

    static public function mdlañadirAnotacion($tabla, $datos){
        
        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla(Reclamacion_Id,Anotacion_Observacion,Usuario_Creacion,Numero_Radicacion)VALUES (:idReclamacion,:Anotacion_Observacion,:Usuario_Creacion,:Numero_Radicacion)");

        $stmt->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);
        $stmt->bindParam(":Anotacion_Observacion", $datos["Anotacion_Observacion"], PDO::PARAM_STR);
        $stmt->bindParam(":Usuario_Creacion", $datos["Usuario_Creacion"], PDO::PARAM_STR);
        $stmt->bindParam(":Numero_Radicacion", $datos["Numero_Radicacion"],PDO::PARAM_STR);

        if ($stmt->execute()) {
            
            return "ok";

        } else {

            
            return "error";
        }

        $stmt = null;
        
    }

    static public function mdleliminarAnotacion($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE reclamaciones_anotaciones SET Estado = 0 , Fecha_Eliminacion=CURRENT_TIMESTAMP, Usuario_Eliminacion = :Usuario_Eliminacion WHERE Anotacion_Id=:Anotacion_Id");

        $stmt->bindParam(":Anotacion_Id",$datos["Anotacion_Id"], PDO::PARAM_STR);
        $stmt->bindParam(":Usuario_Eliminacion",$datos["Usuario_Eliminacion"], PDO::PARAM_STR);

        if ($stmt->execute()){ // Asignacion de la cuenta

            return "Eliminado";
            
        } else {

            return "Error en la eliminacion";
        }
        $stmt = null;

    }

    public static function mdlReclamacionInfoXml($idReclamacion)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT reclamaciones_xml.* , reclamaciones_encabezado.Numero_Radicacion,reclamaciones_encabezado.Fecha_Radicacion_Consolidado, reclamaciones_encabezado.Numero_Paquete, reclamaciones_encabezado.Tipo_Doc_Reclamante,reclamaciones_encabezado.Total_Reclamado FROM reclamaciones_xml JOIN reclamaciones_encabezado ON reclamaciones_xml.reclamacion_id = reclamaciones_encabezado.Reclamacion_Id WHERE reclamaciones_xml.reclamacion_id= $idReclamacion;");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //return $perfil;
        $stmt = null;
    }
}

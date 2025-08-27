<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');


class ModeloHistoricos
{
    public static function mdlHistoricosEvento($datos)
    {
        $llave = Connection::connectOnly()->prepare("SELECT Llave,Numero_Radicacion FROM reclamaciones_encabezado WHERE Reclamacion_Id =:idReclamacion;");
        $llave->bindParam(":idReclamacion", $datos["idReclamacion"], PDO::PARAM_STR);
        $llave->execute();
        $llaves = $llave->fetch(PDO::FETCH_ASSOC);

        //print_r($llaves['Llave']);

        $Historicos = Connection::connectOnly()->prepare("SELECT * from (SELECT * from( 
            SELECT Numero_Paquete, Numero_Radicacion, Reclamacion_ID, Numero_Factura, Fecha_Hora_Evento, Razon_Social_Reclamante, Numero_Doc_Reclamante, Primer_Nombre_Victima, Segundo_Nombre_Victima, Primer_Apellido_Victima, Segundo_Apellido_Victima, Tipo_Doc_Victima, Numero_Doc_Victima, Total_Reclamado, Total_Aprobado, Codigo_Entrada, Llave from reclamaciones_encabezado where MATCH(llave) AGAINST (:llave IN BOOLEAN MODE) UNION
            SELECT 'Historico' as tipo, Numero_Radicacion, ReclamacionID, Numero_Factura, Fecha_Hora_Evento, Razon_Social_Reclamante, Numero_Doc_Reclamante,  Primer_Nombre_Victima, Segundo_Nombre_Victima, Primer_Apellido_Victima, Segundo_Apellido_Victima, Tipo_Doc_Victima, Numero_Doc_Victima, Total_Reclamado, Total_Aprobado, Codigo_Entrada, Llave from HISTORICO_ENCABEZADO_RECLAMACIONES where MATCH(llave) AGAINST (:llave IN BOOLEAN MODE) 
            ) as tabla where Reclamacion_ID != :idReclamacion UNION   
            SELECT * from( 
            SELECT Numero_Paquete, Numero_Radicacion, Reclamacion_ID, Numero_Factura, Fecha_Hora_Evento, Razon_Social_Reclamante, Numero_Doc_Reclamante, Primer_Nombre_Victima, Segundo_Nombre_Victima, Primer_Apellido_Victima, Segundo_Apellido_Victima, Tipo_Doc_Victima, Numero_Doc_Victima, Total_Reclamado, Total_Aprobado, Codigo_Entrada, Llave from reclamaciones_encabezado where Numero_Radicacion=:numRad UNION
            SELECT 'Historico' as tipo, Numero_Radicacion, ReclamacionID, Numero_Factura, Fecha_Hora_Evento, Razon_Social_Reclamante, Numero_Doc_Reclamante,  Primer_Nombre_Victima, Segundo_Nombre_Victima, Primer_Apellido_Victima, Segundo_Apellido_Victima, Tipo_Doc_Victima, Numero_Doc_Victima, Total_Reclamado, Total_Aprobado, Codigo_Entrada, Llave from HISTORICO_ENCABEZADO_RECLAMACIONES where Numero_Radicacion=:numRad
            ) as tabla where Reclamacion_ID != :idReclamacion ) TablaFin ORDER BY Numero_Paquete Desc;");

        /*$Historicos = Connection::connectOnly()->prepare("SELECT * from( 
			SELECT Numero_Paquete, Numero_Radicacion, Reclamacion_ID, Numero_Factura, Fecha_Hora_Evento, Razon_Social_Reclamante, Numero_Doc_Reclamante, Primer_Nombre_Victima, Segundo_Nombre_Victima, Primer_Apellido_Victima, Segundo_Apellido_Victima, Tipo_Doc_Victima, Numero_Doc_Victima, Total_Reclamado, Total_Aprobado, Codigo_Entrada from reclamaciones_encabezado where MATCH(llave) AGAINST (:llave IN BOOLEAN MODE) UNION
			SELECT 'Historico' as tipo, Numero_Radicacion, ReclamacionID, Numero_Factura, Fecha_Hora_Evento, Razon_Social_Reclamante, Numero_Doc_Reclamante,  Primer_Nombre_Victima, Segundo_Nombre_Victima, Primer_Apellido_Victima, Segundo_Apellido_Victima, Tipo_Doc_Victima, Numero_Doc_Victima, Total_Reclamado, Total_Aprobado, Codigo_Entrada from HISTORICO_ENCABEZADO_RECLAMACIONES where MATCH(llave) AGAINST (:llave IN BOOLEAN MODE)
			) as tabla where Reclamacion_ID != :idReclamacion ;");*/

        $Historicos->bindParam(':llave', $llaves['Llave'], PDO::PARAM_STR);
        $Historicos->bindParam(':numRad', $llaves['Numero_Radicacion'], PDO::PARAM_STR);
        $Historicos->bindParam(':idReclamacion', $datos["idReclamacion"], PDO::PARAM_STR); // Si es entero

        $Historicos->execute();
        return $Historicos->fetchAll(PDO::FETCH_ASSOC);

        //$Historicos = null;
    }

    public static function mdlReclamacionInfo($idReclamacion)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT *, CASE WHEN Tipo_Aprobacion=1 THEN 'Aprobado' WHEN Tipo_Aprobacion=2 THEN 'Aprobado Parcial' WHEN Tipo_Aprobacion=3 THEN 'No Aprobado' END AS Tipo_Aprobacion_New FROM historico_encabezado_reclamaciones WHERE ReclamacionID = $idReclamacion;");

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
        //return $perfil;
        $stmt = null;
    }

    public static function mdlReclamacionDetail($idReclamacion)
    {
        //$stmt = Connection::connectOnly()->prepare("SELECT * FROM historico_detalle_reclamaciones WHERE Reclamacion_Id = $idReclamacion;");

        $stmt = Connection::connectOnly()->prepare("SELECT   historico_detalle_reclamaciones.*,   GROUP_CONCAT( historico_glosas_reclamaciones.Codigo_glosa SEPARATOR ' | ' ) AS Glosa  FROM   historico_detalle_reclamaciones   LEFT JOIN historico_glosas_reclamaciones ON historico_detalle_reclamaciones.reclamacionid = historico_glosas_reclamaciones.ReclamacionID    AND historico_detalle_reclamaciones.Itemid = historico_glosas_reclamaciones.Itemid  WHERE   historico_detalle_reclamaciones.reclamacionid = $idReclamacion  GROUP BY   historico_detalle_reclamaciones.Itemid;");
        
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $stmt->errorInfo();
        }
        $stmt = null;
    }

    public static function mdlReclamacionGlosas($idReclamacion)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT * FROM historico_glosas_reclamaciones WHERE ReclamacionID = $idReclamacion;");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //return $perfil;
        $stmt = null;
    }

    static public function mdlTablaAnotacion($idReclamacion){

        $stmt = Connection::connectOnly()->prepare("SELECT reclamacionID, Numero_Radicacion, Descripcion, Usuario, Fecha FROM historico_anotaciones_reclamaciones WHERE (reclamacionID = :idReclamacion );");

        $stmt->bindParam(":idReclamacion",$idReclamacion,PDO::PARAM_STR);
        if($stmt->execute()){

            return $stmt->fetchAll();
        }else{
            return $stmt->errorInfo();
        }

        $stmt = null;


    }

}

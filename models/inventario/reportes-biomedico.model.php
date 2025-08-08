<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelReportesInventarioBiomedico{

    static public function mdlListaEquiposBiomedicosTipoMantenimiento($tipoMantenimiento){

        $stmt = Connection::connectOnly()->prepare("SELECT inv_e.*, inv_tm.tipo_mantenimiento, inv_tm.frecuencia, inv_em.id_mantenimiento_biomedico, inv_em.fecha_mantenimiento, inv_h.forma_adquisicion, inv_h.fecha_fin_garantia, inv_h.vida_util, inv_h.instalacion
            FROM inventario_equipos_biomedicos_historicos inv_h JOIN inventario_equipos_biomedicos inv_e ON inv_h.id_equipo_biomedico = inv_e.id JOIN inventario_equipos_biomedicos_tipos_mante inv_tm ON inv_e.id = inv_tm.id_equipo_biomedico LEFT JOIN ( SELECT em.* FROM inventario_equipos_biomedicos_mantenimientos em
            INNER JOIN ( SELECT id_equipo_biomedico, MAX(fecha_mantenimiento) AS ultima_fecha FROM inventario_equipos_biomedicos_mantenimientos WHERE is_active = 1 AND fecha_mantenimiento IS NOT NULL GROUP BY id_equipo_biomedico ) ult ON em.id_equipo_biomedico = ult.id_equipo_biomedico AND em.fecha_mantenimiento = ult.ultima_fecha WHERE em.is_active = 1 ) inv_em ON inv_e.id = inv_em.id_equipo_biomedico
            WHERE inv_tm.is_active = 1 AND inv_tm.tipo_mantenimiento = '$tipoMantenimiento'");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaReportesBiomedicos($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE estado = 1");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

}
<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelInventarioBiomedico{

    static public function mdlListaEquiposBiomedicosReserva($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE active = 1 AND servicio = 'EQUIPOS DE RESERVA'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidacionTipoMantenimiento($idEquipoBiomedico, $tipoMantenimiento, $hoy){

        $stmt = Connection::connectOnly()->prepare("SELECT inv_e.*, inv_tm.tipo_mantenimiento, inv_tm.frecuencia, inv_em.id_mantenimiento_biomedico, inv_em.fecha_mantenimiento, inv_h.instalacion, DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) AS dias_desde_mantenimiento,
            CASE WHEN inv_tm.frecuencia = 'TRIMESTRAL' THEN CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 90 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (90 - 30) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'CUATRIMESTRAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 120 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (120 - 60) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'SEMESTRAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 182 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (182 - 60) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'ANUAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 365 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (365 - 90) THEN 'A VENCER' ELSE 'A TIEMPO' END ELSE 'NO APLICA' END AS estado_mantenimiento
            FROM inventario_equipos_biomedicos_historicos inv_h JOIN inventario_equipos_biomedicos inv_e ON inv_h.id_equipo_biomedico = inv_e.id JOIN inventario_equipos_biomedicos_tipos_mante inv_tm  ON inv_e.id = inv_tm.id_equipo_biomedico LEFT JOIN ( SELECT em.* FROM inventario_equipos_biomedicos_mantenimientos em INNER JOIN ( SELECT id_equipo_biomedico, MAX(fecha_mantenimiento) AS ultima_fecha FROM inventario_equipos_biomedicos_mantenimientos WHERE is_active = 1 AND fecha_mantenimiento IS NOT NULL AND tipo_mantenimiento = '$tipoMantenimiento' GROUP BY id_equipo_biomedico) ult ON em.id_equipo_biomedico = ult.id_equipo_biomedico AND em.fecha_mantenimiento = ult.ultima_fecha WHERE em.is_active = 1 ) inv_em ON inv_e.id = inv_em.id_equipo_biomedico
            WHERE inv_tm.is_active = 1 AND inv_tm.tipo_mantenimiento = '$tipoMantenimiento' AND inv_e.id = $idEquipoBiomedico HAVING estado_mantenimiento != 'A TIEMPO'");


        if($stmt->execute()){

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaEstadosMantenimientosBiomedicosCl($hoy){

        $stmt = Connection::connectOnly()->prepare("SELECT inv_e.*, inv_tm.tipo_mantenimiento, inv_tm.frecuencia, inv_em.id_mantenimiento_biomedico, inv_em.fecha_mantenimiento, inv_h.instalacion, DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) AS dias_desde_mantenimiento,
            CASE WHEN inv_tm.frecuencia = 'TRIMESTRAL' THEN CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 90 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (90 - 30) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'CUATRIMESTRAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 120 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (120 - 60) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'SEMESTRAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 182 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (182 - 60) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'ANUAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 365 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (365 - 90) THEN 'A VENCER' ELSE 'A TIEMPO' END ELSE 'NO APLICA' END AS estado_mantenimiento
            FROM inventario_equipos_biomedicos_historicos inv_h JOIN inventario_equipos_biomedicos inv_e ON inv_h.id_equipo_biomedico = inv_e.id JOIN inventario_equipos_biomedicos_tipos_mante inv_tm  ON inv_e.id = inv_tm.id_equipo_biomedico LEFT JOIN ( SELECT em.* FROM inventario_equipos_biomedicos_mantenimientos em INNER JOIN ( SELECT id_equipo_biomedico, MAX(fecha_mantenimiento) AS ultima_fecha FROM inventario_equipos_biomedicos_mantenimientos WHERE is_active = 1 AND fecha_mantenimiento IS NOT NULL AND tipo_mantenimiento = 'CL' GROUP BY id_equipo_biomedico) ult ON em.id_equipo_biomedico = ult.id_equipo_biomedico AND em.fecha_mantenimiento = ult.ultima_fecha WHERE em.is_active = 1 ) inv_em ON inv_e.id = inv_em.id_equipo_biomedico
            WHERE inv_tm.is_active = 1 AND inv_tm.tipo_mantenimiento = 'CL' HAVING estado_mantenimiento != 'A TIEMPO'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        

    }

    static public function mdlListaEstadosMantenimientosBiomedicosVld($hoy){

        $stmt = Connection::connectOnly()->prepare("SELECT inv_e.*, inv_tm.tipo_mantenimiento, inv_tm.frecuencia, inv_em.id_mantenimiento_biomedico, inv_em.fecha_mantenimiento, inv_h.instalacion, DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) AS dias_desde_mantenimiento,
            CASE WHEN inv_tm.frecuencia = 'TRIMESTRAL' THEN CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 90 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (90 - 30) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'CUATRIMESTRAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 120 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (120 - 60) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'SEMESTRAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 182 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (182 - 60) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'ANUAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 365 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (365 - 90) THEN 'A VENCER' ELSE 'A TIEMPO' END ELSE 'NO APLICA' END AS estado_mantenimiento
            FROM inventario_equipos_biomedicos_historicos inv_h JOIN inventario_equipos_biomedicos inv_e ON inv_h.id_equipo_biomedico = inv_e.id JOIN inventario_equipos_biomedicos_tipos_mante inv_tm  ON inv_e.id = inv_tm.id_equipo_biomedico LEFT JOIN ( SELECT em.* FROM inventario_equipos_biomedicos_mantenimientos em INNER JOIN ( SELECT id_equipo_biomedico, MAX(fecha_mantenimiento) AS ultima_fecha FROM inventario_equipos_biomedicos_mantenimientos WHERE is_active = 1 AND fecha_mantenimiento IS NOT NULL AND tipo_mantenimiento = 'VLD' GROUP BY id_equipo_biomedico) ult ON em.id_equipo_biomedico = ult.id_equipo_biomedico AND em.fecha_mantenimiento = ult.ultima_fecha WHERE em.is_active = 1 ) inv_em ON inv_e.id = inv_em.id_equipo_biomedico
            WHERE inv_tm.is_active = 1 AND inv_tm.tipo_mantenimiento = 'VLD' HAVING estado_mantenimiento != 'A TIEMPO'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        

    }

    static public function mdlListaEstadosMantenimientosBiomedicosClbr($hoy){

        $stmt = Connection::connectOnly()->prepare("SELECT inv_e.*, inv_tm.tipo_mantenimiento, inv_tm.frecuencia, inv_em.id_mantenimiento_biomedico, inv_em.fecha_mantenimiento, inv_h.instalacion, DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) AS dias_desde_mantenimiento,
            CASE WHEN inv_tm.frecuencia = 'TRIMESTRAL' THEN CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 90 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (90 - 30) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'CUATRIMESTRAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 120 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (120 - 60) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'SEMESTRAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 182 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (182 - 60) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'ANUAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 365 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (365 - 90) THEN 'A VENCER' ELSE 'A TIEMPO' END ELSE 'NO APLICA' END AS estado_mantenimiento
            FROM inventario_equipos_biomedicos_historicos inv_h JOIN inventario_equipos_biomedicos inv_e ON inv_h.id_equipo_biomedico = inv_e.id JOIN inventario_equipos_biomedicos_tipos_mante inv_tm  ON inv_e.id = inv_tm.id_equipo_biomedico LEFT JOIN ( SELECT em.* FROM inventario_equipos_biomedicos_mantenimientos em INNER JOIN ( SELECT id_equipo_biomedico, MAX(fecha_mantenimiento) AS ultima_fecha FROM inventario_equipos_biomedicos_mantenimientos WHERE is_active = 1 AND fecha_mantenimiento IS NOT NULL AND tipo_mantenimiento = 'CLBR'  GROUP BY id_equipo_biomedico) ult ON em.id_equipo_biomedico = ult.id_equipo_biomedico AND em.fecha_mantenimiento = ult.ultima_fecha WHERE em.is_active = 1 ) inv_em ON inv_e.id = inv_em.id_equipo_biomedico
            WHERE inv_tm.is_active = 1 AND inv_tm.tipo_mantenimiento = 'CLBR' HAVING estado_mantenimiento != 'A TIEMPO'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        

    }

    static public function mdlObtenerHistorialMantenimientos($idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT 'MANTENIMIENTO CORRECTIVO' AS tipo_mantenimiento, observaciones_mantenimiento, fecha_crea FROM inventario_equipos_mantenimientos 
            WHERE id_equipo = $idEquipoBiomedico AND categoria_activo = 'EQUIPOBIOMEDICO'
            UNION ALL
            SELECT CONCAT('MANTENIMIENTO',' ', tipo_mantenimiento) AS tipo_mantenimiento, observaciones_mantenimiento, fecha_crea FROM inventario_equipos_biomedicos_mantenimientos 
            WHERE id_equipo_biomedico = $idEquipoBiomedico ORDER BY fecha_crea DESC");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::PARAM_STR);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerOtrosMto($idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_equipos_biomedicos_tipos_mante WHERE id_equipo_biomedico = :id_equipo_biomedico AND tipo_mantenimiento != 'MTTO' AND is_active = 1");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::PARAM_STR);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerMtoBiomedico($idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_equipos_biomedicos_tipos_mante WHERE id_equipo_biomedico = :id_equipo_biomedico AND tipo_mantenimiento = 'MTTO' AND is_active = 1");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch(PDO::PARAM_STR);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerTiposMantenimientosEquipoBiomedico($idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_equipos_biomedicos_tipos_mante WHERE id_equipo_biomedico = :id_equipo_biomedico AND is_active = 1");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::PARAM_STR);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarTipoMantenimientoBiomedico($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE inventario_equipos_biomedicos_tipos_mante SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = :fecha_elimina WHERE id_tipo_mante_bio = :id_tipo_mante_bio");

        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_elimina", $datos["fecha_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":id_tipo_mante_bio", $datos["id_tipo_mante_bio"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAgregarTipoMantenimientoBiomedico($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO inventario_equipos_biomedicos_tipos_mante (id_equipo_biomedico, tipo_mantenimiento, frecuencia, usuario_crea) VALUES (:id_equipo_biomedico, :tipo_mantenimiento, :frecuencia, :usuario_crea)");

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_mantenimiento", $datos["tipo_mantenimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":frecuencia", $datos["frecuencia"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidarTipoMantenimientro($idEquipoBiomedico, $tipoMantenimiento){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_equipos_biomedicos_tipos_mante WHERE id_equipo_biomedico = :id_equipo_biomedico AND tipo_mantenimiento = :tipo_mantenimiento AND is_active = 1");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);
        $stmt->bindParam(":tipo_mantenimiento", $tipoMantenimiento, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaEquipoBiomedicoTiposMantenimientos($idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_equipos_biomedicos_tipos_mante WHERE id_equipo_biomedico = :id_equipo_biomedico AND is_active = 1");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarSedeBiomedico($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE inventario_equipos_biomedicos SET sede = :sede, activo_fijo = :activo_fijo, ubicacion = :ubicacion WHERE id = :id");

        $stmt->bindParam(":id", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":sede", $datos["sede_new"], PDO::PARAM_STR);
        $stmt->bindParam(":activo_fijo", $datos["activo_fijo_new"], PDO::PARAM_STR);
        $stmt->bindParam(":ubicacion", $datos["ubicacion_new"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaEstadosMantenimientosBiomedicosMto($hoy){

        $stmt = Connection::connectOnly()->prepare("SELECT inv_e.*, inv_tm.tipo_mantenimiento, inv_tm.frecuencia, inv_em.id_mantenimiento_biomedico, inv_em.fecha_mantenimiento, inv_h.instalacion, DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) AS dias_desde_mantenimiento,
            CASE WHEN inv_tm.frecuencia = 'TRIMESTRAL' THEN CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 90 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (90 - 30) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'CUATRIMESTRAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 120 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (120 - 60) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'SEMESTRAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 182 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (182 - 60) THEN 'A VENCER' ELSE 'A TIEMPO' END WHEN inv_tm.frecuencia = 'ANUAL' THEN
            CASE WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= 365 THEN 'VENCIDO' WHEN DATEDIFF('$hoy', COALESCE(inv_em.fecha_mantenimiento, inv_h.instalacion)) >= (365 - 90) THEN 'A VENCER' ELSE 'A TIEMPO' END ELSE 'NO APLICA' END AS estado_mantenimiento
            FROM inventario_equipos_biomedicos_historicos inv_h JOIN inventario_equipos_biomedicos inv_e ON inv_h.id_equipo_biomedico = inv_e.id JOIN inventario_equipos_biomedicos_tipos_mante inv_tm  ON inv_e.id = inv_tm.id_equipo_biomedico LEFT JOIN ( SELECT em.* FROM inventario_equipos_biomedicos_mantenimientos em INNER JOIN ( SELECT id_equipo_biomedico, MAX(fecha_mantenimiento) AS ultima_fecha FROM inventario_equipos_biomedicos_mantenimientos WHERE is_active = 1 AND fecha_mantenimiento IS NOT NULL AND tipo_mantenimiento = 'MTTO' GROUP BY id_equipo_biomedico) ult ON em.id_equipo_biomedico = ult.id_equipo_biomedico AND em.fecha_mantenimiento = ult.ultima_fecha WHERE em.is_active = 1 ) inv_em ON inv_e.id = inv_em.id_equipo_biomedico
            WHERE inv_tm.is_active = 1 AND inv_tm.tipo_mantenimiento = 'MTTO' HAVING estado_mantenimiento != 'A TIEMPO'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        

    }

    static public function mdlEliminarMantenimientoBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = :fecha_elimina WHERE id_mantenimiento_biomedico = :id_mantenimiento_biomedico");

        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_elimina", $datos["fecha_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":id_mantenimiento_biomedico", $datos["id_mantenimiento_biomedico"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerMantenimientosEquipoBiomedico($idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_equipos_biomedicos_solicitudes_mantenimientos WHERE id_equipo_biomedico = :id_equipo_biomedico AND estado = 'REALIZADO' ORDER BY fecha_crea DESC LIMIT 2");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);
    
        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaSolicitudesActaBajaEquipoBio($tabla, $idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_equipo_biomedico = :id_equipo_biomedico");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);
    
        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAgregarSolicitudBajaEquipoBio($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_equipo_biomedico, nombre_solicitante, cargo, concepto_baja, reciclaje, empresa_responsable_reci, disposicion, empresa_responsable_dispo, usuario_crea) VALUES (:id_equipo_biomedico, :nombre_solicitante, :cargo, :concepto_baja, :reciclaje, :empresa_responsable_reci, :disposicion, :empresa_responsable_dispo, :usuario_crea)");

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_solicitante", $datos["nombre_solicitante"], PDO::PARAM_STR);
        $stmt->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);
        $stmt->bindParam(":concepto_baja", $datos["concepto_baja"], PDO::PARAM_STR);
        $stmt->bindParam(":reciclaje", $datos["reciclaje"], PDO::PARAM_STR);
        $stmt->bindParam(":empresa_responsable_reci", $datos["empresa_responsable_reci"], PDO::PARAM_STR);
        $stmt->bindParam(":disposicion", $datos["disposicion"], PDO::PARAM_STR);
        $stmt->bindParam(":empresa_responsable_dispo", $datos["empresa_responsable_dispo"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaSolicitudesMantenimientosEquipoBio($tabla, $idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_equipo_biomedico = :id_equipo_biomedico");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);
    
        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAgregarSolicitudMantenimientoCorrectivoEquipoBio($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_equipo_biomedico, orden_no, cargo, descripcion_incidencia, fecha_ejecucion, responsable, requiere_repuesto, repuestos_necesarios, usuario_crea, descripcion_falla) VALUES (:id_equipo_biomedico, :orden_no, :cargo, :descripcion_incidencia, :fecha_ejecucion, :responsable, :requiere_repuesto, :repuestos_necesarios, :usuario_crea, :descripcion_falla)");

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":orden_no", $datos["orden_no"], PDO::PARAM_STR);
        $stmt->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion_incidencia", $datos["descripcion_incidencia"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_ejecucion", $datos["fecha_ejecucion"], PDO::PARAM_STR);
        $stmt->bindParam(":responsable", $datos["responsable"], PDO::PARAM_STR);
        $stmt->bindParam(":requiere_repuesto", $datos["requiere_repuesto"], PDO::PARAM_STR);
        $stmt->bindParam(":repuestos_necesarios", $datos["repuestos_necesarios"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion_falla", $datos["descripcion_falla"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaSolicitudesTrasladoEquipoBio($tabla, $idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_equipo_biomedico = :id_equipo_biomedico");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);
    
        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAgregarSolicitudTrasladoEquipoBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_equipo_biomedico, tiempo_estimado_salida, motivo_salida, observaciones, sede_new, activo_fijo_new, ubicacion_new, usuario_crea, sede_old, activo_fijo_old, ubicacion_old, recibido_por) VALUES (:id_equipo_biomedico, :tiempo_estimado_salida, :motivo_salida, :observaciones, :sede_new, :activo_fijo_new, :ubicacion_new, :usuario_crea, :sede_old, :activo_fijo_old, :ubicacion_old, :recibido_por)");

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":tiempo_estimado_salida", $datos["tiempo_estimado_salida"], PDO::PARAM_STR);
        $stmt->bindParam(":motivo_salida", $datos["motivo_salida"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
        $stmt->bindParam(":sede_new", $datos["sede_new"], PDO::PARAM_STR);
        $stmt->bindParam(":activo_fijo_new", $datos["activo_fijo_new"], PDO::PARAM_STR);
        $stmt->bindParam(":ubicacion_new", $datos["ubicacion_new"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":sede_old", $datos["sede_old"], PDO::PARAM_STR);
        $stmt->bindParam(":activo_fijo_old", $datos["activo_fijo_old"], PDO::PARAM_STR);
        $stmt->bindParam(":ubicacion_old", $datos["ubicacion_old"], PDO::PARAM_STR);
        $stmt->bindParam(":recibido_por", $datos["recibido_por"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidacionMantenimientoEquipoBiomedico($hoy, $idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT inv_e.*, inv_em.fecha_mantenimiento, DATEDIFF('$hoy', inv_em.fecha_mantenimiento) AS dias_desde_mantenimiento, CASE WHEN inv_e.frecuencia_mantenimiento = 'SEMESTRAL' THEN CASE WHEN DATEDIFF('$hoy', inv_em.fecha_mantenimiento) >= 182.5 THEN 'MANTENIMIENTO SEMESTRAL VENCIDO' WHEN DATEDIFF('$hoy', inv_em.fecha_mantenimiento) >= (182.5 - 60) THEN 'MANTENIMIENTO SEMESTRAL PRÓXIMO A VENCER' ELSE 'MANTENIMIENTO SEMESTRAL A TIEMPO' END WHEN inv_e.frecuencia_mantenimiento = 'ANUAL' THEN CASE WHEN DATEDIFF('$hoy', inv_em.fecha_mantenimiento) >= 365 THEN 'MANTENIMIENTO ANUAL VENCIDO' WHEN DATEDIFF('$hoy', inv_em.fecha_mantenimiento) >= (365 - 90) THEN 'MANTENIMIENTO ANUAL PRÓXIMO A VENCER' ELSE 'MANTENIMIENTO ANUAL A TIEMPO' END ELSE 'NO APLICA' END AS estado_mantenimiento FROM inventario_equipos_biomedicos inv_e JOIN inventario_equipos_biomedicos_mantenimientos inv_em ON inv_e.id = inv_em.id_equipo_biomedico
            WHERE id_equipo_biomedico = :id_equipo_biomedico AND inv_em.is_active = 1 ORDER BY inv_em.fecha_mantenimiento DESC LIMIT 1");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaMantenimientosEquiposBiomedicos($idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT inv_m.*, inv_pm.nombre FROM inventario_equipos_biomedicos_mantenimientos inv_m JOIN inventario_par_tipos_mantenimientos_biomedicos inv_pm ON inv_m.tipo_mantenimiento = inv_pm.tipo
            WHERE id_equipo_biomedico = :id_equipo_biomedico AND is_active = 1");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlAgregarMantenimientoBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_equipo_biomedico, tipo_mantenimiento, fecha_mantenimiento, observaciones_mantenimiento, usuario_crea, ruta_archivo) VALUES (:id_equipo_biomedico, :tipo_mantenimiento, :fecha_mantenimiento, :observaciones_mantenimiento, :usuario_crea, :ruta_archivo)");

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_mantenimiento", $datos["tipo_mantenimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_mantenimiento", $datos["fecha_mantenimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_mantenimiento", $datos["observaciones_mantenimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerDatosActivos($tabla, $item, $valor){

        if($item == null){
            
            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE estado = 1");

            $stmt->execute();

            return $stmt->fetchAll();

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :valor AND estado = 1");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();	

        }

        $stmt = null;


    }

    static public function mdlListaEstadosGarantiaBiomedicos($hoy){

        $stmt = Connection::connectOnly()->prepare("SELECT inv_e.id, inv_e.nombre_equipo, inv_e.sede, inv_e.servicio, inv_h.fecha_fin_garantia, DATEDIFF(inv_h.fecha_fin_garantia, '$hoy'), IF(inv_h.fecha_fin_garantia <= '$hoy', 'VENCIDA', IF(DATEDIFF(inv_h.fecha_fin_garantia, '$hoy') <= 90, 'A VENCER', 'TIEMPO')) AS estado_garantia FROM inventario_equipos_biomedicos_historicos inv_h JOIN inventario_equipos_biomedicos inv_e ON inv_h.id_equipo_biomedico = inv_e.id HAVING estado_garantia IN ('VENCIDA', 'A VENCER')");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


    static public function mdlObtenerDato($tabla, $item, $valor){

        if($item == null){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");

            if($stmt->execute()){

                return $stmt->fetchAll();

            }else{

                return $stmt->errorInfo();

            }

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            if($stmt->execute()){

                return $stmt->fetch();

            }else{

                return $stmt->errorInfo();

            }

        }

        $stmt = null;

    }

    static public function mdlListaEquiposBiomedicos($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE active = 1");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarComponenteAccesorioBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = :fecha_elimina WHERE id_compo_caract = :id_compo_caract");

        $stmt->bindParam(":id_compo_caract", $datos["id_compo_caract"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_elimina", $datos["fecha_elimina"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarRecomendacionBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = :fecha_elimina WHERE id_recomendacion = :id_recomendacion");

        $stmt->bindParam(":id_recomendacion", $datos["id_recomendacion"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_elimina", $datos["fecha_elimina"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarPlanoBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = :fecha_elimina WHERE id_plano = :id_plano");

        $stmt->bindParam(":id_plano", $datos["id_plano"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_elimina", $datos["fecha_elimina"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarManualBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = :fecha_elimina WHERE id_manual = :id_manual");

        $stmt->bindParam(":id_manual", $datos["id_manual"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_elimina", $datos["fecha_elimina"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoDatosEquipoBiomedicoHistorico($tabla, $idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_equipo_biomedico = :id_equipo_biomedico");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearEquipoBiomedicoHistorico($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO inventario_equipos_biomedicos_historicos (id_equipo_biomedico, usuario_crea, fecha_crea) VALUES (:id_equipo_biomedico, :usuario_crea, :fecha_crea)");

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlGuardarHistoricoEquipoBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET numero_factura = :numero_factura, forma_adquisicion = :forma_adquisicion, vida_util = :vida_util, valor_iva = :valor_iva, compra = :compra, instalacion = :instalacion, recibido = :recibido, fecha_inicio_garantia = :fecha_inicio_garantia, fecha_fin_garantia = :fecha_fin_garantia, garantia_anios = :garantia_anios, fabricante = :fabricante, nombre_contacto = :nombre_contacto, representante = :representante, telefono = :telefono, correo_electronico = :correo_electronico, cargo_puesto = :cargo_puesto, proveedor = :proveedor, celular = :celular, valor_depreciacion = :valor_depreciacion WHERE id_equipo_biomedico = :id_equipo_biomedico");

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_factura", $datos["numero_factura"], PDO::PARAM_STR);
        $stmt->bindParam(":forma_adquisicion", $datos["forma_adquisicion"], PDO::PARAM_STR);
        $stmt->bindParam(":vida_util", $datos["vida_util"], PDO::PARAM_STR);
        $stmt->bindParam(":valor_iva", $datos["valor_iva"], PDO::PARAM_STR);
        $stmt->bindParam(":compra", $datos["compra"], PDO::PARAM_STR);
        $stmt->bindParam(":instalacion", $datos["instalacion"], PDO::PARAM_STR);
        $stmt->bindParam(":recibido", $datos["recibido"], $datos["recibido"] !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindParam(":fecha_inicio_garantia", $datos["fecha_inicio_garantia"], $datos["fecha_inicio_garantia"] !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindParam(":fecha_fin_garantia", $datos["fecha_fin_garantia"], $datos["fecha_fin_garantia"] !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindParam(":garantia_anios", $datos["garantia_anios"], PDO::PARAM_STR);
        $stmt->bindParam(":fabricante", $datos["fabricante"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_contacto", $datos["nombre_contacto"], PDO::PARAM_STR);
        $stmt->bindParam(":representante", $datos["representante"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":correo_electronico", $datos["correo_electronico"], PDO::PARAM_STR);
        $stmt->bindParam(":cargo_puesto", $datos["cargo_puesto"], PDO::PARAM_STR);
        $stmt->bindParam(":proveedor", $datos["proveedor"], PDO::PARAM_STR);
        $stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
        $stmt->bindParam(":valor_depreciacion", $datos["valor_depreciacion"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlListaEquipoBiomedicoComponentesCaracteristicas($tabla, $idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_equipo_biomedico = :id_equipo_biomedico AND is_active = 1");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearComponenteCaracteristica($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_equipo_biomedico, componente_caracteristica, cantidad, usuario_crea, fecha_crea) VALUES (:id_equipo_biomedico, :componente_caracteristica, :cantidad, :usuario_crea, :fecha_crea)");

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":componente_caracteristica", $datos["componente_caracteristica"], PDO::PARAM_STR);
        $stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaEquipoBiomedicoRecomendaciones($tabla, $idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_equipo_biomedico = :id_equipo_biomedico AND is_active = 1");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearRecomendacionBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_equipo_biomedico, recomendacion, usuario_crea, fecha_crea) VALUES (:id_equipo_biomedico, :recomendacion, :usuario_crea, :fecha_crea)");

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":recomendacion", $datos["recomendacion"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaEquipoBiomedicoPlanos($tabla, $idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_equipo_biomedico = :id_equipo_biomedico AND is_active = 1");

        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }


    static public function mdlCrearPlanoBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_equipo_biomedico, tipo_plano, nombre_plano, ruta_archivo, usuario_crea, fecha_crea) VALUES (:id_equipo_biomedico, :tipo_plano, :nombre_plano, :ruta_archivo, :usuario_crea, :fecha_crea)");

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_plano", $datos["tipo_plano"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_plano", $datos["nombre_plano"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaEquipoBiomedicoManuales($tabla, $idEquipoBiomedico){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_equipo_biomedico = :id_equipo_biomedico AND is_active = 1");
        
        $stmt->bindParam(":id_equipo_biomedico", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        
    }

    static public function mdlCrearManualBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_equipo_biomedico, tipo_manual, nombre_manual, ruta_archivo, usuario_crea, fecha_crea) VALUES (:id_equipo_biomedico, :tipo_manual, :nombre_manual, :ruta_archivo, :usuario_crea, :fecha_crea)");

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_manual", $datos["tipo_manual"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_manual", $datos["nombre_manual"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        
    }

    static public function mdlRegistrarLog($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_equipo_biomedico, accion, usuario_crea, fecha_crea, data_old, data_new) VALUES (:id_equipo_biomedico, :accion, :usuario_crea, :fecha_crea, :data_old, :data_new)");        

        $stmt->bindParam(":id_equipo_biomedico", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":accion", $datos["accion"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":data_old", $datos["data_old"], PDO::PARAM_STR);
        $stmt->bindParam(":data_new", $datos["data_new"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEditarDatosEquipoBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET tipo_equipo = :tipo_equipo, nombre_equipo = :nombre_equipo, marca = :marca, modelo = :modelo, serie = :serie, activo_fijo = :activo_fijo, registro_sanitario_invima = :registro_sanitario_invima,
            sede = :sede, ubicacion = :ubicacion, servicio = :servicio, clasificacion_biomedica = :clasificacion_biomedica, clasificacion_riesgo = :clasificacion_riesgo, tecnologia_predominante = :tecnologia_predominante, fuente_alimentacion = :fuente_alimentacion,
            caracteristica_instalacion = :caracteristica_instalacion, tension_trabajo = :tension_trabajo, consumo_watt = :consumo_watt, peso = :peso, condiciones_ambientales = :condiciones_ambientales
            WHERE id = :id");

        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_equipo", $datos["tipo_equipo"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_equipo", $datos["nombre_equipo"], PDO::PARAM_STR);
        $stmt->bindParam(":marca", $datos["marca"], PDO::PARAM_STR);
        $stmt->bindParam(":modelo", $datos["modelo"], PDO::PARAM_STR);
        $stmt->bindParam(":serie", $datos["serie"], PDO::PARAM_STR);
        $stmt->bindParam(":activo_fijo", $datos["activo_fijo"], PDO::PARAM_STR);
        $stmt->bindParam(":registro_sanitario_invima", $datos["registro_sanitario_invima"], PDO::PARAM_STR);
        $stmt->bindParam(":sede", $datos["sede"], PDO::PARAM_STR);
        $stmt->bindParam(":ubicacion", $datos["ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":servicio", $datos["servicio"], PDO::PARAM_STR);
        $stmt->bindParam(":clasificacion_biomedica", $datos["clasificacion_biomedica"], PDO::PARAM_STR);
        $stmt->bindParam(":clasificacion_riesgo", $datos["clasificacion_riesgo"], PDO::PARAM_STR);
        $stmt->bindParam(":tecnologia_predominante", $datos["tecnologia_predominante"], PDO::PARAM_STR);
        $stmt->bindParam(":fuente_alimentacion", $datos["fuente_alimentacion"], PDO::PARAM_STR);
        $stmt->bindParam(":caracteristica_instalacion", $datos["caracteristica_instalacion"], PDO::PARAM_STR);
        $stmt->bindParam(":tension_trabajo", $datos["tension_trabajo"], PDO::PARAM_STR);
        $stmt->bindParam(":consumo_watt", $datos["consumo_watt"], PDO::PARAM_STR);
        $stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
        $stmt->bindParam(":condiciones_ambientales", $datos["condiciones_ambientales"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        

    }

    static public function mdlInfoDatosEquipoBiomedico($tabla, $idEquipoBiomedico){

        $hoy = date("Y-m-d");

        $stmt = Connection::connectOnly()->prepare("SELECT inv_e.*, inv_h.fecha_fin_garantia, IF(inv_h.fecha_fin_garantia <= '$hoy', 'VENCIDA', IF(DATEDIFF(inv_h.fecha_fin_garantia, '$hoy') <= 30, 'A VENCER', 'TIEMPO')) AS estado_garantia FROM inventario_equipos_biomedicos inv_e JOIN inventario_equipos_biomedicos_historicos inv_h ON inv_e.id = inv_h.id_equipo_biomedico WHERE id = :id");

        $stmt->bindParam(":id", $idEquipoBiomedico, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlObtenerEquipoBiomedico($marca, $modelo, $activoFijo, $usuarioCrea){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_equipos_biomedicos WHERE marca = :marca AND modelo = :modelo AND activo_fijo = :activo_fijo AND usuario_crea = :usuario_crea ORDER BY fecha_crea DESC LIMIT 1");

        $stmt->bindParam(":marca", $marca, PDO::PARAM_STR);
        $stmt->bindParam(":modelo", $modelo, PDO::PARAM_STR);
        $stmt->bindParam(":activo_fijo", $activoFijo, PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $usuarioCrea, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlGuardarDatosEquipoBiomedico($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (tipo_equipo, nombre_equipo, marca, modelo, serie, activo_fijo, registro_sanitario_invima, sede, ubicacion, servicio, clasificacion_biomedica, clasificacion_riesgo, tecnologia_predominante, fuente_alimentacion, caracteristica_instalacion, tension_trabajo, consumo_watt, peso, condiciones_ambientales, usuario_crea, fecha_crea) VALUES (:tipo_equipo, :nombre_equipo, :marca, :modelo, :serie, :activo_fijo, :registro_sanitario_invima, :sede, :ubicacion, :servicio, :clasificacion_biomedica, :clasificacion_riesgo, :tecnologia_predominante, :fuente_alimentacion, :caracteristica_instalacion, :tension_trabajo, :consumo_watt, :peso, :condiciones_ambientales, :usuario_crea, :fecha_crea)");

        $stmt->bindParam(":tipo_equipo", $datos["tipo_equipo"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_equipo", $datos["nombre_equipo"], PDO::PARAM_STR);
        $stmt->bindParam(":marca", $datos["marca"], PDO::PARAM_STR);
        $stmt->bindParam(":modelo", $datos["modelo"], PDO::PARAM_STR);
        $stmt->bindParam(":serie", $datos["serie"], PDO::PARAM_STR);
        $stmt->bindParam(":activo_fijo", $datos["activo_fijo"], PDO::PARAM_STR);
        $stmt->bindParam(":registro_sanitario_invima", $datos["registro_sanitario_invima"], PDO::PARAM_STR);
        $stmt->bindParam(":sede", $datos["sede"], PDO::PARAM_STR);
        $stmt->bindParam(":ubicacion", $datos["ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":servicio", $datos["servicio"], PDO::PARAM_STR);
        $stmt->bindParam(":clasificacion_biomedica", $datos["clasificacion_biomedica"], PDO::PARAM_STR);
        $stmt->bindParam(":clasificacion_riesgo", $datos["clasificacion_riesgo"], PDO::PARAM_STR);
        $stmt->bindParam(":tecnologia_predominante", $datos["tecnologia_predominante"], PDO::PARAM_STR);
        $stmt->bindParam(":fuente_alimentacion", $datos["fuente_alimentacion"], PDO::PARAM_STR);
        $stmt->bindParam(":caracteristica_instalacion", $datos["caracteristica_instalacion"], PDO::PARAM_STR);
        $stmt->bindParam(":tension_trabajo", $datos["tension_trabajo"], PDO::PARAM_STR);
        $stmt->bindParam(":consumo_watt", $datos["consumo_watt"], PDO::PARAM_STR);
        $stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
        $stmt->bindParam(":condiciones_ambientales", $datos["condiciones_ambientales"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }
    
}
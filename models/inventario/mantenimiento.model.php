<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelInventarioMantenimiento{

    static public function mdlEditarMantenimiento($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE inventario_equipos_mantenimientos SET mantenimientos_preventivos = :mantenimientos_preventivos, mantenimientos_correctivos = :mantenimientos_correctivos, observaciones_mantenimiento = :observaciones_mantenimiento, usuario_edita = :usuario_edita, fecha_edita = :fecha_edita WHERE id_mante_activo_fijo = :id_mante_activo_fijo");

        $stmt->bindParam(":mantenimientos_preventivos", $datos["mantenimientos_preventivos"], PDO::PARAM_STR);
        $stmt->bindParam(":mantenimientos_correctivos", $datos["mantenimientos_correctivos"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_mantenimiento", $datos["observaciones_mantenimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_edita", $datos["usuario_edita"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_edita", $datos["fecha_edita"], PDO::PARAM_STR);
        $stmt->bindParam(":id_mante_activo_fijo", $datos["id_mante_activo_fijo"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';
    
        }else{

            return $stmt->errorInfo();

        }
    
        $stmt = null;

    }

    static public function mdlInfoMantenimientoId($idManteActivoFijo){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_equipos_mantenimientos WHERE id_mante_activo_fijo = :id_mante_activo_fijo");

        $stmt->bindParam(":id_mante_activo_fijo", $idManteActivoFijo, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();
    
        }else{

            return $stmt->errorInfo();

        }
    
        $stmt = null;

    }

    static public function mdlListaMantenimientosRealizadosActivosFijos(){

        $stmt = Connection::connectOnly()->prepare("SELECT inv_e.*, inv_m.id_mante_activo_fijo, inv_m.mantenimientos_preventivos, inv_m.mantenimientos_preventivos, inv_m.fecha_crea AS fecha_mantenimiento, inv_m.categoria_activo FROM inventario_equipos_mantenimientos inv_m JOIN inventario_equipos_biomedicos inv_e ON inv_m.id_equipo = inv_e.id  ORDER BY inv_m.fecha_crea DESC");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoMantenimiento($datos){

        $campo  = $datos["campo"];

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_equipos_mantenimientos WHERE $campo = :id_solicitud_mante");

        $stmt->bindParam(":id_solicitud_mante", $datos["id_solicitud_mante"], PDO::PARAM_STR);

        if($stmt->execute()){

                return $stmt->fetch();
    
        }else{

            return $stmt->errorInfo();

        }
    
        $stmt = null;

    }

    static public function mdlActualizarSolicitudMantenimiento($datos){

        if($datos["categoria_activo"] == 'EQUIPOBIOMEDICO'){

            $stmt = Connection::connectOnly()->prepare("UPDATE inventario_equipos_biomedicos_solicitudes_mantenimientos SET estado = 'REALIZADO' WHERE id_soli_mante_bio = :id_soli_mante_bio");

            $stmt->bindParam(":id_soli_mante_bio", $datos["id_soli_mante"], PDO::PARAM_STR);

            if($stmt->execute()){

                return 'ok';
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }

    }

    static public function mdlGuardarMantenimiento($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO inventario_equipos_mantenimientos (id_equipo, id_solicitud_mante, mantenimientos_preventivos, mantenimientos_correctivos, observaciones_mantenimiento, usuario_crea, categoria_activo) VALUES (:id_equipo, :id_solicitud_mante, :mantenimientos_preventivos, :mantenimientos_correctivos, :observaciones_mantenimiento, :usuario_crea, :categoria_activo)");

        $stmt->bindParam(":id_equipo", $datos["id_equipo_biomedico"], PDO::PARAM_STR);
        $stmt->bindParam(":id_solicitud_mante", $datos["id_soli_mante"], PDO::PARAM_STR);
        $stmt->bindParam(":mantenimientos_preventivos", $datos["mantenimientos_preventivos"], PDO::PARAM_STR);
        $stmt->bindParam(":mantenimientos_correctivos", $datos["mantenimientos_correctivos"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_mantenimiento", $datos["observaciones_mantenimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":categoria_activo", $datos["categoria_activo"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoSolicitudMantenimiento($idSoliMantenimiento, $categoriaActivo){

        if($categoriaActivo == 'EQUIPOBIOMEDICO'){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_equipos_biomedicos_solicitudes_mantenimientos WHERE  id_soli_mante_bio = :id_soli_mante_bio");

            $stmt->bindParam(":id_soli_mante_bio", $idSoliMantenimiento, PDO::PARAM_STR);

            if($stmt->execute()){

                return $stmt->fetch();
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }

    }

    static public function mdlListaTiposMantenimientosEquipo($tipoEquipo, $categoriaActivo){

        if($categoriaActivo == 'EQUIPOBIOMEDICO'){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_par_tipos_mantenimientos WHERE categoria = 'EQUIPO BIOMEDICO' AND tipo_activo = :tipo_activo AND is_active = 1");

            $stmt->bindParam(":tipo_activo", $tipoEquipo, PDO::PARAM_STR);

            if($stmt->execute()){

                return $stmt->fetchAll();
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;


        }


    }

    static public function mdlInformacionEquipo($idEquipo, $categoriaActivo){

        if($categoriaActivo == 'EQUIPOBIOMEDICO'){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_equipos_biomedicos WHERE id = :id");

            $stmt->bindParam(":id", $idEquipo, PDO::PARAM_STR);

            if($stmt->execute()){

                return $stmt->fetch();
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }

    }

    static public function mdlEliminarMantenimientoActivoFijo($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET usuario_elimina = :usuario_elimina, fecha_elimina = :fecha_elimina, is_active = 0 WHERE id_tipo_mante = :id_tipo_mante");

        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_elimina", $datos["fecha_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":id_tipo_mante", $datos["id_tipo_mante"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaMantenimientosActivosFijos($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE is_active = 1");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlCrearMantenimientoActivoFijo($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (categoria, tipo_activo, mantenimiento, tipo_mantenimiento, usuario_crea) VALUES (:categoria, :tipo_activo, :mantenimiento, :tipo_mantenimiento, :usuario_crea)");

        $stmt->bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR );
        $stmt->bindParam(":tipo_activo", $datos["tipo_activo"], PDO::PARAM_STR );
        $stmt->bindParam(":mantenimiento", $datos["mantenimiento"], PDO::PARAM_STR );
        $stmt->bindParam(":tipo_mantenimiento", $datos["tipo_mantenimiento"], PDO::PARAM_STR );
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR );

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


}
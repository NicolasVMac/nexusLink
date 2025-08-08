<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";

require_once $rutaConnection;

date_default_timezone_set('America/Bogota');

class ModelTickets{

    static public function mdlTerminarTicket($idTicket, $tipoSolucion, $fechaHora){

        $stmt = Connection::connectOnly()->prepare("UPDATE mesaayuda_tickets SET tipo_solucion = '$tipoSolucion', fecha_fin_ticket = '$fechaHora', estado = 'PRE_REALIZADO' WHERE id_ticket = $idTicket");

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarEstadoTicket($idTicket){

        $stmt = Connection::connectOnly()->prepare("UPDATE mesaayuda_tickets SET estado = 'PENDIENTE', fecha_fin_ticket = NULL WHERE id_ticket = $idTicket");

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaMisTicketsPendienteGestion($idUser){

        $stmt = Connection::connectOnly()->prepare("SELECT mesaayuda_tickets.*, proyectos.proyecto, usuarios.nombre AS nombre_usuario, usuarios.usuario, usuarios.telefono, usuarios.mail FROM proyectos JOIN mesaayuda_tickets ON proyectos.id_proyecto = mesaayuda_tickets.id_proyecto JOIN usuarios ON mesaayuda_tickets.id_usuario_ticket = usuarios.id WHERE mesaayuda_tickets.estado IN ('PENDIENTE','PRE_REALIZADO')  AND mesaayuda_tickets.id_usuario_soporte = $idUser");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt = null;

        }

        $stmt = null;

    }

    static public function mdlAgregarSeguimiento($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_ticket, id_usuario, descripcion, ruta_archivos, usuario_crea) VALUES (:id_ticket, :id_usuario, :descripcion, :ruta_archivos, :usuario_crea)");

        $stmt->bindParam(":id_ticket", $datos["id_ticket"], PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivos", $datos["ruta_archivos"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAsignarTicket($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET id_usuario_soporte = :id_usuario_soporte, fecha_ini_ticket = :fecha_ini_ticket, estado = :estado WHERE id_ticket = :id_ticket");

        $stmt->bindParam(":id_usuario_soporte", $datos["id_usuario_soporte"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_ini_ticket", $datos["fecha_ini_ticket"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":id_ticket", $datos["id_ticket"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerDato($tabla, $item, $valor){

        if($item != null){

			$stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();

		}else{

			$stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt = null;

    }

    static public function mdlListaTicketsBolsa(){

        $stmt = Connection::connectOnly()->prepare("SELECT mesaayuda_tickets.*, proyectos.proyecto, usuarios.nombre AS nombre_usuario, usuarios.usuario, usuarios.telefono, usuarios.mail FROM proyectos JOIN mesaayuda_tickets ON proyectos.id_proyecto = mesaayuda_tickets.id_proyecto JOIN usuarios ON mesaayuda_tickets.id_usuario_ticket = usuarios.id WHERE mesaayuda_tickets.estado = 'CREADO' AND mesaayuda_tickets.id_usuario_soporte IS NULL");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt = null;

        }

        $stmt = null;

    }

    static public function mdlVerSeguimientosTicket($idTicket){

        $stmt = Connection::connectOnly()->prepare("SELECT mts.*, u.nombre AS nombre_usuario, DATE_FORMAT(mts.fecha_crea, '%W %e %M de %Y') AS fecha, DATE_FORMAT(mts.fecha_crea, '%W') AS dia_txt, DATE_FORMAT(mts.fecha_crea, '%e') AS dia_num, MONTH(mts.fecha_crea) AS mes_num, DATE_FORMAT(mts.fecha_crea, '%M') AS mes_txt, DATE_FORMAT(mts.fecha_crea, '%Y') AS anio, DATE_FORMAT(mts.fecha_crea, '%r') AS hora FROM mesaayuda_tickets_seguimientos AS mts
            JOIN usuarios AS u ON mts.id_usuario = u.id WHERE mts.id_ticket = $idTicket ORDER BY fecha_crea DESC");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlVerInfoTicket($idTicket){

        $stmt = Connection::connectOnly()->prepare("SELECT mesaayuda_tickets.*, proyectos.proyecto, usuarios.nombre AS nombre_usuario, usuarios.usuario, usuarios.telefono, usuarios.mail 
            FROM proyectos JOIN mesaayuda_tickets ON proyectos.id_proyecto = mesaayuda_tickets.id_proyecto JOIN usuarios ON mesaayuda_tickets.id_usuario_ticket = usuarios.id WHERE mesaayuda_tickets.id_ticket = '$idTicket'");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlMostrarMisTickets($usuario){

        $stmt = Connection::connectOnly()->prepare("SELECT mesaayuda_tickets.*, proyectos.proyecto, usuarios.nombre AS nombre_usuario, usuarios.usuario, usuarios.telefono, usuarios.mail 
            FROM proyectos JOIN mesaayuda_tickets ON proyectos.id_proyecto = mesaayuda_tickets.id_proyecto JOIN usuarios ON mesaayuda_tickets.id_usuario_ticket = usuarios.id WHERE mesaayuda_tickets.usuario_crea = '$usuario'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearTicket($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_proyecto, id_usuario_ticket, asunto, descripcion, prioridad, ruta_archivos, usuario_crea) VALUES (:id_proyecto, :id_usuario_ticket, :asunto, :descripcion, :prioridad, :ruta_archivos, :usuario_crea)");

        $stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario_ticket", $datos["id_usuario_ticket"], PDO::PARAM_STR);
        $stmt->bindParam(":asunto", $datos["asunto"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
        $stmt->bindParam(":prioridad", $datos["prioridad"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivos", $datos["ruta_archivos"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


}
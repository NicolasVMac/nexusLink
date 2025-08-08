<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";

require_once $rutaConnection;

date_default_timezone_set('America/Bogota');

class ModelCallCenter{

    static public function mdlMostrarHorasAgendaProfesional($tabla, $idProfesional, $fechaCita){

        $stmt = Connection::connectOnly()->prepare("SELECT *, DATE_FORMAT(hora_cita, '%r') AS hora_cita_txt FROM $tabla WHERE id_profesional = $idProfesional AND fecha_cita = '$fechaCita' ORDER BY fecha_cita, hora_cita_txt DESC;");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlMostrarDiasAgendaProfesional($tabla, $idProfesional){
        
        $stmt = Connection::connectOnly()->prepare("SELECT fecha_cita, DATE_FORMAT(fecha_cita, '%W %e %M de %Y') AS fecha, DATE_FORMAT(fecha_cita, '%W') AS dia_txt, DATE_FORMAT(fecha_cita, '%e') AS dia_num, MONTH(fecha_cita) AS mes, DATE_FORMAT(fecha_cita, '%Y') AS anio FROM $tabla WHERE id_profesional = $idProfesional GROUP BY fecha_cita ORDER BY fecha_cita, hora_cita DESC");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlCrearCitaAgenda($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (motivo_cita, id_profesional, id_paciente, fecha_cita, hora_cita, usuario_crea) VALUES (:motivo_cita, :id_profesional, :id_paciente, :fecha_cita, :hora_cita, :usuario_crea)");

        $stmt->bindParam(":motivo_cita", $datos["motivo_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":id_profesional", $datos["id_profesional"], PDO::PARAM_STR);
        $stmt->bindParam(":id_paciente", $datos["id_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cita", $datos["fecha_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":hora_cita", $datos["hora_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;
    
    }

    static public function mdlMostrarEspaciosAgendaProfesional($idProfesional, $fechaCita){

        $stmt = Connection::connectOnly()->prepare("SELECT hora FROM (SELECT DATE_FORMAT(DATE_ADD('$fechaCita 00:00:00', INTERVAL hour HOUR), '%H:%i:%s') AS hora
            FROM (SELECT 6 hour UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15 UNION ALL SELECT 16 		UNION ALL SELECT 17 UNION ALL SELECT 18) horas ) h
            WHERE NOT EXISTS (
            SELECT * FROM agenda_citas WHERE id_profesional = $idProfesional AND fecha_cita = '$fechaCita' AND hora_cita = h.hora) ORDER BY hora");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPendientesCall($usuario){

        $stmt = Connection::connectOnly()->prepare("SELECT call_center_bolsa.*, CONCAT(primer_apellido,' ',segundo_apellido, ' ', primer_nombre, ' ', segundo_nombre) AS nombre_paciente_completo FROM call_center_bolsa JOIN pacientes ON call_center_bolsa.id_paciente = pacientes.id_paciente WHERE call_center_bolsa.estado = 'PROCESO' AND asesor = '$usuario'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }

    static public function mdlGuardarRespuestaPreguntaCall($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_call, id_pregunta, respuesta, origen_encuesta, usuario_crea) VALUES (:id_call, :id_pregunta, :respuesta, :origen_encuesta, :usuario_crea)");

        $stmt->bindParam(":id_call", $datos["id_call"], PDO::PARAM_STR);
        $stmt->bindParam(":id_pregunta", $datos["id_pregunta"], PDO::PARAM_STR);
        $stmt->bindParam(":respuesta", $datos["respuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":origen_encuesta", $datos["origen_encuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }


    static public function mdlTerminarGestionCall($tabla, $idCall, $estado, $fechaFin){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = '$estado', fecha_fin = '$fechaFin' WHERE id_call = $idCall");

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }

    static public function mdlActualizarEstadoFallidaCall($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = :estado, fecha_fin = :fecha_fin WHERE id_call = :id_call");

        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":id_call", $datos["id_call"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }

    static public function mdlActualizarContadorGestiones($idCall, $nuevoContadorGestiones){

        $stmt = Connection::connectOnly()->prepare("UPDATE call_center_bolsa SET contador_gestiones = $nuevoContadorGestiones WHERE id_call = $idCall");

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


    static public function mdlCrearComunicacionFallida($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_call, causal_fallida, observaciones, usuario_crea) VALUES (:id_call, :causal_fallida, :observaciones, :usuario_crea)");

        $stmt->bindParam(":id_call", $datos["id_call"], PDO::PARAM_STR);
        $stmt->bindParam(":causal_fallida", $datos["causal_fallida"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


    static public function mdlMostrarPreguntasProcesoCall($tabla, $procesoCall){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE origen_encuesta = '$procesoCall' AND estado = 1");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoCall($tabla, $idCall, $procesoCall){

        switch ($procesoCall) {

            case 'BUSQUEDA':
                $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_call = $idCall AND proceso_origen = '$procesoCall'");
                $stmt->execute();
                return $stmt->fetch();
                break;
            
        }


    }

    static public function mdlCrearGestionCall($tabla, $procesoCall, $idPaciente, $asesor, $fechaIni){

        switch ($procesoCall) {

            case 'BUSQUEDA':

                $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_paciente, proceso_origen, columna_origen, asesor, fecha_ini) VALUES (:id_paciente, :proceso_origen, 'NINGUNA', :asesor, :fecha_ini)");

                $stmt->bindParam(":id_paciente", $idPaciente, PDO::PARAM_STR);
                $stmt->bindParam(":proceso_origen", $procesoCall, PDO::PARAM_STR);
                $stmt->bindParam(":asesor", $asesor, PDO::PARAM_STR);
                $stmt->bindParam(":fecha_ini", $fechaIni, PDO::PARAM_STR);

                if($stmt->execute()){

                    $stmtCall = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_paciente = $idPaciente AND estado = 'CREADA' AND asesor = '$asesor' ORDER BY fecha_crea DESC LIMIT 1");

                    if($stmtCall->execute()){
                    
                        $registroCall = $stmtCall->fetch();

                        $idCall = $registroCall["id_call"];

                        $data = array(

                            "resultado" => "ok",
                            "id_call" => $idCall

                        );

                        //UNA VEZ QUE SE TIENEN LOS DATOS DEL REGISTRO CALL ACTUALIZAMOS EL ESTADO A PROCESO YA QUE SE REDIRECCIONA A REALIZAR LA ENCUESTA
                        $stmtUpdate = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = 'PROCESO' WHERE id_call = $idCall");

                        if($stmtUpdate->execute()){

                            return $data;

                        }else{

                            $data = array(

                                "resultado" => $stmtUpdate->errorInfo(),
                                "id_call" => "ERROR"
        
                            );
        
                            return $data; 

                        }

                    }else{

                        $data = array(

                            "resultado" => $stmtCall->errorInfo(),
                            "id_call" => "ERROR"
    
                        );
    
                        return $data;                        

                    }

                }else{

                    $data = array(

                        "resultado" => $stmt->errorInfo(),
                        "id_call" => "ERROR"

                    );

                    return $data;

                }

                break;
            
        }

        $stmt = null;

    }


    static public function mdlBuscarPaciente($tabla, $filtro, $valor){

		switch($filtro){

            case 'Numero Documento':

                $stmt = Connection::connectOnly()->prepare("SELECT *, CONCAT(primer_apellido,' ',segundo_apellido, ' ', primer_nombre, ' ', segundo_nombre) AS nombre_paciente_completo FROM $tabla WHERE numero_documento = '$valor' AND estado = 1");

                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

                break;

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

    static public function mdlListaDato($tabla, $item, $valor){

        if($item != null){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);


        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        $stmt = null;

    }


}
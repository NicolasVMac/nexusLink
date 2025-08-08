<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";

require_once $rutaConnection;

date_default_timezone_set('America/Bogota');

class ModelPacientes{

    static public function mdlMostrarInfoPacienteId($tabla, $idPaciente){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_paciente = $idPaciente");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        
    }

    static public function mdlValidarExisteDocumento($tabla, $tipoDocumento, $numDocumento){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE tipo_documento = '$tipoDocumento' AND numero_documento = '$numDocumento'");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEditarPaciente($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET tipo_documento = :tipo_documento, primer_apellido = :primer_apellido, segundo_apellido = :segundo_apellido, primer_nombre = :primer_nombre,
            segundo_nombre = :segundo_nombre, seudonimo_paciente = :seudonimo_paciente, expedido_en = :expedido_en, no_carnet = :no_carnet, fecha_nacimiento = :fecha_nacimiento, edad_n = :edad_n, edad_t = :edad_t,
            genero_paciente = :genero_paciente, estado_civil = :estado_civil, escolaridad = :escolaridad, vinculacion = :vinculacion, ocupacion = :ocupacion, grupo_poblacional = :grupo_poblacional,
            pertenencia_etnica = :pertenencia_etnica, regimen = :regimen, tipo_usuario_rips = :tipo_usuario_rips, tipo_afiliacion = :tipo_afiliacion, entidad_af_actual = :entidad_af_actual, mod_copago = :mod_copago,
            copago_fe = :copago_fe, nivel_sisben = :nivel_sisben, departamento_sisben = :departamento_sisben, municipio_sisben = :municipio_sisben, sede_reclama_med = :sede_reclama_med, paquete_atencion = :paquete_atencion,
            notifica_sivigila = :notifica_sivigila, fecha_notificacion_sivigila = :fecha_notificacion_sivigila, ips_notifica = :ips_notifica, direccion_ubicacion = :direccion_ubicacion, latitud_ubicacion = :latitud_ubicacion,
            longitud_ubicacion = :longitud_ubicacion, telefono_uno_ubicacion = :telefono_uno_ubicacion, telefono_dos_ubicacion = :telefono_dos_ubicacion, zona_ubicacion = :zona_ubicacion, departamento_ubicacion = :departamento_ubicacion,
            municipio_ubicacion = :municipio_ubicacion, pais_origen = :pais_origen, correo = :correo, nombre_madre = :nombre_madre, nombre_padre = :nombre_padre, responsable = :responsable, parentesco = :parentesco,
            direccion_contacto = :direccion_contacto, telefono_contacto = :telefono_contacto, psudonimo = :psudonimo, observacion_contacto = :observacion_contacto WHERE id_paciente = :id_paciente");

        $stmt->bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
        $stmt->bindParam(":primer_apellido", $datos["primer_apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":segundo_apellido", $datos["segundo_apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":primer_nombre", $datos["primer_nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":segundo_nombre", $datos["segundo_nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":seudonimo_paciente", $datos["seudonimo_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":expedido_en", $datos["expedido_en"], PDO::PARAM_STR);
        $stmt->bindParam(":no_carnet", $datos["no_carnet"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":edad_n", $datos["edad_n"], PDO::PARAM_STR);
        $stmt->bindParam(":edad_t", $datos["edad_t"], PDO::PARAM_STR);
        $stmt->bindParam(":genero_paciente", $datos["genero_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":estado_civil", $datos["estado_civil"], PDO::PARAM_STR);
        $stmt->bindParam(":escolaridad", $datos["escolaridad"], PDO::PARAM_STR);
        $stmt->bindParam(":vinculacion", $datos["vinculacion"], PDO::PARAM_STR);
        $stmt->bindParam(":ocupacion", $datos["ocupacion"], PDO::PARAM_STR);
        $stmt->bindParam(":grupo_poblacional", $datos["grupo_poblacional"], PDO::PARAM_STR);
        $stmt->bindParam(":pertenencia_etnica", $datos["pertenencia_etnica"], PDO::PARAM_STR);
        $stmt->bindParam(":regimen", $datos["regimen"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_usuario_rips", $datos["tipo_usuario_rips"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_afiliacion", $datos["tipo_afiliacion"], PDO::PARAM_STR);
        $stmt->bindParam(":entidad_af_actual", $datos["entidad_af_actual"], PDO::PARAM_STR);
        $stmt->bindParam(":mod_copago", $datos["mod_copago"], PDO::PARAM_STR);
        $stmt->bindParam(":copago_fe", $datos["copago_fe"], PDO::PARAM_STR);
        $stmt->bindParam(":nivel_sisben", $datos["nivel_sisben"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento_sisben", $datos["departamento_sisben"], PDO::PARAM_STR);
        $stmt->bindParam(":municipio_sisben", $datos["municipio_sisben"], PDO::PARAM_STR);
        $stmt->bindParam(":sede_reclama_med", $datos["sede_reclama_med"], PDO::PARAM_STR);
        $stmt->bindParam(":paquete_atencion", $datos["paquete_atencion"], PDO::PARAM_STR);
        $stmt->bindParam(":notifica_sivigila", $datos["notifica_sivigila"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_notificacion_sivigila", $datos["fecha_notificacion_sivigila"], PDO::PARAM_STR);
        $stmt->bindParam(":ips_notifica", $datos["ips_notifica"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_ubicacion", $datos["direccion_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":latitud_ubicacion", $datos["latitud_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":longitud_ubicacion", $datos["longitud_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono_uno_ubicacion", $datos["telefono_uno_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono_dos_ubicacion", $datos["telefono_dos_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":zona_ubicacion", $datos["zona_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento_ubicacion", $datos["departamento_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":municipio_ubicacion", $datos["municipio_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":pais_origen", $datos["pais_origen"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_madre", $datos["nombre_madre"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_padre", $datos["nombre_padre"], PDO::PARAM_STR);
        $stmt->bindParam(":responsable", $datos["responsable"], PDO::PARAM_STR);
        $stmt->bindParam(":parentesco", $datos["parentesco"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_contacto", $datos["direccion_contacto"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono_contacto", $datos["telefono_contacto"], PDO::PARAM_STR);
        $stmt->bindParam(":psudonimo", $datos["psudonimo"], PDO::PARAM_STR);
        $stmt->bindParam(":observacion_contacto", $datos["observacion_contacto"], PDO::PARAM_STR);
        $stmt->bindParam(":id_paciente", $datos["id_paciente"], PDO::PARAM_STR);

        if($stmt->execute()){

            if($datos["cambios_campos"][0] == "Ningun cambio"){

                return "ok";

            }else{

                $cadenaLog = '';

                foreach ($datos["cambios_campos"] as $key => $value) {

                    $cadenaLog .= $value.",";

                }

                $cadenaLog = substr($cadenaLog, 0, -1);

                $stmtLog = Connection::connectOnly()->prepare("INSERT INTO pacientes_log_cambios (id_paciente, campos_cambio, usuario_edita) VALUES (:id_paciente, '$cadenaLog', :usuario_edita)");

                $stmtLog->bindParam(":id_paciente", $datos["id_paciente"], PDO::PARAM_STR);
                $stmtLog->bindParam(":usuario_edita", $datos["usuario_edita"], PDO::PARAM_STR);

                if($stmtLog->execute()){

                    return "ok";

                }else{

                    return $stmt->errorInfo();

                }

            }

        }

    }

    static public function mdlMostrarPacientes($tabla, $item, $valor){

		if ($item != null) {

			$stmt = Connection::connectOnly()->prepare("SELECT *, CONCAT(primer_apellido,' ',segundo_apellido, ' ', primer_nombre, ' ', segundo_nombre) AS nombre_paciente_completo FROM $tabla WHERE $item = :$item AND estado = 1");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);

		} else {

			$stmt = Connection::connectOnly()->prepare("SELECT *, CONCAT(primer_apellido,' ',segundo_apellido, ' ', primer_nombre, ' ', segundo_nombre) AS nombre_paciente_completo FROM $tabla WHERE estado = 1;");

			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}

		$stmt = null;
	}


    static public function mdlCrearPaciente($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (tipo_documento,numero_documento,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,seudonimo_paciente,expedido_en,no_carnet,fecha_nacimiento,edad_n,edad_t,genero_paciente,estado_civil,escolaridad,vinculacion,ocupacion,grupo_poblacional,pertenencia_etnica,regimen,tipo_usuario_rips,tipo_afiliacion,entidad_af_actual,mod_copago,copago_fe,nivel_sisben,departamento_sisben,municipio_sisben,sede_reclama_med,paquete_atencion,notifica_sivigila,fecha_notificacion_sivigila,ips_notifica,direccion_ubicacion,latitud_ubicacion,longitud_ubicacion,telefono_uno_ubicacion,telefono_dos_ubicacion,zona_ubicacion,departamento_ubicacion,municipio_ubicacion,pais_origen,correo,nombre_madre,nombre_padre,responsable,parentesco,direccion_contacto,telefono_contacto,psudonimo,observacion_contacto,usuario_crea) VALUES (:tipo_documento,:numero_documento,:primer_apellido,:segundo_apellido,:primer_nombre,:segundo_nombre,:seudonimo_paciente,:expedido_en,:no_carnet,:fecha_nacimiento,:edad_n,:edad_t,:genero_paciente,:estado_civil,:escolaridad,:vinculacion,:ocupacion,:grupo_poblacional,:pertenencia_etnica,:regimen,:tipo_usuario_rips,:tipo_afiliacion,:entidad_af_actual,:mod_copago,:copago_fe,:nivel_sisben,:departamento_sisben,:municipio_sisben,:sede_reclama_med,:paquete_atencion,:notifica_sivigila,:fecha_notificacion_sivigila,:ips_notifica,:direccion_ubicacion,:latitud_ubicacion,:longitud_ubicacion,:telefono_uno_ubicacion,:telefono_dos_ubicacion,:zona_ubicacion,:departamento_ubicacion,:municipio_ubicacion,:pais_origen,:correo,:nombre_madre,:nombre_padre,:responsable,:parentesco,:direccion_contacto,:telefono_contacto,:psudonimo,:observacion_contacto,:usuario_crea)");

        $stmt->bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_documento", $datos["numero_documento"], PDO::PARAM_STR);
        $stmt->bindParam(":primer_apellido", $datos["primer_apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":segundo_apellido", $datos["segundo_apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":primer_nombre", $datos["primer_nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":segundo_nombre", $datos["segundo_nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":seudonimo_paciente", $datos["seudonimo_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":expedido_en", $datos["expedido_en"], PDO::PARAM_STR);
        $stmt->bindParam(":no_carnet", $datos["no_carnet"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":edad_n", $datos["edad_n"], PDO::PARAM_STR);
        $stmt->bindParam(":edad_t", $datos["edad_t"], PDO::PARAM_STR);
        $stmt->bindParam(":genero_paciente", $datos["genero_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":estado_civil", $datos["estado_civil"], PDO::PARAM_STR);
        $stmt->bindParam(":escolaridad", $datos["escolaridad"], PDO::PARAM_STR);
        $stmt->bindParam(":vinculacion", $datos["vinculacion"], PDO::PARAM_STR);
        $stmt->bindParam(":ocupacion", $datos["ocupacion"], PDO::PARAM_STR);
        $stmt->bindParam(":grupo_poblacional", $datos["grupo_poblacional"], PDO::PARAM_STR);
        $stmt->bindParam(":pertenencia_etnica", $datos["pertenencia_etnica"], PDO::PARAM_STR);
        $stmt->bindParam(":regimen", $datos["regimen"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_usuario_rips", $datos["tipo_usuario_rips"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_afiliacion", $datos["tipo_afiliacion"], PDO::PARAM_STR);
        $stmt->bindParam(":entidad_af_actual", $datos["entidad_af_actual"], PDO::PARAM_STR);
        $stmt->bindParam(":mod_copago", $datos["mod_copago"], PDO::PARAM_STR);
        $stmt->bindParam(":copago_fe", $datos["copago_fe"], PDO::PARAM_STR);
        $stmt->bindParam(":nivel_sisben", $datos["nivel_sisben"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento_sisben", $datos["departamento_sisben"], PDO::PARAM_STR);
        $stmt->bindParam(":municipio_sisben", $datos["municipio_sisben"], PDO::PARAM_STR);
        $stmt->bindParam(":sede_reclama_med", $datos["sede_reclama_med"], PDO::PARAM_STR);
        $stmt->bindParam(":paquete_atencion", $datos["paquete_atencion"], PDO::PARAM_STR);
        $stmt->bindParam(":notifica_sivigila", $datos["notifica_sivigila"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_notificacion_sivigila", $datos["fecha_notificacion_sivigila"], PDO::PARAM_STR);
        $stmt->bindParam(":ips_notifica", $datos["ips_notifica"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_ubicacion", $datos["direccion_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":latitud_ubicacion", $datos["latitud_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":longitud_ubicacion", $datos["longitud_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono_uno_ubicacion", $datos["telefono_uno_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono_dos_ubicacion", $datos["telefono_dos_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":zona_ubicacion", $datos["zona_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento_ubicacion", $datos["departamento_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":municipio_ubicacion", $datos["municipio_ubicacion"], PDO::PARAM_STR);
        $stmt->bindParam(":pais_origen", $datos["pais_origen"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_madre", $datos["nombre_madre"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_padre", $datos["nombre_padre"], PDO::PARAM_STR);
        $stmt->bindParam(":responsable", $datos["responsable"], PDO::PARAM_STR);
        $stmt->bindParam(":parentesco", $datos["parentesco"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_contacto", $datos["direccion_contacto"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono_contacto", $datos["telefono_contacto"], PDO::PARAM_STR);
        $stmt->bindParam(":psudonimo", $datos["psudonimo"], PDO::PARAM_STR);
        $stmt->bindParam(":observacion_contacto", $datos["observacion_contacto"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

}
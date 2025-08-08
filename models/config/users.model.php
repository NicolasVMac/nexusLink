<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelUsers{

	static public function mdlCrearUsuarioPQRS($datos){

		$stmt = Connection::connectOnly()->prepare("INSERT INTO pqr_usuarios (tipo, nombre, numero_documento, usuario, usuario_crea, programas) VALUES (:tipo, :nombre, :numero_documento, :usuario, :usuario_crea, :programas)");

		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":numero_documento", $datos["numero_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
		$stmt->bindParam(":programas", $datos["programas"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 'ok';

		}else{

			return $stmt->errorInfo();

		}

		$stmt = null;


	}

	static public function mdlCrearProfesional($datos){

		$stmt = Connection::connectOnly()->prepare("INSERT INTO par_profesionales (id_profesional, usuario, nombre_profesional, doc_profesional) VALUES (:id_profesional, :usuario, :nombre_profesional, :doc_profesional)");

		$stmt->bindParam(":id_profesional", $datos["id_profesional"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_profesional", $datos["nombre_profesional"], PDO::PARAM_STR);
		$stmt->bindParam(":doc_profesional", $datos["doc_profesional"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 'ok';

		}else{

			return $stmt->errorInfo();

		}

		$stmt = null;

	}


	static public function mdlCrearCargoUsuario($datos){

		$stmt = Connection::connectOnly()->prepare("INSERT INTO usuarios_cargos (id_usuario, cargo) VALUES (:id_usuario, :cargo)");

		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 'ok';

		}else{

			return $stmt->errorInfo();

		}

		$stmt = null;	

	}

	static public function mdlExisteUsuario($usuario){

		$stmt = Connection::connectOnly()->prepare("SELECT * FROM usuarios WHERE usuario = '$usuario'");

		if($stmt->execute()){

			return $stmt->fetchAll();

		}else{

			return $stmt->errorInfo();

		}

		$stmt = null;


	}

	static public function mdlEliminarMenusUsuario($usuario){

		$stmt = Connection::connectOnly()->prepare("DELETE FROM usuarios_permisos WHERE usuario = '$usuario'");

		if($stmt->execute()){

			return 'ok';

		}else{

			return $stmt->errorInfo();

		}

		$stmt = null;		

	}

	static public function mdlEditarUsuario($tabla, $datos){

		if(!empty($datos["nuevoPassowrd"])){

			$password = crypt($datos["nuevoPassowrd"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
	
		}else{
	
			$password = $datos["antiguoPassword"];
			
		}

		$stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET nombre = :nombre, password = :password, telefono = :telefono, mail = :mail WHERE id = :id");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $password, PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":mail", $datos["mail"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id_usuario"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 'ok';

		}else{

			return $stmt->errorInfo();

		}

		$stmt = null;

	}

	static public function mdlObtenerMenusUsuario($usuario){

		$stmt = Connection::connectOnly()->prepare("SELECT * FROM usuarios_permisos WHERE usuario = '$usuario'");

		if($stmt->execute()){

			return $stmt->fetchAll();

		}else{

			return $stmt->errorInfo();

		}

		$stmt = null;

	}

	static public function mdlCrearUsuarioPermiso($tabla, $datos){

		$stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (usuario, id_proyecto, id_menu) VALUES (:usuario, :id_proyecto, :id_menu)");

		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":id_proyecto", $datos["id_proyecto"], PDO::PARAM_STR);
		$stmt->bindParam(":id_menu", $datos["id_menu"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 'ok';

		}else{

			return $stmt->errorInfo();

		}

		$stmt = null;

	}

	static public function mdlCrearUsuario($tabla, $datos){

		$paswordEncrypt = crypt($datos["password"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		$stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (nombre, documento, telefono, usuario, password, mail) VALUES (:nombre, :documento, :telefono, :usuario, :password, :mail)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $paswordEncrypt, PDO::PARAM_STR);
		$stmt->bindParam(":mail", $datos["mail"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 'ok';

		}else{

			return $stmt->errorInfo();

		}

		$stmt = null;
		
	}

	static public function mdlListaProyectos(){

		$stmt = Connection::connectOnly()->prepare("SELECT * FROM proyectos WHERE estado = 1");

		if($stmt->execute()){

			return $stmt->fetchAll();

		}else{

			return $stmt->errorInfo();

		}

		$stmt = null;


	}

	static public function mdlMenusProyecto($idProyecto){

		$stmt = Connection::connectOnly()->prepare("SELECT proyectos_menu.*, proyectos.proyecto FROM proyectos_menu JOIN proyectos ON proyectos_menu.id_proyecto = proyectos.id_proyecto WHERE proyectos.id_proyecto = $idProyecto AND proyectos_menu.estado = 1");

		if($stmt->execute()){

			return $stmt->fetchAll();

		}else{

			return $stmt->errorInfo();

		}

		$stmt = null;

	}

	static public function mdlListaUsuarios($user){

		// $stmt = Connection::connectOnly()->prepare("SELECT id, nombre, documento, telefono, usuario, mail FROM usuarios WHERE usuario != '$user'");
		$stmt = Connection::connectOnly()->prepare("SELECT id, nombre, documento, telefono, usuario, mail FROM usuarios");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

	}

	static public function mdlObtenerOpcionesMenu($idMenu){

		$stmt = Connection::connectOnly()->prepare("SELECT * FROM proyectos_opciones WHERE id_menu = $idMenu AND estado=1");

		if($stmt->execute()){

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}else{

			return $stmt->errorInfo();

		}

	}

	static public function mdlObtenerMenusProyecto($data, $proyecto){

		$stmt = Connection::connectOnly()->prepare("SELECT p.id_proyecto, p.proyecto, p.ruta, pm.id_menu, up.usuario, pm.menu, pm.icon FROM proyectos AS p JOIN usuarios_permisos AS up ON p.id_proyecto = up.id_proyecto JOIN proyectos_menu AS pm ON up.id_menu = pm.id_menu WHERE up.usuario = '$data' AND p.ruta = '$proyecto'");

		if($stmt->execute()){

			return $stmt->fetchAll();

		}else{

			return $stmt->errorInfo();

		}

	}


	static public function mdlObtenerProyectosPermiso($usuario){

		$stmt = Connection::connectOnly()->prepare("SELECT proyectos.proyecto, proyectos.descripcion, proyectos.orden, proyectos.ruta, proyectos.ruta_imagen, usuarios.usuario FROM proyectos JOIN usuarios_permisos ON proyectos.id_proyecto = usuarios_permisos.id_proyecto JOIN usuarios ON usuarios_permisos.usuario = usuarios.usuario WHERE usuarios.usuario = '$usuario' AND proyectos.estado = 1 GROUP BY proyectos.proyecto ORDER BY proyectos.orden ASC");

		if($stmt->execute()){

			$resultado = $stmt->fetchAll();

			if(!empty($resultado)){

				//BUSCAR PROYECTOS QUE NO TIENE PERMISO EL USUARIO

				$cadenaProyecto = "";

				foreach ($resultado as $key => $valueResultado) {

					$cadenaProyecto .= "'".$valueResultado["ruta"]."',";
					
				}

				$cadenaProyecto = substr($cadenaProyecto, 0, -1);

				$notPermisos = Connection::connectOnly()->prepare("SELECT * FROM proyectos WHERE ruta NOT IN ($cadenaProyecto) ORDER BY proyectos.orden ASC");

				$notPermisos->execute();

				$resultadoNotPermisos = $notPermisos->fetchAll();

				$arrayRespuesta = array(
					"permisosAsignados" => $resultado,
					"permisosNoAsignados" => $resultadoNotPermisos
				);

				return $arrayRespuesta;

			}

		}else{

			return $stmt->errorInfo();

		}


	}

    /* public static function mdlLogin($tabla, $data)
    {
        $datos = json_decode(base64_decode($data), true);
        $passEncrypt = crypt($datos["password"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE usuario=:user AND password=:pass");
        $stmt->bindParam(":user", $datos["user"], PDO::PARAM_STR);
        $stmt->bindParam(":pass", $passEncrypt, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
            //return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } else {

            return "error";
        }

        $stmt = null;
    } */

    static public function mdlMostrarUsuarios($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		} else {

			$stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE usuario!='administrador'");

			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		$stmt = null;
	}

    static public function mdlSesionUsuario($tabla, $datos)
	{

		$stmt = Connection::connectOnly()->prepare("SELECT * from $tabla where usuario='$datos'");

		$stmt->execute();

		$resultado = $stmt->fetchAll();

		if (sizeof($resultado) > 0) {

			return 'Login';

			$stmt = null;

		} else {

			return 'Not Login';

			$stmt = null;
		}
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
}
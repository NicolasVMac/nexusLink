<?php

class ControladorUsers{

    static public function ctrAgregarUsuarioPQRS($datos){

        $tabla = "usuarios";

        $itemUser = "documento";
        $valorUser = $datos["documento"];

        $datosUsuario = ControladorUsers::ctrObtenerDato($tabla, $itemUser, $valorUser);

        if(empty($datosUsuario)){

            $usuario = ControladorUsers::ctrGenerarUsuario($datos["nombres"], $datos["apellidos"]);

            $datosUser = array(
                "nombre" => strtoupper($datos["nombres"]." ".$datos["apellidos"]),
                "documento" => $datos["documento"],
                "telefono" => $datos["telefono"],
                "usuario" => strtolower($usuario),
                "password" => $datos["documento"],
                "mail" => $datos["correo"]
            );

            $crearUsuario = ModelUsers::mdlCrearUsuario($tabla, $datosUser);

            if($crearUsuario == 'ok'){

                $itemUser = "usuario";
                $valorUser = $usuario;

                $datosUsuario = ControladorUsers::ctrObtenerDato($tabla, $itemUser, $valorUser);

                if(!empty($datosUsuario)){

                    $arrayMenuCargo = array(
                        "AUXILIAR" => 19,
                        "DIGITADOR" => 16,
                        "GESTOR" => 17,
                        "SUPERVISOR" => 18,
                    );

                    //INFO PROYECTO
                    $itemMenu = "id_menu";
                    $valorMenu = $arrayMenuCargo[$datos["cargo"]];
                    $datosMenu = ControladorUsers::ctrObtenerDato("proyectos_menu", $itemMenu, $valorMenu);

                    $datosUsuarioPermisos = array(
                        "usuario" => $datosUsuario["usuario"],
                        "id_proyecto" => $datosMenu["id_proyecto"],
                        "id_menu" => $datosMenu["id_menu"]
                    );

                    $crearPermiso = ControladorUsers::ctrCrearUsuarioPermiso($datosUsuarioPermisos);

                    //SI ES SUPERVISOR TAMBIEN AGREGAMOS EL MENU GESTOR
                    if($datos["cargo"] == "SUPERVISOR"){

                        $datosUsuarioPermisosGestor = array(
                            "usuario" => $datosUsuario["usuario"],
                            "id_proyecto" => $datosMenu["id_proyecto"],
                            "id_menu" => 17 //MENU GESTOR
                        );
    
                        $crearPermisoGestor = ControladorUsers::ctrCrearUsuarioPermiso($datosUsuarioPermisosGestor);

                    }

                    $datosUsuPQRS = array(
                        "tipo" => $datos["cargo"],
                        "nombre" => $datosUsuario["nombre"],
                        "numero_documento" => $datosUsuario["documento"],
                        "usuario" => $usuario,
                        "programas" => $datos["programas"],
                        "usuario_crea" => $datos["usuario_crea"]

                    );

                    //CREAR PROFESIONAL
                    $crearUsuarioPQRS = ModelUsers::mdlCrearUsuarioPQRS($datosUsuPQRS);

                    if($crearPermiso == 'ok'){

                        return array(
                            "respuesta" => "usuario-permisos-creado",
                            "usuario" => $datosUsuario["usuario"]
                        );

                    }else{

                        return array(
                            "respuesta" => "error-creando-permisos",
                        );

                    }


                }else{

                    return array(
                        "respuesta" => "no-existe-usuario",
                    );

                }

            }else{

                return array(
                    "respuesta" => "error-crear-usuario",
                );

            }

        }else{

            return array(
                "respuesta" => "error-usuario-existe",
            );

        }

    }

    static public function ctrCrearUsuarioProfesional($datos){

        $tabla = "usuarios";

        $itemUser = "documento";
        $valorUser = $datos["documento"];

        $datosUsuario = ControladorUsers::ctrObtenerDato($tabla, $itemUser, $valorUser);

        if(empty($datosUsuario)){

            $usuario = ControladorUsers::ctrGenerarUsuario($datos["nombres"], $datos["apellidos"]);

            $datosUser = array(
                "nombre" => strtoupper($datos["nombres"]." ".$datos["apellidos"]),
                "documento" => $datos["documento"],
                "telefono" => $datos["telefono"],
                "usuario" => strtolower($usuario),
                "password" => $datos["documento"],
                "mail" => $datos["correo"]
            );

            $crearUsuario = ModelUsers::mdlCrearUsuario($tabla, $datosUser);

            if($crearUsuario == 'ok'){

                $itemUser = "usuario";
                $valorUser = $usuario;

                $datosUsuario = ControladorUsers::ctrObtenerDato($tabla, $itemUser, $valorUser);

                if(!empty($datosUsuario)){

                    //INFO PROYECTO
                    $itemMenu = "id_menu";
                    $valorMenu = 12;
                    $datosMenu = ControladorUsers::ctrObtenerDato("proyectos_menu", $itemMenu, $valorMenu);

                    $datosUsuarioPermisos = array(
                        "usuario" => $datosUsuario["usuario"],
                        "id_proyecto" => $datosMenu["id_proyecto"],
                        "id_menu" => 12
                    );

                    $crearPermiso = ControladorUsers::ctrCrearUsuarioPermiso($datosUsuarioPermisos);

                    $datosProfesional = array(
                        "id_profesional" => $datosUsuario["id"],
                        "usuario" => $usuario,
                        "nombre_profesional" => $datosUsuario["nombre"],
                        "doc_profesional" => $datosUsuario["documento"]

                    );

                    //CREAR PROFESIONAL
                    $crearProfesional = ModelUsers::mdlCrearProfesional($datosProfesional);


                    $datosCargo = array(
                        "id_usuario" => $datosUsuario["id"],
                        "cargo" => $datos["cargo"]
                    );

                    //CREAR USUARIO CARGO
                    $crearCargo = ModelUsers::mdlCrearCargoUsuario($datosCargo);

                    if($crearPermiso == 'ok'){

                        return array(
                            "respuesta" => "usuario-permisos-creado",
                            "usuario" => $datosUsuario["usuario"]
                        );

                    }else{

                        return array(
                            "respuesta" => "error-creando-permisos",
                        );

                    }


                }else{

                    return array(
                        "respuesta" => "no-existe-usuario",
                    );

                }

            }else{

                return array(
                    "respuesta" => "error-crear-usuario",
                );

            }

        }else{

            return array(
                "respuesta" => "error-usuario-existe",
            );

        }
        
    }

    static public function ctrGenerarUsuario($nombres, $apellidos) {

        function limpiarCaracteresEspeciales($cadena) {
            $caracteresEspeciales = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');
            $caracteresReemplazo = array('a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N');
            return str_replace($caracteresEspeciales, $caracteresReemplazo, strtolower($cadena));
        }
    
        $partesNombres = explode(" ", $nombres);
        $partesApellidos = explode(" ", $apellidos);
    
        $nombreUser = substr($partesNombres[0], 0, 1);
        $apellidoUser = $partesApellidos[0];
        $usuario = limpiarCaracteresEspeciales($nombreUser . $apellidoUser);
    
        $tabla = "usuarios";
        $datosUsuario = ControladorUsers::ctrObtenerDato($tabla, "usuario", $usuario);
    
        if(!empty($datosUsuario)) {

            $nombreUser = substr($partesNombres[0], 0, 2);
            $usuario = limpiarCaracteresEspeciales($nombreUser . $apellidoUser);

            $tabla = "usuarios";
            $datosUsuario = ControladorUsers::ctrObtenerDato($tabla, "usuario", $usuario);

            if(!empty($datosUsuario)){

                $nombreUser = substr($partesNombres[0], 0, 3);
                $usuario = limpiarCaracteresEspeciales($nombreUser . $apellidoUser);

            }

        }
    
        return $usuario;
    }

    static public function ctrEditarUsuario($datos){

        $tabla = "usuarios";

        $editarUsuario = ModelUsers::mdlEditarUsuario($tabla, $datos);

        if($editarUsuario == 'ok'){

            //ELIMINAR LOS MENUS ANTERIORES
            $deleteMenusUsuario = ModelUsers::mdlEliminarMenusUsuario($datos["usuario"]);

            if($deleteMenusUsuario == 'ok'){

                //REGISTRAR PERMISOS
                $arrayMenus = explode(",", $datos["menus"]);

                foreach ($arrayMenus as $key => $valueMenu) {

                    //INFO PROYECTO
                    $itemMenu = "id_menu";
                    $valorMenu = $valueMenu;
                    $datosMenu = ControladorUsers::ctrObtenerDato("proyectos_menu", $itemMenu, $valorMenu);

                    $datosUsuarioPermisos = array(
                        "usuario" => $datos["usuario"],
                        "id_proyecto" => $datosMenu["id_proyecto"],
                        "id_menu" => $valueMenu
                    );

                    $crearPermiso = ControladorUsers::ctrCrearUsuarioPermiso($datosUsuarioPermisos);

                }

                if($crearPermiso == 'ok'){

                    return 'usuario-permisos-editado';

                }else{

                    return 'error-creando-permisos';

                }

            }else{

                return 'error-eliminando-menus';

            }


        }else{

            return 'error-editar-usuario';

        }

    }

    static public function ctrObtenerMenusUsuario($usuario){

        $respuesta = ModelUsers::mdlObtenerMenusUsuario($usuario);

        $arrayMenus = [];

        foreach ($respuesta as $key => $value) {

            $arrayMenus[] = $value["id_menu"];

        }


        return $arrayMenus;

    }

    static public function ctrCrearUsuario($datos){

        $tabla = "usuarios";

        //VALIDAR SI EXISTE USUARIO
        $userExiste = ModelUsers::mdlExisteUsuario($datos["usuario"]);

        if(empty($userExiste)){

            $crearUsuario = ModelUsers::mdlCrearUsuario($tabla, $datos);

            if($crearUsuario == 'ok'){

                $itemUser = "usuario";
                $valorUser = $datos["usuario"];

                $datosUsuario = ControladorUsers::ctrObtenerDato($tabla, $itemUser, $valorUser);

                if(!empty($datosUsuario)){

                    //REGISTRAR PERMISOS
                    $arrayMenus = explode(",", $datos["menus"]);

                    foreach ($arrayMenus as $key => $valueMenu) {

                        //INFO PROYECTO
                        $itemMenu = "id_menu";
                        $valorMenu = $valueMenu;
                        $datosMenu = ControladorUsers::ctrObtenerDato("proyectos_menu", $itemMenu, $valorMenu);

                        $datosUsuarioPermisos = array(
                            "usuario" => $datosUsuario["usuario"],
                            "id_proyecto" => $datosMenu["id_proyecto"],
                            "id_menu" => $valueMenu
                        );

                        $crearPermiso = ControladorUsers::ctrCrearUsuarioPermiso($datosUsuarioPermisos);

                    }

                    if($crearPermiso == 'ok'){

                        return 'usuario-permisos-creado';

                    }else{

                        return 'error-creando-permisos';

                    }


                }else{

                    return 'no-existe-usuario';

                }

            }else{

                return 'error-crear-usuario';

            }

        }else{

            return 'usuario-existe';

        }

    }

    static public function ctrCrearUsuarioPermiso($datos){

        $tabla = "usuarios_permisos";

        $respuesta = ModelUsers::mdlCrearUsuarioPermiso($tabla, $datos);

        return $respuesta;

    }

    static public function ctrMenusProyecto($idProyecto){

        $respuesta = ModelUsers::mdlMenusProyecto($idProyecto);

        return $respuesta;

    }

    static public function ctrListaProyectos(){

        $respuesta = ModelUsers::mdlListaProyectos();

        return $respuesta;
        
    }

    static public function ctrListaUsuarios($user){

        $respuesta = ModelUsers::mdlListaUsuarios($user);

        return $respuesta;

    }

    static public function ctrLogin($data)
    {
        $tabla = 'usuarios';
        $datos = json_decode(base64_decode($data), true);
        $paswordEncrypt = crypt($datos["password"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
        $respuesta = ModelUsers::mdlMostrarUsuarios($tabla, 'usuario', $datos["user"]);

        if (!empty($respuesta)) {
            if ($respuesta["usuario"] == $datos["user"] && $respuesta["password"] == $paswordEncrypt) {
                if ($respuesta["estado"] == 1) {

                    $sesionActiva = ModelUsers::mdlSesionUsuario("usuarios_activos", $respuesta["usuario"]);

                    if ($sesionActiva == 'Login') {
                        return 'Login';    
                    } else {
                        session_start();
                        $_SESSION["iniciarSesion"] = "ok";
                        $_SESSION["id_usuario"] = $respuesta["id"];
                        $_SESSION["nombre"] = $respuesta["nombre"];
                        $_SESSION["usuario"] = $respuesta["usuario"];

                        return 'success';
                    }
                } else {
                    return 'disabled';
                }
            } else {
                return 'Incorrect';
            }
        } else {
            return 'Incorrect';
        }
    }

    static public function ctrObtenerProyectosPermiso($usuario){

        $respuesta = ModelUsers::mdlObtenerProyectosPermiso($usuario);

        return $respuesta;

    }

    static public function ctrObtenerMenusProyecto($data, $proyecto){

        $respuesta = ModelUsers::mdlObtenerMenusProyecto($data, $proyecto);

        $array = array();

        foreach ($respuesta as $key => $valueMenu) {
        
            //array_push($array, $valueMenu["menu"]);
            $array["menus"][] = array(

                "menu" => $valueMenu["menu"],
                "icon" => $valueMenu["icon"]

            );

            $idMenu = $valueMenu["id_menu"];

            $opcionesMenu = ModelUsers::mdlObtenerOpcionesMenu($idMenu);

            if(!empty($opcionesMenu)){

                foreach ($opcionesMenu as $key => $valueOpcion) {
    
                    $array[$valueMenu["menu"]][] = array(
                        "id_opcion" => $valueOpcion["id_opcion"],
                        "nombre" => $valueOpcion["nombre"],
                        "opcion" => $valueOpcion["opcion"],
                        "icon" => $valueOpcion["icon"],
                        "ruta" => $valueOpcion["ruta"]
                    );
    
                }

            }else{

                return "El menu no tiene opciones, validar.";

            }

        
        }

        return $array;


    }

    static public function ctrObtenerDato($tabla, $item, $valor){

        $respuesta = ModelUsers::mdlObtenerDato($tabla, $item, $valor);

        return $respuesta;

    }

}

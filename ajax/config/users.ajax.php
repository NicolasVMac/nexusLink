<?php

require_once "../../controllers/config/users.controller.php";
require_once "../../models/config/users.model.php";

class UsersAjax{

    public $datos;

    public function mostrarPerfiles($data){

        $permisos = ControladorUsers::ctrObtenerProyectosPermiso($data);

        echo json_encode($permisos);
        
    }

    public function mostrarMenus($data, $proyecto){

        $menus = ControladorUsers::ctrObtenerMenusProyecto($data, $proyecto);

        echo json_encode($menus);
    }

    public function listaUsuarios($user){

        $usuarios = ControladorUsers::ctrListaUsuarios($user);
        
        $data = array();

        foreach ($usuarios as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }

    public function listaProyectos(){

        $proyectos = ControladorUsers::ctrListaProyectos();

        echo json_encode($proyectos);

    }

    public function menusProyecto($idProyecto){

        $menus = ControladorUsers::ctrMenusProyecto($idProyecto);

        echo json_encode($menus);

    }

    public function selectMenus(){

        $cadenaSelect = '<select class="form-select select-field-multiple" id="selectMenus" data-placeholder="Menus Disponibles" multiple style="width: 100%;" required>';
    
            $proyectos = ControladorUsers::ctrListaProyectos();

            foreach ($proyectos as $key => $valueProyecto) {

                $cadenaSelect .= '<optgroup label="'.$valueProyecto["proyecto"].'">';

                $menus = ControladorUsers::ctrMenusProyecto($valueProyecto["id_proyecto"]);

                foreach ($menus as $key => $valueMenu) {

                    //$isSelect = $valueMenu["id_menu"] == 5 || $valueMenu["id_menu"] == 7 ? 'selected' : '';
                    
                    $cadenaSelect .= '<option value="'.$valueMenu["id_menu"].'">'.$valueMenu["menu"].' - '.$valueMenu["descripcion"].'</option>';
                
                }

            }

        $cadenaSelect .= '</select>';

        echo $cadenaSelect;

    }

    public function crearUsuario(){

        $datos = $this->datos;

        $crearUsuario = ControladorUsers::ctrCrearUsuario($datos);

        echo $crearUsuario;

    }

    public function selectMenusUsuario($usuario){

        $cadenaSelect = '<select class="form-select select-field-multiple" id="selectMenus" data-placeholder="Menus Disponibles" multiple style="width: 100%;" required>';
    
            $proyectos = ControladorUsers::ctrListaProyectos();

            foreach ($proyectos as $key => $valueProyecto) {

                $cadenaSelect .= '<optgroup label="'.$valueProyecto["proyecto"].'">';

                $menus = ControladorUsers::ctrMenusProyecto($valueProyecto["id_proyecto"]);

                $menusUsuario = ControladorUsers::ctrObtenerMenusUsuario($usuario);

                foreach ($menus as $key => $valueMenu) {

                    //$isSelect = $valueMenu["id_menu"] == 5 || $valueMenu["id_menu"] == 7 ? 'selected' : '';

                    if(!empty($menusUsuario)){

                        $isSelect = in_array($valueMenu["id_menu"], $menusUsuario) ? 'selected' : '';

                        $cadenaSelect .= '<option value="'.$valueMenu["id_menu"].'" '.$isSelect.'>'.$valueMenu["menu"].' - '.$valueMenu["descripcion"].'</option>';
                    
                    }else{

                        $cadenaSelect .= '<option value="'.$valueMenu["id_menu"].'">'.$valueMenu["menu"].' - '.$valueMenu["descripcion"].'</option>';

                    }
                
                }

            }

        $cadenaSelect .= '</select>';

        echo $cadenaSelect;

    }

    public function infoUsuario($idUsuario){

        $respuesta = ControladorUsers::ctrObtenerDato("usuarios", "id", $idUsuario);

        echo json_encode($respuesta);

    }

    public function editarUsuario(){

        $datos = $this->datos;

        $editarUsuario = ControladorUsers::ctrEditarUsuario($datos);

        echo $editarUsuario;

    }

    public function crearUsuarioProfesional(){

        $datos = $this->datos;

        $crear = ControladorUsers::ctrCrearUsuarioProfesional($datos);

        echo json_encode($crear);

    }

    public function agregarUsuarioPQRS(){

        $datos = $this->datos;

        $respuesta = ControladorUsers::ctrAgregarUsuarioPQRS($datos);

        echo json_encode($respuesta);

    }

}

if (isset($_POST['lista'])) {
    $lista = $_POST['lista'];
    switch ($lista) {

        case 'agregarUsuarioPQRS':
            $agregarUsuarioPQRS = new UsersAjax();
            $agregarUsuarioPQRS->datos = array(
                "nombres" => $_POST["nombreUsuario"],
                "apellidos" => $_POST["apellidosUsuario"],
                "documento" => $_POST["documentoUsuario"],
                "telefono" => $_POST["telefonoUsuario"],
                "correo" => $_POST["correoUsuario"],
                "cargo" => $_POST["cargoUsuario"],
                "programas" => $_POST["respPrograma"],
                "usuario_crea" => $_POST["userCreate"]
            );
            $agregarUsuarioPQRS->agregarUsuarioPQRS();
            break;

        case 'crearUsuarioProfesional':
            $crearUsuarioProfesional = new UsersAjax();
            $crearUsuarioProfesional->datos = array(
                "nombres" => $_POST["nombres"],
                "apellidos" => $_POST["apellidos"],
                "documento" => $_POST["documento"],
                "telefono" => $_POST["telefono"],
                "correo" => $_POST["correo"],
                "cargo" => $_POST["cargo"],
                "usuario_crea" => $_POST["userCreate"]
            );
            $crearUsuarioProfesional->crearUsuarioProfesional();
            break;

        case 'editarUsuario':
            $editarUsuario = new UsersAjax();
            $editarUsuario->datos = array(
                "id_usuario" => $_POST["editarIdUsuario"],
                "usuario" => $_POST["editarUsuarioTxt"],
                "nombre" => strtoupper($_POST["editarNombre"]),
                "nuevoPassowrd" => $_POST["editarPassword"],
                "antiguoPassword" => $_POST["passwordAntiguo"],
                "telefono" => $_POST["editarTelefono"],
                "mail" => $_POST["editarCorreo"],
                "menus" => $_POST["menus"]
            );
            $editarUsuario->editarUsuario();
            break;

        case 'infoUsuario':
            $infoUsuario = new UsersAjax();
            $infoUsuario->infoUsuario($_POST["idUsuario"]);
            break;

        case 'selectMenusUsuario':
            $selectMenusUsuario = new UsersAjax();
            $selectMenusUsuario->selectMenusUsuario($_POST["usuario"]);
            break;

        case 'crearUsuario':
            $crearUsuario = new UsersAjax();
            $crearUsuario->datos = array(
                "nombre" => strtoupper($_POST["nombreUsuario"]),
                "documento" => $_POST["numDocUsuario"],
                "telefono" => $_POST["telefonoUsuario"],
                "usuario" => strtolower($_POST["usuarioNuevo"]),
                "password" => $_POST["passwordUsuario"],
                "mail" => $_POST["correoUsuario"],
                "menus" => $_POST["menus"]
            );
            $crearUsuario->crearUsuario();
            break;

        case 'selectMenus':
            $selectMenus = new UsersAjax();
            $selectMenus->selectMenus();
            break;

        case 'menusProyecto':
            $menusProyecto = new UsersAjax();
            $menusProyecto->menusProyecto($_POST["idProyecto"]);
            break;

        case 'listaProyectos':
            $listaProyectos = new UsersAjax();
            $listaProyectos->listaProyectos();
            break;

        case 'listaUsuarios':
            $listaUsuarios = new UsersAjax();
            $listaUsuarios->listaUsuarios($_POST["user"]);
            break;

        case 'mostrarPerfiles':
            $mostrarPerfiles = new UsersAjax();
            $mostrarPerfiles->mostrarPerfiles($_POST["data"]);
            break;
        case 'mostrarMenuUsuarioProyecto':
            $mostrarMenus = new UsersAjax();
            $mostrarMenus->mostrarMenus($_POST["data"], $_POST["proyecto"]);
            break;
        case 'logout':
            break;
    }
}

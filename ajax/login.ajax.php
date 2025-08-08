<?php

require_once "../controllers/config/users.controller.php";
require_once "../models/config/users.model.php";

class loginAjax
{
    public $datos;

    public function login($data)
    {
        
        //$datos = json_decode(base64_decode($data), true);

        $resultado = ControladorUsers::ctrLogin($data);

        print_r($resultado);
        //var_dump($datos);
        
    }
}

if (isset($_POST['lista'])) {
    $lista = $_POST['lista'];

    switch ($lista) {
        case 'login':
            $auditoria = new loginAjax();
            $auditoria->login($_POST["data"]);
            break;
        case 'logout':
            break;
    }
}

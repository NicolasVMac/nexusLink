<?php

require_once "../../controllers/correspon/correspondencia-recibida.controller.php";
require_once "../../models/correspon/correspondencia-recibida.model.php";

class CorrespondenciaRecibidaAjax{

    public $datos;

    public function selectListaRadicado($idProyecto){

        $listaCorrespondenciaEnv = ControladorCorrespondenciaRecibida::ctrListaCorrespondenciaEnviadaProyecto($idProyecto);

        $htmlSelect = '<label>Correspondenvia Enviada</label>
            <select class="form-control" id="nuevoIdCorresponEnv" name="nuevoIdCorresponEnv" style="width: 100%;" required><option value="">Seleccione una opcion</option>';

            foreach ($listaCorrespondenciaEnv as $key => $valueLista){
                $htmlSelect .= '<option value="'.$valueLista["id_corr_env"].'">'.$valueLista["codigo"].' - '.$valueLista["asunto"].'</option>';
            }

        $htmlSelect .= '</select>';

        echo $htmlSelect;
        
    }

    public function cargarCorresponRec(){

        $datos = $this->datos;

        $respuesta = ControladorCorrespondenciaRecibida::ctrCargarCorrespondenciaRecibida($datos);

        echo $respuesta;

    }

    public function listaCorrespondenciaRecibida($user){

        $respuesta = ControladorCorrespondenciaRecibida::ctrListaCorrespondenciaRecibida($user);

        $data = array();

        foreach ($respuesta as $key => $value) {
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

    public function infoCorrespondenciaRec($idCorresRec){

        $respuesta = ControladorCorrespondenciaRecibida::ctrInfoCorrespondenciaRec($idCorresRec);

        echo json_encode($respuesta);

    }

    public function eliminarCorresponRec($idCorresRec, $user){

        $respuesta = ControladorCorrespondenciaRecibida::ctrEliminarCorresponRec($idCorresRec, $user);

        echo $respuesta;

    }

    public function reAsignarCorresRec(){

        $datos = $this->datos;

        $respuesta = ControladorCorrespondenciaRecibida::ctrReAsignarCorresRec($datos);
        
        echo $respuesta;

    }

    public function listaMiBandejaCorresponRec($idUserSesion){

        $respuesta = ControladorCorrespondenciaRecibida::ctrListaMiBandejaCorresponRec($idUserSesion);

        $data = array();

        foreach ($respuesta as $key => $value) {
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

    public function aceptarCorresponRec(){

        $datos = $this->datos;

        $respuesta = ControladorCorrespondenciaRecibida::ctrAceptarCorrespondenciaRecibida($datos);

        echo $respuesta;

    }

    public function listaMiCorresponRec($idUserSesion){

        $respuesta = ControladorCorrespondenciaRecibida::ctrListaMiCorresponRec($idUserSesion);

        $data = array();

        foreach ($respuesta as $key => $value) {
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

    public function rechazarCorresponRec(){

        $datos = $this->datos;

        $respuesta = ControladorCorrespondenciaRecibida::ctrRechazarCorresponRec($datos);

        echo $respuesta;


    }


    public function listaUsuariosCorresponRecibida($idUserSesion){

        $usuarios = ControladorCorrespondenciaRecibida::ctrListaUsuariosCorresponRecibida($idUserSesion);

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Usuario</option>';
        
        foreach ($usuarios as $key => $value) {

            $cadena .= '<option value="'.$value["id"].'">'.$value["nombre"].' - '.$value["usuario"].'</option>';

        }

        echo $cadena;

    }

    public function asignarUsuarioCorresponRec(){

        $datos = $this->datos;

        $respuesta = ControladorCorrespondenciaRecibida::ctrAsignarUsuarioCorrespondenciaRec($datos);

        echo $respuesta;

    }

    public function gestionarCorresponRecibida(){

        $datos = $this->datos;

        $respuesta = ControladorCorrespondenciaRecibida::ctrGestionarCorrespondenciaRecibida($datos);

        echo $respuesta;

    }


    public function listaBolsaCorresponFactuRec(){

        $respuesta = ControladorCorrespondenciaRecibida::ctrListaBolsaCorresponFactuRec();

        $data = array();

        foreach ($respuesta as $key => $value) {
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

    public function aprobarCorresponFacRec(){

        $datos = $this->datos;

        $respuesta = ControladorCorrespondenciaRecibida::ctrAprobarCorresponFacRec($datos);

        echo $respuesta;

    }


    public function listaCorresponFactuRec(){

        $respuesta = ControladorCorrespondenciaRecibida::ctrListaCorresponFactuRec();

        $data = array();

        foreach ($respuesta as $key => $value) {
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


    public function listaCorrespondenciaRecibidaAll(){

        $respuesta = ControladorCorrespondenciaRecibida::ctrListaCorrespondenciaRecibidaAll();

        $data = array();

        foreach ($respuesta as $key => $value) {
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

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'listaCorrespondenciaRecibidaAll':
            $listaCorrespondenciaRecibidaAll = new CorrespondenciaRecibidaAjax();
            $listaCorrespondenciaRecibidaAll->listaCorrespondenciaRecibidaAll();
            break;

        case 'listaCorresponFactuRec':
            $listaCorresponFactuRec = new CorrespondenciaRecibidaAjax();
            $listaCorresponFactuRec->listaCorresponFactuRec();
            break;

        case 'aprobarCorresponFacRec':
            $aprobarCorresponFacRec = new CorrespondenciaRecibidaAjax();
            $aprobarCorresponFacRec->datos = array(
                "id_corr_rec" => $_POST["idCorresRecApro"],
                "aprobado_cartera" => $_POST["estadoAprobacion"],
                "observaciones_cartera" => mb_strtoupper($_POST["observacionesEstadoAprobacion"]),
                "usuario_cartera" => $_POST["user"]
            );
            $aprobarCorresponFacRec->aprobarCorresponFacRec();
            break;

        case 'listaBolsaCorresponFactuRec':
            $listaBolsaCorresponFactuRec = new CorrespondenciaRecibidaAjax();
            $listaBolsaCorresponFactuRec->listaBolsaCorresponFactuRec();
            break;

        case 'gestionarCorresponRecibida':
            $gestionarCorresponRecibida = new CorrespondenciaRecibidaAjax();
            if(isset($_FILES["archivosGestionCorresponRec"])){$archivosGestionCorresponRec = $_FILES["archivosGestionCorresponRec"];}else{$archivosGestionCorresponRec = 'VACIO';}
            $gestionarCorresponRecibida->datos = array(
                "observaciones_ges" => mb_strtoupper($_POST["observaGestionCorresRec"]),
                "usuario_gestion" => $_POST["user"],
                "id_corr_rec" => $_POST["idCorresponRec"],
                "archivosGestionCorresponRec" => $archivosGestionCorresponRec
            );
            $gestionarCorresponRecibida->gestionarCorresponRecibida();
            break;

        case 'asignarUsuarioCorresponRec':
            $asignarUsuarioCorresponRec = new CorrespondenciaRecibidaAjax();
            $asignarUsuarioCorresponRec->datos = array(
                "id_corr_rec" => $_POST["idCorresRecReAsignar"],
                "id_usuario_re_asignacion" => $_POST["usuarioResponsableCorresRec"],
                "usuario_sesion" => $_POST["user"],
            );
            $asignarUsuarioCorresponRec->asignarUsuarioCorresponRec();
            break;

        case 'listaUsuariosCorresponRecibida':
            $listaUsuariosCorresponRecibida = new CorrespondenciaRecibidaAjax();
            $listaUsuariosCorresponRecibida->listaUsuariosCorresponRecibida($_POST["idUserSesion"]);
            break;

        case 'rechazarCorresponRec':
            $rechazarCorresponRec = new CorrespondenciaRecibidaAjax();
            $rechazarCorresponRec->datos = array(
                "id_corr_rec" => $_POST["idCorresRec"],
                "usuario_sesion" => $_POST["userSession"],
                "id_user" => $_POST["idUserSession"]
            );
            $rechazarCorresponRec->rechazarCorresponRec();
            break;

        case 'listaMiCorresponRec':
            $listaMiCorresponRec = new CorrespondenciaRecibidaAjax();
            $listaMiCorresponRec->listaMiCorresponRec($_POST["idUserSesion"]);
            break;

        case 'aceptarCorresponRec':
            $aceptarCorresponRec = new CorrespondenciaRecibidaAjax();
            $aceptarCorresponRec->datos = array(
                "id_corr_rec" => $_POST["idCorresRec"],
                "usuario_sesion" => $_POST["userSession"],
                "id_user" => $_POST["idUserSession"]
            );
            $aceptarCorresponRec->aceptarCorresponRec();
            break;

        case 'listaMiBandejaCorresponRec':
            $listaMiBandejaCorresponRec = new CorrespondenciaRecibidaAjax();
            $listaMiBandejaCorresponRec->listaMiBandejaCorresponRec($_POST["idUserSesion"]);
            break;

        case 'reAsignarCorresRec':
            $reAsignarCorresRec = new CorrespondenciaRecibidaAjax();
            $reAsignarCorresRec->datos = array(
                "id_corr_rec" => $_POST["idCorresRecReAsignar"],
                "asunto" => mb_strtoupper($_POST["asuntoCorresRecReAsignar"]),
                "observaciones" => mb_strtoupper($_POST["observacionesCorresRecReAsignar"]),
                "id_proyecto" => $_POST["proyectoCorresRecReAsignar"],
                "id_responsable_proyecto" => $_POST["idResponProyectoCorresRecReAsignar"],
                "id_responsable_proyecto_old" => $_POST["idResponProyectoCorresRecOld"],
                "usuario_sesion" => $_POST["user"]
            );
            $reAsignarCorresRec->reAsignarCorresRec();
            break;

        case 'eliminarCorresponRec':
            $eliminarCorresponRec = new CorrespondenciaRecibidaAjax();
            $eliminarCorresponRec->eliminarCorresponRec($_POST["idCorresRec"], $_POST["userSession"]);
            break;

        case 'infoCorrespondenciaRec':
            $infoCorrespondenciaRec = new CorrespondenciaRecibidaAjax();
            $infoCorrespondenciaRec->infoCorrespondenciaRec($_POST["idCorresponRec"]);
            break;

        case 'listaCorrespondenciaRecibida':
            $listaCorrespondenciaRecibida = new CorrespondenciaRecibidaAjax();
            $listaCorrespondenciaRecibida->listaCorrespondenciaRecibida($_POST["userSesion"]);
            break;

        case 'cargarCorresponRec':
            $cargarCorresponRec = new CorrespondenciaRecibidaAjax();
            if(isset($_FILES["archivosCorresRec"])){$archivosCorresRec = $_FILES["archivosCorresRec"];}else{$archivosCorresRec = 'VACIO';}
            if(isset($_POST["nuevoIdCorresponEnv"])){$idCorresponEnv = $_POST["nuevoIdCorresponEnv"];}else{$idCorresponEnv = null;}
            $cargarCorresponRec->datos = array(
                "id_corr_env" => $idCorresponEnv,
                "asunto" => mb_strtoupper($_POST["nuevoAsunCorresponRec"]),
                "observaciones" => mb_strtoupper($_POST["nuevoObservacionesCorresponRec"]),
                "archivosCorresRec" => $archivosCorresRec,
                "id_proyecto" => $_POST["nuevoProyectoCorresRec"],
                "id_responsable_proyecto" => $_POST["idResponProyectoCorresRec"],
                "tipo_correspondencia" => $_POST["nuevoTipoCorresponRec"],
                "usuario_crea" => $_POST["user"]
            );
            $cargarCorresponRec->cargarCorresponRec();
            break;

        case 'selectListaRadicado':
            $selectListaRadicado = new CorrespondenciaRecibidaAjax();
            $selectListaRadicado->selectListaRadicado($_POST["idProyecto"]);
            break;

    }

}
<?php

require_once "../../controllers/correspon/correspondencia-enviada.controller.php";
require_once "../../models/correspon/correspondencia-enviada.model.php";

class CorrespondenciaEnviadaAjax{

    public $datos;

    public function crearNuevoConsecutivo(){

        $datos = $this->datos;

        $resultado = ControladorCorrespondenciaEnviada::ctrCrearNuevoConsecutivo($datos);

        echo json_encode($resultado);

    }

    public function listaMiCorrespondenciaEnviada($user){

        $respuesta = ControladorCorrespondenciaEnviada::ctrListaMiCorrespondenciaEnviada($user);

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

    public function infoCorrespondenciaEnv($idCorresEnv){

        $respuesta = ControladorCorrespondenciaEnviada::ctrInfoCorrespondenciaEnv($idCorresEnv);

        echo json_encode($respuesta);

    }

    public function anularCorrespondenciaEnv(){

        $datos = $this->datos;

        $respuesta = ControladorCorrespondenciaEnviada::ctrAnularCorrespondenciaEnv($datos);

        echo json_encode($respuesta);

    }


    public function radicarCorrespondenciaEnv(){

        $datos = $this->datos;

        $respuesta = ControladorCorrespondenciaEnviada::ctrRadicarCorrespondenciaEnv($datos);

        echo $respuesta;

    }

    public function respuestaCorrespondenciaEnv(){

        $datos = $this->datos;

        $respuesta = ControladorCorrespondenciaEnviada::ctrRespuestaCorrespondenciaEnv($datos);

        echo $respuesta;

    }


    public function listaCorrespondenciaEnviada(){

        $respuesta = ControladorCorrespondenciaEnviada::ctrListaCorrespondenciaEnviada();

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

        case 'listaCorrespondenciaEnviada':
            $listaCorrespondenciaEnviada = new CorrespondenciaEnviadaAjax();
            $listaCorrespondenciaEnviada->listaCorrespondenciaEnviada();
            break;

        case 'respuestaCorrespondenciaEnv':
            $respuestaCorrespondenciaEnv = new CorrespondenciaEnviadaAjax();
            if(isset($_FILES["archivosRespCorres"])){$archivosRespCorres = $_FILES["archivosRespCorres"];}else{$archivosRespCorres = 'VACIO';}
            $respuestaCorrespondenciaEnv->datos = array(
                "id_corr_env" => $_POST["idCorresEnvRespCorres"],
                "radicado" => mb_strtoupper($_POST["radicadoRespCorres"]),
                "usuario_radicado" => $_POST["user"],
                "archivosRespCorres" => $archivosRespCorres,
            );
            $respuestaCorrespondenciaEnv->respuestaCorrespondenciaEnv();
            break;

        case 'radicarCorrespondenciaEnv':
            $radicarCorrespondenciaEnv = new CorrespondenciaEnviadaAjax();
            if(isset($_FILES["archivosRadCorres"])){$archivosRadCorres = $_FILES["archivosRadCorres"];}else{$archivosRadCorres = 'VACIO';}
            $radicarCorrespondenciaEnv->datos = array(
                "id_corr_env" => $_POST["idCorresEnvRadCorres"],
                "asunto" => mb_strtoupper($_POST["asuntoRadCorres"]),
                "usuario_radicacion" => $_POST["user"],
                "destinatario" => $_POST["destinatarioRadCorres"], 
                "descripcion" => $_POST["descripcionRadCorres"], 
                "archivosRadCorres" => $archivosRadCorres
            );
            $radicarCorrespondenciaEnv->radicarCorrespondenciaEnv();
            break;

        case 'anularCorrespondenciaEnv':
            $anularCorrespondenciaEnv = new CorrespondenciaEnviadaAjax();
            $anularCorrespondenciaEnv->datos = array(
                "id_corr_env" => $_POST["idCorresEnvAnular"],
                "estado" => $_POST["accionAnular"],
                "motivo_anula" => mb_strtoupper($_POST["observacionesAnula"]),
                "usuario_anula" => $_POST["userSession"]
            );
            $anularCorrespondenciaEnv->anularCorrespondenciaEnv();
            break;

        case 'infoCorrespondenciaEnv':
            $infoCorrespondenciaEnv = new CorrespondenciaEnviadaAjax();
            $infoCorrespondenciaEnv->infoCorrespondenciaEnv($_POST["idCorresponEnv"]);
            break;

        case 'listaMiCorrespondenciaEnviada':
            $listaMiCorrespondenciaEnviada = new CorrespondenciaEnviadaAjax();
            $listaMiCorrespondenciaEnviada->listaMiCorrespondenciaEnviada($_POST["userSesion"]);
            break;

        case 'crearNuevoConsecutivo':
            $crearNuevoConsecutivo = new CorrespondenciaEnviadaAjax();
            $crearNuevoConsecutivo->datos = array(
                "id_proyecto" => $_POST["proyectosCorrespondencia"],
                "tipo_comunicacion" => $_POST["tipoComuniCorrespondencia"],
                "usuario_crea" => $_POST["userSession"]
            );
            $crearNuevoConsecutivo->crearNuevoConsecutivo();
            break;

    }

}
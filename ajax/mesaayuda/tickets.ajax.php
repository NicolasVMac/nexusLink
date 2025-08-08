<?php


require_once "../../controllers/mesaayuda/tickets.controller.php";
require_once "../../models/mesaayuda/tickets.model.php";
//require_once "../../models/callcenter/callcenter.model.php";

class TicketsAjax{

    public $datos;
    
    public function cargarImagenesTickets($filename, $tmpName){

        $codigoNumerico = rand(000000001, 999999999);

        $filename = $codigoNumerico."-".$filename;

        $uploadImg = ControladorTickets::ctrCargarImagenesTickets($filename, $tmpName);

        //var_dump($uploadImg);

        echo $uploadImg;

    }

    public function crearTicket(){

        $datos = $this->datos;
    
        $crear = ControladorTickets::ctrCrearTicket($datos);

        echo $crear;


    }

    public function misTickets($usuario){

        $respuesta = ControladorTickets::ctrMostrarMisTickets($usuario);

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

    public function verInfoTicket($idTicket){

        $respuesta = ControladorTickets::ctrVerInfoTicket($idTicket);

        echo json_encode($respuesta);

    }

    public function verArchivosTicket($rutaArchivos){

        $respuesta = ControladorTickets::ctrVerArchivosTicket($rutaArchivos);

        echo json_encode($respuesta);

    }

    public function verSeguimientosTicket($idTicket){

        $respuesta = ControladorTickets::ctrVerSeguimientosTicket($idTicket);

        echo json_encode($respuesta);

    }

    public function verArchivosSeguimientoTicket($rutaArchivos){

        $respuesta = ControladorTickets::ctrVerArchivosSeguimientoTicket($rutaArchivos);

        echo $respuesta;

    }

    public function listaTicketsBolsa(){

        $respuesta = ControladorTickets::ctrListaTicketsBolsa();

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

    public function tomarTicket($user, $idUser, $idTicket, $rolUsuario){

        $respuesta = ControladorTickets::ctrTomarTicket($user, $idUser, $idTicket, $rolUsuario);

        echo $respuesta;

    }

    public function agregarSeguimiento(){

        $datos = $this->datos;
    
        $agregarSegui = ControladorTickets::ctrAgregarSeguimiento($datos);

        echo $agregarSegui;

        //var_dump($crear);

    }

    public function listaMisTicketsPendienteGestion($user){

        $respuesta = ControladorTickets::ctrListaMisTicketsPendienteGestion($user);

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

    public function terminarTicket($idTicket, $tipoSolucion){

        $respuesta = ControladorTickets::ctrTerminarTicket($idTicket, $tipoSolucion);

        echo $respuesta;

    }


}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'terminarTicket':
            $terminarTicket = new TicketsAjax();
            $terminarTicket->terminarTicket($_POST["idTicket"], $_POST["tipoSolucion"]);
            break;

        case 'listaMisTicketsPendienteGestion':
            $listaMisTicketsPendienteGestion = new TicketsAjax();
            $listaMisTicketsPendienteGestion->listaMisTicketsPendienteGestion($_POST["idUser"]);
            break;

        case 'agregarSeguimiento':
            $agregarSeguimiento = new TicketsAjax();
            if(isset($_FILES["archivosTicket"])){$archivosTicket = $_FILES["archivosTicket"];}else{$archivosTicket = '';}
            $agregarSeguimiento->datos = array(
                "id_ticket" => $_POST["idTicket"],
                "id_usuario" => $_POST["idUser"],
                "descripcion" => $_POST["descripcionTicket"],
                "archivosTicket" => $archivosTicket,
                "usuario_crea" => $_POST["usuarioCrea"],
                "rol_usuario" => $_POST["rolUsuario"]
            );
            $agregarSeguimiento->agregarSeguimiento();
            break;

        case 'tomarTicket':
            $tomarTicket = new TicketsAjax();
            $tomarTicket->tomarTicket($_POST["user"], $_POST["idUser"], $_POST["idTicket"], $_POST["rolUsuario"]);
            break;

        case 'listaTicketsBolsa':
            $listaTicketsBolsa = new TicketsAjax();
            $listaTicketsBolsa->listaTicketsBolsa();
            break;

        case 'verArchivosSeguimientoTicket':
            $verArchivosSeguimientoTicket = new TicketsAjax();
            $verArchivosSeguimientoTicket->verArchivosSeguimientoTicket($_POST["rutaArchivos"]);
            break;

        case 'verSeguimientosTicket':
            $verSeguimientosTicket = new TicketsAjax();
            $verSeguimientosTicket->verSeguimientosTicket($_POST["idTicket"]);
            break;

        case 'verArchivosTicket':
            $verArchivosTicket = new TicketsAjax();
            $verArchivosTicket->verArchivosTicket($_POST["rutaArchivos"]);
            break;

        case 'verInfoTicket':
            $verInfoTicket = new TicketsAjax();
            $verInfoTicket->verInfoTicket($_POST["idTicket"]);
            break;

        case 'listaMisTickets':
            $listaMisTickets = new TicketsAjax();
            $listaMisTickets->misTickets($_POST["userTicket"]);
            break;

        case 'crearTicket':

            $crearTicket = new TicketsAjax();

            if(isset($_FILES["archivosTicket"])){$archivosTicket = $_FILES["archivosTicket"];}else{$archivosTicket = '';}

            $crearTicket->datos = array(

                "archivosTicket" => $archivosTicket,
                "id_proyecto" => $_POST["idProyecto"],
                "id_usuario_ticket" => $_POST["idUsuarioTicket"],
                "asunto" => $_POST["asuntoTicket"],
                "descripcion" => $_POST["descripcionTicket"],
                "prioridad" => $_POST["prioridadTicket"],
                "usuario_crea" => $_POST["usuarioCrea"]

            );
            $crearTicket->crearTicket();
            break;

    }


}elseif(isset($_FILES["upload"]["name"])){

    $filename = $_FILES["upload"]["name"];
    $tmpName = $_FILES["upload"]["tmp_name"];
    //echo "Filename: " . $filename . " - TmpName: " . $tmpName;
    $cargarImagen = new TicketsAjax();
    $cargarImagen->cargarImagenesTickets($filename, $tmpName);

}
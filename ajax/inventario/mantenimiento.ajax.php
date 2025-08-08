<?php

require_once "../../controllers/inventario/mantenimiento.controller.php";
require_once "../../models/inventario/mantenimiento.model.php";

class InventarioMantenimientoAjax{

    public $datos;

    public function crearMantenimientoActivoFijo(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioMantenimiento::ctrCrearMantenimientoActivoFijo($datos);

        echo $respuesta;

    }

    public function listaMantenimientosActivosFijos(){

        $respuesta = ControladorInventarioMantenimiento::ctrListaMantenimientosActivosFijos();

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

    public function eliminarMantenimientoActivoFijo($idTipoMante, $usuario){

        $respuesta = ControladorInventarioMantenimiento::ctrEliminarMantenimientoActivoFijo($idTipoMante, $usuario);

        echo  $respuesta;

    }

    public function listaTiposMantenimientosEquipo($idEquipo, $categoriaActivo){

        $respuesta = ControladorInventarioMantenimiento::ctrListaTiposMantenimientosEquipo($idEquipo, $categoriaActivo);

        echo json_encode($respuesta);


    }

    public function infoSolicitudMantenimiento($idSoliMantenimiento, $categoriaActivo){

        $respuesta = ControladorInventarioMantenimiento::ctrInfoSolicitudMantenimiento($idSoliMantenimiento, $categoriaActivo);

        echo json_encode($respuesta);

    }


    public function guardarMantenimiento(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioMantenimiento::ctrGuardarMantenimiento($datos);

        echo $respuesta;

    }

    public function infoMantenimiento(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioMantenimiento::ctrInfoMantenimiento($datos);

        echo json_encode($respuesta);

    }

    public function listaMantenimientosRealizadosActivosFijos(){

        $respuesta = ControladorInventarioMantenimiento::ctrListaMantenimientosRealizadosActivosFijos();

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


    public function infoMantenimientoId($idManteActivoFijo){

        $respuesta = ControladorInventarioMantenimiento::ctrInfoMantenimientoId($idManteActivoFijo);

        echo json_encode($respuesta);

    }

    public function editarMantenimiento(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioMantenimiento::ctrEditarMantenimiento($datos);

        echo $respuesta;

    }


}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'editarMantenimiento':
            $editarMantenimiento = new InventarioMantenimientoAjax();
            if(isset($_POST["gMMantenimientosPreventivos"])){$mantenimientosPreventivos = $_POST["gMMantenimientosPreventivos"];}else{$mantenimientosPreventivos = '';}
            if(isset($_POST["gMMantenimientosCorrectivos"])){$mantenimientosCorrectivos = $_POST["gMMantenimientosCorrectivos"];}else{$mantenimientosCorrectivos = '';}
            $editarMantenimiento->datos = array(
                "id_mante_activo_fijo" => $_POST["idManteActivoFijo"],
                "mantenimientosPreventivos" => $mantenimientosPreventivos,
                "mantenimientosCorrectivos" => $mantenimientosCorrectivos,
                "observaciones_mantenimiento" => mb_strtoupper($_POST["gMObservacionesMantenimiento"]),
                "usuario_edita" => $_POST["user"],
                "categoria_activo" => $_POST["categoriaActivo"],
            );
            $editarMantenimiento->editarMantenimiento();
            break;

        case 'infoMantenimientoId':
            $infoMantenimientoId = new InventarioMantenimientoAjax();
            $infoMantenimientoId->infoMantenimientoId($_POST["idManteActivoFijo"]);
            break;

        case 'listaMantenimientosRealizadosActivosFijos':
            $listaMantenimientosRealizadosActivosFijos = new InventarioMantenimientoAjax();
            $listaMantenimientosRealizadosActivosFijos->listaMantenimientosRealizadosActivosFijos();
            break;

        case 'infoMantenimiento':
            $infoMantenimiento = new InventarioMantenimientoAjax();
            $infoMantenimiento->datos = array(
                "campo" => $_POST["campo"],
                "id_solicitud_mante" => $_POST["idSoliMantenimiento"],
            ); 
            $infoMantenimiento->infoMantenimiento();
            break;

        case 'guardarMantenimiento':
            $guardarMantenimiento = new InventarioMantenimientoAjax();
            if(isset($_POST["gMMantenimientosPreventivos"])){$mantenimientosPreventivos = $_POST["gMMantenimientosPreventivos"];}else{$mantenimientosPreventivos = '';}
            if(isset($_POST["gMMantenimientosCorrectivos"])){$mantenimientosCorrectivos = $_POST["gMMantenimientosCorrectivos"];}else{$mantenimientosCorrectivos = '';}
            $guardarMantenimiento->datos = array(
                "id_equipo_biomedico" => $_POST["idEquipoBio"],
                "id_soli_mante" => $_POST["idSoliMantenimiento"],
                "mantenimientosPreventivos" => $mantenimientosPreventivos,
                "mantenimientosCorrectivos" => $mantenimientosCorrectivos,
                "observaciones_mantenimiento" => mb_strtoupper($_POST["gMObservacionesMantenimiento"]),
                "usuario_crea" => $_POST["user"],
                "categoria_activo" => $_POST["categoriaActivo"],
            );
            $guardarMantenimiento->guardarMantenimiento();
            break;

        case 'infoSolicitudMantenimiento':
        $infoSolicitudMantenimiento = new InventarioMantenimientoAjax();
        $infoSolicitudMantenimiento->infoSolicitudMantenimiento($_POST["idSoliMantenimiento"], $_POST["categoriaActivo"]);
        break;

        case 'listaTiposMantenimientosEquipo':
            $listaTiposMantenimientosEquipo = new InventarioMantenimientoAjax();
            $listaTiposMantenimientosEquipo->listaTiposMantenimientosEquipo($_POST["idEquipo"], $_POST["categoriaActivo"]);
            break;

        case 'eliminarMantenimientoActivoFijo':
            $eliminarMantenimientoActivoFijo = new InventarioMantenimientoAjax();
            $eliminarMantenimientoActivoFijo->eliminarMantenimientoActivoFijo($_POST["idTipoMante"], $_POST["user"]);
            break;

        case 'listaMantenimientosActivosFijos':
            $listaMantenimientosActivosFijos = new InventarioMantenimientoAjax();
            $listaMantenimientosActivosFijos->listaMantenimientosActivosFijos();
            break;

        case 'crearMantenimientoActivoFijo':
            $crearMantenimientoActivoFijo = new InventarioMantenimientoAjax();
            $crearMantenimientoActivoFijo->datos = array(
                "categoria" => $_POST["mCategoriaActivoFijo"],
                "tipo_activo" => $_POST["mTipoActivoFijo"],
                "mantenimiento" => mb_strtoupper($_POST["mMantenimiento"]),
                "tipo_mantenimiento" => $_POST["mTipoMantenimiento"],
                "usuario_crea" => $_POST["user"],
            );
            $crearMantenimientoActivoFijo->crearMantenimientoActivoFijo();
            break;


    }

}
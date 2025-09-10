<?php

require_once "../../controllers/pcm/historicos.controlador.php";
require_once "../../models/pcm/historicos.modelo.php";

class historicosAjax
{
    public $datos;

    public function historicosEvento()
    {
        $datos = $this->datos;

        $resultado = ControladorHistoricos::ctrHistoricosEvento($datos);

        $data = array();

        foreach ($resultado as $key => $value) {
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

    public function reclamacionInfo($idReclamacion)
    {
        $respuesta = ControladorHistoricos::ctrReclamacionInfo($idReclamacion);
        echo json_encode($respuesta);
    }

    public function reclamacionDetail($idReclamacion)
    {
        $respuesta = ControladorHistoricos::ctrReclamacionDetail($idReclamacion);
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

    public function reclamacionGlosas($idReclamacion)
    {
        $respuesta = ControladorHistoricos::ctrReclamacionGlosas($idReclamacion);
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
    public function TablaAnotacion($idReclamacion){

        $respuesta = ControladorHistoricos::ctrTablaAnotacion($idReclamacion);

        $data = array();

        foreach($respuesta as $key => $value){
            $data[] = $value;
        }

        $respuesta = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($respuesta);

    }


    
    
}

    // ----------------------------------------------------------------
    if (isset($_POST['option'])) {
        $option = $_POST['option'];
    
        switch ($option) {
            case 'historicosEvento':
                $auditoria = new historicosAjax();
                $auditoria->datos = array(
                    "idReclamacion" => $_POST["idReclamacion"]
                );
                $auditoria->historicosEvento();
                break;
            case 'reclamacionInfo':
                $auditoria = new historicosAjax();
                $auditoria->reclamacionInfo($_POST["idReclamacion"]);
                break;
            case 'reclamacionDetail':
                $auditoria = new historicosAjax();
                $auditoria->reclamacionDetail($_POST["idReclamacion"]);
                break;
            case 'reclamacionGlosas':
                $auditoria = new historicosAjax();
                $auditoria->reclamacionGlosas($_POST["idReclamacion"]);
                break;
            case 'TablaAnotacion':
                $TablaAnotacion = new historicosAjax();
                $TablaAnotacion->TablaAnotacion($_POST["idReclamacion"]);
                break;
        }
    }
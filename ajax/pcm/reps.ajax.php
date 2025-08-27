<?php

require_once "../../controllers/pcm/reps.controlador.php";
require_once "../../models/pcm/reps.modelo.php";

class repsAjax
{
    public $datos;

    public function repsInfo()
    {
        $datos = $this->datos;

        $resultado = ControladorReps::ctrRepsInfo($datos);

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

    
}

    // ----------------------------------------------------------------
    if (isset($_POST['option'])) {
        $option = $_POST['option'];
    
        switch ($option) {
            case 'repsInfo':
                $auditoria = new repsAjax();
                $auditoria->datos = array(
                    "codigoHabilitacion" => $_POST["codigoHabilitacion"]
                );
                $auditoria->repsInfo();
                break;
           
        }
    }
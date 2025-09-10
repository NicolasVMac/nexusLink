<?php

session_start();

require_once "../../controllers/pcm/cruces.controlador.php";
require_once "../../models/pcm/cruces.modelo.php";

class crucesAjax
{
    public $datos;

    public function cruceRenc()
    {
        $datos = $this->datos;
        $tabla = 'cruce_rnec_fallecidos';

        $resultado = ControladorCruces::ctrCruceRenc($tabla, $datos);

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

    public function cruceRepsHabili()
    {
        $datos = $this->datos;
        $tabla = 'cruce_reps_habilitacion';

        $resultado = ControladorCruces::ctrCruceRepsHabili($tabla, $datos);

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

    public function cruceRepsProced()
    {
        $datos = $this->datos;
        $tabla = 'cruce_reps_procedimientos';

        $resultado = ControladorCruces::ctrCruceRepsProced($tabla, $datos);

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

    public function cruceRepsTrans()
    {
        $datos = $this->datos;
        $tabla = 'cruce_reps_transporte';

        $resultado = ControladorCruces::ctrCruceRepsTrans($tabla, $datos);

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

    public function crucePoliza()
    {
        $datos = $this->datos;
        $tabla = 'cruce_polizas';

        $resultado = ControladorCruces::ctrCrucePoliza($tabla, $datos);

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

    public function cruceSiniestro()
    {
        $datos = $this->datos;
        $tabla = 'cruce_siniestros';

        $resultado = ControladorCruces::ctrCruceSiniestro($tabla, $datos);

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
//------------------------------------- 
if (isset($_POST['option'])) {
    $option = $_POST['option'];

    switch ($option) {
        case 'cruceRenc':
            $auditoria = new crucesAjax();
            $auditoria->datos = array(
                "idReclamacion" => $_POST["idReclamacion"]
            );
            $auditoria->cruceRenc();
            break;
        case 'cruceRepsHabili':
            $auditoria = new crucesAjax();
            $auditoria->datos = array(
                "idReclamacion" => $_POST["idReclamacion"]
            );
            $auditoria->cruceRepsHabili();
            break;
        case 'cruceRepsProced':
            $auditoria = new crucesAjax();
            $auditoria->datos = array(
                "idReclamacion" => $_POST["idReclamacion"]
            );
            $auditoria->cruceRepsProced();
            break;
        case 'cruceRepsTrans':
            $auditoria = new crucesAjax();
            $auditoria->datos = array(
                "idReclamacion" => $_POST["idReclamacion"]
            );
            $auditoria->cruceRepsTrans();
            break;
        case 'crucePoliza':
            $auditoria = new crucesAjax();
            $auditoria->datos = array(
                "idReclamacion" => $_POST["idReclamacion"]
            );
            $auditoria->crucePoliza();
            break;
        case 'cruceSiniestro':
            $auditoria = new crucesAjax();
            $auditoria->datos = array(
                "idReclamacion" => $_POST["idReclamacion"]
            );
            $auditoria->cruceSiniestro();
            break;
    }
}

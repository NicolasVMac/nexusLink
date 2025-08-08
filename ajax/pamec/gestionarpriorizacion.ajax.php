<?php

require_once "../../controllers/pamec/gestionarpriorizacion.controller.php";
require_once "../../models/pamec/gestionarpriorizacion.model.php";

class gestionPriorizacionAjax
{
    public $datos;

    public function actualizarEstadoPriorizacion()
    {
        $datos = $this->datos;
        $respuesta = ControladorGestionPriorizacion::ctrActualizarEstadoPriorizacion($datos);
        echo json_encode($respuesta);
    }
    public function guardarCalidadEsperada()
    {
        $datos = $this->datos;
        $respuesta = ControladorGestionPriorizacion::ctrGuardarCalidadEsperada($datos);
        echo json_encode($respuesta);
    }
    public function guardarCalidadObservada()
    {
        $datos = $this->datos;
        $respuesta = ControladorGestionPriorizacion::ctrGuardarCalidadObservada($datos);
        echo json_encode($respuesta);
    }
    public function listaCalidadEsperada($idPrio)
    {
        $respuesta = ControladorGestionPriorizacion::ctrListaCalidadEsperada($idPrio);
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
    public function obtenerValorEvaluacionCuantitativa($idPrio)
    {
        $respuesta = ControladorGestionPriorizacion::ctrObtenerValorEvaluacionCuantitativa($idPrio);
        echo json_encode($respuesta);
    }
    public function verCalidadObservada($idCalidadEsperada)
    {
        $fila = ControladorGestionPriorizacion::ctrVerCalidadObservada($idCalidadEsperada);
        echo json_encode($fila);
    }
    public function eliminarCalidadEsperada($idCalidad, $user)
    {
        $respuesta = ControladorGestionPriorizacion::ctrEliminarCalidadEsperada($idCalidad, $user);
        echo json_encode($respuesta);
    }
    public function eliminarCalidadObservada($idCalidadObs, $user)
    {
        $respuesta = ControladorGestionPriorizacion::ctrEliminarCalidadObservada($idCalidadObs, $user);
        echo json_encode($respuesta);
    }
    public function obtenerInfoGeneralPriorizacion($idPrio)
    {
        $respuesta = ControladorGestionPriorizacion::ctrObtenerInfoGeneralPriorizacion($idPrio);
        echo json_encode($respuesta);
    }
    public function verificarCalidadObservadaExiste($idPrio)
    {
        $respuesta = ControladorGestionPriorizacion::ctrVerificarCalidadObservadaExiste($idPrio);
        echo json_encode($respuesta);
    }
    public function listaCalidadObservada($idPrio)
    {
        $respuesta = ControladorGestionPriorizacion::ctrListaCalidadObservada($idPrio);
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
    public function listaSedesPriorizacion($idPrio)
    {
        $respuesta = ControladorGestionPriorizacion::ctrListaSedesPorPriorizacion($idPrio);
        echo json_encode($respuesta);
    }
    public function listaAccionesMejora($idCalidadObservada)
    {
        $respuesta = ControladorGestionPriorizacion::ctrListaAccionesMejora($idCalidadObservada);
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
    public function guardarAccionMejora()
    {
        $datos = $this->datos;
        $respuesta = ControladorGestionPriorizacion::ctrGuardarAccionMejora($datos);
        echo json_encode($respuesta);
    }
    public function verAccionMejora($idAccionMejora)
    {
        $fila = ControladorGestionPriorizacion::ctrVerAccionMejora($idAccionMejora);
        echo json_encode($fila);
    }
    public function eliminarAccionMejora($idAccionMejora, $user)
    {
        $respuesta = ControladorGestionPriorizacion::ctrEliminarAccionMejora($idAccionMejora, $user);
        echo json_encode($respuesta);
    }

    public function verificarAccionMejoraExiste($idPrio)
    {
        $total = ControladorGestionPriorizacion::ctrVerificarAccionMejoraExiste($idPrio);
        echo json_encode(['total' => $total]);
    }
    public function listaAccionesMejoraPriorizacion($idPrio)
    {
        $data = ControladorGestionPriorizacion::ctrListaAccionesPorPriorizacion($idPrio);
        echo json_encode(["data" => $data]);
    }
    public function listaEvaluaciones($idAccion)
    {
        $data = ControladorGestionPriorizacion::ctrListaEvaluaciones($idAccion);
        echo json_encode(["data" => $data]);
    }
    public function guardarEvaluacion()
    {
        $respuesta = ControladorGestionPriorizacion::ctrGuardarEvaluacion($this->datos);
        echo json_encode($respuesta);
    }
    public function verEvaluacion($idEval)
    {
        $respuesta = ControladorGestionPriorizacion::ctrVerEvaluacion($idEval);
        echo json_encode($respuesta);
    }
    public function eliminarEvaluacion($idEval, $user)
    {
        $respuesta =  ControladorGestionPriorizacion::ctrEliminarEvaluacion($idEval, $user);
        echo json_encode($respuesta);
    }
    public function cargarSelectIndicador($idPrio)
    {
        $resultado = ControladorGestionPriorizacion::ctrCargarSelectIndicador($idPrio);
        $cadena = '';
        $cadena .= '<option value="">Seleccione una opcion</option>';
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["id_calidad_esperada"] . '">' . $value["nombre_indicador"] . '</option>';
        }
        echo $cadena;
    }
    public function listaAprendizajeOrg($idPrio)
    {
        $respuesta = ControladorGestionPriorizacion::ctrListarAprendizajeOrg($idPrio);
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

    public function verAprendizajeOrg($id, $indicador)
    {
        $respuesta = ControladorGestionPriorizacion::ctrVerAprendizajeOrg($id, $indicador);
        echo json_encode($respuesta);
    }

    public function verAprendizajeOrgById($id)
    {
        $respuesta = ControladorGestionPriorizacion::ctrAprendizajeOrgById($id);
        echo json_encode($respuesta);
    }


    public function guardarAprendizajeOrg()
    {
        $datos = $this->datos;
        $respuesta = ControladorGestionPriorizacion::ctrGuardarAprendizajeOrg($datos);
        echo json_encode($respuesta);
    }

    public function eliminarAprendizajeOrg($id, $user)
    {
        $respuesta = ControladorGestionPriorizacion::ctrEliminarAprendizajeOrg($id, $user);
        echo json_encode($respuesta);
    }
    public function listarAprendizajeOrgGeneral()
    {
        $respuesta = ControladorGestionPriorizacion::ctrListarAprendizajeOrgGeneral();
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

    public function listaGestionPamec()
    {
        $respuesta = ControladorGestionPriorizacion::ctrListaGestionPamec();
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
    public function validarAntesCerrar($idPrio)
    {
        $respuesta = ControladorGestionPriorizacion::ctrValidarAntesCerrar($idPrio);
        echo json_encode($respuesta);
    }
}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch ($proceso) {

        case 'actualizarEstadoPriorizacion':
            $actualizarEstadoPriorizacion = new gestionPriorizacionAjax();
            $actualizarEstadoPriorizacion->datos = array(
                "user" => $_POST["user"],
                "idPrio" => $_POST["idPrio"],
                "gestion" => $_POST["gestion"]
            );
            $actualizarEstadoPriorizacion->actualizarEstadoPriorizacion();
            break;
        case 'listaCalidadEsperada':
            $listaCalidadEsperada = new gestionPriorizacionAjax();
            $listaCalidadEsperada->listaCalidadEsperada($_POST["idPrio"]);
            break;
        case 'guardarCalidadEsperada':
            $guardarCalidadEsperada = new gestionPriorizacionAjax();
            $guardarCalidadEsperada->datos = array(
                "metaAutoevaluacion" => $_POST["metaAutoevaluacion"],
                "nombreIndicador" => mb_strtoupper($_POST["nombreIndicador"]),
                "metaIndicador" => mb_strtoupper($_POST["metaIndicador"]),
                "user" => $_POST["user"],
                "idPrio" => $_POST["idPrio"]
            );
            $guardarCalidadEsperada->guardarCalidadEsperada();
            break;
        case 'obtenerValorEvaluacionCuantitativa':
            $obtenerValorEvaluacionCuantitativa = new gestionPriorizacionAjax();
            $obtenerValorEvaluacionCuantitativa->obtenerValorEvaluacionCuantitativa($_POST["idPrio"]);
            break;
        case 'guardarCalidadObservada':
            $guardarCalidadObservada = new gestionPriorizacionAjax();
            $guardarCalidadObservada->datos = array(
                "idCalidadEsperadaObs" => mb_strtoupper($_POST["idCalidadEsperadaObs"]),
                "resultadoAutoeval" => $_POST["resultadoAutoeval"],
                "resultadoIndicador" => mb_strtoupper($_POST["resultadoIndicador"]),
                "obsCalidadObservada" => mb_strtoupper($_POST["obsCalidadObservada"]),
                "user" => $_POST["user"],
            );
            $guardarCalidadObservada->guardarCalidadObservada();
            break;
        case 'verCalidadObservada':
            $verCalidadObservada = new gestionPriorizacionAjax();
            $verCalidadObservada->verCalidadObservada($_POST["idCalidadEsperadaObs"]);
            break;
        case 'eliminarCalidadEsperada':
            $eliminarCalidadEsperada = new gestionPriorizacionAjax();
            $eliminarCalidadEsperada->eliminarCalidadEsperada($_POST["idCalidad"], $_POST["user"]);
            break;

        case 'eliminarCalidadObservada':
            $eliminarCalidadObservada = new gestionPriorizacionAjax();
            $eliminarCalidadObservada->eliminarCalidadObservada($_POST["idCalidadObservada"], $_POST["user"]);
            break;
        case 'obtenerInfoGeneralPriorizacion':
            $obtenerInfoGeneralPriorizacion = new gestionPriorizacionAjax();
            $obtenerInfoGeneralPriorizacion->obtenerInfoGeneralPriorizacion($_POST['idPrio']);
            break;

        case 'verificarCalidadObservadaExiste':
            $verificarCalidadObservadaExiste = new gestionPriorizacionAjax();
            $verificarCalidadObservadaExiste->verificarCalidadObservadaExiste($_POST['idPrio']);
            break;
        case 'listaCalidadObservada':
            $listaObs = new gestionPriorizacionAjax();
            $listaObs->listaCalidadObservada($_POST["idPrio"]);
            break;
        case 'listaSedesPriorizacion':
            $lista = new gestionPriorizacionAjax();
            $lista->listaSedesPriorizacion($_POST["idPrio"]);
            break;
        case 'listaAccionesMejora':
            $listaAcc = new gestionPriorizacionAjax();
            $listaAcc->listaAccionesMejora($_POST["idCalidadObservada"]);
            break;

        case 'guardarAccionMejora':
            $guardarAccionMejora = new gestionPriorizacionAjax();
            $guardarAccionMejora->datos = array(
                "idCalidadObservada"    => $_POST["idCalidadObservada"],
                "idAccionMejora"        => isset($_POST["idAccionMejora"]) ? $_POST["idAccionMejora"] : null,
                "que"                   => mb_strtoupper($_POST["que"]),
                "tipo_accion"           => mb_strtoupper($_POST["tipo_accion"]),
                "porque"                => mb_strtoupper($_POST["porque"]),
                "como"                  => mb_strtoupper($_POST["como"]),
                "donde"                 => mb_strtoupper($_POST["donde"]),
                "quien"                 => mb_strtoupper($_POST["quien"]),
                "fecha_inicio"          => $_POST["fecha_inicio"],
                "fecha_fin"             => $_POST["fecha_fin"],
                "acciones_planeadas"    => $_POST["acciones_planeadas"],
                "observaciones"         => mb_strtoupper($_POST["observaciones"]),
                "user"                  => $_POST["user"]
            );
            $guardarAccionMejora->guardarAccionMejora();
            break;

        case 'verAccionMejora':
            $verAccionMejora = new gestionPriorizacionAjax();
            $verAccionMejora->verAccionMejora($_POST["idAccionMejora"]);
            break;

        case 'eliminarAccionMejora':
            $eliminarAccionMejora = new gestionPriorizacionAjax();
            $eliminarAccionMejora->eliminarAccionMejora($_POST["idAccionMejora"], $_POST["user"]);
            break;

        case 'verificarAccionMejoraExiste':
            $verificarAccionMejoraExiste = new gestionPriorizacionAjax();
            $verificarAccionMejoraExiste->verificarAccionMejoraExiste($_POST['idPrio']);
            break;

        case 'listaAccionesMejoraPriorizacion':
            $listaAccionesMejoraPriorizacion = new gestionPriorizacionAjax();
            $listaAccionesMejoraPriorizacion->listaAccionesMejoraPriorizacion($_POST['idPrio']);
            break;

        case 'listaEvaluaciones':
            $listaEvaluaciones = new gestionPriorizacionAjax();
            $listaEvaluaciones->listaEvaluaciones($_POST['idAccionMejora']);
            break;

        case 'guardarEvaluacion':
            $guardarEvaluacion = new gestionPriorizacionAjax();
            $guardarEvaluacion->datos = array(
                "idEvaluacion"       => $_POST['idEvaluacion'],
                "idAccionMejora"     => $_POST['idAccionMejora'],
                "fecha"              => $_POST['fecha'],
                "ejecutadas"         => $_POST['ejecutadas'],
                "avance"             => $_POST['avance'],
                "estado"             => mb_strtoupper($_POST['estado']),
                "observaciones"      => mb_strtoupper($_POST['observaciones']),
                "user"               => $_POST['user']
            );
            $guardarEvaluacion->guardarEvaluacion();
            break;

        case 'verEvaluacion':
            $verEvaluacion = new gestionPriorizacionAjax();
            $verEvaluacion->verEvaluacion($_POST['idEvaluacion']);
            break;

        case 'eliminarEvaluacion':
            $eliminarEvaluacion = new gestionPriorizacionAjax();
            $eliminarEvaluacion->eliminarEvaluacion($_POST['idEvaluacion'], $_POST['user']);
            break;
        case 'cargarSelectIndicador':
            $cargarSelectIndicador = new gestionPriorizacionAjax();
            $cargarSelectIndicador->cargarSelectIndicador($_POST['idPrio']);

            break;
        case 'listarAprendizajeOrg':
            $ajax = new gestionPriorizacionAjax();
            $ajax->listaAprendizajeOrg($_POST['idPrio']);
            break;

        case 'verAprendizajeOrg':
            $ajax = new gestionPriorizacionAjax();
            $ajax->verAprendizajeOrg($_POST['idPrio'], $_POST['indicador']);
            break;

        case 'verAprendizajeOrgById':
            $ajax = new gestionPriorizacionAjax();
            $ajax->verAprendizajeOrgById($_POST['idAprendizaje']);
            break;

        case 'guardarAprendizajeOrg':
            $ajax = new gestionPriorizacionAjax();
            $ajax->datos = array(
                "idAprendizaje"               => $_POST['idAprendizaje'] ?: null,
                "idPrio"                      => $_POST['idPrio'],
                "codigoEstandar"              => $_POST['codigoEstandar'],
                "estandar"                    => $_POST['estandar'],
                "oportunidadMejora"           => $_POST['oportunidadMejora'],
                "accionesCompletas"           => $_POST['accionesCompletas'],
                "avancePorcentaje"            => $_POST['avancePorcentaje'],
                "estadoAprendizaje"           => $_POST['estadoAprendizaje'],
                "observaciones"               => mb_strtoupper($_POST['obs1']),
                "metaAutoevaluacionAp"        => $_POST['metaAutoevaluacionAp'],
                "indicadorAp"                 => $_POST['indicadorAp'],
                "metaIndicadorAP"             => $_POST['metaIndicadorAP'],
                "calObsIniAuto"               => $_POST['calObsIniAuto'],
                "calObsIniIndicador"          => $_POST['calObsIniIndicador'],
                "calObsFin"                   => $_POST['calObsFin'],
                "calObsFinIndicador"          => $_POST['calObsFinIndicador'],
                "barrerasMejora"              => mb_strtoupper($_POST['barrerasMejora']),
                "obsAprendizajeOrganizacional" => mb_strtoupper($_POST['obsAprendizajeOrganizacional']),
                "user"                        => $_POST['user']
            );
            $ajax->guardarAprendizajeOrg();
            break;

        case 'eliminarAprendizajeOrg':
            $ajax = new gestionPriorizacionAjax();
            $ajax->eliminarAprendizajeOrg($_POST['idAprendizaje'], $_POST['user']);
            break;
        case 'listarAprendizajeOrgGeneral':
            $ajax = new gestionPriorizacionAjax();
            $ajax->listarAprendizajeOrgGeneral();
            break;
        case 'listaGestionPamec':
            $listaGestionPamec = new gestionPriorizacionAjax();
            $listaGestionPamec->listaGestionPamec();
            break;
        case 'validarAntesCerrar':
            $ajax = new gestionPriorizacionAjax();
            $ajax->validarAntesCerrar($_POST['idPrio']);
            break;
    }
}

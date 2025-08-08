<?php

require_once "../../controllers/pamec/autoevaluacion.controller.php";
require_once "../../models/pamec/autoevaluacion.model.php";

class autoevaluacionAjax
{
    public $datos;

    public function guardarInfoGeneral()
    {
        $datos = $this->datos;

        $respuesta = ControladorAutoevaluacion::ctrGuardarInfoGeneral($datos);
        echo json_encode($respuesta);
    }
    public function obtenerInfoAutoevaluacion($idAutoEva)
    {
        $respuesta = ControladorAutoevaluacion::ctrObtenerInfoAutoevaluacion($idAutoEva);
        echo json_encode($respuesta);
    }

    public function listaPreguntasCualitativasAutoevaluacion()
    {

        $respuesta = ControladorAutoevaluacion::ctrListaPreguntasCualitativasAutoevaluacion();

        echo json_encode($respuesta);
    }

    public function guardarInfoCualitativa()
    {
        $datos = $this->datos;

        $respuesta = ControladorAutoevaluacion::ctrGuardarInfoCualitativa($datos);
        echo json_encode($respuesta);
    }
    public function actualizarInfoGeneralAutoevaluacion()
    {
        $datos = $this->datos;

        $respuesta = ControladorAutoevaluacion::ctrActualizarInfoGeneralAutoevaluacion($datos);
        echo json_encode($respuesta);
    }
    public function obtenerInfoCualitativaAutoevaluacion($idAutoEva)
    {
        $respuesta = ControladorAutoevaluacion::ctrObtenerInfoCualitativaAutoevaluacion($idAutoEva);
        echo json_encode($respuesta);
    }
    public function actualizarInfoCualitativa()
    {
        $datos = $this->datos;

        $respuesta = ControladorAutoevaluacion::ctrActualizarInfoCualitativa($datos);
        echo json_encode($respuesta);
    }

    public function listaDimensionesCuantitativaAutoevaluacion()
    {
        $respuesta = ControladorAutoevaluacion::ctrListaDimensionesCuantitativaAutoevaluacion();
        echo json_encode($respuesta);
    }

    public function listaVariablesDimension($dimension)
    {
        $respuesta = ControladorAutoevaluacion::ctrListaVariablesDimension($dimension);
        echo json_encode($respuesta);
    }

    public function listaRespuestasVariables($dimension, $variable)
    {
        $respuesta = ControladorAutoevaluacion::ctrListaRespuestasVariables($dimension, $variable);
        echo json_encode($respuesta);
    }
    public function guardarInfoCuantitativa()
    {
        $datos = $this->datos;

        $respuesta = ControladorAutoevaluacion::ctrGuardarInfoCuantitativa($datos);
        echo json_encode($respuesta);
    }
    public function obtenerInfoCuantitativaAutoevaluacion($idAutoEva)
    {
        $respuesta = ControladorAutoevaluacion::ctrObtenerInfoCuantitativaAutoevaluacion($idAutoEva);
        echo json_encode($respuesta);
    }
    public function actualizarInfoCuantitativa()
    {
        $datos = $this->datos;

        $respuesta = ControladorAutoevaluacion::ctrActualizarInfoCuantitativa($datos);
        echo json_encode($respuesta);
    }
    public function guardarInfoPriorizacion()
    {
        $datos = $this->datos;

        $respuesta = ControladorAutoevaluacion::ctrGuardarInfoPriorizacion($datos);
        echo json_encode($respuesta);
    }
    public function listaPriorizacionesAutoevaluacion($idAutoEva)
    {
        $respuesta = ControladorAutoevaluacion::ctrListaPriorizacionesAutoevaluacion($idAutoEva);
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
    public function eliminarPriorizacionAutoEvaluacion($id_respuesta_priorizacion, $user)
    {

        $respuesta = ControladorAutoevaluacion::ctrEliminarPriorizacionAutoEvaluacion($id_respuesta_priorizacion, $user);
        echo json_encode($respuesta);
    }
    public function listarOpcionesRespPriorizacion()
    {
        $respuesta = ControladorAutoevaluacion::ctrListarOpcionesRespPriorizacion();
        echo json_encode($respuesta);
    }
    public function terminarGestionAutoevaluacion()
    {
        $datos = $this->datos;

        $respuesta = ControladorAutoevaluacion::ctrTerminarGestionAutoevaluacion($datos);
        echo json_encode($respuesta);
    }
    public function listaMisAutoevaluaciones($user)
    {
        $respuesta = ControladorAutoevaluacion::ctrListaMisAutoevaluaciones($user);
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
    public function listaAutoevaluacionesVerEvaluador()
    {
        $respuesta = ControladorAutoevaluacion::ctrListaAutoevaluacionesVerEvaluador();
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

    public function cargarArchivosEvidenciaAutoevaluacion()
    {

        $datos = $this->datos;

        $respuesta = ControladorAutoevaluacion::ctrCargarArchivosEvidenciaAutoevaluacion($datos);

        echo $respuesta;
    }

    public function infoAutoevaluacionArchivos($idAutoEva)
    {
        $respuesta = ControladorAutoevaluacion::ctrInfoAutoevaluacionArchivos($idAutoEva);
        echo json_encode($respuesta);
    }

    public function eliminarArchivoEvidencia()
    {
        $datos = $this->datos;
        $respuesta = ControladorAutoevaluacion::ctrEliminarArchivoEvidencia($datos);
        echo $respuesta;
    }

    public function verificarPeriodosCreacion()
    {
        $respuesta = ControladorAutoevaluacion::ctrVerificarPeriodosCreacion();
        echo json_encode($respuesta);
    }

    public function guardarPeriodoAutoevaluaciones()
    {
        $datos = $this->datos;
        $respuesta = ControladorAutoevaluacion::ctrGuardarPeriodoAutoevaluacion($datos);
        echo json_encode($respuesta);
    }

    public function listaPeriodosAutoevaluacionPamec()
    {
        $respuesta = ControladorAutoevaluacion::ctrListaPeriodosAutoevaluacionPamec();
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

    public function periodoAutoevaluacionActivo()
    {
        $respuesta = ControladorAutoevaluacion::ctrPeriodoAutoevaluacionActivo();
        echo json_encode($respuesta);
    }

    public function sedesNoEvaluadasPorEstandar($codigo, $periodo)
    {
        $respuesta = ControladorAutoevaluacion::ctrSedesNoEvaluadasPorEstandar($codigo, $periodo);
        echo json_encode($respuesta);
    }

    public function programasNoEvaluadosPorEstandar($codigo, $periodo)
    {
        $respuesta = ControladorAutoevaluacion::ctrProgramasNoEvaluadosPorEstandar($codigo, $periodo);
        echo json_encode($respuesta);
    }

    public function consultarAutoevaluaciones()
    {

        $datos = $this->datos;

        $respuesta = ControladorAutoevaluacion::ctrConsultarAutoevaluaciones($datos);

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
    public function guardarNoAplicaAutoevaluacion($idAutoeva, $user)
    {
        $respuesta = ControladorAutoevaluacion::ctrGuardarNoAplicaAutoevaluacion($idAutoeva, $user);
        echo json_encode($respuesta);
    }
    public function listaPriorizacionesGeneral()
    {
        $respuesta = ControladorAutoevaluacion::ctrListaPriorizacionesGeneral();
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

    switch ($proceso) {
        case 'eliminarArchivoEvidencia':
            $eliminarArchivoEvidencia = new autoevaluacionAjax();
            $eliminarArchivoEvidencia->datos = array(
                "ruta_archivo" => $_POST["rutaArchivo"],
                "archivo" => $_POST["archivo"],
                "id_autoevaluacion" => $_POST["idAutoEva"],
                "usuario_elimina" => $_POST["user"]
            );
            $eliminarArchivoEvidencia->eliminarArchivoEvidencia();
            break;

        case 'infoAutoevaluacionArchivos':
            $info = new autoevaluacionAjax();
            $info->infoAutoevaluacionArchivos($_POST["idAutoEva"]);
            break;

        case 'cargarArchivosEvidenciaAutoevaluacion':
            $cargarArchivosEvidenciaAutoevaluacion = new autoevaluacionAjax();
            if (isset($_FILES["archivoEvidencia"])) {
                $archivoEvidencia = $_FILES["archivoEvidencia"];
            } else {
                $archivoEvidencia = 'VACIO';
            }
            $cargarArchivosEvidenciaAutoevaluacion->datos = array(
                "archivoEvidencia" => $archivoEvidencia,
                "idAutoEva" => $_POST["idAutoEva"],
                "user" => $_POST["user"],
            );
            $cargarArchivosEvidenciaAutoevaluacion->cargarArchivosEvidenciaAutoevaluacion();
            break;
        case 'listaAutoevaluacionesVerEvaluador':
            $listaAutoevaluacionesVerEvaluador = new autoevaluacionAjax();
            $listaAutoevaluacionesVerEvaluador->listaAutoevaluacionesVerEvaluador();
            break;
        case 'listaMisAutoevaluaciones':
            $listaMisAutoevaluaciones = new autoevaluacionAjax();
            $listaMisAutoevaluaciones->listaMisAutoevaluaciones($_POST["user"]);
            break;
        case 'terminarGestionAutoevaluacion':
            $terminarGestionAutoevaluacion = new autoevaluacionAjax();
            $terminarGestionAutoevaluacion->datos = array(
                "idAutoeva" => $_POST["idAutoeva"],
                "user" => $_POST["user"]
            );
            $terminarGestionAutoevaluacion->terminarGestionAutoevaluacion();
            break;
        case 'listarOpcionesRespPriorizacion':
            $listarOpcionesRespPriorizacion = new autoevaluacionAjax();
            $listarOpcionesRespPriorizacion->listarOpcionesRespPriorizacion();
            break;
        case 'eliminarPriorizacionAutoEvaluacion':
            $eliminarPriorizacionAutoEvaluacion = new autoevaluacionAjax();
            $eliminarPriorizacionAutoEvaluacion->eliminarPriorizacionAutoEvaluacion($_POST["id_respuesta_priorizacion"], $_POST["user"]);
            break;
        case 'listaPriorizacionesAutoevaluacion':
            $listaPriorizacionesAutoevaluacion = new autoevaluacionAjax();
            $listaPriorizacionesAutoevaluacion->listaPriorizacionesAutoevaluacion($_POST["idAutoeva"]);
            break;
        case 'guardarInfoPriorizacion':
            $guardarInfoPriorizacion = new autoevaluacionAjax();
            $guardarInfoPriorizacion->datos = array(
                "grupo" => $_POST["grupo"],
                "estandar" => $_POST["estandar"],
                "sedes" => $_POST["sedes"],
                "variable3" => $_POST["variable3"],
                "variable5" => $_POST["variable5"],
                "selRiesgoPrio" => $_POST["selRiesgoPrio"],
                "selCostoPriorizacion" => $_POST["selCostoPriorizacion"],
                "selVolumenPriorizacion" => $_POST["selVolumenPriorizacion"],
                "NEPriorizacion" => $_POST["NEPriorizacion"],
                "idAutoEva" => $_POST["idAutoEva"],
                "usuario" => $_POST["user"],
            );

            $guardarInfoPriorizacion->guardarInfoPriorizacion();
            break;
        case 'actualizarInfoCuantitativa':
            $actualizarInfoCuantitativa = new autoevaluacionAjax();
            $respuestas = json_decode($_POST["respuestasCuantitativas"], true);
            $actualizarInfoCuantitativa->datos = array(
                "idAutoEva" => $_POST["idAutoEva"],
                "usuario" => $_POST["user"],
                "listaRespuestas" => $respuestas
            );

            $actualizarInfoCuantitativa->actualizarInfoCuantitativa();
            break;
        case 'obtenerInfoCuantitativaAutoevaluacion':
            $obtenerInfoCuantitativaAutoevaluacion = new autoevaluacionAjax();
            $obtenerInfoCuantitativaAutoevaluacion->obtenerInfoCuantitativaAutoevaluacion($_POST["idAutoEva"]);
            break;
        case 'guardarInfoCuantitativa':
            $guardarInfoCuantitativa = new autoevaluacionAjax();
            $respuestas = json_decode($_POST["respuestasCuantitativas"], true);
            $guardarInfoCuantitativa->datos = array(
                "idAutoEva" => $_POST["idAutoEva"],
                "usuario" => $_POST["user"],
                "listaRespuestas" => $respuestas
            );

            $guardarInfoCuantitativa->guardarInfoCuantitativa();
            break;
        case 'listaRespuestasVariables':
            $listaRespuestasVariables = new autoevaluacionAjax();
            $listaRespuestasVariables->listaRespuestasVariables($_POST["dimension"], $_POST["variable"]);
            break;
        case 'listaVariablesDimension':
            $listaVariablesDimension = new autoevaluacionAjax();
            $listaVariablesDimension->listaVariablesDimension($_POST["dimension"]);
            break;
        case 'listaDimensionesCuantitativaAutoevaluacion':
            $listaDimensionesCuantitativaAutoevaluacion = new autoevaluacionAjax();
            $listaDimensionesCuantitativaAutoevaluacion->listaDimensionesCuantitativaAutoevaluacion();
            break;
        case 'actualizarInfoCualitativa':
            $actualizarInfoCualitativa = new autoevaluacionAjax();
            $respuestas = json_decode($_POST["respuestasCualitativas"], true);
            $actualizarInfoCualitativa->datos = array(
                "idAutoEva" => $_POST["idAutoEva"],
                "usuario" => $_POST["user"],
                "listaRespuestas" => $respuestas
            );

            $actualizarInfoCualitativa->actualizarInfoCualitativa();
            break;

        case 'obtenerInfoCualitativaAutoevaluacion':
            $obtenerInfoCualitativaAutoevaluacion = new autoevaluacionAjax();
            $obtenerInfoCualitativaAutoevaluacion->obtenerInfoCualitativaAutoevaluacion($_POST["idAutoEva"]);
            break;
        case 'actualizarInfoGeneralAutoevaluacion':
            $actualizarInfoGeneralAutoevaluacion = new autoevaluacionAjax();
            $actualizarInfoGeneralAutoevaluacion->datos = array(
                "grupo" => $_POST["grupo"],
                "subGrupo" => $_POST["subGrupo"],
                "estandar" => $_POST["estandar"],
                // "resolucion" => $_POST["resolucion"],
                "procesoForm" => $_POST["procesoForm"],
                "autoevaluacion" => $_POST["periodoAutoevaluacion"],
                "sede" => $_POST["selSedesPamec"],
                "programa" => $_POST["selProgramasPamec"],
                "usuario" => $_POST["user"],
                "idAutoevaluacion" => $_POST["idAutoevaluacion"],

            );

            $actualizarInfoGeneralAutoevaluacion->actualizarInfoGeneralAutoevaluacion();
            break;
        case 'guardarInfoCualitativa':
            $guardarInfoCualitativa = new autoevaluacionAjax();
            $respuestas = json_decode($_POST["respuestasCualitativas"], true);
            $guardarInfoCualitativa->datos = array(
                "idAutoEva" => $_POST["idAutoEva"],
                "usuario" => $_POST["user"],
                "listaRespuestas" => $respuestas
            );

            $guardarInfoCualitativa->guardarInfoCualitativa();
            break;
        case 'listaPreguntasCualitativasAutoevaluacion':
            $listaPreguntasCualitativasAutoevaluacion = new autoevaluacionAjax();
            $listaPreguntasCualitativasAutoevaluacion->listaPreguntasCualitativasAutoevaluacion();
            break;
        case 'obtenerInfoAutoevaluacion':
            $obtenerInfoAutoevaluacion = new autoevaluacionAjax();
            $obtenerInfoAutoevaluacion->obtenerInfoAutoevaluacion($_POST["idAutoEva"]);
            break;
        case 'guardarInfoGeneralAutoevaluacion':
            $guardarInfoGeneral = new autoevaluacionAjax();
            $guardarInfoGeneral->datos = array(
                "grupo" => $_POST["grupo"],
                "subGrupo" => $_POST["subGrupo"],
                "estandar" => $_POST["estandar"],
                // "resolucion" => $_POST["resolucion"],
                "procesoForm" => $_POST["procesoForm"],
                "autoevaluacion" => $_POST["periodoAutoevaluacion"],
                "sede" => $_POST["selSedesPamec"],
                "programa" => $_POST["selProgramasPamec"],
                "usuario" => $_POST["user"],
            );

            $guardarInfoGeneral->guardarInfoGeneral();
            break;

        case 'verificarPeriodosCreacion':
            $verificarPeriodosCreacion = new autoevaluacionAjax();
            $verificarPeriodosCreacion->verificarPeriodosCreacion();
            break;

        case 'guardarPeriodoAutoevaluaciones':
            $guardarPeriodoAutoevaluaciones = new autoevaluacionAjax();
            $guardarPeriodoAutoevaluaciones->datos = array(
                "user" => $_POST["user"],
                "periodo" => $_POST["periodo"],
                "usuario" => $_POST["user"],
            );

            $guardarPeriodoAutoevaluaciones->guardarPeriodoAutoevaluaciones();
            break;

        case 'listaPeriodosAutoevaluacionPamec':
            $listaPeriodosAutoevaluacionPamec = new autoevaluacionAjax();
            $listaPeriodosAutoevaluacionPamec->listaPeriodosAutoevaluacionPamec();
            break;

        case 'periodoAutoevaluacionActivo':
            $periodoAutoevaluacionActivo = new autoevaluacionAjax();
            $periodoAutoevaluacionActivo->periodoAutoevaluacionActivo();
            break;

        case 'sedesNoEvaluadasPorEstandar':
            $ajax = new autoevaluacionAjax();
            $ajax->sedesNoEvaluadasPorEstandar($_POST["codigo"], $_POST["periodo"]);
            break;

        case 'programasNoEvaluadosPorEstandar':
            $ajax = new autoevaluacionAjax();
            $ajax->programasNoEvaluadosPorEstandar($_POST["codigo"], $_POST["periodo"]);
            break;

        case 'consultarAutoevaluaciones':
            $consultarAutoevaluaciones = new autoevaluacionAjax();
            $consultarAutoevaluaciones->datos = array(
                "selectPeriodoAutoevaluacion" => $_POST["selectPeriodoAutoevaluacion"],
                "grupo" => $_POST["grupo"],
                "subGrupo" => $_POST["subGrupo"],
                "estandar" => $_POST["estandar"],
                "selSedesPamec" => $_POST["selSedesPamec"],
            );
            $consultarAutoevaluaciones->consultarAutoevaluaciones();
            break;
        case 'guardarNoAplicaAutoevaluacion':
            $guardarNoAplicaAutoevaluacion = new autoevaluacionAjax();
            $guardarNoAplicaAutoevaluacion->guardarNoAplicaAutoevaluacion($_POST["idAutoeva"], $_POST["user"]);
            break;
        case 'listaPriorizacionesGeneral':
            $listaPriorizacionesGeneral = new autoevaluacionAjax();
            $listaPriorizacionesGeneral->listaPriorizacionesGeneral();
            break;
    }
}

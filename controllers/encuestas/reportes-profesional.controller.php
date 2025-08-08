<?php

require_once "../../plugins/Spout/src/Spout/Autoloader/autoload.php";

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Type;


class ControladorEncuestasReportesProfesional{

    static public function ctrPreguntasSegmentoIntrumentoProfesional($idBaseEncuesta, $idEncuSegmento, $profesional){

        $respuesta = ModelEncuestasReportesProfesional::mdlPreguntasSegmentoIntrumentoProfesional($idBaseEncuesta, $idEncuSegmento, $profesional);

        return $respuesta;

    }

    static public function ctrSegmentosOtraEspecialidadProfesional($idBaseEncuesta, $idProceso, $profesional){

        $respuesta = ModelEncuestasReportesProfesional::mdlSegmentosOtraEspecialidadProfesional($idBaseEncuesta, $idProceso, $profesional);

        return $respuesta;

    }

    static public function ctrInfoReporteEspecidalidadProfesionalPro($idBaseEncuesta, $programa, $especialidad, $tipo, $profesional){

        $respuesta = ModelEncuestasReportesProfesional::ctrInfoReporteEspecidalidadProfesionalPro($idBaseEncuesta, $programa, $especialidad, $tipo, $profesional);

        return $respuesta;

    }

    static public function ctrListaProfesionalesIdBaseEncuesta($idBaseEncuesta){

        $respuesta = ModelEncuestasReportesProfesional::mdlListaProfesionalesIdBaseEncuesta($idBaseEncuesta);

        return $respuesta;

    }

    static public function ctrInfoResultadoAuditoriaProfesional($idBaseEncuesta){

        $infoBase = ControladorEncuestasReportesProfesional::ctrObtenerDatos("encuestas_bases_encuestas_profesional", "id_base_encuesta", $idBaseEncuesta);

        $infoProceso = ControladorEncuestasReportesProfesional::ctrObtenerInfoProceso($infoBase["especialidad"]);

        $respuesta = ModelEncuestasReportesProfesional::mdlInfoResultadoAuditoriaProfesional($idBaseEncuesta, $infoProceso["id_encu_proceso"]);

        return $respuesta;

    }

    static public function ctrObtenerInfoProceso($especialidad){

        $respuesta = ModelEncuestasReportesProfesional::mdlObtenerInfoProceso($especialidad);

        return $respuesta;

    }

    static public function ctrlistaBasesProfesionales(){

        $respuesta = ModelEncuestasReportesProfesional::mdllistaBasesProfesionales();

        return $respuesta;

    }

    static public function ctrPreguntasSegmentoIntrumento($idBaseEncuesta, $idEncuSegmento){

        $respuesta = ModelEncuestasReportesProfesional::mdlPreguntasSegmentoIntrumento($idBaseEncuesta, $idEncuSegmento);

        return $respuesta;

    }

    static public function ctrSegmentosOtraEspecialidad($idBaseEncuesta, $idProceso){

        $respuesta = ModelEncuestasReportesProfesional::mdlSegmentosOtraEspecialidad($idBaseEncuesta, $idProceso);

        return $respuesta;

    }

    static public function ctrListaBasesEncuestasEspecialidadIdProceso($idProceso){

        $especialidad = ControladorEncuestasReportesProfesional::ctrObtenerDatos("encuestas_procesos_profesional","id_encu_proceso",$idProceso);

        $tabla = "encuestas_bases_encuestas_profesional";

        $respuesta = ModelEncuestasReportesProfesional::mdlListaBasesEncuestasEspecialidad($tabla, $especialidad["especialidad"]);

        return $respuesta;

    }

    static public function ctrlistaOtrasEspecialistas(){

        $respuesta = ModelEncuestasReportesProfesional::mdllistaOtrasEspecialistas();

        return $respuesta;

    }

    static public function ctrInfoReporteEspecidalidadProfesional($idBaseEncuesta, $programa, $especialidad, $tipo){

        $respuesta = ModelEncuestasReportesProfesional::ctrInfoReporteEspecidalidadProfesional($idBaseEncuesta, $programa, $especialidad, $tipo);

        return $respuesta;

    }

    static public function ctrListaBasesEncuestasEspecialidad($especialidad){

        $tabla = "encuestas_bases_encuestas_profesional";

        $respuesta = ModelEncuestasReportesProfesional::mdlListaBasesEncuestasEspecialidad($tabla, $especialidad);

        return $respuesta;

    }

    static public function ctrListaEspecialidadProfesional($programa){

        $tabla = "encuestas_procesos_profesional";

        $respuesta = ModelEncuestasReportesProfesional::mdlListaEspecialidadProfesional($tabla, $programa);

        return $respuesta;

    }

    static public function ctrListaReportesEncuestasProfesional(){

        $tabla = "encuestas_reportes_profesional";

        $respuesta = ModelEncuestasReportesProfesional::mdlListaReportesEncuestasProfesional($tabla);

        return $respuesta;

    }

    static public function ctrObtenerDatos($tabla, $item, $valor){

        $respuesta = ModelEncuestasReportesProfesional::mdlObtenerDatos($tabla, $item, $valor);

        return $respuesta;
    }


}
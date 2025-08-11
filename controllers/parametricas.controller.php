<?php

class ControladorParametricas
{

    static public function ctrObtenerTiposActivosInventario($categoriaActivoFijo){

        $respuesta = ModelParametricas::mdlObtenerTiposActivosInventario($categoriaActivoFijo);

        return $respuesta;

    }


    static public function ctrListaAuditoresAudProfesional(){

        $respuesta = ModelParametricas::mdlListaAuditoresAudProfesional();

        return $respuesta;

    }

    static public function ctrListaManualesProyecto($proyecto){

        $rutaManuales = "../../archivos_nexuslink/recursos/manuales/{$proyecto}/";
        $files = [];

        if (is_dir($rutaManuales)) {

            $scanned_files = scandir($rutaManuales);

            // Filtrar archivos y omitir '.' y '..'
            foreach ($scanned_files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $files[] = $file;
                }
            }

            $respuesta["archivosManuales"] = $files;
        } else {

            $respuesta["archivosManuales"] = "SIN MANUALES";
        }

        return array(
            "ruta" => $rutaManuales,
            "archivos" => $respuesta["archivosManuales"]
        );
    }


    static public function ctrObtenerEpsSedePqrsf($sede)
    {

        $respuesta = ModelParametricas::mdlObtenerEpsSedePqrsf($sede);

        return $respuesta;
    }

    static public function ctrObtenerListaResponsablesProyectosCorrespondencia()
    {

        $respuesta = ModelParametricas::mdlObtenerListaResponsablesProyectosCorrespondencia();

        return $respuesta;
    }


    static public function ctrObtenerSedesEpsPqrsf($eps)
    {

        $respuesta = ModelParametricas::mdlObtenerSedesEpsPqrsf($eps);

        return $respuesta;
    }

    static public function ctrObtenerClasiAtributos()
    {

        $respuesta = ModelParametricas::mdlObtenerClasiAtributos();

        return $respuesta;
    }

    static public function ctrObtenerEpsSede($sede)
    {

        $respuesta = ModelParametricas::mdlObtenerEpsSede($sede);

        return $respuesta;
    }

    static public function ctrVerDatoParametrica($parametrica, $dato)
    {

        $respuesta = ModelParametricas::mdlVerDatoParametrica($parametrica, $dato);

        return $respuesta;
    }

    static public function ctrObtenerDatosActivosAll($tabla, $item, $valor)
    {

        $respuesta = ModelParametricas::mdlObtenerDatosActivosAll($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ctrObtenerDatosActivos($tabla, $item, $valor)
    {

        $respuesta = ModelParametricas::mdlObtenerDatosActivos($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ctrObtenerDepartamentos($tabla)
    {

        $respuesta = ModelParametricas::mdlObtenerDepartamentos($tabla);

        return $respuesta;
    }

    static public function ctrObtenerCiudadesDepartamento($tabla, $departamento)
    {

        $respuesta = ModelParametricas::mdlObtenerCiudadesDepartamento($tabla, $departamento);

        return $respuesta;
    }

    static public function ctrListaGrupoEstandaresAutoevaluacion($tabla)
    {

        $respuesta = ModelParametricas::mdlListaGrupoEstandaresAutoevaluacion($tabla);

        return $respuesta;
    }

    static public function ctrListaSubGrupoEstandaresAutoevaluacion($tabla, $grupo)
    {

        $respuesta = ModelParametricas::mdlListaSubGrupoEstandaresAutoevaluacion($tabla, $grupo);

        return $respuesta;
    }
    static public function ctrListaEstandaresAutoevaluacion($tabla, $grupo, $subGrupo)
    {

        $respuesta = ModelParametricas::mdlListaEstandaresAutoevaluacion($tabla, $grupo, $subGrupo);

        return $respuesta;
    }

    static public function ctrListaResolucionEstandaresAutoevaluacion($tabla)
    {

        $respuesta = ModelParametricas::mdlListaResolucionEstandaresAutoevaluacion($tabla);

        return $respuesta;
    }

    static public function ctrListaProcesoEstandaresAutoevaluacion($tabla)
    {

        $respuesta = ModelParametricas::mdlListaProcesoEstandaresAutoevaluacion($tabla);

        return $respuesta;
    }

    static public function ctrListaSedesPamec($tabla)
    {

        $respuesta = ModelParametricas::mdlListaSedesPamec($tabla);

        return $respuesta;
    }

    static public function ctrListaProgramasPamec($tabla)
    {

        $respuesta = ModelParametricas::mdlListaProgramasPamec($tabla);

        return $respuesta;
    }

    static public function ctrListaEstandaresPamecPriorizacionAutoevaluacion($tabla, $grupo)
    {
        $respuesta = ModelParametricas::mdlListaEstandaresPamecPriorizacionAutoevaluacion($tabla, $grupo);

        return $respuesta;
    }
  
    static public function ctrListaVariablesPriorizacionAutoevaluacion($tabla,$tipoVariable)
    {

        $respuesta = ModelParametricas::mdlListaVariablesPriorizacionAutoevaluacion($tabla,$tipoVariable);

        return $respuesta;
    }
  
    static public function ctrObtenerCriteriosEstandar($estandar) {
        $respuesta = ModelParametricas::mdlObtenerCriteriosEstandar($estandar);
        return $respuesta;
    }

    static public function ctrListarPamecParEstandar($tabla,$select)
    {

        $respuesta = ModelParametricas::mdlListarPamecParEstandar($tabla,$select);

        return $respuesta;
    }

    static public function ctrListaPeriodosConsultaAutoevaluacion($tabla)
    {

        $respuesta = ModelParametricas::mdlListaPeriodosConsultaAutoevaluacion($tabla);

        return $respuesta;
    }

    static public function ctrListaPeriodosPamecReporteAvance($tabla)
    {

        $respuesta = ModelParametricas::mdlListaPeriodosPamecReporteAvance($tabla);

        return $respuesta;
    }
}

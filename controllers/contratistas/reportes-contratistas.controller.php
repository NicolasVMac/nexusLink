<?php

class ControladorReportesContratistas{

    static public function ctrListaEstadoPolizas($tipo){

        $respuesta = ModelReportesContratistas::mdlListaEstadoPolizas($tipo);

        return $respuesta;

    }

    static public function ctrListaEstadoContratos($tipo){

        $respuesta = ModelReportesContratistas::mdlListaEstadoContratos($tipo);

        return $respuesta;

    }

    static public function ctrEstadoProcesoPolizas(){

        $respuesta = ModelReportesContratistas::mdlEstadoProcesoPolizas();
        
        return $respuesta;

    }

    static public function ctrEstadoProcesoContratos(){

        $respuesta = ModelReportesContratistas::mdlEstadoProcesoContratos();

        return $respuesta;

    }

    static public function ctrListaReportesContratistas(){

        $tabla = "contratistas_contratista_reportes";

        $respuesta = ModelReportesContratistas::mdlListaReportesContratistas($tabla);

        return $respuesta;

    }

}
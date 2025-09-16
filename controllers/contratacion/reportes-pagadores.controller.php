<?php

class ControladorReportesPagadores{

    static public function ctrListaEstadoPolizas($tipo){

        $respuesta = ModelReportesPagadores::mdlListaEstadoPolizas($tipo);

        return $respuesta;

    }

    static public function ctrListaEstadoContratos($tipo){

        $respuesta = ModelReportesPagadores::mdlListaEstadoContratos($tipo);

        return $respuesta;

    }

    static public function ctrEstadoProcesoPolizas(){

        $respuesta = ModelReportesPagadores::mdlEstadoProcesoPolizas();
        
        return $respuesta;

    }

    static public function ctrEstadoProcesoContratos(){

        $respuesta = ModelReportesPagadores::mdlEstadoProcesoContratos();

        return $respuesta;

    }

    static public function ctrListaReportesPagadores(){

        $tabla = "pagadores_pagadores_reportes";

        $respuesta = ModelReportesPagadores::mdlListaReportesPagadores($tabla);

        return $respuesta;

    }

}
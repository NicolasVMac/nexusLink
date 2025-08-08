<?php

class ControladorReportesInventarioBiomedico{

    static public function ctrListaEquiposBiomedicosTipoMantenimiento($tipoMantenimiento){

        $respuesta = ModelReportesInventarioBiomedico::mdlListaEquiposBiomedicosTipoMantenimiento($tipoMantenimiento);

        return $respuesta;

    }

    static public function ctrListaReportesBiomedicos(){

        $tabla = "inventario_equipos_biomedicos_reportes";

        $respuesta = ModelReportesInventarioBiomedico::mdlListaReportesBiomedicos($tabla);

        return $respuesta;

    }

}
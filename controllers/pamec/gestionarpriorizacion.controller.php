<?php

class ControladorGestionPriorizacion
{
    // static public function ctrGuardarInfoGeneral($datos)
    // {
    //     $tabla = "pamec_autoevaluacion";
    //     $respuesta = ModelAutoevaluacion::mdlGuardarInfoGeneral($tabla, $datos);

    //     if ($respuesta != "error") {

    //         $resp = array(
    //             "idAutoevaluacion" => $respuesta,
    //             "status" => "ok"
    //         );
    //     } else {

    //         $resp = array(
    //             "status" => "error"
    //         );
    //     }

    //     return $resp;
    // }
    static public function ctrActualizarEstadoPriorizacion($datos)
    {
        $respuesta = ModelGestionPriorizacion::mdlActualizarEstadoPriorizacion($datos);

        return $respuesta;
    }
    static public function ctrGuardarCalidadEsperada($datos)
    {
        $tabla = "pamec_calidad_esperada";
        $respuesta = ModelGestionPriorizacion::mdlGuardarCalidadEsperada($datos, $tabla);

        return $respuesta;
    }
    static public function ctrListaCalidadEsperada($idPrio)
    {
        $tabla = "pamec_calidad_esperada";
        $respuesta = ModelGestionPriorizacion::mdlListaCalidadEsperada($idPrio, $tabla);

        return $respuesta;
    }
    static public function ctrObtenerValorEvaluacionCuantitativa($idPrio)
    {
        $escalas = ModelGestionPriorizacion::mdlObtenerValorEvaluacionCuantitativa($idPrio);

        if (!is_array($escalas)) {
            return ['error' => $escalas];
        }
        $valores = [];
        foreach ($escalas as $fila) {
            $valores[] = intval($fila['escala']);
        }
        // $total = array_sum($valores); //si es suma
        $total = array_sum($valores) / 10; //si es promedio
        /*$total = 1; // si es multiplicacion
        foreach ($valores as $v) {
            $total *= $v;
        }*/


        return [
            'resultadoEvaluacionCuantitativa' => $total
        ];
    }
    static public function ctrGuardarCalidadObservada($datos)
    {
        $tabla = "pamec_calidad_observada";
        $respuesta = ModelGestionPriorizacion::mdlGuardarCalidadObservada($datos, $tabla);

        return $respuesta;
    }
    static public function ctrVerCalidadObservada($idCalidadEsperada)
    {
        $tabla = "pamec_calidad_observada";
        $respuesta = ModelGestionPriorizacion::mdlVerCalidadObservada($idCalidadEsperada, $tabla);
        return $respuesta;
    }
    static public function ctrEliminarCalidadEsperada($idCalidad, $user)
    {
        $tabla = "pamec_calidad_esperada";
        $respuesta = ModelGestionPriorizacion::mdlEliminarCalidadEsperada($idCalidad, $user, $tabla);
        return $respuesta;
    }

    static public function ctrEliminarCalidadObservada($idCalidadObs, $user)
    {
        $tabla = "pamec_calidad_observada";
        $respuesta = ModelGestionPriorizacion::mdlEliminarCalidadObservada($idCalidadObs, $user, $tabla);
        return $respuesta;
    }

    static public function ctrObtenerInfoGeneralPriorizacion($idPrio)
    {
        $respuesta = ModelGestionPriorizacion::mdlObtenerInfoGeneralPriorizacion($idPrio);
        return $respuesta;
    }

    static public function ctrVerificarCalidadObservadaExiste($idPrio)
    {
        $respuesta = ModelGestionPriorizacion::mdlVerificarCalidadObservadaExiste($idPrio);
        return ['total' => $respuesta];
    }

    static public function ctrListaCalidadObservada($idPrio)
    {
        $tabla = "pamec_calidad_observada";
        $respuesta = ModelGestionPriorizacion::mdlListaCalidadObservada($idPrio, $tabla);
        return $respuesta;
    }
    static public function ctrListaSedesPorPriorizacion($idPrio)
    {
        $respuesta = ModelGestionPriorizacion::mdlListaSedesPorPriorizacion($idPrio);
        $resultado = explode('-', $respuesta);
        return $resultado;
    }
    static public function ctrListaAccionesMejora($idCalidadObservada)
    {
        $tabla = "pamec_accion_mejora";
        $respuesta = ModelGestionPriorizacion::mdlListaAccionesMejora($idCalidadObservada, $tabla);
        return $respuesta;
    }

    static public function ctrGuardarAccionMejora($datos)
    {
        if (empty($datos['idAccionMejora'])) {
            $respuesta = ModelGestionPriorizacion::mdlCrearAccionMejora($datos, "pamec_accion_mejora");
        } else {
            $respuesta = ModelGestionPriorizacion::mdlEditarAccionMejora($datos, "pamec_accion_mejora");
        }
        return $respuesta;
    }

    static public function ctrVerAccionMejora($idAccionMejora)
    {
        $tabla = "pamec_accion_mejora";
        $respuesta = ModelGestionPriorizacion::mdlVerAccionMejora($idAccionMejora, $tabla);
        return $respuesta;
    }

    static public function ctrEliminarAccionMejora($idAccionMejora, $user)
    {
        $tabla = "pamec_accion_mejora";
        $respuesta = ModelGestionPriorizacion::mdlEliminarAccionMejora($idAccionMejora, $user, $tabla);
        return $respuesta;
    }

    static public function ctrVerificarAccionMejoraExiste($idPrio)
    {
        $respuesta = ModelGestionPriorizacion::mdlContarAccionesPriorizacion($idPrio);
        return $respuesta;
    }

    static public function ctrListaAccionesPorPriorizacion($idPrio)
    {
        $respuesta = ModelGestionPriorizacion::mdlAccionesPorPriorizacion($idPrio);
        return $respuesta;
    }

    static public function ctrListaEvaluaciones($idAccion)
    {
        $tabla = "pamec_evaluacion_ejecucion";
        $respuesta = ModelGestionPriorizacion::mdlListaEvaluaciones($idAccion, $tabla);
        return $respuesta;;
    }

    static public function ctrGuardarEvaluacion($datos)
    {
        $tabla = "pamec_evaluacion_ejecucion";
        if (empty($datos['idEvaluacion'])) {
            $respuesta = ModelGestionPriorizacion::mdlCrearEvaluacion($datos, $tabla);
            return $respuesta;
        } else {
            $respuesta = ModelGestionPriorizacion::mdlEditarEvaluacion($datos, $tabla);
            return $respuesta;
        }
    }

    static public function ctrVerEvaluacion($idEval)
    {
        $tabla = "pamec_evaluacion_ejecucion";
        $respuesta = ModelGestionPriorizacion::mdlVerEvaluacion($idEval, $tabla);
        return $respuesta;
    }

    static public function ctrEliminarEvaluacion($idEval, $user)
    {
        $tabla = "pamec_evaluacion_ejecucion";
        $respuesta = ModelGestionPriorizacion::mdlEliminarEvaluacion($idEval, $user, $tabla);
        return $respuesta;
    }

    static public function ctrCargarSelectIndicador($idPrio)
    {
        $tabla = "pamec_calidad_esperada";
        $respuesta = ModelGestionPriorizacion::mdlCargarSelectIndicador($idPrio, $tabla);
        return $respuesta;
    }

    static public function ctrListarAprendizajeOrg($idPrio)
    {
        $tabla = "pamec_aprendizaje_organizacional";
        $respuesta = ModelGestionPriorizacion::mdlListarAprendizajeOrg($idPrio, $tabla);
        return $respuesta;
    }

    static public function ctrVerAprendizajeOrg($idPrio, $indicador)
    {
        $base = ModelGestionPriorizacion::mdlVerAprendizajeOrg($idPrio, $indicador);

        $planeadas = ModelGestionPriorizacion::mdlPlaneadas($indicador);   // 15
        $completas = ModelGestionPriorizacion::mdlCompletas($indicador);   // 11
        $avance = $planeadas > 0 ? round(($completas / $planeadas) * 100, 2) : 0;

        return array_merge($base, [
            'acciones_planeadas'  => $planeadas,
            'acciones_completas'  => $completas,
            'avance'              => $avance
        ]);
    }
    static public function ctrAprendizajeOrgById($idA)
    {
        $tabla = "pamec_aprendizaje_organizacional";
        $respuesta = ModelGestionPriorizacion::mdlAprendizajeOrgById($idA, $tabla);
        return $respuesta;
    }

    static public function ctrGuardarAprendizajeOrg($datos)
    {
        $tabla = "pamec_aprendizaje_organizacional";
        if (empty($datos['idAprendizaje'])) {
            $respuesta = ModelGestionPriorizacion::mdlCrearAprendizajeOrg($datos, $tabla);
        }
        return $respuesta;
    }

    static public function ctrEliminarAprendizajeOrg($id, $user)
    {
        $tabla = "pamec_aprendizaje_organizacional";
        $respuesta = ModelGestionPriorizacion::mdlEliminarAprendizajeOrg($id, $user, $tabla);
        return $respuesta;
    }

    static public function ctrListarAprendizajeOrgGeneral()
    {
        $tabla = "pamec_aprendizaje_organizacional";
        $respuesta = ModelGestionPriorizacion::mdlListarAprendizajeOrgGeneral($tabla);
        return $respuesta;
    }

    static public function ctrListaGestionPamec()
    {
        $respuesta = ModelGestionPriorizacion::mdlListaGestionPamec();

        return $respuesta;
    }

    /* =================  VALIDACIÓN DE CIERRE ================= */
    static public function ctrValidarAntesCerrar($idPrio)
    {

        $pendientes = [];

        $ces = ControladorGestionPriorizacion::ctrListaCalidadEsperada($idPrio);
        if (!count($ces)) {
            $pendientes[] = "La priorización no tiene ninguna <b>calidad esperada</b>.";
        }

        foreach ($ces as $ce) {
            if (!$ce['existe_observada']) {
                $pendientes[] = "La calidad esperada <b>#{$ce['id_calidad_esperada']}</b>"
                    . " ({$ce['nombre_indicador']}) no tiene calidad observada.";
            }
        }

        $cos = ModelGestionPriorizacion::mdlListaCalidadObservada($idPrio, 'pamec_calidad_observada');
        foreach ($cos as $co) {
            $acciones = ModelGestionPriorizacion::mdlListaAccionesMejora(
                $co['id_calidad_observada'],
                'pamec_accion_mejora'
            );

            if (!count($acciones)) {
                $pendientes[] = "La calidad observada <b>#{$co['id_calidad_observada']}</b>"
                    . " no tiene acciones de mejora.";
            } else {
                foreach ($acciones as $am) {
                    $eval = ModelGestionPriorizacion::mdlListaEvaluaciones(
                        $am['id_accion_mejora'],
                        'pamec_evaluacion_ejecucion'
                    );
                    if (!count($eval)) {
                        $pendientes[] = "La acción de mejora <b>#{$am['id_accion_mejora']}</b>"
                            . " no tiene evaluaciones de ejecución.";
                    }
                }
            }
        }

        $apr = ModelGestionPriorizacion::mdlListarAprendizajeOrg(
            $idPrio,
            'pamec_aprendizaje_organizacional'
        );
        if (!count($apr)) {
            $pendientes[] =
                "La gestión de la priorización no tiene registros de <b>Aprendizaje Organizacional</b>.";
        }

        return [
            'valida'   => !count($pendientes),
            'mensajes' => $pendientes
        ];
    }
}

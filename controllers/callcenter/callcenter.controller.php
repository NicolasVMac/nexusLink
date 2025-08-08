<?php

class ControladorCallCenter{

    static public function ctrMostrarHorasAgendaProfesional($idProfesional, $fechaCita){

        $tabla = "agenda_citas";

        $respuesta = ModelCallCenter::mdlMostrarHorasAgendaProfesional($tabla, $idProfesional, $fechaCita);

        return $respuesta;

    }

    static public function ctrMostrarDiasAgendaProfesional($idProfesional){

        $tabla = "agenda_citas";

        $respuesta = ModelCallCenter::mdlMostrarDiasAgendaProfesional($tabla, $idProfesional);

        return $respuesta;

    }

    static public function ctrCrearCitaAgenda($datos){

        $tabla = "agenda_citas";

        $respuesta = ModelCallCenter::mdlCrearCitaAgenda($tabla, $datos);

        return $respuesta;

    }

    static public function ctrMostrarEspaciosAgendaProfesional($idProfesional, $fechaCita){

        $respuesta = ModelCallCenter::mdlMostrarEspaciosAgendaProfesional($idProfesional, $fechaCita);

        return $respuesta;

    }

    static public function ctrListaPendientesCall($usuario){

        $respuesta = ModelCallCenter::mdlListaPendientesCall($usuario);

        return $respuesta;

    }

    static public function ctrGuardarRespuestaPreguntaCall($datos){

        $tabla = "call_center_respuestas";

        $respuesta = ModelCallCenter::mdlGuardarRespuestaPreguntaCall($tabla, $datos);

        return $respuesta;

    }

    static public function ctrTerminarGestionCall($idCall, $estado){

        $tabla = "call_center_bolsa";

        $fechaFin = date("Y-m-d H:i:s");

        $respuesta = ModelCallCenter::mdlTerminarGestionCall($tabla, $idCall, $estado, $fechaFin);

        return $respuesta;

    }

    static public function ctrCrearComunicacionFallida($datos){

        $tabla = "call_center_comunicaciones_fallidas";

        $datosCall = array(

            "id_call" => $datos["id_call"],
            "causal_fallida" => $datos["causal_fallida"],
            "observaciones" => strtoupper($datos["observaciones"]),
            "usuario_crea" => $datos["usuario_crea"]

        );

        $guardarComFallida = ModelCallCenter::mdlCrearComunicacionFallida($tabla, $datosCall);

        if($guardarComFallida == "ok"){

            if($datos["causal_fallida"] != 'NO ACEPTA VISITA'){

                // $tablaCall = "call_center_bolsa";
                // $itemCall = "id_call";
                // $valorCall = $datos["id_call"];

                // $datosCall = ControladorCallCenter::ctrObtenerDato($tablaCall, $itemCall, $valorCall);

                $nuevoContadorGestiones = $datos["cantidad_gestiones"] + 1;

                $actualizarContador = ModelCallCenter::mdlActualizarContadorGestiones($datos["id_call"], $nuevoContadorGestiones);

                if($actualizarContador == "ok"){

                    $tablaCantidad = "par_cantidad_gestiones_call";
                    $itemCantidad = "proceso";
                    $valorCantidad = $datos["proceso_call"];

                    $datosCantidades = ControladorCallCenter::ctrObtenerDato($tablaCantidad, $itemCantidad, $valorCantidad);

                    if($nuevoContadorGestiones >= $datosCantidades["valor"]){

                        //CUMPLIO LA CANTIDAD DE GESTIONES, CERRAMOS EL PROCESO CALL

                        $tablaCall = "call_center_bolsa";

                        $datosActualizar = array(

                            "id_call" => $datos["id_call"],
                            "estado" => "FALLIDA",
                            "fecha_fin" => date("Y-m-d H:i:s")

                        );

                        $estadoFallida = ModelCallCenter::mdlActualizarEstadoFallidaCall($tablaCall, $datosActualizar);

                        if($estadoFallida == "ok"){

                            return "ok-cierre-call";

                        }else{

                            return "error";

                        }


                    }else{

                        return "ok-comunicacion-fallida";

                    }


                }else{

                    return "error";

                }

            }else{

                //CAUSAL NO ACEPTA VISITA SE CIERRA LA GESTION SIN IMPORTAR CANTIDAD GESTIONES
                $tablaCall = "call_center_bolsa";

                $datosActualizar = array(

                    "id_call" => $datos["id_call"],
                    "estado" => "FALLIDA",
                    "fecha_fin" => date("Y-m-d H:i:s")

                );

                $estadoFallida = ModelCallCenter::mdlActualizarEstadoFallidaCall($tablaCall, $datosActualizar);

                if($estadoFallida == "ok"){

                    return "ok-cierre-call-causal";

                }else{

                    return "error";

                }


            }

        }else{

            return "error";

        }

    }

    static public function ctrMostrarPreguntasProcesoCall($procesoCall){

        $tabla = "call_center_preguntas";

        $respuesta = ModelCallCenter::mdlMostrarPreguntasProcesoCall($tabla, $procesoCall);

        return $respuesta;

    }

    static public function ctrBuscarPaciente($filtro, $valor){

        $tabla = "pacientes";

        $respuesta = ModelCallCenter::mdlBuscarPaciente($tabla, $filtro, $valor);

        return $respuesta;

    }

    static public function ctrCrearGestionCall($procesoCall, $idPaciente, $asesor){

        $tabla = "call_center_bolsa";

        $fechaIni = date("Y-m-d H:i:s");

        $respuesta = ModelCallCenter::mdlCrearGestionCall($tabla, $procesoCall, $idPaciente, $asesor, $fechaIni);

        return $respuesta;

    }

    static public function ctrInfoCall($idCall, $procesoCall){

        $tabla = "call_center_bolsa";

        $respuesta = ModelCallCenter::mdlInfoCall($tabla, $idCall, $procesoCall);

        return $respuesta;

    }

    static public function ctrObtenerDato($tabla, $item, $valor){

        $respuesta = ModelCallCenter::mdlObtenerDato($tabla, $item, $valor);

        return $respuesta;

    }

    static public function ctrListaDato($tabla, $item, $valor){

        $respuesta = ModelCallCenter::mdlListaDato($tabla, $item, $valor);

        return $respuesta;

    }

}
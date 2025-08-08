<?php

class ControladorCitas{

    static public function ctrGuardarGestionCitaFallida($datos){

        $tabla = "di_agendamiento_citas";

        $respuesta = ModelCitas::mdlGuardarGestionCitaFallida($tabla, $datos);

        return $respuesta;

    }

    static public function ctrEliminarPreCita($idPreCita){

        $respuesta = ModelCitas::mdlEliminarPreCita($idPreCita);

        return $respuesta;

    }

    static public function ctrListaPreCitasCita($idCita){

        $respuesta = ModelCitas::mdlListaPreCitasCita($idCita);

        return $respuesta;
        
    }

    static public function ctrTerminarGestionPreCita($datos){

        $tabla = "di_agendamiento_pre_citas";
        $hoy = date("Y-m-d H:i:s");

        $validarCitas = ModelCitas::mdlValidarAgendamientoCitasPreCitas($datos["id_pre_cita"]);

        if(!empty($validarCitas)){

            $respuesta = ModelCitas::mdlTerminarGestionPreCita($tabla, $datos, $hoy);

        }else{

            $respuesta = 'sin-registros-citas';

        }

        return $respuesta;

    }

    static public function ctrCrearComunicacionFallida($datos){

        $tabla = "di_pre_citas_comunicaciones_fallidas";

        $datosAgendamiento = array(

            "id_pre_cita" => $datos["id_pre_cita"],
            "causal_fallida" => $datos["causal_fallida"],
            "observaciones" => strtoupper($datos["observaciones"]),
            "usuario_crea" => $datos["usuario_crea"]

        );

        $guardarComFallida = ModelCitas::mdlCrearComunicacionFallida($tabla, $datosAgendamiento);

        if($guardarComFallida == "ok"){

            //OBTENER CAUSALES CANCELA
            $causalesCancela = ControladorCitas::ctrObtenerCausalesComFallidaCancela();

            // if($datos["causal_fallida"] != 'NO ACEPTA VISITA'){

            if(!in_array($datos["causal_fallida"], $causalesCancela)){

                // $tablaCall = "call_center_bolsa";
                // $itemCall = "id_call";
                // $valorCall = $datos["id_call"];

                // $datosCall = ControladorCallCenter::ctrObtenerDato($tablaCall, $itemCall, $valorCall);

                $nuevoContadorGestiones = $datos["cantidad_gestiones"] + 1;

                $actualizarContador = ModelCitas::mdlActualizarContadorGestiones($datos["id_pre_cita"], $nuevoContadorGestiones);

                if($actualizarContador == "ok"){

                    $tablaCantidad = "par_variables_globales";
                    $itemCantidad = "variable";
                    $valorCantidad = "CANTIDAD_GESTIONES_PRE_CITAS";

                    $datosCantidades = ControladorCitas::ctrObtenerDato($tablaCantidad, $itemCantidad, $valorCantidad);

                    if($nuevoContadorGestiones >= $datosCantidades["valor"]){

                        //CUMPLIO LA CANTIDAD DE GESTIONES, CERRAMOS EL PROCESO CALL

                        $tablaCall = "di_agendamiento_pre_citas";

                        $datosActualizar = array(

                            "id_pre_cita" => $datos["id_pre_cita"],
                            "estado" => "FALLIDA",
                            "fecha_fin" => date("Y-m-d H:i:s")

                        );

                        $estadoFallida = ModelCitas::mdlActualizarEstadoFallidaCall($tablaCall, $datosActualizar);

                        if($estadoFallida == "ok"){

                            return "ok-cierre-agendamiento";

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

                $tablaCall = "di_agendamiento_pre_citas";

                $datosActualizar = array(

                    "id_pre_cita" => $datos["id_pre_cita"],
                    "estado" => "FALLIDA",
                    "fecha_fin" => date("Y-m-d H:i:s")

                );

                $estadoFallida = ModelCitas::mdlActualizarEstadoFallidaCall($tablaCall, $datosActualizar);

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

    static public function ctrObtenerCausalesComFallidaCancela(){

        $respuesta = ModelCitas::mdlObtenerCausalesComFallidaCancela();

        $arrayCancela = [];

        foreach ($respuesta as $key => $value) {
            
            $arrayCancela[] = $value["descripcion"];

        }

        return $arrayCancela;

    }

    static public function ctrCrearCitaPreCita($datos){

        $tabla = "di_agendamiento_citas";

        $respuesta = ModelCitas::mdlCrearCitaPreCita($tabla, $datos);

        if($respuesta == 'ok'){

            $obtenerInfoCita = ModelCitas::mdlObtenerInfoCitaPreCita($datos);

            if(!empty($obtenerInfoCita)){

                $datosUpd = array(

                    "id_pre_cita" => $datos["id_pre_cita"],
                    "id_cita" => $obtenerInfoCita["id_cita"]

                );
                
                $updIntermedia = ModelCitas::mdlActualizarIntermerdia($datosUpd);

                if($updIntermedia == 'ok'){

                    return 'ok';

                }else{

                    return 'error-update';

                }
            
            }else{

                return 'no-encontrada';

            }

        }else{

            return 'error';   

        }

    }

    static public function ctrTomarPreCita($idPreCita, $asesor){

        $preCitasUser = ControladorCitas::ctrListaPreCitasPendienteUser($asesor);

        $tablaCantidad = "par_variables_globales";
        $itemCantidad = "variable";
        $valorCantidad = "CANTIDAD_PENDIENTES_PRE_CITAS";

        $datosCantidades = ControladorCitas::ctrObtenerDato($tablaCantidad, $itemCantidad, $valorCantidad);

        if(count($preCitasUser) < $datosCantidades["valor"]){

            $data = ControladorCitas::ctrObtenerPreCita($idPreCita);

            if(empty($data["asesor"]) && $data["estado"] == 'CREADA'){

                $hoy = date("Y-m-d H:i:s");

                $asignarPreCita = ModelCitas::mdlAsignarPreCita($idPreCita, $asesor, $hoy);

                if($asignarPreCita == 'ok'){

                    return array(

                        "estado" => 'ok-asignado'

                    );

                }else{

                    return array (
                            
                        "estado" => "error-asignando"
                    
                    );

                }

            }else if(!empty($data["asesor"]) && $data["estado"] != 'CREADA'){

                return array (
                            
                    "estado" => "ok-ya-asignado"
                
                );

            }

        }else{

            return array (
                            
                "estado" => "error-capacidad-superada"
            
            );

        }

    }

    static public function ctrListaComunicacionFallidasPreCitas($idPreCita){

        $respuesta = ModelCitas::mdlListaComunicacionFallidasPreCitas($idPreCita);

        return $respuesta;

    }

    static public function ctrObtenerPreCita($idPreCita){

        $respuesta = ModelCitas::mdlObtenerPreCita($idPreCita);

        return $respuesta;

    }

    static public function ctrListaPreCitasPendienteUser($user){

        $respuesta = ModelCitas::mdlListaPreCitasPendienteUser($user);

        return $respuesta;

    }

    static public function ctrListaPendientesPreCitasUser($user){

        $respuesta = ModelCitas::mdlListaPendientesPreCitasUser($user);

        return $respuesta;

    }
    

    static public function ctrListaBolsaPreCitas(){

        $respuesta = ModelCitas::mdlListaBolsaPreCitas();

        return $respuesta;

    }

    static public function ctrCrearPreCita($datos){

        $tabla = "di_agendamiento_pre_citas";

        $respuesta = ModelCitas::mdlCrearPreCita($tabla, $datos);

        return $respuesta;

    }

    static public function ctrListaCitasPaciente($datos){

        $respuesta = ModelCitas::mdlListaCitasPaciente($datos);

        return $respuesta;

    }

    static public function ctrGuardarGestionFormularioCita($datos){

        $respuesta = ModelCitas::mdlGuardarGestionFormularioCita($datos);

        if($respuesta == 'ok'){

            $datosTerminar = array(

                "id_cita" => $datos["id_cita"],
                "estado" => "TERMINADA",
                "fecha_fin" => date("Y-m-d H:i:s")

            );

            //TERMINAR CITA
            $respuestaCita = ControladorCitas::ctrTerminarCita($datosTerminar);

            if($respuestaCita == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }


        }

    }

    static public function ctrTerminarCita($datos){

        $tabla = "di_agendamiento_citas";

        $respuesta = ModelCitas::mdlTerminarCita($tabla, $datos);

        return $respuesta;

    }

    static public function ctrVerInfoCita($idCita){

        $respuesta = ModelCitas::mdlVerInfoCita($idCita);

        return $respuesta;

    }

    static public function ctrGestionarCita($idCita, $estado, $idProfesional){

        $citasProcesoProfesional = ModelCitas::mdlCitasProcesoProfesional($idProfesional);

        if(empty($citasProcesoProfesional)){

            $tabla = "di_agendamiento_citas";
            $hoy = date("Y-m-d H:i:s");

            $respuesta = ModelCitas::mdlGestionarCita($tabla, $idCita, $estado, $hoy);

            if($respuesta == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }else{

            return 'error-cita-proceso';

        }

    }

    static public function ctrListaCitasPendientesMedica($idProfesional){

        $respuesta = ModelCitas::mdlListaCitasPendientesMedica($idProfesional);

        return $respuesta;

    }

    static public function ctrObtenerDato($tabla, $item, $valor){

        $respuesta = ModelCitas::mdlObtenerDato($tabla, $item, $valor);

        return $respuesta;

    }

}
<?php

require_once "../../plugins/PHPExcel/IOFactory.php";
require_once "../../plugins/PHPExcel.php";

class ControladorAgendamiento{

    static public function ctrInfoPacienteBolsaPaciente($idBolsaAgendamiento){

        $infoBolsaDemandaInducida = ModelAgendamiento::mdlInfoBolsaAgendamiento($idBolsaAgendamiento);

        $infoPaciente = ModelAgendamiento::mdlBuscarPaciente($infoBolsaDemandaInducida["tipo_doc"], $infoBolsaDemandaInducida["numero_documento"]);

        if(empty($infoPaciente)){

            return array(
                "estado" => "paciente-no-existe"
            );

        }else{

            //ACTUALIZAR ID PACIENTE BOLSA PACIENTES
            $actualizar = ModelAgendamiento::mdlActualizarPacienteBolsa($idBolsaAgendamiento, $infoPaciente["id_paciente"]);

            return  array(
                "estado" => "paciente-existe",
                "paciente" => $infoPaciente
            );

        }

    }

    static public function ctrListaPacienteAgenda($datos){

        $respuesta = ModelAgendamiento::mdlListaPacienteAgenda($datos);

        return $respuesta;

    }

    static public function ctrAsignarAgendamiento($datos){

        $hoy = date("Y-m-d H:i:s");

        $respuesta = ModelAgendamiento::mdlAsignarAgendamiento($datos["id_bolsa_paciente"], $datos["asesor"], $hoy);

        return $respuesta;

    }

    static public function ctrListaAgendamientosBusqueda($tipoDocumento, $numeroDocumento){

        $respuesta = ModelAgendamiento::mdlListaAgendamientosBusqueda($tipoDocumento, $numeroDocumento);

        return $respuesta;

    }

    static public function ctrListaAgendamientosPendienteUserCohorte($cohortePrograma, $user){

        $respuesta = ModelAgendamiento::mdlListaAgendamientosPendienteUserCohorte($cohortePrograma, $user);

        return $respuesta;

    }

    static public function ctrListaBolsasAgendamientoUser($user){

        $respuesta = ModelAgendamiento::mdlListaBolsasAgendamientoUser($user);

        return $respuesta;

    }

    static public function ctrEliminarAsignacionBolsaAgendamiento($idUsuBolsaAgend){

        $respuesta = ModelAgendamiento::mdlEliminarAsignacionBolsaAgendamiento($idUsuBolsaAgend);

        return $respuesta;

    }

    static public function ctrListaAsignacionesBolsasAgendamiento(){

        $respuesta = ModelAgendamiento::mdlListaAsignacionesBolsasAgendamiento();

        return $respuesta;

    }

    static public function ctrCrearAsignacionBolsa($datos){

        //VALIDACION EXISTE BOLSA ASIGNADA
        $validacion = ModelAgendamiento::mdlUsuarioAsignacionBolsaExiste($datos);

        if(!empty($validacion)){

            return 'bandeja-asignada';

        }else{

            //CREAR BANDEJA
            $crear = ModelAgendamiento::mdlCrearAsignacionBolsa($datos);

            if($crear == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }

    }

    static public function ctrListaUsuariosAgendamiento(){

        $respuesta = ModelAgendamiento::mdlListaUsuariosAgendamiento();

        return $respuesta;

    }

    static public function ctrListaProfesionalesAgendamiento(){

        $respuesta = ModelAgendamiento::mdlListaProfesionalesAgendamiento();

        return $respuesta;

    }

    static public function ctrGuardarInformacionNexusVidamedical($idBolsaAgendamiento){

        // $datosRespuesta = array();

        $infoAgendamiento = ControladorAgendamiento::ctrObtenerDato("di_bolsa_pacientes", "id_bolsa_paciente", $idBolsaAgendamiento);

        $datosPacienteVidamedical = ControladorAgendamiento::ctrExistePacienteVidamedical($infoAgendamiento["tipo_doc"], $infoAgendamiento["numero_documento"]);

        if(empty($datosPacienteVidamedical)){

            //SE CREA PACIENTE YA QUE NO EXISTE
            $infoPaciente = ControladorAgendamiento::ctrObtenerDato("pacientes", "id_paciente", $infoAgendamiento["id_paciente"]);

            // $datosRespuesta["infoPaciente"] = $infoPaciente;

            $datosPaciente = ControladorAgendamiento::ctrTransformarInformacionVidamedical($infoPaciente);            

            // $datosRespuesta["datosPaciente"] = $datosPaciente;

            $crearPaciente = ControladorAgendamiento::ctrCrearPacienteVidamedical($datosPaciente);

            if($crearPaciente == 'ok'){

                $datosPacienteVidamedical = ControladorAgendamiento::ctrExistePacienteVidamedical($infoAgendamiento["tipo_doc"], $infoAgendamiento["numero_documento"]);

                $idPaciente = $datosPacienteVidamedical["id_pac"];

                $crearCita = ControladorAgendamiento::ctrCrearCitaVidamedical($idBolsaAgendamiento, $idPaciente);

                if($crearCita != 'ok'){

                    $datosLog = array(
                        "proceso" => "AGENDAMIENTO",
                        "id_proceso" => $idBolsaAgendamiento,
                        "error" => "error-save-cita"
                    ); 
    
                    $log = ModelAgendamiento::mdlRegistrarLogVidaMedical($datosLog);

                    return 'error-save-cita';
    
                }

            }else{

                // var_dump($crearPaciente);

                $datosLog = array(
                    "proceso" => "AGENDAMIENTO",
                    "id_proceso" => $idBolsaAgendamiento,
                    "error" => "error-save-paciente"
                ); 

                $log = ModelAgendamiento::mdlRegistrarLogVidaMedical($datosLog);

                // return 'error-save-paciente';
                // return $crearPaciente;

            }

        }else{

            //EL PACIENTE EXISTE TOMAMOS EL ID
            $idPaciente = $datosPacienteVidamedical["id_pac"];

            $crearCita = ControladorAgendamiento::ctrCrearCitaVidamedical($idBolsaAgendamiento, $idPaciente);

            if($crearCita != 'ok'){

                $datosLog = array(
                    "proceso" => "AGENDAMIENTO",
                    "id_proceso" => $idBolsaAgendamiento,
                    "error" => "error-save-cita"
                ); 

                $log = ModelAgendamiento::mdlRegistrarLogVidaMedical($datosLog);

                // return 'error-save-cita';

            }


        }

        // $datosRespuesta["infoAgendamiento"] = $infoAgendamiento;
        // $datosRespuesta["datosPacienteVidamedical"] = $datosPacienteVidamedical;

        return 'ok';
        

    }

    static public function ctrCrearCitaVidamedical($idBolsaAgendamiento, $idPaciente){

        //OBTENER LAS CITAS CREADAS EN EL AGENDAMIENTO
        $citasPaciente = ControladorAgendamiento::ctrObtenerCitasAgendamiento($idBolsaAgendamiento);

        
        $datosRespuesta["infoCitas"] = $citasPaciente;
        
        foreach ($citasPaciente as $key => $valueCita){

            //OBTENER ID CONCECUTIVO
            $infoConcecutivo = ModelAgendamiento::mdlConcecutivoMedicoGenerips();
            
            //OBTENER DATOS PROFESIONAL
            $datosProfesional = ControladorAgendamiento::ctrObtenerDato("par_profesionales", "id_profesional", $valueCita["id_profesional"]);

            //OBTENER DATOS GENERIPS
            $datosGenerips = ModelAgendamiento::mdlObtenerInfoMedicoGenerips($datosProfesional["doc_profesional"]);

            //OBTENER DATOS SERVICIO
            $datosServicio = ModelAgendamiento::mdlObtenerInfoServicio($valueCita["servicio_cita"]);

            if(!empty($datosGenerips)){

                $idMedGenerips = $datosGenerips["medico_nexus"];

            }else{

                $datosMed = array(
                    "medico_nexus" => $infoConcecutivo["id_increment"],  
                    "nombre_medico" => $datosProfesional["nombre_profesional"],
                    "documento_medico" => $datosProfesional["doc_profesional"],
                    "sede" => 1
                );

                //CREAR MEDICO GENERIPS NO EXISTE
                $crearMed = ModelAgendamiento::mdlCrearMedicoGenerips($datosMed);

                if($crearMed == 'ok'){

                    $datosGenerips = ModelAgendamiento::mdlObtenerInfoMedicoGenerips($datosMed["documento_medico"]);

                    $idMedGenerips = $datosGenerips["medico_nexus"];

                }else{

                    $idMedGenerips = 0;

                    //LOG ERRORES
                    $datosLog = array(
                        "proceso" => "AGENDAMIENTO",
                        "id_proceso" => $idBolsaAgendamiento,
                        "error" => "error-save-medico"
                    ); 
    
                    $log = ModelAgendamiento::mdlRegistrarLogVidaMedical($datosLog);

                }

            }


            $hora = $valueCita["franja_cita"] == 'AM' ? '08:00' : '14:00';

            $datosCita = array(
                "id_nexus" => $valueCita["id_cita"],
                "sede_nexus" => 1,
                "id_paciente" => $idPaciente,
                "fecha_nexus" => $valueCita["fecha_cita"],
                "solicitud_nexus" => $valueCita["fecha_cita"],
                "requerida_nexus" => $valueCita["fecha_cita"],
                "medico_nexus" => $idMedGenerips,
                "hora_nexus" => $hora,
                "servicio_nexus" => $datosServicio["id_par_servicio"],
                "estado_nexus" => 1,
                "actualiza_nexus" => 1,
                "data_nexus" => $valueCita["fecha_crea"]
            );

            $guardarCitaVidaMedical = ControladorAgendamiento::ctrGuardarCitaVidamedical($datosCita);

            if($guardarCitaVidaMedical != 'ok'){

                return 'error-save-cita';

            }

        }

        return 'ok';

    }

    static public function ctrCrearPacienteVidamedical($datos){

        $respuesta = ModelAgendamiento::mdlCrearPacienteVidamedical($datos);

        return $respuesta;

    }

    static public function ctrTransformarInformacionVidamedical($infoPaciente){

        $tipoUsuarioRips = ControladorAgendamiento::ctrObtenerDato("par_tipo_usuario_rips", "descripcion", $infoPaciente["tipo_usuario_rips"]);
        $generoPaciente = ControladorAgendamiento::ctrObtenerDato("par_generos", "descripcion", $infoPaciente["genero_paciente"]);

        if(!empty($infoPaciente["departamento_sisben"])){
            $departamentoPacienteSis = ControladorAgendamiento::ctrObtenerDato("par_ciudad", "departamento", $infoPaciente["departamento_sisben"]);
            $depa_pac = $departamentoPacienteSis["codigo_departamento"];
        }else{
            $depa_pac = "";
        }

        if(!empty($infoPaciente["municipio_sisben"])){
            $municipioPacienteSis = ControladorAgendamiento::ctrObtenerDato("par_ciudad", "ciudad", $infoPaciente["municipio_sisben"]);
            $muni_pac = $municipioPacienteSis["codigo_dane"];
        }else{
            $muni_pac = "";
        }

        $zonePaciente = ControladorAgendamiento::ctrObtenerDato("par_zonas", "descripcion", $infoPaciente["zona_ubicacion"]);
        $ocupacionPaciente = ControladorAgendamiento::ctrObtenerDato("par_ocupacion", "descripcion", $infoPaciente["ocupacion"]);
        $entidadEpsPaciente = ControladorAgendamiento::ctrObtenerDato("par_entidad_actual", "descripcion", $infoPaciente["entidad_af_actual"]);
        $estadoCivilPaciente = ControladorAgendamiento::ctrObtenerDato("par_estados_civiles", "descripcion", $infoPaciente["estado_civil"]);
        $grupoPoblacionPaciente = ControladorAgendamiento::ctrObtenerDato("par_grupo_poblacional", "descripcion", $infoPaciente["grupo_poblacional"]);
        $pertinenciaEtnicaPaciente = ControladorAgendamiento::ctrObtenerDato("par_pertinencia_etnica", "descripcion", $infoPaciente["pertenencia_etnica"]);
        $regimenPaciente = ControladorAgendamiento::ctrObtenerDato("par_regimenes", "descripcion", $infoPaciente["regimen"]);

        if(!empty($infoPaciente["departamento_ubicacion"])){
            $departamentoPacienteUbi = ControladorAgendamiento::ctrObtenerDato("par_ciudad", "departamento", $infoPaciente["departamento_ubicacion"]);
            $dpto2_pac = $departamentoPacienteUbi["codigo_departamento"];
        }else{
            $dpto2_pac = "";
        }

        if(!empty($infoPaciente["municipio_ubicacion"])){
            $municipioPacienteUbi = ControladorAgendamiento::ctrObtenerDato("par_ciudad", "ciudad", $infoPaciente["municipio_ubicacion"]);
            $muni2_pac = $municipioPacienteUbi["codigo_dane"];
        }else{
            $muni2_pac = "";
        }

        $copagoPaciente = ControladorAgendamiento::ctrObtenerDato("par_mod_copagos", "descripcion", $infoPaciente["mod_copago"]);
        $tipoVinculacionPaciente = ControladorAgendamiento::ctrObtenerDato("par_vinculaciones", "descripcion", $infoPaciente["vinculacion"]);

        if(!empty($infoPaciente["paquete_atencion"])){
            $paqueteAtencionPaciente = ControladorAgendamiento::ctrObtenerDato("par_paquetes_atencion", "id_paquete_atencion", $infoPaciente["paquete_atencion"]);
            $paqueteAtencionPaciente = $paqueteAtencionPaciente["id_paquete_atencion"];
        }else{
            $paqueteAtencionPaciente = 0;
        }


        $escolaridadPaciente = ControladorAgendamiento::ctrObtenerDato("par_escolaridad", "descripcion", $infoPaciente["escolaridad"]);
        $paisOrigen = ControladorAgendamiento::ctrObtenerDato("par_paises_origen", "descripcion", $infoPaciente["pais_origen"]);

        $datos = array(
            "tipoiden_pac" => $infoPaciente["tipo_documento"] ?? "",
            "documento_pac" => $infoPaciente["numero_documento"] ?? "",
            "expedido_pac" => $infoPaciente["expedido_en"] ?? "",
            "ape1_pac" => $infoPaciente["primer_apellido"] ?? "",
            "ape2_pac" => $infoPaciente["segundo_apellido"] ?? "",
            "nom1_pac" => $infoPaciente["primer_nombre"] ?? "",
            "nom2_pac" => $infoPaciente["segundo_nombre"] ?? "",
            "tipousu_pac" => $tipoUsuarioRips["id_tipo_usuario_rips"] ?? "",
            "sexo_pac" => $generoPaciente["codigo"] ?? "",
            "fechanac_pac" => $infoPaciente["fecha_nacimiento"],
            "depa_pac" => $depa_pac ?? "",
            "muni_pac" => $muni_pac ?? "",
            "zona_pac" => $zonePaciente["codigo"] ?? "",
            "direccion_pac" => $infoPaciente["direccion_ubicacion"] ?? "",
            "barrio_pac" => "", //NO TENEMOS BARRIO
            "telefono1_pac" => $infoPaciente["telefono_uno_ubicacion"] ?? "",
            "telefono2_pac" => $infoPaciente["telefono_dos_ubicacion"] ?? "",
            "ocupacion_pac" => $ocupacionPaciente["codigo"] ?? "",
            "observa_pac" => $infoPaciente["observacion_contacto"] ?? "",
            "entidad_pac" => 0,
            "responsable_pac" => $infoPaciente["responsable"] ?? "",
            "parentesco_pac" => $infoPaciente["parentesco"] ?? "",
            "direccion2_pac" => $infoPaciente["direccion_contacto"] ?? "",
            "telefono3_pac" => $infoPaciente["telefono_contacto"] ?? "",
            "ecivil_pac" => $estadoCivilPaciente["codigo"] ?? "",
            "madre_pac" => $infoPaciente["nombre_madre"] ?? "",
            "padre_pac" => $infoPaciente["nombre_padre"] ?? "",
            "sisben_pac" => $infoPaciente["nivel_sisben"] ?? "",
            "grupop_pac" => $grupoPoblacionPaciente["id_grupo_poblacional"] ?? "",
            "petnica_pac" => $pertinenciaEtnicaPaciente["id_pertinencia_etnica"] ?? "",
            "regimen_pac" => $regimenPaciente["id_regimen"] ?? "",
            "dpto2_pac" => $dpto2_pac ?? "",
            "muni2_pac" => $muni2_pac ?? "",
            "copago_pac" => $copagoPaciente["codigo"] ?? "",
            "tipovin_pac" => $tipoVinculacionPaciente["codigo"] ?? "",
            "prestadir_pac" => 0, //NO SE EL DATO QUE VA ACA
            "reclamamed_pac" => 0,
            "escolar_pac" => $escolaridadPaciente["id_escolaridad"] ?? "",
            "alias_pac" => $infoPaciente["psudonimo"] ?? "",
            "paquete_pac" => $paqueteAtencionPaciente ?? "",
            "ipsnot_pac" => $infoPaciente["ips_notifica"] ?? "",
            "notifica_pac" => $infoPaciente["notifica_sivigila"] ?? "",
            "fecnanoti_pac" => $infoPaciente["fecha_notificacion_sivigila"],
            "ingresa" => $infoPaciente["fecha_crea"] ?? "",
            "email_pac" => $infoPaciente["correo"] ?? "",
            "rh" => 0, //NO SE EL DATO QUE VA ACA
            "arl" => 0, //NO SE EL DATO QUE VA ACA
            "eps" => $entidadEpsPaciente["id_ent_actual"] ?? "",
            "afp" => 0, //NO SE EL DATO QUE VA ACA
            "pais" => $paisOrigen["codigo"] ?? "",
            "tipo_usu_fe" => 0, //NO SE EL DATO QUE VA ACA
            "modera_fe" => 0, //NO SE EL DATO QUE VA ACA
        );
        

        return $datos;

    }

    static public function ctrGuardarCitaVidamedical($datos){

        $respuesta = ModelAgendamiento::mdlGuardarCitaVidamedical($datos);

        return $respuesta;

    }

    static public function ctrObtenerCitasAgendamiento($idBolsaAgendamiento){

        $respuesta = ModelAgendamiento::mdlObtenerCitasAgendamiento($idBolsaAgendamiento);

        return $respuesta;

    }

    static public function ctrCrearNoDisponibilidad($datos){

        $respuesta = ModelAgendamiento::mdlCrearNoDisponibilidad($datos);

        return $respuesta;

    }

    static public function ctrValidarNoDisponibilidad($idProfesional, $fechaCita){

        $respuesta = ModelAgendamiento::mdlValidarNoDisponibilidad($idProfesional, $fechaCita);

        return $respuesta;

    }

    static public function ctrReAgendarCita($datos){

        $datosAntiguos = ModelAgendamiento::mdlObtenerDato("di_agendamiento_citas", "id_cita", $datos["idCita"]);

        $txtAntiguos = "idProfesional: " . $datosAntiguos["id_profesional"] . " - Fecha Cita: " . $datosAntiguos["fecha_cita"] . " - Franja Cita: " . $datosAntiguos["franja_cita"];
        $txtNuevos = "idProfesional: " . $datos["idProfesional"] . " - Fecha Cita: " . $datos["fechaCita"] . " - Franja Cita: " . $datos["franjaCita"];

        $reAgendar = ModelAgendamiento::mdlReAgendarCita($datos);

        if($reAgendar == 'ok'){

            $tablaLog = "di_agendamiento_citas_reagendamiento_log";

            //REGISTRAR LOG
            $datosLog = array(

                "id_cita" => $datos["idCita"],
                "data_antigua" => $txtAntiguos,
                "data_nueva" => $txtNuevos,
                "usuario_crea" => $datos["usuario"]

            );

            $log = ModelAgendamiento::mdlGuardarLogReAgendamiento($tablaLog, $datosLog);

            if($log == 'ok'){

                return 'ok';

            }else{

                return 'error-save-log';

            }

        }else{

            return 'error-re-agendamiento';

        }

    }

    static public function ctrEliminarCita($idCita, $user){

        $logElimina = ModelAgendamiento::mdlCitaEliminadaLog($idCita, $user);

        if($logElimina == 'ok'){

            $eliminar = ModelAgendamiento::mdlEliminarCita($idCita);

            if($eliminar == 'ok'){

                return 'ok';

            }else{

                return 'error-eliminando';

            }

        }else{

            return 'error';

        }

    }

    static public function ctrEliminarPrioridad($idPrioridad){

        $respuesta = ModelAgendamiento::mdlEliminarPrioridad($idPrioridad);

        return $respuesta;

    }

    static public function ctrListaPrioridadesAgendamiento(){

        $respuesta = ModelAgendamiento::mdlListaPrioridadesAgendamiento();

        return $respuesta;

    }

    static public function ctrCrearPrioridad($cohortePrograma, $prioridad, $usuarioCrea){

        //VALIDACION EXISTENCIA DE PRIORIDAD
        $prioridadExist = ModelAgendamiento::mdlValidarExistePrioridad($cohortePrograma, $prioridad);

        if(empty($prioridadExist)){

            $crearPrioridad = ModelAgendamiento::mdlCrearPrioridad($cohortePrograma, $prioridad, $usuarioCrea);

            if($crearPrioridad == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }else{

            return 'prioridad-existe';

        }

    }

    static public function ctrListaCohorteProgramas(){

        $respuesta = ModelAgendamiento::mdlListaCohorteProgramas();

        return $respuesta;

    }

    static public function ctrValidaDatosPaciente($idBolsaAgendamiento, $tipoDocumento, $numeroDocumento){

        $respuesta = ModelAgendamiento::mdlValidaDatosPaciente($tipoDocumento, $numeroDocumento);

        if(!empty($respuesta)){

            $actualizar = ModelAgendamiento::mdlActualizarBolsaAgendamientoPaciente($idBolsaAgendamiento, $respuesta["id_paciente"]);

        }

        return $respuesta;

    }

    static public function ctrListaCitasCalendarProfesional($idProfesional){

        $respuesta = ModelAgendamiento::mdlListaCitasCalendarProfesional($idProfesional);

        $datos = array();

        foreach ($respuesta as $item) {

            $nombrePaciente = '';
            $documentoPaciente = '';

            $paciente = ControladorAgendamiento::ctrObtenerDato("pacientes", "id_paciente", $item["id_paciente"]);

            if(!empty($paciente)){

                $nombrePaciente = $paciente["primer_apellido"] . " " . $paciente["segundo_apellido"] . " " . $paciente["primer_nombre"] . " " . $paciente["segundo_nombre"];
                $documentoPaciente = $paciente["tipo_documento"] . " - " . $paciente["numero_documento"];

            }else{

                $nombrePaciente = 'SIN PACIENTE';
                $documentoPaciente = 'SIN PACIENTE';

            }

            $color = $item["franja_cita"] == "AM" ? '#ffb200' : ($item["franja_cita"] == 'PM' ? '#3874ff' : '#ed2000');

            $evento = array(
                'idCita' => $item['id_cita'],
                'title' => $item['nombre_profesional'],
                'description' => $item['motivo_cita'],
                'cohortePrograma' => $item['cohorte_programa'],
                'fechaCita' => $item['fecha_cita'],
                'franjaCita' => $item['franja_cita'],
                'estado' => $item['estado'],
                'start' => $item['fecha_cita'],
                'observaciones' => $item['observaciones_cita'],
                'color' => $color,
                'nombrePaciente' => $nombrePaciente,
                'documentoPaciente' => $documentoPaciente
            );

            $datos[] = $evento;
        }

        return $datos;


    }

    static public function ctrListaCitasCalendar(){

        $respuesta = ModelAgendamiento::mdlListaCitasCalendar();

        $datos = array();

        foreach ($respuesta as $item) {

            $nombrePaciente = '';
            $documentoPaciente = '';

            $paciente = ControladorAgendamiento::ctrObtenerDato("pacientes", "id_paciente", $item["id_paciente"]);

            if(!empty($paciente)){

                $nombrePaciente = $paciente["primer_apellido"] . " " . $paciente["segundo_apellido"] . " " . $paciente["primer_nombre"] . " " . $paciente["segundo_nombre"];
                $documentoPaciente = $paciente["tipo_documento"] . " - " . $paciente["numero_documento"];

            }else{

                $nombrePaciente = 'SIN PACIENTE';
                $documentoPaciente = 'SIN PACIENTE';

            }



            $color = $item["franja_cita"] == "AM" ? '#ffb200' : ($item["franja_cita"] == 'PM' ? '#3874ff' : '#ed2000');

            $evento = array(
                'idCita' => $item['id_cita'],
                'title' => $item['nombre_profesional'],
                'description' => $item['motivo_cita'],
                'cohortePrograma' => $item['cohorte_programa'],
                'fechaCita' => $item['fecha_cita'],
                'franjaCita' => $item['franja_cita'],
                'estado' => $item['estado'],
                'start' => $item['fecha_cita'],
                'observaciones' => $item['observaciones_cita'],
                'localidadCita' => $item['localidad_cita'],
                'servicioCita' => $item['servicio_cita'],
                'color' => $color,
                'nombrePaciente' => $nombrePaciente,
                'documentoPaciente' => $documentoPaciente
            );

            $datos[] = $evento;
        }

        return $datos;

    }

    static public function ctrTerminarGestionAgendamiento($datos){

        $tabla = "di_bolsa_pacientes";
        $hoy = date("Y-m-d H:i:s");

        $validarCitas = ModelAgendamiento::mdlValidarAgendamientoCitas($datos["id_bolsa_paciente"]);

        if(!empty($validarCitas)){

            $respuesta = ModelAgendamiento::mdlTerminarGestionAgendamiento($tabla, $datos, $hoy);

        }else{

            $respuesta = 'sin-registros-citas';

        }

        return $respuesta;

    }

    static public function ctrCrearCita($datos){

        $tabla = "di_agendamiento_citas";

        $respuesta = ModelAgendamiento::mdlCrearCita($tabla, $datos);

        return $respuesta;

    }

    static public function ctrCrearCitaBusqueda($datos){

        $tabla = "di_agendamiento_citas";

        $infoCita = ModelAgendamiento::mdlCrearCitaBusqueda($tabla, $datos);

        if($infoCita["status"] == 'ok'){

            $respGenerips = ControladorAgendamiento::ctrCrearCitaVidamedicalBusqueda($infoCita["data"]);

            return 'ok';

        }else{

            return 'error';

        }

    }

    static public function ctrCrearCitaVidamedicalBusqueda($datos){

        $infoPaciente = ControladorAgendamiento::ctrObtenerDato("pacientes", "id_paciente", $datos["id_paciente"]);

        $datosPacienteVidamedical = ControladorAgendamiento::ctrExistePacienteVidamedical($infoPaciente["tipo_documento"], $infoPaciente["numero_documento"]);

        if(empty($datosPacienteVidamedical)){

            $datosPaciente = ControladorAgendamiento::ctrTransformarInformacionVidamedical($infoPaciente);            

            $crearPaciente = ControladorAgendamiento::ctrCrearPacienteVidamedical($datosPaciente);

            if($crearPaciente == 'ok'){

                $datosPacienteVidamedical = ControladorAgendamiento::ctrExistePacienteVidamedical($infoPaciente["tipo_documento"], $infoPaciente["numero_documento"]);

                $idPaciente = $datosPacienteVidamedical["id_pac"];

            }else{

                $datosLog = array(
                    "proceso" => "BUSQUEDA-CITA",
                    "id_proceso" => $datos["id_cita"],
                    "error" => "error-save-paciente"
                ); 

                $log = ModelAgendamiento::mdlRegistrarLogVidaMedical($datosLog);

                return 'error-save-paciente';
                // return $crearPaciente;

            }

        }else{

            $idPaciente = $datosPacienteVidamedical["id_pac"];

        }

        //OBTENER ID CONCECUTIVO
        $infoConcecutivo = ModelAgendamiento::mdlConcecutivoMedicoGenerips();
            
        //OBTENER DATOS PROFESIONAL
        $datosProfesional = ControladorAgendamiento::ctrObtenerDato("par_profesionales", "id_profesional", $datos["id_profesional"]);

        //OBTENER DATOS GENERIPS
        $datosGenerips = ModelAgendamiento::mdlObtenerInfoMedicoGenerips($datosProfesional["doc_profesional"]);

        //OBTENER DATOS SERVICIO
        $datosServicio = ModelAgendamiento::mdlObtenerInfoServicio($datos["servicio_cita"]);

        if(!empty($datosGenerips)){

            $idMedGenerips = $datosGenerips["medico_nexus"];

        }else{

            $datosMed = array(
                "medico_nexus" => $infoConcecutivo["id_increment"],  
                "nombre_medico" => $datosProfesional["nombre_profesional"],
                "documento_medico" => $datosProfesional["doc_profesional"],
                "sede" => 1
            );

            //CREAR MEDICO GENERIPS NO EXISTE
            $crearMed = ModelAgendamiento::mdlCrearMedicoGenerips($datosMed);

            if($crearMed == 'ok'){

                $datosGenerips = ModelAgendamiento::mdlObtenerInfoMedicoGenerips($datosMed["documento_medico"]);

                $idMedGenerips = $datosGenerips["medico_nexus"];

            }else{

                $idMedGenerips = 0;

                //LOG ERRORES
                $datosLog = array(
                    "proceso" => "BUSQUEDA-CITA",
                    "id_proceso" => $datos["id_cita"],
                    "error" => "error-save-medico"
                ); 

                $log = ModelAgendamiento::mdlRegistrarLogVidaMedical($datosLog);

            }

        }


        $hora = $datos["franja_cita"] == 'AM' ? '08:00' : '14:00';

        $datosCita = array(
            "id_nexus" => $datos["id_cita"],
            "sede_nexus" => 1,
            "id_paciente" => $idPaciente,
            "fecha_nexus" => $datos["fecha_cita"],
            "solicitud_nexus" => $datos["fecha_cita"],
            "requerida_nexus" => $datos["fecha_cita"],
            "medico_nexus" => $idMedGenerips,
            "hora_nexus" => $hora,
            "servicio_nexus" => $datosServicio["id_par_servicio"],
            "estado_nexus" => 1,
            "actualiza_nexus" => 1,
            "data_nexus" => $datos["fecha_crea"]
        );

        $guardarCitaVidaMedical = ControladorAgendamiento::ctrGuardarCitaVidamedical($datosCita);

        if($guardarCitaVidaMedical != 'ok'){

            return 'error-save-cita';

        }


    }
    
    static public function crValidarDiaDisponible($idProfesional, $fechaCita){

        $respuesta = ModelAgendamiento::mdlValidarDiaDisponible($idProfesional, $fechaCita);

        return $respuesta;

    }

    static public function ctrValidarDisponibilidadMedicoCita($idProfesional, $fechaCita, $franjaCita){

        $diaDisponible = ControladorAgendamiento::crValidarDiaDisponible($idProfesional, $fechaCita);

        if(empty($diaDisponible)){

            $franja = $franjaCita == 'AM' ? 'CANTIDAD_CITAS_FRANJA_AM' : 'CANTIDAD_CITAS_FRANJA_PM';

            $tablaCantidad = "par_capacidades";
            $itemCantidad = "variable";

            $datosCantidades = ControladorAgendamiento::ctrObtenerDato($tablaCantidad, $itemCantidad, $franja);

            if(!empty($datosCantidades)){

                $datos = array(

                    "id_profesional" => $idProfesional,
                    "fecha_cita" => $fechaCita,
                    "franja_cita" => $franjaCita,
                    "cantidad_capacidad" => $datosCantidades["valor"]

                );

                $respuesta = ModelAgendamiento::mdlValidarDisponibilidadMedicoCita($datos);

                if(count($respuesta) < $datos["cantidad_capacidad"]){

                    $cupos = $datos["cantidad_capacidad"] - count($respuesta);

                    return array(

                        "respuesta" => "ok-disponibilidad",
                        "cupos" => $cupos

                    );

                }else{

                    return array(

                        "respuesta" => "no-disponibilidad",
                        "cupos" => 0

                    );

                }

            }else{

                return array(
                    
                    "respuesta" => "error-variable-capacidad",
                    "cupos" => 0
                    
                );

            }

        }else{

            return array(
                "respuesta" => "error-dia-no-disponible",
                "cupos" => 0
            );

        }

    }

    static public function ctrVerCitasPendientesPaciente($idPaciente){

        $respuesta = ModelAgendamiento::mdlVerCitasPendientesPaciente($idPaciente);

        return $respuesta;

    }

    static public function ctrListaComunicacionFallidasAgendamiento($idBolsaAgendamiento){

        $respuesta = ModelAgendamiento::mdlListaComunicacionFallidasAgendamiento($idBolsaAgendamiento);

        return $respuesta;

    }

    static public function ctrCrearComunicacionFallida($datos){

        $tabla = "di_bolsa_comunicaciones_fallidas";

        $datosAgendamiento = array(

            "id_bolsa_paciente" => $datos["id_bolsa_paciente"],
            "causal_fallida" => $datos["causal_fallida"],
            "observaciones" => strtoupper($datos["observaciones"]),
            "usuario_crea" => $datos["usuario_crea"]

        );

        $guardarComFallida = ModelAgendamiento::mdlCrearComunicacionFallida($tabla, $datosAgendamiento);

        if($guardarComFallida == "ok"){

            //OBTENER CAUSALES CANCELA
            $causalesCancela = ControladorAgendamiento::ctrObtenerCausalesComFallidaCancela();

            // if($datos["causal_fallida"] != 'NO ACEPTA VISITA'){

            if(!in_array($datos["causal_fallida"], $causalesCancela)){

                // $tablaCall = "call_center_bolsa";
                // $itemCall = "id_call";
                // $valorCall = $datos["id_call"];

                // $datosCall = ControladorCallCenter::ctrObtenerDato($tablaCall, $itemCall, $valorCall);

                $nuevoContadorGestiones = $datos["cantidad_gestiones"] + 1;

                $actualizarContador = ModelAgendamiento::mdlActualizarContadorGestiones($datos["id_bolsa_paciente"], $nuevoContadorGestiones);

                if($actualizarContador == "ok"){

                    $tablaCantidad = "par_variables_globales";
                    $itemCantidad = "variable";
                    $valorCantidad = "CANTIDAD_GESTIONES_AGENDAMIENTO";

                    $datosCantidades = ControladorAgendamiento::ctrObtenerDato($tablaCantidad, $itemCantidad, $valorCantidad);

                    if($nuevoContadorGestiones >= $datosCantidades["valor"]){

                        //CUMPLIO LA CANTIDAD DE GESTIONES, CERRAMOS EL PROCESO CALL

                        $tablaCall = "di_bolsa_pacientes";

                        $datosActualizar = array(

                            "id_bolsa_paciente" => $datos["id_bolsa_paciente"],
                            "estado" => "FALLIDA",
                            "fecha_fin" => date("Y-m-d H:i:s")

                        );

                        $estadoFallida = ModelAgendamiento::mdlActualizarEstadoFallidaCall($tablaCall, $datosActualizar);

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

                $tablaCall = "di_bolsa_pacientes";

                $datosActualizar = array(

                    "id_bolsa_paciente" => $datos["id_bolsa_paciente"],
                    "estado" => "FALLIDA",
                    "fecha_fin" => date("Y-m-d H:i:s")

                );

                $estadoFallida = ModelAgendamiento::mdlActualizarEstadoFallidaCall($tablaCall, $datosActualizar);

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

        $respuesta = ModelAgendamiento::mdlObtenerCausalesComFallidaCancela();

        $arrayCancela = [];

        foreach ($respuesta as $key => $value) {
            
            $arrayCancela[] = $value["descripcion"];

        }

        return $arrayCancela;

    }

    static public function ctrListaAgendamientoPendienteUser($user){

        $respuesta = ModelAgendamiento::mdlListaAgendamientoPendienteUser($user);

        return $respuesta;

    }

    static public function ctrValidarExistePaciente($idBolsaPaciente){

        $data = ControladorAgendamiento::ctrObtenerAgendamiento($idBolsaPaciente);

        if(!empty($data)){

            $respuesta = ModelAgendamiento::mdlValidarExistePaciente($data["tipo_doc"], $data["numero_documento"]);

            if(!empty($respuesta)){

                return "paciente-existe";

            }else{

                return "paciente-no-existe";

            }
        
        }

    }

    static public function ctrTomarAgendamiento($idBolsaPaciente, $asesor){

        $agendamientosUser = ControladorAgendamiento::ctrListaAgendamientoPendienteUser($asesor);

        $tablaCantidad = "par_variables_globales";
        $itemCantidad = "variable";
        $valorCantidad = "CANTIDAD_PENDIENTES_AGENDAMIENTO";

        $datosCantidades = ControladorAgendamiento::ctrObtenerDato($tablaCantidad, $itemCantidad, $valorCantidad);

        if(count($agendamientosUser) < $datosCantidades["valor"]){

            $data = ControladorAgendamiento::ctrObtenerAgendamiento($idBolsaPaciente);

            if(empty($data["asesor"]) && $data["estado"] == 'CREADA'){

                $hoy = date("Y-m-d H:i:s");

                $asignarAgendamiento = ModelAgendamiento::mdlAsignarAgendamiento($idBolsaPaciente, $asesor, $hoy);

                if($asignarAgendamiento == 'ok'){

                    //VALIDAR SI EXISTE USUARIO POR TIPO DOC Y NUMERO DOC

                    $pacienteExist = ModelAgendamiento::mdlValidarExisteDocumento("pacientes", $data["tipo_doc"], $data["numero_documento"]);

                    if(empty($pacienteExist)){

                        return array (
                            
                            "estado" => "ok-asignado"
                        
                        );

                    }else{

                        //ACTUALIZAR ID PACIENTE BOLSA PACIENTES
                        $actualizar = ModelAgendamiento::mdlActualizarPacienteBolsa($idBolsaPaciente, $pacienteExist["id_paciente"]);

                        if($actualizar == 'ok'){

                            return array(

                                "estado" => "ok-asignado-paciente",
                                "idPaciente" => $pacienteExist["id_paciente"]

                            );

                        }else{

                            return array (
                            
                                "estado" => "error-actualizando-paciente"
                            
                            );

                        }

                    }

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

    static public function ctrObtenerAgendamiento($idBolsaPaciente){

        $respuesta = ModelAgendamiento::mdlObtenerAgendamiento($idBolsaPaciente);

        return $respuesta;

    }

    static public function ctrListaAgendamientoBolsa($cohortePrograma){

        $respuesta = ModelAgendamiento::mdlListaAgendamientoBolsa($cohortePrograma);

        //var_dump($respuesta);

        return $respuesta;

    }

    static public function ctrListaBasesAgendamiento(){

        $respuesta = ModelAgendamiento::mdlListaBasesAgendamiento();

        return $respuesta;

    }

    static public function ctrObtenerArchivoCargar(){

        $tabla = "di_bases_pacientes";

        $respuesta = ModelAgendamiento::mdlObtenerArchivoCargar($tabla);

        return $respuesta;

    }

    static public function ctrCargarArchivoAgendamiento($datos){

        if(!empty($datos)){

            $Now = date('YmdHis');
			$ruta = "../../../archivos_nexuslink/di/agendamiento/archivos_bases_agendamiento/";
			$rutaErrores = "../../../archivos_nexuslink/di/agendamiento/archivos_bases_agendamiento/errores/";
			$nombreOriginal = $datos["archivo"]["name"];
			$nombreArchivo = $Now.$nombreOriginal;
			$rutaFin = $ruta.$nombreArchivo;
			$rutaFinErros = $rutaErrores.$nombreArchivo.".txt";

            move_uploaded_file ($datos["archivo"]["tmp_name"], $rutaFin);

            $objPHPExcel = PHPEXCEL_IOFactory::load($rutaFin);
            $objPHPExcel->setActiveSheetIndex(0);
            $NumColum = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
            $NumFilas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

            if($NumColum == 'O'){

                $tabla = "di_bases_pacientes";

                $datosAgendamiento = array(
                    "nombre" => strtoupper($datos["nombre_archivo"]),
                    "nombre_archivo_original" => $nombreOriginal,
                    "nombre_archivo" => $nombreArchivo,
                    "ruta_archivo" => $rutaFin,
                    "cantidad" => $NumFilas-1,
                    "estado" => "SUBIDA",
                    "usuario" => $datos["usuario"]
                );

                $guardarArchivo = ModelAgendamiento::mdlGuardarArchivoAgendamiento($tabla, $datosAgendamiento);

                if($guardarArchivo == 'ok'){

                    return 'ok';

                }else{

                    return $guardarArchivo;

                }

            }else{

                $archivoError = fopen("../../../archivos_nexuslink/di/agendamiento/archivos_bases_agendamiento/errores/" . $nombreArchivo . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

                fwrite($archivoError, $nombreArchivo . "\n");
                fwrite($archivoError, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
                fwrite($archivoError, "Validacion Cargue Base Agendamiento\n");
                fwrite($archivoError, "El archivo no posee la estructura adecuada de 15 columnas (O)\n");
                fwrite($archivoError, "------------------------ Fin Validacion-------------------------------------\n");

                return 'error-estructura';

            }


        }

    }

    static public function ctrObtenerDato($tabla, $item, $valor){

        $respuesta = ModelAgendamiento::mdlObtenerDato($tabla, $item, $valor);

        return $respuesta;

    }

    static public function ctrObtenerDatoNexusVidamedical($tabla, $item, $valor){

        $respuesta = ModelAgendamiento::mdlObtenerDatoNexusVidamedical($tabla, $item, $valor);

        return $respuesta;

    }

    static public function ctrExistePacienteVidamedical($tipoDoc, $numDoc){

        $respuesta = ModelAgendamiento::mdlExistePacienteVidamedical($tipoDoc, $numDoc);

        return $respuesta;

    }


}
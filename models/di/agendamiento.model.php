<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";

require_once $rutaConnection;

date_default_timezone_set('America/Bogota');

class ModelAgendamiento{

    static public function mdlBuscarPaciente($tipoDoc, $numeroDoc){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pacientes WHERE tipo_documento = :tipo_documento AND numero_documento = :numero_documento");

        $stmt->bindParam(":tipo_documento", $tipoDoc, PDO::PARAM_STR);
        $stmt->bindParam(":numero_documento", $numeroDoc, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoBolsaAgendamiento($idBolsaAgendamiento){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE id_bolsa_paciente = :id_bolsa_paciente");

        $stmt->bindParam(":id_bolsa_paciente", $idBolsaAgendamiento, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPacienteAgenda($datos){

        $stmt = Connection::connectOnly()->prepare("SELECT pacientes.id_paciente, CONCAT( pacientes.primer_nombre, ' ', pacientes.segundo_nombre, ' ', pacientes.primer_apellido, ' ', pacientes.segundo_apellido ) AS nombre_paciente, pacientes.tipo_documento, pacientes.numero_documento, regimen, direccion_ubicacion, telefono_uno_ubicacion FROM pacientes 
            WHERE pacientes.tipo_documento = :tipo_documento AND pacientes.numero_documento = :numero_documento");

        $stmt->bindParam(":tipo_documento", $datos["tipoDoc"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_documento", $datos["numeroDocumento"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

        
    }

    static public function mdlObtenerInfoServicio($servicioCita){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_par_servicios WHERE nombre_servicio = :nombre_servicio");

        $stmt->bindParam(":nombre_servicio", $servicioCita, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaAgendamientosBusqueda($tipoDocumento, $numeroDocumento){

        $stmt = Connection::connectOnly()->prepare("SELECT di_bases_pacientes.nombre, di_bolsa_pacientes.* FROM di_bolsa_pacientes JOIN di_bases_pacientes ON di_bolsa_pacientes.id_base = di_bases_pacientes.id_base 
            WHERE tipo_doc = :tipo_doc AND numero_documento = :numero_documento AND di_bolsa_pacientes.estado IN ('CREADA','PROCESO')");

        $stmt->bindParam(":tipo_doc", $tipoDocumento, PDO::PARAM_STR);
        $stmt->bindParam(":numero_documento", $numeroDocumento, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaAgendamientosPendienteUserCohorte($cohortePrograma, $user){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE asesor = :asesor AND estado = 'PROCESO' AND cohorte_programa = :cohorte_programa");

        $stmt->bindParam(":asesor", $user, PDO::PARAM_STR);
        $stmt->bindParam(":cohorte_programa", $cohortePrograma, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaBolsasAgendamientoUser($user){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_usuarios_bolsas_agendamiento JOIN di_cohortes_programas ON di_usuarios_bolsas_agendamiento.cohorte = di_cohortes_programas.cohorte_programa AND di_usuarios_bolsas_agendamiento.usuario = :usuario");

        $stmt->bindParam(":usuario", $user, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarAsignacionBolsaAgendamiento($idUsuBolsaAgend){

        $stmt = Connection::connectOnly()->prepare("DELETE FROM di_usuarios_bolsas_agendamiento WHERE id_usu_bolsa_agend = :id_usu_bolsa_agend");

        $stmt->bindParam(":id_usu_bolsa_agend", $idUsuBolsaAgend, PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaAsignacionesBolsasAgendamiento(){

        $stmt = Connection::connectOnly()->prepare("SELECT usuarios.nombre, di_usuarios_bolsas_agendamiento.* FROM di_usuarios_bolsas_agendamiento JOIN usuarios ON di_usuarios_bolsas_agendamiento.usuario = usuarios.usuario");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        
    }

    static public function mdlCrearAsignacionBolsa($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO di_usuarios_bolsas_agendamiento (usuario, cohorte, usuario_crea) VALUES (:usuario, :cohorte, :usuario_crea)");

        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":cohorte", $datos["cohorte"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlUsuarioAsignacionBolsaExiste($datos){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_usuarios_bolsas_agendamiento WHERE usuario = :usuario AND cohorte = :cohorte");

        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":cohorte", $datos["cohorte"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaUsuariosAgendamiento(){

        $stmt = Connection::connectOnly()->prepare("SELECT usuarios.nombre, usuarios.usuario FROM usuarios_permisos JOIN usuarios ON usuarios_permisos.usuario = usuarios.usuario WHERE id_menu = 10 AND usuarios.admin = 0 AND usuarios.estado = 1");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlConcecutivoMedicoGenerips(){

        $stmt = Connection::connectNexusVidamedical()->prepare("SELECT medico_nexus, medico_nexus + 1 AS id_increment FROM medicos ORDER BY medico_nexus DESC LIMIT 1");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;



    }

    static public function mdlListaProfesionalesAgendamiento(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM par_profesionales JOIN usuarios_cargos ON par_profesionales.id_profesional = usuarios_cargos.id_usuario WHERE estado = 1");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlRegistrarLogVidaMedical($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO log_transacciones_vidamedical (proceso, id_proceso, error) VALUES (:proceso, :id_proceso, :error)");

        $stmt->bindParam(":proceso", $datos["proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":error", $datos["error"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearMedicoGenerips($datos){

        $stmt = Connection::connectNexusVidamedical()->prepare("INSERT INTO medicos (nombre_medico, sede, documento_medico, medico_nexus) VALUES (:nombre_medico, :sede, :documento_medico, :medico_nexus)");

        $stmt->bindParam(":nombre_medico", $datos["nombre_medico"], PDO::PARAM_STR);
        $stmt->bindParam(":sede", $datos["sede"], PDO::PARAM_STR);
        $stmt->bindParam(":documento_medico", $datos["documento_medico"], PDO::PARAM_STR);
        $stmt->bindParam(":medico_nexus", $datos["medico_nexus"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlObtenerInfoMedicoGenerips($docProfesional){

        $stmt = Connection::connectNexusVidamedical()->prepare("SELECT * FROM medicos WHERE documento_medico = :documento_medico");

        $stmt->bindParam(":documento_medico", $docProfesional, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlCrearPacienteVidamedical($datos){

        $stmt = Connection::connectNexusVidamedical()->prepare("INSERT INTO tpacientes (tipoiden_pac,documento_pac,expedido_pac,ape1_pac,ape2_pac,nom1_pac,nom2_pac,tipousu_pac,sexo_pac,fechanac_pac,depa_pac,muni_pac,zona_pac,direccion_pac,barrio_pac,telefono1_pac,telefono2_pac,ocupacion_pac,observa_pac,entidad_pac,responsable_pac,parentesco_pac,direccion2_pac,telefono3_pac,ecivil_pac,madre_pac,padre_pac,sisben_pac,grupop_pac,petnica_pac,regimen_pac,dpto2_pac,muni2_pac,copago_pac,tipovin_pac,prestadir_pac,reclamamed_pac,escolar_pac,alias_pac,paquete_pac,ipsnot_pac,notifica_pac,fecnanoti_pac,ingresa,email_pac,rh,arl,eps,afp,pais,modera_fe,tipo_usu_fe) 
            VALUES (:tipoiden_pac,:documento_pac,:expedido_pac,:ape1_pac,:ape2_pac,:nom1_pac,:nom2_pac,:tipousu_pac,:sexo_pac,:fechanac_pac,:depa_pac,:muni_pac,:zona_pac,:direccion_pac,:barrio_pac,:telefono1_pac,:telefono2_pac,:ocupacion_pac,:observa_pac,:entidad_pac,:responsable_pac,:parentesco_pac,:direccion2_pac,:telefono3_pac,:ecivil_pac,:madre_pac,:padre_pac,:sisben_pac,:grupop_pac,:petnica_pac,:regimen_pac,:dpto2_pac,:muni2_pac,:copago_pac,:tipovin_pac,:prestadir_pac,:reclamamed_pac,:escolar_pac,:alias_pac,:paquete_pac,:ipsnot_pac,:notifica_pac,:fecnanoti_pac,:ingresa,:email_pac,:rh,:arl,:eps,:afp,:pais,:modera_fe,:tipo_usu_fe)");

        $stmt->bindParam(":tipoiden_pac", $datos["tipoiden_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":documento_pac", $datos["documento_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":expedido_pac", $datos["expedido_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":ape1_pac", $datos["ape1_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":ape2_pac", $datos["ape2_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":nom1_pac", $datos["nom1_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":nom2_pac", $datos["nom2_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":tipousu_pac", $datos["tipousu_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":sexo_pac", $datos["sexo_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":fechanac_pac", $datos["fechanac_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":depa_pac", $datos["depa_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":muni_pac", $datos["muni_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":zona_pac", $datos["zona_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_pac", $datos["direccion_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":barrio_pac", $datos["barrio_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono1_pac", $datos["telefono1_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono2_pac", $datos["telefono2_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":ocupacion_pac", $datos["ocupacion_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":observa_pac", $datos["observa_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":entidad_pac", $datos["entidad_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":responsable_pac", $datos["responsable_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":parentesco_pac", $datos["parentesco_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion2_pac", $datos["direccion2_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono3_pac", $datos["telefono3_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":ecivil_pac", $datos["ecivil_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":madre_pac", $datos["madre_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":padre_pac", $datos["padre_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":sisben_pac", $datos["sisben_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":grupop_pac", $datos["grupop_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":petnica_pac", $datos["petnica_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":regimen_pac", $datos["regimen_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":dpto2_pac", $datos["dpto2_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":muni2_pac", $datos["muni2_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":copago_pac", $datos["copago_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":tipovin_pac", $datos["tipovin_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":prestadir_pac", $datos["prestadir_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":reclamamed_pac", $datos["reclamamed_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":escolar_pac", $datos["escolar_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":alias_pac", $datos["alias_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":paquete_pac", $datos["paquete_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":ipsnot_pac", $datos["ipsnot_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":notifica_pac", $datos["notifica_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":fecnanoti_pac", $datos["fecnanoti_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":ingresa", $datos["ingresa"], PDO::PARAM_STR);
        $stmt->bindParam(":email_pac", $datos["email_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":rh", $datos["rh"], PDO::PARAM_STR);
        $stmt->bindParam(":arl", $datos["arl"], PDO::PARAM_STR);
        $stmt->bindParam(":eps", $datos["eps"], PDO::PARAM_STR);
        $stmt->bindParam(":afp", $datos["afp"], PDO::PARAM_STR);
        $stmt->bindParam(":pais", $datos["pais"], PDO::PARAM_STR);
        $stmt->bindParam(":modera_fe", $datos["modera_fe"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_usu_fe", $datos["tipo_usu_fe"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlGuardarCitaVidamedical($datos){

        $stmt = Connection::connectNexusVidamedical()->prepare("INSERT INTO tcitas_nexus (id_nexus, sede_nexus, id_paciente, fecha_nexus, solicitud_nexus, requerida_nexus, medico_nexus, hora_nexus, servicio_nexus, estado_nexus, actualiza_nexus, data_nexus) VALUES (:id_nexus, :sede_nexus, :id_paciente, :fecha_nexus, :solicitud_nexus, :requerida_nexus, :medico_nexus, :hora_nexus, :servicio_nexus, :estado_nexus, :actualiza_nexus, :data_nexus)");

        $stmt->bindParam(":id_nexus", $datos["id_nexus"], PDO::PARAM_STR);
        $stmt->bindParam(":sede_nexus", $datos["sede_nexus"], PDO::PARAM_STR);
        $stmt->bindParam(":id_paciente", $datos["id_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nexus", $datos["fecha_nexus"], PDO::PARAM_STR);
        $stmt->bindParam(":solicitud_nexus", $datos["solicitud_nexus"], PDO::PARAM_STR);
        $stmt->bindParam(":requerida_nexus", $datos["requerida_nexus"], PDO::PARAM_STR);
        $stmt->bindParam(":medico_nexus", $datos["medico_nexus"], PDO::PARAM_STR);
        $stmt->bindParam(":hora_nexus", $datos["hora_nexus"], PDO::PARAM_STR);
        $stmt->bindParam(":servicio_nexus", $datos["servicio_nexus"], PDO::PARAM_STR);
        $stmt->bindParam(":estado_nexus", $datos["estado_nexus"], PDO::PARAM_STR);
        $stmt->bindParam(":actualiza_nexus", $datos["actualiza_nexus"], PDO::PARAM_STR);
        $stmt->bindParam(":data_nexus", $datos["data_nexus"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlObtenerCausalesComFallidaCancela(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_causales_comunicaciones_fallidas WHERE gestion = 'CANCELA'");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerCitasAgendamiento($idBolsaAgendamiento){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_citas WHERE id_bolsa_agendamiento = $idBolsaAgendamiento");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearNoDisponibilidad($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO di_agendamiento_citas (id_profesional, id_paciente, id_bolsa_agendamiento, cohorte_programa, motivo_cita, fecha_cita, franja_cita, localidad_cita, observaciones_cita, usuario_crea, estado) VALUES (:id_profesional, 0, 0, 'NINGUNO', :motivo_cita, :fecha_cita, :franja_cita, :localidad_cita, :observaciones_cita, :usuario_crea, 'NO-DISPONIBLE')");

        $stmt->bindParam(":id_profesional", $datos["id_profesional"], PDO::PARAM_STR);
        $stmt->bindParam(":motivo_cita", $datos["motivo_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cita", $datos["fecha_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":franja_cita", $datos["franja_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":localidad_cita", $datos["localidad_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_cita", $datos["observaciones_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidarNoDisponibilidad($idProfesional, $fechaCita){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_citas WHERE id_profesional = $idProfesional AND fecha_cita = '$fechaCita' AND estado = 'NO-DISPONIBLE'");

        if($stmt->execute()){

            $datos = $stmt->fetchAll();

            if(!empty($datos)){

                return 'no-disponible-existe';

            }else{

                $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_citas WHERE id_profesional = $idProfesional AND fecha_cita = '$fechaCita' AND estado != 'NO-DISPONIBLE'");

                if($stmt->execute()){

                    $datos = $stmt->fetchAll();

                    if(!empty($datos)){

                        return 'citas-agendadas';

                    }else{

                        return 'ok-agendar-no-disponibilidad';

                    }

                }

            }

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlGuardarLogReAgendamiento($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_cita, data_antigua, data_nueva, usuario_crea) VALUES (:id_cita, :data_antigua, :data_nueva, :usuario_crea)");

        $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":data_antigua", $datos["data_antigua"], PDO::PARAM_STR);
        $stmt->bindParam(":data_nueva", $datos["data_nueva"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlReAgendarCita($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE di_agendamiento_citas SET id_profesional = :id_profesional, fecha_cita = :fecha_cita, franja_cita = :franja_cita, servicio_cita = :servicio_cita WHERE id_cita = :id_cita");

        $stmt->bindParam(":id_profesional", $datos["idProfesional"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cita", $datos["fechaCita"], PDO::PARAM_STR);
        $stmt->bindParam(":franja_cita", $datos["franjaCita"], PDO::PARAM_STR);
        $stmt->bindParam(":id_cita", $datos["idCita"], PDO::PARAM_STR);
        $stmt->bindParam(":servicio_cita", $datos["servicioCita"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlValidarDiaDisponible($idProfesional, $fechaCita){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_citas WHERE id_profesional = $idProfesional AND fecha_cita = '$fechaCita' AND franja_cita = 'NO-DISPONIBLE'");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
    }

    static public function mdlEliminarCita($idCita){

        $stmt = Connection::connectOnly()->prepare("DELETE FROM di_agendamiento_citas WHERE id_cita = $idCita");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        
    }

    static public function mdlCitaEliminadaLog($idCita, $usuario){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO di_agendamiento_citas_eliminadas (id_cita, id_profesional, id_paciente, id_bolsa_agendamiento, cohorte_programa, motivo_cita, fecha_cita, franja_cita, localidad_cita, observaciones_cita, usuario_crea, fecha_crea, estado, fecha_ini, fecha_fin, usuario_elimina)
            SELECT id_cita, id_profesional, id_paciente, id_bolsa_agendamiento, cohorte_programa, motivo_cita, fecha_cita, franja_cita, localidad_cita, observaciones_cita, usuario_crea, fecha_crea, estado, fecha_ini, fecha_fin, '$usuario'
            FROM di_agendamiento_citas WHERE id_cita = $idCita;");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlActualizarPacienteBolsa($idBolsaPaciente, $idPaciente){

        $stmt = Connection::connectOnly()->prepare("UPDATE di_bolsa_pacientes SET id_paciente = $idPaciente WHERE id_bolsa_paciente = $idBolsaPaciente");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlEliminarPrioridad($idPrioridad){

        $stmt = Connection::connectOnly()->prepare("DELETE FROM di_prioridades_bolsa_agendamiento WHERE id_prioridad = $idPrioridad");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPrioridadesAgendamiento(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_prioridades_bolsa_agendamiento ORDER BY prioridad ASC");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearPrioridad($cohortePrograma, $prioridad, $usuarioCrea){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO di_prioridades_bolsa_agendamiento (cohorte_programa, prioridad, usuario_crea) VALUES ('$cohortePrograma', '$prioridad', '$usuarioCrea')");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidarExistePrioridad($cohortePrograma, $prioridad){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_prioridades_bolsa_agendamiento WHERE cohorte_programa = '$cohortePrograma' OR prioridad = $prioridad");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
        
    }

    static public function mdlListaCohorteProgramas(){

        $stmt = Connection::connectOnly()->prepare("SELECT cohorte_programa FROM di_cohortes_programas WHERE estado = 1");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidarAgendamientoCitas($idBolsaPaciente){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_citas WHERE id_bolsa_agendamiento = $idBolsaPaciente");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarBolsaAgendamientoPaciente($idBolsaAgendamiento, $idPaciente){

        $stmt = Connection::connectOnly()->prepare("UPDATE di_bolsa_pacientes SET id_paciente = $idPaciente WHERE id_bolsa_paciente = $idBolsaAgendamiento");

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidaDatosPaciente($tipoDocumento, $numeroDocumento){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pacientes WHERE tipo_documento = '$tipoDocumento' AND numero_documento = '$numeroDocumento'");

        $stmt->execute();

        return $stmt->fetch();

        $stmt = null;

    }

    static public function mdlListaCitasCalendarProfesional($idProfesional){

        if(!empty($idProfesional)){

            $stmt = Connection::connectOnly()->prepare("SELECT nombre_profesional, di_agendamiento_citas.* FROM di_agendamiento_citas JOIN par_profesionales ON di_agendamiento_citas.id_profesional = par_profesionales.id_profesional WHERE di_agendamiento_citas.id_profesional = $idProfesional ORDER BY fecha_cita, franja_cita ASC");

            $stmt->execute();

            return $stmt->fetchAll();

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT nombre_profesional, di_agendamiento_citas.* FROM di_agendamiento_citas JOIN par_profesionales ON di_agendamiento_citas.id_profesional = par_profesionales.id_profesional ORDER BY fecha_cita, franja_cita ASC");

            $stmt->execute();

            return $stmt->fetchAll();

        }

        $stmt = null;

    }

    static public function mdlListaCitasCalendar(){

        $stmt = Connection::connectOnly()->prepare("SELECT nombre_profesional, di_agendamiento_citas.* FROM di_agendamiento_citas JOIN par_profesionales ON di_agendamiento_citas.id_profesional = par_profesionales.id_profesional ORDER BY fecha_cita, franja_cita ASC");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;

    }

    static public function mdlTerminarGestionAgendamiento($tabla, $datos, $hoy){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = :estado, fecha_fin = '$hoy' WHERE id_bolsa_paciente = :id_bolsa_paciente");

        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":id_bolsa_paciente", $datos["id_bolsa_paciente"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearCita($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_profesional, id_paciente, id_bolsa_agendamiento, motivo_cita, fecha_cita, franja_cita, cohorte_programa, observaciones_cita, localidad_cita, usuario_crea, servicio_cita) VALUES (:id_profesional, :id_paciente, :id_bolsa_agendamiento, :motivo_cita, :fecha_cita, :franja_cita, :cohorte_programa, :observaciones_cita, :localidad_cita, :usuario_crea, :servicio_cita)");

        $stmt->bindParam(":id_profesional", $datos["id_profesional"], PDO::PARAM_STR);
        $stmt->bindParam(":id_paciente", $datos["id_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":id_bolsa_agendamiento", $datos["id_bolsa_agendamiento"], PDO::PARAM_STR);
        $stmt->bindParam(":motivo_cita", $datos["motivo_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cita", $datos["fecha_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":franja_cita", $datos["franja_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_cita", $datos["observaciones_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":cohorte_programa", $datos["cohorte_programa"], PDO::PARAM_STR);
        $stmt->bindParam(":localidad_cita", $datos["localidad_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":servicio_cita", $datos["servicio_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearCitaBusqueda($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_profesional, id_paciente, id_bolsa_agendamiento, motivo_cita, fecha_cita, franja_cita, cohorte_programa, observaciones_cita, localidad_cita, usuario_crea, servicio_cita) VALUES (:id_profesional, :id_paciente, :id_bolsa_agendamiento, :motivo_cita, :fecha_cita, :franja_cita, :cohorte_programa, :observaciones_cita, :localidad_cita, :usuario_crea, :servicio_cita)");

        $stmt->bindParam(":id_profesional", $datos["id_profesional"], PDO::PARAM_STR);
        $stmt->bindParam(":id_paciente", $datos["id_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":id_bolsa_agendamiento", $datos["id_bolsa_agendamiento"], PDO::PARAM_STR);
        $stmt->bindParam(":motivo_cita", $datos["motivo_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cita", $datos["fecha_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":franja_cita", $datos["franja_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_cita", $datos["observaciones_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":cohorte_programa", $datos["cohorte_programa"], PDO::PARAM_STR);
        $stmt->bindParam(":localidad_cita", $datos["localidad_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":servicio_cita", $datos["servicio_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            $stmtCita = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_citas WHERE id_paciente = :id_paciente AND id_profesional = :id_profesional AND motivo_cita = :motivo_cita AND servicio_cita = :servicio_cita AND fecha_cita = :fecha_cita AND id_bolsa_agendamiento = :id_bolsa_agendamiento ORDER BY fecha_crea DESC LIMIT 1");

            $stmtCita->bindParam(":id_profesional", $datos["id_profesional"], PDO::PARAM_STR);
            $stmtCita->bindParam(":id_paciente", $datos["id_paciente"], PDO::PARAM_STR);
            $stmtCita->bindParam(":id_bolsa_agendamiento", $datos["id_bolsa_agendamiento"], PDO::PARAM_STR);
            $stmtCita->bindParam(":motivo_cita", $datos["motivo_cita"], PDO::PARAM_STR);
            $stmtCita->bindParam(":fecha_cita", $datos["fecha_cita"], PDO::PARAM_STR);
            $stmtCita->bindParam(":servicio_cita", $datos["servicio_cita"], PDO::PARAM_STR);

            if($stmtCita->execute()){

                return array(
                    "status" => "ok",
                    "data" => $stmtCita->fetch()
                );

            }else{

                return array(
                    "status" => "error",
                    "data" => $stmtCita->errorInfo()
                );

            }

            $stmt = null;

        }else{

            return array(
                "status" => "error",
                "data" => $stmt->errorInfo()
            );

        }

        $stmt = null;

    }

    static public function mdlValidarDisponibilidadMedicoCita($datos){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_citas WHERE id_profesional = :id_profesional AND fecha_cita = :fecha_cita AND franja_cita = :franja_cita");

        $stmt->bindParam(":id_profesional", $datos["id_profesional"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cita", $datos["fecha_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":franja_cita", $datos["franja_cita"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlVerCitasPendientesPaciente($idPaciente){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_citas WHERE id_paciente = $idPaciente AND estado = 'CREADA' ORDER BY fecha_cita, franja_cita ASC");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;

    }

    static public function mdlListaComunicacionFallidasAgendamiento($idBolsaAgendamiento){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_comunicaciones_fallidas WHERE id_bolsa_paciente = $idBolsaAgendamiento");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearComunicacionFallida($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_bolsa_paciente, causal_fallida, observaciones, usuario_crea) VALUES (:id_bolsa_paciente, :causal_fallida, :observaciones, :usuario_crea)");

        $stmt->bindParam(":id_bolsa_paciente", $datos["id_bolsa_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":causal_fallida", $datos["causal_fallida"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarEstadoFallidaCall($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = :estado, fecha_fin = :fecha_fin WHERE id_bolsa_paciente = :id_bolsa_paciente");

        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":id_bolsa_paciente", $datos["id_bolsa_paciente"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }

    static public function mdlActualizarContadorGestiones($idBolsaAgendamiento, $nuevoContadorGestiones){

        $stmt = Connection::connectOnly()->prepare("UPDATE di_bolsa_pacientes SET contador_gestiones = $nuevoContadorGestiones WHERE id_bolsa_paciente = $idBolsaAgendamiento");

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


    static public function mdlListaAgendamientoPendienteUser($user){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE asesor = '$user' AND estado = 'PROCESO'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidarExistePaciente($tipoDoc, $numeroDocumento){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pacientes WHERE tipo_documento = '$tipoDoc' AND numero_documento = '$numeroDocumento'");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAsignarAgendamiento($idBolsaPaciente, $asesor, $fechaIni){

        $stmt = Connection::connectOnly()->prepare("UPDATE di_bolsa_pacientes SET asesor = '$asesor', estado = 'PROCESO', fecha_ini = '$fechaIni' WHERE id_bolsa_paciente = $idBolsaPaciente");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerAgendamiento($idBolsaPaciente){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE id_bolsa_paciente = $idBolsaPaciente");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }

    static public function mdlListaAgendamientoBolsa($cohortePrograma){

        //$stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE di_bolsa_pacientes.estado = 'CREADA' AND asesor IS NULL ORDER BY fecha_base ASC LIMIT 1");

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE di_bolsa_pacientes.estado = 'CREADA' AND asesor IS NULL AND cohorte_programa = :cohorte_programa LIMIT 1");

        $stmt->bindParam(":cohorte_programa", $cohortePrograma, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }

    static public function mdlListaBasesAgendamiento(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bases_pacientes ORDER BY id_base DESC");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
        
    }

    static public function mdlCrearPacienteTemp($datos){

        $stmt = Connection::connectBatch()->prepare("INSERT INTO di_bolsa_pacientes(id_base, fecha_base, agrupador_ips, ips, nombre_completo, edad_anios, sexo, tipo_doc, numero_documento, regimen, numero_celular, numero_fijo, direccion, cohorte_programa, grupo_riesgo, equipo_profesional) VALUES (:id_base, :fecha_base, :agrupador_ips, :ips, :nombre_completo, :edad_anios, :sexo, :tipo_doc, :numero_documento, :regimen, :numero_celular, :numero_fijo, :direccion, :cohorte_programa, :grupo_riesgo, :equipo_profesional)");

        $stmt->bindParam(":id_base", $datos["id_base"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_base", $datos["fecha_base"], PDO::PARAM_STR);
        $stmt->bindParam(":agrupador_ips", $datos["agrupador_ips"], PDO::PARAM_STR);
        $stmt->bindParam(":ips", $datos["ips"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_completo", $datos["nombre_completo"], PDO::PARAM_STR);
        $stmt->bindParam(":edad_anios", $datos["edad_anios"], PDO::PARAM_STR);
        $stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_doc", $datos["tipo_doc"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_documento", $datos["numero_documento"], PDO::PARAM_STR);
        $stmt->bindParam(":regimen", $datos["regimen"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_celular", $datos["numero_celular"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_fijo", $datos["numero_fijo"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":cohorte_programa", $datos["cohorte_programa"], PDO::PARAM_STR);
        $stmt->bindParam(":grupo_riesgo", $datos["grupo_riesgo"], PDO::PARAM_STR);
        $stmt->bindParam(":equipo_profesional", $datos["equipo_profesional"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarBaseAgendamiento($proceso, $datos){

        if($proceso == "ERROR"){

            $stmt = Connection::connectOnly()->prepare("UPDATE di_bases_pacientes SET ruta_archivo_errors = :ruta_archivo_errors, estado = :estado, fecha_fin_valida = :fecha_fin_valida WHERE id_base = :id_base");

            $stmt->bindParam(":ruta_archivo_errors", $datos["ruta_archivo_errors"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_fin_valida", $datos["fecha_fin_valida"], PDO::PARAM_STR);
            $stmt->bindParam(":id_base", $datos["id_base"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else if($proceso == "ERROR_CARGA"){
        
            $stmt = Connection::connectOnly()->prepare("UPDATE di_bases_pacientes SET fecha_fin_carga = :fecha_fin_carga, estado = :estado, ruta_archivo_errors = :ruta_archivo_errors WHERE id_base = :id_base");

            $stmt->bindParam(":fecha_fin_carga", $datos["fecha_fin_carga"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
            $stmt->bindParam(":ruta_archivo_errors", $datos["ruta_archivo_errors"], PDO::PARAM_STR);
            $stmt->bindParam(":id_base", $datos["id_base"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;
        
        }else if($proceso == "CARGAR"){

            $stmt = Connection::connectOnly()->prepare("UPDATE di_bases_pacientes SET fecha_fin_valida = :fecha_fin_valida, estado = :estado WHERE id_base = :id_base");

            $stmt->bindParam(":fecha_fin_valida", $datos["fecha_fin_valida"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
            $stmt->bindParam(":id_base", $datos["id_base"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else if($proceso == "CARGADO"){

            $stmt = Connection::connectOnly()->prepare("UPDATE di_bases_pacientes SET fecha_fin_carga = :fecha_fin_carga, estado = :estado WHERE id_base = :id_base");

            $stmt->bindParam(":fecha_fin_carga", $datos["fecha_fin_carga"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
            $stmt->bindParam(":id_base", $datos["id_base"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }

    }

    static public function mdlObtenerArchivoCargar($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE estado = 'SUBIDA' ORDER BY fecha_crea ASC LIMIT 1");

        $stmt->execute();

        return $stmt->fetch();

        $stmt = null;

    }

    static public function mdlGuardarArchivoAgendamiento($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla(nombre, nombre_archivo_original, nombre_archivo, ruta_archivo, cantidad, estado, usuario) VALUES (:nombre, :nombre_archivo_original, :nombre_archivo, :ruta_archivo, :cantidad, :estado, :usuario)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_archivo_original", $datos["nombre_archivo_original"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_archivo", $datos["nombre_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerDato($tabla, $item, $valor){

        if($item != null){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();


        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();

        }

        $stmt = null;

    }

    static public function mdlValidarExisteDocumento($tabla, $tipoDocumento, $numDocumento){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE tipo_documento = '$tipoDocumento' AND numero_documento = '$numDocumento'");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerDatoNexusVidamedical($tabla, $item, $valor){

        if($item != null){

            $stmt = Connection::connectNexusVidamedical()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();


        }else{

            $stmt = Connection::connectNexusVidamedical()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();

        }

        $stmt = null;

    }

    static public function mdlExistePacienteVidamedical($tipoDoc, $numDoc){

        $stmt = Connection::connectNexusVidamedical()->prepare("SELECT * FROM tpacientes WHERE tipoiden_pac = '$tipoDoc' AND documento_pac = '$numDoc'");

        $stmt->execute();

		return $stmt->fetch();

    }

}
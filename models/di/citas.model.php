<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";

require_once $rutaConnection;

date_default_timezone_set('America/Bogota');

class ModelCitas{

    static public function mdlGuardarGestionCitaFallida($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET observaciones_fallida = :observaciones_fallida, fecha_fin = CURRENT_TIME, estado = 'FALLIDA' WHERE id_cita = :id_cita");

        $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_fallida", $datos["observaciones_fallida"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarPreCita($idPreCita){

        $stmt = Connection::connectOnly()->prepare("DELETE FROM di_agendamiento_pre_citas WHERE id_pre_cita = :id_pre_cita");

        $stmt->bindParam(":id_pre_cita", $idPreCita, PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPreCitasCita($idCita){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_pre_citas WHERE id_cita = $idCita");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCitasProcesoProfesional($idProfesional){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_citas WHERE id_profesional = $idProfesional AND estado = 'PROCESO'");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlTerminarGestionPreCita($tabla, $datos, $hoy){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = :estado, fecha_fin = '$hoy' WHERE id_pre_cita = :id_pre_cita");

        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":id_pre_cita", $datos["id_pre_cita"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidarAgendamientoCitasPreCitas($idPreCita){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_pre_citas_citas WHERE id_pre_cita = $idPreCita");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarEstadoFallidaCall($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = :estado, fecha_fin = :fecha_fin WHERE id_pre_cita = :id_pre_cita");

        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":id_pre_cita", $datos["id_pre_cita"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }


    static public function mdlActualizarContadorGestiones($idPreCita, $nuevoContadorGestiones){

        $stmt = Connection::connectOnly()->prepare("UPDATE di_agendamiento_pre_citas SET contador_gestiones = $nuevoContadorGestiones WHERE id_pre_cita = $idPreCita");

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearComunicacionFallida($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_pre_cita, causal_fallida, observaciones, usuario_crea) VALUES (:id_pre_cita, :causal_fallida, :observaciones, :usuario_crea)");

        $stmt->bindParam(":id_pre_cita", $datos["id_pre_cita"], PDO::PARAM_STR);
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

    static public function mdlObtenerCausalesComFallidaCancela(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_causales_comunicaciones_fallidas WHERE gestion = 'CANCELA'");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarIntermerdia($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO di_pre_citas_citas (id_pre_cita, id_cita) VALUES (:id_pre_cita, :id_cita)");

        $stmt->bindParam(":id_pre_cita", $datos["id_pre_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerInfoCitaPreCita($datos){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_citas WHERE id_paciente = :id_paciente AND id_profesional = :id_profesional AND cohorte_programa = :cohorte_programa AND fecha_cita = :fecha_cita ORDER BY id_cita DESC");

        $stmt->bindParam(":id_paciente", $datos["id_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":id_profesional", $datos["id_profesional"], PDO::PARAM_STR);
        $stmt->bindParam(":cohorte_programa", $datos["cohorte_programa"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cita", $datos["fecha_cita"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }

    static public function mdlCrearCitaPreCita($tabla, $datos){

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
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":servicio_cita", $datos["servicio_cita"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAsignarPreCita($idPreCita, $asesor, $fechaIni){

        $stmt = Connection::connectOnly()->prepare("UPDATE di_agendamiento_pre_citas SET asesor = '$asesor', estado = 'PROCESO', fecha_ini = '$fechaIni' WHERE id_pre_cita = $idPreCita");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerPreCita($idPreCita){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_pre_citas WHERE id_pre_cita = $idPreCita");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }
        
        $stmt = null;

    }

    static public function mdlListaPreCitasPendienteUser($user){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_agendamiento_pre_citas WHERE asesor = '$user' AND estado = 'PROCESO'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPendientesPreCitasUser($user){

        $stmt = Connection::connectOnly()->prepare("SELECT CONCAT(pacientes.primer_nombre, ' ', pacientes.segundo_nombre, ' ', pacientes.primer_apellido, ' ', pacientes.segundo_apellido) AS nombre_paciente, pacientes.tipo_documento, pacientes.numero_documento, CONCAT(pacientes.telefono_uno_ubicacion, '-', pacientes.telefono_dos_ubicacion) AS numero_celular, pacientes.direccion_ubicacion, di_agendamiento_pre_citas.* FROM di_agendamiento_pre_citas JOIN pacientes ON di_agendamiento_pre_citas.id_paciente = pacientes.id_paciente WHERE di_agendamiento_pre_citas.estado = 'PROCESO' AND asesor = '$user'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaComunicacionFallidasPreCitas($idPreCita){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_pre_citas_comunicaciones_fallidas WHERE id_pre_cita = $idPreCita");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaBolsaPreCitas(){

        $stmt = Connection::connectOnly()->prepare("SELECT CONCAT(pacientes.primer_nombre, ' ', pacientes.segundo_nombre, ' ', pacientes.primer_apellido, ' ', pacientes.segundo_apellido) AS nombre_paciente, pacientes.tipo_documento, pacientes.numero_documento, CONCAT(pacientes.telefono_uno_ubicacion, '-', pacientes.telefono_dos_ubicacion) AS numero_celular, pacientes.direccion_ubicacion, di_agendamiento_pre_citas.*, DATEDIFF(fecha_cita, NOW()) AS diff_dias FROM di_agendamiento_pre_citas JOIN pacientes ON di_agendamiento_pre_citas.id_paciente = pacientes.id_paciente WHERE di_agendamiento_pre_citas.estado = 'CREADA' AND asesor IS NULL");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearPreCita($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_paciente, id_cita, motivo_cita, fecha_cita, franja_cita, observaciones_cita, usuario_crea) VALUES (:id_paciente, :id_cita, :motivo_cita, :fecha_cita, :franja_cita, :observaciones_cita, :usuario_crea)");

        $stmt->bindParam(":id_paciente", $datos["id_paciente"], PDO::PARAM_STR);
        $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":motivo_cita", $datos["motivo_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cita", $datos["fecha_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":franja_cita", $datos["franja_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_cita", $datos["observaciones_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";

        }else{

            return $stmt->errorInfo();

        }

    }

    static public function mdlListaCitasPaciente($datos){

        $stmt = Connection::connectOnly()->prepare("SELECT CONCAT(pacientes.primer_nombre, ' ', pacientes.segundo_nombre, ' ', pacientes.primer_apellido, ' ', pacientes.segundo_apellido) AS nombre_paciente,
            pacientes.tipo_documento, pacientes.numero_documento, nombre_profesional, di_agendamiento_citas.* FROM di_agendamiento_citas JOIN par_profesionales ON di_agendamiento_citas.id_profesional = par_profesionales.id_profesional JOIN pacientes ON di_agendamiento_citas.id_paciente = pacientes.id_paciente
            WHERE di_agendamiento_citas.estado IN ('CREADA','PROCESO') AND franja_cita IN ('AM', 'PM') AND pacientes.tipo_documento = :tipo_documento AND pacientes.numero_documento = :numero_documento ORDER BY fecha_cita, franja_cita ASC");

        $stmt->bindParam(":tipo_documento", $datos["tipoDoc"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_documento", $datos["numeroDocumento"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlGuardarGestionFormularioCita($datos){

        if($datos["formulario"] == 'VACUNACION'){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO di_citas_vacunaciones (id_cita, vacuna_administrada, dosis_administrada, fecha_administracion, observaciones, usuario_crea) VALUES (:id_cita, :vacuna_administrada, :dosis_administrada, :fecha_administracion, :observaciones, :usuario_crea)");

            $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
            $stmt->bindParam(":vacuna_administrada", $datos["vacuna_administrada"], PDO::PARAM_STR);
            $stmt->bindParam(":dosis_administrada", $datos["dosis_administrada"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_administracion", $datos["fecha_administracion"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";

            }else{

                return $stmt->errorInfo();

            }

        }else if($datos["formulario"] == 'SALUD INFANTIL'){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO di_citas_salud_infantil (id_cita, peso, talla, perimetro_braquial, lactancia_materna_exclusiva, consejeria_lactancia_materna, verificacion_esque_pai_covid, soporte_nutricional, nombre_soporte_nutricional, formulacion_apme, entrega_apme, oximetria, sintomatologia_respiratoria, condiciones_riesgo, educacion_signos_alarma, remision_urgencias, remision_especialidades, remision_manejo_intramural, usuario_crea) VALUES (:id_cita, :peso, :talla, :perimetro_braquial, :lactancia_materna_exclusiva, :consejeria_lactancia_materna, :verificacion_esque_pai_covid, :soporte_nutricional, :nombre_soporte_nutricional, :formulacion_apme, :entrega_apme, :oximetria, :sintomatologia_respiratoria, :condiciones_riesgo, :educacion_signos_alarma, :remision_urgencias, :remision_especialidades, :remision_manejo_intramural, :usuario_crea)");

            $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
            $stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
            $stmt->bindParam(":talla", $datos["talla"], PDO::PARAM_STR);
            $stmt->bindParam(":perimetro_braquial", $datos["perimetro_braquial"], PDO::PARAM_STR);
            $stmt->bindParam(":lactancia_materna_exclusiva", $datos["lactancia_materna_exclusiva"], PDO::PARAM_STR);
            $stmt->bindParam(":consejeria_lactancia_materna", $datos["consejeria_lactancia_materna"], PDO::PARAM_STR);
            $stmt->bindParam(":verificacion_esque_pai_covid", $datos["verificacion_esque_pai_covid"], PDO::PARAM_STR);
            $stmt->bindParam(":soporte_nutricional", $datos["soporte_nutricional"], PDO::PARAM_STR);
            $stmt->bindParam(":nombre_soporte_nutricional", $datos["nombre_soporte_nutricional"], PDO::PARAM_STR);
            $stmt->bindParam(":formulacion_apme", $datos["formulacion_apme"], PDO::PARAM_STR);
            $stmt->bindParam(":entrega_apme", $datos["entrega_apme"], PDO::PARAM_STR);
            $stmt->bindParam(":oximetria", $datos["oximetria"], PDO::PARAM_STR);
            $stmt->bindParam(":sintomatologia_respiratoria", $datos["sintomatologia_respiratoria"], PDO::PARAM_STR);
            $stmt->bindParam(":condiciones_riesgo", $datos["condiciones_riesgo"], PDO::PARAM_STR);
            $stmt->bindParam(":educacion_signos_alarma", $datos["educacion_signos_alarma"], PDO::PARAM_STR);
            $stmt->bindParam(":remision_urgencias", $datos["remision_urgencias"], PDO::PARAM_STR);
            $stmt->bindParam(":remision_especialidades", $datos["remision_especialidades"], PDO::PARAM_STR);
            $stmt->bindParam(":remision_manejo_intramural", $datos["remision_manejo_intramural"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";

            }else{

                return $stmt->errorInfo();

            }

        }else if($datos["formulario"] == 'MATERNO PERINATAL Y SSR'){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO di_citas_materno_perinatal (id_cita, tamizaje_salud_mental, educacion_individual_familiar, inicio_referencia_contrareferencia, notificacion_inmediata_alertas, consulta_gestante, verificacion_cpn_vacunacion, identificacion_riesgo, realizacion_estrategia_etmi_plus, verificacion_administracion_pnc, captacion_pareja_tratamiento_sifilis_congenita, orden_provision_preservativos, educacion_signos_alarma, notificacion_cohorte_mp, asesoria_planificacion_familiar, demanda_inducida_pf, demanda_inducida_preconcepcional, disentimiento_pnf_cita_percepcional, estado_caso, observaciones, usuario_crea) VALUES (:id_cita, :tamizaje_salud_mental, :educacion_individual_familiar, :inicio_referencia_contrareferencia, :notificacion_inmediata_alertas, :consulta_gestante, :verificacion_cpn_vacunacion, :identificacion_riesgo, :realizacion_estrategia_etmi_plus, :verificacion_administracion_pnc, :captacion_pareja_tratamiento_sifilis_congenita, :orden_provision_preservativos, :educacion_signos_alarma, :notificacion_cohorte_mp, :asesoria_planificacion_familiar, :demanda_inducida_pf, :demanda_inducida_preconcepcional, :disentimiento_pnf_cita_percepcional, :estado_caso, :observaciones, :usuario_crea)");

            $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
            $stmt->bindParam(":tamizaje_salud_mental", $datos["tamizaje_salud_mental"], PDO::PARAM_STR);
            $stmt->bindParam(":educacion_individual_familiar", $datos["educacion_individual_familiar"], PDO::PARAM_STR);
            $stmt->bindParam(":inicio_referencia_contrareferencia", $datos["inicio_referencia_contrareferencia"], PDO::PARAM_STR);
            $stmt->bindParam(":notificacion_inmediata_alertas", $datos["notificacion_inmediata_alertas"], PDO::PARAM_STR);
            $stmt->bindParam(":consulta_gestante", $datos["consulta_gestante"], PDO::PARAM_STR);
            $stmt->bindParam(":verificacion_cpn_vacunacion", $datos["verificacion_cpn_vacunacion"], PDO::PARAM_STR);
            $stmt->bindParam(":identificacion_riesgo", $datos["identificacion_riesgo"], PDO::PARAM_STR);
            $stmt->bindParam(":realizacion_estrategia_etmi_plus", $datos["realizacion_estrategia_etmi_plus"], PDO::PARAM_STR);
            $stmt->bindParam(":verificacion_administracion_pnc", $datos["verificacion_administracion_pnc"], PDO::PARAM_STR);
            $stmt->bindParam(":captacion_pareja_tratamiento_sifilis_congenita", $datos["captacion_pareja_tratamiento_sifilis_congenita"], PDO::PARAM_STR);
            $stmt->bindParam(":orden_provision_preservativos", $datos["orden_provision_preservativos"], PDO::PARAM_STR);
            $stmt->bindParam(":educacion_signos_alarma", $datos["educacion_signos_alarma"], PDO::PARAM_STR);
            $stmt->bindParam(":notificacion_cohorte_mp", $datos["notificacion_cohorte_mp"], PDO::PARAM_STR);
            $stmt->bindParam(":asesoria_planificacion_familiar", $datos["asesoria_planificacion_familiar"], PDO::PARAM_STR);
            $stmt->bindParam(":demanda_inducida_pf", $datos["demanda_inducida_pf"], PDO::PARAM_STR);
            $stmt->bindParam(":demanda_inducida_preconcepcional", $datos["demanda_inducida_preconcepcional"], PDO::PARAM_STR);
            $stmt->bindParam(":disentimiento_pnf_cita_percepcional", $datos["disentimiento_pnf_cita_percepcional"], PDO::PARAM_STR);
            $stmt->bindParam(":estado_caso", $datos["estado_caso"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";

            }else{

                return $stmt->errorInfo();

            }
        
        }else if($datos["formulario"] == "CRONICOS"){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO di_citas_cronicos (id_cita, tf, too, tl, tr, psicologia, trabajo_social, nutricion, toma_laboratorios, numero_proximo_control, especificacion_proximo_control, clinica_heridas, cambio_sonda, phd_cronicos_agudizados, suspende_tratamiento, finaliza_tratamiento, cambio_manejo, inicia, termina, observaciones, usuario_crea) VALUES (:id_cita, :tf, :too, :tl, :tr, :psicologia, :trabajo_social, :nutricion, :toma_laboratorios, :numero_proximo_control, :especificacion_proximo_control, :clinica_heridas, :cambio_sonda, :phd_cronicos_agudizados, :suspende_tratamiento, :finaliza_tratamiento, :cambio_manejo, :inicia, :termina, :observaciones, :usuario_crea)");

            $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
            $stmt->bindParam(":tf", $datos["tf"], PDO::PARAM_STR);
            $stmt->bindParam(":too", $datos["too"], PDO::PARAM_STR);
            $stmt->bindParam(":tl", $datos["tl"], PDO::PARAM_STR);
            $stmt->bindParam(":tr", $datos["tr"], PDO::PARAM_STR);
            $stmt->bindParam(":psicologia", $datos["psicologia"], PDO::PARAM_STR);
            $stmt->bindParam(":trabajo_social", $datos["trabajo_social"], PDO::PARAM_STR);
            $stmt->bindParam(":nutricion", $datos["nutricion"], PDO::PARAM_STR);
            $stmt->bindParam(":toma_laboratorios", $datos["toma_laboratorios"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_proximo_control", $datos["numero_proximo_control"], PDO::PARAM_STR);
            $stmt->bindParam(":especificacion_proximo_control", $datos["especificacion_proximo_control"], PDO::PARAM_STR);
            $stmt->bindParam(":clinica_heridas", $datos["clinica_heridas"], PDO::PARAM_STR);
            $stmt->bindParam(":cambio_sonda", $datos["cambio_sonda"], PDO::PARAM_STR);
            $stmt->bindParam(":phd_cronicos_agudizados", $datos["phd_cronicos_agudizados"], PDO::PARAM_STR);
            $stmt->bindParam(":suspende_tratamiento", $datos["suspende_tratamiento"], PDO::PARAM_STR);
            $stmt->bindParam(":finaliza_tratamiento", $datos["finaliza_tratamiento"], PDO::PARAM_STR);
            $stmt->bindParam(":cambio_manejo", $datos["cambio_manejo"], PDO::PARAM_STR);
            $stmt->bindParam(":inicia", $datos["inicia"], PDO::PARAM_STR);
            $stmt->bindParam(":termina", $datos["termina"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";

            }else{

                return $stmt->errorInfo();

            }

        }else if($datos["formulario"] == "PHD"){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO di_citas_phd (id_cita, tf, too, tl, tr, succion, toma_laboratorios, numero_proximo_control, especificacion_proximo_control, clinica_heridas, cambio_sonda, suspende_tratamiento, finaliza_tratamiento, cambio_manejo, observaciones, usuario_crea) VALUES (:id_cita, :tf, :too, :tl, :tr, :succion, :toma_laboratorios, :numero_proximo_control, :especificacion_proximo_control, :clinica_heridas, :cambio_sonda, :suspende_tratamiento, :finaliza_tratamiento, :cambio_manejo, :observaciones, :usuario_crea)");

            $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
            $stmt->bindParam(":tf", $datos["tf"], PDO::PARAM_STR);
            $stmt->bindParam(":too", $datos["too"], PDO::PARAM_STR);
            $stmt->bindParam(":tl", $datos["tl"], PDO::PARAM_STR);
            $stmt->bindParam(":tr", $datos["tr"], PDO::PARAM_STR);
            $stmt->bindParam(":succion", $datos["succion"], PDO::PARAM_STR);
            $stmt->bindParam(":toma_laboratorios", $datos["toma_laboratorios"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_proximo_control", $datos["numero_proximo_control"], PDO::PARAM_STR);
            $stmt->bindParam(":especificacion_proximo_control", $datos["especificacion_proximo_control"], PDO::PARAM_STR);
            $stmt->bindParam(":clinica_heridas", $datos["clinica_heridas"], PDO::PARAM_STR);
            $stmt->bindParam(":cambio_sonda", $datos["cambio_sonda"], PDO::PARAM_STR);
            $stmt->bindParam(":suspende_tratamiento", $datos["suspende_tratamiento"], PDO::PARAM_STR);
            $stmt->bindParam(":finaliza_tratamiento", $datos["finaliza_tratamiento"], PDO::PARAM_STR);
            $stmt->bindParam(":cambio_manejo", $datos["cambio_manejo"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";

            }else{

                return $stmt->errorInfo();

            }

        }else if($datos["formulario"] == "ANTICOAGULADOS"){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO di_citas_anticoagulados (id_cita, tf, too, tl, tr, succion, toma_laboratorios, fecha_toma_laboratorios, clinica_heridas, cambio_sonda, salida, continua, reingreso, observaciones, usuario_crea) VALUES (:id_cita, :tf, :too, :tl, :tr, :succion, :toma_laboratorios, :fecha_toma_laboratorios, :clinica_heridas, :cambio_sonda, :salida, :continua, :reingreso, :observaciones, :usuario_crea)");

            $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
            $stmt->bindParam(":tf", $datos["tf"], PDO::PARAM_STR);
            $stmt->bindParam(":too", $datos["too"], PDO::PARAM_STR);
            $stmt->bindParam(":tl", $datos["tl"], PDO::PARAM_STR);
            $stmt->bindParam(":tr", $datos["tr"], PDO::PARAM_STR);
            $stmt->bindParam(":succion", $datos["succion"], PDO::PARAM_STR);
            $stmt->bindParam(":toma_laboratorios", $datos["toma_laboratorios"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_toma_laboratorios", $datos["fecha_toma_laboratorios"], PDO::PARAM_STR);
            $stmt->bindParam(":clinica_heridas", $datos["clinica_heridas"], PDO::PARAM_STR);
            $stmt->bindParam(":cambio_sonda", $datos["cambio_sonda"], PDO::PARAM_STR);
            $stmt->bindParam(":salida", $datos["salida"], PDO::PARAM_STR);
            $stmt->bindParam(":continua", $datos["continua"], PDO::PARAM_STR);
            $stmt->bindParam(":reingreso", $datos["reingreso"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";

            }else{

                return $stmt->errorInfo();

            }


        }else if($datos["formulario"] == 'NUTRICION'){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO di_citas_nutricion(id_cita, valoracion_nutricional, proximo_control, numero_fecha, especificacion_fecha, educacion_individual_familiar, consulta_gestante, verificacion_cpn_vacunacion, realizacion_estrategia_etmi, soporte_nutricional, nombre_soporte, usuario_gastrostomia, perimetro_abd, perimetro_pantorrilla, perimetro_braquial, imc, peso, talla, remision_seguimiento, educacion_signos_alarma, notificacion_inmediata_alertas, observaciones, usuario_crea) VALUES (:id_cita, :valoracion_nutricional, :proximo_control, :numero_fecha, :especificacion_fecha, :educacion_individual_familiar, :consulta_gestante, :verificacion_cpn_vacunacion, :realizacion_estrategia_etmi, :soporte_nutricional, :nombre_soporte, :usuario_gastrostomia, :perimetro_abd, :perimetro_pantorrilla, :perimetro_braquial, :imc, :peso, :talla, :remision_seguimiento, :educacion_signos_alarma, :notificacion_inmediata_alertas, :observaciones, :usuario_crea)");

            $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
            $stmt->bindParam(":valoracion_nutricional", $datos["valoracion_nutricional"], PDO::PARAM_STR);
            $stmt->bindParam(":proximo_control", $datos["proximo_control"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_fecha", $datos["numero_fecha"], PDO::PARAM_STR);
            $stmt->bindParam(":especificacion_fecha", $datos["especificacion_fecha"], PDO::PARAM_STR);
            $stmt->bindParam(":educacion_individual_familiar", $datos["educacion_individual_familiar"], PDO::PARAM_STR);
            $stmt->bindParam(":consulta_gestante", $datos["consulta_gestante"], PDO::PARAM_STR);
            $stmt->bindParam(":verificacion_cpn_vacunacion", $datos["verificacion_cpn_vacunacion"], PDO::PARAM_STR);
            $stmt->bindParam(":realizacion_estrategia_etmi", $datos["realizacion_estrategia_etmi"], PDO::PARAM_STR);
            $stmt->bindParam(":soporte_nutricional", $datos["soporte_nutricional"], PDO::PARAM_STR);
            $stmt->bindParam(":nombre_soporte", $datos["nombre_soporte"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_gastrostomia", $datos["usuario_gastrostomia"], PDO::PARAM_STR);
            $stmt->bindParam(":perimetro_abd", $datos["perimetro_abd"], PDO::PARAM_STR);
            $stmt->bindParam(":perimetro_pantorrilla", $datos["perimetro_pantorrilla"], PDO::PARAM_STR);
            $stmt->bindParam(":perimetro_braquial", $datos["perimetro_braquial"], PDO::PARAM_STR);
            $stmt->bindParam(":imc", $datos["imc"], PDO::PARAM_STR);
            $stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
            $stmt->bindParam(":talla", $datos["talla"], PDO::PARAM_STR);
            $stmt->bindParam(":remision_seguimiento", $datos["remision_seguimiento"], PDO::PARAM_STR);
            $stmt->bindParam(":educacion_signos_alarma", $datos["educacion_signos_alarma"], PDO::PARAM_STR);
            $stmt->bindParam(":notificacion_inmediata_alertas", $datos["notificacion_inmediata_alertas"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";

            }else{

                return $stmt->errorInfo();

            }


        }else if($datos["formulario"] == 'TRABAJO SOCIAL'){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO di_citas_trabajo_social (id_cita, valoracion_trabajo_social, proximo_control, numero_fecha, especificacion_fecha, educacion_individual_familiar, consulta_gestante, riesgo_psicosocial, red_apoyo, cuidador_idoneo, reporte_entes, ente_reportado, luz, agua, gas, remision_seguimiento, educacion_signos_alarma, notificacion_inmediata_alertas, observaciones, usuario_crea) VALUES (:id_cita, :valoracion_trabajo_social, :proximo_control, :numero_fecha, :especificacion_fecha, :educacion_individual_familiar, :consulta_gestante, :riesgo_psicosocial, :red_apoyo, :cuidador_idoneo, :reporte_entes, :ente_reportado, :luz, :agua, :gas, :remision_seguimiento, :educacion_signos_alarma, :notificacion_inmediata_alertas, :observaciones, :usuario_crea)");

            $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
            $stmt->bindParam(":valoracion_trabajo_social", $datos["valoracion_trabajo_social"], PDO::PARAM_STR);
            $stmt->bindParam(":proximo_control", $datos["proximo_control"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_fecha", $datos["numero_fecha"], PDO::PARAM_STR);
            $stmt->bindParam(":especificacion_fecha", $datos["especificacion_fecha"], PDO::PARAM_STR);
            $stmt->bindParam(":educacion_individual_familiar", $datos["educacion_individual_familiar"], PDO::PARAM_STR);
            $stmt->bindParam(":consulta_gestante", $datos["consulta_gestante"], PDO::PARAM_STR);
            $stmt->bindParam(":riesgo_psicosocial", $datos["riesgo_psicosocial"], PDO::PARAM_STR);
            $stmt->bindParam(":red_apoyo", $datos["red_apoyo"], PDO::PARAM_STR);
            $stmt->bindParam(":cuidador_idoneo", $datos["cuidador_idoneo"], PDO::PARAM_STR);
            $stmt->bindParam(":reporte_entes", $datos["reporte_entes"], PDO::PARAM_STR);
            $stmt->bindParam(":ente_reportado", $datos["ente_reportado"], PDO::PARAM_STR);
            $stmt->bindParam(":luz", $datos["luz"], PDO::PARAM_STR);
            $stmt->bindParam(":agua", $datos["agua"], PDO::PARAM_STR);
            $stmt->bindParam(":gas", $datos["gas"], PDO::PARAM_STR);
            $stmt->bindParam(":remision_seguimiento", $datos["remision_seguimiento"], PDO::PARAM_STR);
            $stmt->bindParam(":educacion_signos_alarma", $datos["educacion_signos_alarma"], PDO::PARAM_STR);
            $stmt->bindParam(":notificacion_inmediata_alertas", $datos["notificacion_inmediata_alertas"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";

            }else{

                return $stmt->errorInfo();

            }

        }else if($datos["formulario"] == 'PSICOLOGIA'){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO di_citas_psicologia (id_cita, valoracion_psicologia, proximo_control, numero_fecha, especificacion_fecha, educacion_individual_familiar, consulta_gestante, riesgo_psicosocial, remision_seguimiento, educacion_signos_alarma, notificacion_inmediata_alertas, reporte_sivigila, tipo_reporte, observaciones, usuario_crea) VALUES (:id_cita, :valoracion_psicologia, :proximo_control, :numero_fecha, :especificacion_fecha, :educacion_individual_familiar, :consulta_gestante, :riesgo_psicosocial, :remision_seguimiento, :educacion_signos_alarma, :notificacion_inmediata_alertas, :reporte_sivigila, :tipo_reporte, :observaciones, :usuario_crea)");

            $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
            $stmt->bindParam(":valoracion_psicologia", $datos["valoracion_psicologia"], PDO::PARAM_STR);
            $stmt->bindParam(":proximo_control", $datos["proximo_control"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_fecha", $datos["numero_fecha"], PDO::PARAM_STR);
            $stmt->bindParam(":especificacion_fecha", $datos["especificacion_fecha"], PDO::PARAM_STR);
            $stmt->bindParam(":educacion_individual_familiar", $datos["educacion_individual_familiar"], PDO::PARAM_STR);
            $stmt->bindParam(":consulta_gestante", $datos["consulta_gestante"], PDO::PARAM_STR);
            $stmt->bindParam(":riesgo_psicosocial", $datos["riesgo_psicosocial"], PDO::PARAM_STR);
            $stmt->bindParam(":remision_seguimiento", $datos["remision_seguimiento"], PDO::PARAM_STR);
            $stmt->bindParam(":educacion_signos_alarma", $datos["educacion_signos_alarma"], PDO::PARAM_STR);
            $stmt->bindParam(":notificacion_inmediata_alertas", $datos["notificacion_inmediata_alertas"], PDO::PARAM_STR);
            $stmt->bindParam(":reporte_sivigila", $datos["reporte_sivigila"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo_reporte", $datos["tipo_reporte"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";

            }else{

                return $stmt->errorInfo();

            }

        }else if($datos["formulario"] == 'RIESGO CARDIO VASCULAR'){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO di_citas_riesgo_cardio_vascular (id_cita, evolucion_consumo_tabaco, laboratorios_recientes, ordenamiento_laboratorios, evaluacion_antecedentes, evaluacion_rcv, evaluacion_rcm, evaluacion_epoc, evaluacion_imc, eduacion_individual, derivo_educacion_grupal, confirmacion_diagnostica, usuario_crea) VALUES (:id_cita, :evolucion_consumo_tabaco, :laboratorios_recientes, :ordenamiento_laboratorios, :evaluacion_antecedentes, :evaluacion_rcv, :evaluacion_rcm, :evaluacion_epoc, :evaluacion_imc, :eduacion_individual, :derivo_educacion_grupal, :confirmacion_diagnostica, :usuario_crea)");

            $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
            $stmt->bindParam(":evolucion_consumo_tabaco", $datos["evolucion_consumo_tabaco"], PDO::PARAM_STR);
            $stmt->bindParam(":laboratorios_recientes", $datos["laboratorios_recientes"], PDO::PARAM_STR);
            $stmt->bindParam(":ordenamiento_laboratorios", $datos["ordenamiento_laboratorios"], PDO::PARAM_STR);
            $stmt->bindParam(":evaluacion_antecedentes", $datos["evaluacion_antecedentes"], PDO::PARAM_STR);
            $stmt->bindParam(":evaluacion_rcv", $datos["evaluacion_rcv"], PDO::PARAM_STR);
            $stmt->bindParam(":evaluacion_rcm", $datos["evaluacion_rcm"], PDO::PARAM_STR);
            $stmt->bindParam(":evaluacion_epoc", $datos["evaluacion_epoc"], PDO::PARAM_STR);
            $stmt->bindParam(":evaluacion_imc", $datos["evaluacion_imc"], PDO::PARAM_STR);
            $stmt->bindParam(":eduacion_individual", $datos["eduacion_individual"], PDO::PARAM_STR);
            $stmt->bindParam(":derivo_educacion_grupal", $datos["derivo_educacion_grupal"], PDO::PARAM_STR);
            $stmt->bindParam(":confirmacion_diagnostica", $datos["confirmacion_diagnostica"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return "ok";

            }else{

                return $stmt->errorInfo();

            }

        }

    }
    
    static public function mdlTerminarCita($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = :estado, fecha_fin = :fecha_fin WHERE id_cita = :id_cita");

        $stmt->bindParam(":id_cita", $datos["id_cita"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlVerInfoCita($idCita){

        $stmt = Connection::connectOnly()->prepare("SELECT dic.*, CONCAT( p.primer_nombre, ' ', p.segundo_nombre, ' ', p.primer_apellido, ' ', p.segundo_apellido ) AS nombre_paciente, p.tipo_documento, p.numero_documento FROM di_agendamiento_citas AS dic JOIN pacientes AS p ON dic.id_paciente = p.id_paciente WHERE dic.id_cita = $idCita");

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlGestionarCita($tabla, $idCita, $estado, $hoy){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado = '$estado', fecha_ini = '$hoy' WHERE id_cita = $idCita");

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaCitasPendientesMedica($idProfesional){

        $stmt = Connection::connectOnly()->prepare("SELECT dic.id_cita, dic.id_profesional, dic.fecha_cita, dic.franja_cita, CONCAT( p.primer_nombre, ' ', p.segundo_nombre, ' ', p.primer_apellido, ' ', p.segundo_apellido ) AS nombre_paciente, p.tipo_documento, p.numero_documento, p.telefono_uno_ubicacion, p.telefono_dos_ubicacion, p.direccion_ubicacion, dic.cohorte_programa, dic.motivo_cita, dic.estado FROM pacientes AS p JOIN di_agendamiento_citas AS dic ON p.id_paciente = dic.id_paciente WHERE dic.id_profesional = $idProfesional AND dic.estado IN ('CREADA', 'PROCESO')");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

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

}
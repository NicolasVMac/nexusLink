<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";

require_once $rutaConnection;

date_default_timezone_set('America/Bogota');

class ModelReportesAgendamiento{

    static public function mdlListaDetalleDi($cohorte, $fechaInicio, $fechaFin){

        $arrayCohorte = array(
            "MATERNO PERINATAL Y SSR" => "di_citas_materno_perinatal",
            "SALUD INFANTIL" => "di_citas_salud_infantil",
            "VACUNACION" => "di_citas_vacunaciones",
            "CRONICOS" => "di_citas_cronicos",
            "PHD" => "di_citas_phd",
            "ANTICOAGULADOS" => "di_citas_anticoagulados",
            "NUTRICION" => "di_citas_nutricion",
            "TRABAJO SOCIAL" => "di_citas_trabajo_social",
            "PSICOLOGIA" => "di_citas_psicologia",
            "RIESGO CARDIO VASCULAR" => "di_citas_riesgo_cardio_vascular"
        );


        $stmt = Connection::connectOnly()->prepare("SELECT CONCAT(primer_apellido,' ',segundo_apellido,' ', primer_nombre,' ',segundo_nombre) AS nombre_paciente, CONCAT(tipo_documento,'-',numero_documento) AS documento_poaciente, servicio_cita, motivo_cita, cohorte_programa, fecha_cita, franja_cita, localidad_cita, di_agendamiento_citas.estado AS estado_agendamiento_cita, $arrayCohorte[$cohorte].* FROM pacientes JOIN di_agendamiento_citas ON pacientes.id_paciente = di_agendamiento_citas.id_paciente JOIN $arrayCohorte[$cohorte] ON $arrayCohorte[$cohorte].id_cita = di_agendamiento_citas.id_cita
            WHERE di_agendamiento_citas.cohorte_programa = :cohorte AND di_agendamiento_citas.fecha_cita BETWEEN '$fechaInicio' AND '$fechaFin'");

        $stmt->bindParam(":cohorte", $cohorte, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlListaAtencionCohorteGraficaTable($idProfesional, $fechaInicio, $fechaFin){

        $stmt = Connection::connectOnly()->prepare("SELECT di_agendamiento_citas.*, CONCAT( pacientes.primer_nombre, ' ', pacientes.segundo_nombre, ' ', pacientes.primer_apellido, ' ', pacientes.segundo_apellido ) AS nombre_paciente, CONCAT( pacientes.tipo_documento, '-', pacientes.numero_documento ) AS documento_paciente, usuarios.nombre AS nombre_profesional FROM pacientes JOIN di_agendamiento_citas ON pacientes.id_paciente = di_agendamiento_citas.id_paciente JOIN usuarios ON di_agendamiento_citas.id_profesional = usuarios.id 
            WHERE di_agendamiento_citas.estado IN ( 'TERMINADA', 'FALLIDA' ) AND fecha_fin BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59' AND id_profesional = :id_profesional");

        $stmt->bindParam(":id_profesional", $idProfesional, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaAtencionCohorteGrafica($idProfesional, $fechaInicio, $fechaFin){

        $stmt = Connection::connectOnly()->prepare("SELECT YEAR( fecha_fin ) AS anio, MONTH ( fecha_fin ) AS mes,
            SUM(CASE WHEN  di_agendamiento_citas.cohorte_programa = 'MATERNO PERINATAL Y SSR' THEN 1 ELSE 0 END) AS cant_materno_perinatal,
            SUM(CASE WHEN  di_agendamiento_citas.cohorte_programa = 'SALUD INFANTIL' THEN 1 ELSE 0 END) AS cant_salud_infantil,
            SUM(CASE WHEN  di_agendamiento_citas.cohorte_programa = 'VACUNACION' THEN 1 ELSE 0 END) AS cant_vacunacion,
            SUM(CASE WHEN  di_agendamiento_citas.cohorte_programa = 'CRONICOS' THEN 1 ELSE 0 END) AS cant_cronicos,
            SUM(CASE WHEN  di_agendamiento_citas.cohorte_programa = 'PHD' THEN 1 ELSE 0 END) AS cant_phd,
            SUM(CASE WHEN  di_agendamiento_citas.cohorte_programa = 'ANTICOAGULADOS' THEN 1 ELSE 0 END) AS cant_anticoagulados,
            SUM(CASE WHEN  di_agendamiento_citas.cohorte_programa = 'NUTRICION' THEN 1 ELSE 0 END) AS cant_nutricion,
            SUM(CASE WHEN  di_agendamiento_citas.cohorte_programa = 'TRABAJO SOCIAL' THEN 1 ELSE 0 END) AS cant_trabajo_social,
            SUM(CASE WHEN  di_agendamiento_citas.cohorte_programa = 'PSICOLOGIA' THEN 1 ELSE 0 END) AS cant_psicologia,
            SUM(CASE WHEN  di_agendamiento_citas.cohorte_programa = 'RIESGO CARDIO VASCULAR' THEN 1 ELSE 0 END) AS cant_riesgo_cardiovascular
            FROM pacientes JOIN di_agendamiento_citas ON pacientes.id_paciente = di_agendamiento_citas.id_paciente JOIN usuarios ON di_agendamiento_citas.id_profesional = usuarios.id 
            WHERE di_agendamiento_citas.estado IN ( 'TERMINADA', 'FALLIDA' ) AND fecha_fin BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59' AND id_profesional = :id_profesional 
            GROUP BY anio, mes ORDER BY anio ASC, mes ASC");

        $stmt->bindParam(":id_profesional", $idProfesional, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null; 

    }

    static public function mdlListaEfectiFalliReproGraficaTable($idProfesional, $fechaInicio, $fechaFin){

        $stmt = Connection::connectOnly()->prepare("SELECT c.*, CONCAT( p.primer_nombre, ' ', p.segundo_nombre, ' ', p.primer_apellido, ' ', p.segundo_apellido ) AS nombre_paciente, CONCAT( p.tipo_documento, '-', p.numero_documento ) AS documento_paciente, u.nombre AS nombre_profesional, CASE WHEN r.id_cita IS NOT NULL THEN 'REPROGRAMADA' WHEN c.estado NOT IN ('TERMINADA', 'FALLIDA') THEN 'REPROGRAMADA' ELSE c.estado END AS estado_final FROM pacientes p JOIN di_agendamiento_citas c ON p.id_paciente = c.id_paciente JOIN usuarios u ON c.id_profesional = u.id LEFT JOIN di_agendamiento_citas_reagendamiento_log r ON c.id_cita = r.id_cita 
            WHERE c.fecha_fin BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59' AND c.id_profesional = :id_profesional GROUP BY id_cita");

        $stmt->bindParam(":id_profesional", $idProfesional, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null; 

    }

    static public function mdlListaEfectiFalliReproGrafica($idProfesional, $fechaInicio, $fechaFin){

        $stmt = Connection::connectOnly()->prepare("SELECT YEAR( fecha_fin ) AS anio, MONTH ( fecha_fin ) AS mes, SUM( CASE WHEN c.estado = 'TERMINADA' AND r.id_cita IS NULL THEN 1 ELSE 0 END ) AS count_terminados, SUM( CASE WHEN c.estado = 'FALLIDA' AND r.id_cita IS NULL THEN 1 ELSE 0 END ) AS count_fallidos, COUNT( DISTINCT r.id_cita ) AS count_reagendadas FROM di_agendamiento_citas c LEFT JOIN di_agendamiento_citas_reagendamiento_log r ON c.id_cita = r.id_cita 
            WHERE c.fecha_fin BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59' AND c.id_profesional = :id_profesional GROUP BY anio, mes ORDER BY anio ASC, mes ASC");

        $stmt->bindParam(":id_profesional", $idProfesional, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null; 

    }

    static public function mdlListaProductividadProfesionalGrafica($idProfesional, $fechaInicio, $fechaFin){

        $stmt = Connection::connectOnly()->prepare("SELECT YEAR(fecha_fin) AS anio, MONTH(fecha_fin) AS mes, COUNT(*) AS cantidad FROM pacientes JOIN di_agendamiento_citas ON pacientes.id_paciente = di_agendamiento_citas.id_paciente JOIN usuarios ON di_agendamiento_citas.id_profesional = usuarios.id
            WHERE di_agendamiento_citas.estado IN ( 'TERMINADA', 'FALLIDA' ) AND fecha_fin BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59' AND id_profesional = :id_profesional GROUP BY anio, mes ORDER BY anio ASC, mes ASC");

        $stmt->bindParam(":id_profesional", $idProfesional, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;    

    }

    static public function mdlListaProductividadProfesional($idProfesional, $fechaInicio, $fechaFin){

        $stmt = Connection::connectOnly()->prepare("SELECT di_agendamiento_citas.*, CONCAT(pacientes.primer_nombre, ' ', pacientes.segundo_nombre, ' ', pacientes.primer_apellido, ' ', pacientes.segundo_apellido) AS nombre_paciente, CONCAT(pacientes.tipo_documento, '-', pacientes.numero_documento) AS documento_paciente, usuarios.nombre AS nombre_profesional FROM pacientes JOIN di_agendamiento_citas ON pacientes.id_paciente = di_agendamiento_citas.id_paciente JOIN usuarios ON di_agendamiento_citas.id_profesional = usuarios.id
            WHERE di_agendamiento_citas.estado IN ('TERMINADA', 'FALLIDA') AND fecha_fin BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59' AND id_profesional = :id_profesional");

        $stmt->bindParam(":id_profesional", $idProfesional, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;        

    }

    static public function mdlListaTablaRegimenBaseDetalle($idBase, $regimen){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE id_base = $idBase AND regimen = '$regimen'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;        

    }

    static public function mdlListaTablaRegimenBase($idBase){

        $stmt = Connection::connectOnly()->prepare("SELECT regimen, COUNT(*) AS cantidad FROM di_bolsa_pacientes WHERE id_base = $idBase GROUP BY regimen ORDER BY cantidad DESC");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaTablaReporteBaseDetallado($idBase){

        $stmt = Connection::connectOnly()->prepare("SELECT
            usuarios_cargos.cargo,
            par_profesionales.nombre_profesional,
            SUM( CASE WHEN usuarios_cargos.cargo = 'MEDICO GENERAL' THEN 1 ELSE 0 END ) AS ASIGNADAS_MEDICOS,
            SUM( CASE WHEN usuarios_cargos.cargo = 'JEFE ENFERMERIA' THEN 1 ELSE 0 END ) AS ASIGNADAS_JEFES_ENFERMERIAS,
            SUM( CASE WHEN usuarios_cargos.cargo = 'MEDICO GENERAL' AND di_agendamiento_citas.estado = 'TERMINADA' THEN 1 ELSE 0 END ) AS EFECTIVAS_MEDICOS,
            SUM( CASE WHEN usuarios_cargos.cargo = 'MEDICO GENERAL' AND di_agendamiento_citas.estado = 'FALLIDA' THEN 1 ELSE 0 END ) AS FALLIDAS_MEDICOS,
            SUM( CASE WHEN usuarios_cargos.cargo = 'JEFE ENFERMERIA' AND di_agendamiento_citas.estado = 'TERMINADA' THEN 1 ELSE 0 END ) AS EFECTIVAS_JEFES_ENFERMERIAS,
            SUM( CASE WHEN usuarios_cargos.cargo = 'JEFE ENFERMERIA' AND di_agendamiento_citas.estado = 'FALLIDA' THEN 1 ELSE 0 END ) AS FALLIDAS_JEFES_ENFERMERIAS,
            SUM( CASE WHEN di_agendamiento_citas.estado IN ('CREADA','PROCESO') THEN 1 ELSE 0 END ) AS PROGRAMADAS
            FROM di_bases_pacientes
            JOIN di_bolsa_pacientes ON di_bases_pacientes.id_base = di_bolsa_pacientes.id_base
            JOIN di_agendamiento_citas ON di_bolsa_pacientes.id_bolsa_paciente = di_agendamiento_citas.id_bolsa_agendamiento
            JOIN par_profesionales ON di_agendamiento_citas.id_profesional = par_profesionales.id_profesional
            JOIN usuarios_cargos ON par_profesionales.id_profesional = usuarios_cargos.id_usuario
            WHERE di_bases_pacientes.id_base = $idBase GROUP BY par_profesionales.id_profesional ORDER BY cargo ASC");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlListaTablaReporteBaseGeneral($idBase){

        $stmt = Connection::connectOnly()->prepare("SELECT
            TRUNCATE((SUM(CASE WHEN di_agendamiento_citas.estado = 'TERMINADA' THEN 1 ELSE 0 END) / COUNT(di_bolsa_pacientes.id_bolsa_paciente)) * 100, 0) AS PORCENTAJE_GESTION,
            SUM( CASE WHEN usuarios_cargos.cargo = 'MEDICO GENERAL' THEN 1 ELSE 0 END ) AS ASIGNADAS_MEDICOS,
            SUM( CASE WHEN usuarios_cargos.cargo = 'JEFE ENFERMERIA' THEN 1 ELSE 0 END ) AS ASIGNADAS_JEFES_ENFERMERIAS,
            SUM( CASE WHEN usuarios_cargos.cargo = 'MEDICO GENERAL' AND di_agendamiento_citas.estado = 'TERMINADA' THEN 1 ELSE 0 END ) AS EFECTIVAS_MEDICOS,
            SUM( CASE WHEN usuarios_cargos.cargo = 'MEDICO GENERAL' AND di_agendamiento_citas.estado = 'FALLIDA' THEN 1 ELSE 0 END ) AS FALLIDAS_MEDICOS,
            SUM( CASE WHEN usuarios_cargos.cargo = 'JEFE ENFERMERIA' AND di_agendamiento_citas.estado = 'TERMINADA' THEN 1 ELSE 0 END ) AS EFECTIVAS_JEFES_ENFERMERIAS,
            SUM( CASE WHEN usuarios_cargos.cargo = 'JEFE ENFERMERIA' AND di_agendamiento_citas.estado = 'FALLIDA' THEN 1 ELSE 0 END ) AS FALLIDAS_JEFES_ENFERMERIAS,
            SUM( CASE WHEN di_agendamiento_citas.estado IN ('CREADA','PROCESO') THEN 1 ELSE 0 END ) AS PROGRAMADAS
            FROM di_bases_pacientes
            JOIN di_bolsa_pacientes ON di_bases_pacientes.id_base = di_bolsa_pacientes.id_base
            JOIN di_agendamiento_citas ON di_bolsa_pacientes.id_bolsa_paciente = di_agendamiento_citas.id_bolsa_agendamiento
            JOIN par_profesionales ON di_agendamiento_citas.id_profesional = par_profesionales.id_profesional
            JOIN usuarios_cargos ON par_profesionales.id_profesional = usuarios_cargos.id_usuario
            WHERE di_bases_pacientes.id_base = $idBase");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlListaTablaLlamadas($procesoLlamada, $cohortePrograma, $fechaInicio, $fechaFin){

        if($procesoLlamada == "REALIZADAS"){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE fecha_crea BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59'");

            if($stmt->execute()){

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }else{

                return $stmt->errorInfo();

            }


        }else if($procesoLlamada == "PROGRAMADAS"){

            if($cohortePrograma == 'TODOS'){

                $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE estado IN ('CREADA', 'PROCESO') AND fecha_crea BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59'");

                if($stmt->execute()){

                    return $stmt->fetchAll(PDO::FETCH_ASSOC);

                }else{

                    return $stmt->errorInfo();

                }

            }else{

                $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE estado IN ('CREADA', 'PROCESO') AND cohorte_programa = '$cohortePrograma' AND fecha_crea BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59'");

                if($stmt->execute()){

                    return $stmt->fetchAll(PDO::FETCH_ASSOC);

                }else{

                    return $stmt->errorInfo();

                }

            }


        }else{

            if($cohortePrograma == 'TODOS'){

                $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE estado IN ('FINALIZADA', 'FALLIDA') AND fecha_crea BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59'");

                if($stmt->execute()){

                    return $stmt->fetchAll(PDO::FETCH_ASSOC);

                }else{

                    return $stmt->errorInfo();

                }

            }else{

                $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bolsa_pacientes WHERE estado IN ('FINALIZADA', 'FALLIDA') AND cohorte_programa = '$cohortePrograma' AND fecha_crea BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59'");

                if($stmt->execute()){

                    return $stmt->fetchAll(PDO::FETCH_ASSOC);

                }else{

                    return $stmt->errorInfo();

                }

            }

        }

        

    }

    static public function mdlReporteLlamadasRealizadas($fechaInicio, $fechaFin){

        $stmt = Connection::connectOnly()->prepare("SELECT SUM( CASE WHEN estado = 'FINALIZADA' THEN 1 ELSE 0 END ) AS FINALIZADAS, SUM( CASE WHEN estado != 'FINALIZADA' THEN 1 ELSE 0 END ) AS NO_FINALIZADAS FROM di_bolsa_pacientes WHERE fecha_crea BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlReporteLlamadasProgramadas($cohortePrograma, $fechaInicio, $fechaFin){

        if($cohortePrograma == 'TODOS'){

            $stmt = Connection::connectOnly()->prepare("SELECT cohorte_programa, SUM( CASE WHEN estado = 'CREADA' THEN 1 ELSE 0 END ) AS CREADAS, SUM( CASE WHEN estado = 'PROCESO' THEN 1 ELSE 0 END ) AS PROCESOS FROM di_bolsa_pacientes WHERE fecha_crea BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59' GROUP BY cohorte_programa");

            if($stmt->execute()){

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT cohorte_programa, SUM( CASE WHEN estado = 'CREADA' THEN 1 ELSE 0 END ) AS CREADAS, SUM( CASE WHEN estado = 'PROCESO' THEN 1 ELSE 0 END ) AS PROCESOS FROM di_bolsa_pacientes WHERE cohorte_programa = '$cohortePrograma' AND fecha_crea BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59' GROUP BY cohorte_programa");

            if($stmt->execute()){

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }


    }

    static public function mdlReporteLlamadasEfectivasFallidas($cohortePrograma, $fechaInicio, $fechaFin){

        if($cohortePrograma == 'TODOS'){

            $stmt = Connection::connectOnly()->prepare("SELECT cohorte_programa, SUM( CASE WHEN estado = 'FINALIZADA' THEN 1 ELSE 0 END ) AS FINALIZADAS, SUM( CASE WHEN estado = 'FALLIDA' THEN 1 ELSE 0 END ) AS FALLIDAS FROM di_bolsa_pacientes WHERE fecha_crea BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59' GROUP BY cohorte_programa");

            if($stmt->execute()){

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT cohorte_programa, SUM( CASE WHEN estado = 'FINALIZADA' THEN 1 ELSE 0 END ) AS FINALIZADAS, SUM( CASE WHEN estado = 'FALLIDA' THEN 1 ELSE 0 END ) AS FALLIDAS FROM di_bolsa_pacientes WHERE cohorte_programa = '$cohortePrograma' AND fecha_crea BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59' GROUP BY cohorte_programa");

            if($stmt->execute()){

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }

    }

    static public function mdlListaReportesAgendamiento($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaCohorteProgramas(){

        $stmt = Connection::connectOnly()->prepare("SELECT cohorte_programa FROM di_bolsa_pacientes GROUP BY cohorte_programa");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaBasesCargadas(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM di_bases_pacientes WHERE estado = 'CARGADO'");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }


}
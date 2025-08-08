<?php

$rutaControlador =  __DIR__. "\..\..\controllers\di\citas.controller.php";
$rutaModelo = __DIR__ . "\..\..\models\di\citas.model.php";
//echo $rutaControlador;

require_once $rutaControlador;
require_once $rutaModelo;
//require_once "../../models/callcenter/callcenter.model.php";

class CitasAjax{

    public $datos;

    public function listaCitasPendientesMedica($idProfesional){

        $respuesta = ControladorCitas::ctrListaCitasPendientesMedica($idProfesional);

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }

    public function gestionarCita($idCita, $estado, $idProfesional){

        $respuesta = ControladorCitas::ctrGestionarCita($idCita, $estado, $idProfesional);

        echo $respuesta;

    }

    public function verInfoCita($idCita){

        $respuesta = ControladorCitas::ctrVerInfoCita($idCita);

        echo json_encode($respuesta);

    }

    public function guardarGestionCitaVacunacion(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrGuardarGestionFormularioCita($datos);

        echo $respuesta;

    }

    public function guardarGestionCitaSaludInfantil(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrGuardarGestionFormularioCita($datos);

        echo $respuesta;

    }

    public function guardarGestionCitaMaternoPerinatal(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrGuardarGestionFormularioCita($datos);

        echo $respuesta;


    }

    public function listaCitasPaciente(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrListaCitasPaciente($datos);

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);


    }

    public function crearPreCita(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrCrearPreCita($datos);

        echo $respuesta;

    }

    public function listaBolsaPreCitas(){

        $respuesta = ControladorCitas::ctrListaBolsaPreCitas();

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);


    }

    public function tomarPreCita($idPreCita, $asesor){

        $respuesta = ControladorCitas::ctrTomarPreCita($idPreCita, $asesor);

        echo json_encode($respuesta);

    }

    public function infoPreCita($idPreCita){

        $respuesta = ControladorCitas::ctrObtenerPreCita($idPreCita);

        echo json_encode($respuesta);

    }

    public function crearCitaPreCita(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrCrearCitaPreCita($datos);

        echo $respuesta;

    }

    public function crearComunicacionFallida(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrCrearComunicacionFallida($datos);

        echo $respuesta;

    }

    public function listaPendientesPreCitasUser($user){

        $respuesta = ControladorCitas::ctrListaPendientesPreCitasUser($user);

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }

    public function listaComunicacionFallidasPreCitas($idPreCita){

        $respuesta = ControladorCitas::ctrListaComunicacionFallidasPreCitas($idPreCita);

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }

    public function terminarGestionPreCita(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrTerminarGestionPreCita($datos);

        echo $respuesta;

    }

    public function listaPreCitasCita($idCita){

        $respuesta = ControladorCitas::ctrListaPreCitasCita($idCita);

        $data = array();

        foreach ($respuesta as $key => $value) {
            $data[] = $value;
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);

    }

    public function eliminarPreCita($idPreCita){

        $respuesta = ControladorCitas::ctrEliminarPreCita($idPreCita);

        echo json_encode($respuesta);

    }

    public function guardarGestionCitaCronicos(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrGuardarGestionFormularioCita($datos);

        echo $respuesta;

    }

    public function guardarGestionCitaPhd(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrGuardarGestionFormularioCita($datos);

        echo $respuesta;

    }

    public function guardarGestionCitaAnticoagulados(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrGuardarGestionFormularioCita($datos);

        echo $respuesta;

    }

    public function guardarGestionCitaNutricion(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrGuardarGestionFormularioCita($datos);

        echo $respuesta;

    }

    public function guardarCitaTrabajoSocial(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrGuardarGestionFormularioCita($datos);

        echo $respuesta;

    }

    public function guardarCitaPsicologia(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrGuardarGestionFormularioCita($datos);

        echo $respuesta;

    }

    public function guardarGestionCitaFallida(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrGuardarGestionCitaFallida($datos);

        echo $respuesta;

    }

    public function guardarCitaRiesgoCardioVascular(){

        $datos = $this->datos;

        $respuesta = ControladorCitas::ctrGuardarGestionFormularioCita($datos);

        echo $respuesta;

    }

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'guardarCitaRiesgoCardioVascular':
            $guardarCitaRiesgoCardioVascular = new CitasAjax();
            $guardarCitaRiesgoCardioVascular->datos = array(
                "formulario" => $_POST["formulario"],
                "id_cita" => $_POST["idCita"],
                "evolucion_consumo_tabaco" => $_POST["evaluacionConsumoTabaco"],
                "laboratorios_recientes" => $_POST["laboratoriosRecientes"],
                "ordenamiento_laboratorios" => $_POST["ordenamientoLaboratorios"],
                "evaluacion_antecedentes" => $_POST["evaluacionAntecedentes"],
                "evaluacion_rcv" => $_POST["evaluacionRcv"],
                "evaluacion_rcm" => $_POST["evaluacionRcm"],
                "evaluacion_epoc" => $_POST["evaluacionEpoc"],
                "evaluacion_imc" => $_POST["evaluacionImc"],
                "eduacion_individual" => $_POST["educacionIndividual"],
                "derivo_educacion_grupal" => $_POST["derivoEducacionGrupal"],
                "confirmacion_diagnostica" => $_POST["confirmacionDiagnostica"],
                "usuario_crea" => $_POST["userSession"],
            );
            $guardarCitaRiesgoCardioVascular->guardarCitaRiesgoCardioVascular();
            break;

        case 'guardarGestionCitaFallida':
            $guardarGestionCitaFallida = new CitasAjax();
            $guardarGestionCitaFallida->datos = array(
                "id_cita" => $_POST["idCita"],
                "observaciones_fallida" => mb_strtoupper($_POST["observacionesFallida"]),
            );
            $guardarGestionCitaFallida->guardarGestionCitaFallida();
            break;

        case 'guardarCitaPsicologia':
            $guardarCitaPsicologia = new CitasAjax();
            $guardarCitaPsicologia->datos = array(
                "formulario" => $_POST["formulario"],
                "id_cita" => $_POST["idCita"],
                "valoracion_psicologia" => $_POST["valoracionPsicologia"],
                "proximo_control" => $_POST["proximoControl"],
                "numero_fecha" => $_POST["numeroFecha"],
                "especificacion_fecha" => $_POST["especificacionFecha"],
                "educacion_individual_familiar" => $_POST["educacionIndividualFamiliar"],
                "consulta_gestante" => $_POST["consultaGestante"],
                "riesgo_psicosocial" => $_POST["riesgoPsicosocial"],
                "remision_seguimiento" => $_POST["remisionSeguimiento"],
                "educacion_signos_alarma" => $_POST["educacionSignosAlarma"],
                "notificacion_inmediata_alertas" => $_POST["notificacionInmediataAlertas"],
                "reporte_sivigila" => $_POST["reportaSivigila"],
                "tipo_reporte" => mb_strtoupper($_POST["tipoReporte"]),
                "observaciones" => mb_strtoupper($_POST["observaciones"]),
                "usuario_crea" => $_POST["userSession"]
            );
            $guardarCitaPsicologia->guardarCitaPsicologia();
            break;

        case 'guardarCitaTrabajoSocial':
            $guardarCitaTrabajoSocial = new CitasAjax();
            $guardarCitaTrabajoSocial->datos = array(
                "formulario" => $_POST["formulario"],
                "id_cita" => $_POST["idCita"],
                "valoracion_trabajo_social" => $_POST["valoracionTrabajoSocial"],
                "proximo_control" => $_POST["proximoControl"],
                "numero_fecha" => $_POST["numeroFecha"],
                "especificacion_fecha" => $_POST["especificacionFecha"],
                "educacion_individual_familiar" => $_POST["educacionIndividualFamiliar"],
                "consulta_gestante" => $_POST["consultaGestante"],
                "riesgo_psicosocial" => $_POST["riesgoPsicosocial"],
                "red_apoyo" => $_POST["redApoyo"],
                "cuidador_idoneo" => $_POST["cuidadorIdoneo"],
                "reporte_entes" => $_POST["reporteEntes"],
                "ente_reportado" => mb_strtoupper($_POST["enteReportado"]),
                "luz" => $_POST["luz"],
                "agua" => $_POST["agua"],
                "gas" => $_POST["gaz"],
                "remision_seguimiento" => $_POST["remisionSeguimiento"],
                "educacion_signos_alarma" => $_POST["educacionSignosAlarma"],
                "notificacion_inmediata_alertas" => $_POST["notificacionInmediataAlertas"],
                "observaciones" => mb_strtoupper($_POST["observaciones"]),
                "usuario_crea" => $_POST["userSession"],
            );
            $guardarCitaTrabajoSocial->guardarCitaTrabajoSocial();
            break;

        case 'guardarGestionCitaNutricion':
            $guardarGestionCitaNutricion = new CitasAjax();
            $guardarGestionCitaNutricion->datos = array(
                "formulario" => $_POST["formulario"],
                "id_cita" => $_POST["idCita"],
                "valoracion_nutricional" => $_POST["valoracionNutricional"],
                "proximo_control" => $_POST["proximoControl"],
                "numero_fecha" => $_POST["numeroFecha"],
                "especificacion_fecha" => $_POST["especificacionFecha"],
                "educacion_individual_familiar" => $_POST["educacionIndividualFamiliar"],
                "consulta_gestante" => $_POST["consultaGestante"],
                "verificacion_cpn_vacunacion" => $_POST["verificacionCpnVacunacion"],
                "realizacion_estrategia_etmi" => $_POST["realizacionEstrategiaEtmiPlus"],
                "soporte_nutricional" => $_POST["soporteNutricional"],
                "nombre_soporte" => mb_strtoupper($_POST["nombreSoporte"]),
                "usuario_gastrostomia" => $_POST["usuarioGastrostomia"],
                "perimetro_abd" => $_POST["perimetroAbd"],
                "perimetro_pantorrilla" => $_POST["perimetroPantorrilla"],
                "perimetro_braquial" => $_POST["perimetroBraquial"],
                "imc" => $_POST["imc"],
                "peso" => $_POST["peso"],
                "talla" => $_POST["talla"],
                "remision_seguimiento" => $_POST["remisionSeguimiento"],
                "educacion_signos_alarma" => $_POST["educacionSignosAlarma"],
                "notificacion_inmediata_alertas" => $_POST["notificacionInmediataAlertas"],
                "observaciones" => mb_strtoupper($_POST["observaciones"]),
                "usuario_crea" => $_POST["userSession"]
            );
            $guardarGestionCitaNutricion->guardarGestionCitaNutricion();
            break;

        case 'guardarGestionCitaAnticoagulados':
            $guardarGestionCitaAnticoagulados = new CitasAjax();
            $guardarGestionCitaAnticoagulados->datos = array(
                "formulario" => $_POST["formulario"],
                "id_cita" => $_POST["idCita"],
                "tf" => $_POST["tf"],
                "too" => $_POST["too"],
                "tl" => $_POST["tl"],
                "tr" => $_POST["tr"],
                "succion" => $_POST["succion"],
                "toma_laboratorios" => $_POST["tomaLaboratorios"],
                "fecha_toma_laboratorios" => $_POST["fechaTomaLaboratorios"],
                "clinica_heridas" => $_POST["clinicaHeridas"],
                "cambio_sonda" => $_POST["cambioSonda"],
                "salida" => $_POST["salida"],
                "continua" => $_POST["continua"],
                "reingreso" => $_POST["reingreso"],
                "observaciones" => $_POST["observaciones"],
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $guardarGestionCitaAnticoagulados->guardarGestionCitaAnticoagulados();
            break;

        case 'guardarGestionCitaPhd':
            $guardarGestionCitaPhd = new CitasAjax();
            $guardarGestionCitaPhd->datos = array(
                "formulario" => $_POST["formulario"],
                "id_cita" => $_POST["idCita"],
                "tf" => $_POST["tf"],
                "too" => $_POST["too"],
                "tl" => $_POST["tl"],
                "tr" => $_POST["tr"],
                "succion" => $_POST["succion"],
                "toma_laboratorios" => $_POST["tomaLaboratorios"],
                "numero_proximo_control" => $_POST["numeroProximoControl"],
                "especificacion_proximo_control" => $_POST["especificacionProximoControl"],
                "clinica_heridas" => $_POST["clinicaHeridas"],
                "cambio_sonda" => $_POST["cambioSonda"],
                "suspende_tratamiento" => $_POST["suspendeTratamiento"],
                "finaliza_tratamiento" => $_POST["finalizaTratamiento"],
                "cambio_manejo" => $_POST["cambioManejo"],
                "observaciones" => $_POST["observaciones"],
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $guardarGestionCitaPhd->guardarGestionCitaPhd();
            break;

        case 'guardarGestionCitaCronicos':
            $guardarGestionCitaCronicos = new CitasAjax();
            $guardarGestionCitaCronicos->datos = array(
                "formulario" => $_POST["formulario"],
                "id_cita" => $_POST["idCita"],
                "tf" => $_POST["tf"],
                "too" => $_POST["too"],
                "tl" => $_POST["tl"],
                "tr" => $_POST["tr"],
                "psicologia" => $_POST["psicologia"],
                "trabajo_social" => $_POST["trabajoSocial"],
                "nutricion" => $_POST["nutricion"],
                "toma_laboratorios" => $_POST["tomaLaboratorios"],
                "numero_proximo_control" => $_POST["numeroProximoControl"],
                "especificacion_proximo_control" => $_POST["especificacionProximoControl"],
                "clinica_heridas" => $_POST["clinicaHeridas"],
                "cambio_sonda" => $_POST["cambioSonda"],
                "phd_cronicos_agudizados" => $_POST["phdCronicosAgudizados"],
                "suspende_tratamiento" => $_POST["suspendeTratamiento"],
                "finaliza_tratamiento" => $_POST["finalizaTratamiento"],
                "cambio_manejo" => $_POST["cambioManejo"],
                "inicia" => $_POST["inicia"],
                "termina" => $_POST["termina"],
                "observaciones" => $_POST["observaciones"],
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $guardarGestionCitaCronicos->guardarGestionCitaCronicos();
            break;

        case 'eliminarPreCita':
            $eliminarPreCita = new CitasAjax();
            $eliminarPreCita->eliminarPreCita($_POST["idPreCita"]);
            break;

        case 'listaPreCitasCita':
            $listaPreCitasCita = new CitasAjax();
            $listaPreCitasCita->listaPreCitasCita($_POST["idCita"]);
            break;

        case 'terminarGestionPreCita':
            $terminarGestionPreCita = new CitasAjax();
            $terminarGestionPreCita->datos = array(
                "id_pre_cita" => $_POST["idPreCita"],
                "estado" => $_POST["estado"]
            );
            $terminarGestionPreCita->terminarGestionPreCita();
            break;

        case 'listaComunicacionFallidasPreCitas':
            $listaComunicacionFallidasPreCitas = new CitasAjax();
            $listaComunicacionFallidasPreCitas->listaComunicacionFallidasPreCitas($_POST["idPreCita"]);
            break;

        case 'listaPendientesPreCitasUser':
            $listaPendientesPreCitasUser = new CitasAjax();
            $listaPendientesPreCitasUser->listaPendientesPreCitasUser($_POST["user"]);
            break;

        case 'crearComunicacionFallida':
            $crearComunicacionFallida = new CitasAjax();
            $crearComunicacionFallida->datos = array(
                "id_pre_cita" => $_POST["idPreCita"],
                "causal_fallida" => $_POST["causalFallida"],
                "observaciones" => $_POST["observacionFallida"],
                "cantidad_gestiones" => $_POST["cantidadGestiones"],
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $crearComunicacionFallida->crearComunicacionFallida();
            break;

        case 'crearCitaPreCita':
            $crearCitaPreCita = new CitasAjax();
            $crearCitaPreCita->datos = array(
                "id_pre_cita" => $_POST["idPreCita"],
                "id_profesional" => $_POST["idProfesional"],
                "id_paciente" => $_POST["idPaciente"],
                "id_bolsa_agendamiento" => $_POST["idBolsaAgendamiento"],
                "motivo_cita" => strtoupper($_POST["motivoCita"]),
                "fecha_cita" => $_POST["fechaCita"],
                "franja_cita" => $_POST["franjaCita"],
                "observaciones_cita" => strtoupper($_POST["observacionCita"]),
                "cohorte_programa" => $_POST["cohortePrograma"],
                "localidad_cita" => $_POST["localidadCita"],
                "servicio_cita" => $_POST["servicioCita"],
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $crearCitaPreCita->crearCitaPreCita();
            break;

        case 'infoPreCita':
            $infoPreCita = new CitasAjax();
            $infoPreCita->infoPreCita($_POST["idPreCita"]);
            break;

        case 'tomarPreCita':
            $tomarPreCita = new CitasAjax();
            $tomarPreCita->tomarPreCita($_POST["idPreCita"], $_POST["asesor"]);
            break;

        case 'listaBolsaPreCitas':
            $listaBolsaPreCitas = new CitasAjax();
            $listaBolsaPreCitas->listaBolsaPreCitas();
            break;

        case 'crearPreCita':
            $crearPreCita = new CitasAjax();
            $crearPreCita->datos = array(
                "motivo_cita" => strtoupper($_POST["motivoPreCita"]),
                "id_paciente" => $_POST["idPacientePreCita"],
                "fecha_cita" => $_POST["fechaPreCita"],
                "franja_cita" => $_POST["franjaPreCita"],
                "observaciones_cita" => strtoupper($_POST["observacionPreCita"]),
                "usuario_crea" => $_POST["userCreate"],
                "id_cita" => $_POST["idCita"]
            );
            $crearPreCita->crearPreCita();
            break;

        case 'listaCitasPaciente':
            $listaCitasPaciente = new CitasAjax();
            $listaCitasPaciente->datos = array(
                "tipoDoc" => $_POST["tipoDoc"],
                "tipoBusqueda" => $_POST["tipoBusqueda"],
                "numeroDocumento" => $_POST["numeroDocumento"],
            );
            $listaCitasPaciente->listaCitasPaciente();
            break;

        case 'guardarGestionCitaMaternoPerinatal':
            $guardarGestionCitaMaternoPerinatal = new CitasAjax();
            $guardarGestionCitaMaternoPerinatal->datos = array(
                "formulario" => $_POST["formulario"],
                "id_cita" => $_POST["idCita"],
                "tamizaje_salud_mental" => strtoupper($_POST["tamizajeSaludMental"]),
                "educacion_individual_familiar" => strtoupper($_POST["educacionIndividualFamiliar"]),
                "inicio_referencia_contrareferencia" => strtoupper($_POST["inicioReferenciaContrareferencia"]),
                "notificacion_inmediata_alertas" => strtoupper($_POST["notificacionInmediataAlertas"]),
                "consulta_gestante" => strtoupper($_POST["consultaGestante"]),
                "verificacion_cpn_vacunacion" => strtoupper($_POST["verificacionCpnVacunacion"]),
                "identificacion_riesgo" => strtoupper($_POST["identificacionRiesgo"]),
                "realizacion_estrategia_etmi_plus" => strtoupper($_POST["realizacionEstrategiaEtmiPlus"]),
                "verificacion_administracion_pnc" => strtoupper($_POST["verificacionAdministracionPnc"]),
                "captacion_pareja_tratamiento_sifilis_congenita" => strtoupper($_POST["captacionParejaTratamientoSifilisCongenita"]),
                "orden_provision_preservativos" => $_POST["ordenProvisionPreservativos"],
                "educacion_signos_alarma" => strtoupper($_POST["educacionSignosAlarma"]),
                "notificacion_cohorte_mp" => strtoupper($_POST["notificacionCohorteMp"]),
                "asesoria_planificacion_familiar" => strtoupper($_POST["asesoriaPlanificacionFamiliar"]),
                "demanda_inducida_pf" => strtoupper($_POST["demandaInducidaPf"]),
                "demanda_inducida_preconcepcional" => strtoupper($_POST["demandaInducidaPreconcepcional"]),
                "disentimiento_pnf_cita_percepcional" => strtoupper($_POST["disentimientoPnfCitaPercepcional"]),
                "estado_caso" => $_POST["estadoCaso"],
                "observaciones" => strtoupper($_POST["observaciones"]),
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $guardarGestionCitaMaternoPerinatal->guardarGestionCitaMaternoPerinatal();
            break;

        case 'guardarGestionCitaSaludInfantil':
            $guardarGestionCitaSaludInfantil = new CitasAjax();
            $guardarGestionCitaSaludInfantil->datos = array(

                "formulario" => $_POST["formulario"],
                "id_cita" => $_POST["idCita"],
                "peso" => strtoupper($_POST["peso"]),
                "talla" => strtoupper($_POST["talla"]),
                "perimetro_braquial" => strtoupper($_POST["perimetroBraquial"]),
                "lactancia_materna_exclusiva" => strtoupper($_POST["lactanciaMaternaExclusiva"]),
                "consejeria_lactancia_materna" => strtoupper($_POST["consejeriaLactanciaMaterna"]),
                "verificacion_esque_pai_covid" => strtoupper($_POST["verificacionEsquemaPAICovid"]),
                "soporte_nutricional" => strtoupper($_POST["soporteNutricional"]),
                "nombre_soporte_nutricional" => strtoupper($_POST["nombreSoporteNutricional"]),
                "formulacion_apme" => strtoupper($_POST["formulacionApme"]),
                "entrega_apme" => strtoupper($_POST["entregaApme"]),
                "oximetria" => strtoupper($_POST["oximetria"]),
                "sintomatologia_respiratoria" => strtoupper($_POST["sintomatologiaRespiratoria"]),
                "condiciones_riesgo" => strtoupper($_POST["condicionesRiesgo"]),
                "educacion_signos_alarma" => strtoupper($_POST["educacionSignosAlarma"]),
                "remision_urgencias" => strtoupper($_POST["remisionUrgencias"]),
                "remision_especialidades" => strtoupper($_POST["remisionEspecialidades"]),
                "remision_manejo_intramural" => strtoupper($_POST["remisionManejoIntramural"]),
                "usuario_crea" => $_POST["usuarioCrea"]

            );
            $guardarGestionCitaSaludInfantil->guardarGestionCitaSaludInfantil();
            break;

        case 'guardarGestionCitaVacunacion':
            $guardarGestionCitaVacunacion = new CitasAjax();
            $guardarGestionCitaVacunacion->datos = array(
                "formulario" => $_POST["formulario"],
                "id_cita" => $_POST["idCita"],
                "vacuna_administrada" => strtoupper($_POST["vacunaAdministrada"]),
                "dosis_administrada" => strtoupper($_POST["dosisAdministrada"]),
                "fecha_administracion" => $_POST["fechaAdministracion"],
                "observaciones" => strtoupper($_POST["observaciones"]),
                "usuario_crea" => $_POST["usuarioCrea"]
            );
            $guardarGestionCitaVacunacion->guardarGestionCitaVacunacion();
            break;

        case 'verInfoCita':
            $verInfoCita = new CitasAjax();
            $verInfoCita->verInfoCita($_POST["idCita"]);
            break;

        case 'gestionarCita':
            $gestionarCita = new CitasAjax();
            $gestionarCita->gestionarCita($_POST["idCita"], $_POST["estado"], $_POST["idProfesional"]);
            break;

        case 'listaCitasPendientesMedica':
            $listaCitasPendientesMedica = new CitasAjax();
            $listaCitasPendientesMedica->listaCitasPendientesMedica($_POST["idProfesional"]);
            break;

    }

}
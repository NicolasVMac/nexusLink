<?php

require_once "../controllers/parametricas.controller.php";
require_once "../controllers/pqr/pqr.controller.php";
require_once "../models/parametricas.model.php";
require_once "../models/pqr/pqr.model.php";

class ParametricasAjax
{

    public function listaTipoDocumento()
    {

        $tabla = "par_tipo_documentos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Tipo Documento</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["tipo"] . '">' . $value["tipo"] . ' - ' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaEstadoCivil()
    {

        $tabla = "par_estados_civiles";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Estado Civil</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }


    public function listaGenero()
    {

        $tabla = "par_generos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Genero</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaDepartamentos()
    {

        $tabla = "par_ciudad";

        $departamentos = ControladorParametricas::ctrObtenerDepartamentos($tabla);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Departamento</option>';

        foreach ($departamentos as $key => $value) {

            $cadena .= '<option value="' . $value["departamento"] . '">' . $value["departamento"] . '</option>';
        }

        echo $cadena;
    }

    public function listaCiudadesDepartamento($departamento)
    {

        $tabla = "par_ciudad";
        $cadena = '';

        $ciudades = ControladorParametricas::ctrObtenerCiudadesDepartamento($tabla, $departamento);

        $cadena .= '<option value="">Seleccione Ciudad</option>';

        foreach ($ciudades as $key => $value) {

            $cadena .= '<option value="' . $value["ciudad"] . '">' . $value["ciudad"] . '</option>';
        }

        echo $cadena;
    }

    public function listaEscolaridad()
    {

        $tabla = "par_escolaridad";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la Escolaridad</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaVinculacion()
    {

        $tabla = "par_vinculaciones";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la Vinculacion</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaOcupaciones()
    {

        $tabla = "par_ocupacion";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la Ocupacion</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaGruposPoblacionales()
    {

        $tabla = "par_grupo_poblacional";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione el Grupo Poblacional</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaPertinenciaEtnica()
    {

        $tabla = "par_pertinencia_etnica";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la Pertenencia Etnica</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaRegimenes()
    {

        $tabla = "par_regimenes";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione el Regimen</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaTipoUsuarioRips()
    {

        $tabla = "par_tipo_usuario_rips";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipo Usuario RIPS</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaTipoAfiliaciones()
    {

        $tabla = "par_tipo_afiliaciones";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipo Afiliacion</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaEntidadesActuales()
    {

        $tabla = "par_entidad_actual";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Entidad Af. Actual</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaModCopagos()
    {

        $tabla = "par_mod_copagos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Mod - Copago</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaCopagosFe()
    {

        $tabla = "par_copagos_fe";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Copago Fe</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaSedesReclaMedicamentos()
    {

        $tabla = "par_reclama_med_sede";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Sede</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaPaquetesAtencion()
    {

        $tabla = "par_paquetes_atencion";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Paquete Atencion</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaNotificadosSivigila()
    {

        $tabla = "par_notificados_sivigila";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Notificado Sivigila</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaPaisesOrigen()
    {

        $tabla = "par_paises_origen";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Pais Origen</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaZonas()
    {

        $tabla = "par_zonas";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Zona</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaCausalesComunicacionesFallidas()
    {

        $tabla = "di_causales_comunicaciones_fallidas";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione una Causal</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaProfesionalesAgenda()
    {

        $tabla = "par_profesionales";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Profesional</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["id_profesional"] . '">' . $value["nombre_profesional"] . '</option>';
        }

        echo $cadena;
    }

    public function listaProyectos()
    {

        $tabla = "proyectos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Proyecto</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["id_proyecto"] . '">' . $value["proyecto"] . '</option>';
        }

        echo $cadena;
    }

    public function listaPrioridades()
    {

        $tabla = "par_prioridades_ticket";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la Prioridad</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["descripcion"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function verDatoParametrica($parametrica, $dato)
    {

        $resultado = ControladorParametricas::ctrVerDatoParametrica($parametrica, $dato);

        echo json_encode($resultado);
    }

    public function listaLocalidades()
    {

        $tabla = "par_localidades";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la Localidad</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["localidad"] . '">' . $value["localidad"] . '</option>';
        }

        echo $cadena;
    }

    public function listaEpsPqr()
    {

        $tabla = "pqr_par_eps";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la EPS</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["eps"] . '">' . $value["eps"] . '</option>';
        }

        echo $cadena;
    }

    public function listaMediosRecepcionPqr()
    {

        $tabla = "pqr_par_medios_recepcion";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione el Medio de Recepcion</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["medio_recepcion"] . '">' . $value["medio_recepcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaTiposPqr()
    {

        $tabla = "pqr_par_tipos_pqr";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione el Tipo PQRSF</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["tipo_pqr"] . '">' . $value["tipo_pqr"] . '</option>';
        }

        echo $cadena;
    }

    public function listaMotivosPqr()
    {

        $tabla = "pqr_par_motivos_pqr";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione el Motivo PQRSF</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["motivo_pqr"] . '">' . $value["motivo_pqr"] . '</option>';
        }

        echo $cadena;
    }

    public function listaServiciosAreasPqr()
    {

        $tabla = "pqr_par_servicios_areas";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione el Servicio o Area PQRSF</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["servicio_area"] . '">' . $value["servicio_area"] . '</option>';
        }

        echo $cadena;
    }

    public function listaClasificacionesAtributosPqr()
    {

        $tabla = "pqr_par_clasificaciones_atributos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerClasiAtributos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la Clasificacion Atributo PQRSF</option><option value="TODAS">TODAS</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["clasificacion_atributo"] . '">' . $value["clasificacion_atributo"] . '</option>';
        }

        echo $cadena;
    }

    public function listaRecursosPqr()
    {

        $tabla = "pqr_par_recursos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["recurso"] . '">' . $value["recurso"] . '</option>';
        }

        echo $cadena;
    }

    public function listaProgramasPqr()
    {

        $tabla = "pqr_par_programas";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione el Programa</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["programa"] . '">' . $value["programa"] . '</option>';
        }

        echo $cadena;
    }

    public function listaSedesPqr($programa)
    {

        $tablaPro = "pqr_par_programas";
        $itemPro = "programa";
        $valorPro = $programa;

        $programaInfo = ControladorParametricas::ctrObtenerDatosActivos($tablaPro, $itemPro, $valorPro);

        //SEDES

        $tabla = "pqr_par_sedes";
        $item = "id_programa";
        $valor = $programaInfo["id_pqr_programa"];

        $resultado = ControladorParametricas::ctrObtenerDatosActivosAll($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la Sede</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["sede"] . '">' . $value["sede"] . '</option>';
        }

        echo $cadena;
    }

    public function listaEntesPqr()
    {

        $tabla = "pqr_par_entes";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione el Ente Reporta</option><option value="TODAS">TODAS</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["ente"] . '">' . $value["ente"] . '</option>';
        }

        echo $cadena;
    }

    public function infoMotivoPQRSF($motivoPQRS)
    {

        $tabla = "pqr_par_motivos_pqr";
        $item = "motivo_pqr";
        $valor = $motivoPQRS;

        $respuesta = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        echo json_encode($respuesta);
    }

    public function listaPlanAccionQuienPqr()
    {

        $tabla = "pqr_par_quien";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["quien"] . '">' . $value["quien"] . '</option>';
        }

        echo $cadena;
    }

    public function listaGestoresProgramaPqr($programa)
    {

        $tabla = "pqr_usuarios";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione el Gestor</option>';

        foreach ($resultado as $key => $value) {

            $arrayProgramas = explode("-", $value["programas"]);

            if (in_array($programa, $arrayProgramas)) {

                $countPQRS = ControladorPqr::ctrCantidadPQRSFUser($value["usuario"]);

                $cadena .= '<option value="' . $value["usuario"] . '">' . $value["nombre"] . " - " . $value["usuario"] . " - Pendientes: " . $countPQRS["cantidad"]  . '</option>';
            }
        }

        echo $cadena;
    }

    public function listaTrabajadorRelaPqr()
    {

        $tabla = "pqr_par_trabajadores";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione el Trabajador</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["nombre_trabajador"] . '">' . $value["nombre_trabajador"] . '</option>';
        }

        echo $cadena;
    }

    public function listaEpsSedePqr($sede)
    {

        $resultado = ControladorParametricas::ctrObtenerEpsSede($sede);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la EPS</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["eps"] . '">' . $value["eps"] . '</option>';
        }

        echo $cadena;
    }

    public function listaPlaAcDonde()
    {

        $tabla = "pqr_par_sedes";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Donde</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["sede"] . '">' . $value["sede"] . '</option>';
        }

        echo $cadena;
    }

    public function listaServiciosDI()
    {

        $tabla = "di_par_servicios";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Servicio</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["nombre_servicio"] . '">' . $value["codigo_servicio_com"] . ' - ' . $value["nombre_servicio"] . '</option>';
        }

        echo $cadena;
    }

    public function listaSedesPqrReportes()
    {

        $tabla = "pqr_par_sedes";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione una Sede</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["sede"] . '">' . $value["sede"] . '</option>';
        }

        echo $cadena;
    }

    public function listaSedeEpsPqrsf($eps)
    {

        $resultado = ControladorParametricas::ctrObtenerSedesEpsPqrsf($eps);

        $cadena = '';

        $cadena .= '<option value="">Seleccione una Sede</option><option value="TODAS">TODAS</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["sede"] . '">' . $value["sede"] . '</option>';
        }

        echo $cadena;
    }


    public function listaResponsablesProyectosCorrespondencia()
    {

        $resultado = ControladorParametricas::ctrObtenerListaResponsablesProyectosCorrespondencia();

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Responsable</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["id"] . '">' . $value["nombre"] . ' - ' . $value["usuario"] . '</option>';
        }

        echo $cadena;
    }


    public function listaEpsSedePqrsf($sede)
    {

        $resultado = ControladorParametricas::ctrObtenerEpsSedePqrsf($sede);

        $cadena = '';

        $cadena .= '<option value="">Seleccione una Eps</option><option value="TODAS">TODAS</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["eps"] . '">' . $value["eps"] . '</option>';
        }

        echo $cadena;
    }


    public function listaSedesPqrReportesOptionTodos()
    {

        $tabla = "pqr_par_sedes";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione una Sede</option><option value="TODAS">TODAS</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["sede"] . '">' . $value["sede"] . '</option>';
        }

        echo $cadena;
    }


    public function listaNacionalidadHv()
    {

        $tabla = "hv_par_nacionalidades";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione una Nacionalidad</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["nacionalidad"] . '">' . $value["nacionalidad"] . '</option>';
        }

        echo $cadena;
    }


    public function listaSectorHv()
    {

        $tabla = "hv_par_sectores";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Sector</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["sector"] . '">' . $value["sector"] . '</option>';
        }

        echo $cadena;
    }

    public function listaManualesProyecto($proyecto)
    {

        $respuesta = ControladorParametricas::ctrListaManualesProyecto($proyecto);

        echo json_encode($respuesta);
    }

    public function listaGrupoEstandaresAutoevaluacion()
    {

        $tabla = "pamec_par_estandares";
        $resultado = ControladorParametricas::ctrListaGrupoEstandaresAutoevaluacion($tabla);
        $cadena = '';

        $cadena .= '<option value="">Seleccione el Grupo</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["grupo"] . '">' . $value["grupo"] . '</option>';
        }

        echo $cadena;
    }

    public function listaSubGrupoEstandaresAutoevaluacion($grupo)
    {

        $tabla = "pamec_par_estandares";
        $resultado = ControladorParametricas::ctrListaSubGrupoEstandaresAutoevaluacion($tabla, $grupo);
        $cadena = '';

        $cadena .= '<option value="">Seleccione el Subgrupo</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["subgrupo"] . '">' . $value["subgrupo"] . '</option>';
        }

        echo $cadena;
    }

    public function listaEstandaresAutoevaluacion($grupo, $subGrupo)
    {

        $tabla = "pamec_par_estandares";
        $resultado = ControladorParametricas::ctrListaEstandaresAutoevaluacion($tabla, $grupo, $subGrupo);
        $cadena = '';

        $cadena .= '<option value="">Seleccione el Estandar</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["codigo"] . '">' . $value["codigo_descripcion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaResolucionEstandaresAutoevaluacion()
    {

        $tabla = "pamec_par_resoluciones";
        $resultado = ControladorParametricas::ctrListaResolucionEstandaresAutoevaluacion($tabla);
        $cadena = '';

        $cadena .= '<option value="">Seleccione una resolucion</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["resolucion"] . '">' . $value["resolucion"] . '</option>';
        }

        echo $cadena;
    }

    public function listaProcesoEstandaresAutoevaluacion()
    {

        $tabla = "pamec_par_proceso";
        $resultado = ControladorParametricas::ctrListaProcesoEstandaresAutoevaluacion($tabla);
        $cadena = '';

        $cadena .= '<option value="">Seleccione un proceso</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["proceso"] . '">' . $value["proceso"] . '</option>';
        }

        echo $cadena;
    }
    public function listaSedesPamec()
    {

        $tabla = "pamec_par_sedes";
        $resultado = ControladorParametricas::ctrListaSedesPamec($tabla);
        $cadena = '';

        $cadena .= '<option value="">Seleccione una sede</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["sede"] . '">' . $value["sede"] . '</option>';
        }

        echo $cadena;
    }
    public function listaProgramasPamec()
    {

        $tabla = "pamec_par_programas";
        $resultado = ControladorParametricas::ctrListaProgramasPamec($tabla);
        $cadena = '';

        $cadena .= '<option value="">Seleccione un programa</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["programa"] . '">' . $value["programa"] . '</option>';
        }

        echo $cadena;
    }
    public function listaEstandaresPamecPriorizacionAutoevaluacion($grupo)
    {

        $tabla = "pamec_par_estandares";
        $resultado = ControladorParametricas::ctrListaEstandaresPamecPriorizacionAutoevaluacion($tabla, $grupo);
        $cadena = '';

        $cadena .= '<option value="">Seleccione el Estandar</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["codigo"] . '">' . $value["codigo_descripcion"] . '</option>';
        }

        echo $cadena;
    }
    public function listaVariablesPriorizacionAutoevaluacion($tipoVariable)
    {

        $tabla = "pamec_par_escalas_priorizacion";
        $resultado = ControladorParametricas::ctrListaVariablesPriorizacionAutoevaluacion($tabla, $tipoVariable);
        $cadena = '';

        $cadena .= '<option value="">Seleccione una opcion..</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["escala"] . '">' . $value["descripcion"] . '</option>';
        }

        echo $cadena;
    }
    public function obtenerCriteriosEstandar($estandar) {
        $respuesta = ControladorParametricas::ctrObtenerCriteriosEstandar($estandar);
        echo json_encode($respuesta);
    }
  
    public function listaEspecialidadesProfesional(){

        $tabla = "encuestas_par_especialidades_profesional";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione una Especialidad</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["especialidad"].'">'.$value["especialidad"].'</option>';

        }

        echo $cadena;

    }

    public function listaAuditoresAudProfesional(){

        $resultado = ControladorParametricas::ctrListaAuditoresAudProfesional();

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Auditor</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["usuario"].'">'.$value["nombre"].' - '.$value['usuario'].'</option>';

        }

        echo $cadena;


    }


    public function listaDestinatarios(){

        $tabla = "correspondencia_par_destinatarios";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Destinatario</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["destinatario"].'">'.$value['destinatario'].'</option>';

        }

        echo $cadena;

    }

    public function listaSedesDg(){

        $tabla = "inventario_par_sedes_biomedicos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione una Sede</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["sede"].'">'.$value['cod'].'-'.$value["sede"].'</option>';

        }

        echo $cadena;

    }


    public function listaServiciosDg(){

        $tabla = "inventario_par_areas_servicios_biomedicos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione un Servicio</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["area_servicio"].'">'.$value['codigo'].'-'.$value["area_servicio"].'</option>';

        }

        echo $cadena;

    }

    public function listaClasificiacionBiomedicaDg(){

        $tabla = "inventario_par_clasificaciones_biomedicos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la Clasificacion Biomedica</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["clasificacion_biomedica"].'">'.$value['clasificacion_biomedica'].'</option>';

        }

        echo $cadena;

    }

    public function listaClasificiacionRiesgoDg(){

        $tabla = "inventario_par_clasificaciones_riesgos_biomedicos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione la Clasificacion Riesgo</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["clasificacion_riesgo"].'">'.$value['clasificacion_riesgo'].'</option>';

        }

        echo $cadena;

    }

    public function listaTecnologiaPredoDt(){

        $tabla = "inventario_par_tecnologias_predominantes_biomedicos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Tecnologia Predominante</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["tecnologia_predominante"].'">'.$value['tecnologia_predominante'].'</option>';

        }

        echo $cadena;

    }


    public function listaFuenteAlimentacionDt(){

        $tabla = "inventario_par_fuentes_alimentacion_biomedicos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Fuente Alimentacion</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["fuente_alimentacion"].'">'.$value['fuente_alimentacion'].'</option>';

        }

        echo $cadena;

    }


    public function listaCaracteristicasInstaDt(){

        $tabla = "inventario_par_caracteristicas_instalaciones";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Caracteristica Instalacion</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["caracteristica_instalacion"].'">'.$value['caracteristica_instalacion'].'</option>';

        }

        echo $cadena;

    }


    public function listaTipoEquipoDg(){

        $tabla = "inventario_par_tipos_equipos_biomedicos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipo Equipo</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["tipo"].'">'.$value['cod_tipo'].'-'.$value["tipo"].'</option>';

        }

        echo $cadena;

    }


    public function listarPamecParEstandar($select)
    {
        $tabla = "pamec_par_estandares";
        $resultado = ControladorParametricas::ctrListarPamecParEstandar($tabla,$select);
        $cadena = '';
        $cadena .= '<option value="">Seleccione una opcion</option>';

        if($select==='subgrupo'){

            foreach ($resultado as $key => $value) {

                $cadena .= '<option value="' . $value["subgrupo"] . '">' . $value["subgrupo"] . '</option>';
            }

        }else{

            foreach ($resultado as $key => $value) {

                $cadena .= '<option value="' . $value["codigo"] . '">' . $value["codigo_descripcion"] . '</option>';
            }

        }
        echo $cadena;
    }

    public function listaPeriodosConsultaAutoevaluacion()
    {
        $tabla = "pamec_par_periodos_autoevaluacion";
        $resultado = ControladorParametricas::ctrListaPeriodosConsultaAutoevaluacion($tabla);
        $cadena = '';
        $cadena .= '<option value="">Seleccione una opcion</option>';
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["periodo"] . '">' . $value["periodo"] . '</option>';
        }
        echo $cadena;
    }

    public function listaPeriodosPamecReporteAvance()
    {

        $tabla = "pamec_par_periodos_autoevaluacion";
        $resultado = ControladorParametricas::ctrListaPeriodosPamecReporteAvance($tabla);
        $cadena = '';

        $cadena .= '<option value="">Seleccione un periodo</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["periodo"] . '">' . $value["periodo"] . '</option>';
        }

        echo $cadena;
    }
  
    public function listaTipoMantenimientos(){

        $tabla = "inventario_par_tipos_mantenimientos_biomedicos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipos Mantenimiento</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["tipo"].'">'.$value['tipo'].'-'.$value["nombre"].'</option>';

        }

        echo $cadena;

    }


    public function listaTiposActivoFijo($categoriaActivoFijo){

        $resultado = ControladorParametricas::ctrObtenerTiposActivosInventario($categoriaActivoFijo);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipo Activo Fijo</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["tipo"].'">'.$value['tipo'].'</option>';

        }

        echo $cadena;

    }

    public function listaTiposPagadores(){

        $tabla = "pagadores_par_tipos_pagadores";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipo Pagador</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["tipo"].'">'.$value['tipo'].'-'.$value["tipo_pagador"].'</option>';

        }

        echo $cadena;


    }

    public function listaTiposIdentiPagador(){

        $tabla = "par_tipos_documentos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);
        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipo Documento</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["codigo"].'">'.$value['codigo'].'-'.$value["descripcion"].'</option>';

        }

        echo $cadena;


    }

    public function listaTiposContratos(){

        $tabla = "pagadores_par_tipos_contratos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);
        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipo Contrato</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["tipo_contrato"].'">'.$value['tipo_contrato'].'</option>';

        }

        echo $cadena;

    }

    public function listaTipoOtrosDocumentos(){

        $tabla = "pagadores_par_tipos_otros_documentos";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);
        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipo Documento</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["tipo_documento"].'">'.$value['tipo_documento'].'</option>';

        }

        echo $cadena;

    }

    public function listaTiposPolizas(){

        $tabla = "pagadores_par_tipos_polizas";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);
        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipo Poliza</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["tipo_poliza"].'">'.$value['tipo_poliza'].'</option>';

        }

        echo $cadena;

    }

    public function listaAseguradorasPolizas(){

        $tabla = "pagadores_par_aseguradoras";
        $item = null;
        $valor = null;

        $resultado = ControladorParametricas::ctrObtenerDatosActivos($tabla, $item, $valor);
        $cadena = '';

        $cadena .= '<option value="">Seleccione Aseguradora</option>';
        
        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="'.$value["aseguradora"].'">'.$value['aseguradora'].'</option>';

        }

        echo $cadena;

    }


}

if (isset($_POST['lista'])) {

    $lista = $_POST['lista'];
  
    switch ($lista) {
        
        case 'listaAseguradorasPolizas':
            $listaAseguradorasPolizas = new ParametricasAjax();
            $listaAseguradorasPolizas->listaAseguradorasPolizas();
            break;

        case 'listaTiposPolizas':
            $listaTiposPolizas = new ParametricasAjax();
            $listaTiposPolizas->listaTiposPolizas();
            break;

        case 'listaTipoOtrosDocumentos':
            $listaTipoOtrosDocumentos = new ParametricasAjax();
            $listaTipoOtrosDocumentos->listaTipoOtrosDocumentos();
            break;

        case 'listaTiposContratos':
            $listaTiposContratos = new ParametricasAjax();
            $listaTiposContratos->listaTiposContratos();
            break;

        case 'listaTiposIdentiPagador':
            $listaTiposIdentiPagador = new ParametricasAjax();
            $listaTiposIdentiPagador->listaTiposIdentiPagador();
            break;

        case 'listaTiposPagadores':
            $listaTiposPagadores = new ParametricasAjax();
            $listaTiposPagadores->listaTiposPagadores();
            break;

        case 'listaTiposActivoFijo':
            $listaTiposActivoFijo = new ParametricasAjax();
            $listaTiposActivoFijo->listaTiposActivoFijo($_POST["categoriaActivoFijo"]);
            break;

        case 'listaTipoMantenimientos':
            $listaTipoMantenimientos = new ParametricasAjax();
            $listaTipoMantenimientos->listaTipoMantenimientos();
            break;
        
        case 'obtenerCriteriosEstandar':
            $obtenerCriteriosEstandar = new ParametricasAjax();
            $obtenerCriteriosEstandar->obtenerCriteriosEstandar($_POST["estandar"]);
            break;
        
        case 'listaVariablesPriorizacionAutoevaluacion':
            $listaVariablesPriorizacionAutoevaluacion = new ParametricasAjax();
            $listaVariablesPriorizacionAutoevaluacion->listaVariablesPriorizacionAutoevaluacion($_POST["tipoVariable"]);
            break;
        
        case 'listaEstandaresPamecPriorizacionAutoevaluacion':
            $listaEstandaresPamecPriorizacionAutoevaluacion = new ParametricasAjax();
            $listaEstandaresPamecPriorizacionAutoevaluacion->listaEstandaresPamecPriorizacionAutoevaluacion($_POST["grupo"]);
            break;
        
        case 'listaProgramasPamec':
            $listaProgramasPamec = new ParametricasAjax();
            $listaProgramasPamec->listaProgramasPamec();
            break;
        
        case 'listaSedesPamec':
            $listaSedesPamec = new ParametricasAjax();
            $listaSedesPamec->listaSedesPamec();
            break;
        
        case 'listaProcesoEstandaresAutoevaluacion':
            $listaProcesoEstandaresAutoevaluacion = new ParametricasAjax();
            $listaProcesoEstandaresAutoevaluacion->listaProcesoEstandaresAutoevaluacion();
            break;
        
        case 'listaResolucionEstandaresAutoevaluacion':
            $listaResolucionEstandaresAutoevaluacion = new ParametricasAjax();
            $listaResolucionEstandaresAutoevaluacion->listaResolucionEstandaresAutoevaluacion();
            break;
        
        case 'listaEstandaresAutoevaluacion':
            $listaEstandaresAutoevaluacion = new ParametricasAjax();
            $listaEstandaresAutoevaluacion->listaEstandaresAutoevaluacion($_POST["grupo"], $_POST["subGrupo"]);
            break;
        
        case 'listaSubGrupoEstandaresAutoevaluacion':
            $listaSubGrupoEstandaresAutoevaluacion = new ParametricasAjax();
            $listaSubGrupoEstandaresAutoevaluacion->listaSubGrupoEstandaresAutoevaluacion($_POST["grupo"]);
            break;
        
        case 'listaGrupoEstandaresAutoevaluacion':
            $listaGrupoEstandaresAutoevaluacion = new ParametricasAjax();
            $listaGrupoEstandaresAutoevaluacion->listaGrupoEstandaresAutoevaluacion();
            break;

        case 'listaTipoEquipoDg':
            $listaTipoEquipoDg = new ParametricasAjax();
            $listaTipoEquipoDg->listaTipoEquipoDg();
            break;

        case 'listaCaracteristicasInstaDt':
            $listaCaracteristicasInstaDt = new ParametricasAjax();
            $listaCaracteristicasInstaDt->listaCaracteristicasInstaDt();
            break;

        case 'listaFuenteAlimentacionDt':
            $listaFuenteAlimentacionDt = new ParametricasAjax();
            $listaFuenteAlimentacionDt->listaFuenteAlimentacionDt();
            break;

        case 'listaTecnologiaPredoDt':
            $listaTecnologiaPredoDt = new ParametricasAjax();
            $listaTecnologiaPredoDt->listaTecnologiaPredoDt();
            break;

        case 'listaClasificiacionRiesgoDg':
            $listaClasificiacionRiesgoDg = new ParametricasAjax();
            $listaClasificiacionRiesgoDg->listaClasificiacionRiesgoDg();
            break;

        case 'listaClasificiacionBiomedicaDg':
            $listaClasificiacionBiomedicaDg = new ParametricasAjax();
            $listaClasificiacionBiomedicaDg->listaClasificiacionBiomedicaDg();
            break;

        case 'listaServiciosDg':
            $listaServiciosDg = new ParametricasAjax();
            $listaServiciosDg->listaServiciosDg();
            break;

        case 'listaSedesDg':
            $listaSedesDg = new ParametricasAjax();
            $listaSedesDg->listaSedesDg();
            break;

        case 'listaDestinatarios':
            $listaDestinatarios = new ParametricasAjax();
            $listaDestinatarios->listaDestinatarios();
            break;

        case 'listaAuditoresAudProfesional':
            $listaAuditoresAudProfesional = new ParametricasAjax();
            $listaAuditoresAudProfesional->listaAuditoresAudProfesional();
            break;

        case 'listaEspecialidadesProfesional':
            $listaEspecialidadesProfesional = new ParametricasAjax();
            $listaEspecialidadesProfesional->listaEspecialidadesProfesional();
            break;

        case 'listaManualesProyecto':
            $listaManualesProyecto = new ParametricasAjax();
            $listaManualesProyecto->listaManualesProyecto($_POST["proyecto"]);
            break;

        case 'listaSectorHv':
            $listaSectorHv = new ParametricasAjax();
            $listaSectorHv->listaSectorHv();
            break;

        case 'listaNacionalidadHv':
            $listaNacionalidadHv = new ParametricasAjax();
            $listaNacionalidadHv->listaNacionalidadHv();
            break;

        case 'listaSedesPqrReportesOptionTodos':
            $listaSedesPqrReportesOptionTodos = new ParametricasAjax();
            $listaSedesPqrReportesOptionTodos->listaSedesPqrReportesOptionTodos();
            break;

        case 'listaEpsSedePqrsf':
            $listaEpsSedePqrsf = new ParametricasAjax();
            $listaEpsSedePqrsf->listaEpsSedePqrsf($_POST["sede"]);
            break;

        case 'listaResponsablesProyectosCorrespondencia':
            $listaResponsablesProyectosCorrespondencia = new ParametricasAjax();
            $listaResponsablesProyectosCorrespondencia->listaResponsablesProyectosCorrespondencia();
            break;

        case 'listaSedeEpsPqrsf':
            $listaSedeEpsPqrsf = new ParametricasAjax();
            $listaSedeEpsPqrsf->listaSedeEpsPqrsf($_POST["eps"]);
            break;

        case 'listaSedesPqrReportes':
            $listaSedesPqrReportes = new ParametricasAjax();
            $listaSedesPqrReportes->listaSedesPqrReportes();
            break;

        case 'listaServiciosDI':
            $listaServiciosDI = new ParametricasAjax();
            $listaServiciosDI->listaServiciosDI();
            break;

        case 'listaPlaAcDonde':
            $listaPlaAcDonde = new ParametricasAjax();
            $listaPlaAcDonde->listaPlaAcDonde();
            break;

        case 'listaEpsSedePqr':
            $listaEpsSedePqr = new ParametricasAjax();
            $listaEpsSedePqr->listaEpsSedePqr($_POST["sede"]);
            break;

        case 'listaTrabajadorRelaPqr':
            $listaTrabajadorRelaPqr = new ParametricasAjax();
            $listaTrabajadorRelaPqr->listaTrabajadorRelaPqr();
            break;

        case 'listaGestoresProgramaPqr':
            $listaGestoresProgramaPqr = new ParametricasAjax();
            $listaGestoresProgramaPqr->listaGestoresProgramaPqr($_POST["programa"]);
            break;

        case 'listaPlanAccionQuienPqr':
            $listaPlanAccionQuienPqr = new ParametricasAjax();
            $listaPlanAccionQuienPqr->listaPlanAccionQuienPqr();
            break;

        case 'infoMotivoPQRSF':
            $infoMotivoPQRSF = new ParametricasAjax();
            $infoMotivoPQRSF->infoMotivoPQRSF($_POST["motivoPQRS"]);
            break;

        case 'listaEntesPqr':
            $listaEntesPqr = new ParametricasAjax();
            $listaEntesPqr->listaEntesPqr();
            break;

        case 'listaSedesPqr':
            $listaSedesPqr = new ParametricasAjax();
            $listaSedesPqr->listaSedesPqr($_POST["programa"]);
            break;

        case 'listaProgramasPqr':
            $listaProgramasPqr = new ParametricasAjax();
            $listaProgramasPqr->listaProgramasPqr();
            break;

        case 'listaRecursosPqr':
            $listaRecursosPqr = new ParametricasAjax();
            $listaRecursosPqr->listaRecursosPqr();
            break;

        case 'listaClasificacionesAtributosPqr':
            $listaClasificacionesAtributosPqr = new ParametricasAjax();
            $listaClasificacionesAtributosPqr->listaClasificacionesAtributosPqr();
            break;

        case 'listaServiciosAreasPqr':
            $listaServiciosAreasPqr = new ParametricasAjax();
            $listaServiciosAreasPqr->listaServiciosAreasPqr();
            break;

        case 'listaMotivosPqr':
            $listaMotivosPqr = new ParametricasAjax();
            $listaMotivosPqr->listaMotivosPqr();
            break;

        case 'listaTiposPqr':
            $listaTiposPqr = new ParametricasAjax();
            $listaTiposPqr->listaTiposPqr();
            break;

        case 'listaMediosRecepcionPqr':
            $listaMediosRecepcionPqr = new ParametricasAjax();
            $listaMediosRecepcionPqr->listaMediosRecepcionPqr();
            break;

        case 'listaEpsPqr':
            $listaEpsPqr = new ParametricasAjax();
            $listaEpsPqr->listaEpsPqr();
            break;

        case 'listaLocalidades':
            $listaLocalidades = new ParametricasAjax();
            $listaLocalidades->listaLocalidades();
            break;

        case 'verDatoParametrica':
            $verDatoParametrica = new ParametricasAjax();
            $verDatoParametrica->verDatoParametrica($_POST["parametrica"], $_POST["dato"]);
            break;

        case 'listaPrioridades':
            $listaPrioridades = new ParametricasAjax();
            $listaPrioridades->listaPrioridades();
            break;

        case 'listaProyectos':
            $listaProyectos = new ParametricasAjax();
            $listaProyectos->listaProyectos();
            break;

        case 'listaTipoDocumento':
            $listaTipoDocumento = new ParametricasAjax();
            $listaTipoDocumento->listaTipoDocumento();
            break;

        case 'listaEstadoCivil':
            $listaEstadoCivil = new ParametricasAjax();
            $listaEstadoCivil->listaEstadoCivil();
            break;

        case 'listaGenero':
            $listaGenero = new ParametricasAjax();
            $listaGenero->listaGenero();
            break;

        case 'listaDepartamentos':
            $listaDepartamentos = new ParametricasAjax();
            $listaDepartamentos->listaDepartamentos();
            break;

        case 'listaMunicipiosDepartamento':
            $listaCiudadesDepartamento = new ParametricasAjax();
            $listaCiudadesDepartamento->listaCiudadesDepartamento($_POST["departamento"]);
            break;

        case 'listaEscolaridad':
            $listaEscolaridad = new ParametricasAjax();
            $listaEscolaridad->listaEscolaridad();
            break;

        case 'listaVinculaciones':
            $listaVinculacion = new ParametricasAjax();
            $listaVinculacion->listaVinculacion();
            break;

        case 'listaOcupaciones':
            $listaOcupaciones = new ParametricasAjax();
            $listaOcupaciones->listaOcupaciones();
            break;

        case 'listaGrupoPoblacional':
            $listaGruposPoblacionales = new ParametricasAjax();
            $listaGruposPoblacionales->listaGruposPoblacionales();
            break;

        case 'listaPertenenciaEtnica':
            $listaPertenenciaEtnica = new ParametricasAjax();
            $listaPertenenciaEtnica->listaPertinenciaEtnica();
            break;

        case 'listaRegimenes':
            $listaRegimenes = new ParametricasAjax();
            $listaRegimenes->listaRegimenes();
            break;

        case 'listaTipoUsuariosRips':
            $listaTipUsuRips = new ParametricasAjax();
            $listaTipUsuRips->listaTipoUsuarioRips();
            break;

        case 'listaTipoAfiliaciones':
            $listaTipoAfiliaciones = new ParametricasAjax();
            $listaTipoAfiliaciones->listaTipoAfiliaciones();
            break;

        case 'listaEntidadesActuales':
            $listaEntActuales = new ParametricasAjax();
            $listaEntActuales->listaEntidadesActuales();
            break;

        case 'listaModCopagos':
            $listaModCopagos = new ParametricasAjax();
            $listaModCopagos->listaModCopagos();
            break;

        case 'listaCopagosFe':
            $listaCopagosFe = new ParametricasAjax();
            $listaCopagosFe->listaCopagosFe();
            break;

        case 'listaSedesReclaMedicamentos':
            $listaSedesReclaMedicamentos = new ParametricasAjax();
            $listaSedesReclaMedicamentos->listaSedesReclaMedicamentos();
            break;

        case 'listaPaquetesAtencion':
            $listaPaquetesAtencion = new ParametricasAjax();
            $listaPaquetesAtencion->listaPaquetesAtencion();
            break;

        case 'listaNotificadosSivigila':
            $listaNotificadosSivigila = new ParametricasAjax();
            $listaNotificadosSivigila->listaNotificadosSivigila();
            break;

        case 'listaZonas':
            $listaZonas = new ParametricasAjax();
            $listaZonas->listaZonas();
            break;

        case 'listaPaisesOrigen':
            $listaPaisesOrigen = new ParametricasAjax();
            $listaPaisesOrigen->listaPaisesOrigen();
            break;

        case 'listaCausalesComunicacionesFallidas':
            $listaCausalesComunicacionesFallidas = new ParametricasAjax();
            $listaCausalesComunicacionesFallidas->listaCausalesComunicacionesFallidas();
            break;

        case 'listaProfesionalesAgenda':
            $listaProfesionalesAgenda = new ParametricasAjax();
            $listaProfesionalesAgenda->listaProfesionalesAgenda();
            break;

        case 'listarPamecParEstandar':
            $listarPamecParEstandar = new ParametricasAjax();
            $listarPamecParEstandar->listarPamecParEstandar($_POST["select"]);
            break;
        
        case 'listaPeriodosConsultaAutoevaluacion':
            $listaPeriodosConsultaAutoevaluacion = new ParametricasAjax();
            $listaPeriodosConsultaAutoevaluacion->listaPeriodosConsultaAutoevaluacion();
            break;

        case 'listaPeriodosPamec':
            $listaPeriodosPamec = new ParametricasAjax();
            $listaPeriodosPamec->listaPeriodosPamecReporteAvance();
            break;

        case 'listaTiposContratos':
            $listaTiposContratos = new ParametricasAjax();
            $listaTiposContratos->listaTiposContratos();
            break;
        
    }
}

<?php

require_once "../../controllers/inventario/inventario-biomedico.controller.php";
require_once "../../models/inventario/inventario-biomedico.model.php";

class InventarioBiomedicoAjax{

    public $datos;

    public function guardarDatosEquipoBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrGuardarDatosEquipoBiomedico($datos);

        echo json_encode($respuesta);

    }


    public function infoDatosEquipoBiomedico($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrInfoDatosEquipoBiomedico($idEquipoBiomedico);

        echo json_encode($respuesta);

    }


    public function editarDatosEquipoBiomedico(){

        $datos = $this->datos;
        
        $respuesta = ControladorInventarioBiomedico::ctrEditarDatosEquipoBiomedico($datos);

        echo $respuesta;

    }


    public function crearManualBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrCrearManualBiomedico($datos);

        echo $respuesta;

    }


    public function listaEquipoBiomedicoManuales($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoManuales($idEquipoBiomedico);

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


    public function crearPlanoBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrCrearPlanoBiomedico($datos);

        echo $respuesta;

    }


    public function listaEquipoBiomedicoPlanos($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoPlanos($idEquipoBiomedico);

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


    public function crearRecomendacionBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrCrearRecomendacionBiomedico($datos);

        echo $respuesta;

    }


    public function listaEquipoBiomedicoRecomendaciones($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoRecomendaciones($idEquipoBiomedico);

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


    public function crearComponenteCaracteristica(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrCrearComponenteCaracteristica($datos);

        echo $respuesta;

    }


    public function listaEquipoBiomedicoComponentesCaracteristicas($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoComponentesCaracteristicas($idEquipoBiomedico);

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


    public function guardarHistoricoEquipoBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrGuardarHistoricoEquipoBiomedico($datos);

        echo $respuesta;

    }

    public function infoDatosEquipoBiomedicoHistorico($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrInfoDatosEquipoBiomedicoHistorico($idEquipoBiomedico);

        echo json_encode($respuesta);

    }

    public function eliminarManualBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrEliminarManualBiomedico($datos);

        echo json_encode($respuesta);

    }

    public function eliminarPlanoBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrEliminarPlanoBiomedico($datos);

        echo json_encode($respuesta);

    }


    public function eliminarRecomendacionBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrEliminarRecomendacionBiomedico($datos);

        echo json_encode($respuesta);

    }

    public function eliminarComponenteAccesorioBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrEliminarComponenteAccesorioBiomedico($datos);

        echo json_encode($respuesta);

    }

    public function listaEquiposBiomedicos(){

        $respuesta = ControladorInventarioBiomedico::ctrListaEquiposBiomedicos();

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


    public function infoComponenteAccesorio($idCompoAcceso){

        $tabla = "inventario_equipos_biomedicos_componentes_caracteristicas";
        $item = "id_compo_caract";
        $valor = $idCompoAcceso;

        $respuesta = ControladorInventarioBiomedico::ctrObtenerDato($tabla, $item, $valor);

        echo json_encode($respuesta);

    }

    public function infoRecomendacionFabricante($idRecomendacion){

        $tabla = "inventario_equipos_biomedicos_recomendaciones";
        $item = "id_recomendacion";
        $valor = $idRecomendacion;

        $respuesta = ControladorInventarioBiomedico::ctrObtenerDato($tabla, $item, $valor);

        echo json_encode($respuesta);

    }

    public function listaEstadosGarantiaBiomedicos(){

        $respuesta = ControladorInventarioBiomedico::ctrListaEstadosGarantiaBiomedicos();

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

    public function listaTiposMantenimientosBiomedicos($opciones){

        $tabla = "inventario_par_tipos_mantenimientos_biomedicos";
        $item = null;
        $valor = null;

        $resultado = ControladorInventarioBiomedico::ctrObtenerDatosActivos($tabla, $item, $valor);

        $arrayOpciones = explode('|', $opciones);

        $cadena = '';
        
        foreach ($resultado as $key => $value) {

            if(in_array($value["tipo"], $arrayOpciones)){

                $cadena .= '<option value="'.$value["tipo"].'" selected>'.$value["tipo"].' - '.$value["nombre"].'</option>';
                
            }else{
                
                $cadena .= '<option value="'.$value["tipo"].'">'.$value["tipo"].' - '.$value["nombre"].'</option>';

            }


        }

        echo $cadena;
        
    }

    public function listaTiposMantenimientosBiomedicosMantenimiento($opciones){

        $tabla = "inventario_par_tipos_mantenimientos_biomedicos";
        $item = null;
        $valor = null;

        $resultado = ControladorInventarioBiomedico::ctrObtenerDatosActivos($tabla, $item, $valor);

        $arrayOpciones = explode('|', $opciones);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipo Mantenimiento</option>';
        
        foreach ($resultado as $key => $value) {

            if(in_array($value["tipo"], $arrayOpciones)){

                $cadena .= '<option value="'.$value["tipo"].'">'.$value["tipo"].' - '.$value["nombre"].'</option>';
                
            }


        }

        echo $cadena;

    }


    public function agregarMantenimientoBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrAgregarMantenimientoBiomedico($datos);

        echo $respuesta;

    }


    public function listaMantenimientosEquiposBiomedicos($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrListaMantenimientosEquiposBiomedicos($idEquipoBiomedico);

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

    public function validacionMantenimientoEquipoBiomedico($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrValidacionMantenimientoEquipoBiomedico($idEquipoBiomedico);

        echo json_encode($respuesta);

    }

    public function agregarSolicitudTrasladoEquipoBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrAgregarSolicitudTrasladoEquipoBiomedico($datos);

        echo $respuesta;

    }


    public function listaSolicitudesTrasladoEquipoBio($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrListaSolicitudesTrasladoEquipoBio($idEquipoBiomedico);

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

    public function agregarSolicitudMantenimientoCorrectivoEquipoBio(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrAgregarSolicitudMantenimientoCorrectivoEquipoBio($datos);

        echo $respuesta;

    }


    public function listaSolicitudesMantenimientosEquipoBio($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrListaSolicitudesMantenimientosEquipoBio($idEquipoBiomedico);

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


    public function agregarSolicitudBajaEquipoBio(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico:: ctrAgregarSolicitudBajaEquipoBio($datos);

        echo $respuesta;

    }


    public function listaSolicitudesActaBajaEquipoBio($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrListaSolicitudesActaBajaEquipoBio($idEquipoBiomedico);

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

    public function eliminarMantenimientoBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrEliminarMantenimientoBiomedico($datos);

        echo json_encode($respuesta);

    }

    public function listaEstadosMantenimientosBiomedicosMto(){

        $respuesta = ControladorInventarioBiomedico::ctrListaEstadosMantenimientosBiomedicosMto();

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

    public function agregarTipoMantenimientoBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrAgregarTipoMantenimientoBiomedico($datos);

        echo $respuesta;


    }

    public function listaEquipoBiomedicoTiposMantenimientos($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoTiposMantenimientos($idEquipoBiomedico);

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

    public function eliminarTipoMantenimientoBiomedico(){

        $datos = $this->datos;

        $respuesta = ControladorInventarioBiomedico::ctrEliminarTipoMantenimientoBiomedico($datos);

        echo json_encode($respuesta);

    }


    public function listaTipoMantenimientosEquipoBiomedico($idEquipoBiomedico){

        $resultado = ControladorInventarioBiomedico::ctrObtenerTiposMantenimientosEquipoBiomedico($idEquipoBiomedico);

        $cadena = '';

        $cadena .= '<option value="">Seleccione Tipo Mantenimiento</option>';

        foreach ($resultado as $key => $value) {

            $cadena .= '<option value="' . $value["tipo_mantenimiento"] . '">' . $value["tipo_mantenimiento"] . '</option>';
        }

        echo $cadena;
    }

    public function listaEstadosMantenimientosBiomedicosClbr(){

        $respuesta = ControladorInventarioBiomedico::ctrListaEstadosMantenimientosBiomedicosClbr();

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

    public function listaEstadosMantenimientosBiomedicosVld(){

        $respuesta = ControladorInventarioBiomedico::ctrListaEstadosMantenimientosBiomedicosVld();

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

    public function listaEstadosMantenimientosBiomedicosCl(){

        $respuesta = ControladorInventarioBiomedico::ctrListaEstadosMantenimientosBiomedicosCl();

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

    public function obtenerTiposMantenimientosBiomedicos($idEquipoBiomedico){

        $respuesta = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoTiposMantenimientos($idEquipoBiomedico);

        echo json_encode($respuesta);

    }

    public function validacionTipoMantenimiento($idEquipoBiomedico, $tipoMantenimiento){

        $respuesta = ControladorInventarioBiomedico::ctrValidacionTipoMantenimiento($idEquipoBiomedico, $tipoMantenimiento);

        echo json_encode($respuesta);

    }

    public function listaEquiposBiomedicosReserva(){

        $respuesta = ControladorInventarioBiomedico::ctrListaEquiposBiomedicosReserva();

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

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch($proceso){

        case 'listaEquiposBiomedicosReserva':
            $listaEquiposBiomedicosReserva = new InventarioBiomedicoAjax();
            $listaEquiposBiomedicosReserva->listaEquiposBiomedicosReserva();
            break;

        case 'validacionTipoMantenimiento':
            $validacionTipoMantenimiento = new InventarioBiomedicoAjax();
            $validacionTipoMantenimiento->validacionTipoMantenimiento($_POST["idEquipoBiomedico"], $_POST["tipoMantenimiento"]);
            break;

        case 'obtenerTiposMantenimientosBiomedicos':
            $obtenerTiposMantenimientosBiomedicos = new InventarioBiomedicoAjax();
            $obtenerTiposMantenimientosBiomedicos->obtenerTiposMantenimientosBiomedicos($_POST["idEquipoBiomedico"]);
            break;

        case 'listaEstadosMantenimientosBiomedicosCl':
            $listaEstadosMantenimientosBiomedicosCl = new InventarioBiomedicoAjax();
            $listaEstadosMantenimientosBiomedicosCl->listaEstadosMantenimientosBiomedicosCl();
            break;

        case 'listaEstadosMantenimientosBiomedicosVld':
            $listaEstadosMantenimientosBiomedicosVld = new InventarioBiomedicoAjax();
            $listaEstadosMantenimientosBiomedicosVld->listaEstadosMantenimientosBiomedicosVld();
            break;

        case 'listaEstadosMantenimientosBiomedicosClbr':
            $listaEstadosMantenimientosBiomedicosClbr = new InventarioBiomedicoAjax();
            $listaEstadosMantenimientosBiomedicosClbr->listaEstadosMantenimientosBiomedicosClbr();
            break;

        case 'listaTipoMantenimientosEquipoBiomedico':
            $listaTipoMantenimientosEquipoBiomedico = new InventarioBiomedicoAjax();
            $listaTipoMantenimientosEquipoBiomedico->listaTipoMantenimientosEquipoBiomedico($_POST["idEquipoBiomedico"]);
            break;

        case 'eliminarTipoMantenimientoBiomedico':
            $eliminarTipoMantenimientoBiomedico = new InventarioBiomedicoAjax();
            $eliminarTipoMantenimientoBiomedico->datos = array(
                "id_tipo_mante_bio" => $_POST["idTipoMantenimiento"],
                "usuario_elimina" => $_POST["userSesion"]
            );
            $eliminarTipoMantenimientoBiomedico->eliminarTipoMantenimientoBiomedico();
            break;

        case 'listaEquipoBiomedicoTiposMantenimientos':
            $listaEquipoBiomedicoTiposMantenimientos = new InventarioBiomedicoAjax();
            $listaEquipoBiomedicoTiposMantenimientos->listaEquipoBiomedicoTiposMantenimientos($_POST["idEquipoBiomedico"]);
            break;

        case 'agregarTipoMantenimientoBiomedico':
            $agregarTipoMantenimientoBiomedico = new InventarioBiomedicoAjax();
            $agregarTipoMantenimientoBiomedico->datos = array(
                "id_equipo_biomedico" => $_POST["idEquipoBiomedico"],
                "tipo_mantenimiento" => $_POST["tMTipoMantenimientoEquipo"],
                "frecuencia" => $_POST["tmFrecuencia"],
                "usuario_crea" => $_POST["user"]
            );
            $agregarTipoMantenimientoBiomedico->agregarTipoMantenimientoBiomedico();
            break;

        case 'listaEstadosMantenimientosBiomedicosMto':
            $listaEstadosMantenimientosBiomedicosMto = new InventarioBiomedicoAjax();
            $listaEstadosMantenimientosBiomedicosMto->listaEstadosMantenimientosBiomedicosMto();
            break;

        case 'eliminarMantenimientoBiomedico':
            $eliminarMantenimientoBiomedico = new InventarioBiomedicoAjax();
            $eliminarMantenimientoBiomedico->datos = array(
                "id_mantenimiento_biomedico" => $_POST["idManteniBiomedico"],
                "usuario_elimina" => $_POST["userSesion"]
            );
            $eliminarMantenimientoBiomedico->eliminarMantenimientoBiomedico();
            break;

        case 'listaSolicitudesActaBajaEquipoBio':
            $listaSolicitudesActaBajaEquipoBio = new InventarioBiomedicoAjax();
            $listaSolicitudesActaBajaEquipoBio->listaSolicitudesActaBajaEquipoBio($_POST["idEquipoBiomedico"]);
            break;

        case 'agregarSolicitudBajaEquipoBio':
            $agregarSolicitudBajaEquipoBio = new InventarioBiomedicoAjax();
            $agregarSolicitudBajaEquipoBio->datos = array(
                "nombre_solicitante" => mb_strtoupper($_POST["sABEBNombreSolicitante"]),
                "cargo" => mb_strtoupper($_POST["sABEBCargo"]),
                "concepto_baja" => mb_strtoupper($_POST["sABEBConceptoDarBaja"]),
                "reciclaje" => $_POST["sABEBReciclaje"],
                "empresa_responsable_reci" => mb_strtoupper($_POST["sABEBEmpresaResponsableRe"]),
                "disposicion" => $_POST["sABEBDisposicionFinal"],
                "empresa_responsable_dispo" => mb_strtoupper($_POST["sABEBEmpresaResponsableDis"]),
                "id_equipo_biomedico" => $_POST["idEquipoBiomedico"],
                "usuario_crea" => $_POST["user"],
            );
            $agregarSolicitudBajaEquipoBio->agregarSolicitudBajaEquipoBio();
            break;

        case 'listaSolicitudesMantenimientosEquipoBio':
            $listaSolicitudesMantenimientosEquipoBio = new InventarioBiomedicoAjax();
            $listaSolicitudesMantenimientosEquipoBio->listaSolicitudesMantenimientosEquipoBio($_POST["idEquipoBiomedico"]);
            break;

        case 'agregarSolicitudMantenimientoCorrectivoEquipoBio':
            $agregarSolicitudMantenimientoCorrectivoEquipoBio = new InventarioBiomedicoAjax();
            $agregarSolicitudMantenimientoCorrectivoEquipoBio->datos = array(
                "orden_no" => mb_strtoupper($_POST["sMCEBOrdenNo"]),
                "cargo" => mb_strtoupper($_POST["sMCEBCargo"]),
                "descripcion_incidencia" => mb_strtoupper($_POST["sMCEBDescripcionIncidencia"]),
                "fecha_ejecucion" => $_POST["sMCEBFechaEjecucion"],
                "responsable" => mb_strtoupper($_POST["sMCEBResponsable"]),
                "requiere_repuesto" => $_POST["sMCEBRequiereRepuesto"],
                "repuestos_necesarios" => mb_strtoupper($_POST["sMCEBRepuestosNecesarios"]),
                "descripcion_falla" => mb_strtoupper($_POST["sMCEBDescripcionFalla"]),
                "id_equipo_biomedico" => $_POST["idEquipoBiomedico"],
                "usuario_crea" => $_POST["user"]
            );
            $agregarSolicitudMantenimientoCorrectivoEquipoBio->agregarSolicitudMantenimientoCorrectivoEquipoBio();
            break;

        case 'listaSolicitudesTrasladoEquipoBio':
            $listaSolicitudesTrasladoEquipoBio = new InventarioBiomedicoAjax();
            $listaSolicitudesTrasladoEquipoBio->listaSolicitudesTrasladoEquipoBio($_POST["idEquipoBiomedico"]);
            break;

        case 'agregarSolicitudTrasladoEquipoBiomedico':
            $agregarSolicitudTrasladoEquipoBiomedico = new InventarioBiomedicoAjax();
            $agregarSolicitudTrasladoEquipoBiomedico->datos = array(
                "tiempo_estimado_salida" => $_POST["sEBTiempoEstimadoSalida"],
                "motivo_salida" => mb_strtoupper($_POST["sEBMotivoSalida"]),
                "observaciones" => mb_strtoupper($_POST["sEBObservaciones"]),
                "sede_new" => $_POST["sEBSede"],
                "activo_fijo_new" => mb_strtoupper($_POST["sEBActivoFijo"]),
                "ubicacion_new" => mb_strtoupper($_POST["sEBUbicacion"]),
                "id_equipo_biomedico" => $_POST["idEquipoBiomedico"],
                "usuario_crea" => $_POST["user"],
                "recibido_por" => mb_strtoupper($_POST["sEBRecibidoPor"])
            );
            $agregarSolicitudTrasladoEquipoBiomedico->agregarSolicitudTrasladoEquipoBiomedico();
            break;

        case 'validacionMantenimientoEquipoBiomedico':
            $validacionMantenimientoEquipoBiomedico = new InventarioBiomedicoAjax();
            $validacionMantenimientoEquipoBiomedico->validacionMantenimientoEquipoBiomedico($_POST["idEquipoBiomedico"]);
            break;
        
        case 'listaMantenimientosEquiposBiomedicos':
            $listaMantenimientosEquiposBiomedicos = new InventarioBiomedicoAjax();
            $listaMantenimientosEquiposBiomedicos->listaMantenimientosEquiposBiomedicos($_POST["idEquipoBiomedico"]);
            break;

        case 'agregarMantenimientoBiomedico':
            $agregarMantenimientoBiomedico = new InventarioBiomedicoAjax();
            if(isset($_FILES["tMArchivoMantenimiento"])){$archivoMantenimiento = $_FILES["tMArchivoMantenimiento"];}else{$archivoMantenimiento = 'VACIO';}
            $agregarMantenimientoBiomedico->datos = array(
                "id_equipo_biomedico" => $_POST["idEquipoBiomedico"],
                "tipo_mantenimiento" => $_POST["tMTipoMantenimiento"],
                "fecha_mantenimiento" => $_POST["tmFechaMantenimiento"],
                "observaciones_mantenimiento" => mb_strtoupper($_POST["tmObservacionMantenimiento"]),
                "archivoMantenimiento" => $archivoMantenimiento,
                "usuario_crea" => $_POST["user"]
            );
            $agregarMantenimientoBiomedico->agregarMantenimientoBiomedico();
            break;

        case 'listaTiposMantenimientosBiomedicosMantenimiento':
            $listaTiposMantenimientosBiomedicosMantenimiento = new InventarioBiomedicoAjax();
            $listaTiposMantenimientosBiomedicosMantenimiento->listaTiposMantenimientosBiomedicosMantenimiento($_POST["opciones"]);
            break;

        case 'listaTiposMantenimientosBiomedicos':
            $listaTiposMantenimientosBiomedicos = new InventarioBiomedicoAjax();
            $listaTiposMantenimientosBiomedicos->listaTiposMantenimientosBiomedicos($_POST["opciones"]);
            break;

        case 'listaEstadosGarantiaBiomedicos':
            $listaEstadosGarantiaBiomedicos = new InventarioBiomedicoAjax();
            $listaEstadosGarantiaBiomedicos->listaEstadosGarantiaBiomedicos();
            break;

        case 'infoRecomendacionFabricante':
            $infoRecomendacionFabricante = new InventarioBiomedicoAjax();
            $infoRecomendacionFabricante->infoRecomendacionFabricante($_POST["idRecomendacion"]);
            break;

        case 'infoComponenteAccesorio':
            $infoComponenteAccesorio = new InventarioBiomedicoAjax();
            $infoComponenteAccesorio->infoComponenteAccesorio($_POST["idCompoAccesorio"]);
            break;

        case 'listaEquiposBiomedicos':
            $listaEquiposBiomedicos = new InventarioBiomedicoAjax();
            $listaEquiposBiomedicos->listaEquiposBiomedicos();
            break;

        case 'eliminarComponenteAccesorioBiomedico':
            $eliminarComponenteAccesorioBiomedico = new InventarioBiomedicoAjax();
            $eliminarComponenteAccesorioBiomedico->datos = array(
                "id_compo_caract" => $_POST["idCompoAcceso"],
                "usuario" => $_POST["userSesion"]
            );
            $eliminarComponenteAccesorioBiomedico->eliminarComponenteAccesorioBiomedico();
            break;

        case 'eliminarRecomendacionBiomedico':
            $eliminarRecomendacionBiomedico = new InventarioBiomedicoAjax();
            $eliminarRecomendacionBiomedico->datos = array(
                "id_recomendacion" => $_POST["idRecomendacion"],
                "usuario" => $_POST["userSesion"]
            );
            $eliminarRecomendacionBiomedico->eliminarRecomendacionBiomedico();
            break;

        case 'eliminarPlanoBiomedico':
            $eliminarPlanoBiomedico = new InventarioBiomedicoAjax();
            $eliminarPlanoBiomedico->datos = array(
                "id_plano" => $_POST["idPlano"],
                "usuario" => $_POST["userSesion"],
            );
            $eliminarPlanoBiomedico->eliminarPlanoBiomedico();
            break;

        case 'eliminarManualBiomedico':
            $eliminarManualBiomedico = new InventarioBiomedicoAjax();
            $eliminarManualBiomedico->datos = array(
                "id_manual" => $_POST["idManual"],
                "usuario" => $_POST["userSesion"],
            );
            $eliminarManualBiomedico->eliminarManualBiomedico();
            break;

        case 'infoDatosEquipoBiomedicoHistorico':
            $infoDatosEquipoBiomedicoHistorico = new InventarioBiomedicoAjax();
            $infoDatosEquipoBiomedicoHistorico->infoDatosEquipoBiomedicoHistorico($_POST["idEquipoBiomedico"]);
            break;

        case 'guardarHistoricoEquipoBiomedico':
            $guardarHistoricoEquipoBiomedico = new InventarioBiomedicoAjax();
            $guardarHistoricoEquipoBiomedico->datos = array(
                "id_equipo_biomedico" => $_POST["idEquipoBiomedico"],
                "numero_factura" => mb_strtoupper($_POST["hENumeroFactura"]),
                "forma_adquisicion" => mb_strtoupper($_POST["hEFormaAdqui"]),
                "vida_util" => mb_strtoupper($_POST["hEVidaUtilEquipo"]),
                "valor_iva" => $_POST["hEValorIvaIncluido"],
                "compra" => mb_strtoupper($_POST["hECompra"]),
                "instalacion" => mb_strtoupper($_POST["hEInstalacion"]),
                "recibido" => mb_strtoupper($_POST["hERecibido"]),
                "fecha_inicio_garantia" => $_POST["hEFechaIniGarantia"],
                "fecha_fin_garantia" => $_POST["hEFechaFinGarantia"],
                "garantia_anios" => $_POST["hEGarantiaAnios"],
                "fabricante" => mb_strtoupper($_POST["hEFabricante"]),
                "nombre_contacto" => mb_strtoupper($_POST["hENombreContacto"]),
                "representante" => mb_strtoupper($_POST["hERepresentante"]),
                "telefono" => $_POST["hETelefono"],
                "correo_electronico" => mb_strtoupper($_POST["hECorreoElectronico"]),
                "cargo_puesto" => mb_strtoupper($_POST["hECargoPuesto"]),
                "proveedor" => mb_strtoupper($_POST["hEProveedor"]),
                "celular" => $_POST["hECelular"],
                "usuario_crea" => $_POST["user"]
            );
            $guardarHistoricoEquipoBiomedico->guardarHistoricoEquipoBiomedico();
            break;

        case 'listaEquipoBiomedicoComponentesCaracteristicas':
            $listaEquipoBiomedicoComponentesCaracteristicas = new InventarioBiomedicoAjax();
            $listaEquipoBiomedicoComponentesCaracteristicas->listaEquipoBiomedicoComponentesCaracteristicas($_POST["idEquipoBiomedico"]);
            break;

        case 'crearComponenteCaracteristica':
        $crearComponenteCaracteristica = new InventarioBiomedicoAjax();
        $crearComponenteCaracteristica->datos = array(
            "id_equipo_biomedico" => $_POST["idEquipoBiomedico"],
            "componente_caracteristica" => mb_strtoupper($_POST["cAECompoCaracte"]),
            "cantidad" => $_POST["cAECantidad"],
            "usuario_crea" => $_POST["user"]
        );
        $crearComponenteCaracteristica->crearComponenteCaracteristica();
        break;

        case 'listaEquipoBiomedicoRecomendaciones':
            $listaEquipoBiomedicoRecomendaciones = new InventarioBiomedicoAjax();
            $listaEquipoBiomedicoRecomendaciones->listaEquipoBiomedicoRecomendaciones($_POST["idEquipoBiomedico"]);
            break;

        case 'crearRecomendacionBiomedico':
            $crearRecomendacionBiomedico = new InventarioBiomedicoAjax();
            $crearRecomendacionBiomedico->datos = array(
                "id_equipo_biomedico" => $_POST["idEquipoBiomedico"],
                "recomendacion" => mb_strtoupper($_POST["rFRecomendacion"]),
                "usuario_crea" => $_POST["user"]
            );
            $crearRecomendacionBiomedico->crearRecomendacionBiomedico();
            break;

        case 'listaEquipoBiomedicoPlanos':
            $listaEquipoBiomedicoPlanos = new InventarioBiomedicoAjax();
            $listaEquipoBiomedicoPlanos->listaEquipoBiomedicoPlanos($_POST["idEquipoBiomedico"]);
            break;

        case 'crearPlanoBiomedico':
            $crearPlanoBiomedico = new InventarioBiomedicoAjax();
            $crearPlanoBiomedico->datos = array(
                "id_equipo_biomedico" => $_POST["idEquipoBiomedico"],
                "tipo_plano" => $_POST["pTipoPlano"],
                "nombre_plano" => mb_strtoupper($_POST["pNombrePlano"]),
                "archivoPlano" => $_FILES["pArchivoPlano"],
                "usuario_crea" => $_POST["user"]
            );
            $crearPlanoBiomedico->crearPlanoBiomedico();
            break;

        case 'listaEquipoBiomedicoManuales':
            $listaEquipoBiomedicoManuales = new InventarioBiomedicoAjax();
            $listaEquipoBiomedicoManuales->listaEquipoBiomedicoManuales($_POST["idEquipoBiomedico"]);
            break;

        case 'crearManualBiomedico':
            $crearManualBiomedico = new InventarioBiomedicoAjax();
            $crearManualBiomedico->datos = array(
                "id_equipo_biomedico" => $_POST["idEquipoBiomedico"],
                "nombre_manual" => mb_strtoupper($_POST["mNombreManual"]),
                "tipo_manual" => $_POST["mTipoManual"],
                "archivoManual" => $_FILES["mArchivoManual"],
                "usuario_crea" => $_POST["user"]
            );
            $crearManualBiomedico->crearManualBiomedico();
            break;

        case 'editarDatosEquipoBiomedico':
            $editarDatosEquipoBiomedico = new InventarioBiomedicoAjax();
            $editarDatosEquipoBiomedico->datos = array(
                "id" => $_POST["idEquipoBiomedico"],
                "tipo_equipo" => $_POST["dGTipoEquipo"],
                "nombre_equipo" => mb_strtoupper($_POST["dGNombreEquipo"]),
                "marca" => mb_strtoupper($_POST["dGMarca"]),
                "modelo" => mb_strtoupper($_POST["dGModelo"]),
                "serie" => mb_strtoupper($_POST["dGSerie"]),
                "activo_fijo" => mb_strtoupper($_POST["dGActivoFijo"]),
                "registro_sanitario_invima" => mb_strtoupper($_POST["dGRegistroSaniInvima"]),
                "sede" => $_POST["dGSede"],
                "ubicacion" => mb_strtoupper($_POST["dGUbicacion"]),
                "servicio" => $_POST["dGServicio"],
                "clasificacion_biomedica" => $_POST["dGClasificacionBio"],
                "clasificacion_riesgo" => $_POST["dGClasificacionRiesgo"],
                "tecnologia_predominante" => $_POST["dTTecnologiaPredo"],
                "fuente_alimentacion" => $_POST["dTFuenteAlimen"],
                "caracteristica_instalacion" => $_POST["dTCaracteristicasInsta"],
                "tension_trabajo" => mb_strtoupper($_POST["dTTensionTrabajo"]),
                "consumo_watt" => $_POST["dTConsumoWatt"],
                "peso" => $_POST["dTPeso"],
                "condiciones_ambientales" => mb_strtoupper($_POST["dtCondicionesAmbien"]),
                "usuario_edita" => $_POST["user"],
            );
            $editarDatosEquipoBiomedico->editarDatosEquipoBiomedico();
            break;

        case 'infoDatosEquipoBiomedico':
            $infoDatosEquipoBiomedico = new InventarioBiomedicoAjax();
            $infoDatosEquipoBiomedico->infoDatosEquipoBiomedico($_POST["idEquipoBiomedico"]);
            break;

        case 'guardarDatosEquipoBiomedico':
            $guardarDatosEquipoBiomedico = new InventarioBiomedicoAjax();
            $guardarDatosEquipoBiomedico->datos = array(
                "tipo_equipo" => $_POST["dGTipoEquipo"],
                "nombre_equipo" => mb_strtoupper($_POST["dGNombreEquipo"]),
                "marca" => mb_strtoupper($_POST["dGMarca"]),
                "modelo" => mb_strtoupper($_POST["dGModelo"]),
                "serie" => mb_strtoupper($_POST["dGSerie"]),
                "activo_fijo" => mb_strtoupper($_POST["dGActivoFijo"]),
                "registro_sanitario_invima" => mb_strtoupper($_POST["dGRegistroSaniInvima"]),
                "sede" => $_POST["dGSede"],
                "ubicacion" => mb_strtoupper($_POST["dGUbicacion"]),
                "servicio" => $_POST["dGServicio"],
                "clasificacion_biomedica" => $_POST["dGClasificacionBio"],
                "clasificacion_riesgo" => $_POST["dGClasificacionRiesgo"],
                "tecnologia_predominante" => $_POST["dTTecnologiaPredo"],
                "fuente_alimentacion" => $_POST["dTFuenteAlimen"],
                "caracteristica_instalacion" => $_POST["dTCaracteristicasInsta"],
                "tension_trabajo" => mb_strtoupper($_POST["dTTensionTrabajo"]),
                "consumo_watt" => $_POST["dTConsumoWatt"],
                "peso" => $_POST["dTPeso"],
                "condiciones_ambientales" => mb_strtoupper($_POST["dtCondicionesAmbien"]),
                "usuario_crea" => $_POST["user"],
            );
            $guardarDatosEquipoBiomedico->guardarDatosEquipoBiomedico();
            break;


    }

}
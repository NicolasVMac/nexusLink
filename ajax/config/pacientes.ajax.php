<?php


$rutaControlador =  __DIR__. "\..\..\controllers\config\pacientes.controller.php";
$rutaModelo = __DIR__ . "\..\..\models\config\pacientes.model.php";

//require_once "../../controllers/config/pacientes.controller.php";
//require_once "../../models/config/pacientes.model.php";

require_once $rutaControlador;
require_once $rutaModelo;

class PacientesAjax{

    public $datos;

    public function crearPaciente(){

        $datos = $this->datos;

        $crearPaciente = ControladorPacientes::ctrCrearPaciente($datos);

        echo $crearPaciente;

    }

    public function listaPacientes(){

        $respuesta = ControladorPacientes::ctrMostrarPacientes(null, null);

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

    public function mostrarPaciente($idPaciente){

        $respuesta = ControladorPacientes::ctrMostrarPacientes("id_paciente", $idPaciente);

        echo json_encode($respuesta);

    }

    public function editarPaciente(){

        $datos = $this->datos;

        $editarPaciente = ControladorPacientes::ctrEditarPaciente($datos);

        echo $editarPaciente;

        //echo $datos["cambios_campos"][0];

        // if($datos["cambios_campos"][0] == "Ningun cambio"){

        //     echo "Ningun Cambio";

        // }else{

        //     echo "Hay cambios que guardar";

        // }

    }

    public function validarExisteDocumento($tipoDocumento, $numDocumento){

        $respuesta = ControladorPacientes::ctrValidarExisteDocumento($tipoDocumento, $numDocumento);

        echo json_encode($respuesta);

    }

    public function mostrarPacienteDocumento($tipoDoc, $numeroDoc){

        $respuesta = ControladorPacientes::ctrValidarExisteDocumento($tipoDoc, $numeroDoc);

        echo json_encode($respuesta);

    }

    public function mostrarInfoPacienteId($idPaciente){

        $respuesta = ControladorPacientes::ctrMostrarInfoPacienteId($idPaciente);

        echo json_encode($respuesta);


    }

}

if (isset($_POST['proceso'])) {

    $proceso = $_POST['proceso'];

    switch ($proceso) {

        case 'mostrarInfoPacienteId':
            $mostrarInfoPacienteId = new PacientesAjax();
            $mostrarInfoPacienteId->mostrarInfoPacienteId($_POST["idPaciente"]);
            break;

        case 'mostrarPacienteDocumento':
            $mostrarPacienteDocumento = new PacientesAjax();
            $mostrarPacienteDocumento->mostrarPacienteDocumento($_POST["tipoDoc"], $_POST["numeroDoc"]);
            break;

        case 'validarExisteDocumento':
            $validarExisteDocumento = new PacientesAjax();
            $validarExisteDocumento->validarExisteDocumento($_POST["tipoDocumento"], $_POST["numDocumento"]);
            break;

        case 'listaPacientes':
            $listaPacientes = new PacientesAjax();
            $listaPacientes->listaPacientes();
            break;

        case 'crearPaciente':
            $crearPaciente = new PacientesAjax();
            if(empty($_POST["fechaNotificacionSiviPaciente"])){
                $fechaNotificacionSiviPaciente = null;
            }else{
                $fechaNotificacionSiviPaciente = $_POST["fechaNotificacionSiviPaciente"];
            }
            $crearPaciente->datos = array(

                'numero_documento' => $_POST["numeroIdentificacion"],
                'expedido_en' => strtoupper($_POST["expedidoEn"]),
                'tipo_documento' => $_POST["tipoDocumento"],
                'no_carnet' => $_POST["numeroIdentificacion"],
                'primer_apellido' => strtoupper($_POST["primerApellidoPaciente"]),
                'segundo_apellido' => strtoupper($_POST["segundoApellidoPaciente"]),
                'primer_nombre' => strtoupper($_POST["primerNombrePaciente"]),
                'segundo_nombre' => strtoupper($_POST["segundoNombrePaciente"]),
                'seudonimo_paciente' => strtoupper($_POST["seudonimoPaciente"]),
                'fecha_nacimiento' => $_POST["fechaNacimientoPaciente"],
                'edad_n' => $_POST["edadNPaciente"],
                'edad_t' => $_POST["edadTPaciente"],
                'estado_civil' => $_POST["estadoCivilPaciente"],
                'genero_paciente' => $_POST["generoPaciente"],
                'escolaridad' => $_POST["escolaridadPaciente"],
                'vinculacion' => $_POST["vinculacionPaciente"],
                'ocupacion' => $_POST["ocupacionPaciente"],
                'grupo_poblacional' => $_POST["grupoPoblacionalPaciente"],
                'pertenencia_etnica' => $_POST["pertenenciaEtnicaPaciente"],
                'regimen' => $_POST["regimenPaciente"],
                'tipo_usuario_rips' => $_POST["tipoUsuarioRipsPaciente"],
                'tipo_afiliacion' => $_POST["tipoAfiliacionPaciente"],
                'entidad_af_actual' => $_POST["entidadAfActualPaciente"],
                'mod_copago' => $_POST["modCopagoPaciente"],
                'copago_fe' => $_POST["copagoFePaciente"],
                'nivel_sisben' => $_POST["nivelSisbenPaciente"],
                'departamento_sisben' => $_POST["departamentoSisbenPaciente"],
                'municipio_sisben' => $_POST["municipioSisbenPaciente"],
                'sede_reclama_med' => $_POST["reclamaMediPaciente"],
                'paquete_atencion' => $_POST["paqueteAtencionPaciente"],
                'notifica_sivigila' => $_POST["notificaSivigilaPaciente"],
                'fecha_notificacion_sivigila' => $fechaNotificacionSiviPaciente,
                'ips_notifica' => strtoupper($_POST["ipsNotificaPaciente"]),
                'direccion_ubicacion' => strtoupper($_POST["direccionUbicacionPaciente"]), 
                'latitud_ubicacion' => $_POST["latitudUbicacion"],
                'longitud_ubicacion' => $_POST["longitudUbicacion"],
                'telefono_uno_ubicacion' => $_POST["telefonoUnoPaciente"],
                'telefono_dos_ubicacion' => $_POST["telefonoDosPaciente"],
                'zona_ubicacion' => $_POST["zonaUbicacionPaciente"],
                'departamento_ubicacion' => $_POST["departamentoUbicacionPaciente"],
                'municipio_ubicacion' => $_POST["municipioUbicacionPaciente"],
                'pais_origen' => $_POST["paisOrigenPaciente"],
                'correo' => $_POST["correoPaciente"],
                'nombre_madre' => strtoupper($_POST["nombreMadrePaciente"]),
                'nombre_padre' => strtoupper($_POST["nombrePadrePaciente"]),
                'responsable' => strtoupper($_POST["responsablePaciente"]),
                'parentesco' => strtoupper($_POST["parentescoPaciente"]),
                'direccion_contacto' => strtoupper($_POST["direccionContactoPaciente"]),
                'telefono_contacto' => $_POST["telefonoContactoPaciente"],
                'psudonimo' => strtoupper($_POST["psuodonimoPaciente"]),
                'observacion_contacto' => strtoupper($_POST["observacionContactoPaciente"]),
                'usuario_crea' => $_POST["usuarioCrea"]

            );
            $crearPaciente->crearPaciente();
            break;

        case 'mostrarPaciente':
            $mostrarPaciente = new PacientesAjax();
            $mostrarPaciente->mostrarPaciente($_POST["idPaciente"]);
            break;

        case 'editarPaciente':
            $editarPaciente = new PacientesAjax();
            if(empty($_POST["fechaNotificacionSiviPaciente"])){
                $fechaNotificacionSiviPaciente = null;
            }else{
                $fechaNotificacionSiviPaciente = $_POST["fechaNotificacionSiviPaciente"];
            }
            $editarPaciente->datos = array(
                'id_paciente' => $_POST["idPaciente"],
                'tipo_documento' => $_POST["tipoDocumento"],
                'numero_documento' => $_POST["numeroIdentificacion"],
                'primer_apellido' => $_POST["primerApellidoPaciente"],
                'segundo_apellido' => $_POST["segundoApellidoPaciente"],
                'seudonimo_paciente' => $_POST["seudonimoPaciente"],
                'primer_nombre' => $_POST["primerNombrePaciente"],
                'segundo_nombre' => $_POST["segundoNombrePaciente"],
                'expedido_en' => strtoupper($_POST["expedidoEn"]),
                'no_carnet' => $_POST["numeroIdentificacion"],
                'fecha_nacimiento' => $_POST["fechaNacimientoPaciente"],
                'edad_n' => $_POST["edadNPaciente"],
                'edad_t' => $_POST["edadTPaciente"],
                'genero_paciente' => $_POST["generoPaciente"],
                'estado_civil' => $_POST["estadoCivilPaciente"],
                'escolaridad' => $_POST["escolaridadPaciente"],
                'vinculacion' => $_POST["vinculacionPaciente"],
                'ocupacion' => $_POST["ocupacionPaciente"],
                'grupo_poblacional' => $_POST["grupoPoblacionalPaciente"],
                'pertenencia_etnica' => $_POST["pertenenciaEtnicaPaciente"],
                'regimen' => $_POST["regimenPaciente"],
                'tipo_usuario_rips' => $_POST["tipoUsuarioRipsPaciente"],
                'tipo_afiliacion' => $_POST["tipoAfiliacionPaciente"],
                'entidad_af_actual' => $_POST["entidadAfActualPaciente"],
                'mod_copago' => $_POST["modCopagoPaciente"],
                'copago_fe' => $_POST["copagoFePaciente"],
                'nivel_sisben' => $_POST["nivelSisbenPaciente"],
                'departamento_sisben' => $_POST["departamentoSisbenPaciente"],
                'municipio_sisben' => $_POST["municipioSisbenPaciente"],
                'sede_reclama_med' => $_POST["reclamaMediPaciente"],
                'paquete_atencion' => $_POST["paqueteAtencionPaciente"],
                'notifica_sivigila' => $_POST["notificaSivigilaPaciente"],
                'fecha_notificacion_sivigila' => $fechaNotificacionSiviPaciente,
                'ips_notifica' => $_POST["ipsNotificaPaciente"],
                'direccion_ubicacion' => $_POST["direccionUbicacionPaciente"],
                'latitud_ubicacion' => $_POST["latitudUbicacion"],
                'longitud_ubicacion' => $_POST["longitudUbicacion"],
                'telefono_uno_ubicacion' => $_POST["telefonoUnoPaciente"],
                'telefono_dos_ubicacion' => $_POST["telefonoDosPaciente"],
                'zona_ubicacion' => $_POST["zonaUbicacionPaciente"],
                'departamento_ubicacion' => $_POST["departamentoUbicacionPaciente"],
                'municipio_ubicacion' => $_POST["municipioUbicacionPaciente"],
                'pais_origen' => $_POST["paisOrigenPaciente"],
                'correo' => $_POST["correoPaciente"],
                'nombre_madre' => $_POST["nombreMadrePaciente"],
                'nombre_padre' => $_POST["nombrePadrePaciente"],
                'responsable' => $_POST["responsablePaciente"],
                'parentesco' => $_POST["parentescoPaciente"],
                'direccion_contacto' => $_POST["direccionContactoPaciente"],
                'telefono_contacto' => $_POST["telefonoContactoPaciente"],
                'psudonimo' => $_POST["psuodonimoPaciente"],
                'observacion_contacto' => $_POST["observacionContactoPaciente"],
                'cambios_campos' => $_POST["camposCambios"],
                'usuario_edita' => $_POST["usuarioEdita"]
            );
            $editarPaciente->editarPaciente();
            break;

    }
}

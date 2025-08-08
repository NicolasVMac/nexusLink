<?php

require_once "../../controllers/hv/hv.controller.php";
require_once "../../models/hv/hv.model.php";

class HvAjax{

    public $datos;

    public function crearDatosPersonales(){

        $datos = $this->datos;

        $resultado = ControladorHv::ctrCrearDatosPersonales($datos);

        echo json_encode($resultado);

    }


    public function crearEstudio(){

        $datos = $this->datos;

        $resultado = ControladorHv::ctrCrearEstudio($datos);

        echo json_encode($resultado);

    }



    public function crearExperienciaLaboral(){

        $datos = $this->datos;

        $resultado = ControladorHv::ctrCrearExperienciaLaboral($datos);

        echo json_encode($resultado);

    }

    public function listaExperienciasLaborales($idHV){

        $respuesta = ControladorHv::ctrListaExperienciasLaborales($idHV);

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

    static public function listaEstudios($idHV){

        $respuesta = ControladorHv::ctrListaEstudios($idHV);

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

    public function infoDatosPersonales($idHV){

        $respuesta = ControladorHv::ctrInfoDatosPersonales($idHV);

        echo json_encode($respuesta);

    }

    public function editarDatosPersonales(){

        $datos = $this->datos;

        $resultado = ControladorHv::ctrEditarDatosPersonales($datos);

        echo json_encode($resultado);


    }


    public function eliminarExperienciaLaboral(){

        $datos = $this->datos;

        $respuesta = ControladorHv::ctrEliminarExperienciaLaboral($datos);

        echo json_encode($respuesta);

    }


    public function eliminarEstudio(){

        $datos = $this->datos;

        $respuesta = ControladorHv::ctrEliminarEstudio($datos);

        echo json_encode($respuesta);


    }

    public function validarExistePersona($tipoDoc, $numeroDoc){

        $respuesta = ControladorHv::ctrBuscarHvDocumento($tipoDoc, $numeroDoc);

        echo json_encode($respuesta);

    }


    public function verEstudio($idEstudio){

        $respuesta = ControladorHv::ctrVerEstudio($idEstudio);

        echo json_encode($respuesta);

    }


    public function verExperienciaLaboral($idExpLaboral){

        $respuesta = ControladorHv::ctrVerExperienciaLaboral($idExpLaboral);

        echo json_encode($respuesta);

    }

    public function consultarHv(){

        $datos = $this->datos;

        $respuesta = ControladorHv::ctrConsultarHv($datos);

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


    public function estudiosHV($idHV){

        $respuesta = ControladorHv::ctrListaEstudios($idHV);

        echo json_encode($respuesta);

    }

    public function experienciasLaboralesHV($idHV){

        $respuesta = ControladorHv::ctrListaExperienciasLaborales($idHV);

        echo json_encode($respuesta);

    }

    public function calculoExperienciaLaboral($idHV){

        $respuesta = ControladorHv::ctrCalculoExperienciaLaboral($idHV);

        echo json_encode($respuesta);

    }

    public function listaHV(){

        $respuesta = ControladorHv::ctrListaHv();

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

        case 'listaHV':
            $listaHV = new HvAjax();
            $listaHV->listaHV();
            break;

        case 'calculoExperienciaLaboral':
            $calculoExperienciaLaboral = new HvAjax();
            $calculoExperienciaLaboral->calculoExperienciaLaboral($_POST["idHV"]);
            break;

        case 'experienciasLaboralesHV':
            $experienciasLaboralesHV = new HvAjax();
            $experienciasLaboralesHV->experienciasLaboralesHV($_POST["idHV"]);
            break;

        case 'estudiosHV':
            $estudiosHV = new HvAjax();
            $estudiosHV->estudiosHV($_POST["idHV"]);
            break;

        case 'consultarHv':
            $consultarHv = new HvAjax();
            $consultarHv->datos = array(
                "numero_doc" => $_POST["numDocumentoBuscar"],
                "tipo_formacion" => $_POST["tipoFormacionBuscar"],
                "profesion" => $_POST["profesionBuscar"],
                "palabra_clave" => $_POST["palabraClaveBuscar"]
            );
            $consultarHv->consultarHv();
            break;

        case 'verExperienciaLaboral':
            $verExperienciaLaboral = new HvAjax();
            $verExperienciaLaboral->verExperienciaLaboral($_POST["idExpLaboral"]);
            break;

        case 'verEstudio':
            $verEstudio = new HvAjax();
            $verEstudio->verEstudio($_POST["idEstudio"]);
            break;

        case 'validarExistePersona':
            $validarExistePersona = new HvAjax();
            $validarExistePersona->validarExistePersona($_POST["tipoDoc"], $_POST["numDoc"]);
            break;

        case 'eliminarEstudio':
            $eliminarEstudio = new HvAjax();
            $eliminarEstudio->datos = array(
                "id_estudio" => $_POST["idEstudio"],
                "usuario_elimina" => $_POST["userSesion"],
            );
            $eliminarEstudio->eliminarEstudio();
            break;

        case 'eliminarExperienciaLaboral':
            $eliminarExperienciaLaboral = new HvAjax();
            $eliminarExperienciaLaboral->datos = array(
                "id_exp_laboral" => $_POST["idExpLaboral"],
                "usuario_elimina" => $_POST["userSesion"],
            );
            $eliminarExperienciaLaboral->eliminarExperienciaLaboral();
            break;

        case 'editarDatosPersonales':
        $editarDatosPersonales = new HvAjax();
        if(isset($_FILES["archivosDatosPersonales"])){$archivosDatosPersonales = $_FILES["archivosDatosPersonales"];}else{$archivosDatosPersonales = 'VACIO';}
        $editarDatosPersonales->datos = array(
            "id_hv" => $_POST["idHV"],
            "tipo_doc" => mb_strtoupper($_POST["tipoDocumentoDp"]),
            "numero_doc" => trim($_POST["numeroDocumentoDp"]),
            "nombre_completo" => mb_strtoupper($_POST["nombreCompletoDp"]),
            "fecha_nacimiento" => $_POST["fechaNacimientoDp"],
            "nacionalidad" => mb_strtoupper($_POST["nacionalidadDp"]),
            "profesion" => mb_strtoupper($_POST["profesionDp"]),
            "correo_electronico" => $_POST["correoElectronicoDp"],
            "direccion" => mb_strtoupper($_POST["direccionDp"]),
            "celular" => $_POST["celularDp"],
            "telefono" => $_POST["telefonoDp"],
            "usuario_sesion" => $_POST["user"],
            "archivosDatosPersonales" => $archivosDatosPersonales,
        );
        $editarDatosPersonales->editarDatosPersonales();
        break;

        case 'infoDatosPersonales':
            $infoDatosPersonales = new HvAjax();
            $infoDatosPersonales->infoDatosPersonales($_POST["idHV"]);
            break;

        case 'listaEstudios':
            $listaEstudios = new HvAjax();
            $listaEstudios->listaEstudios($_POST["idHV"]);
            break;

        case 'listaExperienciasLaborales':
            $listaExperienciasLaborales = new HvAjax();
            $listaExperienciasLaborales->listaExperienciasLaborales($_POST["idHV"]);
            break;

        case 'crearExperienciaLaboral':
            $crearExperienciaLaboral = new HvAjax();
            if(isset($_FILES["archivoExpLaboral"])){$archivoExpLaboral = $_FILES["archivoExpLaboral"];}else{$archivoExpLaboral = 'VACIO';}
            if(isset($_POST["valorSalarioEL"]) && !empty($_POST["valorSalarioEL"])){$valorSalarioEL = $_POST["valorSalarioEL"];}else{$valorSalarioEL = 0;}
            $crearExperienciaLaboral->datos = array(
                "id_hv" => $_POST["idHV"],
                "empresa_contratante" => mb_strtoupper($_POST["empresaEL"]),
                "sector" => $_POST["sectorEL"],
                "cargo_desempenado" => mb_strtoupper($_POST["cargoEL"]),
                "area_trabajo" => mb_strtoupper($_POST["areaTrabajoEL"]),
                "valor_contrato_salario" => $valorSalarioEL,
                "fecha_inicio_labor" => $_POST["fechaInicioEL"],
                "fecha_fin_labor" => $_POST["fechaFinEL"],
                "tipo_certificado" => $_POST["tipoCertiEL"],
                "usuario_crea" => $_POST["user"],
                "archivoExpLaboral" => $archivoExpLaboral
            );
            $crearExperienciaLaboral->crearExperienciaLaboral();
            break;

        case 'crearEstudio':
            $crearEstudio = new HvAjax();
            if(isset($_FILES["archivoEstudio"])){$archivoEstudio = $_FILES["archivoEstudio"];}else{$archivoEstudio = 'VACIO';}
            if(isset($_FILES["archivoTarjPro"])){$archivoTarjPro = $_FILES["archivoTarjPro"];}else{$archivoTarjPro = 'VACIO';}
            if(isset($_POST["fechaExpTarjetaProEst"]) && !empty($_POST["fechaExpTarjetaProEst"])){$fechaExpTarjeProEst = $_POST["fechaExpTarjetaProEst"];}else{$fechaExpTarjeProEst = null;}
            if(isset($_POST["fechaTermMateriasEst"]) && !empty($_POST["fechaTermMateriasEst"])){$fechaTermMateEst = $_POST["fechaTermMateriasEst"];}else{$fechaTermMateEst = null;}
            $crearEstudio->datos = array(
                "id_hv" => $_POST["idHV"],
                "tipo_formacion" => $_POST["tipoFormacionEst"],
                "titulo_otorgado" => mb_strtoupper($_POST["tituloOtorgadoEst"]),
                "institucion_educativa" => mb_strtoupper($_POST["institucionEducativaEst"]),
                "fecha_grado" => $_POST["fechaGradoEst"],
                "fecha_exp_tarjeta_pro" => $fechaExpTarjeProEst,
                "fecha_terminacion_mate" => $fechaTermMateEst,
                "usuario_crea" => $_POST["user"],
                "archivoEstudio" => $archivoEstudio,
                "archivoTarjPro" => $archivoTarjPro
            );
            $crearEstudio->crearEstudio();
            break;

        case 'crearDatosPersonales':
            $crearDatosPersonales = new HvAjax();
            if(isset($_FILES["archivosDatosPersonales"])){$archivosDatosPersonales = $_FILES["archivosDatosPersonales"];}else{$archivosDatosPersonales = 'VACIO';}
            $crearDatosPersonales->datos = array(
                "tipo_doc" => mb_strtoupper($_POST["tipoDocumentoDp"]),
                "numero_doc" => trim($_POST["numeroDocumentoDp"]),
                "nombre_completo" => mb_strtoupper($_POST["nombreCompletoDp"]),
                "fecha_nacimiento" => $_POST["fechaNacimientoDp"],
                "nacionalidad" => mb_strtoupper($_POST["nacionalidadDp"]),
                "profesion" => mb_strtoupper($_POST["profesionDp"]),
                "correo_electronico" => $_POST["correoElectronicoDp"],
                "direccion" => mb_strtoupper($_POST["direccionDp"]),
                "celular" => $_POST["celularDp"],
                "telefono" => $_POST["telefonoDp"],
                "usuario_crea" => $_POST["user"],
                "archivosDatosPersonales" => $archivosDatosPersonales,
            );
            $crearDatosPersonales->crearDatosPersonales();
            break;

    }

}
<?php

require_once "../../plugins/PHPExcel/IOFactory.php";
require_once "../../plugins/PHPExcel.php";

class ControladorContratistas
{

    static public function eliminarContratoOtroSi($datos){

        $respuesta = ModelContratistas::mdlEliminarContratoOtroSi($datos);

        return $respuesta;

    }

    static public function ctrListaContratosOtroSiContrato($idContrato){

        $respuesta = ModelContratistas::mdlListaContratosOtroSiContrato($idContrato);

        return $respuesta;

    }

     static public function ctrCrearOtroSi($datos){

        $rutaDocumento = "";

        if(!empty($_FILES['cOSDocumento']['name'])) {

            $Now  = date('YmdHis');
            $ruta = "../../../archivos_nexuslink/contratacion/contratistas/contratistas_contratos_otro_si/{$datos['idContratista']}/";

            if (!file_exists($ruta)) {
                if (!mkdir($ruta, 0777, true) && !is_dir($ruta)) {
                    die('No se pudo crear el directorio');
                }
            }

            $nombreOriginal = basename($_FILES['cOSDocumento']['name']);
            $nombreArchivo  = $Now . '_' . $nombreOriginal;
            $rutaFin        = $ruta . $nombreArchivo;

            if (move_uploaded_file($_FILES['cOSDocumento']['tmp_name'], $rutaFin)) {
                $rutaDocumento = $rutaFin;
            } else {
                error_log('Error al mover el archivo');
                $rutaDocumento = '';
            }

        } else {
            $rutaDocumento = '';
        }

        if($datos["cOSTipoOtroSi"] == "PRORROGA"){

            $datosContrato = array(
                "id_contrato" => $_POST["idContrato"],
                "tipo_otro_si" => $_POST["cOSTipoOtroSi"],
                "numero_contrato_otro_si" => mb_strtoupper($_POST["cOSNumeroOtroSi"]),
                "fecha_otro_si" => $_POST["cOSFechaOtroSi"],
                "fecha_inicio" => $_POST["cOSFechaInicioProrroga"],
                "fecha_fin" => $_POST["cOSFechaFinProrroga"],
                "observaciones" => mb_strtoupper($_POST["cOSObservacionesProrroga"]),
                "ruta_documento" => $rutaDocumento,
                "usuario_crea" => $_POST["userCreate"],
            );

            $respuesta = ModelContratistas::mdlCrearOtroSi($datosContrato);

            if($respuesta == "ok"){

                //ACTUALIZAR FIN VIGENCIA CONTRATO
                $updContrato = ModelContratistas::mdlActualizarVigenciaContrato($datosContrato);

                if($updContrato == 'ok'){

                    return 'ok';

                }else{

                    return 'error';

                }

            }else{
                unlink($rutaDocumento);
                return 'error';

            }

        }else if($datos["cOSTipoOtroSi"] == "ADICION"){

            $datosContrato = array(
                "id_contrato" => $_POST["idContrato"],
                "tipo_otro_si" => $_POST["cOSTipoOtroSi"],
                "numero_contrato_otro_si" => mb_strtoupper($_POST["cOSNumeroOtroSi"]),
                "fecha_otro_si" => $_POST["cOSFechaOtroSi"],
                "valor" => $_POST["cOSValorAdicion"],
                "observaciones" => mb_strtoupper($_POST["cOSObservacionesAdicion"]),
                "ruta_documento" => $rutaDocumento,
                "usuario_crea" => $_POST["userCreate"],
            );

            $respuesta = ModelContratistas::mdlCrearOtroSi($datosContrato);

            if($respuesta == "ok"){

                $infoContrato = ControladorContratistas::ctrInfoContratoContratista($datos["idContratista"], $datos["idContrato"]);

                $valor = $infoContrato["valor_contrato"] + $datosContrato["valor"];

                //ACTUALIZAR VALOR CONTRATO
                $updContrato = ModelContratistas::mdlActualizarValorContrato($datos["idContrato"], $valor);

                if($updContrato == 'ok'){

                    return 'ok';

                }else{

                    return 'error';

                }




            }else{
                unlink($rutaDocumento);
                return 'error';

            }

        }

    }


    static public function ctrEliminarPoliza($datos){

        $respuesta = ModelContratistas::mdlEliminarPoliza($datos);

        return $respuesta;

    }


    static public function ctrListaPolizasContrato($idContrato){

        $respuesta = ModelContratistas::mdlListaPolizasContrato($idContrato);

        return $respuesta;

    }

    static public function ctrCrearPolizas($datos){
        

        if($datos["pTipoPoliza"] == "GARANTIA UNICA"){

            $rutaDocumento = "";
            $error = false;

            if (!empty($_FILES['pDocumento']['name'])) {

                $Now  = date('YmdHis');
                $ruta = "../../../archivos_nexuslink/contratacion/contratistas/contratistas_polizas/{$datos['idContratista']}/";

                if (!file_exists($ruta)) {
                    if (!mkdir($ruta, 0777, true) && !is_dir($ruta)) {
                        die('No se pudo crear el directorio');
                    }
                }

                $nombreOriginal = basename($_FILES['pDocumento']['name']);
                $nombreArchivo  = $Now . '_' . $nombreOriginal;
                $rutaFin        = $ruta . $nombreArchivo;

                if (move_uploaded_file($_FILES['pDocumento']['tmp_name'], $rutaFin)) {
                    $rutaDocumento = $rutaFin;
                } else {
                    error_log('Error al mover el archivo');
                    $rutaDocumento = '';
                }

            } else {
                $rutaDocumento = '';
            }


            if(isset($datos["pFechaFinCumpli"])){

                $datosPoliza = array(
                    "id_contrato" => $datos["idContrato"],
                    "aseguradora" => $datos["pAseguradoraPoliza"],
                    "tipo_poliza" => $datos["pTipoPoliza"],
                    "numero_poliza" => mb_strtoupper($datos["pNumeroPoliza"]),
                    "fecha_inicio" => $datos["pFechaInicio"],
                    "valor_contrato" => $datos["pValorContrato"],
                    "ruta_documento_poliza" => $rutaDocumento,
                    "amparo" => $datos["pAmparoCumpli"],
                    "fecha_fin" => $datos["pFechaFinCumpli"],
                    "porcentaje_valor" => $datos["pPorcenValorCumpli"],
                    "valor_final" => $datos["pValorFinalCumpli"],
                    "usuario_crea" => $datos["userCreate"],
                );

                $respuesta = ControladorContratistas::ctrCrearPoliza($datosPoliza);

                if($respuesta == 'ok'){

                    $error = false;

                }else{

                    $error = true;

                }

            }

            if(isset($datos["pFechaFinCalidad"])){

                $datosPoliza = array(
                    "id_contrato" => $datos["idContrato"],
                    "aseguradora" => $datos["pAseguradoraPoliza"],
                    "tipo_poliza" => $datos["pTipoPoliza"],
                    "numero_poliza" => mb_strtoupper($datos["pNumeroPoliza"]),
                    "fecha_inicio" => $datos["pFechaInicio"],
                    "valor_contrato" => $datos["pValorContrato"],
                    "ruta_documento_poliza" => $rutaDocumento,
                    "amparo" => $datos["pAmparoCalidad"],
                    "fecha_fin" => $datos["pFechaFinCalidad"],
                    "porcentaje_valor" => $datos["pPorcenValorCalidad"],
                    "valor_final" => $datos["pValorFinalCalidad"],
                    "usuario_crea" => $datos["userCreate"],
                );

                $respuesta = ControladorContratistas::ctrCrearPoliza($datosPoliza);

                if($respuesta == 'ok'){

                    $error = false;

                }else{

                    $error = true;

                }

            }

            if(isset($datos["pFechaFinSalarios"])){

                $datosPoliza = array(
                    "id_contrato" => $datos["idContrato"],
                    "aseguradora" => $datos["pAseguradoraPoliza"],
                    "tipo_poliza" => $datos["pTipoPoliza"],
                    "numero_poliza" => mb_strtoupper($datos["pNumeroPoliza"]),
                    "fecha_inicio" => $datos["pFechaInicio"],
                    "valor_contrato" => $datos["pValorContrato"],
                    "ruta_documento_poliza" => $rutaDocumento,
                    "amparo" => $datos["pAmparoSalarios"],
                    "fecha_fin" => $datos["pFechaFinSalarios"],
                    "porcentaje_valor" => $datos["pPorcenValorSalarios"],
                    "valor_final" => $datos["pValorFinalSalarios"],
                    "usuario_crea" => $datos["userCreate"],
                );

                $respuesta = ControladorContratistas::ctrCrearPoliza($datosPoliza);

                if($respuesta == 'ok'){

                    $error = false;

                }else{

                    $error = true;

                }

            }

            if(isset($datos["pFechaFinCivil"])){

                $datosPoliza = array(
                    "id_contrato" => $datos["idContrato"],
                    "aseguradora" => $datos["pAseguradoraPoliza"],
                    "tipo_poliza" => $datos["pTipoPoliza"],
                    "numero_poliza" => mb_strtoupper($datos["pNumeroPoliza"]),
                    "fecha_inicio" => $datos["pFechaInicio"],
                    "valor_contrato" => $datos["pValorContrato"],
                    "ruta_documento_poliza" => $rutaDocumento,
                    "amparo" => $datos["pAmparoCivil"],
                    "fecha_fin" => $datos["pFechaFinCivil"],
                    "porcentaje_valor" => $datos["pPorcenValorCivil"],
                    "valor_final" => $datos["pValorFinalCivil"],
                    "usuario_crea" => $datos["userCreate"],
                );

                $respuesta = ControladorContratistas::ctrCrearPoliza($datosPoliza);

                if($respuesta == 'ok'){

                    $error = false;

                }else{

                    $error = true;

                }

            }

            if($error){

                return 'error';
                
            }else{
                
                return 'ok';

            }


        }else if($datos["pTipoPoliza"] == "RESPONSABILIDAD - MEDICA"){

            if(!empty($_FILES['pDocumento']['name'])){

                $Now  = date('YmdHis');
                $ruta = "../../../archivos_nexuslink/contratacion/contratistas/contratistas_polizas/{$datos['idContratista']}/";

                if (!file_exists($ruta)) {
                    if (!mkdir($ruta, 0777, true) && !is_dir($ruta)) {
                        die('No se pudo crear el directorio');
                    }
                }

                $nombreOriginal = basename($_FILES['pDocumento']['name']);
                $nombreArchivo  = $Now . '_' . $nombreOriginal;
                $rutaFin        = $ruta . $nombreArchivo;

                if (move_uploaded_file($_FILES['pDocumento']['tmp_name'], $rutaFin)) {
                    $rutaDocumento = $rutaFin;
                } else {
                    error_log('Error al mover el archivo');
                    $rutaDocumento = '';
                }

            } else {
                $rutaDocumento = '';
            }

            $datosPoliza = array(
                "id_contrato" => $datos["idContrato"],
                "aseguradora" => $datos["pAseguradoraPoliza"],
                "tipo_poliza" => $datos["pTipoPoliza"],
                "numero_poliza" => mb_strtoupper($datos["pNumeroPoliza"]),
                "fecha_inicio" => $datos["pFechaInicioResMed"],
                "valor_contrato" => $datos["pValorFinalResMed"],
                "ruta_documento_poliza" => $rutaDocumento,
                "amparo" => $datos["pAmparoResMed"],
                "fecha_fin" => $datos["pFechaFinResMed"],
                "observaciones" => mb_strtoupper($datos["pObservacionesResMed"]),
                "usuario_crea" => $datos["userCreate"],
            );

            $respuesta = ControladorContratistas::ctrCrearPoliza($datosPoliza);

            if($respuesta == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }else if($datos["pTipoPoliza"] == "RESPONSABILIDAD - CLINICA Y/O HOSPITALES"){

            if(!empty($_FILES['pDocumento']['name'])){

                $Now  = date('YmdHis');
                $ruta = "../../../archivos_nexuslink/contratacion/contratistas/contratistas_polizas/{$datos['idContratista']}/";

                if (!file_exists($ruta)) {
                    if (!mkdir($ruta, 0777, true) && !is_dir($ruta)) {
                        die('No se pudo crear el directorio');
                    }
                }

                $nombreOriginal = basename($_FILES['pDocumento']['name']);
                $nombreArchivo  = $Now . '_' . $nombreOriginal;
                $rutaFin        = $ruta . $nombreArchivo;

                if (move_uploaded_file($_FILES['pDocumento']['tmp_name'], $rutaFin)) {
                    $rutaDocumento = $rutaFin;
                } else {
                    error_log('Error al mover el archivo');
                    $rutaDocumento = '';
                }

            } else {
                $rutaDocumento = '';
            }

            $datosPoliza = array(
                "id_contrato" => $datos["idContrato"],
                "aseguradora" => $datos["pAseguradoraPoliza"],
                "tipo_poliza" => $datos["pTipoPoliza"],
                "numero_poliza" => mb_strtoupper($datos["pNumeroPoliza"]),
                "fecha_inicio" => $datos["pFechaInicioResCli"],
                "valor_contrato" => $datos["pValorFinalResCli"],
                "ruta_documento_poliza" => $rutaDocumento,
                "amparo" => $datos["pAmparoResCli"],
                "fecha_fin" => $datos["pFechaFinResCli"],
                "observaciones" => mb_strtoupper($datos["pObservacionesResCli"]),
                "usuario_crea" => $datos["userCreate"],
            );

            $respuesta = ControladorContratistas::ctrCrearPoliza($datosPoliza);

            if($respuesta == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }else if($datos["pTipoPoliza"] == "OTRAS POLIZAS"){

            
            if(!empty($_FILES['pDocumento']['name'])){

                $Now  = date('YmdHis');
                $ruta = "../../../archivos_nexuslink/contratacion/contratistas/contratistas_polizas/{$datos['idContratista']}/";

                if (!file_exists($ruta)) {
                    if (!mkdir($ruta, 0777, true) && !is_dir($ruta)) {
                        die('No se pudo crear el directorio');
                    }
                }

                $nombreOriginal = basename($_FILES['pDocumento']['name']);
                $nombreArchivo  = $Now . '_' . $nombreOriginal;
                $rutaFin        = $ruta . $nombreArchivo;

                if (move_uploaded_file($_FILES['pDocumento']['tmp_name'], $rutaFin)) {
                    $rutaDocumento = $rutaFin;
                } else {
                    error_log('Error al mover el archivo');
                    $rutaDocumento = '';
                }

            } else {
                $rutaDocumento = '';
            }

            $datosPoliza = array(
                "id_contrato" => $datos["idContrato"],
                "aseguradora" => $datos["pAseguradoraPoliza"],
                "tipo_poliza" => $datos["pTipoPoliza"],
                "numero_poliza" => mb_strtoupper($datos["pNumeroPoliza"]),
                "fecha_inicio" => $datos["pFechaInicioOtraPoli"],
                "valor_contrato" => $datos["pValorFinalOtraPoli"],
                "ruta_documento_poliza" => $rutaDocumento,
                "amparo" => mb_strtoupper($datos["pNombrePolizaOtraPoli"]),
                "fecha_fin" => $datos["pFechaFinOtraPoli"],
                "observaciones" => mb_strtoupper($datos["pObservacionesOtraPoli"]),
                "usuario_crea" => $datos["userCreate"],
            );

            $respuesta = ControladorContratistas::ctrCrearPoliza($datosPoliza);

            if($respuesta == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }

    }

    static public function ctrCrearPoliza($datos){

        $respuesta = ModelContratistas::mdlCrearPoliza($datos);

        return $respuesta;

    }


    static public function ctrEliminarOtroDocumento($datos){

        $respuesta = ModelContratistas::mdlEliminarOtroDocumento($datos);

        return $respuesta;

    }

    static public function ctrListaOtrosDocumentosContrato($idContrato){

        $respuesta = ModelContratistas::mdlListaOtrosDocumentosContrato($idContrato);

        return $respuesta;

    }

    static public function ctrAgregarOtroDocumento($datos){

        if(!empty($datos["archivoDocumento"]["name"])){

            $Now = date('YmdHis');
			$ruta = "../../../archivos_nexuslink/contratacion/contratistas/contratistas_otros_documentos/{$datos["id_contratista"]}/";
            if(!file_exists($ruta)){
                mkdir($ruta, 0777, true) or die ("No se puede crear el directorio");
            }
			$nombreOriginal = $datos["archivoDocumento"]["name"];
			$nombreArchivo = $Now.$nombreOriginal;
			$rutaFin = $ruta.$nombreArchivo;

            move_uploaded_file ($datos["archivoDocumento"]["tmp_name"], $rutaFin);
            $datos["ruta_documento"] = $rutaFin;

        }else{

            $datos["ruta_documento"] = "";

        }

        $tabla = "contratistas_contratista_contratos_otros_documentos";

        $respuesta = ModelContratistas::mdlAgregarOtroDocumento($tabla, $datos);

        if($respuesta == 'ok'){
            
            return 'ok';

        }else{

            unlink($datos["ruta_documento"]);
            return 'error';

        }

    }


    static public function ctrListaArchivosMasivosTarifas($idTarifario){

        $respuesta = ModelContratistas::mdlListaArchivosMasivosTarifas($idTarifario);

        return $respuesta;

    }

    static public function ctrCargarArchivoTarifasMasivo($datos){

        if(!empty($datos)){

            $Now = date('YmdHis');
			$ruta = "../../../archivos_nexuslink/contratacion/contratistas/contratistas_archivos_tarifarios/";
			$rutaErrores = "../../../archivos_nexuslink/contratacion/contratistas/contratistas_archivos_tarifarios/errores/";
			$nombreOriginal = $datos["archivoDocumento"]["name"];
			$nombreArchivo = $Now.$nombreOriginal;
			$rutaFin = $ruta.$nombreArchivo;
			$rutaFinErros = $rutaErrores.$nombreArchivo.".txt";

            move_uploaded_file ($datos["archivoDocumento"]["tmp_name"], $rutaFin);

            $objPHPExcel = PHPEXCEL_IOFactory::load($rutaFin);
            $objPHPExcel->setActiveSheetIndex(0);
            $NumColum = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
            $NumFilas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

            if($NumColum == 'J'){

                $tabla = "contratistas_contratista_tarifas_archivos_masivo";

                $datos = array(
                    "id_tarifario" => $datos["id_tarifario"],
                    "nombre_archivo" => $nombreOriginal,
                    "ruta_archivo" => $rutaFin,
                    "usuario_crea" => $datos["usuario_crea"]
                );

                $guardarArchivo = ModelContratistas::mdlCargarArchivoTarifasMasivo($tabla, $datos);

                if($guardarArchivo == 'ok'){

                    return 'ok';

                }else{
                    unlink($rutaFin);
                    return 'error';

                }

            }else{

                unlink($rutaFin);
                $archivoError = fopen("../../../archivos_nexuslink/contratacion/contratistas/contratistas_archivos_tarifarios/errores/" . $nombreArchivo . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

                fwrite($archivoError, $nombreArchivo . "\n");
                fwrite($archivoError, "Archivo generado el " . date("Y-m-d h:i:s:a") . "\n");
                fwrite($archivoError, "Validacion Cargue Tarifas Masivo\n");
                fwrite($archivoError, "El archivo no posee la estructura adecuada de 10 columnas (J)\n");
                fwrite($archivoError, "------------------------ Fin Validacion-------------------------------------\n");

                return 'error-estructura';

            }


        }

    }


    static public function ctrEliminarTarifaUnitaria($datos){

        $respuesta = ModelContratistas::mdlEliminarTarifaUnitaria($datos);

        return $respuesta;

    }


    static public function ctrListaTarifasTarifario($idTarifario){

        $respuesta = ModelContratistas::mdlListaTarifasTarifario($idTarifario);

        return $respuesta;

    }


    static public function ctrCrearTarifaUnitaria($datos){

        $respuesta = ModelContratistas::mdlCrearTarifaUnitaria($datos);

        return $respuesta;

    }

    static public function ctrInfoTarifario($idTarifario){

        $respuesta = ModelContratistas::mdlInfoTarifario($idTarifario);

        return $respuesta;

    }

    static public function ctrEliminarProrroga($datos){

        $respuesta = ModelContratistas::mdlEliminarProrroga($datos);

        return $respuesta;

    }


    static public function ctrAplicarProrrogaContrato($datos){

        $respuesta = ModelContratistas::mdlAplicarProrrogaContrato($datos);

        if($respuesta == 'ok'){

            //ESTADO PRORROGA
            $updProrroga = ModelContratistas::mdlActualizarEstadoProrroga($datos);


            //REGISTRAR LOG

            $datosLog = array(
                "id_prorroga" => $datos["id_prorroga"],
                "id_contrato" => $datos["id_contrato"],
                "usuario_crea" => $datos["usuario_crea"]
            );

            $logProrroga = ControladorContratistas::ctrCrearLogAplicarProrroga($datosLog);

            return 'ok';

        }else{

            return 'error';

        }


    }

    static public function ctrCrearLogAplicarProrroga($datos){

        $respuesta = ModelContratistas::mdlCrearLogAplicarProrroga($datos);

        return $respuesta;

    }

    static public function ctrCrearProrroga($datos){

        $respuesta = ModelContratistas::mdlCrearProrroga($datos);

        return $respuesta;


    }

    static public function ctrListaProrrogasContrato($idContrato){

        $respuesta = ModelContratistas::mdlListaProrrogasContrato($idContrato);

        return $respuesta;

    }


    static public function ctrListaParTarifasPrestador($datos){

        $respuesta = ModelContratistas::mdlListaParTarifasPrestador($datos);

        return $respuesta;

    }


    static public function ctrInfoContratoContratista($idContratista, $idContrato){

        $respuesta = ModelContratistas::mdlInfoContratoContratista($idContratista, $idContrato);

        return $respuesta;

    }


    static public function ctrCrearTarifasDefault($datos){

        $response = ControladorContratistas::ctrValidarExisteTarifasDefault($datos);

        if(empty($response)){

            $arrayTarifasDefault = ['SOAT VIGENTE', 'TARIFA PROPIA', 'ISS'];
    
            foreach ($arrayTarifasDefault as $key => $valueTarifa) {
    
                $datos = array(
                    "id_contratista" => $datos["id_contratista"],
                    "id_contrato" => $datos["id_contrato"],
                    "nombre_tarifa" => $valueTarifa,
                    "usuario_crea" => $datos["usuario_crea"]
                );
    
                $respuesta = ControladorContratistas::ctrCrearTarifa($datos);
    
            }
    
            return $respuesta;

        }else{

            return 'ok';

        }

    
    }

    static public function ctrCrearTarifa($datos){

        $respuesta = ModelContratistas::mdlCrearTarifa($datos);

        return $respuesta;

    }

    static public function ctrValidarExisteTarifasDefault($datos){

        $respuesta = ModelContratistas::mdlValidarExisteTarifasDefault($datos);

        return $respuesta;

    }


    static public function ctrListaTipoContratista($tabla)
    {
        $respuesta = ModelContratistas::mdlListaTipoContratista($tabla);

        return $respuesta;
    }

    static public function ctrValidarExisteContratista($numeroDoc, $tipoDoc)
    {

        $respuesta = ModelContratistas::mdlValidarExisteContratista($numeroDoc, $tipoDoc);

        if (empty($respuesta)) {

            return 'no-existe';
        } else {

            return 'existe';
        }
    }
    static public function ctrCrearContratista($datos)
    {

        $tabla = 'contratistas_contratistas';
        $respuesta = ModelContratistas::mdlCrearContratista($tabla, $datos);

        return $respuesta;
    }

    static public function ctrListaContratistas()
    {

        $tabla = 'contratistas_contratistas';
        $respuesta = ModelContratistas::mdlListaContratistas($tabla);

        return $respuesta;
    }

    static public function ctrEliminarContratista($idContratista)
    {

        $tabla = 'contratistas_contratistas';
        $respuesta = ModelContratistas::mdlEliminarContratista($tabla, $idContratista);

        return $respuesta;
    }
    static public function ctrListaContratosContratista($idContratista)
    {

        $respuesta = ModelContratistas::mdlListaContratosContratista($idContratista);

        return $respuesta;
    }

    static public function ctrCrearContrato($datos)
    {

        if (!empty($datos["archivoContrato"]["name"])) {

            $Now = date('YmdHis');
            $ruta = "../../../archivos_nexuslink/contratacion/contratistas/contratistas_contratos/{$datos["id_Contratista"]}/";
            if (!file_exists($ruta)) {
                mkdir($ruta, 0777, true) or die("No se puede crear el directorio");
            }
            $nombreOriginal = $datos["archivoContrato"]["name"];
            $nombreArchivo = $Now . $nombreOriginal;
            $rutaFin = $ruta . $nombreArchivo;

            move_uploaded_file($datos["archivoContrato"]["tmp_name"], $rutaFin);
            $datos["ruta_archivo_contrato"] = $rutaFin;
        } else {

            $datos["ruta_archivo_contrato"] = "";
        }

        $tabla = "contratistas_contratistas_contratos";

        $respuesta = ModelContratistas::mdlCrearContrato($tabla, $datos);

        return $respuesta;
    }

    static public function ctrInfoContratista($idContratista)
    {

        $tabla = "contratistas_contratistas";

        $respuesta = ModelContratistas::mdlInfoContratista($idContratista);

        return $respuesta;
    }
}

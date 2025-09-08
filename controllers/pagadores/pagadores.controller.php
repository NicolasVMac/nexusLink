<?php

require_once "../../plugins/PHPExcel/IOFactory.php";
require_once "../../plugins/PHPExcel.php";

class ControladorPagadores{

    static public function ctrListaArchivosMasivosTarifas($idTarifario){

        $respuesta = ModelPagadores::mdlListaArchivosMasivosTarifas($idTarifario);

        return $respuesta;

    }

    static public function ctrCargarArchivoTarifasMasivo($datos){

        if(!empty($datos)){

            $Now = date('YmdHis');
			$ruta = "../../../archivos_nexuslink/pagadores/pagadores_archivos_tarifarios/";
			$rutaErrores = "../../../archivos_nexuslink/pagadores/pagadores_archivos_tarifarios/errores/";
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

                $tabla = "pagadores_pagadores_tarifas_archivos_masivo";

                $datos = array(
                    "id_tarifario" => $datos["id_tarifario"],
                    "nombre_archivo" => $nombreOriginal,
                    "ruta_archivo" => $rutaFin,
                    "usuario_crea" => $datos["usuario_crea"]
                );

                $guardarArchivo = ModelPagadores::mdlCargarArchivoTarifasMasivo($tabla, $datos);

                if($guardarArchivo == 'ok'){

                    return 'ok';

                }else{
                    unlink($rutaFin);
                    return 'error';

                }

            }else{

                unlink($rutaFin);
                $archivoError = fopen("../../../archivos_nexuslink/pagadores/pagadores_archivos_tarifarios/errores/" . $nombreArchivo . ".txt", "w") or die("Problema al Crear Archivo"); // Archivo Escritura

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

        $respuesta = ModelPagadores::mdlEliminarTarifaUnitaria($datos);

        return $respuesta;

    }

    static public function ctrListaTarifasTarifario($idTarifario){

        $respuesta = ModelPagadores::mdlListaTarifasTarifario($idTarifario);

        return $respuesta;

    }

    static public function ctrCrearTarifaUnitaria($datos){

        $respuesta = ModelPagadores::mdlCrearTarifaUnitaria($datos);

        return $respuesta;

    }

    static public function ctrInfoTarifario($idTarifario){

        $respuesta = ModelPagadores::mdlInfoTarifario($idTarifario);

        return $respuesta;

    }

    static public function eliminarContratoOtroSi($datos){

        $respuesta = ModelPagadores::mdlEliminarContratoOtroSi($datos);

        return $respuesta;

    }

    static public function ctrListaContratosOtroSiContrato($idContrato){

        $respuesta = ModelPagadores::mdlListaContratosOtroSiContrato($idContrato);

        return $respuesta;

    }
        
    static public function ctrCrearOtroSi($datos){

        $rutaDocumento = "";

        if(!empty($_FILES['cOSDocumento']['name'])) {

            $Now  = date('YmdHis');
            $ruta = "../../../archivos_nexuslink/pagadores/pagadores_contratos_otro_si/{$datos['idPagador']}/";

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

            $respuesta = ModelPagadores::mdlCrearOtroSi($datosContrato);

            if($respuesta == "ok"){

                //ACTUALIZAR FIN VIGENCIA CONTRATO
                $updContrato = ModelPagadores::mdlActualizarVigenciaContrato($datosContrato);

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

            $respuesta = ModelPagadores::mdlCrearOtroSi($datosContrato);

            if($respuesta == "ok"){

                $infoContrato = ControladorPagadores::ctrInfoContratoPagador($datos["idPagador"], $datos["idContrato"]);

                if($infoContrato["cuantia_indeterminada"] != "SI"){

                    $valor = $infoContrato["valor_contrato"] + $datosContrato["valor"];

                    //ACTUALIZAR VALOR CONTRATO
                    $updContrato = ModelPagadores::mdlActualizarValorContrato($datos["idContrato"], $valor);

                    if($updContrato == 'ok'){

                        return 'ok';

                    }else{

                        return 'error';

                    }

                }

                return 'ok';


            }else{
                unlink($rutaDocumento);
                return 'error';

            }

        }

    }

    static public function ctrEliminarPoliza($datos){

        $respuesta = ModelPagadores::mdlEliminarPoliza($datos);

        return $respuesta;

    }

    static public function ctrListaPolizasContrato($idContrato){

        $respuesta = ModelPagadores::mdlListaPolizasContrato($idContrato);

        return $respuesta;

    }

    static public function ctrCrearPolizas($datos){
        

        if($datos["pTipoPoliza"] == "GARANTIA UNICA"){

            $rutaDocumento = "";
            $error = false;

            if (!empty($_FILES['pDocumento']['name'])) {

                $Now  = date('YmdHis');
                $ruta = "../../../archivos_nexuslink/pagadores/pagadores_polizas/{$datos['idPagador']}/";

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

                $respuesta = ControladorPagadores::ctrCrearPoliza($datosPoliza);

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

                $respuesta = ControladorPagadores::ctrCrearPoliza($datosPoliza);

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

                $respuesta = ControladorPagadores::ctrCrearPoliza($datosPoliza);

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

                $respuesta = ControladorPagadores::ctrCrearPoliza($datosPoliza);

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
                $ruta = "../../../archivos_nexuslink/pagadores/pagadores_polizas/{$datos['idPagador']}/";

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

            $respuesta = ControladorPagadores::ctrCrearPoliza($datosPoliza);

            if($respuesta == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }else if($datos["pTipoPoliza"] == "RESPONSABILIDAD - CLINICA Y/O HOSPITALES"){

            if(!empty($_FILES['pDocumento']['name'])){

                $Now  = date('YmdHis');
                $ruta = "../../../archivos_nexuslink/pagadores/pagadores_polizas/{$datos['idPagador']}/";

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

            $respuesta = ControladorPagadores::ctrCrearPoliza($datosPoliza);

            if($respuesta == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }else if($datos["pTipoPoliza"] == "OTRAS POLIZAS"){

            
            if(!empty($_FILES['pDocumento']['name'])){

                $Now  = date('YmdHis');
                $ruta = "../../../archivos_nexuslink/pagadores/pagadores_polizas/{$datos['idPagador']}/";

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

            $respuesta = ControladorPagadores::ctrCrearPoliza($datosPoliza);

            if($respuesta == 'ok'){

                return 'ok';

            }else{

                return 'error';

            }

        }

    }

    static public function ctrCrearPoliza($datos){

        $respuesta = ModelPagadores::mdlCrearPoliza($datos);

        return $respuesta;

    }

    static public function ctrEliminarOtroDocumento($datos){

        $respuesta = ModelPagadores::mdlEliminarOtroDocumento($datos);

        return $respuesta;

    }

    static public function ctrListaOtrosDocumentosContrato($idContrato){

        $respuesta = ModelPagadores::mdlListaOtrosDocumentosContrato($idContrato);

        return $respuesta;

    }

    static public function ctrAgregarOtroDocumento($datos){

        if(!empty($datos["archivoDocumento"]["name"])){

            $Now = date('YmdHis');
			$ruta = "../../../archivos_nexuslink/pagadores/pagadores_otros_documentos/{$datos["id_pagador"]}/";
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

        $tabla = "pagadores_pagadores_contratos_otros_documentos";

        $respuesta = ModelPagadores::mdlAgregarOtroDocumento($tabla, $datos);

        if($respuesta == 'ok'){
            
            return 'ok';

        }else{

            unlink($datos["ruta_documento"]);
            return 'error';

        }

    }

    static public function ctrAplicarProrrogaContrato($datos){

        $respuesta = ModelPagadores::mdlAplicarProrrogaContrato($datos);

        if($respuesta == 'ok'){

            //ESTADO PRORROGA
            $updProrroga = ModelPagadores::mdlActualizarEstadoProrroga($datos);


            //REGISTRAR LOG

            $datosLog = array(
                "id_prorroga" => $datos["id_prorroga"],
                "id_contrato" => $datos["id_contrato"],
                "usuario_crea" => $datos["usuario_crea"]
            );

            $logProrroga = ControladorPagadores::ctrCrearLogAplicarProrroga($datosLog);

            return 'ok';

        }else{

            return 'error';

        }


    }

    static public function ctrCrearLogAplicarProrroga($datos){

        $respuesta = ModelPagadores::mdlCrearLogAplicarProrroga($datos);

        return $respuesta;

    }


    static public function ctrObtenerContrato($idContrato){

        $respuesta = ModelPagadores::mdlObtenerContrato($idContrato);

        return $respuesta;

    }

    static public function ctrEliminarProrroga($datos){

        $respuesta = ModelPagadores::mdlEliminarProrroga($datos);

        return $respuesta;

    }

    static public function ctrListaProrrogasContrato($idContrato){

        $respuesta = ModelPagadores::mdlListaProrrogasContrato($idContrato);

        return $respuesta;

    }

    static public function ctrCrearProrroga($datos){

        $respuesta = ModelPagadores::mdlCrearProrroga($datos);

        return $respuesta;


    }

    static public function ctrListaParTarifasPrestador($datos){

        $respuesta = ModelPagadores::mdlListaParTarifasPrestador($datos);

        return $respuesta;

    }

    static public function ctrCrearTarifasDefault($datos){

        $response = ControladorPagadores::ctrValidarExisteTarifasDefault($datos);

        if(empty($response)){

            $arrayTarifasDefault = ['SOAT VIGENTE', 'TARIFA PROPIA', 'ISS'];
    
            foreach ($arrayTarifasDefault as $key => $valueTarifa) {
    
                $datos = array(
                    "id_pagador" => $datos["id_pagador"],
                    "id_contrato" => $datos["id_contrato"],
                    "nombre_tarifa" => $valueTarifa,
                    "usuario_crea" => $datos["usuario_crea"]
                );
    
                $respuesta = ControladorPagadores::ctrCrearTarifa($datos);
    
            }
    
            return $respuesta;

        }else{

            return 'ok';

        }

    
    }

    static public function ctrCrearTarifa($datos){

        $respuesta = ModelPagadores::mdlCrearTarifa($datos);

        return $respuesta;

    }

    static public function ctrValidarExisteTarifasDefault($datos){

        $respuesta = ModelPagadores::mdlValidarExisteTarifasDefault($datos);

        return $respuesta;

    }

    static public function ctrInfoContratoPagador($idPagador, $idContrato){

        $respuesta = ModelPagadores::mdlInfoContratoPagador($idPagador, $idContrato);

        return $respuesta;

    }

    static public function ctrListaContratosPagador($idPagador){

        $respuesta = ModelPagadores::mdlListaContratosPagador($idPagador);
        
        return $respuesta;

    }

    static public function ctrCrearContrato($datos){

        if(!empty($datos["archivoContrato"]["name"])){

            $Now = date('YmdHis');
			$ruta = "../../../archivos_nexuslink/pagadores/pagadores_contratos/{$datos["id_pagador"]}/";
            if(!file_exists($ruta)){
                mkdir($ruta, 0777, true) or die ("No se puede crear el directorio");
            }
			$nombreOriginal = $datos["archivoContrato"]["name"];
			$nombreArchivo = $Now.$nombreOriginal;
			$rutaFin = $ruta.$nombreArchivo;

            move_uploaded_file ($datos["archivoContrato"]["tmp_name"], $rutaFin);
            $datos["ruta_archivo_contrato"] = $rutaFin;

        }else{

            $datos["ruta_archivo_contrato"] = "";

        }

        $tabla = "pagadores_pagadores_contratos";

        $respuesta = ModelPagadores::mdlCrearContrato($tabla, $datos);

        if($respuesta == 'ok'){
            
            return 'ok';

        }else{

            unlink($datos["ruta_archivo_contrato"]);
            return 'error';

        }


    }

    static public function ctrInfoPagador($idPagador){

        $tabla = "pagadores_pagadores";

        $respuesta = ModelPagadores::ctrInfoPagador($idPagador);

        return $respuesta;

    }

    static public function ctrListaPagadores(){

        $tabla = "pagadores_pagadores";

        $respuesta = ModelPagadores::mdlListaPagadores($tabla);

        return $respuesta;

    }
    
    static public function ctrAgregarPagador($datos){

        $tabla = "pagadores_pagadores";

        $respuesta = ModelPagadores::mdlAgregarPagador($tabla, $datos);

        return $respuesta;

    }


}
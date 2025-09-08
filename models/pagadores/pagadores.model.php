<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelPagadores{

    static public function mdlListaArchivosMasivosTarifas($idTarifario){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagadores_tarifas_archivos_masivo WHERE id_tarifario = :id_tarifario");

        $stmt->bindParam(":id_tarifario", $idTarifario, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCargarArchivoTarifasMasivo($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_tarifario, nombre_archivo, ruta_archivo, usuario_crea) VALUES (:id_tarifario, :nombre_archivo, :ruta_archivo, :usuario_crea)");

        $stmt->bindParam(":id_tarifario", $datos["id_tarifario"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_archivo", $datos["nombre_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarTarifaUnitaria($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pagadores_pagadores_tarifas SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = CURRENT_TIMESTAMP WHERE id_tarifa = :id_tarifa");

        $stmt->bindParam(":id_tarifa", $datos["id_tarifa"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaTarifasTarifario($idTarifario){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagadores_tarifas WHERE id_par_tarifario = :id_par_tarifario AND is_active = 1");

        $stmt->bindParam(":id_par_tarifario", $idTarifario, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlCrearTarifaUnitaria($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO pagadores_pagadores_tarifas (id_par_tarifario, tipo_tarifa, codigo, codigo_normalizado, registro_sanitario, tarifa_pactada, tarifa_regulacion, fecha_inicio_vigencia, fecha_fin_vigencia, descripcion_tarifa, producto, usuario_crea) VALUES (:id_par_tarifario, :tipo_tarifa, :codigo, :codigo_normalizado, :registro_sanitario, :tarifa_pactada, :tarifa_regulacion, :fecha_inicio_vigencia, :fecha_fin_vigencia, :descripcion_tarifa, :producto, :usuario_crea)");

        $stmt->bindParam(":id_par_tarifario", $datos["id_par_tarifario"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_tarifa", $datos["tipo_tarifa"], PDO::PARAM_STR);
        $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":codigo_normalizado", $datos["codigo_normalizado"], PDO::PARAM_STR);
        $stmt->bindParam(":registro_sanitario", $datos["registro_sanitario"], PDO::PARAM_STR);
        $stmt->bindParam(":tarifa_pactada", $datos["tarifa_pactada"], PDO::PARAM_STR);
        $stmt->bindParam(":tarifa_regulacion", $datos["tarifa_regulacion"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_inicio_vigencia", $datos["fecha_inicio_vigencia"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin_vigencia", $datos["fecha_fin_vigencia"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion_tarifa", $datos["descripcion_tarifa"], PDO::PARAM_STR);
        $stmt->bindParam(":producto", $datos["producto"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoTarifario($idTarifario){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagador_par_tarifas WHERE id_par_tarifa_pagador = :id_par_tarifa_pagador");

        $stmt->bindParam(":id_par_tarifa_pagador", $idTarifario, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarValorContrato($idContrato, $valor){

        $stmt = Connection::connectOnly()->prepare("UPDATE pagadores_pagadores_contratos SET valor_contrato = :valor_contrato WHERE id_contrato = :id_contrato");

        $stmt->bindParam(":valor_contrato", $valor, PDO::PARAM_STR);
        $stmt->bindParam(":id_contrato", $idContrato, PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlEliminarContratoOtroSi($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pagadores_pagadores_contratos_otro_si SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = CURRENT_TIMESTAMP WHERE id_contrato_otro_si = :id_contrato_otro_si");

        $stmt->bindParam(":id_contrato_otro_si", $datos["id_contrato_si"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $datos["usuario_sesion"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlListaContratosOtroSiContrato($idContrato){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagadores_contratos_otro_si WHERE id_contrato = :id_contrato AND is_active = 1");

        $stmt->bindParam(":id_contrato", $idContrato, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarVigenciaContrato($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pagadores_pagadores_contratos SET fecha_fin_real = :fecha_fin_real WHERE id_contrato = :id_contrato");

        $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin_real", $datos["fecha_fin"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearOtroSi($datos){

        if($datos["tipo_otro_si"] == "PRORROGA"){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO pagadores_pagadores_contratos_otro_si (id_contrato, tipo_otro_si, numero_contrato_otro_si, fecha_otro_si, fecha_inicio, fecha_fin, observaciones, ruta_documento, usuario_crea) VALUES (:id_contrato, :tipo_otro_si, :numero_contrato_otro_si, :fecha_otro_si, :fecha_inicio, :fecha_fin, :observaciones, :ruta_documento, :usuario_crea)");

            $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo_otro_si", $datos["tipo_otro_si"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_contrato_otro_si", $datos["numero_contrato_otro_si"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_otro_si", $datos["fecha_otro_si"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":ruta_documento", $datos["ruta_documento"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return 'ok';

            }else{

                return $stmt->errorInfo();

            }

            $stmt = null;

        }else if($datos["tipo_otro_si"] == "ADICION"){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO pagadores_pagadores_contratos_otro_si (id_contrato, tipo_otro_si, numero_contrato_otro_si, fecha_otro_si, valor_adicion, observaciones, ruta_documento, usuario_crea) VALUES (:id_contrato, :tipo_otro_si, :numero_contrato_otro_si, :fecha_otro_si, :valor_adicion, :observaciones, :ruta_documento, :usuario_crea)");

            $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo_otro_si", $datos["tipo_otro_si"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_contrato_otro_si", $datos["numero_contrato_otro_si"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_otro_si", $datos["fecha_otro_si"], PDO::PARAM_STR);
            $stmt->bindParam(":valor_adicion", $datos["valor"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":ruta_documento", $datos["ruta_documento"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return 'ok';

            }else{

                return $stmt->errorInfo();

            }

        }



    }

    static public function mdlEliminarPoliza($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pagadores_pagadores_contratos_polizas SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = CURRENT_TIMESTAMP WHERE id_poliza = :id_poliza");

        $stmt->bindParam(":usuario_elimina", $datos["usuario_sesion"], PDO::PARAM_STR);
        $stmt->bindParam(":id_poliza", $datos["id_poliza"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPolizasContrato($idContrato){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagadores_contratos_polizas WHERE id_contrato = :id_contrato AND is_active = 1");

        $stmt->bindParam(":id_contrato", $idContrato, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::PARAM_STR);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearPoliza($datos){

        if($datos["tipo_poliza"] == "GARANTIA UNICA"){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO pagadores_pagadores_contratos_polizas (id_contrato, aseguradora, tipo_poliza, numero_poliza, fecha_inicio, valor_contrato, ruta_documento_poliza, amparo, fecha_fin, porcentaje_valor, valor_final, usuario_crea) 
                VALUES (:id_contrato, :aseguradora, :tipo_poliza, :numero_poliza, :fecha_inicio, :valor_contrato, :ruta_documento_poliza, :amparo, :fecha_fin, :porcentaje_valor, :valor_final, :usuario_crea)");

            $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
            $stmt->bindParam(":aseguradora", $datos["aseguradora"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo_poliza", $datos["tipo_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_poliza", $datos["numero_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
            $stmt->bindParam(":valor_contrato", $datos["valor_contrato"], PDO::PARAM_STR);
            $stmt->bindParam(":ruta_documento_poliza", $datos["ruta_documento_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":amparo", $datos["amparo"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
            $stmt->bindParam(":porcentaje_valor", $datos["porcentaje_valor"], PDO::PARAM_STR);
            $stmt->bindParam(":valor_final", $datos["valor_final"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return 'ok';

            }else{

                return $stmt->errorInfo();

            }

            $stmt = null;

        }else if($datos["tipo_poliza"] == "RESPONSABILIDAD - MEDICA"){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO pagadores_pagadores_contratos_polizas (id_contrato, aseguradora, tipo_poliza, numero_poliza, fecha_inicio, valor_contrato, ruta_documento_poliza, amparo, fecha_fin, observaciones, usuario_crea) 
                VALUES (:id_contrato, :aseguradora, :tipo_poliza, :numero_poliza, :fecha_inicio, :valor_contrato, :ruta_documento_poliza, :amparo, :fecha_fin, :observaciones, :usuario_crea)");

            $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
            $stmt->bindParam(":aseguradora", $datos["aseguradora"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo_poliza", $datos["tipo_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_poliza", $datos["numero_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
            $stmt->bindParam(":valor_contrato", $datos["valor_contrato"], PDO::PARAM_STR);
            $stmt->bindParam(":ruta_documento_poliza", $datos["ruta_documento_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":amparo", $datos["amparo"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return 'ok';

            }else{

                return $stmt->errorInfo();

            }

            $stmt = null;
            
        }else if($datos["tipo_poliza"] == "RESPONSABILIDAD - CLINICA Y/O HOSPITALES"){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO pagadores_pagadores_contratos_polizas (id_contrato, aseguradora, tipo_poliza, numero_poliza, fecha_inicio, valor_contrato, ruta_documento_poliza, amparo, fecha_fin, observaciones, usuario_crea) 
                VALUES (:id_contrato, :aseguradora, :tipo_poliza, :numero_poliza, :fecha_inicio, :valor_contrato, :ruta_documento_poliza, :amparo, :fecha_fin, :observaciones, :usuario_crea)");

            $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
            $stmt->bindParam(":aseguradora", $datos["aseguradora"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo_poliza", $datos["tipo_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_poliza", $datos["numero_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
            $stmt->bindParam(":valor_contrato", $datos["valor_contrato"], PDO::PARAM_STR);
            $stmt->bindParam(":ruta_documento_poliza", $datos["ruta_documento_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":amparo", $datos["amparo"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return 'ok';

            }else{

                return $stmt->errorInfo();

            }

            $stmt = null;

        }else if($datos["tipo_poliza"] == "OTRAS POLIZAS"){

            $stmt = Connection::connectOnly()->prepare("INSERT INTO pagadores_pagadores_contratos_polizas (id_contrato, aseguradora, tipo_poliza, numero_poliza, fecha_inicio, valor_contrato, ruta_documento_poliza, amparo, fecha_fin, observaciones, usuario_crea) 
                VALUES (:id_contrato, :aseguradora, :tipo_poliza, :numero_poliza, :fecha_inicio, :valor_contrato, :ruta_documento_poliza, :amparo, :fecha_fin, :observaciones, :usuario_crea)");

            $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
            $stmt->bindParam(":aseguradora", $datos["aseguradora"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo_poliza", $datos["tipo_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":numero_poliza", $datos["numero_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
            $stmt->bindParam(":valor_contrato", $datos["valor_contrato"], PDO::PARAM_STR);
            $stmt->bindParam(":ruta_documento_poliza", $datos["ruta_documento_poliza"], PDO::PARAM_STR);
            $stmt->bindParam(":amparo", $datos["amparo"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
            $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

            if($stmt->execute()){

                return 'ok';

            }else{

                return $stmt->errorInfo();

            }

            $stmt = null;


        }

    }

    static public function mdlEliminarOtroDocumento($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pagadores_pagadores_contratos_otros_documentos SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = CURRENT_TIMESTAMP WHERE id_otro_documento = :id_otro_documento");

        $stmt->bindParam(":id_otro_documento", $datos["id_otro_documento"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaOtrosDocumentosContrato($idContrato){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagadores_contratos_otros_documentos WHERE id_contrato = :id_contrato AND is_active = 1");

        $stmt->bindParam(":id_contrato", $idContrato, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlAgregarOtroDocumento($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_contrato, tipo_documento, ruta_documento, observaciones, usuario_crea) VALUES (:id_contrato, :tipo_documento, :ruta_documento, :observaciones, :usuario_crea)");

        $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_documento", $datos["ruta_documento"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlActualizarEstadoProrroga($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pagadores_pagadores_contratos_prorrogas SET estado = 'APLICADO' WHERE id_prorroga = :id_prorroga");

        $stmt->bindParam(":id_prorroga", $datos["id_prorroga"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAplicarProrrogaContrato($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pagadores_pagadores_contratos SET fecha_fin_real = DATE_ADD(fecha_fin_real, INTERVAL :prorroga_meses MONTH) WHERE id_contrato = :id_contrato");

        $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":prorroga_meses", $datos["prorroga_meses"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearLogAplicarProrroga($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO pagadores_pagadores_log_prorrogas_aplicadas (id_prorroga, id_contrato, usuario_crea) VALUES (:id_prorroga, :id_contrato, :usuario_crea)");

        $stmt->bindParam(":id_prorroga", $datos["id_prorroga"], PDO::PARAM_STR);
        $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerContrato($idContrato){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagadores_contratos WHERE id_contrato = :id_contrato");

        $stmt->bindParam(":id_contrato", $idContrato, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarProrroga($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pagadores_pagadores_contratos_prorrogas SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = CURRENT_TIMESTAMP WHERE id_prorroga = :id_prorroga");

        $stmt->bindParam(":id_prorroga", $datos["id_prorroga"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaProrrogasContrato($idContrato){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagadores_contratos_prorrogas WHERE id_contrato = :id_contrato AND is_active = 1");

        $stmt->bindParam(":id_contrato", $idContrato, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearProrroga($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO pagadores_pagadores_contratos_prorrogas (id_contrato, prorroga_meses, observaciones, usuario_crea) VALUES (:id_contrato, :prorroga_meses, :observaciones, :usuario_crea)");

        $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":prorroga_meses", $datos["prorroga_meses"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaParTarifasPrestador($datos){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagador_par_tarifas WHERE id_pagador = :id_pagador AND id_contrato = :id_contrato");

        $stmt->bindParam(":id_pagador", $datos["id_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearTarifa($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO pagadores_pagador_par_tarifas (id_pagador, id_contrato, nombre_tarifa, usuario_crea) VALUES (:id_pagador, :id_contrato, :nombre_tarifa, :usuario_crea)");

        $stmt->bindParam(":id_pagador", $datos["id_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_tarifa", $datos["nombre_tarifa"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidarExisteTarifasDefault($datos){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagador_par_tarifas WHERE id_pagador = :id_pagador AND id_contrato = :id_contrato");

        $stmt->bindParam(":id_pagador", $datos["id_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoContratoPagador($idPagador, $idContrato){

        $stmt = Connection::connectOnly()->prepare("SELECT p.id_pagador, p.tipo_pagador, p.nombre_pagador, p.tipo_identi_pagador, ptd.descripcion AS tipo_documento_pagador, ptp.tipo_pagador AS tipo_pagador_full, p.numero_identi_pagador, p.direccion_pagador, p.telefono_pagador, p.departamento, p.ciudad, p.correo, pc.id_contrato, pc.tipo_contrato, pc.nombre_contrato, pc.fecha_inicio, pc.fecha_fin, pc.fecha_fin_real, pc.valor_contrato, pc.cuantia_indeterminada, pc.ruta_archivo_contrato, pc.objeto_contractual FROM pagadores_pagadores_contratos pc JOIN pagadores_pagadores p ON pc.id_pagador = p.id_pagador JOIN par_tipos_documentos ptd ON p.tipo_identi_pagador = ptd.codigo JOIN pagadores_par_tipos_pagadores ptp ON p.tipo_pagador = ptp.tipo
            WHERE pc.id_contrato = :id_contrato AND p.id_pagador = :id_pagador");

        $stmt->bindParam(":id_pagador", $idPagador, PDO::PARAM_STR);
        $stmt->bindParam(":id_contrato", $idContrato, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlListaContratosPagador($idPagador){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pagadores_pagadores_contratos WHERE id_pagador = :id_pagador");

        $stmt->bindParam(":id_pagador", $idPagador, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearContrato($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_pagador, tipo_contrato, nombre_contrato, fecha_inicio, fecha_fin, fecha_fin_real, valor_contrato, cuantia_indeterminada, ruta_archivo_contrato, objeto_contractual, usuario_crea) VALUES (:id_pagador, :tipo_contrato, :nombre_contrato, :fecha_inicio, :fecha_fin, :fecha_fin_real, :valor_contrato, :cuantia_indeterminada, :ruta_archivo_contrato, :objeto_contractual, :usuario_crea)");

        $stmt->bindParam(":id_pagador", $datos["id_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_contrato", $datos["tipo_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_contrato", $datos["nombre_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin_real", $datos["fecha_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":valor_contrato", $datos["valor_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":cuantia_indeterminada", $datos["cuantia_indeterminada"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo_contrato", $datos["ruta_archivo_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":objeto_contractual", $datos["objeto_contractual"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function ctrInfoPagador($idPagador){

        $stmt = Connection::connectOnly()->prepare("SELECT pagadores_pagadores.*, par_tipos_documentos.descripcion AS tipo_documento_pagador, pagadores_par_tipos_pagadores.tipo_pagador AS tipo_pagador_full FROM par_tipos_documentos JOIN pagadores_pagadores ON pagadores_pagadores.tipo_identi_pagador = par_tipos_documentos.codigo JOIN pagadores_par_tipos_pagadores ON pagadores_pagadores.tipo_pagador = pagadores_par_tipos_pagadores.tipo
            WHERE pagadores_pagadores.id_pagador = :id_pagador");

        $stmt->bindParam(":id_pagador", $idPagador, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPagadores(){

        $stmt = Connection::connectOnly()->prepare("SELECT pagadores_pagadores.*, par_tipos_documentos.descripcion AS tipo_documento_pagador, pagadores_par_tipos_pagadores.tipo_pagador AS tipo_pagador_full FROM par_tipos_documentos JOIN pagadores_pagadores ON pagadores_pagadores.tipo_identi_pagador = par_tipos_documentos.codigo JOIN pagadores_par_tipos_pagadores ON pagadores_pagadores.tipo_pagador = pagadores_par_tipos_pagadores.tipo");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;
    
    }

    static public function mdlAgregarPagador($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (tipo_pagador, nombre_pagador, tipo_identi_pagador, numero_identi_pagador, direccion_pagador, telefono_pagador, departamento, ciudad, correo, usuario_crea) 
            VALUES (:tipo_pagador, :nombre_pagador, :tipo_identi_pagador, :numero_identi_pagador, :direccion_pagador, :telefono_pagador, :departamento, :ciudad, :correo, :usuario_crea)");

        $stmt->bindParam(":tipo_pagador", $datos["tipo_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_pagador", $datos["nombre_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_identi_pagador", $datos["tipo_identi_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_identi_pagador", $datos["numero_identi_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_pagador", $datos["direccion_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono_pagador", $datos["telefono_pagador"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento", $datos["departamento"], PDO::PARAM_STR);
        $stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


}


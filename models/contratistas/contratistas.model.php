<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelContratistas
{

    static public function mdlEliminarContratoOtroSi($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE contratistas_contratista_contratos_otro_si SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = CURRENT_TIMESTAMP WHERE id_contrato_otro_si = :id_contrato_otro_si");

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

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratista_contratos_otro_si WHERE id_contrato = :id_contrato AND is_active = 1");

        $stmt->bindParam(":id_contrato", $idContrato, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarValorContrato($idContrato, $valor){

        $stmt = Connection::connectOnly()->prepare("UPDATE contratistas_contratistas_contratos SET valor_contrato = :valor_contrato WHERE id_contrato = :id_contrato");

        $stmt->bindParam(":valor_contrato", $valor, PDO::PARAM_STR);
        $stmt->bindParam(":id_contrato", $idContrato, PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlActualizarVigenciaContrato($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE contratistas_contratistas_contratos SET fecha_fin_real = :fecha_fin_real WHERE id_contrato = :id_contrato");

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

            $stmt = Connection::connectOnly()->prepare("INSERT INTO contratistas_contratista_contratos_otro_si (id_contrato, tipo_otro_si, numero_contrato_otro_si, fecha_otro_si, fecha_inicio, fecha_fin, observaciones, ruta_documento, usuario_crea) VALUES (:id_contrato, :tipo_otro_si, :numero_contrato_otro_si, :fecha_otro_si, :fecha_inicio, :fecha_fin, :observaciones, :ruta_documento, :usuario_crea)");

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

            $stmt = Connection::connectOnly()->prepare("INSERT INTO contratistas_contratista_contratos_otro_si (id_contrato, tipo_otro_si, numero_contrato_otro_si, fecha_otro_si, valor_adicion, observaciones, ruta_documento, usuario_crea) VALUES (:id_contrato, :tipo_otro_si, :numero_contrato_otro_si, :fecha_otro_si, :valor_adicion, :observaciones, :ruta_documento, :usuario_crea)");

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

        $stmt = Connection::connectOnly()->prepare("UPDATE contratistas_contratista_contratos_polizas SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = CURRENT_TIMESTAMP WHERE id_poliza = :id_poliza");

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

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratista_contratos_polizas WHERE id_contrato = :id_contrato AND is_active = 1");

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

            $stmt = Connection::connectOnly()->prepare("INSERT INTO contratistas_contratista_contratos_polizas (id_contrato, aseguradora, tipo_poliza, numero_poliza, fecha_inicio, valor_contrato, ruta_documento_poliza, amparo, fecha_fin, porcentaje_valor, valor_final, usuario_crea) 
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

            $stmt = Connection::connectOnly()->prepare("INSERT INTO contratistas_contratista_contratos_polizas (id_contrato, aseguradora, tipo_poliza, numero_poliza, fecha_inicio, valor_contrato, ruta_documento_poliza, amparo, fecha_fin, observaciones, usuario_crea) 
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

            $stmt = Connection::connectOnly()->prepare("INSERT INTO contratistas_contratista_contratos_polizas (id_contrato, aseguradora, tipo_poliza, numero_poliza, fecha_inicio, valor_contrato, ruta_documento_poliza, amparo, fecha_fin, observaciones, usuario_crea) 
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

            $stmt = Connection::connectOnly()->prepare("INSERT INTO contratistas_contratista_contratos_polizas (id_contrato, aseguradora, tipo_poliza, numero_poliza, fecha_inicio, valor_contrato, ruta_documento_poliza, amparo, fecha_fin, observaciones, usuario_crea) 
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

        $stmt = Connection::connectOnly()->prepare("UPDATE contratistas_contratista_contratos_otros_documentos SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = CURRENT_TIMESTAMP WHERE id_otro_documento = :id_otro_documento");

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

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratista_contratos_otros_documentos WHERE id_contrato = :id_contrato AND is_active = 1");

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


    static public function mdlListaArchivosMasivosTarifas($idTarifario){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratista_tarifas_archivos_masivo WHERE id_tarifario = :id_tarifario");

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

        $stmt = Connection::connectOnly()->prepare("UPDATE contratistas_contratista_tarifas SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = CURRENT_TIMESTAMP WHERE id_tarifa = :id_tarifa");

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

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratista_tarifas WHERE id_par_tarifario = :id_par_tarifario AND is_active = 1");

        $stmt->bindParam(":id_par_tarifario", $idTarifario, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlCrearTarifaUnitaria($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO contratistas_contratista_tarifas (id_par_tarifario, tipo_tarifa, codigo, codigo_normalizado, registro_sanitario, tarifa_pactada, tarifa_regulacion, fecha_inicio_vigencia, fecha_fin_vigencia, descripcion_tarifa, producto, usuario_crea) VALUES (:id_par_tarifario, :tipo_tarifa, :codigo, :codigo_normalizado, :registro_sanitario, :tarifa_pactada, :tarifa_regulacion, :fecha_inicio_vigencia, :fecha_fin_vigencia, :descripcion_tarifa, :producto, :usuario_crea)");

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

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratista_par_tarifas WHERE id_par_tarifa_contratista = :id_par_tarifa_contratista");

        $stmt->bindParam(":id_par_tarifa_contratista", $idTarifario, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarProrroga($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE contratistas_contratista_contratos_prorrogas SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = CURRENT_TIMESTAMP WHERE id_prorroga = :id_prorroga");

        $stmt->bindParam(":id_prorroga", $datos["id_prorroga"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearLogAplicarProrroga($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO contratistas_contratista_log_prorrogas_aplicadas (id_prorroga, id_contrato, usuario_crea) VALUES (:id_prorroga, :id_contrato, :usuario_crea)");

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

    static public function mdlActualizarEstadoProrroga($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE contratistas_contratista_contratos_prorrogas SET estado = 'APLICADO' WHERE id_prorroga = :id_prorroga");

        $stmt->bindParam(":id_prorroga", $datos["id_prorroga"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAplicarProrrogaContrato($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE contratistas_contratistas_contratos SET fecha_fin_real = DATE_ADD(fecha_fin_real, INTERVAL :prorroga_meses MONTH) WHERE id_contrato = :id_contrato");

        $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);
        $stmt->bindParam(":prorroga_meses", $datos["prorroga_meses"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearProrroga($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO contratistas_contratista_contratos_prorrogas (id_contrato, prorroga_meses, observaciones, usuario_crea) VALUES (:id_contrato, :prorroga_meses, :observaciones, :usuario_crea)");

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

    static public function mdlListaProrrogasContrato($idContrato){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratista_contratos_prorrogas WHERE id_contrato = :id_contrato AND is_active = 1");

        $stmt->bindParam(":id_contrato", $idContrato, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaParTarifasPrestador($datos){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratista_par_tarifas WHERE id_contratista = :id_contratista AND id_contrato = :id_contrato");

        $stmt->bindParam(":id_contratista", $datos["id_contratista"], PDO::PARAM_STR);
        $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


    static public function mdlInfoContratoContratista($idContratista, $idContrato){

        $stmt = Connection::connectOnly()->prepare("SELECT c.id_contratistas, c.tipo_contratistas, c.nombre_contratistas, c.tipo_identi_contratistas, ptd.descripcion AS tipo_documento_contratista, ctc.tipo_contratistas AS tipo_contratista_full, c.numero_identi_contratistas, c.direccion_contratistas, c.telefono_contratistas, c.departamento, c.ciudad, c.correo, cc.id_contrato, cc.tipo_contrato, cc.nombre_contrato, cc.fecha_inicio, cc.fecha_fin, cc.fecha_fin_real, cc.valor_contrato, cc.cuantia_indeterminada, cc.ruta_archivo_contrato, cc.objeto_contractual FROM contratistas_contratistas_contratos cc JOIN contratistas_contratistas c ON cc.id_contratista = c.id_contratistas JOIN par_tipos_documentos ptd ON c.tipo_identi_contratistas = ptd.codigo JOIN contratistas_par_tipos_contratistas ctc ON c.tipo_contratistas = ctc.tipo
            WHERE cc.id_contrato = :id_contrato AND c.id_contratistas = :id_contratista");

        $stmt->bindParam(":id_contratista", $idContratista, PDO::PARAM_STR);
        $stmt->bindParam(":id_contrato", $idContrato, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlCrearTarifa($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO contratistas_contratista_par_tarifas (id_contratista, id_contrato, nombre_tarifa, usuario_crea) VALUES (:id_contratista, :id_contrato, :nombre_tarifa, :usuario_crea)");

        $stmt->bindParam(":id_contratista", $datos["id_contratista"], PDO::PARAM_STR);
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

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratista_par_tarifas WHERE id_contratista = :id_contratista AND id_contrato = :id_contrato");

        $stmt->bindParam(":id_contratista", $datos["id_contratista"], PDO::PARAM_STR);
        $stmt->bindParam(":id_contrato", $datos["id_contrato"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaTipoContratista($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * , CONCAT(tipo,' - ',tipo_contratistas) as tipo_contra FROM $tabla;");

        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }


    static public function mdlValidarExisteContratista($numeroDoc, $tipoDoc)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratistas WHERE tipo_identi_contratistas = :tipoDoc AND numero_identi_contratistas = :numeroDoc AND active='1'");

        $stmt->bindParam(":tipoDoc", $tipoDoc, PDO::PARAM_STR);
        $stmt->bindParam(":numeroDoc", $numeroDoc, PDO::PARAM_STR);
        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }


    static public function mdlCrearContratista($tabla, $datos)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("INSERT INTO $tabla (tipo_contratistas,nombre_contratistas,naturaleza,tipo_identi_contratistas,numero_identi_contratistas,direccion_contratistas,telefono_contratistas,departamento,ciudad,correo,usuario_crea,fecha_crea) VALUES (:tipoContratista,:nombreContratistaContratista,:naturalezaContratista,:tipoDocumentoContratista, :numeroDocumentoContratista,:direccionContratista,:telefonoContratista, :departamentoContratista,:ciudadContratista,:correoContratista,:usuario,CURRENT_TIMESTAMP)");

        $stmt->bindParam(":tipoContratista", $datos["tipoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":nombreContratistaContratista", $datos["nombreContratistaContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":naturalezaContratista", $datos["naturalezaContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":tipoDocumentoContratista", $datos["tipoDocumentoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":numeroDocumentoContratista", $datos["numeroDocumentoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":direccionContratista", $datos["direccionContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":telefonoContratista", $datos["telefonoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":departamentoContratista", $datos["departamentoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":ciudadContratista", $datos["ciudadContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":correoContratista", $datos["correoContratista"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);


        if ($stmt->execute()) {
            return 'ok';
        } else {
            return "error";
        }

        $stmt = null;
    }

    static public function mdlListaContratistas($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT cc.* , ptd.tipo as tipoDoc, ptd.descripcion as descripcionDoc, cptc.tipo_contratistas as descripcionTipoContratista,cc.active as estado  FROM contratistas_contratistas cc JOIN par_tipo_documentos ptd  on ptd.tipo=cc.tipo_identi_contratistas JOIN contratistas_par_tipos_contratistas cptc ON cptc.tipo=cc.tipo_contratistas");

        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlEliminarContratista($tabla, $idContratista)
    {

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET active='0' WHERE id_contratistas = $idContratista;");

        if ($stmt->execute()) {

            return 'ok';
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }


    static public function mdlListaContratosContratista($idContratista)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM contratistas_contratistas_contratos WHERE id_contratista = :id_contratista");

        $stmt->bindParam(":id_contratista", $idContratista, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlCrearContrato($tabla, $datos)
    {

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_contratista, tipo_contrato, nombre_contrato, fecha_inicio, fecha_fin, fecha_fin_real, valor_contrato, cuantia_indeterminada, ruta_archivo_contrato, objeto_contractual, usuario_crea) VALUES (:id_contratista, :tipo_contrato, :nombre_contrato, :fecha_inicio, :fecha_fin, :fecha_fin_real, :valor_contrato, :cuantia_indeterminada, :ruta_archivo_contrato, :objeto_contractual, :usuario_crea)");

        $stmt->bindParam(":id_contratista", $datos["id_Contratista"], PDO::PARAM_STR);
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

        if ($stmt->execute()) {

            return 'ok';
        } else {
            return $stmt->errorInfo();
            
        }

        $stmt = null;
    }

    static public function mdlInfocontratista($idContratista)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT contratistas_contratistas.*, par_tipo_documentos.descripcion AS tipo_documento_contratista, contratistas_par_tipos_contratistas.tipo_contratistas AS tipo_contratistas_full FROM par_tipo_documentos JOIN contratistas_contratistas ON contratistas_contratistas.tipo_identi_contratistas = par_tipo_documentos.tipo JOIN contratistas_par_tipos_contratistas ON contratistas_contratistas.tipo_contratistas = contratistas_par_tipos_contratistas.tipo
            WHERE contratistas_contratistas.id_contratistas = :id_contratista WHERE contratistas_contratistas.id_contratistas = :id_contratista");

        $stmt->bindParam(":id_contratista", $idContratista, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }
}

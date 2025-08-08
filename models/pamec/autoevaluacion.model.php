<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelAutoevaluacion
{
    static public function mdlGuardarInfoGeneral($tabla, $datos)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("INSERT INTO $tabla (grupo, subgrupo, codigo, proceso, periodo_autoevaluacion, sede, programa, usuario,estado)VALUES (:grupo, :subgrupo, :codigo, :proceso, :autoevaluacion, :sede, :programa, :usuario,'PENDIENTE')");

        $stmt->bindParam(":grupo",         $datos["grupo"],          PDO::PARAM_STR);
        $stmt->bindParam(":subgrupo",      $datos["subGrupo"],       PDO::PARAM_STR);
        $stmt->bindParam(":codigo",        $datos["estandar"],       PDO::PARAM_STR);
        // $stmt->bindParam(":id_resolucion", $datos["resolucion"],     PDO::PARAM_INT);
        $stmt->bindParam(":proceso",    $datos["procesoForm"],    PDO::PARAM_STR);
        $stmt->bindParam(":autoevaluacion", $datos["autoevaluacion"], PDO::PARAM_STR);
        $stmt->bindParam(":sede",       $datos["sede"],           PDO::PARAM_STR);
        $stmt->bindParam(":programa",   $datos["programa"],       PDO::PARAM_STR);
        $stmt->bindParam(":usuario",       $datos["usuario"],        PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $pdo->lastInsertId();
        } else {
            return "error";
        }

        $stmt = null;
    }

    static public function mdlObtenerInfoAutoevaluacion($idAutoEva, $tabla)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT * FROM $tabla WHERE id_autoevaluacion= :idAutoEva");

        $stmt->bindParam(":idAutoEva", $idAutoEva, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlListaPreguntasCualitativasAutoevaluacion()
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pamec_par_variables_cualitativas;");

        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlGuardarInfoCualitativa($tabla, $datos)
    {
        $pdo = Connection::connectOnly();
        $numRespuestas = count($datos["listaRespuestas"]);
        $filasPlaceholders = [];
        $values = [];

        foreach ($datos["listaRespuestas"] as $r) {
            $filasPlaceholders[] = '(?,?,?,?)';
            // id_autoevaluacion
            $values[] = $datos["idAutoEva"];
            // id_variable
            $values[] = $r["id_variable"];
            // descripcion
            $values[] = $r["descripcion"];
            // usuario
            $values[] = $datos["usuario"];
        }
        $placeholders = implode(', ', $filasPlaceholders);

        // Armamos el SQL final
        $stmt = $pdo->prepare("INSERT INTO $tabla (id_autoevaluacion, id_variable, descripcion, usuario_crea)VALUES $placeholders");

        if ($stmt->execute($values)) {

            $stmt2 = $pdo->prepare("UPDATE pamec_autoevaluacion SET estado= 'PROCESO' WHERE id_autoevaluacion = :idAutoEva ");
            $stmt2->bindParam(":idAutoEva", $datos["idAutoEva"], PDO::PARAM_STR);
            if ($stmt2->execute()) {
                return 'ok';
            } else {
                return $stmt2->errorInfo();
            }
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlActualizarInfoGeneralAutoevaluacion($tabla, $datos)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("UPDATE $tabla SET grupo= :grupo,subgrupo  = :subgrupo, codigo = :codigo,proceso  = :proceso, periodo_autoevaluacion = :autoevaluacion, sede   = :sede,  programa  = :programa,usuario  = :usuario WHERE id_autoevaluacion = :idAutoevaluacion ");

        $stmt->bindParam(":grupo",   $datos["grupo"],   PDO::PARAM_STR);
        $stmt->bindParam(":subgrupo",   $datos["subGrupo"],   PDO::PARAM_STR);
        $stmt->bindParam(":codigo",   $datos["estandar"],   PDO::PARAM_STR);
        $stmt->bindParam(":proceso",   $datos["procesoForm"],   PDO::PARAM_STR);
        $stmt->bindParam(":autoevaluacion", $datos["autoevaluacion"], PDO::PARAM_STR);
        $stmt->bindParam(":sede",   $datos["sede"],   PDO::PARAM_STR);
        $stmt->bindParam(":programa",   $datos["programa"],   PDO::PARAM_STR);
        $stmt->bindParam(":usuario",   $datos["usuario"],   PDO::PARAM_STR);
        $stmt->bindParam(":idAutoevaluacion",     $datos["idAutoevaluacion"],     PDO::PARAM_INT);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return "error";
        }
        $stmt = null;
    }

    static public function mdlObtenerInfoCualitativaAutoevaluacion($idAutoEva, $tabla)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT * FROM $tabla WHERE id_autoevaluacion= :idAutoEva and is_active = '1' ");

        $stmt->bindParam(":idAutoEva", $idAutoEva, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlActualizarInfoCualitativa($tabla, $datos)
    {
        $stmtDelete = Connection::connectOnly()->prepare("UPDATE $tabla SET is_active = '0' , usuario_elimina = :usuario , fecha_elimina = CURRENT_TIMESTAMP WHERE id_autoevaluacion = :idAutoEva ;");
        $stmtDelete->bindParam(":idAutoEva", $datos["idAutoEva"], PDO::PARAM_STR);
        $stmtDelete->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

        if ($stmtDelete->execute()) {
            $pdo = Connection::connectOnly();
            $numRespuestas = count($datos["listaRespuestas"]);
            $filasPlaceholders = [];
            $values = [];

            foreach ($datos["listaRespuestas"] as $r) {
                $filasPlaceholders[] = '(?,?,?,?)';
                // id_autoevaluacion
                $values[] = $datos["idAutoEva"];
                // id_variable
                $values[] = $r["id_variable"];
                // descripcion
                $values[] = $r["descripcion"];
                // usuario
                $values[] = $datos["usuario"];
            }
            $placeholders = implode(', ', $filasPlaceholders);

            // Armamos el SQL final
            $stmt = $pdo->prepare("INSERT INTO $tabla (id_autoevaluacion, id_variable, descripcion, usuario_crea)VALUES $placeholders");

            if ($stmt->execute($values)) {
                return 'ok';
            } else {
                return $stmt->errorInfo();
            }
        } else {
            return 'error';
        }

        $stmt = null;
        $stmtDelete = null;
    }

    static public function mdlListaDimensionesCuantitativaAutoevaluacion($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT dimension FROM $tabla GROUP BY dimension;");

        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlListaVariablesDimension($tabla, $dimension)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla where dimension = :dimension GROUP BY variable;");
        $stmt->bindParam(":dimension", $dimension, PDO::PARAM_STR);


        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlListaRespuestasVariables($tabla, $dimension, $variable)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla where dimension = :dimension and variable = :variable ORDER BY escala ASC");
        $stmt->bindParam(":dimension", $dimension, PDO::PARAM_STR);
        $stmt->bindParam(":variable", $variable, PDO::PARAM_STR);



        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlGuardarInfoCuantitativa($tabla, $datos)
    {
        $pdo = Connection::connectOnly();
        $numRespuestas = count($datos["listaRespuestas"]);
        $filasPlaceholders = [];
        $values = [];

        foreach ($datos["listaRespuestas"] as $r) {
            $filasPlaceholders[] = '(?,?,?,?)';
            // id_autoevaluacion
            $values[] = $datos["idAutoEva"];
            // id_escala
            $values[] = $r["id_escala"];
            // escala
            $values[] = $r["variable"];
            // usuario
            $values[] = $datos["usuario"];
        }
        $placeholders = implode(', ', $filasPlaceholders);

        // Armamos el SQL final
        $stmt = $pdo->prepare("INSERT INTO $tabla (id_autoevaluacion, id_escala, variable, usuario_crea)VALUES $placeholders");

        if ($stmt->execute($values)) {

            $stmt2  = Connection::connectOnly()->prepare("UPDATE pamec_autoevaluacion_respuesta_cuantitativa r  JOIN pamec_par_escalas_calificacion_cuantitativa p  ON r.id_escala = p.id_escala  SET r.escala = p.escala;");
            if ($stmt2->execute()) {

                $stmt3 = $pdo->prepare("UPDATE pamec_autoevaluacion SET estado= 'PROCESO' WHERE id_autoevaluacion = :idAutoEva ");
                $stmt3->bindParam(":idAutoEva", $datos["idAutoEva"], PDO::PARAM_STR);


                if ($stmt3->execute()) {
                    return 'ok';
                } else {
                    return $stmt3->errorInfo();
                }
            } else {
                return $stmt2->errorInfo();
            }
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
        $stmt2 = null;
    }

    static public function mdlObtenerInfoCuantitativaAutoevaluacion($idAutoEva)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT parct.*,ppecc.dimension,ppecc.descripcion  FROM pamec_autoevaluacion_respuesta_cuantitativa parct JOIN pamec_par_escalas_calificacion_cuantitativa ppecc ON parct.id_escala=ppecc.id_escala  WHERE id_autoevaluacion = :idAutoEva and parct.is_active = '1' ");

        $stmt->bindParam(":idAutoEva", $idAutoEva, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlActualizarInfoCuantitativa($tabla, $datos)
    {
        $stmtDelete = Connection::connectOnly()->prepare("UPDATE $tabla SET is_active = '0' , usuario_elimina = :usuario , fecha_elimina = CURRENT_TIMESTAMP WHERE id_autoevaluacion = :idAutoEva ;");
        $stmtDelete->bindParam(":idAutoEva", $datos["idAutoEva"], PDO::PARAM_STR);
        $stmtDelete->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);


        if ($stmtDelete->execute()) {
            $actualizar = ModelAutoevaluacion::mdlGuardarInfoCuantitativa($tabla, $datos);
            return $actualizar;
        } else {
            return 'error';
        }

        $stmt = null;
        $stmtDelete = null;
    }

    static public function mdlGuardarInfoPriorizacion($tabla, $datos)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("INSERT INTO $tabla (id_autoevaluacion , grupo , estandar , sedes , oportunidades_mejora , acciones_oportunidades , riesgo , costo , volumen , nivel_estimacion , usuario_crea, fecha_crea)VALUES (:id_autoevaluacion ,:grupo ,:estandar ,:sedes ,:oportunidades_mejora ,:acciones_oportunidades ,:riesgo ,:costo ,:volumen ,:nivel_estimacion ,:usuario_crea, CURRENT_TIMESTAMP)");

        $stmt->bindParam(":id_autoevaluacion", $datos["idAutoEva"], PDO::PARAM_STR);
        $stmt->bindParam(":grupo", $datos["grupo"], PDO::PARAM_STR);
        $stmt->bindParam(":estandar", $datos["estandar"], PDO::PARAM_STR);
        $stmt->bindParam(":sedes", $datos["sedes"], PDO::PARAM_STR);
        $stmt->bindParam(":oportunidades_mejora", $datos["variable3"], PDO::PARAM_STR);
        $stmt->bindParam(":acciones_oportunidades", $datos["variable5"], PDO::PARAM_STR);
        $stmt->bindParam(":riesgo", $datos["selRiesgoPrio"], PDO::PARAM_STR);
        $stmt->bindParam(":costo", $datos["selCostoPriorizacion"], PDO::PARAM_STR);
        $stmt->bindParam(":volumen", $datos["selVolumenPriorizacion"], PDO::PARAM_STR);
        $stmt->bindParam(":nivel_estimacion", $datos["NEPriorizacion"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            $stmt2 = $pdo->prepare("UPDATE pamec_autoevaluacion SET estado= 'PROCESO' WHERE id_autoevaluacion = :idAutoEva");
            $stmt2->bindParam(":idAutoEva", $datos["idAutoEva"], PDO::PARAM_STR);


            if ($stmt2->execute()) {
                return 'ok';
            } else {
                return $stmt2->errorInfo();
            }
        } else {
            return "error";
        }

        $stmt = null;
    }

    static public function mdlListaPriorizacionesAutoevaluacion($idAutoEva, $tabla)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT * FROM $tabla WHERE id_autoevaluacion=:idAutoEva AND is_active = 1 order by nivel_estimacion desc ");

        $stmt->bindParam(":idAutoEva", $idAutoEva, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlEliminarPriorizacionAutoEvaluacion($tabla, $id_respuesta_priorizacion, $user)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("UPDATE $tabla SET is_active = '0' , usuario_elimina = :usuario_elimina, fecha_elimina = CURRENT_TIMESTAMP where id_respuesta_priorizacion = :id_respuesta_priorizacion ");

        $stmt->bindParam(":id_respuesta_priorizacion", $id_respuesta_priorizacion, PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $user, PDO::PARAM_STR);


        if ($stmt->execute()) {
            return 'ok';
        } else {
            return "error";
        }

        $stmt = null;
    }

    static public function mdlListarOpcionesRespPriorizacion($id_variable_priorizacion)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT CONCAT(escala, '-', descripcion) AS opciones FROM pamec_par_escalas_priorizacion WHERE id_variable_priorizacion = :id_variable_priorizacion");
        $stmt->bindParam(":id_variable_priorizacion", $id_variable_priorizacion, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } else {
            return 'error';
        }
        $stmt = null;
    }

    static public function mdlObtenerVariablesPriorizacion()
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT id_variable_priorizacion,variable  FROM pamec_par_variables_priorizacion");
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } else {
            return 'error';
        }
        $stmt = null;
    }

    static public function mdlTerminarGestionAutoevaluacion($datos)
    {
        $pdo = Connection::connectOnly();
        $idAutoeva = $datos['idAutoeva'];

        $stmtPrio = $pdo->prepare("SELECT COUNT(*) FROM pamec_autoevaluacion_priorizacion_respuesta WHERE id_autoevaluacion = :idAutoeva and is_active = 1");
        $stmtPrio->bindParam(":idAutoeva", $idAutoeva, PDO::PARAM_STR);
        if ($stmtPrio->execute()) {
            $countPriorizacion = $stmtPrio->fetchColumn();
            if ($countPriorizacion == 0) {
                return "sin_priorizacion";
            }
        } else {
            return 'error';
        }

        $stmtCualitativa = $pdo->prepare("SELECT COUNT(*) FROM pamec_autoevaluacion_respuesta_cualitativa WHERE id_autoevaluacion = :idAutoeva");
        $stmtCualitativa->bindParam(":idAutoeva", $idAutoeva, PDO::PARAM_STR);
        if ($stmtCualitativa->execute()) {
            $countCualitativa = $stmtCualitativa->fetchColumn();
            if ($countCualitativa == 0) {
                return "sin_cualitativa";
            }
        } else {
            return 'error';
        }

        $stmtCuantitativa = $pdo->prepare("SELECT COUNT(*) FROM pamec_autoevaluacion_respuesta_cuantitativa WHERE id_autoevaluacion = :idAutoeva");
        $stmtCuantitativa->bindParam(":idAutoeva", $idAutoeva, PDO::PARAM_STR);
        if ($stmtCuantitativa->execute()) {
            $countCuantitativa = $stmtCuantitativa->fetchColumn();
            if ($countCuantitativa == 0) {
                return "sin_cuantitativa";
            }
        } else {
            return 'error';
        }


        $stmt = $pdo->prepare("UPDATE pamec_autoevaluacion SET estado = 'TERMINADO', fecha_fin = CURRENT_TIMESTAMP , usuario_fin = :user WHERE id_autoevaluacion = :idAutoeva");
        $stmt->bindParam(":idAutoeva", $idAutoeva, PDO::PARAM_STR);
        $stmt->bindParam(":user", $datos['user'], PDO::PARAM_STR);


        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmtPrio = null;
        $stmtCualitativa = null;
        $stmtCuantitativa = null;
        $stmt = null;
    }

    static public function mdlListaMisAutoevaluaciones($user)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT pa.* FROM pamec_autoevaluacion pa join pamec_par_periodos_autoevaluacion ppa on pa.periodo_autoevaluacion = ppa.periodo WHERE usuario = :user and ppa.is_active='1' and ppa.seleccionado='1'");
        $stmt->bindParam(":user", $user, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlListaAutoevaluacionesVerEvaluador()
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT pa.* FROM pamec_autoevaluacion pa join pamec_par_periodos_autoevaluacion as ppa on pa.periodo_autoevaluacion=ppa.periodo  WHERE ppa.is_active='1' and ppa.seleccionado = '1' and pa.is_active='1' and (pa.estado = 'PROCESO' or pa.estado = 'ABIERTO' or pa.estado='TERMINADO' or pa.estado='CREADO' or pa.estado = 'PENDIENTE' )");
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    // static public function mdlCargarArchivosEvidenciaAutoevaluacion($tabla, $datos, $target_path_archivo)
    // {

    //     $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_autoevaluacion, ruta_archivo , usuario_crea , fecha_crea) VALUES (:idAutoEva, :ruta_archivo_evidencia, :user,CURRENT_TIMESTAMP )");

    //     $stmt->bindParam(":idAutoEva", $datos["idAutoEva"], PDO::PARAM_STR);
    //     $stmt->bindParam(":ruta_archivo_evidencia", $target_path_archivo, PDO::PARAM_STR);
    //     $stmt->bindParam(":user", $datos["user"], PDO::PARAM_STR);

    //     if ($stmt->execute()) {

    //         return 'ok';
    //     } else {

    //         return $stmt->errorInfo();
    //     }

    //     $stmt = null;
    // }

    static public function mdlCargarCarpetaArchivosAutoevaluacion($datos)
    {

        $stmt = Connection::connectOnly()->prepare("UPDATE pamec_autoevaluacion SET  ruta_archivo_evidencia= :ruta_archivo_evidencia WHERE  id_autoevaluacion = :idAutoEva AND ruta_archivo_evidencia IS NULL");

        $stmt->bindParam(":idAutoEva", $datos["idAutoEva"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo_evidencia", $datos["ruta_archivo_evidencia"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return 'ok';
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlInfoAutoevaluacionArchivos($tabla, $idAutoEva)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_autoevaluacion = :idAutoEva");
        $stmt->bindParam(":idAutoEva", $idAutoEva, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return 'error';
        }

        $stmt = null;
    }

    static public function mdlEliminarArchivoEvidencia($tabla, $datos)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("INSERT INTO $tabla (id_autoevaluacion, ruta_archivo, archivo, usuario_elimina, fecha_elimina) VALUES (:id_autoevaluacion, :ruta_archivo, :archivo, :usuario_elimina, CURRENT_TIMESTAMP)");

        $stmt->bindParam(":id_autoevaluacion", $datos["id_autoevaluacion"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":archivo", $datos["archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlVerificarPeriodosCreacion($tabla)
    {

        $stmtVerificarEstado = Connection::connectOnly()->prepare("SELECT periodo FROM $tabla WHERE seleccionado = '1' and estado='PROCESO' limit 1;");

        if ($stmtVerificarEstado->execute()) {
            $activoEnProceso = $stmtVerificarEstado->fetchColumn();
            return $activoEnProceso ? $activoEnProceso : 'ok';
        } else {
            return $stmtVerificarEstado->errorInfo();
        }
    }

    static public function mdlGuardarPeriodoAutoevaluacion($datos, $tabla)
    {

        $stmtVerificarDuplicado = Connection::connectOnly()->prepare("SELECT COUNT(*) FROM $tabla WHERE periodo = :periodo and is_active='1' ;");
        $stmtVerificarDuplicado->bindParam(":periodo", $datos["periodo"], PDO::PARAM_STR);

        if ($stmtVerificarDuplicado->execute()) {
            $existe = $stmtVerificarDuplicado->fetchColumn();

            if ($existe > 0) {
                return "duplicado";
            }
        } else {
            return $stmtVerificarDuplicado->errorInfo();
        }
        $stmtVerificarDuplicado = null;
        $stmtInsertar = Connection::connectOnly()->prepare("INSERT INTO $tabla (periodo,seleccionado,usuario_crea, fecha_crea,estado)VALUES (:periodo,'1',:usuario, CURRENT_TIMESTAMP, 'PROCESO' )");
        $stmtInsertar->bindParam(":periodo", $datos["periodo"], PDO::PARAM_STR);
        $stmtInsertar->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

        if ($stmtInsertar->execute()) {

            $stmtUpdate = Connection::connectOnly()->prepare("UPDATE $tabla SET seleccionado = '0' where periodo != :periodo ;");
            $stmtUpdate->bindParam(":periodo", $datos["periodo"], PDO::PARAM_STR);

            if ($stmtUpdate->execute()) {
                return "ok";
            } else {
                return $stmtUpdate->errorInfo();
            }
        } else {
            return $stmtInsertar->errorInfo();
        }

        $stmtInsertar = null;
    }

    static public function mdlListaPeriodosAutoevaluacionPamec($tabla)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT * from $tabla where is_active = '1' ");
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlPeriodoAutoevaluacionActivo($tabla)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT * FROM $tabla  WHERE is_active = '1' AND seleccionado='1'");

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    public static function mdlSedesEvaluadasPorEstandar($codigo, $periodo)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT sede FROM pamec_autoevaluacion WHERE codigo = :codigo AND periodo_autoevaluacion = :periodo");
        $stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
        $stmt->bindParam(":periodo", $periodo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function mdlProgramasEvaluadosPorEstandar($codigo, $periodo)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT programa FROM pamec_autoevaluacion WHERE codigo = :codigo AND periodo_autoevaluacion = :periodo");
        $stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
        $stmt->bindParam(":periodo", $periodo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function mdlTodasSedes()
    {
        $stmt = Connection::connectOnly()->prepare("SELECT sede FROM pamec_par_sedes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function mdlTodosProgramas()
    {
        $stmt = Connection::connectOnly()->prepare("SELECT programa FROM pamec_par_programas");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    static public function mdlConsultarAutoevaluaciones($datos)
    {

        if (empty($datos["selectPeriodoAutoevaluacion"])) {
            $textGrupo    = "";
            $textSubGrupo = "";
            $textEstandar = "";
            $textSede     = "";
            if (!empty($datos["grupo"])) {
                $textGrupo = " AND pa.grupo LIKE :grupo ";
            }
            if (!empty($datos["subGrupo"])) {
                $textSubGrupo = " AND pa.subgrupo LIKE :subgrupo ";
            }
            if (!empty($datos["estandar"])) {
                $textEstandar = " AND pa.codigo LIKE :estandar ";
            }
            if (!empty($datos["selSedesPamec"])) {
                $textSede = " AND pa.sede LIKE :sede ";
            }

            $sqlAll = "SELECT    pa.*   FROM pamec_autoevaluacion pa   JOIN pamec_par_periodos_autoevaluacion ppp    ON pa.periodo_autoevaluacion = ppp.periodo   WHERE ppp.seleccionado = '0'   $textGrupo   $textSubGrupo   $textEstandar   $textSede   ORDER BY pa.id_autoevaluacion DESC";

            $stmtAll = Connection::connectOnly()->prepare($sqlAll);

            if (!empty($datos["grupo"])) {
                $grupoLike = "%" . $datos["grupo"] . "%";
                $stmtAll->bindParam(":grupo", $grupoLike, PDO::PARAM_STR);
            }
            if (!empty($datos["subGrupo"])) {
                $subGrupoLike = "%" . $datos["subGrupo"] . "%";
                $stmtAll->bindParam(":subgrupo", $subGrupoLike, PDO::PARAM_STR);
            }
            if (!empty($datos["estandar"])) {
                $estandarLike = "%" . $datos["estandar"] . "%";
                $stmtAll->bindParam(":estandar", $estandarLike, PDO::PARAM_STR);
            }
            if (!empty($datos["selSedesPamec"])) {
                $sedeLike = "%" . $datos["selSedesPamec"] . "%";
                $stmtAll->bindParam(":sede", $sedeLike, PDO::PARAM_STR);
            }

            if ($stmtAll->execute()) {
                return $stmtAll->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stmtAll->errorInfo();
            }

            $stmtAll = null;
        } else {
            $textGrupo    = "";
            $textSubGrupo = "";
            $textEstandar = "";
            $textSede     = "";
            if (!empty($datos["grupo"])) {
                $textGrupo = " AND pa.grupo LIKE :grupo ";
            }
            if (!empty($datos["subGrupo"])) {
                $textSubGrupo = " AND pa.subgrupo LIKE :subgrupo ";
            }
            if (!empty($datos["estandar"])) {
                $textEstandar = " AND pa.codigo LIKE :estandar ";
            }
            if (!empty($datos["selSedesPamec"])) {
                $textSede = " AND pa.sede LIKE :sede ";
            }
            $sql = "SELECT     pa.id_autoevaluacion,    pa.grupo,    pa.subgrupo,    pa.codigo,    pa.proceso,    pa.periodo_autoevaluacion,    pa.sede,    pa.programa,    pa.estado    FROM pamec_autoevaluacion pa    WHERE pa.periodo_autoevaluacion LIKE :periodo      $textGrupo      $textSubGrupo      $textEstandar      $textSede    ORDER BY pa.id_autoevaluacion DESC";
            $stmt = Connection::connectOnly()->prepare($sql);

            $periodoLike = "%" . $datos["selectPeriodoAutoevaluacion"] . "%";
            $stmt->bindParam(":periodo", $periodoLike, PDO::PARAM_STR);

            if (!empty($datos["grupo"])) {
                $grupoLike = "%" . $datos["grupo"] . "%";
                $stmt->bindParam(":grupo", $grupoLike, PDO::PARAM_STR);
            }
            if (!empty($datos["subGrupo"])) {
                $subGrupoLike = "%" . $datos["subGrupo"] . "%";
                $stmt->bindParam(":subgrupo", $subGrupoLike, PDO::PARAM_STR);
            }
            if (!empty($datos["estandar"])) {
                $estandarLike = "%" . $datos["estandar"] . "%";
                $stmt->bindParam(":estandar", $estandarLike, PDO::PARAM_STR);
            }
            if (!empty($datos["selSedesPamec"])) {
                $sedeLike = "%" . $datos["selSedesPamec"] . "%";
                $stmt->bindParam(":sede", $sedeLike, PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stmt->errorInfo();
            }

            $stmt = null;
        }
    }

    static public function mdlGuardarNoAplicaAutoevaluacion($idAutoeva, $user)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("UPDATE pamec_autoevaluacion SET estado = 'NO APLICA' , fecha_fin = CURRENT_TIMESTAMP , usuario_fin = :user  WHERE id_autoevaluacion = :idAutoeva");
        $stmt->bindParam(":idAutoeva", $idAutoeva, PDO::PARAM_STR);
        $stmt->bindParam(":user", $user, PDO::PARAM_STR);


        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt = null;
    }

    static public function mdlListaPriorizacionesGeneral($tabla)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT * , papr.estado as estadoPriorizacion FROM $tabla as papr join pamec_autoevaluacion pa on papr.id_autoevaluacion=pa.id_autoevaluacion join pamec_par_periodos_autoevaluacion as ppa on pa.periodo_autoevaluacion=ppa.periodo WHERE ppa.is_active='1' and ppa.seleccionado = '1' AND papr.is_active = 1 AND pa.estado!='NO APLICA' order by nivel_estimacion desc  ");
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }

        $stmt = null;
    }
}

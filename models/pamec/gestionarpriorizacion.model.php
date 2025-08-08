<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelGestionPriorizacion
{
    static public function mdlActualizarEstadoPriorizacion($datos)
    {
        if ($datos['gestion'] == 'PROCESO') {
            $pdo = Connection::connectOnly();
            $sql = "SELECT estado FROM pamec_autoevaluacion_priorizacion_respuesta WHERE id_respuesta_priorizacion= :idPrio";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idPrio', $datos['idPrio'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                $fila = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($fila['estado'] === 'CREADO') {
                    $sqlUpd = "UPDATE pamec_autoevaluacion_priorizacion_respuesta SET estado = 'PROCESO' WHERE id_respuesta_priorizacion = :idPrio";
                    $stmt2 = $pdo->prepare($sqlUpd);
                    $stmt2->bindParam(':idPrio', $datos['idPrio'], PDO::PARAM_INT);
                    if ($stmt2->execute()) {
                        return 'ok';
                    } else {
                        return $stmt2->errorInfo();
                    }
                } else if ($fila['estado'] === 'PROCESO') {
                    return 'ok';
                }
            } else {
                return $stmt->errorInfo();
            }
        } else if ($datos['gestion'] == 'TERMINAR') {
            $pdo = Connection::connectOnly();
            $sql = "SELECT estado FROM pamec_autoevaluacion_priorizacion_respuesta WHERE id_respuesta_priorizacion= :idPrio";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idPrio', $datos['idPrio'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                $fila = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($fila['estado'] === 'PROCESO') {
                    $sqlUpd = "UPDATE pamec_autoevaluacion_priorizacion_respuesta SET estado = 'FINALIZADO' , fecha_termina= CURRENT_TIMESTAMP , usuario_termina = :user WHERE id_respuesta_priorizacion = :idPrio";
                    $stmt2 = $pdo->prepare($sqlUpd);
                    $stmt2->bindParam(':idPrio', $datos['idPrio'], PDO::PARAM_INT);
                    $stmt2->bindParam(':user', $datos['user'], PDO::PARAM_STR);

                    if ($stmt2->execute()) {
                        return 'ok';
                    } else {
                        return $stmt2->errorInfo();
                    }
                }
            } else {
                return $stmt->errorInfo();
            }
        }
    }
    static public function mdlGuardarCalidadEsperada($datos, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "INSERT INTO $tabla (id_respuesta_priorizacion, meta_autoevaluacion, nombre_indicador, meta_indicador, usuario_crea, fecha_crea) VALUES (:idPrio,:metaAuto,:nomInd,:metaInd,:user,CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':idPrio', $datos['idPrio'], PDO::PARAM_INT);
        $stmt->bindParam(':metaAuto', $datos['metaAutoevaluacion'], PDO::PARAM_STR);
        $stmt->bindParam(':nomInd', $datos['nombreIndicador'], PDO::PARAM_STR);
        $stmt->bindParam(':metaInd', $datos['metaIndicador'], PDO::PARAM_STR);
        $stmt->bindParam(':user', $datos['user'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlListaCalidadEsperada($idPrio, $tabla)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT id_calidad_esperada,meta_autoevaluacion,nombre_indicador,meta_indicador, (SELECT COUNT(*) FROM pamec_calidad_observada o WHERE o.id_calidad_esperada = pamec_calidad_esperada.id_calidad_esperada AND o.is_active = 1) AS existe_observada FROM $tabla WHERE id_respuesta_priorizacion = :idPrio AND is_active = 1");
        $stmt->bindParam(":idPrio", $idPrio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlObtenerValorEvaluacionCuantitativa($idPrio)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT    r.escala  FROM    pamec_autoevaluacion_priorizacion_respuesta p    JOIN pamec_autoevaluacion_respuesta_cuantitativa r ON p.id_autoevaluacion = r.id_autoevaluacion   WHERE    p.is_active = 1     AND p.id_respuesta_priorizacion = :idPrio     AND r.is_active = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPrio', $idPrio, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlGuardarCalidadObservada($datos, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "INSERT INTO $tabla (id_calidad_esperada, resultado_autoevaluacion, resultado_indicador, observacion, usuario_crea, fecha_crea) VALUES (:idCalidadEsperadaObs,:resultadoAutoeval,:resultadoIndicador,:obsCalidadObservada,:user,CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':idCalidadEsperadaObs', $datos['idCalidadEsperadaObs'], PDO::PARAM_INT);
        $stmt->bindParam(':resultadoAutoeval', $datos['resultadoAutoeval'], PDO::PARAM_STR);
        $stmt->bindParam(':resultadoIndicador', $datos['resultadoIndicador'], PDO::PARAM_STR);
        $stmt->bindParam(':obsCalidadObservada', $datos['obsCalidadObservada'], PDO::PARAM_STR);
        $stmt->bindParam(':user', $datos['user'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlVerCalidadObservada($idCalidadEsperada, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT id_calidad_observada,id_calidad_esperada,resultado_autoevaluacion,resultado_indicador,observacion,usuario_crea,fecha_crea FROM $tabla WHERE id_calidad_esperada = :idCalidadEsperada AND is_active = 1 LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idCalidadEsperada', $idCalidadEsperada, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function mdlEliminarCalidadEsperada($idCalidad, $user, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "UPDATE $tabla SET is_active = '0',usuario_elimina = :user,fecha_elimina = CURRENT_TIMESTAMP WHERE id_calidad_esperada = :idCalidad";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idCalidad', $idCalidad, PDO::PARAM_INT);
        $stmt->bindParam(':user', $user, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlEliminarCalidadObservada($idCalidadObs, $user, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "UPDATE $tabla  SET is_active = '0', usuario_elimina = :user, fecha_elimina   = CURRENT_TIMESTAMP WHERE id_calidad_observada = :idCalidadObs";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idCalidadObs', $idCalidadObs, PDO::PARAM_INT);
        $stmt->bindParam(':user',         $user,         PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlObtenerInfoGeneralPriorizacion($idPrio)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT * FROM pamec_autoevaluacion_priorizacion_respuesta p WHERE p.id_respuesta_priorizacion = :idPrio AND p.is_active = 1 LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPrio', $idPrio, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlVerificarCalidadObservadaExiste($idPrio)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT COUNT(o.id_calidad_observada) AS total_observadas FROM pamec_calidad_esperada ce JOIN pamec_calidad_observada o ON ce.id_calidad_esperada = o.id_calidad_esperada WHERE ce.id_respuesta_priorizacion = :idPrio AND ce.is_active = 1 AND o.is_active = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPrio', $idPrio, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            return intval($fila['total_observadas']);
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlListaCalidadObservada($idPrio, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT o.id_calidad_observada, e.nombre_indicador, o.resultado_autoevaluacion, o.resultado_indicador, o.observacion FROM pamec_calidad_observada o INNER JOIN pamec_calidad_esperada e ON o.id_calidad_esperada = e.id_calidad_esperada WHERE e.id_respuesta_priorizacion = :idPrio AND e.is_active = 1 AND o.is_active = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPrio', $idPrio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlListaSedesPorPriorizacion($idPrio)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT sedes FROM pamec_autoevaluacion_priorizacion_respuesta WHERE id_respuesta_priorizacion = :idPrio AND is_active = 1 LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPrio', $idPrio, PDO::PARAM_INT);
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila['sedes'];
    }

    static public function mdlListaAccionesMejora($idCalidadObservada, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT id_accion_mejora,que,tipo_accion,porque,como,donde,quien,fecha_inicio,fecha_fin,acciones_planeadas,observaciones FROM $tabla WHERE id_calidad_observada = :idCalidadObservada AND is_active = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idCalidadObservada', $idCalidadObservada, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlCrearAccionMejora($datos, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "INSERT INTO $tabla (id_calidad_observada, que, tipo_accion, porque, como, donde, quien,fecha_inicio, fecha_fin, acciones_planeadas, observaciones,usuario_crea, fecha_crea)VALUES(:idCalidadObs, :que, :tipo_accion, :porque, :como, :donde, :quien,:fecha_inicio, :fecha_fin, :acciones_planeadas, :observaciones,:user, CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idCalidadObs', $datos['idCalidadObservada'],  PDO::PARAM_INT);
        $stmt->bindParam(':que', $datos['que'], PDO::PARAM_STR);
        $stmt->bindParam(':tipo_accion', $datos['tipo_accion'],  PDO::PARAM_STR);
        $stmt->bindParam(':porque', $datos['porque'], PDO::PARAM_STR);
        $stmt->bindParam(':como', $datos['como'], PDO::PARAM_STR);
        $stmt->bindParam(':donde', $datos['donde'], PDO::PARAM_STR);
        $stmt->bindParam(':quien', $datos['quien'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_inicio', $datos['fecha_inicio'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_fin',  $datos['fecha_fin'], PDO::PARAM_STR);
        $stmt->bindParam(':acciones_planeadas', $datos['acciones_planeadas'], PDO::PARAM_INT);
        $stmt->bindParam(':observaciones',  $datos['observaciones'], PDO::PARAM_STR);
        $stmt->bindParam(':user', $datos['user'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlEditarAccionMejora($datos, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "UPDATE $tabla SET que = :que,tipo_accion    = :tipo_accion,   porque = :porque,   como = :como,   donde  = :donde,   quien  = :quien,   fecha_inicio   = :fecha_inicio,   fecha_fin    = :fecha_fin,   acciones_planeadas = :acciones_planeadas,   observaciones  = :observaciones,   usuario_edita  = :user,   fecha_edita    = CURRENT_TIMESTAMP WHERE id_accion_mejora = :idAccionMejora";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':que',   $datos['que'],   PDO::PARAM_STR);
        $stmt->bindParam(':tipo_accion', $datos['tipo_accion'],   PDO::PARAM_STR);
        $stmt->bindParam(':porque', $datos['porque'],   PDO::PARAM_STR);
        $stmt->bindParam(':como', $datos['como'], PDO::PARAM_STR);
        $stmt->bindParam(':donde', $datos['donde'], PDO::PARAM_STR);
        $stmt->bindParam(':quien', $datos['quien'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_inicio', $datos['fecha_inicio'],   PDO::PARAM_STR);
        $stmt->bindParam(':fecha_fin', $datos['fecha_fin'],   PDO::PARAM_STR);
        $stmt->bindParam(':acciones_planeadas', $datos['acciones_planeadas'],  PDO::PARAM_INT);
        $stmt->bindParam(':observaciones', $datos['observaciones'],   PDO::PARAM_STR);
        $stmt->bindParam(':user', $datos['user'],   PDO::PARAM_STR);
        $stmt->bindParam(':idAccionMejora', $datos['idAccionMejora'],   PDO::PARAM_INT);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlVerAccionMejora($idAccionMejora, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT * FROM $tabla WHERE id_accion_mejora = :idAccionMejora AND is_active = 1 LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idAccionMejora', $idAccionMejora, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function mdlEliminarAccionMejora($idAccionMejora, $user, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "UPDATE $tabla SET is_active = '0', usuario_elimina = :user, fecha_elimina = CURRENT_TIMESTAMP WHERE id_accion_mejora = :idAccionMejora";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idAccionMejora', $idAccionMejora, PDO::PARAM_INT);
        $stmt->bindParam(':user',           $user,           PDO::PARAM_STR);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlContarAccionesPriorizacion($idPrio)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT COUNT(*) total FROM pamec_accion_mejora am JOIN pamec_calidad_observada co ON am.id_calidad_observada=co.id_calidad_observada JOIN pamec_calidad_esperada  ce ON co.id_calidad_esperada=ce.id_calidad_esperada WHERE ce.id_respuesta_priorizacion=:id AND am.is_active='1'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $idPrio, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            return $result;
        } else {
            return $stmt->errorInfo();
        }
    }

    // static public function mdlAccionesPorPriorizacion($idPrio)
    // {
    //     $pdo = Connection::connectOnly();
    //     $sql = "SELECT am.* FROM pamec_accion_mejora am JOIN pamec_calidad_observada co ON am.id_calidad_observada=co.id_calidad_observada JOIN pamec_calidad_esperada  ce ON co.id_calidad_esperada=ce.id_calidad_esperada WHERE ce.id_respuesta_priorizacion=:id AND am.is_active='1'";
    //     $stmt = $pdo->prepare($sql);
    //     $stmt->bindParam(':id', $idPrio, PDO::PARAM_INT);
    //     if ($stmt->execute()) {
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } else {
    //         return $stmt->errorInfo();
    //     }
    // }


    static public function mdlAccionesPorPriorizacion($idPrio)
    {
        $pdo = Connection::connectOnly();

        $sql = "SELECT am.*,co.id_calidad_observada,   co.resultado_indicador,   co.resultado_autoevaluacion,   ce.nombre_indicador      FROM pamec_accion_mejora am      JOIN pamec_calidad_observada  co ON co.id_calidad_observada = am.id_calidad_observada      JOIN pamec_calidad_esperada   ce ON ce.id_calidad_esperada = co.id_calidad_esperada      WHERE ce.id_respuesta_priorizacion = :id   AND am.is_active = 1   AND co.is_active = 1   AND ce.is_active = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $idPrio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlListaEvaluaciones($idAccion, $tabla)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT * FROM $tabla WHERE id_accion_mejora=:id AND is_active='1'");
        $stmt->bindParam(':id', $idAccion, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlCrearEvaluacion($datos, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "INSERT INTO $tabla(id_accion_mejora,fecha,acciones_ejecutadas,avance,estado,observaciones,usuario_crea,fecha_crea)VALUES(:idA,:fecha,:ejec,:av,:est,:obs,:user,CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idA', $datos['idAccionMejora'], PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $datos['fecha']);
        $stmt->bindParam(':ejec', $datos['ejecutadas'], PDO::PARAM_INT);
        $stmt->bindParam(':av', $datos['avance']);
        $stmt->bindParam(':est', $datos['estado']);
        $stmt->bindParam(':obs', $datos['observaciones']);
        $stmt->bindParam(':user', $datos['user']);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlEditarEvaluacion($datos, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "UPDATE $tabla SET fecha=:fecha,acciones_ejecutadas=:ejec,avance=:av,estado=:est,observaciones=:obs,usuario_edita=:user,fecha_edita=CURRENT_TIMESTAMP WHERE id_evaluacion=:id AND is_active='1'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fecha', $datos['fecha']);
        $stmt->bindParam(':ejec', $datos['ejecutadas'], PDO::PARAM_INT);
        $stmt->bindParam(':av', $datos['avance'], PDO::PARAM_INT);
        $stmt->bindParam(':est', $datos['estado']);
        $stmt->bindParam(':obs', $datos['observaciones']);
        $stmt->bindParam(':user', $datos['user']);
        $stmt->bindParam(':id', $datos['idEvaluacion'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlVerEvaluacion($idEval, $tabla)
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT * FROM $tabla WHERE id_evaluacion=:id LIMIT 1");
        $stmt->bindParam(':id', $idEval, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function mdlEliminarEvaluacion($idEval, $user, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "UPDATE $tabla SET is_active='0',usuario_elimina=:user,fecha_elimina=CURRENT_TIMESTAMP WHERE id_evaluacion=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':id', $idEval, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlCargarSelectIndicador($idPrio, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT * FROM $tabla  WHERE id_respuesta_priorizacion=:id and is_active='1'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $idPrio, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo();
        }
    }

    static public function mdlListarAprendizajeOrg($idPrio, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT * FROM $tabla WHERE id_respuesta_priorizacion = :idPrio AND is_active = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPrio', $idPrio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlVerAprendizajeOrg($id, $indicador)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT CONCAT(pamecestandar.subgrupo,'-',papr.estandar) as codigo_estandar , ppe.estandar as estandar, count(*) as oportunidades_mejora , SUM(pee.acciones_ejecutadas) as acciones_completas2 , SUM(pee.avance) as avance2 , pce.meta_autoevaluacion,pce.nombre_indicador, pce.meta_indicador, pco.resultado_autoevaluacion as cal_obs_ini, pco.resultado_indicador, pco.resultado_autoevaluacion as cal_obs_final from  pamec_evaluacion_ejecucion pee  join pamec_accion_mejora pam on pee.id_accion_mejora=pam.id_accion_mejora join pamec_calidad_observada pco on pam.id_calidad_observada=pco.id_calidad_observada join pamec_calidad_esperada pce on pco.id_calidad_esperada=pce.id_calidad_esperada join pamec_autoevaluacion_priorizacion_respuesta papr on pce.id_respuesta_priorizacion=papr.id_respuesta_priorizacion join pamec_par_estandares ppe on papr.estandar=ppe.codigo join pamec_par_estandares pamecestandar on papr.estandar= pamecestandar.codigo where pam.is_active='1' and pco.is_active='1' and pce.is_active='1' and papr.is_active='1' and ppe.is_active='1' and pee.is_active='1' and pee.estado='COMPLETO' and pce.id_respuesta_priorizacion= :id and pce.id_calidad_esperada= :indicador";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':indicador', $indicador, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    static public function mdlAprendizajeOrgById($id, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT * FROM $tabla WHERE id_aprendizaje_organizacional=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function mdlCompletas($indicador)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT  COALESCE(SUM(ult.acciones_ejecutadas),0) AS acciones_completas  FROM    pamec_accion_mejora AS am  JOIN    pamec_calidad_observada AS co   ON co.id_calidad_observada = am.id_calidad_observada  JOIN   ( SELECT  ee1.id_accion_mejora,       ee1.acciones_ejecutadas   FROM    pamec_evaluacion_ejecucion AS ee1   INNER JOIN (       SELECT  id_accion_mejora,       MAX(id_evaluacion) AS max_eval       FROM    pamec_evaluacion_ejecucion       WHERE   is_active = 1     AND   estado = 'COMPLETO'       GROUP BY id_accion_mejora   ) AS ult2     ON  ult2.id_accion_mejora = ee1.id_accion_mejora    AND  ult2.max_eval    = ee1.id_evaluacion   WHERE  ee1.is_active = 1     ) AS ult     ON  ult.id_accion_mejora = am.id_accion_mejora  WHERE   am.is_active  = 1    AND   co.is_active  = 1    AND   co.id_calidad_esperada = :indicador;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':indicador', $indicador, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public static function mdlPlaneadas($indicador)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT COALESCE(SUM(pam.acciones_planeadas),0) AS planeadas FROM pamec_accion_mejora pam JOIN pamec_calidad_observada pco ON pco.id_calidad_observada = pam.id_calidad_observada WHERE pam.is_active = '1' AND pco.is_active = '1' AND pco.id_calidad_esperada = :indicador";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':indicador', $indicador, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }


    static public function mdlCrearAprendizajeOrg($datos, $tabla)
    {
        $pdo = Connection::connectOnly();

        if (empty($datos['indicadorAp'])) {
            return 'sin_evaluacion';
        }
        $sql2 = "SELECT COUNT(ee.id_evaluacion) AS total FROM   pamec_calidad_esperada  ce JOIN   pamec_calidad_observada  co  ON co.id_calidad_esperada = ce.id_calidad_esperada  AND co.is_active = 1 JOIN   pamec_accion_mejora           am  ON am.id_calidad_observada = co.id_calidad_observada AND am.is_active = 1 JOIN   pamec_evaluacion_ejecucion    ee  ON ee.id_accion_mejora = am.id_accion_mejora        AND ee.is_active = 1 WHERE  ce.nombre_indicador = :idIndicador";
        $check = $pdo->prepare($sql2);
        $check->bindParam(':idIndicador', $datos['indicadorAp'], PDO::PARAM_INT);
        $check->execute();
        if ($check->fetchColumn() == 0) {
            return 'sin_evaluacion';
        }

        $sql = "INSERT INTO $tabla (id_respuesta_priorizacion, codigo_estandar, estandar, oportunidad_mejora, acciones_completas, porcentaje_avance, estado, observaciones,meta_autoevaluacion, indicador, meta_indicador,calidad_observada_auto, calidad_observada_inicio_ind,calidad_observada_final, calidad_observada_final_ind,barreras_mejoramiento, aprendizaje_organizacional,usuario_crea, fecha_crea) VALUES(:idPrio, :codEst, :estandar, :oportMej,:accComp, :porcAvance, :estado, :obs,:metaAuto, :indicador, :metaInd,:calAuto, :calIniInd,:calFin, :calFinInd,:barreras, :aprendizaje,:user, CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPrio', $datos['idPrio'], PDO::PARAM_INT);
        $stmt->bindParam(':codEst', $datos['codigoEstandar'],  PDO::PARAM_STR);
        $stmt->bindParam(':estandar', $datos['estandar'], PDO::PARAM_STR);
        $stmt->bindParam(':oportMej', $datos['oportunidadMejora'], PDO::PARAM_STR);
        $stmt->bindParam(':accComp', $datos['accionesCompletas'], PDO::PARAM_INT);
        $stmt->bindParam(':porcAvance',  $datos['avancePorcentaje'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $datos['estadoAprendizaje'], PDO::PARAM_STR);
        $stmt->bindParam(':obs', $datos['observaciones'], PDO::PARAM_STR);
        $stmt->bindParam(':metaAuto', $datos['metaAutoevaluacionAp'], PDO::PARAM_STR);
        $stmt->bindParam(':indicador', $datos['indicadorAp'], PDO::PARAM_STR);
        $stmt->bindParam(':metaInd', $datos['metaIndicadorAP'], PDO::PARAM_STR);
        $stmt->bindParam(':calAuto', $datos['calObsIniAuto'], PDO::PARAM_STR);
        $stmt->bindParam(':calIniInd', $datos['calObsIniIndicador'], PDO::PARAM_STR);
        $stmt->bindParam(':calFin', $datos['calObsFin'],  PDO::PARAM_STR);
        $stmt->bindParam(':calFinInd', $datos['calObsFinIndicador'], PDO::PARAM_STR);
        $stmt->bindParam(':barreras', $datos['barrerasMejora'],  PDO::PARAM_STR);
        $stmt->bindParam(':aprendizaje', $datos['obsAprendizajeOrganizacional'], PDO::PARAM_STR);
        $stmt->bindParam(':user', $datos['user'],  PDO::PARAM_STR);

        return $stmt->execute() ? 'ok' : $stmt->errorInfo();
    }


    static public function mdlEliminarAprendizajeOrg($id, $user, $tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "UPDATE $tabla SET is_active = '0', usuario_elimina = :user, fecha_elimina = CURRENT_TIMESTAMP WHERE id_aprendizaje_organizacional = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id',   $id,   PDO::PARAM_INT);
        $stmt->bindParam(':user', $user, PDO::PARAM_STR);
        return $stmt->execute() ? 'ok' : $stmt->errorInfo();
    }

    static public function mdlListarAprendizajeOrgGeneral($tabla)
    {
        $pdo = Connection::connectOnly();
        $sql = "SELECT * ,pao.estado as estado FROM pamec_aprendizaje_organizacional pao join pamec_autoevaluacion_priorizacion_respuesta papr on pao.id_respuesta_priorizacion = papr.id_respuesta_priorizacion join pamec_autoevaluacion pa  on papr.id_autoevaluacion = pa.id_autoevaluacion  join pamec_par_periodos_autoevaluacion as ppa on pa.periodo_autoevaluacion=ppa.periodo WHERE ppa.is_active='1' and ppa.seleccionado = '1' AND papr.is_active = '1' AND  pao.is_active = '1' AND pa.is_active='1'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlListaGestionPamec()
    {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT * FROM pamec_autoevaluacion pa JOIN pamec_autoevaluacion_priorizacion_respuesta papr on pa.id_autoevaluacion=papr.id_autoevaluacion join pamec_par_periodos_autoevaluacion as ppa on pa.periodo_autoevaluacion=ppa.periodo WHERE ppa.is_active='1' and ppa.seleccionado = '1' and pa.is_active='1' and papr.is_active='1' and papr.estado='FINALIZADO'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

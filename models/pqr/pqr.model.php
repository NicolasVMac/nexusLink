<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelPqr{

    static public function mdlEliminarArchivoPQRSF($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_pqr, ruta_archivo, usuario_elimina) VALUES (:id_pqr, :ruta_archivo, :usuario_elimina)");

        $stmt->bindParam(":id_pqr", $datos["id_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);
        
        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPQRSGestionadosGestor($user){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pqr_pqrs WHERE gestor = :gestor AND estado_pqr = 'COMPLETADO'");

        $stmt->bindParam(":gestor", $user, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;



    }

    static public function mdlObtenerDiasHabiles($anio){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pqr_par_dias_festivos WHERE YEAR(fecha) = :fecha");

        $stmt->bindParam(":fecha", $anio, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValidarRevisarPQRSF($idPQR){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pqr_pqrs WHERE id_pqr = :id_pqr AND estado_pqr != 'REVISION'");

        $stmt->bindParam(":id_pqr", $idPQR, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarTrabajadorPQRSF($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pqr_par_trabajadores SET estado = 0, usuario_elimina = :usuario_elimina, fecha_elimina = :fecha_elimina WHERE id_par_trabajador = :id_par_trabajador");

        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_elimina", $datos["fecha_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":id_par_trabajador", $datos["id_par_trabajador"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlValiTrabajador($datos){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pqr_par_trabajadores WHERE tipo_doc_trabajador = :tipo_doc_trabajador AND numero_doc_trabajador = :numero_doc_trabajador");

        $stmt->bindParam(":tipo_doc_trabajador", $datos["tipo_doc_trabajador"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_doc_trabajador", $datos["numero_doc_trabajador"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlAgregarTrabajadorPQRSF($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO pqr_par_trabajadores(tipo_doc_trabajador, numero_doc_trabajador, nombre_trabajador, usuario_crea) VALUES (:tipo_doc_trabajador, :numero_doc_trabajador, :nombre_trabajador, :usuario_crea)");

        $stmt->bindParam(":tipo_doc_trabajador", $datos["tipo_doc_trabajador"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_doc_trabajador", $datos["numero_doc_trabajador"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_trabajador", $datos["nombre_trabajador"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaTrabajadoresPQRSF(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pqr_par_trabajadores WHERE estado = 1");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlGuardarResPQRSF($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pqr_pqrs SET ruta_archivo_res = :ruta_archivo_res, usuario_archivo_res = :usuario_archivo_res, fecha_archivo_res = :fecha_archivo_res, estado_pqr = :estado_pqr, fecha_respuesta_pqr = :fecha_respuesta_pqr WHERE id_pqr = :id_pqr");

        $stmt->bindParam(":ruta_archivo_res", $datos["ruta_archivo_res"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_archivo_res", $datos["usuario_archivo_res"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_archivo_res", $datos["fecha_archivo_res"], PDO::PARAM_STR);
        $stmt->bindParam(":estado_pqr", $datos["estado_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_respuesta_pqr", $datos["fecha_respuesta_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":id_pqr", $datos["id_pqr"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaCargarResPQRSF(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pqr_pqrs WHERE estado_pqr = 'COMPLETADO'");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlGuardarLog($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_pqr, usuario, accion) VALUES (:id_pqr, :usuario, :accion)");

        $stmt->bindParam(":id_pqr", $datos["id_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":accion", $datos["accion"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarPQRSF($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET nombre_pac = :nombre_pac, tipo_identificacion_pac = :tipo_identificacion_pac, numero_identificacion_pac = :numero_identificacion_pac, fecha_nacimiento_pac = :fecha_nacimiento_pac, eps = :eps, regimen = :regimen, programa = :programa, sede = :sede, nombre_pet = :nombre_pet,
            tipo_identificacion_pet = :tipo_identificacion_pet, numero_identificacion_pet = :numero_identificacion_pet, contacto_pet = :contacto_pet, correo_pet = :correo_pet, departamento = :departamento, municipio = :municipio, descripcion_pqr = :descripcion_pqr, medio_recep_pqr = :medio_recep_pqr, fecha_apertura_buzon_suge = :fecha_apertura_buzon_suge,
            tipo_pqr = :tipo_pqr, ente_reporta_pqr = :ente_reporta_pqr, motivo_pqr = :motivo_pqr, trabajador_relacionado_pqr = :trabajador_relacionado_pqr, servicio_area = :servicio_area, clasificacion_atributo = :clasificacion_atributo, tiempo_res_normativo = :tiempo_res_normativo, pla_ac_pqr_recurrente = :pla_ac_pqr_recurrente, pla_ac_accion_efectiva = :pla_ac_accion_efectiva, fecha_pqr = :fecha_pqr, fecha_max_resp_pqr = :fecha_max_resp_pqr WHERE id_pqr = :id_pqr");

        $stmt->bindParam(":id_pqr", $datos["id_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_pac", $datos["nombre_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_identificacion_pac", $datos["tipo_identificacion_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_identificacion_pac", $datos["numero_identificacion_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento_pac", $datos["fecha_nacimiento_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":eps", $datos["eps"], PDO::PARAM_STR);
        $stmt->bindParam(":regimen", $datos["regimen"], PDO::PARAM_STR);
        $stmt->bindParam(":programa", $datos["programa"], PDO::PARAM_STR);
        $stmt->bindParam(":sede", $datos["sede"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_pet", $datos["nombre_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_identificacion_pet", $datos["tipo_identificacion_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_identificacion_pet", $datos["numero_identificacion_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":contacto_pet", $datos["contacto_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":correo_pet", $datos["correo_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento", $datos["departamento"], PDO::PARAM_STR);
        $stmt->bindParam(":municipio", $datos["municipio"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion_pqr", $datos["descripcion_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":medio_recep_pqr", $datos["medio_recep_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_apertura_buzon_suge", $datos["fecha_apertura_buzon_suge"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_pqr", $datos["tipo_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":ente_reporta_pqr", $datos["ente_reporta_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":motivo_pqr", $datos["motivo_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":trabajador_relacionado_pqr", $datos["trabajador_relacionado_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":servicio_area", $datos["servicio_area"], PDO::PARAM_STR);
        $stmt->bindParam(":clasificacion_atributo", $datos["clasificacion_atributo"], PDO::PARAM_STR);
        $stmt->bindParam(":tiempo_res_normativo", $datos["tiempo_res_normativo"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_pqr_recurrente", $datos["pla_ac_pqr_recurrente"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_accion_efectiva", $datos["pla_ac_accion_efectiva"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_pqr", $datos["fecha_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_max_resp_pqr", $datos["fecha_max_resp_pqr"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCantidadPQRSFUser($user){

        $stmt = Connection::connectOnly()->prepare("SELECT COUNT(*) AS cantidad FROM pqr_pqrs WHERE gestor = :gestor AND estado_pqr IN ('CREADA', 'GESTION')");

        $stmt->bindParam(":gestor", $user, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCantidadPQRSTrabajador($trabador, $fecha){

        $stmt = Connection::connectOnly()->prepare("SELECT COUNT(*) AS cantidad FROM pqr_pqrs WHERE trabajador_relacionado_pqr = :trabajador AND MONTH(fecha_crea) = :fecha");

        $stmt->bindParam(":trabajador", $trabador, PDO::PARAM_STR);
        $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearBuzonPQRS($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET nombre_pac = :nombre_pac, tipo_identificacion_pac = :tipo_identificacion_pac, numero_identificacion_pac = :numero_identificacion_pac, fecha_nacimiento_pac = :fecha_nacimiento_pac, eps = :eps,
            regimen = :regimen, programa = :programa, sede = :sede, nombre_pet = :nombre_pet, tipo_identificacion_pet = :tipo_identificacion_pet, numero_identificacion_pet = :numero_identificacion_pet, contacto_pet = :contacto_pet,
            correo_pet = :correo_pet, departamento = :departamento, municipio = :municipio, descripcion_pqr = :descripcion_pqr, medio_recep_pqr = :medio_recep_pqr, fecha_apertura_buzon_suge = :fecha_apertura_buzon_suge,
            fecha_radicacion_pqr = :fecha_radicacion_pqr, tipo_pqr = :tipo_pqr, ente_reporta_pqr = :ente_reporta_pqr, motivo_pqr = :motivo_pqr, trabajador_relacionado_pqr = :trabajador_relacionado_pqr, servicio_area = :servicio_area,
            clasificacion_atributo = :clasificacion_atributo, gestor = :gestor, usuario_crea = :usuario_crea, tiempo_res_normativo = :tiempo_res_normativo, estado_pqr = :estado_pqr, fecha_fin_buzon = :fecha_fin_buzon, pla_ac_pqr_recurrente = :pla_ac_pqr_recurrente, pla_ac_accion_efectiva = :pla_ac_accion_efectiva, fecha_pqr = :fecha_pqr, fecha_max_resp_pqr = :fecha_max_resp_pqr WHERE id_pqr = :id_pqr");

        $stmt->bindParam(":id_pqr", $datos["id_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_pac", $datos["nombre_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_identificacion_pac", $datos["tipo_identificacion_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_identificacion_pac", $datos["numero_identificacion_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento_pac", $datos["fecha_nacimiento_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":eps", $datos["eps"], PDO::PARAM_STR);
        $stmt->bindParam(":regimen", $datos["regimen"], PDO::PARAM_STR);
        $stmt->bindParam(":programa", $datos["programa"], PDO::PARAM_STR);
        $stmt->bindParam(":sede", $datos["sede"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_pet", $datos["nombre_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_identificacion_pet", $datos["tipo_identificacion_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_identificacion_pet", $datos["numero_identificacion_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":contacto_pet", $datos["contacto_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":correo_pet", $datos["correo_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento", $datos["departamento"], PDO::PARAM_STR);
        $stmt->bindParam(":municipio", $datos["municipio"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion_pqr", $datos["descripcion_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":medio_recep_pqr", $datos["medio_recep_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_apertura_buzon_suge", $datos["fecha_apertura_buzon_suge"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_radicacion_pqr", $datos["fecha_radicacion_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_pqr", $datos["tipo_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":ente_reporta_pqr", $datos["ente_reporta_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":motivo_pqr", $datos["motivo_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":trabajador_relacionado_pqr", $datos["trabajador_relacionado_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":servicio_area", $datos["servicio_area"], PDO::PARAM_STR);
        $stmt->bindParam(":clasificacion_atributo", $datos["clasificacion_atributo"], PDO::PARAM_STR);
        $stmt->bindParam(":gestor", $datos["gestor"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":tiempo_res_normativo", $datos["tiempo_res_normativo"], PDO::PARAM_STR);
        $stmt->bindParam(":estado_pqr", $datos["estado_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin_buzon", $datos["fecha_fin_buzon"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_pqr_recurrente", $datos["pla_ac_pqr_recurrente"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_accion_efectiva", $datos["pla_ac_accion_efectiva"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_pqr", $datos["fecha_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_max_resp_pqr", $datos["fecha_max_resp_pqr"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaBuzonPendientesPQRSF($user){

        $stmt = Connection::connectOnly()->prepare("SELECT pqr_actas.radicado_acta, pqr_pqrs.* FROM pqr_actas JOIN pqr_pqrs ON pqr_actas.id_acta = pqr_pqrs.id_acta WHERE estado_pqr = 'PRECREADA' AND usuario_buzon = :usuario_buzon");

        $stmt->bindParam(":usuario_buzon", $user, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoBuzonPQRSF($idPQR){

        $stmt = Connection::connectOnly()->prepare("SELECT pqr_actas.radicado_acta, pqr_actas.fecha_acta, pqr_actas.fecha_apertura_buzon, pqr_actas.ruta_archivos AS ruta_archivos_actas, pqr_pqrs.* FROM pqr_actas JOIN pqr_pqrs ON pqr_actas.id_acta = pqr_pqrs.id_acta WHERE pqr_pqrs.id_pqr = :id_pqr");

        $stmt->bindParam(":id_pqr", $idPQR, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlTomarBuzonPQRSF($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pqr_pqrs SET usuario_buzon = :usuario_buzon, fecha_ini_buzon = :fecha_ini_buzon WHERE id_pqr = :id_pqr");

        $stmt->bindParam(":usuario_buzon", $datos["usuario_buzon"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_ini_buzon", $datos["fecha_ini_buzon"], PDO::PARAM_STR);
        $stmt->bindParam(":id_pqr", $datos["id_pqr"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaBuzonPQRSF(){

        $stmt = Connection::connectOnly()->prepare("SELECT pqr_actas.radicado_acta, pqr_pqrs.* FROM pqr_actas JOIN pqr_pqrs ON pqr_actas.id_acta = pqr_pqrs.id_acta WHERE estado_pqr = 'PRECREADA' AND usuario_buzon IS NULL");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlPreCrearPQR($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO pqr_pqrs (id_acta, estado_pqr) VALUES (:id_acta, :estado_pqr)");

        $stmt->bindParam(":id_acta", $datos["id_acta"], PDO::PARAM_STR);
        $stmt->bindParam(":estado_pqr", $datos["estado_pqr"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearActa($datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO pqr_actas (radicado_acta, cantidad_pqr, ruta_archivos, fecha_acta, fecha_apertura_buzon, usuario_crea) VALUES (:radicado_acta, :cantidad_pqr, :ruta_archivos, :fecha_acta, :fecha_apertura_buzon, :usuario_crea)");

        $stmt->bindParam(":radicado_acta", $datos["radicado_acta"], PDO::PARAM_STR);
        $stmt->bindParam(":cantidad_pqr", $datos["cantidad_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivos", $datos["ruta_archivos"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_acta", $datos["fecha_acta"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_apertura_buzon", $datos["fecha_apertura_buzon"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlActualizarPQRSFArchivos($idPQR, $rutaArchivo){

        $stmt = Connection::connectOnly()->prepare("UPDATE pqr_pqrs SET ruta_archivos = :ruta_archivos WHERE id_pqr = :id_pqr");

        $stmt->bindParam(":id_pqr", $idPQR, PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivos", $rutaArchivo, PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlObtenerPQRSF($datos){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pqr_pqrs WHERE numero_identificacion_pac = :numero_identificacion_pac AND eps = :eps AND regimen = :regimen AND programa = :programa AND sede = :sede AND estado_pqr = 'CREADA' ORDER BY id_pqr DESC LIMIT 1");

        $stmt->bindParam(":numero_identificacion_pac", $datos["numero_identificacion_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":eps", $datos["eps"], PDO::PARAM_STR);
        $stmt->bindParam(":regimen", $datos["regimen"], PDO::PARAM_STR);
        $stmt->bindParam(":programa", $datos["programa"], PDO::PARAM_STR);
        $stmt->bindParam(":sede", $datos["sede"], PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlAsignarPQRS($datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE pqr_pqrs SET estado_pqr = 'GESTION', gestor = :gestor, fecha_ini_gestor = :fecha_ini_gestor WHERE id_pqr = :id_pqr");

        $stmt->bindParam(":id_pqr", $datos["id_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":gestor", $datos["gestor"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_ini_gestor", $datos["fecha_ini_gestor"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlRechazarPQRS($idPQR){

        $stmt = Connection::connectOnly()->prepare("UPDATE pqr_pqrs SET estado_pqr = 'RECHAZADA' WHERE id_pqr = :id_pqr");

        $stmt->bindParam(":id_pqr", $idPQR, PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaUsuariosPQRS(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM pqr_usuarios");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


    static public function mdlListaPQRS(){

        $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.*, usuarios.nombre, usuarios.usuario FROM pqr_pqrs JOIN usuarios ON pqr_pqrs.gestor = usuarios.usuario");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlTerminarRevisionPQRS($tabla, $datos){

        $stmt = Connection::connectBatch()->prepare("UPDATE $tabla SET pla_ac_que = :pla_ac_que, pla_ac_por_que = :pla_ac_por_que, pla_ac_cuando = :pla_ac_cuando, pla_ac_donde = :pla_ac_donde, pla_ac_como = :pla_ac_como, pla_ac_quien = :pla_ac_quien, pla_ac_recurso = :pla_ac_recurso, pla_ac_negacion_pqr = :pla_ac_negacion_pqr, pla_ac_motivo_negacion = :pla_ac_motivo_negacion, estado_pqr = :estado_pqr, observaciones_revision = :observaciones_revision, fecha_fin_revision = :fecha_fin_revision, pla_ac_respuesta = :pla_ac_respuesta, observaciones_gestor = :observaciones_gestor WHERE id_pqr = :id_pqr");

        $stmt->bindParam(":id_pqr", $datos["id_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_que", $datos["pla_ac_que"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_por_que", $datos["pla_ac_por_que"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_cuando", $datos["pla_ac_cuando"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_donde", $datos["pla_ac_donde"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_como", $datos["pla_ac_como"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_quien", $datos["pla_ac_quien"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_recurso", $datos["pla_ac_recurso"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_negacion_pqr", $datos["pla_ac_negacion_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_motivo_negacion", $datos["pla_ac_motivo_negacion"], PDO::PARAM_STR);
        // $stmt->bindParam(":pla_ac_pqr_recurrente", $datos["pla_ac_pqr_recurrente"], PDO::PARAM_STR);
        // $stmt->bindParam(":pla_ac_accion_efectiva", $datos["pla_ac_accion_efectiva"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_respuesta", $datos["pla_ac_respuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_revision", $datos["observaciones_revision"], PDO::PARAM_STR);
        $stmt->bindParam(":estado_pqr", $datos["estado_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin_revision", $datos["fecha_fin_revision"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_gestor", $datos["observaciones_gestor"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPendientesRevisionPQRS($usuario){

        $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.*, usuarios.nombre, usuarios.usuario FROM pqr_pqrs JOIN usuarios ON pqr_pqrs.usuario_revision = usuarios.usuario WHERE usuario_revision = :usuario_revision AND estado_pqr = 'REVISANDO'");

        $stmt->bindParam(":usuario_revision", $usuario);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlRevisarPQRS($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET usuario_revision = :usuario_revision, fecha_ini_revision = :fecha_ini_revision, estado_pqr = :estado_pqr WHERE id_pqr = :id_pqr");

        $stmt->bindParam(":usuario_revision", $datos["usuario_revision"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_ini_revision", $datos["fecha_ini_revision"], PDO::PARAM_STR);
        $stmt->bindParam(":estado_pqr", $datos["estado_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":id_pqr", $datos["id_pqr"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaRevisionesPQRS(){

        $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.*, usuarios.nombre, usuarios.usuario FROM pqr_pqrs JOIN usuarios ON pqr_pqrs.gestor = usuarios.usuario WHERE estado_pqr IN ('REVISION','RECHAZADA')");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearPlanAccionPQRS($tabla, $datos){

        $stmt = Connection::connectBatch()->prepare("UPDATE $tabla SET fecha_fin_gestor = :fecha_fin_gestor, pla_ac_que = :pla_ac_que, pla_ac_por_que = :pla_ac_por_que, pla_ac_cuando = :pla_ac_cuando, pla_ac_donde = :pla_ac_donde, pla_ac_como = :pla_ac_como, pla_ac_quien = :pla_ac_quien, pla_ac_recurso = :pla_ac_recurso, pla_ac_negacion_pqr = :pla_ac_negacion_pqr, pla_ac_motivo_negacion = :pla_ac_motivo_negacion, usuario_crea_pla_ac = :usuario_crea_pla_ac, fecha_crea_pla_ac = :fecha_crea_pla_ac, estado_pqr = :estado_pqr, pla_ac_respuesta = :pla_ac_respuesta, observaciones_gestor = :observaciones_gestor WHERE id_pqr = :id_pqr");

        $stmt->bindParam(":id_pqr", $datos["id_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin_gestor", $datos["fecha_crea_pla_ac"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_que", $datos["pla_ac_que"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_por_que", $datos["pla_ac_por_que"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_cuando", $datos["pla_ac_cuando"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_donde", $datos["pla_ac_donde"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_como", $datos["pla_ac_como"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_quien", $datos["pla_ac_quien"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_recurso", $datos["pla_ac_recurso"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_negacion_pqr", $datos["pla_ac_negacion_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_motivo_negacion", $datos["pla_ac_motivo_negacion"], PDO::PARAM_STR);
        // $stmt->bindParam(":pla_ac_pqr_recurrente", $datos["pla_ac_pqr_recurrente"], PDO::PARAM_STR);
        // $stmt->bindParam(":pla_ac_accion_efectiva", $datos["pla_ac_accion_efectiva"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_respuesta", $datos["pla_ac_respuesta"], PDO::PARAM_STR);
        $stmt->bindParam(":observaciones_gestor", $datos["observaciones_gestor"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea_pla_ac", $datos["usuario_crea_pla_ac"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_crea_pla_ac", $datos["fecha_crea_pla_ac"], PDO::PARAM_STR);
        $stmt->bindParam(":estado_pqr", $datos["estado_pqr"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaPendientesPQRS($tabla, $usuario){

        $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.*, usuarios.nombre, usuarios.usuario FROM $tabla JOIN usuarios ON pqr_pqrs.gestor = usuarios.usuario WHERE gestor = :gestor AND estado_pqr = 'GESTION'");

        $stmt->bindParam(":gestor", $usuario);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlGestionarPQRS($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET estado_pqr = :estado_pqr, fecha_ini_gestor = :fecha_ini_gestor WHERE id_pqr = :id_pqr");

        $stmt->bindParam(":estado_pqr", $datos["estado_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_ini_gestor", $datos["fecha_ini_gestor"], PDO::PARAM_STR);
        $stmt->bindParam(":id_pqr", $datos["id_pqr"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoPQR($tabla, $idPQR){

        $stmt = Connection::connectOnly()->prepare("SELECT pqr_pqrs.*, usuarios.nombre, usuarios.usuario, calcular_horas_habiles(pqr_pqrs.fecha_pqr, pqr_pqrs.fecha_respuesta_pqr) AS horas_habiles, pqr_par_tipos_pqr.tipo_pqr AS tipo_pqr_par, pqr_par_tipos_pqr.cantidad, pqr_par_tipos_pqr.tiempo FROM $tabla JOIN usuarios ON pqr_pqrs.gestor = usuarios.usuario JOIN pqr_par_tipos_pqr ON pqr_pqrs.tipo_pqr = pqr_pqrs.tipo_pqr WHERE id_pqr = :id_pqr GROUP BY pqr_pqrs.tipo_pqr");

        $stmt->bindParam(":id_pqr", $idPQR, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlListaAsignacionesPQRS($tabla, $usuario){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE gestor = :gestor AND estado_pqr = 'CREADA'");

        $stmt->bindParam(":gestor", $usuario, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCrearPQRS($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (nombre_pac, tipo_identificacion_pac, numero_identificacion_pac, fecha_nacimiento_pac, eps, regimen, programa, sede, nombre_pet, tipo_identificacion_pet, numero_identificacion_pet, contacto_pet, correo_pet, departamento, municipio, descripcion_pqr, medio_recep_pqr, fecha_apertura_buzon_suge, fecha_radicacion_pqr, tipo_pqr, ente_reporta_pqr, motivo_pqr, trabajador_relacionado_pqr, servicio_area, clasificacion_atributo, gestor, usuario_crea, tiempo_res_normativo, pla_ac_pqr_recurrente, pla_ac_accion_efectiva, fecha_pqr, fecha_max_resp_pqr) VALUES (:nombre_pac, :tipo_identificacion_pac, :numero_identificacion_pac, :fecha_nacimiento_pac, :eps, :regimen, :programa, :sede, :nombre_pet, :tipo_identificacion_pet, :numero_identificacion_pet, :contacto_pet, :correo_pet, :departamento, :municipio, :descripcion_pqr, :medio_recep_pqr, :fecha_apertura_buzon_suge, :fecha_radicacion_pqr, :tipo_pqr, :ente_reporta_pqr, :motivo_pqr, :trabajador_relacionado_pqr, :servicio_area, :clasificacion_atributo, :gestor, :usuario_crea, :tiempo_res_normativo, :pla_ac_pqr_recurrente, :pla_ac_accion_efectiva, :fecha_pqr, :fecha_max_resp_pqr)");

        $stmt->bindParam(":nombre_pac", $datos["nombre_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_identificacion_pac", $datos["tipo_identificacion_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_identificacion_pac", $datos["numero_identificacion_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento_pac", $datos["fecha_nacimiento_pac"], PDO::PARAM_STR);
        $stmt->bindParam(":eps", $datos["eps"], PDO::PARAM_STR);
        $stmt->bindParam(":regimen", $datos["regimen"], PDO::PARAM_STR);
        $stmt->bindParam(":programa", $datos["programa"], PDO::PARAM_STR);
        $stmt->bindParam(":sede", $datos["sede"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_pet", $datos["nombre_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_identificacion_pet", $datos["tipo_identificacion_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_identificacion_pet", $datos["numero_identificacion_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":contacto_pet", $datos["contacto_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":correo_pet", $datos["correo_pet"], PDO::PARAM_STR);
        $stmt->bindParam(":departamento", $datos["departamento"], PDO::PARAM_STR);
        $stmt->bindParam(":municipio", $datos["municipio"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion_pqr", $datos["descripcion_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":medio_recep_pqr", $datos["medio_recep_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_apertura_buzon_suge", $datos["fecha_apertura_buzon_suge"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_radicacion_pqr", $datos["fecha_radicacion_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_pqr", $datos["tipo_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":ente_reporta_pqr", $datos["ente_reporta_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":motivo_pqr", $datos["motivo_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":trabajador_relacionado_pqr", $datos["trabajador_relacionado_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":servicio_area", $datos["servicio_area"], PDO::PARAM_STR);
        $stmt->bindParam(":clasificacion_atributo", $datos["clasificacion_atributo"], PDO::PARAM_STR);
        $stmt->bindParam(":gestor", $datos["gestor"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":tiempo_res_normativo", $datos["tiempo_res_normativo"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_pqr_recurrente", $datos["pla_ac_pqr_recurrente"], PDO::PARAM_STR);
        $stmt->bindParam(":pla_ac_accion_efectiva", $datos["pla_ac_accion_efectiva"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_pqr", $datos["fecha_pqr"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_max_resp_pqr", $datos["fecha_max_resp_pqr"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlUsuariosPqrs($tabla, $tipo){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE tipo = :tipo");

        $stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
        
        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;


    }

    static public function mdlObtenerDato($tabla, $item, $valor){

        if($item != null){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();


        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();

        }

        $stmt = null;

    }

    static public function mdlObtenerDatosActivos($tabla, $item, $valor){

        if($item == null){
            
            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE estado = 1");

            $stmt->execute();

            return $stmt->fetchAll();

        }else{

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :valor AND estado = 1");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();	

        }

        $stmt = null;


    }

}
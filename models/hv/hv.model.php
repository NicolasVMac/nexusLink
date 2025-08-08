<?php

$rutaConnection = dirname(__DIR__) . "\connection.php";
require_once $rutaConnection;
date_default_timezone_set('America/Bogota');

class ModelHv{

    static public function mdlListaHV($tabla){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlCalculoExperienciaLaboral($idHV){

        $stmt = Connection::connectOnly()->prepare("SELECT SUM(tiempo_dias) AS dias, SUM(tiempo_meses) AS meses, SUM(tiempo_anios) AS anios FROM hv_experiencias_laborales WHERE id_hv = :id_hv");

        $stmt->bindParam(":id_hv", $idHV, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlConsultarHv($datos){

        if($datos["numero_doc"] != ""){

            $textNumDoc = "AND hv_datos_personales.numero_doc LIKE '%{$datos['numero_doc']}%'";

        }else{

            $textNumDoc = "";

        }

        if($datos["tipo_formacion"] != ""){

            $textTipoForm = "AND hv_estudios.tipo_formacion LIKE '%{$datos['tipo_formacion']}%'";

        }else{

            $textTipoForm = "";

        }

        if($datos["profesion"] != ""){

            $textProfesion = "AND hv_datos_personales.profesion LIKE '%{$datos['profesion']}%'";

        }else{

            $textProfesion = "";

        }

        if($datos["palabra_clave"] != ""){

            $textPalabraClave = "AND hv_datos_personales.nombre_completo LIKE '%{$datos['palabra_clave']}%' OR hv_datos_personales.profesion LIKE '%{$datos['palabra_clave']}%' 
                OR hv_experiencias_laborales.cargo_desempenado LIKE '%{$datos['palabra_clave']}%' OR hv_experiencias_laborales.empresa_contratante LIKE '%{$datos['palabra_clave']}%'
                OR hv_experiencias_laborales.sector LIKE '%{$datos['palabra_clave']}%' OR hv_experiencias_laborales.area_trabajo LIKE '%{$datos['palabra_clave']}%'
                OR hv_estudios.titulo_otorgado LIKE '%{$datos['palabra_clave']}%'";

        }else{

            $textPalabraClave = "";

        }


        $stmt = Connection::connectOnly()->prepare("SELECT hv_datos_personales.id_hv, hv_datos_personales.nombre_completo, hv_datos_personales.tipo_doc, hv_datos_personales.numero_doc, hv_datos_personales.correo_electronico, hv_datos_personales.celular, hv_datos_personales.profesion FROM hv_estudios RIGHT JOIN hv_datos_personales ON hv_estudios.id_hv = hv_datos_personales.id_hv LEFT JOIN hv_experiencias_laborales ON hv_datos_personales.id_hv = hv_experiencias_laborales.id_hv
            WHERE hv_datos_personales.id_hv IS NOT NULL $textNumDoc $textTipoForm $textProfesion $textPalabraClave
            GROUP BY hv_datos_personales.id_hv");

        if($stmt->execute()){

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlVerExperienciaLaboral($tabla, $idExpLaboral){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_exp_laboral = :id_exp_laboral");

        $stmt->bindParam(":id_exp_laboral", $idExpLaboral, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlVerEstudio($tabla, $idEstudio){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_estudio = :id_estudio");

        $stmt->bindParam(":id_estudio", $idEstudio, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarEstudio($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = :fecha_elimina WHERE id_estudio = :id_estudio");

        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_elimina", $datos["fecha_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":id_estudio", $datos["id_estudio"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlEliminarExperienciaLaboral($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET is_active = 0, usuario_elimina = :usuario_elimina, fecha_elimina = :fecha_elimina WHERE id_exp_laboral = :id_exp_laboral");

        $stmt->bindParam(":usuario_elimina", $datos["usuario_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_elimina", $datos["fecha_elimina"], PDO::PARAM_STR);
        $stmt->bindParam(":id_exp_laboral", $datos["id_exp_laboral"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


    static public function mdlEditarDatosPersonales($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("UPDATE $tabla SET nombre_completo = :nombre_completo, fecha_nacimiento = :fecha_nacimiento, nacionalidad = :nacionalidad, profesion = :profesion, correo_electronico = :correo_electronico, direccion = :direccion, celular = :celular, telefono = :telefono, ruta_archivos_datos = :ruta_archivos_datos WHERE id_hv = :id_hv");

        $stmt->bindParam(":id_hv", $datos["id_hv"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_completo", $datos["nombre_completo"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":nacionalidad", $datos["nacionalidad"], PDO::PARAM_STR);
        $stmt->bindParam(":profesion", $datos["profesion"], PDO::PARAM_STR);
        $stmt->bindParam(":correo_electronico", $datos["correo_electronico"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivos_datos", $datos["ruta_archivos_datos"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlInfoDatosPersonales($tabla, $idHV){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_hv = :id_hv");

        $stmt->bindParam(":id_hv", $idHV, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }
    
        $stmt = null;

    }

    static public function mdlListaEstudios($tabla, $idHV){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_hv = :id_hv AND is_active = 1");

        $stmt->bindParam(":id_hv", $idHV, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }
    
        $stmt = null;

    }

    static public function mdlListaExperienciasLaborales($tabla, $idHV){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_hv = :id_hv AND is_active = 1");

        $stmt->bindParam(":id_hv", $idHV, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }
    
        $stmt = null;

    }

    static public function mdlCrearExperienciaLaboral($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_hv, empresa_contratante, sector, cargo_desempenado, area_trabajo, valor_contrato_salario, fecha_inicio_labor, fecha_fin_labor, tipo_certificado, ruta_archivo, usuario_crea, tiempo_dias, tiempo_meses, tiempo_anios) VALUES (:id_hv, :empresa_contratante, :sector, :cargo_desempenado, :area_trabajo, :valor_contrato_salario, :fecha_inicio_labor, :fecha_fin_labor, :tipo_certificado, :ruta_archivo, :usuario_crea, :tiempo_dias, :tiempo_meses, :tiempo_anios)");

        $stmt->bindParam(":id_hv", $datos["id_hv"], PDO::PARAM_STR);
        $stmt->bindParam(":empresa_contratante", $datos["empresa_contratante"], PDO::PARAM_STR);
        $stmt->bindParam(":sector", $datos["sector"], PDO::PARAM_STR);
        $stmt->bindParam(":cargo_desempenado", $datos["cargo_desempenado"], PDO::PARAM_STR);
        $stmt->bindParam(":area_trabajo", $datos["area_trabajo"], PDO::PARAM_STR);
        $stmt->bindParam(":valor_contrato_salario", $datos["valor_contrato_salario"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_inicio_labor", $datos["fecha_inicio_labor"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin_labor", $datos["fecha_fin_labor"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_certificado", $datos["tipo_certificado"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);
        $stmt->bindParam(":tiempo_dias", $datos["tiempo_dias"], PDO::PARAM_STR);
        $stmt->bindParam(":tiempo_meses", $datos["tiempo_meses"], PDO::PARAM_STR);
        $stmt->bindParam(":tiempo_anios", $datos["tiempo_anios"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }
    
        $stmt = null;

    }

    static public function mdlCrearEstudio($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (id_hv, tipo_formacion, titulo_otorgado, institucion_educativa, fecha_grado, ruta_archivo, fecha_exp_tarjeta_pro, ruta_archivo_tarjeta_pro, fecha_terminacion_mate, usuario_crea) VALUES (:id_hv, :tipo_formacion, :titulo_otorgado, :institucion_educativa, :fecha_grado, :ruta_archivo, :fecha_exp_tarjeta_pro, :ruta_archivo_tarjeta_pro, :fecha_terminacion_mate, :usuario_crea)");

        $stmt->bindParam(":id_hv", $datos["id_hv"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_formacion", $datos["tipo_formacion"], PDO::PARAM_STR);
        $stmt->bindParam(":titulo_otorgado", $datos["titulo_otorgado"], PDO::PARAM_STR);
        $stmt->bindParam(":institucion_educativa", $datos["institucion_educativa"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_grado", $datos["fecha_grado"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo", $datos["ruta_archivo"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_exp_tarjeta_pro", $datos["fecha_exp_tarjeta_pro"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivo_tarjeta_pro", $datos["ruta_archivo_tarjeta_pro"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_terminacion_mate", $datos["fecha_terminacion_mate"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);

        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }
    
        $stmt = null;

    }

    static public function mdlCrearDatosPersonales($tabla, $datos){

        $stmt = Connection::connectOnly()->prepare("INSERT INTO $tabla (tipo_doc, numero_doc, nombre_completo, fecha_nacimiento, nacionalidad, profesion, correo_electronico, direccion, celular, telefono, ruta_archivos_datos, usuario_crea) VALUES (:tipo_doc, :numero_doc, :nombre_completo, :fecha_nacimiento, :nacionalidad, :profesion, :correo_electronico, :direccion, :celular, :telefono, :ruta_archivos_datos, :usuario_crea)");

        $stmt->bindParam(":tipo_doc", $datos["tipo_doc"], PDO::PARAM_STR);
        $stmt->bindParam(":numero_doc", $datos["numero_doc"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre_completo", $datos["nombre_completo"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":nacionalidad", $datos["nacionalidad"], PDO::PARAM_STR);
        $stmt->bindParam(":profesion", $datos["profesion"], PDO::PARAM_STR);
        $stmt->bindParam(":correo_electronico", $datos["correo_electronico"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":ruta_archivos_datos", $datos["ruta_archivos_datos"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_crea", $datos["usuario_crea"], PDO::PARAM_STR);


        if($stmt->execute()){

            return 'ok';

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlBuscarHvDocumento($tabla, $tipoDoc, $numDoc){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE tipo_doc = :tipo_doc AND numero_doc = :numero_doc");

        $stmt->bindParam(":tipo_doc", $tipoDoc, PDO::PARAM_STR);
        $stmt->bindParam(":numero_doc", $numDoc, PDO::PARAM_STR);

        if($stmt->execute()){

            return $stmt->fetch();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }


}
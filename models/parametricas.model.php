<?php

require_once "connection.php";
date_default_timezone_set('America/Bogota');

class ModelParametricas
{

    static public function mdlObtenerTiposActivosInventario($categoriaActivoFijo){

        if($categoriaActivoFijo == 'EQUIPO BIOMEDICO'){

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM inventario_par_tipos_equipos_biomedicos WHERE estado = 1");

            if($stmt->execute()){

                return $stmt->fetchAll();
    
            }else{
    
                return $stmt->errorInfo();
    
            }
    
            $stmt = null;

        }

    }


    static public function mdlListaAuditoresAudProfesional(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM usuarios JOIN usuarios_permisos ON usuarios.usuario = usuarios_permisos.usuario WHERE id_menu = 26 GROUP BY usuarios.usuario");

        if($stmt->execute()){

            return $stmt->fetchAll();

        }else{

            return $stmt->errorInfo();

        }

        $stmt = null;

    }

    static public function mdlObtenerEpsSedePqrsf($sede){

        $stmt = Connection::connectOnly()->prepare("SELECT eps, sede FROM pqr_par_eps JOIN pqr_eps_sedes ON pqr_par_eps.id_eps_pqr = pqr_eps_sedes.id_eps JOIN pqr_par_sedes ON pqr_eps_sedes.id_sede = pqr_par_sedes.id_par_sede WHERE pqr_par_sedes.sede = :sede");

        $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlObtenerListaResponsablesProyectosCorrespondencia()
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM usuarios JOIN usuarios_permisos ON usuarios.usuario = usuarios_permisos.usuario WHERE id_proyecto = 24 GROUP BY usuarios.usuario");

        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlObtenerSedesEpsPqrsf($eps)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT eps, sede FROM pqr_par_eps JOIN pqr_eps_sedes ON pqr_par_eps.id_eps_pqr = pqr_eps_sedes.id_eps JOIN pqr_par_sedes ON pqr_eps_sedes.id_sede = pqr_par_sedes.id_par_sede WHERE pqr_par_eps.eps = :eps");

        $stmt->bindParam(":eps", $eps, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlObtenerClasiAtributos()
    {

        $stmt = Connection::connectOnly()->prepare("SELECT clasificacion_atributo FROM pqr_par_motivos_pqr GROUP BY clasificacion_atributo");

        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlObtenerEpsSede($sede)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT pqr_par_sedes.sede, pqr_par_eps.eps, pqr_eps_sedes.* FROM pqr_par_eps JOIN pqr_eps_sedes ON pqr_par_eps.id_eps_pqr = pqr_eps_sedes.id_eps JOIN pqr_par_sedes ON pqr_eps_sedes.id_sede = pqr_par_sedes.id_par_sede
            WHERE pqr_par_sedes.sede = :sede");

        $stmt->bindParam(":sede", $sede, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return $stmt->fetchAll();
        } else {

            return $stmt->errorInfo();
        }

        $stmt = null;
    }

    static public function mdlVerDatoParametrica($parametrica, $dato)
    {

        switch ($parametrica) {

            case 'sexo':
                $stmt = Connection::connectOnly()->prepare("SELECT * FROM par_generos WHERE codigo = '$dato'");
                $stmt->execute();
                return $stmt->fetch();
                $stmt = null;
                break;

            case 'tipoDocumento':
                $stmt = Connection::connectOnly()->prepare("SELECT * FROM par_tipo_documentos WHERE tipo = '$dato'");
                $stmt->execute();
                return $stmt->fetch();
                $stmt = null;
                break;
        }
    }

    static public function mdlObtenerDatosActivosAll($tabla, $item, $valor)
    {

        if ($item == null) {

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE estado = 1");

            $stmt->execute();

            return $stmt->fetchAll();
        } else {

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :valor AND estado = 1");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchall();
        }

        $stmt = null;
    }

    static public function mdlObtenerDatosActivos($tabla, $item, $valor)
    {

        if ($item == null) {

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE estado = 1");

            $stmt->execute();

            return $stmt->fetchAll();
        } else {

            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE $item = :valor AND estado = 1");

            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        }

        $stmt = null;
    }

    static public function mdlObtenerDepartamentos($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT departamento FROM $tabla GROUP BY departamento");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }

    static public function mdlObtenerCiudadesDepartamento($tabla, $departamento)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT ciudad FROM $tabla WHERE departamento = '$departamento'");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }

    static public function mdlMostrarParametros($tipo, $variable)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM par_variables_globales WHERE tipo='$tipo' and variable='$variable' and estado='1';");

        $stmt->execute();

        return $stmt->fetch();

        $stmt = null;
    }

    static public function mdlListaGrupoEstandaresAutoevaluacion($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT grupo FROM $tabla GROUP BY grupo");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }

    static public function mdlListaSubGrupoEstandaresAutoevaluacion($tabla, $grupo)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT subgrupo FROM $tabla where grupo = :grupo GROUP BY subgrupo");
        $stmt->bindParam(":grupo", $grupo, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }

    static public function mdlListaEstandaresAutoevaluacion($tabla, $grupo, $subGrupo)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT codigo , CONCAT(codigo,'-',estandar) as codigo_descripcion FROM $tabla where subgrupo= :subGrupo  GROUP BY codigo");
        $stmt->bindParam(":subGrupo", $subGrupo, PDO::PARAM_STR);


        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }

    static public function mdlListaResolucionEstandaresAutoevaluacion($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT id_resolucion,resolucion FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }

    static public function mdlListaProcesoEstandaresAutoevaluacion($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT id_proceso,proceso FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }

    static public function mdlListaSedesPamec($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT id_sede,sede FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }

    static public function mdlListaProgramasPamec($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT id_programa,programa FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }

    static public function mdlListaEstandaresPamecPriorizacionAutoevaluacion($tabla, $grupo)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT codigo, CONCAT(codigo,'-',estandar) as codigo_descripcion FROM $tabla where grupo = :grupo GROUP BY codigo");
        $stmt->bindParam(":grupo", $grupo, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }
    static public function mdlListaVariablesPriorizacionAutoevaluacion($tabla,$tipoVariable)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla WHERE id_variable_priorizacion= :tipoVariable ORDER BY escala ASC");
        $stmt->bindParam(":tipoVariable", $tipoVariable, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }
    static public function mdlObtenerCriteriosEstandar($estandar) {
        $pdo = Connection::connectOnly();
        $stmt = $pdo->prepare("SELECT criterios FROM pamec_par_estandares WHERE codigo = :estandar");
        $stmt->bindParam(":estandar", $estandar, PDO::PARAM_STR);
        if($stmt->execute()){
             $criterios = $stmt->fetch(PDO::FETCH_COLUMN);
             return $criterios;
        } else {
             return "error";
        }
        $stmt = null;
    }

    static public function mdlListarPamecParEstandar($tabla,$select)
    {
        if($select==='subgrupo'){
            $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla GROUP BY subgrupo ");
        }else{
            $stmt = Connection::connectOnly()->prepare("SELECT *,CONCAT(codigo,'-',estandar) as codigo_descripcion FROM $tabla GROUP BY codigo");
        }

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }

    static public function mdlListaPeriodosConsultaAutoevaluacion($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla where is_active='1' and seleccionado='0' ");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }
    static public function mdlListaPeriodosPamecReporteAvance($tabla)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM $tabla where is_active='1' ;");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }
    
}

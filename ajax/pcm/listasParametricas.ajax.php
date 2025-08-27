<?php

require_once "../../models/connection.php";

class listasParametricas
{
    public $datos;

    public function listaPerfiles()
    {

        $stmt = Connection::connectOnly()->prepare("SELECT * from usuarios_perfiles where id_perfil not in ('1','8') and estado=1");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function listaPerfilesActivos($usuario)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT*FROM (
            SELECT usuarios_perfiles.id_perfil,usuarios_perfiles.perfil,usuarios_perfiles.descripcion,'Activo' as estado FROM usuarios_perfiles LEFT JOIN usuarios_permisos ON usuarios_perfiles.id_perfil=usuarios_permisos.id_perfil WHERE usuarios_perfiles.id_perfil not in ('1','8') AND estado=1 AND usuario='$usuario' UNION 
            SELECT usuarios_perfiles.id_perfil,usuarios_perfiles.perfil,usuarios_perfiles.descripcion,'Inactivo' as estado  FROM usuarios_perfiles LEFT JOIN usuarios_permisos ON usuarios_perfiles.id_perfil=usuarios_permisos.id_perfil WHERE usuarios_perfiles.id_perfil not in ('1','8') AND estado=1 AND (usuario !='$usuario' or usuario is null)) AS TABLA
            GROUP BY id_perfil");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    public function tipoDocumento()
    {
        $datos = $this->datos;

        if ($datos['tipo'] === 'J') {


            $stmt = Connection::connectOnly()->prepare("SELECT * from par_documento where tipo in ('J','A') AND estado='1' ORDER BY descripcion desc");
            $stmt->execute();
            $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        } else {
        }


        $data = array();
    }

    public function departamentos()
    {
        $stmt = Connection::connectOnly()->prepare("SELECT departamento from par_ubicacion where estado ='1' GROUP BY departamento");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function ciudades($departamento)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT ciudad from par_ubicacion where departamento='$departamento' AND estado ='1'");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function descPerfil($perfil)
    {

        $stmt = Connection::connectOnly()->prepare("SELECT usuarios_perfiles.perfil,usuarios_perfiles.descripcion,par_variables_globales.variable,par_variables_globales.valor FROM usuarios_perfiles INNER JOIN par_variables_globales ON usuarios_perfiles.perfil=par_variables_globales.tipo WHERE usuarios_perfiles.perfil='$perfil' AND usuarios_perfiles.estado='1' AND par_variables_globales.estado='1';");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($respuesta) <= 0) {
            $data[] = '';
        } else {
            foreach ($respuesta as $key => $value) {
                $data[] = $value;
            }
        }

        $resultado = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        echo json_encode($resultado);
    }
    public function glosasTipo()
    {
        $datos = $this->datos;

        $stmt = Connection::connectOnly()->prepare("SELECT * from par_glosa where estado='1' and Tipo_Glosa = '{$datos['tipoGlosa']}' and uso = '{$datos['uso']}' GROUP BY Tipo;");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function glosasDetalle()
    {
        $datos = $this->datos; 

        if($datos['valor']=='TODOS'){
            $stmt = Connection::connectOnly()->prepare("SELECT * from par_glosa where estado='1' and Tipo_Glosa = '{$datos['tipoGlosa']}' and uso = '{$datos['uso']}'");
        }else{
            $stmt = Connection::connectOnly()->prepare("SELECT * from par_glosa where estado='1' and Tipo_Glosa = '{$datos['tipoGlosa']}' and uso = '{$datos['uso']}' and Tipo = '{$datos['valor']}'");
        }
        
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function adversoTipo()
    {
        $stmt = Connection::connectOnly()->prepare("SELECT * from par_evento_adverso where estado='1'");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function adversoDetalle($adversoType)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT * FROM par_evento_adverso_detalle WHERE id_cod='$adversoType' AND estado_detalle='1';");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function devolucionTipo()
    {
        $stmt = Connection::connectOnly()->prepare("SELECT * FROM par_glosa_detalle WHERE id_cod='8' AND estado_detalle='1'");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    public function devolucionTipoEps()
    {
        $stmt = Connection::connectOnly()->prepare("SELECT * FROM par_devolucion_eps WHERE estado='1';");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    public function pendingProvider()
    {
        $stmt = Connection::connectOnly()->prepare("SELECT cuentas_facturas.id_prestador,par_prestador.nombre,par_prestador.nit_completo FROM cuentas_facturas INNER JOIN par_prestador ON cuentas_facturas.id_prestador=par_prestador.id_prestador WHERE cuentas_facturas.estado='AUDITORIA' GROUP BY par_prestador.nombre;");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function pendingProviderType($idProvider)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT cuentas_facturas.tipo_cuenta FROM cuentas_facturas INNER JOIN par_prestador ON cuentas_facturas.id_prestador=par_prestador.id_prestador WHERE cuentas_facturas.estado='AUDITORIA' and cuentas_facturas.id_prestador='$idProvider' GROUP BY cuentas_facturas.tipo_cuenta;");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function listProvider()
    {
        $stmt = Connection::connectOnly()->prepare("SELECT id_prestador, nombre, nit_completo FROM par_prestador WHERE estado='1' GROUP BY codigo_habilitacion ORDER BY nombre ASC;");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function listProfileReportProductivity()
    {
        $stmt = Connection::connectOnly()->prepare("SELECT * from usuarios_perfiles where descripcion like '%Auditor%'");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function listUsersProfile($perfil)
    {
        switch ($perfil) {
            case 'Todos':
                $stmt = Connection::connectOnly()->prepare("SELECT usuarios.id,usuarios.nombre,usuarios.usuario,usuarios_perfiles.id_perfil,usuarios_perfiles.perfil,usuarios_perfiles.descripcion FROM usuarios INNER JOIN usuarios_permisos ON usuarios.usuario=usuarios_permisos.usuario INNER JOIN usuarios_perfiles ON usuarios_permisos.id_perfil=usuarios_perfiles.id_perfil WHERE usuarios_perfiles.id_perfil NOT IN ('1','2','3') ORDER BY usuarios_perfiles.descripcion ASC,usuarios.nombre ASC");
                $stmt->execute();
                $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
            case 'AuditorMed':
                $stmt = Connection::connectOnly()->prepare("SELECT usuarios.id,usuarios.nombre,usuarios.usuario,usuarios_perfiles.id_perfil,usuarios_perfiles.perfil,usuarios_perfiles.descripcion FROM usuarios INNER JOIN usuarios_permisos ON usuarios.usuario=usuarios_permisos.usuario INNER JOIN usuarios_perfiles ON usuarios_permisos.id_perfil=usuarios_perfiles.id_perfil WHERE usuarios_perfiles.perfil = 'AuditorMed' ORDER BY usuarios_perfiles.descripcion ASC,usuarios.nombre ASC");
                $stmt->execute();
                $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
            case 'AuditorEnf':
                $stmt = Connection::connectOnly()->prepare("SELECT usuarios.id,usuarios.nombre,usuarios.usuario,usuarios_perfiles.id_perfil,usuarios_perfiles.perfil,usuarios_perfiles.descripcion FROM usuarios INNER JOIN usuarios_permisos ON usuarios.usuario=usuarios_permisos.usuario INNER JOIN usuarios_perfiles ON usuarios_permisos.id_perfil=usuarios_perfiles.id_perfil WHERE usuarios_perfiles.perfil = 'AuditorEnf' ORDER BY usuarios_perfiles.descripcion ASC,usuarios.nombre ASC");
                $stmt->execute();
                $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
            case 'AuditorAna':
                $stmt = Connection::connectOnly()->prepare("SELECT usuarios.id,usuarios.nombre,usuarios.usuario,usuarios_perfiles.id_perfil,usuarios_perfiles.perfil,usuarios_perfiles.descripcion FROM usuarios INNER JOIN usuarios_permisos ON usuarios.usuario=usuarios_permisos.usuario INNER JOIN usuarios_perfiles ON usuarios_permisos.id_perfil=usuarios_perfiles.id_perfil WHERE usuarios_perfiles.perfil = 'AuditorAna' ORDER BY usuarios_perfiles.descripcion ASC,usuarios.nombre ASC");
                $stmt->execute();
                $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
            case 'AuditorOdon':
                $stmt = Connection::connectOnly()->prepare("SELECT usuarios.id,usuarios.nombre,usuarios.usuario,usuarios_perfiles.id_perfil,usuarios_perfiles.perfil,usuarios_perfiles.descripcion FROM usuarios INNER JOIN usuarios_permisos ON usuarios.usuario=usuarios_permisos.usuario INNER JOIN usuarios_perfiles ON usuarios_permisos.id_perfil=usuarios_perfiles.id_perfil WHERE usuarios_perfiles.perfil = 'AuditorOdon'  ORDER BY usuarios_perfiles.descripcion ASC,usuarios.nombre ASC");
                $stmt->execute();
                $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
        }

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

    public function listUsersIdProfile($perfil)
    {
        $stmt = Connection::connectOnly()->prepare("SELECT usuarios.id,usuarios.nombre,usuarios.usuario,usuarios_perfiles.id_perfil,usuarios_perfiles.perfil,usuarios_perfiles.descripcion FROM usuarios INNER JOIN usuarios_permisos ON usuarios.usuario=usuarios_permisos.usuario INNER JOIN usuarios_perfiles ON usuarios_permisos.id_perfil=usuarios_perfiles.id_perfil WHERE usuarios_perfiles.perfil = '$perfil' ORDER BY usuarios_perfiles.descripcion ASC,usuarios.nombre ASC");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function ajaxListaAyudas(){

        $stmt = Connection::connectOnly()->prepare("SELECT * FROM par_ayudas");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($respuesta);

    }

    public function selectGlosasTipo(){

        $datos = $this->datos;

        $stmt = Connection::connectOnly()->prepare("SELECT * from par_glosa where estado='1' and Tipo_Glosa = '{$datos['tipoGlosa']}' GROUP BY Tipo;");
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cadena = '';

        $cadena .= '<option value="">Seleccione una opcion</option><option value="TODOS">TODOS</option>';
        
        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["Tipo"].'">'.$value["Tipo"].'</option>';

        }

        echo $cadena;


    }

    public function selectGlosasDetalle(){

        $datos = $this->datos;

        if($datos['valor']=='TODOS'){
            $stmt = Connection::connectOnly()->prepare("SELECT * from par_glosa where estado='1' and Tipo_Glosa = '{$datos['tipoGlosa']}' and uso = '{$datos['uso']}'");
        }else{
            $stmt = Connection::connectOnly()->prepare("SELECT * from par_glosa where estado='1' and Tipo_Glosa = '{$datos['tipoGlosa']}' and uso = '{$datos['uso']}' and Tipo = '{$datos['valor']}'");
        }
        
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cadena = '';

        $cadena .= '
            <div class="form-group">
                <label class="form-label" for="glosaDescription">Descripcion Glosa</label>
                <select name="glosaDescription" id="glosaDescription" class="form-control select-choice" required>
                <option value="">Seleccione una opcion</option>';
        
        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["Nota_Aclaratoria"].'" data-codigo="'.$value["Codigo_Glosa"].'">'.$value["Codigo_Glosa"].' - '.$value["Nota_Aclaratoria"].'</option>';

        }

        $cadena .= '</select></div>';

        echo $cadena;


    }

    public function selectGlosasDetalleRecla(){

        $datos = $this->datos;

        if($datos['valor']=='TODOS'){
            $stmt = Connection::connectOnly()->prepare("SELECT * from par_glosa where estado='1' and Tipo_Glosa = '{$datos['tipoGlosa']}' and uso = '{$datos['uso']}'");
        }else{
            $stmt = Connection::connectOnly()->prepare("SELECT * from par_glosa where estado='1' and Tipo_Glosa = '{$datos['tipoGlosa']}' and uso = '{$datos['uso']}' and Tipo = '{$datos['valor']}'");
        }
        
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cadena = '';

        $cadena .= '
            <div class="form-group">
                <label class="form-label" for="glosaDescriptionRecla">Descripcion Glosa</label>
                <select name="glosaDescriptionRecla" id="glosaDescriptionRecla" class="form-control select-choice">
                <option value="">Seleccione una opcion</option>';
        
        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["Nota_Aclaratoria"].'" data-codigo="'.$value["Codigo_Glosa"].'">'.$value["Codigo_Glosa"].' - '.$value["Nota_Aclaratoria"].'</option>';

        }

        $cadena .= '</select></div>';

        echo $cadena;

    }

    public function selectGlosasDetalleMasiva(){

        $datos = $this->datos;

        if($datos['valor']=='TODOS'){
            $stmt = Connection::connectOnly()->prepare("SELECT * from par_glosa where estado='1' and Tipo_Glosa = '{$datos['tipoGlosa']}' and uso = '{$datos['uso']}'");
        }else{
            $stmt = Connection::connectOnly()->prepare("SELECT * from par_glosa where estado='1' and Tipo_Glosa = '{$datos['tipoGlosa']}' and uso = '{$datos['uso']}' and Tipo = '{$datos['valor']}'");
        }
        
        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cadena = '';

        $cadena .= '
            <div class="form-group">
                <label class="form-label" for="glosaMasivaDescription">Descripcion Glosa</label>
                <select name="glosaMasivaDescription" id="glosaMasivaDescription" class="form-control select-choice">
                <option value="">Seleccione una opcion</option>';
        
        foreach ($respuesta as $key => $value) {

            $cadena .= '<option value="'.$value["Nota_Aclaratoria"].'" data-codigo="'.$value["Codigo_Glosa"].'">'.$value["Codigo_Glosa"].' - '.$value["Nota_Aclaratoria"].'</option>';

        }

        $cadena .= '</select></div>';

        echo $cadena;

    }

}

if(isset($_POST["listaAyudas"])){

    $listaAyudas = new listasParametricas();
    $listaAyudas->ajaxListaAyudas();
}


if (isset($_POST['lista'])) {
    $lista = $_POST['lista'];

    switch ($lista) {

        case 'selectGlosasDetalleMasiva':
            $selectGlosasDetalleMasiva = new listasParametricas();
            $selectGlosasDetalleMasiva->datos = array(
                "tipoGlosa" => $_POST["tipoGlosa"],
                "uso" => $_POST["uso"],
                "valor" => $_POST["valor"]
            );
            $selectGlosasDetalleMasiva->selectGlosasDetalleMasiva();
            break;

        case 'selectGlosasDetalleRecla':
            $selectGlosasDetalleRecla = new listasParametricas();
            $selectGlosasDetalleRecla->datos = array(
                "tipoGlosa" => $_POST["tipoGlosa"],
                "uso" => $_POST["uso"],
                "valor" => $_POST["valor"]
            );
            $selectGlosasDetalleRecla->selectGlosasDetalleRecla();
            break;

        case 'selectGlosasDetalle':
            $selectGlosasDetalle = new listasParametricas();
            $selectGlosasDetalle->datos = array(
                "tipoGlosa" => $_POST["tipoGlosa"],
                "uso" => $_POST["uso"],
                "valor" => $_POST["valor"]
            );
            $selectGlosasDetalle->selectGlosasDetalle();
            break;

        case 'selectGlosasTipo':
            $selectGlosasTipo = new listasParametricas();
            $selectGlosasTipo->datos = array(
                "tipoGlosa" => $_POST["tipoGlosa"],
                "uso" => $_POST["uso"]
            );
            $selectGlosasTipo->selectGlosasTipo();
            break;
        case 'Perfiles':
            $usuarios = new listasParametricas();
            $usuarios->listaPerfiles();
            break;
        case 'PerfilesActivos':
            $usuarios = new listasParametricas();
            $usuarios->listaPerfilesActivos($_POST['user']);
            break;
        case 'TipoDocumento':
            $usuarios = new listasParametricas();
            $usuarios->datos = array(
                "tipo" => $_POST["tipo"]
            );
            $usuarios->tipoDocumento();
            break;
        case 'Departamento':
            $usuarios = new listasParametricas();
            $usuarios->departamentos();
            break;
        case 'Ciudad':
            $usuarios = new listasParametricas();
            $usuarios->ciudades($_POST["valor"]);
            break;
        case 'descPerfil':
            $usuarios = new listasParametricas();
            $usuarios->descPerfil($_POST["valor"]);
            break;
        case 'glosasTipo':
            $usuarios = new listasParametricas();
            $usuarios->datos = array(
                "tipoGlosa" => $_POST["tipoGlosa"],
                "uso" => $_POST["uso"]

            );
            $usuarios->glosasTipo();
            break;
        case 'glosasDetalle':
            $usuarios = new listasParametricas();
            $usuarios->datos = array(
                "tipoGlosa" => $_POST["tipoGlosa"],
                "uso" => $_POST["uso"],
                "valor" => $_POST["valor"]
            );
            $usuarios->glosasDetalle();
            break;
        case 'AdversoEventoTipo':
            $usuarios = new listasParametricas();
            $usuarios->adversoTipo();
            break;
        case 'adversoDetalle':
            $usuarios = new listasParametricas();
            $usuarios->adversoDetalle($_POST["valor"]);
            break;
        case 'DevolutionTipo':
            $usuarios = new listasParametricas();
            $usuarios->devolucionTipo();
            break;
        case 'DevolutionTipoEps':
            $usuarios = new listasParametricas();
            $usuarios->devolucionTipoEps();
            break;
        case 'pendingProvider':
            $usuarios = new listasParametricas();
            $usuarios->pendingProvider();
            break;
        case 'pendingProviderType':
            $usuarios = new listasParametricas();
            $usuarios->pendingProviderType($_POST["valor"]);
            break;
        case 'listProvider':
            $usuarios = new listasParametricas();
            $usuarios->listProvider();
            break;
        case 'listProfileReportProductivity':
            $usuarios = new listasParametricas();
            $usuarios->listProfileReportProductivity();
            break;
        case 'listUsersProfile':
            $usuarios = new listasParametricas();
            $usuarios->listUsersProfile($_POST["valor"]);
            break;
        case 'listUsersIdProfile':
            $usuarios = new listasParametricas();
            $usuarios->listUsersIdProfile($_POST["valor"]);
            break;
    }
}

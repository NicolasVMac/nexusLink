<?php

/*===================================
CONTROLADORES
=====================================*/
require_once "../../../../../controllers/pcm/auditoria.controlador.php";

/*===================================
MODELOS
=====================================*/
require_once "../../../../../models/pcm/auditoria.modelo.php";


class GenerarFuripsPDF{

public $numRecla;

public function furipsPDF(){

/*==========================
COLORES
==========================*/
$colorHeader = "#78ceff";
$colorBloque = "#d9d8d8";


/*===================================
CONSULTAS Y LOGICA PHP
=====================================*/

//TRAER INFORMACION RECLAMACION
$itemReclmacion = "Reclamacion_ID";
$valorReclamacion = $this->numRecla;

$infoReclamacion = ControladorAuditoria::ctrObtenerDatos("reclamaciones_encabezado", $itemReclmacion, $valorReclamacion);

//INFO DEPARTAMENTO
$itemDep = "CODIGO_DANE";
$valorDep = $infoReclamacion["Codigo_Dep_Victima"]."".$infoReclamacion["Codigo_Muni_Victima"];

$infoDep = ControladorAuditoria::ctrObtenerDatos("par_ciudad", $itemDep, $valorDep);

if(empty($infoDep) || !is_array($infoDep)) {
    $infoDep = array();  // Inicializa $infoDep como un array vacío si está vacío o no es un array
    $infoDep["DEPARTAMENTO"] = "";
    $infoDep["CIUDAD"] = "";
}

$infoDepEvento = ControladorAuditoria::ctrObtenerDatos("par_ciudad", $itemDep, $infoReclamacion["Codigo_Dep_Evento"].$infoReclamacion["Codigo_Mun_Evento"]);

if(empty($infoDepEvento) || !is_array($infoDepEvento)) {
    $infoDepEvento = array();  // Inicializa $infoDep como un array vacío si está vacío o no es un array
    $infoDepEvento["DEPARTAMENTO"] = "";
    $infoDepEvento["CIUDAD"] = "";
}

$infoDepPropietario = ControladorAuditoria::ctrObtenerDatos("par_ciudad", $itemDep, $infoReclamacion["Codigo_Dep_Propietario"].$infoReclamacion["Codigo_Mun_Propietario"]);

if(empty($infoDepPropietario) || !is_array($infoDepPropietario)) {
    $infoDepPropietario = array();  // Inicializa $infoDep como un array vacío si está vacío o no es un array
    $infoDepPropietario["DEPARTAMENTO"] = "";
    $infoDepPropietario["CIUDAD"] = "";
}

$infoDepConductor = ControladorAuditoria::ctrObtenerDatos("par_ciudad", $itemDep, $infoReclamacion["Codigo_Dep_Conductor"].$infoReclamacion["Codigo_Mun_Conductor"]);

if(empty($infoDepConductor) || !is_array($infoDepConductor)) {
    $infoDepConductor = array();  // Inicializa $infoDep como un array vacío si está vacío o no es un array
    $infoDepConductor["DEPARTAMENTO"] = "";
    $infoDepConductor["CIUDAD"] = "";
}


$Total_Facturado_Amparo_Gastos_Medicos_Quirurgicos = number_format($infoReclamacion["Total_Facturado_Amparo_Gastos_Medicos_Quirurgicos"] ?? 0, 2);
$Total_Reclamado_Amparo_Gastos_Medicos_Quirurgicos = number_format($infoReclamacion["Total_Reclamado_Amparo_Gastos_Medicos_Quirurgicos"] ?? 0, 2);
$Total_Facturado_Amparo_Gastos_Transporte_Movilizacion_Victima = number_format($infoReclamacion["Total_Facturado_Amparo_Gastos_Transporte_Movilizacion_Victima"] ?? 0, 2);
$Total_Reclamado_Amparo_Gastos_Transporte_Movilización_Victima = number_format($infoReclamacion["Total_Reclamado_Amparo_Gastos_Transporte_Movilización_Victima"] ?? 0, 2);

//ARRAY CONDICION VICTIMA
$arrayCondicionVictima = array(
    "1" => "CONDUCTOR",
    "2" => "PEATON",
    "3" => "OCUPANTE",
    "4" => "CICLISTA"
);

$arrayNaturalezaEvento = array(
    "ACCIDENTE DE TRANSITO" => array(
        "01" => "ACCIDENTE DE TRANSITO"
    ),
    "NATURALES" => array(
        "02" => "SISMO",
        "03" => "MAREMOTO",
        "04" => "ERUPCION VOLCANICA",
        "16" => "HURACAN",
        "06" => "INUNDACION",
        "07" => "AVALANCHA",
        "05" => "DESLIZAMIENTO",
        "08" => "INCENDIO",
        "25" => "RAYO",
        "26" => "VENDAVAL",
        "27" => "TORNADO",
    ),
    "TERRORISTA" => array(
        "09" => "EXPLOSION",
        "13" => "MASACRE",
        "15" => "MINA ANTIPERSONA",
        "11" => "COMBATE",
        "10" => "INCENDIO",
        "12" => "ATAQUE A MUNICIPIO",
        "14" => "DESPLAZADOS",
        "17" => "OTRO",
        "" => "CUAL",
    )
);

$arrayEstadoAseguramiento = array(
    "1" => "ASEGURADO",
    "2" => "NO ASEGURADO",
    "3" => "VEHICULO FANTASMA",
    "4" => "POLIZA FALSA",
    "5" => "VEHICULO EN FUGA",
    "6" => "ASEGURADO D.2497",
    "7" => "NO ASEGURADO - PROPIETARIO INDETERMINADO",
    "8" => "NO ASEGURADO - SIN PLACA",
    "" => "",
    " " => "",
);

$arrayTipoVehiculo = array(
    "1" => "AUTOMOVIL",
    "2" => "BUS",
    "3" => "BUSETA",
    "4" => "CAMION",
    "5" => "CAMIONETA",
    "6" => "CAMPERO",
    "7" => "MICROBUS",
    "8" => "TRACTOCAMION",
    "10" => "MOTOCICLETA",
    "14" => "MOTOCARRO",
    "17" => "MOTOTRICICLO",
    "19" => "CUATRIMOTO",
    "20" => "MOTO EXTRANJERA",
    "21" => "VEHICULO EXTRANJERO",
    "22" => "VOLQUETA",
    "" => "",
    " " => "",
);

$arrayCobroAgotamientoTopeAsegu = array(
    "0" => "SI",
    "1" => "NO",
    "" => "",
    " " => ""
);

$arrayComplejidadProcQx = array(
    "1" => "ALTA",
    "2" => "MEDIA",
    "3" => "BAJA",
    "" => "",
    " " => "",
);

$arrayPrestoSerUCI = array(
    "0" => "NO",
    "1" => "SI",
    "" => "",
    " " => ""
);

$arrayTipoReferencia = array(
    "0" => "",
    "1" => "REMITE PACIENTE",
    "2" => "ORDEN DE SERVICIO",
    "3" => "RECIBE PACIENTE",
    "" => "",
    " " => "",
);

$arrayManifesServPres = array(
    "0" => "NO",
    "1" => "SI",
    "" => ""
);

/*===================================
SINTAXIS PDF
=====================================*/
require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setTitle('PDF FURIPS');

$pdf->startPageGroup();

$pdf->AddPage();

//$pdf->Image('../../vistas/img/plantilla/Logo_AGS.jpg', 20, 12, 20, '', '', '', '', false, 100);

date_default_timezone_set('America/Bogota');


$bloque1 = <<<EOF
    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:140px; text-align:center;"><img src="images/col.jpg" alt="" width="80" height="50"></td>
                <td style="border: 1px solid #666; width:400px; text-align:center;"><br><b>REPUBLICA DE COLOMBIA MINISTERIO DE LA PROTECCIÓN SOCIAL FORMULARIO ÚNICO DE RECLAMACIÓN DE LAS INSTITUCIONES PRESTADORAS DE SERVICIOS DE SALUD POR SERVICIOS PRESTADOS A VICTIMAS DE EVENTOS CATASTRÓFICOS Y ACCIDENTES DE TRANSITO. PERSONAS JURIDICAS-FURIPS</b></td>
            </tr>
        </thead>
    </table>
    <br><br>
EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$bloque2 = <<<EOF
    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">I. DATOS DE LA RECLAMACION</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px"><b>FECHA RADICACION:</b><br/>$infoReclamacion[Fecha_Radicacion_Consolidado]</td>
                <td style="border: 1px solid #666; width:180px"><b>RGO:</b><br/></td>
                <td style="border: 1px solid #666; width:180px"><b>No RADICADO:</b><br/>$infoReclamacion[Numero_Radicacion]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>No RADICADO ANTERIOR:</b><br/>$infoReclamacion[Radicado_Anterior]</td>
                <td style="border: 1px solid #666; width:270px"><b>NUMERO FACTURA:</b><br/>$infoReclamacion[Numero_Factura]</td>
            </tr>
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

$bloque3 = <<<EOF
    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">II. DATOS DE LA INSTITUION PRESTADORA DE SERVICIO DE SALUD</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>RAZON SOCIAL:</b><br/>$infoReclamacion[Razon_Social_Reclamante]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>CODIGO HABILITACION:</b><br/>$infoReclamacion[Codigo_Habilitacion]</td>
                <td style="border: 1px solid #666; width:270px"><b>NIT:</b><br/>$infoReclamacion[Numero_Doc_Reclamante]</td>
            </tr>
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

$bloque4 = <<<EOF
    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">III. DATOS DE LA VICTIMA DEL EVENTO CATASTROFICO O ACCIDENTE DE TRANSITO</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>PRIMER APELLIDO:</b><br/>$infoReclamacion[Primer_Apellido_Victima]</td>
                <td style="border: 1px solid #666; width:270px"><b>SEGUNDO APELLIDO:</b><br/>$infoReclamacion[Segundo_Apellido_Victima]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>PRIMER NOMBRE:</b><br/>$infoReclamacion[Primer_Nombre_Victima]</td>
                <td style="border: 1px solid #666; width:270px"><b>SEGUNDO NOMBRE:</b><br/>$infoReclamacion[Segundo_Nombre_Victima]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>TIPO DOCUMENTO:</b><br/>$infoReclamacion[Tipo_Doc_Victima]</td>
                <td style="border: 1px solid #666; width:270px"><b>NO. DOCUMENTO:</b><br/>$infoReclamacion[Numero_Doc_Victima]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>FECHA NACIMIENTO:</b><br/>$infoReclamacion[Fecha_Nac_Victima]</td>
                <td style="border: 1px solid #666; width:270px"><b>FECHA FALLECIMIENTO VICTIMA:</b><br/>$infoReclamacion[Fecha_Fallecimiento_Victima]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>DIRECCION RESIDENCIAL:</b><br/>$infoReclamacion[Direccion_Victima]</td>
                <td style="border: 1px solid #666; width:135px"><b>TELEFONO:</b><br/>$infoReclamacion[Tel_victima]</td>
                <td style="border: 1px solid #666; width:135px"><b>SEXO:</b><br/>$infoReclamacion[Sexo_victima]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>DEPARTAMENTO:</b><br/>$infoDep[DEPARTAMENTO]</td>
                <td style="border: 1px solid #666; width:270px"><b>CODIGO:</b><br/>$infoReclamacion[Codigo_Dep_Victima]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>MUNICIPIO:</b><br/>$infoDep[CIUDAD]</td>
                <td style="border: 1px solid #666; width:270px"><b>CODIGO:</b><br/>$infoReclamacion[Codigo_Muni_Victima]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>CONDICION DEL ACCIDENTADO:</b></td>
            </tr>
            <tr>
EOF;


foreach ($arrayCondicionVictima as $key => $valueVictima) {

    if($key == $infoReclamacion["Condicion_Victima"]){

        $bloque4 .= <<<EOF
            <td style="border: 1px solid #666; width:135px"><b>{$valueVictima}:</b>  X</td>
        EOF;

    }else{

        $bloque4 .= <<<EOF
            <td style="border: 1px solid #666; width:135px"><b>{$valueVictima}:</b></td>
        EOF;

    }


}

$bloque4 .= <<<EOF
            </tr>
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

$bloque5 = <<<EOF
    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">IV. DATOS DEL SITIO DONDE OCURRIO EL EVENTO CATASTROFICO O EL ACCIDENTE DE TRANSITO</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>NATURALEZA DEL EVENTO:</b></td>
            </tr>
            <tr>
EOF;

if($infoReclamacion["Naturaleza_Evento"] == "01"){
    
    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:540px"><b>ACCIDENTE DE TRANSITO:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:540px"><b>ACCIDENTE DE TRANSITO:</b></td>
    EOF;

}

            
$bloque5 .= <<<EOF
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>NATURALES:</b></td>
            </tr>
            <tr>
EOF;

if($infoReclamacion["Naturaleza_Evento"] == "02"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>SISMO:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>SISMO:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "03"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>MAREMOTO:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>MAREMOTO:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "04"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>ERUPCION VOLCANICA:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>ERUPCION VOLCANICA:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "16"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>HURACAN:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>HURACAN:</b></td>
    EOF;

}

$bloque5 .= <<<EOF
            </tr>
            <tr>
EOF;

if($infoReclamacion["Naturaleza_Evento"] == "06"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>INUNDACION:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>INUNDACION:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "07"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>AVALANCHA:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>AVALANCHA:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "05"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>DESLIZAMIENTO:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>DESLIZAMIENTO:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "08"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>INCENDIO:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>INCENDIO:</b></td>
    EOF;

}


$bloque5 .= <<<EOF
            </tr>
            <tr>
EOF;

if($infoReclamacion["Naturaleza_Evento"] == "25"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>RAYO:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>RAYO:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "26"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>VENDAVAL:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>VENDAVAL:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "27"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>TORNADO:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>TORNADO:</b></td>
    EOF;

}
            
            
$bloque5 .= <<<EOF
            <td style="border: 1px solid #666; width:135px"></td>
            </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px"><b>TERRORISTA:</b></td>
        </tr>
        <tr>
EOF;

if($infoReclamacion["Naturaleza_Evento"] == "09"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>EXPLOSION:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>EXPLOSION:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "13"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>MASACRE:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>MASACRE:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "15"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>MINA ANTIPERSONA:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>MINA ANTIPERSONA:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "11"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>COMBATE:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>COMBATE:</b></td>
    EOF;

}

        
$bloque5 .= <<<EOF
            </tr>
            <tr>
EOF;

if($infoReclamacion["Naturaleza_Evento"] == "10"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>INCENDIO:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>INCENDIO:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "12"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>ATAQUE A MUNICIPIO:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>ATAQUE A MUNICIPIO:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "14"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>DESPLAZADOS:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>DESPLAZADOS:</b></td>
    EOF;

}
if($infoReclamacion["Naturaleza_Evento"] == "17"){

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>OTRO:</b>  X</td>
    EOF;

}else{

    $bloque5 .= <<<EOF
        <td style="border: 1px solid #666; width:135px"><b>OTRO:</b></td>
    EOF;

}


            
$bloque5 .= <<<EOF
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>DIRECCION OCURRENCIA:</b><br/>$infoReclamacion[Direccion_Evento]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>FECHA EVENTO/ ACCIDENTE:</b><br/>$infoReclamacion[Fecha_Hora_Evento]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>DEPARTAMENTO:</b><br/>$infoDepEvento[DEPARTAMENTO]</td>
                <td style="border: 1px solid #666; width:270px"><b>CODIGO:</b><br/>$infoReclamacion[Codigo_Dep_Evento]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>MUNICIPIO:</b><br/>$infoDepEvento[CIUDAD]</td>
                <td style="border: 1px solid #666; width:135px"><b>CODIGO:</b><br/>$infoReclamacion[Codigo_Mun_Evento]</td>
                <td style="border: 1px solid #666; width:135px"><b>ZONA:</b><br/>$infoReclamacion[Zona_Evento]</td>
            </tr>
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

$bloque6 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">V. DATOS DEL VEHICULO DEL ACCIDENTE DE TRANSITO</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>ESTADO DE ASEGURAMIENTO:</b><br/>$infoReclamacion[Estado_Aseguramiento] - {$arrayEstadoAseguramiento[$infoReclamacion['Estado_Aseguramiento']]}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>MARCA:</b><br/>$infoReclamacion[Marca]</td>
                <td style="border: 1px solid #666; width:270px"><b>PLACA:</b><br/>$infoReclamacion[Placa]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>TIPO VEHICULO:</b><br/>$infoReclamacion[Tipo_Vehiculo] - {$arrayTipoVehiculo[$infoReclamacion['Tipo_Vehiculo']]}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>CODIGO ASEGURADORA:</b><br/>$infoReclamacion[Codigo_Aseguradora]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px"><b>No DE LA POLIZA SOAT:</b><br/>$infoReclamacion[Poliza_Soat]</td>
                <td style="border: 1px solid #666; width:180px"><b>FECHA INICIO POLIZA:</b><br/>$infoReclamacion[Inicio_Poliza]</td>
                <td style="border: 1px solid #666; width:180px"><b>FECHA FIN POLIZA:</b><br/>$infoReclamacion[Fin_Poliza]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>NUMERO DE RADICADO SIRAS:</b><br/>$infoReclamacion[Numero_Radicacion_Siras]</td>
                <td style="border: 1px solid #666; width:270px"><b>COBRO POR AGOTAMIENTO TOPE ASEGURADORA:</b><br/>{$arrayCobroAgotamientoTopeAsegu[$infoReclamacion['Cobro_agotamiento_tope_Aseguradora']]}</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

$bloque7 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">VI. DATOS RELACIONADOS CON LA ATENCION DE LA VICTIMA</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>CODIGO CUPS PRINCIPAL DE HOSPITALIZACION:</b><br/>$infoReclamacion[Codigo_Cups_Hospitalizacion]</td>
                <td style="border: 1px solid #666; width:270px"><b>COMPLEJIDAD DEL PROCEDIMIENTO QUIRURGICO:</b><br/>{$arrayComplejidadProcQx[$infoReclamacion['Codigo_Tipo_complejidad']]}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px"><b>CODIGO CUPS PROCEDIMIENTO QUIRURGICO PRINCIPAL:</b><br/>$infoReclamacion[Codigo_Cups_Procedimiento_Principal]</td>
                <td style="border: 1px solid #666; width:180px"><b>CODIGO CUPS PROCEDIMIENTO QUIRURGICO SECUNDARIO:</b><br/>$infoReclamacion[Codigo_Cups_Procedimiento_Secundario]</td>
                <td style="border: 1px solid #666; width:180px"><b>SE PRESTO SERVICIO UCI:</b><br/>{$arrayPrestoSerUCI[$infoReclamacion['UCI']]}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>DIAS UCI RECLAMADOS:</b><br/>$infoReclamacion[Dia_Uci]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');

$bloque8 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">VII. DATOS DEL PROPIETARIO DEL VEHICULO</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>PRIMER APELLIDO:</b><br/>$infoReclamacion[Primer_Apellido_Propietario]</td>
                <td style="border: 1px solid #666; width:270px"><b>SEGUNDO APELLIDO:</b><br/>$infoReclamacion[Segundo_Apellido_Propietario]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>PRIMER NOMBRE:</b><br/>$infoReclamacion[Primer_Nombre_Propietario]</td>
                <td style="border: 1px solid #666; width:270px"><b>SEGUNDO NOMBRE:</b><br/>$infoReclamacion[Segundo_Nombre_Propietario]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>TIPO DOCUMENTO:</b><br/>$infoReclamacion[Tipo_Doc_Propietario]</td>
                <td style="border: 1px solid #666; width:270px"><b>NO. DOCUMENTO:</b><br/>$infoReclamacion[Num_Doc_Propietario]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>RAZON SOCIAL:</b><br/>$infoReclamacion[Razon_Social_Propietario]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>DIRECCION RESIDENCIAL:</b><br/>$infoReclamacion[Dir_Propietario]</td>
                <td style="border: 1px solid #666; width:270px"><b>TELEFONO:</b><br/>$infoReclamacion[Tel_Propietario]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>DEPARTAMENTO:</b><br/>$infoDepPropietario[DEPARTAMENTO]</td>
                <td style="border: 1px solid #666; width:270px"><b>CODIGO:</b><br/>$infoReclamacion[Codigo_Dep_Propietario]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>MUNICIPIO:</b><br/>$infoDepPropietario[CIUDAD]</td>
                <td style="border: 1px solid #666; width:270px"><b>CODIGO:</b><br/>$infoReclamacion[Codigo_Mun_Propietario]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque8, false, false, false, false, '');

$bloque9 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">VIII. DATOS DEL CONDUCTOR DEL VEHICULO INVOLUCRADO EN ACCIDENTE DE TRANSITO</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>PRIMER APELLIDO:</b><br/>$infoReclamacion[Primer_Apellido_Conductor]</td>
                <td style="border: 1px solid #666; width:270px"><b>SEGUNDO APELLIDO:</b><br/>$infoReclamacion[Segundo_Apellido_Conductor]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>PRIMER NOMBRE:</b><br/>$infoReclamacion[Primer_Nombre_Conductor]</td>
                <td style="border: 1px solid #666; width:270px"><b>SEGUNDO NOMBRE:</b><br/>$infoReclamacion[Segundo_Nombre_Conductor]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>TIPO DOCUMENTO:</b><br/>$infoReclamacion[Tipo_Doc_Conductor]</td>
                <td style="border: 1px solid #666; width:270px"><b>NO. DOCUMENTO:</b><br/>$infoReclamacion[Num_Doc_Conductor]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>DIRECCION RESIDENCIAL:</b><br/>$infoReclamacion[Dir_Conductor]</td>
                <td style="border: 1px solid #666; width:270px"><b>TELEFONO:</b><br/>$infoReclamacion[Tel_Conductor]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>DEPARTAMENTO:</b><br/>$infoDepConductor[DEPARTAMENTO]</td>
                <td style="border: 1px solid #666; width:270px"><b>CODIGO:</b><br/>$infoReclamacion[Codigo_Dep_Conductor]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>MUNICIPIO:</b><br/>$infoDepConductor[CIUDAD]</td>
                <td style="border: 1px solid #666; width:270px"><b>CODIGO:</b><br/>$infoReclamacion[Codigo_Mun_Conductor]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque9, false, false, false, false, '');

$bloque10 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">IX. DATOS DE REMISION</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>TIPO REFERENCIA:</b><br/>{$arrayTipoReferencia[$infoReclamacion['Tipo_Referencia_Remision']]}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>FECHA REMISION:</b><br/>$infoReclamacion[Fecha_Hora_Remision]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>PRESTADOR QUE REMITE:</b><br/></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>CODIGO DE INSCRIPCION:</b><br/>$infoReclamacion[Codigo_IPS_Remite]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>PROFESIONAL QUE REMITE:</b><br/>$infoReclamacion[Profesional_Remite]</td>
                <td style="border: 1px solid #666; width:270px"><b>CARGO:</b><br/>$infoReclamacion[Cargo_Remite]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>FECHA ACEPTACION:</b><br/>$infoReclamacion[Fecha_Hora_Ingreso]</td>
            </tr>
            <tr>
EOF;

if($infoReclamacion["Codigo_IPS_Recibe"] == $infoReclamacion["Codigo_Habilitacion"]){
    $bloque10 .= <<<EOF
        <td style="border: 1px solid #666; width:540px"><b>PRESTADOR QUE RECIBE:</b><br/>$infoReclamacion[Razon_Social_Reclamante]</td>
    EOF;
}else{
    $bloque10 .= <<<EOF
        <td style="border: 1px solid #666; width:540px"><b>PRESTADOR QUE RECIBE:</b><br/></td>
    EOF;

}

            
$bloque10 .= <<<EOF
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>CODIGO DE INSCRIPCION:</b><br/>$infoReclamacion[Codigo_IPS_Recibe]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>PROFESIONAL QUE RECIBE:</b><br/>$infoReclamacion[Profesional_Recibe]</td>
                <td style="border: 1px solid #666; width:270px"><b>CARGO:</b><br/>$infoReclamacion[Cargo_Recibe]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>PLACA DE LA AMBULANCIA QUE REALIZA EL TRASLADO INTERINSTITUCIONAL:</b><br/>$infoReclamacion[Placa_Traslado_Interinstitucional]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque10, false, false, false, false, '');

$bloque11 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">X. TRANSPORTE Y MOVILIZACION DE LA VICTIMA</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>DATOS DEL VEHICULO:</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>PLACA NO:</b><br/>$infoReclamacion[Placa_Servicio_Transporte]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>TRANSPORTO DESDE:</b><br/>$infoReclamacion[Trans_Direc_Sitio_Evento]</td>
                <td style="border: 1px solid #666; width:270px"><b>HASTA:</b><br/>$infoReclamacion[Trans_Direc_Fin_Recorrido]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>TIPO TRANSPORTE:</b></td>
            </tr>
            <tr>
EOF;

if($infoReclamacion["Tipo_Servicio"] == "1" || $infoReclamacion["Tipo_Servicio"] == "1A"){

    $bloque11 .= <<<EOF
        <td style="border: 1px solid #666; width:180px"><b>AMBULANCIA BASICA:</b>  X</td>
    EOF;
    
}else{
    
    $bloque11 .= <<<EOF
        <td style="border: 1px solid #666; width:180px"><b>AMBULANCIA BASICA:</b></td>
    EOF;

}

if($infoReclamacion["Tipo_Servicio"] == "2" || $infoReclamacion["Tipo_Servicio"] == "2A"){
    
    $bloque11 .= <<<EOF
        <td style="border: 1px solid #666; width:180px"><b>AMBULANCIA MEDICALIZADA:</b>  X</td>
    EOF;
    
}else{
    
    $bloque11 .= <<<EOF
        <td style="border: 1px solid #666; width:180px"><b>AMBULANCIA MEDICALIZADA:</b></td>
    EOF;

}


$bloque11 .= <<<EOF
            <td style="border: 1px solid #666; width:180px"><b>LUGAR DONDE RECOGE:</b>$infoReclamacion[Zona_Recogida]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque11, false, false, false, false, '');

$bloque12 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">XI. CERTIFICACIÓN DE LA ATENCIÓN MEDICA DE LA VICTIMA COMO PRUEBA DEL ACCIDENTE O EVENTO</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>FECHA INGRESO:</b><br/>$infoReclamacion[Fecha_Hora_Ingreso_IPS]</td>
                <td style="border: 1px solid #666; width:270px"><b>FECHA EGRESO:</b><br/>$infoReclamacion[Fecha_Hora_Egreso_IPS]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>CODIGO DX PRINCIPAL NGRESO:</b><br/>$infoReclamacion[Cod_Diagnostico_Ingreso]</td>
                <td style="border: 1px solid #666; width:270px"><b>CODIGO DX PRINCIPAL EGRESO:</b><br/>$infoReclamacion[Cod_Diagnostico_Egreso]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>OTRO CODIGO DIAGNOSTICO DE INGRESO:</b><br/>$infoReclamacion[Cod_Diagnostico_Ingreso1]</td>
                <td style="border: 1px solid #666; width:270px"><b>OTRO CODIGO DE DIAGNOSTICO DE EGRESO:</b><br/>$infoReclamacion[Cod_Diagnostico_Egreso1]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>OTRO CODIGO DIAGNOSTICO DE INGRESO:</b><br/>$infoReclamacion[Cod_Diagnostico_Ingreso2]</td>
                <td style="border: 1px solid #666; width:270px"><b>OTRO CODIGO DE DIAGNOSTICO DE EGRESO:</b><br/>$infoReclamacion[Cod_Diagnostico_Egreso2]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque12, false, false, false, false, '');

$bloque13 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">XII. DATOS DEL MEDICO O PROFESIONAL DE SALUD TRATANTE</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>PRIMER APELLIDO MEDICO TRATANTE:</b><br/>$infoReclamacion[Primer_Apellido_Medico]</td>
                <td style="border: 1px solid #666; width:270px"><b>SEGUNDO APELLIDO MEDICO TRATANTE:</b><br/>$infoReclamacion[Segundo_Apellido_Medico]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px"><b>PRIMER NOMBRE MEDICO TRATANTE:</b><br/>$infoReclamacion[Primer_Nombre_Medico]</td>
                <td style="border: 1px solid #666; width:270px"><b>SEGUNDO NOMBRE MEDICO TRATANTE:</b><br/>$infoReclamacion[Segundo_Nombre_Medico]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px"><b>TIPO DOCUMENTO:</b><br/>$infoReclamacion[Tipo_Doc_Medico]</td>
                <td style="border: 1px solid #666; width:180px"><b>NO. DOCUMENTO:</b><br/>$infoReclamacion[Doc_Medico]</td>
                <td style="border: 1px solid #666; width:180px"><b>NO. REGISTRO MEDICO:</b><br/>$infoReclamacion[Registro_Medico]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque13, false, false, false, false, '');

$bloque14 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">XIII. AMPAROS QUE RECLAMA</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px"><b></b></td>
                <td style="border: 1px solid #666; width:180px"><b>VALOR TOTAL FACTURADO:</b></td>
                <td style="border: 1px solid #666; width:180px"><b>VALORT TOTAL RECLAMADO AL FOSYGA:</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px"><b>GASTOS MEDICOS QUIRURGICOS</b></td>
                <td style="border: 1px solid #666; width:180px">$Total_Facturado_Amparo_Gastos_Medicos_Quirurgicos</td>
                <td style="border: 1px solid #666; width:180px">$Total_Reclamado_Amparo_Gastos_Medicos_Quirurgicos</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px"><b>GASTOS DE TRANSPORTE Y MOVILIZACION</b></td>
                <td style="border: 1px solid #666; width:180px">$Total_Facturado_Amparo_Gastos_Transporte_Movilizacion_Victima</td>
                <td style="border: 1px solid #666; width:180px">$Total_Reclamado_Amparo_Gastos_Transporte_Movilización_Victima</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque14, false, false, false, false, '');

$bloque15 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left; background-color:$colorBloque;">XIV. DECLARACION DE LA INSTITUCION PRESTADORA DE SERVICIOS DE SALUD</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>MANIFESTACION DE LOS SERVICIOS HABILITADOS:</b><br/>{$arrayManifesServPres[$infoReclamacion['Manifestacion_servicios_habilitados']]}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px"><b>DESCRIPCION DEL EVENTO:</b><br/>$infoReclamacion[Descripcion_evento]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque15, false, false, false, false, '');

$pdf->Output('Furips.pdf', 'I');

}

}

$furipsPDF = new GenerarFuripsPDF();
$furipsPDF->numRecla = base64_decode($_GET["numRecla"]);
$furipsPDF->furipsPDF();
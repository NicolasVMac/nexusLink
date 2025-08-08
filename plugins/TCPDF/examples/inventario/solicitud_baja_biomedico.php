<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

/*===================================
CONTROLADORES
=====================================*/
require_once "../../../../controllers/inventario/inventario-biomedico.controller.php";

/*===================================
MODELOS
=====================================*/
require_once "../../../../models/inventario/inventario-biomedico.model.php";

class BajaEquipoBiomedicoPDF {

public $idSoliBajaBiomedico;

public function generarPDF() {

date_default_timezone_set('America/Bogota');

$diaFormato = date('d');
$mesFormato = date('m');
$anioFormato = date('Y');

$hoy = date('d/m/Y');
$fechaHora = date("Y-m-d H:i:s");



$colorBloque = "#78ceff";

$meses = array(
    "01" => "enero",
    "02" => "febrero",
    "03" => "marzo",
    "04" => "abril",
    "05" => "mayo",
    "06" => "junio",
    "07" => "julio",
    "08" => "agosto",
    "09" => "septiembre",
    "10" => "octubre",
    "11" => "noviembre",
    "12" => "diciembre"
);


//INFORMACION BAJA EQUIPO
$infoBajaEquipo = ControladorInventarioBiomedico::ctrObtenerDato("inventario_equipos_biomedicos_solicitudes_bajas_equipos", "id_soli_baja_bio", $this->idSoliBajaBiomedico);

//INFORMACION EQUIPO BIOMEDICO
$infoEquipoBiomedico = ControladorInventarioBiomedico::ctrObtenerDato("inventario_equipos_biomedicos", "id", $infoBajaEquipo["id_equipo_biomedico"]);

//INFORMACION MANTENIMIENTOS
$infoMantenimientos = ControladorInventarioBiomedico::ctrObtenerMantenimientosEquipoBiomedico($infoBajaEquipo["id_equipo_biomedico"]);


require_once('../tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// $pdf->SetMargins(20, 30, 20); // Márgenes: Izquierda, Arriba, Derecha
// $pdf->SetAutoPageBreak(true, 30);

$pdf->setPrintHeader(false);

$pdf->setTitle('Acta Baja Equipo Biomedico');
$pdf->startPageGroup();
$pdf->AddPage();


$header = <<<EOF
    <table border="0" style="padding: 5px; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:center;">
EOF;

if (strpos($infoEquipoBiomedico["sede"], 'CAFAM') !== false){
    $imagen = '<img src="../images/shared/header-cafam.png" width="150" height="60">';
} else {
    $imagen = '<img src="../images/shared/header-vidamedical.png" width="150" height="60">';
}

$header .= $imagen;

$header .= <<<EOF
                </td>
                <td style="border: 1px solid #666; width:270px; text-align:center; font-size: 12px;">
                    <b><br>ACTA DE BAJA DE EQUIPOS BIOMEDICOS</b>
                </td>
                <td style="border: 1px solid #666; width:135px; text-align:center; font-size: 10px;"><br><br>F-INF-P-01-5 V.1 <br>31/10/2024</td>
            </tr>
        </thead>
    </table>
    <br>
EOF;

$pdf->writeHTML($header, false, false, false, false, '');

$bloque1 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>INFORMACION DEL SOLICITANTE</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>SEDE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[fecha_crea]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>FECHA Y HORA</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$fechaHora</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>NOMBRE SOLICITANTE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoBajaEquipo[nombre_solicitante]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>CARGO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoBajaEquipo[cargo]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');


$bloque2 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>INFORMACION DEL EQUIPO BIOMEDICO</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>NOMBRE EQUIPO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[nombre_equipo]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>SERIE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[serie]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>MARCA</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[marca]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>ACTIVO FIJO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[activo_fijo]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>MODELO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[modelo]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>UBICACION</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[ubicacion]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');


$bloque3 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>INFORMACION TECNICA Y DE MANTENIMIENTO</b></td>
            </tr>
EOF;

if(!empty($infoMantenimientos)){


foreach ($infoMantenimientos as $key => $mantenimiento) {
    
$bloque3 .= <<<EOF

    <tr>
        <td style="border: 1px solid #666; width:135px; text-align:left;"><b>RESPONSABLE MANTENIMIENTO</b></td>
        <td style="border: 1px solid #666; width:135px; text-align:left;">$mantenimiento[responsable]</td>
        <td style="border: 1px solid #666; width:135px; text-align:left;"><b>FECHA MANTENIMIENTO</b></td>
        <td style="border: 1px solid #666; width:135px; text-align:left;">$mantenimiento[fecha_ejecucion]</td>
    </tr>
    <tr>
        <td style="border: 1px solid #666; width:540px; text-align:center;"><b>FALLAS ENCONTRADAS</b></td>
    </tr>
    <tr>
        <td style="border: 1px solid #666; width:540px; text-align:left;">$mantenimiento[descripcion_falla]</td>
    </tr>

EOF;
    
}

}else{

$bloque3 .= <<<EOF

    <tr>
        <td style="border: 1px solid #666; width:540px; text-align:center;">SIN MANTENIMIENTOS</td>
    </tr>

EOF;

}


$bloque3 .= <<<EOF
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center;"><b>CONCEPTO TECNICO PARDA DAR BAJA</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left;">$infoBajaEquipo[concepto_baja]</td>
            </tr>
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

$bloque4= <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>DISPOSICION FINAL</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>RECICLAJE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoBajaEquipo[reciclaje]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>EMPRESA RESPONSABLE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoBajaEquipo[empresa_responsable_reci]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>DISPOSICION FINAL</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoBajaEquipo[disposicion]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>EMPRESA RESPONSABLE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoBajaEquipo[empresa_responsable_dispo]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');


$bloque5 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>APROBACION DEL RETIRO</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; height: 60px; text-align:center;"><b><br><br>COORDINADOR DE LA IPS</b></td>
                <td style="border: 1px solid #666; width:405px; text-align:left;"><br><br><br></td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

// Generar PDF
$pdf->Output('Acta Baja Equipo.pdf', 'I');

}

}

$generatedPDF = new BajaEquipoBiomedicoPDF();
$generatedPDF->idSoliBajaBiomedico = base64_decode($_GET["idSoliBajaBiomedico"]);
$generatedPDF->generarPDF();

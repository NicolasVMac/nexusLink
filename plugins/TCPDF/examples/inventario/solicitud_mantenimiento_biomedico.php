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

class MantenimientoCorrectivoEquipoBiomedicoPDF {

public $idSoliMantenimientoBiomedico;

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


//INFORMACION Mantenimiento
$infoMantenimietno = ControladorInventarioBiomedico::ctrObtenerDato("inventario_equipos_biomedicos_solicitudes_mantenimientos", "id_soli_mante_bio", $this->idSoliMantenimientoBiomedico);

//INFORMACION EQUIPO BIOMEDICO
$infoEquipoBiomedico = ControladorInventarioBiomedico::ctrObtenerDato("inventario_equipos_biomedicos", "id", $infoMantenimietno["id_equipo_biomedico"]);

//INFORMACION USUARIO ELABORA
$infoElabora= ControladorInventarioBiomedico::ctrObtenerDato("usuarios", "usuario", $infoMantenimietno["usuario_crea"]);

//INFORMACION COMPONENTES Y ACCESORIOS
$infoCompoAccesorios = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoComponentesCaracteristicas($infoMantenimietno["id_equipo_biomedico"]);


require_once('../tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// $pdf->SetMargins(20, 30, 20); // Márgenes: Izquierda, Arriba, Derecha
// $pdf->SetAutoPageBreak(true, 30);

$pdf->setPrintHeader(false);

$pdf->setTitle('Mantenimiento Correctivo Equipo Biomedico');
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
                    <b><br>SOLICITUD MANTENIMIENTO CORRECTIVO DE EQUIPOS BIOMEDICOS</b>
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
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>SEDE</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$infoEquipoBiomedico[fecha_crea]</td>
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>ORDEN Nº</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$infoMantenimietno[orden_no]</td>
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>FECHA Y HORA</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$fechaHora</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$bloque2= <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>INFORMACION DEL EQUIPO Y DE QUIEN SOLICITA</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>NOMBRE DEL EQUIPO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[nombre_equipo]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>ACTIVO FIJO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[activo_fijo]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>MARCA</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[marca]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>UBICACION</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[ubicacion]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>MODELO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[modelo]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>SOLICITANTE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoElabora[nombre]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>SERIE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[serie]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>CARGO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoMantenimietno[cargo]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

$bloque3 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>DETALLE INCIDENCIA</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left;">$infoMantenimietno[descripcion_incidencia]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

$bloque4 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>DETALLE SERVICIO</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>FECHA EJECUCION</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$infoMantenimietno[fecha_ejecucion]</td>
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>RESPONSABLE</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$infoMantenimietno[responsable]</td>
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>REQUIERE REPUESTO</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$infoMantenimietno[requiere_repuesto]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center;"><b>DESCRIPCION FALLA</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left;">$infoMantenimietno[descripcion_falla]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

$bloque5 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>REPUESTOS NECESARIOS</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left;">$infoMantenimietno[repuestos_necesarios]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');


$bloque6 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>RECIBIDO SATISFACCION</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; height: 60px; text-align:center;"><b><br>NOMBRE RESPONSABLE QUIEN REALIZA MANTENIMIENTO</b></td>
                <td style="border: 1px solid #666; width:405px; text-align:left;"><br><br><br></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; height: 60px; text-align:center;"><b><br>NOMBRE RESPONSABLE QUIEN RECIBE MANTENIMIENTO</b></td>
                <td style="border: 1px solid #666; width:405px; text-align:left;"><br><br><br></td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

// Generar PDF
$pdf->Output('Solicitud Mantenimiento Correctivo.pdf', 'I');

}

}

$generatedPDF = new MantenimientoCorrectivoEquipoBiomedicoPDF();
$generatedPDF->idSoliMantenimientoBiomedico = base64_decode($_GET["idSoliMantenimientoBiomedico"]);
$generatedPDF->generarPDF();

<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

/*===================================
CONTROLADORES
=====================================*/
require_once "../../../controllers/pqr/pqr.controller.php";

/*===================================
MODELOS
=====================================*/
require_once "../../../models/pqr/pqr.model.php";

class GeneratedPDFPQRSF {

public $idPQRSF;

public function generarPDF() {

date_default_timezone_set('America/Bogota');

$diaFormato = date('d');
$mesFormato = date('m');
$anioFormato = date('Y');

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


//INFORMACION PQRSF
$pqrsf = ControladorPqr::ctrObtenerDato("pqr_pqrs", "id_pqr", $this->idPQRSF);

//INFORMACION SEDE
$infoSede = ControladorPqr::ctrObtenerDato("pqr_par_sedes", "sede", $pqrsf["sede"]);


require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// $pdf->SetMargins(20, 30, 20); // Márgenes: Izquierda, Arriba, Derecha
// $pdf->SetAutoPageBreak(true, 30);

$pdf->setPrintHeader(false);

$pdf->setTitle('generated_pdf_pqrsf');
$pdf->startPageGroup();
$pdf->AddPage();


$header = <<<EOF
    <table style="border: none; text-align: left;">
        <thead>
            <tr style="border: none;">
                <td style="border: none; width:540px;">
EOF;

if($infoSede["tipo"] == 'NEXUS'){

    $header .= <<<EOF
        <img src="images/pqrsf/nexus.png" width="100" height="80">
    EOF;

}else{

    $header .= <<<EOF
        <img src="images/pqrsf/header-cafam.png" width="100" height="50">
    EOF;

}


$header .= <<<EOF
                </td>
            </tr>
        </thead>
    </table>
    <br>
    <br>
EOF;

$pdf->writeHTML($header, false, false, false, false, '');


$bloque1 = <<<EOF

    <table style="border: none; text-align: left; font-size: 10px;">
        <thead>
            <tr style="border: none;">
                <td style="border: none; width:540px;">Bogotá D.C, $diaFormato de $meses[$mesFormato] de $anioFormato</td>
            </tr>
            <tr>
                <td style="width:540px;"></td>
            </tr>
            <tr>
                <td style="border: none; width:540px;"># PQRSF: $pqrsf[id_pqr]</td>
            </tr>
            <tr>
                <td style="width:540px;"></td>
            </tr>
            <tr>
                <td style="border: none; width:540px;">Usuario: $pqrsf[nombre_pac]</td>
            </tr>
            <tr>
                <td style="border: none; width:540px;">$pqrsf[tipo_identificacion_pac] $pqrsf[numero_identificacion_pac]</td>
            </tr>
            <tr>
                <td style="border: none; width:540px;">$pqrsf[contacto_pet]</td>
            </tr>
            <tr>
                <td style="border: none; width:540px;">$pqrsf[correo_pet]</td>
            </tr>
            <tr>
                <td style="border: none; width:540px;">Bogotá D.C</td>
            </tr>
        </thead>
    </table>
    <br>
    <br>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');


$bloque2 = <<<EOF

    <table style="border: none; text-align: justify; font-size: 10px;">
        <thead>
            <tr style="border: none;">
                <td style="border: none; width:540px;"><b>ASUNTO:</b> Respuesta a $pqrsf[tipo_pqr]</td>
            </tr>
            <tr>
                <td style="width:540px;"></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; width:540px;">$pqrsf[pla_ac_respuesta]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');


// Generar PDF
$pdf->Output('Furips.pdf', 'I');

}

}

$generatedPDF = new GeneratedPDFPQRSF();
$generatedPDF->idPQRSF = base64_decode($_GET["idPQRSF"]);
$generatedPDF->generarPDF();

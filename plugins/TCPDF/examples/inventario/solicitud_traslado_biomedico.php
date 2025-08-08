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

class TrasladoEquipoBiomedicoPDF {

public $idSoliTrasladoBiomedico;

public function generarPDF() {

date_default_timezone_set('America/Bogota');

$diaFormato = date('d');
$mesFormato = date('m');
$anioFormato = date('Y');

$hoy = date('d/m/Y');

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


//INFORMACION TRASLADO
$infoTraslado = ControladorInventarioBiomedico::ctrObtenerDato("inventario_equipos_biomedicos_solicitudes_traslados", "id_soli_traslado_bio", $this->idSoliTrasladoBiomedico);

//INFORMACION EQUIPO BIOMEDICO
$infoEquipoBiomedico = ControladorInventarioBiomedico::ctrObtenerDato("inventario_equipos_biomedicos", "id", $infoTraslado["id_equipo_biomedico"]);

//INFORMACION USUARIO ELABORA
$infoElabora= ControladorInventarioBiomedico::ctrObtenerDato("usuarios", "usuario", $infoTraslado["usuario_crea"]);

//INFORMACION COMPONENTES Y ACCESORIOS
$infoCompoAccesorios = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoComponentesCaracteristicas($infoTraslado["id_equipo_biomedico"]);


require_once('../tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// $pdf->SetMargins(20, 30, 20); // Márgenes: Izquierda, Arriba, Derecha
// $pdf->SetAutoPageBreak(true, 30);

$pdf->setPrintHeader(false);

$pdf->setTitle('Traslado Equipo Biomedico');
$pdf->startPageGroup();
$pdf->AddPage();


$header = <<<EOF
    <table border="0" style="padding: 5px; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:center;">
EOF;

if (strpos($infoTraslado["sede_new"], 'CAFAM') !== false){
    $imagen = '<img src="../images/shared/header-cafam.png" width="150" height="60">';
} else {
    $imagen = '<img src="../images/shared/header-vidamedical.png" width="150" height="60">';
}

$header .= $imagen;

$header .= <<<EOF
                </td>
                <td style="border: 1px solid #666; width:270px; text-align:center; font-size: 12px; line-height:60px;">
                    <b>TRASLADO EQUIPOS BIOMEDICOS</b>
                </td>
                <td style="border: 1px solid #666; width:135px; text-align:center; font-size: 10px;"><br><br>F-INF-P-01-8 V.1 <br>31/10/2024</td>
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
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>INFORMACION GENERAL</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>FECHA</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoTraslado[fecha_crea]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>SERIE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[serie]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>NOMBRE DEL EQUIPO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[nombre_equipo]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>ACTIVO FIJO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoTraslado[activo_fijo_old]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>MARCA</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[marca]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>UBICACION</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoTraslado[ubicacion_old]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>MODELO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[modelo]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>SEDE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoTraslado[sede_old]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; text-align:left;"><b>TIEMPO ESTIMADO DE SALIDA</b></td>
                <td style="border: 1px solid #666; width:270px; text-align:left;">$infoTraslado[tiempo_estimado_salida]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$bloque2 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>MOTIVO SALIDA</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left;">$infoTraslado[motivo_salida]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

$bloque3 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>OBSERVACIONES</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:left;">$infoTraslado[observaciones]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

$bloque4 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>ACCESORIOS</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:405px; text-align:center;">DESCRIPCION</td>
                <td style="border: 1px solid #666; width:135px; text-align:center;">CANTIDAD</td>
            </tr>

EOF;

foreach ($infoCompoAccesorios as $key => $valueCompoAcceso) {

    $bloque4 .= <<<EOF
        <tr>
            <td style="border: 1px solid #666; width:405px; text-align:left;">$valueCompoAcceso[componente_caracteristica]</td>
            <td style="border: 1px solid #666; width:135px; text-align:center;">$valueCompoAcceso[cantidad]</td>
        </tr>
    EOF;

}


$bloque4 .= <<<EOF
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');


$bloque5 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>UBICACION NUEVA</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>SEDE</b></td>
                <td style="border: 1px solid #666; width:405px; text-align:left;">$infoTraslado[sede_new]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>ACTIVO FIJO</b></td>
                <td style="border: 1px solid #666; width:405px; text-align:left;">$infoTraslado[activo_fijo_new]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>UBICACION</b></td>
                <td style="border: 1px solid #666; width:405px; text-align:left;">$infoTraslado[ubicacion_new]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');


$bloque6 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>INFORMACION DEL RESPONSABLE</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; height: 60px; text-align:center;"><b><br><br>AUTORIZADO POR</b></td>
                <td style="border: 1px solid #666; width:405px; text-align:left;"><br><br><br>$infoElabora[nombre]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; height: 60px; text-align:center;"><b><br><br>RECIBIDO POR</b></td>
                <td style="border: 1px solid #666; width:405px; text-align:left;"><br><br><br>$infoTraslado[recibido_por]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

// Generar PDF
$pdf->Output('Solicitud Traslado.pdf', 'I');

}

}

$generatedPDF = new TrasladoEquipoBiomedicoPDF();
$generatedPDF->idSoliTrasladoBiomedico = base64_decode($_GET["idSoliTrasladoBiomedico"]);
$generatedPDF->generarPDF();

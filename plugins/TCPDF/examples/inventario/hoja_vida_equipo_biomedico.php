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

class HojaVidaEquipoBiomedicoPDF {

public $idEquipoBiomedico;

public function generarPDF() {

date_default_timezone_set('America/Bogota');

$diaFormato = date('d');
$mesFormato = date('m');
$anioFormato = date('Y');

$hoy = date('d/m/Y');
$fechaHora = date("Y-m-d H:i:s");



$colorBloque = "#78ceff";
$colorBloque2 = "#eaeded";

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


$arrayFrecuencias = array(
    "TRIMESTRAL" => 3,
    "CUATRIMESTRAL" => 4,
    "SEMESTRAL" => 6,
    "ANUAL" => 12,
);


//INFORMACION EQUIPO BIOMEDICO
$infoEquipoBiomedico = ControladorInventarioBiomedico::ctrObtenerDato("inventario_equipos_biomedicos", "id", $this->idEquipoBiomedico);

//HISTORICO EQUIPO
$infoHistorico = ControladorInventarioBiomedico::ctrInfoDatosEquipoBiomedicoHistorico($this->idEquipoBiomedico);

//LISTA MANUALES
$manuales = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoManuales($this->idEquipoBiomedico);

//LISTA PLANOS
$planos = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoPlanos($this->idEquipoBiomedico);

//LISTA RECOMENDACIONES FABRICANTE
$recomendaciones = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoRecomendaciones($this->idEquipoBiomedico);

//LISTA COMPONENTES Y ACCESORIOS
$componentesAccesorios = ControladorInventarioBiomedico::ctrListaEquipoBiomedicoComponentesCaracteristicas($this->idEquipoBiomedico);

//TIPO MANTENIMIENTO - MTTO
$mtto = ControladorInventarioBiomedico::ctrObtenerMtoBiomedico($this->idEquipoBiomedico);

//TIPO MANTENIMIENTOS - OTROS
$otrosMto = ControladorInventarioBiomedico::ctrObtenerOtrosMto($this->idEquipoBiomedico);

//HISTORIAL MANTENIMIENTO
$historial = ControladorInventarioBiomedico::ctrObtenerHistorialMantenimientos($this->idEquipoBiomedico);

$strManuales = '';
$strPlanos = '';

$valorIvaIncluido = number_format($infoHistorico["valor_iva"], 2);

if(!empty($manuales)){
    foreach ($manuales as $key => $valueM) {
        $strManuales .= $valueM["tipo_manual"]."<br>";
    }
}

if(!empty($planos)){
    foreach ($planos as $key => $valueP) {
        $strPlanos .= $valueP["tipo_plano"]."<br>";
    }
}


require_once('../tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// $pdf->SetMargins(20, 30, 20); // Márgenes: Izquierda, Arriba, Derecha
// $pdf->SetAutoPageBreak(true, 30);

$pdf->setPrintHeader(false);

$pdf->setTitle('Hoja Vida Equipo Biomedico');
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
                    <b><br>HOJA DE VIDA EQUIPOS BIOMEDICOS</b>
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
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>INFORMACION DEL EQUIPO BIOMEDICO</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>NOMBRE EQUIPO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[nombre_equipo]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>SEDE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[sede]</td>
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
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>SERVICIO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[servicio]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>SERIE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[serie]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>CLASIFICACION BIOMEDICA</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[clasificacion_biomedica]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>ACTIVO FIJO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[activo_fijo]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>CLASIFICACION RIESGO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoEquipoBiomedico[clasificacion_riesgo]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>REGISTRO INVIMA</b></td>
                <td style="border: 1px solid #666; width:405px; text-align:left;">$infoEquipoBiomedico[registro_sanitario_invima]</td>
            </tr>
        </thead>
    </table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$bloque2 = <<<EOF
    <table border="0" style="width:100%; font-size: 8px; padding: 5px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>DATOS TECNICOS</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; text-align:left;"><b>TECNOLOGIA PREDOMINANTE</b></td>
                <td style="border: 1px solid #666; width:270px; text-align:left;">$infoEquipoBiomedico[tecnologia_predominante]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; text-align:left;"><b>FUENTE ALIMENTACION</b></td>
                <td style="border: 1px solid #666; width:270px; text-align:left;">$infoEquipoBiomedico[fuente_alimentacion]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; text-align:left;"><b>CARACTERISTICAS INSTALACION</b></td>
                <td style="border: 1px solid #666; width:270px; text-align:left;">$infoEquipoBiomedico[caracteristica_instalacion]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; text-align:left;"><b>TENSION TRABAJO</b></td>
                <td style="border: 1px solid #666; width:270px; text-align:left;">$infoEquipoBiomedico[tension_trabajo]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; text-align:left;"><b>CONSUMO WATT</b></td>
                <td style="border: 1px solid #666; width:270px; text-align:left;">$infoEquipoBiomedico[consumo_watt]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; text-align:left;"><b>PESO (KG)</b></td>
                <td style="border: 1px solid #666; width:270px; text-align:left;">$infoEquipoBiomedico[peso]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; text-align:left;"><b>CONDICIONES AMBIENTALES</b></td>
                <td style="border: 1px solid #666; width:270px; text-align:left;">$infoEquipoBiomedico[condiciones_ambientales]</td>
            </tr>
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

$bloque3 = <<<EOF
    <table border="0" style="width:100%; font-size: 8px; padding: 5px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:270px; text-align:center; background-color:$colorBloque;"><b>MANUALES EQUIPO</b></td>
                <td style="border: 1px solid #666; width:270px; text-align:center; background-color:$colorBloque;"><b>PLANOS EQUIPO</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; text-align:left;">$strManuales</td>
                <td style="border: 1px solid #666; width:270px; text-align:left;">$strPlanos</td>
            </tr>
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');


$bloque4 = <<<EOF
    <table border="0" style="width:100%; font-size: 8px; padding: 5px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>MANTENIMIENTO PREVENTIVO</b></td>
            </tr>
EOF;

if(!empty($mtto)){

    $visitasAnio = 12 / $arrayFrecuencias[$mtto['frecuencia']];

    $bloque4 .= <<<EOF
        <tr>
            <td style="border: 1px solid #666; width:135px; text-align:left;"><b>FRECUENCIA MANTENIMIENTO</b></td>
            <td style="border: 1px solid #666; width:135px; text-align:left;">$mtto[frecuencia]</td>
            <td style="border: 1px solid #666; width:135px; text-align:left;"><b>VISITAS AL AÑO</b></td>
            <td style="border: 1px solid #666; width:135px; text-align:left;">$visitasAnio</td>
        </tr>
    EOF;
}else{

    $bloque4 .= <<<EOF
        <tr>
            <td style="border: 1px solid #666; width:540px; text-align:center;"><b>SIN MANTENIMIENTO</b></td>
        </tr>
    EOF;

}

    $bloque4 .= <<<EOF
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>METROLOGIA / OTRO</b></td>
            </tr>
    EOF;

    foreach ($otrosMto as $key => $valueMto){

        $visitasAnio = 12 / $arrayFrecuencias[$valueMto['frecuencia']];

        $bloque4 .= <<<EOF
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>OTROS MANTENIMIENTOS</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$valueMto[tipo_mantenimiento]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>VISITAS AL AÑO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$visitasAnio</td>
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
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>RECOMENDACIONES FABRICANTE</b></td>
            </tr>

EOF;

foreach ($recomendaciones as $key => $valueR) {

    $bloque5 .= <<<EOF
        <tr>
            <td style="border: 1px solid #666; width:540px; text-align:left;">$valueR[recomendacion]</td>
        </tr>
    EOF;

}


$bloque5 .= <<<EOF
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');


$bloque6 = <<<EOF
    <table border="0" style="width:100%; font-size: 8px; padding: 5px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>HISTORICO EQUIPO</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>NUMERO FACTURA</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoHistorico[numero_factura]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>FORMA ADQUISICION</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoHistorico[forma_adquisicion]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>VIDA UTIL EQUIPO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoHistorico[vida_util]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>VALOR IVA INCLUIDO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$valorIvaIncluido</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque2;"><b>FECHAS</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>COMPRA</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$infoHistorico[compra]</td>
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>INSTALACION</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$infoHistorico[instalacion]</td>
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>RECIBIDO</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$infoHistorico[recibido]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>FECHA INICIO GARANTIA</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$infoHistorico[fecha_inicio_garantia]</td>
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>FECHA FIN GARANTIA</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$infoHistorico[fecha_fin_garantia]</td>
                <td style="border: 1px solid #666; width:90px; text-align:left;"><b>GARANTIA (DIAS)</b></td>
                <td style="border: 1px solid #666; width:90px; text-align:left;">$infoHistorico[garantia_anios]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque2;"><b>DATOS COMERCIALES</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>FABRICANTE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoHistorico[fabricante]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>NOMBRE CONTACTO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoHistorico[nombre_contacto]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>REPRESANTE</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoHistorico[representante]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>TELEFONO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoHistorico[telefono]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>CORREO ELECTRONICO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoHistorico[correo_electronico]</td>
                <td style="border: 1px solid #666; width:135px; text-align:left;"><b>CARGO O PUESTO</b></td>
                <td style="border: 1px solid #666; width:135px; text-align:left;">$infoHistorico[cargo_puesto]</td>
            </tr>
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

$bloque7 = <<<EOF

    <table border="0" style="padding: 5px; text-align: left; font-size: 8px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>COMPONENTES Y ACCESORIOS</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:405px; text-align:center;">DESCRIPCION</td>
                <td style="border: 1px solid #666; width:135px; text-align:center;">CANTIDAD</td>
            </tr>

EOF;

foreach ($componentesAccesorios as $key => $valueCompoAcceso) {

    $bloque7 .= <<<EOF
        <tr>
            <td style="border: 1px solid #666; width:405px; text-align:left;">$valueCompoAcceso[componente_caracteristica]</td>
            <td style="border: 1px solid #666; width:135px; text-align:center;">$valueCompoAcceso[cantidad]</td>
        </tr>
    EOF;

}


$bloque7 .= <<<EOF
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');

$bloque8 = <<<EOF
    <table border="0" style="width:100%; font-size: 8px; padding: 5px;">
        <thead>
            <tr>
                <td style="border: 1px solid #666; width:540px; text-align:center; background-color:$colorBloque;"><b>HISTORIAL MANTENIMIENTOS</b></td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:100px; text-align:center; background-color:$colorBloque2;"><b>TIPO MANTENIMIENTO</b></td>
                <td style="border: 1px solid #666; width:340px; text-align:center; background-color:$colorBloque2;"><b>OBSERVACIONES</b></td>
                <td style="border: 1px solid #666; width:100px; text-align:center; background-color:$colorBloque2;"><b>FECHA CREA</b></td>
            </tr>
EOF;

foreach ($historial as $key => $valueH) {
    $bloque8 .= <<<EOF
        <tr>
            <td style="border: 1px solid #666; width:100px; text-align:left;">$valueH[tipo_mantenimiento]</td>
            <td style="border: 1px solid #666; width:340px; text-align:left;">$valueH[observaciones_mantenimiento]</td>
            <td style="border: 1px solid #666; width:100px; text-align:left;">$valueH[fecha_crea]</td>
        </tr>
    EOF;
}

$bloque8 .= <<<EOF
        </thead>
    </table>
EOF;

$pdf->writeHTML($bloque8, false, false, false, false, '');

// Generar PDF
$pdf->Output('Hoja Vida Equipo.pdf', 'I');

}

}

$generatedPDF = new HojaVidaEquipoBiomedicoPDF();
$generatedPDF->idEquipoBiomedico = base64_decode($_GET["idEquipoBiomedico"]);
$generatedPDF->generarPDF();

<?php

/*===================================
CONTROLADORES
=====================================*/
require_once "../../../../controladores/cuentasmedicas.controlador.php";
require_once "../../../../controladores/paciente.controlador.php";
require_once "../../../../controladores/prestador.controlador.php";
require_once "../../../../controladores/usuarios.controlador.php";

/*===================================
MODELOS
=====================================*/
require_once "../../../../modelos/cuentasmedicas.modelo.php";
require_once "../../../../modelos/paciente.modelo.php";
require_once "../../../../modelos/prestador.modelo.php";
require_once "../../../../modelos/usuarios.modelo.php";


class GenerarPdfCuentaMedica{

public $idCuentaMedica;


public function pdfCuentaMedica(){

/*===================================
CONSULTAS Y LOGICA PHP
=====================================*/

//INFO CUENTA MEDICA
$tablaCm = "cuentas_facturas";
$itemCm = "id_factura";
$valorCm = $this->idCuentaMedica;

$datoCm = ControladorCuentasMedicas::ctrBuscarDato($tablaCm, $itemCm, $valorCm);

$tablaRad = "cuentas_radicacion";
$itemRad = "id_radicacion";
$valorRad = $datoCm["id_radicacion"];

$datoRadicacion = ControladorCuentasMedicas::ctrBuscarDato($tablaRad, $itemRad, $valorRad);

$datosCuentasMedicas = ControladorCuentasMedicas::ctrInfoCuentaPdf($valorCm);

$datosCuentasMedicas["valor_factura"] = number_format($datosCuentasMedicas["valor_factura"], 2);
$datosCuentasMedicas["valor_iva"] = number_format($datosCuentasMedicas["valor_iva"], 2);
$datosCuentasMedicas["valor_nota_credito"] = number_format($datosCuentasMedicas["valor_nota_credito"], 2);

if($datosCuentasMedicas["dias_ans"] >= 3){

    $estadoPublicada = "A TIEMPO";

}elseif($datosCuentasMedicas["dias_ans"] < 3 && $datosCuentasMedicas["dias_ans"] >= 1){
    
    $estadoPublicada = "A VENCER";

}elseif($datosCuentasMedicas["dias_ans"] <= 0 ){

    $estadoPublicada = "VENCIDA";

}

if($datosCuentasMedicas["dias_auditoria"] >= 10){

    $estadoRadicacion = "A TIEMPO";

}elseif($datosCuentasMedicas["dias_auditoria"] >= 1 && $datosCuentasMedicas["dias_auditoria"] < 10){

    $estadoRadicacion = "A VENCER";

}elseif($datosCuentasMedicas['dias_auditoria'] <= 0){

    $estadoRadicacion = "VENCIDA";

}

//TRAER INFORMACION AUDITOR
$itemAuditor = "usuario";
$valorAuditor = $datosCuentasMedicas["auditor"];

$dataAuditor = ControladorUsuarios::ctrMostrarUsuarios($itemAuditor, $valorAuditor);


//TRAER INFORMACION PACIENTE
$itemPaciente = "id_paciente";
$valorPaciente = $datosCuentasMedicas["id_paciente"];

$dataPaciente = ControladorPaciente::ctrMostrarPacienteAjax($itemPaciente, $valorPaciente);

//TRAER INFORMACION PRESTADOR
$tablaPrestador = "par_prestador";
$itemPrestador = "id_prestador";
$valorPrestador = $datosCuentasMedicas["id_prestador"];

$datosPrestador = ControladorPrestadores::ctrMostrarDato($tablaPrestador, $itemPrestador, $valorPrestador);

//DIAGNOSTICO
$dxFactura = ControladorCuentasMedicas::ctrValidaDX($datosCuentasMedicas["cie10"]);

if(empty($dxFactura)){

    $dxFactura["codigo"] = "NINGUNO";
    $dxFactura["descripcion"] = "NINGUNO";

}

//GLOSAS
$glosas = ControladorCuentasMedicas::ctrMostrarGlosas($valorCm);

/*===================================
SINTAXIS PDF
=====================================*/

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setTitle('PDF CUENTA MEDICA');

$pdf->startPageGroup();

$pdf->AddPage();

//$pdf->Image('../../vistas/img/plantilla/Logo_AGS.jpg', 20, 12, 20, '', '', '', '', false, 100);

date_default_timezone_set('America/Bogota');


$bloque1 = <<<EOF

    <table style="padding: 5px; text-align: center; font-size: 10px;">

        <thead>
        
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:70px; height:20px;"><img src="images/Ags_logo.png" style="height: 25px; width: 50px;"></td>
                <td style="border: 1px solid #666; background-color:#FFDFC5;text-align:center; width:400px; line-height: 25px;"><b>FACTURA</b></td>
                <td style="border: 1px solid #666; background-color:white; width:70px; height:20px;"><center><img src="images/positiva.jpeg" style="height: 25px; width: 30px;"></td>
            </tr>

        </thead>

    </table>
    <br>
    <br>
EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$bloque2 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>INFORMACIÓN PACIENTE</b></td>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td style="border: 1px solid #666; width:400px; height:20px;"><b>NOMBRE PACIENTE:</b> $dataPaciente[primer_nombre] $dataPaciente[segundo_nombre] $dataPaciente[primer_apellido] $dataPaciente[segundo_apellido]</td>
                <td style="border: 1px solid #666; width:140px; height:20px;"><b>DOCUMENTO:</b> $dataPaciente[tipo_documento] - $dataPaciente[numero_documento]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>GENERO:</b> $dataPaciente[genero]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>FECHA NACIMIENTO:</b> $dataPaciente[fecha_nacimiento]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>TELEFONO:</b> $dataPaciente[telefono]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>DIRECCION:</b> $dataPaciente[direccion]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>DEPARTAMENTO:</b> $dataPaciente[departamento]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>CIUDAD:</b> $dataPaciente[ciudad]</td>
            </tr>
        
        </tbody>

    </table>

    <br>
    <br>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

$bloque3 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>INFORMACIÓN FACTURA</b></td>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>ID FACTURA:</b> $datosCuentasMedicas[id_factura]</td>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>TRAMITE:</b> $datosCuentasMedicas[tramite]</td>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>TIPO AGS:</b> $datosCuentasMedicas[tipo_factura]</td>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>ESTADO:</b> $datosCuentasMedicas[estado]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>NUMERO FACTURA:</b> $datosCuentasMedicas[prefijo_factura] $datosCuentasMedicas[numero_factura]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA FACTURA:</b> $datosCuentasMedicas[fecha_factura]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA SERVICIO:</b> $datosCuentasMedicas[fecha_servicio]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>VALOR FACTURA:</b> $ $datosCuentasMedicas[valor_factura]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>VALOR IVA:</b> $ $datosCuentasMedicas[valor_iva]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>VALOR NOTA CREDITO:</b> $ $datosCuentasMedicas[valor_nota_credito]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>ID POSITIVA:</b> $datosCuentasMedicas[id_positiva]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>ID SINIESTRO:</b> $datosCuentasMedicas[id_siniestro]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA SINIESTRO:</b> $datosCuentasMedicas[fecha_siniestro]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>NOMBRE PROVEEDOR:</b> $datosPrestador[nombre]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>NUMERO PROVEEDOR:</b> $datosPrestador[tipo_numero] $datosPrestador[nit_completo]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>CIUDAD PROVEEDOR:</b> $datosPrestador[ciudad]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>DEPARTAMENTO PROVEEDOR:</b> $datosPrestador[departamento]</td>
            </tr>
        
        </tbody>

    </table>

    <br>
    <br>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

$bloque4 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>DIAGNOSTICO</b></td>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td style="border: 1px solid #666; width:200px; height:20px;"><b>CODIGO:</b> $dxFactura[codigo]</td>
                <td style="border: 1px solid #666; width:340px; height:20px;"><b>DESCRIPCION:</b> $dxFactura[descripcion]</td>
            </tr>
        </tbody>

    </table>

    <br>
    <br>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

$bloque5 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>GLOSAS</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

foreach ($glosas as $key => $valueGlosas) {

$valueGlosas["valor_factura"] = number_format($valueGlosas["valor_factura"], 2);
$valueGlosas["valor_glosa"] = number_format($valueGlosas["valor_glosa"], 2);
$valueGlosas["valor_pagar"] = number_format($valueGlosas["valor_pagar"], 2);
    
$bloque6 = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>TIPO AUDITORIA:</b> $valueGlosas[tipo_auditoria]</td>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>TIPO GLOSA:</b> $valueGlosas[tipo_glosa]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>VALOR FACTURA:</b> $ $valueGlosas[valor_factura]</td>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>VALOR GLOSA:</b> $ $valueGlosas[valor_glosa]</td>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>VALOR PAGAR:</b> $ $valueGlosas[valor_pagar]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;"><b>JUSTIFICACION:</b> $valueGlosas[justificacion]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>USUARIO GLOSA:</b> $valueGlosas[usuario_glosa]</td>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA GLOSA:</b> $valueGlosas[fecha_glosa]</td>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>ESTADO:</b> $valueGlosas[estado]</td>
        </tr>
    </table>
    
EOF;
    
$pdf->writeHTML($bloque6, false, false, false, false, '');
    
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

if($datoCm["observaciones_vencida"] != ""){

$bloque8 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>OBSERVACIONES GESTION VENCIDA</b></td>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td style="border: 1px solid #666; width:540px; height:20px;">$datoCm[observaciones_vencida]</td>
            </tr>
        </tbody>

    </table>

    <br>
    <br>

EOF;

$pdf->writeHTML($bloque8, false, false, false, false, '');

}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque9 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>TRAZABILIDAD FACTURA</b></td>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>NOMBRE AUDITOR:</b> $dataAuditor[nombre]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>USUARIO AUDITOR:</b> $dataAuditor[usuario]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>ID RADICACION:</b> $datoRadicacion[id_radicacion]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA CARGA RADICACION:</b> $datoRadicacion[fecha_crea]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA CARGA FACTURA:</b> $datoCm[fecha_crea]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>FECHA INICIO AUDITORIA:</b> $datoCm[fecha_ini]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>FECHA FIN AUDITORIA:</b> $datoCm[fecha_fin]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>FECHA PUBLICADA:</b> $datosCuentasMedicas[fecha_publicada]</td>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>FECHA MAX ANS:</b> $datosCuentasMedicas[fecha_publicada_max]</td>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>DIAS RESTANTES ANS:</b> $datosCuentasMedicas[dias_ans]</td>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>ESTADO:</b> $estadoPublicada</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>FECHA RADICACION:</b> $datosCuentasMedicas[fecha_radicacion]</td>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>FECHA MAX AUDITORIA:</b> $datosCuentasMedicas[fecha_radicacion_max]</td>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>DIAS RESTANTES AUDITORIAS:</b> $datosCuentasMedicas[dias_auditoria]</td>
                <td style="border: 1px solid #666; width:135px; height:20px;"><b>ESTADO:</b> $estadoRadicacion</td>
            </tr>
        </tbody>

    </table>

    <br>
    <br>

EOF;

$pdf->writeHTML($bloque9, false, false, false, false, '');


$pdf->Output('Cuenta Medica.pdf', 'I');


}


}

$pdfAcomp = new GenerarPdfCuentaMedica();
$pdfAcomp->idCuentaMedica = $_GET["idCuentaMedica"];
$pdfAcomp->pdfCuentaMedica();
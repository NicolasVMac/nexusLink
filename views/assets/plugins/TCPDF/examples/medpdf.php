<?php

/*===========================
CONTROLADORES
============================*/
require_once "../../../../controladores/paciente.controlador.php";
require_once "../../../../controladores/prestador.controlador.php";
require_once "../../../../controladores/usuarios.controlador.php";
require_once "../../../../controladores/interventoriamed.controlador.php";

/*===========================
MODELOS
============================*/
require_once "../../../../modelos/paciente.modelo.php";
require_once "../../../../modelos/prestador.modelo.php";
require_once "../../../../modelos/usuarios.modelo.php";
require_once "../../../../modelos/interventoriamed.modelo.php";


class GenerarPdfMedicamento{

public $idMedicamentoSolicitud;


public function pdfMedicamentoSolicitud(){


$idSolicitud = $this->idMedicamentoSolicitud;

$Seguimiento = ControladorInterventoriaMed::ctrInfoSeguimiento($idSolicitud);
$Medicamentos = ControladorInterventoriaMed::ctrMostrarMedicamentos($idSolicitud);


//TRAER INFORMACION AUDITOR
$itemAuditor = "usuario";
$valorAuditor = $Seguimiento["auditor"];

$dataAuditor = ControladorUsuarios::ctrMostrarUsuarios($itemAuditor, $valorAuditor);

//TRAER INFORMACION PACIENTE
$itemPaciente = "id_paciente";
$valorPaciente = $Seguimiento["id_paciente"];

$dataPaciente = ControladorPaciente::ctrMostrarPacienteAjax($itemPaciente, $valorPaciente);

//TRAER INFORMACION PRESTADOR
$tablaPrestador = "par_prestador";
$itemPrestador = "id_prestador";
$valorPrestador = $Seguimiento["id_prestador"];

$datosPrestador = ControladorPrestadores::ctrMostrarDato($tablaPrestador, $itemPrestador, $valorPrestador);


/*===================================
SINTAXIS PDF
=====================================*/

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setTitle('PDF MEDICAMENTO');

$pdf->startPageGroup();

$pdf->AddPage();

//$pdf->Image('../../vistas/img/plantilla/Logo_AGS.jpg', 20, 12, 20, '', '', '', '', false, 100);

date_default_timezone_set('America/Bogota');

$bloque1 = <<<EOF

    <table style="padding: 5px; text-align: center; font-size: 10px;">

        <thead>
        
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:70px; height:20px;"><img src="images/Ags_logo.png" style="height: 25px; width: 50px;"></td>
                <td style="border: 1px solid #666; background-color:#FFDFC5;text-align:center; width:400px; line-height: 25px;"><b>INTERVENTORIA MEDICAMENTO</b></td>
                <td style="border: 1px solid #666; background-color:white; width:70px; height:20px;"><center><img src="images/positiva.jpeg" style="height: 25px; width: 30px;"></td>
            </tr>

        </thead>

    </table>
    <br>
    <br>
EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$bloqueInfoConcurrencia = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>INFORMACIÓN INTERVENTORIA MEDICAMENTO</b></td>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>AUDITOR:</b> $dataAuditor[nombre]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>ESTADO:</b> $Seguimiento[estado]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>FECHA INICIA MEDICAMENTO:</b> $Seguimiento[fecha_ini]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>FECHA CIERRA MEDICAMENTO:</b> $Seguimiento[fecha_fin]</td>
            </tr>
        
        </tbody>

    </table>

    <br>
    <br>


EOF;

$pdf->writeHTML($bloqueInfoConcurrencia, false, false, false, false, '');

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
                <td style="border: 1px solid #666; width:230px; height:20px;"><b>GENERO:</b> $dataPaciente[genero]</td>
                <td style="border: 1px solid #666; width:170px; height:20px;"><b>FECHA NACIMIENTO:</b> $dataPaciente[fecha_nacimiento]</td>
                <td style="border: 1px solid #666; width:140px; height:20px;"><b>TELEFONO:</b> $dataPaciente[telefono]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px; height:20px;"><b>DIRECCION:</b> $dataPaciente[direccion]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:230px; height:20px;"><b>DEPARTAMENTO:</b> $dataPaciente[departamento]</td>
                <td style="border: 1px solid #666; width:310px; height:20px;"><b>CIUDAD:</b> $dataPaciente[ciudad]</td>
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
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>MEDICAMENTOS SOLICITADOS</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;


$pdf->writeHTML($bloqueBr, false, false, false, false, '');

foreach ($Medicamentos as $key => $valueMed) {

    
$bloque4 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:150px; height:20px;"><b>CODIGO:</b> $valueMed[procedimiento_codigo]</td>
            <td style="border: 1px solid #666; width:390px; height:20px;"><b>NOMBRE:</b> $valueMed[procedimiento_nombre]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:150px; height:20px;"><b>CANTIDAD:</b> $valueMed[procedimiento_cantidad]</td>
            <td style="border: 1px solid #666; width:390px; height:20px;"><b>JUSTIFICACION:</b> $valueMed[justificacion_clinica]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:150px; height:20px;"><b>SOLICITUD:</b> $valueMed[solicitud_estado]</td>
            <td style="border: 1px solid #666; width:195px; height:20px;"><b>SOLICITUD FECHA CREA:</b> $valueMed[solicitud_fecha_creacion]</td>
            <td style="border: 1px solid #666; width:195px; height:20px;"><b>SOLICITUD FECHA FIN:</b> $valueMed[solicitud_fecha_finalizacion]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>MOTIVO NIEGA:</b> $valueMed[motivo_negacion]</td>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>MOTIVO AUTORIZA:</b> $valueMed[motivo_autorizacion]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:150px; height:20px;"><b>SEGUIMIENTO 1:</b> $valueMed[primer_seg_fecha]</td>
            <td style="border: 1px solid #666; width:195px; height:20px;"><b>SEGUIMIENTO 2:</b> $valueMed[segundo_seg_fecha]</td>
            <td style="border: 1px solid #666; width:195px; height:20px;"><b>ESTADO:</b> $valueMed[estado]</td>
        </tr>
    </table>


EOF;
    
$pdf->writeHTML($bloque4, false, false, false, false, '');
    
    
}


$pdf->Output('Solicitud Medicamento.pdf', 'I');


}


}

$pdfMed = new GenerarPdfMedicamento();
$pdfMed->idMedicamentoSolicitud = $_GET["idSolicitud"];
$pdfMed->pdfMedicamentoSolicitud();
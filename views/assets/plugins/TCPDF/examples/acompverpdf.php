<?php

/*===================================
CONTROLADORES
=====================================*/


require_once "../../../../controladores/acompanamiento.controlador.php";
require_once "../../../../controladores/paciente.controlador.php";
require_once "../../../../controladores/prestador.controlador.php";
require_once "../../../../controladores/usuarios.controlador.php";

/*===================================
MODELOS
=====================================*/
require_once "../../../../modelos/acompanamiento.modelo.php";
require_once "../../../../modelos/paciente.modelo.php";
require_once "../../../../modelos/prestador.modelo.php";
require_once "../../../../modelos/usuarios.modelo.php";


class GenerarPdfAcompanamiento{

public $idAcompanamiento;


public function pdfAcompanamiento(){

/*===================================
CONSULTAS Y LOGICA PHP
=====================================*/
if($_SERVER["SERVER_NAME"] == "www.akee.com.co" || $_SERVER["SERVER_NAME"] == "54.39.49.44" || $_SERVER["SERVER_NAME"] == "localhost"){

    $rutaServer = "http://www.akee.com.co/";


}else{

    $rutaServer = "https://agssoftweb.com/";

}

//INFO ACOMPAÑAMIENTO
$tablaAcompanamiento = "acompanamiento";
$itemAcomp = "id_acompanamiento";
$valorAcomp = $this->idAcompanamiento;

$datosAcompanamiento = ControladorAcompanamiento::ctrBuscarDato($tablaAcompanamiento, $itemAcomp, $valorAcomp);

if($datosAcompanamiento["id_censo"] == "" || $datosAcompanamiento["id_censo"] == NULL){

    $estadoCenso = "NO";

}else{

    $estadoCenso = "SI";

}

//TRAER INFORMACION AUDITOR
$itemAuditor = "usuario";
$valorAuditor = $datosAcompanamiento["auditor"];

$dataAuditor = ControladorUsuarios::ctrMostrarUsuarios($itemAuditor, $valorAuditor);


//TRAER INFORMACION PACIENTE
$itemPaciente = "id_paciente";
$valorPaciente = $datosAcompanamiento["id_paciente"];

$dataPaciente = ControladorPaciente::ctrMostrarPacienteAjax($itemPaciente, $valorPaciente);

//TRAER INFORMACION PRESTADOR
$tablaPrestador = "par_prestador";
$itemPrestador = "id_prestador";
$valorPrestador = $datosAcompanamiento["id_ips"];

$datosPrestador = ControladorPrestadores::ctrMostrarDato($tablaPrestador, $itemPrestador, $valorPrestador);


//TRAER INFORMACION CONTRATO PRESTADOR
$tablaContratoPrestador = "par_prestador_contrato";
$itemContratoPrestador = "id_contrato";
$valorContratoPrestador = $datosAcompanamiento["id_ips_contrato"];

$datosContratoPrestador = ControladorPrestadores::ctrMostrarDato($tablaContratoPrestador, $itemContratoPrestador, $valorContratoPrestador);


//TRAER DIAGNOSTICOS INGRESO ACOMPAÑAMIENTO
$tipoDx = "INGRESO";
$idAcompanamiento = $this->idAcompanamiento;

$datosDx = ControladorAcompanamiento::ctrBuscarDx($tipoDx,$idAcompanamiento);

//TRAER SEGUIMIENTOS ACOMPAÑAMIENTO
$datosSegumientos = ControladorAcompanamiento::ctrBuscarSeguimiento($idAcompanamiento);

//TRAER DIAGNOSTICOS EGRESO ACOMPAÑAMIENTO
$itemEgresoDx = "id_acompanamiento";
$valorEgresoDx = $this->idAcompanamiento;

$datosDxEgreso = ControladorAcompanamiento::ctrDiagnosticoEgreso($itemEgresoDx, $valorEgresoDx);

$datosEventosAdversos = ControladorAcompanamiento::ctrBuscarEventoAdverso($idAcompanamiento);

$datosCalidad = ControladorAcompanamiento::ctrBuscarFalla($idAcompanamiento);

//TRAER EVOLUCIONES ACOMPAÑAMIENTO
$datosEvolucion = ControladorAcompanamiento::ctrBuscarEvolucion($idAcompanamiento);

//TRAER RESPUESTAS ENCUESTA ACOMPAÑAMIENTO
$datosEncuesta = ControladorAcompanamiento::ctrObtenerRespuestasAcompanamiento($idAcompanamiento);


/*===================================
SINTAXIS PDF
=====================================*/

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setTitle('PDF ACOMPAÑAMIENTO');

$pdf->startPageGroup();

$pdf->AddPage();

//$pdf->Image('../../vistas/img/plantilla/Logo_AGS.jpg', 20, 12, 20, '', '', '', '', false, 100);

date_default_timezone_set('America/Bogota');


$bloque1 = <<<EOF

    <table style="padding: 5px; text-align: center; font-size: 10px;">

        <thead>
        
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:70px; height:20px;"><img src="images/Ags_logo.png" style="height: 25px; width: 50px;"></td>
                <td style="border: 1px solid #666; background-color:#FFDFC5;text-align:center; width:400px; line-height: 25px;"><b>ACOMPAÑAMIENTO</b></td>
                <td style="border: 1px solid #666; background-color:white; width:70px; height:20px;"><center><img src="images/positiva.jpeg" style="height: 25px; width: 30px;"></td>
            </tr>

        </thead>

    </table>
    <br>
    <br>
EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$bloqueInfoAcompanamiento = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>INFORMACIÓN ACOMPAÑAMIENTO</b></td>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>CARGADO POR CENSO:</b> $estadoCenso</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>AUDITOR:</b> $dataAuditor[nombre]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>ESTADO:</b> $datosAcompanamiento[estado]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA CREACION ACOMPAÑAMIENTO:</b> $datosAcompanamiento[fecha_crea]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA INICIA ACOMPAÑAMIENTO:</b> $datosAcompanamiento[fecha_ini]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA CIERRA ACOMPAÑAMIENTO:</b> $datosAcompanamiento[fecha_fin]</td>
            </tr>
        
        </tbody>

    </table>

    <br>
    <br>


EOF;

$pdf->writeHTML($bloqueInfoAcompanamiento, false, false, false, false, '');

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
                <td style="border: 1px solid #666; width:140px; height:20px;"><b>EDAD:</b> $datosAcompanamiento[edad_n] $datosAcompanamiento[edad_t]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:230px; height:20px;"><b>GRUPO ETAREO:</b> $datosAcompanamiento[grupo_etario]</td>
                <td style="border: 1px solid #666; width:310px; height:20px;"><b>TELEFONO:</b> $dataPaciente[telefono]</td>
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
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>INFORMACIÓN INGRESO</b></td>
            </tr>

        </thead>

        <tbody>

            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>NUMERO SINIESTRO:</b> $datosAcompanamiento[num_siniestro]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>CALIFICACION ORIGEN:</b> $datosAcompanamiento[calificacion_origen_siniestro]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>RAZON SOCIAL EMPLEADOR:</b> $datosAcompanamiento[nombre_empleador]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>NIT EMPLEADOR:</b> $datosAcompanamiento[nit_empleador]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>IPS HOSPITALIZACION:</b> $datosPrestador[nombre]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>NIT IPS HOSPITALIZACIÓN:</b> $datosPrestador[nit_completo]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA INGRESO:</b> $datosAcompanamiento[fecha_ingreso]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>REINGRESO:</b> $datosAcompanamiento[reingreso]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>ESPECIALIDAD TRATANTE:</b> $datosAcompanamiento[especialidad_tratante]</td>
            </tr>

        </tbody>

    </table>


EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque4 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>DIAGNOSTICOS DE INGRESO</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

foreach ($datosDx as $key => $valueDx) {

if($valueDx["ingreso_egreso"] == "INGRESO"){

$bloque5 = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:100px; height:20px;"><b>CIE10:</b> $valueDx[cie10]</td>
            <td style="border: 1px solid #666; width:440px; height:20px;"><b>DESCRIPCION:</b> $valueDx[descripcion]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:100px; height:20px;"><b>TIPO:</b> $valueDx[tipo]</td>
            <td style="border: 1px solid #666; width:340px; height:20px;"><b>OBSERVACION:</b> $valueDx[observacion]</td>
            <td style="border: 1px solid #666; width:100px; height:20px;"><b>REINGRESO:</b> $valueDx[reingreso]</td>
        </tr>
    </table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

}

}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque4 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>EVENTOS ADVERSOS</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

foreach ($datosEventosAdversos as $key => $valueEventosAdversos) {

    
    $bloqueEventoAdverso = <<<EOF
        
        <table style="padding: 5px; text-align: left; font-size: 8px;">
            <tr>
                <td style="border: 1px solid #666; width:420px; height:20px;"><b>EVENTO:</b> $valueEventosAdversos[evento]</td>
                <td style="border: 1px solid #666; width:120px; height:20px;"><b>FECHA EVENTO:</b> $valueEventosAdversos[fecha_evento]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:420px; height:20px;"><b>OBSERVACIONES:</b> $valueEventosAdversos[observacion]</td>
                <td style="border: 1px solid #666; width:120px; height:20px;"><b>VALOR:</b> $valueEventosAdversos[valor]</td>
            </tr>
        </table>
    
    EOF;
    
$pdf->writeHTML($bloqueEventoAdverso, false, false, false, false, '');
        
        
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloqueFallas = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>CALIDAD</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloqueFallas, false, false, false, false, '');

foreach ($datosCalidad as $key => $valueCalidad) {

    
    $bloque19 = <<<EOF
    
        <table style="padding: 5px; text-align: left; font-size: 8px;">
            <tr>
                <td style="border: 1px solid #666; width:400px; height:20px;"><b>TIPO FALLA:</b> $valueCalidad[falla]</td>
                <td style="border: 1px solid #666; width:140px; height:20px;"><b>FECHA FALLA:</b> $valueCalidad[fecha_falla]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:540px; height:20px;"><b>OBSERVACION:</b> $valueCalidad[observacion]</td>
            </tr>
        </table>
    
    
    EOF;
                
    $pdf->writeHTML($bloque19, false, false, false, false, '');
                    
                    
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque6 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>SEGUIMIENTOS</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

foreach ($datosSegumientos as $key => $valueSeguimientos) {

    
$bloque7 = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>TIPO:</b> $valueSeguimientos[tipo]</td>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>DESCRIPCION:</b> $valueSeguimientos[descripcion]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;"><b>OBSERVACIONES:</b> $valueSeguimientos[observacion]</td>
        </tr>
    </table>

EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');
    
    
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque8 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>EGRESO</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque8, false, false, false, false, '');

if(!empty($datosDxEgreso)){

$bloque9 = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>CONDICION DE ALTA:</b> $datosAcompanamiento[condicion_alta]</td>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>FECHA EGRESO:</b> $datosAcompanamiento[fecha_egreso]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>TIPO ACOMPAÑAMIENTO:</b> $datosAcompanamiento[tipo_acompanamiento]</td>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>CAUSAL TIPO ACOMPAÑAMIENTO:</b> $datosAcompanamiento[causal_tipo_acomp]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>MATRICULA REHABILITACION:</b> $datosAcompanamiento[matricula_rehabilitacion]</td>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>QUIEN MATRICULA REHABILITACION:</b> $datosAcompanamiento[quien_matricula_rehabilitacion]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>ANEXO 3:</b> $datosAcompanamiento[anexo3]</td>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>CAUSAL ANEXO 3:</b> $datosAcompanamiento[causal_anexo3]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;"><b>DIAGNOSTICO EGRESO:</b> $datosDxEgreso[cie10] - $datosDxEgreso[descripcion]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;"><b>OBSERVACIONES:</b> $datosAcompanamiento[observacion_egreso]</td>
        </tr>
    </table>

EOF;

$pdf->writeHTML($bloque9, false, false, false, false, '');

}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque10 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>BITACORA</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque10, false, false, false, false, '');

foreach ($datosEvolucion as $key => $valueEvolucion) {

    
$bloque11 = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;"><b>OBSERVACIONES:</b> $valueEvolucion[observacion]</td>
        </tr>
    </table>

EOF;

$pdf->writeHTML($bloque11, false, false, false, false, '');
    
    
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque12 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>RESULTADO ENCUESTA</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque12, false, false, false, false, '');

foreach ($datosEncuesta as $key => $valueEncuesta) {

if($valueEncuesta["descripcion"] != "OBSERVACIONES"){
    
$bloque13 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:400px; height:20px;"><b>PREGUNTA:</b> $valueEncuesta[descripcion]</td>
            <td style="border: 1px solid #666; width:140px; height:20px;"><b>RESPUESTA:</b> $valueEncuesta[respuesta]</td>
        </tr>
    </table>


EOF;
            
$pdf->writeHTML($bloque13, false, false, false, false, '');

}else{

$bloque14 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:200px; height:20px;"><b>PREGUNTA:</b> $valueEncuesta[descripcion]</td>
            <td style="border: 1px solid #666; width:340px; height:20px;"><b>RESPUESTA:</b> $valueEncuesta[respuesta]</td>
        </tr>
    </table>


EOF;
            
$pdf->writeHTML($bloque14, false, false, false, false, '');


}

}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');


//$pdfPath = "../../../../".$datosAcompanamiento["ruta_archivo_anexo3"];

$pdfPath = $datosAcompanamiento["ruta_archivo_anexo3"];

$pdfString = substr($pdfPath, 3);

$rutaCompleta = $rutaServer.$pdfString;

if(!empty($datosAcompanamiento["ruta_archivo_anexo3"])){

$bloque15 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;"><b>ANEXO 3</b></td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;"><a href="$rutaCompleta" target="_blank"> VER ANEXO 3</a></td>
        </tr>
    </table>


EOF;


$pdf->writeHTML($bloque15, false, false, false, false, '');


}else{

$bloque16 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;"><b>ANEXO 3</b></td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;">NO HAY ANEXO 3 ADJUNTO</td>
        </tr>
    </table>


EOF;

$pdf->writeHTML($bloque16, false, false, false, false, '');


}


$pdf->Output('Acompañamiento.pdf', 'I');


}


}

$pdfAcomp = new GenerarPdfAcompanamiento();
$pdfAcomp->idAcompanamiento = $_GET["idAcompanamiento"];
$pdfAcomp->pdfAcompanamiento();
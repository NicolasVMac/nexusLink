<?php

/*===================================
CONTROLADORES
=====================================*/
require_once "../../../../controladores/concurrencia.controlador.php";
require_once "../../../../controladores/paciente.controlador.php";
require_once "../../../../controladores/prestador.controlador.php";
require_once "../../../../controladores/usuarios.controlador.php";

/*===================================
MODELOS
=====================================*/
require_once "../../../../modelos/concurrencia.modelo.php";
require_once "../../../../modelos/paciente.modelo.php";
require_once "../../../../modelos/prestador.modelo.php";
require_once "../../../../modelos/usuarios.modelo.php";


class GenerarPdfConcurrencia{

public $idConcurrencia;

public function pdfConcurrencia(){

/*===================================
CONSULTAS Y LOGICA PHP
=====================================*/

//TRAER INFORMACION CONCURRENCIA
$itemConcurrencia = "id_concurrencia";
$valorConcurrencia = $this->idConcurrencia;

$dataConcurrencia = ControladorConcurrencia::ctrMostrarConcurrencia($itemConcurrencia, $valorConcurrencia);

if($dataConcurrencia["id_censo"] == "" || $dataConcurrencia["id_censo"] == NULL){

    $estadoCenso = "NO";

}else{

    $estadoCenso = "SI";

}

//TRAER INFORMACION AUDITOR
$itemAuditor = "usuario";
$valorAuditor = $dataConcurrencia["auditor"];

$dataAuditor = ControladorUsuarios::ctrMostrarUsuarios($itemAuditor, $valorAuditor);

//TRAER INFORMACION PACIENTE
$itemPaciente = "id_paciente";
$valorPaciente = $dataConcurrencia["id_paciente"];

$dataPaciente = ControladorPaciente::ctrMostrarPacienteAjax($itemPaciente, $valorPaciente);

//TRAER INFORMACION PRESTADOR
$tablaPrestador = "par_prestador";
$itemPrestador = "id_prestador";
$valorPrestador = $dataConcurrencia["id_ips"];

$datosPrestador = ControladorPrestadores::ctrMostrarDato($tablaPrestador, $itemPrestador, $valorPrestador);

//TRAER INFORMACION CONTRATO PRESTADOR
$tablaContratoPrestador = "par_prestador_contrato";
$itemContratoPrestador = "id_contrato";
$valorContratoPrestador = $dataConcurrencia["id_ips_contrato"];

$datosContratoPrestador = ControladorPrestadores::ctrMostrarDato($tablaContratoPrestador, $itemContratoPrestador, $valorContratoPrestador);


//TRAER DIAGNOSTICOS CONCURRENCIA
$tablaDx = "concurrencia_dx";
$itemDx = "id_concurrencia";
$valorDx = $this->idConcurrencia;

$datosDx = ControladorConcurrencia::ctrBuscarDatoAll($tablaDx, $itemDx, $valorDx);


//TRAER INFORMACION ESTANCIAS
$idConcurrencia = $this->idConcurrencia;

$datosEstancia = ControladorConcurrencia::ctrBuscarEstancia($idConcurrencia);

//TRAER INFORMACION ESTANCIA
$datosAntecedentes = ControladorConcurrencia::ctrBuscarAntecedente($idConcurrencia);


//TRAER INFORMACION SERVICIOS
$datosServicios = ControladorConcurrencia::ctrBuscarServicio($idConcurrencia);


//TRAER INFORMACION EVENTOS ADVERSOS
$datosEventosAdversos = ControladorConcurrencia::ctrBuscarEventoAdverso($idConcurrencia);

//TRAER INFORMACION OTROS EVENTOS
$datosEventosOtros = ControladorConcurrencia::ctrBuscarOtroEvento($idConcurrencia);

//TRAER INFORMACION FUGAS
$datosFugas = ControladorConcurrencia::ctrBuscarFuga($idConcurrencia);

//TRAER INFORMACION CALIDAD
$datosCalidad = ControladorConcurrencia::ctrBuscarFalla($idConcurrencia);

//TRAER INFORMACION ACCESIBILIDAD Y OPORTUNIDAD
$datosAcceOpor = ControladorConcurrencia::ctrBuscarAceopor($idConcurrencia);

//TRAER INFORMACION GLOSAS
$datosGlosas = ControladorConcurrencia::ctrBuscarGlosa($idConcurrencia);

//TRAER INFORMACION COSTO EVITADO
$datosCostosEvitados = ControladorConcurrencia::ctrBuscarCostoEvitado($idConcurrencia);

//TRAER INFORMACION DX EGRESO
$datosDxEgreso = ControladorConcurrencia::ctrMostrarDxEgreso($idConcurrencia);

//TRAER INFORMACION EVOLUCIONES
$datosEvolucion = ControladorConcurrencia::ctrBuscarEvolucion($idConcurrencia);


//TRAER INFORMACION ENCUESTA
$datosEncuesta = ControladorConcurrencia::ctrObtenerRespuestasEncuestaConcurrencia($idConcurrencia);


/*===================================
SINTAXIS PDF
=====================================*/

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setTitle('PDF CONCURRENCIA');

$pdf->startPageGroup();

$pdf->AddPage();

//$pdf->Image('../../vistas/img/plantilla/Logo_AGS.jpg', 20, 12, 20, '', '', '', '', false, 100);

date_default_timezone_set('America/Bogota');


$bloque1 = <<<EOF

    <table style="padding: 5px; text-align: center; font-size: 10px;">

        <thead>
        
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:70px; height:20px;"><img src="images/Ags_logo.png" style="height: 25px; width: 50px;"></td>
                <td style="border: 1px solid #666; background-color:#FFDFC5;text-align:center; width:400px; line-height: 25px;"><b>CONCURRENCIA</b></td>
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
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>INFORMACIÓN CONCURRENCIA</b></td>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>CARGADO POR CENSO:</b> $estadoCenso</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>AUDITOR:</b> $dataAuditor[nombre]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>ESTADO:</b> $dataConcurrencia[estado]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA CREACION CONCURRENCIA:</b> $dataConcurrencia[fecha_crea]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA INICIA CONCURRENCIA:</b> $dataConcurrencia[fecha_ini]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA CIERRA CONCURRENCIA:</b> $dataConcurrencia[fecha_fin]</td>
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
                <td style="border: 1px solid #666; width:140px; height:20px;"><b>EDAD:</b> $dataConcurrencia[edad_n] $dataConcurrencia[edad_t]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:230px; height:20px;"><b>GRUPO ETAREO:</b> $dataConcurrencia[grupo_etario]</td>
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
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>NUMERO HC:</b> $dataConcurrencia[num_hc]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>NUMERO SINIESTRO:</b> $dataConcurrencia[num_siniestro]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>CALIFICACION ORIGEN:</b> $dataConcurrencia[calificacion_origen_siniestro]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>ORIGEN SERVICIO:</b> $dataConcurrencia[origen_servicio]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>SEVERIDAD NIVEL:</b> $dataConcurrencia[nivel_severidad]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>RAZON SOCIAL EMPLEADOR:</b> $dataConcurrencia[nombre_empleador]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>NIT EMPLEADOR:</b> $dataConcurrencia[nit_empleador]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>IPS HOSPITALIZACION:</b> $datosPrestador[nombre]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>NIT IPS HOSPITALIZACIÓN:</b> $datosPrestador[nit_completo]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>FECHA INGRESO:</b> $dataConcurrencia[fecha_ingreso]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>VIA INGRESO:</b> $dataConcurrencia[via_ingreso]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>REINGRESO:</b> $dataConcurrencia[reingreso]</td>
                <td style="border: 1px solid #666; width:270px; height:20px;"><b>CAUSAL REINGRESO:</b> $dataConcurrencia[causal_reingreso]</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>CAUSA HOSPITALIZACION:</b> $dataConcurrencia[causa_hospitalizacion]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>ESPECIALIDAD TRATANTE:</b> $dataConcurrencia[especialidad_tratante]</td>
                <td style="border: 1px solid #666; width:180px; height:20px;"><b>COHORTE:</b> $dataConcurrencia[cohorte]</td>
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
            <td style="border: 1px solid #666; width:440px; height:20px;"><b>OBSERVACION:</b> $valueDx[observacion]</td>
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

$bloque6 = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>ESTANCIAS</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

foreach ($datosEstancia as $key => $valueEstancia) {

    
$bloque7 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:160px; height:20px;"><b>ESTANCIA:</b> $valueEstancia[estancia]</td>
            <td style="border: 1px solid #666; width:190px; height:20px;"><b>FECHA - HORA INGRESO:</b> $valueEstancia[fecha_ingreso] $valueEstancia[hora_ingreso]</td>
            <td style="border: 1px solid #666; width:190px; height:20px;"><b>FECHA - HORA EGRESO:</b> $valueEstancia[fecha_egreso] $valueEstancia[hora_egreso]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:350px; height:20px;"><b>OBSERVACIONES:</b> $valueEstancia[observacion]</td>
            <td style="border: 1px solid #666; width:190px; height:20px;"><b>ESTADO:</b> $valueEstancia[estado]</td>
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
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>ANTECEDENTES</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque8, false, false, false, false, '');

foreach ($datosAntecedentes as $key => $valueAntecedente) {

    
$bloque9 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>ANTECEDENTE:</b> $valueAntecedente[antecedente]</td>
            <td style="border: 1px solid #666; width:360px; height:20px;"><b>DETALLE:</b> $valueAntecedente[observacion]</td>
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
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>SERVICIOS</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque10, false, false, false, false, '');

foreach ($datosServicios as $key => $valueServicios) {

    
$bloque11 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:90px; height:20px;"><b>TIPO:</b> $valueServicios[tipo]</td>
            <td style="border: 1px solid #666; width:110px; height:20px;"><b>CODIGO:</b> $valueServicios[codigo]</td>
            <td style="border: 1px solid #666; width:340px; height:20px;"><b>DESCRIPCION:</b> $valueServicios[descripcion]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;"><b>OBSERVACION:</b> $valueServicios[observacion]</td>
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
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>EVENTOS ADVERSOS</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque12, false, false, false, false, '');

foreach ($datosEventosAdversos as $key => $valueEventosAdversos) {

    
$bloque13 = <<<EOF

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
            
$pdf->writeHTML($bloque13, false, false, false, false, '');
                
                
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;


$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque14 = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>EVENTOS OTRO</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque14, false, false, false, false, '');

foreach ($datosEventosOtros as $key => $valueEventosOtros) {

    
$bloque15 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:310px; height:20px;"><b>CLASIFICACION:</b> $valueEventosOtros[tipo_evento]</td>
            <td style="border: 1px solid #666; width:230px; height:20px;"><b>EVENTO:</b> $valueEventosOtros[descripcion]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:310px; height:20px;"><b>OBSERVACIONES:</b> $valueEventosOtros[observacion]</td>
            <td style="border: 1px solid #666; width:230px; height:20px;"><b>FECHA EVENTO:</b> $valueEventosOtros[fecha_evento]</td>
        </tr>
    </table>


EOF;
            
$pdf->writeHTML($bloque15, false, false, false, false, '');
                
                
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque16 = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>FUGAS</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque16, false, false, false, false, '');

foreach ($datosFugas as $key => $datosFugas) {

    
$bloque17 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>TIPO FUGA:</b> $datosFugas[clasificacion]</td>
            <td style="border: 1px solid #666; width:140px; height:20px;"><b>FECHA RADICACION:</b> $datosFugas[fecha_radicacion]</td>
            <td style="border: 1px solid #666; width:130px; height:20px;"><b>FECHA CIERRE:</b> $datosFugas[fecha_cierre]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>OBSERVACION:</b> $datosFugas[observacion]</td>
            <td style="border: 1px solid #666; width:140px; height:20px;"><b>VALOR:</b> $datosFugas[valor]</td>
            <td style="border: 1px solid #666; width:130px; height:20px;"><b>ESTADO:</b> $datosFugas[estado_fuga]</td>
        </tr>
    </table>


EOF;
            
$pdf->writeHTML($bloque17, false, false, false, false, '');
                
                
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque18 = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>CALIDAD</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque18, false, false, false, false, '');


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

$bloque20 = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>ACCESIBILIDAD Y OPORTUNIDAD</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque20, false, false, false, false, '');

foreach ($datosAcceOpor as $key => $valueAcceOpor) {

    
$bloque21 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:140px; height:20px;"><b>TIPO:</b> $valueAcceOpor[tipo]</td>
            <td style="border: 1px solid #666; width:400px; height:20px;"><b>OBSERVACION:</b> $valueAcceOpor[observacion]</td>
        </tr>
    </table>


EOF;
            
$pdf->writeHTML($bloque21, false, false, false, false, '');
                
                
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque22 = <<<EOF
    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>GLOSAS</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque22, false, false, false, false, '');

foreach ($datosGlosas as $key => $valueGlosas) {
    
$bloque23 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>TIPO:</b> $valueGlosas[tipo]</td>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>DESCRIPCION:</b> $valueGlosas[descripcion]</td>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>CONCEPTO:</b> $valueGlosas[glosa_concepto]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>TIPO:</b> $valueGlosas[glosa_tipo]</td>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>DETALLE:</b> $valueGlosas[glosa_detalle]</td>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>VALOR:</b> $valueGlosas[valor]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;"><b>OBSERVACION:</b> $valueGlosas[observacion]</td>
        </tr>
    </table>


EOF;
            
$pdf->writeHTML($bloque23, false, false, false, false, '');
                
                
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque24 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>COSTO EVITADO</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque24, false, false, false, false, '');

foreach ($datosCostosEvitados as $key => $valueCostoEvitado) {
    
$bloque25 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:400px; height:20px;"><b>TIPO:</b> $valueCostoEvitado[tipo]</td>
            <td style="border: 1px solid #666; width:140px; height:20px;"><b>VALOR:</b> $valueCostoEvitado[valor]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;"><b>OBSERVACION:</b> $valueCostoEvitado[observacion]</td>
        </tr>
    </table>


EOF;
            
$pdf->writeHTML($bloque25, false, false, false, false, '');
                
                
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque26 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>EGRESO</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque26, false, false, false, false, '');

if(!empty($datosDxEgreso)){

$bloque27 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>CONDICION DE ALTA:</b> $dataConcurrencia[condicion_alta]</td>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>FECHA EGRESO:</b> $dataConcurrencia[fecha_egreso]</td>
            <td style="border: 1px solid #666; width:180px; height:20px;"><b>DIAS ESTANCIA:</b> $dataConcurrencia[dias_estancia]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>DIAGNOSTICO:</b> $datosDxEgreso[cie10] - $datosDxEgreso[descripcion]</td>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>POSIBLE INVALIDEZ:</b> $dataConcurrencia[invalidez]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:270pxpx; height:20px;"><b>MATRICULA REHABILITACION:</b> $dataConcurrencia[matricula_rehabilitacion]</td>
            <td style="border: 1px solid #666; width:270pxpx; height:20px;"><b>QUIEN MATRICULA REHABILITACION:</b> $dataConcurrencia[quien_matricula_rehabilitacion]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:270pxpx; height:20px;"><b>TIPO CONCURRENCIA:</b> $dataConcurrencia[tipo_concurrencia]</td>
            <td style="border: 1px solid #666; width:270pxpx; height:20px;"><b>CAUSAL TIPO CONCURRENCIA:</b> $dataConcurrencia[causal_virtual]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;"><b>OBSERVACION:</b> $dataConcurrencia[observacion_egreso]</td>
        </tr>
    </table>

EOF;

$pdf->writeHTML($bloque27, false, false, false, false, '');

}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque28 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>EVOLUCIONES</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque28, false, false, false, false, '');

foreach ($datosEvolucion as $key => $valueEvolucion) {
    
$bloque29 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>TIPO CONCURRENCIA:</b> $valueEvolucion[tipo_concurrencia]</td>
            <td style="border: 1px solid #666; width:270px; height:20px;"><b>CAUSAL TIPO CONCURRENCIA:</b> $valueEvolucion[causal_virtual]</td>
        </tr>
        <tr>
            <td style="border: 1px solid #666; width:540px; height:20px;"><b>OBSERVACIONES:</b> $valueEvolucion[observacion]</td>
        </tr>
    </table>


EOF;
            
$pdf->writeHTML($bloque29, false, false, false, false, '');
                
                
}

$bloqueBr = <<<EOF

    <br>
    <br>

EOF;

$pdf->writeHTML($bloqueBr, false, false, false, false, '');

$bloque29 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">

        <thead>

            <tr>
                <td style="border: 1px solid #666; background-color:#FFDFC5; text-align:center; width:540px; line-height: 25px;" colspan="2"><b>RESULTADO ENTREVISTA</b></td>
            </tr>

        </thead>

    </table>

EOF;

$pdf->writeHTML($bloque29, false, false, false, false, '');


foreach ($datosEncuesta as $key => $valueEncuesta) {

if($valueEncuesta["descripcion"] != "OBSERVACIONES"){
    
$bloque30 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:400px; height:20px;"><b>PREGUNTA:</b> $valueEncuesta[descripcion]</td>
            <td style="border: 1px solid #666; width:140px; height:20px;"><b>RESPUESTA:</b> $valueEncuesta[respuesta]</td>
        </tr>
    </table>


EOF;
            
$pdf->writeHTML($bloque30, false, false, false, false, '');

}else{

$bloque31 = <<<EOF

    <table style="padding: 5px; text-align: left; font-size: 8px;">
        <tr>
            <td style="border: 1px solid #666; width:200px; height:20px;"><b>PREGUNTA:</b> $valueEncuesta[descripcion]</td>
            <td style="border: 1px solid #666; width:340px; height:20px;"><b>RESPUESTA:</b> $valueEncuesta[respuesta]</td>
        </tr>
    </table>


EOF;
            
$pdf->writeHTML($bloque31, false, false, false, false, '');


}

}


$pdf->Output('Concurrencia.pdf', 'I');

}

}

$pdfConcu = new GenerarPdfConcurrencia();
$pdfConcu->idConcurrencia = $_GET["idConcurrencia"];
$pdfConcu->pdfConcurrencia();
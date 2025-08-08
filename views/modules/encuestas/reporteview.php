<?php 
$tipoEncuesta = base64_decode($_GET["tipoEncuesta"]); 
$rutaReporte = base64_decode($_GET["rutaReporte"]);
?>

<?php 
echo $rutaReporte;
?>

<?php 

    if($tipoEncuesta == 'VIH'){

        if(
            $rutaReporte == "reportconsolidadoepsvih" ||
            $rutaReporte == "reportconsolidadogpintervih" ||
            $rutaReporte == "reportfrecuenciasvih" ||
            $rutaReporte == "reportatencionpacnuevosvih" ||
            $rutaReporte == "reportconsolidadoddatosidenvih" ||
            $rutaReporte == "reportconsolidadomedexpertovih" ||
            $rutaReporte == "reportconsolidadoinfectologovih" ||
            $rutaReporte == "reportinstrumentosvih" ||
            $rutaReporte == "reportindicadores1vih" ||
            $rutaReporte == "reportindicadores2vih" ||
            $rutaReporte == "reportconsomedespvih" ||
            $rutaReporte == "reportconsoproespvih" ||
            $rutaReporte == "reportconsoinstruprovih" ||
            $rutaReporte == "reportgeneralvih" ||
            $rutaReporte == "reportconsocalifisegmentovih"
        ){

            include "reportes-vih/".$rutaReporte.".php";
            // include "reportes-vih/reportconsolidadoepsvih.php";

        }


    }else if($tipoEncuesta == 'AUTOINMUNES'){

        if(
            $rutaReporte == "reportconsolidadoauto" ||
            $rutaReporte == "reportconsolidadogeneralauto" ||
            $rutaReporte == "reportfrecuenciasauto" ||
            $rutaReporte == "reportcumpligrupointerauto" ||
            $rutaReporte == "reportconsolidadodatosidenauto" ||
            $rutaReporte == "reporttratamientoforauto" ||
            $rutaReporte == "reportconsolidadomedgenauto" ||
            $rutaReporte == "reportconsolidadoreumaauto" ||
            $rutaReporte == "reportconsolidadomedintauto" ||
            $rutaReporte == "reportconsolidadomedfamauto" ||
            $rutaReporte == "reportinstrumentosauto" ||
            $rutaReporte == "reportindicadores1auto" ||
            $rutaReporte == "reportconsomedespauto" ||
            $rutaReporte == "reportconsoproespauto" ||
            $rutaReporte == "reportconsoinstruproauto" ||
            $rutaReporte == "reportgeneralautoinmunes" ||
            $rutaReporte == "reportconsocalifisegmentoauto"
        ){

            include "reportes-autoinmunes/".$rutaReporte.".php";
            
        }


    }


?>
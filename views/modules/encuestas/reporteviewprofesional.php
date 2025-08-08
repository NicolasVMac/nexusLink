<?php 
$rutaReporte = base64_decode($_GET["rutaReporte"]);
?>

<?php 

    if(
        $rutaReporte == "reportconsomedespvih" ||
        $rutaReporte == "reportconsootrasesp" ||
        $rutaReporte == "reportconsoresulaud" ||
        $rutaReporte == "reportconsomedespvihpro" ||
        $rutaReporte == "reportconsootrasesppro"
    ){

        include "reportes-profesional/".$rutaReporte.".php";
        // include "reportes-vih/reportconsolidadoepsvih.php";

    }



?>
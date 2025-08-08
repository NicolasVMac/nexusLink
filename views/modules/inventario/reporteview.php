<?php 
$rutaReporte = base64_decode($_GET["rutaReporte"]);
?>

<?php 
echo $rutaReporte;
?>

<?php 

    if(
        $rutaReporte == "reportcalendariobiomedico"
    ){

        include "reportes/".$rutaReporte.".php";
        // include "reportes-vih/reportconsolidadoepsvih.php";

    }


?>
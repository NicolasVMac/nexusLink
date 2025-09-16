<?php 
$rutaReporte = base64_decode($_GET["rutaReporte"]);
?>

<?php 
echo $rutaReporte;
?>

<?php 

    if(
        $rutaReporte == "estadoprocesopagadores"
    ){

        include "reportes-pagadores/".$rutaReporte.".php";
        // include "reportes-vih/reportconsolidadoepsvih.php";

    }


?>
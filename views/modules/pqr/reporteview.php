<?php 
$rutaReporte = base64_decode($_GET["rutaReporte"]);
?>

<?php 

    if(
        $rutaReporte == "reportestadistica1" ||
        $rutaReporte == "reportestadistica2" ||
        $rutaReporte == "reportestadistica3" ||
        $rutaReporte == "reportestadoproceso" ||
        $rutaReporte == "reportelistapqrsf"
    ){

        include "reportes/".$rutaReporte.".php";
        // include "reportes-vih/reportconsolidadoepsvih.php";

    }


?>
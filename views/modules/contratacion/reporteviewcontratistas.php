<?php 
$rutaReporte = base64_decode($_GET["rutaReporte"]);
?>

<?php 
echo $rutaReporte;
?>

<?php 

    if(
        $rutaReporte == "estadoprocesocontratistas"
    ){

        include "reportes-contratistas/".$rutaReporte.".php";
        // include "reportes-vih/reportconsolidadoepsvih.php";

    }


?>
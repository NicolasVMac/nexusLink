<?php 
$rutaReporte = base64_decode($_GET["rutaReporte"]);
?>

<?php 
// echo "Ruta Reporte:" . $rutaReporte;
?>

<?php 

    if(
        $rutaReporte == "reportellamadas" ||
        $rutaReporte == "reportebases" ||
        $rutaReporte == "reporteregimenbase" ||
        $rutaReporte == "reporteproducprofesionales" ||
        $rutaReporte == "reporteefecfallirepro" ||
        $rutaReporte == "reporteatencohorte" ||
        $rutaReporte == "reportedetalledi"
    ){

        include "reportes-agendamiento/".$rutaReporte.".php";
        // include "reportes-vih/reportconsolidadoepsvih.php";

    }


?>
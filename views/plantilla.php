<?php
date_default_timezone_set('America/Bogota');
session_start();
$hoy = date("Y-m-d");
$hoyTime = date("Y-m-d 23:59:59");
$anio = date("Y");
$ApiKey = ModelParametricas::mdlMostrarParametros('GOOGLEMAPS', 'ApiKey');

?>
<!DOCTYPE html>
<html lang="es-ES" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msapplication-TileImage" content="views/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>NexuxLink</title>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="icon" type="image/jpg" href="views/assets/img/logo.ico"/>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="views/assets/css/user.css" type="text/css" rel="stylesheet">
    <link href="views/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="plugins/toatsr/toastr.min.css" type="text/css" rel="stylesheet" id="style-default">

    <!--DataTables -->
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" type="text/css" rel="stylesheet" id="style-default">-->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!-- Select2 -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- FullCalendar -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

    <!-- Estilos Highcharts -->
    <link rel="stylesheet" href="plugins/highcharts/code/css/highcharts.css">

    <link href="plugins/choices/choices.min.css" rel="stylesheet" />


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=<?= $ApiKey["valor"] ?>&libraries=&v=weekly&channel=2"></script> -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=<?= $ApiKey["valor"] ?>&v=weekly"
      defer
    ></script>
    <!-- FullCalendar -->
    <script src="plugins/fullcalendar/dist/index.global.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.10/index.global.min.js'></script>
    <!-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/locale/es.js'></script> -->
    <script src="views/assets/js/config.js"></script>
    <script src="views/assets/popper/popper.min.js"></script>
    <script src="views/assets/bootstrap/bootstrap.min.js"></script>
    <script src="views/assets/fontawesome/all.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="plugins/toatsr/toastr.min.js"></script>
    <script src="plugins/choices/choices.min.js"></script>
    <!-- CKEDITOR -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <!--DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
    <script src="//cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!--Select2-->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Sweeralert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- HighCharts -->
    <script src="plugins/highcharts/code/highcharts.js"></script>
    <script src="plugins/highcharts/code/highcharts-more.js"></script>
    <script src="plugins/highcharts/code/modules/exporting.js"></script>
    <script src="plugins/highcharts/code/modules/export-data.js"></script>
    <script src="plugins/highcharts/code/modules/accessibility.js"></script>
    

    <!-- <script src="views/assets/js/phoenix.js"></script> -->

    <!-- JavaScript Propios -->
    <script>
        var userSession = "<?php echo $_SESSION["usuario"]; ?>";
        var userName = "<?php echo $_SESSION["nombre"]; ?>";
        var idUserSession = "<?php echo $_SESSION["id_usuario"]; ?>";
    </script>
    <!-- <script>
        var userSession = "<?php echo $_SESSION["usuario"]; ?>";
    </script>
    <script src="views/js/plantilla.js?v=<?= md5_file('views/js/plantilla.js') ?>"></script>
    <script src="views/js/parametricas.js?v=<?= md5_file('views/js/parametricas.js') ?>"></script> -->
    

</head>

<body>
    <main class="main" id="top">
        <?php

        if (!isset($_GET["ruta"])) {
            include "modules/login.php";
        } else {
            if (strpos($_GET["ruta"], '/') !== false) {
                //echo "La ruta contiene el carácter '/'.\n";
                $partesRuta = explode('/', trim($_GET["ruta"], '/'));
                $carpeta = $partesRuta[0];
                $ruta = $partesRuta[1];
            } else {
                //echo "La ruta no contiene el carácter '/'.\n";
                $carpeta = '';
                $ruta = $_GET["ruta"];
            }

            $rutaValida = ControllerPlantilla::ctrRutas($carpeta, $ruta);

            //echo $carpeta . ' ' . $ruta.'<br/>';
            //var_dump($rutaValida);

            if ($rutaValida == 'error') {
                    include "modules/ui/404.php";
                
            } else {
                if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
                    /* Header */
                    if ($rutaValida["header"] == 'LIMPIO') {
                        include_once "modules/ui/headerClear.php";
                    } elseif ($rutaValida["header"] == 'SI') {
                        include_once "modules/ui/header.php";
                    }
                    /* Board */
                    include "modules/" . $rutaValida["ruta_fin"] . ".php";
                    /* Footer */
                    if ($rutaValida["footer"] == 'SI') {
                        include "modules/ui/footer.php";
                    }
                } else {
                    include "modules/login.php";
                }
            }
        }

        ?>

    </main>

</body>

<!-- <script src="views/js/plantilla.js?v=<?= md5_file('views/js/plantilla.js') ?>"></script> -->
<script src="views/js/plantilla.js?v=<?= md5_file('views/js/plantilla.js') ?>"></script>
<!-- <script src="views/js/parametricas.js?v=<?= md5_file('views/js/parametricas.js') ?>"></script> -->


</html>
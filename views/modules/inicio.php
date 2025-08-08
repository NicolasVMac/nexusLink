<?php 
    /*
    echo $_SESSION["nombre"] . '</br>';
    echo  $_SESSION["iniciarSesion"] . "<br>";
    echo  $_SESSION["usuario"];
    */

?>
<div class="content">
    <h3 class="mb-2 text-1100">Bienvenido: <?php echo $_SESSION["nombre"]; ?></h3>
    <div class="card mb-5">
        <div class="card-body p-4">
            <div id="contenedorTarjetasModulos"></div>
        </div>
    </div>
</div>


<script src="views/js/inicio.js?v=<?= md5_file('views/js/inicio.js') ?>"></script>
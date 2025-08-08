<div class="content">

    <h1>Moodulo Configuraciones Inicio</h1>

    <?php

    $partesRuta = explode('/', trim($_GET["ruta"], '/'));
    echo $carpeta = $partesRuta[0] . "<br>";
    echo $ruta = $partesRuta[1] . "<br>";

    ?>

</div>
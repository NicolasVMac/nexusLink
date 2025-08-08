<?php

/*============================================
CONTROLADORES
============================================*/
require_once "controllers/plantilla.controller.php";
require_once "controllers/config/users.controller.php";

/*============================================
MODELO
============================================*/

require_once "models/plantilla.model.php";
require_once "models/parametricas.model.php";

//CONTROLADOR PLANTILLA
$plantilla = new ControllerPlantilla();
$plantilla->ctrPlantilla();
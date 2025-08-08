<?php
$idAutoEva = "";
if (isset($_GET["idAutoEva"])) {
    $idAutoEva = $_GET["idAutoEva"];
} else {
    $idAutoEva = "new";
}
?>
<div class="content">
    <div class="col-sm-12 col-md-12">
        <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
            <div class="card-header p-4 border-bottom border-300 bg-primary">
                <div class="row g-3 justify-content-between align-items-center">
                    <div class="col-12 col-md">
                        <h4 class="text-white mb-0">Gestionar Autoevaluacion-Evaluador</h4>
                    </div>
                    <div class="col col-md-auto">
                        <button id="terminarGestion" class="btn btn-phoenix-success ms-2" onclick="terminarGestion()" type="submit" style="display: none;">
                            <i class="far fa-check-circle"></i> Terminar Gestion
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class=" col-sm-12 col-md-12">
                        <div class="card shadow-sm border border-200 mb-4">
                            <form id="formInfoGeneral" name="formInfoGeneral" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                <div class="card-header p-3 border border-300 ">
                                    <div class="row g-3 justify-content-between align-items-center">
                                        <div class="col-sm-12 col-md-4">
                                            <h4 class="text-black mb-1">Gestion</h4>
                                        </div>
                                        <div class="col col-md-auto">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <ul class="nav nav-underline" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="calidad-tab" data-bs-toggle="tab" href="#tab-calidad" role="tab" aria-controls="tab-calidad" aria-selected="true">
                                                Calidad Esperada
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="observaciones-tab" data-bs-toggle="tab" href="#tab-observaciones" role="tab" aria-controls="tab-observaciones" aria-selected="false" tabindex="-1">
                                                Calidad Observada
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="resultados-tab" data-bs-toggle="tab" href="#tab-resultados" role="tab" aria-controls="tab-resultados" aria-selected="false" tabindex="-1">
                                                Plan de Accion
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content mt-3" id="myTabContent">
                                        <div class="tab-pane fade active show" id="tab-calidad" role="tabpanel" aria-labelledby="calidad-tab">
                                            <!-- Contenido de Calidad esperada -->
                                            Contenido para Calidad esperada.
                                        </div>
                                        <div class="tab-pane fade" id="tab-observaciones" role="tabpanel" aria-labelledby="observaciones-tab">
                                            <!-- Contenido de Observaciones -->
                                            Contenido para Observaciones.
                                        </div>
                                        <div class="tab-pane fade" id="tab-resultados" role="tabpanel" aria-labelledby="resultados-tab">
                                            <!-- Contenido de Resultados -->
                                            Contenido para Resultados.
                                        </div>
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class=" col-sm-12 col-md-12">
                        <div class="card shadow-sm border border-200 mb-4">
                            <form id="formInfoGeneral" name="formInfoGeneral" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                <div class="card-header p-3 border border-300 ">
                                    <div class="row g-3 justify-content-between align-items-center">
                                        <div class="col-sm-12 col-md-4">
                                            <h4 class="text-black mb-1">Informacion General</h4>
                                        </div>
                                        <div class="col col-md-auto">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-sm-6 col-md-2">
                                            <label for="selGrupo" class="text-black mb-1">GRUPO</label>
                                            <input type="hidden" id="idAutoevaluacion" name="idAutoevaluacion">
                                            <select class="form-control select-field" id="selGrupo" name="grupo" style=" width:100%" required>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <label for="selSubGrupo" class="text-black mb-1">SUBGRUPO</label>
                                            <select class="form-control select-field" id="selSubGrupo" name="subGrupo" style=" width:100%" required>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <label for="selEstandar" class=" text-black mb-1">ESTANDAR</label>
                                            <select class="form-control select-field" id="selEstandar" name="estandar" style=" width:100%" required></select>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <label for="selProceso" class=" text-black mb-1">PROCESO</label>
                                            <select class="form-control select-field" id="selProceso" name="procesoForm" style=" width:100%" required></select>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <label for="selAutoeval" class=" text-black mb-1">AUTOEVALUACION</label>
                                            <select class="form-control select-field" id="selAutoeval" name="autoevaluacion" style=" width:100%" required>
                                                <option value="">Seleccione un tipo de Autoevaluacion</option>
                                                <option value="SATISFACTORIO">SATISFACTORIO</option>
                                                <option value="MEJORABLE">MEJORABLE</option>
                                            </select>
                                        </div>
                                    </div>

                                    <hr>
                                    <h5 class="text-black mb-1">Sede y Programas</h5>

                                    <div class="row mt-4 mb-3">
                                        <div class="col-md-3 col-sm-12">
                                            <h6 class="text-black mb-1">SEDES</h6>
                                            <select class="form-control select-field" id="selSedesPamec" name="selSedesPamec" style=" width:100%" required>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <h6 class="text-black mb-1">PROGRAMAS</h6>
                                            <select class="form-control select-field" id="selProgramasPamec" name="selProgramasPamec" style=" width:100%" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Row con Cualitativa y Cuantitativa (oculto si NO hay idAutoevaluacion) -->
                <?php
                if ($idAutoEva != "new"):
                ?>
                    <div class="row">

                        <!-- Card Cualitativa -->
                        <div class="col-sm-12 col-md-6">
                            <div class="card shadow-sm border border-300 mb-4">
                                <form id="formCualitativa" name="formCualitativa" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                    <div class="card-header p-3 border border-300 ">
                                        <div class="row g-3 justify-content-between align-items-center">
                                            <div class="col-sm-12 col-md-4">
                                                <h4 class="text-black mb-1">Cualitativa</h4>
                                            </div>
                                            <div class="col col-md-auto">
                                                <!-- <button class="btn btn-phoenix-success ms-2"  type="submit">
                                                    <i class="far fa-check-circle"></i> Guardar
                                                </button> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" id="idRespuestaCualitativa" name="idRespuestaCualitativa">
                                        <div class="accordion card shadow-sm border border-150" id="accordionCualitativa">
                                        </div> <!-- fin accordion -->
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Card Cuantitativa -->
                        <div class="col-sm-12 col-md-6">
                            <div class="card shadow-sm border border-300 mb-4">
                                <form id="formCuantitativa" name="formCuantitativa" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                    <div class="card-header p-3 border border-300 ">
                                        <div class="row g-3 justify-content-between align-items-center">
                                            <div class="col-sm-12 col-md-4">
                                                <h4 class="text-black mb-1">Cuantitativa</h4>
                                            </div>
                                            <div class="col col-md-auto">
                                                <!-- <button class="btn btn-phoenix-success ms-2" type="submit">
                                                    <i class="far fa-check-circle"></i> Guardar
                                                </button> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" id="idRespuestaCuantitativa" name="idRespuestaCuantitativa">
                                        <div id="contenedorTablasCuantitativas"></div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="card shadow-sm border border-200 mb-4">
                                <form id="formPriorizacion" name="formPriorizacion" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">

                                    <div class="card-header p-3 border border-300 ">
                                        <div class="row g-3 justify-content-between align-items-center">
                                            <div class="col-sm-12 col-md-2">
                                                <h4 class="text-black mb-1">Priorizacion</h4>
                                            </div>
                                            <div class="col col-md-auto">
                                                <!-- <button class="btn btn-phoenix-success ms-2" type="submit">
                                                    <i class="far fa-check-circle"></i> Guardar
                                                </button> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                                <div class="card-header p-4 border-bottom border-300">
                                                    <div class="row g-3 justify-content-between align-items-center">
                                                        <div class="col-12 col-md">
                                                            <h4 class="text-black mb-0">Lista Priorizacion</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="tablaListaPriorizacionVer" class="table table-striped" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>GRUPO</th>
                                                                    <th>ESTANDAR</th>
                                                                    <th>FORTALEZAS</th>
                                                                    <th>OPORTUNIDAD DE MEJORA</th>
                                                                    <th>PROCESO A MEJORAR</th>
                                                                    <th>RIESGO</th>
                                                                    <th>COSTO</th>
                                                                    <th>VOLUMEN</th>
                                                                    <th>NIVEL DE ESTIMACION</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<script src="views/js/pamec/autoevaluacion.js?v=<?= md5_file('views/js/pamec/autoevaluacion.js') ?>"></script>
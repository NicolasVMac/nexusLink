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
                        <h4 class="text-white mb-0">Autoevaluación</h4>
                    </div>
                    <div class="col col-md-auto">
                        <button id="terminarGestion" class="btn btn-phoenix-success ms-2" onclick="terminarGestion()" type="submit" style="display: none;">
                            <i class="far fa-check-circle"></i> Terminar Gestion
                        </button>
                    </div>
                    <div class="col col-md-auto">
                        <button id="noAplica" class="btn btn-phoenix-danger ms-2" onclick="noAplicaCualiCuantiPriorizacion()" type="submit" style="display: none;">
                            <i class="far fa-file-excel"></i> No Aplica
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="card shadow-sm border border-200 mb-4">
                            <form id="formInfoGeneral" name="formInfoGeneral" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                <div class="card-header p-3 border border-300 ">
                                    <div class="row g-3 justify-content-between align-items-center">
                                        <div class="col-sm-12 col-md-4">
                                            <h4 class="text-black mb-1">Informacion General</h4>
                                        </div>
                                        <div class="col col-md-auto">
                                            <button class="btn btn-phoenix-success ms-2" onclick="guardarInfoGeneral()" type="submit">
                                                <i class="far fa-check-circle"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-sm-6 col-md-2">
                                            <label for="selGrupo" class="text-black mb-1">GRUPO</label>
                                            <input type="hidden" id="idAutoevaluacion" name="idAutoevaluacion">
                                            <select class="form-control select-field" id="selGrupo" name="grupo" onchange="onGrupoLoadSubGrupo(this) " style=" width:100%" required>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <label for="selSubGrupo" class="text-black mb-1">SUBGRUPO</label>
                                            <select class="form-control select-field" id="selSubGrupo" name="subGrupo" onchange="onSubGrupoLoadEstandar(this)" style=" width:100%" required>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-md-8">
                                            <label for="selEstandar" class=" text-black mb-1">ESTANDAR</label>
                                            <select class="form-control select-field" id="selEstandar" name="estandar" onchange="onEstandarLoadSedes(this) ; onEstandarLoadProgramas(this)" style=" width:100%" required></select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-6 col-md-2">
                                            <label for="selProceso" class=" text-black mb-1">PROCESO</label>
                                            <select class="form-control select-field" id="selProceso" name="procesoForm" style=" width:100%" required></select>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <label for="periodoAutoevaluacion" class=" text-black mb-1">PERIODO AUTOEVALUACION</label>
                                            <input class="form-control readonly" id="periodoAutoevaluacion" name="periodoAutoevaluacion" required readonly>
                                        </div>
                                        <div class="col-sm-6 col-md-8">
                                            <label class=" text-black mb-1">CRITERIOS</label>
                                            <div id="divCriterios"></div>
                                        </div>
                                    </div>

                                    <hr>
                                    <h5 class="text-black mb-1">Sede y Programas</h5>

                                    <div class="row mt-4 mb-3">
                                        <div class="col-md-3 col-sm-12">
                                            <h6 class="text-black mb-1">SEDES</h6>
                                            <select class="form-control select-field-multiple" id="selSedesPamec" name="selSedesPamec" multiple style=" width:100%" required>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <h6 class="text-black mb-1">PROGRAMAS</h6>
                                            <select class="form-control select-field-multiple" id="selProgramasPamec" name="selProgramasPamec" multiple style=" width:100%" required>
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
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="card shadow-sm border border-300 mb-4">
                                        <form id="formCualitativa" name="formCualitativa" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                            <div class="card-header p-3 border border-300 ">
                                                <div class="row g-3 justify-content-between align-items-center">
                                                    <div class="col-sm-12 col-md-4">
                                                        <h4 class="text-black mb-1">Cualitativa</h4>
                                                    </div>
                                                    <div class="col col-md-auto">
                                                        <button class="btn btn-phoenix-success ms-2" onclick="guardarCualitativa()" type="submit">
                                                            <i class="far fa-check-circle"></i> Guardar
                                                        </button>
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
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                        <form id="formCargarPdfEvidencias" name="formCargarPdfEvidencias" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                            <div class="card-header p-4 border-bottom border-300">
                                                <div class="row g-3 justify-content-between align-items-center">
                                                    <div class="col-12 col-md">
                                                        <h4 class="text-black mb-0">Cargar Archivos</h4>
                                                    </div>
                                                    <div class="col col-md-auto">
                                                        <button class="btn btn-phoenix-success ms-2" onclick="cargarPdfEvidencias()"><i class="far fa-check-circle"></i> Guardar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 mb-2">
                                                        <label>Archivos</label>
                                                        <input class="form-control" id="nuevoArchivoEvidencia" name="nuevoArchivoEvidencia" accept=".pdf" type="file" multiple="multiple" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12" id="contenedorArchivosAutoevaluacion"></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
                                                <button class="btn btn-phoenix-success ms-2" type="submit" onclick="guardarCuantitativa()">
                                                    <i class="far fa-check-circle"></i> Guardar
                                                </button>
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
                                                <button class="btn btn-phoenix-success ms-2" type="submit" onclick="guardarPriorizacion()">
                                                    <i class="far fa-check-circle"></i> Guardar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="row mb-4">
                                            <div class="col-sm-6 col-md-3 pb-4" id="container-selRiesgoPrio">
                                                <label for="selRiesgoPrio" class=" text-black mb-1">RIESGO</label>
                                                <select class="form-control select-field" id="selRiesgoPrio" name="selRiesgoPrio" onchange="cambioColorSelect(this)" style="width:100%" required></select>
                                            </div>
                                            <div class="col-sm-6 col-md-3 pb-4" id="container-selCostoPriorizacion">
                                                <label for="selCostoPriorizacion" class=" text-black mb-1">COSTO</label>
                                                <select class="form-control select-field" id="selCostoPriorizacion" name="selCostoPriorizacion" onchange="cambioColorSelect(this)" style=" width:100%" required></select>
                                            </div>
                                            <div class="col-sm-6 col-md-3 pb-4" id="container-selVolumenPriorizacion">
                                                <label for="selVolumenPriorizacion" class=" text-black mb-1">VOLUMEN</label>
                                                <select class="form-control" id="selVolumenPriorizacion" name="selVolumenPriorizacion" onchange="cambioColorSelect(this)" style=" width:100%" required></select>
                                            </div>
                                            <div class="col-sm-6 col-md-3 pb-4" id="containerNivelEstimacion">
                                                <label for="inputNEPriorizacion" class=" text-black mb-1">NIVEL DE ESTIMACION</label>
                                                <input class="form-control readonly" id="NEPriorizacion" name="NEPriorizacion" readonly>
                                            </div>
                                        </div>

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
                                                        <table id="tablaListaPriorizacion" class="table table-striped" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>GRUPO</th>
                                                                    <th>ESTANDAR</th>
                                                                    <th>SEDES</th>
                                                                    <th>OPORTUNIDAD DE MEJORA</th>
                                                                    <th>ACCIONES OPORTUNIDADES</th>
                                                                    <th>RIESGO</th>
                                                                    <th>COSTO</th>
                                                                    <th>VOLUMEN</th>
                                                                    <th>NIVEL DE ESTIMACION</th>
                                                                    <th>OPCIONES</th>
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
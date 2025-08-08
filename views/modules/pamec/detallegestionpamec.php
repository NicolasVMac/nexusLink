<?php
$idAutoEva = "";
if (isset($_GET["idAutoEva"])) {
    $idAutoEva = $_GET["idAutoEva"];
} else {
    $idAutoEva = "new";
}
?>
<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Gestion Pamec</h4>
                </div>
                <div class="col col-md-auto">
                    <!-- <button class="btn btn-phoenix-success ms-2" onclick="terminarGestionPriorizacion()" type="submit">
                        <i class="far fa-check-circle"></i> Terminar Gestion
                    </button> -->
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-underline" id="tabsVerGestionPamec" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" style="font-size: 12px !important;" id="autoevaluacion-tab" data-bs-toggle="tab" data-bs-target="#autoevaluacionPane" role="tab">
                        <i class="fas fa-th-list"></i> AUTOEVALUACION
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" style="font-size: 12px !important;" id="priorizacion-tab" data-bs-toggle="tab" data-bs-target="#priorizacion-pane" role="tab">
                        <i class="fas fa-th-list"></i> PRIORIZACION
                    </a>
                </li>
            </ul>
            <br>
            <div class="tab-content" id="contentGestionPrio">
                <div class="tab-pane fade show active" id="autoevaluacionPane" role="tabpanel">
                    <div class="col-sm-12 col-md-12">
                        <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                            <div class="card-header p-4 border-bottom border-300 bg-primary">
                                <div class="row g-3 justify-content-between align-items-center">
                                    <div class="col-12 col-md">
                                        <h4 class="text-white mb-0">Autoevaluación</h4>
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
                                                            <label for="selAutoeval" class=" text-black mb-1">PERIODO AUTOEVALUACION</label>
                                                            <input class="form-control readonly" id="periodoAutoevaluacion" name="periodoAutoevaluacion" readonly>
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
                                                                                    <th>SEDES</th>
                                                                                    <th>OPORTUNIDAD DE MEJORA</th>
                                                                                    <th>ACCIONES OPORTUNIDADES</th>
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
                <div class="tab-pane fade" id="priorizacion-pane" role="tabpanel">
                    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                        <div class="card-header p-4 border-bottom border-300 bg-primary">
                            <div class="row g-3 justify-content-between align-items-center">
                                <div class="col-12 col-md">
                                    <h4 class="text-white mb-0">Priorizacion</h4>
                                </div>
                                <div class="col col-md-auto">
                                    <!-- <button class="btn btn-phoenix-success ms-2" onclick="terminarGestionPriorizacion()" type="submit">
                                        <i class="far fa-check-circle"></i> Terminar Gestion
                                    </button> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-12">
                                    <ul class="nav nav-underline" id="tabsGestionPrio" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" style="font-size: 12px !important;" id="calidadEsperada-tab" data-bs-toggle="tab" data-bs-target="#calidadEsperadaPane" role="tab">
                                                <i class="fas fa-th-list"></i> CALIDAD ESPERADA Y OBSERVADA
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" style="font-size: 12px !important;" id="planAccion-tab" data-bs-toggle="tab" data-bs-target="#planAccion-pane" role="tab">
                                                <i class="fas fa-th-list"></i> ACCIÓN MEJORA E IMPLEMENTACIÓN
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" style="font-size: 12px !important;" id="evaluacion-tab" data-bs-toggle="tab" data-bs-target="#evaluacion-pane" role="tab">
                                                <i class="fas fa-th-list"></i> EVALUACIÓN EJECUCIÓN
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" style="font-size: 12px !important;" id="apOrganizacional-tab" data-bs-toggle="tab" data-bs-target="#apOrganizacional-pane" role="tab">
                                                <i class="fab fa-fort-awesome"></i> APRENDIZAJE ORGANIZACIONAL
                                            </a>
                                        </li>
                                    </ul>
                                    <br>
                                </div>
                            </div>

                            <div class="tab-content" id="contentGestionPrio">
                                <div class="tab-pane fade" id="calidadEsperadaPane" role="tabpanel">
                                    <div class="row mb-4">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="card shadow-sm border border-300 mb-4">
                                                <div class="card-body">
                                                    <div class="row mb-2">
                                                        <div class="col-sm-12 col-md-12">
                                                            <div class="card border-0 shadow-sm h-100">
                                                                <div class="table-responsive">
                                                                    <table id="tablaCalidadEsperada" class="table table-sm table-striped" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Meta Autoevaluacion</th>
                                                                                <th>Nombre Indicador</th>
                                                                                <th>Meta Indicador</th>
                                                                                <th>Acciones</th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="planAccion-pane" role="tabpanel">
                                    <div class="row mb-4">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="card shadow-sm border border-300 mb-4">
                                                <div class="card-body">
                                                    <div class="table-responsive mb-4" style="display: none;">
                                                        <table id="tablaCalidadObservada" class="table table-sm table-striped" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Indicador (Calidad Esperada)</th>
                                                                    <th>Resultado Autoeval.</th>
                                                                    <th>Resultado Obtenido</th>
                                                                    <th>Observaciones</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                    <div id="containerVerPanelsObservadas"></div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="evaluacion-pane" role="tabpanel">
                                    <div class="row mb-3">
                                        <div id="containerPanelsAcciones"></div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="apOrganizacional-pane" role="tabpanel">
                                    <div class="row mb-3">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                                <div class="card-header p-4 border-bottom border-300">
                                                    <div class="row g-3 justify-content-between align-items-center">
                                                        <div class="col-12 col-md">
                                                            <h4 class="text-black mb-0">Lista Aprendizaje Organizacional</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="tablaListaAprendizajeOrgEspecifica" class="table table-striped" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>CODIGO</th>
                                                                    <th>ESTANDAR</th>
                                                                    <th>OPORTUNIDAD DE MEJORA</th>
                                                                    <th>ACCIONES COMPLETAS</th>
                                                                    <th>AVANCE(%)</th>
                                                                    <th>ESTADO</th>
                                                                    <th>OBSERVACIONES</th>
                                                                    <th>META AUTOEVALUACION</th>
                                                                    <th>INDICADOR</th>
                                                                    <th>META INDICADOR</th>
                                                                    <th>CAL.OBS INICIO AUTOEVALUACIÓN</th>
                                                                    <th>CAL.OBS INICIO INDICADOR</th>
                                                                    <th>CAL.OBS FINAL</th>
                                                                    <th>CAL.OBS FINAL INDICADOR</th>
                                                                    <th>BARRERAS MEJORAMIENTO</th>
                                                                    <th>APRENDIZAJE ORGANIZACIONAL</th>
                                                                    <th>ACCIONES</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modalVerObservada">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-300 shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Ver Calidad Observada</h5>
                <button class="btn p-1 text-primary" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">
                <form id="formVerCalidadObservada" onsubmit="return false;">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <input type="hidden" id="idCalidadObservada" name="idCalidadObservada">
                            <label class="text-900">Resultado Autoevaluación</label>
                            <input type="number" class="form-control readonly" id="verResultadoAutoeval" name="verResultadoAutoeval" readonly>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label class="text-900">Resultado Obtenido Indicador</label>
                            <input type="text" class="form-control readonly" id="verResultadoIndicador" name="verResultadoIndicador" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label class="text-900">Observaciones</label>
                            <textarea class="form-control readonly" id="verObsCalidadObservada" name="verObsCalidadObservada" rows="3" readonly></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarCalidadObservada()" data-bs-dismiss="modal"><i class="fas fa-trash-alt"></i> Eliminar Calidad Observada</button>
            </div> -->
        </div>
    </div>
</div>

<div class="modal fade" id="modalAccionMejora" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-300 shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Detalle Acción Mejora</h5>
                <button class="btn p-1 text-primary" data-bs-dismiss="modal">
                    <span class="fas fa-times fs--1"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div id="bodyAccion">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEvaluacion" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-300 shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Detalle Evaluación</h5>
                <button class="btn p-1 text-primary" data-bs-dismiss="modal">
                    <span class="fas fa-times fs--1"></span>
                </button>
            </div>
            <div class="modal-body" id="bodyEvaluacion">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetalleAprendizaje" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-300 shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Detalle Aprendizaje Organizacional</h5>
            </div>

            <div class="modal-body">
                <div id="contenDetalleAprendizaje"></div>
            </div>
        </div>
    </div>
</div>


<script src="views/js/pamec/gestion-pamec.js?v=<?= md5_file('views/js/pamec/gestion-pamec.js') ?>"></script>
<script src="views/js/pamec/autoevaluacion.js?v=<?= md5_file('views/js/pamec/autoevaluacion.js') ?>"></script>
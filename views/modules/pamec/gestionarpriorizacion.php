<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Gestion Priorizacion</h4>
                </div>
                <div class="col col-md-auto">
                    <button class="btn btn-phoenix-success ms-2" onclick="terminarGestionPriorizacion()" type="submit">
                        <i class="far fa-check-circle"></i> Terminar Gestion
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-12 col-md-12">
                    <div class="accordion" id="accordionInfoGeneral">
                        <div class="accordion-item border-top border-300">
                            <h2 class="accordion-header" id="headingInfoGeneral">
                                <button class="accordion-button" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseInfoGeneral"
                                    aria-expanded="false"
                                    aria-controls="collapseInfoGeneral">
                                    INFORMACIÓN GENERAL PRIORIZACIÓN
                                </button>
                            </h2>
                            <div id="collapseInfoGeneral"
                                class="accordion-collapse collapse "
                                aria-labelledby="headingInfoGeneral"
                                data-bs-parent="#accordionInfoGeneral">
                                <div class="accordion-body pt-0">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">Grupo</label>
                                                    <div id="infoGrupo"></div>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">Estándar</label>
                                                    <div id="infoEstandar"></div>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">Sedes</label>
                                                    <div id="infoSedes"></div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">Oportunidad Mejora</label>
                                                    <div id="infoOM"></div>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">Acciones Oportunidades</label>
                                                    <div id="infoAO"></div>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">Fecha Creación Prioridad</label>
                                                    <div id="infoFechaCrea"></div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">Usuario Creador</label>
                                                    <div id="infoUsuarioCrea"></div>
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

            <ul class="nav nav-underline" id="tabsGestionPrio" role="tablist">
                <li class="nav-item" role="presentation">
                    <!-- <button class="nav-link active" id="calidadEsperada-tab" data-bs-toggle="tab"
                        data-bs-target="#calidadEsperadaPane" type="button" role="tab">
                        CALIDAD ESPERADA Y OBSERVADA
                    </button> -->
                    <a class="nav-link" style="font-size: 12px !important;" id="calidadEsperada-tab" data-bs-toggle="tab" data-bs-target="#calidadEsperadaPane" role="tab">
                        <i class="fas fa-th-list"></i> CALIDAD ESPERADA Y OBSERVADA
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link disabled" style="font-size: 12px !important;" id="planAccion-tab" data-bs-toggle="tab" data-bs-target="#planAccion-pane" role="tab">
                        <i class="fas fa-th-list"></i> ACCIÓN MEJORA E IMPLEMENTACIÓN
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <!-- <button class="nav-link" id="evaluacion-tab" data-bs-toggle="tab"
                        data-bs-target="#evaluacion-pane" type="button" role="tab">
                        EVALUACIÓN EJECUCIÓN
                    </button> -->
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
            <div class="tab-content" id="contentGestionPrio">
                <div class="tab-pane fade" id="calidadEsperadaPane" role="tabpanel">
                    <div class="row mb-4">
                        <div class="col-sm-12 col-md-12">
                            <div class="card shadow-sm border border-300 mb-4">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-12 col-md-6">
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
                                        <div class="col-sm-12 col-md-6">
                                            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                                <div class="card-header p-4 border-bottom border-300">
                                                    <div class="row g-3 justify-content-between align-items-center">
                                                        <div class="col-12 col-md-12">
                                                            <h4 class="text-black mb-0">Agregar Calidad Esperada</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <form id="formCalidadEsperada" name="formCalidadEsperada" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                        <div class="row mb-2">
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Meta Autoevaluación</label>
                                                                <input type="number" step="0.1" min="0" max="5" class="form-control" id="metaAutoevaluacion" name="metaAutoevaluacion" required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Nombre Indicador</label>
                                                                <input type="text" class="form-control" id="nombreIndicador" name="nombreIndicador" placeholder="Nombre Indicador" required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Meta Indicador</label>
                                                                <input type="number" step="0.1" min="0" max="5" class="form-control" id="metaIndicador" placeholder="Meta Indicador" name="metaIndicador" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4 text-center">
                                                            <div class="col-sm-12 col-md-12">
                                                                <button class="btn btn-outline-success" type="submit" onclick="guardarCalidadEsperada()"><i class="far fa-save me-1"></i> Guardar</button>
                                                            </div>
                                                        </div>
                                                    </form>
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

                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12 text-end">
                            <button class="btn btn-outline-primary" id="btnRecargarObservadas" onclick="recargarTablaObservadas()">
                                <i class="fas fa-sync-alt me-1"></i> Recargar Calidad Observada
                            </button>
                        </div>
                    </div>

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
                                    <div id="containerPanelsObservadas"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="evaluacion-pane" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <button class="btn btn-outline-primary" id="btnRecargarEvaluaciones"
                                onclick="recargarEvaluaciones()">
                                <i class="fas fa-sync-alt me-1"></i> Recargar Evaluaciones
                            </button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div id="containerPanelsAcciones"></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="apOrganizacional-pane" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-md-12 col-sm-12">
                            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                <div class="card-header p-4 border-bottom border-300 bg-success">
                                    <div class="row g-3 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h4 class="text-white mb-0">Aprendizaje Organizacional</h4>
                                        </div>
                                        <div class="col col-md-auto">
                                            <button class="btn btn-phoenix-success ms-2" onclick="guardarAprendizaje()" type="submit">
                                                <i class="far fa-check-circle"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <form id="formAprendizajeOrg" name="formAprendizajeOrg" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-4 col-sm-12">
                                            </div>
                                            <div class="col-md-4 col-sm-12 text-center">
                                                <label for="selIndicador" class="text-black mb-1">Indicador <b class="text-danger">*</b></label>
                                                <select class="form-control select-field" id="selIndicador" name="selIndicador" onchange="llenarFormulario(this)" style=" width:100%" required>
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                                    <div class="card-header p-4 border-bottom border-300">
                                                        <div class="row g-3 justify-content-between align-items-center">
                                                            <div class="col-12 col-md">
                                                                <h4 class="text-black mb-0">Informacion Indicador</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- <div class="row mb-4">
                                                            <input type="hidden" name="idAprendizaje">
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Cod Estandar</label>
                                                                <input type="text" class="form-control readonly" id="codigoEstandar" name="codigoEstandar" readonly required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Estandar</label>
                                                                <textarea class="form-control readonly" id="estandar" name="estandar" rows="2" readonly required></textarea>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Oportunidad Mejor</label>
                                                                <input type="text" class="form-control readonly" id="oportunidadMejora" name="oportunidadMejora" readonly required>
                                                            </div>
                                                        </div> -->

                                                        <!-- <div class="row mb-4">
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Acciones Completas</label>
                                                                <input type="text" class="form-control readonly" id="accionesCompletas" name="accionesCompletas" readonly required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Avance (%)</label>
                                                                <input type="text" class="form-control readonly" id="avancePorcentaje" name="avancePorcentaje" readonly required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4 pb-4" id="containerAvance">
                                                                <label class="text-900">Estado </label>
                                                                <input type="text" class="form-control readonly" id="estadoAprendizaje" name="estadoAprendizaje" readonly required>
                                                            </div>
                                                        </div> -->

                                                        <!-- <div class="row mb-4">
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Meta Autoevaluacion </label>
                                                                <input type="text" class="form-control readonly" id="metaAutoevaluacionAp" name="metaAutoevaluacionAp" readonly required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Indicador </label>
                                                                <input type="text" class="form-control readonly" id="indicadorAp" name="indicadorAp" readonly required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Meta Indicador</label>
                                                                <input type="text" class="form-control readonly" id="metaIndicadorAP" name="metaIndicadorAP" readonly required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Cal. Obsevada Inicio Autoevaluacion</label>
                                                                <input type="text" class="form-control readonly" id="calObsIniAuto" name="calObsIniAuto" readonly required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Cal. Obsevada Inicio Indicador </label>
                                                                <input type="text" class="form-control readonly" id="calObsIniIndicador" name="calObsIniIndicador" readonly required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                                <label class="text-900">Cal. Obsevada Final</label>
                                                                <input type="text" class="form-control readonly" id="calObsFin" name="calObsFin" readonly required>
                                                            </div>
                                                        </div> -->
                                                        <hr>
                                                        <div class="row mb-4">
                                                            <div class="col-sm-12 col-md-12">
                                                                <label class="text-900">Estandar</label>
                                                                <input type="hidden" name="estandar" id="estandar">
                                                                <div id="vEstandar"></div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row mb-4">
                                                            <input type="hidden" name="idAprendizaje">
                                                            <div class="col-sm-12 col-md-3">
                                                                <label class="text-900">Cod Estandar</label>
                                                                <input type="hidden" name="codigoEstandar" id="codigoEstandar">
                                                                <div id="vCodigoEstandar"></div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-3">
                                                                <label class="text-900">Oportunidad Mejora</label>
                                                                <input type="hidden" name="oportunidadMejora" id="oportunidadMejora">
                                                                <div id="vOportunidadMejora"></div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-3">
                                                                <label class="text-900">Acciones Completas</label>
                                                                <input type="hidden" name="accionesCompletas" id="accionesCompletas" required>
                                                                <div id="vAccionesCompletas"></div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-3">
                                                                <label class="text-900">Avance (%)</label>
                                                                <input type="hidden" name="avancePorcentaje" id="avancePorcentaje" required>
                                                                <div id="vAvancePorcentaje"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col-sm-12 col-md-3 pb-4" id="containerAvance">
                                                                <label class="text-900">Estado</label>
                                                                <input type="hidden" name="estadoAprendizaje" id="estadoAprendizaje" required>
                                                                <div id="vEstadoAprendizaje"></div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-3">
                                                                <label class="text-900">Meta Autoevaluacion</label>
                                                                <input type="hidden" name="metaAutoevaluacionAp" id="metaAutoevaluacionAp" required>
                                                                <div id="vMetaAutoevaluacionAp"></div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-3">
                                                                <label class="text-900">Indicador</label>
                                                                <input type="hidden" name="indicadorAp" id="indicadorAp" required>
                                                                <div id="vIndicadorAp"></div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-3">
                                                                <label class="text-900">Meta Indicador</label>
                                                                <input type="hidden" name="metaIndicadorAP" id="metaIndicadorAP" required>
                                                                <div id="vMetaIndicadorAP"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col-sm-12 col-md-3">
                                                                <label class="text-900">Cal. Obsevada Inicio Autoevaluacion</label>
                                                                <input type="hidden" name="calObsIniAuto" id="calObsIniAuto" required>
                                                                <div id="vCalObsIniAuto"></div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-3">
                                                                <label class="text-900">Cal. Obsevada Inicio Indicador</label>
                                                                <input type="hidden" name="calObsIniIndicador" id="calObsIniIndicador" required>
                                                                <div id="vCalObsIniIndicador"></div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-3">
                                                                <label class="text-900">Cal. Obsevada Final</label>
                                                                <input type="hidden" name="calObsFin" id="calObsFin" required>
                                                                <div id="vCalObsFin"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                                    <div class="card-header p-4 border-bottom border-300">
                                                        <div class="row g-3 justify-content-between align-items-center">
                                                            <div class="col-12 col-md">
                                                                <h4 class="text-black mb-0">Agregar Aprendizaje Organizacional</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row mb-2">
                                                            <div class="col-sm-12 col-md-6">
                                                                <label class="text-900">Observaciones </label>
                                                                <textarea class="form-control" id="obs1" name="obs1" rows="2"></textarea>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <label class="text-900">Cal. Obsevada Final Indicador <b class="text-danger">*</b></label>
                                                                <textarea type="text" class="form-control" id="calObsFinIndicador" name="calObsFinIndicador" rows="2" required></textarea>
                                                            </div>

                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-sm-12 col-md-6">
                                                                <label class="text-900">Barreras Mejoramiento <b class="text-danger">*</b></label>
                                                                <textarea class="form-control" id="barrerasMejora" name="barrerasMejora" rows="2" required></textarea>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <label class="text-900">Aprendizaje Organizacional <b class="text-danger">*</b></label>
                                                                <textarea class="form-control" id="obsAprendizajeOrganizacional" name="obsAprendizajeOrganizacional" rows="2" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 col-sm-12">
                            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                <div class="card-header p-4 border-bottom border-300 bg-success">
                                    <div class="row g-3 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h4 class="text-white mb-0">Lista Aprendizaje Organizacional</h4>
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

<div class="modal fade" id="modalCalidadObservada">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-300 shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="exampleModalLabel">Calidad Observada</h5>
                <button class="btn p-1 text-primary" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>

            <form id="formCalidadObservada" name="formCalidadEsperada" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-body">
                    <input type="hidden" id="idCalidadEsperadaObs" name="idCalidadEsperadaObs">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <label class="text-900">Resultado Autoevaluación</label>
                            <input type="number" step="0.01" min="0" class="form-control readonly" id="resultadoAutoeval" name="resultadoAutoeval" readonly required>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label class="text-900">Resultado Obtenido Indicador</label>
                            <input type="text" class="form-control" id="resultadoIndicador" name="resultadoIndicador" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label class="text-900">Observaciones</label>
                            <textarea class="form-control" name="obsCalidadObservada" id="obsCalidadObservada" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-success" onclick="guardarCalidadObservada()"><i class="far fa-save me-1"></i> Guardar</button>
                </div>
            </form>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarCalidadObservada()" data-bs-dismiss="modal"><i class="fas fa-trash-alt"></i> Eliminar Calidad Observada</button>
            </div>
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


<script src="views/js/pamec/gestion-priorizacion.js?v=<?= md5_file('views/js/pamec/gestion-priorizacion.js') ?>"></script>
<script src="views/js/pamec/autoevaluacion.js?v=<?= md5_file('views/js/pamec/autoevaluacion.js') ?>"></script>
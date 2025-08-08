<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Consolidado de Frecuencias de Atencion por Grupo Interdisciplinario</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formReportFrecuenciasVIH" name="formReportFrecuenciasVIH" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Base Encuestas</label>
                        <select class="form-control select-field" name="basesEncuestas" id="basesEncuestas" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarConsolidadoFrecuenciasVIH()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoReporteFrecuencias" data-component-card="data-component-card" style="display: none;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Resultado:</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="card mb-2">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaConsolidadoMedicoExperto" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>MÉDICO EXPERTO DEL PROGRAMA</th>
                                                    <th>NO.</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaMedicoExperto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaConsolidadoInfectologo" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>INFECTÓLOGO</th>
                                                    <th>NO.</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaInfectologo"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaConsolidadoPsicologia" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>PSICOLOGÍA</th>
                                                    <th>NO.</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaPsicologia"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaConsolidadoNutricion" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>NUTRICIÓN</th>
                                                    <th>NO.</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaNutricion"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaConsolidadoTrabajoSocial" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>TRABAJO SOCIAL</th>
                                                    <th>NO.</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaTrabajoSocial"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaConsolidadoOdontologia" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>ODONTOLOGÍA</th>
                                                    <th>NO.</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaOdontologia"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaConsolidadoQuimicoFarmaceutico" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>QUÍMICO FARMACÉUTICO</th>
                                                    <th>NO.</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaQuimicoFarmaceutico"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaConsolidadoEnfermeria" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>ENFERMERÍA</th>
                                                    <th>NO.</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaEnfermeria"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaConsolidadoSIAU" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>SEGUIMIENTO PACIENTES DE LA MUESTRA</th>
                                                    <th>NO.</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaSIAU"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaConsolidadoPsiquiatria" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>PSIQUIATRÍA</th>
                                                    <th>NO.</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaPsiquiatria"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaConsolidadoFrecuenciasGrupo" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>CUMPLIMIENTO DE LAS FRECUENCIAS DE ATENCIÓN EQUIPO INTERDISCIPLINARIO</th>
                                                    <th>% DE PACIENTES ATENDIDOS DENTRO DE LA FRECUENCIA ESTABLECIDA</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaConsolidadoFrecuenciaGrupo"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="views/js/encuestas/reportes-vih.js?v=<?= md5_file('views/js/encuestas/reportes-vih.js') ?>"></script>
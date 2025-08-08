<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Consolidado Medico General Autoinmunes</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formReportConsoMedGeneral" name="formReportConsoMedGeneral" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
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
                    <center><button class="btn btn-success btn-sm" onclick="generarReportConsoMedGeneralAuto()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoReporteConsolidadoMedGeneral" data-component-card="data-component-card" style="display: none;">
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
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="table-responsive">
                                <table id="tablaDiligenciamiento" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA MEDICOS GENERALES</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div id="containerDiligenciamiento"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaEvaluacionClinica1" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO DE EVALUACION CLINICA</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div id="containerEvaluacionClinica1"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaEvaluacionClinica2" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO DE EVALUACION CLINICA</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div id="containerEvaluacionClinica2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaParaclinicos1" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS</th>
                                            <th>% DE CUMPLIMIENTO DE PARACLINICOS ANALIZADOS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div id="containerParaclinicos1"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaParaclinicos2" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS</th>
                                            <th>% DE CUMPLIMIENTO DE PARACLINICOS ANALIZADOS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div id="containerParaclinicos2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="table-responsive">
                                <table id="tablaParaclinicosGeneral" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS</th>
                                            <th>PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ANALIZADOS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div id="containerParaclinicosGeneral"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="table-responsive">
                                <table id="tablaRecomendacionCoherencia" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO RECOMENDACIONES Y COHERENCIA</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div id="containerRecomendacionCoherencia"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="table-responsive">
                                <table id="tablaAtributosCalidad" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO ATRIBUTOS DE CALIDAD</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div id="containerAtributosCalidad"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="views/js/encuestas/reportes-autoinmunes.js?v=<?= md5_file('views/js/encuestas/reportes-autoinmunes.js') ?>"></script>
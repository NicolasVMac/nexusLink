<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Consolidado por Profesional - Especialidad VIH</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formReportConsoProfeEspe" name="formReportConsoProfeEspe" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Base Encuestas</label>
                        <select class="form-control select-field" name="basesEncuestas" id="basesEncuestas" onchange="obtenerEspecialidadesBase()" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Especialidad</label>
                        <select class="form-control select-field" name="especialidadEncuesta" id="especialidadEncuesta" onchange="obtenerAuditoresEspecialidad()" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Auditor</label>
                        <select class="form-control select-field" name="auditorEncuesta" id="auditorEncuesta" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteConsolidadoProfesionalEspecialidad()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoReporteConsolidadoProfesionalEspecialidad" data-component-card="data-component-card" style="display: none;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Resultado:</h4>
                </div>
            </div>
        </div>
        <div class="card-body" id="cardResult">
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="table-responsive">
                                <table id="tablaDiligenciamiento" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA <b class="nombreAuditorTable"></b></th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
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
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="table-responsive">
                                <table id="tablaRegistroAntecedentes" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO DE REGISTRO DE ANTECEDENTES</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div id="containerRegistroAntecedentes"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaEvaluacionClinica" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO DE EVALUACION CLINICA</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div id="containerEvaluacionClinica"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="table-responsive">
                                <table id="tablaSeguimientoVacunas" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO DE SEGUIMIENTO A VACUNAS</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div id="containerSeguimientoVacunas"></div>
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
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
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
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
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
                                <table id="tablaParaclinicos3" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS</th>
                                            <th>% DE CUMPLIMIENTO DE PARACLINICOS ANALIZADOS</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div id="containerParaclinicos3"></div>
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
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
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
                                <table id="tablaCitologiaAnal" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>CUMPLIMIENTO DE CITOLOGIA ANAL</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div id="containerCitologiaAnal"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="table-responsive">
                                <table id="tablaCitologiaVaginal" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>CUMPLIMIENTO DE CITOLOGIA VAGINAL</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div id="containerCitologiaVaginal"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="table-responsive">
                                <table id="tablaAntigenoProstatico" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>CUMPLIMIENTO DE ANTIGENO PROSTATICO</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div id="containerAntigenoProstatico"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="table-responsive">
                                <table id="tablaMamografia" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>CUMPLIMIENTO DE MAMOGRAFIA</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div id="containerMamografia"></div>
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
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
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
                                    <!-- <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot> -->
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

<script src="views/js/encuestas/reportes-vih.js?v=<?= md5_file('views/js/encuestas/reportes-vih.js') ?>"></script>
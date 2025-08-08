<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Cumplimiento de la Ruta de Atencion Inicial en los Pacientes Nuevos</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formReportCumpliAtenPacNuevo" name="formReportCumpliAtenPacNuevo" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
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
                    <center><button class="btn btn-success btn-sm" onclick="generarCumplimiAtenPacNuevoVIH()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoReporteCumpliAtenPacNuevo" data-component-card="data-component-card" style="display: none;">
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
                    <div class="card">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaReportCumpliAtenPacNuevo" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>EQUIPO INTERDISCIPLINARIO</th>
                                                    <th>No DE ATENCIONES DE 1RA VEZ</th>
                                                    <th>% DE PACIENTES NUEVOS ATENDIDOS EN EL MISMO MES DE INGRESO</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbodyTable"></tbody>
                                            <tfoot class="tfootTable"></tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div id="containerGraficaCumpliAtenPacNuevo"></div>
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
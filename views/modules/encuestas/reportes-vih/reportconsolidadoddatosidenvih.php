<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Consolidado Datos Identificacion VIH</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formReportConsoDatosIdentificacion" name="formReportConsoDatosIdentificacion" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
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
                    <center><button class="btn btn-success btn-sm" onclick="generarReportConsoDatosIdentificacionVIH()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoReporteConsolidadoDatosIdentificacion" data-component-card="data-component-card" style="display: none;">
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
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaConsolidadoDatosIdentificacion" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>DATO</th>
                                            <th>PORCENTAJE DE CUMPLIMIENTO</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodyTable"></tbody>
                                    <tfoot class="tfootTable"></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div id="containerConsolidadoDatosIdentificacion"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="views/js/encuestas/reportes-vih.js?v=<?= md5_file('views/js/encuestas/reportes-vih.js') ?>"></script>
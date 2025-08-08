<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Regimen Base</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formReporteRegimenBase" name="formReporteRegimenBase" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Base</label>
                        <select class="form-control select-field" name="baseCargadas" id="baseCargadas" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteRegimenBase()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoReporteRegimenBase" data-component-card="data-component-card" style="display: none;">
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
                        <div class="col-sm-12 col-md-4 mb-2">
                            <div class="table-responsive">
                                <table id="tablaReporteRegimen" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>REGIMEN</th>
                                            <th>CANTIDAD</th>
                                            <th>OPCION</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-8 mb-2">
                            <div id="contenedorRegimenSeleccionado"></div>
                            <hr>
                            <div class="table-responsive">
                                <table id="tablaReporteRegimenDetalle" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>IPS</th>
                                            <th>NOMBRE PACIENTE</th>
                                            <th>DOCUMENTO PACIENTE</th>
                                            <th>REGIMEN</th>
                                            <th>COHORTE O PROGRAMA</th>
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

<script src="views/js/di/reportes.js?v=<?= md5_file('views/js/di/reportes.js') ?>"></script>
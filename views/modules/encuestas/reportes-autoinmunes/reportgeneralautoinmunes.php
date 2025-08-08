<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Reporte General Autoinmunes</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="formReportGeneralAutoinmunes" name="formReportGeneralAutoinmunes" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12">
                                <label class="">Base Encuestas</label>
                                <select class="form-control select-field" name="basesEncuestas" id="basesEncuestas" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12">
                                <label class="">Instrumento</label>
                                <select class="form-control select-field" name="listaInstrumentosGeneral" id="listaInstrumentosGeneral" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <center><button class="btn btn-success btn-sm mb-5" onclick="generarReporteGeneralAutoinmunes()"><i class="fas fa-search"></i> Generar</button></center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Lista Reportes Generados</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaSolicitudesReportesConsolidados" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PROCESO</th>
                                    <th>TIPO ENCUESTA</th>
                                    <th>ARCHIVO</th>
                                    <th>ESTADO</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="views/js/encuestas/reportes-autoinmunes.js?v=<?= md5_file('views/js/encuestas/reportes-autoinmunes.js') ?>"></script>
<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Bases</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formReporteBases" name="formReporteBases" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
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
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteBases()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoReporteBases" data-component-card="data-component-card" style="display: none;">
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
                        <div class="col-sm-12 col-md-12">
                            <div class="table-responsive">
                                <table id="tablaReporteBaseGeneral" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>PORCENTAJE GESTION</th>
                                            <th>ASIGNADAS MEDICOS</th>
                                            <th>ASIGNADAS JEFES ENFERMERIAS</th>
                                            <th>EFECTIVAS MEDICOS - FALLIDAS MEDICOS</th>
                                            <th>EFETIVAS JEFES ENFERMERIA - FALLIDAS JEFES ENFERMERIA</th>
                                            <th>PROGRAMADAS</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <div class="table-responsive">
                                <table id="tablaReporteBaseProfesional" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>CARGO</th>
                                            <th>NOMBRE PROFESIONAL</th>
                                            <th>ASIGNADAS MEDICOS</th>
                                            <th>ASIGNADAS JEFES ENFERMERIAS</th>
                                            <th>EFECTIVAS MEDICOS - FALLIDAS MEDICOS</th>
                                            <th>EFETIVAS JEFES ENFERMERIA - FALLIDAS JEFES ENFERMERIA</th>
                                            <th>PROGRAMADAS</th>
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
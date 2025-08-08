<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Llamadas</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formReporteLlamadas" name="formReporteLlamadas" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Cohorte o Programa</label>
                        <select class="form-control select-field" name="cohortePrograma" id="cohortePrograma" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Fecha Inicio</label>
                        <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" required>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Fecha Fin</label>
                        <input type="date" class="form-control" name="fechaFin" id="fechaFin" required>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteLlamadas()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoReporteLlamadas" data-component-card="data-component-card" style="display: none;">
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
                        <div class="col-sm-12 col-md-6">
                            <div id="containerGrafRealizadas"></div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="table-responsive">
                                <table id="tablaRealizadas" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>IPS</th>
                                            <th>NOMBRE PACIENTE</th>
                                            <th>DOCUMENTO PACIENTE</th>
                                            <th>COHORTE O PROGRAMA</th>
                                            <th>ESTADO</th>
                                            <th>USUARIO</th>
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
                        <div class="col-sm-12 col-md-6">
                            <div id="containerGrafEfecticasFallidas"></div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="table-responsive">
                                <table id="tablaEfectivasFallidas" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>IPS</th>
                                            <th>NOMBRE PACIENTE</th>
                                            <th>DOCUMENTO PACIENTE</th>
                                            <th>COHORTE O PROGRAMA</th>
                                            <th>ESTADO</th>
                                            <th>USUARIO</th>
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
                        <div class="col-sm-12 col-md-6">
                            <div id="containerGrafProgramadas"></div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="table-responsive">
                                <table id="tablaProgramadas" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>IPS</th>
                                            <th>NOMBRE PACIENTE</th>
                                            <th>DOCUMENTO PACIENTE</th>
                                            <th>COHORTE O PROGRAMA</th>
                                            <th>ESTADO</th>
                                            <th>USUARIO</th>
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
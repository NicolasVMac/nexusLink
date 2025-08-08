<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Productividad Profesional</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formReporteProductividad" name="formReporteProductividad" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Profesional</label>
                        <select class="form-control select-field" name="profesionalAgendamiento" id="profesionalAgendamiento" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Fecha Inicio</label>
                        <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" max="<?php echo $hoy; ?>" required>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Fecha Fin</label>
                        <input type="date" class="form-control" name="fechaFin" id="fechaFin"  required>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteProductividadProfesional()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoReporteProductividadProfesional" data-component-card="data-component-card" style="display: none;">
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
                            <div id="containerGraficaProductividadProfesional"></div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="table-responsive">
                                <table id="tablaResultProductividadProfesional" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PACIENTE</th>
                                            <th>DOCUMENTO PACIENTE</th>
                                            <th>SERVICIO CITA</th>
                                            <th>MOTIVO CITA</th>
                                            <th>FECHA CITA</th>
                                            <th>LOCALIDAD CITA</th>
                                            <th>COHORTE PROGRAMA</th>
                                            <th>ESTADO</th>
                                            <th>PROFESIONAL</th>
                                            <th>FECHA INI</th>
                                            <th>FECHA FIN</th>
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
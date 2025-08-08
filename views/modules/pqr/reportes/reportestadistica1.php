<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Estadistica 1</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formRepEstadistica1" name="formRepEstadistica1" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Año</label>
                        <select class="form-control select-field" name="fechaAnio" id="fechaAnio" required>
                            <option value="">Seleccione una opcion</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                        <!-- <input type="text" class="form-control readonly" name="fechaAnio" id="fechaAnio" value="<?php echo $anio; ?>" readonly required> -->
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Sede</label>
                        <select class="form-control select-field" name="sedePqrsf" id="sedePqrsf" required></select>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteEstadistica1()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-none border border-300 mb-2" id="cardResulRepEstadistica1" data-component-card="data-component-card" style="display: none;">
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
                                <table id="tablaTipoPqrsf" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>TIPO PQRSF</th>
                                            <th>ENERO</th>
                                            <th>FEBRERO</th>
                                            <th>MARZO</th>
                                            <th>ABRIL</th>
                                            <th>MAYO</th>
                                            <th>JUNIO</th>
                                            <th>JULIO</th>
                                            <th>AGOSTO</th>
                                            <th>SEPTIEMBRE</th>
                                            <th>OCTUBRE</th>
                                            <th>NOVIEMBRE</th>
                                            <th>DICIEMBRE</th>
                                            <th>TOTAL</th>
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
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaMotivoPQRSF" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>MOTIVO PQRSF</th>
                                            <th>ENERO</th>
                                            <th>RECURRENCIA</th>
                                            <th>FEBRERO</th>
                                            <th>RECURRENCIA</th>
                                            <th>MARZO</th>
                                            <th>RECURRENCIA</th>
                                            <th>ABRIL</th>
                                            <th>RECURRENCIA</th>
                                            <th>MAYO</th>
                                            <th>RECURRENCIA</th>
                                            <th>JUNIO</th>
                                            <th>RECURRENCIA</th>
                                            <th>JULIO</th>
                                            <th>RECURRENCIA</th>
                                            <th>AGOSTO</th>
                                            <th>RECURRENCIA</th>
                                            <th>SEPTIEMBRE</th>
                                            <th>RECURRENCIA</th>
                                            <th>OCTUBRE</th>
                                            <th>RECURRENCIA</th>
                                            <th>NOVIEMBRE</th>
                                            <th>RECURRENCIA</th>
                                            <th>DICIEMBRE</th>
                                            <th>RECURRENCIA</th>
                                            <th>TOTAL</th>
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
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaClaAtriPQRSF" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>CLASIFICACION ATRIBUTO</th>
                                            <th>ENERO</th>
                                            <th>FEBRERO</th>
                                            <th>MARZO</th>
                                            <th>ABRIL</th>
                                            <th>MAYO</th>
                                            <th>JUNIO</th>
                                            <th>JULIO</th>
                                            <th>AGOSTO</th>
                                            <th>SEPTIEMBRE</th>
                                            <th>OCTUBRE</th>
                                            <th>NOVIEMBRE</th>
                                            <th>DICIEMBRE</th>
                                            <th>TOTAL</th>
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
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaEpsPQRSF" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>EPS</th>
                                            <th>ENERO</th>
                                            <th>FEBRERO</th>
                                            <th>MARZO</th>
                                            <th>ABRIL</th>
                                            <th>MAYO</th>
                                            <th>JUNIO</th>
                                            <th>JULIO</th>
                                            <th>AGOSTO</th>
                                            <th>SEPTIEMBRE</th>
                                            <th>OCTUBRE</th>
                                            <th>NOVIEMBRE</th>
                                            <th>DICIEMBRE</th>
                                            <th>TOTAL</th>
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
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaMedRecepPQRSF" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>MEDIO RECEPCION</th>
                                            <th>ENERO</th>
                                            <th>FEBRERO</th>
                                            <th>MARZO</th>
                                            <th>ABRIL</th>
                                            <th>MAYO</th>
                                            <th>JUNIO</th>
                                            <th>JULIO</th>
                                            <th>AGOSTO</th>
                                            <th>SEPTIEMBRE</th>
                                            <th>OCTUBRE</th>
                                            <th>NOVIEMBRE</th>
                                            <th>DICIEMBRE</th>
                                            <th>TOTAL</th>
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
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaServicioPQRSF" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>SERVICIO</th>
                                            <th>ENERO</th>
                                            <th>FEBRERO</th>
                                            <th>MARZO</th>
                                            <th>ABRIL</th>
                                            <th>MAYO</th>
                                            <th>JUNIO</th>
                                            <th>JULIO</th>
                                            <th>AGOSTO</th>
                                            <th>SEPTIEMBRE</th>
                                            <th>OCTUBRE</th>
                                            <th>NOVIEMBRE</th>
                                            <th>DICIEMBRE</th>
                                            <th>TOTAL</th>
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
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaEnteControlPQRSF" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ENTE CONTROL</th>
                                            <th>ENERO</th>
                                            <th>FEBRERO</th>
                                            <th>MARZO</th>
                                            <th>ABRIL</th>
                                            <th>MAYO</th>
                                            <th>JUNIO</th>
                                            <th>JULIO</th>
                                            <th>AGOSTO</th>
                                            <th>SEPTIEMBRE</th>
                                            <th>OCTUBRE</th>
                                            <th>NOVIEMBRE</th>
                                            <th>DICIEMBRE</th>
                                            <th>TOTAL</th>
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

<script src="views/js/pqr/reportes.js?v=<?= md5_file('views/js/pqr/reportes.js') ?>"></script>
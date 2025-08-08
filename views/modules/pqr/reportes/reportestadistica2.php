<div class="content">
    <h2 class="mb-3">Reporte Estadistica 2</h2>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">TIPO PQRSF Y EPS</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formRepEstadistica2Eps" name="formRepEstadistica2Eps" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <label class="">Año</label>
                                <select class="form-control select-field" name="fechaAnio1" id="fechaAnio1" required style="width: 100%;">
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
                            <div class="col-sm-12 col-md-4">
                                <label class="">Sede</label>
                                <select class="form-control select-field" name="sedePqrsf1" id="sedePqrsf1" onchange="listaEpsSedePqrsf(this, 'epsSedePqrsf1')" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="">Eps</label>
                                <select class="form-control select-field" name="epsSedePqrsf1" id="epsSedePqrsf1" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteEstadistica2Eps()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
            <div class="card shadow-none border border-300 mb-2" id="cardResulRepEstadistica2Eps" data-component-card="data-component-card" style="display: none;">
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
                                        <table id="tablaTipoPqrsfEps" class="table table-striped" style="width:100%;">
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
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">MOTIVO PQRSF Y EPS</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formRepEstadistica2EpsMotivo" name="formRepEstadistica2EpsMotivo" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <label class="">Año</label>
                                <select class="form-control select-field" name="fechaAnio2" id="fechaAnio2" required style="width: 100%;">
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
                            <div class="col-sm-12 col-md-4">
                                <label class="">Sede</label>
                                <select class="form-control select-field" name="sedePqrsf2" id="sedePqrsf2" onchange="listaEpsSedePqrsf(this, 'epsSedePqrsf2')" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="">Eps</label>
                                <select class="form-control select-field" name="epsSedePqrsf2" id="epsSedePqrsf2" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteEstadistica2EpsMotivo()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
            <div class="card shadow-none border border-300 mb-2" id="cardResulRepEstadistica2EpsMotivo" data-component-card="data-component-card" style="display: none;">
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
                                        <table id="tablaMotivoPqrsfEps" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>MOTIVO PQRSF</th>
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
    </div>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">TIPO PQRSF Y CLASIFICACION ATRIBUTO</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formRepEstadistica2ClasiAtribu" name="formRepEstadistica2ClasiAtribu" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-8">
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <label class="">Año</label>
                                <select class="form-control select-field" name="fechaAnio3" id="fechaAnio3" required style="width: 100%;">
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
                            <div class="col-sm-12 col-md-3">
                                <label class="">Sede</label>
                                <select class="form-control select-field" name="sedePqrsf3" id="sedePqrsf3" onchange="listaEpsSedePqrsf(this, 'epsSedePqrsf4')" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="">Eps</label>
                                <select class="form-control select-field" name="epsSedePqrsf4" id="epsSedePqrsf4" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="">Clasificacion Atributo</label>
                                <select class="form-control select-field" name="clasiAtributoPqrsf" id="clasiAtributoPqrsf" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteEstadistica2ClasiAtribu()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
            <div class="card shadow-none border border-300 mb-2" id="cardResulRepEstadistica2ClasiAtribu" data-component-card="data-component-card" style="display: none;">
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
                                        <table id="tablaTipoPqrsfClasiAtribu" class="table table-striped" style="width:100%;">
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
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">TIPO PQRSF Y ENTE DE CONTROL</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formRepEstadistica2EnteControl" name="formRepEstadistica2EnteControl" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-8">
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <label class="">Año</label>
                                <select class="form-control select-field" name="fechaAnio4" id="fechaAnio4" required style="width: 100%;">
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
                            <div class="col-sm-12 col-md-3">
                                <label class="">Sede</label>
                                <select class="form-control select-field" name="sedePqrsf4" id="sedePqrsf4" onchange="listaEpsSedePqrsf(this, 'epsSedePqrsf5')" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="">Eps</label>
                                <select class="form-control select-field" name="epsSedePqrsf5" id="epsSedePqrsf5" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="">Ente de Control</label>
                                <select class="form-control select-field" name="EnteControlPqrsf" id="EnteControlPqrsf" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteEstadistica2EnteControl()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
            <div class="card shadow-none border border-300 mb-2" id="cardResulRepEstadistica2EnteControl" data-component-card="data-component-card" style="display: none;">
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
                                        <table id="tablaTipoPqrsfEnteControl" class="table table-striped" style="width:100%;">
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
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">OPORTUNIDAD PQRSF Y EPS</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formRepEstadistica2OportunidadEps" name="formRepEstadistica2OportunidadEps" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <label class="">Año</label>
                                <select class="form-control select-field" name="fechaAnio5" id="fechaAnio5" required style="width: 100%;">
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
                            <div class="col-sm-12 col-md-4">
                                <label class="">Sede</label>
                                <select class="form-control select-field" name="sedePqrsf5" id="sedePqrsf5" onchange="listaEpsSedePqrsf(this, 'epsSedePqrsf3')" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="">Eps</label>
                                <select class="form-control select-field" name="epsSedePqrsf3" id="epsSedePqrsf3" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteEstadistica2OportunidadEps()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
            <div class="card shadow-none border border-300 mb-2" id="cardResulRepEstadistica2OportunidadEps" data-component-card="data-component-card" style="display: none;">
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
                                        <table id="tablaTipoPqrsfOportunidadEps" class="table table-striped" style="width:100%;">
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
                                                    <th>OPORTUNIDAD NORMATIVA</th>
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
    </div>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">OPORTUNIDAD PQRSF PROMEDIO HORAS</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formRepEstadistica2OportunidadSedeHoras" name="formRepEstadistica2OportunidadSedeHoras" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <label class="">Año</label>
                                <select class="form-control select-field" name="fechaAnio6" id="fechaAnio6" required style="width: 100%;">
                                    <option value="">Seleccione una opcion</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="">Sede</label>
                                <select class="form-control select-field" name="sedePqrsf6" id="sedePqrsf6" onchange="listaEpsSedePqrsf(this, 'epsSedePqrsf6')" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="">Eps</label>
                                <select class="form-control select-field" name="epsSedePqrsf6" id="epsSedePqrsf6" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteEstadistica2OportunidadSedeHoras()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
            <div class="card shadow-none border border-300 mb-2" id="cardResulRepEstadistica2OportunidadSedeHoras" data-component-card="data-component-card" style="display: none;">
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
                                        <table id="tablaTipoPqrsfOportunidadSedeHoras" class="table table-striped" style="width:100%;">
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
                                                    <th>OPORTUNIDAD NORMATIVA</th>
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
    </div>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">OPORTUNIDAD PQRSF PROMEDIO DIAS</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formRepEstadistica2OportunidadSedeDias" name="formRepEstadistica2OportunidadSedeDias" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <label class="">Año</label>
                                <select class="form-control select-field" name="fechaAnio7" id="fechaAnio7" required style="width: 100%;">
                                    <option value="">Seleccione una opcion</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="">Sede</label>
                                <select class="form-control select-field" name="sedePqrsf7" id="sedePqrsf7" onchange="listaEpsSedePqrsf(this, 'epsSedePqrsf7')" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="">Eps</label>
                                <select class="form-control select-field" name="epsSedePqrsf7" id="epsSedePqrsf7" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteEstadistica2OportunidadSedeDias()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
            <div class="card shadow-none border border-300 mb-2" id="cardResulRepEstadistica2OportunidadSedeDias" data-component-card="data-component-card" style="display: none;">
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
                                        <table id="tablaTipoPqrsfOportunidadSedeDias" class="table table-striped" style="width:100%;">
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
                                                    <th>OPORTUNIDAD NORMATIVA</th>
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
    </div>
</div>

<script src="views/js/pqr/reportes.js?v=<?= md5_file('views/js/pqr/reportes.js') ?>"></script>
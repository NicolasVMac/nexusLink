<div class="content">
    <h1>Modulo PAMEC Inicio</h1>
    <!-- <div class="row mb-5 mt-3">
        <div class="col-sm-12 col-md-6">
            <div class="card border border-300 h-100 w-100 overflow-hidden">
                <div class="card-body px-5 position-relative">
                    <div class="badge badge-phoenix fs--2 badge-phoenix-primary">
                        <span class="fw-bold">Manuales</span>
                    </div>
                    <hr>
                    <div id="containerManuales"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12 mb-2">
                            <div class="table-responsive">
                                <table id="tablaAvanceEstandares" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>SEDE</th>
                                            <th>ESTANDARES</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> -->
    
    <div class="row mb-5 mt-3">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <figure class="highcharts-figure m-0">
                        <div id="containerEstados"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <figure class="highcharts-figure m-0">
                        <div id="containerEstandaresSedes"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-5 mt-3">
        <div class="col-sm-12">
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <figure class="highcharts-figure m-0">
                        <div id="containerEstadosPorSede"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>




    <div class="row mb-3">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <form id="formSeleccionarSede" name="formSeleccionarSede" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-4"></div>
                            <div class="col-sm-12 col-md-4 text-center">
                                <label class="">Sede</label>
                                <select class="form-control select-field" id="selectSedes" name="selectSedes" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-4"></div>
                            <div class="col-sm-12 col-md-4 text-center">
                                <label class="">Periodo</label>
                                <select class="form-control select-field" id="selectPeriodo" name="selectPeriodo" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                        <center><button type="submit" class="btn btn-success" onclick="revisarAvanceEstandaresEvaluados()">Revisar Avance</button></center>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-12 col-md-12">
            <div id="cardGruposEstandares" class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card" style="display: none;">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="mb-2">
                            <span class="badge badge-phoenix badge-phoenix-danger m-1">NA: No Aplica</span><br>
                            <span class="badge badge-phoenix badge-phoenix-warning m-1">A: Abierto</span><small> Se guardo la informacion general del estandar</small><br>
                            <span class="badge badge-phoenix badge-phoenix-info m-1">EP: En Proceso</span><small> Se realizo evaluacion cualitativa o cuantitativa o priorizacion</small><br>
                            <span class="badge badge-phoenix badge-phoenix-success m-1">Completo: CERRADO TOTAL</span><small> Cuantos estandares se evaluaron en el periodo.</small><br>
                        </div>
                        <table id="tablaGruposEstandares" class="table table-striped table-bordered" style="width:100%;">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="align-middle">Grupos</th>
                                    <th rowspan="2" class="align-middle">Rango Estándar</th>
                                    <th rowspan="2" class="align-middle"># Estándares</th>
                                    <th rowspan="2" class="align-middle"># Criterios</th>
                                    <th colspan="5" class="text-center">Criterios</th>
                                    <th rowspan="2">Pendientes</th>
                                </tr>
                                <tr>
                                    <th>NA</th>
                                    <th>A</th>
                                    <th>EP</th>
                                    <th>C</th>
                                    <th>%</th>
                                </tr>
                            </thead>

                            <!-- <tbody>
                                    </tbody> -->
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-12 col-md-12">
            <div id="cardSubGruposEstandares" class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card" style="display: none;">
                <div class="card-body">

                    <div class="table-responsive">
                        <div class="mb-2">
                            <span class="badge badge-phoenix badge-phoenix-danger m-1">NA: No Aplica </span><br>
                            <span class="badge badge-phoenix badge-phoenix-warning m-1">A: Abierto </span><small> Se guardo la informacion general del estandar</small><br>
                            <span class="badge badge-phoenix badge-phoenix-info m-1">EP: En Proceso </span><small> Se realizo evaluacion cualitativa o cuantitativa o priorizacion</small><br>
                            <span class="badge badge-phoenix badge-phoenix-success m-1">Completo: CERRADO TOTAL </span><small> Cuantos estandares se evaluaron en el periodo.</small><br>
                        </div>
                        <table id="tablaSubGruposEstandares" class="table table-striped table-bordered" style="width:100%;">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="align-middle">Subgrupo de Estándares</th>
                                    <th rowspan="2" class="align-middle">Rango Estándar</th>
                                    <th rowspan="2" class="align-middle"># Estándares</th>
                                    <th rowspan="2" class="align-middle"># Criterios</th>
                                    <th colspan="5" class="text-center">Criterios</th>
                                    <th rowspan="2">Pendientes</th>
                                </tr>
                                <tr>
                                    <th>NA</th>
                                    <th>A</th>
                                    <th>EP</th>
                                    <th>C</th>
                                    <th>%</th>
                                </tr>
                            </thead>

                            <!-- <tbody>
                                    </tbody> -->
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="views/js/pamec/inicio.js?v=<?= md5_file('views/js/pamec/inicio.js') ?>"></script>
<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Consultar Autoevaluaciones</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formConsultarAutoevaluaciones" name="formConsultarAutoevaluaciones" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-2">
                    <div class="col-sm-6 col-md-2">
                        <label for="selectPeriodoAutoevaluacion" class=" text-black mb-1">PERIODO AUTOEVALUACION</label>
                        <select class="form-control select-field" id="selectPeriodoAutoevaluacion" name="selectPeriodoAutoevaluacion" style=" width:100%"></select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <label for="selGrupo" class="text-black mb-1">GRUPO</label>
                        <input type="hidden" id="idAutoevaluacion" name="idAutoevaluacion">
                        <select class="form-control select-field" id="selGrupo" name="grupo" onchange="onGrupoLoadSubGrupo(this)" style=" width:100%">
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <label for="selSubGrupo" class="text-black mb-1">SUBGRUPO</label>
                        <select class="form-control select-field" id="selSubGrupo" name="subGrupo" onchange="onSubGrupoLoadEstandar(this)" style=" width:100%">
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <label for="selEstandar" class=" text-black mb-1">ESTANDAR</label>
                        <select class="form-control select-field" id="selEstandar" name="estandar" style=" width:100%"></select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <label for="selSedesPamec" class="text-black mb-1">SEDES</label>
                        <select class="form-control select-field" id="selSedesPamec" name="selSedesPamec" style=" width:100%">
                        </select>
                    </div>

                </div>
                <hr>
                <div class="row text-center">
                    <div>
                        <button class="btn btn-outline-success" type="submit" onclick="consultarAutoevaluacion()">Consultar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-none border border-300 mb-2" id="cardResultadoConsultarAutoevaluacion" data-component-card="data-component-card" style="display: none;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Resultados:</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card">
                    <div class="card-body shadow-lg">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12 mb-2">
                                <div class="table-responsive">
                                    <table id="tablaResultadoConsultarAutoevaluacion" class="table table-striped" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>GRUPO</th>
                                                <th>SUB GRUPO</th>
                                                <th>ESTANDAR</th>
                                                <th>PERIODO</th>
                                                <th>SEDES</th>
                                                <th>ACCIONES</th>
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

    <script src="views/js/pamec/coordinador.js?v=<?= md5_file('views/js/pamec/coordinador.js') ?>"></script>
    <script src="views/js/pamec/parametricas.js?v=<?= md5_file('views/js/pamec/parametricas.js') ?>"></script>
<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Periodos Autoevaluaciones</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaListaPeriodos" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Periodo</th>
                                    <th>Estado</th>
                                    <th>Usuario Crea</th>
                                    <th>Fecha Crea</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <form id="formCrearPeriodoPamec" name="formCrearPeriodoPamec" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Gestion Periodos Autoevaluaciones</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3 justify-content-center">
                            <div class="col-sm-12 col-md-6 text-center">
                                <label for="nombrePeriodo" class="text-black mb-1">Periodo</label>
                                <input type="text" class="form-control" id="nombrePeriodo" name="nombrePeriodo" placeholder="2021-2022" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-12 col-md-12 text-center">
                                <button id="guardarperiodo" class="btn btn-outline-success me-1" onclick="guardarPeriodo()" type="submit">
                                    <i class="fa fa-floppy-disk"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script src="views/js/pamec/coordinador.js?v=<?= md5_file('views/js/pamec/coordinador.js') ?>"></script>
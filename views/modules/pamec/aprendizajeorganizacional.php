<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Lista Aprendizaje Organizacional</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaListaAprendizajeOrgGeneral" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PRIORIZACIÓN</th>
                            <th>CODIGO</th>
                            <th>ESTANDAR</th>
                            <th>OPORTUNIDAD DE MEJORA</th>
                            <th>ACCIONES COMPLETAS</th>
                            <th>AVANCE(%)</th>
                            <th>ESTADO</th>
                            <th>OBSERVACIONES</th>
                            <th>META AUTOEVALUACION</th>
                            <th>INDICADOR</th>
                            <th>META INDICADOR</th>
                            <th>CAL.OBS INICIO AUTOEVALUACIÓN</th>
                            <th>CAL.OBS INICIO INDICADOR</th>
                            <th>CAL.OBS FINAL</th>
                            <th>CAL.OBS FINAL INDICADOR</th>
                            <th>BARRERAS MEJORAMIENTO</th>
                            <th>APRENDIZAJE ORGANIZACIONAL</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetalleAprendizaje" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-300 shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Detalle Aprendizaje Organizacional</h5>
            </div>

            <div class="modal-body">
                <div id="contenDetalleAprendizaje"></div>
            </div>
        </div>
    </div>
</div>
<script src="views/js/pamec/gestion-priorizacion.js?v=<?= md5_file('views/js/pamec/gestion-priorizacion.js') ?>"></script>
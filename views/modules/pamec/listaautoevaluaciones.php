<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Lista Autoevaluaciones</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaEvaluadorListaAutoevaluaciones" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>GRUPO</th>
                            <th>SUB GRUPO</th>
                            <th>ESTANDAR</th>
                            <th>SEDE</th>
                            <th>PROGRAMA</th>
                            <th>ESTADO</th>
                            <th>USUARIO</th>
                            <th>FECHA CREA</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>  
        </div>
    </div>
</div>
<script src="views/js/pamec/autoevaluacion.js?v=<?= md5_file('views/js/pamec/autoevaluacion.js') ?>"></script>
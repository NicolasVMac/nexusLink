<div class="content">
    <!-- <h3 class="mb-3">Reportes Equipos Biomedicos</h3> -->
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Reportes Pagadores</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaReportesPagadores" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NOMBRE REPORTE</th>
                                    <th>DESCRIPCION</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

<script src="views/js/pagadores/reportes.js?v=<?= md5_file('views/js/pagadores/reportes.js') ?>"></script>
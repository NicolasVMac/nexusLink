<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Lista Pdf</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaListaPdfGestionar" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>NOMBRE ARCHIVO</th>
                            <th>ARCHIVO</th>
                            <th>USUARIO</th>
                            <th>FECHA CARGA</th>
                            <th>OPCION</th>
                        </tr>
                    </thead>
                </table>
            </div>  
        </div>
    </div>
</div>
<script src="views/js/pdfia/listapdf.js?v=<?= md5_file('views/js/pdfia/listapdf.js') ?>"></script>

<div class="content">

    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Cargar Base CAC</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formCargarArchivoCac" name="formCargarArchivoCac" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Nombre</label>
                        <input type="text" class="form-control" id="nombreArchivoCac" name="nombreArchivoCac" required>
                        <label class="">Archivo</label>
                        <input type="file" class="form-control" id="archivoCac" name="archivoCac" required>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <center><button type="submit" class="btn btn-success" onclick="cargarBaseCac()"><i class="far fa-save"></i> Cargar Base</button></center>
            </form>
        </div>
    </div>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Bases CAC</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaBasesCac" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>NOMBRE ARCHIVO</th>
                            <th>ARCHIVO</th>
                            <th>CANTIDAD</th>
                            <th>ESTADO</th>
                            <th>USUARIO</th>
                            <th>FECHA CARGA</th>
                        </tr>
                    </thead>
                </table>
            </div>  
        </div>
    </div>
</div>

<script src="views/js/cac/cac.js?v=<?= md5_file('views/js/cac/cac.js') ?>"></script>

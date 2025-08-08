<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <form id="formAgregarTrabajadorPQRSF" name="formAgregarTrabajadorPQRSF" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Agregar Trabajador PQRSF</h4>
                            </div>
                            <div class="col col-md-auto">
                                <button class="btn btn-phoenix-success ms-2" onclick="agregarTrabajadorPQRSF()"><i class="far fa-address-card"></i> Agregar Trabajador</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label class="">Tipo Documento</label>
                                <select class="form-control select-field" name="tipoDocumentoTrabajador" id="tipoDocumentoTrabajador" required>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label class="">Documento</label>
                                <input type="number" class="form-control" name="documentoTrabajador" id="documentoTrabajador" placeholder="Documento" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label class="">Nombre Completo</label>
                                <input type="text" class="form-control" name="nombreTrabajador" id="nombreTrabajador" placeholder="Nombre Completo" required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Trabajadores PQRSF</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaTrabajadoresPQRSF" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>TIPO DOCUMENTO</th>
                                    <th>DOCUMENTO</th>
                                    <th>NOMBRE</th>
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

<script src="views/js/pqr/parametricas.js?v=<?= md5_file('views/js/pqr/parametricas.js') ?>"></script>
<script src="views/js/pqr/pqr.js?v=<?= md5_file('views/js/pqr/pqr.js') ?>"></script>
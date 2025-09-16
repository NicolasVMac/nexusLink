<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-900 mb-0" data-anchor="data-anchor" id="basic-example">LISTA PAGADORES</h4>
                </div>
                <div class="col col-md-auto">
                    <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                        <button class="btn btn-outline-success me-1 mb-1" type="button" data-bs-toggle="modal" data-bs-target="#modalAgregarPagador"><i class="far fa-plus-square"></i> Agregar Pagador</button>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaPagadores" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TIPO PAGADOR</th>
                            <th>NOMBRE PAGADOR</th>
                            <th>TIPO IDENTIFICACION</th>
                            <th>NUMERO IDENTIFICACION</th>
                            <th>DIRECCION</th>
                            <th>TELEFONO</th>
                            <th>DEPARTAMENTO</th>
                            <th>CIUDAD</th>
                            <th>CORREOS</th>
                            <th>ESTADO</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>  
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgregarPagador">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formAgregarPagador" name="formAgregarPagador" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Pagador</h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Tipo Pagador</label>
                            <select class="form-select" name="tipoPagador" id="tipoPagador" style="width: 100%;" required>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Nombre Pagador</label>
                            <input type="text" class="form-control" name="nombrePagador" id="nombrePagador" placeholder="Nombre Pagador" required>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Tipo Identificacion</label>
                            <select class="form-select" name="tipoIdentiPagador" id="tipoIdentiPagador" style="width: 100%;" required>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Numero Identificacion</label>
                            <input type="number" class="form-control" name="numeroIdentiPagador" id="numeroIdentiPagador" placeholder="Numero Identificacion Pagador" required>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-2">
                            <label>Direccion Pagador</label>
                            <input type="text" class="form-control" name="direccionPagador" id="direccionPagador" placeholder="Direccion Pagador" required>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Telefono</label>
                            <input type="text" class="form-control" name="telefonoPagador" id="telefonoPagador" placeholder="Telefono Pagador" required>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Correo</label>
                            <input type="email" class="form-control" name="correoPagador" id="correoPagador" placeholder="Correo Pagador" required>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Departamento</label>
                            <select class="form-select" name="departamentoPagador" id="departamentoPagador" style="width: 100%;" required>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Ciudad</label>
                            <select class="form-select" name="ciudadPagador" id="ciudadPagador" style="width: 100%;" required>
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cerrar</button>
                    <button type="submit" class="btn btn-outline-success"onclick="agregarPagador()"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/contratacion/pagadores.js?v=<?= md5_file('views/js/contratacion/pagadores.js') ?>"></script>
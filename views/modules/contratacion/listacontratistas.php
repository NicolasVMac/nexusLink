<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-black mb-0">Agregar Contratista</h4>
                        </div>
                        <!-- <div class="col col-md-auto">
                            <button class="btn btn-phoenix-success ms-2" data-bs-toggle="modal" data-bs-target="#modalAgregarContratista"><i class="fas fa-briefcase"></i> Agregar Contratista</button>
                        </div> -->
                        <div class="col col-md-auto">
                            <button class="btn btn-phoenix-success ms-2" onclick="cargarModal()"><i class="fas fa-briefcase"></i> Agregar Contratista</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaListaContratistas" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>TIPO</th>
                                    <th>NOMBRE CONTRATISTA</th>
                                    <th>TIPO IDENTIFICACION</th>
                                    <th>NUMERO IDENTIFICACION</th>
                                    <th>NATURALEZA</th>
                                    <th>DIRECCION</th>
                                    <th>TELEFONO</th>
                                    <th>DEPARTAMENTO</th>
                                    <th>CIUDAD</th>
                                    <th>CORREO</th>
                                    <th>ESTADO</th>
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

<div class="modal fade" id="modalAgregarContratista">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAgregarContratista" name="formAgregarContratista" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Contratista</h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-2">
                            <label class="">Tipo Contratista</label>
                            <select class="form-control select-field" id="tipoContratista" name="tipoContratista" required style="width: 100%;">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-2">
                            <label class="">Nombre Contratista</label>
                            <input type="text" class="form-control" name="nombreContratistaContratista" id="nombreContratistaContratista" placeholder="Nombre Contratista" required>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Tipo Documento</label>
                            <select class="form-control select-field" id="tipoDocumentoContratista" name="tipoDocumentoContratista" required style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Numero Documento</label>
                            <input type="number" class="form-control" name="numeroDocumentoContratista" id="numeroDocumentoContratista" placeholder="Numero Documento" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Naturaleza</label>
                            <select class="form-control" id="naturalezaContratista" name="naturalezaContratista" required style="width: 100%;">
                                <option value="">Seleccione una opcion</option>
                                <option value="NATURAL">NATURAL</option>
                                <option value="JURIDICA">JURIDICA</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Direccion</label>
                            <input type="text" class="form-control" name="direccionContratista" id="direccionContratista" placeholder="Direccion" minlength="5" maxlength="150" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Telefono</label>
                            <input type="number" class="form-control" name="telefonoContratista" id="telefonoContratista" placeholder="3000000000" required>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Departamento</label>
                            <select class="form-control select-field" id="departamentoContratista" name="departamentoContratista" required style="width: 100%;">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Ciudad</label>
                            <select class="form-control select-field" id="ciudadContratista" name="ciudadContratista" required style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Correo Electronico</label>
                            <input type="email" class="form-control" name="correoContratista" id="correoContratista" placeholder="correo@correo.com" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="agregarContratista()" type="button"><i class="far fa-save"></i> Guardar</button>
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/contratacion/contratista.js?v=<?= md5_file('views/js/contratacion/contratista.js') ?>"></script>
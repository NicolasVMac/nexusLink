<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Administracion Profesionales</h4>
                </div>
                <div class="col col-md-auto">
                    <button class="btn btn-phoenix-success ms-2" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuarioProfesional"><i class="far fa-calendar-plus"></i> Agregar Usuario Profesional</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaAdminProfesionales" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TIPO ENCUESTA</th>
                            <th>PROCESO</th>
                            <th>NOMBRE PROFESIONAL</th>
                            <th>DOCUMENTO PROFESIONAL</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>  
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgregarUsuarioProfesional">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAgregarUsuarioProfesional" name="formAgregarUsuarioProfesional" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Profesional</h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label class="">Tipo Encuesta</label>
                            <select class="form-control" id="tipoEncuesta" name="tipoEncuesta" onchange="changeTipoEncuesta()" required style="width: 100%;">
                                <option value="">Seleccione un Tipo Encuesta</option>
                                <option value="AUTOINMUNES">AUTOINMUNES</option>
                                <option value="VIH">VIH</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label class="">Proceso Encuesta</label>
                            <select class="form-control" id="procesoEncuesta" name="procesoEncuesta" required style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-2">
                            <label>Nombre Profesional</label>
                            <input type="text" class="form-control" name="nombreProfesional" id="nombreProfesional" placeholder="Nombre Profesional" required>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Tipo Documento</label>
                            <select class="form-control" id="tipoDocumento" name="tipoDocumento" required style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Numero Documento</label>
                            <input type="number" class="form-control" name="numeroDocumento" id="numeroDocumento" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="agregarUsuarioProfesional()" type="button"><i class="far fa-save"></i> Guardar</button>
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/encuestas/encuestas.js?v=<?= md5_file('views/js/encuestas/encuestas.js') ?>"></script>
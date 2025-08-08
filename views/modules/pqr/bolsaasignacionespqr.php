<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Asignaciones PQRSF</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaAsignacionesPQRS" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE PACIENTE</th>
                            <th>DOCUMENTO PACIENTE</th>
                            <th>TIPO PQRSF</th>
                            <th>MOTIVO PQRSF</th>
                            <th>SERVICIO O AREA</th>
                            <th>CLASIFICACION ATRIBUTO</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>  
        </div>
    </div>
</div>

<div class="modal fade" id="modalVerPQR">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Ver PQRSF</h5>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-12">
                        <label># PQRSF</label>
                        <label class="form-control" id="txtIdPQRS"></label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4">
                        <label>Nombre Paciente</label>
                        <label class="form-control" id="txtNombrePac"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Tipo Identificacion Paciente</label>
                        <label class="form-control" id="txtTipoDocPac"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Numero Identificacion Paciente</label>
                        <label class="form-control" id="txtNumDocPac"></label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4">
                        <label>Fecha Nacimiento</label>
                        <label class="form-control" id="txtFechaNacPac"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>EPS</label>
                        <label class="form-control" id="txtEps"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Regimen</label>
                        <label class="form-control" id="txtRegimenEps"></label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4">
                        <label>Programa</label>
                        <label class="form-control" id="txtPrograma"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Sede</label>
                        <label class="form-control" id="txtSede"></label>
                    </div>
                </div>
                <hr>
                <h4 class="mb-4">Descripcion PQRSF</h4>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4">
                        <label>Nombre Peticionario</label>
                        <label class="form-control" id="txtNombrePet"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Tipo Identificacion Peticionario</label>
                        <label class="form-control" id="txtTipoDocPet"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Numero Identificacion Peticionario</label>
                        <label class="form-control" id="txtNumDocPet"></label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4">
                        <label>Contacto Peticionario</label>
                        <label class="form-control" id="txtContactoPet"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Correo Peticionario</label>
                        <label class="form-control" id="txtCorreoPet"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Fecha PQRSF</label>
                        <label class="form-control" id="txtFechaPQRSF"></label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4">
                        <label class="">Departamento</label>
                        <label class="form-control" id="txtDepPet"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Municipio</label>
                        <label class="form-control" id="txtMunPet"></label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-12">
                        <label>Descripcion PQRSF</label>
                        <label class="form-control" id="txtDescripcionPqr"></label>
                    </div>
                </div>
                <hr>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4">
                        <label>Medio Recepcion PQRSF</label>
                        <label class="form-control" id="txtMedRecepPqr"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Fecha Apertura Buzon de Sugerencias</label>
                        <label class="form-control" id="txtFechaAperBuzonSug"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Fecha Hora Radicacion PQRSF</label>
                        <label class="form-control" id="txtFechaHoraRadPqr"></label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4">
                        <label>Tipo PQRSF</label>
                        <label class="form-control" id="txtTipoPqr"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Ente Reporte PQRSF</label>
                        <label class="form-control" id="txtEnteRepPqr"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Motivo PQRSF</label>
                        <label class="form-control" id="txtMotivoPqr"></label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4">
                        <label>Trabajador Relacionado PQRSF</label>
                        <label class="form-control" id="txtTrabajadorRelaPqr"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Servicio o Area Involucrado</label>
                        <label class="form-control" id="txtServAreaPqr"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Clasificacion Atributo</label>
                        <label class="form-control" id="txtCaliAtribuPqr"></label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4">
                        <label>Gestor</label>
                        <label class="form-control" id="txtGestorPqr"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Tiempo Respuesta Normativo</label>
                        <label class="form-control" id="txtTiempoResNormaPqr"></label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Horas o Dias Oportunidad</label>
                        <label class="form-control" id="txtHorasDiasOportPqr"></label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-12">
                        <label>Archivos</label>
                        <div id="containerArchivosPQRSF"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button class="btn btn-success" onclick="agregarUsuarioProfesional()" type="button"><i class="far fa-save"></i> Guardar</button> -->
                <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="views/js/pqr/pqr.js?v=<?= md5_file('views/js/pqr/pqr.js') ?>"></script>
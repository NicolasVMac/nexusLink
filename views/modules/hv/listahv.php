<div class="content">
    <!-- <h3 class="mb-3"></h3> -->
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Lista HV</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaListaHV" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th>NUMERO DOCUMENTO</th>
                                    <th>FECHA NACIMIENTO</th>
                                    <th>NACIONALIDAD</th>
                                    <th>PROFESION</th>
                                    <th>CORREO ELECTRONICO</th>
                                    <th>DIRECCION</th>
                                    <th>CELULAR</th>
                                    <th>TELEFONO</th>
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

<div class="modal fade" id="modalVerHV">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="exampleModalLabel">Ver HV</h5>
                <button class="btn p-1 text-primary" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionDatosPersonales">
                    <div class="accordion-item border-top border-300">
                        <h2 class="accordion-header" id="headingOne">

                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDatosPersonales" aria-expanded="true" aria-controls="collapseDatosPersonales">
                                DATOS PERSONALES
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse show" id="collapseDatosPersonales" aria-labelledby="headingOne" data-bs-parent="#accordionDatosPersonales">
                            <div class="accordion-body pt-0">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-3">
                                                <label class="text-900">Tipo Documento</label>
                                                <div id="tipoDocumentoDpVer"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <label class="text-900">Numero Documento</label>
                                                <div id="numeroDocumentoDpVer"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Nombre Completo</label>
                                                <div id="nombreCompletoDpVer"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-3">
                                                <label class="text-900">Fecha Nacimiento</label>
                                                <div id="fechaNacimientoDpVer"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <label class="text-900">Nacionalidad</label>
                                                <div id="nacionalidadDpVer"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Profesion</label>
                                                <div id="profesionDpVer"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Correo Electronico</label>
                                                <div id="correoElectronicoDpVer"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Direccion Residencia</label>
                                                <div id="direccionDpVer"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-3">
                                                <label class="text-900">Celular</label>
                                                <div id="celularDpVer"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <label class="text-900">Telefono</label>
                                                <div id="telefonoDpVer"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Archivos</label>
                                                <div id="containerArchivosDatosPersonalesVer" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion" id="accordionEstudios">
                    <div class="accordion-item border-top border-300">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEstudios" aria-expanded="false" aria-controls="collapseEstudios">
                                ESTUDIOS
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse" id="collapseEstudios" aria-labelledby="headingOne" data-bs-parent="#accordionEstudios">
                            <div class="accordion-body pt-0">
                                <div id="containerEstudios"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion" id="accordionExpLaborales">
                    <div class="accordion-item border-top border-300">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExpLaborales" aria-expanded="false" aria-controls="collapseExpLaborales">
                                EXPERIENCIAS LABORARES
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse" id="collapseExpLaborales" aria-labelledby="headingOne" data-bs-parent="#accordionExpLaborales">
                            <div id="containerTiempoExpLaboral"></div>
                            <div id="containerExpLaborales"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script src="views/js/hv/hv.js?v=<?= md5_file('views/js/hv/hv.js') ?>"></script>
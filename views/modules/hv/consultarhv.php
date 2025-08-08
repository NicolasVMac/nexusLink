<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Consultar Hoja de Vida</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formConsultarHv" name="formConsultarHv" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-3">
                        <label class="text-900">Numero Documento</label>
                        <input type="number" class="form-control" name="numDocumentoBuscar" id="numDocumentoBuscar" min="0">
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <label class="text-900">Tipo Formacion</label>
                        <select class="form-control select-field" name="tipoFormacionBuscar" id="tipoFormacionBuscar" style="width: 100%;">
                            <option value="">Seleccione una opcion</option>
                            <option value="BACHILLERATO">BACHILLERATO</option>
                            <option value="TECNICO LABORAL">TECNICO LABORAL</option>
                            <option value="TECNICO PROFESIONAL">TECNICO PROFESIONAL</option>
                            <option value="TECNOLOGICA">TECNOLOGICA</option>
                            <option value="UNIVERSITARIA">UNIVERSITARIA</option>
                            <option value="ESPECIALIZACION">ESPECIALIZACION</option>
                            <option value="MAESTRIA">MAESTRIA</option>
                            <option value="DOCTORADO">DOCTORADO</option>
                            <option value="ESTUDIOS NO FORMALES">ESTUDIOS NO FORMALES</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <label class="text-900">Profesion</label>
                        <input type="text" class="form-control" name="profesionBuscar" id="profesionBuscar" placeholder="Profesion">
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <label class="text-900">Palabra Clave</label>
                        <input type="text" class="form-control" name="palabraClaveBuscar" id="palabraClaveBuscar" placeholder="Profesion">
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div>
                        <button class="btn btn-outline-success" type="submit" onclick="consultarHv()">Consultar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-none border border-300 mb-2" id="cardResultadoConsultarHv" data-component-card="data-component-card" style="display: none;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Resultados:</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="card">
                        <div class="card-body shadow-lg">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-12 mb-2">
                                    <div class="table-responsive">
                                        <table id="tablaResultadoConsultarHv" class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>NOMBRE</th>
                                                    <th>NUMERO DOCUMENTO</th>
                                                    <th>CORREO</th>
                                                    <th>CELULAR</th>
                                                    <th>PROFESION</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
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

<script src="views/js/hv/parametricas.js?v=<?= md5_file('views/js/hv/parametricas.js') ?>"></script>
<script src="views/js/hv/hv.js?v=<?= md5_file('views/js/hv/hv.js') ?>"></script>
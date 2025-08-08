<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Correspondencia Recibida</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaCorresponRecCargada" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ASUNTO</th>
                                    <th>TIPO CORRESPONDENCIA</th>
                                    <th>PROYECTO</th>
                                    <th>RESPONSABLE</th>
                                    <th>ESTADO ASIGNACION</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>  
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <form id="formCrearCorresponRec" name="formCrearCorresponRec" method="post" enctype="multipart/form-data" onsubmit="return false;">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Cargar Correspondencia</h4>
                            </div>
                            <div class="col col-md-auto">
                                <button class="btn btn-phoenix-success ms-2" onclick="crearCorresponRec()"><i class="far fa-plus-square"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label>Asunto</label>
                                <input type="text" class="form-control" name="nuevoAsunCorresponRec" id="nuevoAsunCorresponRec" minlength="10" maxlength="250" placeholder="Asunto" required>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label>Observaciones</label>
                                <textarea class="form-control" name="nuevoObservacionesCorresponRec" id="nuevoObservacionesCorresponRec" rows="5" minlength="10" maxlength="2000" placeholder="Observaciones" required></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label>Proyecto</label>
                                <select class="form-control select-field" id="nuevoProyectoCorresRec" onchange="changeProyectoCorresponRec(this)" name="nuevoProyectoCorresRec" style="width: 100%;" required>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label>Responsable Proyecto</label>
                                <input type="text" class="form-control readonly" name="responProyectoCorresRec" id="responProyectoCorresRec" readonly>
                                <input type="hidden" class="form-control" name="idResponProyectoCorresRec" id="idResponProyectoCorresRec" readonly>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-2" style="display: none;" id="containerTipoCorrespondenciaRec">
                                <label>Tipo Correspondencia</label>
                                <select class="form-control select-field" id="nuevoTipoCorresponRec" name="nuevoTipoCorresponRec" onchange="changeTipoCorresponRec(this)" style="width: 100%;" required>
                                    <option value="">Seleccione una opcion</option>
                                    <option value="FACTURAS/RECIBOS">FACTURAS/RECIBOS</option>
                                    <option value="DOCUMENTOS">DOCUMENTOS</option>
                                    <!-- <option value="RADICADOS/RESPUESTAS">RADICADOS/RESPUESTAS</option> -->
                                </select>
                            </div>
                            <div id="containerRadicadoCorresRec" class="mb-2" style="display: none;">
                            </div>
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label>Archivos</label>
                                <input class="form-control" id="nuevoArchivosCorresponRec" name="nuevoArchivosCorresponRec" accept=".pdf" type="file" multiple="multiple" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVerCorresRec">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning" id="exampleModalLabel">Ver Correspondencia Recibida</h5>
                <button class="btn p-1 text-warning" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                        <label class="fw-bold"># Correspondenvia Rec</label>
                        <div id="textIdCorresRecibida"></div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                        <label class="fw-bold">Asunto</label>
                        <div id="textAsuntoVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                        <label class="fw-bold">Observaciones</label>
                        <div id="textObservacionesVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                        <label class="fw-bold">Proyecto</label>
                        <div id="textProyectoVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                        <label class="fw-bold">Responsable Proyecto</label>
                        <div id="textResponsableProyectoVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                        <label for="" class="fw-bold">Documentos Recibidos</label>
                        <div id="contenedorArchivosCorresRec"></div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 mb-2">
                        <label class="fw-bold">Tipo Correspondencia</label>
                        <div id="textTipoCorresponVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 mb-2">
                        <label class="fw-bold">Usuario Crea</label>
                        <div id="textUsuarioCreaVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 mb-2">
                        <label class="fw-bold">Fecha Crea</label>
                        <div id="textFechaCreaVer"></div>
                    </div>
                    <div id="contenedorHasCorresEnv"></div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button class="btn btn-primary" type="button">Okay</button> -->
                <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReAsignarCorresRec">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formReAsignarCorresRec" name="formReAsignarCorresRec" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="exampleModalLabel">Re-Asignar Correspondecia Recibida</h5>
                    <button class="btn p-1 text-primary" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-2">
                            <label>Asunto</label>
                            <input type="text" class="form-control" name="asuntoCorresRecReAsignar" id="asuntoCorresRecReAsignar" minlength="10" maxlength="250" placeholder="Asunto" required>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-2">
                            <label>Observaciones</label>
                            <textarea class="form-control" name="observacionesCorresRecReAsignar" id="observacionesCorresRecReAsignar" rows="5" minlength="10" maxlength="2000" placeholder="Observaciones" required></textarea>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label for="organizerSingle">Proyecto</label>
                            <select class="form-select" id="proyectoCorresRecReAsignar" name="proyectoCorresRecReAsignar" onchange="changeProyectoCorresponRecReAsignar(this)" style="width: 100%;" required>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label>Responsable Proyecto</label>
                            <input type="text" class="form-control readonly" name="responProyectoCorresRecReAsignar" id="responProyectoCorresRecReAsignar" readonly>
                            <input type="hidden" class="form-control" name="idResponProyectoCorresRecReAsignar" id="idResponProyectoCorresRecReAsignar" readonly>
                            <input type="hidden" class="form-control" name="idResponProyectoCorresRecOld" id="idResponProyectoCorresRecOld" readonly>
                            <input type="hidden" class="form-control" name="idCorresRecReAsignar" id="idCorresRecReAsignar" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
                    <button class="btn btn-success" onclick="reAsignarCorrespondenciaRec()"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/correspon/parametricas.js?v=<?= md5_file('views/js/correspon/parametricas.js') ?>"></script>
<script src="views/js/correspon/correspondencia-recibida.js?v=<?= md5_file('views/js/correspon/correspondencia-recibida.js') ?>"></script>
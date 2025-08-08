<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Mi Correspondencia</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaMiCorrespondenciaEnviada" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ASUNTO</th>
                                    <th>PROYECTO</th>
                                    <th>CODIGO</th>
                                    <th>DESTINATARIO</th>
                                    <th>TIPO COMUNICACION</th>
                                    <th>FECHA CREA</th>
                                    <th>ESTADO</th>
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
                <form id="formAgregarConsecutivo" name="formAgregarConsecutivo" method="post" enctype="multipart/form-data" onsubmit="return false;">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Nuevo Consecutivo</h4>
                            </div>
                            <div class="col col-md-auto">
                                <button class="btn btn-phoenix-success ms-2" onclick="crearNuevoConsecutivo()"><i class="far fa-plus-square"></i> Generar Nuevo Consecutivo</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label>Proyecto</label>
                                <select class="form-control select-field" id="proyectosCorrespondencia" name="proyectosCorrespondencia" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label>Tipo Comuinicacion</label>
                                <select class="form-control select-field" id="tipoComuniCorrespondencia" name="tipoComuniCorrespondencia" required style="width: 100%;">
                                    <option value="">Seleccione una opcion</option>
                                    <option value="INTERNA">INTERNA</option>
                                    <option value="EXTERNA">EXTERNA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--=====================================
MODAL ANULAR CORRESPONDENCIA
======================================-->
<div class="modal fade" id="modalAnularCorres" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="exampleModalLabel">Anular Correspondencia</h5>
                <button class="btn p-1 text-danger" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <form id="formAnularCorrespondencia" name="formAnularCorrespondencia" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header p-3 border-bottom border-300">
                                    <div class="row g-1 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-danger mb-0">Informacion Correspondencia</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Codigo</label>
                                            <div id="textCodigoAnular"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Proyecto</label>
                                            <div id="textProyectoAnular"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Descripcion</label>
                                            <div id="textDescripcionAnular"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Destinatario</label>
                                            <div id="textDestinatarioAnular"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Tipo Comunicacion</label>
                                            <div id="textTipoComunicacionAnular"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Asunto</label>
                                            <div id="textAsuntoAnular"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Usuario Crea</label>
                                            <div id="textUsuarioCreaAnular"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Fecha Crea</label>
                                            <div id="textFechaCreaAnular"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-2">
                                <label for="accionAnular" class="fw-bold">Accion</label>
                                <select class="form-control" name="accionAnular" id="accionAnular" required>
                                    <option value="">Seleccione una opcion</option>
                                    <option value="ANULADO">ANULAR</option>
                                </select>
                                <input type="hidden" id="idCorresEnvAnular" name="idCorresEnvAnular">
                                <input type="hidden" id="codigoCorresAnular" name="codigoCorresAnular">
                            </div>
                            <div class="mb-2">
                                <label for="observacionesAnula" class="fw-bold">Observaciones</label>
                                <textarea class="form-control" rows="4" name="observacionesAnula" id="observacionesAnula" placeholder="Observaciones Anula" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
                    <button type="submit" class="btn btn-success" onclick="anularCorrespondenciaEnv()"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--=====================================
MODAL RADICAR CORRESPONDENCIA
======================================-->
<div class="modal fade" id="modalRadicarCorres" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="exampleModalLabel">Radicar Correspondencia</h5>
                <button class="btn p-1 text-primary" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <form id="formRadicarCorrespondencia" name="formRadicarCorrespondencia" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header p-3 border-bottom border-300">
                                    <div class="row g-1 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-primary mb-0">Informacion Correspondencia</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Codigo</label>
                                            <div id="textCodigoRadCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Proyecto</label>
                                            <div id="textProyectoRadCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Tipo Comunicacion</label>
                                            <div id="textTipoComunicacionCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Usuario Crea</label>
                                            <div id="textUsuarioCreaRadCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Fecha Crea</label>
                                            <div id="textFechaCreaRadCorres"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-2">
                                <label for="asuntoRadCorres" class="fw-bold">Asunto</label>
                                <input type="text" class="form-control" id="asuntoRadCorres" name="asuntoRadCorres" minlength="10" maxlength="250" placeholder="Asunto" required>
                                <input type="hidden" id="idCorresEnvRadCorres" name="idCorresEnvRadCorres">
                            </div>
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label>Descripcion</label>
                                <textarea class="form-control editor" rows="5" name="descripcionRadCorres"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label>Destinatario</label>
                                <select class="form-control" id="destinatarioRadCorres" name="destinatarioRadCorres" data-choices="data-choices" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="archivosRadCorres" class="fw-bold">Archivos</label>
                                <input class="form-control" id="archivosRadCorres" name="archivosRadCorres" accept=".pdf" type="file" multiple="multiple" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
                    <button type="submit" class="btn btn-success" onclick="radicarCorrespondenciaEnv()"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--=====================================
MODAL RESPUESTA RADICACION CORRESPONDENCIA
======================================-->
<div class="modal fade" id="modalRespuestaCorres" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="exampleModalLabel">Respuesta Radicacion Correspondencia</h5>
                <button class="btn p-1 text-success" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <form id="formRespuestaCorrespondencia" name="formRespuestaCorrespondencia" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header p-3 border-bottom border-300">
                                    <div class="row g-1 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-success mb-0">Informacion Correspondencia</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Codigo</label>
                                            <div id="textCodigoRespCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Proyecto</label>
                                            <div id="textProyectoRespCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Descripcion</label>
                                            <div id="textDescripcionRespCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Destinatario</label>
                                            <div id="textDestinatarioRespCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Tipo Comunicacion</label>
                                            <div id="textTipoComunicacionRespCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Asunto</label>
                                            <div id="textAsuntoRespCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Documentos Radicados</label>
                                            <div id="containerArchivosEnviadosCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Usuario Crea</label>
                                            <div id="textUsuarioCreaRespCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Fecha Crea</label>
                                            <div id="textFechaCreaRespCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Usuario Radica</label>
                                            <div id="textUsuarioRadicaRespCorres"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Fecha Radica</label>
                                            <div id="textFechaRadicaRespCorres"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-2">
                                <label for="radicadoRespCorres" class="fw-bold">Radicado</label>
                                <input type="text" class="form-control" id="radicadoRespCorres" name="radicadoRespCorres" minlength="10" maxlength="250" placeholder="Radicado" required>
                                <input type="hidden" id="idCorresEnvRespCorres" name="idCorresEnvRespCorres">
                            </div>
                            <div class="mb-2">
                                <label for="archivosRespCorres" class="fw-bold">Archivos</label>
                                <input class="form-control" id="archivosRespCorres" name="archivosRespCorres" accept=".pdf" type="file" multiple="multiple" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
                    <button type="submit" class="btn btn-success" onclick="respuestaCorrespondenciaEnv()"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--=====================================
MODAL VER CORRESPONDENCIA
======================================-->
<div class="modal fade" id="modalVerCorres" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning" id="exampleModalLabel">Ver Correspondencia</h5>
                <button class="btn p-1 text-warning" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <form id="formRespuestaCorrespondencia" name="formRespuestaCorrespondencia" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="card shadow-sm mb-2">
                                <div class="card-header p-3 border-bottom border-300">
                                    <div class="row g-1 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-info mb-0">Informacion Correspondencia</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                                            <label for="" class="fw-bold">Codigo</label>
                                            <div id="textCodigoVer"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 mb-2">
                                            <label for="" class="fw-bold">Proyecto</label>
                                            <div id="textProyectoVer"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 mb-2">
                                            <label for="" class="fw-bold">Tipo Comunicacion</label>
                                            <div id="textTipoComunicacionVer"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Asunto</label>
                                            <div id="textAsuntoVer"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Usuario Crea</label>
                                            <div id="textUsuarioCreaVer"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Fecha Crea</label>
                                            <div id="textFechaCreaVer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="containerCorrespondenciaAnulado"></div>
                            

                            <div class="card shadow-sm mb-2">
                                <div class="card-header p-3 border-bottom border-300">
                                    <div class="row g-1 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-primary mb-0">Correspondencia Radicada</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Descripcion</label>
                                            <div id="textDescripcionRadicacionVer"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Destinatario</label>
                                            <div id="textDestinatarioRadicacionVer"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Documentos Radicados</label>
                                            <div id="containerArchivosEnviadosCorresVer"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Usuario Radicacion</label>
                                            <div id="textUsuarioRadicacionVer"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Fecha Radicacion</label>
                                            <div id="textFechaRadicacionVer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm mb-2">
                                <div class="card-header p-3 border-bottom border-300">
                                    <div class="row g-1 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-success mb-0">Respuesta Correspondencia Radicada</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Documentos Respuesta Radicada</label>
                                            <div id="containerArchivosRespuestaCorresVer"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Usuario Respuesta</label>
                                            <div id="textUsuarioRadicadoVer"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Fecha Respuesta</label>
                                            <div id="textFechaRadicadoVer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
                    <!-- <button type="submit" class="btn btn-success" onclick="respuestaCorrespondenciaEnv()"><i class="fas fa-save"></i> Guardar</button> -->
                </div>
            </form>
        </div>
    </div>
</div>



<script src="views/js/correspon/parametricas.js?v=<?= md5_file('views/js/correspon/parametricas.js') ?>"></script>
<script src="views/js/correspon/correspondencia-enviada.js?v=<?= md5_file('views/js/correspon/correspondencia-enviada.js') ?>"></script>
<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Lista Correspondencia Enviada</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaListaCorrespondenciaEnviada" class="table table-striped" style="width:100%;">
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

<script src="views/js/correspon/correspondencia-enviada.js?v=<?= md5_file('views/js/correspon/correspondencia-enviada.js') ?>"></script>
<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Lista Correspondencia Facturas/Recibos</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaBolsaCorrespondenciaFactuReci" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ASUNTO</th>
                                    <th>PROYECTO</th>
                                    <th>TIPO CORRESPONDENCIA</th>
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
                    <div id="contenedorHasGestionCorresEnv"></div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button class="btn btn-primary" type="button">Okay</button> -->
                <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--=====================================
MODAL APROBAR CORRESPONDENCIA
======================================-->
<div class="modal fade" id="modalAprobarFacRec" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="exampleModalLabel">Aprobar Factura/Recibo</h5>
                <button class="btn p-1 text-primary" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <form id="formAprobarCorrFacRec" name="formAprobarCorrFacRec" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-2">
                            <label>Estado Aprobacion</label>
                            <input type="hidden" readonly id="idCorresRecApro" name="idCorresRecApro">
                            <select class="form-control select-field" id="estadoAprobacion" name="estadoAprobacion" required style="width: 100%;">
                                <option value="">Seleccione una opcion</option>
                                <option value="APROBADO">APROBADO</option>
                                <option value="NO_APROBADO">NO APROBADO</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-2">
                            <label>Observaciones</label>
                            <textarea class="form-control" name="observacionesEstadoAprobacion" id="observacionesEstadoAprobacion" rows="5" minlength="5" required maxlength="1000"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
                    <button type="submit" class="btn btn-success" onclick="guardarAprobacionFacRec()"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/correspon/correspondencia-recibida.js?v=<?= md5_file('views/js/correspon/correspondencia-recibida.js') ?>"></script>
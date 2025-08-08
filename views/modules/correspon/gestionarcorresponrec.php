<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Gestionar Correspondencia Recibida</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                <div class="card-header p-4 border-bottom border-300 bg-info">
                                    <div class="row g-3 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-white mb-0">Informacion Correspondencia Recibida</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
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
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                <form id="formGestionarCorresponRec" name="formGestionarCorresponRec" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                    <div class="card-header p-4 border-bottom border-300 bg-success">
                                        <div class="row g-3 justify-content-between align-items-center">
                                            <div class="col-12 col-md">
                                                <h5 class="text-white mb-0">Gestionar Correspondencia Recibida</h5>
                                            </div>
                                            <div class="col col-md-auto">
                                                <div class="nav nav-underline justify-content-end doc-tab-nav align-items-center">
                                                    <button class="btn btn-phoenix-success ms-2" onclick="gestionCorrespondenciaRecibida()"><i class="fas fa-save"></i> Gestionar Correspondencia</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 mb-2">
                                                <label>Observaciones</label>
                                                <textarea class="form-control" name="observaGestionCorresRec" id="observaGestionCorresRec" rows="5" minlength="10" maxlength="2000" placeholder="Observaciones" required></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-12 mb-2">
                                                <label>Archivos</label>
                                                <input class="form-control" id="archivosGestionCorresponRec" name="archivosGestionCorresponRec" accept=".pdf" type="file" multiple="multiple" required>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="views/js/correspon/parametricas.js?v=<?= md5_file('views/js/correspon/parametricas.js') ?>"></script>
<script src="views/js/correspon/correspondencia-recibida.js?v=<?= md5_file('views/js/correspon/correspondencia-recibida.js') ?>"></script>
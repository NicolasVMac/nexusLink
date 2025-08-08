<div class="content">
    <h2 class="mb-2">Gestionar Ticket</h2>
    <hr>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div id="contenedorAlertaTicketPostRealizado"></div>
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="table-responsive">
                    <div class="card-header p-4 border-bottom border-300 bg-primary">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0"><i class="fas fa-list-alt"></i> Informacion Ticket</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label class=" text-primary">Nombre Usuario Solicitud</label><div id="textNombreUsuarioSolicitud"></div>
                            </div>
                            <div class="col-md-4">
                                <label class=" text-primary">Usuario Solicitud</label><div id="textUsuarioSolicitud"></div>
                            </div>
                            <div class="col-md-4">
                                <label class=" text-primary">Fecha Ticket</label><div id="textFechaTicket"></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <label class=" text-primary"># Ticket</label><div id="textIdTicket"></div>
                            </div>
                            <div class="col-md-3">
                                <label class=" text-primary">Estado Ticket</label><div id="textEstadoTicket"></div>
                            </div>
                            <div class="col-md-3">
                                <label class=" text-primary">Proyecto</label><div id="textProyecto"></div>
                            </div>
                            <div class="col-md-3">
                                <label class=" text-primary">Prioridad</label><div id="textPrioridad"></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class=" text-primary">Asunto</label><div id="textAsunto"></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class=" text-primary">Archivos Adjuntos</label><br>
                                <div id="contenedorTituloArchivosAdjuntos"></div>
                                <div class="collapse" id="collapseArchivosAdjuntos">
                                    <div class="border p-3 rounded">
                                        <div id="contenedorArchivosAdjuntos"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class=" text-primary">Descripcion</label>
                                <hr>
                                <div id="descripcionTicket"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <form id="formAgregarSeguimiento" name="formAgregarSeguimiento" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div id="contenedorHeaderSeguimientoTicket"></div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label class="">Descripcion</label>
                                <textarea class="form-control editor" name="descripcionTicket"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label class="">Adjuntar Archivos</label>
                                <input type="file" class="form-control" id="archivosTicket" name="archivosTicket" multiple>
                            </div>
                        </div>
                        <center><button class="btn btn-success" onclick="agregarSeguimiento()"><span class="far fa-save"></span> Agregar Seguimiento</button></center>
                    
                </div>
                </form>
            </div>
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-warning-300">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0"><i class="fas fa-history"></i> Seguimientos</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="contenedorSeguimientosTicket"></div>
                </div>
            </div>
        </div>
    </div>         
</div>

<script src="views/js/mesaayuda/tickets.js?v=<?= md5_file('views/js/mesaayuda/tickets.js') ?>"></script>
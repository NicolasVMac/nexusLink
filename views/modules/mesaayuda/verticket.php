<div class="content">
    <h2 class="mb-2">Ver Ticket</h2>
    <hr>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="table-responsive">
                    <!-- <div class="card-header p-4 border-bottom border-300 bg-primary">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Informacion Ticket</h4>
                            </div>
                        </div>
                    </div> -->
                    <div id="contenedorHeaderCardTicket"></div>
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
            <!-- <h4 class="py-3 border-y border-300 mb-3 ms-8">Today</h4>
            <div class="timeline-basic">
                <div class="timeline-item">
                    <div class="row g-3">
                    <div class="col-auto">
                        <div class="timeline-item-bar position-relative">
                        <div class="icon-item icon-item-md rounded-7 border"><span class="far fa-file text-primary"></span></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">Onboarding Meeting</h6>
                        </div>
                        <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span> 9:33pm</p>
                        </div>
                        <h6 class="fs--2 fw-normal false">by <a class="fw-semi-bold" href="#!">John N. Ward</a></h6>
                        <p class="fs--1 text-800 w-sm-60">To get off the runway and paradigm shift, we should take brass tacks with above-the-board actionable analytics, ramp up with viral partnering, not the usual goat rodeo putting socks on an octopus. </p>
                    </div>
                    </div>
                </div>
            </div>
            <h4 class="py-3 border-y border-300 mb-5 ms-8">15 October, 2022</h4>
            <div class="timeline-basic mb-9">
                <div class="timeline-item">
                    <div class="row g-3">
                    <div class="col-auto">
                        <div class="timeline-item-bar position-relative">
                        <div class="icon-item icon-item-md rounded-7 border"><span class="far fa-comment text-info"></span></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-between">
                        <div class="d-flex mb-2">
                            <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">Designing the dungeon</h6>
                        </div>
                        <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span> 1:30pm</p>
                        </div>
                        <h6 class="fs--2 fw-normal mb-3">by <a class="fw-semi-bold" href="#!">John N. Ward</a></h6>
                        <p class="fs--1 text-800 w-sm-60 mb-5">To get off the runway and paradigm shift, we should take brass tacks with above-the-board actionable analytics, ramp up with viral partnering, not the usual goat rodeo putting socks on an octopus. </p>
                    </div>
                    </div>
                </div>
            </div> -->
            <!-- <div id="contenedorSeguimientosTicket"></div> -->
        </div>
    </div>         
</div>

<script src="views/js/mesaayuda/tickets.js?v=<?= md5_file('views/js/mesaayuda/tickets.js') ?>"></script>
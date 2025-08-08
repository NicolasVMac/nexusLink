<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Informacion Paciente</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" name="procesoCall" id="procesoCall">
                    <input type="hidden" name="idPaciente" id="idPaciente">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="">Nombre</label><div id="textNombrePaciente"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">Documento</label><div id="textDocumentoPaciente"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">Fecha Expedicion</label><div id="textFechaExpedicion"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label class="">No Carnet</label><div id="textNoCarnet"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">Fecha Nacimiento</label><div id="textFechaNacimiento"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">Edad</label><div id="textEdad"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">Genero</label><div id="textGenero"></div>
                        </div>
                    </div>
                    <hr>
                    <a class="btn btn-outline-primary mt-2 mb-2" data-bs-toggle="collapse" href="#collExtraInfoPaciente" role="button" aria-expanded="false" aria-controls="collExtraInfoPaciente">Mas Información</a>

                    <div class="collapse" id="collExtraInfoPaciente">
                        <div class="border p-3 rounded">
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <label class="">Ocupacion</label><div id="textOcupacion"></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="">Regimen</label><div id="textRegimen"></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="">Tipo Usuario RIPS</label><div id="textTipoUsuarioRips"></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="">Tipo Afiliacion</label><div id="textTipoAfiliacion"></div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <label class="">Entidad Af. Actual</label><div id="textEntidadAfActual"></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="">Paquete Atencion</label><div id="textPaqueteAtencion"></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="">Departamento</label><div id="textDepartamento"></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="">Municipio</label><div id="textMunicipio"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-success">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Información Gestion Call</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="">Proceso Call</label><div id="textProcesoCall"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="">Asesor</label><div id="textAsesor"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="">Cantidad Gestiones</label><div id="textCantidadGestiones"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-warning">
                    <div class="row g-3 justify-content-between align-items-center">    
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Auditoria</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="formRespuestasEncuesta" name="formRespuestasEncuesta" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                        <div id="contenedorPreguntasEncuesta"></div>
                        <hr>
                        <center>
                            <button class="btn btn-primary btn-sm mb-2" onclick="guardarRespuestasEncuesta()"><span class="far fa-save"></span> Guardar Respuestas</button>
                            <a class="btn btn-warning btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalComunicacionFallida"><span class="fas fa-phone-slash"></span> Comunicacion Fallida</a>
                        </center>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-danger">
                    <div class="row g-3 justify-content-between align-items-center">    
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Comunicaciones Fallidas</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaComunicacionesFallidas" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>CAUSAL FALLIDA</th>
                                    <th>OBSERVACIONES</th>
                                    <th>USUARIO CREA</th>
                                    <th>FECHA CREA</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgendarCita"><span class="far fa-calendar-plus"></span> Agendar Cita</a>
            <a class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerAgendaCitas"><span class="far fa-calendar-plus"></span> Ver Agenda Citas</a>
        </div>
    </div>
</div>

<div class="modal fade" id="modalComunicacionFallida" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formComunicacionFallida" name="formComunicacionFallida" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header bg-warning">
                    <h6 class="modal-title text-white">Registrar Comunicacion Fallida</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="">Causal Comunicacion Fallida</label>
                        <select class="form-select" name="causalFallida" id="causalFallida" required style="width: 100%;">
                        </select>
                        <input type="hidden" name="idCallComuFallida" id="idCallComuFallida">
                        <input type="hidden" name="cantidadGestionesComuFallida" id="cantidadGestionesComuFallida">
                    </div>
                    <div class="mb-2">
                        <label class="">Observaciones</label>
                        <textarea class="form-control" name="observacionesFallida" id="observacionesFallida" required rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="fas fa-arrow-left"></span> Close</a>
                    <button class="btn btn-primary btn-sm" onclick="registrarComunicacionFallida()"><span class="far fa-save"></span> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgendarCita" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAgendarCita" name="formAgendarCita" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Agendar Cita</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="">Motivo Cita</label>
                        <input type="text" class="form-control" onchange="espaciosAgendaProfesional()" name="motivoCita" id="motivoCita" placeholder="Motivo Cita" required>
                    </div>
                    <div class="mb-2">
                        <label class="">Profesional</label>
                        <select class="form-select" onchange="espaciosAgendaProfesional()" name="profesionalCita" id="profesionalCita" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="">Fecha Cita</label>
                        <input type="date" class="form-control" onchange="espaciosAgendaProfesional()" name="fechaCita" id="fechaCita" required>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <label class="">Horas Disponibles</label>
                        <br><br>
                        <div id="contenedorHorasDisponibles"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="fas fa-arrow-left"></span> Close</a>
                    <button class="btn btn-success btn-sm" onclick="agendarCita()"><span class="far fa-calendar-plus"></span> Agendar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVerAgendaCitas" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formAgendarCita" name="formAgendarCita" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header bg-info">
                    <h6 class="modal-title text-white">Ver Agenda Citas</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="">Profesional</label>
                        <select class="form-select" onchange="verAgendaProfesional()" name="profesionalAgenda" id="profesionalAgenda" required style="width: 100%;">
                        </select>
                    </div>
                    <label class="">Agenda Profesional</label>
                    <br><br>
                    <div id="contenedorAcordionAgenda"></div>
                    <!-- <div class="accordion" id="accordionExample">
                        <div class="accordion-item border-top border-300">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    How long does it take to ship my order?
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body pt-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Messages</li>
                                        <li class="list-group-item">Events</li>
                                        <li class="list-group-item">Groups</li>
                                        <li class="list-group-item">Pages</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="fas fa-arrow-left"></span> Close</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/callcenter/callcenter.js?v=<?= md5_file('views/js/callcenter/callcenter.js') ?>"></script>
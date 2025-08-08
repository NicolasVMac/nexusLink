<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Re-Agendar Cita</h4>
                </div>
            </div>
        </div>
        <div class="card-body">

            <form id="formReAgendarCita" name="formReAgendarCita" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                            <div class="card-header p-4 border-bottom border-300 bg-primary">
                                <div class="row g-3 justify-content-between align-items-center">
                                    <div class="col-12 col-md">
                                        <h4 class="text-white mb-0">Re-Agendar Cita</h4>
                                    </div>
                                    <div class="col col-md-auto">
                                        <button class="btn btn-phoenix-primary ms-2" onclick="ReAgendarCita()"><i class="far fa-save"></i> Re-Agendar Cita</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-12 col-md-12 mb-2">
                                        <label class="">Servicio</label>
                                        <select class="form-select select-field" name="servicioCitaEditar" id="servicioCitaEditar" required style="width: 100%;">
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mb-2">
                                        <label class="">Motivo Cita</label><div id="textMotivoCita"></div>
                                        <input type="hidden" class="form-control" id="idCitaEditar" name="idCitaEditar" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mb-2">
                                        <label class="">Profesional</label>
                                        <select class="form-select select-field" name="profesionalCitaEditar" id="profesionalCitaEditar" required style="width: 100%;">
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mb-2">
                                        <label class="">Fecha Cita</label>
                                        <input type="date" class="form-control" name="fechaCita" id="fechaCita" min="<?php echo $hoy; ?>" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mb-2">
                                        <label class="">Franja Cita</label>
                                        <select class="form-select select-field" name="franjaCita" id="franjaCita" required style="width: 100%;">
                                            <option value="">Seleccione una Franja</option>
                                            <option value="AM">AM</option>
                                            <option value="PM">PM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 mb-2">
                                        <label class="">Localidad</label><div id="textLocalidad"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <label class="">Observacion Cita</label><div id="textObservacionCita"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                            <div class="card-body">
                                <center>
                                    <a class="btn btn-warning" style="background-color: #ffb200;">FRANJA: AM</a>
                                    <a class="btn btn-primary">FRANJA: PM</a>
                                    <a class="btn btn-danger">NO-DISPONIBLE</a>
                                </center>
                                <div class="p-2" id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEvento" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title text-white">Informacion Cita</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6">
                        <label class="">Nombre Paciente</label><div id="textNombrePaciente"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="">Documento Paciente</label><div id="textDocPaciente"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6">
                        <label class="">Motivo Cita</label><div id="textEventMotivoCita"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="">Cohorte o Programa</label><div id="textEventCohortePrograma"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6">
                        <label class="">Fecha Cita</label><div id="textEventFechaCita"></div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <label class="">Estado</label><div id="textEventEstado"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6">
                        <label class="">Profesional</label><div id="textEventProfesional"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="">Localidad</label><div id="textEventLocalidad"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-12">
                        <label class="">Observaciones Cita</label><div id="textEventObservacionesCita"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="fas fa-arrow-left"></span> Close</a>
            </div>
        </div>
    </div>
</div>

<script src="views/js/di/agendamiento.js?v=<?= md5_file('views/js/di/agendamiento.js') ?>"></script>
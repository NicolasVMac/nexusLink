<div class="content">
    <h3 class="mb-3">Gestion Auditoria Profesional</h3>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Informacion Auditoria Profesional</h4>
                        </div>
                        <div class="col col-md-auto">
                            <button class="btn btn-phoenix-primary ms-2" onclick="mostrarInformacionAuditoriaEncuesta()" data-bs-toggle="modal" data-bs-target="#modalEditarInformacion"><i class="fas fa-pencil-alt"></i> Editar Información</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <label class=""># Auditoria</label><div id="textIdEncuesta"></div>
                        </div>
                        <div class="col-md-2">
                            <label class="">No. Historia Clinica</label><div id="textNoHistoriaClinica"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="">Nombre Paciente</label><div id="textNombrePaciente"></div>
                        </div>
                        <div class="col-md-2">
                            <label class="">Edad</label><div id="textEdad"></div>
                        </div>
                        <div class="col-md-2">
                            <label class="">Sexo</label><div id="textSexo"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label class="">Especialidad</label><div id="textEspecialidad"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">Profesional Auditado</label><div id="textProfesionalAuditado"></div>
                        </div>
                        <div class="col-md-2">
                            <label class="">Sede</label><div id="textSede"></div>
                        </div>
                        <div class="col-md-2">
                            <label class="">Eps</label><div id="textEps"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label class="">Fecha Atencion</label><div id="textFechaAtencion"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">Modalidad Consulta o Tipo Atencion</label><div id="textModalidadConsultaotipoAtencion"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-success">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Gestion Auditoria Profesional</h4>
                        </div>
                        <div class="col col-md-auto">
                            <button class="btn btn-phoenix-success ms-2" onclick="terminarEncuesta()"><i class="far fa-check-circle"></i> Terminar Auditoria</button>
                            <button class="btn btn-phoenix-danger ms-2" onclick="descartarEncuesta()"><i class="far fa-calendar-times"></i> Descartar Auditoria</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-underline" id="tabGestionEncuesta" role="tablist">
                    </ul>
                    <div class="table-responsive">
                        <div class="tab-content mt-3" id="tabContentGestionEncuesta">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarInformacion">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditarInfoEncuesta" name="formEditarInfoEncuesta" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Información Encuesta</h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombrePacienteEncuesta" id="nombrePacienteEncuesta" required>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label>Edad</label>
                            <input type="number" class="form-control" name="edadPacienteEncuesta" id="edadPacienteEncuesta" required>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label>Sexo</label>
                            <select class="form-control" name="sexoPacienteEncuesta" id="sexoPacienteEncuesta" required>
                                <option value="">Seleccione una opcion</option>
                                <option value="M">MASCULINO</option>
                                <option value="F">FEMENINO</option>
                            </select>
                            <!-- <input type="text" class="form-control" name="sexoPacienteEncuesta" id="sexoPacienteEncuesta" required> -->
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <label>Modalidad Consulta o Tipo Atecion</label>
                            <input type="text" class="form-control" name="modalidadConsultaPacienteEncuesta" id="modalidadConsultaPacienteEncuesta" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="editarInformacionEncuesta()" type="button"><i class="far fa-save"></i> Guardar</button>
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/encuestas/encuestas-gestion-profesional-edit.js?v=<?= md5_file('views/js/encuestas/encuestas-gestion-profesional-edit.js') ?>"></script>
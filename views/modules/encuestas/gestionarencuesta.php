<div class="content">
    <h3 class="mb-3">Gestion Auditoria</h3>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Informacion Auditoria</h4>
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
                            <label class="">Modalidad Consulta</label><div id="textModalidadConsulta"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">Tipo Auditoria</label><div id="textTipoEncuesta"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-9">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-success">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Gestion Auditoria</h4>
                        </div>
                        <div class="col col-md-auto">
                            <button class="btn btn-phoenix-success ms-2" onclick="terminarEncuesta()"><i class="far fa-check-circle"></i> Terminar Auditoria</button>
                            <button class="btn btn-phoenix-danger ms-2" onclick="descartarEncuesta()"><i class="far fa-calendar-times"></i> Descartar Auditoria</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- <div class="table-responsive" id="content-encuesta"></div> -->
                    <ul class="nav nav-underline" id="tabGestionEncuesta" role="tablist">
                        <!-- <li class="nav-item" role="presentation">
                            <a class="nav-link" id="cita-tab" data-bs-toggle="tab" href="#tab-cita" role="tab" aria-controls="tab-cita" aria-selected="false" tabindex="-1">
                                <i class="fas fa-address-book"></i> Cita
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="encuesta-4-tab" data-bs-toggle="tab" href="#tab-encuesta-4" role="tab" aria-controls="tab-encuesta-4" aria-selected="false" tabindex="-1" aria-labelledby="#tab-encuesta-4">
                                ENFERMERIA
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="paciente-tab" data-bs-toggle="tab" href="#tab-paciente" role="tab" aria-controls="tab-paciente" aria-selected="true">
                                <i class="far fa-id-card"></i> Paciente
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="cita-tab" data-bs-toggle="tab" href="#tab-cita" role="tab" aria-controls="tab-cita" aria-selected="false" tabindex="-1">
                                <i class="fas fa-address-book"></i> Cita
                            </a>
                        </li> -->
                    </ul>
                    <!-- <form id="formGestionEncuesta" name="formGestionEncuesta" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;"> -->
                    <div class="table-responsive">
                        <div class="tab-content mt-3" id="tabContentGestionEncuesta">
                            <!-- <div class="tab-pane fade" id="tab-encuesta-4" role="tabpanel" aria-labelledby="encuesta-4-tab">
                                <h1>ENFERMERIA</h1>
                            </div>
                            <div class="tab-pane fade" id="tab-cita" role="tabpanel" aria-labelledby="cita-tab">
                                <h1>CITA</h1>
                            </div> -->
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-3">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Agregar Profesional</h4>
                        </div>
                        <div class="col col-md-auto">
                            <button class="btn btn-phoenix-primary ms-2" data-bs-toggle="modal" data-bs-target="#modalAgregarProfesional"><i class="far fa-calendar-plus"></i> Agregar Profesional</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaProcesosGestionEncuesta" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>   
                                    <th>PROCESO</th>
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

<div class="modal fade" id="modalAgregarProfesional">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAgregarProfesional" name="formAgregarProfesional" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Profesional</h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-outline-primary" role="alert">¡Recuerde que puede Agregar el Instrumento y su Auditor para su respectiva gestion!</div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <label>Profesional</label>
                            <select class="form-control" id="procesoProfesional" name="procesoProfesional" onchange="changeProcesoProfesional()" required style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <label>Auditado</label>
                            <select class="form-control" id="auditorProceso" name="auditorProceso" required style="width: 100%;">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="agregarProfesional()" type="button"><i class="far fa-save"></i> Guardar</button>
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
                </div>
            </form>
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
                                <option value="MASCULINO">MASCULINO</option>
                                <option value="FEMENINO">FEMENINO</option>
                            </select>
                            <!-- <input type="text" class="form-control" name="sexoPacienteEncuesta" id="sexoPacienteEncuesta" required> -->
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <label>Modalidad Consulta</label>
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

<script src="views/js/encuestas/encuestas-gestion.js?v=<?= md5_file('views/js/encuestas/encuestas-gestion.js') ?>"></script>
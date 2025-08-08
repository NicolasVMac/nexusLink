<div class="content">
    <h2 class="mb-3">Cargar Respuesta PQRSF</h2>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-sm">
                            <h4 class="text-white mb-0">Informacion PQRSF</h4>
                        </div>
                        <div class="col col-md-auto">
                            <div class="nav nav-underline justify-content-end doc-tab-nav align-items-center">
                                <a class="btn btn-phoenix-info btnVerActas" style="display: none;" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="far fa-eye"></i> Ver Acta</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 700px; overflow-y: auto;">
                    <div class="border p-3 rounded shadow-sm mb-2 containerInfoActa" style="display: none;">
                        <h4 class="mb-4">Informacion Acta PQRSF</h4>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label>Radicado Acta</label>
                                <label class="form-control" id="txtRadActa"></label>

                                <label>Fecha Acta</label>
                                <label class="form-control" id="txtFechaActa"></label>

                                <label>Fecha Apertura Buzon</label>
                                <label class="form-control" id="txtFechaAperturaActa"></label>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label>Archivos Acta PQRSF</label>
                                <div id="containerArchivosActasPQRSF"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label># PQRSF</label>
                            <label class="form-control" id="txtIdPQRS"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>Nombre Paciente</label>
                            <label class="form-control" id="txtNombrePac"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Tipo Identificacion Paciente</label>
                            <label class="form-control" id="txtTipoDocPac"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Numero Identificacion Paciente</label>
                            <label class="form-control" id="txtNumDocPac"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>Fecha Nacimiento</label>
                            <label class="form-control" id="txtFechaNacPac"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>EPS</label>
                            <label class="form-control" id="txtEps"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Regimen</label>
                            <label class="form-control" id="txtRegimenEps"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>Programa</label>
                            <label class="form-control" id="txtPrograma"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Sede</label>
                            <label class="form-control" id="txtSede"></label>
                        </div>
                    </div>
                    <hr>
                    <h4 class="mb-4">Descripcion PQRSF</h4>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>Nombre Peticionario</label>
                            <label class="form-control" id="txtNombrePet"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Tipo Identificacion Peticionario</label>
                            <label class="form-control" id="txtTipoDocPet"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Numero Identificacion Peticionario</label>
                            <label class="form-control" id="txtNumDocPet"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>Contacto Peticionario</label>
                            <label class="form-control" id="txtContactoPet"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Correo Peticionario</label>
                            <label class="form-control" id="txtCorreoPet"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Fecha PQRSF</label>
                            <label class="form-control" id="txtFechaPQRSF"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label class="">Departamento</label>
                            <label class="form-control" id="txtDepPet"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label class="">Municipio</label>
                            <label class="form-control" id="txtMunPet"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label>Descripcion PQRSF</label>
                            <label class="form-control" id="txtDescripcionPqr"></label>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>Medio Recepcion PQRSF</label>
                            <label class="form-control" id="txtMedRecepPqr"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Fecha Apertura Buzon de Sugerencias</label>
                            <label class="form-control" id="txtFechaAperBuzonSug"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Fecha Hora Radicacion PQRSF</label>
                            <label class="form-control" id="txtFechaHoraRadPqr"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>Tipo PQRSF</label>
                            <label class="form-control" id="txtTipoPqr"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Ente Reporte PQRSF</label>
                            <label class="form-control" id="txtEnteRepPqr"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Motivo PQRSF</label>
                            <label class="form-control" id="txtMotivoPqr"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>Gestor</label>
                            <label class="form-control" id="txtGestorPqr"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Servicio o Area Involucrado</label>
                            <label class="form-control" id="txtServAreaPqr"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Clasificacion Atributo</label>
                            <label class="form-control" id="txtCaliAtribuPqr"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>Tiempo Respuesta Normativo</label>
                            <label class="form-control" id="txtTiempoResNormaPqr"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Horas o Dias Oportunidad</label>
                            <label class="form-control" id="txtHorasDiasOportPqr"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label>Archivos</label>
                            <div id="containerArchivosPQRSF"></div>
                        </div>
                    </div>
                    <hr>
                    <h4 class="mb-4">Plan Accion</h4>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label>¿Qué?</label>
                            <label class="form-control" id="txtQue"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label>¿Por Qué?</label>
                            <label class="form-control" id="txtPorQue"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <label>¿Cuándo?</label>
                            <label class="form-control" id="txtCuando"></label>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label>¿Dónde?</label>
                            <label class="form-control" id="txtDonde"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label>¿Como?</label>
                            <label class="form-control" id="txtComo"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>¿Quién?</label>
                            <label class="form-control" id="txtQuien"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Recursos</label>
                            <label class="form-control" id="txtRecursos"></label>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Negación PQRSF</label>
                            <label class="form-control" id="txtNegacionPQR"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label>Motivo y Responsable Negacion</label>
                            <label class="form-control" id="txtMotivoResponsableNegacion"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <label>PQRSF Recurrente</label>
                            <label class="form-control" id="txtPQRSRecurrente"></label>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label>Accion Efectiva</label>
                            <label class="form-control" id="txtAccionEfectiva"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label>Respuesta PQRSF (Para ser enviada al usuario)</label>
                            <label class="form-control" id="txtRespPqr"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                    <div class="col-sm-12 col-md-12">
                            <label>Observaciones Internas Gestor</label>
                            <label class="form-control" id="txtObservacionesGestor"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label>Observaciones Internas Supervisor</label>
                            <label class="form-control" id="txtObservacionesSupervisor"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <form id="formCargarResPqr" name="formCargarResPqr" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Cargar Respuesta PQRSF</h4>
                            </div>
                            <div class="col col-md-auto">
                                <button class="btn btn-phoenix-success ms-2" onclick="guardarResPQRSF()"><i class="fas fa-file-upload"></i> Guardar Respuesta PQRSF</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label>Fecha Respuesta PQRSF</label>
                                <input type="datetime-local" class="form-control" id="fechaRespuestaPqr" name="fechaRespuestaPqr" required>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label>Adjuntar Respuesta</label>
                                <input type="file" class="form-control" id="respuestaPqr" multiple name="respuestaPqr" accept=".pdf" required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/pqr/parametricas.js?v=<?= md5_file('views/js/pqr/parametricas.js') ?>"></script>
<script src="views/js/pqr/pqr.js?v=<?= md5_file('views/js/pqr/pqr.js') ?>"></script>
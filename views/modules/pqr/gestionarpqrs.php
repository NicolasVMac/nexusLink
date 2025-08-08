<div class="content">
    <h2 class="mb-3">Gestionar PQRSF</h2>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <form id="formActualizarPQRSF" name="formActualizarPQRSF" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-primary">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-sm">
                                <h4 class="text-white mb-0">Informacion PQRSF</h4>
                            </div>
                            <div class="col col-md-auto">
                                <div class="nav nav-underline justify-content-end doc-tab-nav align-items-center">
                                    <a class="btn btn-phoenix-info btnVerActas" style="display: none;" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="far fa-eye"></i> Ver Acta</a>
                                    <button class="btn btn-phoenix-warning ms-2" onclick="actualizarPQRSF('GESTOR')"><i class="far fa-edit"></i> Actualizar PQRSF</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="collapse mb-2" id="collapseExample">
                            <div class="border p-3 rounded shadow-sm">
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
                                <input type="text" class="form-control" name="nombrePaciente" id="nombrePaciente" placeholder="Nombre Paciente" required>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Tipo Identificacion Paciente</label>
                                <select class="form-select select-field" name="tipoDocPaciente" id="tipoDocPaciente" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Numero Identificacion Paciente</label>
                                <input type="number" class="form-control" name="numIdentificacionPaciente" id="numIdentificacionPaciente" placeholder="1000000000" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-4">
                                <label>Fecha Nacimiento</label>
                                <input type="date" class="form-control" name="fechaNacimientoPaciente" id="fechaNacimientoPaciente" max="<?php echo $hoy; ?>">
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>EPS</label>
                                <select class="form-select select-field" name="epsPqr" id="epsPqr" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Regimen</label>
                                <select class="form-select select-field" name="regimenEps" id="regimenEps" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-4">
                                <label>Programa</label>
                                <select class="form-select select-field" name="programaPqr" id="programaPqr" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Sede</label>
                                <select class="form-select select-field" name="sedePqr" id="sedePqr" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <hr>
                        <h4 class="mb-4">Descripcion PQRSF</h4>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-4">
                                <label>Nombre Peticionario</label>
                                <input type="text" class="form-control" name="nombrePeticionario" id="nombrePeticionario" placeholder="Nombre Peticionario" required>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Tipo Identificacion Peticionario</label>
                                <select class="form-select select-field" name="tipoDocPeticionario" id="tipoDocPeticionario" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Numero Identificacion Peticionario</label>
                                <input type="number" class="form-control" name="numIdentificacionPeticionario" id="numIdentificacionPeticionario" placeholder="1000000000" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-4">
                                <label>Contacto Peticionario</label>
                                <input type="number" class="form-control" name="telefonoPeticionario" id="telefonoPeticionario" placeholder="3002000000" required>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Correo Peticionario</label>
                                <input type="email" class="form-control" name="correoPeticionario" id="correoPeticionario" placeholder="Correo Peticionario" required>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Fecha PQRSF</label>
                                <input type="datetime-local" class="form-control" name="fechaPQRSF" id="fechaPQRSF" max="<?php echo $hoyTime; ?>" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-4">
                                <label class="">Departamento</label>
                                <select class="form-select select-field" name="departamentoPeticionario" id="departamentoPeticionario" style="width: 100%;" required>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="">Municipio</label>
                                <select class="form-select select-field" name="municipioPeticionario" id="municipioPeticionario" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12">
                                <label>Descripcion PQRSF</label>
                                <textarea class="form-control" name="descripcionPqr" id="descripcionPqr" minlength="50" maxlength="100000" placeholder="Descripcion de la PQRSF"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-4">
                                <label>Medio Recepcion PQRSF</label>
                                <select class="form-select select-field" name="medioRecepcionPqr" id="medioRecepcionPqr" onchange="validarBuzonSugerencias()" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Fecha Apertura Buzon de Sugerencias</label>
                                <input type="date" class="form-control" name="fechaAperturaBuzonSugerencias" id="fechaAperturaBuzonSugerencias" required>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Fecha Hora Radicacion PQRSF</label>
                                <label class="form-control" id="txtFechaHoraRadPqr"></label>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-4">
                                <label>Tipo PQRSF</label>
                                <select class="form-select select-field" name="tipoPqr" id="tipoPqr" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Ente Reporte PQRSF</label>
                                <select class="form-select select-field" name="enteReportePqr" id="enteReportePqr" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Motivo PQRSF</label>
                                <select class="form-select select-field" name="motivoPqr" id="motivoPqr" onchange="obtenerAtributoClasificacion()" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-4">
                                <label>Trabajador Relacionado PQRSF</label>
                                <select class="form-select select-field" name="trabajadorRelaPqr" id="trabajadorRelaPqr" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Servicio o Area Involucrado</label>
                                <select class="form-select select-field" name="servcioAreaPqr" id="servcioAreaPqr" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label>Clasificacion Atributo</label>
                                <input type="text" class="form-control readonly" name="clasificacionAtributoPqr" id="clasificacionAtributoPqr" placeholder="Calificacion Atributo" required readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-4">
                                <label>Gestor</label>
                                <label class="form-control" id="txtGestorPqr"></label>
                            </div>
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
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-12 col-md-6">
            <form id="formPlanAccionPqr" name="formPlanAccionPqr" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Plan Acción</h4>
                            </div>
                            <div class="col col-md-auto">
                                <button class="btn btn-phoenix-success ms-2" onclick="crearPlanAccionPQRS()"><i class="far fa-calendar-check"></i> Guardar Plan Accion</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <input type="hidden" class="form-control" id="txtRutaArchivosPQRSF" name="txtRutaArchivosPQRSF">
                            <div class="col-sm-12 col-md-6">
                                <label>¿Qué?</label>
                                <textarea class="form-control" rows="5" name="planAccionQue" id="planAccionQue" placeholder="¿Que se quiere mejorar?" minlength="10" maxlength="1000" required></textarea>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label>¿Por Qué?</label>
                                <textarea class="form-control" rows="5" name="planAccionPorQue" id="planAccionPorQue" placeholder="¿Por que se quiere mejorar?" minlength="10" maxlength="2000" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label>¿Cuándo?</label>
                                <input type="date" class="form-control" name="planAccionCuando" id="planAccionCuando" placeholder="¿Cuando se quiere mejorar?" required>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label>¿Dónde?</label>
                                <!-- <input type="text" class="form-control" name="planAccionDonde" id="planAccionDonde" placeholder="¿Donde se va a mejorar?" minlength="10" maxlength="250" required> -->
                                <select class="form-select select-field" name="planAccionDonde" id="planAccionDonde" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12">
                                <label>¿Como?</label>
                                <textarea class="form-control" rows="5" name="planAccionComo" id="planAccionComo" placeholder="¿Como lo va a mejorar?" minlength="10" maxlength="2000" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label>¿Quién?</label>
                                <!-- <select class="form-select select-field-multiple" multiple name="planAccionQuien" id="planAccionQuien" style="width: 100%;" required> -->
                                <select class="form-select select-field-multiple" name="planAccionQuien" id="planAccionQuien" multiple style="width: 100%;" required>    
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="">Recursos</label>
                                <select class="form-select select-field-multiple" multiple name="planAccionRecursos" id="planAccionRecursos" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="">Negación PQRSF</label>
                                <select class="form-select" name="planAccionNegacion" id="planAccionNegacion" style="width: 100%;" onchange="validarNegacionPqr()" required>
                                    <option value="">Seleccione</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label>Motivo y Responsable Negacion</label>
                                <textarea class="form-control" rows="5" name="planAccionMotivoResponsableNega" id="planAccionMotivoResponsableNega" placeholder="Motivo y Responsable Negacion" minlength="50" maxlength="2000" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="">PQRSF Recurrente</label>
                                <select class="form-select readonly" name="planAccionPqrRecurrente" id="planAccionPqrRecurrente" style="width: 100%;" disabled required>
                                    <option value="">Seleccione</option>
                                    <option value="RECURRENTE">RECURRENTE</option>
                                    <option value="NO RECURRENTE">NO RECURRENTE</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="">Accion Efectiva</label>
                                <select class="form-select" name="planAccionEfectiva" id="planAccionEfectiva" style="width: 100%;" required disabled>
                                    <option value="">Seleccione</option>
                                    <option value="EFECTIVA">EFECTIVA</option>
                                    <option value="NO EFECTIVA">NO EFECTIVA</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12">
                                <label>Respuesta PQRSF (Para ser enviada al usuario)</label>
                                <textarea class="form-control editor" name="respuestaPQRSF" placeholder="Respuesta PQRSF" minlength="10" maxlength="100000"></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12">
                                <label>Observaciones Internas</label>
                                <textarea rows="4" class="form-control" name="gestorObservaciones" id="gestorObservaciones" placeholder="Observaciones" minlength="10" maxlength="10000" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12">
                                <label>Adjuntar Archivos</label>
                                <input type="file" class="form-control" id="archivosPqr" name="archivosPqr" accept=".pdf" multiple required>
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
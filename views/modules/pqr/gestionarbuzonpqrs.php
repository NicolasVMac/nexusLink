<div class="content">
    <h2 class="mb-3">Registrar Buzon PQRSF</h2>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <form id="formCrearBuzonPqr" name="formCrearBuzonPqr" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-primary">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Informacion PQRSF</h4>
                            </div>
                            <div class="col col-md-auto">
                                <a class="btn btn-phoenix-info mt-2 mb-2" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="far fa-eye"></i> Ver Informacion Acta</a>
                                <button class="btn btn-phoenix-primary ms-2" onclick="crearBuzonPQRS()"><i class="far fa-calendar-check"></i> Guardar PQRSF</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="collapse" id="collapseExample">
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
                        <hr>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label>Nombre Paciente</label>
                                <input type="text" class="form-control" name="nombrePaciente" id="nombrePaciente" placeholder="Nombre Paciente" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Tipo Identificacion Paciente</label>
                                <select class="form-select select-field" name="tipoDocPaciente" id="tipoDocPaciente" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Numero Identificacion Paciente</label>
                                <input type="number" class="form-control" name="numIdentificacionPaciente" id="numIdentificacionPaciente" placeholder="1000000000" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Fecha Nacimiento Paciente</label>
                                <input type="date" class="form-control" name="fechaNacimientoPaciente" id="fechaNacimientoPaciente" max="<?php echo $hoy; ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label>Regimen</label>
                                <select class="form-select select-field" name="regimenEps" id="regimenEps" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Programa</label>
                                <select class="form-select select-field" name="programaPqr" id="programaPqr" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Sede</label>
                                <select class="form-select select-field" name="sedePqr" id="sedePqr" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>EPS</label>
                                <select class="form-select select-field" name="epsPqr" id="epsPqr" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <hr>
                        <h4 class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                Descripcion PQRSF
                            </div>
                            <div class="form-check form-switch" style="display: flex; align-items: center;">
                                <input class="form-check-input" id="checkPacientePeticionario" style="margin-right: 10px;" type="checkbox" onclick="registrarInfoPacientePeticionario()"/>
                                <label class="form-check-label" for="checkPacientePeticionario" style="margin-top: 10px;"><h5>Paciente - Peticionario</h5></label>
                            </div>
                        </h4>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label>Nombre Peticionario</label>
                                <input type="text" class="form-control" name="nombrePeticionario" id="nombrePeticionario" placeholder="Nombre Peticionario" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Tipo Identificacion Peticionario</label>
                                <select class="form-select select-field" name="tipoDocPeticionario" id="tipoDocPeticionario" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Numero Identificacion Peticionario</label>
                                <input type="number" class="form-control" name="numIdentificacionPeticionario" id="numIdentificacionPeticionario" placeholder="1000000000" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Contacto Peticionario</label>
                                <input type="number" class="form-control" name="telefonoPeticionario" id="telefonoPeticionario" placeholder="3002000000" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label>Correo Peticionario</label>
                                <input type="email" class="form-control" name="correoPeticionario" id="correoPeticionario" placeholder="Correo Peticionario" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Fecha PQRSF</label>
                                <input type="datetime-local" class="form-control" name="fechaPQRSF" id="fechaPQRSF" max="<?php echo $hoy; ?>" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="">Departamento</label>
                                <select class="form-select select-field" name="departamentoPeticionario" id="departamentoPeticionario" style="width: 100%;" required>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="">Municipio</label>
                                <select class="form-select select-field" name="municipioPeticionario" id="municipioPeticionario" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12">
                                <label>Descripcion PQRSF</label>
                                <textarea class="form-control editor" name="descripcionPqr" id="descripcionPqr" minlength="50" maxlength="100000" placeholder="Descripcion de la PQRSF"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label>Medio Recepcion PQRSF</label>
                                <select class="form-select select-field" name="medioRecepcionPqr" id="medioRecepcionPqr" onchange="validarBuzonSugerencias()" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Fecha Apertura Buzon de Sugerencias</label>
                                <input type="date" class="form-control" name="fechaAperturaBuzonSugerencias" id="fechaAperturaBuzonSugerencias" required>
                            </div>
                            <!-- <div class="col-sm-12 col-md-2">
                                <label>Fecha Hora Radicacion PQRSF</label>
                                <input type="datetime-local" class="form-control" name="fechaHoraRadicacionPqr" id="fechaHoraRadicacionPqr" required>
                            </div> -->
                            <div class="col-sm-12 col-md-3">
                                <label>Tipo PQRSF</label>
                                <select class="form-select select-field" name="tipoPqr" id="tipoPqr" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Ente Reporte PQRSF</label>
                                <select class="form-select select-field" name="enteReportePqr" id="enteReportePqr" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label>Motivo PQRSF</label>
                                <select class="form-select select-field" name="motivoPqr" id="motivoPqr" onchange="obtenerAtributoClasificacion()" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Trabajador Relacionado PQRSF</label>
                                <select class="form-select select-field" name="trabajadorRelaPqr" id="trabajadorRelaPqr" required style="width: 100%;">
                                </select>                            
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Clasificacion Atributo</label>
                                <input type="text" class="form-control readonly" name="clasificacionAtributoPqr" id="clasificacionAtributoPqr" placeholder="Calificacion Atributo" required readonly>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Servicio o Area Involucrado</label>
                                <select class="form-select select-field" name="servcioAreaPqr" id="servcioAreaPqr" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label>Gestor</label>
                                <select class="form-select select-field" name="gestoresPqr" id="gestoresPqr" style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6">
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
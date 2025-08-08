<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Informacion Equipo</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <label>Tipo Equipo <small class="text-danger">*</small></label>
                            <input type="hidden" class="form-control" name="idEquipoBiomedico" id="idEquipoBiomedico" required>
                            <select class="form-control select-field" name="dGTipoEquipo" id="dGTipoEquipo" required style="width: 100%;" disabled></select>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label>Nombre Equipo <small class="text-danger">*</small></label>
                            <input type="text" class="form-control readonly" name="dGNombreEquipo" id="dGNombreEquipo" placeholder="Nombre Equipo" readonly required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <label>Marca <small class="text-danger">*</small></label>
                            <input type="text" class="form-control readonly" name="dGMarca" id="dGMarca" placeholder="Marca" readonly required>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label>Modelo <small class="text-danger">*</small></label>
                            <input type="text" class="form-control readonly" name="dGModelo" id="dGModelo" placeholder="Modelo" readonly required>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label>Serie <small class="text-danger">*</small></label>
                            <input type="text" class="form-control readonly" name="dGSerie" id="dGSerie" placeholder="Serie" readonly required>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label>Activo Fijo <small class="text-danger">*</small></label>
                            <input type="text" class="form-control readonly" name="dGActivoFijo" id="dGActivoFijo" placeholder="Activo Fijo" readonly required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>Registro Sanitario Invima <small class="text-danger">*</small></label>
                            <input type="text" class="form-control readonly" name="dGRegistroSaniInvima" id="dGRegistroSaniInvima" placeholder="Registro Sanitario Invima" required>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Sede <small class="text-danger">*</small></label>
                            <select class="form-control select-field" name="dGSede" id="dGSede" required style="width: 100%;" disabled></select>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Ubicacion <small class="text-danger">*</small></label>
                            <input type="text" class="form-control readonly" name="dGUbicacion" id="dGUbicacion" placeholder="Ubicacion" readonly required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label>Servicio <small class="text-danger">*</small></label>
                            <select class="form-control select-field" name="dGServicio" id="dGServicio" required style="width: 100%;" disabled></select>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Clasificacion Biomedica <small class="text-danger">*</small></label>
                            <select class="form-control select-field" name="dGClasificacionBio" id="dGClasificacionBio" required style="width: 100%;" disabled></select>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label>Clasificacion Riesgo <small class="text-danger">*</small></label>
                            <select class="form-control select-field" name="dGClasificacionRiesgo" id="dGClasificacionRiesgo" required style="width: 100%;" disabled></select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <label>Tipo Mantenimientos <small class="text-danger">*</small></label>
                            <select class="form-control select-field-multiple" multiple name="tipoMantenimiento" disabled id="tipoMantenimiento" required style="width: 100%;"></select>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label>Frecuencia Mantenimiento <small class="text-danger">*</small></label>
                            <select class="form-control" name="frecuenciaMantenimiento" id="frecuenciaMantenimiento" disabled required style="width: 100%;">
                                <option value="">Seleccione Frecuencia Mantenimiento</option>
                                <option value="SEMESTRAL">SEMESTRAL</option>
                                <option value="ANUAL">ANUAL</option>
                                <option value="NO APLICA">NO APLICA</option>
                            </select>
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
                            <h4 class="text-white mb-0">Gestionar Mantenimiento</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="formGestionMantenimiento" name="formGestionMantenimiento" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12 d-grid">
                                <a class="btn btn-outline-success mt-2" data-bs-toggle="collapse" href="#collapseInfoSolicitud" role="button" aria-expanded="false" aria-controls="collapseInfoSolicitud">Informacion Solicitud Mantenimiento</a>
                                <div class="collapse mt-2" id="collapseInfoSolicitud">
                                    <div class="border p-3 rounded">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 mb-2">
                                                <label>Orden No. <small class="text-danger">*</small></label>
                                                <div id="txtSoliOrdenNo"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 mb-2">
                                                <label>Cargo <small class="text-danger">*</small></label>
                                                <div id="txtSoliCargo"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 mb-2">
                                                <label>Descripcion Incidencia <small class="text-danger">*</small></label>
                                                <div id="txtSoliDescripcionIncidencia"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 mb-2">
                                                <label>Fecha Ejecucion <small class="text-danger">*</small></label>
                                                <div id="txtSoliFechaEjecucion"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 mb-2">
                                                <label>Responsable <small class="text-danger">*</small></label>
                                                <div id="txtSoliResponsable"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 mb-2">
                                                <label>Requiere Repuesto <small class="text-danger">*</small></label>
                                                <div id="txtSoliRequiereRespuesto"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 mb-2">
                                                <label>Descripcion Falla</label>
                                                <div id="txtSoliDescripcionFalla"></div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 mb-2">
                                                <label>Respuestos Necesarios</label>
                                                <div id="txtSoliRespuestosNecesarios"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <div class="accordion" id="accordionMantePreventivos">
                                    <div class="accordion-item border-top border-300">
                                        <h2 class="accordion-header" id="headingMantePreventivos">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMantePreventivos" aria-expanded="false" aria-controls="collapseMantePreventivos">
                                                Mantenimientos Preventivos
                                            </button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="collapseMantePreventivos" aria-labelledby="headingMantePreventivos" data-bs-parent="#accordionMantePreventivos">
                                            <div class="accordion-body pt-4">
                                                <div id="contenedorCheckPreventivos"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="accordion" id="accordionManteCorrectivos">
                                    <div class="accordion-item border-top border-300">
                                        <h2 class="accordion-header" id="headingManteCorrectivos">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseManteCorrectivos" aria-expanded="false" aria-controls="collapseManteCorrectivos">
                                                Mantenimientos Correctivos
                                            </button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="collapseManteCorrectivos" aria-labelledby="headingManteCorrectivos" data-bs-parent="#accordionManteCorrectivos">
                                            <div class="accordion-body pt-4">
                                                <div id="contenedorCheckCorrectivos"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-12 mb-2">
                                <label>Observaciones Mantenimiento <small class="text-danger">*</small></label>
                                <textarea class="form-control" name="gMObservacionesMantenimiento" id="gMObservacionesMantenimiento" rows="5" minlength="10" maxlength="5000" placeholder="Observaciones Mantenimiento" required></textarea>
                            </div>
                        </div>
                        <center><button type="submit" class="btn btn-outline-success me-1" onclick="guardarMantenimiento()"><i class="far fa-save"></i> Guardar</button></center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="views/js/inventario/mantenimientos.js?v=<?= md5_file('views/js/inventario/mantenimientos.js') ?>"></script>
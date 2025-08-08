<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
    <form id="formCitaPsicologia" name="formCitaPsicologia" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Formulario Cita Psicologia</h4>
                </div>
                <div class="col col-md-auto">
                    <button class="btn btn-phoenix-danger ms-2" onclick="guardarCitaFallida()"><i class="far fa-calendar-times"></i> Fallida</button>
                    <button class="btn btn-phoenix-success ms-2" onclick="guardarCitaPsicologia()"><i class="far fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Valoracion Psicologia</label>
                    <select class="form-control" name="valoracionPsicologia" id="valoracionPsicologia" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Proximo Control</label>
                    <select class="form-control" name="proximoControl" id="proximoControl" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="row mb-2">
                        <center><label>Fecha</label></center>
                        <div class="col-sm-12 col-md-6">
                            <input type="number" class="form-control" min="0" name="numeroFecha" min="0" id="numeroFecha" placeholder="Dia/Semana/Mes" required>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <select class="form-control" name="especificacionFecha" id="especificacionFecha" required>
                                <option value="">Seleccione una opcion</option>
                                <option value="DIA">DIA</option>
                                <option value="SEMANA">SEMANA</option>
                                <option value="MES">MES</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Educacion Individual y/o Familiar</label>
                    <select class="form-control" name="educacionIndividualFamiliar" id="educacionIndividualFamiliar" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Consulta Gestante</label>
                    <select class="form-control" name="consultaGestante" id="consultaGestante" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Riesgo Psicosocial</label>
                    <select class="form-control" name="riesgoPsicosocial" id="riesgoPsicosocial" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Remision para Seguimiento</label>
                    <select class="form-control" name="remisionSeguimiento" id="remisionSeguimiento" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Educacion Signos de Alarma</label>
                    <select class="form-control" name="educacionSignosAlarma" id="educacionSignosAlarma" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Notificacion Inmediata de Alertas</label>
                    <select class="form-control" name="notificacionInmediataAlertas" id="notificacionInmediataAlertas" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Reporta a Sivigila</label>
                    <select class="form-control" name="reportaSivigila" id="reportaSivigila" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label>Tipo de Reporte</label>
                    <input type="text" class="form-control" minlength="10" name="tipoReporte" id="tipoReporte" placeholder="Tipo Reporte" maxlength="250" required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12">
                    <label>Observaciones</label>
                    <textarea class="form-control" rows="2" name="observaciones" id="observaciones" minlength="10" maxlength="250" placeholder="Observaciones" required></textarea>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
    <form id="formCitaNutricion" name="formCitaNutricion" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Formulario Cita Nutricion</h4>
                </div>
                <div class="col col-md-auto">
                    <button class="btn btn-phoenix-danger ms-2" onclick="guardarCitaFallida()"><i class="far fa-calendar-times"></i> Fallida</button>
                    <button class="btn btn-phoenix-success ms-2" onclick="guardarCitaNutricion()"><i class="far fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Valoracion Nutricional</label>
                    <select class="form-control" name="valoracionNutricional" id="valoracionNutricional" required>
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
                    <label class="">Verificacion de CPN y Vacunacion</label>
                    <select class="form-control" name="verificacionCpnVacunacion" id="verificacionCpnVacunacion" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Realizacion de estrategia ETMI - Plus</label>
                    <select class="form-control" name="realizacionEstrategiaEtmiPlus" id="realizacionEstrategiaEtmiPlus" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Soporte Nutricional</label>
                    <select class="form-control" name="soporteNutricional" id="soporteNutricional" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Nombre del Soporte</label>
                    <input type="text" class="form-control" minlength="10" name="nombreSoporte" id="nombreSoporte" placeholder="Nombre del Soporte" required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Usuario Gastrostomia</label>
                    <select class="form-control" name="usuarioGastrostomia" id="usuarioGastrostomia" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Perimetro ABD</label>
                    <input type="number" class="form-control" min="0" name="perimetroAbd" id="perimetroAbd" placeholder="Perimetro ABD" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Perimetro Pantorrilla</label>
                    <input type="number" class="form-control" min="0" name="perimetroPantorrilla" id="perimetroPantorrilla" placeholder="Perimetro Pantorrilla" required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Perimetro Braquial</label>
                    <input type="number" class="form-control" min="0" name="perimetroBraquial" id="perimetroBraquial" placeholder="Perimetro Braquial" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">IMC</label>
                    <input type="number" class="form-control" min="0" name="imc" id="imc" placeholder="IMC" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Peso</label>
                    <input type="number" class="form-control" min="0" name="peso" id="peso" placeholder="Peso" required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Talla</label>
                    <input type="number" class="form-control" min="0" name="talla" id="talla" placeholder="Talla" required>
                </div>
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
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <label class="">Notificacion Inmediata de Alertas</label>
                    <select class="form-control" name="notificacionInmediataAlertas" id="notificacionInmediataAlertas" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-6">
                    <label>Observaciones</label>
                    <textarea class="form-control" rows="2" name="observaciones" id="observaciones" minlength="10" maxlength="250" placeholder="Observaciones" required></textarea>
                </div>
            </div>
        </div>
    </form>
</div>
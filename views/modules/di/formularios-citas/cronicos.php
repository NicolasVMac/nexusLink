<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
    <form id="formCitaCronicos" name="formCitaCronicos" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Formulario Cita Cronicos</h4>
                </div>
                <div class="col col-md-auto">
                    <button class="btn btn-phoenix-danger ms-2" onclick="guardarCitaFallida()"><i class="far fa-calendar-times"></i> Fallida</button>
                    <button class="btn btn-phoenix-success ms-2" onclick="guardarCitaCronicos()"><i class="far fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
        
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">TF</label>
                    <input type="number" class="form-control" min="0" name="tf" id="tf" placeholder="TF" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">TO</label>
                    <input type="number" class="form-control" min="0" name="too" id="too" placeholder="TO" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">TL</label>
                    <input type="number" class="form-control" min="0" name="tl" id="tl" placeholder="TL" required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">TR</label>
                    <input type="text" class="form-control" min="0" name="tr" id="tr" placeholder="TR" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Psicologia</label>
                    <select class="form-control" name="psicologia" id="psicologia" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Trabajo Social</label>
                    <select class="form-control" name="trabajoSocial" id="trabajoSocial" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Nutricion</label>
                    <select class="form-control" name="nutricion" id="nutricion" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Toma Laboratorios</label>
                    <select class="form-control" name="tomaLaboratorios" id="tomaLaboratorios" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="row mb-2">
                        <center><label>Proximo Control</label></center>
                        <div class="col-sm-12 col-md-6">
                            <input type="number" class="form-control" min="0" name="numeroProximoControl" min="0" id="numeroProximoControl" placeholder="Dia/Semana/Mes" required>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <select class="form-control" name="especificacionProximoControl" id="especificacionProximoControl" required>
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
                    <label class="">Clinica Heridas</label>
                    <select class="form-control" name="clinicaHeridas" id="clinicaHeridas" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Cambio Sonda</label>
                    <select class="form-control" name="cambioSonda" id="cambioSonda" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">PHD Cronicos Agudizado</label>
                    <select class="form-control" name="phdCronicosAgudizados" id="phdCronicosAgudizados" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Suspende Tratamiento</label>
                    <select class="form-control" name="suspendeTratamiento" id="suspendeTratamiento" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Finaliza Tratamiento</label>
                    <select class="form-control" name="finalizaTratamiento" id="finalizaTratamiento" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Cambio Manejo</label>
                    <select class="form-control" name="cambioManejo" id="cambioManejo" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <center><label>Enfermeria Cuidado en Casa</label></center>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label class="">Inicia</label>
                            <select class="form-control" name="inicia" id="inicia" required>
                                <option value="">Seleccione una opcion</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label class="">Termina</label>
                            <select class="form-control" name="termina" id="termina" required>
                                <option value="">Seleccione una opcion</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <label>Observaciones</label>
                    <textarea class="form-control" rows="2" name="observaciones" id="observaciones" minlength="10" maxlength="250" placeholder="Observaciones" required></textarea>
                </div>
            </div>
        </div>
    </form>
</div>
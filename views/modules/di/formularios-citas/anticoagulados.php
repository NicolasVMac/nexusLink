<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
    <form id="formCitaAnticoagulados" name="formCitaAnticoagulados" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Formulario Cita Anticoagulados</h4>
                </div>
                <div class="col col-md-auto">
                    <button class="btn btn-phoenix-danger ms-2" onclick="guardarCitaFallida()"><i class="far fa-calendar-times"></i> Fallida</button>
                    <button class="btn btn-phoenix-success ms-2" onclick="guardarCitaAnticoagulados()"><i class="far fa-save"></i> Guardar</button>
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
                    <label class="">Succion</label>
                    <input type="text" class="form-control" min="0" name="succion" id="succion" placeholder="Succion" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Toma Laboratorios</label>
                    <select class="form-control" name="tomaLaboratorios" id="tomaLaboratorios" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Fecha Toma Laboratorios</label>
                    <input type="date" class="form-control" name="fechaTomaLaboratorios" id="fechaTomaLaboratorios" required>
                </div>
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
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Salida</label>
                    <select class="form-control" name="salida" id="salida" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Continua</label>
                    <select class="form-control" name="continua" id="continua" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Reingreso</label>
                    <select class="form-control" name="reingreso" id="reingreso" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
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
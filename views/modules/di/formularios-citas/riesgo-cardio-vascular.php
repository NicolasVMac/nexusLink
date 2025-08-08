<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
    <form id="formCitaRiesgoCardioVascular" name="formCitaRiesgoCardioVascular" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Formulario Cita Riesgo Cardio Vascular</h4>
                </div>
                <div class="col col-md-auto">
                    <button class="btn btn-phoenix-danger ms-2" onclick="guardarCitaFallida()"><i class="far fa-calendar-times"></i> Fallida</button>
                    <button class="btn btn-phoenix-success ms-2" onclick="guardarCitaRiesgoCardioVascular()"><i class="far fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Evaluacion Consumo Tabaco</label>
                    <select class="form-control" name="evaluacionConsumoTabaco" id="evaluacionConsumoTabaco" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Laboratorios Recientes</label>
                    <select class="form-control" name="laboratoriosRecientes" id="laboratoriosRecientes" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Ordenamiento de Laboratorios</label>
                    <select class="form-control" name="ordenamientoLaboratorios" id="ordenamientoLaboratorios" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Evaluacion Ancedentes (Familiares y Personales - Hábitos Alimenticios, Actividad Física)</label>
                    <select class="form-control" name="evaluacionAntecedentes" id="evaluacionAntecedentes" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Evaluacion RCV (Framingham/OMS)</label>
                    <select class="form-control" name="evaluacionRcv" id="evaluacionRcv" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Evaluacion RCM (Findrisk)</label>
                    <select class="form-control" name="evaluacionRcm" id="evaluacionRcm" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Evaluacion EPOC</label>
                    <select class="form-control" name="evaluacionEpoc" id="evaluacionEpoc" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Evaluacion IMC</label>
                    <select class="form-control" name="evaluacionImc" id="evaluacionImc" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Educacion Individual</label>
                    <select class="form-control" name="educacionIndividual" id="educacionIndividual" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Derivo a Educacion Grupal</label>
                    <select class="form-control" name="derivoEducacionGrupal" id="derivoEducacionGrupal" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Confirmacion Diagnostica</label>
                    <select class="form-control" name="confirmacionDiagnostica" id="confirmacionDiagnostica" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                        <option value="PENDIENTE">PENDIENTE</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
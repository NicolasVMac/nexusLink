<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
    <form id="formCitaSaludInfantil" name="formCitaSaludInfantil" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Formulario Cita Salud Infantil</h4>
                </div>
                <div class="col col-md-auto">
                    <button class="btn btn-phoenix-danger ms-2" onclick="guardarCitaFallida()"><i class="far fa-calendar-times"></i> Fallida</button>
                    <button class="btn btn-phoenix-success ms-2" onclick="guardarCitaSaludInfantil()"><i class="far fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Peso</label>
                    <input type="number" class="form-control" name="pesoSaludInfantil" min="1" id="pesoSaludInfantil" placeholder="Peso (KG)" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Talla</label>
                    <input type="number" class="form-control" min="1" name="tallaSaludInfantil" id="tallaSaludInfantil" placeholder="Talla" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Perimetro Braquial</label>
                    <input type="number" class="form-control" name="perimetroBraquial" min="1" id="perimetroBraquial" placeholder="Perimetro Braquial" required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Lactancia materna exclusiva</label>
                    <!-- <input type="text" class="form-control" name="lactanciaMaternaExclu" id="lactanciaMaternaExclu" placeholder="Lactancia materna exclusiva" required> -->
                    <select class="form-control" name="lactanciaMaternaExclu" id="lactanciaMaternaExclu" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Consejeria lactancia materna</label>
                    <!-- <input type="number" class="form-control" name="consejeriaLactanciaMaterna" id="consejeriaLactanciaMaterna" placeholder="Consejeria lactancia materna" required> -->
                    <select class="form-control" name="consejeriaLactanciaMaterna" id="consejeriaLactanciaMaterna" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Verificacion Esquema PAI y COVID</label>
                    <!-- <input type="text" class="form-control" name="verificacionEsquemaPaiCovid" id="verificacionEsquemaPaiCovid" placeholder="Verificacion Esquema PAI y COVID" required> -->
                    <select class="form-control" name="verificacionEsquemaPaiCovid" id="verificacionEsquemaPaiCovid" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Soporte nutricional</label>
                    <!-- <input type="text" class="form-control" name="soporteNutricional" id="soporteNutricional" placeholder="Soporte nutricional" required> -->
                    <select class="form-control" name="soporteNutricional" id="soporteNutricional" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Nombre del soporte nutricional</label>
                    <!-- <input type="text" class="form-control" name="nombreSoporteNutricional" id="nombreSoporteNutricional" placeholder="Nombre del soporte nutricional" required> -->
                    <select class="form-control" name="nombreSoporteNutricional" id="nombreSoporteNutricional" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Formulacion APME</label>
                    <!-- <input type="number" class="form-control" name="formularioApme" id="formularioApme" placeholder="Formulacion APME" required> -->
                    <select class="form-control" name="formularioApme" id="formularioApme" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Entrega APME</label>
                    <!-- <input type="text" class="form-control" name="entregaApme" id="entregaApme" placeholder="Entrega APME" required> -->
                    <select class="form-control" name="entregaApme" id="entregaApme" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Oximetria</label>
                    <input type="number" class="form-control" name="oximetriaSaludInfantil" id="oximetriaSaludInfantil" min="1" placeholder="Oximetria" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Sintomatologia respiratoria</label>
                    <!-- <input type="text" class="form-control" name="sintomatologiaRespiratoria" id="sintomatologiaRespiratoria" placeholder="Sintomatologia respiratoria" required> -->
                    <select class="form-control" name="sintomatologiaRespiratoria" id="sintomatologiaRespiratoria" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Condiciones de riesgo</label>
                    <!-- <input type="number" class="form-control" name="condicionesRiesgo" id="condicionesRiesgo" placeholder="Condiciones de riesgo" required> -->
                    <select class="form-control" name="condicionesRiesgo" id="condicionesRiesgo" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Educacion Signos de alarma</label>
                    <!-- <input type="text" class="form-control" name="educacionSignosAlarma" id="educacionSignosAlarma" placeholder="Educacion Signos de alarma" required> -->
                    <select class="form-control" name="educacionSignosAlarma" id="educacionSignosAlarma" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Remision a Urgencias</label>
                    <!-- <input type="text" class="form-control" name="remisionUrgencias" id="remisionUrgencias" placeholder="Remision a Urgencias" required> -->
                    <select class="form-control" name="remisionUrgencias" id="remisionUrgencias" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <label class="">Remision a Especialidades</label>
                    <!-- <input type="text" class="form-control" name="remisionEspecialidades" id="remisionEspecialidades" placeholder="Remision a Especialidades" required> -->
                    <select class="form-control" name="remisionEspecialidades" id="remisionEspecialidades" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-6">
                    <label class="">Remision a manejo intramural</label>
                    <!-- <input type="text" class="form-control" name="remisionManejoIntramural" id="remisionManejoIntramural" placeholder="Remision a manejo intramural" required> -->
                    <select class="form-control" name="remisionManejoIntramural" id="remisionManejoIntramural" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
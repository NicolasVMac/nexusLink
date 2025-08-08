<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
    <div class="card-header p-4 border-bottom border-300 bg-info">
        <div class="row g-3 justify-content-between align-items-center">
            <div class="col-12 col-md">
                <div id="contenedorInfoPacienteTitulo"></div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="accordion" id="accordionPaciente">
            <div class="accordion-item border-top border-300">
                <h2 class="accordion-header" id="headingPaciente">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePaciente" aria-expanded="false" aria-controls="collapsePaciente">
                        Informacion Paciente
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapsePaciente" aria-labelledby="headingPaciente" data-bs-parent="#accordionPaciente">
                    <div class="accordion-body">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label class=" text-primary">Documento Paciente</label><div id="textDocPaciente"></div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class=" text-primary">Nombre Paciente</label><div id="textNombrePaciente"></div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class=" text-primary">Fecha Nacimiento</label><div id="textFechaNacimiento"></div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class=" text-primary">Edad</label><div id="textEdadPaciente"></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label class=" text-primary">Genero Paciente</label><div id="textGeneroPaciente"></div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class=" text-primary">Estado Civil</label><div id="textEstadoCivilPaciente"></div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class=" text-primary">Escolaridad</label><div id="textEscolaridadPaciente"></div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class=" text-primary">Vinculacion</label><div id="textVinculacionPaciente"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Re-Asignar Cita</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formBusquedaPacienteCita" name="formBusquedaPacienteCita" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Tipo Documento</label>
                        <select class="form-control select-field" name="tipoDocPaciente" id="tipoDocPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Tipo Busqueda</label>
                        <select class="form-control select-field" name="tipoDato" id="tipoDato" required style="width: 100%;">
                            <option value="">Seleccione una opcion</option>
                            <option value="Numero Documento">Numero Documento</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Numero Documento</label>
                        <input type="number" class="form-control" name="numeroDocumento" id="numeroDocumento" placeholder="Numero Documento" required>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="buscarCitaPaciente()"><i class="fas fa-search"></i> Buscar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoBusquedaPacienteCitas" data-component-card="data-component-card" style="display: none;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Resultado:</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card shadow-lg border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <div class="table-responsive">
                                <table id="tablaCitasPaciente" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PACIENTE</th>
                                            <th>DOCUMENTO PACIENTE</th>
                                            <th>PROFESIONAL</th>
                                            <th>MOTIVO CITA</th>
                                            <th>COHORTE O PROGRAMA</th>
                                            <th>FECHA CITA</th>
                                            <th>LOCALIDAD</th>
                                            <th>ESTADO</th>
                                            <th>OPCIONES</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="views/js/di/parametricas.js?v=<?= md5_file('views/js/di/parametricas.js') ?>"></script>
<script src="views/js/di/agendamiento.js?v=<?= md5_file('views/js/di/agendamiento.js') ?>"></script>
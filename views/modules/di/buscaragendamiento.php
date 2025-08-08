<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Buscar Agendamiento</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formBuscarAgendamiento" name="formBuscarAgendamiento" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Tipo Documento</label>
                        <select class="form-control select-field" name="tipoDocumentoSearch" id="tipoDocumentoSearch" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <label class="">Numero Documento</label>
                        <input type="number" class="form-control" name="numeroDocSearch" id="numeroDocSearch" required>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="buscarAgendamiento()"><i class="fas fa-search"></i> Buscar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoBusquedaAgendamiento" data-component-card="data-component-card" style="display: none;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Resultado:</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaBusquedaAgendamiento" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>BASE</th>
                            <th>IPS</th>
                            <th>NOMBRE PACIENTE</th>
                            <th>DOCUMENTO PACIENTE</th>
                            <th>NUMERO CELULAR</th>
                            <th>TELEFONO FIJO</th>
                            <th>DIRECCION</th>
                            <th>COHORTE O PROGRAMA</th>
                            <th>REGIMEN</th>
                            <th>ESTADO</th>
                            <th>ASESOR</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAsignarAgendamiento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAsignarAgendamiento" name="formAsignarAgendamiento" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="modalAsignarAgendamientoLabel"></h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idBolsaPacienteAsignar" id="idBolsaPacienteAsignar" required>
                    <label class="">Usuario Agendador</label>
                    <select class="form-control" name="usuarioAgendador" id="usuarioAgendador" required style="width: 100%;">
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" onclick="asignarAgendamiento()"><i class="far fa-save"></i> Asignar</button>
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/di/agendamiento.js?v=<?= md5_file('views/js/di/agendamiento.js') ?>"></script>
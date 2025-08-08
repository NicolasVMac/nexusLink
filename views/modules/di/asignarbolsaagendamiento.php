<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-7">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Usuarios Bolsas Agendamientos</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaUsuariosBolsaAgendamiento" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th>USUARIO</th>
                                    <th>COHORTE O PROGRAMA</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>  
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-5">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <form id="formAsignarBolsaAgendamiento" name="formAsignarBolsaAgendamiento" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Asignar Bolsa Agendamiento</h4>
                            </div>
                            <div class="col col-md-auto">
                                <button class="btn btn-phoenix-success ms-2" onclick="guardarAsignacionBolsaAgendamiento()"><i class="far fa-save"></i> Guardar Asignacion</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-6">
                                <label class="">Usuario</label>
                                <select class="form-control select-field" name="usuarioAgendamiento" id="usuarioAgendamiento" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="">Cohorte o Programa</label>
                                <select class="form-control select-field" name="cohorteProgramaAgendamiento" id="cohorteProgramaAgendamiento" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="views/js/di/agendamiento.js?v=<?= md5_file('views/js/di/agendamiento.js') ?>"></script>
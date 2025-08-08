<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <form id="formAgregarUsuarioProfesional" name="formAgregarUsuarioProfesional" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Agregar Profesional</h4>
                            </div>
                            <div class="col col-md-auto">
                                <button class="btn btn-phoenix-success ms-2" onclick="agregarUsuarioProfesional()"><i class="far fa-save"></i> Agregar Profesional</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <small class="text-danger">* La Contraseña del usuario sera el Numero de Documento.</small>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label class="">Nombres</label>
                                <input type="text" class="form-control" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre" required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label class="">Apellidos</label>
                                <input type="text" class="form-control" name="apellidosUsuario" id="apellidosUsuario" placeholder="Apellidos" required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label class="">Documento</label>
                                <input type="number" class="form-control" name="documentoUsuario" id="documentoUsuario" placeholder="Documento" required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label class="">Telefono</label>
                                <input type="number" class="form-control" name="telefonoUsuario" id="telefonoUsuario" placeholder="Telefono" required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label class="">Correo</label>
                                <input type="email" class="form-control" name="correoUsuario" id="correoUsuario" placeholder="Correo" required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label class="">Cargo</label>
                                <select class="form-control" name="cargoUsuario" id="cargoUsuario" required>
                                    <option value="">Seleccione una opcion</option>
                                    <option value="JEFE ENFERMERIA">JEFE ENFERMERIA</option>
                                    <option value="MEDICO GENERAL">MEDICO GENERAL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Profesionales</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaProfesionalAgendamiento" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th>NUMERO DOCUMENTO</th>
                                    <th>USUARIO</th>
                                    <th>CARGO</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="views/js/di/agendamiento.js?v=<?= md5_file('views/js/di/agendamiento.js') ?>"></script>
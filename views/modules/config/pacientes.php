<div class="content">
    <div class="card shadow-none border border-300" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h3 class="text-white mb-0" data-anchor="data-anchor" id="basic-example">Pacientes<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#basic-example" style="padding-left: 0.375em;"></a></h3>
                </div>
                <div class="col col-md-auto">
                    <a class="btn btn-phoenix-success me-1 mb-1" href="<?php echo 'index.php?ruta='.$carpeta.'/agregarpaciente'; ?>"><span class="fas fa-hospital-user"></span> Agregar Paciente</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaPacientes" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>NUMERO DOCUMENTO</th>
                            <th>EDAD</th>
                            <th>CORREO</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="views/js/config/pacientes.js?v=<?= md5_file('views/js/config/pacientes.js') ?>"></script>
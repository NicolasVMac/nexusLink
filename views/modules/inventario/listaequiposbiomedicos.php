<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Lista Equipos Biomedicos</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaEquiposBiomedicos" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TIPO EQUIPO</th>
                            <th>NOMBRE EQUIPO</th>
                            <th>MARCA</th>
                            <th>MODELO</th>
                            <th>SERIE</th>
                            <th>ACTIVO FIJO</th>
                            <th>SEDE</th>
                            <th>UBICACION</th>
                            <th>SERVICIO</th>
                            <th>CLASIFICACION BIOMEDICA</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>  
        </div>
    </div>
</div>

<script src="views/js/inventario/inventario-biomedico.js?v=<?= md5_file('views/js/inventario/inventario-biomedico.js') ?>"></script>
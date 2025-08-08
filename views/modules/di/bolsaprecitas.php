<div class="content">

    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Bolsa Pre-Citas</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="mb-2">
                    <span class="badge badge-phoenix badge-phoenix-danger">2024-XX-XX</span><small> Pre-Citas menores o igual a 2 dias de la fecha actual.</small><br>
                    <span class="badge badge-phoenix badge-phoenix-warning">2024-XX-XX</span><small> Pre-Citas que esten entre el rango de 3 a 5 dias de la fecha actual.</small><br>
                    <span class="badge badge-phoenix badge-phoenix-success">2024-XX-XX</span><small> Pre-Citas que esten mayores a 5 dias de la fecha actual.</small><br>
                </div>
                <table id="tablaBolsaPreCitas" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE PACIENTE</th>
                            <th>DOCUMENTO PACIENTE</th>
                            <th>NUMERO CELULAR</th>
                            <th>DIRECCION</th>
                            <th>MOTIVO CITA</th>
                            <th>FECHA CITA</th>
                            <th>FRANJA CITA</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>  
        </div>
    </div>
</div>

<script src="views/js/di/citas.js?v=<?= md5_file('views/js/di/citas.js') ?>"></script>
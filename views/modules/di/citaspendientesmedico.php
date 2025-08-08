<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Citas Pendientes Medico</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaCitasPendientesMedico" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>FECHA CITA</th>
                            <th>FRANJA CITA</th>
                            <th>NOMBRE PACIENTE</th>
                            <th>DOCUMENTO PACIENTE</th>
                            <th>NUMERO CELULAR</th>
                            <th>TELEFONO FIJO</th>
                            <th>DIRECCION</th>
                            <th>COHORTE O PROGRAMA</th>
                            <th>MOTIVO CITA</th>
                            <th>ESTADO</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>  
        </div>
    </div>
</div>

<script src="views/js/di/citas.js?v=<?= md5_file('views/js/di/citas.js') ?>"></script>
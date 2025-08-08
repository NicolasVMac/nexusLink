<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Consolidado Otros Especialistas Profesional</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formReportOtraEspecialidad" name="formReportOtraEspecialidad" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Especialidad</label>
                        <select class="form-control select-field" name="listaOtrasEspecialistas" id="listaOtrasEspecialistas" onchange="onChangeOtrasEspecialidad(this)" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Base</label>
                        <select class="form-control select-field" name="basesEncuestasEspecialistas" id="basesEncuestasEspecialistas" onchange="onChangeBaseEncuesta(this)" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Profesional</label>
                        <select class="form-control select-field" name="profesionalesEncuesta" id="profesionalesEncuesta" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteOtraEspecialidadProfesional()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoOtraEspecialidad" data-component-card="data-component-card" style="display: none;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Resultado:</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row cardBodyResult">
            </div>
        </div>
    </div>

</div>

<script src="views/js/encuestas/reportes-profesional.js?v=<?= md5_file('views/js/encuestas/reportes-profesional.js') ?>"></script>
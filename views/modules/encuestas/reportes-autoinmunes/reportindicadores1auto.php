<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Reporte Indicadores</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formReportIndicadores" name="formReportIndicadores" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                        <label class="">Base Encuestas</label>
                        <select class="form-control select-field" name="basesEncuestas" id="basesEncuestas" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <div class="row mb-2">
                    <center><button class="btn btn-success btn-sm" onclick="generarReporteIndicador()"><i class="fas fa-search"></i> Generar</button></center>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-none border border-300 mb-2" id="cardResultadoIndicador" data-component-card="data-component-card" style="display: none;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Resultado:</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="tablaIndicadores" style="width:100%;">
                <thead>
                    <th>NOMBRE DEL INDICADOR</th>
                    <th>NUMERADOR</th>
                    <th>FUENTE DEL NUMERADOR</th>
                    <th>DENOMINADOR</th>
                    <th>FUENTE DEL DENOMINADOR</th>
                    <th>META</th>
                    <th>PERIODICIDAD</th>
                    <th>SEMESTRE</th>
                    <th>NUMERADOR/DENOMINADOR</th>
                </thead>
                <tbody class="tbodyTable"></tbody>
            </table>
        </div>
    </div>

</div>

<script src="views/js/encuestas/reportes-autoinmunes.js?v=<?= md5_file('views/js/encuestas/reportes-autoinmunes.js') ?>"></script>
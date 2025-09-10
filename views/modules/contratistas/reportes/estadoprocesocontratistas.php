<div class="content">
    <h3 class="mb-3">Reporte Estado Proceso</h3>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Estado Proceso Contratos</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="estadoProcesoContratos" class="table table-striped text-center" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="background-color: #f56954 !important;" class="text-white text-center"><button class="btn btn-danger btn-sm" onclick="generarTablaContratos('vencido')"><= 0 DIAS</button></th>
                                    <th style="background-color: #ff851b !important;" class="text-white text-center"><button class="btn btn-default btn-sm" onclick="generarTablaContratos('1-30')" style="background-color: #D97218;">1 - 30 DIAS</button></th>
                                    <th style="background-color: #f39c12 !important;" class="text-white text-center"><button class="btn btn-warning btn-sm" onclick="generarTablaContratos('31-59')">31 - 59 DIAS</button></th>
                                    <th style="background-color: #00a65a !important;" class="text-white text-center"><button class="btn btn-success btn-sm" onclick="generarTablaContratos('futuro')">>= 60 DIAS</button></th>
                                </tr>
                                <tr>
                                    <th style="background-color: #f56954 !important;" class="text-white text-center">CONTRATOS VENCIDOS</th>
                                    <th style="background-color: #ff851b !important;" class="text-white text-center">CONTRATOS 1 - 30 DIAS A VENCER</th>
                                    <th style="background-color: #f39c12 !important;" class="text-white text-center">CONTRATOS 31 - 59 DIAS VENCER</th>
                                    <th style="background-color: #00a65a !important;" class="text-white text-center">CONTRATOS FUTUROS</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <font size="2"><p class="help-block" >*Las fechas de vencimiento en interventoria de contratos tienen las siguientes concideraciones:<br/>
                    1. <b><= 0 Dias</b>, Son todos los contratos que tienen 0 menos dias en relacion a su fecha de vencimiento.<br/>
                    2. <b>1-30 Dias</b>, Son todas los contratos que tienen entre 1-30 dias en relacion a su fecha de vencimiento.<br/>
                    3. <b>31-59 Dias</b>, Son todas los contratos que tienen entre 31-90 dias en relacion a su fecha de vencimiento.<br/>
                    4. <b>>= 60 Dias</b>, Son todas los contratos que tienen mas de 90 dias en relacion a su fecha de vencimiento.<br/>
                    </p></font> 
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Estado Proceso Polizas</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="estadoProcesoPolizas" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="background-color: #f56954 !important;" class="text-white text-center"><button class="btn btn-danger btn-sm" onclick="generarTablaPolizas('vencido')"><= 1 DIAS</button></th>
                                    <th style="background-color: #ff851b !important;" class="text-white text-center"><button class="btn btn-default btn-sm" onclick="generarTablaPolizas('2-7')" style="background-color: #D97218;">2 - 7 DIAS</button></th>
                                    <th style="background-color: #f39c12 !important;" class="text-white text-center"><button class="btn btn-warning btn-sm" onclick="generarTablaPolizas('8-14')">8 - 14 DIAS</button></th>
                                    <th style="background-color: #00a65a !important;" class="text-white text-center"><button class="btn btn-success btn-sm" onclick="generarTablaPolizas('futuro')">>= 15 DIAS</button></th>
                                </tr>
                                <tr>
                                    <th style="background-color: #f56954 !important;" class="text-white text-center">POLIZAS VENCIDOS</th>
                                    <th style="background-color: #ff851b !important;" class="text-white text-center">POLIZAS 1 - 30 DIAS A VENCER</th>
                                    <th style="background-color: #f39c12 !important;" class="text-white text-center">POLIZAS 31 - 59 DIAS VENCER</th>
                                    <th style="background-color: #00a65a !important;" class="text-white text-center">POLIZAS FUTUROS</th>
                                </tr>
                            </thead>
                        </table>
                    </div>  
                    <font size="2"><p class="help-block" >*Las fechas de vencimiento en interventoria de contratos tienen las siguientes concideraciones:<br/>
                        1. <b><= 1 Dias</b>, Son todas las polizas que tienen 1 o menos dias en relacion a su fecha de vencimiento.<br/>
                        2. <b>2-7 Dias</b>, Son todas los polizas que tienen entre 1-7 dias en relacion a su fecha de vencimiento.<br/>
                        3. <b>8-14 Dias</b>, Son todas los polizas que tienen entre 8-15 dias en relacion a su fecha de vencimiento.<br/>
                        4. <b>>= 15 Dias</b>, Son todas los polizas que tienen mas de 15 dias en relacion a su fecha de vencimiento.<br/>
                    </p></font>
                </div>
            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2 containerTableContratos" data-component-card="data-component-card" style="display: none;">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Contratos:</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="listaEstadoContratos" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>TIPO PAGADOR</th>
                                    <th>PAGADOR</th>
                                    <th>IDENTIFICACION PAGADOR</th>
                                    <th>TIPO CONTRATO</th>
                                    <th>NOMBRE CONTRATO</th>
                                    <th>VIGENCIA</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>  
                </div>
            </div>

        </div>
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2 containerTablePolizas" data-component-card="data-component-card" style="display: none;">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Polizas:</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="listaEstadoPolizas" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>TIPO CONTRATO</th>
                                    <th>NOMBRE CONTRATO</th>
                                    <th>ASEGURADORA</th>
                                    <th>TIPO POLIZA</th>
                                    <th>NUMERO POLIZA</th>
                                    <th>AMPARO</th>
                                    <th>VIGENCIA</th>
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

<script src="views/js/contratista/reportes.js?v=<?= md5_file('views/js/contratista/reportes.js') ?>"></script>
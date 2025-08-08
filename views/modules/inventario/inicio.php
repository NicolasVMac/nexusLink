<div class="content">

    <h1>Modulo Inventario Inicio</h1>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-body p-4">
                    <h4 class="text-nowrap">Estado Garantias Equipos Biomedicos</h4>
                    <hr>
                    <div class="table-responsive">
                        <table id="tableEstadosGarantiasBiomedicos" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>ESTADO</th>
                                    <th>EQUIPO</th>
                                    <th>SEDE</th>
                                    <th>SERVICIO</th>
                                    <th>FECHA FIN GARANTIA</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-body p-4">
                    <h4 class="text-nowrap">Estado Mantenimientos Tipo - MTTO Equipos Biomedicos</h4>
                    <hr>
                    <div class="table-responsive">
                        <table id="tableEstadosMantenimientosBiomedicosMto" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>ESTADO</th>
                                    <th>EQUIPO</th>
                                    <th>SEDE</th>
                                    <th>SERVICIO</th>
                                    <th>FRECUENCIA MANTENIMIENTO</th>
                                    <th>FECHA ULTIMO MANTENIMIENTO</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-body p-4">
                    <h4 class="text-nowrap">Estado Mantenimientos Tipo - CLRB Equipos Biomedicos</h4>
                    <hr>
                    <div class="table-responsive">
                        <table id="tableEstadosMantenimientosBiomedicosClbr" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>ESTADO</th>
                                    <th>EQUIPO</th>
                                    <th>SEDE</th>
                                    <th>SERVICIO</th>
                                    <th>FRECUENCIA MANTENIMIENTO</th>
                                    <th>FECHA ULTIMO MANTENIMIENTO</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-body p-4">
                    <h4 class="text-nowrap">Estado Mantenimientos Tipo - VLD Equipos Biomedicos</h4>
                    <hr>
                    <div class="table-responsive">
                        <table id="tableEstadosMantenimientosBiomedicosVld" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>ESTADO</th>
                                    <th>EQUIPO</th>
                                    <th>SEDE</th>
                                    <th>SERVICIO</th>
                                    <th>FRECUENCIA MANTENIMIENTO</th>
                                    <th>FECHA ULTIMO MANTENIMIENTO</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-body p-4">
                    <h4 class="text-nowrap">Estado Mantenimientos Tipo - CL Equipos Biomedicos</h4>
                    <hr>
                    <div class="table-responsive">
                        <table id="tableEstadosMantenimientosBiomedicosCl" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>ESTADO</th>
                                    <th>EQUIPO</th>
                                    <th>SEDE</th>
                                    <th>SERVICIO</th>
                                    <th>FRECUENCIA MANTENIMIENTO</th>
                                    <th>FECHA ULTIMO MANTENIMIENTO</th>
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


<script src="views/js/inventario/inventario-biomedico.js?v=<?= md5_file('views/js/inventario/inventario-biomedico.js') ?>"></script>
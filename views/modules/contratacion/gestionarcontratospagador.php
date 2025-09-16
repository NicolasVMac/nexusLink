<div class="content">
    <h3 class="mb-4 lh-sm text-primary" id="titlePage"></h3>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-900 mb-0 text-white" data-anchor="data-anchor" id="basic-example">Informacion Pagador</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-3">
                    <label class="text-1100 mb-2">Tipo Pagador</label><div id="textTipoPagador"></div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <label class="text-1100 mb-2">Nombre</label><div id="textNombrePagador"></div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <label class="text-1100 mb-2">Tipo Identifacion</label><div id="textTipoIdentiPagador"></div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <label class="text-1100 mb-2">Numero Identificacion</label><div id="textNumeroIdentiPagador"></div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-2">
                    <label class="text-1100 mb-2">Direccion</label><div id="textDireccionPagador"></div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <label class="text-1100 mb-2">Telefono</label><div id="textTelefonoPagador"></div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <label class="text-1100 mb-2">Correo</label><div id="textCorreoPagador"></div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <label class="text-1100 mb-2">Departamento</label><div id="textDepartamentoPagador"></div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <label class="text-1100 mb-2">Ciudad</label><div id="textCiudadPagador"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-900 mb-0 text-white" data-anchor="data-anchor" id="basic-example">Contratos</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                        <form id="formCrearContrato" name="formCrearContrato" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                            <div class="card-header p-3 border-bottom border-300 bg-soft">
                                <div class="row g-3 justify-content-between align-items-center">
                                    <div class="col-12 col-md">
                                        <h4 class="text-900 mb-0" data-anchor="data-anchor" id="basic-example">Crear Contrato</h4>
                                    </div>
                                    <div class="col col-md-auto">
                                        <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                                            <button class="btn btn-outline-success me-1" type="submit" onclick="crearContrato()"><i class="far fa-plus-square"></i> Crear Contrato</button>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <label>Tipo Contrato</label>
                                        <select class="form-select select-field" name="tipoContrato" id="tipoContrato" style="width: 100%;" required>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label>Nombre Contrato</label>
                                        <input type="text" class="form-control" name="nombreContrato" id="nombreContrato" placeholder="Nombre Contrato" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label>Fecha Inicio</label>
                                        <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label>Fecha Fin</label>
                                        <input type="date" class="form-control" name="fechaFin" id="fechaFin" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label>Valor Contrato</label>
                                        <input type="number" class="form-control" min="0" name="valorContrato" id="valorContrato" required>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input mt-2" id="cuantiaInderContrato" onchange="changeCuantiaContrato(this)" type="checkbox"/>
                                            <label class="form-check-label" for="cuantiaInderContrato">Cuantia Indeterminada</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label>Archivo</label>
                                        <input type="file" class="form-control" name="archivoContrato" id="archivoContrato" required>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <label>Objeto Contractual</label>
                                        <textarea class="form-control" rows="5" name="objetoContrato" id="objetoContrato" minlength="10" maxlength="10000" placeholder="Objeto Contractual" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="card">
                        <div class="card-header p-3 border-bottom border-300 bg-soft">
                            <div class="row g-3 justify-content-between align-items-center">
                                <div class="col-12 col-md">
                                    <h4 class="text-900 mb-0" data-anchor="data-anchor" id="basic-example">Lista Contratos</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <span class="badge badge-phoenix badge-phoenix-secondary mb-2">Cuantia Indeterminada</span>
                                <table id="tablaContratos" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>TIPO CONTRATO</th>
                                            <th>CONTRATO</th>
                                            <th>VIGENCIA CONTRATO</th>
                                            <th>VALOR CONTRATO</th>
                                            <th>ARCHIVO</th>
                                            <th>OBJECTO CONTRATO</th>
                                            <th>ESTADO</th>
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
    </div>
                    
</div>

<script src="views/js/contratacion/contratos-pagadores.js?v=<?= md5_file('views/js/contratacion/contratos-pagadores.js') ?>"></script>
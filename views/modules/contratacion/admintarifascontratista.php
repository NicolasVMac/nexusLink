<div class="content">
    <h3 class="mb-4 lh-sm text-primary" id="titlePage"></h3>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0 text-white" data-anchor="data-anchor" id="basic-example">Informacion Contratista</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-2">
                            <label class="text-1100 mb-2">Tipo Contratista</label><div id="textTipoContratista"></div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label class="text-1100 mb-2">Nombre</label><div id="textNombreContratista"></div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <label class="text-1100 mb-2">Tipo Identifacion</label><div id="textTipoIdentiContratista"></div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <label class="text-1100 mb-2">Numero Identificacion</label><div id="textNumeroIdentiContratista"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-2">
                            <label class="text-1100 mb-2">Direccion</label><div id="textDireccionContratista"></div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <label class="text-1100 mb-2">Telefono</label><div id="textTelefonoContratista"></div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label class="text-1100 mb-2">Correo</label><div id="textCorreoContratista"></div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <label class="text-1100 mb-2">Departamento</label><div id="textDepartamentoContratista"></div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <label class="text-1100 mb-2">Ciudad</label><div id="textCiudadContratista"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0 text-white" data-anchor="data-anchor" id="basic-example">Informacion Contrato</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-2">
                            <label class="text-1100 mb-2">Tipo Contrato</label><div id="textTipoContrato"></div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label class="text-1100 mb-2">Nombre Contrato</label><div id="textNombreContrato"></div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label class="text-1100 mb-2">Vigencia Contrato</label><div id="textVigenciaContrato"></div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label class="text-1100 mb-2">Valor Contrato</label><div id="textValorContrato"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-2">
                            <label class="text-1100 mb-2">Archivo</label><div id="textArchivoContrato"></div>
                        </div>
                        <div class="col-sm-12 col-md-10">
                            <label class="text-1100 mb-2">Objeto Contractual</label><div id="textObjetoContractualContrato"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-900 mb-0 text-white" data-anchor="data-anchor" id="basic-example">Administrar Tarifas</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-underline" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link" id="tarifas-tab" data-bs-toggle="tab" href="#tab-tarifas" role="tab" aria-controls="tab-tarifas" aria-selected="true">Tarifas</a></li>
                <li class="nav-item"><a class="nav-link" id="tarifas-masivo-tab" data-bs-toggle="tab" href="#tab-tarifas-masivo" role="tab" aria-controls="tab-tarifas-masivo" aria-selected="true">Cargar Tarifas Masivo</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade" id="tab-tarifas" role="tabpanel" aria-labelledby="tarifas-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                        <form id="formCrearTarifa" name="formCrearTarifa" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                            <div class="card-header p-3 border-bottom border-300 bg-soft">
                                                <div class="row g-3 justify-content-between align-items-center">
                                                    <div class="col-12 col-md">
                                                        <h4 class="text-900 mb-0" data-anchor="data-anchor" id="basic-example">Crear Tarifa</h4>
                                                    </div>
                                                    <div class="col col-md-auto">
                                                        <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                                                            <button class="btn btn-outline-success me-1" type="submit" onclick="crearTarifa()"><i class="far fa-plus-square"></i> Crear Tarifa</button>
                                                        </nav>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-sm-12 col-md-3">
                                                        <label>Tipo Tarifa</label>
                                                        <select class="form-control select-field" name="tTipoTarifa" id="tTipoTarifa" required>
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="MEDICAMENTOS">MEDICAMENTOS</option>
                                                            <option value="INSUMOS">INSUMOS</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label>Codigo</label>
                                                        <input type="text" class="form-control" name="tCodigo" id="tCodigo" placeholder="Codigo Tarifa" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label>Codigo Normalizado</label>
                                                        <input type="text" class="form-control" name="tCodigoNormalizado" id="tCodigoNormalizado" placeholder="Codigo Normalizado" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label>Registro Sanitario</label>
                                                        <input type="text" class="form-control" name="tRegistroSanitario" id="tRegistroSanitario" placeholder="Registro Sanitario" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-sm-12 col-md-3">
                                                        <label>Tarifa Pactada</label>
                                                        <input type="number" class="form-control" name="tTarifaPactada" id="tTarifaPactada" min="0" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label>Tarifa Regulacion</label>
                                                        <input type="number" class="form-control" name="tTarifaRegulacion" id="tTarifaRegulacion" min="0" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="row text-center">
                                                            <label>Vigencia Tarifa</label>
                                                            <div class="col-sm-12 col-md-6">
                                                                <input type="date" class="form-control" name="tFechaInicio" id="tFechaInicio" required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <input type="date" class="form-control" name="tFechaFin" id="tFechaFin" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6">
                                                        <label>Descripcion Tarifa</label>
                                                        <textarea class="form-control" name="tDescripcionTarifa" id="tDescripcionTarifa" rows="5" placeholder="Descripcion Tarifa" minlength="10" maxlength="5000" required></textarea>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <label>Producto</label>
                                                        <textarea class="form-control" name="tProductos" id="tProductos" rows="5" placeholder="Descripcion Producto" minlength="10" maxlength="5000" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="listaTarifasTarifario" class="table table-striped" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>TIPO TARIFA</th>
                                                            <th>CODIGO</th>
                                                            <th>CODIGO NORMALIZADO</th>
                                                            <th>REGISTRO SANITARIO</th>
                                                            <th>TARIFA PACTADA</th>
                                                            <th>TARIFA REGULACION</th>
                                                            <th>VIGENCIA</th>
                                                            <th>DESCRIPCION</th>
                                                            <th>PRODUCTO</th>
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
                <div class="tab-pane fade" id="tab-tarifas-masivo" role="tabpanel" aria-labelledby="tarifas-masivo-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                        <form id="formCargarArchivoTarifa" name="formCargarArchivoTarifa" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                            <div class="card-header p-3 border-bottom border-300 bg-soft">
                                                <div class="row g-3 justify-content-between align-items-center">
                                                    <div class="col-12 col-md">
                                                        <h4 class="text-900 mb-0" data-anchor="data-anchor" id="basic-example">Cargar Tarifas Masivo</h4>
                                                    </div>
                                                    <div class="col col-md-auto">
                                                        <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                                                            <button class="btn btn-outline-success me-1" type="submit" onclick="cargarArchivoMasivoTarifas()"><i class="far fa-plus-square"></i> Cargar</button>
                                                        </nav>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 mb-2">
                                                        <label>Nombre Tarifa</label>
                                                        <input type="text" class="form-control" name="tMNombreArchivo" id="tMNombreArchivo" placeholder="Nombre Archivo" required maxlength="150">
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label>Archivo Tarifas</label>
                                                        <input type="file" class="form-control" name="tMArchivoTarifas" id="tMArchivoTarifas" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="listaArchivosMasivosTarifas" class="table table-striped" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>NOMRBE ARCHIVO</th>
                                                            <th>ARCHIVO</th>
                                                            <th>ESTADO</th>
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
            </div>
        </div>
    </div>
</div>

<script src="views/js/contratacion/admintarifas-contratistas.js?v=<?= md5_file('views/js/contratacion/admintarifas-contratistas.js') ?>"></script>
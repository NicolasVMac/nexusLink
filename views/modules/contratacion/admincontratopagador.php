<div class="content">
    <h3 class="mb-4 lh-sm text-primary" id="titlePage"></h3>
    <div class="row">
        <div class="col-sm-12 col-md-6">
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
                        <div class="col-sm-12 col-md-2">
                            <label class="text-1100 mb-2">Tipo Pagador</label><div id="textTipoPagador"></div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label class="text-1100 mb-2">Nombre</label><div id="textNombrePagador"></div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <label class="text-1100 mb-2">Tipo Identifacion</label><div id="textTipoIdentiPagador"></div>
                        </div>
                        <div class="col-sm-12 col-md-2">
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
                        <div class="col-sm-12 col-md-4">
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
                    <h4 class="text-900 mb-0 text-white" data-anchor="data-anchor" id="basic-example">Administrar Contrato</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-underline" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link" id="prorroga-tab" data-bs-toggle="tab" href="#tab-prorroga" role="tab" aria-controls="tab-prorroga" aria-selected="true">Prorrogas</a></li>
                <li class="nav-item"><a class="nav-link" id="tarifas-tab" data-bs-toggle="tab" href="#tab-tarifas" role="tab" aria-controls="tab-tarifas" aria-selected="true">Tarifas</a></li>
                <li class="nav-item"><a class="nav-link" id="polizas-tab" data-bs-toggle="tab" href="#tab-polizas" role="tab" aria-controls="tab-polizas" aria-selected="false">Polizas</a></li>
                <li class="nav-item"><a class="nav-link" id="contratos-otro-si-tab" data-bs-toggle="tab" href="#tab-contratos-otro-si" role="tab" aria-controls="tab-contratos-otro-si" aria-selected="false">Contrato Otro Si</a></li>
                <li class="nav-item"><a class="nav-link" id="otros-documentos-tab" data-bs-toggle="tab" href="#tab-otros-documentos" role="tab" aria-controls="tab-otros-documentos" aria-selected="false">Otros Documentos</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade" id="tab-prorroga" role="tabpanel" aria-labelledby="prorroga-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                        <form id="formCrearProrroga" name="formCrearProrroga" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                            <div class="card-header p-3 border-bottom border-300 bg-soft">
                                                <div class="row g-3 justify-content-between align-items-center">
                                                    <div class="col-12 col-md">
                                                        <h4 class="text-900 mb-0" data-anchor="data-anchor" id="basic-example">Crear Prorroga</h4>
                                                    </div>
                                                    <div class="col col-md-auto">
                                                        <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                                                            <button class="btn btn-outline-success me-1" type="submit" onclick="crearProrroga()"><i class="far fa-plus-square"></i> Crear Prorroga</button>
                                                        </nav>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                        <div class="row">
                                                            <label>Prorroga (MESES)</label>
                                                            <div class="col-sm-12 col-md-6">
                                                                <input type="number" class="form-control" name="pMesesProrroga" id="pMesesProrroga" min="1" placeholder="Prorroga (MESES)" required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <input type="text" class="form-control readonly" value="MESES" readonly required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label>Observaciones</label>
                                                        <textarea class="form-control" name="pObservacionesProrroga" id="pObservacionesProrroga" rows="5" placeholder="Observaciones" minlength="10" maxlength="5000" required></textarea>
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
                                                <table id="listaProrrogasContrato" class="table table-striped" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>PRORROGA MESES</th>
                                                            <th>OBSERVACIONES</th>
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
                <div class="tab-pane fade" id="tab-tarifas" role="tabpanel" aria-labelledby="tarifas-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
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
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                        <label>Nombre Tarifa</label>
                                                        <input type="text" class="form-control" name="nombreTarifa" id="nombreTarifa" placeholder="Nombre Tarifa" required maxlength="150">
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
                                                <table id="listaParTarifasPrestador" class="table table-striped" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>NOMRBE TARIFA</th>
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
                <div class="tab-pane fade" id="tab-polizas" role="tabpanel" aria-labelledby="polizas-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                        <form id="formCrearPoliza" name="formCrearPoliza" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                            <div class="card-header p-3 border-bottom border-300 bg-soft">
                                                <div class="row g-3 justify-content-between align-items-center">
                                                    <div class="col-12 col-md">
                                                        <h4 class="text-900 mb-0" data-anchor="data-anchor" id="basic-example">Crear Poliza</h4>
                                                    </div>
                                                    <div class="col col-md-auto">
                                                        <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                                                            <button class="btn btn-outline-success me-1" type="submit" onclick="crearPoliza()"><i class="far fa-plus-square"></i> Crear Poliza</button>
                                                        </nav>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-sm-12 col-md-4">
                                                        <label>Tipo Poliza</label>
                                                        <select class="form-control select-field" name="pTipoPoliza" id="pTipoPoliza" onchange="changeFormTipoPoliza(this)" required></select>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4">
                                                        <label>Numero Poliza</label>
                                                        <input type="text" class="form-control" name="pNumeroPoliza" id="pNumeroPoliza" placeholder="Numero Poliza" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4">
                                                        <label>Aseguradora</label>
                                                        <select class="form-control select-field" name="pAseguradoraPoliza" id="pAseguradoraPoliza" required></select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row" id="containerFormTipoPoliza">
                                                </div>
                                                <div class="row" id="containerFormTipoPolizaCivilExtra">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="listaPolizasContrato" class="table table-striped" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>ASEGURADORA</th>
                                                            <th>TIPO POLIZA</th>
                                                            <th>NUMERO POLIZA</th>
                                                            <th>AMPARO</th>
                                                            <th>FECHA INICIO</th>
                                                            <th>FECHA FIN</th>
                                                            <th>VALOR ESTIMADO</th>
                                                            <th>VALOR AMPARO</th>
                                                            <th>DOCUMENTO</th>
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
                <div class="tab-pane fade" id="tab-contratos-otro-si" role="tabpanel" aria-labelledby="contratos-otro-si-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                        <form id="formCrearContratoOtroSi" name="formCrearContratoOtroSi" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                            <div class="card-header p-3 border-bottom border-300 bg-soft">
                                                <div class="row g-3 justify-content-between align-items-center">
                                                    <div class="col-12 col-md">
                                                        <h4 class="text-900 mb-0" data-anchor="data-anchor" id="basic-example">Crear Otro Si</h4>
                                                    </div>
                                                    <div class="col col-md-auto">
                                                        <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                                                            <button class="btn btn-outline-success me-1" type="submit" onclick="crearContratoOtroSi()"><i class="far fa-plus-square"></i> Crear Otro Si</button>
                                                        </nav>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-sm-12 col-md-3">
                                                        <label>Tipo Otro Si</label>
                                                        <select class="form-control select-field" name="cOSTipoOtroSi" id="cOSTipoOtroSi" onchange="changeFormTipoOtroSi(this)" required>
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="PRORROGA">PRORROGA (TIEMPO)</option>
                                                            <option value="ADICION">ADICION (VALOR)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label>Numero Otro Si</label>
                                                        <input type="text" class="form-control" name="cOSNumeroOtroSi" id="cOSNumeroOtroSi" placeholder="Numero Otro Si" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label>Fecha Otro Si</label>
                                                        <input type="date" class="form-control" name="cOSFechaOtroSi" id="cOSFechaOtroSi" placeholder="Fecha Otro Si" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label>Documento</label>
                                                        <input type="file" class="form-control" name="cOSDocumento" id="cOSDocumento" accept=".pdf" required>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row" id="containerFormTipoOtroSi">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="listaContratosOtroSiContrato" class="table table-striped" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>TIPO OTRO SI</th>
                                                            <th>NUMERO OTRO SI</th>
                                                            <th>FECHA OTRO SI</th>
                                                            <th>FECHA INICIO</th>
                                                            <th>FECHA FIN</th>
                                                            <th>VALOR ADICION</th>
                                                            <th>DOCUMENTO</th>
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
                <div class="tab-pane fade" id="tab-otros-documentos" role="tabpanel" aria-labelledby="otros-documentos-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                        <form id="formAgregarOtroDocumento" name="formAgregarOtroDocumento" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                            <div class="card-header p-3 border-bottom border-300 bg-soft">
                                                <div class="row g-3 justify-content-between align-items-center">
                                                    <div class="col-12 col-md">
                                                        <h4 class="text-900 mb-0" data-anchor="data-anchor" id="basic-example">Agregar Otro Documento</h4>
                                                    </div>
                                                    <div class="col col-md-auto">
                                                        <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                                                            <button class="btn btn-outline-success me-1" type="submit" onclick="agregarOtroDocumento()"><i class="far fa-plus-square"></i> Agregar Otro Documento</button>
                                                        </nav>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6">
                                                        <label>Tipo Documento</label>
                                                        <select class="form-control select-field" name="oDTipoDocumento" id="oDTipoDocumento" required></select>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <label>Documento</label>
                                                        <input type="file" class="form-control" name="oDarchivoDocumento" id="oDarchivoDocumento" accept=".pdf" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label>Observaciones</label>
                                                        <textarea class="form-control" name="oDObservaciones" id="oDObservaciones" rows="5" placeholder="Observaciones" minlength="10" maxlength="5000" required></textarea>
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
                                                <table id="listaOtrosDocumentosContrato" class="table table-striped" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>TIPO DOCUMENTO</th>
                                                            <th>DOCUMENTO</th>
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
            </div>
        </div>
    </div>
                    
</div>

<script src="views/js/contratacion/admincontrato-pagadores.js?v=<?= md5_file('views/js/contratacion/admincontrato-pagadores.js') ?>"></script>
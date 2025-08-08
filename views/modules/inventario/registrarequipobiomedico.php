<?php

$active = '';

if(isset($_GET["active"])){

    $active = $_GET["active"];

}else{

    $active = "new";

}

?>
<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-success">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Registrar Equipo Biomedico</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-underline" id="tabBiomedicoList" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="datos-equipo-tab" data-bs-toggle="tab" href="#datos-equipo" role="tab" aria-controls="datos-equipo" aria-selected="true">DATOS EQUIPO BIOMEDICO</a></li>
                        <?php if(isset($_GET["idEquipoBio"])): ?>
                            <li class="nav-item"><a class="nav-link" id="manuales-tab" data-bs-toggle="tab" href="#manuales" role="tab" aria-controls="manuales" aria-selected="false">MANUALES Y GUIAS</a></li>
                            <li class="nav-item"><a class="nav-link" id="planos-tab" data-bs-toggle="tab" href="#planos" role="tab" aria-controls="planos" aria-selected="false">PLANOS</a></li>
                            <li class="nav-item"><a class="nav-link" id="recomendaciones-fabricante-tab" data-bs-toggle="tab" href="#recomendaciones-fabricante" role="tab" aria-controls="recomendaciones-fabricante" aria-selected="false">RECOMENDACIONES FABRICANTE</a></li>
                            <li class="nav-item"><a class="nav-link" id="historico-equipo-tab" data-bs-toggle="tab" href="#historico-equipo" role="tab" aria-controls="historico-equipo" aria-selected="false">HISTORICO EQUIPO</a></li>
                            <li class="nav-item"><a class="nav-link" id="componentes-accesorios-tab" data-bs-toggle="tab" href="#componentes-accesorios" role="tab" aria-controls="componentes-accesorios" aria-selected="false">COMPONENTES Y/O ACCESORIOS</a></li>
                            <li class="nav-item"><a class="nav-link" id="mantenimientos-tab" data-bs-toggle="tab" href="#mantenimientos" role="tab" aria-controls="mantenimientos" aria-selected="false">TIPO MANTENIMIENTOS</a></li>
                            <li class="nav-item"><a class="nav-link" id="solicitudes-tab" data-bs-toggle="tab" href="#solicitudes" role="tab" aria-controls="solicitudes" aria-selected="false">SOLICITUDES</a></li>
                            <!-- <li class="nav-item"><a class="nav-link" id="historial-mantenimientos-tab" data-bs-toggle="tab" href="#historial-mantenimientos" role="tab" aria-controls="historial-mantenimientos" aria-selected="false">HISTORIAL MANTENIMIENTOS</a></li> -->
                        <?php endif ?>
                    </ul>
                    <div class="tab-content mt-3" id="tabContentBiomedico">
                        <!-- 
                            DATOS EQUIPO
                        -->
                        <div class="tab-pane fade show active" id="datos-equipo" role="tabpanel" aria-labelledby="datos-equipo-tab">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="col-auto mb-2">
                                                        <h4>ALERTAS</h4>
                                                    </div>
                                                    <div id="containerAlertas"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-9">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form id="formDatosEquipoBio" name="formDatosEquipoBio" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                        <div class="card-body">
                                                            
                                                            <div class="row align-items-end justify-content-between pb-5 g-3">
                                                                <div class="col-auto">
                                                                    <h4>DATOS GENERALES</h4>
                                                                </div>
                                                                <div class="col-12 col-md-auto">
                                                                    <div class="row g-2 gy-3">
                                                                        <div class="col-auto">
                                                                            <?php if(isset($_GET["idEquipoBio"])): ?>
                                                                                <a class="btn btn-outline-danger btn-sm" title="Ver Hoja Vida Equipo Biomedico" target="_blank" href="plugins/TCPDF/examples/inventario/hoja_vida_equipo_biomedico.php?idEquipoBiomedico=<?php echo $_GET["idEquipoBio"]; ?>"><i class="far fa-file-pdf"></i> Hoja Vida Equipo Biomedico</a>
                                                                            <?php endif ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Tipo Equipo <small class="text-danger">*</small></label>
                                                                    <input type="hidden" class="form-control" name="idEquipoBiomedico" id="idEquipoBiomedico" required>
                                                                    <select class="form-control select-field" name="dGTipoEquipo" id="dGTipoEquipo" required style="width: 100%;"></select>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Nombre Equipo <small class="text-danger">*</small></label>
                                                                    <input type="text" class="form-control" name="dGNombreEquipo" id="dGNombreEquipo" placeholder="Nombre Equipo" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Marca <small class="text-danger">*</small></label>
                                                                    <input type="text" class="form-control" name="dGMarca" id="dGMarca" placeholder="Marca" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Modelo <small class="text-danger">*</small></label>
                                                                    <input type="text" class="form-control" name="dGModelo" id="dGModelo" placeholder="Modelo" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Serie <small class="text-danger">*</small></label>
                                                                    <input type="text" class="form-control" name="dGSerie" id="dGSerie" placeholder="Serie" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Activo Fijo <small class="text-danger">*</small></label>
                                                                    <input type="text" class="form-control" name="dGActivoFijo" id="dGActivoFijo" placeholder="Activo Fijo" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Registro Sanitario Invima <small class="text-danger">*</small></label>
                                                                    <input type="text" class="form-control" name="dGRegistroSaniInvima" id="dGRegistroSaniInvima" placeholder="Registro Sanitario Invima" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Sede <small class="text-danger">*</small></label>
                                                                    <select class="form-control select-field" name="dGSede" id="dGSede" required style="width: 100%;"></select>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Ubicacion <small class="text-danger">*</small></label>
                                                                    <input type="text" class="form-control" name="dGUbicacion" id="dGUbicacion" placeholder="Ubicacion" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Servicio <small class="text-danger">*</small></label>
                                                                    <select class="form-control select-field" name="dGServicio" id="dGServicio" required style="width: 100%;"></select>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Clasificacion Biomedica <small class="text-danger">*</small></label>
                                                                    <select class="form-control select-field" name="dGClasificacionBio" id="dGClasificacionBio" required style="width: 100%;"></select>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Clasificacion Riesgo <small class="text-danger">*</small></label>
                                                                    <select class="form-control select-field" name="dGClasificacionRiesgo" id="dGClasificacionRiesgo" required style="width: 100%;"></select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <hr>
                                                            <br>
                                                            <h4 class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
                                                                <div>
                                                                    DATOS TECNICOS
                                                                </div>
                                                            </h4>
                                                            <div class="row mb-2">
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Tecnologia Predominante <small class="text-danger">*</small></label>
                                                                    <select class="form-control select-field" name="dTTecnologiaPredo" id="dTTecnologiaPredo" required style="width: 100%;"></select>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Fuente Alimentacion <small class="text-danger">*</small></label>
                                                                    <select class="form-control select-field" name="dTFuenteAlimen" id="dTFuenteAlimen" required style="width: 100%;"></select>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Caracteristicas Instalacion <small class="text-danger">*</small></label>
                                                                    <select class="form-control select-field" name="dTCaracteristicasInsta" id="dTCaracteristicasInsta" required style="width: 100%;"></select>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Tension Trabajo <small class="text-danger">*</small></label>
                                                                    <input type="text" class="form-control" name="dTTensionTrabajo" id="dTTensionTrabajo" placeholder="Tension Trabajo" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Consumo Watt <small class="text-danger">*</small></label>
                                                                    <input type="number" class="form-control" name="dTConsumoWatt" id="dTConsumoWatt" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2">
                                                                    <label>Peso (KG) <small class="text-danger">*</small></label>
                                                                    <input type="number" class="form-control" name="dTPeso" id="dTPeso" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-sm-12 col-md-4">
                                                                    <label>Condiciones Ambientales <small class="text-danger">*</small></label>
                                                                    <textarea class="form-control" rows="3" name="dtCondicionesAmbien" id="dtCondicionesAmbien" minlength="5" maxlength="2000" placeholder="Condiciones Ambientales" required></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <center><button type="submit" class="btn btn-outline-success me-1 mb-3" onclick="guardarDatosEquipoBiomedico()"><i class="far fa-save"></i> Guardar</button></center>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                </div>
                            </div>
                        </div>
                        <!-- 
                            MANUALES
                        -->
                        <div class="tab-pane fade" id="manuales" role="tabpanel" aria-labelledby="manuales-tab">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="table-responsive">
                                                        <table id="tableEquipoBiomedicoManual" class="table table-striped" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Tipo Manual</th>
                                                                    <th>Nombre Manual</th>
                                                                    <th>Manual</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="card">
                                                        <div class="card-header p-3 border-bottom border-300 bg-success">
                                                            <div class="row g-3 justify-content-between align-items-center">
                                                                <div class="col-12 col-md">
                                                                    <h5 class="text-white mb-0">Agregar Manual</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <form id="formManualBiomedico" name="formManualBiomedico" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-12 col-md-6">
                                                                        <label>Nombre Manual <small class="text-danger">*</small></label>
                                                                        <input type="text" class="form-control" name="mNombreManual" id="mNombreManual" placeholder="Nombre Manual" minlength="5" maxlength="250" required>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-6">
                                                                        <label>Tipo Manual <small class="text-danger">*</small></label>
                                                                        <select class="form-control select-field" name="mTipoManual" id="mTipoManual" required style="width: 100%;">
                                                                            <option value="">Seleccione una opcion</option>
                                                                            <option value="GUIA RAPIDA DE USO">GUIA RAPIDA DE USO</option>
                                                                            <option value="OPERACION">OPERACION</option>
                                                                            <option value="FUNCIONAMIENTO">FUNCIONAMIENTO</option>
                                                                            <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                                                                            <option value="PARTES">PARTES</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <label>Archivo <small class="text-danger">*</small></label>
                                                                        <input type="file" class="form-control" name="mArchivoManual" id="mArchivoManual" accept=".pdf" required>
                                                                    </div>
                                                                </div>
                                                                <center><button type="submit" class="btn btn-outline-success me-1" onclick="crearManualBiomedico()"><i class="far fa-save"></i> Guardar</button></center>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 
                            PLANOS
                        -->
                        <div class="tab-pane fade" id="planos" role="tabpanel" aria-labelledby="planos-tab">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="table-responsive">
                                                        <table id="tableEquipoBiomedicoPlanos" class="table table-striped" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Tipo Plano</th>
                                                                    <th>Nombre Plano</th>
                                                                    <th>Plano</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="card">
                                                        <div class="card-header p-3 border-bottom border-300 bg-success">
                                                            <div class="row g-3 justify-content-between align-items-center">
                                                                <div class="col-12 col-md">
                                                                    <h5 class="text-white mb-0">Agregar Plano</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <form id="formPlanoBiomedico" name="formPlanoBiomedico" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-12 col-md-6">
                                                                        <label>Nombre Plano <small class="text-danger">*</small></label>
                                                                        <input type="text" class="form-control" name="pNombrePlano" id="pNombrePlano" placeholder="Nombre Plano" minlength="5" maxlength="250" required>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-6">
                                                                        <label>Tipo Plano <small class="text-danger">*</small></label>
                                                                        <select class="form-control select-field" name="pTipoPlano" id="pTipoPlano" required style="width: 100%;">
                                                                            <option value="">Seleccione una opcion</option>
                                                                            <option value="ELECTRONICO">ELECTRONICO</option>
                                                                            <option value="ELECTRICOS">ELECTRICOS</option>
                                                                            <option value="NEUMATICOS">NEUMATICOS</option>
                                                                            <option value="MECANICOS">MECANICOS</option>
                                                                            <option value="HIDRAULICOS">HIDRAULICOS</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <label>Archivo <small class="text-danger">*</small></label>
                                                                        <input type="file" class="form-control" name="pArchivoPlano" id="pArchivoPlano" accept=".pdf" required>
                                                                    </div>
                                                                </div>
                                                                <center><button type="submit" class="btn btn-outline-success me-1" onclick="crearPlanoBiomedico()"><i class="far fa-save"></i> Guardar</button></center>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 
                            RECOMENDACION FABRICANTE
                        -->
                        <div class="tab-pane fade" id="recomendaciones-fabricante" role="tabpanel" aria-labelledby="recomendaciones-fabricante-tab">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="table-responsive">
                                                        <table id="tableEquipoBiomedicoRecomendaciones" class="table table-striped" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Recomendacion</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="card">
                                                        <div class="card-header p-3 border-bottom border-300 bg-success">
                                                            <div class="row g-3 justify-content-between align-items-center">
                                                                <div class="col-12 col-md">
                                                                    <h5 class="text-white mb-0">Agregar Recomendacion</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <form id="formRecomendacionFabri" name="formRecomendacionFabri" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <label>Recomendacion <small class="text-danger">*</small></label>
                                                                        <textarea class="form-control" name="rFRecomendacion" id="rFRecomendacion" placeholder="Recomendacion" minlength="5" maxlength="10000" rows="5" required></textarea>
                                                                    </div>
                                                                </div>
                                                                <center><button type="submit" class="btn btn-outline-success me-1" onclick="crearRecomendacionBiomedico()"><i class="far fa-save"></i> Guardar</button></center>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 
                            HISTORICO EQUIPO
                        -->
                        <div class="tab-pane fade" id="historico-equipo" role="tabpanel" aria-labelledby="historico-equipo-tab">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-header p-3 border-bottom border-300 bg-success">
                                            <div class="row g-3 justify-content-between align-items-center">
                                                <div class="col-12 col-md">
                                                    <h5 class="text-white mb-0">Historico Equipo</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form id="formHistoricoEquipo" name="formHistoricoEquipo" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                <div class="row mb-4">
                                                    <div class="col-sm-12 col-md-2">
                                                        <label>Numero Factura <small class="text-danger">*</small></label>
                                                        <input type="text" class="form-control" name="hENumeroFactura" id="hENumeroFactura" placeholder="Numero Factura" minlength="5" maxlength="50" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-2">
                                                        <label>Forma Adquisicion <small class="text-danger">*</small></label>
                                                        <input type="text" class="form-control" name="hEFormaAdqui" id="hEFormaAdqui" placeholder="Forma Adquisicion" minlength="5" maxlength="150" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-2">
                                                        <label>Vida Util Equipo (Años) <small class="text-danger">*</small></label>
                                                        <input type="number" class="form-control" name="hEVidaUtilEquipo" id="hEVidaUtilEquipo" placeholder="Vida Util Equipo" minlength="5" maxlength="50" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-2">
                                                        <label>Valor Iva Incluido <small class="text-danger">*</small></label>
                                                        <input type="number" class="form-control" name="hEValorIvaIncluido" id="hEValorIvaIncluido" min="0" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-2">
                                                        <label>Valor Depreciacion <small class="text-danger">*</small></label>
                                                        <input type="number" class="form-control readonly" name="hEValorDepreciacion" id="hEValorDepreciacion" min="0" readonly>
                                                    </div>
                                                    <div class="col-sm-12 col-md-2">
                                                        <label>Valor Depreciacion Anual <small class="text-danger">*</small></label>
                                                        <input type="number" class="form-control readonly" name="hEValorDepreciacionAnual" id="hEValorDepreciacionAnual" min="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 mb-4">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="card">
                                                                <div class="card-header p-3 border-bottom border-300 bg-primary">
                                                                    <div class="row g-3 justify-content-between align-items-center">
                                                                        <div class="col-12 col-md">
                                                                            <h5 class="text-white mb-0">Fechas</h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row mb-2">
                                                                        <div class="col-sm-12 col-md-4">
                                                                            <label>Compra <small class="text-danger">*</small></label>
                                                                            <input type="date" class="form-control" name="hECompra" id="hECompra" placeholder="Compra" required>
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-4">
                                                                            <label>Instalacion <small class="text-danger">*</small></label>
                                                                            <input type="date" class="form-control" name="hEInstalacion" id="hEInstalacion" placeholder="Instalacion" required>
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-4">
                                                                            <label>Recibido <small class="text-danger">*</small></label>
                                                                            <input type="date" class="form-control" name="hERecibido" id="hERecibido" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <div class="col-sm-12 col-md-4">
                                                                            <label>Fecha Inicio Garantia <small class="text-danger">*</small></label>
                                                                            <input type="date" class="form-control" name="hEFechaIniGarantia" id="hEFechaIniGarantia" onchange="changeFechaGarantia(this)" required>
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-4">
                                                                            <label>Fecha Fin Garantia <small class="text-danger">*</small></label>
                                                                            <input type="date" class="form-control" name="hEFechaFinGarantia" id="hEFechaFinGarantia" onblur="changeFechaGarantia(this)" required>
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-4">
                                                                            <label>Garantia (Dias)</label>
                                                                            <input type="number" class="form-control readonly" readonly name="hEGarantiaAnios" id="hEGarantiaAnios">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="card">
                                                                <div class="card-header p-3 border-bottom border-300 bg-primary">
                                                                    <div class="row g-3 justify-content-between align-items-center">
                                                                        <div class="col-12 col-md">
                                                                            <h5 class="text-white mb-0">Datos Comerciales</h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row mb-2">
                                                                        <div class="col-sm-12 col-md-3">
                                                                            <label>Fabricante</label>
                                                                            <input type="text" class="form-control" name="hEFabricante" id="hEFabricante" placeholder="Fabricante" minlength="5" maxlength="150">
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-3">
                                                                            <label>Nombre Contacto</label>
                                                                            <input type="text" class="form-control" name="hENombreContacto" id="hENombreContacto" placeholder="Nombre Contacto" minlength="5" maxlength="150">
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-3">
                                                                            <label>Representante</label>
                                                                            <input type="text" class="form-control" name="hERepresentante" id="hERepresentante" placeholder="Representante" minlength="5" maxlength="150">
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-3">
                                                                            <label>Telefono</label>
                                                                            <input type="number" class="form-control" name="hETelefono" id="hETelefono" placeholder="Telefono">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <div class="col-sm-12 col-md-3">
                                                                            <label>Correo Electronico</label>
                                                                            <input type="email" class="form-control" name="hECorreoElectronico" id="hECorreoElectronico" placeholder="Correo Electronico" minlength="5" maxlength="150">
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-3">
                                                                            <label>Cargo o Puesto</label>
                                                                            <input type="text" class="form-control" name="hECargoPuesto" id="hECargoPuesto" placeholder="Cargo o Puesto" minlength="5" maxlength="150">
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-3">
                                                                            <label>Proveedor</label>
                                                                            <input type="text" class="form-control" name="hEProveedor" id="hEProveedor" placeholder="Proveedor" minlength="5" maxlength="150">
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-3">
                                                                            <label>Celular</label>
                                                                            <input type="number" class="form-control" name="hECelular" id="hECelular" placeholder="Celular">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <center><button type="submit" class="btn btn-outline-success me-1" onclick="guardarHistoricoEquipo()"><i class="far fa-save"></i> Guardar</button></center>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 
                            COMPONENTES ACCESORIOS
                        -->
                        <div class="tab-pane fade" id="componentes-accesorios" role="tabpanel" aria-labelledby="componentes-accesorios-tab">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="table-responsive">
                                                        <table id="tableEquipoBiomedicoComponentesAccesorios" class="table table-striped" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Componente y/o Accesorio</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="card">
                                                        <div class="card-header p-3 border-bottom border-300 bg-success">
                                                            <div class="row g-3 justify-content-between align-items-center">
                                                                <div class="col-12 col-md">
                                                                    <h5 class="text-white mb-0">Agregar Componente y/o Accesorio</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <form id="formComponenAccesorios" name="formComponenAccesorios" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-12 col-md-10">
                                                                        <label>Componente y/o Caracteristica <small class="text-danger">*</small></label>
                                                                        <textarea class="form-control" name="cAECompoCaracte" id="cAECompoCaracte" placeholder="Componente y/o Caracteristica" minlength="5" maxlength="10000" rows="3" required></textarea>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-2">
                                                                        <label>Cantidad <small class="text-danger">*</small></label>
                                                                        <input type="number" class="form-control" name="cAECantidad" id="cAECantidad" min="0" placeholder="0" required>
                                                                    </div>
                                                                </div>
                                                                <center><button type="submit" class="btn btn-outline-success me-1" onclick="crearComponenteCaracteristica()"><i class="far fa-save"></i> Guardar</button></center>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 
                            MANTENIMIENTOS
                        -->
                        <div class="tab-pane fade" id="mantenimientos" role="tabpanel" aria-labelledby="mantenimientos-tab">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form id="formTipoManteEquipoBio" name="formTipoManteEquipoBio" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                                            <h4 class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
                                                                <div>
                                                                    AGREGAR TIPO MANTENIMIENTO
                                                                </div>
                                                            </h4>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6">
                                                                    <label>Tipo Mantenimiento <small class="text-danger">*</small></label>
                                                                    <select class="form-control" name="tMTipoMantenimientoEquipo" id="tMTipoMantenimientoEquipo" required style="width: 100%;"></select>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6">
                                                                    <label>Frecuencia <small class="text-danger">*</small></label>
                                                                    <select class="form-control" name="tmFrecuencia" id="tmFrecuencia" required style="width: 100%;">
                                                                        <option value="">Seleccione una opcion</option>
                                                                        <option value="TRIMESTRAL">TRIMESTRAL</option>
                                                                        <option value="CUATRIMESTRAL">CUATRIMESTRAL</option>
                                                                        <option value="SEMESTRAL">SEMESTRAL</option>
                                                                        <option value="ANUAL">ANUAL</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <center><button type="submit" class="btn btn-outline-success me-1 mb-3" onclick="agregarTipoMantenimiento()"><i class="far fa-save"></i> Guardar</button></center>
                                                        <hr>
                                                        <div class="col-sm-12 col-md-6 col-lg-12 mt-2">
                                                            <div class="table-responsive">
                                                                <table id="tablaListaTiposMantenimientos" class="table table-striped" style="width:100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Tipo Mantenimiento</th>
                                                                            <th>Fecruencia</th>
                                                                            <th>Acciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form id="formManteEquipoBio" name="formManteEquipoBio" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                                            <h4 class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
                                                                <div>
                                                                    AGREGAR MANTENIMIENTO
                                                                </div>
                                                            </h4>
                                                            <div class="row mb-2">
                                                                <div class="col-sm-12 col-md-6">
                                                                    <label>Tipo Mantenimiento <small class="text-danger">*</small></label>
                                                                    <select class="form-control" name="tMTipoMantenimiento" id="tMTipoMantenimiento" required style="width: 100%;"></select>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6">
                                                                    <label>Fecha Mantenimiento <small class="text-danger">*</small></label>
                                                                    <input type="date" class="form-control" name="tmFechaMantenimiento" id="tmFechaMantenimiento" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-sm-12 col-md-12">
                                                                    <label>Observacion Mantenimiento <small class="text-danger">*</small></label>
                                                                    <textarea class="form-control" name="tmObservacionMantenimiento" id="tmObservacionMantenimiento" minlength="5" maxlength="2500" rows="5" required placeholder="Observaciones Mantenimiento"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-sm-12 col-md-12">
                                                                    <label>Archivo</label>
                                                                    <input type="file" class="form-control" id="tMArchivoMantenimiento" name="tMArchivoMantenimiento" accept=".pdf">
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <center><button type="submit" class="btn btn-outline-success me-1 mb-3" onclick="agregarMantenimiento()"><i class="far fa-save"></i> Guardar</button></center>
                                                        <hr>
                                                        <div class="col-sm-12 col-md-6 col-lg-12 mt-2">
                                                            <div class="table-responsive">
                                                                <table id="tableListaMantenimentosBiomedicos" class="table table-striped" style="width:100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Tipo Mantenimiento</th>
                                                                            <th>Fecha Mantenimiento</th>
                                                                            <th>Archivo Mantenimiento</th>
                                                                            <th>Observaciones Mantenimiento</th>
                                                                            <th>Acciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        <!-- 
                            SOLICITUDES
                        -->
                        <div class="tab-pane fade" id="solicitudes" role="tabpanel" aria-labelledby="solicitudes-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h4 class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
                                            <div>
                                                SOLICITUDES
                                            </div>
                                        </h4>
                                        <div class="col-sm-12 col-md-12 mb-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="d-grid gap-2">
                                                                <a class="btn btn-phoenix-success mt-2 mb-2" data-bs-toggle="collapse" href="#SolicitudTrasladoEquipoBiomedico" role="button" aria-expanded="false" aria-controls="SolicitudTrasladoEquipoBiomedico"><i class="fas fa-truck-moving"></i> Traslado Equipo Biomedico</a>
                                                                <div class="collapse" id="SolicitudTrasladoEquipoBiomedico">
                                                                    <div class="border p-3 rounded">
                                                                        <form id="formSolicitudTrasladoEquipoBiomedico" name="formSolicitudTrasladoEquipoBiomedico" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                                            <h4 class="text-center text-success">TRASLADO EQUIPO BIOMEDICO</h4>
                                                                            <div class="row mb-2">
                                                                                <div class="col-sm-12 col-md-12 mb-2">
                                                                                    <label>Tiempo Estimado Salida <small class="text-danger">*</small></label>
                                                                                    <select class="form-control" name="sEBTiempoEstimadoSalida" id="sEBTiempoEstimadoSalida" required style="width: 100%;">
                                                                                        <option value="">Seleccione una opcion</option>
                                                                                        <option value="TEMPORAL">TEMPORAL</option>
                                                                                        <option value="PERMANENTE">PERMANENTE</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12 mb-2">
                                                                                    <label>Motivo Salida <small class="text-danger">*</small></label>
                                                                                    <textarea class="form-control" name="sEBMotivoSalida" id="sEBMotivoSalida" rows="5" minlength="10" maxlength="5000" placeholder="Motivo Salida" required></textarea>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12 mb-2">
                                                                                    <label>Observaciones</label>
                                                                                    <textarea class="form-control" name="sEBObservaciones" id="sEBObservaciones" rows="5" minlength="10" maxlength="5000" placeholder="Observaciones"></textarea>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-4 mb-2">
                                                                                    <label>Sede <small class="text-danger">*</small></label>
                                                                                    <select class="form-control select-field" name="sEBSede" id="sEBSede" required style="width: 100%;"></select>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-4 mb-2">
                                                                                    <label>Activo Fijo <small class="text-danger">*</small></label>
                                                                                    <input type="text" class="form-control" name="sEBActivoFijo" id="sEBActivoFijo" placeholder="Activo Fijo" required>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-4 mb-2">
                                                                                    <label>Ubicacion <small class="text-danger">*</small></label>
                                                                                    <input type="text" class="form-control" name="sEBUbicacion" id="sEBUbicacion" placeholder="Ubicacion" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-2">
                                                                                <div class="col-sm-12 col-md-12 mb-2">
                                                                                    <label>Recibido Por <small class="text-danger">*</small></label>
                                                                                    <input type="text" class="form-control" name="sEBRecibidoPor" id="sEBRecibidoPor" placeholder="Recibido Por" minlength="5" maxlength="150" required>
                                                                                </div>
                                                                            </div>
                                                                            <center><button type="submit" class="btn btn-outline-success me-1" onclick="agregarSolicitudTrasladoEquipoBio()"><i class="far fa-save"></i> Guardar</button></center>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <h3 class="text-success">Lista Traslados</h3>
                                                            <hr>
                                                            <div class="table-responsive">
                                                                <table id="tableListaSolicitudesTrasladoEquipoBio" class="table table-striped" style="width:100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Tiempo Estimado Salida</th>
                                                                            <th>Sede</th>
                                                                            <th>Activo Fijo</th>
                                                                            <th>Ubicacion</th>
                                                                            <th>Recibido Por</th>
                                                                            <th>Acciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 mb-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="d-grid gap-2">
                                                                <a class="btn btn-phoenix-primary mt-2 mb-2" data-bs-toggle="collapse" href="#SolicitudMantenimientoEquipoBiomedico" role="button" aria-expanded="false" aria-controls="SolicitudMantenimientoEquipoBiomedico"><i class="fas fa-tools"></i> Mantenimiento Equipo Biomedico</a>
                                                                <div class="collapse" id="SolicitudMantenimientoEquipoBiomedico">
                                                                    <div class="border p-3 rounded">
                                                                    <form id="formSolicitudMantenimientoEquipoBiomedico" name="formSolicitudMantenimientoEquipoBiomedico" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                                            <h4 class="text-center text-primary">SOLICITUD MANTENIMIENTO CORRECTIVO</h4>
                                                                            <div class="row mb-2">
                                                                                <div class="col-sm-12 col-md-6 mb-2">
                                                                                    <label>Orden No. <small class="text-danger">*</small></label>
                                                                                    <input type="text" class="form-control" name="sMCEBOrdenNo" id="sMCEBOrdenNo" minlength="2" maxlength="30" placeholder="Orden No" required>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6 mb-2">
                                                                                    <label>Cargo <small class="text-danger">*</small></label>
                                                                                    <input type="text" class="form-control" name="sMCEBCargo" id="sMCEBCargo" minlength="2" maxlength="150" placeholder="Cargo" required>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12 mb-2">
                                                                                    <label>Descripcion Incidencia <small class="text-danger">*</small></label>
                                                                                    <textarea class="form-control" name="sMCEBDescripcionIncidencia" id="sMCEBDescripcionIncidencia" rows="5" minlength="10" maxlength="5000" placeholder="Descripcion Incidencia" required></textarea>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-4 mb-2">
                                                                                    <label>Fecha Ejecucion <small class="text-danger">*</small></label>
                                                                                    <input type="datetime-local" class="form-control" name="sMCEBFechaEjecucion" id="sMCEBFechaEjecucion" placeholder="Fecha Ejecucion" required>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-4 mb-2">
                                                                                    <label>Responsable <small class="text-danger">*</small></label>
                                                                                    <input type="text" class="form-control" name="sMCEBResponsable" id="sMCEBResponsable" minlength="10" maxlength="150" placeholder="Responsable" required>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-4 mb-2">
                                                                                    <label>Requiere Repuesto <small class="text-danger">*</small></label>
                                                                                    <select class="form-control" name="sMCEBRequiereRepuesto" id="sMCEBRequiereRepuesto" required>
                                                                                        <option value="">Seleccione una opcion</option>
                                                                                        <option value="SI">SI</option>
                                                                                        <option value="NO">NO</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12 mb-2">
                                                                                    <label>Descripcion Falla <small class="text-danger">*</small></label>
                                                                                    <textarea class="form-control" name="sMCEBDescripcionFalla" id="sMCEBDescripcionFalla" rows="5" minlength="10" maxlength="5000" placeholder="Descripcion Falla" required></textarea>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12 mb-2">
                                                                                    <label>Respuestos Necesarios</label>
                                                                                    <textarea class="form-control" name="sMCEBRepuestosNecesarios" id="sMCEBRepuestosNecesarios" rows="5" minlength="10" maxlength="5000" placeholder="Repuestos Necesarios"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <center><button type="submit" class="btn btn-outline-success me-1" onclick="agregarSolicitudMantenimientoCorrectivoEquipoBio()"><i class="far fa-save"></i> Guardar</button></center>
                                                                        </form>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <h3 class="text-primary">Lista Mantenimientos Correctivos</h3>
                                                            <hr>
                                                            <div class="table-responsive">
                                                                <table id="tableListaSolicitudesMantenimientosEquipoBio" class="table table-striped" style="width:100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Orden No.</th>
                                                                            <th>Cargo</th>
                                                                            <th>Fecha Ejecucion</th>
                                                                            <th>Responsable</th>
                                                                            <th>Estado</th>
                                                                            <th>Acciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 mb-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="d-grid gap-2">
                                                                <a class="btn btn-phoenix-danger mt-2 mb-2" data-bs-toggle="collapse" href="#SolicitudAcataBajaEquipoBiomedico" role="button" aria-expanded="false" aria-controls="SolicitudAcataBajaEquipoBiomedico"><i class="far fa-arrow-alt-circle-down"></i> Acta Baja Equipo Biomedico</a>
                                                                <div class="collapse" id="SolicitudAcataBajaEquipoBiomedico">
                                                                    <div class="border p-3 rounded">
                                                                        <form id="formSolicitudBajaEquipoBiomedico" name="formSolicitudBajaEquipoBiomedico" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                                            <h4 class="text-center text-danger">SOLICITUD ACTA BAJA EQUIPO BIOMEDICO</h4>
                                                                            <div class="row mb-2">
                                                                                <div class="col-sm-12 col-md-6 mb-2">
                                                                                    <label>Nombre Solicitante <small class="text-danger">*</small></label>
                                                                                    <input type="text" class="form-control" name="sABEBNombreSolicitante" id="sABEBNombreSolicitante" minlength="2" maxlength="100" placeholder="Nombre Solicitante" required>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6 mb-2">
                                                                                    <label>Cargo <small class="text-danger">*</small></label>
                                                                                    <input type="text" class="form-control" name="sABEBCargo" id="sABEBCargo" minlength="2" maxlength="150" placeholder="Cargo" required>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12 mb-2">
                                                                                    <label>Concepto Tecnico Dar Baja <small class="text-danger">*</small></label>
                                                                                    <textarea class="form-control" name="sABEBConceptoDarBaja" id="sABEBConceptoDarBaja" rows="5" minlength="10" maxlength="5000" placeholder="Concepto Tecnico" required></textarea>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6 mb-2">
                                                                                    <label>Reciclaje <small class="text-danger">*</small></label>
                                                                                    <select class="form-control" name="sABEBReciclaje" id="sABEBReciclaje" required>
                                                                                        <option value="">Seleccione una opcion</option>
                                                                                        <option value="SI">SI</option>
                                                                                        <option value="NO">NO</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6 mb-2">
                                                                                    <label>Empresa Responsable <small class="text-danger">*</small></label>
                                                                                    <input type="text" class="form-control" name="sABEBEmpresaResponsableRe" id="sABEBEmpresaResponsableRe" minlength="2" maxlength="150" placeholder="Empresa Responsable" required>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6 mb-2">
                                                                                    <label>Disposicion Final <small class="text-danger">*</small></label>
                                                                                    <select class="form-control" name="sABEBDisposicionFinal" id="sABEBDisposicionFinal" required>
                                                                                        <option value="">Seleccione una opcion</option>
                                                                                        <option value="SI">SI</option>
                                                                                        <option value="NO">NO</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6 mb-2">
                                                                                    <label>Empresa Responsable <small class="text-danger">*</small></label>
                                                                                    <input type="text" class="form-control" name="sABEBEmpresaResponsableDis" id="sABEBEmpresaResponsableDis" minlength="2" maxlength="150" placeholder="Empresa Responsable" required>
                                                                                </div>
                                                                            </div>
                                                                            <center><button type="submit" class="btn btn-outline-success me-1" onclick="agregarSolicitudBajaEquipoBio()"><i class="far fa-save"></i> Guardar</button></center>
                                                                        </form>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <h3 class="text-danger">Lista Actas Baja de Equipo</h3>
                                                            <hr>
                                                            <div class="table-responsive">
                                                                <table id="tableListaSolicitudesActaBajaEquipoBio" class="table table-striped" style="width:100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Nombre Solicitante</th>
                                                                            <th>Cargo</th>
                                                                            <th>Reciclaje</th>
                                                                            <th>Empresa R. Reciclaje</th>
                                                                            <th>Disposicion</th>
                                                                            <th>Empresa R. Disposicion</th>
                                                                            <th>Acciones</th>
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
                        <!-- 
                            HISTORIAL MANTENIMIENTO
                        -->
                        <!-- <div class="tab-pane fade" id="historial-mantenimientos" role="tabpanel" aria-labelledby="historial-mantenimientos-tab">Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork.</div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVerComponenteAccesorioBiomedico" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ver Componente y/o Accesorio</h5>
            <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <label class="font-bold">Componente y/o Accesorio</label>
                    <div id="txtComponenteAccesorio"></div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <label class="font-bold">Cantidad</label>
                    <div id="txtCantidadCompoAcceso"></div>
                </div>
            </div>
        </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVerRecomendacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ver Recomendacion Fabricante</h5>
            <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <label class="font-bold">Recomendacion Fabricante</label>
                    <div id="txtRecomendacionFabricante"></div>
                </div>
            </div>
        </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVerMantenimientoCorrectivo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ver Mantenimiento Correctivo</h5>
            <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
        </div>
        <div class="modal-body">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12 d-grid">
                    <a class="btn btn-outline-success mt-2" data-bs-toggle="collapse" href="#collapseInfoSolicitud" role="button" aria-expanded="false" aria-controls="collapseInfoSolicitud">Informacion Solicitud Mantenimiento</a>
                    <div class="collapse mt-2" id="collapseInfoSolicitud">
                        <div class="border p-3 rounded">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <label>Orden No. <small class="text-danger">*</small></label>
                                    <div id="txtSoliOrdenNo"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <label>Cargo <small class="text-danger">*</small></label>
                                    <div id="txtSoliCargo"></div>
                                </div>
                                <div class="col-sm-12 col-md-12 mb-2">
                                    <label>Descripcion Incidencia <small class="text-danger">*</small></label>
                                    <div id="txtSoliDescripcionIncidencia"></div>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <label>Fecha Ejecucion <small class="text-danger">*</small></label>
                                    <div id="txtSoliFechaEjecucion"></div>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <label>Responsable <small class="text-danger">*</small></label>
                                    <div id="txtSoliResponsable"></div>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <label>Requiere Repuesto <small class="text-danger">*</small></label>
                                    <div id="txtSoliRequiereRespuesto"></div>
                                </div>
                                <div class="col-sm-12 col-md-12 mb-2">
                                    <label>Descripcion Falla</label>
                                    <div id="txtSoliDescripcionFalla"></div>
                                </div>
                                <div class="col-sm-12 col-md-12 mb-2">
                                    <label>Respuestos Necesarios</label>
                                    <div id="txtSoliRespuestosNecesarios"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <div class="accordion" id="accordionMantePreventivos">
                        <div class="accordion-item border-top border-300">
                            <h2 class="accordion-header" id="headingMantePreventivos">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMantePreventivos" aria-expanded="false" aria-controls="collapseMantePreventivos">
                                    Mantenimientos Preventivos
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapseMantePreventivos" aria-labelledby="headingMantePreventivos" data-bs-parent="#accordionMantePreventivos">
                                <div class="accordion-body pt-4">
                                    <div id="contenedorCheckPreventivos"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="accordion" id="accordionManteCorrectivos">
                        <div class="accordion-item border-top border-300">
                            <h2 class="accordion-header" id="headingManteCorrectivos">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseManteCorrectivos" aria-expanded="false" aria-controls="collapseManteCorrectivos">
                                    Mantenimientos Correctivos
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapseManteCorrectivos" aria-labelledby="headingManteCorrectivos" data-bs-parent="#accordionManteCorrectivos">
                                <div class="accordion-body pt-4">
                                    <div id="contenedorCheckCorrectivos"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12 mb-2">
                    <label>Observaciones Mantenimiento <small class="text-danger">*</small></label>
                    <div id="txtVerObservacionMantenimiento"></div>
                </div>
            </div>
        </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="views/js/inventario/inventario-biomedico.js?v=<?= md5_file('views/js/inventario/inventario-biomedico.js') ?>"></script>
<?php if($active == 'new'): ?>
<script src="views/js/inventario/parametricas-biomedicos.js?v=<?= md5_file('views/js/inventario/parametricas-biomedicos.js') ?>"></script>
<?php endif ?>
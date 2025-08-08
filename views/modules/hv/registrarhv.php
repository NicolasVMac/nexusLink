<?php

$active = '';

if(isset($_GET["active"])){

    $active = $_GET["active"];

}else{

    $active = "new";

}

?>

<div class="content">
    <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
        <div class="card-header bg-100 pt-3 pb-2 border-bottom-0">
            <ul class="nav justify-content-between nav-wizard" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?php if($active == 'datos-personales'){ echo 'active'; } ?> fw-semi-bold" href="#datos-personales" data-bs-toggle="tab" data-wizard-step="1" aria-selected="true" role="tab">
                        <div class="text-center d-inline-block">
                            <span class="nav-item-circle-parent">
                                <span class="nav-item-circle">
                                    <i class="far fa-user"></i>
                                </span>
                            </span>
                            <span class="d-none d-md-block mt-1 fs--1">Datos</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?php if($active == 'estudios'){ echo 'active'; }else if($active == 'new'){ echo 'disabled'; } ?> fw-semi-bold" href="#estudios" data-bs-toggle="tab" data-wizard-step="2" aria-selected="false" tabindex="-1" role="tab">
                        <div class="text-center d-inline-block">
                            <span class="nav-item-circle-parent">
                                <span class="nav-item-circle">
                                    <i class="fas fa-book"></i>
                                </span>
                            </span>
                            <span class="d-none d-md-block mt-1 fs--1">Estudios</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?php if($active == 'experiencias'){ echo 'active'; }else if($active == 'new'){ echo 'disabled'; } ?> fw-semi-bold" href="#experiencias" data-bs-toggle="tab" data-wizard-step="4" aria-selected="false" tabindex="-1" role="tab">
                        <div class="text-center d-inline-block">
                            <span class="nav-item-circle-parent">
                                <span class="nav-item-circle">
                                    <i class="fas fa-hammer"></i>
                                </span>
                            </span>
                            <span class="d-none d-md-block mt-1 fs--1">Experiencias L.</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body pt-4">
            <div class="tab-content">
                <div class="tab-pane <?php if($active == 'datos-personales' || $active == 'new'){ echo 'active'; } ?>" role="tabpanel" aria-labelledby="datos-personales" id="datos-personales">
                    <form id="formDatosPersonales" name="formDatosPersonales" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Tipo Documento <b class="text-danger">*</b></label>
                                <select class="form-control select-field" name="tipoDocumentoDp" id="tipoDocumentoDp" onchange="validarExistePersona()" required style="width: 100%;"></select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Numero Documento <b class="text-danger">*</b></label>
                                <input type="number" class="form-control" name="numeroDocumentoDp" id="numeroDocumentoDp" onchange="validarExistePersona()" required>
                                <input type="hidden" class="form-control" name="idHV" id="idHV" required>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="text-900">Nombre Completo <b class="text-danger">*</b></label>
                                <input class="form-control" type="text" name="nombreCompletoDp" id="nombreCompletoDp" placeholder="Nombre Completo" minlength="5" maxlength="150" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Fecha Nacimiento <b class="text-danger">*</b></label>
                                <input type="date" class="form-control" name="fechaNacimientoDp" id="fechaNacimientoDp" max="<?php echo $hoy; ?>" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Nacionalidad <b class="text-danger">*</b></label>
                                <select class="form-control select-field" name="nacionalidadDp" id="nacionalidadDp" required style="width: 100%;"></select>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="text-900">Profesion <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" name="profesionDp" id="profesionDp" placeholder="Profesion" minlength="5" maxlength="150" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="text-900">Correo Electronico <b class="text-danger">*</b></label>
                                <input type="email" class="form-control" name="correoElectronicoDp" id="correoElectronicoDp" placeholder="Correo Electronico" required>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="text-900">Direccion Residencia <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" name="direccionDp" id="direccionDp" placeholder="Direccion" minlength="5" maxlength="150" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Celular <b class="text-danger">*</b></label>
                                <input type="number" class="form-control" name="celularDp" id="celularDp" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Telefono <b class="text-danger">*</b></label>
                                <input type="number" class="form-control" name="telefonoDp" id="telefonoDp" placeholder="Direccion" required>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="text-900">Archivos</label>
                                <input type="file" class="form-control" id="archivosDp" name="archivosDp" accept=".pdf" multiple>
                                <div id="containerArchivosDatosPersonales" class="mt-2"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-1 text-center">
                            <button class="btn btn-outline-success me-1" onclick="crearDatosPersonas()"><i class="fas fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
                <!-- TAB ESTUDIOS -->
                <div class="tab-pane <?php if($active == 'estudios'){ echo 'active'; } ?>" role="tabpanel" aria-labelledby="estudios" id="estudios">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="table-responsive">
                                <div class="mb-3">
                                    <h4>Lista Estudios</h4>
                                </div>
                                <table id="tablaEstudios" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>TIPO FORMACION</th>
                                            <th>TITULO</th>
                                            <th>INSTITUCION EDUCATIVA</th>
                                            <th>ARCHIVO</th>
                                            <th>OPCIONES</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="card">
                                <div class="card-header p-3 border-bottom border-300 bg-success">
                                    <div class="row g-3 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-white mb-0">Agregar Estudios</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="formEstudios" name="formEstudios" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-12">
                                                <label class="text-900">Tipo Formacion <b class="text-danger">*</b></label>
                                                <select class="form-control select-field" name="tipoFormacionEst" id="tipoFormacionEst" onchange="changeTipoFormacion(this)" required style="width: 100%;">
                                                    <option value="">Seleccione una opcion</option>
                                                    <option value="BACHILLERATO">BACHILLERATO</option>
                                                    <option value="TECNICO LABORAL">TECNICO LABORAL</option>
                                                    <option value="TECNICO PROFESIONAL">TECNICO PROFESIONAL</option>
                                                    <option value="TECNOLOGICA">TECNOLOGICA</option>
                                                    <option value="UNIVERSITARIA">UNIVERSITARIA</option>
                                                    <option value="ESPECIALIZACION">ESPECIALIZACION</option>
                                                    <option value="MAESTRIA">MAESTRIA</option>
                                                    <option value="DOCTORADO">DOCTORADO</option>
                                                    <option value="ESTUDIOS NO FORMALES">ESTUDIOS NO FORMALES</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Titulo Otorgado <b class="text-danger">*</b></label>
                                                <input type="text" class="form-control" name="tituloOtorgadoEst" placeholder="Titulo Otorgado" id="tituloOtorgadoEst" minlength="10" maxlength="250" required>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Institucion Educativa <b class="text-danger">*</b></label>
                                                <input type="text" class="form-control" name="institucionEducativaEst" placeholder="Institucion Educativa" id="institucionEducativaEst" minlength="10" maxlength="250" required>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Fecha Grado <b class="text-danger">*</b></label>
                                                <input type="date" class="form-control" name="fechaGradoEst" id="fechaGradoEst" max="<?php echo $hoy; ?>" required>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Archivo <b class="text-danger">*</b></label>
                                                <input type="file" class="form-control" id="archivosEst" name="archivosEst" accept=".pdf" required>
                                            </div>
                                        </div>
                                        <div id="containerFieldsUniversitario" style="display: none;">
                                            <div class="row mb-2">
                                                <div class="col-sm-12 col-md-3">
                                                    <label class="text-900">Fecha Exp. Tarjeta Profesional</label>
                                                    <input type="date" class="form-control" name="fechaExpTarjetaProEst" id="fechaExpTarjetaProEst" max="<?php echo $hoy; ?>">
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <label class="text-900">Fecha Terminacion Materias</label>
                                                    <input type="date" class="form-control" name="fechaTermMateriasEst" id="fechaTermMateriasEst" max="<?php echo $hoy; ?>">
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <label class="text-900">Archivo Tarjeta Profesional</label>
                                                    <input type="file" class="form-control" id="archivosTarjetaProEst" name="archivosTarjetaProEst" accept=".pdf">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-1 text-center">
                                            <button class="btn btn-outline-success me-1" onclick="crearEstudio()"><i class="fas fa-save"></i> Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TAB EXPERIENCIAS LABORALES -->
                <div class="tab-pane <?php if($active == 'experiencias'){ echo 'active'; } ?>" role="tabpanel" aria-labelledby="experiencias" id="experiencias">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="table-responsive">
                                <div class="mb-3">
                                    <h4>Lista Experiencias Laborales</h4>
                                </div>
                                <table id="tablaExperienciasLaborales" class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>EMPRESA CONTRATANTE</th>
                                            <th>SECTOR</th>
                                            <th>CARGO</th>
                                            <th>ARCHIVO</th>
                                            <th>OPCIONES</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="card">
                                <div class="card-header p-3 border-bottom border-300 bg-success">
                                    <div class="row g-3 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-white mb-0">Agregar Experiencias Laborales</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="formExpLaborales" name="formExpLaborales" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Empresa Contratante <b class="text-danger">*</b></label>
                                                <input type="text" class="form-control" name="empresaEL" id="empresaEL" placeholder="Empresa Contratante" minlength="5" maxlength="150" required>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Sector <b class="text-danger">*</b></label>
                                                <select class="form-control select-field" name="sectorEL" id="sectorEL" required style="width: 100%;"></select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Cargo Desempeñado <b class="text-danger">*</b></label>
                                                <input type="text" class="form-control" name="cargoEL" id="cargoEL" minlength="5" maxlength="150" required>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Area Trabajo</label>
                                                <input type="text" class="form-control" name="areaTrabajoEL" id="areaTrabajoEL" minlength="5" maxlength="150">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Valor Contrato y/o Salario</label>
                                                <input type="number" class="form-control" name="valorSalarioEL" id="valorSalarioEL">
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <label class="text-900">Fecha Inicio Labor <b class="text-danger">*</b></label>
                                                <input type="date" class="form-control" name="fechaInicioEL" id="fechaInicioEL" max="<?php echo $hoy; ?>" required>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <label class="text-900">Fecha Fin Labor <b class="text-danger">*</b></label>
                                                <input type="date" class="form-control" name="fechaFinEL" id="fechaFinEL" max="<?php echo $hoy; ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Tipo Certificado <b class="text-danger">*</b></label>
                                                <select class="form-control select-field" name="tipoCertiEL" id="tipoCertiEL" required style="width: 100%;">
                                                    <option value="">Seleccione una opcion</option>
                                                    <option value="CERTIFICACION">CERTIFICACION</option>
                                                    <option value="CONTRATO">CONTRATO</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Archivos <b class="text-danger">*</b></label>
                                                <input type="file" class="form-control" id="archivosEL" name="archivosEL" accept=".pdf" required>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-1 text-center">
                                            <button class="btn btn-outline-success me-1" onclick="crearExperienciaLaboral()"><i class="fas fa-save"></i> Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <form id="formExpLaborales" name="formExpLaborales" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="text-900">Empresa Contratante <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" name="empresaEL" id="empresaEL" minlength="10" maxlength="150" required>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="text-900">Sector <b class="text-danger">*</b></label>
                                <select class="form-control select-field" name="sectorEL" id="sectorEL" required style="width: 100%;"></select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="text-900">Cargo Desempeñado <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" name="cargoEL" id="cargoEL" minlength="10" maxlength="150" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Area Trabajo</label>
                                <input type="text" class="form-control" name="areaTrabajoEL" id="areaTrabajoEL" minlength="10" maxlength="150">
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Valor Contrato y/o Salario</label>
                                <input type="number" class="form-control" name="valorSalarioEL" id="valorSalarioEL">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Fecha Inicio Labor <b class="text-danger">*</b></label>
                                <input type="date" class="form-control" name="fechaInicioEL" id="fechaInicioEL" max="<?php echo $hoy; ?>" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Fecha Fin Labor <b class="text-danger">*</b></label>
                                <input type="date" class="form-control" name="fechaFinEL" id="fechaFinEL" max="<?php echo $hoy; ?>" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Tipo Certificado <b class="text-danger">*</b></label>
                                <select class="form-control select-field" name="tipoCertiEL" id="tipoCertiEL" required style="width: 100%;"></select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label class="text-900">Archivos <b class="text-danger">*</b></label>
                                <input type="file" class="form-control" id="archivosEL" name="archivosEL" accept=".pdf" multiple required>
                            </div>
                        </div>
                    </form> -->


                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVerEstudio">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="exampleModalLabel">Ver Estudio</h5>
                <button class="btn p-1 text-primary" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Tipo Formacion</label>
                        <div id="tipoFormarcionVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Titulo Otorgado</label>
                        <div id="tituloOtorgadoVer"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Institucion Educativa</label>
                        <div id="institucionEducativaVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Fecha Grado</label>
                        <div id="fechaGradoVer"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Archivo Estudio</label>
                        <div id="contenedorArchivoEstudioVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Fecha Exp. Tarjeta Profesional</label>
                        <div id="fechaExpTarjetaProfesionalVer"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Archivo Exp. Tarjeta Profesional</label>
                        <div id="contenedorArchivoExpTarjetaProVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Fecha Terminacion Materia</label>
                        <div id="fechaTerminacionMateriaVer"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Usuario Crea</label>
                        <div id="usuarioCreaEstudioVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Fecha Crea</label>
                        <div id="fechaCreaEstudioVer"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVerExpLaboral">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="exampleModalLabel">Ver Experiencia Laboral</h5>
                <button class="btn p-1 text-primary" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Empresa Contratante</label>
                        <div id="empresaContratanteVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Sector</label>
                        <div id="sectorVer"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Cargo Desempeñado</label>
                        <div id="cargoDesempenadoVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Area Trabajo</label>
                        <div id="areaTrabajoVer"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Valor Contrato o Salario</label>
                        <div id="valorContratoSalarioVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Fecha Inicio Labor</label>
                                <div id="fechaInicioLaborVer"></div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Fecha Fin Labor</label>
                                <div id="fechaFinLaborVer"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Tipo Certificacion</label>
                        <div id="tipoCertificacionVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Archivo Exp. Laboral</label>
                        <div id="contenedorArchivoExpLaboralVer"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Usuario Crea</label>
                        <div id="usuarioCreaExpLaboralVer"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="fw-bold">Fecha Crea</label>
                        <div id="fechaCreaExpLaboralVer"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script src="views/js/hv/parametricas.js?v=<?= md5_file('views/js/hv/parametricas.js') ?>"></script>
<script src="views/js/hv/hv.js?v=<?= md5_file('views/js/hv/hv.js') ?>"></script>
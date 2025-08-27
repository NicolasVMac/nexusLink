<div class="content">
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card mb-2">
                <div class="card-header">
                    <h5 class="card-title font-20" id="card-header-title-audit-start" name="card-header-title-audit-start"></h5>
                </div>
                <div class="card-body cardAudit">
                    <ul class="nav nav-tabs custom-tab-line nav-tabs-aud mb-2" id="defaultTabLine" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link nav-link-aud active" id="info-Reclamacion" data-bs-toggle="tab" href="#infoReclamacion" role="tab" aria-controls="home-line" aria-selected="true"><i class="fa-solid fa-info mr-2"></i> Información</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-aud" id="profile-tab-line" data-bs-toggle="tab" href="#Cruces" role="tab" aria-controls="profile-line" aria-selected="false"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Cruces</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-aud" id="profile-tab-line" data-bs-toggle="tab" href="#Historicos" role="tab" aria-controls="profile-line" aria-selected="false"><i class="fa-solid fa-backward mr-2"></i> Historicos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-aud" id="profile-tab-line" data-bs-toggle="tab" href="#Anotaciones" role="tab" aria-controls="profile-line" aria-selected="false"><i class="fa-regular fa-clipboard mr-2"></i> Anotaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-aud" id="profile-tab-line" data-bs-toggle="tab" href="#Reps" role="tab" aria-controls="profile-line" aria-selected="false"><i class="fa-regular fa-clipboard mr-2"></i> Reps</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-aud" id="profile-tab-line" data-bs-toggle="tab" href="#infoReclamacionXml" role="tab" aria-controls="profile-line" aria-selected="false"><i class="fa-regular fa-file mr-2"></i> XML</a>
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link" id="contact-tab-line" data-bs-toggle="tab" href="#contact-line" role="tab" aria-controls="contact-line" aria-selected="false"><i class="fa-solid fa-brain mr-2"></i>IA (Beta)</a>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link nav-link-aud" id="cierre-Reclamacion" data-bs-toggle="tab" href="#cierreReclamacion" role="tab" aria-controls="profile-line" aria-selected="false"><i class="fa-solid fa-lock mr-2"></i> Cierre</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="defaultTabContentLine">
                        <div class="tab-pane fade active show" id="infoReclamacion" role="tabpanel" aria-labelledby="home-tab-line">
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <p class="text-center fw-bold">
                                        INFORMACIÓN CUENTA
                                    </p>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Nro Radicacion</label>
                                    <div id="numRadica" name="numRadica"></div>
                                    <input type="hidden" id="numeroPaquete" name="numeroPaquete">
                                    <!-- <input type="text" id="NumeroRadicacionAnotacion" name="NumeroRadicacionAnotacion"> -->
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Cuenta ID</label>
                                    <div id="reclamacionId" name="reclamacionId"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Fecha Radicación</label>
                                    <div id="fechaRadica" name="fechaRadica"></div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold" style="color: black;">Razon Social Reclamante</label>
                                    <div id="proveedor" name="proveedor"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Doc Reclamante</label>
                                    <div id="proveedorDoc" name="proveedorDoc"></div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Tipo Ingreso</label>
                                    <div id="tipoIngreso" name="tipoIngreso"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Nro Factura</label>
                                    <div id="numFactura" name="numFactura"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Fecha Evento</label>
                                    <div id="fechaEvento" name="fechaEvento"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Valor Medico</label>
                                    <div id="valorMedico" name="valorMedico"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Valor Transporte</label>
                                    <div id="valorTransporte" name="valorTransporte"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Valor Total Reclamado</label>
                                    <div id="valorReclamado" name="valorReclamado"></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <p class="text-center fw-bold">
                                        INFORMACIÓN VICTIMA
                                    </p>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold" style="color: black;">Nombre</label>
                                    <div id="nombreVictima" name="nombreVictima"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Documento</label>
                                    <div id="docVictima" name="docVictima"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Fecha Nacimiento</label>
                                    <div id="fechaNaci" name="fechaNaci"></div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Fecha Ingreso</label>
                                    <div id="fechaIni" name="fechaIni"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Fecha Egreso</label>
                                    <div id="fechaEgr" name="fechaEgr"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Dias Estancia</label>
                                    <div id="estanciaDia" name="estanciaDia"></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <p class="text-center fw-bold">
                                        DESCRIPCION DEL EVENTO
                                    </p>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold" style="color: black;">Descripcion</label>
                                    <div id="eventoDescrip" name="eventoDescrip"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Cruces" role="tabpanel" aria-labelledby="profile-tab-line">
                        </div>
                        <div class="tab-pane fade" id="Historicos" role="tabpanel" aria-labelledby="contact-tab-line">
                            <div class="row">
                                <div class="col-md-12 table-containerHistory">
                                    <div class="table-responsive">
                                        <table id="tableReclaHistorico" class="table table-striped table-sm" style="width:100%">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Cuenta Id</th>
                                                    <th>Num Factura</th>
                                                    <th>Evento</th>
                                                    <th>Prestador</th>
                                                    <th>Vl Reclamado</th>
                                                    <th>Vl Glosado</th>
                                                    <th>Vl Aprobado</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Anotaciones" role="tabpanel" aria-labelledby="profile-tab-line">
                            <div class="row">
                                <div class="col-md-12 table-containerHistory">
                                    <div class="table-responsive">
                                        <table id="tableAnotaciones" class="table table-striped table-sm" style="width:100%">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Cuenta Id</th>
                                                    <th>Numero Radicacion</th>
                                                    <th>Anotaciones</th>
                                                    <th>Usuario</th>
                                                    <th>Fecha crea</th>
                                                    <th>Opcion</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Reps" role="tabpanel" aria-labelledby="profile-tab-line">
                            <div class="row">
                                <div class="col-md-12 table-containerHistory">
                                    <div class="table-responsive">
                                        <table id="tableReps" class="table table-striped table-sm" style="width:100%">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Departamento</th>
                                                    <th>Municipio</th>
                                                    <th>Razon Social</th>
                                                    <th>NIT</th>
                                                    <th>Codigo Sede</th>
                                                    <th>Fecha Apertura Prestador</th>
                                                    <th>Fecha Cierre Prestador</th>
                                                    <th>Grupo Servicio</th>
                                                    <th>Codigo Servicio</th>
                                                    <th>Nombre Servicio</th>
                                                    <th>Fecha Apertura Servicio</th>
                                                    <th>Fecha Cierre Servicio</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="infoReclamacionXml" role="tabpanel" aria-labelledby="profile-tab-line">
                            <div id="accordionXml"></div>
                        </div>
                        <div class="tab-pane fade" id="cierreReclamacion" role="tabpanel" aria-labelledby="contact-tab-line">
                            <div class="row">
                                <div class="col">
                                    <p class="text-center fw-bold">
                                        VALORES DE CIERRE
                                    </p>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Valor Reclamado</label>
                                    <div id="valorReclamacionFin" name="valorReclamacionFin"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Valor Aprobado</label>
                                    <div id="valorAprobadoFin" name="valorAprobadoFin"></div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold" style="color: black;">Valor Glosado</label>
                                    <div id="valorGlosaFin" name="valorGlosaFin"></div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold" style="color: black;">Estado Aprobacion</label>
                                    <div id="EstadoAprobacion" name="EstadoAprobacion"></div>
                                </div>
                            </div>
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <div class="row justify-content-center">
                                <div class="col-md-2">
                                    <center><button class="btn btn-outline-success" id="btCloseRecla" name="btCloseRecla">Terminar Cuenta <i class="fa-solid fa-lock"></i></button></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title font-20">Gestion Cuenta</h5>
                        </div>
                        <div class="col-md-6">
                            <!-- <button id="hidePdfBtn" class="btn btn-outline-info mb-2 float-end">Ocultar PDF</button> -->
                            <button class="btn btn-outline-primary float-end m-1" onclick="openWindowImg()"><i class="far fa-eye"></i> Ver Imagen</button>
                            <button class="btn btn-outline-secondary float-end m-1" onclick="openFurips()"><i class="far fa-eye"></i> Ver Furips</button>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- <div class="col-md-6 pdf-container">
                        </div> -->
                        <div class="col-md-12 table-container">
                            <div class="table-responsive">
                                <table id="tableReclaDetail" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Tipo</th>
                                            <th>Codigo</th>
                                            <th>Descripcion</th>
                                            <th>Cant</th>
                                            <th>Vl Unitario</th>
                                            <th>Vl Reclamado</th>
                                            <th>Vl Glosado</th>
                                            <th>Opciones <input type="checkbox" class="checkGlosa" id="checkGlosaMasiva"></th>
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

    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title font-20">Glosas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tableReclaGlosas" class="table table-striped table-sm" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Id Glosa</th>
                                            <th>Id Item</th>
                                            <th>Tipo</th>
                                            <th>Cod Glosa</th>
                                            <th>Descrpcion Glosa</th>
                                            <th>Justificacion Glosa</th>
                                            <th>Valor Glosa</th>
                                            <th>Usuario</th>
                                            <th>Fecha</th>
                                            <th>Opciones <input type="checkbox" class="checkDelete" id="checkDeleteMasiva"></th>
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

<div class="modal fade" id="createGlosaUniModal">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <form id="formCreateGlosaItem" name="formCreateGlosaItem" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalCrearGlosa"></h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="glosaType">Tipo Glosa</label>
                                <select name="glosaType" id="glosaType" class="form-control" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label" for="glosaDescription">Descripcion Glosa</label>
                                <select name="glosaDescription" id="glosaDescription" class="form-control" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label" for="glosaBy">Glosar por:</label>
                        <select class="form-control" name="glosaBy" id="glosaBy" required="">
                        </select>
                    </div>



                    <div id="valorGlosaInput" style="display:none"> <!-- Valor Glosa-->
                        <div class="row">
                            <div class="col">
                                <p class="text-center fw-bold">
                                    Liquidacion Glosa
                                </p>
                                <hr>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="cantidadGlosa">Cantidad a Glosar</label>
                                    <input type="number" class="form-control" id="cantidadGlosa" name="cantidadGlosa" min="1" step="any">
                                    <small id="cantidadGlosaHelp" class="form-text invalid-feedback"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="valorGlosa">Valor a Glosar</label>
                                    <input type="number" class="form-control" id="valorGlosa" name="valorGlosa" min="0.01" step="any">
                                    <small id="valorGlosaHelp" class="form-text invalid-feedback"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="totalGlosa">Valor Total Glosado</label>
                                    <input type="number" class="form-control" id="totalGlosa" name="totalGlosa" min="1" step="any" value="0" readonly>
                                    <small id="totalGlosaHelp" class="form-text invalid-feedback"></small>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="porcentajeGlosaInput" class="mb-2" style="display:none"> <!-- Porcentaje Glosa-->
                        <div class="row">
                            <div class="col">
                                <p class="text-center fw-bold">
                                    Liquidacion Glosa
                                </p>
                                <hr>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="porcentajeGlosa">Porcentaje a Glosar</label>
                                    <input type="number" class="form-control" id="porcentajeGlosa" name="porcentajeGlosa" min="1" max="100" step="any">
                                    <small id="porcentajeGlosaHelp" class="form-text invalid-feedback"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="totalPorcentajeGlosa">Valor Total Glosado</label>
                                    <input type="number" class="form-control" id="totalPorcentajeGlosa" name="totalPorcentajeGlosa" min="1" step="any" value="0" readonly>
                                    <small id="totalPorcentajeGlosaHelp" class="form-text invalid-feedback"></small>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-2" id="justificacion" style="display:none">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="obsGlosa">Justificacion</label>
                                <textarea class="form-control" id="obsGlosa" name="obsGlosa" rows="4" placeholder="Justificacion glosa" type="textarea" minlength="5" maxlength="2000" required=""></textarea>
                                <small id="obsGlosaHelp" class="form-text invalid-feedback"></small>
                            </div>
                            <div id="contenedorValidacionJustificacion"></div>
                        </div>
                    </div>


                    <div class="row mb-2">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-sm" id="idItemModal" name="idItemModal" value="" required readonly="">
                                    <input type="hidden" class="form-control input-sm" id="descripItemModal" name="descripItemModal" value="" required readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-sm" id="cantidadItemModal" name="cantidadItemModal" value="" required readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-sm" id="valorUniItemModal" name="valorUniItemModal" value="" required readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-sm" id="valorItemModal" name="valorItemModal" value="" required readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-sm" id="codGlosa" name="codGlosa" value="" required readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-sm" id="tipoGlosa" name="tipoGlosa" value="" required readonly="">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success" id="btCreateGlosa" name="btCreateGlosa" disabled>Crear Glosa <i class="fa-solid fa-sack-dollar"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- GLOSA ENCABEZADO -->
<div class="modal fade" id="createGlosaRecModal" role="dialog" aria-labelledby="createGlosaRecModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <form id="formCreateGlosaRecla" name="formCreateGlosaRecla" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalCrearGlosaRecla"></h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="glosaTypeRecla">Tipo Glosa</label>
                                <select name="glosaTypeRecla" id="glosaTypeRecla" class="form-control" required>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label" for="glosaDescriptionRecla">Descripcion Glosa</label>
                                <select name="glosaDescriptionRecla" id="glosaDescriptionRecla" class="form-control" style="width: 100%;" required>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2" id="justificacion" style="display:block">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="obsGlosaRecla">Justificacion</label>
                                <textarea class="form-control" id="obsGlosaRecla" name="obsGlosaRecla" rows="4" placeholder="Justificacion glosa" onkeyup="mayusculaValidText(this)" type="textarea" minlength="5" maxlength="2000" required=""></textarea>
                                <small id="obsGlosaReclaHelp" class="form-text invalid-feedback"></small>
                            </div>
                            <div id="contenedorValidacionJustificacionRecla"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-sm" id="codGlosaRecla" name="codGlosaRecla" value="" required readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-sm" id="tipoGlosaRecla" name="tipoGlosaRecla" value="Encabezado" required readonly="">
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success" id="btCreateGlosaRecla" name="btCreateGlosaRecla" disabled>Crear Glosa Cuenta <i class="fa-solid fa-sack-dollar"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="createGlosaMasivaModal" role="dialog" aria-labelledby="createGlosaMasivaModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <form id="formCreateGlosaMasivaItem" name="formCreateGlosaMasivaItem" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalCrearGlosaMasiva"></h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="glosaMasivaType">Tipo Glosa</label>
                                <select name="glosaMasivaType" id="glosaMasivaType" class="form-control" required>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label" for="glosaMasivaDescription">Descripcion Glosa</label>
                                <select name="glosaMasivaDescription" id="glosaMasivaDescription" class="form-control" required>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        
                        <label class="form-label" for="glosaMasivaBy">Glosar por:</label>
                        <select class="form-control" name="glosaMasivaBy" id="glosaMasivaBy" required="">
                            <option value="">Seleccione una opcion</option>
                            <option value="Valor">Valor - $</option>
                            <option value="Porcentaje">Porcentaje - %</option>
                        </select>
                    </div>

                    <div id="valorMasivaGlosaInput" style="display:none"> <!-- Valor Glosa-->
                        <div class="row">
                            <div class="col">
                                <p class="text-center fw-bold">
                                    Liquidacion Glosa
                                </p>
                                <hr>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="valorMasivaGlosa">Valor a Glosar *</label>
                                    <input type="number" class="form-control" id="valorMasivaGlosa" name="valorMasivaGlosa" min="0.01" step="any">
                                    <small id="valorMasivaGlosaHelp" class="form-text invalid-feedback"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="porcentajeMasivaGlosaInput" class="mb-2" style="display:none"> <!-- Porcentaje Glosa-->
                        <div class="row">
                            <div class="col">
                                <p class="text-center fw-bold">
                                    Liquidacion Glosa
                                </p>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="porcentajeMasivaGlosa">Porcentaje a Glosar **</label>
                                    <input type="number" class="form-control" id="porcentajeMasivaGlosa" name="porcentajeMasivaGlosa" min="1" max="100" step="any">
                                    <small id="porcentajeMasivaGlosaHelp" class="form-text invalid-feedback"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="justificacionMasiva" style="display:none">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="obsMasivoGlosa">Justificacion</label>
                                <textarea class="form-control" id="obsMasivoGlosa" name="obsMasivoGlosa" rows="4" placeholder="Justificacion glosa" type="textarea" minlength="5" maxlength="2000" required=""></textarea>
                                <small id="obsMasivoGlosaHelp" class="form-text invalid-feedback"></small>
                            </div>
                            <div id="contenedorValidacionJustificacionMasiva"></div>
                        </div>
                    </div>


                    <div class="row mb-2">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-sm" id="idItemMasivoModal" name="idItemMasivoModal" value="" required readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-sm" id="codMasivoGlosa" name="codMasivoGlosa" value="" required readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control input-sm" id="tipoMasivoGlosa" name="tipoMasivoGlosa" value="" required readonly="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <font size="2">
                                <p class="help-block">
                                    * El valor del de la glosa sera aplicado a todos los servicios seleccionados,si el valor glosado es mayor al valor facturado se glosara el total del servicio, de lo contrario se aplicara la diferencia<br>
                                    ** El valor del porcentaje sera aplicado por igual a todos los servicios seleccionados
                                </p>
                            </font>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-warning" id="btCreateMasivaGlosa" name="btCreateMasivaGlosa" disabled>Crear Glosa Masiva <i class="fa-solid fa-money-check-dollar"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="createAnotacion" role="dialog" aria-labelledby="createAnotacion" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <form id="formCreateAnotacion" name="formCreateAnotacion" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Anotacion</h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="NumeroRadicacionAnotacion" name="NumeroRadicacionAnotacion">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="obsAnotacion">Anotacion</label>
                                <textarea class="form-control" id="obsAnotacion" name="obsAnotacion" rows="4" placeholder="Anotacion Cuenta" type="textarea" minlength="2" maxlength="1200" required=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success" id="btCreateAnotacion" name="btCreateAnotacion" onclick="guardarAnotacion()" enabled>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/pcm/audstart.js?v=<?= md5_file('views/js/pcm/audstart.js') ?>"></script>
<script src="views/js/pcm/cruces.js?v=<?= md5_file('views/js/pcm/cruces.js') ?>"></script>
<script src="views/js/pcm/historicos.js?v=<?= md5_file('views/js/pcm/historicos.js') ?>"></script>
<script src="views/js/pcm/reps.js?v=<?= md5_file('views/js/pcm/reps.js') ?>"></script>
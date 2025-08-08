<div class="content">
    <form id="formEditarPaciente" name="formEditarPaciente" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
            <div class="card-header p-4 border-bottom border-300 bg-primary">
                <div class="row g-3 justify-content-between align-items-center">
                    <div class="col-12 col-md">
                        <h4 class="text-white mb-0">Datos Basicos</h4>
                    </div>
                    <div class="col col-md-auto">
                        <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                            <a class="btn btn-danger me-1 mb-1" href="<?php echo 'index.php?ruta='.$carpeta.'/pacientes'; ?>" ><span class="fas fa-arrow-left"></span> Volver</a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="">Numero Identificacion</label>
                        <input type="number" class="form-control readonly" name="editNumIdentificacionPaciente" id="editNumIdentificacionPaciente" placeholder="1000000000" required readonly>
                        <input type="hidden" class="form-control" name="editIdPaciente" id="editIdPaciente" required>
                    </div>
                    <div class="col-md-3">
                        <label class="">Expedido En</label>
                        <input type="text" class="form-control" name="editExpDocPaciente" id="editExpDocPaciente" placeholder="Expedido En">
                    </div>
                    <div class="col-md-3">
                        <label class="">Tipo Documento</label>
                        <select class="form-select select-field" name="editTipoDocPaciente" id="editTipoDocPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="">Carnet No.</label>
                        <input type="number" class="form-control readonly" name="editNumCarnetPaciente" id="editNumCarnetPaciente" placeholder="1000000000" readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="">Primer Apellido</label>
                        <input type="text" class="form-control" name="editPriApellidoPaciente" id="editPriApellidoPaciente" placeholder="Primer Apellido" required>
                    </div>
                    <div class="col-md-2">
                        <label class="">Segundo Apellido</label>
                        <input type="text" class="form-control" name="editSegApellidoPaciente" id="editSegApellidoPaciente" placeholder="Segundo Apellido" required>
                    </div>
                    <div class="col-md-3">
                        <label class="">Primer Nombre</label>
                        <input type="text" class="form-control" name="editPriNombrePaciente" id="editPriNombrePaciente" placeholder="Primer Nombre" required>
                    </div>
                    <div class="col-md-2">
                        <label class="">Segundo Nombre</label>
                        <input type="text" class="form-control" name="editSegNombrePaciente" id="editSegNombrePaciente" placeholder="Segundo Nombre">
                    </div>
                    <div class="col-md-2">
                        <label class="">Seudónimo</label>
                        <input type="text" class="form-control" name="editSeudonimoPaciente" id="editSeudonimoPaciente" placeholder="Seudonimo">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class="">Fecha Nacimiento</label>
                        <input type="date" class="form-control" name="editFechaNacimientoPaciente" id="editFechaNacimientoPaciente" fechaActual="<?php echo $hoy; ?>" min="1900-01-01" max="<?php echo $hoy; ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label class="">Edad</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="editEdadNPaciente" id="editEdadNPaciente" readonly required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="editEdadTPaciente" id="editEdadTPaciente" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="">Estado Civil</label>
                        <select class="form-select select-field" name="editEstadoCivilPaciente" id="editEstadoCivilPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="">Sexo</label>
                        <select class="form-select select-field" name="editGeneroPaciente" id="editGeneroPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="">Escolaridad</label>
                        <select class="form-select select-field" name="editEscolaridadPaciente" id="editEscolaridadPaciente" required style="width: 100%;">
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class="">Vinculacion</label>
                        <select class="form-select select-field" name="editVinculacionPaciente" id="editVinculacionPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Ocupacion</label>
                        <select class="form-select select-field" name="editOcupacionPaciente" id="editOcupacionPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Grupo Poblacional</label>
                        <select class="form-select select-field" name="editGrupoPoblacionalPaciente" id="editGrupoPoblacionalPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Pertenencia Etnica</label>
                        <select class="form-select select-field" name="editPertenenciaEtnicaPaciente" id="editPertenenciaEtnicaPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Regimen</label>
                        <select class="form-select select-field" name="editRegimenPaciente" id="editRegimenPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Tipo Usuario RIPS</label>
                        <select class="form-select select-field" name="editTipoUsuRipsPaciente" id="editTipoUsuRipsPaciente" required style="width: 100%;">
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="">Tipo Afiliacion (FE)</label>
                        <select class="form-select select-field" name="editTipoAfiliacionPaciente" id="editTipoAfiliacionPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="">Entidad Af. Actual</label>
                        <select class="form-select select-field" name="editEntidadAfActualPaciente" id="editEntidadAfActualPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Mod - Copago</label>
                        <select class="form-select select-field" name="editModCopagoPaciente" id="editModCopagoPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Copago FE</label>
                        <select class="form-select select-field" name="editCopagoFePaciente" id="editCopagoFePaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Nivel Sisben</label>
                        <input type="number" class="form-control" name="editNivelSisbenPaciente" id="editNivelSisbenPaciente" style="width: 100%;">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="">Departamento Sisben</label>
                        <select class="form-select select-field" name="editDepartamentoSisbenPaciente" id="editDepartamentoSisbenPaciente" style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="">Municipio Sisben</label>
                        <select class="form-select select-field" name="editMunicipioSisbenPaciente" id="editMunicipioSisbenPaciente" style="width: 100%;">
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6 mb-2">
                <div class="card shadow-none border border-300" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Datos Atencion</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="">Reclama Medicamentos En</label>
                                <select class="form-select select-field" name="editReclamaMedicamentosEnPaciente" id="editReclamaMedicamentosEnPaciente" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="">Paquete de Atencion</label>
                                <select class="form-select select-field" name="editPaqueteAtencionPaciente" id="editPaqueteAtencionPaciente" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="">Notificado Sivigila</label>
                                <div class="row">
                                    <div class="col-md-8">
                                        <select class="form-select select-field" name="editNotificadoSivigilaPaciente" id="editNotificadoSivigilaPaciente" style="width: 100%;">
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" name="editFechaNotificadoSivigilaPaciente" id="editFechaNotificadoSivigilaPaciente" min="1900-01-01" max="<?php echo $hoy; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="">IPS que Notifica</label>
                                <input type="text" class="form-control" name="editIpsNotificacionPaciente" id="editIpsNotificacionPaciente" placeholder="Nombre IPS">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <div class="card shadow-none border border-300" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Datos Ubicacion</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="">Direccion</label>
                                <input type="text" class="form-control" name="editDireccionUbicacionPaciente" id="editDireccionUbicacionPaciente" placeholder="Calle 100 #00-00" required>
                                <input type="hidden" class="form-control" name="latitudUbicacion" id="latitudUbicacion" required>
                                <input type="hidden" class="form-control" name="longitudUbicacion" id="longitudUbicacion" required>
                                <input type="hidden" class="form-control" name="usuarioEdita" id="usuarioEdita" value="<?php echo $_SESSION["usuario"]; ?>" required>
                            </div>
                            <div class="col-md-8">
                                <center><label class="">Telefono</label></center>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" name="editTelefonoUnoPaciente" id="editTelefonoUnoPaciente" placeholder="3000000000" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" name="editTelefonoDosPaciente" id="editTelefonoDosPaciente" placeholder="3010000000" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="">Zona</label>
                                <select class="form-select select-field" name="editZonaUbicacionPaciente" id="editZonaUbicacionPaciente" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="">Departamento</label>
                                <select class="form-select select-field" name="editDepartamentoUbicacionPaciente" id="editDepartamentoUbicacionPaciente" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="">Municipio</label>
                                <select class="form-select select-field" name="editMunicipioUbicacionPaciente" id="editMunicipioUbicacionPaciente" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="">Pais Origen</label>
                                <select class="form-select select-field" name="editPaisOrigenPaciente" id="editPaisOrigenPaciente" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="">Correo Electronico</label>
                                <input type="email" class="form-control" name="editCorreoPaciente" id="editCorreoPaciente" placeholder="correo@correo.com" required>
                            </div>
                        </div>
                        <br>
                        <!-- <center><a class="btn btn-success" onclick="mostrarMapaUbicacionEditar()"><span class="fas fa-map-pin"></span> Mostrar Mapa Ubicacion</a></center> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6 mb-2">
                <div class="card shadow-none border border-300" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-info">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Datos Contacto</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="">Madre</label>
                                <input type="text" class="form-control" name="editNombreMadrePaciente" id="editNombreMadrePaciente" placeholder="Nombre Madre">
                            </div>
                            <div class="col-md-6">
                                <label class="">Padre</label>
                                <input type="text" class="form-control" name="editNombrePadrePaciente" id="editNombrePadrePaciente" placeholder="Nombre Padre">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="">Responsable</label>
                                <input type="text" class="form-control" name="editResponsablePaciente" id="editResponsablePaciente" required>
                            </div>
                            <div class="col-md-6">
                                <label class="">Parentesco</label>
                                <input type="text" class="form-control" name="editParentescoPaciente" id="editParentescoPaciente" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-5">
                                <label class="">Direccion</label>
                                <input type="text" class="form-control" name="editDireccionContactoPaciente" id="editDireccionContactoPaciente" required>
                            </div>
                            <div class="col-md-3">
                                <label class="">Telefono</label>
                                <input type="number" class="form-control" name="editTelefonoContactoPaciente" id="editTelefonoContactoPaciente" required>
                            </div>
                            <div class="col-md-4">
                                <label class="">Pseudonimo</label>
                                <input type="text" class="form-control" name="editPseudonimoPaciente" id="editPseudonimoPaciente">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="">Observaciones</label>
                                <textarea class="form-control" name="editObservacionesContactoPaciente" id="editObservacionesContactoPaciente" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-none border border-300" data-component-card="data-component-card">
                    <div class="card-body">
                        <div class="alert alert-outline-warning d-flex align-items-center" role="alert">
                            <span class="fas fa-info-circle text-warning fs-3 me-3"></span>
                            <p class="mb-0 flex-1">Si el Mapa no se muestra correctamente por favor haz click. <a class="btn btn-info btn-sm" onclick="recargarMapa()">ACTUALIZAR MAPA</a></p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div id="mapaUbicacion" style="height: 500px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <center><button class="btn btn-primary" onclick="editarPaciente()"><span class="far fa-save"></span> Guardar Paciente</button></center>
    </form>
</div>

<script src="views/js/config/pacientes.js?v=<?= md5_file('views/js/config/pacientes.js') ?>"></script>

<div class="content">
    <form id="formAgregarPaciente" name="formAgregarPaciente" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
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
                        <input type="number" class="form-control" name="numIdentificacionPaciente" id="numIdentificacionPaciente" placeholder="1000000000" required onchange="validarExistenciaDocumento()">
                    </div>
                    <div class="col-md-3">
                        <label class="">Expedido En</label>
                        <input type="text" class="form-control" name="expDocPaciente" id="expDocPaciente" placeholder="Expedido En">
                    </div>
                    <div class="col-md-3">
                        <label class="">Tipo Documento</label>
                        <select class="form-select select-field" name="tipoDocPaciente" id="tipoDocPaciente" required style="width: 100%;" onchange="validarExistenciaDocumento()">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="">Carnet No.</label>
                        <input type="number" class="form-control readonly" name="numCarnetPaciente" id="numCarnetPaciente" placeholder="1000000000" required readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="">Primer Apellido</label>
                        <input type="text" class="form-control" name="priApellidoPaciente" id="priApellidoPaciente" placeholder="Primer Apellido" required>
                    </div>
                    <div class="col-md-2">
                        <label class="">Segundo Apellido</label>
                        <input type="text" class="form-control" name="segApellidoPaciente" id="segApellidoPaciente" placeholder="Segundo Apellido" required>
                    </div>
                    <div class="col-md-3">
                        <label class="">Primer Nombre</label>
                        <input type="text" class="form-control" name="priNombrePaciente" id="priNombrePaciente" placeholder="Primer Nombre" required>
                    </div>
                    <div class="col-md-2">
                        <label class="">Segundo Nombre</label>
                        <input type="text" class="form-control" name="segNombrePaciente" id="segNombrePaciente" placeholder="Segundo Nombre" required>
                    </div>
                    <div class="col-md-2">
                        <label class="">Seudónimo</label>
                        <input type="text" class="form-control" name="seudonimoPaciente" id="seudonimoPaciente" placeholder="Seudonimo">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class="">Fecha Nacimiento</label>
                        <input type="date" class="form-control" name="fechaNacimientoPaciente" id="fechaNacimientoPaciente" fechaActual="<?php echo $hoy; ?>" min="1900-01-01" max="<?php echo $hoy; ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label class="">Edad</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="edadNPaciente" id="edadNPaciente" readonly required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="edadTPaciente" id="edadTPaciente" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="">Estado Civil</label>
                        <select class="form-select select-field" name="estadoCivilPaciente" id="estadoCivilPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="">Sexo</label>
                        <select class="form-select select-field" name="generoPaciente" id="generoPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="">Escolaridad</label>
                        <select class="form-select select-field" name="escolaridadPaciente" id="escolaridadPaciente" required style="width: 100%;">
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class="">Vinculacion</label>
                        <select class="form-select select-field" name="vinculacionPaciente" id="vinculacionPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Ocupacion</label>
                        <select class="form-select select-field" name="ocupacionPaciente" id="ocupacionPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Grupo Poblacional</label>
                        <select class="form-select select-field" name="grupoPoblacionalPaciente" id="grupoPoblacionalPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Pertenencia Etnica</label>
                        <select class="form-select select-field" name="pertenenciaEtnicaPaciente" id="pertenenciaEtnicaPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Regimen</label>
                        <select class="form-select select-field" name="regimenPaciente" id="regimenPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Tipo Usuario RIPS</label>
                        <select class="form-select select-field" name="tipoUsuRipsPaciente" id="tipoUsuRipsPaciente" required style="width: 100%;">
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="">Tipo Afiliacion (FE)</label>
                        <select class="form-select select-field" name="tipoAfiliacionPaciente" id="tipoAfiliacionPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="">Entidad Af. Actual</label>
                        <select class="form-select select-field" name="entidadAfActualPaciente" id="entidadAfActualPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Mod - Copago</label>
                        <select class="form-select select-field" name="modCopagoPaciente" id="modCopagoPaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Copago FE</label>
                        <select class="form-select select-field" name="copagoFePaciente" id="copagoFePaciente" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="">Nivel Sisben</label>
                        <input type="number" class="form-control" name="nivelSisbenPaciente" id="nivelSisbenPaciente" style="width: 100%;">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="">Departamento Sisben</label>
                        <select class="form-select select-field" name="departamentoSisbenPaciente" id="departamentoSisbenPaciente" style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="">Municipio Sisben</label>
                        <select class="form-select select-field" name="municipioSisbenPaciente" id="municipioSisbenPaciente" style="width: 100%;">
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
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
                                <select class="form-select select-field" name="reclamaMedicamentosEnPaciente" id="reclamaMedicamentosEnPaciente" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="">Paquete de Atencion</label>
                                <select class="form-select select-field" name="paqueteAtencionPaciente" id="paqueteAtencionPaciente" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="">Notificado Sivigila</label>
                                <div class="row">
                                    <div class="col-md-8">
                                        <select class="form-select select-field" name="notificadoSivigilaPaciente" id="notificadoSivigilaPaciente" style="width: 100%;">
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" name="fechaNotificadoSivigilaPaciente" id="fechaNotificadoSivigilaPaciente" min="1900-01-01" max="<?php echo $hoy; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="">IPS que Notifica</label>
                                <input type="text" class="form-control" name="ipsNotificacionPaciente" id="ipsNotificacionPaciente" placeholder="Nombre IPS">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
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
                                <input type="text" class="form-control" name="direccionUbicacionPaciente" id="direccionUbicacionPaciente" placeholder="Calle 100 #00-00" required>
                                <input type="hidden" class="form-control" name="latitudUbicacion" id="latitudUbicacion" required>
                                <input type="hidden" class="form-control" name="longitudUbicacion" id="longitudUbicacion" required>
                                <input type="hidden" class="form-control" name="usuarioCrea" id="usuarioCrea" value="<?php echo $_SESSION["usuario"]; ?>" required>
                            </div>
                            <div class="col-md-8">
                                <center><label class="">Telefono</label></center>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" name="telefonoUnoPaciente" id="telefonoUnoPaciente" placeholder="3000000000" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" name="telefonoDosPaciente" id="telefonoDosPaciente" placeholder="3010000000" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="">Zona</label>
                                <select class="form-select select-field" name="zonaUbicacionPaciente" id="zonaUbicacionPaciente" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="">Departamento</label>
                                <select class="form-select select-field" name="departamentoUbicacionPaciente" id="departamentoUbicacionPaciente" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="">Municipio</label>
                                <select class="form-select select-field" name="municipioUbicacionPaciente" id="municipioUbicacionPaciente" required style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="">Pais Origen</label>
                                <select class="form-select select-field" name="paisOrigenPaciente" id="paisOrigenPaciente" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="">Correo Electronico</label>
                                <input type="email" class="form-control" name="correoPaciente" id="correoPaciente" placeholder="correo@correo.com" required>
                            </div>
                        </div>
                        <br>
                        <!-- <center><a class="btn btn-success" onclick="mostrarMapaUbicacion()"><span class="fas fa-map-pin"></span> Mostrar Mapa Ubicacion</a></center> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
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
                                <input type="text" class="form-control" name="nombreMadrePaciente" id="nombreMadrePaciente" placeholder="Nombre Madre">
                            </div>
                            <div class="col-md-6">
                                <label class="">Padre</label>
                                <input type="text" class="form-control" name="nombrePadrePaciente" id="nombrePadrePaciente" placeholder="Nombre Padre">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="">Responsable</label>
                                <input type="text" class="form-control" name="responsablePaciente" id="responsablePaciente" required>
                            </div>
                            <div class="col-md-6">
                                <label class="">Parentesco</label>
                                <input type="text" class="form-control" name="parentescoPaciente" id="parentescoPaciente" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-5">
                                <label class="">Direccion</label>
                                <input type="text" class="form-control" name="direccionContactoPaciente" id="direccionContactoPaciente" required>
                            </div>
                            <div class="col-md-3">
                                <label class="">Telefono</label>
                                <input type="number" class="form-control" name="telefonoContactoPaciente" id="telefonoContactoPaciente" required>
                            </div>
                            <div class="col-md-4">
                                <label class="">Pseudonimo</label>
                                <input type="text" class="form-control" name="pseudonimoPaciente" id="pseudonimoPaciente">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="">Observaciones</label>
                                <textarea class="form-control" name="observacionesContactoPaciente" id="observacionesContactoPaciente" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-none border border-300" data-component-card="data-component-card">
                    <div class="card-body">
                        <div id="mapaUbicacion" style="height: 500px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <center><button class="btn btn-primary btnAgregarPaciente"><span class="far fa-save"></span> Guardar Paciente</button></center>
    </form>
</div>

<script src="views/js/config/parametricas.js?v=<?= md5_file('views/js/config/parametricas.js') ?>"></script>
<script src="views/js/config/pacientes.js?v=<?= md5_file('views/js/config/pacientes.js') ?>"></script>

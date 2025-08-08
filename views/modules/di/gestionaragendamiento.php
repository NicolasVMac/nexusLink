<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Informacion Paciente Base</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label class=""># Bolsa Agendamiento</label><div id="textIdBolsaAgendamiento"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">Fecha Base</label><div id="textFechaBase"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">Agrupador IPS</label><div id="textAgrupadorIps"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">IPS</label><div id="textIps"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="">Nombre Paciente</label><div id="textNombrePaciente"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="">Edad Años</label><div id="textEdadAnios"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label class="">Sexo</label><div id="textSexo"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="">Tipo Documento</label><div id="textTipoDocumento"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="">Numero Documento</label><div id="textNumeroDocumento"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label class="">Numero Celular</label><div id="textNumeroCelular"></div>
                        </div>
                        <div class="col-md-3">
                            <label class="">Numero Telefono</label><div id="textNumeroTelefono"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="">Direccion</label><div id="textDireccion"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label class="">Cohorte o Programa</label><div id="textCohortePrograma"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="">Grupo Riesgo</label><div id="textGrupoRiesgo"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="">Equipo Profesional</label><div id="textEquipoProfesional"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-danger">
                    <div class="row g-3 justify-content-between align-items-center">    
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Comunicaciones Fallidas</h4>
                        </div>
                        <div class="col col-md-auto">
                            <a class="btn btn-phoenix-danger ms-2" data-bs-toggle="modal" data-bs-target="#modalComunicacionFallida"><i class="fas fa-phone-slash"></i> Agregar Comunicacion Fallida</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaComunicacionesFallidas" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>CAUSAL FALLIDA</th>
                                    <th>OBSERVACIONES</th>
                                    <th>USUARIO CREA</th>
                                    <th>FECHA CREA</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-success">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Gestion Agendamiento</h4>
                        </div>
                        <div class="col col-md-auto">
                            <form id="formTerminarGestionAgendamiento" name="formTerminarGestionAgendamiento" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                <button class="btn btn-phoenix-success ms-2" onclick="terminarGestionAgendamiento()"><i class="far fa-calendar-check"></i> Terminar Gestion</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-underline" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="paciente-tab" data-bs-toggle="tab" href="#tab-paciente" role="tab" aria-controls="tab-paciente" aria-selected="true">
                                <i class="far fa-id-card"></i> Paciente
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <?php if(isset($_GET["idPaciente"])): ?>
                                <a class="nav-link" id="cita-tab" data-bs-toggle="tab" href="#tab-cita" role="tab" aria-controls="tab-cita" aria-selected="false" tabindex="-1">
                                    <i class="fas fa-address-book"></i> Cita
                                </a>
                            <?php else: ?>
                                <a class="nav-link text-danger">
                                    <i class="fas fa-address-book"></i> Cita
                                </a>
                            <?php endif ?>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab-paciente" role="tabpanel" aria-labelledby="paciente-tab">

                            <?php if(!isset($_GET["idPaciente"])): ?>
                                <form id="formAgregarPaciente" name="formAgregarPaciente" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                        <div class="card-header p-4 border-bottom border-300 bg-primary">
                                            <div class="row g-3 justify-content-between align-items-center">
                                                <div class="col-12 col-md">
                                                    <h4 class="text-white mb-0">Datos Basicos</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-md-3">
                                                    <label class="">Tipo Documento <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="tipoDocPacienteAgen" id="tipoDocPacienteAgen" required style="width: 100%;" onchange="validarExistenciaDocumento()">
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Numero Identificacion <small class="text-danger">*</small></label>
                                                    <input type="number" class="form-control" name="numIdentificacionPaciente" id="numIdentificacionPaciente" placeholder="1000000000" required onchange="validarExistenciaDocumento()">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Expedido En</label>
                                                    <input type="text" class="form-control" name="expDocPaciente" id="expDocPaciente" placeholder="Expedido En">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Carnet No.</label>
                                                    <input type="number" class="form-control readonly" name="numCarnetPaciente" id="numCarnetPaciente" placeholder="1000000000">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3">
                                                    <label class="">Primer Apellido <small class="text-danger">*</small></label>
                                                    <input type="text" class="form-control" name="priApellidoPaciente" id="priApellidoPaciente" placeholder="Primer Apellido" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Segundo Apellido</label>
                                                    <input type="text" class="form-control" name="segApellidoPaciente" id="segApellidoPaciente" placeholder="Segundo Apellido">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Primer Nombre <small class="text-danger">*</small></label>
                                                    <input type="text" class="form-control" name="priNombrePaciente" id="priNombrePaciente" placeholder="Primer Nombre" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Segundo Nombre</label>
                                                    <input type="text" class="form-control" name="segNombrePaciente" id="segNombrePaciente" placeholder="Segundo Nombre">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Seudónimo</label>
                                                    <input type="text" class="form-control" name="seudonimoPaciente" id="seudonimoPaciente" placeholder="Seudonimo">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-2">
                                                    <label class="">Fecha Nacimiento <small class="text-danger">*</small></label>
                                                    <input type="date" class="form-control" name="fechaNacimientoPaciente" id="fechaNacimientoPaciente" fechaActual="<?php echo $hoy; ?>" min="1900-01-01" max="<?php echo $hoy; ?>" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Edad <small class="text-danger">*</small></label>
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
                                                    <label class="">Estado Civil <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="estadoCivilPaciente" id="estadoCivilPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Sexo <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="generoPacienteAgen" id="generoPacienteAgen" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Escolaridad <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="escolaridadPaciente" id="escolaridadPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-2">
                                                    <label class="">Vinculacion <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="vinculacionPaciente" id="vinculacionPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Ocupacion <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="ocupacionPaciente" id="ocupacionPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Grupo Poblacional <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="grupoPoblacionalPaciente" id="grupoPoblacionalPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Pertenencia Etnica <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="pertenenciaEtnicaPaciente" id="pertenenciaEtnicaPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Regimen <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="regimenPacienteAgen" id="regimenPacienteAgen" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Tipo Usuario RIPS <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="tipoUsuRipsPaciente" id="tipoUsuRipsPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3">
                                                    <label class="">Tipo Afiliacion (FE) <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="tipoAfiliacionPaciente" id="tipoAfiliacionPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Entidad Af. Actual <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="entidadAfActualPaciente" id="entidadAfActualPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Mod - Copago <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="modCopagoPaciente" id="modCopagoPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Copago FE <small class="text-danger">*</small></label>
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
                                                            <label class="">Direccion <small class="text-danger">*</small></label>
                                                            <input type="text" class="form-control" name="direccionUbicacionPaciente" id="direccionUbicacionPaciente" placeholder="Calle 100 #00-00" required>
                                                            <input type="hidden" class="form-control" name="latitudUbicacion" id="latitudUbicacion" required>
                                                            <input type="hidden" class="form-control" name="longitudUbicacion" id="longitudUbicacion" required>
                                                            <input type="hidden" class="form-control" name="usuarioCrea" id="usuarioCrea" value="<?php echo $_SESSION["usuario"]; ?>" required>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <center><label class="">Telefono <small class="text-danger">*</small></label></center>
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
                                                            <label class="">Zona <small class="text-danger">*</small></label>
                                                            <select class="form-select select-field" name="zonaUbicacionPaciente" id="zonaUbicacionPaciente" required style="width: 100%;">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <label class="">Departamento <small class="text-danger">*</small></label>
                                                            <select class="form-select select-field" name="departamentoUbicacionPaciente" id="departamentoUbicacionPaciente" required style="width: 100%;">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="">Municipio <small class="text-danger">*</small></label>
                                                            <select class="form-select select-field" name="municipioUbicacionPaciente" id="municipioUbicacionPaciente" required style="width: 100%;">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <label class="">Pais Origen <small class="text-danger">*</small></label>
                                                            <select class="form-select select-field" name="paisOrigenPaciente" id="paisOrigenPaciente" required style="width: 100%;">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="">Correo Electronico <small class="text-danger">*</small></label>
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
                                                            <label class="">Responsable <small class="text-danger">*</small></label>
                                                            <input type="text" class="form-control" name="responsablePaciente" id="responsablePaciente" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="">Parentesco <small class="text-danger">*</small></label>
                                                            <input type="text" class="form-control" name="parentescoPaciente" id="parentescoPaciente" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">
                                                            <label class="">Direccion <small class="text-danger">*</small></label>
                                                            <input type="text" class="form-control" name="direccionContactoPaciente" id="direccionContactoPaciente" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="">Telefono <small class="text-danger">*</small></label>
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
                                                    <div class="alert alert-outline-warning d-flex align-items-center" role="alert">
                                                        <span class="fas fa-info-circle text-warning fs-3 me-3"></span>
                                                        <p class="mb-0 flex-1">Si el Mapa no se muestra correctamente por favor haz click. <a class="btn btn-info btn-sm" onclick="recargarMapaPaciente()">ACTUALIZAR MAPA</a></p>
                                                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                    <div id="mapaUbicacion" style="height: 500px; width: 100%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <center><button class="btn btn-primary" onclick="agregarPaciente()"><span class="far fa-save"></span> Guardar Paciente</button></center>
                                </form>
                            <?php else: ?>
                                <form id="formEditarPaciente" name="formEditarPaciente" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                        <div class="card-header p-4 border-bottom border-300 bg-primary">
                                            <div class="row g-3 justify-content-between align-items-center">
                                                <div class="col-12 col-md">
                                                    <h4 class="text-white mb-0">Datos Basicos</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-md-3">
                                                    <label class="">Tipo Documento <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editTipoDocPaciente" id="editTipoDocPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Numero Identificacion <small class="text-danger">*</small></label>
                                                    <input type="number" class="form-control readonly" name="editNumIdentificacionPaciente" id="editNumIdentificacionPaciente" placeholder="1000000000" required readonly>
                                                    <input type="hidden" class="form-control" name="editIdPaciente" id="editIdPaciente" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Expedido En</label>
                                                    <input type="text" class="form-control" name="editExpDocPaciente" id="editExpDocPaciente" placeholder="Expedido En">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Carnet No.</label>
                                                    <input type="number" class="form-control readonly" name="editNumCarnetPaciente" id="editNumCarnetPaciente" readonly placeholder="1000000000">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3">
                                                    <label class="">Primer Apellido <small class="text-danger">*</small></label>
                                                    <input type="text" class="form-control" name="editPriApellidoPaciente" id="editPriApellidoPaciente" placeholder="Primer Apellido" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Segundo Apellido</label>
                                                    <input type="text" class="form-control" name="editSegApellidoPaciente" id="editSegApellidoPaciente" placeholder="Segundo Apellido">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Primer Nombre <small class="text-danger">*</small></label>
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
                                                    <label class="">Fecha Nacimiento <small class="text-danger">*</small></label>
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
                                                    <label class="">Estado Civil <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editEstadoCivilPaciente" id="editEstadoCivilPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Sexo <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editGeneroPaciente" id="editGeneroPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Escolaridad <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editEscolaridadPaciente" id="editEscolaridadPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-2">
                                                    <label class="">Vinculacion <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editVinculacionPaciente" id="editVinculacionPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Ocupacion <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editOcupacionPaciente" id="editOcupacionPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Grupo Poblacional <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editGrupoPoblacionalPaciente" id="editGrupoPoblacionalPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Pertenencia Etnica <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editPertenenciaEtnicaPaciente" id="editPertenenciaEtnicaPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Regimen <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editRegimenPaciente" id="editRegimenPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Tipo Usuario RIPS <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editTipoUsuRipsPaciente" id="editTipoUsuRipsPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-3">
                                                    <label class="">Tipo Afiliacion (FE) <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editTipoAfiliacionPaciente" id="editTipoAfiliacionPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="">Entidad Af. Actual <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editEntidadAfActualPaciente" id="editEntidadAfActualPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Mod - Copago <small class="text-danger">*</small></label>
                                                    <select class="form-select select-field" name="editModCopagoPaciente" id="editModCopagoPaciente" required style="width: 100%;">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="">Copago FE <small class="text-danger">*</small></label>
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
                                                            <label class="">Direccion <small class="text-danger">*</small></label>
                                                            <input type="text" class="form-control" name="editDireccionUbicacionPaciente" id="editDireccionUbicacionPaciente" placeholder="Calle 100 #00-00" required>
                                                            <input type="hidden" class="form-control" name="latitudUbicacion" id="latitudUbicacion" required>
                                                            <input type="hidden" class="form-control" name="longitudUbicacion" id="longitudUbicacion" required>
                                                            <input type="hidden" class="form-control" name="usuarioEdita" id="usuarioEdita" value="<?php echo $_SESSION["usuario"]; ?>" required>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <center><label class="">Telefono <small class="text-danger">*</small></label></center>
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
                                                            <label class="">Zona <small class="text-danger">*</small></label>
                                                            <select class="form-select select-field" name="editZonaUbicacionPaciente" id="editZonaUbicacionPaciente" required style="width: 100%;">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <label class="">Departamento <small class="text-danger">*</small></label>
                                                            <select class="form-select select-field" name="editDepartamentoUbicacionPaciente" id="editDepartamentoUbicacionPaciente" required style="width: 100%;">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="">Municipio <small class="text-danger">*</small></label>
                                                            <select class="form-select select-field" name="editMunicipioUbicacionPaciente" id="editMunicipioUbicacionPaciente" required style="width: 100%;">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <label class="">Pais Origen <small class="text-danger">*</small></label>
                                                            <select class="form-select select-field" name="editPaisOrigenPaciente" id="editPaisOrigenPaciente" required style="width: 100%;">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="">Correo Electronico <small class="text-danger">*</small></label>
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
                                                            <label class="">Responsable <small class="text-danger">*</small></label>
                                                            <input type="text" class="form-control" name="editResponsablePaciente" id="editResponsablePaciente" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="">Parentesco <small class="text-danger">*</small></label>
                                                            <input type="text" class="form-control" name="editParentescoPaciente" id="editParentescoPaciente" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">
                                                            <label class="">Direccion <small class="text-danger">*</small></label>
                                                            <input type="text" class="form-control" name="editDireccionContactoPaciente" id="editDireccionContactoPaciente" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="">Telefono <small class="text-danger">*</small></label>
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
                                <!-- <div id="calendar"></div> -->
                            <?php endif ?>
                        </div>
                        <div class="tab-pane fade" id="tab-cita" role="tabpanel" aria-labelledby="cita-tab">
                            <form id="formAgregarCita" name="formAgregarCita" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                            <div class="card-header p-4 border-bottom border-300 bg-primary">
                                                <div class="row g-3 justify-content-between align-items-center">
                                                    <div class="col-12 col-md">
                                                        <h4 class="text-white mb-0">Agendar Cita</h4>
                                                    </div>
                                                    <div class="col col-md-auto">
                                                        <button class="btn btn-phoenix-primary ms-2" onclick="crearCita()"><i class="far fa-save"></i> Guardar Cita</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 mb-2">
                                                        <label class="">Servicio</label>
                                                        <select class="form-select select-field" name="servicioCita" id="servicioCita" required style="width: 100%;">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 mb-2">
                                                        <label class="">Motivo Cita</label>
                                                        <input type="text" class="form-control" name="motivoCita" id="motivoCita" placeholder="Motivo Cita" required>
                                                        <input type="hidden" name="cohortePrograma" id="cohortePrograma">
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 mb-2">
                                                        <label class="">Profesional</label>
                                                        <select class="form-select select-field" name="profesionalCita" id="profesionalCita" required style="width: 100%;">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 mb-2">
                                                        <label class="">Fecha Cita</label>
                                                        <input type="date" class="form-control" name="fechaCita" id="fechaCita" min="<?php echo $hoy; ?>" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 mb-2">
                                                        <label class="">Franja Cita</label>
                                                        <select class="form-select select-field" name="franjaCita" id="franjaCita" required style="width: 100%;">
                                                            <option value="">Seleccione una Franja</option>
                                                            <option value="AM">AM</option>
                                                            <option value="PM">PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 mb-2">
                                                        <label class="">Localidad</label>
                                                        <select class="form-select select-field" name="localidadCita" id="localidadCita" required style="width: 100%;">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 mb-3">
                                                    <label class="">Observacion Cita</label>
                                                    <textarea class="form-control" name="observacionCita" id="observacionCita" rows="3" required placeholder="Observaciones"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                            <div class="card-header p-4 border-bottom border-300 bg-warning-300">
                                                <div class="row g-3 justify-content-between align-items-center">
                                                    <div class="col-12 col-md">
                                                        <h4 class="text-white mb-0">Citas Pendiente Paciente</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="contenedorCitasPendientesPaciente"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-8">
                                        <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                                            <div class="card-body">
                                                <center>
                                                    <a class="btn btn-warning" style="background-color: #ffb200;">FRANJA: AM</a>
                                                    <a class="btn btn-primary">FRANJA: PM</a>
                                                    <a class="btn btn-danger">NO-DISPONIBLE</a>
                                                </center>
                                                <div class="p-2" id="calendar"></div>
                                            </div>
                                        </div>
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

<div class="modal fade" id="modalEvento" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title text-white">Informacion Cita</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-12">
                        <label class="">Servicio</label><div id="txtServicio"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6">
                        <label class="">Nombre Paciente</label><div id="textNombrePacienteCita"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="">Documento Paciente</label><div id="textDocPaciente"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6">
                        <label class="">Motivo Cita</label><div id="textEventMotivoCita"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="">Cohorte o Programa</label><div id="textEventCohortePrograma"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6">
                        <label class="">Fecha Cita</label><div id="textEventFechaCita"></div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <label class="">Estado</label><div id="textEventEstado"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-6">
                        <label class="">Profesional</label><div id="textEventProfesional"></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="">Localidad</label><div id="textEventLocalidad"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-12">
                        <label class="">Observaciones Cita</label><div id="textEventObservacionesCita"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="fas fa-arrow-left"></span> Close</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalComunicacionFallida" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formComunicacionFallida" name="formComunicacionFallida" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Registrar Comunicacion Fallida</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="">Causal Comunicacion Fallida</label>
                        <select class="form-select" name="causalFallida" id="causalFallida" required style="width: 100%;">
                        </select>
                        <input type="hidden" name="idBolsaPaciente" id="idBolsaPaciente">
                        <input type="hidden" name="cantidadGestionesComuFallida" id="cantidadGestionesComuFallida">
                    </div>
                    <div class="mb-2">
                        <label class="">Observaciones</label>
                        <textarea class="form-control" name="observacionesFallida" id="observacionesFallida" required rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="fas fa-arrow-left"></span> Close</a>
                    <button class="btn btn-primary btn-sm" onclick="registrarComunicacionFallida()"><span class="far fa-save"></span> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/di/parametricas.js?v=<?= md5_file('views/js/di/parametricas.js') ?>"></script>
<script src="views/js/di/agendamiento.js?v=<?= md5_file('views/js/di/agendamiento.js') ?>"></script>
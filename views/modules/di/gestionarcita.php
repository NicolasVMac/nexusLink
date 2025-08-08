<?php 
$cohortePrograma = base64_decode($_GET["cohortePrograma"]);
?>
<div class="content">

    <h1>Gestionar Cita</h1>
    <div class="row">
        <div class="col-sm-12 col-md-6">

            <?php include "./views/modules/config/infopaciente.php"; ?>

            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Informacion Cita</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label class=" text-primary">Servicio Cita</label><div id="textServicioCita"></div>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <label class=" text-primary">Motivo Cita</label><div id="textMotivoCita"></div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label class=" text-primary">Cohorte o Programa</label><div id="textCohortePrograma"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <label class=" text-primary">Fecha Cita</label><div id="textFechaCita"></div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label class=" text-primary">Franja Cita</label><div id="textFranjaCita"></div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label class=" text-primary">Localidad</label><div id="textLocalidadCita"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <label class=" text-primary">Observaciones Cita</label><div id="textObservacionesCita"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <form id="formAgregarPreCita" name="formAgregarPreCita" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Agendar Pre-Cita</h4>
                            </div>
                            <div class="col col-md-auto">
                                <button class="btn btn-phoenix-success ms-2" onclick="crearPreCita()"><i class="far fa-save"></i> Guardar Pre-Cita</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label class="">Motivo Pre-Cita</label>
                                <input type="text" class="form-control" name="motivoPreCita" id="motivoPreCita" placeholder="Motivo Cita" required>
                                <input type="hidden" class="form-control" name="idPacientePreCita" id="idPacientePreCita" required>
                            </div>
                            <div class="col-sm-12 col-md-3 mb-2">
                                <label class="">Fecha Pre-Cita</label>
                                <input type="date" class="form-control" name="fechaPreCita" id="fechaPreCita" min="<?php echo $hoy; ?>" required>
                            </div>
                            <div class="col-sm-12 col-md-3 mb-2">
                                <label class="">Franja Pre-Cita</label>
                                <select class="form-select select-field" name="franjaPreCita" id="franjaPreCita" required style="width: 100%;">
                                    <option value="">Seleccione una Franja</option>
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-3">
                            <label class="">Observacion Pre-Cita</label>
                            <textarea class="form-control" name="observacionPreCita" id="observacionPreCita" rows="3" required placeholder="Observaciones"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-warning">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Pre-Citas Agendadas</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaPreCitasCreadas" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>MOTIVO CITA</th>
                                    <th>FECHA CITA</th>
                                    <th>OBSERVACIONES CITA</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            
            <?php if($cohortePrograma == "VACUNACION"): ?>

                <?php include "formularios-citas/vacunacion.php"; ?>

            <?php elseif($cohortePrograma == "MATERNO PERINATAL Y SSR"): ?>

                <?php include "formularios-citas/materno-perinatal.php"; ?>

            <?php elseif($cohortePrograma == "SALUD INFANTIL"): ?>

                <?php include "formularios-citas/salud-infantil.php"; ?>

            <?php elseif($cohortePrograma == "CRONICOS"): ?>

                <?php include "formularios-citas/cronicos.php"; ?>

            <?php elseif($cohortePrograma == "PHD"): ?>

                <?php include "formularios-citas/phd.php"; ?>

            <?php elseif($cohortePrograma == "ANTICOAGULADOS"): ?>

                <?php include "formularios-citas/anticoagulados.php"; ?>

            <?php elseif($cohortePrograma == "NUTRICION"): ?>

                <?php include "formularios-citas/nutricion.php"; ?>
                
            <?php elseif($cohortePrograma == "TRABAJO SOCIAL"): ?>
                    
                <?php include "formularios-citas/trabajo-social.php"; ?>

            <?php elseif($cohortePrograma == "PSICOLOGIA"): ?>
                
                <?php include "formularios-citas/psicologia.php"; ?>
                
            <?php elseif($cohortePrograma == "RIESGO CARDIO VASCULAR"): ?>
                
                <?php include "formularios-citas/riesgo-cardio-vascular.php"; ?>

            <?php endif ?>

        </div>
    </div>
</div>

<script src="views/js/di/citas.js?v=<?= md5_file('views/js/di/citas.js') ?>"></script>
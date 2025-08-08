<div class="content">
    <h2 class="mb-3">Cargar Acta</h2>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <form id="formCrearActa" name="formCrearActa" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-primary">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Informacion Acta</h4>
                            </div>
                            <div class="col col-md-auto">
                                <button class="btn btn-phoenix-primary ms-2" onclick="crearActa()"><i class="far fa-calendar-check"></i> Guardar Acta</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <label>Radicado Acta</label>
                                <input type="text" class="form-control" name="radicadoActa" id="radicadoActa" placeholder="Radicado Acta" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Cantidad PQRSF</label>
                                <input type="number" min="1" class="form-control" name="cantidadPQR" id="cantidadPQR" placeholder="Radicado Acta" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Fecha Apertura Buzon</label>
                                <input type="date" class="form-control" name="fechaAperturaBuzonPQR" id="fechaAperturaBuzonPQR" onchange="valiFechaActaPQRSF()" max="<?php echo $hoy; ?>" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Fecha Acta</label>
                                <input type="date" class="form-control" name="fechaActaPQR" id="fechaActaPQR" max="<?php echo $hoy; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <label>Adjuntar Archivos</label>
                                <input type="file" class="form-control" id="archivosActa" name="archivosActa" accept=".pdf" multiple required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="views/js/pqr/actas.js?v=<?= md5_file('views/js/pqr/actas.js') ?>"></script>
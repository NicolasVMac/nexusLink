<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
    <form id="formCitaVacunacion" name="formCitaVacunacion" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Formulario Cita Vacunacion</h4>
                </div>
                <div class="col col-md-auto">
                    <button class="btn btn-phoenix-danger ms-2" onclick="guardarCitaFallida()"><i class="far fa-calendar-times"></i> Fallida</button>
                    <button class="btn btn-phoenix-success ms-2" onclick="guardarCitaVacunacion()"><i class="far fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
        
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Vacuna Administrada</label>
                    <input type="text" class="form-control" name="vacunaAdministrada" id="vacunaAdministrada" placeholder="Vacuna Administrada" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Dosis Administrada</label>
                    <input type="text" class="form-control" name="dosisAdministrada" id="dosisAdministrada" placeholder="Dosis Administrada" required>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Fecha Administracion</label>
                    <input type="date" class="form-control" name="fechaAdministracion" id="fechaAdministracion" required>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-12 col-md-12">
                    <label class="">Observaciones</label>
                    <textarea class="form-control" rows="5" name="observacionesVacunacion" id="observacionesVacunacion" placeholder="Observaciones..."></textarea>
                </div>
            </div>
        </div>
    </form>
</div>
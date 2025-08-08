<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0">Lista Mantenimientos Activos Fijos</h4>
                        </div>
                        <!-- <div class="col col-md-auto">
                            <button class="btn btn-phoenix-success ms-2" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuarioProfesional"><i class="fas fa-briefcase"></i> Agregar Proyecto</button>
                        </div> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaListaMantenimientosActivosFijos" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>CATEGORIA</th>
                                    <th>TIPO ACTIVO</th>
                                    <th>MANTENIMIENTO</th>
                                    <th>TIPO MANTENIMIENTO</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                <form id="formAgregarMantenimientoActivoFijo" name="formAgregarMantenimientoActivoFijo" method="post" enctype="multipart/form-data" onsubmit="return false;">
                    <div class="card-header p-4 border-bottom border-300 bg-success">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Agregar Mantenimiento Activo Fijo</h4>
                            </div>
                            <div class="col col-md-auto">
                                <button class="btn btn-phoenix-success ms-2" onclick="crearMantenimientoActivoFijo()"><i class="fas fa-save"></i> Agregar Mantenimiento</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label>Categoria Actiivo Fijo</label>
                                <select class="form-control" id="mCategoriaActivoFijo" name="mCategoriaActivoFijo" onchange="changeCategoriaActivoFijo(this)" required style="width: 100%;">
                                    <option value="">Seleccione una opcion</option>
                                    <option value="EQUIPO BIOMEDICO">EQUIPO BIOMEDICO</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label>Tipo Activo Fijo</label>
                                <select class="form-control select-field" id="mTipoActivoFijo" name="mTipoActivoFijo" required style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label>Mantenimiento</label>
                                <input type="text" class="form-control" name="mMantenimiento" id="mMantenimiento" placeholder="Mantenimiento" minlength="5" maxlength="150" required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <label>Tipo Mantenimiento</label>
                                <select class="form-control" id="mTipoMantenimiento" name="mTipoMantenimiento" required style="width: 100%;">
                                    <option value="">Seleccione una opcion</option>
                                    <option value="PREVENTIVO">PREVENTIVO</option>
                                    <option value="CORRECTIVO">CORRECTIVO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="views/js/inventario/mantenimientos.js?v=<?= md5_file('views/js/inventario/mantenimientos.js') ?>"></script>
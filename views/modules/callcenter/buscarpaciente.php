<div class="content">
    <form id="formBuscarPaciente" name="formBuscarPaciente" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
            <div class="card-header p-4 border-bottom border-300 bg-primary">
                <div class="row g-3 justify-content-between align-items-center">
                    <div class="col-12 col-md">
                        <h4 class="text-white mb-0">Buscar Paciente</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label class="">Filtro Busqueda</label>
                        <select class="form-select select-field" name="filtroBusqueda" id="filtroBusqueda" style="width: 100%;" required>
                            <option value="">Seleccione una opcion</option>
                            <option value="Numero Documento">Numero Documento</option>
                        </select>
                        <label class=" mt-3">Valor Busqueda</label>
                        <input type="text" class="form-control" name="textoBusqueda" id="textoBusqueda" placeholder="Texto Busqueda" required>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <br><br>
                <center><button class="btn btn-success btn-sm" onclick="buscarPaciente()"><span class="fas fa-search"></span> Buscar</button></center>
            </div>
        </div>
    </form>

    <div class="card shadow-none border border-300 mb-2" id="cardResultSearch" style="display: none;">
        <div class="card-header p-4 border-bottom border-300 bg-light">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h5 class="">Resultado</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaSearchPacientes" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>NUMERO DOCUMENTO</th>
                            <th>NO CARNET</th>
                            <th>EDAD</th>
                            <th>CORREO</th>
                            <th>TELEFONOS</th>
                            <th>UBICACION</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="views/js/callcenter/callcenter.js?v=<?= md5_file('views/js/callcenter/callcenter.js') ?>"></script>
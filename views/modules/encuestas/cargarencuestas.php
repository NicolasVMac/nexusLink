<div class="content">

    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Cargar Base Auditoria</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formCargarArchivoEncuestas" name="formCargarArchivoEncuestas" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4 text-center">
                        <label class="">Nombre</label>
                        <input type="text" class="form-control" id="nombreArchivoEncuesta" name="nombreArchivoEncuesta" required>
                        <label class="">Tipo Auditoria</label>
                        <select class="form-control select-field" id="tipoEncuesta" name="tipoEncuesta"  style="width: 100%;" onchange="auditoresTipoEncuesta()" required>
                            <option value="">Seleccione un Tipo Auditoria</option>
                            <option value="AUTOINMUNES">AUTOINMUNES</option>
                            <option value="VIH">VIH</option>
                        </select>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label class="">% Nivel Confianza</label>
                                <select class="form-control select-field" id="nivelConfianza" name="nivelConfianza" style="width: 100%;"  required>
                                    <option value="">Seleecione una opcion</option>
                                    <option value="80">80%</option>
                                    <option value="85">85%</option>
                                    <option value="90">90%</option>
                                    <option value="95">95%</option>
                                    <option value="99">99%</option>
                                </select>
                                <!-- <input type="number" class="form-control" id="nivelConfianza" name="nivelConfianza" min="1" max="100" required> -->
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="">% Margen Error</label>
                                <input type="number" class="form-control" id="margenError" name="margenError" min="1" max="100" required>
                            </div>
                        </div>
                        <label class="">Archivo</label>
                        <input type="file" class="form-control" id="archivoEncuesta" name="archivoEncuesta" required>
                        <label class="">Auditor</label>
                        <select class="form-control select-field" id="auditorEncuesta" name="auditorEncuesta"  style="width: 100%;" required>
                        </select>
                        <br/>
                        <a href="../../../archivos_vidamedical/recursos/encuestas/BASE CARGUE ENCUESTAS.xlsx" target="_blank" download><center><span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label"><i class="fas fa-cloud-download-alt"></i> Descargar formato de Carga <b>Auditoria <i class="far fa-file-excel"></i></b></span></span></center></a>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <center><button type="submit" class="btn btn-success" onclick="cargarBaseEncuestas()"><i class="far fa-save"></i> Cargar Base</button></center>
            </form>
        </div>
    </div>
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Bases Encuestas</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaBasesEncuestas" class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>NOMBRE ARCHIVO</th>
                            <th>TIPO ENCUESTA</th>
                            <th>ARCHIVO</th>
                            <th>CANTIDAD</th>
                            <th>MUESTRA</th>
                            <th>ESTADO</th>
                            <th>USUARIO</th>
                            <th>AUDITOR BASE</th>
                            <th>FECHA CARGA</th>
                        </tr>
                    </thead>
                </table>
            </div>  
        </div>
    </div>
</div>

<script src="views/js/encuestas/encuestas.js?v=<?= md5_file('views/js/encuestas/encuestas.js') ?>"></script>

<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Cargar PDF</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="formCargarArchivoPDF" name="formCargarArchivoPDF" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-4 text-center">
                        <label class="">Nombre</label>
                        <input type="text" class="form-control" id="nombreArchivoPDF" name="nombreArchivoPDF" required>
                        <div class="row"></div>
                        <label class="">Archivo</label>
                        <input type="file" class="form-control" id="archivoPDF" name="archivoPDF" required accept=".pdf">
                        <br />
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
                <center>
                    <button type="submit" class="btn btn-success" onclick="cargarPDF()">
                        <i class="far fa-save"></i> Cargar PDF
                    </button>
                </center>
            </form>
        </div>
    </div>
</div>
<script src="views/js/pdfia/cargarpdf.js?v=<?= md5_file('views/js/pdfia/cargarpdf.js') ?>"></script>

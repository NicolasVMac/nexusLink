<div class="content">
    <form id="formCrearTicket" name="formCrearTicket" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
            <div class="card-header p-4 border-bottom border-300 bg-primary">
                <div class="row g-3 justify-content-between align-items-center">
                    <div class="col-12 col-md">
                        <h3 class="text-white mb-0">Crear Ticket</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="">Nombre Usuario</label>
                                <input type="text" class="form-control readonly" name="nombreUsuarioTicket" id="nombreUsuarioTicket" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                                <input type="hidden" name="idUsuarioCreaTicket" id="idUsuarioCreaTicket" value="<?php echo $_SESSION["id_usuario"]; ?>">
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="">Usuario</label>
                                <input type="text" class="form-control readonly" name="usuarioTicket" id="usuarioTicket" value="<?php echo $_SESSION["usuario"]; ?>" readonly>
                            </div>
                        </div>
                        <hr>
                        <label class="">Asunto</label>
                        <input type="text" class="form-control" name="asuntoTicket" id="asuntoTicket" placeholder="Asunto Ticket" required>
                        <br>
                        <label class="">Proyecto</label>
                        <select class="form-select select-field" name="proyectoTicket" id="proyectoTicket" style="width: 100%;" required>
                        </select>
                        <br>
                        <label class="">Prioridad</label>
                        <select class="form-select select-field" name="prioridadTicket" id="prioridadTicket" style="width: 100%;" required>
                        </select>
                        <br>
                        <label class="">Adjuntar Archivos</label>
                        <input type="file" class="form-control" id="archivosTicket" name="archivosTicket" multiple>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="">Descripcion</label>
                        <textarea class="form-control editor" name="descripcionTicket"></textarea>
                    </div>
                </div>
                <br><br>
                <center><button class="btn btn-primary" onclick="crearTicket()"><span class="far fa-save"></span> Crear Ticket</button></center>
            </div>
        </div>
    </form>
</div>

<script src="views/js/mesaayuda/parametricas.js?v=<?= md5_file('views/js/mesaayuda/parametricas.js') ?>"></script>
<script src="views/js/mesaayuda/tickets.js?v=<?= md5_file('views/js/mesaayuda/tickets.js') ?>"></script>
<div class="content">
    <form id="formAgregarUsuario" name="formAgregarUsuario" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
            <div class="card-header p-4 border-bottom border-300 bg-primary">
                <div class="row g-3 justify-content-between align-items-center">
                    <div class="col-12 col-md">
                        <h4 class="text-white mb-0">Informacion Usuario</h4>
                    </div>
                    <div class="col col-md-auto">
                        <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                            <a class="btn btn-danger me-1 mb-1" href="<?php echo 'index.php?ruta='.$carpeta.'/usuarios'; ?>" ><span class="fas fa-arrow-left"></span> Volver</a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <h4 class="text-primary mb-2">Datos</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="">Nombre</label>
                                <input type="text" class="form-control" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre Completo" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="">Documento</label>
                                <input type="number" class="form-control" name="numDocUsuario" id="numDocUsuario" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="">Usuario</label>
                                <input type="text" class="form-control" name="usuarioNuevo" id="usuarioNuevo" placeholder="Usuario" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="">Contraseña</label>
                                <input type="password" class="form-control" name="passwordUsuario" id="passwordUsuario" placeholder="Contraseña" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="">Telefono</label>
                                <input type="number" class="form-control" name="telefonoUsuario" id="telefonoUsuario" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="">Correo</label>
                                <input type="email" class="form-control" name="correoUsuario" id="correoUsuario" placeholder="Correo Electronico" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <h4 class="text-primary mb-2">Menus</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class=" mb-2">Disponibles</label>
                                <!-- <div id="contenedorMenusProyecto"></div> -->
                                <div id="contenedorSelectMenus"></div>
                            </div>
                            <!-- <div class="col-md-12 mb-2">
                                <label class="">Proyecto</label>
                                <select class="form-select select-field" name="proyectos" id="proyectos" required style="width: 100%;" onchange="menusProyecto()">
                                </select>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="">Menus</label>
                                <div id="contenedorMenusProyecto"></div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <center><button class="btn btn-primary" onclick="crearUsuario()"><span class="far fa-save"></span> Guardar Usuario</button></center>
    </form>
</div>

<script src="views/js/config/usuarios.js?v=<?= md5_file('views/js/config/usuarios.js') ?>"></script>

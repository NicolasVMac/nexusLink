<div class="content">
    <div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-primary">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Gestión PDF-IA</h4>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row pdfia-row-height">

                <div class="col-sm-12 col-md-7 ">
                    <div class="card border border-300 mb-2 h-100">
                        <div class="card-body pdf-container p-0 ">
                            <iframe id="pdfViewer" class="pdfia-iframe" style="height:100vh; width:100%;"></iframe>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-5 ">
                    <div class="card border border-300 mb-2 h-100">
                        <div class="card-header p-4 border-bottom border-300 bg-primary">
                            <div class="row g-3 justify-content-between align-items-center">
                                <div class="col-12 col-md">
                                    <h4 class="text-white mb-0">Chat Gestion</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column" style="overflow-y: auto; height:100px;">
                            <div class="chat-messages flex-grow-1 overflow-auto" id="chatMensajes">
                            </div>
                            <div class="chat-input mt-3">
                                <input type="text" id="chatMensaje" placeholder="Escribe un mensaje..." class="form-control mb-2">
                                <button id="enviarMensajeBtn" class="btn btn-primary w-100">Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="views/js/pdfia/gestionpdf.js?v=<?= md5_file('views/js/pdfia/gestionpdf.js') ?>"></script>
function getParameterByName(name) {
    let urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}
let id_pdf, sourceId, nombre_pdf;

const loadingFnc = () => {

    Swal.fire({
        title: 'Guardando...',
        text: 'Por favor espera mientras se guarda la información.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

}

async function initGestionPDF() {
    id_pdf = atob(getParameterByName('idPDF'));
    sourceId = atob(getParameterByName('sourceId'));
    nombre_pdf = atob(getParameterByName('pdf'));

    document.getElementById("pdfViewer").src = `view_pdf.php?type=pdfIA&nombre_pdf=${nombre_pdf}`;
}

const construirMensajeHTML = (msg, nombreUsuario) => {
    // Elegimos un color de texto según el rol
    let claseTitulo = (msg.rol === 'user') ? 'text-warning-300' : 'text-primary-300';

    return `
    <div class="row mb-2">
        <div class="col-sm-12 col-md-1 text-center d-flex align-items-center">
            <div class="row h-100">
                <div class="col d-flex align-items-center">
                    <h5 class="m-2">
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-11 py-2">
            <div class="card shadow-user-permited">
                <div class="table-responsive">
                    <div class="card-body">
                        <h5 class="card-title ${claseTitulo}">
                            <span class="far fa-user-circle"></span> ${nombreUsuario}
                        </h5>
                        <p class="card-text">${msg.descripcion}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `;
};


async function cargarMensajesBD() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'ajax/pdfia/pdfia.ajax.php',
            type: 'POST',
            dataType: 'json',
            data: {
                proceso: 'listarMensajesPDF',
                id_pdf: id_pdf
            },
            success: function (respuesta) {
                $("#chatMensajes").empty();
                if (respuesta.data) {
                    respuesta.data.forEach(msg => {
                        let nombreUsuario = (msg.rol === 'user') ? 'Tú' : 'IA';

                        let tarjetaHTML = construirMensajeHTML(msg, nombreUsuario);
                        $("#chatMensajes").append(tarjetaHTML);
                    });

                    $("#chatMensajes").scrollTop($("#chatMensajes")[0].scrollHeight);

                    resolve(true);

                } else {
                    console.warn("No se obtuvo un array de mensajes desde el servidor (respuesta.data).");
                    resolve(false);
                }
            },
            error: function (error) {
                console.error("Error al cargar mensajes desde BD:", error);
                reject(error);
            }
        });
    });
}



const enviarMensajeChatPdf = async (mensaje) => {
    loadingFnc();
    try {
        const response = await fetch("https://api.chatpdf.com/v1/chats/message", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",

                "x-api-key": "sec_ZVFh61DRGTFKgpKttdU2P0AyhFF6Ia1R"// (APIKEY SANTIAGO)
            },
            body: JSON.stringify({
                sourceId: sourceId,
                messages: [{ role: "user", content: mensaje }]
            })
        });
        if(response.status == 200){
            const data = await response.json();
            Swal.close();
            return data;
        }
        

    } catch (error) {
        console.error("Error al enviar mensaje a ChatPDF:", error);
        return { error: true, content: "Error en la comunicación con la API" };
    }
};


async function guardarMensajeEnBD(rol, contenido, idPDF) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'ajax/pdfia/pdfia.ajax.php',
            type: 'POST',
            data: {
                proceso: 'guardarMensajePDF',
                rol: rol,
                contenido: contenido,
                id_pdf: idPDF,
                usuario: userSession
            },
            success: function (respuesta) {
                if (respuesta.trim() === "ok") {
                    resolve(true);
                } else {
                    console.warn("No se pudo guardar el mensaje en BD.", respuesta);
                    Swal.fire({
                        title: "Error al guardar",
                        text: "El servidor respondió con un error: " + respuesta,
                        icon: "error",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "Aceptar"
                    });
                    resolve(false);
                }
            },
            error: function (error) {
                console.error("Error al guardar mensaje en la BD:", error);
                Swal.fire({
                    title: "Error de conexión",
                    text: "Hubo un problema al conectar con el servidor.",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Aceptar"
                });
                reject(error);
            }
        });
    });
}

$("#enviarMensajeBtn").click(async function () {
    let mensaje = $("#chatMensaje").val().trim();

    if (mensaje !== "") {
        let msgUser = {
            rol: 'user',
            descripcion: mensaje
        };

        let tarjetaUserHTML = construirMensajeHTML(msgUser, 'Tú');
        $("#chatMensajes").append(tarjetaUserHTML);

        try {
            await guardarMensajeEnBD('user', mensaje, id_pdf);

            const respuestaApi = await enviarMensajeChatPdf(mensaje);

            if (respuestaApi && respuestaApi.content) {
                let msgBot = {
                    rol: 'bot',
                    descripcion: respuestaApi.content
                };
                let tarjetaBotHTML = construirMensajeHTML(msgBot, 'ChatPDF');
                $("#chatMensajes").append(tarjetaBotHTML);

                await guardarMensajeEnBD('bot', respuestaApi.content, id_pdf);

            } else {
                $("#chatMensajes").append(`
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="alert alert-danger" role="alert">
                                <strong>Error:</strong> No se recibió respuesta.
                            </div>
                        </div>
                    </div>
                `);
            }

        } catch (error) {
            $("#chatMensajes").append(`
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert">
                            <strong>Error:</strong> No se pudo procesar el mensaje.
                        </div>
                    </div>
                </div>
            `);
        }

        $("#chatMensaje").val("");

        $("#chatMensajes").scrollTop($("#chatMensajes")[0].scrollHeight);

        await cargarMensajesBD();

    } else {
        Swal.fire({
            title: "Mensaje vacío",
            text: "Por favor escriba un mensaje antes de enviarlo.",
            icon: "warning",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Aceptar"
        });
    }
});


$(document).ready(async function () {
    try {
        await initGestionPDF();
        await cargarMensajesBD();
        console.log(id_pdf);
        console.log(sourceId);
        console.log(nombre_pdf);


    } catch (error) {
        console.error("Error al inicializar la gestión del PDF:", error);
        toastr.error("Error al iniciar la gestión del PDF. Redirigiendo...", "Error", { timeOut: 5000 });
        // setTimeout(() => {
        //     window.location = "inicio";
        // }, 1000);
    }
});


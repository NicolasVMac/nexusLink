let tablaListaPdf;

tablaListaPdf = $('#tablaListaPdf').DataTable({
    columns: [
        { name: '#', data: 'id_pdf' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre_pdf_original' },
        {
            name: 'ARCHIVO', render: function (data, type, row) {
                return '<a href="' + row.ruta_pdf + '" target="_blank"><span class="badge badge-phoenix badge-phoenix-success p-2"><i class="far fa-file-excel"></i> ARCHIVO CARGADO</span></a>'
            }
        },
        { name: 'USUARIO', data: 'usuario_crea' },
        { name: 'FECHA CARGA', data: 'fecha_crea' },
    ],
    order: [[0, 'desc']],
    ajax: {
        url: 'ajax/pdfia/pdfia.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPdfCargados'
        }
    }


});


tablaListaPdf = $('#tablaListaPdfGestionar').DataTable({
    columns: [
        { name: '#', data: 'id_pdf' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre_pdf_original' },
        {
            name: 'ARCHIVO', render: function (data, type, row) {
                return '<a href="' + row.ruta_pdf + '" target="_blank"><span class="badge badge-phoenix badge-phoenix-success p-2"><i class="far fa-file-excel"></i> ARCHIVO CARGADO</span></a>'
            }
        },
        { name: 'USUARIO', data: 'usuario_crea' },
        { name: 'FECHA CARGA', data: 'fecha_crea' },
        {
            name: 'OPCION', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-success btn-sm" onclick="gestionarPdf(${row.id_pdf}, '${row.ruta_pdf}','${row.nombre_pdf}' ,'${row.id_sourceid || ''}')" title="Gestionar PDF"><i class="fas fa-check-square"></i></button>
                `;
            }
        },
    ],
    order: [[0, 'desc']],
    ajax: {
        url: 'ajax/pdfia/pdfia.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPdfCargados'
        }
    }


});

// llamar al API de ChatPDF
const llamarApiChatPdf = async (ruta_pdf) => {
    try {
        const response = await fetch("https://api.chatpdf.com/v1/sources/add-url", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "x-api-key": "sec_ZVFh61DRGTFKgpKttdU2P0AyhFF6Ia1R" // clave personal api (Santiago)
            },
            body: JSON.stringify({
                url: ruta_pdf
            })
        });

        const data = await response.json();
        return data;

    } catch (error) {
        console.error("Error al llamar a ChatPDF:", error);
        throw error;
    }
};

const gestionarPdf = (id_pdf, ruta_pdf, nombre_pdf, id_sourceid) => {
    Swal.fire({
        title: "¿Desea Gestionar el PDF?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Gestionar PDF!"
    }).then(async (result) => {

        if (result.isConfirmed) {
            if (id_sourceid && id_sourceid.trim() !== '') {
                Swal.fire({
                    title: "¡PDF procesado exitosamente!",
                    text: "Será dirigido para realizar la gestión.",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#3085d6"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'index.php?ruta=pdfia/gestionarpdf&idPDF=' + btoa(id_pdf) + '&sourceId=' + btoa(id_sourceid) + '&pdf=' + btoa(nombre_pdf);
                    }
                });
            } else {

                try {
                    console.log("URL enviada a ChatPDF:", ruta_pdf);
                    let pathPdf = ruta_pdf.replace('../../../', 'https://vidamedicalips.app/');
                    const apiResponse = await llamarApiChatPdf(pathPdf);
                    console.log("Respuesta de la API:", apiResponse);

                    if (apiResponse && apiResponse.sourceId) {
                        console.log("Respuesta satisfactoria de ChatPDF:", apiResponse);

                        let data = new FormData();
                        data.append("proceso", "actualizarSourceID");
                        data.append("sourceId", apiResponse.sourceId);
                        data.append("id_pdf", id_pdf);

                        $.ajax({
                            url: 'ajax/pdfia/pdfia.ajax.php',
                            type: 'POST',
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (respuesta) {
                                if (respuesta === 'ok') {
                                    Swal.fire({
                                        title: "¡PDF procesado exitosamente!",
                                        text: "Será dirigido para realizar la gestión.",
                                        icon: "success",
                                        confirmButtonText: "Aceptar",
                                        confirmButtonColor: "#3085d6"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location = 'index.php?ruta=pdfia/gestionarpdf&idPDF=' + btoa(id_pdf) + '&sourceId=' + btoa(apiResponse.sourceId) + '&pdf=' + btoa(nombre_pdf);
                                        }
                                    });

                                } else {
                                    Swal.fire({
                                        title: "Error en el procesamiento del PDF",
                                        text: "No se pudo procesar el archivo correctamente.",
                                        icon: "error",
                                        confirmButtonText: "Cerrar",
                                        confirmButtonColor: "#d33"
                                    });
                                }
                            },
                            error: function () {
                                Swal.fire({
                                    title: "Error en la petición AJAX",
                                    text: "Hubo un problema con la solicitud al servidor.",
                                    icon: "error",
                                    confirmButtonText: "Cerrar",
                                    confirmButtonColor: "#d33"
                                });
                            }
                        });

                    } else {
                        Swal.fire({
                            title: "Error en el procesamiento",
                            text: "Ocurrió un problema al procesar tu PDF.",
                            icon: "error",
                            confirmButtonText: "Cerrar",
                            confirmButtonColor: "#d33"
                        });
                    }

                } catch (error) {
                    Swal.fire({
                        title: "Error inesperado",
                        text: "Ocurrió un error al intentar gestionar el PDF.",
                        icon: "error",
                        confirmButtonText: "Cerrar",
                        confirmButtonColor: "#d33"
                    });
                }

            }


        }

    });
};



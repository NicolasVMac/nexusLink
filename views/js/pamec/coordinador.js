/*
1. RUTA
*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
/*
2. VARIABLES GLOBALES
*/

/*
3. FUNCIONES
*/
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
// guardar informacion general autoevaluacion

const guardarPeriodo = () => {

    let formulario = document.getElementById("formCrearPeriodoPamec");
    let elementos = formulario.elements;
    let errores = 0;
    let form = document.querySelector('#formCrearPeriodoPamec');
    let nombrePeriodo = $("#nombrePeriodo").val().trim();


    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {
        if (formulario.checkValidity()) {
            // Validación del formato
            if (!/^\d{4}-\d{4}$/.test(nombrePeriodo)) {
                toastr.warning("El nombre del periodo debe tener el formato YYYY-YYYY", "¡Atención!");
                return;
            }

            const [anioInicio, anioFin] = nombrePeriodo.split("-");
            if (parseInt(anioInicio) > parseInt(anioFin)) {
                toastr.warning("El año de inicio no puede ser mayor al de fin", "¡Atención!");
                return;
            }
            $.ajax({
                url: 'ajax/pamec/autoevaluacion.ajax.php',
                type: 'POST',
                data: {
                    proceso: 'verificarPeriodosCreacion',
                },
                dataType: "json",
                success: function (respuesta) {

                    const formData = new FormData(form);
                    formData.append('user', userSession);
                    formData.append('proceso', 'guardarPeriodoAutoevaluaciones');
                    formData.append('periodo', nombrePeriodo);

                    if (respuesta === 'ok') {

                        $.ajax({
                            url: 'ajax/pamec/autoevaluacion.ajax.php',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: "json",
                            success: function (respuesta) {

                                if (respuesta === 'ok') {
                                    Swal.fire({
                                        text: '¡El Periodo se guardó correctamente!',
                                        icon: 'success',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });

                                } else if (respuesta === 'duplicado') {

                                    Swal.fire({
                                        text: `¡Ya Existe el Periodo"${nombrePeriodo}"!`,
                                        icon: 'warning',
                                        confirmButtonText: 'Cerrar',
                                        confirmButtonColor: "#d33",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                    });

                                } else {

                                    Swal.fire({
                                        text: '¡El Periodo no se guardó correctamente!',
                                        icon: 'error',
                                        confirmButtonText: 'Cerrar',
                                        confirmButtonColor: "#d33",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                    });
                                }

                            },
                        });

                    } else {

                        Swal.fire({
                            title: `El periodo "${respuesta}" está en proceso`,
                            text: "¿Está seguro de crear un nuevo periodo? El anterior quedara Inactivo.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, crear nuevo',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33"
                        }).then(result => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: 'ajax/pamec/autoevaluacion.ajax.php',
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    dataType: "json",
                                    success: function (respuesta) {

                                        if (respuesta === 'ok') {
                                            Swal.fire({
                                                text: '¡El Periodo se guardó correctamente!',
                                                icon: 'success',
                                                confirmButtonText: 'Cerrar',
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                confirmButtonColor: "#d33"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.reload();
                                                }
                                            });

                                        } else if (respuesta === 'duplicado') {

                                            Swal.fire({
                                                text: `¡Ya Existe el Periodo"${nombrePeriodo}"!`,
                                                icon: 'warning',
                                                confirmButtonText: 'Cerrar',
                                                confirmButtonColor: "#d33",
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            });

                                        } else {

                                            Swal.fire({
                                                text: '¡El Periodo no se guardó correctamente!',
                                                icon: 'error',
                                                confirmButtonText: 'Cerrar',
                                                confirmButtonColor: "#d33",
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            });
                                        }

                                    },
                                });
                            }
                        });
                    }

                },
            });

        } else {
            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");
            return;
        }
    } else {
        toastr.warning("Errores manuales en el Formulario", "¡Atencion!");
        return;
    }



}

// const cerrarPeriodoAutoevaluacion = (id_periodo) => {
//     Swal.fire({
//         title: `¿Esta seguro de dar por Finalizado el periodo?`,
//         icon: 'question',
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         cancelButtonText: "Cancelar",
//         showCancelButton: true,
//         confirmButtonText: "¡Si!"
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $.ajax({
//                 url: 'ajax/pamec/autoevaluacion.ajax.php',
//                 type: 'POST',
//                 data: {
//                     proceso: 'activarPeriodoAutoevaluacion',
//                     idPeriodo: idPeriodo,
//                     user: userSession
//                 },
//                 dataType: 'json',
//                 success: function (respuesta) {
//                     if (respuesta === "ok") {
//                         toastr.success("Periodo activado correctamente");
//                         tablaListaPeriodos.ajax.reload(null, false);
//                     } else {
//                         toastr.error("Error al activar el periodo");
//                     }
//                 }
//             });
//         }
//     });
// }

// Activar periodo
// const activarPeriodo = (idPeriodo) => {
//     Swal.fire({
//         title: `¿Desea Activar el periodo?`,
//         icon: 'question',
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         cancelButtonText: "Cancelar",
//         showCancelButton: true,
//         confirmButtonText: "¡Si!"
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $.ajax({
//                 url: 'ajax/pamec/autoevaluacion.ajax.php',
//                 type: 'POST',
//                 data: {
//                     proceso: 'activarPeriodoAutoevaluacion',
//                     idPeriodo: idPeriodo,
//                     user: userSession
//                 },
//                 dataType: 'json',
//                 success: function (respuesta) {
//                     if (respuesta === "ok") {
//                         toastr.success("Periodo activado correctamente");
//                         tablaListaPeriodos.ajax.reload(null, false);
//                     } else {
//                         toastr.error("Error al activar el periodo");
//                     }
//                 }
//             });
//         }
//     });
// }
// // Inactivar periodo
// const inactivarPeriodo = (idPeriodo) => {
//     Swal.fire({
//         title: `¿Desea Desactivar el periodo?`,
//         icon: 'question',
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         cancelButtonText: "Cancelar",
//         showCancelButton: true,
//         confirmButtonText: "¡Si!"
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $.ajax({
//                 url: 'ajax/pamec/autoevaluacion.ajax.php',
//                 type: 'POST',
//                 data: {
//                     proceso: 'inactivarPeriodoAutoevaluacion',
//                     idPeriodo: idPeriodo,
//                     user: userSession
//                 },
//                 dataType: 'json',
//                 success: function (respuesta) {
//                     if (respuesta === "ok") {
//                         toastr.success("Periodo inactivado correctamente");
//                         tablaListaPeriodos.ajax.reload(null, false);
//                     } else {
//                         toastr.error("Error al inactivar el periodo");
//                     }
//                 }
//             });
//         }
//     });
// }

const verAutoevaluacionConsulta = (idautoevaluacion) => {

    window.location = 'index.php?ruta=pamec/verautoevaluacion&idAutoEva=' + btoa(idautoevaluacion);
}

const consultarAutoevaluacion = () => {

    const cardResultado = document.querySelector("#cardResultadoConsultarAutoevaluacion");

    let formulario = document.getElementById("formConsultarAutoevaluaciones");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()) {

            cardResultado.style.display = 'block';

            let form = document.querySelector('#formConsultarAutoevaluaciones');
            const formData = new FormData(form);
            formData.append('proceso', 'consultarAutoevaluaciones');

            for (const [key, value] of formData) {
                console.log(key, value);
            }

            let tablaResultadoConsultarAutoevaluacion = $('#tablaResultadoConsultarAutoevaluacion').DataTable({

                columns: [
                    { name: '#', data: 'id_autoevaluacion' },
                    { name: 'GRUPO', data: 'grupo' },
                    { name: 'SUB GRUPO', data: 'subgrupo' },
                    { name: 'ESTANDAR', data: 'codigo' },
                    { name: 'PERIODO', data: 'periodo_autoevaluacion' },
                    {
                        name: 'Sede',
                        orderable: false,
                        render: function (data, type, row) {
                            if (!row.sede) return '';
                            let sedesArr = row.sede.split('-');
                            let badges = sedesArr.map((sede) => {
                                let sedeTrim = sede.trim();
                                return `<span class="badge badge-phoenix fs--2 badge-phoenix-info me-1"><span class="badge-label">${sedeTrim}</span></span>`;
                            }).join('');
                            return badges;
                        }
                    },
                    {
                        name: 'ACCIONES', render: function (data, type, row) {
                            return `
                                <button title='ver autoevaluacion' title="Ver Autoevaluacion" type="button" class="btn btn-info btn-sm" onclick="verAutoevaluacionConsulta(${row.id_autoevaluacion})"><i class="fas fa-eye"></i></button>
                                `;
                        }
                    },
                ],
                ordering: false,
                dom: 'Bfrtip',
                destroy: true,
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ],
                ajax: {
                    url: 'ajax/pamec/autoevaluacion.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'consultarAutoevaluaciones',
                        'selectPeriodoAutoevaluacion': formData.get('selectPeriodoAutoevaluacion'),
                        'grupo': formData.get('grupo'),
                        'subGrupo': formData.get('subGrupo'),
                        'estandar': formData.get('estandar'),
                        'selSedesPamec': formData.get('selSedesPamec')
                    },
                }

            })

        } else {

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }

    }

}






/*
4. TABLAS
*/

tablaListaPeriodos = $('#tablaListaPeriodos').DataTable({
    columns: [
        { name: '#', data: 'id_periodo' },
        {
            name: 'Periodo', orderable: false, render: function (data, type, row) {

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-info"><span class="badge-label">${row.periodo}</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span>`;
            }
        },
        {
            name: 'Estado', orderable: false, render: function (data, type, row) {
                newEstado = '';
                if (row.seleccionado === '0') {
                    newEstado = 'Inactivo';
                    return `<span class="badge badge-phoenix fs--2 badge-phoenix-danger"><span class="badge-label">${newEstado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;
                } else {
                    newEstado = 'Activo';
                    return `<span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label">${newEstado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;
                }
            }
        },
        { name: 'Usuario Crea', data: 'usuario_crea' },
        { name: 'Fecha Crea', data: 'fecha_crea' },
        // {
        //     name: 'Estado', orderable: false, render: function (data, type, row) {
        //         newEstado = '';
        //         if (row.estado === 'PROCESO') {
        //             return `<span class="badge badge-phoenix fs--2 badge-phoenix-info"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;
        //         } else {
        //             return `<span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;
        //         }
        //     }
        // },
        // {
        //     name: 'Opcion', orderable: false, render: function (data, type, row) {
        //         newEstado = '';
        //         if (row.estado === 'PROCESO') {

        //             return `
        //             <div class="btn-group btn-group-sm" role="group" aria-label="...">
        //                 <button class="btn btn-phoenix-success" onclick="cerrarPeriodoAutoevaluacion(${row.id_periodo})" title="Finalizar Periodo"><i class="far fa-check-square"></i></button>
        //             </div>
        //         `;
        //         }
        //     }
        // },
    ],
    order: [[0, 'desc']],
    ajax: {
        url: 'ajax/pamec/autoevaluacion.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPeriodosAutoevaluacionPamec'
        }
    }
});



/*
5. document.ready
*/
$(document).ready(async () => {

});


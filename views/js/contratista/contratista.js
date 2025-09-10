let tablaListaContratistas;

const resetFormulario = (formulario) => {

    const form = document.querySelector(`#${formulario}`);
    form.reset();

}

const validarExisteContratista = async (tipoDocumentoContratista, numeroDocumentoContratista) => {

    let datos = new FormData();
    datos.append('proceso', 'validarExisteContratista');
    datos.append('numeroDoc', numeroDocumentoContratista);
    datos.append('tipoDoc', tipoDocumentoContratista);


    const validacion = await $.ajax({
        url: 'ajax/contratistas/contratistas.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    return validacion;

}

const cargarModal = () => {
    let modal = new bootstrap.Modal(document.getElementById('modalAgregarContratista'));
    modal.show();

    $.ajax({
        type: "POST",
        url: "ajax/contratistas/contratistas.ajax.php",
        data: {
            'proceso': 'listaTipoContratista'
        },
        success: function (respuesta) {
            $("#tipoContratista").html(respuesta);
        }
    });

    $.ajax({
        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaTipoDocumento'
        },
        success: function (respuesta) {
            $("#tipoDocumentoContratista").html(respuesta);
        }
    });

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaDepartamentos'
        },
        success: function (respuesta) {

            $("#departamentoContratista").html(respuesta);

        }

    })

    $("#departamentoContratista").change(function () {

        let departamento = $(this).val();

        $.ajax({

            type: "POST",
            url: "ajax/parametricas.ajax.php",
            data: {
                'lista': 'listaMunicipiosDepartamento',
                'departamento': departamento
            },
            success: function (respuesta) {

                $("#ciudadContratista").html(respuesta);

            }

        })

    })

}

const agregarContratista = async () => {

    let formulario = document.getElementById("formAgregarContratista");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()) {

            let form = document.querySelector('#formAgregarContratista');

            const formData = new FormData(form);

            formData.append('proceso', 'crearContratista');
            formData.append('userCreate', userSession);
            for (const [key, value] of formData) {
                console.log(key, value);
            }
            let tipoDocumentoContratista = formData.get('tipoDocumentoContratista');
            let numeroDocumentoContratista = formData.get('numeroDocumentoContratista');


            let validacionContratista = await validarExisteContratista(tipoDocumentoContratista, numeroDocumentoContratista);

            if (validacionContratista === 'no-existe') {

                Swal.fire({
                    title: "¿Desea Crear el Contratista?",
                    icon: 'info',
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    showCancelButton: true,
                    confirmButtonText: "¡Si, Crear Contratista!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'ajax/contratistas/contratistas.ajax.php',
                            type: 'POST',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function (respuesta) {

                                if (respuesta == 'ok') {

                                    Swal.fire({

                                        text: '¡El Contratista se Creo correctamente!',
                                        icon: 'success',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33",

                                    }).then((result) => {

                                        if (result.isConfirmed) {

                                            tablaListaContratistas.ajax.reload();
                                            window.location.reload();
                                            resetFormulario('formAgregarContratista');
                                        }

                                    })

                                } else {

                                    Swal.fire({
                                        text: 'El Contratista no se Creo correctamente',
                                        icon: 'error',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33"
                                    })

                                    window.location.reload();


                                }

                            }

                        })

                    }

                })

            } else {

                Swal.fire({
                    text: '¡El Contratista ya se encuestra registrado!',
                    icon: 'error',
                    confirmButtonText: 'Cerrar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonColor: "#d33"
                })

            }


        } else {

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }


}

const eliminarContratista = (id_contratistas) => {

    Swal.fire({
        title: "¿Desea Eliminar el Contratista?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar Contratista!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'ajax/contratistas/contratistas.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarContratista',
                    'idContratista': id_contratistas
                },
                dataType: 'json',
                success: function (respuesta) {

                    if (respuesta == 'ok') {

                        Swal.fire({

                            text: '¡El Contratista se Elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) => {

                            if (result.isConfirmed) {
                                window.location.reload();
                            }

                        })

                    } else {

                        Swal.fire({
                            text: 'El Contratista no se Elimino correctamente',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                        window.location.reload();


                    }

                }

            })

        }

    })










}

tablaListaContratistas = $('#tablaListaContratistas').DataTable({

    columns: [
        { name: '#', data: 'id_contratistas' },
        {
            name: 'TIPO', orderable: false, render: function (data, type, row) {
                return `${row.tipo_contratistas} - ${row.descripcionTipoContratista}`;
            }
        },
        { name: 'NOMBRE CONTRATISTA', data: 'nombre_contratistas' },
        {
            name: 'TIPO IDENTIFICACION', orderable: false, render: function (data, type, row) {
                return `${row.tipo_identi_contratistas} - ${row.descripcionDoc}`;
            }
        },
        {
            name: 'NUMERO IDENTIFICACION', orderable: false, render: function (data, type, row) {
                return `${row.numero_identi_contratistas}`;
            }
        },
        { name: 'NATURALEZA', data: 'naturaleza' },

        { name: 'DIRECCION', data: 'direccion_contratistas' },
        { name: 'TELEFONO', data: 'telefono_contratistas' },
        { name: 'DEPARTAMENTO', data: 'departamento' },
        { name: 'CIUDAD', data: 'ciudad' },
        { name: 'CORREO', data: 'correo' },
        {
            name: 'ESTADO',
            orderable: false,
            render: function (data, type, row) {
                if (row.estado == 1) {
                    return `<span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label">ACTIVO</span></span>`;
                } else {
                    return `<span class="badge badge-phoenix fs--2 badge-phoenix-danger"><span class="badge-label">INACTIVO</span></span>`
                }
            }
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                if(row.estado == 1){
                    return `
                    <!--<button type="button" class="btn btn-primary btn-sm m-1" onclick="mostrarInformacionEdicionProyecto('${row.id_contratistas}')" title="Ver Contratista"><i class="fas fa-pencil"></i></button>-->
                    <button type="button" class="btn btn-danger btn-sm m-1" onclick="eliminarContratista('${row.id_contratistas}')" title="Eliminar Contratista"><i class="fas fa-trash"></i></button>
                    <button type="button" class="btn btn-success btn-sm" onclick="irGestionContratos(${row.id_contratistas})" title="Gestionar Contratos"><i class="far fa-folder"></i></button>
                    `;
                }else{
                    return ``;
                }
                

            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/contratistas/contratistas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaContratistas',
        }
    }

})

const irGestionContratos = (id_contratistas) => {

    window.location = 'index.php?ruta=contratistas/gestionarcontratos&idContratista='+btoa(id_contratistas);
}




$(document).on('shown.bs.modal', '.modal', function () {
    const $m = $(this);
    $m.find('.select-field').each(function () {
        const $s = $(this);
        if ($s.data('select2')) $s.select2('destroy');
        $s.select2({ theme: 'bootstrap-5', width: '100%', dropdownParent: $m });
    });
});


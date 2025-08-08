let tablaAdminProyectos;

const resetFormulario = (formulario) => {

    const form = document.querySelector(`#${formulario}`);
    form.reset();

}

const validarExistePrefijoProyecto = async (prefijoProyecto) => {

    let datos = new FormData();
    datos.append('proceso','validarExistePrefijoProyecto');
    datos.append('prefijoProyecto', prefijoProyecto);

    const validacion = await $.ajax({
        url: 'ajax/correspon/proyectos.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    return validacion;

}


const crearProyecto = async () => {

    let formulario = document.getElementById("formAgregarProyectoCorrespondencia");
    let elementos = formulario.elements;
    let errores = 0;

    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if(errores === 0){

        if (formulario.checkValidity()){

            let form = document.querySelector('#formAgregarProyectoCorrespondencia');

            const formData = new FormData(form);

            formData.append('proceso', 'crearProyecto');
            formData.append('userCreate', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            const prefijoProyecto = formData.get('prefijoProyecto');

            const validacionPrefijo = await validarExistePrefijoProyecto(prefijoProyecto);

            if(validacionPrefijo === 'no-existe'){

                Swal.fire({
                    title: "¿Desea Crear el Proyecto?",
                    icon: 'info',
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    showCancelButton: true,
                    confirmButtonText: "¡Si, Crear Proyecto!"
                }).then((result) => {
            
                    if(result.isConfirmed){

                        $.ajax({

                            url: 'ajax/correspon/proyectos.ajax.php',
                            type: 'POST',
                            data: formData,
                            cache:false,
                            contentType: false,
                            processData: false,
                            success:function(respuesta){
            
                                if(respuesta == 'ok'){
            
                                    Swal.fire({

                                        text: '¡El Proyecto se creo correctamente!',
                                        icon: 'success',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33",
            
                                    }).then((result) =>{
            
                                        if(result.isConfirmed){
                                            
                                            tablaAdminProyectos.ajax.reload();
                                            resetFormulario('formAgregarProyectoCorrespondencia');
                                            $('#responsablesProyectos').val('').trigger('change');
            
                                        }
            
                                    })
            
                                }else{
            
                                    Swal.fire({
                                        text: 'El Proyecto no creo correctamente',
                                        icon: 'error',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33"
                                    })
            
            
                                }
                                
                            }
            
                        })

                    }

                })

            }else{

                Swal.fire({
                    text: '¡El Prefijo del Proyecto ya se encuestra registrado!',
                    icon: 'error',
                    confirmButtonText: 'Cerrar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonColor: "#d33"
                })

            }


        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }


}

const mostrarInformacionEdicionProyecto = (idProyecto) => {

    let cardEdicionProyecto = document.querySelector('#cardEditarProyectoCorrespondencia');
    cardEdicionProyecto.style.display = 'block';

    let datos = new FormData();
    datos.append('proceso', 'obtenerInfoProyecto');
    datos.append('idProyecto', idProyecto);

    $.ajax({
        url: 'ajax/correspon/proyectos.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(respuesta){

            $("#editIdProyecto").val(respuesta["id_proyecto"]);
            $("#editarNombreProyecto").val(respuesta["nombre_proyecto"]);
            $("#editarPrefijoProyecto").val(respuesta["prefijo_proyecto"]);

            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaResponsablesProyectosCorrespondencia'
                },
            }).done(function (responsables) {
            
                $("#editarResponsablesProyectos").html(responsables);
                $("#editarResponsablesProyectos").val(respuesta.id_usuario_responsable);
            
            })

        }

    })

}

const editarProyecto = () => {

    let formulario = document.getElementById("formEditarProyectoCorrespondencia");
    let elementos = formulario.elements;
    let errores = 0;

    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if(errores === 0){

        if (formulario.checkValidity()){

            let form = document.querySelector('#formEditarProyectoCorrespondencia');

            const formData = new FormData(form);

            formData.append('proceso', 'editarProyecto');
            formData.append('userSession', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }


            Swal.fire({
                title: "¿Desea Guardar el Proyecto?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si, Guardar Proyecto!"
            }).then((result) => {
        
                if(result.isConfirmed){

                    $.ajax({

                        url: 'ajax/correspon/proyectos.ajax.php',
                        type: 'POST',
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(respuesta){
        
                            if(respuesta == 'ok'){
        
                                Swal.fire({

                                    text: '¡El Proyecto se guardo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33",
        
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
                                        
                                        tablaAdminProyectos.ajax.reload();
                                        resetFormulario('formEditarProyectoCorrespondencia');
                                        $('#editarResponsablesProyectos').val('').trigger('change');
                                        let cardEdicionProyecto = document.querySelector('#cardEditarProyectoCorrespondencia');
                                        cardEdicionProyecto.style.display = 'none';

                                    }
        
                                })
        
                            }else{
        
                                Swal.fire({
                                    text: 'El Proyecto no guardo correctamente',
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                })
        
        
                            }
                            
                        }
        
                    })

                }

            })


        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}


tablaAdminProyectos = $('#tablaAdminProyectos').DataTable({

    columns: [
        { name: '#', data: 'id_proyecto' },
        { name: 'PROYECTO', data: 'nombre_proyecto' },
        { name: 'PREFIJO PROYECTO', data: 'prefijo_proyecto' },
        { name: 'CONSECUTIVO', data: 'numero_consecutivo' },
        { name: 'RESPONSABLE', orderable: false, render: function (data, type, row) {
            return `${row.nombre} - ${row.usuario}`;
        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-primary btn-sm" onclick="mostrarInformacionEdicionProyecto('${row.id_proyecto}')" title="Editar Proyecto"><i class="fas fa-pencil"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/correspon/proyectos.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaProyectosCorrespondencia',
        }
    }

})
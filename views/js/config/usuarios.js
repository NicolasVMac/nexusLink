/*==============================
VARIABLES DE RUTA
==============================*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

var idUsuario = atob(getParameterByName('idUsuario'));

let tableUsuarios;


$.ajax({

    url: 'ajax/config/users.ajax.php',
    type: 'POST',
    data: {
        'lista': 'selectMenus'
    },
    success:function(respuesta){
    
        // console.log(respuesta);

        $('#selectMenus').select2('destroy');
        $("#contenedorSelectMenus").html(respuesta);
        $('#selectMenus').select2();

    }

})

// $.ajax({

//     url: 'ajax/config/users.ajax.php',
//     type: 'POST',
//     data: {'lista':'listaProyectos'},
//     cache: false,
//     dataType: "json",
//     success:function(respuestaProyectos){

//         //console.log(respuestaProyectos);
//         let cadena = ``;
//         let arrayProyectos = respuestaProyectos;

//         arrayProyectos.forEach(proyecto => {

//             //console.log(proyecto);

//             let datos = new FormData();
//             datos.append('lista', 'menusProyecto')
//             datos.append('idProyecto', proyecto["id_proyecto"]);

//             $.ajax({

//                 url: 'ajax/config/users.ajax.php',
//                 type: 'POST',
//                 data: datos,
//                 cache: false,
//                 contentType: false,
//                 processData: false,
//                 dataType: "json",
//                 success:function(respuestaMenus){


//                     let menus = respuestaMenus;

//                     menus.forEach(menu => {

//                         console.log(menu);

//                         cadena += `<div class="form-check">
//                             <input class="form-check-input" id="${menu.menu}Check${menu.id_menu}" type="checkbox" value="${menu.id_menu}"/>
//                             <label class="form-check-label" for="${menu.menu}Check${menu.id_menu}">${menu.menu} (${menu.descripcion}) - ${menu.proyecto}</label>
//                         </div>`;


//                     })

//                     $("#contenedorMenusProyecto").html(cadena);


//                 }

//             })


            

//         });

        

//     }

// })

/*=======================================
ACCORDION DE MENUS
=======================================*/

// $.ajax({
//     url: 'ajax/config/users.ajax.php',
//     type: 'POST',
//     data: {'lista':'listaProyectos'},
//     cache: false,
//     dataType: "json",
//     success: async function(respuestaProyectos){
//         let cadenaAccordion = ``;
//         let arrayProyectos = respuestaProyectos;

//         cadenaAccordion += `<div class="accordion" id="accordionExample">`;

//         // Function to fetch menus for a project
//         async function fetchMenusForProject(proyecto) {
//             let datos = new FormData();
//             datos.append('lista', 'menusProyecto');
//             datos.append('idProyecto', proyecto.id_proyecto);

//             try {
//                 const respuestaMenus = await $.ajax({
//                     url: 'ajax/config/users.ajax.php',
//                     type: 'POST',
//                     data: datos,
//                     cache: false,
//                     contentType: false,
//                     processData: false,
//                     dataType: "json"
//                 });
//                 return respuestaMenus;
//             } catch (error) {
//                 console.error("Error fetching menus:", error);
//                 return [];
//             }
//         }

//         for (const proyecto of arrayProyectos) {
//             cadenaAccordion += `<div class="accordion-item">
//                 <h2 class="accordion-header" id="heading${proyecto.id_proyecto}">
//                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor${proyecto.id_proyecto}" aria-expanded="false" aria-controls="accor${proyecto.id_proyecto}">
//                     ${proyecto.proyecto}
//                     </button>
//                 </h2>
//                 <div class="accordion-collapse collapse" id="accor${proyecto.id_proyecto}" aria-labelledby="heading${proyecto.id_proyecto}" data-bs-parent="#accordionExample">
//                     <div class="accordion-body pt-0">`;

//             const respuestaMenus = await fetchMenusForProject(proyecto);

//             for (const menu of respuestaMenus) {
//                 cadenaAccordion += `<div class="form-check form-check-inline">
//                     <input class="form-check-input" id="${menu.menu}Check${menu.id_menu}" type="checkbox" value="${menu.id_menu}"/>
//                     <label class="form-check-label" for="${menu.menu}Check${menu.id_menu}">${menu.menu} (${menu.descripcion})</label>
//                 </div>`;
//             }

//             cadenaAccordion += `</div></div></div>`;
//         }

//         cadenaAccordion += `</div>`;
//         $("#contenedorMenusProyecto").html(cadenaAccordion);
//     }
// });

function menusProyecto(){

    let proyecto = document.getElementById("proyectos").value;

    let datos = new FormData();
    datos.append("lista", "listaProyectos");
    //datos.append("idProyecto", proyecto);

    $.ajax({

        url: 'ajax/config/users.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
        success:function(respuesta){

            console.log(respuesta);
            
            // console.log(respuesta);

            // let cadena = ``;
            // let arrayMenus = respuesta;

            // arrayMenus.forEach((menu) => {

            //     cadena += `<div class="form-check form-check-inline">
            //         <input class="form-check-input" id="${menu.menu}Check${menu.id_menu}" type="checkbox" value="${menu.id_menu}"/>
            //         <label class="form-check-label" for="${menu.menu}Check${menu.id_menu}">${menu.menu} (${menu.descripcion})</label>
            //     </div>`;

            // })

            // $("#contenedorMenusProyecto").html(cadena);

            // let valoresSeleccionados = [];

            // // Manejar clic en los checkboxes
            // $("input[type='checkbox']").on('change', function () {
            //     let valorSeleccionado = $(this).val();

            //     // Verificar si el checkbox está marcado o desmarcado
            //     if ($(this).prop("checked")) {
            //         // Agregar el objeto al array
            //         valoresSeleccionados.push(valorSeleccionado);
            //     } else {
            //         // Eliminar del array si está desmarcado
            //         valoresSeleccionados = valoresSeleccionados.filter(item => item !== valorSeleccionado);
            //     }

            //     // Imprimir el array en la consola
            //     console.log(valorSeleccionado);
            //     console.log(valoresSeleccionados);

            // });

        }

    })

}

const crearUsuario = () => {

    let formulario = document.getElementById("formAgregarUsuario");
    let elementos = formulario.elements;
    let errores = 0;

    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('form');

            //console.log(form);

            const formData = new FormData(form);

            let selectMenu = document.getElementById('selectMenus');

            let menusSeleccionados = [];

            for(let i = 0; i < selectMenu.options.length; i++){

                let option = selectMenu.options[i];

                if(option.selected){

                    menusSeleccionados.push(option.value);

                }

            }

            formData.append('lista', 'crearUsuario');
            formData.append('menus', menusSeleccionados);

            // for(const [key, value] of formData){

            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/config/users.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta === 'usuario-permisos-creado'){

                        Swal.fire({
                            text: '¡El Usuario se creo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=config/usuarios';

                            }

                        })

                    }else if(respuesta === 'usuario-existe'){

                        Swal.fire({
                            title: 'Error!',
                            text: '¡El Usuario ya existe!',
                            icon: 'error',
                            confirmButtonColor: "#d33",
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })

                        $("#usuarioNuevo").val('');


                    }else if(respuesta === 'error-creando-permisos'){

                        Swal.fire({
                            title: 'Error!',
                            text: 'El Usuario no se guardo los permisos correctamente',
                            icon: 'error',
                            confirmButtonColor: "#d33",
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })

                    }else if(respuesta === 'no-existe-usuario'){

                        Swal.fire({
                            title: 'Error!',
                            text: 'El Usuario no existe en la base de datos',
                            icon: 'error',
                            confirmButtonColor: "#d33",
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })

                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: 'El Usuario no se creo correctamente',
                            icon: 'error',
                            confirmButtonColor: "#d33",
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "Error!");

        }

    }


}

const editarUsuario = () => {

    let formulario = document.getElementById("formEditarUsuario");
    let elementos = formulario.elements;
    let errores = 0;

    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('form');

            const formData = new FormData(form);

            let selectMenu = document.getElementById('selectMenus');

            let menusSeleccionados = [];

            for(let i = 0; i < selectMenu.options.length; i++){

                let option = selectMenu.options[i];

                if(option.selected){

                    menusSeleccionados.push(option.value);

                }

            }

            formData.append('lista', 'editarUsuario');
            formData.append('menus', menusSeleccionados);

            // for(const [key, value] of formData){

            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/config/users.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta === 'usuario-permisos-editado'){

                        Swal.fire({
                            text: '¡El Usuario se modifico correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=config/usuarios';

                            }

                        })

                    }else if(respuesta === 'error-creando-permisos'){

                        Swal.fire({
                            title: 'Error!',
                            text: 'El Usuario no se guardo los permisos correctamente',
                            icon: 'error',
                            confirmButtonColor: "#d33",
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })

                    }else if(respuesta === 'error-eliminando-menus'){

                        Swal.fire({
                            title: 'Error!',
                            text: 'No se pudieron eliminar los permisos del Usuario',
                            icon: 'error',
                            confirmButtonColor: "#d33",
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })

                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: 'El Usuario no se logro modificar correctamente',
                            icon: 'error',
                            confirmButtonColor: "#d33",
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "Error!");

        }

    }



}

const redireccionEditarUsuario = (idUsuario) => {

    window.location = 'index.php?ruta=config/editarusuario&idUsuario='+btoa(idUsuario);   


}

tableUsuarios = $('#tableUsuarios').DataTable({
    columns: [
        { name: 'ID', data: 'id' },
        { name: 'NOMBRE', data: 'nombre' },
        { name: 'USUARIO', data: 'usuario' },
        { name: 'NUMERO DOCUMENTO', data: 'documento', render: $.fn.dataTable.render.number('.', ',', 0, '') },
        { name: 'TELEFONO', data: 'telefono' },
        { name: 'CORREO', data: 'mail' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-sm btn-primary" onclick="redireccionEditarUsuario(${row.id})" title="Editar Usuario"><i class="fa-solid fa-user-pen"></i></button>`;
            }
        }
    ],
    ajax: {
        url: 'ajax/config/users.ajax.php',
        type: 'POST',
        data: {
            'lista': 'listaUsuarios',
            'user': userSession
        }
    }
    

});

if(idUsuario){

    let formData = new FormData();

    formData.append('lista', 'infoUsuario');
    formData.append('idUsuario', idUsuario);

    $.ajax({

        url: 'ajax/config/users.ajax.php',
        type: 'POST',
        data: formData,
        cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
        success:function(respuesta){

            // console.log(respuesta);

            $("#editarIdUsuario").val(respuesta["id"]);
            $("#editarNombre").val(respuesta["nombre"]);
            $("#editarNumDocUsuario").val(respuesta["documento"]);
            $("#editarUsuarioTxt").val(respuesta["usuario"]);
            $("#passwordAntiguo").val(respuesta["password"]);
            $("#editarTelefono").val(respuesta["telefono"]);
            $("#editarCorreo").val(respuesta["mail"]);


            $.ajax({

                url: 'ajax/config/users.ajax.php',
                type: 'POST',
                data: {
                    'lista': 'selectMenusUsuario',
                    'usuario': respuesta["usuario"]
                },
                success:function(respuesta){
                
                    // console.log(respuesta);
            
                    $('#selectMenus').select2('destroy');
                    $("#contenedorSelectMenusUpdate").html(respuesta);
                    $('#selectMenus').select2();
            
                }
            
            })


        }

    })

}
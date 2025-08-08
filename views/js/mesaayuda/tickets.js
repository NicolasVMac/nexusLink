/*==============================
VARIABLES DE RUTA
==============================*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
let idTicket = atob(getParameterByName('idTicket'));
let rolUsuario = atob(getParameterByName('rolUsuario'));
let idUserSession = document.getElementById("idUserSession").value;
let tablaMisTickets, tablaBolsaTickets, tablaTicketPendienteGestion;
let meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
let dias = {'Monday':'Lunes', 'Tuesday':'Martes', 'Wednesday':'Miercoles', 'Thursday':'Jueves', 'Friday':'Viernes', 'Saturday':'Sabado', 'Sunday':'Domingo'};

/*================================
SUBIR IMAGENES TICKET
================================*/
ClassicEditor
.create( document.querySelector('.editor'),{
    ckfinder:{
        uploadUrl: 'ajax/mesaayuda/tickets.ajax.php'
    }
})
.then(editor =>{
    //console.log(editor);
})
.catch( error => {
    //console.error( error );
} );

function crearTicket(){

    let proyectoTicket = document.getElementById("proyectoTicket").value;
    let prioridadTicket = document.getElementById("prioridadTicket").value;
    let asuntoTicket = document.getElementById("asuntoTicket").value;
    let idUsuario = document.getElementById("idUsuarioCreaTicket").value;
    let archivosTickets = document.getElementById("archivosTicket");


    if(idUsuario && asuntoTicket && proyectoTicket && prioridadTicket){

        Swal.fire({
            title: "¿Desea crear el Ticket?",
            icon: 'info',
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "No, Crear Ticket",
            showCancelButton: true,
            confirmButtonText: "Crear Ticket"
        }).then((result) => {

            if (result.isConfirmed) {

                let descripcionTicket = document.querySelector('textarea[name="descripcionTicket"]');

                descripcionTicket = descripcionTicket.value;

                //console.log(descripcionTicket)

                //window.location = 'index.php?ruta=config/pacientes';

                //Swal.fire("Saved!", "", "success");

                if(descripcionTicket){

                    let data = new FormData();

                    data.append("proceso", "crearTicket");

                    for(let file of archivosTickets.files){

                        data.append('archivosTicket[]', file);

                    }

                    data.append("idProyecto", proyectoTicket);
                    data.append("idUsuarioTicket", idUsuario);
                    data.append("asuntoTicket", asuntoTicket);
                    data.append("prioridadTicket", prioridadTicket);
                    data.append("descripcionTicket", descripcionTicket);
                    data.append("usuarioCrea", userSession);


                    $.ajax({

                        url: 'ajax/mesaayuda/tickets.ajax.php',
                        type: 'POST',
                        data: data,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(respuesta){
                        
                            //console.log(respuesta);

                            if(respuesta === 'ok'){

                                Swal.fire({

                                    text: '¡El Ticket se creo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33",
        
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=mesaayuda/mistickets';
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    title: 'Error!',
                                    text: '¡El Ticket no se creo correctamente!',
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                })

                            }

                        }

                    })

                }else{

                    toastr.warning("Debe agregar la descripcion del Ticket.", "Error!");

                }

            }

        });

    }else{

        toastr.warning("Debe diligenciar todos los campos del formulario Crear Ticket.", "Error!");

    }


}

function verTicket(idTicket, rolUsuario){

    window.location = 'index.php?ruta=mesaayuda/verticket&idTicket='+btoa(idTicket)+'&rolUsuario='+btoa(rolUsuario);


}

function tomarTicket(idTicket,rolUsu){

    let idUserSession = document.getElementById("idUserSession").value;

    if(rolUsuario == ''){

        rolUsuario = rolUsu

    }

    //console.log(rolUsuario);

    Swal.fire({
        title: "¿Desea Gestionar el Ticket?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Gestionar Ticket!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/mesaayuda/tickets.ajax.php',
                type: 'POST',
                data: {
                    'proceso':'tomarTicket',
                    'idTicket':idTicket,
                    'user':userSession,
                    'idUser':idUserSession,
                    'rolUsuario':rolUsuario
                },
                success:function(respuesta){
                    
                    if(rolUsuario == 'SOPORTE'){

                        switch (respuesta) {
                            case 'ok-asignado':

                                Swal.fire({

                                    text: '¡El Ticket se asigno correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33",
        
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=mesaayuda/gestionarticket&idTicket='+btoa(idTicket)+'&rolUsuario='+btoa(rolUsuario);
        
                                    }
        
                                })

                                break;

                            case 'ok-asignado-usuario':

                                window.location = 'index.php?ruta=mesaayuda/gestionarticket&idTicket='+btoa(idTicket)+'&rolUsuario='+btoa(rolUsuario);

                                break;
                            
                            case 'ok-ya-asignado':

                                Swal.fire({

                                    text: '¡El Ticket ya fue asignado!',
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33",
        
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=mesaayuda/bolsatickets';
        
                                    }
        
                                })

                                break;

                            case 'error-soporte':
                                
                                Swal.fire({

                                    text: '¡Error al Asignar el Ticket!',
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33",
        
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=mesaayuda/bolsatickets';
        
                                    }
        
                                })

                                break;
                        
                        }

                    }

                }

            })

        }

    });

}

function gestionarTicket(idTicket, rolUsuario){

    window.location = 'index.php?ruta=mesaayuda/gestionarticket&idTicket='+btoa(idTicket)+'&rolUsuario='+btoa(rolUsuario);

}


function agregarSeguimiento(){

    let archivosTickets = document.getElementById("archivosTicket");

    let descripcionTicket = document.querySelector('textarea[name="descripcionTicket"]');

    // console.log(descripcionTicket.value)

    Swal.fire({
        title: "¿Desea agregar el Seguimiento?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "No, Agregar",
        showCancelButton: true,
        confirmButtonText: "Si Agregar"
    }).then((result) => {

        if (result.isConfirmed) {

            descripcionTicket = descripcionTicket.value;

            if(descripcionTicket){

                let data = new FormData();

                data.append("proceso", "agregarSeguimiento");

                for(let file of archivosTickets.files){

                    data.append('archivosTicket[]', file);

                }

                //console.log(idUserSession);

                data.append("idTicket", idTicket);
                data.append("idUser", idUserSession);
                data.append("descripcionTicket", descripcionTicket);
                data.append("usuarioCrea", userSession);
                data.append("rolUsuario", rolUsuario);

                $.ajax({

                    url: 'ajax/mesaayuda/tickets.ajax.php',
                    type: 'POST',
                    data: data,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){
                  
                        //console.log(respuesta);

                        Swal.fire({

                            text: '¡El Seguimiento se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=mesaayuda/gestionarticket&idTicket='+btoa(idTicket)+'&rolUsuario='+btoa(rolUsuario);

                            }

                        })

                    }

                })

            }else{

                toastr.warning("Debe agregar la descripcion del Seguimiento.", "Error!");

            }

        }

    })

}

function terminarTicket(){

    let archivosTickets = document.getElementById("archivosTicket");
    let descripcionTicket = document.querySelector('textarea[name="descripcionTicket"]');

    Swal.fire({
        title: "¿Desea Terminar el Ticket?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Terminar!"
    }).then(async (result) => {

        //console.log(descripcionTicket.value);

        if (result.isConfirmed) {

            const inputOptions = new Promise((resolve) => {
                resolve({
                    "SOPORTE": "SOPORTE",
                    "DESARROLLO": "DESARROLLO"
                });
            });
            const { value: tipoSolucion } = await Swal.fire({
                text: "Seleccione el Tipo de Solucion realizada:",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Terminar!",
                allowOutsideClick: false,
                allowEscapeKey: false,
                input: "radio",
                inputOptions,
                inputValidator: (value) => {
                    if (!value) {
                        return "¡Para Terminar el Ticket debe seleccionar el Tipo Solucion realizada!";
                    }
                }
            });
            if(tipoSolucion){

                descripcionTicket = descripcionTicket.value;

                //console.log(descripcionTicket);

                if(descripcionTicket){

                    let data = new FormData();

                    data.append("proceso", "agregarSeguimiento");

                    for(let file of archivosTickets.files){

                        data.append('archivosTicket[]', file);

                    }

                    //console.log(idUserSession);

                    data.append("idTicket", idTicket);
                    data.append("idUser", idUserSession);
                    data.append("descripcionTicket", descripcionTicket);
                    data.append("usuarioCrea", userSession);
                    data.append("rolUsuario", rolUsuario);

                    $.ajax({

                        url: 'ajax/mesaayuda/tickets.ajax.php',
                        type: 'POST',
                        data: data,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(respuesta){
                        
                            //console.log("Guardado Seguimiento: ", respuesta);

                        }

                    })

                    /*===================================
                    TERMINAR TICKET - PRE_REALIZADO
                    ===================================*/
                    $.ajax({

                        url: 'ajax/mesaayuda/tickets.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso':'terminarTicket',
                            'idTicket':idTicket,
                            'tipoSolucion':tipoSolucion
                        },
                        success:function(respuestaTerminar){
                            
                            //console.log("Terminar Ticket: ", respuestaTerminar);

                            Swal.fire({

                                text: '¡El Ticket se Termino correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33",

                            }).then((result) =>{

                                if(result.isConfirmed){

                                    window.location = 'index.php?ruta=mesaayuda/ticketspendientegestion';

                                }

                            })

                        }

                    })

                }else{

                    if(archivosTickets.files.length != 0){

                        toastr.warning("Si va a cargar documentos debe digitar una Descripcion del Seguimiento.", "Error!");
                        
                    }else{

                        /*===================================
                        TERMINAR TICKET - PRE_REALIZADO
                        ===================================*/
                        $.ajax({

                            url: 'ajax/mesaayuda/tickets.ajax.php',
                            type: 'POST',
                            data: {
                                'proceso':'terminarTicket',
                                'idTicket':idTicket,
                                'tipoSolucion':tipoSolucion
                            },
                            success:function(respuestaTerminar){
                                
                                //console.log("Terminar Ticket: ", respuestaTerminar);

                                Swal.fire({

                                    text: '¡El Ticket se Termino correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33",

                                }).then((result) =>{

                                    if(result.isConfirmed){

                                        window.location = 'index.php?ruta=mesaayuda/ticketspendientegestion';

                                    }

                                })
            
                            }
            
                        })


                    }

                }


            }else{

                Swal.fire({ 
                    icon:'warning',
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Cerrar",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    html: `¡Para Terminar el Ticket debe seleccionar el Tipo Solucion realizada!` 
                });

            }

        }

    })

}

/*======================================
MOSTRAR INFO TICKET
======================================*/
if(idTicket){

    $.ajax({

        url: 'ajax/mesaayuda/tickets.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'verInfoTicket',
            'idTicket': idTicket
        },
        cache: false,
        dataType: "json",
        success:function(respuesta){

            $("#textNombreUsuarioSolicitud").html(respuesta["nombre_usuario"]);
            $("#textUsuarioSolicitud").html(respuesta["usuario_crea"]);
            $("#textIdTicket").html(respuesta["id_ticket"]);
            $("#textFechaTicket").html(respuesta["fecha_crea"]);
            $("#textProyecto").html(respuesta["proyecto"]);
            $("#textPrioridad").html(respuesta["prioridad"]);
            $("#textAsunto").html(respuesta["asunto"]);
            $("#descripcionTicket").html(respuesta["descripcion"]);

            if(respuesta["ruta_archivos"]){

                $.ajax({

                    url: 'ajax/mesaayuda/tickets.ajax.php',
                    type: 'POST',
                    data:{
                        'proceso':'verArchivosTicket',
                        'rutaArchivos':respuesta["ruta_archivos"]
                    },
                    cache: false,
                    dataType: "json",
                    success:function(respuestaFile){

                        //console.log(respuestaFile);

                        $("#contenedorArchivosAdjuntos").html(respuestaFile.cadena);
                        $("#contenedorTituloArchivosAdjuntos").html(`<a class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseArchivosAdjuntos" aria-expanded="false" aria-controls="collapseArchivosAdjuntos"><span class="fas fa-folder-plus"></span> Archivos Adjuntos <span class="badge badge-phoenix badge-phoenix-warning">${respuestaFile.cantidad_archivos}</span></a>`);

                    }

                })

            }else{

                $("#contenedorArchivosAdjuntos").html(`<div class="alert alert-outline-warning" role="alert">No Adjuntaron Archivos!</div>`);

            }

            /*=======================================
            BOTON TOMAR TICKET
            =======================================*/
            if(rolUsuario == 'USUARIO'){

                $("#contenedorHeaderCardTicket").html(`<div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0"><i class="fas fa-list-alt"></i> Informacion Ticket</h4>
                        </div>
                    </div>
                </div>`);

            }else if(rolUsuario == 'SOPORTE' && respuesta["estado"] == 'CREADO'){

                $("#contenedorHeaderCardTicket").html(`<div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0"><i class="fas fa-list-alt"></i> Informacion Ticket</h4>
                        </div>
                        <div class="col col-md-auto">
                            <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center">
                                <button class="btn btn-success btn-sm ms-2" onclick="tomarTicket(${respuesta.id_ticket},'SOPORTE')"><i class="far fa-check-square"></i> Tomar Ticket</button>
                            </nav>
                        </div>
                    </div>
                </div>`);

            }else{

                $("#contenedorHeaderCardTicket").html(`<div class="card-header p-4 border-bottom border-300 bg-primary">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0"><i class="fas fa-list-alt"></i> Informacion Ticket</h4>
                        </div>
                    </div>
                </div>`);

            }

            /*=======================================
            BOTON TERMINAR TICKET
            =======================================*/
            if(rolUsuario == 'USUARIO'){

                $("#contenedorHeaderSeguimientoTicket").html(`<div class="card-header p-4 border-bottom border-300 bg-success">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0"><i class="far fa-calendar-plus"></i> Agregar Seguimiento</h4>
                        </div>
                    </div>
                </div>`);

            }else if(rolUsuario == 'SOPORTE' && respuesta["estado"] == 'PENDIENTE'){

                $("#contenedorHeaderSeguimientoTicket").html(`<div class="card-header p-4 border-bottom border-300 bg-success">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0"><i class="far fa-calendar-plus"></i> Agregar Seguimiento</h4>
                        </div>
                        <div class="col col-md-auto">
                            <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                                <button class="btn btn-danger me-1 mb-1" onclick="terminarTicket()"><i class="far fa-calendar-check"></i> Terminar Ticket</button>
                            </nav>
                        </div>
                    </div>
                </div>`);

            }else{

                $("#contenedorHeaderSeguimientoTicket").html(`<div class="card-header p-4 border-bottom border-300 bg-success">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-white mb-0"><i class="far fa-calendar-plus"></i> Agregar Seguimiento</h4>
                        </div>
                    </div>
                </div>`);

            }

            /*=========================================
            ALERTA TICKET PRE_REALIZADO
            =========================================*/
            if(rolUsuario == 'USUARIO' && respuesta["estado"] == 'PRE_REALIZADO'){

                $("#contenedorAlertaTicketPostRealizado").html(`<div class="alert alert-soft-warning" role="alert">
                    <h4 class="alert-heading fw-semi-bold">Informacion Ticket!</h4>
                    <p>El usuario de Soporte marco el ticket como <b>PRE_REALIZADO</b>, si el Ticket aun no ha sido solucionado en su totalidad puede escribir en el panel de seguimiento, si por el contrario todo fue solucionado, por favor no registrar mas seguimientos.</p>
                </div>`);

            }else{

                $("#contenedorAlertaTicketPostRealizado").html(``);

            }

            /*====================================
            ESTADO TICKET
            ====================================*/
            if(respuesta["estado"] == 'CREADO'){

                $("#textEstadoTicket").html(`<span class="badge badge-phoenix badge-phoenix-warning p-2">${respuesta.estado}</span>`);

            }else if(respuesta["estado"] == 'PENDIENTE'){

                $("#textEstadoTicket").html(`<span class="badge badge-phoenix badge-phoenix-info p-2">${respuesta.estado}</span>`);

            }else if(respuesta["estado"] == 'PRE_REALIZADO'){

                $("#textEstadoTicket").html(`<span class="badge badge-phoenix badge-phoenix-primary p-2">${respuesta.estado}</span>`);

            }else if(respuesta["estado"] == 'REALIZADO'){

                $("#textEstadoTicket").html(`<span class="badge badge-phoenix badge-phoenix-success p-2">${respuesta.estado}</span>`);

            }
        
        }

    })

    let cadena = ``;

    $.ajax({
        url: 'ajax/mesaayuda/tickets.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'verSeguimientosTicket',
            'idTicket': idTicket
        },
        cache: false,
        dataType: "json",
        success: function (respuesta) {
            //console.log(respuesta);

            let arraySeguimientos = respuesta;
            let promesas = [];

            arraySeguimientos.forEach(function (seguimiento) {

                // Construir cadena para cada seguimiento
                cadena += `
                <div class="row">
                    <div class="col-sm-12 col-md-1 text-center d-flex align-items-center">
                        <div class="row h-100">
                            <div class="col d-flex align-items-center">
                                <h5 class="m-2">
                                    <span class="badge rounded-pill bg-warning-300 border"><span class="far fa-comment p-1"></span></span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-11 py-2">
                        <div class="card shadow-user-permited">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <div class="float-end text-muted">${dias[seguimiento.dia_txt]}, ${seguimiento.dia_num} de ${meses[seguimiento.mes_num-1]} de ${seguimiento.anio} ${seguimiento.hora}</div>
                                    <h5 class="card-title text-warning-300"><span class="far fa-user-circle"></span> ${seguimiento.nombre_usuario}</h5>
                                    <p class="card-text">${seguimiento.descripcion}</p><div id="contenedorArchivosSeguimientos${seguimiento.id_seguimiento}"></div>`;

                                    // if (seguimiento["ruta_archivos"]) {
                                    //     let promise = new Promise(function (resolve) {
                                    //         $.ajax({
                                    //             url: 'ajax/mesaayuda/tickets.ajax.php',
                                    //             type: 'POST',
                                    //             data: {
                                    //                 'proceso': 'verArchivosSeguimientoTicket',
                                    //                 'rutaArchivos': seguimiento["ruta_archivos"]
                                    //             }
                                    //         }).done(function (respuestaFile) {
                                    //             console.log(respuestaFile);
                                    //             cadena += respuestaFile;
                                    //             resolve(cadena);
                                    //         });
                                    //     });
                                    //     promesas.push(promise);
                                    // } else {
                                    //     // Si no hay archivos, simplemente resolvemos la promesa con la cadena actual
                                    //     promesas.push(Promise.resolve(cadena));
                                    // }

                                    cadena += `
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

                if(seguimiento["ruta_archivos"]){

                    $.ajax({
                        url: 'ajax/mesaayuda/tickets.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'verArchivosSeguimientoTicket',
                            'rutaArchivos': seguimiento["ruta_archivos"]
                        }
                    }).done(function (respuestaFile) {
                        
                        $("#contenedorArchivosSeguimientos"+seguimiento.id_seguimiento).html(respuestaFile);
                        
                    });
                
                }
            });

            $("#contenedorSeguimientosTicket").html(cadena);

            // Resuelve todas las promesas después de construir la cadena para cada seguimiento
            // Promise.all(promesas).then(function (cadenas) {
            //     // Actualiza el contenido en #contenedorSeguimientosTicket con todas las cadenas
            //     $("#contenedorSeguimientosTicket").html(cadenas.join(''));
            // });


        }
    });

}

tablaMisTickets = $('#tablaMisTickets').DataTable({
    columns: [
        { name: 'ID', data: 'id_ticket' },
        { name: 'PROYECTO', data: 'proyecto' },
        { name: 'ASUNTO', data: 'asunto' },
        { name: 'PRIORIDAD', data: 'prioridad' },
        { name: 'FECHA TICKET', data: 'fecha_crea' },
        { name: 'ESTADO', render: function(data, type, row){
            if(row.estado == 'CREADO'){

                return '<span class="badge badge-phoenix badge-phoenix-warning p-2">'+row.estado+'</span>';

            }else if(row.estado == 'PENDIENTE'){

                return '<span class="badge badge-phoenix badge-phoenix-info p-2">'+row.estado+'</span>';

            }else if(row.estado == 'PRE_REALIZADO'){

                return '<span class="badge badge-phoenix badge-phoenix-primary p-2">'+row.estado+'</span>';

            }else if(row.estado == 'REALIZADO'){

                return '<span class="badge badge-phoenix badge-phoenix-success p-2">'+row.estado+'</span>';

            }
        } 
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                let botonSeguimiento = ``;
                let botonVerTicket = `<button type="button" class="btn btn-sm btn-warning me-1 mb-1" onclick="verTicket(${row.id_ticket},'USUARIO')" title="Ver Ticket"><i class="far fa-eye"></i></button>`;
                //return botones + '<button class="btn btn-success">HOLA</button>';
                if(row.estado == 'PENDIENTE' || row.estado == 'PRE_REALIZADO'){

                    botonSeguimiento = `<button type="button" class="btn btn-sm btn-primary me-1 mb-1" onclick="gestionarTicket(${row.id_ticket},'USUARIO')" title="Gestionar Ticket"><i class="far fa-comments"></i></button>`;

                }else{

                    botonSeguimiento = `<button type="button" class="btn btn-sm btn-primary me-1 mb-1" title="Gestionar Ticket" disabled><i class="far fa-comments"></i></button>`;

                }

                return botonVerTicket + botonSeguimiento;

            }
        }
    ],
    ajax: {
        url: 'ajax/mesaayuda/tickets.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaMisTickets',
            'userTicket': userSession
        }
    }
    

});

tablaBolsaTickets = $('#tablaBolsaTickets').DataTable({
    columns: [
        { name: 'ID', data: 'id_ticket' },
        { name: 'PROYECTO', data: 'proyecto' },
        { name: 'ASUNTO', data: 'asunto' },
        { name: 'PRIORIDAD', data: 'prioridad' },
        { name: 'USUARIO SOLICITUD', data: 'nombre_usuario' },
        { name: 'FECHA TICKET', data: 'fecha_crea' },
        { name: 'ESTADO', render: function(data, type, row){
            if(row.estado == 'CREADO'){

                return '<span class="badge badge-phoenix badge-phoenix-warning p-2">'+row.estado+'</span>';

            }else if(row.estado == 'PENDIENTE'){

                return '<span class="badge badge-phoenix badge-phoenix-info p-2">'+row.estado+'</span>';

            }else if(row.estado == 'PRE_REALIZADO'){

                return '<span class="badge badge-phoenix badge-phoenix-primary p-2">'+row.estado+'</span>';

            }else if(row.estado == 'REALIZADO'){

                return '<span class="badge badge-phoenix badge-phoenix-success p-2">'+row.estado+'</span>';

            }
        } 
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                let botonTomarTicket = ``;
                let botonVerTicket = `<button type="button" class="btn btn-sm btn-warning me-1 mb-1" onclick="verTicket(${row.id_ticket},'SOPORTE')" title="Ver Ticket"><i class="far fa-eye"></i></button>`;
                //return botones + '<button class="btn btn-success">HOLA</button>';
                botonTomarTicket = `<button type="button" class="btn btn-sm btn-success me-1 mb-1" onclick="tomarTicket(${row.id_ticket},'SOPORTE')" title="Tomar Ticket"><i class="far fa-check-square"></i></button>`;

                return botonVerTicket + botonTomarTicket;

            }
        }
    ],
    ajax: {
        url: 'ajax/mesaayuda/tickets.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaTicketsBolsa'
        }
    }
    

});

tablaTicketPendienteGestion = $('#tablaTicketPendienteGestion').DataTable({
    columns: [
        { name: 'ID', data: 'id_ticket' },
        { name: 'PROYECTO', data: 'proyecto' },
        { name: 'ASUNTO', data: 'asunto' },
        { name: 'PRIORIDAD', data: 'prioridad' },
        { name: 'USUARIO SOLICITUD', data: 'nombre_usuario' },
        { name: 'FECHA TICKET', data: 'fecha_crea' },
        { name: 'FECHA INI', data: 'fecha_ini_ticket' },
        { name: 'ESTADO', render: function(data, type, row){
            if(row.estado == 'CREADO'){

                return '<span class="badge badge-phoenix badge-phoenix-warning p-2">'+row.estado+'</span>';

            }else if(row.estado == 'PENDIENTE'){

                return '<span class="badge badge-phoenix badge-phoenix-info p-2">'+row.estado+'</span>';

            }else if(row.estado == 'PRE_REALIZADO'){

                return '<span class="badge badge-phoenix badge-phoenix-primary p-2">'+row.estado+'</span>';

            }else if(row.estado == 'REALIZADO'){

                return '<span class="badge badge-phoenix badge-phoenix-success p-2">'+row.estado+'</span>';

            }
        } 
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                let botonSeguimiento = ``;
                let botonVerTicket = `<button type="button" class="btn btn-sm btn-warning me-1 mb-1" onclick="verTicket(${row.id_ticket},'SOPORTE')" title="Ver Ticket"><i class="far fa-eye"></i></button>`;
                //return botones + '<button class="btn btn-success">HOLA</button>';
                botonSeguimiento = `<button type="button" class="btn btn-sm btn-primary me-1 mb-1" onclick="gestionarTicket(${row.id_ticket},'SOPORTE')" title="Gestionar Ticket"><i class="far fa-comments"></i></button>`;

                return botonVerTicket + botonSeguimiento;

            }
        }
    ],
    ajax: {
        url: 'ajax/mesaayuda/tickets.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaMisTicketsPendienteGestion',
            'idUser':idUserSession
        }
    }
    

});
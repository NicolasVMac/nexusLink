/*==============================
VARIABLES DE RUTA
==============================*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

var idCall = atob(getParameterByName('idCall'));
var procesoCall = atob(getParameterByName('procesoCall'));
let meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
let dias = {'Monday':'Lunes', 'Tuesday':'Martes', 'Wednesday':'Miercoles', 'Thursday':'Jueves', 'Friday':'Viernes', 'Saturday':'Sabado', 'Sunday':'Domingo'};
let tablaSearchPacientes;

function buscarPaciente(){

    let filtroBusqueda = document.getElementById("filtroBusqueda").value;
    let textoBusqueda = document.getElementById("textoBusqueda").value;

    if(filtroBusqueda && textoBusqueda){

        document.getElementById("cardResultSearch").style.display = "block";

        if ($.fn.DataTable.isDataTable('#tablaSearchPacientes')) {
            tablaSearchPacientes.destroy(); // Destruir la DataTable existente
        }

        tablaSearchPacientes = $('#tablaSearchPacientes').DataTable({
            columns: [
                { name: '#', data: 'id_paciente' },
                { name: 'NOMBRE', data: 'nombre_paciente_completo' },
                { name: 'NUMERO DOCUMENTO', render: function(data, type, row){ 
                    return row.tipo_documento + "-" + $.fn.dataTable.render.number('.', '', 0, '').display(row.numero_documento);
                }
                },
                { name: 'NO CARNET', data: 'no_carnet', render: $.fn.dataTable.render.number('.', ',', 0, '') },
                { name: 'EDAD', render: function(data, type, row){
                    return row.edad_n + " " + row.edad_t
                } 
                },
                { name: 'CORREO', data: 'correo' },
                { name: 'TELEFONOS', render: function(data, type, row){
                    return row.telefono_uno_ubicacion + "-" + row.telefono_dos_ubicacion
                } 
                },
                { name: 'UBICACION', render: function(data, type, row){
                    return row.departamento_ubicacion + "-" + row.municipio_ubicacion
                } 
                },
                {
                    name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                        return `<button type="button" class="btn btn-primary btn-sm" onclick="btnCrearGestionCall('BUSQUEDA', ${row.id_paciente})" title="Crear Gestion Call"><i class="fas fa-phone-alt"></i></button>`;
                    }
                }
            ],
            ajax: {
                url: 'ajax/callcenter/callcenter.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'buscarPacienteCall',
                    'filtroBusqueda': filtroBusqueda,
                    'valorBusqueda': textoBusqueda
                }
            }
            

        });

    }else{

        toastr.warning("Debe diligenciar el Filtro y Valor de busqueda", "Error");

    }

}

function continuarGestionCall(idCall, procesoCall){

    window.location = 'index.php?ruta=callcenter/gestionarcall&idCall='+btoa(idCall)+'&procesoCall='+btoa(procesoCall);    

}

function btnCrearGestionCall(procesoCall, idPaciente){

    switch(procesoCall){

        case 'BUSQUEDA':

            $.ajax({

                url: 'ajax/callcenter/callcenter.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'crearGestionCall',
                    'procesoCall': procesoCall,
                    'idPaciente': idPaciente,
                    'asesor': userSession
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    if(respuesta["resultado"] === 'ok'){

                        Swal.fire({
                            text: 'La Gestion Call se creo correctamente',
                            icon: 'success',
                            confirmButtonText: 'Gestionar Encuesta',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=callcenter/gestionarcall&idCall='+btoa(respuesta["id_call"])+'&procesoCall='+btoa(procesoCall);

                            }

                        })

                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: 'La Gestion call no se guardo correctamente',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })


                    }
                    
                }

            })

            break;

    }

}

/*=====================================
INFORMACION GENERAL GESTION CALL
=====================================*/
if(procesoCall && idCall){

    $.ajax({

        url: 'ajax/callcenter/callcenter.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'infoCall',
            'idCall': idCall,
            'procesoCall': procesoCall
        },
        cache: false,
        dataType: "json",
        success:function(respuestaCall){

            if(respuestaCall["estado"] == 'PROCESO'){

                $("#idCallComuFallida").val(respuestaCall["id_call"]);
                $("#idPaciente").val(respuestaCall["id_paciente"]);
                $("#cantidadGestionesComuFallida").val(respuestaCall["contador_gestiones"]);
                $("#procesoCall").val(respuestaCall["proceso_origen"]);

                $("#textProcesoCall").html(respuestaCall["proceso_origen"]);
                $("#textAsesor").html(respuestaCall["asesor"]);
                $("#textCantidadGestiones").html(respuestaCall["contador_gestiones"]);

                /*=====================================
                INFORMACION PACIENTE
                =====================================*/
                $.ajax({

                    url: 'ajax/config/pacientes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'mostrarPaciente',
                        'idPaciente': respuestaCall["id_paciente"]
                    },
                    cache: false,
                    dataType: "json",
                    success:function(respuestaPaciente){
                    
                        $("#textNombrePaciente").html(respuestaPaciente["nombre_paciente_completo"]);
                        $("#textDocumentoPaciente").html(respuestaPaciente["tipo_documento"]+"-"+respuestaPaciente["numero_documento"]);
                        $("#textFechaExpedicion").html(respuestaPaciente["expedido_en"]);
                        $("#textNoCarnet").html(respuestaPaciente["no_carnet"]);
                        $("#textFechaNacimiento").html(respuestaPaciente["fecha_nacimiento"]);
                        $("#textEdad").html(respuestaPaciente["edad_n"]+" "+respuestaPaciente["edad_t"]);
                        $("#textGenero").html(respuestaPaciente["genero_paciente"]);
                        $("#textOcupacion").html(respuestaPaciente["ocupacion"]);
                        $("#textRegimen").html(respuestaPaciente["regimen"]);
                        $("#textTipoUsuarioRips").html(respuestaPaciente["tipo_usuario_rips"]);
                        $("#textTipoAfiliacion").html(respuestaPaciente["tipo_afiliacion"]);
                        $("#textEntidadAfActual").html(respuestaPaciente["entidad_af_actual"]);
                        $("#textPaqueteAtencion").html(respuestaPaciente["paquete_atencion"]);
                        $("#textDepartamento").html(respuestaPaciente["departamento_ubicacion"]);
                        $("#textMunicipio").html(respuestaPaciente["municipio_ubicacion"]);
                    
                    }

                })

                /*=====================================
                PREGUNTAS PROCESO
                =====================================*/
                $.ajax({

                    url: 'ajax/callcenter/callcenter.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'mostrarPreguntasProcesoCall',
                        'procesoCall': procesoCall 
                    },
                    cache: false,
                    dataType: "json",
                    success:function(respuestaPreguntas){

                        let cadenaPreguntas = '';
                        let arrayPreguntas = respuestaPreguntas;

                        cadenaPreguntas += '<div class="row mb-2">'+
                            '<div class="col-md-8 bg-warning-300 p-3"><h5 class="text-center text-white">Pregunta</h5></div>'+
                            '<div class="col-md-4 bg-warning-300 p-3 border-start"><h5 class="text-center text-white">Respuesta</h5></div>'+
                        '</div>';

                        arrayPreguntas.forEach(function(pregunta){

                            let idPreguntaEncuesta = "idPreguntaEncuesta"+pregunta["id_pregunta"];
                            let nameCampo = "pregunta"+pregunta["id_pregunta"];

                            cadenaPreguntas += '<div class="row mb-2">'+
                                '<div class="col-md-8">'+pregunta["descripcion"]+'</div>';

                            cadenaPreguntas += '<div class="col-md-4">';

                                if(pregunta["tipo_pregunta"] == "select"){

                                    let arrayRespuestas = pregunta["respuesta"].split("-");

                                    cadenaPreguntas += '<select class="form-select" name="'+nameCampo+'" id="'+nameCampo+'" required style="width: 100%;">'+
                                    '<option value="">Selecciona una respuesta</option>';


                                    arrayRespuestas.forEach(function(respuesta){

                                        cadenaPreguntas += '<option value="'+respuesta+'">'+respuesta+'</option>';

                                    })


                                    cadenaPreguntas += '</select>'+
                                    '<input type="hidden" name="'+idPreguntaEncuesta+'" id="'+idPreguntaEncuesta+'" value="'+pregunta["id_pregunta"]+'">';

                                }else{

                                    cadenaPreguntas += '<textarea class="form-control" name="'+nameCampo+'" id="'+nameCampo+'" rows="5" required></textarea>'+
                                    '<input type="hidden" name="'+idPreguntaEncuesta+'" id="'+idPreguntaEncuesta+'" value="'+pregunta["id_pregunta"]+'">';

                                }

                            cadenaPreguntas += '</div></div>';

                            $("#contenedorPreguntasEncuesta").html(cadenaPreguntas);

                        })
                    
                    }

                })

            }else{

                Swal.fire({

                    text: 'La Gestion Call ya fue finalizada',
                    icon: 'info',
                    confirmButtonText: 'Cerrar',
                    allowOutsideClick: false,
                    allowEscapeKey: false

                }).then((result) =>{

                    if(result.isConfirmed){

                        window.location = 'index.php?ruta=callcenter/pendientescall';

                    }

                })

            }
            
        }


    })

}

function terminarGestionCall(idCall, estado){

    let respuesta = '';

    $.ajax({

        url: 'ajax/callcenter/callcenter.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'terminarGestionCall',
            'id_call': idCall,
            'estado': estado
        },
        cache: false,
        success:function(respuestaTerminar){
            
            //console.log(respuestaTerminar);

            if(respuestaTerminar === 'ok'){

                return respuesta = 'ok';

            }else{
                
                return respuestaTerminar;

            }

        }

    })

}


function registrarComunicacionFallida(){

    let idCall = document.getElementById("idCallComuFallida").value;
    let causalFallida = document.getElementById("causalFallida").value;
    let observacionFallida = document.getElementById("observacionesFallida").value;
    let cantidadGestiones = document.getElementById("cantidadGestionesComuFallida").value;
    let procesoCall = document.getElementById("procesoCall").value;

    let formulario = document.getElementById("formComunicacionFallida");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            $.ajax({

                url: 'ajax/callcenter/callcenter.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'crearRegistroComunicacionFallida',
                    'idCall':idCall,
                    'causalFallida':causalFallida,
                    'observacionFallida':observacionFallida,
                    'cantidadGestiones':cantidadGestiones,
                    'procesoCall':procesoCall,
                    'usuarioCrea': userSession
                },
                success:function(respuesta){

                    console.log(respuesta);

                    if(respuesta === 'ok-cierre-call'){

                        Swal.fire({

                            text: 'El Proceso Call fue terminado debido a que no se pudo establecer comunicación con el Paciente',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=callcenter/pendientescall';

                            }

                        })

                    }else if(respuesta === 'ok-comunicacion-fallida'){

                        Swal.fire({

                            text: 'La Comunicacion Fallida se guardo correctamente',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=callcenter/pendientescall';

                            }

                        })
                    
                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: 'La Comunicacion Fallida no se guardo correctamente',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })

                    }

                }

            })

        }

    }else{

        toastr.warning("Debe diligenciar todos los campos para Registrar la Comunicacion Fallida", "Error!");

    }
}

function guardarRespuestasEncuesta(){

    let procesoCall = document.getElementById("procesoCall").value;

    let formulario = document.getElementById("formRespuestasEncuesta");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            $.ajax({

                url: 'ajax/callcenter/callcenter.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'mostrarPreguntasProcesoCall',
                    'procesoCall': procesoCall 
                },
                cache: false,
                dataType: "json",
                success:function(respuestaPreguntas){

                    let arrayPreguntas = respuestaPreguntas;

                    arrayPreguntas.forEach(function(pregunta){

                        variableIdPregunta = "idPreguntaEncuesta"+pregunta["id_pregunta"];
                        variable = "pregunta"+pregunta["id_pregunta"];

                        if(document.getElementById(variable).value){

                            let idPregunta = document.getElementById(variableIdPregunta).value;
                            let respuesta = document.getElementById(variable).value;

                            $.ajax({

                                url: 'ajax/callcenter/callcenter.ajax.php',
                                type: 'POST',
                                data: {
                                    'proceso': 'guardarRespuestaPreguntaCall',
                                    'id_call': idCall,
                                    'id_pregunta': idPregunta,
                                    'respuesta': respuesta,
                                    'origen_encuesta': procesoCall,
                                    'usuario_crea': userSession
                                },
                                cache: false,
                                dataType: "json",
                                success: function(respuestaSaveRespuesta){

                                    //console.log(respuestaSaveRespuesta);

                                }

                            })

                        }


                    })


                        //             Swal.fire({
            
                        //                 text: 'La Gestion Call se guardo correctamente',
                        //                 icon: 'success',
                        //                 confirmButtonText: 'Cerrar',
                        //                 allowOutsideClick: false,
                        //                 allowEscapeKey: false
            
                        //             }).then((result) =>{
            
                        //                 if(result.isConfirmed){
            
                        //                     window.location = 'index.php?ruta=callcenter/pendientescall';
            
                        //                 }
            
                        //             })
            
                        //         }else{
            
                        //             Swal.fire({
                        //                 title: 'Error!',
                        //                 text: 'La Gestion Call no se guardo correctamente',
                        //                 icon: 'error',
                        //                 confirmButtonText: 'Cerrar',
                        //                 allowOutsideClick: false,
                        //                 allowEscapeKey: false
                        //             })
            
            
                        //         }

                    // $.ajax({

                    //     url: 'ajax/callcenter/callcenter.ajax.php',
                    //     type: 'POST',
                    //     data: {
                    //         'proceso': 'terminarGestionCall',
                    //         'id_call': idCall,
                    //         'estado': 'FINALIZADA'
                    //     },
                    //     cache: false,
                    //     success:function(respuestaTerminar){

                    //         if(respuestaTerminar === 'ok'){

                    //             Swal.fire({
        
                    //                 text: 'La Gestion Call se guardo correctamente',
                    //                 icon: 'success',
                    //                 confirmButtonText: 'Cerrar',
                    //                 allowOutsideClick: false,
                    //                 allowEscapeKey: false
        
                    //             }).then((result) =>{
        
                    //                 if(result.isConfirmed){
        
                    //                     window.location = 'index.php?ruta=callcenter/pendientescall';
        
                    //                 }
        
                    //             })
        
                    //         }else{
        
                    //             Swal.fire({
                    //                 title: 'Error!',
                    //                 text: 'La Gestion Call no se guardo correctamente',
                    //                 icon: 'error',
                    //                 confirmButtonText: 'Cerrar',
                    //                 allowOutsideClick: false,
                    //                 allowEscapeKey: false
                    //             })
        
        
                    //         }
                
                    //     }
                
                    // })

                }

            
            })

            $.ajax({

                url: 'ajax/callcenter/callcenter.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'terminarGestionCall',
                    'id_call': idCall,
                    'estado': 'FINALIZADA'
                },
                cache: false,
                success:function(respuestaTerminar){

                    if(respuestaTerminar === 'ok'){

                        Swal.fire({

                            text: 'La Gestion Call se guardo correctamente',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=callcenter/pendientescall';

                            }

                        })

                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: 'La Gestion Call no se guardo correctamente',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })


                    }
        
                }
        
            })


        }

    }else{

        toastr.warning("Debe diligenciar todos los campos para guardar las Respuestas de la Encuesta", "Error!");
    }

}

var tablaPendientesCall = $('#tablaPendientesCall').DataTable({
    columns: [
        { name: 'ID', data: 'id_call' },
        { name: 'PACIENTE', data: 'nombre_paciente_completo' },
        { name: 'PROCESO CALL', data: 'proceso_origen' },
        { name: 'CANTIDAD GESTIONES', data: 'contador_gestiones' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-sm btn-primary" onclick="continuarGestionCall(${row.id_call}, '${row.proceso_origen}')" title="Gestionar Call"><i class="fas fa-phone-volume"></i></button>`;
            }
        }
    ],
    ajax: {
        url: 'ajax/callcenter/callcenter.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPendientesCall',
            'usuario': userSession
        }
    }
    

});

var tablaComunicacionesFallidas = $('#tablaComunicacionesFallidas').DataTable({
    columns: [
        { name: 'ID', data: 'id_comu_fallida' },
        { name: 'CAUSAL FALLIDA', data: 'causal_fallida' },
        { name: 'OBSERVACIONES', data: 'observaciones' },
        { name: 'USUARIO CREA', data: 'usuario_crea' },
        { name: 'FECHA CREA', data: 'fecha' }
    ],
    ajax: {
        url: 'ajax/callcenter/callcenter.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaComunicacionFallidasCall',
            'idCall': idCall
        }
    }
    

});

function espaciosAgendaProfesional(){

    let motivoCita = document.getElementById('motivoCita').value;
    let idProfesional = document.getElementById('profesionalCita').value;
    let fechaCita = document.getElementById('fechaCita').value;

    if(idProfesional && fechaCita && motivoCita){

        $.ajax({

            url: 'ajax/callcenter/callcenter.ajax.php',
            type: 'POST',
            data: {
                'proceso': 'mostrarEspaciosAgendaProfesional',
                'idProfesional': idProfesional,
                'fechaCita': fechaCita 
            },
            cache: false,
            dataType: "json",
            success:function(respuesta){
            
                let cadenaHoras = '';

                let arrayHoras = respuesta;

                cadenaHoras += '<div class="row">';

                arrayHoras.forEach(function(hora, index){

                    cadenaHoras += '<div class="col-sm-12 col-md-3">'+
                        '<div class="form-check">'+
                            '<input class="form-check-input" id="datoHora'+(index+1)+'" name="horaCita" type="radio" value="'+hora["hora"]+'" required="">'+
                            '<span class="badge badge-phoenix badge-phoenix-success"><label class="form-check-label" for="datoHora'+(index+1)+'">'+hora["hora"]+'</label></span>'+
                        '</div>'+
                    '</div>';

                })

                cadenaHoras += '</div>';


                $("#contenedorHorasDisponibles").html(cadenaHoras);


            
            }

        })


    }else{

        $("#contenedorHorasDisponibles").html('');
        //toastr.warning("Debe diligenciar el Motivo Cita, Profesional y Fecha Cita", "Error!");

    }

}


function agendarCita(){

    let motivoCita = document.getElementById('motivoCita').value;
    let idProfesional = document.getElementById("profesionalCita").value;
    let fechaCita = document.getElementById("fechaCita").value;
    let idPaciente = document.getElementById("idPaciente").value;

    if(idProfesional && fechaCita && motivoCita){

        let horaCita = document.querySelector('input[name="horaCita"]:checked');
        
        if(horaCita?.value){

            let horaCitaCheck = horaCita.value;

            let formulario = document.getElementById("formAgendarCita");
            let elementos = formulario.elements;
            let errores = 0;

            Array.from(elementos).forEach(function (element) {
                if (element.className.includes('is-invalid')) {
                    errores += 1;
                }
            });

            if (errores === 0) {

                if (formulario.checkValidity()){

                    $.ajax({

                        url: 'ajax/callcenter/callcenter.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'crearCitaAgenda',
                            'motivoCita': motivoCita,
                            'idProfesional':idProfesional,
                            'idPaciente':idPaciente,
                            'fechaCita':fechaCita,
                            'horaCita':horaCitaCheck,
                            'usuarioCrea':userSession
                        },
                        success:function(respuesta){
        
                            if(respuesta === 'ok'){
        
                                Swal.fire({
        
                                    text: 'El Agendamiento de la Cita se realizo correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
        
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=callcenter/gestionarcall&idCall='+btoa(idCall)+'&procesoCall='+btoa(procesoCall);
        
                                    }
        
                                })
        
                            }else{
        
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'El Agendamiento de la Cita no se realizo correctamente',
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                })
        
                            }
        
                        }
        
                    })
                    
                
                }

            }

        }else{

            toastr.warning("Debe seleccionar la Hora de la Cita", "Error!");

        }

    }

}

// function verAgendaProfesional(){

//     let idProfesional = document.getElementById("profesionalAgenda").value;

//     if(idProfesional){

//         $.ajax({

//             url: 'ajax/callcenter/callcenter.ajax.php',
//             type: 'POST',
//             data: {
//                 'proceso': 'mostrarDiasAgendaProfesional',
//                 'idProfesional': idProfesional
//             },
//             cache: false,
//             dataType: "json",
//         }).done(function(respuesta){

//             let cadena = '';
//             let cadenaHoras = '';

//             let arrayDiasAgenda = respuesta

//             cadena += '<div class="accordion" id="accordionExample">';

//             arrayDiasAgenda.forEach(function(diasAgenda, index){

//                 console.log(diasAgenda);
                
//                 let key = index + 1;

//                 cadena += '<div class="accordion-item">'+
//                     '<h2 class="accordion-header" id="acordion'+key+'">'+
//                         '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'+key+'" aria-expanded="false" aria-controls="collapse'+key+'">'+dias[diasAgenda.dia_txt] + ' ' + diasAgenda.dia_num + ' ' + meses[diasAgenda.mes-1]+' de '+diasAgenda.anio+'</button>'+
//                     '</h2>'+
//                     '<div class="accordion-collapse collapse" id="collapse'+key+'" aria-labelledby="acordion'+key+'" data-bs-parent="#accordionExample">'+
//                         '<div class="accordion-body pt-0">';
                
//                     $.ajax({

//                         url: 'ajax/callcenter/callcenter.ajax.php',
//                         type: 'POST',
//                         data: {
//                             'proceso': 'mostrarHorasAgendaProfesional',
//                             'idProfesional': idProfesional,
//                             'fechaCita': diasAgenda.fecha_cita
//                         },
//                         cache: false,
//                         dataType: "json",
//                         }).done(function(respuestaHoras){

//                             console.info(respuestaHoras);

//                             cadena += '<ul class="list-group list-group-flush"><li class="list-group-item">Messages</li><li class="list-group-item">Pages</li></ul>';

//                             // let arrayHoras = respuestaHoras;

//                             // arrayHoras.forEach(function(horasAgenda){

//                             //     cadena += '<li class="list-group-item">'+horasAgenda.hora_cita_txt+'</li>';

//                             // })


//                         })


//                 cadena += '</div>'+
//                     '</div>'+
//                 '</div>';

//             })

//             cadena += '</div>';

//             $("#contenedorAcordionAgenda").html(cadena);


//         })

//     }

// }



function verAgendaProfesional() {

    let idProfesional = document.getElementById("profesionalAgenda").value;
  
    if(idProfesional){

        let cadena = '';
        let promesas = [];
  
        $.ajax({
            url: 'ajax/callcenter/callcenter.ajax.php',
            type: 'POST',
            data: {
            'proceso': 'mostrarDiasAgendaProfesional',
            'idProfesional': idProfesional
            },
            cache: false,
            dataType: "json"
        }).done(function (respuesta){

            let arrayDiasAgenda = respuesta;
  
            arrayDiasAgenda.forEach(function (diasAgenda, index) {
            let key = index + 1;
    
            let seccionCadena = `
                <div class="accordion-item">
                    <h2 class="accordion-header p-2" id="acordion${key}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${key}" aria-expanded="false" aria-controls="collapse${key}">
                        ${dias[diasAgenda.dia_txt]} ${diasAgenda.dia_num} ${meses[diasAgenda.mes - 1]} de ${diasAgenda.anio}
                        </button>
                    </h2>
                <div class="accordion-collapse collapse" id="collapse${key}" aria-labelledby="acordion${key}" data-bs-parent="#accordionExample">
                    <div class="accordion-body pt-0">
                        <ul class="list-group list-group-flush">`;
    
                let promise = new Promise(function(resolve){

                    $.ajax({
                        url: 'ajax/callcenter/callcenter.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'mostrarHorasAgendaProfesional',
                            'idProfesional': idProfesional,
                            'fechaCita': diasAgenda.fecha_cita
                        },
                        cache: false,
                        dataType: "json"
                    }).done(function (respuestaHoras) {
                    
                        let arrayHoras = respuestaHoras;
        
                        arrayHoras.forEach(function(hora){

                            seccionCadena += `<li class="list-group-item"><span class="badge badge-phoenix badge-phoenix-primary">${hora.hora_cita_txt}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;${hora.motivo_cita}</li>`;
                        
                        });
        
                        seccionCadena += `</ul></div></div></div>`;
                        resolve(seccionCadena);

                    });
                });
    
                promesas.push(promise);

            });
  
            Promise.all(promesas).then(function (seccionesCadena) {

                seccionesCadena.forEach(function (seccion) {
                    cadena += seccion;
                });
        
                cadena += `</div>`;
                $("#contenedorAcordionAgenda").html(cadena);
            });

        });

    }else{

        $("#contenedorAcordionAgenda").html('');

    }
}
  
  
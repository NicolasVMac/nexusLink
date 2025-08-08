let tablaBasesEncuestas;
let tablaBolsaEncuestasAutoinmunes;
let tablaAdminProfesionales;

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaTipoDocumento'
    },
}).done(function (tipoDoc) {

    $("#tipoDocumento").html(tipoDoc);

})

const changeTipoEncuesta = () => {

    let tipoEncuesta = document.querySelector('#tipoEncuesta').value;

    // console.log(tipoEncuesta);

    $.ajax({
        type: 'POST',
        url: 'ajax/encuestas/encuestas.ajax.php',
        data: {
            'proceso': 'listaProcesosEncuestaNoIniciales',
            'tipoEncuesta': tipoEncuesta
        },
    }).done(function(procesosEncuesta) {
    
        $("#procesoEncuesta").html(procesosEncuesta);
    
    })


}

const auditoresTipoEncuesta = () => {

    let tipoEncuesta = document.querySelector('#tipoEncuesta').value;

    $.ajax({
        type: 'POST',
        url: 'ajax/encuestas/encuestas.ajax.php',
        data: {
            'proceso': 'listaAuditoresEncuesta',
            'tipoEncuesta': tipoEncuesta,
            'userSession': userSession
        },
    }).done(function(auditoresEncuesta) {
    
        $("#auditorEncuesta").html(auditoresEncuesta);
    
    })


}

const cargarBaseEncuestas = () =>{

    let formulario = document.getElementById("formCargarArchivoEncuestas");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let nombreArchivo = document.getElementById("nombreArchivoEncuesta").value;
            let tipoEncuestas = document.getElementById("tipoEncuesta").value;
            let nivelConfianza = document.getElementById("nivelConfianza").value;
            let margenError = document.getElementById("margenError").value;
            let archivo = document.querySelector("#archivoEncuesta").files;
            let auditor = document.getElementById("auditorEncuesta").value;

            // console.log(archivo[0]);

            let data = new FormData();
            data.append("proceso", "cargarArchivoEncuestas");
            data.append("nombreArchivo", nombreArchivo);
            data.append("tipoEncuestas", tipoEncuestas);
            data.append("nivelConfianza", nivelConfianza);
            data.append("margenError", margenError);
            data.append("auditorEncuesta", auditor);
            data.append("archivoEncuesta", archivo[0]);
            data.append("user", userSession);

            $.ajax({

                url: 'ajax/encuestas/encuestas.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({

                            text: '¡La Base se cargo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=encuestas/cargarencuestas';

                            }

                        })

                    }else if(respuesta === 'error-estructura'){
                        
                        Swal.fire({

                            text: '¡La Base no cuenta con la estructura adecuada, 10 Columnas (J)!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=encuestas/cargarencuestas';

                            }

                        })
                    
                    }else{

                        Swal.fire({

                            text: '¡La Base no se cargo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=encuestas/cargarencuestas';

                            }

                        })

                    }

                }

            })



        }

    }

}

const tomarEncuesta = (idEncuesta, tipoEncuesta, idBaseEncuesta) => {

    Swal.fire({
        title: "¿Desea Gestionar la Auditoria?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Gestionar Auditoria!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/encuestas/encuestas.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'tomarEncuesta',
                    'idEncuesta': idEncuesta,
                    'auditor': userSession,
                    'nombreUser': userName,
                    'idBaseEncuesta': idBaseEncuesta,
                    'tipoEncuesta': tipoEncuesta
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    if(respuesta.estado == 'ok-asignado'){

                        Swal.fire({
                            text: '¡La Auditoria se asigno correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Gestionar Auditoria',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#3085d6"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=encuestas/gestionarencuesta&idEncuesta='+btoa(idEncuesta)+'&tipoEncuesta='+btoa(tipoEncuesta);

                            }

                        })

                    }else if(respuesta.estado == 'error-creando-procesos'){

                        Swal.fire({
                            title: 'Error!',
                            text: '¡No se crearon las Auditorias Iniciales correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                        
                    }else if(respuesta.estado == 'error-asignando'){

                        Swal.fire({
                            text: '¡La Auditoria no se asigno correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                if(tipoEncuesta == 'AUTOINMUNES'){

                                    window.location = 'index.php?ruta=encuestas/bolsaencuautoinmunes';

                                }else{

                                    window.location = 'index.php?ruta=encuestas/bolsaencuvih';

                                }

                                

                            }

                        })


                    }else if(respuesta.estado == 'ok-ya-asignado'){
                        
                        Swal.fire({
                            text: '¡La Auditoria ya esta asignado a otro Auditor!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                if(tipoEncuesta == 'AUTOINMUNES'){

                                    window.location = 'index.php?ruta=encuestas/bolsaencuautoinmunes';

                                }else{

                                    window.location = 'index.php?ruta=encuestas/bolsaencuvih';

                                }

                            }

                        })
                        
                    }else if(respuesta.estado == 'error-capacidad-superada'){

                        Swal.fire({
                            title: 'Error!',
                            text: '¡La Auditoria no se asigno debido a que supero los pendientes permitidos!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })
                    
                    }else if(respuesta.estado == 'muestra-cumplida'){

                        Swal.fire({
                            title: 'Informacion!',
                            text: '¡La Auditoria no se asigno debido a que ya se cumplio la cantidad de la muestra!',
                            icon: 'info',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                if(tipoEncuesta == 'AUTOINMUNES'){

                                    window.location = 'index.php?ruta=encuestas/bolsaencuautoinmunes';

                                }else{

                                    window.location = 'index.php?ruta=encuestas/bolsaencuvih';

                                }

                            }

                        })

                    }else if(respuesta.estado == 'pendiente-cierre-muestra'){

                        Swal.fire({
                            title: 'Informacion!',
                            text: '¡En espera de cierre de Auditoria para cerrar muestra, (Usuarios con Auditorias Pendiente)!',
                            icon: 'info',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                if(tipoEncuesta == 'AUTOINMUNES'){

                                    window.location = 'index.php?ruta=encuestas/bolsaencuautoinmunes';

                                }else{

                                    window.location = 'index.php?ruta=encuestas/bolsaencuvih';

                                }

                            }

                        })
                        
                        
                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: 'La Auditoria no se asigno correctamente',
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

}

const gestionarEncuesta = (idEncuesta, tipoEncuesta) => {

    window.location = 'index.php?ruta=encuestas/gestionarencuesta&idEncuesta='+btoa(idEncuesta)+'&tipoEncuesta='+btoa(tipoEncuesta);

}

tablaBasesEncuestas = $('#tablaBasesEncuestas').DataTable({
    columns: [
        { name: '#', data: 'id_base_encuesta' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre_archivo' },
        { name: 'TIPO ENCUESTAS', data: 'tipo_encuestas' },
        { name: 'ARCHIVO', render: function(data, type, row){ 
            return '<a href="'+row.ruta_archivo+'" target="_blank"><span class="badge badge-phoenix badge-phoenix-success p-2"><i class="far fa-file-excel"></i> ARCHIVO CARGADO</span></a>'
        }
        },
        { name: 'CANTIDAD', data: 'cantidad'},
        { name: 'MUESTRA', data: 'muestra'},
        { name: 'ESTADO', render: function(data, type, row){
            if(row.estado == 'SUBIDA'){

                return '<span class="badge badge-phoenix badge-phoenix-primary p-2">'+row.estado+'</span>';

            }else if(row.estado == 'ERROR' || row.estado == 'ERROR_CARGA'){

                return '<a href="'+row.ruta_archivo_errors+'" target="_blank" download><span class="badge badge-phoenix badge-phoenix-danger p-2"><i class="fas fa-file-download"></i> '+row.estado+'</span></a>';

            }else if(row.estado == 'CARGAR' || row.estado == 'VALIDANDO' || row.estado == 'CARGANDO'){

                return '<span class="badge badge-phoenix badge-phoenix-primary p-2">'+row.estado+'</span>';

            }else if(row.estado == 'CARGADO' || row.estado == 'AUDITADA'){

                return '<span class="badge badge-phoenix badge-phoenix-success p-2">'+row.estado+'</span>';

            }
        } 
        },
        { name: 'USUARIO', data: 'usuario' },
        { name: 'AUDITOR', data: 'auditor' },
        { name: 'FECHA CARGA', data: 'fecha_crea' },
    ],
    order: [[0, 'desc']],
    ajax: {
        url: 'ajax/encuestas/encuestas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'basesCargadasEncuestas'
        }
    }
    

});


tablaBolsaEncuestasAutoinmunes = $('#tablaBolsaEncuestasAutoinmunes').DataTable({

    columns: [
        { name: '#', data: 'id_encuesta' },
        { name: '# BASE', data: 'id_base_encu' },
        { name: 'NO. HISTORIA CLINICA', data: 'no_historia_clinica' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
        { name: 'EDAD', data: 'edad' },
        { name: 'SEXO', data: 'sexo' },
        { name: 'ESPECIALIDAD', data: 'especialidad' },
        { name: 'PROFESIONAL AUDITADO', data: 'profesional_auditado' },
        { name: 'EPS', data: 'eps' },
        { name: 'FECHA ATENCION', data: 'fecha_atencion' },
        { name: 'MODALIDAD CONSULTA', data: 'modalidad_consulta' },
        { name: 'TIPO ENCUESTA', data: 'tipo_encuesta' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-success btn-sm" onclick="tomarEncuesta(${row.id_encuesta},'${row.tipo_encuesta}',${row.id_base_encu})" title="Tomar Encuesta"><i class="far fa-check-square"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/encuestas/encuestas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEncuestasBolsa',
            'tipoEncuesta': 'AUTOINMUNES',
            'user': userSession
        }
    }

})

tablaBolsaEncuestasHistoriaClinica = $('#tablaBolsaEncuestasHistoriaClinica').DataTable({

    columns: [
        { name: '#', data: 'id_encuesta' },
        { name: '# BASE', data: 'id_base_encu' },
        { name: 'NO. HISTORIA CLINICA', data: 'no_historia_clinica' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
        { name: 'EDAD', data: 'edad' },
        { name: 'SEXO', data: 'sexo' },
        { name: 'ESPECIALIDAD', data: 'especialidad' },
        { name: 'PROFESIONAL AUDITADO', data: 'profesional_auditado' },
        { name: 'EPS', data: 'eps' },
        { name: 'FECHA ATENCION', data: 'fecha_atencion' },
        { name: 'MODALIDAD CONSULTA', data: 'modalidad_consulta' },
        { name: 'TIPO ENCUESTA', data: 'tipo_encuesta' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-success btn-sm" onclick="tomarEncuesta(${row.id_encuesta},'${row.tipo_encuesta}',${row.id_base_encu})" title="Tomar Encuesta"><i class="far fa-check-square"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/encuestas/encuestas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEncuestasBolsa',
            'tipoEncuesta': 'VIH',
            'user': userSession
        }
    }

})

tablaPendientesEncuAutoinmunes = $('#tablaPendientesEncuAutoinmunes').DataTable({

    columns: [
        { name: '#', data: 'id_encuesta' },
        { name: '# BASE', data: 'id_base_encu' },
        { name: 'NO. HISTORIA CLINICA', data: 'no_historia_clinica' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
        { name: 'EDAD', data: 'edad' },
        { name: 'SEXO', data: 'sexo' },
        { name: 'ESPECIALIDAD', data: 'especialidad' },
        { name: 'PROFESIONAL AUDITADO', data: 'profesional_auditado' },
        { name: 'EPS', data: 'eps' },
        { name: 'FECHA ATENCION', data: 'fecha_atencion' },
        { name: 'MODALIDAD CONSULTA', data: 'modalidad_consulta' },
        { name: 'TIPO ENCUESTA', data: 'tipo_encuesta' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-success btn-sm" onclick="gestionarEncuesta(${row.id_encuesta},'${row.tipo_encuesta}')" title="Gestionar Encuesta"><i class="far fa-check-square"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/encuestas/encuestas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEncuestasPendientesUser',
            'tipoEncuesta': 'AUTOINMUNES',
            'user': userSession
        }
    }

})

tablaPendientesEncuHistoriaClinica = $('#tablaPendientesEncuHistoriaClinica').DataTable({

    columns: [
        { name: '#', data: 'id_encuesta' },
        { name: '# BASE', data: 'id_base_encu' },
        { name: 'NO. HISTORIA CLINICA', data: 'no_historia_clinica' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
        { name: 'EDAD', data: 'edad' },
        { name: 'SEXO', data: 'sexo' },
        { name: 'ESPECIALIDAD', data: 'especialidad' },
        { name: 'PROFESIONAL AUDITADO', data: 'profesional_auditado' },
        { name: 'EPS', data: 'eps' },
        { name: 'FECHA ATENCION', data: 'fecha_atencion' },
        { name: 'MODALIDAD CONSULTA', data: 'modalidad_consulta' },
        { name: 'TIPO ENCUESTA', data: 'tipo_encuesta' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-success btn-sm" onclick="gestionarEncuesta(${row.id_encuesta},'${row.tipo_encuesta}')" title="Gestionar Encuesta"><i class="far fa-check-square"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/encuestas/encuestas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEncuestasPendientesUser',
            'tipoEncuesta': 'VIH',
            'user': userSession
        }
    }

})

tablaAdminProfesionales = $('#tablaAdminProfesionales').DataTable({

    columns: [
        { name: '#', data: 'id_pro_usu' },
        { name: 'TIPO ENCUESTA', data: 'tipo_encuesta' },
        { name: 'PROCESO', data: 'proceso' },
        { name: 'NOMBRE PROFESIONAL', data: 'nombre_profesional' },
        { name: 'DOCUMENTO PROFESIONAL', render: (data, type, row) => {
            return `${row.tipo_doc_profesional} - ${row.documento_profesional}`;
        } 
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-danger btn-sm" onclick="eliminarUsuarioProfesional(${row.id_pro_usu},'${row.proceso}','${row.nombre_profesional}')" title="Eliminar Usuario Profesional"><i class="fas fa-trash-alt"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/encuestas/encuestas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaUsuariosProfesionales',
        }
    }

})

tablaBolsaEncuestasTerminadasHistoriaClinica = $('#tablaBolsaEncuestasTerminadasHistoriaClinica').DataTable({

    columns: [
        { name: '#', data: 'id_encuesta' },
        { name: '# BASE', data: 'id_base_encu' },
        { name: 'NO. HISTORIA CLINICA', data: 'no_historia_clinica' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
        { name: 'EDAD', data: 'edad' },
        { name: 'SEXO', data: 'sexo' },
        { name: 'ESPECIALIDAD', data: 'especialidad' },
        { name: 'PROFESIONAL AUDITADO', data: 'profesional_auditado' },
        { name: 'EPS', data: 'eps' },
        { name: 'FECHA ATENCION', data: 'fecha_atencion' },
        { name: 'MODALIDAD CONSULTA', data: 'modalidad_consulta' },
        { name: 'TIPO ENCUESTA', data: 'tipo_encuesta' },
        { name: 'FECHA INICIO AUD', data: 'fecha_ini' },
        { name: 'FECHA FIN AUD', data: 'fecha_fin' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-success btn-sm" onclick="modificarEncuesta(${row.id_encuesta},'${row.tipo_encuesta}',${row.id_base_encu})" title="Modificar Encuesta"><i class="fas fa-pencil-ruler"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/encuestas/encuestas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEncuestasBolsaTerminadas',
            'tipoEncuesta': 'VIH',
            'user': userSession
        }
    }

})

tablaBolsaEncuestasTerminadasAutoinmunes = $('#tablaBolsaEncuestasTerminadasAutoinmunes').DataTable({

    columns: [
        { name: '#', data: 'id_encuesta' },
        { name: '# BASE', data: 'id_base_encu' },
        { name: 'NO. HISTORIA CLINICA', data: 'no_historia_clinica' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
        { name: 'EDAD', data: 'edad' },
        { name: 'SEXO', data: 'sexo' },
        { name: 'ESPECIALIDAD', data: 'especialidad' },
        { name: 'PROFESIONAL AUDITADO', data: 'profesional_auditado' },
        { name: 'EPS', data: 'eps' },
        { name: 'FECHA ATENCION', data: 'fecha_atencion' },
        { name: 'MODALIDAD CONSULTA', data: 'modalidad_consulta' },
        { name: 'TIPO ENCUESTA', data: 'tipo_encuesta' },
        { name: 'FECHA INICIO AUD', data: 'fecha_ini' },
        { name: 'FECHA FIN AUD', data: 'fecha_fin' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-success btn-sm" onclick="modificarEncuesta(${row.id_encuesta},'${row.tipo_encuesta}',${row.id_base_encu})" title="Modificar Encuesta"><i class="fas fa-pencil-ruler"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/encuestas/encuestas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEncuestasBolsaTerminadas',
            'tipoEncuesta': 'AUTOINMUNES',
            'user': userSession
        }
    }

})

const modificarEncuesta = (idEncuesta, tipoEncuesta) => {

    Swal.fire({
        title: "¿Desea Modificar la Auditoria?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Gestionar Auditoria!"
    }).then((result) => {

        if (result.isConfirmed) {

            window.location = 'index.php?ruta=encuestas/gestionarencuestamodificar&idEncuesta='+btoa(idEncuesta)+'&tipoEncuesta='+btoa(tipoEncuesta);
                
        }

    })

}

const eliminarUsuarioProfesional = async (idProUsu, procesoEncu, nombreProfesional) => {

    Swal.fire({
        html: `<h4>¿Desea eliminar el Usuario Profesional: <b>${nombreProfesional}</b> del Proceso: <b>${procesoEncu}</b>?</h4>`,
        icon: 'question',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si!"
    }).then(async (result) => {

        if (result.isConfirmed){

            $.ajax({

                url: 'ajax/encuestas/encuestas.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarUsuarioProfesional',
                    'idProUsu':idProUsu,
                    'userDelete':userSession
                },
                success:function(respuesta){
                    
                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡Se Elimino el Usuario Profesional correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=encuestas/adminprofesionalesencu';

                            }

                        })
                  
                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: '¡No se elimino el Usuario Profesional correctamente!',
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

}

const agregarUsuarioProfesional = () => {

    let formulario = document.getElementById("formAgregarUsuarioProfesional");
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

            // console.log(form);

            const formData = new FormData(form);

            formData.append('proceso', 'agregarUsuarioProfesional');
            formData.append('userCreate', userSession);

            for(const [key, value] of formData){

                // console.log(key, value);
            }

            $.ajax({

                url: 'ajax/encuestas/encuestas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡Se guardo el Usuario Profesional correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=encuestas/adminprofesionalesencu';

                            }

                        })

                    }else if(respuesta == 'usu-pro-existe'){
                        
                        Swal.fire({
                            text: '¡El Usuario Profesional ya esta registrado al Proceso seleccionado!',
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })
                    
                    }else{

                        Swal.fire({
                            text: '¡El Usuario Profesional no se guardo correctamente!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "Error!");

        }

    }

}
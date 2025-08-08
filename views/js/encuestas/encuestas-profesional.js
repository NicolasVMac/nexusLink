/*==============================
VARIABLES DE RUTA
==============================*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let url = new URL(window.location.href);
let rutaValor = url.searchParams.get("ruta");
let tablaBasesEncuestasPro;

const obtenerEspecialidades = async (especialidad) => {

    console.log(especialidad);

    let datos = new FormData();
    datos.append('proceso','listaEspecialidades');
    datos.append('especialidad', especialidad);

    const especialidades = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!especialidades){

        console.error("Sin especialidades"); 
        return;
    }

    // console.log(especialidades);

    return especialidades;

}

const cargarBaseEncuestasProfesional = () =>{

    let formulario = document.getElementById("formCargarArchivoEncuestasProfesional");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let nombreArchivo = document.getElementById("nombreArchivoEncuestaPro").value;
            let especialidad = document.getElementById("tipoEspecialidadProfesional").value;
            let nivelConfianza = document.getElementById("nivelConfianzaPro").value;
            let margenError = document.getElementById("margenErrorPro").value;
            let archivo = document.querySelector("#archivoEncuestaPro").files;
            let auditor = document.getElementById("auditorAudProfesional").value;

            // console.log(archivo[0]);

            let data = new FormData();
            data.append("proceso", "cargarArchivoEncuestas");
            data.append("nombreArchivo", nombreArchivo);
            data.append("especialidad", especialidad);
            data.append("nivelConfianza", nivelConfianza);
            data.append("margenError", margenError);
            data.append("auditorEncuesta", auditor);
            data.append("archivoEncuesta", archivo[0]);
            data.append("user", userSession);

            $.ajax({

                url: 'ajax/encuestas/encuestas-profesional.ajax.php',
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

                                window.location = 'index.php?ruta=encuestas/cargaraudprofesional';

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

                                window.location = 'index.php?ruta=encuestas/cargaraudprofesional';

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

                                window.location = 'index.php?ruta=encuestas/cargaraudprofesional';

                            }

                        })

                    }

                }

            })



        }

    }

}


const tomarEncuesta = (idEncuesta, especialidad, idBaseEncuesta) => {

    Swal.fire({
        title: "¿Desea Gestionar la Auditoria Profesional?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Gestionar Auditoria Profesional!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/encuestas/encuestas-profesional.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'tomarEncuestaProfesional',
                    'idEncuesta': idEncuesta,
                    'auditor': userSession,
                    'nombreUser': userName,
                    'idBaseEncuesta': idBaseEncuesta,
                    'especialidad': especialidad
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

                                window.location = 'index.php?ruta=encuestas/gestionarencuestaprofesional&idEncuesta='+btoa(idEncuesta)+'&especialidad='+btoa(especialidad);

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

                                window.location = 'index.php?ruta=encuestas/bolsaaudprofesional';

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

                                window.location = 'index.php?ruta=encuestas/bolsaaudprofesional';

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

                                window.location = 'index.php?ruta=encuestas/bolsaaudprofesional';

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

                                window.location = 'index.php?ruta=encuestas/bolsaaudprofesional';

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

const gestionarEncuestaProfesional = (idEncuesta, especialidad) => {

    window.location = 'index.php?ruta=encuestas/gestionarencuestaprofesional&idEncuesta='+btoa(idEncuesta)+'&especialidad='+btoa(especialidad);

}

const modificarEncuesta = (idEncuesta, especialidad) => {

    Swal.fire({
        title: "¿Desea Modificar la Auditoria Profesional?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Gestionar Auditoria!"
    }).then((result) => {

        if (result.isConfirmed) {

            window.location = 'index.php?ruta=encuestas/gestionarencuestapromodificar&idEncuesta='+btoa(idEncuesta)+'&especialidad='+btoa(especialidad);
                
        }

    })

}


tablaBasesEncuestasPro = $('#tablaBasesEncuestasPro').DataTable({
    columns: [
        { name: '#', data: 'id_base_encuesta' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre_archivo' },
        { name: 'ESPECIALIDAD', data: 'especialidad' },
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
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'basesCargadasEncuestas'
        }
    }
    

});


if(rutaValor === 'encuestas/bolsaaudprofesional'){

    $.ajax({

        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaBolsasEncuestasProfesional',
            'user': userSession,
        },
        cache: false,
        dataType: "json",
        success:function(bolsasEspe){

            let containerBolsa = ``;

            bolsasEspe.forEach((bolsaEsp) => {

                let especialidadKey = bolsaEsp.especialidad.replace('.', '').split(' ').join('-');

                containerBolsa += `<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-primary">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Bolsa Encuestas Profesional ${bolsaEsp.especialidad}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablaBolsaEncuestas${especialidadKey}" class="table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th># BASE</th>
                                        <th>NO. HISTORIA CLINICA</th>
                                        <th>NOMBRE PACIENTE</th>
                                        <th>EDAD</th>
                                        <th>SEXO</th>
                                        <th>ESPECIALIDAD</th>
                                        <th>PROFESIONAL AUDITADO</th>
                                        <th>EPS</th>
                                        <th>FECHA ATENCION</th>
                                        <th>MODALIDAD CONSULTA o TIPO ATENCION</th>
                                        <th>ESPECIALIDAD</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>  
                    </div>
                </div>`;

            })

            $("#contenedorBolsasAudProfesional").html(containerBolsa);

            bolsasEspe.forEach(bolsaEsp => {

                let especialidadKey = bolsaEsp.especialidad.replace('.', '').split(' ').join('-');
                let cadena = `tablaBolsaEncuestas${especialidadKey}`;

                cadena = $(`#${cadena}`).DataTable({

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
                        { name: 'MODALIDAD CONSULTA', data: 'modalidad_consulta_tipo_atencion' },
                        { name: 'especialista', data: 'especialidad' },
                        {
                            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                                return `<button type="button" class="btn btn-success btn-sm" onclick="tomarEncuesta(${row.id_encuesta},'${row.especialidad}',${row.id_base_encu})" title="Tomar Encuesta"><i class="far fa-check-square"></i></button>`;
                            }
                        }
                    ],
                    ordering: false,
                    ajax: {
                        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'listaEncuestasBolsaProfesional',
                            'especialidad': bolsaEsp.especialidad,
                            'user': userSession
                        }
                    }
                
                })


            })

        }

    })

}

if(rutaValor === 'encuestas/pendientesaudprofesional'){

    $.ajax({

        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaBolsasPendientesEncuestasProfesional',
            'user': userSession,
        },
        cache: false,
        dataType: "json",
        success:function(bolsasEspe){

            // console.log(bolsasEspe);

            let containerBolsa = ``;

            bolsasEspe.forEach((bolsaEsp) => {

                let especialidadKey = bolsaEsp.especialidad.replace('.', '').split(' ').join('-');

                containerBolsa += `<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-primary">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Bolsa Encuestas Profesional ${bolsaEsp.especialidad}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablaBolsaPendientesEncuestas${especialidadKey}" class="table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th># BASE</th>
                                        <th>NO. HISTORIA CLINICA</th>
                                        <th>NOMBRE PACIENTE</th>
                                        <th>EDAD</th>
                                        <th>SEXO</th>
                                        <th>ESPECIALIDAD</th>
                                        <th>PROFESIONAL AUDITADO</th>
                                        <th>EPS</th>
                                        <th>FECHA ATENCION</th>
                                        <th>MODALIDAD CONSULTA o TIPO ATENCION</th>
                                        <th>ESPECIALIDAD</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>  
                    </div>
                </div>`;

            })

            $("#contenedorBolsasPendientesAudProfesional").html(containerBolsa);

            bolsasEspe.forEach(bolsaEsp => {

                let especialidadKey = bolsaEsp.especialidad.replace('.', '').split(' ').join('-');
                let cadena = `tablaBolsaPendientesEncuestas${especialidadKey}`;

                cadena = $(`#${cadena}`).DataTable({

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
                        { name: 'MODALIDAD CONSULTA', data: 'modalidad_consulta_tipo_atencion' },
                        { name: 'especialista', data: 'especialidad' },
                        {
                            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                                return `<button type="button" class="btn btn-primary btn-sm" onclick="gestionarEncuestaProfesional(${row.id_encuesta},'${row.especialidad}')" title="Gestionar Encuesta"><i class="far fa-arrow-alt-circle-right"></i></button>`;
                            }
                        }
                    ],
                    ordering: false,
                    ajax: {
                        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'listaEncuestasBolsaPendientesProfesional',
                            'especialidad': bolsaEsp.especialidad,
                            'user': userSession
                        }
                    }
                
                })


            })

        }

    })

}

if(rutaValor === 'encuestas/bolsasterminandasaudprofesional'){

    $.ajax({

        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaBolsasTerminadasEncuestasProfesional',
            'user': userSession,
        },
        cache: false,
        dataType: "json",
        success:function(bolsasEspe){

            console.log(bolsasEspe);

            let containerBolsa = ``;

            bolsasEspe.forEach((bolsaEsp) => {

                let especialidadKey = bolsaEsp.especialidad.replace('.', '').split(' ').join('-');

                containerBolsa += `<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-primary">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Bolsa Encuestas Profesional Terminadas ${bolsaEsp.especialidad}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablaBolsaTerminandasEncuestas${especialidadKey}" class="table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th># BASE</th>
                                        <th>NO. HISTORIA CLINICA</th>
                                        <th>NOMBRE PACIENTE</th>
                                        <th>EDAD</th>
                                        <th>SEXO</th>
                                        <th>ESPECIALIDAD</th>
                                        <th>PROFESIONAL AUDITADO</th>
                                        <th>EPS</th>
                                        <th>FECHA ATENCION</th>
                                        <th>MODALIDAD CONSULTA o TIPO ATENCION</th>
                                        <th>ESPECIALIDAD</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>  
                    </div>
                </div>`;

            })

            $("#contenedorBolsasAudProfesionalTerminadas").html(containerBolsa);

            bolsasEspe.forEach(bolsaEsp => {

                let especialidadKey = bolsaEsp.especialidad.replace('.', '').split(' ').join('-');
                let cadena = `tablaBolsaTerminandasEncuestas${especialidadKey}`;

                cadena = $(`#${cadena}`).DataTable({

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
                        { name: 'MODALIDAD CONSULTA', data: 'modalidad_consulta_tipo_atencion' },
                        { name: 'especialista', data: 'especialidad' },
                        {
                            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                                return `<button type="button" class="btn btn-success btn-sm" onclick="modificarEncuesta(${row.id_encuesta},'${row.especialidad}')" title="Modificar Encuesta"><i class="far fa-edit"></i></button>`;
                            }
                        }
                    ],
                    ordering: false,
                    ajax: {
                        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'listaEncuestasBolsaTerminadasProfesional',
                            'especialidad': bolsaEsp.especialidad,
                            'user': userSession
                        }
                    }
                
                })


            })

        }

    })

}
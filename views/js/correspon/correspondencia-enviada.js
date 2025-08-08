let tablaMiCorrespondenciaEnviada;
let tablaListaCorrespondenciaEnviada;

let editorExist = document.querySelector('.editor');

if(editorExist){
    
    ClassicEditor
    .create( document.querySelector('.editor'),{
        toolbar: {
            items: [
            'bold', 'italic', '|',
            'bulletedList', 'numberedList', '|',
            'undo', 'redo', '|',
        ]
    }
    })

}


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

const crearNuevoConsecutivo = () => {

    let formulario = document.getElementById("formAgregarConsecutivo");
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

            let form = document.querySelector('#formAgregarConsecutivo');

            const formData = new FormData(form);

            formData.append('proceso', 'crearNuevoConsecutivo');
            formData.append('userSession', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }


            Swal.fire({
                title: "¿Desea Crar un nuevo Consecutivo?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si, Crear Consecutivo!"
            }).then((result) => {
        
                if(result.isConfirmed){

                    $.ajax({

                        url: 'ajax/correspon/correspondencia-enviada.ajax.php',
                        type: 'POST',
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success:function(respuesta){
        
                            if(respuesta.resp == 'ok'){
        
                                Swal.fire({

                                    html: `¡Se genero Codigo Consecutivo correctamente!</br></br>
                                        <h4><b>${respuesta.codigoConsecutivo}</b></h4>`,
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33",
        
                                }).then((result) =>{
        
                                    tablaMiCorrespondenciaEnviada.ajax.reload();
                                    $('#proyectosCorrespondencia').val('').trigger('change');
                                    $('#tipoComuniCorrespondencia').val('').trigger('change');
                                    
                                })
        
                            }else if(respuesta.resp == 'error-save-codigo'){
        
                                Swal.fire({
                                    text: 'El Codigo Consecutivo no se guardo correctamente',
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                })
        
        
                            }else{

                                Swal.fire({
                                    text: 'Contacte al administrador. algo salio mal.',
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

const verInfoCorrespondencia = async (idCorrespondenciaEnv, accion) => {

    let datos = new FormData();
    datos.append('proceso','infoCorrespondenciaEnv');
    datos.append('idCorresponEnv', idCorrespondenciaEnv);

    const infoCorrespondencia = await $.ajax({
        url: 'ajax/correspon/correspondencia-enviada.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!infoCorrespondencia){

        console.error("No existe Correspondencia"); 
        return;
    }

    // console.log(infoCorrespondencia);

    if(accion === 'ANULAR-CORRESPONDENCIA'){

        $("#idCorresEnvAnular").val(infoCorrespondencia.id_corr_env);
        $("#codigoCorresAnular").val(infoCorrespondencia.codigo);
        $("#textCodigoAnular").html(infoCorrespondencia.codigo);
        $("#textProyectoAnular").html(infoCorrespondencia.nombre_proyecto);
        $("#textDescripcionAnular").html(infoCorrespondencia.descripcion);
        $("#textDestinatarioAnular").html(infoCorrespondencia.destinatario);
        $("#textTipoComunicacionAnular").html(infoCorrespondencia.tipo_comunicacion);
        $("#textAsuntoAnular").html(infoCorrespondencia.asunto);
        $("#textUsuarioCreaAnular").html(infoCorrespondencia.nombre);
        $("#textFechaCreaAnular").html(infoCorrespondencia.fecha_crea);

    }else if(accion === 'RADICAR-CORRESPONDENCIA'){

        $("#idCorresEnvRadCorres").val(infoCorrespondencia.id_corr_env);
        $("#textCodigoRadCorres").html(infoCorrespondencia.codigo);
        $("#textProyectoRadCorres").html(infoCorrespondencia.nombre_proyecto);
        $("#textTipoComunicacionCorres").html(infoCorrespondencia.tipo_comunicacion);
        $("#textUsuarioCreaRadCorres").html(infoCorrespondencia.nombre);
        $("#textFechaCreaRadCorres").html(infoCorrespondencia.fecha_crea);
        
    }else if(accion == 'RESPUESTA-CORRESPONDENCIA'){
        
        $("#idCorresEnvRespCorres").val(infoCorrespondencia.id_corr_env);
        $("#textCodigoRespCorres").html(infoCorrespondencia.codigo);
        $("#textProyectoRespCorres").html(infoCorrespondencia.nombre_proyecto);
        $("#textDescripcionRespCorres").html(infoCorrespondencia.descripcion);
        $("#textDestinatarioRespCorres").html(infoCorrespondencia.destinatario);
        $("#textTipoComunicacionRespCorres").html(infoCorrespondencia.tipo_comunicacion);
        $("#textAsuntoRespCorres").html(infoCorrespondencia.asunto);
        $("#textUsuarioCreaRespCorres").html(infoCorrespondencia.usuario_crea);
        $("#textFechaCreaRespCorres").html(infoCorrespondencia.fecha_crea);
        $("#textUsuarioRadicaRespCorres").html(infoCorrespondencia.usuario_radicacion);
        $("#textFechaRadicaRespCorres").html(infoCorrespondencia.fecha_radicacion);

        if(infoCorrespondencia.archivosCorresEnv === 'SIN ARCHIVOS'){

            $("#containerArchivosEnviadosCorres").html(`<b>SIN ARCHIVOS</b>`);
    
        }else{
    
            let cadena = `<ul class="list-group">`;
    
            for(const archivo of infoCorrespondencia.archivosCorresEnv){
    
                cadena += `<li class="list-group-item"><a href="${infoCorrespondencia.ruta_archivo_env+archivo}" target="_blank">${archivo}</a></li>`;
                
            }
    
            cadena += `</ul>`;
    
            $("#containerArchivosEnviadosCorres").html(cadena);
    
        }


    }else if(accion === 'VER-CORRESPONDENCIA'){

        $("#textCodigoVer").html(infoCorrespondencia.codigo);
        $("#textProyectoVer").html(infoCorrespondencia.nombre_proyecto);
        $("#textDescripcionRadicacionVer").html(infoCorrespondencia.descripcion);
        $("#textDestinatarioRadicacionVer").html(infoCorrespondencia.destinatario);
        $("#textTipoComunicacionVer").html(infoCorrespondencia.tipo_comunicacion);
        $("#textAsuntoVer").html(infoCorrespondencia.asunto);
        $("#textUsuarioCreaVer").html(infoCorrespondencia.usuario_crea);
        $("#textFechaCreaVer").html(infoCorrespondencia.fecha_crea);
        $("#textUsuarioRadicacionVer").html(infoCorrespondencia.usuario_radicacion);
        $("#textFechaRadicacionVer").html(infoCorrespondencia.fecha_radicacion);
        $("#textUsuarioRadicadoVer").html(infoCorrespondencia.usuario_radicado);
        $("#textFechaRadicadoVer").html(infoCorrespondencia.fecha_radicado);

        if(infoCorrespondencia.archivosCorresEnv === 'SIN ARCHIVOS'){

            $("#containerArchivosEnviadosCorresVer").html(`<b>SIN ARCHIVOS</b>`);
    
        }else{
    
            let cadena = `<ul class="list-group">`;
    
            for(const archivo of infoCorrespondencia.archivosCorresEnv){
    
                cadena += `<li class="list-group-item"><a href="${infoCorrespondencia.ruta_archivo_env+archivo}" target="_blank">${archivo}</a></li>`;
                
            }
    
            cadena += `</ul>`;
    
            $("#containerArchivosEnviadosCorresVer").html(cadena);
    
        }

        if(infoCorrespondencia.archivosCorresRec === 'SIN ARCHIVOS'){

            $("#containerArchivosRespuestaCorresVer").html(`<b>SIN ARCHIVOS</b>`);
    
        }else{
    
            let cadena = `<ul class="list-group">`;
    
            for(const archivo of infoCorrespondencia.archivosCorresRec){
    
                cadena += `<li class="list-group-item"><a href="${infoCorrespondencia.ruta_archivo_rec+archivo}" target="_blank">${archivo}</a></li>`;
                
            }
    
            cadena += `</ul>`;
    
            $("#containerArchivosRespuestaCorresVer").html(cadena);
    
        }

        if(infoCorrespondencia.estado === 'ANULADO'){

            $("#containerCorrespondenciaAnulado").html(`
                
                <div class="card shadow-sm mb-2">
                    <div class="card-header p-3 border-bottom border-300">
                        <div class="row g-1 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h5 class="text-danger mb-0">Correspondencia Anulada</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                <label for="" class="fw-bold">Observaciones</label>
                                <div>${infoCorrespondencia.motivo_anula}</div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                <label for="" class="fw-bold">Usuario Anula</label>
                                <div>${infoCorrespondencia.usuario_anula}</div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                <label for="" class="fw-bold">Fecha Anula</label>
                                <div>${infoCorrespondencia.fecha_anula}</div>
                            </div>
                        </div>
                    </div>
                </div>

            `);

        }else{

            $("#containerCorrespondenciaAnulado").html(``);

        }

    }

}

const anularCorrespondenciaEnv = () => {

    let formulario = document.getElementById("formAnularCorrespondencia");
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

            let form = document.querySelector('#formAnularCorrespondencia');

            const formData = new FormData(form);

            formData.append('proceso', 'anularCorrespondenciaEnv');
            formData.append('userSession', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            let codigo = formData.get('codigoCorresAnular');

            Swal.fire({
                title: `¿Desea Anular la Correspondencia: ${codigo}?`,
                icon: 'question',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si, Anular!"
            }).then((result) => {
        
                if(result.isConfirmed){

                    $.ajax({

                        url: 'ajax/correspon/correspondencia-enviada.ajax.php',
                        type: 'POST',
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success:function(respuesta){
        
                            if(respuesta == 'ok'){
        
                                Swal.fire({

                                    title: `¡La Correspondencia se Anulo correctamente!`,
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33",
        
                                }).then((result) =>{
                                    
                                    window.location = 'index.php?ruta=correspon/micorresponenv';
                                    
                                })
        
                            }else{

                                Swal.fire({
                                    text: '¡La Correspondencia no se Anulo, contacte al administrador!',
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

const validarArchivoPDF = async (archivo) => {

    let archivos = archivo.files;

    let noValid = false;

    if(archivos.length > 0){

        for (const item of archivos) {
            
            if (item["type"] != "application/pdf") {

                noValid = true;
                
            }
            
        }
        
        if(noValid){
            Swal.fire({
                
                title: "Archivo No Valido",
                text: "¡Los archivos debe tener formato .PDF!",
                icon: "error",
                confirmButtonText: "¡Cerrar!",
                confirmButtonColor: "#d33"
                
            });
        }

        return noValid;


    }else{

        Swal.fire({

            title: "Archivo No Valido",
            text: "¡Los archivos debe tener formato .PDF!",
            icon: "error",
            confirmButtonText: "¡Cerrar!",
            confirmButtonColor: "#d33"

        });

    }

}

const radicarCorrespondenciaEnv = async () => {

    let formulario = document.getElementById("formRadicarCorrespondencia");
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

            let form = document.querySelector('#formRadicarCorrespondencia');

            let descripcionRadCorres = document.querySelector('textarea[name="descripcionRadCorres"]');
            descripcionRadCorres = descripcionRadCorres.value;

            if(descripcionRadCorres){
                
                const formData = new FormData(form);
                
                let archivosRadCorres = document.getElementById("archivosRadCorres");
                
                formData.append('proceso', 'radicarCorrespondenciaEnv');
                formData.append('user', userSession);
                formData.append('descripcionRadCorres', descripcionRadCorres);
                for(let file of archivosRadCorres.files){
                    formData.append('archivosRadCorres[]', file);
                }
                
                //VALIDACION ARCHIVOS
                let validFiles = await validarArchivoPDF(archivosRadCorres);

                // for(const [key, value] of formData){
                //     console.log(key, value);
                // }

                if(!validFiles){

                    loadingFnc();
        
                    $.ajax({
        
                        url: 'ajax/correspon/correspondencia-enviada.ajax.php',
                        type: 'POST',
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(respuesta){
        
                            Swal.close();
        
                            if(respuesta == 'ok'){
        
                                Swal.fire({
                                    text: '¡Se Radico la Correspondencia correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=correspon/micorresponenv';
        
                                    }
        
                                })
        
                            }else{
        
                                Swal.fire({
                                    text: '¡No se Radico la Correspondencia correctamente!',
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

            }else{

                toastr.warning("Recuerde diligenciar el campo Descripcion.", "¡Atencion!");

            }


        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const respuestaCorrespondenciaEnv = async () => {

    let formulario = document.getElementById("formRespuestaCorrespondencia");
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

            let form = document.querySelector('#formRespuestaCorrespondencia');

            const formData = new FormData(form);

            let archivosRespCorres = document.getElementById("archivosRespCorres");

            formData.append('proceso', 'respuestaCorrespondenciaEnv');
            formData.append('user', userSession);
            for(let file of archivosRespCorres.files){
                formData.append('archivosRespCorres[]', file);
            }

            //VALIDACION ARCHIVOS
            let validFiles = await validarArchivoPDF(archivosRespCorres);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            if(!validFiles){

                loadingFnc();
    
                $.ajax({
    
                    url: 'ajax/correspon/correspondencia-enviada.ajax.php',
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){
    
                        Swal.close();
    
                        if(respuesta == 'ok'){
    
                            Swal.fire({
                                text: '¡Se Guardo la Respuesta de la Correspondencia correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{
    
                                if(result.isConfirmed){
    
                                    window.location = 'index.php?ruta=correspon/micorresponenv';
    
                                }
    
                            })
    
                        }else{
    
                            Swal.fire({
                                text: '¡No se Guardo la Respuesta de la Correspondencia correctamente!',
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



        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

tablaMiCorrespondenciaEnviada = $('#tablaMiCorrespondenciaEnviada').DataTable({

    columns: [
        { name: '#', data: 'id_corr_env' },
        { name: 'ASUNTO', data: 'asunto' },
        { name: 'PROYECTO', data: 'nombre_proyecto' },
        { name: 'CODIGO', data: 'codigo' },
        { name: 'DESTINATARIO', data: 'destinatario' },
        { name: 'TIPO COMUNICACION', data: 'tipo_comunicacion' },
        { name: 'FECHA CREA', data: 'fecha_crea' },
        { name: 'ESTADO', render: function(data, type, row){

            if(row.estado === 'CREADO'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-warning"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span></span>`;

            }else if(row.estado === 'RADICANDO'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-info"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span>`;

            }else if(row.estado === 'RADICADO'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;
                
            }else{
                
                return `<span class="badge badge-phoenix fs--2 badge-phoenix-danger"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;

            }

        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                if(row.estado === 'CREADO'){

                    return `
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
    
                            <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorres" onclick="verInfoCorrespondencia(${row.id_corr_env}, 'VER-CORRESPONDENCIA')" title="Ver Correspondencia"><i class="far fa-eye"></i></button>
    
                            <button class="btn btn-phoenix-primary" data-bs-toggle="modal" data-bs-target="#modalRadicarCorres" onclick="verInfoCorrespondencia(${row.id_corr_env}, 'RADICAR-CORRESPONDENCIA')" title="Radicar Correspondencia"><i class="fas fa-file-export"></i></button>
    
                            <button class="btn btn-phoenix-danger" data-bs-toggle="modal" data-bs-target="#modalAnularCorres" onclick="verInfoCorrespondencia(${row.id_corr_env}, 'ANULAR-CORRESPONDENCIA')" title=""><i class="fas fa-ban"></i></button>
    
                        </div>
                    `;
                    
                }else if(row.estado === 'RADICANDO'){
                    
                    return `
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
    
                            <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorres" onclick="verInfoCorrespondencia(${row.id_corr_env}, 'VER-CORRESPONDENCIA')" title="Ver Correspondencia"><i class="far fa-eye"></i></button>
    
                            <button class="btn btn-phoenix-success" data-bs-toggle="modal" data-bs-target="#modalRespuestaCorres" onclick="verInfoCorrespondencia(${row.id_corr_env}, 'RESPUESTA-CORRESPONDENCIA')" title="Respuesta Correspondencia"><i class="fas fa-file-import"></i></button>
    
                            <button class="btn btn-phoenix-danger" data-bs-toggle="modal" data-bs-target="#modalAnularCorres" onclick="verInfoCorrespondencia(${row.id_corr_env}, 'ANULAR-CORRESPONDENCIA')" title=""><i class="fas fa-ban"></i></button>
    
                        </div>
                    `;

                }else{

                    return `
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
    
                            <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorres" onclick="verInfoCorrespondencia(${row.id_corr_env}, 'VER-CORRESPONDENCIA')" title="Ver Correspondencia"><i class="far fa-eye"></i></button>
    
                        </div>
                    `;

                }

            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/correspon/correspondencia-enviada.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaMiCorrespondenciaEnviada',
            'userSesion': userSession,
        }
    }

})

tablaListaCorrespondenciaEnviada = $('#tablaListaCorrespondenciaEnviada').DataTable({

    columns: [
        { name: '#', data: 'id_corr_env' },
        { name: 'ASUNTO', data: 'asunto' },
        { name: 'PROYECTO', data: 'nombre_proyecto' },
        { name: 'CODIGO', data: 'codigo' },
        { name: 'DESTINATARIO', data: 'destinatario' },
        { name: 'TIPO COMUNICACION', data: 'tipo_comunicacion' },
        { name: 'FECHA CREA', data: 'fecha_crea' },
        { name: 'ESTADO', render: function(data, type, row){

            if(row.estado === 'CREADO'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-warning"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span></span>`;

            }else if(row.estado === 'RADICANDO'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-info"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span>`;

            }else if(row.estado === 'RADICADO'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;
                
            }else{
                
                return `<span class="badge badge-phoenix fs--2 badge-phoenix-danger"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;

            }

        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <div class="btn-group btn-group-sm" role="group" aria-label="...">

                        <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorres" onclick="verInfoCorrespondencia(${row.id_corr_env}, 'VER-CORRESPONDENCIA')" title="Ver Correspondencia"><i class="far fa-eye"></i></button>

                    </div>
                `;


            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/correspon/correspondencia-enviada.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaCorrespondenciaEnviada',
        }
    }

})

$('#tablaListaCorrespondenciaEnviada thead tr').clone(true).appendTo('#tablaListaCorrespondenciaEnviada thead');

$('#tablaListaCorrespondenciaEnviada thead tr:eq(1) th').each( function (i) {

    var title = $(this).text();
    $(this).html( '<input type="text" class="form-control" placeholder="Buscar..." />' );

    $( 'input', this ).on( 'keyup change', function () {

        if(tablaListaCorrespondenciaEnviada.column(i).search() !== this.value){

            tablaListaCorrespondenciaEnviada
                .column(i)
                .search( this.value )
                .draw();

        }

    })

})

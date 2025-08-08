function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}



let tablaCorresponRecCargada;
let tablaBandejaCorresRec;
let tablaMiCorresponRec;
let idCorrespondenciaRec = atob(getParameterByName('idCorresRec'));
let url = new URL(window.location.href);
let rutaValor = url.searchParams.get("ruta");


$.ajax({
    type: 'POST',
    url: 'ajax/correspon/correspondencia-recibida.ajax.php',
    data: {
        'proceso': 'listaUsuariosCorresponRecibida',
        'idUserSesion': idUserSession
    },
}).done(function(usuarios){

    $("#usuarioResponsableCorresRec").html(usuarios);

})

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

const changeProyectoCorresponRec = (elementHTML) => {

    let containerTipoCorrespondenciaRec = document.querySelector('#containerTipoCorrespondenciaRec');

    $.ajax({
            
        url: 'ajax/correspon/proyectos.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'obtenerInfoProyecto',
            'idProyecto': elementHTML.value
        },
        cache: false,
        dataType: "json",
        success:function(resp){

            $("#responProyectoCorresRec").val(resp.nombre);
            $("#idResponProyectoCorresRec").val(resp.id_usuario_responsable);

        }

    })

    if(elementHTML.value !== ''){
        containerTipoCorrespondenciaRec.style.display = 'block';
    }else{
        containerTipoCorrespondenciaRec.style.display = 'none';
    }

}


const changeProyectoCorresponRecReAsignar = (elementHTML) => {

    $.ajax({
            
        url: 'ajax/correspon/proyectos.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'obtenerInfoProyecto',
            'idProyecto': elementHTML.value
        },
        cache: false,
        dataType: "json",
        success:function(resp){

            $("#responProyectoCorresRecReAsignar").val(resp.nombre);
            $("#idResponProyectoCorresRecReAsignar").val(resp.id_usuario_responsable);

        }

    })

}

const changeTipoCorresponRec = (elementHTML) => {

    let containerRadicado = document.querySelector('#containerRadicadoCorresRec');
    let proyectoCorresponRec = document.querySelector('#nuevoProyectoCorresRec').value;

    if(elementHTML.value === 'RADICADOS/RESPUESTAS'){

        containerRadicado.style.display = 'block';

        $.ajax({

            type: "POST",
            url: "ajax/correspon/correspondencia-recibida.ajax.php",
            data: {
                'proceso': 'selectListaRadicado',
                'idProyecto': proyectoCorresponRec
            },
            success:function(respuesta){
                $("#containerRadicadoCorresRec").html(respuesta);
            }
        
        })

    }else{
        containerRadicado.style.display = 'none';
        $("#containerRadicadoCorresRec").html('');
    }

}

const verInfoCorrespondiaRecibida = async (idCorrRec) => {

    let datos = new FormData();
    datos.append('proceso','infoCorrespondenciaRec');
    datos.append('idCorresponRec', idCorrRec);

    const infoCorrespondencia = await $.ajax({
        url: 'ajax/correspon/correspondencia-recibida.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!infoCorrespondencia){
        console.error("No existe Correspondencia Recibida"); 
        return;
    }

    // console.log(infoCorrespondencia);

    $("#textIdCorresRecibida").html(infoCorrespondencia.id_corr_rec);
    $("#textAsuntoVer").html(infoCorrespondencia.asunto);
    $("#textObservacionesVer").html(infoCorrespondencia.observaciones);
    $("#textProyectoVer").html(infoCorrespondencia.nombre_proyecto);
    $("#textResponsableProyectoVer").html(infoCorrespondencia.nombre);
    $("#textTipoCorresponVer").html(infoCorrespondencia.tipo_correspondencia);
    $("#textUsuarioCreaVer").html(infoCorrespondencia.usuario_crea);
    $("#textFechaCreaVer").html(infoCorrespondencia.fecha_crea);

    if(infoCorrespondencia.archivosCorresEnv === 'SIN ARCHIVOS'){

        $("#contenedorArchivosCorresRec").html(`<b>SIN ARCHIVOS</b>`);

    }else{

        let cadena = `<ul class="list-group">`;

        for(const archivo of infoCorrespondencia.archivosCorresRec){

            cadena += `<li class="list-group-item"><a href="${infoCorrespondencia.ruta_archivo_rec+archivo}" target="_blank">${archivo}</a></li>`;
            
        }

        cadena += `</ul>`;

        $("#contenedorArchivosCorresRec").html(cadena);

    }


    if(infoCorrespondencia.id_corr_env){

        let datos = new FormData();
        datos.append('proceso','infoCorrespondenciaEnv');
        datos.append('idCorresponEnv', infoCorrespondencia.id_corr_env);

        const infoCorrespondenciaEnv = await $.ajax({
            url: 'ajax/correspon/correspondencia-enviada.ajax.php',
            type: 'POST',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json"
        });

        if(!infoCorrespondenciaEnv){

            console.error("No existe Correspondencia Env"); 
            return;
        }

        // console.log(infoCorrespondenciaEnv);

        let cardHTMLCorresEnv = `
            <div class="d-grid gap-2 mb-2">
                <a class="btn btn-phoenix-success mt-2" data-bs-toggle="collapse" href="#collapseCorresEnv" role="button" aria-expanded="false" aria-controls="collapseCorresEnv">Informacion Correspondencia Enviada</a>
            </div>
            <div class="collapse" id="collapseCorresEnv">
                <div class="card shadow-sm mb-2">
                    <div class="card-header p-3 border-bottom border-300">
                        <div class="row g-1 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h5 class="text-success mb-0">Correspondencia Enviada</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="card shadow-sm mb-2">
                                <div class="card-header p-3 border-bottom border-300">
                                    <div class="row g-1 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-info mb-0">Informacion Correspondencia</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-lg-6 mb-4">
                                            <label for="" class="fw-bold">Codigo</label>
                                            <div>${infoCorrespondenciaEnv.codigo}</div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Proyecto</label>
                                            <div>${infoCorrespondenciaEnv.nombre_proyecto}</div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Asunto</label>
                                            <div>${infoCorrespondenciaEnv.asunto}</div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Usuario Crea</label>
                                            <div>${infoCorrespondenciaEnv.usuario_crea}</div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Fecha Crea</label>
                                            <div>${infoCorrespondenciaEnv.fecha_crea}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-sm mb-2">
                                <div class="card-header p-3 border-bottom border-300">
                                    <div class="row g-1 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-primary mb-0">Correspondencia Radicada</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Documentos Radicados</label>`;

                                            if(infoCorrespondenciaEnv.archivosCorresEnv === 'SIN ARCHIVOS'){

                                                // $("#contenedorArchivosCorresRec").html(`<b>SIN ARCHIVOS</b>`);

                                                cardHTMLCorresEnv += `<b>SIN ARCHIVOS</b>`;
                                        
                                            }else{
                                        
                                                cardHTMLCorresEnv += `<ul class="list-group">`;
                                        
                                                for(const archivo of infoCorrespondenciaEnv.archivosCorresEnv){
                                        
                                                    cardHTMLCorresEnv += `<li class="list-group-item"><a href="${infoCorrespondenciaEnv.ruta_archivo_env+archivo}" target="_blank">${archivo}</a></li>`;
                                                    
                                                }
                                        
                                                cardHTMLCorresEnv += `</ul>`;
                                        
                                                // $("#contenedorArchivosCorresRec").html(cadena);
                                        
                                            }
                                        

                                           cardHTMLCorresEnv += `
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Usuario Radicacion</label>
                                            <div>${infoCorrespondenciaEnv.usuario_radicacion}</div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Fecha Radicacion</label>
                                            <div>${infoCorrespondenciaEnv.fecha_radicacion}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-sm mb-2">
                                <div class="card-header p-3 border-bottom border-300">
                                    <div class="row g-1 justify-content-between align-items-center">
                                        <div class="col-12 col-md">
                                            <h5 class="text-success mb-0">Respuesta Correspondencia Radicada</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                            <label for="" class="fw-bold">Documentos Respuesta Radicada</label>`;

                                            if(infoCorrespondenciaEnv.archivosCorresRec === 'SIN ARCHIVOS'){

                                                // $("#contenedorArchivosCorresRec").html(`<b>SIN ARCHIVOS</b>`);

                                                cardHTMLCorresEnv += `<b>SIN ARCHIVOS</b>`;
                                        
                                            }else{
                                        
                                                cardHTMLCorresEnv += `<ul class="list-group">`;
                                        
                                                for(const archivo of infoCorrespondenciaEnv.archivosCorresRec){
                                        
                                                    cardHTMLCorresEnv += `<li class="list-group-item"><a href="${infoCorrespondenciaEnv.ruta_archivo_rec+archivo}" target="_blank">${archivo}</a></li>`;
                                                    
                                                }
                                        
                                                cardHTMLCorresEnv += `</ul>`;
                                        
                                                // $("#contenedorArchivosCorresRec").html(cadena);
                                        
                                            }

                                        cardHTMLCorresEnv += `</div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Usuario Respuesta</label>
                                            <div>${infoCorrespondenciaEnv.usuario_radicado}</div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                            <label for="" class="fw-bold">Fecha Respuesta</label>
                                            <div>${infoCorrespondenciaEnv.fecha_radicado}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

        $("#contenedorHasCorresEnv").html(cardHTMLCorresEnv);
        

    }else{

        $("#contenedorHasCorresEnv").html(``);

    }

    if(infoCorrespondencia.estado === 'GESTIONADA'){

        let cardHTMLGestion = `
            <div class="d-grid gap-2 mb-2">
                <a class="btn btn-phoenix-primary mt-2" data-bs-toggle="collapse" href="#collapseGestionCorresRec" role="button" aria-expanded="false" aria-controls="collapseGestionCorresRec">Gestion Correspondencia Recibida</a>
            </div>
            <div class="collapse" id="collapseGestionCorresRec">
                <div class="card shadow-sm mb-2">
                    <div class="card-header p-3 border-bottom border-300">
                        <div class="row g-1 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h5 class="text-primary mb-0">Gestion Correspondencia Recibida</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                <label for="" class="fw-bold">Observaciones Gestion</label>
                                <div>${infoCorrespondencia.observaciones_ges}</div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                <label for="" class="fw-bold">Documentos Gestion Correspondencia Recibida</label>`;

                                if(infoCorrespondencia.archivosCorresRecGes === 'SIN ARCHIVOS'){

                                    // $("#contenedorarchivosCorresRecGes").html(`<b>SIN ARCHIVOS</b>`);

                                    cardHTMLGestion += `<b>SIN ARCHIVOS</b>`;
                            
                                }else{
                            
                                    cardHTMLGestion += `<ul class="list-group">`;
                            
                                    for(const archivo of infoCorrespondencia.archivosCorresRecGes){
                            
                                        cardHTMLGestion += `<li class="list-group-item"><a href="${infoCorrespondencia.ruta_archivo_ges+archivo}" target="_blank">${archivo}</a></li>`;
                                        
                                    }
                            
                                    cardHTMLGestion += `</ul>`;
                            
                                    // $("#contenedorarchivosCorresRecGes").html(cadena);
                            
                                }

        cardHTMLGestion += `</div>
                            <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                <label for="" class="fw-bold">Usuario Gestion</label>
                                <div>${infoCorrespondencia.usuario_gestion}</div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                                <label for="" class="fw-bold">Fecha Gestion</label>
                                <div>${infoCorrespondencia.fecha_gestion}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

        $("#contenedorHasGestionCorresEnv").html(cardHTMLGestion); 
        
    }else{
        
        $("#contenedorHasGestionCorresEnv").html(``); 

    }

    if(infoCorrespondencia.aprobado_cartera !== 'SIN_REVISION'){

        let cardHTMLGestionCartera = `
        <div class="d-grid gap-2 mb-2">
            <a class="btn btn-phoenix-success mt-2" data-bs-toggle="collapse" href="#collapseGestionCorresRecCartera" role="button" aria-expanded="false" aria-controls="collapseGestionCorresRec">Gestion Correspondencia Recibida Cartera</a>
        </div>
        <div class="collapse" id="collapseGestionCorresRecCartera">
            <div class="card shadow-sm mb-2">
                <div class="card-header p-3 border-bottom border-300">
                    <div class="row g-1 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h5 class="text-success mb-0">Gestion Cartera</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                            <label for="" class="fw-bold">Estado Aprobacion Cartera</label>
                            <div>${infoCorrespondencia.aprobado_cartera}</div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                            <label for="" class="fw-bold">Observaciones Cartera</label>
                            <div>${infoCorrespondencia.observaciones_cartera}</div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                            <label for="" class="fw-bold">Usuario Cartera</label>
                            <div>${infoCorrespondencia.usuario_cartera}</div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                            <label for="" class="fw-bold">Fecha Cartera</label>
                            <div>${infoCorrespondencia.fecha_cartera}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        $("#contenedorHasGestionCorresRecCartera").html(cardHTMLGestionCartera);
        
    }else{
        
        $("#contenedorHasGestionCorresRecCartera").html(``);

    }




}

const verInfoCorrespondiaRecibidaReAsignar = async (idCorrRec) => {

    let datos = new FormData();
    datos.append('proceso','infoCorrespondenciaRec');
    datos.append('idCorresponRec', idCorrRec);

    const infoCorrespondencia = await $.ajax({
        url: 'ajax/correspon/correspondencia-recibida.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!infoCorrespondencia){
        console.error("No existe Correspondencia Recibida"); 
        return;
    }

    // console.log(infoCorrespondencia);

    $("#idCorresRecReAsignar").val(infoCorrespondencia.id_corr_rec);
    $("#asuntoCorresRecReAsignar").val(infoCorrespondencia.asunto);
    $("#observacionesCorresRecReAsignar").val(infoCorrespondencia.observaciones);
    $("#proyectoCorresRecReAsignar").val(infoCorrespondencia.id_proyecto);
    $("#responProyectoCorresRecReAsignar").val(infoCorrespondencia.nombre);
    $("#idResponProyectoCorresRecReAsignar").val(infoCorrespondencia.id_responsable_proyecto);
    $("#idResponProyectoCorresRecOld").val(infoCorrespondencia.id_responsable_proyecto);

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


const crearCorresponRec = async () => {

    let formulario = document.getElementById("formCrearCorresponRec");
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

            let form = document.querySelector('#formCrearCorresponRec');

            const formData = new FormData(form);

            let archivosCorresRec = document.getElementById("nuevoArchivosCorresponRec");

            formData.append('proceso', 'cargarCorresponRec');
            formData.append('user', userSession);
            for(let file of archivosCorresRec.files){
                formData.append('archivosCorresRec[]', file);
            }

            //VALIDACION ARCHIVOS
            let validFiles = await validarArchivoPDF(archivosCorresRec);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            if(!validFiles){

                loadingFnc();
    
                $.ajax({
    
                    url: 'ajax/correspon/correspondencia-recibida.ajax.php',
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){
    
                        Swal.close();
    
                        if(respuesta == 'ok'){
    
                            Swal.fire({
                                text: '¡Se Cargo la Correspondencia Recibida!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{
    
                                if(result.isConfirmed){
    
                                    window.location = 'index.php?ruta=correspon/cargarcorresponrec';
    
                                }
    
                            })
    
                        }else{
    
                            Swal.fire({
                                text: '¡No se Cargo la Correspondencia Recibida!',
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

const eliminarCorresponRec = (idCorresRec, asunto) => {

    Swal.fire({
        title: `¿Desea eliminar la Correspondencia Recibida: ${asunto}?`,
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if(result.isConfirmed){

            let formData = new FormData();
            formData.append('proceso', 'eliminarCorresponRec');
            formData.append('idCorresRec', idCorresRec);
            formData.append('userSession', userSession);

            $.ajax({

                url: 'ajax/correspon/correspondencia-recibida.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({

                            text: '¡La Correspondencia Recibida se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){
                                
                                tablaCorresponRecCargada.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'La Correspondencia Recibida no se elimino correctamente',
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


const reAsignarCorrespondenciaRec = () => {

    let formulario = document.getElementById("formReAsignarCorresRec");
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

            let form = document.querySelector('#formReAsignarCorresRec');

            const formData = new FormData(form);


            formData.append('proceso', 'reAsignarCorresRec');
            formData.append('user', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }


            loadingFnc();

            $.ajax({

                url: 'ajax/correspon/correspondencia-recibida.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    Swal.close();

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Correspondencia Recibida se re-asigno correctamento!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=correspon/cargarcorresponrec';

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡La Correspondencia Recibida no se re-asigno!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const aceptarCorresponRec = (idCorresRec, asunto) => {

    Swal.fire({
        html: `¿Desea aceptar la Correspondencia Recibida: <b>${asunto}?</b>`,
        icon: 'question',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Aceptar!"
    }).then((result) => {

        if(result.isConfirmed){

            let formData = new FormData();
            formData.append('proceso', 'aceptarCorresponRec');
            formData.append('idCorresRec', idCorresRec);
            formData.append('userSession', userSession);
            formData.append('idUserSession', idUserSession);

            $.ajax({

                url: 'ajax/correspon/correspondencia-recibida.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({

                            text: '¡La Correspondencia Recibida se acepto correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){
                                
                                tablaBandejaCorresRec.ajax.reload();
                                tablaMiCorresponRec.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'La Correspondencia Recibida no se acepto correctamente',
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


const rechazarCorresponRec = (idCorresRec, asunto) => {

    Swal.fire({
        html: `¿Desea rechazar la Correspondencia Recibida: <b>${asunto}?</b>`,
        icon: 'question',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Rechazar!"
    }).then((result) => {

        if(result.isConfirmed){

            let formData = new FormData();
            formData.append('proceso', 'rechazarCorresponRec');
            formData.append('idCorresRec', idCorresRec);
            formData.append('userSession', userSession);
            formData.append('idUserSession', idUserSession);

            $.ajax({

                url: 'ajax/correspon/correspondencia-recibida.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({

                            text: '¡La Correspondencia Recibida se rechazo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){
                                
                                tablaBandejaCorresRec.ajax.reload();
                                tablaMiCorresponRec.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'La Correspondencia Recibida no se rechazo correctamente',
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

const mostrarInfoReAsignarUsuarioCorresponRec = (idCorresRec, asunto) => {

    $("#textIdCorresReAsignar").html(idCorresRec);
    $("#idCorresRecReAsignar").val(idCorresRec);
    $("#textAsuntoCorresReAsignar").html(asunto);


}


const asignarUsuarioCorresponRec = () => {

    let formulario = document.getElementById("formReAsignarUsuarioCorresRec");
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

            let form = document.querySelector('#formReAsignarUsuarioCorresRec');

            const formData = new FormData(form);

            formData.append('proceso', 'asignarUsuarioCorresponRec');
            formData.append('user', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }


            loadingFnc();

            $.ajax({

                url: 'ajax/correspon/correspondencia-recibida.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    Swal.close();

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡Se Re-Asigno la Correspondencia Recibida!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){
    
                                window.location = 'index.php?ruta=correspon/micorresponrec';

                            }                        

                        })

                    }else{

                        Swal.fire({
                            text: '¡No se Re-Asigno la Correspondencia Recibida!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}


const iniciarGestionarCorresponRec = (idCorresponRec) => {

    window.location = 'index.php?ruta=correspon/gestionarcorresponrec&idCorresRec='+btoa(idCorresponRec);

}


const gestionCorrespondenciaRecibida = async () => {

    let formulario = document.getElementById("formGestionarCorresponRec");
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

            let form = document.querySelector('#formGestionarCorresponRec');

            const formData = new FormData(form);

            let archivosGestionCorresponRec = document.getElementById("archivosGestionCorresponRec");

            formData.append('proceso', 'gestionarCorresponRecibida');
            formData.append('idCorresponRec', idCorrespondenciaRec);
            formData.append('user', userSession);
            formData.append('idUser', idUserSession);
            for(let file of archivosGestionCorresponRec.files){
                formData.append('archivosGestionCorresponRec[]', file);
            }

            //VALIDACION ARCHIVOS
            let validFiles = await validarArchivoPDF(archivosGestionCorresponRec);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            if(!validFiles){

                loadingFnc();
    
                $.ajax({
    
                    url: 'ajax/correspon/correspondencia-recibida.ajax.php',
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){
    
                        Swal.close();
    
                        if(respuesta == 'ok'){
    
                            Swal.fire({
                                text: '¡Se guardo la Gestion de la Correspondencia Recibida correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{
    
                                if(result.isConfirmed){
    
                                    window.location = 'index.php?ruta=correspon/micorresponrec';
    
                                }
    
                            })
    
                        }else{
    
                            Swal.fire({
                                text: '¡No guardo la Gestion de la Correspondencia Recibida correctamente!',
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

const infoAprobadoCorresFacRec = (idCorresponRec) => {

    $("#idCorresRecApro").val(idCorresponRec);

}


const guardarAprobacionFacRec = () => {

    let formulario = document.getElementById("formAprobarCorrFacRec");
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

            let form = document.querySelector('#formAprobarCorrFacRec');

            const formData = new FormData(form);

            formData.append('proceso', 'aprobarCorresponFacRec');
            formData.append('user', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            loadingFnc();

            $.ajax({

                url: 'ajax/correspon/correspondencia-recibida.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    Swal.close();

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡Se guardo la Gestion correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=correspon/bolsafacrec';

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡No guardo la Gestion correctamente!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

tablaCorresponRecCargada = $('#tablaCorresponRecCargada').DataTable({

    columns: [
        { name: '#', data: 'id_corr_rec' },
        { name: 'ASUNTO', data: 'asunto' },
        { name: 'TIPO CORRESPONDENCIA', data: 'tipo_correspondencia' },
        { name: 'PROYECTO', data: 'nombre_proyecto' },
        { name: 'RESPONSABLE', data: 'nombre' },
        { name: 'ESTADO ASIGNACION', render: function(data, type, row){

            if(row.estado_asignacion === 'RECHAZADA'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-danger"><span class="badge-label">${row.estado_asignacion}</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span>`;

            }else if(row.estado_asignacion === 'ASIGNADA'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-info"><span class="badge-label">${row.estado_asignacion}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;
                
            }

        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                if(row.estado_asignacion === 'RECHAZADA'){

                    return `
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
    
                            <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorresRec" onclick="verInfoCorrespondiaRecibida(${row.id_corr_rec})" title="Ver Correspondencia Recibida"><i class="far fa-eye"></i></button>
                            <button class="btn btn-phoenix-primary" data-bs-toggle="modal" data-bs-target="#modalReAsignarCorresRec" onclick="verInfoCorrespondiaRecibidaReAsignar(${row.id_corr_rec})" title="Re-Asignar Correspondencia Recibida"><i class="fas fa-user-plus"></i></button>
                            <button class="btn btn-phoenix-danger" onclick="eliminarCorresponRec(${row.id_corr_rec}, '${row.asunto}')" title="Eliminar Correspondencia Recibida"><i class="fas fa-trash-alt"></i></button>
    
                        </div>
                    `;
                    
                }else{
                    
                    return `
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
    
                            <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorresRec" onclick="verInfoCorrespondiaRecibida(${row.id_corr_rec})" title="Ver Correspondencia Recibida"><i class="far fa-eye"></i></button>
                            <button class="btn btn-phoenix-danger" onclick="eliminarCorresponRec(${row.id_corr_rec}, '${row.asunto}')" title="Eliminar Correspondencia Recibida"><i class="fas fa-trash-alt"></i></button>
    
                        </div>
                    `;

                }



            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/correspon/correspondencia-recibida.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaCorrespondenciaRecibida',
            'userSesion': userSession,
        }
    }

})

tablaBandejaCorresRec = $('#tablaBandejaCorresRec').DataTable({

    columns: [
        { name: '#', data: 'id_corr_rec' },
        { name: 'ASUNTO', data: 'asunto' },
        { name: 'TIPO CORRESPONDENCIA', data: 'tipo_correspondencia' },
        { name: 'PROYECTO', data: 'nombre_proyecto' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <div class="btn-group btn-group-sm" role="group" aria-label="...">

                        <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorresRec" onclick="verInfoCorrespondiaRecibida(${row.id_corr_rec})" title="Ver Correspondencia Recibida"><i class="far fa-eye"></i></button>
                        <button class="btn btn-phoenix-success" onclick="aceptarCorresponRec(${row.id_corr_rec}, '${row.asunto}')" title="Aceptar Correspondencia Recibida"><i class="fas fa-check"></i></button>
                        <button class="btn btn-phoenix-danger" onclick="rechazarCorresponRec(${row.id_corr_rec}, '${row.asunto}')" title="Rechazar Correspondencia Recibida"><i class="fas fa-times"></i></button>

                    </div>
                `;


            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/correspon/correspondencia-recibida.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaMiBandejaCorresponRec',
            'idUserSesion': idUserSession,
        }
    }

})

tablaMiCorresponRec = $('#tablaMiCorresponRec').DataTable({

    columns: [
        { name: '#', data: 'id_corr_rec' },
        { name: 'ASUNTO', data: 'asunto' },
        { name: 'TIPO CORRESPONDENCIA', data: 'tipo_correspondencia' },
        { name: 'PROYECTO', data: 'nombre_proyecto' },
        { name: 'ESTADO ASIGNACION', render: function(data, type, row){

            if(row.estado_asignacion === 'RECHAZADA' || row.estado_asignacion === 'RE-ASIGNADA-RECHAZADA'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-danger"><span class="badge-label">${row.estado_asignacion}</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span>`;

            }else if(row.estado_asignacion === 'ASIGNADA'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-info"><span class="badge-label">${row.estado_asignacion}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;
                
            }else if(row.estado_asignacion === 'RE-ASIGNADA'){
                
                return `<span class="badge badge-phoenix fs--2 badge-phoenix-warning"><span class="badge-label">${row.estado_asignacion}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;
                
            }else if(row.estado_asignacion === 'ACEPTADA'){
                
                return `<span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label">${row.estado_asignacion}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;

            }

        }},
        { name: 'ESTADO', render: function(data, type, row){

            if(row.estado === 'CREADA'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-warning"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span>`;
                
            }else if(row.estado === 'GESTIONADA'){
                
                return `<span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;

            }

        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                if(row.estado === 'GESTIONADA'){

                    return `
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
    
                            <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorresRec" onclick="verInfoCorrespondiaRecibida(${row.id_corr_rec})" title="Ver Correspondencia Recibida"><i class="far fa-eye"></i></button>
    
                        </div>
                    `;

                }else if(row.estado === 'CREADA' && row.estado_asignacion === 'RE-ASIGNADA-RECHAZADA'){

                    return `
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
    
                            <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorresRec" onclick="verInfoCorrespondiaRecibida(${row.id_corr_rec})" title="Ver Correspondencia Recibida"><i class="far fa-eye"></i></button>
                            <button class="btn btn-phoenix-primary" data-bs-toggle="modal" data-bs-target="#modalAsignarUsuarioCorresponRec" onclick="mostrarInfoReAsignarUsuarioCorresponRec(${row.id_corr_rec}, '${row.asunto}')" title="Asignar Usuario Correspondencia Recibida"><i class="fas fa-user-plus"></i></button>
                            <button class="btn btn-phoenix-success" onclick="iniciarGestionarCorresponRec(${row.id_corr_rec})" title="Gestionar Correspondencia Recibida"><i class="fas fa-file-signature"></i></button>
    
                        </div>
                    `;

                }else if(row.estado === 'CREADA' && row.estado_asignacion === 'RE-ASIGNADA'){

                    return `
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
    
                            <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorresRec" onclick="verInfoCorrespondiaRecibida(${row.id_corr_rec})" title="Ver Correspondencia Recibida"><i class="far fa-eye"></i></button>
    
                        </div>
                    `;

                }else if(row.estado === 'CREADA' && row.estado_asignacion === 'ACEPTADA'){

                    return `
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
    
                            <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorresRec" onclick="verInfoCorrespondiaRecibida(${row.id_corr_rec})" title="Ver Correspondencia Recibida"><i class="far fa-eye"></i></button>
                            <button class="btn btn-phoenix-primary" data-bs-toggle="modal" data-bs-target="#modalAsignarUsuarioCorresponRec" onclick="mostrarInfoReAsignarUsuarioCorresponRec(${row.id_corr_rec}, '${row.asunto}')" title="Asignar Usuario Correspondencia Recibida"><i class="fas fa-user-plus"></i></button>
                            <button class="btn btn-phoenix-success" onclick="iniciarGestionarCorresponRec(${row.id_corr_rec})" title="Gestionar Correspondencia Recibida"><i class="fas fa-file-signature"></i></button>
    
                        </div>
                    `;

                }
                
                // else if(row.estado === 'CREADA' && row.estado_asignacion === 'RE-ASIGNADA-RECHAZADA' || row.estado_asignacion === 'ACEPTADA'){

                //     return `
                //         <div class="btn-group btn-group-sm" role="group" aria-label="...">
    
                //             <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorresRec" onclick="verInfoCorrespondiaRecibida(${row.id_corr_rec})" title="Ver Correspondencia Recibida"><i class="far fa-eye"></i></button>
                //             <button class="btn btn-phoenix-primary" data-bs-toggle="modal" data-bs-target="#modalAsignarUsuarioCorresponRec" onclick="mostrarInfoReAsignarUsuarioCorresponRec(${row.id_corr_rec}, '${row.asunto}')" title="Asignar Usuario Correspondencia Recibida"><i class="fas fa-user-plus"></i></button>
                //             <button class="btn btn-phoenix-success" onclick="iniciarGestionarCorresponRec(${row.id_corr_rec})" title="Gestionar Correspondencia Recibida"><i class="fas fa-file-signature"></i></button>
    
                //         </div>
                //     `;

                // }


            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/correspon/correspondencia-recibida.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaMiCorresponRec',
            'userSesion': userSession,
            'idUserSesion': idUserSession
        }
    }

})


tablaBolsaCorrespondenciaFactuReci = $('#tablaBolsaCorrespondenciaFactuReci').DataTable({

    columns: [
        { name: '#', data: 'id_corr_rec' },
        { name: 'ASUNTO', data: 'asunto' },
        { name: 'PROYECTO', data: 'nombre_proyecto' },
        { name: 'TIPO CORRESPONDENCIA', data: 'tipo_correspondencia' },
        { name: 'ESTADO', render: function(data, type, row){

            if(row.estado === 'CREADA'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-warning"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span>`;
                
            }else if(row.estado === 'GESTIONADA'){
                
                return `<span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;

            }

        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <div class="btn-group btn-group-sm" role="group" aria-label="...">

                        <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorresRec" onclick="verInfoCorrespondiaRecibida(${row.id_corr_rec})" title="Ver Correspondencia Recibida"><i class="far fa-eye"></i></button>
                        <button class="btn btn-phoenix-success" data-bs-toggle="modal" data-bs-target="#modalAprobarFacRec" onclick="infoAprobadoCorresFacRec(${row.id_corr_rec})" title="Gestionar"><i class="far fa-check-square"></i></button>

                    </div>
                `;


            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/correspon/correspondencia-recibida.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaBolsaCorresponFactuRec'
        }
    }

})


tablaListCorrespondenciaFactuReci = $('#tablaListCorrespondenciaFactuReci').DataTable({

    columns: [
        { name: '#', data: 'id_corr_rec' },
        { name: 'ASUNTO', data: 'asunto' },
        { name: 'PROYECTO', data: 'nombre_proyecto' },
        { name: 'TIPO CORRESPONDENCIA', data: 'tipo_correspondencia' },
        { name: 'ESTADO', render: function(data, type, row){

            if(row.estado === 'CREADA'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-warning"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span>`;
                
            }else if(row.estado === 'GESTIONADA'){
                
                return `<span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;

            }

        }},
        { name: 'APROBADO CARTERA', render: function(data, type, row){

            if(row.aprobado_cartera === 'NO_APROBADO'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-danger"><span class="badge-label">${row.aprobado_cartera}</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span>`;
                
            }else if(row.aprobado_cartera === 'APROBADO'){
                
                return `<span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label">${row.aprobado_cartera}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;

            }

        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <div class="btn-group btn-group-sm" role="group" aria-label="...">

                        <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorresRec" onclick="verInfoCorrespondiaRecibida(${row.id_corr_rec})" title="Ver Correspondencia Recibida"><i class="far fa-eye"></i></button>

                    </div>
                `;


            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/correspon/correspondencia-recibida.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaCorresponFactuRec'
        }
    }

})


tablaListaCorrespondenciaRecibida = $('#tablaListaCorrespondenciaRecibida').DataTable({

    columns: [
        { name: '#', data: 'id_corr_rec' },
        { name: 'ASUNTO', data: 'asunto' },
        { name: 'TIPO CORRESPONDENCIA', data: 'tipo_correspondencia' },
        { name: 'PROYECTO', data: 'nombre_proyecto' },
        { name: 'ESTADO', render: function(data, type, row){

            if(row.estado === 'CREADA'){

                return `<span class="badge badge-phoenix fs--2 badge-phoenix-warning"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span>`;
                
            }else if(row.estado === 'GESTIONADA'){
                
                return `<span class="badge badge-phoenix fs--2 badge-phoenix-success"><span class="badge-label">${row.estado}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>`;

            }

        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <div class="btn-group btn-group-sm" role="group" aria-label="...">

                        <button class="btn btn-phoenix-warning" data-bs-toggle="modal" data-bs-target="#modalVerCorresRec" onclick="verInfoCorrespondiaRecibida(${row.id_corr_rec})" title="Ver Correspondencia Recibida"><i class="far fa-eye"></i></button>

                    </div>
                `;

            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/correspon/correspondencia-recibida.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaCorrespondenciaRecibidaAll',
        }
    }

})

$('#tablaListaCorrespondenciaRecibida thead tr').clone(true).appendTo('#tablaListaCorrespondenciaRecibida thead');

$('#tablaListaCorrespondenciaRecibida thead tr:eq(1) th').each( function (i) {

    var title = $(this).text();
    $(this).html( '<input type="text" class="form-control" placeholder="Buscar..." />' );

    $( 'input', this ).on( 'keyup change', function () {

        if(tablaListaCorrespondenciaRecibida.column(i).search() !== this.value){

            tablaListaCorrespondenciaRecibida
                .column(i)
                .search( this.value )
                .draw();

        }

    })

})



if(rutaValor == 'correspon/gestionarcorresponrec'){

    // console.log(idCorrespondenciaRec);

    verInfoCorrespondiaRecibida(idCorrespondenciaRec);
    

}
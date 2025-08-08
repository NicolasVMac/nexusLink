/*==============================
VARIABLES DE RUTA
==============================*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let idPQRS = atob(getParameterByName('idPQRS'));
let ckEditorInstance = null;
let url = new URL(window.location.href);
let rutaValor = url.searchParams.get("ruta");


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

const validarBuzonSugerencias = () => {

    let medioRecepcion = document.getElementById('medioRecepcionPqr').value;
    let fechaAperturaBuzon = document.querySelector('#fechaAperturaBuzonSugerencias');

    if(medioRecepcion !== 'BUZON DE SUGERENCIAS'){

        fechaAperturaBuzon.setAttribute('readonly', true);
        fechaAperturaBuzon.setAttribute('type', 'text');
        fechaAperturaBuzon.classList.add('readonly');
        fechaAperturaBuzon.value = 'NO APLICA';
        
    }else{
        
        fechaAperturaBuzon.setAttribute('type', 'date');
        fechaAperturaBuzon.removeAttribute('readonly');
        fechaAperturaBuzon.classList.remove('readonly');

    }

}

const validarNegacionPqr = () => {

    let negacionPQR = document.getElementById('planAccionNegacion').value;
    let motivoResponsableNegacion = document.querySelector('#planAccionMotivoResponsableNega');

    if(negacionPQR === 'NO'){

        motivoResponsableNegacion.setAttribute('readonly', true);
        motivoResponsableNegacion.classList.add('readonly');
        motivoResponsableNegacion.value = 'NO APLICA';

    }else{

        motivoResponsableNegacion.removeAttribute('readonly');
        motivoResponsableNegacion.classList.remove('readonly');
        motivoResponsableNegacion.value = '';

    }

}

const convertDiasHoras = (horas) => {

    const dias = Math.floor(horas / 24);
    const horasRestantes = horas % 24;
    return `${dias} D ${Math.floor(horasRestantes)} H`;

}


const crearPQRS = () => {

    let formulario = document.getElementById("formCrearPqr");
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

            let descripcionPqr = document.querySelector('textarea[name="descripcionPqr"]');
            descripcionPqr = descripcionPqr.value;

            if(descripcionPqr){

                let archivosPqr = document.getElementById("archivosPqr");

                const formData = new FormData(form);

                formData.append('proceso', 'crearPQRS');
                formData.append('descripcionPqr', descripcionPqr);

                for(let file of archivosPqr.files){

                    formData.append('archivosPqr[]', file);

                }

                formData.append('userCreate', userSession);

                for(const [key, value] of formData){
                    // console.log(key, value);
                }

                loadingFnc();

                $.ajax({

                    url: 'ajax/pqr/pqr.ajax.php',
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        Swal.close();

                        if(respuesta == 'ok'){

                            Swal.fire({
                                text: '¡La PQRSF se creo correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{

                                if(result.isConfirmed){

                                    window.location = 'index.php?ruta=pqr/registrarpqr';

                                }

                            })

                        }else{

                            Swal.fire({
                                text: '¡La PQRSF no se creo correctamente!',
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

                toastr.warning("Recuerde diligenciar el campo Descripcion PQRSF.", "¡Atencion!");

            }

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const actualizarPQRSF = (rol) => {

    let formulario = document.getElementById("formActualizarPQRSF");
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

            let form = document.querySelector('#formActualizarPQRSF');

            let descripcionPqr = document.querySelector('textarea[name="descripcionPqr"]');
            descripcionPqr = descripcionPqr.value;

            if(descripcionPqr){

                const formData = new FormData(form);

                formData.append('proceso', 'actualizarPQRS');
                formData.append('idPQRS', idPQRS);
                formData.append('descripcionPqr', descripcionPqr);
                formData.append('userModifica', userSession);

                // for(const [key, value] of formData){
                //     // console.log(key, value);
                // }

                Swal.fire({
                    text: "¿Seguro que desea Modificar la Informacion del PQRSF, se afectara la Calidad del Digitador?",
                    icon: 'info',
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    showCancelButton: true,
                    confirmButtonText: "¡Si, Actualizar PQRSF!"
                }).then((result) => {
            
                    if (result.isConfirmed) {

                        loadingFnc();
            
                        $.ajax({

                            url: 'ajax/pqr/pqr.ajax.php',
                            type: 'POST',
                            data: formData,
                            cache:false,
                            contentType: false,
                            processData: false,
                            success:function(respuesta){

                                Swal.close();
            
                                if(respuesta == 'ok'){
            
                                    Swal.fire({
                                        text: '¡La PQRSF se actualizo correctamente!',
                                        icon: 'success',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33"
                                    }).then((result) =>{
            
                                        if(result.isConfirmed){

                                            if(rol === 'SUPERVISOR'){

                                                window.location = 'index.php?ruta=pqr/revisionpqr&idPQRS='+btoa(idPQRS);

                                            }else{

                                                window.location = 'index.php?ruta=pqr/gestionarpqrs&idPQRS='+btoa(idPQRS);

                                            }
            
            
                                        }
            
                                    })
            
                                }else{
            
                                    Swal.fire({
                                        text: '¡La PQRSF no se actualizo correctamente!',
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

                toastr.warning("Recuerde diligenciar el campo Descripcion PQRSF.", "¡Atencion!");

            }

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const crearBuzonPQRS = () => {

    let formulario = document.getElementById("formCrearBuzonPqr");
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

            let descripcionPqr = document.querySelector('textarea[name="descripcionPqr"]');
            descripcionPqr = descripcionPqr.value;

            if(descripcionPqr){

                let archivosPqr = document.getElementById("archivosPqr");

                const formData = new FormData(form);

                formData.append('proceso', 'crearBuzonPQRS');

                for(let file of archivosPqr.files){

                    formData.append('archivosPqr[]', file);

                }

                formData.append('idPQRSF', idPQRS);
                formData.append('userCreate', userSession);

                for(const [key, value] of formData){
                    // console.log(key, value);
                }

                loadingFnc();

                $.ajax({

                    url: 'ajax/pqr/pqr.ajax.php',
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        Swal.close();

                        if(respuesta == 'ok'){

                            Swal.fire({
                                text: '¡La PQRSF se guardo correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{

                                if(result.isConfirmed){

                                    window.location = 'index.php?ruta=pqr/pendientesbuzonpqr';

                                }

                            })

                        }else{

                            Swal.fire({
                                text: '¡La PQRSF no se guardo correctamente!',
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

                toastr.warning("Recuerde diligenciar el campo Descripcion PQRSF.", "¡Atencion!");

            }

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}


const verPQRS = (idPQR) => {

    $.ajax({
        
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'infoPQR',
            'idPQR': idPQR,
        },
        cache: false,
        dataType: "json",
        success:function(pqr){

            // console.log('Ver PQRSF:', pqr);
            
            $("#txtIdPQRS").text(pqr.id_pqr);
            $("#txtNombrePac").text(pqr.nombre_pac);
            $("#txtTipoDocPac").text(pqr.tipo_identificacion_pac);
            $("#txtNumDocPac").text(pqr.numero_identificacion_pac);
            $("#txtFechaNacPac").text(pqr.fecha_nacimiento_pac);
            $("#txtEps").text(pqr.eps);
            $("#txtRegimenEps").text(pqr.regimen);
            $("#txtPrograma").text(pqr.programa);
            $("#txtSede").text(pqr.sede);
            $("#txtNombrePet").text(pqr.nombre_pet);
            $("#txtTipoDocPet").text(pqr.tipo_identificacion_pet);
            $("#txtNumDocPet").text(pqr.numero_identificacion_pet);
            $("#txtContactoPet").text(pqr.contacto_pet);
            $("#txtCorreoPet").text(pqr.correo_pet);
            $("#txtDepPet").text(pqr.departamento);
            $("#txtMunPet").text(pqr.municipio);
            $("#txtDescripcionPqr").html(pqr.descripcion_pqr);
            $("#txtMedRecepPqr").text(pqr.medio_recep_pqr);
            $("#txtFechaAperBuzonSug").text(pqr.fecha_apertura_buzon_suge);
            $("#txtFechaHoraRadPqr").text(pqr.fecha_radicacion_pqr);
            $("#txtTipoPqr").text(pqr.tipo_pqr);
            $("#txtEnteRepPqr").text(pqr.ente_reporta_pqr);
            $("#txtMotivoPqr").text(pqr.motivo_pqr);
            $("#txtTrabajadorRelaPqr").text(pqr.trabajador_relacionado_pqr);
            $("#txtGestorPqr").text(`${pqr.nombre} - ${pqr.gestor}`);
            $("#txtServAreaPqr").text(pqr.servicio_area);
            $("#txtCaliAtribuPqr").text(pqr.clasificacion_atributo);
            $("#txtTiempoResNormaPqr").text(pqr.tiempo_res_normativo);
            $("#txtHorasDiasOportPqr").text(pqr.horas_dias_oportunidad);
            $("#planAccionPqrRecurrente").val(pqr.pla_ac_pqr_recurrente);
            $("#txtFechaPQRSF").text(pqr.fecha_pqr);

            if(pqr.archivosPQRSF === 'SIN ARCHIVOS'){

                $("#containerArchivosPQRSF").html(`<b>SIN ARCHIVOS</b>`);

            }else{

                let cadena = `<ul class="list-group">`;

                for(const archivo of pqr.archivosPQRSF){

                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivos+archivo}" target="_blank">${archivo}</a></li>`;
                    
                }

                cadena += `</ul>`;

                $("#containerArchivosPQRSF").html(cadena);

            }

            //INFORMACION SI TIENE ACTA
            if(pqr.id_acta){

                let btnVerActas = document.querySelector('.btnVerActas');

                if(btnVerActas){

                    btnVerActas.style.display = 'block';

                    $.ajax({
            
                        url: 'ajax/pqr/pqr.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'infoBuzonPQR',
                            'idPQR': pqr.id_pqr,
                        },
                        cache: false,
                        dataType: "json",
                        success:function(pqr){
                
                            console.log(pqr);
                            $("#txtIdPQRSF").text(pqr.id_pqr);
                            $("#txtRadActa").text(pqr.radicado_acta);
                            $("#txtFechaActa").text(pqr.fecha_acta);
                            $("#txtFechaAperturaActa").text(pqr.fecha_apertura_buzon);
                
                            if(pqr.archivosActaPQRSF === 'SIN ARCHIVOS'){
                
                                $("#containerArchivosActasPQRSF").html(`<b>SIN ARCHIVOS</b>`);
                
                            }else{
                
                                let cadena = `<ul class="list-group">`;
                
                                for(const archivo of pqr.archivosActaPQRSF){
                
                                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivos_actas+archivo}" target="_blank">${archivo}</a></li>`;
                                    
                                }
                
                                cadena += `</ul>`;
                
                                $("#containerArchivosActasPQRSF").html(cadena);
                
                            }
                
                        }
                
                    })

                }

            }

        }

    })
}

const infoPQRS = (idPQR) => {

    $.ajax({
        
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'infoPQR',
            'idPQR': idPQR,
        },
        cache: false,
        dataType: "json",
        success:function(pqr){
            
            // console.log('Info PQRSF:', pqr);

            $("#txtIdPQRS").text(pqr.id_pqr);
            $("#txtNombrePac").text(pqr.nombre_pac);
            $("#txtTipoDocPac").text(pqr.tipo_identificacion_pac);
            $("#txtNumDocPac").text(pqr.numero_identificacion_pac);
            $("#txtFechaNacPac").text(pqr.fecha_nacimiento_pac);
            $("#txtEps").text(pqr.eps);
            $("#txtRegimenEps").text(pqr.regimen);
            $("#txtPrograma").text(pqr.programa);
            $("#txtSede").text(pqr.sede);
            $("#txtNombrePet").text(pqr.nombre_pet);
            $("#txtTipoDocPet").text(pqr.tipo_identificacion_pet);
            $("#txtNumDocPet").text(pqr.numero_identificacion_pet);
            $("#txtContactoPet").text(pqr.contacto_pet);
            $("#txtCorreoPet").text(pqr.correo_pet);
            $("#txtDepPet").text(pqr.departamento);
            $("#txtMunPet").text(pqr.municipio);
            $("#txtDescripcionPqr").html(pqr.descripcion_pqr);
            $("#txtMedRecepPqr").text(pqr.medio_recep_pqr);
            $("#txtFechaAperBuzonSug").text(pqr.fecha_apertura_buzon_suge);
            $("#txtFechaHoraRadPqr").text(pqr.fecha_radicacion_pqr);
            $("#txtTipoPqr").text(pqr.tipo_pqr);
            $("#txtEnteRepPqr").text(pqr.ente_reporta_pqr);
            $("#txtMotivoPqr").text(pqr.motivo_pqr);
            $("#txtTrabajadorRelaPqr").text(pqr.trabajador_relacionado_pqr);
            $("#txtGestorPqr").text(`${pqr.nombre} - ${pqr.gestor}`);
            $("#txtServAreaPqr").text(pqr.servicio_area);
            $("#txtCaliAtribuPqr").text(pqr.clasificacion_atributo);
            $("#txtTiempoResNormaPqr").text(pqr.tiempo_res_normativo);
            $("#txtHorasDiasOportPqr").text(pqr.horas_dias_oportunidad);
            $("#txtFechaPQRSF").text(pqr.fecha_pqr);
            $("#txtHorasHabilesResp").text(Math.round(pqr.horas_habiles) + ' HORAS');
            $("#txtDiasHabilesResp").text(convertDiasHoras(pqr.horas_habiles));

            if(pqr.tiempo == 'DIAS'){
                $("#txtTiempoNormativo").text(pqr.cantidad + ' DIAS HABILES - ' + pqr.cantidad * 24 + ' HORAS HABILES');
            }else{
                $("#txtTiempoNormativo").text(pqr.cantidad / 24 + ' DIAS HABILES - ' + pqr.cantidad + ' HORAS HABILES');
            }


            if(pqr.archivosPQRSF === 'SIN ARCHIVOS'){

                $("#containerArchivosPQRSF").html(`<b>SIN ARCHIVOS</b>`);

            }else{

                let cadena = `<ul class="list-group">`;

                for(const archivo of pqr.archivosPQRSF){

                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivos+archivo}" target="_blank">${archivo}</a></li>`;
                    
                }

                cadena += `</ul>`;

                $("#containerArchivosPQRSF").html(cadena);

            }

            //INFORMACION GESTOR Y SUPERVISOR

            if(pqr.estado_pqr === 'CREADA'){
                $("#contenedorEstadoPQR").html(`<div class="alert alert-soft-danger text-center" style="font-size: 25px;" role="alert">SIN TRAMITE</div>`);
            }else if(pqr.estado_pqr === 'GESTION' || pqr.estado_pqr === 'REVISION' || pqr.estado_pqr === 'REVISANDO'){
                $("#contenedorEstadoPQR").html(`<div class="alert alert-soft-warning text-center" style="font-size: 25px;" role="alert">EN PROCESO DE TRAMITE</div>`);
            }else if(pqr.estado_pqr === 'COMPLETADO'){
                $("#contenedorEstadoPQR").html(`<div class="alert alert-soft-info text-center" style="font-size: 25px;" role="alert">RESPUESTA POR LA ENTIDAD</div>`);
            }else{
                $("#contenedorEstadoPQR").html(`<div class="alert alert-soft-success text-center" style="font-size: 25px;" role="alert">CERRADO TOTAL</div>`);
            }


            $("#txtQue").text(pqr.pla_ac_que);
            $("#txtPorQue").text(pqr.pla_ac_por_que);
            $("#txtCuando").text(pqr.pla_ac_cuando);
            $("#txtDonde").text(pqr.pla_ac_donde);
            $("#txtComo").text(pqr.pla_ac_como);

            if(pqr.pla_ac_quien){

                let cadenaQuien = '';

                for (const element of pqr.pla_ac_quien.split('-')) {
                    cadenaQuien += `<li>${element}</li>`;
                }
                $("#txtQuien").html(cadenaQuien);
                
            }else{
                
                $("#txtQuien").html('');

            }


            if(pqr.pla_ac_recurso){

                let cadenaRecursos = '';
                
                for (const element of pqr.pla_ac_recurso.split('-')) {
                    cadenaRecursos += `<li>${element}</li>`;
                }
                $("#txtRecursos").html(cadenaRecursos);
                
            }else{
                $("#txtRecursos").html('');
            }
                
            $("#txtNegacionPQR").text(pqr.pla_ac_negacion_pqr);
            $("#txtMotivoResponsableNegacion").text(pqr.pla_ac_motivo_negacion);
            $("#txtPQRSRecurrente").text(pqr.pla_ac_pqr_recurrente);
            $("#txtAccionEfectiva").text(pqr.pla_ac_accion_efectiva);
            $("#txtRespPqr").html(pqr.pla_ac_respuesta);
            $("#txtObservacionesGestor").text(pqr.observaciones_gestor);
            $("#txtObservacionesSupervisor").text(pqr.observaciones_revision);

            //INFORMACION SI TIENE ACTA

            let containerInfoActa = document.querySelector('.containerInfoActa');
                
            if(containerInfoActa){

                if(pqr.id_acta){

                    containerInfoActa.style.display = 'block';

                    $.ajax({
            
                        url: 'ajax/pqr/pqr.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'infoBuzonPQR',
                            'idPQR': pqr.id_pqr,
                        },
                        cache: false,
                        dataType: "json",
                        success:function(pqr){
                
                            $("#txtIdPQRSF").text(pqr.id_pqr);
                            $("#txtRadActa").text(pqr.radicado_acta);
                            $("#txtFechaActa").text(pqr.fecha_acta);
                            $("#txtFechaAperturaActa").text(pqr.fecha_apertura_buzon);
                
                            if(pqr.archivosActaPQRSF === 'SIN ARCHIVOS'){
                
                                $("#containerArchivosActasPQRSF").html(`<b>SIN ARCHIVOS</b>`);
                
                            }else{
                
                                let cadena = `<ul class="list-group">`;
                
                                for(const archivo of pqr.archivosActaPQRSF){
                
                                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivos_actas+archivo}" target="_blank">${archivo}</a></li>`;
                                    
                                }
                
                                cadena += `</ul>`;
                
                                $("#containerArchivosActasPQRSF").html(cadena);
                
                            }
                
                        }
                
                    })

                }else{

                    containerInfoActa.style.display = 'none';

                }

            }

            if(pqr.estado_pqr === 'FINALIZADO'){

                $("#contenedorArchivoResPQRSF").html(`
                <div class="alert alert-soft-success text-center" role="alert">
                    <b>ARCHIVO RESPUESTA PQRSF</b>
                    <br><br>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="${pqr.ruta_archivo_res}" target="_blank">Archivo Respuesta</a></li>
                    </ul>
                </div>`);

            }else{

                $("#contenedorArchivoResPQRSF").html('');

            }

            if(pqr.ruta_archivo_res){

                let cadena = `<div class="alert alert-soft-success text-center" role="alert">
                    <b>ARCHIVO RESPUESTA PQRSF</b>
                    <br><br>
                    <ul class="list-group">`;

                for(const archivo of pqr.archivosRespPQRSF){

                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivo_res+archivo}" target="_blank">${archivo}</a></li>`;
                    
                }

                cadena += `</ul></div`;

                $("#contenedorArchivoResPQRSF").html(cadena);

            }

        }

    })
}

const gestionarPQRS = (idPQR) => {

    Swal.fire({
        title: "¿Desea Gestionar la PQRSF?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Gestionar PQRSF!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/pqr/pqr.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'gestionarPQRS',
                    'idPQR': idPQR,
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La PQRSF se asigno correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Gestionar PQRSF',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#3085d6"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=pqr/gestionarpqrs&idPQRS='+btoa(idPQR);

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'La PQRSF no se asigno correctamente',
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

const abrirPQRS = (idPQR) => {

    window.location = 'index.php?ruta=pqr/gestionarpqrs&idPQRS='+btoa(idPQR);

}

const abrirRevisionPQRS = (idPQR) => {

    window.location = 'index.php?ruta=pqr/revisionpqr&idPQRS='+btoa(idPQR);

}

const crearPlanAccionPQRS = () => {

    let formulario = document.getElementById("formPlanAccionPqr");
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

            let form = document.querySelector('#formPlanAccionPqr');
            
            let respuestaPQRSF = document.querySelector('textarea[name="respuestaPQRSF"]');
            respuestaPQRSF = respuestaPQRSF.value;

            if(respuestaPQRSF){

                const formData = new FormData(form);

                let quienData = document.querySelector(`#planAccionQuien`);
                let respQuien = '';

                if(quienData){

                    let valoresSeleccionados = [];
                    let cadena = '';

                    for (var i = 0; i < quienData.options.length; i++) {
                        if (quienData.options[i].selected) {
                            valoresSeleccionados.push(quienData.options[i].value);
                            cadena += quienData.options[i].value + '-'; 
                        }
                    }

                    if(valoresSeleccionados.length <= 0){
                        Swal.fire({
                            text: 'Debe seleccionar alguna opcion en el campo ¿Quién?.',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })
                        return;
                    }

                    respQuien = cadena.slice(0, -1);

                }

                let recursosData = document.querySelector(`#planAccionRecursos`);
                let respRecursos = '';

                if(recursosData){

                    let valoresSeleccionados = [];
                    let cadena = '';

                    for (var i = 0; i < recursosData.options.length; i++) {
                        if (recursosData.options[i].selected) {
                            valoresSeleccionados.push(recursosData.options[i].value);
                            cadena += recursosData.options[i].value + '-'; 
                        }
                    }

                    if(valoresSeleccionados.length <= 0){
                        Swal.fire({
                            text: 'Debe seleccionar alguna opcion en el campo Recursos.',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })
                        return;
                    }

                    respRecursos = cadena.slice(0, -1);

                }

                let archivosPqr = document.getElementById("archivosPqr");

                formData.append('proceso', 'crearPlanAccionPQRS');
                formData.append('idPQRS', idPQRS);
                formData.append('respQuien', respQuien);
                formData.append('respRecursos', respRecursos);
                formData.append('userCreate', userSession);
                for(let file of archivosPqr.files){

                    formData.append('archivosPqr[]', file);

                }

                // for(const [key, value] of formData){
                //     console.log(key, value);
                // }

                loadingFnc();

                $.ajax({

                    url: 'ajax/pqr/pqr.ajax.php',
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        Swal.close();

                        if(respuesta == 'ok'){

                            Swal.fire({
                                text: '¡El Plan de Accion se creo correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{

                                if(result.isConfirmed){

                                    window.location = 'index.php?ruta=pqr/pendientespqr';

                                }

                            })

                        }else{

                            Swal.fire({
                                text: '¡El Plan de Accion no se creo correctamente!',
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

                toastr.warning("Recuerde diligenciar el campo Respuesta PQRSF.", "¡Atencion!");

            }

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const revisarPQRS = (idPQR) => {

    Swal.fire({
        title: "¿Desea Revisar la PQRSF?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Revisar PQRSF!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/pqr/pqr.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'revisarPQRS',
                    'idPQR': idPQR,
                    'user': userSession
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La PQRSF se asigno correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Revisar PQRSF',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#3085d6"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=pqr/revisionpqr&idPQRS='+btoa(idPQR);

                            }

                        })

                    }else if(respuesta == 'asignada'){

                        Swal.fire({
                            text: 'La PQRSF fue tomada por otro Supervisor',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })
                        
                    }else{

                        Swal.fire({
                            text: 'La PQRSF no se asigno correctamente',
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

const terminarRevisionPQRS = () => {

    let formulario = document.getElementById("formRevisionPqr");
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

            let form = document.querySelector('#formRevisionPqr');

            let respuestaPQRSF = document.querySelector('textarea[name="respuestaPQRSF"]');
            respuestaPQRSF = respuestaPQRSF.value;

            if(respuestaPQRSF){

                const formData = new FormData(form);

                let quienData = document.querySelector(`#planAccionQuien`);
                let respQuien = '';

                if(quienData){

                    let valoresSeleccionados = [];
                    let cadena = '';

                    for (var i = 0; i < quienData.options.length; i++) {
                        if (quienData.options[i].selected) {
                            valoresSeleccionados.push(quienData.options[i].value);
                            cadena += quienData.options[i].value + '-'; 
                        }
                    }

                    if(valoresSeleccionados.length <= 0){
                        Swal.fire({
                            text: 'Debe seleccionar alguna opcion en el campo ¿Quién?.',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })
                        return;
                    }

                    respQuien = cadena.slice(0, -1);

                }

                let recursosData = document.querySelector(`#planAccionRecursos`);
                let respRecursos = '';

                if(recursosData){

                    let valoresSeleccionados = [];
                    let cadena = '';

                    for (var i = 0; i < recursosData.options.length; i++) {
                        if (recursosData.options[i].selected) {
                            valoresSeleccionados.push(recursosData.options[i].value);
                            cadena += recursosData.options[i].value + '-'; 
                        }
                    }

                    if(valoresSeleccionados.length <= 0){
                        Swal.fire({
                            text: 'Debe seleccionar alguna opcion en el campo Recursos.',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })
                        return;
                    }

                    respRecursos = cadena.slice(0, -1);

                }

                let archivosPqr = document.getElementById("archivosPqr");

                formData.append('proceso', 'terminarRevisionPQRS');
                formData.append('idPQRS', idPQRS);
                formData.append('respuestaPQRSF', respuestaPQRSF);
                formData.append('respQuien', respQuien);
                formData.append('respRecursos', respRecursos);
                formData.append('userCreate', userSession);
                for(let file of archivosPqr.files){

                    formData.append('archivosPqr[]', file);

                }

                // for(const [key, value] of formData){
                //     console.log(key, value);
                // }

                loadingFnc();

                $.ajax({

                    url: 'ajax/pqr/pqr.ajax.php',
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        Swal.close();

                        if(respuesta == 'ok'){

                            Swal.fire({
                                text: '¡La Revision se guardo correctamente correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{

                                if(result.isConfirmed){

                                    window.location = 'index.php?ruta=pqr/pendientespqr';

                                }

                            })

                        }else{

                            Swal.fire({
                                text: '¡La Revision no se guardo correctamente!',
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

                toastr.warning("Recuerde diligenciar el campo Respuesta PQRSF.", "¡Atencion!");

            }

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const agregarUsuarioPQRS = () => {

    let formulario = document.getElementById("formAgregarUsuarioPQRS");
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

            let programasData = document.querySelector(`#programaUsuario`);
            let respProgramas = '';

            if(programasData){

                let valoresSeleccionados = [];
                let cadena = '';

                for (var i = 0; i < programasData.options.length; i++) {
                    if (programasData.options[i].selected) {
                        valoresSeleccionados.push(programasData.options[i].value);
                        cadena += programasData.options[i].value + '-'; 
                    }
                }

                // if(valoresSeleccionados.length <= 0){
                //     Swal.fire({
                //         text: 'Debe seleccionar alguna opcion en el campo Programa.',
                //         icon: 'error',
                //         confirmButtonText: 'Cerrar',
                //         allowOutsideClick: false,
                //         allowEscapeKey: false
                //     })
                //     return;
                // }

                respProgramas = cadena.slice(0, -1);

            }

            formData.append('lista', 'agregarUsuarioPQRS');
            formData.append('respPrograma', respProgramas);
            formData.append('userCreate', userSession);

            for(const [key, value] of formData){
                // console.log(key, value);
            }

            $.ajax({

                url: 'ajax/config/users.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType: "json",
                success:function(resp){

                    if(resp.respuesta === 'usuario-permisos-creado'){

                        Swal.fire({
                            title: '¡El Usuario PQRSF se creo correctamente!',
                            html: `<b>Usuario: </b> ${resp.usuario} <br> <b>Contraseña: </b> Numero Documento`,
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=pqr/adminusuariospqr';

                            }

                        })

                    }else if(resp.respuesta === 'usuario-existe'){

                        Swal.fire({
                            title: 'Error!',
                            text: '¡El Usuario ya existe!',
                            icon: 'error',
                            confirmButtonColor: "#d33",
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })


                    }else if(resp.respuesta === 'error-usuario-existe'){

                        Swal.fire({
                            title: 'Error!',
                            text: '¡El Numero de Documento ya esta registrado en otro Usuario!',
                            icon: 'error',
                            confirmButtonColor: "#d33",
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })

                        $("#documentoUsuario").val('');


                    }else if(resp.respuesta === 'error-creando-permisos'){

                        Swal.fire({
                            title: 'Error!',
                            text: 'El Usuario no se guardo los permisos correctamente',
                            icon: 'error',
                            confirmButtonColor: "#d33",
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })

                    }else if(resp.respuesta === 'no-existe-usuario'){

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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const recharzarPQRS = (idPQR) => {

    Swal.fire({
        title: "¿Desea Rechazar la PQRSF?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Rechazar PQRSF!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/pqr/pqr.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'rechazarPQRS',
                    'idPQR': idPQR
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La PQRSF se rechazo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=pqr/bolsaasignacionespqr';

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'La PQRSF no se rechazo correctamente',
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

const verAsignarPQRS = (idPQR) => {

    $.ajax({
        
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'infoPQR',
            'idPQR': idPQR,
        },
        cache: false,
        dataType: "json",
        success:function(pqr){
            
            // console.log(pqr);

            $("#txtIdPQRSAsignar").text(pqr.id_pqr);
            $("#idPQRSAsignar").val(pqr.id_pqr);
            $("#txtNombrePacAsignar").text(pqr.nombre_pac);
            $("#txtTipoDocPacAsignar").text(pqr.tipo_identificacion_pac);
            $("#txtNumDocPacAsignar").text(pqr.numero_identificacion_pac);
            $("#txtFechaNacPacAsignar").text(pqr.fecha_nacimiento_pac);
            $("#txtEpsAsignar").text(pqr.eps);
            $("#txtRegimenEpsAsignar").text(pqr.regimen);
            $("#txtProgramaAsignar").text(pqr.programa);
            $("#txtSedeAsignar").text(pqr.sede);
            $("#txtNombrePetAsignar").text(pqr.nombre_pet);
            $("#txtTipoDocPetAsignar").text(pqr.tipo_identificacion_pet);
            $("#txtNumDocPetAsignar").text(pqr.numero_identificacion_pet);
            $("#txtContactoPetAsignar").text(pqr.contacto_pet);
            $("#txtCorreoPetAsignar").text(pqr.correo_pet);
            $("#txtDepPetAsignar").text(pqr.departamento);
            $("#txtMunPetAsignar").text(pqr.municipio);
            $("#txtDescripcionPqrAsignar").html(pqr.descripcion_pqr);
            $("#txtMedRecepPqrAsignar").text(pqr.medio_recep_pqr);
            $("#txtFechaAperBuzonSugAsignar").text(pqr.fecha_apertura_buzon_suge);
            $("#txtFechaHoraRadPqrAsignar").text(pqr.fecha_radicacion_pqr);
            $("#txtTipoPqrAsignar").text(pqr.tipo_pqr);
            $("#txtEnteRepPqrAsignar").text(pqr.ente_reporta_pqr);
            $("#txtMotivoPqrAsignar").text(pqr.motivo_pqr);
            $("#txtTrabajadorRelaPqrAsignar").text(pqr.trabajador_relacionado_pqr);
            $("#txtGestorPqrAsignar").text(`${pqr.nombre} - ${pqr.gestor}`);
            $("#txtServAreaPqrAsignar").text(pqr.servicio_area);
            $("#txtCaliAtribuPqrAsignar").text(pqr.clasificacion_atributo);
            $("#txtTiempoResNormaPqrAsignar").text(pqr.tiempo_res_normativo);
            $("#txtHorasDiasOportPqrAsignar").text(pqr.horas_dias_oportunidad);
            $("#txtFechaPQRSFAsignar").text(pqr.fecha_pqr);

            if(pqr.archivosPQRSF === 'SIN ARCHIVOS'){

                $("#containerArchivosPQRSFAsignar").html(`<b>SIN ARCHIVOS</b>`);

            }else{

                let cadena = `<ul class="list-group">`;

                for(const archivo of pqr.archivosPQRSF){

                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivos+archivo}" target="_blank">${archivo}</a></li>`;
                    
                }

                cadena += `</ul>`;

                $("#containerArchivosPQRSFAsignar").html(cadena);

            }

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaGestoresProgramaPqr',
                    'programa': pqr.programa
                },
                success:function(respuesta){
            
                    $("#gestoresPqrAsignar").html(respuesta);
            
                }
            
            })

        }

    })

}

const asignarPQRS = () => {

    let formulario = document.getElementById("formAsignarPQRS");
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

            formData.append('proceso', 'asignarPQRS');
            formData.append('userCreate', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/pqr/pqr.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La PQRSF se asigno correctamente correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=pqr/bolsarevisionpqr';

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡La PQRSF no se asigno correctamente!',
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

const abrirCargaResPQRSF = (idPQR) => {

    window.location = 'index.php?ruta=pqr/cargarrespqr&idPQRS='+btoa(idPQR);

}

const guardarResPQRSF = () => {

    let formulario = document.getElementById("formCargarResPqr");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let archivosPqr = document.getElementById("respuestaPqr");
            let fechaRespPQRSF = document.getElementById("fechaRespuestaPqr").value;

            // console.log(archivo[0]);

            let data = new FormData();
            data.append("proceso", "guardarResPQRSF");
            data.append("idPQRSF", idPQRS);
            data.append("fechaRespPQRSF", fechaRespPQRSF);
            data.append("user", userSession);
            for(let file of archivosPqr.files){

                data.append('archivoResPQRSF[]', file);
            
            }

            loadingFnc();

            $.ajax({

                url: 'ajax/pqr/pqr.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    Swal.close();
                
                    if(respuesta === 'ok'){

                        Swal.fire({

                            text: '¡La Respuesta del PQRSF se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=pqr/listapqrcargares';

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡La Respuesta del PQRSF no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })



        }

    }

}

const setTextCkEditor = async (idElement, text) => {
    if (!ckEditorInstance) {
        // Crear el editor si no existe
        ckEditorInstance = await ClassicEditor
            .create(document.querySelector(`#${idElement}`), {
                toolbar: {
                    items: [
                        'bold', 'italic', '|',
                        'bulletedList', 'numberedList', '|',
                        'undo', 'redo', '|',
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    }

    // Si ya existe el editor, solo actualizar el contenido
    if (ckEditorInstance) {
        ckEditorInstance.setData(text);
    }
};

const registrarInfoPacientePeticionario = () => {

    let checkPacPet = document.querySelector('#checkPacientePeticionario');

    if(checkPacPet.checked){

        let nombrePaciente = document.querySelector('#nombrePaciente').value;
        let tipoDocPaciente = document.querySelector('#tipoDocPaciente').value;
        let numDocPaciente = document.querySelector('#numIdentificacionPaciente').value;

        if(nombrePaciente && tipoDocPaciente && numDocPaciente){

            // console.log('Ingreso', {nombrePaciente, tipoDocPaciente, numDocPaciente});

            $("#nombrePeticionario").val(nombrePaciente);
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaTipoDocumento'
                },
            }).done(function (tipoDocPacienteList) {
                $("#tipoDocPeticionario").html(tipoDocPacienteList);
                $("#tipoDocPeticionario").val(tipoDocPaciente);
            })
            $("#numIdentificacionPeticionario").val(numDocPaciente);

        }
        
    }else{

        $("#nombrePeticionario").val('');
        $.ajax({
            type: 'POST',
            url: 'ajax/parametricas.ajax.php',
            data: {
                'lista': 'listaTipoDocumento'
            },
        }).done(function (tipoDocPacienteList) {
            $("#tipoDocPeticionario").html(tipoDocPacienteList);
            $("#tipoDocPeticionario").val('');
        })
        $("#numIdentificacionPeticionario").val('');

        
    }
}

const agregarTrabajadorPQRSF = () => {

    let formulario = document.getElementById("formAgregarTrabajadorPQRSF");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formAgregarTrabajadorPQRSF');

            const data = new FormData(form);

            // console.log(archivo[0]);
            data.append("proceso", "agregarTrabajadorPQRSF");
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/pqr/pqr.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({

                            text: '¡El Trabajador se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){

                                tablaTrabajadoresPQRSF.ajax.reload();
                                $('#tipoDocumentoTrabajador').val('').trigger('change');
                                $('#documentoTrabajador').val('');
                                $('#nombreTrabajador').val('');

                            }

                        })

                    }else if(respuesta == 'trabajador-existe'){

                        Swal.fire({

                            text: '¡El Trabajador ya esta registrado!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }else{

                        Swal.fire({

                            text: '¡El Trabajador no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })



        }

    }

}

const eliminarTrabajador = (idTrabajador, nombreTrabajador) => {
    
    Swal.fire({
        title: `¿Desea eliminar el Trabajador: ${nombreTrabajador}?`,
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar Trabajador!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/pqr/pqr.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarTrabajadorPQRSF',
                    'idTrabajadorPQRSF': idTrabajador,
                    'user': userSession
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡El Trabajador se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tablaTrabajadoresPQRSF.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'El Trabajador no se asigno correctamente',
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

const eliminarArchivoPQRSF = (rutaArchivo, archivo) => {

    Swal.fire({
        title: `¿Desea eliminar el Archivo: ${archivo}?`,
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar Archivo!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/pqr/pqr.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminararchivoPQRSF',
                    'idPQRSF': idPQRS,
                    'rutaArchivo': rutaArchivo,
                    'user': userSession
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡El Archivo se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                location.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'El Archivo no se elimino correctamente',
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

tablaAsignacionesPQRS = $('#tablaAsignacionesPQRS').DataTable({

    columns: [
        { name: '#', data: 'id_pqr' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_pac' },
        { 
            name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                return `${row.tipo_identificacion_pac} - ${row.numero_identificacion_pac}`;
            }
        },
        { name: 'TIPO PQRS', data: 'tipo_pqr' },
        { name: 'MOTIVO PQRS', data: 'motivo_pqr' },
        { name: 'SERVICIO O AREA', data: 'servicio_area' },
        { name: 'CLASIFICACION ATRIBUTO', data: 'clasificacion_atributo' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-info btn-sm" onclick="verPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="recharzarPQRS(${row.id_pqr})" title="Rechazar PQRSF"><i class="far fa-times-circle"></i></button>
                    <button type="button" class="btn btn-success btn-sm" onclick="gestionarPQRS(${row.id_pqr})" title="Gestionar PQRSF"><i class="fas fa-check-square"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaAsignacionesPQRS',
            'user': userSession
        }
    }

})

tablaPendientesPQRS = $('#tablaPendientesPQRS').DataTable({

    columns: [
        { name: '#', data: 'id_pqr' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_pac' },
        { 
            name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                return `${row.tipo_identificacion_pac} - ${row.numero_identificacion_pac}`;
            }
        },
        { name: 'TIPO PQRS', data: 'tipo_pqr' },
        { name: 'MOTIVO PQRSF', data: 'motivo_pqr' },
        { name: 'SERVICIO O AREA', data: 'servicio_area' },
        { name: 'CLASIFICACION ATRIBUTO', data: 'clasificacion_atributo' },
        { name: 'GESTOR', data: 'nombre' },
        { name: 'FECHA INI', data: 'fecha_ini_gestor' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-info btn-sm" onclick="verPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                    <button type="button" class="btn btn-success btn-sm" onclick="abrirPQRS(${row.id_pqr})" title="Abrir PQRSF"><i class="far fa-share-square"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPendientesPQRS',
            'user': userSession
        }
    }

})

tablaRevisionesPQRS = $('#tablaRevisionesPQRS').DataTable({

    columns: [
        { name: '#', data: 'id_pqr' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_pac' },
        { 
            name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                return `${row.tipo_identificacion_pac} - ${row.numero_identificacion_pac}`;
            }
        },
        { name: 'TIPO PQRS', data: 'tipo_pqr' },
        { name: 'MOTIVO PQRS', data: 'motivo_pqr' },
        { name: 'SERVICIO O AREA', data: 'servicio_area' },
        { name: 'CLASIFICACION ATRIBUTO', data: 'clasificacion_atributo' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                if(row.estado_pqr === 'REVISION'){

                    return `
                        <button type="button" class="btn btn-info btn-sm" onclick="verPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                        <button type="button" class="btn btn-success btn-sm" onclick="revisarPQRS(${row.id_pqr})" title="Revisar PQRSF"><i class="far fa-share-square"></i></button>
                    `;
                    
                }else{
                    
                    return `
                        <button type="button" class="btn btn-info btn-sm" onclick="verPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="verAsignarPQRS(${row.id_pqr})" title="Asignar PQRSF" data-bs-toggle="modal" data-bs-target="#modalAsignarPQRS"><i class="fas fa-user-plus"></i></button>
                    `;

                }

            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaRevisionesPQRS'
        }
    }

})

tablaPendientesRevisionPQRS = $('#tablaPendientesRevisionPQRS').DataTable({

    columns: [
        { name: '#', data: 'id_pqr' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_pac' },
        { 
            name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                return `${row.tipo_identificacion_pac} - ${row.numero_identificacion_pac}`;
            }
        },
        { name: 'TIPO PQRS', data: 'tipo_pqr' },
        { name: 'MOTIVO PQRS', data: 'motivo_pqr' },
        { name: 'SERVICIO O AREA', data: 'servicio_area' },
        { name: 'CLASIFICACION ATRIBUTO', data: 'clasificacion_atributo' },
        { name: 'GESTOR', data: 'nombre' },
        { name: 'FECHA INI', data: 'fecha_ini_gestor' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-info btn-sm" onclick="verPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                    <button type="button" class="btn btn-success btn-sm" onclick="abrirRevisionPQRS(${row.id_pqr})" title="Abrir Revision PQRSF"><i class="far fa-share-square"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPendientesRevisionPQRS',
            'user': userSession
        }
    }

})

tablaPQRS = $('#tablaPQRS').DataTable({

    columns: [
        { name: '#', data: 'id_pqr' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_pac' },
        { 
            name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                return `${row.tipo_identificacion_pac} - ${row.numero_identificacion_pac}`;
            }
        },
        { name: 'TIPO PQRS', data: 'tipo_pqr' },
        { name: 'MOTIVO PQRS', data: 'motivo_pqr' },
        { name: 'SERVICIO O AREA', data: 'servicio_area' },
        { name: 'CLASIFICACION ATRIBUTO', data: 'clasificacion_atributo' },
        { name: 'MEDIO RECEPCION', data: 'medio_recep_pqr' },
        { name: 'FECHA PQRSF', data: 'fecha_pqr' },
        { name: 'FECHA RESPUESTA PQRSF', data: 'fecha_respuesta_pqr' },
        { name: 'EPS', data: 'eps' },
        { name: 'SEDE', data: 'sede' },
        {
            name: 'ESTADO PQR', render: function(data, type, row){

                if(row.estado_pqr === 'CREADA'){
                    return `<span class="badge badge-phoenix badge-phoenix-danger">SIN TRAMITE</span>`;
                }else if(row.estado_pqr === 'GESTION' || row.estado_pqr === 'REVISION' || row.estado_pqr === 'REVISANDO'){
                    return `<span class="badge badge-phoenix badge-phoenix-warning">EN PROCESO DE TRAMITE</span>`;
                }else if(row.estado_pqr === 'COMPLETADO'){
                    return `<span class="badge badge-phoenix badge-phoenix-info">RESPUESTA POR LA ENTIDAD</span>`;
                }else{
                    return `<span class="badge badge-phoenix badge-phoenix-success">CERRADO TOTAL</span>`;
                }
            }
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                if(row.estado_pqr === 'COMPLETADO' || row.estado_pqr === 'FINALIZADO'){
                    return `
                        <button type="button" class="btn btn-info btn-sm" onclick="infoPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                        <a type="button" target="_blank" class="btn btn-success btn-sm" href="plugins/TCPDF/examples/pqrsf_generated.php?idPQRSF=${btoa(row.id_pqr)}" onclick="infoPQRS(${row.id_pqr})" title="Generar PQRSF"><i class="fas fa-file-pdf"></i></a>
                    `;

                }else{
                    return `
                        <button type="button" class="btn btn-info btn-sm" onclick="infoPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                    `;
                }

            }
        }
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
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPQRS',
            'user': userSession
        }
    }

})

tablaPQRSFSearch = $('#tablaPQRSFSearch').DataTable({

    columns: [
        { name: '#', data: 'id_pqr' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_pac' },
        { 
            name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                return `${row.tipo_identificacion_pac} - ${row.numero_identificacion_pac}`;
            }
        },
        { name: 'TIPO PQRS', data: 'tipo_pqr' },
        { name: 'MOTIVO PQRS', data: 'motivo_pqr' },
        { name: 'SERVICIO O AREA', data: 'servicio_area' },
        { name: 'CLASIFICACION ATRIBUTO', data: 'clasificacion_atributo' },
        { name: 'MEDIO RECEPCION', data: 'medio_recep_pqr' },
        { name: 'FECHA PQRSF', data: 'fecha_pqr' },
        { name: 'FECHA RESPUESTA PQRSF', data: 'fecha_respuesta_pqr' },
        { name: 'EPS', data: 'eps' },
        { name: 'SEDE', data: 'sede' },
        {
            name: 'ESTADO PQR', render: function(data, type, row){

                if(row.estado_pqr === 'CREADA'){
                    return `<span class="badge badge-phoenix badge-phoenix-danger">SIN TRAMITE</span>`;
                }else if(row.estado_pqr === 'GESTION' || row.estado_pqr === 'REVISION' || row.estado_pqr === 'REVISANDO'){
                    return `<span class="badge badge-phoenix badge-phoenix-warning">EN PROCESO DE TRAMITE</span>`;
                }else if(row.estado_pqr === 'COMPLETADO'){
                    return `<span class="badge badge-phoenix badge-phoenix-info">RESPUESTA POR LA ENTIDAD</span>`;
                }else{
                    return `<span class="badge badge-phoenix badge-phoenix-success">CERRADO TOTAL</span>`;
                }
            }
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
               
                return `
                    <button type="button" class="btn btn-info btn-sm" onclick="infoPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                `;

            }
        }
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
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPQRS',
            'user': userSession
        }
    }

})

$('#tablaPQRSFSearch thead tr').clone(true).appendTo( '#tablaPQRSFSearch thead' );

$('#tablaPQRSFSearch thead tr:eq(1) th').each( function (i) {

    var title = $(this).text();
    $(this).html( '<input type="text" class="form-control" placeholder="Buscar..." />' );

    $( 'input', this ).on( 'keyup change', function () {

        if(tablaPQRSFSearch.column(i).search() !== this.value){

            tablaPQRSFSearch
                .column(i)
                .search( this.value )
                .draw();

        }

    })

})



tablaPQRSGestionadosGestor = $('#tablaPQRSGestionadosGestor').DataTable({

    columns: [
        { name: '#', data: 'id_pqr' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_pac' },
        { 
            name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                return `${row.tipo_identificacion_pac} - ${row.numero_identificacion_pac}`;
            }
        },
        { name: 'TIPO PQRS', data: 'tipo_pqr' },
        { name: 'MOTIVO PQRS', data: 'motivo_pqr' },
        { name: 'SERVICIO O AREA', data: 'servicio_area' },
        { name: 'CLASIFICACION ATRIBUTO', data: 'clasificacion_atributo' },
        { name: 'FECHA PQRSF', data: 'fecha_pqr' },
        { name: 'EPS', data: 'eps' },
        { name: 'SEDE', data: 'sede' },
        {
            name: 'ESTADO PQR', render: function(data, type, row){

                if(row.estado_pqr === 'CREADA'){
                    return `<span class="badge badge-phoenix badge-phoenix-danger">SIN TRAMITE</span>`;
                }else if(row.estado_pqr === 'GESTION' || row.estado_pqr === 'REVISION' || row.estado_pqr === 'REVISANDO'){
                    return `<span class="badge badge-phoenix badge-phoenix-warning">EN PROCESO DE TRAMITE</span>`;
                }else if(row.estado_pqr === 'COMPLETADO'){
                    return `<span class="badge badge-phoenix badge-phoenix-info">RESPUESTA POR LA ENTIDAD</span>`;
                }else{
                    return `<span class="badge badge-phoenix badge-phoenix-success">CERRADO TOTAL</span>`;
                }
            }
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `
                    <button type="button" class="btn btn-info btn-sm" onclick="infoPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                `;

            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPQRSGestionadosGestor',
            'user': userSession
        }
    }

})

tablaCargarResPQRS = $('#tablaCargarResPQRS').DataTable({

    columns: [
        { name: '#', data: 'id_pqr' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_pac' },
        { 
            name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                return `${row.tipo_identificacion_pac} - ${row.numero_identificacion_pac}`;
            }
        },
        { name: 'TIPO PQRS', data: 'tipo_pqr' },
        { name: 'MOTIVO PQRS', data: 'motivo_pqr' },
        { name: 'SERVICIO O AREA', data: 'servicio_area' },
        { name: 'CLASIFICACION ATRIBUTO', data: 'clasificacion_atributo' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-info btn-sm" onclick="infoPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                    <button type="button" class="btn btn-success btn-sm" onclick="abrirCargaResPQRSF(${row.id_pqr})" title="Cargar Respuesta PQRSF"><i class="fas fa-cloud-upload-alt"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaCargarResPQRSF'
        }
    }

})

tablaTrabajadoresPQRSF = $('#tablaTrabajadoresPQRSF').DataTable({

    columns: [
        { name: '#', data: 'id_par_trabajador' },
        { name: 'TIPO DOCUMENTO', data: 'tipo_doc_trabajador' },
        { name: 'NUMERO DOCUMENTO', data: 'numero_doc_trabajador'},
        { name: 'NOMBRE TRABAJADOR', data: 'nombre_trabajador' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTrabajador(${row.id_par_trabajador},'${row.nombre_trabajador}')" title="Eliminar Trabajador"><i class="far fa-trash-alt"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaTrabajadoresPQRSF',
        }
    }

})

tablaUsuariosPQRS = $('#tablaUsuariosPQRS').DataTable({

    columns: [
        { name: '#', data: 'id_pqr_usuario' },
        { name: 'TIPO', data: 'tipo' },
        { name: 'NOMBRE PACIENTE', data: 'nombre' },
        { name: 'NUMERO DOCUMENTO', data: 'numero_documento'},
        { name: 'PROGRAMA', data: 'programas'},
        { name: 'USUARIO', data: 'usuario' },
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaUsuariosPQRS',
        }
    }

})

if(rutaValor == 'pqr/cargarrespqr'){

    infoPQRS(idPQRS);

}

if(rutaValor == 'pqr/revisionpqr'){

    $.ajax({
        
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'infoPQR',
            'idPQR': idPQRS,
        },
        cache: false,
        dataType: "json",
        success:function(pqr){

            // console.log(pqr);

            //INFORMACION SI TIENE ACTA
            if(pqr.id_acta){

                let btnVerActas = document.querySelector('.btnVerActas');

                if(btnVerActas){

                    btnVerActas.style.display = 'block';

                    $.ajax({
            
                        url: 'ajax/pqr/pqr.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'infoBuzonPQR',
                            'idPQR': pqr.id_pqr,
                        },
                        cache: false,
                        dataType: "json",
                        success:function(pqr){
                
                            $("#txtIdPQRSF").text(pqr.id_pqr);
                            $("#txtRadActa").text(pqr.radicado_acta);
                            $("#txtFechaActa").text(pqr.fecha_acta);
                            $("#txtFechaAperturaActa").text(pqr.fecha_apertura_buzon);
                
                            if(pqr.archivosActaPQRSF === 'SIN ARCHIVOS'){
                
                                $("#containerArchivosActasPQRSF").html(`<b>SIN ARCHIVOS</b>`);
                
                            }else{
                
                                let cadena = `<ul class="list-group">`;
                
                                for(const archivo of pqr.archivosActaPQRSF){
                
                                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivos_actas+archivo}" target="_blank">${archivo}</a></li>`;
                                    
                                }
                
                                cadena += `</ul>`;
                
                                $("#containerArchivosActasPQRSF").html(cadena);
                
                            }
                
                        }
                
                    })

                }

            }

            //INFORMACION PQRSF
            $("#txtIdPQRS").text(pqr.id_pqr);
            $("#nombrePaciente").val(pqr.nombre_pac);
            $("#numIdentificacionPaciente").val(pqr.numero_identificacion_pac);
            $("#fechaNacimientoPaciente").val(pqr.fecha_nacimiento_pac);
            $("#nombrePeticionario").val(pqr.nombre_pet);
            $("#numIdentificacionPeticionario").val(pqr.numero_identificacion_pet);
            $("#telefonoPeticionario").val(pqr.contacto_pet);
            $("#correoPeticionario").val(pqr.correo_pet);
            $("#fechaPQRSF").val(pqr.fecha_pqr);
            // $("#descripcionPqr").val(pqr.descripcion_pqr);
            setTextCkEditor('descripcionPqr', pqr.descripcion_pqr);

            $("#txtFechaHoraRadPqr").text(pqr.fecha_radicacion_pqr);
            $("#txtGestorPqr").text(`${pqr.nombre} - ${pqr.gestor}`);
            $("#txtTiempoResNormaPqr").text(pqr.tiempo_res_normativo);
            $("#txtHorasDiasOportPqr").text(pqr.horas_dias_oportunidad);
            $("#clasificacionAtributoPqr").val(pqr.clasificacion_atributo);
            $("#txtRutaArchivosPQRSF").val(pqr.ruta_archivos);
            $("#gestorObservaciones").val(pqr.observaciones_gestor);

            let fechaAperturaBuzon = document.querySelector('#fechaAperturaBuzonSugerencias');

            if(pqr.medio_recep_pqr !== 'BUZON DE SUGERENCIAS'){

                fechaAperturaBuzon.setAttribute('readonly', true);
                fechaAperturaBuzon.setAttribute('type', 'text');
                fechaAperturaBuzon.classList.add('readonly');
                fechaAperturaBuzon.value = 'NO APLICA';
                
            }else{
                fechaAperturaBuzon.setAttribute('type', 'date');
                fechaAperturaBuzon.removeAttribute('readonly');
                fechaAperturaBuzon.classList.remove('readonly');
                fechaAperturaBuzon.value = pqr.fecha_apertura_buzon_suge;

            }

            let planAccionMotivoResponsableNega = document.querySelector('#planAccionMotivoResponsableNega');

            if(pqr.pla_ac_negacion_pqr === 'NO'){

                planAccionMotivoResponsableNega.setAttribute('readonly', true);
                planAccionMotivoResponsableNega.classList.add('readonly');
                planAccionMotivoResponsableNega.value = 'NO APLICA';
        
            }else{
        
                planAccionMotivoResponsableNega.removeAttribute('readonly');
                planAccionMotivoResponsableNega.classList.remove('readonly');
                planAccionMotivoResponsableNega.value = '';
        
            }


            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaTipoDocumento'
                },
            }).done(function (tipoDocPaciente) {
                $("#tipoDocPaciente").html(tipoDocPaciente);
                $("#tipoDocPaciente").val(pqr.tipo_identificacion_pac);
            })

            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaTipoDocumento'
                },
            }).done(function (tipoDocPaciente) {
                $("#tipoDocPeticionario").html(tipoDocPaciente);
                $("#tipoDocPeticionario").val(pqr.tipo_identificacion_pet);
            })

            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaRegimenes'
                },
            }).done(function (regimenes) {
                $("#regimenEps").html(regimenes);
                $("#regimenEps").val(pqr.regimen);
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaProgramasPqr'
                },
                success:function(respuesta){
            
                    $("#programaPqr").html(respuesta);
                    $("#programaPqr").val(pqr.programa);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaSedesPqr',
                    'programa': pqr.programa
                },
                success:function(respuesta){
        
                    $("#sedePqr").html(respuesta);
                    $("#sedePqr").val(pqr.sede);
        
                }
        
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaEpsSedePqr',
                    'sede': pqr.sede
                },
                success:function(respuesta){
        
                    $("#epsPqr").html(respuesta);
                    $("#epsPqr").val(pqr.eps);
        
                }
        
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaDepartamentos'
                },
                success:function(respuesta){
            
                    $("#departamentoPeticionario").html(respuesta);
                    $("#departamentoPeticionario").val(pqr.departamento);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaMunicipiosDepartamento',
                    'departamento': pqr.departamento
                },
                success:function(respuesta){
        
                    $("#municipioPeticionario").html(respuesta);
                    $("#municipioPeticionario").val(pqr.municipio);
        
                }
        
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaMediosRecepcionPqr'
                },
                success:function(respuesta){
            
                    $("#medioRecepcionPqr").html(respuesta);
                    $("#medioRecepcionPqr").val(pqr.medio_recep_pqr);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaTiposPqr'
                },
                success:function(respuesta){
            
                    $("#tipoPqr").html(respuesta);
                    $("#tipoPqr").val(pqr.tipo_pqr);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaEntesPqr'
                },
                success:function(respuesta){
            
                    $("#enteReportePqr").html(respuesta);
                    $("#enteReportePqr").val(pqr.ente_reporta_pqr);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaMotivosPqr'
                },
                success:function(respuesta){
            
                    $("#motivoPqr").html(respuesta);
                    $("#motivoPqr").val(pqr.motivo_pqr);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaTrabajadorRelaPqr'
                },
                success:function(respuesta){
            
                    $("#trabajadorRelaPqr").html(respuesta);
                    $("#trabajadorRelaPqr").val(pqr.trabajador_relacionado_pqr);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaServiciosAreasPqr'
                },
                success:function(respuesta){
            
                    $("#servcioAreaPqr").html(respuesta);
                    $("#servcioAreaPqr").val(pqr.servicio_area);
            
                }
            
            })


            if(pqr.archivosPQRSF === 'SIN ARCHIVOS'){

                $("#containerArchivosPQRSF").html(`<b>SIN ARCHIVOS</b>`);

            }else{

                let cadena = `<ul class="list-group">`;

                for(const archivo of pqr.archivosPQRSF){

                    const rutaArchivo = pqr.ruta_archivos+archivo;

                    cadena += `<li class="list-group-item"><i class="fas fa-trash-alt text-danger" onclick="eliminarArchivoPQRSF('${rutaArchivo}', '${archivo}')" style="cursor: pointer"></i> <a href="${pqr.ruta_archivos+archivo}" target="_blank">${archivo}</a></li>`;
                    
                }

                cadena += `</ul>`;

                $("#containerArchivosPQRSF").html(cadena);

            }

            
            //INFORMACION PLAN ACCION

            $("#planAccionQue").val(pqr.pla_ac_que);
            $("#planAccionPorQue").val(pqr.pla_ac_por_que);
            $("#planAccionCuando").val(pqr.pla_ac_cuando);
            $("#planAccionDonde").val(pqr.pla_ac_donde);
            $("#planAccionComo").val(pqr.pla_ac_como);
            $("#planAccionQuien").val(pqr.pla_ac_quien);
            $("#planAccionNegacion").val(pqr.pla_ac_negacion_pqr);
            $("#planAccionMotivoResponsableNega").val(pqr.pla_ac_motivo_negacion);
            $("#planAccionPqrRecurrente").val(pqr.pla_ac_pqr_recurrente);
            $("#planAccionEfectiva").val(pqr.pla_ac_accion_efectiva);
            setTextCkEditor('respuestaPQRSF', pqr.pla_ac_respuesta);
            // $("#respuestaPQRSF").val(pqr.pla_ac_respuesta);

            $.ajax({

                type: "POST",
                url: "ajax/pqr/pqr.ajax.php",
                data: {
                    'proceso': 'listaQuienRevisionPqr',
                    'opciones': pqr.pla_ac_quien
                },
                success:function(respuesta){
            
                    $("#planAccionQuien").html(respuesta);
                    // $("#planAccionRecursos").val(pqr.pla_ac_recurso);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/pqr/pqr.ajax.php",
                data: {
                    'proceso': 'listaRecursosRevisionPqr',
                    'opciones': pqr.pla_ac_recurso
                },
                success:function(respuesta){
            
                    $("#planAccionRecursos").html(respuesta);
                    // $("#planAccionRecursos").val(pqr.pla_ac_recurso);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaPlaAcDonde'
                },
                success:function(respuesta){
            
                    $("#planAccionDonde").html(respuesta);
                    $("#planAccionDonde").val(pqr.pla_ac_donde);
            
                }
            
            })

        }

    })
    
}

if(rutaValor == 'pqr/gestionarbuzonpqrs'){

    $.ajax({
        
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'infoBuzonPQR',
            'idPQR': idPQRS,
        },
        cache: false,
        dataType: "json",
        success:function(pqr){

            // console.log(pqr);
            $("#txtRadActa").text(pqr.radicado_acta);
            $("#txtIdPQRSF").text(pqr.id_pqr);
            $("#txtFechaActa").text(pqr.fecha_acta);
            $("#txtFechaAperturaActa").text(pqr.fecha_apertura_buzon);

            if(pqr.archivosActaPQRSF === 'SIN ARCHIVOS'){

                $("#containerArchivosActasPQRSF").html(`<b>SIN ARCHIVOS</b>`);

            }else{

                let cadena = `<ul class="list-group">`;

                for(const archivo of pqr.archivosActaPQRSF){

                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivos_actas+archivo}" target="_blank">${archivo}</a></li>`;
                    
                }

                cadena += `</ul>`;

                $("#containerArchivosActasPQRSF").html(cadena);

            }

        }

    })
    
}

if(rutaValor == 'pqr/gestionarpqrs'){

    $.ajax({
        
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'infoPQR',
            'idPQR': idPQRS,
        },
        cache: false,
        dataType: "json",
        success:function(pqr){
            
            // console.log(pqr);
            $("#txtIdPQRS").text(pqr.id_pqr);
            $("#nombrePaciente").val(pqr.nombre_pac);
            $("#numIdentificacionPaciente").val(pqr.numero_identificacion_pac);
            $("#fechaNacimientoPaciente").val(pqr.fecha_nacimiento_pac);
            $("#nombrePeticionario").val(pqr.nombre_pet);
            $("#numIdentificacionPeticionario").val(pqr.numero_identificacion_pet);
            $("#telefonoPeticionario").val(pqr.contacto_pet);
            $("#correoPeticionario").val(pqr.correo_pet);
            $("#fechaPQRSF").val(pqr.fecha_pqr);


            setTextCkEditor('descripcionPqr', pqr.descripcion_pqr);
            // let descripcionPqr = document.querySelector('textarea[name="descripcionPqr"]');
            // console.log(descripcionPqr);
            // descripcionPqr.value = pqr.descripcion_pqr;
            // $("#descripcionPqr").val(pqr.descripcion_pqr);


            $("#txtFechaHoraRadPqr").text(pqr.fecha_radicacion_pqr);
            $("#txtGestorPqr").text(`${pqr.nombre} - ${pqr.gestor}`);
            $("#txtTiempoResNormaPqr").text(pqr.tiempo_res_normativo);
            $("#txtHorasDiasOportPqr").text(pqr.horas_dias_oportunidad);
            $("#clasificacionAtributoPqr").val(pqr.clasificacion_atributo);
            $("#planAccionPqrRecurrente").val(pqr.pla_ac_pqr_recurrente);
            $("#planAccionEfectiva").val(pqr.pla_ac_accion_efectiva);
            $("#txtRutaArchivosPQRSF").val(pqr.ruta_archivos);



            let fechaAperturaBuzon = document.querySelector('#fechaAperturaBuzonSugerencias');

            if(pqr.medio_recep_pqr !== 'BUZON DE SUGERENCIAS'){

                fechaAperturaBuzon.setAttribute('readonly', true);
                fechaAperturaBuzon.setAttribute('type', 'text');
                fechaAperturaBuzon.classList.add('readonly');
                fechaAperturaBuzon.value = 'NO APLICA';
                
            }else{
                fechaAperturaBuzon.setAttribute('type', 'date');
                fechaAperturaBuzon.removeAttribute('readonly');
                fechaAperturaBuzon.classList.remove('readonly');
                fechaAperturaBuzon.value = pqr.fecha_apertura_buzon_suge;

            }


            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaTipoDocumento'
                },
            }).done(function (tipoDocPaciente) {
                $("#tipoDocPaciente").html(tipoDocPaciente);
                $("#tipoDocPaciente").val(pqr.tipo_identificacion_pac);
            })

            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaTipoDocumento'
                },
            }).done(function (tipoDocPaciente) {
                $("#tipoDocPeticionario").html(tipoDocPaciente);
                $("#tipoDocPeticionario").val(pqr.tipo_identificacion_pet);
            })

            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaRegimenes'
                },
            }).done(function (regimenes) {
                $("#regimenEps").html(regimenes);
                $("#regimenEps").val(pqr.regimen);
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaProgramasPqr'
                },
                success:function(respuesta){
            
                    $("#programaPqr").html(respuesta);
                    $("#programaPqr").val(pqr.programa);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaSedesPqr',
                    'programa': pqr.programa
                },
                success:function(respuesta){
        
                    $("#sedePqr").html(respuesta);
                    $("#sedePqr").val(pqr.sede);
        
                }
        
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaEpsSedePqr',
                    'sede': pqr.sede
                },
                success:function(respuesta){
        
                    $("#epsPqr").html(respuesta);
                    $("#epsPqr").val(pqr.eps);
        
                }
        
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaDepartamentos'
                },
                success:function(respuesta){
            
                    $("#departamentoPeticionario").html(respuesta);
                    $("#departamentoPeticionario").val(pqr.departamento);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaMunicipiosDepartamento',
                    'departamento': pqr.departamento
                },
                success:function(respuesta){
        
                    $("#municipioPeticionario").html(respuesta);
                    $("#municipioPeticionario").val(pqr.municipio);
        
                }
        
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaMediosRecepcionPqr'
                },
                success:function(respuesta){
            
                    $("#medioRecepcionPqr").html(respuesta);
                    $("#medioRecepcionPqr").val(pqr.medio_recep_pqr);
            
                }
            
            })

            if(pqr.archivosPQRSF === 'SIN ARCHIVOS'){

                $("#containerArchivosPQRSF").html(`<b>SIN ARCHIVOS</b>`);

            }else{

                let cadena = `<ul class="list-group">`;

                for(const archivo of pqr.archivosPQRSF){

                    const rutaArchivo = pqr.ruta_archivos+archivo;

                    cadena += `<li class="list-group-item"><i class="fas fa-trash-alt text-danger" onclick="eliminarArchivoPQRSF('${rutaArchivo}', '${archivo}')" style="cursor: pointer"></i> <a href="${pqr.ruta_archivos+archivo}" target="_blank">${archivo}</a></li>`;
                    
                }

                cadena += `</ul>`;

                $("#containerArchivosPQRSF").html(cadena);

            }

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaTiposPqr'
                },
                success:function(respuesta){
            
                    $("#tipoPqr").html(respuesta);
                    $("#tipoPqr").val(pqr.tipo_pqr);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaEntesPqr'
                },
                success:function(respuesta){
            
                    $("#enteReportePqr").html(respuesta);
                    $("#enteReportePqr").val(pqr.ente_reporta_pqr);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaMotivosPqr'
                },
                success:function(respuesta){
            
                    $("#motivoPqr").html(respuesta);
                    $("#motivoPqr").val(pqr.motivo_pqr);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaTrabajadorRelaPqr'
                },
                success:function(respuesta){
            
                    $("#trabajadorRelaPqr").html(respuesta);
                    $("#trabajadorRelaPqr").val(pqr.trabajador_relacionado_pqr);
            
                }
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaServiciosAreasPqr'
                },
                success:function(respuesta){
            
                    $("#servcioAreaPqr").html(respuesta);
                    $("#servcioAreaPqr").val(pqr.servicio_area);
            
                }
            
            })

            //INFORMACION SI TIENE ACTA
            if(pqr.id_acta){

                let btnVerActas = document.querySelector('.btnVerActas');

                if(btnVerActas){

                    btnVerActas.style.display = 'block';

                    $.ajax({
            
                        url: 'ajax/pqr/pqr.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'infoBuzonPQR',
                            'idPQR': pqr.id_pqr,
                        },
                        cache: false,
                        dataType: "json",
                        success:function(pqr){
                
                            $("#txtIdPQRSF").text(pqr.id_pqr);
                            $("#txtRadActa").text(pqr.radicado_acta);
                            $("#txtFechaActa").text(pqr.fecha_acta);
                            $("#txtFechaAperturaActa").text(pqr.fecha_apertura_buzon);
                
                            if(pqr.archivosActaPQRSF === 'SIN ARCHIVOS'){
                
                                $("#containerArchivosActasPQRSF").html(`<b>SIN ARCHIVOS</b>`);
                
                            }else{
                
                                let cadena = `<ul class="list-group">`;
                
                                for(const archivo of pqr.archivosActaPQRSF){
                
                                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivos_actas+archivo}" target="_blank">${archivo}</a></li>`;
                                    
                                }
                
                                cadena += `</ul>`;
                
                                $("#containerArchivosActasPQRSF").html(cadena);
                
                            }
                
                        }
                
                    })

                }

            }

        }

    })

}

$(document).ready(async function() {

    //GESTOR
    if (idPQRS){

        // verPQRS(idPQRS);

    }

})
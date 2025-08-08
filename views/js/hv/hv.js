function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


let idHV = atob(getParameterByName('idHV'));
let active = getParameterByName('active');
let tablaListaHV;
let tablaExperienciasLaborales;
let tablaEstudios;

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

const validarArchivosPDF = async (archivo) => {

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

const validarArchivoPDF = async (archivo) => {

    let noValid = false;

    if(archivo.length > 0){

        for (const item of archivo) {
            
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

const changeTipoFormacion = (field) => {

    let containerUniversitario = document.querySelector('#containerFieldsUniversitario');

    if(field.value === 'UNIVERSITARIA'){

        containerUniversitario.style.display = 'block';

    }else{

        containerUniversitario.style.display = 'none';

    }


}

const validarExistePersona = () => {

    let tipoDoc = document.querySelector('#tipoDocumentoDp').value;
    let numDoc = document.querySelector('#numeroDocumentoDp').value;

    if(tipoDoc && numDoc){

        let data = new FormData()
        data.append('proceso', 'validarExistePersona');
        data.append('tipoDoc', tipoDoc);
        data.append('numDoc', numDoc);

        $.ajax({
    
            url: 'ajax/hv/hv.ajax.php',
            type: 'POST',
            data: data,
            cache:false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(resp){

                // console.log(resp);
                
                if(resp){

                    Swal.fire({
                        text: `¡El Documento ya se encuentra registrado para la persona: ${resp.tipo_doc} - ${resp.numero_doc} Nombre: ${resp.nombre_completo}, sera redireccionado para que pueda realizar la gestion!`,
                        icon: 'warning',
                        confirmButtonText: 'Cerrar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: "#d33"
                    }).then((result) =>{

                        if(result.isConfirmed){

                            // window.location = 'index.php?ruta=correspon/micorresponenv';
                            window.location = 'index.php?ruta=hv/registrarhv&idHV='+btoa(resp.id_hv)+'&active=datos-personales';

                        }

                    })

                }
                
            }
    
        })

    }

}


const crearDatosPersonas = async () => {

    let formulario = document.getElementById("formDatosPersonales");
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

            let form = document.querySelector('#formDatosPersonales');

            const formData = new FormData(form);

            let archivosDatosPersonales = document.getElementById("archivosDp");

            formData.append('user', userSession);
            for(let file of archivosDatosPersonales.files){
                formData.append('archivosDatosPersonales[]', file);
            }

            if(formData.get('idHV')){

                formData.append('proceso', 'editarDatosPersonales');

                // for(const [key, value] of formData){
                //     console.log(key, value);
                // }

                let validFiles = await validarArchivosPDF(archivosDatosPersonales);

                if(!validFiles){
    
                    loadingFnc();
        
                    $.ajax({
        
                        url: 'ajax/hv/hv.ajax.php',
                        type: 'POST',
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success:function(resp){
        
                            Swal.close();
        
                            if(resp.response == 'ok'){
    
                                Swal.fire({
                                    text: '¡Los Datos Personas se crearon correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        // window.location = 'index.php?ruta=correspon/micorresponenv';
                                        window.location = 'index.php?ruta=hv/registrarhv&idHV='+btoa(resp.dataHv.id_hv)+'&active=datos-personales';
        
                                    }
        
                                })
        
                            }else{
        
                                Swal.fire({
                                    text: '¡No se guardaron los datos personales correctamente!',
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

                formData.append('proceso', 'crearDatosPersonales');

                //VALIDACION ARCHIVOS
                let validFiles = await validarArchivosPDF(archivosDatosPersonales);
    
                // for(const [key, value] of formData){
                //     console.log(key, value);
                // }
    
                if(!validFiles){
    
                    loadingFnc();
        
                    $.ajax({
        
                        url: 'ajax/hv/hv.ajax.php',
                        type: 'POST',
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success:function(resp){
        
                            Swal.close();
        
                            if(resp.response == 'ok'){
    
                                Swal.fire({
                                    text: '¡Los Datos Personas se crearon correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        // window.location = 'index.php?ruta=correspon/micorresponenv';
                                        window.location = 'index.php?ruta=hv/registrarhv&idHV='+btoa(resp.dataHv.id_hv)+'&active=datos-personales';
        
                                    }
        
                                })
        
                            }else if(resp.response == 'error-existe-persona'){

                                Swal.fire({
                                    text: `¡Los Datos Personales de ${resp.dataHv.tipo_doc} - ${resp.dataHv.numero_doc} - Nombre: ${resp.dataHv.nombre_completo} ya existen!`,
                                    icon: 'warning',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        // window.location = 'index.php?ruta=correspon/micorresponenv';
                                        window.location = 'index.php?ruta=hv/registrarhv&idHV='+btoa(resp.dataHv.id_hv)+'&active=datos-personales';
        
                                    }
        
                                })

                            }else{
        
                                Swal.fire({
                                    text: '¡No se guardaron los datos personales correctamente!',
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
            }




        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const crearEstudio = async () => {

    let formulario = document.getElementById("formEstudios");
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

            let form = document.querySelector('#formEstudios');

            const formData = new FormData(form);

            let archivoEstudio = document.querySelector("#archivosEst").files;
            
            formData.append('proceso', 'crearEstudio');
            formData.append('idHV', idHV);
            formData.append('user', userSession);
            formData.append("archivoEstudio", archivoEstudio[0]);
            
            if(formData.get('tipoFormacionEst') === 'UNIVERSITARIA'){
                let archivoTarjPro = document.querySelector("#archivosTarjetaProEst").files;
                formData.append("archivoTarjPro", archivoTarjPro[0]);
            }


            //VALIDACION ARCHIVOS
            let validFile = await validarArchivoPDF(archivoEstudio);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            if(!validFile){

                loadingFnc();
    
                $.ajax({
    
                    url: 'ajax/hv/hv.ajax.php',
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success:function(resp){
    
                        Swal.close();
    
                        if(resp == 'ok'){

                            Swal.fire({
                                text: '¡El Estudio se guardo correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{
    
                                if(result.isConfirmed){
    
                                    // window.location = 'index.php?ruta=correspon/micorresponenv';
                                    window.location = 'index.php?ruta=hv/registrarhv&idHV='+btoa(idHV)+'&active=estudios';
    
                                }
    
                            })
    
                        }else{
    
                            Swal.fire({
                                text: '¡El Estudio no se guardo correctamente!',
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

const crearExperienciaLaboral = async() => {

    let formulario = document.getElementById("formExpLaborales");
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

            let form = document.querySelector('#formExpLaborales');

            const formData = new FormData(form);

            let archivoExpLaboral = document.querySelector("#archivosEL").files;
            
            formData.append('proceso', 'crearExperienciaLaboral');
            formData.append('idHV', idHV);
            formData.append('user', userSession);
            formData.append("archivoExpLaboral", archivoExpLaboral[0]);
            
            //VALIDACION ARCHIVOS
            let validFile = await validarArchivoPDF(archivoExpLaboral);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            if(!validFile){

                loadingFnc();
    
                $.ajax({
    
                    url: 'ajax/hv/hv.ajax.php',
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success:function(resp){
    
                        Swal.close();
    
                        if(resp == 'ok'){

                            Swal.fire({
                                text: '¡La Experiencia Laboral se guardo correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{
    
                                if(result.isConfirmed){
    
                                    // window.location = 'index.php?ruta=correspon/micorresponenv';
                                    window.location = 'index.php?ruta=hv/registrarhv&idHV='+btoa(idHV)+'&active=experiencias';
    
                                }
    
                            })
    
                        }else{
    
                            Swal.fire({
                                text: '¡La Experiencia Laboral no se guardo correctamente!',
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

const verExperienciaLaboral = (idExpLaboral) => {

    let data = new FormData()
    data.append('proceso', 'verExperienciaLaboral');
    data.append('idExpLaboral', idExpLaboral);

    $.ajax({
    
        url: 'ajax/hv/hv.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(resp){

            // console.log(resp)

            $('#empresaContratanteVer').html(resp.empresa_contratante);
            $('#sectorVer').html(resp.sector);
            $('#cargoDesempenadoVer').html(resp.cargo_desempenado);
            $('#areaTrabajoVer').html(resp.area_trabajo);
            $('#valorContratoSalarioVer').html(resp.valor_contrato_salario);
            $('#fechaInicioLaborVer').html(resp.fecha_inicio_labor);
            $('#fechaFinLaborVer').html(resp.fecha_fin_labor);
            $('#tipoCertificacionVer').html(resp.tipo_certificado);
            $('#usuarioCreaExpLaboralVer').html(resp.usuario_crea);
            $('#fechaCreaExpLaboralVer').html(resp.fecha_crea);

            if(resp.ruta_archivo){

                $('#contenedorArchivoExpLaboralVer').html(`<a href="${resp.ruta_archivo}" target="_blank" class="btn btn-outline-primary btn-sm me-1 mb-1" ><i class="far fa-file-pdf"></i></a>`);
                
            }
            
        }

    })
    
}

const eliminarExperienciaLaboral = (idExpLaboral) => {

    Swal.fire({
        title: "¿Desea Eliminar la Experiencia Laboral?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/hv/hv.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarExperienciaLaboral',
                    'idExpLaboral': idExpLaboral,
                    'userSesion': userSession
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta == 'ok'){

                        Swal.fire({
                            title: '¡La Experiencia Laboral se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tablaExperienciasLaborales.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            title: '¡La Experiencia Laboral no se elimino correctamente!',
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

const eliminarEstudio = (idEstudio) => {

    Swal.fire({
        title: "¿Desea Eliminar el Estudio?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/hv/hv.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarEstudio',
                    'idEstudio': idEstudio,
                    'userSesion': userSession
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta == 'ok'){

                        Swal.fire({
                            title: '¡El Estudio se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tablaEstudios.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            title: '¡El Estudio no se elimino correctamente!',
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

const verEstudio = (idEstudio) => {

    let data = new FormData()
    data.append('proceso', 'verEstudio');
    data.append('idEstudio', idEstudio);

    $.ajax({
    
        url: 'ajax/hv/hv.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(resp){

            // console.log(resp)

            $('#tipoFormarcionVer').html(resp.tipo_formacion);
            $('#tituloOtorgadoVer').html(resp.titulo_otorgado);
            $('#institucionEducativaVer').html(resp.institucion_educativa);
            $('#fechaGradoVer').html(resp.fecha_grado);
            $('#fechaExpTarjetaProfesionalVer').html(resp.fecha_exp_tarjeta_pro);
            $('#fechaTerminacionMateriaVer').html(resp.fecha_terminacion_mate);
            $('#usuarioCreaEstudioVer').html(resp.usuario_crea);
            $('#fechaCreaEstudioVer').html(resp.fecha_crea);

            if(resp.ruta_archivo){

                $('#contenedorArchivoEstudioVer').html(`<a href="${resp.ruta_archivo}" target="_blank" class="btn btn-outline-primary btn-sm me-1 mb-1" ><i class="far fa-file-pdf"></i></a>`);
                
            }
            
            if(resp.ruta_archivo_tarjeta_pro){
                
                $('#contenedorArchivoExpTarjetaProVer').html(`<a href="${resp.ruta_archivo_tarjeta_pro}" target="_blank" class="btn btn-outline-primary btn-sm me-1 mb-1" ><i class="far fa-file-pdf"></i></a>`);


            }else{

                $('#contenedorArchivoExpTarjetaProVer').html('');

            }


        }

    })

}

const gestionarHv = (idHV) => {

    window.location = 'index.php?ruta=hv/registrarhv&idHV='+btoa(idHV)+'&active=datos-personales';

}


const verHv = async (idHV) => {

    let data = new FormData()
    data.append('proceso', 'infoDatosPersonales');
    data.append('idHV', idHV);

    $.ajax({
    
        url: 'ajax/hv/hv.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(resp){

            // console.log(resp);
            $('#tipoDocumentoDpVer').html(resp.tipo_doc);
            $('#numeroDocumentoDpVer').html(resp.numero_doc);
            $('#nombreCompletoDpVer').html(resp.nombre_completo);
            $('#fechaNacimientoDpVer').html(resp.fecha_nacimiento);
            $('#nacionalidadDpVer').html(resp.nacionalidad);
            $('#profesionDpVer').html(resp.profesion);
            $('#correoElectronicoDpVer').html(resp.correo_electronico);
            $('#direccionDpVer').html(resp.direccion);
            $('#celularDpVer').html(resp.celular);
            $('#telefonoDpVer').html(resp.telefono);

            if(resp.archivosDatosPersonales === 'SIN ARCHIVOS'){

                $("#containerArchivosDatosPersonalesVer").html(`<b>SIN ARCHIVOS</b>`);
        
            }else{
        
                let cadena = `<ul class="list-group">`;
        
                for(const archivo of resp.archivosDatosPersonales){
        
                    cadena += `<li class="list-group-item"><a href="${resp.ruta_archivos_datos+archivo}" target="_blank">${archivo}</a></li>`;
                    
                }
        
                cadena += `</ul>`;
        
                $("#containerArchivosDatosPersonalesVer").html(cadena);
        
            }

        }

    })

    await generarCardEstudios(idHV, 'containerEstudios');
    await generarCardExpLaborales(idHV, 'containerExpLaborales');

}

const calculoExperienciaLaboral = async (idHV) => {

    let datos = new FormData();
    datos.append('proceso','calculoExperienciaLaboral');
    datos.append('idHV', idHV);

    const calculo = await $.ajax({
        url: 'ajax/hv/hv.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!calculo){

        console.error("Sin Exp. Laborales"); 
        return;
    }

    return calculo;

}

const generarCardEstudios = async (idHV, container) => {

    let data = new FormData()
    data.append('proceso', 'estudiosHV');
    data.append('idHV', idHV);

    $.ajax({
    
        url: 'ajax/hv/hv.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(resp){

            let cardEstudio = ``;

            resp.forEach((estudio) => {

                // console.log(estudio);

                cardEstudio += `<div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                    <div class="card-header p-3 border-bottom border-300 bg-soft">
                      <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                          <h5 class="text-900 mb-0" data-anchor="data-anchor" id="basic-example">${estudio.titulo_otorgado}<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#basic-example" style="padding-left: 0.375em;"></a></h5>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Tipo Formacion</label>
                                <div>${estudio.tipo_formacion}</div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Titulo Otorgado</label>
                                <div>${estudio.titulo_otorgado}</div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Institucion Educativa</label>
                                <div>${estudio.institucion_educativa}</div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Fecha Grado</label>
                                <div>${estudio.fecha_grado}</div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Archivo Estudio</label>
                                <div><a href="${estudio.ruta_archivo}" target="_blank" class="btn btn-outline-primary btn-sm me-1 mb-1" ><i class="far fa-file-pdf"></i></a></div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Fecha Exp. Tarjeta Profesional</label>
                                <div>${estudio.fecha_exp_tarjeta_pro ? estudio.fecha_exp_tarjeta_pro : ''}</div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Archivo Exp. Tarjeta Profesional</label>
                                <div>${estudio.ruta_archivo_tarjeta_pro ? `<a href="${estudio.ruta_archivo_tarjeta_pro}" target="_blank" class="btn btn-outline-primary btn-sm me-1 mb-1" ><i class="far fa-file-pdf"></i></a>` : ``}</div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Fecha Terminacion Materia</label>
                                <div>${estudio.fecha_terminacion_mate ? estudio.fecha_terminacion_mate : ''}</div>
                            </div>
                        </div>
                    </div>
                </div>`;

            })

            $(`#${container}`).html(cardEstudio);

        }

    })

}

const generarCardExpLaborales = async (idHV, container) => {

    let data = new FormData()
    data.append('proceso', 'experienciasLaboralesHV');
    data.append('idHV', idHV);

    $.ajax({
    
        url: 'ajax/hv/hv.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: async function(resp){

            let cardExpLaboral = ``;

            let calculoExpLaboral = await calculoExperienciaLaboral(idHV);

            if(calculoExpLaboral){

                $('#containerTiempoExpLaboral').html(`<center><div class="fw-bold text-primary">${calculoExpLaboral.dias ? `Meses: ${calculoExpLaboral.meses} - Años: ${calculoExpLaboral.anios}` : ''}</div></center>`)

            }else{

                $('#containerTiempoExpLaboral').html('');

            }
            

            resp.forEach((expLaboral) => {

                // console.log(expLaboral);

                cardExpLaboral += `<div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                    <div class="card-header p-3 border-bottom border-300 bg-soft">
                      <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                          <h5 class="text-900 mb-0" data-anchor="data-anchor" id="basic-example">${expLaboral.cargo_desempenado}<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#basic-example" style="padding-left: 0.375em;"></a></h5>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                        
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Empresa Contratante</label>
                                <div>${expLaboral.empresa_contratante}</div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Sector</label>
                                <div>${expLaboral.sector}</div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Cargo Desempeñado</label>
                                <div>${expLaboral.cargo_desempenado}</div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Area Trabajo</label>
                                <div>${expLaboral.area_trabajo}</div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Valor Contrato o Salario</label>
                                <div>${expLaboral.valor_contrato_salario}</div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <label class="fw-bold">Fecha Inicio Labor</label>
                                        <div>${expLaboral.fecha_inicio_labor}</div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label class="fw-bold">Fecha Fin Labor</label>
                                        <div>${expLaboral.fecha_fin_labor}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Tipo Certificacion</label>
                                <div>${expLaboral.tipo_certificado}</div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="fw-bold">Archivo Exp. Laboral</label>
                                <div><a href="${expLaboral.ruta_archivo}" target="_blank" class="btn btn-outline-primary btn-sm me-1 mb-1" ><i class="far fa-file-pdf"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>`;

            })

            $(`#${container}`).html(cardExpLaboral);

        }

    })

}

const consultarHv = () => {

    const cardResultado = document.querySelector("#cardResultadoConsultarHv");

    let formulario = document.getElementById("formConsultarHv");
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

            cardResultado.style.display = 'block';

            let form = document.querySelector('#formConsultarHv');
            const formData = new FormData(form);
            formData.append('proceso', 'consultarHv');

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            let tablaResultadoConsultarHv = $('#tablaResultadoConsultarHv').DataTable({

                columns: [
                    { name: '#', data: 'id_hv' },
                    { name: 'NOMBRE', data: 'nombre_completo' },
                    { name: 'NUMERO DOCUMENTO', render: function(data, type, row){
                        return `${row.tipo_doc} - ${row.numero_doc}`;
                    }},
                    { name: 'CORREO', data: 'correo_electronico' },
                    { name: 'CELULAR', data: 'celular' },
                    { name: 'PROFESION', data: 'profesion' },
                    { name: 'ACCIONES', render: function(data, type, row){
                        return `
                            <button class="btn btn-outline-primary btn-sm me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modalVerHV" onclick="verHv(${row.id_hv})" title="Ver HV"><i class="far fa-eye"></i></button>
                            <button class="btn btn-outline-success btn-sm me-1 mb-1" onclick="gestionarHv(${row.id_hv})" title="Gestionar HV"><i class="far fa-arrow-alt-circle-right"></i></button>
                        `;
                    }},
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
                    url: 'ajax/hv/hv.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'consultarHv',
                        'numDocumentoBuscar': formData.get('numDocumentoBuscar'),
                        'tipoFormacionBuscar': formData.get('tipoFormacionBuscar'),
                        'profesionBuscar': formData.get('profesionBuscar'),
                        'palabraClaveBuscar': formData.get('palabraClaveBuscar')
                    },
                }
            
            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }

    }

}

tablaExperienciasLaborales = $('#tablaExperienciasLaborales').DataTable({

    columns: [
        { name: '#', data: 'id_exp_laboral' },
        { name: 'EMPRESA CONTRATANTE', data: 'empresa_contratante' },
        { name: 'SECTOR', data: 'sector' },
        { name: 'CARGO', data: 'cargo_desempenado' },
        { name: 'ARCHIVO', render: function(data, type, row){

            return `<a href="${row.ruta_archivo}" target="_blank" class="btn btn-outline-primary btn-sm me-1 mb-1" ><i class="far fa-file-pdf"></i></a>`;

        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <span class="badge badge-phoenix badge-phoenix-primary p-2" data-bs-toggle="modal" data-bs-target="#modalVerExpLaboral" onclick="verExperienciaLaboral('${row.id_exp_laboral}')" title="Ver Exp. Laboral"><i class="far fa-eye"></i></span>
                    <span class="badge badge-phoenix badge-phoenix-danger p-2" onclick="eliminarExperienciaLaboral('${row.id_exp_laboral}')" title="Eliminar Exp. Laboral"><i class="far fa-trash-alt"></i></span>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/hv/hv.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaExperienciasLaborales',
            'idHV': idHV
        }
    }

})


tablaEstudios = $('#tablaEstudios').DataTable({

    columns: [
        { name: '#', data: 'id_estudio' },
        { name: 'TIPO FORMACION', data: 'tipo_formacion' },
        { name: 'TITULO', data: 'titulo_otorgado' },
        { name: 'INSTITUCION EDUCATIVA', data: 'institucion_educativa' },
        { name: 'ARCHIVO', render: function(data, type, row){

            return `<a href="${row.ruta_archivo}" target="_blank" class="btn btn-outline-primary btn-sm me-1 mb-1" ><i class="far fa-file-pdf"></i></a>`;

        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <span class="badge badge-phoenix badge-phoenix-primary p-2" data-bs-toggle="modal" data-bs-target="#modalVerEstudio" onclick="verEstudio('${row.id_estudio}')" title="Ver Estudio"><i class="far fa-eye"></i></span>
                    <span class="badge badge-phoenix badge-phoenix-danger p-2" onclick="eliminarEstudio('${row.id_estudio}')" title="Eliminar Estudio"><i class="far fa-trash-alt"></i></span>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/hv/hv.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEstudios',
            'idHV': idHV
        }
    }

})

tablaListaHV = $('#tablaListaHV').DataTable({

    columns: [
        { name: '#', data: 'id_hv' },
        { name: 'NOMBRE', data: 'nombre_completo' },
        { name: 'NUMERO DOCUMENTO', render: function(data, type, row){
            return `${row.tipo_doc} - ${row.numero_doc}`;
        }},
        { name: 'FECHA NACIMIENTO', data: 'fecha_nacimiento' },
        { name: 'NACIONALIDAD', data: 'nacionalidad' },
        { name: 'PROFESION', data: 'profesion' },
        { name: 'CORREO ELECTRONICO', data: 'correo_electronico' },
        { name: 'DIRECCION', data: 'direccion' },
        { name: 'CELULAR', data: 'celular' },
        { name: 'TELEFONO', data: 'telefono' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modalVerHV" onclick="verHv(${row.id_hv})" title="Ver HV"><i class="far fa-eye"></i></button>
                    <button class="btn btn-outline-success btn-sm me-1 mb-1" onclick="gestionarHv(${row.id_hv})" title="Gestionar HV"><i class="far fa-arrow-alt-circle-right"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/hv/hv.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaHV',
        }
    }

})

if(idHV && active){

    let data = new FormData()
    data.append('proceso', 'infoDatosPersonales');
    data.append('idHV', idHV);

    $.ajax({
    
        url: 'ajax/hv/hv.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(resp){

            // console.log(resp);
            $('#idHV').val(resp.id_hv);
            $('#tipoDocumentoDp').val(resp.tipo_doc);
            let tipoDoc = document.querySelector('#tipoDocumentoDp');
            tipoDoc.setAttribute('disabled', true);
            $('#numeroDocumentoDp').val(resp.numero_doc);
            let numDoc = document.querySelector('#numeroDocumentoDp');
            numDoc.setAttribute('disabled', true);
            numDoc.classList.add('readonly');
            $('#nombreCompletoDp').val(resp.nombre_completo);
            $('#fechaNacimientoDp').val(resp.fecha_nacimiento);
            $('#nacionalidadDp').val(resp.nacionalidad);
            $('#profesionDp').val(resp.profesion);
            $('#correoElectronicoDp').val(resp.correo_electronico);
            $('#direccionDp').val(resp.direccion);
            $('#celularDp').val(resp.celular);
            $('#telefonoDp').val(resp.telefono);

            if(resp.archivosDatosPersonales === 'SIN ARCHIVOS'){

                $("#containerArchivosDatosPersonales").html(`<b>SIN ARCHIVOS</b>`);
        
            }else{
        
                let cadena = `<ul class="list-group">`;
        
                for(const archivo of resp.archivosDatosPersonales){
        
                    cadena += `<li class="list-group-item"><a href="${resp.ruta_archivos_datos+archivo}" target="_blank">${archivo}</a></li>`;
                    
                }
        
                cadena += `</ul>`;
        
                $("#containerArchivosDatosPersonales").html(cadena);
        
            }

        }

    })

}
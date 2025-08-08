function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


let idEquipoBiomedico = atob(getParameterByName('idEquipoBio'));
let active = getParameterByName('active');
let tableEquipoBiomedicoManual;
let tableEquipoBiomedicoPlanos;
let tableEquipoBiomedicoRecomendaciones;
let tableEquipoBiomedicoComponentesAccesorios;
let tablaEquiposBiomedicos;
let tablaEquiposBiomedicosReserva;
let tableEstadosGarantiasBiomedicos;
let tableListaMantenimentosBiomedicos;
let tableListaSolicitudesTrasladoEquipoBio;
let tableListaSolicitudesMantenimientosEquipoBio;
let tableListaSolicitudesActaBajaEquipoBio;
let tablaListaTiposMantenimientos;
let tableEstadosMantenimientosBiomedicosMto;
let tableEstadosMantenimientosBiomedicosClbr;
let tableEstadosMantenimientosBiomedicosVld;
let tableEstadosMantenimientosBiomedicosCl;

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaSedesDg'
    },
}).done(function (sedes) {
    $("#sEBSede").html(sedes)
})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaTipoMantenimientos'
    },
}).done(function (tiposMantenimientos) {
    $("#tMTipoMantenimientoEquipo").html(tiposMantenimientos)
})


const changeFechaGarantia = (field) => {

    if(field.id === 'hEFechaFinGarantia'){

        let fechaIniGarantia = document.getElementById('hEFechaIniGarantia').value;

        if(field.value < fechaIniGarantia){
            $('#hEFechaIniGarantia').val('');
        }

        $('#hEFechaIniGarantia').attr('max', field.value);
        
    }else{

        let fechaFinGarantia = document.getElementById('hEFechaFinGarantia').value;
        
        if(field.value > fechaFinGarantia){
            $('#hEFechaFinGarantia').val('');
        }

        $('#hEFechaFinGarantia').attr('min', field.value);

    }

}

const guardarDatosEquipoBiomedico = () => {

    let formulario = document.getElementById("formDatosEquipoBio");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formDatosEquipoBio');

            const data = new FormData(form);

            // console.log(archivo[0]);
            data.append("user", userSession);
            
            if(data.get('idEquipoBiomedico')){

                let tiposMantenimientoData = document.querySelector(`#tipoMantenimiento`);
                let respTiposMantenimiento = '';

                if(tiposMantenimientoData){

                    let valoresSeleccionados = [];
                    let cadena = '';

                    for (var i = 0; i < tiposMantenimientoData.options.length; i++) {
                        if (tiposMantenimientoData.options[i].selected) {
                            valoresSeleccionados.push(tiposMantenimientoData.options[i].value);
                            cadena += tiposMantenimientoData.options[i].value + '|'; 
                        }
                    }

                    if(valoresSeleccionados.length <= 0){
                        Swal.fire({
                            text: 'Debe seleccionar alguna opcion en el campo Tipo Mantenimientos.',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })
                        return;
                    }

                    respTiposMantenimiento = cadena.slice(0, -1);

                }

                data.append("proceso", "editarDatosEquipoBiomedico");
                data.append("tipoMantenimientos", respTiposMantenimiento);
                
                // for(const [key, value] of data){
                //     console.log(key, value);
                // }

                $.ajax({
    
                    url: 'ajax/inventario/inventario-biomedico.ajax.php',
                    type: 'POST',
                    data: data,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){
                    
                        if(respuesta === 'ok'){
    
                            Swal.fire({
                                text: '¡Los Datos del Equipo Biomedico se guardaron correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{
    
                                if(result.isConfirmed){
    
                                    window.location = 'index.php?ruta=inventario/registrarequipobiomedico&idEquipoBio='+btoa(data.get('idEquipoBiomedico'))+'&active=datos-equipo';
    
                                }
    
                            })
    
                        }else{
    
                            Swal.fire({
    
                                text: '¡Los Datos del Equipo Biomedico no se guardaron correctamente!',
                                icon: 'error',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33",
    
                            })
    
                        }
    
                    }
    
                })
                
            }else{

                let tiposMantenimientoData = document.querySelector(`#tipoMantenimiento`);
                let respTiposMantenimiento = '';

                if(tiposMantenimientoData){

                    let valoresSeleccionados = [];
                    let cadena = '';

                    for (var i = 0; i < tiposMantenimientoData.options.length; i++) {
                        if (tiposMantenimientoData.options[i].selected) {
                            valoresSeleccionados.push(tiposMantenimientoData.options[i].value);
                            cadena += tiposMantenimientoData.options[i].value + '|'; 
                        }
                    }

                    if(valoresSeleccionados.length <= 0){
                        Swal.fire({
                            text: 'Debe seleccionar alguna opcion en el campo Tipo Mantenimientos.',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })
                        return;
                    }

                    respTiposMantenimiento = cadena.slice(0, -1);

                }

                data.append("proceso", "guardarDatosEquipoBiomedico");
                data.append("tipoMantenimientos", respTiposMantenimiento);
                

                // for(const [key, value] of data){
                //     console.log(key, value);
                // }
    
                $.ajax({
    
                    url: 'ajax/inventario/inventario-biomedico.ajax.php',
                    type: 'POST',
                    data: data,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success:function(respuesta){
                    
                        if(respuesta.response === 'ok'){
    
                            Swal.fire({
                                text: '¡Los Datos del Equipo Biomedico se guardaron correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{
    
                                if(result.isConfirmed){
    
                                    window.location = 'index.php?ruta=inventario/registrarequipobiomedico&idEquipoBio='+btoa(respuesta.data.id)+'&active=datos-equipo';
    
                                }
    
                            })
    
                        }else{
    
                            Swal.fire({
    
                                text: '¡Los Datos del Equipo Biomedico no se guardaron correctamente!',
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




        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }
}

const obtenerTiposMantenimientoBiomedico = async (idEquipoBio) => {

    let datos = new FormData();
    datos.append('proceso','obtenerTiposMantenimientosBiomedicos');
    datos.append('idEquipoBiomedico', idEquipoBio);

    const tiposMantenimientos = await $.ajax({
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!tiposMantenimientos){

        console.error("Tipos Mantenimientos Vacios"); 
        return;
    }

    return tiposMantenimientos;

}

const obtenerValidacionTipoMantenimiento = async (idEquipoBio, tipoMantenimiento) => {

    let datos = new FormData();
    datos.append('proceso','validacionTipoMantenimiento');
    datos.append('idEquipoBiomedico', idEquipoBio);
    datos.append('tipoMantenimiento', tipoMantenimiento);

    const infoMantenimiento = await $.ajax({
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    // if(!infoMantenimiento){

    //     console.error("Info Mantenimiento Vacio"); 
    //     return;
    // }

    return infoMantenimiento;


}

const mostrarAlertasTipoMantenimientos = async (idEquipoBio, divElement) => {

    //OBTENER TIPOS MANTENIMIENTO EQUIPO BIOMEDICO
    let tiposMantenimientos = await obtenerTiposMantenimientoBiomedico(idEquipoBio);

    // const info = await obtenerValidacionTipoMantenimiento(idEquipoBio, 'MTTO');

    // console.log(info);

    await Promise.all(tiposMantenimientos.map(async (tipo) => {

        const { tipo_mantenimiento, ...dataTipoMantenimiento } = tipo;
        const info = await obtenerValidacionTipoMantenimiento(idEquipoBio, tipo_mantenimiento);
        // console.log(info);

        if (info) {

            let bgAlert = info.estado_mantenimiento === 'VENCIDO' ? 'danger' : 'warning';

            let fecha = info.fecha_mantenimiento ? info.fecha_mantenimiento : info.instalacion;

            divElement.innerHTML += `
            <div class="alert alert-soft-${bgAlert}" role="alert">
                <h5 class="alert-heading fw-semi-bold mb-2">
                ¡Alerta Mantenimiento Tipo: <b>${info.tipo_mantenimiento} - ${info.estado_mantenimiento}</b>!
                </h5>
                <p>El Mantenimiento ${info.tipo_mantenimiento} - ${info.frecuencia} venció, fecha último mantenimiento es: <b>${fecha}</b>.</p>
            </div>
            `;

        }

    }));

}

const mostrarInfoEquipoBiomedico = async (idEquipoBiomedico) => {

    let data = new FormData()
    data.append('proceso', 'infoDatosEquipoBiomedico');
    data.append('idEquipoBiomedico', idEquipoBiomedico);
    
    $.ajax({
    
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:async function(resp){

            // console.log(resp);

            let containerAlertas = document.querySelector('#containerAlertas');

            if(resp.estado_garantia == 'VENCIDA'){

                containerAlertas.innerHTML += `
                    <div class="alert alert-soft-danger" role="alert">
                        <h5 class="alert-heading fw-semi-bold mb-2">¡Alerta Garantia!</h5>
                        <p>La Garantia del Equipo Biomedico Vencio el dia: <b>${resp.fecha_fin_garantia}</b>.</p>
                    </div>
                `;

            }else if(resp.estado_garantia == 'A VENCER'){

                containerAlertas.innerHTML += `
                    <div class="alert alert-soft-warning" role="alert">
                        <h5 class="alert-heading fw-semi-bold mb-2">¡Alerta Garantia!</h5>
                        <p>La Garantia del Equipo Biomedico va a vencer el dia <b>${resp.fecha_fin_garantia}</b>.</p>
                    </div>    
                `;

            }

            await mostrarAlertasTipoMantenimientos(idEquipoBiomedico, containerAlertas);

            //VALIDACION ESTADO MANTENIMIENTO

            // let dataValidacion = new FormData();
            // dataValidacion.append('proceso', 'validacionMantenimientoEquipoBiomedico');
            // dataValidacion.append('idEquipoBiomedico', idEquipoBiomedico);

            // $.ajax({
    
            //     url: 'ajax/inventario/inventario-biomedico.ajax.php',
            //     type: 'POST',
            //     data: dataValidacion,
            //     cache:false,
            //     contentType: false,
            //     processData: false,
            //     dataType: "json",
            //     success:function(resp){

            //         if(resp){

            //             // console.log(resp);
            //             if(resp.estado_mantenimiento.includes('VENCIDO')){

                            
            //                 containerAlertas.innerHTML += `
            //                     <div class="col-sm-12 col-md-4">
            //                         <div class="alert alert-soft-danger" role="alert">
            //                             <h4 class="alert-heading fw-semi-bold mb-2">¡Alerta Mantenimiento!</h4>
            //                             <p>El Mantenimiento ${resp.frecuencia_mantenimiento} del Equipo Biomedico Vencio.</p>
            //                         </div>
            //                     </div>    
            //                 `;

            //             }

            //             if(resp.estado_mantenimiento.includes('VENCER')){

            //                 containerAlertas.innerHTML += `
            //                     <div class="col-sm-12 col-md-4">
            //                         <div class="alert alert-soft-warning" role="alert">
            //                             <h4 class="alert-heading fw-semi-bold mb-2">¡Alerta Mantenimiento!</h4>
            //                             <p>El Mantenimiento ${resp.frecuencia_mantenimiento} del Equipo Biomedico esta proximo a vencer.</p>
            //                         </div>
            //                     </div>    
            //                 `;

            //             }

            //         }

            //     }

            // })
    
            $('#idEquipoBiomedico').val(resp.id);
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaTipoEquipoDg'
                },
            }).done(function (tipoEquipos) {
                $("#dGTipoEquipo").html(tipoEquipos);
                $("#dGTipoEquipo").val(resp.tipo_equipo);
            })
            $('#dGNombreEquipo').val(resp.nombre_equipo);
            $('#dGMarca').val(resp.marca);
            $('#dGModelo').val(resp.modelo);
            $('#dGSerie').val(resp.serie);
            $('#dGActivoFijo').val(resp.activo_fijo);
            $('#dGRegistroSaniInvima').val(resp.registro_sanitario_invima);
            $('#dGUbicacion').val(resp.ubicacion);
            $('#dTTensionTrabajo').val(resp.tension_trabajo);
            $('#dTConsumoWatt').val(resp.consumo_watt);
            $('#dTPeso').val(resp.peso);
            $('#dtCondicionesAmbien').val(resp.condiciones_ambientales);
            $('#frecuenciaMantenimiento').val(resp.frecuencia_mantenimiento);
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaSedesDg'
                },
            }).done(function (sedes) {
                $("#dGSede").html(sedes)
                $("#dGSede").val(resp.sede)
            })
            

            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaServiciosDg'
                },
            }).done(function (lista) {
                $("#dGServicio").html(lista)
                $("#dGServicio").val(resp.servicio)
            })
            
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaClasificiacionBiomedicaDg'
                },
            }).done(function (lista) {
                $("#dGClasificacionBio").html(lista)
                $("#dGClasificacionBio").val(resp.clasificacion_biomedica)
            })
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaClasificiacionRiesgoDg'
                },
            }).done(function (lista) {
                $("#dGClasificacionRiesgo").html(lista)
                $("#dGClasificacionRiesgo").val(resp.clasificacion_riesgo)
            })
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaTecnologiaPredoDt'
                },
            }).done(function (lista) {
                $("#dTTecnologiaPredo").html(lista)
                $("#dTTecnologiaPredo").val(resp.tecnologia_predominante)
            })
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaFuenteAlimentacionDt'
                },
            }).done(function (lista) {
                $("#dTFuenteAlimen").html(lista)
                $("#dTFuenteAlimen").val(resp.fuente_alimentacion)
            })
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaCaracteristicasInstaDt'
                },
            }).done(function (lista) {
                $("#dTCaracteristicasInsta").html(lista)
                $("#dTCaracteristicasInsta").val(resp.caracteristica_instalacion)
            })

            $.ajax({
                type: 'POST',
                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                data: {
                    'proceso': 'listaTipoMantenimientosEquipoBiomedico',
                    'idEquipoBiomedico': idEquipoBiomedico
                },
            }).done(function(lista){
                $("#tMTipoMantenimiento").html(lista)
            })


            // console.log(resp);
            // $('#tipoDocumentoDp').val(resp.tipo_doc);
            // let tipoDoc = document.querySelector('#tipoDocumentoDp');
            // tipoDoc.setAttribute('disabled', true);
            // $('#numeroDocumentoDp').val(resp.numero_doc);
            // let numDoc = document.querySelector('#numeroDocumentoDp');
            // numDoc.setAttribute('disabled', true);
            // numDoc.classList.add('readonly');
            // $('#nombreCompletoDp').val(resp.nombre_completo);
            // $('#fechaNacimientoDp').val(resp.fecha_nacimiento);
            // $('#nacionalidadDp').val(resp.nacionalidad);
            // $('#profesionDp').val(resp.profesion);
            // $('#correoElectronicoDp').val(resp.correo_electronico);
            // $('#direccionDp').val(resp.direccion);
            // $('#celularDp').val(resp.celular);
            // $('#telefonoDp').val(resp.telefono);
    
            // if(resp.archivosDatosPersonales === 'SIN ARCHIVOS'){
    
            //     $("#containerArchivosDatosPersonales").html(`<b>SIN ARCHIVOS</b>`);
        
            // }else{
        
            //     let cadena = `<ul class="list-group">`;
        
            //     for(const archivo of resp.archivosDatosPersonales){
        
            //         cadena += `<li class="list-group-item"><a href="${resp.ruta_archivos_datos+archivo}" target="_blank">${archivo}</a></li>`;
                    
            //     }
        
            //     cadena += `</ul>`;
        
            //     $("#containerArchivosDatosPersonales").html(cadena);
        
            // }
    
        }
    
    })

}

const mostrarInfoEquipoBiomedicoHistorico = async (idEquipoBiomedico) => {

    let data = new FormData()
    data.append('proceso', 'infoDatosEquipoBiomedicoHistorico');
    data.append('idEquipoBiomedico', idEquipoBiomedico);
    
    $.ajax({
    
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:async function(resp){

            //CALCULAMOS LA DEPRECIACION ANUAL
            let aniosInstalacion = await calcularDepreciacionAnual(resp);
            let valorDepreciacionAnual = resp.valor_depreciacion * aniosInstalacion;

            $("#hENumeroFactura").val(resp.numero_factura);
            $("#hEFormaAdqui").val(resp.forma_adquisicion);
            $("#hEVidaUtilEquipo").val(resp.vida_util);
            $("#hEValorIvaIncluido").val(resp.valor_iva);
            $("#hEValorDepreciacion").val(resp.valor_depreciacion);
            $("#hECompra").val(resp.compra);
            $("#hEInstalacion").val(resp.instalacion);
            $("#hERecibido").val(resp.recibido);
            $("#hEFechaIniGarantia").val(resp.fecha_inicio_garantia);
            $("#hEFechaFinGarantia").val(resp.fecha_fin_garantia);
            $("#hEGarantiaAnios").val(resp.garantia_anios);
            $("#hEFabricante").val(resp.fabricante);
            $("#hENombreContacto").val(resp.nombre_contacto);
            $("#hERepresentante").val(resp.representante);
            $("#hETelefono").val(resp.telefono);
            $("#hECorreoElectronico").val(resp.correo_electronico);
            $("#hECargoPuesto").val(resp.cargo_puesto);
            $("#hEProveedor").val(resp.proveedor);
            $("#hECelular").val(resp.celular);
            $("#hEValorDepreciacionAnual").val(valorDepreciacionAnual);

        }
    
    })

}

const calcularDepreciacionAnual = async (historico) => {

    // console.log(historico);

    let fechaInstalacion = new Date(historico.instalacion + 'T12:00:00');
    let fechaActual = new Date();

    // console.log(fechaInstalacion);

    let aniosInstalacion = fechaActual.getFullYear() - fechaInstalacion.getFullYear();

    const mesActual = fechaActual.getMonth() + 1;
    const mesInicio = fechaInstalacion.getMonth() + 1;
    const diaActual = fechaActual.getDate();
    const diaInicio = fechaInstalacion.getDate();

    // console.log(mesActual, mesInicio, diaActual, diaInicio);

    if (mesActual < mesInicio || (mesActual === mesInicio && diaActual < diaInicio)) {
        aniosInstalacion--;
    }

    return aniosInstalacion;

}

const crearManualBiomedico = () => {

    let formulario = document.getElementById("formManualBiomedico");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formManualBiomedico');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "crearManualBiomedico");
            data.append("idEquipoBiomedico", idEquipoBiomedico);
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡El Manual del Equipo Biomedico se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tableEquipoBiomedicoManual.ajax.reload();
                                $('#mTipoManual').val('').trigger('change');
                                form.reset();

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡El Manual del Equipo Biomedico no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}


const crearPlanoBiomedico = () => {

    let formulario = document.getElementById("formPlanoBiomedico");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formPlanoBiomedico');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "crearPlanoBiomedico");
            data.append("idEquipoBiomedico", idEquipoBiomedico);
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡El Plano del Equipo Biomedico se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tableEquipoBiomedicoPlanos.ajax.reload();
                                $('#pTipoPlano').val('').trigger('change');
                                form.reset();

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡El Plano del Equipo Biomedico no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }
    
}


const crearRecomendacionBiomedico = () => {

    let formulario = document.getElementById("formRecomendacionFabri");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formRecomendacionFabri');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "crearRecomendacionBiomedico");
            data.append("idEquipoBiomedico", idEquipoBiomedico);
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡La Recomendacion del Equipo Biomedico se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tableEquipoBiomedicoRecomendaciones.ajax.reload();
                                form.reset();

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡La Recomendacion del Equipo Biomedico no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}


const crearComponenteCaracteristica = () => {

    let formulario = document.getElementById("formComponenAccesorios");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formComponenAccesorios');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "crearComponenteCaracteristica");
            data.append("idEquipoBiomedico", idEquipoBiomedico);
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡El Componente o Accesorio del Equipo Biomedico se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tableEquipoBiomedicoComponentesAccesorios.ajax.reload();
                                form.reset();

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡El Componente o Accesorio del Equipo Biomedico no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}


const guardarHistoricoEquipo = () => {

    let formulario = document.getElementById("formHistoricoEquipo");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formHistoricoEquipo');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "guardarHistoricoEquipoBiomedico");
            data.append("idEquipoBiomedico", idEquipoBiomedico);
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡El Historico del Equipo Biomedico se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=inventario/registrarequipobiomedico&idEquipoBio='+btoa(idEquipoBiomedico)+'&active=historico-equipo';

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡El Historico del Equipo Biomedico no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const eliminarManualBiomedico = (idManual) => {

    Swal.fire({
        title: "¿Desea Eliminar el Manual?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarManualBiomedico',
                    'idManual': idManual,
                    'userSesion': userSession
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta == 'ok'){

                        Swal.fire({
                            title: '¡El Manual se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tableEquipoBiomedicoManual.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            title: '¡El Manual no se elimino correctamente!',
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

const eliminarPlanoBiomedico = (idPlano) => {

    Swal.fire({
        title: "¿Desea Eliminar el Plano?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarPlanoBiomedico',
                    'idPlano': idPlano,
                    'userSesion': userSession
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta == 'ok'){

                        Swal.fire({
                            title: '¡El Plano se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tableEquipoBiomedicoPlanos.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            title: '¡El Plano no se elimino correctamente!',
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

const eliminarRecomendacionBiomedico = (idRecomendacion) => {

    Swal.fire({
        title: "¿Desea Eliminar la Recomendacion?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarRecomendacionBiomedico',
                    'idRecomendacion': idRecomendacion,
                    'userSesion': userSession
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta == 'ok'){

                        Swal.fire({
                            title: '¡La Recomendacion se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tableEquipoBiomedicoRecomendaciones.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            title: '¡La Recomendacion no se elimino correctamente!',
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

const eliminarComponenteAccesorioBiomedico = (idCompoAcceso) => {

    Swal.fire({
        title: "¿Desea Eliminar el Componente o Accesorio?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarComponenteAccesorioBiomedico',
                    'idCompoAcceso': idCompoAcceso,
                    'userSesion': userSession
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta == 'ok'){

                        Swal.fire({
                            title: '¡El Componente o Accesorio se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tableEquipoBiomedicoComponentesAccesorios.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            title: '¡El Componente o Accesorio no se elimino correctamente!',
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

const gestionarEquipoBiomedico = (idEquipoBiomedico) => {

    window.open(`index.php?ruta=inventario/registrarequipobiomedico&idEquipoBio=${btoa(idEquipoBiomedico)}&active=datos-equipo`);

}

const verComponenteAccesorioBiomedico = (idCompoAcceso) => {

    let data = new FormData()
    data.append('proceso', 'infoComponenteAccesorio');
    data.append('idCompoAccesorio', idCompoAcceso);
    
    $.ajax({
    
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(resp){

            $("#txtComponenteAccesorio").html(resp.componente_caracteristica);
            $("#txtCantidadCompoAcceso").html(resp.cantidad);

        }
    
    })

}


const verRecomendacionBiomedico = (idRecomendacion) => {

    let data = new FormData()
    data.append('proceso', 'infoRecomendacionFabricante');
    data.append('idRecomendacion', idRecomendacion);
    
    $.ajax({
    
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(resp){

            $("#txtRecomendacionFabricante").html(resp.recomendacion);

        }
    
    })

}

const agregarTipoMantenimiento = () => {

    let formulario = document.getElementById("formTipoManteEquipoBio");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formTipoManteEquipoBio');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "agregarTipoMantenimientoBiomedico");
            data.append("idEquipoBiomedico", idEquipoBiomedico);
            data.append("user", userSession);

            for(const [key, value] of data){
                console.log(key, value);
            }

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡El Tipo Mantenimiento Biomedico se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                // tableListaMantenimentosBiomedicos.ajax.reload();
                                window.location = 'index.php?ruta=inventario/registrarequipobiomedico&idEquipoBio='+btoa(data.get('idEquipoBiomedico'))+'&active=datos-equipo';
                                form.reset();

                            }

                        })

                    }else if(respuesta == 'error-existe'){
                        
                        Swal.fire({

                            text: '¡El Tipo Mantenimiento ya se encuentra registrado!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }else{

                        Swal.fire({

                            text: '¡El Tipo Mantenimiento Biomedico no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}


const agregarMantenimiento = () => {

    let formulario = document.getElementById("formManteEquipoBio");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formManteEquipoBio');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "agregarMantenimientoBiomedico");
            data.append("idEquipoBiomedico", idEquipoBiomedico);
            data.append("user", userSession);

            for(const [key, value] of data){
                console.log(key, value);
            }

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡El Mantenimiento Biomedico se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                // tableListaMantenimentosBiomedicos.ajax.reload();
                                window.location = 'index.php?ruta=inventario/registrarequipobiomedico&idEquipoBio='+btoa(data.get('idEquipoBiomedico'))+'&active=datos-equipo';
                                form.reset();

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡El Mantenimiento Biomedico no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const agregarSolicitudTrasladoEquipoBio = () => {

    let formulario = document.getElementById("formSolicitudTrasladoEquipoBiomedico");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formSolicitudTrasladoEquipoBiomedico');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "agregarSolicitudTrasladoEquipoBiomedico");
            data.append("idEquipoBiomedico", idEquipoBiomedico);
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡La Solicitud de Traslado se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                // tableListaSolicitudesTrasladoEquipoBio.ajax.reload();
                                // form.reset();
                                window.location = 'index.php?ruta=inventario/registrarequipobiomedico&idEquipoBio='+btoa(idEquipoBiomedico)+'&active=datos-equipo';

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡La Solicitud de Traslado no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const agregarSolicitudMantenimientoCorrectivoEquipoBio = () => {

    let formulario = document.getElementById("formSolicitudMantenimientoEquipoBiomedico");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formSolicitudMantenimientoEquipoBiomedico');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "agregarSolicitudMantenimientoCorrectivoEquipoBio");
            data.append("idEquipoBiomedico", idEquipoBiomedico);
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡La Solicitud de Mantenimiento Correctivo se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tableListaSolicitudesMantenimientosEquipoBio.ajax.reload();
                                form.reset();

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡La Solicitud de Mantenimiento Correctivo no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const redirectGestionarMantenimientoCorrectivo = (idSoliMante, idEquipoBio) => {

    // window.location = 'index.php?ruta=inventario/gestionarmantenimientocorrec&idEquipoBio='+btoa(idEquipoBio)+'&idSoliMantenimiento=${idSoliMante}';
    window.location = `index.php?ruta=inventario/gestionarmantenimientocorrec&idEquipoBio=${btoa(idEquipoBio)}&idSoliMantenimiento=${btoa(idSoliMante)}&categoriaActivo=${btoa('EQUIPOBIOMEDICO')}`;

}

const agregarSolicitudBajaEquipoBio = () => {

    let formulario = document.getElementById("formSolicitudBajaEquipoBiomedico");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formSolicitudBajaEquipoBiomedico');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "agregarSolicitudBajaEquipoBio");
            data.append("idEquipoBiomedico", idEquipoBiomedico);
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡La Solicitud de Baja de Equipo se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tableListaSolicitudesActaBajaEquipoBio.ajax.reload();
                                form.reset();

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡La Solicitud de Baja de Equipo no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}


const obtenerInfoSolicitudMantenimiento = async (idSoliMantenimiento, categoriaActivo) => {

    let data = new FormData()
    data.append('proceso', 'infoSolicitudMantenimiento');
    data.append('idSoliMantenimiento', idSoliMantenimiento);
    data.append('categoriaActivo', categoriaActivo);

    const respuesta = await $.ajax({
        url: 'ajax/inventario/mantenimiento.ajax.php',
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!respuesta){

        console.error("Sin Informacion"); 
        return;
    }

    // console.log(segmentos);

    return respuesta;

}

const obtenerInfoMantenimiento = async (idSoliMantenimiento) => {

    let data = new FormData()
    data.append('proceso', 'infoMantenimiento');
    data.append('campo', 'id_solicitud_mante');
    data.append('idSoliMantenimiento', idSoliMantenimiento);

    const respuesta = await $.ajax({
        url: 'ajax/inventario/mantenimiento.ajax.php',
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!respuesta){

        console.error("Sin Informacion"); 
        return;
    }

    // console.log(segmentos);

    return respuesta;

}

const verInfoMantenimientoCorrectivo = async (idSoliMantenimiento, categoriaActivo) => {

    let infoSolicitud = await obtenerInfoSolicitudMantenimiento(idSoliMantenimiento, categoriaActivo);

    if(infoSolicitud){

        $('#txtSoliOrdenNo').html(infoSolicitud.orden_no);
        $('#txtSoliCargo').html(infoSolicitud.cargo);
        $('#txtSoliDescripcionIncidencia').html(infoSolicitud.descripcion_incidencia);
        $('#txtSoliFechaEjecucion').html(infoSolicitud.fecha_ejecucion);
        $('#txtSoliResponsable').html(infoSolicitud.responsable);
        $('#txtSoliRequiereRespuesto').html(infoSolicitud.requiere_repuesto);
        $('#txtSoliDescripcionFalla').html(infoSolicitud.descripcion_falla);
        $('#txtSoliRespuestosNecesarios').html(infoSolicitud.repuestos_necesarios);
        
    }
    
    let infoMantenimiento = await obtenerInfoMantenimiento(idSoliMantenimiento);

    // console.log(infoMantenimiento);

    if(infoMantenimiento){

        let cadenaPreventivos = '';
        let cadenaCorrectivos = '';

        let arrayPreventivos = infoMantenimiento.mantenimientos_preventivos.split('|');
        let arrayCorrectivos = infoMantenimiento.mantenimientos_correctivos.split('|');

        arrayCorrectivos.forEach(item => {

            cadenaCorrectivos += `<span class="badge badge-phoenix badge-phoenix-success m-1">${item}</span><br>`;

        })

        arrayPreventivos.forEach(item => {

            cadenaPreventivos += `<span class="badge badge-phoenix badge-phoenix-warning m-1">${item}</span><br>`;

        })

        $('#contenedorCheckPreventivos').html(cadenaPreventivos);
        $('#contenedorCheckCorrectivos').html(cadenaCorrectivos);
        
        $('#txtVerObservacionMantenimiento').html(infoMantenimiento.observaciones_mantenimiento);

    }

}

const eliminarMantenimientoBiomedico = (idManteBiomedico) => {

    Swal.fire({
        title: "¿Desea Eliminar el Mantenimiento?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarMantenimientoBiomedico',
                    'idManteniBiomedico': idManteBiomedico,
                    'userSesion': userSession
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta == 'ok'){

                        Swal.fire({
                            title: '¡El Mantenimiento se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=inventario/registrarequipobiomedico&idEquipoBio='+btoa(idEquipoBiomedico)+'&active=datos-equipo';

                            }

                        })

                    }else{

                        Swal.fire({
                            title: '¡El Mantenimiento no se elimino correctamente!',
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

const eliminarTipoMantenimiento = (idTipoMantenimiento) => {

    Swal.fire({
        title: "¿Desea Eliminar el Tipo Mantenimiento?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/inventario/inventario-biomedico.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarTipoMantenimientoBiomedico',
                    'idTipoMantenimiento': idTipoMantenimiento,
                    'userSesion': userSession
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta == 'ok'){

                        Swal.fire({
                            title: '¡El Tipo Mantenimiento se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=inventario/registrarequipobiomedico&idEquipoBio='+btoa(idEquipoBiomedico)+'&active=datos-equipo';

                            }

                        })

                    }else{

                        Swal.fire({
                            title: '¡El Tipo Mantenimiento no se elimino correctamente!',
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

tableEquipoBiomedicoManual = $('#tableEquipoBiomedicoManual').DataTable({

    columns: [
        { name: '#', data: 'id_manual' },
        { name: 'TIPO MANUAL', data: 'tipo_manual' },
        { name: 'MANUAL', data: 'nombre_manual' },
        { name: 'MANUAL PDF', render: function(data, type, row) {
            return `<a target="_blank" class="btn btn-primary btn-sm" href="${row.ruta_archivo}" title="Eliminar Manual"><i class="far fa-file"></i></a>`;
        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-danger btn-sm" onclick="eliminarManualBiomedico(${row.id_manual})" title="Eliminar Manual"><i class="fas fa-trash-alt"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEquipoBiomedicoManuales',
            'idEquipoBiomedico': idEquipoBiomedico
        }
    }

})

tableEquipoBiomedicoPlanos = $('#tableEquipoBiomedicoPlanos').DataTable({

    columns: [
        { name: '#', data: 'id_plano' },
        { name: 'TIPO PLANO', data: 'tipo_plano' },
        { name: 'NOMBRE PLANO', data: 'nombre_plano' },
        { name: 'PLANO PDF', render: function(data, type, row) {
            return `<a target="_blank" class="btn btn-primary btn-sm" href="${row.ruta_archivo}" title="Eliminar Plano"><i class="far fa-file"></i></a>`;
        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-danger btn-sm" onclick="eliminarPlanoBiomedico(${row.id_plano})" title="Eliminar Plano"><i class="fas fa-trash-alt"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEquipoBiomedicoPlanos',
            'idEquipoBiomedico': idEquipoBiomedico
        }
    }

})


tableEquipoBiomedicoRecomendaciones = $('#tableEquipoBiomedicoRecomendaciones').DataTable({

    columns: [
        { name: '#', data: 'id_recomendacion' },
        { name: 'RECOMENDACION', data: 'recomendacion', render: function(data, type, row){
            return `${row.recomendacion.substring(0 , 50) + '...'}`;
        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerRecomendacion" onclick="verRecomendacionBiomedico(${row.id_recomendacion})" title="Ver Recomendacion"><i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarRecomendacionBiomedico(${row.id_recomendacion})" title="Eliminar Recomendacion"><i class="fas fa-trash-alt"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEquipoBiomedicoRecomendaciones',
            'idEquipoBiomedico': idEquipoBiomedico
        }
    }

})

tableEquipoBiomedicoComponentesAccesorios = $('#tableEquipoBiomedicoComponentesAccesorios').DataTable({

    columns: [
        { name: '#', data: 'id_compo_caract' },
        { name: 'COMPONENTE Y/O ACCESORIO', render: function(data, type, row){
            return `${row.componente_caracteristica.substring(0, 50) + '...'}`;
        }},
        { name: 'CANTIDAD', data: 'cantidad' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerComponenteAccesorioBiomedico" onclick="verComponenteAccesorioBiomedico(${row.id_compo_caract})" title="Ver Componente y/o Accesorio"><i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarComponenteAccesorioBiomedico(${row.id_compo_caract})" title="Eliminar Componente y/o Accesorio"><i class="fas fa-trash-alt"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEquipoBiomedicoComponentesCaracteristicas',
            'idEquipoBiomedico': idEquipoBiomedico
        }
    }

})


tablaEquiposBiomedicos = $('#tablaEquiposBiomedicos').DataTable({

    columns: [
        { name: '#', data: 'id' },
        { name: 'TIPO EQUIPO', data: 'tipo_equipo' },
        { name: 'NOMBRE EQUIPO', data: 'nombre_equipo' },
        { name: 'MARCA', data: 'marca' },
        { name: 'MODELO', data: 'modelo' },
        { name: 'SERIE', data: 'serie' },
        { name: 'ACTIVO FIJO', data: 'activo_fijo' },
        { name: 'SEDE', data: 'sede' },
        { name: 'UBICACION', data: 'ubicacion' },
        { name: 'SERVICIO', data: 'servicio' },
        { name: 'CLASIFICACION BIOMEDICA', data: 'clasificacion_biomedica' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-outline-success btn-sm" onclick="gestionarEquipoBiomedico(${row.id})" title="Gestionar Equipo Biomedico"><i class="far fa-arrow-alt-circle-right"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEquiposBiomedicos',
        }
    }

})

tablaEquiposBiomedicosReserva = $('#tablaEquiposBiomedicosReserva').DataTable({

    columns: [
        { name: '#', data: 'id' },
        { name: 'TIPO EQUIPO', data: 'tipo_equipo' },
        { name: 'NOMBRE EQUIPO', data: 'nombre_equipo' },
        { name: 'MARCA', data: 'marca' },
        { name: 'MODELO', data: 'modelo' },
        { name: 'SERIE', data: 'serie' },
        { name: 'ACTIVO FIJO', data: 'activo_fijo' },
        { name: 'SEDE', data: 'sede' },
        { name: 'UBICACION', data: 'ubicacion' },
        { name: 'SERVICIO', data: 'servicio' },
        { name: 'CLASIFICACION BIOMEDICA', data: 'clasificacion_biomedica' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-outline-success btn-sm" onclick="gestionarEquipoBiomedico(${row.id})" title="Gestionar Equipo Biomedico"><i class="far fa-arrow-alt-circle-right"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEquiposBiomedicosReserva',
        }
    }

})


tableEstadosGarantiasBiomedicos = $('#tableEstadosGarantiasBiomedicos').DataTable({

    columns: [
        { name: 'ESTADO', data: 'estado_garantia', render:function(data, type, row){

            if(row.estado_garantia === 'VENCIDA'){
                return `<span class="badge badge-phoenix badge-phoenix-danger p-2">${row.estado_garantia}</span>`;
            }else{
                return `<span class="badge badge-phoenix badge-phoenix-warning p-2">${row.estado_garantia}</span>`;
            }

        }},
        { name: 'EQUIPO', data: 'nombre_equipo' },
        { name: 'SEDE', data: 'sede' },
        { name: 'SERVICIO', data: 'servicio' },
        { name: 'FECHA FIN GARANTIA', data: 'fecha_fin_garantia' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-outline-success btn-sm" onclick="gestionarEquipoBiomedico(${row.id})" title="Gestionar Equipo Biomedico"><i class="far fa-arrow-alt-circle-right"></i></button>`;
            }
        }
    ],
    order: [
        [0, 'desc']
    ],
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEstadosGarantiaBiomedicos',
        }
    }

})


tableListaMantenimentosBiomedicos = $('#tableListaMantenimentosBiomedicos').DataTable({

    columns: [
        { name: '#', data: 'id_mantenimiento_biomedico' },
        { name: 'TIPO MANTENIMIENTO', render: function(data, type, row){

            return `${row.tipo_mantenimiento} - ${row.nombre}`;

        }},
        { name: 'FECHA MANTENIMIENTO', data: 'fecha_mantenimiento' },
        { name: 'ARCHIVO', render: function(data, type, row){
            if(row.ruta_archivo){
                return `<a class="btn btn-outline-danger btn-sm" title="Ver Archivo Manteninimiento" target="_blank" href="${row.ruta_archivo}"><i class="far fa-file-pdf"></i></a>`;
            }else{
                return ``;
            }
        }},
        { name: 'OBSERVACIONES MANTENIMIENTO', data: 'observaciones_mantenimiento' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarMantenimientoBiomedico(${row.id_mantenimiento_biomedico})" title="Eliminar Mantenimiento"><i class="far fa-trash-alt"></i></button>`;
            }
        }
    ],
    order: [
        [2, 'desc']
    ],
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaMantenimientosEquiposBiomedicos',
            'idEquipoBiomedico': idEquipoBiomedico
        }
    }

})

tablaListaTiposMantenimientos = $('#tablaListaTiposMantenimientos').DataTable({

    columns: [
        { name: '#', data: 'id_tipo_mante_bio' },
        { name: 'TIPO MANTENIMIENTO', data: 'tipo_mantenimiento'},
        { name: 'FRECUENCIA MANTENIMIENTO', data: 'frecuencia' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarTipoMantenimiento(${row.id_tipo_mante_bio})" title="Eliminar Tipo Mantenimiento"><i class="far fa-trash-alt"></i></button>`;
            }
        }
    ],
    order: [
        [0, 'desc']
    ],
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEquipoBiomedicoTiposMantenimientos',
            'idEquipoBiomedico': idEquipoBiomedico
        }
    }

})


tableListaSolicitudesTrasladoEquipoBio = $('#tableListaSolicitudesTrasladoEquipoBio').DataTable({

    columns: [
        { name: '#', data: 'id_soli_traslado_bio' },
        { name: 'TIEMPO ESTIMADO SALIDA', data: 'tiempo_estimado_salida'},
        { name: 'SEDE', data: 'sede_new' },
        { name: 'ACTIVO FIJO', data: 'activo_fijo_new' },
        { name: 'UBICACION', data: 'ubicacion_new' },
        { name: 'RECIBIDO POR', data: 'recibido_por' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <a type="button" target="_blank" class="btn btn-outline-success btn-sm" href="plugins/TCPDF/examples/inventario/solicitud_traslado_biomedico.php?idSoliTrasladoBiomedico=${btoa(row.id_soli_traslado_bio)}" title="Generar PDF"><i class="fas fa-file-pdf"></i></a>
                `;
            }
        }
    ],
    order: [
        [0, 'desc']
    ],
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaSolicitudesTrasladoEquipoBio',
            'idEquipoBiomedico': idEquipoBiomedico
        }
    }

})

tableListaSolicitudesMantenimientosEquipoBio = $('#tableListaSolicitudesMantenimientosEquipoBio').DataTable({

    columns: [
        { name: '#', data: 'id_soli_mante_bio' },
        { name: 'ORDEN NO', data: 'orden_no'},
        { name: 'CARGO', data: 'cargo' },
        { name: 'FECHA EJECUCION', data: 'fecha_ejecucion' },
        { name: 'RESPONSABLE', data: 'responsable' },
        { name: 'ESTADO', render: function(data, type, row){
            if(row.estado === 'PENDIENTE'){
                return `<span class="badge badge-phoenix badge-phoenix-warning">${row.estado}</span>`;
            }else{
                return `<span class="badge badge-phoenix badge-phoenix-success">${row.estado}</span>`;
            }
        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                if(row.estado == 'PENDIENTE'){
                    return `
                        <a type="button" target="_blank" class="btn btn-outline-success btn-sm m-1" href="plugins/TCPDF/examples/inventario/solicitud_mantenimiento_biomedico.php?idSoliMantenimientoBiomedico=${btoa(row.id_soli_mante_bio)}" title="Generar PDF"><i class="fas fa-file-pdf"></i></a>
                        <a class="btn btn-outline-primary btn-sm" title="Realizar Mantenimiento" onclick="redirectGestionarMantenimientoCorrectivo(${row.id_soli_mante_bio},${idEquipoBiomedico})"><i class="fas fa-hammer"></i></a>
                    `;
                    
                }else{
                    
                    return `
                        <a type="button" target="_blank" class="btn btn-outline-success btn-sm m-1" href="plugins/TCPDF/examples/inventario/solicitud_mantenimiento_biomedico.php?idSoliMantenimientoBiomedico=${btoa(row.id_soli_mante_bio)}" title="Generar PDF"><i class="fas fa-file-pdf"></i></a>
                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="verInfoMantenimientoCorrectivo(${row.id_soli_mante_bio},'EQUIPOBIOMEDICO')" data-bs-toggle="modal" data-bs-target="#modalVerMantenimientoCorrectivo"  title="Ver Mantenimiento"><i class="fas fa-eye"></i></button>
                    `;

                }

            }
        }
    ],
    order: [
        [0, 'desc']
    ],
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaSolicitudesMantenimientosEquipoBio',
            'idEquipoBiomedico': idEquipoBiomedico
        }
    }

})

tableListaSolicitudesActaBajaEquipoBio = $('#tableListaSolicitudesActaBajaEquipoBio').DataTable({

    columns: [
        { name: '#', data: 'id_soli_baja_bio' },
        { name: 'NOMBRE SOLICITANTE', data: 'nombre_solicitante'},
        { name: 'CARGO', data: 'cargo' },
        { name: 'RECICLAJE', data: 'reciclaje' },
        { name: 'EMPRESA R. RECICLAJE', data: 'empresa_responsable_reci' },
        { name: 'DISPOSICION', data: 'disposicion' },
        { name: 'EMPRESA R. DISPOSICION', data: 'empresa_responsable_dispo' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <a type="button" target="_blank" class="btn btn-outline-success btn-sm m-1" href="plugins/TCPDF/examples/inventario/solicitud_baja_biomedico.php?idSoliBajaBiomedico=${btoa(row.id_soli_baja_bio)}" title="Generar PDF"><i class="fas fa-file-pdf"></i></a>
                `;
                    
            }
        }
    ],
    order: [
        [0, 'desc']
    ],
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaSolicitudesActaBajaEquipoBio',
            'idEquipoBiomedico': idEquipoBiomedico
        }
    }

})

tableEstadosMantenimientosBiomedicosMto = $('#tableEstadosMantenimientosBiomedicosMto').DataTable({

    columns: [
        { name: 'ESTADO', data: 'estado_mantenimiento', render:function(data, type, row){

            if(row.estado_mantenimiento === 'VENCIDO'){
                return `<span class="badge badge-phoenix badge-phoenix-danger p-2">${row.estado_mantenimiento}</span>`;
            }else if(row.estado_mantenimiento === 'A VENCER'){
                return `<span class="badge badge-phoenix badge-phoenix-warning p-2">${row.estado_mantenimiento}</span>`;
            }

        }},
        { name: 'EQUIPO', data: 'nombre_equipo' },
        { name: 'SEDE', data: 'sede' },
        { name: 'SERVICIO', data: 'servicio' },
        { name: 'FRECUENCIA MANTENIMIENTO', data: 'frecuencia' },
        { name: 'FECHA ULTIMO MANTENIMIENTO', render: function(data, type, row){
            if(row.fecha_mantenimiento){
                return row.fecha_mantenimiento;
            }else{
                return row.instalacion;
            }
        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-outline-success btn-sm" onclick="gestionarEquipoBiomedico(${row.id})" title="Gestionar Equipo Biomedico"><i class="far fa-arrow-alt-circle-right"></i></button>`;
            }
        }
    ],
    order: [
        [0, 'desc']
    ],
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEstadosMantenimientosBiomedicosMto',
        }
    }

})

tableEstadosMantenimientosBiomedicosClbr = $('#tableEstadosMantenimientosBiomedicosClbr').DataTable({

    columns: [
        { name: 'ESTADO', data: 'estado_mantenimiento', render:function(data, type, row){

            if(row.estado_mantenimiento === 'VENCIDO'){
                return `<span class="badge badge-phoenix badge-phoenix-danger p-2">${row.estado_mantenimiento}</span>`;
            }else if(row.estado_mantenimiento === 'A VENCER'){
                return `<span class="badge badge-phoenix badge-phoenix-warning p-2">${row.estado_mantenimiento}</span>`;
            }

        }},
        { name: 'EQUIPO', data: 'nombre_equipo' },
        { name: 'SEDE', data: 'sede' },
        { name: 'SERVICIO', data: 'servicio' },
        { name: 'FRECUENCIA MANTENIMIENTO', data: 'frecuencia' },
        { name: 'FECHA ULTIMO MANTENIMIENTO', render: function(data, type, row){
            if(row.fecha_mantenimiento){
                return row.fecha_mantenimiento;
            }else{
                return row.instalacion;
            }
        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-outline-success btn-sm" onclick="gestionarEquipoBiomedico(${row.id})" title="Gestionar Equipo Biomedico"><i class="far fa-arrow-alt-circle-right"></i></button>`;
            }
        }
    ],
    order: [
        [0, 'desc']
    ],
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEstadosMantenimientosBiomedicosClbr',
        }
    }

})

tableEstadosMantenimientosBiomedicosVld = $('#tableEstadosMantenimientosBiomedicosVld').DataTable({

    columns: [
        { name: 'ESTADO', data: 'estado_mantenimiento', render:function(data, type, row){

            if(row.estado_mantenimiento === 'VENCIDO'){
                return `<span class="badge badge-phoenix badge-phoenix-danger p-2">${row.estado_mantenimiento}</span>`;
            }else if(row.estado_mantenimiento === 'A VENCER'){
                return `<span class="badge badge-phoenix badge-phoenix-warning p-2">${row.estado_mantenimiento}</span>`;
            }

        }},
        { name: 'EQUIPO', data: 'nombre_equipo' },
        { name: 'SEDE', data: 'sede' },
        { name: 'SERVICIO', data: 'servicio' },
        { name: 'FRECUENCIA MANTENIMIENTO', data: 'frecuencia' },
        { name: 'FECHA ULTIMO MANTENIMIENTO', render: function(data, type, row){
            if(row.fecha_mantenimiento){
                return row.fecha_mantenimiento;
            }else{
                return row.instalacion;
            }
        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-outline-success btn-sm" onclick="gestionarEquipoBiomedico(${row.id})" title="Gestionar Equipo Biomedico"><i class="far fa-arrow-alt-circle-right"></i></button>`;
            }
        }
    ],
    order: [
        [0, 'desc']
    ],
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEstadosMantenimientosBiomedicosVld',
        }
    }

})

tableEstadosMantenimientosBiomedicosCl = $('#tableEstadosMantenimientosBiomedicosCl').DataTable({

    columns: [
        { name: 'ESTADO', data: 'estado_mantenimiento', render:function(data, type, row){

            if(row.estado_mantenimiento === 'VENCIDO'){
                return `<span class="badge badge-phoenix badge-phoenix-danger p-2">${row.estado_mantenimiento}</span>`;
            }else if(row.estado_mantenimiento === 'A VENCER'){
                return `<span class="badge badge-phoenix badge-phoenix-warning p-2">${row.estado_mantenimiento}</span>`;
            }

        }},
        { name: 'EQUIPO', data: 'nombre_equipo' },
        { name: 'SEDE', data: 'sede' },
        { name: 'SERVICIO', data: 'servicio' },
        { name: 'FRECUENCIA MANTENIMIENTO', data: 'frecuencia' },
        { name: 'FECHA ULTIMO MANTENIMIENTO', render: function(data, type, row){
            if(row.fecha_mantenimiento){
                return row.fecha_mantenimiento;
            }else{
                return row.instalacion;
            }
        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-outline-success btn-sm" onclick="gestionarEquipoBiomedico(${row.id})" title="Gestionar Equipo Biomedico"><i class="far fa-arrow-alt-circle-right"></i></button>`;
            }
        }
    ],
    order: [
        [0, 'desc']
    ],
    ajax: {
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEstadosMantenimientosBiomedicosCl',
        }
    }

})

$('#tablaEquiposBiomedicos thead tr').clone(true).appendTo('#tablaEquiposBiomedicos thead');

$('#tablaEquiposBiomedicos thead tr:eq(1) th').each( function (i) {

    var title = $(this).text();
    $(this).html( '<input type="text" class="form-control" placeholder="Buscar..." />' );

    $( 'input', this ).on( 'keyup change', function () {

        if(tablaEquiposBiomedicos.column(i).search() !== this.value){

            tablaEquiposBiomedicos
                .column(i)
                .search( this.value )
                .draw();

        }

    })

})

$('#tablaEquiposBiomedicosReserva thead tr').clone(true).appendTo('#tablaEquiposBiomedicosReserva thead');

$('#tablaEquiposBiomedicosReserva thead tr:eq(1) th').each( function (i) {

    var title = $(this).text();
    $(this).html( '<input type="text" class="form-control" placeholder="Buscar..." />' );

    $( 'input', this ).on( 'keyup change', function () {

        if(tablaEquiposBiomedicosReserva.column(i).search() !== this.value){

            tablaEquiposBiomedicosReserva
                .column(i)
                .search( this.value )
                .draw();

        }

    })

})

$(document).ready(async function() {

    if (idEquipoBiomedico && active) {

        await mostrarInfoEquipoBiomedico(idEquipoBiomedico);
        await mostrarInfoEquipoBiomedicoHistorico(idEquipoBiomedico);


    }

});
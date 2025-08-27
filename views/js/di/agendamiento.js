/*==============================
VARIABLES DE RUTA
==============================*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let idAgendamiento = atob(getParameterByName('idAgendamiento'));
let idCitaReAgendar = atob(getParameterByName('idCitaReAgendar'));
let pacienteExist = getParameterByName('pacienteExist');
let idPaciente = atob(getParameterByName('idPaciente'));
let tablaBasesAgendamientoPacientes;
let tablaBolsaPendienteUser;
let tablaComunicacionesFallidas;
let tablaPrioridadBolsaAgendamiento;
let tablaProfesionalAgendamiento;
let tablaBusquedaAgendamiento;
let url = new URL(window.location.href);
let rutaValor = url.searchParams.get("ruta");

/*============================
LISTA USUARIOS AGENDAMIENTO
============================*/
$.ajax({

    type: "POST",
    url: "ajax/di/agendamiento.ajax.php",
    data: {
        'proceso': 'listaUsuariosAgendamiento'
    },
    success:function(respuesta){

        $("#usuarioAgendamiento").html(respuesta);

    }

})


/*============================
LISTA COHORTE O PROGRAMAS AGENDAMIENTO
============================*/
$.ajax({

    type: "POST",
    url: "ajax/di/agendamiento.ajax.php",
    data: {
        'proceso': 'listaCohorteProgramas'
    },
    success:function(respuesta){

        $("#cohorteProgramaPrioridad").html(respuesta);

    }

})


/*============================
LISTA COHORTE O PROGRAMAS AGENDAMIENTO
============================*/
$.ajax({

    type: "POST",
    url: "ajax/di/agendamiento.ajax.php",
    data: {
        'proceso': 'listaCohorteProgramas'
    },
    success:function(respuesta){

        $("#cohorteProgramaAgendamiento").html(respuesta);
        $("#cohortePrograma").html(respuesta);

    }

})


$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaLocalidades'
    },
    success:function(respuesta){

        $("#localidadCita").html(respuesta);

    }

})

/*=============================
EDICION DE PACIENTE ACTUALIZACION DEP-MUN SISBEN
=============================*/
$("#editDepartamentoSisbenPaciente").change(function(){

    let departamento = $(this).val();

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaMunicipiosDepartamento',
            'departamento': departamento
        },
        success:function(respuesta){

            $("#editMunicipioSisbenPaciente").html(respuesta);

        }

    })

})

/*=============================
EDICION DE PACIENTE ACTUALIZACION DEP-MUN UBICACION
=============================*/
$("#editDepartamentoUbicacionPaciente").change(function(){

    let departamento = $(this).val();

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaMunicipiosDepartamento',
            'departamento': departamento
        },
        success:function(respuesta){

            $("#editMunicipioUbicacionPaciente").html(respuesta);

        }

    })

})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaTipoDocumento'
    },
}).done(function (tipoDocPaciente) {
    $("#tipoDocumentoSearch").html(tipoDocPaciente)
    // $("#tipoDocumentoSearch").val(respuesta["tipo_doc"]);
})


$.ajax({
    type: 'POST',
    url: 'ajax/di/agendamiento.ajax.php',
    data: {
        'proceso': 'listaUsuariosAgendamiento'
    },
}).done(function (usuariosAgendamiento) {
    $("#usuarioAgendador").html(usuariosAgendamiento)
})


$("#fechaNacimientoPaciente").change(function(){

    let fechaNacimiento = $(this).val();
    let fechaActual = $(this).attr("fechaActual");
    let resultado = CalcularEdad(fechaNacimiento, fechaActual);

    let edadN = resultado.EdadN;
    let edadT = resultado.EdadT;

    $("#edadNPaciente").val(edadN);
    $("#edadTPaciente").val(edadT);


})

$("#editFechaNacimientoPaciente").change(function(){

    let fechaNacimiento = $(this).val();
    let fechaActual = $(this).attr("fechaActual");
    let resultado = CalcularEdad(fechaNacimiento, fechaActual);

    let edadN = resultado.EdadN;
    let edadT = resultado.EdadT;

    $("#editEdadNPaciente").val(edadN);
    $("#editEdadTPaciente").val(edadT);


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

const CalcularEdad = (fechaNacimiento, fechaActual) => {

    let fecha1 = moment(fechaNacimiento);
	let fecha2 = moment(fechaActual);
	let dias = fecha2.diff(fecha1, 'days');
	let meses = fecha2.diff(fecha1, 'month');
	let anos= fecha2.diff(fecha1, 'years');
	//console.log('Dias '+dias+' Meses '+meses+' Años '+anos);

	let edadN = 0;
	
	if(anos === 0){

		if(meses === 0){

			edadN = dias;

		}else{

			edadN = meses;

		}
	}else{

		edadN=anos;

	}

	let edadT='N/A';

	if(anos===0){
		if(meses===0){
			edadT='DIAS';
		}else{
			edadT='MESES';
		}
	}else{
		edadT='AÑOS';
	}

	//console.log( 'Edad Numerica-->'+edadN +' Unidad de edad-->'+ edadT + ' Grupo Etario-->'+grupoEtario); 

	return {
		EdadN: edadN,
		EdadT: edadT
	};

}

const cargarAgendamientoPaciente = () =>{

    let formulario = document.getElementById("formCargarArchivoAgendamiento");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let nombreArchivo = document.getElementById("nombreArchivoAgendamiento").value;
            let archivo = document.querySelector("#archivoAgendamiento").files;

            // console.log(archivo[0]);

            let data = new FormData();
            data.append("proceso", "cargarArchivoAgendamiento");
            data.append("nombreArchivo", nombreArchivo);
            data.append("archivoAgendamiento", archivo[0]);
            data.append("user", userSession);

            loadingFnc();

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    Swal.close();
                
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

                                window.location = 'index.php?ruta=di/cargarbaseagendamiento';

                            }

                        })

                    }else if(respuesta === 'error-estructura'){
                        
                        Swal.fire({

                            text: '¡La Base no cuenta con la estructura adecuada, 21 Columnas (U)!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/cargarbaseagendamiento';

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

                                window.location = 'index.php?ruta=di/cargarbaseagendamiento';

                            }

                        })

                    }

                }

            })



        }

    }

}

const tomarAgendamiento = (idBolsaPaciente) => {

    Swal.fire({
        title: "¿Desea Gestionar el Agendamiento?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Gestionar Agendamiento!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'tomarAgendamiento',
                    'idBolsaPaciente': idBolsaPaciente,
                    'asesor': userSession
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta.estado == 'ok-asignado-paciente'){

                        Swal.fire({
                            text: '¡El Agendamiento se asigno correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Gestionar Agendamiento',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#3085d6"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/gestionaragendamiento&idAgendamiento='+btoa(idBolsaPaciente)+'&idPaciente='+btoa(respuesta.idPaciente);

                            }

                        })

                    
                    }else if(respuesta.estado == 'ok-asignado'){

                        Swal.fire({
                            text: '¡El Agendamiento se asigno correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Gestionar Agendamiento',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#3085d6"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/gestionaragendamiento&idAgendamiento='+btoa(idBolsaPaciente);

                            }

                        })

                    }else if(respuesta.estado == 'error-asignando'){

                        Swal.fire({
                            text: '¡El Agendamiento no se asigno correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/bolsaagendamiento';

                            }

                        })


                    }else if(respuesta.estado == 'ok-ya-asignado'){
                        
                        Swal.fire({
                            text: '¡El Agendamiento ya esta asignado a otro Asesor!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/bolsaagendamiento';

                            }

                        })
                        
                    }else if(respuesta.estado == 'error-capacidad-superada'){

                        Swal.fire({
                            title: 'Error!',
                            text: '¡El Agendamiento no se asigno debido a que supero los pendientes permitidos!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })
                    
                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: 'La Gestion call no se asigno correctamente',
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

const infoPacienteBolsaAgendamiento = async (idBolsaPaciente) => {

    let datos = new FormData();
    datos.append('proceso','infoPacienteBolsaAgendamiento');
    datos.append('idBolsaPacienteAgendamiento', idBolsaPaciente);

    const infoPaciente = await $.ajax({
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    return infoPaciente;

}

const gestionarAgendamiento = async (idBolsaPaciente, idPaciente) => {

    const infoPaciente = await infoPacienteBolsaAgendamiento(idBolsaPaciente);

    if(infoPaciente.estado === 'paciente-existe'){

        window.location = 'index.php?ruta=di/gestionaragendamiento&idAgendamiento='+btoa(idBolsaPaciente)+'&idPaciente='+btoa(infoPaciente.paciente.id_paciente);
        
    }else{

        window.location = 'index.php?ruta=di/gestionaragendamiento&idAgendamiento='+btoa(idBolsaPaciente);

    }

    // if(typeof idPaciente !== 'undefined' && idPaciente !== null){

    //     window.location = 'index.php?ruta=di/gestionaragendamiento&idAgendamiento='+btoa(idBolsaPaciente)+'&idPaciente='+btoa(idPaciente);

    // }else{

    //     window.location = 'index.php?ruta=di/gestionaragendamiento&idAgendamiento='+btoa(idBolsaPaciente);
        
    // }

}

const registrarComunicacionFallida = () => {

    let idBolsaPaciente = document.getElementById("idBolsaPaciente").value;
    let causalFallida = document.getElementById("causalFallida").value;
    let observacionFallida = document.getElementById("observacionesFallida").value;
    let cantidadGestiones = document.getElementById("cantidadGestionesComuFallida").value;

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

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'crearComunicacionFallida',
                    'idBolsaPaciente':idBolsaPaciente,
                    'causalFallida':causalFallida,
                    'observacionFallida':observacionFallida,
                    'cantidadGestiones':cantidadGestiones,
                    'usuarioCrea': userSession
                },
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta === 'ok-cierre-agendamiento'){

                        Swal.fire({

                            text: 'El Agendamiento fue terminado debido a que no se pudo establecer comunicación con el Paciente',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/pendientesagendamiento';

                            }

                        })

                    }else if(respuesta === 'ok-cierre-call-causal'){

                        Swal.fire({

                            text: `El Agendamiento fue terminado debido a que: ${causalFallida}.`,
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/pendientesagendamiento';

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

                                window.location = 'index.php?ruta=di/pendientesagendamiento';

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

const mostrarMapaUbicacion = (direccionUbicacion, departamentoUbicacion, municipioUbicacion, lat, lng) => {

    if (direccionUbicacion !== '' && departamentoUbicacion !== null && municipioUbicacion !== null && municipioUbicacion !== '') {
        let vMarker;
        let map;

        map = new google.maps.Map(document.getElementById('mapaUbicacion'), {
            zoom: 15,
            center: new google.maps.LatLng(0, 0),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        let geocoder = new google.maps.Geocoder();

        let dirCompleUbicacion = `${direccionUbicacion} ${departamentoUbicacion} ${municipioUbicacion}`;

        let latlng  = {
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        }


        if(!isNaN(latlng.lat) && !isNaN(latlng.lng)){
            
            console.log('Ingreso LATLNG')

            geocoder.geocode({
                "location": latlng
            }, function (results, status) {
                console.log(results);
                if (status === google.maps.GeocoderStatus.OK) {
                    const location = results[0].geometry.location;

                    map.setCenter(location); // Centra el mapa en la ubicación obtenida

                    vMarker = new google.maps.Marker({
                        animation: google.maps.Animation.DROP,
                        position: location,
                        draggable: true,
                        map: map
                    });

                    google.maps.event.addListener(vMarker, 'dragend', function (evt) {
                        const latLng = evt.latLng;
                        $("#latitudUbicacion").val(latLng.lat().toFixed(6));
                        $("#longitudUbicacion").val(latLng.lng().toFixed(6));
                        map.panTo(latLng);
                    });

                    $("#latitudUbicacion").val(location.lat());
                    $("#longitudUbicacion").val(location.lng());
                }
            });

        }else{

            console.log('Ingreso Direccion')

            geocoder.geocode({
                "address": dirCompleUbicacion
            }, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    const location = results[0].geometry.location;

                    map.setCenter(location); // Centra el mapa en la ubicación obtenida

                    vMarker = new google.maps.Marker({
                        animation: google.maps.Animation.DROP,
                        position: location,
                        draggable: true,
                        map: map
                    });

                    google.maps.event.addListener(vMarker, 'dragend', function (evt) {
                        const latLng = evt.latLng;
                        $("#latitudUbicacion").val(latLng.lat().toFixed(6));
                        $("#longitudUbicacion").val(latLng.lng().toFixed(6));
                        map.panTo(latLng);
                    });

                    $("#latitudUbicacion").val(location.lat());
                    $("#longitudUbicacion").val(location.lng());
                }
            });

        }

    } else {
        if (!direccionUbicacion) {
            toastr.warning("Debe digitar la Dirección de Ubicación", "Error");
        }

        if (!departamentoUbicacion) {
            toastr.warning("Debe seleccionar el Departamento de Ubicación", "Error");
        }

        if (!municipioUbicacion) {
            toastr.warning("Debe seleccionar el Municipio de Ubicación", "Error");
        }
    }
}

function recargarMapaPaciente(){

    let direccionUbicacion = $("#direccionUbicacionPaciente").val();
    let departamentoUbicacion = $("#departamentoUbicacionPaciente").val();
    let municipioUbicacion = $("#municipioUbicacionPaciente").val();
    let lat = $("#latitudUbicacion").val();
    let lng = $("#longitudUbicacion").val();

    if (direccionUbicacion !== '' && departamentoUbicacion !== null && municipioUbicacion !== null && municipioUbicacion !== '') {

        console.log('Ingreso')
        
        // mostrarMapaUbicacion(direccionUbicacion, departamentoUbicacion, municipioUbicacion, lat, lng)
        loadGoogleMaps(() => {
            mostrarMapaUbicacion(
                direccionUbicacion, 
                departamentoUbicacion, 
                municipioUbicacion, 
                '', 
                ''
            );
        });
    
    }else{

        toastr.warning("Recurde que debe gestionar el campo Direccion, Departamento y Municipio para que se genere la ubicacion en el mapa", "Error");

    }

}


const recargarMapa = () => {

    let direccionUbicacion = $("#editDireccionUbicacionPaciente").val();
    let departamentoUbicacion = $("#editDepartamentoUbicacionPaciente").val();
    let municipioUbicacion = $("#editMunicipioUbicacionPaciente").val();
    let lat = $("#latitudUbicacion").val();
    let lng = $("#longitudUbicacion").val();

    if (direccionUbicacion !== '' && departamentoUbicacion !== null && municipioUbicacion !== null && municipioUbicacion !== '') {
        
        // mostrarMapaUbicacion(direccionUbicacion, departamentoUbicacion, municipioUbicacion, lat, lng)
        loadGoogleMaps(() => {
            mostrarMapaUbicacion(
                direccionUbicacion, 
                departamentoUbicacion, 
                municipioUbicacion, 
                '', 
                ''
            );
        });
    
    }else{

        console.log("Algo salio mal al recargar el mapa");

    }

}

const agregarPaciente = () => {

    let formulario = document.getElementById("formAgregarPaciente");
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

            //$(".btnAgregarPaciente").attr('disabled', true);

            let numeroIdentificacion = $('#numIdentificacionPaciente').val();
            let expedidoEn = $('#expDocPaciente').val();
            let tipoDocumento = $('#tipoDocPacienteAgen').val();
            let noCarnet = $('#numCarnetPaciente').val();
            let primerApellidoPaciente = $('#priApellidoPaciente').val();
            let segundoApellidoPaciente = $('#segApellidoPaciente').val();
            let primerNombrePaciente = $('#priNombrePaciente').val();
            let segundoNombrePaciente = $('#segNombrePaciente').val();
            let seudonimoPaciente = $("#seudonimoPaciente").val();
            let fechaNacimientoPaciente = $('#fechaNacimientoPaciente').val();
            let edadNPaciente = $('#edadNPaciente').val();
            let edadTPaciente = $('#edadTPaciente').val();
            let estadoCivilPaciente = $('#estadoCivilPaciente').val();
            let generoPaciente = $('#generoPacienteAgen').val();
            let escolaridadPaciente = $('#escolaridadPaciente').val();
            let vinculacionPaciente = $('#vinculacionPaciente').val();
            let ocupacionPaciente = $('#ocupacionPaciente').val();
            let grupoPoblacionalPaciente = $('#grupoPoblacionalPaciente').val();
            let pertenenciaEtnicaPaciente = $('#pertenenciaEtnicaPaciente').val();
            let regimenPaciente = $('#regimenPacienteAgen').val();
            let tipoUsuarioRipsPaciente = $('#tipoUsuRipsPaciente').val();
            let tipoAfiliacionPaciente = $('#tipoAfiliacionPaciente').val();
            let entidadAfActualPaciente = $('#entidadAfActualPaciente').val();
            let modCopagoPaciente = $('#modCopagoPaciente').val();
            let copagoFePaciente = $('#copagoFePaciente').val();
            let nivelSisbenPaciente = $('#nivelSisbenPaciente').val();
            let departamentoSisbenPaciente = $('#departamentoSisbenPaciente').val();
            let municipioSisbenPaciente = $('#municipioSisbenPaciente').val();
            let reclamaMediPaciente = $('#reclamaMedicamentosEnPaciente').val();
            let paqueteAtencionPaciente = $('#paqueteAtencionPaciente').val();
            let notificaSivigilaPaciente = $('#notificadoSivigilaPaciente').val();
            let fechaNotificacionSiviPaciente = $('#fechaNotificadoSivigilaPaciente').val();
            let ipsNotificaPaciente = $('#ipsNotificacionPaciente').val();
            let direccionUbicacionPaciente = $('#direccionUbicacionPaciente').val();
            let latitudUbicacion = $('#latitudUbicacion').val();
            let longitudUbicacion = $('#longitudUbicacion').val();
            let telefonoUnoPaciente = $('#telefonoUnoPaciente').val();
            let telefonoDosPaciente = $('#telefonoDosPaciente').val();
            let zonaUbicacionPaciente = $('#zonaUbicacionPaciente').val();
            let departamentoUbicacionPaciente = $('#departamentoUbicacionPaciente').val();
            let municipioUbicacionPaciente = $('#municipioUbicacionPaciente').val();
            let paisOrigenPaciente = $('#paisOrigenPaciente').val();
            let correoPaciente = $('#correoPaciente').val();
            let nombreMadrePaciente = $('#nombreMadrePaciente').val();
            let nombrePadrePaciente = $('#nombrePadrePaciente').val();
            let responsablePaciente = $('#responsablePaciente').val();
            let parentescoPaciente = $('#parentescoPaciente').val();
            let direccionContactoPaciente = $('#direccionContactoPaciente').val();
            let telefonoContactoPaciente = $('#telefonoContactoPaciente').val();
            let psuodonimoPaciente = $('#pseudonimoPaciente').val();
            let observacionContactoPaciente = $('#observacionesContactoPaciente').val();
            let usuarioCrea = $("#usuarioCrea").val();

            // mostrarMapaUbicacion(direccionUbicacionPaciente, departamentoUbicacionPaciente, municipioUbicacionPaciente, latitudUbicacion, longitudUbicacion);
            loadGoogleMaps(() => {
                mostrarMapaUbicacion(
                    direccionUbicacionPaciente, 
                    departamentoUbicacionPaciente, 
                    municipioUbicacionPaciente, 
                    latitudUbicacion, 
                    longitudUbicacion
                );
            });

            //console.log(latitudUbicacion);
            //console.log(longitudUbicacion);

            if(latitudUbicacion !== "" && longitudUbicacion !== ""){

                loadingFnc();

                $.ajax({

                    url: 'ajax/config/pacientes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'crearPaciente',
                        'numeroIdentificacion':numeroIdentificacion,
                        'expedidoEn':expedidoEn,
                        'tipoDocumento':tipoDocumento,
                        'noCarnet':noCarnet,
                        'primerApellidoPaciente':primerApellidoPaciente,
                        'segundoApellidoPaciente':segundoApellidoPaciente,
                        'primerNombrePaciente':primerNombrePaciente,
                        'segundoNombrePaciente':segundoNombrePaciente,
                        'seudonimoPaciente':seudonimoPaciente,
                        'fechaNacimientoPaciente':fechaNacimientoPaciente,
                        'edadNPaciente':edadNPaciente,
                        'edadTPaciente':edadTPaciente,
                        'estadoCivilPaciente':estadoCivilPaciente,
                        'generoPaciente':generoPaciente,
                        'escolaridadPaciente':escolaridadPaciente,
                        'vinculacionPaciente':vinculacionPaciente,
                        'ocupacionPaciente':ocupacionPaciente,
                        'grupoPoblacionalPaciente':grupoPoblacionalPaciente,
                        'pertenenciaEtnicaPaciente':pertenenciaEtnicaPaciente,
                        'regimenPaciente':regimenPaciente,
                        'tipoUsuarioRipsPaciente':tipoUsuarioRipsPaciente,
                        'tipoAfiliacionPaciente':tipoAfiliacionPaciente,
                        'entidadAfActualPaciente':entidadAfActualPaciente,
                        'modCopagoPaciente':modCopagoPaciente,
                        'copagoFePaciente':copagoFePaciente,
                        'nivelSisbenPaciente':nivelSisbenPaciente,
                        'departamentoSisbenPaciente':departamentoSisbenPaciente,
                        'municipioSisbenPaciente':municipioSisbenPaciente,
                        'reclamaMediPaciente':reclamaMediPaciente,
                        'paqueteAtencionPaciente':paqueteAtencionPaciente,
                        'notificaSivigilaPaciente':notificaSivigilaPaciente,
                        'fechaNotificacionSiviPaciente':fechaNotificacionSiviPaciente,
                        'ipsNotificaPaciente':ipsNotificaPaciente,
                        'direccionUbicacionPaciente':direccionUbicacionPaciente, 
                        'latitudUbicacion':latitudUbicacion,
                        'longitudUbicacion':longitudUbicacion,
                        'telefonoUnoPaciente':telefonoUnoPaciente,
                        'telefonoDosPaciente':telefonoDosPaciente,
                        'zonaUbicacionPaciente':zonaUbicacionPaciente,
                        'departamentoUbicacionPaciente':departamentoUbicacionPaciente,
                        'municipioUbicacionPaciente':municipioUbicacionPaciente,
                        'paisOrigenPaciente':paisOrigenPaciente,
                        'correoPaciente':correoPaciente,
                        'nombreMadrePaciente':nombreMadrePaciente,
                        'nombrePadrePaciente':nombrePadrePaciente,
                        'responsablePaciente':responsablePaciente,
                        'parentescoPaciente':parentescoPaciente,
                        'direccionContactoPaciente':direccionContactoPaciente,
                        'telefonoContactoPaciente':telefonoContactoPaciente,
                        'psuodonimoPaciente':psuodonimoPaciente,
                        'observacionContactoPaciente':observacionContactoPaciente,
                        "usuarioCrea":usuarioCrea

                    },
                    success:function(respuesta){

                        Swal.close();

                        if(respuesta === 'ok'){

                            Swal.fire({
                                text: 'El Paciente se guardo correctamente',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) =>{

                                if(result.isConfirmed){

                                    $.ajax({
                                        url: 'ajax/di/agendamiento.ajax.php',
                                        type: 'POST',
                                        data: {
                                            'proceso': 'validaDatosPaciente',
                                            'idBolsaAgendamiento': idAgendamiento,
                                            'tipoDocumento': tipoDocumento,
                                            'numeroDocumento': numeroIdentificacion
                                        },
                                        cache: false,
                                        dataType: "json"
                                    }).done(function (respuestaUsu) {
            
                                        window.location = 'index.php?ruta=di/gestionaragendamiento&idAgendamiento='+btoa(idAgendamiento)+'&idPaciente='+btoa(respuestaUsu.id_paciente);
                
                                    });

                                }

                            })

                        }else{

                            Swal.fire({
                                title: 'Error!',
                                text: 'El Paciente no se guardo correctamente',
                                icon: 'error',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            })

                        }

                    }

                })

            }else{

                toastr.warning("Por favor espera que se genere la ubicacion geografica del Paciente", "Error!");

            }

        }
    
    }else{
        console.log('Error en algun campo');
    }

}

const editarPaciente = () => {

    let idPaciente = document.getElementById("editIdPaciente").value;

    let formulario = document.getElementById("formEditarPaciente");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {
        
        
        if (formulario.checkValidity()){

            $.ajax({

                url: 'ajax/config/pacientes.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'mostrarPaciente',
                    'idPaciente': idPaciente
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    delete(respuesta["nombre_paciente_completo"]);
                    delete(respuesta["estado"]);
                    delete(respuesta["usuario_crea"]);
                    delete(respuesta["fecha_crea"]);
                    

                    //console.log(respuesta);

                    let arrayDatosNuevos = {};
                    let fechaNotificaSivila =  $("#editFechaNotificadoSivigilaPaciente").val();

                    if(fechaNotificaSivila == ''){
                        fechaNotificaSivila = null;
                    }else{
                        fechaNotificaSivila = $("#editFechaNotificadoSivigilaPaciente").val();
                    }

                    arrayDatosNuevos.id_paciente = $("#editIdPaciente").val();
                    arrayDatosNuevos.numero_documento = $("#editNumIdentificacionPaciente").val();
                    arrayDatosNuevos.tipo_documento = $("#editTipoDocPaciente").val();
                    arrayDatosNuevos.primer_apellido = $("#editPriApellidoPaciente").val().toUpperCase();
                    arrayDatosNuevos.segundo_apellido = $("#editSegApellidoPaciente").val().toUpperCase();
                    arrayDatosNuevos.primer_nombre = $("#editPriNombrePaciente").val().toUpperCase();
                    arrayDatosNuevos.segundo_nombre = $("#editSegNombrePaciente").val().toUpperCase();
                    arrayDatosNuevos.seudonimo_paciente = $("#editSeudonimoPaciente").val().toUpperCase();
                    arrayDatosNuevos.expedido_en = $("#editExpDocPaciente").val();
                    arrayDatosNuevos.no_carnet = $("#editNumCarnetPaciente").val();
                    arrayDatosNuevos.fecha_nacimiento = $("#editFechaNacimientoPaciente").val();
                    arrayDatosNuevos.edad_n = $("#editEdadNPaciente").val();
                    arrayDatosNuevos.edad_t = $("#editEdadTPaciente").val();
                    arrayDatosNuevos.genero_paciente = $("#editGeneroPaciente").val();
                    arrayDatosNuevos.estado_civil = $("#editEstadoCivilPaciente").val();
                    arrayDatosNuevos.escolaridad = $("#editEscolaridadPaciente").val();
                    arrayDatosNuevos.vinculacion = $("#editVinculacionPaciente").val();
                    arrayDatosNuevos.ocupacion = $("#editOcupacionPaciente").val();
                    arrayDatosNuevos.grupo_poblacional = $("#editGrupoPoblacionalPaciente").val();
                    arrayDatosNuevos.pertenencia_etnica = $("#editPertenenciaEtnicaPaciente").val();
                    arrayDatosNuevos.regimen = $("#editRegimenPaciente").val();
                    arrayDatosNuevos.tipo_usuario_rips = $("#editTipoUsuRipsPaciente").val();
                    arrayDatosNuevos.tipo_afiliacion = $("#editTipoAfiliacionPaciente").val();
                    arrayDatosNuevos.entidad_af_actual = $("#editEntidadAfActualPaciente").val();
                    arrayDatosNuevos.mod_copago = $("#editModCopagoPaciente").val();
                    arrayDatosNuevos.copago_fe = $("#editCopagoFePaciente").val();
                    arrayDatosNuevos.nivel_sisben = $("#editNivelSisbenPaciente").val();
                    arrayDatosNuevos.departamento_sisben = $("#editDepartamentoSisbenPaciente").val();
                    arrayDatosNuevos.municipio_sisben = $("#editMunicipioSisbenPaciente").val();
                    arrayDatosNuevos.sede_reclama_med = $("#editReclamaMedicamentosEnPaciente").val();
                    arrayDatosNuevos.paquete_atencion = $("#editPaqueteAtencionPaciente").val();
                    arrayDatosNuevos.notifica_sivigila = $("#editNotificadoSivigilaPaciente").val();
                    arrayDatosNuevos.fecha_notificacion_sivigila = fechaNotificaSivila;
                    arrayDatosNuevos.ips_notifica = $("#editIpsNotificacionPaciente").val();
                    arrayDatosNuevos.direccion_ubicacion = $("#editDireccionUbicacionPaciente").val().toUpperCase();
                    arrayDatosNuevos.latitud_ubicacion = $("#latitudUbicacion").val();
                    arrayDatosNuevos.longitud_ubicacion = $("#longitudUbicacion").val();
                    arrayDatosNuevos.telefono_uno_ubicacion = $("#editTelefonoUnoPaciente").val();
                    arrayDatosNuevos.telefono_dos_ubicacion = $("#editTelefonoDosPaciente").val();
                    arrayDatosNuevos.zona_ubicacion = $("#editZonaUbicacionPaciente").val();
                    arrayDatosNuevos.departamento_ubicacion = $("#editDepartamentoUbicacionPaciente").val();
                    arrayDatosNuevos.municipio_ubicacion = $("#editMunicipioUbicacionPaciente").val();
                    arrayDatosNuevos.pais_origen = $("#editPaisOrigenPaciente").val();
                    arrayDatosNuevos.correo = $("#editCorreoPaciente").val();
                    arrayDatosNuevos.nombre_madre = $("#editNombreMadrePaciente").val();
                    arrayDatosNuevos.nombre_padre = $("#editNombrePadrePaciente").val();
                    arrayDatosNuevos.responsable = $("#editResponsablePaciente").val();
                    arrayDatosNuevos.parentesco = $("#editParentescoPaciente").val();
                    arrayDatosNuevos.direccion_contacto = $("#editDireccionContactoPaciente").val();
                    arrayDatosNuevos.telefono_contacto = $("#editTelefonoContactoPaciente").val();
                    arrayDatosNuevos.psudonimo = $("#editPseudonimoPaciente").val();
                    arrayDatosNuevos.observacion_contacto = $("#editObservacionesContactoPaciente").val();

                    let usuarioEdita = $("#usuarioEdita").val();


                    // mostrarMapaUbicacion(arrayDatosNuevos.direccion_ubicacion, arrayDatosNuevos.departamento_ubicacion, arrayDatosNuevos.municipio_ubicacion, arrayDatosNuevos.latitud_ubicacion, arrayDatosNuevos.longitud_ubicacion);
                    loadGoogleMaps(() => {
                        mostrarMapaUbicacion(
                            arrayDatosNuevos.direccion_ubicacion, 
                            arrayDatosNuevos.departamento_ubicacion, 
                            arrayDatosNuevos.municipio_ubicacion, 
                            arrayDatosNuevos.latitud_ubicacion, 
                            arrayDatosNuevos.longitud_ubicacion
                        );
                    });


                    let cambios = obtenerCambiosCamposEditarPaciente(respuesta, arrayDatosNuevos);

                    if(cambios.length === 0){

                        cambios.push('Ningun cambio');

                    }

                    //console.log('Cambios', cambios);

                    loadingFnc();

                    $.ajax({

                        url: 'ajax/config/pacientes.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'editarPaciente',
                            'idPaciente': arrayDatosNuevos.id_paciente,
                            'numeroIdentificacion': arrayDatosNuevos.numero_documento,
                            'expedidoEn':arrayDatosNuevos.expedido_en,
                            'tipoDocumento': arrayDatosNuevos.tipo_documento,
                            'noCarnet': arrayDatosNuevos.no_carnet,
                            'primerApellidoPaciente': arrayDatosNuevos.primer_apellido,
                            'segundoApellidoPaciente':arrayDatosNuevos.segundo_apellido,
                            'seudonimoPaciente':arrayDatosNuevos.seudonimo_paciente,
                            'primerNombrePaciente': arrayDatosNuevos.primer_nombre,
                            'segundoNombrePaciente': arrayDatosNuevos.segundo_nombre,
                            'fechaNacimientoPaciente':arrayDatosNuevos.fecha_nacimiento,
                            'edadNPaciente': arrayDatosNuevos.edad_n,
                            'edadTPaciente': arrayDatosNuevos.edad_t,
                            'estadoCivilPaciente': arrayDatosNuevos.estado_civil,
                            'generoPaciente': arrayDatosNuevos.genero_paciente,
                            'escolaridadPaciente': arrayDatosNuevos.escolaridad,
                            'vinculacionPaciente': arrayDatosNuevos.vinculacion,
                            'ocupacionPaciente': arrayDatosNuevos.ocupacion,
                            'grupoPoblacionalPaciente': arrayDatosNuevos.grupo_poblacional,
                            'pertenenciaEtnicaPaciente': arrayDatosNuevos.pertenencia_etnica,
                            'regimenPaciente': arrayDatosNuevos.regimen,
                            'tipoUsuarioRipsPaciente': arrayDatosNuevos.tipo_usuario_rips,
                            'tipoAfiliacionPaciente': arrayDatosNuevos.tipo_afiliacion,
                            'entidadAfActualPaciente': arrayDatosNuevos.entidad_af_actual,
                            'modCopagoPaciente': arrayDatosNuevos.mod_copago,
                            'copagoFePaciente': arrayDatosNuevos.copago_fe,
                            'nivelSisbenPaciente': arrayDatosNuevos.nivel_sisben,
                            'departamentoSisbenPaciente':arrayDatosNuevos.departamento_sisben,
                            'municipioSisbenPaciente':arrayDatosNuevos.municipio_sisben,
                            'reclamaMediPaciente':arrayDatosNuevos.sede_reclama_med,
                            'paqueteAtencionPaciente':arrayDatosNuevos.paquete_atencion,
                            'notificaSivigilaPaciente':arrayDatosNuevos.notifica_sivigila,
                            'fechaNotificacionSiviPaciente':arrayDatosNuevos.fecha_notificacion_sivigila,
                            'ipsNotificaPaciente':arrayDatosNuevos.ips_notifica,
                            'direccionUbicacionPaciente':arrayDatosNuevos.direccion_ubicacion, 
                            'latitudUbicacion':arrayDatosNuevos.latitud_ubicacion,
                            'longitudUbicacion':arrayDatosNuevos.longitud_ubicacion,
                            'telefonoUnoPaciente':arrayDatosNuevos.telefono_uno_ubicacion,
                            'telefonoDosPaciente':arrayDatosNuevos.telefono_dos_ubicacion,
                            'zonaUbicacionPaciente':arrayDatosNuevos.zona_ubicacion,
                            'departamentoUbicacionPaciente':arrayDatosNuevos.departamento_ubicacion,
                            'municipioUbicacionPaciente':arrayDatosNuevos.municipio_ubicacion,
                            'paisOrigenPaciente':arrayDatosNuevos.pais_origen,
                            'correoPaciente':arrayDatosNuevos.correo,
                            'nombreMadrePaciente':arrayDatosNuevos.nombre_madre,
                            'nombrePadrePaciente':arrayDatosNuevos.nombre_padre,
                            'responsablePaciente':arrayDatosNuevos.responsable,
                            'parentescoPaciente':arrayDatosNuevos.parentesco,
                            'direccionContactoPaciente':arrayDatosNuevos.direccion_contacto,
                            'telefonoContactoPaciente':arrayDatosNuevos.telefono_contacto,
                            'psuodonimoPaciente':arrayDatosNuevos.psudonimo,
                            'observacionContactoPaciente':arrayDatosNuevos.observacion_contacto,
                            'camposCambios':cambios,
                            'usuarioEdita': usuarioEdita
    
                        },
                        success:function(respuesta){

                            Swal.close();

                            if(respuesta === 'ok'){

                                Swal.fire({
                                    text: 'El Paciente se guardo correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) =>{
    
                                    if(result.isConfirmed){
    
                                        window.location = 'index.php?ruta=di/gestionaragendamiento&idAgendamiento='+btoa(idAgendamiento)+'&idPaciente='+btoa(arrayDatosNuevos.id_paciente);
    
                                    }
    
                                })
    
                            }else{
    
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'El Paciente no se guardo correctamente',
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                })
    
                            }

                        }

                    })

                }
            })

        }else{

            toastr.warning("Los Formularios no se encuentran completamente diligenciados, por favor revisa.", "Error!");

        }

    }

}

function validarExistenciaDocumento(){

    let tipoDocumento = document.getElementById("tipoDocPacienteAgen").value;
    let numDocumento = document.getElementById("numIdentificacionPaciente").value;

    if(tipoDocumento && numDocumento){

        $.ajax({
            url: 'ajax/config/pacientes.ajax.php',
            type: 'POST',
            data: {
                'proceso': 'validarExisteDocumento',
                'tipoDocumento': tipoDocumento,
                'numDocumento': numDocumento
            },
            cache: false,
            dataType: "json",
            success:function(respuesta){

                //console.log(respuesta);

                if(respuesta){

                    Swal.fire({
                        title: '¡El Paciente ya Existe!',
                        text: `El Tipo Documento y Numero Documento ya se encuentran registrados en el Paciente: ${respuesta.primer_nombre} ${respuesta.segundo_nombre} ${respuesta.primer_apellido} ${respuesta.segundo_apellido}`,
                        icon: 'info',
                        confirmButtonText: '¡Actualizar Informacion!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: "#3085d6",
                    }).then((result) =>{

                        if(result.isConfirmed){

                            window.location = 'index.php?ruta=di/gestionaragendamiento&idAgendamiento='+btoa(idAgendamiento)+'&idPaciente='+btoa(respuesta.id_paciente);

                        }

                    })

                    $("#numIdentificacionPaciente").val('');

                }
            
            }

        })

    }

}

const obtenerCambiosCamposEditarPaciente = (array1, array2) => {

    let diferencias = [];

    //console.log(array1);

    for (let key in array1) {
        
        if(array1[key] !== array2[key]){
            //console.log(array1[key]);
            diferencias.push(key);

        }

    }

    return diferencias;

}

const crearCitaBusqueda = () => {

    let idPaciente = document.getElementById("idPaciente").value;

    let formulario = document.getElementById("formAgendarCitaBusqueda");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {
        
        
        if (formulario.checkValidity()){

            let motivoCita = document.getElementById('motivoCita').value;
            let idProfesional = document.getElementById('profesionalCita').value;
            let fechaCita = document.getElementById('fechaCita').value;
            let franjaCita = document.getElementById('franjaCita').value;
            let observacionCita = document.getElementById('observacionCita').value;
            let cohortePrograma = document.getElementById('cohortePrograma').value;
            let localidadCita = document.getElementById('localidadCita').value;
            let servicioCita = document.getElementById('servicioCita').value;

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'validarDisponibilidadMedicoCita',
                    'idProfesional':idProfesional,
                    'fechaCita':fechaCita,
                    'franjaCita':franjaCita
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta.respuesta);

                    if(respuesta["respuesta"] == 'ok-disponibilidad'){

                        Swal.fire({
                            title: '¡Agenda Disponible!',
                            html: `Cupos: <b>${respuesta.cupos}</b><br>¿Desea agendar la Cita?`,
                            icon: 'info',
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            cancelButtonText: "Cancelar",
                            showCancelButton: true,
                            confirmButtonText: "¡Si Agendar!"
                        }).then((result) => {
                    
                            if (result.isConfirmed) {

                                loadingFnc();

                                $.ajax({

                                    url: 'ajax/di/agendamiento.ajax.php',
                                    type: 'POST',
                                    data: {
                                        'proceso': 'crearCitaBusqueda',
                                        'idProfesional':idProfesional,
                                        'idPaciente':idPaciente,
                                        'idBolsaAgendamiento':0,
                                        'motivoCita':motivoCita,
                                        'fechaCita':fechaCita,
                                        'franjaCita':franjaCita,
                                        'observacionCita':observacionCita,
                                        'cohortePrograma':cohortePrograma,
                                        'localidadCita': localidadCita,
                                        'servicioCita': servicioCita,
                                        'usuarioCrea':userSession
                                    },
                                    success:function(respuesta){

                                        Swal.close();

                                        if(respuesta == 'ok'){

                                            Swal.fire({
                                                text: '¡La Cita se guardo correctamente!',
                                                icon: 'success',
                                                confirmButtonText: 'Cerrar',
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                confirmButtonColor: "#d33"
                                            }).then((result) =>{
                    
                                                if(result.isConfirmed){
                    
                                                    window.location = 'index.php?ruta=di/agendarcitapaciente&idPaciente='+btoa(idPaciente);
                    
                                                }
                    
                                            })

                                        }else{

                                            Swal.fire({
                                                text: '¡Algo salio mal, la Cita no se creo correctamente!',
                                                icon: 'warning',
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



                    }else if(respuesta["respuesta"] == "error-dia-no-disponible"){
                        
                        Swal.fire({
                            text: `¡El Profesional el dia ${fechaCita} no esta Disponible para agendar la Cita!`,
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })
                        
                    }else if(respuesta["respuesta"] == 'no-disponibilidad'){

                        Swal.fire({
                            text: '¡No hay disponibilidad para agendar la Cita!',
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }else{

                        Swal.fire({
                            text: '¡Algo salio mal al obtener las capacidades de gestion, comunique al administrador!',
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }


                }

            })
        
        }else{

            toastr.warning("El Formulario para agregar Cita debe ser diligenciado completamente.", "Error!");

        }

    }

}

const terminarAgendarCitaBuqueda = () => {

    window.location = 'index.php?ruta=di/buscaragendacita';

}

const crearCita = () => {

    let idPaciente = document.getElementById("editIdPaciente").value;

    let formulario = document.getElementById("formAgregarCita");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {
        
        
        if (formulario.checkValidity()){

            let motivoCita = document.getElementById('motivoCita').value;
            let idProfesional = document.getElementById('profesionalCita').value;
            let fechaCita = document.getElementById('fechaCita').value;
            let franjaCita = document.getElementById('franjaCita').value;
            let observacionCita = document.getElementById('observacionCita').value;
            let cohortePrograma = document.getElementById('cohortePrograma').value;
            let localidadCita = document.getElementById('localidadCita').value;
            let servicioCita = document.getElementById('servicioCita').value;

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'validarDisponibilidadMedicoCita',
                    'idProfesional':idProfesional,
                    'fechaCita':fechaCita,
                    'franjaCita':franjaCita
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta.respuesta);

                    if(respuesta["respuesta"] == 'ok-disponibilidad'){

                        Swal.fire({
                            title: '¡Agenda Disponible!',
                            html: `Cupos: <b>${respuesta.cupos}</b><br>¿Desea agendar la Cita?`,
                            icon: 'info',
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            cancelButtonText: "Cancelar",
                            showCancelButton: true,
                            confirmButtonText: "¡Si Agendar!"
                        }).then((result) => {
                    
                            if (result.isConfirmed) {

                                loadingFnc();

                                $.ajax({

                                    url: 'ajax/di/agendamiento.ajax.php',
                                    type: 'POST',
                                    data: {
                                        'proceso': 'crearCita',
                                        'idProfesional':idProfesional,
                                        'idPaciente':idPaciente,
                                        'idBolsaAgendamiento':idAgendamiento,
                                        'motivoCita':motivoCita,
                                        'fechaCita':fechaCita,
                                        'franjaCita':franjaCita,
                                        'observacionCita':observacionCita,
                                        'cohortePrograma':cohortePrograma,
                                        'localidadCita': localidadCita,
                                        'servicioCita': servicioCita,
                                        'usuarioCrea':userSession
                                    },
                                    success:function(respuesta){

                                        Swal.fire();

                                        if(respuesta == 'ok'){

                                            Swal.fire({
                                                text: '¡La Cita se guardo correctamente!',
                                                icon: 'success',
                                                confirmButtonText: 'Cerrar',
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                confirmButtonColor: "#d33"
                                            }).then((result) =>{
                    
                                                if(result.isConfirmed){
                    
                                                    window.location = 'index.php?ruta=di/gestionaragendamiento&idAgendamiento='+btoa(idAgendamiento)+'&idPaciente='+btoa(idPaciente);
                    
                                                }
                    
                                            })

                                        }else{

                                            Swal.fire({
                                                text: '¡Algo salio mal, la Cita no se creo correctamente!',
                                                icon: 'warning',
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



                    }else if(respuesta["respuesta"] == "error-dia-no-disponible"){
                        
                        Swal.fire({
                            text: `¡El Profesional el dia ${fechaCita} no esta Disponible para agendar la Cita!`,
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })
                        
                    }else if(respuesta["respuesta"] == 'no-disponibilidad'){

                        Swal.fire({
                            text: '¡No hay disponibilidad para agendar la Cita!',
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }else{

                        Swal.fire({
                            text: '¡Algo salio mal al obtener las capacidades de gestion, comunique al administrador!',
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }


                }

            })
        
        }else{

            toastr.warning("El Formulario para agregar Cita debe ser diligenciado completamente.", "Error!");

        }

    }

}

const guardarInformacionNexusVidamedial = async (idAgendamiento) => {

    const respuesta = await $.ajax({

        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'guardarInformacionNexusVidamedical',
            'idBolsaAgendamiento':idAgendamiento,
        },
        dataType:'json'
    });

    if(!respuesta){

        console.error("Respuesta no existe"); 
        return;
    }

    // console.log(respuesta);

    return respuesta;

}

const terminarGestionAgendamiento = async () => {

    // let respExportData = await guardarInformacionNexusVidamedial(idAgendamiento);

    // console.log(respExportData);

    Swal.fire({
        text: '¿Desea terminar la Gestion del Agendamiento?',
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Terminar!"
    }).then((result) => {

        if(result.isConfirmed){

            loadingFnc();

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'terminarGestionAgendamiento',
                    'idBolsaAgendamiento':idAgendamiento,
                    'estado':'FINALIZADA'
                },
                success:async function(respuesta){

                    Swal.close();
                    
                    if(respuesta == 'ok'){

                        loadingFnc();

                        let respExportData = await guardarInformacionNexusVidamedial(idAgendamiento);

                        Swal.close();

                        Swal.fire({
                            text: '¡La Gestion de Agendamiento se finalizo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/pendientesagendamiento';

                            }

                        })

                    }else if(respuesta == 'sin-registros-citas'){

                        Swal.fire({
                            text: '¡La Gestion de Agendamiento no se puede finalizar debido a que no se agendaron Citas!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }else{

                        Swal.fire({
                            text: '¡La Gestion de Agendamiento no se finalizo correctamente!',
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

const existeUsuario = (event) => {

    // console.log(event);

}

const guardarAsignacionBolsaAgendamiento = () => {

    let formulario = document.getElementById("formAsignarBolsaAgendamiento");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {
        
        if (formulario.checkValidity()){

            let usuarioAgendamiento = document.getElementById('usuarioAgendamiento').value;
            let cohorteProgramaAgendamiento = document.getElementById('cohorteProgramaAgendamiento').value;

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'crearAsignacionBolsa',
                    'usuario':usuarioAgendamiento,
                    'cohortePrograma':cohorteProgramaAgendamiento,
                    'usuarioCrea':userSession,
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Asignacion de Bolsa de Agendamiento se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            // if(result.isConfirmed){

                            //     window.location = 'index.php?ruta=di/asignarbolsaagendamiento';

                            // }
                            tablaUsuariosBolsaAgendamiento.ajax.reload();
                            $('#usuarioAgendamiento').val('').trigger('change');
                            $('#cohorteProgramaAgendamiento').val('').trigger('change');

                        })


                    }else if(respuesta == 'bandeja-asignada'){

                        Swal.fire({
                            text: '¡El Usuario ya tiene la Bolsa de Agendamiento Asignada!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }else{

                        Swal.fire({
                            text: '¡La Asignacion de Bolsa de Agendamiento no se guardo correctamente!',
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

            toastr.warning("El Formulario para agregar Prioridad debe ser diligenciado completamente.", "Error!");

        }

    }
        

}

const crearPrioridadAgendamiento = () => {

    Swal.fire({
        text: '¿Desea crear la Prioridad en el Agendamiento?',
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Terminar!"
    }).then((result) => {

        if(result.isConfirmed){

            let formulario = document.getElementById("formPrioridadAgendamiento");
            let elementos = formulario.elements;
            let errores = 0;
            //console.log(formulario);
            //console.log(elementos);

            Array.from(elementos).forEach(function (element) { //array de elementos del Form
                if (element.className.includes('is-invalid')) {
                    errores += 1;
                }
            });
            if (errores === 0) {
                
                if (formulario.checkValidity()){

                    let cohortePrograma = document.getElementById('cohorteProgramaPrioridad').value;
                    let prioridad = document.getElementById('numeroPrioridad').value;

                    $.ajax({

                        url: 'ajax/di/agendamiento.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'crearPrioridad',
                            'cohortePrograma':cohortePrograma,
                            'prioridad':prioridad,
                            'usuarioCrea':userSession,
                        },
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Prioridad de Agendamiento se guardo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=di/prioridadagendamiento';
        
                                    }
        
                                })
        
        
                            }else if(respuesta == 'error'){
        
                                Swal.fire({
                                    text: '¡La Prioridad de Agendamiento no se guardo correctamente!',
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                })
        
                            }else{
        
                                Swal.fire({
                                    text: '¡La Prioridad de Agendamiento para la Cohorte o Programa seleccionado ya existe!',
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

                    toastr.warning("El Formulario para agregar Prioridad debe ser diligenciado completamente.", "Error!");

                }

            }
        
        }

    })

}

const eliminarPrioridad = (idPrioridad) => {

    Swal.fire({
        text: '¿Desea eliminar la Prioridad en el Agendamiento?',
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if(result.isConfirmed){

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarPrioridad',
                    'idPrioridad':idPrioridad,
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Prioridad de Agendamiento se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/prioridadagendamiento';

                            }

                        })


                    }else{

                        Swal.fire({
                            text: '¡La Prioridad de Agendamiento no se elimino correctamente!',
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

const eliminarCita = (idCita, motivoCita, idAgendamiento, idPaciente) => {

    Swal.fire({
        text: `¿Desea eliminar la Cita: ${motivoCita}?`,
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if(result.isConfirmed){

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarCita',
                    'idCita':idCita,
                    'user': userSession
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Cita se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/gestionaragendamiento&idAgendamiento='+btoa(idAgendamiento)+'&idPaciente='+btoa(idPaciente);

                            }

                        })

                        
                    }else if(respuesta == 'error-eliminando'){

                        Swal.fire({
                            text: '¡La Cita no se elimino correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }else{

                        Swal.fire({
                            text: '¡Algo salio mal intentado eliminar la Cita!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }

                }

            });


        }

    })
}

const eliminarCitaDisponibilidad = (idCita, motivoCita) => {

    Swal.fire({
        text: `¿Desea eliminar la Cita: ${motivoCita}?`,
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if(result.isConfirmed){

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarCita',
                    'idCita':idCita,
                    'user': userSession
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Cita se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/disponibilidadprofesional';

                            }

                        })

                        
                    }else if(respuesta == 'error-eliminando'){

                        Swal.fire({
                            text: '¡La Cita no se elimino correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }else{

                        Swal.fire({
                            text: '¡Algo salio mal intentado eliminar la Cita!',
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

const redireccionReAgendarCita = (idCitaReAgendar) => {

    window.location = 'index.php?ruta=di/reagendarcita&idCitaReAgendar='+btoa(idCitaReAgendar);
    
}

const redireccionAgendarCita = (idPaciente) => {
    
    window.location = 'index.php?ruta=di/agendarcitapaciente&idPaciente='+btoa(idPaciente);

}

const buscarCitaPaciente = () => {

    const cardResultado = document.querySelector("#cardResultadoBusquedaPacienteCitas");

    let formulario = document.getElementById("formBusquedaPacienteCita");
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

            let tipoDoc = document.getElementById('tipoDocPaciente').value;
            let tipoBusqueda = document.getElementById('tipoDato').value;
            let numeroDocumento = document.getElementById('numeroDocumento').value;

            if ($.fn.DataTable.isDataTable('#tablaCitasPaciente')) {
                $('#tablaCitasPaciente').DataTable().destroy();
            }

            tablaCitasPaciente = $("#tablaCitasPaciente").DataTable({

                columns: [
                    { name: 'ID CITA', data: 'id_cita' },
                    { name: 'PACIENTE', data: 'nombre_paciente' },
                    {
                        name: 'DOCUMENTO PACIENTE', orderable: false, render: function (data, type, row) {
                            return row.tipo_documento + ' - ' + row.numero_documento;
                        }
                    },
                    { name: 'PROFESIONAL', data: 'nombre_profesional' },
                    { name: 'MOTIVO CITA', data: 'motivo_cita' },
                    { name: 'COHORTE O PROGRAMA', data: 'cohorte_programa' },
                    {
                        name: 'FECHA CITA PACIENTE', orderable: false, render: function (data, type, row) {
                            let badgedColor = row.franja_cita == 'AM' ? 'badge-phoenix-warning' : 'badge-phoenix-primary';

                            return `<span class="badge badge-phoenix ${badgedColor}">${row.fecha_cita} - ${row.franja_cita}</span>`;
                        }
                    },
                    { name: 'LOCALIDAD', data: 'localidad_cita' },
                    { name: 'ESTADO', render: function(data, type, row){
                        let badgedColor = row.estado == 'CREADA' ? 'badge-phoenix-warning' : 'badge-phoenix-primary';
                        return `<span class="badge badge-phoenix ${badgedColor}">${row.estado}</span>`;
                        } 
                    },
                    {
                        name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                            return `<button type="button" class="btn btn-success btn-sm" onclick="redireccionReAgendarCita(${row.id_cita})" title="Re-Agendar Cita"><i class="far fa-calendar-check"></i></button>`;
                        }
                    }
                ],
                ajax: {
                    url: 'ajax/di/citas.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaCitasPaciente',
                        'tipoDoc': tipoDoc,
                        'tipoBusqueda': tipoBusqueda,
                        'numeroDocumento': numeroDocumento
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ]
            
            });

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const buscarPacienteAgenda = () => {

    const cardResultado = document.querySelector("#cardResultadoBusquedaPaciente");

    let formulario = document.getElementById("formBusquedaPaciente");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            cardResultado.style.display = 'block';

            let tipoDoc = document.getElementById('tipoDocPaciente').value;
            let tipoBusqueda = document.getElementById('tipoDato').value;
            let numeroDocumento = document.getElementById('numeroDocumento').value;

            if ($.fn.DataTable.isDataTable('#tablaPacienteAgenda')) {
                $('#tablaPacienteAgenda').DataTable().destroy();
            }

            let tablaPacienteAgenda = $("#tablaPacienteAgenda").DataTable({

                columns: [
                    { name: 'ID PACIENTE', data: 'id_paciente' },
                    { name: 'PACIENTE', data: 'nombre_paciente' },
                    {
                        name: 'DOCUMENTO PACIENTE', orderable: false, render: function (data, type, row) {
                            return row.tipo_documento + ' - ' + row.numero_documento;
                        }
                    },
                    { name: 'REGIMEN', data: 'regimen' },
                    { name: 'DIRECCION', data: 'direccion_ubicacion' },
                    { name: 'TELEFONO', data: 'telefono_uno_ubicacion' },
                    {
                        name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                            return `<button type="button" class="btn btn-success btn-sm" onclick="redireccionAgendarCita(${row.id_paciente})" title="Agendar Cita"><i class="far fa-calendar-check"></i></button>`;
                        }
                    }
                ],
                ajax: {
                    url: 'ajax/di/agendamiento.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaPacienteAgenda',
                        'tipoDoc': tipoDoc,
                        'tipoBusqueda': tipoBusqueda,
                        'numeroDocumento': numeroDocumento
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ]
            
            });

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const crearNoDisponibilidad = () => {

    let formulario = document.getElementById("formAgregarNoDisponibilidad");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {
        
        
        if (formulario.checkValidity()){

            let motivoCita = document.getElementById('motivoCita').value;
            let idProfesional = document.getElementById('profesionalCita').value;
            let fechaCita = document.getElementById('fechaCita').value;
            let franjaCita = document.getElementById('franjaCita').value;
            let observacionCita = document.getElementById('observacionCita').value;
            // let localidadCita = document.getElementById('localidadCita').value;

            // console.log(franjaCita);

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'validarNoDisponibilidad',
                    'idProfesional':idProfesional,
                    'fechaCita':fechaCita,
                    'franjaCita':franjaCita
                },
                success:function(respuesta){

                    if(respuesta == 'ok-agendar-no-disponibilidad'){

                        Swal.fire({
                            text: `Se puede agregar la NO disponibilidad del Profesional`,
                            icon: 'info',
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            cancelButtonText: "Cancelar",
                            showCancelButton: true,
                            confirmButtonText: "¡Si Agendar!"
                        }).then((result) => {
                    
                            if (result.isConfirmed) {

                                $.ajax({

                                    url: 'ajax/di/agendamiento.ajax.php',
                                    type: 'POST',
                                    data: {
                                        'proceso': 'crearNoDisponibilidad',
                                        'idProfesional':idProfesional,
                                        'motivoCita':motivoCita,
                                        'fechaCita':fechaCita,
                                        'franjaCita':franjaCita,
                                        'observacionCita':observacionCita,
                                        'localidadCita': 'NO APLICA',
                                        'usuarioCrea':userSession
                                    },
                                    success:function(respuesta){

                                        if(respuesta == 'ok'){

                                            Swal.fire({
                                                text: '¡Se Agrego la No Disponibilidad correctamente!',
                                                icon: 'success',
                                                confirmButtonText: 'Cerrar',
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                confirmButtonColor: "#d33"
                                            }).then((result) =>{
                    
                                                if(result.isConfirmed){
                    
                                                    window.location = 'index.php?ruta=di/disponibilidadprofesional';
                    
                                                }
                    
                                            })

                                        }else{

                                            Swal.fire({
                                                text: '¡Algo salio mal, la No Disponibilidad no se creo correctamente!',
                                                icon: 'warning',
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



                    }else if(respuesta == "no-disponible-existe"){
                        
                        Swal.fire({
                            text: `¡No se puede Agendar No Disponibilidad porque ya existe una!`,
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })
                        
                    }else if(respuesta == 'citas-agendadas'){

                        Swal.fire({
                            text: '¡No se puede Agendar No Disponibilidad porque existen Citas agendadas!',
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }else{

                        Swal.fire({
                            text: '¡Algo salio mal al obtener los datos, comuniquese al administrador!',
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }

                }

            })

        }else{

            toastr.warning("El Formulario para agregar Cita debe ser diligenciado completamente.", "Error!");

        }

    }
}

const ReAgendarCita = () => {

    let formulario = document.getElementById("formReAgendarCita");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let idCita = document.getElementById('idCitaEditar').value;
            let idProfesional = document.getElementById('profesionalCitaEditar').value;
            let fechaCita = document.getElementById('fechaCita').value;
            let franjaCita = document.getElementById('franjaCita').value;
            let servicioCita = document.getElementById('servicioCitaEditar').value;

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'validarDisponibilidadMedicoCita',
                    'idProfesional':idProfesional,
                    'fechaCita':fechaCita,
                    'franjaCita':franjaCita
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta.respuesta);

                    if(respuesta["respuesta"] == 'ok-disponibilidad'){

                        Swal.fire({
                            title: '¡Agenda Disponible!',
                            html: `Cupos: <b>${respuesta.cupos}</b><br>¿Desea Re-Agendar la Cita?`,
                            icon: 'info',
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            cancelButtonText: "Cancelar",
                            showCancelButton: true,
                            confirmButtonText: "¡Si Re-Agendar!"
                        }).then((result) => {
                    
                            if (result.isConfirmed) {

                                $.ajax({

                                    url: 'ajax/di/agendamiento.ajax.php',
                                    type: 'POST',
                                    data: {
                                        'proceso': 'reAgendarCita',
                                        'idCita':idCita,
                                        'idProfesional':idProfesional,
                                        'fechaCita':fechaCita,
                                        'franjaCita':franjaCita,
                                        'servicioCita':servicioCita,
                                        'user': userSession
                                    },
                                    success:function(respuesta){

                                        if(respuesta == 'ok'){

                                            Swal.fire({
                                                text: '¡La Cita se Re-Agendo correctamente!',
                                                icon: 'success',
                                                confirmButtonText: 'Cerrar',
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                confirmButtonColor: "#d33"
                                            }).then((result) =>{
                    
                                                if(result.isConfirmed){
                    
                                                    window.location = 'index.php?ruta=di/buscarcitareagendar';
                    
                                                }
                    
                                            })

                                        }else{

                                            Swal.fire({
                                                text: '¡Algo salio mal, la Cita no se Re-Agendo correctamente!',
                                                icon: 'warning',
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



                    }else if(respuesta["respuesta"] == "error-dia-no-disponible"){
                        
                        Swal.fire({
                            text: `¡El Profesional el dia ${fechaCita} no esta Disponible para agendar la Cita!`,
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })
                        
                    }else if(respuesta["respuesta"] == 'no-disponibilidad'){

                        Swal.fire({
                            text: '¡No hay disponibilidad para agendar la Cita!',
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }else{

                        Swal.fire({
                            text: '¡Algo salio mal al obtener las capacidades de gestion, comunique al administrador!',
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }


                }

            })

        }else{

            toastr.warning("Los Formularios no se encuentran completamente diligenciados, por favor revisa.", "Error!");

        }

    }

}

const agregarUsuarioProfesional = () => {

    let formulario = document.getElementById("formAgregarUsuarioProfesional");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let nombres = document.getElementById('nombreUsuario').value;
            let apellidos = document.getElementById('apellidosUsuario').value;
            let documento = document.getElementById('documentoUsuario').value;
            let telefono = document.getElementById('telefonoUsuario').value;
            let correo = document.getElementById('correoUsuario').value;
            let cargo = document.getElementById('cargoUsuario').value;

            let datos = new FormData();

            $.ajax({
                url: 'ajax/config/users.ajax.php',
                type: 'POST',
                data: {
                    'lista': 'crearUsuarioProfesional',
                    'nombres':nombres,
                    'apellidos':apellidos,
                    'documento':documento,
                    'telefono':telefono,
                    'correo':correo,
                    'cargo':cargo,
                    'userCreate': userSession
                },
                cache: false,
                dataType: "json",
                success:function(resp){

                    if(resp.respuesta === 'usuario-permisos-creado'){

                        Swal.fire({
                            title: '¡El Profesional se creo correctamente!',
                            html: `<b>Usuario: </b> ${resp.usuario} <br> <b>Contraseña: </b> Numero Documento`,
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/registrarprofesional';

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

            toastr.warning("Los Formularios no se encuentran completamente diligenciados, por favor revisa.", "Error!");

        }

    }

}

const eliminarAsignacionBolsaAgendamiento = (idUsuBolsaAgenda) => {

    Swal.fire({
        text: `¿Desea eliminar la Asginacion de la Bolsa de Agendamiento?`,
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if(result.isConfirmed){

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarAsignacionBolsaAgendamiento',
                    'idUsuBolsaAgend':idUsuBolsaAgenda,
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Asignacion de Bolsa de Agendamiento se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            tablaUsuariosBolsaAgendamiento.ajax.reload();

                            // if(result.isConfirmed){

                            //     window.location = 'index.php?ruta=di/disponibilidadprofesional';

                            // }

                        })

                    }else{

                        Swal.fire({
                            text: '¡Algo salio mal intentado eliminar la Asignacion de Bolsa de Agendamiento!',
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

const reiniciarTable = async (idTable) => {

    if(!idTable) throw new Error('El idTable no existe'); 

    if ($.fn.DataTable.isDataTable(`#${idTable}`)) {
        $(`#${idTable}`).DataTable().destroy();
    }

    $(`#${idTable}`).DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'Descargar Excel',
                className: 'btn btn-phoenix-success',
            },
            // {
            //     extend: 'copy',
            //     text: 'Copiar Tabla',
            //     className: 'btn btn-phoenix-info',
            // }
        ],
        order: [],
        ordering: false
    });

}


const buscarAgendamiento = async () => {

    let formulario = document.getElementById("formBuscarAgendamiento");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let tipoDocumento = document.getElementById('tipoDocumentoSearch').value;
            let numeroDocumento = document.getElementById('numeroDocSearch').value;

            const cardResultado = document.querySelector('#cardResultadoBusquedaAgendamiento');
            cardResultado.style.display = 'block'; 

            const idTable = 'tablaBusquedaAgendamiento';

            if ($.fn.DataTable.isDataTable(`#${idTable}`)) {
                $(`#${idTable}`).DataTable().destroy();
            }

            tablaBusquedaAgendamiento = $('#tablaBusquedaAgendamiento').DataTable({

                columns: [
                    { name: '#', data: 'id_bolsa_paciente' },
                    { name: 'BASE', data: 'nombre' },
                    { name: 'IPS', data: 'ips' },
                    { name: 'NOMBRE PACIENTE', data: 'nombre_completo' },
                    {
                        name: 'DOCUMENTO PACIENTE', orderable: false, render: function (data, type, row) {
                            return `${row.tipo_doc} - ${row.numero_documento}`;
                        }
                    },
                    { name: 'NUMERO CELULAR', data: 'numero_celular' },
                    { name: 'TELEFONO FIJO', data: 'numero_fijo' },
                    { name: 'DIRECCION', data: 'direccion' },
                    { name: 'COHORTE O PROGRAMA', data: 'cohorte_programa' },
                    { name: 'REGIMEN', data: 'regimen' },
                    { name: 'ESTADO', data: 'estado' },
                    { name: 'ASESOR', data: 'asesor' },
                    {
                        name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                            return `<button type="button" class="btn btn-primary btn-sm btnModalAsignarAgendamiento" idBolsaPaciente="${row.id_bolsa_paciente}" data-bs-toggle="modal" data-bs-target="#modalAsignarAgendamiento" title="Asignar Agendamiento"><i class="fas fa-user-plus"></i></button>`;
                        }
                    }
                ],
                ordering: false,
                ajax: {
                    url: 'ajax/di/agendamiento.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaAgendamientosBusqueda',
                        'tipoDocumento': tipoDocumento,
                        'numeroDocumento': numeroDocumento
                    }
                }
            
            })

        }else{

            toastr.warning("Los Formularios no se encuentran completamente diligenciados, por favor revisa.", "Error!");

        }

    }

}

$(document).on("click", ".btnModalAsignarAgendamiento", function(){

    let idBolsaPaciente = $(this).attr("idBolsaPaciente");
    console.log(idBolsaPaciente);

    let titleCard = document.querySelector('#modalAsignarAgendamientoLabel');
    titleCard.innerText = `Asignar Agendamiento #: ${idBolsaPaciente}`;
    
    $("#idBolsaPacienteAsignar").val(btoa(idBolsaPaciente));

})


const asignarAgendamiento = () => {

    let formulario = document.getElementById("formAsignarAgendamiento");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let idBolsaPaciente = document.getElementById('idBolsaPacienteAsignar').value;
            let usuarioAgendador = document.getElementById('usuarioAgendador').value;

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'asignarAgendamiento',
                    'idBolsaPaciente':idBolsaPaciente,
                    'usuarioAgendador': usuarioAgendador
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡El Agendamiento se asigno correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/buscaragendamiento';

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡Algo salio mal intentado asignar el Agendamiento al usuario!',
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

            toastr.warning("Debe seleccionar el Usuario Agendador.", "Error!");

        }

    }

}

function loadGoogleMaps(callback) {
  if (typeof google !== "undefined") {
    // Ya está cargado
    callback();
    return;
  }

  const script = document.createElement("script");
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCxYFphHDvKq2REnB0dqHU3APojarTZpgc";
  script.async = true;
  script.defer = true;
  script.onload = callback;
  document.head.appendChild(script);
}

tablaBasesAgendamientoPacientes = $('#tablaBasesAgendamientoPacientes').DataTable({
    columns: [
        { name: '#', data: 'id_base' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre_archivo' },
        { name: 'ARCHIVO', render: function(data, type, row){ 
            return '<a href="'+row.ruta_archivo+'" target="_blank"><span class="badge badge-phoenix badge-phoenix-success p-2"><i class="far fa-file-excel"></i> ARCHIVO CARGADO</span></a>'
        }
        },
        { name: 'CANTIDAD', data: 'cantidad'},
        { name: 'ESTADO', render: function(data, type, row){
            if(row.estado == 'SUBIDA'){

                return '<span class="badge badge-phoenix badge-phoenix-primary p-2">'+row.estado+'</span>';

            }else if(row.estado == 'ERROR' || row.estado == 'ERROR_CARGA'){

                return '<a href="'+row.ruta_archivo_errors+'" target="_blank" download><span class="badge badge-phoenix badge-phoenix-danger p-2"><i class="fas fa-file-download"></i> '+row.estado+'</span></a>';
                
            }else if(row.estado == 'CARGAR' || row.estado == 'VALIDANDO' || row.estado == 'CARGANDO'){
                
                return '<span class="badge badge-phoenix badge-phoenix-primary p-2">'+row.estado+'</span>';
                
            }else if(row.estado == 'CARGADO'){
                
                return '<span class="badge badge-phoenix badge-phoenix-success p-2">'+row.estado+'</span>';
                
            }
        } 
        },
        { name: 'USUARIO', data: 'usuario' },
        { name: 'FECHA CARGA', data: 'fecha_crea' },
    ],
    order: [[0, 'desc']],
    ajax: {
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'basesCargadasAgendamientoPacientes'
        }
    }
    

});

tablaProfesionalAgendamiento = $('#tablaProfesionalAgendamiento').DataTable({

    columns: [
        { name: '#', data: 'id_par_profesional' },
        { name: 'NOMBRE', data: 'nombre_profesional' },
        { name: 'NUMERO DOCUMENTO', data: 'doc_profesional' },
        { name: 'USUARIO', data: 'usuario' },
        { name: 'CARGO', data: 'cargo' },
    ],
    ordering: false,
    ajax: {
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaProfesionalesAgendamiento'
        }
    }

})


tablaComunicacionesFallidas = $("#tablaComunicacionesFallidas").DataTable({

    columns: [
        { name: 'ID', data: 'id_comunicacion_fallida' },
        { name: 'CAUSAL FALLIDA', data: 'causal_fallida' },
        { name: 'OBSERVACIONES', data: 'observaciones' },
        { name: 'USUARIO CREA', data: 'usuario_crea' },
        { name: 'FECHA CREA', data: 'fecha_crea' }
    ],
    ajax: {
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaComunicacionFallidasAgendamiento',
            'idAgendamiento': idAgendamiento
        }
    }

})

tablaUsuariosBolsaAgendamiento = $("#tablaUsuariosBolsaAgendamiento").DataTable({

    columns: [
        { name: '#', data: 'id_usu_bolsa_agend' },
        { name: 'NOMBRE', data: 'nombre' },
        { name: 'USUARIO', data: 'usuario' },
        { name: 'COHORTE', data: 'cohorte' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-danger btn-sm" onclick="eliminarAsignacionBolsaAgendamiento(${row.id_usu_bolsa_agend})" title="Eliminar Asignacion"><i class="fas fa-trash-alt"></i></button>`;
            }
        }
    ],
    ajax: {
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaAsignacionesBolsasAgendamiento',
        }
    }

})


/*========================
INFORMACION AGENDAMIENTO
========================*/
if(idAgendamiento){

    $.ajax({

        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'verInfoAgendamiento',
            'idAgendamiento': idAgendamiento
        },
        cache: false,
        dataType: "json",
        success:function(respuesta){

            // console.log(respuesta);

            $("#cantidadGestionesComuFallida").val(respuesta["contador_gestiones"]);
            $("#idBolsaPaciente").val(idAgendamiento);
            $("#textIdBolsaAgendamiento").html(idAgendamiento);
            $("#textFechaBase").html(respuesta["fecha_base"]);
            $("#textAgrupadorIps").html(respuesta["agrupador_ips"]);
            $("#textIps").html(respuesta["ips"]);
            $("#textNombrePaciente").html(respuesta["nombre_completo"]);
            $("#textEdadAnios").html(respuesta["edad_anios"]);

            $.ajax({
                url: 'ajax/parametricas.ajax.php',
                type: 'POST',
                data: {
                    'lista': 'verDatoParametrica',
                    'parametrica': 'sexo',
                    'dato': respuesta["sexo"]
                },
                cache: false,
                dataType: "json",
                success:function(respuestaSexo){

                    $("#textSexo").html(respuestaSexo["codigo"] + " - " + respuestaSexo["descripcion"]);

                }
            })

            $.ajax({
                url: 'ajax/parametricas.ajax.php',
                type: 'POST',
                data: {
                    'lista': 'verDatoParametrica',
                    'parametrica': 'tipoDocumento',
                    'dato': respuesta["tipo_doc"]
                },
                cache: false,
                dataType: "json",
                success:function(respuestaTipoDoc){

                    $("#textTipoDocumento").html(respuestaTipoDoc["tipo"] + ' - ' + respuestaTipoDoc["descripcion"]);

                }
            })
            
            $("#textTipoDocumento").html(respuesta["edad_meses"]);
            $("#textNumeroDocumento").html(respuesta["numero_documento"]);
            $("#textDocumentoMadre").html(respuesta["numero_documento_madre"]);
            $("#textNumeroCelular").html(respuesta["numero_celular"]);
            $("#textNumeroTelefono").html(respuesta["numero_fijo"]);
            $("#textDireccion").html(respuesta["direccion"]);
            $("#textCohortePrograma").html(respuesta["cohorte_programa"]);
            $("#cohortePrograma").val(respuesta["cohorte_programa"]);
            $("#textGrupoRiesgo").html(respuesta["grupo_riesgo"]);
            $("#textEquipoProfesional").html(respuesta["equipo_profesional"]);

            /*=====================================
            SE INSERTAN DATOS DE AGENDAMIENTO EN FORMULARIO PACIENTE
            ======================================*/

            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaTipoDocumento'
                },
            }).done(function (tipoDocPaciente) {
                $("#tipoDocPacienteAgen").html(tipoDocPaciente)
                $("#tipoDocPacienteAgen").val(respuesta["tipo_doc"]);
            })

            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaRegimenes'
                },
            }).done(function (regimenes) {
                $("#regimenPacienteAgen").html(regimenes)
                $("#regimenPacienteAgen").val(respuesta["regimen"]);
            })


            $("#numIdentificacionPaciente").val(respuesta["numero_documento"]);
            $("#priApellidoPaciente").val(respuesta["nombre_completo"]);

            let genero = '';

            if(respuesta["sexo"] == 'F'){

                genero = 'FEMENINO';

            }else if(respuesta["sexo"] == 'M'){

                genero = 'MASCULINO';

            }else{

                genero = 'INTERSEXUAL';

            }

            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaGenero'
                },
            }).done(function (generos) {
                $("#generoPacienteAgen").html(generos)
                $("#generoPacienteAgen").val(genero);
            })

            if(respuesta["edad_anios"]){

                $("#edadNPaciente").val(respuesta["edad_anios"]);

            }

            if(respuesta["numero_celular"]){

                $("#telefonoUnoPaciente").val(respuesta["numero_celular"]);

            }

            if(respuesta["numero_fijo"]){

                $("#telefonoDosPaciente").val(respuesta["numero_fijo"]);

            }

            if(respuesta["direccion"]){

                $("#direccionUbicacionPaciente").val(respuesta["direccion"]);

            }




            if(idPaciente){

                $.ajax({
        
                    url: 'ajax/config/pacientes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'mostrarInfoPacienteId',
                        'idPaciente': idPaciente,
                    },
                    cache: false,
                    dataType: "json",
                    success:function(respuesta){
                        
                        // console.log({respuesta});
                
                        $("#editNumIdentificacionPaciente").val(respuesta["numero_documento"]);
                        $("#editIdPaciente").val(respuesta["id_paciente"]);
                        $("#editExpDocPaciente").val(respuesta["expedido_en"]);
                        
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaTipoDocumento'
                            },
                        }).done(function (tipoDocPaciente) {
                            $("#editTipoDocPaciente").html(tipoDocPaciente)
                            $("#editTipoDocPaciente").val(respuesta["tipo_documento"]);
                        })
                
                
                        $("#editNumCarnetPaciente").val(respuesta["no_carnet"]);
                        $("#editPriApellidoPaciente").val(respuesta["primer_apellido"]);
                        $("#editSegApellidoPaciente").val(respuesta["segundo_apellido"]);
                        $("#editPriNombrePaciente").val(respuesta["primer_nombre"]);
                        $("#editSegNombrePaciente").val(respuesta["segundo_nombre"]);
                        $("#editSeudonimoPaciente").val(respuesta["seudonimo_paciente"]);
                        $("#editFechaNacimientoPaciente").val(respuesta["fecha_nacimiento"]);
                        $("#editEdadNPaciente").val(respuesta["edad_n"]);
                        $("#editEdadTPaciente").val(respuesta["edad_t"]);
                    
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaEstadoCivil'
                            },
                        }).done(function (estadoCivil) {
                            $("#editEstadoCivilPaciente").html(estadoCivil)
                            $("#editEstadoCivilPaciente").val(respuesta["estado_civil"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaGenero'
                            },
                        }).done(function (genero) {
                            $("#editGeneroPaciente").html(genero)
                            $("#editGeneroPaciente").val(respuesta["genero_paciente"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaEscolaridad'
                            },
                        }).done(function (escolaridad) {
                            $("#editEscolaridadPaciente").html(escolaridad)
                            $("#editEscolaridadPaciente").val(respuesta["escolaridad"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaVinculaciones'
                            },
                        }).done(function (vinculacion) {
                            $("#editVinculacionPaciente").html(vinculacion)
                            $("#editVinculacionPaciente").val(respuesta["vinculacion"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaOcupaciones'
                            },
                        }).done(function (ocupacion) {
                            $("#editOcupacionPaciente").html(ocupacion)
                            $("#editOcupacionPaciente").val(respuesta["ocupacion"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaGrupoPoblacional'
                            },
                        }).done(function (grupoPoblacion) {
                            $("#editGrupoPoblacionalPaciente").html(grupoPoblacion)
                            $("#editGrupoPoblacionalPaciente").val(respuesta["grupo_poblacional"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaPertenenciaEtnica'
                            },
                        }).done(function (pertenenciaEtnica) {
                            $("#editPertenenciaEtnicaPaciente").html(pertenenciaEtnica)
                            $("#editPertenenciaEtnicaPaciente").val(respuesta["pertenencia_etnica"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaRegimenes'
                            },
                        }).done(function (regimen) {
                            $("#editRegimenPaciente").html(regimen)
                            $("#editRegimenPaciente").val(respuesta["regimen"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaTipoUsuariosRips'
                            },
                        }).done(function (tipoUsuarioRips) {
                            $("#editTipoUsuRipsPaciente").html(tipoUsuarioRips)
                            $("#editTipoUsuRipsPaciente").val(respuesta["tipo_usuario_rips"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaTipoAfiliaciones'
                            },
                        }).done(function (tipoAfiliacion) {
                            $("#editTipoAfiliacionPaciente").html(tipoAfiliacion)
                            $("#editTipoAfiliacionPaciente").val(respuesta["tipo_afiliacion"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaEntidadesActuales'
                            },
                        }).done(function (entidad) {
                            $("#editEntidadAfActualPaciente").html(entidad)
                            $("#editEntidadAfActualPaciente").val(respuesta["entidad_af_actual"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaModCopagos'
                            },
                        }).done(function (modCopago) {
                            $("#editModCopagoPaciente").html(modCopago)
                            $("#editModCopagoPaciente").val(respuesta["mod_copago"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaCopagosFe'
                            },
                        }).done(function (copagoFe) {
                            $("#editCopagoFePaciente").html(copagoFe)
                            $("#editCopagoFePaciente").val(respuesta["copago_fe"]);
                        })
                
                        $("#editNivelSisbenPaciente").val(respuesta["nivel_sisben"]);
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaDepartamentos'
                            },
                        }).done(function (departamento) {
                            $("#editDepartamentoSisbenPaciente").html(departamento)
                            $("#editDepartamentoSisbenPaciente").val(respuesta["departamento_sisben"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaMunicipiosDepartamento',
                                'departamento': respuesta["departamento_sisben"]
                            },
                        }).done(function (municipio) {
                            $("#editMunicipioSisbenPaciente").html(municipio)
                            $("#editMunicipioSisbenPaciente").val(respuesta["municipio_sisben"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaSedesReclaMedicamentos'
                            },
                        }).done(function (sedeReclaMed) {
                            $("#editReclamaMedicamentosEnPaciente").html(sedeReclaMed)
                            $("#editReclamaMedicamentosEnPaciente").val(respuesta["sede_reclama_med"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaPaquetesAtencion'
                            },
                        }).done(function (sedeReclaMed) {
                            $("#editPaqueteAtencionPaciente").html(sedeReclaMed)
                            $("#editPaqueteAtencionPaciente").val(respuesta["paquete_atencion"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaNotificadosSivigila'
                            },
                        }).done(function (notificaSivigila) {
                            $("#editNotificadoSivigilaPaciente").html(notificaSivigila)
                            $("#editNotificadoSivigilaPaciente").val(respuesta["notifica_sivigila"]);
                        })
                
                        $("#editFechaNotificadoSivigilaPaciente").val(respuesta["fecha_notificacion_sivigila"]);
                        $("#editIpsNotificacionPaciente").val(respuesta["ips_notifica"]);
                        $("#editDireccionUbicacionPaciente").val(respuesta["direccion_ubicacion"]);
                        $("#editTelefonoUnoPaciente").val(respuesta["telefono_uno_ubicacion"]);
                        $("#editTelefonoDosPaciente").val(respuesta["telefono_dos_ubicacion"]);
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaZonas'
                            },
                        }).done(function (zona) {
                            $("#editZonaUbicacionPaciente").html(zona)
                            $("#editZonaUbicacionPaciente").val(respuesta["zona_ubicacion"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaDepartamentos'
                            },
                        }).done(function (departamento) {
                            $("#editDepartamentoUbicacionPaciente").html(departamento)
                            $("#editDepartamentoUbicacionPaciente").val(respuesta["departamento_ubicacion"]);
                        })
                
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaMunicipiosDepartamento',
                                'departamento': respuesta["departamento_ubicacion"]
                            },
                        }).done(function (municipio) {
                            $("#editMunicipioUbicacionPaciente").html(municipio)
                            $("#editMunicipioUbicacionPaciente").val(respuesta["municipio_ubicacion"]);
                        })
                
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/parametricas.ajax.php',
                            data: {
                                'lista': 'listaPaisesOrigen'
                            },
                        }).done(function (paisOrigen) {
                            $("#editPaisOrigenPaciente").html(paisOrigen)
                            $("#editPaisOrigenPaciente").val(respuesta["pais_origen"]);
                        })
                
                        $("#editCorreoPaciente").val(respuesta["correo"]);
                        $("#editNombreMadrePaciente").val(respuesta["nombre_madre"]);
                        $("#editNombrePadrePaciente").val(respuesta["nombre_padre"]);
                        $("#editResponsablePaciente").val(respuesta["responsable"]);
                        $("#editParentescoPaciente").val(respuesta["parentesco"]);
                        $("#editDireccionContactoPaciente").val(respuesta["direccion_contacto"]);
                        $("#editTelefonoContactoPaciente").val(respuesta["telefono_contacto"]);
                        $("#editPseudonimoPaciente").val(respuesta["psudonimo"]);
                        $("#editObservacionesContactoPaciente").val(respuesta["observacion_contacto"]);
                        $("#latitudUbicacion").val(respuesta["latitud_ubicacion"]);
                        $("#longitudUbicacion").val(respuesta["longitud_ubicacion"]);

                        console.log(respuesta);
                
                        // mostrarMapaUbicacion(respuesta["direccion_ubicacion"], respuesta["departamento_ubicacion"], respuesta["municipio_ubicacion"], respuesta["latitud_ubicacion"], respuesta["longitud_ubicacion"]);

                        loadGoogleMaps(() => {
                            mostrarMapaUbicacion(
                                respuesta["direccion_ubicacion"], 
                                respuesta["departamento_ubicacion"], 
                                respuesta["municipio_ubicacion"], 
                                respuesta["latitud_ubicacion"], 
                                respuesta["longitud_ubicacion"]
                            );
                        });

                        //CITAS PENDIENTES
                        $.ajax({

                            url: 'ajax/di/agendamiento.ajax.php',
                            type: 'POST',
                            data: {
                                'proceso': 'verCitasPendientesPaciente',
                                'idPaciente': respuesta["id_paciente"]
                            },
                            cache: false,
                            dataType: "json",
                            success:function(respuestaCitasPendientes){

                                let arrayCitasPendientes = respuestaCitasPendientes;

                                let cadena = '';

                                arrayCitasPendientes.forEach((cita) => {

                                    let badgedColor = 'badge-phoenix-primary';

                                    if(cita.franja_cita == 'AM'){

                                        badgedColor = 'badge-phoenix-warning';
                                        
                                    }

                                    cadena += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="badge badge-phoenix ${badgedColor}">Dia: ${cita.fecha_cita} - Franja: ${cita.franja_cita}</span>
                                        <span>${cita.motivo_cita}</span>
                                        <a class="btn btn-danger btn-sm" onclick="eliminarCita(${cita.id_cita},'${cita.motivo_cita}',${idAgendamiento},${idPaciente})"><i class="fas fa-trash-alt"></i></a>
                                    </li>`;

                                })

                                $("#contenedorCitasPendientesPaciente").html(cadena);

                            }

                        })
                
                    }
                
                })
                
        
            }

        }

    })


    /*==============================================
    CARGAR CALENDAR CUANDO SE SELECCIONA EL TAB CITA
    ==============================================*/
    let calendarEL = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEL, {
        themeSystem: 'bootstrap5',
        initialView: 'dayGridMonth',
        dayMaxEvents: true,
        locale: 'es',
        events: [],
        eventClick: function(info){

            $('#modalEvento').modal('show');
            $("#txtServicio").html(info.event.extendedProps.servicioCita);
            $("#textNombrePacienteCita").html(info.event.extendedProps.nombrePaciente);
            $("#textDocPaciente").html(info.event.extendedProps.documentoPaciente);
            $("#textEventMotivoCita").html(info.event.extendedProps.description);
            $("#textEventCohortePrograma").html(info.event.extendedProps.cohortePrograma);
            let badgedColor = 'badge-phoenix-primary';
            // badgedColor = info.event.extendedProps.franjaCita == 'AM' ? 'badge-phoenix-warning' : 'badge-phoenix-primary';
            badgedColor = info.event.extendedProps.franjaCita == 'AM' ? 'badge-phoenix-warning' : info.event.extendedProps.franjaCita  == 'PM' ? 'badge-phoenix-primary' : 'badge-phoenix-danger';
            $("#textEventFechaCita").html(`<span class="badge badge-phoenix ${badgedColor}">Dia: ${info.event.extendedProps.fechaCita} - Franja: ${info.event.extendedProps.franjaCita}</span>`);
            // const colorEstado = (info.event.extendedProps.estado === 'CREADA') ? 'badge-phoenix-warning' : (info.event.extendedProps.estado === 'PROCESO') ? 'badge-phoenix-primary' : 'badge-phoenix-success';
            const colorEstado = (info.event.extendedProps.estado === 'CREADA') ? 'badge-phoenix-warning' : (info.event.extendedProps.estado === 'PROCESO') ? 'badge-phoenix-primary' : (info.event.extendedProps.estado === 'NO-DISPONIBLE') ? 'badge-phoenix-danger' : 'badge-phoenix-success';
            $("#textEventEstado").html(`<span class="badge badge-phoenix ${colorEstado}">${info.event.extendedProps.estado}</span>`);
            $("#textEventObservacionesCita").html(info.event.extendedProps.observaciones);
            $("#textEventProfesional").html(info.event.title);
            $("#textEventLocalidad").html(info.event.extendedProps.localidadCita);

            //console.log(info.event);
            //console.log(info.event.extendedProps);
            //alert('Event: ' + info.event.title + ' Descripcion: ' + info.event.extendedProps.description);
            //alert('View: ' + info.view.type);
            //info.el.style.borderColor = 'red';
        }
    });

    $("#cita-tab").click(() => {
        $.ajax({
            url: 'ajax/di/agendamiento.ajax.php',
            type: 'POST',
            data: {
                proceso: 'listaCitasCalendar'
            },
            success: function (respuesta) {
                //console.log(respuesta);
                calendar.setOption('events', JSON.parse(respuesta));
                calendar.render();
            }
        });
    });

    $("#profesionalCita").change(() => {

        let idProfesional = document.getElementById('profesionalCita').value;

        //console.log(idProfesional);

        $.ajax({
            url: 'ajax/di/agendamiento.ajax.php',
            type: 'POST',
            data: {
                proceso: 'listaCitasCalendarProfesional',
                idProfesional: idProfesional
            },
            success: function (respuesta) {
                //console.log(respuesta);
                calendar.setOption('events', JSON.parse(respuesta));
                calendar.render();
            }
        });

    })

}

if(idCitaReAgendar){

    $.ajax({

        url: 'ajax/di/citas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'verInfoCita',
            'idCita': idCitaReAgendar
        },
        cache: false,
        dataType: "json",
        success:function(respuesta){

            // console.log(respuesta);
            $("#textMotivoCita").html(respuesta["motivo_cita"]);
            $("#fechaCita").val(respuesta["fecha_cita"]);
            $("#franjaCita").val(respuesta["franja_cita"]);
            $("#textLocalidad").html(respuesta["localidad_cita"]);
            $("#textObservacionCita").html(respuesta["observaciones_cita"]);
            $("#idCitaEditar").val(respuesta["id_cita"]);

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaProfesionalesAgenda'
                },
            }).done(function (profesionales) {
        
                $("#profesionalCitaEditar").html(profesionales);
                $("#profesionalCitaEditar").val(respuesta["id_profesional"]);
        
            })

            $.ajax({

                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaServiciosDI'
                },
            }).done(function (servicios) {
        
                $("#servicioCitaEditar").html(servicios);
                $("#servicioCitaEditar").val(respuesta["servicio_cita"]);
        
            })
        
        }

    })


    let calendarEL = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEL, {
        themeSystem: 'bootstrap5',
        initialView: 'dayGridMonth',
        dayMaxEvents: true,
        locale: 'es',
        events: [],
        eventClick: function(info){

            $('#modalEvento').modal('show');
            $("#textNombrePaciente").html(info.event.extendedProps.nombrePaciente);
            $("#textDocPaciente").html(info.event.extendedProps.documentoPaciente);
            $("#textEventMotivoCita").html(info.event.extendedProps.description);
            $("#textEventCohortePrograma").html(info.event.extendedProps.cohortePrograma);
            let badgedColor = 'badge-phoenix-primary';
            // badgedColor = info.event.extendedProps.franjaCita == 'AM' ? 'badge-phoenix-warning' : info.event.extendedProps.franjaCita  == 'PM' ? 'badge-phoenix-primary' : 'badge-phoenix-danger';
            badgedColor = info.event.extendedProps.franjaCita == 'AM' ? 'badge-phoenix-warning' : info.event.extendedProps.franjaCita  == 'PM' ? 'badge-phoenix-primary' : 'badge-phoenix-danger';
            $("#textEventFechaCita").html(`<span class="badge badge-phoenix ${badgedColor}">Dia: ${info.event.extendedProps.fechaCita} - Franja: ${info.event.extendedProps.franjaCita}</span>`);
            // const colorEstado = (info.event.extendedProps.estado === 'CREADA') ? 'badge-phoenix-warning' : (info.event.extendedProps.estado === 'PROCESO') ? 'badge-phoenix-primary' : 'badge-phoenix-success';
            const colorEstado = (info.event.extendedProps.estado === 'CREADA') ? 'badge-phoenix-warning' : (info.event.extendedProps.estado === 'PROCESO') ? 'badge-phoenix-primary' : (info.event.extendedProps.estado === 'NO-DISPONIBLE') ? 'badge-phoenix-danger' : 'badge-phoenix-success';
            $("#textEventEstado").html(`<span class="badge badge-phoenix ${colorEstado}">${info.event.extendedProps.estado}</span>`);
            $("#textEventObservacionesCita").html(info.event.extendedProps.observaciones);
            $("#textEventProfesional").html(info.event.title);
            $("#textEventLocalidad").html(info.event.extendedProps.localidadCita);

            //console.log(info.event);
            //console.log(info.event.extendedProps);
            //alert('Event: ' + info.event.title + ' Descripcion: ' + info.event.extendedProps.description);
            //alert('View: ' + info.view.type);
            //info.el.style.borderColor = 'red';
        }
    });


    $.ajax({
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaCitasCalendar'
        },
        success: function (respuesta) {
            //console.log(respuesta);
            calendar.setOption('events', JSON.parse(respuesta));
            calendar.render();
        }
    })

    $("#profesionalCita").change(() => {

        let idProfesional = document.getElementById('profesionalCita').value;

        //console.log(idProfesional);

        $.ajax({
            url: 'ajax/di/agendamiento.ajax.php',
            type: 'POST',
            data: {
                proceso: 'listaCitasCalendarProfesional',
                idProfesional: idProfesional
            },
            success: function (respuesta) {
                //console.log(respuesta);
                calendar.setOption('events', JSON.parse(respuesta));
                calendar.render();
            }
        });

    })


}

if(rutaValor == 'di/disponibilidadprofesional'){

    let calendarEL = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEL, {
        themeSystem: 'bootstrap5',
        initialView: 'dayGridMonth',
        dayMaxEvents: true,
        locale: 'es',
        events: [],
        eventClick: function(info){

            $('#modalEvento').modal('show');
            $("#textNombrePaciente").html(info.event.extendedProps.nombrePaciente);
            $("#textServicioCita").html(info.event.extendedProps.servicioCita);
            $("#textDocPaciente").html(info.event.extendedProps.documentoPaciente);
            $("#textEventMotivoCita").html(info.event.extendedProps.description);
            $("#textEventCohortePrograma").html(info.event.extendedProps.cohortePrograma);
            let badgedColor = 'badge-phoenix-primary';
            badgedColor = info.event.extendedProps.franjaCita == 'AM' ? 'badge-phoenix-warning' : info.event.extendedProps.franjaCita  == 'PM' ? 'badge-phoenix-primary' : 'badge-phoenix-danger';
            $("#textEventFechaCita").html(`<span class="badge badge-phoenix ${badgedColor}">Dia: ${info.event.extendedProps.fechaCita} - Franja: ${info.event.extendedProps.franjaCita}</span>`);
            const colorEstado = (info.event.extendedProps.estado === 'CREADA') ? 'badge-phoenix-warning' : (info.event.extendedProps.estado === 'PROCESO') ? 'badge-phoenix-primary' : (info.event.extendedProps.estado === 'NO-DISPONIBLE') ? 'badge-phoenix-danger' : 'badge-phoenix-success';
            $("#textEventEstado").html(`<span class="badge badge-phoenix ${colorEstado}">${info.event.extendedProps.estado}</span>`);
            $("#textEventObservacionesCita").html(info.event.extendedProps.observaciones);
            $("#textEventProfesional").html(info.event.title);
            $("#textEventLocalidad").html(info.event.extendedProps.localidadCita);

            $("#contenedorEliminarCitaDisponibilidad").html(`<a class="btn btn-warning btn-sm" onclick="eliminarCitaDisponibilidad(${info.event.extendedProps.idCita},'${info.event.extendedProps.description}')"><span class="fas fa-trash-alt"></span> Eliminar Cita</a>`);

            // console.log(info.event);
            // console.log(info.event.extendedProps);
            //alert('Event: ' + info.event.title + ' Descripcion: ' + info.event.extendedProps.description);
            //alert('View: ' + info.view.type);
            //info.el.style.borderColor = 'red';
        }
    });


    $.ajax({
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaCitasCalendar'
        },
        success: function (respuesta) {
            //console.log(respuesta);
            calendar.setOption('events', JSON.parse(respuesta));
            calendar.render();
        }
    })


    $("#profesionalCita").change(() => {

        let idProfesional = document.getElementById('profesionalCita').value;

        //console.log(idProfesional);

        $.ajax({
            url: 'ajax/di/agendamiento.ajax.php',
            type: 'POST',
            data: {
                proceso: 'listaCitasCalendarProfesional',
                idProfesional: idProfesional
            },
            success: function (respuesta) {
                //console.log(respuesta);
                calendar.setOption('events', JSON.parse(respuesta));
                calendar.render();
            }
        });

    })

}

if(rutaValor == 'di/citascalendario'){

    let calendarEL = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEL, {
        themeSystem: 'bootstrap5',
        initialView: 'dayGridMonth',
        dayMaxEvents: true,
        locale: 'es',
        events: [],
        eventClick: function(info){

            $('#modalEvento').modal('show');
            $("#textNombrePaciente").html(info.event.extendedProps.nombrePaciente);
            $("#textServicioCita").html(info.event.extendedProps.servicioCita);
            $("#textDocPaciente").html(info.event.extendedProps.documentoPaciente);
            $("#textEventMotivoCita").html(info.event.extendedProps.description);
            $("#textEventCohortePrograma").html(info.event.extendedProps.cohortePrograma);
            let badgedColor = 'badge-phoenix-primary';
            badgedColor = info.event.extendedProps.franjaCita == 'AM' ? 'badge-phoenix-warning' : info.event.extendedProps.franjaCita  == 'PM' ? 'badge-phoenix-primary' : 'badge-phoenix-danger';
            $("#textEventFechaCita").html(`<span class="badge badge-phoenix ${badgedColor}">Dia: ${info.event.extendedProps.fechaCita} - Franja: ${info.event.extendedProps.franjaCita}</span>`);
            const colorEstado = (info.event.extendedProps.estado === 'CREADA') ? 'badge-phoenix-warning' : (info.event.extendedProps.estado === 'PROCESO') ? 'badge-phoenix-primary' : (info.event.extendedProps.estado === 'NO-DISPONIBLE') ? 'badge-phoenix-danger' : 'badge-phoenix-success';
            $("#textEventEstado").html(`<span class="badge badge-phoenix ${colorEstado}">${info.event.extendedProps.estado}</span>`);
            $("#textEventObservacionesCita").html(info.event.extendedProps.observaciones);
            $("#textEventProfesional").html(info.event.title);
            $("#textEventLocalidad").html(info.event.extendedProps.localidadCita);

            $("#contenedorEliminarCitaDisponibilidad").html(`<a class="btn btn-warning btn-sm" onclick="eliminarCitaDisponibilidad(${info.event.extendedProps.idCita},'${info.event.extendedProps.description}')"><span class="fas fa-trash-alt"></span> Eliminar Cita</a>`);

            // console.log(info.event);
            // console.log(info.event.extendedProps);
            //alert('Event: ' + info.event.title + ' Descripcion: ' + info.event.extendedProps.description);
            //alert('View: ' + info.view.type);
            //info.el.style.borderColor = 'red';
        }
    });


    $.ajax({
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaCitasCalendar'
        },
        success: function (respuesta) {
            //console.log(respuesta);
            calendar.setOption('events', JSON.parse(respuesta));
            calendar.render();
        }
    })

    $("#profesionalCita").change(() => {

        let idProfesional = document.getElementById('profesionalCita').value;

        //console.log(idProfesional);

        $.ajax({
            url: 'ajax/di/agendamiento.ajax.php',
            type: 'POST',
            data: {
                proceso: 'listaCitasCalendarProfesional',
                idProfesional: idProfesional
            },
            success: function (respuesta) {
                //console.log(respuesta);
                calendar.setOption('events', JSON.parse(respuesta));
                calendar.render();
            }
        });

    })

}


if(rutaValor == 'di/bolsaagendamiento'){

    $.ajax({
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaBolsasAgendamientoUser',
            'userBolsa': userSession
        },
        cache: false,
        dataType: "json",
        success:function(bolsas){

            // console.log(bolsas);

            let containerBolsa = ``;

            bolsas.forEach(bolsa => {

                containerBolsa += `<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-primary">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Bolsa Agendamiento ${bolsa.cohorte}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablaBolsaAgendamiento${bolsa.id_cohorte_programa}" class="table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>IPS</th>
                                        <th>NOMBRE PACIENTE</th>
                                        <th>DOCUMENTO PACIENTE</th>
                                        <th>NUMERO CELULAR</th>
                                        <th>TELEFONO FIJO</th>
                                        <th>DIRECCION</th>
                                        <th>COHORTE O PROGRAMA</th>
                                        <th>REGIMEN</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>  
                    </div>
                </div>`;

            })
            
            $("#contenedorBolsasAgendamiendo").html(containerBolsa);

            bolsas.forEach(bolsa => {

                let cadena = `tablaBolsaAgendamiento${bolsa.id_cohorte_programa}`;

                cadena = $(`#${cadena}`).DataTable({

                    columns: [
                        { name: '#', data: 'id_bolsa_paciente' },
                        { name: 'IPS', data: 'ips' },
                        { name: 'NOMBRE PACIENTE', data: 'nombre_completo' },
                        { name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                            return row.tipo_doc + ' - ' + row.numero_documento;
                        } },
                        { name: 'NUMERO CELULAR', data: 'numero_celular' },
                        { name: 'TELEFONO FIJO', data: 'numero_fijo' },
                        { name: 'DIRECCION', data: 'direccion' },
                        { name: 'COHORTE O PROGRAMA', data: 'cohorte_programa' },
                        { name: 'REGIMEN', data: 'regimen' },
                        {
                            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                                return `<button type="button" class="btn btn-success btn-sm" onclick="tomarAgendamiento(${row.id_bolsa_paciente})" title="Tomar Agendamiento"><i class="fas fa-user-check"></i></button>`;
                            }
                        }
                    ],
                    ordering: false,
                    ajax: {
                        url: 'ajax/di/agendamiento.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'listaAgendamientoBolsa',
                            'cohortePrograma': bolsa.cohorte_programa
                        }
                    }
                
                })


            })

        }
    })


}


if(rutaValor == 'di/pendientesagendamiento'){

    $.ajax({
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaBolsasAgendamientoUser',
            'userBolsa': userSession
        },
        cache: false,
        dataType: "json",
        success:function(bolsas){

            // console.log(bolsas);

            let containerBolsa = ``;

            bolsas.forEach(bolsa => {

                containerBolsa += `<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
                    <div class="card-header p-4 border-bottom border-300 bg-primary">
                        <div class="row g-3 justify-content-between align-items-center">
                            <div class="col-12 col-md">
                                <h4 class="text-white mb-0">Pendientes Agendamiento ${bolsa.cohorte}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablaBolsaPendienteUser${bolsa.id_cohorte_programa}" class="table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>IPS</th>
                                        <th>NOMBRE PACIENTE</th>
                                        <th>DOCUMENTO PACIENTE</th>
                                        <th>NUMERO CELULAR</th>
                                        <th>TELEFONO FIJO</th>
                                        <th>DIRECCION</th>
                                        <th>COHORTE O PROGRAMA</th>
                                        <th>REGIMEN</th>
                                        <th>CANTIDAD GESTIONES</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>  
                    </div>
                </div>`;

            })

            $("#contenedorBolsasPendientesUserAgendamiendo").html(containerBolsa);

            bolsas.forEach(bolsa => {

                let cadena = `tablaBolsaPendienteUser${bolsa.id_cohorte_programa}`;

                cadena = $(`#${cadena}`).DataTable({

                    columns: [
                        { name: '#', data: 'id_bolsa_paciente' },
                        { name: 'IPS', data: 'ips' },
                        { name: 'NOMBRE PACIENTE', data: 'nombre_completo' },
                        { name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                            return row.tipo_doc + ' - ' + row.numero_documento;
                        } },
                        { name: 'NUMERO CELULAR', data: 'numero_celular' },
                        { name: 'TELEFONO FIJO', data: 'numero_fijo' },
                        { name: 'DIRECCION', data: 'direccion' },
                        { name: 'COHORTE O PROGRAMA', data: 'cohorte_programa' },
                        { name: 'REGIMEN', data: 'regimen' },
                        { name: 'CANTIDAD GESTIONES', data: 'contador_gestiones' },
                        {
                            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                                return `<button type="button" class="btn btn-success btn-sm" onclick="gestionarAgendamiento(${row.id_bolsa_paciente},${row.id_paciente})" title="Gestionar Agendamiento"><i class="far fa-play-circle"></i></button>`;
                            }
                        }
                    ],
                    ajax: {
                        url: 'ajax/di/agendamiento.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'listaAgendamientosPendienteUserCohorte',
                            'cohorte': bolsa.cohorte,
                            'user': userSession
                        }
                    }
                
                })

            })

        }

    })


}

if(rutaValor == 'di/agendarcitapaciente'){

    let calendarEL = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEL, {
        themeSystem: 'bootstrap5',
        initialView: 'dayGridMonth',
        dayMaxEvents: true,
        locale: 'es',
        events: [],
        eventClick: function(info){

            $('#modalEvento').modal('show');
            $("#textNombrePaciente").html(info.event.extendedProps.nombrePaciente);
            $("#textServicioCita").html(info.event.extendedProps.servicioCita);
            $("#textDocPaciente").html(info.event.extendedProps.documentoPaciente);
            $("#textEventMotivoCita").html(info.event.extendedProps.description);
            $("#textEventCohortePrograma").html(info.event.extendedProps.cohortePrograma);
            let badgedColor = 'badge-phoenix-primary';
            badgedColor = info.event.extendedProps.franjaCita == 'AM' ? 'badge-phoenix-warning' : info.event.extendedProps.franjaCita  == 'PM' ? 'badge-phoenix-primary' : 'badge-phoenix-danger';
            $("#textEventFechaCita").html(`<span class="badge badge-phoenix ${badgedColor}">Dia: ${info.event.extendedProps.fechaCita} - Franja: ${info.event.extendedProps.franjaCita}</span>`);
            const colorEstado = (info.event.extendedProps.estado === 'CREADA') ? 'badge-phoenix-warning' : (info.event.extendedProps.estado === 'PROCESO') ? 'badge-phoenix-primary' : (info.event.extendedProps.estado === 'NO-DISPONIBLE') ? 'badge-phoenix-danger' : 'badge-phoenix-success';
            $("#textEventEstado").html(`<span class="badge badge-phoenix ${colorEstado}">${info.event.extendedProps.estado}</span>`);
            $("#textEventObservacionesCita").html(info.event.extendedProps.observaciones);
            $("#textEventProfesional").html(info.event.title);
            $("#textEventLocalidad").html(info.event.extendedProps.localidadCita);

            $("#contenedorEliminarCitaDisponibilidad").html(`<a class="btn btn-warning btn-sm" onclick="eliminarCitaDisponibilidad(${info.event.extendedProps.idCita},'${info.event.extendedProps.description}')"><span class="fas fa-trash-alt"></span> Eliminar Cita</a>`);

            // console.log(info.event);
            // console.log(info.event.extendedProps);
            //alert('Event: ' + info.event.title + ' Descripcion: ' + info.event.extendedProps.description);
            //alert('View: ' + info.view.type);
            //info.el.style.borderColor = 'red';
        }
    });


    $.ajax({
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaCitasCalendar'
        },
        success: function (respuesta) {
            //console.log(respuesta);
            calendar.setOption('events', JSON.parse(respuesta));
            calendar.render();
        }
    })

    $("#profesionalCita").change(() => {

        let idProfesional = document.getElementById('profesionalCita').value;

        //console.log(idProfesional);

        $.ajax({
            url: 'ajax/di/agendamiento.ajax.php',
            type: 'POST',
            data: {
                proceso: 'listaCitasCalendarProfesional',
                idProfesional: idProfesional
            },
            success: function (respuesta) {
                //console.log(respuesta);
                calendar.setOption('events', JSON.parse(respuesta));
                calendar.render();
            }
        });

    })

}
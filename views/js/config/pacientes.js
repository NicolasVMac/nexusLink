/*==============================
VARIABLES DE RUTA
==============================*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

var idPaciente = atob(getParameterByName('idPaciente'));

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


/*==============================
CALCULAR EDAD Y GRUPO ETAREO
===============================*/
$("#fechaNacimientoPaciente").change(function(){

    let fechaNacimiento = $(this).val();
    let fechaActual = $(this).attr("fechaActual");
    let resultado = CalcularEdad(fechaNacimiento, fechaActual);

    let edadN = resultado.EdadN;
    let edadT = resultado.EdadT;

    $("#edadNPaciente").val(edadN);
    $("#edadTPaciente").val(edadT);


})

function CalcularEdad(fechaNacimiento, fechaActual){

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

function recargarMapa(){

    let direccionUbicacion = $("#editDireccionUbicacionPaciente").val();
    let departamentoUbicacion = $("#editDepartamentoUbicacionPaciente").val();
    let municipioUbicacion = $("#editMunicipioUbicacionPaciente").val();
    let lat = $("#latitudUbicacion").val();
    let lng = $("#longitudUbicacion").val();

    if (direccionUbicacion !== '' && departamentoUbicacion !== null && municipioUbicacion !== null && municipioUbicacion !== '') {
        
        mostrarMapaUbicacion(direccionUbicacion, departamentoUbicacion, municipioUbicacion, lat, lng)
    
    }else{

        console.log("Algo salio mal al recargar el mapa");

    }

}


function mostrarMapaUbicacion(direccionUbicacion, departamentoUbicacion, municipioUbicacion, lat, lng) {

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

            geocoder.geocode({
                "location": latlng
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

        }else{

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


$(".btnAgregarPaciente").click(function(){

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
            let tipoDocumento = $('#tipoDocPaciente').val();
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
            let generoPaciente = $('#generoPaciente').val();
            let escolaridadPaciente = $('#escolaridadPaciente').val();
            let vinculacionPaciente = $('#vinculacionPaciente').val();
            let ocupacionPaciente = $('#ocupacionPaciente').val();
            let grupoPoblacionalPaciente = $('#grupoPoblacionalPaciente').val();
            let pertenenciaEtnicaPaciente = $('#pertenenciaEtnicaPaciente').val();
            let regimenPaciente = $('#regimenPaciente').val();
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

            mostrarMapaUbicacion(direccionUbicacionPaciente, departamentoUbicacionPaciente, municipioUbicacionPaciente, latitudUbicacion, longitudUbicacion);

            //console.log(latitudUbicacion);
            //console.log(longitudUbicacion);

            if(latitudUbicacion !== "" && longitudUbicacion !== ""){

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

                        if(respuesta === 'ok'){

                            Swal.fire({
                                text: 'El Paciente se guardo correctamente',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) =>{

                                if(result.isConfirmed){

                                    window.location = 'index.php?ruta=config/pacientes';

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

})

var tablePacientes = $('#tablaPacientes').DataTable({
    columns: [
        { name: 'ID', data: 'id_paciente' },
        { name: 'NOMBRE', data: 'nombre_paciente_completo' },
        { name: 'NUMERO DOCUMENTO', data: 'numero_documento', render: $.fn.dataTable.render.number('.', ',', 0, '') },
        { name: 'EDAD', render: function(data, type, row){
            return row.edad_n + " " + row.edad_t
        } 
        },
        { name: 'CORREO', data: 'correo' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-sm btn-primary" onclick="btnRedireccionEditarPaciente(${row.id_paciente})" title="Editar Paciente" idPaciente="${row.id_paciente}"><i class="fa-solid fa-user-pen"></i></button>`;
            }
        }
    ],
    ajax: {
        url: 'ajax/config/pacientes.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPacientes',
        }
    }
    

});

function btnRedireccionEditarPaciente(idPaciente){

    window.location = 'index.php?ruta=config/editarpaciente&idPaciente='+btoa(idPaciente);

}

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
        
        //console.log(respuesta);

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

        mostrarMapaUbicacion(respuesta["direccion_ubicacion"], respuesta["departamento_ubicacion"], respuesta["municipio_ubicacion"], respuesta["latitud_ubicacion"], respuesta["longitud_ubicacion"]);

    }

})

/*==============================
CALCULAR EDAD Y GRUPO ETAREO
===============================*/
$("#editFechaNacimientoPaciente").change(function(){

    let fechaNacimiento = $(this).val();
    let fechaActual = $(this).attr("fechaActual");
    let resultado = CalcularEdad(fechaNacimiento, fechaActual);

    let edadN = resultado.EdadN;
    let edadT = resultado.EdadT;

    $("#editEdadNPaciente").val(edadN);
    $("#editEdadTPaciente").val(edadT);


})


const editarPaciente = () => {

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

                    //console.log(arrayDatosNuevos);

                    mostrarMapaUbicacion(arrayDatosNuevos.direccion_ubicacion, arrayDatosNuevos.departamento_ubicacion, arrayDatosNuevos.municipio_ubicacion, arrayDatosNuevos.latitud_ubicacion, arrayDatosNuevos.longitud_ubicacion);

                    let cambios = obtenerCambiosCamposEditarPaciente(respuesta, arrayDatosNuevos);

                    if(cambios.length === 0){

                        cambios.push('Ningun cambio');

                    }

                    //console.log('Cambios', cambios);

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

                            if(respuesta === 'ok'){

                                Swal.fire({
                                    text: 'El Paciente se guardo correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) =>{
    
                                    if(result.isConfirmed){
    
                                        window.location = 'index.php?ruta=config/pacientes';
    
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

const editarPacienteExt = () => {

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

                    //console.log(respuesta);
                    //console.log(arrayDatosNuevos);

                    //console.log(arrayDatosNuevos);

                    mostrarMapaUbicacion(arrayDatosNuevos.direccion_ubicacion, arrayDatosNuevos.departamento_ubicacion, arrayDatosNuevos.municipio_ubicacion, arrayDatosNuevos.latitud_ubicacion, arrayDatosNuevos.longitud_ubicacion);

                    let cambios = obtenerCambiosCamposEditarPaciente(respuesta, arrayDatosNuevos);

                    if(cambios.length === 0){

                        cambios.push('Ningun cambio');

                    }

                    //console.log('Cambios', cambios);

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

                            if(respuesta === 'ok'){

                                Swal.fire({
                                    text: 'El Paciente se guardo correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) =>{
    
                                    if(result.isConfirmed){
    
                                        location.reload();
    
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

function obtenerCambiosCamposEditarPaciente(array1, array2){

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

function validarExistenciaDocumento(){

    let tipoDocumento = document.getElementById("tipoDocPaciente").value;
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

                if(respuesta){

                    Swal.fire({
                        title: '¡El Paciente ya Existe!',
                        text: `El Tipo Documento y Numero Documento ya se encuentran registrados en el Paciente: ${respuesta.primer_nombre} ${respuesta.segundo_nombre} ${respuesta.primer_apellido} ${respuesta.segundo_apellido}`,
                        icon: 'info',
                        confirmButtonText: 'Cerrar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: "#d33",
                        confirmButtonText: "Cerrar"
                    })

                    $("#numIdentificacionPaciente").val('');

                }
            
            }

        })

    }

}
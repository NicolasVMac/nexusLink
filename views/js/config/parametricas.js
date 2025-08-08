$(document).ready(function(){

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaTipoDocumento'
        },
        success:function(respuesta){

            $("#tipoDocPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaEstadoCivil'
        },
        success:function(respuesta){

            $("#estadoCivilPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaGenero'
        },
        success:function(respuesta){

            $("#generoPaciente").html(respuesta);

        }

    })

    $.ajax({

		type: "POST",
		url: "ajax/parametricas.ajax.php",
		data: {
            'lista': 'listaDepartamentos'
        },
		success:function(respuesta){

			$("#departamentoSisbenPaciente").html(respuesta);

		}

	})

    $("#departamentoSisbenPaciente").change(function(){

		let departamento = $(this).val();
	
		$.ajax({

			type: "POST",
			url: "ajax/parametricas.ajax.php",
			data: {
                'lista': 'listaMunicipiosDepartamento',
                'departamento': departamento
            },
			success:function(respuesta){
	
				$("#municipioSisbenPaciente").html(respuesta);
	
			}
	
		})
	
	})

    $.ajax({

		type: "POST",
		url: "ajax/parametricas.ajax.php",
		data: {
            'lista': 'listaDepartamentos'
        },
		success:function(respuesta){

			$("#departamentoUbicacionPaciente").html(respuesta);

		}

	})

    $("#departamentoUbicacionPaciente").change(function(){

		let departamento = $(this).val();
	
		$.ajax({

			type: "POST",
			url: "ajax/parametricas.ajax.php",
			data: {
                'lista': 'listaMunicipiosDepartamento',
                'departamento': departamento
            },
			success:function(respuesta){
	
				$("#municipioUbicacionPaciente").html(respuesta);
	
			}
	
		})
	
	})


    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaEscolaridad'
        },
        success:function(respuesta){

            $("#escolaridadPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaVinculaciones'
        },
        success:function(respuesta){

            $("#vinculacionPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaOcupaciones'
        },
        success:function(respuesta){

            $("#ocupacionPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaGrupoPoblacional'
        },
        success:function(respuesta){

            $("#grupoPoblacionalPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaPertenenciaEtnica'
        },
        success:function(respuesta){

            $("#pertenenciaEtnicaPaciente").html(respuesta);

        }

    })


    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaRegimenes'
        },
        success:function(respuesta){

            $("#regimenPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaTipoUsuariosRips'
        },
        success:function(respuesta){

            $("#tipoUsuRipsPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaTipoAfiliaciones'
        },
        success:function(respuesta){

            $("#tipoAfiliacionPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaEntidadesActuales'
        },
        success:function(respuesta){

            $("#entidadAfActualPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaModCopagos'
        },
        success:function(respuesta){

            $("#modCopagoPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaCopagosFe'
        },
        success:function(respuesta){

            $("#copagoFePaciente").html(respuesta);

        }

    })


    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaSedesReclaMedicamentos'
        },
        success:function(respuesta){

            $("#reclamaMedicamentosEnPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaPaquetesAtencion'
        },
        success:function(respuesta){

            $("#paqueteAtencionPaciente").html(respuesta);

        }

    })


    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaNotificadosSivigila'
        },
        success:function(respuesta){

            $("#notificadoSivigilaPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaZonas'
        },
        success:function(respuesta){

            $("#zonaUbicacionPaciente").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaPaisesOrigen'
        },
        success:function(respuesta){

            $("#paisOrigenPaciente").html(respuesta);

        }

    })

    // $.ajax({

    //     type: "POST",
    //     url: "ajax/parametricas.ajax.php",
    //     data: {
    //         'lista': 'listaProyectos'
    //     },
    //     success:function(respuesta){

    //         $("#proyectos").html(respuesta);

    //     }

    // })



})
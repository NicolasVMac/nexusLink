$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaTipoDocumento'
    },
}).done(function (tipoDocPaciente) {
    $("#tipoDocPaciente").html(tipoDocPaciente);
    $("#tipoDocPeticionario").html(tipoDocPaciente);
    $("#tipoDocumentoTrabajador").html(tipoDocPaciente);
})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaRegimenes'
    },
}).done(function (regimenes) {
    $("#regimenEps").html(regimenes)
})

// $.ajax({
//     type: 'POST',
//     url: 'ajax/parametricas.ajax.php',
//     data: {
//         'lista': 'listaEpsPqr'
//     },
// }).done(function (eps) {
//     $("#epsPqr").html(eps)
// })

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaDepartamentos'
    },
    success:function(respuesta){

        $("#departamentoPeticionario").html(respuesta);

    }

})

$("#departamentoPeticionario").change(function(){

    let departamento = $(this).val();

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaMunicipiosDepartamento',
            'departamento': departamento
        },
        success:function(respuesta){

            $("#municipioPeticionario").html(respuesta);

        }

    })

})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaMediosRecepcionPqr'
    },
    success:function(respuesta){

        $("#medioRecepcionPqr").html(respuesta);

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

    }

})

// $.ajax({

//     type: "POST",
//     url: "ajax/parametricas.ajax.php",
//     data: {
//         'lista': 'listaClasificacionesAtributosPqr'
//     },
//     success:function(respuesta){

//         $("#clasificacionAtributoPqr").html(respuesta);

//     }

// })

// $.ajax({

//     type: "POST",
//     url: "ajax/pqr/pqr.ajax.php",
//     data: {
//         'proceso': 'listaGestoresPqr',
//         'tipo':'GESTOR'
//     },
//     success:function(respuesta){

//         $("#gestoresPqr").html(respuesta);

//     }

// })

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaRecursosPqr'
    },
    success:function(respuesta){

        $("#planAccionRecursos").html(respuesta);

    }

})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaProgramasPqr'
    },
    success:function(respuesta){

        $("#programaPqr").html(respuesta);

    }

})


$("#programaPqr").change(function(){

    let programa = $(this).val();

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaSedesPqr',
            'programa': programa
        },
        success:function(respuesta){

            $("#sedePqr").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaGestoresProgramaPqr',
            'programa': programa
        },
        success:function(respuesta){

            $("#gestoresPqr").html(respuesta);

        }

    })

})


$("#sedePqr").change(function(){

    let sede = $(this).val();

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaEpsSedePqr',
            'sede': sede
        },
        success:function(respuesta){

            $("#epsPqr").html(respuesta);

        }

    })

})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaEntesPqr'
    },
    success:function(respuesta){

        $("#enteReportePqr").html(respuesta);

    }

})

const obtenerAtributoClasificacion = () => {

    let motivoPQRSF = document.getElementById('motivoPqr').value;

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'infoMotivoPQRSF',
            'motivoPQRS': motivoPQRSF
        },
        dataType: "json",
        success:function(respuesta){

            $("#clasificacionAtributoPqr").val(respuesta.clasificacion_atributo);

        }

    })

}

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaPlanAccionQuienPqr'
    },
    success:function(respuesta){

        $("#planAccionQuien").html(respuesta);

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

    }

})
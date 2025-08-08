$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaTipoEquipoDg'
    },
}).done(function (tipoEquipos) {
    $("#dGTipoEquipo").html(tipoEquipos)
})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaSedesDg'
    },
}).done(function (sedes) {
    $("#dGSede").html(sedes)
})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaServiciosDg'
    },
}).done(function (servicios) {
    $("#dGServicio").html(servicios)
})


$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaClasificiacionBiomedicaDg'
    },
}).done(function (clasificacionBiomedicas) {
    $("#dGClasificacionBio").html(clasificacionBiomedicas)
})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaClasificiacionRiesgoDg'
    },
}).done(function (clasificacionesRiesgos) {
    $("#dGClasificacionRiesgo").html(clasificacionesRiesgos)
})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaTecnologiaPredoDt'
    },
}).done(function (tecnologiasPredo) {
    $("#dTTecnologiaPredo").html(tecnologiasPredo)
})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaFuenteAlimentacionDt'
    },
}).done(function (fuentesAlimen) {
    $("#dTFuenteAlimen").html(fuentesAlimen)
})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaCaracteristicasInstaDt'
    },
}).done(function (caracteristicasInsta) {
    $("#dTCaracteristicasInsta").html(caracteristicasInsta)
})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaTipoMantenimientos'
    },
}).done(function (tiposMantenimientos) {
    $("#tipoMantenimiento").html(tiposMantenimientos)
})
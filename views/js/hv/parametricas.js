$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaTipoDocumento'
    },
}).done(function (tipoDocPaciente) {
    $("#tipoDocumentoDp").html(tipoDocPaciente);
})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaNacionalidadHv'
    },
}).done(function (nacionalidades) {
    $("#nacionalidadDp").html(nacionalidades);
})


$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaSectorHv'
    },
}).done(function (sectores) {
    $("#sectorEL").html(sectores);
})
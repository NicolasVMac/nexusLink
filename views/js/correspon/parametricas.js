$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaResponsablesProyectosCorrespondencia'
    },
}).done(function (responsables) {

    $("#responsablesProyectos").html(responsables);

})

$.ajax({
    type: 'POST',
    url: 'ajax/correspon/proyectos.ajax.php',
    data: {
        'proceso': 'listaSelectProyectosCorrespondencia'
    },
}).done(function(proyectos){

    $("#proyectosCorrespondencia").html(proyectos);
    $("#nuevoProyectoCorresRec").html(proyectos);
    $("#proyectoCorresRecReAsignar").html(proyectos);

})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaDestinatarios'
    },
}).done(function (destinatarios) {

    $("#destinatarioRadCorres").html(destinatarios);

})
$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaEspecialidadesProfesional'
    },
}).done(function (especialidades) {
    $("#tipoEspecialidadProfesional").html(especialidades)
})

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaAuditoresAudProfesional'
    },
}).done(function (auditores) {
    $("#auditorAudProfesional").html(auditores)
})
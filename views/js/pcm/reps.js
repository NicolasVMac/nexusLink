let codigoHabilitacion; // Declara la variable fuera del scope del AJAX


try {
    idReclamacion = atob(getParameterByName('idReclamacion'));
} catch (error) {
    console.error("Error decodificando la cadena: ", error);
    Swal.fire({
        text: 'Error de perfil, Sera direccionado al inicio',
        icon: 'error',
        confirmButtonText: 'Continuar',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "inicio";
        }
    });
}

$.ajax({
    url: 'ajax/pcm/auditoria.ajax.php',
    type: 'POST',
    data: {
        'option': 'reclamacionInfo',
        'idReclamacion': idReclamacion
    },
    dataType: 'json',
    success: function (respuesta) {
        codigoHabilitacion = respuesta["Codigo_Habilitacion"]; 
        console.log(codigoHabilitacion);
    },
    error: function (xhr, status, error) {
        console.error("Error en la solicitud AJAX: ", status, error);
    }
});

console.log(codigoHabilitacion); 

$('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {

    console.log(codigoHabilitacion); 

    var target = $(e.target).attr("href"); // Obtiene el id de la pestaña activa
    if (target === "#Reps") {
        var tableReps = $('#tableReps').DataTable({
            destroy: true,
            pageLength: 50,
            columns: [
                { name: 'Departamento', data: 'departamento_prestador' },
                { name: 'Municipio', data: 'municipio_prestador' },
                { name: 'Razon Social', data: 'nombreprestador' },
                { name: 'NIT', data: 'nit'},
                { name: 'Codigo Sede', data: 'codigo_habilitacion' },
                { name: 'Fecha Apertura Prestador', data: 'fecha_apertura_prestador' },
                { name: 'Fecha Cierre Prestador', data: 'fecha_cierre_prestador' },
                { name: 'Grupo Servicio', data: 'grupo_servicio' },
                { name: 'Codigo Servicio', data: 'serv_codigo' },
                { name: 'Nombre Servicio', data: 'nombre_servicio' },
                { name: 'Fecha Apertura Servicio', data: 'fecha_apertura_servicio' },
                { name: 'Fecha Cierre Servicio', data: 'fecha_cierre_servicio' },

               
            ],
            ajax: {
                url: 'ajax/pcm/reps.ajax.php',
                type: 'POST',
                data: {
                    'option': 'repsInfo',
                    'codigoHabilitacion': codigoHabilitacion
                }
            }
        });
        //tableReclaHistorico.draw(); // Redibuja la tabla cuando la pestaña "Historicos" esté activa
    }
});




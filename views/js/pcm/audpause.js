function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

try {
    $('#card-header-title-audit-pause').html('Cuentas en pausa - ' + idProfile + ' - Usuario: ' + sessionUser);
    $('#card-header-title-audit-devolution-cal').html('Cuentas Devolucion Calidad - '+ idProfile + ' - Usuario: ' + sessionUser);
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
    })

}


var tableAuditPause = $('#tableAuditPause').DataTable({
    columns: [
        { name: 'Reclamacion Id', data: 'Reclamacion_Id' },
        { name: 'Proveedor', data: 'Razon_Social_Reclamante' },
        { name: 'Numero Factura', data: 'Numero_Factura' },
        {
            name: 'Valor',
            data: 'Total_Reclamado',
            render: function (data, type, row) {
                if (type === 'display') {
                    return '$ ' + $.fn.dataTable.render.number('.', ',', 2, '').display(data);
                }
                return data;
            }
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `<button type="button" class="btn btn-round btn-outline-info btAuditStart" title="Iniciar ${idProfile}" idReclamacion="${row.Reclamacion_Id}" codEntrada="${row.Codigo_Entrada}"><i class="fa-solid fa-play"></i></button>`;

            }
        }
    ],
    ajax: {
        url: 'ajax/pcm/auditoria.ajax.php',
        type: 'POST',
        data: {
            'option': 'auditoriaPausa',
            'perfil': idProfile,
            'usuario': sessionUser
        }
    },
    bFilter: true,
    bPaginate: false,

});

$(document).on("click", ".btAuditStart", function () {
    var idReclamacion = $(this).attr('idReclamacion');
    var codEntrada = $(this).attr('codEntrada');

    //alert ('hola mundo, a iniciar auditoria '+idProfile+idCuenta);

    window.location = "index.php?ruta=pcm/audstart&idPerfil=" + btoa(idProfile) + "&idReclamacion=" + btoa(idReclamacion)+ "&codEntrada=" +btoa(codEntrada);;
})
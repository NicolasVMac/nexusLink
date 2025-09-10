try {
    const idReclamacion = atob(getParameterByName('idReclamacion'));
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

$('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href"); // Obtiene el id de la pestaña activa
    if (target === "#Historicos") {
        var tableReclaHistorico = $('#tableReclaHistorico').DataTable({
            destroy: true,
            pageLength: 50,
            columns: [
                { name: 'Reclamacion Id', data: 'Reclamacion_ID' },
                { name: 'Num Factura', data: 'Numero_Factura' },
                { name: 'Evento', data: 'Fecha_Hora_Evento' },
                { name: 'Prestador', data: 'Razon_Social_Reclamante' },
                {
                    name: 'Vl Reclamado',
                    data: 'Total_Reclamado',
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return '$ ' + $.fn.dataTable.render.number('.', ',', 2, '').display(data);
                        }
                        return data;
                    }
                },
                {
                    name: 'Vl Glosado',
                    render: function (data, type, row) {
                        var totalReclamado = row.Total_Reclamado ? row.Total_Reclamado : 0;
                        var totalAprobado = row.Total_Aprobado ? row.Total_Aprobado : 0;
                        var valorGlosado = totalReclamado - totalAprobado;

                        if (type === 'display') {
                            return '$ ' + $.fn.dataTable.render.number('.', ',', 2, '').display(valorGlosado);
                        }
                        return valorGlosado;
                    }
                },
                {
                    name: 'Vl Aprobado',
                    data: 'Total_Aprobado',
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return '$ ' + $.fn.dataTable.render.number('.', ',', 2, '').display(data);
                        }
                        return data;
                    }
                },
                {
                    name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                        if (row.Numero_Paquete !== 'Historico') {
                            return `
                                <button type="button" class="btn btn-round btn-primary btnVerSoportesHisto" onclick="openWindowImgPaq('${row.Codigo_Entrada}','${row.Numero_Paquete}')" title="Ver Soportes."><i class="fa-solid fa-file-pdf"></i></button>
                            `;
                        }else{

                            return `
                                <button type="button" class="btn btn-round btn-primary btnVerSoportesHisto" onclick="openWindowImgHist('${row.Codigo_Entrada}')" title="Ver Soportes"><i class="fa-solid fa-file-pdf"></i></button>
                            `;
                        }
                    }
                }
            ],
            ajax: {
                url: 'ajax/pcm/historico.ajax.php',
                type: 'POST',
                data: {
                    'option': 'historicosEvento',
                    'idReclamacion': idReclamacion
                }
            }
        });
        //tableReclaHistorico.draw(); // Redibuja la tabla cuando la pestaña "Historicos" esté activa
    }
});

function openWindowImgHist(imgHisCod) {
    let numeroPaquete = document.getElementById('numeroPaquete').value;
    // var url = "index.php?ruta=imgview&codImg=" + btoa(imgHisCod)+"&type=history";
    var url = "index.php?ruta=pcm/imgview&codImg=" + btoa(imgHisCod)+"&type=history&numPaq="+numeroPaquete.toLowerCase();
    var win = window.open(url, '_blank');
    win.focus();
}

function openWindowImgPaq(codEntrada, numeroPaquete) {
    //let numeroPaquete = document.getElementById('numeroPaquete').value;
    var url = "index.php?ruta=pcm/imgview&codImg=" + btoa(codEntrada)+"&type=new&numPaq="+numeroPaquete.toLowerCase();
    var win = window.open(url, '_blank');
    win.focus();
}

function openWindowGestionRecla(codEntrada, numeroPaqueteH,Reclamacion_ID,tipo){
    let numeroPaquete = document.getElementById('numeroPaquete').value;
    var url = "index.php?ruta=historicosGestion&idPerfil=" + btoa(idProfile) + "&idReclamacion=" + btoa(Reclamacion_ID)+ "&codEntrada=" +btoa(codEntrada)+"&type=new&numPaq="+numeroPaquete.toLowerCase()+ "&tipo=" + tipo;
    var win = window.open(url, '_blank');
    win.focus();
}
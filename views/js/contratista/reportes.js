const mostrarReporte = (rutaReporte) => {

    window.location = `index.php?ruta=contratistas/reporteview&rutaReporte=${btoa(rutaReporte)}`;

}

const idAdminContrato = async (idContratista, idContrato) => {

    window.location = 'index.php?ruta=contratistas/admincontratocontratista&idContratista='+btoa(idContratista)+'&idContrato='+btoa(idContrato);

}

const generarTablaContratos = (tipo) => {

    let containerTableContratos = document.querySelector('.containerTableContratos');

    containerTableContratos.style.display = 'block';

    $('#listaEstadoContratos').DataTable({

        columns: [
            { name: '#', data: 'id_contrato' },
            { name: 'TIPO CONTRATISTA', data: 'tipo_contratistas' },
            { name: 'CONTRATISTA', data: 'nombre_contratistas' },
            { name: 'IDENTIFICACION CONTRATISTA', data: 'contratista_identificacion' },
            { name: 'TIPO CONTRATO', data: 'tipo_contrato' },
            { name: 'NOMBRE CONTRATO', data: 'nombre_contrato' },
            { name: 'VIGENCIA', render: function(data, type, row){
                return `<span class="badge badge-phoenix badge-phoenix-success">${row.fecha_inicio}</span> - <span class="badge badge-phoenix badge-phoenix-danger">${row.fecha_fin_real}</span>`;
            }},
            {
                name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                    return `<button type="button" class="btn btn-success btn-sm" onclick="idAdminContrato(${row.id_contratista},${row.id_contrato})" title="Gestionar Contrato"><i class="far fa-folder"></i></button>`;
                }
            }
        ],
        ordering: false,
        destroy: true,
        ajax: {
            url: 'ajax/contratistas/reportes-contratistas.ajax.php',
            type: 'POST',
            data: {
                'proceso': 'listaEstadoContratos',
                'tipo': tipo
            }
        }

    })

}

const generarTablaPolizas = (tipo) => {

    let containerTablePolizas = document.querySelector('.containerTablePolizas');

    containerTablePolizas.style.display = 'block';

    $('#listaEstadoPolizas').DataTable({

        columns: [
            { name: '#', data: 'id_poliza' },
            { name: 'TIPO CONTRATO', data: 'tipo_contrato' },
            { name: 'NOMBRE CONTRATO', data: 'nombre_contrato' },
            { name: 'ASEGURADORA', data: 'aseguradora' },
            { name: 'TIPO POLIZA', data: 'tipo_poliza' },
            { name: 'NUMERO POLIZA', data: 'numero_poliza' },
            { name: 'AMPARO', data: 'amparo' },
            { name: 'VIGENCIA', render: function(data, type, row){
                return `<span class="badge badge-phoenix badge-phoenix-success">${row.fecha_inicio}</span> - <span class="badge badge-phoenix badge-phoenix-danger">${row.fecha_fin}</span>`;
            }},
            {
                name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                    return `<button type="button" class="btn btn-success btn-sm" onclick="idAdminContrato(${row.id_contratista},${row.id_contrato})" title="Gestionar Contrato"><i class="far fa-folder"></i></button>`;
                }
            }
        ],
        ordering: false,
        destroy: true,
        ajax: {
            url: 'ajax/contratistas/reportes-contratistas.ajax.php',
            type: 'POST',
            data: {
                'proceso': 'listaEstadoPolizas',
                'tipo': tipo
            }
        }

    })

}

tablaReportesContratistas = $('#tablaReportesContratistas').DataTable({

    columns: [
        { name: '#', data: 'id_reporte' },
        { name: 'NOMBRE REPORTE', data: 'nombre_reporte' },
        { name: 'DESCRIPCION', data: 'descripcion_reporte' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-success btn-sm" onclick="mostrarReporte('${row.ruta_reporte}')" title="Ver Reporte"><i class="fas fa-chart-area"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/contratistas/reportes-contratistas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaReportesContratistas',
        }
    }

})

estadoProcesoContratos = $('#estadoProcesoContratos').DataTable({

    columns: [
        { name: 'CONTRATOS VENCIDOS', data: 'CANTIDAD_VENCIDO' },
        { name: 'CONTRATOS 1 - 30 DIAS A VENCER', data: 'CANTIDAD_MES_VENCIMIENTO' },
        { name: 'CONTRATOS 31 - 59 DIAS VENCER', data: 'CANTIDAD_MESES_VENCIMIENTO' },
        { name: 'CONTRATOS FUTUROS', data: 'CANTIDAD_FUTURO_VENCEN' },
    ],
    ordering: false,
    ajax: {
        url: 'ajax/contratistas/reportes-contratistas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'estadoProcesoContratos',
        }
    }
})

estadoProcesoPolizas = $('#estadoProcesoPolizas').DataTable({

    columns: [
        { name: 'POLIZAS VENCIDOS', data: 'CANTIDAD_VENCIDO' },
        { name: 'POLIZAS 1 - 30 DIAS A VENCER', data: 'CANTIDAD_MES_VENCIMIENTO' },
        { name: 'POLIZAS 31 - 59 DIAS VENCER', data: 'CANTIDAD_MESES_VENCIMIENTO' },
        { name: 'POLIZAS FUTUROS', data: 'CANTIDAD_FUTURO_VENCE' },
    ],
    ordering: false,
    ajax: {
        url: 'ajax/contratistas/reportes-contratistas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'estadoProcesoPolizas',
        }
    }
})
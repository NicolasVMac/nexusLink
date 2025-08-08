let tablaReportesVIH;
let tablaReportesAutoinmunes;
let tablaReportesProfesional;


const mostrarReporte = (tipoEncuesta, rutaReporte) => {

    window.location = `index.php?ruta=encuestas/reporteview&tipoEncuesta=${btoa(tipoEncuesta)}&rutaReporte=${btoa(rutaReporte)}`;

}

const mostrarReporteProfesional = (rutaReporte) => {

    window.location = `index.php?ruta=encuestas/reporteviewprofesional&rutaReporte=${btoa(rutaReporte)}`;

}

tablaReportesVIH = $('#tablaReportesVIH').DataTable({

    columns: [
        { name: '#', data: 'id_encu_reporte' },
        { name: 'TIPO ENCUESTA', data: 'tipo_encuesta' },
        { name: 'NOMBRE REPORTE', data: 'nombre_reporte' },
        { name: 'DESCRIPCION', data: 'descripcion_reporte' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-success btn-sm" onclick="mostrarReporte('${row.tipo_encuesta}','${row.ruta_reporte}')" title="Ver Reporte"><i class="fas fa-chart-area"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/encuestas/reportes.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaReportesEncuestas',
            'tipoEncuesta': 'VIH'
        }
    }

})

tablaReportesAutoinmunes = $('#tablaReportesAutoinmunes').DataTable({

    columns: [
        { name: '#', data: 'id_encu_reporte' },
        { name: 'TIPO ENCUESTA', data: 'tipo_encuesta' },
        { name: 'NOMBRE REPORTE', data: 'nombre_reporte' },
        { name: 'DESCRIPCION', data: 'descripcion_reporte' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-success btn-sm" onclick="mostrarReporte('${row.tipo_encuesta}','${row.ruta_reporte}')" title="Ver Reporte"><i class="fas fa-chart-area"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/encuestas/reportes.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaReportesEncuestas',
            'tipoEncuesta': 'AUTOINMUNES'
        }
    }

})

tablaReportesProfesional = $('#tablaReportesProfesional').DataTable({

    columns: [
        { name: '#', data: 'id_encu_reporte' },
        { name: 'NOMBRE REPORTE', data: 'nombre_reporte' },
        { name: 'DESCRIPCION', data: 'descripcion_reporte' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-success btn-sm" onclick="mostrarReporteProfesional('${row.ruta_reporte}')" title="Ver Reporte"><i class="fas fa-chart-area"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/encuestas/reportes-profesional.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaReportesEncuestasProfesional',
        }
    }

})
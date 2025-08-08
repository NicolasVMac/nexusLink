function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let url = new URL(window.location.href);
let rutaValor = url.searchParams.get("ruta");

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: { lista: 'listaSedesPamec' },
    success: (resp) => {
        $('#selectSedes').html(resp);
    }
});

$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: { lista: 'listaPeriodosPamec' },
    success: (resp) => {
        $('#selectPeriodo').html(resp);
    }
});

const revisarAvanceEstandaresEvaluados = () => {
    const cardResultado = document.querySelector("#cardSubGruposEstandares");
    const cardResultadoGrupo = document.querySelector("#cardGruposEstandares");

    let formulario = document.getElementById("formSeleccionarSede");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });


    if (errores === 0) {

        if (formulario.checkValidity()) {
            cardResultado.style.display = 'block';
            cardResultadoGrupo.style.display = 'block';

            let form = document.querySelector('#formSeleccionarSede');
            const formData = new FormData(form);
            formData.append('proceso', 'listarSubgruposEstandares');

            // for (const [key, value] of formData) {
            //     console.log(key, value);
            // }

            let tablaSubGruposEstandares = $('#tablaSubGruposEstandares').DataTable({

                columns: [
                    { name: 'Subgrupo de Estándares', data: 'subgrupo' },
                    { name: 'Rango Estándar', data: 'rango_estandar' },
                    { name: '# Estándares', data: 'numero_estandares' },
                    { name: '# Criterios', data: 'numero_criterios' },
                    { name: 'NA', data: 'na' },
                    { name: 'A', data: 'a' },
                    { name: 'EP', data: 'ep' },
                    { name: 'C', data: 'c' },
                    { name: '%', data: 'porcentaje' },
                    { name: 'Pendientes', data: 'pendientes' },
                ],

                columnDefs: [
                    { targets: [0, 9], orderable: false }
                ],
                ordering: false,
                dom: 'Bfrtip',
                destroy: true,
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ],
                ajax: {
                    url: 'ajax/pamec/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listarSubgruposEstandares',
                        'selectSedes': formData.get('selectSedes'),
                        'selectPeriodo': formData.get('selectPeriodo')
                    },
                }

            })

            let tablaGruposEstandares = $('#tablaGruposEstandares').DataTable({

                columns: [
                    { name: 'Grupos', data: 'grupo' },
                    { name: 'Rango Estándar', data: 'rango_estandar' },
                    { name: '# Estándares', data: 'numero_estandares' },
                    { name: '# Criterios', data: 'numero_criterios' },
                    { name: 'NA', data: 'na' },
                    { name: 'A', data: 'a' },
                    { name: 'EP', data: 'ep' },
                    { name: 'C', data: 'c' },
                    { name: '%', data: 'porcentaje' },
                    { name: 'Pendientes', data: 'pendientes' },
                ],

                columnDefs: [
                    { targets: [0, 9], orderable: false }
                ],
                ordering: false,
                dom: 'Bfrtip',
                destroy: true,
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ],
                ajax: {
                    url: 'ajax/pamec/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listargruposEstandares',
                        'selectSedes': formData.get('selectSedes'),
                        'selectPeriodo': formData.get('selectPeriodo')

                    },
                }

            })

        } else {

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }

    }


}

const cargarGraficoEstados = () => {
    $.ajax({
        type: 'POST',
        url: 'ajax/pamec/reportes.ajax.php',
        data: { proceso: 'conteoEstadosAutoevaluacion' },
        dataType: 'json',
        success: (resp) => {
            const categorias = ['NO APLICA', 'PENDIENTE', 'PROCESO', 'TERMINADO'];
            const valores = [
                parseInt(resp.no_aplica ?? 0),
                parseInt(resp.pendiente ?? 0),
                parseInt(resp.proceso ?? 0),
                parseInt(resp.terminado ?? 0)
            ];

            Highcharts.chart('containerEstados', {
                chart: { type: 'column' },
                title: { text: 'Estado de las autoevaluaciones' },
                xAxis: { categories: categorias, crosshair: true },
                yAxis: {
                    min: 0,
                    title: { text: 'Número de autoevaluaciones' }
                },
                tooltip: { pointFormat: '<b>{point.y}</b>' },
                plotOptions: {
                    column: { pointPadding: 0.2, borderWidth: 0, colorByPoint: true }
                },
                series: [
                    {
                        name: 'Autoevaluaciones',
                        data: valores
                    }
                ]
            });
        },
    });
};

const cargarGraficoEstandaresSede = () => {
    $.ajax({
        type: 'POST',
        url: 'ajax/pamec/reportes.ajax.php',
        data: { proceso: 'conteoEstandaresPorSede' },
        dataType: 'json',
        success: (resp) => {
            const categorias = resp.map(r => r.sede);
            const valores = resp.map(r => parseInt(r.cantidad, 10));

            Highcharts.chart('containerEstandaresSedes', {
                chart: { type: 'column' },
                title: { text: 'Estándares evaluados por sede' },
                xAxis: { categories: categorias, crosshair: true },
                yAxis: {
                    min: 0,
                    title: { text: 'Número de estándares evaluados' }
                },
                tooltip: { pointFormat: '<b>{point.y}</b> estándares' },
                plotOptions: {
                    column: { pointPadding: 0.2, borderWidth: 0, colorByPoint: true }
                },
                series: [
                    {
                        name: 'Estándares',
                        data: valores
                    }
                ]
            });
        },
    });
};

const cargarGraficoEstadosPorSede = () => {
    $.ajax({
        type: 'POST',
        url: 'ajax/pamec/reportes.ajax.php',
        data: { proceso: 'conteoEstadosPorSede' },
        dataType: 'json',
        success: (resp) => {
            const categorias = resp.map(r => r.sede);

            const series = [
                { name: 'NO APLICA', data: resp.map(r => parseInt(r.no_aplica, 10)) },
                { name: 'PENDIENTE', data: resp.map(r => parseInt(r.pendiente, 10)) },
                { name: 'PROCESO', data: resp.map(r => parseInt(r.proceso, 10)) },
                { name: 'TERMINADO', data: resp.map(r => parseInt(r.terminado, 10)) }
            ];

            Highcharts.chart('containerEstadosPorSede', {
                chart: { type: 'column' },
                title: { text: 'Autoevaluaciones por estado y sede' },
                xAxis: { categories: categorias, crosshair: true },
                yAxis: {
                    min: 0,
                    title: { text: 'Número de autoevaluaciones' }
                },
                tooltip: {
                    shared: true,
                    pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: <b>{point.y}</b><br/>'
                },
                plotOptions: {
                    column: { pointPadding: 0.1, borderWidth: 0 }
                },
                series: series
            });
        },
        error: (xhr) => {
            console.error('Error al cargar estados por sede:', xhr.responseText);
        }
    });
};



if (rutaValor == 'pamec/inicio') {

    let proyecto = 'pamec';

    tablaAvanceEstandares = $('#tablaAvanceEstandares').DataTable({
        columns: [
            {
                name: 'SEDE',
                orderable: false,
                render: function (data, type, row) {
                    return `<span class="badge badge-phoenix fs--2 badge-phoenix-info me-1"><span class="badge-label">${row.sede}</span></span>`;
                }
            },
            {
                name: 'ESTANDARES',
                orderable: false,
                render: function (data, type, row) {
                    if (!row.estandares) return '';
                    if (row.estandares != 'NO HAY ESTANDARES EVALUADOS') {
                        let estandaresArr = row.estandares.split(',');
                        let badges = estandaresArr.map((estandares) => {
                            let estandaresTrim = estandares.trim();
                            return `<span class="badge badge-phoenix fs--2 badge-phoenix-success me-1"><span class="badge-label">${estandaresTrim}</span></span>`;
                        }).join('');
                        return badges;
                    } else {
                        return `<span class="badge badge-phoenix fs--2 badge-phoenix-danger me-1"><span class="badge-label">${row.estandares}</span></span>`;
                    }

                }
            },
        ],
        ordering: false,
        ajax: {
            url: 'ajax/pamec/reportes.ajax.php',
            type: 'POST',
            data: { 'proceso': 'listaEstandarEvaluadoSedes' }
        }
    });
    cargarGraficoEstados();
    cargarGraficoEstandaresSede();
    cargarGraficoEstadosPorSede();
    cargarHeatmapEstandaresSede();
}
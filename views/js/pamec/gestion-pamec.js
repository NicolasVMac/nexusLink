
function getParameterByName(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)'),
        result = regex.exec(location.search);
    return result === null ? '' : decodeURIComponent(result[1].replace(/\+/g, ' '));
}



/*
2. VARIABLES GLOBALES
*/
let idPriorizacion = atob(getParameterByName('idPrio'));
let url2 = new URL(window.location.href);
let paramidPrio = url2.searchParams.get("idPrio");
let ruta = url2.searchParams.get("ruta");
let tablaCalidadEsperada;
let tablaCalidadObservada;

const coloresAvance = {
    completo: '#d1ffb9', // verde claro
    incompleto: '#ff9f9f'  // rojo
};

console.log(idPriorizacion);

function verGestionPamec(idAutoEva, idPrio) {
    window.location = `index.php?ruta=pamec/detallegestionpamec&idAutoEva=${btoa(idAutoEva)}&idPrio=${btoa(idPrio)}`;
}

$('a[data-bs-target="#calidadEsperadaPane"]').on('shown.bs.tab', function () {
    if (tablaCalidadEsperada) {
        tablaCalidadEsperada.columns.adjust().draw();
    }
});


const syncMetaAutoevaluacion = () => {
    const metaInput = $('#metaAutoevaluacion');
    const total = tablaCalidadEsperada.rows().count();

    if (total > 0) {
        const meta = tablaCalidadEsperada.row(0).data().meta_autoevaluacion;
        metaInput.val(meta).prop('readonly', true);
    } else {
        metaInput.val('').prop('readonly', false);
    }
}

const verCalidadObservada = (idCalidadEsperada) => {
    document.getElementById('formVerCalidadObservada').reset();
    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'verCalidadObservada',
            idCalidadEsperadaObs: idCalidadEsperada
        },
        dataType: 'json',
        success: function (resp) {
            if (!resp) {
                toastr.error('No se encontró la calidad observada');
                return;
            }
            document.getElementById('idCalidadObservada').value = resp.id_calidad_observada || '';
            document.getElementById('verResultadoAutoeval').value = resp.resultado_autoevaluacion || '';
            document.getElementById('verResultadoIndicador').value = resp.resultado_indicador || '';
            document.getElementById('verObsCalidadObservada').value = resp.observacion || '';

            const modalEl = document.getElementById('modalVerObservada');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    });
};



const recargarTablaObservadas = () => {
    $('#containerVerPanelsObservadas').html('');
    tablaCalidadObservada.clear().draw();
    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaCalidadObservada',
            idPrio: idPriorizacion
        },
        dataType: 'json',
        success: (respuesta) => {
            if (respuesta.data) {
                tablaCalidadObservada.rows.add(respuesta.data).draw();
                respuesta.data.forEach((resp) => {
                    const idObs = resp.id_calidad_observada;
                    const indicador = resp.nombre_indicador;
                    const resAuto = resp.resultado_autoevaluacion;
                    const resInd = resp.resultado_indicador;
                    const obsTxt = resp.observacion;

                    const panelHTML = `
                        <div class="card mb-3 border border-200" id="cardObservada${idObs}">
                        <div class="card-header p-2 bg-light d-flex justify-content-between align-items-center">
                            <div>
                            <strong>Calidad Observada # ${idObs}</strong>
                            <span class="ms-3 badge bg-success">Indicador: ${indicador}</span>
                            <span class="ms-3">Resultado Autoevaluacion: ${resAuto}</span>
                            <span class="ms-3">Resultado Obtenido: ${resInd}</span>
                            <span class="ms-3 badge bg-info" id="headerCount${idObs}">0</span>
                            </div>
                            <button
                            class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelObservada${idObs}" aria-expanded="false" aria-controls="panelObservada${idObs}">
                            <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="accordion-collapse collapse" id="panelObservada${idObs}" data-bs-parent="#containerPanelsObservadas">
                            <div class="card-body">
                                <div class="card shadow-sm border border-200 mb-4">
                                    <div class="card-header p-3 border border-300 ">
                                        <div class="row g-3 justify-content-between align-items-center">
                                            <div class="col-sm-12 col-md-4">
                                                <h4 class="text-black mb-1">Informacion Calidad Observada</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <input type="hidden" name="idCalidadObservada" value="${idObs}">
                                            <div class="col-sm-12 col-md-4">
                                                <label class="text-900">Indicador</label>
                                                <div id="infoIdObs">Calidad Observada #${idObs}</div>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <label class="text-900">Indicador</label>
                                                <div id="infoIndicador">${indicador}</div>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <label class="text-900">Resultado Autoevaluacion</label>
                                                <div id="infoResultAutoeva">${resAuto}</div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-4">
                                                <label class="text-900">Resultado Obtenido</label>
                                                <div id="infoResultObtenido">${resInd}</div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label class="text-900">Observacion</label>
                                                <div id="infoObservacion">${obsTxt}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow-none border border-300 mb-4" data-component-card="data-component-card">
                                    <div class="card-header p-3 border border-300">
                                        <div class="row g-3 justify-content-between align-items-center">
                                            <div class="col-12 col-md">
                                                <h4 class="text-black mb-0">Lista Acciones Mejora</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive mb-3">
                                            <table id="tablaAccionesMejora${idObs}" class="table table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                    <th>#</th>
                                                    <th>¿QUÉ?</th>
                                                    <th>TIPO ACCIÓN</th>
                                                    <th>¿POR QUÉ?</th>
                                                    <th>¿CÓMO?</th>
                                                    <th>¿DÓNDE?</th>
                                                    <th>¿QUIÉN?</th>
                                                    <th>FECHA INICIO</th>
                                                    <th>FECHA FIN</th>
                                                    <th>ACCIONES PLANEADAS</th>
                                                    <th>OBSERVACIONES</th>
                                                    <th>ACCIONES</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                    $('#containerVerPanelsObservadas').append(panelHTML);
                    let tablaAcciones = $(`#tablaAccionesMejora${idObs}`).DataTable({
                        scrollX: true,
                        columns: [
                            { name: '#', data: 'id_accion_mejora' },
                            {
                                name: '¿QUÉ?',
                                data: 'que',
                                render: function (data, type) {
                                    if (type === 'display' || type === 'filter') {
                                        let txt = (data || '').toString();
                                        let limpio = $('<div>').text(txt).html();
                                        let corto = txt.length > 40 ? txt.substring(0, 40) + '…' : txt;
                                        return `<span title="${limpio}">${corto}</span>`;
                                    }
                                    return data;
                                }
                            },
                            { name: 'TIPO ACCIÓN', data: 'tipo_accion' },
                            {
                                name: '¿POR QUÉ?',
                                data: 'porque',
                                render: function (data, type) {
                                    if (type === 'display' || type === 'filter') {
                                        let txt = (data || '').toString();
                                        let limpio = $('<div>').text(txt).html();
                                        let corto = txt.length > 40 ? txt.substring(0, 40) + '…' : txt;
                                        return `<span title="${limpio}">${corto}</span>`;
                                    }
                                    return data;
                                }
                            },
                            {
                                name: '¿CÓMO?',
                                data: 'como',
                                render: function (data, type) {
                                    if (type === 'display' || type === 'filter') {
                                        let txt = (data || '').toString();
                                        let limpio = $('<div>').text(txt).html();
                                        let corto = txt.length > 40 ? txt.substring(0, 40) + '…' : txt;
                                        return `<span title="${limpio}">${corto}</span>`;
                                    }
                                    return data;
                                }
                            },
                            { name: '¿DÓNDE?', data: 'donde' },
                            {
                                name: '¿QUIÉN?',
                                data: 'quien',
                                render: function (data, type) {
                                    if (type === 'display' || type === 'filter') {
                                        let txt = (data || '').toString();
                                        let limpio = $('<div>').text(txt).html();
                                        let corto = txt.length > 40 ? txt.substring(0, 40) + '…' : txt;
                                        return `<span title="${limpio}">${corto}</span>`;
                                    }
                                    return data;
                                }
                            },
                            { name: 'FECHA INICIO', data: 'fecha_inicio' },
                            { name: 'FECHA FIN', data: 'fecha_fin' },
                            { name: 'ACCIONES PLANEADAS', data: 'acciones_planeadas' },
                            {
                                name: 'OBSERVACIONES',
                                data: 'observaciones',
                                render: function (data, type) {
                                    if (type === 'display' || type === 'filter') {
                                        let txt = (data || '').toString();
                                        let limpio = $('<div>').text(txt).html();
                                        let corto = txt.length > 40 ? txt.substring(0, 40) + '…' : txt;
                                        return `<span title="${limpio}">${corto}</span>`;
                                    }
                                    return data;
                                }
                            },
                            {
                                name: 'Acciones',
                                orderable: false,
                                render: (data, type, row) => {
                                    return `
                                        <button class="btn btn-sm btn-info m-1" data-bs-toggle="modal" data-bs-target="#modalAccionMejora" onclick="cargarDetalleAccion(${row.id_accion_mejora})"title="Ver detalle"><i class="fas fa-eye"></i></button>
                                    `;
                                }
                            }
                        ],
                        ordering: false,
                        destroy: true,
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'excel',
                            text: 'Descargar Excel',
                            className: 'btn btn-phoenix-success',
                            exportOptions: { orthogonal: 'export' }
                        }],
                        ajax: {
                            url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
                            type: 'POST',
                            data: {
                                proceso: 'listaAccionesMejora',
                                idCalidadObservada: idObs
                            }
                        },
                        initComplete: function (settings, json) {
                            const cantidad = json.data ? json.data.length : 0;
                            $(`#headerCount${idObs}`).text(`Acciones: ${cantidad}`);
                        }
                    });
                    $(`#panelObservada${idObs}`).on('shown.bs.collapse', function () {
                        tablaAcciones.columns.adjust().draw();
                    });
                });

            } else {
                toastr.error('No se encontraron calidades observadas');
            }
        }
    });
};

function cargarDetalleAccion(idAccionMejora) {

    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {
            proceso: 'verAccionMejora',
            idAccionMejora: idAccionMejora
        },
        success: function (resp) {

            if (!resp) { toastr.error('No se encontró la acción'); return; }
            const txt = v => $('<div>').text(v ?? '').html();

            const html = `
                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12">
                                    <label class="text-900"><b>¿QUÉ?</b></label>
                                    <div>${txt(resp.que)}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12">
                                    <label class="text-900"><b>¿POR QUÉ?</b></label>
                                    <div>${txt(resp.porque)}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12">
                                    <label class="text-900"><b>¿CÓMO?</b></label>
                                    <div>${txt(resp.como)}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12">
                                    <label class="text-900"><b>OBSERVACIONES</b></label>
                                    <div>${txt(resp.observaciones)}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>TIPO ACCIÓN</b></label>
                                    <div>${txt(resp.tipo_accion)}</div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>¿DÓNDE?</b></label>
                                    <div>${txt(resp.donde)}</div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>¿QUIÉN?</b></label>
                                    <div>${txt(resp.quien)}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>ACCIONES PLANEADAS</b></label>
                                    <div>${resp.acciones_planeadas}</div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>FECHA INICIO</b></label>
                                    <div>${resp.fecha_inicio}</div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>FECHA FIN</b></label>
                                    <div>${resp.fecha_fin}</div>
                                </div>
                            </div>
                        `;

            $('#bodyAccion').html(html);
            $('#modalAccionMejora .modal-title').text(`Acción Mejora #${resp.id_accion_mejora}`);
        }
    });
}

$('a[data-bs-target="#planAccion-pane"]').on('shown.bs.tab', function () {
    if (tablaCalidadObservada) {
        tablaCalidadObservada.columns.adjust().draw();
    }
    recargarTablaObservadas();
});

const recargarEvaluaciones = () => {

    $('#containerPanelsAcciones').empty();

    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: { proceso: 'listaAccionesMejoraPriorizacion', idPrio: idPriorizacion },
        dataType: 'json',

        success: ({ data }) => {
            const grupos = {};
            data.forEach(r => {
                const id = r.id_calidad_observada;
                if (!grupos[id]) {
                    grupos[id] = {
                        id_calidad_observada: id,
                        nombre_indicador: r.nombre_indicador,
                        resultado_autoevaluacion: r.resultado_autoevaluacion,
                        resultado_indicador: r.resultado_indicador,
                        acciones: []
                    };
                }
                grupos[id].acciones.push(r);
            });

            /* 4. Pinta cada grupo (card normal) ----------------------- */
            Object.values(grupos).forEach(g => {

                const cardCO = $(`
          <div class="card shadow-none border border-300 mb-4" id="cardCO${g.id_calidad_observada}">
            <div class="card-header  p-4 border-bottom border-300 ">
                <div class="row g-3 justify-content-between align-items-center">
                    <div class="col-12 col-md-3">
                        <h4 class="text-black mb-0"><strong>Calidad Observada #${g.id_calidad_observada}</strong></h4>
                    </div>
                    <div class="col-12 col-md-3">
                        <h5 class="text-black mb-0"><strong>Indicador: ${g.nombre_indicador}</strong></h5>
                        <!--<span class="badge bg-success ms-2">Indicador: ${g.nombre_indicador}</span>-->
                    </div>
                    <div class="col-12 col-md-3">
                        <h5 class="text-black mb-0"><strong>Result. Autoevaluacion: ${g.resultado_autoevaluacion}</strong></h5>
                         <!--<span class="ms-3">Autoevaluacion: ${g.resultado_autoevaluacion}</span>-->
                    </div>
                    <div class="col-12 col-md-3">
                        <h5 class="text-black mb-0"><strong>Result. Obtenido Indicador: ${g.resultado_indicador}</strong></h5>
                         <!--<span class="ms-3">Obtenido Indicador: ${g.resultado_indicador}</span>-->
                    </div>

                </div>
            </div>
            <div class="card-body" id="bodyCO${g.id_calidad_observada}"></div>
          </div>`);

                $('#containerPanelsAcciones').append(cardCO);
                g.acciones.forEach(a => {
                    const colorTipo = a.tipo_accion === 'CORRECTIVA' ? 'warning'
                        : a.tipo_accion === 'PREVENTIVA' ? 'success' : 'info';

                    const htmlAccion = `
                    <div class="card mb-3 border border-200" id="cardAccion${a.id_accion_mejora}">
                        <div class="card-header p-2 bg-light">
                            <div class="row  gx-0">
                                <div class="col-12 col-md-2">
                                    <strong>Acción Mejora #${a.id_accion_mejora} </strong>
                                </div>
                                <div class="col-12 col-md-2">
                                <span class="badge bg-${colorTipo} ms-2">${a.tipo_accion}</span>
                                </div>
                                <div class="col-12 col-md-3">
                                    <span class="ms-2" title="${$('<div>').text(a.que).html()}">
                                        <b>¿QUÉ?: </b>${a.que.length > 40 ? a.que.substring(0, 40) + '…' : a.que}
                                    </span>
                                </div>
                                <div class="col-12 col-md-3">
                                    <span class="badge bg-info ms-3" id="evalCount${a.id_accion_mejora}">0</span>
                                </div>
                                <div class="col-auto ms-auto">
                                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelEval${a.id_accion_mejora}" aria-expanded="false" aria-controls="panelEval${a.id_accion_mejora}">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="collapse" id="panelEval${a.id_accion_mejora}" data-bs-parent="#bodyCO${g.id_calidad_observada}">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div col-sm-12 col-md-6>
                                        <div class="card shadow-sm border border-200 mb-4">
                                            <div class="card-header p-3 border border-300">
                                                <h4 class="text-black mb-1">Información Acción Mejora</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <input type="hidden" name="idAccionMejora" value="${a.id_accion_mejora}">
                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="text-900"><b>Id Acción Mejora</b></label>
                                                        <div id="infoIdAs"> #${a.id_accion_mejora}</div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="text-900"><b>¿Que?</b></label>
                                                        <div id="infoQue">${a.que}</div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="text-900"><b>¿Porque?</b></label>
                                                        <div id="infoPorque">${a.porque}</div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="text-900"><b>¿Como?</b></label>
                                                        <div id="infoComo">${a.como}</div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="text-900"><b>¿Donde?</b></label>
                                                        <div id="infoDonde">${a.donde}</div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="text-900"><b>¿Quien?</b></label>
                                                        <div id="infoQuien">${a.quien}</div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="text-900"><b>Rango Fecha Ejecucion</b></label>
                                                        <div id="infoFechaEjecucion">${a.fecha_inicio} - ${a.fecha_fin}</div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label class="text-900"><b>Cant. Acciones Planeadas</b></label>
                                                        <div id="infoAccionesPlaneadas">${a.acciones_planeadas}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="card shadow-none border border-300 mb-4">
                                            <div class="card-header p-3 border border-300">
                                                <h4 class="text-black mb-0">Lista Evaluaciones</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="tablaEvaluacion${a.id_accion_mejora}" class="table table-striped w-100">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Fecha</th>
                                                                <th>Acciones</th>
                                                                <th>%</th>
                                                                <th>Estado</th>
                                                                <th>Obs.</th>
                                                                <th>Acc.</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                    $('#bodyCO' + g.id_calidad_observada).append(htmlAccion);
                    crearDataTableEvaluacion(a.id_accion_mejora);
                });
            });
        }
    });
};


const crearDataTableEvaluacion = idA => {

    if ($.fn.DataTable.isDataTable('#tablaEvaluacion' + idA)) {
        $('#tablaEvaluacion' + idA).DataTable().ajax.reload(null, false);
        return;
    }

    let tabla = $('#tablaEvaluacion' + idA).DataTable({
        scrollX: true,
        destroy: true,
        destroy: true,
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excel',
            text: 'Descargar Excel',
            className: 'btn btn-phoenix-success',
            exportOptions: { orthogonal: 'export' }
        }],
        ajax: {
            url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
            type: 'POST',
            data: { proceso: 'listaEvaluaciones', idAccionMejora: idA }
        },
        columns: [
            { data: 'id_evaluacion' }, { data: 'fecha' }, { data: 'acciones_ejecutadas' },
            { data: 'avance' },
            {
                data: 'estado',
                render: (d, t, r) => {
                    const map = { 'NO INICIADO': 'warning', 'PROCESO': 'info', 'COMPLETO': 'success', 'ATRASADO': 'danger' };
                    return `<span class="badge bg-${map[r.estado] || 'light'}">${r.estado}</span>`;
                }
            },
            {
                data: 'observaciones',
                render: (d, t) => (t === 'display' || t === 'filter') ?
                    `<span title="${d}">${(d || '').substr(0, 40)}${d && d.length > 40 ? '…' : ''}</span>` : d
            },
            {
                orderable: false,
                render: (d, t, row) => `
         <button class="btn btn-sm btn-info m-1" data-bs-toggle="modal"
                 data-bs-target="#modalEvaluacion"
                 onclick="cargarDetalleEvaluacion(${row.id_evaluacion})"
                 title="Ver detalle"><i class="fas fa-eye"></i></button>`}
        ],
        initComplete: (s, json) => $('#evalCount' + idA).text(`Evaluaciones: ${json.data.length}`)
    });

    /* Ajusta columnas si se expande el collapse */
    $('#panelEval' + idA).on('shown.bs.collapse', () => tabla.columns.adjust().draw());
};

function cargarDetalleEvaluacion(idEvaluacion) {

    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {
            proceso: 'verEvaluacion',
            idEvaluacion: idEvaluacion
        },
        success: function (resp) {

            if (!resp) { toastr.error('No se encontró la evaluación'); return; }

            const txt = v => $('<div>').text(v ?? '').html();

            const html = `
        <div class="row mb-2">
            <div class="col-md-4 col-sm-12">
                <label class="text-900"><b>FECHA</b></label>
                <div>${resp.fecha}</div>
            </div>
            <div class="col-md-4 col-sm-12">
                <label class="text-900"><b>ACC. EJECUTADAS</b></label>
                <div>${resp.acciones_ejecutadas}</div>
            </div>
            <div class="col-md-4 col-sm-12">
                <label class="text-900"><b>% AVANCE</b></label>
                <div>${resp.avance}</div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 col-sm-12">
                <label class="text-900"><b>ESTADO</b></label>
                <div>${txt(resp.estado)}</div>
            </div>
            <div class="col-md-8 col-sm-12">
                <label class="text-900"><b>OBSERVACIONES</b></label>
                <div>${txt(resp.observaciones)}</div>
            </div>
        </div>
      `;

            $('#bodyEvaluacion').html(html);
            $('#modalEvaluacion .modal-title').text(`Evaluación #${resp.id_evaluacion}`);
        }
    });
}

$('a[data-bs-target="#evaluacion-pane"]').on('shown.bs.tab', recargarEvaluaciones);


const initAprendizajeOrg = () => {

    if ($.fn.DataTable.isDataTable('#tablaListaAprendizajeOrgEspecifica')) {
        tablaAprOrg = $('#tablaListaAprendizajeOrgEspecifica').DataTable();
        tablaAprOrg.ajax.reload(null, false);
        return;
    }

    tablaAprOrg = $('#tablaListaAprendizajeOrgEspecifica').DataTable({
        scrollX: true,
        destroy: true,
        destroy: true,
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excel',
            text: 'Descargar Excel',
            className: 'btn btn-phoenix-success',
            exportOptions: { orthogonal: 'export' }
        }],
        columns: [
            { name: '#', data: 'id_aprendizaje_organizacional' },
            { name: 'CODIGO', data: 'codigo_estandar' },
            // { name: 'ESTANDAR', data: 'estandar' },
            {
                name: 'ESTANDAR',
                data: 'estandar',
                width: '250px',
                render: (d, t) => (t === 'display' || t === 'filter') ?
                    `<span title="${d}">${(d || '').substr(0, 40)}${d && d.length > 40 ? '…' : ''}</span>` : d
            },
            { name: 'OPORTUNIDAD DE MEJORA', data: 'oportunidad_mejora' },
            { name: 'ACCIONES COMPLETAS', data: 'acciones_completas' },
            { name: 'AVANCE(%)', data: 'porcentaje_avance' },
            {
                name: 'ESTADO',
                data: 'estado',
                render: (d, t, r) => {
                    const map = { 'INCOMPLETO': 'danger', 'COMPLETO': 'success' };
                    return `<span class="badge bg-${map[r.estado] || 'light'}">${r.estado}</span>`;
                }
            },
            {
                name: 'OBSERVACIONES',
                data: 'observaciones',
                render: (d, t) => (t === 'display' || t === 'filter') ?
                    `<span title="${d}">${(d || '').substr(0, 40)}${d && d.length > 40 ? '…' : ''}</span>` : d
            },
            { name: 'META AUTOEVALUACION', data: 'meta_autoevaluacion' },
            { name: 'INDICADOR', data: 'indicador' },
            { name: 'META INDICADOR', data: 'meta_indicador' },
            { name: 'CAL.OBS INICIO AUTOEVALUACIÓN', data: 'calidad_observada_auto' },
            { name: 'CAL.OBS INICIO INDICADOR', data: 'calidad_observada_inicio_ind' },
            { name: 'CAL.OBS FINAL', data: 'calidad_observada_final' },
            {
                name: 'CAL.OBS FINAL INDICADOR',
                data: 'calidad_observada_final_ind',
                render: (d, t) => (t === 'display' || t === 'filter') ?
                    `<span title="${d}">${(d || '').substr(0, 40)}${d && d.length > 40 ? '…' : ''}</span>` : d
            },
            {
                name: 'BARRERAS MEJORAMIENTO',
                data: 'barreras_mejoramiento',
                render: (d, t) => (t === 'display' || t === 'filter') ?
                    `<span title="${d}">${(d || '').substr(0, 40)}${d && d.length > 40 ? '…' : ''}</span>` : d
            },
            {
                name: 'APRENDIZAJE ORGANIZACIONAL',
                data: 'aprendizaje_organizacional',
                render: (d, t) => (t === 'display' || t === 'filter') ?
                    `<span title="${d}">${(d || '').substr(0, 40)}${d && d.length > 40 ? '…' : ''}</span>` : d
            },
            {
                name: 'ACCIONES', orderable: false, render: function (data, type, row) {
                    return `<button class="btn btn-sm btn-info m-1" title="Ver detalle" onclick="cargarDetalleAprendizaje(${row.id_aprendizaje_organizacional})"><i class="fas fa-eye"></i></button>
                    `;
                }
            }

        ],
        ajax: {
            url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
            type: 'POST',
            data: {
                proceso: 'listarAprendizajeOrg',
                idPrio: idPriorizacion
            }
        }
    });


};

const cargarDetalleAprendizaje = (idApr) => {

    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'verAprendizajeOrgById',
            idAprendizaje: idApr
        },
        dataType: 'json',

        success: function (resp) {

            if (!resp) { toastr.error('No se encontró el registro'); return; }
            let html = `
                            <div class="row mb-4">
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>CÓDIGO</b></label>
                                    <div>${resp.codigo_estandar}</div>
                                </div>
                                <div class="col-md-8 col-sm-12">
                                    <label class="text-900"><b>ESTÁNDAR</b></label>
                                    <div>${resp.estandar}</div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="row mb-4">
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>OPORTUNIDAD MEJORA</b></label>
                                    <div>${resp.oportunidad_mejora}</div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>ACC. COMPLETAS</b></label>
                                    <div>${resp.acciones_completas}</div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>% AVANCE</b></label>
                                    <div>${resp.porcentaje_avance}</div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                 <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>ESTADO</b></label>
                                    <div>${resp.estado}</div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>META AUTOEVAL.</b></label>
                                    <div>${resp.meta_autoevaluacion}</div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>INDICADOR</b></label>
                                    <div>${resp.indicador}</div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>META INDICADOR</b></label>
                                    <div>${resp.meta_indicador}</div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>CAL. OBS. INI AUTO</b></label>
                                    <div>${resp.calidad_observada_auto}</div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label class="text-900"><b>CAL. OBS. INI INDIC.</b></label>
                                    <div>${resp.calidad_observada_inicio_ind}</div>
                                </div>
                            </div>
                            <hr>
                            <br>
                            <div class="row mb-4">
                                <div class="col-md-12 col-sm-12">
                                    <label class="text-900"><b>CAL. OBS. FINAL</b></label>
                                    <div>${resp.calidad_observada_final}</div>
                                </div>
                            </div>
                             <div class="row mb-4">
                                <div class="col-md-12 col-sm-12">
                                    <label class="text-900"><b>OBSERVACIONES</b></label>
                                    <div>${resp.observaciones}</div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12 col-sm-12">
                                    <label class="text-900"><b>CAL. OBS. FINAL INDICADOR</b></label>
                                    <div>${resp.calidad_observada_final_ind}</div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12 col-sm-12">
                                    <label class="text-900"><b>BARRERAS MEJORAMIENTO</b></label>
                                    <div>${resp.barreras_mejoramiento}</div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-900"><b>APRENDIZAJE ORGANIZACIONAL</b></label>
                                    <div>${resp.aprendizaje_organizacional}</div>
                                </div>
                            </div>
                        `;

            $('#contenDetalleAprendizaje').html(html);
            new bootstrap.Modal('#modalDetalleAprendizaje').show();
        },

        error: function () {
            toastr.error('Error de comunicación con el servidor');
        }
    });
}


const guardarAprendizaje = () => {
    let formulario = document.getElementById("formAprendizajeOrg");
    let elementos = formulario.elements;
    let errores = 0;
    let form = document.querySelector('#formAprendizajeOrg');

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (formulario.checkValidity()) {
        Swal.fire({
            title: '¿Guardar Aprendizaje Organizacional?',
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
        }).then(result => {
            if (!result.isConfirmed) return;
            const fd = new FormData(form);
            fd.append('proceso', 'guardarAprendizajeOrg');
            fd.append('idPrio', idPriorizacion);
            fd.append('user', userSession);
            $.ajax({
                url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                dataType: 'json'
            }).done(res => {
                if (res === 'ok') {
                    Swal.fire('¡Guardado!', '', 'success');
                    form.reset();
                    limpiarCamposIndicador();
                    tablaAprOrg.ajax.reload(null, false);
                } else {
                    Swal.fire('Error', 'No se pudo guardar', 'error');
                    console.error(res);
                }
            });
        });
    } else {
        toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");
        form.reportValidity();
        return;
    }

};

const eliminarAprendizajeOrg = (id) => {
    Swal.fire({
        title: '¿Desea Eliminar Aprendizaje Organizacional?',
        icon: 'warning',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar',
    }).then(result => {
        if (!result.isConfirmed) return;
        $.ajax({
            url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
            type: 'POST',
            data: {
                proceso: 'eliminarAprendizajeOrg',
                idAprendizaje: id,
                user: userSession
            },
            dataType: 'json'
        }).done(res => {
            if (res === 'ok') {
                toastr.success('Registro eliminado');
                tablaAprOrg.ajax.reload(null, false);
            } else {
                toastr.error('No se pudo eliminar');
                console.error(res);
            }
        });
    });
};

$('a[data-bs-target="#apOrganizacional-pane"]').on('shown.bs.tab', () => {
    initAprendizajeOrg();
    $.ajax({
        type: "POST",
        url: "ajax/pamec/gestionarpriorizacion.ajax.php",
        data: {
            proceso: 'cargarSelectIndicador',
            idPrio: idPriorizacion
        },
        success: function (respuesta) {
            $("#selIndicador").html(respuesta);
        }
    });
    $('#formAprendizajeOrg')[0].reset();
    limpiarCamposIndicador();
    $('#containerAvance').removeAttr('style');

});



tablaCalidadEsperada = $('#tablaCalidadEsperada').DataTable({
    scrollX: true,
    columns: [
        { name: '#', data: 'id_calidad_esperada' },
        { name: 'Meta Autoevaluacion', data: 'meta_autoevaluacion', },
        { name: 'Nombre Indicador', data: 'nombre_indicador' },
        { name: 'Meta Indicador', data: 'meta_indicador' },
        {
            name: 'Acciones', orderable: false, render: function (data, type, row) {
                let botones = '';
                if (parseInt(row.existe_observada) === 0) {
                    botones += `<button title='Crear Calidad Observada'type="button" data-bs-toggle="modal" data-bs-target="#modalCalidadObservada" class="btn btn-primary btn-sm m-1" onclick="crearCalidadObservada(${row.id_calidad_esperada})"><i class="fas fa-plus"></i></button>`
                } else {
                    botones += `<button type="button" class="btn btn-info btn-sm m-1" onclick="verCalidadObservada(${row.id_calidad_esperada})" title="Ver Calidad Observada"><i class="fas fa-eye"></i></button>`;
                }
                return botones
            }
        }
    ],
    ordering: false,
    dom: 'Bfrtip',
    buttons: [{
        extend: 'excel',
        text: 'Descargar Excel',
        className: 'btn btn-phoenix-success'
    }],
    ajax: {
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaCalidadEsperada',
            idPrio: idPriorizacion
        }
    },
});
tablaCalidadEsperada.on('draw', syncMetaAutoevaluacion);

tablaCalidadObservada = $('#tablaCalidadObservada').DataTable({
    scrollX: true,
    autoWidth: true,
    columns: [
        { name: '#', data: 'id_calidad_observada' },
        { name: 'Indicador', data: 'nombre_indicador' },
        { name: 'Resultado Autoeval.', data: 'resultado_autoevaluacion' },
        { name: 'Resultado Obtenido', data: 'resultado_indicador' },
        { name: 'Observaciones', data: 'observacion' }
    ],
    ordering: false,
    paging: false,
    searching: false,
    info: false,
    data: []
});

let tablaGestionPamec = $('#tablaGestionPamec').DataTable({
    scrollX: true,
    order: [[0, 'desc']],
    columns: [
        { name: '#', data: 'id_autoevaluacion' },
        { name: 'GRUPO', data: 'grupo' },
        { name: 'SUBGRUPO', data: 'subgrupo' },
        { name: 'ESTÁNDAR', data: 'codigo' },
        { name: 'SEDES', data: 'sede' },
        { name: 'PROGRAMAS', data: 'programa' },
        { name: 'FECHA FIN', data: 'fecha_fin' },
        { name: 'PRIORIZACIÓN', data: 'id_respuesta_priorizacion' },
        {
            name: 'ACCIONES', orderable: false, render: function (d, t, row) {
                return `
          <button class="btn btn-sm btn-info"
                  onclick="verGestionPamec(${row.id_autoevaluacion},${row.id_respuesta_priorizacion})"
                  title="Ver Gestión Pamec">
            <i class="fas fa-eye"></i>
          </button>`;
            }
        }
    ],
    dom: 'Bfrtip',
    buttons: [{
        extend: 'excel', text: 'Descargar Excel', className: 'btn btn-phoenix-success'
    }],
    ajax: {
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: { proceso: 'listaGestionPamec' }
    }
});


$(document).ready(async () => {
});



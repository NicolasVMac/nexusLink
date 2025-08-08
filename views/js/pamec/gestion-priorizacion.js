/*
1. RUTA
*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
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

const gestionarPriorizacion = (idPriorizacion) => {

    Swal.fire({
        title: '¿Desea Gestionar la priorizacion ' + idPriorizacion + '?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then(function (result) {

        if (!result.isConfirmed) { return; }
        const formData = new FormData();
        formData.append('proceso', 'actualizarEstadoPriorizacion');
        formData.append('user', userSession);
        formData.append('idPrio', idPriorizacion);
        formData.append('gestion', 'PROCESO');

        $.ajax({
            url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (respuesta) {

                if (respuesta === 'ok') {
                    Swal.fire({
                        text: '¡Redirreccionando para su gestion!',
                        icon: 'success',
                        confirmButtonText: 'Cerrar',
                        confirmButtonColor: '#d33',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(function () {
                        window.location = 'index.php?ruta=pamec/gestionarpriorizacion&idPrio=' + btoa(idPriorizacion);
                    });
                } else {
                    Swal.fire({
                        text: '¡No se Gestionar la priorizacion!',
                        icon: 'error',
                        confirmButtonText: 'Cerrar',
                        confirmButtonColor: '#d33',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                    console.error(respuesta);
                }
            },
        });
    });

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

const guardarCalidadEsperada = () => {
    let formulario = document.getElementById("formCalidadEsperada");
    let elementos = formulario.elements;
    let errores = 0;
    let form = document.querySelector('#formCalidadEsperada');

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {
        if (formulario.checkValidity()) {
            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }
            Swal.fire({
                title: '¿Guardar calidad esperada?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function (result) {

                if (!result.isConfirmed) { return; }
                const formData = new FormData(form);
                formData.append('proceso', 'guardarCalidadEsperada');
                formData.append('user', userSession);
                formData.append('idPrio', idPriorizacion);
                $.ajax({
                    url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (respuesta) {

                        if (respuesta === 'ok') {
                            Swal.fire({
                                text: '¡Calidad esperada guardada correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                confirmButtonColor: '#d33',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then(function () {
                                formulario.reset();
                                tablaCalidadEsperada.ajax.reload(() => syncMetaAutoevaluacion(), false);
                            });
                        } else {
                            Swal.fire({
                                text: '¡No se pudo guardar la información!',
                                icon: 'error',
                                confirmButtonText: 'Cerrar',
                                confirmButtonColor: '#d33',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            });
                            console.error(respuesta);
                        }
                    },
                });
            });

        } else {
            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");
            return;
        }
    } else {
        toastr.warning("Hay campos con errores manuales", "¡Atencion!");
        return;
    }

}

const eliminarCalidadEsperada = (id) => {

    Swal.fire({
        title: '¿Eliminar la calidad esperada?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then(result => {

        if (!result.isConfirmed) { return; }

        $.ajax({
            url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
            type: 'POST',
            data: {
                proceso: 'eliminarCalidadEsperada',
                idCalidad: id,
                user: userSession
            },
            dataType: 'json',
            success: function (respuesta) {

                if (respuesta === 'ok') {
                    Swal.fire({
                        text: '¡Calidad Esperada Eliminada Correctamente!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6'
                    })
                    tablaCalidadEsperada.ajax.reload(() => syncMetaAutoevaluacion(), false);

                } else {
                    Swal.fire({
                        text: '¡No se pudo Eliminar la calidad esperada!',
                        icon: 'error',
                        confirmButtonText: 'Cerrar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: "#d33",
                    })
                }
            },
            error: function () {
                toastr.error('Error de comunicación con el servidor');
            }
        });
    });
};

const crearCalidadObservada = (idCalidad) => {
    document.getElementById('formCalidadObservada').reset();
    document.getElementById('idCalidadEsperadaObs').value = idCalidad;

    $.ajax({

        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'obtenerValorEvaluacionCuantitativa',
            'idPrio': idPriorizacion
        },
        dataType: "json",
        success: function (resp) {
            if (resp.error) {
                toastr.error('Error al procesar las escalas');
                return;
            }
            document.getElementById('resultadoAutoeval').value = resp.resultadoEvaluacionCuantitativa;
        }

    })
};

const guardarCalidadObservada = () => {
    let formulario = document.getElementById("formCalidadObservada");
    let elementos = formulario.elements;
    let errores = 0;
    let form = document.querySelector('#formCalidadObservada');

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {
        if (formulario.checkValidity()) {
            Swal.fire({
                title: '¿Guardar calidad observada?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(result => {
                if (!result.isConfirmed) return;
                const fd = new FormData(form);
                fd.append('proceso', 'guardarCalidadObservada');
                fd.append('user', userSession);
                // for (const [key, value] of fd) {
                //     console.log(key, value);
                // }

                $.ajax({
                    url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: respuesta => {
                        if (respuesta === 'ok') {
                            Swal.fire({
                                text: '¡Calidad observada guardada!',
                                icon: 'success',
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                let $tab = $('#planAccion-tab');
                                $tab.removeClass('disabled');
                                $tab.attr('data-bs-toggle', 'tab');
                                bootstrap.Modal.getInstance(document.getElementById('modalCalidadObservada')).hide();
                                tablaCalidadEsperada.ajax.reload(() => syncMetaAutoevaluacion(), false);


                            });
                        } else {
                            console.error(respuesta);
                            Swal.fire('Error', 'No se pudo guardar', 'error');
                        }
                    },
                });
            });
        } else {
            toastr.warning('Complete todos los campos', '¡Atención!');
            return;
        }
    } else {
        toastr.warning("Hay campos con errores manuales", "¡Atencion!");
        return;
    }
};

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

const eliminarCalidadObservada = () => {
    let idCalidadObs = document.getElementById('idCalidadObservada').value;

    if (!idCalidadObs) {
        toastr.error('No se identificó la calidad observada para eliminar');
        return;
    }

    Swal.fire({
        title: '¿Eliminar la calidad observada?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then(result => {
        if (!result.isConfirmed) return;

        const fd = new FormData();
        fd.append('proceso', 'eliminarCalidadObservada');
        fd.append('idCalidadObservada', idCalidadObs);
        fd.append('user', userSession);

        $.ajax({
            url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta === 'ok') {
                    Swal.fire({
                        text: '¡Calidad observada Eliminada Correctamente!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        bootstrap.Modal.getInstance(document.getElementById('modalVerObservada')).hide();
                    });
                    tablaCalidadEsperada.ajax.reload(() => syncMetaAutoevaluacion(), false);

                } else {
                    Swal.fire({
                        text: '¡No se pudo Eliminar la calidad observada!',
                        icon: 'error',
                        confirmButtonText: 'Cerrar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: "#d33",
                    })

                }
            },
        });
    });
};

const cargarInfoGeneral = () => {
    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'obtenerInfoGeneralPriorizacion',
            idPrio: idPriorizacion
        },
        dataType: 'json',
        success: function (resp) {
            if (resp && resp.grupo !== undefined) {
                document.getElementById('infoGrupo').innerText = resp.grupo || '';
                document.getElementById('infoEstandar').innerText = resp.estandar || '';
                document.getElementById('infoSedes').innerText = resp.sedes || '';
                document.getElementById('infoOM').innerText = resp.oportunidades_mejora || '';
                document.getElementById('infoAO').innerText = resp.acciones_oportunidades || '';
                document.getElementById('infoFechaCrea').innerText = resp.fecha_crea || '';
                document.getElementById('infoUsuarioCrea').innerText = resp.usuario_crea || '';
            }
        },
        error: function () {
            toastr.error('No se pudo cargar la información general');
        }
    });
};

const verificaPestaniaActivas = () => {
    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'verificarCalidadObservadaExiste',
            idPrio: idPriorizacion
        },
        dataType: 'json',
        success: function (resp) {
            if (resp && resp.total !== undefined) {
                if (parseInt(resp.total) > 0) {
                    $('#planAccion-tab').removeClass('disabled');
                    $('#planAccion-tab').attr('data-bs-toggle', 'tab');
                } else {
                    $('#planAccion-tab').addClass('disabled');
                    $('#planAccion-tab').removeAttr('data-bs-toggle');
                }
            }
        },
    });
}


const recargarTablaObservadas = () => {
    $('#containerPanelsObservadas').html('');
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
                                                    <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow-sm border border-200 mb-4">
                                    <form id="formAccionMejora${idObs}" name="formAccionMejora${idObs}" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                        <div class="card-header p-3 border border-300 ">
                                            <div class="row g-3 justify-content-between align-items-center">
                                                <div class="col-sm-12 col-md-4">
                                                    <h4 class="text-black mb-1">Agregar Accion Mejora</h4>
                                                </div>
                                                <div class="col col-md-auto">
                                                    <button class="btn btn-phoenix-success ms-2" type="submit" onclick="guardarAccionMejora(${idObs})">
                                                        <i class="far fa-check-circle"></i> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <input type="hidden" name="idCalidadObservada" value="${idObs}">
                                                <div class="col-sm-12 col-md-6">
                                                    <label class="text-900">¿QUÉ? <b class="text-danger">*</b></label>
                                                    <textarea class="form-control" name="que" rows="2"  placeholder="¿QUE?"required></textarea>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <label class="text-900">¿POR QUÉ? <b class="text-danger">*</b></label>
                                                    <textarea class="form-control" name="porque" rows="2" placeholder="¿PORQUE?" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">TIPO DE ACCIÓN <b class="text-danger">*</b></label>
                                                    <select class="form-control select-field" name="tipo_accion" required>
                                                        <option value="">Seleccionar…</option>
                                                        <option value="PREVENTIVA">Acciones Preventivas</option>
                                                        <option value="CORRECTIVA">Acciones Correctivas</option>
                                                        <option value="MEJORA">Acciones de Mejora</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">¿DÓNDE? <b class="text-danger">*</b></label>
                                                    <select class="form-control select-field-multiple" multiple name="donde" id="dondeSelect${idObs}" data-placeholder="Seleccionar sedes…" style="width:100%" required></select>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">¿QUIÉN? <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control" name="quien" placeholder="¿QUIEN?" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">ACCIONES PLANEADAS <b class="text-danger">*</b></label>
                                                    <input type="number" min="1" class="form-control" name="acciones_planeadas" placeholder="Numero Acciones Planeadas" required>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">FECHA INICIO <b class="text-danger">*</b></label>
                                                    <input type="date" class="form-control" name="fecha_inicio"  max="" onchange="validarFechas(this)" required>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label class="text-900">FECHA FIN <b class="text-danger">*</b></label>
                                                    <input type="date" class="form-control" name="fecha_fin" min="" onchange="validarFechas(this)" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-12 col-md-6">
                                                    <label class="text-900">¿CÓMO? <b class="text-danger">*</b></label>
                                                    <textarea class="form-control" name="como" rows="2" placeholder="¿COMO?" required></textarea>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <label class="text-900">OBSERVACIONES</label>
                                                    <textarea class="form-control" name="observaciones" rows="2" placeholder="OBSERVACIONES"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        `;
                    $('#containerPanelsObservadas').append(panelHTML);
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
                                        <!--<button class="btn btn-sm btn-primary" onclick="editarAccionMejora(${row.id_accion_mejora}, ${idObs})">
                                        <i class="fas fa-edit">
                                        </button></i>-->
                                        <button class="btn btn-sm btn-info m-1" data-bs-toggle="modal" data-bs-target="#modalAccionMejora" onclick="cargarDetalleAccion(${row.id_accion_mejora})"title="Ver detalle"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-danger m-1" onclick="eliminarAccionMejora(${row.id_accion_mejora}, ${idObs})"><i class="fas fa-trash-alt"></i></button>`;
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
                    cargarSelectSedesPriorizacion(idObs);
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

const validarFechas = (inputFecha) => {
    const form = inputFecha.closest('form');
    let fechaInicioInput = form.querySelector('input[name="fecha_inicio"]');
    let fechaFinInput = form.querySelector('input[name="fecha_fin"]');

    let fechaInicioVal = fechaInicioInput.value;
    let fechaFinVal = fechaFinInput.value;

    if (inputFecha.name === 'fecha_inicio') {
        if (fechaInicioVal) {
            fechaFinInput.min = fechaInicioVal;
        } else {
            fechaFinInput.removeAttribute('min');
        }
    }

    if (inputFecha.name === 'fecha_fin') {
        if (fechaFinVal) {
            fechaInicioInput.max = fechaFinVal;
        } else {
            fechaInicioInput.removeAttribute('max');
        }
    }

    if (fechaInicioVal && fechaFinVal) {
        let fechaInicioDate = new Date(fechaInicioVal);
        let fechaFinDate = new Date(fechaFinVal);

        if (fechaInicioDate > fechaFinDate) {
            inputFecha.setCustomValidity('La Fecha Inicio no puede ser mayor que la Fecha Fin.');
            inputFecha.reportValidity();
            toastr.error('La Fecha Inicio no puede ser mayor que la Fecha Fin.', 'Error de Validación');
            inputFecha.value = '';
            return;
        }
    }

    inputFecha.setCustomValidity('');
};


const pintarSelectSedes = (idObs, sedes, selected = []) => {

    let $sel = $('#dondeSelect' + idObs);

    /* arma el HTML de opciones */
    let html = '';
    sedes.forEach(s => {
        let marcado = selected.includes(s) ? ' selected' : '';
        html += `<option value="${s}"${marcado}>${s}</option>`;
    });
    $sel.html(html);

    if ($sel.hasClass('select2-hidden-accessible')) {
        $sel.select2('destroy');
    }
    $sel.select2({
        width: '100%',
        placeholder: 'Seleccionar sedes…',
        closeOnSelect: false,
        allowClear: true,
        dropdownParent: $('#formAccionMejora' + idObs)
    });
    if (selected.length) {
        $sel.trigger('change');
    }
};

const cargarSelectSedesPriorizacion = (idObs, selected = []) => {

    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaSedesPriorizacion',
            idPrio: idPriorizacion
        },
        dataType: 'json',
        success: (respSedes) => {
            pintarSelectSedes(idObs, respSedes, selected);
        }
    });
};

const guardarAccionMejora = (idObs) => {
    const formSelector = `#formAccionMejora${idObs}`;
    let formulario = document.querySelector(formSelector);
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach((element) => {
        if (element.className.includes('is-invalid')) {
            errores++;
        }
    });

    if (errores > 0) {
        toastr.warning("Hay campos con errores manuales", "¡Atención!");
        return;
    }
    if (!formulario.checkValidity()) {
        toastr.warning("Complete todos los campos obligatorios", "¡Atención!");
        return;
    }

    Swal.fire({
        title: '¿Guardar acción de mejora?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (!result.isConfirmed) return;

        let selSedes = document.getElementById(`dondeSelect${idObs}`);
        let cadenaSedes = "";
        for (let i = 0; i < selSedes.options.length; i++) {
            if (selSedes.options[i].selected) {
                cadenaSedes += selSedes.options[i].value + '-';
            }
        }
        cadenaSedes = cadenaSedes.slice(0, -1);

        const fd = new FormData(formulario);
        fd.set('donde', cadenaSedes);
        fd.append('proceso', 'guardarAccionMejora');
        fd.append('user', userSession);
        // for (const [key, value] of fd) {
        //     console.log(key, value);
        // }
        $.ajax({
            url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: (resp) => {
                if (resp === 'ok') {
                    Swal.fire({
                        text: '¡Acción de mejora guardada!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        let dt = $(`#tablaAccionesMejora${idObs}`).DataTable().ajax.reload(null, false);
                        dt.ajax.reload(function (json) {
                            const cantidad = json.data ? json.data.length : 0;
                            $(`#headerCount${idObs}`).text(`Acciones: ${cantidad}`);
                        }, false);
                        formulario.reset();
                        cargarSelectSedesPriorizacion(idObs);
                        verificaPestaEval();
                    });
                } else {
                    Swal.fire('Error', 'No se pudo guardar la acción de mejora', 'error');
                    console.error(resp);
                }
            }
        });
    });
};

const editarAccionMejora = (idAccion, idObs) => {
    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'verAccionMejora',
            idAccionMejora: idAccion
        },
        dataType: 'json',
        success: (resp) => {
            if (!resp) {
                toastr.error('No se pudo cargar la acción de mejora');
                return;
            }

            const formSelector = `#formAccionMejora${idObs}`;
            const form = $(formSelector);

            if (form.find('input[name="idAccionMejora"]').length === 0) {
                form.append('<input type="hidden" name="idAccionMejora">');
            }
            form.find('input[name="idAccionMejora"]').val(resp.id_accion_mejora);
            form.find('textarea[name="que"]').val(resp.que);
            form.find('select[name="tipo_accion"]').val(resp.tipo_accion);
            form.find('textarea[name="porque"]').val(resp.porque);
            form.find('textarea[name="como"]').val(resp.como);
            let sedesActuales = resp.donde ? resp.donde.split('-') : [];
            cargarSelectSedesPriorizacion(idObs, sedesActuales);
            form.find('input[name="quien"]').val(resp.quien);
            form.find('input[name="fecha_inicio"]').val(resp.fecha_inicio);
            form.find('input[name="fecha_fin"]').val(resp.fecha_fin);
            form.find('input[name="acciones_planeadas"]').val(resp.acciones_planeadas);
            form.find('textarea[name="observaciones"]').val(resp.observaciones);

            $('html, body').animate({
                scrollTop: form.offset().top - 100
            }, 400);

        }
    });
};

const eliminarAccionMejora = (idAccion, idObs) => {
    Swal.fire({
        title: '¿Eliminar esta acción de mejora?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (!result.isConfirmed) return;

        $.ajax({
            url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
            type: 'POST',
            data: {
                proceso: 'eliminarAccionMejora',
                idAccionMejora: idAccion,
                user: userSession
            },
            dataType: 'json',
            success: (resp) => {
                if (resp === 'ok') {
                    Swal.fire({
                        text: '¡Acción de mejora Eliminada!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        let dt = $(`#tablaAccionesMejora${idObs}`).DataTable().ajax.reload(null, false);
                        dt.ajax.reload(function (json) {
                            const cantidad = json.data ? json.data.length : 0;
                            $(`#headerCount${idObs}`).text(`Acciones: ${cantidad}`);
                        }, false);
                    });
                } else {
                    Swal.fire({
                        text: '¡No se pudo Eliminar la Accion de mejora!',
                        icon: 'error',
                        confirmButtonText: 'Cerrar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: "#d33",
                    })
                }
            }
        });
    });
};

$('a[data-bs-target="#planAccion-pane"]').on('shown.bs.tab', function () {
    if (tablaCalidadObservada) {
        tablaCalidadObservada.columns.adjust().draw();
    }
    recargarTablaObservadas();
});

const verificaPestaEval = () => {
    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'verificarAccionMejoraExiste',
            idPrio: idPriorizacion
        },
        dataType: 'json',
        success: resp => {
            if (resp && resp.total !== undefined && parseInt(resp.total) > 0) {
                $('#evaluacion-tab').removeClass('disabled')
                    .attr('data-bs-toggle', 'tab');
            } else {
                $('#evaluacion-tab').addClass('disabled')
                    .removeAttr('data-bs-toggle');
            }
        }
    });
};


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
                                    <div class="col-md-6 col-sm-12">
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

                                    <div class="col-md-6 col-sm-12">
                                        <div class="card shadow-sm border border-200 mb-4">
                                            <form id="formEvaluacion${a.id_accion_mejora}" name="formEvaluacion${a.id_accion_mejora}" data-fecha-inicio="${a.fecha_inicio}"data-fecha-fin="${a.fecha_fin}" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                                <div class="card-header p-3 border border-300 ">
                                                    <div class="row g-3 justify-content-between align-items-center">
                                                        <div class="col-sm-12 col-md-6">
                                                            <h4 class="text-black mb-1">Agregar Evaluacion Ejecucion</h4>
                                                        </div>
                                                        <div class="col col-md-auto">
                                                            <button class="btn btn-phoenix-success ms-2" type="submit" onclick="guardarEvaluacion(${a.id_accion_mejora})">
                                                            <i class="far fa-check-circle"></i> Guardar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <input type="hidden" name="idAccionMejora" value="${a.id_accion_mejora}">
                                                    <input type="hidden" name="idEvaluacion" value="">
                                                    <input type="hidden" name="accionesPlaneadas" value="${a.acciones_planeadas}">

                                                    <div class="row mb-2">
                                                        <div class="col-md-3">
                                                            <label class="text-900">Fecha Seguimiento <b class="text-danger">*</b></label>
                                                            <input type="date" class="form-control" min="${a.fecha_inicio}" max="${a.fecha_fin}"
                                                            onchange="validarFechaSeguimiento(this)" name="fecha" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="text-900">Acciones <b class="text-danger">*</b></label>
                                                            <input type="number" min="0" class="form-control" name="ejecutadas"
                                                            oninput="calcularAvance(this.value,${a.id_accion_mejora})" placeholder="Numero Acciones" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="text-900">% Avance</b></label>
                                                            <input type="number" min="0" max="100" class="form-control readonly" name="avance" required
                                                            readonly>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="text-900">Estado <b class="text-danger">*</b></label>
                                                            <select class="form-control" name="estado" onchange="validarEstadoAvance(this, ${a.id_accion_mejora})" required>
                                                            <option value="">Seleccionar…</option>
                                                            <option>NO INICIADO</option>
                                                            <option>PROCESO</option>
                                                            <option>COMPLETO</option>
                                                            <option>ATRASADO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-12">
                                                            <label class="text-900">Observaciones</label>
                                                            <textarea class="form-control" name="observaciones" rows="2"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
                 title="Ver detalle"><i class="fas fa-eye"></i></button>
         <button class="btn btn-sm btn-danger m-1"
                 onclick="eliminarEvaluacion(${row.id_evaluacion},${idA})">
                 <i class="fas fa-trash-alt"></i></button>`}
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
            <div class="col-md-3 col-sm-12">
                <label class="text-900"><b>FECHA</b></label>
                <div>${resp.fecha}</div>
            </div>
            <div class="col-md-3 col-sm-12">
                <label class="text-900"><b>ACC. EJECUTADAS</b></label>
                <div>${resp.acciones_ejecutadas}</div>
            </div>
            <div class="col-md-3 col-sm-12">
                <label class="text-900"><b>% AVANCE</b></label>
                <div>${resp.avance}</div>
            </div>
            <div class="col-md-3 col-sm-12">
                <label class="text-900"><b>ESTADO</b></label>
                <div>${txt(resp.estado)}</div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 col-sm-12">
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

const guardarEvaluacion = (idA) => {

    const form = $(`#formEvaluacion${idA}`);
    if (!form[0].checkValidity()) { toastr.warning('Complete todos los campos'); return; }

    Swal.fire({
        title: '¿Desea guardar Evaluación Ejecucion?',
        icon: 'question', showCancelButton: true,
        confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Guardar', cancelButtonText: 'Cancelar',
        allowOutsideClick: false, allowEscapeKey: false
    }).then(res => {
        if (!res.isConfirmed) return;

        const fd = new FormData(form[0]);
        fd.append('proceso', 'guardarEvaluacion');
        fd.append('user', userSession);

        $.ajax({
            url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
            type: 'POST', data: fd,
            processData: false, contentType: false, dataType: 'json',
            success: resp => {
                if (resp === 'ok') {

                    Swal.fire({
                        text: '¡Evaluacion de Ejecucion guardada correctamente!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        let dt = $(`#tablaEvaluacion${idA}`).DataTable().ajax.reload(null, false);
                        dt.ajax.reload(function (json) {
                            const cantidad = json.data ? json.data.length : 0;
                            $(`#evalCount${idA}`).text(`Evaluaciones: ${cantidad}`);
                        }, false);
                        form[0].reset();
                        verificaPestaEval();
                    });

                } else {
                    Swal.fire('Error', 'No se pudo guardar la evaluacion de ejecucion', 'error');
                }
            }
        });
    });
};

const editarEvaluacion = (idEval, idA) => {

    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'verEvaluacion',
            idEvaluacion: idEval
        },
        dataType: 'json',
        success: function (resp) {

            if (!resp) {
                toastr.error('No se encontró la evaluación');
                return;
            }

            const form = $(`#formEvaluacion${idA}`);

            form.find('[name="idEvaluacion"]').val(resp.id_evaluacion);
            form.find('[name="fecha"]').val(resp.fecha);
            form.find('[name="ejecutadas"]').val(resp.acciones_ejecutadas);
            form.find('[name="avance"]').val(resp.avance);
            form.find('[name="estado"]').val(resp.estado);
            form.find('[name="observaciones"]').val(resp.observaciones);

            $('html, body').animate({
                scrollTop: form.offset().top - 100
            }, 300);
        }
    });
};

const eliminarEvaluacion = (idEval, idA) => {

    Swal.fire({
        title: '¿Eliminar evaluación?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then(result => {
        if (!result.isConfirmed) { return; }
        $.ajax({
            url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
            type: 'POST',
            data: {
                proceso: 'eliminarEvaluacion',
                idEvaluacion: idEval,
                user: userSession
            },
            dataType: 'json',
            success: function (resp) {
                if (resp === 'ok') {
                    Swal.fire({
                        text: '¡Evaluación eliminada correctamente!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        let dt = $(`#tablaEvaluacion${idA}`).DataTable().ajax.reload(null, false);
                        dt.ajax.reload(function (json) {
                            const cantidad = json.data ? json.data.length : 0;
                            $(`#evalCount${idA}`).text(`Evaluaciones: ${cantidad}`);
                        }, false);
                        verificaPestaEval();
                    });

                } else {
                    Swal.fire({
                        text: '¡No se pudo eliminar la evaluación!',
                        icon: 'error',
                        confirmButtonText: 'Cerrar',
                        confirmButtonColor: '#d33',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                }
            }
        });

    });
};

const validarEstadoAvance = (selectEstado, idA) => {

    const form = document.querySelector(`#formEvaluacion${idA}`);
    let avance = form.querySelector('[name="avance"]');
    let ejec = form.querySelector('[name="ejecutadas"]').value;

    if (selectEstado.value !== 'COMPLETO') {
        avance.value = 0;
    } else {
        calcularAvance(ejec, idA);
    }
};

const calcularAvance = (accionesEjecutadas, idA) => {

    const form = document.querySelector(`#formEvaluacion${idA}`);
    const estado = form.querySelector('[name="estado"]').value;
    const avance = form.querySelector('[name="avance"]');

    /* Regla de negocio: solo se calcula si está COMPLETO */
    if (estado !== 'COMPLETO') {
        avance.value = 0;
        return;
    }

    const planeadas = parseInt(form.querySelector('[name="accionesPlaneadas"]').value) || 0;
    const ejecut = parseInt(accionesEjecutadas) || 0;

    let porcentaje = 0;
    if (planeadas > 0) {
        porcentaje = ((ejecut / planeadas) * 100).toFixed(2);
        if (porcentaje > 100) porcentaje = 100;
    }
    avance.value = porcentaje;
};


const validarFechaSeguimiento = (input) => {
    const form = input.closest('form');
    if (!form) return;
    let inicioStr = form.getAttribute('data-fecha-inicio');
    let finStr = form.getAttribute('data-fecha-fin');
    if (!inicioStr || !finStr) return;

    input.min = inicioStr;
    input.max = finStr;

    if (input.value) {
        const sel = new Date(input.value);
        const ini = new Date(inicioStr);
        const fin = new Date(finStr);
        if (sel < ini || sel > fin) {
            input.setCustomValidity(
                `La Fecha Seguimiento debe estar entre ${inicioStr} y ${finStr}.`
            );
            input.reportValidity();
            return;
        }
    }
    input.setCustomValidity('');
}

// const terminarGestionPriorizacion = () => {
//     Swal.fire({
//         title: '¿Desea Finalizar la gestion de la Priorizacion?',
//         icon: 'question',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Sí, Terminar',
//         cancelButtonText: 'Cancelar',
//         allowOutsideClick: false,
//         allowEscapeKey: false
//     }).then(function (result) {

//         if (!result.isConfirmed) { return; }
//         const formData = new FormData();
//         formData.append('proceso', 'actualizarEstadoPriorizacion');
//         formData.append('user', userSession);
//         formData.append('idPrio', idPriorizacion);
//         formData.append('gestion', 'TERMINAR');

//         $.ajax({
//             url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
//             type: 'POST',
//             data: formData,
//             processData: false,
//             contentType: false,
//             dataType: 'json',
//             success: function (respuesta) {

//                 if (respuesta === 'ok') {
//                     Swal.fire({
//                         text: 'Gestion Finalizada Correctamente!',
//                         icon: 'success',
//                         confirmButtonText: 'Cerrar',
//                         confirmButtonColor: '#d33',
//                         allowOutsideClick: false,
//                         allowEscapeKey: false
//                     }).then(function () {
//                         window.location = 'index.php?ruta=pamec/listapriorizaciones';
//                     });
//                 } else {
//                     Swal.fire({
//                         text: '¡No se Finalizar la Gestion!',
//                         icon: 'error',
//                         confirmButtonText: 'Cerrar',
//                         confirmButtonColor: '#d33',
//                         allowOutsideClick: false,
//                         allowEscapeKey: false
//                     });
//                     console.error(respuesta);
//                 }
//             },
//         });
//     });
// }

const terminarGestionPriorizacion = () => {

    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'validarAntesCerrar',
            idPrio: idPriorizacion
        },
        dataType: 'json',
        success: function (respuesta) {

            let tituloSwal = '',
                htmlSwal = '',
                iconSwal = '',
                btnConfirm = '',
                btnCancel = 'Cancelar';

            if (respuesta.valida) {
                tituloSwal = '¿Desea finalizar la gestión de la priorización?';
                htmlSwal = '';
                iconSwal = 'question';
                btnConfirm = 'Sí, terminar';
            } else {
                tituloSwal = 'Se encontraron pendientes';
                htmlSwal = `<ul class="text-start mb-0">${respuesta.mensajes
                    .map(m => `<li>${m}</li>`).join('')}</ul>`;
                iconSwal = 'warning';
                btnConfirm = 'Sí, terminar gestión';
            }

            Swal.fire({
                title: tituloSwal,
                html: htmlSwal,
                icon: iconSwal,
                showCancelButton: true,
                confirmButtonText: btnConfirm,
                confirmButtonColor: '#3085d6',
                cancelButtonText: btnCancel,
                cancelButtonColor: '#d33',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function (result) {

                if (!result.isConfirmed) return;
                const formData = new FormData();
                formData.append('proceso', 'actualizarEstadoPriorizacion');
                formData.append('user', userSession);
                formData.append('idPrio', idPriorizacion);
                formData.append('gestion', 'TERMINAR');

                $.ajax({
                    url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (resp) {

                        if (resp === 'ok') {
                            Swal.fire({
                                text: '¡Gestión finalizada correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                confirmButtonColor: '#d33',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then(function () {
                                window.location =
                                    'index.php?ruta=pamec/listapriorizaciones';
                            });

                        } else {
                            Swal.fire({
                                text: '¡No se pudo finalizar la gestión!',
                                icon: 'error',
                                confirmButtonText: 'Cerrar',
                                confirmButtonColor: '#d33',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            });
                            console.error(resp);
                        }
                    }
                });
            });
        }
    });
};


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
                    return `<button class="btn btn-sm btn-danger m-1" onclick="eliminarAprendizajeOrg(${row.id_aprendizaje_organizacional})"><i class="fas fa-trash"></i></button>
                            <button class="btn btn-sm btn-info m-1" title="Ver detalle" onclick="cargarDetalleAprendizaje(${row.id_aprendizaje_organizacional})"><i class="fas fa-eye"></i></button>
        
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

const pintarEstadoAvance = (porcentaje = 0) => {

    let pct = parseFloat(porcentaje) || 0;
    let estadoTxt = pct === 100 ? 'COMPLETO' : 'INCOMPLETO';
    let colorFondo = pct === 100 ? coloresAvance.completo : coloresAvance.incompleto;

    $('#avancePorcentaje').val(pct);
    $('#estadoAprendizaje').val(estadoTxt);

    $('#vAvancePorcentaje').text(pct);
    $('#vEstadoAprendizaje').text(estadoTxt);

    $('#containerAvance').css({
        backgroundColor: colorFondo,
        border: `2px solid ${colorFondo}`,
        'border-radius': '10px'
    });
    $('#vEstadoAprendizaje').css('font-weight', '500');
};

function limpiarCamposIndicador() {
    $('#codigoEstandar, #estandar, #oportunidadMejora, #accionesCompletas,' +
        '#avancePorcentaje, #estadoAprendizaje, #metaAutoevaluacionAp,' +
        '#indicadorAp, #metaIndicadorAP, #calObsIniAuto, #calObsIniIndicador,' +
        '#calObsFin').val('');

    $('#vCodigoEstandar, #vEstandar, #vOportunidadMejora, #vAccionesCompletas,' +
        '#vAvancePorcentaje, #vEstadoAprendizaje, #vMetaAutoevaluacionAp,' +
        '#vIndicadorAp, #vMetaIndicadorAP, #vCalObsIniAuto, #vCalObsIniIndicador,' +
        '#vCalObsFin').text('');

    $('#containerAvance').removeAttr('style');

}

const llenarFormulario = (select) => {

    let indicadorSeleccionado = select.value;

    if (!indicadorSeleccionado) {
        limpiarCamposIndicador();
        return;
    }

    $.ajax({
        url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'verAprendizajeOrg',
            idPrio: idPriorizacion,
            indicador: indicadorSeleccionado
        },
        dataType: 'json',
        success: function (resp) {

            $('#codigoEstandar').val(resp.codigo_estandar);
            $('#estandar').val(resp.estandar);
            $('#oportunidadMejora').val(resp.oportunidades_mejora);
            $('#accionesCompletas').val(resp.acciones_completas);
            $('#avancePorcentaje').val(resp.avance);
            $('#metaAutoevaluacionAp').val(resp.meta_autoevaluacion);
            $('#indicadorAp').val(resp.nombre_indicador);
            $('#metaIndicadorAP').val(resp.meta_indicador);
            $('#calObsIniAuto').val(resp.cal_obs_ini);
            $('#calObsIniIndicador').val(resp.resultado_indicador);
            $('#calObsFin').val(resp.cal_obs_final);

            $('#vCodigoEstandar').text(resp.codigo_estandar);
            $('#vEstandar').text(resp.estandar);
            $('#vOportunidadMejora').text(resp.oportunidades_mejora);
            $('#vAccionesCompletas').text(resp.acciones_completas);
            $('#vAvancePorcentaje').text(resp.avance);
            $('#vMetaAutoevaluacionAp').text(resp.meta_autoevaluacion);
            $('#vIndicadorAp').text(resp.nombre_indicador);
            $('#vMetaIndicadorAP').text(resp.meta_indicador);
            $('#vCalObsIniAuto').text(resp.cal_obs_ini);
            $('#vCalObsIniIndicador').text(resp.resultado_indicador);
            $('#vCalObsFin').text(resp.cal_obs_final);

            pintarEstadoAvance(resp.avance);
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
                    $('#formAprendizajeOrg')[0].reset();
                    limpiarCamposIndicador();
                    $('#containerAvance').removeAttr('style');
                    initAprendizajeOrg();
                } else if (res === 'sin_evaluacion') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Indicador incompleto',
                        text: 'El indicador seleccionado aún no posee acciones de mejora con evaluaciones de ejecución. Complete al menos una evaluación antes de registrar el aprendizaje.',
                        confirmButtonColor: '#3085d6'
                    });
                }
                else {
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

// const editarAprendizajeOrg = (id) => {
//     $.ajax({
//         url: 'ajax/pamec/gestionarpriorizacion.ajax.php',
//         type: 'POST',
//         data: { proceso: 'verAprendizajeOrgById', idAprendizaje: id },
//         dataType: 'json'
//     }).done(row => {
//         const form = document.getElementById('formAprendizajeOrg');
//         form.idAprendizaje.value = row.id_aprendizaje;
//         form.obs1.value = row.observaciones;
//         form.barrerasMejora.value = row.barreras_mejoramiento;
//         form.obsAprendizajeOrganizacional.value = row.aprendizaje_organizacional;
//         window.scrollTo({ top: form.offsetTop - 100, behavior: 'smooth' });
//     });
// };

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



tablaListaPriorizacionGenerales = $('#tablaListaPriorizacionGenerales').DataTable({
    scrollX: true,
    columns: [
        { name: '#', data: 'id_respuesta_priorizacion' },
        { name: 'AUTOEVALUACION', data: 'id_autoevaluacion' },
        { name: 'GRUPO', data: 'grupo' },
        { name: 'ESTANDAR', data: 'estandar' },
        { name: 'SEDES', data: 'sedes' },
        {
            name: 'OPORTUNIDAD DE MEJORA',
            data: 'oportunidades_mejora',
            width: '250px',
            render: function (data, type, row) {
                return `<textarea class="form-control" rows="3" readonly>${$('<div>').text(row.oportunidades_mejora).html()}</textarea>`;
            }
        },
        {
            name: 'ACCIONES OPORTUNIDADES',
            data: 'acciones_oportunidades',
            width: '250px',
            render: function (data, type, row) {
                return `<textarea class="form-control" rows="3" readonly>${$('<div>').text(row.acciones_oportunidades).html()}</textarea>`;
            }

        },
        {
            name: 'RIESGO', render: function (data, type, row) {
                let titleOpciones = riesgoOptions.join('\n');
                return `<p title="${titleOpciones}" class="p-4 text-center" style="background-color: ${coloresSelects[row.riesgo]};">
                          ${row.riesgo}
                        </p>`;
            }
        },
        {
            name: 'COSTO', render: function (data, type, row) {
                let titleOpciones = costoOptions.join('\n');
                return `<p title="${titleOpciones}" class="p-4 text-center" style="background-color: ${coloresSelects[row.costo]};">
                          ${row.costo}
                        </p>`;
            }
        },
        {
            name: 'VOLUMEN', render: function (data, type, row) {
                let titleOpciones = volumenOptions.join('\n');
                return `<p title="${titleOpciones}" class="p-4 text-center" style="background-color: ${coloresSelects[row.volumen]};">
                          ${row.volumen}
                        </p>`;
            }
        },
        {
            name: 'NIVEL DE ESTIMACION', render: function (data, type, row) {
                let titleNE = '';
                if (row.nivel_estimacion <= 30) {
                    titleNE = 'Oportunidad de Mejora no prioritaria. La Alta Dirección determina su viabilidad y factibilidad para ser o no aplicada en el largo plazo'
                } else if (row.nivel_estimacion >= 31 && row.nivel_estimacion <= 60) {
                    titleNE = 'Oportunidad de Mejora no prioritaria.  Requiere tratamiento en el largo plazo. Requiere de seguimiento constante.'
                } else if (row.nivel_estimacion >= 61 && row.nivel_estimacion <= 90) {
                    titleNE = 'Se requiere de la implementación de la oportunidad de mejora en el corto plazo. Su implementación es de carácter prioritario.'
                } else {
                    titleNE = 'Implementación inmediata de la oportunidad de mejora.  Se debe prevenir de forma rapida la ocurrencia de la(s) consecuencia(s) que se generen de la no aplicación de la oportunidad de mejora.'
                }
                return `<p title="${titleNE}" class="p-4 text-center" style="background-color: ${colorNivelEstimacion([row.nivel_estimacion])}">${row.nivel_estimacion}</p>`
            }
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                if (row.estadoPriorizacion == 'CREADO') {
                    // <!-- <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPriorizacion(${row.id_respuesta_priorizacion})" title="Eliminar Priorizacion"><i class="fas fa-trash-alt"></i></button>-->
                    return `
                    <button title='gestionar priorizacion'type="button" class="btn btn-success btn-sm" onclick="gestionarPriorizacion(${row.id_respuesta_priorizacion})"><i class="far fa-check-square"></i></button>
                    `;
                } else if (row.estadoPriorizacion == 'PROCESO') {
                    // <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPriorizacion(${row.id_respuesta_priorizacion})" title="Eliminar Priorizacion"><i class="fas fa-trash-alt"></i></button>
                    return `
                    <button title='gestionar priorizacion'type="button" class="btn btn-success btn-sm" onclick="gestionarPriorizacion(${row.id_respuesta_priorizacion})"><i class="far fa-check-square"></i></button>
                    `;

                } else if (row.estadoPriorizacion == 'FINALIZADO') {
                    console.log(row.estadoPriorizacion);
                    return ``;
                }

            }
        }
    ],
    ordering: false,
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excel',
            text: 'Descargar Excel',
            className: 'btn btn-phoenix-success',
        },
    ],
    ajax: {
        url: 'ajax/pamec/autoevaluacion.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPriorizacionesGeneral',
        }
    },
})

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
                botones += `<button type="button" class="btn btn-danger btn-sm m-1" onclick="eliminarCalidadEsperada(${row.id_calidad_esperada})" title="Eliminar Calidad Esperada"><i class="fas fa-trash-alt"></i></button>`

                if (parseInt(row.existe_observada) === 0) {
                    botones += `<button title='Crear Calidad Observada'type="button" data-bs-toggle="modal" data-bs-target="#modalCalidadObservada" class="btn btn-success btn-sm m-1" onclick="crearCalidadObservada(${row.id_calidad_esperada})"><i class="fas fa-plus"></i></button>`
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

tablaAprOrgGeneral = $('#tablaListaAprendizajeOrgGeneral').DataTable({
    scrollX: true,
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
        { name: 'PRIORIZACIÓN', data: 'id_respuesta_priorizacion' },
        { name: 'CODIGO', data: 'codigo_estandar' },
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
            proceso: 'listarAprendizajeOrgGeneral'
        }
    }
});





$(document).ready(async () => {
    cargarInfoGeneral();
    verificaPestaniaActivas();
    verificaPestaEval();
});




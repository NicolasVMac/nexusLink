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
let idAutoevaluacion = atob(getParameterByName('idAutoEva'));
let url = new URL(window.location.href);
let rutaValor = url.searchParams.get("ruta");
let paramAutoEva = url.searchParams.get("idAutoEva");
console.log(idAutoevaluacion);
let riesgoOptions = [];
let costoOptions = [];
let volumenOptions = [];
const coloresSelects = {
    '1': '#a3ff73', // Verde oscuro
    '2': '#d1ffb9', // Verde claro
    '3': '#fffa96', // Amarillo
    '4': '#ffcb9f', // Naranja
    '5': '#ff9f9f'  // Rojo
};
/*
3. FUNCIONES
*/
const loadingFnc = () => {

    Swal.fire({
        title: 'Guardando...',
        text: 'Por favor espera mientras se guarda la información.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

}
//Cargar Grupos
$.ajax({
    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaGrupoEstandaresAutoevaluacion'
    },
    success: function (respuesta) {
        $("#selGrupo").html(respuesta);
    }
});
// Cargar SubGrupos
const onGrupoLoadSubGrupo = (selectGrupo) => {
    let grupo = selectGrupo.value;
    $.ajax({
        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaSubGrupoEstandaresAutoevaluacion',
            'grupo': grupo
        },
        success: function (respuesta) {
            $("#selSubGrupo").html(respuesta);
        }
    });
    $("#selEstandar").html("");

};
//CargarEstandares
const onSubGrupoLoadEstandar = (selectSubGrupo) => {
    let subGrupo = selectSubGrupo.value;
    let grupo = $("#selGrupo").val();
    $.ajax({
        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaEstandaresAutoevaluacion',
            'grupo': grupo,
            'subGrupo': subGrupo
        },
        success: function (respuesta) {
            $("#selEstandar").html(respuesta);
        }
    });
};
//CargarCriterios
const onEstandarCriterio = () => {
    let estandar = $("#selEstandar").val();
    console.log(estandar);
    $.ajax({
        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'obtenerCriteriosEstandar',
            'estandar': estandar
        },
        dataType: 'json',
        success: function (respuesta) {
            let textoConSaltos = respuesta.replace(/•/g, '<br>•');
            $('#divCriterios').html(textoConSaltos);
        }
    });
};
$('#selEstandar').on('change', onEstandarCriterio);

// // Cargar proceso
$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        lista: 'listaProcesoEstandaresAutoevaluacion',
    },
    success: (resp) => {
        $('#selProceso').html(resp);
    }
});
//cargar Periodo Autoevaluacion
$.ajax({
    type: 'POST',
    url: 'ajax/pamec/autoevaluacion.ajax.php',
    data: {
        proceso: 'periodoAutoevaluacionActivo',
    },
    dataType: 'json',
    success: (resp) => {
        $('#periodoAutoevaluacion').val(resp.periodo);
    }
});

//cargarSedes
const onEstandarLoadSedes = (selectEstandar) => {
    let estandar = selectEstandar.value;
    let periodoAutoeva = $('#periodoAutoevaluacion').val()
    $.ajax({
        type: 'POST',
        url: 'ajax/pamec/autoevaluacion.ajax.php',
        data: {
            proceso: 'sedesNoEvaluadasPorEstandar',
            codigo: estandar,
            periodo: periodoAutoeva

        },
        dataType: 'json',
        success: (resp) => {
            // console.log(resp);
            $('#selSedesPamec').html('');
            resp.forEach(sede => {
                $('#selSedesPamec').append(`<option value="${sede}">${sede}</option>`);
            });
        }
    });
};

//cargarProgramas
const onEstandarLoadProgramas = (selectEstandar) => {
    let estandar = selectEstandar.value;
    let periodoAutoeva = $('#periodoAutoevaluacion').val()

    $.ajax({
        type: 'POST',
        url: 'ajax/pamec/autoevaluacion.ajax.php',
        data: {
            proceso: 'programasNoEvaluadosPorEstandar',
            codigo: estandar,
            periodo: periodoAutoeva
        },
        dataType: 'json',
        success: (resp) => {
            // console.log(resp);
            $('#selProgramasPamec').html('');
            resp.forEach(programa => {
                $('#selProgramasPamec').append(`<option value="${programa}">${programa}</option>`);
            });
        }
    });
};


// guardar informacion general autoevaluacion
function guardarInfoGeneral() {
    let formulario = document.getElementById("formInfoGeneral");
    let elementos = formulario.elements;
    let errores = 0;
    let form = document.querySelector('#formInfoGeneral');
    let periodo = document.getElementById("periodoAutoevaluacion").value.trim();

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {
        if (!periodo) {
            return toastr.warning("Debes tener un periodo activo antes de guardar", "¡Atención!");
        }
        if (formulario.checkValidity()) {
            const formData = new FormData(form);
            formData.append('user', userSession);
            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }
            // Formatear sedes seleccionadas
            let selSedes = document.getElementById("selSedesPamec");
            let cadenaSedes = "";
            for (let i = 0; i < selSedes.options.length; i++) {
                if (selSedes.options[i].selected) {
                    cadenaSedes += selSedes.options[i].value + '-';
                }
            }
            cadenaSedes = cadenaSedes.slice(0, -1);
            // Formatear programas seleccionados
            let selProgramas = document.getElementById("selProgramasPamec");
            let cadenaProgramas = "";
            for (let i = 0; i < selProgramas.options.length; i++) {
                if (selProgramas.options[i].selected) {
                    cadenaProgramas += selProgramas.options[i].value + '-';
                }
            }
            cadenaProgramas = cadenaProgramas.slice(0, -1);
            // console.log(cadenaProgramas);
            // console.log(cadenaSedes);
            formData.set('selSedesPamec', cadenaSedes);
            formData.set('selProgramasPamec', cadenaProgramas);

            if (formData.get('idAutoevaluacion')) {
                formData.append('proceso', 'actualizarInfoGeneralAutoevaluacion');
                formData.append('idAutoevaluacion', idAutoevaluacion);
                $.ajax({
                    url: 'ajax/pamec/autoevaluacion.ajax.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (respuesta) {

                        if (respuesta === 'ok') {
                            Swal.fire({
                                text: '¡Los Datos Generales de la Autoevaluacion guardaron correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });

                        } else {

                            Swal.fire({

                                text: '¡Los Datos Generales de la Autoevaluacion no se guardaron correctamente!',
                                icon: 'error',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33",

                            })

                        }

                    },
                });

            } else {
                formData.append('proceso', 'guardarInfoGeneralAutoevaluacion');

                $.ajax({
                    url: 'ajax/pamec/autoevaluacion.ajax.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (respuesta) {

                        if (respuesta.status === 'ok') {

                            Swal.fire({
                                text: '¡Los Datos Generales de la Autoevaluacion guardaron correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) => {

                                if (result.isConfirmed) {

                                    window.location = 'index.php?ruta=pamec/autoevaluacion&idAutoEva=' + btoa(respuesta.idAutoevaluacion);

                                }

                            })

                        } else {

                            Swal.fire({

                                text: '¡Los Datos Generales de la Autoevaluacion no se guardaron correctamente!',
                                icon: 'error',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33",

                            })

                        }

                    },
                });
            }
        } else {
            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");
            return;
        }
    } else {
        toastr.warning("Hay campos con errores manuales", "¡Atencion!");
        return;
    }

}

//mostrar la informacion general en la pagina asi se recargur
const mostrarInfoGeneralAutoEvaluacion = (idAutoevaluacion) => {

    if (!idAutoevaluacion) {
        console.log('No tiene IdAutoevaluacion');
        return;
    }

    $.ajax({
        type: "POST",
        url: "ajax/pamec/autoevaluacion.ajax.php",
        data: {
            proceso: "obtenerInfoAutoevaluacion",
            idAutoEva: idAutoevaluacion
        },
        dataType: "json",
        success: (respAuto) => {

            // console.log(respAuto);
            $("#idAutoevaluacion").val(respAuto.id_autoevaluacion);
            //SELECT GRUPO
            $.ajax({
                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaGrupoEstandaresAutoevaluacion'
                },
                success: function (respuesta) {
                    $("#selGrupo").html(respuesta);
                    $("#selGrupo").val(respAuto.grupo);
                }
            });

            //SELECT SUBGRUPO
            $.ajax({
                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaSubGrupoEstandaresAutoevaluacion',
                    'grupo': respAuto.grupo
                },
                success: function (respuesta) {
                    $("#selSubGrupo").html(respuesta);
                    $("#selSubGrupo").val(respAuto.subgrupo);
                }
            });

            //SELECT ESTANDAR
            $.ajax({
                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'listaEstandaresAutoevaluacion',
                    'grupo': respAuto.grupo,
                    'subGrupo': respAuto.subgrupo
                },
                success: function (respuesta) {
                    $("#selEstandar").html(respuesta);
                    $("#selEstandar").val(respAuto.codigo);
                }
            });
            estandarListaPrio = respAuto.codigo;
            // DIV CRITERIOS
            $.ajax({
                type: "POST",
                url: "ajax/parametricas.ajax.php",
                data: {
                    'lista': 'obtenerCriteriosEstandar',
                    'estandar': respAuto.codigo
                },
                dataType: 'json',
                success: function (respuesta) {
                    let textoConSaltos = respuesta.replace(/•/g, '<br>•');
                    $('#divCriterios').html(textoConSaltos);
                }
            });

            //SELECT PROCESO
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    lista: 'listaProcesoEstandaresAutoevaluacion',
                },
                success: (resp) => {
                    $('#selProceso').html(resp);
                    $('#selProceso').val(respAuto.proceso);

                }
            });
            //SELECT AUTOEVALUACION
            $('#periodoAutoevaluacion').val(respAuto.periodo_autoevaluacion);

            //SELECT SEDES
            let sedesActuales = respAuto.sede ? respAuto.sede.split('-') : [];

            $.ajax({
                type: 'POST',
                url: 'ajax/pamec/autoevaluacion.ajax.php',
                data: {
                    proceso: 'sedesNoEvaluadasPorEstandar',
                    codigo: respAuto.codigo,
                    periodo: respAuto.periodo_autoevaluacion
                },
                dataType: 'json',
                success: (respNoEvaluadas) => {
                    let todas = unirArreglosSinDuplicados(sedesActuales, respNoEvaluadas);
                    $('#selSedesPamec').html('');

                    for (let sede of todas) {
                        $('#selSedesPamec').append(`<option value="${sede}">${sede}</option>`);
                    }

                    $('#selSedesPamec').val(sedesActuales);
                    $('#selSedesPamec').select2();
                }
            });

            //SELECT PROGRAMAS
            let programasActuales = respAuto.programa ? respAuto.programa.split('-') : [];

            $.ajax({
                type: 'POST',
                url: 'ajax/pamec/autoevaluacion.ajax.php',
                data: {
                    proceso: 'programasNoEvaluadosPorEstandar',
                    codigo: respAuto.codigo,
                    periodo: respAuto.periodo_autoevaluacion
                },
                dataType: 'json',
                success: (respNoEvaluados) => {
                    let todos = unirArreglosSinDuplicados(programasActuales, respNoEvaluados);
                    $('#selProgramasPamec').html('');

                    for (let programa of todos) {
                        $('#selProgramasPamec').append(`<option value="${programa}">${programa}</option>`);
                    }
                    $('#selProgramasPamec').val(programasActuales);
                    $('#selProgramasPamec').select2();
                }
            });

        }
    });

};
const unirArreglosSinDuplicados = (opcionesSeleccionadas, opcionesPosibles) => {
    let total = [];

    for (let opcion of opcionesSeleccionadas) {
        total.push(opcion);
    }

    for (let opcion of opcionesPosibles) {
        total.push(opcion);
    }

    let resultadoFinal = [];
    for (let opcion of total) {
        if (resultadoFinal.indexOf(opcion) === -1) {
            resultadoFinal.push(opcion);
        }
    }

    return resultadoFinal;
};


//obtener preguntas, es decir , fortalezas,soporte de fortalezas
const obtenerPreguntasCualitativasAutoevaluacion = async () => {
    try {
        const formData = new FormData();
        formData.append('proceso', 'listaPreguntasCualitativasAutoevaluacion');
        const respuesta = await $.ajax({
            url: 'ajax/pamec/autoevaluacion.ajax.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json'
        });

        return respuesta;
    } catch (error) {
        console.error('Error obteniendo preguntas cualitativas:', error);
        return null;
    }
};
//generar collapse dinamicamente
const generarCollapseCualitativas = async () => {
    const preguntas = await obtenerPreguntasCualitativasAutoevaluacion();
    if (!Array.isArray(preguntas)) {
        console.warn('No hay preguntas cualitativas o hubo error en la respuesta');
        return;
    }
    let html = ``;
    for (const p of preguntas) {
        let idVariable = p.id_variable;
        let campoRespuesta = await generarCampoRespuestaAutoevaluacionCualitativa(p);

        html += `
        <div class="accordion-item border-top border-300">
            <h2 class="accordion-header" id="heading-${idVariable}">
                <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse-${idVariable}"
                    aria-expanded="true"
                    aria-controls="collapse-${idVariable}"
                    >
                    ${p.variable}
                </button>
            </h2>
            <div
                id="collapse-${idVariable}"
                class="accordion-collapse collapse"
                aria-labelledby="heading-${idVariable}"
                data-bs-parent="#accordionCualitativa">
                <div class="accordion-body pt-0" id="container-${idVariable}">
                ${campoRespuesta}
                </div>
            </div>
        </div>
        `;
    }
    $("#accordionCualitativa").html(html);

    mostrarInfoCualitativaAutoEvaluacion(idAutoevaluacion);

};
//generar text area
const generarCampoRespuestaAutoevaluacionCualitativa = async (pregunta) => {
    let campoRespuesta = '';
    if (pregunta.tipo_pregunta == 'textarea') {

        campoRespuesta += `<textarea type="text" rows="5" class="form-control" idVariable="${pregunta.id_variable}" name="variable${pregunta.id_variable}" id="variable${pregunta.id_variable}" maxlength="5000" required ></textarea>`;

    }
    campoRespuesta += `<input type="hidden" idVariable="${pregunta.id_variable}" name="idVariableCualitativa${pregunta.id_variable}" id="idVariableCualitativa${pregunta.id_variable}" value="${pregunta.id_variable}" >`;
    return campoRespuesta;
};
//formatear mis datos para poder insertarlos en la tabla (respuestas_cualitativa)
async function transformarRespuestasCualitativas(formData) {
    const respuestasCualitativas = [];

    for (let [key, value] of formData.entries()) {

        if (key.startsWith("variable") && !key.startsWith("idVariable")) {
            // Saca el sufijo "1", "2", ...
            let sufijo = key.replace("variable", "");
            let keyIdVar = "idVariableCualitativa" + sufijo;
            let idVar = formData.get(keyIdVar);

            // Generamos la estructura final 
            respuestasCualitativas.push({
                id_variable: idVar,
                descripcion: value.toUpperCase()
            });
        }
    }
    return respuestasCualitativas;
}
//guardar los datos de cualitativa
const guardarCualitativa = async () => {
    const form = document.getElementById('formCualitativa');
    const formData = new FormData(form);
    let elementos = form.elements;
    let errores = 0;

    // 1. Revisar si hay elementos con la clase 'is-invalid' (igual que en guardarInfoGeneral)
    Array.from(elementos).forEach(el => {
        if (el.className.includes('is-invalid')) {
            errores++;
        }
    });
    if (errores === 0) {
        if (form.checkValidity()) {
            Swal.fire({
                title: `¿Desea guardar la Evaluacion Cualitativa?`,
                icon: 'question',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si!"
            }).then(async (result) => {
                if (result.isConfirmed) {

                    const arrayRespuestas = await transformarRespuestasCualitativas(formData);
                    const data = new FormData();
                    data.append('idAutoEva', idAutoevaluacion);
                    data.append('user', userSession);
                    data.append('respuestasCualitativas', JSON.stringify(arrayRespuestas));

                    if (formData.get('idRespuestaCualitativa')) {
                        data.append('proceso', 'actualizarInfoCualitativa');

                        $.ajax({
                            url: 'ajax/pamec/autoevaluacion.ajax.php',
                            type: 'POST',
                            data: data,
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            success: (resp) => {
                                if (resp === 'ok') {
                                    Swal.fire({
                                        text: '¡Los Datos de la evaluación Cualitativa se guardaron correctamente!',
                                        icon: 'success',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                } else {

                                    Swal.fire({

                                        text: '¡Los Datos de la evaluacion Caulitativa no se guardaron correctamente!',
                                        icon: 'error',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33",

                                    })

                                }
                            }
                        });
                    } else {
                        data.append('proceso', 'guardarInfoCualitativa');
                        $.ajax({
                            url: 'ajax/pamec/autoevaluacion.ajax.php',
                            type: 'POST',
                            data: data,
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            success: (resp) => {
                                if (resp === 'ok') {
                                    Swal.fire({
                                        text: '¡Los Datos de la evaluación Cualitativa se guardaron correctamente!',
                                        icon: 'success',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                } else {

                                    Swal.fire({

                                        text: '¡Los Datos de la evaluacion Caulitativa no se guardaron correctamente!',
                                        icon: 'error',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33",

                                    })

                                }
                            }
                        });
                    }

                }

            })
        } else {

            const requiredTextareas = formCualitativa.querySelectorAll('textarea[required]');
            let abiertoAlguno = false;
            for (const ta of requiredTextareas) {
                if (!ta.value.trim()) {
                    const accordionItem = ta.closest('.accordion-item');
                    if (accordionItem) {
                        const collapseDiv = accordionItem.querySelector('.accordion-collapse');
                        if (collapseDiv) {
                            new bootstrap.Collapse(collapseDiv, { show: true });
                        }
                    }
                    abiertoAlguno = true;
                    break;
                }
            }
            toastr.warning("Debe diligenciar todos los campos de la evaluación cualitativa.", "¡Atención!");
            return;

        }
    } else {
        toastr.warning("Hay campos con errores manuales", "¡Atencion!");
        return;
    }

};
//mostrar la informacion general en la pagina asi se recargur   
const mostrarInfoCualitativaAutoEvaluacion = (idAutoevaluacion) => {


    if (!idAutoevaluacion) {
        console.log('No tiene IdAutoevaluacion');
        return;
    }

    $.ajax({
        type: "POST",
        url: "ajax/pamec/autoevaluacion.ajax.php",
        data: {
            proceso: "obtenerInfoCualitativaAutoevaluacion",
            idAutoEva: idAutoevaluacion
        },
        dataType: "json",
        success: (respCualit) => {

            // console.log(respCualit);
            respCualit.forEach(item => {
                $("#idRespuestaCualitativa").val(item.id_autoevaluacion);
                let idVar = 'variable' + item.id_variable;
                const textarea = document.querySelector(`#${idVar}`);
                if (textarea) {
                    textarea.value = item.descripcion;
                }
            });

        }
    });

};



// obtener dimensiones
const obtenerDimensionesCuantitativaAutoevaluacion = async () => {
    try {
        const respuesta = await $.ajax({
            type: "POST",
            url: "ajax/pamec/autoevaluacion.ajax.php",
            data: { proceso: "listaDimensionesCuantitativaAutoevaluacion" },
            dataType: "json"
        });
        return respuesta;
    } catch (error) {
        console.error("Error obteniendo dimensiones:", error);
        return [];
    }
};
//obtener variables
const obtenerVariablesDeDimension = async (dimension) => {
    try {
        const respuesta = await $.ajax({
            type: "POST",
            url: "ajax/pamec/autoevaluacion.ajax.php",
            data: {
                proceso: "listaVariablesDimension",
                dimension: dimension
            },
            dataType: "json"
        });
        return respuesta;
    } catch (error) {
        console.error("Error obteniendo variables:", error);
        return [];
    }
};
//obtener descripciones y escalas
const obtenerPreguntasCuantitativas = async (dimension, variable) => {
    try {
        const formData = new FormData();
        formData.append('proceso', 'listaRespuestasVariables');
        formData.append('dimension', dimension);
        formData.append('variable', variable);

        const respuesta = await $.ajax({
            url: 'ajax/pamec/autoevaluacion.ajax.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json'
        });
        return respuesta;
    } catch (error) {
        console.error('Error obteniendo preguntas cuantitativas:', error);
        return null;
    }
};

//generar tabla de cuantitativas
const generarTablasEscalasCuantitativas = async (bodyContent) => {
    let dimensiones = await obtenerDimensionesCuantitativaAutoevaluacion();
    if (!dimensiones || dimensiones.length === 0) {
        console.error("Dimensiones Vacías Generando Tablas");
        return;
    }
    for (const dim of dimensiones) {
        const nombreDimension = dim.dimension || "SIN_DIMENSION";
        //creacion tabla
        let tableDimension = document.createElement("table");
        tableDimension.className = `table table-striped table-bordered table-dimension-${nombreDimension}`;

        // Thead
        let tableDimensionHeader = document.createElement("thead");
        tableDimensionHeader.innerHTML = `
        <tr>
          <th colspan="2" style="text-align: center">${nombreDimension}</th>
        </tr>
      `;

        // Tbody
        let tableDimensionBody = document.createElement("tbody");
        tableDimensionBody.className = `tableBody${nombreDimension}`;

        tableDimension.append(tableDimensionHeader, tableDimensionBody);

        bodyContent.appendChild(tableDimension);
        await generarCamposTablasCuantitativas(nombreDimension, tableDimensionBody);
    }
};
//generar campos tablas cuantitativas
const generarCamposTablasCuantitativas = async (dimension, tableBodyElement) => {

    const variables = await obtenerVariablesDeDimension(dimension);
    if (!variables) {
        console.log('No existen variables');
        return;
    }

    for (const v of variables) {
        // const arrayRespuestasVariable = await obtenerPreguntasCuantitativas(dimension, varPrueba);
        // console.log(respuestas);
        // const varTexto = v.variable || "SIN_VARIABLE";
        const campoRespuesta = await generarCampoRespuestaAutoevaluacionCuantitativa(v);
        const fila = document.createElement("tr");
        fila.innerHTML = `
        <td style="width:50%;">${v.variable}</td>
        <td style="width:50%;">${campoRespuesta}</td>
        `;

        tableBodyElement.appendChild(fila);

    }


};
//generar campo de respuesta
const generarCampoRespuestaAutoevaluacionCuantitativa = async (v) => {

    let idSelect = `select-${v.variable.split(' ').join('')}`;
    let selectHTML = `<select class="form-control" id="${idSelect}" name="select-${v.variable}" style="width:100%" required><option value="">Seleccione una Respuesta</option>`;

    const arrayRespuestasVariable = await obtenerPreguntasCuantitativas(v.dimension, v.variable);

    for (const rv of arrayRespuestasVariable) {

        selectHTML += `<option value="${rv.id_escala}">${rv.descripcion}</option>`;


    }

    selectHTML += `</select>`;


    // await reloadSelect(idSelect);

    return selectHTML;

};
//reload select field
const reloadSelect = async (idSelect) => {
    // $(`#${idSelect}`).select2();
    $(`.select-field-cuanti`).select2({ theme: 'bootstrap-5' });

}
//formatear datos para envio a bd
async function transformarRespuestasCuantitativas(formData) {
    const respuestasCuantitativas = [];

    for (let [key, value] of formData.entries()) {
        if (key.startsWith("select-") && value !== "") {
            let variable = key.replace("select-", ""); // Extrae la variable
            respuestasCuantitativas.push({
                variable: variable,
                id_escala: value,
            });
        }
    }

    return respuestasCuantitativas;
}
//envio de datos cuantitativos a bd
const guardarCuantitativa = async () => {
    const form = document.getElementById('formCuantitativa');
    const formData = new FormData(form);
    let elementos = form.elements;
    let errores = 0;

    // 1. Revisar si hay elementos con la clase 'is-invalid' (igual que en guardarInfoGeneral)
    Array.from(elementos).forEach(el => {
        if (el.className.includes('is-invalid')) {
            errores++;
        }
    });
    if (errores === 0) {
        if (form.checkValidity()) {

            Swal.fire({
                title: `¿Desea guardar la Evaluacion Cuantitativa?`,
                icon: 'question',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si!"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const arrayRespuestas = await transformarRespuestasCuantitativas(formData);
                    const data = new FormData();
                    data.append('idAutoEva', idAutoevaluacion);
                    data.append('user', userSession);
                    data.append('respuestasCuantitativas', JSON.stringify(arrayRespuestas));

                    // for (const [key, value] of data) {
                    //     console.log(key, value);
                    // }

                    if (formData.get('idRespuestaCuantitativa')) {

                        data.append('proceso', 'actualizarInfoCuantitativa');
                        $.ajax({
                            url: 'ajax/pamec/autoevaluacion.ajax.php',
                            type: 'POST',
                            data: data,
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            success: (resp) => {
                                if (resp === 'ok') {
                                    Swal.fire({
                                        text: '¡Los Datos de la evaluación Cuantitativa se guardaron correctamente!',
                                        icon: 'success',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                } else {

                                    Swal.fire({

                                        text: '¡Los Datos de la evaluacion Cuantitativa no se guardaron correctamente!',
                                        icon: 'error',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33",

                                    })

                                }
                            }
                        });
                    } else {
                        data.append('proceso', 'guardarInfoCuantitativa');
                        $.ajax({
                            url: 'ajax/pamec/autoevaluacion.ajax.php',
                            type: 'POST',
                            data: data,
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            success: (resp) => {
                                if (resp === 'ok') {
                                    Swal.fire({
                                        text: '¡Los Datos de la evaluación Cuantitativa se guardaron correctamente!',
                                        icon: 'success',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                } else {

                                    Swal.fire({

                                        text: '¡Los Datos de la evaluacion Cuantitativa no se guardaron correctamente!',
                                        icon: 'error',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        confirmButtonColor: "#d33",

                                    })

                                }
                            }
                        });
                    }
                }

            })

        } else {
            toastr.warning("Debe diligenciar todos los campos de la evaluación cuantitativa.", "¡Atención!");
            return;

        }
    } else {
        toastr.warning("Hay campos con errores manuales", "¡Atencion!");
        return;
    }

};
//mostrar infoCuantitativa
const mostrarInfoCuantitativaAutoEvaluacion = (idAutoevaluacion) => {
    if (!idAutoevaluacion) {
        console.log('No tiene IdAutoevaluacion');
        return;
    }
    $.ajax({
        type: "POST",
        url: "ajax/pamec/autoevaluacion.ajax.php",
        data: {
            proceso: "obtenerInfoCuantitativaAutoevaluacion",
            idAutoEva: idAutoevaluacion
        },
        dataType: "json",
        success: (respuestas) => {
            respuestas.forEach(item => {
                $("#idRespuestaCuantitativa").val(item.id_autoevaluacion);
                const selectId = `select-${item.variable.split(' ').join('')}`;
                const select = document.getElementById(selectId);
                if (select) {
                    select.value = item.id_escala;
                } else {
                    console.warn(`No se encontró el select: ${selectId}`);
                }
            });
        }
    });
};

//estandares de priorizacion 
const onGrupoLoadEstandar = (selectGrupo) => {
    let grupo = selectGrupo.value;
    $.ajax({
        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaEstandaresPamecPriorizacionAutoevaluacion',
            'grupo': grupo,
        },
        success: function (respuesta) {
            $("#selEstandarPriorizacion").html(respuesta);
        }
    });
}
//cambio color  select
const cambioColorSelect = (select) => {
    const selectValor = select.value;
    const color = coloresSelects[selectValor];
    const selectId = select.id;
    const containerId = 'container-' + selectId;
    let $container = $('#' + containerId);
    if ($container.length === 0) {
        console.log("No existe el contenedor");
        return;
    }
    if (color) {
        $container.attr('style', `background-color: ${color} !important;`);
    } else {
        $container.removeAttr('style');
    }
}

const colorNivelEstimacion = (ne) => {
    if (ne >= 1 && ne <= 30) return '#a3ff73';  // Verde oscuro
    if (ne >= 31 && ne <= 60) return '#fffa96';  // Amarillo
    if (ne >= 61 && ne <= 90) return '#ffcb9f';  // Naranja
    if (ne >= 91) return '#ff9f9f';             // Rojo
};

//cambio color  nivel estimacion
const calculoNivelEstimacion = async () => {

    const onChangeNE = () => {
        let valRiesgo = parseInt($('#selRiesgoPrio').val() || 0, 10);
        let valCosto = parseInt($('#selCostoPriorizacion').val() || 1, 10);
        let valVolumen = parseInt($('#selVolumenPriorizacion').val() || 1, 10);

        let ne = valRiesgo * valCosto * valVolumen;
        $('#NEPriorizacion').val(ne);
        let color = colorNivelEstimacion(ne);
        if (color) {
            $('#containerNivelEstimacion').attr('style', 'background-color: ' + color + ' !important; border: 2px solid ' + color + ' !important;');
        } else {
            $('#containerNivelEstimacion').removeAttr('style');
        }
    };
    $('#selRiesgoPrio, #selCostoPriorizacion, #selVolumenPriorizacion').on('change', onChangeNE);
};

//guardar priorizacion
const guardarPriorizacion = async () => {
    $("#formPriorizacion textarea").each(function () {
        $(this).val($(this).val().toUpperCase());
    });

    const form = document.getElementById('formPriorizacion');
    const formData = new FormData(form);
    let elementos = form.elements;
    let errores = 0;
    let selGrupoVal = $('#selGrupo').val();
    let selEstandarVal = $('#selEstandar').val();
    let selSedesVals = $('#selSedesPamec').val() ? $('#selSedesPamec').val().join('-') : '';
    let var3 = $('#variable3').val() || '';
    let var5 = $('#variable5').val() || '';

    // 1. Revisar si hay elementos con la clase 'is-invalid' (igual que en guardarInfoGeneral)
    Array.from(elementos).forEach(el => {
        if (el.className.includes('is-invalid')) {
            errores++;
        }
    });
    if (errores === 0) {
        if (form.checkValidity()) {
            if (!var3.trim()) {
                toastr.warning("Debe diligenciar y guardar la informacion del campo Oportunidades para la mejora (cualitativa).", "¡Atención!");
                let collapse3 = document.getElementById('collapse-3');
                if (collapse3) new bootstrap.Collapse(collapse3, { show: true });
                let campo3 = document.getElementById('variable3');
                if (campo3) campo3.focus();
                return;
            }
            if (!var5.trim()) {
                toastr.warning("Debe diligenciar y guardar la informacion del campo Acciones para las oportunidades (cualitativa).", "¡Atención!");
                let collapse5 = document.getElementById('collapse-5');
                if (collapse5) new bootstrap.Collapse(collapse5, { show: true });
                let campo5 = document.getElementById('variable5');
                if (campo5) campo5.focus();
                return;
            }

            formData.append('grupo', selGrupoVal);
            formData.append('estandar', selEstandarVal);
            formData.append('sedes', selSedesVals);
            formData.append('variable3', var3);
            formData.append('variable5', var5);
            formData.append('idAutoEva', idAutoevaluacion);
            formData.append('user', userSession);
            formData.append('proceso', 'guardarInfoPriorizacion');

            // for (const [key, value] of formData) {
            //     console.log(key, value);
            // }

            $.ajax({
                url: 'ajax/pamec/autoevaluacion.ajax.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: (resp) => {
                    if (resp === 'ok') {
                        Swal.fire({
                            text: '¡La Evaluación de Priorizacion se guardaron correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {

                        Swal.fire({

                            text: '¡La Evaluacion Priorizacion no se guardaron correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }
                }
            });

        } else {
            toastr.warning("Debe diligenciar todos los campos de la priorizacion.", "¡Atención!");
            return;

        }
    } else {
        toastr.warning("Hay campos con errores manuales", "¡Atencion!");
        return;
    }

};

const eliminarPriorizacion = (id_respuesta_priorizacion) => {

    Swal.fire({
        title: `¿Desea eliminar la priorizacion: ${id_respuesta_priorizacion}?`,
        icon: 'question',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si!"
    }).then(async (result) => {
        if (result.isConfirmed) {
            $.ajax({

                url: 'ajax/pamec/autoevaluacion.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarPriorizacionAutoEvaluacion',
                    'id_respuesta_priorizacion': id_respuesta_priorizacion,
                    'user': userSession
                },
                dataType: 'json',
                success: function (respuesta) {

                    if (respuesta == 'ok') {

                        Swal.fire({
                            text: '¡La priorizacion se Elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Gestionar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#3085d6"
                        }).then((result) => {

                            if (result.isConfirmed) {

                                window.location.reload();

                            }

                        })


                    } else {

                        Swal.fire({
                            title: 'Error!',
                            text: '¡La priorizacion no se pudo eliminar correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })


                    }

                }

            })

        }

    })


}
//obtener array de opciones tittle
$.ajax({
    type: "POST",
    url: "ajax/pamec/autoevaluacion.ajax.php",
    data: { proceso: "listarOpcionesRespPriorizacion" },
    dataType: "json",
    success: function (resp) {
        riesgoOptions = resp[1] || [];
        costoOptions = resp[2] || [];
        volumenOptions = resp[3] || [];
    }
});


const terminarGestion = () => {
    Swal.fire({
        title: `¿Desea finalizar la gestion de la Autoevaluacion?`,
        icon: 'question',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si!"
    }).then(async (result) => {
        if (result.isConfirmed) {

            const formData = new FormData();
            formData.append('proceso', 'terminarGestionAutoevaluacion');
            formData.append('user', userSession);
            formData.append('idAutoeva', idAutoevaluacion);

            // for (const [key, value] of formData) {
            //     console.log(key, value);
            // }

            $.ajax({
                url: 'ajax/pamec/autoevaluacion.ajax.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: (resp) => {
                    if (resp === 'ok') {
                        Swal.fire({
                            text: '¡La Autoevaluacion fue gestionada correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = 'index.php?ruta=pamec/autoevaluacion';
                            }
                        });
                    } else if (resp === 'sin_priorizacion') {

                        Swal.fire({

                            text: '¡No se ha realizado la priorizacion!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    } else if (resp === 'sin_cualitativa') {

                        Swal.fire({

                            text: '¡No se ha realizado la evaluacion cualitativa!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    } else if (resp === 'sin_cuantitativa') {

                        Swal.fire({

                            text: '¡No se ha realizado la evaluacion cuantitativa!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    } else {

                        Swal.fire({

                            text: '¡No se pudo finalizar la gestion de la autoevaluacion!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }
                }
            });


        }

    })
}

const noAplicaCualiCuantiPriorizacion = () => {

    Swal.fire({
        title: `¿Esta Seguro que el Estandar no Aplica?`,
        icon: 'question',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si!"
    }).then(async (result) => {
        if (result.isConfirmed) {

            const formData = new FormData();
            formData.append('proceso', 'guardarNoAplicaAutoevaluacion');
            formData.append('idAutoeva', idAutoevaluacion);
            formData.append('user', userSession);

            // for (const [key, value] of formData) {
            //     console.log(key, value);
            // }

            $.ajax({
                url: 'ajax/pamec/autoevaluacion.ajax.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: (resp) => {
                    if (resp === 'ok') {
                        Swal.fire({
                            text: '¡Estandar no Aplicado!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = 'index.php?ruta=pamec/autoevaluacion';
                            }
                        });
                    } else {
                        Swal.fire({
                            text: '¡No se pudo Guardar!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }
                }
            });


        }

    })

}

const gestionarAutoevaluacion = (idautoevaluacion, estado, accion) => {

    if (estado == 'TERMINADO') {
        if (accion == 'ver') {
            window.location = 'index.php?ruta=pamec/verautoevaluacion&idAutoEva=' + btoa(idautoevaluacion);
        } else {
            window.location = 'index.php?ruta=pamec/evaluadorgestionautoevaluacion&idAutoEva=' + btoa(idautoevaluacion);
        }
    } else if (estado == 'PROCESO' || estado == 'PENDIENTE') {
        if (accion == 'ver') {
            window.location = 'index.php?ruta=pamec/verautoevaluacion&idAutoEva=' + btoa(idautoevaluacion);
        } else {
            window.location = 'index.php?ruta=pamec/autoevaluacion&idAutoEva=' + btoa(idautoevaluacion);
        }
    } else if (estado == 'NO APLICA') {
        if (accion == 'ver') {
            window.location = 'index.php?ruta=pamec/verautoevaluacion&idAutoEva=' + btoa(idautoevaluacion);
        }
    }

}

const validarArchivoPDF = async (archivo) => {
    let archivos = archivo.files;
    let noValid = false;
    if (archivos.length > 0) {
        for (const item of archivos) {
            if (item["type"] != "application/pdf") {
                noValid = true;
            }
        }
        if (noValid) {
            Swal.fire({

                title: "Archivo No Valido",
                text: "¡Los archivos debe tener formato .PDF!",
                icon: "error",
                confirmButtonText: "¡Cerrar!",
                confirmButtonColor: "#d33"

            });
        }

        return noValid;


    } else {

        Swal.fire({

            title: "Archivo No Valido",
            text: "¡Los archivos debe tener formato .PDF!",
            icon: "error",
            confirmButtonText: "¡Cerrar!",
            confirmButtonColor: "#d33"

        });

    }

}
const cargarPdfEvidencias = async () => {


    let formulario = document.getElementById("formCargarPdfEvidencias");
    let elementos = formulario.elements;
    let errores = 0;

    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()) {

            let form = document.querySelector('#formCargarPdfEvidencias');

            const formData = new FormData(form);

            let nuevoArchivoEvidencia = document.getElementById("nuevoArchivoEvidencia");

            formData.append('proceso', 'cargarArchivosEvidenciaAutoevaluacion');
            formData.append('user', userSession);
            formData.append('idAutoEva', idAutoevaluacion);
            for (let file of nuevoArchivoEvidencia.files) {
                formData.append('archivoEvidencia[]', file);
            }
            let validFiles = await validarArchivoPDF(nuevoArchivoEvidencia);

            if (!validFiles) {

                loadingFnc();

                $.ajax({

                    url: 'ajax/pamec/autoevaluacion.ajax.php',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {

                        Swal.close();

                        if (respuesta == 'ok') {

                            Swal.fire({
                                text: '¡Se Cargo la Evidencia de la Evaluacion!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) => {

                                if (result.isConfirmed) {

                                    window.location.reload();

                                }

                            })

                        } else {

                            Swal.fire({
                                text: '¡No se Cargo la Evidencia de la Evaluacion!',
                                icon: 'error',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            })


                        }


                    }

                })

            }



        } else {

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }


}
const mostrarArchivosAutoevaluacion = (idAutoEva) => {
    $.ajax({
        url: 'ajax/pamec/autoevaluacion.ajax.php',
        type: 'POST',
        data: {
            proceso: 'infoAutoevaluacionArchivos',
            idAutoEva: idAutoEva,
        },
        dataType: 'json',
        success: function (data) {
            if (data.archivos === 'SIN ARCHIVOS') {
                $("#contenedorArchivosAutoevaluacion").html(`<div class="alert alert-soft-warning text-center" role="alert">SIN ARCHIVOS DE EVIDENCIA</div>`);
            } else {
                let html = `<div class="alert alert-soft-success text-center" role="alert">
                        <b>ARCHIVOS DE EVIDENCIA AUTOEVALUACION</b>
                        <br><br>
                        <ul class="list-group">`;
                for (const archivo of data.archivos) {
                    html += ` <li class="list-group-item"><i class="fas fa-trash-alt text-danger" onclick="eliminarArchivoPdfAutoevaluacion('${data.ruta_archivos}', '${archivo}','${idAutoEva}')" style="cursor: pointer"></i> <a href="${data.ruta_archivos + archivo}" target="_blank">${archivo}</a></li>`;
                }
                html += `</ul></div>`;
                $("#contenedorArchivosAutoevaluacion").html(html);
            }
        }
    });
};

const eliminarArchivoPdfAutoevaluacion = (rutaArchivo, archivo, idAutoEva) => {
    Swal.fire({
        title: `¿Desea eliminar el archivo: ${archivo}?`,
        icon: 'warning',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Sí, eliminar!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: 'ajax/pamec/autoevaluacion.ajax.php',
                type: 'POST',
                data: {
                    proceso: 'eliminarArchivoEvidencia',
                    rutaArchivo: rutaArchivo,
                    archivo: archivo,
                    idAutoEva: idAutoEva,
                    user: userSession
                },
                success: function (respuesta) {

                    if (respuesta == 'ok') {
                        Swal.fire({
                            text: '¡El archivo se eliminó correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            confirmButtonColor: "#d33"
                        }).then((r) => {
                            if (r.isConfirmed) location.reload();
                        });
                    } else {
                        Swal.fire({
                            text: 'No se pudo eliminar el archivo.',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            confirmButtonColor: "#d33"
                        });
                    }

                }
            });

        }

    });

};

if (rutaValor == 'pamec/autoevaluacion' && paramAutoEva) {
    mostrarArchivosAutoevaluacion(idAutoevaluacion);
    const noAplicanBtn = document.getElementById("noAplica");
    const terminarBtn = document.getElementById("terminarGestion");

    if (noAplicanBtn) {
        noAplicanBtn.style.display = "block";
    }
    if (terminarBtn) {
        terminarBtn.style.display = "block";
    }
    //cargar variables de Priorizacion
    const tipos = [
        { tipo: 1, selector: "#selRiesgoPrio" },
        { tipo: 2, selector: "#selCostoPriorizacion" },
        { tipo: 3, selector: "#selVolumenPriorizacion" },
    ];
    tipos.forEach(item => {
        $.ajax({
            type: "POST",
            url: "ajax/parametricas.ajax.php",
            data: {
                'lista': 'listaVariablesPriorizacionAutoevaluacion',
                'tipoVariable': item.tipo
            },
            success: function (respuesta) {
                $(item.selector).html(respuesta);
            }
        });
    });
    mostrarInfoGeneralAutoEvaluacion(idAutoevaluacion);
    generarCollapseCualitativas();
    const bodyContent = document.getElementById("contenedorTablasCuantitativas");
    generarTablasEscalasCuantitativas(bodyContent).then(() => {
        mostrarInfoCuantitativaAutoEvaluacion(idAutoevaluacion);
    });
    calculoNivelEstimacion();


} else if (rutaValor == 'pamec/verautoevaluacion' || rutaValor == 'pamec/detallegestionpamec') {
    mostrarArchivosAutoevaluacion(idAutoevaluacion);
    mostrarInfoGeneralAutoEvaluacion(idAutoevaluacion);
    generarCollapseCualitativas();
    const bodyContent = document.getElementById("contenedorTablasCuantitativas");
    generarTablasEscalasCuantitativas(bodyContent).then(() => {
        mostrarInfoCuantitativaAutoEvaluacion(idAutoevaluacion);
    });
    calculoNivelEstimacion();
} else if (rutaValor == 'pamec/evaluadorgestionautoevaluacion') {
    mostrarArchivosAutoevaluacion(idAutoevaluacion);
    mostrarInfoGeneralAutoEvaluacion(idAutoevaluacion);
    generarCollapseCualitativas();
    const bodyContent = document.getElementById("contenedorTablasCuantitativas");
    generarTablasEscalasCuantitativas(bodyContent).then(() => {
        mostrarInfoCuantitativaAutoEvaluacion(idAutoevaluacion);
    });
    calculoNivelEstimacion();
}

/*
4. TABLAS
*/

tablaListaPriorizacion = $('#tablaListaPriorizacion').DataTable({
    scrollX: true,
    columns: [
        { name: '#', data: 'id_respuesta_priorizacion' },
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
                return `
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPriorizacion(${row.id_respuesta_priorizacion})" title="Eliminar Priorizacion"><i class="fas fa-trash-alt"></i></button>
                `;
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
            'proceso': 'listaPriorizacionesAutoevaluacion',
            'idAutoeva': idAutoevaluacion,
        }
    },
})

tablaEvaluadoListaAutoevaluaciones = $('#tablaEvaluadoListaAutoevaluaciones').DataTable({
    columns: [
        { name: '#', data: 'id_autoevaluacion' },
        { name: 'GRUPO', data: 'grupo' },
        { name: 'SUB GRUPO', data: 'subgrupo' },
        { name: 'ESTANDAR', data: 'codigo' },
        { name: 'SEDE', data: 'sede' },
        { name: 'PROGRAMA', data: 'programa' },
        { name: 'ESTADO', data: 'estado' },
        { name: 'FECHA CREA', data: 'fecha_crea' },
        { name: 'FECHA FIN', data: 'fecha_fin' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                if (row.estado === 'TERMINADO') {
                    return `
                    <button type="button" class="btn btn-info btn-sm" onclick="gestionarAutoevaluacion(${row.id_autoevaluacion},'${row.estado}','ver')" title="ver autoevaluacion"><i class="fas fa-eye"></i></button>
                `;
                } else if (row.estado === 'PENDIENTE' || row.estado === 'PROCESO') {
                    return `
                    <button title='ver autoevaluacion' type="button" class="btn btn-info btn-sm" onclick="gestionarAutoevaluacion(${row.id_autoevaluacion},'${row.estado}','ver')"><i class="fas fa-eye"></i></button>
                    <button title='gestionar autoevaluacion'type="button" class="btn btn-success btn-sm" onclick="gestionarAutoevaluacion(${row.id_autoevaluacion},'${row.estado}','gestionar')"><i class="far fa-check-square"></i></button>
                `;
                } else if (row.estado === 'NO APLICA') {
                    return `
                    <button title='ver autoevaluacion' type="button" class="btn btn-info btn-sm" onclick="gestionarAutoevaluacion(${row.id_autoevaluacion},'${row.estado}','ver')"><i class="fas fa-eye"></i></button>
                `;
                }
            }
        }
    ],
    order: [[0, 'desc']],
    ajax: {
        url: 'ajax/pamec/autoevaluacion.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaMisAutoevaluaciones',
            'user': userSession
        }
    }
});

tablaEvaluadorListaAutoevaluaciones = $('#tablaEvaluadorListaAutoevaluaciones').DataTable({
    columns: [
        { name: '#', data: 'id_autoevaluacion' },
        { name: 'GRUPO', data: 'grupo' },
        { name: 'SUB GRUPO', data: 'subgrupo' },
        { name: 'ESTANDAR', data: 'codigo' },
        {
            name: 'SEDE',
            orderable: false,
            render: function (data, type, row) {
                if (!row.sede) return '';
                let sedesArr = row.sede.split('-');
                let badges = sedesArr.map((sede) => {
                    let sedeTrim = sede.trim();
                    return `<span class="badge badge-phoenix fs--2 badge-phoenix-info me-1"><span class="badge-label">${sedeTrim}</span></span>`;
                }).join('');
                return badges;
            }
        },
        {
            name: 'PROGRAMA',
            orderable: false,
            render: function (data, type, row) {
                if (!row.programa) return '';
                let programaArr = row.programa.split('-');
                let badges = programaArr.map((programa) => {
                    let programaTrim = programa.trim();
                    return `<span class="badge badge-phoenix fs--2 badge-phoenix-success me-1"><span class="badge-label">${programaTrim}</span></span>`;
                }).join('');
                return badges;
            }
        },
        // { name: 'PROGRAMA', data: 'programa' },
        { name: 'ESTADO', data: 'estado' },
        { name: 'USUARIO', data: 'usuario' },
        { name: 'FECHA CREA', data: 'fecha_crea' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                if (row.estado === 'PROCESO' || row.estado === 'ABIERTO' || row.estado === 'PENDIENTE') {
                    return `
                    <button title='ver autoevaluacion' type="button" class="btn btn-info btn-sm" onclick="gestionarAutoevaluacion(${row.id_autoevaluacion},'${row.estado}','ver')"><i class="fas fa-eye"></i></button>
                    <button title='gestionar autoevaluacion'type="button" class="btn btn-success btn-sm" onclick="gestionarAutoevaluacion(${row.id_autoevaluacion},'${row.estado}','gestionar')"><i class="far fa-check-square"></i></button>
                `;
                } else if (row.estado === 'TERMINADO') {
                    return `
                    <button title='ver autoevaluacion' type="button" class="btn btn-info btn-sm" onclick="gestionarAutoevaluacion(${row.id_autoevaluacion},'${row.estado}','ver')"><i class="fas fa-eye"></i></button>
                `;
                }
            }
        }
    ],
    order: [[0, 'desc']],
    ajax: {
        url: 'ajax/pamec/autoevaluacion.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaAutoevaluacionesVerEvaluador'
        }
    }
});

tablaListaPriorizacionVer = $('#tablaListaPriorizacionVer').DataTable({

    columns: [
        { name: '#', data: 'id_respuesta_priorizacion' },
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
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pamec/autoevaluacion.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPriorizacionesAutoevaluacion',
            'idAutoeva': idAutoevaluacion
        }
    },
})


/*
5. document.ready
*/
$(document).ready(async () => {
});


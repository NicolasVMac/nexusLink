/*==============================
VARIABLES DE RUTA
==============================*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let idEncuesta = atob(getParameterByName('idEncuesta'));
let especialidad = atob(getParameterByName('especialidad'));
// let paso = atob(getParameterByName('paso'));
// let procesoEncuesta = atob(getParameterByName('procesoEncuesta'));
let tabGestionEncuesta = document.querySelector('#tabGestionEncuesta');
let tabContentGestionEncuesta = document.querySelector('#tabContentGestionEncuesta');
let contenedorBotonSegmento = document.querySelector('#contenedorBotonSegmento');
let contentEncuesta = document.querySelector('#content-encuesta');

let tablaProcesosGestionEncuesta;

let arrayProcesos = [];

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


const arraySegmentosEncuesta = async (procesoEncuesta) => {

    let datos = new FormData();
    datos.append('proceso','listaSegmentosProcesoEncuesta');
    datos.append('idEncuProceso', procesoEncuesta);

    const segmentos = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!segmentos){

        console.error("Segmentos Vacios"); 
        return;
    }

    return segmentos;
    
}

const arrayPreguntasSegmentosEncuesta = async (idSegmento) => {

    if(!idSegmento){

        console.error("Id Segmento Vacio"); 
        return;
    }

    let datos = new FormData();
    datos.append('proceso','listaPreguntasSegmentosEncuesta');
    datos.append('idEncuSegmento', idSegmento);

    const preguntas = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!preguntas){

        console.error("Preguntas Segmentos Vacios"); 
        return;
    }
    
    return preguntas;

}

const obtenerPreguntasEncuestaProceso = async (idEncuProceso) => {

    let datos = new FormData();
    datos.append('proceso','listaPreguntasEncuestaProceso');
    datos.append('idEncuProceso', idEncuProceso);

    const preguntasProceso = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!preguntasProceso){

        console.error("Preguntas Proceso Vacios"); 
        return;
    }

    return preguntasProceso;

}

const validacionTerminarEncuesta = async () => {

    const validacion = await $.ajax({

        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'validacionTerminarEncuesta',
            'idEncuesta': idEncuesta
        }
    });

    if(!validacion){

        console.error("Validacion no existe"); 
        return;
    }

    // console.log(segmentos);

    return validacion;


}


const obtenerCalificacionesEncuesta = async () => {

    const calificaciones = await $.ajax({

        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'obtenerCalificacionesEncuesta',
            'idEncuesta': idEncuesta
        },
        dataType:'json'
    });

    if(!calificaciones){

        console.error("calificaciones no existe"); 
        return;
    }

    // console.log(segmentos);

    return calificaciones;


}

const terminarEncuesta = async () => {

    let validacion = await validacionTerminarEncuesta();

    if(validacion == 'encuestas-pendientes'){

        Swal.fire({
            title: 'Error!',
            text: '¡La Encuesta no se puede terminar porque tiene Profesionales pendiente por Gestionar!',
            icon: 'error',
            confirmButtonText: 'Cerrar',
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonColor: "#d33"
        })

    }else{

        let calificaciones = await obtenerCalificacionesEncuesta();

        let cadena = `<b>Resultado Encuesta</b>:<br><br>`;

        for(let calificacion of calificaciones){

            //ARRAY ID PROCESOS DE INSTRUMENTOS
            let arrayInstrumentos = [20, 21];
            let calificacionProceso = '';

            if(arrayInstrumentos.includes(Number(calificacion.id_encu_proceso))){
                calificacionProceso = calificacion.calificacion == '0.00' ? 'NO APLICA' : calificacion.calificacion;
            }else{
                calificacionProceso = calificacion.calificacion;
            }


            cadena += `<b>${calificacion.proceso}:</b> ${calificacionProceso}<br>`;

        }

        cadena += `<br>¿Desea terminar Auditoria?<br>`;

        Swal.fire({
            html: `${cadena}`,
            icon: 'info',
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            confirmButtonText: "¡Terminar Auditoria!"
        }).then(async (result) => {
    
            if (result.isConfirmed){

                loadingFnc();

                $.ajax({

                    url: 'ajax/encuestas/encuestas-profesional.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'terminarEncuesta',
                        'idEncuesta': idEncuesta
                    },
                    success: function(respuesta){
                        
                        Swal.close();

                        if(respuesta == 'ok'){

                            Swal.fire({
                                text: '¡La Auditoria se termino correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{
            
                                if(result.isConfirmed){
            
                                    window.location = 'index.php?ruta=encuestas/bolsaaudprofesional';
            
                                }
            
                            })

                        }else{

                            Swal.fire({
                                title: 'Error!',
                                text: '¡La Auditoria no se termino correctamente!',
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

}

const guardarRespuestaEncuesta = async (respuestaEncuesta, idEncuProceso, resultadoCalificacionProceso) => {

    // console.log(respuestaEncuesta);

    loadingFnc();

    $.ajax({

        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'guardarRespuestasEncuesta',
            'arrayRespuestas': respuestaEncuesta,
            'idEncuProceso':idEncuProceso,
            'idEncuesta': idEncuesta,
            'calificacionProceso': resultadoCalificacionProceso
        },
        success: async function(respuesta){

            Swal.close();

            if(respuesta == 'ok'){

                //await terminarEncuesta(idEncuesta, tipoEncuesta);

                Swal.fire({
                    text: '¡La Auditoria Profesional se guardo correctamente!',
                    icon: 'success',
                    confirmButtonText: 'Cerrar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonColor: "#d33"
                }).then((result) =>{

                    if(result.isConfirmed){

                        window.location = 'index.php?ruta=encuestas/gestionarencuestapromodificar&idEncuesta='+btoa(idEncuesta)+'&especialidad='+btoa(especialidad);

                    }

                })


            }else if(respuesta == 'error-save-respuestas'){

                Swal.fire({
                    title: 'Error!',
                    text: '¡No se guardaron las respuestas de la Auditoria correstamente!',
                    icon: 'error',
                    confirmButtonText: 'Cerrar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonColor: "#d33"
                })


            }else if(respuesta == 'error-actualizacion'){

                Swal.fire({
                    title: 'Error!',
                    text: '¡No se logro actualizar la Nota del Proceso de la Auditoria!',
                    icon: 'error',
                    confirmButtonText: 'Cerrar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonColor: "#d33"
                })

            }else{

                Swal.fire({
                    title: 'Error!',
                    text: '¡Algo salio mal contacte el administrador!',
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




const mostrarInfoEncuesta = async (idEncuesta) => {

    $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'mostrarInfoEncuesta',
            'idEncuesta': idEncuesta,
        },
        cache: false,
        dataType: "json",
        success:function(respuesta){

            // console.log(respuesta);
            $("#textIdEncuesta").html(respuesta["id_encuesta"]);
            $("#textNoHistoriaClinica").html(respuesta["no_historia_clinica"]);
            $("#textNombrePaciente").html(respuesta["nombre_paciente"]);
            $("#textEdad").html(respuesta["edad"]);
            $("#textSexo").html(respuesta["sexo"]);
            $("#textEspecialidad").html(respuesta["especialidad"]);
            $("#textProfesionalAuditado").html(respuesta["profesional_auditado"]);
            $("#textSede").html(respuesta["sede"]);
            $("#textEps").html(respuesta["eps"]);
            $("#textFechaAtencion").html(respuesta["fecha_atencion"]);
            $("#textModalidadConsultaotipoAtencion").html(respuesta["modalidad_consulta_tipo_atencion"]);

        }

    })

}

const descartarEncuesta = () => {

    Swal.fire({
        title: "¿Desea Descartar la Auditoria?",
        icon: 'question',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Descartar Auditoria!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/encuestas/encuestas-profesional.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'descartarEncuesta',
                    'idEncuesta': idEncuesta
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Auditoria se descarto correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=encuestas/bolsaaudprofesional';

                            }

                        })

                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: '¡La Auditoria no se pudo descartar correctamente!',
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


const obtenerProcesosInicialesEncuesta = async (especialidad) => {

    let datos = new FormData();
    datos.append('proceso', 'obtenerProcesosInicialesEncuesta');
    datos.append('especialidad', especialidad);

    const arrayProcesosIniciales = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    //console.log(respuestaMenus);
    
    return arrayProcesosIniciales;

}

const obtenerProcesosGestionEncuesta = async (idEncuesta) => {

    let datos = new FormData();
    datos.append('proceso', 'obtenerProcesosGestionEncuesta');
    datos.append('idEncuesta', idEncuesta);

    const arrayProcesos = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    //console.log(respuestaMenus);
    
    return arrayProcesos;

}

const obtenerSegmentosEncuestaPorcentaje = async (idProcesoEncuesta) => {

    let datos = new FormData();
    datos.append('proceso','listaSegmentosProcesoEncuestaPorcentaje');
    datos.append('idEncuProceso', idProcesoEncuesta);

    const segmentos = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!segmentos){

        console.error("Segmentos Porcentaje Vacios"); 
        return;
    }

    // console.log(segmentos);

    return segmentos;    
}

const obtenerSegmentosEncuesta = async (idProcesoEncuesta) => {

    let datos = new FormData();
    datos.append('proceso','listaSegmentosProcesoEncuesta');
    datos.append('idEncuProceso', idProcesoEncuesta);

    const segmentos = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!segmentos){

        console.error("Segmentos Vacios"); 
        return;
    }

    // console.log(segmentos);

    return segmentos;    
}

const obtenerPreguntasSegmentosEncuesta = async (idSegmento) => {

    if(!idSegmento){

        console.error("Id Segmento Vacio"); 
        return;
    }

    let datos = new FormData();
    datos.append('proceso','listaPreguntasSegmentosEncuesta');
    datos.append('idEncuSegmento', idSegmento);

    const preguntas = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!preguntas){

        console.error("Preguntas Segmentos Vacios"); 
        return;
    }
    
    // await generarPreguntasSegmentos(preguntas);

    return preguntas;

}

const obtenerPreguntasSegmentosEncuestaRespuesta = async (idSegmento) => {

    if(!idSegmento){

        console.error("Id Segmento Vacio"); 
        return;
    }

    let datos = new FormData();
    datos.append('proceso','listaPreguntasSegmentosEncuestaRespuesta');
    datos.append('idEncuSegmento', idSegmento);
    datos.append('idEncuesta', idEncuesta);

    const preguntas = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!preguntas){

        console.error("Preguntas Segmentos Vacios"); 
        return;
    }
    
    // await generarPreguntasSegmentos(preguntas);

    return preguntas;

}


const generarBotonSaveProceso = async (id_encu_proceso, proceso) => {

    const formElement = document.querySelector(`.form-proceso-${id_encu_proceso}`);

    let botonSave = document.createElement('button');
    botonSave.type = 'submit';
    // botonSave.id = 'btnSaveEncuestaSegmento';
    botonSave.className = `btn btn-success ms-2 btn-proceso-${id_encu_proceso}`;
    botonSave.innerHTML = '<i class="fas fa-clipboard-list"></i> Guardar Proceso';
    botonSave.onclick = async () => {
        await guardarProcesoEncuesta(id_encu_proceso, proceso);
    };

    formElement.appendChild(botonSave);
    
}

const generarTablaParaclinicos = async (especialidad) => {

    // console.log({tipoEncuesta});

    let datos = new FormData();
    datos.append('proceso','listaSegmentosParaclinicos');
    datos.append('especialidad', especialidad);

    const segmentosParaclinicos = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!segmentosParaclinicos){

        console.error("Segmentos Paraclinicos Vacios"); 
        return;
    }

    const contenedorTablesParaclinicos = document.querySelector('.contenedorTablasParaclinicos');

    for (const segmentoVal of segmentosParaclinicos) {

        const { id_encu_segmento, segmento, porcentaje_general  } = segmentoVal;

        const divColTable = document.createElement('div');
        divColTable.className = 'col-md-6 table-responsive';

        let tableSegmento = 'table'+id_encu_segmento;
        let tableSegmentoHeader = 'tableHeaders'+id_encu_segmento;

        tableSegmento = document.createElement('table');
        tableSegmento.className = `table table-striped table-bordered table-segmento-${id_encu_segmento} tableParaclinicos`;

        tableSegmentoHeader = document.createElement('thead');
        tableSegmentoHeader.innerHTML = `
            <tr>
                <th style="width: 35%; color: #25b003;">${segmento}</th>
                <th style="width: 40%; color: #25b003;">DESCRIPCION</th>
                <th style="width: 15%; color: #25b003;">RESPUESTA</th>
                <th style="width: 10%; color: #25b003;">${porcentaje_general}%</th>
            </tr>
        `;

        let tableSegmentoBody = 'tableBody'+id_encu_segmento;
        tableSegmentoBody = document.createElement('tbody');
        tableSegmentoBody.className = `tableBody${id_encu_segmento} tableBodyParaclinicos`;
        tableSegmento.append(tableSegmentoHeader, tableSegmentoBody);

        divColTable.appendChild(tableSegmento);
        contenedorTablesParaclinicos.appendChild(divColTable);

        await generarPreguntasSegmentos(id_encu_segmento, porcentaje_general);
        
    }



}

const generarTablaSegmentos = async (bodyContent, id_encu_proceso, proceso) => {

    // console.log(bodyContent);

    let segmentos = await obtenerSegmentosEncuesta(id_encu_proceso);

    if(!segmentos){

        console.error("Segmentos Vacios Generando Tablas"); 
        return;
    }

    let isTableParaClinicos = false;

    for(const segmentoEncuesta of segmentos){

        const { id_encu_segmento, segmento, porcentaje_general  } = segmentoEncuesta;
        
        const arrayParaclinicos = [3,4,10,11,17,18,24,25,67,68,75,76,83,84];


        if(!arrayParaclinicos.includes(parseInt(id_encu_segmento))){

            let tableSegmento = 'table'+id_encu_segmento;
            let tableSegmentoHeader = 'tableHeaders'+id_encu_segmento;

            tableSegmento = document.createElement('table');
            tableSegmento.className = `table table-striped table-bordered table-segmento-${id_encu_segmento}`;

            tableSegmentoHeader = document.createElement('thead');
            tableSegmentoHeader.innerHTML = `
                <tr>
                    <th style="width: 35%; color: #25b003;">${segmento}</th>
                    <th style="width: 40%; color: #25b003;">DESCRIPCION</th>
                    <th style="width: 15%; color: #25b003;">RESPUESTA</th>
                    <th style="width: 10%; color: #25b003;">${porcentaje_general}%</th>
                </tr>
            `;

            let tableSegmentoBody = 'tableBody'+id_encu_segmento;
            tableSegmentoBody = document.createElement('tbody');
            tableSegmentoBody.className = `tableBody${id_encu_segmento}`;
            tableSegmento.append(tableSegmentoHeader, tableSegmentoBody);

            bodyContent.appendChild(tableSegmento);

            await generarPreguntasSegmentos(id_encu_segmento, porcentaje_general);

            //GENERAMOS EL DIV QUE CONTENDRA LAS TABLAS DE PARACLINICOS
            //SEGMENTO ANTERIOR A PARACLINICO PARA GENERAR LA TABLA
            let arraySegmentoParaclinicos = [2,9,16,23,66,74,82];
            if(arraySegmentoParaclinicos.includes(Number(id_encu_segmento))){

                let divContainerTableParaclinicos = document.createElement('div');
                divContainerTableParaclinicos.className = 'row contenedorTablasParaclinicos';

                bodyContent.appendChild(divContainerTableParaclinicos);

            }


        }else{

            // isArrayParaclinicos.push(segmentoEncuesta);
            // await generarTablaParaclinicos(bodyContent);
            isTableParaClinicos = true;

            
        }

    }

    if(isTableParaClinicos){
        await generarTablaParaclinicos(especialidad);
    }
    await generarBotonSaveProceso(id_encu_proceso, proceso);

}



const agregarProfesional = () => {

    let formulario = document.getElementById("formAgregarProfesional");
    let elementos = formulario.elements;
    let errores = 0;

    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let procesoProfesional = document.getElementById('procesoProfesional');

            let procesoEncuestaIndex = procesoProfesional.selectedIndex;
            let procesoEncuestaSeleccionado = procesoProfesional.options[procesoEncuestaIndex];
            let idEncuProceso = procesoEncuestaSeleccionado.getAttribute("idEncuProceso");

            let auditorProceso = document.getElementById('auditorProceso').value;

            $.ajax({

                url: 'ajax/encuestas/encuestas-profesional.ajax.php',
                type: 'POST',
                data: {
                    'proceso':'agregarProfesional',
                    'procesoEncuesta':procesoProfesional.value,
                    'idEncuProceso':idEncuProceso,
                    'idEncuesta':idEncuesta,
                    'auditorProceso':auditorProceso,
                    'userSession':userSession
                },
                dataType: "json",
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡Se Agrego el Profesional correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Gestionar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#3085d6"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=encuestas/gestionarencuestapromodificar&idEncuesta='+btoa(idEncuesta)+'&especialidad='+btoa(especialidad);

                            }

                        })

                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: '¡No se pudo Agregar el Profesional correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }

                }

            })


        }else{

            toastr.warning("Debe seleccionar el Instrumento que quiere aplicar y el Auditor que lo realizara", "Error!");

        }

    }


}

const organizarRespuestasEncuesta = async (idEncuProceso, resultadoCalificacionProceso) => {

    let respuestaEncu = {}
                        
    let preguntasProceso = await obtenerPreguntasEncuestaProceso(idEncuProceso);

    for(const pregunta of preguntasProceso){

        let variableIdPregunta = "idPreguntaEncuesta"+pregunta["id_encu_pregunta"];
        let variable = "pregunta"+pregunta["id_encu_pregunta"];
        // console.log({variableIdPregunta});
        // console.log({variable});


        let idPregunta = document.getElementById(variableIdPregunta).value;
        let respuesta = document.getElementById(variable).value;

        // let dataPregunta = document.querySelector('#pregunta73');
        let dataPregunta = document.querySelector(`#${variable}`);

        if(dataPregunta.classList.contains('select-patologia')){

            let valoresSeleccionados = [];
            let cadena = '';

            for (var i = 0; i < dataPregunta.options.length; i++) {
                if (dataPregunta.options[i].selected) {
                    valoresSeleccionados.push(dataPregunta.options[i].value);
                    cadena += dataPregunta.options[i].value + '-'; 
                }
            }

            respuesta = cadena.slice(0, -1);

        }                     

        respuestaEncu[pregunta.id_encu_pregunta] = {

            id_encu_proceso: idEncuProceso,
            id_encuesta: idEncuesta,
            id_encu_pregunta: idPregunta,
            respuesta: respuesta,
            especialidad: especialidad,
            usuario_crea: userSession

        }

    }

    // console.log(respuestaEncu);

    await guardarRespuestaEncuesta(respuestaEncu, idEncuProceso, resultadoCalificacionProceso);

}

const guardarCalificacionSegmento = async (datos) => {

    $.ajax({

        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'guardarCalificacionSegmento',
            'datos':datos
        },
        success:async function(respuesta){

            if(respuesta != 'ok'){

                Swal.fire({
                    title: 'Error!',
                    text: '¡La Calificacion del Segmento no se guardo correctamente, contacte al adminsitrador!',
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

const mostrarCalificacionProcesoInput = async (idEncuProceso, nota) => {

    let inputCalificacion = document.querySelector(`#form-proceso-${idEncuProceso} .califacion-encuesta`);

    if(inputCalificacion){

        inputCalificacion.value = nota;

    }

}

const guardarProcesoEncuesta = async (idEncuProceso, proceso) => {

    const submitButton = document.querySelector(`.btn-proceso-${idEncuProceso}`);

    submitButton.disabled = true;

    Swal.fire({
        title: "¿Desea Guardar la Auditoria?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si!"
    }).then(async (result) => {

        if (result.isConfirmed){

            let formularioProceso = 'form-proceso-'+idEncuProceso; 
            
            let formulario = document.getElementById(formularioProceso);
            // console.log(formulario);
            let elementos = formulario.elements;
            let errores = 0;

            Array.from(elementos).forEach(function (element) { //array de elementos del Form
                if (element.className.includes('is-invalid')) {
                    errores += 1;
                }
            });

            if (formulario.checkValidity()){

                let segmentosResp = await obtenerSegmentosEncuesta(idEncuProceso);

                // console.log(segmentosResp);
                let calificacionProceso = [];
                let arrayDatosSegmentosSave = {}

                for(const segmento of segmentosResp){

                    let preguntasResp = await obtenerPreguntasSegmentosEncuesta(segmento.id_encu_segmento);
                    let calificacionSegmento = [];

                    // console.log(preguntasResp);

                    for(const pregunta of preguntasResp){

                        // console.log(pregunta);

                        let variableIdPregunta = "idPreguntaEncuesta"+pregunta["id_encu_pregunta"];
                        let variable = "pregunta"+pregunta["id_encu_pregunta"];

                        let idPregunta = document.getElementById(variableIdPregunta).value;
                        let respuesta = document.getElementById(variable).value;
                        let porcentajePregunta = document.querySelector(`.porcentaje-pregunta-${idPregunta}`).textContent.replace('%', '');


                        // console.log("idPregunta: " + idPregunta + " - Respuesta: " + respuesta + " - porcentajePregunta: " + porcentajePregunta);

                        if(document.getElementById(variable)){
                            // console.log(document.getElementById(variable));

                            if(Number(respuesta) === 1){

                                calificacionSegmento.push({
                                    idSegmento: segmento.id_encu_segmento,
                                    calificacion: parseFloat(porcentajePregunta)
                                });

                            }else if(Number(respuesta) === 0){

                                calificacionSegmento.push({
                                    idSegmento: segmento.id_encu_segmento,
                                    calificacion: 0
                                });
                                // calificacionSegmento.push(0);

                            }

                        }

                        let dataPregunta = document.querySelector(`#${variable}`);

                        if(dataPregunta.classList.contains('select-patologia')){

                            let valoresSeleccionados = [];
                            let cadena = '';

                            for (var i = 0; i < dataPregunta.options.length; i++) {
                                if (dataPregunta.options[i].selected) {
                                    valoresSeleccionados.push(dataPregunta.options[i].value);
                                    cadena += dataPregunta.options[i].value + '-'; 
                                }
                            }

                            if(valoresSeleccionados.length > 1){
                                if(valoresSeleccionados.includes('NINGUNA')){
                                    Swal.fire({
                                        text: 'Si selecciona NINGUNA no puede seleccionar otras Patologias.',
                                        icon: 'error',
                                        confirmButtonText: 'Cerrar',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    })

                                    submitButton.disabled = false;

                                    return;
                                }
                            }

                        }

                    }

                    // console.log({calificacionSegmento});

                    if(segmento.porcentaje_general != 0 && calificacionSegmento.length > 0){

                        // let sumaPreguntas = calificacionSegmento.calificacion.reduce((acumulador, elemento) => acumulador + elemento, 0);

                        let sumaPreguntas = 0;

                        calificacionSegmento.forEach(elem => {

                            sumaPreguntas = sumaPreguntas + elem.calificacion;

                        })

                        arrayDatosSegmentosSave[segmento.id_encu_segmento] = {
                            idEncuesta,
                            idEncuProceso,
                            idEncuSegmento: segmento.id_encu_segmento,
                            segmento: segmento.segmento,
                            notaSegmento: Math.round(sumaPreguntas).toFixed(2),
                            usuarioCrea:userSession
                        }
                        // // console.log({calificacionSegmento});
                        // // console.log("Segmento Porcentaje: ", segmento.porcentaje_general);
                        // // console.log({sumaPreguntas});
                        let ponderacion = sumaPreguntas * (segmento.porcentaje_general / 100);
                        // // console.log(ponderacion);
                        calificacionProceso.push({
                            idSegmento: Number(segmento.id_encu_segmento),
                            calificacion: parseFloat(ponderacion.toFixed(2))
                        });

                    }

                }

                // let resultadoCalificacionProceso = Math.round(calificacionProceso.reduce((acumulador, elemento) => acumulador + elemento, 0)).toFixed(2);

                let segmentosPorcentaje = await obtenerSegmentosEncuestaPorcentaje(idEncuProceso);

                // console.log({segmentosPorcentaje});

                // console.log({calificacionProceso});

                let resultadoCalificacionProceso = 0;

                if(calificacionProceso.length < segmentosPorcentaje.length){

                    segmentosPorcentaje.forEach(segmento => {

                        //VALIDAMOS SI FALTA LA CALIFICACION DE ALGUN SEGEMENTO SI NO EXISTE ENTONCES AGREGAMOS EL PORCENTAJE DE ESE SEGMENTO Y AQUE SE MARCO COMO NA 
                        const existe = calificacionProceso.some(caliSegmento =>
                            Number(caliSegmento.idSegmento) === Number(segmento.id_encu_segmento)
                        );
                    
                        if(!existe){

                            let porSegNotExis = Number(segmento.porcentaje_general);

                            calificacionProceso.push({
                                idSegmento: Number(segmento.id_encu_segmento),
                                calificacion: parseFloat(porSegNotExis.toFixed(2))
                            })
                            // console.log(`El idSegmento ${segmento.id_encu_segmento} NO existe en segmentosPorcentaje`);
                        }

                    });

                    let sumaSegmentos = 0;

                    calificacionProceso.forEach(elem => {

                        sumaSegmentos = sumaSegmentos + elem.calificacion;

                    })

                    resultadoCalificacionProceso = Math.round(sumaSegmentos).toFixed(2);


                }else{

                    let sumaSegmentos = 0;

                    calificacionProceso.forEach(elem => {

                        sumaSegmentos = sumaSegmentos + elem.calificacion;

                    })

                    resultadoCalificacionProceso = Math.round(sumaSegmentos).toFixed(2);

                }

                // console.log(resultadoCalificacionProceso);

                // let resultadoCalificacionProceso = Math.round(calificacionProceso.reduce((acumulador, elemento) => acumulador + elemento, 0)).toFixed(2);
                // console.log('Calificacion Encuesta:', sumaCaliEncuesta/calificacionSegmento.length);
                // let resultadoCalificacion = (sumaCaliEncuesta/calificacionProceso.length).toFixed(2);
                // let inputCalifacion = document.querySelector('.califacion-encuesta');
                // console.log({inputCalifacion});
                // console.log({resultadoCalificacionProceso});
                // inputCalifacion.value = parseInt(resultadoCalificacionProceso);

                let arrayInstrumentos = [20, 21];
                let calificacionProcesoFinal = '';

                if(arrayInstrumentos.includes(Number(idEncuProceso))){
                    calificacionProcesoFinal = 'NO APLICA';
                }else{
                    calificacionProcesoFinal = resultadoCalificacionProceso;
                }

                // let calificacionProcesoFinal = resultadoCalificacionProceso == '0.00' ? 'NO APLICA o 0.00' : resultadoCalificacionProceso;

                // if(calificacionProcesoFinal != 'NO APLICA'){
                await mostrarCalificacionProcesoInput(idEncuProceso, resultadoCalificacionProceso);
                // }


                Swal.fire({
                    html: `La Califacion obtenida en ${proceso} es: <b>${calificacionProcesoFinal}</b>,<br>¿Desea guardar Auditoria?`,
                    icon: 'info',
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    showCancelButton: true,
                    confirmButtonText: "¡Si, Guardar Auditoria!"
                }).then(async (result) => {

                    if (result.isConfirmed){

                        //ELIMINAR CALIFICACION PROCESO, SEGMENTO Y RESPUESTAS
                        await eliminarCalificacionesSegmentosRespuestas(idEncuesta, idEncuProceso);

                        if(Object.keys(arrayDatosSegmentosSave).length > 0){
                            await guardarCalificacionSegmento(arrayDatosSegmentosSave);
                        }
                        await organizarRespuestasEncuesta(idEncuProceso, resultadoCalificacionProceso);

                    }else{

                        submitButton.disabled = false;

                    }

                })

            }else{

                submitButton.disabled = false;
                toastr.warning("Recurde que debe diligenciar todos los campos del Formulario", "Error!");

            }

        }else{

            submitButton.disabled = false;

        }

    })
    

}

const eliminarCalificacionesSegmentosRespuestas = async (idEncuesta, idEncuProceso) => {

    // console.log(idEncuesta, ' - ', idEncuProceso);

    let datos = new FormData();
    datos.append('proceso', 'eliminarCalificacionesSegmentosRespuestas');
    datos.append('idEncuesta', idEncuesta);
    datos.append('idEncuProceso', idEncuProceso);

    const eliminar = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    // console.log(eliminar);
    return eliminar;

}

const actualizarPorcentajePregunta = async (idEncuSegmento, porcentaje) => {

    let respuestas = document.querySelectorAll(`.table-segmento-${idEncuSegmento} .select-respuesta`);

    respuestas.forEach(respuesta => {
        
        // console.log({respuesta});
        // const { idPreg } = respuesta.attributes.idPregunta.value;

        const { value: idPreg } = respuesta.attributes.idPregunta;

        if(respuesta.value == 'NA'){

            let tdPorcentajeRespuesta = document.querySelector(`.porcentaje-pregunta-${idPreg}`);
            // console.log(tdPorcentajeRespuesta);
            tdPorcentajeRespuesta.innerText = '0.00%';

        }else{

            let tdPorcentajeRespuesta = document.querySelector(`.porcentaje-pregunta-${idPreg}`);
            // console.log(tdPorcentajeRespuesta);
            tdPorcentajeRespuesta.innerText = `${porcentaje}%`;

        }

    })

}

const validarPorcentajeSegmento = async (idEncuSegmento) => {

    let respuestas = document.querySelectorAll(`.table-segmento-${idEncuSegmento} .select-respuesta`);

    // console.log(respuestas.length);

    let arrayNa = [];

    respuestas.forEach(respuesta => {

        //console.log(respuesta.id, ' = ' ,respuesta.value);

        if(respuesta.value == 'NA'){

            arrayNa.push(respuesta.id);

        }

    })

    // console.log(arrayNa);
    // console.log(respuestas.length - arrayNa.length);

    let porcentajeProceso = 100;
    let cantidadRespuestas = respuestas.length - arrayNa.length;
    
    let porcentaje = porcentajeProceso / cantidadRespuestas;

    // console.log(porcentaje.toFixed(2));

    await actualizarPorcentajePregunta(idEncuSegmento, porcentaje.toFixed(2));

}


const generarCampoRespuestaPregunta = async (pregunta) => {

    if(!pregunta){
        console.error("Pregunta Vacio"); 
        return;
    }


    if(pregunta.respu_encu){

        let campoRespuesta = ``;

        if(pregunta.tipo_pregunta == 'select'){

            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-respuesta" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" onchange="validarPorcentajeSegmento(${pregunta.id_encu_segmento})" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                if(respuesta === pregunta.respu_encu){
                    campoRespuesta += `<option value="${respuesta}" selected>${respuesta}</option>`;
                }else{
                    campoRespuesta += `<option value="${respuesta}">${respuesta}</option>`;
                }
                

            }
            
            campoRespuesta += `</select>`;

        }else if(pregunta.tipo_pregunta == 'select-basico'){

            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-respuesta" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                if(respuesta === pregunta.respu_encu){
                    campoRespuesta += `<option value="${respuesta}" selected>${respuesta}</option>`;
                }else{
                    campoRespuesta += `<option value="${respuesta}">${respuesta}</option>`;
                }

            }
            
            campoRespuesta += `</select>`;

        }else if(pregunta.tipo_pregunta == 'select-instrumento'){
            
            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-respuesta" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" onchange="validarFechaInstrumento(${pregunta.id_encu_segmento},${pregunta.id_encu_pregunta})" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                if(respuesta === pregunta.respu_encu){
                    campoRespuesta += `<option value="${respuesta}" selected>${respuesta}</option>`;
                }else{
                    campoRespuesta += `<option value="${respuesta}">${respuesta}</option>`;
                }

            }
            
            campoRespuesta += `</select>`;
            
        }else if(pregunta.tipo_pregunta == 'select-instrumento-option'){
        
            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-respuesta" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                if(respuesta === pregunta.respu_encu){
                    campoRespuesta += `<option value="${respuesta}" selected>${respuesta}</option>`;
                }else{
                    campoRespuesta += `<option value="${respuesta}">${respuesta}</option>`;
                }

            }
            
            campoRespuesta += `</select>`;
        
        }else if(pregunta.tipo_pregunta == 'select-patologia'){
        
            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-field-multiple select-patologia" name="pregunta${pregunta.id_encu_pregunta}" idPregunta="${pregunta.id_encu_pregunta}" multiple style="width: 100%;" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                let selected = pregunta.respu_encu.includes(respuesta) ? 'selected' : '';
                campoRespuesta += `<option value="${respuesta}" ${selected}>${respuesta}</option>`;

            }
            
            campoRespuesta += `</select>`;
        
        }else if(pregunta.tipo_pregunta == 'select-multiple'){

            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-field-multiple" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" multiple style="width: 100%;" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                campoRespuesta += `<option value="${respuesta}">${respuesta}</option>`;

            }
            
            campoRespuesta += `</select>`;
            
        }else if(pregunta.tipo_pregunta == 'text'){

            campoRespuesta += `<input type="text" class="form-control" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" value="${pregunta.respu_encu}" required>`;

        }else if(pregunta.tipo_pregunta == 'number'){

            campoRespuesta += `<input type="number" class="form-control califacion-encuesta readonly" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" value="${pregunta.respu_encu}" readonly>`;

        }else if(pregunta.tipo_pregunta == 'date-instrumento'){

            if(pregunta.respu_encu === 'NA'){
                campoRespuesta += `<input type="text" class="form-control date-instrumento" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" value="${pregunta.respu_encu}" required>`;
            }else{
                campoRespuesta += `<input type="month" class="form-control date-instrumento" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" value="${pregunta.respu_encu}" required>`;
            }
            
        
        }else if(pregunta.tipo_pregunta == 'date'){
            
            campoRespuesta += `<input type="date" class="form-control" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" required> value="${pregunta.respu_encu}"`;
        
        }else{

            campoRespuesta += `<textarea class="form-control" row="3" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" required>${pregunta.respu_encu}</textarea>`;

        }

        campoRespuesta += `<input type="hidden" idPregunta="${pregunta.id_encu_pregunta}" name="idPreguntaEncuesta${pregunta.id_encu_pregunta}" id="idPreguntaEncuesta${pregunta.id_encu_pregunta}" value="${pregunta.id_encu_pregunta}">`;

        return campoRespuesta;

    }else{

        let campoRespuesta = ``;

        if(pregunta.tipo_pregunta == 'select'){

            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-respuesta" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" onchange="validarPorcentajeSegmento(${pregunta.id_encu_segmento})" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                campoRespuesta += `<option value="${respuesta}">${respuesta}</option>`;

            }
            
            campoRespuesta += `</select>`;

        }else if(pregunta.tipo_pregunta == 'select-basico'){

            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-respuesta" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                campoRespuesta += `<option value="${respuesta}">${respuesta}</option>`;

            }
            
            campoRespuesta += `</select>`;

        }else if(pregunta.tipo_pregunta == 'select-instrumento'){
            
            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-respuesta" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" onchange="validarFechaInstrumento(${pregunta.id_encu_segmento},${pregunta.id_encu_pregunta})" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                campoRespuesta += `<option value="${respuesta}">${respuesta}</option>`;

            }
            
            campoRespuesta += `</select>`;
            
        }else if(pregunta.tipo_pregunta == 'select-instrumento-option'){
        
            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-respuesta" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                campoRespuesta += `<option value="${respuesta}">${respuesta}</option>`;

            }
            
            campoRespuesta += `</select>`;
        
        }else if(pregunta.tipo_pregunta == 'select-patologia'){
        
            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-field-multiple select-patologia" name="pregunta${pregunta.id_encu_pregunta}" idPregunta="${pregunta.id_encu_pregunta}" multiple style="width: 100%;" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                campoRespuesta += `<option value="${respuesta}">${respuesta}</option>`;

            }
            
            campoRespuesta += `</select>`;
        
        }else if(pregunta.tipo_pregunta == 'select-multiple'){

            let arrayRespuesta = pregunta.respuesta.split('-');

            campoRespuesta += `<select class="form-control select-field-multiple" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" multiple style="width: 100%;" id="pregunta${pregunta.id_encu_pregunta}" required>`;

            for(const respuesta of arrayRespuesta){

                campoRespuesta += `<option value="${respuesta}">${respuesta}</option>`;

            }
            
            campoRespuesta += `</select>`;
            
        }else if(pregunta.tipo_pregunta == 'text'){

            campoRespuesta += `<input type="text" class="form-control" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" required>`;

        }else if(pregunta.tipo_pregunta == 'number'){

            campoRespuesta += `<input type="number" class="form-control califacion-encuesta readonly" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" readonly>`;

        }else if(pregunta.tipo_pregunta == 'date-instrumento'){
            
            campoRespuesta += `<input type="month" class="form-control date-instrumento" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" required>`;
        
        }else if(pregunta.tipo_pregunta == 'date'){
            
            campoRespuesta += `<input type="date" class="form-control" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" required>`;
        
        }else{

            campoRespuesta += `<textarea class="form-control" row="3" idPregunta="${pregunta.id_encu_pregunta}" name="pregunta${pregunta.id_encu_pregunta}" id="pregunta${pregunta.id_encu_pregunta}" required></textarea>`;

        }

        campoRespuesta += `<input type="hidden" idPregunta="${pregunta.id_encu_pregunta}" name="idPreguntaEncuesta${pregunta.id_encu_pregunta}" id="idPreguntaEncuesta${pregunta.id_encu_pregunta}" value="${pregunta.id_encu_pregunta}">`;

        return campoRespuesta;

    }


}

const reloadSelectMultiple = async (arraySelectMultiple) => {

    arraySelectMultiple.forEach(select => {
        $(select).select2();
    })

}


const validarFechaInstrumento = async (idSegmento, idPregunta) => {

    let respCondicional = document.querySelector(`#pregunta${idPregunta}`).value;

    let preguntas = await obtenerPreguntasSegmentosEncuestaRespuesta(idSegmento);

    for(let pregunta of preguntas){

        const { tipo_pregunta, id_encu_pregunta } = pregunta;

        if(respCondicional == 'NA' || respCondicional == 'NO REGISTRA ATENCIONES' || respCondicional == 'DISENTIMIENTO'){

            if(tipo_pregunta == 'date-instrumento'){

                const inputDateInstrumento = document.querySelector(`#pregunta${id_encu_pregunta}`);
                inputDateInstrumento.type = 'text';
                inputDateInstrumento.value = 'NA';
                inputDateInstrumento.readOnly = true;
                inputDateInstrumento.classList.add('readonly');

            }else if(tipo_pregunta == 'select-instrumento-option'){

                const selectDateInstrumento = document.querySelector(`#pregunta${id_encu_pregunta}`);
                selectDateInstrumento.value = 'NA';
                selectDateInstrumento.readOnly = true;
                selectDateInstrumento.classList.add('readonly');

            }

        }else{

            if(tipo_pregunta == 'date-instrumento'){

                const inputDateInstrumento = document.querySelector(`#pregunta${id_encu_pregunta}`);
                inputDateInstrumento.type = 'month';
                inputDateInstrumento.readOnly = false;
                inputDateInstrumento.classList.remove('readonly');
                inputDateInstrumento.value = '';

            }else if(tipo_pregunta == 'select-instrumento-option'){

                const selectDateInstrumento = document.querySelector(`#pregunta${id_encu_pregunta}`);
                selectDateInstrumento.value = '';
                selectDateInstrumento.readOnly = false;
                selectDateInstrumento.classList.remove('readonly');

            }

        }

    }


}


const generarPreguntasSegmentos = async (idSegmento, porcentajeGeneral) => {

    let preguntas = await obtenerPreguntasSegmentosEncuestaRespuesta(idSegmento);

    if (!preguntas) {
        console.error("Preguntas Segmentos Vacio");
        return;
    }

    let cantidadPreguntasPorcentaje = 0;

    for (const pregunta of preguntas) {
        if (pregunta.respu_encu !== 'NA') {
            cantidadPreguntasPorcentaje++;
        }
    }

    let arraySelectMultiple = [];

    let porcentajeSegmento = 100;
    let porcentajePregunta = porcentajeSegmento / cantidadPreguntasPorcentaje;

    if (porcentajeGeneral == 0) {
        porcentajePregunta = 0;
    }

    for (const pregunta of preguntas) {
        if (pregunta.tipo_pregunta == 'select-patologia') {
            let idTxtPregunta = '#pregunta' + pregunta.id_encu_pregunta;
            arraySelectMultiple.push(idTxtPregunta);
        }

        let porcentajeActualPregunta = porcentajePregunta;

        if (pregunta.tipo_pregunta == 'number' || pregunta.tipo_pregunta == 'textarea' || pregunta.tipo_pregunta == 'select-patologia' || pregunta.respu_encu == 'NA') {
            porcentajeActualPregunta = 0;
        }

        const tableBody = document.querySelector(`.tableBody${pregunta.id_encu_segmento}`);
        let campoRespuesta = await generarCampoRespuestaPregunta(pregunta);

        tableBody.innerHTML += `
            <tr>
                <td>${pregunta.titulo_descripcion}</td>
                <td>${pregunta.descripcion}</td>
                <td>${campoRespuesta}</td>
                <td class="porcentaje-pregunta-${pregunta.id_encu_pregunta}">${porcentajeActualPregunta.toFixed(2)}%</td>            
            </tr>
        `;
    }

    await reloadSelectMultiple(arraySelectMultiple);
}



const generarLiGestionEncuesta = async (idEncuesta) => {

    //let arrayProcesosIniciales = await obtenerProcesosInicialesEncuesta(tipoEncuesta);

    let arrayProcesosGestion = await obtenerProcesosGestionEncuesta(idEncuesta);

    // console.log(arrayProcesosIniciales);

    if(!arrayProcesosGestion) {
        console.error("arrayProcesosIniciales no definido - Li"); 
        return;
    }

    for(const procesoEncuesta of arrayProcesosGestion) {

        const { id_encu_proceso, proceso, calificacion } = procesoEncuesta;

        let newLi = document.createElement('li');
        newLi.className = 'nav-item';
        newLi.setAttribute('role', 'presentation');

        if(!calificacion){

            newLi.innerHTML = `<a class="nav-link" style="font-size: 12px !important;" onclick="mostrarTab('tab-proceso-${id_encu_proceso}')" idProceso="${id_encu_proceso}" id="proceso-${id_encu_proceso}-tab" data-bs-toggle="tab" href="#tab-proceso-${id_encu_proceso}" role="tab" aria-controls="tab-proceso-${id_encu_proceso}">
                <i class="fas fa-th-list"></i> ${proceso}
            </a>`;

        }else{

            newLi.innerHTML = `<a class="nav-link text-success" style="font-size: 12px !important;" onclick="mostrarTab('tab-proceso-${id_encu_proceso}')" idProceso="${id_encu_proceso}" id="proceso-${id_encu_proceso}-tab" data-bs-toggle="tab" href="#tab-proceso-${id_encu_proceso}" role="tab" aria-controls="tab-proceso-${id_encu_proceso}">
                <i class="fas fa-th-list"></i> ${proceso}
            </a>`;
        }

        tabGestionEncuesta.appendChild(newLi);
    }

}

const mostrarTab = (idTab) => {

    // Ocultar todos los tabs
    var tabs = document.querySelectorAll('.tab-pane');
    tabs.forEach(function(tab) {
        tab.classList.remove('show', 'active');
    });

    // Mostrar el tab correspondiente al enlace clicado
    var tabToShow = document.getElementById(idTab);
    if(!tabToShow){

        Swal.fire({
            title: 'Alerta!',
            text: '¡Se esta generando la Encuesta del Profesional!',
            icon: 'info',
            confirmButtonText: 'Cerrar',
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonColor: "#d33"
        })

    }
    tabToShow.classList.add('show', 'active');
}

const generarTabContent = async (idEncuesta) => {

    // let arrayProcesosGestion = await obtenerProcesosInicialesEncuesta(tipoEncuesta);

    let arrayProcesosGestion = await obtenerProcesosGestionEncuesta(idEncuesta);

    // console.log(arrayProcesosGestion);

    if(!arrayProcesosGestion) {
        console.error("arrayProcesosIniciales no definido - DIV"); 
        return;
    }

    for (const procesoEncuesta of arrayProcesosGestion) {

        //FORM INDIVIDUAL

        const { id_encu_proceso, encuesta, proceso } = procesoEncuesta;

        let newTab = document.createElement('div');
        newTab.className = 'tab-pane show';
        newTab.id = `tab-proceso-${id_encu_proceso}`;
        newTab.setAttribute('role', 'tabpanel');
        newTab.setAttribute('aria-labelledby', `proceso-${id_encu_proceso}-tab`);

        tabContentGestionEncuesta.appendChild(newTab);

        const bodyTabContent = tabContentGestionEncuesta.querySelector(`#tab-proceso-${id_encu_proceso}`);

        let formElement = document.createElement('form');
        formElement.id = `form-proceso-${id_encu_proceso}`;
        formElement.classList = `form-proceso-${id_encu_proceso}`;
        formElement.name = `form-proceso-${id_encu_proceso}`;
        formElement.role = 'form'; 
        formElement.method = 'post'; 
        formElement.enctype = 'multipart/form-data';
        formElement.onsubmit = function(event) {
            event.preventDefault();
            return false;
        };

        bodyTabContent.appendChild(formElement);

        await generarTablaSegmentos(formElement, id_encu_proceso, proceso);

    }

}

const mostrarInformacionAuditoriaEncuesta = async () => {

    if(!idEncuesta){
        console.log('No existe idEncuesta');
    }

    const datos = new FormData();
    datos.append('proceso', 'obtenerInfoAuditoriaEncuesta');
    datos.append('idEncuesta', idEncuesta)

    const infoAuditoriaEncuesta = await $.ajax({
        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!infoAuditoriaEncuesta){

        console.error("No existe Info Auditoria"); 
        return;
    }

    const { nombre_paciente, edad, sexo, modalidad_consulta_tipo_atencion } = infoAuditoriaEncuesta;

    // console.log(infoAuditoriaEncuesta);

    $("#nombrePacienteEncuesta").val(nombre_paciente);
    $("#edadPacienteEncuesta").val(edad);
    $("#sexoPacienteEncuesta").val(sexo);
    $("#modalidadConsultaPacienteEncuesta").val(modalidad_consulta_tipo_atencion);


}

const editarInformacionEncuesta = async () => {

    let formulario = document.getElementById("formEditarInfoEncuesta");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let nombrePaciente = document.getElementById("nombrePacienteEncuesta").value;
            let edadPaciente = document.getElementById("edadPacienteEncuesta").value;
            let sexoPaciente = document.getElementById("sexoPacienteEncuesta").value;
            let modalidadConsultaPaciente = document.getElementById("modalidadConsultaPacienteEncuesta").value;

            Swal.fire({
                title: "¿Desea guardar la informacion de Auditoria?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Guardar!"
            }).then((result) => {
        
                if (result.isConfirmed) {

                    $.ajax({

                        url: 'ajax/encuestas/encuestas-profesional.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'guardarInfoAuditoriaEncuesta',
                            'idEncuesta': idEncuesta,
                            'nombrePaciente': nombrePaciente,
                            'edadPaciente': edadPaciente,
                            'sexoPaciente': sexoPaciente,
                            'modalidadConsultaPaciente': modalidadConsultaPaciente,
                            'usuarioEdit': userSession
                        },
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Informacion Auditoria se actualizo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=encuestas/gestionarencuestapromodificar&idEncuesta='+btoa(idEncuesta)+'&especialidad='+btoa(especialidad);
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    text: '¡La Informacion Auditoria no se actualizo correctamente!',
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


        }else{

            toastr.warning("El Formulario de Vacunacion debe ser diligenciado completamente.", "Error!");

        }
    
    }

}


$(document).ready(async function() {

    if (idEncuesta && especialidad) {

        // console.log(procesoEncuesta);
        // await obtenerSegmentosEncuesta(procesoEncuesta);
        // await generarBotonSaveSegmento(procesoEncuesta, tipoEncuesta);
        await mostrarInfoEncuesta(idEncuesta);
        await generarLiGestionEncuesta(idEncuesta);
        await generarTabContent(idEncuesta);

        // $.ajax({

        //     url: 'ajax/encuestas/encuestas.ajax.php',
        //     type: 'POST',
        //     data: {
        //         'proceso': 'selectProcesos',
        //         'idEncuesta':idEncuesta,
        //         'tipoEncuesta':tipoEncuesta
        //     },
        //     success:function(respuesta){
            
        //         // console.log(respuesta);
        //         $("#procesoProfesional").html(respuesta);
        
        //     }
        
        // })


    }

});

/*==============================
VARIABLES DE RUTA
==============================*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let rutaReporte = atob(getParameterByName('rutaReporte'));

let fontSizeTitle = 13;

$.ajax({

    type: "POST",
    url: "ajax/encuestas/reportes-profesional.ajax.php",
    data: {
        'proceso': 'listaBasesProfesionales',
    },
    success:function(respuesta){

        $("#basesEncuestasProfesionales").html(respuesta);

    }

})


$.ajax({

    type: "POST",
    url: "ajax/encuestas/reportes-profesional.ajax.php",
    data: {
        'proceso': 'listaOtrasEspecialistas',
    },
    success:function(respuesta){

        $("#listaOtrasEspecialistas").html(respuesta);

    }

})


$.ajax({

    type: "POST",
    url: "ajax/encuestas/reportes-profesional.ajax.php",
    data: {
        'proceso': 'listaEspecialistasProfesional',
        'programa': 'VIH'
    },
    success:function(respuesta){

        $("#listaEspecialistasVIH").html(respuesta);

    }

})

onChangeEspecialidad = (event) => {

    let especialidad = event.value;

    if(!especialidad){
        toastr.warning("Debe seleccionar una Especialidad.", "¡Atencion!");
    }

    $.ajax({
    
        type: "POST",
        url: "ajax/encuestas/reportes-profesional.ajax.php",
        data: {
            'proceso': 'listaBasesEncuestasEspecialidad',
            'especialidad': especialidad
        },
        success:function(respuesta){
    
            $("#basesEncuestas").html(respuesta);
    
        }
    
    })

}

onChangeOtrasEspecialidad = (event) => {

    let idProceso = event.value;

    if(!idProceso){
        toastr.warning("Debe seleccionar una Especialidad.", "¡Atencion!");
    }

    $.ajax({
    
        type: "POST",
        url: "ajax/encuestas/reportes-profesional.ajax.php",
        data: {
            'proceso': 'listaBasesEncuestasEspecialidadIdProceso',
            'idProceso': idProceso
        },
        success:function(respuesta){
    
            $("#basesEncuestasEspecialistas").html(respuesta);
    
        }
    
    })

}

onChangeBaseEncuesta = (event) => {

    let idBaseEncu = event.value;

    if(!idBaseEncu){
        toastr.warning("Debe seleccionar una Base Encuesta.", "¡Atencion!");
    }

    $.ajax({
    
        type: "POST",
        url: "ajax/encuestas/reportes-profesional.ajax.php",
        data: {
            'proceso': 'listaProfesionalesIdBaseEncuesta',
            'idBaseEncuesta': idBaseEncu
        },
        success:function(respuesta){
    
            $("#profesionalesEncuesta").html(respuesta);
    
        }
    
    })

}

const destroyTable = (idTable) => {

    if ($.fn.DataTable.isDataTable(`#${idTable}`)) {
        $(`#${idTable}`).DataTable().clear().destroy();
    }
    
}

const reiniciarTable = async (idTable) => {

    if(!idTable) throw new Error('El idTable no existe'); 

    if ($.fn.DataTable.isDataTable(`#${idTable}`)) {
        $(`#${idTable}`).DataTable().destroy();
    }

    $(`#${idTable}`).DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'Descargar Excel',
                className: 'btn btn-phoenix-success',
            },
            // {
            //     extend: 'copy',
            //     text: 'Copiar Tabla',
            //     className: 'btn btn-phoenix-info',
            // }
        ],
        order: [],
        ordering: false
    });

}

const obtenerColorLabel = (cantidad) => {

    let color;

    if (cantidad >= 90 && cantidad <= 100) {
        color = '#25b003';
    } else if (cantidad >= 71 && cantidad <= 89) {
        color = '#ffda22';
    } else {
        color = '#ed2000';
    }

    return color;

}

const obtenerColorLabelCantidad = (respuesta) => {

    
    let color;
    
    if(respuesta === '1'){
        
        color = '#25b003';
        
    }else if(respuesta === '0'){
        
        color = '#ed2000';
        
    }else if(respuesta === 'NA'){
        
        color = '#2caffe';
        
    }else{
        
        color = '#3874ff';
        
    }
    
    return color;

}

const generarReportConsolidadoEspecialista = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoEspecialista");

    let formulario = document.getElementById("formReportConsolidadoEspecialista");
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

            cardResultado.style.display = 'block';

            let especialidad = document.getElementById("listaEspecialistasVIH").value;
            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let datosReport = [

                { tipo: 'DILIGENCIAMIENTO', table: 'tablaDiligenciamiento', container: 'containerDiligenciamiento', title: '% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA ESPECIALISTA MEDICO EXPERTO DE VIH', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'REGISTRO-ANTECEDENTES', table: 'tablaRegistroAntecedentes', container: 'containerRegistroAntecedentes', title:'% DE CUMPLIMIENTO DE REGISTRO DE ANTECEDENTES', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA', table: 'tablaEvaluacionClinica', container: 'containerEvaluacionClinica', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'SEGUIMIENTO-VACUNAS', table: 'tablaSeguimientoVacunas', container: 'containerSeguimientoVacunas', title:'% DE CUMPLIMIENTO DE SEGUIMIENTO A VACUNAS', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-1', table: 'tablaParaclinicos1', container: 'containerParaclinicos1', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-2', table: 'tablaParaclinicos2', container: 'containerParaclinicos2', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-3', table: 'tablaParaclinicos3', container: 'containerParaclinicos3', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                // { tipo: 'PARACLINICOS-GENERAL', table: 'tablaParaclinicosGeneral', container: 'containerParaclinicosGeneral', title:'PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS GENERAL', tableType:'PARACLINICOS-GENERAL', dataResult:'porcentaje'},
                { tipo: 'CITOLOGIA-ANAL', table: 'tablaCitologiaAnal', container: 'containerCitologiaAnal', title:'CUMPLIMIENTO DE CITOLOGIA ANAL', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'CITOLOGIA-VAGINAL', table: 'tablaCitologiaVaginal', container: 'containerCitologiaVaginal', title:'CUMPLIMIENTO DE CITOLOGIA VAGINAL', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'ANTIGENO-PROSTATICO', table: 'tablaAntigenoProstatico', container: 'containerAntigenoProstatico', title:'CUMPLIMIENTO DE ANTIGENO PROSTATICO', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'MAMOGRAFIA', table: 'tablaMamografia', container: 'containerMamografia', title:'CUMPLIMIENTO DE MAMOGRAFIA', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'RECOMENDACIONES-COHERENCIA', table: 'tablaRecomendacionCoherencia', container: 'containerRecomendacionCoherencia', title:'% DE CUMPLIMIENTO RECOMENDACIONES Y COHERENCIA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'ATRIBUTOS-CALIDAD', table: 'tablaAtributosCalidad', container: 'containerAtributosCalidad', title:'% DE CUMPLIMIENTO ATRIBUTOS DE CALIDAD', tableType:'NORMAL', dataResult:'porcentaje'}

            ]

            for (const info of datosReport) {
                
                await generarTablasConsolidadoVIH(idBaseEncuesta, 'VIH', especialidad, info);
                await generarGraficaConsolidadoVIH(idBaseEncuesta, 'VIH', especialidad, info);

            }



        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarTablasConsolidadoVIH = async (idBaseEncuesta, programa, especialidad, info) => {

    let datos = new FormData();
    datos.append('proceso', 'infoReporteEspecidalidadProfesional'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('programa', programa);
    datos.append('especialidad', especialidad);
    datos.append('tipo', info.tipo);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });


    // console.log({response});

    // console.log({info});

    if(info.dataResult == 'porcentaje'){

        if(info.tableType == 'NORMAL'){

            let cadenaBody = ``;
            const tbodyConsolidado = document.querySelector(`#${info.table} .tbodyTable`);

            destroyTable(`${info.table}`);

            for(const res of response) {
                
                cadenaBody += `
                <tr>
                    <td>${res.item}</td>
                    <td>${res.resultado}%</td>
                </tr>`;

            }

            tbodyConsolidado.innerHTML = cadenaBody;

            await reiniciarTable(info.table);


        }else if(info.tableType == 'PARACLINICOS'){


            let cadenaBody = ``;
            const tbodyConsolidado = document.querySelector(`#${info.table} .tbodyTable`);

            destroyTable(`${info.table}`);

            for(const res of response){
                
                cadenaBody += `
                <tr>
                    <td>${res.titulo_descripcion}</td>    
                    <td>${res.resultado_ordenado}%</td>    
                    <td>${res.resultado_analizado}%</td>    
                </tr>`;

            }

            tbodyConsolidado.innerHTML = cadenaBody;

            await reiniciarTable(info.table);


        }else if(info.tableType == 'PARACLINICOS-GENERAL'){

            let cadenaBody = ``;
            const tbodyConsolidado = document.querySelector(`#${info.table} .tbodyTable`);

            destroyTable(`${info.table}`);

            cadenaBody += `
            <tr>
                <td>${response.resultado_ordenado}%</td>    
                <td>${response.resultado_analizado}%</td>    
            </tr>`;

            tbodyConsolidado.innerHTML = cadenaBody;

            await reiniciarTable(info.table);

        }


    }else if(info.dataResult == 'cantidad'){

        if(info.tableType == 'NORMAL'){

            let cadenaBody = ``;
            let totalCantidad = 0;
            const tbodyConsolidado = document.querySelector(`#${info.table} .tbodyTable`);

            destroyTable(`${info.table}`);

            for (const res of response) {
                totalCantidad += parseInt(res.resultado);
            }

            for(const res of response) {
                
                cadenaBody += `
                <tr>
                    <td>${res.item}</td>
                    <td>${res.resultado}</td>
                </tr>`;

            }

            tbodyConsolidado.innerHTML = cadenaBody;

            const tfootTable = document.querySelector(`#${info.table} .tfootTable`);

            let cadenaFinal = `
                <tr>
                    <td><b>TOTAL</b></td>
                    <td><b>${totalCantidad}</b></td>
                </tr>
            `;

            tfootTable.innerHTML = cadenaFinal;

            await reiniciarTable(info.table);

        }else if(info.tableType == 'PARACLINICOS'){

            let cadenaBody = ``;
            const tbodyConsolidado = document.querySelector(`#${info.table} .tbodyTable`);
        
            destroyTable(`${info.table}`);

            for(const res of response){
                
                cadenaBody += `
                <tr>
                    <td>${res.titulo_descripcion}</td>    
                    <td>${res.resultado_ordenado}</td>    
                    <td>${res.resultado_analizado}</td>    
                </tr>`;

            }

            tbodyConsolidado.innerHTML = cadenaBody;

            await reiniciarTable(info.table);

        }


    }

}

const generarGraficaConsolidadoVIH = async (idBaseEncuesta, programa, especialidad, info) => {

    let datos = new FormData();
    datos.append('proceso', 'infoReporteEspecidalidadProfesional'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('programa', programa);
    datos.append('especialidad', especialidad);
    datos.append('tipo', info.tipo);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(info.dataResult == 'porcentaje'){

        if(info.tableType == 'NORMAL'){

            let categories = response.map(data => data.item);
            categories.push('PROMEDIO');

            let dataResult = response.map(data => parseInt(data.resultado));

            let promedio = 0;

            dataResult.forEach(element => {
                promedio += Number(element);
            })
            dataResult.push(Number((promedio/dataResult.length).toFixed(0)));



            Highcharts.chart(`${info.container}`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `${info.title}`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: categories,
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: '% CUMPLIMIENTO'
                    },
                    plotLines: [{
                        color: 'blue',
                        width: 2,
                        value: 90,
                        animation: {
                            duration: 1000,
                            defer: 4000
                        },
                        label: {
                            text: '90%',
                            align: 'right',
                        }
                    }]
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}%'
                        }
                    },
                },
                series: [{
                    name: 'ITEM',
                    data: dataResult.map(item => ({
                      y: item,
                      color: obtenerColorLabel(item)
                    }))
                }]
            });



        }else if(info.tableType == 'PARACLINICOS'){

            let categories = response.map(data => data.titulo_descripcion);
            let dataResultOrdenado = response.map(data => parseFloat(data.resultado_ordenado));
            let dataResultAnalizado = response.map(data => parseFloat(data.resultado_analizado));

            Highcharts.chart(`${info.container}`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `${info.title}`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: categories,
                    crosshair: true,
                    accessibility: {
                        description: 'Countries'
                    }
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: '% CUMPLIMIENTO'
                    },
                    plotLines: [{
                        color: 'blue',
                        width: 2,
                        value: 90,
                        animation: {
                            duration: 1000,
                            defer: 4000
                        },
                        label: {
                            text: '90%',
                            align: 'right',
                        }
                    }]
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}%'
                        }
                    },
                },
                series: [
                    {
                        name: '% CUMPLIMIENTO PARACLINICOS ORDENADOS',
                        data: dataResultOrdenado.map(item => ({
                            y: item,
                            color: obtenerColorLabel(item)
                        }))
                        // data: dataResultOrdenado
                    },
                    {
                        name: '% CUMPLIMIENTO PARACLINICOS ANALIZADOS',
                        data: dataResultAnalizado.map(item => ({
                            y: item,
                            color: obtenerColorLabel(item)
                        }))
                        // data: dataResultAnalizado
                    }
                ]
            });
            

        }else if(info.tableType == 'PARACLINICOS-GENERAL'){

            Highcharts.chart(`${info.container}`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `${info.title}`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: ['ITEM'],
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: '% CUMPLIMIENTO'
                    }
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}%'
                        }
                    },
                },
                series: [
                    {
                        name: 'PROMEDIO % CUMPLIMIENTO PARACLINICOS ORDENADOS',
                        data: [
                            {
                                y: Number(response.resultado_ordenado),
                                color: obtenerColorLabel(Number(response.resultado_ordenado))
                            }
                        ]
                    },
                    {
                        name: 'PROMEDIO % CUMPLIMIENTO PARACLINICOS ANALIZADOS',
                        data: [
                            {
                                y: Number(response.resultado_analizado),
                                color: obtenerColorLabel(Number(response.resultado_analizado))
                            }
                        ]
                        // data: [Number(response.resultado_analizado)]
                    }
                ]
            });

        }


    }else if(info.dataResult == 'cantidad'){

        if(info.tableType == 'NORMAL'){

            let categories = response.map(data => data.item);
            let dataResult = response.map(data => parseInt(data.resultado));

            Highcharts.chart(`${info.container}`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `${info.title}`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: categories,
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'CANTIDAD'
                    }
                },
                // plotOptions: {
                //     column: {
                //         pointPadding: 0.2,
                //         borderWidth: 0
                //     }
                // },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                        }
                    },
                },
                series: [{
                    name: 'ITEM',
                    data: response.map(item => ({
                      y: Number(item.resultado),
                      color: obtenerColorLabelCantidad(item.respuesta)
                    }))
                }]
            });

        }else if(info.tableType == 'PARACLINICOS'){

            

        }


    }

}

const generarReporteOtraEspecialidad = async () => {

    const cardResultado = document.querySelector("#cardResultadoOtraEspecialidad");

    let formulario = document.getElementById("formReportOtraEspecialidad");
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

            cardResultado.style.display = 'block';

            let idBaseEncuesta = document.getElementById("basesEncuestasEspecialistas").value;
            let idInstrumento = document.getElementById("listaOtrasEspecialistas").value;

            let cardBodyResult = document.querySelector('.cardBodyResult');
            cardBodyResult.innerHTML = '';


            let datos = new FormData();
            datos.append('proceso', 'segmentosOtraEspecialidad'),
            datos.append('idBaseEncuesta', idBaseEncuesta);
            datos.append('idProceso', idInstrumento);

            const response = await $.ajax({
                url: 'ajax/encuestas/reportes-profesional.ajax.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            // console.log(response);

            let rowTable = document.createElement('div');
            rowTable.className = 'col-sm-12 col-md-6';
            let cadena = ``;
            let tableSegmento = document.createElement('table');
            tableSegmento.className = 'table table-striped'
            tableSegmento.id = `tableSegmentoGeneral${idInstrumento}`;
            tableSegmentoThead = document.createElement('thead');
            tableSegmentoThead.className = 'theadTable'
            tableSegmentoThead.innerHTML = `
                <tr>
                    <th>ITEM</th>
                    <th>% DE CUMPLIMIENTO HISTORIA CLINICA ${response[0].proceso}</th>
                </tr>
            `;
            tableSegmentoTbody = document.createElement('tbody');
            tableSegmentoTbody.className = 'tbodyTable';

            for (const res of response){

                cadena += `
                    <tr>
                        <td>${res.item}</td>
                        <td>${res.resultado}%</td>
                    </tr>
                `;

                // await generarTablaPreguntasSegmentos(idBaseEncuesta, res, res.item, cardTableResult);
                // await generarGraficasPreguntasSegmentos(idBaseEncuesta, res, res.item, cardGraficaResult);
                
            }

            tableSegmentoTbody.innerHTML += cadena;
            tableSegmento.appendChild(tableSegmentoThead);
            tableSegmento.appendChild(tableSegmentoTbody);
            rowTable.appendChild(tableSegmento);
            cardBodyResult.appendChild(rowTable);

            await reiniciarTable(`tableSegmentoGeneral${idInstrumento}`);

            let rowGrafica = document.createElement('div');
            rowGrafica.className = 'col-sm-12 col-md-6';


            let containerGrafica = document.createElement('div');
            containerGrafica.id = `containerGraficaSegmentoGeneral${idInstrumento}`;
            rowGrafica.appendChild(containerGrafica);
            cardBodyResult.appendChild(rowGrafica);

            let categories = response.map(data => data.item);
            categories.push('PROMEDIO');
            let dataResult = response.map(data => parseInt(data.resultado));

            let promedio = 0;

            dataResult.forEach(element => {
                promedio += Number(element);
            })
            dataResult.push(Number((promedio/dataResult.length).toFixed(0)));

            Highcharts.chart(`containerGraficaSegmentoGeneral${idInstrumento}`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `% DE CUMPLIMIENTO HISTORIA CLINICA DE ${response[0].proceso}`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: categories,
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: '% CUMPLIMIENTO'
                    }
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}%'
                        }
                    },
                },
                series: [{
                    name: 'ITEM',
                    data: dataResult.map(item => ({
                      y: item,
                      color: obtenerColorLabel(item)
                    }))
                }]
            });


            for (const res of response){

                await generarTablaPreguntasSegmentos(idBaseEncuesta, res, res.item, cardBodyResult);
                await generarGraficasPreguntasSegmentos(idBaseEncuesta, res, res.item, cardBodyResult);
                
            }


        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarTablaPreguntasSegmentos = async (idBaseEncuesta, infoSegmento, segmento, body) => {

    let datos = new FormData();
    datos.append('proceso', 'preguntasSegmentoIntrumento'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('idEncuSegmento', infoSegmento.id_encu_segmento);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    let rowTable = document.createElement('div');
    rowTable.className = 'col-sm-12 col-md-6 mb-4';


    let cadena = ``;
    let tableSegmento = document.createElement('table');
    tableSegmento.className = 'table table-striped mb-4'
    tableSegmento.id = `tableSegmento${infoSegmento.id_encu_segmento}`;
    tableSegmentoThead = document.createElement('thead');
    tableSegmentoThead.className = 'theadTable'
    tableSegmentoThead.innerHTML = `
        <tr>
            <th>ITEM</th>
            <th>% DE CUMPLIMIENTO HISTORIA CLINICA ${segmento}</th>
        </tr>
    `;
    tableSegmentoTbody = document.createElement('tbody');
    tableSegmentoTbody.className = 'tbodyTable';

    for (const res of response){

        let resultado = res.resultado == null ? 0 : res.resultado;

        cadena += `
            <tr>
                <td>${res.item}</td>
                <td>${resultado}%</td>
            </tr>
        `;

        // await generarTablaPreguntasSegmentos(idBaseEncuesta, res, res.item, cardTableResult);
        // await generarGraficasPreguntasSegmentos(idBaseEncuesta, res, res.item, cardGraficaResult);
        
    }

    tableSegmentoTbody.innerHTML += cadena;
    tableSegmento.appendChild(tableSegmentoThead);
    tableSegmento.appendChild(tableSegmentoTbody);
    rowTable.appendChild(tableSegmento);
    body.appendChild(rowTable);

    await reiniciarTable(`tableSegmento${infoSegmento.id_encu_segmento}`);

}

const generarGraficasPreguntasSegmentos = async (idBaseEncuesta, infoSegmento, segmento, body) => {

    let datos = new FormData();
    datos.append('proceso', 'preguntasSegmentoIntrumento'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('idEncuSegmento', infoSegmento.id_encu_segmento);

    //CREAR CARD

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    let rowGrafica = document.createElement('div');
    rowGrafica.className = 'col-sm-12 col-md-6 mb-4';

    let containerGrafica = document.createElement('div');
    containerGrafica.id = `containerGraficaSegmento${infoSegmento.id_encu_segmento}`;
    rowGrafica.appendChild(containerGrafica);
    body.appendChild(rowGrafica);

    let categories = response.map(data => data.item);

    categories.push('PROMEDIO');

    let dataResult = response.map(data => parseInt(data.resultado));

    let promedio = 0;

    dataResult.forEach(element => {
        promedio += Number(element);
    })
    dataResult.push(Number((promedio/dataResult.length).toFixed(0)));

    Highcharts.chart(`containerGraficaSegmento${infoSegmento.id_encu_segmento}`, {
        chart: {
            type: 'column'
        },
        title: {
            text: `% DE CUMPLIMIENTO HISTORIA CLINICA DE ${segmento}`,
            align: 'center',
            style: {
                fontSize: `${fontSizeTitle}px` 
            }
        },
        xAxis: {
            categories: categories,
            crosshair: true,
        },
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: '% CUMPLIMIENTO'
            }
        },
        tooltip: {
            valueSuffix: '%'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{y}%'
                }
            },
        },
        series: [{
            name: 'ITEM',
            data: dataResult.map(item => ({
                y: item,
                color: obtenerColorLabel(item)
            }))
        }]
    });

}

const generarReporteConsolidadoResultadoAud = async () => {

    const cardResultado = document.querySelector("#cardResultado");

    let formulario = document.getElementById("formReportConsoResultadoAud");
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

            cardResultado.style.display = 'block';

            let idBaseEncuesta = document.getElementById("basesEncuestasProfesionales").value;


            /*==============================
            TABLA Y GRAFICA DE MEDICOS
            ==============================*/

            let datos = new FormData();
            datos.append('proceso', 'infoResultadoAuditoriaProfesional'),
            datos.append('idBaseEncuesta', idBaseEncuesta);

            const response = await $.ajax({
                url: 'ajax/encuestas/reportes-profesional.ajax.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            // console.log(response);

            let idTableMedico = "tablaConsolidadoResultado";
            let tBodyTableMedico = document.querySelector(`#${idTableMedico} .tbodyTable`);
            let cadenaBodyMedico = ``;

            destroyTable(idTableMedico);

            for (const res of response) {

                cadenaBodyMedico += `
                <tr>
                    <td>${res.profesional_auditado}</td>
                    <td>${res.cantidad}</td>
                    <td>${res.calificacion}%</td>
                </tr>`;
        
            }
        
            tBodyTableMedico.innerHTML = cadenaBodyMedico;

            await reiniciarTable(idTableMedico);


            let categories = response.map(item => item.profesional_auditado);
            categories.push('PROMEDIO');

            let dataResult = response.map(data => parseInt(data.calificacion));
            let promedio = 0;

            dataResult.forEach(element => {
                promedio += Number(element);
            })
            dataResult.push(Number((promedio/dataResult.length).toFixed(0)));

            Highcharts.chart(`containerGraficaConsolidadoResultado`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `RESULTADOS DE AUDITORIA`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: categories,
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: '% CUMPLIMIENTO'
                    },
                    plotLines: [{
                        color: 'blue',
                        width: 2,
                        value: 90,
                        animation: {
                            duration: 1000,
                            defer: 4000
                        },
                        label: {
                            text: '90%',
                            align: 'right',
                        }
                    }]
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}%'
                        }
                    },
                },
                series: [{
                    name: 'PROFESIONALES',
                    data: dataResult.map(item => ({
                        y: item,
                        color: obtenerColorLabel(item)
                    }))
                }]
            });

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }


}


//PROFESIONAL
const generarReportConsolidadoEspecialistaProfesional = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoEspecialista");

    let formulario = document.getElementById("formReportConsolidadoEspecialistaPro");
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

            cardResultado.style.display = 'block';

            let especialidad = document.getElementById("listaEspecialistasVIH").value;
            let idBaseEncuesta = document.getElementById("basesEncuestas").value;
            let profesional = document.getElementById("profesionalesEncuesta").value;

            let datosReport = [

                { tipo: 'DILIGENCIAMIENTO', table: 'tablaDiligenciamiento', container: 'containerDiligenciamiento', title: '% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA ESPECIALISTA MEDICO EXPERTO DE VIH', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'REGISTRO-ANTECEDENTES', table: 'tablaRegistroAntecedentes', container: 'containerRegistroAntecedentes', title:'% DE CUMPLIMIENTO DE REGISTRO DE ANTECEDENTES', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA', table: 'tablaEvaluacionClinica', container: 'containerEvaluacionClinica', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'SEGUIMIENTO-VACUNAS', table: 'tablaSeguimientoVacunas', container: 'containerSeguimientoVacunas', title:'% DE CUMPLIMIENTO DE SEGUIMIENTO A VACUNAS', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-1', table: 'tablaParaclinicos1', container: 'containerParaclinicos1', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-2', table: 'tablaParaclinicos2', container: 'containerParaclinicos2', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-3', table: 'tablaParaclinicos3', container: 'containerParaclinicos3', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                // { tipo: 'PARACLINICOS-GENERAL', table: 'tablaParaclinicosGeneral', container: 'containerParaclinicosGeneral', title:'PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS GENERAL', tableType:'PARACLINICOS-GENERAL', dataResult:'porcentaje'},
                { tipo: 'CITOLOGIA-ANAL', table: 'tablaCitologiaAnal', container: 'containerCitologiaAnal', title:'CUMPLIMIENTO DE CITOLOGIA ANAL', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'CITOLOGIA-VAGINAL', table: 'tablaCitologiaVaginal', container: 'containerCitologiaVaginal', title:'CUMPLIMIENTO DE CITOLOGIA VAGINAL', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'ANTIGENO-PROSTATICO', table: 'tablaAntigenoProstatico', container: 'containerAntigenoProstatico', title:'CUMPLIMIENTO DE ANTIGENO PROSTATICO', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'MAMOGRAFIA', table: 'tablaMamografia', container: 'containerMamografia', title:'CUMPLIMIENTO DE MAMOGRAFIA', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'RECOMENDACIONES-COHERENCIA', table: 'tablaRecomendacionCoherencia', container: 'containerRecomendacionCoherencia', title:'% DE CUMPLIMIENTO RECOMENDACIONES Y COHERENCIA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'ATRIBUTOS-CALIDAD', table: 'tablaAtributosCalidad', container: 'containerAtributosCalidad', title:'% DE CUMPLIMIENTO ATRIBUTOS DE CALIDAD', tableType:'NORMAL', dataResult:'porcentaje'}

            ]

            for (const info of datosReport) {
                
                await generarTablasConsolidadoVIHProfesional(idBaseEncuesta, 'VIH', especialidad, info, profesional);
                await generarGraficaConsolidadoVIHProfesional(idBaseEncuesta, 'VIH', especialidad, info, profesional);

            }



        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarTablasConsolidadoVIHProfesional = async (idBaseEncuesta, programa, especialidad, info, profesional) => {

    let datos = new FormData();
    datos.append('proceso', 'infoReporteEspecidalidadProfesionalPro'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('programa', programa);
    datos.append('especialidad', especialidad);
    datos.append('tipo', info.tipo);
    datos.append('profesional', profesional);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });


    // console.log({response});

    // console.log({info});

    if(info.dataResult == 'porcentaje'){

        if(info.tableType == 'NORMAL'){

            let cadenaBody = ``;
            const tbodyConsolidado = document.querySelector(`#${info.table} .tbodyTable`);

            destroyTable(`${info.table}`);

            for(const res of response) {
                
                cadenaBody += `
                <tr>
                    <td>${res.item}</td>
                    <td>${res.resultado}%</td>
                </tr>`;

            }

            tbodyConsolidado.innerHTML = cadenaBody;

            await reiniciarTable(info.table);


        }else if(info.tableType == 'PARACLINICOS'){


            let cadenaBody = ``;
            const tbodyConsolidado = document.querySelector(`#${info.table} .tbodyTable`);

            destroyTable(`${info.table}`);

            for(const res of response){
                
                cadenaBody += `
                <tr>
                    <td>${res.titulo_descripcion}</td>    
                    <td>${res.resultado_ordenado}%</td>    
                    <td>${res.resultado_analizado}%</td>    
                </tr>`;

            }

            tbodyConsolidado.innerHTML = cadenaBody;

            await reiniciarTable(info.table);


        }else if(info.tableType == 'PARACLINICOS-GENERAL'){

            let cadenaBody = ``;
            const tbodyConsolidado = document.querySelector(`#${info.table} .tbodyTable`);

            destroyTable(`${info.table}`);

            cadenaBody += `
            <tr>
                <td>${response.resultado_ordenado}%</td>    
                <td>${response.resultado_analizado}%</td>    
            </tr>`;

            tbodyConsolidado.innerHTML = cadenaBody;

            await reiniciarTable(info.table);

        }


    }else if(info.dataResult == 'cantidad'){

        if(info.tableType == 'NORMAL'){

            let cadenaBody = ``;
            let totalCantidad = 0;
            const tbodyConsolidado = document.querySelector(`#${info.table} .tbodyTable`);

            destroyTable(`${info.table}`);

            for (const res of response) {
                totalCantidad += parseInt(res.resultado);
            }

            for(const res of response) {
                
                cadenaBody += `
                <tr>
                    <td>${res.item}</td>
                    <td>${res.resultado}</td>
                </tr>`;

            }

            tbodyConsolidado.innerHTML = cadenaBody;

            const tfootTable = document.querySelector(`#${info.table} .tfootTable`);

            let cadenaFinal = `
                <tr>
                    <td><b>TOTAL</b></td>
                    <td><b>${totalCantidad}</b></td>
                </tr>
            `;

            tfootTable.innerHTML = cadenaFinal;

            await reiniciarTable(info.table);

        }else if(info.tableType == 'PARACLINICOS'){

            let cadenaBody = ``;
            const tbodyConsolidado = document.querySelector(`#${info.table} .tbodyTable`);
        
            destroyTable(`${info.table}`);

            for(const res of response){
                
                cadenaBody += `
                <tr>
                    <td>${res.titulo_descripcion}</td>    
                    <td>${res.resultado_ordenado}</td>    
                    <td>${res.resultado_analizado}</td>    
                </tr>`;

            }

            tbodyConsolidado.innerHTML = cadenaBody;

            await reiniciarTable(info.table);

        }


    }

}

const generarGraficaConsolidadoVIHProfesional = async (idBaseEncuesta, programa, especialidad, info, profesional) => {

    let datos = new FormData();
    datos.append('proceso', 'infoReporteEspecidalidadProfesionalPro'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('programa', programa);
    datos.append('especialidad', especialidad);
    datos.append('tipo', info.tipo);
    datos.append('profesional', profesional);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(info.dataResult == 'porcentaje'){

        if(info.tableType == 'NORMAL'){

            let categories = response.map(data => data.item);
            categories.push('PROMEDIO');

            let dataResult = response.map(data => parseInt(data.resultado));

            let promedio = 0;

            dataResult.forEach(element => {
                promedio += Number(element);
            })
            dataResult.push(Number((promedio/dataResult.length).toFixed(0)));



            Highcharts.chart(`${info.container}`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `${info.title}`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: categories,
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: '% CUMPLIMIENTO'
                    },
                    plotLines: [{
                        color: 'blue',
                        width: 2,
                        value: 90,
                        animation: {
                            duration: 1000,
                            defer: 4000
                        },
                        label: {
                            text: '90%',
                            align: 'right',
                        }
                    }]
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}%'
                        }
                    },
                },
                series: [{
                    name: 'ITEM',
                    data: dataResult.map(item => ({
                      y: item,
                      color: obtenerColorLabel(item)
                    }))
                }]
            });



        }else if(info.tableType == 'PARACLINICOS'){

            let categories = response.map(data => data.titulo_descripcion);
            let dataResultOrdenado = response.map(data => parseFloat(data.resultado_ordenado));
            let dataResultAnalizado = response.map(data => parseFloat(data.resultado_analizado));

            Highcharts.chart(`${info.container}`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `${info.title}`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: categories,
                    crosshair: true,
                    accessibility: {
                        description: 'Countries'
                    }
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: '% CUMPLIMIENTO'
                    },
                    plotLines: [{
                        color: 'blue',
                        width: 2,
                        value: 90,
                        animation: {
                            duration: 1000,
                            defer: 4000
                        },
                        label: {
                            text: '90%',
                            align: 'right',
                        }
                    }]
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}%'
                        }
                    },
                },
                series: [
                    {
                        name: '% CUMPLIMIENTO PARACLINICOS ORDENADOS',
                        data: dataResultOrdenado.map(item => ({
                            y: item,
                            color: obtenerColorLabel(item)
                        }))
                        // data: dataResultOrdenado
                    },
                    {
                        name: '% CUMPLIMIENTO PARACLINICOS ANALIZADOS',
                        data: dataResultAnalizado.map(item => ({
                            y: item,
                            color: obtenerColorLabel(item)
                        }))
                        // data: dataResultAnalizado
                    }
                ]
            });
            

        }else if(info.tableType == 'PARACLINICOS-GENERAL'){

            Highcharts.chart(`${info.container}`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `${info.title}`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: ['ITEM'],
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: '% CUMPLIMIENTO'
                    }
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}%'
                        }
                    },
                },
                series: [
                    {
                        name: 'PROMEDIO % CUMPLIMIENTO PARACLINICOS ORDENADOS',
                        data: [
                            {
                                y: Number(response.resultado_ordenado),
                                color: obtenerColorLabel(Number(response.resultado_ordenado))
                            }
                        ]
                    },
                    {
                        name: 'PROMEDIO % CUMPLIMIENTO PARACLINICOS ANALIZADOS',
                        data: [
                            {
                                y: Number(response.resultado_analizado),
                                color: obtenerColorLabel(Number(response.resultado_analizado))
                            }
                        ]
                        // data: [Number(response.resultado_analizado)]
                    }
                ]
            });

        }


    }else if(info.dataResult == 'cantidad'){

        if(info.tableType == 'NORMAL'){

            let categories = response.map(data => data.item);
            let dataResult = response.map(data => parseInt(data.resultado));

            Highcharts.chart(`${info.container}`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `${info.title}`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: categories,
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'CANTIDAD'
                    }
                },
                // plotOptions: {
                //     column: {
                //         pointPadding: 0.2,
                //         borderWidth: 0
                //     }
                // },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                        }
                    },
                },
                series: [{
                    name: 'ITEM',
                    data: response.map(item => ({
                      y: Number(item.resultado),
                      color: obtenerColorLabelCantidad(item.respuesta)
                    }))
                }]
            });

        }else if(info.tableType == 'PARACLINICOS'){

            

        }


    }

}


const generarReporteOtraEspecialidadProfesional = async () => {

    const cardResultado = document.querySelector("#cardResultadoOtraEspecialidad");

    let formulario = document.getElementById("formReportOtraEspecialidad");
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

            cardResultado.style.display = 'block';

            let idBaseEncuesta = document.getElementById("basesEncuestasEspecialistas").value;
            let idInstrumento = document.getElementById("listaOtrasEspecialistas").value;
            let profesional = document.getElementById("profesionalesEncuesta").value;

            let cardBodyResult = document.querySelector('.cardBodyResult');
            cardBodyResult.innerHTML = '';


            let datos = new FormData();
            datos.append('proceso', 'segmentosOtraEspecialidadProfesional'),
            datos.append('idBaseEncuesta', idBaseEncuesta);
            datos.append('idProceso', idInstrumento);
            datos.append('profesional', profesional);

            const response = await $.ajax({
                url: 'ajax/encuestas/reportes-profesional.ajax.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            // console.log(response);

            let rowTable = document.createElement('div');
            rowTable.className = 'col-sm-12 col-md-6';
            let cadena = ``;
            let tableSegmento = document.createElement('table');
            tableSegmento.className = 'table table-striped'
            tableSegmento.id = `tableSegmentoGeneral${idInstrumento}`;
            tableSegmentoThead = document.createElement('thead');
            tableSegmentoThead.className = 'theadTable'
            tableSegmentoThead.innerHTML = `
                <tr>
                    <th>ITEM</th>
                    <th>% DE CUMPLIMIENTO HISTORIA CLINICA ${response[0].proceso}</th>
                </tr>
            `;
            tableSegmentoTbody = document.createElement('tbody');
            tableSegmentoTbody.className = 'tbodyTable';

            for (const res of response){

                cadena += `
                    <tr>
                        <td>${res.item}</td>
                        <td>${res.resultado}%</td>
                    </tr>
                `;

                // await generarTablaPreguntasSegmentos(idBaseEncuesta, res, res.item, cardTableResult);
                // await generarGraficasPreguntasSegmentos(idBaseEncuesta, res, res.item, cardGraficaResult);
                
            }

            tableSegmentoTbody.innerHTML += cadena;
            tableSegmento.appendChild(tableSegmentoThead);
            tableSegmento.appendChild(tableSegmentoTbody);
            rowTable.appendChild(tableSegmento);
            cardBodyResult.appendChild(rowTable);

            await reiniciarTable(`tableSegmentoGeneral${idInstrumento}`);

            let rowGrafica = document.createElement('div');
            rowGrafica.className = 'col-sm-12 col-md-6';


            let containerGrafica = document.createElement('div');
            containerGrafica.id = `containerGraficaSegmentoGeneral${idInstrumento}`;
            rowGrafica.appendChild(containerGrafica);
            cardBodyResult.appendChild(rowGrafica);

            let categories = response.map(data => data.item);
            categories.push('PROMEDIO');
            let dataResult = response.map(data => parseInt(data.resultado));

            let promedio = 0;

            dataResult.forEach(element => {
                promedio += Number(element);
            })
            dataResult.push(Number((promedio/dataResult.length).toFixed(0)));

            Highcharts.chart(`containerGraficaSegmentoGeneral${idInstrumento}`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `% DE CUMPLIMIENTO HISTORIA CLINICA DE ${response[0].proceso}`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: categories,
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: '% CUMPLIMIENTO'
                    }
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}%'
                        }
                    },
                },
                series: [{
                    name: 'ITEM',
                    data: dataResult.map(item => ({
                      y: item,
                      color: obtenerColorLabel(item)
                    }))
                }]
            });


            for (const res of response){

                await generarTablaPreguntasSegmentosProfesional(idBaseEncuesta, res, res.item, cardBodyResult, profesional);
                await generarGraficasPreguntasSegmentosProfesional(idBaseEncuesta, res, res.item, cardBodyResult, profesional);
                
            }


        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarTablaPreguntasSegmentosProfesional = async (idBaseEncuesta, infoSegmento, segmento, body, profesional) => {

    let datos = new FormData();
    datos.append('proceso', 'preguntasSegmentoIntrumentoProfesional'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('idEncuSegmento', infoSegmento.id_encu_segmento);
    datos.append('profesional', profesional);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    let rowTable = document.createElement('div');
    rowTable.className = 'col-sm-12 col-md-6 mb-4';


    let cadena = ``;
    let tableSegmento = document.createElement('table');
    tableSegmento.className = 'table table-striped mb-4'
    tableSegmento.id = `tableSegmento${infoSegmento.id_encu_segmento}`;
    tableSegmentoThead = document.createElement('thead');
    tableSegmentoThead.className = 'theadTable'
    tableSegmentoThead.innerHTML = `
        <tr>
            <th>ITEM</th>
            <th>% DE CUMPLIMIENTO HISTORIA CLINICA ${segmento}</th>
        </tr>
    `;
    tableSegmentoTbody = document.createElement('tbody');
    tableSegmentoTbody.className = 'tbodyTable';

    for (const res of response){

        let resultado = res.resultado == null ? 0 : res.resultado;

        cadena += `
            <tr>
                <td>${res.item}</td>
                <td>${resultado}%</td>
            </tr>
        `;

        // await generarTablaPreguntasSegmentos(idBaseEncuesta, res, res.item, cardTableResult);
        // await generarGraficasPreguntasSegmentos(idBaseEncuesta, res, res.item, cardGraficaResult);
        
    }

    tableSegmentoTbody.innerHTML += cadena;
    tableSegmento.appendChild(tableSegmentoThead);
    tableSegmento.appendChild(tableSegmentoTbody);
    rowTable.appendChild(tableSegmento);
    body.appendChild(rowTable);

    await reiniciarTable(`tableSegmento${infoSegmento.id_encu_segmento}`);

}

const generarGraficasPreguntasSegmentosProfesional = async (idBaseEncuesta, infoSegmento, segmento, body, profesional) => {

    let datos = new FormData();
    datos.append('proceso', 'preguntasSegmentoIntrumentoProfesional'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('idEncuSegmento', infoSegmento.id_encu_segmento);
    datos.append('profesional', profesional);

    //CREAR CARD

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes-profesional.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    let rowGrafica = document.createElement('div');
    rowGrafica.className = 'col-sm-12 col-md-6 mb-4';

    let containerGrafica = document.createElement('div');
    containerGrafica.id = `containerGraficaSegmento${infoSegmento.id_encu_segmento}`;
    rowGrafica.appendChild(containerGrafica);
    body.appendChild(rowGrafica);

    let categories = response.map(data => data.item);

    categories.push('PROMEDIO');

    let dataResult = response.map(data => parseInt(data.resultado));

    let promedio = 0;

    dataResult.forEach(element => {
        promedio += Number(element);
    })
    dataResult.push(Number((promedio/dataResult.length).toFixed(0)));

    Highcharts.chart(`containerGraficaSegmento${infoSegmento.id_encu_segmento}`, {
        chart: {
            type: 'column'
        },
        title: {
            text: `% DE CUMPLIMIENTO HISTORIA CLINICA DE ${segmento}`,
            align: 'center',
            style: {
                fontSize: `${fontSizeTitle}px` 
            }
        },
        xAxis: {
            categories: categories,
            crosshair: true,
        },
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: '% CUMPLIMIENTO'
            }
        },
        tooltip: {
            valueSuffix: '%'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{y}%'
                }
            },
        },
        series: [{
            name: 'ITEM',
            data: dataResult.map(item => ({
                y: item,
                color: obtenerColorLabel(item)
            }))
        }]
    });

}
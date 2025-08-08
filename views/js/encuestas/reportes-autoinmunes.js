let fontSizeTitle = 13;

/*============================
LISTA BASES ENCUESTAS
============================*/
$.ajax({

    type: "POST",
    url: "ajax/encuestas/reportes.ajax.php",
    data: {
        'proceso': 'listaBasesEncuestas',
        'tipoEncuesta': 'AUTOINMUNES'
    },
    success:function(respuesta){

        $("#basesEncuestas").html(respuesta);

    }

})

/*============================
INSTRUMENTOS
============================*/
$.ajax({

    type: "POST",
    url: "ajax/encuestas/reportes.ajax.php",
    data: {
        'proceso': 'listaInstrumentos',
        'tipoEncuesta': 'AUTOINMUNES'
    },
    success:function(respuesta){

        $("#instrumentosEncuesta").html(respuesta);

    }

})

/*============================
INSTRUMENTOS GENERAL
============================*/
$.ajax({

    type: "POST",
    url: "ajax/encuestas/reportes.ajax.php",
    data: {
        'proceso': 'listaInstrumentosGeneral',
        'tipoEncuesta': 'AUTOINMUNES'
    },
    success:function(respuesta){

        $("#listaInstrumentosGeneral").html(respuesta);

    }

})


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
        pageLength: 15
    });

}

const destroyTable = (idTable) => {

    if ($.fn.DataTable.isDataTable(`#${idTable}`)) {
        $(`#${idTable}`).DataTable().clear().destroy();
    }
    
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

const generarReportConsolidadoEpsAutoinmunes = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoEpsAuto");

    let formulario = document.getElementById("formReporteConsilidadoEpsAuto");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let datos = new FormData();
            datos.append('proceso', 'infoReportConsolidadoEps'),
            datos.append('idBaseEncuesta', idBaseEncuesta);

            const resultado = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            // console.log({resultado});

            let idTable = "tablaConsolidadoEpsAuto";

            destroyTable(idTable);

            const tbodyTable = document.querySelector('.tbodyTable');

            let cadenaBody = ``;
            let totalCantidad = 0;
            let totalPorcentaje = 0;

            for (const res of resultado) {
                totalCantidad += parseInt(res.cantidad);
            }

            for (const res of resultado) {
                
                let porcentaje = (res.cantidad / totalCantidad * 100).toFixed(0);
                totalPorcentaje += parseFloat(porcentaje);

                cadenaBody += `
                <tr>
                    <td>${res.eps}</td>
                    <td>${res.cantidad}</td>
                    <td>${porcentaje}%</td>
                </tr>`;

            }

            tbodyTable.innerHTML = cadenaBody;

            const tfootTable = document.querySelector('.tfootTable');

            //FILA FINAL DE RESULTADOS
            let cadenaFinal = `
                <tr>
                    <td><b>TOTAL DE HISTORIAS CLÍNICAS TOMADA PARA LA AUDITORÍA</b></td>
                    <td><b>${totalCantidad}</b></td>
                    <td><b>${totalPorcentaje.toFixed(0)}%</b></td>
                </tr>
            `;

            tfootTable.innerHTML = cadenaFinal;

            //REINICIAR TABLA PARA QUE SE MUESTRE COMO DATATABLE
            await reiniciarTable(idTable);         

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarReportConsolidadoCumpliGrupoInterAutoinmunes = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoCumpliGrupoInter");

    let formulario = document.getElementById("formReportConsolidadoCumpliGrupoInter");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let datos = new FormData();
            datos.append('proceso', 'infoReportConsolidadoGrupoInter'),
            datos.append('idBaseEncuesta', idBaseEncuesta);
            datos.append('procesoEncuesta', 'MEDICO O ESPECIALISTA');

            const resultado = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            let arrayOrganizado = resultado.sort((a, b) => parseInt(b.puntaje) - parseInt(a.puntaje));

            let idTable = "tablaConsolidadoCumpliGrupoInter";
            const tbodyTable = document.querySelector('.tbodyTable');

            destroyTable(idTable);

            let cadenaBody = ``;
            let totalCantidad = 0;

            for (const res of arrayOrganizado) {
                totalCantidad += parseInt(res.cantidad);
            }

            for (const res of arrayOrganizado) {
                
                cadenaBody += `
                <tr>
                    <td>${res.grupo}</td>
                    <td>${res.puntaje}%</td>
                </tr>`;

            }

            tbodyTable.innerHTML = cadenaBody;

            //REINICIAR TABLA PARA QUE SE MUESTRE COMO DATATABLE
            await reiniciarTable(idTable);

            let categories = arrayOrganizado.map(item => item.grupo);
            categories.push('PROMEDIO');
            let dataResult = arrayOrganizado.map(item => parseInt(item.puntaje));
            let promedio = 0;

            dataResult.forEach(element => {
                promedio += Number(element);
            })
            dataResult.push(Number((promedio/dataResult.length).toFixed(0)));

            Highcharts.chart('containerConsolidadoCumpliGrupoInter', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'CONSOLIDADO GENERAL CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA',
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
                        name: 'PROFESIONAL EVALUADO',
                        data: dataResult.map(item => ({
                            y: item,
                            color: obtenerColorLabel(item)
                        }))
                    },
                ]
            });


        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarReportConsolidadoGrupoInterAutoinmunes = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoGeneral");

    let formulario = document.getElementById("formReportConsolidadoGeneral");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let datos = new FormData();
            datos.append('proceso', 'infoReportConsolidadoGrupoInter'),
            datos.append('idBaseEncuesta', idBaseEncuesta);
            datos.append('procesoEncuesta', 'MEDICO O ESPECIALISTA');

            const resultado = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            let arrayOrganizado = resultado.sort((a, b) => parseInt(b.cantidad) - parseInt(a.cantidad));

            let idTable = "tablaConsolidadoGeneral";
            const tbodyTable = document.querySelector('.tbodyTable');

            destroyTable(idTable);

            let cadenaBody = ``;
            let totalCantidad = 0;

            for (const res of arrayOrganizado) {
                totalCantidad += parseInt(res.cantidad);
            }

            for (const res of arrayOrganizado) {
                
                cadenaBody += `
                <tr>
                    <td>${res.grupo}</td>
                    <td>${res.cantidad}</td>
                </tr>`;

            }

            tbodyTable.innerHTML = cadenaBody;

            const tfootTable = document.querySelector('.tfootTable');

            //FILA FINAL DE RESULTADOS
            let cadenaFinal = `
                <tr>
                    <td><b>TOTAL DE HISTORIAS CLÍNICAS AUDITADAS</b></td>
                    <td><b>${totalCantidad}</b></td>
                </tr>
            `;

            tfootTable.innerHTML = cadenaFinal;

            //REINICIAR TABLA PARA QUE SE MUESTRE COMO DATATABLE
            await reiniciarTable(idTable);

            let categories = arrayOrganizado.map(item => item.grupo);
            let dataResult = arrayOrganizado.map(item => parseInt(item.cantidad));

            Highcharts.chart('containerConsolidadoGeneral', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'TOTAL DE HISTORIAS CLÍNICAS AUDITADAS',
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
                        text: 'TOTAL DE HISTORIAS AUDITADAS'
                    }
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                        }
                    },
                },
                series: [
                    {
                        name: 'PROFESIONAL EVALUADO',
                        data: dataResult
                    },
                ]
            });


        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}


const generarReportConsoDatosIdentificacionAutoinmunes = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoDatosIdentificacion");

    let formulario = document.getElementById("formReportConsoDatosIdentificacion");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let datos = new FormData();
            datos.append('proceso', 'infoReportConsolidadoDatosIdentificacion'),
            datos.append('idBaseEncuesta', idBaseEncuesta);
            datos.append('tipoEncuesta', 'AUTOINMUNES');

            const resultado = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            let idTable = "tablaConsolidadoDatosIdentificacion";
            let tBodyTable = document.querySelector('.tbodyTable');
            let cadenaBody = ``;

            destroyTable(idTable);

            for (const res of resultado) {

                cadenaBody += `
                <tr>
                    <td>${res.titulo_descripcion}</td>
                    <td>${res.calificacion}%</td>
                </tr>`;
        
            }
        
            tBodyTable.innerHTML = cadenaBody;

            await reiniciarTable(idTable);
            let categories = resultado.map(item => item.titulo_descripcion);
            categories.push('PROMEDIO');
            let dataResult = resultado.map(item => parseInt(item.calificacion));
            let promedio = 0;

            dataResult.forEach(element => {
                promedio += Number(element);
            })
            dataResult.push(Number((promedio/dataResult.length).toFixed(0)));
            

            Highcharts.chart('containerConsolidadoDatosIdentificacion', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'PORCENTAJE DE CUMPLIMIENTO',
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
                    name: 'ITEM EVALUACION',
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

const generarReporteTratamientoFormulado = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteTratamientoFormulado");

    let formulario = document.getElementById("formReportTratamientoFormulado");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let datos = new FormData();
            datos.append('proceso', 'infoReportTratamientoFormulado'),
            datos.append('idBaseEncuesta', idBaseEncuesta);

            const resultado = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            let idTable = "tablaTratamientoFormulado";
            let tBodyTable = document.querySelector('.tbodyTable');
            let cadenaBody = ``;
            let cantidadTotal = 0;
            let porcentaje = 0;

            destroyTable(idTable)

            for (const res of resultado){

                cantidadTotal += parseInt(res.cantidad);

            }


            for (const res of resultado) {

                porcentaje = (parseInt(res.cantidad) / cantidadTotal * 100).toFixed(0);

                cadenaBody += `
                <tr>
                    <td>${res.respuesta}</td>
                    <td>${porcentaje}%</td>
                    <td>${res.cantidad}</td>
                </tr>`;
        
            }
        
            tBodyTable.innerHTML = cadenaBody;

            const tfootTable = document.querySelector(`#${idTable} .tfootTable`);

            //FILA FINAL DE RESULTADOS
            let cadenaFinal = `
                <tr>
                    <td><b>TOTAL PACIENTES</b></td>
                    <td><b>100%</b></td>
                    <td><b>${cantidadTotal}</b></td>
                </tr>
            `;

            tfootTable.innerHTML = cadenaFinal;

            await reiniciarTable(idTable);

            let dataResult = resultado.map(item => {
                return {
                    name: item.respuesta,
                    y: parseInt((parseInt(item.cantidad) / cantidadTotal * 100).toFixed(0))
                }
            })

            // console.log(dataResult);

            Highcharts.chart('containerTratamientoFormulado', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: '% PACIENTES CON TRATAMIENTO DMARD',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: [{
                            enabled: true,
                            distance: 20
                        }, {
                            enabled: true,
                            distance: -40,
                            format: '{point.percentage:.0f}%',
                        }]
                    }
                },
                series: [
                    {
                        name: 'RESULTADO',
                        colorByPoint: true,
                        data: dataResult
                    }
                ]
            });

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarReporteInstrumento = async () => {

    const cardResultado = document.querySelector("#cardResultadoInstrumento");

    let formulario = document.getElementById("formReportInstrumentos");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;
            let idInstrumento = document.getElementById("instrumentosEncuesta").value;

            let cardBodyResult = document.querySelector('.cardBodyResult');
            cardBodyResult.innerHTML = '';


            let datos = new FormData();
            datos.append('proceso', 'segmentosInstrumento'),
            datos.append('idBaseEncuesta', idBaseEncuesta);
            datos.append('idInstrumento', idInstrumento);

            const response = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

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
        url: 'ajax/encuestas/reportes.ajax.php',
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
        url: 'ajax/encuestas/reportes.ajax.php',
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

const generarReportConsoMedGeneralAuto = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoMedGeneral");

    let formulario = document.getElementById("formReportConsoMedGeneral");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let tipoEncuesta = 'AUTOINMUNES';
            let especialidad = 'MEDICINA GENERAL';

            let datosReport = [

                { tipo: 'DILIGENCIAMIENTO', table: 'tablaDiligenciamiento', container: 'containerDiligenciamiento', title: '% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA MEDICO GENERAL', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA-1', table: 'tablaEvaluacionClinica1', container: 'containerEvaluacionClinica1', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA-2', table: 'tablaEvaluacionClinica2', container: 'containerEvaluacionClinica2', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-1', table: 'tablaParaclinicos1', container: 'containerParaclinicos1', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-2', table: 'tablaParaclinicos2', container: 'containerParaclinicos2', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-GENERAL', table: 'tablaParaclinicosGeneral', container: 'containerParaclinicosGeneral', title:'PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS GENERAL', tableType:'PARACLINICOS-GENERAL', dataResult:'porcentaje'},
                { tipo: 'RECOMENDACIONES-COHERENCIA', table: 'tablaRecomendacionCoherencia', container: 'containerRecomendacionCoherencia', title:'% DE CUMPLIMIENTO RECOMENDACIONES Y COHERENCIA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'ATRIBUTOS-CALIDAD', table: 'tablaAtributosCalidad', container: 'containerAtributosCalidad', title:'% DE CUMPLIMIENTO ATRIBUTOS DE CALIDAD', tableType:'NORMAL', dataResult:'porcentaje'}

            ]

            for (const info of datosReport) {
                
                await generarTablasConsolidado(idBaseEncuesta, tipoEncuesta, especialidad, info);
                await generarGraficaConsolidado(idBaseEncuesta, tipoEncuesta, especialidad, info);

            }



        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarReportConsoReumatologiaAuto = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoReumatologia");

    let formulario = document.getElementById("formReportConsoReumatologia");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let tipoEncuesta = 'AUTOINMUNES';
            let especialidad = 'REUMATOLOGIA';

            let datosReport = [

                { tipo: 'DILIGENCIAMIENTO', table: 'tablaDiligenciamiento', container: 'containerDiligenciamiento', title: '% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA REUMATOLOGIA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA-1', table: 'tablaEvaluacionClinica1', container: 'containerEvaluacionClinica1', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA-2', table: 'tablaEvaluacionClinica2', container: 'containerEvaluacionClinica2', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-1', table: 'tablaParaclinicos1', container: 'containerParaclinicos1', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-2', table: 'tablaParaclinicos2', container: 'containerParaclinicos2', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-GENERAL', table: 'tablaParaclinicosGeneral', container: 'containerParaclinicosGeneral', title:'PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS GENERAL', tableType:'PARACLINICOS-GENERAL', dataResult:'porcentaje'},
                { tipo: 'RECOMENDACIONES-COHERENCIA', table: 'tablaRecomendacionCoherencia', container: 'containerRecomendacionCoherencia', title:'% DE CUMPLIMIENTO RECOMENDACIONES Y COHERENCIA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'ATRIBUTOS-CALIDAD', table: 'tablaAtributosCalidad', container: 'containerAtributosCalidad', title:'% DE CUMPLIMIENTO ATRIBUTOS DE CALIDAD', tableType:'NORMAL', dataResult:'porcentaje'}

            ]

            for (const info of datosReport) {
                
                await generarTablasConsolidado(idBaseEncuesta, tipoEncuesta, especialidad, info);
                await generarGraficaConsolidado(idBaseEncuesta, tipoEncuesta, especialidad, info);

            }



        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarReportConsoMedInternaAuto = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoMedInterna");

    let formulario = document.getElementById("formReportConsoMedInterna");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let tipoEncuesta = 'AUTOINMUNES';
            let especialidad = 'MEDICINA INTERNA';

            let datosReport = [

                { tipo: 'DILIGENCIAMIENTO', table: 'tablaDiligenciamiento', container: 'containerDiligenciamiento', title: '% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA MEDICINA INTERNA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA-1', table: 'tablaEvaluacionClinica1', container: 'containerEvaluacionClinica1', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA-2', table: 'tablaEvaluacionClinica2', container: 'containerEvaluacionClinica2', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-1', table: 'tablaParaclinicos1', container: 'containerParaclinicos1', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-2', table: 'tablaParaclinicos2', container: 'containerParaclinicos2', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-GENERAL', table: 'tablaParaclinicosGeneral', container: 'containerParaclinicosGeneral', title:'PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS GENERAL', tableType:'PARACLINICOS-GENERAL', dataResult:'porcentaje'},
                { tipo: 'RECOMENDACIONES-COHERENCIA', table: 'tablaRecomendacionCoherencia', container: 'containerRecomendacionCoherencia', title:'% DE CUMPLIMIENTO RECOMENDACIONES Y COHERENCIA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'ATRIBUTOS-CALIDAD', table: 'tablaAtributosCalidad', container: 'containerAtributosCalidad', title:'% DE CUMPLIMIENTO ATRIBUTOS DE CALIDAD', tableType:'NORMAL', dataResult:'porcentaje'}

            ]

            for (const info of datosReport) {
                
                await generarTablasConsolidado(idBaseEncuesta, tipoEncuesta, especialidad, info);
                await generarGraficaConsolidado(idBaseEncuesta, tipoEncuesta, especialidad, info);

            }



        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarReportConsoMedFamiliarAuto = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoMedFamiliar");

    let formulario = document.getElementById("formReportConsoMedFamiliar");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let tipoEncuesta = 'AUTOINMUNES';
            let especialidad = 'MEDICINA FAMILIAR';

            let datosReport = [

                { tipo: 'DILIGENCIAMIENTO', table: 'tablaDiligenciamiento', container: 'containerDiligenciamiento', title: '% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA MEDICINA FAMILIAR', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA-1', table: 'tablaEvaluacionClinica1', container: 'containerEvaluacionClinica1', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA-2', table: 'tablaEvaluacionClinica2', container: 'containerEvaluacionClinica2', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-1', table: 'tablaParaclinicos1', container: 'containerParaclinicos1', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-2', table: 'tablaParaclinicos2', container: 'containerParaclinicos2', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-GENERAL', table: 'tablaParaclinicosGeneral', container: 'containerParaclinicosGeneral', title:'PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS GENERAL', tableType:'PARACLINICOS-GENERAL', dataResult:'porcentaje'},
                { tipo: 'RECOMENDACIONES-COHERENCIA', table: 'tablaRecomendacionCoherencia', container: 'containerRecomendacionCoherencia', title:'% DE CUMPLIMIENTO RECOMENDACIONES Y COHERENCIA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'ATRIBUTOS-CALIDAD', table: 'tablaAtributosCalidad', container: 'containerAtributosCalidad', title:'% DE CUMPLIMIENTO ATRIBUTOS DE CALIDAD', tableType:'NORMAL', dataResult:'porcentaje'}

            ]

            for (const info of datosReport) {
                
                await generarTablasConsolidado(idBaseEncuesta, tipoEncuesta, especialidad, info);
                await generarGraficaConsolidado(idBaseEncuesta, tipoEncuesta, especialidad, info);

            }



        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}



const generarTablasConsolidado = async (idBaseEncuesta, tipoEncuesta, especialidad, info) => {

    let datos = new FormData();
    datos.append('proceso', 'infoReporteEspecidalidad'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('tipoEncuesta', tipoEncuesta);
    datos.append('especialidad', especialidad);
    datos.append('tipo', info.tipo);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
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
            destroyTable(info.table);

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
            destroyTable(info.table);

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
            destroyTable(info.table);

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
            destroyTable(info.table);

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
            destroyTable(info.table);

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

const generarGraficaConsolidado = async (idBaseEncuesta, tipoEncuesta, especialidad, info) => {

    let datos = new FormData();
    datos.append('proceso', 'infoReporteEspecidalidad'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('tipoEncuesta', tipoEncuesta);
    datos.append('especialidad', especialidad);
    datos.append('tipo', info.tipo);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
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
                        name: '% CUMPLIMIENTO PARACLINICOS ORDENADOS',
                        // data: dataResultOrdenado
                        data: dataResultOrdenado.map(item => ({
                            y: item,
                            color: obtenerColorLabel(item)
                        }))
                    },
                    {
                        name: '% CUMPLIMIENTO PARACLINICOS ANALIZADOS',
                        // data: dataResultAnalizado
                        data: dataResultAnalizado.map(item => ({
                            y: item,
                            color: obtenerColorLabel(item)
                        }))
                        
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
                        text: 'CANTIDAD'
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
                    max: 100,
                    title: {
                        text: 'CANTIDAD'
                    }
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                    {
                        name: 'ITEM',
                        data: dataResult
                    },
                ]
            });

        }else if(info.tableType == 'PARACLINICOS'){

            

        }


    }

}

const generarReporteIndicador = async () => {

    const cardResultado = document.querySelector("#cardResultadoIndicador");

    let formulario = document.getElementById("formReportIndicadores");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let procesosIndicadorVih = [
                { proceso: 'MEDICINA FAMILIAR' },
                { proceso: 'REUMATOLOGIA' },
                { proceso: 'MEDICINA GENERAL' },
                { proceso: 'MEDICINA INTERNA' },
                { proceso: 'ENFERMERIA' },
                { proceso: 'PSICOLOGIA' },
                { proceso: 'NUTRICION' },
                { proceso: 'TRABAJO SOCIAL' },
                { proceso: 'QUIMICO FARMACEUTICO' },
                { proceso: 'FISIOTERAPIA' },
                { proceso: 'TERAPIA OCUPACIONAL' },
                { proceso: 'OTROS ESPECIALISTAS' }
            ]

            for (const proceso of procesosIndicadorVih){

                await generarTablaIndicador(idBaseEncuesta, proceso.proceso);
                
            }

            await reiniciarTable(`tablaIndicadores`);

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarTablaIndicador = async (idBaseEncuesta, procesoEncu) => {

    let datos = new FormData();
    datos.append('proceso', 'infoDatosIndicador2'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('procesoEncu', procesoEncu);
    datos.append('tipoEncuesta', 'AUTOINMUNES');

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    const tableTbody = document.querySelector('#tablaIndicadores .tbodyTable');

    let valor = (response.cantidad_satisfactorio / response.cantidad_total * 100).toFixed(0);

    let colorBadged = '';

    if (valor >= 90 && valor <= 100) {
        colorBadged = 'success';
    } else if (valor >= 71 && valor <= 89) {
        colorBadged = 'warning';
    } else {
        colorBadged = 'danger';
    }

    tableTbody.innerHTML += `
        <tr>
            <td>PORCENTAJE DE CUMPLIMIENTO DE LA HISTORIA CLINICA ${procesoEncu}</td>
            <td>NÚMERO DE HISTORIAS CLINICAS DE ${procesoEncu} EVALUADAS Y QUE CUMPLEN LOS CRITERIOS</td>
            <td>AUDITORIA DE HISTORIA CLÍNICA</td>
            <td>NÚMERO DE HISTORIAS CLÍNICAS ${procesoEncu} EVALUADAS</td>
            <td>AUDITORIA DE HISTORIA CLÍNICA</td>
            <td>90%</td>
            <td>SEMESTRAL</td>
            <td>${response.cantidad_satisfactorio}/${response.cantidad_total}</td>
            <td><span class="badge bg-${colorBadged}"><h5 class="text-white">${valor}%</h5></span></td>
        </tr>
    `;


}

const generarReporteConsolidadoMedicoEspecialista = async () => {

    const cardResultado = document.querySelector("#cardResultadoConsoMedicoEspecialista");

    let formulario = document.getElementById("formReportMedEsp");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;


            /*==============================
            TABLA Y GRAFICA DE MEDICOS
            ==============================*/

            let datosMedicos = new FormData();
            datosMedicos.append('proceso', 'infoReportConsoMedicoEspecialista'),
            datosMedicos.append('idBaseEncuesta', idBaseEncuesta);
            datosMedicos.append('tipoEncuesta', 'AUTOINMUNES');
            datosMedicos.append('tipoProfesional', 'MEDICO');

            const responseMedico = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datosMedicos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            let idTableMedico = "tablaConsolidadoMedico";
            let tBodyTableMedico = document.querySelector(`#${idTableMedico} .tbodyTable`);
            let cadenaBodyMedico = ``;

            destroyTable(idTableMedico);

            for (const res of responseMedico) {

                cadenaBodyMedico += `
                <tr>
                    <td>${res.profesional_auditado}</td>
                    <td>${res.cantidad}</td>
                    <td>${res.calificacion}%</td>
                </tr>`;
        
            }
        
            tBodyTableMedico.innerHTML = cadenaBodyMedico;

            await reiniciarTable(idTableMedico);


            let categories = responseMedico.map(item => item.profesional_auditado);
            categories.push('PROMEDIO');
            let dataResult = responseMedico.map(data => parseInt(data.calificacion));
            let promedio = 0;

            dataResult.forEach(element => {
                promedio += Number(element);
            })
            dataResult.push(Number((promedio/dataResult.length).toFixed(0)));

            Highcharts.chart(`containerGraficaConsolidadoMedico`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `RESULTADOS DE AUDITORIA MEDICOS DEL PROGRAMA`,
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
                    name: 'PROFESIONALES',
                    data: dataResult.map(item => ({
                        y: item,
                        color: obtenerColorLabel(item)
                    }))
                }]
            });

            /*==============================
            TABLA Y GRAFICA DE ESPECIALISTAS
            ==============================*/

            let datosEspecialista = new FormData();
            datosEspecialista.append('proceso', 'infoReportConsoMedicoEspecialista'),
            datosEspecialista.append('idBaseEncuesta', idBaseEncuesta);
            datosEspecialista.append('tipoEncuesta', 'AUTOINMUNES');
            datosEspecialista.append('tipoProfesional', 'ESPECIALISTA');

            const responseEspecialista = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datosEspecialista,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            let idTableEspecialista = "tablaConsolidadoEspecialista";
            let tBodyTableEspecialista = document.querySelector(`#${idTableEspecialista} .tbodyTable`);
            let cadenaBodyEspecialista = ``;

            destroyTable(idTableEspecialista);

            for (const res of responseEspecialista) {

                cadenaBodyEspecialista += `
                <tr>
                    <td>${res.nombre_usuario}</td>
                    <td>${res.cantidad}</td>
                    <td>${res.calificacion}%</td>
                </tr>`;
        
            }
        
            tBodyTableEspecialista.innerHTML = cadenaBodyEspecialista;

            await reiniciarTable(idTableEspecialista);

            let categoriesEsp = responseEspecialista.map(item => item.nombre_usuario);
            categoriesEsp.push('PROMEDIO');
            let dataResultEsp = responseEspecialista.map(data => parseInt(data.calificacion));
            let promedioEsp = 0;

            dataResultEsp.forEach(element => {
                promedioEsp += Number(element);
            })
            dataResultEsp.push(Number((promedioEsp/dataResultEsp.length).toFixed(0)));

            Highcharts.chart(`containerGraficaConsolidadoEspecialista`, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: `RESULTADOS DE AUDITORIA POR PROFESIONAL DE ESPECIALISTAS`,
                    align: 'center',
                    style: {
                        fontSize: `${fontSizeTitle}px` 
                    }
                },
                xAxis: {
                    categories: categoriesEsp,
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
                    name: 'PROFESIONALES',
                    data: dataResultEsp.map(item => ({
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

const obtenerEspecialidadesBase = () => {

    let idBaseEncu = document.querySelector('#basesEncuestas').value;

    $.ajax({

        type: "POST",
        url: "ajax/encuestas/reportes.ajax.php",
        data: {
            'proceso': 'listaEspecialidadBase',
            'idBaseEncu': idBaseEncu
        },
        success:function(respuesta){
    
            $("#especialidadEncuesta").html(respuesta);
    
        }
    
    })

}


const obtenerAuditoresEspecialidad = () => {

    let especialidad = document.querySelector('#especialidadEncuesta').value;
    let idBaseEncu = document.querySelector('#basesEncuestas').value;

    $.ajax({

        type: "POST",
        url: "ajax/encuestas/reportes.ajax.php",
        data: {
            'proceso': 'listaAuditoresEspecialidad',
            'idBaseEncu': idBaseEncu,
            'especialidad': especialidad,
            'tipoEncuesta': 'AUTOINMUNES'
        },
        success:function(respuesta){
    
            $("#auditorEncuesta").html(respuesta);
    
        }
    
    })

}

const generarReportConsolidadoAutoProfesional = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoProfesionalEspecialidad");

    let formulario = document.getElementById("formReportConsoProfeEspe");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;
            let especialidad = document.getElementById("especialidadEncuesta").value;
            let auditor = document.getElementById("auditorEncuesta").value;

            let tipoEncuesta = 'AUTOINMUNES';

            let datosReport = [

                { tipo: 'DILIGENCIAMIENTO', table: 'tablaDiligenciamiento', container: 'containerDiligenciamiento', title: `% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA ${especialidad}`, tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA-1', table: 'tablaEvaluacionClinica1', container: 'containerEvaluacionClinica1', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA-2', table: 'tablaEvaluacionClinica2', container: 'containerEvaluacionClinica2', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-1', table: 'tablaParaclinicos1', container: 'containerParaclinicos1', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-2', table: 'tablaParaclinicos2', container: 'containerParaclinicos2', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-GENERAL', table: 'tablaParaclinicosGeneral', container: 'containerParaclinicosGeneral', title:'PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS GENERAL', tableType:'PARACLINICOS-GENERAL', dataResult:'porcentaje'},
                { tipo: 'RECOMENDACIONES-COHERENCIA', table: 'tablaRecomendacionCoherencia', container: 'containerRecomendacionCoherencia', title:'% DE CUMPLIMIENTO RECOMENDACIONES Y COHERENCIA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'ATRIBUTOS-CALIDAD', table: 'tablaAtributosCalidad', container: 'containerAtributosCalidad', title:'% DE CUMPLIMIENTO ATRIBUTOS DE CALIDAD', tableType:'NORMAL', dataResult:'porcentaje'}

            ]

            for (const info of datosReport) {
                
                await generarTablasConsolidadoProfesional(idBaseEncuesta, tipoEncuesta, especialidad, info, auditor);
                await generarGraficaConsolidadoProfesional(idBaseEncuesta, tipoEncuesta, especialidad, info, auditor);

            }



        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarTablasConsolidadoProfesional = async (idBaseEncuesta, tipoEncuesta, especialidad, info, auditor) => {

    let datos = new FormData();
    datos.append('proceso', 'infoReporteEspecidalidadxProfesional'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('tipoEncuesta', tipoEncuesta);
    datos.append('especialidad', especialidad);
    datos.append('tipo', info.tipo);
    datos.append('auditor', auditor);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
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
            const tableHtml = document.querySelector(`#${info.table}`);
            let tbodyTable = tableHtml.querySelector('tbody')
            if(tbodyTable){
                tbodyTable.remove();
            }
            tbodyTable = document.createElement('tbody');
            
            for(const res of response) {
                
                cadenaBody += `
                <tr>
                <td>${res.item}</td>
                <td>${res.resultado}%</td>
                </tr>`;
                
            }
            
            tbodyTable.innerHTML += cadenaBody;
            tableHtml.appendChild(tbodyTable);

            await reiniciarTable(info.table);


        }else if(info.tableType == 'PARACLINICOS'){


            let cadenaBody = ``;
            const tableHtml = document.querySelector(`#${info.table}`);
            let tbodyTable = tableHtml.querySelector('tbody')
            if(tbodyTable){
                tbodyTable.remove();
            }
            tbodyTable = document.createElement('tbody');

            for(const res of response){
                
                cadenaBody += `
                <tr>
                    <td>${res.titulo_descripcion}</td>    
                    <td>${res.resultado_ordenado}%</td>    
                    <td>${res.resultado_analizado}%</td>    
                </tr>`;

            }

            tbodyTable.innerHTML += cadenaBody;
            tableHtml.appendChild(tbodyTable);

            await reiniciarTable(info.table);


        }else if(info.tableType == 'PARACLINICOS-GENERAL'){


            let cadenaBody = ``;
            const tableHtml = document.querySelector(`#${info.table}`);
            let tbodyTable = tableHtml.querySelector('tbody')
            if(tbodyTable){
                tbodyTable.remove();
            }
            
            tbodyTable = document.createElement('tbody');

            cadenaBody += `
            <tr>
                <td>${response.resultado_ordenado}%</td>    
                <td>${response.resultado_analizado}%</td>    
            </tr>`;

            tbodyTable.innerHTML += cadenaBody;
            tableHtml.appendChild(tbodyTable);

            await reiniciarTable(info.table);

        }


    }else if(info.dataResult == 'cantidad'){

        if(info.tableType == 'NORMAL'){

            let cadenaBody = ``;
            const tableHtml = document.querySelector(`#${info.table}`);
            let tbodyTable = tableHtml.querySelector('tbody')
            if(tbodyTable){
                tbodyTable.remove();
            }
            tbodyTable = document.createElement('tbody');

            for(const res of response) {
                
                cadenaBody += `
                <tr>
                    <td>${res.item}</td>
                    <td>${res.resultado}</td>
                </tr>`;

            }

            
            let totalCantidad = 0;
            for (const res of response) {
                totalCantidad += parseInt(res.resultado);
            }
            
            cadenaBody += `
            <tr>
            <td><b>TOTAL</b></td>
            <td><b>${totalCantidad}</b></td>
            </tr>`;
            
            tbodyTable.innerHTML += cadenaBody;
            tableHtml.appendChild(tbodyTable);

            await reiniciarTable(info.table);

        }else if(info.tableType == 'PARACLINICOS'){

            // let cadenaBody = ``;
            // const tbodyConsolidado = document.querySelector(`#${info.table} .tbodyTable`);

            // for(const res of response){
                
            //     cadenaBody += `
            //     <tr>
            //         <td>${res.titulo_descripcion}</td>    
            //         <td>${res.resultado_ordenado}</td>    
            //         <td>${res.resultado_analizado}</td>    
            //     </tr>`;

            // }

            // tbodyConsolidado.innerHTML += cadenaBody;

            // await reiniciarTable(info.table);

        }


    }


}

const generarGraficaConsolidadoProfesional = async (idBaseEncuesta, tipoEncuesta, especialidad, info, auditor) => {

    let datos = new FormData();
    datos.append('proceso', 'infoReporteEspecidalidadxProfesional'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('tipoEncuesta', tipoEncuesta);
    datos.append('especialidad', especialidad);
    datos.append('tipo', info.tipo);
    datos.append('auditor', auditor);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
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
                        name: '% CUMPLIMIENTO PARACLINICOS ORDENADOS',
                        // data: dataResultOrdenado
                        data: dataResultOrdenado.map(item => ({
                            y: item,
                            color: obtenerColorLabel(item)
                        }))
                    },
                    {
                        name: '% CUMPLIMIENTO PARACLINICOS ANALIZADOS',
                        // data: dataResultAnalizado
                        data: dataResultAnalizado.map(item => ({
                            y: item,
                            color: obtenerColorLabel(item)
                        }))
                    }
                ]
            });
            

        }else if(info.tableType == 'PARACLINICOS-GENERAL'){

            // console.log(response);

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
                        text: 'CANTIDAD'
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
                        // data: [Number(response.resultado_ordenado)]
                        data: [
                            {
                                y: Number(response.resultado_ordenado),
                                color: obtenerColorLabel(Number(response.resultado_ordenado))
                            }
                        ]
                    },
                    {
                        name: 'PROMEDIO % CUMPLIMIENTO PARACLINICOS ANALIZADOS',
                        // data: [Number(response.resultado_analizado)]
                        data: [
                            {
                                y: Number(response.resultado_analizado),
                                color: obtenerColorLabel(Number(response.resultado_analizado))
                            }
                        ]
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
                    max: 100,
                    title: {
                        text: 'CANTIDAD'
                    }
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                    {
                        name: 'ITEM',
                        data: dataResult
                    },
                ]
            });

        }else if(info.tableType == 'PARACLINICOS'){

            

        }


    }

}

const obtenerAuditoresInstrumento = () => {

    let idInstrumento = document.querySelector('#instrumentosEncuesta').value;
    let idBaseEncu = document.querySelector('#basesEncuestas').value;

    $.ajax({

        type: "POST",
        url: "ajax/encuestas/reportes.ajax.php",
        data: {
            'proceso': 'listaAuditoresInstrumento',
            'idBaseEncu': idBaseEncu,
            'idInstrumento': idInstrumento,
        },
        success:function(respuesta){
    
            $("#auditorInstrumento").html(respuesta);
    
        }
    
    })

}


const generarReporteInstrumentoxProfesional = async () => {

    const cardResultado = document.querySelector("#cardResultadoInstrumentoProfesional");

    let formulario = document.getElementById("formReportInstrumentosProfesional");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;
            let idInstrumento = document.getElementById("instrumentosEncuesta").value;
            let auditor = document.getElementById("auditorInstrumento").value;

            let cardBodyResult = document.querySelector('.cardBodyResult');
            cardBodyResult.innerHTML = '';


            let datos = new FormData();
            datos.append('proceso', 'segmentosInstrumentoProfesional'),
            datos.append('idBaseEncuesta', idBaseEncuesta);
            datos.append('idInstrumento', idInstrumento);
            datos.append('auditor', auditor);

            const response = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            let rowTable = document.createElement('div');
            rowTable.className = 'col-sm-12 col-md-6';
            let cadena = ``;
            let tableSegmento = document.createElement('table');
            tableSegmento.className = 'table table-striped'
            tableSegmento.id = `tableSegmentoGeneral${idInstrumento}`;
            let tableSegmentoThead = document.createElement('thead');
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

                await generarTablaPreguntasSegmentosProfesional(idBaseEncuesta, res, res.item, cardBodyResult, idInstrumento, auditor);
                await generarGraficasPreguntasSegmentosProfesional(idBaseEncuesta, res, res.item, cardBodyResult, idInstrumento, auditor);
                
            }


        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}


const generarTablaPreguntasSegmentosProfesional = async (idBaseEncuesta, infoSegmento, segmento, body, idInstrumento, auditor) => {

    let datos = new FormData();
    datos.append('proceso', 'preguntasSegmentoIntrumentoProfesional'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('idEncuSegmento', infoSegmento.id_encu_segmento);
    datos.append('idInstrumento', idInstrumento);
    datos.append('auditor', auditor);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
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

const generarGraficasPreguntasSegmentosProfesional = async (idBaseEncuesta, infoSegmento, segmento, body, idInstrumento, auditor) => {

    let datos = new FormData();
    datos.append('proceso', 'preguntasSegmentoIntrumentoProfesional'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('idEncuSegmento', infoSegmento.id_encu_segmento);
    datos.append('idInstrumento', idInstrumento);
    datos.append('auditor', auditor);

    //CREAR CARD

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
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

const generarReporteGeneralAutoinmunes = async () => {

    let formulario = document.getElementById("formReportGeneralAutoinmunes");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()) {

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;
            let idEncuProceso = document.getElementById("listaInstrumentosGeneral").value;
            const alertBody = document.getElementById("alertBodyLoad");

            const datos = new FormData();
            datos.append('proceso', 'generarReporteGeneralAutoinmunes');
            datos.append('idBaseEncuesta', idBaseEncuesta);
            datos.append('idEncuProceso', idEncuProceso);
            datos.append('tipoEncuesta', 'AUTOINMUNES');
            datos.append('user', userSession);

            $.ajax({

                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datos,
                cache:false,
                contentType: false,
                processData: false,
                dataType: "json",
                success:function(respuesta){
                    
                    if(respuesta == 'ok'){

                        toastr.success("¡La solicitud del Reporte se genero correctamente!", "¡Atencion!");
                        tablaSolicitudesReportesConsolidados.ajax.reload();
                        
                    }else{
                        
                        toastr.danger("¡La solicitud del Reporte no se genero correctamente!", "¡Atencion!");
                        tablaSolicitudesReportesConsolidados.ajax.reload();

                    }          

                }

            });

        } else {
            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");
        }

    }
};

const generarReportConsolidadoCalificacionSegmentoAuto = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoCaliSegmentoAuto");

    let formulario = document.getElementById("formReporteConsilidadoCaliSegmentoAuto");
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

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let datosMedicos = new FormData();
            datosMedicos.append('proceso', 'infoReportConsolidadoCalificacionesSegmento'),
            datosMedicos.append('idBaseEncuesta', idBaseEncuesta);
            datosMedicos.append('tipoEncuesta', 'AUTOINMUNES');

            const respuesta = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datosMedicos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            // console.log({respuesta});

            let idTable = "tablaConsolidadoCaliSegmentoAuto";
            let tBodyTable = document.querySelector(`#${idTable} .tbodyTable`);
            let cadenaBody = ``;
            let cantidadTotal = 0;

            destroyTable(idTable);

            for (const res of respuesta) {

                cantidadTotal += Number(res.cantidad_encuestas);

                cadenaBody += `
                <tr>
                    <td>${res.resultado}</td>
                    <td>${res.cantidad_encuestas}</td>
                </tr>`;
        
            }
        
            tBodyTable.innerHTML = cadenaBody;

            const tfootTable = document.querySelector(`#${idTable} .tfootTable`);

            let cadenaFinal = `
                <tr>
                    <td><b>TOTAL</b></td>
                    <td><b>${cantidadTotal}</b></td>
                </tr>
            `;

            tfootTable.innerHTML = cadenaFinal;

            await reiniciarTable(idTable);

            

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

tablaSolicitudesReportesConsolidados = $('#tablaSolicitudesReportesConsolidados').DataTable({

    columns: [
        { name: '#', data: 'id_reporte'},
        { name: 'PROCESO', data: 'proceso_encuesta'},
        { name: 'TIPO ENCUESTA', data: 'tipo_encuesta'},
        { name: 'ARCHIVO', render: function(data, type, row){

            if(row.estado == 'FINALIZADO'){

                return `<a class="badge badge-phoenix fs--2 badge-phoenix-success p-2" href="../../../archivos_vidamedical/encuestas/archivos_reportes_autoinmunes/${row.nombre_archivo}"><i class="far fa-file-excel"></i> ${row.nombre_archivo}</a>`;

            }else{

                return `<span class="badge badge-phoenix badge-phoenix-warning p-2">SIN ARCHIVO</span>`;

            }

        }},
        { name: 'ESTADO', render: function(data, type, row){

            if(row.estado == 'CREADO'){

                return `<span class="badge badge-phoenix badge-phoenix-warning">${row.estado}</span>`;
                
            }else if(row.estado == 'PROCESO'){
                
                return `<span class="badge badge-phoenix badge-phoenix-primary">${row.estado}</span>`;
                
            }else{
                
                return `<span class="badge badge-phoenix badge-phoenix-success">${row.estado}</span>`;

            }

        }},
    ],
    ordering: true,
    order: [[0, 'desc']],
    ajax: {
        url: 'ajax/encuestas/reportes.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaSolicitudesReportesConsolidados',
            'tipoEncuesta': 'AUTOINMUNES'
        }
    }

})
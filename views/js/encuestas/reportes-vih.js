let fontSizeTitle = 13;

/*============================
LISTA BASES ENCUESTAS
============================*/
$.ajax({

    type: "POST",
    url: "ajax/encuestas/reportes.ajax.php",
    data: {
        'proceso': 'listaBasesEncuestas',
        'tipoEncuesta': 'VIH'
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
        'tipoEncuesta': 'VIH'
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
        'tipoEncuesta': 'VIH'
    },
    success:function(respuesta){

        $("#listaInstrumentosGeneral").html(respuesta);

    }

})

const compararCantidad = async (a, b) => {

    return parseInt(b.cantidad) - parseInt(a.cantidad);

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

const obtenerColorLabelFrecuencia = (respuesta) => {

    
    let color;
    
    if(respuesta === '1'){
        
        color = '#25b003';
        
    }else if(respuesta === '0'){
        
        color = '#ffda22';
        
    }else if(respuesta === 'NO REGISTRA ATENCIONES'){

        color = '#ed2000';
        
    }else if(respuesta === 'NA' || respuesta === 'DISENTIMIENTO'){
        
        color = '#2caffe';
        
    }else{
        
        color = '#3874ff';
        
    }
    
    return color;

}

function obtenerColorAleatorio() {
    const letras = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
      color += letras[Math.floor(Math.random() * 16)];
    }
    return color;
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

const destroyTable = (idTable) => {

    if ($.fn.DataTable.isDataTable(`#${idTable}`)) {
        $(`#${idTable}`).DataTable().clear().destroy();
    }
    
}

const generarReportConsolidadoEpsVIH = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoEpsVIH");

    let formulario = document.getElementById("formReporteConsilidadoEpsVIH");
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

            const tbodyTable = document.querySelector('.tbodyTable');

            let cadenaBody = ``;
            let totalCantidad = 0;
            let totalPorcentaje = 0;


            //DESTRIR TABLA ANTES DE INSERTAR CONTENIDO
            destroyTable('tablaConsolidadoEpsVIH');


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
            reiniciarTable('tablaConsolidadoEpsVIH');

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarReportConsolidadoGrupoInterVIH = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoGpInter");

    let formulario = document.getElementById("formReportGpInter");
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
            datos.append('procesoEncuesta', 'MEDICINA');

            const resultado = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            // console.log(resultado);
            
            let arrayOrganizado = resultado.sort((a, b) => parseInt(b.cantidad) - parseInt(a.cantidad));

            let idTable = "tablaConsolidadoGpInter";
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
            
            Highcharts.chart('containerConsolidadoGrupoInter', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'CONSOLIDADO POR GRUPO INTERDISCIPLINARIO',
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
                        text: 'TOTAL DE HISTORIAS CLÍNICAS AUDITADAS'
                    }
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}'
                        }
                    },
                },
                series: [
                    {
                        name: 'PROFESIONAL AUDITADO',
                        data: dataResult
                    },
                ]
            });


            //TABLA Y GRAFICA PUNTAJE

            let idTablePuntaje = "tablaConsolidadoGpInterPuntaje";
            const tbodyTablePuntaje = document.querySelector(`#${idTablePuntaje} .tbodyTable`);

            destroyTable(idTablePuntaje);

            let cadenaBodyPuntaje = ``;

            let arrayOrganizadoPuntaje = resultado.sort((a, b) => parseInt(b.puntaje) - parseInt(a.puntaje));

            for (const res of arrayOrganizadoPuntaje) {
                
                cadenaBodyPuntaje += `
                <tr>
                    <td>${res.grupo}</td>
                    <td>${res.puntaje}%</td>
                </tr>`;
                
            }

            tbodyTablePuntaje.innerHTML = cadenaBodyPuntaje;

            //REINICIAR TABLA PARA QUE SE MUESTRE COMO DATATABLE
            await reiniciarTable(idTablePuntaje);
            
            let categoriesPuntaje = arrayOrganizado.map(item => item.grupo);
            categoriesPuntaje.push('PROMEDIO');

            let dataResultPuntaje = arrayOrganizado.map(item => parseInt(item.puntaje));

            let promedio = 0;

            dataResultPuntaje.forEach(element => {
                promedio += Number(element);
            })
            dataResultPuntaje.push(Number((promedio/dataResultPuntaje.length).toFixed(0)));
            
            Highcharts.chart('containerConsolidadoGrupoInterPuntaje', {
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
                    categories: categoriesPuntaje,
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
                        name: 'PROFESIONAL AUDITADO',
                        data: dataResultPuntaje.map(item => ({
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

const generarConsolidadoFrecuenciasVIH = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteFrecuencias");

    let formulario = document.getElementById("formReportFrecuenciasVIH");
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

            let datosReport = [
                { tipo: 'MEDICO-EXPERTO', table: 'tablaConsolidadoMedicoExperto', container: 'containerGraficaMedicoExperto', title: 'FRECUENCIA DE ATENCIÓN POR MÉDICO DEL PROGRAMA DE VIH'},
                { tipo: 'INFECTOLOGIA', table: 'tablaConsolidadoInfectologo', container: 'containerGraficaInfectologo', title:'CUMPLIMIENTO FRECUENCIAS DE ATENCIÓN INFECTÓLOGO'},
                { tipo: 'PSICOLOGIA', table: 'tablaConsolidadoPsicologia', container: 'containerGraficaPsicologia', title:'FRECUENCIAS DE ATENCION DE PSICOLOGIA'},
                { tipo: 'NUTRICION', table: 'tablaConsolidadoNutricion', container: 'containerGraficaNutricion', title:'FRECUENCIA DE ATENCIÓN POR NUTRICIÓN'},
                { tipo: 'TRABAJO-SOCIAL', table: 'tablaConsolidadoTrabajoSocial', container: 'containerGraficaTrabajoSocial', title:'FRECUENCIA DE ATENCIÓN POR TRABAJO SOCIAL'},
                { tipo: 'ODONTOLOGIA', table: 'tablaConsolidadoOdontologia', container: 'containerGraficaOdontologia', title:'FRECUENCIAS DE ATENCION POR ODONTOLOGIA'},
                { tipo: 'QUIMICO-FARMACEUTICO', table: 'tablaConsolidadoQuimicoFarmaceutico', container: 'containerGraficaQuimicoFarmaceutico', title:'FRECUENCIAS DE ATENCION POR QUIMICO FARMACEUTA'},
                { tipo: 'ENFERMERIA', table: 'tablaConsolidadoEnfermeria', container: 'containerGraficaEnfermeria', title:'FRECUENCIAS DE ATENCION POR ENFERMERIA'},
                { tipo: 'SIAU', table: 'tablaConsolidadoSIAU', container: 'containerGraficaSIAU', title:'SEGUIMIENTO PACIENTES DE LA MUESTRA'},
                { tipo: 'PSIQUIATRIA', table: 'tablaConsolidadoPsiquiatria', container: 'containerGraficaPsiquiatria', title:'FRECUENCIAS DE ATENCION DE PSIQUIATRIA'},
            ]

            for (const frecuencia of datosReport) {
                
                await generalTablasFrecuencias(idBaseEncuesta, frecuencia);
                await generarGraficasFrecuencias(idBaseEncuesta, frecuencia);

            }

            await generarConsolidadoFrecuenciasGrupo(idBaseEncuesta);
            

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarConsolidadoFrecuenciasGrupo = async (idBaseEncuesta) => {

    let datos = new FormData();
    datos.append('proceso', 'infoReporteConsolidadoFrencuenciaGrupo'),
    datos.append('idBaseEncuesta', idBaseEncuesta);

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    let tabla = "tablaConsolidadoFrecuenciasGrupo";
    let containerGrafica = "containerGraficaConsolidadoFrecuenciaGrupo";

    destroyTable(tabla);

    const tbodyTable = document.querySelector(`#${tabla} .tbodyTable`);

    let cadenaBody = ``;

    for (const res of response) {
        
        cadenaBody += `
        <tr>
            <td>${res.titulo}</td>
            <td>${res.calificacion}%</td>
        </tr>`;

    }

    tbodyTable.innerHTML = cadenaBody;

    await reiniciarTable(tabla);

    let categories = response.map(item => item.titulo);
    let dataResult = response.map(item => parseInt(item.calificacion));

    Highcharts.chart(`${containerGrafica}`, {
        chart: {
            type: 'column'
        },
        title: {
            text: `CUMPLIMIENTO DE LAS FRECUENCIAS DE ATENCIÓN EQUIPO INTERDISCIPLINARIO`,
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
            name: 'PROFESIONAL EVALUADO',
            data: dataResult.map(item => ({
              y: item,
              color: obtenerColorLabel(item)
            }))
        }]
    });



}

const generarGraficasFrecuencias = async (idBaseEncuesta, infoFrecuencia) => {

    let datos = new FormData();
    datos.append('proceso', 'infoReporteFrencuencia'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('tipoEncuesta', 'VIH');
    datos.append('frecuencia', infoFrecuencia.tipo);

    const respFrecuencia = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    // console.log({respFrecuencia});

    let totalCantidad = 0;

    for (const res of respFrecuencia) {
        if(!res.titulo.includes('TRIMESTRE')){
            totalCantidad += parseInt(res.cantidad);
        }
    }


    let categories = respFrecuencia
    .filter(item => !item.titulo.includes("TRIMESTRE"))
    .map(item => item.titulo);
    // let dataResult = respFrecuencia.map(item => parseFloat((item.cantidad / totalCantidad * 100).toFixed(2)));
    let dataResult = respFrecuencia
    .filter(item => !item.titulo.includes("TRIMESTRE"))
    .map(item => ({
        respuesta: item.respuesta,
        valor: parseFloat((item.cantidad / totalCantidad * 100).toFixed(2))
    }));

    // console.log({categories});
    // console.log({dataResult});

    Highcharts.chart(`${infoFrecuencia.container}`, {
        chart: {
            type: 'column'
        },
        title: {
            text: `${infoFrecuencia.title}`,
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
            }
        },
        series: [{
            name: 'FRECUENCIAS',
            data: dataResult.map(item => ({
                y: item.valor,
                color: obtenerColorLabelFrecuencia(item.respuesta)
            }))
        }]
    });

}


const generalTablasFrecuencias = async (idBaseEncuesta, infoFrecuencia) => {

    let datos = new FormData();
    datos.append('proceso', 'infoReporteFrencuencia'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('tipoEncuesta', 'VIH');
    datos.append('frecuencia', infoFrecuencia.tipo);

    const respFrecuencia = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    // console.log(respFrecuencia);

    const tbodyFrecuencia = document.querySelector(`#${infoFrecuencia.table} .tbodyTable`);

    destroyTable(`${infoFrecuencia.table}`);

    // console.log(tbodyFrecuencia);

    let cadenaBody = ``;
    let totalCantidad = 0;
    let totalPorcentaje = 0;

    for (const res of respFrecuencia) {
        if(!res.titulo.includes('TRIMESTRE')){
            totalCantidad += parseInt(res.cantidad);
        }
    }

    let porcentaje = '';

    for (const res of respFrecuencia) {
        if(!res.titulo.includes('TRIMESTRE')){
            porcentaje = (res.cantidad / totalCantidad * 100).toFixed(2)+"%";
        }else{
            porcentaje = 'NA';
        }
        if(!res.titulo.includes('TRIMESTRE')){
            totalPorcentaje += parseFloat(porcentaje);
        }
        
        cadenaBody += `
        <tr>
            <td>${res.titulo}</td>
            <td>${res.cantidad}</td>
            <td>${porcentaje}</td>
        </tr>`;

    }

    tbodyFrecuencia.innerHTML = cadenaBody;

    const tfootTable = document.querySelector(`#${infoFrecuencia.table} .tfootTable`);

    //FILA FINAL DE RESULTADOS
    let cadenaFinal = `
        <tr>
            <td><b>TOTAL DE PACIENTES DE LA MUESTRA</b></td>
            <td><b>${totalCantidad}</b></td>
            <td><b>${totalPorcentaje.toFixed(0)}%</b></td>
        </tr>
    `;

    tfootTable.innerHTML = cadenaFinal;

    //REINICIAR TABLA PARA QUE SE MUESTRE COMO DATATABLE
    await reiniciarTable(infoFrecuencia.table);

}

const generarCumplimiAtenPacNuevoVIH = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteCumpliAtenPacNuevo");

    let formulario = document.getElementById("formReportCumpliAtenPacNuevo");
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
            datos.append('proceso', 'infoReportCumplimientoAtencionInicial'),
            datos.append('idBaseEncuesta', idBaseEncuesta);
            datos.append('tipoEncuesta', 'VIH');

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

            let arrayOrganizado = resultado["data"].sort((a, b) => parseInt(b.cantidad) - parseInt(a.cantidad));
            // console.log({arrayOrganizado});

            let idTable = "tablaReportCumpliAtenPacNuevo";
            let tBodyTable = document.querySelector('.tbodyTable');
            let totalPorcentaje = 0;
            let cadenaBody = ``;

            destroyTable(idTable);

            for (const res of arrayOrganizado) {

                let porcentaje = (res.cantidad / resultado.cantidadTotal * 100).toFixed(0);
                totalPorcentaje += parseFloat(porcentaje);
                
                cadenaBody += `
                <tr>
                    <td>${res.equipo}</td>
                    <td>${res.cantidad}</td>
                    <td>${porcentaje}%</td>
                </tr>`;
        
            }
        
            tBodyTable.innerHTML = cadenaBody;

            await reiniciarTable(idTable);

            let categories = arrayOrganizado.map(item => item.equipo);
            let dataResult = arrayOrganizado.map(item => parseFloat((item.cantidad / resultado.cantidadTotal * 100).toFixed(0)));

            Highcharts.chart('containerGraficaCumpliAtenPacNuevo', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'CUMPLIMIENTO EN LA RUTA DE ATENCION PACIENTES NUEVOS',
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
                    name: 'PROFESIONAL EVALUADO',
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

const generarReportConsoDatosIdentificacionVIH = async () => {

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
            datos.append('tipoEncuesta', 'VIH');

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

            destroyTable('tablaConsolidadoDatosIdentificacion');

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

const generarReportConsoMedExpertoVIH = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoMedExperto");

    let formulario = document.getElementById("formReportConsoMedExperto");
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

            let tipoEncuesta = 'VIH';
            let especialidad = 'MEDICINA GENERAL';

            let datosReport = [

                { tipo: 'DILIGENCIAMIENTO', table: 'tablaDiligenciamiento', container: 'containerDiligenciamiento', title: '% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA ESPECIALISTA MEDICO EXPERTO DE VIH', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'REGISTRO-ANTECEDENTES', table: 'tablaRegistroAntecedentes', container: 'containerRegistroAntecedentes', title:'% DE CUMPLIMIENTO DE REGISTRO DE ANTECEDENTES', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA', table: 'tablaEvaluacionClinica', container: 'containerEvaluacionClinica', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'SEGUIMIENTO-VACUNAS', table: 'tablaSeguimientoVacunas', container: 'containerSeguimientoVacunas', title:'% DE CUMPLIMIENTO DE SEGUIMIENTO A VACUNAS', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-1', table: 'tablaParaclinicos1', container: 'containerParaclinicos1', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-2', table: 'tablaParaclinicos2', container: 'containerParaclinicos2', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-3', table: 'tablaParaclinicos3', container: 'containerParaclinicos3', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-GENERAL', table: 'tablaParaclinicosGeneral', container: 'containerParaclinicosGeneral', title:'PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS GENERAL', tableType:'PARACLINICOS-GENERAL', dataResult:'porcentaje'},
                { tipo: 'CITOLOGIA-ANAL', table: 'tablaCitologiaAnal', container: 'containerCitologiaAnal', title:'CUMPLIMIENTO DE CITOLOGIA ANAL', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'CITOLOGIA-VAGINAL', table: 'tablaCitologiaVaginal', container: 'containerCitologiaVaginal', title:'CUMPLIMIENTO DE CITOLOGIA VAGINAL', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'ANTIGENO-PROSTATICO', table: 'tablaAntigenoProstatico', container: 'containerAntigenoProstatico', title:'CUMPLIMIENTO DE ANTIGENO PROSTATICO', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'MAMOGRAFIA', table: 'tablaMamografia', container: 'containerMamografia', title:'CUMPLIMIENTO DE MAMOGRAFIA', tableType:'NORMAL', dataResult:'cantidad'},
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

const generarReportConsoInfectologoVIH = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoInfectologo");

    let formulario = document.getElementById("formReportConsoInfectologo");
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

            let tipoEncuesta = 'VIH';
            let especialidad = 'INFECTOLOGIA';

            let datosReport = [

                { tipo: 'DILIGENCIAMIENTO', table: 'tablaDiligenciamiento', container: 'containerDiligenciamiento', title: '% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA ESPECIALISTA INFECTOLOGIA DE VIH', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'REGISTRO-ANTECEDENTES', table: 'tablaRegistroAntecedentes', container: 'containerRegistroAntecedentes', title:'% DE CUMPLIMIENTO DE REGISTRO DE ANTECEDENTES', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA', table: 'tablaEvaluacionClinica', container: 'containerEvaluacionClinica', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'SEGUIMIENTO-VACUNAS', table: 'tablaSeguimientoVacunas', container: 'containerSeguimientoVacunas', title:'% DE CUMPLIMIENTO DE SEGUIMIENTO A VACUNAS', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-1', table: 'tablaParaclinicos1', container: 'containerParaclinicos1', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-2', table: 'tablaParaclinicos2', container: 'containerParaclinicos2', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-3', table: 'tablaParaclinicos3', container: 'containerParaclinicos3', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-GENERAL', table: 'tablaParaclinicosGeneral', container: 'containerParaclinicosGeneral', title:'PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS GENERAL', tableType:'PARACLINICOS-GENERAL', dataResult:'porcentaje'},
                { tipo: 'CITOLOGIA-ANAL', table: 'tablaCitologiaAnal', container: 'containerCitologiaAnal', title:'CUMPLIMIENTO DE CITOLOGIA ANAL', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'CITOLOGIA-VAGINAL', table: 'tablaCitologiaVaginal', container: 'containerCitologiaVaginal', title:'CUMPLIMIENTO DE CITOLOGIA VAGINAL', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'ANTIGENO-PROSTATICO', table: 'tablaAntigenoProstatico', container: 'containerAntigenoProstatico', title:'CUMPLIMIENTO DE ANTIGENO PROSTATICO', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'MAMOGRAFIA', table: 'tablaMamografia', container: 'containerMamografia', title:'CUMPLIMIENTO DE MAMOGRAFIA', tableType:'NORMAL', dataResult:'cantidad'},
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

}

const generarReporteIndicador1 = async () => {

    const cardResultado = document.querySelector("#cardResultadoIndicador1");

    let formulario = document.getElementById("formReportIndicadores1");
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

            let cardBodyResult = document.querySelector('.cardBodyResult');
            cardBodyResult.innerHTML = '';

            let idBaseEncuesta = document.getElementById("basesEncuestas").value;

            let procesosIndicadorVih = [
                { proceso: 'MEDICINA GENERAL' },
                { proceso: 'INFECTOLOGIA' },
                { proceso: 'ENFERMERIA' },
                { proceso: 'PSICOLOGIA' },
                { proceso: 'NUTRICION' },
                { proceso: 'TRABAJO SOCIAL' },
                { proceso: 'ODONTOLOGIA' },
                { proceso: 'QUIMICO FARMACEUTICO' }
            ]

            for (const proceso of procesosIndicadorVih){

                await generarTablasIndicador1(idBaseEncuesta, proceso.proceso, cardBodyResult);
                await generarGraficasIndicador1(idBaseEncuesta, proceso.proceso, cardBodyResult);
                
            }


        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarGraficasIndicador1 = async (idBaseEncuesta, procesoEncu, body) => {

    let datos = new FormData();
    datos.append('proceso', 'infoDatosIndicador1'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('procesoEncu', procesoEncu);
    datos.append('tipoEncuesta', 'VIH');

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    let procesoId = procesoEncu.replace(/\s/g, "-");

    let rowGrafica = document.createElement('div');
    rowGrafica.className = 'col-sm-12 col-md-6 mb-4';


    let containerGrafica = document.createElement('div');
    containerGrafica.id = `containerGrafica${procesoId}`;
    rowGrafica.appendChild(containerGrafica);
    body.appendChild(rowGrafica);

    let valor = (response.cantidad_satisfactorio / response.cantidad_total * 100).toFixed(0);
    let color = obtenerColorLabel(valor);

    // console.log(color);

    Highcharts.chart(`containerGrafica${procesoId}`, {
        chart: {
            type: 'bar'
        },
        title: {
            text: `% CUMPLIMIENTO ${procesoEncu}`,
            align: 'center',
            style: {
                fontSize: `${fontSizeTitle}px` 
            }
        },
        xAxis: {
            categories: [response.nombre, 'META'],
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
            bar: {
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
            data:[
                {y: parseInt(valor), color: color}, 
                {y: 90, color: '#3874ff'}
            ]
            // data:[
            //     {y: valor, color: obtenerColorLabel(valor)}, 
            //     {y: 90, color: ''}
            // ]
        }]
    });

}

const generarTablasIndicador1 = async (idBaseEncuesta, procesoEncu, body) => {

    let datos = new FormData();
    datos.append('proceso', 'infoDatosIndicador1'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('procesoEncu', procesoEncu);
    datos.append('tipoEncuesta', 'VIH');

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    let procesoId = procesoEncu.replace(/\s/g, "-");

    let rowTables = document.createElement('div');
    rowTables.className = 'col-sm-12 col-md-6 mb-4';

    /*===========================
    TABLE CUMPLIMIENTO
    ============================*/
    let tableCumplimiento = document.createElement('table');
    tableCumplimiento.className = 'table table-striped mb-4';
    tableCumplimiento.id = `tableCumplimiento${procesoId}`;
    tableCumplimientoThead = document.createElement('thead');
    tableCumplimientoThead.className = 'theadTable'
    tableCumplimientoThead.innerHTML = `
        <tr>
            <th colspan="2">% CUMPLIMIENTO ${procesoEncu}</th>
        </tr>
        <tr>
            <th>META</th>
            <th>${response.nombre}</th>
        </tr>
    `;
    tableCumplimientoTbody = document.createElement('tbody');
    tableCumplimientoTbody.className = 'tbodyTable';
    tableCumplimientoTbody.innerHTML = `
        <tr>
            <td>90%</td>
            <td>${ (parseInt(response.cantidad_satisfactorio) / parseInt(response.cantidad_total) * 100).toFixed(0) }%</td>
        </tr>
    `;

    tableCumplimiento.appendChild(tableCumplimientoThead);
    tableCumplimiento.appendChild(tableCumplimientoTbody);

    /*===========================
    TABLE INFO BASE
    ============================*/
    let tableBase = document.createElement('table');
    tableBase.className = 'table table-striped mb-4';
    tableBase.id = `tableBase${procesoId}`;
    tableBaseThead = document.createElement('thead');
    tableBaseThead.className = 'theadTable'
    tableBaseThead.innerHTML = `
        <tr>
            <th>PERIODO A MEDIR</th>
            <th>${response.nombre}</th>
        </tr>
    `;
    tableBaseTbody = document.createElement('tbody');
    tableBaseTbody.className = 'tbodyTable';
    tableBaseTbody.innerHTML = `
        <tr>
            <td>NUMERADOR</td>
            <td>${parseInt(response.cantidad_satisfactorio)}</td>
        </tr>
        <tr>
            <td>DENOMINADOR</td>
            <td>${parseInt(response.cantidad_total)}</td>
        </tr>
        <tr>
            <td>RESULTADO</td>
            <td>${ (parseInt(response.cantidad_satisfactorio) / parseInt(response.cantidad_total) * 100).toFixed(0) }%</td>
        </tr>
    `;

    tableBase.appendChild(tableBaseThead);
    tableBase.appendChild(tableBaseTbody);


    rowTables.appendChild(tableCumplimiento);
    rowTables.appendChild(tableBase);

    body.appendChild(rowTables);


    await reiniciarTable(`tableCumplimiento${procesoId}`);
    await reiniciarTable(`tableBase${procesoId}`);


}

const generarReporteIndicador2 = async () => {

    const cardResultado = document.querySelector("#cardResultadoIndicador2");

    let formulario = document.getElementById("formReportIndicadores2");
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
                { proceso: 'DATOS DE IDENTIFICACION' },
                { proceso: 'MEDICINA GENERAL' },
                { proceso: 'INFECTOLOGIA' },
                { proceso: 'ENFERMERIA' },
                { proceso: 'PSICOLOGIA' },
                { proceso: 'NUTRICION' },
                { proceso: 'TRABAJO SOCIAL' },
                { proceso: 'ODONTOLOGIA' },
                { proceso: 'QUIMICO FARMACEUTICO' }
            ]

            for (const proceso of procesosIndicadorVih){

                await generarTablaIndicador2(idBaseEncuesta, proceso.proceso);
                
            }

            await reiniciarTable(`tablaIndicadores2`);

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarTablaIndicador2 = async (idBaseEncuesta, procesoEncu) => {

    let datos = new FormData();
    datos.append('proceso', 'infoDatosIndicador2'),
    datos.append('idBaseEncuesta', idBaseEncuesta);
    datos.append('procesoEncu', procesoEncu);
    datos.append('tipoEncuesta', 'VIH');

    const response = await $.ajax({
        url: 'ajax/encuestas/reportes.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    const tableTbody = document.querySelector('#tablaIndicadores2 .tbodyTable');

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
            datosMedicos.append('tipoEncuesta', 'VIH');
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

            /*==============================
            TABLA Y GRAFICA DE ESPECIALISTAS
            ==============================*/

            let datosEspecialista = new FormData();
            datosEspecialista.append('proceso', 'infoReportConsoMedicoEspecialista'),
            datosEspecialista.append('idBaseEncuesta', idBaseEncuesta);
            datosEspecialista.append('tipoEncuesta', 'VIH');
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
            'tipoEncuesta': 'VIH'
        },
        success:function(respuesta){
    
            $("#auditorEncuesta").html(respuesta);
    
        }
    
    })

}


const generarReporteConsolidadoProfesionalEspecialidad = async () => {

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

            const nombreAuditorTable = document.querySelector('.nombreAuditorTable');
            nombreAuditorTable.innerText = auditor;

            let tipoEncuesta = 'VIH';

            let datosReport = [

                { tipo: 'DILIGENCIAMIENTO', table: 'tablaDiligenciamiento', container: 'containerDiligenciamiento', title: `% DE CUMPLIMIENTO DILIGENCIAMIENTO DE HISTORIA CLINICA ${auditor}`, tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'REGISTRO-ANTECEDENTES', table: 'tablaRegistroAntecedentes', container: 'containerRegistroAntecedentes', title:'% DE CUMPLIMIENTO DE REGISTRO DE ANTECEDENTES', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'EVALUACION-CLINICA', table: 'tablaEvaluacionClinica', container: 'containerEvaluacionClinica', title:'% DE CUMPLIMIENTO DE EVALUACION CLINICA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'SEGUIMIENTO-VACUNAS', table: 'tablaSeguimientoVacunas', container: 'containerSeguimientoVacunas', title:'% DE CUMPLIMIENTO DE SEGUIMIENTO A VACUNAS', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-1', table: 'tablaParaclinicos1', container: 'containerParaclinicos1', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-2', table: 'tablaParaclinicos2', container: 'containerParaclinicos2', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-3', table: 'tablaParaclinicos3', container: 'containerParaclinicos3', title:'% DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS', dataResult:'porcentaje'},
                { tipo: 'PARACLINICOS-GENERAL', table: 'tablaParaclinicosGeneral', container: 'containerParaclinicosGeneral', title:'PROMEDIO % DE CUMPLIMIENTO DE PARACLINICOS ORDENADOS Y ANALIZADOS', tableType:'PARACLINICOS-GENERAL', dataResult:'porcentaje'},
                { tipo: 'CITOLOGIA-ANAL', table: 'tablaCitologiaAnal', container: 'containerCitologiaAnal', title:'CUMPLIMIENTO DE CITOLOGIA ANAL', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'CITOLOGIA-VAGINAL', table: 'tablaCitologiaVaginal', container: 'containerCitologiaVaginal', title:'CUMPLIMIENTO DE CITOLOGIA VAGINAL', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'ANTIGENO-PROSTATICO', table: 'tablaAntigenoProstatico', container: 'containerAntigenoProstatico', title:'CUMPLIMIENTO DE ANTIGENO PROSTATICO', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'MAMOGRAFIA', table: 'tablaMamografia', container: 'containerMamografia', title:'CUMPLIMIENTO DE MAMOGRAFIA', tableType:'NORMAL', dataResult:'cantidad'},
                { tipo: 'RECOMENDACIONES-COHERENCIA', table: 'tablaRecomendacionCoherencia', container: 'containerRecomendacionCoherencia', title:'% DE CUMPLIMIENTO RECOMENDACIONES Y COHERENCIA', tableType:'NORMAL', dataResult:'porcentaje'},
                { tipo: 'ATRIBUTOS-CALIDAD', table: 'tablaAtributosCalidad', container: 'containerAtributosCalidad', title:'% DE CUMPLIMIENTO ATRIBUTOS DE CALIDAD', tableType:'NORMAL', dataResult:'porcentaje'}

            ]

            for (const info of datosReport) {
                
                await generarGraficaConsolidadoxProfesional(idBaseEncuesta, tipoEncuesta, especialidad, info, auditor);
                await generarTablasConsolidadoxProfesional(idBaseEncuesta, tipoEncuesta, especialidad, info, auditor);

            }



        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarGraficaConsolidadoxProfesional = async (idBaseEncuesta, tipoEncuesta, especialidad, info, auditor) => {

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
                    // max: 100,
                    title: {
                        text: 'CANTIDAD'
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

const generarTablasConsolidadoxProfesional = async (idBaseEncuesta, tipoEncuesta, especialidad, info, auditor) => {

    // console.log('Ejecutando');
    // console.log(auditor);

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

const generarReportConsolidadoCalificacionSegmentoVIH = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteConsolidadoCaliSegmentoVIH");

    let formulario = document.getElementById("formReporteConsilidadoCaliSegmentoVIH");
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
            datosMedicos.append('tipoEncuesta', 'VIH');

            const respuesta = await $.ajax({
                url: 'ajax/encuestas/reportes.ajax.php',
                type: 'POST',
                data: datosMedicos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            //console.log({respuesta});

            let idTable = "tablaConsolidadoCaliSegmentoVIH";
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

}

const generarReporteGeneralVih = async () => {

    let formulario = document.getElementById("formReportGeneralVih");
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

            const datos = new FormData();
            datos.append('proceso', 'generarReporteGeneralVih');
            datos.append('idBaseEncuesta', idBaseEncuesta);
            datos.append('idEncuProceso', idEncuProceso);
            datos.append('tipoEncuesta', 'VIH');
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


tablaSolicitudesReportesConsolidados = $('#tablaSolicitudesReportesConsolidados').DataTable({

    columns: [
        { name: '#', data: 'id_reporte'},
        { name: 'PROCESO', data: 'proceso_encuesta'},
        { name: 'TIPO ENCUESTA', data: 'tipo_encuesta'},
        { name: 'ARCHIVO', render: function(data, type, row){

            if(row.estado == 'FINALIZADO'){

                return `<a class="badge badge-phoenix fs--2 badge-phoenix-success p-2" href="../../../archivos_nexuslink/encuestas/archivos_reportes_vih/${row.nombre_archivo}"><i class="far fa-file-excel"></i> ${row.nombre_archivo}</a>`;

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
            'tipoEncuesta': 'VIH'
        }
    }

})
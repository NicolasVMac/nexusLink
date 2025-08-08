let tablaReportesAgendamiendo;
let tablaRealizadas, tablaEfectivasFallidas, tablaProgramadas, tablaReporteBaseGeneral, tablaReporteBaseProfesional;
let meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

/*============================
LISTA PROFESIONALES
============================*/
$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaProfesionalesAgenda'
    },
    success:function(respuesta){

        $("#profesionalAgendamiento").html(respuesta);

    }

})

/*============================
LISTA COHORTE O PROGRAMAS AGENDAMIENTO
============================*/
$.ajax({

    type: "POST",
    url: "ajax/di/reportes.ajax.php",
    data: {
        'proceso': 'listaCohorteProgramas'
    },
    success:function(respuesta){

        $("#cohortePrograma").html(respuesta);

    }

})

$.ajax({

    type: "POST",
    url: "ajax/di/reportes.ajax.php",
    data: {
        'proceso': 'listaCohorteProgramasNotTodos'
    },
    success:function(respuesta){

        $("#cohorteProgramaDetalle").html(respuesta);

    }

})

/*============================
LISTA BASES CARGADAS
============================*/
$.ajax({

    type: "POST",
    url: "ajax/di/reportes.ajax.php",
    data: {
        'proceso': 'listaBasesCargadas'
    },
    success:function(respuesta){

        $("#baseCargadas").html(respuesta);

    }

})


const generarReporteLlamadas = () => {

    const cardResultado = document.querySelector("#cardResultadoReporteLlamadas");

    let formulario = document.getElementById("formReporteLlamadas");
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

            let cohortePrograma = document.getElementById("cohortePrograma").value;
            let fechaInicio = document.getElementById("fechaInicio").value;
            let fechaFIn = document.getElementById("fechaFin").value;

            $.ajax({

                type: "POST",
                url: "ajax/di/reportes.ajax.php",
                data: {
                    'proceso': 'reporteLlamadasRealizadas',
                    'fechaInicio': fechaInicio,
                    'fechaFin': fechaFIn
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    Highcharts.chart('containerGrafRealizadas', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Llamadas Realizadas',
                        },
                        xAxis: {
                            categories: ['FINALIZADAS', 'NO FINALIZADAS']
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Cantidad'
                            }
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true
                                }
                            }
                        },
                        series: [
                            {
                                name: 'FINALIZADAS',
                                data: respuesta.seriesFinalizadas
                            },
                            {
                                name: 'NO FINALIZADAS',
                                data: respuesta.seriesNoFinalizadas
                            }
                        ]
                    });

                }
                
            })

            if ($.fn.DataTable.isDataTable('#tablaRealizadas')) {
                $('#tablaRealizadas').DataTable().destroy();
            }

            tablaRealizadas = $("#tablaRealizadas").DataTable({

                columns: [
                    { name: 'ID', data: 'id_bolsa_paciente' },
                    { name: 'IPS', data: 'ips' },
                    { name: 'NOMBRE PACIENTE', data: 'nombre_completo' },
                    { name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                        return row.tipo_doc + ' - ' + row.numero_documento;
                    } },
                    { name: 'COHORTE O PROGRAMA', data: 'cohorte_programa' },
                    { name: 'ESTADO', render: function(data, type, row){

                        let badgedColor = row.estado == 'CREADA' ? 'badge-phoenix-warning' : row.estado == 'PROCESO' ? 'badge-phoenix-primary' : row.estado == 'FALLIDA' ? 'badge-phoenix-danger' : 'badge-phoenix-success';
            
                        return `<span class="badge badge-phoenix ${badgedColor}">${row.estado}</span>`;
            
            
                    } 
                    },
                    { name: 'USUARIO', data: 'asesor' },
                ],
                ajax: {
                    url: 'ajax/di/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaTablaLlamadas',
                        'procesoLlamada': 'REALIZADAS',
                        'cohortePrograma': cohortePrograma,
                        'fechaInicio': fechaInicio,
                        'fechaFin': fechaFIn

                    }
                },
                scrollY: "300px",
                scrollCollapse: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ]
            
            })



            $.ajax({

                type: "POST",
                url: "ajax/di/reportes.ajax.php",
                data: {
                    'proceso': 'reporteLlamadasEfectivasFallidas',
                    'cohortePrograma': cohortePrograma,
                    'fechaInicio': fechaInicio,
                    'fechaFin': fechaFIn
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    Highcharts.chart('containerGrafEfecticasFallidas', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Llamadas Efectivas - Fallidas',
                        },
                        xAxis: {
                            categories: respuesta.categories
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Cantidad'
                            },
                            stackLabels: {
                                enabled: true
                            }
                        },
                        tooltip: {
                            headerFormat: '<b>{point.x}</b><br/>',
                            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal',
                                dataLabels: {
                                    enabled: true
                                }
                            }
                        },
                        series: [{
                            name: 'FINALIZADAS',
                            data: respuesta.seriesFinalizada
                        }, {
                            name: 'FALLIDAS',
                            data: respuesta.seriesFallida
                        }]
                    })

                }

            })

            if ($.fn.DataTable.isDataTable('#tablaEfectivasFallidas')) {
                $('#tablaEfectivasFallidas').DataTable().destroy();
            }

            tablaEfectivasFallidas = $("#tablaEfectivasFallidas").DataTable({

                columns: [
                    { name: 'ID', data: 'id_bolsa_paciente' },
                    { name: 'IPS', data: 'ips' },
                    { name: 'NOMBRE PACIENTE', data: 'nombre_completo' },
                    { name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                        return row.tipo_doc + ' - ' + row.numero_documento;
                    } },
                    { name: 'COHORTE O PROGRAMA', data: 'cohorte_programa' },
                    { name: 'ESTADO', render: function(data, type, row){

                        let badgedColor = row.estado == 'CREADA' ? 'badge-phoenix-warning' : row.estado == 'PROCESO' ? 'badge-phoenix-primary' : row.estado == 'FALLIDA' ? 'badge-phoenix-danger' : 'badge-phoenix-success';
            
                        return `<span class="badge badge-phoenix ${badgedColor}">${row.estado}</span>`;
            
            
                    } 
                    },
                    { name: 'USUARIO', data: 'asesor' },
                ],
                ajax: {
                    url: 'ajax/di/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaTablaLlamadas',
                        'procesoLlamada': 'EFECTIVASFALLIDAS',
                        'cohortePrograma': cohortePrograma,
                        'fechaInicio': fechaInicio,
                        'fechaFin': fechaFIn

                    }
                },
                scrollY: "300px",
                scrollCollapse: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ]
            
            })

            $.ajax({

                type: "POST",
                url: "ajax/di/reportes.ajax.php",
                data: {
                    'proceso': 'reporteLlamadasProgramadas',
                    'cohortePrograma': cohortePrograma,
                    'fechaInicio': fechaInicio,
                    'fechaFin': fechaFIn
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    Highcharts.chart('containerGrafProgramadas', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Llamadas Programadas',
                        },
                        xAxis: {
                            categories: respuesta.categories
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Cantidad'
                            }
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true
                                }
                            }
                        },
                        series: [
                            {
                                name: 'CREADA',
                                data: respuesta.seriesCreadas
                            },
                            {
                                name: 'PROCESO',
                                data: respuesta.seriesProcesos
                            }
                        ]
                    });

                }

            })

            if ($.fn.DataTable.isDataTable('#tablaProgramadas')) {
                $('#tablaProgramadas').DataTable().destroy();
            }

            
            tablaProgramadas = $("#tablaProgramadas").DataTable({

                columns: [
                    { name: 'ID', data: 'id_bolsa_paciente' },
                    { name: 'IPS', data: 'ips' },
                    { name: 'NOMBRE PACIENTE', data: 'nombre_completo' },
                    { name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                        return row.tipo_doc + ' - ' + row.numero_documento;
                    } },
                    { name: 'COHORTE O PROGRAMA', data: 'cohorte_programa' },
                    { name: 'ESTADO', render: function(data, type, row){

                        let badgedColor = row.estado == 'CREADA' ? 'badge-phoenix-warning' : row.estado == 'PROCESO' ? 'badge-phoenix-primary' : row.estado == 'FALLIDA' ? 'badge-phoenix-danger' : 'badge-phoenix-success';
            
                        return `<span class="badge badge-phoenix ${badgedColor}">${row.estado}</span>`;
            
            
                    } 
                    },
                    { name: 'USUARIO', data: 'asesor' },
                ],
                ajax: {
                    url: 'ajax/di/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaTablaLlamadas',
                        'procesoLlamada': 'PROGRAMADAS',
                        'cohortePrograma': cohortePrograma,
                        'fechaInicio': fechaInicio,
                        'fechaFin': fechaFIn

                    }
                },
                scrollY: "300px",
                scrollCollapse: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ]
            
            })


        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarReporteBases = () => {

    const cardResultado = document.querySelector("#cardResultadoReporteBases");

    let formulario = document.getElementById("formReporteBases");
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

            let idBase = document.getElementById("baseCargadas").value;

            if ($.fn.DataTable.isDataTable('#tablaReporteBaseGeneral')) {
                $('#tablaReporteBaseGeneral').DataTable().destroy();
            }

            tablaReporteBaseGeneral = $("#tablaReporteBaseGeneral").DataTable({

                columns: [
                    { name: 'PORCENTAJE GESTION', render: (data, type, row) => {
                        return row.PORCENTAJE_GESTION+'%';
                    }},
                    { name: 'ASIGNADAS_MEDICOS', data: 'ASIGNADAS_MEDICOS' },
                    { name: 'NOMBRE ASIGNADAS_JEFES_ENFERMERIAS', data: 'ASIGNADAS_JEFES_ENFERMERIAS' },
                    { name: 'EFECTIVAS MEDICOS - FALLIDAS MEDICOS', render: function(data, type, row){
                        return row.EFECTIVAS_MEDICOS + ' - ' + row.FALLIDAS_MEDICOS;
                    }},
                    { name: 'EFETIVAS JEFES ENFERMERIA - FALLIDAS JEFES ENFERMERIA', render: function(data, type, row){
                        return row.EFECTIVAS_JEFES_ENFERMERIAS + ' - ' + row.FALLIDAS_JEFES_ENFERMERIAS;
                    }},
                    { name: 'PROGRAMADAS', data: 'PROGRAMADAS' },
                ],
                ajax: {
                    url: 'ajax/di/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaTablaReporteBaseGeneral',
                        'idBase': idBase
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ]
            
            });

            if ($.fn.DataTable.isDataTable('#tablaReporteBaseProfesional')) {
                $('#tablaReporteBaseProfesional').DataTable().destroy();
            }

            tablaReporteBaseProfesional = $("#tablaReporteBaseProfesional").DataTable({

                columns: [
                    { name: 'CARGO', data: 'cargo' },
                    { name: 'NOMBRE PROFESIONAL', data: 'nombre_profesional' },
                    { name: 'ASIGNADAS_MEDICOS', data: 'ASIGNADAS_MEDICOS' },
                    { name: 'NOMBRE ASIGNADAS_JEFES_ENFERMERIAS', data: 'ASIGNADAS_JEFES_ENFERMERIAS' },
                    { name: 'EFECTIVAS MEDICOS - FALLIDAS MEDICOS', render: function(data, type, row){
                        return row.EFECTIVAS_MEDICOS + ' - ' + row.FALLIDAS_MEDICOS;
                    }},
                    { name: 'EFETIVAS JEFES ENFERMERIA - FALLIDAS JEFES ENFERMERIA', render: function(data, type, row){
                        return row.EFECTIVAS_JEFES_ENFERMERIAS + ' - ' + row.FALLIDAS_JEFES_ENFERMERIAS;
                    }},
                    { name: 'PROGRAMADAS', data: 'PROGRAMADAS' },
                ],
                ajax: {
                    url: 'ajax/di/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaTablaReporteBaseDetallado',
                        'idBase': idBase
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ]
            
            });


        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}


const generarReporteRegimenBase = () => {

    const cardResultado = document.querySelector("#cardResultadoReporteRegimenBase");

    let formulario = document.getElementById("formReporteRegimenBase");
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

            let idBase = document.getElementById("baseCargadas").value;

            // console.log(idBase);

            if ($.fn.DataTable.isDataTable('#tablaReporteRegimen')) {
                $('#tablaReporteRegimen').DataTable().destroy();
            }

            tablaReporteRegimen = $("#tablaReporteRegimen").DataTable({

                columns: [
                    { name: 'REGIMEN', data: 'regimen' },
                    { name: 'CANTIDAD', data: 'cantidad' },
                    { name: 'OPCIONES', render: function(data, type, row){
                        return `<a class="btn btn-success btn-sm" onclick="generarTablaRegimenDetalle(${idBase},'${row.regimen}')" title="Ver Informacion"><i class="far fa-eye"></i> Generar</a>`;
                    }},
                ],
                ajax: {
                    url: 'ajax/di/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaTablaRegimenBase',
                        'idBase': idBase
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ]
            
            });



        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "Error!");

        }

    }

}

const generarTablaRegimenDetalle = (idBase, regimen) => {

    if(idBase && regimen){

        $("#contenedorRegimenSeleccionado").html(`<span class="badge badge-phoenix badge-phoenix-success"><h5>${regimen}</h5></span>`);

        if ($.fn.DataTable.isDataTable('#tablaReporteRegimenDetalle')) {
            $('#tablaReporteRegimenDetalle').DataTable().destroy();
        }

        tablaReporteRegimenDetalle = $("#tablaReporteRegimenDetalle").DataTable({

            columns: [
                { name: 'ID', data: 'id_bolsa_paciente' },
                { name: 'IPS', data: 'ips' },
                { name: 'NOMBRE PACIENTE', data: 'nombre_completo' },
                { name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                    return row.tipo_doc + ' - ' + row.numero_documento;
                }},
                { name: 'REGIMEN', data: 'regimen' },
                { name: 'COHORTE O PROGRAMA', data: 'cohorte_programa' },
            ],
            ajax: {
                url: 'ajax/di/reportes.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'listaTablaRegimenBaseDetalle',
                    'idBase': idBase,
                    'regimen': regimen
                }
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: 'Descargar Excel',
                    className: 'btn btn-phoenix-success',
                },
            ]
        
        });

    }else{

        toastr.warning("No se puede generar la Tabla Regimen Detalle.", "Error!");

    }

}

const generarReporteProductividadProfesional = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteProductividadProfesional");

    let formulario = document.getElementById("formReporteProductividad");
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

            let idProfesional = document.getElementById("profesionalAgendamiento").value;
            let fechaInicio = document.getElementById("fechaInicio").value;
            let fechaFin = document.getElementById("fechaFin").value;

            // console.log(idBase);

            // if ($.fn.DataTable.isDataTable('#tablaResultProductividadProfesional')) {
            //     $('#tablaResultProductividadProfesional').DataTable().destroy();
            // }


            $("#tablaResultProductividadProfesional").DataTable({

                columns: [
                    { name: '#', data: 'id_cita' },
                    { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
                    { name: 'DOCUMENTO PACIENTE', data: 'documento_paciente'},
                    { name: 'SERVICIO CITA', data: 'servicio_cita' },
                    { name: 'MOTIVO CITA', data: 'motivo_cita' },
                    { name: 'FECHA CITA', render: function (data, type, row) {
                        let badgedColor = row.franja_cita == 'AM' ? 'badge-phoenix-warning' : 'badge-phoenix-primary';
                        return `<span class="badge badge-phoenix ${badgedColor}">${row.fecha_cita} - ${row.franja_cita}</span>`;
                    }},
                    { name: 'LOCALIDAD CITA', data: 'localidad_cita' },
                    { name: 'COHORTE PROGRAMA', data: 'cohorte_programa' },
                    { name: 'ESTADO', data: 'estado', render: function (data, type, row){
                        if(row.estado === 'TERMINADA'){
                            return `<span class="badge badge-phoenix badge-phoenix-success">${row.estado}</span>`;
                        }else if(row.estado === 'FALLIDA'){
                            return `<span class="badge badge-phoenix badge-phoenix-danger">${row.estado}</span>`;
                        }
                    }},
                    { name: 'PROFESIONAL', data: 'nombre_profesional' },
                    { name: 'FECHA INI', data: 'fecha_ini' },
                    { name: 'FECHA FIN', data: 'fecha_fin' },
                ],
                ajax: {
                    url: 'ajax/di/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaProductividadProfesional',
                        'idProfesional': idProfesional,
                        'fechaInicio': fechaInicio,
                        'fechaFin': fechaFin
                    }
                },
                destroy: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ]
            
            });

            let datosGrafica = new FormData();
            datosGrafica.append('proceso','listaProductividadProfesionalGrafica');
            datosGrafica.append('idProfesional', idProfesional);
            datosGrafica.append('fechaInicio', fechaInicio);
            datosGrafica.append('fechaFin', fechaFin);

            const resultDatos = await $.ajax({
                url: 'ajax/di/reportes.ajax.php',
                type: 'POST',
                data: datosGrafica,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            let arrayCategories = resultDatos.map(dato => {
                return `${meses[Number(dato.mes)-1]} - ${dato.anio}`;
            })

            let arrayData = resultDatos.map(dato => Number(dato.cantidad));

            Highcharts.chart('containerGraficaProductividadProfesional', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Productividad'
                },
                xAxis: {
                    categories: arrayCategories,
                },
                yAxis: {
                    min: 0,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}'
                        }
                    }
                },
                series: [
                    {
                        name: 'Cantidad',
                        data: arrayData
                    }
                ]
            });
            


        }

    }

}

const generarReporteEfectFalliRepro = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteEfecFalliRepro");

    let formulario = document.getElementById("formReporteEfectFalliRepro");
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

            let idProfesional = document.getElementById("profesionalAgendamiento").value;
            let fechaInicio = document.getElementById("fechaInicio").value;
            let fechaFin = document.getElementById("fechaFin").value;


            $("#tablaResultEfecFalliRepro").DataTable({

                columns: [
                    { name: '#', data: 'id_cita' },
                    { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
                    { name: 'DOCUMENTO PACIENTE', data: 'documento_paciente'},
                    { name: 'SERVICIO CITA', data: 'servicio_cita' },
                    { name: 'MOTIVO CITA', data: 'motivo_cita' },
                    { name: 'FECHA CITA', render: function (data, type, row) {
                        let badgedColor = row.franja_cita == 'AM' ? 'badge-phoenix-warning' : 'badge-phoenix-primary';
                        return `<span class="badge badge-phoenix ${badgedColor}">${row.fecha_cita} - ${row.franja_cita}</span>`;
                    }},
                    { name: 'LOCALIDAD CITA', data: 'localidad_cita' },
                    { name: 'COHORTE PROGRAMA', data: 'cohorte_programa' },
                    { name: 'ESTADO', data: 'estado', render: function (data, type, row){
                        let badgedColor = row.estado == 'TERMINADA' ? 'badge-phoenix-success' : 'badge-phoenix-danger';
                        if(row.estado_final === 'TERMINADA'){
                            return `<span class="badge badge-phoenix badge-phoenix-success">${row.estado}</span>`;
                        }else if(row.estado === 'FALLIDA'){
                            return `<span class="badge badge-phoenix badge-phoenix-danger">${row.estado}</span>`;
                        }else{
                            return `<span class="badge badge-phoenix ${badgedColor}">${row.estado}</span> <span class="badge badge-phoenix badge-phoenix-primary">${row.estado_final}</span>`;
                        }
                    }},
                    { name: 'PROFESIONAL', data: 'nombre_profesional' },
                    { name: 'FECHA INI', data: 'fecha_ini' },
                    { name: 'FECHA FIN', data: 'fecha_fin' },
                ],
                ajax: {
                    url: 'ajax/di/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaEfectiFalliReproGraficaTable',
                        'idProfesional': idProfesional,
                        'fechaInicio': fechaInicio,
                        'fechaFin': fechaFin
                    }
                },
                destroy: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ]
            
            });


            let datosGrafica = new FormData();
            datosGrafica.append('proceso','listaEfectiFalliReproGrafica');
            datosGrafica.append('idProfesional', idProfesional);
            datosGrafica.append('fechaInicio', fechaInicio);
            datosGrafica.append('fechaFin', fechaFin);

            const resultDatos = await $.ajax({
                url: 'ajax/di/reportes.ajax.php',
                type: 'POST',
                data: datosGrafica,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            let arrayCategories = resultDatos.map(dato => {
                return `${meses[Number(dato.mes)-1]} - ${dato.anio}`;
            })

            let arrayTerminados = resultDatos.map(dato => Number(dato.count_terminados));
            let arrayFallidos = resultDatos.map(dato => Number(dato.count_fallidos));
            let arrayReprogramados = resultDatos.map(dato => Number(dato.count_reagendadas));


            Highcharts.chart('containerGraficaEfecFalliRepro', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'ATENCIONES EFECTIVAS, FALLIDAS Y REPROGRAMADAS',
                    align: 'center'
                },
                xAxis: {
                    categories: arrayCategories
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'CANTIDAD'
                    },
                    stackLabels: {
                        enabled: true
                    }
                },
                legend: {
                    align: 'left',
                    x: 70,
                    verticalAlign: 'top',
                    y: 70,
                    floating: true,
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{category}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Cantidad: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [{
                    name: 'TERMINADAS',
                    color: '#25b003',
                    data: arrayTerminados.map(item => ({
                        y: item,
                        color: '#25b003'
                    }))
                },
                {
                    name: 'FALLIDAS',
                    color: '#ed2000',
                    data: arrayFallidos.map(item => ({
                        y: item,
                        color: '#ed2000'
                    }))
                }, 
                {
                    name: 'REPROGRAMADAS',
                    color: '#0097eb',
                    data: arrayReprogramados.map(item => ({
                        y: item,
                        color: '#0097eb'
                    }))
                }]
            });

        }

    }

}

const generarReporteAtencionCohorte = async () => {

    const cardResultado = document.querySelector("#cardResultadoReporteAtenciCohorte");

    let formulario = document.getElementById("formReporteAtenCohorte");
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

            let idProfesional = document.getElementById("profesionalAgendamiento").value;
            let fechaInicio = document.getElementById("fechaInicio").value;
            let fechaFin = document.getElementById("fechaFin").value;

            $("#tablaResultAtencionCohorte").DataTable({

                columns: [
                    { name: '#', data: 'id_cita' },
                    { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
                    { name: 'DOCUMENTO PACIENTE', data: 'documento_paciente'},
                    { name: 'SERVICIO CITA', data: 'servicio_cita' },
                    { name: 'MOTIVO CITA', data: 'motivo_cita' },
                    { name: 'FECHA CITA', render: function (data, type, row) {
                        let badgedColor = row.franja_cita == 'AM' ? 'badge-phoenix-warning' : 'badge-phoenix-primary';
                        return `<span class="badge badge-phoenix ${badgedColor}">${row.fecha_cita} - ${row.franja_cita}</span>`;
                    }},
                    { name: 'LOCALIDAD CITA', data: 'localidad_cita' },
                    { name: 'COHORTE PROGRAMA', data: 'cohorte_programa' },
                    { name: 'ESTADO', data: 'estado', render: function (data, type, row){
                        if(row.estado === 'TERMINADA'){
                            return `<span class="badge badge-phoenix badge-phoenix-success">${row.estado}</span>`;
                        }else if(row.estado === 'FALLIDA'){
                            return `<span class="badge badge-phoenix badge-phoenix-danger">${row.estado}</span>`;
                        }
                    }},
                    { name: 'PROFESIONAL', data: 'nombre_profesional' },
                    { name: 'FECHA INI', data: 'fecha_ini' },
                    { name: 'FECHA FIN', data: 'fecha_fin' },
                ],
                ajax: {
                    url: 'ajax/di/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaAtencionCohorteGraficaTable',
                        'idProfesional': idProfesional,
                        'fechaInicio': fechaInicio,
                        'fechaFin': fechaFin
                    }
                },
                destroy: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ]
            
            });

            let datosGrafica = new FormData();
            datosGrafica.append('proceso','listaAtencionCohorteGrafica');
            datosGrafica.append('idProfesional', idProfesional);
            datosGrafica.append('fechaInicio', fechaInicio);
            datosGrafica.append('fechaFin', fechaFin);

            const resultDatos = await $.ajax({
                url: 'ajax/di/reportes.ajax.php',
                type: 'POST',
                data: datosGrafica,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json"
            });

            let arrayCategories = resultDatos.map(dato => {
                return `${meses[Number(dato.mes)-1]} - ${dato.anio}`;
            })

            Highcharts.chart('containerGraficaAtencionCohorte', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Atenciones Cohorte'
                },
                xAxis: {
                    categories: arrayCategories
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'CANTIDAD'
                    },
                    stackLabels: {
                        enabled: true
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>' +
                        ': <b>{point.y}</b><br/>',
                    shared: true
                },
                plotOptions: {
                    column: {
                        stacking: 'CANTIDAD',
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [{
                    name: 'MATERNO PERINATAL Y SSR',
                    data: resultDatos.map(dato => Number(dato.cant_materno_perinatal))
                }, {
                    name: 'SALUD INFANTIL',
                    data: resultDatos.map(dato => Number(dato.cant_salud_infantil))
                }, {
                    name: 'VACUNACION',
                    data: resultDatos.map(dato => Number(dato.cant_vacunacion))
                }, {
                    name: 'CRONICOS',
                    data: resultDatos.map(dato => Number(dato.cant_cronicos))
                }, {
                    name: 'PHD',
                    data: resultDatos.map(dato => Number(dato.cant_phd))
                }, {
                    name: 'ANTICOAGULADOS',
                    data: resultDatos.map(dato => Number(dato.cant_anticoagulados))
                }, {
                    name: 'NUTRICION',
                    data: resultDatos.map(dato => Number(dato.cant_nutricion))
                }, {
                    name: 'TRABAJO SOCIAL',
                    data: resultDatos.map(dato => Number(dato.cant_trabajo_social))
                }, {
                    name: 'PSICOLOGIA',
                    data: resultDatos.map(dato => Number(dato.cant_psicologia))
                }, {
                    name: 'RIESGO CARDIO VASCULAR',
                    data: resultDatos.map(dato => Number(dato.cant_riesgo_cardiovascular))
                }]
            });
            


        }

    }

}

const generarReporteDetalleDi = () => {

    const cardResultado = document.querySelector("#cardResultadoReporteDetalleDi");

    let formulario = document.getElementById("formReporteDetalleDi");
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

            let cohorte = document.getElementById("cohorteProgramaDetalle").value;
            let fechaInicio = document.getElementById("fechaInicio").value;
            let fechaFin = document.getElementById("fechaFin").value;


            $.ajax({
                url: 'ajax/di/reportes.ajax.php',
                type: 'POST',
                data: {
                    proceso: 'listaDetalleDi',
                    cohorte: cohorte,
                    fechaInicio: fechaInicio,
                    fechaFin: fechaFin
                },
                dataType: 'json',
                success: function (response) {
                    // Verificar si la tabla ya existe
                    if ($.fn.DataTable.isDataTable('#tablaDetalleDi')) {
                        // Destruir la tabla existente
                        $('#tablaDetalleDi').DataTable().clear().destroy();
                    }

                    // Limpiar el contenido del <thead> y <tbody>
                    $('#tablaDetalleDi thead').empty();
                    $('#tablaDetalleDi tbody').empty();
            
                    if (response.data && response.data.length > 0) {
                        // Generar las columnas dinámicamente a partir de los datos
                        const columns = Object.keys(response.data[0]).map(key => ({
                            title: key.toUpperCase(),
                            data: key
                        }));
            
                        // Inicializar la tabla con los nuevos datos y columnas
                        $('#tablaDetalleDi').DataTable({
                            data: response.data,
                            columns: columns,
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    text: 'Descargar Excel',
                                    className: 'btn btn-phoenix-success',
                                },
                            ],
                        });
                    } else {
                        // Si no hay datos, mostrar una tabla vacía o un mensaje
                        // $('#tablaDetalleDi').html('<tr><td colspan="100%">No se encontraron datos.</td></tr>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error en la solicitud:', error);
                }
            });
            
            

        }

    }

}


const mostrarReporte = (rutaReporte) => {

    window.location = `index.php?ruta=di/reporteview&rutaReporte=${btoa(rutaReporte)}`;

}


tablaReportesAgendamiendo = $("#tablaReportesAgendamiendo").DataTable({

    columns: [
        { name: 'ID', data: 'id_reporte' },
        { name: 'TITULO REPORTE', data: 'titulo' },
        { name: 'DESCRIPCION REPORTE', data: 'descripcion' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<a class="btn btn-success btn-sm" onclick="mostrarReporte('${row.ruta}')" title="Generar Reporte"><i class="far fa-caret-square-right"></i> Generar</a>`;
            }
        }
    ],
    ajax: {
        url: 'ajax/di/reportes.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaReportesAgendamiento',
        }
    }

})
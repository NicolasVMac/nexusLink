let tablaReportesPQRSF;


$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaEpsPqr'
    },
}).done(function (eps) {
    $("#epsPqrsf").html(eps)
    $("#epsMotivoPqrsf").html(eps)
    $("#epsPqrsfOportunidad").html(eps)
})


$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: {
        'lista': 'listaSedesPqr'
    },
}).done(function (sedes) {
    $("#sedeEpsPqrsf").html(sedes)
    // $("#epsMotivoPqrsf").html(eps)
    // $("#epsPqrsfOportunidad").html(eps)
})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaClasificacionesAtributosPqr'
    },
    success:function(respuesta){

        $("#clasiAtributoPqrsf").html(respuesta);

    }

})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaEntesPqr'
    },
    success:function(respuesta){

        $("#EnteControlPqrsf").html(respuesta);

    }

})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaSedesPqrReportes'
    },
    success:function(respuesta){

        $("#sedePqrsf1").html(respuesta);
        $("#sedePqrsf2").html(respuesta);
        $("#sedePqrsf3").html(respuesta);
        $("#sedePqrsf4").html(respuesta);
        $("#sedePqrsf5").html(respuesta);
        $("#sedePqrsf6").html(respuesta);
        $("#sedePqrsf7").html(respuesta);

    }

})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaSedesPqrReportesOptionTodos'
    },
    success:function(respuesta){

        $("#sedePqrsf").html(respuesta);

    }

})

const mostrarReporte = (rutaReporte) => {

    window.location = `index.php?ruta=pqr/reporteview&rutaReporte=${btoa(rutaReporte)}`;

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
        pageLength: 15
    });

}

const destroyIsDataTable = (idTable) => {

    if ($.fn.DataTable.isDataTable(`#${idTable}`)) {
        $(`#${idTable}`).DataTable().destroy();
    }

}

tablaReportesPQRSF = $('#tablaReportesPQRSF').DataTable({

    columns: [
        { name: '#', data: 'id_pqrsf_reporte' },
        { name: 'NOMBRE REPORTE', data: 'nombre_reporte' },
        { name: 'DESCRIPCION', data: 'descripcion_reporte' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-success btn-sm" onclick="mostrarReporte('${row.ruta_reporte}')" title="Ver Reporte"><i class="fas fa-chart-area"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pqr/reportes.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaReportesPqrsf',
        }
    }

})

const generarReporteEstadistica1 = async () => {

    const cardResultado = document.querySelector("#cardResulRepEstadistica1");

    let formulario = document.getElementById("formRepEstadistica1");
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

            let fechaAnio = document.querySelector('#fechaAnio').value;
            let sede = document.querySelector('#sedePqrsf').value;

            let tablaTipoPqrsf = $('#tablaTipoPqrsf').DataTable({

                columns: [
                    { name: 'TIPO PQRSF', data: 'tipo_pqr' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'TOTAL', render: function (data, type, row) {
                        
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportTipoPqrsf',
                        'fechaAnio': fechaAnio,
                        'sede': sede
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            tipo_pqr: 'TOTAL',
                            ENERO: 0,
                            FEBRERO: 0,
                            MARZO: 0,
                            ABRIL: 0,
                            MAYO: 0,
                            JUNIO: 0,
                            JULIO: 0,
                            AGOSTO: 0,
                            SEPTIEMBRE: 0,
                            OCTUBRE: 0,
                            NOVIEMBRE: 0,
                            DICIEMBRE: 0
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            
            })

            let tablaMotivoPQRSF = $('#tablaMotivoPQRSF').DataTable({
                
                columns: [
                    { name: 'MOTIVO PQRSF', data: 'motivo_pqr' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.ENERO) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.FEBRERO) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.MARZO) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.ABRIL) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.MAYO) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.JUNIO) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.JULIO) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.AGOSTO) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.SEPTIEMBRE) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.OCTUBRE) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.NOVIEMBRE) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'RECURRENCIA', render: function(data, type, row){
                        if(Number(row.DICIEMBRE) > 5){
                            return 'RECURRENTE';
                        }else{
                            return 'NO RECURRENTE';
                        }
                    }},
                    { name: 'TOTAL', render: function (data, type, row){
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportMotivoPqrsf',
                        'fechaAnio': fechaAnio,
                        'sede': sede
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            motivo_pqr: 'TOTAL',
                            ENERO: 0,
                            RECURRENTE: '',
                            FEBRERO: 0,
                            RECURRENTE: '',
                            MARZO: 0,
                            RECURRENTE: '',
                            ABRIL: 0,
                            RECURRENTE: '',
                            MAYO: 0,
                            RECURRENTE: '',
                            JUNIO: 0,
                            RECURRENTE: '',
                            JULIO: 0,
                            RECURRENTE: '',
                            AGOSTO: 0,
                            RECURRENTE: '',
                            SEPTIEMBRE: 0,
                            RECURRENTE: '',
                            OCTUBRE: 0,
                            RECURRENTE: '',
                            NOVIEMBRE: 0,
                            RECURRENTE: '',
                            DICIEMBRE: 0,
                            RECURRENTE: '',
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            })

            let tablaClaAtriPQRSF = $('#tablaClaAtriPQRSF').DataTable({

                columns: [
                    { name: 'CLASIFICACION ATRIBUTO', data: 'clasificacion_atributo' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'TOTAL', render: function (data, type, row) {
                        
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportClaAtriPqrsf',
                        'fechaAnio': fechaAnio,
                        'sede': sede
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            clasificacion_atributo: 'TOTAL',
                            ENERO: 0,
                            FEBRERO: 0,
                            MARZO: 0,
                            ABRIL: 0,
                            MAYO: 0,
                            JUNIO: 0,
                            JULIO: 0,
                            AGOSTO: 0,
                            SEPTIEMBRE: 0,
                            OCTUBRE: 0,
                            NOVIEMBRE: 0,
                            DICIEMBRE: 0
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            
            })

            let tablaEpsPQRSF = $('#tablaEpsPQRSF').DataTable({

                columns: [
                    { name: 'EPS', data: 'eps' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'TOTAL', render: function (data, type, row) {
                        
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportEpsPqrsf',
                        'fechaAnio': fechaAnio,
                        'sede': sede
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            eps: 'TOTAL',
                            ENERO: 0,
                            FEBRERO: 0,
                            MARZO: 0,
                            ABRIL: 0,
                            MAYO: 0,
                            JUNIO: 0,
                            JULIO: 0,
                            AGOSTO: 0,
                            SEPTIEMBRE: 0,
                            OCTUBRE: 0,
                            NOVIEMBRE: 0,
                            DICIEMBRE: 0
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            
            })

            let tablaMedRecepPQRSF = $('#tablaMedRecepPQRSF').DataTable({

                columns: [
                    { name: 'MEDIO RECEPCION', data: 'medio_recep_pqr' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'TOTAL', render: function (data, type, row) {
                        
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportMedRecepPqrsf',
                        'fechaAnio': fechaAnio,
                        'sede': sede
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            medio_recep_pqr: 'TOTAL',
                            ENERO: 0,
                            FEBRERO: 0,
                            MARZO: 0,
                            ABRIL: 0,
                            MAYO: 0,
                            JUNIO: 0,
                            JULIO: 0,
                            AGOSTO: 0,
                            SEPTIEMBRE: 0,
                            OCTUBRE: 0,
                            NOVIEMBRE: 0,
                            DICIEMBRE: 0
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            
            })

            let tablaServicioPQRSF = $('#tablaServicioPQRSF').DataTable({

                columns: [
                    { name: 'SERVICIO', data: 'servicio_area' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'TOTAL', render: function (data, type, row) {
                        
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
                ],
                ordering: false,
                dom: 'Bfrtip',
                destroy: true,
                pageLength: 50,
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Descargar Excel',
                        className: 'btn btn-phoenix-success',
                    },
                ],
                ajax: {
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportServicioPqrsf',
                        'fechaAnio': fechaAnio,
                        'sede': sede
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            servicio_area: 'TOTAL',
                            ENERO: 0,
                            FEBRERO: 0,
                            MARZO: 0,
                            ABRIL: 0,
                            MAYO: 0,
                            JUNIO: 0,
                            JULIO: 0,
                            AGOSTO: 0,
                            SEPTIEMBRE: 0,
                            OCTUBRE: 0,
                            NOVIEMBRE: 0,
                            DICIEMBRE: 0
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            
            })

            let tablaEnteControlPQRSF = $('#tablaEnteControlPQRSF').DataTable({

                columns: [
                    { name: 'ENTE CONTROL', data: 'ente_reporta_pqr' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'TOTAL', render: function (data, type, row) {
                        
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportEnteControlPqrsf',
                        'fechaAnio': fechaAnio,
                        'sede': sede
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            ente_reporta_pqr: 'TOTAL',
                            ENERO: 0,
                            FEBRERO: 0,
                            MARZO: 0,
                            ABRIL: 0,
                            MAYO: 0,
                            JUNIO: 0,
                            JULIO: 0,
                            AGOSTO: 0,
                            SEPTIEMBRE: 0,
                            OCTUBRE: 0,
                            NOVIEMBRE: 0,
                            DICIEMBRE: 0
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            
            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }

    }

}

// const listaSedesEpsPqrsf = (element, idSedeSelect) => {

//     let eps = $(element).val();

//     $.ajax({

//         type: "POST",
//         url: "ajax/parametricas.ajax.php",
//         data: {
//             'lista': 'listaSedeEpsPqrsf',
//             'eps': eps
//         },
//         success:function(respuesta){

//             $(`#${idSedeSelect}`).html(respuesta);

//         }

//     })

// }

const listaEpsSedePqrsf = (element, idEpsSelect) => {

    let sede = $(element).val();
    
    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaEpsSedePqrsf',
            'sede': sede
        },
        success:function(respuesta){

            let ipsSelectElement = document.querySelector(`#${idEpsSelect}`);

            $(`#${idEpsSelect}`).html(respuesta);

        }

    })

}


const generarReporteEstadistica2Eps = () => {

    const cardResultado = document.querySelector("#cardResulRepEstadistica2Eps");

    let formulario = document.getElementById("formRepEstadistica2Eps");
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

            let idTable = 'tablaTipoPqrsfEps';

            destroyIsDataTable(idTable);

            cardResultado.style.display = 'block';

            let fechaAnio = document.querySelector('#fechaAnio1').value;
            let eps = document.querySelector('#epsSedePqrsf1').value;
            let sede = document.querySelector('#sedePqrsf1').value;

            let tablaTipoPqrsfEps = $('#tablaTipoPqrsfEps').DataTable({

                columns: [
                    { name: 'TIPO PQRSF', data: 'tipo_pqr' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'TOTAL', render: function (data, type, row) {
                        
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportTipoPqrsfEps',
                        'fechaAnio': fechaAnio,
                        'eps': eps,
                        'sede': sede
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            tipo_pqr: 'TOTAL',
                            ENERO: 0,
                            FEBRERO: 0,
                            MARZO: 0,
                            ABRIL: 0,
                            MAYO: 0,
                            JUNIO: 0,
                            JULIO: 0,
                            AGOSTO: 0,
                            SEPTIEMBRE: 0,
                            OCTUBRE: 0,
                            NOVIEMBRE: 0,
                            DICIEMBRE: 0
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            
            })

        
        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }
    }


}

const generarReporteEstadistica2EpsMotivo = () => {

    const cardResultado = document.querySelector("#cardResulRepEstadistica2EpsMotivo");

    let formulario = document.getElementById("formRepEstadistica2EpsMotivo");
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

            let idTable = 'tablaMotivoPqrsfEps';

            destroyIsDataTable(idTable);

            cardResultado.style.display = 'block';

            let fechaAnio = document.querySelector('#fechaAnio2').value;
            let eps = document.querySelector('#epsSedePqrsf2').value;
            let sede = document.querySelector('#sedePqrsf2').value;

            let tablaMotivoPqrsfEps = $('#tablaMotivoPqrsfEps').DataTable({

                columns: [
                    { name: 'MOTIVO PQRSF', data: 'motivo_pqr' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'TOTAL', render: function (data, type, row) {
                        
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportTipoPqrsfEpsMotivo',
                        'fechaAnio': fechaAnio,
                        'eps': eps,
                        'sede': sede
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            motivo_pqr: 'TOTAL',
                            ENERO: 0,
                            FEBRERO: 0,
                            MARZO: 0,
                            ABRIL: 0,
                            MAYO: 0,
                            JUNIO: 0,
                            JULIO: 0,
                            AGOSTO: 0,
                            SEPTIEMBRE: 0,
                            OCTUBRE: 0,
                            NOVIEMBRE: 0,
                            DICIEMBRE: 0
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            
            })

        
        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }
    }


}

const generarReporteEstadistica2ClasiAtribu = () => {

    const cardResultado = document.querySelector("#cardResulRepEstadistica2ClasiAtribu");

    let formulario = document.getElementById("formRepEstadistica2ClasiAtribu");
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

            let idTable = 'tablaTipoPqrsfClasiAtribu';

            destroyIsDataTable(idTable);

            cardResultado.style.display = 'block';

            let fechaAnio = document.querySelector('#fechaAnio3').value;
            let clasifiAtributo = document.querySelector('#clasiAtributoPqrsf').value;
            let sede = document.querySelector('#sedePqrsf3').value;
            let eps = document.querySelector('#epsSedePqrsf4').value;

            let tablaTipoPqrsfClasiAtribu = $('#tablaTipoPqrsfClasiAtribu').DataTable({

                columns: [
                    { name: 'TIPO PQRSF', data: 'tipo_pqr' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'TOTAL', render: function (data, type, row) {
                        
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportTipoPqrsfClasiAtribu',
                        'fechaAnio': fechaAnio,
                        'clasifiAtributo': clasifiAtributo,
                        'sede': sede,
                        'eps': eps
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            tipo_pqr: 'TOTAL',
                            ENERO: 0,
                            FEBRERO: 0,
                            MARZO: 0,
                            ABRIL: 0,
                            MAYO: 0,
                            JUNIO: 0,
                            JULIO: 0,
                            AGOSTO: 0,
                            SEPTIEMBRE: 0,
                            OCTUBRE: 0,
                            NOVIEMBRE: 0,
                            DICIEMBRE: 0
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            
            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }

    }


}


const generarReporteEstadistica2EnteControl = () => {

    const cardResultado = document.querySelector("#cardResulRepEstadistica2EnteControl");

    let formulario = document.getElementById("formRepEstadistica2EnteControl");
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

            let idTable = 'tablaTipoPqrsfEnteControl';

            destroyIsDataTable(idTable);

            cardResultado.style.display = 'block';

            let fechaAnio = document.querySelector('#fechaAnio4').value;
            let enteControl = document.querySelector('#EnteControlPqrsf').value;
            let sede = document.querySelector('#sedePqrsf4').value;
            let eps = document.querySelector('#epsSedePqrsf5').value;

            let tablaTipoPqrsfEnteControl = $('#tablaTipoPqrsfEnteControl').DataTable({

                columns: [
                    { name: 'TIPO PQRSF', data: 'tipo_pqr' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'TOTAL', render: function (data, type, row) {
                        
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportTipoPqrsfEnteControl',
                        'fechaAnio': fechaAnio,
                        'enteControl': enteControl,
                        'sede': sede,
                        'eps': eps,
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            tipo_pqr: 'TOTAL',
                            ENERO: 0,
                            FEBRERO: 0,
                            MARZO: 0,
                            ABRIL: 0,
                            MAYO: 0,
                            JUNIO: 0,
                            JULIO: 0,
                            AGOSTO: 0,
                            SEPTIEMBRE: 0,
                            OCTUBRE: 0,
                            NOVIEMBRE: 0,
                            DICIEMBRE: 0
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            
            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }

    }


}

const generarReporteEstadistica2OportunidadEps = () => {

    const cardResultado = document.querySelector("#cardResulRepEstadistica2OportunidadEps");

    let formulario = document.getElementById("formRepEstadistica2OportunidadEps");
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

            let idTable = 'tablaTipoPqrsfOportunidadEps';

            destroyIsDataTable(idTable);

            cardResultado.style.display = 'block';

            let fechaAnio = document.querySelector('#fechaAnio5').value;
            let eps = document.querySelector('#epsSedePqrsf3').value;
            let sede = document.querySelector('#sedePqrsf5').value;

            let tablaTipoPqrsfOportunidadEps = $('#tablaTipoPqrsfOportunidadEps').DataTable({

                columns: [
                    { name: 'TIPO PQRSF', data: 'tipo_pqr' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'OPORTUNIDAD NORMATIVA', data: 'tiempo_normativo' },
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportTipoPqrsfOportunidadEps',
                        'fechaAnio': fechaAnio,
                        'eps': eps,
                        'sede': sede
                    }
                }
            
            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }

    }

}

const convertDiasHoras = (horas) => {

    const dias = Math.floor(horas / 24);
    const horasRestantes = horas % 24;
    return `${dias} D ${Math.floor(horasRestantes)} H`;

}

const generarReporteEstadistica2OportunidadSedeHoras = () => {

    const cardResultado = document.querySelector("#cardResulRepEstadistica2OportunidadSedeHoras");

    let formulario = document.getElementById("formRepEstadistica2OportunidadSedeHoras");
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

            let idTable = 'tablaTipoPqrsfOportunidadSedeHoras';

            destroyIsDataTable(idTable);

            cardResultado.style.display = 'block';

            let fechaAnio = document.querySelector('#fechaAnio6').value;
            let sede = document.querySelector('#sedePqrsf6').value;
            let eps = document.querySelector('#epsSedePqrsf6').value;

            let tablaTipoPqrsfOportunidadSedeHoras = $('#tablaTipoPqrsfOportunidadSedeHoras').DataTable({

                columns: [
                    { name: 'TIPO PQRSF', data: 'tipo_pqr' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'OPORTUNIDAD NORMATIVA', render: function (data, type, row) {

                        if(row.tiempo_normativo === ''){
                            return '';                            
                        }else{
                            return `${row.tiempo_normativo} - (${row.horas_normativas} horas)`;
                        }

                    }
                    },
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportTipoPqrsfOportunidadSedeHoras',
                        'fechaAnio': fechaAnio,
                        'sede': sede,
                        'eps': eps
                    }
                }
            
            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }

    }

}

const generarReporteEstadistica2OportunidadSedeDias = () => {

    const cardResultado = document.querySelector("#cardResulRepEstadistica2OportunidadSedeDias");

    let formulario = document.getElementById("formRepEstadistica2OportunidadSedeDias");
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

            let idTable = 'tablaTipoPqrsfOportunidadSedeDias';

            destroyIsDataTable(idTable);

            cardResultado.style.display = 'block';

            let fechaAnio = document.querySelector('#fechaAnio7').value;
            let sede = document.querySelector('#sedePqrsf7').value;
            let eps = document.querySelector('#epsSedePqrsf7').value;

            let tablaTipoPqrsfOportunidadSedeDias = $('#tablaTipoPqrsfOportunidadSedeDias').DataTable({

                columns: [
                    { name: 'TIPO PQRSF', data: 'tipo_pqr' },
                    { name: 'ENERO', render: function(data, type, row){
                        return convertDiasHoras(row.ENERO);
                    }},
                    { name: 'FEBRERO',render: function(data, type, row){
                        return convertDiasHoras(row.FEBRERO);
                    }},
                    { name: 'MARZO', render: function(data, type, row){
                        return convertDiasHoras(row.MARZO);
                    }},
                    { name: 'ABRIL', render: function(data, type, row){
                        return convertDiasHoras(row.ABRIL);
                    }},
                    { name: 'MAYO', render: function(data, type, row){
                        return convertDiasHoras(row.MAYO);
                    }},
                    { name: 'JUNIO', render: function(data, type, row){
                        return convertDiasHoras(row.JUNIO);
                    }},
                    { name: 'JULIO', render: function(data, type, row){
                        return convertDiasHoras(row.JULIO);
                    }},
                    { name: 'AGOSTO', render: function(data, type, row){
                        return convertDiasHoras(row.AGOSTO);
                    }},
                    { name: 'SEPTIEMBRE', render: function(data, type, row){
                        return convertDiasHoras(row.SEPTIEMBRE);
                    }},
                    { name: 'OCTUBRE', render: function(data, type, row){
                        return convertDiasHoras(row.OCTUBRE);
                    }},
                    { name: 'NOVIEMBRE', render: function(data, type, row){
                        return convertDiasHoras(row.NOVIEMBRE);
                    }},
                    { name: 'DICIEMBRE', render: function(data, type, row){
                        return convertDiasHoras(row.DICIEMBRE);
                    }},
                    { name: 'OPORTUNIDAD NORMATIVA', render: function (data, type, row) {

                        if(row.tiempo_normativo === ''){
                            return '';                            
                        }else{
                            return `${row.tiempo_normativo} - (${row.dias_normativos} dias)`;
                        }

                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportTipoPqrsfOportunidadSedeDias',
                        'fechaAnio': fechaAnio,
                        'sede': sede,
                        'eps': eps
                    }
                }
            
            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }

    }

}

const generarReporteEstadistica3 = () => {

    const cardResultado = document.querySelector("#cardResulRepEstadistica3");

    let formulario = document.getElementById("formRepEstadistica3");
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

            let idTable = 'tablaUsuariosPqrsf';

            destroyIsDataTable(idTable);

            cardResultado.style.display = 'block';

            let fechaAnio = document.querySelector('#fechaAnio').value;
            let rol = document.querySelector('#rolPqrsf').value;

            let tablaUsuariosPqrsf = $('#tablaUsuariosPqrsf').DataTable({

                columns: [
                    { name: 'NOMBRE Y USUARIO TRABAJADOR', data: 'usuario' },
                    { name: 'ENERO', data: 'ENERO' },
                    { name: 'FEBRERO', data: 'FEBRERO' },
                    { name: 'MARZO', data: 'MARZO' },
                    { name: 'ABRIL', data: 'ABRIL' },
                    { name: 'MAYO', data: 'MAYO' },
                    { name: 'JUNIO', data: 'JUNIO' },
                    { name: 'JULIO', data: 'JULIO' },
                    { name: 'AGOSTO', data: 'AGOSTO' },
                    { name: 'SEPTIEMBRE', data: 'SEPTIEMBRE' },
                    { name: 'OCTUBRE', data: 'OCTUBRE' },
                    { name: 'NOVIEMBRE', data: 'NOVIEMBRE' },
                    { name: 'DICIEMBRE', data: 'DICIEMBRE' },
                    { name: 'TOTAL', render: function (data, type, row) {
                        
                        let totalPQRSF = 0;
                        const array = Object.values(row);
                        for (const element of array){
                            if(Number(element)){
                                totalPQRSF += Number(element);
                            }
                        }
                        return totalPQRSF;
                    }},
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
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'reportEstadistica3Usuarios',
                        'fechaAnio': fechaAnio,
                        'rol': rol
                    },
                    dataSrc: function (json) {
                    
                        let totalFila = {
                            usuario: 'TOTAL',
                            ENERO: 0,
                            FEBRERO: 0,
                            MARZO: 0,
                            ABRIL: 0,
                            MAYO: 0,
                            JUNIO: 0,
                            JULIO: 0,
                            AGOSTO: 0,
                            SEPTIEMBRE: 0,
                            OCTUBRE: 0,
                            NOVIEMBRE: 0,
                            DICIEMBRE: 0
                        };
            
                        json.data.forEach(function (row){
                            totalFila.ENERO += Number(row.ENERO) || 0;
                            totalFila.FEBRERO += Number(row.FEBRERO) || 0;
                            totalFila.MARZO += Number(row.MARZO) || 0;
                            totalFila.ABRIL += Number(row.ABRIL) || 0;
                            totalFila.MAYO += Number(row.MAYO) || 0;
                            totalFila.JUNIO += Number(row.JUNIO) || 0;
                            totalFila.JULIO += Number(row.JULIO) || 0;
                            totalFila.AGOSTO += Number(row.AGOSTO) || 0;
                            totalFila.SEPTIEMBRE += Number(row.SEPTIEMBRE) || 0;
                            totalFila.OCTUBRE += Number(row.OCTUBRE) || 0;
                            totalFila.NOVIEMBRE += Number(row.NOVIEMBRE) || 0;
                            totalFila.DICIEMBRE += Number(row.DICIEMBRE) || 0;
                        });
            
                        json.data.push(totalFila);
                        return json.data;
                    }
                }
            
            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

        }

    }


}


const generarReporteEstadoProcesoPQRSF = () => {

    const cardResultado = document.querySelector("#cardResultEstadoProcesoPQRSF");

    let formulario = document.getElementById("formRepEstadoProcesoPQRSF");
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

            let sede = document.querySelector('#sedePqrsf').value;

            cardResultado.style.display = 'block';

            tablaEstadoProcesoPQRSF = $('#tablaEstadoProcesoPQRSF').DataTable({

                columns: [
                    { name: 'TIPO PQRSF', data: 'tipo_pqr' },
                    { name: 'VENCIDAS', data: 'CANT_VENCIDA' },
                    { name: 'A VENCER', data: 'CANT_A_VENCER' },
                    { name: 'A TIEMPO', data: 'CANT_A_TIEMPO' },
                ],
                ordering: false,
                destroy: true,
                ajax: {
                    url: 'ajax/pqr/reportes.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'listaReporteEstadoProcesoPQRSF',
                        'sede': sede
                    }
                }
            
            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");
        }

    }

}

const mostrarPqrsfEstadoProceso = (tipo) => {

    let sede = document.querySelector('#sedePqrsf').value;

    let tablePqrsfEstadoProceso = $('#tablePqrsfEstadoProceso').DataTable({

        columns: [
            { name: '#', data: 'id_pqr' },
            { name: 'NOMBRE PACIENTE', data: 'nombre_pac' },
            { 
                name: 'DOCUMENTO PACIENTE', render: function(data, type, row){
                    return `${row.tipo_identificacion_pac} - ${row.numero_identificacion_pac}`;
                }
            },
            { name: 'TIPO PQRS', data: 'tipo_pqr' },
            { name: 'MOTIVO PQRS', data: 'motivo_pqr' },
            { name: 'SERVICIO O AREA', data: 'servicio_area' },
            { name: 'CLASIFICACION ATRIBUTO', data: 'clasificacion_atributo' },
            { name: 'FECHA PQRSF', data: 'fecha_pqr' },
            { name: 'EPS', data: 'eps' },
            { name: 'SEDE', data: 'sede' },
            {
                name: 'ESTADO PQR', render: function(data, type, row){
    
                    if(row.estado_pqr === 'CREADA'){
                        return `<span class="badge badge-phoenix badge-phoenix-danger">SIN TRAMITE</span>`;
                    }else if(row.estado_pqr === 'GESTION' || row.estado_pqr === 'REVISION' || row.estado_pqr === 'REVISANDO'){
                        return `<span class="badge badge-phoenix badge-phoenix-warning">EN PROCESO DE TRAMITE</span>`;
                    }else if(row.estado_pqr === 'COMPLETADO'){
                        return `<span class="badge badge-phoenix badge-phoenix-info">RESPUESTA POR LA ENTIDAD</span>`;
                    }else{
                        return `<span class="badge badge-phoenix badge-phoenix-success">CERRADO TOTAL</span>`;
                    }
                }
            },
            {
                name: 'OPCIONES', orderable: false, render: function (data, type, row) {
    
                    if(row.estado_pqr === 'COMPLETADO' || row.estado_pqr === 'FINALIZADO'){
                        return `
                            <button type="button" class="btn btn-info btn-sm" onclick="infoPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                        `;
    
                    }else{
                        return `
                            <button type="button" class="btn btn-info btn-sm" onclick="infoPQRS(${row.id_pqr})" title="Ver PQRSF" data-bs-toggle="modal" data-bs-target="#modalVerPQR"><i class="far fa-eye"></i></button>
                        `;
                    }
    
                }
            }
        ],
        ordering: false,
        destroy: true,
        ajax: {
            url: 'ajax/pqr/reportes.ajax.php',
            type: 'POST',
            data: {
                'proceso': 'listaPQRSEstadoProceso',
                'tipo': tipo,
                'sede': sede
            }
        }
    
    })

}

const infoPQRS = (idPQR) => {

    $.ajax({
        
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'infoPQR',
            'idPQR': idPQR,
        },
        cache: false,
        dataType: "json",
        success:function(pqr){
            
            console.log('Info PQRSF:', pqr);

            $("#txtIdPQRS").text(pqr.id_pqr);
            $("#txtNombrePac").text(pqr.nombre_pac);
            $("#txtTipoDocPac").text(pqr.tipo_identificacion_pac);
            $("#txtNumDocPac").text(pqr.numero_identificacion_pac);
            $("#txtFechaNacPac").text(pqr.fecha_nacimiento_pac);
            $("#txtEps").text(pqr.eps);
            $("#txtRegimenEps").text(pqr.regimen);
            $("#txtPrograma").text(pqr.programa);
            $("#txtSede").text(pqr.sede);
            $("#txtNombrePet").text(pqr.nombre_pet);
            $("#txtTipoDocPet").text(pqr.tipo_identificacion_pet);
            $("#txtNumDocPet").text(pqr.numero_identificacion_pet);
            $("#txtContactoPet").text(pqr.contacto_pet);
            $("#txtCorreoPet").text(pqr.correo_pet);
            $("#txtDepPet").text(pqr.departamento);
            $("#txtMunPet").text(pqr.municipio);
            $("#txtDescripcionPqr").html(pqr.descripcion_pqr);
            $("#txtMedRecepPqr").text(pqr.medio_recep_pqr);
            $("#txtFechaAperBuzonSug").text(pqr.fecha_apertura_buzon_suge);
            $("#txtFechaHoraRadPqr").text(pqr.fecha_radicacion_pqr);
            $("#txtTipoPqr").text(pqr.tipo_pqr);
            $("#txtEnteRepPqr").text(pqr.ente_reporta_pqr);
            $("#txtMotivoPqr").text(pqr.motivo_pqr);
            $("#txtTrabajadorRelaPqr").text(pqr.trabajador_relacionado_pqr);
            $("#txtGestorPqr").text(`${pqr.nombre} - ${pqr.gestor}`);
            $("#txtServAreaPqr").text(pqr.servicio_area);
            $("#txtCaliAtribuPqr").text(pqr.clasificacion_atributo);
            $("#txtTiempoResNormaPqr").text(pqr.tiempo_res_normativo);
            $("#txtHorasDiasOportPqr").text(pqr.horas_dias_oportunidad);
            $("#txtFechaPQRSF").text(pqr.fecha_pqr);

            if(pqr.archivosPQRSF === 'SIN ARCHIVOS'){

                $("#containerArchivosPQRSF").html(`<b>SIN ARCHIVOS</b>`);

            }else{

                let cadena = `<ul class="list-group">`;

                for(const archivo of pqr.archivosPQRSF){

                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivos+archivo}" target="_blank">${archivo}</a></li>`;
                    
                }

                cadena += `</ul>`;

                $("#containerArchivosPQRSF").html(cadena);

            }

            //INFORMACION GESTOR Y SUPERVISOR

            if(pqr.estado_pqr === 'CREADA'){
                $("#contenedorEstadoPQR").html(`<div class="alert alert-soft-danger text-center" style="font-size: 25px;" role="alert">SIN TRAMITE</div>`);
            }else if(pqr.estado_pqr === 'GESTION' || pqr.estado_pqr === 'REVISION' || pqr.estado_pqr === 'REVISANDO'){
                $("#contenedorEstadoPQR").html(`<div class="alert alert-soft-warning text-center" style="font-size: 25px;" role="alert">EN PROCESO DE TRAMITE</div>`);
            }else if(pqr.estado_pqr === 'COMPLETADO'){
                $("#contenedorEstadoPQR").html(`<div class="alert alert-soft-info text-center" style="font-size: 25px;" role="alert">RESPUESTA POR LA ENTIDAD</div>`);
            }else{
                $("#contenedorEstadoPQR").html(`<div class="alert alert-soft-success text-center" style="font-size: 25px;" role="alert">CERRADO TOTAL</div>`);
            }

            $("#txtQue").text(pqr.pla_ac_que);
            $("#txtPorQue").text(pqr.pla_ac_por_que);
            $("#txtCuando").text(pqr.pla_ac_cuando);
            $("#txtDonde").text(pqr.pla_ac_donde);
            $("#txtComo").text(pqr.pla_ac_como);

            if(pqr.pla_ac_quien){

                let cadenaQuien = '';

                for (const element of pqr.pla_ac_quien.split('-')) {
                    cadenaQuien += `<li>${element}</li>`;
                }
                $("#txtQuien").html(cadenaQuien);
                
            }else{
                
                $("#txtQuien").html('');

            }


            if(pqr.pla_ac_recurso){

                let cadenaRecursos = '';
                
                for (const element of pqr.pla_ac_recurso.split('-')) {
                    cadenaRecursos += `<li>${element}</li>`;
                }
                $("#txtRecursos").html(cadenaRecursos);
                
            }else{
                $("#txtRecursos").html('');
            }
                
            $("#txtNegacionPQR").text(pqr.pla_ac_negacion_pqr);
            $("#txtMotivoResponsableNegacion").text(pqr.pla_ac_motivo_negacion);
            $("#txtPQRSRecurrente").text(pqr.pla_ac_pqr_recurrente);
            $("#txtAccionEfectiva").text(pqr.pla_ac_accion_efectiva);
            $("#txtRespPqr").html(pqr.pla_ac_respuesta);
            $("#txtObservacionesGestor").text(pqr.observaciones_gestor);
            $("#txtObservacionesSupervisor").text(pqr.observaciones_revision);

            //INFORMACION SI TIENE ACTA

            let containerInfoActa = document.querySelector('.containerInfoActa');
                
            if(containerInfoActa){

                if(pqr.id_acta){

                    containerInfoActa.style.display = 'block';

                    $.ajax({
            
                        url: 'ajax/pqr/pqr.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'infoBuzonPQR',
                            'idPQR': pqr.id_pqr,
                        },
                        cache: false,
                        dataType: "json",
                        success:function(pqr){
                
                            $("#txtIdPQRSF").text(pqr.id_pqr);
                            $("#txtRadActa").text(pqr.radicado_acta);
                            $("#txtFechaActa").text(pqr.fecha_acta);
                            $("#txtFechaAperturaActa").text(pqr.fecha_apertura_buzon);
                
                            if(pqr.archivosActaPQRSF === 'SIN ARCHIVOS'){
                
                                $("#containerArchivosActasPQRSF").html(`<b>SIN ARCHIVOS</b>`);
                
                            }else{
                
                                let cadena = `<ul class="list-group">`;
                
                                for(const archivo of pqr.archivosActaPQRSF){
                
                                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivos_actas+archivo}" target="_blank">${archivo}</a></li>`;
                                    
                                }
                
                                cadena += `</ul>`;
                
                                $("#containerArchivosActasPQRSF").html(cadena);
                
                            }
                
                        }
                
                    })

                }else{

                    containerInfoActa.style.display = 'none';

                }

            }

            if(pqr.estado_pqr === 'FINALIZADO'){

                $("#contenedorArchivoResPQRSF").html(`
                <div class="alert alert-soft-success text-center" role="alert">
                    <b>ARCHIVO RESPUESTA PQRSF</b>
                    <br><br>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="${pqr.ruta_archivo_res}" target="_blank">Archivo Respuesta</a></li>
                    </ul>
                </div>`);

            }else{

                $("#contenedorArchivoResPQRSF").html('');

            }

            if(pqr.ruta_archivo_res){

                let cadena = `<div class="alert alert-soft-success text-center" role="alert">
                    <b>ARCHIVO RESPUESTA PQRSF</b>
                    <br><br>
                    <ul class="list-group">`;

                for(const archivo of pqr.archivosRespPQRSF){

                    cadena += `<li class="list-group-item"><a href="${pqr.ruta_archivo_res+archivo}" target="_blank">${archivo}</a></li>`;
                    
                }

                cadena += `</ul></div`;

                $("#contenedorArchivoResPQRSF").html(cadena);

            }

        }

    })
}
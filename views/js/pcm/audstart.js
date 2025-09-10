let idReclamacion, valorReclamado, codEntrada,TipoIngreso, tipoGlosaPar;

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function validaText(campo, largoMin, largoMax, contenido, boton) {
    let menssage = '';
    const longMin = largoMin;
    const longMax = largoMax;
    const pattern = new RegExp('^[a-zA-ZñÑ ]+$', 'i');
    const pattern2 = new RegExp('^[a-zA-Z0-9ñÑ.]+$', 'i');
    const pattern3 = new RegExp('^[0-9]+$', 'i');
    const pattern4 = new RegExp('^[a-zA-Z0-9ñÑ.,#\\-\\s]+$', 'i');
    var input = $('#' + campo).val();

    /* Largo Minimo del campo */
    if (input.length < longMin) {
        menssage += 'Largo menor a ' + longMin + '<br>';
        //console.log('Esta es la validacion de Texto ' + input + menssage);
    }

    /* Largo Maximo del campo */
    if (input.length > longMax) {
        menssage += 'Largo mayor a ' + longMax + '<br>';
        //console.log('Esta es la validacion de Texto ' + input + menssage);
    }

    /* Contenido campo*/
    if (contenido == 1) {
        if (!pattern.test(input)) {
            menssage += 'Contiene caracteres especiales o numeros <br>';
            //console.log('Esta es la validacion de Texto ' + input + menssage);
        }
    }
    if (contenido == 2) {
        if (!pattern2.test(input)) {
            menssage += 'Contiene caracteres especiales <br>';
            //console.log('Esta es la validacion de Texto con numeros ' + input + menssage);
        }
    }
    if (contenido == 3) {
        if (!pattern3.test(input)) {
            menssage += 'Solo debe contener numeros <br>';
            //console.log('Esta es la validacion solo numeros ' + input + menssage);
        }
    }
    
    if(contenido == 4){
        if(!pattern4.test(input)){
            menssage += 'Solo debe contener letras numeros y caracteres (.,-#) <br>';
        }
    }

    /* Se valida si hay error */
    if (menssage == '') { // Sin Errores
        $('#' + boton).attr('disabled', false);
        $('#' + campo).removeClass('is-invalid');
        $('#' + campo).addClass('is-valid');
        //console.log(campo + '->' + input + '->' + 'Ok');
    } else { // Con Errores
        $('#' + boton).attr('disabled', true);
        $('#' + campo).removeClass('is-valid');
        $('#' + campo).addClass('is-invalid');
        $('#' + campo + 'Help').html(menssage);
        //console.log(campo + '->' + input + '->' + menssage);
    }

}

function calcularGlosa(idReclamacion, callback) {
    //console.log("Id Cuenta: " + idCuenta);
    $.ajax({
        url: 'ajax/pcm/auditoria.ajax.php',
        type: 'POST',
        data: {
            'option': 'calcularGlosa',
            'idReclamacion': idReclamacion
        },
        success: function (respuesta) {
            //console.log(respuesta);
            if (respuesta === 'ok') {
                //console.log("Calculo Correcto");
                if (callback && typeof callback === 'function') {
                    callback();  // Llama al callback si todo es correcto
                }
            } else {
                console.log("Hubo un problema realizando el calculo ");
            }
        }
    })
}

function formatNumber(num) {
    return num.toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    });
}

function cleanForm(form) {
    const formulario = document.getElementById(form);
    formulario.reset();
    const elementsValid = document.getElementsByClassName('is-valid');
    const elementsInValid = document.getElementsByClassName('is-invalid');
    //console.log(elementsValid);
    Object.entries(elementsValid).forEach(([key, value]) => {
        $('#' + value.name).removeClass('is-valid');
    });
    Object.entries(elementsInValid).forEach(([key, value]) => {
        $('#' + value.name).removeClass('is-invalid');
    });

}

function validaNum(campo, numMin, numMax, contenido, boton) {
    let menssage = '';
    const min = numMin;
    const max = numMax;
    var input = $('#' + campo).val();

    if (input == '' || input == null) {
        menssage += 'Ingrese numero<br>';
    }

    /* Minimo del campo */
    if (parseFloat(input) < parseFloat(numMin)) {
        menssage += 'Numero menor a ' + numMin + '<br>';
        //console.log(menssage);
    }

    /* Largo Maximo del campo */
    if (parseFloat(input) > parseFloat(numMax)) {
        menssage += 'Numero mayor a ' + numMax + '<br>';
        //console.log(menssage);
    }

    /* Contenido campo*/
    if (contenido == 1) {
        if (isNaN(input)) {
            menssage += 'Por favor inserte solo numeros <br>';
            //console.log(menssage);
        }
    }

    if (menssage == '') { // Sin Errores
        $('#' + boton).attr('disabled', false);
        $('#' + campo).removeClass('is-invalid');
        $('#' + campo).addClass('is-valid');
        //console.log(campo + '->' + input + '->' + 'Ok');
    } else { // Con Errores
        $('#' + boton).attr('disabled', true);
        $('#' + campo).removeClass('is-valid');
        $('#' + campo).addClass('is-invalid');
        $('#' + campo + 'Help').html(menssage);
        //console.log(campo + '->' + input + '->' + menssage);
    }

}

try {
    idProfile = atob(getParameterByName('idPerfil'));
    idReclamacion = atob(getParameterByName('idReclamacion'));
    codEntrada = atob(getParameterByName('codEntrada'));
    calcularGlosa(idReclamacion);
    reclamacionInfo(idReclamacion);
    pdfContainer(codEntrada);
} catch (error) {
    console.error("Error decodificando la cadena: ", error);
    toastr.error("¡Error de perfil, Sera direccionado al inicio", "Mensaje", { timeOut: 5000 });
    setInterval(function () {
        window.location = "inicio";
    }, 1000);

}

$.ajax({
    url: 'ajax/pcm/auditoria.ajax.php',
    type: 'POST',
    data: {
        'option': 'validaCuenta',
        'idReclamacion': idReclamacion,
        'idPerfil': idProfile,
        'usuario': sessionUser
    }, success: function (respuesta) {
        console.log(respuesta);
        switch (respuesta) {
            case 'Asignada':
                calcularGlosa(idReclamacion);
                toastr.success('¡Se ha asignado la Cuenta! ' + idReclamacion);
                if (tipoGlosaPar=='respuesta_glosa'){
                    console.log('Ingreso '+TipoIngreso);
                    alert('Tener en cuenta que la reclamación corresponde a una respuesta a glosa por lo tanto la auditoria realizada por usted, debe tener en cuenta los componentes: medico, financiero y juridico.');
                }
                break;
            case 'Error Asignado':
                toastr.error("¡Hubo un problema al asignar la Cuenta!", "Mensaje", { timeOut: 5000 });
                setInterval(function () {
                    window.location = "index.php?ruta=audSearch&idProfile=" + btoa(idProfile) + "";
                }, 1000);
                break;
            case 'Ya Asignada':
                toastr.error("Cuenta ya asignada a otro auditor o Cerrada!", "Mensaje", { timeOut: 5000 });
                setInterval(function () {
                    window.location = "index.php?ruta=audSearch&idProfile=" + btoa(idProfile) + "";
                }, 1000);
                break;
            case 'Propia':
                calcularGlosa(idReclamacion);
                if (tipoGlosaPar=='respuesta_glosa'){
                    console.log('Ingreso '+TipoIngreso);
                    alert('Tener en cuenta que la reclamación corresponde a una respuesta a glosa por lo tanto la auditoria realizada por usted, debe tener en cuenta los componentes: medico, financiero y juridico.');
                }
                break;
            default:
                toastr.error("¡Error general!", "Mensaje", { timeOut: 5000 });
                setInterval(function () {
                    window.location = "index.php?ruta=audSearch&idProfile=" + btoa(idProfile) + "";
                }, 1000);
                break;

        }
    }
})

function reclamacionInfo(idReclamacion) {
    $.ajax({
        url: 'ajax/pcm/auditoria.ajax.php',
        type: 'POST',
        data: {
            'option': 'reclamacionInfo',
            'idReclamacion': idReclamacion
        },
        dataType: 'json',
        success: function (respuesta) {
            console.log(respuesta);
            let fechaFin = new Date(respuesta["Fecha_Hora_Egreso_IPS"]);
            let fechaIni = new Date(respuesta["Fecha_Hora_Ingreso_IPS"]);
            eventoIni = fechaFin.toISOString().split('T')[0];
            eventoFin = fechaIni.toISOString().split('T')[0];
            let diasEstancia = Math.floor((fechaFin.getTime() - fechaIni.getTime()) / (1000 * 60 * 60 * 24))
            $("#numeroPaquete").val(respuesta["Numero_Paquete"]);
            $("#numRadica").html(respuesta["Numero_Radicacion"]);
            $("#NumeroRadicacionAnotacion").val(respuesta["Numero_Radicacion"]);//para añadir el numero de radicacion a la tabla anotaciones
            $("#reclamacionId").html(respuesta["Reclamacion_Id"]);
            $("#fechaRadica").html(respuesta["Fecha_Radicacion_Consolidado"]);
            $("#proveedor").html(respuesta["Razon_Social_Reclamante"]);
            $("#proveedorDoc").html(respuesta["Tipo_Doc_Reclamante"] + '-' + respuesta["Numero_Doc_Reclamante"] + ' / ' + respuesta["Codigo_Habilitacion"]);
            $("#numFactura").html(respuesta["Numero_Factura"]);
            $("#fechaEvento").html(respuesta["Fecha_Hora_Evento"]);
            $("#valorMedico").html(formatNumber(parseFloat(respuesta["Total_Reclamado_Amparo_Gastos_Medicos_Quirurgicos"])));
            $("#valorTransporte").html(formatNumber(parseFloat(respuesta["Total_Reclamado_Amparo_Gastos_Transporte_Movilización_Victima"])));
            $("#valorReclamado").html(formatNumber(parseFloat(respuesta["Total_Reclamado"])));
            valorReclamado = respuesta["Total_Reclamado"];
            imgCod = respuesta["Codigo_Entrada"];
            if (respuesta["Tipo_Ingreso"] == '2') {
                TipoIngreso = 'Reclamacion Nueva';
                tipoGlosaPar = 'reclamacion_nueva';
            } else if(respuesta["Tipo_Ingreso"] == '0' || respuesta["Tipo_Ingreso"] == '1') {
                TipoIngreso = 'Respuesta Glosa';
                tipoGlosaPar = 'respuesta_glosa';
            }else{
                TipoIngreso = 'error';
                tipoGlosaPar = 'error';
            };
            $("#tipoIngreso").html(TipoIngreso);
            $("#nombreVictima").html(respuesta["Primer_Nombre_Victima"] + ' ' + respuesta["Segundo_Nombre_Victima"] + ' ' + respuesta["Primer_Apellido_Victima"] + ' ' + respuesta["Segundo_Apellido_Victima"]);
            $("#docVictima").html(respuesta["Tipo_Doc_Victima"] + '-' + respuesta["Numero_Doc_Victima"]);
            $("#fechaNaci").html(respuesta["Fecha_Hora_Evento"]);
            $("#fechaIni").html(respuesta["Fecha_Hora_Ingreso_IPS"]);
            $("#fechaEgr").html(respuesta["Fecha_Hora_Egreso_IPS"]);
            $("#estanciaDia").html(diasEstancia);
            $("#eventoDescrip").html(respuesta["Descripcion_evento"]);

            $('#card-header-title-audit-start').html(idProfile + ' - Auditando ' + respuesta["Tipo_Formulario"] + ' Cuenta Id: ' + idReclamacion + ' Paquete-> ' + respuesta["Numero_Paquete"]);

            $("#valorReclamacionFin").html(formatNumber(parseFloat(respuesta["Total_Reclamado"])));
            $("#valorAprobadoFin").html(formatNumber(parseFloat(respuesta["Total_Aprobado"])));
            $("#valorGlosaFin").html(formatNumber(parseFloat(respuesta["Total_Glosado"])));
            $("#EstadoAprobacion").html(respuesta["Tipo_Aprobacion_New"]);

            console.log('tipo glosa ->' + tipoGlosaPar);


        }

    })
}

function pdfContainer(codEntrada) {

    let type = 'new';

    $.ajax({
        url: 'ajax/pcm/auditoria.ajax.php',
        type: 'POST',
        data: {
            'option': 'reclamacionInfo',
            'idReclamacion': idReclamacion
        },
        dataType: 'json',
        success: function (respuesta) {

            $('.pdf-container').html(`
                <center>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <button class="btn btn-outline-info m-1" onclick="openWindowImg()">
                            Ver Imagenes <i class="fa-regular fa-image"></i>
                        </button>
                        <button class="btn btn-outline-warning m-1" onclick="openWindowCompare()">
                            Fisico Vs Magnetico <i class="fa-solid fa-table-columns"></i>
                        </button>
                    </div>
                </div>
                </center>
                <br>
                <iframe src="view_pdf.php?type=${type}&codImg=${codEntrada}&numPaquete=${respuesta.Numero_Paquete.toLowerCase()}" height="800" width="100%"></iframe>
            `);


        }
    })
}

$('#hidePdfBtn').click(function () {
    $('.pdf-container').toggle(); // Oculta o muestra el PDF container

    if ($('.pdf-container').is(':visible')) {
        $('.table-container').removeClass('col-md-12').addClass('col-md-6');
        $('#hidePdfBtn').text('Ocultar PDF');
        tableReclaDetail.draw();
    } else {
        $('.table-container').removeClass('col-md-6').addClass('col-md-12');
        $('#hidePdfBtn').text('Mostrar PDF');
        tableReclaDetail.draw();
    }
});

var tableReclaDetail = $('#tableReclaDetail').DataTable({
    scrollY: "70vh",
    columns: [
        { name: 'Item', data: 'Item_id' },
        { name: 'Tipo', data: 'Tipo_Servicio' },
        { name: 'Codigo', data: 'Codigo_Servicio' },
        { name: 'Descripcion', data: 'Descripcion' },
        { name: 'Cant', data: 'Cantidad' },
        {
            name: 'Vl Unitario',
            data: 'Valor_Unitario',
            render: function (data, type, row) {
                if (type === 'display') {
                    return '$ ' + $.fn.dataTable.render.number('.', ',', 2, '').display(data);
                }
                return data;
            }
        },
        {
            name: 'Vl Reclamado',
            data: 'Valor_Total_Reclamado_item',
            render: function (data, type, row) {
                if (type === 'display') {
                    return '$ ' + $.fn.dataTable.render.number('.', ',', 2, '').display(data);
                }
                return data;
            }
        },
        {
            name: 'Vl Glosado',
            data: 'Valor_Glosado_Item',
            render: function (data, type, row) {
                if (type === 'display') {
                    return '$ ' + $.fn.dataTable.render.number('.', ',', 2, '').display(data);
                }
                return data;
            }
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                if (row.sum_glosas !== "0" && row.sum_glosas !== 0) {
                    return `<button type="button" class="btn btn-round btn-danger btnCreateGlosaItemModal" title="Glosas en item: ${row.Glosa}" idItem="${row.Item_id}" valorUni="${row.Valor_Unitario}" valorItem="${row.Valor_Total_Reclamado_item}" cantidadItem="${row.Cantidad}" descripItem="${row.Descripcion}"><i class="fa-solid fa-dollar-sign"></i></button>
                    <input type="checkbox" class="checkGlosa" name="createGlosa[]" value="${row.Item_id}">`;
                } else {
                    return `<button type="button" class="btn btn-round btn-success btnCreateGlosaItemModal" title="Glosar Item" idItem="${row.Item_id}" valorUni="${row.Valor_Unitario}" valorItem="${row.Valor_Total_Reclamado_item}" cantidadItem="${row.Cantidad}" descripItem="${row.Descripcion}"><i class="fa-solid fa-dollar-sign"></i></button>
                    <input type="checkbox" class="checkGlosa" name="createGlosa[]" value="${row.Item_id}">`;
                }

            }
        }
    ],
    pageLength: -1,
    ajax: {
        url: 'ajax/pcm/auditoria.ajax.php',
        type: 'POST',
        data: {
            'option': 'reclamacionDetail',
            'idReclamacion': idReclamacion
        }
    },
    buttons: [
        {
            extend: 'excel',
            footer: true,
            text: 'Exportar .xlsx <i class="fa-regular fa-file-excel"></i>',
            title: 'Detalle de Cuenta ' + idReclamacion,
            className: 'btn btn-outline-primary m-1',
        },
        {
            text: 'Glosa Cuenta <i class="fa-solid fa-sack-dollar"></i>',
            className: 'btn btn-outline-success m-1 btnCreateGlosaReclamaModal',
            action: function (e, dt, node, config) {
                /* $("#createGlosaRecModal").modal();
                console.log('Glosa general');
                cleanForm("formCreateGlosaRecla");
                $('#titleModalCrearGlosa').html('<b>Glosando Encabezado</b>'); */
            }
        },
        {
            text: 'Glosa Masiva <i class="fa-solid fa-money-check-dollar"></i>',
            className: 'btn btn-outline-warning m-1 btnCreateGlosaMasivaRecModal',
            action: function (e, dt, node, config) {
                /* $("#createGlosaRecModal").modal();
                console.log('Glosa general');
                cleanForm("formCreateGlosaRecla");
                $('#titleModalCrearGlosa').html('<b>Glosando Encabezado</b>'); */
            }
        }
    ],
    dom: "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
});

var tableReclaGlosas = $('#tableReclaGlosas').DataTable({
    columns: [
        { name: 'Id Glosa', data: 'Id_Glosa' },
        { name: 'Id Item', data: 'Item_id' },
        { name: 'Tipo', data: 'Clasificacion_Glosa' },
        { name: 'Cod Glosa', data: 'Cod_Glosa' },
        { name: 'Descrpcion Glosa', data: 'Descripcion_Glosa' },
        { name: 'Justificacion Glosa', data: 'Justificacion_Glosa' },
        {
            name: 'Valor Glosa',
            data: 'Valor_Total_Glosa',
            render: function (data, type, row) {
                if (type === 'display') {
                    return '$ ' + $.fn.dataTable.render.number('.', ',', 2, '').display(data);
                }
                return data;
            }
        },
        { name: 'Usuario', data: 'Usuario' },
        { name: 'Fecha', data: 'Fecha_Glosa' },
        {
            name: 'Opciones', orderable: false, render: function (data, type, row) {
                if (row.Usuario === 'diego.medina') {
                    // No mostrar botones si el usuario es "diego.medina"
                    return '';
                } else {
                    // Mostrar los botones para otros usuarios
                    return `<button type="button" class="btn btn-round btn-danger btnDeleteGlosa" title="Borrar" idGlosa="${row.Id_Glosa}" ><i class="fa-solid fa-eraser"></i></button>
                    <input type="checkbox" class="checkDelete" name="deteleGlosa[]" value="${row.Id_Glosa}">`;
                }
            }
        }
    ],
    pageLength: -1,
    ajax: {
        url: 'ajax/pcm/auditoria.ajax.php',
        type: 'POST',
        data: {
            'option': 'reclamacionGlosas',
            'idReclamacion': idReclamacion
        }
    },
    buttons: [
        {
            extend: 'excel',
            footer: true,
            text: 'Exportar .xlsx <i class="fa-regular fa-file-excel"></i>',
            title: 'Glosas de Cuenta ' + idReclamacion,
            className: 'btn btn-outline-primary',
        },
        {
            text: 'Eliminar Glosas <i class="fa-regular fa-trash-can"></i>',
            className: 'btn btn-outline-danger btnDeleteGlosasMasi',
            action: function (e, dt, node, config) {
                /* $("#createGlosaRecModal").modal();
                console.log('Glosa general');
                cleanForm("formCreateGlosaRecla");
                $('#titleModalCrearGlosa').html('<b>Glosando Encabezado</b>'); */
            }

        }],
    dom: "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
});

function openFurips(){
    let numeroPaquete = document.getElementById('numeroPaquete').value;
    var url = "views/assets/plugins/TCPDF/examples/furips.php?numRecla=" + btoa(idReclamacion);
    // <iframe src="vistas/assets/plugins/TCPDF/examples/furips.php?numRecla=`+ btoa(reclamacionId) + `" width="49%" height="1000" align="right"></iframe>
    var win = window.open(url, '_blank');

}

// Definir la función que abre la nueva ventana
function openWindowImg() {
    let numeroPaquete = document.getElementById('numeroPaquete').value;
    var url = "index.php?ruta=pcm/imgview&codImg=" + btoa(codEntrada) + "&type=new&numPaq=" + numeroPaquete.toLowerCase();
    var win = window.open(url, '_blank');
    win.focus();
}

function openWindowCompare() {
    let numeroPaquete = document.getElementById('numeroPaquete').value;
    // var url = "index.php?ruta=imgview&codImg=" + btoa(codEntrada)+"&type=compare&reclamacionId=" + btoa(idReclamacion);
    var url = "index.php?ruta=imgview&codImg=" + btoa(codEntrada) + "&reclamacionId=" + btoa(idReclamacion) + "&type=compare&numPaq=" + numeroPaquete.toLowerCase();
    var win = window.open(url, '_blank');
    win.focus();
    /* var url = 'formulario.php?ima=' + imgCod + '&numrecla=' + idReclamacion;
    var win = window.open(url, '_blank');
    win.focus(); */
}
function CalcularValor() {

    let CantidadGlosa = Number(document.getElementById('cantidadGlosa').value);
    let ValorGlosa = Number(document.getElementById('valorGlosa').value);
    let ValorTotal = CantidadGlosa * ValorGlosa;
    let ValorServicio = document.getElementById('valorItemModal').value;

    let cantidadItem = document.getElementById('cantidadItemModal').value;
    let valorUniItem = Number(document.getElementById('valorUniItemModal').value);


    if (ValorTotal > ValorServicio) {
        $('#btCreateGlosa').attr('disabled', true);
        $('#totalGlosa').removeClass('is-valid');
        $('#totalGlosa').addClass('is-invalid');
        $('#totalGlosaHelp').html('El valor de la glosa supera el valor facturado del item');

    } else {
        $('#btCreateGlosa').attr('disabled', false);
        $('#totalGlosa').removeClass('is-invalid');
        $('#totalGlosa').addClass('is-valid');
        $('#totalGlosaHelp').html();

    }

    if (ValorGlosa == valorUniItem) {
        document.getElementById('tipoGlosa').value = 'cantidad';
    } else {
        document.getElementById('tipoGlosa').value = 'valor';
    }

    document.getElementById('totalGlosa').value = ValorTotal;
}

function CalcularPorcentaje() {
    //console.log("CalcularPorcentaje");
    let PorcentajeGlosa = Number(document.getElementById('porcentajeGlosa').value);
    let valorItem = Number(document.getElementById('valorItemModal').value);
    let valorTotal = (valorItem * PorcentajeGlosa) / 100;
    document.getElementById('tipoGlosa').value = 'porcentaje';
    document.getElementById('totalPorcentajeGlosa').value = valorTotal;

}

function initialiceChoice(idSelect) {
    const element = document.querySelector(`#${idSelect}`);

    if (!element) return; // Si el elemento no existe, salir

    // Verifica si el elemento ya tiene una instancia de Choices y la destruye
    if (element._choices) {
        element._choices.destroy();
    }

    // Crear una nueva instancia y guardarla en la propiedad `_choices` del elemento
    element._choices = new Choices(element, {
        removeItemButton: true,  
        noResultsText: "No hay resultados", 
        itemSelectText: "Seleccionar", 
        shouldSort: false, // Mantiene el orden de las opciones
        searchEnabled: true, // Habilita la búsqueda
        searchFloor: 1, // Número mínimo de caracteres para empezar a filtrar
        searchResultLimit: 10, // Limita la cantidad de resultados mostrados
        fuseOptions: {
            threshold: 0.2, // Hace el filtrado más estricto (0 = más exacto, 1 = más permisivo)
            distance: 5, // Reduce la distancia de coincidencia
            ignoreLocation: true, // No prioriza coincidencias en la primera parte del texto
        }
    });
}





$(document).on("click", ".btnCreateGlosaItemModal", function () {
    $("#createGlosaUniModal").modal('show');
    cleanForm("formCreateGlosaItem");

    document.getElementById("valorGlosaInput").style.display = "none";
    document.getElementById("porcentajeGlosaInput").style.display = "none";
    document.getElementById("justificacion").style.display = "none";

    let descripItem = $(this).attr("descripItem");
    let idItem = $(this).attr("idItem");
    let cantidadItem = parseFloat($(this).attr("cantidadItem"));
    let valorUni = parseFloat($(this).attr("valorUni"));
    let valorItem = parseFloat($(this).attr("valorItem"));

    $('#titleModalCrearGlosa').html('<b>Glosando Item: </b>' + descripItem + '<br/><b>Cantidad: </b>' + cantidadItem + ' <b>Valor Unitario: </b>' + formatNumber(valorUni) + '<b> Valor Total: </b>' + formatNumber(valorItem));
    $("#cantidadItemModal").val(cantidadItem);
    $("#valorUniItemModal").val(valorUni);
    $("#idItemModal").val(idItem);
    $("#valorItemModal").val(valorItem);

    let glosaBySelect = '<option value=""></option>';
    glosaBySelect += '<option value="Valor">Valor - $</option>';
    glosaBySelect += '<option value="Porcentaje">Porcentaje - %</option>';

    $('#glosaBy').html(glosaBySelect);

    $('#glosaBy').on('change', function () {
        let glosaBy = $(this).val();
        if (glosaBy === 'Valor') {

            document.getElementById("valorGlosaInput").style.display = "block";
            document.getElementById("porcentajeGlosaInput").style.display = "none";
            document.getElementById("justificacion").style.display = "block";

            $('#cantidadGlosa').attr('required', true);
            $('#valorGlosa').attr('required', true);
            $('#totalGlosa').attr('required', true);
            $('#porcentajeGlosa').attr('required', false);
            $('#totalPorcentajeGlosa').attr('required', false);

            let cantidadGlosa = document.getElementById('cantidadGlosa');
            cantidadGlosa.max = cantidadItem;
            cantidadGlosa.onkeyup = function () {
                validaNum('cantidadGlosa', 1, cantidadItem, 1, 'btCreateGlosa');
                CalcularValor();
            }
            cantidadGlosa.addEventListener('input', function () {
                validaNum('cantidadGlosa', 1, cantidadItem, 1, 'btCreateGlosa');
                CalcularValor();
            });

            let valorGlosa = document.getElementById('valorGlosa');
            valorGlosa.max = valorItem;
            valorGlosa.onkeyup = function () {
                validaNum('valorGlosa', 0.01, valorItem, 1, 'btCreateGlosa');
                CalcularValor();
            }

            valorGlosa.addEventListener('input', function () {
                validaNum('valorGlosa', 0.01, valorItem, 1, 'btCreateGlosa');
                CalcularValor();
            });

            let valorTotalGlosado = document.getElementById('totalGlosa');
            valorTotalGlosado.max = valorItem;
            valorTotalGlosado.onchange = function () {
                validaNum('totalGlosa', 0.01, cantidadItem, 1, 'btCreateGlosa');
            }

            let textGlosa = document.getElementById('obsGlosa');
            textGlosa.onkeyup = function () {
                validaText('obsGlosa', 5, 2000, -1, 'btCreateGlosa');
                preserveCaretPosition(this, upper);
            }

        } else if (glosaBy === 'Porcentaje') {
            document.getElementById("valorGlosaInput").style.display = "none";
            document.getElementById("porcentajeGlosaInput").style.display = "block";
            document.getElementById("justificacion").style.display = "block";

            $('#cantidadGlosa').attr('required', false);
            $('#valorGlosa').attr('required', false);
            $('#totalGlosa').attr('required', false);
            $('#porcentajeGlosa').attr('required', true);
            $('#totalPorcentajeGlosa').attr('required', true);

            let porcentajeGlosa = document.getElementById('porcentajeGlosa');
            porcentajeGlosa.onkeyup = function () {
                validaNum('porcentajeGlosa', 1, 100, 1, 'btCreateGlosa');
                CalcularPorcentaje();
            }
            porcentajeGlosa.addEventListener('input', function () {
                validaNum('porcentajeGlosa', 1, 100, 1, 'btCreateGlosa');
                CalcularPorcentaje();
            });

            let textGlosa = document.getElementById('obsGlosa');
            textGlosa.onkeyup = function () {
                validaText('obsGlosa', 5, 2000, -1, 'btCreateGlosa');
                preserveCaretPosition(this, upper);
            }


        }
    })

    $.ajax({
        type: 'POST',
        url: 'ajax/pcm/listasParametricas.ajax.php',
        data: {
            lista: 'glosasTipo',
            tipoGlosa: tipoGlosaPar,
            uso: 'Item'
        },
    }).done(function (lista) {
        let json = JSON.parse(lista);
        let select = '<option value=""></option>';
        select += '<option value="TODOS">TODOS</option>';
        json.data.forEach(function (obj) {
            select += '<option value="' + obj.Tipo + '">' + obj.Tipo + '</option>';
            //console.log(select);
            $('#glosaType').html(select);
        });
        initialiceChoice('glosaType');
    }).fail(function () {
        alert('Hubo un error al cargar los tipos de glosas');
    });

    $('#glosaDescription').html('');

    $('#glosaType').on('change', function () {
        let glosaType = $(this).val();
    
        $.ajax({
            type: 'POST',
            url: 'ajax/pcm/listasParametricas.ajax.php',
            data: {
                lista: 'glosasDetalle',
                tipoGlosa: tipoGlosaPar,
                uso: 'Item',
                valor: glosaType
            },
        }).done(function (lista) {
            let json = JSON.parse(lista);
            
            const select = document.querySelector('#glosaDescription');
        
            // Destruir Choices antes de actualizar opciones
            if (select._choices) {
                select._choices.destroy();
            }
        
            // Limpiar opciones anteriores
            select.innerHTML = '';
        
            // Agregar opción vacía
            let option = new Option('', '', false, false);
            select.appendChild(option);
        
            // Agregar nuevas opciones
            json.data.forEach(function (obj) {
                let option = new Option(`${obj.Codigo_Glosa} - ${obj.Nota_Aclaratoria}`, obj.Nota_Aclaratoria, false, false);
                option.setAttribute('data-codigo', obj.Codigo_Glosa);
                select.appendChild(option);
            });
        
            // Reinicializar Choices
            initialiceChoice('glosaDescription');
        
        }).fail(function () {
            alert('Hubo un error al cargar las Glosas');
        });
        
    });
    

    $('#glosaDescription').on('change', function () {
        let notaGlosa = $(this).val();

        let ejm = document.querySelector('#glosaDescription');
        
        $('#codGlosa').val(ejm.textContent.split('-')[0].trim());
        //console.log(descripItem);
        notaGlosa = notaGlosa.replace("(XXX)", `(${descripItem})`);
        //console.log(notaGlosa);
        $('#obsGlosa').val(notaGlosa);

    })
})

function validacionCaracteres(obsGlosa, buttonElement, divElement){

    if(obsGlosa.toLowerCase().includes('xxx')){
        
        $(`#${divElement}`).html('<div class="alert alert-soft-danger"><i class="icon fa fa-ban"></i> <b>Resultado:</b> La Justificacion tiene caracteres (XXX) no permitidos por favor validar.</div>');
        document.getElementById(`${buttonElement}`).disabled = true;
        return 'error';

    }else{

        $(`#${divElement}`).html('');
        document.getElementById(`${buttonElement}`).disabled = false;
        return 'ok';

    }


}

$("#btCreateGlosa").click(function () {

    let formulario = document.getElementById("formCreateGlosaItem");
    let errores = 0;
    let elements = formulario.elements;
    Array.from(elements).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0 && glosaDescription !== '') {
        if (formulario.checkValidity()) {
            $("#btCreateGlosa").attr('disabled', true);
            let idItemModal = $('#idItemModal').val();
            let glosaType = $('#glosaType').val();
            let glosaDescription = $('#glosaDescription').val();
            let glosaBy = $('#glosaBy').val();
            let obsGlosa = $('#obsGlosa').val();
            let cantidadItemModal = Number($('#cantidadItemModal').val());
            let valorUniItemModal = Number($('#valorUniItemModal').val());
            let valorItemModal = Number($('#valorItemModal').val());
            let codGlosa = $('#codGlosa').val();
            let cantidadGlosa, valorGlosa, totalGlosa, tipoGlosa;

            let vali = validacionCaracteres(obsGlosa, 'btCreateGlosa', 'contenedorValidacionJustificacion');
            if(vali == 'error'){
                return;
            }

            if ($('#glosaBy').val() == 'Valor') {
                console.log('Crea Glosa Valor');
                tipoGlosa = $('#tipoGlosa').val();
                cantidadGlosa = Number($('#cantidadGlosa').val());
                valorGlosa = Number($('#valorGlosa').val());
                totalGlosa = Number($('#totalGlosa').val());
            } else if ($('#glosaBy').val() == 'Porcentaje') {
                console.log('Crea Glosa Porcentaje');
                tipoGlosa = $('#tipoGlosa').val() + ' ' + $('#porcentajeGlosa').val();
                cantidadGlosa = cantidadItemModal;
                valorGlosa = (valorUniItemModal * Number($('#porcentajeGlosa').val())) / 100;
                totalGlosa = cantidadGlosa * valorGlosa;
            } else {
                console.log('Error');
            }

            $.ajax({
                url: 'ajax/pcm/auditoria.ajax.php',
                type: 'POST',
                data: {
                    'option': 'crearGlosaItem',
                    'idItem': idItemModal,
                    'idReclamacion': idReclamacion,
                    'clasificacion': 'Item',
                    'codGlosa': codGlosa,
                    'glosaDescription': glosaDescription,
                    'justificacion': obsGlosa,
                    'usuario': sessionUser,
                    'tipoGlosa': tipoGlosa,
                    'cantidadItem': cantidadItemModal,
                    'valorUniItem': valorUniItemModal,
                    'valorItem': valorItemModal,
                    'cantidadGlosa': cantidadGlosa,
                    'valorGlosa': valorGlosa,
                    'totalGlosa': totalGlosa,
                },
                success: function (respuesta) {
                    if (respuesta === 'ok') {
                        toastr.success('Se ha creado una GLOSA ' + codGlosa);

                        calcularGlosa(idReclamacion, function () {
                            tableReclaGlosas.ajax.reload(null, false);
                            tableReclaDetail.ajax.reload(null, false);
                            reclamacionInfo(idReclamacion);
                        });

                    } else {
                        toastr.error('Hubo un error creando una GLOSA ' + codGlosa);

                        calcularGlosa(idReclamacion, function () {
                            tableReclaGlosas.ajax.reload(null, false);
                            tableReclaDetail.ajax.reload(null, false);
                            reclamacionInfo(idReclamacion);
                        });
                    }
                    $("#createGlosaUniModal").modal("hide");

                }

            })

            /* let data = {
                'glosaUni': '1',
                'idReclamacion': idReclamacion,
                'glosaBy' : glosaBy,
                'idItemModal': idItemModal,
                'glosaType': glosaType,
                'glosaDescription': glosaDescription,
                'cantidadGlosa': cantidadGlosa,
                'valorGlosa': valorGlosa,
                'totalGlosa': totalGlosa,
                'obsGlosa': obsGlosa,
                'cantidadItemModal': cantidadItemModal,
                'valorUniItemModal': valorUniItemModal,
                'valorItemModal': valorItemModal,
                'codGlosa': codGlosa,
                'tipoGlosa': tipoGlosa,
                'usuario': sessionUser
            };

            console.log(data); */
        }
    } else {
        console.log('Error en algun campo');
        toastr.error('Error algun campo en el Formulario esta vacio');
    }
});

const mayusculaValidText = (e) => {

    e.value = e.value.toUpperCase();
    validaText('obsGlosaRecla', 5, 2000, -1, 'btCreateGlosaRecla');

}

$(document).on("click", ".btnCreateGlosaReclamaModal", function () {
    //console.log('Create');
    $("#createGlosaRecModal").modal('show');
    //console.log('Glosa general');
    cleanForm("formCreateGlosaRecla");
    $('#btCreateGlosaRecla').attr('disabled', true);

    $('#titleModalCrearGlosaRecla').html('<b>Glosando Encabezado</b>');

    $.ajax({
        type: 'POST',
        url: 'ajax/pcm/listasParametricas.ajax.php',
        data: {
            lista: 'glosasTipo',
            tipoGlosa: tipoGlosaPar,
            uso: 'Encabezado'
        },
    }).done(function (lista) {
        let json = JSON.parse(lista);
        let select = '<option value=""></option>';
        select += '<option value="TODOS">TODOS</option>';
        json.data.forEach(function (obj) {
            select += '<option value="' + obj.Tipo + '">' + obj.Tipo + '</option>';
            //console.log(select);
            $('#glosaTypeRecla').html(select);
        });
        initialiceChoice('glosaTypeRecla');
    }).fail(function () {
        alert('Hubo un error al cargar los tipos de glosas');
    });
    $('#glosaDescriptionRecla').html('');

    $('#glosaTypeRecla').on('change', function () {

        let glosaTypeRecla = $(this).val();

        $.ajax({
            type: 'POST',
            url: 'ajax/pcm/listasParametricas.ajax.php',
            data: {
                lista: 'glosasDetalle',
                tipoGlosa: tipoGlosaPar,
                uso: 'Encabezado',
                valor: glosaTypeRecla
            },
        }).done(function (lista) {

            let json = JSON.parse(lista);

            const select = document.querySelector('#glosaDescriptionRecla');

            if (select._choices) {
                select._choices.destroy();
            }

            select.innerHTML = '';

            let option = new Option('', '', false, false);
            select.appendChild(option);

            json.data.forEach(function (obj) {
                let option = new Option(`${obj.Codigo_Glosa} - ${obj.Nota_Aclaratoria}`, obj.Nota_Aclaratoria, false, false);
                option.setAttribute('data-codigo', obj.Codigo_Glosa);
                select.appendChild(option);
            });

            initialiceChoice('glosaDescriptionRecla');

        }).fail(function () {
            alert('Hubo un error al cargar las Glosas');
        });
    })

    let textGlosa = document.getElementById('obsGlosaRecla');
    textGlosa.onkeyup = function () {
        validaText('obsGlosaRecla', 5, 2000, -1, 'btCreateGlosaRecla');
        preserveCaretPosition(this, upper);
    }

    $('#glosaDescriptionRecla').on('change', function () {
        let notaGlosa = $(this).val();

        //BUSCAR DESCRIPCION GLOSA
        let ejm = document.querySelector('#glosaDescriptionRecla');
        // let selectedOption = $(this).find('option:selected');
        // let codigo = selectedOption.data('codigo');
        $('#codGlosaRecla').val(ejm.textContent.split('-')[0].trim());
        $('#obsGlosaRecla').val(notaGlosa);
        validaText('obsGlosaRecla', 5, 2000, -1, 'btCreateGlosaRecla');


    })
})

$("#btCreateGlosaRecla").click(function () {

    let formulario = document.getElementById("formCreateGlosaRecla");
    let errores = 0;
    let elements = formulario.elements;
    Array.from(elements).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0 && glosaDescription !== '') {
        if (formulario.checkValidity()) {
            $("#btCreateGlosaRecla").attr('disabled', true);

            let glosaType = $('#glosaTypeRecla').val();
            let glosaDescription = $('#glosaDescriptionRecla').val();
            let obsGlosa = $('#obsGlosaRecla').val();
            let codGlosa = $('#codGlosaRecla').val();
            let tipoGlosa = $('#tipoGlosaRecla').val();

            let vali = validacionCaracteres(obsGlosa, 'btCreateGlosaRecla', 'contenedorValidacionJustificacionRecla');
            if(vali == 'error'){
                return;
            }

            $.ajax({
                url: 'ajax/pcm/auditoria.ajax.php',
                type: 'POST',
                data: {
                    'option': 'crearGlosaRecla',
                    'idReclamacion': idReclamacion,
                    'clasificacion': 'Encabezado',
                    'codGlosa': codGlosa,
                    'glosaDescription': glosaDescription,
                    'justificacion': obsGlosa,
                    'usuario': sessionUser,
                    'tipoGlosa': tipoGlosa,
                    'valorReclamado': valorReclamado
                },
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta === 'ok') {
                        toastr.success('Se ha creado una GLOSA ' + codGlosa);
                        calcularGlosa(idReclamacion, function () {
                            tableReclaGlosas.ajax.reload(null, false);
                            tableReclaDetail.ajax.reload(null, false);
                            reclamacionInfo(idReclamacion);
                        });
                    } else {
                        toastr.error('Hubo un error creando una GLOSA ' + codGlosa);
                        calcularGlosa(idReclamacion, function () {
                            tableReclaGlosas.ajax.reload(null, false);
                            tableReclaDetail.ajax.reload(null, false);
                            reclamacionInfo(idReclamacion);
                        });
                    }
                    $("#createGlosaRecModal").modal("hide");
                }

            })

            /* let data = {
                'glosaUni': '1',
                'idReclamacion': idReclamacion,
                'glosaBy' : glosaBy,
                'idItemModal': idItemModal,
                'glosaType': glosaType,
                'glosaDescription': glosaDescription,
                'cantidadGlosa': cantidadGlosa,
                'valorGlosa': valorGlosa,
                'totalGlosa': totalGlosa,
                'obsGlosa': obsGlosa,
                'cantidadItemModal': cantidadItemModal,
                'valorUniItemModal': valorUniItemModal,
                'valorItemModal': valorItemModal,
                'codGlosa': codGlosa,
                'tipoGlosa': tipoGlosa,
                'usuario': sessionUser
            };

            console.log(data); */
        }
    } else {
        console.log('Error en algun campo');
        toastr.error('Error algun campo en el Formulario esta vacio');
    }
});

$(document).on("click", ".btnDeleteGlosa", function () {
    var idGlosa = $(this).attr("idGlosa");
    $.ajax({
        url: 'ajax/pcm/auditoria.ajax.php',
        type: 'POST',
        data: {
            'option': 'glosaUniDelete',
            'idGlosa': idGlosa,
            'usuario': sessionUser
        },
        success: function (respuesta) {
            if (respuesta === 'ok') {
                toastr.success("¡Ud ha eliminado una GLOSA!", "Mensaje", { timeOut: 5000 });
                calcularGlosa(idReclamacion, function () {
                    tableReclaGlosas.ajax.reload(null, false);
                    tableReclaDetail.ajax.reload(null, false);
                    reclamacionInfo(idReclamacion);
                });
            } else {
                toastr.error('¡Hubo un error eliminado una GLOSA!', { timeOut: 5000 });
                calcularGlosa(idReclamacion, function () {
                    tableReclaGlosas.ajax.reload(null, false);
                    tableReclaDetail.ajax.reload(null, false);
                    reclamacionInfo(idReclamacion);
                });
            }
        }
    })
})

$("#btCloseRecla").click(function () {
    calcularGlosa(idReclamacion)
    $.ajax({
        url: 'ajax/pcm/auditoria.ajax.php',
        type: 'POST',
        data: {
            'option': 'reclamacionClose',
            'idReclamacion': idReclamacion,
            'idPerfil': idProfile,
            'usuario': sessionUser
        },
        success: function (respuesta) {
            if (respuesta === 'ok') {
                toastr.success("¡Ud ha cerrado una Cuenta!", "Mensaje", { timeOut: 5000 });
                setInterval(function () {
                    window.location = "index.php?ruta=pcm/audsearch&idProfile=" + btoa(idProfile) + "";
                }, 1000);
            } else {
                toastr.error('¡Hubo un error cerrando la Cuenta!', { timeOut: 5000 });
            }
        }
    })
})

$("#checkGlosaMasiva").click(function () {
    $(".checkGlosa").prop('checked', $(this).prop('checked'));
});

$("#checkDeleteMasiva").click(function () {
    $(".checkDelete").prop('checked', $(this).prop('checked'));
});

$(document).on("click", ".btnDeleteGlosasMasi", function () {

    var datos = new Array();

    $("input[name='deteleGlosa[]']:checked").each(function () {
        if ($(this).val() != 'on') {
            datos.push($(this).val());
        }
    });

    if (datos.length <= 0) {
        toastr.error('Error, No hay GLOSAS seleccionadas', { timeOut: 5000 })
    } else {
        //console.table(datos);
        $.ajax({
            url: 'ajax/pcm/auditoria.ajax.php',
            type: 'POST',
            data: {
                'option': 'glosaMasivoDelete',
                'idGlosas': datos,
                'usuario': sessionUser
            },
            success: function (respuesta) {
                //console.log(respuesta);
                if (respuesta === 'ok') {
                    toastr.success('Se han eliminado las GLOSAS ');
                    calcularGlosa(idReclamacion, function () {
                        tableReclaGlosas.ajax.reload(null, false);
                        tableReclaDetail.ajax.reload(null, false);
                        reclamacionInfo(idReclamacion);
                    });
                    $('#checkDeleteMasiva').prop('checked', false);
                } else {
                    toastr.error('Hubo un error eliminando las GLOSAS ');
                    calcularGlosa(idReclamacion, function () {
                        tableReclaGlosas.ajax.reload(null, false);
                        tableReclaDetail.ajax.reload(null, false);
                        reclamacionInfo(idReclamacion);
                    });
                }
            }
        })
    }

});

$(document).on("click", ".btnCreateGlosaMasivaRecModal", function () {

    var datos = new Array();

    $("input[name='createGlosa[]']:checked").each(function () {
        if ($(this).val() != 'on') {
            datos.push($(this).val());
        }
    });

    if (datos.length <= 0) {
        toastr.error('Error, No hay Items seleccionadas', { timeOut: 5000 })
    } else {
        //console.table(datos);
        $("#createGlosaMasivaModal").modal('show');
        cleanForm("formCreateGlosaMasivaItem");

        document.getElementById("valorMasivaGlosaInput").style.display = "none";
        document.getElementById("porcentajeMasivaGlosaInput").style.display = "none";
        document.getElementById("justificacionMasiva").style.display = "none";

        $('#titleModalCrearGlosaMasiva').html('<b>Glosa Masiva a ' + datos.length + ' items</b>');
        $("#idItemMasivoModal").val(datos);

        let glosaByMasivoSelect = '<option value=""></option>';
        glosaByMasivoSelect += '<option value="Valor">Valor - $</option>';
        glosaByMasivoSelect += '<option value="Porcentaje">Porcentaje - %</option>';
        $('#glosaMasivaBy').html(glosaByMasivoSelect);

        $('#glosaMasivaBy').on('change', function () {
            let glosaMasivaBy = $(this).val();
            if (glosaMasivaBy === 'Valor') {

                document.getElementById("valorMasivaGlosaInput").style.display = "block";
                document.getElementById("porcentajeMasivaGlosaInput").style.display = "none";
                document.getElementById("justificacionMasiva").style.display = "block";
                document.getElementById('tipoMasivoGlosa').value = 'valorM';

                $('#valorMasivaGlosa').attr('required', true);
                $('#porcentajeMasivaGlosa').attr('required', false);


                let valorMasivaGlosa = document.getElementById('valorMasivaGlosa');
                valorMasivaGlosa.max = "99999999";
                valorMasivaGlosa.onkeyup = function () {
                    validaNum('valorMasivaGlosa', 0.01, 99999999, 1, 'btCreateMasivaGlosa');
                }
                valorMasivaGlosa.addEventListener('input', function () {
                    validaNum('cantidadGlosa', 1, 99999999, 1, 'btCreateMasivaGlosa');
                });

                let textGlosa = document.getElementById('obsMasivoGlosa');
                textGlosa.onkeyup = function () {
                    validaText('obsMasivoGlosa', 5, 2000, -1, 'btCreateMasivaGlosa');
                    preserveCaretPosition(this, upper);
                }

            } else if (glosaMasivaBy === 'Porcentaje') {

                document.getElementById("valorMasivaGlosaInput").style.display = "none";
                document.getElementById("porcentajeMasivaGlosaInput").style.display = "block";
                document.getElementById("justificacionMasiva").style.display = "block";
                document.getElementById('tipoMasivoGlosa').value = 'PorcentajeM';

                $('#valorMasivaGlosa').attr('required', false);
                $('#porcentajeMasivaGlosa').attr('required', true);

                let porcentajeGlosa = document.getElementById('porcentajeMasivaGlosa');
                porcentajeGlosa.onkeyup = function () {
                    validaNum('porcentajeMasivaGlosa', 1, 100, 1, 'btCreateMasivaGlosa');
                }
                porcentajeGlosa.addEventListener('input', function () {
                    validaNum('porcentajeMasivaGlosa', 1, 100, 1, 'btCreateMasivaGlosa');
                });

                let textGlosa = document.getElementById('obsMasivoGlosa');
                textGlosa.onkeyup = function () {
                    validaText('obsMasivoGlosa', 5, 2000, -1, 'btCreateMasivaGlosa');
                    preserveCaretPosition(this, upper);
                }
            }
        })

        $.ajax({
            type: 'POST',
            url: 'ajax/pcm/listasParametricas.ajax.php',
            data: {
                lista: 'glosasTipo',
                tipoGlosa: tipoGlosaPar,
                uso: 'Item'
            },
        }).done(function (lista) {
            let json = JSON.parse(lista);
            let select = '<option value=""></option>';
            select += '<option value="TODOS">TODOS</option>';
            json.data.forEach(function (obj) {
                select += '<option value="' + obj.Tipo + '">' + obj.Tipo + '</option>';
                //console.log(select);
                $('#glosaMasivaType').html(select);
            });
            initialiceChoice('glosaMasivaType');
        }).fail(function () {
            alert('Hubo un error al cargar los tipos de glosas');
        });
        $('#glosaMasivaDescription').html('');

        $('#glosaMasivaType').on('change', function () {

            let glosaMasivaType = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'ajax/pcm/listasParametricas.ajax.php',
                data: {
                    lista: 'glosasDetalle',
                    tipoGlosa: tipoGlosaPar,
                    uso: 'Item',
                    valor: glosaMasivaType
                },
            }).done(function (lista) {

                let json = JSON.parse(lista);

                const select = document.querySelector('#glosaMasivaDescription');

                if (select._choices) {
                    select._choices.destroy();
                }

                select.innerHTML = '';

                let option = new Option('', '', false, false);
                select.appendChild(option);

                json.data.forEach(function (obj) {
                    let option = new Option(`${obj.Codigo_Glosa} - ${obj.Nota_Aclaratoria}`, obj.Nota_Aclaratoria, false, false);
                    select.appendChild(option);
                });
    
                initialiceChoice('glosaMasivaDescription');                

            }).fail(function () {
                alert('Hubo un error al cargar las Glosas');
            });
        })

        $('#glosaMasivaDescription').on('change', function () {

            let notaGlosa = $(this).val();
            let ejm = document.querySelector('#glosaMasivaDescription');
            $('#codMasivoGlosa').val(ejm.textContent.split('-')[0].trim());
            $('#obsMasivoGlosa').val(notaGlosa);

        })

    }

});

$("#btCreateMasivaGlosa").click(function () {

    let formulario = document.getElementById("formCreateGlosaMasivaItem");
    let errores = 0;
    let elements = formulario.elements;
    Array.from(elements).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0 && glosaMasivaDescription !== '') {
        if (formulario.checkValidity()) {
            $("#btCreateMasivaGlosa").attr('disabled', true);
            let idItemMasivoModal = $('#idItemMasivoModal').val();
            let codMasivoGlosa = $('#codMasivoGlosa').val();
            let tipoMasivoGlosa = $('#tipoMasivoGlosa').val();
            let glosaMasivaType = $('#glosaMasivaType').val();
            let glosaMasivaDescription = $('#glosaMasivaDescription').val();
            let glosaMasivaBy = $('#glosaMasivaBy').val();
            let obsMasivoGlosa = $('#obsMasivoGlosa').val();
            let valorMasivaGlosa = $('#valorMasivaGlosa').val();
            let porcentajeMasivaGlosa = $('#porcentajeMasivaGlosa').val();

            let vali = validacionCaracteres(obsMasivoGlosa, 'btCreateMasivaGlosa', 'contenedorValidacionJustificacionMasiva');
            if(vali == 'error'){
                return;
            }

            $.ajax({
                url: 'ajax/pcm/auditoria.ajax.php',
                type: 'POST',
                data: {
                    'option': 'crearGlosaMasivoItem',
                    'idReclamacion': idReclamacion,
                    'clasificacion': 'Item',
                    'idItemMasivoModal': idItemMasivoModal,
                    'codMasivoGlosa': codMasivoGlosa,
                    'glosaMasivaDescription': glosaMasivaDescription,
                    'obsMasivoGlosa': obsMasivoGlosa,
                    'usuario': sessionUser,
                    'tipoMasivoGlosa': tipoMasivoGlosa,
                    'valorMasivaGlosa': valorMasivaGlosa,
                    'porcentajeMasivaGlosa': porcentajeMasivaGlosa,

                },
                success: function (respuesta) {
                    if (respuesta === 'ok') {
                        toastr.success('Se han creado las GLOSAS ' + codMasivoGlosa);

                        calcularGlosa(idReclamacion, function () {
                            tableReclaGlosas.ajax.reload(null, false);
                            tableReclaDetail.ajax.reload(null, false);
                            reclamacionInfo(idReclamacion);
                        });
                        $('#checkGlosaMasiva').prop('checked', false);

                    } else {
                        toastr.error('Hubo un error creando las GLOSAS ' + codMasivoGlosa);

                        calcularGlosa(idReclamacion, function () {
                            tableReclaGlosas.ajax.reload(null, false);
                            tableReclaDetail.ajax.reload(null, false);
                            reclamacionInfo(idReclamacion);
                        });
                    }
                    $("#createGlosaMasivaModal").modal("hide");

                }

            })

            /* let data = {
                'glosaUni': '1',
                'glosaMasivaType': glosaMasivaType,
                'glosaMasivaDescription': glosaMasivaDescription,
                'glosaMasivaByNO': glosaMasivaBy,
                'valorMasivaGlosa': valorMasivaGlosa,
                'porcentajeMasivaGlosa': porcentajeMasivaGlosa,
                'obsMasivoGlosa': obsMasivoGlosa,
                'idItemMasivoModal': idItemMasivoModal,
                'codMasivoGlosa': codMasivoGlosa,
                'tipoMasivoGlosa': tipoMasivoGlosa,
                'usuario': sessionUser
            };

            console.table(data); */
        }
    } else {
        console.log('Error en algun campo');
        toastr.error('Error algun campo en el Formulario esta vacio');
    }
});

function guardarAnotacion() {

    let Anotacion_Observacion = document.getElementById("obsAnotacion").value;
    let NumeroRadicacionAnotacion = document.getElementById("NumeroRadicacionAnotacion").value;

    $.ajax({
        url: 'ajax/pcm/auditoria.ajax.php',
        type: 'POST',
        data: {
            'option': 'añadirAnotacion',
            'idReclamacion': idReclamacion,
            'Anotacion_Observacion': Anotacion_Observacion,
            'Usuario_Creacion': sessionUser,
            'Numero_Radicacion': NumeroRadicacionAnotacion
        },
        success: function (respuesta) {
            if (respuesta === 'ok') {
                toastr.success('Se ha creado una anotacion');

                $("#createAnotacion").modal('hide');

                $('a[href="#Anotaciones"]').tab('show');

                if ($('#tableAnotaciones').DataTable()) {
                    $('#tableAnotaciones').DataTable().ajax.reload(null, false);
                }


            } else {
                toastr.error('Hubo un error creando la anotacion ');

            }
        }

    })


}

$('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href"); // Obtiene el id de la pestaña activa
    if (target === "#Anotaciones") {

        var tableAnotaciones = $('#tableAnotaciones').DataTable({
            destroy: true,
            pageLength: 50,
            columns: [
                { name: 'Anotacion Id', data: 'Anotacion_Id' },
                { name: 'Reclamacion Id', data: 'Reclamacion_Id' },
                { name: 'Numero Radicacion', data: 'Numero_Radicacion' },
                { name: 'Anotaciones', data: 'Anotacion_Observacion' },
                { name: 'Usuario', data: 'Usuario_Creacion' },
                { name: 'Fecha', data: 'Fecha_Creacion' },
                {
                    name: 'Opciones', orderable: false, render: function (data, type, row) {

                        return `<button type="button" class="btn btn-round btn-danger btnDeleteAnotacion" title="Borrar" data-id="${row.Anotacion_Id}" ><i class="fa-solid fa-eraser"></i></button>`;
                    }
                }

            ],
            ajax: {
                url: 'ajax/pcm/auditoria.ajax.php',
                type: 'POST',
                data: {
                    'option': 'TablaAnotacion',
                    'idReclamacion': idReclamacion
                }
            },
            buttons: [{
                text: 'Agregar Anotacion <i class="fa fa-plus-square"></i>',
                className: 'btn btn-outline-success m-1',
                action: function (e, dt, node, config) {
                    $("#createAnotacion").modal('show');
                    let NumeroRadicacion = document.querySelector('#numRadica');
                    cleanForm("formCreateAnotacion");
                    $("#NumeroRadicacionAnotacion").val(NumeroRadicacion.textContent);
                }
            }],
            dom: "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",


        });
        $('#tableAnotaciones').on('click', '.btnDeleteAnotacion', function () {
            let AnotacionId = $(this).data('id');
            $.ajax({
                url: 'ajax/pcm/auditoria.ajax.php',
                type: 'POST',
                data: {
                    'option': 'eliminarAnotacion',
                    'Anotacion_Id': AnotacionId,
                    'Usuario_Eliminacion': sessionUser
                },
                success: function (respuesta) {

                    if (respuesta === 'Eliminado') {
                        toastr.success('Anotación eliminada exitosamente');
                        tableAnotaciones.ajax.reload(null, false); // Recargar la tabla
                    } else {
                        toastr.error('Error eliminando la anotación');
                    }
                }
            });
        });
    }else if(target === "#infoReclamacionXml"){

        $.ajax({
            url: 'ajax/pcm/auditoria.ajax.php',
            type: 'POST',
            data: {
                option: 'reclamacionInfoXml',
                idReclamacion: idReclamacion
            },
            dataType: 'json',
            success: function (respuesta) {

                if (!Array.isArray(respuesta)) respuesta = [respuesta];
                crearAccordionXml(respuesta);

            }

        })

    }
});

function crearAccordionXml(respuesta){
    let accordion = '';                
    let parentId = 'accordionXml';
    let index = 0;

    respuesta.forEach(xml => {

        const valorImpuesto = parseFloat(xml.iva || 0);
        const valorDesc = parseFloat(xml.descuentos || 0);
        const valorCopago = parseFloat(xml.total_copago || 0);
        let valorTotal = parseFloat(xml.total_pagar || 0);
        let xmlNombre;
        if(xml.nit_adquiere == '901037916'){
            xmlNombre = 'XML RECLAMACION';
        }else{
            xmlNombre = 'XML MAOS';

        }

        if (!valorTotal) { valorTotal = parseFloat(xml.Total_Reclamado); }

        const idCollapse = `collapseXml${index}`;
        const idCard = `headingXml${index}`;

        accordion += `
            <div class="card border border-300 mb-2">
                <div class="card-header p-1" id="${idCard}">
                    <h6 class="mb-0">
                        <button class="btn btn-link font-weight-bold" type="button"
                                data-bs-toggle="collapse" data-bs-target="#${idCollapse}"
                                aria-expanded="false"
                                aria-controls="${idCollapse}">
                            ${xmlNombre}
                        </button>
                    </h6>
                </div>
                <div id="${idCollapse}" class="collapse"
                        aria-labelledby="${idCard}" data-bs-parent="#${parentId}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Nro Radicacion</label>
                                <br><div>${xml.Numero_Radicacion}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Cuenta ID</label>
                                <div>${xml.reclamacion_id}</div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Fecha Radicación</label>
                                <br><div>${xml.Fecha_Radicacion_Consolidado}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Fecha Emision</label>
                                <br><div>${xml.fecha_emision}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Razon Social Reclamante</label>
                                <br><div>${xml.nombre_emisor}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Doc Reclamante</label>
                                <br><div>NIT-${xml.nit_emisor}</div>
                            </div>
                        </div><br/>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Razon Social Adquiere</label>
                                <br><div>NIT-${xml.nombre_adquiere}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Doc Adquiere</label>
                                <br><div>NIT-${xml.nit_adquiere}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Nro Factura</label>
                                <br><div>${xml.numero_factura}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Valor (Impuesto Incluido)</label>
                                <br><div>${formatNumber(valorImpuesto)}</div>
                            </div>
                        </div><br/>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Descuentos</label>
                                <br><div>${formatNumber(valorDesc)}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Valor Copago</label>
                                <br><div>${formatNumber(valorCopago)}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Valor Total</label>
                                <br><div>${formatNumber(valorTotal)}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold" style="color: black;">Cufe</label>
                                <br><div>${xml.cufe}</div>
                            </div>
                        </div><br/>
                    </div> <!-- card-body -->
                </div> <!-- collapse -->
            </div>`;
        index++;
    });
    $('#'+parentId).html(accordion);
}

try {
    const idReclamacion = atob(getParameterByName('idReclamacion'));
} catch (error) {
    console.error("Error decodificando la cadena: ", error);
    toastr.error("¡Error de perfil, Sera direccionado al inicio", "Mensaje", { timeOut: 5000 });
    setInterval(function () {
        window.location = "inicio";
    }, 1000);

}

//$('#Cruces').html('Cruces js'+idReclamacion);

$('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href"); // Obtiene el id de la pestaña activa
    console.log(target);
    if (target === "#Cruces") {
        var tableHtml = '';
        var buttomHtml = '';
        var totalHtml = '';

        $.ajax({
            url: 'ajax/pcm/cruces.ajax.php',
            type: 'POST',
            data: {
                'option': 'cruceRenc',
                'idReclamacion': idReclamacion
            },
            dataType: 'json',
            success: function (respuesta) {

                if (respuesta.recordsTotal > 0) {
                    buttomHtml += ` <button class="btn btn-primary my-1" type="button" data-bs-toggle="collapse" href="#renec" aria-expanded="true" aria-controls="collapseExample">
                                        RENEC
                                    </button>`;
                    tableHtml += ` <div class="collapse" id="renec">
                                        <div class="card card-body table-responsive mb-2">
                                            <h5 class="card-title">RENEC</h5>
                                            <table id="tablaRnec" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo</th>
                                                        <th>Tipo Doc</th>
                                                        <th>Num Doc</th>
                                                        <th>Primer Nombre</th>
                                                        <th>Segundo Nombre</th>
                                                        <th>Primer Apellido</th>
                                                        <th>Segundo Apellido</th>
                                                        <th>Teléfono</th>
                                                        <th>Observación</th>
                                                        <th>Fecha de Fallecido</th>
                                                        <th>Fecha de Nacimiento</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        `;
                    // Itera sobre cada objeto en el array "data"
                    respuesta.data.forEach(function (item) {
                        tableHtml += `
                        <tr>
                            <td>${item.Tipo}</td>
                            <td>${item.Tipo_Documento}</td>
                            <td>${item.Numero_Documento}</td>
                            <td>${item.primer_nombre}</td>
                            <td>${item.segundo_nombre}</td>
                            <td>${item.primer_apellido}</td>
                            <td>${item.segundo_apellido}</td>
                            <td>${item.telefono}</td>
                            <td>${item.observacion}</td>
                            <td>${item.FECHA_FALLECIDO_rnec ? item.FECHA_FALLECIDO_rnec.split(' ')[0] : ''}</td>
                            <td>${item.FECHA_NACIMIENTO_rnec ? item.FECHA_NACIMIENTO_rnec.split(' ')[0] : ''}</td>
                        </tr>
                    `;
                    });
                    // Cierra el tbody y la tabla
                    tableHtml += `          </tbody>
                                        </table>
                                    </div>
                                </div>`;
                }
                updateCrucesContent(); // Llama a la función para actualizar el contenido después de este AJAX

            },
            error: function (err) {
                console.error("Error en la llamada AJAX:", err);
                // Manejo de errores aquí si es necesario
            }
        });

        $.ajax({
            url: 'ajax/pcm/cruces.ajax.php',
            type: 'POST',
            data: {
                'option': 'cruceRepsHabili',
                'idReclamacion': idReclamacion
            },
            dataType: 'json',
            success: function (respuesta) {
                //console.log(respuesta);
                if (respuesta.recordsTotal > 0) {
                    buttomHtml += ` <button class="btn btn-warning my-1" type="button" data-bs-toggle="collapse" href="#RepsHabi" aria-expanded="true" aria-controls="collapseExample">
                                        Reps Habilitacion
                                    </button>`;
                    tableHtml += ` <div class="collapse" id="RepsHabi">
                                        <div class="card card-body table-responsive mb-2">
                                            <h5 class="card-title">RESP HABILITACION</h5>
                                            <table id="tablaRepsHabi" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo Doc</th>
                                                        <th>Num Doc</th>
                                                        <th>Nombre</th>
                                                        <th>Fecha Ingreso</th>
                                                        <th>Fecha Apertura</th>
                                                        <th>Fecha Vencimiento</th>
                                                        <th>Observación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        `;
                    // Itera sobre cada objeto en el array "data"
                    respuesta.data.forEach(function (item) {
                        tableHtml += `
                        <tr>
                            <td>${item.Tipo_Documento_Reclamante}</td>
                            <td>${item.Numero_Documento_Reclamante}</td>
                            <td>${item.Nombre_Reclamante}</td>
                            <td>${item.Fecha_Ingreso}</td>
                            <td>${item.Fecha_Apertura}</td>
                            <td>${item.Fecha_Vencimiento}</td>
                            <td>${item.observacion}</td>
                        </tr>
                    `;
                    });
                    // Cierra el tbody y la tabla
                    tableHtml += `          </tbody>
                                        </table>
                                    </div>
                                </div>`;
                }
                updateCrucesContent(); // Llama a la función para actualizar el contenido después de este AJAX

            },
            error: function (err) {
                console.error("Error en la llamada AJAX:", err);
                // Manejo de errores aquí si es necesario
            }
        })

        $.ajax({
            url: 'ajax/pcm/cruces.ajax.php',
            type: 'POST',
            data: {
                'option': 'cruceRepsProced',
                'idReclamacion': idReclamacion
            },
            dataType: 'json',
            success: function (respuesta) {

                if (respuesta.recordsTotal > 0) {
                    buttomHtml += ` <button class="btn btn-danger my-1" type="button" data-bs-toggle="collapse" href="#RepsProce" aria-expanded="true" aria-controls="collapseExample">
                                        Reps Procedimiento
                                    </button>`;
                    tableHtml += ` <div class="collapse" id="RepsProce">
                                        <div class="card card-body table-responsive mb-2">
                                            <h5 class="card-title">RESP PROCEDIMIENTO</h5>
                                            <table id="tablaRepsProce" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Elemento</th>
                                                        <th>Número de Radicación</th>
                                                        <th>Código de Habilitación</th>
                                                        <th>Reclamación ID</th>
                                                        <th>Número de Factura Cuenta</th>
                                                        <th>Código</th>
                                                        <th>Descripción</th>
                                                        <th>Valor Total Reclamado</th>
                                                        <th>Cantidad Reclamada</th>
                                                        <th>Valor Unitario</th>
                                                        <th>Tipo de Documento de Víctima</th>
                                                        <th>Número de Documento de Víctima</th>
                                                        <th>Fecha de Ingreso</th>
                                                        <th>Fecha de Egreso</th>
                                                        <th>Observación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        `;
                    // Itera sobre cada objeto en el array "data"
                    respuesta.data.forEach(function (item) {
                        tableHtml += `
                        <tr>
                            <td>${item.elemento}</td>
                            <td>${item.Numero_Radicacion}</td>
                            <td>${item.Codigo_Habilitacion}</td>
                            <td>${item.reclamacionID}</td>
                            <td>${item.Numero_Factura_Cuenta}</td>
                            <td>${item.codigo}</td>
                            <td>${item.descripcion}</td>
                            <td>${item.valor_total_reclamado}</td>
                            <td>${item.cantidad_reclamada}</td>
                            <td>${item.valor_unitario}</td>
                            <td>${item.tipo_doc_victima}</td>
                            <td>${item.numero_doc_victima}</td>
                            <td>${item.fecha_ingreso}</td>
                            <td>${item.fecha_egreso}</td>
                            <td>${item.Observacion}</td>
                        </tr>
                    `;
                    });
                    // Cierra el tbody y la tabla
                    tableHtml += `          </tbody>
                                        </table>
                                    </div>
                                </div>`;

                }
                updateCrucesContent(); // Llama a la función para actualizar el contenido después de este AJAX
            },
            error: function (err) {
                console.error("Error en la llamada AJAX:", err);
                // Manejo de errores aquí si es necesario
            }

        })

        $.ajax({
            url: 'ajax/pcm/cruces.ajax.php',
            type: 'POST',
            data: {
                'option': 'cruceRepsTrans',
                'idReclamacion': idReclamacion
            },
            dataType: 'json',
            success: function (respuesta) {

                if (respuesta.recordsTotal > 0) {
                    buttomHtml += ` <button class="btn btn-secondary my-1" type="button" data-bs-toggle="collapse" href="#RepsTrans" aria-expanded="true" aria-controls="collapseExample">
                                        Reps Transporte
                                    </button>`;
                    tableHtml += ` <div class="collapse" id="RepsTrans">
                                        <div class="card card-body table-responsive mb-2">
                                            <h5 class="card-title">RESP TRANSPORTE</h5>
                                            <table id="tablaRepsTrans" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Elemento</th>
                                                        <th>Número de Radicación</th>
                                                        <th>Código de Habilitación</th>
                                                        <th>Reclamación ID</th>
                                                        <th>Número de Factura Cuenta</th>
                                                        <th>Código</th>
                                                        <th>Descripción</th>
                                                        <th>Valor Total Reclamado</th>
                                                        <th>Cantidad Reclamada</th>
                                                        <th>Valor Unitario</th>
                                                        <th>Item ID</th>
                                                        <th>Tipo de Documento de Víctima</th>
                                                        <th>Número de Documento de Víctima</th>
                                                        <th>Fecha Traslado</th>
                                                        <th>Fecha Apertura</th>
                                                        <th>Fecha Cierre</th>
                                                        <th>Observación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        `;
                    // Itera sobre cada objeto en el array "data"
                    respuesta.data.forEach(function (item) {
                        tableHtml += `
                        <tr>
                            <td>${item.elemento}</td>
                            <td>${item.Numero_Radicacion}</td>
                            <td>${item.Codigo_Habilitacion}</td>
                            <td>${item.reclamacionID}</td>
                            <td>${item.Numero_Factura_Cuenta}</td>
                            <td>${item.codigo}</td>
                            <td>${item.descripcion}</td>
                            <td>${item.valor_total_reclamado}</td>
                            <td>${item.Cantidad_reclamada}</td>
                            <td>${item.Valor_Unitario}</td>
                            <td>${item.itemid}</td>
                            <td>${item.tipo_doc_victima}</td>
                            <td>${item.numero_doc_victima}</td>
                            <td>${item.Fecha_Traslado}</td>
                            <td>${item.FECHA_APERTURA_SERVICIO}</td>
                            <td>${item.FECHA_CIERRE_SERVICIO}</td>
                            <td>${item.Observacion}</td>
                        </tr>
                    `;
                    });
                    // Cierra el tbody y la tabla
                    tableHtml += `          </tbody>
                                        </table>
                                    </div>
                                </div>`;

                }
                updateCrucesContent(); // Llama a la función para actualizar el contenido después de este AJAX
            },
            error: function (err) {
                console.error("Error en la llamada AJAX:", err);
                // Manejo de errores aquí si es necesario
            }
        })

        $.ajax({
            url: 'ajax/pcm/cruces.ajax.php',
            type: 'POST',
            data: {
                'option': 'crucePoliza',
                'idReclamacion': idReclamacion
            },
            dataType: 'json',
            success: function (respuesta) {

                if (respuesta.recordsTotal > 0) {
                    buttomHtml += ` <button class="btn btn-success my-1" type="button" data-bs-toggle="collapse" href="#crucePoliza" aria-expanded="true" aria-controls="collapseExample">
                                        Polizas
                                    </button>`;
                    tableHtml += ` <div class="collapse" id="crucePoliza">
                                        <div class="card card-body table-responsive mb-2">
                                            <h5 class="card-title">POLIZAS</h5>
                                            <table id="tablaCrucePoliza" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Número de Documento Reclamante</th>
                                                        <th>Nombre Reclamante</th>
                                                        <th>Total Reconocido Gastos Médicos</th>
                                                        <th>Código de Aseguradora</th>
                                                        <th>Número de Póliza</th>
                                                        <th>Fecha de Inicio</th>
                                                        <th>Fecha de Vencimiento</th>
                                                        <th>Placa</th>
                                                        <th>Documento Tomador</th>
                                                        <th>Nombres Tomador</th>
                                                        <th>Observación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        `;
                    // Itera sobre cada objeto en el array "data"
                    respuesta.data.forEach(function (item) {
                        tableHtml += `
                        <tr>
                            <td>${item.Numero_Documento_Reclamante}</td>
                            <td>${item.Nombre_Reclamante}</td>
                            <td>${item.Total_Reconocido_Gastos_Medicos}</td>
                            <td>${item.Codigoaseguradora}</td>
                            <td>${item.NumeroPoliza}</td>
                            <td>${item.FechaInicio}</td>
                            <td>${item.FechaVencimiento}</td>
                            <td>${item.placa}</td>
                            <td>${item.tipo_doc_tomador + item.num_doc_tomador}</td>
                            <td>${item.nombres_apellidos_tomador}</td>
                            <td>${item.observacion}</td>
                        </tr>
                    `;
                    });
                    // Cierra el tbody y la tabla
                    tableHtml += `          </tbody>
                                        </table>
                                    </div>
                                </div>`;

                }
                updateCrucesContent(); // Llama a la función para actualizar el contenido después de este AJAX
            },
            error: function (err) {
                console.error("Error en la llamada AJAX:", err);
                // Manejo de errores aquí si es necesario
            }
        })

        $.ajax({
            url: 'ajax/pcm/cruces.ajax.php',
            type: 'POST',
            data: {
                'option': 'cruceSiniestro',
                'idReclamacion': idReclamacion
            },
            dataType: 'json',
            success: function (respuesta) {

                if (respuesta.recordsTotal > 0) {
                    buttomHtml += ` <button class="btn btn-info my-1" type="button" data-bs-toggle="collapse" href="#cruceSiniestro" aria-expanded="true" aria-controls="collapseExample">
                                        Siniestros
                                    </button>`;
                    tableHtml += ` <div class="collapse" id="cruceSiniestro">
                                        <div class="card card-body table-responsive mb-2">
                                            <h5 class="card-title">SINIESTROS</h5>
                                            <table id="tablaCrucePoliza" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Documento Reclamante</th>
                                                        <th>Nombre Reclamante</th>
                                                        <th>Gastos Medicos</th>
                                                        <th>Gastos Transporte</th>
                                                        <th>Num Iden Recla</th>
                                                        <th>Nombre Juridico</th>
                                                        <th>Poliza</th>
                                                        <th>Aseguradora</th>
                                                        <th>Fecha Evento</th>
                                                        <th>Fecha Atencion</th>
                                                        <th>Pagado Funerarios</th>
                                                        <th>Pagado Incapacidad</th>
                                                        <th>Pagado Muerte</th>
                                                        <th>Pagado Medico</th>
                                                        <th>Pagado Transporte</th>
                                                        <th>Placa</th>
                                                        <th>Doc Tomador</th>
                                                        <th>Nombre Tomador</th>
                                                        <th>Observación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        `;
                    // Itera sobre cada objeto en el array "data"
                    respuesta.data.forEach(function (item) {
                        tableHtml += `
                        <tr>
                            <td>${item.Tipo_Documento_Reclamante + item.Numero_Documento_Reclamante}</td>
                            <td>${item.Nombre_Reclamante}</td>
                            <td>${item.Gastos_Medicos_reclamados}</td>
                            <td>${item.Gastos_transporte_reclamados}</td>
                            <td>${item.NumeroIdentificacionRecla}</td>
                            <td>${item.nombrejuridico}</td>
                            <td>${item.NumeroPoliza}</td>
                            <td>${item.CodigoAseguradora + '-' + item.aseguradora}</td>
                            <td>${item.FechaEvento}</td>
                            <td>${item.FechaAtencion}</td>
                            <td>${item.valor_pagado_gastos_funerarios}</td>
                            <td>${item.valor_pagado_incapacidad}</td>
                            <td>${item.valor_pagado_muerte}</td>
                            <td>${item.valor_pagado_servicios_medicos}</td>
                            <td>${item.valor_pagado_transporte}</td>
                            <td>${item.placa}</td>
                            <td>${item.tipo_doc_tomador + item.num_doc_tomador}</td>
                            <td>${item.nombres_apellidos_tomador}</td>
                            <td>${item.Resultado_Validacion}</td>
                        </tr>
                    `;
                    });
                    // Cierra el tbody y la tabla
                    tableHtml += `          </tbody>
                                        </table>
                                    </div>
                                </div>`;

                }
                updateCrucesContent(); // Llama a la función para actualizar el contenido después de este AJAX
            },
            error: function (err) {
                //console.error("Error en la llamada AJAX:", err);
                // Manejo de errores aquí si es necesario
            }
        })




        function updateCrucesContent() {
            $('#Cruces').html(`
                <div class="row">
                    <div class="col-12">
                        ${buttomHtml}
                    </div>
                </div>
                ${tableHtml}
            `);
        }



    }
});

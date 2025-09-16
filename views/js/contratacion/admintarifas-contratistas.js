function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let idContratista = atob(getParameterByName('idContratista'));
let idContrato = atob(getParameterByName('idContrato'));
let idTarifario = atob(getParameterByName('idTarifario'));

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

const obtenerInfoContrato = async (idContratista, idContrato) => {

    let datos = new FormData();
    datos.append('proceso','infoContratoContratista');
    datos.append('idContratista', idContratista);
    datos.append('idContrato', idContrato);

    const infoContrato = await $.ajax({
        url: 'ajax/contratacion/contratistas.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!infoContrato){

        console.error("No Existe Contratista"); 
        return;
    }

    return infoContrato;

}

const obtenerInfoTarifario = async (idTarifario) => {

    let datos = new FormData();
    datos.append('proceso','infoTarifario');
    datos.append('idTarifario', idTarifario);

    const infoTarifario = await $.ajax({
        url: 'ajax/contratacion/contratistas.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!infoTarifario){

        console.error("No Existe Tarifario"); 
        return;
    }

    return infoTarifario;

}

const crearTarifa = () => {

    let formulario = document.getElementById("formCrearTarifa");
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

            const formData = new FormData(formulario);

            formData.append('proceso', 'crearTarifaUnitaria');
            formData.append('idTarifario', idTarifario);
            formData.append('userCreate', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/contratacion/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Tarifa se registro correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                // listaParTarifasPrestador.ajax.reload();
                                $('#tTipoTarifa').val('').trigger('change');
                                formulario.reset();
                                listaTarifasTarifario.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡La Tarifa no se registro correctamente!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const eliminarTarifaUnitaria = (idTarifa) => {

    Swal.fire({
        title: "¿Desea eliminar la Tarifa?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if(result.isConfirmed){

            const formData = new FormData();
            formData.append('proceso', 'eliminarTarifaUnitaria');
            formData.append('idTarifa', idTarifa);
            formData.append('userCreate', userSession);

            $.ajax({

                url: 'ajax/contratacion/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({

                            text: '¡La Tarifa se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){
                                
                                listaTarifasTarifario.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'La Tarifa no se elimino correctamente',
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

const cargarArchivoMasivoTarifas = () => {

    let formulario = document.getElementById("formCargarArchivoTarifa");
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

            const formData = new FormData(formulario);
            
            formData.append('proceso', 'cargarArchivoTarifasMasivo');
            formData.append('idTarifario', idTarifario);
            formData.append('userCreate', userSession);


            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            loadingFnc();

            $.ajax({

                url: 'ajax/contratacion/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    Swal.close();

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡El Archivo de Tarifas Masivo se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                formulario.reset();
                                listaArchivosMasivosTarifas.ajax.reload();

                            }

                        })

                    }else if(respuesta == 'error-estructura'){

                        Swal.fire({
                            text: '¡El Archivo de Tarifas no cumple con la estructura establecida (J) 10 Columnas!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                formulario.reset();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡El Archivo de Tarifas no se pudo cargar correctamente!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

listaTarifasTarifario = $('#listaTarifasTarifario').DataTable({

    columns: [
        { title: '#', data: 'id_tarifa' },
        { title: 'TIPO TARIFA', data: 'tipo_tarifa'},
        { title: 'CODIGO', data: 'codigo'},
        { title: 'CODIGO NORMALIZADO', data: 'codigo_normalizado'},
        { title: 'REGISTRO SANITARIO', data: 'registro_sanitario'},
        { title: 'TARIFA PACTADA', data: 'tarifa_pactada'},
        { title: 'TARIFA REGULACION', data: 'tarifa_regulacion'},
        { title: 'VIGENCIA', render: function(data, type, row){
            return `<span class="badge badge-phoenix badge-phoenix-success">${row.fecha_inicio_vigencia}</span> - <span class="badge badge-phoenix badge-phoenix-danger">${row.fecha_fin_vigencia}</span>`;
        }},
        { title: 'DESCRIPCION', render: function(data, type, row){
            return `<textarea class="form-control" rows="4">${row.descripcion_tarifa}</textarea>`;
        }},
        { title: 'PRODUCTO', render: function(data, type, row){
            return `<textarea class="form-control" rows="4">${row.producto}</textarea>`;
        }},
        {
            title: 'OPCIONES', orderable: false, data: null, render: function (data, type, row) {
                return `
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarTarifaUnitaria(${row.id_tarifa})" title="Eliminar Tarifa"><i class="far fa-trash-alt"></i></button>
                `;
                    
               
            }
        }
    ],
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excel',
            text: 'Descargar Excel',
            className: 'btn btn-phoenix-success',
        },
    ],
    ajax: {
        url: 'ajax/contratacion/contratistas.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaTarifasTarifario',
            idTarifario: idTarifario
        }
    }

});


listaArchivosMasivosTarifas = $('#listaArchivosMasivosTarifas').DataTable({

    columns: [
        { title: '#', data: 'id_archivo_tarifas' },
        { title: 'NOMBRE ARCHIVO', data: 'nombre_archivo'},
        { title: 'ARCHIVO', render: function(data, type, row){
            return `<a download href="${row.ruta_archivo}"><span class="badge badge-phoenix badge-phoenix-success" style="font-size: 30px;"><i class="far fa-file-excel"></i></span></a>`;
        }},
        { title: 'ESTADO', data: 'estado', render: function(data){
            if(data == 'SUBIDA'){
                return `<span class="badge badge-phoenix badge-phoenix-warning">${data}</span>`;
            }else if(data == 'ERROR' || data == 'ERROR_CARGA'){
                return `<span class="badge badge-phoenix badge-phoenix-danger">${data}</span>`;
            }else if(data == 'PROCESANDO' || data == 'VALIDANDO' || data == 'CARGANDO' || data == 'CARGAR'){
                return `<span class="badge badge-phoenix badge-phoenix-info">${data}</span>`;
            }else{
                return `<span class="badge badge-phoenix badge-phoenix-success">${data}</span>`;
            }
        }},
    ],
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excel',
            text: 'Descargar Excel',
            className: 'btn btn-phoenix-success',
        },
    ],
    ajax: {
        url: 'ajax/contratacion/contratistas.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaArchivosMasivosTarifas',
            idTarifario: idTarifario
        }
    }

});

(async () => {

    if (idContratista && idContrato){

        let datosContrato = await obtenerInfoContrato(idContratista, idContrato);
        let tarifario = await obtenerInfoTarifario(idTarifario); 

        // console.log(datosContrato)

        if(datosContrato && tarifario){

            $('#titlePage').text('Administrar Tarifario Contratista: ' + datosContrato.nombre_contratistas + ' - Contrato: ' + datosContrato.nombre_contrato + ' - Tarifario: ' + tarifario.nombre_tarifa);
            $('#textTipoContratista').text(datosContrato.tipo_contratista_full);
            $('#textNombreContratista').text(datosContrato.nombre_contratistas);
            $('#textTipoIdentiContratista').text(datosContrato.tipo_identi_contratistas + ' - ' + datosContrato.tipo_documento_contratista);
            $('#textNumeroIdentiContratista').text(datosContrato.numero_identi_contratistas);
            $('#textDireccionContratista').text(datosContrato.direccion_contratistas);
            $('#textTelefonoContratista').text(datosContrato.telefono_contratistas);
            $('#textCorreoContratista').text(datosContrato.correo);
            $('#textDepartamentoContratista').text(datosContrato.departamento);
            $('#textCiudadContratista').text(datosContrato.ciudad);

            $('#textTipoContrato').text(datosContrato.tipo_contrato);
            $('#textNombreContrato').text(datosContrato.nombre_contrato);
            $('#textVigenciaContrato').html(`<span class="badge badge-phoenix badge-phoenix-success">${datosContrato.fecha_inicio}</span> - <span class="badge badge-phoenix badge-phoenix-danger">${datosContrato.fecha_fin_real}</span>`);

            if(datosContrato.cuantia_indeterminada == 'SI'){
                $('#textValorContrato').html(`<span class="badge badge-phoenix badge-phoenix-secondary">Cuantia Indeterminada</span>`);
            }else{
                $('#textValorContrato').html(datosContrato.valor_contrato);
            }
            
            $('#textArchivoContrato').html(`<a class="" target="_blank" href="${datosContrato.ruta_archivo_contrato}"><span class="badge badge-phoenix badge-phoenix-danger" style="font-size: 30px;"><i class="far fa-file-pdf"></i></span></a>`);
            $('#textObjetoContractualContrato').text(datosContrato.objeto_contractual);

        }

    }

})();
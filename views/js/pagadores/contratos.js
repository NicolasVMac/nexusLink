function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let idPagador = atob(getParameterByName('idPagador'));

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaTiposContratos'
    },
    success:function(respuesta){

        $("#tipoContrato").html(respuesta);

    }

})

const changeCuantiaContrato = (element) => {

    if(element.checked){
        $('#valorContrato').attr('disabled', true);
        $('#valorContrato').val(0);
    }else{
        $('#valorContrato').attr('disabled', false);
    }

}

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


const obtenerInfoPagador = async (idPagador) => {

    let datos = new FormData();
    datos.append('proceso','infoPagador');
    datos.append('idPagador', idPagador);

    const infoPagador = await $.ajax({
        url: 'ajax/pagadores/pagadores.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!infoPagador){

        console.error("No Existe Pagador"); 
        return;
    }

    return infoPagador;

}

const crearContrato = () => {

    let formulario = document.getElementById("formCrearContrato");
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

            let form = document.querySelector('form');
            const formData = new FormData(form);
            let checkCuantia = document.querySelector('#cuantiaInderContrato');

            formData.append('proceso', 'crearContrato');
            formData.append('idPagador', idPagador);
            formData.append('userCreate', userSession);

            if(!formData.get('valorContrato')){
                formData.append('valorContrato', 0);
            }
            if(checkCuantia.checked){
                formData.append('cuantiaInderContrato', 'SI');
            }else{
                formData.append('cuantiaInderContrato', 'NO');
            }

            for(const [key, value] of formData){
                console.log(key, value);
            }

            loadingFnc();

            $.ajax({

                url: 'ajax/pagadores/pagadores.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    Swal.close();

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡El Contrato se registro correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=pagadores/gestionarcontratos&idPagador='+btoa(idPagador);

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡El Contrato no se registro correctamente!',
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

tablaContratos = $('#tablaContratos').DataTable({

    columns: [
        { title: '#', data: 'id_contrato' },
        { title: 'TIPO CONTRATO', data: 'tipo_contrato' },
        { title: 'NOMBRE CONTRATO', data: 'nombre_contrato' },
        { title: 'VIGENCIA CONTRATO', render: function(data, type, row) {
            return `<span class="badge badge-phoenix badge-phoenix-success">${row.fecha_inicio}</span> - <span class="badge badge-phoenix badge-phoenix-danger">${row.fecha_fin_real}</span>`;
        }},
        { title: 'VALOR CONTRATO', data: 'valor_contrato', render: function(data, type, row){
            if (data == 0) {
            return `<span class="badge badge-phoenix badge-phoenix-secondary" style="font-size: 15px;">` +$.fn.dataTable.render.number(',', '.', 2, null).display(data) +`</span>`;
            }
            return $.fn.dataTable.render.number(',', '.', 2, null).display(data);
        }},
        { title: 'ARCHIVO', render: function(data, type, row){
            return `<a class="" target="_blank" href="${row.ruta_archivo_contrato}"><span class="badge badge-phoenix badge-phoenix-danger" style="font-size: 30px;"><i class="far fa-file-pdf"></i></span></a>`;
        }},
        { title: 'OBJETO CONTRACTUAL', render: function(data, type, row){
            return `<textarea class="form-control" rows="3">${row.objeto_contractual}</textarea>`;
        }},
        { title: 'ESTADO', data: 'active', render: function(data) {
            return data == 1 ? `<span class="badge badge-phoenix badge-phoenix-success m-1">Activo</span>` : `<span class="badge badge-phoenix badge-phoenix-danger m-1">Inactivo</span>`;
        }},
        {
            title: 'OPCIONES', orderable: false, data: null, render: function (data, type, row) {
                return `<button type="button" class="btn btn-success btn-sm" onclick="gestionarContrato(${row.id_contrato})" title="Gestionar Contrato"><i class="far fa-folder"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pagadores/pagadores.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaContratosPagador',
            idPagador: idPagador
        }
    }

});


(async () => {

    if (idPagador){

        let datosPagador = await obtenerInfoPagador(idPagador);

        if(datosPagador){
            $('#titlePage').text('Administrar Pagador: ' + datosPagador.nombre_pagador);
            $('#textTipoPagador').text(datosPagador.tipo_pagador_full);
            $('#textNombrePagador').text(datosPagador.nombre_pagador);
            $('#textTipoIdentiPagador').text(datosPagador.tipo_identi_pagador + ' - ' + datosPagador.tipo_documento_pagador);
            $('#textNumeroIdentiPagador').text(datosPagador.numero_identi_pagador);
            $('#textDireccionPagador').text(datosPagador.direccion_pagador);
            $('#textTelefonoPagador').text(datosPagador.telefono_pagador);
            $('#textCorreoPagador').text(datosPagador.correo);
            $('#textDepartamentoPagador').text(datosPagador.departamento);
            $('#textCiudadPagador').text(datosPagador.ciudad);
        }

        console.log("Datos del pagador:", datosPagador);
    }

})();
let tablaPagadores;


$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaTiposPagadores'
    },
    success:function(respuesta){

        $("#tipoPagador").html(respuesta);

    }

})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaTiposIdentiPagador'
    },
    success:function(respuesta){

        $("#tipoIdentiPagador").html(respuesta);

    }

})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaDepartamentos'
    },
    success:function(respuesta){

        $("#departamentoPagador").html(respuesta);

    }

})

$("#departamentoPagador").change(function(){

    let departamento = $(this).val();

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaMunicipiosDepartamento',
            'departamento': departamento
        },
        success:function(respuesta){

            $("#ciudadPagador").html(respuesta);

        }

    })

})

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


const agregarPagador = () => {

    let formulario = document.getElementById("formAgregarPagador");
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

            formData.append('proceso', 'agregarPagador');
            formData.append('userCreate', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

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
                            text: '¡El Pagadores se registro correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=pagadores/listapagadores';

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡El Pagador no se registro correctamente!',
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

const irGestionContratos = (idPagador) => {

    window.location = 'index.php?ruta=pagadores/gestionarcontratos&idPagador='+btoa(idPagador);
}

tablaPagadores = $('#tablaPagadores').DataTable({

    columns: [
        { name: '#', data: 'id_pagador' },
        { name: 'TIPO PAGADOR', render: function(data, type, row){
            return `${row.tipo_pagador} - ${row.tipo_pagador_full}`;
        }},
        { name: 'NOMBRE PAGADOR', data: 'nombre_pagador' },
        { name: 'TIPO IDENTIFICACION', render: function(data, type, row){
            return `${row.tipo_identi_pagador} - ${row.tipo_documento_pagador}`;
        }},
        { name: 'NUMERO IDENTIFICACION', data: 'numero_identi_pagador' },
        { name: 'DIRECCION', data: 'direccion_pagador' },
        { name: 'TELEFONO', data: 'telefono_pagador' },
        { name: 'DEPARTAMENTO', data: 'departamento' },
        { name: 'CIUDAD', data: 'ciudad' },
        { name: 'CORREOS', data: 'correo' },
        { name: 'ESTADO', render: function(data, type, row){
            if(row.active == 1){
                return `<span class="badge badge-phoenix badge-phoenix-success m-1">Activo</span>`;
            }else{
                return `<span class="badge badge-phoenix badge-phoenix-danger m-1">Inactivo</span>`;
            }
        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `
                    <button type="button" class="btn btn-success btn-sm" onclick="irGestionContratos(${row.id_pagador})" title="Gestionar Contratos"><i class="far fa-folder"></i></button>
                `;

            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pagadores/pagadores.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPagadores',
        }
    }

})
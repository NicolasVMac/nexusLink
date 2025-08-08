const valiFechaActaPQRSF = () => {

    let fechaAperturaBuzon = document.querySelector('#fechaAperturaBuzonPQR').value;
    let fechaActa = document.querySelector('#fechaActaPQR');

    fechaActa.min = fechaAperturaBuzon;


}


const crearActa = () => {

    let formulario = document.getElementById("formCrearActa");
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

            let archivosActa = document.getElementById("archivosActa");

            formData.append('proceso', 'crearActa');
            formData.append('userCreate', userSession);
            for(let file of archivosActa.files){

                formData.append('archivosActa[]', file);

            }

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/pqr/pqr.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Acta se guardo correctamente correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=pqr/cargaractapqr';

                            }

                        })

                    }else if(respuesta == 'error-existe'){
                        
                        Swal.fire({
                            text: '¡El Radicado del Acta ya existe!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })
                    
                    }else{

                        Swal.fire({
                            text: '¡La Acta no se guardo correctamente!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "Error!");

        }

    }

}

const tomarBuzonPQRSF = (idPQR) => {

    Swal.fire({
        title: "¿Desea Gestionar el Buzon PQRSF?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Gestionar PQRSF!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/pqr/pqr.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'tomarBuzonPQRSF',
                    'idPQR': idPQR,
                    'userSession': userSession
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La PQRSF se asigno correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Gestionar Buzon PQRSF',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#3085d6"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=pqr/gestionarbuzonpqrs&idPQRS='+btoa(idPQR);

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'La PQRSF no se asigno correctamente',
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

const abrirBuzonPQRSF = (idPQR) => {

    window.location = 'index.php?ruta=pqr/gestionarbuzonpqrs&idPQRS='+btoa(idPQR);

}

tablaBuzonPQRSF = $('#tablaBuzonPQRSF').DataTable({

    columns: [
        { name: '#', data: 'id_pqr' },
        { name: 'RADICADO ACTA', data: 'radicado_acta' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-success btn-sm" onclick="tomarBuzonPQRSF(${row.id_pqr})" title="Gestionar Buzon PQRSF"><i class="fas fa-check-square"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaBuzonPQRSF',
        }
    }

})

tablaPendientesBuzonPQRSF = $('#tablaPendientesBuzonPQRSF').DataTable({

    columns: [
        { name: '#', data: 'id_pqr' },
        { name: 'RADICADO ACTA', data: 'radicado_acta' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-info btn-sm" onclick="abrirBuzonPQRSF(${row.id_pqr})" title="Abrir Buzon PQRSF"><i class="fas fa-chevron-circle-right"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/pqr/pqr.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaBuzonPendientesPQRSF',
            'user': userSession
        }
    }

})
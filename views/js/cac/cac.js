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

const cargarBaseCac = () => {

    let formulario = document.getElementById("formCargarArchivoCac");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let nombreArchivo = document.getElementById("nombreArchivoCac").value;
            let archivo = document.querySelector("#archivoCac").files;

            // console.log(archivo[0]);

            let data = new FormData();
            data.append("proceso", "cargarArchivoCac");
            data.append("nombreArchivo", nombreArchivo);
            data.append("archivoCac", archivo[0]);
            data.append("user", userSession);

            loadingFnc();

            $.ajax({

                url: 'ajax/cac/cac.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    Swal.close();
                
                    if(respuesta === 'ok'){

                        Swal.fire({

                            text: '¡La Base se cargo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=cac/cargarbase';

                            }

                        })

                    }else if(respuesta === 'error-estructura'){
                        
                        Swal.fire({

                            text: '¡La Base no cuenta con la estructura adecuada, 212 Columnas (HD)!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=cac/cargarbase';

                            }

                        })
                    
                    }else{

                        Swal.fire({

                            text: '¡La Base no se cargo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=cac/cargarbase';

                            }

                        })

                    }

                }

            })

        }

    }

}


tablaBasesCac = $('#tablaBasesCac').DataTable({
    columns: [
        { name: '#', data: 'id_base' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre' },
        { name: 'NOMBRE ARCHIVO', data: 'nombre_archivo' },
        { name: 'ARCHIVO', render: function(data, type, row){ 
            return '<a href="'+row.ruta_archivo+'" target="_blank"><span class="badge badge-phoenix badge-phoenix-success p-2"><i class="far fa-file-excel"></i> ARCHIVO CARGADO</span></a>'
        }
        },
        { name: 'CANTIDAD', data: 'cantidad'},
        { name: 'ESTADO', render: function(data, type, row){
            if(row.estado == 'SUBIDA' || row.estado == 'CARGADA'){

                return '<span class="badge badge-phoenix badge-phoenix-primary p-2">'+row.estado+'</span>';

            }else if(row.estado == 'ERROR' || row.estado == 'ERROR_CARGA'){

                return '<a href="'+row.ruta_archivo_errors+'" target="_blank" download><span class="badge badge-phoenix badge-phoenix-danger p-2"><i class="fas fa-file-download"></i> '+row.estado+'</span></a>';

            }else if(row.estado == 'VALIDADO_ERRORES'){

                return '<a href="'+row.ruta_archivo_errores+'" target="_blank" download><span class="badge badge-phoenix badge-phoenix-danger p-2"><i class="fas fa-file-download"></i> '+row.estado+'</span></a>';

            }else if(row.estado == 'PROCESANDO' || row.estado == 'VALIDANDO'){

                return '<span class="badge badge-phoenix badge-phoenix-primary p-2">'+row.estado+'</span>';

            }else if(row.estado == 'VALIDADO_OK'){

                return '<span class="badge badge-phoenix badge-phoenix-success p-2">'+row.estado+'</span>';

            }
        } 
        },
        { name: 'USUARIO', data: 'usuario_crea' },
        { name: 'FECHA CARGA', data: 'fecha_crea' },
    ],
    order: [[0, 'desc']],
    ajax: {
        url: 'ajax/cac/cac.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'basesCargadasCac'
        }
    }
    

});
const validarArchivoPDF = async (archivo) => {

    let noValid = false;

    if(archivo.length > 0){

        for (const item of archivo) {
            
            if (item["type"] != "application/pdf") {

                noValid = true;
                
            }
            
        }
        
        if(noValid){
            Swal.fire({
                
                title: "Archivo No Valido",
                text: "¡Los archivos debe tener formato .PDF!",
                icon: "error",
                confirmButtonText: "¡Cerrar!",
                confirmButtonColor: "#d33"
                
            });
        }

        return noValid;


    }else{

        Swal.fire({

            title: "Archivo No Valido",
            text: "¡Los archivos debe tener formato .PDF!",
            icon: "error",
            confirmButtonText: "¡Cerrar!",
            confirmButtonColor: "#d33"

        });

    }

}


const cargarPDF = async () => {

    let formulario = document.getElementById("formCargarArchivoPDF");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {
        if (formulario.checkValidity()) {

            let form = document.querySelector('#formCargarArchivoPDF');

            const data = new FormData(form);

            data.append("proceso", "cargarArchivoPDF");
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            let archivoPdf = document.querySelector("#archivoPDF").files;
            

            let validFile = await validarArchivoPDF(archivoPdf);

            if(!validFile){


                $.ajax({
                    url: 'ajax/pdfia/pdfia.ajax.php',
                    type: 'POST',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        if (respuesta === 'ok') {
                            Swal.fire({
                                text: '¡El archivo PDF se cargó correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    formulario.reset();
                                }
                            });

                        } else {


                            Swal.fire({
                                text: '¡La PDF no se cargo correctamente!',
                                icon: 'error',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            })

                        }
                    }
                });

            }
        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }
    }
};

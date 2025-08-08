function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let url = new URL(window.location.href);
let rutaValor = url.searchParams.get("ruta");


if(rutaValor == 'correspon/inicio'){

    let proyecto = 'correspondencia';

    let datos = new FormData();
    datos.append('lista', 'listaManualesProyecto');
    datos.append('proyecto', proyecto);

    $.ajax({

        url: 'ajax/parametricas.ajax.php',
        type: 'POST',
        data: datos,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(respuesta){

            let cadenaHTMLManuales = ``;

            if(respuesta.archivos.length > 0){

                cadenaHTMLManuales += `<ul class="list-group">`;

                for (const manual of respuesta.archivos) {

                    cadenaHTMLManuales += `<li class="list-group-item"><a target="blank_" href="${respuesta.ruta+manual}">${manual}</a></li>`;
                
                }
                
                cadenaHTMLManuales += `</ul>`;

            }

            $("#containerManuales").html(cadenaHTMLManuales);

        }

    })

    

}
$(document).ready(function(){

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaProyectos'
        },
        success:function(respuesta){

            $("#proyectoTicket").html(respuesta);

        }

    })

    $.ajax({

        type: "POST",
        url: "ajax/parametricas.ajax.php",
        data: {
            'lista': 'listaPrioridades'
        },
        success:function(respuesta){

            $("#prioridadTicket").html(respuesta);

        }

    })

})
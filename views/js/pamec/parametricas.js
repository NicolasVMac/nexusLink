//Cargar Grupos
$.ajax({
    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaGrupoEstandaresAutoevaluacion'
    },
    success: function (respuesta) {
        $("#selGrupo").html(respuesta);
    }
});

//Cargar SubGrupos
$.ajax({
    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listarPamecParEstandar',
        'select': 'subgrupo',
    },
    success: function (respuesta) {
        $("#selSubGrupo").html(respuesta);
    }
});

//Cargar Estandar
$.ajax({
    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listarPamecParEstandar',
        'select': 'estandar',

    },
    success: function (respuesta) {
        $("#selEstandar").html(respuesta);
    }
});



// // Cargar SubGrupos
// const onGrupoLoadSubGrupo = (selectGrupo) => {
//     let grupo = selectGrupo.value;
//     $.ajax({
//         type: "POST",
//         url: "ajax/parametricas.ajax.php",
//         data: {
//             'lista': 'listaSubGrupoEstandaresAutoevaluacion',
//             'grupo': grupo
//         },
//         success: function (respuesta) {
//             $("#selSubGrupo").html(respuesta);
//         }
//     });

// };

// //CargarEstandares
// const onSubGrupoLoadEstandar = (selectSubGrupo) => {
//     let subGrupo = selectSubGrupo.value;
//     let grupo = $("#selGrupo").val();
//     $.ajax({
//         type: "POST",
//         url: "ajax/parametricas.ajax.php",
//         data: {
//             'lista': 'listaEstandaresAutoevaluacion',
//             'grupo': grupo,
//             'subGrupo': subGrupo
//         },
//         success: function (respuesta) {
//             $("#selEstandar").html(respuesta);
//         }
//     });
// };

// Cargar sedes
$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: { lista: 'listaSedesPamec' },
    success: (resp) => {
        $('#selSedesPamec').html(resp);
    }
});


// Cargar periodos
$.ajax({
    type: 'POST',
    url: 'ajax/parametricas.ajax.php',
    data: { lista: 'listaPeriodosConsultaAutoevaluacion' },
    success: (resp) => {
        $('#selectPeriodoAutoevaluacion').html(resp);
    }
});
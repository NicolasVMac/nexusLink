function upper(e) {
    e.value = e.value.toUpperCase();
}

function lower(e) {
    e.value = e.value.toLowerCase();
}


$.extend(true, DataTable.defaults, {
    info: true,
    paging: true,
    ordering: true,
    searching: true,
    fixedHeader: true,
    language: {
      "decimal": ",",
      "thousands": ".",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
      "infoFiltered": "(Filtrado de _MAX_ total entradas)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ Entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "Sin resultados encontrados",
      "paginate": {
        "first": "Primero",
        "last": "Ultimo",
        "next": "Siguiente",
        "previous": "Anterior"
      }
    },
    pageLength: 10,
    lengthMenu: [
      [10, 20, 50, 100, 500, -1], [10, 20, 50, 100, 500, 'Todos']
    ]
});

new DataTable('#example');


$(document).ready(function(){

$('.select-field').select2({
    theme: 'bootstrap-5'
});

$('.select-field-multiple').select2({
  // theme: 'bootstrap-5'
});

const element = document.querySelector('[data-choices]');
if (element) {
  new Choices(element);
}

})

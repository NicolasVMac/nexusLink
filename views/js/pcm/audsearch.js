let pendientesUsuario = 0;
let pendientesPerfil = 5;
let pendientesCalidad = 0;


var tableAuditSearch = $("#tableAuditSearch").DataTable({
columns: [
    { name: "Reclamacion Id", data: "Reclamacion_Id" },
    { name: "Proveedor", data: "Razon_Social_Reclamante" },
    { name: "Numero Factura", data: "Numero_Factura" },
    {
    name: "Valor",
    data: "Total_Reclamado",
    render: function (data, type, row) {
        if (type === "display") {
        return (
            "$ " + $.fn.dataTable.render.number(".", ",", 2, "").display(data)
        );
        }
        return data;
    },
    },
    {
    name: "OPCIONES",
    orderable: false,
    render: function (data, type, row) {
        if (pendientesUsuario >= pendientesPerfil) {
        return "Limite de Pendientes";
        } else if (pendientesCalidad >= 1) {
        return "Limite de Pendientes Calidad";
        } else {
        return `<button type="button" class="btn btn-round btn-outline-info btAuditStart" title="Iniciar ${btoa(idProfile)}" idReclamacion="${row.Reclamacion_Id}" codEntrada="${row.Codigo_Entrada}"><i class="fa-solid fa-play"></i></button>`;
        }
    },
    },
],
ajax: {
    url: "ajax/pcm/auditoria.ajax.php",
    type: "POST",
    data: {
    option: "auditoriaSearch",
    perfil: idProfile,
    usuario: sessionUser,
    montos: sessionAmounts,
    items: sessionItems,
    },
},
bFilter: false,
bPaginate: false,
});

$("#card-header-title-audit-search").html(
  "Busqueda Cuentas - " +
    idProfile +
    ' Montos <font color="red">' +
    sessionAmounts +
    '</font> Items <font color="red">' +
    sessionItems +
    "</font> "
);

$(document).on("click", ".btAuditStart", function () {
  var idReclamacion = $(this).attr("idReclamacion");
  var codEntrada = $(this).attr("codEntrada");

  //alert ('hola mundo, a iniciar auditoria '+idProfile+idCuenta);

  window.location =
    "index.php?ruta=pcm/audStart&idPerfil=" +
    btoa(idProfile) +
    "&idReclamacion=" +
    btoa(idReclamacion) +
    "&codEntrada=" +
    btoa(codEntrada);
});

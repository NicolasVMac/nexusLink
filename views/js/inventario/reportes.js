const meses = [
    'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO',
    'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'
];


const mostrarReporte = (rutaReporte) => {

    window.location = `index.php?ruta=inventario/reporteview&rutaReporte=${btoa(rutaReporte)}`;

}

function calcularMesesMantenimiento(instalacionStr, frecuencia) {

  const frecuenciaMap = {
    'TRIMESTRAL': 3,
    'CUATRIMESTRAL': 4,
    'SEMESTRAL': 6,
    'ANUAL': 12,
  };

  const mesesIntervalo = frecuenciaMap[frecuencia.toUpperCase()];
  if (!mesesIntervalo) return [];

  const instalacion = new Date(instalacionStr);
  const anioInstalacion = instalacion.getFullYear();

  const resultado = [];
  let fecha = new Date(instalacion);

//   while (fecha.getFullYear() === anioInstalacion) {
//     resultado.push(meses[fecha.getMonth()]);
//     fecha.setMonth(fecha.getMonth() + mesesIntervalo);
//   }

  while (fecha.getTime() < new Date(instalacion.getFullYear() + 1, instalacion.getMonth()).getTime()) {
    resultado.push(meses[fecha.getMonth()]);
    fecha.setMonth(fecha.getMonth() + mesesIntervalo);
  }

  return resultado;
}

const obtenerResultadoMantenimientoMes = (fecha_mantenimiento, arrayMeses, mes) => {

    let respuesta = '';

    // if(fecha_mantenimiento && fecha_mantenimiento !== null){

    //     const fechaMantenimiento = new Date(fecha_mantenimiento);
    //     const anioActual = new Date().getFullYear();
    //     const anioMante = fechaMantenimiento.getFullYear();
    //     const mesMante = fechaMantenimiento.getMonth();

    //     if(anioActual === anioMante && meses[mesMante] === mes){

    //         respuesta = '<span class="badge badge-phoenix badge-phoenix-success">MTTO</span>';

    //     }else{

    //         if(arrayMeses.includes(mes)){
    //             respuesta = 'MTTO';
    //         }else{
    //             respuesta = '';
    //         }

    //     }

    // }else{

    //     if(arrayMeses.includes(mes)){
    //         respuesta = 'MTTO';
    //     }else{
    //         respuesta = '';
    //     }

    // }

    if(arrayMeses.includes(mes)){
        respuesta = 'MTTO';
    }else{
        respuesta = '';
    }

    return respuesta;

}


// const generarReporteCalendario = async () => {

//     const cardResultado = document.querySelector("#cardResulRepCalendario");

//     let formulario = document.getElementById("formRepCalendario");
//     let elementos = formulario.elements;
//     let errores = 0;

//     //console.log(elementos);

//     Array.from(elementos).forEach(function (element) { //array de elementos del Form
//         if (element.className.includes('is-invalid')) {
//             errores += 1;
//         }
//     });
//     if (errores === 0) {

//         if (formulario.checkValidity()){

//             cardResultado.style.display = 'block';

//             // let result = calcularMesesMantenimiento('2024-09-11', 'TRIMESTRAL');

//             // console.log(result);


//             tablaCalendarioMTTO = $('#tablaCalendarioMTTO').DataTable({

//                 columns: [
//                     { name: '#', data: 'id' },
//                     { name: 'EQUIPO', data: 'nombre_equipo' },
//                     { name: 'MARCA', data: 'marca' },
//                     { name: 'MODELO', data: 'modelo' },
//                     { name: 'SERIE', data: 'serie' },
//                     { name: 'ACTIVO FIJO', data: 'activo_fijo' },
//                     { name: 'SERVICIO', data: 'servicio' },
//                     { name: 'UBICACION', data: 'ubicacion' },
//                     { name: 'TIPO ADQUISICION', data: 'forma_adquisicion' },
//                     { name: 'TIPO MANTENIMIENTO', render: function(data, type, row){
//                         return 'MTTO';
//                     }},
//                     { name: 'FECHA FIN GARANTIA', data: 'fecha_fin_garantia' },
//                     { name: 'CLASIFICACION RIESGO', data: 'clasificacion_riesgo' },
//                     { name: 'REGISTRO INVIMA', data: 'registro_sanitario_invima' },
//                     { name: 'FRECUENCIA', data: 'frecuencia' },
//                     { name: 'ENERO', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'ENERO');
//                         return resultado;
//                     }},
//                     { name: 'FEBRERO', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'FEBRERO');
//                         return resultado;
//                     }},
//                     { name: 'MARZO', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'MARZO');
//                         return resultado;
//                     }},
//                     { name: 'ABRIL', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'ABRIL');
//                         return resultado;
//                     }},
//                     { name: 'MAYO', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'MAYO');
//                         return resultado;
//                     }},
//                     { name: 'JUNIO', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'JUNIO');
//                         return resultado;
//                     }},
//                     { name: 'JULIO', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'JULIO');
//                         return resultado;
//                     }},
//                     { name: 'AGOSTO', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'AGOSTO');
//                         return resultado;
//                     }},
//                     { name: 'SEPTIEMBRE', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'SEPTIEMBRE');
//                         return resultado;
//                     }},
//                     { name: 'OCTUBRE', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'OCTUBRE');
//                         return resultado;
//                     }},
//                     { name: 'NOVIEMBRE', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'NOVIEMBRE');
//                         return resultado;
//                     }},
//                     { name: 'DICIEMBRE', render: function(data, type, row){
//                         let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
//                         let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'DICIEMBRE');
//                         return resultado;
//                     }},
//                     { name: 'FECHA INSTALACION', data: 'instalacion' },
//                     { name: 'VIDA UTIL', data: 'vida_util' },
//                 ],
//                 ordering: false,
//                 dom: 'Bfrtip',
//                 destroy: true,
//                 buttons: [
//                     {
//                         extend: 'excel',
//                         text: 'Descargar Excel',
//                         className: 'btn btn-phoenix-success',
//                     },
//                 ],
//                 ajax: {
//                     url: 'ajax/inventario/reportes-biomedicos.ajax.php',
//                     type: 'POST',
//                     data: {
//                         'proceso': 'listaEquiposBiomedicosTipoMantenimiento',
//                         'fechaAnio': fechaAnio,
//                         'tipoMantenimiento': 'MTTO'
//                     }
//                 }

//             })


//         }else{

//             toastr.warning("Debe diligenciar todos los campos del Formulario.", "¡Atencion!");

//         }

//     }

// }

const gestionarEquipoBiomedico = (idEquipoBiomedico) => {

    window.open(`index.php?ruta=inventario/registrarequipobiomedico&idEquipoBio=${btoa(idEquipoBiomedico)}&active=datos-equipo`);

}

tablaReportesBiomedicos = $('#tablaReportesBiomedicos').DataTable({

    columns: [
        { name: '#', data: 'id_reporte_bio' },
        { name: 'NOMBRE REPORTE', data: 'nombre_reporte' },
        { name: 'DESCRIPCION', data: 'descripcion_reporte' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-success btn-sm" onclick="mostrarReporte('${row.ruta_reporte}')" title="Ver Reporte"><i class="fas fa-chart-area"></i></button>`;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/inventario/reportes-biomedicos.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaReportesBiomedicos',
        }
    }

})

tablaCalendarioMTTO = $('#tablaCalendarioMTTO').DataTable({
    columns: [
        { name: '#', data: 'id' },
        { name: 'EQUIPO', data: 'nombre_equipo' },
        { name: 'MARCA', data: 'marca' },
        { name: 'MODELO', data: 'modelo' },
        { name: 'SERIE', data: 'serie' },
        { name: 'ACTIVO FIJO', data: 'activo_fijo' },
        { name: 'SERVICIO', data: 'servicio' },
        { name: 'UBICACION', data: 'ubicacion' },
        { name: 'TIPO ADQUISICION', data: 'forma_adquisicion' },
        { name: 'TIPO MANTENIMIENTO', render: function(data, type, row){
            return 'MANTENIMIENTO (MTTO)';
        }},
        { name: 'FECHA FIN GARANTIA', data: 'fecha_fin_garantia' },
        { name: 'CLASIFICACION RIESGO', data: 'clasificacion_riesgo' },
        { name: 'REGISTRO INVIMA', data: 'registro_sanitario_invima' },
        { name: 'FRECUENCIA', data: 'frecuencia' },
        { name: 'ENERO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'ENERO');
            return resultado;
        }},
        { name: 'FEBRERO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'FEBRERO');
            return resultado;
        }},
        { name: 'MARZO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'MARZO');
            return resultado;
        }},
        { name: 'ABRIL', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'ABRIL');
            return resultado;
        }},
        { name: 'MAYO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'MAYO');
            return resultado;
        }},
        { name: 'JUNIO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'JUNIO');
            return resultado;
        }},
        { name: 'JULIO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'JULIO');
            return resultado;
        }},
        { name: 'AGOSTO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'AGOSTO');
            return resultado;
        }},
        { name: 'SEPTIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'SEPTIEMBRE');
            return resultado;
        }},
        { name: 'OCTUBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'OCTUBRE');
            return resultado;
        }},
        { name: 'NOVIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'NOVIEMBRE');
            return resultado;
        }},
        { name: 'DICIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'DICIEMBRE');
            return resultado;
        }},
        { name: 'FECHA INSTALACION', data: 'instalacion' },
        { name: 'VIDA UTIL', data: 'vida_util' },
        { name: 'ACCION', render:function(data, type, row){
            return `<button type="button" class="btn btn-outline-success btn-sm" onclick="gestionarEquipoBiomedico(${row.id})" title="Gestionar Equipo Biomedico"><i class="far fa-arrow-alt-circle-right"></i></button>`;
        }}
    ],
    ordering: false,
    dom: 'Bfrtip',
    destroy: true,
    buttons: [
        {
            extend: 'excel',
            text: 'Descargar Excel',
            className: 'btn btn-phoenix-success',
        },
    ],
    ajax: {
        url: 'ajax/inventario/reportes-biomedicos.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEquiposBiomedicosTipoMantenimiento',
            'tipoMantenimiento': 'MTTO'
        }
    }

})

tablaCalendarioCLBR = $('#tablaCalendarioCLBR').DataTable({
    columns: [
        { name: '#', data: 'id' },
        { name: 'EQUIPO', data: 'nombre_equipo' },
        { name: 'MARCA', data: 'marca' },
        { name: 'MODELO', data: 'modelo' },
        { name: 'SERIE', data: 'serie' },
        { name: 'ACTIVO FIJO', data: 'activo_fijo' },
        { name: 'SERVICIO', data: 'servicio' },
        { name: 'UBICACION', data: 'ubicacion' },
        { name: 'TIPO ADQUISICION', data: 'forma_adquisicion' },
        { name: 'TIPO MANTENIMIENTO', render: function(data, type, row){
            return 'CALIBRACION (CLBR)';
        }},
        { name: 'FECHA FIN GARANTIA', data: 'fecha_fin_garantia' },
        { name: 'CLASIFICACION RIESGO', data: 'clasificacion_riesgo' },
        { name: 'REGISTRO INVIMA', data: 'registro_sanitario_invima' },
        { name: 'FRECUENCIA', data: 'frecuencia' },
        { name: 'ENERO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'ENERO');
            return resultado;
        }},
        { name: 'FEBRERO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'FEBRERO');
            return resultado;
        }},
        { name: 'MARZO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'MARZO');
            return resultado;
        }},
        { name: 'ABRIL', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'ABRIL');
            return resultado;
        }},
        { name: 'MAYO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'MAYO');
            return resultado;
        }},
        { name: 'JUNIO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'JUNIO');
            return resultado;
        }},
        { name: 'JULIO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'JULIO');
            return resultado;
        }},
        { name: 'AGOSTO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'AGOSTO');
            return resultado;
        }},
        { name: 'SEPTIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'SEPTIEMBRE');
            return resultado;
        }},
        { name: 'OCTUBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'OCTUBRE');
            return resultado;
        }},
        { name: 'NOVIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'NOVIEMBRE');
            return resultado;
        }},
        { name: 'DICIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'DICIEMBRE');
            return resultado;
        }},
        { name: 'FECHA INSTALACION', data: 'instalacion' },
        { name: 'VIDA UTIL', data: 'vida_util' },
        { name: 'ACCION', render:function(data, type, row){
            return `<button type="button" class="btn btn-outline-success btn-sm" onclick="gestionarEquipoBiomedico(${row.id})" title="Gestionar Equipo Biomedico"><i class="far fa-arrow-alt-circle-right"></i></button>`;
        }}
    ],
    ordering: false,
    dom: 'Bfrtip',
    destroy: true,
    buttons: [
        {
            extend: 'excel',
            text: 'Descargar Excel',
            className: 'btn btn-phoenix-success',
        },
    ],
    ajax: {
        url: 'ajax/inventario/reportes-biomedicos.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEquiposBiomedicosTipoMantenimiento',
            'tipoMantenimiento': 'CLBR'
        }
    }

})

tablaCalendarioVLD = $('#tablaCalendarioVLD').DataTable({
    columns: [
        { name: '#', data: 'id' },
        { name: 'EQUIPO', data: 'nombre_equipo' },
        { name: 'MARCA', data: 'marca' },
        { name: 'MODELO', data: 'modelo' },
        { name: 'SERIE', data: 'serie' },
        { name: 'ACTIVO FIJO', data: 'activo_fijo' },
        { name: 'SERVICIO', data: 'servicio' },
        { name: 'UBICACION', data: 'ubicacion' },
        { name: 'TIPO ADQUISICION', data: 'forma_adquisicion' },
        { name: 'TIPO MANTENIMIENTO', render: function(data, type, row){
            return 'VALIDACION (VLD)';
        }},
        { name: 'FECHA FIN GARANTIA', data: 'fecha_fin_garantia' },
        { name: 'CLASIFICACION RIESGO', data: 'clasificacion_riesgo' },
        { name: 'REGISTRO INVIMA', data: 'registro_sanitario_invima' },
        { name: 'FRECUENCIA', data: 'frecuencia' },
        { name: 'ENERO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'ENERO');
            return resultado;
        }},
        { name: 'FEBRERO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'FEBRERO');
            return resultado;
        }},
        { name: 'MARZO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'MARZO');
            return resultado;
        }},
        { name: 'ABRIL', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'ABRIL');
            return resultado;
        }},
        { name: 'MAYO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'MAYO');
            return resultado;
        }},
        { name: 'JUNIO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'JUNIO');
            return resultado;
        }},
        { name: 'JULIO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'JULIO');
            return resultado;
        }},
        { name: 'AGOSTO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'AGOSTO');
            return resultado;
        }},
        { name: 'SEPTIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'SEPTIEMBRE');
            return resultado;
        }},
        { name: 'OCTUBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'OCTUBRE');
            return resultado;
        }},
        { name: 'NOVIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'NOVIEMBRE');
            return resultado;
        }},
        { name: 'DICIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'DICIEMBRE');
            return resultado;
        }},
        { name: 'FECHA INSTALACION', data: 'instalacion' },
        { name: 'VIDA UTIL', data: 'vida_util' },
        { name: 'ACCION', render:function(data, type, row){
            return `<button type="button" class="btn btn-outline-success btn-sm" onclick="gestionarEquipoBiomedico(${row.id})" title="Gestionar Equipo Biomedico"><i class="far fa-arrow-alt-circle-right"></i></button>`;
        }}
    ],
    ordering: false,
    dom: 'Bfrtip',
    destroy: true,
    buttons: [
        {
            extend: 'excel',
            text: 'Descargar Excel',
            className: 'btn btn-phoenix-success',
        },
    ],
    ajax: {
        url: 'ajax/inventario/reportes-biomedicos.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEquiposBiomedicosTipoMantenimiento',
            'tipoMantenimiento': 'VLD'
        }
    }

})

tablaCalendarioCL = $('#tablaCalendarioCL').DataTable({
    columns: [
        { name: '#', data: 'id' },
        { name: 'EQUIPO', data: 'nombre_equipo' },
        { name: 'MARCA', data: 'marca' },
        { name: 'MODELO', data: 'modelo' },
        { name: 'SERIE', data: 'serie' },
        { name: 'ACTIVO FIJO', data: 'activo_fijo' },
        { name: 'SERVICIO', data: 'servicio' },
        { name: 'UBICACION', data: 'ubicacion' },
        { name: 'TIPO ADQUISICION', data: 'forma_adquisicion' },
        { name: 'TIPO MANTENIMIENTO', render: function(data, type, row){
            return 'CALIFACION (CL)';
        }},
        { name: 'FECHA FIN GARANTIA', data: 'fecha_fin_garantia' },
        { name: 'CLASIFICACION RIESGO', data: 'clasificacion_riesgo' },
        { name: 'REGISTRO INVIMA', data: 'registro_sanitario_invima' },
        { name: 'FRECUENCIA', data: 'frecuencia' },
        { name: 'ENERO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'ENERO');
            return resultado;
        }},
        { name: 'FEBRERO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'FEBRERO');
            return resultado;
        }},
        { name: 'MARZO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'MARZO');
            return resultado;
        }},
        { name: 'ABRIL', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'ABRIL');
            return resultado;
        }},
        { name: 'MAYO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'MAYO');
            return resultado;
        }},
        { name: 'JUNIO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'JUNIO');
            return resultado;
        }},
        { name: 'JULIO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'JULIO');
            return resultado;
        }},
        { name: 'AGOSTO', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'AGOSTO');
            return resultado;
        }},
        { name: 'SEPTIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'SEPTIEMBRE');
            return resultado;
        }},
        { name: 'OCTUBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'OCTUBRE');
            return resultado;
        }},
        { name: 'NOVIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'NOVIEMBRE');
            return resultado;
        }},
        { name: 'DICIEMBRE', render: function(data, type, row){
            let arrayMeses = calcularMesesMantenimiento(row.instalacion, row.frecuencia);
            let resultado = obtenerResultadoMantenimientoMes(row.fecha_mantenimiento, arrayMeses, 'DICIEMBRE');
            return resultado;
        }},
        { name: 'FECHA INSTALACION', data: 'instalacion' },
        { name: 'VIDA UTIL', data: 'vida_util' },
        { name: 'ACCION', render:function(data, type, row){
            return `<button type="button" class="btn btn-outline-success btn-sm" onclick="gestionarEquipoBiomedico(${row.id})" title="Gestionar Equipo Biomedico"><i class="far fa-arrow-alt-circle-right"></i></button>`;
        }}
    ],
    ordering: false,
    dom: 'Bfrtip',
    destroy: true,
    buttons: [
        {
            extend: 'excel',
            text: 'Descargar Excel',
            className: 'btn btn-phoenix-success',
        },
    ],
    ajax: {
        url: 'ajax/inventario/reportes-biomedicos.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaEquiposBiomedicosTipoMantenimiento',
            'tipoMantenimiento': 'CL'
        }
    }

})
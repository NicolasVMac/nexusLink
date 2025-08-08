function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let idEquipoBiomedico = atob(getParameterByName('idEquipoBio'));
let idSoliMantenimiento = atob(getParameterByName('idSoliMantenimiento'));
let categoriaActivo = atob(getParameterByName('categoriaActivo'));
let idManteActivoFijo = atob(getParameterByName('idManteActivoFijo'));


let tablaListaMantenimientosActivosFijos;
let tablaMantenimientosActivosFijos;


const changeCategoriaActivoFijo = (field) => {

    let categoriaActivoFijo = field.value;

    $.ajax({
        type: 'POST',
        url: 'ajax/parametricas.ajax.php',
        data: {
            'lista': 'listaTiposActivoFijo',
            'categoriaActivoFijo': categoriaActivoFijo
        },
    }).done(function (tiposActivos) {
        $("#mTipoActivoFijo").html(tiposActivos)
    })

}

const crearMantenimientoActivoFijo = () => {

    let formulario = document.getElementById("formAgregarMantenimientoActivoFijo");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formAgregarMantenimientoActivoFijo');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "crearMantenimientoActivoFijo");
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/inventario/mantenimiento.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡El Mantenimiento del Activo Fijo se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tablaListaMantenimientosActivosFijos.ajax.reload();
                                $('#mTipoActivoFijo').val(null).trigger('change');
                                form.reset();

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡El Mantenimiento del Acitvo Fijo no se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}


const eliminarMantenimientoActivoFijo = (idTipoMante) => {

    Swal.fire({
        title: `¿Desea eliminar el Mantenimiento del Activo Fijo?`,
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar Mantenimiento!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/inventario/mantenimiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarMantenimientoActivoFijo',
                    'idTipoMante': idTipoMante,
                    'user': userSession
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡El Mantenimiento de Activo Fijo se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                tablaListaMantenimientosActivosFijos.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'El Mantenimiento de Activo Fijo no se elimino correctamente',
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

const mostrarInfoEquipoBiomedico = async (idEquipoBiomedico) => {

    let data = new FormData()
    data.append('proceso', 'infoDatosEquipoBiomedico');
    data.append('idEquipoBiomedico', idEquipoBiomedico);
    
    $.ajax({
    
        url: 'ajax/inventario/inventario-biomedico.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(resp){

            // console.log(resp);
    
            $('#idEquipoBiomedico').val(resp.id);

            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaTipoEquipoDg'
                },
            }).done(function (tipoEquipos) {
                $("#dGTipoEquipo").html(tipoEquipos);
                $("#dGTipoEquipo").val(resp.tipo_equipo);
            })
            $('#dGNombreEquipo').val(resp.nombre_equipo);
            $('#dGMarca').val(resp.marca);
            $('#dGModelo').val(resp.modelo);
            $('#dGSerie').val(resp.serie);
            $('#dGActivoFijo').val(resp.activo_fijo);
            $('#dGRegistroSaniInvima').val(resp.registro_sanitario_invima);
            $('#dGUbicacion').val(resp.ubicacion);
            $('#dTTensionTrabajo').val(resp.tension_trabajo);
            $('#dTConsumoWatt').val(resp.consumo_watt);
            $('#dTPeso').val(resp.peso);
            $('#dtCondicionesAmbien').val(resp.condiciones_ambientales);
            $('#frecuenciaMantenimiento').val(resp.frecuencia_mantenimiento);
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaSedesDg'
                },
            }).done(function (sedes) {
                $("#dGSede").html(sedes)
                $("#dGSede").val(resp.sede)
            })
            

            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaServiciosDg'
                },
            }).done(function (lista) {
                $("#dGServicio").html(lista)
                $("#dGServicio").val(resp.servicio)
            })
            
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaClasificiacionBiomedicaDg'
                },
            }).done(function (lista) {
                $("#dGClasificacionBio").html(lista)
                $("#dGClasificacionBio").val(resp.clasificacion_biomedica)
            })
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaClasificiacionRiesgoDg'
                },
            }).done(function (lista) {
                $("#dGClasificacionRiesgo").html(lista)
                $("#dGClasificacionRiesgo").val(resp.clasificacion_riesgo)
            })
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaTecnologiaPredoDt'
                },
            }).done(function (lista) {
                $("#dTTecnologiaPredo").html(lista)
                $("#dTTecnologiaPredo").val(resp.tecnologia_predominante)
            })
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaFuenteAlimentacionDt'
                },
            }).done(function (lista) {
                $("#dTFuenteAlimen").html(lista)
                $("#dTFuenteAlimen").val(resp.fuente_alimentacion)
            })
            
            $.ajax({
                type: 'POST',
                url: 'ajax/parametricas.ajax.php',
                data: {
                    'lista': 'listaCaracteristicasInstaDt'
                },
            }).done(function (lista) {
                $("#dTCaracteristicasInsta").html(lista)
                $("#dTCaracteristicasInsta").val(resp.caracteristica_instalacion)
            })

        }
    
    })

}

const mostrarTiposMantenimientosGestion = async (idEquipo, categoriaActivo) => {

    let data = new FormData()
    data.append('proceso', 'listaTiposMantenimientosEquipo');
    data.append('idEquipo', idEquipo);
    data.append('categoriaActivo', categoriaActivo);
    
    $.ajax({
    
        url: 'ajax/inventario/mantenimiento.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(listaMantenimientos){

            // console.log(listaMantenimientos);
            let cadenaPreventivos = '';
            let cadenaCorrectivos = '';

            if(listaMantenimientos.length > 0){
                
                for (const mantenimiento of listaMantenimientos){
                    
                    if(mantenimiento.tipo_mantenimiento === 'PREVENTIVO'){
                        
                        cadenaPreventivos += `<div class="form-check">
                        <input type="checkbox" name="gMMantenimientosPreventivos[]" style="margin-top: 7px;" class="form-check-input" value="${mantenimiento.mantenimiento}"/>
                        <label class="form-check-label">${mantenimiento.mantenimiento}</label>
                        </div>`;
                        
                    }else{
                        
                        cadenaCorrectivos += `<div class="form-check">
                        <input type="checkbox" name="gMMantenimientosCorrectivos[]" style="margin-top: 7px;" class="form-check-input" value="${mantenimiento.mantenimiento}"/>
                        <label class="form-check-label">${mantenimiento.mantenimiento}</label>
                        </div>`;
                    }
                
                }
            }else{

                cadenaPreventivos = `<div class="alert alert-soft-warning" role="alert">¡Sin Mantenimientos Preventivos Registrados!</div>`;
                cadenaCorrectivos = `<div class="alert alert-soft-warning" role="alert">¡Sin Mantenimientos Correctivos Registrados!</div>`;
                
            }
            
            $('#contenedorCheckPreventivos').html(cadenaPreventivos);
            $('#contenedorCheckCorrectivos').html(cadenaCorrectivos);

        }
    })

}

const mostrarInfoSolicitudMantenimiento = async (idSoliMantenimiento, categoriaActivo) => {

    let data = new FormData()
    data.append('proceso', 'infoSolicitudMantenimiento');
    data.append('idSoliMantenimiento', idSoliMantenimiento);
    data.append('categoriaActivo', categoriaActivo);
    
    $.ajax({
    
        url: 'ajax/inventario/mantenimiento.ajax.php',
        type: 'POST',
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(resp){

            $('#txtSoliOrdenNo').html(resp.orden_no);
            $('#txtSoliCargo').html(resp.cargo);
            $('#txtSoliDescripcionIncidencia').html(resp.descripcion_incidencia);
            $('#txtSoliFechaEjecucion').html(resp.fecha_ejecucion);
            $('#txtSoliResponsable').html(resp.responsable);
            $('#txtSoliRequiereRespuesto').html(resp.requiere_repuesto);
            $('#txtSoliDescripcionFalla').html(resp.descripcion_falla);
            $('#txtSoliRespuestosNecesarios').html(resp.repuestos_necesarios);

        }

    })

}

const obtenerInfoMantenimientoId = async (idManteActivoFijo) => {

    let data = new FormData()
    data.append('proceso', 'infoMantenimientoId');
    data.append('idManteActivoFijo', idManteActivoFijo);

    const respuesta = await $.ajax({
        url: 'ajax/inventario/mantenimiento.ajax.php',
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!respuesta){

        console.error("Sin Informacion"); 
        return;
    }

    // console.log(segmentos);

    return respuesta;

}

const guardarMantenimiento = () => {

    let formulario = document.getElementById("formGestionMantenimiento");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formGestionMantenimiento');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "guardarMantenimiento");
            data.append("idEquipoBio", idEquipoBiomedico);
            data.append("idSoliMantenimiento", idSoliMantenimiento);
            data.append("categoriaActivo", categoriaActivo);
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/inventario/mantenimiento.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡El Mantenimiento se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=inventario/registrarequipobiomedico&idEquipoBio='+btoa(idEquipoBiomedico)+'&active=datos-equipo';

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡El Mantenimiento se guardo correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const redireccionEditarMantenimiento = (idManteActivoFijo, categoriaActivo) => {

    window.location = `index.php?ruta=inventario/editarmantenimientocorrec&idManteActivoFijo=${btoa(idManteActivoFijo)}&categoriaActivo=${btoa(categoriaActivo)}`;

}

const obtenerInfoSolicitudMantenimiento = async (idSoliMantenimiento, categoriaActivo) => {

    let data = new FormData()
    data.append('proceso', 'infoSolicitudMantenimiento');
    data.append('idSoliMantenimiento', idSoliMantenimiento);
    data.append('categoriaActivo', categoriaActivo);

    const respuesta = await $.ajax({
        url: 'ajax/inventario/mantenimiento.ajax.php',
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!respuesta){

        console.error("Sin Informacion"); 
        return;
    }

    // console.log(segmentos);

    return respuesta;

}

const mostrarInformacionEdicionMantenimiento = async (idManteActivoFijo, categoriaActivo) => {

    let infoMantenimiento = await obtenerInfoMantenimientoId(idManteActivoFijo);

    let infoSoliMante = await obtenerInfoSolicitudMantenimiento(infoMantenimiento.id_solicitud_mante, categoriaActivo);

    // console.log(infoMantenimiento);

    if(infoSoliMante){

        $('#txtSoliOrdenNo').html(infoSoliMante.orden_no);
        $('#txtSoliCargo').html(infoSoliMante.cargo);
        $('#txtSoliDescripcionIncidencia').html(infoSoliMante.descripcion_incidencia);
        $('#txtSoliFechaEjecucion').html(infoSoliMante.fecha_ejecucion);
        $('#txtSoliResponsable').html(infoSoliMante.responsable);
        $('#txtSoliRequiereRespuesto').html(infoSoliMante.requiere_repuesto);
        $('#txtSoliDescripcionFalla').html(infoSoliMante.descripcion_falla);
        $('#txtSoliRespuestosNecesarios').html(infoSoliMante.repuestos_necesarios);

    }

    if(infoMantenimiento.categoria_activo == 'EQUIPOBIOMEDICO'){

        await mostrarInfoEquipoBiomedico(infoMantenimiento.id_equipo);

        let arrayManteCorrectivos = infoMantenimiento.mantenimientos_correctivos.split('|');
        let arrayMantePreventivos = infoMantenimiento.mantenimientos_preventivos.split('|');

        let data = new FormData()
        data.append('proceso', 'listaTiposMantenimientosEquipo');
        data.append('idEquipo', infoMantenimiento.id_equipo);
        data.append('categoriaActivo', categoriaActivo);
        
        $.ajax({
        
            url: 'ajax/inventario/mantenimiento.ajax.php',
            type: 'POST',
            data: data,
            cache:false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(listaMantenimientos){

                // console.log(listaMantenimientos);
                let cadenaPreventivos = '';
                let cadenaCorrectivos = '';

                if(listaMantenimientos.length > 0){
                    
                    for (const mantenimiento of listaMantenimientos){
                        
                        if(mantenimiento.tipo_mantenimiento === 'PREVENTIVO'){

                            let isChecked = arrayMantePreventivos.includes(mantenimiento.mantenimiento) ? 'checked' : '';
                            
                            cadenaPreventivos += `<div class="form-check">
                            <input type="checkbox" name="gMMantenimientosPreventivos[]" style="margin-top: 7px;" class="form-check-input" ${isChecked} value="${mantenimiento.mantenimiento}"/>
                            <label class="form-check-label">${mantenimiento.mantenimiento}</label>
                            </div>`;
                            
                        }else{

                            let isChecked = arrayManteCorrectivos.includes(mantenimiento.mantenimiento) ? 'checked' : '';
                            
                            cadenaCorrectivos += `<div class="form-check">
                            <input type="checkbox" name="gMMantenimientosCorrectivos[]" style="margin-top: 7px;" class="form-check-input" ${isChecked} value="${mantenimiento.mantenimiento}"/>
                            <label class="form-check-label">${mantenimiento.mantenimiento}</label>
                            </div>`;
                        }
                    
                    }
                }else{

                    cadenaPreventivos = `<div class="alert alert-soft-warning" role="alert">¡Sin Mantenimientos Preventivos Registrados!</div>`;
                    cadenaCorrectivos = `<div class="alert alert-soft-warning" role="alert">¡Sin Mantenimientos Correctivos Registrados!</div>`;
                    
                }
                
                $('#contenedorCheckPreventivos').html(cadenaPreventivos);
                $('#contenedorCheckCorrectivos').html(cadenaCorrectivos);

            }
        })

        $('#gMObservacionesMantenimiento').val(infoMantenimiento.observaciones_mantenimiento);

    }


}


const edicionMantenimiento = () => {

    let formulario = document.getElementById("formGestionEdicionMantenimiento");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formGestionEdicionMantenimiento');

            const data = new FormData(form);

            // console.log(archivo[0]);
            
            data.append("proceso", "editarMantenimiento");
            data.append("idManteActivoFijo", idManteActivoFijo);
            data.append("categoriaActivo", categoriaActivo);
            data.append("user", userSession);

            // for(const [key, value] of data){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/inventario/mantenimiento.ajax.php',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){
                
                    if(respuesta === 'ok'){

                        Swal.fire({
                            text: '¡El Mantenimiento se modifico correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=inventario/listamanterealizados';

                            }

                        })

                    }else{

                        Swal.fire({

                            text: '¡El Mantenimiento no se modifico correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        })

                    }

                }

            })

        }else{

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

tablaListaMantenimientosActivosFijos = $('#tablaListaMantenimientosActivosFijos').DataTable({

    columns: [
        { name: '#', data: 'id_tipo_mante' },
        { name: 'CATEGORIA', data: 'categoria'},
        { name: 'TIPO ACTIVO', data: 'tipo_activo' },
        { name: 'MANTENIMIENTO', data: 'mantenimiento' },
        { name: 'TIPO MANTENIMIENTO', data: 'tipo_mantenimiento' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-outline-danger btn-sm" title="Eliminar Mantenimiento" onclick="eliminarMantenimientoActivoFijo(${row.id_tipo_mante})"><i class="fas fa-trash-alt"></i></button>
                `;
            }
        }
    ],
    order: [
        [0, 'desc']
    ],
    ajax: {
        url: 'ajax/inventario/mantenimiento.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaMantenimientosActivosFijos',
        }
    }

})


tablaMantenimientosActivosFijos = $('#tablaMantenimientosActivosFijos').DataTable({

    columns: [
        { name: '#', data: 'id_mante_activo_fijo' },
        { name: 'TIPO EQUIPO', data: 'tipo_equipo'},
        { name: 'NOMBRE EQUIPO', data: 'nombre_equipo' },
        { name: 'MARCA', data: 'marca' },
        { name: 'MODELO', data: 'modelo' },
        { name: 'SERIE', data: 'serie' },
        { name: 'ACTIVO FIJO', data: 'activo_fijo' },
        { name: 'SEDE', data: 'sede' },
        { name: 'UBICACION', data: 'ubicacion' },
        { name: 'FECHA MANTENIMIENTO', data: 'fecha_mantenimiento' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {

                return `
                    <button type="button" class="btn btn-outline-primary btn-sm" title="Editar Mantenimiento" onclick="redireccionEditarMantenimiento(${row.id_mante_activo_fijo}, '${row.categoria_activo}')"><i class="fas fa-pen-square"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/inventario/mantenimiento.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaMantenimientosRealizadosActivosFijos',
        }
    }

})

$('#tablaMantenimientosActivosFijos thead tr').clone(true).appendTo('#tablaMantenimientosActivosFijos thead');

$('#tablaMantenimientosActivosFijos thead tr:eq(1) th').each( function (i) {

    var title = $(this).text();
    $(this).html( '<input type="text" class="form-control" placeholder="Buscar..." />' );

    $( 'input', this ).on( 'keyup change', function () {

        if(tablaMantenimientosActivosFijos.column(i).search() !== this.value){

            tablaMantenimientosActivosFijos
                .column(i)
                .search( this.value )
                .draw();

        }

    })

})


$(document).ready(async function() {

    if (idEquipoBiomedico && idSoliMantenimiento && categoriaActivo) {

        await mostrarInfoEquipoBiomedico(idEquipoBiomedico);
        await mostrarInfoSolicitudMantenimiento(idSoliMantenimiento, categoriaActivo);
        await mostrarTiposMantenimientosGestion(idEquipoBiomedico, categoriaActivo);

    }

    if(idManteActivoFijo && categoriaActivo){

        await mostrarInformacionEdicionMantenimiento(idManteActivoFijo, categoriaActivo);

    }

});
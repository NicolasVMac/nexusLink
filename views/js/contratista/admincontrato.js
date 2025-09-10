function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let idContratista = atob(getParameterByName('idContratista'));
let idContrato = atob(getParameterByName('idContrato'));

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaTipoOtrosDocumentos'
    },
    success:function(respuesta){

        $("#oDTipoDocumento").html(respuesta);

    }

})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaTiposPolizas'
    },
    success:function(respuesta){

        $("#pTipoPoliza").html(respuesta);

    }

})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaAseguradorasPolizas'
    },
    success:function(respuesta){

        $("#pAseguradoraPoliza").html(respuesta);

    }

})

const obtenerInfoContrato = async (idContratista, idContrato) => {

    let datos = new FormData();
    datos.append('proceso','infoContratoContratista');
    datos.append('idContratista', idContratista);
    datos.append('idContrato', idContrato);

    const infoContrato = await $.ajax({
        url: 'ajax/contratistas/contratistas.ajax.php',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json"
    });

    if(!infoContrato){

        console.error("No Existe Contratista"); 
        return;
    }

    return infoContrato;

}

const crearTarifa = () => {

    let formulario = document.getElementById("formCrearTarifa");
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

            const formData = new FormData(formulario);

            formData.append('proceso', 'crearTarifa');
            formData.append('idContratista', idContratista);
            formData.append('idContrato', idContrato);
            formData.append('userCreate', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/contratistas/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Tarifa se registro correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                listaParTarifasPrestador.ajax.reload();
                                formulario.reset();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡La Tarifa no se registro correctamente!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const crearProrroga = () => {

    let formulario = document.getElementById("formCrearProrroga");
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

            const formData = new FormData(formulario);

            formData.append('proceso', 'crearProrroga');
            formData.append('idContrato', idContrato);
            formData.append('userCreate', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/contratistas/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Prorroga se registro correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                listaProrrogasContrato.ajax.reload();
                                formulario.reset();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡La Prorroga no se registro correctamente!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const eliminarProrroga = (idProrroga) => {

    Swal.fire({
        title: "¿Desea eliminar la Prorroga?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if(result.isConfirmed){

            const formData = new FormData();
            formData.append('proceso', 'eliminarProrroga');
            formData.append('idProrroga', idProrroga);
            formData.append('userCreate', userSession);

            $.ajax({

                url: 'ajax/contratistas/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({

                            text: '¡La Prorroga se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){
                                
                                listaProrrogasContrato.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'La Prorroga no se elimino correctamente',
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

const aplicarProrroga = (idProrroga, prorrogaMeses) => {

    Swal.fire({
        title: "¿Desea Aplicar la Prorroga al Contrato?",
        text: `Tenga en cuenta que la Fecha Fin de Vigencia del Contrato se le aumentaran ${prorrogaMeses} MESES.`,
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Aplicar Prorroga!"
    }).then((result) => {

        if(result.isConfirmed){

            const formData = new FormData();
            formData.append('proceso', 'aplicarProrrogaContrato');
            formData.append('idProrroga', idProrroga);
            formData.append('idContrato', idContrato);
            formData.append('prorrogaMeses', prorrogaMeses);
            formData.append('userCreate', userSession);

            $.ajax({

                url: 'ajax/contratistas/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({

                            text: '¡La Prorroga se Aplico correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){
                                
                                window.location = 'index.php?ruta=contratistas/admincontratocontratista&idContratista='+btoa(idContratista)+'&idContrato='+btoa(idContrato);

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'La Prorroga no se Aplico correctamente',
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

const agregarOtroDocumento = () => {

    let formulario = document.getElementById("formAgregarOtroDocumento");
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

            const formData = new FormData(formulario);
            
            formData.append('proceso', 'agregarOtroDocumento');
            formData.append('idContratista', idContratista);
            formData.append('idContrato', idContrato);
            formData.append('userCreate', userSession);


            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/contratistas/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    Swal.close();

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡El Otro Documento se guardo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                listaOtrosDocumentosContrato.ajax.reload();
                                $('#oDTipoDocumento').val('').trigger('change');
                                formulario.reset();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡El Otro Documento no se guardo correctamente!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const eliminarOtroDocumento = (idOtroDocumento) => {

    Swal.fire({
        title: "¿Desea eliminar el Otro Documento?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if(result.isConfirmed){

            const formData = new FormData();
            formData.append('proceso', 'eliminarOtroDocumento');
            formData.append('idOtroDocumento', idOtroDocumento);
            formData.append('userCreate', userSession);

            $.ajax({

                url: 'ajax/contratistas/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({

                            text: '¡El Otro Documento se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){
                                
                                listaOtrosDocumentosContrato.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'El Otro Documento no se elimino correctamente',
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

const changeValorFinalPorcentajePoliza = (tipoPoliza, element) => {

    let field = document.querySelector(`.valorFinal-${tipoPoliza}`);
    let valorContrato = document.querySelector('#pValorContrato').value;
    let valorFinal = 0;

    // if(valorContrato < 0 || valorContrato == ''){
    //     toastr.warning("Debe digitar el Valor Contrato para realizar los calculos correspondientes.", "¡Atencion!");
    //     return;
    // }

    if(valorContrato < 0 || valorContrato == ''){

        element.value = '';

        toastr.warning("Debe digitar el Valor Contrato para realizar los calculos correspondientes.", "¡Atencion!");
        return;

    }else{

        valorFinal = (valorContrato * element.value) / 100;
        field.value = valorFinal;

    }

}

const activeFormPolizaCivilExtracontractual = (element) => {

    let containerFormPolizaCivilExtra = document.querySelector('#containerFormTipoPolizaCivilExtra');

    if(element.checked){

        containerFormPolizaCivilExtra.innerHTML += `
            <hr class="mt-3">
            <h4 class="mb-2 mt-2">Civil Extra Contractual</h4>

            <div class="col-sm-12 col-md-4">
                <label>Fecha Fin</label>
                <input type="date" class="form-control" name="pFechaFinCivil" id="pFechaFinCivil" placeholder="Fecha Fin" required>
                <input type="hidden" class="form-control" name="pAmparoCivil" id="pAmparoCivil" value="CIVIL EXTRA CONTRACTUAL">
            </div>
            <div class="col-sm-12 col-md-4">
                <label>% Valor</label>
                <input type="number" class="form-control" name="pPorcenValorCivil" id="pPorcenValorCivil" onchange="changeValorFinalPorcentajePoliza('civil-extra', this)" required>
            </div>
            <div class="col-sm-12 col-md-4">
                <label>Valor Final</label>
                <input type="number" class="form-control readonly valorFinal-civil-extra" name="pValorFinalCivil" id="pValorFinalCivil" readonly required>
            </div>
            <hr class="mb-1 mt-3">
        `;

    }else{

        containerFormPolizaCivilExtra.innerHTML = ``;

    }

}

const changeFormTipoPoliza = (element) => {

    let tipoPoliza = element.value;
    let containerFormPoliza = document.querySelector('#containerFormTipoPoliza');
    let containerFormPolizaCivilExtra = document.querySelector('#containerFormTipoPolizaCivilExtra');

    containerFormPoliza.innerHTML = ``;
    containerFormPolizaCivilExtra.innerHTML = ``;

    if(tipoPoliza == 'GARANTIA UNICA'){

        containerFormPoliza.innerHTML = `

            <div class="col-sm-12 col-md-4">
                <label>Fecha Inicio</label>
                <input type="date" class="form-control" name="pFechaInicio" id="pFechaInicio" placeholder="Fecha Inicio" required>
            </div>
            <div class="col-sm-12 col-md-4">
                <label>Valor Contrato</label>
                <input type="number" class="form-control" name="pValorContrato" id="pValorContrato" placeholder="Valor Contrato" required>
            </div>
            <div class="col-sm-12 col-md-4">
                <label>Documento</label>
                <input type="file" class="form-control" name="pDocumento" id="pDocumento" accept=".pdf" required>
            </div>

            <div class="col-sm-12 col-md-4 mt-2">
                <div class="form-check form-switch">
                    <input class="form-check-input mt-2" id="polizaCivilExtraContractual" onchange="activeFormPolizaCivilExtracontractual(this)" type="checkbox"/>
                    <label class="form-check-label" for="polizaCivilExtraContractual">Civil Extra Contractual</label>
                </div>
            </div>

            <hr>

            <h4 class="mb-2 mt-1">Cumplimiento</h4>

            <div class="col-sm-12 col-md-4">
                <label>Fecha Fin</label>
                <input type="date" class="form-control" name="pFechaFinCumpli" id="pFechaFinCumpli" placeholder="Fecha Fin" required>
                <input type="hidden" class="form-control" name="pAmparoCumpli" id="pAmparoCumpli" value="CUMPLIMIENTO">
            </div>
            <div class="col-sm-12 col-md-4">
                <label>% Valor</label>
                <input type="number" class="form-control" name="pPorcenValorCumpli" id="pPorcenValorCumpli" onchange="changeValorFinalPorcentajePoliza('cumplimiento', this)" required>
            </div>
            <div class="col-sm-12 col-md-4">
                <label>Valor Final</label>
                <input type="number" class="form-control readonly valorFinal-cumplimiento" name="pValorFinalCumpli" id="pValorFinalCumpli" readonly required>
            </div>

            <hr class="mt-3">

            <h4 class="mb-2 mt-1">Calidad del Bien o Servicio</h4>

            <div class="col-sm-12 col-md-4">
                <label>Fecha Fin</label>
                <input type="date" class="form-control" name="pFechaFinCalidad" id="pFechaFinCalidad" placeholder="Fecha Fin" required>
                <input type="hidden" class="form-control" name="pAmparoCalidad" id="pAmparoCalidad" value="CALIDAD BIEN O SERVICIO">
            </div>
            <div class="col-sm-12 col-md-4">
                <label>% Valor</label>
                <input type="number" class="form-control" name="pPorcenValorCalidad" id="pPorcenValorCalidad" onchange="changeValorFinalPorcentajePoliza('calidad', this)" required>
            </div>
            <div class="col-sm-12 col-md-4">
                <label>Valor Final</label>
                <input type="number" class="form-control readonly valorFinal-calidad" name="pValorFinalCalidad" id="pValorFinalCalidad" readonly required>
            </div>

            <hr class="mt-3">

            <h4 class="mb-2 mt-1">Pago de Salarios, Prestaciones Sociales e Indemnizaciones</h4>

            <div class="col-sm-12 col-md-4">
                <label>Fecha Fin</label>
                <input type="date" class="form-control" name="pFechaFinSalarios" id="pFechaFinSalarios" placeholder="Fecha Fin" required>
                <input type="hidden" class="form-control" name="pAmparoSalarios" id="pAmparoSalarios" value="PAGO SALARIOS O PRESTACIONES">
            </div>
            <div class="col-sm-12 col-md-4">
                <label>% Valor</label>
                <input type="number" class="form-control" name="pPorcenValorSalarios" id="pPorcenValorSalarios" onchange="changeValorFinalPorcentajePoliza('salarios', this)" required>
            </div>
            <div class="col-sm-12 col-md-4">
                <label>Valor Final</label>
                <input type="number" class="form-control readonly valorFinal-salarios" name="pValorFinalSalarios" id="pValorFinalSalarios" readonly required>
            </div>

        `;

    }else if(tipoPoliza == 'RESPONSABILIDAD - MEDICA'){

        containerFormPoliza.innerHTML = `
            <h4 class="mb-2 mt-1">Responsabilidad Civil Profesional Médica</h4>

            <div class="col-sm-12 col-md-3">
                <label>Fecha Inicio</label>
                <input type="date" class="form-control" name="pFechaInicioResMed" id="pFechaInicioResMed" required>
                <input type="hidden" class="form-control" name="pAmparoResMed" id="pAmparoResMed" value="RESPONSABILIDAD CIVIL PROFESIONAL MEDICA" required>
            </div>
            <div class="col-sm-12 col-md-3">
                <label>Fecha Fin</label>
                <input type="date" class="form-control" name="pFechaFinResMed" id="pFechaFinResMed" required>
            </div>
            <div class="col-sm-12 col-md-3">
                <label>Valor Poliza</label>
                <input type="number" class="form-control" name="pValorFinalResMed" id="pValorFinalResMed" required>
            </div>
            <div class="col-sm-12 col-md-3">
                <label>Documento</label>
                <input type="file" class="form-control" name="pDocumento" id="pDocumento" accept=".pdf" required>
            </div>
            <div class="col-sm-12 col-md-12">
                <label>Observaciones</label>
                <textarea class="form-control" minlength="10" maxlength="5000" name="pObservacionesResMed" id="pObservacionesResMed" placeholder="Observaciones" rows="5" required></textarea>
            </div>
        
        `;

    }else if(tipoPoliza == 'RESPONSABILIDAD - CLINICA Y/O HOSPITALES'){

        containerFormPoliza.innerHTML = `
            <h4 class="mb-2 mt-1">Responsabilidad Civil Profesional Clínicas y/o Hospitales</h4>

            <div class="col-sm-12 col-md-3">
                <label>Fecha Inicio</label>
                <input type="date" class="form-control" name="pFechaInicioResCli" id="pFechaInicioResCli" required>
                <input type="hidden" class="form-control" name="pAmparoResCli" id="pAmparoResCli" value="RESPONSABILIDAD CIVIL PROFESIONAL CLINICAS Y HOSPITALES" required>
            </div>
            <div class="col-sm-12 col-md-3">
                <label>Fecha Fin</label>
                <input type="date" class="form-control" name="pFechaFinResCli" id="pFechaFinResCli" required>
            </div>
            <div class="col-sm-12 col-md-3">
                <label>Valor Poliza</label>
                <input type="number" class="form-control" name="pValorFinalResCli" id="pValorFinalResCli" required>
            </div>
            <div class="col-sm-12 col-md-3">
                <label>Documento</label>
                <input type="file" class="form-control" name="pDocumento" id="pDocumento" accept=".pdf" required>
            </div>
            <div class="col-sm-12 col-md-12">
                <label>Observaciones</label>
                <textarea class="form-control" minlength="10" maxlength="5000" name="pObservacionesResCli" id="pObservacionesResCli" placeholder="Observaciones" rows="5" required></textarea>
            </div>
        
        `;

    }else if(tipoPoliza == 'OTRAS POLIZAS'){

        containerFormPoliza.innerHTML = `
            <h4 class="mb-2 mt-1">Otra Poliza</h4>

            <div class="col-sm-12 col-md-3">
                <label>Fecha Inicio</label>
                <input type="date" class="form-control" name="pFechaInicioOtraPoli" id="pFechaInicioOtraPoli" required>
            </div>
            <div class="col-sm-12 col-md-3">
                <label>Fecha Fin</label>
                <input type="date" class="form-control" name="pFechaFinOtraPoli" id="pFechaFinOtraPoli" required>
            </div>
            <div class="col-sm-12 col-md-3">
                <label>Nombre Poliza</label>
                <input type="text" class="form-control" name="pNombrePolizaOtraPoli" id="pNombrePolizaOtraPoli" placeholder="Nombre Poliza" required>
            </div>
            <div class="col-sm-12 col-md-3">
                <label>Valor Poliza</label>
                <input type="number" class="form-control" name="pValorFinalOtraPoli" id="pValorFinalOtraPoli" required>
            </div>
            <div class="col-sm-12 col-md-6">
                <label>Documento</label>
                <input type="file" class="form-control" name="pDocumento" id="pDocumento" accept=".pdf" required>
            </div>
            <div class="col-sm-12 col-md-6">
                <label>Observaciones</label>
                <textarea class="form-control" minlength="10" maxlength="5000" name="pObservacionesOtraPoli" id="pObservacionesOtraPoli" placeholder="Observaciones" rows="5" required></textarea>
            </div>
        
        `;

    }

}

const crearPoliza = () => {

    let formulario = document.getElementById("formCrearPoliza");
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

            const formData = new FormData(formulario);

            formData.append('proceso', 'crearPoliza');
            formData.append('idContrato', idContrato);
            formData.append('idContratista', idContratista);
            formData.append('userCreate', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            // loadingFnc();

            $.ajax({

                url: 'ajax/contratistas/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Poliza se registro correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                listaPolizasContrato.ajax.reload();
                                $('#pTipoPoliza').val('').trigger('change');
                                $('#pAseguradoraPoliza').val('').trigger('change');
                                formulario.reset();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡La Poliza no se registro correctamente!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const eliminarPoliza = (idPoliza) => {

    Swal.fire({
        title: "¿Desea eliminar la Poliza?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if(result.isConfirmed){

            const formData = new FormData();
            formData.append('proceso', 'eliminarPoliza');
            formData.append('idPoliza', idPoliza);
            formData.append('userCreate', userSession);

            $.ajax({

                url: 'ajax/contratistas/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({

                            text: '¡La Poliza se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){
                                
                                listaPolizasContrato.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'La Poliza no se elimino correctamente',
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

const changeFormTipoOtroSi = async (element) => {

    let tipoOtroSi = element.value;
    let containerFormTipoOtroSi = document.querySelector('#containerFormTipoOtroSi');
    let infoContrato = await obtenerInfoContrato(idContratista, idContrato);

    containerFormTipoOtroSi.innerHTML = ``;

    if(tipoOtroSi == 'PRORROGA'){

        containerFormTipoOtroSi.innerHTML = `
            <div class="col-sm-12 col-md-3">
                <label>Fecha Inicio</label>
                <input type="date" class="form-control" name="cOSFechaInicioProrroga" id="cOSFechaInicioProrroga" value="${infoContrato.fecha_fin_real}" required>
            </div>
            <div class="col-sm-12 col-md-3">
                <label>Fecha Fin</label>
                <input type="date" class="form-control" name="cOSFechaFinProrroga" id="cOSFechaFinProrroga" min="${infoContrato.fecha_fin_real}" required>
            </div>
            <div class="col-sm-12 col-md-6">
                <label>Observaciones</label>
                <textarea class="form-control" minlength="10" maxlength="5000" name="cOSObservacionesProrroga" id="cOSObservacionesProrroga" placeholder="Observaciones" rows="5" required></textarea>
            </div>
        
        `;

    }else if(tipoOtroSi == 'ADICION'){

        containerFormTipoOtroSi.innerHTML = `
            <div class="col-sm-12 col-md-2">
                <label>Valor</label>
                <input type="number" class="form-control" name="cOSValorAdicion" min="0" id="cOSValorAdicion" required>
            </div>
            <div class="col-sm-12 col-md-10">
                <label>Observaciones</label>
                <textarea class="form-control" minlength="10" maxlength="5000" name="cOSObservacionesAdicion" id="cOSObservacionesAdicion" placeholder="Observaciones" rows="5" required></textarea>
            </div>
        
        `;

    }

}

const crearContratoOtroSi = () => {

    let formulario = document.getElementById("formCrearContratoOtroSi");
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

            const formData = new FormData(formulario);

            formData.append('proceso', 'crearOtroSi');
            formData.append('idContrato', idContrato);
            formData.append('idContratista', idContratista);
            formData.append('userCreate', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            $.ajax({

                url: 'ajax/contratistas/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡El Contrato Otro Si se registro correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=contratistas/admincontratocontratista&idContratista='+btoa(idContratista)+'&idContrato='+btoa(idContrato);

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡El Contrato Otro Si no se registro correctamente!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "¡Atencion!");

        }

    }

}

const eliminarContratoOtroSi = (idContratoOtraSi) => {

    Swal.fire({
        title: "¿Desea eliminar el Contrato Otro Si?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Eliminar!"
    }).then((result) => {

        if(result.isConfirmed){

            const formData = new FormData();
            formData.append('proceso', 'eliminarContratoOtroSi');
            formData.append('idContratoOtraSi', idContratoOtraSi);
            formData.append('userCreate', userSession);

            $.ajax({

                url: 'ajax/contratistas/contratistas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({

                            text: '¡El Contrato Otro Si se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33",

                        }).then((result) =>{

                            if(result.isConfirmed){
                                
                                listaContratosOtroSiContrato.ajax.reload();

                            }

                        })

                    }else{

                        Swal.fire({
                            text: 'El Contrato Otro Si no se elimino correctamente',
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

const irAdminTarifas = (idParTarifario) => {

    window.location = 'index.php?ruta=contratistas/admintarifas&idContratista='+btoa(idContratista)+'&idContrato='+btoa(idContrato)+'&idTarifario='+btoa(idParTarifario);

}

listaParTarifasPrestador = $('#listaParTarifasPrestador').DataTable({

    columns: [
        { title: '#', data: 'id_par_tarifa_contratista' },
        { title: 'NOMBRE TARIFA', data: 'nombre_tarifa' },
        {
            title: 'OPCIONES', orderable: false, data: null, render: function (data, type, row) {
                return `
                    <button type="button" class="btn btn-outline-success btn-sm" title="Administrar Tarifas" onclick="irAdminTarifas(${row.id_par_tarifa_contratista})"><i class="far fa-plus-square"></i></button>
                `;
            }
        }
    ],
    ordering: false,
    ajax: {
        url: 'ajax/contratistas/contratistas.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaParTarifasPrestador',
            idContratista: idContratista,
            idContrato: idContrato
        }
    }

});


listaProrrogasContrato = $('#listaProrrogasContrato').DataTable({

    columns: [
        { title: '#', data: 'id_prorroga' },
        { title: 'PRORROGA MESES', data: 'prorroga_meses', render: function(data){
            return `${data} MESES`;
        }},
        { title: 'OBSERVACIONES', data: 'observaciones' },
        { title: 'ESTADO', data: 'estado', render: function(data){
            if(data === 'DISPONIBLE'){
                return `<span class="badge badge-phoenix badge-phoenix-success">DISPONIBLE</span>`;
            }else{
                return `<span class="badge badge-phoenix badge-phoenix-danger">APLICADO</span>`;
            }
        }},
        {
            title: 'OPCIONES', orderable: false, data: null, render: function (data, type, row) {
                if(row.estado == 'DISPONIBLE'){
                    return `
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="aplicarProrroga(${row.id_prorroga}, ${row.prorroga_meses})" title="Aplicar Prorroga"><i class="far fa-calendar-check"></i></button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarProrroga(${row.id_prorroga})" title="Eliminar Prorroga"><i class="far fa-trash-alt"></i></button>
                    `;
                    
                }else{
                    return ``;
                }
            }
        }
    ],
    ajax: {
        url: 'ajax/contratistas/contratistas.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaProrrogasContrato',
            idContrato: idContrato
        }
    }

});

listaOtrosDocumentosContrato = $('#listaOtrosDocumentosContrato').DataTable({

    columns: [
        { title: '#', data: 'id_otro_documento' },
        { title: 'TIPO DOCUMENTO', data: 'tipo_documento'},
        { title: 'DOCUMENTO', data: 'ruta_documento', render: function(data){
            return `<a class="" target="_blank" href="${data}"><span class="badge badge-phoenix badge-phoenix-danger" style="font-size: 30px;"><i class="far fa-file-pdf"></i></span></a>`;
        }},
        { title: 'OBSERVACIONES', data: 'observaciones', render: function(data){
            return `<textarea class="form-control" rows="5">${data}</textarea>`;
        }},
        {
            title: 'OPCIONES', orderable: false, data: null, render: function (data, type, row) {
                return `
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarOtroDocumento(${row.id_otro_documento})" title="Eliminar Otro Documento"><i class="far fa-trash-alt"></i></button>
                `;
                    
               
            }
        }
    ],
    ajax: {
        url: 'ajax/contratistas/contratistas.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaOtrosDocumentosContrato',
            idContrato: idContrato
        }
    }

});

listaPolizasContrato = $('#listaPolizasContrato').DataTable({

    columns: [
        { title: '#', data: 'id_poliza' },
        { title: 'ASEGURADOR', data: 'aseguradora'},
        { title: 'TIPO POLIZA', data: 'tipo_poliza'},
        { title: 'NUMERO POLIZA', data: 'numero_poliza'},
        { title: 'AMPARO', data: 'amparo'},
        { title: 'FECHA INICIO', data: 'fecha_inicio'},
        { title: 'FECHA FIN', data: 'fecha_fin'},
        { title: 'VALOR ESTIMADO', data: 'valor_contrato'},
        { title: 'VALOR AMPARO', data: 'valor_final'},
        { title: 'DOCUMENTO', data: 'ruta_documento_poliza', render: function(data){
            return `<a class="" target="_blank" href="${data}"><span class="badge badge-phoenix badge-phoenix-danger" style="font-size: 30px;"><i class="far fa-file-pdf"></i></span></a>`;
        }},
        {
            title: 'OPCIONES', orderable: false, data: null, render: function (data, type, row) {
                return `
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarPoliza(${row.id_poliza})" title="Eliminar Poliza"><i class="far fa-trash-alt"></i></button>
                `;
                    
               
            }
        }
    ],
    ajax: {
        url: 'ajax/contratistas/contratistas.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaPolizasContrato',
            idContrato: idContrato
        }
    }

});

listaContratosOtroSiContrato = $('#listaContratosOtroSiContrato').DataTable({

    columns: [
        { title: '#', data: 'id_contrato_otro_si' },
        { title: 'TIPO OTRO SI', data: 'tipo_otro_si'},
        { title: 'NUMERO OTRO SI', data: 'numero_contrato_otro_si'},
        { title: 'FECHA OTRO SI', data: 'fecha_otro_si'},
        { title: 'FECHA INICIO', data: 'fecha_inicio'},
        { title: 'FECHA FIN', data: 'fecha_fin'},
        { title: 'VALOR ADICION', data: 'valor_adicion'},
        { title: 'DOCUMENTO', data: 'ruta_documento', render: function(data){
            return `<a class="" target="_blank" href="${data}"><span class="badge badge-phoenix badge-phoenix-danger" style="font-size: 30px;"><i class="far fa-file-pdf"></i></span></a>`;
        }},
        {
            title: 'OPCIONES', orderable: false, data: null, render: function (data, type, row) {
                return `
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarContratoOtroSi(${row.id_contrato_otro_si})" title="Eliminar Poliza"><i class="far fa-trash-alt"></i></button>
                `;
                    
               
            }
        }
    ],
    ajax: {
        url: 'ajax/contratistas/contratistas.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaContratosOtroSiContrato',
            idContrato: idContrato
        }
    }

});

(async () => {

    if (idContratista && idContrato){

        let datosContrato = await obtenerInfoContrato(idContratista, idContrato);

        if(datosContrato){

            // console.log(datosContrato)

            $('#titlePage').text('Administrar Contrato Contratista: ' + datosContrato.nombre_contratistas + ' - Contrato: ' + datosContrato.nombre_contrato);
            $('#textTipoContratista').text(datosContrato.tipo_contratista_full);
            $('#textNombreContratista').text(datosContrato.nombre_contratistas);
            $('#textTipoIdentiContratista').text(datosContrato.tipo_identi_contratistas + ' - ' + datosContrato.tipo_documento_contratista);
            $('#textNumeroIdentiContratista').text(datosContrato.numero_identi_contratistas);
            $('#textDireccionContratista').text(datosContrato.direccion_contratistas);
            $('#textTelefonoContratista').text(datosContrato.telefono_contratistas);
            $('#textCorreoContratista').text(datosContrato.correo);
            $('#textDepartamentoContratista').text(datosContrato.departamento);
            $('#textCiudadContratista').text(datosContrato.ciudad);

            $('#textTipoContrato').text(datosContrato.tipo_contrato);
            $('#textNombreContrato').text(datosContrato.nombre_contrato);
            $('#textVigenciaContrato').html(`<span class="badge badge-phoenix badge-phoenix-success">${datosContrato.fecha_inicio}</span> - <span class="badge badge-phoenix badge-phoenix-danger">${datosContrato.fecha_fin_real}</span>`);

            if(datosContrato.cuantia_indeterminada == 'SI'){
                $('#textValorContrato').html(`<span class="badge badge-phoenix badge-phoenix-secondary">Cuantia Indeterminada</span>`);
            }else{
                $('#textValorContrato').html(datosContrato.valor_contrato);
            }
            
            $('#textArchivoContrato').html(`<a class="" target="_blank" href="${datosContrato.ruta_archivo_contrato}"><span class="badge badge-phoenix badge-phoenix-danger" style="font-size: 30px;"><i class="far fa-file-pdf"></i></span></a>`);
            $('#textObjetoContractualContrato').text(datosContrato.objeto_contractual);

        }

    }

})();
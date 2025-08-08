/*==============================
VARIABLES DE RUTA
==============================*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

let idCita = atob(getParameterByName('idCita'));
let idPreCita = atob(getParameterByName('idPreCita'));
let idCitaReAgendar = atob(getParameterByName('idCitaReAgendar'));
let cohortePrograma = atob(getParameterByName('cohortePrograma'));
// let idUserSession = document.getElementById("idUserSession").value;
let tablaCitasPendientesMedico, tablaCitasPaciente, tablaBolsaPreCitas, tablaPendientePreCitasUser, tablaPreCitasCreadas;

/*============================
LISTA COHORTE O PROGRAMAS AGENDAMIENTO
============================*/

$.ajax({

    type: "POST",
    url: "ajax/di/agendamiento.ajax.php",
    data: {
        'proceso': 'listaCohorteProgramas'
    },
    success:function(respuesta){

        $("#cohortePrograma").html(respuesta);

    }

})

$.ajax({

    type: "POST",
    url: "ajax/parametricas.ajax.php",
    data: {
        'lista': 'listaLocalidades'
    },
    success:function(respuesta){

        $("#localidadCita").html(respuesta);

    }

})



const gestionarCita = (idCita, estado, cohortePrograma, idProfesional) => {

    // console.log({idCita, estado, cohortePrograma});

    // console.log(idProfesional);

    if(estado == 'CREADA'){

        $.ajax({

            url: 'ajax/di/citas.ajax.php',
            type: 'POST',
            data: {
                'proceso': 'gestionarCita',
                'idCita':idCita,
                'idProfesional':idProfesional,
                'estado':'PROCESO'
            },
            success:function(respuesta){

                if(respuesta == 'ok'){

                    window.location = 'index.php?ruta=di/gestionarcita&idCita='+btoa(idCita)+"&cohortePrograma="+btoa(cohortePrograma);

                }else if(respuesta == 'error-cita-proceso'){

                    Swal.fire({
                        text: '¡La Cita no se puede iniciar porque tiene otra Cita en Proceso!',
                        icon: 'error',
                        confirmButtonText: 'Cerrar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: "#d33"
                    })

                }else{

                    Swal.fire({
                        text: '¡Error inesperado!',
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

        window.location = 'index.php?ruta=di/gestionarcita&idCita='+btoa(idCita)+"&cohortePrograma="+btoa(cohortePrograma);

    }

}

const guardarCitaVacunacion = () => {

    let formulario = document.getElementById("formCitaVacunacion");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let vacunaAdministrada = document.getElementById("vacunaAdministrada").value;
            let dosisAdministrada = document.getElementById("dosisAdministrada").value;
            let fechaAdministracion = document.getElementById("fechaAdministracion").value;
            let observaciones = document.getElementById("observacionesVacunacion").value;

            Swal.fire({
                title: "¿Desea guardar la informacion de Vacunacion?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Guardar!"
            }).then((result) => {
        
                if (result.isConfirmed) {

                    $.ajax({

                        url: 'ajax/di/citas.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'guardarGestionCitaVacunacion',
                            'formulario':'VACUNACION',
                            'idCita': idCita,
                            'vacunaAdministrada': vacunaAdministrada,
                            'dosisAdministrada': dosisAdministrada,
                            'fechaAdministracion': fechaAdministracion,
                            'observaciones': observaciones,
                            'usuarioCrea': userSession
                        },
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Cita Vacunacion se completo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=di/citaspendientesmedico';
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    text: '¡La Cita Vacunacion no se completo correctamente!',
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


        }else{

            toastr.warning("El Formulario de Vacunacion debe ser diligenciado completamente.", "¡Atencion!");

        }
    
    }

}


const guardarCitaSaludInfantil = () => {

    let formulario = document.getElementById("formCitaSaludInfantil");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let peso = document.getElementById("pesoSaludInfantil").value;
            let talla = document.getElementById("tallaSaludInfantil").value;
            let perimetroBraquial = document.getElementById("perimetroBraquial").value;
            let lactanciaMaternaExclusiva = document.getElementById("lactanciaMaternaExclu").value;
            let consejeriaLactanciaMaterna = document.getElementById("consejeriaLactanciaMaterna").value;
            let verificacionEsquemaPAICovid = document.getElementById("verificacionEsquemaPaiCovid").value;
            let soporteNutricional = document.getElementById("soporteNutricional").value;
            let nombreSoporteNutricional = document.getElementById("nombreSoporteNutricional").value;
            let formulacionApme = document.getElementById("formularioApme").value;
            let entregaApme = document.getElementById("entregaApme").value;
            let oximetria = document.getElementById("oximetriaSaludInfantil").value;
            let sintomatologiaRespiratoria = document.getElementById("sintomatologiaRespiratoria").value;
            let condicionesRiesgo = document.getElementById("condicionesRiesgo").value;
            let educacionSignosAlarma = document.getElementById("educacionSignosAlarma").value;
            let remisionUrgencias = document.getElementById("remisionUrgencias").value;
            let remisionEspecialidades = document.getElementById("remisionEspecialidades").value;
            let remisionManejoIntramural = document.getElementById("remisionManejoIntramural").value;

            Swal.fire({
                title: "¿Desea guardar la informacion de Salud Infantil?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Guardar!"
            }).then((result) => {
        
                if (result.isConfirmed) {

                    $.ajax({

                        url: 'ajax/di/citas.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'guardarGestionCitaSaludInfantil',
                            'formulario':'SALUD INFANTIL',
                            'idCita': idCita,
                            'peso': peso,
                            'talla': talla,
                            'perimetroBraquial': perimetroBraquial,
                            'lactanciaMaternaExclusiva': lactanciaMaternaExclusiva,
                            'consejeriaLactanciaMaterna': consejeriaLactanciaMaterna,
                            'verificacionEsquemaPAICovid': verificacionEsquemaPAICovid,
                            'soporteNutricional': soporteNutricional,
                            'nombreSoporteNutricional': nombreSoporteNutricional,
                            'formulacionApme': formulacionApme,
                            'entregaApme': entregaApme,
                            'oximetria': oximetria,
                            'sintomatologiaRespiratoria': sintomatologiaRespiratoria,
                            'condicionesRiesgo': condicionesRiesgo,
                            'educacionSignosAlarma': educacionSignosAlarma,
                            'remisionUrgencias': remisionUrgencias,
                            'remisionEspecialidades': remisionEspecialidades,
                            'remisionManejoIntramural': remisionManejoIntramural,
                            'usuarioCrea': userSession
                        },
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Cita Salud Infantil se completo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=di/citaspendientesmedico';
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    text: '¡La Cita Salud Infantil no se completo correctamente!',
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


        }else{

            toastr.warning("El Formulario de Salud Infantil debe ser diligenciado completamente.", "¡Atencion!");

        }

    }

}

const guardarCitaMaternoPerinatal = () => {

    let formulario = document.getElementById("formCitaMaternoPerinatal");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let tamizajeSaludMental = document.getElementById("tamizajeSaludMental").value;
            let educacionIndividualFamiliar = document.getElementById("educacionIndividualFamiliar").value;
            let inicioReferenciaContrareferencia = document.getElementById("inicioReferenciaContra").value;
            let notificacionInmediataAlertas = document.getElementById("notificacionAlertas").value;
            let consultaGestante = document.getElementById("consultaGestante").value;
            let verificacionCpnVacunacion = document.getElementById("verificacionCpnVacunacion").value;
            let identificacionRiesgo = document.getElementById("identificacionRiesgo").value;
            let realizacionEstrategiaEtmiPlus = document.getElementById("realizacionEstrategia").value;
            let verificacionAdministracionPnc = document.getElementById("verificacionAdministracionPNC").value;
            let captacionParejaTratamientoSifilisCongenita = document.getElementById("captacionTratamientoSifilis").value;
            let ordenProvisionPreservativos = document.getElementById("ordenProvisionPreservativo").value;
            let educacionSignosAlarma = document.getElementById("educacionSignosAlarma").value;
            let notificacionCohorteMp = document.getElementById("notificacionCohorteMp").value;
            let asesoriaPlanificacionFamiliar = document.getElementById("asesoriaPlanificacionFamiliar").value;
            let demandaInducidaPf = document.getElementById("demandaInducidaPf").value;
            let demandaInducidaPreconcepcional = document.getElementById("demandaInducidaPreconcepcional").value;
            let disentimientoPnfCitaPercepcional = document.getElementById("disentimientoPnfCitaPercepcional").value;
            let estadoCaso = document.getElementById("estadoCaso").value;
            let observaciones = document.getElementById("observaciones").value;


            // let macActual = document.getElementById("macActual").value;
            // let fechaInicio = document.getElementById("fechaInicio").value;
            // let macEntregado = document.getElementById("macEntregado").value;
            // let fechaEntrega = document.getElementById("fechaEntrega").value;
            // let formulaMac = document.getElementById("formulaMac").value;
            // let formatoProcedimientoQx = document.getElementById("formatoProcedimientoQx").value;

            Swal.fire({
                title: "¿Desea guardar la informacion de Materno Perinatal y SSR?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Guardar!"
            }).then((result) => {
        
                if (result.isConfirmed) {

                    $.ajax({

                        url: 'ajax/di/citas.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'guardarGestionCitaMaternoPerinatal',
                            'formulario':'MATERNO PERINATAL Y SSR',
                            'idCita': idCita,
                            'tamizajeSaludMental': tamizajeSaludMental,
                            'educacionIndividualFamiliar': educacionIndividualFamiliar,
                            'inicioReferenciaContrareferencia': inicioReferenciaContrareferencia,
                            'notificacionInmediataAlertas': notificacionInmediataAlertas,
                            'consultaGestante': consultaGestante,
                            'verificacionCpnVacunacion': verificacionCpnVacunacion,
                            'identificacionRiesgo': identificacionRiesgo,
                            'realizacionEstrategiaEtmiPlus': realizacionEstrategiaEtmiPlus,
                            'verificacionAdministracionPnc': verificacionAdministracionPnc,
                            'captacionParejaTratamientoSifilisCongenita': captacionParejaTratamientoSifilisCongenita,
                            'ordenProvisionPreservativos': ordenProvisionPreservativos,
                            'educacionSignosAlarma': educacionSignosAlarma,
                            'notificacionCohorteMp': notificacionCohorteMp,
                            'asesoriaPlanificacionFamiliar': asesoriaPlanificacionFamiliar,
                            'demandaInducidaPf': demandaInducidaPf,
                            'demandaInducidaPreconcepcional': demandaInducidaPreconcepcional,
                            'disentimientoPnfCitaPercepcional': disentimientoPnfCitaPercepcional,
                            'estadoCaso':estadoCaso,
                            'observaciones':observaciones,
                            'usuarioCrea': userSession
                        },
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Cita Materno Perinatal y SSR se completo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=di/citaspendientesmedico';
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    text: '¡La Cita Materno Perinatal y SSR no se completo correctamente!',
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

        }else{

            toastr.warning("El Formulario de Materno Perinatal y SSR debe ser diligenciado completamente.", "¡Atencion!");

        }

    }

}

const guardarCitaCronicos = () => {

    let formulario = document.getElementById("formCitaCronicos");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let tf = document.getElementById("tf").value;
            let too = document.getElementById("too").value;
            let tl = document.getElementById("tl").value;
            let tr = document.getElementById("tr").value;
            let psicologia = document.getElementById("psicologia").value;
            let trabajoSocial = document.getElementById("trabajoSocial").value;
            let nutricion = document.getElementById("nutricion").value;
            let tomaLaboratorios = document.getElementById("tomaLaboratorios").value;
            let numeroProximoControl = document.getElementById("numeroProximoControl").value;
            let especificacionProximoControl = document.getElementById("especificacionProximoControl").value;
            let clinicaHeridas = document.getElementById("clinicaHeridas").value;
            let cambioSonda = document.getElementById("cambioSonda").value;
            let phdCronicosAgudizados = document.getElementById("phdCronicosAgudizados").value;
            let suspendeTratamiento = document.getElementById("suspendeTratamiento").value;
            let finalizaTratamiento = document.getElementById("finalizaTratamiento").value;
            let cambioManejo = document.getElementById("cambioManejo").value;
            let inicia = document.getElementById("inicia").value;
            let termina = document.getElementById("termina").value;
            let observaciones = document.getElementById("observaciones").value;

            Swal.fire({
                title: "¿Desea guardar la informacion de Cronicos?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Guardar!"
            }).then((result) => {
        
                if (result.isConfirmed) {

                    $.ajax({

                        url: 'ajax/di/citas.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'guardarGestionCitaCronicos',
                            'formulario':'CRONICOS',
                            'idCita': idCita,
                            'tf': tf,
                            'too': too,
                            'tl': tl,
                            'tr': tr,
                            'psicologia': psicologia,
                            'trabajoSocial': trabajoSocial,
                            'nutricion': nutricion,
                            'tomaLaboratorios': tomaLaboratorios,
                            'numeroProximoControl': numeroProximoControl,
                            'especificacionProximoControl': especificacionProximoControl,
                            'clinicaHeridas': clinicaHeridas,
                            'cambioSonda': cambioSonda,
                            'phdCronicosAgudizados': phdCronicosAgudizados,
                            'suspendeTratamiento': suspendeTratamiento,
                            'finalizaTratamiento': finalizaTratamiento,
                            'cambioManejo': cambioManejo,
                            'inicia': inicia,
                            'termina': termina,
                            'observaciones': observaciones,
                            'usuarioCrea': userSession
                        },
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Cita Cronicos se completo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=di/citaspendientesmedico';
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    text: '¡La Cita Cronicos no se completo correctamente!',
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


        }else{

            toastr.warning("El Formulario de Vacunacion debe ser diligenciado completamente.", "¡Atencion!");

        }
    
    }

}


const guardarCitaFallida = () => {

    console.log(idCita);
    console.log('Cita Fallida');

    Swal.fire({
        title: "¿Desea Terminar la Cita como Fallida?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si, Terminar!"
    }).then(async (result) => {

        //console.log(descripcionTicket.value);

        if (result.isConfirmed) {

            const { value: observacionFallida } = await Swal.fire({
                text: "Observacion Fallida:",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si, Terminar!",
                allowOutsideClick: false,
                allowEscapeKey: false,
                input: "text",
                inputAttributes: {
                    autocapitalize: "off",
                    required: "true",
                    minlength: "10",
                    maxlength: "1000",
                    placeholder: "Observaciones..."
                },
                inputValidator: (value) => {
                    if (!value) {
                        return "¡Para Terminar la Cita como Fallida debe digitar una Observacion!";
                    }
                }
            });
            if(observacionFallida){

                $.ajax({

                    url: 'ajax/di/citas.ajax.php',
                    type: 'POST',
                    data: {
                        'proceso': 'guardarGestionCitaFallida',
                        'idCita': idCita,
                        'observacionesFallida': observacionFallida
                    },
                    success:function(respuesta){

                        if(respuesta == 'ok'){

                            Swal.fire({
                                text: '¡La Cita se guardo como Fallida correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: "#d33"
                            }).then((result) =>{
    
                                if(result.isConfirmed){
    
                                    window.location = 'index.php?ruta=di/citaspendientesmedico';
    
                                }
    
                            })

                        }else{

                            Swal.fire({
                                text: '¡La Cita no se guardo correctamente!',
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

        }

    })

}

const guardarCitaPhd = () => {

    let formulario = document.getElementById("formCitaPhd");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let tf = document.getElementById("tf").value;
            let too = document.getElementById("too").value;
            let tl = document.getElementById("tl").value;
            let tr = document.getElementById("tr").value;
            let succion = document.getElementById("succion").value;
            let tomaLaboratorios = document.getElementById("tomaLaboratorios").value;
            let numeroProximoControl = document.getElementById("numeroProximoControl").value;
            let especificacionProximoControl = document.getElementById("especificacionProximoControl").value;
            let clinicaHeridas = document.getElementById("clinicaHeridas").value;
            let cambioSonda = document.getElementById("cambioSonda").value;
            let suspendeTratamiento = document.getElementById("suspendeTratamiento").value;
            let finalizaTratamiento = document.getElementById("finalizaTratamiento").value;
            let cambioManejo = document.getElementById("cambioManejo").value;
            let observaciones = document.getElementById("observaciones").value;

            Swal.fire({
                title: "¿Desea guardar la informacion de Cronicos?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Guardar!"
            }).then((result) => {
        
                if (result.isConfirmed) {

                    $.ajax({

                        url: 'ajax/di/citas.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'guardarGestionCitaPhd',
                            'formulario':'PHD',
                            'idCita': idCita,
                            'tf': tf,
                            'too': too,
                            'tl': tl,
                            'tr': tr,
                            'succion': succion,
                            'tomaLaboratorios': tomaLaboratorios,
                            'numeroProximoControl': numeroProximoControl,
                            'especificacionProximoControl': especificacionProximoControl,
                            'clinicaHeridas': clinicaHeridas,
                            'cambioSonda': cambioSonda,
                            'suspendeTratamiento': suspendeTratamiento,
                            'finalizaTratamiento': finalizaTratamiento,
                            'cambioManejo': cambioManejo,
                            'observaciones': observaciones,
                            'usuarioCrea': userSession
                        },
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Cita PHD se completo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=di/citaspendientesmedico';
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    text: '¡La Cita PHD no se completo correctamente!',
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


        }else{

            toastr.warning("El Formulario de Vacunacion debe ser diligenciado completamente.", "¡Atencion!");

        }
    
    }

}

const guardarCitaAnticoagulados = () => {

    let formulario = document.getElementById("formCitaAnticoagulados");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let tf = document.getElementById("tf").value;
            let too = document.getElementById("too").value;
            let tl = document.getElementById("tl").value;
            let tr = document.getElementById("tr").value;
            let succion = document.getElementById("succion").value;
            let tomaLaboratorios = document.getElementById("tomaLaboratorios").value;
            let fechaTomaLaboratorios = document.getElementById("fechaTomaLaboratorios").value;
            let clinicaHeridas = document.getElementById("clinicaHeridas").value;
            let cambioSonda = document.getElementById("cambioSonda").value;
            let salida = document.getElementById("salida").value;
            let continua = document.getElementById("continua").value;
            let reingreso = document.getElementById("reingreso").value;
            let observaciones = document.getElementById("observaciones").value;

            Swal.fire({
                title: "¿Desea guardar la informacion de Anticoagulados?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Guardar!"
            }).then((result) => {
        
                if (result.isConfirmed) {

                    $.ajax({

                        url: 'ajax/di/citas.ajax.php',
                        type: 'POST',
                        data: {
                            'proceso': 'guardarGestionCitaAnticoagulados',
                            'formulario':'ANTICOAGULADOS',
                            'idCita': idCita,
                            'tf': tf,
                            'too': too,
                            'tl': tl,
                            'tr': tr,
                            'succion': succion,
                            'tomaLaboratorios': tomaLaboratorios,
                            'fechaTomaLaboratorios': fechaTomaLaboratorios,
                            'clinicaHeridas': clinicaHeridas,
                            'cambioSonda': cambioSonda,
                            'salida': salida,
                            'continua': continua,
                            'reingreso': reingreso,
                            'observaciones': observaciones,
                            'usuarioCrea': userSession
                        },
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Cita Anticoagulados se completo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=di/citaspendientesmedico';
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    text: '¡La Cita Anticoagulados no se completo correctamente!',
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


        }else{

            toastr.warning("El Formulario de Vacunacion debe ser diligenciado completamente.", "Error!");

        }
    
    }

}

const guardarCitaNutricion = () => {

    let formulario = document.getElementById("formCitaNutricion");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formCitaNutricion');

            const formData = new FormData(form);

            formData.append('proceso', 'guardarGestionCitaNutricion');
            formData.append('formulario', 'NUTRICION');
            formData.append('idCita', idCita);
            formData.append('userSession', userSession);


            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            Swal.fire({
                title: "¿Desea guardar la informacion de Nutricion?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Guardar!"
            }).then((result) => {
        
                if (result.isConfirmed) {

                    $.ajax({

                        url: 'ajax/di/citas.ajax.php',
                        type: 'POST',
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Cita Nutricion se completo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=di/citaspendientesmedico';
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    text: '¡La Cita Nutricion no se completo correctamente!',
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


        }else{

            toastr.warning("El Formulario de Nutricion debe ser diligenciado completamente.", "¡Atencion!");

        }
    
    }


}

const guardarCitaTrabajoSocial = () => {

    let formulario = document.getElementById("formCitaTrabajoSocial");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formCitaTrabajoSocial');

            const formData = new FormData(form);

            formData.append('proceso', 'guardarCitaTrabajoSocial');
            formData.append('formulario', 'TRABAJO SOCIAL');
            formData.append('idCita', idCita);
            formData.append('userSession', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            Swal.fire({
                title: "¿Desea guardar la informacion de Trabajo Social?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Guardar!"
            }).then((result) => {
        
                if (result.isConfirmed) {

                    $.ajax({

                        url: 'ajax/di/citas.ajax.php',
                        type: 'POST',
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Cita Trabajo Social se completo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=di/citaspendientesmedico';
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    text: '¡La Cita Trabajo Social no se completo correctamente!',
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


        }else{

            toastr.warning("El Formulario de Trabajo Social debe ser diligenciado completamente.", "¡Atencion!");

        }
    
    }    

}

const guardarCitaPsicologia = () => {

    let formulario = document.getElementById("formCitaPsicologia");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formCitaPsicologia');

            const formData = new FormData(form);

            formData.append('proceso', 'guardarCitaPsicologia');
            formData.append('formulario', 'PSICOLOGIA');
            formData.append('idCita', idCita);
            formData.append('userSession', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            Swal.fire({
                title: "¿Desea guardar la informacion de Psicologia?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Guardar!"
            }).then((result) => {
        
                if (result.isConfirmed) {

                    $.ajax({

                        url: 'ajax/di/citas.ajax.php',
                        type: 'POST',
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Cita Psicologia se completo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=di/citaspendientesmedico';
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    text: '¡La Cita Psicologia no se completo correctamente!',
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


        }else{

            toastr.warning("El Formulario de Psicologia debe ser diligenciado completamente.", "¡Atencion!");

        }
    
    }
}


const guardarCitaRiesgoCardioVascular = () => {

    let formulario = document.getElementById("formCitaRiesgoCardioVascular");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {

        if (formulario.checkValidity()){

            let form = document.querySelector('#formCitaRiesgoCardioVascular');

            const formData = new FormData(form);

            formData.append('proceso', 'guardarCitaRiesgoCardioVascular');
            formData.append('formulario', 'RIESGO CARDIO VASCULAR');
            formData.append('idCita', idCita);
            formData.append('userSession', userSession);

            // for(const [key, value] of formData){
            //     console.log(key, value);
            // }

            Swal.fire({
                title: "¿Desea guardar la informacion de Riesgo Cardio Vascular?",
                icon: 'info',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                confirmButtonText: "¡Si Guardar!"
            }).then((result) => {
        
                if (result.isConfirmed) {

                    $.ajax({

                        url: 'ajax/di/citas.ajax.php',
                        type: 'POST',
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(respuesta){

                            if(respuesta == 'ok'){

                                Swal.fire({
                                    text: '¡La Cita Riesgo Cardio Vascular se completo correctamente!',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonColor: "#d33"
                                }).then((result) =>{
        
                                    if(result.isConfirmed){
        
                                        window.location = 'index.php?ruta=di/citaspendientesmedico';
        
                                    }
        
                                })

                            }else{

                                Swal.fire({
                                    text: '¡La Cita Riesgo Cardio Vascular no se completo correctamente!',
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


        }else{

            toastr.warning("El Formulario de Riesgo Cardio Vascular debe ser diligenciado completamente.", "¡Atencion!");

        }
    
    }

}

const redireccionFormularioEdicionPaciente = (idPaciente) => {

    window.open("index.php?ruta=config/editarpacienteext&idPaciente="+btoa(idPaciente), "Edicion Usuario", "width="+(screen.width/2)+",height="+(screen.height)+",left="+ (screen.width / 2) + " ,location=no,toolbar=no,menubar=no,scrollbars=no, resizable=no"); 

}

const crearPreCita = () => {

    let formulario = document.getElementById("formAgregarPreCita");
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

            let form = document.querySelector('form');

            const formData = new FormData(form);

            formData.append('proceso', 'crearPreCita');
            formData.append('userCreate', userSession);
            formData.append('idCita', idCita);

            for(const [key, value] of formData){

                // console.log(key, value);
            }

            $.ajax({

                url: 'ajax/di/citas.ajax.php',
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Pre-Cita se creo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/gestionarcita&idCita='+btoa(idCita)+"&cohortePrograma="+btoa(cohortePrograma);

                            }

                        })

                    }else{

                        Swal.fire({
                            text: '¡La Pre-Cita no se creo correctamente!',
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

            toastr.warning("Debe diligenciar todos los campos del Formulario", "Error!");

        }

    }

}

const tomarPreCita = (idPreCita) => {

    Swal.fire({
        title: "¿Desea Gestionar la Pre-Cita?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Gestionar Pre-Cita!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/di/citas.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'tomarPreCita',
                    'idPreCita': idPreCita,
                    'asesor': userSession
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta.estado == 'ok-asignado'){

                        Swal.fire({
                            text: '¡La Pre-Cita se asigno correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Gestionar Pre-Cita',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#3085d6"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/gestionarprecita&idPreCita='+btoa(idPreCita);

                            }

                        })

                    }else if(respuesta.estado == 'error-asignando'){

                        Swal.fire({
                            text: '¡La Pre-Cita no se asigno correctamente!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/bolsaprecitas';

                            }

                        })


                    }else if(respuesta.estado == 'ok-ya-asignado'){
                        
                        Swal.fire({
                            text: '¡La Pre-Cita ya esta asignada a otro Asesor!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/bolsaprecitas';

                            }

                        })
                        
                    }else if(respuesta.estado == 'error-capacidad-superada'){

                        Swal.fire({
                            title: 'Error!',
                            text: '¡La Pre-Cita no se asigno debido a que supero los pendientes permitidos!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })
                    
                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: 'Algo salio mal, contacte al administrador',
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

const crearCita = () => {

    let idPreCita = document.getElementById("idPreCita").value;
    let idPaciente = document.getElementById("idPacientePreCita").value;

    let formulario = document.getElementById("formAgregarCita");
    let elementos = formulario.elements;
    let errores = 0;
    //console.log(formulario);
    //console.log(elementos);

    Array.from(elementos).forEach(function (element) { //array de elementos del Form
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });
    if (errores === 0) {
        
        
        if (formulario.checkValidity()){

            let motivoCita = document.getElementById('motivoCita').value;
            let idProfesional = document.getElementById('profesionalCita').value;
            let fechaCita = document.getElementById('fechaCita').value;
            let franjaCita = document.getElementById('franjaCita').value;
            let observacionCita = document.getElementById('observacionCita').value;
            let cohortePrograma = document.getElementById('cohortePrograma').value;
            let localidadCita = document.getElementById('localidadCita').value;
            let servicioCita = document.getElementById('servicioCita').value;

            $.ajax({

                url: 'ajax/di/agendamiento.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'validarDisponibilidadMedicoCita',
                    'idProfesional':idProfesional,
                    'fechaCita':fechaCita,
                    'franjaCita':franjaCita
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    //console.log(respuesta.respuesta);

                    if(respuesta["respuesta"] == 'ok-disponibilidad'){

                        Swal.fire({
                            title: '¡Agenda Disponible!',
                            html: `Cupos: <b>${respuesta.cupos}</b><br>¿Desea agendar la Cita?`,
                            icon: 'info',
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            cancelButtonText: "Cancelar",
                            showCancelButton: true,
                            confirmButtonText: "¡Si Agendar!"
                        }).then((result) => {
                    
                            if (result.isConfirmed) {

                                $.ajax({

                                    url: 'ajax/di/citas.ajax.php',
                                    type: 'POST',
                                    data: {
                                        'proceso': 'crearCitaPreCita',
                                        'idPreCita':idPreCita,
                                        'idProfesional':idProfesional,
                                        'idPaciente':idPaciente,
                                        'idBolsaAgendamiento':0,
                                        'motivoCita':motivoCita,
                                        'fechaCita':fechaCita,
                                        'franjaCita':franjaCita,
                                        'observacionCita':observacionCita,
                                        'cohortePrograma':cohortePrograma,
                                        'localidadCita': localidadCita,
                                        'servicioCita': servicioCita,
                                        'usuarioCrea':userSession
                                    },
                                    success:function(respuesta){

                                        if(respuesta == 'ok'){

                                            Swal.fire({
                                                text: '¡La Cita se guardo correctamente!',
                                                icon: 'success',
                                                confirmButtonText: 'Cerrar',
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                confirmButtonColor: "#d33"
                                            }).then((result) =>{
                    
                                                if(result.isConfirmed){
                    
                                                    window.location = 'index.php?ruta=di/gestionarprecita&idPreCita='+btoa(idPreCita);
                    
                                                }
                    
                                            })

                                        }else{

                                            Swal.fire({
                                                text: '¡Algo salio mal, la Cita no se creo correctamente!',
                                                icon: 'warning',
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



                    }else if(respuesta["respuesta"] == "error-dia-no-disponible"){
                        
                        Swal.fire({
                            text: `¡El Profesional el dia ${fechaCita} no esta Disponible para agendar la Cita!`,
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })
                        
                    }else if(respuesta["respuesta"] == 'no-disponibilidad'){

                        Swal.fire({
                            text: '¡No hay disponibilidad para agendar la Cita!',
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }else{

                        Swal.fire({
                            text: '¡Algo salio mal al obtener las capacidades de gestion, comunique al administrador!',
                            icon: 'warning',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }


                }

            })
        
        }else{

            toastr.warning("El Formulario para agregar Cita debe ser diligenciado completamente.", "Error!");

        }

    }

}

const registrarComunicacionFallida = () => {

    let idPreCita = document.getElementById("idPreCitaComuFallida").value;
    let causalFallida = document.getElementById("causalFallida").value;
    let observacionFallida = document.getElementById("observacionesFallida").value;
    let cantidadGestiones = document.getElementById("cantidadGestionesComuFallida").value;

    let formulario = document.getElementById("formComunicacionFallida");
    let elementos = formulario.elements;
    let errores = 0;

    Array.from(elementos).forEach(function (element) {
        if (element.className.includes('is-invalid')) {
            errores += 1;
        }
    });

    if (errores === 0) {

        if (formulario.checkValidity()){

            $.ajax({

                url: 'ajax/di/citas.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'crearComunicacionFallida',
                    'idPreCita':idPreCita,
                    'causalFallida':causalFallida,
                    'observacionFallida':observacionFallida,
                    'cantidadGestiones':cantidadGestiones,
                    'usuarioCrea': userSession
                },
                success:function(respuesta){

                    //console.log(respuesta);

                    if(respuesta === 'ok-cierre-agendamiento'){

                        Swal.fire({

                            text: 'La Pre-Cita fue terminada debido a que no se pudo establecer comunicación con el Paciente',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/pendientesprecitas';

                            }

                        })

                    }else if(respuesta === 'ok-cierre-call-causal'){

                        Swal.fire({

                            text: `La Pre-Cita fue terminada debido a que: ${causalFallida}.`,
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/pendientesprecitas';

                            }

                        })


                    }else if(respuesta === 'ok-comunicacion-fallida'){

                        Swal.fire({

                            text: 'La Comunicacion Fallida se guardo correctamente',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false

                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/pendientesprecitas';

                            }

                        })
                    
                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: 'La Comunicacion Fallida no se guardo correctamente',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })

                    }

                }

            })

        }

    }else{

        toastr.warning("Debe diligenciar todos los campos para Registrar la Comunicacion Fallida", "Error!");

    }
}


const gestionarPreCita = (idPreCita) => {

    window.location = 'index.php?ruta=di/gestionarprecita&idPreCita='+btoa(idPreCita);

}

const terminarGestionPreCita = () => {

    Swal.fire({
        text: '¿Desea terminar la Gestion de la Pre-Cita?',
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Terminar!"
    }).then((result) => {

        if(result.isConfirmed){

            $.ajax({

                url: 'ajax/di/citas.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'terminarGestionPreCita',
                    'idPreCita':idPreCita,
                    'estado':'FINALIZADA'
                },
                success:function(respuesta){

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Pre-Cita se finalizo correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/pendientesprecitas';

                            }

                        })


                    }else if(respuesta == 'sin-registros-citas'){

                        Swal.fire({
                            text: '¡La Pre-Cita no se puede finalizar debido a que no se agendaron Citas!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        })

                    }else{

                        Swal.fire({
                            text: '¡La Pre-Cita no se finalizo correctamente!',
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

tablaBolsaPreCitas = $("#tablaBolsaPreCitas").DataTable({

    columns: [
        { name: 'ID', data: 'id_pre_cita' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
        { name: 'DOCUMENTO PACIENTE', render: (data, type, row) => {
            return row.tipo_documento + ' - ' + row.numero_documento;
        } },
        { name: 'NUMERO CELULAR', data: 'numero_celular' },
        { name: 'DIRECCION', data: 'direccion_ubicacion' },
        { name: 'MOTIVO CITA', data: 'motivo_cita' },
        { name: 'FECHA CITA', render: (data, type, row) => {

            let badgedFechaCita = row.diff_dias <= 2 ? `<span class="badge badge-phoenix badge-phoenix-danger" title="Pre-Citas menores o igual a 2 dias de la fecha actual.">${row.fecha_cita}</span>` : row.diff_dias >= 3 && row.diff_dias <= 5 ? `<span class="badge badge-phoenix badge-phoenix-warning" title="Pre-Citas que esten entre el rango de 3 a 5 dias de la fecha actual.">${row.fecha_cita}</span>` : `<span class="badge badge-phoenix badge-phoenix-success" title="Pre-Citas que esten mayores a 5 dias de la fecha actual.">${row.fecha_cita}</span>`;

            return badgedFechaCita;

        }},
        { name: 'FRANJA CITA', render: (data, type, row) => {
            let badgedColor = row.franja_cita == 'AM' ? 'badge-phoenix-warning' : row.franja_cita  == 'PM' ? 'badge-phoenix-primary' : 'badge-phoenix-danger';
            return `<span class="badge badge-phoenix ${badgedColor}">${row.franja_cita}</span>`;
        }},
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-sm btn-success" onclick="tomarPreCita(${row.id_pre_cita})" title="Tomar Pre-Cita"><i class="far fa-check-square"></i></button>`;
            }
        }
    ],
    order: [[6, 'asc'], [7, 'asc']],
    ajax: {
        url: 'ajax/di/citas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaBolsaPreCitas'
        }
    }

})

tablaPendientePreCitasUser = $('#tablaPendientePreCitasUser').DataTable({

    columns: [
        { name: 'ID', data: 'id_pre_cita' },
        { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
        { name: 'DOCUMENTO PACIENTE', render: (data, type, row) => {
            return row.tipo_documento + ' - ' + row.numero_documento;
        } },
        { name: 'NUMERO CELULAR', data: 'numero_celular' },
        { name: 'DIRECCION', data: 'direccion_ubicacion' },
        { name: 'MOTIVO CITA', data: 'motivo_cita' },
        { name: 'FECHA CITA', data: 'fecha_cita' },
        { name: 'CANTIDAD GESTIONES', data: 'contador_gestiones' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-sm btn-success" onclick="gestionarPreCita(${row.id_pre_cita})" title="Gestionar Pre-Cita"><i class="far fa-check-square"></i></button>`;
            }
        }
    ],
    ajax: {
        url: 'ajax/di/citas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPendientesPreCitasUser',
            'user':userSession
        }
    }

})

tablaComunicacionesFallidas = $("#tablaComunicacionesFallidas").DataTable({

    columns: [
        { name: 'ID', data: 'id_comunicacion_fallida' },
        { name: 'CAUSAL FALLIDA', data: 'causal_fallida' },
        { name: 'OBSERVACIONES', data: 'observaciones' },
        { name: 'USUARIO CREA', data: 'usuario_crea' },
        { name: 'FECHA CREA', data: 'fecha_crea' }
    ],
    ajax: {
        url: 'ajax/di/citas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaComunicacionFallidasPreCitas',
            'idPreCita': idPreCita
        }
    }

})

tablaCitasPendientesMedico = $("#tablaCitasPendientesMedico").DataTable({

    columns: [
        { name: 'ID', data: 'id_cita' },
        { name: 'FECHA CITA', data: 'fecha_cita' },
        { name: 'FRANJA CITA', render: function (data, type, row){
            let badgedColor = row.franja_cita == 'AM' ? 'badge-phoenix-warning' : 'badge-phoenix-primary';
            return `<span class="badge badge-phoenix ${badgedColor}">${row.franja_cita}</span>`;
        } 
        },
        { name: 'NOMBRE PACIENTE', data: 'nombre_paciente' },
        { name: 'DOCUMENTO PACIENTE', render: function(data, type, row){

            return row.tipo_documento + ' - ' + row.numero_documento;

        } 
        },
        { name: 'TELEFONO UNO', data: 'telefono_uno_ubicacion' },
        { name: 'TELEFONO DOS', data: 'telefono_dos_ubicacion' },
        { name: 'DIRECCION', data: 'direccion_ubicacion' },
        { name: 'COHORTE O PROGRAMA', data: 'cohorte_programa' },
        { name: 'MOTIVO CITA', data: 'motivo_cita' },
        { name: 'ESTADO', render: function(data, type, row){

            let badgedColor = row.estado == 'CREADA' ? 'badge-phoenix-warning' : 'badge-phoenix-primary';

            return `<span class="badge badge-phoenix ${badgedColor}">${row.estado}</span>`;


        } 
        },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-success btn-sm" onclick="gestionarCita(${row.id_cita},'${row.estado}','${row.cohorte_programa}',${row.id_profesional})" title="Gestionar Cita"><i class="far fa-check-square"></i></button>`;
            }
        }
    ],
    order: [[2, 'asc']],
    ajax: {
        url: 'ajax/di/citas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaCitasPendientesMedica',
            'idProfesional': idUserSession
        }
    }

})

tablaPreCitasCreadas = $("#tablaPreCitasCreadas").DataTable({

    columns: [
        { name: 'ID', data: 'id_pre_cita' },
        { name: 'MOTIVO CITA', data: 'motivo_cita' },
        { name: 'FECHA CITA', render: function (data, type, row){
            let badgedColor = row.franja_cita == 'AM' ? 'badge-phoenix-warning' : 'badge-phoenix-primary';
            return `<span class="badge badge-phoenix ${badgedColor}">${row.fecha_cita} - Franja: ${row.franja_cita}</span>`;
        } 
        },
        { name: 'OBSERVACIONES CITA', data: 'observaciones_cita' },
        {
            name: 'OPCIONES', orderable: false, render: function (data, type, row) {
                return `<button type="button" class="btn btn-danger btn-sm" onclick="eliminarPreCita(${row.id_pre_cita})" title="Eliminar Pre-Cita"><i class="far fa-trash-alt"></i></button>`;
            }
        }
    ],
    ajax: {
        url: 'ajax/di/citas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'listaPreCitasCita',
            'idCita': idCita
        }
    }

})

const eliminarPreCita = (idPreCita) => {

    Swal.fire({
        title: "¿Desea Eliminar la Pre-Cita?",
        icon: 'info',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        confirmButtonText: "¡Si Eliminar Pre-Cita!"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: 'ajax/di/citas.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'eliminarPreCita',
                    'idPreCita': idPreCita
                },
                cache: false,
                dataType: "json",
                success:function(respuesta){

                    console.log(respuesta);

                    if(respuesta == 'ok'){

                        Swal.fire({
                            text: '¡La Pre-Cita se elimino correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#d33"
                        }).then((result) =>{

                            if(result.isConfirmed){

                                window.location = 'index.php?ruta=di/gestionarcita&idCita='+btoa(idCita)+"&cohortePrograma="+btoa(cohortePrograma);

                            }

                        })

                    }else{

                        Swal.fire({
                            title: 'Error!',
                            text: 'Algo salio mal, contacte al administrador',
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


if(idCita && cohortePrograma){

    $.ajax({

        url: 'ajax/di/citas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'verInfoCita',
            'idCita': idCita
        },
        cache: false,
        dataType: "json",
        success:function(respuesta){

            $("#textMotivoCita").html(respuesta["motivo_cita"]);
            $("#textServicioCita").html(respuesta["servicio_cita"]);
            $("#textCohortePrograma").html(respuesta["cohorte_programa"]);
            let badgedColor = respuesta.franja_cita == 'AM' ? 'badge-phoenix-warning' : 'badge-phoenix-primary';
            $("#textFechaCita").html(`<span class="badge badge-phoenix ${badgedColor}">${respuesta.fecha_cita}</span>`);
            $("#textFranjaCita").html(`<span class="badge badge-phoenix ${badgedColor}">${respuesta.franja_cita}</span>`);
            $("#textLocalidadCita").html(respuesta["localidad_cita"]);
            $("#textObservacionesCita").html(respuesta["observaciones_cita"]);
            $("#idPacientePreCita").val(respuesta["id_paciente"]);

            $.ajax({

                url: 'ajax/config/pacientes.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'mostrarPaciente',
                    'idPaciente': respuesta.id_paciente
                },
                cache: false,
                dataType: "json",
                success:function(respuestaPaciente){
        
                    //console.log(respuestaPaciente);

                    $("#contenedorInfoPacienteTitulo").html(`<h4 class="text-white mb-0">Informacion Paciente <a onclick="redireccionFormularioEdicionPaciente(${respuestaPaciente.id_paciente})"><i class="fas fa-search text-white"></i></a></h4>`);
                    $("#textDocPaciente").html(respuestaPaciente.tipo_documento + ' ' + respuestaPaciente.numero_documento);
                    $("#textNombrePaciente").html(respuestaPaciente.nombre_paciente_completo);
                    $("#textFechaNacimiento").html(respuestaPaciente.fecha_nacimiento);
                    $("#textEdadPaciente").html(respuestaPaciente.edad_n + ' ' + respuestaPaciente.edad_t);
                    $("#textGeneroPaciente").html(respuestaPaciente.genero_paciente);
                    $("#textEstadoCivilPaciente").html(respuestaPaciente.estado_civil);
                    $("#textEscolaridadPaciente").html(respuestaPaciente.escolaridad);
                    $("#textVinculacionPaciente").html(respuestaPaciente.vinculacion);

        
                }
        
            })

        }


    })

}

if(idPreCita){

    $.ajax({

        url: 'ajax/di/citas.ajax.php',
        type: 'POST',
        data: {
            'proceso': 'infoPreCita',
            'idPreCita': idPreCita
        },
        cache: false,
        dataType: "json",
        success:function(respPreCita){

            // console.log(respPreCita);

            $("#idPreCita").val(respPreCita["id_pre_cita"]);
            $("#idPreCitaComuFallida").val(respPreCita["id_pre_cita"]);
            $("#idPacientePreCita").val(respPreCita["id_paciente"]);
            $("#motivoCita").val(respPreCita["motivo_cita"]);
            $("#fechaCita").val(respPreCita["fecha_cita"]);
            $("#franjaCita").val(respPreCita["franja_cita"]);
            $("#observacionCita").val(respPreCita["observaciones_cita"]);
            $("#cantidadGestionesComuFallida").val(respPreCita["contador_gestiones"]);

            $.ajax({

                url: 'ajax/config/pacientes.ajax.php',
                type: 'POST',
                data: {
                    'proceso': 'mostrarPaciente',
                    'idPaciente': respPreCita.id_paciente
                },
                cache: false,
                dataType: "json",
                success:function(respuestaPaciente){
        
                    //console.log(respuestaPaciente);

                    $("#contenedorInfoPacienteTitulo").html(`<h4 class="text-white mb-0">Informacion Paciente <a onclick="redireccionFormularioEdicionPaciente(${respuestaPaciente.id_paciente})"><i class="fas fa-search text-white"></i></a></h4>`);
                    $("#textDocPaciente").html(respuestaPaciente.tipo_documento + ' ' + respuestaPaciente.numero_documento);
                    $("#textNombrePaciente").html(respuestaPaciente.nombre_paciente_completo);
                    $("#textFechaNacimiento").html(respuestaPaciente.fecha_nacimiento);
                    $("#textEdadPaciente").html(respuestaPaciente.edad_n + ' ' + respuestaPaciente.edad_t);
                    $("#textGeneroPaciente").html(respuestaPaciente.genero_paciente);
                    $("#textEstadoCivilPaciente").html(respuestaPaciente.estado_civil);
                    $("#textEscolaridadPaciente").html(respuestaPaciente.escolaridad);
                    $("#textVinculacionPaciente").html(respuestaPaciente.vinculacion);

        
                }
        
            })

        }

    })

    /*============================
    CALENDARIO
    ============================*/
    let calendarEL = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEL, {
        themeSystem: 'bootstrap5',
        initialView: 'dayGridMonth',
        dayMaxEvents: true,
        locale: 'es',
        events: [],
        eventClick: function(info){

            $('#modalEvento').modal('show');
            $("#textNombrePacienteCita").html(info.event.extendedProps.nombrePaciente);
            $("#textServicioCita").html(info.event.extendedProps.servicioCita);
            $("#textDocPacienteCita").html(info.event.extendedProps.documentoPaciente);
            $("#textEventMotivoCita").html(info.event.extendedProps.description);
            $("#textEventCohortePrograma").html(info.event.extendedProps.cohortePrograma);
            let badgedColor = 'badge-phoenix-primary';
            badgedColor = info.event.extendedProps.franjaCita == 'AM' ? 'badge-phoenix-warning' : info.event.extendedProps.franjaCita  == 'PM' ? 'badge-phoenix-primary' : 'badge-phoenix-danger';
            $("#textEventFechaCita").html(`<span class="badge badge-phoenix ${badgedColor}">Dia: ${info.event.extendedProps.fechaCita} - Franja: ${info.event.extendedProps.franjaCita}</span>`);
            const colorEstado = (info.event.extendedProps.estado === 'CREADA') ? 'badge-phoenix-warning' : (info.event.extendedProps.estado === 'PROCESO') ? 'badge-phoenix-primary' : (info.event.extendedProps.estado === 'NO-DISPONIBLE') ? 'badge-phoenix-danger' : 'badge-phoenix-success';
            $("#textEventEstado").html(`<span class="badge badge-phoenix ${colorEstado}">${info.event.extendedProps.estado}</span>`);
            $("#textEventObservacionesCita").html(info.event.extendedProps.observaciones);
            $("#textEventProfesional").html(info.event.title);
            $("#textEventLocalidad").html(info.event.extendedProps.localidadCita);

            //console.log(info.event);
            //console.log(info.event.extendedProps);
            //alert('Event: ' + info.event.title + ' Descripcion: ' + info.event.extendedProps.description);
            //alert('View: ' + info.view.type);
            //info.el.style.borderColor = 'red';
        }
    });


    $.ajax({
        url: 'ajax/di/agendamiento.ajax.php',
        type: 'POST',
        data: {
            proceso: 'listaCitasCalendar'
        },
        success: function (respuesta) {
            //console.log(respuesta);
            calendar.setOption('events', JSON.parse(respuesta));
            calendar.render();
        }
    })

    $("#profesionalCita").change(() => {

        let idProfesional = document.getElementById('profesionalCita').value;

        //console.log(idProfesional);

        $.ajax({
            url: 'ajax/di/agendamiento.ajax.php',
            type: 'POST',
            data: {
                proceso: 'listaCitasCalendarProfesional',
                idProfesional: idProfesional
            },
            success: function (respuesta) {
                //console.log(respuesta);
                calendar.setOption('events', JSON.parse(respuesta));
                calendar.render();
            }
        });

    })

}
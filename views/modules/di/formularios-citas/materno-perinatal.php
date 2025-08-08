<div class="card shadow-none border border-300 mb-2" data-component-card="data-component-card">
    <form id="formCitaMaternoPerinatal" name="formCitaMaternoPerinatal" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="card-header p-4 border-bottom border-300 bg-success">
            <div class="row g-3 justify-content-between align-items-center">
                <div class="col-12 col-md">
                    <h4 class="text-white mb-0">Formulario Cita Materno Perinatal y SSR</h4>
                </div>
                <div class="col col-md-auto">
                    <button class="btn btn-phoenix-danger ms-2" onclick="guardarCitaFallida()"><i class="far fa-calendar-times"></i> Fallida</button>
                    <button class="btn btn-phoenix-success ms-2" onclick="guardarCitaMaternoPerinatal()"><i class="far fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Tamizaje de Salud Mental</label>
                    <!-- <input type="text" class="form-control" name="tamizajeSaludMental" id="tamizajeSaludMental" placeholder="Tamizaje de Salud Mental" required> -->
                    <select class="form-control" name="tamizajeSaludMental" id="tamizajeSaludMental" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Educacion Individual y/o Familiar</label>
                    <!-- <input type="text" class="form-control" name="educacionIndividualFamiliar" id="educacionIndividualFamiliar" placeholder="Educacion Individual y/o Familiar" required> -->
                    <select class="form-control" name="educacionIndividualFamiliar" id="educacionIndividualFamiliar" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Inicio Referencia y Contrareferencia</label>
                    <!-- <input type="text" class="form-control" name="inicioReferenciaContra" id="inicioReferenciaContra" placeholder="Inicio Referencia y Contrareferencia" required> -->
                    <select class="form-control" name="inicioReferenciaContra" id="inicioReferenciaContra" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Notificacion Inmediata de alertas</label>
                    <!-- <input type="text" class="form-control" name="notificacionAlertas" id="notificacionAlertas" placeholder="Notificacion Inmediata de alertas" required> -->
                    <select class="form-control" name="notificacionAlertas" id="notificacionAlertas" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Consulta Gestante</label>
                    <!-- <input type="text" class="form-control" name="consultaGestante" id="consultaGestante" placeholder="Consulta Gestante" required> -->
                    <select class="form-control" name="consultaGestante" id="consultaGestante" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Verificacion de CPN y Vacunacion</label>
                    <!-- <input type="text" class="form-control" name="verificacionCpnVacunacion" id="verificacionCpnVacunacion" placeholder="Verificacion de CPN y Vacunacion" required> -->
                    <select class="form-control" name="verificacionCpnVacunacion" id="verificacionCpnVacunacion" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Identificacion Riesgo</label>
                    <!-- <input type="text" class="form-control" name="identificacionRiesgo" id="identificacionRiesgo" placeholder="Identificacion Riesgo" required> -->
                    <select class="form-control" name="identificacionRiesgo" id="identificacionRiesgo" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Realizacion de estrategia ETMI - Plus</label>
                    <!-- <input type="text" class="form-control" name="realizacionEstrategia" id="realizacionEstrategia" placeholder="Realizacion de estrategia ETMI - Plus" required> -->
                    <select class="form-control" name="realizacionEstrategia" id="realizacionEstrategia" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Verificacion de administracion de PNC</label>
                    <!-- <input type="text" class="form-control" name="verificacionAdministracionPNC" id="verificacionAdministracionPNC" placeholder="Verificacion de administracion de PNC" required> -->
                    <select class="form-control" name="verificacionAdministracionPNC" id="verificacionAdministracionPNC" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Captacion de pareja para tratamiento Sifilis C.</label>
                    <!-- <input type="text" class="form-control" name="captacionTratamientoSifilis" id="captacionTratamientoSifilis" placeholder="Captacion de pareja para tratamiento Sifilis Congenita" required> -->
                    <select class="form-control" name="captacionTratamientoSifilis" id="captacionTratamientoSifilis" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Orden y/o Provision de preservativos</label>
                    <!-- <input type="text" class="form-control" name="ordenProvisionPreservativo" id="ordenProvisionPreservativo" placeholder="Orden y/o Provision de preservativos" required> -->
                    <select class="form-control" name="ordenProvisionPreservativo" id="ordenProvisionPreservativo" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Educacion Signos de Alarma</label>
                    <!-- <input type="text" class="form-control" name="educacionSignosAlarma" id="educacionSignosAlarma" placeholder="Educacion Signos de Alarma" required> -->
                    <select class="form-control" name="educacionSignosAlarma" id="educacionSignosAlarma" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Notificacion Cohorte MP</label>
                    <!-- <input type="text" class="form-control" name="notificacionCohorteMp" id="notificacionCohorteMp" placeholder="Notificacion Cohorte MP" required> -->
                    <select class="form-control" name="notificacionCohorteMp" id="notificacionCohorteMp" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Asesoria Planificacion Familiar</label>
                    <!-- <input type="text" class="form-control" name="asesoriaPlanificacionFamiliar" id="asesoriaPlanificacionFamiliar" placeholder="Asesoria Planificacion Familiar" required> -->
                    <select class="form-control" name="asesoriaPlanificacionFamiliar" id="asesoriaPlanificacionFamiliar" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Demanda inducida PF</label>
                    <!-- <input type="text" class="form-control" name="demandaInducidaPf" id="demandaInducidaPf" placeholder="Demanda inducida PF" required> -->
                    <select class="form-control" name="demandaInducidaPf" id="demandaInducidaPf" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-4">
                    <label class="">Demanda inducida preconcepcional</label>
                    <!-- <input type="text" class="form-control" name="demandaInducidaPreconcepcional" id="demandaInducidaPreconcepcional" placeholder="Demanda inducida preconcepcional" required> -->
                    <select class="form-control" name="demandaInducidaPreconcepcional" id="demandaInducidaPreconcepcional" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Disentimiento de PNF o Cita percepcional</label>
                    <!-- <input type="text" class="form-control" name="disentimientoPnfCitaPercepcional" id="disentimientoPnfCitaPercepcional" placeholder="Disentimiento de PNF o Cita percepcional" required> -->
                    <select class="form-control" name="disentimientoPnfCitaPercepcional" id="disentimientoPnfCitaPercepcional" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="">Estado del Caso</label>
                    <!-- <input type="text" class="form-control" name="disentimientoPnfCitaPercepcional" id="disentimientoPnfCitaPercepcional" placeholder="Disentimiento de PNF o Cita percepcional" required> -->
                    <select class="form-control" name="estadoCaso" id="estadoCaso" required>
                        <option value="">Seleccione una opcion</option>
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="FALLIDO">FALLIDO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12">
                    <label class="">Observaciones</label>
                    <textarea class="form-control" rows="3" minlength="10" maxlength="200" name="observaciones" id="observaciones" required placeholder="Observaciones"></textarea>
                </div>
            </div>
            <!-- <div class="row mb-2">
                <div class="col-sm-12 col-md-3">
                    <label class="">Mac Actual</label>
                    <input type="text" class="form-control" name="macActual" id="macActual" placeholder="Mac Actual" required>
                </div>
                <div class="col-sm-12 col-md-3">
                    <label class="">Fecha Inicio</label>
                    <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" required>
                </div>
            </div> -->
            <!-- <div class="row mb-2">
                <div class="col-sm-12 col-md-3">
                    <label class="">Mac Entregado</label>
                    <input type="text" class="form-control" name="macEntregado" id="macEntregado" placeholder="Mac Entregado" required>
                </div>
                <div class="col-sm-12 col-md-3">
                    <label class="">Fecha Entrega</label>
                    <input type="date" class="form-control" name="fechaEntrega" id="fechaEntrega" required>
                </div>
            </div> -->
            <!-- <div class="row mb-2">
                <div class="col-sm-12 col-md-3">
                    <label class="">Formula Mac</label>
                    <input type="text" class="form-control" name="formulaMac" id="formulaMac" placeholder="Formula Mac" required>
                </div>
                <div class="col-sm-12 col-md-3">
                    <label class="">Formato Procedimiento QX</label>
                    <input type="text" class="form-control" name="formatoProcedimientoQx" id="formatoProcedimientoQx" placeholder="Formato Procedimiento QX" required>
                </div>
            </div> -->
        </div>
    </form>
</div>
<?php

class ControladorReportesAutoevaluacion
{
    static public function ctrListaEstandarEvaluadoSedes()
    {
        $sedes = ModelReportesAutoevaluacion::mdlObtenerSedes();
        $autoevaluaciones = ModelReportesAutoevaluacion::mdlObtenerAutoevaluacionesSeleccionadas();
        $mapaSedeEstandar = [];

        foreach ($autoevaluaciones as $auto) {

            $sedeEnBD  = $auto["sede"];
            $codigoEst = $auto["codigo"];
            $listaSedes = explode("-", $sedeEnBD);
            foreach ($listaSedes as $sedeIndividual) {
                $sedeIndividual = trim($sedeIndividual);
                if (!isset($mapaSedeEstandar[$sedeIndividual])) {
                    $mapaSedeEstandar[$sedeIndividual] = [];
                }
                $mapaSedeEstandar[$sedeIndividual][] = $codigoEst;
            }
        }

        $resultadoFinal = [];
        foreach ($sedes as $sedeRow) {
            $sedeNombre = $sedeRow["sede"];
            if (
                isset($mapaSedeEstandar[$sedeNombre])
                && count($mapaSedeEstandar[$sedeNombre]) > 0
            ) {
                $codigosStr = implode(",", $mapaSedeEstandar[$sedeNombre]);
            } else {
                $codigosStr = "NO HAY ESTANDARES EVALUADOS";
            }
            $resultadoFinal[] = [
                "sede"       => $sedeNombre,
                "estandares" => $codigosStr
            ];
        }

        return $resultadoFinal;
    }


    static public function ctrListarSubgruposEstandares($sede, $periodo)
    {
        $estandaresBD = ModelReportesAutoevaluacion::mdlObtenerEstandares();
        $autoevaluacionesBD = ModelReportesAutoevaluacion::mdlObtenerAutoevaluacionesPorSede($sede, $periodo);

        $mapaSubgrupos = [];
        foreach ($estandaresBD as $est) { //iteramos por cada fila obtenida de pamec_par_estandar
            $subgrupo = $est["subgrupo"];
            $idEst = (int)$est["id_estandar"];
            $criteriosTexto = $est["criterios"];

            if (!isset($mapaSubgrupos[$subgrupo])) {
                $mapaSubgrupos[$subgrupo] = [
                    "minID"       => $idEst,
                    "maxID"       => $idEst,
                    "criteriosAll" => [],
                    "na" => 0,
                    "ep" => 0,
                    "c"  => 0,
                    "a"  => 0
                ];
            }
            if ($idEst < $mapaSubgrupos[$subgrupo]["minID"]) {
                $mapaSubgrupos[$subgrupo]["minID"] = $idEst;
            }
            if ($idEst > $mapaSubgrupos[$subgrupo]["maxID"]) {
                $mapaSubgrupos[$subgrupo]["maxID"] = $idEst;
            }
            if (!empty($criteriosTexto)) {
                $mapaSubgrupos[$subgrupo]["criteriosAll"][] = $criteriosTexto;
            }
        }
        foreach ($autoevaluacionesBD as $auto) { //iteramos por cada fila obtenida de pamec_par_estandar
            $subgp    = $auto["subgrupo"];
            $estado   = $auto["estado"];
            if (isset($mapaSubgrupos[$subgp])) {
                if ($estado === 'NO APLICA') {
                    $mapaSubgrupos[$subgp]["na"]++;
                }
                if ($estado === "PROCESO") {
                    $mapaSubgrupos[$subgp]["ep"]++;
                } else if ($estado === "TERMINADO") {
                    $mapaSubgrupos[$subgp]["c"]++;
                } else if ($estado === "PENDIENTE") {
                    $mapaSubgrupos[$subgp]["a"]++;
                }
            }
        }

        $resultado = [];

        foreach ($mapaSubgrupos as $subg => $info) {
            $minID = $info["minID"];
            $maxID = $info["maxID"];

            $rangoStr = $minID . "-" . $maxID;

            $numEstandares = ($maxID - $minID) + 1;

            $criteriosUnico  = implode("•", $info["criteriosAll"]);
            $arrayCriterios  = explode("•", $criteriosUnico);
            $arrayCriterios  = array_filter($arrayCriterios, fn($item) => trim($item) !== "");
            $numCriterios    = count($arrayCriterios);

            $na = $info["na"];
            $ep = $info["ep"];
            $c  = $info["c"];
            $a  = $info["a"];

            $estandaresCompletados = $na + $c; // no aplica + completo
            $pendientesNum = $numEstandares - $estandaresCompletados;
            $pendientesPorcentaje = 0;
            $porcentaje = 0;
            $pendientes = 0;

            if ($numEstandares > 0) {
                $porcentajeProduccion  = round(($estandaresCompletados / $numEstandares) * 100);
                $pendientesPorcentaje  = round(($pendientesNum / $numEstandares) * 100);
            }
            $porcentaje = $porcentajeProduccion . "%";
            $pendientes = $pendientesNum . " (" . $pendientesPorcentaje . "%)";

            $resultado[] = [
                "subgrupo"         => $subg,
                "rango_estandar"   => $rangoStr,
                "numero_estandares" => $numEstandares,
                "numero_criterios" => $numCriterios,
                "na"               => $na,
                "ep"               => $ep,
                "c"                => $c,
                "a"                => $a,
                "porcentaje"       => $porcentaje,
                "pendientes"       => $pendientes
            ];
        }

        return $resultado;
    }

    static public function ctrListarGruposEstandares($sede, $periodo)
    {
        $estandaresBD = ModelReportesAutoevaluacion::mdlObtenerEstandares();
        $autoevaluacionesBD = ModelReportesAutoevaluacion::mdlObtenerAutoevaluacionesPorSede($sede, $periodo);

        $mapagrupos = [];
        foreach ($estandaresBD as $est) { //iteramos por cada fila obtenida de pamec_par_estandar
            $grupo = $est["grupo"];
            $idEst = (int)$est["id_estandar"];
            $criteriosTexto = $est["criterios"];

            if (!isset($mapagrupos[$grupo])) {
                $mapagrupos[$grupo] = [
                    "minID"       => $idEst,
                    "maxID"       => $idEst,
                    "criteriosAll" => [],
                    "na" => 0,
                    "ep" => 0,
                    "c"  => 0,
                    "a"  => 0
                ];
            }
            if ($idEst < $mapagrupos[$grupo]["minID"]) {
                $mapagrupos[$grupo]["minID"] = $idEst;
            }
            if ($idEst > $mapagrupos[$grupo]["maxID"]) {
                $mapagrupos[$grupo]["maxID"] = $idEst;
            }
            if (!empty($criteriosTexto)) {
                $mapagrupos[$grupo]["criteriosAll"][] = $criteriosTexto;
            }
        }
        foreach ($autoevaluacionesBD as $auto) { //iteramos por cada fila obtenida de pamec_par_estandar
            $gp    = $auto["grupo"];
            $estado   = $auto["estado"];
            if (isset($mapagrupos[$gp])) {
                if ($estado === 'NO APLICA') {
                    $mapagrupos[$gp]["na"]++;
                }
                if ($estado === "PROCESO") {
                    $mapagrupos[$gp]["ep"]++;
                } else if ($estado === "TERMINADO") {
                    $mapagrupos[$gp]["c"]++;
                } else if ($estado === "PENDIENTE") {
                    $mapagrupos[$gp]["a"]++;
                }
            }
        }

        $resultado = [];

        foreach ($mapagrupos as $gp => $info) {
            $minID = $info["minID"];
            $maxID = $info["maxID"];

            $rangoStr = $minID . "-" . $maxID;

            $numEstandares = ($maxID - $minID) + 1;

            $criteriosUnico  = implode("•", $info["criteriosAll"]);
            $arrayCriterios  = explode("•", $criteriosUnico);
            $arrayCriterios  = array_filter($arrayCriterios, fn($item) => trim($item) !== "");
            $numCriterios    = count($arrayCriterios);

            $na = $info["na"];
            $ep = $info["ep"];
            $c  = $info["c"];
            $a  = $info["a"];

            $estandaresCompletados = $c + $na; //completo
            $pendientesNum = $numEstandares - $estandaresCompletados;
            $pendientesPorcentaje = 0;
            $porcentaje = 0;
            $pendientes = 0;

            if ($numEstandares > 0) {
                $porcentajeProduccion  = round(($estandaresCompletados / $numEstandares) * 100);
                $pendientesPorcentaje  = round(($pendientesNum / $numEstandares) * 100);
            }
            $porcentaje = $porcentajeProduccion . "%";
            $pendientes = $pendientesNum . " (" . $pendientesPorcentaje . "%)";

            $resultado[] = [
                "grupo"         => $gp,
                "rango_estandar"   => $rangoStr,
                "numero_estandares" => $numEstandares,
                "numero_criterios" => $numCriterios,
                "na"               => $na,
                "ep"               => $ep,
                "c"                => $c,
                "a"                => $a,
                "porcentaje"       => $porcentaje,
                "pendientes"       => $pendientes
            ];
        }

        return $resultado;
    }

    static public function ctrConteoEstadosAutoevaluacion()
    {
        $conteoEstado = ModelReportesAutoevaluacion::mdlConteoEstadosAutoevaluacion();

        /*  Mapeo:  ABIERTO → PENDIENTE  |  COMPLETO → TERMINADO  */
        return [
            "no_aplica"  => (int)$conteoEstado["no_aplica"],
            "pendiente"  => (int)$conteoEstado["pendiente"],
            "proceso"    => (int)$conteoEstado["proceso"],
            "terminado"  => (int)$conteoEstado["terminado"]
        ];
    }

    static public function ctrConteoEstandaresPorSede()
    {
        $sedes             = ModelReportesAutoevaluacion::mdlObtenerSedes();
        $autoevaluaciones  = ModelReportesAutoevaluacion::mdlObtenerAutoevaluacionesSeleccionadas();

        $conteoEstandaresSede = [];
        foreach ($sedes as $row) {
            $conteoEstandaresSede[$row['sede']] = 0;
        }

        foreach ($autoevaluaciones as $auto) {
            $listaSedes = explode('-', $auto['sede']);
            foreach ($listaSedes as $sedeIndividual) {
                $sedeIndividual = trim($sedeIndividual);
                if (isset($conteoEstandaresSede[$sedeIndividual])) {
                    $conteoEstandaresSede[$sedeIndividual]++;
                }
            }
        }

        $resultado = [];
        foreach ($conteoEstandaresSede as $sede => $cantidad) {
            $resultado[] = [
                "sede"     => $sede,
                "cantidad" => $cantidad
            ];
        }

        return $resultado;
    }

    static public function ctrConteoEstadosPorSede()
    {
        $sedes            = ModelReportesAutoevaluacion::mdlObtenerSedes();
        $autoevaluaciones = ModelReportesAutoevaluacion::mdlObtenerAutoevaluacionesSeleccionadas();

        $mapaConteos = [];
        foreach ($sedes as $row) {
            $mapaConteos[$row['sede']] = [
                'no_aplica' => 0,
                'pendiente' => 0,
                'proceso'   => 0,
                'terminado' => 0
            ];
        }
        foreach ($autoevaluaciones as $auto) {
            $estado       = $auto['estado'];
            $listaSedes   = explode('-', $auto['sede']);

            foreach ($listaSedes as $sedeIndividual) {
                $sedeIndividual = trim($sedeIndividual);
                if (!isset($mapaConteos[$sedeIndividual])) {
                    $mapaConteos[$sedeIndividual] = [
                        'no_aplica' => 0,
                        'pendiente' => 0,
                        'proceso'   => 0,
                        'terminado' => 0
                    ];
                }

                switch ($estado) {
                    case 'NO APLICA':
                        $mapaConteos[$sedeIndividual]['no_aplica']++;
                        break;
                    case 'PENDIENTE':
                        $mapaConteos[$sedeIndividual]['pendiente']++;
                        break;
                    case 'PROCESO':
                        $mapaConteos[$sedeIndividual]['proceso']++;
                        break;
                    case 'TERMINADO':
                        $mapaConteos[$sedeIndividual]['terminado']++;
                        break;
                }
            }
        }

        $resultado = [];
        foreach ($mapaConteos as $sede => $valores) {
            $resultado[] = array_merge(['sede' => $sede], $valores);
        }

        return $resultado;
    }

    static public function ctrMatrizEstandaresPorSede()
    {
        $sedes            = ModelReportesAutoevaluacion::mdlObtenerSedes();
        $autoevaluaciones = ModelReportesAutoevaluacion::mdlObtenerAutoevaluacionesSeleccionadas();

        $setEstandares = [];
        foreach ($autoevaluaciones as $auto) {
            $setEstandares[$auto['codigo']] = true;
        }
        ksort($setEstandares);                            
        $listaEstandares = array_keys($setEstandares);

        $mapaIndiceSede      = [];   
        $mapaIndiceEstandar  = [];  

        foreach ($sedes as $i => $row)    $mapaIndiceSede[$row['sede']]     = $i;
        foreach ($listaEstandares as $j => $cod) $mapaIndiceEstandar[$cod]  = $j;

        $datos = [];
        foreach ($autoevaluaciones as $auto) {
            $y = $mapaIndiceEstandar[$auto['codigo']];
            $listaSedesAE = explode('-', $auto['sede']);

            foreach ($listaSedesAE as $sedeNombre) {
                $sedeNombre = trim($sedeNombre);
                if (!isset($mapaIndiceSede[$sedeNombre])) continue; 
                $x = $mapaIndiceSede[$sedeNombre];
                $datos[] = [$x, $y, 1];               
            }
        }

        return [
            'sedes'      => array_column($sedes, 'sede'),
            'estandares' => $listaEstandares,
            'data'       => $datos
        ];
    }
}

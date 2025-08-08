<?php

class ControladorInventarioMantenimiento{

    static public function ctrEditarMantenimiento($datos){

        $cadenaManteniPreventivos = '';

        if(!empty($datos["mantenimientosPreventivos"])){

            foreach ($datos["mantenimientosPreventivos"] as $key => $valuePreventivo) {

                $cadenaManteniPreventivos .= $valuePreventivo.'|';

            }

        }

        $cadenaManteniCorrectivos = '';

        if(!empty($datos["mantenimientosCorrectivos"])){

            foreach ($datos["mantenimientosCorrectivos"] as $key => $valueCorrectivo) {

                $cadenaManteniCorrectivos .= $valueCorrectivo.'|';

            }

        }

        $cadenaManteniPreventivos = substr($cadenaManteniPreventivos, 0,  -1);
        $cadenaManteniCorrectivos = substr($cadenaManteniCorrectivos, 0,  -1);

        $datos["mantenimientos_preventivos"] = $cadenaManteniPreventivos;
        $datos["mantenimientos_correctivos"] = $cadenaManteniCorrectivos;
        $datos["fecha_edita"] = date("Y-m-d H:i:s");

        $respuesta = ModelInventarioMantenimiento::mdlEditarMantenimiento($datos);

        if($respuesta == 'ok'){

            return 'ok';
            
        }else{

            return 'error';

        }

    }

    static public function ctrInfoMantenimientoId($idManteActivoFijo){

        $respuesta = ModelInventarioMantenimiento::mdlInfoMantenimientoId($idManteActivoFijo);

        return $respuesta;

    }

    static public function ctrListaMantenimientosRealizadosActivosFijos(){

        $respuesta = ModelInventarioMantenimiento::mdlListaMantenimientosRealizadosActivosFijos();

        return $respuesta;

    }

    static public function ctrInfoMantenimiento($datos){

        $respuesta = ModelInventarioMantenimiento::mdlInfoMantenimiento($datos);

        return $respuesta;

    }

    static public function ctrGuardarMantenimiento($datos){

        $cadenaManteniPreventivos = '';

        if(!empty($datos["mantenimientosPreventivos"])){

            foreach ($datos["mantenimientosPreventivos"] as $key => $valuePreventivo) {

                $cadenaManteniPreventivos .= $valuePreventivo.'|';

            }

        }

        $cadenaManteniCorrectivos = '';

        if(!empty($datos["mantenimientosCorrectivos"])){

            foreach ($datos["mantenimientosCorrectivos"] as $key => $valueCorrectivo) {

                $cadenaManteniCorrectivos .= $valueCorrectivo.'|';

            }

        }

        $cadenaManteniPreventivos = substr($cadenaManteniPreventivos, 0,  -1);
        $cadenaManteniCorrectivos = substr($cadenaManteniCorrectivos, 0,  -1);

        $datos["mantenimientos_preventivos"] = $cadenaManteniPreventivos;
        $datos["mantenimientos_correctivos"] = $cadenaManteniCorrectivos;

        $respuesta = ModelInventarioMantenimiento::mdlGuardarMantenimiento($datos);

        if($respuesta == 'ok'){

            //ACTUALIZAR ESTADO SOLICITUD
            $updSoli = ModelInventarioMantenimiento::mdlActualizarSolicitudMantenimiento($datos);

            if($updSoli == 'ok'){

                return 'ok';

            }else{
                
                return 'error';
            }

        }else{

            return 'error';

        }


    }

    static public function ctrInfoSolicitudMantenimiento($idSoliMantenimiento, $categoriaActivo){

        $respuesta = ModelInventarioMantenimiento::mdlInfoSolicitudMantenimiento($idSoliMantenimiento, $categoriaActivo);

        return $respuesta;

    }

    static public function ctrListaTiposMantenimientosEquipo($idEquipo, $categoriaActivo){

        $infoEquipo = ControladorInventarioMantenimiento::ctrInformacionEquipo($idEquipo, $categoriaActivo);

        if(!empty($infoEquipo)){

            $respuesta = ModelInventarioMantenimiento::mdlListaTiposMantenimientosEquipo($infoEquipo["tipo_equipo"], $categoriaActivo);
    
            return $respuesta;

        }else{

            return 'error';

        }

    }

    static public function ctrInformacionEquipo($idEquipo, $categoriaActivo){

        $respuesta = ModelInventarioMantenimiento::mdlInformacionEquipo($idEquipo, $categoriaActivo);

        return $respuesta;

    }

    static public function ctrEliminarMantenimientoActivoFijo($idTipoMante, $usuario){

        $tabla = "inventario_par_tipos_mantenimientos";

        $datos = array(

            "id_tipo_mante" => $idTipoMante,
            "usuario_elimina" => $usuario,
            "fecha_elimina" => date("Y-m-d H:i:s")

        );

        $respuesta = ModelInventarioMantenimiento::mdlEliminarMantenimientoActivoFijo($tabla, $datos);

        return $respuesta;

    }

    static public function ctrListaMantenimientosActivosFijos(){

        $tabla = "inventario_par_tipos_mantenimientos";

        $respuesta = ModelInventarioMantenimiento::mdlListaMantenimientosActivosFijos($tabla);

        return $respuesta;

    }

    static public function ctrCrearMantenimientoActivoFijo($datos){

        $tabla = "inventario_par_tipos_mantenimientos";

        $respuesta = ModelInventarioMantenimiento::mdlCrearMantenimientoActivoFijo($tabla, $datos);

        return $respuesta;

    }


}
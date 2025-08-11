<?php

class ControladorTickets{

    static public function ctrTerminarTicket($idTicket, $tipoSolucion){

        $fechaHora = date("Y-m-d H:i:s");

        $respuesta = ModelTickets::mdlTerminarTicket($idTicket, $tipoSolucion, $fechaHora);

        return $respuesta;

    }

    static public function ctrListaMisTicketsPendienteGestion($idUser){

        $respuesta = ModelTickets::mdlListaMisTicketsPendienteGestion($idUser);

        return $respuesta;

    }

    static public function ctrAgregarSeguimiento($datos){

        $hoy = date('YmdHis');
        
        if(!empty($datos["archivosTicket"])){

            $rutaArchivo = "../../../archivos_nexuslink/mesaayuda/archivos_tickets_seguimientos/".$hoy."/";

            if(!file_exists($rutaArchivo)){

                mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");

            }

            foreach ($datos["archivosTicket"]["tmp_name"] as $key => $tmp_name) {

                if($datos["archivosTicket"]["name"][$key]){

                    $aletorioArchivo = rand(0000001, 9999999);

                    $filenameArchivo = $aletorioArchivo.$datos["archivosTicket"]["name"][$key];
                    $sourceArchivo = $datos["archivosTicket"]["tmp_name"][$key];

                    $dirArchivo = opendir($rutaArchivo);
                    $target_path_archivo = $rutaArchivo."/".$filenameArchivo;

                    if(move_uploaded_file($sourceArchivo, $target_path_archivo)){

                        $resultado = "ok";

                    }else{

                        $resultado = "error";

                    }

                    closedir($dirArchivo);
        
                }

            }
        
        }else{

            $rutaArchivo = '';

        }

        $tabla = "mesaayuda_tickets_seguimientos";

        /*====================================
        SI EL ROL ES USUARIO SE ACTUALIZARA A PENDIENTE EL TICKET
        ====================================*/
        if($datos["rol_usuario"] == 'USUARIO'){

            $updEstadoTicket = ModelTickets::mdlActualizarEstadoTicket($datos["id_ticket"]);

        }

        $datosTicket = array(

            "id_ticket" => $datos["id_ticket"],
            "id_usuario" => $datos["id_usuario"],
            "descripcion" => $datos["descripcion"],
            "ruta_archivos" => $rutaArchivo,
            "usuario_crea" => $datos["usuario_crea"]

        );

        $agregarSeguimiento = ModelTickets::mdlAgregarSeguimiento($tabla, $datosTicket);

        if($agregarSeguimiento == "ok"){

            return "ok";

        }else{

            return $agregarSeguimiento;

        }


    }

    static public function ctrTomarTicket($user, $idUser, $idTicket, $rolUsuario){

        if($rolUsuario == 'SOPORTE'){

            /*============================
            VALIDAR ASIGNACION TICKET
            ============================*/
            $tabla = "mesaayuda_tickets";
            $item = "id_ticket";
            $valor = $idTicket;
            
            $dato = ControladorTickets::ctrObtenerDato($tabla, $item, $valor);

            if(empty($dato["id_usuario_soporte"]) && $dato["estado"] == 'CREADO'){

                /*==================================
                ASIGNAR TICKET 
                ==================================*/

                $asignarTicket = ControladorTickets::ctrAsignarTicket($idTicket, $idUser);

                if($asignarTicket == 'ok'){

                    return "ok-asignado";

                }else{

                    return "error-soporte";

                }

            }elseif($dato["id_usuario_soporte"] == $idUser && $dato["estado"] == 'PENDIENTE' || $dato["estado"] == 'PRE_REALIZADO'){

                /*=================================
                TICKET DEL USUARIO
                =================================*/
                return "ok-asignado-usuario";


            }elseif(!empty($dato["id_usuario_soporte"]) && $dato["id_usuario_soporte"] != $idUser){

                /*===================================
                TICKET YA ASIGNADO
                ===================================*/
                return "ok-ya-asignado";

            }

        }


    }

    static public function ctrAsignarTicket($idTicket, $idUser){

        $tabla = "mesaayuda_tickets";

        $datos = array(

            "id_ticket" => $idTicket,
            "id_usuario_soporte" => $idUser,
            "fecha_ini_ticket" => date("Y-m-d H:i:s"),
            "estado" => 'PENDIENTE' 

        );

        $respuesta = ModelTickets::mdlAsignarTicket($tabla, $datos);

        return $respuesta;

    }

    static public function ctrObtenerDato($tabla, $item, $valor){

        $respuesta = ModelTickets::mdlObtenerDato($tabla, $item, $valor);

        return $respuesta;

    }

    static public function ctrListaTicketsBolsa(){

        $respuesta = ModelTickets::mdlListaTicketsBolsa();

        return $respuesta;

    }

    static public function ctrVerArchivosSeguimientoTicket($rutaArchivos){

        if(!empty($rutaArchivos)){

            $cadena = '<ul class="list-group">';

            if($gestor = opendir($rutaArchivos)){

                while (($archivo = readdir($gestor)) !== false)  {

                    if (is_file($rutaArchivos."/".$archivo)) {

                        $cadena .= '<li class="list-group-item"><a class="" target="_blank" href="'.$rutaArchivos.$archivo.'"><i class="far fa-file"></i> '.$archivo.'</a></li>';

                    }     

                }

                closedir($gestor);

            }

            $cadena .= '</ul>';

            return $cadena;

        }
        
    }

    static public function ctrVerSeguimientosTicket($idTicket){

        $respuesta = ModelTickets::mdlVerSeguimientosTicket($idTicket);

        return $respuesta;

    }

    static public function ctrVerArchivosTicket($rutaArchivos){

        if(!empty($rutaArchivos)){

            $cadena = '<ul class="list-group">';

            if($gestor = opendir($rutaArchivos)){

                $contador = 0;

                while (($archivo = readdir($gestor)) !== false)  {

                    if (is_file($rutaArchivos."/".$archivo)) {

                        $contador++;

                        $cadena .= '<li class="list-group-item"><a class="" target="_blank" href="'.$rutaArchivos.$archivo.'"><i class="far fa-file"></i> '.$archivo.'</a></li>';

                    }     

                }

                closedir($gestor);

            }

            $cadena .= '</ul>';

            $datos = array(

                "cantidad_archivos" => $contador,
                "cadena" => $cadena

            );

            return $datos;

        }
        
    }

    static public function ctrVerInfoTicket($idTicket){

        $respuesta = ModelTickets::mdlVerInfoTicket($idTicket);

        return $respuesta;

    }

    static public function ctrMostrarMisTickets($usuario){

        $respuesta = ModelTickets::mdlMostrarMisTickets($usuario);

        return $respuesta;

    }

    static public function ctrCrearTicket($datos){

        $hoy = date('YmdHis');
        

        if(!empty($datos["archivosTicket"])){

            $rutaArchivo = "../../../archivos_nexuslink/mesaayuda/archivos_tickets/".$hoy."/";

            if(!file_exists($rutaArchivo)){

                mkdir($rutaArchivo, 0777, true) or die ("No se puede crear el directorio");

            }

            foreach ($datos["archivosTicket"]["tmp_name"] as $key => $tmp_name) {

                if($datos["archivosTicket"]["name"][$key]){

                    $aletorioArchivo = rand(0000001, 9999999);

                    $filenameArchivo = $aletorioArchivo.$datos["archivosTicket"]["name"][$key];
                    $sourceArchivo = $datos["archivosTicket"]["tmp_name"][$key];

                    $dirArchivo = opendir($rutaArchivo);
                    $target_path_archivo = $rutaArchivo."/".$filenameArchivo;

                    if(move_uploaded_file($sourceArchivo, $target_path_archivo)){

                        $resultado = "ok";

                    }else{

                        $resultado = "error";

                    }

                    closedir($dirArchivo);
        
                }

            }
        
        }else{

            $rutaArchivo = '';

        }

        $tabla = "mesaayuda_tickets";

        $datosTicket = array(

            "id_proyecto" => $datos["id_proyecto"],
            "id_usuario_ticket" => $datos["id_usuario_ticket"],
            "asunto" => strtoupper($datos["asunto"]),
            "descripcion" => $datos["descripcion"],
            "prioridad" => $datos["prioridad"],
            "ruta_archivos" => $rutaArchivo,
            "usuario_crea" => $datos["usuario_crea"]

        );

        $crearTicket = ModelTickets::mdlCrearTicket($tabla, $datosTicket);

        if($crearTicket == "ok"){

            return "ok";

        }else{

            return "error";

        }

    }

    static public function ctrCargarImagenesTickets($filename, $tmpName){

        if(!empty($filename)){
    
            $data = array();
    
            $location = '../../../archivos_nexuslink/mesaayuda/uploads_img_tickets/';
    
            if(!file_exists($location)){
                mkdir($location, 0755);
            }
    
            $location = $location.$filename;
    
            $fileExtension = pathinfo($location, PATHINFO_EXTENSION);
            $fileExtension = strtolower($fileExtension);
    
            $validExt = array('jpg', 'jpeg', 'png');
    
            if(in_array($fileExtension, $validExt)){
    
                list($width, $height) = getimagesize($tmpName);
                $newWidth = 600;
                $ratio = $newWidth / $width;
                $newHeight = $height * $ratio;
    
                $imageResized = imagecreatetruecolor($newWidth, $newHeight);
    
                switch ($fileExtension) {
                    case 'jpg':
                    case 'jpeg':
                        $imageSource = imagecreatefromjpeg($tmpName);
                        break;
                    case 'png':
                        $imageSource = imagecreatefrompng($tmpName);
                        break;
                    default:
                        $imageSource = false;
                        break;
                }
    
                if ($imageSource !== false) {
                    imagecopyresampled($imageResized, $imageSource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
                    switch ($fileExtension) {
                        case 'jpg':
                        case 'jpeg':
                            imagejpeg($imageResized, $location);
                            break;
                        case 'png':
                            imagepng($imageResized, $location);
                            break;
                    }
    
                    imagedestroy($imageResized);
                    imagedestroy($imageSource);
    
                    $data["filename"] = $filename;
                    $data["uploaded"] = 1;
                    $data["url"] = $location;
                } else {
                    $data["uploaded"] = 0;
                    $data["error"]["message"] = "Extensión no admitida";
                }
    
            } else {
    
                $data["uploaded"] = 0;
                $data["error"]["message"] = "Imagen no cargada";
    
            }
    
        } else {
    
            $data["uploaded"] = 0;
            $data["error"]["message"] = "Imagen no cargada";
    
        }
    
        echo json_encode($data);
    
    }
    
    

    // static public function ctrCargarImagenesTickets($filename, $tmpName){

    //     if(!empty($filename)){

    //         $data = array();

    //         //$location = '../../../archivos_nexuslink/uploads_img_tickets/'.$fechaCarpeta.'/';

    //         $location = '../../../archivos_nexuslink/mesaayuda/uploads_img_tickets/';

    //         if(!file_exists($location)){
                
    //             mkdir($location, 0755);
            
    //         }

    //         $location = $location.$filename;

    //         $fileExtension = pathinfo($location, PATHINFO_EXTENSION);
    //         $fileExtension = strtolower($fileExtension);

    //         $validExt = array('jpg', 'jpeg', 'png');

    //         if(in_array($fileExtension, $validExt)){

    //             if(move_uploaded_file($tmpName, $location)){

    //                 $data["filename"] = $filename;
    //                 $data["uploaded"] = 1;
    //                 $data["url"] = $location;

    //             }else{

    //                 $data["uploaded"] = 0;
    //                 $data["error"]["message"] = "Imagen no cargada";

    //             }


    //         }else{

    //             $data["uploaded"] = 0;
    //             $data["error"]["message"] = "Imagen no cargada";

    //         }

    //         // $array = array(

    //         //     "filename" => $filename,
    //         //     "tmpName" => $tmpName,
    //         //     "location" => $location,
    //         //     "fileExtension" => $fileExtension

    //         // );

    //         // return $array;

    //     }else{

    //         $data["uploaded"] = 0;
    //         $data["error"]["message"] = "Imagen no cargada";

    //     }

    //     echo json_encode($data);

    // }


}
<?php
session_start();

function is_authenticated() {
    return isset($_SESSION['id_usuario']);
}


if(is_authenticated()){
    
    $type = $_GET["type"];

    if($type == 'pdfIA'){

        $nombre_pdf = $_GET["nombre_pdf"];
        $pdf_path = '../archivos_nexuslink/pdfia/pdf/'.$nombre_pdf;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($pdf_path) . '"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        readfile($pdf_path);

    }

}else{

    header('HTTP/1.0 403 Forbidden');
    echo "Acceso denegado. Por favor, inicie sesión para ver este documento.";

}
exit;


?>

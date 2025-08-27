<?php
session_start();

function is_authenticated() {
    return isset($_SESSION['id_usuario']);
}

if(is_authenticated()){
    
    $type = $_GET["type"];

    if($type == 'new'){

        $numPaquete = $_GET["numPaquete"];
        $codImg = $_GET["codImg"];

        $pdf_path = '../archivos_nexuslink/pcm/imagen/'.mb_strtolower($numPaquete).'/'.$codImg.'.pdf';
        // $pdf_path = '../archivosEcat/imagen/paq10/pdf-prueba.pdf';

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($pdf_path) . '"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        readfile($pdf_path);

    }else if($type == 'history'){

        $numPaquete = $_GET["numPaquete"];
        $codImg = $_GET["codImg"];

        $pdf_path = '../archivos_nexuslink/pcm/historicos/'.mb_strtolower($numPaquete).'/'.$codImg.'.pdf';
        // $pdf_path = '../archivosEcat/imagen/paq10/pdf-prueba.pdf';

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($pdf_path) . '"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        readfile($pdf_path);


    }else if($type == 'compare'){
        
        $numPaquete = $_GET["numPaquete"];
        $codImg = $_GET["codImg"];

        $pdf_path = '../archivos_nexuslink/pcm/imagen/'.mb_strtolower($numPaquete).'/'.$codImg.'.pdf';
        
        // $pdf_path = '../archivosEcat/imagen/paq10/pdf-prueba.pdf';

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($pdf_path) . '"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        readfile($pdf_path);

    }else if($type == 'compare-new'){

        // VISUALIZAR PDF VS FURIPS HISTORICOS - NEW

        $numPaquete = $_GET["numPaquete"];
        $codImg = $_GET["codImg"];

        $pdf_path = '../archivos_nexuslink/pcm/imagen/'.mb_strtolower($numPaquete).'/'.$codImg.'.pdf';
        
        // $pdf_path = '../archivosEcat/imagen/paq10/pdf-prueba.pdf';

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($pdf_path) . '"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        readfile($pdf_path);


    }else if($type === 'compare-history'){

        // VISUALIZAR PDF VS FURIPS HISTORICOS - HISTORICOS

        $numPaquete = $_GET["numPaquete"];
        $codImg = $_GET["codImg"];

        $pdf_path = '../archivos_nexuslink/pcm/historicos/'.mb_strtolower($numPaquete).'/'.$codImg.'.pdf';
        
        // $pdf_path = '../archivosEcat/imagen/paq10/pdf-prueba.pdf';

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



// $pdf_path = '../archivosEcat/imagen/pdf-prueba.pdf';

// if (is_authenticated()) {

//     header('Content-Type: application/pdf');
//     header('Content-Disposition: inline; filename="' . basename($pdf_path) . '"');
//     header('Cache-Control: private, max-age=0, must-revalidate');
//     header('Pragma: public');

//     readfile($pdf_path);
// } else {

//     header('HTTP/1.0 403 Forbidden');
//     echo "Acceso denegado. Por favor, inicie sesión para ver este documento.";

// }
// exit;

?>

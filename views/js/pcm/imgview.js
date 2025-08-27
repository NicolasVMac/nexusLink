let codImg, type;

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

try {
    codImg = atob(getParameterByName('codImg'));
    type = getParameterByName('type');
    numPaquete = getParameterByName('numPaq');
    console.log(type);
    console.log(numPaquete);
    console.log(codImg);
} catch (error) {
    console.error("Error decodificando la cadena: ", error);
    toastr.error("¡Error de perfil, Sera direccionado al inicio", "Mensaje", { timeOut: 5000 });
    // setInterval(function () {
    //     window.location = "inicio";
    // }, 1000);


}

//alert(codImg);

switch (type) {
    case 'new':
        $('.pdf-container').html(`
            <br>
            <iframe src="view_pdf_pcm.php?type=${type}&codImg=${codImg}&numPaquete=${numPaquete.toLowerCase()}" height="1000" width="100%"></iframe>
        `);
        break;
    case 'history':
        $('.pdf-container').html(`
            <br>
            <iframe src="view_pdf_pcm.php?type=${type}&codImg=${codImg}&numPaquete=${numPaquete.toLowerCase()}" height="1000" width="100%"></iframe>
        `);
        break;
    case 'compare':
        reclamacionId = atob(getParameterByName('reclamacionId'));
        $('.pdf-container').html(`
            <br> 
            <iframe src="view_pdf_pcm.php?type=${type}&codImg=${codImg}&numPaquete=${numPaquete.toLowerCase()}" width="50%" height="1000" align="left"></iframe>
			<iframe src="vistas/assets/plugins/TCPDF/examples/furips.php?numRecla=`+ btoa(reclamacionId) + `" width="49%" height="1000" align="right"></iframe>
        `);
        break;
    case 'compare-new':
        reclamacionId = atob(getParameterByName('reclamacionId'));
        $('.pdf-container').html(`
            <br> 
            <iframe src="view_pdf_pcm.php?type=${type}&codImg=${codImg}&numPaquete=${numPaquete.toLowerCase()}" width="50%" height="1000" align="left"></iframe>
			<iframe src="vistas/assets/plugins/TCPDF/examples/furips.php?numRecla=`+ btoa(reclamacionId) + `" width="49%" height="1000" align="right"></iframe>
        `);
        break;
    case 'compare-history':
        reclamacionId = atob(getParameterByName('reclamacionId'));
        $('.pdf-container').html(`
            <br> 
            <iframe src="view_pdf_pcm.php?type=${type}&codImg=${codImg}&numPaquete=${numPaquete.toLowerCase()}" width="50%" height="1000" align="left"></iframe>
			<iframe src="vistas/assets/plugins/TCPDF/examples/furips.php?numRecla=`+ btoa(reclamacionId) + `" width="49%" height="1000" align="right"></iframe>
        `);
        break;
    default:
        window.location = "inicio";
        break;
}

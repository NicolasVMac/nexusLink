/*============================================
CARD INICIO MODULOS
============================================*/
$.ajax({
    url: 'ajax/config/users.ajax.php',
    type: 'POST',
    data: {
        'lista': 'mostrarPerfiles',
        'data': userSession
    },
    cache: false,
	dataType: "json",
    success:function(respuesta){
        
        let cadenaTarjeta = "";

        respuesta["permisosAsignados"].forEach(function(permiso) {

            // console.log(permiso)

            if(permiso.proyecto !== 'MESA AYUDA'){

                cadenaTarjeta += `
                    <div class="col-sm-6 col-md-3 mb-3">
                        <div class="card shadow-user-permited">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img class="img-fluid w-100 p-3 rounded-start" src="${permiso["ruta_imagen"]}" alt="Imagen ${permiso["proyecto"]}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h4 class="card-title">${permiso["proyecto"]}</h4>
                                        <p class="card-text">${permiso["descripcion"]}</p>
                                        <div class="d-grid gap-2">
                                            <a href="index.php?ruta=${permiso["ruta"]}/inicio" class="btn btn-soft-success me-1 mb-1 btn-block btn-sm">Ingresar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;


            }else{

                cadenaTarjeta += `
                    <div class="col-sm-6 col-md-3 mb-3">
                        <div class="card shadow-user-permited">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img class="img-fluid w-100 p-3 rounded-start" src="${permiso["ruta_imagen"]}" alt="Imagen ${permiso["proyecto"]}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h4 class="card-title">${permiso["proyecto"]}</h4>
                                        <p class="card-text">${permiso["descripcion"]}</p>
                                        <div class="d-grid gap-2">
                                            <a href="https://cuentasmedicas.nexusmerak.app/helpdesk/login" target="_blank" class="btn btn-soft-success me-1 mb-1 btn-block btn-sm">Ingresar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;



            }


        })

        respuesta["permisosNoAsignados"].forEach(function(permiso) {

            cadenaTarjeta += `
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="card shadow-user-permited" style="background: #F9F8F8;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img class="img-fluid w-100 p-3 rounded-start" style="opacity: 0.3;" src="${permiso["ruta_imagen"]}" alt="Imagen ${permiso["proyecto"]}">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title">${permiso["proyecto"]}</h4>
                                    <p class="card-text">${permiso["descripcion"]}</p>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-phoenix-secondary me-1 mb-1 btn-block btn-sm" type="button">Ingresar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

        })

        $("#contenedorTarjetasModulos").html('<div class="row mb-2">'+cadenaTarjeta+'</div>');

    }
})

/*============================================
MENUS DINAMICOS
============================================*/
if(typeof proyectoCurrent !== 'undefined' && proyectoCurrent !== null){

    //console.info(proyectoCurrent);

    $.ajax({

        url: 'ajax/config/users.ajax.php',
        type: 'POST',
        data: {
            'lista': 'mostrarMenuUsuarioProyecto',
            'data': userSession,
            'proyecto': proyectoCurrent
        },
        cache: false,
        dataType: "json",
        success:function(respuesta){

            //console.log(respuesta);
            //console.log(respuesta[0]);
            // console.log(respuesta["Configuraciones"]);

            let arrayMenu = respuesta["menus"];


            let cadenaMenu = "";
            let cadenaOpciones = "";

            cadenaMenu += '<ul class="navbar-nav navbar-nav-top" data-dropdown-on-hover="data-dropdown-on-hover">';

            arrayMenu.forEach(function(menu){

                //console.log("Menu: " + menu["menu"]);

                let menuText = menu["menu"];

                cadenaMenu += '<li class="nav-item dropdown">'+
                    '<a class="nav-link dropdown-toggle lh-1" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">'+
                        '<span class="'+menu['icon']+'"></span> '+menu["menu"]+''+
                    '</a>'+
                    '<ul class="dropdown-menu navbar-dropdown-caret">';
                        respuesta[menuText].forEach(function(opcion){
                            cadenaOpciones += '<li>'+
                                '<a class="dropdown-item" href="index.php?ruta='+opcion["ruta"]+'">'+
                                    '<div class="dropdown-item-wrapper">'+
                                        '<span class="'+opcion["icon"]+'"></span> '+opcion["nombre"]+''+
                                    '</div>'+
                                '</a>'+
                            '</li>';
                        })

                    cadenaMenu += cadenaOpciones;
                    
                    cadenaMenu += '</ul></li>';

                cadenaOpciones = '';

            })

            cadenaMenu += '</ul>';

            $("#contenedorMenusDinamicos").html(cadenaMenu);


        }

    })

}
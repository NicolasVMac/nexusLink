$("#btLogin").click(function () {

    var formulario = document.getElementById("formLogin");

    if (formulario.checkValidity()) {
        console.log("sin error");
        //$("#btLogin").attr('disabled', true);
        const formData = {
            user: $('#userSign').val(),
            password: $('#password').val()
        };
        $.ajax({
            url: 'ajax/login.ajax.php',
            type: 'POST',
            data: {
                'lista': 'login',
                'data': btoa(JSON.stringify(formData))
            },
            success: function (respuesta) {
                switch (respuesta) {
                    case 'success':
                        toastr.info('Datos Correctos!!!, Bienvenido <b>' + $('#userSign').val() + '</b>', { timeOut: 5000 }, { "positionClass": "toast-top-full-width" });
                        setInterval(function () {
                            //window.location = "inicio";
                            window.location = "index.php?ruta=inicio";
                        },800)
                        break;
                    case 'Incorrect':
                        toastr.error('Datos incorrectos!!!, Intente nuevamente.', { timeOut: 5000 }, { "positionClass": "toast-top-full-width" })
                        break;
                    case 'disabled':
                        toastr.warning('El usuario <b>' + $('#userSign').val() + '</b> se encuentra desactivado', { timeOut: 5000 }, { "positionClass": "toast-top-full-width" })
                        break;
                    case 'Login':
                        toastr.warning('El usuario <b>' + $('#userSign').val() + '</b> posee una sesion activa', { timeOut: 5000 }, { "positionClass": "toast-top-full-width" })
                        break;
                    default:
                        toastr.error('Error al ingresar, comuniquese con el Administrador.', { timeOut: 5000 }, { "positionClass": "toast-top-full-width" })
                }
            }
        })
    } else {
        console.log("Form Error");
    }

})

<div class="row vh-100 g-0">
    <div class="col-lg-8 position-relative d-none d-lg-block border-end">
        <div class="bg-holder opacity-25" style="background-image:url(views/assets/img/fondo.jpg);">
        </div>
        <!--/.bg-holder-->

    </div>
    <div class="col-lg-4">
        <div class="row flex-center h-100 g-0 px-4 px-sm-0">
            <div class="col col-sm-6 col-lg-7 col-xl-6">
                <div class="text-center">
                    <img src="views/assets/img/link.png" style="height: 200px;" class="img-fluid" alt="">
                </div>
                <br>
                <div class="text-center mb-7">
                    <h3 class="text-1000">Bienvenido a NexusLink</h3>
                    <p class="text-700">Ingrese sus credenciales</p>
                </div>
                <div class="position-relative">
                    <hr class="bg-200 mt-5 mb-4">
                </div>
                <form id="formLogin" name="formLogin" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                    <div class="mb-3 text-start">
                        <label class="form-label" for="email">Usuario</label>
                        <div class="form-icon-container">
                            <input class="form-control form-icon-input" id="userSign" type="text" name="userSign" placeholder="Usuario">
                            <i class="fas fa-envelope form-icon"></i>
                            <!-- <svg class="svg-inline--fa fa-user text-900 fs--1 form-icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                <path fill="currentColor" d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"></path>
                            </svg> -->
                        </div>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="password">Password</label>
                        <div class="form-icon-container">
                            <input class="form-control form-icon-input" id="password" type="password" name="password" placeholder="Password">
                            <i class="fa fa-key form-icon"></i>
                            <!-- <svg class="svg-inline--fa fa-key text-900 fs--1 form-icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="key" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor" d="M282.3 343.7L248.1 376.1C244.5 381.5 238.4 384 232 384H192V424C192 437.3 181.3 448 168 448H128V488C128 501.3 117.3 512 104 512H24C10.75 512 0 501.3 0 488V408C0 401.6 2.529 395.5 7.029 391L168.3 229.7C162.9 212.8 160 194.7 160 176C160 78.8 238.8 0 336 0C433.2 0 512 78.8 512 176C512 273.2 433.2 352 336 352C317.3 352 299.2 349.1 282.3 343.7zM376 176C398.1 176 416 158.1 416 136C416 113.9 398.1 96 376 96C353.9 96 336 113.9 336 136C336 158.1 353.9 176 376 176z"></path>
                            </svg> -->
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3" id="btLogin" name="btLogin">Iniciar Sesion</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="views/js/login.js?v=<?= md5_file('views/js/login.js') ?>"></script>
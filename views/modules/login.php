<div class="container-fluid bg-300 dark__bg-1200">
    <div class="bg-holder bg-auth-card-overlay" style="background-image:url(views/assets/img/background.jpg);">
    </div>
    <div class="row flex-center position-relative min-vh-100 g-0 py-5">
        <div class="col-12 col-sm-11 col-md-10 col-lg-9	col-xl-8 col-xxl-7">
            <div class="card border border-200 auth-card">
                <div class="card-body pe-md-0">
                    <div class="row align-items-center gx-0 gy-7">
                        <div class="col-auto bg-100 dark__bg-1100 rounded-3 position-relative overflow-hidden auth-title-box">
                            <div class="bg-holder" style="background-image:url(views/assets/img/loginImg.jpg);">
                            </div>

                            <div class="position-relative px-4 px-lg-7 pt-7 pb-7 pb-sm-5 text-center text-md-start pb-lg-7 pb-md-7">
                                <h3 class="mb-3 text-black fs-1"></h3>
                                <p class="text-700"></p>

                            </div>
                            <div class="position-relative z-index--1 mb-6 d-none d-md-block text-center mt-md-15"><img class="auth-title-box-img d-dark-none" src="#" alt="" /></div>
                        </div>
                        <div class="col mx-auto">
                            <div class="auth-form-box">
                                <div class="text-center">
                                    <img src="views/assets/img/VidaMedical.png" class="img-fluid" alt="Vidamedical" width="250" />
                                </div>
                                <div class="text-center mb-7">
                                    <h3 class="text-1000">Bienvenido</h3>
                                    <p class="text-700">Ingrese sus credenciales</p>
                                </div>
                                <form id="formLogin" name="formLogin" role="form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                                    <div class="mb-3 text-start">
                                        <label class="" for="userSign">Usuario</label>
                                        <div class="form-icon-container">
                                            <input type="text" class="form-control form-icon-input" id="userSign" name="userSign" placeholder="Usuario" autocomplete="off" onkeyup="lower(this)" required> <span class="fas fa-user text-900 fs--1 form-icon"></span>
                                        </div>
                                    </div>
                                    <div class="mb-3 text-start">
                                        <label class="" for="password">Contraseña</label>
                                        <div class="form-icon-container">
                                            <input class="form-control form-icon-input" id="password" type="password" placeholder="Password" required/><span class="fas fa-key text-900 fs--1 form-icon"></span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mb-3" id="btLogin" name="btLogin">Conectarse</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="views/js/login.js?v=<?= md5_file('views/js/login.js') ?>"></script>
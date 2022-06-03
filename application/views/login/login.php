<div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark" style=" height: 100vh;">
    <div class="auth-box bg-dark border-top border-secondary d-flex align-items-center " style=" height: 100vh;">
        <div id="loginform">
            <div class="text-center pt-1 pb-1">
                <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="<?=base_url()?>assets/images/cdnlogo.com_pokemon.svg" style="width: 200px;" alt="homepage"
                                 class="light-logo"/>
                </span>
            </div>
            <div class="text-center pt-3 pb-3">
                <h4 class="text-white"> Adminsitarción PokeApp</h4>
            </div>
            <!-- Form -->
            <form class="form-horizontal mt-3" id="loginform" action="" method="post">
                <div class="row pb-1">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white h-100" id="basic-addon1"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" class="form-control form-control-lg" name="username" id="username" placeholder="Usuario" aria-label="Usuario" aria-describedby="basic-addon1" required="">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning text-white h-100" id="basic-addon2"><i class="ti-pencil"></i></span>
                            </div>
                            <input type="password" name="passw" id="passw" class="form-control form-control-lg validate" autocomplete="new-password"
                                    placeholder="Contraseña" aria-label="Contraseña" aria-describedby="basic-addon1" required="">
                        </div>
                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                    </div>
                </div>
                <div class="row pb-1">
                    <div class="col-12">
                                <button class="btn btn-success float-end text-white" type="submit"> Ingresar </button>
                    </div>
                </div>
            </form>
            <form action="<?= base_url('acceso/recuperar'); ?>" method="post" name="recuperarform" id="recuperarform">
                <div class="row border-top border-secondary pt-1">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="pt-3">
                                <button class="btn btn-info" id="Recuperar" type="submit"><i class="fa fa-lock me-1"></i> Recuperar mi contraseña </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


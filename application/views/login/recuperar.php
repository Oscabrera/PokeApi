
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark" style=" height: 100vh;">
    <div class="auth-box bg-dark border-top border-secondary d-flex align-items-center " style=" height: 100vh;">
        <div id="loginform">
            <div class="text-center pt-3 pb-3">
                <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="<?=base_url()?>assets/images/cdnlogo.com_pokemon.svg" style="width: 200px;" alt="homepage"
                                 class="light-logo"/>
                </span>

            </div>
            <div class="text-center pt-3 pb-3">
                <h4 class="text-white"> Recuperar contraseña</h4>
            </div>
            <!-- Form -->
            <form class="form-horizontal mt-3" id="loginform" action="<?=base_url('acceso/recuperar');?>" method="post">
                <div class="row pb-1">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white h-100" id="basic-addon1"><i class="ti-email"></i></span>
                            </div>
                            <input  class="form-control form-control-lg" type="email" name="correo" id="correo" placeholder="Ingresa tu correo" aria-label="Ingresa tu correo" aria-describedby="basic-addon1" required="">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white h-100" id="basic-addon1"><i class="ti-email"></i></span>
                            </div>
                            <input  class="form-control form-control-lg" type="email" name="correo2" id="correo2" placeholder="Confirma tu correo" aria-label="Confirma tu correo" aria-describedby="basic-addon1" required="">
                        </div>
                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                        <div class="row justify-content-center msjp"> <span></span> </div>
                    </div>
                </div>
                <div class="row pb-1">
                    <div class="col-12">
                        <button class="btn btn-success float-end text-white submit" type="submit"> Recuperar </button>
                    </div>
                </div>
            </form>
            <form action="<?= base_url('acceso'); ?>" method="post" name="regresarform" id="regresarform">
                <div class="row border-top border-secondary pt-1">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="pt-3">
                                <button class="btn btn-info" id="regresar" type="submit"><i class="fas fa-undo me-1"></i> Regresar </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>





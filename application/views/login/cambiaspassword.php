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
                <p class="text-white">Para continuar, ingrese una nueva contraseña<br>
                    y el código que recibió en su correo electrónico</p>
            </div>


            <form class="form-horizontal mt-3" id="loginform" action="<?= base_url(); ?>acceso/restablecer"
                  method="post">
                <input type="hidden" name='token' value="<?= $token ?>">

                <div class="row pb-1">
                    <div class="col-12">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text bg-warning text-white h-100" id="basic-addon1"><i
                                        class="ti-key"></i></span>
                            </div>
                            <input type="text" class="form-control form-control-lg" name="codigo" id="codigo"
                                   placeholder="Código de verificación" aria-label="Código de verificación"
                                   aria-describedby="basic-addon1" required autocomplete="new-password">

                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text bg-success text-white h-100" id="basic-addon1"><i
                                        class="ti-lock"></i></span>
                            </div>
                            <input type="password" class="form-control form-control-lg" name="contrasenia1"
                                   minlength="6"
                                   id="password" placeholder="Ingresa una nueva contraseña"
                                   aria-label="Ingresa una nueva contraseña" aria-describedby="basic-addon1" required
                                   autocomplete="new-password">

                        </div>

                        <div class="input-group  mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white h-100" id="basic-addon1"><i
                                        class="ti-lock"></i></span>
                            </div>
                            <input type="password" class="form-control form-control-lg" name="contrasenia2"
                                   minlength="6"
                                   id="password2" placeholder="Confirma la nueva contraseña"
                                   aria-label="Confirma la nueva contraseña" aria-describedby="basic-addon1" required
                                   autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                <div class="row justify-content-center msjp"><span></span></div>

                <div class="row pb-1">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success float-end text-white submit" > Guardar contraseña</button>
                    </div>
                </div>


            </form>




        </div>
    </div>
</div>

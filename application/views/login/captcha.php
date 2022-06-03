<script src="https://www.google.com/recaptcha/api.js?render=6LdokbAaAAAAAJRB_mtD90wloBKP0BgpAf0mkyjY"></script>
  <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('6LdokbAaAAAAAJRB_mtD90wloBKP0BgpAf0mkyjY', { action: '<?=$accion?>' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
                //console.log(token);
            });
        });

    </script>

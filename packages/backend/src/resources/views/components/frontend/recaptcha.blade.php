<script src="https://www.google.com/recaptcha/api.js?render={{ $recaptcha['google_recaptcha_key'] }}"></script>

<div class="recaptcha-token"></div>

<script type="text/javascript">
    grecaptcha.ready(function () {
        grecaptcha.execute('{{ $recaptcha['google_recaptcha_key'] }}', {
            action: 'submit'
        }).then(function (token) {
            let forms = document.getElementsByClassName('recaptcha-token');
            let input = document.createElement('input');
            input.setAttribute('type', 'hidden');
            input.setAttribute('name', 'recaptcha');
            input.value = token;

            for (i = 0; i < forms.length; i++) {
                forms[i].appendChild(input);
            }
        });
    });
</script>
let grecaptchaWidget;
let grecaptchaWidgetResolver;
let CreatePromise = function (resolveCallback) {
    let resolved = false;
    let payload;
    let callbackList = [];

    resolveCallback(function(data) {
        resolved = true;
        payload = data;
        callbackList.forEach(function(f) { f() });
    });

    return {
        then: function (callback) { if (resolved) { callback(payload) } else { callbackList.push(function() { callback(payload) }) } }
    }
}

function recaptchaLoadCallback() {
    grecaptchaWidget = grecaptcha.render(document.getElementById('recaptcha-render'), {
        sitekey : recaptchaSiteKey,
        callback: function(response) {
            grecaptchaWidgetResolver(response);
        },
        'size' : "invisible"
    });
}

function loadRecapchaAndSubmit(callback) {
    if (typeof grecaptcha === 'undefined') {
        return;
    }

    let widgetPromise = CreatePromise(function(resolve) {
        grecaptchaWidgetResolver = resolve;
    });

    widgetPromise.then(function(result) {
        callback(result);
    });

    grecaptcha.reset(grecaptchaWidget);
    grecaptcha.execute(grecaptchaWidget)
        .catch(function (err) {
            console.err(err);
        });
}

function recapchaRenderTokenToForm(form) {
    if (typeof grecaptcha === 'undefined') {
        return true;
    }

    loadRecapchaAndSubmit(
        function (token) {
            let e = document.createElement('input');
            e.name = "g-recaptcha-response";
            e.value = token;
            e.type = 'hidden';
            form.appendChild(e);
            HTMLFormElement.prototype.submit.call(form);
        }
    );

    return false;
}

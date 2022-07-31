$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $(document).ajaxError(function (event, jqxhr, settings, thrownError) {
        if (jqxhr.status === 401) {
            window.location = "/";
        }

        if (jqxhr.status === 419) {
            window.location = location.toString();
        }
    });
});

function ajaxRequest(url, data = null, options = {}) {
    let jqxhr = $.ajax({
        type: options.method || 'POST',
        url: url,
        dataType: options.dataType || 'json',
        data: data,
        cache: false,
        async: typeof options.async !== 'undefined' ? options.async : true,
    });

    jqxhr.done(function(response) {
        if (options.callback || false) {
            options.callback(response);
        }
    });

    jqxhr.fail(function(response) {
        if (options.failCallback || false) {
            options.failCallback(response);
        }
    });

    return jqxhr.responseJSON;
}

function replace_template( template, data ) {
    return template.replace(
        /{(\w*)}/g,
        function( m, key ){
            return data.hasOwnProperty( key ) ? data[ key ] : "";
        }
    );
}

function process_each(elements, cb, timeout, options = {}) {
    let i = 0;
    let l = elements.length;

    (function fn() {
        let result = cb.call(elements[i++]);
        if (i < l) {
            setTimeout(fn, timeout);
        } else {
            if (options.completeCallback || false) {
                options.completeCallback(result);
            }
        }
    }());
}

function random_string(length) {
    let result = '';
    let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    let charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}

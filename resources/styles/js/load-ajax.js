$(document).on("turbolinks:load", function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $(document).ajaxError(function (event, jqxhr, settings, thrownError) {
        if (jqxhr.status === 401) {
            Turbolinks.visit('/');
        }

        if (jqxhr.status === 419) {
            Turbolinks.visit(location.toString());
        }
    });
});

function show_message(message, status = 'success') {
    if (message) {
        if (status === "success") {
            toastr.success(message, 'Successfully!');
        }
        else {
            toastr.error(message, 'Error!');
        }
    }
}

function replace_template(template, data){
    return template.replace(
        /{(\w*)}/g,
        function( m, key ){
            return data.hasOwnProperty( key ) ? data[ key ] : "";
        }
    );
}


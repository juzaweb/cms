$(document).on("turbolinks:load", function() {
    $('body').on('submit', '.cms-update-form', function(event) {
        if (event.isDefaultPrevented()) {
            return false;
        }

        event.preventDefault();

        var form = $(this);
        var formData = new FormData(form[0]);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            dataType: 'json',
            data: formData,
            cache:false,
            contentType: false,
            processData: false
        }).done(function(response) {

            show_message(response);



            if (response.data.redirect) {
                setTimeout(function () {
                    Turbolinks.visit(response.data.redirect, {action: "replace"});
                }, 1000);
                return false;
            }

            if (response.status === false) {
                return false;
            }

            return false;
        }).fail(function(response) {
            show_message(response);
            return false;
        });
    });
});

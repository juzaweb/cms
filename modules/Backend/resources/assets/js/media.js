$(document).on("turbolinks:load", function() {
    $('#media-container').on('click', '.show-form-upload', function () {
        let form = $('.media-upload-form');

        if (form.is(':hidden')) {
            form.show('slow');
        } else {
            form.hide('slow');
        }
    })
});
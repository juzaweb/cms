$(document).ready(function () {
    let mediaContainer = $('#media-container');
    mediaContainer.on('click', '.show-form-upload', function () {
        let form = $('.media-upload-form');

        if (form.is(':hidden')) {
            form.show('slow');
        } else {
            form.hide('slow');
        }
    })
});

$(document).ready(function () {
    const mediaContainer = $('#media-container');
    mediaContainer.on('click', '.show-form-upload', function () {
        let form = $('.media-upload-form');

        if (form.is(':hidden')) {
            form.show('slow');
        } else {
            form.hide('slow');
        }
    });

    mediaContainer.on('click', '.media-file-item', function () {
        let temp = document.getElementById('media-detail-template').innerHTML;
        let info = JSON.parse($(this).find('.item-info').val());

        temp = replace_template(temp, info);
        $('#preview-file').html(temp);
    });
});

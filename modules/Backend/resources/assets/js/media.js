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
        toggle_global_loading(true);

        let id = $(this).data('id');
        ajaxRequest(
            juzaweb.adminUrl + '/media/file/'+ id,
            null,
            {
                method: 'GET',
                callback: function (response) {
                    let temp = document.getElementById('media-detail-modal-template').innerHTML;
                    temp = replace_template(temp, response.file);
                    $('#show-modal').empty().html(temp);
                    $('#show-modal .modal').modal();
                    toggle_global_loading(false);
                },
                failCallback: function (response) {
                    show_notify(response);
                    toggle_global_loading(false);
                }
            }
        );
    });
});

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

        info.name = htmlspecialchars(info.name);
        temp = replace_template(temp, info);
        $('#preview-file').html(temp);
    });

    $('#preview-file').on('click', '.delete-file', function () {
        let id = $(this).data('id');
        let is_file = $(this).data('is_file');
        let name = $(this).data('name');

        confirm_message(
            juzaweb.lang.remove_question.replace(':name', (is_file == 1 ? ' file '+ name : ' folder '+ name)),
            function (value) {
                if (!value) {
                    return false;
                }

                toggle_global_loading(true);
                ajaxRequest(
                    juzaweb.adminUrl + '/media/'+ id,
                    {
                        is_file: is_file
                    },
                    {
                        method: 'DELETE',
                        callback: function (response) {
                            toggle_global_loading(false);
                            show_notify(response);

                            setTimeout(
                                function () {
                                    window.location = "";
                                },
                                500
                            );
                        },
                        failCallback: function (response) {
                            toggle_global_loading(false);
                            show_notify(response);
                        }
                    }
                );
            }
        );
    });
});

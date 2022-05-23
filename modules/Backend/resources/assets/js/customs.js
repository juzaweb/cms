$(document).ready(function () {
    let bodyElement = $('body');

    bodyElement.on('change', '.show_on_front-change', function () {
        let showOnFront = $(this).val();

        if (showOnFront == 'posts') {
            $('.select-show_on_front').prop('disabled', true);
        }

        if (showOnFront == 'page') {
            $('.select-show_on_front').prop('disabled', false);
        }
    });

    bodyElement.on('click', '.cancel-button', function () {
        window.location = "";
    });

    bodyElement.on('change', '.generate-slug', function () {
        let title = $(this).val();

        ajaxRequest(juzaweb.adminUrl +'/load-data/generateSlug', {
            title: title
        }, {
            method: 'GET',
            callback: function (response) {
                $('input[name=slug]').val(response.slug).trigger('change');
            }
        });
    });

    bodyElement.on('click', '.slug-edit', function () {
        let slugInput = $(this).closest('.input-group').find('input:first');
        slugInput.prop('readonly', !slugInput.prop('readonly'));
    });

    bodyElement.on('click', '.close-message', function () {
        let id = $(this).data('id');
        ajaxRequest(juzaweb.adminUrl + '/remove-message', {
            id: id,
        }, {
            method: 'POST',
            callback: function (response) {

            }
        });
    });
});

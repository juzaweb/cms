$(document).on("turbolinks:load", function() {
    $('body').on('change', '.show_on_front-change', function () {
        let showOnFront = $(this).val();
        
        if (showOnFront == 'posts') {
            $('.select-show_on_front').prop('disabled', true);
        }

        if (showOnFront == 'page') {
            $('.select-show_on_front').prop('disabled', false);
        }
    });

    $('body').on('click', '.cancel-button', function () {
        window.location = "";
    });

    $('body').on('change', '.generate-slug', function () {
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

    $('body').on('click', '.slug-edit', function () {
        let slugInput = $(this).closest('.input-group').find('input:first');
        slugInput.prop('readonly', !slugInput.prop('readonly'));
    });
});

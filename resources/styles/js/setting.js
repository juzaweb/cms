$(document).on("turbolinks:load", function() {

    $('#setting-menu').on('click', '.list-group-item', function () {
        let form = $(this).data('form');

        $.ajax({
            type: 'GET',
            url: '/admin-cp/setting/system/get-form',
            dataType: 'json',
            data: {
                'form': form,
            }
        }).done(function(data) {

            if (data.status === "error") {
                show_message(data.message, 'error');
                return false;
            }

            $('#setting-title').empty().html(data.data.title);
            $('#setting-form').empty().html(data.data.html);

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });

    });


});
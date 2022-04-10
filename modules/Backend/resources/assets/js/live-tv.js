$(document).on("turbolinks:load", function() {
    $('.form-add-category').on('click', '.add-category', function () {
        let name = $("#categoryName").val();
        if (!name) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/admin-cp/live-tv-categories/save',
            dataType: 'json',
            data: {
                'name': name,
                'status': 1,
                'addtype': 2,
            }
        }).done(function(data) {

            if (data.status === "error") {
                show_message(data.message, 'error');
                return false;
            }

            var newOption = new Option(data.text, data.id, false, false);
            $("#category_id").append(newOption).val(data.id).trigger('change');
            $("#categoryName").val('');

            return false;
        }).fail(function(data) {
            show_message(juzaweb.lang.data_error, 'error');
            return false;
        });
    });
});
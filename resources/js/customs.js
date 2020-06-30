$(document).on("turbolinks:load", function() {
    $('#lfm').filemanager('image');

    $(document).on('change', '.checkedAll', function () {
        if ($(this).is(':checked')) {
            $("input.ids").prop('checked', true);
        }
        else {
            $("input.ids").prop('checked', false);
        }
    });

    $(document).on('click', '.delete-items', function () {
        let ids = $("input[name=ids]:checked").map(function(){return $(this).val();}).get();
        $.ajax({
            type: 'POST',
            url: '',
            dataType: 'json',
            data: {
                'ids': ids
            }
        }).done(function(data) {

            return false;
        }).fail(function(data) {

            return false;
        });
    });
});
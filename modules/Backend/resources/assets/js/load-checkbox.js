$(document).ready(function () {
    var item_template = '<li class="m-1" id="item-genre-{id}">\n' +
        '        <div class="custom-control custom-checkbox">\n' +
        '            <input type="checkbox" name="items[]" class="custom-control-input" id="genre-{id}" value="{id}">\n' +
        '            <label class="custom-control-label" for="genre-{id}">{name}</label>\n' +
        '         </div>\n' +
        '    </li>';

    if ($('.load-checkbox-items').length) {
        $.ajax({
            type: 'GET',
            url: '/'+ juzaweb.adminPrefix +'/load-data/loadGenres',
            dataType: 'json',
            data: {}
        }).done(function(data) {

            if (data.status === "error") {
                show_message(data.message, 'error');
                return false;
            }

            $.each(data.results, function (index, item) {

            });
            $('.load-checkbox-items').append();

            return false;
        }).fail(function(data) {
            show_message(juzaweb.lang.data_error, 'error');
            return false;
        });
    }
});

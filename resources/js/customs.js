$(document).on("turbolinks:load", function() {
    $('#lfm').filemanager('image');

    $('.add-new-category').on('click', function () {
        if ($('.form-add-category').is(":hidden")) {
            $('.form-add-category').show('slow');
        }
        else {
            $('.form-add-category').hide('slow');
        }
    });

    $('.form-add-category').on('click', 'button[type=button]', function () {
        let name = $("#categoryName").val();
        let category_item = '<li class="m-1" id="item-category-{id}">\n' +
            '  <div class="custom-control custom-checkbox">\n' +
            '    <input type="checkbox" name="categories[]" class="custom-control-input" id="category-{id}" value="{id}">\n' +
            '    <label class="custom-control-label" for="category-{id}">{name}</label>\n' +
            '  </div>\n' +
            '</li>';

        if (!name) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/admin/post-categories/save',
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

            let item = replace_template(category_item, data);
            $(".show-categories ul").append(item);

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });
    });
});
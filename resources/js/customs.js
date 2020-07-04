$(document).on("turbolinks:load", function() {
    $('#lfm').filemanager('image');

    var tag_item = '<span class="tag m-1">{name} <a href="javascript:void(0)" class="text-danger ml-1 remove-tags"><i class="fa fa-times-circle"></i></a>\n' +
        '  <input type="hidden" name="tags[]" class="tag-explode" value="{id}">\n' +
        '</span>';

    $('.add-new-category').on('click', function () {
        if ($('.form-add-category').is(":hidden")) {
            $('.form-add-category').show('slow');
        }
        else {
            $('.form-add-category').hide('slow');
        }
    });

    $('.add-new-tags').on('click', function () {
        if ($('.form-add-tags').is(":hidden")) {
            $('.form-add-tags').show('slow');
        }
        else {
            $('.form-add-tags').hide('slow');
        }
    });

    $('.select-tags').on('change', function () {
        let id = $(this).val();
        let name = $(this).text();

        let item = replace_template(tag_item, {
            'name': name,
            'id': id,
        });

        $(".show-tags").append(item);
        $(this).val(null).trigger('change.select2');
    });

    $('.form-add-category').on('click', '.add-category', function () {
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
            $("#categoryName").val('');

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });
    });

    $('.form-add-tags').on('click', '.add-tags', function () {
        let name = $("#tagsName").val();

        if (!name) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/admin/tags/save',
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

            let item = replace_template(tag_item, data);
            $(".show-tags").append(item);
            $("#tagsName").val('');

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });
    });

    $(document).on('click', '.remove-tag-item', function () {
        $(this).closest('span.m-1').remove();
    });
});
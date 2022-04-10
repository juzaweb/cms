$(document).on("turbolinks:load", function() {
    $('.form-taxonomy').on('click', '.add-new', function () {
        let formAdd = $(this).closest('.form-taxonomy').find('.form-add');
        if (formAdd.is(':visible')) {
            formAdd.hide('slow');
        } else {
            formAdd.show('slow');
        }
    });

    $('body').on('change', '.select-tags', function () {
        let item = $(this);
        let id = item.val();
        let taxonomy = item.data('taxonomy');
        let type = item.data('type');

        $.ajax({
            type: 'GET',
            url: juzaweb.adminUrl + '/taxonomy/' + type +'/' + taxonomy + '/component-item',
            dataType: 'json',
            data: {
                'id': id
            }
        }).done(function(response) {
            if (response.status === false) {
                show_message(response);
                return false;
            }

            item.closest('.form-taxonomy')
                .find('.show-tags')
                .append(response.data.html);

            item.val(null).trigger('change.select2');

            return false;
        }).fail(function(response) {
            show_message(response);
            return false;
        });
    });

    $('body').on('click', '.remove-tag-item', function () {
        $(this).closest('.tag').remove();
    });

    $('body').on('click', '.form-add-taxonomy button', function () {
        let btn = $(this);
        let taxForm = btn.closest('.form-add');
        let name = taxForm.find('.taxonomy-name').val();
        let parent = taxForm.find('.taxonomy-parent').val();
        let type = btn.data('type');
        let taxonomy = btn.data('taxonomy');
        let postType = btn.data('post_type');
        let icon = btn.find('i').attr('class');

        btn.find('i').attr('class', 'fa fa-spinner fa-spin');
        btn.prop("disabled", true);

        $.ajax({
            type: 'POST',
            url: juzaweb.adminUrl + '/taxonomy/' + type +'/' + taxonomy,
            dataType: 'json',
            data: {
                name: name,
                parent_id: parent,
                post_type: postType,
                taxonomy: taxonomy,
            }
        }).done(function(response) {

            btn.find('i').attr('class', icon);
            btn.prop("disabled", false);

            if (response.status === false) {
                show_message(response);
                return false;
            }

            btn.closest('.form-taxonomy')
                .find('.show-tags')
                .append(response.data.html);

            taxForm.find('.taxonomy-name').val('');
            if (parent) {
                taxForm.find('.taxonomy-parent').val(null)
                    .trigger('change.select2');
            }

            return false;
        }).fail(function(response) {
            btn.find('i').attr('class', icon);
            btn.prop("disabled", false);

            show_message(response);
            return false;
        });
    });
});
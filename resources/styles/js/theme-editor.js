$(document).on("turbolinks:load", function() {
    $('.load-media').filemanager('image', {prefix: '/admin-cp/filemanager'});

    $("#theme-editor-sidebar").on('click', '.add-card-item', function () {
        let item = $(this);
        let card = item.closest('.theme-editor__card');
        let template = card.find('.card-add-template').html().toString();
        let add_list = item.closest('.theme-editor__card').find('.card-add-list');
        let length = card.find('.editor-item').length;
        let add_html = replace_template(template, {
            'next_index': ((length / 2) + 1),
        });

        add_list.append(add_html);
    });

    $("#theme-editor-sidebar").on('click', '.remove-editor-item', function () {
        $(this).closest('.theme-setting').remove();
    });

    $("#theme-editor-sidebar").on('click', '.show-card-body', function () {
        let body = $(this).closest('.theme-editor__card').find('.card-body');
        if (body.is(':hidden')) {
            body.show('slow');
            $(this).html('<i class="fa fa-eye-slash"></i> '+ langs.hide);
        }
        else {
            body.hide('slow');
            $(this).html('<i class="fa fa-eye"></i> '+ langs.show);
        }
    });

    $(".check-status").on('change', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.next-input-wrapper').find('.check-status-hide').val(1);
        }
        else {
            $(this).closest('.next-input-wrapper').find('.check-status-hide').val(0);
        }
    });

    $(".product-detail-tab").on('change', function () {
        if ($(this).val() == 'custom') {
            $($(this).data('custom-text')).show('slow');
        }
        else {
            $($(this).data('custom-text')).hide('slow');
        }
    });

    $(".form-product-list").on('change', '.select-ctype', function () {
        let ctype = $(this).val();
        if (parseInt(ctype) > 0) {
            $(this).closest('.form-product-list').find('.ctype').hide('slow');
            $(this).closest('.form-product-list').find('.ctype-'+ ctype).show('slow');
        }
    });
});
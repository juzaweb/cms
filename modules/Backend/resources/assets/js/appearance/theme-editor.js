$(document).ready(function () {
    $('.load-media').filemanager('image', {prefix: '/'+ juzaweb.adminPrefix +'/file-manager'});

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
});

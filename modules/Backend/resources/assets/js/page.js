$(document).ready(function () {
    let urlParams = new URLSearchParams(window.location.search);
    let template = urlParams.get('template');
    let bodyElement = $('body');

    if (template) {
        $('select[name="meta[template]"]').val(template).trigger('change');
    }

    bodyElement.on('click', '.show-form-block', function () {
        let form = $(this).closest('.dd-item').find('.form-block-edit');
        if (form.is(':hidden')) {
            form.show('slow');
        } else {
            form.hide('slow');
        }
    });

    bodyElement.on('click', '.remove-form-block', function () {
        $(this).closest('.dd-item').remove();
    });

    bodyElement.on('change', 'select[name="meta[template]"]', function () {
        let template = $(this).val();
        if (!template) {
            return false;
        }

        let currentUrl = window.location.href;
        currentUrl = currentUrl.split("?")[0];
        window.location = currentUrl + '?template=' + template;
    });

    bodyElement.on('click', '.add-block-data', function () {
        let block = $(this).data('block');
        let contentKey = $(this).data('content_key');
        let item = $(this);
        let template = document.getElementById('block-'+ block + '-template').innerHTML;
        let marker = (new Date()).getTime();
        template = replace_template(template, {
            'marker': marker,
            'content_key': contentKey,
        });

        item.closest('.page-block-content').find('.dd-empty').remove();
        item.closest('.page-block-content').find('.dd-list').append(template);

        initSelect2('#page-block-' + marker);
    });
});

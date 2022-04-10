$(document).on("turbolinks:load", function() {
    
    let urlParams = new URLSearchParams(window.location.search);
    let template = urlParams.get('template');
    
    if (template) {
        $('select[name="meta[template]"]').val(template).trigger('change');
    }
    
    $('body').on('click', '.show-form-block', function () {
        let form = $(this).closest('.dd-item').find('.form-block-edit');
        if (form.is(':hidden')) {
            form.show('slow');
        } else {
            form.hide('slow');
        }
    });
    
    $('body').on('click', '.remove-form-block', function () {
        $(this).closest('.dd-item').remove();
    });
    
    $('body').on('change', 'select[name="meta[template]"]', function () {
        let template = $(this).val();
        if (!template) {
            return false;
        }
        
        let currentUrl = window.location.href;
        currentUrl = currentUrl.split("?")[0];
        
        Turbolinks.visit(currentUrl + '?template=' + template, {action: "replace"});
    });

    $('body').on('click', '.add-block-data', function () {
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
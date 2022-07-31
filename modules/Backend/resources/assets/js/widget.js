$(document).ready(function () {
    $('.jw-widget-builder').nestable({
        noDragClass: 'dd-nodrag',
        maxDepth: 1,
    });

    $('#widget-container').on('click', '.dropdown-action', function () {
        let blocks = $(this).closest('.widget-block').find('.sidebar-blocks');
        if (blocks.is(':hidden')) {
            blocks.show();
        } else {
            blocks.hide();
        }
    });

    $('#widget-container').on('submit', '.form-add-widget', function () {
        let form = $(this).serialize();
        let btn = $(this).find('button[type=submit]');
        let icon = btn.find('i').attr('class');

        btn.find('i').attr('class', 'fa fa-spinner fa-spin');
        btn.prop("disabled", true);

        ajaxRequest(juzaweb.adminUrl + '/widgets/get-item', form, {
            method: 'GET',
            callback: function(response) {
                let items = response.items || [];
                $.each(items, function (key, item) {
                    $('#sidebar-' + key + ' .jw-widget-builder .dd-empty').remove();
                    $('#sidebar-' + key + ' .dd-list').append(item.html);
                });

                $.each(items, function (key, item) {
                    initSelect2('#dd-item-' + item.key);
                });

                btn.find('i').attr('class', icon);
                btn.prop("disabled", false);
            },
            failCallback: function () {
                show_message(response);
                btn.find('i').attr('class', icon);
                btn.prop("disabled", false);
            }
        });

        return false;
    });

    $('#widget-container').on(
        'click',
        '.widget-sidebar-item',
        function () {
            let item = $(this);
            let isChecked = item.find('input').is(':checked');
            let form = item.closest('.form-add-widget');
            let btn = form.find('button[type=submit]');

            if (isChecked) {
                item.find('span').html('');
                item.find('input').prop('checked', false);
            } else {
                item.find('span').html(`<i class="fa fa-check"></i>`);
                item.find('input').prop('checked', true);
            }

            if (form.find('.widget-sidebar-item input:checked').length > 0) {
                btn.prop('disabled', false);
            } else {
                btn.prop('disabled', true);
            }
        }
    );

    $('#widget-container').on('click', '.show-edit-form', function () {
        let item = $(this);
        let form = item.closest('.sidebar-item').find('.card-body');
        if (form.is(':hidden')) {
            form.show();
        } else {
            form.hide();
        }
    });

    $('#widget-container').on('click', '.show-item-form', function () {
        let editForm = $(this).closest('.dd-item').find('.form-item-edit');
        if (editForm.is(':hidden')) {
            editForm.show();
        } else {
            editForm.hide();
        }
    });

    $('#widget-container').on(
        'click',
        '.delete-item-form',
        function () {
            $(this).closest('.dd-item').remove();
        }
    );
});

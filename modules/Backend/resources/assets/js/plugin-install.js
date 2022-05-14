$(document).on("turbolinks:load", function() {
    let bodyElement = $('body');
    bodyElement.on('click', '.install-plugin', function () {
        let plugin = $(this).data('plugin');
        let btn = $(this);
        btn.prop("disabled", true);

        ajaxRequest(juzaweb.adminUrl + '/plugins/bulk-actions', {
            ids: [plugin],
            action: 'update',
        }, {
            method: 'POST',
            callback: function (response) {
                show_message(response);
                btn.html(`<i class="fa fa-check"></i> ${juzaweb.lang.activate}`);
                btn.removeClass('install-plugin');
                btn.addClass('active-plugin');
                btn.prop("disabled", false);
            },
            failCallback: function(response) {
                show_message(response);
                btn.prop("disabled", false);
            }
        });
    });

    bodyElement.on('click', '.active-plugin', function () {
        let plugin = $(this).data('plugin');
        let btn = $(this);
        btn.prop("disabled", true);

        ajaxRequest(juzaweb.adminUrl + '/plugins/bulk-actions', {
            ids: [plugin],
            action: 'activate',
        }, {
            method: 'POST',
            callback: function (response) {
                show_message(response);
                btn.html(`<i class="fa fa-check"></i> ${juzaweb.lang.activated}`);
                btn.removeClass('active-plugin');
                btn.prop("disabled", true);
            },
            failCallback: function(response) {
                show_message(response);
                btn.prop("disabled", false);
            }
        });
    });
});

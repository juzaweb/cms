$(document).ready(function () {
    let bodyElement = $('body');
    bodyElement.on('click', '.install-plugin', function () {
        let plugin = $(this).data('plugin');
        let btn = $(this);
        let btnText = btn.html();
        btn.prop("disabled", true);
        btn.html('<i class="fa fa-spinner fa-spin"></i> ' + juzaweb.lang.please_wait);

        jwCMSUpdate(
            'plugin',
            1,
            null,
            {plugin: plugin},
            function (response) {
                btn.html(juzaweb.lang.activate);
                btn.removeClass('install-plugin');
                btn.addClass('active-plugin');
                btn.prop("disabled", false);
            },
            function(response) {
                show_message(response);
                btn.prop("disabled", false);
                btn.html(btnText);
            }
        );
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

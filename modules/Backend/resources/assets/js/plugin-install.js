$(document).on("turbolinks:load", function() {
    $('body').on('click', '.install-plugin', function () {
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
                btn.prop("disabled", false);
            }
        });
    });

    $('body').on('click', '.active-plugin', function () {
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
            },
            failCallback: function(response) {
                show_message(response);
                btn.prop("disabled", false);
            }
        });
    });

    $('body').on('click', '.install-theme', function () {
        let theme = $(this).data('theme');
        let btn = $(this);
        btn.prop("disabled", true);

        ajaxRequest(juzaweb.adminUrl + '/themes/update', {
            theme: theme
        }, {
            method: 'POST',
            callback: function (response) {
                show_message(response);
                btn.html(`${juzaweb.lang.installed}`);
                btn.removeClass('install-theme');
                //btn.addClass('active-theme');
                //btn.prop("disabled", false);
            },
            failCallback: function(response) {
                show_message(response);
                btn.prop("disabled", false);
            }
        });
    });
});

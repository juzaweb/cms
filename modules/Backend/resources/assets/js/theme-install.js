$(document).on("turbolinks:load", function() {
    let bodyElement = $('body');

    bodyElement.on('click', '.update-theme', function () {
        let theme = $(this).data('theme');
        let btn = $(this);
        let btnText = btn.html();
        btn.prop("disabled", true);
        btn.html('<i class="fa fa-spinner fa-spin"></i> ' + juzaweb.lang.please_wait);

        jwCMSUpdate(
            'theme',
            1,
            null,
            {theme: theme},
            function (response) {
                btn.remove();
                show_message(response);
            },
            function (response) {
                btn.prop("disabled", false);
                btn.html(btnText);
                show_message(response);
            }
        );
    });

    bodyElement.on('click', '.install-theme', function () {
        let theme = $(this).data('theme');
        let btn = $(this);
        let btnText = btn.html();
        btn.prop("disabled", true);
        btn.html('<i class="fa fa-spinner fa-spin"></i> ' + juzaweb.lang.please_wait);

        jwCMSUpdate(
            'theme',
            1,
            null,
            {theme: theme},
            function (response) {
                btn.html(juzaweb.lang.activate);
                btn.removeClass('install-theme');
                btn.addClass('active-theme');
                btn.prop("disabled", false);
            },
            function(response) {
                show_message(response);
                btn.prop("disabled", false);
                btn.html(btnText);
            }
        );
    });

    bodyElement.on('click', '.active-theme', function () {
        let theme = $(this).data('theme');
        let btn = $(this);
        btn.prop("disabled", true);

        ajaxRequest(juzaweb.adminUrl + '/themes/activate', {
            theme: theme
        }, {
            method: 'POST',
            callback: function (response) {
                show_message(response);
                btn.html(`<i class="fa fa-check"></i> ${juzaweb.lang.activated}`);
                btn.removeClass('active-theme');
                btn.prop("disabled", true);
            },
            failCallback: function(response) {
                show_message(response);
                btn.prop("disabled", false);
            }
        });
    });

    bodyElement.on('click', '.delete-theme', function () {
        let theme = $(this).data('theme');
        let btn = $(this);
        let btnText = btn.html();

        confirm_message(
            juzaweb.lang.delete_theme_confirm,
            function (result) {
                if (!result) {
                    return false;
                }

                btn.html('<i class="fa fa-spinner fa-spin"></i> ' + juzaweb.lang.please_wait);

                ajaxRequest(juzaweb.adminUrl + '/themes/bulk-actions', {
                    ids: [theme],
                    action: 'delete'
                }, {
                    method: 'POST',
                    callback: function (response) {
                        show_message(response);
                        if (response.status == true) {
                            btn.closest('.theme-list-item').remove();
                        }
                    },
                    failCallback: function(response) {
                        show_message(response);
                        btn.html(btnText);
                    }
                });
        });
    });
});

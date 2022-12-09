$(document).ready(function () {
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

    bodyElement.on('click', '.buy-theme', function () {
        let btn = $(this);
        let module = btn.data('theme');
        let btnText = btn.html();

        btn.prop('disabled', true);
        btn.html('<i class="fa fa-spinner fa-spin"></i>');

        ajaxRequest(
            juzaweb.adminUrl+'/module/theme/buy-modal',
            {
                module: module
            },
            {
                method: 'GET',
                callback: function (response) {
                    $('#show-modal').empty().html(response.data.html);
                    $('#show-modal .modal').modal();

                    btn.html(btnText);
                    btn.prop('disabled', false);
                },
                failCallback: function (response) {
                    show_message(response);

                    btn.html(btnText);
                    btn.prop('disabled', false);
                }
            }
        );
    });

    bodyElement.on('submit', '#form-activation-code, #form-select-key', function (event) {
        if (event.isDefaultPrevented()) {
            return false;
        }

        event.preventDefault();

        let form = $(this);
        let btn = form.find('button[type=submit]');
        let module = form.find('input[name=module]').val();
        let key = form.find('[name=key]').val();
        let btnText = btn.html();

        if (!key) {
            return false;
        }

        btn.prop('disabled', true);
        btn.html('<i class="fa fa-spinner fa-spin"></i> '+ juzaweb.lang.please_wait);

        ajaxRequest(
            juzaweb.adminUrl+'/module/theme/activation-code',
            {
                module: module,
                key: key
            },
            {
                method: 'POST',
                callback: function (response) {
                    if (response.status !== true) {
                        show_message(response);
                        btn.html(btnText);
                        btn.prop('disabled', false);
                        return false;
                    }

                    form.find('input[name=key]').closest('.form-group').hide();
                    btn.html('<i class="fa fa-spinner fa-spin"></i> '+ juzaweb.lang.installing);

                    jwCMSUpdate(
                        'theme',
                        1,
                        null,
                        {theme: module},
                        function (response) {
                            btn.html(juzaweb.lang.activate);
                            btn.removeClass('install-theme');
                            btn.addClass('active-theme');
                            btn.data('theme', module);
                            btn.prop("disabled", false);
                        },
                        function(response) {
                            show_message(response);
                            btn.prop("disabled", false);
                            btn.html(btnText);
                        }
                    );

                    return false;
                },
                failCallback: function (response) {
                    show_message(response);

                    btn.html(btnText);
                    btn.prop('disabled', false);
                    return false;
                }
            }
        );

        return false;
    });

    bodyElement.on('submit', '#form-login-juzaweb', function (event) {
        if (event.isDefaultPrevented()) {
            return false;
        }

        event.preventDefault();

        let form = $(this);
        let btn = form.find('button[type=submit]');
        let module = form.find('input[name=module]').val();
        let email = form.find('input[name=email]').val();
        let password = form.find('input[name=password]').val();
        let btnText = btn.html();

        if (!email || !password) {
            return false;
        }

        btn.prop('disabled', true);
        btn.html('<i class="fa fa-spinner fa-spin"></i> '+ juzaweb.lang.please_wait);

        ajaxRequest(
            juzaweb.adminUrl+'/module/login-juzaweb',
            {
                module: module,
                email: email,
                password: password
            },
            {
                method: 'POST',
                callback: function (response) {
                    if (response.status !== true) {
                        show_message(response);
                        btn.html(btnText);
                        btn.prop('disabled', false);
                        return false;
                    }

                    ajaxRequest(
                        juzaweb.adminUrl+'/module/theme/buy-modal',
                        {
                            module: module
                        },
                        {
                            method: 'GET',
                            callback: function (response) {
                                $('#show-modal .modal').modal('hide');
                                $('#show-modal').empty().html(response.data.html);
                                $('#show-modal .modal').modal();
                            },
                            failCallback: function (response) {
                                show_message(response);

                                btn.html(btnText);
                                btn.prop('disabled', false);
                            }
                        }
                    );

                    return false;
                },
                failCallback: function (response) {
                    show_message(response);

                    btn.html(btnText);
                    btn.prop('disabled', false);
                    return false;
                }
            }
        );

        return false;
    });
});

/*
 * JUZAWEB CMS 1.0 - Form Ajax support
 *
 *
 * Copyright JS Foundation and other contributors
 * Released under the MIT license
 *
 * Date: 2021-03-12T21:04Z
 */

$(document).on("turbolinks:load", function() {
    $('body').on('submit', '.form-ajax', function(event) {
        if (event.isDefaultPrevented()) {
            return false;
        }

        event.preventDefault();

        var form = $(this);
        var formData = new FormData(form[0]);
        var btnsubmit = form.find("button[type=submit]");
        var currentIcon = btnsubmit.find('i').attr('class');
        var currentText = btnsubmit.html();
        var submitSuccess = form.data('success');

        btnsubmit.find('i').attr('class', 'fa fa-spinner fa-spin');
        btnsubmit.prop("disabled", true);

        if (btnsubmit.data('loading-text')) {
            btnsubmit.html('<i class="fa fa-spinner fa-spin"></i> ' + btnsubmit.data('loading-text'));
        }

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            dataType: 'json',
            data: formData,
            cache:false,
            contentType: false,
            processData: false
        }).done(function(response) {

            show_message(response);

            if (submitSuccess) {
                eval(submitSuccess)(form, response);
            }

            if (response.data.redirect) {
                setTimeout(function () {
                    Turbolinks.visit(response.data.redirect, {action: "replace"});
                }, 1000);
                return false;
            }

            btnsubmit.find('i').attr('class', currentIcon);
            btnsubmit.prop("disabled", false);

            if (btnsubmit.data('loading-text')) {
                btnsubmit.html(currentText);
            }

            if (response.status === false) {
                return false;
            }

            return false;
        }).fail(function(response) {
            btnsubmit.find('i').attr('class', currentIcon);
            btnsubmit.prop("disabled", false);

            if (btnsubmit.data('loading-text')) {
                btnsubmit.html(currentText);
            }

            show_message(response);
            return false;
        });
    });

    $('body').on('click', '.load-modal', function(event) {
        if (event.isDefaultPrevented()) {
            return false;
        }

        event.preventDefault();
        let data = $(this).data();
        let btnsubmit = $(this);
        let currentIcon = btnsubmit.find('i').attr('class');

        btnsubmit.find('i').attr('class', 'fa fa-spinner fa-spin');
        btnsubmit.prop("disabled", true);
        btnsubmit.addClass("disabled");

        let query_str = '';
        $.each(data, function (index, item) {
            if (index !== 'url') {
                query_str += '&'+index+'='+item;
            }
        });

        let url = $(this).data('url');

        if (query_str) {
            url = url + "?"+query_str;
        }

        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            data: {},
            cache:false,
            contentType: false,
            processData: false
        }).done(function(response) {

            btnsubmit.find('i').attr('class', currentIcon);
            btnsubmit.prop("disabled", false);
            btnsubmit.removeClass("disabled");

            if (response.status === false) {
                return false;
            }

            $('#show-modal').html(response.data.source);
            $('#show-modal .modal').modal();

            return false;
        }).fail(function(response) {
            btnsubmit.find('i').attr('class', currentIcon);
            btnsubmit.prop("disabled", false);

            /*show_message(response);*/
            return false;
        });
    });

    $("body").on('keypress', '.is-number', function () {
        return validate_isNumberKey(this);
    });

    $("body").on('keyup', '.number-format', function () {
        return validate_FormatNumber(this);
    });

    function validate_isNumberKey(evt) {
        let charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode == 59 || charCode == 46)
            return true;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function validate_FormatNumber(a) {
        a.value = a.value.replace(/\,/gi, "");
        a.value = a.value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    }
});
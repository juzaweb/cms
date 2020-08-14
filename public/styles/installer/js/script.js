$(document).ready(function () {
    var tab = 1;
    $('.next-button').on('click', function () {
        tab = tab + 1;
        $('.tabs').hide('slow');
        $('.tab-title').html($('.tab-'+ tab + ' .tab-name').text());
        $('.tab-'+ tab).show('slow');

        if (tab > 1) {
            $('.back-button').prop('disabled', false);
        }
        else {
            $('.back-button').prop('disabled', true);
        }

        if (tab == 4) {
            $('.next-button').hide('slow');
            $('.submit-button').show('slow');
        }
    });

    $('.back-button').on('click', function () {
        tab = tab - 1;
        $('.tabs').hide('slow');
        $('.tab-title').html($('.tab-'+ tab + ' .tab-name').text());
        $('.tab-'+ tab).show('slow');

        if (tab < 4) {
            $('.submit-button').hide('slow');
            $('.next-button').show('slow');
        }
    });

    $(document).on('submit', '.form-ajax', function(event) {
        if (event.isDefaultPrevented()) {
            return false;
        }

        event.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
        var btnsubmit = form.find("button[type=submit]");
        var currentIcon = btnsubmit.find('i').attr('class');
        var submitSuccess = form.data('success');
        btnsubmit.find('i').attr('class', 'fa fa-spinner fa-spin');
        btnsubmit.prop("disabled", true);

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(data) {

            Swal.fire(
                data.status.toUpperCase(),
                data.message,
                data.status
            );

            if (data.redirect) {
                window.location = data.redirect;
                return false;
            }

            btnsubmit.find('i').attr('class', currentIcon);
            btnsubmit.prop("disabled", false);

            if (data.status === "error") {
                return false;
            }

            if (submitSuccess) {
                eval(submitSuccess)();
            }

            return false;
        }).fail(function() {
            btnsubmit.find('i').attr('class', currentIcon);
            btnsubmit.prop("disabled", false);

            Swal.fire(
                '',
                'Data error',
                'error'
            );
            return false;
        });
    });

    function install_submit_success() {
        $('.tabs').hide('slow');
        $('.tab-title').html($('.tab-5 .tab-name').text());
        $('.tab-5').show('slow');
        install_step(1);
    }

    function install_step(step) {
        var form = $('.form-ajax');
        var formData = new FormData(form[0]);

        $.ajax({
            type: "POST",
            url: "/install/step/" + step,
            dataType: 'json',
            data: formData,
            success: function (result) {
                $('.step-status').append('<li class="list-group-item success">'+ result.flash +'<span><i class="fa fa-fw fa-check-circle-o row-icon" aria-hidden="true"></i></span></li>');
                if (result.next_step) {
                    install_step(result.next_step);
                }

                if (result.redirect) {
                    window.location = result.redirect;
                    return false;
                }
            }
        });
    }
});
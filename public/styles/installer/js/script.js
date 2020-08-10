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
});
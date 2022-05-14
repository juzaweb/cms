function jwUpdateProcess(
    processElement,
    message = null,
    percent = 0,
    status = 'primary'
) {
    if (message) {
        $(processElement + ' .process-text').append(`<li class="text-${status}">${message}</li>`);
    }

    if (percent) {
        $(processElement + ' .progress-bar')
            .attr('aria-valuenow', percent)
            .text(percent + '%')
            .css('width', percent + '%');
    }
}

function jwCMSUpdate(
    type,
    step,
    processElement = null,
    params = {},
    successCallback = null,
    failCallback = null
) {
    let cmsUpdateUrl = juzaweb.adminUrl + '/update/'+type+'/__STEP__';

    if (processElement) {
        jwUpdateProcess(
            processElement,
            juzaweb.lang.update_process['step'+step].before
        )
    }

    ajaxRequest(cmsUpdateUrl.replace('__STEP__', step), params, {
        method: 'POST',
        callback: function (response) {
            if(response.status == false) {
                if (failCallback) {
                    failCallback(response);
                }

                if (processElement) {
                    jwUpdateProcess(
                        processElement,
                        response.data.message,
                        0,
                        'error'
                    );
                }
                return false;
            }

            if(response.data.next_url) {
                if (processElement) {
                    jwUpdateProcess(processElement, null, step * 17);
                }

                jwCMSUpdate(type, step+1, processElement, params);
            } else {
                if (successCallback) {
                    successCallback(response);
                }

                if (processElement) {
                    jwUpdateProcess(
                        processElement,
                        juzaweb.lang.update_process.done,
                        100
                    );
                }
            }
        },
        failCallback: function (response) {
            let message = response.message || 'Server Error';
            if (failCallback) {
                failCallback(response);
            }

            if (processElement) {
                jwUpdateProcess(
                    processElement,
                    message,
                    step * 15,
                    'error'
                );
            }
        }
    })
}

$(document).on("turbolinks:load", function() {
    $('body').on('click', '.update-theme', function () {
        let theme = $(this).data('theme');
        let btn = $(this);
        let btnText = btn.html();
        btn.prop("disabled", true);
        btn.html('<i class="fa fa-spinner fa-spin"></i> ' + juzaweb.lang.please_wait);

        jwCMSUpdate(
            'theme',
            1,
            null,
            {themes: [theme]},
            function (response) {
                btn.prop("disabled", false);
                btn.html(btnText);
                show_message(response);
            },
            function (response) {
                btn.prop("disabled", false);
                btn.html(btnText);
                show_message(response);
            }
        );
    });
});

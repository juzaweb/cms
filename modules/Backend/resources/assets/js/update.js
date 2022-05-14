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
        $(processElement + ' .progress-bar').text(percent + '%').css('width', percent + '%');
    }
}

function jwCMSUpdate(type, step, processElement = null, params = [])
{
    let cmsUpdateUrl = juzaweb.adminUrl + '/update/'+type+'/__STEP__';

    if (processElement) {
        jwUpdateProcess(
            processElement,
            juzaweb.lang.update_process['step'+step].before
        )
    }

    ajaxRequest(cmsUpdateUrl.replace('__STEP__', step), {}, {
        method: 'POST',
        callback: function (response) {
            if(response.status == false) {
                jwUpdateProcess(
                    processElement,
                    response.data.message,
                    0,
                    'error'
                );
                return false;
            }

            if(response.data.next_url) {
                if (processElement) {
                    jwUpdateProcess(processElement, null, step * 17);
                }

                jwCMSUpdate(type, step+1, processElement, params);
            } else {
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

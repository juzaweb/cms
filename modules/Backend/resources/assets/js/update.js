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
                        'danger'
                    );
                }
                return false;
            }

            if(response.data.next_url) {
                if (processElement) {
                    jwUpdateProcess(processElement, null, step * 17);
                }

                jwCMSUpdate(
                    type,
                    step+1,
                    processElement,
                    params,
                    successCallback,
                    failCallback
                );
            } else {
                if (successCallback) {
                    successCallback(response);
                }

                if (processElement) {
                    jwUpdateProcess(
                        processElement,
                        juzaweb.lang.update_process.done,
                        100,
                        'success'
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
                    'danger'
                );
            }
        }
    })
}

function recursiveUpdate(
    type,
    items,
    updateIndex = 0,
    successCallback = null,
    failCallback = null
) {
    let params = {};
    if (type == 'theme') {
        params = {theme: items[updateIndex]};
    } else {
        params = {plugin: items[updateIndex]};
    }

    jwCMSUpdate(
        type,
        1,
        '#'+type+'-'+ items[updateIndex].replace('/', '_') +'-update-process',
        params,
        function (response) {
            if (items[updateIndex+1]) {
                recursiveUpdate(type, items, updateIndex + 1, successCallback, failCallback);
            } else {
                if (successCallback) {
                    successCallback(response);
                }
            }
        },
        function (response) {
            if (failCallback) {
                failCallback(response);
            }

            if (items[updateIndex+1]) {
                recursiveUpdate(type, items, updateIndex + 1, successCallback, failCallback);
            }
        }
    );
}

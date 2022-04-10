toastr.options.timeOut = 3000;

function toastr_message(message, status, title = null) {
    if (status == true) {
        toastr.success(message, title || juzaweb.lang.successfully + ' !!');
    } else {
        toastr.error(message, title || juzaweb.lang.error + ' !!');
    }
}

function confirm_message(question, callback) {
    Swal.fire({
        title: '',
        text: question,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: juzaweb.lang.yes + '!',
        cancelButtonText: juzaweb.lang.cancel + '!',
    }).then((result) => {
        callback(result.value);
    });
}

function show_message(response) {
    // Show response message
    if (response.data) {
        if (response.data.message) {
            toastr_message(response.data.message, response.status);
        }
        return false;
    }

    // Show message validate
    if (response.responseJSON) {
        if (response.responseJSON.errors) {
            $.each(response.responseJSON.errors, function (index, msg) {
                toastr_message(msg[0], false);
                return false;
            });
        }

        else if (response.responseJSON.message) {
            toastr_message(response.responseJSON.message, false);
            return false;
        }
    }

    // Show message errors
    if (response.message) {
        toastr_message(response.message.message, false);
    }
}
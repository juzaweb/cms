

function jwCMSUpdate()
{
    ajaxRequest("", {}, {
        method: 'POST',
        callback: function (response) {
            $('#update-form').html(response.html);
        }
    })
}

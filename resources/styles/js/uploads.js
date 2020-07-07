$(document).on("turbolinks:load", function() {

    var r = new Resumable({
        target: '/admin/movies/servers/upload',
        maxFiles: 1,
    });

    if (!r.support) {
        alert('Resumable not support !');
    }

    r.assignBrowse(document.getElementById('browseButton'));
    r.assignDrop(document.getElementById('dropTarget'));

    r.on('fileAdded', function (file, event) {

    });

    r.on('fileSuccess', function (file, message) {

    });

    r.on('fileError', function (file, message) {

    });

});
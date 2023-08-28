let juzawebFileManager = function (options, cb) {
    let type = options.type || 'image';
    let disk = options.disk || null;
    let routePrefix = options.prefix;
    let multichoose = options.multichoose || false;

    if (routePrefix[0] !== '/') {
        routePrefix = '/' + routePrefix;
    }

    let dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
    let w = options.width ? options.width : 800;
    let h = options.height ? options.height : 500;
    let dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;
    let width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    let height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
    let systemZoom = width / window.screen.availWidth;
    let left = (width - w) / 2 / systemZoom + dualScreenLeft;
    let top = (height - h) / 2 / systemZoom + dualScreenTop;

    window.open(routePrefix + '?type=' + type + (multichoose ? '&multichoose=1' : '') + (disk ? '&disk=' + disk : ''), 'File Manager', 'scrollbars=yes, width=' + w / systemZoom + ', height=' + h / systemZoom + ', top=' + top + ', left=' + left);
    window.SetUrl = cb;
};

$.fn.filemanager = function(type, options) {
    let element = this;
    let prefix = juzaweb.adminPrefix + '/file-manager';
    this.on('click', function(e) {
        juzawebFileManager({
            type: type,
            prefix: prefix
        }, function (files) {
            let file = files[0];

            if (element.data('input')) {
                let targetInput = $('#' + element.data('input'));
                targetInput.val(file.path);
            }

            if (element.data('preview')) {
                let targetPreview = $('#' + element.data('preview'));
                targetPreview.html('<img src="'+ file.url +'" alt="'+ file.name +'">');
            }

            if (element.data('name')) {
                let targetName = $('#' + element.data('name'));
                targetName.html(file.name);
            }
        });
    });
};

$(function () {
    const bodyElement = $('body');

    bodyElement.on('click', '.file-manager', function () {
        let type = $(this).data('type') || 'image';
        let input = $(this).data('input');
        let preview = $(this).data('preview');
        let name = $(this).data('name');
        let prefix = juzaweb.adminPrefix + '/file-manager';
        let disk = $(this).data('disk');

        juzawebFileManager({
            type: type,
            prefix: prefix,
            disk: disk
        }, function (files) {
            let file = files[0];

            if (input) {
                let targetInput = $('#' + input);
                targetInput.val(file.path);
            }

            if (preview) {
                let targetPreview = $('#' + preview);
                targetPreview.html('<img src="'+ file.url +'" alt="">');
            }

            if (name) {
                let targetName = $('#' + name);
                targetName.html(file.name);
            }
        });
    });

    bodyElement.on('click', '.form-image', function () {
        let item = $(this);
        let targetInput = item.find('.input-path');
        let targetPreview = item.find('.dropify-render');
        let targetName = item.find('.dropify-filename-inner');
        let prefix = juzaweb.adminPrefix + '/file-manager';

        juzawebFileManager({
            type: 'image',
            prefix: prefix
        }, function (files) {
            let file = files[0];
            targetInput.val(file.path);
            targetPreview.html('<img src="'+ file.url +'" alt="">');
            targetName.html(file.name);
            item.addClass('previewing');
            item.find('.image-hidden').show();
        });
    });

    bodyElement.on('click', '.form-image .image-clear', function (e) {
        e.stopPropagation();
        let item = $(this).closest('.form-image');
        let targetInput = item.find('.input-path');
        let targetPreview = item.find('.dropify-render');
        let targetName = item.find('.dropify-filename-inner');
        targetInput.val("");
        targetPreview.html('');
        targetName.html("");
        item.removeClass('previewing');
        item.find('.image-hidden').hide();
    });

    bodyElement.on('click', '.add-image-images', function () {
        let prefix = juzaweb.adminPrefix + '/file-manager';
        let item = $(this).closest('.form-images');
        let inputName = item.find('.input-name').val();

        juzawebFileManager({
            type: 'image',
            prefix: prefix,
            multichoose: true
        }, function (files) {
            let temp = document.getElementById('form-images-template').innerHTML;
            let str = "";

            $.each(files, function (index, item) {
                str += replace_template(temp, {
                    name: inputName,
                    url: item.url,
                    path: item.path
                });
            });

            item.find('.images-list .image-item:last').before(str);
        });
    });

    bodyElement.on('click', '.form-images .remove-image-item', function () {
        $(this).closest('.image-item').remove();
    });
});

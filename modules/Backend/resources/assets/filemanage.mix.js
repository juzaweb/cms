const mix = require('laravel-mix');
const baseAsset = 'modules/Backend/resources/assets';
const basePublish = baseAsset + '/public';

mix.styles(
    [
        baseAsset + '/plugins/bootstrap/css/bootstrap.min.css',
        baseAsset + '/plugins/font-awesome/css/font-awesome.min.css',
        baseAsset + '/css/mime-icons.min.css',
        baseAsset + '/plugins/cropper/css/cropper.min.css',
        baseAsset + '/plugins/dropzone/css/dropzone.css',
        baseAsset + '/css/lfm.css',
    ],
    basePublish + '/css/filemanager.min.css'
);

mix.combine(
    [
        baseAsset + '/plugins/jquery/js/jquery.min.js',
        baseAsset + '/plugins/popper/umd/popper.js',
        baseAsset + '/plugins/bootstrap/js/bootstrap.js',
        baseAsset + '/plugins/jquery-ui/jquery-ui.min.js',
        baseAsset + '/plugins/cropper/js/cropper.min.js',
        baseAsset + '/plugins/dropzone/js/dropzone.js',
        baseAsset + '/js/lfm.js',
    ],
    basePublish + '/js/filemanager.min.js'
);

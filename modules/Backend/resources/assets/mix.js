const mix = require('laravel-mix');

const baseAsset = 'modules/Backend/resources/assets';
const basePublish = baseAsset + '/public';

mix.styles(
    [
        baseAsset + '/css/widget.css',
        baseAsset + '/css/media.css',
        baseAsset + '/css/menu.css',
        baseAsset + '/css/page.css',
        baseAsset + '/css/customs.css',
    ],
    `${basePublish}/css/custom.min.css`
);

mix.combine(
    [
        baseAsset + '/js/load-ajax.js',
        baseAsset + '/js/vendor-support.js',
        baseAsset + '/js/custom-seo.js',
        baseAsset + '/js/filemanager.js',
        baseAsset + '/js/widget.js',
        baseAsset + '/js/media.js',
        baseAsset + '/js/menu.js',
        baseAsset + '/js/update.js',
        baseAsset + '/js/plugin-install.js',
        baseAsset + '/js/theme-install.js',
        baseAsset + '/js/load-select2.js',
        baseAsset + '/js/juzaweb-table.js',
        baseAsset + '/js/list-view.js',
        baseAsset + '/js/form-ajax.js',
        baseAsset + '/js/taxonomy.js',
        baseAsset + '/js/customs.js',
        baseAsset + '/js/setting.js',
        baseAsset + '/js/page.js',
    ],
    `${basePublish}/js/custom.min.js`
);

const mix = require('laravel-mix');

const baseAsset = 'plugins/ecommerce/src/resources/assets';
const basePublish = baseAsset + '/public';

mix.styles(
    [
        baseAsset + '/css/bootstrap.min.css',
        baseAsset + '/css/nprogress.css',
        baseAsset + '/css/select2-min.css',
        baseAsset + '/css/checkout.css',
    ],
    `${basePublish}/css/checkout.min.css`
);

mix.combine(
    [
        baseAsset + '/js/bootstrap.min.js',
        baseAsset + '/js/twine.min.js',
        baseAsset + '/js/validator.min.js',
        baseAsset + '/js/nprogress.js',
        baseAsset + '/js/money-helper.js',
        baseAsset + '/js/select2-full-min.js',
        baseAsset + '/js/ua-parser.pack.js',
        baseAsset + '/js/checkout.js',
    ],
    `${basePublish}/js/checkout.min.js`
);

mix.combine(
    [
            baseAsset + '/js/frontend-support.js',
    ],
    `${basePublish}/js/frontend-support.min.js`
);

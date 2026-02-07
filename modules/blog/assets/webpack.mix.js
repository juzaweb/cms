const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.disableNotifications();
mix.version();

mix.options({
    postCss: [
        require('postcss-discard-comments') ({removeAll: true})
    ],
    terser: {extractComments: false}
});

const baseAsset = path.relative(process.cwd(), __dirname);
const basePublish = baseAsset + '/public';

mix.setPublicPath(basePublish);

mix.styles([
    //
], `${basePublish}/css/main.min.css`);

mix.combine([
    //
], `${basePublish}/js/main.min.js`);

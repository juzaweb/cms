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

mix.setPublicPath(`public/modules/$LOWER_NAME$`);

mix.styles([
    //
], 'public/modules/$LOWER_NAME$/css/main.min.css');

mix.combine([
    //
], 'public/modules/$LOWER_NAME$/js/main.min.js');

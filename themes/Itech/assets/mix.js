let mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.disableNotifications();
mix.version();

mix.options({
    postCss: [
        require('postcss-discard-comments') ({removeAll: true})
    ],
    terser: {extractComments: false}
});

mix.setPublicPath('public/themes/itech');

mix.combine([
    'themes/Itech/assets/js/owlcarousel2.min.js',
    'themes/Itech/assets/js/sticky-sidebar.min.js',
    'themes/Itech/assets/js/jquery-replacetext.min.js',
    'themes/Itech/assets/js/toc.min.js',
], 'public/themes/itech/js/vendor.min.js');

mix.combine(
    [
        'themes/Itech/assets/js/main.js',
        'themes/Itech/assets/js/load-more.js',
        'themes/Itech/assets/js/comments.js',
    ],
    'public/themes/itech/js/main.min.js'
);

mix.styles(
    ['themes/Itech/assets/css/google-fonts.css'],
    'public/themes/itech/css/google-fonts.min.css'
);

mix.styles(
    [
        'themes/Itech/assets/css/main.css',
        'themes/Itech/assets/css/custom.css',
    ],
    'public/themes/itech/css/main.min.css'
);

mix.styles(
    [
        'themes/Itech/assets/css/auth.css',
    ],
    'public/themes/itech/css/auth.min.css'
);

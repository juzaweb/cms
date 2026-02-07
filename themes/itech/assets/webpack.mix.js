let mix = require('laravel-mix');
let path = require('path');

require('laravel-mix-merge-manifest');

mix.disableNotifications();
mix.version();

mix.options({
    postCss: [
        require('postcss-discard-comments') ({removeAll: true})
    ],
    terser: {extractComments: false}
});

const basePath = path.relative(process.cwd(), __dirname);
const publishPath = basePath + '/public';
mix.setPublicPath(publishPath);

mix.combine([
    basePath + '/js/owlcarousel2.min.js',
    basePath + '/js/sticky-sidebar.min.js',
    basePath + '/js/jquery-replacetext.min.js',
    basePath + '/js/toc.min.js',
], publishPath + '/js/vendor.min.js');

mix.combine(
    [
        basePath + '/js/main.js',
        basePath + '/js/load-more.js',
        basePath + '/js/comments.js',
    ],
    publishPath + '/js/main.min.js'
);

mix.styles(
    [basePath + '/css/google-fonts.css'],
    publishPath + '/css/google-fonts.min.css'
);

mix.styles(
    [
        basePath + '/css/main.css',
        basePath + '/css/custom.css',
    ],
    publishPath + '/css/main.min.css'
);

mix.styles(
    [
        basePath + '/css/auth.css',
    ],
    publishPath + '/css/auth.min.css'
);

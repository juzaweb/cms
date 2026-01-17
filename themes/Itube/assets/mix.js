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

mix.setPublicPath(`public/themes/itube`);

mix.styles([
    'themes/Itube/assets/css/all.min.css',
    'themes/Itube/assets/css/hs-mega-menu.min.css',
    'themes/Itube/assets/css/dzsparallaxer.css',
    'themes/Itube/assets/css/cubeportfolio.min.css',
    'themes/Itube/assets/css/aos.css',
    'themes/Itube/assets/css/slick.css',
    'themes/Itube/assets/css/jquery.fancybox.css',
    'themes/Itube/assets/css/select2.min.css',
    'themes/Itube/assets/css/theme.css',
    'modules/Admin/resources/assets/plugins/toastr/toastr.min.css',
    'themes/Itube/assets/css/helpers.css',
], 'public/themes/itube/css/main.min.css');

mix.styles([
    'themes/Itube/assets/css/upload.css',
], 'public/themes/itube/css/upload.min.css');

mix.styles([
    'themes/Itube/assets/css/profile.css',
], 'public/themes/itube/css/profile.min.css');

mix.combine([
    'themes/Itube/assets/js/jquery.min.js',
    'themes/Itube/assets/js/jquery-migrate.min.js',
    'themes/Itube/assets/js/bootstrap.bundle.min.js',
    'themes/Itube/assets/js/hs-header.min.js',
    'themes/Itube/assets/js/hs-go-to.min.js',
    'themes/Itube/assets/js/hs-unfold.min.js',
    'themes/Itube/assets/js/hs-mega-menu.min.js',
    'themes/Itube/assets/js/hs-show-animation.min.js',
    'themes/Itube/assets/js/hs-sticky-block.min.js',
    'themes/Itube/assets/js/hs-counter.min.js',
    'themes/Itube/assets/js/appear.js',
    'themes/Itube/assets/js/jquery.cubeportfolio.min.js',
    'themes/Itube/assets/js/jquery.validate.min.js',
    'themes/Itube/assets/js/dzsparallaxer.js',
    'themes/Itube/assets/js/aos.js',
    'themes/Itube/assets/js/slick.js',
    'themes/Itube/assets/js/jquery.fancybox.min.js',
    'themes/Itube/assets/js/select2.full.min.js',
    'themes/Itube/assets/js/hs.core.js',
    'themes/Itube/assets/js/hs.validation.js',
    'themes/Itube/assets/js/hs.cubeportfolio.js',
    'themes/Itube/assets/js/hs.slick-carousel.js',
    'themes/Itube/assets/js/hs.fancybox.js',
    'themes/Itube/assets/js/hs.select2.js',
    'modules/Admin/resources/assets/plugins/toastr/toastr.min.js',
    'modules/Admin/resources/assets/admin/js/helpers.js',
    'modules/Admin/resources/assets/admin/js/datatable-helper.js',
    'modules/Admin/resources/assets/admin/js/form-ajax.js',
    'themes/Itube/assets/js/infinite-scroll.js',
], 'public/themes/itube/js/main.min.js');

const mix = require('laravel-mix');

mix.styles([
    'themes/gamxo/assets/css/bootstrap.min.css',
    'themes/gamxo/assets/css/all.min.css',
    'themes/gamxo/assets/css/flaticon.css',
    'themes/gamxo/assets/css/animate.min.css',
    'themes/gamxo/assets/css/owl.carousel.min.css',
    'themes/gamxo/assets/css/owl.theme.default.min.css',
    'themes/gamxo/assets/css/magnific-popup.css',
    'themes/gamxo/assets/css/sal.css',
    'themes/gamxo/assets/css/select2.min.css',
    'themes/gamxo/assets/css/nivo-slider.css',
    'themes/gamxo/assets/css/meanmenu.min.css',
    'themes/gamxo/assets/css/app.css'
], 'themes/gamxo/assets/public/css/main.css');

mix.combine([
    'themes/gamxo/assets/js/jquery.min.js',
    'themes/gamxo/assets/js/popper.min.js',
    'themes/gamxo/assets/js/bootstrap.min.js',
    'themes/gamxo/assets/js/jquery.nivo.slider.js',
    'themes/gamxo/assets/js/home.js',
    'themes/gamxo/assets/js/owl.carousel.min.js',
    'themes/gamxo/assets/js/jquery.magnific-popup.min.js',
    'themes/gamxo/assets/js/sal.js',
    'themes/gamxo/assets/js/select2.min.js',
    'themes/gamxo/assets/js/isotope.pkgd.min.js',
    'themes/gamxo/assets/js/imagesloaded.pkgd.min.js',
    'themes/gamxo/assets/js/validator.min.js',
    'themes/gamxo/assets/js/jquery.meanmenu.min.js',
    'themes/gamxo/assets/js/app.js'
], 'themes/gamxo/assets/public/js/main.js');

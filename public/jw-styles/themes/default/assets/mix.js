const mix = require('laravel-mix');

mix.styles([
    'themes/default/assets/css/bootstrap.min.css',
    'themes/default/assets/css/font-awesome.min.css',
    'themes/default/assets/css/style.css',
    'themes/default/assets/css/responsive.css',
    'themes/default/assets/css/colors.css',
    'themes/default/assets/css/version/tech.css',
], 'themes/default/assets/css/main.css');

mix.combine([
    'update/styles/js/app.js',
    'themes/default/assets/js/jquery.min.js',
    'themes/default/assets/js/tether.min.js',
    'themes/default/assets/js/bootstrap.min.js',
    'themes/default/assets/js/custom.js'
], 'themes/default/assets/js/main.js');

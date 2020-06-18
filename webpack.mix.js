const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'resources/styles/vendors/bootstrap/dist/css/bootstrap.css',
    'resources/styles/vendors/perfect-scrollbar/css/perfect-scrollbar.css',
    'resources/styles/vendors/ladda/dist/ladda-themeless.min.css',
    'resources/styles/vendors/bootstrap-select/dist/css/bootstrap-select.min.css',
    'resources/styles/vendors/select2/dist/css/select2.min.css',
    'resources/styles/vendors/tempus-dominus-bs4/build/css/tempusdominus-bootstrap-4.min.css',
    'resources/styles/vendors/fullcalendar/dist/fullcalendar.min.css',
    'resources/styles/vendors/bootstrap-sweetalert/dist/sweetalert.css',
    'resources/styles/vendors/summernote/dist/summernote.css',
    'resources/styles/vendors/owl.carousel/dist/assets/owl.carousel.min.css',
    'resources/styles/vendors/ionrangeslider/css/ion.rangeSlider.css',
    'resources/styles/vendors/c3/c3.min.css',
    'resources/styles/vendors/chartist/dist/chartist.min.css',
    'resources/styles/vendors/nprogress/nprogress.css',
    'resources/styles/vendors/jquery-steps/demo/css/jquery.steps.css',
    'resources/styles/vendors/dropify/dist/css/dropify.min.css',
    'resources/styles/vendors/font-feathericons/dist/feather.css',
    'resources/styles/vendors/font-linearicons/style.css',
    'resources/styles/vendors/font-awesome/css/font-awesome.min.css',
    'resources/styles/vendors/font-icomoon/style.css',
], 'public/css/backend.css');

mix.combine([
    'resources/styles/vendors/jquery/dist/jquery.min.js',
    'resources/styles/vendors/popper.js/dist/umd/popper.js',
    'resources/styles/vendors/jquery-ui/jquery-ui.min.js',
    'resources/styles/vendors/bootstrap/dist/js/bootstrap.js',
    'resources/styles/vendors/jquery-mousewheel/jquery.mousewheel.min.js',
    'resources/styles/vendors/perfect-scrollbar/js/perfect-scrollbar.jquery.js',
    'resources/styles/vendors/spin.js/spin.js',
    'resources/styles/vendors/ladda/dist/ladda.min.js',
    'resources/styles/vendors/bootstrap-select/dist/js/bootstrap-select.min.js',
    'resources/styles/vendors/select2/dist/js/select2.full.min.js',
    'resources/styles/vendors/html5-form-validation/dist/jquery.validation.min.js',
    'resources/styles/vendors/jquery-typeahead/dist/jquery.typeahead.min.js',
    'resources/styles/vendors/jquery-mask-plugin/dist/jquery.mask.min.js',
    'resources/styles/vendors/autosize/dist/autosize.min.js',
    'resources/styles/vendors/bootstrap-show-password/dist/bootstrap-show-password.min.js',
    'resources/styles/vendors/moment/min/moment.min.js',
    'resources/styles/vendors/tempus-dominus-bs4/build/js/tempusdominus-bootstrap-4.min.js',
    'resources/styles/vendors/fullcalendar/dist/fullcalendar.min.js',
    'resources/styles/vendors/bootstrap-sweetalert/dist/sweetalert.min.js',
    'resources/styles/vendors/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js',
    'resources/styles/vendors/summernote/dist/summernote.min.js',
    'resources/styles/vendors/owl.carousel/dist/owl.carousel.min.js',
    'resources/styles/vendors/ionrangeslider/js/ion.rangeSlider.min.js',
    'resources/styles/vendors/d3/d3.min.js',
    'resources/styles/vendors/c3/c3.min.js',
    'resources/styles/vendors/nprogress/nprogress.js',
    'resources/styles/vendors/jquery-steps/build/jquery.steps.min.js',
    'resources/styles/vendors/chart.js/dist/Chart.bundle.min.js',
    'resources/styles/vendors/dropify/dist/js/dropify.min.js',
    'resources/styles/vendors/d3-dsv/dist/d3-dsv.js',
    'resources/styles/vendors/d3-time-format/dist/d3-time-format.js',
    'resources/styles/vendors/techan/dist/techan.min.js',
], 'public/js/backend.js');

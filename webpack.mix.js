const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'resources/styles/vendors/bootstrap/dist/css/bootstrap.css',
    'resources/styles/vendors/bootstrap-select/dist/css/bootstrap-select.min.css',
    'resources/styles/vendors/select2/dist/css/select2.min.css',
    'resources/styles/vendors/tempus-dominus-bs4/build/css/tempusdominus-bootstrap-4.min.css',
    'resources/styles/vendors/font-feathericons/dist/feather.css',
    'resources/styles/vendors/font-linearicons/style.css',
    'resources/styles/vendors/font-awesome/css/font-awesome.min.css',
    'resources/styles/vendors/bootstrap-table/bootstrap-table.min.css',
    'resources/styles/vendors/font-icomoon/style.css',
    'resources/styles/components/kit-vendors/style.css',
    'resources/styles/components/kit-core/style.css',
    'resources/styles/components/cui-styles/style.css',
    'resources/styles/components/kit-widgets/style.css',
    'resources/styles/components/kit-apps/style.css',
    'resources/styles/components/cui-ecommerce/style.css',
    'resources/styles/components/cui-dashboards/style.css',
    'resources/styles/components/cui-system/auth/style.css',
    'resources/styles/components/cui-layout/breadcrumbs/style.css',
    'resources/styles/components/cui-layout/footer/style.css',
    'resources/styles/components/cui-layout/menu-left/style.css',
    'resources/styles/components/cui-layout/menu-top/style.css',
    'resources/styles/components/cui-layout/sidebar/style.css',
    'resources/styles/components/cui-layout/support-chat/style.css',
    'resources/styles/components/cui-layout/topbar/style.css',
    'resources/styles/css/customs.css',
], 'public/css/backend.css');

mix.combine([
    'resources/styles/vendors/jquery/dist/jquery.min.js',
    'resources/styles/vendors/popper.js/dist/umd/popper.js',
    'resources/styles/vendors/jquery-ui/jquery-ui.min.js',
    'resources/styles/vendors/bootstrap/dist/js/bootstrap.js',
    'resources/styles/vendors/select2/dist/js/select2.full.min.js',
    'resources/styles/vendors/jquery-validation/jquery.validate.min.js',
    'resources/styles/vendors/bootstrap-table/bootstrap-table.min.js',
    'resources/styles/vendors/bootstrap-table/LoadBootstrapTable.js',
    'resources/styles/components/cui-layout/menu-left/index.js',
    'resources/styles/components/cui-layout/menu-top/index.js',
    'resources/styles/components/cui-layout/sidebar/index.js',
    'resources/styles/components/cui-layout/support-chat/index.js',
    'resources/styles/components/cui-layout/topbar/index.js',
    'public/vendor/laravel-filemanager/js/stand-alone-button.js',
    'resources/styles/js/lazyload.min.js',
    'resources/js/customs.js',
], 'public/js/backend.js');

mix.styles([
    'resources/styles/frontend/style.css',
    'resources/styles/frontend/assets/css/bootstrap.min.css',
    'resources/styles/frontend/assets/css/style.css'
], 'public/css/frontend.css');

mix.combine([
    'resources/styles/frontend/assets/js/jquery.js',
    'resources/styles/frontend/assets/js/bootstrap.min.js',
    'resources/styles/frontend/assets/js/core.min.js',
    'resources/styles/frontend/assets/js/lazysizes.min.js',
    'resources/styles/frontend/assets/js/owl.carousel.min.js',
    'resources/styles/frontend/assets/js/ajax-auth-script.min.js',
    'resources/styles/frontend/player/assets/js/jwplayer-8.9.3.js',
    'resources/styles/frontend/player/assets/js/player.min.js'
],'public/js/frontend.js');

mix.copyDirectory('resources/styles/frontend/assets/images', 'public/images');
mix.copyDirectory('resources/styles/frontend/assets/font', 'public/font');

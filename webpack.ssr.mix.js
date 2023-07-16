const path = require('path')
const mix = require('laravel-mix')
const nodeExternals = require('webpack-node-externals');

mix
    .options({manifest: false})
    .ts('themes/default-inertia/assets/styles/js/ssr.js', 'public/jw-styles/themes/default-inertia/assets/js')
    .react()
    //.alias({'@': path.resolve('resources/js')})
    .webpackConfig({
        target: 'node',
        externals: [nodeExternals()],
    });

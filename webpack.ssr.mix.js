const path = require('path')
const mix = require('laravel-mix')
const nodeExternals = require('webpack-node-externals');
const webpackConfig = require('./webpack.config')

mix
    .options({manifest: false})
    .js('resources/js/ssr.tsx', 'public/js')
    .react()
    .alias({'@': path.resolve('resources/js')})
    .webpackConfig({
        //...webpackConfig,
        target: 'node',
        externals: [nodeExternals()],
    });

const process = require('process')
const mix = require('laravel-mix')
const cssImport = require('postcss-import')
const cssNesting = require('postcss-nesting')
const webpackConfig = require('./webpack.config')

mix
.ts('./modules/Backend/resources/js/app.js', 'public/jw-styles/juzaweb/js')
.react({ runtimeOnly: (process.env.NODE_ENV || 'production') === 'production' })
.webpackConfig(webpackConfig)
.postCss('./modules/Backend/resources/css/app.css', 'public/jw-styles/juzaweb/css', [
  // prettier-ignore
  cssImport(),
  cssNesting(),
  //require('tailwindcss')('./modules/Backend/tailwind.config.js'),
])
.version()
.sourceMaps()
.browserSync({
    proxy: '127.0.0.1:8000',
    open: false,
    files: [
        "modules/Backend/resources/**/*.js",
        "modules/Backend/resources/**/*.ts",
        "modules/Backend/resources/**/*.tsx",
        "modules/Backend/resources/**/*.css",
    ]
})

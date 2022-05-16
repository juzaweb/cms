const process = require('process')
const mix = require('laravel-mix')
const cssImport = require('postcss-import')
const cssNesting = require('postcss-nesting')
const webpackConfig = require('./webpack.config')

mix
.js('./modules/Backend/resources/js/app.js', 'public/js')
.react({ runtimeOnly: (process.env.NODE_ENV || 'production') === 'production' })
.webpackConfig(webpackConfig)
.postCss('./modules/Backend/resources/css/app.css', 'public/css', [
  // prettier-ignore
  cssImport(),
  cssNesting(),
  require('tailwindcss')('./modules/Backend/tailwind.config.js'),
])
.version()
.sourceMaps()

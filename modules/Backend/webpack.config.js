const path = require('path')

// https://stefanbauer.me/tips-and-tricks/autocompletion-for-webpack-path-aliases-in-phpstorm-when-using-laravel-mix
module.exports = {
  output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
  resolve: {
    alias: {
      '@': path.resolve('./modules/Backend/resources/js'),
    },
    extensions: ['.js', '.json'],
  },
  devServer: {
    allowedHosts: 'all',
  },
}

const path = require('path')

module.exports = {
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
        alias: {
            '@': path.resolve('./resources/js'),
        },
        extensions: ['.js', '.jsx', '.json'],
    },
    devServer: {
        allowedHosts: 'all',
    },
}

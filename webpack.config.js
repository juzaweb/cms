const path = require('path')

module.exports = {
    //output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
        alias: {
            '@': path.resolve('./resources/js'),
        },
        extensions: ['.js', '.jsx', '.json', '.ts', '.tsx'],
    },
    devServer: {
        allowedHosts: 'all',
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                use: 'ts-loader',
                exclude: /node_modules/,
            },
        ],
    }
}

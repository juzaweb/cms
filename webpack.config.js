const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
    output:{
        chunkFilename:'js/chunk-[name].js',
    }
};

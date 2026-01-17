let mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

const modulePath = `${__dirname}/modules`;
const themePath = `${__dirname}/themes`;

mix.disableNotifications();
mix.version();

mix.options(
    {
        postCss: [
            require('postcss-discard-comments')(
                {
                    removeAll: true
                }
            )
        ],
        terser: {
            extractComments: false,
        },
    }
);

if (process.env.npm_config_theme) {
    require(`${themePath}/${process.env.npm_config_theme}/assets/webpack.mix.js`);
} else if (process.env.npm_config_module) {
    require(`${modulePath}/${process.env.npm_config_module}/assets/webpack.mix.js`);
} else {
    require(`${__dirname}/vendor/juzaweb/core/assets/webpack.mix.js`);
}

const mix = require('laravel-mix');
const modulePath = `${__dirname}/modules/Backend/resources/assets`;
const pluginPath = `${__dirname}/plugins`;
const themePath = `${__dirname}/themes`;

mix.disableNotifications();
mix.options(
    {
        postCss: [
            require('postcss-discard-comments') (
                {
                    removeAll: true
                }
            )
        ],
        uglify: {
            comments: false
        }
    }
);

if (process.env.npm_config_module) {
    require(`${modulePath}/mix.js`);
    return;
}

if (process.env.npm_config_theme) {
    require(`${themePath}/${process.env.npm_config_theme}/assets/mix.js`);
    return;
}

if (process.env.npm_config_plugin) {
    require(`${pluginPath}/${process.env.npm_config_plugin}/assets/mix.js`);
    return;
}

mix.browserSync({
    files: [
        'modules/**/*',
        'plugins/**/*',
        'themes/**/*',
        'config/*',
        'public/**/*',
        'resources/views/**/*',
        'resources/lang/**/*',
    ],
    proxy: process.env.APP_URL,
    notify: false,
    snippetOptions: {
        rule: {
            match: /<\/head>/i,
            fn: function (snippet, match) {
                return snippet + match;
            }
        }
    }
});

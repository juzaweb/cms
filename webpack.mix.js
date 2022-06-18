const mix = require('laravel-mix');
const modulePath = `${__dirname}/modules/Backend/resources/assets`;
const backendWebpack = `${__dirname}/modules/Backend/webpack.mix.js`;
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

//require(`${backendWebpack}`);

//require(`${modulePath}/mix.js`);
//require(`${modulePath}/filemanage.mix.js`);
//require(`${pluginPath}/ecommerce/src/resources/assets/mix.js`);
//require(`${themePath}/gamxo/assets/mix.js`);

mix.browserSync({
    files: [
        'modules/**/*',
        'config/*',
        'public/**/*',
        'resources/views/**/*',
        'resources/lang/**/*',
        'routes/**/*'
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

const mix = require('laravel-mix');
const modulePath = `${__dirname}/modules/Backend/resources/assets`;
const pluginPath = `${__dirname}/plugins`;

mix.disableNotifications();
mix.options({
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
});

//require(`${modulePath}/mix.js`);
//require(`${modulePath}/filemanage.mix.js`);
//require(`${pluginPath}/ecommerce/src/resources/assets/mix.js`);

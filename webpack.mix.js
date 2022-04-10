const mix = require('laravel-mix');
const modulePath = `${__dirname}/modules/Backend/resources/assets`;

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
require(`${modulePath}/filemanage.mix.js`);

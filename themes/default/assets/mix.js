const mix = require('laravel-mix');

mix.styles(
    [
        `${__dirname}/styles/css/styles.css`,
    ],
    `${__dirname}/public/css/styles.min.css`
);

mix.combine(
    [
        `${__dirname}/styles/js/index.js`,
        'modules/Backend/resources/assets/js/recaptcha.js',
    ],
    `${__dirname}/public/js/index.min.js`
);

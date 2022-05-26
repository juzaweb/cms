const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    prefix: 'tw-',
    purge: [
        // prettier-ignore
        './modules/Backend/resources/**/*.js',
        './modules/Backend/resources/**/*.blade.php',
    ],
    darkMode: false, // or 'media' or 'class'
    variants: {
        extend: {
        fill: ['focus', 'group-hover'],
        },
    },
    plugins: [
        //require ('bootstrap')
    ]
}

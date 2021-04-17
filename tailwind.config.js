const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                body: ['Open Sans'],
                avenir: ['Avenir Next'],
            },
        },
        colors: {
            // Brand colors
            primary: colors.cyan,
            secondary: colors.amber,
            neutral: colors.trueGray,

            // Direct colors
            gray: colors.trueGray,
            amber: colors.amber,
            cyan: colors.cyan,
            red: colors.red,
            blue: colors.lightBlue,
            yellow: colors.amber,
            green: colors.green,
            indigo: colors.indigo,

            black: '#000',
            white: '#fff',
            transparent: 'transparent',
            current: 'currentColor',
        }
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
    },

    plugins: [
        //require('@tailwindcss/ui'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],

    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
        defaultLineHeights: true,
        standardFontWeights: true,
    },
};

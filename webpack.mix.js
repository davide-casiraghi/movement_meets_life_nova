const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// Compile SCSS and JS
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);


// Sync browser any time something change in compiled css, js or views
mix.browserSync({
    proxy: 'laravel_jetstream.test',
    host: 'laravel_jetstream.test',
    notify: false,
    files: ['./public/css/*.css', './**/*.htm', './public/js/*.js'], //target the compiled files
})
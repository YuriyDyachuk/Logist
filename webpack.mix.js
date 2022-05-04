const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// // VERSION 1
// mix/*.js('resources/assets/js/app.js', 'public/js')*/
//   .sass('resources/assets/sass/app.scss', 'public/css').
//    options({
//        processCssUrls: false
//    });

// VERSION 2
mix.sass('resources/assets/sass2/app.scss', 'public/css').
    options({
        processCssUrls: false
    });

// mix.sass('resources/assets/sass2/template.scss', 'public/main_layout/css').
// options({
//     processCssUrls: false
// });

// PDF
mix.sass('resources/assets/sass2/pdf.scss', 'public/css').
options({
    processCssUrls: false
});
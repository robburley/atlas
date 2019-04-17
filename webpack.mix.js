const {mix} = require('laravel-mix')

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

mix.js('resources/assets/js/app.js', 'public/js')
    .extract(['vue', 'lodash', 'axios', 'jquery', 'select2'])
    .sass('resources/assets/sass/app.scss', 'public/css')
    .browserSync({
        proxy: 'atlas.test',
    })
    .version()
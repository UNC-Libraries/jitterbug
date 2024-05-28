const mix = require('laravel-mix');

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

mix.sass('resources/assets/sass/app.scss', 'public/css');

mix.scripts([
  'node_modules/js-cookie/dist/js.cookie.min.js',
  'node_modules/bootstrap/dist/js/bootstrap.min.js',
  // We're using a very slightly modified version of colResizable,
  // so have made a copy of the source to the public directory.
  'public/js/colResizable-1.6.js',
  'node_modules/devbridge-autocomplete/dist/jquery.autocomplete.min.js'
], 'public/js/vendor.js');

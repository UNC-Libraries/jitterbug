var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

/* elixir(function(mix) {
    mix.less('app.less');
});
*/

elixir(function(mix) {
    mix.sass('app.scss');

    mix.scripts([
      'node_modules/js-cookie/src/js.cookie.js',
      'node_modules/bootstrap/dist/js/bootstrap.min.js',
      'node_modules/devbridge-autocomplete/dist/jquery.autocomplete.js'
    ], 'public/js/vendor.js', './');
});

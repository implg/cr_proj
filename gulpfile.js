var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix
        .scripts([
            '/jquery/dist/jquery.min.js',
            '/bootstrap/dist/js/bootstrap.min.js',
            '/bootstrap-material-design/dist/js/material.min.js',
            '/bootstrap-material-design/dist/js/ripples.min.js',
            '/bootstrap-select/dist/js/bootstrap-select.min.js',
            '/bootstrap-select/dist/js/i18n/defaults-ru_RU.min.js',
            '/datatables.net/js/jquery.dataTables.min.js',
            '/datatables.net-buttons/js/dataTables.buttons.min.js',
            '/jquery-confirm2/dist/jquery-confirm.min.js',
            '/Split.js/split.min.js'
        ], "public/js/dependencies.js", "bower_components")
        .scriptsIn('resources/assets/js', 'public/js/app.js')
        .sass('app.scss')
        .browserSync({
            proxy: 'crm.dev'
        });
});

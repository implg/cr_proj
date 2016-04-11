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
            '/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        ], "public/js/dependencies.js", "node_modules")
        .scriptsIn('resources/assets/js', 'public/js/app.js')
        .sass('app.scss')
        .browserSync({
            proxy: 'crm.dev'
        });
});

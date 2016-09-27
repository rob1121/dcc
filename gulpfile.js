const elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

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

elixir(mix => {
    mix.copy("node_modules/font-awesome/fonts", "public/fonts")
        .sass('app.scss')
        .browserify('internal-index.js')
        // .browserify('internal-edit.js')
        // .browserify('internal-create.js')
        .browserify('external-index.js')
        // .browserify('external-edit.js')
        // .browserify('external-create.js')
        .browserSync({
            proxy: "dcc_2016.me"
        });
});

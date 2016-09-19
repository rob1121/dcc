const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

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
        .sass('internal-index.sass')
        .sass('internal-edit.sass')
        .sass('internal-create.sass')
        .webpack('internal-index.js')
        .webpack('internal-edit.js')
        .webpack('internal-create.js')

        .sass('external-index.sass')
        .webpack('external-create.js')
        .browserSync({
            proxy: "dcc_2016.me"
        });
});

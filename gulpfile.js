const elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

// require('laravel-elixir-vue-2');

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


    // mix.copy("node_modules/font-awesome/fonts", "public/fonts");

        mix.browserify('form.js')
        // mix.webpack('internal-index.js');
        // mix.webpack('external-index.js');
        // mix.webpack('iso-index.js');
        // mix.webpack('user-index.js');

        .sass('app.scss').browserSync({ proxy: "dcc.dev.me" });
});

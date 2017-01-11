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


    // mix.copy("node_modules/font-awesome/fonts", "public/fonts");

        mix.browserify('user-index.js');
        mix.browserify('user-registration.js');
        mix.browserify('user-edit.js');
        mix.browserify('external-edit.js');
        mix.browserify('internal-edit.js')
        // mix.browserify('form.js')
            // mix.webpack('internal-index.js');
            // mix.webpack('external-index.js');
            // mix.webpack('iso-index.js');

            .sass('app.scss').browserSync({ proxy: "dcc.dev" });
});

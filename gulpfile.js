const elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

elixir(mix => {


    // mix.copy("node_modules/font-awesome/fonts", "public/fonts");

        mix.browserify('user-index.js');
        mix.browserify('user-registration.js');
        mix.browserify('user-edit.js');
        mix.browserify('external-edit.js');
        mix.browserify('internal-edit.js');
        mix.browserify('form.js');
        mix.browserify('internal-index.js');
        mix.browserify('external-index.js');
        mix.browserify('iso-index.js');
        mix.browserify('esd-index.js');
        mix.browserify('log-index.js');
        mix.sass('app.scss');
        mix.browserSync({ proxy: "dcc.me" });
});

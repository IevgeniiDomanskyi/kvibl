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

mix.js('resources/js/client/app.js', 'public/js')
   .sass('resources/sass/loader.scss', 'public/css/loader.css')
   .sass('resources/sass/app.scss', 'public/css')
   .js('resources/js/admin/app.js', 'public/js/admin.js')
   .sass('resources/sass/admin.scss', 'public/css/admin.css')
   .sourceMaps()
   .version();

mix.webpackConfig({
   module: {
      rules: [
         {
            test: /\.mp3$/,
            loader: 'file-loader',
         }
      ]
   },
});

// mix.browserSync({ proxy: 'kvibl.da' })
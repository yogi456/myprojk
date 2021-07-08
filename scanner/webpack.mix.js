let mix = require('laravel-mix');

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
//require('laravel-mix-merge-manifest');
mix.webpackConfig({
  output: {
    publicPath: '/',
  }
});
mix.js('resources/assets/js/app.js', 'public/js')
      // .js('resources/assets/js/components/conversation-hub/conversation-hub.js', 'public/js/components')
      // .js('resources/assets/js/components/report-component/report.js', 'public/js/components')
      // .js('resources/assets/js/iframe.js', 'public/js/components')
      // .js('resources/assets/js/webiframe.js', 'public/js/components')
     //  .js('resources/assets/js/webiframevisitorparent.js', 'public/js/components')
       
       

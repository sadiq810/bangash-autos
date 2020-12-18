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

mix.react('resources/js/app.js', 'public/js');
//mix.sourceMaps('cheap-module-eval-source-map');
   //.sass('resources/sass/app.scss', 'public/css');
mix.js([
    'public/assets/js/custom_.js',
    'public/assets/frontend/so_tools/js/script.js',
    'public/assets/frontend/so_megamenu/so_megamenu.js',
    'public/assets/frontend/zoomsl.js',
], 'public/js/vendor.js');

mix.styles([
    'public/assets/frontend/bootstrap/css/bootstrap.min.css',
    'public/assets/frontend/soconfig/css/lib.css',
    'public/assets/frontend/so_listing_tabs/css/so-listing-tabs.css',
    'public/assets/frontend/so_tools/css/style.css',
    'public/assets/frontend/so_megamenu/so_megamenu.css',
    'public/assets/frontend/so_megamenu/wide-grid.css',
    'public/assets/frontend/theme/so-chromium/css/layout2/yellow.css',
    'public/assets/frontend/theme/so-chromium/css/responsive.css',
    'public/assets/frontend/so_onepagecheckout.css',
    'public/assets/frontend/custom.css',
    'public/assets/css/image-gallery.min.css',
], 'public/css/app.css').options({
    processCssUrls: false
});

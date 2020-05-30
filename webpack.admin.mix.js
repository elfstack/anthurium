const mix = require('laravel-mix')
const path = require('path')

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

mix.setPublicPath('public/assets/admin/')
mix.js('resources/js/admin/app.js', 'assets/admin/js')
mix.less('resources/js/admin/less/app.less', 'assets/admin/css')
mix.options({
    hmrOptions: {
        host: '0.0.0.0',
        port: 8081
    }
})
mix.webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve('resources/js/admin')
            }
        },
        output: {
            chunkFilename: 'js/[id].[contenthash].js'
        }
    });

if (mix.inProduction()) {
    mix.version();
}

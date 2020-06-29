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

mix.setPublicPath('public/assets/app/')
mix.js('resources/js/user/app.js', 'assets/app/js')
mix.less('resources/js/user/less/app.less', 'assets/app/css')

mix.options({
    hmrOptions: {
        host: '127.0.0.1',
        port: 8082
    }
})

mix.webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve('resources/js/user')
            }
        },
        output: {
            chunkFilename: 'js/[id].[contenthash].js'
        }
    });

if (mix.inProduction()) {
    mix.version();
}

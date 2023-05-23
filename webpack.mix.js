const { sourceMaps } = require('laravel-mix');
const mix = require('laravel-mix');
const CompressionPlugin = require('compression-webpack-plugin');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').vue()
    .webpackConfig({
        plugins: [
            new CompressionPlugin({
                    filename: '[path][base].gz[query]',
                    algorithm: 'gzip',
                    test: /\.js$|\.css$|\.html$|\.svg$/,
                    threshold: 10240,
                    minRatio: 0.8,
                })
            ]
    })

    .postCss('resources/css/app.css', 'public/css', [
        //
        
    ])
    .sourceMaps();

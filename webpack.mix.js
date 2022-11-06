const path = require('path')
const mix = require('laravel-mix')
const webpack = require('webpack')

require('dotenv').config()

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

let webDir = 'public'

if (! mix.inProduction()) {
    webDir = 'public'

    mix.sourceMaps()
    mix.disableNotifications()
}

mix.setPublicPath(webDir)

mix.js('resources/js/app.js', webDir + '/js')
    .postCss('resources/css/app.css', webDir + '/css', [
        require('tailwindcss')
    ])
    .postCss('resources/css/style.css', webDir + '/css', [
        require('tailwindcss')
    ])
    .vue()

mix.webpackConfig({
    plugins: [
        // new BundleAnalyzerPlugin()
        new webpack.DefinePlugin({
            'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV || 'development')
        }),
        new webpack.EnvironmentPlugin(['NODE_ENV'])
    ],
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '@': path.join(__dirname, './resources'),
            '~': path.join(__dirname, './resources/js')
        },
        fallback: {
            'http': require.resolve('stream-http'),
            'https': require.resolve('https-browserify'),
            'os': require.resolve('os-browserify/browser'),
            'stream': require.resolve('stream-browserify'),
            'crypto': require.resolve('crypto-browserify')
        }
    },
    output: {
        chunkFilename: 'js/[chunkhash].js'
    }
})

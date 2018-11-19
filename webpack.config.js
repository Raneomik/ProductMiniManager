var Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    .addPlugin(new CopyWebpackPlugin([
      { from :  './assets/fosckeditor', to : './../bundles/fosckeditor'}
    ]))
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', [
        './assets/js/app.js'
    ])
    .enableSassLoader()
    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())

    .enableVersioning(Encore.isProduction())
    .configureFilenames( {
      js:     'js/[name].js',
      css:    'css/[name].css',
      images: 'images/[name].[ext]',
      fonts:  'fonts/[name].[ext]'
    } )
     .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();

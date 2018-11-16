var Encore = require('@symfony/webpack-encore');

Encore
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

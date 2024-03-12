// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
    // répertoire où seront placés les assets compilés
    .setOutputPath('public/build/')
    // le chemin public utilisé par le serveur web pour accéder au répertoire précédent
    .setPublicPath('/build')
    // vider le répertoire outputPath avant chaque build
    .cleanupOutputBeforeBuild()
    // vous permettra d'appeler `yarn encore dev-server`
    .enableSingleRuntimeChunk()
    // active le versioning des fichiers - `yarn encore production` créera des fichiers avec des noms de fichiers différents
    .enableVersioning(Encore.isProduction())

    // analyse les fichiers .vue
    // .enableVueLoader()

    // décommentez la ligne suivante si vous utilisez TypeScript
    //.enableTypeScriptLoader()

    // décommentez la ligne suivante si vous utilisez Sass/SCSS
    //.enableSassLoader()

    // décommentez si vous utilisez React
    //.enableReactPreset()

    // une seule entrée par fichier JavaScript nécessaire pour votre application
    .addEntry('app', '/assets/app.js')

    // une seule entrée par fichier CSS
    // .addStyleEntry('global', './assets/css/global.scss')

    // active la conversion de ES6+ en ES5
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    });

// exporte la configuration finale de Webpack
module.exports = Encore.getWebpackConfig();
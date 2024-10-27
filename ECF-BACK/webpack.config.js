// webpack.config.js
const Encore = require('@symfony/webpack-encore');

Encore
    // Dossier de sortie pour les fichiers compilés
    .setOutputPath('public/build/')
    // URL publique pour accéder aux fichiers compilés
    .setPublicPath('/build')
    
    // Point d'entrée de l'application React
    .addEntry('app', './assets/js/app.js')
    
    // Permet d'utiliser JSX avec React
    .enableReactPreset()
    
    // Autres configurations
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;

// Exporte la configuration
module.exports = Encore.getWebpackConfig();

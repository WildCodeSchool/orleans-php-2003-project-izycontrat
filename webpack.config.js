const Encore = require('@symfony/webpack-encore');
const Translator = require('bazinga-translator');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    // .setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('js_dashboard', './assets/js/dashboard.js')
    .addEntry('home', './assets/js/home.js')
    .addEntry('login', './assets/js/login.js')
    .addEntry('fields', './assets/js/fields.js')

    .addStyleEntry('style_dashboard', './assets/scss/dashboard.scss')
    .addStyleEntry('article', './assets/scss/article.scss')
    .addStyleEntry('team', './assets/scss/team.scss')
    .addStyleEntry('dashboardPage', './assets/scss/dashboardPage.scss')
    .addStyleEntry('clientsList', './assets/scss/clientsList.scss')
    .addStyleEntry('lawyersList', './assets/scss/lawyersList.scss')
    .addStyleEntry('register_user', './assets/scss/registerUser.scss')
    .addStyleEntry('editor', './assets/scss/editor.scss')
    .addStyleEntry('document', './assets/scss/document.scss')

    .copyFiles([
        {
            from: './node_modules/ckeditor/', to: 'ckeditor/[path][name].[ext]', pattern: /\.(js|css)$/, includeSubdirectories: false,
        },
        { from: './node_modules/ckeditor/adapters', to: 'ckeditor/adapters/[path][name].[ext]' },
        { from: './node_modules/ckeditor/lang', to: 'ckeditor/lang/[path][name].[ext]' },
        { from: './node_modules/ckeditor/plugins', to: 'ckeditor/plugins/[path][name].[ext]' },
        { from: './node_modules/ckeditor/skins', to: 'ckeditor/skins/[path][name].[ext]' },
        { from: './assets/ckeditor', to: 'ckeditor/plugins/[path][name].[ext]' },
    ])
// .addEntry('page1', './assets/js/page1.js')
// .addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3,
    })

    // enables Sass/SCSS support
    .enableSassLoader();

// uncomment if you use TypeScript
// .enableTypeScriptLoader()

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
// .enableIntegrityHashes()

// uncomment if you're having problems with a jQuery plugin
// .autoProvidejQuery()

// uncomment if you use API Platform Admin (composer req api-admin)
// .enableReactPreset()
// .addEntry('admin', './assets/js/admin.js')
module.exports = Encore.getWebpackConfig();

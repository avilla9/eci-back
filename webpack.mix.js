const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/dist/js")
    .css("public/dist/css/_app.css", "public/dist/css/app.css")
    .options({
        processCssUrls: false,
    })
    .copyDirectory("resources/json", "public/dist/json")
    .copyDirectory("resources/fonts", "public/dist/fonts")
    .copyDirectory("resources/images", "public/dist/images")
    .browserSync({
        proxy: "lienzoestudio.test",
        files: ["resources/**/*.*"],
    });

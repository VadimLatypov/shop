const mix = require('laravel-mix');
const minifier = require('minifier');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/options.js', 'public/js')
    .vue({ version: 3 })
    .sass('resources/css/app.scss', 'public/css');

// Минификация css
mix.then(() => {
    minifier.minify('public/css/app.css');
});
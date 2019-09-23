const mix = require('laravel-mix');
const glob = require('glob');

glob.sync('resources/sass/[^_]*.scss').map(function (file) {
    mix.sass(file, 'public/css')
        .options({
            postCss: [
                require('autoprefixer')({
                    grid : true,
                }),
                require('postcss-css-variables')(),
                require('css-declaration-sorter')({
                    order: 'smacss'
                })
            ],
        })
});

// glob.sync('resources/js/*.js').map(function (file) {
//     mix.js(file, 'public/js')
// });



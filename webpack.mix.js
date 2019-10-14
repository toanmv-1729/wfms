const mix = require('laravel-mix');

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

/**
 * Resources dirs
 * @type {string}
 */
const imageDir = 'resources/img';
const vendorDir = 'resources/vendor';

/**
 * Public dirs
 * @type {string}
 */
const imgPublicDir = 'public/img';
const jsPublicDir = 'public/js';
const cssPublicDir = 'public/css';
const vendorPublicDir = 'public/vendor/';

/**
 * Images
 */
mix.copyDirectory(`${imageDir}`, imgPublicDir);

/**
 * Vendor
 */
mix.copyDirectory(`${vendorDir}`, vendorPublicDir);

mix.sass('resources/sass/app.scss', 'public/css/');
mix.js('resources/js/app.js', 'public/js/');

mix.version();

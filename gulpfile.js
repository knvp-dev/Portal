const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.copy('./node_modules/font-awesome/fonts','public/fonts')
    	.scripts([
    		'vendor/*.js'
    	], 'public/js/vendor.js')
    	.styles([
    		'vendor/*.css'
    	], 'public/css/vendor.css')
	    .sass('app.scss')
	    .webpack('app.js');
});
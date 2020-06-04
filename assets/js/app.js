/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you require will output into a single css file (app.css in this case)
global.$ = require('jquery');
global.$ = global.jQuery = $;

require('bootstrap');
require('../scss/app.scss');
require('../scss/home.scss');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.navbar').css('background-color', '#042A5F');
        } else {
            $('.navbar').css('background-color', 'rgba(0,0,0,0.0)');
        }
    });
});


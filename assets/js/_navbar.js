const $ = require('jquery');

$(document).ready(() => {
    // eslint-disable-next-line func-names
    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            $('.navbar').css('background-color', '#2d2d2d');
        } else {
            $('.navbar').css('background-color', 'transparent');
        }
    });
});

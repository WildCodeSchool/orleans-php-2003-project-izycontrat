const $ = require('jquery');

$(document).ready(() => {
    // eslint-disable-next-line func-names
    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            $('.navbar').css('background-color', '#042A5F');
        } else {
            $('.navbar').css('background-color', 'transparent');
        }
    });
});

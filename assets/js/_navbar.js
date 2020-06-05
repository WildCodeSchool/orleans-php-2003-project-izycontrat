const $ = require('jquery');

$(document).ready(() => {
    // eslint-disable-next-line func-names
    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            $('.navbar').css({ 'background-color': '#eeeeee', 'box-shadow': '1px 1px 3px #BEA058' });
            $('.nav-link').css('color', '#212121');
        } else {
            $('.navbar').css({ 'background-color': 'transparent', 'box-shadow': 'none' });
            $('.nav-link').css('color', '#eeeeee');
        }
    });
});

$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.navbar').css('background-color', '#042A5F');
        } else {
            $('.navbar').css('background-color', 'rgba(0,0,0,0.0)');
        }
    });
});

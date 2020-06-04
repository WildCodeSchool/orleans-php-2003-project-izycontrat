const $ = require('jquery');

$(() => {
    // eslint-disable-next-line func-names
    $('.sidebar-dropdown > a').click(function () {
        $('.sidebar-submenu').slideUp(200);
        if (
            $(this)
                .parent()
                .hasClass('active')
        ) {
            $('.sidebar-dropdown').removeClass('active');
            $(this)
                .parent()
                .removeClass('active');
        } else {
            $('.sidebar-dropdown').removeClass('active');
            $(this)
                .next('.sidebar-submenu')
                .slideDown(200);
            $(this)
                .parent()
                .addClass('active');
        }
    });

    $('#close-sidebar').click(() => {
        $('.page-wrapper').removeClass('toggled');
    });
    $('#show-sidebar').click(() => {
        $('.page-wrapper').addClass('toggled');
    });
});

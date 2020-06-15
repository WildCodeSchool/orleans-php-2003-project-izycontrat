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
        $('.footer').removeClass('toggled');
        $('.sidebar-submenu').slideUp(200);
        $('.sidebar-dropdown').removeClass('active');
        $(this)
            .parent()
            .removeClass('active');
    });
    $('.sidebar-wrapper .sidebar-menu ul .sidebar-dropdown a').click(() => {
        $('.page-wrapper').addClass('toggled');
        $('.footer').addClass('toggled');
    });
    $('#show-sidebar').click(() => {
        $('.page-wrapper').addClass('toggled');
        $('.footer').addClass('toggled');
    });
});

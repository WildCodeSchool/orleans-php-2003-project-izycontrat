const $ = require('jquery');

$(function dashboard()
{
    $('.sidebar-dropdown > a').click(function dropDown()
    {
        $('.sidebar-submenu').slideUp(200);
        if (
            $(this)
                .parent()
                .hasClass('active')
        ) {
            $(".sidebar-dropdown").removeClass('active');
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

    $('#close-sidebar').click(function remove()
    {
        $('.page-wrapper').removeClass('toggled');
    });
    $('#show-sidebar').click(function add()
    {
        $('.page-wrapper').addClass('toggled');
    });


});

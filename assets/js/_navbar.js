$(document)
    .ready(function () {
        $(window)
            .scroll(function () {
                if ($(this)
                    .scrollTop() > 100) {
                    $('.navbar')
                        .css('background-color', '#042A5F');
                    $('.nav-link')
                        .css('color', '#E1E6EC');
                } else {
                    $('.navbar')
                        .css('background-color', 'rgba(0,0,0,0.0)');
                    $('.nav-link')
                        .css('color', '#000A16');
                }
            });
    });

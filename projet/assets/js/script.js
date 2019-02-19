$(document).ready( function() {


    $('#navigation-toggle').click( function() {
        $('html').toggleClass('shownav');
    });

    $('#subnav-toggle').click( function() {
        $('#subnav').toggleClass('showsubnav');
    });

    $("iframe[src*='youtube']").closest("div, p").addClass("videopanel");

});


$(window).on('scroll load',function(){

    // we round here to reduce a little workload
    var stop = Math.round($(window).scrollTop());

    if (stop > 40) {
        $('body').addClass('scrolled');
    } else {
        $('body').removeClass('scrolled');
    }

});


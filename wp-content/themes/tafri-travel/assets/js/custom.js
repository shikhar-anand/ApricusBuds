jQuery(function($){
	"use strict";
	jQuery('.main-menu-navigation > ul').superfish({
		delay:       0,                            
		animation:   {opacity:'show',height:'show'},  
		speed:       'fast'                        
	});
});

function tafri_travel_resmenu_open() {
	jQuery(".sidebar").addClass('menu');
}
function tafri_travel_resmenu_close() {
	jQuery(".sidebar").removeClass('menu');
}

var tafri_travel_Keyboard_loop = function (elem) {

    var tafri_travel_tabbable = elem.find('select, input, textarea, button, a').filter(':visible');

    var tafri_travel_firstTabbable = tafri_travel_tabbable.first();
    var tafri_travel_lastTabbable = tafri_travel_tabbable.last();
    /*set focus on first input*/
    tafri_travel_firstTabbable.focus();

    /*redirect last tab to first input*/
    tafri_travel_lastTabbable.on('keydown', function (e) {
        if ((e.which === 9 && !e.shiftKey)) {
            e.preventDefault();
            tafri_travel_firstTabbable.focus();
        }
    });

    /*redirect first shift+tab to last input*/
    tafri_travel_firstTabbable.on('keydown', function (e) {
        if ((e.which === 9 && e.shiftKey)) {
            e.preventDefault();
            tafri_travel_lastTabbable.focus();
        }
    });

    /* allow escape key to close insiders div */
    elem.on('keyup', function (e) {
        if (e.keyCode === 27) {
            elem.hide();
        }
        ;
    });
};

// scroll
jQuery(document).ready(function () {
	jQuery(window).scroll(function () {
	    if (jQuery(this).scrollTop() > 100) {
	        jQuery('.scrollup').fadeIn();
	    } else {
	        jQuery('.scrollup').fadeOut();
	    }
	});
	jQuery('.scrollup').click(function () {
	    jQuery("html, body").animate({
	        scrollTop: 0
	    }, 600);
	    return false;
	});

	jQuery('.search-show').click(function(){
		jQuery('.searchform-inner').css('visibility','visible');
	});

	jQuery('.close').click(function(){
		jQuery('.searchform-inner').css('visibility','hidden');
	});
});

jQuery(function($){
	$(window).load(function() {
		$("#pre-loader").delay(1000).fadeOut("slow");
		$(".circle").delay(1000).fadeOut("slow");
	})

	$('.mobiletoggle').click(function () {
        tafri_travel_Keyboard_loop($('.sidebar'));
    });
});

(function( $ ) {

	$(window).scroll(function(){
		var sticky = $('.sticky-header'),
		scroll = $(window).scrollTop();

		if (scroll >= 100) sticky.addClass('fixed-header');
		else sticky.removeClass('fixed-header');
	});

})( jQuery );
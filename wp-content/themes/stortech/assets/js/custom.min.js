jQuery(document).ready(function($) {

/*------------------------------------------------
            DECLARATIONS
------------------------------------------------*/

    var loader = $('#loader');
    var loader_container = $('#preloader');
    var scroll = $(window).scrollTop();  
    var scrollup = $('.backtotop');
    var menu_toggle = $('.menu-toggle');
    var dropdown_toggle = $('.main-navigation button.dropdown-toggle');
    var nav_menu = $('.main-navigation ul.nav-menu');

/*------------------------------------------------
            PRELOADER
------------------------------------------------*/

    loader_container.delay(1000).fadeOut();
    loader.delay(1000).fadeOut("slow");

/*------------------------------------------------
            BACK TO TOP
------------------------------------------------*/

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            scrollup.css({bottom:"25px"});
        } 
        else {
            scrollup.css({bottom:"-100px"});
        }
    });

    scrollup.click(function() {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });

/*------------------------------------------------
            MAIN NAVIGATION
------------------------------------------------*/

    menu_toggle.click(function(){
        nav_menu.slideToggle();
        $(this).toggleClass('active');
       $('.main-navigation').toggleClass('menu-open');
       $('.menu-overlay').toggleClass('active');
    });

    dropdown_toggle.click(function() {
        $(this).toggleClass('active');
        $(this).parent().find('.sub-menu').first().slideToggle();
        $('#primary-menu > li:last-child button.active').unbind('keydown');
    });

    $('.site-branding-wrapper ul li.search-menu a').click(function(event) {
        event.preventDefault();
        $('body').addClass('search-menu-active');
        $('.site-branding-wrapper ul li.search-menu a').addClass('search-active');
        $('.site-branding-wrapper #search').fadeIn();
    });

    
      $('.main-navigation ul li.search-menu a').click(function(event) {
        event.preventDefault();
        $(this).toggleClass('search-active');
        $('.main-navigation #search').fadeToggle();
        $('.main-navigation .search-field').focus();
    });


    $(document).click(function (e) {
        var container = $("#masthead");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('#site-navigation').removeClass('menu-open');
            $('#primary-menu').slideUp();
            $('.menu-overlay').removeClass('active');
        }
    });

    $(document).keyup(function(e) {
        event.preventDefault();
        if (e.keyCode === 27) {
            $('body').removeClass('search-menu-active');
            $('.site-branding-wrapper ul li.search-menu a').removeClass('search-active');
            $('.site-branding-wrapper #search').hide();

            $('#site-navigation').removeClass('menu-open');
            $('#primary-menu').slideUp();
            $('.menu-overlay').removeClass('active');
        }
    });

/*--------------------------------------------------------------
 Keyboard Navigation
----------------------------------------------------------------*/
if( $(window).width() < 1024 ) {
    $('#primary-menu').find("li").last().bind( 'keydown', function(e) {
        if( e.which === 9 ) {
            e.preventDefault();
            $('#masthead').find('.menu-toggle').focus();
        }
    });

    $('#primary-menu > li:last-child button:not(.active)').bind( 'keydown', function(e) {
        if( e.which === 9 ) {
            e.preventDefault();
            $('#masthead').find('.menu-toggle').focus();
        }
    });
}
else {
    $('#primary-menu').find("li").unbind('keydown');
}

$(window).resize(function() {
    if( $(window).width() < 1024 ) {
        $('#primary-menu').find("li").last().bind( 'keydown', function(e) {
            if( e.which === 9 ) {
                e.preventDefault();
                $('#masthead').find('.menu-toggle').focus();
            }
        });

        $('#primary-menu > li:last-child button:not(.active)').bind( 'keydown', function(e) {
            if( e.which === 9 ) {
                e.preventDefault();
                $('#masthead').find('.menu-toggle').focus();
            }
        });
    }
    else {
        $('#primary-menu').find("li").unbind('keydown');
    }
});

menu_toggle.on('keydown', function (e) {
    var tabKey = e.keyCode === 9;
    var shiftKey = e.shiftKey;

    if( menu_toggle.hasClass('active') ) {
        if ( shiftKey && tabKey ) {
            e.preventDefault();
            nav_menu.slideUp();
            $('.main-navigation').removeClass('menu-open');
            $('.menu-overlay').removeClass('active');
            menu_toggle.removeClass('active');
        };
    }
});
/*------------------------------------------------
            SLICK SLIDER
------------------------------------------------*/

$('#featured-slider').slick({
    responsive: [
        {
            breakpoint: 1024,
                settings: {
                slidesToShow: 1
            }
        },
        {
            breakpoint: 567,
                settings: {
                slidesToShow: 1,
                arrows: false
            }
        }
    ]
});

$('.product-slider').slick({
    responsive: [
        {
            breakpoint: 1200,
                settings: {
                slidesToShow: 3,
                slidesToScroll: 3
            }
        },
        {
            breakpoint: 900,
                settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                arrows: false
            }
        },
        {
            breakpoint: 567,
                settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false
            }
        }
    ]
});

$('.testimonial-slider').slick();

/*------------------------------------------------
            PACKERY
------------------------------------------------*/
$('.grid').imagesLoaded( function() {
    $('.grid').packery({
        itemSelector: '.grid-item'
    });
});


/*------------------------------------------------
                Match Height
------------------------------------------------*/

$('.woocommerce ul.products li.product').matchHeight();

/*------------------------------------------------
            PRODUCTS FILTERING
------------------------------------------------*/
$('.product-filtering ul li a').click(function(){
    $('.product-filtering ul li').removeClass('active');
    $(this).parent().addClass('active');
});

$('.product-filtering ul li a').click( function(e) {
    e.preventDefault();
    var currentCategory = '.' + $(this).data('slug');
    $('.product-slider').slick('slickUnfilter');
    $('.product-slider').slick('slickFilter', currentCategory);
});

/*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});
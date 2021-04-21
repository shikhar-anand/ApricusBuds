/**
 *	Custom Front-end JS code
 */
 
jQuery(document).ready(function() {
	
	var searchButton	=	jQuery('#search-btn'),
		searchField		=	jQuery('#olively_search input[type="text"]'),
		siteNav			=	jQuery('#site-navigation, #mobile-nav-btn'),
		jumpToIcon		=	jQuery('.jump-to-icon'),
		jumpToField		=	jQuery('.jump-to-field');
	
	
	searchButton.on('click', function() {
		searchField.focus()
		var toggleWidth = searchField.width() == 0 ? '200px' : '0px';
		
		if (toggleWidth === '200px') {
			jumpToIcon.add(jumpToField).add(searchField).attr('tabindex', 0)
			searchField.focus()
		} else {
			jumpToIcon.add(jumpToField).add(searchField).attr('tabindex', -1)
			searchButton.focus()
		}
		searchField.animate({
			width: toggleWidth
			},
			300,
		)
	})
	
	jumpToIcon.on('focus', () => {
		searchButton.focus()
	})
	
	jumpToField.on('focus', () => {
		searchField.focus()
	})
/*
	var	searchScreen = jQuery('#search-screen'),
		searchInput	 = jQuery('.top_search_field'),
		cancelSearch = jQuery('.cancel_search');
	
	searchScreen.hide();
	
	jQuery('#search-btn').on('click', function() {
		searchScreen.fadeIn(200);
		searchInput.focus();
	});
	
	cancelSearch.on('click', function(e) {
		searchScreen.fadeOut(200);
		jQuery('#search-btn').focus();
	});
	
	jQuery('#go-to-field').on('focus', function() {
		jQuery(this).siblings('input[type="text"]').focus();
	});
	
	jQuery('#go-to-close').on('focus', function() {
		jQuery(this).siblings('button.cancel_search').focus();
	});
*/
	
	// Navigation
	jQuery('.menu-link').bigSlide({
		easyClose	: true,
		width		: '25em',
		side		: 'right',
		afterOpen	: function() {
				    	jQuery('#close-menu').focus();
			    	},
		afterClose: function() {
				    	jQuery('#mobile-nav-btn').focus();
			      }
    });
  
  	jQuery('.go-to-top').on('focus', function() {
		jQuery('#close-menu').focus();
	});
	
	jQuery('.go-to-bottom').on('focus', function() {
		jQuery('ul#mobile-menu > li:last-child > a').focus();
	});
	
	var parentElement =	jQuery('.panel li.menu-item-has-children'),
      dropdown		=	jQuery('.panel li.menu-item-has-children span');
	  
	parentElement.children('ul').hide();
	dropdown.on({
		'click': function(e) {
			jQuery(this).siblings('ul').slideToggle().toggleClass('expanded');
			e.stopPropagation();
		},
		'keydown': function(e) {
			if( e.keyCode == 32 || e.keyCode == 13 ) {
				e.preventDefault();
				jQuery(this).siblings('ul').slideToggle().toggleClass('expanded');
				e.stopPropagation();
			}
		}
	});
	
	
// Owl Slider
var catSliders = [];

for (catSlider in window) {
    if ( catSlider.indexOf("cat_slider") != -1 ) {
	    catSliders.push( window[catSlider] );
    }
};
catSliders.forEach( function( item ) {
    var slider = jQuery("#" + item.id).find('.cat-slider');
    slider.owlCarousel({
	    items: 1,
	    loop: true,
	    autoplay: true,
	    dots: false,
	    nav: true
    });
});
	
	
	// Tab Widget
	var tabWidgets = [];
    
    if ( 'undefined' !== tabWidgets && tabWidgets.length > 0 ) {
	    console.log(tabWidgets)
	    for (tabWidget in window) {
		    if ( tabWidget.indexOf("tab_widget") != -1 ) {
			    tabWidgets.push( window[tabWidget] );
		    }
	    };
	    tabWidgets.forEach( function( item ) {
		    
		    var widget 			=	jQuery("#tab-category-wrapper-" + item.number),
		    	containerLeft	=	widget.find('ul').offset().left,
	    		currentArrow	=	widget.find('.tabs-slider'),
	    		arrowWidth		=	currentArrow.width();
	    		
		    widget.tabs({
			    create: function( event, ui ) {
					
					var initialTab = ui.tab;
						initialTabLeft	=	initialTab.position().left;
						initialTabWidth	=	initialTab.width();
						console.log(initialTabWidth)
						currentArrow.css('left', (initialTabWidth/2 - 10) + 'px');
						//currentArrow.css('transform', initialTabLeft - containerLeft + initialTabWidth/2 -10 + 'px');
			    },
			     beforeActivate: function( event, ui ) {
				    jQuery(ui.oldPanel[0]).fadeOut()
				    jQuery(ui.newPanel[0]).fadeIn()
			    },
			    activate: function( event, ui ) {
			    	var currentTabLeft		=	ui.newTab.position().left,
			    		currentTabWidth		=	ui.newTab.width();
			    		
					currentArrow.animate({
										    left: currentTabLeft + currentTabWidth/2 - 10 + 'px'
										},
										{
											duration: 300
										});
		    	}
		    });
		});
	}
});
;( function( $ ) {

    /*
     * Search Form
     */
    var searchForm = $( '.theme-integration-one-row' );
    if( searchForm.length ) {
        searchForm.each( function() {
            var searchInput = $( this ).find( 'input[id^="searchform-"]' ),
                searchSubmit = $( this ).find( 'input[type="submit"]' );

            if( searchInput.length && searchSubmit.length ) {
                searchSubmit.css( 'width', Math.round( searchSubmit.outerWidth() ) );
                searchInput.css( 'width', searchInput.outerWidth() - searchSubmit.outerWidth() + 'px' );
                searchSubmit.css( {
                    'height': searchInput.outerHeight() + 'px',
                    'verticalAlign': 'bottom'
                } );
            }

            $( this ).css( 'opacity', 1 );
        } );
    }

    /*
     * Back to Top Button
     */
    var backToTop       = $( '.theme-integration-footer-backtotop' ),
        backToTopFixed  = $( '.theme-integration-footer-backtotop-fixed' ),
        showAfterPixel  = 60,
        scrollTime      = 500,
        fadeInTime      = 250,
        showHideTimeout;

    // if button is active
    if( backToTop.length ) {
        // button function
        backToTop.on( 'click', function() {
            $( 'html, body' ).animate( {
                scrollTop : 0
            }, scrollTime );
        });

        // show / hide fixed button
        if( backToTopFixed.length ) {
            $( window ).scroll( function() {
                if( showHideTimeout != 'running' ) {
                    showHideTimeout = 'running';

                    setTimeout( function() {
                        showHideTimeout = 'finished';

                        if ( $( this ).scrollTop() > showAfterPixel ) {        // If page is scrolled more than 50px
                            backToTopFixed.css( 'display', 'block' ).animate( {
                                opacity: 1
                            }, fadeInTime );
                        } else {
                            backToTopFixed.animate( {
                                opacity: 0
                            }, fadeInTime, function() {
                                $( this ).css( 'display', 'none' );
                            } )
                        }
                    }, fadeInTime + 100 );
                }
            });
        }

    }

} )( jQuery );
<?php

// footer credits
if( $this->get_content_field_value( 'footer_credits_select' ) === 'custom' ) {
	global $theme_integration_footer_credits;
	$theme_integration_footer_credits = str_replace( '%year%', date( 'Y', time() ), $this->get_content_field_value( 'footer_credits' ) );

	if( !function_exists( 'theme_integration_footer_credits' ) ) {
		function theme_integration_footer_credits( $text ) {
			global $theme_integration_footer_credits;

			return $theme_integration_footer_credits;
		}
	}

	add_filter( 'genesis_footer_creds_text', 'theme_integration_footer_credits' );
}

// footer backtotop link
if( $this->get_content_field_value( 'footer_backtotop_select' ) !== 'none' ) {
	global $theme_integration_footer_backtotop,
	       $theme_integration_footer_backtotop_select;

	$theme_integration_footer_backtotop = $this->get_content_field_value( 'footer_backtotop_text' );
	$theme_integration_footer_backtotop_select = $this->get_content_field_value( 'footer_backtotop_select' );

	if( !function_exists( 'theme_integration_footer_backtotop' ) ) {
		function theme_integration_footer_backtotop( $text ) {
			global $theme_integration_footer_backtotop,
			       $theme_integration_footer_backtotop_select;

			$class = 'theme-integration-footer-backtotop theme-integration-footer-backtotop-'
			         . $theme_integration_footer_backtotop_select;
			$class .= $theme_integration_footer_backtotop_select === 'fixed'
				? ' button'
				: '';

			return '<div class="' . $class. '">[footer_backtotop text="'
			       . $theme_integration_footer_backtotop . '"]</div>';
		}
	}

	add_filter( 'genesis_footer_backtotop_text', 'theme_integration_footer_backtotop' );
}


// for html5 genesis disables backtotop link - we reactivate it
if ( genesis_html5() && $this->get_content_field_value( 'footer_backtotop_select' ) !== 'none' ) {
	if( !function_exists( 'theme_integration_footer_html5' ) ) {
		function theme_integration_footer_html5( $output, $backtotop_text, $creds_text ) {
			$backtotop = $backtotop_text ? sprintf( '<div class="gototop"><p>%s</p></div>', $backtotop_text ) : '';
			$creds     = $creds_text ? sprintf( '<div class="creds"><p>%s</p></div>', $creds_text ) : '';
			return $backtotop . $creds;
		}
	}
	add_filter( 'genesis_footer_output', 'theme_integration_footer_html5', 10, 3 );
}


genesis_footer_markup_open();
genesis_do_footer();
genesis_footer_markup_close();


remove_filter( 'genesis_footer_output', 'theme_integration_footer_html5' );
remove_filter( 'genesis_footer_creds_text', 'theme_integration_footer_credits' );
remove_filter( 'genesis_footer_backtotop_text', 'theme_integration_footer_backtotop' );
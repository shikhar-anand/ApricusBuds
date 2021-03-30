<?php
/**
 * @package tafri-travel
 * @subpackage tafri-travel
 * @since tafri-travel 1.0
 * Setup the WordPress core custom header feature.
 *
 * @uses tafri_travel_header_style()
*/

function tafri_travel_custom_header_setup() {

	add_theme_support( 'custom-header', apply_filters( 'tafri_travel_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1355,
		'height'                 => 320,
		'flex-width'         	=> true,
        'flex-height'        	=> true,
		'wp-head-callback'       => 'tafri_travel_header_style',
	) ) );
}

add_action( 'after_setup_theme', 'tafri_travel_custom_header_setup' );

if ( ! function_exists( 'tafri_travel_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see tafri_travel_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'tafri_travel_header_style' );
function tafri_travel_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$tafri_travel_custom_css = "
        #header,.page-template-custom-front-page #header{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'tafri-travel-basic-style', $tafri_travel_custom_css );
	endif;
}
endif;
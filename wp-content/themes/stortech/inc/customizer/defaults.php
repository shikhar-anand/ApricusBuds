<?php
/**
 * Customizer default options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 * @return array An array of default values
 */

function stortech_get_default_theme_options() {
	$theme_data = wp_get_theme();
	$stortech_default_options = array(
		// Color Options
		'header_title_color'			=> '#010101',
		'header_tagline_color'			=> '#010101',
		'header_txt_logo_extra'			=> 'show-all',

	
		// breadcrumb
		'breadcrumb_enable'				=> true,
		'breadcrumb_separator'			=> '/',
		
		// layout 
		'site_layout'         			=> 'wide-layout',
		'sidebar_position'         		=> 'right-sidebar',
		'post_sidebar_position' 		=> 'right-sidebar',
		'page_sidebar_position' 		=> 'right-sidebar',
		'menu_sticky'					=> true,
		'social_nav_enable'				=> true,

		// excerpt options
		'long_excerpt_length'           => 25,
		
		// pagination options
		'pagination_enable'         	=> true,
		'pagination_type'         		=> 'default',

		// footer options
		'copyright_text'           		=> sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'stortech' ), '[the-year]', '[site-link]' ),
		'scroll_top_visible'        	=> true,


		// reset options
		'reset_options'      			=> false,
		
		// homepage options
		'enable_frontpage_content' 		=> false,

		// homepage sections sortable
		'sortable' 			=>'slider,recent_product,accessories,testimonial,services',

		// blog/archive options
		'your_latest_posts_title' 		=> esc_html__( 'Blogs', 'stortech' ),
		'hide_date' 					=> false,
		'hide_category'					=> false,
		'hide_author'					=> false,

		// single post theme options
		'single_post_hide_date' 		=> false,
		'single_post_hide_author'		=> false,
		'single_post_hide_category'		=> false,
		'single_post_hide_tags'			=> false,

		/* Front Page */
	
		
		// slider section 
		'slider_section_enable'			=> false,
		'slider_content_type'			=> 'page',
		'slider_autoplay'				=> false,
		'slider_btn_label'				=> esc_html__( 'Buy Now', 'stortech' ),

		// accessories section
		'accessories_section_enable'			=> false,
		'accessories_content_type'			=> 'page',
		'accessories_btn_label'				=> esc_html__( 'Buy Now', 'stortech' ),

		// testimonial
		'testimonial_section_enable'		=> false,

		// recent section
		'recent_product_section_enable'		=> false,
		'recent_product_content_type'		=> 'product',
		'recent_product_title'				=> esc_html__( 'Similar Products', 'stortech' ),
		'recent_product_subtitle'				=> esc_html__( 'Although fashion and technology are often perceived as entirely distinct fields, the two have always intersected.', 'stortech' ),

		//services section
		'services_section_enable'			=> false,

	);
	
	$output = apply_filters( 'stortech_default_theme_options', $stortech_default_options );

	// Sort array in ascending order, according to the key:
	if ( ! empty( $output ) ) {
		ksort( $output );
	}

	return $output;
}
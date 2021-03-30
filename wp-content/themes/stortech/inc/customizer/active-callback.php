<?php
/**
 * Customizer active callbacks
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

if ( ! function_exists( 'stortech_is_breadcrumb_enable' ) ) :
	/**
	 * Check if breadcrumb is enabled.
	 *
	 * @since Stortech 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function stortech_is_breadcrumb_enable( $control ) {
		return $control->manager->get_setting( 'stortech_theme_options[breadcrumb_enable]' )->value();
	}
endif;

if ( ! function_exists( 'stortech_is_pagination_enable' ) ) :
	/**
	 * Check if pagination is enabled.
	 *
	 * @since Stortech 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function stortech_is_pagination_enable( $control ) {
		return $control->manager->get_setting( 'stortech_theme_options[pagination_enable]' )->value();
	}
endif;

if ( ! function_exists( 'stortech_is_static_homepage_enable' ) ) :
	/**
	 * Check if static homepage is enabled.
	 *
	 * @since Stortech 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function stortech_is_static_homepage_enable( $control ) {
		return ( 'page' == $control->manager->get_setting( 'show_on_front' )->value() );
	}
endif;

/**
 * Front Page Active Callbacks
 */

/**
 * Check if testimonial section is enabled.
 *
 * @since Stortech 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function stortech_is_testimonial_section_enable( $control ) {
	return ( $control->manager->get_setting( 'stortech_theme_options[testimonial_section_enable]' )->value() );
}

/**
 * Check if testimonial section is enabled.
 *
 * @since Stortech 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function stortech_is_subscription_section_enable( $control ) {
	return ( $control->manager->get_setting( 'stortech_theme_options[subscription_section_enable]' )->value() );
}

//======================================================================//

/**
 * Check if slider section is enabled.
 *
 * @since Stortech 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function stortech_is_slider_section_enable( $control ) {
	return ( $control->manager->get_setting( 'stortech_theme_options[slider_section_enable]' )->value() );
}

//--------------accessories section------------------------//

/**
 * Check if accessories section is enabled.
 *
 * @since Stortech 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function stortech_is_accessories_section_enable( $control ) {
	return ( $control->manager->get_setting( 'stortech_theme_options[accessories_section_enable]' )->value() );
}

/**
 * Check if accessories section content type is page.
 *
 * @since Stortech 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function stortech_is_accessories_section_content_page_enable( $control ) {
	$content_type = $control->manager->get_setting( 'stortech_theme_options[accessories_content_type]' )->value();
	return stortech_is_accessories_section_enable( $control ) && ( 'page' == $content_type );
}


function stortech_is_accessories_product_section_content_product_enable( $control ) {
	$content_type = $control->manager->get_setting( 'stortech_theme_options[accessories_content_type]' )->value();
	return stortech_is_accessories_section_enable( $control ) && ( 'product' == $content_type );
}


/**
 * Check if recent_product section is enabled.
 *
 * @since Stortech 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function stortech_is_recent_product_section_enable( $control ) {
	return ( $control->manager->get_setting( 'stortech_theme_options[recent_product_section_enable]' )->value() );
}

function stortech_is_recent_product_section_content_product_enable( $control ) {
	$content_type = $control->manager->get_setting( 'stortech_theme_options[recent_product_content_type]' )->value();
	return stortech_is_recent_product_section_enable( $control ) && ( 'product' == $content_type );
}

function stortech_is_services_section_enable( $control ) {
	return ( $control->manager->get_setting( 'stortech_theme_options[services_section_enable]' )->value() );
}

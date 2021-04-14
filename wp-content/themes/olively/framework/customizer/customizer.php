<?php
/**
 * Olively Theme Customizer
 *
 * @package Olively
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function olively_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'olively_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'olively_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'olively_customize_register' );

/**
 *	Add Controls for different Sections
 */
require_once get_template_directory() . '/framework/customizer/sanitization.php';
require_once get_template_directory() . '/framework/customizer/custom_controls.php';
require_once get_template_directory() . '/framework/customizer/general.php';
require_once get_template_directory() . '/framework/customizer/header.php';
require_once get_template_directory() . '/framework/customizer/layouts.php';
require_once get_template_directory() . '/framework/customizer/footer.php';
require_once get_template_directory() . '/framework/customizer/colors.php';
require_once get_template_directory() . '/framework/customizer/social_icons.php';
require_once get_template_directory() . '/framework/customizer/front-page.php';
require_once get_template_directory() . '/framework/customizer/selective_refresh.php';


/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function olively_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function olively_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function olively_customize_preview_js() {
	wp_enqueue_script( 'olively-customizer', esc_url(get_template_directory_uri() . '/assets/js/customizer.js'), array( 'customize-preview' ), OLIVELY_VERSION, true );
}
add_action( 'customize_preview_init', 'olively_customize_preview_js' );

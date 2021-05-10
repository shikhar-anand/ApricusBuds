<?php
/**
 *	Scripts and Styles for Admin area and Customizer
 */

function olively_custom_admin_styles( $hook ) {
	
	$allowed = ['widgets.php', 'post.php', 'post-new.php'];
	
	if (!in_array($hook, $allowed)) {
		return;
	}
	
	wp_enqueue_script("olively-customize-control-js", esc_url(get_template_directory_uri() . "/assets/js/customize_controls.js"), array(), OLIVELY_VERSION, true );

    wp_enqueue_style( 'olively-admin-css', esc_url( get_template_directory_uri() . '/assets/theme-styles/css/admin.css' ), array(), OLIVELY_VERSION );
    
}
add_action( 'admin_enqueue_scripts', 'olively_custom_admin_styles' );

<?php
/**
 *	Custom Block Styles for OLIVELY
 */
 
function olively_register_block_style() {
	
	wp_enqueue_style( 'olively-block-style', esc_url( get_template_directory_uri() . '/assets/theme-styles/css/block-styles.css'), array(), OLIVELY_VERSION );
	
}
add_action('init', 'olively_register_block_style');
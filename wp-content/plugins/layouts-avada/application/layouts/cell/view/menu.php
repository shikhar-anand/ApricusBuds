<?php
/**
 * View for Avada Nav Menu
 */

$sticky = false;

if(!function_exists('avada_main_menu_override')) {
	function avada_main_menu_override() {
		wp_nav_menu(array(
				'theme_location'	=> 'main_navigation',
				'depth'				=> 5,
				'menu_class'      	=> 'fusion-menu',
				'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'fallback_cb'	   	=> 'FusionCoreFrontendWalker::fallback',
				'walker'			=> new FusionCoreFrontendWalker(),
				'container_class'	=> 'fusion-main-menu'
		));

		// Make sure mobile menu is not loaded when ubermenu is used
		if ( ! function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) ||
				( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ! ubermenu_get_menu_instance_by_theme_location( 'main_navigation' ) )
		) {
			avada_mobile_main_menu();
		}
	}
}

if( $this->get_content_field_value( 'toggle_search' ) && "1" == $this->get_content_field_value( 'toggle_search' )) {
	avada_main_menu_override();
} else {
	remove_filter( 'wp_nav_menu_items', 'avada_add_search_to_main_nav', 20, 4 );
	avada_main_menu_override();
	add_filter( 'wp_nav_menu_items', 'avada_add_search_to_main_nav', 20, 4 );
}




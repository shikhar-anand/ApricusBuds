<?php
/**
 *	Starter Content for Olively
 */

function olively_starter_content() {
	
	$starter_content = array(
		'theme_mods'	=>	array(
			'blogdescription'			=>	'',
			'olively_hero_text'			=>	_x('Have Stories to Tell', 'Theme Starter Content', 'olively'),
			'olively_hero_description'	=>	_x('Not Pockets to Fill', 'Theme Starter Content', 'olively'),
			'olively_hero_cta_url'		=>	esc_url('#'),
			'olively_hero_cta_text'		=>	_x('Read More', 'Theme Starter Content', 'olively'),
			'olively_featured_page'		=>	0
		)
	);
	
	add_theme_support('starter-content', $starter_content);
	
}
add_action('after_setup_theme', 'olively_starter_content');
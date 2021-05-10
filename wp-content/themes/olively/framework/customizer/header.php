<?php
/**
 * Controls for the Header Section
 */
 
function olively_header_customize_register( $wp_customize ) {
	 
	$wp_customize->get_section("title_tagline")->panel	=	"olively_header";
	$wp_customize->get_section("header_image")->panel	=	"olively_header";
	 
	$wp_customize->add_panel(
		"olively_header", array(
			"title"	=>	__("Header", "olively"),
			"priority"	=>	10
		)
	);
	
	$wp_customize->add_section(
		'olively_header_options', array(
			'title'			=>	__('Header Options', 'olively'),
			'description'	=>	__('Options for the Header', 'olively'),
			'panel'			=>	'olively_header',
			'priority'		=>	60
		)
	);
	
	$wp_customize->add_setting(
		'olively_hero_text', array(
			'default'			=>	'',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(
		'olively_hero_text', array(
			'label'		=>	__('Hero Text', 'olively'),
			'section'	=>	'olively_header_options',
			'type'		=>	'text',
			'priority'	=>	7
		)
	);
	
	$wp_customize->add_setting(
		'olively_hero_description', array(
			'default'			=>	'',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(
		'olively_hero_description', array(
			'label'		=>	__('Hero Description', 'olively'),
			'section'	=>	'olively_header_options',
			'type'		=>	'text',
			'priority'	=>	8
		)
	);
	
	$wp_customize->add_setting(
		'olively_hero_cta_url', array(
			'default'			=>	'',
			'sanitize_callback'	=>	'esc_url_raw'
		)
	);
	
	$wp_customize->add_control(
		'olively_hero_cta_url', array(
			'label'		=>	__('Call to Action URL', 'olively'),
			'section'	=>	'olively_header_options',
			'type'		=>	'url',
			'priority'	=>	9
		)
	);
	
	$wp_customize->add_setting(
		'olively_hero_cta_text', array(
			'default'		=>	'',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(
		'olively_hero_cta_text', array(
			'label'			=>	__('Call to Action Text', 'olively'),
			'section'		=>	'olively_header_options',
			'priority'		=>	9
		)
	);
	
	$wp_customize->add_setting(
		'olively_featured_page', array(
			'default'		=>	0,
			'sanitize_callback'	=>	'absint'
		)
	);
	
	$wp_customize->add_control(
		'olively_featured_page', array(
			'label'			=>	__('Featured Page', 'olively'),
			'description'	=>	__('Page to be featured in Header in Home Page', 'olively'),
			'type'			=>	'dropdown-pages',
			'section'		=>	'olively_header_options',
			'priority'		=>	10
		)
	);
	
	$wp_customize->selective_refresh->add_partial(
		'olively_featured_page', array(
			'selector'				=>	'#olively-featured-page',
			'render_callback'		=>	'olively_featured_page_refresh',
			'container_inclusive'	=>	true
		)
	);
}
 
add_action("customize_register", "olively_header_customize_register");
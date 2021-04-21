<?php
/**
 *	Front Page Controls
 */
 
function olively_front_page_controls( $wp_customize ) {
	
	$wp_customize->add_section(
		'olively_front_section', array(
			'title'			=>	esc_html__('Front Page', 'olively'),
			'description'	=>	esc_html__('Controls for the Front Page Template', 'olively'),
			'priority'		=>	5
		)
	);
	
	$wp_customize->add_setting(
		'olively_front_featured_cat', array(
			'default'			=> 0,
			'sanitize_callback'	=>	'absint'
		)
	);
	
	$wp_customize->add_control(
		new Olively_WP_Customize_Category_Control (
			$wp_customize, 'olively_front_featured_cat', array(
				'label'		=>	esc_html__('Featured Category', 'olively'),
				'section'	=>	'olively_front_section'
			)
		)
	);
	
	$wp_customize->add_setting(
		'olively_front_custom_post', array(
			'default'	=>	'',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(
		new Olively_WP_Custom_Post_Control (
			$wp_customize, 'olively_front_custom_post', array(
				'label'		=>	esc_html__('Featured Post', 'olively'),
				'section'	=>	'olively_front_section'
			)
		)
	);
}
add_action('customize_register', 'olively_front_page_controls');
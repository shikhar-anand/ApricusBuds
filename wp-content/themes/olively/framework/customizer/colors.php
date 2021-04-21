<?php
/**
 *	Color Controls
 */
 
function olively_color_customize_register( $wp_customize ) {
	
	$wp_customize->add_setting(
		'olively-theme-color', array(
			'default'			=>	'7a94ce',
			'sanitize_callback'	=>	'sanitize_hex_color'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'olively-theme-color', array(
				'label'		=>	__('Theme Color', 'olively'),
				'section'	=>	'colors',
				'settings'	=>	'olively-theme-color',
				'priority'	=>	30
			)	
		)
	);
	
	$wp_customize->add_setting(
		'olively-body-color', array(
			'default'			=>	'#000000',
			'sanitize_callback'	=>	'sanitize_hex_color'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'olively-body-color', array(
				'label'		=>	__('Body Color', 'olively'),
				'section'	=>	'colors',
				'settings'	=>	'olively-body-color',
				'priority'	=>	40
			)	
		)
	);
}
add_action('customize_register', 'olively_color_customize_register');
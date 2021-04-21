<?php
/**
 *	Customizer Controls for General Settings for the theme
 */
 
function olively_general_customize_register( $wp_customize ) {
	
	$wp_customize->add_section(
		"olively_general_options", array(
			"title"			=>	__("General", "olively"),
			"description"	=>	__("General Settings for the Theme", "olively"),
			"priority"		=>	5
		)
	);
	
	$wp_customize->add_setting(
        'olively_sidebar_width', array(
            'default'    =>  25,
            'sanitize_callback'  =>  'absint'
        )
    );

    $wp_customize->add_control(
        new Olively_Range_Value_Control(
            $wp_customize, 'olively_sidebar_width', array(
	            'label'         =>	esc_html__( 'Sidebar Width', 'olively' ),
            	'type'          => 'olively-range-value',
            	'section'       => 'olively_general_options',
            	'settings'      => 'olively_sidebar_width',
                'priority'		=>  5,
            	'input_attrs'   => array(
            		'min'            => 25,
            		'max'            => 40,
            		'step'           => 1,
            		'suffix'         => '%', //optional suffix
				),
            )
        )
    );
}
add_action("customize_register", "olively_general_customize_register");
<?php
/**
 * services Section options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

// Add services section
$wp_customize->add_section( 'stortech_services_section', array(
	'title'             => esc_html__( 'Services','stortech' ),
	'description'       => esc_html__( 'Services Section options.', 'stortech' ),
	'panel'             => 'stortech_front_page_panel',
) );

// services content enable control and setting
$wp_customize->add_setting( 'stortech_theme_options[services_section_enable]', array(
	'default'			=> 	$options['services_section_enable'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[services_section_enable]', array(
	'label'             => esc_html__( 'Services Section Enable', 'stortech' ),
	'section'           => 'stortech_services_section',
	'on_off_label' 		=> stortech_switch_options(),
) ) );



for ( $i = 1; $i <= 6; $i++ ) :
	// services pages drop down chooser control and setting
	$wp_customize->add_setting( 'stortech_theme_options[services_content_page_' . $i . ']', array(
		'sanitize_callback' => 'stortech_sanitize_page',
	) );

	$wp_customize->add_control( new Stortech_Dropdown_Chooser( $wp_customize, 'stortech_theme_options[services_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'stortech' ), $i ),
		'section'           => 'stortech_services_section',
		'choices'			=> stortech_page_choices(),
		'active_callback'	=> 'stortech_is_services_section_enable',
	) ) );


	$wp_customize->add_setting( 'stortech_theme_options[services_content_icon_' . $i . ']', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Stortech_Icon_Picker( $wp_customize, 'stortech_theme_options[services_content_icon_' . $i . ']', array(
        'label'             => sprintf( esc_html__( 'Select Icon %d', 'stortech' ), $i ),
        'section'           => 'stortech_services_section',
        'active_callback'   => 'stortech_is_services_section_enable',
    ) ) );

    $wp_customize->add_setting( 'stortech_theme_options[services_hr_'. $i .']', array(
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( new Stortech_Customize_Horizontal_Line( $wp_customize, 'stortech_theme_options[services_hr_'. $i .']',
        array(
            'section'           => 'stortech_services_section',
            'active_callback'   => 'stortech_is_services_section_enable',
            'type'            => 'hr'
    ) ) );
endfor;

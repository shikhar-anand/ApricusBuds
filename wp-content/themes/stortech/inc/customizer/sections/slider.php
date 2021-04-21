<?php
/**
 * Slider Section options
 *
 * @package Theme Palace
 * @subpackage stortech
 * @since stortech 1.0.0
 */

// Add Slider section
$wp_customize->add_section( 'stortech_slider_section', array(
	'title'             => esc_html__( 'Main Slider','stortech' ),
	'description'       => esc_html__( 'Slider Section options.', 'stortech' ),
	'panel'             => 'stortech_front_page_panel',

) );

// Slider content enable control and setting
$wp_customize->add_setting( 'stortech_theme_options[slider_section_enable]', array(
	'default'			=> 	$options['slider_section_enable'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[slider_section_enable]', array(
	'label'             => esc_html__( 'Slider Section Enable', 'stortech' ),
	'section'           => 'stortech_slider_section',
	'on_off_label' 		=> stortech_switch_options(),
) ) );

// Slider content enable control and setting
$wp_customize->add_setting( 'stortech_theme_options[slider_autoplay]', array(
	'default'			=> 	$options['slider_autoplay'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[slider_autoplay]', array(
	'label'             => esc_html__( 'Auto Play Enable', 'stortech' ),
	'section'           => 'stortech_slider_section',
	'on_off_label' 		=> stortech_switch_options(),
	'active_callback' 	=> 'stortech_is_slider_section_enable',
) ) );

$wp_customize->add_setting( 'stortech_theme_options[slider_btn_label]', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'			=> $options['slider_btn_label'],
) );

$wp_customize->add_control( 'stortech_theme_options[slider_btn_label]', array(
	'label'           	=> esc_html__( 'Slider Button Lable', 'stortech' ),
	'section'        	=> 'stortech_slider_section',
	'active_callback' 	=> 'stortech_is_slider_section_enable',
	'type'				=> 'text',
) );


for ( $i = 1; $i <= 3; $i++ ) :
	// slider pages drop down chooser control and setting
	$wp_customize->add_setting( 'stortech_theme_options[slider_content_page_' . $i . ']', array(
		'sanitize_callback' => 'stortech_sanitize_page',
	) );

	$wp_customize->add_control( new Stortech_Dropdown_Chooser( $wp_customize, 'stortech_theme_options[slider_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'stortech' ), $i ),
		'section'           => 'stortech_slider_section',
		'choices'			=> stortech_page_choices(),
		'active_callback'	=> 'stortech_is_slider_section_enable',
	) ) );
endfor;
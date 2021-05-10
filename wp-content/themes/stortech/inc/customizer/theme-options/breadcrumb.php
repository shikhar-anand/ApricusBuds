<?php
/**
 * Breadcrumb options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

$wp_customize->add_section( 'stortech_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','stortech' ),
	'description'       => esc_html__( 'Breadcrumb section options.', 'stortech' ),
	'panel'             => 'stortech_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'stortech_theme_options[breadcrumb_enable]', array(
	'sanitize_callback' => 'stortech_sanitize_switch_control',
	'default'          	=> $options['breadcrumb_enable'],
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[breadcrumb_enable]', array(
	'label'            	=> esc_html__( 'Enable Breadcrumb', 'stortech' ),
	'section'          	=> 'stortech_breadcrumb',
	'on_off_label' 		=> stortech_switch_options(),
) ) );

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'stortech_theme_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
) );

$wp_customize->add_control( 'stortech_theme_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'stortech' ),
	'active_callback' 	=> 'stortech_is_breadcrumb_enable',
	'section'          	=> 'stortech_breadcrumb',
	'type'				=> 'text'
) );

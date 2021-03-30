<?php
/**
 * pagination options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'stortech_pagination', array(
	'title'               => esc_html__('Pagination','stortech'),
	'description'         => esc_html__( 'Pagination section options.', 'stortech' ),
	'panel'               => 'stortech_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'stortech_theme_options[pagination_enable]', array(
	'sanitize_callback' => 'stortech_sanitize_switch_control',
	'default'             => $options['pagination_enable'],
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[pagination_enable]', array(
	'label'               => esc_html__( 'Pagination Enable', 'stortech' ),
	'section'             => 'stortech_pagination',
	'on_off_label' 		=> stortech_switch_options(),
) ) );

// Site layout setting and control.
$wp_customize->add_setting( 'stortech_theme_options[pagination_type]', array(
	'sanitize_callback'   => 'stortech_sanitize_select',
	'default'             => $options['pagination_type'],
) );

$wp_customize->add_control( 'stortech_theme_options[pagination_type]', array(
	'label'               => esc_html__( 'Pagination Type', 'stortech' ),
	'section'             => 'stortech_pagination',
	'type'                => 'select',
	'choices'			  => stortech_pagination_options(),
	'active_callback'	  => 'stortech_is_pagination_enable',
) );

<?php
/**
 * Layout options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'stortech_layout', array(
	'title'               => esc_html__('Layout','stortech'),
	'description'         => esc_html__( 'Layout section options.', 'stortech' ),
	'panel'               => 'stortech_theme_options_panel',
) );

// Site layout setting and control.
$wp_customize->add_setting( 'stortech_theme_options[site_layout]', array(
	'sanitize_callback'   => 'stortech_sanitize_select',
	'default'             => $options['site_layout'],
) );

$wp_customize->add_control(  new Stortech_Custom_Radio_Image_Control ( $wp_customize, 'stortech_theme_options[site_layout]', array(
	'label'               => esc_html__( 'Site Layout', 'stortech' ),
	'section'             => 'stortech_layout',
	'choices'			  => stortech_site_layout(),
) ) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'stortech_theme_options[sidebar_position]', array(
	'sanitize_callback'   => 'stortech_sanitize_select',
	'default'             => $options['sidebar_position'],
) );

$wp_customize->add_control(  new Stortech_Custom_Radio_Image_Control ( $wp_customize, 'stortech_theme_options[sidebar_position]', array(
	'label'               => esc_html__( 'Global Sidebar Position', 'stortech' ),
	'section'             => 'stortech_layout',
	'choices'			  => stortech_global_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'stortech_theme_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'stortech_sanitize_select',
	'default'             => $options['post_sidebar_position'],
) );

$wp_customize->add_control(  new Stortech_Custom_Radio_Image_Control ( $wp_customize, 'stortech_theme_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Position', 'stortech' ),
	'section'             => 'stortech_layout',
	'choices'			  => stortech_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'stortech_theme_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'stortech_sanitize_select',
	'default'             => $options['page_sidebar_position'],
) );

$wp_customize->add_control( new Stortech_Custom_Radio_Image_Control( $wp_customize, 'stortech_theme_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Position', 'stortech' ),
	'section'             => 'stortech_layout',
	'choices'			  => stortech_sidebar_position(),
) ) );
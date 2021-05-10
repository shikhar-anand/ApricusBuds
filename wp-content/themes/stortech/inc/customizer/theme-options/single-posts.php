<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'stortech_single_post_section', array(
	'title'             => esc_html__( 'Single Post','stortech' ),
	'description'       => esc_html__( 'Options to change the single posts globally.', 'stortech' ),
	'panel'             => 'stortech_theme_options_panel',
) );

// Tourableve date meta setting and control.
$wp_customize->add_setting( 'stortech_theme_options[single_post_hide_date]', array(
	'default'           => $options['single_post_hide_date'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[single_post_hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'stortech' ),
	'section'           => 'stortech_single_post_section',
	'on_off_label' 		=> stortech_hide_options(),
) ) );

// Tourableve author meta setting and control.
$wp_customize->add_setting( 'stortech_theme_options[single_post_hide_author]', array(
	'default'           => $options['single_post_hide_author'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[single_post_hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'stortech' ),
	'section'           => 'stortech_single_post_section',
	'on_off_label' 		=> stortech_hide_options(),
) ) );

// Tourableve author category setting and control.
$wp_customize->add_setting( 'stortech_theme_options[single_post_hide_category]', array(
	'default'           => $options['single_post_hide_category'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[single_post_hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'stortech' ),
	'section'           => 'stortech_single_post_section',
	'on_off_label' 		=> stortech_hide_options(),
) ) );

// Tourableve tag category setting and control.
$wp_customize->add_setting( 'stortech_theme_options[single_post_hide_tags]', array(
	'default'           => $options['single_post_hide_tags'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[single_post_hide_tags]', array(
	'label'             => esc_html__( 'Hide Tag', 'stortech' ),
	'section'           => 'stortech_single_post_section',
	'on_off_label' 		=> stortech_hide_options(),
) ) );

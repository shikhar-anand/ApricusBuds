<?php
/**
 * Archive options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

// Add archive section
$wp_customize->add_section( 'stortech_archive_section', array(
	'title'             => esc_html__( 'Blog/Archive','stortech' ),
	'description'       => esc_html__( 'Archive section options.', 'stortech' ),
	'panel'             => 'stortech_theme_options_panel',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'stortech_theme_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'stortech_theme_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'stortech' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'stortech' ),
	'section'           => 'stortech_archive_section',
	'type'				=> 'text',
	'active_callback'   => 'stortech_is_latest_posts'
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'stortech_theme_options[hide_date]', array(
	'default'           => $options['hide_date'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'stortech' ),
	'section'           => 'stortech_archive_section',
	'on_off_label' 		=> stortech_hide_options(),
) ) );

// Archive category setting and control.
$wp_customize->add_setting( 'stortech_theme_options[hide_category]', array(
	'default'           => $options['hide_category'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'stortech' ),
	'section'           => 'stortech_archive_section',
	'on_off_label' 		=> stortech_hide_options(),
) ) );

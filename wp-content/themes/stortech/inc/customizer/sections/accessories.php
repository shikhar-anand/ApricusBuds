<?php
/**
 * Accessories Section options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

// Add Accessories section
$wp_customize->add_section( 'stortech_accessories_section', array(
	'title'             => esc_html__( 'Accessories','stortech' ),
	'description'       => esc_html__( 'Accessories Section options.', 'stortech' ),
	'panel'             => 'stortech_front_page_panel',
) );

// Accessories content enable control and setting
$wp_customize->add_setting( 'stortech_theme_options[accessories_section_enable]', array(
	'default'			=> 	$options['accessories_section_enable'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[accessories_section_enable]', array(
	'label'             => esc_html__( 'Accessories Section Enable', 'stortech' ),
	'section'           => 'stortech_accessories_section',
	'on_off_label' 		=> stortech_switch_options(),
) ) );

$wp_customize->add_setting( 'stortech_theme_options[accessories_btn_label]', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'			=> $options['accessories_btn_label'],
) );

$wp_customize->add_control( 'stortech_theme_options[accessories_btn_label]', array(
	'label'           	=> esc_html__( 'Accessories Button Lable', 'stortech' ),
	'section'        	=> 'stortech_accessories_section',
	'active_callback' 	=> 'stortech_is_accessories_section_enable',
	'type'				=> 'text',
) );

// Accessories content type control and setting
$wp_customize->add_setting( 'stortech_theme_options[accessories_content_type]', array(
	'default'          	=> $options['accessories_content_type'],
	'sanitize_callback' => 'stortech_sanitize_select',
) );

$wp_customize->add_control( 'stortech_theme_options[accessories_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'stortech' ),
	'section'           => 'stortech_accessories_section',
	'type'				=> 'select',
	'active_callback' 	=> 'stortech_is_accessories_section_enable',
	'choices'			=> stortech_accessories_product_content_type(),
) );

for ( $i = 1; $i <= 5; $i++ ) :
	// accessories pages drop down chooser control and setting
	$wp_customize->add_setting( 'stortech_theme_options[accessories_content_page_' . $i . ']', array(
		'sanitize_callback' => 'stortech_sanitize_page',
	) );

	$wp_customize->add_control( new Stortech_Dropdown_Chooser( $wp_customize, 'stortech_theme_options[accessories_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'stortech' ), $i ),
		'section'           => 'stortech_accessories_section',
		'choices'			=> stortech_page_choices(),
		'active_callback'	=> 'stortech_is_accessories_section_content_page_enable',
	) ) );

	$wp_customize->add_setting( 'stortech_theme_options[accessories_product_content_page_' . $i . ']', array(
		'sanitize_callback' => 'stortech_sanitize_page',
	) );

	$wp_customize->add_control( new Stortech_Dropdown_Chooser( $wp_customize, 'stortech_theme_options[accessories_product_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Product %d', 'stortech' ), $i ),
		'section'           => 'stortech_accessories_section',
		'choices'			=> stortech_product_choices(),
		'active_callback'	=> 'stortech_is_accessories_product_section_content_product_enable',
	) ) );
endfor;
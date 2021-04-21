<?php
/**
 * Testimonial Section options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

// Add Testimonial section
$wp_customize->add_section( 'stortech_testimonial_section', array(
	'title'             => esc_html__( 'Testimonial','stortech' ),
	'description'       => esc_html__( 'Testimonial Section options.', 'stortech' ),
	'panel'             => 'stortech_front_page_panel',
) );

// Testimonial content enable control and setting
$wp_customize->add_setting( 'stortech_theme_options[testimonial_section_enable]', array(
	'default'			=> 	$options['testimonial_section_enable'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[testimonial_section_enable]', array(
	'label'             => esc_html__( 'Testimonial Section Enable', 'stortech' ),
	'section'           => 'stortech_testimonial_section',
	'on_off_label' 		=> stortech_switch_options(),
) ) );



for ( $i = 1; $i <= 3; $i++ ) :
	// testimonial pages drop down chooser control and setting
	$wp_customize->add_setting( 'stortech_theme_options[testimonial_content_page_' . $i . ']', array(
		'sanitize_callback' => 'stortech_sanitize_page',
	) );

	$wp_customize->add_control( new Stortech_Dropdown_Chooser( $wp_customize, 'stortech_theme_options[testimonial_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'stortech' ), $i ),
		'section'           => 'stortech_testimonial_section',
		'choices'			=> stortech_page_choices(),
		'active_callback'	=> 'stortech_is_testimonial_section_enable',
	) ) );
endfor;
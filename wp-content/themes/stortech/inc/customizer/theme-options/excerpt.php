<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'stortech_excerpt_section', array(
	'title'             => esc_html__( 'Excerpt','stortech' ),
	'description'       => esc_html__( 'Excerpt section options.', 'stortech' ),
	'panel'             => 'stortech_theme_options_panel',
) );


// long Excerpt length setting and control.
$wp_customize->add_setting( 'stortech_theme_options[long_excerpt_length]', array(
	'sanitize_callback' => 'stortech_sanitize_number_range',
	'validate_callback' => 'stortech_validate_long_excerpt',
	'default'			=> $options['long_excerpt_length'],
) );

$wp_customize->add_control( 'stortech_theme_options[long_excerpt_length]', array(
	'label'       		=> esc_html__( 'Blog Page Excerpt Length', 'stortech' ),
	'description' 		=> esc_html__( 'Total words to be displayed in archive page/search page.', 'stortech' ),
	'section'     		=> 'stortech_excerpt_section',
	'type'        		=> 'number',
	'input_attrs' 		=> array(
		'style'       => 'width: 80px;',
		'max'         => 100,
		'min'         => 5,
	),
) );

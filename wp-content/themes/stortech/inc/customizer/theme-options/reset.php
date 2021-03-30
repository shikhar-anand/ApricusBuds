<?php
/**
 * Reset options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

/**
* Reset section
*/
// Add reset enable section
$wp_customize->add_section( 'stortech_reset_section', array(
	'title'             => esc_html__('Reset all settings','stortech'),
	'description'       => esc_html__( 'Caution: All settings will be reset to default. Refresh the page after clicking Save & Publish.', 'stortech' ),
) );

// Add reset enable setting and control.
$wp_customize->add_setting( 'stortech_theme_options[reset_options]', array(
	'default'           => $options['reset_options'],
	'sanitize_callback' => 'stortech_sanitize_checkbox',
	'transport'			  => 'postMessage',
) );

$wp_customize->add_control( 'stortech_theme_options[reset_options]', array(
	'label'             => esc_html__( 'Check to reset all settings', 'stortech' ),
	'section'           => 'stortech_reset_section',
	'type'              => 'checkbox',
) );

<?php
/**
 * Footer options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

// Footer Section
$wp_customize->add_section( 'stortech_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'stortech' ),
		'priority'   			=> 900,
		'panel'      			=> 'stortech_theme_options_panel',
	)
);

// footer text
$wp_customize->add_setting( 'stortech_theme_options[copyright_text]',
	array(
		'default'       		=> $options['copyright_text'],
		'sanitize_callback'		=> 'stortech_santize_allow_tag',
		'transport'				=> 'postMessage',
	)
);
$wp_customize->add_control( 'stortech_theme_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Copyright Text', 'stortech' ),
		'section'    			=> 'stortech_section_footer',
		'type'		 			=> 'textarea',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'stortech_theme_options[copyright_text]', array(
		'selector'            => '.site-info .wrapper span',
		'settings'            => 'stortech_theme_options[copyright_text]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'stortech_copyright_text_partial',
    ) );
}

// scroll top visible
$wp_customize->add_setting( 'stortech_theme_options[scroll_top_visible]',
	array(
		'default'       		=> $options['scroll_top_visible'],
		'sanitize_callback' => 'stortech_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[scroll_top_visible]',
    array(
		'label'      			=> esc_html__( 'Display Scroll Top Button', 'stortech' ),
		'section'    			=> 'stortech_section_footer',
		'on_off_label' 		=> stortech_switch_options(),
    )
) );


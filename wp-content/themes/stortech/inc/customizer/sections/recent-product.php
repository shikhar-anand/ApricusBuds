<?php
/**
 * recent_product Section options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */
if ( !class_exists('WooCommerce') ) {
	return;
}
// Add recent_product section
$wp_customize->add_section( 'stortech_recent_product_section', array(
	'title'             => esc_html__( 'Recent Product Section','stortech' ),
	'description'       => esc_html__( 'Recent Product Section Section options.', 'stortech' ),
	'panel'             => 'stortech_front_page_panel',
) );

// recent_product content enable control and setting
$wp_customize->add_setting( 'stortech_theme_options[recent_product_section_enable]', array(
	'default'			=> 	$options['recent_product_section_enable'],
	'sanitize_callback' => 'stortech_sanitize_switch_control',
) );

$wp_customize->add_control( new Stortech_Switch_Control( $wp_customize, 'stortech_theme_options[recent_product_section_enable]', array(
	'label'             => esc_html__( 'Recent product Section Enable', 'stortech' ),
	'section'           => 'stortech_recent_product_section',
	'on_off_label' 		=> stortech_switch_options(),
) ) );


// recent_product title setting and control
$wp_customize->add_setting( 'stortech_theme_options[recent_product_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['recent_product_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'stortech_theme_options[recent_product_title]', array(
	'label'           	=> esc_html__( 'Title', 'stortech' ),
	'section'        	=> 'stortech_recent_product_section',
	'active_callback' 	=> 'stortech_is_recent_product_section_enable',
	'type'				=> 'text',
) );




// recent_product title setting and control
$wp_customize->add_setting( 'stortech_theme_options[recent_product_subtitle]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['recent_product_subtitle'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'stortech_theme_options[recent_product_subtitle]', array(
	'label'           	=> esc_html__( 'Title', 'stortech' ),
	'section'        	=> 'stortech_recent_product_section',
	'active_callback' 	=> 'stortech_is_recent_product_section_enable',
	'type'				=> 'text',
) );



$wp_customize->add_setting( 'stortech_theme_options[recent_product_content_type]', array(
	'default'          	=> $options['recent_product_content_type'],
	'sanitize_callback' => 'stortech_sanitize_select',
) );

$wp_customize->add_control( 'stortech_theme_options[recent_product_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'stortech' ),
	'section'           => 'stortech_recent_product_section',
	'type'				=> 'select',
	'active_callback' 	=> 'stortech_is_recent_product_section_enable',
	'choices'			=> array(
		'product'           => esc_html__( 'Product', 'stortech' ),
	    'recent_product'    => esc_html__( 'Recent Product', 'stortech' ),
	),
) );

for( $i = 1 ; $i <= 8 ; $i++ ){

	$wp_customize->add_setting( 'stortech_theme_options[recent_product_content_page_' . $i . ']', array(
		'sanitize_callback' => 'stortech_sanitize_page',
	) );

	$wp_customize->add_control( new Stortech_Dropdown_Chooser( $wp_customize, 'stortech_theme_options[recent_product_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Product %d', 'stortech' ), $i ),
		'section'           => 'stortech_recent_product_section',
		'choices'			=> stortech_product_choices(),
		'active_callback'	=> 'stortech_is_recent_product_section_enable',
	) ) );
}

$wp_customize->add_setting( 'stortech_theme_options[recent_btn_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'stortech_theme_options[recent_btn_label]', array(
	'label'           	=>  esc_html__( 'Recent ProductButton Lable', 'stortech' ),
	'section'        	=> 'stortech_recent_product_section',
	'active_callback' 	=> 'stortech_is_recent_product_section_enable',
	'type'				=> 'text',
) );

$wp_customize->add_setting( 'stortech_theme_options[recent_btn_url]', array(
	'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( 'stortech_theme_options[recent_btn_url]', array(
	'label'           	=>  esc_html__( 'Recent ProductButton Link ', 'stortech' ),
	'section'        	=> 'stortech_recent_product_section',
	'active_callback' 	=> 'stortech_is_recent_product_section_enable',
	'type'				=> 'url',
) );
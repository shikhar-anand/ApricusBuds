<?php
/**
 * Tafri Travel Theme Customizer
 *
 * @package tafri-travel
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function tafri_travel_custom_controls() {

	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-control.php' );
}

add_action( 'customize_register', 'tafri_travel_custom_controls' );

function tafri_travel_customize_register($wp_customize) {

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-changer.php' );

	//add home page setting pannel
	$wp_customize->add_panel('tafri_travel_panel_id', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Theme Settings', 'tafri-travel'),
		'description'    => __('Description of what this panel does.', 'tafri-travel'),
	));	

	// font array
	$tafri_travel_font_array = array(
        '' => 'No Fonts',
        'Abril Fatface' => 'Abril Fatface',
        'Acme' => 'Acme',
        'Anton' => 'Anton',
        'Architects Daughter' => 'Architects Daughter',
        'Arimo' => 'Arimo',
        'Arsenal' => 'Arsenal', 
        'Arvo' => 'Arvo',
        'Alegreya' => 'Alegreya',
        'Alfa Slab One' => 'Alfa Slab One',
        'Averia Serif Libre' => 'Averia Serif Libre',
        'Bangers' => 'Bangers', 
        'Boogaloo' => 'Boogaloo',
        'Bad Script' => 'Bad Script',
        'Bitter' => 'Bitter',
        'Bree Serif' => 'Bree Serif',
        'BenchNine' => 'BenchNine', 
        'Cabin' => 'Cabin', 
        'Cardo' => 'Cardo',
        'Courgette' => 'Courgette',
        'Cherry Swash' => 'Cherry Swash',
        'Cormorant Garamond' => 'Cormorant Garamond',
        'Crimson Text' => 'Crimson Text',
        'Cuprum' => 'Cuprum', 
        'Cookie' => 'Cookie', 
        'Chewy' => 'Chewy', 
        'Days One' => 'Days One', 
        'Dosis' => 'Dosis',
        'Droid Sans' => 'Droid Sans',
        'Economica' => 'Economica',
        'Fredoka One' => 'Fredoka One',
        'Fjalla One' => 'Fjalla One',
        'Francois One' => 'Francois One',
        'Frank Ruhl Libre' => 'Frank Ruhl Libre',
        'Gloria Hallelujah' => 'Gloria Hallelujah',
        'Great Vibes' => 'Great Vibes',
        'Handlee' => 'Handlee', 
        'Hammersmith One' => 'Hammersmith One',
        'Inconsolata' => 'Inconsolata', 
        'Indie Flower' => 'Indie Flower', 
        'IM Fell English SC' => 'IM Fell English SC', 
        'Julius Sans One' => 'Julius Sans One',
        'Josefin Slab' => 'Josefin Slab', 
        'Josefin Sans' => 'Josefin Sans', 
        'Kanit' => 'Kanit', 
        'Lobster' => 'Lobster', 
        'Lato' => 'Lato',
        'Lora' => 'Lora', 
        'Libre Baskerville' =>'Libre Baskerville',
        'Lobster Two' => 'Lobster Two',
        'Merriweather' =>'Merriweather', 
        'Monda' => 'Monda',
        'Montserrat' => 'Montserrat',
        'Muli' => 'Muli', 
        'Marck Script' => 'Marck Script',
        'Noto Serif' => 'Noto Serif',
        'Open Sans' => 'Open Sans', 
        'Overpass' => 'Overpass',
        'Overpass Mono' => 'Overpass Mono',
        'Oxygen' => 'Oxygen', 
        'Orbitron' => 'Orbitron', 
        'Patua One' => 'Patua One', 
        'Pacifico' => 'Pacifico',
        'Padauk' => 'Padauk', 
        'Playball' => 'Playball',
        'Playfair Display' => 'Playfair Display', 
        'PT Sans' => 'PT Sans',
        'Philosopher' => 'Philosopher',
        'Permanent Marker' => 'Permanent Marker',
        'Poiret One' => 'Poiret One', 
        'Quicksand' => 'Quicksand', 
        'Quattrocento Sans' => 'Quattrocento Sans', 
        'Raleway' => 'Raleway', 
        'Rubik' => 'Rubik', 
        'Rokkitt' => 'Rokkitt', 
        'Russo One' => 'Russo One', 
        'Righteous' => 'Righteous', 
        'Slabo' => 'Slabo', 
        'Source Sans Pro' => 'Source Sans Pro', 
        'Shadows Into Light Two' =>'Shadows Into Light Two', 
        'Shadows Into Light' => 'Shadows Into Light', 
        'Sacramento' => 'Sacramento', 
        'Shrikhand' => 'Shrikhand', 
        'Tangerine' => 'Tangerine',
        'Ubuntu' => 'Ubuntu', 
        'VT323' => 'VT323', 
        'Varela Round' => 'Varela Round', 
        'Vampiro One' => 'Vampiro One',
        'Vollkorn' => 'Vollkorn',
        'Volkhov' => 'Volkhov', 
        'Yanone Kaffeesatz' => 'Yanone Kaffeesatz',
        'Merienda One' => 'Merienda One',
    );
    
	//Typography
	$wp_customize->add_section( 'tafri_travel_typography', array(
    	'title'      => __( 'Color / Fonts Settings', 'tafri-travel' ),
		'panel' => 'tafri_travel_panel_id'
	) );
	
	// This is Paragraph Color picker setting
	$wp_customize->add_setting( 'tafri_travel_paragraph_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_paragraph_color', array(
		'label' => __('Paragraph Color', 'tafri-travel'),
		'section' => 'tafri_travel_typography',
		'settings' => 'tafri_travel_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('tafri_travel_paragraph_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control(
	    'tafri_travel_paragraph_font_family', array(
	    'section'  => 'tafri_travel_typography',
	    'label'    => __( 'Paragraph Fonts','tafri-travel'),
	    'type'     => 'select',
	    'choices'  => $tafri_travel_font_array,
	));

	$wp_customize->add_setting('tafri_travel_paragraph_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_paragraph_font_size',array(
		'label'	=> __('Paragraph Font Size','tafri-travel'),
		'section'	=> 'tafri_travel_typography',
		'setting'	=> 'tafri_travel_paragraph_font_size',
		'type'	=> 'text'
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'tafri_travel_atag_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_atag_color', array(
		'label' => __('"a" Tag Color', 'tafri-travel'),
		'section' => 'tafri_travel_typography',
		'settings' => 'tafri_travel_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('tafri_travel_atag_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control(
	    'tafri_travel_atag_font_family', array(
	    'section'  => 'tafri_travel_typography',
	    'label'    => __( '"a" Tag Fonts','tafri-travel'),
	    'type'     => 'select',
	    'choices'  => $tafri_travel_font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'tafri_travel_li_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_li_color', array(
		'label' => __('"li" Tag Color', 'tafri-travel'),
		'section' => 'tafri_travel_typography',
		'settings' => 'tafri_travel_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('tafri_travel_li_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control(
	    'tafri_travel_li_font_family', array(
	    'section'  => 'tafri_travel_typography',
	    'label'    => __( '"li" Tag Fonts','tafri-travel'),
	    'type'     => 'select',
	    'choices'  => $tafri_travel_font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting( 'tafri_travel_h1_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_h1_color', array(
		'label' => __('H1 Color', 'tafri-travel'),
		'section' => 'tafri_travel_typography',
		'settings' => 'tafri_travel_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('tafri_travel_h1_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control(
	    'tafri_travel_h1_font_family', array(
	    'section'  => 'tafri_travel_typography',
	    'label'    => __( 'H1 Fonts','tafri-travel'),
	    'type'     => 'select',
	    'choices'  => $tafri_travel_font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('tafri_travel_h1_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_h1_font_size',array(
		'label'	=> __('H1 Font Size','tafri-travel'),
		'section'	=> 'tafri_travel_typography',
		'setting'	=> 'tafri_travel_h1_font_size',
		'type'	=> 'text'
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting( 'tafri_travel_h2_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_h2_color', array(
		'label' => __('h2 Color', 'tafri-travel'),
		'section' => 'tafri_travel_typography',
		'settings' => 'tafri_travel_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('tafri_travel_h2_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control(
	    'tafri_travel_h2_font_family', array(
	    'section'  => 'tafri_travel_typography',
	    'label'    => __( 'h2 Fonts','tafri-travel'),
	    'type'     => 'select',
	    'choices'  => $tafri_travel_font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('tafri_travel_h2_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_h2_font_size',array(
		'label'	=> __('h2 Font Size','tafri-travel'),
		'section'	=> 'tafri_travel_typography',
		'setting'	=> 'tafri_travel_h2_font_size',
		'type'	=> 'text'
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting( 'tafri_travel_h3_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_h3_color', array(
		'label' => __('h3 Color', 'tafri-travel'),
		'section' => 'tafri_travel_typography',
		'settings' => 'tafri_travel_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('tafri_travel_h3_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control(
	    'tafri_travel_h3_font_family', array(
	    'section'  => 'tafri_travel_typography',
	    'label'    => __( 'h3 Fonts','tafri-travel'),
	    'type'     => 'select',
	    'choices'  => $tafri_travel_font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('tafri_travel_h3_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_h3_font_size',array(
		'label'	=> __('h3 Font Size','tafri-travel'),
		'section'	=> 'tafri_travel_typography',
		'setting'	=> 'tafri_travel_h3_font_size',
		'type'	=> 'text'
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting( 'tafri_travel_h4_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_h4_color', array(
		'label' => __('h4 Color', 'tafri-travel'),
		'section' => 'tafri_travel_typography',
		'settings' => 'tafri_travel_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('tafri_travel_h4_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control(
	    'tafri_travel_h4_font_family', array(
	    'section'  => 'tafri_travel_typography',
	    'label'    => __( 'h4 Fonts','tafri-travel'),
	    'type'     => 'select',
	    'choices'  => $tafri_travel_font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('tafri_travel_h4_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_h4_font_size',array(
		'label'	=> __('h4 Font Size','tafri-travel'),
		'section'	=> 'tafri_travel_typography',
		'setting'	=> 'tafri_travel_h4_font_size',
		'type'	=> 'text'
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting( 'tafri_travel_h5_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_h5_color', array(
		'label' => __('h5 Color', 'tafri-travel'),
		'section' => 'tafri_travel_typography',
		'settings' => 'tafri_travel_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('tafri_travel_h5_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control(
	    'tafri_travel_h5_font_family', array(
	    'section'  => 'tafri_travel_typography',
	    'label'    => __( 'h5 Fonts','tafri-travel'),
	    'type'     => 'select',
	    'choices'  => $tafri_travel_font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('tafri_travel_h5_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_h5_font_size',array(
		'label'	=> __('h5 Font Size','tafri-travel'),
		'section'	=> 'tafri_travel_typography',
		'setting'	=> 'tafri_travel_h5_font_size',
		'type'	=> 'text'
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting( 'tafri_travel_h6_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_h6_color', array(
		'label' => __('h6 Color', 'tafri-travel'),
		'section' => 'tafri_travel_typography',
		'settings' => 'tafri_travel_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('tafri_travel_h6_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control(
	    'tafri_travel_h6_font_family', array(
	    'section'  => 'tafri_travel_typography',
	    'label'    => __( 'h6 Fonts','tafri-travel'),
	    'type'     => 'select',
	    'choices'  => $tafri_travel_font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('tafri_travel_h6_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_h6_font_size',array(
		'label'	=> __('h6 Font Size','tafri-travel'),
		'section'	=> 'tafri_travel_typography',
		'setting'	=> 'tafri_travel_h6_font_size',
		'type'	=> 'text'
	));

	// background skin mode
	$wp_customize->add_setting('tafri_travel_background_image_type',array(
        'default' => 'Transparent',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_background_image_type',array(
        'type' => 'radio',
        'label' => __('Background Skin Mode','tafri-travel'),
        'section' => 'background_image',
        'choices' => array(
            'Transparent' => __('Transparent','tafri-travel'),
            'Background' => __('Background','tafri-travel'),
        ),
	) );

	// Add the Theme Color Option section.
	$wp_customize->add_section( 'tafri_travel_theme_color_option', array( 
		'panel' => 'tafri_travel_panel_id', 
		'title' => esc_html__( 'Theme Color Option', 'tafri-travel' 
	) )	);

  	$wp_customize->add_setting( 'tafri_travel_first_theme_color', array(
	    'default' => '#26bdf7',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_theme_color', array(
  		'label' => __('First Color Option','tafri-travel'),
	    'description' => __('One can change complete theme color on just one click.', 'tafri-travel'),
	    'section' => 'tafri_travel_theme_color_option',
	    'settings' => 'tafri_travel_first_theme_color',
  	)));

  	$wp_customize->add_setting( 'tafri_travel_second_theme_color', array(
	    'default' => '#0f2036',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_second_theme_color', array(
  		'label' => __('Second Color Option','tafri-travel'),
	    'description' => __('One can change complete theme color on just one click.', 'tafri-travel'),
	    'section' => 'tafri_travel_theme_color_option',
	    'settings' => 'tafri_travel_second_theme_color',
  	)));

  	// woocommerce Options
	$wp_customize->add_section( 'tafri_travel_shop_page_options', array(
    	'title'      => __( 'Shop Page Settings', 'tafri-travel' ),
		'panel' => 'tafri_travel_panel_id'
	) );

	$wp_customize->add_setting('tafri_travel_display_related_products',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_display_related_products',array(
       'type' => 'checkbox',
       'label' => __('Related Product','tafri-travel'),
       'section' => 'tafri_travel_shop_page_options',
    ));

    $wp_customize->add_setting('tafri_travel_shop_products_border',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_shop_products_border',array(
       'type' => 'checkbox',
       'label' => __('Product Border','tafri-travel'),
       'section' => 'tafri_travel_shop_page_options',
    ));

	$wp_customize->add_setting( 'tafri_travel_woocommerce_product_per_columns' , array(
		'default'           => 3,
		'transport'         => 'refresh',
		'sanitize_callback' => 'tafri_travel_sanitize_choices',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'tafri_travel_woocommerce_product_per_columns', array(
		'label'    => __( 'Total Products Per Columns', 'tafri-travel' ),
		'section'  => 'tafri_travel_shop_page_options',
		'type'     => 'radio',
		'choices'  => array(
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
		),
	) ) );

	$wp_customize->add_setting('tafri_travel_woocommerce_product_per_page',array(
		'default'	=> 9,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));	
	$wp_customize->add_control('tafri_travel_woocommerce_product_per_page',array(
		'label'	=> __('Total Products Per Page','tafri-travel'),
		'section'	=> 'tafri_travel_shop_page_options',
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'tafri_travel_shop_page_top_padding',array(
		'default' => 0,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control( 'tafri_travel_shop_page_top_padding',	array(
		'label' => esc_html__( 'Product Padding (Top Bottom)','tafri-travel' ),
		'section' => 'tafri_travel_shop_page_options',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'tafri_travel_shop_page_left_padding',array(
		'default' => 0,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control( 'tafri_travel_shop_page_left_padding',	array(
		'label' => esc_html__( 'Product Padding (Right Left)','tafri-travel' ),
		'section' => 'tafri_travel_shop_page_options',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'tafri_travel_shop_page_border_radius',array(
		'default' => 0,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_shop_page_border_radius',array(
		'label' => esc_html__( 'Product Border Radius','tafri-travel' ),
		'section' => 'tafri_travel_shop_page_options',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'tafri_travel_shop_page_box_shadow',array(
		'default' => 0,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_shop_page_box_shadow',array(
		'label' => esc_html__( 'Product Shadow','tafri-travel' ),
		'section' => 'tafri_travel_shop_page_options',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'tafri_travel_shop_button_padding_top',array(
		'default' => 10,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_shop_button_padding_top',	array(
		'label' => esc_html__( 'Button Padding (Top Bottom)','tafri-travel' ),
		'section' => 'tafri_travel_shop_page_options',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number',

	));

	$wp_customize->add_setting( 'tafri_travel_shop_button_padding_left',array(
		'default' => 16,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_shop_button_padding_left',array(
		'label' => esc_html__( 'Button Padding (Right Left)','tafri-travel' ),
		'section' => 'tafri_travel_shop_page_options',
		'type'		=> 'number',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting( 'tafri_travel_shop_button_border_radius',array(
		'default' => 0,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_shop_button_border_radius',array(
		'label' => esc_html__( 'Button Border Radius','tafri-travel' ),
		'section' => 'tafri_travel_shop_page_options',
		'type'		=> 'number',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting('tafri_travel_align_product_sale',array(
        'default' => 'Right',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_align_product_sale',array(
        'type' => 'radio',
        'label' => __('Product Sale Alignment','tafri-travel'),
        'section' => 'tafri_travel_shop_page_options',
        'choices' => array(
            'Right' => __('Right','tafri-travel'),
            'Left' => __('Left','tafri-travel'),
        ),
	) );

	$wp_customize->add_setting( 'tafri_travel_border_radius_product_sale',array(
		'default' => 0,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_border_radius_product_sale', array(
        'label'  => __('Product Sale Border Radius','tafri-travel'),
        'section'  => 'tafri_travel_shop_page_options',
        'type'        => 'number',
        'input_attrs' => array(
        	'step'=> 1,
            'min' => 0,
            'max' => 50,
        )
    ) );

    $wp_customize->add_setting('tafri_travel_top_bottom_product_sale_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_top_bottom_product_sale_padding',array(
		'label'	=> __('Top / Bottom Product Sale Padding ','tafri-travel'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'tafri_travel_shop_page_options',
		'type'=> 'number'
	));

	$wp_customize->add_setting('tafri_travel_left_right_product_sale_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_left_right_product_sale_padding',array(
		'label'	=> __('Left / Right Product Sale Padding','tafri-travel'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'tafri_travel_shop_page_options',
		'type'=> 'number'
	));

	$wp_customize->add_setting('tafri_travel_product_sale_font_size',array(
		'default'=> 14,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float'
	));
	$wp_customize->add_control('tafri_travel_product_sale_font_size',array(
		'label'	=> __('Product Sale Font Size','tafri-travel'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'tafri_travel_shop_page_options',
		'type'=> 'number'
	));

	$wp_customize->add_setting('tafri_travel_shop_products_navigation',array(
       'default' => 'Yes',
       'sanitize_callback'	=> 'tafri_travel_sanitize_choices'
    ));
    $wp_customize->add_control('tafri_travel_shop_products_navigation',array(
       'type' => 'radio',
       'label' => __('Woocommerce Products Navigation','tafri-travel'),
       'choices' => array(
            'Yes' => __('Yes','tafri-travel'),
            'No' => __('No','tafri-travel'),
        ),
       'section' => 'tafri_travel_shop_page_options',
    ));

	//Layout Settings
	$wp_customize->add_section( 'tafri_travel_width_layout', array(
    	'title'      => __( 'Layout Settings', 'tafri-travel' ),
		'panel' => 'tafri_travel_panel_id'
	) );

	$wp_customize->add_setting( 'tafri_travel_fixed_header',array(
		'default' => false,
      	'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ) );
    $wp_customize->add_control('tafri_travel_fixed_header',array(
    	'type' => 'checkbox',
        'label' => __( 'Enable / Disable Fixed Header','tafri-travel' ),
        'section' => 'tafri_travel_width_layout'
    ));

    $wp_customize->add_setting( 'tafri_travel_fixed_header_padding_option', array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	) );
	$wp_customize->add_control( 'tafri_travel_fixed_header_padding_option', array(
		'label'       => esc_html__( 'Fixed Header Padding','tafri-travel' ),
		'section'     => 'tafri_travel_width_layout',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('tafri_travel_loader_setting',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_loader_setting',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Preloader','tafri-travel'),
       'section' => 'tafri_travel_width_layout'
    ));

    $wp_customize->add_setting('tafri_travel_preloader_types',array(
        'default' => 'Default',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_preloader_types',array(
        'type' => 'radio',
        'label' => __('Preloader Option','tafri-travel'),
        'section' => 'tafri_travel_width_layout',
        'choices' => array(
            'Default' => __('Default','tafri-travel'),
            'Circle' => __('Circle','tafri-travel'),
            'Two Circle' => __('Two Circle','tafri-travel')
        ),
	) );

    $wp_customize->add_setting( 'tafri_travel_loader_color_setting', array(
	    'default' => '#fff',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_loader_color_setting', array(
  		'label' => __('Preloader Color Option', 'tafri-travel'),
	    'section' => 'tafri_travel_width_layout',
	    'settings' => 'tafri_travel_loader_color_setting',
  	)));

  	$wp_customize->add_setting( 'tafri_travel_loader_background_color', array(
	    'default' => '#000',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_loader_background_color', array(
  		'label' => __('Preloader Background Color Option', 'tafri-travel'),
	    'section' => 'tafri_travel_width_layout',
	    'settings' => 'tafri_travel_loader_background_color',
  	)));

	$wp_customize->add_setting('tafri_travel_theme_options',array(
    'default' => 'Default',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_theme_options',array(
        'type' => 'select',
        'label' => __('Container Box','tafri-travel'),
        'description' => __('Here you can change the Width layout. ','tafri-travel'),
        'section' => 'tafri_travel_width_layout',
        'choices' => array(
            'Default' => __('Default','tafri-travel'),
            'Wide Layout' => __('Wide Layout','tafri-travel'),
            'Box Layout' => __('Box Layout','tafri-travel'),
        ),
	) );

	$wp_customize->add_setting('tafri_travel_mobile_media_open_menu_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_mobile_media_open_menu_icon',array(
		'label'	=> __('Open Menu icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_width_layout',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('tafri_travel_mobile_media_close_menu_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_mobile_media_close_menu_icon',array(
		'label'	=> __('Close Menu icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_width_layout',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'tafri_travel_post_image_border_radius', array(
		'default'=> 0,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	) );
	$wp_customize->add_control( 'tafri_travel_post_image_border_radius', array(
		'label'       => esc_html__( 'Featured Image Border Radius','tafri-travel' ),
		'section'     => 'tafri_travel_width_layout',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'tafri_travel_featured_image_box_shadow',array(
		'default' => 0,
		'sanitize_callback'    => 'tafri_travel_sanitize_number_range',
	));
	$wp_customize->add_control('tafri_travel_featured_image_box_shadow',array(
		'label' => esc_html__( 'Featured Image Shadow','tafri-travel' ),
		'section' => 'tafri_travel_width_layout',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type' => 'range'
	));

	// Button Settings
	$wp_customize->add_section( 'tafri_travel_button_option', array(
		'title' => __('Button','tafri-travel'),
		'panel' => 'tafri_travel_panel_id',
	));

	$wp_customize->add_setting('tafri_travel_top_bottom_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_top_bottom_padding',array(
		'label'	=> __('Top and Bottom Padding ','tafri-travel'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'tafri_travel_button_option',
		'type'=> 'number'
	));

	$wp_customize->add_setting('tafri_travel_left_right_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_left_right_padding',array(
		'label'	=> __('Left and Right Padding','tafri-travel'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'tafri_travel_button_option',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'tafri_travel_border_radius', array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	) );
	$wp_customize->add_control( 'tafri_travel_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','tafri-travel' ),
		'section'     => 'tafri_travel_button_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Top Bar
	$wp_customize->add_section('tafri_travel_topbar',array(
		'title'	=> __('Topbar Section','tafri-travel'),
		'description'	=> __('Add topbar content','tafri-travel'),
		'panel' => 'tafri_travel_panel_id',
	));

	//Show /Hide Topbar
	$wp_customize->add_setting( 'tafri_travel_show_hide_topbar',array(
		'default' => true,
      	'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ) );
    $wp_customize->add_control('tafri_travel_show_hide_topbar',array(
    	'type' => 'checkbox',
        'label' => __( 'Show / Hide Top Header','tafri-travel' ),
        'section' => 'tafri_travel_topbar'
    ));

    $wp_customize->add_setting('tafri_travel_topbar_top_bottom_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_topbar_top_bottom_padding',array(
		'label'	=> __('Topbar Top and Bottom Padding','tafri-travel'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'tafri_travel_topbar',
		'type'=> 'number'
	));

    $wp_customize->add_setting('tafri_travel_enable_disable_search',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_search',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Search','tafri-travel'),
       'section' => 'tafri_travel_topbar'
    ));

    $wp_customize->add_setting('tafri_travel_change_search_placeholder',array(
       'default' => 'Search',
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('tafri_travel_change_search_placeholder',array(
       'type' => 'text',
       'label' => __('Change Search Placeholder','tafri-travel'),
       'section' => 'tafri_travel_topbar'
    ));

	$wp_customize->add_setting('tafri_travel_search_icon',array(
		'default'	=> 'fas fa-search',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_search_icon',array(
		'label'	=> __('Search Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_topbar',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('tafri_travel_search_font_size',array(
		'default'=> 16,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_search_font_size',array(
		'label'	=> __('Search Font Size ','tafri-travel'),
		'section'=> 'tafri_travel_topbar',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	$wp_customize->add_setting('tafri_travel_search_padding',array(
		'default'=> 15,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_search_padding',array(
		'label'	=> __('Search Padding','tafri-travel'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'tafri_travel_topbar',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'tafri_travel_search_border_radius', array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	) );
	$wp_customize->add_control( 'tafri_travel_search_border_radius', array(
		'label'       => esc_html__( 'Search Border Radius','tafri-travel' ),
		'section'     => 'tafri_travel_topbar',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('tafri_travel_header_type',array(
        'default' => 'With Transparent',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_header_type',array(
        'type' => 'radio',
        'label' => __('Header display options','tafri-travel'),
        'section' => 'tafri_travel_topbar',
        'choices' => array(
            'With Transparent' => __('With Transparent','tafri-travel'),
            'Without Transparent' => __('Without Transparent','tafri-travel'),
        ),
	) );

	$wp_customize->add_setting('tafri_travel_social_icons_font_size',array(
		'default'=> 14,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_social_icons_font_size',array(
		'label'	=> __('Social Icons Font Size ','tafri-travel'),
		'section'=> 'tafri_travel_topbar',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	$wp_customize->add_setting('tafri_travel_timing_icon',array(
		'default'	=> 'far fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_timing_icon',array(
		'label'	=> __('Time Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_topbar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('tafri_travel_timing',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	$wp_customize->add_control('tafri_travel_timing',array(
		'label'	=> __('Timing','tafri-travel'),
		'section'	=> 'tafri_travel_topbar',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('tafri_travel_facebook_icon',array(
		'default'	=> 'fab fa-facebook-f',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_facebook_icon',array(
		'label'	=> __('Facebook Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_topbar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('tafri_travel_facebook_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('tafri_travel_facebook_url',array(
		'label'	=> __('Add Facebook link','tafri-travel'),
		'section'	=> 'tafri_travel_topbar',
		'setting'	=> 'tafri_travel_facebook_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('tafri_travel_twitter_icon',array(
		'default'	=> 'fab fa-twitter',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_twitter_icon',array(
		'label'	=> __('Twitter Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_topbar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('tafri_travel_twitter_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('tafri_travel_twitter_url',array(
		'label'	=> __('Add Twitter link','tafri-travel'),
		'section'	=> 'tafri_travel_topbar',
		'setting'	=> 'tafri_travel_twitter_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('tafri_travel_insta_icon',array(
		'default'	=> 'fab fa-instagram',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_insta_icon',array(
		'label'	=> __('Instagram Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_topbar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('tafri_travel_insta_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('tafri_travel_insta_url',array(
		'label'	=> __('Add Instagram link','tafri-travel'),
		'section'	=> 'tafri_travel_topbar',
		'setting'	=> 'tafri_travel_insta_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('tafri_travel_linkedin_icon',array(
		'default'	=> 'fab fa-linkedin-in',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_linkedin_icon',array(
		'label'	=> __('Linkedin Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_topbar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('tafri_travel_linkedin_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('tafri_travel_linkedin_url',array(
		'label'	=> __('Add Linkedin link','tafri-travel'),
		'section'	=> 'tafri_travel_topbar',
		'setting'	=> 'tafri_travel_linkedin_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('tafri_travel_pintrest_icon',array(
		'default'	=> 'fab fa-pinterest-p',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_pintrest_icon',array(
		'label'	=> __('Pintrest Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_topbar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('tafri_travel_pintrest_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('tafri_travel_pintrest_url',array(
		'label'	=> __('Add Pintrest link','tafri-travel'),
		'section'	=> 'tafri_travel_topbar',
		'setting'	=> 'tafri_travel_pintrest_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('tafri_travel_youtube_icon',array(
		'default'	=> 'fab fa-youtube',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_youtube_icon',array(
		'label'	=> __('Youtube Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_topbar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('tafri_travel_youtube_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('tafri_travel_youtube_url',array(
		'label'	=> __('Add Youtube link','tafri-travel'),
		'section'	=> 'tafri_travel_topbar',
		'setting'	=> 'tafri_travel_youtube_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('tafri_travel_enable_disable_myaccount',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_myaccount',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide My Account','tafri-travel'),
       'section' => 'tafri_travel_topbar'
    ));

	$wp_customize->add_setting('tafri_travel_myaccount_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_myaccount_icon',array(
		'label'	=> __('My Account Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_topbar',
		'type'		=> 'icon'
	)));

	// navigation menu 
	$wp_customize->add_section( 'tafri_travel_navigation_menu' , array(
    	'title'      => __( 'Navigation Menus Settings', 'tafri-travel' ),
		'priority'   => null,
		'panel' => 'tafri_travel_panel_id'
	) );

	$wp_customize->add_setting('tafri_travel_navigation_menu_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_navigation_menu_font_size',array(
		'label'	=> __('Navigation Menus Font Size ','tafri-travel'),
		'section'=> 'tafri_travel_navigation_menu',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	$wp_customize->add_setting('tafri_travel_menu_text_tranform',array(
        'default' => 'Default',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
    ));
    $wp_customize->add_control('tafri_travel_menu_text_tranform',array(
        'type' => 'radio',
        'label' => __('Navigation Menus Text Transform','tafri-travel'),
        'section' => 'tafri_travel_navigation_menu',
        'choices' => array(
            'Default' => __('Default','tafri-travel'),
            'Uppercase' => __('Uppercase','tafri-travel'),
        ),
	) );

	$wp_customize->add_setting('tafri_travel_menu_font_weight',array(
        'default' => 'Default',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
    ));
    $wp_customize->add_control('tafri_travel_menu_font_weight',array(
        'type' => 'radio',
        'label' => __('Navigation Menus Font Weight','tafri-travel'),
        'section' => 'tafri_travel_navigation_menu',
        'choices' => array(
            'Default' => __('Default','tafri-travel'),
            'Normal' => __('Normal','tafri-travel'),
        ),
	) );

	//Slider
	$wp_customize->add_section( 'tafri_travel_slider' , array(
    	'title'      => __( 'Slider Settings', 'tafri-travel' ),
		'priority'   => null,
		'panel' => 'tafri_travel_panel_id'
	) );

	$wp_customize->add_setting('tafri_travel_slider_hide',array(
       'default' => false,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_slider_hide',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide slider','tafri-travel'),
       'section' => 'tafri_travel_slider'
    ));

    $wp_customize->add_setting('tafri_travel_slider_title',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_slider_title',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Slider Title','tafri-travel'),
       'section' => 'tafri_travel_slider'
    ));

    $wp_customize->add_setting('tafri_travel_slider_content',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_slider_content',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Slider Content','tafri-travel'),
       'section' => 'tafri_travel_slider'
    ));

    $wp_customize->add_setting('tafri_travel_slider_button',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_slider_button',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Slider Button','tafri-travel'),
       'section' => 'tafri_travel_slider'
    ));

	for ( $count = 1; $count <= 4; $count++ ) {

		// Add color scheme setting and control.
		$wp_customize->add_setting( 'tafri_travel_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'tafri_travel_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'tafri_travel_slider_page' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'tafri-travel' ),
			'description'	=> __('Size of image should be 1600 x 633','tafri-travel'),
			'section'  => 'tafri_travel_slider',
			'type'     => 'dropdown-pages'
		) );
	}

	$wp_customize->add_setting('tafri_travel_slider_display_option',array(
    	'default' => 'Home page',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_slider_display_option',array(
        'type' => 'select',
        'label' => __('Slider Show in','tafri-travel'),
        'section' => 'tafri_travel_slider',
        'choices' => array(
            'Home page' => __('Home page','tafri-travel'),
            'Blog Page' => __('Blog Page','tafri-travel'),
            'Both Home page & Blog Page' => __('Both Home page & Blog Page','tafri-travel'),
        ),
	) );

	$wp_customize->add_setting( 'tafri_travel_slider_speed',array(
		'default' => 3000,
		'sanitize_callback'    => 'tafri_travel_sanitize_number_range',
	));
	$wp_customize->add_control( 'tafri_travel_slider_speed',array(
		'label' => esc_html__( 'Slider Speed','tafri-travel' ),
		'section' => 'tafri_travel_slider',
		'type'        => 'range',
		'input_attrs' => array(
			'min' => 1000,
			'max' => 5000,
			'step' => 500,
		),
	));

	$wp_customize->add_setting('tafri_travel_slider_height_option',array(
		'default'=> 600,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_slider_height_option',array(
		'label'	=> __('Slider Height Option','tafri-travel'),
		'section'=> 'tafri_travel_slider',
		'type'=> 'number'
	));

    $wp_customize->add_setting('tafri_travel_slider_content_option',array(
    'default' => 'Center',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_slider_content_option',array(
        'type' => 'select',
        'label' => __('Slider Content Layout','tafri-travel'),
        'section' => 'tafri_travel_slider',
        'choices' => array(
            'Center' => __('Center','tafri-travel'),
            'Left' => __('Left','tafri-travel'),
            'Right' => __('Right','tafri-travel'),
        ),
	) );

	$wp_customize->add_setting('tafri_travel_slider_button_text',array(
		'default'=> __('View All Travels','tafri-travel'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_slider_button_text',array(
		'label'	=> __('Slider Button Text','tafri-travel'),
		'section'=> 'tafri_travel_slider',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'tafri_travel_slider_excerpt_number', array(
		'default'              => 15,
		'sanitize_callback'    => 'tafri_travel_sanitize_number_range',
	) );
	$wp_customize->add_control( 'tafri_travel_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','tafri-travel' ),
		'section'     => 'tafri_travel_slider',
		'type'        => 'range',
		'settings'    => 'tafri_travel_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('tafri_travel_slider_opacity_color',array(
      'default'              => 0.7,
      'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control( 'tafri_travel_slider_opacity_color', array(
	'label'       => esc_html__( 'Slider Image Opacity','tafri-travel' ),
	'section'     => 'tafri_travel_slider',
	'type'        => 'select',
	'settings'    => 'tafri_travel_slider_opacity_color',
	'choices' => array(
      '0' =>  esc_attr('0','tafri-travel'),
      '0.1' =>  esc_attr('0.1','tafri-travel'),
      '0.2' =>  esc_attr('0.2','tafri-travel'),
      '0.3' =>  esc_attr('0.3','tafri-travel'),
      '0.4' =>  esc_attr('0.4','tafri-travel'),
      '0.5' =>  esc_attr('0.5','tafri-travel'),
      '0.6' =>  esc_attr('0.6','tafri-travel'),
      '0.7' =>  esc_attr('0.7','tafri-travel'),
      '0.8' =>  esc_attr('0.8','tafri-travel'),
      '0.9' =>  esc_attr('0.9','tafri-travel')
	),
	));

    $wp_customize->add_setting('tafri_travel_padding_top_bottom_slider_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_padding_top_bottom_slider_content',array(
		'label'	=> __('Top Bottom Slider Content Padding','tafri-travel'),
		'section'=> 'tafri_travel_slider',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	$wp_customize->add_setting('tafri_travel_padding_left_right_slider_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_padding_left_right_slider_content',array(
		'label'	=> __('Left Right Slider Content Padding','tafri-travel'),
		'section'=> 'tafri_travel_slider',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	$wp_customize->add_setting('tafri_travel_show_slider_image_overlay',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_show_slider_image_overlay',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Image Overlay Slider','tafri-travel'),
       'section' => 'tafri_travel_slider'
    ));

    $wp_customize->add_setting('tafri_travel_color_slider_image_overlay', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tafri_travel_color_slider_image_overlay', array(
		'label'    => __('Image Overlay Slider Color', 'tafri-travel'),
		'section'  => 'tafri_travel_slider',
		'settings' => 'tafri_travel_color_slider_image_overlay',
	)));

	//Destination Section
	$wp_customize->add_section('tafri_travel_category',array(
		'title'	=> __('Destination Section','tafri-travel'),
		'description'	=> __('Add section below.','tafri-travel'),
		'panel' => 'tafri_travel_panel_id',
	));

	$wp_customize->add_setting('tafri_travel_title',array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_text_field',
   	));
   	$wp_customize->add_control('tafri_travel_title',array(
	    'label' => __('Section Title','tafri-travel'),
	    'section' => 'tafri_travel_category',
	    'type'  => 'text'
   	));

   	$wp_customize->add_setting('tafri_travel_desc',array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_text_field',
   	));
   	$wp_customize->add_control('tafri_travel_desc',array(
	    'label' => __('Section short description','tafri-travel'),
	    'section' => 'tafri_travel_category',
	    'type'  => 'text'
   	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('tafri_travel_popular_destination',array(
		'default'	=> 'select',
		'sanitize_callback' => 'tafri_travel_sanitize_choices',
	));	
	$wp_customize->add_control('tafri_travel_popular_destination',array(
		'type'    => 'select',
		'choices' => $cat_post,		
		'label' => __('Select Category to display post','tafri-travel'),
		'description'	=> __('Size of image should be 300 x 300','tafri-travel'),
		'section' => 'tafri_travel_category',
	));

	$wp_customize->add_setting( 'tafri_travel_category_excerpt_number', array(
		'default'              => 20,
		'sanitize_callback'    => 'tafri_travel_sanitize_number_range',
	) );
	$wp_customize->add_control( 'tafri_travel_category_excerpt_number', array(
		'label'       => esc_html__( 'Destination Excerpt length','tafri-travel' ),
		'section'     => 'tafri_travel_category',
		'type'        => 'range',
		'settings'    => 'tafri_travel_category_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//no Result Setting
	$wp_customize->add_section('tafri_travel_no_result_setting',array(
		'title'	=> __('No Results Settings','tafri-travel'),
		'panel' => 'tafri_travel_panel_id',
	));	

	$wp_customize->add_setting('tafri_travel_no_search_result_title',array(
		'default'=> __('Nothing Found','tafri-travel'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_no_search_result_title',array(
		'label'	=> __('No Search Results Title','tafri-travel'),
		'section'=> 'tafri_travel_no_result_setting',
		'type'=> 'text'
	));

	$wp_customize->add_setting('tafri_travel_no_search_result_content',array(
		'default'=> __('Sorry, but nothing matched your search terms. Please try again with some different keywords.','tafri-travel'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_no_search_result_content',array(
		'label'	=> __('No Search Results Content','tafri-travel'),
		'section'=> 'tafri_travel_no_result_setting',
		'type'=> 'text'
	));

	//404 Page Setting
	$wp_customize->add_section('tafri_travel_page_not_found_setting',array(
		'title'	=> __('Page Not Found Settings','tafri-travel'),
		'panel' => 'tafri_travel_panel_id',
	));	

	$wp_customize->add_setting('tafri_travel_page_not_found_title',array(
		'default'=> __('404 Not Found','tafri-travel'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_page_not_found_title',array(
		'label'	=> __('Page Not Found Title','tafri-travel'),
		'section'=> 'tafri_travel_page_not_found_setting',
		'type'=> 'text'
	));

	$wp_customize->add_setting('tafri_travel_page_not_found_content',array(
		'default'=> __('Looks like you have taken a wrong turn&hellip. Dont worry&hellip it happens to the best of us.','tafri-travel'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_page_not_found_content',array(
		'label'	=> __('Page Not Found Content','tafri-travel'),
		'section'=> 'tafri_travel_page_not_found_setting',
		'type'=> 'text'
	));

	$wp_customize->add_setting('tafri_travel_page_not_found_button',array(
		'default'=>  __('Back to Home Page','tafri-travel'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_page_not_found_button',array(
		'label'	=> __('Button Text','tafri-travel'),
		'section'=> 'tafri_travel_page_not_found_setting',
		'type'=> 'text'
	));

	//Responsive Media Settings
	$wp_customize->add_section('tafri_travel_mobile_media',array(
		'title'	=> __('Mobile Media Settings','tafri-travel'),
		'panel' => 'tafri_travel_panel_id',
	));

	$wp_customize->add_setting('tafri_travel_enable_disable_preloader',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_preloader',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Preloader','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

	$wp_customize->add_setting('tafri_travel_enable_disable_sidebar',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_sidebar',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Sidebar','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

	$wp_customize->add_setting('tafri_travel_enable_disable_topbar',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_topbar',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Top Header','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

    $wp_customize->add_setting('tafri_travel_enable_disable_fixed_header',array(
       'default' => false,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_fixed_header',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Fixed Header','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

    $wp_customize->add_setting('tafri_travel_enable_disable_slider',array(
       'default' => false,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_slider',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Slider','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

    $wp_customize->add_setting('tafri_travel_show_hide_slider_button',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_show_hide_slider_button',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Slider Button','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

    $wp_customize->add_setting('tafri_travel_enable_disable_scrolltop',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_scrolltop',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Scroll To Top','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

    $wp_customize->add_setting('tafri_travel_mobile_enable_disable_search',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_mobile_enable_disable_search',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Search','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

    $wp_customize->add_setting('tafri_travel_mobile_enable_disable_myaccount',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_mobile_enable_disable_myaccount',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable My Account','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

    $wp_customize->add_setting('tafri_travel_enable_disable_post_date',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_post_date',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Post Date','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

    $wp_customize->add_setting('tafri_travel_enable_disable_post_author',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_post_author',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Post Author','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

    $wp_customize->add_setting('tafri_travel_enable_disable_post_comment',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_post_comment',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Post Comment','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

    $wp_customize->add_setting('tafri_travel_enable_disable_single_post_time',array(
       'default' => false,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_enable_disable_single_post_time',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Single Post Time','tafri-travel'),
       'section' => 'tafri_travel_mobile_media'
    ));

	//Blog Post
	$wp_customize->add_section('tafri_travel_blog_post',array(
		'title'	=> __('Post Settings','tafri-travel'),
		'panel' => 'tafri_travel_panel_id',
	));	

	$wp_customize->add_setting('tafri_travel_date_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_date_hide',array(
       'type' => 'checkbox',
       'label' => __('Post Date','tafri-travel'),
       'section' => 'tafri_travel_blog_post'
    ));

    $wp_customize->add_setting('tafri_travel_date_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_date_icon',array(
		'label'	=> __('Date Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_blog_post',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('tafri_travel_comment_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_comment_hide',array(
       'type' => 'checkbox',
       'label' => __('Post Comments','tafri-travel'),
       'section' => 'tafri_travel_blog_post'
    ));

    $wp_customize->add_setting('tafri_travel_comment_icon',array(
		'default'	=> 'fas fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_comment_icon',array(
		'label'	=> __('Comments Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_blog_post',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('tafri_travel_author_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_author_hide',array(
       'type' => 'checkbox',
       'label' => __('Post Author','tafri-travel'),
       'section' => 'tafri_travel_blog_post'
    ));

    $wp_customize->add_setting('tafri_travel_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_author_icon',array(
		'label'	=> __('Author Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_blog_post',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('tafri_travel_blog_post_layout',array(
        'default' => 'Default',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
    ));
    $wp_customize->add_control('tafri_travel_blog_post_layout',array(
        'type' => 'radio',
        'label' => __('Post Layout Option','tafri-travel'),
        'section' => 'tafri_travel_blog_post',
        'choices' => array(
            'Default' => __('Default','tafri-travel'),
            'Center' => __('Center','tafri-travel'),
            'Left' => __('Left','tafri-travel'),
        ),
	) );

	$wp_customize->add_setting('tafri_travel_blog_post_featured_option',array(
       'default' => 'Post Image',
       'sanitize_callback'	=> 'tafri_travel_sanitize_choices'
    ));
    $wp_customize->add_control('tafri_travel_blog_post_featured_option',array(
       'type' => 'radio',
       'label'	=> __('Blog Post Featured Option','tafri-travel'),
       'choices' => array(
            'Post Image' => __('Post Image','tafri-travel'),
            'Post Color' => __('Post Color','tafri-travel'),
            'None' => __('None','tafri-travel'),
        ),
      	'section'	=> 'tafri_travel_blog_post',
    ));

    $wp_customize->add_setting('tafri_travel_post_image_dimention',array(
       'default' => 'Default',
       'sanitize_callback'	=> 'tafri_travel_sanitize_choices'
    ));
    $wp_customize->add_control('tafri_travel_post_image_dimention',array(
       'type' => 'radio',
       'label'	=> __('Post Featured Image Dimention','tafri-travel'),
       'choices' => array(
            'Default' => __('Default','tafri-travel'),
            'Custom Image Size' => __('Custom Image Size','tafri-travel'),
        ),
      	'section'	=> 'tafri_travel_blog_post',
      	'active_callback' => 'tafri_travel_show_post_image_dimention'
    ));

    $wp_customize->add_setting( 'tafri_travel_post_featured_image_width',array(
		'default' => '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_number_range'
	));
	$wp_customize->add_control('tafri_travel_post_featured_image_width',	array(
		'label' => esc_html__( 'Blog Post Custom Width','tafri-travel' ),
		'section' => 'tafri_travel_blog_post',
		'input_attrs' => array(
			'min' => 0,
			'max' => 500,
			'step' => 1,
		),
		'type' => 'range',
		'active_callback' => 'tafri_travel_enable_image_dimention'
	));

	$wp_customize->add_setting( 'tafri_travel_post_featured_image_height',array(
		'default' => '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_number_range'
	));
	$wp_customize->add_control('tafri_travel_post_featured_image_height',	array(
		'label' => esc_html__( 'Blog Post Custom Height','tafri-travel' ),
		'section' => 'tafri_travel_blog_post',
		'input_attrs' => array(
			'min' => 0,
			'max' => 350,
			'step' => 1,
		),
		'type' => 'range',
		'active_callback' => 'tafri_travel_enable_image_dimention'
	));

    $wp_customize->add_setting('tafri_travel_blog_post_featured_color', array(
		'default'           => '#26bdf7',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tafri_travel_blog_post_featured_color', array(
		'label'    => __('Post Color', 'tafri-travel'),
		'section'  => 'tafri_travel_blog_post',
		'settings' => 'tafri_travel_blog_post_featured_color',
		'active_callback' => 'tafri_travel_show_post_color'
	)));

	$wp_customize->add_setting( 'tafri_travel_color_post_width',array(
		'default' => '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_number_range'
	));
	$wp_customize->add_control('tafri_travel_color_post_width',	array(
		'label' => esc_html__( 'Color Post Custom Width','tafri-travel' ),
		'section' => 'tafri_travel_blog_post',
		'input_attrs' => array(
			'min' => 0,
			'max' => 500,
			'step' => 1,
		),
		'type' => 'range',
		'active_callback' => 'tafri_travel_show_post_color'
	));

	$wp_customize->add_setting( 'tafri_travel_color_post_height',array(
		'default' => '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_number_range'
	));
	$wp_customize->add_control('tafri_travel_color_post_height',	array(
		'label' => esc_html__( 'Color Post Custom Height','tafri-travel' ),
		'section' => 'tafri_travel_blog_post',
		'input_attrs' => array(
			'min' => 0,
			'max' => 350,
			'step' => 1,
		),
		'type' => 'range',
		'active_callback' => 'tafri_travel_show_post_color'
	));

	$wp_customize->add_setting('tafri_travel_post_break_block_setting',array(
        'default' => 'Into Blocks',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_post_break_block_setting',array(
        'type' => 'radio',
        'label' => __('Display Blog Page posts','tafri-travel'),
        'section' => 'tafri_travel_blog_post',
        'choices' => array(
            'Into Blocks' => __('Into Blocks','tafri-travel'),
            'Without Blocks' => __('Without Blocks','tafri-travel'),
        ),
	) );

	$wp_customize->add_setting('tafri_travel_blog_description',array(
    	'default'   => 'Post Excerpt',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_blog_description',array(
        'type' => 'select',
        'label' => __('Post Description','tafri-travel'),
        'section' => 'tafri_travel_blog_post',
        'choices' => array(
            'None' => __('None','tafri-travel'),
            'Post Excerpt' => __('Post Excerpt','tafri-travel'),
            'Post Content' => __('Post Content','tafri-travel'),
        ),
	) );

    $wp_customize->add_setting( 'tafri_travel_excerpt_number', array(
		'default'              => 30,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	) );
	$wp_customize->add_control( 'tafri_travel_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','tafri-travel' ),
		'section'     => 'tafri_travel_blog_post',
		'type'        => 'number',
		'settings'    => 'tafri_travel_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'tafri_travel_post_excerpt_suffix', array(
		'default'   => __('{...}','tafri-travel'),
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'tafri_travel_post_excerpt_suffix', array(
		'label'       => esc_html__( 'Excerpt Indicator','tafri-travel' ),
		'section'     => 'tafri_travel_blog_post',
		'type'        => 'text',
		'settings'    => 'tafri_travel_post_excerpt_suffix',
	) );

	$wp_customize->add_setting('tafri_travel_button_text',array(
		'default'=> __('READ MORE','tafri-travel'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_button_text',array(
		'label'	=> __('Add Button Text','tafri-travel'),
		'section'=> 'tafri_travel_blog_post',
		'type'=> 'text'
	));

	$wp_customize->add_setting('tafri_travel_show_post_pagination',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_show_post_pagination',array(
       'type' => 'checkbox',
       'label' => __('Post Pagination','tafri-travel'),
       'section' => 'tafri_travel_blog_post'
    ));

	$wp_customize->add_setting( 'tafri_travel_pagination_option', array(
        'default'			=> 'Default',
        'sanitize_callback'	=> 'tafri_travel_sanitize_choices'
    ));
    $wp_customize->add_control( 'tafri_travel_pagination_option', array(
        'section' => 'tafri_travel_blog_post',
        'type' => 'radio',
        'label' => __( 'Post Pagination', 'tafri-travel' ),
        'choices'		=> array(
            'Default'  => __( 'Default', 'tafri-travel' ),
            'next-prev' => __( 'Next / Previous', 'tafri-travel' ),
    )));

    $wp_customize->add_setting( 'tafri_travel_pagination_position_options', array(
        'default'			=> 'Only Bottom',
        'sanitize_callback'	=> 'tafri_travel_sanitize_choices',
    ));
    $wp_customize->add_control( 'tafri_travel_pagination_position_options', array(
        'section' => 'tafri_travel_blog_post',
        'type' => 'radio',
        'label' => __( 'Post Pagination Position Options', 'tafri-travel' ),
        'choices'		=> array(
            'Only Bottom'  => __('Only Bottom', 'tafri-travel' ),
            'Only Top' => __('Only Top', 'tafri-travel' ),
            'Both Top & Bottom' => __( 'Both Top & Bottom', 'tafri-travel' ),
    )));

	//Single Post Settings
	$wp_customize->add_section('tafri_travel_single_post_settings', array(
		'title'    => __('Single Post Settings', 'tafri-travel'),
		'panel'    => 'tafri_travel_panel_id',
	));

	$wp_customize->add_setting('tafri_travel_single_post_date',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_single_post_date',array(
       'type' => 'checkbox',
       'label' => __('Single Post Date','tafri-travel'),
       'section' => 'tafri_travel_single_post_settings'
    ));

    $wp_customize->add_setting('tafri_travel_single_post_comment',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_single_post_comment',array(
       'type' => 'checkbox',
       'label' => __('Single Post Comments','tafri-travel'),
       'section' => 'tafri_travel_single_post_settings'
    ));

    $wp_customize->add_setting('tafri_travel_single_post_author',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_single_post_author',array(
       'type' => 'checkbox',
       'label' => __('Single Post Author','tafri-travel'),
       'section' => 'tafri_travel_single_post_settings'
    ));

	$wp_customize->add_setting('tafri_travel_single_post_time',array(
       'default' => false,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_single_post_time',array(
       'type' => 'checkbox',
       'label' => __('Single Post Time','tafri-travel'),
       'section' => 'tafri_travel_single_post_settings'
    ));

    $wp_customize->add_setting('tafri_travel_single_post_breadcrumb',array(
       'default' => false,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_single_post_breadcrumb',array(
       'type' => 'checkbox',
       'label' => __('Single Post Breadcrumb','tafri-travel'),
       'section' => 'tafri_travel_single_post_settings'
    ));

    $wp_customize->add_setting('tafri_travel_post_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_post_time_icon',array(
		'label'	=> __('Single Post Time Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_single_post_settings',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('tafri_travel_single_post_image',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_single_post_image',array(
       'type' => 'checkbox',
       'label' => __('Single Post Featured Image','tafri-travel'),
       'section' => 'tafri_travel_single_post_settings'
    ));

    $wp_customize->add_setting('tafri_travel_tags_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_tags_hide',array(
       'type' => 'checkbox',
       'label' => __('Single Post Tags','tafri-travel'),
       'section' => 'tafri_travel_single_post_settings'
    ));

    $wp_customize->add_setting('tafri_travel_show_single_post_pagination',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_show_single_post_pagination',array(
       'type' => 'checkbox',
       'label' => __('Single Post Pagination','tafri-travel'),
       'section' => 'tafri_travel_single_post_settings'
    ));

	$wp_customize->add_setting('tafri_travel_prev_single_post_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_prev_single_post_navigation_text',array(
		'label'	=> __('Single Post Previous Navigation Text','tafri-travel'),
		'section'=> 'tafri_travel_single_post_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('tafri_travel_next_single_post_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_next_single_post_navigation_text',array(
		'label'	=> __('Single Post Next Navigation Text ','tafri-travel'),
		'section'=> 'tafri_travel_single_post_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'tafri_travel_seperator_metabox', array(
		'default'   => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'tafri_travel_seperator_metabox', array(
		'label'       => esc_html__( 'Single Post Meta Box Seperator','tafri-travel' ),
		'section'     => 'tafri_travel_single_post_settings',
		'description' => __('Add the seperator for meta box. Example: ",",  "|", "/", etc. ','tafri-travel'),
		'type'        => 'text',
		'settings'    => 'tafri_travel_seperator_metabox',
	) );

	$wp_customize->add_setting('tafri_travel_comment_form_heading',array(
       'default' => __('Leave a Reply','tafri-travel'),
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('tafri_travel_comment_form_heading',array(
       'type' => 'text',
       'label' => __('Comment Form Heading','tafri-travel'),
       'section' => 'tafri_travel_single_post_settings'
    ));

    $wp_customize->add_setting('tafri_travel_comment_button_text',array(
       'default' => __('Post Comment','tafri-travel'),
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('tafri_travel_comment_button_text',array(
       'type' => 'text',
       'label' => __('Comment Submit Button Text','tafri-travel'),
       'section' => 'tafri_travel_single_post_settings'
    ));

    $wp_customize->add_setting( 'tafri_travel_comment_form_size',array(
		'default' => 100,
		'sanitize_callback'    => 'tafri_travel_sanitize_number_range',
	));
	$wp_customize->add_control('tafri_travel_comment_form_size',	array(
		'label' => esc_html__( 'Comment Form Size','tafri-travel' ),
		'section' => 'tafri_travel_single_post_settings',
		'type' => 'range',
		'input_attrs' => array(
			'min' => 0,
			'max' => 100,
			'step' => 1,
		),
	));

    // related post setting
    $wp_customize->add_section('tafri_travel_related_post_section',array(
		'title'	=> __('Related Post Settings','tafri-travel'),
		'panel' => 'tafri_travel_panel_id',
	));	

	$wp_customize->add_setting('tafri_travel_related_posts',array(
       'default' => true,
       'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
    ));
    $wp_customize->add_control('tafri_travel_related_posts',array(
       'type' => 'checkbox',
       'label' => __('Related Post','tafri-travel'),
       'section' => 'tafri_travel_related_post_section',
    ));

	$wp_customize->add_setting( 'tafri_travel_show_related_post', array(
        'default' => 'By Categories',
        'sanitize_callback'	=> 'tafri_travel_sanitize_choices'
    ));
    $wp_customize->add_control( 'tafri_travel_show_related_post', array(
        'section' => 'tafri_travel_related_post_section',
        'type' => 'radio',
        'label' => __( 'Show Related Posts', 'tafri-travel' ),
        'choices' => array(
            'categories'  => __('By Categories', 'tafri-travel'),
            'tags' => __('By Tags', 'tafri-travel' ),
    )));

    $wp_customize->add_setting('tafri_travel_change_related_post_title',array(
		'default'=> __('Related Posts','tafri-travel'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('tafri_travel_change_related_post_title',array(
		'label'	=> __('Change Related Post Title','tafri-travel'),
		'section'=> 'tafri_travel_related_post_section',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('tafri_travel_change_related_posts_number',array(
		'default'=> 3,
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_change_related_posts_number',array(
		'label'	=> __('Change Related Post Number','tafri-travel'),
		'section'=> 'tafri_travel_related_post_section',
		'type'=> 'number',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
	));

	//footer
	$wp_customize->add_section('tafri_travel_footer_section', array(
		'title'       => __('Footer Section', 'tafri-travel'),
		'priority'    => null,
		'panel'       => 'tafri_travel_panel_id',
	));

	$wp_customize->add_setting('tafri_travel_footer_widget',array(
        'default'           => 4,
        'sanitize_callback' => 'tafri_travel_sanitize_choices',
    ));
    $wp_customize->add_control('tafri_travel_footer_widget',array(
        'type'        => 'radio',
        'label'       => __('No. of Footer widget area', 'tafri-travel'),
        'section'     => 'tafri_travel_footer_section',
        'description' => __('Select the number of footer widget areas and after that, go to Appearance > Widgets and add your widgets in the footer.', 'tafri-travel'),
        'choices' => array(
            '1'     => __('One', 'tafri-travel'),
            '2'     => __('Two', 'tafri-travel'),
            '3'     => __('Three', 'tafri-travel'),
            '4'     => __('Four', 'tafri-travel')
        ),
    ));

	$wp_customize->add_setting( 'tafri_travel_footer_widget_background', array(
	    'default' => '#0f2036',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tafri_travel_footer_widget_background', array(
  		'label' => __('Footer Widget Background','tafri-travel'),
	    'section' => 'tafri_travel_footer_section',
  	)));

  	$wp_customize->add_setting('tafri_travel_footer_widget_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'tafri_travel_footer_widget_image',array(
        'label' => __('Footer Widget Background Image','tafri-travel'),
        'section' => 'tafri_travel_footer_section'
	)));

	$wp_customize->add_setting('tafri_travel_hide_show_scroll',array(
        'default' => true,
        'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
	));
	$wp_customize->add_control('tafri_travel_hide_show_scroll',array(
     	'type' => 'checkbox',
      	'label' => __('Show / Hide Scroll To Top','tafri-travel'),
      	'section' => 'tafri_travel_footer_section',
	));

	$wp_customize->add_setting('tafri_travel_scroll_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Tafri_Travel_Icon_Changer(
        $wp_customize,'tafri_travel_scroll_icon',array(
		'label'	=> __('Scroll To Top Icon','tafri-travel'),
		'transport' => 'refresh',
		'section'	=> 'tafri_travel_footer_section',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('tafri_travel_footer_options',array(
        'default' => 'Right align',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_footer_options',array(
        'type' => 'select',
        'label' => __('Scroll To Top','tafri-travel'),
        'description' => __('Here you can change the Footer layout. ','tafri-travel'),
        'section' => 'tafri_travel_footer_section',
        'choices' => array(
            'Left align' => __('Left align','tafri-travel'),
            'Right align' => __('Right align','tafri-travel'),
            'Center align' => __('Center align','tafri-travel'),
        ),
	) );

	$wp_customize->add_setting('tafri_travel_scroll_top_fontsize',array(
		'default'=> '',
		'sanitize_callback'    => 'tafri_travel_sanitize_number_range',
	));
	$wp_customize->add_control('tafri_travel_scroll_top_fontsize',array(
		'label'	=> __('Scroll To Top Font Size','tafri-travel'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'tafri_travel_footer_section',
		'type'=> 'range'
	));

	$wp_customize->add_setting('tafri_travel_scroll_top_bottom_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_scroll_top_bottom_padding',array(
		'label'	=> __('Scroll Top Bottom Padding ','tafri-travel'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'tafri_travel_footer_section',
		'type'=> 'number'
	));

	$wp_customize->add_setting('tafri_travel_scroll_left_right_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_scroll_left_right_padding',array(
		'label'	=> __('Scroll Left Right Padding','tafri-travel'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'tafri_travel_footer_section',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'tafri_travel_scroll_border_radius', array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	) );
	$wp_customize->add_control( 'tafri_travel_scroll_border_radius', array(
		'label'       => esc_html__( 'Scroll To Top Border Radius','tafri-travel' ),
		'section'     => 'tafri_travel_footer_section',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting('tafri_travel_copyright_top_bottom_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_copyright_top_bottom_padding',array(
		'label'	=> __('Copyright Top and Bottom Padding','tafri-travel'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'tafri_travel_footer_section',
		'type'=> 'number'
	));

	$wp_customize->add_setting('tafri_travel_footer_text', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('tafri_travel_footer_text', array(
		'label'   => __('Copyright Text', 'tafri-travel'),
		'description' => __('Add some text for footer like copyright etc.', 'tafri-travel'),
		'section' => 'tafri_travel_footer_section',
		'type'    => 'text',
	));

	$wp_customize->add_setting('tafri_travel_footer_text_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'tafri_travel_sanitize_float',
	));
	$wp_customize->add_control('tafri_travel_footer_text_font_size',array(
		'label'	=> __('Footer Text Font Size','tafri-travel'),
		'section'=> 'tafri_travel_footer_section',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	//Layouts
	$wp_customize->add_section('tafri_travel_left_right', array(
		'title'    => __('Sidebar Layout Settings', 'tafri-travel'),
		'priority' => '',
		'panel'    => 'tafri_travel_panel_id',
	));

	$wp_customize->add_setting('tafri_travel_single_product_sidebar',array(
        'default' => true,
        'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
	));
	$wp_customize->add_control('tafri_travel_single_product_sidebar',array(
     	'type' => 'checkbox',
      	'label' => __('Enable / Disable Single Product Sidebar','tafri-travel'),
      	'section' => 'tafri_travel_left_right',
	));

	$wp_customize->add_setting('tafri_travel_enable_disable_shop_sidebar',array(
        'default' => true,
        'sanitize_callback'	=> 'tafri_travel_sanitize_checkbox'
	));
	$wp_customize->add_control('tafri_travel_enable_disable_shop_sidebar',array(
     	'type' => 'checkbox',
      	'label' => __('Enable / Disable Shop page Sidebar','tafri-travel'),
      	'section' => 'tafri_travel_left_right',
	));

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('tafri_travel_post_sidebar_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_post_sidebar_options',array(
        'type' => 'radio',
        'label' => __('Post Sidebar Layout','tafri-travel'),
        'section' => 'tafri_travel_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','tafri-travel'),
            'Right Sidebar' => __('Right Sidebar','tafri-travel'),
            'One Column' => __('One Column','tafri-travel'),
            'Grid Layout' => __('Grid Layout','tafri-travel')
        ),
	) );

	$wp_customize->add_setting('tafri_travel_page_sidebar_option',array(
        'default' => 'One Column',
        'sanitize_callback' => 'tafri_travel_sanitize_choices'
	));
	$wp_customize->add_control('tafri_travel_page_sidebar_option',array(
        'type' => 'radio',
        'label' => __('Page Sidebar Layout','tafri-travel'),
        'section' => 'tafri_travel_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','tafri-travel'),
            'Right Sidebar' => __('Right Sidebar','tafri-travel'),
            'One Column' => __('One Column','tafri-travel')
        ),
	) );
}
add_action('customize_register', 'tafri_travel_customize_register');

// logo resize
load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Tafri_Travel_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if (is_null($instance)) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action('customize_register', array($this, 'sections'));

		// Register scripts and styles for the contafri_travel_Customizetrols.
		add_action('customize_controls_enqueue_scripts', array($this, 'enqueue_control_scripts'), 0);
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections($manager) {

		// Load custom sections.
		load_template(trailingslashit(get_template_directory()).'/inc/section-pro.php');

		// Register custom section types.
		$manager->register_section_type('Tafri_Travel_Customize_Section_Pro');

		// Register sections.
		$manager->add_section(
			new Tafri_Travel_Customize_Section_Pro(
				$manager,
				'tafri_travel_example_1',
				array(
					'priority' => 9,
					'title'    => esc_html__('Travel Pro Theme', 'tafri-travel'),
					'pro_text' => esc_html__('Go Pro', 'tafri-travel'),
					'pro_url'  => esc_url('https://www.themeseye.com/wordpress/wordpress-travel-theme/'),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script('tafri-travel-customize-controls', trailingslashit(esc_url(get_template_directory_uri())).'/assets/js/customize-controls.js', array('customize-controls'));
		wp_enqueue_style('tafri-travel-customize-controls', trailingslashit(esc_url(get_template_directory_uri())).'assets/css/customize-controls.css');
	}
}

// Doing this customizer thang!
Tafri_Travel_Customize::get_instance();
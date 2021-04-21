<?php
/**
 *  Customizer Section for Footer
 */

 function olively_customize_register_footer( $wp_customize ) {

    $wp_customize->add_section(
        'olively_footer_section', array(
            'title'    => esc_html__('Footer', 'olively'),
            'priority' => 30,
        )
    );

    $wp_customize->add_setting(
        'olively_footer_cols', array(
            'default'  => 4,
            'sanitize_callback'    => 'absint'
        )
    );
     
    $wp_customize->add_control(
	    new Olively_Image_Radio_Control(
		    $wp_customize, 'olively_footer_cols', array(
			    'label'    =>  esc_html__('Select the Footer Layout', 'olively'),
	            'section'  =>  'olively_footer_section',
	            'priority' => 5,
	            'type'	   => 'image-radio',
	            'choices'	=>	array(
		            '1'	=>	array(
			            'name'	=>	__('1 Column', 'olively'),
			            'image'	=> get_template_directory_uri() . '/assets/images/1-column.png',
		            ),
		            '2'	=>	array(
			            'name'	=>	__('2 Columns', 'olively'),
			            'image'	=> get_template_directory_uri() . '/assets/images/2-columns.png',
		            ),
		            '3'	=>	array(
			            'name'	=>	__('3 Columns', 'olively'),
			            'image'	=> esc_url(get_template_directory_uri() . '/assets/images/3-columns.png'),
		            ),
		            '4'	=>	array(
			            'name'	=>	__('4 Columns', 'olively'),
			            'image'	=> esc_url(get_template_directory_uri() . '/assets/images/4-columns.png'),
		            ),
	            )
	        )
	    )
    );
    
    $wp_customize->add_setting(
	    'olively_footer_bg', array(
		    'default'			=>	'',
		    'sanitize_callback'	=>	'esc_url_raw'
	    )
    );
    
    $wp_customize->add_control(
	    new WP_Customize_Image_Control(
		    $wp_customize,
		    'olively_footer_bg',
		    array(
			    'label'		=>	__('Footer Background', 'olively'),
			    'settings'	=>	'olively_footer_bg',
			    'section'	=>	'olively_footer_section',
			    'priority'	=>	8
		    )
	    )
    );

     $wp_customize->add_setting(
         'olively_footer_text', array(
             'default'  => '',
             'sanitize_callback'    =>  'sanitize_text_field'
         )
     );

     $wp_customize->add_control(
         'olively_footer_text', array(
             'label'    =>  esc_html__('Custom Footer Text', 'olively'),
             'description'  =>  esc_html__('Will show Default Text if empty', 'olively'),
             'priority' =>  10,
             'type'     =>  'text',
             'section'  => 'olively_footer_section'
         )
     );
 }
 add_action('customize_register', 'olively_customize_register_footer');
<?php
function olively_customize_register_social( $wp_customize ) {
		// Social Icons
	$wp_customize->add_section('olively_social_section', array(
			'title' 	=> esc_html__('Social Icons','olively'),
			'priority' 	=> 70,
			'panel'		=> 'olively_header'
	));
	
	$wp_customize->add_setting(
		'olively_social_enable', array(
			'default'	=>	1,
			'sanitize_callback'	=>	'olively_sanitize_checkbox'
		)
	);
	
	$wp_customize->add_control(
		'olively_social_enable', array(
			'label'	=>	__('Enable Social Icons in Header', 'olively'),
			'type'	=>	'checkbox',
			'section'	=>	'olively_social_section',
			'priority'	=>	5
		)
	);

	$social_networks = array( //Redefinied in Sanitization Function.
					'none' 			=> esc_html__('-','olively'),
					'facebook-f' 	=> esc_html__('Facebook', 'olively'),
					'twitter' 		=> esc_html__('Twitter', 'olively'),
					'instagram' 	=> esc_html__('Instagram', 'olively'),
					'rss' 			=> esc_html__('RSS Feeds', 'olively'),
					'pinterest-p' 	=> esc_html__('Pinterest', 'olively'),
					'vimeo' 		=> esc_html__('Vimeo', 'olively'),
					'youtube' 		=> esc_html__('Youtube', 'olively'),
					'flickr' 		=> esc_html__('Flickr', 'olively'),
				);


    $social_count = count($social_networks);

	for ($x = 1 ; $x <= ($social_count - 3) ; $x++) :

		$wp_customize->add_setting(
			'olively_social_'.$x, array(
				'sanitize_callback' => 'olively_sanitize_social',
				'default' 			=> 'none',
				'transport'			=> 'postMessage'
			));

		$wp_customize->add_control( 'olively_social_' . $x, array(
					'settings' 	=> 'olively_social_'.$x,
					'label' 	=> esc_html__('Icon ','olively') . $x,
					'section' 	=> 'olively_social_section',
					'type' 		=> 'select',
					'choices' 	=> $social_networks,
		));

		$wp_customize->add_setting(
			'olively_social_url'.$x, array(
				'sanitize_callback' => 'esc_url_raw'
			));

		$wp_customize->add_control( 'olively_social_url' . $x, array(
			'label' 		=> esc_html__('Icon ','olively') . $x . esc_html__(' Url','olively'),
					'settings' 		=> 'olively_social_url' . $x,
					'section' 		=> 'olively_social_section',
					'type' 			=> 'url',
					'choices' 		=> $social_networks,
		));

	endfor;

	function olively_sanitize_social( $input ) {
		$social_networks = array(
					'none' ,
					'facebook-f',
					'twitter',
					'instagram',
					'rss',
					'pinterest-p',
					'vimeo',
					'youtube',
					'flickr'
				);
		if ( in_array($input, $social_networks) )
			return $input;
		else
			return '';
	}
}
add_action( 'customize_register', 'olively_customize_register_social' );
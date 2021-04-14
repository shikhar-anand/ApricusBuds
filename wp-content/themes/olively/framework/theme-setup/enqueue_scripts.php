<?php
/**
 * Enqueue scripts and styles.
 */
function olively_scripts() {
	wp_enqueue_style( 'olively-style', get_stylesheet_uri(), array(), OLIVELY_VERSION );
	wp_style_add_data( 'olively-style', 'rtl', 'replace' );
	
	wp_enqueue_script('jquery-ui-tabs');
	
	wp_enqueue_style( 'olively-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap', array(), OLIVELY_VERSION );

	wp_enqueue_style( 'olively-main-style', esc_url(get_template_directory_uri() . '/assets/theme-styles/css/default.css'), array(), OLIVELY_VERSION );
	
	wp_enqueue_style( 'bootstrap', esc_url(get_template_directory_uri() . '/assets/bootstrap/bootstrap.css'), array(), OLIVELY_VERSION );
	
	wp_enqueue_style( 'owl', esc_url(get_template_directory_uri() . '/assets/owl/owl.carousel.css'), array(), OLIVELY_VERSION );
	
	wp_enqueue_style( 'font-awesome', esc_url(get_template_directory_uri() . '/assets/fonts/font-awesome.css'), array(), OLIVELY_VERSION );
	
	wp_enqueue_script( 'big-slide', esc_url(get_template_directory_uri() . '/assets/js/bigSlide.js'), array('jquery'), OLIVELY_VERSION, true );
	
	wp_enqueue_script( 'olively-custom-js', esc_url(get_template_directory_uri() . '/assets/js/custom.js'), array('jquery'), OLIVELY_VERSION, true );
	
	wp_enqueue_script( 'owl-js', esc_url(get_template_directory_uri() . '/assets/js/owl.carousel.js'), array('jquery'), OLIVELY_VERSION, true );

	wp_enqueue_script( 'olively-navigation', esc_url(get_template_directory_uri() . '/assets/js/navigation.js'), array(), OLIVELY_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'olively_scripts' );
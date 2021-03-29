<?php

// add filter for "Next Page" label
if( $this->get_content_field_value( 'post_navigation_next_text' ) ) {
	global $theme_integration_post_navigation_next_text;
	$theme_integration_post_navigation_next_text = $this->get_content_field_value( 'post_navigation_next_text' );

	if( !function_exists( 'theme_integration_post_navigation_next_label' ) ) {
		function theme_integration_post_navigation_next_label( $text ) {
			global $theme_integration_post_navigation_next_text;

			return esc_attr( $theme_integration_post_navigation_next_text );
		}
	}

	add_filter( 'genesis_next_link_text', 'theme_integration_post_navigation_next_label' );
}

// add filter for "Previous Page" label
if( $this->get_content_field_value( 'post_navigation_prev_text' ) ) {
	global $theme_integration_post_navigation_prev_text;
	$theme_integration_post_navigation_prev_text = $this->get_content_field_value( 'post_navigation_prev_text' );

	if( !function_exists( 'theme_integration_post_navigation_prev_label' ) ) {
		function theme_integration_post_navigation_prev_label( $text ) {
			global $theme_integration_post_navigation_prev_text;

			return esc_attr( $theme_integration_post_navigation_prev_text );
		}
	}

	add_filter( 'genesis_prev_link_text', 'theme_integration_post_navigation_prev_label' );
}

// output
if ( 'numeric' === $this->get_content_field_value( 'post_navigation_layout' ) )
	genesis_numeric_posts_nav();
else
	genesis_prev_next_posts_nav();


// remove filters
remove_filter( 'genesis_next_link_text', 'theme_integration_post_navigation_next_label' );
remove_filter( 'genesis_prev_link_text', 'theme_integration_post_navigation_prev_label' );
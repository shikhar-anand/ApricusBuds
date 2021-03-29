<?php

// author title
if( $this->get_content_field_value( 'author_box_title' ) ) {
	global $theme_integration_author_box_title;
	$theme_integration_author_box_title = str_replace(
		'%author%',
		'<span itemprop="name">' . get_the_author() . '</span>',
		$this->get_content_field_value( 'author_box_title' ) );

	if( !function_exists( 'theme_integration_author_box_title' ) ) {
		function theme_integration_author_box_title( $text ) {
			global $theme_integration_author_box_title;

			return $theme_integration_author_box_title;
		}
	}

	add_filter( 'genesis_author_box_title', 'theme_integration_author_box_title' );
}

// gravatar size
global $theme_integration_author_box_gravatar_size;
if( $this->get_content_field_value( 'author_box_gravatar_size' ) !== false ) {
	$theme_integration_author_box_gravatar_size = intval( $this->get_content_field_value( 'author_box_gravatar_size' ) );

	if( !function_exists( 'theme_integration_author_box_gravatar_size' ) ) {
		function theme_integration_author_box_gravatar_size( $size ) {
			global $theme_integration_author_box_gravatar_size;

			if( $theme_integration_author_box_gravatar_size > 0 )
				return $theme_integration_author_box_gravatar_size;

			return '';
		}
	}

	if( $theme_integration_author_box_gravatar_size > 0 )
		add_filter( 'genesis_author_box_gravatar_size', 'theme_integration_author_box_gravatar_size' );
	else
		add_filter( 'get_avatar', 'theme_integration_author_box_gravatar_size' );
}


genesis_author_box( 'single' );


remove_filter( 'genesis_author_box_title', 'theme_integration_author_box_title' );

if( $theme_integration_author_box_gravatar_size > 0 )
	remove_filter( 'genesis_author_box_gravatar_size', 'theme_integration_author_box_gravatar_size' );
else
	remove_filter( 'get_avatar', 'theme_integration_author_box_gravatar_size' );
<?php

$unique_id = rand( 1, 999999 );

// btn text
if( $this->get_content_field_value( 'search_form_btn_text' ) ) {
	global $theme_integration_search_button_text;
	$theme_integration_search_button_text = $this->get_content_field_value( 'search_form_btn_text' );

	if( !function_exists( 'theme_integration_search_form_btn_text' ) ) {
		function theme_integration_search_form_btn_text( $btn_text ) {
			global $theme_integration_search_button_text;

			return esc_attr( $theme_integration_search_button_text );
		}
	}

	add_filter( 'genesis_search_button_text', 'theme_integration_search_form_btn_text' );
}

// placeholder text
if( $this->get_content_field_value( 'search_form_placeholder_text' ) ) {
	global $theme_integration_search_placeholder_text;
	$theme_integration_search_placeholder_text = $this->get_content_field_value( 'search_form_placeholder_text' );

	if( !function_exists( 'theme_integration_search_form_placeholder_text' ) ) {
		function theme_integration_search_form_placeholder_text( $btn_text ) {
			global $theme_integration_search_placeholder_text;

			return esc_attr( $theme_integration_search_placeholder_text );
		}
	}

	add_filter( 'genesis_search_text', 'theme_integration_search_form_placeholder_text' );
}

// display style
if( $this->get_content_field_value( 'search_form_layout' ) )
	echo '<div class="theme-integration-' . $this->get_content_field_value( 'search_form_layout' ) . '">';

get_search_form();

if( $this->get_content_field_value( 'search_form_layout' ) )
	echo '</div>';


remove_filter( 'genesis_search_button_text', 'theme_integration_search_form_btn_text' );
remove_filter( 'genesis_search_text', 'theme_integration_search_form_placeholder_text' );
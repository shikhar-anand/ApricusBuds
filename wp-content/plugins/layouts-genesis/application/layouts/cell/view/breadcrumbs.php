<?php

// Home Link
if( $this->get_content_field_value( 'breadcrumbs_home_link' ) ) {
	global $theme_integration_breadcrumbs_home_link;

	$theme_integration_breadcrumbs_home_link = $this->get_content_field_value( 'breadcrumbs_home_link' );

	if( !function_exists( 'theme_integration_breadcrumbs_home_link' ) ) {
		function theme_integration_breadcrumbs_home_link( $link ) {
			global $theme_integration_breadcrumbs_home_link;

			return preg_replace( '/href="[^"]*"/', 'href="' . $theme_integration_breadcrumbs_home_link . '"', $link);
		}
	}

	add_filter( 'genesis_home_crumb', 'theme_integration_breadcrumbs_home_link' );
	add_filter( 'genesis_breadcrumb_homelink', 'theme_integration_breadcrumbs_home_link' );
}

// Attributes: Home Label - Separator - Prefix Label
if( $this->get_content_field_value( 'breadcrumbs_home_label' ) ) {
	global $theme_integration_breadcrumbs_attributes;

	$theme_integration_breadcrumbs_attributes = array(
		'home' => $this->get_content_field_value( 'breadcrumbs_home_label' ),
		'sep' => $this->get_content_field_value( 'breadcrumbs_separator' ),
		'labels' => array(
			'prefix' => $this->get_content_field_value( 'breadcrumbs_prefix' ),
		)
	);

	if( !function_exists( 'theme_integration_breadcrumbs_attributes' ) ) {
		function theme_integration_breadcrumbs_attributes( $attributes ) {
			global $theme_integration_breadcrumbs_attributes;

			return array_replace_recursive( $attributes, $theme_integration_breadcrumbs_attributes );
		}
	}

	add_filter( 'genesis_breadcrumb_args', 'theme_integration_breadcrumbs_attributes' );
}

/*
 * Original Code of genesis_do_breadcrumbs() in genesis/lib/functions/breadcrumbs
 */
$breadcrumb_markup_open = sprintf( '<div %s>', genesis_attr( 'breadcrumb' ) );

if ( function_exists( 'bcn_display' ) ) {
	echo $breadcrumb_markup_open;
	bcn_display();
	echo '</div>';
}
elseif ( function_exists( 'breadcrumbs' ) ) {
	breadcrumbs();
}
elseif ( function_exists( 'crumbs' ) ) {
	crumbs();
}
elseif ( class_exists( 'WPSEO_Breadcrumbs' ) && genesis_get_option( 'breadcrumbs-enable', 'wpseo_internallinks' ) ) {
	yoast_breadcrumb( $breadcrumb_markup_open, '</div>' );
}
elseif( function_exists( 'yoast_breadcrumb' ) && ! class_exists( 'WPSEO_Breadcrumbs' ) ) {
	yoast_breadcrumb( $breadcrumb_markup_open, '</div>' );
}
else {
	genesis_breadcrumb();
}

remove_filter( 'genesis_home_crumb', 'theme_integration_home_link' );
remove_filter( 'genesis_breadcrumb_homelink', 'theme_integration_home_link' );
remove_filter( 'genesis_breadcrumb_args', 'theme_integration_breadcrumbs_attributes' );
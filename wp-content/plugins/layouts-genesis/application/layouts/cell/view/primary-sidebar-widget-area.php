<?php

add_filter( 'genesis_attr_theme-integration-sidebar-primary', 'genesis_attributes_sidebar_primary' );

genesis_markup( array(
	'html5'   => '<aside %s>' . genesis_sidebar_title( 'sidebar' ),
	'xhtml'   => '<div id="sidebar" class="sidebar widget-area">',
	'context' => 'theme-integration-sidebar-primary',
) );

add_action( 'genesis_sidebar', 'genesis_do_sidebar' );
do_action( 'genesis_before_sidebar_widget_area' );
do_action( 'genesis_sidebar' );
do_action( 'genesis_after_sidebar_widget_area' );
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

genesis_markup( array(
	'html5' => '</aside>', //* end .sidebar-primary
	'xhtml' => '</div>', //* end #sidebar
	'context' => 'theme-integration-sidebar-primary-close'
) );

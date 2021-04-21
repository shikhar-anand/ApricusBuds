<?php
/**
 *	Custom Color Control
 */

function olively_hex_to_rgb($color, $opacity) {
	
	if (strpos($color, '#') !== false ) {
		$color = substr($color, 1);
	}
	
	$split	=	str_split($color, 2);
	$r		=	hexdec($split[0]);
	$g		=	hexdec($split[1]);
	$b		=	hexdec($split[2]);
	
	return 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $opacity . ')';
}
 
function olively_custom_colors() {
	
	$title_color	=	get_theme_mod('header_textcolor', 'ffffff');
	$bg_color 		=	get_theme_mod('background_color', 'ffffff');
	$body_color 	=	get_theme_mod('olively-body-color', '000000');
	$theme_color	=	get_theme_mod('olively-theme-color', '#7a94ce');
	
	$colors = "";
	// Title Color
	$colors .= '#header_content_wrapper,
				#masthead #top-bar button
				{color: #' . $title_color . '}';
	// Background Color Control
	$colors .= '.olively-content-svg path {fill: #' .  $bg_color . '}';
	
	// Body Color Control
	$colors .= 'body {color: ' . $body_color . '}';
	
	// Theme Color Control
	$colors .= 'a, button, cite,
				.widget-area:not(#footer-sidebar) ul li:before,
				#panel-top-bar .menu-link i.fa-chevron-right,
				#menu ul li a,
				#menu ul li.menu-item-has-children span.dropdown-arrow i,
				#menu ul li.menu-item-has-children ul a,
				body article .entry-meta i,
				body article .entry-footer .cat-links a, body article .entry-footer .tags-links a,
				.olively-btn.secondary,
				.olively-read-more .more-link,
				#respond input.submit,
				.widget.widget_olively_cat_slider .owl-nav span
				{color: ' . $theme_color . '}';
				
	$colors .= 'blockquote,
				#respond input.submit,
				.olively-read-more .more-link
				{border-color: ' . $theme_color . '}';
				
	$colors .= '.widget.widget_olively_cats_tab ul li.ui-tabs-active:after,
				.widget.widget_olively_cats_tab .tabs-slider
				{border-top-color: ' . $theme_color . '}';
	
	$colors .= '#search-screen {background-color: ' . olively_hex_to_rgb($theme_color, 0.85) . '}';
	
	$colors .= '#menu ul li.menu-item-has-children ul {background-color: ' . olively_hex_to_rgb($theme_color, 0.1) . '}';
	
	$colors .= '#header-image #header_content_wrapper,
				body article.olively-card .olively-thumb .card-posted-on
				{background-color: ' . olively_hex_to_rgb($theme_color, 0.3) . '}';
	
	$colors .= 'ins,
				#masthead #top-bar,
				#footer-sidebar,
				#panel-top-bar,
				.olively-btn.primary,
				.edit-link .post-edit-link,
				.widget.widget_olively_cats_tab ul li a,
				.widget.widget_olively_cat_slider .slide-title,
				#comments .comment .reply a,
				#colophon
				{background-color: ' . $theme_color . '}';
				
	$colors .= '#footer-sidebar .footer-content-svg path { fill: ' . $theme_color . '}';
	
	wp_add_inline_style('olively-main-style', esc_html($colors));

}
add_action('wp_enqueue_scripts', 'olively_custom_colors');

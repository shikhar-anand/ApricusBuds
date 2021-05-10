<?php
/**
 *	Functions for Selective Refresh
 */
 
function olively_featured_page_refresh() {
	
	$id 			= get_theme_mod('lively_featured_page', 0);
	$featured_page	= get_post($id);
	
	$output = '';
	$output .= '<div id="olively-featured-page">';
	$output .= '<h3 id="featured-page-title"><a href="' . the_permalink($featured_page) . '" title="' . esc_attr(get_the_title($featured_page)) . '">' . esc_html(get_the_title($featured_page)) . '</a></h3>';
	$output .= '<p id="olively-featured-excerpt">' . do_action('olively_blog_excerpt', $featured_page, 15) . '</p>';
	$output .= '</div>';
	
	return $output;
	
}
<?php
/**
 *  File for Custom CSS
 */

function olively_custom_css() {

    $primary_width     = 100 - get_theme_mod('olively_sidebar_width', '25') . '%';
    $secondary_width   = get_theme_mod('olively_sidebar_width', '25') . '%';

    $css = "";
    
    $css .= "@media screen and (min-width: 992px) {";

    if (is_home() && is_active_sidebar('sidebar-1') && get_theme_mod('olively_blog_sidebar_enable', 1) !== '' ) {
        $css .= 'body.blog #primary  {width: ' . $primary_width . ';}';
        $css .= 'body.blog #secondary {width: ' . $secondary_width . ';}';
    }
    
    if (is_single() && is_active_sidebar('sidebar-single') && get_theme_mod('olively_single_sidebar_enable', 1) !== '' ) {
        $css .= 'body.single-post #primary {width: ' . $primary_width . ';}';
        $css .= 'body.single-post #secondary {width: ' . $secondary_width . ';}';
    }
    
    if (is_search() && is_active_sidebar('sidebar-1') && get_theme_mod('olively_search_sidebar_enable', 1) !== '' ) {
        $css .= 'body.search #primary {width: ' . $primary_width . ';}';
        $css .= 'body.search #secondary {width: ' . $secondary_width . ';}';
    }
    
    if (is_archive() && is_active_sidebar('sidebar-1') && get_theme_mod('olively_archive_sidebar_enable', 1) !== '' ) {
        $css .= 'body.archive #primary {width: ' . $primary_width . ';}';
        $css .= 'body.archive #secondary {width: ' . $secondary_width . ';}';
    }
    
    if (!is_front_page() && is_page() && is_active_sidebar('sidebar-page') && get_post_meta(get_the_ID(), 'enable-sidebar', true) !== '' ) {
        $css .= 'body.page-template-default #primary {width: ' . $primary_width . ';}';
        $css .= 'body.page-template-default #secondary {width: ' . $secondary_width . ';}';
    }

	$css .= "}";
	
	// Navigation Button margin for logged-in users
	if ( is_user_logged_in() ) {
		$css .= 'button#close-menu {margin-top: 3em !important;}';
	}
	
	// Front Page Custom Post
	if (!empty(get_theme_mod('olively_front_custom_post'))) {
		$css .= '#f_post_image {background-image: url("' . get_the_post_thumbnail_url(get_theme_mod('olively_front_custom_post')) . '")}';
	}
	
	if (!empty(get_theme_mod('olively_footer_bg'))) {
		$css .= '#footer-bg {background-image: url("' . get_theme_mod('olively_footer_bg') . '")}';
	}

     wp_add_inline_style( 'olively-main-style', wp_strip_all_tags($css) );

 }
 add_action('wp_enqueue_scripts', 'olively_custom_css');
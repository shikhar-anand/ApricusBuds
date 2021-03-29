<?php
/**
 * The template for displaying the header
 *
 * Taken from Twenty Fifteen. The difference is that it doesn't contain the sidebar and the site-content div.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyfifteen' ); ?></a>

	<div id="sidebar" class="sidebar">
            <?php dynamic_sidebar( 'sidebar-header' ); ?>
            <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                <div id="secondary" class="secondary">
                        <?php dynamic_sidebar( 'sidebar-1' ); ?>
                </div>
            <?php endif; ?>
	</div><!-- .sidebar -->

	<div id="content" class="site-content">
            
            <div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
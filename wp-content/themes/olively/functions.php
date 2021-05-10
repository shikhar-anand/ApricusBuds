<?php
/**
 * Olively functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Olively
 */

if ( ! defined( 'OLIVELY_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'OLIVELY_VERSION', '1.0.8' );
}

if ( ! function_exists( 'olively_setup' ) ) :
	/** 
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function olively_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Olively, use a find and replace
		 * to change 'olively' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'olively', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'olively' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'olively_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		// Custom Image sizes for the theme
		add_image_size('olively_card_thumb', 600, 480, true);
		add_image_size('olively_list_thumb', 500, 500, true);
		add_image_size('olively_slide', 1200, 500, true);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 60,
				'width'       => 240,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'olively_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function olively_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'olively_content_width', 640 );
}
add_action( 'after_setup_theme', 'olively_content_width', 0 );

/**
 * Register widget area.
 */
require get_template_directory() . '/framework/theme-setup/register_sidebars.php';


/**
 *	Enqueue Front-end Theme Scripts and Styles
 */
require get_template_directory() . '/framework/theme-setup/enqueue_scripts.php';

/**
 *	Enqueue Back-end Theme Scripts and Styles
 */
 require get_template_directory() . '/framework/theme-setup/admin_scripts.php';

/**
 *	Functions for the masthead.
 */
 require get_template_directory() . '/inc/masthead.php';
 

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 *	Custom CSS 
 */
require get_template_directory() . '/inc/css-mods.php';

/**
 *	Include Starter Content
 */
require get_template_directory() . '/inc/starter-content.php';

/**
 *	Block Patterns
 */
require get_template_directory() . '/inc/block-styles.php';

/**
 *	Block Patterns
 */
require get_template_directory() . '/inc/block-patterns.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/framework/customizer/customizer.php';

/**
 *	Add Menu Walker
 */
require get_template_directory() . '/inc/walker.php';

/**
 *	The Meta Box for the Page
 */
require get_template_directory() . '/framework/metabox/display-options.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 *	Custom Widgets
 */
require get_template_directory() . '/framework/widgets/featured-category.php';
require get_template_directory() . '/framework/widgets/recent-posts.php';
require get_template_directory() . '/framework/widgets/slider-category.php';
require get_template_directory() . '/framework/widgets/tab-categories.php';
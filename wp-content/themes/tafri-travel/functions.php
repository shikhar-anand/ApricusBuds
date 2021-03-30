<?php
/**
 * Tafri Travel functions and definitions
 *
 * @package tafri-travel
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 */

/* Breadcrumb Begin */
function tafri_travel_the_breadcrumb() {
	if (!is_home()) {
		echo '<a href="';
			echo esc_url( home_url() );
		echo '">';
			bloginfo('name');
		echo "</a> ";
		if (is_category() || is_single()) {
			the_category(',');
			if (is_single()) {
				echo "<span> ";
					the_title();
				echo "</span> ";
			}
		} elseif (is_page()) {
			the_title();
		}
	}
}

/* Theme Setup */
if (!function_exists('tafri_travel_setup')):

function tafri_travel_setup() {

	$GLOBALS['content_width'] = apply_filters('tafri_travel_content_width', 640);

	load_theme_textdomain( 'tafri-travel', get_template_directory() . '/languages' );
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support('woocommerce');
	add_theme_support('title-tag');
	add_theme_support('custom-logo', array(
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	));
	add_image_size('tafri-travel-homepage-thumb', 250, 145, true);
	register_nav_menus( array(
		'left-primary' => __( 'Left Menu', 'tafri-travel' ),
		'right-primary' => __( 'Right Menu', 'tafri-travel' ),
		'responsive-menu' => __( 'Responsive Menu', 'tafri-travel' ),
	) );
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array('image','video','gallery','audio',) );
	
	add_theme_support('custom-background', array(
		'default-color' => 'f1f1f1',
	));

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style(array('assets/css/editor-style.css', tafri_travel_font_url()));
}

endif;
add_action('after_setup_theme', 'tafri_travel_setup');

// Theme Widgets Setup
function tafri_travel_widgets_init() {
	register_sidebar(array(
		'name'          => __('Blog Sidebar', 'tafri-travel'),
		'description'   => __('Appears on blog page sidebar', 'tafri-travel'),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	register_sidebar(array(
		'name'          => __('Page Sidebar', 'tafri-travel'),
		'description'   => __('Appears on page sidebar', 'tafri-travel'),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	register_sidebar(array(
		'name'          => __('Third Column Sidebar', 'tafri-travel'),
		'description'   => __('Appears on page sidebar', 'tafri-travel'),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	//Footer widget areas
	$tafri_travel_widget_areas = get_theme_mod('tafri_travel_footer_widget', '4');
	for ($i=1; $i<=$tafri_travel_widget_areas; $i++) {
		register_sidebar( array(
			'name'          => __( 'Footer ', 'tafri-travel' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s py-4">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

	register_sidebar( array(
		'name'          => __( 'Shop Page Sidebar', 'tafri-travel' ),
		'description'   => __( 'Appears on shop page', 'tafri-travel' ),
		'id'            => 'woocommerce-shop-page-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Single Product Page Sidebar', 'tafri-travel' ),
		'description'   => __( 'Appears on Single Product Page', 'tafri-travel' ),
		'id'            => 'single-product-page-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action('widgets_init', 'tafri_travel_widgets_init');

/* Theme Font URL */
function tafri_travel_font_url(){
	$font_url = '';
	$font_family = array();
	$font_family[] = 'Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i';
	$font_family[] = 'Merienda One';
	$font_family[] = 'Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
	$font_family[] = 'B612:400,400i,700,700i';
	$font_family[] = 'Kalam:300,400,700';
	$font_family[] = 'PT Sans:300,400,600,700,800,900';
	$font_family[] = 'Roboto:400,700';
	$font_family[] = 'Roboto Condensed:400,700';
	$font_family[] = 'Open Sans';
	$font_family[] = 'Overpass';
	$font_family[] = 'Montserrat:300,400,600,700,800,900';
	$font_family[] = 'Playball:300,400,600,700,800,900';
	$font_family[] = 'Alegreya:300,400,600,700,800,900';
	$font_family[] = 'Julius Sans One';
	$font_family[] = 'Arsenal';
	$font_family[] = 'Slabo';
	$font_family[] = 'Lato';
	$font_family[] = 'Overpass Mono';
	$font_family[] = 'Source Sans Pro';
	$font_family[] = 'Raleway';
	$font_family[] = 'Merriweather';
	$font_family[] = 'Droid Sans';
	$font_family[] = 'Rubik';
	$font_family[] = 'Lora';
	$font_family[] = 'Ubuntu';
	$font_family[] = 'Cabin';
	$font_family[] = 'Arimo';
	$font_family[] = 'Playfair Display';
	$font_family[] = 'Quicksand';
	$font_family[] = 'Padauk';
	$font_family[] = 'Muli';
	$font_family[] = 'Inconsolata';
	$font_family[] = 'Bitter';
	$font_family[] = 'Pacifico';
	$font_family[] = 'Indie Flower';
	$font_family[] = 'VT323';
	$font_family[] = 'Dosis';
	$font_family[] = 'Frank Ruhl Libre';
	$font_family[] = 'Fjalla One';
	$font_family[] = 'Oxygen';
	$font_family[] = 'Arvo';
	$font_family[] = 'Noto Serif';
	$font_family[] = 'Lobster';
	$font_family[] = 'Crimson Text';
	$font_family[] = 'Yanone Kaffeesatz';
	$font_family[] = 'Anton';
	$font_family[] = 'Libre Baskerville';
	$font_family[] = 'Bree Serif';
	$font_family[] = 'Gloria Hallelujah';
	$font_family[] = 'Josefin Sans';
	$font_family[] = 'Abril Fatface';
	$font_family[] = 'Varela Round';
	$font_family[] = 'Vampiro One';
	$font_family[] = 'Shadows Into Light';
	$font_family[] = 'Cuprum';
	$font_family[] = 'Rokkitt';
	$font_family[] = 'Vollkorn';
	$font_family[] = 'Francois One';
	$font_family[] = 'Orbitron';
	$font_family[] = 'Patua One';
	$font_family[] = 'Acme';
	$font_family[] = 'Satisfy';
	$font_family[] = 'Josefin Slab';
	$font_family[] = 'Quattrocento Sans';
	$font_family[] = 'Architects Daughter';
	$font_family[] = 'Russo One';
	$font_family[] = 'Monda';
	$font_family[] = 'Righteous';
	$font_family[] = 'Lobster Two';
	$font_family[] = 'Hammersmith One';
	$font_family[] = 'Courgette';
	$font_family[] = 'Permanent Marker';
	$font_family[] = 'Cherry Swash';
	$font_family[] = 'Cormorant Garamond';
	$font_family[] = 'Poiret One';
	$font_family[] = 'BenchNine';
	$font_family[] = 'Economica';
	$font_family[] = 'Handlee';
	$font_family[] = 'Cardo';
	$font_family[] = 'Alfa Slab One';
	$font_family[] = 'Averia Serif Libre';
	$font_family[] = 'Cookie';
	$font_family[] = 'Chewy';
	$font_family[] = 'Great Vibes';
	$font_family[] = 'Coming Soon';
	$font_family[] = 'Philosopher';
	$font_family[] = 'Days One';
	$font_family[] = 'Kanit';
	$font_family[] = 'Shrikhand';
	$font_family[] = 'Tangerine';
	$font_family[] = 'IM Fell English SC';
	$font_family[] = 'Boogaloo';
	$font_family[] = 'Bangers';
	$font_family[] = 'Fredoka One';
	$font_family[] = 'Bad Script';
	$font_family[] = 'Volkhov';
	$font_family[] = 'Shadows Into Light Two';
	$font_family[] = 'Marck Script';
	$font_family[] = 'Sacramento';
	$font_family[] = 'Unica One';
	$font_family[] = 'Noto Sans:400,400i,700,700i';

	$query_args = array(
		'family'	=> rawurlencode(implode('|',$font_family)),
	);
	$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
	return $font_url;
}

function tafri_travel_sanitize_dropdown_pages($page_id, $setting) {
	// Ensure $input is an absolute integer.
	$page_id = absint($page_id);
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ('publish' == get_post_status($page_id)?$page_id:$setting->default);
}

// radio button sanitization
function tafri_travel_sanitize_choices($input, $setting) {
	global $wp_customize;
	$control = $wp_customize->get_control($setting->id);
	if (array_key_exists($input, $control->choices)) {
		return $input;
	} else {
		return $setting->default;
	}
}

function tafri_travel_sanitize_checkbox( $input ) {
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function tafri_travel_sanitize_float( $input ) {
	return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

function tafri_travel_sanitize_number_range( $number, $setting ) {
	$number = absint( $number );
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

function tafri_travel_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

// Excerpt Limit Begin
function tafri_travel_string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'tafri_travel_loop_columns');
if (!function_exists('tafri_travel_loop_columns')) {
	function tafri_travel_loop_columns() {
		$columns = get_theme_mod( 'tafri_travel_woocommerce_product_per_columns', 3 );
		return $columns; // 3 products per row
	}
}

//Change number of products that are displayed per page (shop page)
add_filter( 'loop_shop_per_page', 'tafri_travel_shop_per_page', 20 );
function tafri_travel_shop_per_page( $cols ) {
  	$cols = get_theme_mod( 'tafri_travel_woocommerce_product_per_page', 9 );
	return $cols;
}

// Theme enqueue scripts
function tafri_travel_scripts() {
	wp_enqueue_style('tafri-travel-font', tafri_travel_font_url(), array());
	wp_enqueue_style( 'tafri-travel-block-style', get_theme_file_uri('/assets/css/blocks.css') );
	wp_enqueue_style('bootstrap-style', esc_url(get_template_directory_uri()).'/assets/css/bootstrap.css');
	wp_enqueue_style('tafri-travel-basic-style', get_stylesheet_uri());
	wp_enqueue_style('tafri-travel-customcss', esc_url(get_template_directory_uri()).'/assets/css/custom.css');
	wp_enqueue_style('font-awesome-style', esc_url(get_template_directory_uri()).'/assets/css/fontawesome-all.css');

	// Paragraph
    $tafri_travel_paragraph_color = get_theme_mod('tafri_travel_paragraph_color', '');
    $tafri_travel_paragraph_font_family = get_theme_mod('tafri_travel_paragraph_font_family', '');
    $tafri_travel_paragraph_font_size = get_theme_mod('tafri_travel_paragraph_font_size', '');
	// "a" tag
	$tafri_travel_atag_color = get_theme_mod('tafri_travel_atag_color', '');
    $tafri_travel_atag_font_family = get_theme_mod('tafri_travel_atag_font_family', '');
	// "li" tag
	$tafri_travel_li_color = get_theme_mod('tafri_travel_li_color', '');
    $tafri_travel_li_font_family = get_theme_mod('tafri_travel_li_font_family', '');
	// H1
	$tafri_travel_h1_color = get_theme_mod('tafri_travel_h1_color', '');
    $tafri_travel_h1_font_family = get_theme_mod('tafri_travel_h1_font_family', '');
    $tafri_travel_h1_font_size = get_theme_mod('tafri_travel_h1_font_size', '');
	// H2
	$tafri_travel_h2_color = get_theme_mod('tafri_travel_h2_color', '');
    $tafri_travel_h2_font_family = get_theme_mod('tafri_travel_h2_font_family', '');
    $tafri_travel_h2_font_size = get_theme_mod('tafri_travel_h2_font_size', '');
	// H3
	$tafri_travel_h3_color = get_theme_mod('tafri_travel_h3_color', '');
    $tafri_travel_h3_font_family = get_theme_mod('tafri_travel_h3_font_family', '');
    $tafri_travel_h3_font_size = get_theme_mod('tafri_travel_h3_font_size', '');
	// H4
	$tafri_travel_h4_color = get_theme_mod('tafri_travel_h4_color', '');
    $tafri_travel_h4_font_family = get_theme_mod('tafri_travel_h4_font_family', '');
    $tafri_travel_h4_font_size = get_theme_mod('tafri_travel_h4_font_size', '');
	// H5
	$tafri_travel_h5_color = get_theme_mod('tafri_travel_h5_color', '');
    $tafri_travel_h5_font_family = get_theme_mod('tafri_travel_h5_font_family', '');
    $tafri_travel_h5_font_size = get_theme_mod('tafri_travel_h5_font_size', '');
	// H6
	$tafri_travel_h6_color = get_theme_mod('tafri_travel_h6_color', '');
    $tafri_travel_h6_font_family = get_theme_mod('tafri_travel_h6_font_family', '');
    $tafri_travel_h6_font_size = get_theme_mod('tafri_travel_h6_font_size', '');

	$tafri_travel_custom_css ='
		p,span{
		    color:'.esc_html($tafri_travel_paragraph_color).'!important;
		    font-family: '.esc_html($tafri_travel_paragraph_font_family).';
		    font-size: '.esc_html($tafri_travel_paragraph_font_size).';
		}
		a{
		    color:'.esc_html($tafri_travel_atag_color).'!important;
		    font-family: '.esc_html($tafri_travel_atag_font_family).';
		}
		li{
		    color:'.esc_html($tafri_travel_li_color).'!important;
		    font-family: '.esc_html($tafri_travel_li_font_family).';
		}
		h1{
		    color:'.esc_html($tafri_travel_h1_color).'!important;
		    font-family: '.esc_html($tafri_travel_h1_font_family).'!important;
		    font-size: '.esc_html($tafri_travel_h1_font_size).'!important;
		}
		h2{
		    color:'.esc_html($tafri_travel_h2_color).'!important;
		    font-family: '.esc_html($tafri_travel_h2_font_family).'!important;
		    font-size: '.esc_html($tafri_travel_h2_font_size).'!important;
		}
		h3{
		    color:'.esc_html($tafri_travel_h3_color).'!important;
		    font-family: '.esc_html($tafri_travel_h3_font_family).'!important;
		    font-size: '.esc_html($tafri_travel_h3_font_size).'!important;
		}
		h4{
		    color:'.esc_html($tafri_travel_h4_color).'!important;
		    font-family: '.esc_html($tafri_travel_h4_font_family).'!important;
		    font-size: '.esc_html($tafri_travel_h4_font_size).'!important;
		}
		h5{
		    color:'.esc_html($tafri_travel_h5_color).'!important;
		    font-family: '.esc_html($tafri_travel_h5_font_family).'!important;
		    font-size: '.esc_html($tafri_travel_h5_font_size).'!important;
		}
		h6{
		    color:'.esc_html($tafri_travel_h6_color).'!important;
		    font-family: '.esc_html($tafri_travel_h6_font_family).'!important;
		    font-size: '.esc_html($tafri_travel_h6_font_size).'!important;
		}
	';

	wp_add_inline_style( 'tafri-travel-basic-style',$tafri_travel_custom_css );
	
	wp_enqueue_script('tafri-travel-customscripts-jquery', esc_url(get_template_directory_uri()).'/assets/js/custom.js', array('jquery'));
	wp_enqueue_script('bootstrap-jquery', esc_url(get_template_directory_uri()).'/assets/js/bootstrap.js', array('jquery'));
	wp_enqueue_script( 'jquery-superfish', esc_url(get_template_directory_uri()) . '/assets/js/jquery.superfish.js', array('jquery') ,'',true);
	require get_parent_theme_file_path( '/color-option.php' );
	wp_add_inline_style( 'tafri-travel-basic-style',$tafri_travel_custom_css );
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'tafri_travel_scripts');

define('TAFRI_TRAVEL_LIVE_DEMO',__('https://www.themeseye.com/demo/tafri-travel-pro/','tafri-travel'));
define('TAFRI_TRAVEL_BUY_PRO',__('https://www.themeseye.com/wordpress/wordpress-travel-theme/','tafri-travel'));
define('TAFRI_TRAVEL_PRO_DOC',__('https://themeseye.com/theme-demo/docs/tafri-travel-pro/','tafri-travel'));
define('TAFRI_TRAVEL_FREE_DOC',__('https://themeseye.com/theme-demo/docs/free-tafri-travel/','tafri-travel'));
define('TAFRI_TRAVEL_PRO_SUPPORT',__('https://www.themeseye.com/forums/forum/themeseye-support/','tafri-travel'));
define('TAFRI_TRAVEL_FREE_SUPPORT',__('https://wordpress.org/support/theme/tafri-travel/','tafri-travel'));
define('TAFRI_TRAVEL_CREDIT',__('https://www.themeseye.com/wordpress/free-wordpress-travel-theme/','tafri-travel'));

if ( ! function_exists( 'tafri_travel_credit' ) ) {
	function tafri_travel_credit(){
		echo "<a href=".esc_url(TAFRI_TRAVEL_CREDIT).">".esc_html__('Travel WordPress Theme','tafri-travel')."</a>";
	}
}

function tafri_travel_enable_image_dimention(){
	if(get_theme_mod('tafri_travel_post_image_dimention') == 'Custom Image Size' ) {
		return true;
	}
	return false;
}

function tafri_travel_show_post_color(){
	if(get_theme_mod('tafri_travel_blog_post_featured_option') == 'Post Color' ) {
		return true;
	}
	return false;
}

function tafri_travel_show_post_image_dimention(){
	if(get_theme_mod('tafri_travel_blog_post_featured_option') == 'Post Image' ) {
		return true;
	}
	return false;
}


/* Custom header additions. */
require get_template_directory().'/inc/custom-header.php';

/* Custom template tags for this theme. */
require get_template_directory().'/inc/template-tags.php';

/* Customizer additions. */
require get_template_directory().'/inc/customizer.php';

require get_parent_theme_file_path( '/inc/dashboard/get_started_info.php' ); 

/* Customizer additions. */
require get_template_directory() . '/inc/widget-about-us.php';

/* Customizer additions. */
require get_template_directory() . '/inc/widget-contact-us.php';
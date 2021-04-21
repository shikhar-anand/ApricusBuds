<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Olively
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses olively_header_style()
 */
function olively_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'olively_custom_header_args',
			array(
				'default-image'      => esc_url(get_template_directory_uri() . '/assets/images/header.jpg'),
				'default-text-color' => '379d96',
				'width'              => 1920,
				'height'             => 1080,
				'flex-height'		 => true,
				'wp-head-callback'   => 'olively_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'olively_custom_header_setup' );

if ( ! function_exists( 'olively_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see olively_custom_header_setup().
	 */
	function olively_header_style() {
		$header_text_color = get_header_textcolor();
		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
				
				?>
				#header-image {
					background-image: url(<?php echo !is_front_page() && is_singular() && has_post_thumbnail() ? esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')) : esc_url( get_header_image() ) ?>);
					background-size: cover;
					background-repeat: repeat;
					background-position: center center;
				}

				<?php
					
		 /*
 		 * If no custom options for text are set, let's bail.
 		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
 		 */


		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
			// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

<?php
/**
 * Theme Palace basic theme structure hooks
 *
 * This file contains structural hooks.
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

$options = stortech_get_theme_options();


if ( ! function_exists( 'stortech_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since Stortech 1.0.0
	 */
	function stortech_doctype() {
	?>
		<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
	<?php
	}
endif;

add_action( 'stortech_doctype', 'stortech_doctype', 10 );


if ( ! function_exists( 'stortech_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' )); ?>">
		<?php endif;
	}
endif;
add_action( 'stortech_before_wp_head', 'stortech_head', 10 );

if ( ! function_exists( 'stortech_page_start' ) ) :
	/**
	 * Page starts html codes
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_page_start() {
		?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'stortech' ); ?></a>

		<?php
	}
endif;
add_action( 'stortech_page_start_action', 'stortech_page_start', 10 );


if ( ! function_exists( 'stortech_header_start' ) ) :
	/**
	 * Header start html codes
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_header_start() {
		?>
		<div class="menu-overlay"></div>
		<div id="site-menu" class="header-menu">
		</div><!-- #site-menu -->
			<header id="masthead" class="site-header" role="banner">
		<?php
	}
endif;
add_action( 'stortech_header_action', 'stortech_header_start', 20 );

if ( ! function_exists( 'stortech_page_end' ) ) :
	/**
	 * Page end html codes
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'stortech_page_end_action', 'stortech_page_end', 10 );

if ( ! function_exists( 'stortech_site_branding' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_site_branding() {
		$options  = stortech_get_theme_options();
		$header_txt_logo_extra = $options['header_txt_logo_extra'];		
		?>
		<div class="wrapper">
			<div class="site-menu">
				<div class="site-branding">
					<?php if ( in_array( $header_txt_logo_extra, array( 'show-all', 'logo-title', 'logo-tagline' ) )  ) { ?>
						<div class="site-logo">
							<?php the_custom_logo(); ?>
						</div>
					<?php } 
					if ( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title', 'show-all', 'tagline-only', 'logo-tagline' ) ) ) : ?>
						<div id="site-identity">
							<?php
							if( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title' ) )  ) {
								if ( stortech_is_latest_posts() ) : ?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<?php else : ?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php
								endif;
							} 
							if ( in_array( $header_txt_logo_extra, array( 'show-all', 'tagline-only', 'logo-tagline' ) ) ) {
								$description = get_bloginfo( 'description', 'display' );
								if ( $description || is_customize_preview() ) : ?>
									<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
								<?php
								endif; 
							}?>
						</div>
					<?php endif; ?>
				</div><!-- .site-branding -->
		<?php
	}
endif;
add_action( 'stortech_header_action', 'stortech_site_branding', 20 );

if ( ! function_exists( 'stortech_site_navigation' ) ) :
	/**
	 * Site navigation codes
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_site_navigation() {
		$options = stortech_get_theme_options();
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="menu-label"><?php esc_html_e( 'Menu', 'stortech' ); ?></span>
				<?php
				echo stortech_get_svg( array( 'icon' => 'menu' ) );
				echo stortech_get_svg( array( 'icon' => 'close' ) );
				?>					
			</button>

			<?php  
        	
        		wp_nav_menu( array(
        			'theme_location' => 'primary',
        			'container' => 'div',
        			'menu_class' => 'menu nav-menu',
        			'menu_id' => 'primary-menu',
        			'echo' => true,
        			'fallback_cb' => 'stortech_menu_fallback_cb',
        		) );
        	?>
		</nav><!-- #site-navigation -->
		</div>
		<?php if ( class_exists('WooCommerce') ): ?>
			<div id="login-register">
	            <ul>
	                <li>
						<a href=" <?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ) ?>">
							<?php echo stortech_get_svg( array( 'icon' => 'user' ) ); ?>
						</a>
	                </li>
	                
		   			<li class="cart-count">
		       		 	<a href="<?php echo wc_get_cart_url(); ?>">
		       		 		<?php 
		       		 			if ( WC()->cart->get_cart_contents_count() > 0 ) {
		       		 				echo '('.WC()->cart->get_cart_contents_count().')';
		       		 			 }
		       		 			echo stortech_get_svg( array( 'icon' => 'cart' ) ); 
		       		 		?>
		           		</a>
		            </li>
		           	
		    	</ul>
	        </div><!-- .social-icons -->
        <?php  endif ; ?> 
		</div><!-- .wrapper -->
		<?php
	}
endif;
add_action( 'stortech_header_action', 'stortech_site_navigation', 30 );


if ( ! function_exists( 'stortech_header_end' ) ) :
	/**
	 * Header end html codes
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_header_end() {
		?>
		</header><!-- #masthead -->
		</div><!-- #site-menu -->
		<?php
	}
endif;

add_action( 'stortech_header_action', 'stortech_header_end', 50 );

if ( ! function_exists( 'stortech_content_start' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_content_start() {
		?>
		<div id="content" class="site-content">
		<?php
	}
endif;
add_action( 'stortech_content_start_action', 'stortech_content_start', 10 );

if ( ! function_exists( 'stortech_header_image' ) ) :
	/**
	 * Header Image codes
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_header_image() {
		if ( stortech_is_frontpage() )
			return;
		$header_image = get_header_image();
		$class = '';
		if ( is_singular() ) :
			$class = ( has_post_thumbnail() || ! empty( $header_image ) ) ? '' : 'header-media-disabled';
		else :
			$class = ! empty( $header_image ) ? '' : 'header-media-disabled';
		endif;
		
		if ( is_singular() && has_post_thumbnail() ) : 
			$header_image = get_the_post_thumbnail_url( get_the_id(), 'full' );
    	endif; ?>

    	<div id="page-site-header" class="relative <?php echo esc_attr( $class ); ?>" style="background-image: url('<?php echo esc_url( $header_image ); ?>');">
            <div class="overlay"></div>
            <div class="wrapper">
                <header class="page-header">
                    <?php stortech_custom_header_banner_title(); ?>
                </header>

                <?php stortech_add_breadcrumb(); ?>
            </div><!-- .wrapper -->
        </div><!-- #page-site-header -->

	<?php
	}
endif;
add_action( 'stortech_header_image_action', 'stortech_header_image', 10 );

if ( ! function_exists( 'stortech_add_breadcrumb' ) ) :
	/**
	 * Add breadcrumb.
	 *
	 * @since Stortech 1.0.0
	 */
	function stortech_add_breadcrumb() {
		$options = stortech_get_theme_options();
		// Bail if Breadcrumb disabled.
		$breadcrumb = $options['breadcrumb_enable'];
		if ( false === $breadcrumb ) {
			return;
		}
		
		// Bail if Home Page.
		if ( stortech_is_frontpage() ) {
			return;
		}

		echo '<div id="breadcrumb-list" >';
				/**
				 * stortech_simple_breadcrumb hook
				 *
				 * @hooked stortech_simple_breadcrumb -  10
				 *
				 */
				do_action( 'stortech_simple_breadcrumb' );
		echo '</div><!-- #breadcrumb-list -->';
		return;
	}
endif;
add_action( 'stortech_header_image_action', 'stortech_add_breadcrumb', 20 );

if ( ! function_exists( 'stortech_content_end' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_content_end() {
		?>
		</div><!-- #content -->
		<?php
	}
endif;
add_action( 'stortech_content_end_action', 'stortech_content_end', 10 );

if ( ! function_exists( 'stortech_footer_start' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_footer_start() {
		?>
		<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
	}
endif;
add_action( 'stortech_footer', 'stortech_footer_start', 10 );

if ( ! function_exists( 'stortech_footer_site_info' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_footer_site_info() {
		$theme_data = wp_get_theme();
		$options = stortech_get_theme_options();
		$search = array( '[the-year]', '[site-link]' );

        $replace = array( date( 'Y' ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );

        $options['copyright_text'] = str_replace( $search, $replace, $options['copyright_text'] );

		$copyright_text = $options['copyright_text']; 
		$poweredby_text = esc_html__( 'Theme By', 'stortech' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( ucwords( $theme_data->get( 'Author' ) ) ) .'</a>';
		?>
		<div class="site-info col-2">
                <div class="wrapper">
                    <span>
                    	<?php 
                    	echo stortech_santize_allow_tag( $copyright_text ); 
                    	echo stortech_santize_allow_tag( $poweredby_text );
                    	if ( function_exists( 'the_privacy_policy_link' ) ) {
							the_privacy_policy_link( ' | ' );
						}
                    	?>
                	</span>
                    <span><?php //echo stortech_santize_allow_tag( $powered_by_text ); ?></span>
                </div><!-- .wrapper -->    
            </div><!-- .site-info -->

		<?php
	}
endif;
add_action( 'stortech_footer', 'stortech_footer_site_info', 40 );

if ( ! function_exists( 'stortech_footer_scroll_to_top' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_footer_scroll_to_top() {
		$options  = stortech_get_theme_options();
		if ( true === $options['scroll_top_visible'] ) : ?>
			<div class="backtotop"><?php echo stortech_get_svg( array( 'icon' => 'up' ) ); ?></div>
		<?php endif;
	}
endif;
add_action( 'stortech_footer', 'stortech_footer_scroll_to_top', 40 );

if ( ! function_exists( 'stortech_footer_end' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Stortech 1.0.0
	 *
	 */
	function stortech_footer_end() {
		?>
		</footer>
		<div class="popup-overlay"></div>
		<?php
	}
endif;
add_action( 'stortech_footer', 'stortech_footer_end', 100 );

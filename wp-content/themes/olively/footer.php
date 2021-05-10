<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Olively
 */

?>
</div><!-- #content-wrapper -->

<?php do_action('olively_footer'); ?>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="site-info">
				<?php printf(esc_html__('Theme Designed by %s', 'olively'), '<a href="https://www.indithemes.com">IndiThemes</a>'); ?>
				<span class="sep"> | </span>
					<?php echo ( get_theme_mod('olively_footer_text') == '' ) ? ('Copyright &copy; '.date_i18n( esc_html__( 'Y', 'olively' ) ).' ' . esc_html( get_bloginfo('name') ) . esc_html__('. All Rights Reserved. ','olively')) : esc_html(get_theme_mod('olively_footer_text')); ?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<nav id="menu" class="panel" role="navigation">
	
	<div id="panel-top-bar">
		<button class="go-to-bottom"></button>
		<button id="close-menu" class="menu-link"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-chevron-right fa-stack-1x fa-inverse"></i></span></button>
	</div>
	
	<?php wp_nav_menu( array( 'menu_id'        => 'mobile-menu',
							  'container'		=> 'ul',
	                          'theme_location' => 'menu-1',
	                          'walker'         => has_nav_menu('menu-1') ? new Olively_Mobile_Menu : '',
	                     ) ); ?>
	                     
	<button class="go-to-top"></button>
</nav>

<?php wp_footer(); ?>

</body>
</html>

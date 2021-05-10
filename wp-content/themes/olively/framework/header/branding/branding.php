<?php
	the_custom_logo();
?>
	<h2 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
	<?php
$olively_description = get_bloginfo( 'description', 'display' );
if ( $olively_description || is_customize_preview() ) :
	?>
	<p class="site-description"><?php echo esc_html($olively_description); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
<?php endif; ?>
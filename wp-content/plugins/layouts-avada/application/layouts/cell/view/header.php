<?php
/**
 * Original code from Avada theme's header.php
 */
?>
<?php avada_header_template( 'Below' ); ?>
				<?php if ( 'Left' == Avada()->settings->get( 'header_position' ) || 'Right' == Avada()->settings->get( 'header_position' ) ) : ?>
	<?php avada_side_header(); ?>
<?php endif; ?>

	<div id="sliders-container">
		<?php
		if ( is_search() ) {
			$slider_page_id = '';
		} else {
			// Layer Slider
			$slider_page_id = '';
			if ( ! is_home() && ! is_front_page() && ! is_archive() && isset( $object_id ) ) {
				$slider_page_id = $object_id;
			}
			if ( ! is_home() && is_front_page() && isset( $object_id ) ) {
				$slider_page_id = $object_id;
			}
			if ( is_home() && ! is_front_page() ) {
				$slider_page_id = get_option( 'page_for_posts' );
			}
			if ( class_exists( 'WooCommerce' ) && is_shop() ) {
				$slider_page_id = get_option( 'woocommerce_shop_page_id' );
			}
			avada_slider( $slider_page_id );
		} ?>
	</div>
<?php if ( get_post_meta( $slider_page_id, 'pyre_fallback', true ) ) : ?>
	<div id="fallback-slide">
		<img src="<?php echo get_post_meta( $slider_page_id, 'pyre_fallback', true ); ?>" alt="" />
	</div>
<?php endif; ?>
				<?php avada_header_template( 'Above' ); ?>


				<?php if ( is_page_template( 'contact.php' ) && Avada()->settings->get( 'recaptcha_public' ) && Avada()->settings->get( 'recaptcha_private' ) ) : ?>
	<script type="text/javascript">var RecaptchaOptions = { theme : '<?php echo Avada()->settings->get( 'recaptcha_color_scheme' ); ?>' };</script>
<?php endif; ?>
<?php do_action( 'avada_before_main' ); ?>

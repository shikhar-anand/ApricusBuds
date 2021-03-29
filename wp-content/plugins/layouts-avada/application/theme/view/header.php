<!DOCTYPE html>
<?php global $woocommerce; ?>
<html class="<?php echo ( Avada()->settings->get( 'smooth_scrolling' ) ) ? 'no-overflow-y' : ''; ?>" <?php language_attributes(); ?>>
<head>
	<?php if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( false !== strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) ) ) : ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<?php endif; ?>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<?php
	if ( ! function_exists( '_wp_render_title_tag' ) ) {
		function avada_render_title() {
			?>
			<title><?php wp_title( '' ); ?></title>
			<?php
		}
		add_action( 'wp_head', 'avada_render_title' );
	}
	?>

	<!--[if lte IE 8]>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
	<![endif]-->

	<?php $isiPad = (bool) strpos( $_SERVER['HTTP_USER_AGENT'],'iPad' ); ?>

	<?php
	$viewport = '';
	if ( Avada()->settings->get( 'responsive' ) && $isiPad ) {
		$viewport = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
	} else if ( Avada()->settings->get( 'responsive' ) ) {
		if ( Avada()->settings->get( 'mobile_zoom' ) ) {
			$viewport .= '<meta name="viewport" content="width=device-width, initial-scale=1" />';
		} else {
			$viewport .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
		}
	}

	$viewport = apply_filters( 'avada_viewport_meta', $viewport );
	echo $viewport;
	?>

	<?php wp_head(); ?>

	<?php

	$object_id = get_queried_object_id();
	$c_pageID  = Avada()->fusion_library->get_page_id();
	?>

	<!--[if lte IE 8]>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			var imgs, i, w;
			var imgs = document.getElementsByTagName( 'img' );
			for( i = 0; i < imgs.length; i++ ) {
				w = imgs[i].getAttribute( 'width' );
				imgs[i].removeAttribute( 'width' );
				imgs[i].removeAttribute( 'height' );
			}
		});
	</script>

	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/excanvas.js"></script>

	<![endif]-->

	<!--[if lte IE 9]>
	<script type="text/javascript">
		jQuery(document).ready(function() {

			// Combine inline styles for body tag
			jQuery('body').each( function() {
				var combined_styles = '<style type="text/css">';

				jQuery( this ).find( 'style' ).each( function() {
					combined_styles += jQuery(this).html();
					jQuery(this).remove();
				});

				combined_styles += '</style>';

				jQuery( this ).prepend( combined_styles );
			});
		});
	</script>

	<![endif]-->

	<script type="text/javascript">
		var doc = document.documentElement;
		doc.setAttribute('data-useragent', navigator.userAgent);
	</script>

	<?php echo Avada()->settings->get( 'google_analytics' ); ?>

	<?php echo Avada()->settings->get( 'space_head' ); ?>
</head>
<?php
$wrapper_class = '';


if ( is_page_template( 'blank.php' ) ) {
	$wrapper_class  = 'wrapper_blank';
}

if ( 'modern' == Avada()->settings->get( 'mobile_menu_design' ) ) {
	$mobile_logo_pos = strtolower( Avada()->settings->get( 'logo_alignment' ) );
	if ( 'center' == strtolower( Avada()->settings->get( 'logo_alignment' ) ) ) {
		$mobile_logo_pos = 'left';
	}
}

?>
<body <?php body_class( 'layouts-avada' ); ?>>
	<?php do_action( 'avada_before_body_content' ); ?>
	<?php $boxed_side_header_right = false; ?>
	<?php if ( ( ( 'Boxed' == Avada()->settings->get( 'layout' ) && ( 'default' == get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) || '' == get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) ) ) || 'boxed' == get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) ) && 'Top' != Avada()->settings->get( 'header_position' ) ) : ?>
		<?php if ( Avada()->settings->get( 'slidingbar_widgets' ) && ! is_page_template( 'blank.php' ) && ( 'Right' == Avada()->settings->get( 'header_position' ) || 'Left' == Avada()->settings->get( 'header_position' ) ) ) : ?>
			<?php get_template_part( 'slidingbar' ); ?>
			<?php $boxed_side_header_right = true; ?>
		<?php endif; ?>
		<div id="boxed-wrapper">
	<?php endif; ?>
	<div id="wrapper" class="<?php echo $wrapper_class; ?>">
		<div id="home" style="position:relative;top:1px;"></div>
		<?php if ( Avada()->settings->get( 'slidingbar_widgets' ) && ! is_page_template( 'blank.php' ) && ! $boxed_side_header_right ) : ?>
			<?php get_template_part( 'slidingbar' ); ?>
		<?php endif; ?>
		<?php if ( false !== strpos( Avada()->settings->get( 'footer_special_effects' ), 'footer_sticky' ) ) : ?>
			<div class="above-footer-wrapper">
		<?php endif; ?>

		<?php // Header stuff converted to header cell ?>

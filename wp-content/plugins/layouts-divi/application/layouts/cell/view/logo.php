<?php
$template_directory_uri = get_template_directory_uri();
$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo ? $user_logo : $template_directory_uri . '/images/logo.png';

?>
<div class="logo_container layouts-modification">
	<span class="logo_helper"></span>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
	</a>
</div>

<style>
	svg#logo {
		max-width: 100%;
		height: auto;
	}

	/* SVG Support Plugin hack for Logo Cell */
	.et_pb_svg_logo #logo {
		height: auto;
	}
</style>

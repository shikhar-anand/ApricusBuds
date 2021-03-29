<div id="et-info">
	<?php
		$et_phone_number = et_get_option( 'phone_number' );
		$et_email = et_get_option( 'header_email' );
	?>

	<?php if( $this->get_content_field_value( 'phone' ) && "1" == $this->get_content_field_value( 'phone' ) && !empty($et_phone_number)) : ?>
		<span id="et-info-phone"><?php echo et_sanitize_html_input_text( $et_phone_number ); ?></span>
	<?php endif; ?>

	<?php if( $this->get_content_field_value( 'email' ) && "1" == $this->get_content_field_value( 'email' ) && !empty($et_email)) : ?>
		<a href="<?php echo esc_attr( 'mailto:' . $et_email ); ?>"><span id="et-info-email"><?php echo esc_html( $et_email ); ?></span></a>
	<?php endif; ?>

	<ul class="et-social-icons">

		<?php if( $this->get_content_field_value( 'facebook' ) && "1" == $this->get_content_field_value( 'facebook' )) : ?>
			<li class="et-social-icon et-social-facebook">
				<a href="<?php echo esc_url( et_get_option( 'divi_facebook_url', '#' ) ); ?>" class="icon">
					<span><?php esc_html_e( 'Facebook', 'Divi' ); ?></span>
				</a>
			</li>
		<?php endif; ?>
		<?php if( $this->get_content_field_value( 'twitter' ) && "1" == $this->get_content_field_value( 'twitter' )) : ?>
			<li class="et-social-icon et-social-twitter">
				<a href="<?php echo esc_url( et_get_option( 'divi_twitter_url', '#' ) ); ?>" class="icon">
					<span><?php esc_html_e( 'Twitter', 'Divi' ); ?></span>
				</a>
			</li>
		<?php endif; ?>
		<?php if( $this->get_content_field_value( 'gplus' ) && "1" == $this->get_content_field_value( 'gplus' )) : ?>
			<li class="et-social-icon et-social-google-plus">
				<a href="<?php echo esc_url( et_get_option( 'divi_google_url', '#' ) ); ?>" class="icon">
					<span><?php esc_html_e( 'Google', 'Divi' ); ?></span>
				</a>
			</li>
		<?php endif; ?>
		<?php if( $this->get_content_field_value( 'rss' ) && "1" == $this->get_content_field_value( 'rss' )) : ?>
			<?php
			$et_rss_url = '' !== et_get_option( 'divi_rss_url' )
					? et_get_option( 'divi_rss_url' )
					: get_bloginfo( 'rss2_url' );
			?>
			<li class="et-social-icon et-social-rss">
				<a href="<?php echo esc_url( $et_rss_url ); ?>" class="icon">
					<span><?php esc_html_e( 'RSS', 'Divi' ); ?></span>
				</a>
			</li>
		<?php endif; ?>

	</ul>
</div>
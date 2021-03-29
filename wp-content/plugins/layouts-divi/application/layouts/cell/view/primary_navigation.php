<?php
$et_secondary_nav_items = et_divi_get_top_nav_items();

$et_phone_number = $et_secondary_nav_items->phone_number;

$et_email = $et_secondary_nav_items->email;

$et_contact_info_defined = $et_secondary_nav_items->contact_info_defined;

$show_header_social_icons = $et_secondary_nav_items->show_header_social_icons;

$et_secondary_nav = $et_secondary_nav_items->secondary_nav;

$et_top_info_defined = $et_secondary_nav_items->top_info_defined;

$et_slide_header = 'slide' === et_get_option( 'header_style', 'left' ) || 'fullscreen' === et_get_option( 'header_style', 'left' ) ? true : false;
?>

<?php if ( $et_slide_header ) : ?>
	<div class="et_slide_in_menu_container">
		<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) || is_customize_preview() ) { ?>
			<span class="mobile_menu_bar et_toggle_fullscreen_menu"></span>
		<?php } ?>

		<?php
		if ( $et_contact_info_defined || true === $show_header_social_icons || false !== et_get_option( 'show_search_icon', true ) || class_exists( 'woocommerce' ) ) { ?>
		<div class="et_slide_menu_top">

			<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) ) { ?>
			<div class="et_pb_top_menu_inner">
				<?php } ?>
				<?php }

				if ( true === $show_header_social_icons ) {
					get_template_part( 'includes/social_icons', 'header' );
				}

				et_show_cart_total();
				?>
				<?php if ( false !== et_get_option( 'show_search_icon', true ) || is_customize_preview() ) : ?>
					<?php if ( 'fullscreen' !== et_get_option( 'header_style', 'left' ) ) { ?>
						<div class="clear"></div>
					<?php } ?>
					<form role="search" method="get" class="et-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php
						printf( '<input type="search" class="et-search-field" placeholder="%1$s" placeholder="%2$s" name="s" title="%3$s" />',
								esc_attr__( 'Search &hellip;', 'Divi' ),
								get_search_query(),
								esc_attr__( 'Search for:', 'Divi' )
						);
						?>
						<button type="submit" id="searchsubmit_header"></button>
					</form>
				<?php endif; // true === et_get_option( 'show_search_icon', false ) ?>

				<?php if ( $et_contact_info_defined ) : ?>

					<div id="et-info">
						<?php if ( '' !== ( $et_phone_number = et_get_option( 'phone_number' ) ) ) : ?>
							<span id="et-info-phone"><?php echo et_sanitize_html_input_text( $et_phone_number ); ?></span>
						<?php endif; ?>

						<?php if ( '' !== ( $et_email = et_get_option( 'header_email' ) ) ) : ?>
							<a href="<?php echo esc_attr( 'mailto:' . $et_email ); ?>"><span id="et-info-email"><?php echo esc_html( $et_email ); ?></span></a>
						<?php endif; ?>
					</div> <!-- #et-info -->

				<?php endif; // true === $et_contact_info_defined ?>
				<?php if ( $et_contact_info_defined || true === $show_header_social_icons || false !== et_get_option( 'show_search_icon', true ) || class_exists( 'woocommerce' ) ) { ?>
				<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) ) { ?>
			</div> <!-- .et_pb_top_menu_inner -->
		<?php } ?>

		</div> <!-- .et_slide_menu_top -->
	<?php } ?>

		<div class="et_pb_fullscreen_nav_container">
			<?php
			$slide_nav = '';
			$slide_menu_class = 'et_mobile_menu';

			$slide_nav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => false, 'items_wrap' => '%3$s' ) );
			$slide_nav .= wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => false, 'items_wrap' => '%3$s' ) );
			?>

			<ul id="mobile_menu_slide" class="<?php echo esc_attr( $slide_menu_class ); ?>">

				<?php
				if ( '' == $slide_nav ) :
					?>
					<?php if ( 'on' == et_get_option( 'divi_home_link' ) ) { ?>
					<li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'Divi' ); ?></a></li>
				<?php }; ?>

					<?php show_page_menu( $slide_menu_class, false, false ); ?>
					<?php show_categories_menu( $slide_menu_class, false ); ?>
					<?php
				else :
					echo( $slide_nav );
				endif;
				?>

			</ul>
		</div>
	</div>
<?php endif; // true ==== $et_slide_header ?>

<div class="et_menu_container">
<div id="et-top-navigation" data-height="<?php echo esc_attr( et_get_option( 'menu_height', '66' ) ); ?>" data-fixed-height="<?php echo esc_attr( et_get_option( 'minimized_menu_height', '40' ) ); ?>">
	<?php if ( ! $et_slide_header ) : ?>
		<nav id="top-menu-nav">
			<?php
			$menuClass = 'nav';
			if ( 'on' == et_get_option( 'divi_disable_toptier' ) ) $menuClass .= ' et_disable_top_tier';
			$primaryNav = '';

			$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => 'top-menu', 'echo' => false ) );

			if ( '' == $primaryNav ) :
				?>
				<ul id="top-menu" class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if ( 'on' == et_get_option( 'divi_home_link' ) ) { ?>
						<li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'Divi' ); ?></a></li>
					<?php }; ?>

					<?php show_page_menu( $menuClass, false, false ); ?>
					<?php show_categories_menu( $menuClass, false ); ?>
				</ul>
				<?php
			else :
				echo( $primaryNav );
			endif;
			?>
		</nav>
	<?php endif; ?>

	<?php if ( $et_slide_header ) : ?>
		<span class="mobile_menu_bar et_pb_header_toggle et_toggle_<?php echo et_get_option( 'header_style', 'left' ); ?>_menu"></span>
	<?php endif; ?>

	<?php
	if ( ! $et_top_info_defined  && ! $et_slide_header ) {
		et_show_cart_total( array(
				'no_text' => true,
		) );
	}
	?>

	<?php if ( $this->get_content_field_value( 'toggle_search' ) && "1" == $this->get_content_field_value( 'toggle_search' ) ) : ?>
	    <div id="et_top_search">
		    <span id="et_search_icon"></span>
	    </div>
	<?php endif; // true === et_get_option( 'show_search_icon', false ) ?>

	<?php do_action( 'et_header_top' ); ?>
</div> <!-- #et-top-navigation -->
</div>

<?php if( $this->get_content_field_value( 'toggle_search' ) && "1" == $this->get_content_field_value( 'toggle_search' )) : ?>
	<!-- <div id="et_top_search"><span class="et_search_icon"></span></div> -->
<div class="et_search_outer">
	<div class="container et_search_form_container">
		<form role="search" method="get" class="et-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
			printf( '<input type="search" class="et-search-field" placeholder="%1$s" value="%2$s" name="s" title="%3$s" />',
				esc_attr__( 'Search &hellip;', 'Divi' ),
				get_search_query(),
				esc_attr__( 'Search for:', 'Divi' )
			);
		?>
		</form>
		<span class="et_close_search_field"></span>
	</div>
</div>
<script type="text/javascript">
	( function( $ ) {
		var $etl_window = $(window),
			$etl_vertical_nav = $('.et_vertical_nav'),
			$etl_header_style_split = $('.et_header_style_split'),
			$etl_top_navigation = $('#et-top-navigation');

        $(function(){
            var main_header = $( '#main-header' ),
                search = $( '.et_search_outer' );
		
            if( main_header.length && search.length ) {
				search.on( 'click', function() {
					$( '.et_search_form_container' ).css( 'height', main_header.outerHeight() + 'px' );
				});

				main_header.append( search.detach() );
			}

			// Move slide-in and full-screen content before <header>
			$($(".et_slide_in_menu_container").detach()).insertBefore("header");

			// Centered Inline Logo Hack for Layouts Plugin
			// Originally copied from Divi's js/custom.js file
			// Variable and Object names were changed for compatibility reasons.
			if ( $etl_header_style_split.length && $etl_vertical_nav.length < 1 ) {
				function etl_header_menu_split(){
					var $logo_container = $( '#main-header .container .logo_container' ),
							$logo_container_splitted = $('.centered-inline-logo-wrap > .logo_container'),
							et_top_navigation_li_size = $etl_top_navigation.children('nav').children('ul').children('li').size(),
							et_top_navigation_li_break_index = Math.round( et_top_navigation_li_size / 2 ) - 1;

					if ( $etl_window.width() > 980 && $logo_container.length ) {
						$('<li class="centered-inline-logo-wrap"></li>').insertAfter($etl_top_navigation.find('nav > ul >li:nth('+et_top_navigation_li_break_index+')') );
						$logo_container.appendTo( $etl_top_navigation.find('.centered-inline-logo-wrap') );
					}

					if ( $etl_window.width() <= 980 && $logo_container_splitted.length ) {
						$logo_container_splitted.prependTo('#main-header > .container');
						$('#main-header .centered-inline-logo-wrap').remove();
					}
				}
				etl_header_menu_split();

				$(window).resize(function(){
					etl_header_menu_split();
				});
			}
		});
	} )( jQuery );
</script>
<?php endif;?>

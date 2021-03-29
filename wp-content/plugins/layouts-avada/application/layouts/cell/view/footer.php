<?php
/**
 * Original code from Avada theme's footer.php
 * Some modifications were applied to comply with the integration.
 */

global $social_icons;

if ( strpos( Avada()->settings->get( 'footer_special_effects' ), 'footer_sticky' ) !== false ) {
	echo '</div>';
}

// Get the correct page ID
$c_pageID = Avada()->fusion_library->get_page_id();

$footer_parallax_class = '';
if ( Avada()->settings->get( 'footer_special_effects' ) == 'footer_parallax_effect' ) {
	$footer_parallax_class = ' fusion-footer-parallax';
}

echo sprintf( '<div class="fusion-footer%s">', $footer_parallax_class );

// *** NOTE ***
// These check have been modified to comply with the options provided by Integration Plugin.
// Means, the global and per page/post settings for these, are overridden by the cell settings.
// However, for widgets and the original content, user should refer to the original theme/page options.

// Check if the footer widget area should be displayed
if ( $this->get_content_field_value( 'show_widgets' ) && "1" == $this->get_content_field_value( 'show_widgets' ) ) {
	?>
	<footer class="fusion-footer-widget-area">
		<div class="fusion-row">
			<div class="fusion-columns fusion-columns-<?php echo Avada()->settings->get( 'footer_widgets_columns' ); ?> fusion-widget-area">

				<?php
				// Check the column width based on the amount of columns chosen in Theme Options
				$avada_footer_widget_columns = ( Avada()->settings->get( 'footer_widgets_columns' ) ) ? Avada()->settings->get( 'footer_widgets_columns' ) : 1;
				$column_width                = 12 / $avada_footer_widget_columns;
				if ( Avada()->settings->get( 'footer_widgets_columns' ) == '5' ) {
					$column_width = 2;
				}

				// Render as many widget columns as have been chosen in Theme Options
				for ( $i = 1; $i < 7; $i ++ ) {
					if ( Avada()->settings->get( 'footer_widgets_columns' ) >= $i ) {
						echo sprintf( '<div class="fusion-column col-lg-%s col-md-%s col-sm-%s">', $column_width, $column_width, $column_width );

						if ( function_exists( 'dynamic_sidebar' ) &&
						     dynamic_sidebar( 'avada-footer-widget-' . $i )
						) {
							// All is good, dynamic_sidebar() already called the rendering
						}
						echo '</div>';
					}
				}
				?>

				<div class="fusion-clearfix"></div>
			</div> <!-- fusion-columns -->
		</div> <!-- fusion-row -->
	</footer> <!-- fusion-footer-area -->
	<?php
} // end footer wigets check

// Check if the footer copyright area should be displayed
if ( $this->get_content_field_value( 'show_copyright' ) && "1" == $this->get_content_field_value( 'show_copyright' ) ) {
	?>
	<footer id="footer" class="fusion-footer-copyright-area">
		<div class="fusion-row">
			<div class="fusion-copyright-content">
				<?php
				/**
				 * avada_footer_copyright_content hook
				 *
				 * @hooked avada_render_footer_copyright_notice - 10 (outputs the HTML for the Theme Options footer copyright text)
				 * @hooked avada_render_footer_social_icons - 15 (outputs the HTML for the footer social icons)
				 */
				do_action( 'avada_footer_copyright_content' );
				?>
			</div> <!-- fusion-fusion-copyright-area-content -->
		</div> <!-- fusion-row -->
	</footer> <!-- #footer -->
	</div> <!-- fusion-footer -->
	<?php
} // end footer copyright area check
?>
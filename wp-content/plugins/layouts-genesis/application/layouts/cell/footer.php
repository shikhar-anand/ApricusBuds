<?php


/**
 * Class WPDDL_Integration_Layouts_Cell_Footer
 */
class WPDDL_Integration_Layouts_Cell_Footer extends WPDDL_Cell_Abstract {
	protected $id      = 'genesis-footer';
	protected $factory = 'WPDDL_Integration_Layouts_Cell_Footer_Cell_Factory';
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Footer_Cell
 */
class WPDDL_Integration_Layouts_Cell_Footer_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'genesis-footer';

	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/footer.php';
	}
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Footer_Cell_Factory
 */
class WPDDL_Integration_Layouts_Cell_Footer_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {

	public function __construct() {
		$this->name              = __('Footer', 'ddl-layouts');
		$this->description       = __('Display Genesis Footer, including the credits text and a link to scroll to the top of the page.', 'ddl-layouts');
		$this->cell_class        = 'WPDDL_Integration_Layouts_Cell_Footer_Cell';
		$this->preview_image_url = plugins_url( '/../../../public/img/footer-cell-description.png', __FILE__ );
	}


	protected function _dialog_template() {
		ob_start();
		?>

		<div class="ddl-form">

			<div class="clear" style="height:10px"></div>
			<p>
				<label for="<?php the_ddl_name_attr('footer_credits_select'); ?>"><?php _e( 'Credits', 'ddl-layouts' ) ?>:</label>
				<select name="<?php the_ddl_name_attr('footer_credits_select'); ?>">
					<option value="default">Genesis Default</option>
					<option value="custom">Custom Text</option>
				</select>
				<div class="footer_credits_custom_text_container" style="display:none;">
					<input type="text" name="<?php the_ddl_name_attr('footer_credits'); ?>" value="">
					<span class="desc">Use can use <b>%year%</b> to output the current year.</span>
				</div>
			</p>
			<div class="clear" style="height:10px"></div>

			<p>
				<label for="<?php the_ddl_name_attr('footer_backtotop_select'); ?>"><?php _e( 'Back To Top Link', 'ddl-layouts' ) ?>:</label>
				<select name="<?php the_ddl_name_attr('footer_backtotop_select'); ?>">
					<option value="none">No Link</option>
					<option value="default">Genesis Default (as link in the footer)</option>
					<option value="fixed">Fixed (bottom right of the page)</option>
				</select>
				<div class="footer_backtotop_text_container" style="display:none;">
					<input type="text" name="<?php the_ddl_name_attr('footer_backtotop_text'); ?>" value="Return to top of page">
					<span class="desc">Default: Return to top of page</span>
				</div>
			</p>
		</div>

		<script type="text/javascript">
			if( jQuery ) {
				( function( $ ) {
					$( document ).on( 'cbox_open', function() {
						var creditsSelect       = $( 'select[name^="ddl-layout-footer_credits_select"]' ),
						    creditsCustomText   = $( 'div.footer_credits_custom_text_container' ),
						    backtopSelect       = $( 'select[name^="ddl-layout-footer_backtotop_select"]' ),
						    backtopText         = $( 'div.footer_backtotop_text_container' );

						function creditsSelectFunction() {
							if( creditsSelect.val() == 'default' ) {
								creditsCustomText.hide();
							} else {
								creditsCustomText.show();
							}
						} creditsSelectFunction();

						creditsSelect.on( 'change', creditsSelectFunction );

						function backtopSelectFunction() {
							if( backtopSelect.val() == 'none' ) {
								backtopText.hide();
							} else {
								backtopText.show();
							}
						} backtopSelectFunction();

						backtopSelect.on( 'change', backtopSelectFunction );
					} );

				} )( jQuery );
			}
		</script>

		<?php
		return ob_get_clean();
	}

	public function get_editor_cell_template() {
		$this->setCategory();

		ob_start();
		?>
			<div class="cell-content">
			<p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
				<div class="cell-preview">
	                <div class="theme-integration-footer">
						<# if( content.footer_backtotop_select == "default" ){ #>
		                    <p><?php $this->sanitizeContentForJS( 'footer_backtotop_text' ); ?></p>
		                <# } #>
		                <# if( content.footer_backtotop_select == "fixed" ){ #>
		                    <div class="footer-backtotop-fixed"><?php $this->sanitizeContentForJS( 'footer_backtotop_text' ); ?></div>
		                <# } #>
						<# if( content.footer_credits_select == "default" ){ #>
							<p><?php $this->sanitizeContentForJS( do_shortcode( sprintf( '[footer_copyright before="%s "] &#x000B7; [footer_childtheme_link before="" after=" %s"] [footer_genesis_link url="http://www.studiopress.com/" before=""] &#x000B7; [footer_wordpress_link] &#x000B7; [footer_loginout]', __( 'Copyright', 'genesis' ), __( 'on', 'genesis' ) ) ) ); ?></p>
						<# } #>
						<# if( content.footer_credits_select == "custom" ){ #>
							<p class="footer-credits"><?php $this->sanitizeContentForJS( 'footer_credits' ); ?></p>
						<# } #>
					</div>
				</div>
			</div>
			</div>
			<script type="text/javascript">
				if( document.getElementsByClassName( 'footer-credits' ).length ) {
					document.getElementsByClassName( 'footer-credits' )[0].innerHTML =
			            document.getElementsByClassName( 'footer-credits' )[0].innerHTML.replace( '%year%', '<?php echo date('Y', time() ); ?>' );
				}
			</script>
		<?php
		return ob_get_clean();
	}

	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/footer.svg', __FILE__ );
	}
}
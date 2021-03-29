<?php


/**
 * Class WPDDL_Integration_Layouts_Cell_Post_Navigation
 */
class WPDDL_Integration_Layouts_Cell_Post_Navigation extends WPDDL_Cell_Abstract {
	protected $id      = 'genesis-post-navigation';
	protected $factory = 'WPDDL_Integration_Layouts_Cell_Post_Navigation_Cell_Factory';
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Post_Navigation_Cell
 */
class WPDDL_Integration_Layouts_Cell_Post_Navigation_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'genesis-post-navigation';

	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/post-navigation.php';
	}
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Post_Navigation_Cell_Factory
 */
class WPDDL_Integration_Layouts_Cell_Post_Navigation_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {


	public function __construct() {
		$this->name              = __('Post Navigation', 'ddl-layouts');
		$this->description       = __('Display the Genesis Post Navigation with the pagination controls for the current page.', 'ddl-layouts');
		$this->cell_class        = 'WPDDL_Integration_Layouts_Cell_Post_Navigation_Cell';
		$this->preview_image_url = plugins_url( '/../../../public/img/post-navigation-cell-description.png', __FILE__ );
	}


	protected function _dialog_template() {
		ob_start();
		?>

		<div class="ddl-form">
			<label for="<?php the_ddl_name_attr('post_navigation_layout'); ?>"><?php _e( 'Display Style', 'ddl-layouts' ) ?>:</label>
			<div class="theme-integration-radio-images">
				<input
					type="radio" checked="checked" name="<?php the_ddl_name_attr('post_navigation_layout'); ?>"
					id="numeric" value="numeric" class="input-hidden" />
				<label for="numeric">
					<img
						src="<?php echo plugins_url( '/../../../public/img/post-navigation-numeric.png', __FILE__ ) ?>"
						alt="" />
				</label>

				<input
					type="radio" name="<?php the_ddl_name_attr('post_navigation_layout'); ?>"
					id="only-next-prev" value="only-next-prev" class="input-hidden" />
				<label for="only-next-prev">
					<img
						src="<?php echo plugins_url( '/../../../public/img/post-navigation.png', __FILE__ ) ?>"
						alt="" />
				</label>
			</div>
			<div class="clear" style="height:10px"></div>

			<p>
				<label for="<?php the_ddl_name_attr('post_navigation_prev_text'); ?>"><?php _e( 'Previous Page Label', 'ddl-layouts' ) ?>:</label>
				<input type="text" name="<?php the_ddl_name_attr('post_navigation_prev_text'); ?>" value="« Previous Page">
				<span class="desc">Default value: « Previous Page</span>
			</p>

			<p>
				<label for="<?php the_ddl_name_attr('post_navigation_next_text'); ?>"><?php _e( 'Next Page Label', 'ddl-layouts' ) ?>:</label>
				<input type="text" name="<?php the_ddl_name_attr('post_navigation_next_text'); ?>" value="Next Page »">
				<span class="desc">Default value: Next Page »</span>
			</p>
		</div>

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
	                <div class="theme-integration-post-navigation-backend">
	                    <# if( content.post_navigation_layout ){ #>
		                    <ul class="{{ content.post_navigation_layout }}">
		                        <li>
		                           <# if( content.post_navigation_prev_text ){ #>
									 <?php $this->sanitizeContentForJS( 'post_navigation_prev_text'); ?>
								   <# } #>
								</li>
								<li>1</li>
								<li>2</li>
								<li>3</li>
								<li>
		                           <# if( content.post_navigation_next_text ){ #>
									 <?php $this->sanitizeContentForJS( 'post_navigation_next_text'); ?>
								   <# } #>
								</li>
							</ul>
						<# } #>
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}

	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/post-navigation.svg', __FILE__ );
	}
}
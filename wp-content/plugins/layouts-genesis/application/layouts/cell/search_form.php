<?php


/**
 * Class WPDDL_Integration_Layouts_Cell_Search_Form
 */
class WPDDL_Integration_Layouts_Cell_Search_Form extends WPDDL_Cell_Abstract {
	protected $id      = 'genesis-search-form';
	protected $factory = 'WPDDL_Integration_Layouts_Cell_Search_Form_Cell_Factory';

	public function setup() {
		add_filter( 'genesis_search_title_output', array( $this, 'removeDefaultGenesisSearchTitle' ) );
		parent::setup();
	}

	public function removeDefaultGenesisSearchTitle( $title ) {
		return '';
	}
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Search_Form_Cell
 */
class WPDDL_Integration_Layouts_Cell_Search_Form_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'genesis-search-form';

	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/search-form.php';
	}
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Search_Form_Cell_Factory
 */
class WPDDL_Integration_Layouts_Cell_Search_Form_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {

	public function __construct() {
		$this->name              = __('Search Form', 'ddl-layouts');
		$this->description       = __('Display Genesis Search Form.', 'ddl-layouts');
		$this->cell_class        = 'WPDDL_Integration_Layouts_Cell_Search_Form_Cell';
		$this->preview_image_url = plugins_url( '/../../../public/img/search-form-cell-description.png', __FILE__ );
	}


	protected function _dialog_template() {
		ob_start();
		?>

		<div class="ddl-form">
				<label for="<?php the_ddl_name_attr('search_form_layout'); ?>"><?php _e( 'Display Style', 'ddl-layouts' ) ?>:</label>
				<div class="theme-integration-radio-images">
					<input
						type="radio" checked="checked" name="<?php the_ddl_name_attr('search_form_layout'); ?>"
						id="two-rows" value="two-rows" class="input-hidden" />
					<label for="two-rows">
						<img
							src="<?php echo plugins_url( '/../../../public/img/search-form-layout-two-rows.png', __FILE__ ) ?>"
							alt="" />
					</label>

					<input
						type="radio" name="<?php the_ddl_name_attr('search_form_layout'); ?>"
						id="one-row" value="one-row" class="input-hidden" />
					<label for="one-row">
						<img
							src="<?php echo plugins_url( '/../../../public/img/search-form-layout-one-row.png', __FILE__ ) ?>"
							alt="" />
					</label>
				</div>
			<div class="clear" style="height:10px"></div>
			<p>
				<label for="<?php the_ddl_name_attr('search_form_btn_text'); ?>"><?php _e( 'Submit Text', 'ddl-layouts' ) ?>:</label>
				<input type="text" name="<?php the_ddl_name_attr('search_form_btn_text'); ?>" value="Search">
			</p>
			<div class="clear" style="height:10px"></div>
			<p>
				<label for="<?php the_ddl_name_attr('search_form_placeholder_text'); ?>"><?php _e( 'Placeholder Text', 'ddl-layouts' ) ?>:</label>
				<input type="text" name="<?php the_ddl_name_attr('search_form_placeholder_text'); ?>" value="Search this website...">
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
	                <div class="theme-integration-search-form-backend">
	                    <# if( content.search_form_layout ){ #>
		                    <ul class="{{ content.search_form_layout }}">
		                        <li>
		                           <# if( content.search_form_placeholder_text ){ #>
									 <?php $this->sanitizeContentForJS( 'search_form_placeholder_text'); ?>
								   <# } #>
								</li>
								<li>
		                           <# if( content.search_form_btn_text ){ #>
									 <?php $this->sanitizeContentForJS( 'search_form_btn_text'); ?>
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
		$this->cell_image_url = plugins_url( '/../../../public/img/search-form.svg', __FILE__ );
	}
}
<?php


/**
 * Class WPDDL_Integration_Layouts_Cell_Author_Box
 */
class WPDDL_Integration_Layouts_Cell_Author_Box extends WPDDL_Cell_Abstract {
	protected $id      = 'genesis-author-box';
	protected $factory = 'WPDDL_Integration_Layouts_Cell_Author_Box_Cell_Factory';
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Author_Box_Cell
 */
class WPDDL_Integration_Layouts_Cell_Author_Box_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'genesis-author-box';

	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/author-box.php';
	}
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Author_Box_Cell_Factory
 */
class WPDDL_Integration_Layouts_Cell_Author_Box_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {

	public function __construct() {
		$this->name              = __('Author Box', 'ddl-layouts');
		$this->description       = __("Display Genesis Author Box, including the gravatar and user description.", 'ddl-layouts');
		$this->cell_class        = 'WPDDL_Integration_Layouts_Cell_Author_Box_Cell';
		$this->preview_image_url = plugins_url( '/../../../public/img/author-box-cell-description.png', __FILE__ );
	}


	protected function _dialog_template() {
		ob_start();
		?>

		<div class="ddl-form">

			<div class="clear" style="height:10px"></div>
			<p>
				<label for="<?php the_ddl_name_attr('author_box_title'); ?>"><?php _e( 'Title', 'ddl-layouts' ) ?>:</label>
				<input type="text" name="<?php the_ddl_name_attr('author_box_title'); ?>" value="About %author%">
				<span class="desc">Use <b>%author%</b> to add the authors name.</span>
			</p>
			<div class="clear" style="height:10px"></div>
			<p>
				<label for="<?php the_ddl_name_attr('author_box_gravatar_size'); ?>"><?php _e( 'Gravatar Size', 'ddl-layouts' ) ?>:</label>
				<input type="text" name="<?php the_ddl_name_attr('author_box_gravatar_size'); ?>" value="70">
				<span class="desc">Use <b>0</b> to remove the Gravatar. Default value: 70</span>
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
	                <div class="theme-integration-author-box">
	                    <# if( content.author_box_title ){ #>
		                    <ul class="{{ content.search_form_layout }}">
		                        <li style="width:{{content.author_box_gravatar_size}}px">
									<img src="http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&f=y"  style="width:{{content.author_box_gravatar_size}}px; height:auto;" />
								</li>
								<li>
		                           <# if( content.author_box_title ){ #>
									 <b><?php $this->sanitizeContentForJS( 'author_box_title' ); ?></b><br />
								   <# } #>
								   <span class="desc">Description of author</span>
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
		$this->cell_image_url = plugins_url( '/../../../public/img/author-box.svg', __FILE__ );
	}
}
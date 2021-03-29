<?php
/**
 * SiteBranding cell
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Entry_Meta extends WPDDL_Cell_Abstract {
	protected $id = '2015-entry-meta';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Entry_Meta_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Entry_Meta_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = '2015-entry-meta';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/entry_meta.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Entry_Meta_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Content Meta';
	protected $description = 'Prints HTML with meta information for the categories, tags... This cell is visible only on single page';
	protected $allow_multiple = false;

	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Entry_Meta_Cell';
        
        public function __construct() {
            $this->preview_image_url = plugins_url( '/../../../public/img/single_post_meta_data_expand_image.png', __FILE__ );
        }
        
	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/single_post_meta_data_cells.svg', __FILE__ );
	}
	public function get_editor_cell_template() {
		$this->setCategory();

		ob_start();
		?>
			<div class="cell-content">
			<p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
				<div class="cell-preview">
	                <div class="theme-integration-position-center">
	                    <img src="<?php echo plugins_url( '/../../../public/img/single_post_meta_data_cells.svg', __FILE__ );?>">
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}
}
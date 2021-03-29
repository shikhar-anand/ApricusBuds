<?php
/**
 * featured pages cell
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Featured_Posts extends WPDDL_Cell_Abstract {
	protected $id = 'featured-posts';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Featured_Posts_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Featured_Posts_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'featured-posts';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/featured_posts.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Featured_Posts_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Featured Pages';

	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Featured_Posts_Cell';
        protected $description = 'Display cell with featured pages defined from theme customizer page.';
	protected function setCellImageUrl() {
		$this->cell_image_url = DDL_ICONS_REL_PATH . 'post-content.svg';
	}
        
        public function get_editor_cell_template() {
		$this->setCategory();

		ob_start();
		?>
			<div class="cell-content">
			<p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
				<div class="cell-preview">
	                <div class="theme-integration-preview-area">
	                    <img src="<?php echo DDL_ICONS_REL_PATH . 'post-content.svg';?>">
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}
}
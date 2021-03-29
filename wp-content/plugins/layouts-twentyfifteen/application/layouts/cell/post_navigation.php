<?php
/**
 * Post Navigation cell
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Post_Navigation extends WPDDL_Cell_Abstract {
	protected $id = '2015-post-navigation';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Post_Navigation_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Post_Navigation_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = '2015-post-navigation';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
            return dirname( __FILE__ ) . '/view/post_navigation.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Post_Navigation_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Post Navigation';
	protected $description = 'Prints HTML with next and previus post navigation... This cell is visible only on single page';
	protected $allow_multiple = false;

	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Post_Navigation_Cell';

        public function __construct() {
            $this->preview_image_url = plugins_url( '/../../../public/img/post_navigation_expand_image.png', __FILE__ );
        }
        
	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/post-navigation.svg', __FILE__ );
	}

	public function get_editor_cell_template() {
		$this->setCategory();

		ob_start();
		?>
			<div class="cell-content">
			<p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
				<div class="cell-preview">
	                <div class="theme-integration-position-center">
	                    <img src="<?php echo plugins_url( '/../../../public/img/post-navigation.svg', __FILE__ );?>">
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}
}
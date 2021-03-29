<?php
/**
 * Divi Post/Page Title
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Post_Title extends WPDDL_Cell_Abstract {
	protected $id = 'divi-post-title';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Post_Title_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Post_Title_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'divi-post-title';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/post_title.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Post_Title_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Post Title';
	protected $description = 'Display post or page title.';

	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Post_Title_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = DDL_ICONS_SVG_REL_PATH . 'site-title-cell.svg';
	}
}
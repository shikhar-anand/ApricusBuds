<?php
/**
 * Divi Logo Output
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Logo extends WPDDL_Cell_Abstract {
	protected $id = 'divi-logo';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Logo_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Logo_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'divi-logo';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/logo.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Logo_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Logo';
	protected $description = 'Display site logo.';

	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Logo_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = DDL_ICONS_SVG_REL_PATH . 'layouts-imagebox-cell.svg';
	}
}
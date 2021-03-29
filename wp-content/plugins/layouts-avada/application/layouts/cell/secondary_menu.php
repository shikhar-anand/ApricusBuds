<?php
/**
 * Avada Secondary Menu Cell.
 */

/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Secondary_Menu extends WPDDL_Cell_Abstract {
	protected $id = 'avada-secondary-menu';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Secondary_Menu_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Secondary_Menu_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'avada-secondary-menu';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/secondary-menu.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Secondary_Menu_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = "Secondary Menu / Top Navigation";
	protected $description = 'Display Avada\'s Top Navigation menu, which is the menu set in Appearance > Menus.';
	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Secondary_Menu_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/secondary-menu.svg', __FILE__ );
	}

	public function get_editor_cell_template() {
		$this->setCategory();
		ob_start();
		?>
			<div class="cell-content">
			<p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
				<div class="cell-preview">
	                <div class="theme-integration-preview-area" style="text-align: center;">
                        <img src="<?php echo plugins_url( '/../../../public/img/secondary-menu.svg', __FILE__ ); ?>" height="120px">
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}
}
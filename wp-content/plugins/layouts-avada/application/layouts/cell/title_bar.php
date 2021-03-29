<?php
/**
 * Avada Title Bar Cell.
 */

/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Title_Bar extends WPDDL_Cell_Abstract {
	protected $id = 'avada-title-bar';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Title_Bar_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Title_Bar_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'avada-title-bar';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/title-bar.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Title_Bar_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Title Bar';
	protected $description = 'Display Avada\'s title bar. Change the settings in Appearance > Theme Options > Page Title Bar tab. You can set different options, per page, when editing the page, in Fusion Page Options > Page Title Bar tab.';
	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Title_Bar_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/title-area.svg', __FILE__ );
	}

	public function get_editor_cell_template() {
		$this->setCategory();
		ob_start();
		?>
			<div class="cell-content">
			<p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
				<div class="cell-preview">
	                <div class="theme-integration-preview-area" style="text-align: center;">
                        <img src="<?php echo plugins_url( '/../../../public/img/title-area.svg', __FILE__ ); ?>" height="120px">
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}
}
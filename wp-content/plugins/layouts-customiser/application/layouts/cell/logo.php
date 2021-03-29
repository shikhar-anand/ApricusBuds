<?php
/**
 * Logo cell
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Logo extends WPDDL_Cell_Abstract {
	protected $id = 'logo';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Logo_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Logo_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'logo';

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
	protected $name = 'Header Logo';
	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Logo_Cell';
        protected $description = 'Display header logo. You can define logo from the theme Customize area.';
	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/title.svg', __FILE__ );
	}
        public function get_editor_cell_template() {
            $this->setCategory();

            ob_start();
            ?>
            <div class="cell-content">
            <p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
                <div class="cell-preview">
                    <div class="theme-integration-preview-area">
                        <img src="<?php echo plugins_url( '/../../../public/img/title.svg', __FILE__ );?>">
                    </div>
                </div>
            </div>
            <?php
            return ob_get_clean();
	}
}

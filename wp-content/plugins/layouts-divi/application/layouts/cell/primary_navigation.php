<?php
/**
 * Divi Logo Output
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Primary_Navigation extends WPDDL_Cell_Abstract {
	protected $id = 'divi-primary-navigation';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Primary_Navigation_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Primary_Navigation_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'divi-primary-navigation';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/primary_navigation.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Primary_Navigation_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Primary Navigation';
	protected $description = 'Display primary navigation.';
	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Primary_Navigation_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = DDL_ICONS_SVG_REL_PATH . 'layouts-menu-cell.svg';
	}

	protected function _dialog_template() {
		ob_start();
		?>

		<div class="ddl-form menu-cell">
			<p>
				<label for="<?php the_ddl_name_attr('toggle_search'); ?>"><?php _e( 'Toggle Search', 'ddl-layouts' ) ?>:</label>
				<input type="checkbox" name="<?php the_ddl_name_attr('toggle_search'); ?>" value="1" <?php echo ("1" == get_ddl_field('toggle_search'))?"checked":""; ?> />
				<?php _e('Add toggle search to main navigation', 'Divi'); ?>
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
			<p class="cell-name from-bot-10"><?php echo $this->category . ' - ' . $this->name; ?></p>
				<div class="cell-preview">
	                <div class="theme-integration-menu">
                        Toggle Search:
                        <# if( content.toggle_search == "1" ){ #>
							 On
                        <# } else { #>
							Off
                        <# } #>
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}
}
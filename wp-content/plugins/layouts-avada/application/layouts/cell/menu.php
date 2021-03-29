<?php
/**
 * Avada Menu Cell.
 */

/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Menu extends WPDDL_Cell_Abstract {
	protected $id = 'avada-menu';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Menu_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Menu_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'avada-menu';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/menu.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Menu_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Main Menu';
	protected $description = 'Display Avada\'s Main Navigation menu, which is the menu set in Appearance > Menus. Only 1 instance per layout is allowed for this cell.';
	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Menu_Cell';
	protected $allow_multiple = false;

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
				<?php _e('Add toggle search to main navigation', 'avada'); ?>
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
	                <div class="theme-integration-preview-area" style="text-align: center;">
	                	<img src="<?php echo DDL_ICONS_SVG_REL_PATH . 'layouts-menu-cell.svg'; ?>" height="120px">
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}
}
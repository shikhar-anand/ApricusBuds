<?php
/**
 * Avada Footer Area Cell.
 */

/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Footer extends WPDDL_Cell_Abstract {
	protected $id = 'avada-footer';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Footer_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Footer_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'avada-footer';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/footer.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Footer_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Footer Area';
	protected $description = 'Display Avada\'s footer area. Change these settings in Appearance > Theme Options > Footer tab. You can set a different footer, per page, when editing the page, in Fusion Page Options > Footer tab.';
	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Footer_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/footer.svg', __FILE__ );
	}

	protected function _dialog_template() {
		ob_start();
		?>

		<div class="ddl-form menu-cell">
			<p>
				<label for="<?php the_ddl_name_attr('show_widgets'); ?>"><?php _e( 'Widgets', 'ddl-layouts' ) ?>:</label>
				<input type="checkbox" name="<?php the_ddl_name_attr('show_widgets'); ?>" value="1" <?php echo ("1" == get_ddl_field('show_widgets'))?"checked":""; ?> />
				<?php _e('Add widgets area to the footer.', 'avada'); ?>
			</p>

			<p>
				<label for="<?php the_ddl_name_attr('show_copyright'); ?>"><?php _e( 'Copyrights', 'ddl-layouts' ) ?>:</label>
				<input type="checkbox" name="<?php the_ddl_name_attr('show_copyright'); ?>" value="1" <?php echo ("1" == get_ddl_field('show_copyright'))?"checked":""; ?> />
				<?php _e('Add copyrights and credits area to the footer.', 'avada'); ?>
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
	                	<img src="<?php echo plugins_url( '/../../../public/img/footer.svg', __FILE__ ); ?>" height="120px">
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}
}
<?php
/**
 * Divi Sidebar Cell
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Sidebar extends WPDDL_Cell_Abstract {
	protected $id = 'divi-sidebar';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Sidebar_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Sidebar_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'divi-sidebar';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/sidebar.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Sidebar_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Sidebar';
	protected $description = 'Display sidebar.';
	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Sidebar_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = DDL_ICONS_SVG_REL_PATH . 'widget-area.svg';
	}

	protected function _dialog_template() {
		ob_start();
		?>

<div class="ddl-form menu-cell" xmlns="http://www.w3.org/1999/html">
			<?php
			 	global $wp_registered_sidebars;

				$sidebar_used = "";
				$sidebar_name = "";

				if(get_ddl_field('sidebar')) {
					$sidebar_used = get_ddl_field('sidebar');
				}

				if(get_ddl_field('sidebar_name')) {
					$sidebar_name = get_ddl_field('sidebar_name');
				}
			?>
			<p>
				<label for="<?php the_ddl_name_attr('sidebar'); ?>"><?php _e( 'Sidebar', 'ddl-layouts' ) ?>:</label>
				<select name="<?php the_ddl_name_attr('sidebar'); ?>">
					<?php
						foreach($wp_registered_sidebars as $divi_sidebar) {
							$selected = ($sidebar_used == $divi_sidebar['id'])?"selected":"";

							if(empty($sidebar_name)) {	// Catching the name of 1st sidebar in the list
								$sidebar_name = $divi_sidebar['name'];
							}
					?>
							<option value="<?php echo $divi_sidebar['id']; ?>" <?php echo $selected; ?>><?php echo $divi_sidebar['name']; ?></option>
					<?php
						}
					?>
				</select>
				<input type="hidden" name="<?php the_ddl_name_attr('sidebar_name'); ?>" value="<?php echo $sidebar_name; ?>" />
				<script type="text/javascript">
					( function( $ ) {
						$("select[name=ddl-layout-sidebar]").on("change", function(e){
							e.preventDefault();

							$("input[name=ddl-layout-sidebar_name]").val($("select[name=ddl-layout-sidebar] option:selected").text());
						});
					})( jQuery );
				</script>
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
                        <# print(content.sidebar_name) #>
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}
}
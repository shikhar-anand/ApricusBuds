<?php


/**
 * Class WPDDL_Integration_Layouts_Cell_Menu
 */
class WPDDL_Integration_Layouts_Cell_Menu extends WPDDL_Cell_Abstract {
	protected $id      = 'genesis-menu';
	protected $factory = 'WPDDL_Integration_Layouts_Cell_Menu_Cell_Factory';
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Menu_Cell
 */
class WPDDL_Integration_Layouts_Cell_Menu_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'genesis-menu';

	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/menu.php';
	}
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Menu_Cell_Factory
 */
class WPDDL_Integration_Layouts_Cell_Menu_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {

	public function __construct() {
		$this->name              = __( 'Menu', 'ddl-layouts' );
		$this->description       = __( 'Display Genesis Menu, which displays the menu set as &quot;Primary Navigation Menu&quot; or &quot;Secondary Navigation Menu&quot; in Appearance > Menus.', 'ddl-layouts' );
		$this->cell_class        = 'WPDDL_Integration_Layouts_Cell_Menu_Cell';
	}

	protected function _dialog_template() {
		ob_start();
		?>

		<div class="ddl-form">
			<p>
				<label for="<?php the_ddl_name_attr('menu_select'); ?>"><?php _e( 'Select Menu', 'ddl-layouts' ) ?>:</label>
				<select name="<?php the_ddl_name_attr('menu_select'); ?>">
					<option value="primary"><?php _e( 'Primary Navigation Menu', 'genesis' ); ?></option>
					<option value="secondary"><?php _e( 'Secondary Navigation Menu', 'genesis' ); ?></option>
				</select>
			</p>
		</div>

		<?php
		return ob_get_clean();
	}

	protected function backendOutput( $menu ) {
		$menu_item_titles = array();

		switch( $menu ) {
				case 'primary':
					$menu_name = __( 'Primary Navigation Menu', 'genesis' );
					break;
				case 'secondary':
					$menu_name = __( 'Secondary Navigation Menu', 'genesis' );
					break;
		}

		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu ] ) ) {
			$menu_object = wp_get_nav_menu_object( $locations[ $menu ] );

			if( is_object( $menu_object ) ) {
				$menu_items = wp_get_nav_menu_items( $menu_object->term_id );

				if( $menu_items ) {
					foreach ( (array) $menu_items as $key => $menu_item ) {
						$menu_item_titles[] = $menu_item->title;
					}
				}
			}

		}

		if( ! empty( $menu_item_titles ) ) {
			return '<p><b>' . $menu_name . '</b></p>' .
			     '<p>' . implode( ' - ', $menu_item_titles ) . '</p>';
		} else {
			return '<p>No <b>' . $menu_name . '</b> created.</p>';
		}
	}

	public function get_editor_cell_template() {
		$this->setCategory();

		ob_start();
		?>
			<div class="cell-content">
			<p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
				<div class="cell-preview">
	                <div class="theme-integration-menu">
                        <# if( content.menu_select == "primary" ){ #>
							<?php $this->sanitizeContentForJS( $this->backendOutput( 'primary' ) ); ?>
                        <# } #>

						<# if( content.menu_select == "secondary" ){ #>
							<?php $this->sanitizeContentForJS( $this->backendOutput( 'secondary' ) ); ?>
                        <# } #>
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}

	protected function setCellImageUrl() {
		$this->cell_image_url = DDL_ICONS_SVG_REL_PATH . 'layouts-menu-cell.svg';
	}
}
<?php
/**
 * Avada woocommerce products listing cell.
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Listing extends WPDDL_Cell_Abstract {
	protected $id = 'avada-woocommerce-products-listing';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Listing_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Listing_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'avada-woocommerce-products-listing';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/woocommerce-products-listing.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Listing_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'WooCommerce Products Listing';
	protected $description = 'Displays the products list, which uses the design and settings from Avada theme.';
	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Listing_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/products-list.svg', __FILE__ );
	}

	public function get_editor_cell_template() {
		$this->setCategory();
		ob_start();
		?>
		<div class="cell-content">
			<p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
			<div class="cell-preview">
				<div class="theme-integration-preview-area" style="text-align: center;">
					<img src="<?php echo $this->cell_image_url; ?>" height="120px">
				</div>
			</div>
		</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
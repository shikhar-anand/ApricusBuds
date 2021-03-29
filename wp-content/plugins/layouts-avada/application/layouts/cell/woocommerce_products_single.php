<?php
/**
 * Avada woocommerce products listing cell.
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Single extends WPDDL_Cell_Abstract {
	protected $id = 'avada-woocommerce-products-single';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Single_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Single_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'avada-woocommerce-products-single';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/woocommerce-products-single.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Single_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'WooCommerce Single Product';
	protected $description = 'Displays single product details using Avada design and options.';
	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Single_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/single-product.svg', __FILE__ );
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
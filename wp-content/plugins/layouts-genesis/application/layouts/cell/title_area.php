<?php

/**
 * Class WPDDL_Integration_Layouts_Cell_Title_Area
 */
class WPDDL_Integration_Layouts_Cell_Title_Area extends WPDDL_Cell_Abstract {
	protected $id      = 'genesis-title-area';
	protected $factory = 'WPDDL_Integration_Layouts_Cell_Title_Area_Cell_Factory';
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Title_Area_Cell
 */
class WPDDL_Integration_Layouts_Cell_Title_Area_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'genesis-title-area';

	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/title-area.php';
	}
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Title_Area_Cell_Factory
 */
class WPDDL_Integration_Layouts_Cell_Title_Area_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {

	public function __construct() {
		$this->name              = __( 'Site title', 'ddl-layouts');
		$this->description       = __( "Display Genesis site title, including your website's title and tagline.", 'ddl-layouts');
		$this->cell_class        = 'WPDDL_Integration_Layouts_Cell_Title_Area_Cell';
		$this->preview_image_url = plugins_url( '/../../../public/img/title-area-description.png', __FILE__ );
	}

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
	                <div class="theme-integration-title-area">
	                    <h1><?php $this->sanitizeContentForJS( get_bloginfo( 'name' ) ); ?></h1>
						<p><?php $this->sanitizeContentForJS( get_bloginfo( 'description' ) ); ?></p>
					</div>
				</div>
			</div>
			</div>
			<script type="text/javascript">
				if( document.getElementsByClassName( 'footer-credits' ).length ) {
					document.getElementsByClassName( 'footer-credits' )[0].innerHTML =
			            document.getElementsByClassName( 'footer-credits' )[0].innerHTML.replace( '%year%', '<?php echo date('Y', time() ); ?>' );
				}
			</script>
		<?php
		return ob_get_clean();
	}
}
<?php
/**
 * Avada Site Logo Cell.
 */

/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Logo extends WPDDL_Cell_Abstract {
	protected $id = 'avada-logo';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Logo_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Logo_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'avada-logo';

	public function __construct($name, $width, $css_class_name, $content, $css_id, $tag)
	{
	    $css_class_name = $css_class_name . ' fusion-logo';
		parent::__construct($name, $width, $css_class_name, $content, $css_id, $tag);
	}

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
	protected $name = 'Logo';
	protected $description = 'Display the site\'s logo. Change the logo image and settings in Appearance > Theme Options > Logo tab.';
	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Logo_Cell';

	public function __construct() {
	    add_filter('ddl-additional_cells_tag_attributes_render', array(&$this, 'add_data_attrs'), 10, 3);
	    add_action( 'ddl_before_frontend_render_cell', array(&$this, 'before_cell_render'), 10, 2 );
	    add_action( 'ddl_after_frontend_render_cell', array(&$this, 'after_cell_render'), 10, 2 );
	}

	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/logo.svg', __FILE__ );
	}

	public function get_editor_cell_template() {
		$this->setCategory();
		ob_start();
		?>
			<div class="cell-content">
			<p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
				<div class="cell-preview">
	                <div class="theme-integration-preview-area" style="text-align: center;min-height:100px;">
                        <?php avada_logo(); ?>
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}

	function add_data_attrs( $out, $renderer, $cell ){
	    if( method_exists($cell, 'get_cell_type') && $cell->get_cell_type() === 'avada-logo' ) {
	        ob_start();?>
                data-margin-top="<?php echo intval( Avada()->settings->get( 'margin_logo_top' ) ); ?>px" data-margin-bottom="<?php echo intval( Avada()->settings->get( 'margin_logo_bottom' ) ); ?>px" data-margin-left="<?php echo intval( Avada()->settings->get( 'margin_logo_left' ) ); ?>px" data-margin-right="<?php echo intval( Avada()->settings->get( 'margin_logo_right' ) ); ?>px"
            <?php
	        $out .= ob_get_clean();
	    }
	    return $out;
	}

	function before_cell_render($cell, $render){
	    if( method_exists($cell, 'get_cell_type') && $cell->get_cell_type() === 'avada-logo' ){
	        do_action( 'avada_logo_prepend' );
	    }
	}

	function after_cell_render($cell, $render){
	    if( method_exists($cell, 'get_cell_type') && $cell->get_cell_type() === 'avada-logo' ){
	        do_action( 'avada_logo_append' );
	    }
	}
}
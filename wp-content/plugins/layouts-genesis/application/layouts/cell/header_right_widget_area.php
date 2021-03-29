<?php

/**
 * Class WPDDL_Integration_Layouts_Cell_Header_Right_Widget_Area
 */
class WPDDL_Integration_Layouts_Cell_Header_Right_Widget_Area extends WPDDL_Cell_Abstract {
	protected $id      = 'genesis-header-right-widget-area';
	protected $factory = 'WPDDL_Integration_Layouts_Cell_Header_Right_Widget_Area_Cell_Factory';
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Header_Right_Widget_Area_Cell
 */
class WPDDL_Integration_Layouts_Cell_Header_Right_Widget_Area_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'genesis-header-right-widget-area';

	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/header-right-widget-area.php';
	}
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Header_Right_Widget_Area_Cell_Factory
 */
class WPDDL_Integration_Layouts_Cell_Header_Right_Widget_Area_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	public function __construct() {
		$this->name              = __( '&quot;Header Right&quot; Widget Area', 'ddl-layouts');
		$this->description       = __( 'Display Genesis &quot;Header Right&quot; Widget Area, which includes all widgets placed in the &quot;Header Right&quot; Widget Area.', 'ddl-layouts');
		$this->cell_class        = 'WPDDL_Integration_Layouts_Cell_Header_Right_Widget_Area_Cell';
	}

	public function get_editor_cell_template() {
		$this->setCategory();

		ob_start();
		?>
			<div class="cell-content">
			<p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
				<div class="cell-preview">
	                <div class="theme-integration-header-right-widget-area">

	                <?php global $wp_registered_widgets;
	                $sidebars = get_option( 'sidebars_widgets' );

	                if( isset( $sidebars['header-right'] ) && count( $sidebars['header-right'] ) > 0 ) {
	                    $widgets = array();
	                    echo '<p><b>Widgets:</b> ';
		                foreach( $sidebars['header-right'] as $widget_id ) {
		                    $widgets[] = $wp_registered_widgets[$widget_id]['name'];
		                }
		                $this->sanitizeContentForJS( '<p>' . implode( ', ', $widgets ) . '</p>' );
	                } else {
	                    echo '<p>You haven\'t placed any widgets into the "Header Right" Widget Area.</p>';
	                } ?>
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}

	protected function setCellImageUrl() {
		$this->cell_image_url = DDL_ICONS_SVG_REL_PATH . 'single-widget.svg';
	}
}
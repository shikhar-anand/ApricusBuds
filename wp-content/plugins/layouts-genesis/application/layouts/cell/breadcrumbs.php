<?php


/**
 * Class WPDDL_Integration_Layouts_Cell_Breadcrumbs
 */
class WPDDL_Integration_Layouts_Cell_Breadcrumbs extends WPDDL_Cell_Abstract {
	protected $id      = 'genesis-breadcrumbs';
	protected $factory = 'WPDDL_Integration_Layouts_Cell_Breadcrumbs_Cell_Factory';
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Breadcrumbs_Cell
 */
class WPDDL_Integration_Layouts_Cell_Breadcrumbs_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'genesis-breadcrumbs';

	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/breadcrumbs.php';
	}
}


/**
 * Class WPDDL_Integration_Layouts_Cell_Breadcrumbs_Cell_Factory
 */
class WPDDL_Integration_Layouts_Cell_Breadcrumbs_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	public function __construct() {
		$this->name              = __( 'Breadcrumbs', 'ddl-layouts' );
		$this->description       = __( "Display Genesis Breadcrumbs, showing the location of the current post in the site hierarchy.", 'ddl-layouts');
		$this->cell_class        = 'WPDDL_Integration_Layouts_Cell_Breadcrumbs_Cell';
		$this->preview_image_url = plugins_url( '/../../../public/img/breadcrumbs-description.png', __FILE__ );
	}

	protected function _dialog_template() {
		ob_start();
		?>

		<div class="ddl-form">

			<div class="clear" style="height:10px"></div>
			<p>
				<label for="<?php the_ddl_name_attr('breadcrumbs_home_label'); ?>"><?php _e( 'Home Label', 'ddl-layouts' ) ?>:</label>
				<input type="text" name="<?php the_ddl_name_attr('breadcrumbs_home_label'); ?>" value="Home">
				<span class="desc">Default value: Home</span>
			</p>
			<div class="clear" style="height:10px"></div>
			<p>
				<label for="<?php the_ddl_name_attr('breadcrumbs_home_link'); ?>"><?php _e( 'Overwrite Home Link', 'ddl-layouts' ) ?>:</label>
				<input type="text" name="<?php the_ddl_name_attr('breadcrumbs_home_link'); ?>" value="">
				<span class="desc">Add full link starting with http://. Leave empty to use default.</span>
			</p>
			<div class="clear" style="height:10px"></div>
			<p>
				<label for="<?php the_ddl_name_attr('breadcrumbs_separator'); ?>"><?php _e( 'Separator', 'ddl-layouts' ) ?>:</label>
				<input type="text" name="<?php the_ddl_name_attr('breadcrumbs_separator'); ?>" value=" / ">
				<span class="desc">Change the Separator. Default value: / </span>
			</p>
			<div class="clear" style="height:10px"></div>
			<p>
				<label for="<?php the_ddl_name_attr('breadcrumbs_prefix'); ?>"><?php _e( 'Prefix Label', 'ddl-layouts' ) ?>:</label>
				<input type="text" name="<?php the_ddl_name_attr('breadcrumbs_prefix'); ?>" value="You are here: ">
				<span class="desc">Change the Breadcrumbs Prefix. Default value: You are here: </span>
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
			<p class="cell-name"><?php echo $this->category . ' - ' . $this->name; ?></p>
				<div class="cell-preview">
	                <div class="theme-integration-breadcrumbs">
                        <# if( content.breadcrumbs_prefix ){ #>
								<?php echo $this->sanitizeContentForJS( 'breadcrumbs_prefix' ); ?>
						<# } #>

						<# if( content.breadcrumbs_home_label ){ #>
							<?php echo $this->sanitizeContentForJS( 'breadcrumbs_home_label' ); ?>

							<# if( content.breadcrumbs_separator ){ #>
								<?php echo $this->sanitizeContentForJS( 'breadcrumbs_separator' ); ?>Page 1
							<# } #>
						<# } else { #>
							<# if( content.breadcrumbs_separator ){ #>
								Page 1<?php echo $this->sanitizeContentForJS( 'breadcrumbs_separator' ); ?>Page 2
							<# } #>
						<# } #>
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}

	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/breadcrumbs.svg', __FILE__ );
	}
}
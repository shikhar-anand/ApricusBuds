<?php
/**
 * Divi Header Elements Output
 * i.e. Social Icons, Phone Number and Email
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Social_Icons extends WPDDL_Cell_Abstract {
	protected $id = 'divi-social-icons';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Social_Icons_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Social_Icons_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = 'divi-social-icons';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/social_icons.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Social_Icons_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Header Elements';
	protected $description = 'Display header elements. These elements include Social Icons, Phone Number and Email.';
	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Social_Icons_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = DDL_ICONS_SVG_REL_PATH . 'layouts-imagebox-cell.svg';
	}

	protected function _dialog_template() {
		ob_start();
		?>

		<div class="ddl-form menu-cell">
			<p>
				<label><?php _e( 'Social Icons', 'ddl-layouts' ) ?>:</label>
				<span style="display: inline-block; margin-left: 10px;">
					<input type="checkbox" name="<?php the_ddl_name_attr('facebook'); ?>" value="1" <?php echo ("1" == get_ddl_field('facebook'))?"checked":""; ?> />
					<?php _e('Facebook', 'Divi'); ?>
				</span>
				<span style="display: inline-block; margin-left: 10px;">
					<input type="checkbox" name="<?php the_ddl_name_attr('twitter'); ?>" value="1" <?php echo ("1" == get_ddl_field('twitter'))?"checked":""; ?> />
					<?php _e('Twitter', 'Divi'); ?>
				</span>
				<span style="display: inline-block; margin-left: 10px;">
					<input type="checkbox" name="<?php the_ddl_name_attr('gplus'); ?>" value="1" <?php echo ("1" == get_ddl_field('gplus'))?"checked":""; ?> />
					<?php _e('Google+', 'Divi'); ?>
				</span>
				<span style="display: inline-block; margin-left: 10px;">
					<input type="checkbox" name="<?php the_ddl_name_attr('rss'); ?>" value="1" <?php echo ("1" == get_ddl_field('rss'))?"checked":""; ?> />
					<?php _e('RSS', 'Divi'); ?>
				</span>
			</p>

			<p>
				<label><?php _e( 'Phone Number', 'ddl-layouts' ) ?>:</label>
				<span style="display: inline-block; margin-left: 10px;">
					<input type="checkbox" name="<?php the_ddl_name_attr('phone'); ?>" value="1" <?php echo ("1" == get_ddl_field('phone'))?"checked":""; ?> />
					<?php _e('Display', 'Divi'); ?>
				</span>
			</p>

			<p>
				<label><?php _e( 'Email', 'ddl-layouts' ) ?>:</label>
				<span style="display: inline-block; margin-left: 10px;">
					<input type="checkbox" name="<?php the_ddl_name_attr('email'); ?>" value="1" <?php echo ("1" == get_ddl_field('email'))?"checked":""; ?> />
					<?php _e('Display', 'Divi'); ?>
				</span>
			</p>

			<p>
				<label></label>
				<span><?php _e('To update social profile links/IDs, phone number and email, please see Theme Options.', 'Divi'); ?></span>
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
	                	<# if( content.phone == "1" ){ #>
							 <span id="et-info-phone"></span>
                        <# } #>

                        <# if( content.email == "1" ){ #>
							 <span id="et-info-email"></span>
                        <# } #>

                        <# if( content.facebook == "1" ){ #>
							 <span class="et-social-icon et-social-facebook"><span class="icon"></span></span>
                        <# } #>

                        <# if( content.twitter == "1" ){ #>
							 <span class="et-social-icon et-social-twitter"><span class="icon"></span></span>
                        <# } #>

                        <# if( content.gplus == "1" ){ #>
							 <span class="et-social-icon et-social-google-plus"><span class="icon"></span></span>
                        <# } #>

                        <# if( content.rss == "1" ){ #>
							 <span class="et-social-icon et-social-rss"><span class="icon"></span></span>
                        <# } #>
					</div>
				</div>
			</div>
			</div>
		<?php
		return ob_get_clean();
	}
}
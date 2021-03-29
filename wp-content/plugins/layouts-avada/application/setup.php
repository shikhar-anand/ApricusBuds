<?php

/**
 * Singleton for setting up the integration.
 *
 * Note that it doesn't have to have unique name. Because of autoloading, it will be loaded only once (when this
 * integration plugin is operational).
 */
/** @noinspection PhpUndefinedClassInspection */
class WPDDL_Integration_Setup extends WPDDL_Theme_Integration_Setup_Abstract {
	public $zindexs;
	public $zidx;
	public $panel_count;

	/**
	 * @var Toolset_Admin_Notice_Layouts_Help
	 */
	private $help_notice;

	/**
	 * @var $help_anchor
	 */
	private static $help_anchor = '';

	/**
	 * Run Integration.
	 *
	 * @return bool|WP_Error True when the integration was successful or a WP_Error with a sensible message
	 *     (which can be displayed to the user directly).
	 */
	public function run() {
		$this->zindexs = array('idx-a', 'idx-b');
		$this->zidx = 0;
		$this->panel_count = 0;

		// Load default layouts
		$this->set_layouts_path( dirname( dirname( __FILE__) ) . DIRECTORY_SEPARATOR . 'public/layouts' );

		parent::run();
		return true;
	}

	/**
	 * @return bool
	 */
	public function add_bootstrap_support() {
		//parent::add_bootstrap_support();
		return false;
	}

	/**
	 * @return string
	 */
	protected function get_supported_theme_version() {
		return '4.0';
	}

	/**
	 * Build URL of an resource from path relative to plugin's root directory.
	 *
	 * @param string $relative_path Some path relative to the plugin's root directory.
	 * @return string URL of the given path.
	 */
	protected function get_plugins_url( $relative_path ) {
		return plugins_url( '/../' . $relative_path , __FILE__ );
	}

	/**
	 * Get list of templates supported by Layouts with this theme.
	 *
	 * @return array Associative array with template file names as keys and theme names as values.
	 */
	protected function get_supported_templates() {
		return array(
				$this->getPageDefaultTemplate() => __( 'Template page', 'ddl-layouts' ),
                'template-single.php' => __( 'Template post', 'ddl-layouts' ),
				'template-single.php' => __( 'Template post', 'ddl-layouts' ),
				'template-index.php' => __( 'Template index', 'ddl-layouts' ),
				'template-archive.php' => __( 'Template archive', 'ddl-layouts' ),
				'template-404.php' => __( 'Template 404', 'ddl-layouts' ),
		);
	}


	/**
	 * Layouts Support
	 *
	 * Implement theme-specific logic here. For example, you may want to:
	 *     - if theme has it's own loop, replace it by the_ddlayout()
	 *     - remove headers, footer, sidebars, menus and such, if achievable by filters
	 *     - otherwise you will have to resort to something like redirecting templates (see the template router below)
	 *     - add $this->clear_content() to some filters to remove unwanted site structure elements
	 */
	protected function add_layouts_support() {
		parent::add_layouts_support();

		/** @noinspection PhpUndefinedClassInspection */
		WPDDL_Integration_Theme_Template_Router::get_instance();

		add_filter('ddl-get_container_class', array( &$this, 'add_fusion_row' ), 10, 1);
		add_filter('ddl-get_container_class', array( &$this, 'disable_logo_resize' ), 11, 1);
		add_filter('ddl-get_container_fluid_class', array( &$this, 'disable_logo_resize' ), 11, 1);

		// Return list of forbidden cells for Content Layouts
		add_filter( 'ddl-disabled_cells_on_content_layout', array( &$this, 'disabled_cells_on_content_layout_function' ), 10, 1 );

		/**
		 * Adjust Layouts' tabs and accordion cells to compliment from Avada's tabs and panel modules
		 */
		add_filter( 'ddl-tabs-get_class_for_tabs', array( &$this, 'fix_layouts_tabs_cell' ), 99, 2 );
		add_filter( 'ddl-cell_render_output_before_content', array(&$this, 'avada_open_tabs_additional_div'), 10, 3 );
		add_filter( 'ddl-cell_render_output_after_content', array(&$this, 'avada_close_tabs_additional_div'), 99, 2 );
		add_filter( 'ddl_render_row_start', array(&$this, 'panel_start_render'), 99, 4 );

		if( version_compare( WPDDL_VERSION, '1.9-b3' ) !== -1 ) {
			// Add custom help link on edit layout screen
			$this->init_specific_help_link();
		}
	}

	/**
	 * Opens additional DIV required to render tabs as of Avada's
	 *
	 * @param $output
	 * @param $cell
	 * @param $target
	 *
	 * @return string
	 */
	public function avada_open_tabs_additional_div( $output, $cell, $target ) {
		if( $cell && 'tabs-cell' == $cell->get_cell_type() ) {
			$justified = '';

			if( ! $this->get_cell_property( 'justified', $cell ) ) {
				$justified .= ' nav-not-justified';
			}

			$output .= '<div class="fusion-tabs classic ' . $justified . ' horizontal-tabs">';
		}

		if( $cell && 'accordion-cell' == $cell->get_cell_type() ) {
			$output .= '<div class="accordian fusion-accordian">';
		}

		return $output;
	}

	/**
	 * Closes additional DIV
	 *
	 * @param $output
	 * @param $cell
	 *
	 * @return string
	 */
	public function avada_close_tabs_additional_div( $output, $cell ) {
		if( $cell && 'tabs-cell' == $cell->get_cell_type() ) {
			$output .= '</div>';
		}

		if( $cell && 'accordion-cell' == $cell->get_cell_type() ) {
			$output .= '</div>';
		}

		return $output;
	}

	/**
	 * Applies additional classes for tabs
	 *
	 * @param $classes
	 * @param $cell
	 *
	 * @return string
	 */
	public function fix_layouts_tabs_cell( $classes, $cell ) {
		if( $this->get_cell_property( 'justified', $cell ) ) {
			$classes .= ' nav-justified';
		}

		return $classes;
	}

	/**
	 * Make adjustments to panel HTML
	 *
	 * @param $out
	 * @param $args
	 * @param $row
	 * @param $renderer
	 *
	 * @return mixed
	 */
	public function panel_start_render( $out, $args, $row, $renderer ){
		$panel = $row->get_as_array();

		if( 'Panel' == $panel['kind'] ) {
			// Add fusion-panel class
			$out = str_replace( 'panel panel-default', 'fusion-panel panel panel-default', $out );

			// Add toggle class to panel-title
			$out = str_replace( 'panel-title', 'panel-title toggle', $out );

			// Make first anchor active by adding class 'active'
			// Layouts outputs first panel anchor class as class=""
			if( 0 == $this->panel_count ) {
				$out = str_replace( 'class=""', 'class="active"', $out );
				$this->panel_count++;
			}

			// Strip out panel title and add later with fusion icon wrapper
			$out = str_replace( $panel['name'], '', $out );

			// Add fusion panel icon and wrapper
			$fusion_icon = '<div class="fusion-toggle-icon-wrapper"><i class="fa-fusion-box"></i></div>';
			$fusion_icon .= '<div class="fusion-toggle-heading">' . $panel['name'] . '</div>';
			$out = str_replace( '</a>', $fusion_icon . '</a>', trim($out) );
		}

		return $out;
	}

	/**
	 * Get cell property (setting)
	 *
	 * @param $property
	 * @param $cell
	 *
	 * @return mixed
	 */
	private function get_cell_property( $property, $cell ) {
		$cell_props = $cell->get_as_array();

		return $cell_props[ $property ];
	}

	public function disabled_cells_on_content_layout_function() {
		return array(
			'avada-footer',
			'avada-header',
			'avada-logo',
			'avada-menu',
			'avada-secondary-menu',
			'avada-sidebar',
			'avada-title-bar'
		);
	}

	/**
	 * Get template for notice text.
	 *
	 * @param string $tag Unique id for template file.
	 *
	 * @return string Absolute path to notice template file.
	 */
	private function get_notice_template( $tag ) {
		$notice_templates = array(
			'help-generic' => 'help-generic.phtml'
		);
		$notices_dir = dirname( dirname( __FILE__) )  . '/public/notices/';

		return $notices_dir . $notice_templates[ $tag ];
	}

	public static function get_help_anchor() {
		return self::$help_anchor;
	}

	/**
	 * @param $layout_slug
	 *
	 * @return bool
	 */
	private function is_default_layout( $layout_slug ) {
		$default_layouts = array(
			'header-footer',
			'pages',
			'posts',
			'archives',
			'error-404-page',
			'home-page'
		);

		if( in_array( $layout_slug, $default_layouts ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Initialise the registration of help notice placed under the title of the layout
	 */
	private function init_specific_help_link() {
		// init Toolset_Admin_Notice_Layouts_Help (the id is just a "dummy" id and will be overwritten later)
		$this->help_notice = new Toolset_Admin_Notice_Layouts_Help( 'layouts-no-help-link' );
		// make notice permanent dismissible by the user
		$this->help_notice->set_is_dismissible_permanent( true );
		// add the notice to our Toolset_Admin_Notices_Manager
		Toolset_Admin_Notices_Manager::add_notice( $this->help_notice );

		// apply content to notice related to the current layout on 'ddl-print-editor-additional-help-link'
		add_action( 'ddl-print-editor-additional-help-link', array( &$this, 'set_content_for_specific_help_link'), 10, 3 );
	}

	/**
	 * Set content for help link
	 *
	 * @param $layouts_array
	 * @param $current_id
	 * @param $current_slug
	 */
	public function set_content_for_specific_help_link( $layouts_array, $current_id, $current_slug ){
		//$current = $layouts_array[$current_id];

		if( $this->is_default_layout( $current_slug ) ){
			$this->help_notice->set_id( 'layouts-help-generic' );
			$this->help_notice->set_content( $this->get_notice_template( 'help-generic' ) );
			self::$help_anchor = $current_slug;

			// we don't want to show more than one message
			return;
		}

		// place for more help links
		// ...
		// ...
	}

	function add_fusion_row( $el ){
			return "{$el} fusion-row";
	}

	/**
	 * Add custom theme elements to Layouts.
	 */
	protected function add_layouts_cells() {
		// Header Cell
		$cell = new WPDDL_Integration_Layouts_Cell_Header();
		$cell->setup();

		// Menu Cell
		$cell = new WPDDL_Integration_Layouts_Cell_Menu();
		$cell->setup();

		// Secondary Menu
		$cell = new WPDDL_Integration_Layouts_Cell_Secondary_Menu();
		$cell->setup();

		// Title Bar Cell
		$cell = new WPDDL_Integration_Layouts_Cell_Title_Bar();
		$cell->setup();

		// Sidebar Cell
		$cell = new WPDDL_Integration_Layouts_Cell_Sidebar();
		$cell->setup();

		// Footer Cell
		$cell = new WPDDL_Integration_Layouts_Cell_Footer();
		$cell->setup();

		// Logo Cell
		$cell = new WPDDL_Integration_Layouts_Cell_Logo();
		$cell->setup();

		// Search Cell
		$cell = new WPDDL_Integration_Layouts_Cell_Search();
		$cell->setup();

		// Social Icons
		$cell = new WPDDL_Integration_Layouts_Cell_Social_Icons();
		$cell->setup();

		// Contact Info
		$cell = new WPDDL_Integration_Layouts_Cell_Contact_Info();
		$cell->setup();

		// WooCommerce Products Listing
		$cell = new WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Listing();
		$cell->setup();

		// WooCommerce Products Single
		$cell = new WPDDL_Integration_Layouts_Cell_Woocommerce_Products_Single();
		$cell->setup();

		unset( $cell );
	}

	public function moveCellCategoryToTop( $categories ) {
		$temp = array( 'Avada' => $categories['Avada'] );
		unset( $categories['Avada'] );
		return  $temp + $categories;
	}

	/**
	 * Add custom row modes elements to Layouts.
	 *
	 */
	protected function add_layout_row_types() {
		// Content
		add_filter( 'ddl-get_rows_modes_gui_list', array($this, 'add_Avada_content_row_mode' ));
		add_filter('ddl_render_row_start', array($this, 'Avada_custom_row_open'), 98, 2);
		add_filter('ddl_render_row_end', array($this, 'Avada_custom_row_close'), 98, 3);
	}

	/**
	 * Header Row Mode
	 */
	public function add_Avada_content_row_mode($lists_html) {
		ob_start(); ?>
		<li>
			<figure class="row-type">
				<img class="item-preview" data-name="row_avada_content" src="<?php echo WPDDL_GUI_RELPATH; ?>dialogs/img/tn-boxed.png" alt="<?php _e('Avada Content', 'ddl-layouts'); ?>">
				<span><?php _e('Avada content row', 'ddl-layouts'); ?></span>
			</figure>
			<label class="radio" data-target="row_avada_content" for="row_avada_content" style="display:none">
				<input type="radio" name="row_type" id="row_avada_content" value="avada_content">
				<?php _e('Avada content', 'ddl-layouts'); ?>
			</label>
		</li>
		<style type="text/css">
			.presets-list li{width:25%!important;}
		</style>
		<?php
		$lists_html .= ob_get_clean();
		return $lists_html;
	}

	public function Avada_custom_row_open($markup, $args) {
		if( $args['mode'] === 'avada_content' ){
			$container_classes = $args['container_class'].' post-content';

			ob_start();?>
			<div class="<?php echo $container_classes; ?>">
			<?php
			$markup = ob_get_clean();
		}
		return $markup;
	}

	public function Avada_custom_row_close($output, $mode, $tag) {
		if( $mode === 'avada_content' ) {
			ob_start(); ?>
			</div><!-- .post-content -->

			<?php
			$output = ob_get_clean();
		}
		return $output;
	}

	/**
	 * This function is used to remove all theme settings which are obsolete with the use of Layouts
	 * i.e. "Default Layout" in "Theme Settings"
	 */
	protected function modify_theme_settings() {
		// ...
	}

	public function disable_logo_resize( $el ) {
		return "{$el} avada-logo-integration";
	}
}

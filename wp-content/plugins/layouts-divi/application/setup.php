<?php
/**
 * Singleton for setting up the integration.
 *
 * Note that it doesn't have to have unique name. Because of autoloading, it will be loaded only once (when this
 * integration plugin is operational).
 *
 */
/** @noinspection PhpUndefinedClassInspection */
class WPDDL_Integration_Setup extends WPDDL_Theme_Integration_Setup_Abstract {
	protected $custom_frontend_js_path;

	/**
	 * @var Toolset_Admin_Notice_Layouts_Help
	 */
	private $help_notice;

	private $has_been_removed = false;

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
		$this->custom_frontend_js_path = 'public/js/custom-frontend.js';

		// reorder cell categories
		add_filter( 'ddl-get_cell_categories', array( $this, 'moveCellCategoryToTop' ) );

		/**
		 * Hook 'the_content' filter so earlier that none of the content is expanded.
		 * Because Divi Builder produces shortcodes with extra line breaks in the beginning,
		 * which cause content expansion (by shortcodes and wpautop) to translate unnecessary
		 * line breaks into empty paragraph tags. And this produces unwanted/empty paragraphs on frontend.
		 *
		 * Invoking 'the_content' filter earlier helps trimming the raw content.
		 *
		 * @see WPDDL_Integration_Setup::trimDiviContent()
		 * @deprecated 1.5
		 */
		//add_filter( 'the_content', array( $this, 'trimDiviContent' ), 9999 );
		//add_filter( 'wpv_filter_wpv_the_content_suppressed', array( $this, 'trimDiviContent' ), 1 );

		// Load default layouts
		$this->set_layouts_path( dirname( dirname( __FILE__) ) . DIRECTORY_SEPARATOR . 'public/layouts' );

		$this->setPageDefaultTemplate( 'template-default.php' );

		// Support for Bootstrap based Cell Types (i.e. Tabs, Accordions and etc)
		add_filter( 'ddl-render_tab_cell', array( $this, 'render_tab_cell_js' ), 10, 3 );
		add_filter('ddl-accordion_open', array( $this, 'render_accordion_cell_js' ), 10, 2 );

		/**
		 * Fix for Divi Front-end Builder.
		 *
		 * @since 1.5
		 */
		add_action( 'ddl_before_frontend_render_cell', array( $this, 'remove_extra_instances_divi_builder' ), 10, 2 );

		/**
		 * Support for WooCommerce default layouts (products archives and products single pages)
		 *
		 * @since 1.7
		 */
		remove_action( 'woocommerce_before_main_content', 'et_divi_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'et_divi_output_content_wrapper_end', 10 );
		add_filter( 'get_the_archive_title', array( $this, 'divi_woocommerce_show_page_title' ), 10, 1 );

		parent::run();
		return true;
	}


	/**
	 * Removes extra instances of Divi Front-end Builder.
	 *
	 * These are invoked by `the_content` filter, added in /themes/Divi/includes/builder/frontend-builder/view.php
	 * Mainly the callback depends on is_main_query() and adds FE builder instance.
	 * Since, the cells (mentioned in $content_cells below) play with the main query, the above callback is trapped.
	 * We need to remove the filter after first execution, for these particular cells.
	 *
	 * @since 1.5
	 */
	public function remove_extra_instances_divi_builder($cell, $renderer) {
		// Cells playing with main query and causing `the_content` filter to be trapped.

		if(isset($_GET['et_fb']) && $_GET['et_fb'] === '1' ) {
			$content_cells = array(
				'cell-text',
				'cell-content-template',
				'views-content-grid-cell',
				'post-loop-views-cell'
			);

			if ( in_array( $cell->get_cell_type(), $content_cells ) && $this->has_been_removed === false ) {
				// Remove the filter
				remove_filter( 'the_content', 'et_fb_app_boot', 1 );
				$this->has_been_removed = true;
			}

			if ( $cell->get_cell_type() === 'cell-post-content' && $this->has_been_removed === true ) {
				add_filter( 'the_content', 'et_fb_app_boot', 1 );
				$this->has_been_removed = false;
			}
		}
	}

	public function frontend_enqueue() {
		parent::frontend_enqueue();

		if( is_ddlayout_assigned() ) {
			wp_register_script(
				'layouts-theme-integration-frontend-js',
				$this->get_plugins_url( $this->custom_frontend_js_path ),
				array(),
				$this->get_supported_theme_version()
			);

			wp_enqueue_script( 'layouts-theme-integration-frontend-js' );
		}
	}

	public function admin_enqueue() {
		parent::admin_enqueue();
		wp_enqueue_script( 'layouts-theme-integration-backend' );
	}

	function get_custom_backend_js_path(){
		return 'public/js/theme-integration-admin.js';
	}


	/**
	 * @return string
	 */
	protected function get_supported_theme_version() {
		return '3.0.15';
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
			$this->getPageDefaultTemplate() => __( 'Template page', 'ddl-layouts' )
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

		if( version_compare( WPDDL_VERSION, '1.9-b3' ) !== -1 ) {
			// Add custom help link on edit layout screen
			$this->init_specific_help_link();
		}

		// Return list of forbidden cells for Content Layouts
		add_filter( 'ddl-disabled_cells_on_content_layout', array( &$this, 'disabled_cells_on_content_layout_function' ), 10, 1 );
	}

	public function disabled_cells_on_content_layout_function() {
		return array(
			'divi-logo',
			'divi-post-title',
			'divi-primary-navigation',
			'divi-sidebar',
			'divi-social-icons'
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

	/**
	 * Add custom theme elements to Layouts.
	 *
	 */
	protected function add_layouts_cells() {
		// logo
		$logo = new WPDDL_Integration_Layouts_Cell_Logo();
		$logo->setup();

		// primary nav
		$primary_navigation = new WPDDL_Integration_Layouts_Cell_Primary_Navigation();
		$primary_navigation->setup();

		// social icons
		$social_icons = new WPDDL_Integration_Layouts_Cell_Social_Icons();
		$social_icons->setup();

		// sidebar
		$sidebar = new WPDDL_Integration_Layouts_Cell_Sidebar();
		$sidebar->setup();

		// post title
		$post_title = new WPDDL_Integration_Layouts_Cell_Post_Title();
		$post_title->setup();
	}

	public function moveCellCategoryToTop( $categories ) {
		$temp = array( 'Divi' => $categories['Divi'] );
		unset( $categories['Divi'] );
		return  $temp + $categories;
	}


	/**
	 * Add custom row modes elements to Layouts.
	 *
	 */
	protected function add_layout_row_types() {
		// Top Header
		$top = new WPDDL_Integration_Layouts_Row_Type_Top();
		$top->setup();

		// Header
		$header = new WPDDL_Integration_Layouts_Row_Type_Header();
		$header->setup();

		// Content
		$content = new WPDDL_Integration_Layouts_Row_Type_Content();
		$content->setup();

		// Footer
		$footer = new WPDDL_Integration_Layouts_Row_Type_Footer();
		$footer->setup();

		return $this;
	}


	/**
	 * This method can be used to remove all theme settings which are obsolete with the use of Layouts
	 * i.e. "Default Layout" in "Theme Settings"
	 *
	 */
	protected function modify_theme_settings() {
		// ...
	}

	public function modifyThemeWidgets() {

		unregister_sidebar( 'sidebar-2' );
		unregister_sidebar( 'sidebar-3' );
		unregister_sidebar( 'sidebar-4' );
		unregister_sidebar( 'sidebar-5' );

		return $this;
	}

	/**
	 * Callback for 'the_content' filter.
	 * Grabs current post content and applies trim().
	 *
	 * @return string Post Content
	 * @deprecated 1.5
	 */
	public function trimDiviContent() {
		global $post;

		$content = trim( $post->post_content );

		return $content;
	}

	public function render_tab_cell_js( $output, $cell, $tab_id ) {
		ob_start(); ?>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				$( '#<?php echo $tab_id; ?>' + ' a' ).click( function( e ) {
					e.preventDefault();
					$( this ).tab( 'show' );
				} )
			} );
		</script>
		<?php
		$output = $output . ob_get_clean();

		return $output;
	}

	public function render_accordion_cell_js( $content, $cell ) {
		$cell_id = $cell->get_unique_identifier();
		ob_start(); ?>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#<?php echo $cell_id; ?> .panel a').on('click', function(e){
					e.preventDefault();

					$('#<?php echo $cell_id; ?> .panel a').each(function(i){
						var tt = $(this).attr('href');
						$(this).addClass('collapsed');
						$(tt).removeClass('in').addClass('collapse');
					});

					var t = $(this).attr("href");

					if($(this).hasClass('collapsed')) {
						$(this).removeClass('collapsed');
						$(t).removeClass('collapse').addClass('in');
					} else {
						$(this).addClass('collapsed');
						$(t).addClass('collapse').removeClass('in');
					}

				});
			});
		</script>

		<?php
		$content = $content.ob_get_clean();

		return $content;
	}

	// TODO: move me to layouts abstract setup class
	/**
	 * Returns appropriate page title to mimic theme's defaults.
	 *
	 * @param $title
	 *
	 * @return string
	 * @since 1.7
	 */
	public function divi_woocommerce_show_page_title( $title ) {
		if ( self::is_woocommerce_active() && is_woocommerce() ) {
			if ( is_shop() ) {
				/**
				 * WooCommerce shop plays dual; as a shop page and an archive.
				 * By default, Views short code for archive title output different stuff,
				 * while, theme shows Shop Page title.
				 *
				 * Here, the title is modified to return the title of Shop Page.
				 */
				$shop_page_id = get_option( 'woocommerce_shop_page_id' );
				$title = sprintf( __( '%s', 'ddl-layouts' ), get_the_title( $shop_page_id ) );
			} else if ( is_product_category() ) {
				/**
				 * Just like the above, we need to strip-off the stuff other than the category name, from the title.
				 */
				$title = sprintf( __( '%s', 'ddl-layouts' ), single_cat_title( '', false ) );
			}
		}

		return $title;

	}

	// TODO: move me to layouts abstract setup class
	/**
	 * @return bool
	 * check if Wooccomerce is actice
	 */
	public static function is_woocommerce_active(){
		return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}
}
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
	/**
	 * @var Toolset_Admin_Notice_Layouts_Help
	 */
	private $help_notice;

	/**
	 * @var $help_anchor
	 */
	private static $help_anchor = '';

	protected function __construct() {
		WPDDL_Integration_Woocommerce_Setup::getInstance();
		/**
		 * Fix for Toolset Access error pages when error template override is in an archive
		 */
		add_filter( 'ddl-has_current_post_ddlayout_template', array(__CLASS__, 'return_true'), 999, 1 );
	}

	/**
	 * Run Integration.
	 *
	 * @return bool|WP_Error True when the integration was successful or a WP_Error with a sensible message
	 *     (which can be displayed to the user directly).
	 */
	public function run() {
		// load default layouts if exists
		if ( is_readable( dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'public/layouts' ) ) {
			$this->set_layouts_path( dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'public/layouts' );
		}

		/**
		 * Support for WooCommerce default layouts (products archives and products single pages)
		 *
		 * @since 1.9
		 */
		// Override default archive title to output appropriate page title, as per WC
		add_filter( 'get_the_archive_title', array( $this, 'genesis_woocommerce_show_page_title' ), 10, 1 );

		parent::run();
		$this->setPageDefaultTemplate( 'page.php' );
		$this->add_layouts_rows();
		$this->add_shortcodes();

		return true;
	}


	/**
	 * @return string
	 */
	protected function get_supported_theme_version() {
		return '2.2.3';
	}


	/**
	 * Build URL of an resource from path relative to plugin's root directory.
	 *
	 * @param string $relative_path Some path relative to the plugin's root directory.
	 *
	 * @return string URL of the given path.
	 */
	protected function get_plugins_url( $relative_path ) {
		return plugins_url( '/../' . $relative_path, __FILE__ );
	}


	/**
	 * Get list of templates supported by Layouts with this theme.
	 *
	 * @return array Associative array with template file names as keys and theme names as values.
	 */
	protected function get_supported_templates() {
		return array(
			$this->getPageDefaultTemplate() => __( 'Page', 'ddl-layouts' )
		);
	}

	/**
	 * Enqueue frontend assets.
	 *
	 * If get_custom_frontend_css_path() returns a path, that file will be enqueued.
	 */
	public function frontend_enqueue() {
		// css
		if ( is_ddlayout_assigned() === false ) {
			return;
		}

		$custom_css_relpath = $this->get_custom_frontend_css_path();

		if ( ! empty( $custom_css_relpath ) ) {
			wp_register_style(
				'layouts-theme-integration-frontend',
				$this->get_plugins_url( $custom_css_relpath ),
				array(),
				$this->get_supported_theme_version()
			);

			wp_enqueue_style( 'layouts-theme-integration-frontend' );
		}

		// js
		$custom_js_relpath = $this->get_custom_frontend_js_path();

		if ( ! empty( $custom_js_relpath ) ) {
			wp_register_script(
				'layouts-theme-integration-frontend',
				$this->get_plugins_url( $custom_js_relpath ),
				array( 'jquery' ),
				$this->get_supported_theme_version(),
				true
			);

			wp_enqueue_script( 'layouts-theme-integration-frontend' );
		}
	}

	/**
	 * @return string Path of CSS file that will be included on the frontend or an empty string if no such file is needed.
	 * The path needs to be relative to the integration plugin root directory.
	 */
	protected function get_custom_frontend_css_path() {
		return 'public/css/theme-integration.css';
	}

	/**
	 * @return string Path of CSS file that will be included on the backend or an empty string if no such file is needed.
	 * The path needs to be relative to the integration plugin root directory.
	 */
	protected function get_custom_backend_css_path() {
		return 'public/css/theme-integration-backend.css';
	}

	/**
	 * @return string Path of JS file that will be included on the backend or an empty string if no such file is needed.
	 * The path needs to be relative to the integration plugin root directory.
	 */
	protected function get_custom_frontend_js_path() {
		return 'public/js/theme-integration.js';
	}

	/**
	 * @return string Path of JS file that will be included on the backend or an empty string if no such file is needed.
	 * The path needs to be relative to the integration plugin root directory.
	 */
	protected function get_custom_backend_js_path() {
		return 'public/js/theme-integration-backend.js';
	}

	/**
	 * Layouts Support
	 */
	protected function add_layouts_support() {

		parent::add_layouts_support();

		add_action( 'get_header', array( &$this, 'genesis_overriders' ), 8 );

		// Remove row-fluid support
		add_filter( 'ddl-get_fluid_type_class_suffix', array( &$this, 'remove_row_fluid_support' ), 10, 2 );

		// Return list of forbidden cells for Content Layouts
		add_filter( 'ddl-disabled_cells_on_content_layout', array( &$this, 'disabled_cells_on_content_layout_function' ), 10, 1 );

		if( version_compare( WPDDL_VERSION, '1.9-b3' ) !== -1 ) {
			// Add custom help link on edit layout screen
			$this->init_specific_help_link();
		}

		return $this;

		/** @noinspection PhpUndefinedClassInspection */
		WPDDL_Integration_Theme_Template_Router::get_instance();

	}

	public function disabled_cells_on_content_layout_function() {
		return array(
			'genesis-footer',
			'genesis-header-right-widget-area',
			'genesis-menu',
			'genesis-primary_sidebar-widget-area',
			'genesis-title-area'
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
			'layout-for-header-footer',
			'layout-for-pages',
			'layout-for-posts',
			'layout-for-archives',
			'layout-for-blog',
			'layout-for-error-404-page',
			'layout-for-search-results'
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
		
		if( $this->is_default_layout( $current_slug ) ){
			$this->help_notice->set_id( 'layouts-help-generic' );
			$this->help_notice->set_content( $this->get_notice_template( 'help-generic' ) );
			self::$help_anchor = $current_slug;

			// we don't want to show more than one message
			return;
		}
	}

	function remove_row_fluid_support( $suffix, $mode ) {
		return "";
	}

	function genesis_do_loop() {
		the_ddlayout();
	}

	function genesis_overriders() {

		if ( is_ddlayout_assigned() === false ) {
			return $this;
		}


		remove_action( 'genesis_loop', 'genesis_do_loop' );
		remove_all_actions( 'genesis_loop' );
		add_action( 'genesis_loop', array( &$this, 'genesis_do_loop' ) );

		/**
		 * in case the child theme adds structural wrap around Layouts divs
		 */
		remove_theme_support( 'genesis-structural-wraps' );

		// remove genesis header
		remove_action( 'genesis_header', 'genesis_do_header' );
		remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
		remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
		remove_all_actions( 'genesis_header' );

		// remove genesis footer
		remove_action( 'genesis_footer', 'genesis_do_footer' );
		remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
		remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
		remove_all_actions( 'genesis_footer' );

		// remove genesis sidebar
		remove_all_actions( 'genesis_sidebar' );
		remove_all_actions( 'genesis_sidebar_alt' );
		add_filter( 'genesis_markup_sidebar-primary_output', array( $this, 'clear_content' ) );

		// remove genesis menu
		remove_action( 'genesis_after_header', 'genesis_do_nav' );
		remove_action( 'genesis_after_header', 'genesis_do_subnav' );

		// remove genesis site structure output
		add_filter( 'genesis_markup_content-sidebar-wrap_output', array( $this, 'clear_content' ) );
		add_filter( 'genesis_markup_content_output', array( $this, 'clear_content' ) );
		add_filter( 'genesis_markup_site-inner_output', array( $this, 'clear_content' ) );

		// closing elements have no context set by genesis - so they cannot be target exactly
		add_filter( 'genesis_markup__output', array( $this, 'clear_content' ) );

		// remove 404 genesis output if a 404 layout isset
		$layouts_options = get_option( 'ddlayouts_options' );
		if ( is_array( $layouts_options ) && isset( $layouts_options['layouts_404_page'] ) ) {
			add_action( 'genesis_loop', array( $this, 'remove_default_404_content' ), 8 );
		}

		// remove default archive output
		remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
		remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
		remove_action( 'genesis_before_loop', 'genesis_do_author_box_archive', 15 );
		remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
		remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
		remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
		remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
		remove_all_actions( 'genesis_before_loop' );

		// remove header menu
		remove_action( 'genesis_header', 'genesis_do_nav', 12 );

		// say Layouts that the theme supports Layouts
		$theme = wp_get_theme();
		$options_manager = new WPDDL_Options_Manager( 'ddl_template_check' );
		if ( ! $options_manager->get_options( 'theme-' . $theme->get( 'Name' ) ) ) {
			$options_manager->update_options( 'theme-' . $theme->get( 'Name' ), 1 );
		}
	}


	/**
	 * Add custom theme elements to Layouts.
	 */
	protected function add_layouts_cells() {

		// Author Box
		$author_box = new WPDDL_Integration_Layouts_Cell_Author_Box();
		$author_box->setup();

		// Breadcrumbs
		$breadcrumbs = new WPDDL_Integration_Layouts_Cell_Breadcrumbs();
		$breadcrumbs->setup();

		// Footer
		$author_box = new WPDDL_Integration_Layouts_Cell_Footer();
		$author_box->setup();

		// Menu
		$menu = new WPDDL_Integration_Layouts_Cell_Menu();
		$menu->setup();

		// Post Navigation
		$post_navigation = new WPDDL_Integration_Layouts_Cell_Post_Navigation();
		$post_navigation->setup();

		// Search Form
		$search_form = new WPDDL_Integration_Layouts_Cell_Search_Form();
		$search_form->setup();

		// Site title
		$title_area = new WPDDL_Integration_Layouts_Cell_Title_Area();
		$title_area->setup();

		// Header Right Widget Area
		$header_right_widget_area = new WPDDL_Integration_Layouts_Cell_Header_Right_Widget_Area();
		$header_right_widget_area->setup();

		// Primary Sidebar Widget Area
		$primary_sidebar = new WPDDL_Integration_Layouts_Cell_Primary_Sidebar_Widget_Area();
		$primary_sidebar->setup();
	}

	/**
	 * Add custom theme rows to Layouts.
	 */
	public function add_layouts_rows() {
		// Site Header
		$site_header = new Layouts_Integration_Layouts_Row_Type_Site_header();
		$site_header->setup();

		// Content
		$site_header = new Layouts_Integration_Layouts_Row_Type_Content();
		$site_header->setup();

		// Sidebar
		$sidebar = new Layouts_Integration_Layouts_Row_Type_Sidebar();
		$sidebar->setup();


		return $this;
	}


	public function add_shortcodes() {
		// post-template
		$post_content = new Layouts_Integration_Theme_Shortcode_Post_Template();
		$post_content->setup();

		// comments
		$comments_content = new Layouts_Integration_Theme_Shortcode_Comments_Template();
		$comments_content->setup();

		return $this;
	}

	/**
	 * This method can be used to remove all theme settings which are obsolete with the use of Layouts
	 * i.e. "Default Layout" in "Theme Settings"
	 */
	protected function modify_theme_settings() {
		// remove "Default Layouts" in Genesis > Theme Settings
		add_action( 'load-toplevel_page_genesis', array(
			'Layouts_Integration_Theme_Settings_Default_Layouts',
			'setup'
		), 100 );

		// remove "Blog Page Template" in Genesis > Theme Settings
		add_action( 'load-toplevel_page_genesis', array(
			'Layouts_Integration_Theme_Settings_Blog_Page_Template',
			'setup'
		), 100 );

		// replace default "Breadcrumb" option with a hint to a new Layouts Element
		add_action( 'genesis_admin_before_metaboxes', array(
			'Layouts_Integration_Theme_Settings_Breadcrumbs',
			'setup'
		) );

		// remove Genesis sidebars "Primary" & "Secondary"
		//unregister_sidebar( 'sidebar' );
		unregister_sidebar( 'sidebar-alt' );
	}

	public function remove_default_404_content() {
		remove_action( 'genesis_loop', 'genesis_404' );
	}

	// TODO: move me to layouts abstract setup class
	/**
	 * Returns appropriate page title to mimic theme's defaults.
	 *
	 * @param $title
	 *
	 * @return string
	 * @since 1.9
	 */
	public function genesis_woocommerce_show_page_title( $title ) {
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
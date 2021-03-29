<?php
/**
 * Integration loader. Determines if the integration should execute and if yes, execute it properly.
 *
 * When this file is loaded, we already know Layouts are active, theme integration support is loaded and it has
 * correct API version.
 *
 * See WPDDL_Theme_Integration_Abstract for details.
 *
 */
final class WPDDL_Avada_Integration extends WPDDL_Theme_Integration_Abstract {


	/**
	 * Theme-specific initialization.
	 *
	 * @return bool|WP_Error True when the integration was successful or a WP_Error with a sensible message
	 *     (which can be displayed to the user directly).
	 */
	protected function initialize() {
		// Check for supported theme version.
		add_action( 'init', array( $this, 'check_theme_version' ) );

		// Setup the autoloader
		$autoloader = WPDDL_Theme_Integration_Autoloader::getInstance();
		$autoloader->addPath( dirname( __FILE__ ) . '/application' );

		// Initialize Toolset Site Installer
		try {
			$this->initializeToolsetSiteInstaller();
		} catch ( Exception $e ) {
			// no demo import / plugin installation possible
			error_log( 'Toolset Site Installer could not be loaded: ' . $e->getMessage() );
		}

		// Run the integration setup
		/** @noinspection PhpUndefinedClassInspection */

		$integration = WPDDL_Integration_Setup::get_instance();
		$result = $integration->run();

		return $result;
	}

	/**
	 * Initialize Toolset Site Installer
	 */
	private function initializeToolsetSiteInstaller() {
		// toolset installer init file
		$file = dirname( __FILE__ ) . '/library/toolset-site-installer/toolset-site-installer.php';
		if( ! file_exists( $file ) ) {
			throw new Exception( 'Required file not found. ' . $file );
		}

		require_once( $file );
		unset( $file );

		// init toolset site installer
		$toolset_site_installer = new Toolset_Site_Installer();

		if( ! function_exists( 'get_plugins' ) ) {
			// WP_Installer (our plugin) depends on get_plugins
			require_once(ABSPATH . 'wp-admin/includes/plugin.php');
		}

		// assign setting and export dir
		$toolset_site_installer
			->setSettingsFile( dirname( __FILE__ ) . '/public/toolset-site-installer/settings.json' )
			->setExportsDir( dirname( __FILE__ ) . '/public/toolset-site-installer' );

		// if init() works run the installer
		if( $toolset_site_installer->init( 'TT_Controller_Site_Installer' ) ) {
			// we don't want to have a layout for the shop page
			add_action( 'tt_import_finished_layouts', array( $this, 'installer_settings_for_woocommerce' ) );

			$toolset_site_installer
				->getSettings()
				->setRepository( new TT_Repository_OTGS() )
				->setContext( new TT_Context_Plugin() );

			$toolset_site_installer
				->run();
		}
	}

	/**
	 * Check for minimum supported theme version, and deactivate plugin if fails.
	 */
	public function check_theme_version() {
		// We're doing this only in admin screen because we need to display the message.
		if ( is_admin() && - 1 == version_compare( $this->get_theme_version(), '5.1.1' ) ) {
			add_action( 'admin_init', array( $this, 'deactivate_plugin' ) );
			add_action( 'admin_notices', array( $this, 'print_avada_theme_version_mismatch_message' ) );
		}
	}

	public function deactivate_plugin() {
		deactivate_plugins( plugin_basename( __DIR__ . DIRECTORY_SEPARATOR . 'avada-integration.php' ), false, false );
	}


	public function print_avada_theme_version_mismatch_message() {

		printf(
			'<div class="error"><p>%s</p></div>',
			__(
				'Toolset Avada Integration plugin does not support older theme versions. Please update to Avada theme version 5.1.1 (or later) and try again.',
				'ddl-layouts'
			)
		);
	}


	/**
	 * This function is fired after import of layouts (via installer).
	 * We need to adjust some settings to make the integration work with WooCommerce out of the box.
	 */
	public function installer_settings_for_woocommerce() {
		$this->installer_unassign_layout_of_woocommerce_shop_page();
		$this->installer_set_options_woocommerce_views();
	}

	/**
	 * This function will remove the layout from the "Shop" page
	 */
	private function installer_unassign_layout_of_woocommerce_shop_page() {
		if( ! class_exists( 'WPDD_Utils' )
		    || ! method_exists( 'WPDD_Utils', 'remove_layout_assignment_to_post_object' ) ) {
			// abort, dependencies missing
			return;
		}

		$shop_page_id = get_option( 'woocommerce_shop_page_id' );

		if( ! $shop_page_id ) {
			// abort, no shop (no problem, perhaps WC is not installed)
			return;
		}

		// remove layout assignment of shop page
		WPDD_Utils::remove_layout_assignment_to_post_object( $shop_page_id );
	}

	/**
	 * This function will make sure that the WooCommerce Views templates will be used
	 * for single product and products listing page.
	 */
	private function installer_set_options_woocommerce_views() {
		//Save PHP template settings
		if( ! defined ( 'WOOCOMMERCE_VIEWS_PLUGIN_PATH' ) || ! class_exists( 'Class_WooCommerce_Views' ) ) {
			return;
		}

		$wc_views = new Class_WooCommerce_Views();

		// single product
		$template_path = WOOCOMMERCE_VIEWS_PLUGIN_PATH .
		                 DIRECTORY_SEPARATOR . 'templates' .
		                 DIRECTORY_SEPARATOR . 'single-product.php';

		if( file_exists( $template_path ) ) {
			$wc_views->wcviews_save_php_template_settings($template_path);
		}

		// products listing
		$template_path = WOOCOMMERCE_VIEWS_PLUGIN_PATH .
		                 DIRECTORY_SEPARATOR . 'templates' .
		                 DIRECTORY_SEPARATOR . 'archive-product.php';

		if( file_exists( $template_path ) ) {
			$wc_views->wcviews_save_php_archivetemplate_settings($template_path);
		}
	}

	/**
	 * Determine whether the expected theme is active and the integration can begin.
	 *
	 * @return bool
	 */
	protected function is_theme_active() {
		return function_exists( 'Avada' );
	}


	/**
	 * Supported theme name (as would wp_get_theme() return).
	 *
	 * @return string
	 */
	protected function get_theme_name() {
		return 'Avada';
	}

	/**
	 * Supported theme version.
	 *
	 * @return false|string
	 */
	public function get_theme_version() {
		// Always get parent theme version.
		$avada_theme = wp_get_theme( get_template() );

		return $avada_theme->get( 'Version' );
	}
}

WPDDL_Avada_Integration::get_instance();

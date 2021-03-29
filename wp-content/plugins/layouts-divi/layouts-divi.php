<?php
/*
Plugin Name: Toolset Divi Integration
Plugin URI: http://wp-types.com/
Description: Layouts Integration for Theme Divi
Author: OnTheGoSystems
Author URI: http://www.onthegosystems.com
Version: 1.7.2
*/

/**
 * Main plugin class.
 *
 * Checks for Layouts compatibility and ensures the integration begins at the right time.
 *
 */
define('TOOLSET_DIVI_VERSION', '1.7.2');
if( !defined('TOOLSET_INTEGRATION_PLUGIN_THEME_NAME') ){
    define('TOOLSET_INTEGRATION_PLUGIN_THEME_NAME','Divi');
}


class WPDDL_Layouts_Divi_Loader {

	private static $instance = null;

	public static function getInstance() {
		if( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}


	private function __construct() {
		add_action( 'wpddl_theme_integration_support_ready', array( $this, 'begin_loading' ), 10, 2 );
		add_action( 'init', array( $this, 'check_layouts' ) );
	}


	private function __clone() {}

	/**
	 * We need to continue only after the integration support has been loaded and we check the API version matches.
	 *
	 * This action should be fired at some point during the 'init' action.
	 *
	 * @param string $layouts_version
	 * @param int $integration_support_version
	 */
	public function begin_loading(
		/** @noinspection PhpUnusedParameterInspection */ $layouts_version, $integration_support_version )
	{
		$supported_integration_api_version = 1;
		if( version_compare( $layouts_version, '1.4.5' ) !== -1 && $supported_integration_api_version == $integration_support_version ) {
			require_once 'integration-loader.php';

			// We need to manually setup plugin name, since it depends on the main file name.
			$loader = WPDDL_Divi_Integration::get_instance();
			$loader->set_plugin_base_name( plugin_basename( __FILE__ ) );
		} else {
			add_action( 'admin_init', array( $this, 'deactivate_plugin' ) );
			add_action( 'admin_notices', array( $this, 'print_api_version_mismatch_message' ) );
		}
	}


	/**
	 * Check that Layouts is active and fail+deactivate this plugin if not.
	 */
	public function check_layouts() {
		// We're doing this only in admin screen because we need to display the message.
		if( is_admin() && !defined( 'WPDDL_VERSION' ) ) {
			add_action( 'admin_init', array( $this, 'deactivate_plugin' ) );
			add_action( 'admin_notices', array( $this, 'print_layouts_inactive_message' ) );
		}
	}


	public function deactivate_plugin() {
		deactivate_plugins( plugin_basename( __FILE__ ), false, false );
	}


	public function print_layouts_inactive_message() {
		printf( '<div class="error"><p>%s</p></div>', __( 'Toolset Divi Integration plugin requires Layouts to be active.', 'ddl-layouts' ) );
	}


	public function print_api_version_mismatch_message() {
		printf(
			'<div class="error"><p>%s</p></div>',
			__( 'Theme integration plugin does not support older versions of Layouts. Please update to the latest version and try again.', 'ddl-layouts' )
		);
	}

}

WPDDL_Layouts_Divi_Loader::getInstance();
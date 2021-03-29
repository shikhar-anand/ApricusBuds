<?php
/*
Plugin Name: Toolset Genesis Integration
Plugin URI: http://wp-types.com/
Description: Layouts Integration for Theme Genesis
Author: OnTheGoSystems
Author URI: http://www.onthegosystems.com
Version: 1.9.2
*/

if( !defined('TOOLSET_GENESIS_INTEGRATION') ){
    define('TOOLSET_GENESIS_INTEGRATION', '1.9.2');
}
if( !defined('TOOLSET_INTEGRATION_PLUGIN_THEME_NAME') ){
    define('TOOLSET_INTEGRATION_PLUGIN_THEME_NAME','Genesis');
}
/**
 * Main plugin class.
 *
 * Checks for Layouts compatibility and ensures the integration begins at the right time.
 *
 */
class WPDDL_Genesis_Loader {

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
		if( version_compare( $layouts_version, '1.4.5' ) !== -1 &&
			$supported_integration_api_version == $integration_support_version &&
			defined('PARENT_THEME_VERSION') &&
			version_compare( PARENT_THEME_VERSION, '2.2' ) !== -1
			) {
			require_once 'integration-loader.php';

			// We need to manually setup plugin name, since it depends on the main file name.
			$loader = WPDDL_Genesis_Integration::get_instance();
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
		printf( '<div class="error"><p>%s</p></div>', __( 'Toolset Genesis Integration requires Layouts to be active.', 'ddl-layouts' ) );
	}


	public function print_api_version_mismatch_message() {
		printf(
			'<div class="error"><p>%s</p></div>',
			__( 'Theme integration plugin does not support older versions of Layouts and Genesis versions prior to 2.2. Please update to the latest version and try again.', 'ddl-layouts' )
		);
	}

}

WPDDL_Genesis_Loader::getInstance();

/* IF PHP < 5.3 */
if ( !function_exists( 'array_replace_recursive' ) ) {
	function theme_integration_recurse( $array, $array1 ) {
		foreach ($array1 as $key => $value) {
			// create new key in $array, if it is empty or not an array
			if( !isset( $array[$key] ) || ( isset( $array[$key] ) && !is_array( $array[$key] ) ) ) {
				$array[$key] = array();
			}

			// overwrite the value in the base array
			if( is_array( $value ) ) {
				$value = theme_integration_recurse( $array[$key], $value );
			}
			$array[$key] = $value;
		}
		return $array;
	}

	function array_replace_recursive( $array, $array1 ) {
		// handle the arguments, merge one by one
		$args = func_get_args();
		$array = $args[0];

		// abort if $array isn't an array
		if ( !is_array( $array ) )
			return $array;

		for ($i = 1; $i < count($args); $i++) {
			if ( is_array( $args[$i] ) )
				$array = theme_integration_recurse( $array, $args[$i] );
		}

		return $array;
	}
}
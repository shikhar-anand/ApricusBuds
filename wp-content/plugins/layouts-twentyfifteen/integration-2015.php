<?php
/*
Plugin Name: Toolset Twenty Fifteen Integration
Plugin URI: http://wp-types.com/
Description: Layouts Integration for Twenty Fifteen
Author: OnTheGoSystems
Author URI: http://www.onthegosystems.com
Version: 1.4
*/


if( !defined('WPDDL_2015_ABS') ) define('WPDDL_2015_ABS', dirname(__FILE__) );
if( !defined('WPDDL_2015_ABS_PUBLIC') ) define('WPDDL_2015_ABS_PUBLIC', dirname(__FILE__) . '/public' );
if( !defined('WPDDL_2015_ABS_APP') ) define('WPDDL_2015_ABS_APP', dirname( __FILE__ ) . '/application' );
if( !defined('WPDDL_2015_ABS_THEME') ) define('WPDDL_2015_ABS_THEME', dirname( __FILE__ ) . '/application/theme' );
if( !defined('WPDDL_2015_ABS_TPLS') ) define('WPDDL_2015_ABS_TPLS', dirname( __FILE__ ) . '/application/theme/view' );

if( !defined('WPDDL_2015_URI') ) define('WPDDL_2015_URI', plugins_url() );
if( !defined('WPDDL_2015_URI_APP') ) define('WPDDL_2015_URI_APP', plugins_url( basename(WPDDL_2015_ABS_APP), WPDDL_2015_ABS_APP ) );
if( !defined('WPDDL_2015_URI_PUBLIC') ) define('WPDDL_2015_URI_PUBLIC', plugins_url( basename(WPDDL_2015_ABS_PUBLIC), WPDDL_2015_ABS_PUBLIC ) );
if( !defined('WPDDL_2015_URI_TPLS') ) define('WPDDL_2015_URI_TPLS', plugins_url( basename(WPDDL_2015_ABS_TPLS), WPDDL_2015_ABS_TPLS ) );

if( !defined('TOOLSET_INTEGRATION_PLUGIN_THEME_NAME') ){
    define('TOOLSET_INTEGRATION_PLUGIN_THEME_NAME','Twenty Fifteen');
}

/**
 * Main plugin class.
 *
 * Checks for Layouts compatibility and ensures the integration begins at the right time.
 *
 * @class Loads Integration class for 2015 Theme
 */
class WPDDL_2015_Integration_Loader {

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

			$loader = WPDDL_Integration_2015::get_instance();
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
		printf( '<div class="error"><p>%s</p></div>', __( 'Toolset Twenty Fifteen Integration plugin requires Layouts to be active.', 'ddl-layouts' ) );
	}


	public function print_api_version_mismatch_message() {
		printf(
			'<div class="error"><p>%s</p></div>',
			__( 'Theme integration plugin does not support older versions of Layouts. Please update to the latest version and try again.', 'ddl-layouts' )
		);
	}

}

WPDDL_2015_Integration_Loader::getInstance();
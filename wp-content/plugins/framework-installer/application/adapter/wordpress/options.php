<?php
namespace OTGS\Toolset\FrameworkInstaller\Adapter\WordPress;

/**
 * Adapter for WordPress Options related methods.
 */
class Options {
	/**
	 * Wrapper for WP get_option.
	 *
	 * @param string $option option name to get.
	 * @param string|array|bool $default default value.
	 * @return bool|mixed|void
	 */
	public function get_option( $option, $default = false ) {
		return get_option( $option, $default );
	}

	/**
	 * Wrapper for WP update_option.
	 *
	 * @param string $option option name to set.
	 * @param string|array $value value.
	 * @param null|bool $autoload autoload boolean.
	 * @return bool
	 */
	public function update_option( $option, $value, $autoload = null ) {
		return update_option( $option, $value, $autoload );
	}
}

<?php
namespace OTGS\Toolset\FrameworkInstaller\Adapter\WPML;

use OTGS\Toolset\FrameworkInstaller\Adapter\WordPress\Options;

/**
 * Adapter for WPML ATE AMS service related methods
 */
class TM_ATE_AMS {

	const OPTION_WPML_TM_AMS = 'WPML_TM_AMS';
	const OPTION_WPML_SITE_ID_ATE = 'WPML_SITE_ID:ate';

	/**
	 * @var Options options adapter instance.
	 */
	private $wordpress_options;

	/**
	 * @param Options $wordpress_options options adapter instance.
	 */
	public function __construct( $wordpress_options ) {
		$this->wordpress_options = $wordpress_options;
	}

	/**
	 * Checks if the site has ATE credentials.
	 *
	 * @return bool
	 */
	public function it_has_ate_credentials() {
		$ams_data = $this->wordpress_options->get_option( self::OPTION_WPML_TM_AMS, [] );
		$wpml_site_id_ams = $this->wordpress_options->get_option( self::OPTION_WPML_SITE_ID_ATE, null );

		return null !== $wpml_site_id_ams && isset( $ams_data['secret'] ) && isset( $ams_data['shared'] );
	}

	/**
	 * Mark site as a copy in WPML ATE.
	 */
	public function mark_site_as_copy() {
		if ( class_exists( \WPML\TM\ATE\ClonedSites\Report::class ) ) {
			/** @var \WPML\TM\ATE\ClonedSites\Report $ams_cloned_sites_report */
			$ams_cloned_sites_report = \WPML\Container\make( \WPML\TM\ATE\ClonedSites\Report::class );
			$ams_cloned_sites_report->report( \WPML\TM\ATE\ClonedSites\Report::REPORT_TYPE_COPY );
		}
	}

	/**
	 * Returns a new instance of this class.
	 *
	 * @return self
	 */
	public static function build() {
		return new self(
			new Options()
		);
	}
}

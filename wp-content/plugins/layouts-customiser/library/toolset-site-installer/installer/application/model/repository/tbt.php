<?php

/**
 * Class TT_Repository_OTGS_Handler
 * This is a lightweight clone of our OTGS Installer (WP_Installer())
 */
class TT_Repository_TBT extends TT_Repository_Abstract {

	/**
	 * @param $plugin_slug
	 *
	 * @return bool|mixed
	 */
	public function getPluginSrc( $plugin_slug ) {
		// use settings src
		$plugin = $this->getSettings()->getPlugin( $plugin_slug );
		return $plugin->getSrc();
	}

	/**
	 * Use TBT Production / Development / Testing mechanism
	 * @return bool
	 */
	public function useHostAllowedMechanism() {
		return true;
	}
}
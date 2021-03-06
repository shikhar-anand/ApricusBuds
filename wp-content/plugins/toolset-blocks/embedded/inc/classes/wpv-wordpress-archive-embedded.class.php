<?php
/**
 * Represents a single WordPress Archive
 *
 * @since 1.8
 */
class WPV_WordPress_Archive_Embedded extends WPV_View_Base {


    /**
     * See parent class constructor description.
     *
     * @param int|WP_Post $wpa WPA post object or ID.
     */
    public function __construct( $wpa ) {
        parent::__construct( $wpa );
    }


    /**
     * Default postmeta values specific for WPAs.
     *
     * Note that this should contain all postmeta keys that only a WPA can have, but it doesn't (yet).
     *
     * @todo Add missing default values.
     * @todo Add description to default values.
     * @var array
     */
    protected static $postmeta_defaults = array();


    /**
     * Get default postmeta for a WPA.
     *
     * Combine self::$postmeta_defaults with defaults common for Views and WPAs.
     *
     * @return array
     */
    protected function get_postmeta_defaults() {
        $parent_postmeta = parent::get_postmeta_defaults();
        $this_postmeta = WPV_WordPress_Archive_Embedded::$postmeta_defaults;
        return wpv_array_merge_recursive_distinct( $parent_postmeta, $this_postmeta );
    }


    /**
     * Get array of "view query mode" values that could identify a WordPress Archive.
     *
     * This would have been an constant in PHP 5.6.
     * @return array
     * @since 1.11
     */
    public static function get_possible_query_modes() {
        return array( 'archive', 'layouts-loop' );
    }

    /* ************************************************************************* *\
            Custom methods
    \* ************************************************************************* */


    /**
     * Get information about loops that have this WPA assigned as archive template.
     *
     * Take a look at $WPV_view_archive_loop->get_archive_loops() for better understanding of what is being returned.
     *
     * @param string $loop_type Relevant loop type. Possible values are the same as for $WPV_view_archive_loop->get_archive_loops().
     *
     * @return array Array of loop information.
     */
    public function get_assigned_loops( $loop_type = 'all' ) {

        global $WPV_view_archive_loop;
        $loops = $WPV_view_archive_loop->get_archive_loops( $loop_type, true );

        $selected_loops = array();
        foreach( $loops as $loop ) {
            if( $loop['wpa'] == $this->id ) {
                $selected_loops[] = $loop;
            }
        }

        return $selected_loops;
    }



	/**
	 * Get information about loop taxonomy terms that have this WPA assigned as archive template.
	 *
	 * @param string $loop_type Relevant loop type. Possible values are the same as for $WPV_view_archive_loop->get_archive_loops().
	 *
	 * @return array Array of loop information.
	 */
	public function get_assigned_loop_options( $loop_type = 'all' ) {

		global $WPV_view_archive_loop;
		$loops = $WPV_view_archive_loop->get_archive_loops( $loop_type, true );

		$selected_loops = array();
		foreach ( $loops as $loop ) {
			if ( isset( $loop['wpa_options'] ) && ! empty( $loop['wpa_options'] ) ) {
				if ( isset( $loop['wpa_options'][ $this->id ] ) && intval( $loop['wpa'] ) !== $this->id ) {
					$loop['wpa_options'] = $loop['wpa_options'][ $this->id ];
				} else {
					$loop['wpa_options'] = [];
				}
				$selected_loops[] = $loop;
			}
		}

		return $selected_loops;
	}

	/**
	 * Determine if this is a WPA and not a View.
	 * @return bool
	 * @since 1.12
	 */
    public function is_a_wordpress_archive() {
        return true;
    }
}

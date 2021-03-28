<?php
/**
 * Itinerary Pricing Options Template
 *
 * This template can be overridden by copying it to yourtheme/wp-travel/content-pricing-options.php.
 *
 * HOWEVER, on occasion wp-travel will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see         http://docs.wensolutions.com/document/template-structure/
 * @author      WenSolutions
 * @package     wp-travel/Templates
 * @since       1.1.5
 */
global $post;
global $wp_travel_itinerary;

if ( ! class_exists( 'WP_Travel_FW_Form' ) ) {
	include_once WP_TRAVEL_ABSPATH . 'inc/framework/form/class.form.php';
}

$trip_id    = $post->ID;
$trip_id    = apply_filters( 'wp_travel_booking_tab_custom_trip_id', $trip_id );
$settings   = wptravel_get_settings();
$form       = new WP_Travel_FW_Form();
$form_field = new WP_Travel_FW_Field();

$fixed_departure = get_post_meta( $trip_id, 'wp_travel_fixed_departure', true );

$enable_pricing_options         = wptravel_is_enable_pricing_options( $trip_id );
$enable_multiple_fixed_departue = get_post_meta( $trip_id, 'wp_travel_enable_multiple_fixed_departue', true );

// $enable_checkout = apply_filters( 'wp_travel_enable_checkout', false ); // commented since WP Travel  4.4.0 need to remove in further version
// $force_checkout  = apply_filters( 'wp_travel_is_force_checkout_enabled', false ); // commented since WP Travel  4.4.0 need to remove in further version

$pricing_option_type = wptravel_get_pricing_option_type( $trip_id );

$wrapper_id = isset( $tab_key ) ? $tab_key . '-booking-form' : 'booking-form'; // temp fixes.
if ( 'yes' === $settings['wp_travel_switch_to_react'] ) {
	$wrapper_id = isset( $tab_key ) ? $tab_key  : 'booking';
} ?>

<div id="<?php echo esc_attr( $wrapper_id ); ?>" class="tab-list-content">
	<?php
	// if ( ( $enable_checkout ) || $force_checkout ) :
		// Set Default WP Travel options list as it is.
		$default_pricing_options = array( 'single-price', 'multiple-price' );
		if ( in_array( $pricing_option_type, $default_pricing_options ) ) {

			$trip_pricing_options_data = get_post_meta( $trip_id, 'wp_travel_pricing_options', true );
			$trip_multiple_dates_data  = get_post_meta( $trip_id, 'wp_travel_multiple_trip_dates', true );

			if ( $enable_pricing_options && is_array( $trip_pricing_options_data ) && count( $trip_pricing_options_data ) !== 0 ) :

				$list_type = wptravel_get_pricing_option_listing_type( $settings );

				if ( 'by-pricing-option' === $list_type ) {
					// Default pricing options template.
					wptravel_do_deprecated_action( 'wp_travel_booking_princing_options_list', array( $trip_pricing_options_data ), '4.4.0', 'wp_travel_booking_default_princing_list' ); 
					do_action( 'wp_travel_booking_default_princing_list', $trip_id );

				} else {
					if ( 'yes' === $enable_multiple_fixed_departue && 'yes' === $fixed_departure && ( ! empty( $trip_multiple_dates_data ) && is_array( $trip_multiple_dates_data ) ) ) {
						// Date listing template.
						wptravel_do_deprecated_action( 'wp_travel_booking_departure_date_list', array( $trip_multiple_dates_data ), '4.4.0', 'wp_travel_booking_fixed_departure_list' ); 
						do_action( 'wp_travel_booking_fixed_departure_list', $trip_id );

					} else {
						wptravel_do_deprecated_action( 'wp_travel_booking_princing_options_list', array( $trip_pricing_options_data ), '4.4.0', 'wp_travel_booking_default_princing_list' ); 
						do_action( 'wp_travel_booking_default_princing_list', $trip_id );
					}
				}
			else :
				// Default pricing options template with trip id.
				wptravel_do_deprecated_action( 'wp_travel_booking_princing_options_list', array( (int) $trip_id ), '4.4.0', 'wp_travel_booking_default_princing_list' ); 
				do_action( 'wp_travel_booking_default_princing_list', (int) $trip_id );
				?>
			<?php endif;
		} else {
			do_action( "wp_travel_{$pricing_option_type}_options_list", $trip_id );
		}
		?>
	<?php //else : ?>
		<?php //echo wp_travel_get_booking_form(); // commented since WP Travel  4.4.0 need to remove in further version ?>
	<?php //endif; ?>
</div>

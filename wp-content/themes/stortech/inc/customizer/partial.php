<?php
/**
* Partial functions
*
* @package Theme Palace
* @subpackage Stortech
* @since Stortech 1.0.0
*/

if ( ! function_exists( 'stortech_copyright_text_partial' ) ) :
    // popular destination title
    function stortech_copyright_text_partial() {
        $options = stortech_get_theme_options();
        return esc_html( $options['copyright_text'] );
    }
endif;

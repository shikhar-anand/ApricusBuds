<?php
/**
 * Original code from Avada theme's header.php
 */

$c_pageID  = Avada()->fusion_library->get_page_id();

if ( has_action( 'avada_override_current_page_title_bar' ) ) {
	do_action('avada_override_current_page_title_bar', $c_pageID);
} else {
	avada_current_page_title_bar( $c_pageID );
}

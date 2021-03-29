<?php
/**
 * View for Secondary Menu Cell
 */

$mobile_menu_wrapper = '';
if ( has_nav_menu( 'top_navigation' ) ) {
	$mobile_menu_wrapper = '<div class="fusion-mobile-nav-holder"></div>';
}
echo  avada_secondary_nav() . $mobile_menu_wrapper;

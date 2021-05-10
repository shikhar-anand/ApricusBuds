<?php

namespace HQWidgetsForElementor\Classes;

defined('ABSPATH') || exit;

/*
 * Adds menu data support for HC Off-canvas Nav
 */

$hc_nav_menu_walker;

class HC_Walker_Nav_Menu extends \Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = array()) {
        global $hc_nav_menu_walker;
        $hc_nav_menu_walker->start_lvl($output, $depth, $args);
    }

    public function end_lvl(&$output, $depth = 0, $args = array()) {
        global $hc_nav_menu_walker;
        $hc_nav_menu_walker->end_lvl($output, $depth, $args);
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $hc_nav_menu_walker;

        $item_output = '';

        $hc_nav_menu_walker->start_el($item_output, $item, $depth, $args, $id);

        if ($item->current_item_parent) {
            $item_output = preg_replace('/<li/', '<li data-nav-active', $item_output, 1);
        }

        if ($item->current_item_ancestor) {
            $item_output = preg_replace('/<li/', '<li data-nav-highlight', $item_output, 1);
        }
        
        if ($item->current) {
            $item_output = preg_replace('/<li/', '<li data-nav-highlight', $item_output, 1);
        }

        $output .= $item_output;
    }

    public function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $hc_nav_menu_walker;
        $hc_nav_menu_walker->end_el($output, $item, $depth, $args, $id);
    }

}

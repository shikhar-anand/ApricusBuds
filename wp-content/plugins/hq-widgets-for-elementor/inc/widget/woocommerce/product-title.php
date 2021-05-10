<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use HQWidgetsForElementor\Widget\Theme\Post_Title;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Product_Title extends Post_Title {

    public function get_name() {
        return 'hq-woocommerce-product-title';
    }

    public function get_title() {
        return __('Woo Product Title', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-transform-text';
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'title', 'heading', 'product'];
    }
}

<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use HQWidgetsForElementor\Widget\Products_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;

abstract class Product_Upsells extends Products_Base {

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    protected function _register_controls() {

        $this->register_test_post_item_section_controls([
            'post_type' => 'product'
        ]);

        $this->register_product_layout_section_controls();

        $this->start_controls_section(
                'section_upsells_content',
                [
                    'label' => __('Upsells', 'hq-widgets-for-elementor'),
                ]
        );

        $this->register_query_posts_per_page_controls();

        $this->register_query_order_section_controls();

        $this->end_controls_section();
        
        // Nothing Found
        $this->register_nothing_found_section_controls();
    }

    protected function get_upsells($settings) {
        global $product;

        if (Plugin::instance()->editor->is_edit_mode()) {
            // Prepare test item for editor mode
            \HQLib\Utils::editor_switch_to_post($settings['test_post_item']);
            $product = wc_get_product($settings['test_post_item']);
        } else {
            $product = wc_get_product();
        }
       
        if (!$product) {
            return;
        }
        
        $args = [
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
        ];

        if (!empty($settings['posts_per_page'])) {
            $args['posts_per_page'] = $settings['posts_per_page'];
        }

        // Handle the legacy filter which controlled posts per page etc.
        $args = apply_filters(
                'woocommerce_upsell_display_args',
                $args
        );
        wc_set_loop_prop('name', 'up-sells');

        $args['orderby'] = apply_filters('woocommerce_upsells_orderby', $args['orderby']);
        $args['posts_per_page'] = apply_filters('woocommerce_upsells_total', $args['posts_per_page']);
        
        // Get visible upsells then sort them at random, then limit result set.
        $upsells = wc_products_array_orderby(array_filter(array_map('wc_get_product', $product->get_upsell_ids()), 'wc_products_array_filter_visible'), $args['orderby'], $args['order']);
        
        $upsells = $args['posts_per_page'] > 0 ? array_slice($upsells, 0, $args['posts_per_page']) : $upsells;

        // Rollback to the previous global post
        \HQLib\Utils::editor_restore_to_current_post();

        return $upsells;

        foreach ($upsells as $upsell) {
            $post_object = get_post($upsell->get_id());
            setup_postdata($GLOBALS['post'] = & $post_object);
            wc_get_template_part('content', 'product');
        }
    }

}

<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use HQWidgetsForElementor\Widget\Products_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;

abstract class Product_Related_Products extends Products_Base {

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    protected function _register_controls() {

        $this->register_test_post_item_section_controls([
            'post_type' => 'product'
        ]);
        
        $this->register_product_layout_section_controls();

        $this->start_controls_section(
                'section_related_products_content',
                [
                    'label' => __('Related Products', 'hq-widgets-for-elementor'),
                ]
        );

        $this->register_query_posts_per_page_controls();

        $this->register_query_order_section_controls();

        $this->end_controls_section();
    }

    protected function get_related_products($settings) {

        // Prepare test item for editor mode
        if (Plugin::instance()->editor->is_edit_mode()) {
            if (!$settings['test_post_item']) {
                ?>
                <div class="elementor-alert elementor-alert-info" role="alert">
                    <span class="elementor-alert-title">
                        <?php esc_html_e('Please select Test Item', 'hq-widgets-for-elementor'); ?>
                    </span>
                    <span class="elementor-alert-description">
                        <?php esc_html_e('Test Item is used only in edit mode for better customization. On live page it will be ignored.', 'hq-widgets-for-elementor'); ?>
                    </span>
                </div>
                <?php
                return;
            }
            Plugin::instance()->db->switch_to_post($settings['test_post_item']);
        }

        global $product;

        $product = wc_get_product();

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

        // Get visible related products then sort them at random.
        $related_products = array_filter(array_map('wc_get_product', wc_get_related_products($product->get_id(), $args['posts_per_page'], $product->get_upsell_ids())), 'wc_products_array_filter_visible');

        // Handle orderby.
        $related_products = wc_products_array_orderby($related_products, $args['orderby'], $args['order']);


        // Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        }

        return $related_products;
    }

}

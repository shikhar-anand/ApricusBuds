<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use HQLib\Utils;
use HQWidgetsForElementor\Widget\Woocommerce\Product_Related_Products;

class Product_Related_Products_Grid extends Product_Related_Products {

    public function get_name() {
        return 'hq-woocommerce-product-related-products-grid';
    }

    public function get_title() {
        return __('Woo Product Related Products Grid', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-wireframe-list-mix';
    }

    public function get_script_depends() {
        return $this->get_script_depends_grid();
    }

    public function get_style_depends() {
        return ['hqt-widgets'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'related products', 'similar', 'product', 'grid'];
    }

    protected function _register_controls() {
        if (!defined('WC_VERSION')) {
            $this->start_controls_section('section_plugin_missing', [
                'label' => __('Woocommerce', 'hq-widgets-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]);

            $this->add_control('plugin_alert', [
                'raw' => '<p>' . __('WooCommerce plugin is not installed.', 'hq-widgets-for-elementor') . '</p>' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('plugin-install.php?s=woocommerce&tab=search&type=term')), __('Install WooCommerce.', 'hq-widgets-for-elementor')),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]);

            $this->end_controls_section();

            return;
        }

        // Related Products Controls
        parent::_register_controls();

        // Grid Controls
        $this->register_grid_controls();
    }

    public function render() {
        if (!defined('WC_VERSION')) {
            Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }
        
        $settings = $this->get_settings();

        $related_products = $this->get_related_products($settings);

        if ($related_products) {

            $settings['wrapper_class'] = 'products';

            $this->start_grid($settings);

            foreach ($related_products as $related_product) {
                $post_object = get_post($related_product->get_id());
                setup_postdata($GLOBALS['post'] = & $post_object);
                ?> 
                <div id="product-<?php the_ID(); ?>" <?php post_class(); ?>> 
                    <?php
                    Utils::load_elementor_template_with_help($settings['product_layout_template'], 'Content Tab > Layout > Product Layout');
                    ?>
                </div>
                <?php
            }

            $this->end_grid();
        } else {
            $this->render_no_results();
        }

        wp_reset_query();
    }

}

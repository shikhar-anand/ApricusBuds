<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use HQLib\Utils;
use HQWidgetsForElementor\Widget\Woocommerce\Product_Related_Products;

class Product_Related_Products_Slider extends Product_Related_Products {

    public function get_name() {
        return 'hq-woocommerce-product-related-products-slider';
    }

    public function get_title() {
        return __('Woo Product Related Products Slider', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-slider-2';
    }

    public function get_script_depends() {
        return $this->get_script_depends_slider();
    }

    public function get_style_depends() {
        return $this->get_style_depends_slider();
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'related products', 'similar', 'product', 'slider'];
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

        // Slide Controls
        $this->register_slider_controls();
    }

    public function render() {
        if (!defined('WC_VERSION')) {
            Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        $settings = $this->get_settings();

        $related_products = $this->get_related_products($settings);

        if ($related_products) {

            $this->start_slider($settings);

            foreach ($related_products as $related_product) {
                $post_object = get_post($related_product->get_id());
                setup_postdata($GLOBALS['post'] = & $post_object);
                ?> 
                <div class="swiper-slide">
                    <div id="product-<?php the_ID(); ?>"> 
                        <?php
                        Utils::load_elementor_template_with_help($settings['product_layout_template'], 'Content Tab > Layout > Product Layout');
                        ?>
                    </div>
                </div>
                <?php
            }

            $this->end_slider($settings);
        }

        wp_reset_query();
    }

}

<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use HQLib\Utils;
use HQWidgetsForElementor\Widget\Woocommerce\Product_Upsells;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Product_Upsells_Slider extends Product_Upsells {

    public function get_name() {
        return 'hq-woocommerce-product-upsells-slider';
    }

    public function get_title() {
        return __('Woo Product Upsells Slider', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-product-upsell-slider';
    }

    public function get_script_depends() {
        return $this->get_script_depends_slider();
    }

    public function get_style_depends() {
        return $this->get_style_depends_slider();
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'upsell', 'product', 'slider'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
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

        // Upsell Products Controls
        parent::_register_controls();

        // Slider Controls
        $this->register_slider_controls();
    }

    public function render() {
        if (!defined('WC_VERSION')) {
            Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        $settings = $this->get_settings();

        $upsells = $this->get_upsells($settings);

        if ($upsells) {

            $this->start_slider($settings);

            foreach ($upsells as $upsell) {
                $post_object = get_post($upsell->get_id());
                setup_postdata($GLOBALS['post'] = & $post_object);
                ?> 
                <div class="swiper-slide">
                    <div id="product-<?php the_ID(); ?>" <?php post_class(); ?>> 
                        <?php
                        Utils::load_elementor_template_with_help($settings['product_layout_template'], 'Content Tab > Layout > Product Layout');
                        ?>
                    </div>
                </div>
                <?php
            }

            $this->end_slider($settings);
        } else {
            $this->render_no_results();
        }

        wp_reset_query();
    }

}

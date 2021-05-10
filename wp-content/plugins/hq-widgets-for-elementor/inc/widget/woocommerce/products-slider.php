<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use HQWidgetsForElementor\Widget\Woocommerce\Products;

class Products_Slider extends Products {

    public function get_name() {
        return 'hq-woocommerce-products-slider';
    }

    public function get_title() {
        return __('Woo Products Slider', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-slider';
    }

    public function get_script_depends() {
        return $this->get_script_depends_slider();
    }

    public function get_style_depends() {
        return $this->get_style_depends_slider();
    }

    public function get_keywords() {
        return ['products', 'woocommerce', 'slider', 'carousel'];
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

        // Products Controls
        parent::_register_controls();

        // Slide Controls
        $this->register_slider_controls();
    }

    public function render() {
        if (!defined('WC_VERSION')) {
            \HQLib\Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        parent::render_slider();
    }

}

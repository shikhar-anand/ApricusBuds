<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use HQWidgetsForElementor\Widget\Theme\Post_Content;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;
use const HQWidgetsForElementor\VERSION;

class Product_Content extends Post_Content {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_style('hq-woocommerce-product-content', PLUGIN_URL . 'assets/widgets/woocommerce/product-content/style.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-woocommerce-product-content';
    }

    public function get_title() {
        return __('Woo Product Content', 'hq-widgets-for-elementor');
    }

    public function get_style_depends() {
        return ['hq-woocommerce-product-content'];
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-product-content';
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    public function get_keywords() {
        return ['content', 'post', 'product'];
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

        $this->register_test_post_item_section_controls(['post_type' => 'product']);
        parent::register_controls();
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            \HQLib\Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        parent::render();
    }

}

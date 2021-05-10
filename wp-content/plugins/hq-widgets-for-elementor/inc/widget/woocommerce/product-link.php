<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Button;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Product_Link extends Widget_Button {

    public function get_name() {
        return 'hq-woocommerce-product-link';
    }

    public function get_title() {
        return __('Woo Product Link', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-add';
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    public function get_keywords() {
        return ['link', 'product', 'button', 'more', 'details', 'woocommerce'];
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

        parent::_register_controls();

        $this->update_control(
                'text', [
            'default' => __('Details', 'hq-widgets-for-elementor'),
            'placeholder' => __('Details', 'hq-widgets-for-elementor'),
                ]
        );

        $this->remove_control('link');
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            \HQLib\Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'elementor-button-wrapper');

        $this->add_render_attribute('button', 'href', get_the_permalink());
        $this->add_render_attribute('button', 'class', ['elementor-button', 'elementor-button-link']);
        $this->add_render_attribute('button', 'role', 'button');

        if (!empty($settings['size'])) {
            $this->add_render_attribute('button', 'class', 'elementor-size-' . $settings['size']);
        }

        if (!empty($settings['button_css_id'])) {
            $this->add_render_attribute('button', 'id', $settings['button_css_id']);
        }

        if ($settings['hover_animation']) {
            $this->add_render_attribute('button', 'class', 'elementor-animation-' . $settings['hover_animation']);
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <a <?php echo $this->get_render_attribute_string('button'); ?>>
                <?php $this->render_text(); ?>
            </a>
        </div>
        <?php
    }

    protected function _content_template() {
        
    }

}

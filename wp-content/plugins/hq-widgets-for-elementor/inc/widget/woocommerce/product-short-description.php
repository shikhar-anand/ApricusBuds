<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use HQWidgetsForElementor\Widget\Posts_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Product_Short_Description extends Posts_Base {

    public function get_name() {
        return 'hq-woocommerce-product-short-description';
    }

    public function get_title() {
        return __('Woo Product Short Description', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-text-image';
    }

    public function get_keywords() {
        return ['woo', 'woocommerce', 'shop', 'store', 'text', 'description', 'product'];
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

        $args = [
            'post_type' => 'product'
        ];
        $this->register_test_post_item_section_controls($args);

        $this->start_controls_section(
                'section_product_description_style', [
            'label' => __('Style', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'text_align', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-right',
                ],
                'justify' => [
                    'title' => __('Justified', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-justify',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}}' => 'text-align: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .woocommerce-product-details__short-description' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'text_typography',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .woocommerce-product-details__short-description',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            \HQLib\Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        $settings = $this->get_settings();

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

        if (!empty($GLOBALS['post'])) {
            wc_get_template('single-product/short-description.php');
        }

        //Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        }
    }

    public function render_plain_content() {
        
    }

}

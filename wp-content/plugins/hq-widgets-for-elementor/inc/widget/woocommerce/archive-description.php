<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Archive_Description extends Widget_Base {

    public function get_name() {
        return 'hq-woocommerce-archive-description';
    }

    public function get_title() {
        return __('Woo Archive Description', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-quill';
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'text', 'description', 'category', 'product', 'archive'];
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

        $this->start_controls_section(
                'section_product_description_style',
                [
                    'label' => __('Style', 'hq-widgets-for-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'wc_style_warning',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => __('The style of this widget is often affected by your theme and plugins. If you experience any such issue, try to switch to a basic theme and deactivate related plugins.', 'hq-widgets-for-elementor'),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
        );

        $this->add_responsive_control(
                'text_align',
                [
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
                'text_color',
                [
                    'label' => __('Text Color', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .woocommerce-product-details__short-description' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'text_typography',
                    'label' => __('Typography', 'hq-widgets-for-elementor'),
                    'selector' => '.woocommerce {{WRAPPER}} .term-description',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            \HQLib\Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        do_action('woocommerce_archive_description');
    }

    public function render_plain_content() {
        
    }

}

<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Widget_Base;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class Notices extends Widget_Base {

    public function get_name() {
        return 'hq-woocommerce-notices';
    }

    public function get_title() {
        return __('Woo Notices', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-warning';
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'notices'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
                'section_style_notices', [
            'label' => 'Notices',
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'notices_typography',
            'selector' => '{{WRAPPER}} .woocommerce-error, {{WRAPPER}} .woocommerce-info, {{WRAPPER}} .woocommerce-message',
                ]
        );

        $this->add_responsive_control('notices_gap', [
            'label' => __('Gap', 'marmot-enhancer-pro'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .woocommerce-error, {{WRAPPER}} .woocommerce-info, {{WRAPPER}} .woocommerce-message' => 'margin: {{SIZE}}{{UNIT}} 0',
            ],
        ]);

        $this->start_controls_tabs('tabs_notices');

        $this->start_controls_tab('error_tab', [
            'label' => __('Error', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('error_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .woocommerce-error' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('error_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .woocommerce-error' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'error_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .woocommerce-error',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('message_tab', [
            'label' => __('Success', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('message_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .woocommerce-message' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('message_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .woocommerce-message' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'message_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .woocommerce-message',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('info_tab', [
            'label' => __('Info', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('info_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .woocommerce-info' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('info_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .woocommerce-info' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'info_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .woocommerce-info',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('notices_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .woocommerce-error, {{WRAPPER}} .woocommerce-info, {{WRAPPER}} .woocommerce-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]);

        $this->add_responsive_control('notices_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .woocommerce-error, {{WRAPPER}} .woocommerce-info, {{WRAPPER}} .woocommerce-message' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'notices_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .woocommerce-error, {{WRAPPER}} .woocommerce-info, {{WRAPPER}} .woocommerce-message',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            \HQLib\Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        if (WC()->session) {
            ?>
            <div class="hq-woo-notices">
                <?php
                if (Plugin::instance()->editor->is_edit_mode()) {
                    wc_add_notice(sprintf('<a href="#" class="button wc-forward">%s</a> %s', esc_html__('Button', 'hq-widgets-for-elementor'), esc_html__('This is example SUCCESS notice!', 'hq-widgets-for-elementor')));
                    wc_add_notice('This is example ERROR notice!', 'error');
                    wc_add_notice('This is example INFO notice!', 'notice');
                }
                woocommerce_output_all_notices();
                ?>
            </div>
            <?php
        }
    }

}

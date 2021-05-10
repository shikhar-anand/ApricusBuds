<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use HQWidgetsForElementor\Widget\Posts_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Product_Stock extends Posts_Base {

    public function get_name() {
        return 'hq-woocommerce-product-stock';
    }

    public function get_title() {
        return __('Woo Product Stock', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-vote';
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'stock', 'quantity', 'product'];
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

        $this->register_test_post_item_section_controls(['post_type' => 'product']);

        $this->start_controls_section('section_content_style', [
            'label' => __('Content', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => 'center',
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}} .stock-wrapper' => 'text-align: {{VALUE}}',
                '{{WRAPPER}} .stock' => 'display: inline-block',
            ],
        ]);

        $this->add_responsive_control('padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .stock' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .stock' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .stock',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_availability_style', [
            'label' => __('Availability', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('heading_general_styles', [
            'label' => __('General', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'general_typography',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .stock',
        ]);

        $this->add_control('general_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('general_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('general_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock' => 'border-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('heading_in_stock_styles', [
            'label' => __('In Stock', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'instock_text_typography',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .stock.in-stock',
        ]);

        $this->add_control('instock_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock.in-stock' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('instock_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock.in-stock' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('instock_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock.in-stock' => 'border-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('heading_out_of_stock_styles', [
            'label' => __('Out of Stock', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'oostock_text_typography',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .stock.out-of-stock',
        ]);

        $this->add_control('oostock_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock.out-of-stock' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('oostock_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock.out-of-stock' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('oostock_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock.out-of-stock' => 'border-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('heading_backorder_styles', [
            'label' => __('Available on Backorder', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'backorder_text_typography',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .stock.available-on-backorder',
        ]);

        $this->add_control('backorder_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock.available-on-backorder' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('backorder_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock.available-on-backorder' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('backorder_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stock.available-on-backorder' => 'border-color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            \HQLib\Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        $settings = $this->get_settings();

        global $product;
        $product = wc_get_product();

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

            $product = wc_get_product($settings['test_post_item']);
        }

        if (empty($product)) {
            return;
        }
        $this->add_render_attribute('wrapper', 'class', 'stock-wrapper');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <?php
            echo wc_get_stock_html($product);
            ?>
        </div>
        <?php
        // Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        }
    }

    public function render_plain_content() {
        
    }

}

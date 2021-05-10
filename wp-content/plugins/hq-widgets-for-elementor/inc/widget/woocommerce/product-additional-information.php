<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use HQWidgetsForElementor\Widget\Posts_Base;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class Product_Additional_Information extends Posts_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-woocommerce-product-additional-information', PLUGIN_URL . 'assets/widgets/woocommerce/product-additional-information/style.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-woocommerce-product-additional-information';
    }

    public function get_title() {
        return __('Woo Product Additional Information', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-product-additional-information';
    }

    public function get_style_depends() {
        return ['hq-woocommerce-product-additional-information'];
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

        $this->start_controls_section('section_heading_content', [
            'label' => __('Heading', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control(
                'show_heading', [
            'label' => __('Heading', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'render_type' => 'template',
            'return_value' => 'yes',
            'default' => 'yes',
            'prefix_class' => 'elementor-show-heading-',
                ]
        );

        $this->add_control(
                'heading_text', [
            'label' => __('Text', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Additional information', 'hq-widgets-for-elementor'),
            'placeholder' => __('Additional information', 'hq-widgets-for-elementor'),
            'condition' => [
                'show_heading!' => '',
            ],
                ]
        );

        $this->add_responsive_control(
                'heading_alignment', [
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
            ],
            'selectors' => [
                '{{WRAPPER}} h2' => 'text-align: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section('section_additional_info_heading_style', [
            'label' => __('Heading', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_heading!' => '',
            ],
        ]);

        $this->add_control(
                'heading_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} h2' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'heading_typography',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} h2',
                ]
        );
        
        $this->add_control(
                'heading_gap', [
            'label' => __('Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'default' => [
                'size' => 15,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} h2' => 'margin-bottom: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section('section_additional_info_content', [
            'label' => __('Additional Information', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control(
                'heading_attributes_label', [
            'label' => __('Attributes Label', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'attributes_label_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} table.shop_attributes th' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'attributes_label_typography',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} table.shop_attributes th',
                ]
        );

        $this->add_control(
                'heading_attributes_content', [
            'label' => __('Attributes Content', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'attributes_content_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} table.shop_attributes td' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'attributes_content_typography',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} table.shop_attributes td',
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

        add_filter('woocommerce_product_additional_information_heading', [$this, 'hq_product_additional_information_heading'], 20);
        wc_get_template('single-product/tabs/additional-information.php');

        // Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        }
    }

    public function hq_product_additional_information_heading($heading) {
        $settings = $this->get_settings();
        if (empty($settings['show_heading'])) {
            $heading = '';
        } else {
            $heading = __($settings['heading_text'], 'hq-widgets-for-elementor');
        }

        return $heading;
    }

    public function render_plain_content() {
        
    }

}

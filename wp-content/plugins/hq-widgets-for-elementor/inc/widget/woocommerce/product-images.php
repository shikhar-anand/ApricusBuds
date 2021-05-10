<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use HQWidgetsForElementor\Widget\Posts_Base;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class Product_Images extends Posts_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-woocommerce-product-images', PLUGIN_URL . 'assets/widgets/woocommerce/product-images/style.css', ['elementor-icons-fa-solid'], VERSION);
        if (Plugin::instance()->editor->is_edit_mode() || Plugin::instance()->preview->is_preview_mode()) {
            wp_register_script('hq-woocommerce-product-images', PLUGIN_URL . 'assets/widgets/woocommerce/product-images/script.js', ['elementor-frontend'], VERSION, true);
        }
    }

    public function get_name() {
        return 'hq-woocommerce-product-images';
    }

    public function get_title() {
        return __('Woo Product Images', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-wireframe-featured';
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'image', 'product', 'gallery', 'lightbox'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    public function get_style_depends() {
        return ['hq-woocommerce-product-images', 'photoswipe', 'photoswipe-default-skin', 'woocommerce_prettyPhoto_css'];
    }

    public function get_script_depends() {
        if (Plugin::instance()->editor->is_edit_mode() || Plugin::instance()->preview->is_preview_mode()) {
            return ['hq-woocommerce-product-images', 'zoom', 'flexslider', 'photoswipe-ui-default', 'photoswipe-default-skin'];
        }
        return [];
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
                'section_product_gallery', [
            'label' => __('Gallery', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control('thumbnails_columns', [
            'label' => __('Thumbnails Layout', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => '4',
            'options' => [
                '3' => __('3 Columns', 'hq-widgets-for-elementor'),
                '4' => __('4 Columns', 'hq-widgets-for-elementor'),
                '5' => __('5 Columns', 'hq-widgets-for-elementor'),
            ],
            'prefix_class' => 'elementor-product-gallery__columns-',
                ]
        );

        $this->add_control(
                'sale_flash', [
            'label' => __('Sale Flash', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'render_type' => 'template',
            'return_value' => 'yes',
            'default' => 'yes',
            'prefix_class' => '',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_product_gallery_style', [
            'label' => __('Image', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'wc_style_warning', [
            'type' => Controls_Manager::RAW_HTML,
            'raw' => __('The style of this widget is often affected by your theme and plugins. If you experience any such issue, try to switch to a basic theme and deactivate related plugins.', 'hq-widgets-for-elementor'),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'image_border',
            'selector' => '{{WRAPPER}} .flex-viewport, {{WRAPPER}} .woocommerce-product-gallery > .woocommerce-product-gallery__wrapper',
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'image_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .flex-viewport, {{WRAPPER}} .woocommerce-product-gallery > .woocommerce-product-gallery__wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'image_box_shadow',
            'selector' => '{{WRAPPER}} .flex-viewport, {{WRAPPER}} .woocommerce-product-gallery > .woocommerce-product-gallery__wrapper',
            'fields_options' => [
                'box_shadow_type' => [
                    'separator' => 'default',
                ],
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_product_gallery_thumbnails', [
            'label' => __('Thumbnails', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );
        
        $this->add_control(
                'spacing', [
            'label' => __('Offset', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .flex-viewport:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'thumbs_border',
            'selector' => '{{WRAPPER}} .flex-control-thumbs img',
                ]
        );

        $this->add_responsive_control(
                'thumbs_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .flex-control-thumbs img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'spacing_thumbs', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .flex-control-thumbs li' => 'padding-right: calc({{SIZE}}{{UNIT}} / 2); padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .flex-control-thumbs' => 'margin-right: calc(-{{SIZE}}{{UNIT}} / 2); margin-left: calc(-{{SIZE}}{{UNIT}} / 2)',
            ],
                ]
        );
        
        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'thumbs_box_shadow',
            'selector' => '{{WRAPPER}} .flex-control-thumbs li img',
            'fields_options' => [
                'box_shadow_type' => [
                    'separator' => 'default',
                ],
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_sale_flash', [
            'label' => __('Sale Flash', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'sale_flash' => 'yes'
            ]
                ]
        );

        $this->add_control(
                'sale_flash_spacing_top', [
            'label' => __('Top Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => -10,
                    'max' => 10,
                    'step' => 0.1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} span.onsale' => 'top: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'sale_flash_spacing_left', [
            'label' => __('Left Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => -10,
                    'max' => 10,
                    'step' => 0.1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} span.onsale' => 'left: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'sale_flash_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} span.onsale' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'sale_flash_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'alpha' => false,
            'selectors' => [
                '{{WRAPPER}} span.onsale' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'sale_flash_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'sale_flash_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'sale_flash_border',
            'selector' => '{{WRAPPER}} span.onsale',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_gallery_trigger', [
            'label' => __('Gallery Trigger', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'sale_flash' => 'yes'
            ]
                ]
        );

        $this->add_control(
                'gallery_trigger_spacing_top', [
            'label' => __('Top Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => -10,
                    'max' => 10,
                    'step' => 0.1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .woocommerce-product-gallery__trigger' => 'top: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'gallery_trigger_spacing_left', [
            'label' => __('Right Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => -10,
                    'max' => 10,
                    'step' => 0.1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .woocommerce-product-gallery__trigger' => 'right: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'galelry_trigger_size', [
            'label' => __('Trigger Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .woocommerce-product-gallery__trigger' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'galelry_trigger_icon_size', [
            'label' => __('Icon Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .woocommerce-product-gallery__trigger:after' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'gallery_trigger_color', [
            'label' => __('Icon Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .woocommerce-product-gallery__trigger:after' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'gallery_trigger_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'alpha' => false,
            'selectors' => [
                '{{WRAPPER}} .woocommerce-product-gallery__trigger:before' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'gallery_trigger_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .woocommerce-product-gallery__trigger:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'gallery_trigger_border',
            'selector' => '{{WRAPPER}} .woocommerce-product-gallery__trigger:before',
                ]
        );

        $this->end_controls_section();
    }

    public function render() {
        if (!defined('WC_VERSION')) {
            \HQLib\Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }
        
        $settings = $this->get_settings_for_display();

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

        if (!$product) {
            return;
        }

        if ('yes' === $settings['sale_flash']) {
            wc_get_template('loop/sale-flash.php');
        }
        wc_get_template('single-product/product-image.php');
    }

}

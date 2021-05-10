<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Button;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use HQLib\Utils;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class Product_Add_To_Cart extends Widget_Button {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_script('hq-woocommerce-product-add-to-cart', PLUGIN_URL . 'assets/widgets/woocommerce/product-add-to-cart/script.js', ['elementor-frontend'], VERSION, true);
        wp_register_style('hq-woocommerce-product-add-to-cart', PLUGIN_URL . 'assets/widgets/woocommerce/product-add-to-cart/style.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-woocommerce-product-add-to-cart';
    }

    public function get_title() {
        return __('Woo Product Add To Cart', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-product-add-to-cart';
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'cart', 'product', 'button', 'add to cart'];
    }

    public function get_script_depends() {
        return ['hq-woocommerce-product-add-to-cart'];
    }

    public function get_style_depends() {
        return ['hq-woocommerce-product-add-to-cart'];
    }

    public function disable_esc_html($safe_text, $text) {
        return $text;
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

        // Test Post Type Section
        $this->start_controls_section(
                'section_test_post_item', [
            'label' => __('Test Item', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        // Explanation
        $this->add_control(
                'test_post_item_alert', [
            'raw' => __('Test Item is used only in edit mode for better customization. On live page it will be ignored.', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
        );

        $args = [
            'post_type' => 'product'
        ];
        // Test Post Item
        $this->add_control('test_post_item', [
            'label' => __('Test Item', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'label_block' => true,
            'default' => [],
            'options' => Utils::get_posts($args),
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_options', [
            'label' => __('Options', 'hq-widgets-for-elementor'),
        ]);

        $this->add_responsive_control('alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'flex-end' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .woocommerce-variation-add-to-cart ' => 'justify-content: {{VALUE}}',
                '{{WRAPPER}} form.grouped_form ' => 'align-items: {{VALUE}}',
                '{{WRAPPER}} form:not(.grouped_form):not(.variations_form) ' => 'justify-content: {{VALUE}}',
            ],
            'condition' => [
                'button_stretch!' => 'yes',
            ],
        ]);

        $this->add_control('show_quantity', [
            'label' => __('Show Quantity', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_off' => __('No', 'hq-widgets-for-elementor'),
            'label_on' => __('Yes', 'hq-widgets-for-elementor'),
            'default' => 'yes'
        ]);

        $this->add_control('quantity', [
            'label' => __('Quantity', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 1,
            'condition' => [
                'show_quantity!' => 'yes',
            ],
        ]);

        $this->add_control('show_view_cart', [
            'label' => __('Show View Cart Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'show-view-cart-',
            'label_off' => __('No', 'hq-widgets-for-elementor'),
            'label_on' => __('Yes', 'hq-widgets-for-elementor'),
            'default' => 'yes',
            'description' => __('View cart button is available only if AJAX add to cart behaviour is enabled.', 'hq-widgets-for-elementor'),
            'condition' => [
                'show_quantity!' => 'yes',
            ],
        ]);

        $this->end_controls_section();

        parent::_register_controls();

        $this->update_controls();

        $this->start_controls_section('section_qty_form', [
            'label' => __('Quantity Controls', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                /*
                  'condition' => [
                  'show_quantity' => 'yes'
                  ]
                 */
        ]);

        $this->add_control('heading_qty_input', [
            'label' => __('Input', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'qty_input_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .quantity input',
        ]);
        /*
          $this->add_control('qty_input_text_color', [
          'label' => __('Text Color', 'hq-widgets-for-elementor'),
          'type' => Controls_Manager::COLOR,
          'selectors' => [
          '{{WRAPPER}} .quantity input' => 'color: {{VALUE}}',
          ],
          ]);

          $this->add_control('qty_input_background_color', [
          'label' => __('Background Color', 'hq-widgets-for-elementor'),
          'type' => Controls_Manager::COLOR,
          'selectors' => [
          '{{WRAPPER}} .quantity input' => 'background-color: {{VALUE}}',
          ],
          ]);
         */
        $this->add_responsive_control('qty_input_size', [
            'label' => __('Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 40,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .quantity input' => 'width: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('qty_input_size_height', [
            'label' => __('Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 30,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .quantity input' => 'height: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->start_controls_tabs('qty_input_tabs');

        $this->start_controls_tab('qty_input_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'qty_input_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .quantity input',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'qty_input_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .quantity input, {{WRAPPER}} .quantity input:focus',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('qty_input_focus_tab', [
            'label' => __('Focus', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'qty_input_focus_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .quantity input:focus',
        ]);

        $this->add_control('qty_input_focus_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .quantity input:focus' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('qty_input_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .quantity input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before'
        ]);

        $this->add_responsive_control('qty_input_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .quantity input, {{WRAPPER}} .quantity input:focus, {{WRAPPER}} .quantity input:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('heading_qty_buttons', [
            'label' => __('Plus and Minus Buttons', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'qty_buttons_typo',
            'selector' => '{{WRAPPER}} .quantity .qty-button',
        ]);

        $this->add_responsive_control('qty_buttons_size', [
            'label' => __('Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 30,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .quantity .qty-button' => 'width: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('qty_buttons_size_height', [
            'label' => __('Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 30,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .quantity .qty-button' => 'height: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('qty_buttons_gap', [
            'label' => __('Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .quantity .qty-button.minus' => 'margin-right: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .quantity .qty-button.plus' => 'margin-left: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->start_controls_tabs('qty_buttons_tabs');

        $this->start_controls_tab('qty_buttons_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('qty_buttons_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .quantity .qty-button' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('qty_buttons_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .quantity .qty-button' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'qty_buttons_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .quantity .qty-button',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('qty_buttons_hover_tab', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('qty_buttons_text_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .quantity .qty-button:hover' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('qty_buttons_background_hover_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .quantity .qty-button:hover' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('qty_buttons_border_hover_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .quantity .qty-button:hover' => 'border-color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('qty_buttons_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .quantity .qty-button.minus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .quantity .qty-button.plus' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} ;',
            ],
            'separator' => 'before'
        ]);

        $this->end_controls_section();
        
        $this->start_controls_section('variation_control_style', [
            'label' => __('Variation Control', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'variation_control_typography',
            'selector' => '{{WRAPPER}} .variations_form .variations select',
        ]);

        $this->start_controls_tabs('variation_control_tabs');

        $this->start_controls_tab('variation_control_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('variation_control_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .variations_form .variations select' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('variation_control_background', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .variations_form .variations select' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'variation_control_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .variations_form .variations select',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'variation_control_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .variations_form .variations select',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('variation_control_focus_tab', [
            'label' => __('Focus', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('variation_control_focus_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .variations_form .variations select:focus' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'variation_control_focus_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .variations_form .variations select:focus',
        ]);

        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_responsive_control('variation_control_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .variations_form .variations select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]);

        $this->add_responsive_control('variation_control_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .variations_form .variations select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('variation_control_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .variations_form .variations select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
                'section_variations', [
            'label' => __('Variation Details', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control('heading_variations_price', [
            'label' => __('Price', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);

        $this->add_responsive_control(
                'variations_price_align',
                [
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
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-variation-price' => 'text-align: {{VALUE}}'
                    ],
                ]
        );

        $this->start_controls_tabs('variations_price_tabs');

        $this->start_controls_tab('variations_price_tab_regular', [
            'label' => __('Regular', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'variations_price_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .woocommerce-variation-price .price',
        ]);

        $this->add_control('variations_price_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .woocommerce-variation-price .price' => 'color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('variations_price_tab_sale', [
            'label' => __('Sale', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'variations_price_sale_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .woocommerce-variation-price .price ins',
        ]);

        $this->add_control('variations_price_sale_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .woocommerce-variation-price .price ins' => 'color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('variations_price_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .woocommerce-variation-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before'
        ]);
        $this->add_responsive_control('variations_price_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .woocommerce-variation-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'variations_price_border',
            'selector' => '{{WRAPPER}} .woocommerce-variation-price',
                ]
        );

        $this->add_control('heading_variations_reset', [
            'label' => __('Reset Variations', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'variations_reset_typography',
            'selector' => '{{WRAPPER}} .variations .reset_variations',
                ]
        );

        $this->add_control('variations_reset_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .variations .reset_variations' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('variations_reset_gap', [
            'label' => __('Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 15
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .variations .reset_variations' => 'margin-top: {{SIZE}}{{UNIT}}',
            ],
        ]);
        
        $this->add_control('heading_add_variation_msg', [
            'label' => __('Notification Messages', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'add_variation_msg_typography',
            'selector' => '{{WRAPPER}} .single_add_variation_message',
                ]
        );

        $this->add_control('add_variation_msg_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .single_add_variation_message' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_view_cart_button', [
            'label' => __('View Cart Button', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_view_cart' => 'yes',
                'show_quantity!' => 'yes'
            ]
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'view_cart_typography',
            'selector' => '{{WRAPPER}} a.added_to_cart',
                ]
        );

        $this->start_controls_tabs('tabs_view_cart_button_style');

        $this->start_controls_tab(
                'tab_view_cart_button_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'view_cart_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'view_cart_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'view_cart_border',
            'selector' => '{{WRAPPER}} a.added_to_cart',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_view_cart_button_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'view_cart_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart:hover, {{WRAPPER}} a.added_to_cart:focus' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'view_cart_background_hover_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart:hover, {{WRAPPER}} a.added_to_cart:focus' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'view_cart_hover_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart:hover, {{WRAPPER}} a.added_to_cart:focus' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();



        $this->add_control(
                'view_cart_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'view_cart_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} a.added_to_cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            Utils::editor_alert_box('WooCommerce plugin is missing.');
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
        setup_postdata($product->get_id());

        // Add filters
        add_filter('woocommerce_dropdown_variation_attribute_options_args', [$this, 'woocommerce_dropdown_variation_attribute_options_args']);

        Utils::editor_start_woocommerce_section();
        if ('yes' === $settings['show_quantity'] || in_array($product->get_type(), ['variable', 'grouped'])) {
            $this->render_form_button($product);
        } else {
            $this->render_ajax_button($product);
        }
        Utils::editor_end_woocommerce_section();

        // Restore filters
        remove_filter('woocommerce_dropdown_variation_attribute_options_args', [$this, 'woocommerce_dropdown_variation_attribute_options_args']);
    }

    protected function _content_template() {
        
    }

    protected function render_ajax_button($product) {
        $settings = $this->get_settings_for_display();
        $product_type = $product->get_type();

        $class = implode(' ', array_filter([
            'product_type_' . $product_type,
            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
            $product->supports('ajax_add_to_cart') ? 'ajax_add_to_cart' : '',
        ]));

        $this->add_render_attribute('button', [
            'rel' => 'nofollow',
            'href' => $product->add_to_cart_url(),
            'data-quantity' => ( isset($settings['quantity']) ? $settings['quantity'] : 1 ),
            'data-product_id' => $product->get_id(),
            'class' => $class,
                ]
        );

        parent::render();
    }

    protected function render_form_button($product) {
        $settings = $this->get_settings_for_display();
        if (!$product && current_user_can('manage_options')) {
            _e('Please set a product', 'hq-widgets-for-elementor');
            return;
        }

        $text_callback = function() {
            ob_start();

            $this->render_text();

            return ob_get_clean();
        };

        // Add filters
        add_filter('woocommerce_get_stock_html', '__return_empty_string');
        add_filter('woocommerce_product_single_add_to_cart_text', $text_callback);
        add_filter('esc_html', [$this, 'disable_esc_html'], 10, 2);

        ob_start();
        woocommerce_template_single_add_to_cart();
        $form = ob_get_clean();
        $form = str_replace('single_add_to_cart_button button alt', 'single_add_to_cart_button button elementor-button', $form);
        echo $form;

        // Restore filters
        remove_filter('woocommerce_product_single_add_to_cart_text', $text_callback);
        remove_filter('woocommerce_get_stock_html', '__return_empty_string');
        remove_filter('esc_html', [$this, 'disable_esc_html']);
    }

    public function woocommerce_dropdown_variation_attribute_options_args($args) {
        // Find the name of the attribute for the slug we passed in to the function
        $attribute_label = wc_attribute_label($args['attribute']);

        // Create a string for our select
        $args['show_option_none'] = __('Select ' . $attribute_label, 'hq-widgets-for-elementor');

        // Send the $select_text variable back to our calling function
        return $args;
    }

    private function update_controls() {
        $this->remove_control('button_type');
        $this->remove_responsive_control('align');
        $this->remove_control('size');
        $this->remove_control('link');

        $this->start_injection([
            'at' => 'before',
            'of' => 'text',
        ]);

        $this->add_control('button_stretch', [
            'label' => __('Stretch', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'no',
            'prefix_class' => 'stretch-add-to-cart-button-',
        ]);

        $this->add_control('button_gap', [
            'label' => __('Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 15
            ],
            'selectors' => [
                '{{WRAPPER}} form.cart .quantity + .elementor-button' => 'margin-left: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} form.grouped_form .elementor-button' => 'margin-top: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->end_injection();

        $this->update_control('text', [
            'default' => __('Add to Cart', 'hq-widgets-for-elementor'),
            'placeholder' => __('Add to Cart', 'hq-widgets-for-elementor'),
        ]);

        $this->update_control('icon', [
            'default' => 'fa fa-shopping-cart',
        ]);

        $buttonSelector = '{{WRAPPER}} form.cart button.elementor-button.button';
        $buttonSelectorHover = '{{WRAPPER}} form.cart button.elementor-button.button:hover, {{WRAPPER}} form.cart button.elementor-button.button:focus';

        $controls_manager = Plugin::$instance->controls_manager;
        $typographyGroup = $controls_manager->get_control_groups('typography');
        foreach ($typographyGroup->get_fields() as $field_key => $field) {
            $control_id = "typography_{$field_key}";
            $old_control_data = $controls_manager->get_control_from_stack($this->get_unique_name(), $control_id);
            $responsive_controls_keys = ['font_size', 'line_height'];
            if (isset($old_control_data['selector_value'])) {
                if (in_array($field_key, $responsive_controls_keys)) {
                    $this->update_responsive_control($control_id, [
                        'selectors' => [
                            $buttonSelector => $old_control_data['selector_value'],
                        ]
                    ]);
                } else {
                    $this->update_control($control_id, [
                        'selectors' => [
                            $buttonSelector => $old_control_data['selector_value'],
                        ]
                    ]);
                }
            } else {
                if (in_array($field_key, $responsive_controls_keys)) {
                    $this->update_responsive_control($control_id, [
                        'selectors' => [
                            $buttonSelector => str_replace('_', '-', $field_key) . ': {{VALUE}}',
                        ]
                    ]);
                } else {
                    $this->update_control($control_id, [
                        'selectors' => [
                            $buttonSelector => str_replace('_', '-', $field_key) . ': {{VALUE}}',
                        ]
                    ]);
                }
            }
        }

        $this->update_control('button_text_color', [
            'selectors' => [$buttonSelector => 'fill: {{VALUE}}; color: {{VALUE}};'],
        ]);

        $this->update_control('background_color', [
            'selectors' => [$buttonSelector => 'background-color: {{VALUE}};'],
        ]);

        $this->update_control('hover_color', [
            'selectors' => [
                $buttonSelectorHover => 'color: {{VALUE}};',
            ],
        ]);

        $this->update_control('button_background_hover_color', [
            'selectors' => [$buttonSelectorHover => 'background-color: {{VALUE}};'],
        ]);

        $this->update_control('button_hover_border_color', [
            'selectors' => [$buttonSelectorHover => 'border-color: {{VALUE}};'],
        ]);

        $this->update_control('button_hover_border_color', [
            'selectors' => [$buttonSelectorHover => 'border-color: {{VALUE}};'],
        ]);

        $this->update_control('border_radius', [
            'selectors' => [$buttonSelector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->update_control('button_box_shadow', [
            'selector' => $buttonSelector,
        ]);

        $this->update_responsive_control('text_padding', [
            'selectors' => [$buttonSelector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);
    }

}
